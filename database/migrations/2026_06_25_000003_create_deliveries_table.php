<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id')->nullable()->index();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->string('courier')->nullable();
            $table->string('delivery_method')->nullable();
            $table->string('tracking_reference')->nullable()->index();
            $table->string('tracking_url')->nullable();
            $table->text('delivery_address')->nullable();
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->string('status')->default('pending')->index();
            $table->timestamp('booked_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        $this->backfillDeliveries();
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }

    private function backfillDeliveries(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        DB::table('orders')
            ->where(function ($query) {
                $query->whereNotNull('delivery_method')
                    ->orWhereNotNull('delivery_address')
                    ->orWhereNotNull('delivery_booking_status')
                    ->orWhereNotNull('lalamove_status')
                    ->orWhereNotNull('delivery_tracking_number')
                    ->orWhereNotNull('lalamove_order_id');
            })
            ->orderBy('id')
            ->chunkById(100, function ($orders) {
                foreach ($orders as $order) {
                    DB::table('deliveries')->updateOrInsert(
                        ['order_id' => $order->id],
                        [
                            'business_id' => $order->business_id ?? null,
                            'customer_id' => $order->user_id ?? null,
                            'courier' => ($order->delivery_method ?? null) === 'lalamove' ? 'lalamove' : null,
                            'delivery_method' => $order->delivery_method ?? 'standard',
                            'tracking_reference' => $order->delivery_tracking_number ?: ($order->lalamove_order_id ?? null),
                            'tracking_url' => $order->delivery_tracking_url ?: ($order->lalamove_share_link ?? null),
                            'delivery_address' => $order->delivery_address ?? null,
                            'delivery_fee' => round((float) ($order->delivery_fee ?? 0), 2),
                            'status' => $this->statusFromOrder($order),
                            'booked_at' => $order->delivery_booked_at ?? null,
                            'delivered_at' => $this->isDeliveredStatus($order) ? ($order->updated_at ?? now()) : null,
                            'remarks' => $order->delivery_notes ?? null,
                            'created_at' => $order->created_at ?? now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            });
    }

    private function statusFromOrder(object $order): string
    {
        $status = strtolower((string) (($order->delivery_booking_status ?? null) ?: ($order->lalamove_status ?? null)));

        return match (true) {
            $status === '' => 'pending',
            str_contains($status, 'delivered') => 'delivered',
            str_contains($status, 'failed'), str_contains($status, 'rejected') => 'failed',
            str_contains($status, 'cancelled'), str_contains($status, 'canceled') => 'cancelled',
            default => ($order->delivery_booking_status ?? null) ?: ($order->lalamove_status ?? null) ?: 'pending',
        };
    }

    private function isDeliveredStatus(object $order): bool
    {
        return str_contains(strtolower((string) (($order->delivery_booking_status ?? null) ?: ($order->lalamove_status ?? null))), 'delivered');
    }
};
