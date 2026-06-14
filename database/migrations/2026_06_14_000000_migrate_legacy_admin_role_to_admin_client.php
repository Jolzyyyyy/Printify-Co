<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'admin_client']);
    }

    public function down(): void
    {
        // Intentionally irreversible: admin_client is the supported role.
    }
};
