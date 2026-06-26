<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('audit_logs') || Schema::hasColumn('audit_logs', 'module')) {
            return;
        }

        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('module')->nullable()->index()->after('action');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('audit_logs') || !Schema::hasColumn('audit_logs', 'module')) {
            return;
        }

        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropIndex(['module']);
            $table->dropColumn('module');
        });
    }
};
