<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users') || Schema::hasColumn('users', 'invite_cancelled_at')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('invite_cancelled_at')->nullable()->after('invitation_accepted_at')->index();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'invite_cancelled_at')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['invite_cancelled_at']);
            $table->dropColumn('invite_cancelled_at');
        });
    }
};
