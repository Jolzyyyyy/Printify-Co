<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'receipt_number')) {
                $table->string('receipt_number')->nullable()->after('paid_at');
            }

            if (! Schema::hasColumn('orders', 'receipt_sent_at')) {
                $table->timestamp('receipt_sent_at')->nullable()->after('receipt_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'receipt_sent_at')) {
                $table->dropColumn('receipt_sent_at');
            }

            if (Schema::hasColumn('orders', 'receipt_number')) {
                $table->dropColumn('receipt_number');
            }
        });
    }
};
