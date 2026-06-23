<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('e_receipt_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('receipt_type', 20);
            $table->string('full_name', 160);
            $table->string('business_name', 180)->nullable();
            $table->string('tin', 40)->nullable();
            $table->string('region', 120);
            $table->string('province', 120);
            $table->string('city', 120);
            $table->string('barangay', 120);
            $table->string('postal_code', 20);
            $table->string('street_address');
            $table->boolean('is_default')->default(false);
            $table->string('status', 30)->default('submitted');
            $table->timestamps();
            $table->index(['user_id', 'is_default']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('e_receipt_requests');
    }
};
