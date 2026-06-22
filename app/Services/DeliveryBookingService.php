<?php

namespace App\Services;

use App\Models\Order;

class DeliveryBookingService
{
    public function __construct(private readonly LalamoveClient $lalamove) {}

    public function book(Order $order): void
    {
        if ($order->delivery_booked_at) return;
        if ($order->delivery_method === 'pickup') {
            $order->update(['delivery_booking_status' => 'not_required_pickup', 'delivery_booked_at' => now()]);
            return;
        }
        if ($order->delivery_method !== 'lalamove') {
            $order->update(['delivery_booking_status' => 'pending_manual_booking']);
            return;
        }
        if (!config('services.lalamove.api_key') || !config('services.lalamove.api_secret')) {
            $order->update(['delivery_booking_status' => 'pending_lalamove_configuration', 'lalamove_status' => 'PENDING_CONFIGURATION']);
            return;
        }
        if (!$order->delivery_latitude || !$order->delivery_longitude) {
            $order->update(['delivery_booking_status' => 'pending_lalamove_coordinates', 'lalamove_status' => 'PENDING_COORDINATES']);
            return;
        }
        try {
            $quotation = $this->lalamove->quotation(['address' => $order->delivery_address, 'lat' => $order->delivery_latitude, 'lng' => $order->delivery_longitude], ['quantity' => max(1, (int) $order->items()->sum('quantity'))]);
            $shipment = $this->lalamove->placeOrder($quotation, ['name' => $order->customer_name, 'phone' => $order->customer_phone, 'remarks' => $order->delivery_notes ?: 'Printify & Co. order ' . ($order->order_reference ?: $order->id)]);
            $order->update([
                'delivery_booking_status' => 'booked_lalamove', 'delivery_tracking_number' => data_get($shipment, 'data.orderId'),
                'delivery_tracking_url' => data_get($shipment, 'data.shareLink'), 'delivery_booked_at' => now(),
                'lalamove_quotation_id' => data_get($quotation, 'data.quotationId'), 'lalamove_order_id' => data_get($shipment, 'data.orderId'),
                'lalamove_status' => data_get($shipment, 'data.status'), 'lalamove_driver_id' => data_get($shipment, 'data.driverId') ?: null,
                'lalamove_share_link' => data_get($shipment, 'data.shareLink'), 'lalamove_last_synced_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            report($exception);
            $order->update(['delivery_booking_status' => 'lalamove_booking_failed', 'lalamove_status' => 'BOOKING_FAILED']);
        }
    }
}
