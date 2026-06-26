<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Business Report</title>
    <style>
        body{font-family:DejaVu Sans,Arial,sans-serif;color:#111827;font-size:11px;margin:24px}
        h1{font-size:20px;margin:0 0 4px}
        h2{font-size:13px;margin:18px 0 8px;color:#111827}
        p{margin:0 0 12px;color:#475569}
        .summary{width:100%;border-collapse:collapse;margin:0 0 14px}
        .summary td{border:1px solid #d8dee8;padding:7px 8px;width:25%}
        .summary small{display:block;color:#64748b;text-transform:uppercase;font-size:8px;font-weight:bold}
        .summary strong{display:block;margin-top:3px;font-size:13px}
        .profile{width:100%;border-collapse:collapse;margin-bottom:14px}
        .profile th{width:26%;background:#f8fafc;color:#64748b;text-align:left;border:1px solid #e5e7eb;padding:7px}
        .profile td{border:1px solid #e5e7eb;padding:7px}
        .report{width:100%;border-collapse:collapse;margin-bottom:12px}
        .report th{background:#f1f5f9;border:1px solid #d8dee8;padding:7px 6px;text-align:left;font-size:9px;text-transform:uppercase}
        .report td{border:1px solid #e5e7eb;padding:6px}
        .number{text-align:right}
    </style>
</head>
<body>
    @php
        $business = $report['business'];
        $owner = $report['owner'];
    @endphp

    <h1>Business-Level Report</h1>
    <p>{{ $business->name }} | Generated {{ $generatedAt->format('F d, Y h:i A') }}</p>

    <h2>Business Profile</h2>
    <table class="profile">
        <tr><th>Business Name</th><td>{{ $business->name }}</td></tr>
        <tr><th>Status</th><td>{{ \Illuminate\Support\Str::headline($business->status) }}</td></tr>
        <tr><th>Email</th><td>{{ $business->email ?: ($owner?->email ?: 'Not recorded') }}</td></tr>
        <tr><th>Contact Number</th><td>{{ $business->contact_number ?: ($owner?->adminClientProfile?->contact_number ?: $owner?->phone ?: 'Not recorded') }}</td></tr>
        <tr><th>Address</th><td>{{ $business->address ?: ($owner?->adminClientProfile?->business_address ?: 'Not recorded') }}</td></tr>
        <tr><th>Last Activity</th><td>{{ $report['lastActivity'] ? \Carbon\Carbon::parse($report['lastActivity'])->format('M d, Y h:i A') : 'No activity yet' }}</td></tr>
    </table>

    <h2>Admin-Client Information</h2>
    <table class="profile">
        <tr><th>Name</th><td>{{ $owner?->name ?: 'Not assigned' }}</td></tr>
        <tr><th>Email</th><td>{{ $owner?->email ?: 'Not assigned' }}</td></tr>
        <tr><th>Approval</th><td>{{ $owner?->approved_at ? 'Approved' : 'Pending or inactive' }}</td></tr>
        <tr><th>Profile</th><td>{{ $owner?->adminClientProfile?->isComplete() ? 'Complete' : 'Incomplete or missing' }}</td></tr>
    </table>

    <h2>Performance Summary</h2>
    <table class="summary">
        @foreach(collect($report['kpis'])->chunk(4) as $chunk)
            <tr>
                @foreach($chunk as $kpi)
                    <td><small>{{ $kpi['label'] }}</small><strong>{{ is_numeric($kpi['value']) ? number_format($kpi['value']) : $kpi['value'] }}</strong></td>
                @endforeach
                @for($i = $chunk->count(); $i < 4; $i++)
                    <td></td>
                @endfor
            </tr>
        @endforeach
    </table>

    <h2>Payments Summary</h2>
    <table class="summary">
        <tr>
            <td><small>Paid</small><strong>{{ number_format($report['paymentsSummary']['paid'] ?? 0) }}</strong></td>
            <td><small>Pending</small><strong>{{ number_format($report['paymentsSummary']['pending'] ?? 0) }}</strong></td>
            <td><small>Failed / Issue</small><strong>{{ number_format($report['paymentsSummary']['failed'] ?? 0) }}</strong></td>
            <td><small>Records Listed</small><strong>{{ number_format($report['payments']->count()) }}</strong></td>
        </tr>
    </table>

    <table class="report">
        <thead><tr><th>Reference</th><th>Method</th><th>Status</th><th class="number">Amount</th></tr></thead>
        <tbody>
            @forelse($report['payments'] as $payment)
                <tr><td>{{ $payment->gateway_reference ?: $payment->order?->order_reference ?: '#'.$payment->id }}</td><td>{{ \Illuminate\Support\Str::headline($payment->payment_method) }}</td><td>{{ \Illuminate\Support\Str::headline($payment->status) }}</td><td class="number">PHP {{ number_format((float) $payment->amount, 2) }}</td></tr>
            @empty
                <tr><td colspan="4">No payments found for this period.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Deliveries Summary</h2>
    <table class="summary">
        <tr>
            <td><small>Active</small><strong>{{ number_format($report['deliveriesSummary']['active'] ?? 0) }}</strong></td>
            <td><small>Delivered</small><strong>{{ number_format($report['deliveriesSummary']['delivered'] ?? 0) }}</strong></td>
            <td><small>Failed / Cancelled</small><strong>{{ number_format($report['deliveriesSummary']['failed'] ?? 0) }}</strong></td>
            <td><small>Records Listed</small><strong>{{ number_format($report['deliveries']->count()) }}</strong></td>
        </tr>
    </table>

    <table class="report">
        <thead><tr><th>Tracking</th><th>Method</th><th>Status</th><th>Address</th></tr></thead>
        <tbody>
            @forelse($report['deliveries'] as $delivery)
                <tr><td>{{ $delivery->tracking_reference ?: $delivery->order?->order_reference ?: '#'.$delivery->id }}</td><td>{{ \Illuminate\Support\Str::headline($delivery->delivery_method) }}</td><td>{{ \Illuminate\Support\Str::headline($delivery->status) }}</td><td>{{ $delivery->delivery_address ?: 'No address recorded' }}</td></tr>
            @empty
                <tr><td colspan="4">No deliveries found for this period.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Invitation History</h2>
    <table class="report">
        <thead><tr><th>Invitee</th><th>Email</th><th>Status</th><th>Sent</th></tr></thead>
        <tbody>
            @forelse($report['invitations'] as $invite)
                @php($inviteStatus = $invite->invite_cancelled_at ? 'Cancelled' : ($invite->invitation_accepted_at ? 'Accepted' : (($invite->invite_token && $invite->invite_expires_at && $invite->invite_expires_at->isPast()) ? 'Expired' : ($invite->invite_token ? 'Pending' : 'Recorded'))))
                <tr><td>{{ $invite->name }}</td><td>{{ $invite->email }}</td><td>{{ $inviteStatus }}</td><td>{{ optional($invite->created_at)->format('M d, Y') }}</td></tr>
            @empty
                <tr><td colspan="4">No invitation history found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Audit Log Summary</h2>
    <table class="report">
        <thead><tr><th>Action</th><th>Actor</th><th>Target</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($report['auditLogs'] as $log)
                <tr><td>{{ \Illuminate\Support\Str::headline($log->action ?? 'Activity') }}</td><td>{{ $log->actor?->name ?: 'System' }}</td><td>{{ $log->targetUser?->name ?: 'Record' }}</td><td>{{ optional($log->created_at)->format('M d, Y') }}</td></tr>
            @empty
                <tr><td colspan="4">No audit logs found.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
