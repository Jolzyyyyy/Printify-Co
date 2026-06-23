<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('e_receipt_requests', function (Blueprint $table) {
            $table->string('uploaded_receipt_path')->nullable()->after('status');
            $table->string('uploaded_receipt_name')->nullable()->after('uploaded_receipt_path');
            $table->timestamp('uploaded_receipt_at')->nullable()->after('uploaded_receipt_name');
        });
    }

    public function down(): void
    {
        Schema::table('e_receipt_requests', function (Blueprint $table) {
            $table->dropColumn(['uploaded_receipt_path', 'uploaded_receipt_name', 'uploaded_receipt_at']);
        });
    }
};
