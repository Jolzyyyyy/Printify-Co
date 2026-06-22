<?php

namespace App\Services;

use App\Models\Order;

class DeliveryBookingService
{
    public function __construct(private readonly LalamoveClient $lalamove)
    {
    }

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
            if (!config('services.lalamove.api_key') || !config('services.lalamove.api_secret')) {
                $order->forceFill([
                    'delivery_booking_status' => 'pending_lalamove_configuration',
                    'lalamove_status' => 'PENDING_CONFIGURATION',
                ])->save();

                return;
            }

            if (!$order->delivery_latitude || !$order->delivery_longitude) {
                $order->forceFill([
                    'delivery_booking_status' => 'pending_lalamove_coordinates',
                    'lalamove_status' => 'PENDING_COORDINATES',
                ])->save();

                return;
            }

            try {
                $quotation = $this->lalamove->quotation([
                    'address' => $order->delivery_address,
                    'lat' => $order->delivery_latitude,
                    'lng' => $order->delivery_longitude,
                ], ['quantity' => max(1, (int) $order->items()->sum('quantity'))]);

                $shipment = $this->lalamove->placeOrder($quotation, [
                    'name' => $order->customer_name,
                    'phone' => $order->customer_phone,
                    'remarks' => $order->delivery_notes ?: 'Printify & Co. order ' . ($order->order_reference ?: str_pad((string) $order->id, 6, '0', STR_PAD_LEFT)),
                ]);

                $order->forceFill([
                    'delivery_booking_status' => 'booked_lalamove',
                    'delivery_tracking_number' => data_get($shipment, 'data.orderId'),
                    'delivery_tracking_url' => data_get($shipment, 'data.shareLink'),
                    'delivery_booked_at' => now(),
                    'lalamove_quotation_id' => data_get($quotation, 'data.quotationId'),
                    'lalamove_order_id' => data_get($shipment, 'data.orderId'),
                    'lalamove_status' => data_get($shipment, 'data.status'),
                    'lalamove_driver_id' => data_get($shipment, 'data.driverId') ?: null,
                    'lalamove_share_link' => data_get($shipment, 'data.shareLink'),
                    'lalamove_last_synced_at' => now(),
                ])->save();

                return;
            } catch (\Throwable $exception) {
                report($exception);

                $order->forceFill([
                    'delivery_booking_status' => 'lalamove_booking_failed',
                    'lalamove_status' => 'BOOKING_FAILED',
                ])->save();

                return;
            }

        }

        $order->forceFill([
            'delivery_booking_status' => 'pending_manual_booking',
        ])->save();
    }
}
