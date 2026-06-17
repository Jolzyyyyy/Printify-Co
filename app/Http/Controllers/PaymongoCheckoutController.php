<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Rules\PhilippineMobileNumber;
use App\Services\CheckoutOrderFactory;
use App\Services\CheckoutReceiptService;
use App\Services\DeliveryBookingService;
use App\Services\PhilippinePhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymongoCheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        return redirect('/checkout');
    }

    public function pay(Request $request)
    {
        $this->validatedCheckoutRequest($request);

        try {
            $checkoutUrl = $this->createCheckoutUrl($request);
        } catch (\Throwable $exception) {
            report($exception);

            return back()->with('error', $exception->getMessage());
        }

        return redirect()->away($checkoutUrl);
    }

    public function start(Request $request)
    {
        $this->validatedCheckoutRequest($request);

        try {
            return response()->json([
                'ok' => true,
                'redirect_url' => $this->createCheckoutUrl($request),
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'ok' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    private function createCheckoutUrl(Request $request): string
    {
        $checkoutDetails = $this->validatedCheckoutRequest($request);
        session()->put('checkout_details', $checkoutDetails['checkout']);

        $cartItems = $this->getCheckoutItems();

        if (empty($cartItems)) {
            throw new \RuntimeException('No items found for checkout. Please add items first.');
        }

        $cartTotal = $this->computeTotal($cartItems);
        $amountInCentavos = (int) round($cartTotal * 100);

        if ($amountInCentavos < 1) {
            throw new \RuntimeException('Invalid checkout total. Please try again.');
        }

        $paymentProvider = in_array($request->payment_method, ['paymaya', 'maya'], true) ? 'maya' : 'paymongo';
        $order = app(CheckoutOrderFactory::class)->createFromCheckout(
            $request,
            $checkoutDetails['checkout'],
            $cartItems,
            $cartTotal,
            (string) $request->payment_method,
            $paymentProvider
        );

        session()->put('pending_order_id', $order->id);

        if (in_array($request->payment_method, ['paymaya', 'maya'], true)) {
            return $this->createMayaCheckoutUrl($request, $cartItems, $cartTotal, $order);
        }

        $lineItems = collect($cartItems)->map(function ($item) {
            $name = $item['name'] ?? 'Item';
            $qty  = (int) ($item['qty'] ?? 1);
            $price = (float) ($item['price'] ?? 0);

            return [
                'name' => $name,
                'quantity' => max(1, $qty),
                'amount' => (int) round($price * 100), // unit price centavos
                'currency' => 'PHP',
            ];
        })->values()->all();

        $secretKey = trim((string) config('services.paymongo.secret_key'));
        if (!$secretKey) {
            throw new \RuntimeException('PAYMONGO_SECRET_KEY is missing in .env');
        }

        $successUrl = url('/payment/success?ref=' . urlencode((string) $order->order_reference));
        $cancelUrl  = url('/payment/cancel?ref=' . urlencode((string) $order->order_reference));

        $response = Http::withBasicAuth($secretKey, '')
            ->timeout(30)
            ->acceptJson()
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'send_email_receipt' => false,
                        'show_description' => true,
                        'show_line_items' => true,
                        'line_items' => $lineItems,
                        'payment_method_types' => $this->mapPaymentMethodTypes($request->payment_method),
                        'description' => 'Printify & Co. order ' . $order->order_reference,
                        'success_url' => $successUrl,
                        'cancel_url' => $cancelUrl,
                        'amount' => $amountInCentavos,
                        'currency' => 'PHP',
                    ],
                ],
            ]);

        if (!$response->successful()) {
            $order->forceFill(['status' => 'payment_setup_failed'])->save();
            throw new \RuntimeException('PayMongo error: ' . $response->body());
        }

        $body = $response->json();
        app(CheckoutOrderFactory::class)->attachCheckoutProviderId($order, data_get($body, 'data.id'));

        $checkoutUrl = data_get($body, 'data.attributes.checkout_url');
        if (!$checkoutUrl) {
            $order->forceFill(['status' => 'payment_setup_failed'])->save();
            throw new \RuntimeException('No checkout_url returned by PayMongo.');
        }

        return $checkoutUrl;
    }

    public function success(Request $request)
    {
        session()->forget('buy_now');
        session()->forget('cart');
        session()->forget('pending_order_id');

        return redirect('/checkout?payment=success&ref=' . urlencode((string) $request->query('ref', '')));
    }

    public function cancel(Request $request)
    {
        return redirect('/checkout?payment=cancel&ref=' . urlencode((string) $request->query('ref', '')));
    }

    public function webhook(
        Request $request,
        CheckoutReceiptService $receiptService,
        DeliveryBookingService $deliveryBookingService
    ) {
        if (!$this->hasValidPaymongoSignature($request)) {
            return response()->json([
                'ok' => false,
                'message' => 'Invalid webhook signature.',
            ], 401);
        }

        $payload = $request->all();
        $eventType = (string) data_get($payload, 'data.attributes.type', data_get($payload, 'type', ''));

        if ($eventType !== 'checkout_session.payment.paid') {
            return response()->json(['ok' => true, 'ignored' => true]);
        }

        $checkoutSession = data_get($payload, 'data.attributes.data', []);
        $checkoutId = (string) data_get($checkoutSession, 'id');

        $order = Order::where('payment_checkout_id', $checkoutId)->first();
        if (!$order) {
            return response()->json([
                'ok' => false,
                'message' => 'Order not found for checkout session.',
            ], 404);
        }

        $paymentReference = data_get($checkoutSession, 'attributes.payments.0.id')
            ?: data_get($checkoutSession, 'attributes.payment_intent.id')
            ?: data_get($payload, 'data.id');

        $order->forceFill([
            'status' => 'paid',
            'payment_reference' => $paymentReference,
            'paid_at' => $order->paid_at ?: now(),
        ])->save();

        try {
            $receiptService->send($order->fresh('items') ?? $order);
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $deliveryBookingService->book($order->fresh() ?? $order);
        } catch (\Throwable $exception) {
            report($exception);
        }

        return response()->json(['ok' => true]);
    }

    private function hasValidPaymongoSignature(Request $request): bool
    {
        $secret = trim((string) config('services.paymongo.webhook_secret'));
        if ($secret === '') {
            return true;
        }

        $header = (string) $request->header('Paymongo-Signature', '');
        if ($header === '') {
            return false;
        }

        $parts = collect(explode(',', $header))
            ->mapWithKeys(function (string $part) {
                [$key, $value] = array_pad(explode('=', trim($part), 2), 2, '');

                return [$key => $value];
            });

        $timestamp = (string) $parts->get('t', '');
        $candidateSignatures = collect([
            $parts->get('te'),
            $parts->get('li'),
        ])->filter()->values();

        if ($timestamp === '' || $candidateSignatures->isEmpty()) {
            return false;
        }

        $expected = hash_hmac('sha256', $timestamp . '.' . $request->getContent(), $secret);

        return $candidateSignatures->contains(
            fn (string $signature) => hash_equals($expected, $signature)
        );
    }

    private function mapPaymentMethodTypes(string $method): array
    {
        return match ($method) {
            'gcash' => ['gcash'],
            'card' => ['card'],
            'grab_pay' => ['grab_pay'],
            'paymaya', 'maya' => ['paymaya'],
            'bank' => ['dob'],
            default => ['gcash'],
        };
    }

    private function createMayaCheckoutUrl(Request $request, array $cartItems, float $cartTotal, Order $order): string
    {
        $publicKey = trim((string) config('services.maya.public_key'));
        $checkoutUrl = trim((string) config('services.maya.checkout_url'));

        if (!$publicKey) {
            throw new \RuntimeException('MAYA_PUBLIC_KEY is missing in .env');
        }
        if (!$checkoutUrl) {
            throw new \RuntimeException('MAYA_CHECKOUT_URL is missing in .env');
        }

        $reference = (string) $order->order_reference;
        $items = collect($cartItems)->map(function ($item, $index) {
            $name = (string) ($item['name'] ?? 'Print Item');
            $qty = max(1, (int) ($item['qty'] ?? 1));
            $price = round((float) ($item['price'] ?? 0), 2);

            return [
                'name' => Str::limit($name, 120, ''),
                'code' => 'ITEM-' . ($index + 1),
                'description' => Str::limit($name, 255, ''),
                'quantity' => $qty,
                'amount' => [
                    'value' => $price,
                    'currency' => 'PHP',
                ],
                'totalAmount' => [
                    'value' => round($price * $qty, 2),
                    'currency' => 'PHP',
                ],
            ];
        })->values()->all();

        $user = $request->user();
        $checkout = $this->validatedCheckoutRequest($request)['checkout'];
        $nameParts = preg_split('/\s+/', trim((string) ($user?->name ?: 'Printify Customer'))) ?: [];
        $firstName = Str::limit((string) data_get($checkout, 'customer.firstName', $nameParts[0] ?? 'Printify'), 60, '');
        $lastName = Str::limit((string) data_get($checkout, 'customer.lastName', count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : 'Customer'), 60, '');
        $payload = [
            'totalAmount' => [
                'value' => round($cartTotal, 2),
                'currency' => 'PHP',
            ],
            'buyer' => [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'contact' => [
                    'email' => data_get($checkout, 'customer.email', $user?->email ?: 'customer@printify.local'),
                    'phone' => data_get($checkout, 'customer.phone'),
                ],
            ],
            'items' => $items,
            'requestReferenceNumber' => $reference,
            'redirectUrl' => [
                'success' => url('/payment/success?ref=' . urlencode($reference)),
                'failure' => url('/payment/cancel?ref=' . urlencode($reference)),
                'cancel' => url('/payment/cancel?ref=' . urlencode($reference)),
            ],
        ];

        $response = Http::withBasicAuth($publicKey, '')
            ->timeout(30)
            ->acceptJson()
            ->asJson()
            ->post($checkoutUrl, $payload);

        if (!$response->successful()) {
            $order->forceFill(['status' => 'payment_setup_failed'])->save();
            throw new \RuntimeException('Maya checkout error: ' . $response->body());
        }

        $body = $response->json();
        app(CheckoutOrderFactory::class)->attachCheckoutProviderId(
            $order,
            data_get($body, 'checkoutId') ?: data_get($body, 'id') ?: data_get($body, 'data.id')
        );

        $redirectUrl = data_get($body, 'redirectUrl')
            ?: data_get($body, 'checkoutUrl')
            ?: data_get($body, 'data.redirectUrl');

        if (!$redirectUrl) {
            $order->forceFill(['status' => 'payment_setup_failed'])->save();
            throw new \RuntimeException('No redirect URL returned by Maya.');
        }

        return $redirectUrl;
    }

    /**
     * ✅ Reads the correct session keys (BUY NOW first, then CART)
     */
    private function getCheckoutItems(): array
    {
        // Priority: buy_now > cart
        $items = session('buy_now');
        if (!empty($items) && is_array($items)) {
            return $this->normalizeItemsFromCartStructure($items);
        }

        $items = session('cart', []);
        if (!empty($items) && is_array($items)) {
            return $this->normalizeItemsFromCartStructure($items);
        }

        return [];
    }

    /**
     * session('cart') / session('buy_now') structure:
     * [
     *   key => ['name','price','price_type','qty',...]
     * ]
     */
    private function normalizeItemsFromCartStructure(array $items): array
    {
        return collect($items)->values()->map(function ($item) {
            return [
                'service_id' => (int) ($item['service_id'] ?? 0),
                'variation_id' => (int) ($item['variation_id'] ?? $item['service_variation_id'] ?? 0),
                'service_item_id' => $item['service_item_id'] ?? null,
                'name' => $item['name'] ?? 'Item',
                'price' => (float) ($item['price'] ?? 0),
                'qty' => (int) ($item['qty'] ?? 1),
                'category' => $item['category'] ?? null,
                'variation_label' => $item['variation_label'] ?? null,
                'price_type' => $item['price_type'] ?? 'retail',
            ];
        })->values()->all();
    }

    private function computeTotal(array $items): float
    {
        return (float) collect($items)->sum(fn ($i) => ((float) $i['price']) * ((int) $i['qty']));
    }

    private function validatedCheckoutRequest(Request $request): array
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'in:gcash,card,grab_pay,paymaya,maya,bank'],
            'checkout' => ['required', 'array'],
            'checkout.customer' => ['required', 'array'],
            'checkout.customer.firstName' => ['required', 'string', 'max:100'],
            'checkout.customer.lastName' => ['required', 'string', 'max:100'],
            'checkout.customer.email' => ['required', 'email', 'max:255'],
            'checkout.customer.phone' => ['required', 'string', 'max:40', new PhilippineMobileNumber],
            'checkout.delivery' => ['required', 'array'],
            'checkout.delivery.type' => ['required', 'string', 'in:standard,express,lalamove,pickup'],
            'checkout.delivery.name' => ['required', 'string', 'max:80'],
            'checkout.shippingAddress' => ['required_unless:checkout.delivery.type,pickup', 'array'],
            'checkout.shippingAddress.street' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:255'],
            'checkout.shippingAddress.apartment' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:255'],
            'checkout.shippingAddress.province' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:120'],
            'checkout.shippingAddress.city' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:120'],
            'checkout.shippingAddress.barangay' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:120'],
            'checkout.shippingAddress.postal' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:20'],
            'checkout.shippingAddress.country' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'in:Philippines'],
        ], [], [
            'checkout.customer.firstName' => 'first name',
            'checkout.customer.lastName' => 'last name',
            'checkout.customer.email' => 'email address',
            'checkout.customer.phone' => 'mobile number',
            'checkout.shippingAddress.street' => 'street address',
            'checkout.shippingAddress.apartment' => 'house, unit, or landmark',
            'checkout.shippingAddress.province' => 'province',
            'checkout.shippingAddress.city' => 'city or municipality',
            'checkout.shippingAddress.barangay' => 'barangay',
            'checkout.shippingAddress.postal' => 'postal code',
        ]);

        $validated['checkout']['customer']['phone'] = PhilippinePhoneNumber::normalize(
            $validated['checkout']['customer']['phone']
        );

        return $validated;
    }
}
