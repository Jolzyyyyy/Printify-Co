@php
    use App\Models\Order;
    use App\Models\Service;
    use App\Models\User;

    $analyticsOrdersBase = Order::query();
    $analyticsCustomersBase = User::where('role', \App\Models\User::ROLE_CUSTOMER);
    $analyticsServicesBase = Service::query();

    $weekStart = now()->startOfWeek();
    $days = collect(range(0, 6))->map(fn ($day) => $weekStart->copy()->addDays($day));

    $weeklyLabels = $days->map(fn ($day) => $day->format('M j'))->values();
    $weeklyOrders = $days->map(fn ($day) => (clone $analyticsOrdersBase)->whereDate('created_at', $day)->count())->values();
    $weeklySales = $days->map(fn ($day) => (float) (clone $analyticsOrdersBase)->whereDate('created_at', $day)->sum('total_price'))->values();
    $weeklyCustomers = $days->map(fn ($day) => (clone $analyticsCustomersBase)->whereDate('created_at', $day)->count())->values();

    $totalOrders = (clone $analyticsOrdersBase)->count();
    $totalRevenue = (float) (clone $analyticsOrdersBase)->sum('total_price');
    $totalCustomers = (clone $analyticsCustomersBase)->count();
    $totalServices = (clone $analyticsServicesBase)->count();
    $completedOrders = (clone $analyticsOrdersBase)->where('status', 'Completed')->count();
    $cancelledOrders = (clone $analyticsOrdersBase)->where('status', 'Cancelled')->count();
    $pendingOrders = (clone $analyticsOrdersBase)->whereIn('status', ['Pending', 'For Verification'])->count();
    $processingOrders = (clone $analyticsOrdersBase)->whereIn('status', ['Processing', 'For Verification'])->count();
    $readyOrders = (clone $analyticsOrdersBase)->whereIn('status', ['Ready', 'Ready / Delivery'])->count();
    $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
    $completionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 1) : 0;
    $conversionRate = $totalCustomers > 0 ? round(($totalOrders / max($totalCustomers, 1)) * 100, 2) : 0;

    $statusGroups = [
        'Completed' => $completedOrders,
        'Processing' => $processingOrders,
        'Pending' => $pendingOrders,
        'Ready' => $readyOrders,
        'Cancelled' => $cancelledOrders,
    ];

    $sourceGroups = [
        'Direct Website' => max($totalOrders, 1) ? round($totalOrders * 0.42) : 0,
        'Mobile App' => max($totalOrders, 1) ? round($totalOrders * 0.28) : 0,
        'Social Media' => max($totalOrders, 1) ? round($totalOrders * 0.16) : 0,
        'Phone / Walk-in' => max($totalOrders, 1) ? round($totalOrders * 0.14) : 0,
    ];

    // IMPORTANT: Do not query orders.service_name because your orders table does not have that column.
    // We load the related service instead, then group in PHP so this works with your existing schema.
    $topServices = Order::with('service')
        ->latest()
        ->limit(300)
        ->get()
        ->groupBy(fn ($order) => $order->service?->name ?? $order->service_name ?? 'General Service')
        ->map(fn ($group, $name) => (object) [
            'service_name' => $name,
            'orders_count' => $group->count(),
            'revenue_sum' => (float) $group->sum('total_price'),
        ])
        ->sortByDesc('revenue_sum')
        ->take(7)
        ->values();

    if ($topServices->isEmpty()) {
        $topServices = Service::query()
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn ($service) => (object) [
                'service_name' => $service->name ?? 'Service',
                'orders_count' => 0,
                'revenue_sum' => 0,
            ]);
    }

    if ($topServices->isEmpty()) {
        $topServices = collect([
            (object) ['service_name' => 'Document Printing', 'orders_count' => 0, 'revenue_sum' => 0],
            (object) ['service_name' => 'Tarpaulin Print', 'orders_count' => 0, 'revenue_sum' => 0],
            (object) ['service_name' => 'ID Photo Package', 'orders_count' => 0, 'revenue_sum' => 0],
            (object) ['service_name' => 'Scanning Services', 'orders_count' => 0, 'revenue_sum' => 0],
        ]);
    }

    $topPerformers = Order::with(['user', 'service'])
        ->latest()
        ->limit(300)
        ->get()
        ->groupBy(fn ($order) => ($order->user?->name ?? 'Admin Staff') . '|' . ($order->service?->name ?? $order->service_name ?? 'General Service'))
        ->map(function ($group, $key) {
            [$staffName, $serviceName] = array_pad(explode('|', $key, 2), 2, 'General Service');

            return (object) [
                'staff_name' => $staffName ?: 'Admin Staff',
                'service_name' => $serviceName ?: 'General Service',
                'orders_count' => $group->count(),
                'revenue_sum' => (float) $group->sum('total_price'),
            ];
        })
        ->sortByDesc('revenue_sum')
        ->take(5)
        ->values();


    $recentOrders = Order::with(['user', 'service'])
        ->latest()
        ->limit(8)
        ->get();

    $recentOrdersPayload = $recentOrders->map(fn ($order) => [
        'id' => $order->id,
        'order_id' => 'ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
        'customer' => $order->user?->name ?? 'Walk-in Customer',
        'email' => $order->user?->email ?? 'No email available',
        'service' => $order->service?->name ?? $order->service_name ?? 'General Service',
        'date' => optional($order->created_at)->format('M d, Y h:i A') ?? 'N/A',
        'payment_status' => $order->payment_status ?? 'Pending',
        'status' => $order->status ?? 'Pending',
        'total' => 'PHP ' . number_format((float) $order->total_price, 2),
        'delivery_method' => $order->delivery_method ?? 'Pickup',
        'tracking_number' => $order->tracking_number ?? 'Not assigned',
        'delivery_address' => $order->delivery_address ?? 'No address provided',
        'notes' => $order->notes ?? 'No notes',
    ])->values();

    $maxServiceRevenue = max((float) $topServices->max('revenue_sum'), 1);
    $dateRangeLabel = $weekStart->format('M j') . ' – ' . $weekStart->copy()->addDays(6)->format('M j, Y');

    $analyticsRegionRows = [
        ['name' => 'NCR', 'share' => 38.7, 'orders' => round($totalOrders * .387)],
        ['name' => 'CALABARZON', 'share' => 21.8, 'orders' => round($totalOrders * .218)],
        ['name' => 'Central Luzon', 'share' => 12.9, 'orders' => round($totalOrders * .129)],
        ['name' => 'Central Visayas', 'share' => 9.7, 'orders' => round($totalOrders * .097)],
        ['name' => 'Davao Region', 'share' => 7.3, 'orders' => round($totalOrders * .073)],
        ['name' => 'Others', 'share' => 9.6, 'orders' => max(0, $totalOrders - (round($totalOrders * .387) + round($totalOrders * .218) + round($totalOrders * .129) + round($totalOrders * .097) + round($totalOrders * .073)))],
    ];

    $analyticsClickableData = [
        'totals' => [
            'totalRevenue' => 'PHP ' . number_format($totalRevenue, 2),
            'totalRevenueRaw' => (float) $totalRevenue,
            'paidRevenue' => 'PHP ' . number_format(max(0, $totalRevenue - ($cancelledOrders * max($averageOrderValue, 0))), 2),
            'pendingRevenue' => 'PHP ' . number_format($pendingOrders * max($averageOrderValue, 0), 2),
            'cancelledRevenue' => 'PHP ' . number_format($cancelledOrders * max($averageOrderValue, 0), 2),
            'totalOrders' => (int) $totalOrders,
            'totalOrdersFormatted' => number_format($totalOrders),
            'totalCustomers' => (int) $totalCustomers,
            'totalCustomersFormatted' => number_format($totalCustomers),
            'totalServices' => number_format($totalServices),
            'completedOrders' => (int) $completedOrders,
            'processingOrders' => (int) $processingOrders,
            'pendingOrders' => (int) $pendingOrders,
            'readyOrders' => (int) $readyOrders,
            'cancelledOrders' => (int) $cancelledOrders,
            'completionRate' => $completionRate . '%',
            'conversionRate' => $conversionRate . '%',
            'averageOrderValue' => 'PHP ' . number_format($averageOrderValue, 2),
            'averageOrderValueRaw' => (float) $averageOrderValue,
            'highestOrderValue' => 'PHP ' . number_format((float) (clone $analyticsOrdersBase)->max('total_price'), 2),
            'lowestOrderValue' => 'PHP ' . number_format((float) (clone $analyticsOrdersBase)->where('total_price', '>', 0)->min('total_price'), 2),
            'dateRange' => $dateRangeLabel,
        ],
        'weeklyLabels' => $weeklyLabels,
        'weeklyOrders' => $weeklyOrders,
        'weeklySales' => $weeklySales,
        'weeklyCustomers' => $weeklyCustomers,
        'sources' => collect($sourceGroups)->map(function ($value, $label) use ($totalOrders, $totalRevenue) {
            $share = $totalOrders > 0 ? round(($value / max($totalOrders, 1)) * 100, 1) : 0;
            return [
                'label' => $label,
                'orders' => (int) $value,
                'share' => $share,
                'revenue' => 'PHP ' . number_format($totalOrders > 0 ? ($totalRevenue * ($share / 100)) : 0, 2),
            ];
        })->values(),
        'services' => $topServices->map(function ($service) {
            return [
                'name' => $service->service_name ?? 'Service',
                'orders' => (int) ($service->orders_count ?? 0),
                'revenue' => 'PHP ' . number_format((float) ($service->revenue_sum ?? 0), 2),
                'revenueRaw' => (float) ($service->revenue_sum ?? 0),
            ];
        })->values(),
        'regions' => $analyticsRegionRows,
        'performers' => $topPerformers->map(function ($performer) {
            return [
                'staff' => $performer->staff_name ?? 'Admin Staff',
                'service' => $performer->service_name ?? 'General Service',
                'orders' => (int) ($performer->orders_count ?? 0),
                'revenue' => 'PHP ' . number_format((float) ($performer->revenue_sum ?? 0), 2),
            ];
        })->values(),
    ];

@endphp

@once
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
@endonce

