<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Business;
use App\Models\User;
use App\Notifications\AdminClientInvitation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DeveloperInvitationController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $this->filters($request);
        $invitations = $this->invitationQuery($filters)
            ->with(['business', 'ownedBusiness', 'adminClientProfile'])
            ->latest('updated_at')
            ->paginate(15)
            ->withQueryString();

        $businesses = Business::query()->orderBy('name')->get(['id', 'name']);
        $statusCounts = User::query()
            ->where('role', User::ROLE_ADMIN_CLIENT)
            ->whereNotNull('preregistered_by')
            ->get()
            ->groupBy(fn (User $user) => $this->invitationStatus($user))
            ->map->count();

        return view('Admin.invitations.index', [
            'filters' => $filters,
            'invitations' => $invitations,
            'businesses' => $businesses,
            'statusCounts' => $statusCounts,
        ]);
    }

    public function show(User $user): View
    {
        abort_unless($user->isAdminClient(), 404);

        $user->load(['business', 'ownedBusiness', 'adminClientProfile']);
        $auditLogs = AuditLog::query()
            ->with(['actor', 'targetUser'])
            ->where('target_user_id', $user->id)
            ->where(function (Builder $query) {
                $query->where('module', 'invitation')
                    ->orWhereIn('action', [
                        'admin_client_invitation_sent',
                        'admin_client_invitation_resent',
                        'admin_client_invitation_cancelled',
                        'admin_client_invite_accepted',
                    ]);
            })
            ->latest()
            ->limit(15)
            ->get();

        return view('Admin.invitations.show', [
            'invitation' => $user,
            'status' => $this->invitationStatus($user),
            'auditLogs' => $auditLogs,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'business_id' => ['nullable', 'integer', 'exists:businesses,id'],
            'business_name' => ['nullable', 'string', 'max:255'],
        ]);

        $plainToken = Str::random(64);
        $business = $this->resolveBusiness($validated, null);

        $adminClient = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make(Str::random(64)),
            'role' => User::ROLE_ADMIN_CLIENT,
            'business_id' => $business?->id,
            'preregistered_by' => $request->user()->id,
            'approved_at' => null,
            'approved_by' => null,
            'invite_token' => hash('sha256', $plainToken),
            'invite_expires_at' => now()->addDays(7),
            'invite_cancelled_at' => null,
        ]);

        if ($business && !$business->owner_user_id) {
            $business->forceFill(['owner_user_id' => $adminClient->id])->save();
        }

        $inviteUrl = route('admin-client-invitations.show', $plainToken);
        $this->recordInvitationAudit($request, $adminClient, 'admin_client_invitation_sent', [], [
            'email' => $adminClient->email,
            'business_id' => $business?->id,
            'invite_expires_at' => optional($adminClient->invite_expires_at)->toDateTimeString(),
        ]);

        $redirect = redirect()
            ->route('developer.invitations.index')
            ->with('success', 'Admin-client invitation sent.')
            ->with('invite_url', $inviteUrl);

        try {
            $adminClient->notify(new AdminClientInvitation($inviteUrl));
        } catch (\Throwable $exception) {
            Log::error('Admin client invitation email failed for ' . $adminClient->email . ': ' . $exception->getMessage());
            $this->recordInvitationAudit($request, $adminClient, 'admin_client_invitation_failed', [], [
                'email' => $adminClient->email,
                'error' => $exception->getMessage(),
            ]);

            return $redirect->with('warning', 'The invitation was created, but email delivery failed. Use the setup link shown below.');
        }

        return $redirect;
    }

    public function resend(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isAdminClient(), 404);

        if ($user->hasAcceptedInvitation()) {
            return redirect()
                ->route('developer.invitations.index')
                ->withErrors(['invitation' => 'Accepted invitations cannot be resent.']);
        }

        $oldValues = $user->only(['invite_token', 'invite_expires_at', 'invite_cancelled_at']);
        $plainToken = Str::random(64);

        $user->forceFill([
            'invite_token' => hash('sha256', $plainToken),
            'invite_expires_at' => now()->addDays(7),
            'invite_cancelled_at' => null,
        ])->save();

        $inviteUrl = route('admin-client-invitations.show', $plainToken);
        $this->recordInvitationAudit($request, $user, 'admin_client_invitation_resent', $oldValues, [
            'invite_expires_at' => optional($user->invite_expires_at)->toDateTimeString(),
        ]);

        try {
            $user->notify(new AdminClientInvitation($inviteUrl));
        } catch (\Throwable $exception) {
            Log::error('Admin client invitation resend failed for ' . $user->email . ': ' . $exception->getMessage());
            $this->recordInvitationAudit($request, $user, 'admin_client_invitation_failed', [], [
                'email' => $user->email,
                'error' => $exception->getMessage(),
            ]);

            return redirect()
                ->route('developer.invitations.index')
                ->with('warning', 'Invitation regenerated, but email delivery failed.')
                ->with('invite_url', $inviteUrl);
        }

        return redirect()
            ->route('developer.invitations.index')
            ->with('success', 'Invitation resent.')
            ->with('invite_url', $inviteUrl);
    }

    public function cancel(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isAdminClient(), 404);

        if ($user->hasAcceptedInvitation()) {
            return redirect()
                ->route('developer.invitations.index')
                ->withErrors(['invitation' => 'Accepted invitations cannot be cancelled.']);
        }

        $oldValues = $user->only(['invite_token', 'invite_expires_at', 'invite_cancelled_at']);

        $user->forceFill([
            'invite_token' => null,
            'invite_expires_at' => null,
            'invite_cancelled_at' => now(),
        ])->save();

        $this->recordInvitationAudit($request, $user, 'admin_client_invitation_cancelled', $oldValues, [
            'invite_cancelled_at' => optional($user->invite_cancelled_at)->toDateTimeString(),
        ]);

        return redirect()
            ->route('developer.invitations.index')
            ->with('success', 'Invitation cancelled.');
    }

    private function invitationQuery(array $filters): Builder
    {
        return User::query()
            ->where('role', User::ROLE_ADMIN_CLIENT)
            ->whereNotNull('preregistered_by')
            ->when($filters['business_id'], function (Builder $query, int $businessId) {
                $query->where(function (Builder $scope) use ($businessId) {
                    $scope->where('business_id', $businessId)
                        ->orWhereHas('ownedBusiness', fn (Builder $business) => $business->whereKey($businessId));
                });
            })
            ->when($filters['search'], function (Builder $query, string $search) {
                $query->where(function (Builder $scope) use ($search) {
                    $scope->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('business', fn (Builder $business) => $business->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('ownedBusiness', fn (Builder $business) => $business->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('adminClientProfile', fn (Builder $profile) => $profile->where('business_name', 'like', "%{$search}%"));
                });
            })
            ->when($filters['date_from'], fn (Builder $query, $date) => $query->where('created_at', '>=', $date))
            ->when($filters['date_to'], fn (Builder $query, $date) => $query->where('created_at', '<=', $date))
            ->when($filters['status'], function (Builder $query, string $status) {
                match ($status) {
                    'pending' => $query->whereNull('invitation_accepted_at')->whereNull('invite_cancelled_at')->whereNotNull('invite_token')->where(function (Builder $scope) {
                        $scope->whereNull('invite_expires_at')->orWhere('invite_expires_at', '>', now());
                    }),
                    'accepted' => $query->whereNotNull('invitation_accepted_at'),
                    'expired' => $query->whereNull('invitation_accepted_at')->whereNull('invite_cancelled_at')->whereNotNull('invite_token')->where('invite_expires_at', '<=', now()),
                    'cancelled' => $query->whereNotNull('invite_cancelled_at'),
                    'failed' => $query->whereHas('auditLogsAsTarget', fn (Builder $logs) => $logs->where('action', 'admin_client_invitation_failed')),
                    default => null,
                };
            });
    }

    private function filters(Request $request): array
    {
        return [
            'search' => trim((string) $request->query('search', '')) ?: null,
            'status' => in_array($request->query('status'), ['pending', 'accepted', 'expired', 'cancelled', 'failed'], true) ? $request->query('status') : null,
            'business_id' => $request->integer('business_id') ?: null,
            'date_from' => $request->date('date_from')?->startOfDay(),
            'date_to' => $request->date('date_to')?->endOfDay(),
        ];
    }

    private function invitationStatus(User $user): string
    {
        if ($user->invite_cancelled_at) {
            return 'cancelled';
        }

        if ($user->invitation_accepted_at) {
            return 'accepted';
        }

        if ($user->invite_token && $user->invite_expires_at && $user->invite_expires_at->isPast()) {
            return 'expired';
        }

        if ($user->invite_token) {
            return 'pending';
        }

        return 'failed';
    }

    private function resolveBusiness(array $validated, ?User $adminClient): ?Business
    {
        if (!empty($validated['business_id'])) {
            return Business::find((int) $validated['business_id']);
        }

        $businessName = trim((string) ($validated['business_name'] ?? ''));
        if ($businessName === '') {
            return null;
        }

        return Business::firstOrCreate(
            ['slug' => $this->uniqueBusinessSlug($businessName, $adminClient?->id ?? random_int(1000, 9999))],
            [
                'name' => $businessName,
                'status' => Business::STATUS_INACTIVE,
            ]
        );
    }

    private function uniqueBusinessSlug(string $name, int $seed): string
    {
        $base = Str::slug($name) ?: 'business-' . $seed;
        $slug = $base;
        $counter = 2;

        while (Business::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function recordInvitationAudit(Request $request, User $adminClient, string $action, array $oldValues, array $newValues): void
    {
        AuditLog::create([
            'actor_id' => $request->user()?->id,
            'target_user_id' => $adminClient->id,
            'business_id' => $adminClient->business_id,
            'auditable_type' => User::class,
            'auditable_id' => $adminClient->id,
            'action' => $action,
            'module' => 'invitation',
            'old_values' => $oldValues ?: null,
            'new_values' => $newValues ?: null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
