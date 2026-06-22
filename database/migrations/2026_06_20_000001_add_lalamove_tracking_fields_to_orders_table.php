<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'customer_phone')) $table->string('customer_phone')->nullable()->after('customer_email');
            if (!Schema::hasColumn('orders', 'delivery_method')) $table->string('delivery_method')->default('pickup')->after('status');
            if (!Schema::hasColumn('orders', 'delivery_fee')) $table->decimal('delivery_fee', 10, 2)->default(0)->after('total_price');
            if (!Schema::hasColumn('orders', 'delivery_address')) $table->text('delivery_address')->nullable()->after('delivery_fee');
            if (!Schema::hasColumn('orders', 'delivery_latitude')) $table->decimal('delivery_latitude', 10, 7)->nullable()->after('delivery_address');
            if (!Schema::hasColumn('orders', 'delivery_longitude')) $table->decimal('delivery_longitude', 10, 7)->nullable()->after('delivery_latitude');
            if (!Schema::hasColumn('orders', 'delivery_notes')) $table->text('delivery_notes')->nullable()->after('delivery_longitude');
            if (!Schema::hasColumn('orders', 'lalamove_quotation_id')) $table->string('lalamove_quotation_id')->nullable()->index();
            if (!Schema::hasColumn('orders', 'lalamove_order_id')) $table->string('lalamove_order_id')->nullable()->index();
            if (!Schema::hasColumn('orders', 'lalamove_status')) $table->string('lalamove_status')->nullable();
            if (!Schema::hasColumn('orders', 'lalamove_driver_id')) $table->string('lalamove_driver_id')->nullable();
            if (!Schema::hasColumn('orders', 'lalamove_driver_name')) $table->string('lalamove_driver_name')->nullable();
            if (!Schema::hasColumn('orders', 'lalamove_driver_phone')) $table->string('lalamove_driver_phone')->nullable();
            if (!Schema::hasColumn('orders', 'lalamove_plate_number')) $table->string('lalamove_plate_number')->nullable();
            if (!Schema::hasColumn('orders', 'lalamove_share_link')) $table->text('lalamove_share_link')->nullable();
            if (!Schema::hasColumn('orders', 'lalamove_last_synced_at')) $table->timestamp('lalamove_last_synced_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = array_filter(['customer_phone','delivery_method','delivery_fee','delivery_address','delivery_latitude','delivery_longitude','delivery_notes','lalamove_quotation_id','lalamove_order_id','lalamove_status','lalamove_driver_id','lalamove_driver_name','lalamove_driver_phone','lalamove_plate_number','lalamove_share_link','lalamove_last_synced_at'], fn ($column) => Schema::hasColumn('orders', $column));
            if ($columns !== []) $table->dropColumn($columns);
        });
    }
};
