<?php

namespace App\Services;

use App\Models\Order;

class DeliveryBookingService
{
    public function book(Order $order): void
    {
        if ($order->delivery_booked_at) {
            return;
        }

        $method = $order->delivery_method ?: data_get($order->checkout_details, 'delivery.type', 'standard');

        if ($method === 'pickup') {
            $order->forceFill([
                'delivery_booking_status' => 'not_required_pickup',
                'delivery_booked_at' => now(),
            ])->save();

            return;
        }

        if ($method === 'lalamove') {
            $order->forceFill([
                'delivery_booking_status' => config('services.lalamove.api_key')
                    ? 'ready_for_lalamove_booking'
                    : 'pending_lalamove_configuration',
            ])->save();

            return;
        }

        $order->forceFill([
            'delivery_booking_status' => 'pending_manual_booking',
        ])->save();
    }
}
