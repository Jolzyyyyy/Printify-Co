<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('business_id')->nullable()->index();
                $table->unsignedBigInteger('order_id')->index();
                $table->unsignedBigInteger('customer_id')->nullable()->index();
                $table->string('payment_method');
                $table->string('payment_gateway')->nullable();
                $table->string('gateway_checkout_id')->nullable()->index();
                $table->string('gateway_reference')->nullable()->index();
                $table->decimal('amount', 12, 2)->default(0);
                $table->string('status')->default('pending')->index();
                $table->unsignedBigInteger('verified_by')->nullable()->index();
                $table->timestamp('paid_at')->nullable();
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }

        $this->backfillPayments();
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }

    private function backfillPayments(): void
    {
        if (!Schema::hasTable('orders') || !Schema::hasTable('payments')) {
            return;
        }

        DB::table('orders')
            ->orderBy('id')
            ->get()
            ->each(function ($order): void {
                if (DB::table('payments')->where('order_id', $order->id)->exists()) {
                    return;
                }

                DB::table('payments')->insert([
                    'business_id' => $order->business_id ?? null,
                    'order_id' => $order->id,
                    'customer_id' => $order->user_id ?? null,
                    'payment_method' => $order->payment_method ?: 'manual',
                    'payment_gateway' => $order->payment_provider ?: null,
                    'gateway_checkout_id' => $order->payment_checkout_id ?: null,
                    'gateway_reference' => $order->payment_reference ?: null,
                    'amount' => round((float) ($order->total_price ?? 0), 2),
                    'status' => $this->paymentStatusFromOrder($order),
                    'verified_by' => null,
                    'paid_at' => $order->paid_at ?: null,
                    'remarks' => 'Backfilled from existing order payment fields.',
                    'created_at' => $order->created_at ?: now(),
                    'updated_at' => now(),
                ]);
            });
    }

    private function paymentStatusFromOrder(object $order): string
    {
        $status = strtolower((string) ($order->status ?? ''));

        if ($order->paid_at || in_array($status, ['paid', 'completed'], true)) {
            return 'paid';
        }

        if (in_array($status, ['failed', 'payment_failed'], true)) {
            return 'failed';
        }

        if (in_array($status, ['refunded'], true)) {
            return 'refunded';
        }

        if (in_array($status, ['discrepancy'], true)) {
            return 'discrepancy';
        }

        if (in_array($status, ['cancelled', 'canceled'], true)) {
            return 'cancelled';
        }

        return 'pending';
    }
};
