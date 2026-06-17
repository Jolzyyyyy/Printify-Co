<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'order_reference')) {
                $table->string('order_reference')->nullable()->unique()->after('id');
            }

            if (!Schema::hasColumn('orders', 'customer_phone')) {
                $table->string('customer_phone')->nullable()->after('customer_email');
            }

            if (!Schema::hasColumn('orders', 'checkout_details')) {
                $table->json('checkout_details')->nullable()->after('total_price');
            }

            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('checkout_details');
            }

            if (!Schema::hasColumn('orders', 'payment_provider')) {
                $table->string('payment_provider')->nullable()->after('payment_method');
            }

            if (!Schema::hasColumn('orders', 'payment_checkout_id')) {
                $table->string('payment_checkout_id')->nullable()->index()->after('payment_provider');
            }

            if (!Schema::hasColumn('orders', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('payment_checkout_id');
            }

            if (!Schema::hasColumn('orders', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_reference');
            }

            if (!Schema::hasColumn('orders', 'receipt_number')) {
                $table->string('receipt_number')->nullable()->after('paid_at');
            }

            if (!Schema::hasColumn('orders', 'receipt_sent_at')) {
                $table->timestamp('receipt_sent_at')->nullable()->after('receipt_number');
            }

            if (!Schema::hasColumn('orders', 'delivery_method')) {
                $table->string('delivery_method')->nullable()->after('receipt_sent_at');
            }

            if (!Schema::hasColumn('orders', 'delivery_address')) {
                $table->text('delivery_address')->nullable()->after('delivery_method');
            }

            if (!Schema::hasColumn('orders', 'delivery_booking_status')) {
                $table->string('delivery_booking_status')->nullable()->after('delivery_address');
            }

            if (!Schema::hasColumn('orders', 'delivery_tracking_number')) {
                $table->string('delivery_tracking_number')->nullable()->after('delivery_booking_status');
            }

            if (!Schema::hasColumn('orders', 'delivery_tracking_url')) {
                $table->string('delivery_tracking_url')->nullable()->after('delivery_tracking_number');
            }

            if (!Schema::hasColumn('orders', 'delivery_booked_at')) {
                $table->timestamp('delivery_booked_at')->nullable()->after('delivery_tracking_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'order_reference',
                'customer_phone',
                'checkout_details',
                'payment_method',
                'payment_provider',
                'payment_checkout_id',
                'payment_reference',
                'paid_at',
                'receipt_number',
                'receipt_sent_at',
                'delivery_method',
                'delivery_address',
                'delivery_booking_status',
                'delivery_tracking_number',
                'delivery_tracking_url',
                'delivery_booked_at',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
