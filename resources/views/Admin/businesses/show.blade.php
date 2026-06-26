<x-app-layout>
@php
    $statusClass = match ($business->status) {
        \App\Models\Business::STATUS_ACTIVE => 'active',
        \App\Models\Business::STATUS_SUSPENDED => 'suspended',
        \App\Models\Business::STATUS_DELETED => 'deleted',
        default => 'inactive',
    };
@endphp

<style>
    .bd-page{padding:34px 56px 52px;background:#f8fafc;color:#111827;font-family:'Inter',system-ui,sans-serif}
    .bd-crumb{font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:8px}
    .bd-crumb a{color:#2563eb;text-decoration:none}
    .bd-head{display:flex;justify-content:space-between;gap:18px;align-items:flex-start;margin-bottom:18px}
    .bd-title{margin:0;font:900 30px 'Poppins',system-ui,sans-serif;color:#111827;line-height:1.05}
    .bd-sub{margin:7px 0 0;color:#64748b;font-size:13px;font-weight:600}
    .bd-actions{display:flex;gap:8px;flex-wrap:wrap}
    .bd-btn{height:38px;border:1px solid #d8dee8;border-radius:8px;background:#fff;color:#111827;display:inline-flex;align-items:center;gap:8px;padding:0 13px;font-size:12px;font-weight:900;text-decoration:none}
    .bd-btn.primary{background:#ff7a00;border-color:#ff7a00;color:#111827}
    .bd-status{display:inline-flex;margin-top:10px;border-radius:999px;padding:5px 12px;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.06em}
    .bd-status.active{background:#dcfce7;color:#166534}.bd-status.inactive{background:#f1f5f9;color:#475569}.bd-status.suspended{background:#fee2e2;color:#991b1b}.bd-status.deleted{background:#e5e7eb;color:#111827}
    .bd-profile{display:grid;grid-template-columns:1.3fr .9fr;gap:14px;margin-bottom:18px}
    .bd-card{border:1px solid #d8dee8;border-radius:8px;background:#fff;padding:16px;box-shadow:0 8px 22px -16px rgba(15,23,42,.2)}
    .bd-card h2{margin:0 0 12px;font:900 14px 'Poppins',system-ui,sans-serif;color:#111827}
    .bd-dl{display:grid;grid-template-columns:150px 1fr;gap:10px 14px;margin:0;font-size:12px}
    .bd-dl dt{font-weight:900;color:#64748b}.bd-dl dd{margin:0;color:#111827;font-weight:700;word-break:break-word}
    .bd-kpis{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:10px;margin-bottom:18px}
    .bd-kpi{border:1px solid #d8dee8;border-radius:8px;background:#fff;padding:13px;min-height:76px}
    .bd-kpi small{display:block;font-size:9px;text-transform:uppercase;font-weight:900;color:#64748b;line-height:1.2}
    .bd-kpi strong{display:block;margin-top:7px;font-size:18px;font-weight:950;color:#111827;line-height:1.1}
    .bd-kpi.blue{border-left:4px solid #2563eb}.bd-kpi.green{border-left:4px solid #10b981}.bd-kpi.orange{border-left:4px solid #ff7a00}.bd-kpi.red{border-left:4px solid #ef4444}.bd-kpi.slate{border-left:4px solid #64748b}
    .bd-tabs{position:sticky;top:0;z-index:5;display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;padding:10px 0;background:#f8fafc}
    .bd-tabs a{border:1px solid #d8dee8;border-radius:999px;background:#fff;color:#475569;padding:7px 12px;font-size:11px;font-weight:900;text-decoration:none}
    .bd-tabs a:hover{border-color:#2563eb;color:#2563eb}
    .bd-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .bd-table-wrap{overflow:auto;border:1px solid #e8edf5;border-radius:8px}
    .bd-table{width:100%;min-width:620px;border-collapse:collapse}
    .bd-table th{height:34px;background:#fbfcfe;border-bottom:1px solid #e8edf5;text-align:left;padding:0 10px;font-size:10px;text-transform:uppercase;color:#475569}
    .bd-table td{height:42px;border-bottom:1px solid #eef2f7;padding:0 10px;font-size:12px;color:#111827;vertical-align:middle}
    .bd-table tr:last-child td{border-bottom:0}
    .bd-muted{color:#94a3b8;font-weight:700}.bd-money{font-weight:900;color:#111827}.bd-empty{border:1px dashed #d8dee8;border-radius:8px;min-height:76px;display:grid;place-items:center;color:#94a3b8;font-size:12px;font-weight:800;text-align:center;padding:12px}
    .bd-section{scroll-margin-top:80px}
    @media(max-width:1200px){.bd-kpis{grid-template-columns:repeat(2,minmax(0,1fr))}.bd-profile,.bd-grid{grid-template-columns:1fr}}
    @media(max-width:720px){.bd-page{padding:24px 16px 40px}.bd-head{display:grid}.bd-kpis{grid-template-columns:1fr}.bd-dl{grid-template-columns:1fr}.bd-tabs{position:static}}
</style>

<main class="bd-page">
    <div class="bd-crumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span>/</span>
        <span>Business Detail</span>
    </div>

    <header class="bd-head">
        <div>
            <h1 class="bd-title">{{ $business->name }}</h1>
            <p class="bd-sub">Tenant-level overview for orders, payments, deliveries, customers, services, and audit activity.</p>
            <span class="bd-status {{ $statusClass }}">{{ \Illuminate\Support\Str::headline($business->status) }}</span>
        </div>
        <div class="bd-actions">
            <a class="bd-btn" href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
            @if($owner)
                <a class="bd-btn primary" href="{{ route('developer.admin-clients.show', $owner) }}">Admin Client</a>
            @endif
        </div>
    </header>

    <section class="bd-profile">
        <article class="bd-card">
            <h2>Business Profile</h2>
            <dl class="bd-dl">
                <dt>Business Name</dt><dd>{{ $business->name }}</dd>
                <dt>Status</dt><dd>{{ \Illuminate\Support\Str::headline($business->status) }}</dd>
                <dt>Email</dt><dd>{{ $business->email ?: ($owner?->email ?: 'Not recorded') }}</dd>
                <dt>Contact Number</dt><dd>{{ $business->contact_number ?: ($owner?->adminClientProfile?->contact_number ?: $owner?->phone ?: 'Not recorded') }}</dd>
                <dt>Address</dt><dd>{{ $business->address ?: ($owner?->adminClientProfile?->business_address ?: 'Not recorded') }}</dd>
                <dt>Last Activity</dt><dd>{{ $lastActivity ? \Carbon\Carbon::parse($lastActivity)->diffForHumans() : 'No activity yet' }}</dd>
            </dl>
        </article>
        <article class="bd-card">
            <h2>Admin Client</h2>
            <dl class="bd-dl">
                <dt>Name</dt><dd>{{ $owner?->name ?: 'Not assigned' }}</dd>
                <dt>Email</dt><dd>{{ $owner?->email ?: 'Not assigned' }}</dd>
                <dt>Approval</dt><dd>{{ $owner?->approved_at ? 'Approved' : 'Pending or inactive' }}</dd>
                <dt>Registered</dt><dd>{{ optional($owner?->created_at)->format('M d, Y') ?: 'Not recorded' }}</dd>
                <dt>Profile</dt><dd>{{ $owner?->adminClientProfile?->isComplete() ? 'Complete' : 'Incomplete or missing' }}</dd>
            </dl>
        </article>
    </section>

    <section class="bd-kpis" id="overview">
        @foreach($kpis as $kpi)
            <article class="bd-kpi {{ $kpi['tone'] }}"><small>{{ $kpi['label'] }}</small><strong>{{ is_numeric($kpi['value']) ? number_format($kpi['value']) : $kpi['value'] }}</strong></article>
        @endforeach
    </section>

    <nav class="bd-tabs" aria-label="Business detail sections">
        <a href="#overview">Overview</a>
        <a href="#customers">Customers</a>
        <a href="#orders">Orders</a>
        <a href="#payments">Payments</a>
        <a href="#deliveries">Deliveries</a>
        <a href="#services">Services</a>
        <a href="#audit-logs">Audit Logs</a>
    </nav>

    <section class="bd-grid">
        <article class="bd-card bd-section" id="customers">
            <h2>Customers</h2>
            @if($customers->isEmpty())
                <div class="bd-empty">No customers assigned to this business yet.</div>
            @else
                <div class="bd-table-wrap"><table class="bd-table"><thead><tr><th>Name</th><th>Email</th><th>Joined</th></tr></thead><tbody>@foreach($customers as $customer)<tr><td>{{ $customer->name ?: 'Customer' }}</td><td>{{ $customer->email }}</td><td>{{ optional($customer->created_at)->format('M d, Y') }}</td></tr>@endforeach</tbody></table></div>
            @endif
        </article>

        <article class="bd-card bd-section" id="orders">
            <h2>Orders</h2>
            @if($orders->isEmpty())
                <div class="bd-empty">No orders recorded for this business.</div>
            @else
                <div class="bd-table-wrap"><table class="bd-table"><thead><tr><th>Order</th><th>Customer</th><th>Status</th><th>Total</th></tr></thead><tbody>@foreach($orders as $order)<tr><td>{{ $order->order_reference ?: '#'.$order->id }}</td><td>{{ $order->customer_name ?: $order->user?->name ?: 'Customer' }}</td><td>{{ \Illuminate\Support\Str::headline($order->status) }}</td><td class="bd-money">PHP {{ number_format((float) $order->total_price, 2) }}</td></tr>@endforeach</tbody></table></div>
            @endif
        </article>

        <article class="bd-card bd-section" id="payments">
            <h2>Payments</h2>
            @if($payments->isEmpty())
                <div class="bd-empty">No payment records for this business.</div>
            @else
                <div class="bd-table-wrap"><table class="bd-table"><thead><tr><th>Reference</th><th>Method</th><th>Status</th><th>Amount</th></tr></thead><tbody>@foreach($payments as $payment)<tr><td>{{ $payment->gateway_reference ?: $payment->order?->order_reference ?: '#'.$payment->id }}</td><td>{{ \Illuminate\Support\Str::headline($payment->payment_method) }}</td><td>{{ \Illuminate\Support\Str::headline($payment->status) }}</td><td class="bd-money">PHP {{ number_format((float) $payment->amount, 2) }}</td></tr>@endforeach</tbody></table></div>
            @endif
        </article>

        <article class="bd-card bd-section" id="deliveries">
            <h2>Deliveries</h2>
            @if($deliveries->isEmpty())
                <div class="bd-empty">No delivery records for this business.</div>
            @else
                <div class="bd-table-wrap"><table class="bd-table"><thead><tr><th>Tracking</th><th>Method</th><th>Status</th><th>Address</th></tr></thead><tbody>@foreach($deliveries as $delivery)<tr><td>{{ $delivery->tracking_reference ?: $delivery->order?->order_reference ?: '#'.$delivery->id }}</td><td>{{ \Illuminate\Support\Str::headline($delivery->delivery_method) }}</td><td>{{ \Illuminate\Support\Str::headline($delivery->status) }}</td><td>{{ $delivery->delivery_address ?: 'No address' }}</td></tr>@endforeach</tbody></table></div>
            @endif
        </article>

        <article class="bd-card bd-section" id="services">
            <h2>Services</h2>
            @if($services->isEmpty())
                <div class="bd-empty">No business-specific services assigned yet.</div>
            @else
                <div class="bd-table-wrap"><table class="bd-table"><thead><tr><th>Service</th><th>Category</th><th>Options</th><th>Status</th></tr></thead><tbody>@foreach($services as $service)<tr><td>{{ $service->name }}</td><td>{{ $service->category ?: 'General' }}</td><td>{{ number_format($service->active_variations_count) }}</td><td>{{ $service->is_active ? 'Active' : 'Inactive' }}</td></tr>@endforeach</tbody></table></div>
            @endif
        </article>

        <article class="bd-card bd-section" id="audit-logs">
            <h2>Audit Logs</h2>
            @if($auditLogs->isEmpty())
                <div class="bd-empty">No audit logs recorded for this business.</div>
            @else
                <div class="bd-table-wrap"><table class="bd-table"><thead><tr><th>Action</th><th>Actor</th><th>Target</th><th>Date</th></tr></thead><tbody>@foreach($auditLogs as $log)<tr><td>{{ \Illuminate\Support\Str::headline($log->action ?? 'Activity') }}</td><td>{{ $log->actor?->name ?: 'System' }}</td><td>{{ $log->targetUser?->name ?: 'Record' }}</td><td>{{ optional($log->created_at)->format('M d, Y') }}</td></tr>@endforeach</tbody></table></div>
            @endif
        </article>
    </section>
</main>
</x-app-layout>
