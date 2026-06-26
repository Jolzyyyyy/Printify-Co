<x-app-layout>
<style>
    .iv-page{padding:34px 56px 52px;background:#f8fafc;color:#111827;font-family:'Inter',system-ui,sans-serif}
    .iv-head{display:flex;justify-content:space-between;gap:18px;align-items:flex-start;margin-bottom:18px}
    .iv-title{margin:0;font:900 28px 'Poppins',system-ui,sans-serif;color:#111827}.iv-sub{margin:6px 0 0;color:#64748b;font-size:13px;font-weight:600}
    .iv-card{border:1px solid #d8dee8;border-radius:8px;background:#fff;padding:16px;margin-bottom:14px;box-shadow:0 8px 22px -16px rgba(15,23,42,.2)}
    .iv-card h2{margin:0 0 12px;font:900 14px 'Poppins',system-ui,sans-serif;color:#111827}
    .iv-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}.iv-dl{display:grid;grid-template-columns:150px 1fr;gap:10px 14px;margin:0;font-size:12px}.iv-dl dt{font-weight:900;color:#64748b}.iv-dl dd{margin:0;font-weight:700}
    .iv-btn{height:38px;border:1px solid #d8dee8;border-radius:8px;background:#fff;color:#111827;display:inline-flex;align-items:center;gap:8px;padding:0 13px;font-size:12px;font-weight:900;text-decoration:none;cursor:pointer}.iv-btn.primary{background:#ff7a00;border-color:#ff7a00}.iv-btn.danger{border-color:#fecaca;color:#dc2626}.iv-btn.success{border-color:#bbf7d0;color:#16a34a}
    .iv-actions{display:flex;gap:8px;flex-wrap:wrap}.iv-status{display:inline-flex;border-radius:999px;padding:5px 11px;font-size:10px;font-weight:900;text-transform:uppercase}.iv-status.pending{background:#fff7ed;color:#c2410c}.iv-status.accepted{background:#dcfce7;color:#166534}.iv-status.expired{background:#f1f5f9;color:#475569}.iv-status.cancelled,.iv-status.failed{background:#fee2e2;color:#991b1b}
    .iv-table{width:100%;border-collapse:collapse}.iv-table th{height:34px;background:#fbfcfe;border-bottom:1px solid #e8edf5;text-align:left;padding:0 10px;font-size:10px;text-transform:uppercase;color:#475569}.iv-table td{height:42px;border-bottom:1px solid #eef2f7;padding:0 10px;font-size:12px}
    @media(max-width:900px){.iv-page{padding:24px 18px 40px}.iv-head,.iv-grid{display:grid}.iv-dl{grid-template-columns:1fr}}
</style>

<main class="iv-page">
    <header class="iv-head">
        <div>
            <h1 class="iv-title">{{ $invitation->name }}</h1>
            <p class="iv-sub">{{ $invitation->email }} · Admin Client invitation</p>
            <span class="iv-status {{ $status }}">{{ ucfirst($status) }}</span>
        </div>
        <div class="iv-actions">
            <a class="iv-btn" href="{{ route('developer.invitations.index') }}">Back to Invitations</a>
            @if($status !== 'accepted')
                <form method="POST" action="{{ route('developer.invitations.resend', $invitation) }}">@csrf @method('PATCH')<button class="iv-btn success" type="submit">Resend</button></form>
            @endif
            @if(in_array($status, ['pending','expired','failed'], true))
                <form method="POST" action="{{ route('developer.invitations.cancel', $invitation) }}" onsubmit="return confirm('Cancel this invitation?');">@csrf @method('PATCH')<button class="iv-btn danger" type="submit">Cancel</button></form>
            @endif
            @if($invitation->hasAcceptedInvitation() && !$invitation->approved_at)
                <form method="POST" action="{{ route('developer.admin-clients.approve', $invitation) }}">@csrf @method('PATCH')<button class="iv-btn primary" type="submit">Approve</button></form>
            @endif
        </div>
    </header>

    <section class="iv-grid">
        <article class="iv-card">
            <h2>Invitation Details</h2>
            <dl class="iv-dl">
                <dt>Invitee</dt><dd>{{ $invitation->name }}</dd>
                <dt>Email</dt><dd>{{ $invitation->email }}</dd>
                <dt>Role</dt><dd>Admin Client</dd>
                <dt>Status</dt><dd>{{ ucfirst($status) }}</dd>
                <dt>Sent Date</dt><dd>{{ optional($invitation->created_at)->format('M d, Y h:i A') }}</dd>
                <dt>Expiry Date</dt><dd>{{ optional($invitation->invite_expires_at)->format('M d, Y h:i A') ?: 'Not active' }}</dd>
                <dt>Accepted Date</dt><dd>{{ optional($invitation->invitation_accepted_at)->format('M d, Y h:i A') ?: '-' }}</dd>
                <dt>Cancelled Date</dt><dd>{{ optional($invitation->invite_cancelled_at)->format('M d, Y h:i A') ?: '-' }}</dd>
            </dl>
        </article>
        <article class="iv-card">
            <h2>Business Assignment</h2>
            <dl class="iv-dl">
                <dt>Business</dt><dd>{{ $invitation->business?->name ?: $invitation->ownedBusiness?->name ?: $invitation->adminClientProfile?->business_name ?: 'Unassigned' }}</dd>
                <dt>Business Status</dt><dd>{{ $invitation->business ? \Illuminate\Support\Str::headline($invitation->business->status) : 'Not linked' }}</dd>
                <dt>Contact Person</dt><dd>{{ $invitation->adminClientProfile?->contact_person ?: $invitation->name }}</dd>
                <dt>Contact Number</dt><dd>{{ $invitation->adminClientProfile?->contact_number ?: $invitation->phone ?: 'Not recorded' }}</dd>
                <dt>Address</dt><dd>{{ $invitation->adminClientProfile?->business_address ?: $invitation->business?->address ?: 'Not recorded' }}</dd>
            </dl>
        </article>
    </section>

    <section class="iv-card">
        <h2>Invitation History</h2>
        <table class="iv-table">
            <thead><tr><th>Action</th><th>Actor</th><th>Date</th><th>Details</th></tr></thead>
            <tbody>
            @forelse($auditLogs as $log)
                <tr><td>{{ \Illuminate\Support\Str::headline($log->action) }}</td><td>{{ $log->actor?->name ?: 'System' }}</td><td>{{ optional($log->created_at)->format('M d, Y h:i A') }}</td><td>{{ collect($log->new_values ?? [])->map(fn($value, $key) => $key.': '.$value)->implode(' · ') }}</td></tr>
            @empty
                <tr><td colspan="4">No invitation history recorded yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>
</main>
</x-app-layout>
