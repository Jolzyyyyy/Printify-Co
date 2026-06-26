<x-app-layout>
@php
    $statusFor = function (\App\Models\User $invite): string {
        if ($invite->invite_cancelled_at) return 'cancelled';
        if ($invite->invitation_accepted_at) return 'accepted';
        if ($invite->invite_token && $invite->invite_expires_at && $invite->invite_expires_at->isPast()) return 'expired';
        if ($invite->invite_token) return 'pending';
        return 'failed';
    };
@endphp

<style>
    .inv-page{padding:34px 56px 52px;background:#f8fafc;color:#111827;font-family:'Inter',system-ui,sans-serif}
    .inv-head{display:flex;justify-content:space-between;gap:18px;align-items:flex-start;margin-bottom:18px}
    .inv-title{margin:0;font:900 28px 'Poppins',system-ui,sans-serif;color:#111827}
    .inv-sub{margin:6px 0 0;color:#64748b;font-size:13px;font-weight:600}
    .inv-card{border:1px solid #d8dee8;border-radius:8px;background:#fff;padding:16px;margin-bottom:14px;box-shadow:0 8px 22px -16px rgba(15,23,42,.2)}
    .inv-card h2{margin:0 0 12px;font:900 14px 'Poppins',system-ui,sans-serif;color:#111827}
    .inv-filter{display:grid;grid-template-columns:1.2fr .75fr .75fr .65fr .65fr 110px;gap:8px;align-items:center}
    .inv-control,.inv-btn{height:38px;border:1px solid #d8dee8;border-radius:8px;background:#fff;color:#111827;display:flex;align-items:center;gap:8px;padding:0 10px;font-size:12px;font-weight:800}
    .inv-control input,.inv-control select{width:100%;border:0;background:transparent;outline:0;font:inherit;color:inherit}
    .inv-btn{justify-content:center;text-decoration:none;cursor:pointer}.inv-btn.primary{background:#ff7a00;border-color:#ff7a00}.inv-btn.blue{background:#2563eb;border-color:#2563eb;color:#fff}.inv-btn.danger{border-color:#fecaca;color:#dc2626}.inv-btn.success{border-color:#bbf7d0;color:#16a34a}
    .inv-form{display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:8px;align-items:center}
    .inv-table-wrap{overflow:auto;border:1px solid #e8edf5;border-radius:8px}
    .inv-table{width:100%;min-width:1120px;border-collapse:collapse}
    .inv-table th{height:34px;background:#fbfcfe;border-bottom:1px solid #e8edf5;text-align:left;padding:0 10px;font-size:10px;text-transform:uppercase;color:#475569}
    .inv-table td{height:46px;border-bottom:1px solid #eef2f7;padding:0 10px;font-size:12px;color:#111827;vertical-align:middle}
    .inv-status{display:inline-flex;border-radius:999px;padding:4px 9px;font-size:10px;font-weight:900;text-transform:uppercase}
    .inv-status.pending{background:#fff7ed;color:#c2410c}.inv-status.accepted{background:#dcfce7;color:#166534}.inv-status.expired{background:#f1f5f9;color:#475569}.inv-status.cancelled,.inv-status.failed{background:#fee2e2;color:#991b1b}
    .inv-actions{display:flex;gap:6px;flex-wrap:wrap}.inv-actions form{display:inline-flex}.inv-muted{color:#94a3b8;font-weight:700}.inv-counts{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px}.inv-pill{border:1px solid #d8dee8;border-radius:999px;background:#fff;padding:7px 11px;font-size:11px;font-weight:900;color:#475569;text-decoration:none}
    @media(max-width:1100px){.inv-filter,.inv-form{grid-template-columns:1fr 1fr}.inv-page{padding:24px 18px 40px}}
    @media(max-width:700px){.inv-head{display:grid}.inv-filter,.inv-form{grid-template-columns:1fr}}
</style>

<main class="inv-page">
    <header class="inv-head">
        <div>
            <h1 class="inv-title">Admin-Client Invitations</h1>
            <p class="inv-sub">Manage business owner onboarding, invitation status, approvals, and audit-ready invitation history.</p>
        </div>
        <a class="inv-btn" href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
    </header>

    @if(session('success'))<div class="inv-card">{{ session('success') }}</div>@endif
    @if(session('warning'))<div class="inv-card">{{ session('warning') }}</div>@endif
    @if(session('invite_url'))<div class="inv-card"><strong>Invite Link:</strong> <span class="inv-muted">{{ session('invite_url') }}</span></div>@endif
    @if($errors->any())<div class="inv-card">{{ $errors->first() }}</div>@endif

    <section class="inv-card">
        <h2>Send Invitation</h2>
        <form class="inv-form" method="POST" action="{{ route('developer.invitations.store') }}">
            @csrf
            <label class="inv-control"><input name="name" placeholder="Invitee name" required></label>
            <label class="inv-control"><input name="email" type="email" placeholder="Email address" required></label>
            <label class="inv-control"><select name="business_id"><option value="">Select existing business</option>@foreach($businesses as $business)<option value="{{ $business->id }}">{{ $business->name }}</option>@endforeach</select></label>
            <label class="inv-control"><input name="business_name" placeholder="Or new business name"></label>
            <button class="inv-btn primary" type="submit">Send</button>
        </form>
    </section>

    <section class="inv-card">
        <h2>Filters</h2>
        <div class="inv-counts">
            @foreach(['pending','accepted','expired','cancelled','failed'] as $status)
                <a class="inv-pill" href="{{ route('developer.invitations.index', ['status' => $status]) }}">{{ ucfirst($status) }} {{ number_format($statusCounts[$status] ?? 0) }}</a>
            @endforeach
        </div>
        <form class="inv-filter" method="GET" action="{{ route('developer.invitations.index') }}">
            <label class="inv-control"><input name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search name, email, business"></label>
            <label class="inv-control"><select name="status"><option value="">All statuses</option>@foreach(['pending','accepted','expired','cancelled','failed'] as $status)<option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>@endforeach</select></label>
            <label class="inv-control"><select name="business_id"><option value="">All businesses</option>@foreach($businesses as $business)<option value="{{ $business->id }}" @selected(($filters['business_id'] ?? null) === $business->id)>{{ $business->name }}</option>@endforeach</select></label>
            <label class="inv-control"><input name="date_from" value="{{ optional($filters['date_from'] ?? null)->format('Y-m-d') }}" type="date"></label>
            <label class="inv-control"><input name="date_to" value="{{ optional($filters['date_to'] ?? null)->format('Y-m-d') }}" type="date"></label>
            <button class="inv-btn blue" type="submit">Apply</button>
        </form>
    </section>

    <section class="inv-card">
        <h2>Invitation Records</h2>
        <div class="inv-table-wrap">
            <table class="inv-table">
                <thead><tr><th>Invitee</th><th>Email</th><th>Business</th><th>Role</th><th>Status</th><th>Invited By</th><th>Sent</th><th>Expires</th><th>Accepted</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse($invitations as $invite)
                    @php($status = $statusFor($invite))
                    <tr>
                        <td><strong>{{ $invite->name }}</strong></td>
                        <td>{{ $invite->email }}</td>
                        <td>{{ $invite->business?->name ?: $invite->ownedBusiness?->name ?: $invite->adminClientProfile?->business_name ?: 'Unassigned' }}</td>
                        <td>Admin Client</td>
                        <td><span class="inv-status {{ $status }}">{{ ucfirst($status) }}</span></td>
                        <td>{{ optional(\App\Models\User::find($invite->preregistered_by))->name ?: 'Developer' }}</td>
                        <td>{{ optional($invite->created_at)->format('M d, Y') }}</td>
                        <td>{{ optional($invite->invite_expires_at)->format('M d, Y') ?: 'Not active' }}</td>
                        <td>{{ optional($invite->invitation_accepted_at)->format('M d, Y') ?: '-' }}</td>
                        <td>
                            <div class="inv-actions">
                                <a class="inv-btn" href="{{ route('developer.invitations.show', $invite) }}">View</a>
                                @if($status !== 'accepted')
                                    <form method="POST" action="{{ route('developer.invitations.resend', $invite) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="inv-btn success" type="submit">Resend</button>
                                    </form>
                                @endif
                                @if(in_array($status, ['pending','expired','failed'], true))
                                    <form method="POST" action="{{ route('developer.invitations.cancel', $invite) }}" onsubmit="return confirm('Cancel this invitation?');">
                                        @csrf
                                        @method('PATCH')
                                        <button class="inv-btn danger" type="submit">Cancel</button>
                                    </form>
                                @endif
                                @if($invite->hasAcceptedInvitation() && !$invite->approved_at)
                                    <form method="POST" action="{{ route('developer.admin-clients.approve', $invite) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="inv-btn primary" type="submit">Approve</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10">No invitations match the selected filters.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:12px">{{ $invitations->links() }}</div>
    </section>
</main>
</x-app-layout>
