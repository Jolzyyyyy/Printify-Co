<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\EReceiptRequest;
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
        $validated = $this->validatedCheckoutRequest($request);
        $receiptRequestId = (int) $request->session()->get('checkout_e_receipt_request_id', 0);
        $hasReceiptRequest = $receiptRequestId > 0 && EReceiptRequest::where('user_id', $request->user()->id)->whereKey($receiptRequestId)->exists();
        if (!$hasReceiptRequest) {
            throw new \RuntimeException('Complete and submit the e-invoice request before payment.');
        }
        $cartItems = $this->getCheckoutItems();

        if (empty($cartItems)) {
            throw new \RuntimeException('No items found for checkout. Please add items first.');
        }

        $subtotal = $this->computeTotal($cartItems);
        $discount = $this->computeDiscount($subtotal, (string) data_get($validated, 'checkout.promoCode', ''));
        $cartTotal = round($subtotal - $discount, 2);
        data_set($validated, 'checkout.totals', [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => 0,
            'tax' => 0,
            'total' => $cartTotal,
        ]);
        $amountInCentavos = (int) round($cartTotal * 100);

        if ($amountInCentavos < 1) {
            throw new \RuntimeException('Invalid checkout total. Please try again.');
        }

        $paymentProvider = in_array($request->payment_method, ['paymaya', 'maya'], true) ? 'maya' : 'paymongo';
        $reference = 'PFY-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));
        session()->put([
            'checkout_details' => $validated['checkout'],
            'checkout_payment_method' => (string) $request->payment_method,
            'checkout_payment_provider' => $paymentProvider,
            'checkout_payment_reference' => $reference,
            'checkout_payment_total' => $cartTotal,
            'checkout_payment_verified' => false,
        ]);

        if (in_array($request->payment_method, ['paymaya', 'maya'], true)) {
            return $this->createMayaCheckoutUrl($request, $cartItems, $cartTotal, $reference);
        }

        $lineItems = [[
            'name' => 'Printify & Co. Order',
            'quantity' => 1,
            'amount' => $amountInCentavos,
            'currency' => 'PHP',
        ]];

        $secretKey = trim((string) config('services.paymongo.secret_key'));
        if (!$secretKey) {
            throw new \RuntimeException('PAYMONGO_SECRET_KEY is missing in .env');
        }

        $successUrl = url('/payment/success?ref=' . urlencode($reference));
        $cancelUrl  = url('/payment/cancel?ref=' . urlencode($reference));

        $response = Http::withBasicAuth($secretKey, '')
            ->timeout(30)
            ->acceptJson()
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        // PayMongo sends the successful payment receipt to the customer
                        // before they return to Checkout to select the delivery method.
                        'send_email_receipt' => true,
                        'show_description' => true,
                        'show_line_items' => true,
                        'line_items' => $lineItems,
                        'payment_method_types' => $this->mapPaymentMethodTypes($request->payment_method),
                        'description' => 'Printify & Co. payment ' . $reference,
                        'success_url' => $successUrl,
                        'cancel_url' => $cancelUrl,
                        'amount' => $amountInCentavos,
                        'currency' => 'PHP',
                    ],
                ],
            ]);

        if (!$response->successful()) {
            throw new \RuntimeException('PayMongo error: ' . $response->body());
        }

        $body = $response->json();
        session()->put('checkout_provider_id', data_get($body, 'data.id'));
        $checkoutUrl = data_get($body, 'data.attributes.checkout_url');
        if (!$checkoutUrl) {
            throw new \RuntimeException('No checkout_url returned by PayMongo.');
        }

        return $checkoutUrl;
    }

    public function success(Request $request)
    {
        $reference = (string) $request->query('ref');
        if ($reference === '' || !hash_equals((string) session('checkout_payment_reference'), $reference)) {
            return redirect('/checkout?payment=cancel')->with('error', 'Unable to verify this payment return.');
        }

        session()->put('checkout_payment_verified', true);
        return redirect('/checkout?payment=success&ref=' . urlencode($reference))
            ->with('success', 'Payment successful. Review the order and click Place Order to continue.');
    }

    public function cancel(Request $request)
    {
        session()->put('checkout_payment_verified', false);
        return redirect('/checkout?payment=cancel&ref=' . urlencode((string) $request->query('ref', '')));
    }

    public function finalize(
        Request $request,
        CheckoutOrderFactory $orders,
        DeliveryBookingService $deliveryBooking,
        CheckoutReceiptService $receipts
    )
    {
        abort_unless($request->user(), 401);
        if (session('checkout_payment_verified') !== true) {
            return response()->json(['ok' => false, 'message' => 'Complete payment before placing the order.'], 422);
        }

        $cartItems = $this->getCheckoutItems();
        $storedCheckout = (array) session('checkout_details', []);
        $submittedCheckout = (array) $request->input('checkout', []);
        if ($storedCheckout === [] || $submittedCheckout === [] || $cartItems === []) {
            return response()->json(['ok' => false, 'message' => 'Checkout details are no longer available. Please restart checkout.'], 422);
        }

        try {
            $submittedCheckout['customer'] = $storedCheckout['customer'] ?? [];
            $request->merge([
                'payment_method' => (string) session('checkout_payment_method', 'card'),
                'checkout' => $submittedCheckout,
            ]);
            $checkout = $this->validatedCheckoutRequest($request)['checkout'];
            $subtotal = $this->computeTotal($cartItems);
            $discount = $this->computeDiscount($subtotal, (string) data_get($storedCheckout, 'promoCode', ''));
            $shipping = $this->deliveryCost((string) data_get($checkout, 'delivery.type'));
            $finalTotal = round(max(0, $subtotal - $discount) + $shipping, 2);
            data_set($checkout, 'promoCode', data_get($storedCheckout, 'promoCode'));
            data_set($checkout, 'delivery.cost', $shipping);
            data_set($checkout, 'totals', [
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $shipping,
                'tax' => 0,
                'total' => $finalTotal,
            ]);
            $order = $orders->createFromCheckout(
                $request,
                $checkout,
                $cartItems,
                $finalTotal,
                (string) session('checkout_payment_method', 'card'),
                (string) session('checkout_payment_provider', 'paymongo')
            );
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
                'payment_reference' => (string) session('checkout_payment_reference'),
                'payment_checkout_id' => session('checkout_provider_id'),
            ]);
            $deliveryBooking->book($order->fresh() ?? $order);

            try {
                $receipts->send($order->fresh('items') ?? $order);
            } catch (\Throwable $receiptException) {
                // The paid order must remain valid even when mail transport is temporarily unavailable.
                report($receiptException);
            }

            session()->forget(['buy_now','cart','checkout_details','checkout_payment_method','checkout_payment_provider','checkout_payment_reference','checkout_payment_total','checkout_payment_verified','checkout_provider_id','checkout_e_receipt_request_id']);

            return response()->json(['ok' => true, 'redirect_url' => route('co.place-order')]);
        } catch (\Throwable $exception) {
            report($exception);
            return response()->json(['ok' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function webhook(
        Request $request,
        CheckoutReceiptService $receiptService,
        DeliveryBookingService $deliveryBookingService
    ) {
        if (!$this->hasValidPaymongoSignature($request)) {
            return response()->json(['ok' => false, 'message' => 'Invalid webhook signature.'], 401);
        }

        $payload = $request->all();
        $eventType = (string) data_get($payload, 'data.attributes.type', data_get($payload, 'type', ''));
        if ($eventType !== 'checkout_session.payment.paid') {
            return response()->json(['ok' => true, 'ignored' => true]);
        }

        $checkoutSession = data_get($payload, 'data.attributes.data', []);
        $checkoutId = (string) data_get($checkoutSession, 'id');
        $order = Order::where('payment_checkout_id', $checkoutId)->first();

        // In the current payment-first flow the final order can be created after this webhook arrives.
        // Acknowledge the event; finalize() records the same provider ID and sends the receipt safely.
        if (!$order) {
            return response()->json(['ok' => true, 'pending_finalization' => true], 202);
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

        $parts = collect(explode(',', $header))->mapWithKeys(function (string $part) {
            [$key, $value] = array_pad(explode('=', trim($part), 2), 2, '');
            return [$key => $value];
        });
        $timestamp = (string) $parts->get('t', '');
        $signatures = collect([$parts->get('te'), $parts->get('li')])->filter()->values();
        if ($timestamp === '' || $signatures->isEmpty()) {
            return false;
        }

        $expected = hash_hmac('sha256', $timestamp . '.' . $request->getContent(), $secret);
        return $signatures->contains(fn (string $signature) => hash_equals($expected, $signature));
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

    private function createMayaCheckoutUrl(Request $request, array $cartItems, float $cartTotal, string $reference): string
    {
        $publicKey = trim((string) config('services.maya.public_key'));
        $checkoutUrl = trim((string) config('services.maya.checkout_url'));

        if (!$publicKey) {
            throw new \RuntimeException('MAYA_PUBLIC_KEY is missing in .env');
        }
        if (!$checkoutUrl) {
            throw new \RuntimeException('MAYA_CHECKOUT_URL is missing in .env');
        }

        $items = [[
            'name' => 'Printify & Co. Order',
            'code' => 'PRINTIFY-ORDER',
            'description' => 'Printing order payment',
            'quantity' => 1,
            'amount' => ['value' => round($cartTotal, 2), 'currency' => 'PHP'],
            'totalAmount' => ['value' => round($cartTotal, 2), 'currency' => 'PHP'],
        ]];

        $user = $request->user();
        $checkout = $this->validatedCheckoutRequest($request)['checkout'];
        $firstName = Str::limit((string) data_get($checkout, 'customer.firstName', 'Printify'), 60, '');
        $lastName = Str::limit((string) data_get($checkout, 'customer.lastName', 'Customer'), 60, '');
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
            throw new \RuntimeException('Maya checkout error: ' . $response->body());
        }

        $body = $response->json();
        session()->put('checkout_provider_id', data_get($body, 'checkoutId') ?: data_get($body, 'id') ?: data_get($body, 'data.id'));
        $redirectUrl = data_get($body, 'redirectUrl')
            ?: data_get($body, 'checkoutUrl')
            ?: data_get($body, 'data.redirectUrl');

        if (!$redirectUrl) {
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
                'price' => (float) ($item['price'] ?? 0), // ✅ unit price
                'qty' => (int) ($item['qty'] ?? 1),
                'variation_label' => $item['variation_label'] ?? null,
                'price_type' => $item['price_type'] ?? 'retail',
                'category' => $item['category'] ?? null,
                'unit' => $item['unit'] ?? null,
                'image_path' => $item['image_path'] ?? null,
                'attachment_path' => $item['attachment_path'] ?? null,
                'file_name' => $item['file_name'] ?? null,
                'file_meta' => $item['file_meta'] ?? null,
            ];
        })->values()->all();
    }

    private function computeTotal(array $items): float
    {
        return (float) collect($items)->sum(fn ($i) => ((float) $i['price']) * ((int) $i['qty']));
    }

    private function computeDiscount(float $subtotal, string $promoCode): float
    {
        $discount = match (strtoupper(trim($promoCode))) {
            'SAVE10', 'DISCOUNT10' => $subtotal * 0.10,
            'PRINTIFY50' => 50,
            default => 0,
        };

        return round(min($subtotal, $discount), 2);
    }

    private function deliveryCost(string $deliveryType): float
    {
        return match ($deliveryType) {
            'standard' => 150,
            'express' => 350,
            'lalamove' => 284,
            'pickup' => 0,
            default => throw new \InvalidArgumentException('Please select a valid delivery method.'),
        };
    }

    private function validatedCheckoutRequest(Request $request): array
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'in:gcash,card,grab_pay,paymaya,maya,bank'],
            'checkout' => ['required', 'array'],
            'checkout.customer.firstName' => ['required', 'string', 'max:100'],
            'checkout.customer.lastName' => ['required', 'string', 'max:100'],
            'checkout.customer.email' => ['required', 'email', 'max:255'],
            'checkout.customer.phone' => ['required', 'string', 'max:40', new PhilippineMobileNumber],
            'checkout.delivery.type' => ['required', 'in:standard,express,lalamove,pickup'],
            'checkout.delivery.name' => ['required', 'string', 'max:80'],
            'checkout.delivery.cost' => ['nullable', 'numeric', 'min:0'],
            'checkout.delivery.quotationId' => ['nullable', 'string', 'max:120'],
            'checkout.shippingAddress' => ['nullable', 'array'],
            'checkout.shippingAddress.street' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:255'],
            'checkout.shippingAddress.apartment' => ['nullable', 'string', 'max:255'],
            'checkout.shippingAddress.province' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:120'],
            'checkout.shippingAddress.city' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:120'],
            'checkout.shippingAddress.barangay' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:120'],
            'checkout.shippingAddress.postal' => ['required_unless:checkout.delivery.type,pickup', 'nullable', 'string', 'max:20'],
            'checkout.shippingAddress.country' => ['nullable', 'string', 'max:80'],
            'checkout.shippingAddress.lat' => ['nullable', 'numeric', 'between:-90,90'],
            'checkout.shippingAddress.lng' => ['nullable', 'numeric', 'between:-180,180'],
            'checkout.notes' => ['nullable', 'string', 'max:250'],
            // Totals are recalculated from the server cart; browser values are optional display hints only.
            'checkout.totals' => ['nullable', 'array'],
            'checkout.totals.subtotal' => ['nullable', 'numeric', 'min:0'],
            'checkout.totals.discount' => ['nullable', 'numeric', 'min:0'],
            'checkout.totals.shipping' => ['nullable', 'numeric', 'min:0'],
            'checkout.totals.total' => ['nullable', 'numeric', 'min:0'],
        ]);

        data_set(
            $validated,
            'checkout.customer.phone',
            PhilippinePhoneNumber::normalize(data_get($validated, 'checkout.customer.phone'))
        );

        return $validated;
    }
}
