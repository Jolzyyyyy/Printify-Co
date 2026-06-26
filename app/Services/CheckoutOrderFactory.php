<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Delivery;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\ServiceVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CheckoutOrderFactory
{
    public function createFromCheckout(Request $request, array $checkout, array $cartItems, float $cartTotal, string $paymentMethod, string $paymentProvider): Order
    {
        return DB::transaction(function () use ($request, $checkout, $cartItems, $cartTotal, $paymentMethod, $paymentProvider) {
            $customer = $request->user();
            $deliveryType = (string) data_get($checkout, 'delivery.type', 'standard');

            $order = Order::create([
                'user_id' => $customer?->id,
                'admin_client_id' => $customer?->admin_client_id,
                'business_id' => $customer?->business_id,
                'order_reference' => $this->makeOrderReference(),
                'customer_name' => trim(data_get($checkout, 'customer.firstName') . ' ' . data_get($checkout, 'customer.lastName')),
                'customer_email' => data_get($checkout, 'customer.email'),
                'customer_phone' => data_get($checkout, 'customer.phone'),
                'status' => 'pending_payment',
                'total_price' => round($cartTotal, 2),
                'checkout_details' => $checkout,
                'payment_method' => $paymentMethod,
                'payment_provider' => $paymentProvider,
                'delivery_method' => $deliveryType,
                'delivery_fee' => round((float) data_get($checkout, 'delivery.cost', 0), 2),
                'delivery_address' => $deliveryType === 'pickup' ? null : $this->formatDeliveryAddress((array) data_get($checkout, 'shippingAddress', [])),
                'delivery_latitude' => data_get($checkout, 'shippingAddress.lat'),
                'delivery_longitude' => data_get($checkout, 'shippingAddress.lng'),
                'delivery_notes' => data_get($checkout, 'notes'),
                'lalamove_quotation_id' => data_get($checkout, 'delivery.quotationId'),
                'lalamove_status' => $deliveryType === 'lalamove' ? 'PENDING_PAYMENT' : null,
                'delivery_booking_status' => 'waiting_for_payment',
            ]);

            foreach ($cartItems as $item) {
                $this->createOrderItem($order, $item);
                $this->attachOrderFile($order, $item);
            }

            Delivery::syncFromOrder($order->fresh() ?? $order);

            return $order->fresh('items') ?? $order;
        });
    }

    public function attachCheckoutProviderId(Order $order, ?string $checkoutId): void
    {
        if ($checkoutId) $order->forceFill(['payment_checkout_id' => $checkoutId])->save();
    }

    private function createOrderItem(Order $order, array $item): void
    {
        $variation = $this->resolveVariation($item);
        $service = $variation?->service ?: Service::find((int) ($item['service_id'] ?? 0));
        $serviceCode = (string) ($item['service_item_id'] ?? 'CHECKOUT-' . Str::slug((string) ($item['name'] ?? 'print-item')));
        if (!$service) {
            $service = Service::firstOrCreate(
                ['service_item_id' => $serviceCode],
                [
                    'name' => $item['name'] ?? 'Print Item',
                    'category' => $item['category'] ?? 'Printing Service',
                    'retail_price' => ($item['price_type'] ?? 'retail') === 'retail' ? $item['price'] : 0,
                    'bulk_price' => ($item['price_type'] ?? 'retail') === 'bulk' ? $item['price'] : 0,
                    'unit' => $item['unit'] ?? 'piece',
                    'description' => 'Checkout catalog snapshot',
                    'image_path' => $item['image_path'] ?? null,
                    'is_active' => true,
                ]
            );
        }

        $quantity = max(1, (int) ($item['qty'] ?? 1));
        $unitPrice = round((float) ($item['price'] ?? 0), 2);
        OrderItem::create([
            'order_id' => $order->id,
            'service_id' => $service->id,
            'service_variation_id' => $variation?->id,
            'service_item_id' => $item['service_item_id'] ?? $variation?->service_item_id,
            'service_name' => $item['name'] ?? $service->name,
            'variation_label' => $item['variation_label'] ?? $variation?->variation_label,
            'price_type' => $item['price_type'] ?? 'retail',
            'unit_price' => $unitPrice,
            'quantity' => $quantity,
            'subtotal' => round($unitPrice * $quantity, 2),
        ]);
    }

    private function resolveVariation(array $item): ?ServiceVariation
    {
        $variationId = (int) ($item['variation_id'] ?? $item['service_variation_id'] ?? 0);
        if ($variationId > 0 && ($variation = ServiceVariation::with('service')->find($variationId))) return $variation;
        $serviceItemId = $item['service_item_id'] ?? null;
        return $serviceItemId ? ServiceVariation::with('service')->where('service_item_id', $serviceItemId)->first() : null;
    }

    private function attachOrderFile(Order $order, array $item): void
    {
        $source = $item['attachment_path'] ?? null;
        if (!$source || !Storage::disk('local')->exists($source)) return;

        $original = basename((string) ($item['file_name'] ?? $source));
        $target = 'order-files/' . $order->id . '/' . Str::uuid() . '-' . $original;
        Storage::disk('public')->put($target, Storage::disk('local')->get($source));
        $meta = (array) ($item['file_meta'] ?? []);
        $order->files()->create([
            'original_name' => $original,
            'path' => $target,
            'mime' => $meta['type'] ?? null,
            'size' => $meta['size'] ?? Storage::disk('public')->size($target),
        ]);
    }

    private function makeOrderReference(): string
    {
        do $reference = 'PFY-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        while (Order::where('order_reference', $reference)->exists());
        return $reference;
    }

    private function formatDeliveryAddress(array $address): string
    {
        return collect([$address['street'] ?? null, $address['apartment'] ?? null, $address['barangay'] ?? null, $address['city'] ?? null, $address['province'] ?? null, $address['postal'] ?? null, $address['country'] ?? null])->filter(fn ($part) => filled($part))->implode(', ');
    }
}
