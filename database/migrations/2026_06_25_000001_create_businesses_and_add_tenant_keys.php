<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('businesses')) {
            Schema::create('businesses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->foreignId('owner_user_id')->nullable()->index();
                $table->string('status')->default('active')->index();
                $table->string('email')->nullable();
                $table->string('contact_number')->nullable();
                $table->text('address')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        $this->addBusinessId('users', 'admin_client_id');
        $this->addBusinessId('orders', 'admin_client_id');
        $this->addBusinessId('services', 'is_active');
        $this->addBusinessId('audit_logs', 'target_user_id');

        $this->backfillBusinesses();
    }

    public function down(): void
    {
        $this->dropBusinessId('audit_logs');
        $this->dropBusinessId('services');
        $this->dropBusinessId('orders');
        $this->dropBusinessId('users');

        Schema::dropIfExists('businesses');
    }

    private function addBusinessId(string $table, ?string $after = null): void
    {
        if (!Schema::hasTable($table) || Schema::hasColumn($table, 'business_id')) {
            return;
        }

        Schema::table($table, function (Blueprint $tableBlueprint) use ($after) {
            $column = $tableBlueprint->unsignedBigInteger('business_id')->nullable()->index();

            if ($after) {
                $column->after($after);
            }
        });
    }

    private function dropBusinessId(string $table): void
    {
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'business_id')) {
            return;
        }

        Schema::table($table, function (Blueprint $tableBlueprint) {
            $tableBlueprint->dropIndex(['business_id']);
            $tableBlueprint->dropColumn('business_id');
        });
    }

    private function backfillBusinesses(): void
    {
        if (!Schema::hasTable('businesses')) {
            return;
        }

        DB::table('users')
            ->where('role', User::ROLE_ADMIN_CLIENT)
            ->orderBy('id')
            ->get()
            ->each(function ($adminClient): void {
                $profile = Schema::hasTable('admin_client_profiles')
                    ? DB::table('admin_client_profiles')->where('user_id', $adminClient->id)->first()
                    : null;

                $businessName = $profile?->business_name
                    ?: $adminClient->company
                    ?: $adminClient->name
                    ?: 'Business ' . $adminClient->id;

                $businessId = $adminClient->business_id
                    ?: DB::table('businesses')->where('owner_user_id', $adminClient->id)->value('id');

                if (!$businessId) {
                    $businessId = DB::table('businesses')->insertGetId([
                        'name' => $businessName,
                        'slug' => $this->uniqueBusinessSlug($businessName, (int) $adminClient->id),
                        'owner_user_id' => $adminClient->id,
                        'status' => $adminClient->approved_at ? 'active' : ($adminClient->invitation_accepted_at ? 'suspended' : 'inactive'),
                        'email' => $adminClient->email,
                        'contact_number' => $profile?->contact_number ?? $adminClient->phone ?? null,
                        'address' => $profile?->business_address ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('users')
                    ->where('id', $adminClient->id)
                    ->update(['business_id' => $businessId]);

                DB::table('users')
                    ->where('admin_client_id', $adminClient->id)
                    ->whereNull('business_id')
                    ->update(['business_id' => $businessId]);

                if (Schema::hasTable('orders')) {
                    DB::table('orders')
                        ->where('admin_client_id', $adminClient->id)
                        ->whereNull('business_id')
                        ->update(['business_id' => $businessId]);

                    $customerIds = DB::table('users')
                        ->where('admin_client_id', $adminClient->id)
                        ->pluck('id');

                    if ($customerIds->isNotEmpty()) {
                        DB::table('orders')
                            ->whereIn('user_id', $customerIds)
                            ->whereNull('business_id')
                            ->update(['business_id' => $businessId]);
                    }
                }
            });

        $defaultBusinessId = DB::table('businesses')->orderBy('id')->value('id');

        if ($defaultBusinessId) {
            DB::table('services')
                ->whereNull('business_id')
                ->update(['business_id' => $defaultBusinessId]);
        }

        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')
                ->whereNull('business_id')
                ->orderBy('id')
                ->get(['id', 'actor_id', 'target_user_id'])
                ->each(function ($log): void {
                    $businessId = null;

                    if ($log->actor_id) {
                        $businessId = DB::table('users')->where('id', $log->actor_id)->value('business_id');
                    }

                    if (!$businessId && $log->target_user_id) {
                        $businessId = DB::table('users')->where('id', $log->target_user_id)->value('business_id');
                    }

                    if ($businessId) {
                        DB::table('audit_logs')->where('id', $log->id)->update(['business_id' => $businessId]);
                    }
                });
        }
    }

    private function uniqueBusinessSlug(string $name, int $adminClientId): string
    {
        $base = Str::slug($name) ?: 'business-' . $adminClientId;
        $slug = $base;
        $counter = 2;

        while (DB::table('businesses')->where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
};
