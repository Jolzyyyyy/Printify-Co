@php
    $filters = $developer['filters'] ?? [];
    $kpis = collect($developer['kpis'] ?? []);
    $kpiGroups = [
        'Business Health' => ['Total Businesses', 'Active Businesses', 'Inactive Businesses', 'Suspended Businesses', 'Deleted Businesses'],
        'Access & Users' => ['Total Admin Clients', 'Pending Invitations', 'Total Customers', 'Suspended Accounts'],
        'Operations' => ['Total Orders', 'Completed Orders', 'Cancelled Orders', 'Active Deliveries'],
        'Financial' => ['Total Sales', 'Total Revenue', 'Pending Payments', 'Failed Payments'],
    ];
    $rangeLabels = [
        'today' => 'Today',
        'last_7' => 'Last 7 days',
        'this_month' => 'This month',
        'custom' => 'Custom range',
    ];
    $revenueTrend = collect($developer['revenueTrend'] ?? []);
    $cancellationTrend = collect($developer['cancellationTrend'] ?? []);
    $statusCounts = collect($developer['statusCounts'] ?? []);
    $paymentBreakdown = collect($developer['paymentBreakdown'] ?? []);
    $deliveryBreakdown = collect($developer['deliveryBreakdown'] ?? []);
    $maxRevenue = max(1, (float) $revenueTrend->max());
    $maxCancel = max(1, (int) $cancellationTrend->max());
    $statusMax = max(1, (int) $statusCounts->max());
    $paymentMax = max(1, (int) $paymentBreakdown->max());
    $deliveryMax = max(1, (int) $deliveryBreakdown->max());
@endphp

