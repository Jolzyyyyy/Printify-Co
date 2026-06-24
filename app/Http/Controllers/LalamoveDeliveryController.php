<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\LalamoveClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LalamoveDeliveryController extends Controller
{
    public function quote(Request $request, LalamoveClient $lalamove): JsonResponse
    {
        $validated = $request->validate([
            'address' => ['required', 'string', 'max:500'],
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
        ]);

        try {
            $quotation = $lalamove->quotation($validated, [
                'quantity' => $validated['quantity'] ?? 1,
            ]);

            session(['lalamove_quotation' => $quotation]);

            return response()->json([
                'ok' => true,
                'quotation_id' => data_get($quotation, 'data.quotationId'),
                'amount' => (float) data_get($quotation, 'data.priceBreakdown.total', 0),
                'currency' => data_get($quotation, 'data.priceBreakdown.currency', 'PHP'),
                'distance_meters' => (int) data_get($quotation, 'data.distance.value', 0),
                'expires_at' => data_get($quotation, 'data.expiresAt'),
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'ok' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function refresh(Request $request, Order $order, LalamoveClient $lalamove): JsonResponse|RedirectResponse
    {
        abort_unless($order->isVisibleToPortalUser($request->user()) || (int) $order->user_id === (int) $request->user()->id, 403);

        if (!$order->lalamove_order_id) {
            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'This order has no Lalamove delivery yet.',
                ], 422);
            }

            return back()->with('error', 'This order has no Lalamove delivery yet.');
        }

        try {
            $details = $lalamove->order($order->lalamove_order_id);
            $driverId = (string) data_get($details, 'data.driverId', '');
            $driver = [];

            if ($driverId !== '') {
                try {
                    $driver = $lalamove->driver($order->lalamove_order_id, $driverId);
                } catch (\Throwable) {
                    $driver = [];
                }
            }

            $order->update([
                'lalamove_status' => data_get($details, 'data.status'),
                'lalamove_driver_id' => $driverId ?: null,
                'lalamove_driver_name' => data_get($driver, 'data.name'),
                'lalamove_driver_phone' => data_get($driver, 'data.phone'),
                'lalamove_plate_number' => data_get($driver, 'data.plateNumber'),
                'lalamove_share_link' => data_get($details, 'data.shareLink') ?: $order->lalamove_share_link,
                'delivery_tracking_url' => data_get($details, 'data.shareLink') ?: $order->delivery_tracking_url,
                'lalamove_last_synced_at' => now(),
            ]);

            if ($request->expectsJson()) {
                $order->refresh();

                return response()->json([
                    'ok' => true,
                    'message' => 'Lalamove tracking updated.',
                    'status' => $order->status,
                    'delivery_status' => $order->delivery_status,
                    'delivery_booking_status' => $order->delivery_booking_status,
                    'lalamove_status' => $order->lalamove_status,
                    'tracking_url' => $order->delivery_tracking_url ?: $order->lalamove_share_link,
                    'lalamove_last_synced_at' => optional($order->lalamove_last_synced_at)->toIso8601String(),
                    'lalamove_last_synced_at_formatted' => optional($order->lalamove_last_synced_at)->format('M d, h:i A'),
                    'driver_name' => $order->lalamove_driver_name,
                    'driver_phone' => $order->lalamove_driver_phone,
                    'plate_number' => $order->lalamove_plate_number,
                ]);
            }

            return back()->with('success', 'Lalamove tracking updated.');
        } catch (\Throwable $exception) {
            report($exception);
            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => false,
                    'message' => $exception->getMessage(),
                ], 422);
            }

            return back()->with('error', $exception->getMessage());
        }
    }

    public function book(Request $request, Order $order, LalamoveClient $lalamove): RedirectResponse
    {
        abort_unless($order->isVisibleToPortalUser($request->user()) || (int) $order->user_id === (int) $request->user()->id, 403);

        if ($order->delivery_method !== 'lalamove') {
            return back()->with('error', 'This order is not set for Lalamove delivery.');
        }

        if ($order->lalamove_order_id) {
            return back()->with('error', 'This order is already booked with Lalamove.');
        }

        if (!$order->delivery_latitude || !$order->delivery_longitude) {
            $order->update([
                'delivery_booking_status' => 'pending_lalamove_coordinates',
                'lalamove_status' => 'PENDING_COORDINATES',
            ]);

            return back()->with('error', 'Lalamove booking needs drop-off map coordinates for this order.');
        }

        try {
            $quotation = $lalamove->quotation([
                'address' => $order->delivery_address,
                'lat' => $order->delivery_latitude,
                'lng' => $order->delivery_longitude,
            ], ['quantity' => max(1, (int) $order->items()->sum('quantity'))]);

            $shipment = $lalamove->placeOrder($quotation, [
                'name' => $order->customer_name,
                'phone' => $this->normalizePhone($order->customer_phone),
                'remarks' => $order->delivery_notes ?: 'Printify & Co. order ' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
            ]);

            $order->update([
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
            ]);

            return back()->with('success', 'Lalamove booking created.');
        } catch (\Throwable $exception) {
            report($exception);
            $order->update([
                'delivery_booking_status' => 'lalamove_booking_failed',
                'lalamove_status' => 'BOOKING_FAILED',
            ]);

            return back()->with('error', $exception->getMessage());
        }
    }

    private function normalizePhone(?string $phone): string
    {
        $value = preg_replace('/[^0-9+]/', '', (string) $phone);

        if (str_starts_with($value, '09')) {
            return '+63' . substr($value, 1);
        }

        if (preg_match('/^9\d{9}$/', $value)) {
            return '+63' . $value;
        }

        return $value;
    }
}
