<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'order_reference')) $table->string('order_reference')->nullable()->unique();
            if (!Schema::hasColumn('orders', 'checkout_details')) $table->json('checkout_details')->nullable();
            if (!Schema::hasColumn('orders', 'payment_method')) $table->string('payment_method')->nullable();
            if (!Schema::hasColumn('orders', 'payment_provider')) $table->string('payment_provider')->nullable();
            if (!Schema::hasColumn('orders', 'payment_checkout_id')) $table->string('payment_checkout_id')->nullable()->index();
            if (!Schema::hasColumn('orders', 'payment_reference')) $table->string('payment_reference')->nullable();
            if (!Schema::hasColumn('orders', 'paid_at')) $table->timestamp('paid_at')->nullable();
            if (!Schema::hasColumn('orders', 'delivery_booking_status')) $table->string('delivery_booking_status')->nullable();
            if (!Schema::hasColumn('orders', 'delivery_tracking_number')) $table->string('delivery_tracking_number')->nullable();
            if (!Schema::hasColumn('orders', 'delivery_tracking_url')) $table->text('delivery_tracking_url')->nullable();
            if (!Schema::hasColumn('orders', 'delivery_booked_at')) $table->timestamp('delivery_booked_at')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = array_filter(['order_reference','checkout_details','payment_method','payment_provider','payment_checkout_id','payment_reference','paid_at','delivery_booking_status','delivery_tracking_number','delivery_tracking_url','delivery_booked_at'], fn ($column) => Schema::hasColumn('orders', $column));
            if ($columns !== []) $table->dropColumn($columns);
        });
    }
};