<style id="developer-dashboard-capstone-layout">
    .staff-portal-developer .hero-banner{height:150px!important;padding:8px 44px!important}
    .staff-portal-developer .hero-title-area{bottom:22px!important}
    .staff-portal-developer .hero-main-title{font-size:34px!important}
    .staff-portal-developer .hero-subline{max-width:720px!important}
    .devx{display:grid;gap:16px;color:#111827}
    .devx-head{display:flex;align-items:flex-end;justify-content:space-between;gap:16px}
    .devx-title h1{margin:0;font:900 22px 'Poppins',system-ui,sans-serif;color:#111827}
    .devx-title p{margin:4px 0 0;color:#64748b;font-size:12px}
    .devx-filter{display:grid;grid-template-columns:minmax(220px,1.4fr) minmax(135px,.72fr) minmax(112px,.58fr) minmax(112px,.58fr) minmax(130px,.7fr) 102px 120px 120px;gap:7px;align-items:center;width:100%;max-width:100%;overflow:visible}
    .devx-control,.devx-btn{height:38px;border:1px solid #d8dee8;border-radius:8px;background:#fff;color:#111827;display:flex;align-items:center;gap:8px;padding:0 10px;font-size:12px;font-weight:700;min-width:0}
    .devx-control input,.devx-control select{width:100%;border:0;background:transparent;outline:0;font:inherit;color:inherit;min-width:0}
    .devx-btn{justify-content:center;text-decoration:none;cursor:pointer}
    .devx-btn.primary{border-color:#ff7a00;background:#ff7a00;color:#111827}
    .devx-btn:hover{border-color:#111827;background:#fff8f1}
    .devx-btn.refresh{border-color:#2f6fed;background:#2f6fed;color:#fff}
    .devx-btn.refresh:hover{border-color:#2459c8;background:#2459c8;color:#fff}
    .devx-export-menu{height:38px;position:relative}
    .devx-export-menu summary{height:38px;border:1px solid #111827;border-radius:999px;background:#fff;color:#111827;display:flex;align-items:center;justify-content:center;gap:8px;padding:0 14px;font-size:12px;font-weight:800;cursor:pointer;list-style:none}
    .devx-export-menu summary::-webkit-details-marker{display:none}
    .devx-export-menu[open] summary{background:#fff8f1}
    .devx-export-options{position:absolute;top:44px;right:0;z-index:30;min-width:132px;border:1px solid #d8dee8;border-radius:8px;background:#fff;box-shadow:0 16px 36px rgba(15,23,42,.14);padding:6px}
    .devx-export-options a{display:flex;align-items:center;gap:8px;border-radius:7px;padding:9px 10px;color:#111827;text-decoration:none;font-size:12px;font-weight:800}
    .devx-export-options a:hover{background:#fff8f1}
    .devx-kpi-section{display:grid;gap:8px}
    .devx-section-title{margin:0;font:900 11px 'Poppins',system-ui,sans-serif;text-transform:uppercase;letter-spacing:.06em;color:#475569}
    .devx-kpi-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:9px}
    .devx-kpi-grid.four{grid-template-columns:repeat(4,minmax(0,1fr))}
    .devx-kpi{min-height:74px;border:1px solid #d8dee8;border-radius:8px;background:#fff;color:#111827;text-decoration:none;padding:11px;display:flex;align-items:center;gap:9px}
    .devx-kpi:hover{border-color:#111827;background:#fff8f1}
    .devx-kpi-icon{width:32px;height:32px;border-radius:8px;display:grid;place-items:center;flex:0 0 auto}
    .devx-kpi-icon.blue{background:#eaf1ff;color:#0b63f6}.devx-kpi-icon.green{background:#e4f8ee;color:#10b981}.devx-kpi-icon.orange{background:#fff3e6;color:#ff7a00}.devx-kpi-icon.red{background:#ffe9e9;color:#ef4444}.devx-kpi-icon.slate{background:#f1f5f9;color:#475569}
    .devx-kpi small{display:block;font-size:9px;text-transform:uppercase;font-weight:900;color:#64748b;line-height:1.2}.devx-kpi strong{display:block;margin-top:5px;font-size:16px;font-weight:900;color:#111827;line-height:1.1}
    .devx-chart-grid{display:grid;grid-template-columns:1.25fr 1fr;gap:14px}.devx-chart-grid.three{grid-template-columns:1fr 1fr 1fr}
    .devx-panel{border:1px solid #d8dee8;border-radius:8px;background:#fff;padding:14px;min-width:0}.devx-panel h2{margin:0 0 12px;font:900 14px 'Poppins',system-ui,sans-serif;color:#111827}
    .devx-empty{min-height:86px;display:grid;place-items:center;border:1px dashed #d8dee8;border-radius:8px;color:#94a3b8;font-size:12px;font-weight:700;text-align:center;padding:12px}
    .devx-bars{display:grid;gap:9px}.devx-bar-row{display:grid;grid-template-columns:120px 1fr 48px;gap:8px;align-items:center;font-size:11px;color:#475569;font-weight:800}.devx-bar-track{height:9px;border-radius:99px;background:#eef2f7;overflow:hidden}.devx-bar-fill{height:100%;border-radius:99px;background:#0b63f6}
    .devx-line{height:150px;width:100%;overflow:visible}.devx-line path{fill:none;stroke:#0b63f6;stroke-width:3;stroke-linecap:round;stroke-linejoin:round}.devx-line .muted{stroke:#eef2f7;stroke-width:1}.devx-line .cancel{stroke:#ef4444}
    .devx-rank{display:grid;gap:0}.devx-rank-row{display:grid;grid-template-columns:1fr auto;gap:10px;border-bottom:1px solid #eef2f7;padding:8px 0;font-size:12px}.devx-rank-row:last-child{border-bottom:0}.devx-rank-row small{display:block;color:#64748b;margin-top:2px}
    .devx-table-wrap{overflow:auto;border:1px solid #e8edf5;border-radius:8px}.devx-table{width:100%;min-width:1180px;border-collapse:collapse}.devx-table th{height:34px;background:#fbfcfe;border-bottom:1px solid #e8edf5;text-align:left;padding:0 10px;font-size:10px;text-transform:uppercase;color:#475569}.devx-table td{height:44px;border-bottom:1px solid #eef2f7;padding:0 10px;font-size:12px;color:#111827;vertical-align:middle}.devx-table tbody tr:hover{background:#fff8f1}
    .devx-status{display:inline-flex;border-radius:999px;padding:3px 9px;font-size:10px;font-weight:900}.devx-status.Active{background:#dcfce7;color:#166534}.devx-status.Inactive{background:#f1f5f9;color:#475569}.devx-status.Suspended{background:#fee2e2;color:#991b1b}
    .devx-actions{display:flex;gap:6px;align-items:center;flex-wrap:wrap}.devx-action{border:1px solid #d8dee8;border-radius:7px;background:#fff;color:#0b63f6;text-decoration:none;font-size:10px;font-weight:900;padding:5px 8px;cursor:pointer}.devx-action.danger{color:#dc2626;border-color:#fecaca}.devx-action.success{color:#16a34a;border-color:#bbf7d0}.devx-action:hover{background:#f8fafc}
    .devx-issue-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}.devx-issue-line{display:flex;justify-content:space-between;gap:10px;border-bottom:1px solid #eef2f7;padding:8px 0;font-size:12px}.devx-issue-line:last-child{border-bottom:0}.devx-issue-line small{display:block;color:#64748b;margin-top:2px}
    @media(max-width:1450px){.devx-filter{grid-template-columns:minmax(190px,1.2fr) minmax(126px,.62fr) minmax(104px,.5fr) minmax(104px,.5fr) minmax(116px,.56fr) 92px 110px 110px;gap:6px}.devx-control,.devx-btn,.devx-export-menu summary{font-size:11px}.devx-btn{padding:0 8px}}
    @media(max-width:1300px){.devx-filter{grid-template-columns:1fr 1fr 1fr}.devx-kpi-grid,.devx-kpi-grid.four{grid-template-columns:repeat(2,minmax(0,1fr))}.devx-chart-grid,.devx-chart-grid.three,.devx-issue-grid{grid-template-columns:1fr}}
    @media(max-width:720px){.devx-head{display:grid}.devx-filter{grid-template-columns:1fr}.devx-kpi-grid,.devx-kpi-grid.four{grid-template-columns:1fr}}
</style>

<section class="devx">
    <div class="devx-head">
        <div class="devx-title">
            <h1>Dashboard</h1>
            <p>Monitor platform-wide print operations, payments, deliveries, and business performance.</p>
        </div>
    </div>

    <form class="devx-filter" method="GET" action="{{ route('admin.dashboard') }}">
        <label class="devx-control"><i data-lucide="search"></i><input name="search" value="{{ $filters['search'] ?? '' }}" type="search" placeholder="Search business, admin client, customer, order ID, payment ref"></label>
        <label class="devx-control"><i data-lucide="calendar-days"></i><select name="date_range"><option value="today" @selected(($filters['date_range'] ?? '') === 'today')>Today</option><option value="last_7" @selected(($filters['date_range'] ?? '') === 'last_7')>Last 7 days</option><option value="this_month" @selected(($filters['date_range'] ?? '') === 'this_month')>This month</option><option value="custom" @selected(($filters['date_range'] ?? '') === 'custom')>Custom range</option></select></label>
        <label class="devx-control"><input name="date_from" value="{{ optional($filters['date_from'] ?? null)->format('Y-m-d') }}" type="date"></label>
        <label class="devx-control"><input name="date_to" value="{{ optional($filters['date_to'] ?? null)->format('Y-m-d') }}" type="date"></label>
        <label class="devx-control"><select name="status"><option value="">All statuses</option>@foreach(($developer['statusCounts'] ?? collect())->keys() as $status)<option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ \Illuminate\Support\Str::headline($status) }}</option>@endforeach</select></label>
        <button class="devx-btn primary" type="submit"><i data-lucide="filter"></i>Apply</button>
        <details class="devx-export-menu">
            <summary><i data-lucide="download"></i>Export</summary>
            <div class="devx-export-options">
                <a href="{{ route('developer.dashboard.export', array_merge(request()->query(), ['format' => 'csv'])) }}"><i data-lucide="file-spreadsheet"></i>CSV</a>
                <a href="{{ route('developer.dashboard.export', array_merge(request()->query(), ['format' => 'pdf'])) }}"><i data-lucide="file-text"></i>PDF</a>
                <a href="{{ route('developer.dashboard.export', array_merge(request()->query(), ['format' => 'xls'])) }}"><i data-lucide="table"></i>Excel</a>
            </div>
        </details>
        <a class="devx-btn refresh" href="{{ route('admin.dashboard') }}"><i data-lucide="refresh-cw"></i>Refresh</a>
    </form>

    @foreach($kpiGroups as $groupTitle => $labels)
        @php $groupKpis = $kpis->whereIn('label', $labels)->values(); @endphp
        <section class="devx-kpi-section">
            <h2 class="devx-section-title">{{ $groupTitle }}</h2>
            <div class="devx-kpi-grid {{ $groupKpis->count() <= 4 ? 'four' : '' }}">
                @foreach($groupKpis as $kpi)
                    <div class="devx-kpi">
                        <span class="devx-kpi-icon {{ $kpi['tone'] }}"><i data-lucide="{{ $kpi['icon'] }}"></i></span>
                        <span><small>{{ $kpi['label'] }}</small><strong>{{ is_numeric($kpi['value']) ? number_format($kpi['value']) : $kpi['value'] }}</strong></span>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach

    <section class="devx-chart-grid">
        <article class="devx-panel">
            <h2>Revenue Overview</h2>
            @if($revenueTrend->isEmpty())
                <div class="devx-empty">No revenue for the selected date range.</div>
            @else
                @php
                    $points = $revenueTrend->values()->map(function ($value, $index) use ($revenueTrend, $maxRevenue) {
                        $x = $revenueTrend->count() <= 1 ? 50 : ($index / max(1, $revenueTrend->count() - 1)) * 100;
                        $y = 95 - (((float) $value / $maxRevenue) * 80);
                        return round($x, 2) . ',' . round($y, 2);
                    })->implode(' ');
                @endphp
                <svg class="devx-line" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path class="muted" d="M0 20 H100 M0 50 H100 M0 80 H100"></path>
                    <polyline points="{{ $points }}" fill="none" stroke="#0b63f6" stroke-width="3" vector-effect="non-scaling-stroke"></polyline>
                </svg>
            @endif
        </article>
        <article class="devx-panel">
            <h2>Orders by Status</h2>
            @if($statusCounts->isEmpty())
                <div class="devx-empty">No orders for the selected date range.</div>
            @else
                <div class="devx-bars">@foreach($statusCounts as $status => $total)<div class="devx-bar-row"><span>{{ \Illuminate\Support\Str::headline($status) }}</span><div class="devx-bar-track"><div class="devx-bar-fill" style="width:{{ max(4, ($total / $statusMax) * 100) }}%"></div></div><strong>{{ number_format($total) }}</strong></div>@endforeach</div>
            @endif
        </article>
    </section>

    <section class="devx-chart-grid three">
        <article class="devx-panel"><h2>Payment Method Breakdown</h2>@if($paymentBreakdown->isEmpty())<div class="devx-empty">No payment records for this range.</div>@else<div class="devx-bars">@foreach($paymentBreakdown as $method => $total)<div class="devx-bar-row"><span>{{ \Illuminate\Support\Str::headline($method) }}</span><div class="devx-bar-track"><div class="devx-bar-fill" style="width:{{ max(4, ($total / $paymentMax) * 100) }}%;background:#ff7a00"></div></div><strong>{{ number_format($total) }}</strong></div>@endforeach</div>@endif</article>
        <article class="devx-panel"><h2>Delivery Status Overview</h2>@if($deliveryBreakdown->isEmpty())<div class="devx-empty">No delivery records for this range.</div>@else<div class="devx-bars">@foreach($deliveryBreakdown as $status => $total)<div class="devx-bar-row"><span>{{ \Illuminate\Support\Str::headline($status) }}</span><div class="devx-bar-track"><div class="devx-bar-fill" style="width:{{ max(4, ($total / $deliveryMax) * 100) }}%;background:#0ea5e9"></div></div><strong>{{ number_format($total) }}</strong></div>@endforeach</div>@endif</article>
        <article class="devx-panel"><h2>Cancellation Trend</h2>@if($cancellationTrend->isEmpty())<div class="devx-empty">No cancelled orders for the selected date range.</div>@else<svg class="devx-line" viewBox="0 0 100 100" preserveAspectRatio="none">@php $cancelPoints = $cancellationTrend->values()->map(fn ($value, $index) => round($cancellationTrend->count() <= 1 ? 50 : ($index / max(1, $cancellationTrend->count() - 1)) * 100, 2) . ',' . round(95 - (((float) $value / $maxCancel) * 80), 2))->implode(' '); @endphp<path class="muted" d="M0 20 H100 M0 50 H100 M0 80 H100"></path><polyline points="{{ $cancelPoints }}" fill="none" stroke="#ef4444" stroke-width="3" vector-effect="non-scaling-stroke"></polyline></svg>@endif</article>
    </section>

    <section class="devx-chart-grid">
        <article class="devx-panel">
            <h2>Top Performing Businesses</h2>
            <div class="devx-rank">@forelse($developer['businessRows']->sortByDesc('revenue')->take(6) as $row)<div class="devx-rank-row"><span><strong>{{ $row['business_name'] }}</strong><small>{{ number_format($row['orders']) }} orders / {{ number_format($row['customers']) }} customers</small></span><b>PHP {{ number_format($row['revenue'], 2) }}</b></div>@empty<div class="devx-empty">No businesses match the selected filters.</div>@endforelse</div>
        </article>
        <article class="devx-panel">
            <h2>Recent Audit Logs</h2>
            @forelse($developer['recentAuditLogs'] as $log)<div class="devx-issue-line"><span><strong>{{ \Illuminate\Support\Str::headline($log->action ?? 'Activity') }}</strong><small>{{ $log->actor?->name ?? 'System' }}</small></span><b>{{ optional($log->created_at)->diffForHumans() }}</b></div>@empty<div class="devx-empty">No audit logs yet.</div>@endforelse
        </article>
    </section>

    <article class="devx-panel">
        <h2>Business Performance Table</h2>
        <div class="devx-table-wrap">
            <table class="devx-table">
                <thead><tr><th>Business Name</th><th>Admin Client</th><th>Status</th><th>Customers</th><th>Orders</th><th>Completed</th><th>Cancelled</th><th>Sales</th><th>Revenue</th><th>Payment Issues</th><th>Last Activity</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse($developer['businessRows'] as $row)
                    <tr>
                        <td><strong>{{ $row['business_name'] }}</strong></td><td>{{ $row['admin_client'] }}</td><td><span class="devx-status {{ $row['status'] }}">{{ $row['status'] }}</span></td><td>{{ number_format($row['customers']) }}</td><td>{{ number_format($row['orders']) }}</td><td>{{ number_format($row['completed']) }}</td><td>{{ number_format($row['cancelled']) }}</td><td>PHP {{ number_format($row['sales'], 2) }}</td><td>PHP {{ number_format($row['revenue'], 2) }}</td><td>{{ number_format($row['payment_issues']) }} Issues</td><td>{{ $row['last_activity'] }}</td>
                        <td>
                            <div class="devx-actions">
                                <a class="devx-action" href="{{ $row['url'] }}">View</a><a class="devx-action" href="{{ $row['orders_url'] }}">Orders</a><a class="devx-action" href="{{ $row['payments_url'] }}">Payments</a><a class="devx-action" href="{{ $row['deliveries_url'] }}">Deliveries</a><a class="devx-action" href="{{ $row['customers_url'] }}">Customers</a><a class="devx-action" href="{{ $row['logs_url'] }}">Logs</a>
                                @if($row['business_activate_url'] && $row['status'] !== 'Active')
                                    <form method="POST" action="{{ $row['business_activate_url'] }}">@csrf @method('PATCH')<button class="devx-action success" type="submit">Activate</button></form>
                                @endif
                                @if($row['business_inactive_url'] && $row['status'] === 'Active')
                                    <form method="POST" action="{{ $row['business_inactive_url'] }}" onsubmit="return confirm('Mark this business as inactive?');">@csrf @method('PATCH')<button class="devx-action" type="submit">Inactive</button></form>
                                @endif
                                @if($row['business_suspend_url'] && $row['status'] !== 'Suspended')
                                    <form method="POST" action="{{ $row['business_suspend_url'] }}" onsubmit="return confirm('Suspend this business and block admin-client access?');">@csrf @method('PATCH')<button class="devx-action danger" type="submit">Suspend</button></form>
                                @endif
                                @if($row['business_delete_url'])
                                    <form method="POST" action="{{ $row['business_delete_url'] }}" onsubmit="return confirm('Mark this business as deleted?');">@csrf @method('DELETE')<button class="devx-action danger" type="submit">Delete</button></form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="12">No businesses match the selected filters.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </article>

    <section class="devx-issue-grid">
        <article class="devx-panel"><h2>Recent Payment Issues</h2>@forelse($developer['recentPayments'] as $paymentOrder)@php $isPayment = $paymentOrder instanceof \App\Models\Payment; $paymentRef = $isPayment ? ($paymentOrder->gateway_reference ?: $paymentOrder->order?->order_reference ?: '#'.$paymentOrder->id) : ($paymentOrder->payment_reference ?: $paymentOrder->order_reference ?: '#'.$paymentOrder->id); $paymentMeta = $isPayment ? (($paymentOrder->payment_method ?: 'Payment') . ' / ' . ($paymentOrder->business?->name ?: $paymentOrder->order?->adminClient?->name ?: 'Unassigned')) : (($paymentOrder->payment_method ?: 'Payment') . ' / ' . ($paymentOrder->adminClient?->name ?? 'Unassigned')); $paymentAmount = $isPayment ? $paymentOrder->amount : $paymentOrder->total_price; @endphp<div class="devx-issue-line"><span><strong>{{ $paymentRef }}</strong><small>{{ $paymentMeta }}</small></span><b>PHP {{ number_format((float) $paymentAmount, 2) }}</b></div>@empty<div class="devx-empty">No payment issues for this range.</div>@endforelse</article>
        <article class="devx-panel"><h2>Recent Cancellations</h2>@forelse($developer['recentCancellations'] as $cancelledOrder)<div class="devx-issue-line"><span><strong>{{ $cancelledOrder->order_reference ?: '#'.$cancelledOrder->id }}</strong><small>{{ $cancelledOrder->user?->name ?? 'Customer' }}</small></span><b>{{ optional($cancelledOrder->created_at)->format('M d') }}</b></div>@empty<div class="devx-empty">No cancellations for this range.</div>@endforelse</article>
        <article class="devx-panel"><h2>Recent Deliveries</h2>@forelse($developer['recentDeliveries'] as $deliveryOrder)@php($isDelivery = $deliveryOrder instanceof \App\Models\Delivery)<div class="devx-issue-line"><span><strong>{{ $isDelivery ? ($deliveryOrder->tracking_reference ?: optional($deliveryOrder->order)->order_reference ?: '#'.$deliveryOrder->id) : ($deliveryOrder->delivery_tracking_number ?: $deliveryOrder->order_reference ?: '#'.$deliveryOrder->id) }}</strong><small>{{ \Illuminate\Support\Str::headline($isDelivery ? ($deliveryOrder->status ?? 'Recorded') : ($deliveryOrder->delivery_booking_status ?? $deliveryOrder->lalamove_status ?? 'Recorded')) }}</small></span><b>{{ optional($isDelivery ? ($deliveryOrder->booked_at ?? $deliveryOrder->created_at) : ($deliveryOrder->delivery_booked_at ?? $deliveryOrder->created_at))->format('M d') }}</b></div>@empty<div class="devx-empty">No deliveries for this range.</div>@endforelse</article>
        <article class="devx-panel"><h2>Notifications</h2><div class="devx-issue-line"><span><strong>Selected filter</strong><small>{{ $rangeLabels[$filters['date_range'] ?? 'this_month'] ?? 'This month' }}</small></span><b>{{ number_format(($developer['failedDeliveries'] ?? 0)) }}</b></div><div class="devx-issue-line"><span><strong>Failed deliveries</strong><small>Needs developer review</small></span><b>{{ number_format($developer['failedDeliveries'] ?? 0) }}</b></div></article>
    </section>
</section>