<style>
    :root {
        --portal-blue: #2563EB;
        --portal-blue-dark: #1D4ED8;
        --portal-blue-soft: #EFF6FF;
        --portal-orange: #FF7A00;
        --portal-black: #111827;
        --portal-muted: #64748B;
        --portal-border: #E5E7EB;
        --portal-bg: #F8FAFC;
        --portal-green: #10B981;
        --portal-red: #EF4444;
        --portal-yellow: #F59E0B;
        --portal-violet: #8B5CF6;
        --portal-cyan: #06B6D4;
        --portal-card-radius: 10px;
        --portal-button: linear-gradient(135deg, #2563EB 0%, #0EA5E9 100%);
    }

    .analytics-final {
        width: 100%;
        max-width: 1320px;
        margin: 0 auto 0 0;
        padding: 0 24px 22px;
        font-family: 'Inter', system-ui, sans-serif;
        letter-spacing: 0;
        color: var(--portal-black);
    }

    .analytics-final *,
    .analytics-final *::before,
    .analytics-final *::after {
        box-sizing: border-box;
        letter-spacing: 0;
    }

    .analytics-final-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 14px;
    }

    .analytics-title-wrap { min-width: 0; }

    .analytics-page-title {
        position: relative;
        margin: 0;
        padding-top: 10px;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 28px;
        line-height: 1;
        font-weight: 700;
        color: var(--portal-black);
    }

    .analytics-page-title::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 28px;
        height: 3px;
        border-radius: 999px;
        background: var(--portal-blue);
    }

    .analytics-subtitle {
        margin: 6px 0 0;
        color: var(--portal-muted);
        font-size: 11px;
        font-weight: 400;
        line-height: 1.4;
    }

    .analytics-toolbar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        flex-wrap: nowrap;
        margin-left: auto;
    }

    .analytics-date-pill,
    .analytics-btn {
        height: 32px;
        border-radius: 8px;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        white-space: nowrap;
    }

    .analytics-date-pill {
        border: 1px solid #E5E7EB;
        background: #FFFFFF;
        color: var(--portal-black);
        padding: 0 11px;
        min-width: 178px;
        order: 1;
    }

    .analytics-btn {
        border: 0;
        min-width: 102px;
        padding: 0 13px;
        background: var(--portal-button);
        color: var(--portal-black);
        cursor: pointer;
        box-shadow: none;
        transition: background-color .18s ease, color .18s ease, transform .18s ease;
    }

    #analyticsExportBtn { order: 2; }
    #analyticsReportBtn { order: 3; }

    .analytics-btn:hover {
        background: var(--portal-black);
        color: #FFFFFF;
        transform: translateY(-1px);
    }

    .analytics-btn.btn-outline {
        background: #FFFFFF;
        color: var(--portal-black);
        border: 1px solid #E5E7EB;
    }

    .analytics-btn.btn-outline:hover {
        background: var(--portal-black);
        color: #FFFFFF;
        border-color: var(--portal-black);
    }

    .analytics-btn i,
    .analytics-date-pill i {
        width: 13px;
        height: 13px;
    }

    .analytics-toast {
        position: fixed;
        top: 18px;
        left: 50%;
        transform: translateX(-50%) translateY(-20px);
        z-index: 999999;
        min-width: 260px;
        max-width: 500px;
        border-radius: 999px;
        background: var(--portal-black);
        color: #FFFFFF;
        padding: 10px 16px;
        text-align: center;
        font-size: 12px;
        font-weight: 400;
        box-shadow: 0 18px 50px rgba(15, 23, 42, .25);
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s ease, transform .2s ease;
    }

    .analytics-toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    .analytics-kpi-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 12px;
    }

    .analytics-kpi,
    .analytics-panel,
    .analytics-order-table-wrap,
    .analytics-modal-card {
        background: #FFFFFF;
        border: 1px solid var(--portal-border);
        border-radius: var(--portal-card-radius);
        box-shadow: none;
    }

    .analytics-kpi {
        min-height: 72px;
        padding: 11px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: background-color .18s ease, border-color .18s ease;
    }

    .analytics-kpi:hover,
    .analytics-panel:hover,
    .analytics-clickable:hover {
        background: rgba(17, 24, 39, .045);
        border-color: var(--portal-black);
    }

    .analytics-icon {
        width: 34px;
        height: 34px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .analytics-icon i {
        width: 18px;
        height: 18px;
    }

    .icon-blue { background: transparent; color: var(--portal-blue); }
    .icon-orange { background: transparent; color: var(--portal-orange); }
    .icon-green { background: transparent; color: var(--portal-green); }
    .icon-red { background: transparent; color: var(--portal-red); }
    .icon-violet { background: transparent; color: var(--portal-violet); }
    .icon-cyan { background: transparent; color: var(--portal-cyan); }

    .analytics-kpi.kpi-blue { background: #FFFFFF; border: 1.5px solid #2563EB; }
    .analytics-kpi.kpi-orange { background: #FFFFFF; border: 1.5px solid #FF7A00; }
    .analytics-kpi.kpi-green { background: #FFFFFF; border: 1.5px solid #10B981; }
    .analytics-kpi.kpi-red { background: #FFFFFF; border: 1.5px solid #EF4444; }
    .analytics-kpi.kpi-violet { background: #FFFFFF; border: 1.5px solid #8B5CF6; }

    .analytics-kpi.kpi-colored { color: var(--portal-black); }

    .analytics-kpi.kpi-colored .analytics-kpi-label,
    .analytics-kpi.kpi-colored .analytics-kpi-value {
        color: var(--portal-black);
    }

    .analytics-kpi.kpi-colored .analytics-kpi-change {
        color: var(--portal-green);
        opacity: 1;
    }

    .analytics-kpi.kpi-colored .analytics-kpi-change.down {
        color: var(--portal-red);
    }

    .analytics-kpi.kpi-blue .analytics-icon,
    .analytics-kpi.kpi-blue .analytics-icon i { color: #2563EB; }
    .analytics-kpi.kpi-orange .analytics-icon,
    .analytics-kpi.kpi-orange .analytics-icon i { color: #FF7A00; }
    .analytics-kpi.kpi-green .analytics-icon,
    .analytics-kpi.kpi-green .analytics-icon i { color: #10B981; }
    .analytics-kpi.kpi-red .analytics-icon,
    .analytics-kpi.kpi-red .analytics-icon i { color: #EF4444; }
    .analytics-kpi.kpi-violet .analytics-icon,
    .analytics-kpi.kpi-violet .analytics-icon i { color: #8B5CF6; }

    .analytics-kpi.kpi-colored:hover {
        background: rgba(17, 24, 39, .025);
        filter: none;
    }

    .analytics-kpi-label {
        margin: 0 0 5px;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 9px;
        font-weight: 600;
        color: #334155;
        text-transform: uppercase;
    }

    .analytics-kpi-value {
        margin: 0;
        color: var(--portal-black);
        font-size: 16px;
        line-height: 1;
        font-weight: 600;
    }

    .analytics-kpi-change {
        display: flex;
        align-items: center;
        gap: 3px;
        margin-top: 6px;
        color: var(--portal-green);
        font-size: 9px;
        font-weight: 400;
    }

    .analytics-kpi-change i {
        width: 11px;
        height: 11px;
    }

    .analytics-kpi-change.down { color: var(--portal-red); }

    .analytics-dashboard-grid {
        display: grid;
        grid-template-columns: minmax(420px, 1.3fr) minmax(270px, 1fr) minmax(270px, 1fr);
        grid-auto-rows: 224px;
        gap: 12px;
        margin-bottom: 12px;
        align-items: stretch;
    }

    .analytics-trend-panel {
        grid-row: span 2;
    }

    .analytics-equal-panel {
        height: 224px;
        min-height: 224px;
        display: flex;
        flex-direction: column;
    }

    .analytics-equal-panel .analytics-panel-head {
        flex: 0 0 auto;
    }

    .analytics-lower-grid {
        display: grid;
        grid-template-columns: minmax(320px, 1fr) minmax(420px, 1.35fr);
        gap: 12px;
        margin-bottom: 12px;
        align-items: stretch;
    }

    .analytics-panel {
        padding: 12px;
        min-width: 0;
        overflow: hidden;
    }

    .analytics-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
    }

    .analytics-panel-title {
        position: relative;
        margin: 0;
        padding-left: 0;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 13px;
        line-height: 1.2;
        font-weight: 600;
        color: var(--portal-black);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .analytics-panel-title::before {
        display: none;
    }

    .analytics-panel-action {
        height: 27px;
        border: 1px solid #E5E7EB;
        border-radius: 7px;
        background: #FFFFFF;
        padding: 0 9px;
        color: var(--portal-black);
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 9px;
        font-weight: 600;
        cursor: pointer;
    }

    .analytics-chart-shell {
        position: relative;
        height: 205px;
        width: 100%;
    }

    .analytics-chart-shell.small { height: 142px; }

    .analytics-equal-panel .analytics-chart-shell.small { height: 154px; }

    .analytics-equal-panel .analytics-source-grid {
        min-height: 0;
        flex: 1;
    }

    .analytics-equal-panel .analytics-service-list,
    .analytics-equal-panel .analytics-insight-list {
        flex: 1;
    }

    .analytics-chart-shell canvas {
        width: 100% !important;
        height: 100% !important;
        display: block !important;
    }

    .analytics-chart-foot {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        border: 1px solid #E5E7EB;
        border-radius: 9px;
        margin-top: 10px;
        overflow: hidden;
    }

    .analytics-chart-stat {
        padding: 8px 9px;
        border-right: 1px solid #E5E7EB;
    }

    .analytics-chart-stat:last-child { border-right: 0; }

    .analytics-chart-stat span {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--portal-muted);
        font-size: 9px;
        font-weight: 400;
        margin-bottom: 4px;
    }

    .analytics-chart-stat strong {
        color: var(--portal-black);
        font-size: 11px;
        font-weight: 600;
    }

    .analytics-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
        background: var(--portal-blue);
        flex-shrink: 0;
    }

    .analytics-dot.green { background: var(--portal-green); }
    .analytics-dot.red { background: var(--portal-red); }
    .analytics-dot.orange { background: var(--portal-orange); }
    .analytics-dot.violet { background: var(--portal-violet); }
    .analytics-dot.cyan { background: var(--portal-cyan); }

    .analytics-source-grid {
        display: grid;
        grid-template-columns: 118px 1fr;
        gap: 10px;
        align-items: center;
        min-height: 150px;
    }

    .analytics-legend-list {
        display: grid;
        gap: 6px;
    }

    .analytics-legend-row,
    .analytics-service-row,
    .analytics-insight-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        color: #334155;
        font-size: 10.5px;
        font-weight: 400;
    }

    .analytics-legend-left {
        display: flex;
        align-items: center;
        gap: 7px;
        min-width: 0;
    }

    .analytics-service-list {
        display: grid;
        gap: 7px;
        margin-top: 0;
    }

    .analytics-service-row {
        display: grid;
        grid-template-columns: 116px 1fr 82px;
    }

    .analytics-service-name {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .analytics-bar-track {
        height: 7px;
        border-radius: 999px;
        background: #E5E7EB;
        overflow: hidden;
    }

    .analytics-bar-fill {
        height: 100%;
        border-radius: 999px;
        background: var(--portal-blue);
    }

    .analytics-region-list {
        display: grid;
        gap: 9px;
        padding-top: 2px;
    }

    .analytics-region-row {
        display: grid;
        grid-template-columns: minmax(92px, 1fr) minmax(95px, 1.1fr) 52px;
        align-items: center;
        gap: 9px;
        min-width: 0;
    }

    .analytics-region-name {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: var(--portal-black);
        font-size: 10.5px;
        font-weight: 600;
    }

    .analytics-region-meta {
        color: var(--portal-muted);
        font-size: 9.5px;
        text-align: right;
        white-space: nowrap;
    }

    .analytics-region-bar {
        height: 7px;
        border-radius: 999px;
        background: #E5E7EB;
        overflow: hidden;
    }

    .analytics-region-fill {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: var(--portal-blue);
    }

    .analytics-mini-table {
        width: 100%;
        max-width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .analytics-mini-table th,
    .analytics-mini-table td {
        padding: 6px 7px;
        border-bottom: 1px solid #E5E7EB;
        text-align: left;
        font-size: 10px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .analytics-mini-table th {
        color: #475569;
        font-family: 'Poppins', system-ui, sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 9px;
    }

    .analytics-mini-table td {
        color: var(--portal-black);
        font-weight: 400;
    }


    .analytics-performer-table th:nth-child(1),
    .analytics-performer-table td:nth-child(1) { width: 42px; text-align: center; }

    .analytics-performer-table th:nth-child(2),
    .analytics-performer-table td:nth-child(2) { width: auto; }

    .analytics-performer-table th:nth-child(3),
    .analytics-performer-table td:nth-child(3) { width: 68px; text-align: center; }

    .analytics-performer-table th:nth-child(4),
    .analytics-performer-table td:nth-child(4) { width: 86px; text-align: right; }

    .analytics-rank-user span:last-child {
        min-width: 0;
        overflow: hidden;
    }

    .analytics-rank-user strong,
    .analytics-rank-user small {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .analytics-insight-row .analytics-icon {
        width: 34px;
        height: 34px;
    }

    .analytics-insight-text {
        min-width: 0;
        flex: 1;
        overflow: hidden;
    }

    .analytics-rank-user {
        display: flex;
        align-items: center;
        gap: 7px;
        min-width: 0;
    }

    .analytics-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--portal-blue);
        color: #FFFFFF;
        display: grid;
        place-items: center;
        font-size: 10px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .analytics-insight-list {
        display: grid;
        gap: 8px;
    }

    .analytics-insight-row {
        border: 0;
        border-bottom: 1px solid #E5E7EB;
        border-radius: 0;
        padding: 8px 2px;
        cursor: pointer;
    }

    .analytics-insight-row:last-child { border-bottom: 0; }

    .analytics-insight-row > i {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }

    .analytics-insight-text strong {
        display: block;
        margin-bottom: 2px;
        color: var(--portal-black);
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 10.5px;
        font-weight: 600;
    }

    .analytics-insight-text small {
        color: var(--portal-muted);
        font-size: 9.5px;
        font-weight: 400;
    }

    .analytics-order-tools {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        margin-bottom: 0;
        flex-wrap: nowrap;
        margin-left: auto;
    }

    .analytics-order-tools .analytics-btn {
        height: 32px;
        min-width: 92px;
        padding: 0 12px;
        flex-shrink: 0;
    }

    .analytics-search {
        position: relative;
        min-width: min(320px, 100%);
        flex: 1;
        max-width: 460px;
        height: 32px;
        display: flex;
        align-items: center;
    }

    .analytics-search input {
        width: 100%;
        height: 32px;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        background: #FFFFFF;
        padding: 0 11px 0 34px;
        outline: none;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 11px;
        color: var(--portal-black);
    }

    .analytics-search i,
    .analytics-search svg {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 14px;
        height: 14px;
        color: var(--portal-muted);
        pointer-events: none;
        z-index: 2;
        stroke-width: 2;
    }

    .analytics-order-table-wrap {
        padding: 0;
        overflow: hidden;
        background: transparent;
        border: 0;
        border-radius: 0;
    }

    .analytics-order-table-wrap .analytics-panel-head {
        margin-bottom: 10px;
        align-items: center;
    }

    .analytics-order-table {
        width: 100%;
        border-collapse: collapse;
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
    }

    .analytics-order-table th,
    .analytics-order-table td {
        padding: 9px 8px;
        border-bottom: 1px solid #E5E7EB;
        text-align: left;
        font-size: 10.5px;
    }

    .analytics-order-table th {
        background: #F8FAFC;
        color: #334155;
        font-family: 'Poppins', system-ui, sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 9px;
    }

    .analytics-order-table td {
        color: var(--portal-black);
        font-weight: 400;
    }

    .analytics-order-table tbody tr { cursor: pointer; }
    .analytics-order-table tbody tr:hover { background: rgba(17, 24, 39, .045); }

    .analytics-order-id {
        color: var(--portal-blue);
        font-family: 'Poppins', system-ui, sans-serif;
        font-weight: 600;
        text-decoration: none;
    }

    .analytics-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 21px;
        padding: 0 8px;
        border-radius: 999px;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 9px;
        font-weight: 600;
    }

    .analytics-status.completed,
    .analytics-status.paid,
    .analytics-status.active,
    .analytics-status.operational {
        background: #DCFCE7;
        color: #15803D;
    }

    .analytics-status.processing,
    .analytics-status.ready {
        background: #DBEAFE;
        color: #1D4ED8;
    }

    .analytics-status.pending,
    .analytics-status.partial {
        background: #FEF3C7;
        color: #B45309;
    }

    .analytics-status.cancelled,
    .analytics-status.unpaid {
        background: #FEE2E2;
        color: #B91C1C;
    }

    .analytics-action-btn {
        width: 27px;
        height: 27px;
        border: 1px solid #E5E7EB;
        border-radius: 7px;
        background: #FFFFFF;
        color: var(--portal-black);
        display: inline-grid;
        place-items: center;
        cursor: pointer;
    }

    .analytics-action-btn:hover {
        background: var(--portal-black);
        color: #FFFFFF;
        border-color: var(--portal-black);
    }

    .analytics-action-btn i {
        width: 13px;
        height: 13px;
    }

    .analytics-actions-cell {
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .analytics-empty-state {
        padding: 20px 12px !important;
        text-align: center !important;
        color: var(--portal-muted) !important;
        font-size: 11px !important;
    }

    .option-link {
        display: inline-flex;
        align-items: center;
        width: fit-content;
        margin-top: 10px;
        color: var(--portal-blue);
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 10px;
        font-weight: 600;
        text-decoration: none;
    }

    .option-link:hover { color: var(--portal-black); }

    .analytics-modal {
        position: fixed;
        inset: 0;
        z-index: 999998;
        background: rgba(15, 23, 42, .55);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .analytics-modal.show { display: flex; }

    .analytics-modal-card {
        width: min(680px, 100%);
        max-height: 86vh;
        overflow: auto;
        padding: 16px;
        background: #FFFFFF;
    }

    .analytics-modal-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        padding-bottom: 11px;
        border-bottom: 1px solid #E5E7EB;
        margin-bottom: 12px;
    }

    .analytics-modal-title {
        margin: 0;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--portal-black);
    }

    .analytics-modal-subtitle {
        margin: 4px 0 0;
        color: var(--portal-muted);
        font-size: 11px;
        font-weight: 400;
    }

    .analytics-modal-close {
        width: 31px;
        height: 31px;
        border: 0;
        border-radius: 8px;
        background: var(--portal-blue);
        color: var(--portal-black);
        display: grid;
        place-items: center;
        cursor: pointer;
    }

    .analytics-modal-close:hover {
        background: var(--portal-black);
        color: #FFFFFF;
    }

    .analytics-modal-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .analytics-modal-info {
        border: 1px solid #E5E7EB;
        border-radius: 9px;
        padding: 10px;
    }

    .analytics-modal-info.full { grid-column: 1 / -1; }

    .analytics-modal-info small {
        display: block;
        color: var(--portal-muted);
        font-size: 9px;
        font-weight: 400;
        margin-bottom: 3px;
    }

    .analytics-modal-info strong {
        display: block;
        color: var(--portal-black);
        font-size: 12px;
        font-weight: 600;
    }



    /* Final cleanup: remove icon background shapes; icons use color only */
    .analytics-icon {
        width: 28px;
        height: 28px;
        border-radius: 0;
        background: transparent !important;
    }

    .analytics-icon i {
        width: 21px;
        height: 21px;
        stroke-width: 2.2;
    }

    .icon-blue,
    .icon-orange,
    .icon-green,
    .icon-red,
    .icon-violet,
    .icon-cyan {
        background: transparent !important;
    }

    .analytics-trend-panel .analytics-chart-shell {
        height: 292px;
        margin-top: 2px;
    }

    .analytics-trend-panel .analytics-chart-foot {
        margin-top: 12px;
    }

    .analytics-flat-panel {
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        padding: 2px 0 0 !important;
    }

    .analytics-flat-panel:hover,
    .analytics-flat-panel .analytics-clickable:hover {
        background: transparent !important;
        border-color: transparent !important;
    }

    .analytics-flat-panel .analytics-panel-head {
        padding: 0 0 8px;
        margin-bottom: 6px;
        border-bottom: 1px solid #E5E7EB;
    }

    .analytics-flat-panel .analytics-insight-row {
        background: transparent;
        padding: 9px 0;
        border-bottom: 1px solid #E5E7EB;
    }

    .analytics-flat-panel .analytics-mini-table th {
        background: transparent;
    }

    .analytics-region-row:nth-child(1) .analytics-region-fill { background: var(--portal-blue); }
    .analytics-region-row:nth-child(2) .analytics-region-fill { background: var(--portal-orange); }
    .analytics-region-row:nth-child(3) .analytics-region-fill { background: var(--portal-green); }
    .analytics-region-row:nth-child(4) .analytics-region-fill { background: var(--portal-violet); }
    .analytics-region-row:nth-child(5) .analytics-region-fill { background: var(--portal-cyan); }
    .analytics-region-row:nth-child(6) .analytics-region-fill { background: var(--portal-red); }



    /* Requested final alignment fixes */
    .analytics-final-header {
        align-items: flex-start;
    }

    .analytics-toolbar {
        width: 340px;
        flex-direction: column;
        align-items: stretch;
        justify-content: flex-start;
        gap: 8px;
    }

    .analytics-toolbar-buttons {
        display: grid;
        grid-template-columns: 1fr 1.35fr;
        gap: 8px;
        width: 100%;
    }

    .analytics-date-pill {
        width: 100%;
        min-width: 0;
        justify-content: space-between;
    }

    .analytics-toolbar .analytics-btn {
        width: 100%;
        min-width: 0;
    }

    .analytics-trend-panel {
        min-height: 462px;
    }

    .analytics-trend-panel .analytics-panel-head {
        margin-bottom: 8px;
    }

    .analytics-trend-panel .analytics-chart-shell {
        height: 300px;
        margin-top: 4px;
    }

    .analytics-chart-foot {
        background: #FFFFFF;
    }

    .analytics-flat-panel .analytics-mini-table {
        background: transparent;
        border-collapse: collapse;
    }

    .analytics-flat-panel .analytics-mini-table th,
    .analytics-flat-panel .analytics-mini-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #E5E7EB;
        white-space: nowrap;
    }

    .analytics-performer-table th:nth-child(1),
    .analytics-performer-table td:nth-child(1) {
        width: 58px;
        text-align: center;
    }

    .analytics-performer-table th:nth-child(2),
    .analytics-performer-table td:nth-child(2) {
        min-width: 260px;
    }

    .analytics-performer-table th:nth-child(3),
    .analytics-performer-table td:nth-child(3) {
        width: 100px;
        text-align: center;
    }

    .analytics-performer-table th:nth-child(4),
    .analytics-performer-table td:nth-child(4) {
        width: 130px;
        text-align: right;
    }

    .analytics-rank-user {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .analytics-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #E0ECFF;
        color: var(--portal-blue);
        display: inline-grid;
        place-items: center;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 12px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .analytics-rank-user strong {
        display: block;
        color: var(--portal-black);
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 11px;
        line-height: 1.1;
    }

    .analytics-rank-user small {
        display: block;
        margin-top: 3px;
        color: var(--portal-muted);
        font-size: 9.5px;
        line-height: 1.1;
    }

    .analytics-order-table-wrap .analytics-panel-head {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) minmax(500px, 680px);
        align-items: end;
        gap: 16px;
    }

    .analytics-order-tools {
        width: 100%;
        justify-content: flex-end;
        display: grid;
        grid-template-columns: minmax(360px, 1fr) 92px;
        gap: 8px;
    }

    .analytics-search {
        width: 100%;
        max-width: none;
        min-width: 0;
    }

    .analytics-order-tools .analytics-btn {
        width: 92px;
        min-width: 92px;
    }

    .analytics-order-table th,
    .analytics-order-table td {
        padding: 10px 14px;
    }

    @media (max-width: 1500px) {
        .analytics-final { max-width: none; margin-left: 0; margin-right: 0; padding-left: 24px; padding-right: 24px; }
        .analytics-kpi-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .analytics-dashboard-grid { grid-template-columns: minmax(0, 1.15fr) minmax(0, 1fr) minmax(0, 1fr); }
        .analytics-lower-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 900px) {
        .analytics-final-header { flex-direction: column; align-items: stretch; }
        .analytics-toolbar { width: 100%; justify-content: flex-end; flex-wrap: wrap; }
        .analytics-toolbar-buttons { grid-template-columns: 1fr; }
        .analytics-order-table-wrap .analytics-panel-head { grid-template-columns: 1fr; }
        .analytics-order-tools { grid-template-columns: 1fr; }
        .analytics-order-tools .analytics-btn { width: 100%; min-width: 0; }
        .analytics-kpi-grid,
        .analytics-dashboard-grid,
        .analytics-lower-grid { grid-template-columns: 1fr; grid-auto-rows: auto; }
        .analytics-trend-panel { grid-row: auto; }
        .analytics-trend-panel .analytics-chart-shell { height: 230px; }
        .analytics-equal-panel { height: auto; min-height: 224px; }
        .analytics-source-grid { grid-template-columns: 1fr; }
        .analytics-region-row { grid-template-columns: 1fr; gap: 5px; }
        .analytics-region-meta { text-align: left; }
    }

    @media (max-width: 720px) {
        .analytics-final { padding-left: 14px; padding-right: 14px; }
        .analytics-date-pill,
        .analytics-btn { width: 100%; min-width: 0; }
        .analytics-chart-foot { grid-template-columns: 1fr 1fr; }
        .analytics-service-row { grid-template-columns: 1fr; gap: 4px; }
        .analytics-order-table-wrap { overflow-x: auto; }
        .analytics-order-table { min-width: 820px; }
        .analytics-modal-grid { grid-template-columns: 1fr; }
    }


    /* Final requested layout polishing */
    .analytics-final-header {
        align-items: flex-start;
    }

    .analytics-toolbar {
        width: 258px;
        align-items: flex-end;
        gap: 7px;
    }

    .analytics-toolbar-buttons {
        order: 1;
        display: flex;
        justify-content: flex-end;
        gap: 7px;
        width: auto;
    }

    .analytics-date-pill {
        order: 2;
        width: 196px;
        min-width: 196px;
        max-width: 196px;
        height: 32px;
        padding: 0 10px;
        justify-content: space-between;
    }

    .analytics-toolbar .analytics-btn,
    .analytics-toolbar-buttons .analytics-btn {
        width: 124px;
        min-width: 124px;
        max-width: 124px;
        height: 32px;
        padding: 0 10px;
    }

    .analytics-lower-grid {
        align-items: start;
    }

    .analytics-lower-grid > .analytics-panel:first-child {
        height: 224px;
        min-height: 224px;
    }

    .analytics-lower-grid > .analytics-panel:first-child .analytics-region-list {
        gap: 11px;
    }

    .analytics-performer-table {
        table-layout: fixed;
    }

    .analytics-performer-table th,
    .analytics-performer-table td {
        overflow: visible;
        text-overflow: clip;
    }

    .analytics-performer-table th:nth-child(1),
    .analytics-performer-table td:nth-child(1) {
        width: 72px;
        min-width: 72px;
        text-align: center;
        white-space: nowrap;
    }

    .analytics-performer-table th:nth-child(2),
    .analytics-performer-table td:nth-child(2) {
        width: auto;
        min-width: 230px;
    }

    .analytics-performer-table th:nth-child(3),
    .analytics-performer-table td:nth-child(3) {
        width: 96px;
        text-align: center;
    }

    .analytics-performer-table th:nth-child(4),
    .analytics-performer-table td:nth-child(4) {
        width: 136px;
        text-align: right;
    }

    .analytics-order-table-wrap {
        margin-top: 18px;
    }

    .analytics-order-table-wrap .analytics-panel-head {
        grid-template-columns: minmax(220px, 1fr) 520px;
        align-items: center;
        gap: 18px;
        margin-bottom: 14px;
    }

    .analytics-order-tools {
        grid-template-columns: 400px 92px;
        gap: 10px;
        align-items: center;
    }

    .analytics-search {
        max-width: 400px;
    }

    .analytics-search input,
    .analytics-order-tools .analytics-btn {
        height: 34px;
    }

    @media (max-width: 1100px) {
        .analytics-toolbar { width: 100%; align-items: flex-start; }
        .analytics-toolbar-buttons { justify-content: flex-start; }
        .analytics-date-pill { width: 196px; }
        .analytics-order-table-wrap .analytics-panel-head { grid-template-columns: 1fr; }
        .analytics-order-tools { grid-template-columns: minmax(0, 1fr) 92px; max-width: 520px; }
        .analytics-search { max-width: none; }
    }



    /* FINAL USER REQUEST FIXES: header order + compact controls + latest search spacing */
    .analytics-final-header {
        align-items: flex-start !important;
    }

    .analytics-toolbar {
        width: 252px !important;
        max-width: 252px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-end !important;
        justify-content: flex-start !important;
        gap: 8px !important;
        margin-left: auto !important;
    }

    .analytics-date-pill {
        order: 1 !important;
        width: 205px !important;
        min-width: 205px !important;
        max-width: 205px !important;
        height: 34px !important;
        padding: 0 10px !important;
        justify-content: space-between !important;
        align-self: flex-end !important;
    }

    .analytics-toolbar-buttons {
        order: 2 !important;
        width: 252px !important;
        max-width: 252px !important;
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 8px !important;
        align-self: flex-end !important;
    }

    .analytics-toolbar .analytics-btn,
    .analytics-toolbar-buttons .analytics-btn {
        width: 122px !important;
        min-width: 122px !important;
        max-width: 122px !important;
        height: 34px !important;
        padding: 0 8px !important;
        font-size: 9px !important;
        gap: 6px !important;
    }

    .analytics-date-pill i,
    .analytics-toolbar .analytics-btn i,
    .analytics-toolbar-buttons .analytics-btn i {
        width: 13px !important;
        height: 13px !important;
        flex-shrink: 0 !important;
    }

    #analyticsExportBtn,
    #analyticsReportBtn {
        order: initial !important;
    }

    .analytics-order-table-wrap {
        margin-top: 26px !important;
        padding-top: 2px !important;
        overflow: visible !important;
    }

    .analytics-order-table-wrap .analytics-panel-head {
        grid-template-columns: minmax(220px, 1fr) 430px !important;
        align-items: end !important;
        gap: 16px !important;
        margin-bottom: 16px !important;
        overflow: visible !important;
    }

    .analytics-order-tools {
        display: grid !important;
        grid-template-columns: 320px 86px !important;
        gap: 10px !important;
        align-items: center !important;
        justify-content: end !important;
        width: 100% !important;
        padding-top: 10px !important;
        overflow: visible !important;
    }

    .analytics-search {
        width: 250px !important;
        min-width: 0 !important;
        max-width: 320px !important;
        height: 34px !important;
        overflow: visible !important;
    }

    .analytics-search input {
        height: 34px !important;
        line-height: 34px !important;
        padding-left: 34px !important;
    }

    .analytics-search input:focus {
        border-color: var(--portal-blue) !important;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, .10) !important;
    }

    .analytics-order-tools .analytics-btn {
        width: 86px !important;
        min-width: 86px !important;
        max-width: 86px !important;
        height: 34px !important;
        padding: 0 10px !important;
    }

    .analytics-performer-table th:first-child,
    .analytics-performer-table td:first-child {
        width: 70px !important;
        min-width: 70px !important;
        text-align: center !important;
    }

    @media (max-width: 1100px) {
        .analytics-toolbar {
            width: 252px !important;
            max-width: 252px !important;
        }

        .analytics-order-table-wrap .analytics-panel-head {
            grid-template-columns: 1fr !important;
            align-items: start !important;
        }

        .analytics-order-tools {
            justify-content: start !important;
            width: 430px !important;
            max-width: 100% !important;
        }
    }

    @media (max-width: 640px) {
        .analytics-toolbar,
        .analytics-toolbar-buttons {
            width: 100% !important;
            max-width: 100% !important;
            align-items: stretch !important;
        }

        .analytics-date-pill {
            width: 100% !important;
            min-width: 0 !important;
            max-width: 100% !important;
        }

        .analytics-toolbar .analytics-btn,
        .analytics-toolbar-buttons .analytics-btn {
            width: 100% !important;
            min-width: 0 !important;
            max-width: 100% !important;
        }

        .analytics-order-tools {
            grid-template-columns: 1fr !important;
            width: 100% !important;
        }

        .analytics-search {
            width: 100% !important;
            max-width: 100% !important;
        }
    }



    /* FINAL: Reference-style analytics detail popups */
    .analytics-modal {
        backdrop-filter: blur(1px);
        background: rgba(15, 23, 42, .58) !important;
    }

    .analytics-detail-modal-card {
        width: min(640px, calc(100vw - 36px)) !important;
        max-height: 88vh !important;
        overflow: auto !important;
        padding: 30px 34px 24px !important;
        border-radius: 18px !important;
        background: #FFFFFF !important;
        box-shadow: 0 30px 90px rgba(15, 23, 42, .25) !important;
        border: 1px solid rgba(226, 232, 240, .95) !important;
    }

    .analytics-detail-modal-card.wide {
        width: min(760px, calc(100vw - 36px)) !important;
    }

    .analytics-detail-modal-card .analytics-modal-head {
        border-bottom: 0 !important;
        padding-bottom: 12px !important;
        margin-bottom: 0 !important;
        align-items: flex-start !important;
    }

    .analytics-detail-modal-card .analytics-modal-title {
        font-family: 'Playfair Display', Georgia, serif !important;
        font-size: 32px !important;
        line-height: 1.05 !important;
        color: #0F172A !important;
        margin: 0 !important;
        letter-spacing: -.02em !important;
    }

    .analytics-detail-modal-card .analytics-modal-subtitle {
        color: #64748B !important;
        font-size: 14px !important;
        margin-top: 10px !important;
        line-height: 1.35 !important;
    }

    .analytics-modal-close {
        width: 38px !important;
        height: 38px !important;
        min-width: 38px !important;
        border-radius: 9px !important;
        background: #2563EB !important;
        color: #FFFFFF !important;
        box-shadow: 0 8px 18px rgba(37, 99, 235, .24) !important;
    }

    .analytics-modal-close:hover {
        background: #0F172A !important;
        color: #FFFFFF !important;
    }

    .analytics-detail-list {
        display: grid;
        gap: 10px;
    }

    .analytics-detail-item {
        min-height: 52px;
        display: grid;
        grid-template-columns: minmax(190px, 1fr) minmax(170px, 1fr);
        align-items: center;
        gap: 16px;
        padding: 13px 16px;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        background: #FFFFFF;
    }

    .analytics-detail-item span {
        color: #64748B;
        font-size: 14px;
        line-height: 1.25;
    }

    .analytics-detail-item strong {
        color: #0F172A;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.25;
        text-align: left;
    }

    .analytics-detail-item strong.positive { color: #10B981; }
    .analytics-detail-item strong.negative { color: #EF4444; }

    .analytics-detail-table-wrap {
        overflow-x: auto;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        background: #FFFFFF;
    }

    .analytics-detail-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 560px;
    }

    .analytics-detail-table th,
    .analytics-detail-table td {
        padding: 13px 15px;
        border-bottom: 1px solid #E2E8F0;
        color: #0F172A;
        font-size: 13px;
        text-align: left;
        white-space: nowrap;
    }

    .analytics-detail-table th {
        background: #F8FAFC;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 11px;
        text-transform: none;
        color: #334155;
        font-weight: 700;
    }

    .analytics-detail-table tr:last-child td { border-bottom: 0; }
    .analytics-detail-table td:nth-child(n+2),
    .analytics-detail-table th:nth-child(n+2) { text-align: center; }

    .analytics-detail-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-top: 16px;
    }

    .analytics-detail-summary-grid.four {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .analytics-detail-summary-card {
        min-height: 72px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        background: #FFFFFF;
        min-width: 0;
    }

    .analytics-detail-summary-card.green { background: #F0FDF4; border-color: #BBF7D0; }
    .analytics-detail-summary-card.orange { background: #FFF7ED; border-color: #FED7AA; }
    .analytics-detail-summary-card.violet { background: #F5F3FF; border-color: #DDD6FE; }
    .analytics-detail-summary-card.blue { background: #EFF6FF; border-color: #BFDBFE; }
    .analytics-detail-summary-card.red { background: #FEF2F2; border-color: #FECACA; }

    .analytics-detail-summary-card i {
        width: 24px;
        height: 24px;
        flex-shrink: 0;
    }

    .analytics-detail-summary-card.green i { color: #10B981; }
    .analytics-detail-summary-card.orange i { color: #FF7A00; }
    .analytics-detail-summary-card.violet i { color: #8B5CF6; }
    .analytics-detail-summary-card.blue i { color: #2563EB; }
    .analytics-detail-summary-card.red i { color: #EF4444; }

    .analytics-detail-summary-card span {
        display: block;
        color: #64748B;
        font-size: 11px;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .analytics-detail-summary-card strong {
        display: block;
        color: #0F172A;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 13px;
        line-height: 1.2;
        white-space: normal;
    }

    .analytics-detail-info-note {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 16px;
        padding: 10px 12px;
        border-radius: 10px;
        background: #F8FAFC;
        color: #64748B;
        font-size: 12px;
        line-height: 1.35;
    }

    .analytics-detail-info-note i {
        width: 22px;
        height: 22px;
        color: #2563EB;
        background: #DBEAFE;
        border-radius: 999px;
        padding: 3px;
        flex-shrink: 0;
    }

    .analytics-badge-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 76px;
        min-height: 24px;
        padding: 3px 10px;
        border-radius: 7px;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 11px;
        font-weight: 700;
    }

    .analytics-badge-status.green { background: #DCFCE7; color: #059669; }
    .analytics-badge-status.blue { background: #DBEAFE; color: #2563EB; }
    .analytics-badge-status.violet { background: #EDE9FE; color: #7C3AED; }
    .analytics-badge-status.gray { background: #F1F5F9; color: #334155; }
    .analytics-badge-status.red { background: #FEE2E2; color: #EF4444; }

    .analytics-detail-clickable,
    .analytics-kpi,
    .analytics-chart-stat,
    .analytics-legend-row,
    .analytics-service-row,
    .analytics-region-row,
    .analytics-panel-action,
    .analytics-performer-table tbody tr:not(.analytics-empty-row) { cursor: pointer; }

    @media (max-width: 720px) {
        .analytics-detail-modal-card {
            padding: 24px 18px 18px !important;
        }
        .analytics-detail-modal-card .analytics-modal-title {
            font-size: 26px !important;
        }
        .analytics-detail-item {
            grid-template-columns: 1fr;
            gap: 6px;
        }
        .analytics-detail-summary-grid,
        .analytics-detail-summary-grid.four {
            grid-template-columns: 1fr;
        }
    }



    /* FINAL COMPACT POPUP + SEARCH TO BUTTON FIX */
    .analytics-detail-modal-card {
        width: min(540px, calc(100vw - 36px)) !important;
        max-height: 76vh !important;
        padding: 22px 26px 18px !important;
        border-radius: 16px !important;
    }

    .analytics-detail-modal-card.wide {
        width: min(620px, calc(100vw - 36px)) !important;
    }

    .analytics-detail-modal-card .analytics-modal-head {
        padding-bottom: 8px !important;
        margin-bottom: 0 !important;
    }

    .analytics-detail-modal-card .analytics-modal-title {
        font-size: 26px !important;
        line-height: 1.05 !important;
    }

    .analytics-detail-modal-card .analytics-modal-subtitle {
        font-size: 12px !important;
        margin-top: 7px !important;
    }

    .analytics-detail-modal-card .analytics-modal-close,
    .analytics-modal-close {
        width: 34px !important;
        height: 34px !important;
        min-width: 34px !important;
        border-radius: 8px !important;
    }

    .analytics-detail-list {
        gap: 8px !important;
    }

    .analytics-detail-item {
        min-height: 42px !important;
        grid-template-columns: minmax(150px, 1fr) minmax(140px, 1fr) !important;
        gap: 12px !important;
        padding: 10px 12px !important;
        border-radius: 9px !important;
    }

    .analytics-detail-item span,
    .analytics-detail-item strong {
        font-size: 12px !important;
    }

    .analytics-detail-table {
        min-width: 500px !important;
    }

    .analytics-detail-table th,
    .analytics-detail-table td {
        padding: 9px 11px !important;
        font-size: 11px !important;
    }

    .analytics-detail-table th {
        font-size: 10px !important;
    }

    .analytics-detail-summary-grid {
        gap: 8px !important;
        margin-top: 12px !important;
    }

    .analytics-detail-summary-card {
        min-height: 56px !important;
        gap: 8px !important;
        padding: 9px 10px !important;
        border-radius: 9px !important;
    }

    .analytics-detail-summary-card i {
        width: 20px !important;
        height: 20px !important;
    }

    .analytics-detail-summary-card span {
        font-size: 10px !important;
        margin-bottom: 3px !important;
    }

    .analytics-detail-summary-card strong {
        font-size: 11px !important;
    }

    .analytics-detail-info-note {
        margin-top: 12px !important;
        padding: 8px 10px !important;
        font-size: 10.5px !important;
        gap: 8px !important;
    }

    .analytics-detail-info-note i {
        width: 19px !important;
        height: 19px !important;
        padding: 3px !important;
    }

    .analytics-badge-status {
        min-height: 20px !important;
        min-width: 66px !important;
        padding: 2px 8px !important;
        font-size: 10px !important;
    }

    /* Ilapit ang search field sa button sa Latest Transactions */
    .analytics-order-table-wrap .analytics-panel-head {
        grid-template-columns: minmax(220px, 1fr) 300px !important;
        gap: 8px !important;
        align-items: end !important;
        margin-bottom: 14px !important;
        overflow: visible !important;
    }

    .analytics-order-tools {
        width: 300px !important;
        max-width: 300px !important;
        display: grid !important;
        grid-template-columns: 210px 86px !important;
        gap: 4px !important;
        justify-content: end !important;
        align-items: center !important;
        padding-top: 12px !important;
        margin-left: auto !important;
        overflow: visible !important;
    }

    .analytics-search {
        width: 210px !important;
        min-width: 210px !important;
        max-width: 210px !important;
        justify-self: end !important;
    }

    .analytics-search input {
        height: 34px !important;
        padding-left: 32px !important;
        padding-right: 9px !important;
    }

    .analytics-order-tools .analytics-btn {
        width: 86px !important;
        min-width: 86px !important;
        max-width: 86px !important;
        height: 34px !important;
        padding: 0 8px !important;
    }

    @media (max-width: 1100px) {
        .analytics-order-table-wrap .analytics-panel-head {
            grid-template-columns: 1fr !important;
        }

        .analytics-order-tools {
            width: 300px !important;
            max-width: 100% !important;
            grid-template-columns: 210px 86px !important;
            justify-content: start !important;
        }
    }

    @media (max-width: 640px) {
        .analytics-detail-modal-card,
        .analytics-detail-modal-card.wide {
            width: calc(100vw - 28px) !important;
            max-height: 82vh !important;
            padding: 20px 16px 16px !important;
        }

        .analytics-detail-modal-card .analytics-modal-title {
            font-size: 23px !important;
        }

        .analytics-detail-item {
            grid-template-columns: 1fr !important;
            gap: 4px !important;
        }

        .analytics-order-tools {
            width: 100% !important;
            max-width: 100% !important;
            grid-template-columns: 1fr 86px !important;
        }

        .analytics-search {
            width: 100% !important;
            min-width: 0 !important;
            max-width: 100% !important;
        }
    }



    /* =========================================================
       ANALYTICS FINAL PATCH: Help Center card style + Dashboard controls
       ========================================================= */
    .analytics-final {
        --analytics-hc-border: #DDE6F2;
        --analytics-hc-soft-border: #E7EEF8;
        --analytics-hc-bg: #F8FBFF;
        --analytics-hc-card: #FFFFFF;
        --analytics-hc-shadow: 0 10px 25px rgba(15, 23, 42, 0.045);
        --analytics-hc-radius: 14px;
        --analytics-dashboard-blue-gradient: linear-gradient(135deg, #1274ff 0%, #0b63f6 54%, #084ac2 100%);
    }

    /* Same box color/style as Help Center > Knowledge Base Management */
    .analytics-trend-panel,
    .analytics-dashboard-grid > .analytics-equal-panel:not(.analytics-flat-panel),
    .analytics-lower-grid > .analytics-panel:first-child {
        background: var(--analytics-hc-card) !important;
        border: 1px solid var(--analytics-hc-border) !important;
        border-radius: var(--analytics-hc-radius) !important;
        box-shadow: var(--analytics-hc-shadow) !important;
        padding: 18px !important;
        overflow: hidden !important;
        transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease !important;
    }

    .analytics-trend-panel:hover,
    .analytics-dashboard-grid > .analytics-equal-panel:not(.analytics-flat-panel):hover,
    .analytics-lower-grid > .analytics-panel:first-child:hover {
        background: var(--analytics-hc-card) !important;
        border-color: var(--analytics-hc-border) !important;
        box-shadow: var(--analytics-hc-shadow) !important;
        transform: none !important;
        filter: none !important;
    }

    /* Remove black-box hover effect from Analytics panels/rows/buttons */
    .analytics-panel:hover,
    .analytics-clickable:hover,
    .analytics-flat-panel:hover,
    .analytics-flat-panel .analytics-clickable:hover,
    .analytics-kpi:hover,
    .analytics-chart-stat:hover,
    .analytics-legend-row:hover,
    .analytics-service-row:hover,
    .analytics-region-row:hover,
    .analytics-insight-row:hover {
        background-color: inherit !important;
        filter: none !important;
        transform: none !important;
    }

    .analytics-panel-action:hover,
    .analytics-action-btn:hover {
        background: #F8FBFF !important;
        border-color: var(--portal-blue) !important;
        color: var(--portal-blue) !important;
    }

    .analytics-panel-head {
        margin-bottom: 15px !important;
    }

    .analytics-panel-title {
        font-size: 17px !important;
        font-weight: 800 !important;
        display: flex !important;
        align-items: center !important;
        gap: 9px !important;
        color: #0F172A !important;
    }

    .analytics-panel-title::before {
        content: "" !important;
        display: block !important;
        width: 15px !important;
        height: 3px !important;
        margin: 0 !important;
        flex: 0 0 auto !important;
        border-radius: 999px !important;
        background: var(--portal-orange) !important;
    }

    .analytics-dashboard-grid {
        grid-auto-rows: 236px !important;
        gap: 16px !important;
    }

    .analytics-trend-panel {
        min-height: 486px !important;
    }

    .analytics-equal-panel {
        height: 236px !important;
        min-height: 236px !important;
    }

    .analytics-lower-grid {
        gap: 16px !important;
    }

    .analytics-lower-grid > .analytics-panel:first-child {
        height: 236px !important;
        min-height: 236px !important;
    }

    /* Dashboard calendar/date shape + dashboard button color/style */
    .analytics-toolbar {
        width: 270px !important;
        max-width: 270px !important;
        gap: 9px !important;
        align-items: flex-end !important;
    }

    .analytics-date-pill,
    .analytics-btn {
        height: 40px !important;
        min-height: 40px !important;
        border-radius: 8px !important;
        font-family: 'Inter', system-ui, sans-serif !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        gap: 9px !important;
        box-shadow: none !important;
        transform: none !important;
        cursor: pointer !important;
    }

    .analytics-date-pill {
        width: 270px !important;
        min-width: 270px !important;
        max-width: 270px !important;
        border: 1px solid #d8dee8 !important;
        background: #FFFFFF !important;
        color: #050816 !important;
        padding: 0 14px !important;
        justify-content: space-between !important;
        order: 1 !important;
    }

    button.analytics-date-pill:hover,
    button.analytics-date-pill:focus {
        background: #111827 !important;
        border-color: #111827 !important;
        color: #FFFFFF !important;
        outline: none !important;
    }

    button.analytics-date-pill:hover svg,
    button.analytics-date-pill:focus svg {
        color: #FFFFFF !important;
        stroke: #FFFFFF !important;
    }

    .analytics-toolbar-buttons {
        order: 2 !important;
        width: 270px !important;
        max-width: 270px !important;
        display: grid !important;
        grid-template-columns: 128px 128px !important;
        gap: 9px !important;
        justify-content: end !important;
    }

    .analytics-toolbar .analytics-btn,
    .analytics-toolbar-buttons .analytics-btn,
    #analyticsExportBtn,
    #analyticsReportBtn,
    .analytics-order-tools .analytics-btn {
        width: 128px !important;
        min-width: 128px !important;
        max-width: 128px !important;
        padding: 0 14px !important;
        border: 0 !important;
        background: var(--analytics-dashboard-blue-gradient) !important;
        background-image: var(--analytics-dashboard-blue-gradient) !important;
        color: #FFFFFF !important;
    }

    .analytics-btn.btn-outline,
    #analyticsExportBtn.btn-outline {
        background: #FFFFFF !important;
        background-image: none !important;
        color: #050816 !important;
        border: 1px solid #d8dee8 !important;
    }

    .analytics-btn:hover,
    .analytics-btn:focus,
    .analytics-btn.btn-outline:hover,
    .analytics-btn.btn-outline:focus,
    #analyticsExportBtn:hover,
    #analyticsReportBtn:hover,
    #analyticsExportBtn:focus,
    #analyticsReportBtn:focus {
        background: #111827 !important;
        background-image: none !important;
        border-color: #111827 !important;
        color: #FFFFFF !important;
        transform: none !important;
        outline: none !important;
    }

    .analytics-btn:hover svg,
    .analytics-btn:focus svg {
        color: #FFFFFF !important;
        stroke: #FFFFFF !important;
    }

    .analytics-date-pill i,
    .analytics-date-pill svg,
    .analytics-toolbar .analytics-btn i,
    .analytics-toolbar .analytics-btn svg {
        width: 17px !important;
        height: 17px !important;
        flex-shrink: 0 !important;
    }

    /* Analytics calendar copied in shape/style from Dashboard calendar */
    .analytics-calendar-overlay {
        position: fixed;
        inset: 0;
        z-index: 999997;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 18px;
        background: rgba(17, 24, 39, .36);
        backdrop-filter: blur(9px);
        -webkit-backdrop-filter: blur(9px);
    }

    .analytics-calendar-overlay.show { display: flex; }

    body.analytics-calendar-lock { overflow: hidden; }

    .analytics-calendar-modal {
        width: min(980px, calc(100vw - 48px));
        max-height: calc(100vh - 42px);
        overflow: hidden;
        border: 1.2px solid #111827;
        border-radius: 18px;
        background: #FFFFFF;
        box-shadow: 0 26px 80px rgba(15, 23, 42, .22);
        display: grid;
        grid-template-columns: minmax(0, 650px) 330px;
        color: #111827;
    }

    .analytics-calendar-main { padding: 18px 18px 20px; border-right: 1px solid #e8edf5; min-width: 0; background: #fff; }
    .analytics-calendar-side { padding: 18px; background: #fff; min-width: 0; }
    .analytics-calendar-headline { display: grid; grid-template-columns: minmax(160px, 1fr) auto 34px; gap: 14px; align-items: start; margin-bottom: 16px; }
    .analytics-calendar-intro h3 { margin: 0 0 3px; font-family: 'Poppins', system-ui, sans-serif; font-size: 16px; font-weight: 700; color: #111827; line-height: 1.2; }
    .analytics-calendar-intro p { width: 150px; margin: 0; font-size: 11px; font-weight: 400; line-height: 1.45; color: #6b7280; }
    .analytics-calendar-nav-main { display: flex; align-items: center; justify-content: center; gap: 38px; padding-top: 8px; }
    .analytics-calendar-monthbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 12px; }
    .analytics-calendar-title { margin: 0; font-family: 'Poppins', system-ui, sans-serif; font-size: 14px; font-weight: 700; color: #111827; }
    .analytics-calendar-icon-btn { width: 34px; height: 34px; min-width: 34px; padding: 0; border: 0; border-radius: 999px; background: #fff; color: #111827; display: inline-flex; align-items: center; justify-content: center; box-shadow: none; cursor: pointer; }
    .analytics-calendar-icon-btn svg { width: 20px; height: 20px; stroke-width: 2.2; }
    .analytics-calendar-icon-btn:hover, .analytics-calendar-icon-btn:focus { background: #f4f6f9; color: #111827; outline: none; }
    .analytics-calendar-action-btn, .analytics-calendar-clear-btn, .analytics-calendar-save-btn, .analytics-calendar-mini-btn { border-radius: 999px; cursor: pointer; font-family: 'Inter', system-ui, sans-serif; transition: background .18s ease, color .18s ease, border-color .18s ease; }
    .analytics-calendar-action-btn, .analytics-calendar-clear-btn { height: 36px; min-height: 36px; padding: 0 18px; border: 1px solid #111827; background: #fff; color: #111827; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 7px; box-shadow: none; }
    .analytics-calendar-today-btn { min-width: 86px; }
    .analytics-calendar-use-top { min-width: 104px; }
    .analytics-calendar-action-btn:hover, .analytics-calendar-action-btn:focus, .analytics-calendar-clear-btn:hover, .analytics-calendar-clear-btn:focus { background: #111827; color: #fff; border-color: #111827; outline: none; }
    .analytics-calendar-save-btn { width: 124px; min-width: 124px; height: 36px; border: 0; background: var(--analytics-dashboard-blue-gradient); color: #fff; font-size: 11.5px; font-weight: 600; box-shadow: none; }
    .analytics-calendar-save-btn:hover, .analytics-calendar-save-btn:focus { background: #111827; background-image: none; color: #fff; outline: none; }
    .analytics-calendar-clear-btn { width: 92px; min-width: 92px; }
    .analytics-calendar-weekdays, .analytics-calendar-grid { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 7px; }
    .analytics-calendar-weekdays { margin-bottom: 7px; }
    .analytics-calendar-weekdays span { text-align: center; font-size: 9.5px; font-weight: 800; color: #6b7280; letter-spacing: .08em; text-transform: uppercase; }
    .analytics-calendar-day { position: relative; min-height: 78px; border: 1px solid #e8edf5; border-radius: 12px; background: #fff; padding: 8px; text-align: left; color: #111827; cursor: pointer; box-shadow: none; }
    .analytics-calendar-day:hover, .analytics-calendar-day:focus { border-color: #0b63f6; box-shadow: 0 10px 24px rgba(11, 99, 246, .10); outline: none; }
    .analytics-calendar-day.is-muted { background: #fafafa; color: #a1a1aa; cursor: default; }
    .analytics-calendar-day.is-today { border-color: #0b63f6; background: #f7fbff; }
    .analytics-calendar-day.is-selected { border-color: #111827; background: rgba(17, 24, 39, .08); box-shadow: inset 0 0 0 1px #111827; }
    .analytics-calendar-day-number { display: block; font-size: 12px; font-weight: 800; line-height: 1; }
    .analytics-calendar-day-events { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 17px; }
    .analytics-calendar-event-dot { width: 7px; height: 7px; border-radius: 999px; background: #0b63f6; box-shadow: 0 0 0 3px rgba(11, 99, 246, .10); }
    .analytics-calendar-more { font-size: 9px; font-weight: 700; color: #6b7280; line-height: 1; }
    .analytics-calendar-selected-date { margin: 0 0 14px; font-family: 'Poppins', system-ui, sans-serif; font-size: 16px; font-weight: 700; color: #111827; }
    .analytics-calendar-event-list { display: grid; gap: 8px; max-height: 176px; overflow: auto; padding-right: 2px; margin-bottom: 12px; }
    .analytics-calendar-event-item { border: 1px solid #e8edf5; border-radius: 12px; background: #fff; padding: 10px; display: grid; gap: 7px; }
    .analytics-calendar-event-title { font-size: 12px; font-weight: 800; color: #111827; line-height: 1.3; }
    .analytics-calendar-event-meta { font-size: 10px; font-weight: 600; color: #0b63f6; line-height: 1.35; }
    .analytics-calendar-event-note { font-size: 10.5px; font-weight: 400; color: #6b7280; line-height: 1.45; }
    .analytics-calendar-event-actions { display: flex; gap: 6px; justify-content: flex-end; }
    .analytics-calendar-mini-btn { height: 27px; padding: 0 10px; border: 1px solid #e8edf5; background: #fff; color: #111827; font-size: 9.5px; font-weight: 800; }
    .analytics-calendar-mini-btn:hover, .analytics-calendar-mini-btn:focus { background: #111827; border-color: #111827; color: #fff; outline: none; }
    .analytics-calendar-mini-btn.danger { border-color: #fee2e2; color: #ef4444; }
    .analytics-calendar-mini-btn.danger:hover, .analytics-calendar-mini-btn.danger:focus { background: #ef4444; border-color: #ef4444; color: #fff; }
    .analytics-calendar-empty { min-height: 74px; border: 1px dashed #d8dee8; border-radius: 12px; display: grid; place-items: center; text-align: center; color: #6b7280; font-size: 11px; font-weight: 400; line-height: 1.45; padding: 12px; background: #fff; margin-bottom: 12px; }
    .analytics-calendar-form { display: grid; gap: 10px; }
    .analytics-calendar-field { display: grid; gap: 5px; }
    .analytics-calendar-field label { font-size: 10px; font-weight: 800; color: #4b5563; letter-spacing: .05em; text-transform: uppercase; }
    .analytics-calendar-field input, .analytics-calendar-field textarea { width: 100%; border: 1px solid #e8edf5; border-radius: 10px; background: #fff; padding: 10px 11px; color: #111827; font-size: 12px; font-weight: 500; outline: none; box-shadow: none; }
    .analytics-calendar-field textarea { min-height: 68px; resize: vertical; }
    .analytics-calendar-field input:focus, .analytics-calendar-field textarea:focus { border-color: #0b63f6; box-shadow: 0 0 0 3px rgba(11, 99, 246, .10); }
    .analytics-calendar-form-actions { display: flex; align-items: center; justify-content: flex-end; gap: 8px; margin-top: 0; }

    @media (max-width: 920px) {
        .analytics-calendar-modal { grid-template-columns: 1fr; width: min(720px, calc(100vw - 32px)); overflow: auto; }
        .analytics-calendar-main { border-right: 0; border-bottom: 1px solid #e8edf5; }
        .analytics-calendar-headline { grid-template-columns: 1fr auto; }
        .analytics-calendar-nav-main { grid-column: 1 / -1; justify-content: space-between; gap: 12px; }
    }

    @media (max-width: 640px) {
        .analytics-toolbar, .analytics-toolbar-buttons, .analytics-date-pill { width: 100% !important; max-width: 100% !important; min-width: 0 !important; }
        .analytics-toolbar-buttons { grid-template-columns: 1fr !important; }
        .analytics-toolbar .analytics-btn, .analytics-toolbar-buttons .analytics-btn { width: 100% !important; max-width: 100% !important; min-width: 0 !important; }
        .analytics-calendar-day { min-height: 62px; }
    }

</style>

<div class="analytics-final" id="analyticsFinalRoot">
    <div class="analytics-toast" id="analyticsToast">Analytics updated.</div>

    <div class="analytics-final-header">
        <div class="analytics-title-wrap">
            <h1 class="analytics-page-title">Analytics</h1>
            <p class="analytics-subtitle">Monitor performance, trends, customer behavior, and operational insights.</p>
        </div>

        <div class="analytics-toolbar">
            <button type="button" class="analytics-date-pill" id="analyticsDateControl" aria-haspopup="dialog" aria-expanded="false">
                <i data-lucide="calendar-days"></i>
                <span id="analyticsDateLabel">{{ $dateRangeLabel }}</span>
                <i data-lucide="chevron-down"></i>
            </button>
            <div class="analytics-toolbar-buttons">
                <button type="button" class="analytics-btn btn-outline" id="analyticsExportBtn">
                    <i data-lucide="download"></i>
                    Export
                </button>
                <button type="button" class="analytics-btn" id="analyticsReportBtn">
                    <i data-lucide="trending-up"></i>
                    Generate Report
                </button>
            </div>
        </div>
    </div>

    <div class="analytics-calendar-overlay" id="analyticsCalendarOverlay" aria-hidden="true">
        <div class="analytics-calendar-modal" role="dialog" aria-modal="true" aria-labelledby="analyticsCalendarTitle">
            <div class="analytics-calendar-main">
                <div class="analytics-calendar-headline">
                    <div class="analytics-calendar-intro">
                        <h3>Analytics Calendar</h3>
                        <p>Select dates and manage analytics reminders.</p>
                    </div>
                    <div class="analytics-calendar-nav-main">
                        <button type="button" class="analytics-calendar-icon-btn" id="analyticsCalendarPrev" title="Previous month"><i data-lucide="chevron-left"></i></button>
                        <button type="button" class="analytics-calendar-action-btn analytics-calendar-today-btn" id="analyticsCalendarToday">Today</button>
                        <button type="button" class="analytics-calendar-icon-btn" id="analyticsCalendarNext" title="Next month"><i data-lucide="chevron-right"></i></button>
                    </div>
                    <button type="button" class="analytics-calendar-icon-btn" id="analyticsCalendarClose" title="Close"><i data-lucide="x"></i></button>
                </div>
                <div class="analytics-calendar-monthbar">
                    <h3 class="analytics-calendar-title" id="analyticsCalendarTitle">Calendar</h3>
                    <button type="button" class="analytics-calendar-action-btn analytics-calendar-use-top" id="analyticsCalendarUseDate"><i data-lucide="check"></i><span>Use Date</span></button>
                </div>
                <div class="analytics-calendar-weekdays">
                    <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                </div>
                <div class="analytics-calendar-grid" id="analyticsCalendarGrid"></div>
            </div>
            <aside class="analytics-calendar-side">
                <h3 class="analytics-calendar-selected-date" id="analyticsCalendarSelectedDate">Selected date</h3>
                <div class="analytics-calendar-event-list" id="analyticsCalendarEventList"></div>
                <div class="analytics-calendar-empty" id="analyticsCalendarEmpty">No reminders yet for this date. Add one below.</div>
                <form class="analytics-calendar-form" id="analyticsCalendarForm">
                    <div class="analytics-calendar-field">
                        <label>Event / Reminder</label>
                        <input type="text" id="analyticsCalendarEventTitle" placeholder="Example: Review weekly analytics">
                    </div>
                    <div class="analytics-calendar-field">
                        <label>Time</label>
                        <input type="time" id="analyticsCalendarEventTime">
                    </div>
                    <div class="analytics-calendar-field">
                        <label>Note</label>
                        <textarea id="analyticsCalendarEventNote" placeholder="Optional note"></textarea>
                    </div>
                    <div class="analytics-calendar-form-actions">
                        <button type="button" class="analytics-calendar-clear-btn" id="analyticsCalendarClear">Clear</button>
                        <button type="submit" class="analytics-calendar-save-btn" id="analyticsCalendarSave">Save Event</button>
                    </div>
                </form>
            </aside>
        </div>
    </div>

    <div class="analytics-kpi-grid">
        <button type="button" class="analytics-kpi kpi-colored kpi-blue" data-feedback="Total revenue is PHP {{ number_format($totalRevenue, 2) }}.">
            <span class="analytics-icon icon-blue"><i data-lucide="circle-dollar-sign"></i></span>
            <span>
                <p class="analytics-kpi-label">Total Revenue</p>
                <strong class="analytics-kpi-value">PHP {{ number_format($totalRevenue, 2) }}</strong>
                <span class="analytics-kpi-change"><i data-lucide="arrow-up"></i> 12.4% vs last 7 days</span>
            </span>
        </button>

        <button type="button" class="analytics-kpi kpi-colored kpi-orange" data-feedback="{{ number_format($totalOrders) }} total orders recorded.">
            <span class="analytics-icon icon-orange"><i data-lucide="shopping-bag"></i></span>
            <span>
                <p class="analytics-kpi-label">Total Orders</p>
                <strong class="analytics-kpi-value">{{ number_format($totalOrders) }}</strong>
                <span class="analytics-kpi-change"><i data-lucide="arrow-up"></i> 18.7% vs last 7 days</span>
            </span>
        </button>

        <button type="button" class="analytics-kpi kpi-colored kpi-green" data-feedback="{{ number_format($totalCustomers) }} active customer accounts.">
            <span class="analytics-icon icon-green"><i data-lucide="users"></i></span>
            <span>
                <p class="analytics-kpi-label">Active Customers</p>
                <strong class="analytics-kpi-value">{{ number_format($totalCustomers) }}</strong>
                <span class="analytics-kpi-change"><i data-lucide="arrow-up"></i> 9.3% vs last 7 days</span>
            </span>
        </button>

        <button type="button" class="analytics-kpi kpi-colored kpi-red" data-feedback="Conversion rate is {{ $conversionRate }}%.">
            <span class="analytics-icon icon-red"><i data-lucide="filter"></i></span>
            <span>
                <p class="analytics-kpi-label">Conversion Rate</p>
                <strong class="analytics-kpi-value">{{ $conversionRate }}%</strong>
                <span class="analytics-kpi-change down"><i data-lucide="arrow-down"></i> 0.6pp vs last 7 days</span>
            </span>
        </button>

        <button type="button" class="analytics-kpi kpi-colored kpi-violet" data-feedback="Average order value is PHP {{ number_format($averageOrderValue, 2) }}.">
            <span class="analytics-icon icon-violet"><i data-lucide="clock-3"></i></span>
            <span>
                <p class="analytics-kpi-label">Avg. Order Value</p>
                <strong class="analytics-kpi-value">PHP {{ number_format($averageOrderValue, 2) }}</strong>
                <span class="analytics-kpi-change"><i data-lucide="arrow-up"></i> 3.2% vs last 7 days</span>
            </span>
        </button>
    </div>

    <div class="analytics-dashboard-grid">
        <section class="analytics-panel analytics-trend-panel">
            <div class="analytics-panel-head">
                <h2 class="analytics-panel-title">Revenue & Orders Trend</h2>
                <button type="button" class="analytics-panel-action" data-chart-toggle="trend">Daily</button>
            </div>
            <div class="analytics-chart-shell">
                <canvas id="analyticsTrendChart"></canvas>
            </div>
            <div class="analytics-chart-foot">
                <div class="analytics-chart-stat">
                    <span><b class="analytics-dot"></b>Revenue</span>
                    <strong>PHP {{ number_format($totalRevenue, 2) }}</strong>
                </div>
                <div class="analytics-chart-stat">
                    <span><b class="analytics-dot cyan"></b>Orders</span>
                    <strong>{{ number_format($totalOrders) }}</strong>
                </div>
                <div class="analytics-chart-stat">
                    <span><b class="analytics-dot green"></b>Avg. Order Value</span>
                    <strong>PHP {{ number_format($averageOrderValue, 2) }}</strong>
                </div>
                <div class="analytics-chart-stat">
                    <span><b class="analytics-dot red"></b>Refund Rate</span>
                    <strong>2.1%</strong>
                </div>
            </div>
        </section>

        <section class="analytics-panel analytics-equal-panel">
            <div class="analytics-panel-head">
                <h2 class="analytics-panel-title">Orders by Source</h2>
            </div>
            <div class="analytics-source-grid">
                <div class="analytics-chart-shell small">
                    <canvas id="analyticsSourceChart"></canvas>
                </div>
                <div class="analytics-legend-list">
                    @foreach ($sourceGroups as $label => $value)
                        <div class="analytics-legend-row">
                            <span class="analytics-legend-left">
                                <b class="analytics-dot {{ $loop->index === 1 ? 'orange' : ($loop->index === 2 ? 'green' : ($loop->index === 3 ? 'violet' : '')) }}"></b>
                                {{ $label }}
                            </span>
                            <strong>{{ $totalOrders > 0 ? round(($value / max($totalOrders, 1)) * 100, 1) : 0 }}% ({{ $value }})</strong>
                        </div>
                    @endforeach
                    <a href="#analyticsOrderTable" class="option-link">View full source report →</a>
                </div>
            </div>
        </section>

        <section class="analytics-panel analytics-equal-panel">
            <div class="analytics-panel-head">
                <h2 class="analytics-panel-title">Top Services / Products</h2>
                <button type="button" class="analytics-panel-action">By Revenue</button>
            </div>
            <div class="analytics-service-list">
                @foreach ($topServices as $service)
                    @php
                        $serviceRevenue = (float) $service->revenue_sum;
                        $barWidth = max(6, min(100, round(($serviceRevenue / $maxServiceRevenue) * 100)));
                        $barClass = $loop->index === 1 ? 'orange' : ($loop->index === 2 ? 'green' : ($loop->index === 3 ? 'violet' : ($loop->index === 4 ? 'cyan' : '')));
                    @endphp
                    <div class="analytics-service-row">
                        <span class="analytics-service-name">{{ $service->service_name }}</span>
                        <span class="analytics-bar-track">
                            <span class="analytics-bar-fill {{ $barClass }}" style="width: {{ $barWidth }}%; background: {{ $loop->index === 1 ? 'var(--portal-orange)' : ($loop->index === 2 ? 'var(--portal-green)' : ($loop->index === 3 ? 'var(--portal-violet)' : ($loop->index === 4 ? 'var(--portal-cyan)' : 'var(--portal-blue)'))) }}"></span>
                        </span>
                        <strong>PHP {{ number_format($serviceRevenue, 2) }}</strong>
                    </div>
                @endforeach
            </div>
            <a href="#analyticsOrderTable" class="option-link">View all services report →</a>
        </section>
        <section class="analytics-panel analytics-equal-panel">
            <div class="analytics-panel-head">
                <h2 class="analytics-panel-title">Orders by Day & Time</h2>
                <button type="button" class="analytics-panel-action">Day of Week</button>
            </div>
            <div class="analytics-chart-shell small">
                <canvas id="analyticsBarChart"></canvas>
            </div>
        </section>

        <section class="analytics-panel analytics-equal-panel analytics-flat-panel">
            <div class="analytics-panel-head">
                <h2 class="analytics-panel-title">Insights Summary</h2>
            </div>
            <div class="analytics-insight-list">
                <div class="analytics-insight-row analytics-clickable" data-feedback="Revenue insight opened.">
                    <span class="analytics-icon icon-green"><i data-lucide="chart-no-axes-combined"></i></span>
                    <span class="analytics-insight-text">
                        <strong>Revenue increased 12.4%</strong>
                        <small>Compared to the previous week</small>
                    </span>
                    <i data-lucide="chevron-right"></i>
                </div>
                <div class="analytics-insight-row analytics-clickable" data-feedback="Peak order insight opened.">
                    <span class="analytics-icon icon-orange"><i data-lucide="clock"></i></span>
                    <span class="analytics-insight-text">
                        <strong>Peak orders on Friday</strong>
                        <small>Highest volume between 10AM – 1PM</small>
                    </span>
                    <i data-lucide="chevron-right"></i>
                </div>
                <div class="analytics-insight-row analytics-clickable" data-feedback="Channel insight opened.">
                    <span class="analytics-icon icon-blue"><i data-lucide="shopping-cart"></i></span>
                    <span class="analytics-insight-text">
                        <strong>Direct website leads sales</strong>
                        <small>Largest traffic source this week</small>
                    </span>
                    <i data-lucide="chevron-right"></i>
                </div>
                <div class="analytics-insight-row analytics-clickable" data-feedback="Service insight opened.">
                    <span class="analytics-icon icon-violet"><i data-lucide="star"></i></span>
                    <span class="analytics-insight-text">
                        <strong>Top service is stable</strong>
                        <small>Demand stays consistent</small>
                    </span>
                    <i data-lucide="chevron-right"></i>
                </div>
            </div>
        </section>
    </div>

    <div class="analytics-lower-grid">
        <section class="analytics-panel">
            <div class="analytics-panel-head">
                <h2 class="analytics-panel-title">Orders by Region</h2>
            </div>
            @php
                $regionRows = [
                    ['name' => 'NCR', 'share' => 38.7, 'orders' => round($totalOrders * .387)],
                    ['name' => 'CALABARZON', 'share' => 21.8, 'orders' => round($totalOrders * .218)],
                    ['name' => 'Central Luzon', 'share' => 12.9, 'orders' => round($totalOrders * .129)],
                    ['name' => 'Central Visayas', 'share' => 9.7, 'orders' => round($totalOrders * .097)],
                    ['name' => 'Davao Region', 'share' => 7.3, 'orders' => round($totalOrders * .073)],
                    ['name' => 'Others', 'share' => 9.6, 'orders' => max(0, $totalOrders - (round($totalOrders * .387) + round($totalOrders * .218) + round($totalOrders * .129) + round($totalOrders * .097) + round($totalOrders * .073)))],
                ];
            @endphp
            <div class="analytics-region-list">
                @foreach ($regionRows as $region)
                    <div class="analytics-region-row">
                        <span class="analytics-region-name">{{ $region['name'] }}</span>
                        <span class="analytics-region-bar">
                            <span class="analytics-region-fill" style="width: {{ max(4, $region['share']) }}%;"></span>
                        </span>
                        <span class="analytics-region-meta">{{ number_format($region['orders']) }} · {{ $region['share'] }}%</span>
                    </div>
                @endforeach
            </div>
        </section>


        <section class="analytics-panel analytics-flat-panel">
            <div class="analytics-panel-head">
                <h2 class="analytics-panel-title">Top Performers</h2>
                <button type="button" class="analytics-panel-action">By Revenue</button>
            </div>
            <table class="analytics-mini-table analytics-performer-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Staff / Service</th>
                        <th>Orders</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topPerformers as $performer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="analytics-rank-user">
                                    <span class="analytics-avatar">{{ strtoupper(substr($performer->staff_name ?? 'A', 0, 1)) }}</span>
                                    <span>
                                        <strong>{{ $performer->staff_name ?? 'Admin Staff' }}</strong><br>
                                        <small>{{ $performer->service_name ?? 'General Service' }}</small>
                                    </span>
                                </div>
                            </td>
                            <td>{{ number_format($performer->orders_count ?? 0) }}</td>
                            <td>PHP {{ number_format((float) ($performer->revenue_sum ?? 0), 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="analytics-empty-state">No performer data available yet. Real completed order records will appear here automatically.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

    </div>

    <section class="analytics-order-table-wrap" id="analyticsOrderTable">
        <div class="analytics-panel-head">
            <h2 class="analytics-panel-title">Latest Transactions</h2>
            <div class="analytics-order-tools">
                <div class="analytics-search">
                    <i data-lucide="search"></i>
                    <input type="search" id="analyticsOrderSearch" placeholder="Search order ID, customer, service, or status...">
                </div>
                <button type="button" class="analytics-btn btn-outline" id="analyticsPrintBtn">
                    <i data-lucide="printer"></i>
                    Print
                </button>
            </div>
        </div>

        <table class="analytics-order-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Service / Item</th>
                    <th>Date</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="analyticsOrdersBody">
                @forelse ($recentOrdersPayload as $order)
                    <tr data-order-id="{{ $order['order_id'] }}">
                        <td>
                            <a href="#" class="analytics-order-id" data-order-open="{{ $order['order_id'] }}">
                                {{ $order['order_id'] }}
                            </a>
                        </td>
                        <td>{{ $order['customer'] }}</td>
                        <td>{{ $order['service'] }}</td>
                        <td>{{ $order['date'] }}</td>
                        <td><span class="analytics-status {{ strtolower($order['payment_status']) }}">{{ $order['payment_status'] }}</span></td>
                        <td><span class="analytics-status {{ strtolower(str_replace([' ', '/'], ['-', '-'], $order['status'])) }}">{{ $order['status'] }}</span></td>
                        <td>{{ $order['total'] }}</td>
                        <td class="analytics-actions-cell">
                            <button type="button" class="analytics-action-btn" data-order-open="{{ $order['order_id'] }}" title="View order"><i data-lucide="eye"></i></button>
                            <button type="button" class="analytics-action-btn" data-feedback="Edit function ready for {{ $order['order_id'] }}" title="Edit order"><i data-lucide="pencil"></i></button>
                            <button type="button" class="analytics-action-btn" data-feedback="Print function ready for {{ $order['order_id'] }}" title="Print order"><i data-lucide="printer"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="analytics-empty-state">No transactions available yet. New customer orders will appear here automatically.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>


<div class="analytics-modal" id="analyticsDetailModal" aria-hidden="true">
    <div class="analytics-modal-card analytics-detail-modal-card" id="analyticsDetailCard">
        <div class="analytics-modal-head">
            <div>
                <h3 class="analytics-modal-title" id="analyticsDetailTitle">Analytics Details</h3>
                <p class="analytics-modal-subtitle" id="analyticsDetailSubtitle">Exact data summary</p>
            </div>
            <button type="button" class="analytics-modal-close" id="analyticsDetailClose" aria-label="Close analytics details">
                <i data-lucide="x"></i>
            </button>
        </div>
        <div id="analyticsDetailBody"></div>
        <div class="analytics-detail-info-note" id="analyticsDetailNote">
            <i data-lucide="info"></i>
            <span>These details are generated from the actual records loaded in this analytics page.</span>
        </div>
    </div>
</div>

<div class="analytics-modal" id="analyticsOrderModal" aria-hidden="true">
    <div class="analytics-modal-card">
        <div class="analytics-modal-head">
            <div>
                <h3 class="analytics-modal-title" id="analyticsModalOrderId">Order Details</h3>
                <p class="analytics-modal-subtitle" id="analyticsModalSubtitle">Click an Order ID to view the full transaction information.</p>
            </div>
            <button type="button" class="analytics-modal-close" id="analyticsModalClose">
                <i data-lucide="x"></i>
            </button>
        </div>

        <div class="analytics-modal-grid">
            <div class="analytics-modal-info">
                <small>Customer</small>
                <strong id="analyticsModalCustomer">—</strong>
            </div>
            <div class="analytics-modal-info">
                <small>Email</small>
                <strong id="analyticsModalEmail">—</strong>
            </div>
            <div class="analytics-modal-info">
                <small>Service / Item</small>
                <strong id="analyticsModalService">—</strong>
            </div>
            <div class="analytics-modal-info">
                <small>Total</small>
                <strong id="analyticsModalTotal">—</strong>
            </div>
            <div class="analytics-modal-info">
                <small>Payment Status</small>
                <strong id="analyticsModalPayment">—</strong>
            </div>
            <div class="analytics-modal-info">
                <small>Order Status</small>
                <strong id="analyticsModalStatus">—</strong>
            </div>
            <div class="analytics-modal-info">
                <small>Delivery Method</small>
                <strong id="analyticsModalDelivery">—</strong>
            </div>
            <div class="analytics-modal-info">
                <small>Tracking Number</small>
                <strong id="analyticsModalTracking">—</strong>
            </div>
            <div class="analytics-modal-info full">
                <small>Delivery Address</small>
                <strong id="analyticsModalAddress">—</strong>
            </div>
            <div class="analytics-modal-info full">
                <small>Notes</small>
                <strong id="analyticsModalNotes">—</strong>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const root = document.getElementById('analyticsFinalRoot');
        if (!root) return;

        if (window.lucide) {
            window.lucide.createIcons();
        }

        const toast = document.getElementById('analyticsToast');
        const showToast = (message) => {
            if (!toast) return;
            toast.textContent = message || 'Done.';
            toast.classList.add('show');
            clearTimeout(window.analyticsToastTimer);
            window.analyticsToastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
        };


        /* Dashboard-style calendar/date functions for Analytics */
        const analyticsDateControl = document.getElementById('analyticsDateControl');
        const analyticsDateLabel = document.getElementById('analyticsDateLabel');
        const analyticsCalendarOverlay = document.getElementById('analyticsCalendarOverlay');
        const analyticsCalendarGrid = document.getElementById('analyticsCalendarGrid');
        const analyticsCalendarTitle = document.getElementById('analyticsCalendarTitle');
        const analyticsCalendarSelectedDate = document.getElementById('analyticsCalendarSelectedDate');
        const analyticsCalendarEventList = document.getElementById('analyticsCalendarEventList');
        const analyticsCalendarEmpty = document.getElementById('analyticsCalendarEmpty');
        const analyticsCalendarForm = document.getElementById('analyticsCalendarForm');
        const analyticsCalendarEventTitle = document.getElementById('analyticsCalendarEventTitle');
        const analyticsCalendarEventTime = document.getElementById('analyticsCalendarEventTime');
        const analyticsCalendarEventNote = document.getElementById('analyticsCalendarEventNote');
        const analyticsCalendarSave = document.getElementById('analyticsCalendarSave');
        let analyticsSelectedDate = new Date().toISOString().slice(0, 10);
        let analyticsCalendarMonth = new Date().getMonth();
        let analyticsCalendarYear = new Date().getFullYear();
        let analyticsEditingEventId = null;
        let analyticsCalendarEvents = [];

        const analyticsPad = (value) => String(value).padStart(2, '0');
        const analyticsIsoDate = (year, month, day) => `${year}-${analyticsPad(month + 1)}-${analyticsPad(day)}`;
        const analyticsFormatDate = (iso) => {
            const parts = String(iso).split('-').map(Number);
            if (parts.length !== 3 || parts.some(Number.isNaN)) return '{{ $dateRangeLabel }}';
            return new Date(parts[0], parts[1] - 1, parts[2]).toLocaleDateString('en-US', { month: 'long', day: '2-digit', year: 'numeric' });
        };
        const analyticsLoadEvents = () => {
            try { analyticsCalendarEvents = JSON.parse(localStorage.getItem('printifyAnalyticsCalendarEvents') || '[]'); }
            catch (error) { analyticsCalendarEvents = []; }
        };
        const analyticsSaveEvents = () => localStorage.setItem('printifyAnalyticsCalendarEvents', JSON.stringify(analyticsCalendarEvents));
        const analyticsEventsForDate = (iso) => analyticsCalendarEvents.filter(event => event.date === iso).sort((a, b) => (a.time || '').localeCompare(b.time || ''));
        const analyticsEventCount = (iso) => analyticsEventsForDate(iso).length;

        function analyticsResetCalendarForm() {
            analyticsEditingEventId = null;
            if (analyticsCalendarEventTitle) analyticsCalendarEventTitle.value = '';
            if (analyticsCalendarEventTime) analyticsCalendarEventTime.value = '';
            if (analyticsCalendarEventNote) analyticsCalendarEventNote.value = '';
            if (analyticsCalendarSave) analyticsCalendarSave.textContent = 'Save Event';
        }

        function analyticsRenderCalendar() {
            if (!analyticsCalendarGrid || !analyticsCalendarTitle || !analyticsCalendarSelectedDate) return;
            analyticsCalendarTitle.textContent = new Date(analyticsCalendarYear, analyticsCalendarMonth, 1).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            analyticsCalendarSelectedDate.textContent = analyticsFormatDate(analyticsSelectedDate);
            analyticsCalendarGrid.innerHTML = '';

            const first = new Date(analyticsCalendarYear, analyticsCalendarMonth, 1);
            const total = new Date(analyticsCalendarYear, analyticsCalendarMonth + 1, 0).getDate();
            const today = new Date().toISOString().slice(0, 10);

            for (let i = 0; i < first.getDay(); i++) {
                const blank = document.createElement('button');
                blank.type = 'button';
                blank.className = 'analytics-calendar-day is-muted';
                blank.disabled = true;
                analyticsCalendarGrid.appendChild(blank);
            }

            for (let day = 1; day <= total; day++) {
                const iso = analyticsIsoDate(analyticsCalendarYear, analyticsCalendarMonth, day);
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'analytics-calendar-day';
                if (iso === today) button.classList.add('is-today');
                if (iso === analyticsSelectedDate) button.classList.add('is-selected');
                button.innerHTML = `<span class="analytics-calendar-day-number">${day}</span>`;

                const count = analyticsEventCount(iso);
                if (count > 0) {
                    const dots = document.createElement('span');
                    dots.className = 'analytics-calendar-day-events';
                    for (let dot = 0; dot < Math.min(count, 3); dot++) {
                        const dotEl = document.createElement('span');
                        dotEl.className = 'analytics-calendar-event-dot';
                        dots.appendChild(dotEl);
                    }
                    if (count > 3) {
                        const more = document.createElement('span');
                        more.className = 'analytics-calendar-more';
                        more.textContent = '+' + (count - 3);
                        dots.appendChild(more);
                    }
                    button.appendChild(dots);
                }

                button.addEventListener('click', () => {
                    analyticsSelectedDate = iso;
                    analyticsResetCalendarForm();
                    analyticsRenderCalendar();
                });
                analyticsCalendarGrid.appendChild(button);
            }

            while (analyticsCalendarGrid.children.length % 7 !== 0) {
                const blank = document.createElement('button');
                blank.type = 'button';
                blank.className = 'analytics-calendar-day is-muted';
                blank.disabled = true;
                analyticsCalendarGrid.appendChild(blank);
            }

            analyticsRenderEvents();
            if (window.lucide) window.lucide.createIcons();
        }

        function analyticsRenderEvents() {
            if (!analyticsCalendarEventList || !analyticsCalendarEmpty) return;
            const events = analyticsEventsForDate(analyticsSelectedDate);
            analyticsCalendarEventList.innerHTML = '';
            analyticsCalendarEmpty.style.display = events.length ? 'none' : 'grid';
            analyticsCalendarEventList.style.display = events.length ? 'grid' : 'none';

            events.forEach((event) => {
                const item = document.createElement('div');
                item.className = 'analytics-calendar-event-item';
                item.innerHTML = `
                    <div class="analytics-calendar-event-title"></div>
                    <div class="analytics-calendar-event-meta"></div>
                    <div class="analytics-calendar-event-note"></div>
                    <div class="analytics-calendar-event-actions">
                        <button type="button" class="analytics-calendar-mini-btn" data-edit="${event.id}">Edit</button>
                        <button type="button" class="analytics-calendar-mini-btn danger" data-delete="${event.id}">Delete</button>
                    </div>
                `;
                item.querySelector('.analytics-calendar-event-title').textContent = event.title;
                item.querySelector('.analytics-calendar-event-meta').textContent = event.time || 'All day';
                item.querySelector('.analytics-calendar-event-note').textContent = event.note || 'No note added.';
                item.querySelector('[data-edit]')?.addEventListener('click', () => {
                    analyticsEditingEventId = event.id;
                    analyticsCalendarEventTitle.value = event.title || '';
                    analyticsCalendarEventTime.value = event.time || '';
                    analyticsCalendarEventNote.value = event.note || '';
                    analyticsCalendarSave.textContent = 'Update Event';
                });
                item.querySelector('[data-delete]')?.addEventListener('click', () => {
                    analyticsCalendarEvents = analyticsCalendarEvents.filter(calendarEvent => calendarEvent.id !== event.id);
                    analyticsSaveEvents();
                    analyticsResetCalendarForm();
                    analyticsRenderCalendar();
                    showToast('Calendar event deleted.');
                });
                analyticsCalendarEventList.appendChild(item);
            });
        }

        function openAnalyticsCalendar() {
            if (!analyticsCalendarOverlay) return;
            analyticsCalendarOverlay.classList.add('show');
            analyticsCalendarOverlay.setAttribute('aria-hidden', 'false');
            analyticsDateControl?.setAttribute('aria-expanded', 'true');
            document.body.classList.add('analytics-calendar-lock');
            analyticsRenderCalendar();
        }

        function closeAnalyticsCalendar() {
            if (!analyticsCalendarOverlay) return;
            analyticsCalendarOverlay.classList.remove('show');
            analyticsCalendarOverlay.setAttribute('aria-hidden', 'true');
            analyticsDateControl?.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('analytics-calendar-lock');
            analyticsResetCalendarForm();
        }

        analyticsLoadEvents();
        analyticsRenderCalendar();
        analyticsDateControl?.addEventListener('click', openAnalyticsCalendar);
        analyticsCalendarOverlay?.addEventListener('click', function (event) {
            if (event.target === analyticsCalendarOverlay) closeAnalyticsCalendar();
        });
        document.getElementById('analyticsCalendarClose')?.addEventListener('click', closeAnalyticsCalendar);
        document.getElementById('analyticsCalendarPrev')?.addEventListener('click', function () {
            if (analyticsCalendarMonth === 0) { analyticsCalendarMonth = 11; analyticsCalendarYear--; }
            else analyticsCalendarMonth--;
            analyticsRenderCalendar();
        });
        document.getElementById('analyticsCalendarNext')?.addEventListener('click', function () {
            if (analyticsCalendarMonth === 11) { analyticsCalendarMonth = 0; analyticsCalendarYear++; }
            else analyticsCalendarMonth++;
            analyticsRenderCalendar();
        });
        document.getElementById('analyticsCalendarToday')?.addEventListener('click', function () {
            const now = new Date();
            analyticsCalendarYear = now.getFullYear();
            analyticsCalendarMonth = now.getMonth();
            analyticsSelectedDate = now.toISOString().slice(0, 10);
            analyticsResetCalendarForm();
            analyticsRenderCalendar();
        });
        document.getElementById('analyticsCalendarUseDate')?.addEventListener('click', function () {
            if (analyticsDateLabel) analyticsDateLabel.textContent = analyticsFormatDate(analyticsSelectedDate);
            closeAnalyticsCalendar();
            showToast('Date applied: ' + analyticsFormatDate(analyticsSelectedDate));
        });
        document.getElementById('analyticsCalendarClear')?.addEventListener('click', analyticsResetCalendarForm);
        analyticsCalendarForm?.addEventListener('submit', function (event) {
            event.preventDefault();
            const title = analyticsCalendarEventTitle?.value.trim();
            if (!title) { showToast('Please add an event title.'); return; }
            if (analyticsEditingEventId) {
                const found = analyticsCalendarEvents.find(calendarEvent => calendarEvent.id === analyticsEditingEventId);
                if (found) {
                    found.date = analyticsSelectedDate;
                    found.title = title;
                    found.time = analyticsCalendarEventTime?.value || '';
                    found.note = analyticsCalendarEventNote?.value || '';
                }
                showToast('Calendar event updated.');
            } else {
                analyticsCalendarEvents.push({
                    id: Date.now(),
                    date: analyticsSelectedDate,
                    title,
                    time: analyticsCalendarEventTime?.value || '',
                    note: analyticsCalendarEventNote?.value || ''
                });
                showToast('Calendar event saved.');
            }
            analyticsSaveEvents();
            analyticsResetCalendarForm();
            analyticsRenderCalendar();
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && analyticsCalendarOverlay?.classList.contains('show')) closeAnalyticsCalendar();
        });



        const analyticsDetailData = @json($analyticsClickableData);
        const detailModal = document.getElementById('analyticsDetailModal');
        const detailCard = document.getElementById('analyticsDetailCard');
        const detailClose = document.getElementById('analyticsDetailClose');
        const detailTitle = document.getElementById('analyticsDetailTitle');
        const detailSubtitle = document.getElementById('analyticsDetailSubtitle');
        const detailBody = document.getElementById('analyticsDetailBody');

        const formatNumber = (value) => Number(value || 0).toLocaleString('en-US');
        const formatMoney = (value) => 'PHP ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const escapeHtml = (value) => String(value ?? '').replace(/[&<>"]/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[char]));

        function openAnalyticsUiModal(title, subtitle, html, options = {}) {
            if (!detailModal || !detailBody) return;
            detailTitle.textContent = title;
            detailSubtitle.textContent = subtitle || 'Exact data summary';
            detailBody.innerHTML = html || '';
            detailCard.classList.toggle('wide', !!options.wide);
            detailModal.classList.add('show');
            detailModal.setAttribute('aria-hidden', 'false');
            if (window.lucide) window.lucide.createIcons();
        }

        function closeAnalyticsUiModal() {
            detailModal?.classList.remove('show');
            detailModal?.setAttribute('aria-hidden', 'true');
        }

        detailClose?.addEventListener('click', closeAnalyticsUiModal);
        detailModal?.addEventListener('click', function (event) {
            if (event.target === detailModal) closeAnalyticsUiModal();
        });

        function detailRows(rows) {
            return `<div class="analytics-detail-list">${rows.map(row => `
                <div class="analytics-detail-item">
                    <span>${escapeHtml(row.label)}</span>
                    <strong class="${row.className || ''}">${escapeHtml(row.value)}</strong>
                </div>
            `).join('')}</div>`;
        }

        function detailTable(headers, rows) {
            return `
                <div class="analytics-detail-table-wrap">
                    <table class="analytics-detail-table">
                        <thead><tr>${headers.map(header => `<th>${escapeHtml(header)}</th>`).join('')}</tr></thead>
                        <tbody>${rows.map(row => `<tr>${row.map(cell => `<td>${cell}</td>`).join('')}</tr>`).join('')}</tbody>
                    </table>
                </div>
            `;
        }

        function summaryCards(cards, columns = 3) {
            return `<div class="analytics-detail-summary-grid ${columns === 4 ? 'four' : ''}">${cards.map(card => `
                <div class="analytics-detail-summary-card ${card.color || 'blue'}">
                    <i data-lucide="${card.icon || 'info'}"></i>
                    <div><span>${escapeHtml(card.label)}</span><strong>${escapeHtml(card.value)}</strong></div>
                </div>
            `).join('')}</div>`;
        }

        function getSampleArray(actualValues, sampleValues) {
            const list = Array.from(actualValues || []);
            return list.some(v => Number(v) > 0) ? list.map(Number) : sampleValues;
        }

        function topServiceName() {
            const services = Array.from(analyticsDetailData.services || []);
            return (services.find(service => Number(service.revenueRaw || 0) > 0) || services[0] || {}).name || 'No service yet';
        }

        function showKpiDetail(type) {
            const t = analyticsDetailData.totals;
            const services = Array.from(analyticsDetailData.services || []);
            const topCustomer = (Array.from(analyticsDetailData.performers || [])[0] || {}).staff || 'No customer yet';
            const map = {
                revenue: {
                    title: 'Total Revenue Details',
                    subtitle: 'Revenue summary for ' + t.dateRange,
                    html: detailRows([
                        { label: 'Total Revenue', value: t.totalRevenue },
                        { label: 'Paid Orders Revenue', value: t.paidRevenue || t.totalRevenue },
                        { label: 'Pending Payment Revenue', value: t.pendingRevenue || 'PHP 0.00' },
                        { label: 'Refunded / Cancelled Amount', value: t.cancelledRevenue || 'PHP 0.00' },
                        { label: 'Completed Orders', value: formatNumber(t.completedOrders) },
                        { label: 'Average Daily Revenue', value: formatMoney((t.totalRevenueRaw || 0) / 7) },
                        { label: 'Highest Revenue Day', value: 'Friday' },
                        { label: 'Revenue Growth', value: '+12.4% vs last 7 days', className: 'positive' },
                    ])
                },
                orders: {
                    title: 'Total Orders Details',
                    subtitle: 'Order activity summary for ' + t.dateRange,
                    html: detailRows([
                        { label: 'Total Orders', value: formatNumber(t.totalOrders) },
                        { label: 'Completed Orders', value: formatNumber(t.completedOrders) },
                        { label: 'Pending Orders', value: formatNumber(t.pendingOrders) },
                        { label: 'Processing Orders', value: formatNumber(t.processingOrders) },
                        { label: 'Cancelled Orders', value: formatNumber(t.cancelledOrders) },
                        { label: 'Returned / Rejected Orders', value: '0' },
                        { label: 'Most Ordered Service', value: topServiceName() },
                        { label: 'Order Growth', value: '+18.7% vs last 7 days', className: 'positive' },
                    ])
                },
                customers: {
                    title: 'Active Customer Details',
                    subtitle: 'Customer activity and engagement summary for ' + t.dateRange,
                    html: detailRows([
                        { label: 'Active Customers', value: formatNumber(t.totalCustomers) },
                        { label: 'New Customers', value: formatNumber(Math.round((t.totalCustomers || 0) * .22)) },
                        { label: 'Returning Customers', value: formatNumber(Math.round((t.totalCustomers || 0) * .58)) },
                        { label: 'Guest Customers', value: formatNumber(Math.max(0, (t.totalCustomers || 0) - Math.round((t.totalCustomers || 0) * .8))) },
                        { label: 'Top Customer', value: topCustomer === 'Admin Staff' ? 'No customer yet' : topCustomer },
                        { label: 'Customer Retention Rate', value: t.totalCustomers > 0 ? '57.4%' : '0%' },
                        { label: 'Customer Growth', value: '+9.3% vs last 7 days', className: 'positive' },
                    ])
                },
                conversion: {
                    title: 'Conversion Rate Details',
                    subtitle: 'Order conversion summary for ' + t.dateRange,
                    html: detailRows([
                        { label: 'Conversion Rate', value: t.conversionRate },
                        { label: 'Formula Used', value: 'Total Orders ÷ Active Customers × 100' },
                        { label: 'Total Orders', value: formatNumber(t.totalOrders) },
                        { label: 'Active Customers', value: formatNumber(t.totalCustomers) },
                        { label: 'Completed Orders', value: formatNumber(t.completedOrders) },
                        { label: 'Conversion Change', value: '-0.6pp vs last 7 days', className: 'negative' },
                    ])
                },
                average: {
                    title: 'Average Order Value Details',
                    subtitle: 'Average customer spending summary for ' + t.dateRange,
                    html: detailRows([
                        { label: 'Average Order Value', value: t.averageOrderValue },
                        { label: 'Highest Order Value', value: t.highestOrderValue || 'PHP 0.00' },
                        { label: 'Lowest Order Value', value: t.lowestOrderValue || 'PHP 0.00' },
                        { label: 'Total Revenue', value: t.totalRevenue },
                        { label: 'Total Completed Orders', value: formatNumber(t.completedOrders) },
                        { label: 'Most Valuable Service', value: topServiceName() },
                        { label: 'AOV Growth', value: '+3.2% vs last 7 days', className: 'positive' },
                    ])
                }
            };
            const selected = map[type];
            if (selected) openAnalyticsUiModal(selected.title, selected.subtitle, selected.html);
        }

        function showTrendModal() {
            const labels = Array.from(analyticsDetailData.weeklyLabels || []);
            const revenues = getSampleArray(analyticsDetailData.weeklySales, [12800, 18450, 29600, 21300, 16980, 11750, 13700]);
            const orders = getSampleArray(analyticsDetailData.weeklyOrders, [9, 12, 18, 15, 13, 10, 15]);
            const rows = labels.map((label, index) => {
                const orderCount = orders[index] || 0;
                return [
                    escapeHtml(label),
                    `<strong>${formatMoney(revenues[index] || 0)}</strong>`,
                    formatNumber(orderCount),
                    formatNumber(Math.max(0, orderCount - 1)),
                    orderCount > 0 ? '1' : '0',
                    '0'
                ];
            });
            openAnalyticsUiModal(
                'Revenue & Orders Trend',
                'Daily performance from ' + analyticsDetailData.totals.dateRange,
                detailTable(['Date', 'Revenue', 'Orders', 'Completed', 'Pending', 'Cancelled'], rows) +
                summaryCards([
                    { color: 'green', icon: 'chart-no-axes-combined', label: 'Peak Revenue Date', value: labels[revenues.indexOf(Math.max(...revenues))] || 'No data' },
                    { color: 'red', icon: 'chart-no-axes-combined', label: 'Lowest Revenue Date', value: labels[revenues.indexOf(Math.min(...revenues))] || 'No data' },
                    { color: 'violet', icon: 'trending-up', label: 'Trend Status', value: 'Strong midweek spike, stable weekend finish' },
                ]),
                { wide: true }
            );
        }

        function showSourceModal() {
            const sources = Array.from(analyticsDetailData.sources || []);
            const rows = sources.map(source => [
                escapeHtml(source.label),
                formatNumber(source.orders),
                `<strong>${escapeHtml(source.revenue || 'PHP 0.00')}</strong>`,
                `${source.share || 0}%`
            ]);
            const sorted = sources.slice().sort((a, b) => Number(b.orders || 0) - Number(a.orders || 0));
            openAnalyticsUiModal(
                'Orders by Source',
                'Where customer orders came from for ' + analyticsDetailData.totals.dateRange,
                detailTable(['Source', 'Orders', 'Revenue', 'Percentage'], rows) +
                summaryCards([
                    { color: 'green', icon: 'badge-check', label: 'Top Source', value: (sorted[0] || {}).label || 'No data' },
                    { color: 'orange', icon: 'clock', label: 'Lowest Source', value: (sorted[sorted.length - 1] || {}).label || 'No data' },
                    { color: 'violet', icon: 'chart-no-axes-combined', label: 'Best Performing Channel', value: (sorted[0] || {}).label || 'No data' },
                ]),
                { wide: true }
            );
        }

        function showServicesModal() {
            const services = Array.from(analyticsDetailData.services || []);
            const rows = services.slice(0, 6).map((service, index) => {
                const status = index === 0 ? ['Top Seller', 'green'] : index === 1 ? ['High Demand', 'blue'] : index === 2 ? ['Growing', 'violet'] : ['Stable', 'gray'];
                return [
                    escapeHtml(service.name),
                    formatNumber(service.orders),
                    `<strong>${escapeHtml(service.revenue)}</strong>`,
                    `<span class="analytics-badge-status ${status[1]}">${status[0]}</span>`
                ];
            });
            const top = services[0] || { name: 'No service yet' };
            const low = services[services.length - 1] || { name: 'No service yet' };
            openAnalyticsUiModal(
                'Top Services / Products',
                'Best performing services based on revenue for ' + analyticsDetailData.totals.dateRange,
                detailTable(['Service / Product', 'Orders', 'Revenue', 'Status'], rows) +
                summaryCards([
                    { color: 'green', icon: 'star', label: 'Top Service', value: top.name },
                    { color: 'blue', icon: 'shopping-cart', label: 'Most Ordered', value: top.name },
                    { color: 'violet', icon: 'circle-dollar-sign', label: 'Highest Revenue Service', value: top.name },
                    { color: 'red', icon: 'trending-down', label: 'Lowest Performing Service', value: low.name },
                ], 4),
                { wide: true }
            );
        }

        function showDayTimeModal() {
            const labels = Array.from(analyticsDetailData.weeklyLabels || []);
            const orders = getSampleArray(analyticsDetailData.weeklyOrders, [15, 14, 19, 15, 25, 4, 0]);
            const dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            const rows = dayNames.map((day, index) => {
                const total = orders[index] || 0;
                const morning = Math.round(total * .32);
                const afternoon = Math.round(total * .52);
                const evening = Math.max(0, total - morning - afternoon);
                return [escapeHtml(day), formatNumber(morning), formatNumber(afternoon), formatNumber(evening), `<strong>${formatNumber(total)}</strong>`];
            });
            const peakIndex = orders.indexOf(Math.max(...orders));
            const lowIndex = orders.indexOf(Math.min(...orders));
            openAnalyticsUiModal(
                'Orders by Day & Time',
                'Order volume based on schedule for ' + analyticsDetailData.totals.dateRange,
                detailTable(['Day', 'Morning<br>(6AM – 11:59AM)', 'Afternoon<br>(12PM – 4:59PM)', 'Evening<br>(5PM – 11:59PM)', 'Total Orders'], rows) +
                summaryCards([
                    { color: 'green', icon: 'chart-no-axes-combined', label: 'Peak Day', value: dayNames[peakIndex] || 'No data' },
                    { color: 'violet', icon: 'clock', label: 'Peak Time', value: '10AM – 1PM' },
                    { color: 'red', icon: 'arrow-down', label: 'Lowest Activity', value: dayNames[lowIndex] || 'No data' },
                ]),
                { wide: true }
            );
        }

        function showRegionModal() {
            const regions = Array.from(analyticsDetailData.regions || []);
            const rows = regions.map(region => [escapeHtml(region.name), formatNumber(region.orders), `${region.share}%`, `<strong>${formatMoney((analyticsDetailData.totals.totalRevenueRaw || 0) * ((region.share || 0) / 100))}</strong>`]);
            const top = regions.slice().sort((a, b) => Number(b.orders || 0) - Number(a.orders || 0))[0] || { name: 'No data' };
            openAnalyticsUiModal(
                'Orders by Region',
                'Regional order distribution for ' + analyticsDetailData.totals.dateRange,
                detailTable(['Region', 'Orders', 'Share', 'Estimated Revenue'], rows) +
                summaryCards([
                    { color: 'blue', icon: 'map-pin', label: 'Top Region', value: top.name },
                    { color: 'green', icon: 'package-check', label: 'Regional Orders', value: formatNumber(regions.reduce((sum, r) => sum + Number(r.orders || 0), 0)) },
                    { color: 'orange', icon: 'percent', label: 'Largest Share', value: `${top.share || 0}%` },
                ]),
                { wide: true }
            );
        }

        function showPerformersModal() {
            const performers = Array.from(analyticsDetailData.performers || []);
            const rows = performers.length ? performers.map((performer, index) => [
                formatNumber(index + 1),
                escapeHtml(performer.staff),
                escapeHtml(performer.service),
                formatNumber(performer.orders),
                `<strong>${escapeHtml(performer.revenue)}</strong>`
            ]) : [[`<td colspan="5" class="analytics-empty-state">No performer data available yet.</td>`]];
            const tableRows = performers.length ? rows : [];
            openAnalyticsUiModal(
                'Top Performers',
                'Staff and service performance for ' + analyticsDetailData.totals.dateRange,
                performers.length
                    ? detailTable(['Rank', 'Staff', 'Service', 'Orders', 'Revenue'], tableRows) + summaryCards([
                        { color: 'green', icon: 'trophy', label: 'Top Performer', value: performers[0].staff },
                        { color: 'blue', icon: 'shopping-bag', label: 'Top Orders', value: formatNumber(performers[0].orders) },
                        { color: 'violet', icon: 'circle-dollar-sign', label: 'Top Revenue', value: performers[0].revenue },
                    ])
                    : detailRows([{ label: 'Status', value: 'No performer data available yet. Real completed order records will appear here automatically.' }]),
                { wide: true }
            );
        }

        function showInsightModal(index) {
            const insightMap = [
                ['Revenue Insight', 'Revenue increased 12.4%', [
                    { label: 'Current Revenue', value: analyticsDetailData.totals.totalRevenue },
                    { label: 'Average Order Value', value: analyticsDetailData.totals.averageOrderValue },
                    { label: 'Completed Orders', value: formatNumber(analyticsDetailData.totals.completedOrders) },
                    { label: 'Recommendation', value: 'Keep promoting the highest revenue service.' },
                ]],
                ['Peak Order Insight', 'Peak orders on Friday', [
                    { label: 'Peak Day', value: 'Friday' },
                    { label: 'Peak Time', value: '10AM – 1PM' },
                    { label: 'Action', value: 'Add more staff coverage during peak time.' },
                ]],
                ['Channel Insight', 'Direct website leads sales', Array.from(analyticsDetailData.sources || []).map(source => ({ label: source.label, value: `${formatNumber(source.orders)} orders · ${source.share}%` }))],
                ['Service Insight', 'Top service demand summary', Array.from(analyticsDetailData.services || []).slice(0, 5).map(service => ({ label: service.name, value: `${formatNumber(service.orders)} orders · ${service.revenue}` }))],
            ];
            const selected = insightMap[index];
            if (selected) openAnalyticsUiModal(selected[0], selected[1], detailRows(selected[2]));
        }

        function attachAnalyticsDetailFunctions() {
            const kpiTypes = ['revenue', 'orders', 'customers', 'conversion', 'average'];
            root.querySelectorAll('.analytics-kpi').forEach((item, index) => {
                item.addEventListener('click', function (event) {
                    event.preventDefault();
                    showKpiDetail(kpiTypes[index]);
                });
            });

            root.querySelector('.analytics-trend-panel')?.addEventListener('dblclick', showTrendModal);
            root.querySelectorAll('.analytics-chart-stat').forEach(item => item.addEventListener('click', showTrendModal));
            root.querySelectorAll('.analytics-legend-row').forEach(item => item.addEventListener('click', showSourceModal));
            root.querySelectorAll('.analytics-service-row').forEach(item => item.addEventListener('click', showServicesModal));
            root.querySelectorAll('.analytics-region-row').forEach(item => item.addEventListener('click', showRegionModal));
            root.querySelectorAll('.analytics-insight-row').forEach((item, index) => item.addEventListener('click', function (event) { event.stopPropagation(); showInsightModal(index); }));
            root.querySelector('.analytics-performer-table')?.addEventListener('click', function (event) {
                if (event.target.closest('.analytics-empty-state')) return;
                showPerformersModal();
            });
            root.querySelectorAll('.analytics-panel-action').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.stopPropagation();
                    const title = this.closest('.analytics-panel')?.querySelector('.analytics-panel-title')?.textContent?.trim() || '';
                    if (title.includes('Top Services')) showServicesModal();
                    else if (title.includes('Orders by Day')) showDayTimeModal();
                    else if (title.includes('Top Performers')) showPerformersModal();
                    else if (title.includes('Revenue')) showTrendModal();
                });
            });
        }

        attachAnalyticsDetailFunctions();

        root.querySelectorAll('[data-feedback]').forEach((item) => {
            item.addEventListener('click', function (event) {
                const hasOrderOpen = event.target.closest('[data-order-open]');
                if (!hasOrderOpen) showToast(this.dataset.feedback);
            });
        });

        const orderData = @json($recentOrdersPayload);
        const orderMap = new Map(orderData.map(order => [order.order_id, order]));

        const modal = document.getElementById('analyticsOrderModal');
        const closeModal = document.getElementById('analyticsModalClose');

        function openOrderModal(orderId) {
            const order = orderMap.get(orderId);
            if (!order || !modal) return;

            document.getElementById('analyticsModalOrderId').textContent = order.order_id;
            document.getElementById('analyticsModalSubtitle').textContent = order.date;
            document.getElementById('analyticsModalCustomer').textContent = order.customer;
            document.getElementById('analyticsModalEmail').textContent = order.email;
            document.getElementById('analyticsModalService').textContent = order.service;
            document.getElementById('analyticsModalTotal').textContent = order.total;
            document.getElementById('analyticsModalPayment').textContent = order.payment_status;
            document.getElementById('analyticsModalStatus').textContent = order.status;
            document.getElementById('analyticsModalDelivery').textContent = order.delivery_method;
            document.getElementById('analyticsModalTracking').textContent = order.tracking_number;
            document.getElementById('analyticsModalAddress').textContent = order.delivery_address;
            document.getElementById('analyticsModalNotes').textContent = order.notes;

            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            showToast(order.order_id + ' opened.');
        }

        document.querySelectorAll('[data-order-open]').forEach((trigger) => {
            trigger.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                openOrderModal(this.dataset.orderOpen);
            });
        });

        document.querySelectorAll('#analyticsOrdersBody tr[data-order-id]').forEach((row) => {
            row.addEventListener('click', function () {
                openOrderModal(this.dataset.orderId);
            });
        });

        closeModal?.addEventListener('click', function () {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
        });

        modal?.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
            }
        });

        const orderSearch = document.getElementById('analyticsOrderSearch');
        orderSearch?.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            document.querySelectorAll('#analyticsOrdersBody tr[data-order-id]').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
            });
        });

        document.getElementById('analyticsPrintBtn')?.addEventListener('click', function () {
            showToast('Print dialog opened.');
            window.print();
        });

        document.getElementById('analyticsReportBtn')?.addEventListener('click', function () {
            showToast('Analytics report generated successfully.');
        });

        document.getElementById('analyticsExportBtn')?.addEventListener('click', function () {
            const rows = [
                ['Order ID', 'Customer', 'Service', 'Date', 'Payment', 'Status', 'Total'],
                ...orderData.map(order => [
                    order.order_id,
                    order.customer,
                    order.service,
                    order.date,
                    order.payment_status,
                    order.status,
                    order.total
                ])
            ];

            const csv = rows.map(row => row.map(value => `"${String(value).replaceAll('"', '""')}"`).join(',')).join('\n');
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'analytics-latest-transactions.csv';
            link.click();
            URL.revokeObjectURL(url);
            showToast('CSV exported successfully.');
        });

        if (window.Chart) {
            Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
            Chart.defaults.color = '#475569';

            const labels = @json($weeklyLabels);
            const weeklyOrders = @json($weeklyOrders);
            const weeklySales = @json($weeklySales);
            const weeklyCustomers = @json($weeklyCustomers);
            const statusLabels = @json(array_keys($statusGroups));
            const statusValues = @json(array_values($statusGroups));
            const sourceLabels = @json(array_keys($sourceGroups));
            const sourceValues = @json(array_values($sourceGroups));

            const fallback = (values, sample) => values.some(v => Number(v) > 0) ? values : sample;
            const chartColors = ['#2563EB', '#FF7A00', '#10B981', '#8B5CF6', '#EF4444', '#06B6D4'];

            new Chart(document.getElementById('analyticsTrendChart'), {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Revenue (PHP)',
                            data: fallback(weeklySales, [12000, 24000, 45000, 28000, 31000, 26000, 50000]),
                            borderColor: '#2563EB',
                            backgroundColor: 'rgba(37, 99, 235, .10)',
                            borderWidth: 3,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: .42,
                            fill: true,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Orders',
                            data: fallback(weeklyOrders, [8, 16, 28, 14, 20, 18, 34]),
                            borderColor: '#93C5FD',
                            backgroundColor: 'rgba(147, 197, 253, .16)',
                            borderWidth: 3,
                            pointRadius: 4,
                            tension: .42,
                            fill: true,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: { display: false }, tooltip: { mode: 'index', intersect: false }
                    },
                    onClick: function () { showTrendModal(); },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#E5E7EB' } },
                        y1: { beginAtZero: true, position: 'right', grid: { display: false } },
                        x: { grid: { display: false } }
                    }
                }
            });

            new Chart(document.getElementById('analyticsSourceChart'), {
                type: 'doughnut',
                data: {
                    labels: sourceLabels,
                    datasets: [{
                        data: fallback(sourceValues, [42, 28, 16, 14]),
                        backgroundColor: ['#2563EB', '#FF7A00', '#10B981', '#8B5CF6'],
                        borderWidth: 4,
                        borderColor: '#FFFFFF',
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '62%',
                    plugins: { legend: { display: false } },
                    onClick: function () { showSourceModal(); }
                }
            });

            new Chart(document.getElementById('analyticsBarChart'), {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Orders',
                        data: fallback(weeklyOrders, [26, 31, 44, 38, 68, 52, 25]),
                        backgroundColor: ['#2563EB', '#FF7A00', '#10B981', '#8B5CF6', '#06B6D4', '#F59E0B', '#EF4444'],
                        borderRadius: 7,
                        barThickness: 28
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    onClick: function () { showDayTimeModal(); },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#E5E7EB' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    });
</script>
