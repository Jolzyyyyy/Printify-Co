<x-app-layout>

    @php
        $portalUser = $portalUser ?? auth()->user();
        $isDeveloperPortal = isset($portalUser) && $portalUser->isDeveloper();
        $isAdminClientPortal = isset($portalUser) && $portalUser->isAdminClient();
        $headerAuditLogs = isset($recentAuditLogs)
            ? $recentAuditLogs
            : \App\Models\AuditLog::with(['actor', 'targetUser'])->latest()->limit(8)->get();
        $headerNotifications = $headerAuditLogs->map(fn ($log) => [
            'title' => \Illuminate\Support\Str::headline($log->event ?? 'System update'),
            'body' => trim(($log->actor?->name ?? 'System') . ($log->targetUser ? ' updated ' . $log->targetUser->name : ' activity recorded')),
            'time' => optional($log->created_at)->diffForHumans() ?? 'Just now',
        ])->values();
        if ($headerNotifications->isEmpty()) {
            $headerNotifications = collect([
                ['title' => 'Dashboard ready', 'body' => 'Admin workspace is ready for today.', 'time' => 'Now'],
                ['title' => 'System status', 'body' => 'No critical alerts detected.', 'time' => 'Now'],
            ]);
        }
        $dashboardOrders = \App\Models\Order::query();
        $dashboardActiveUsers = \App\Models\User::query()
            ->whereNotNull('email_verified_at')
            ->when($isDeveloperPortal, fn ($query) => $query
                ->where('role', \App\Models\User::ROLE_ADMIN_CLIENT)
                ->where('email', 'enchantingasha@gmail.com')
                ->whereNotNull('approved_at'))
            ->when($isAdminClientPortal, fn ($query) => $query
                ->where('role', \App\Models\User::ROLE_CUSTOMER)
                ->where('email', 'julieannecalusa@gmail.com')
                ->where('admin_client_id', $portalUser->id))
            ->when(!$isDeveloperPortal && !$isAdminClientPortal, fn ($query) => $query
                ->where('role', \App\Models\User::ROLE_CUSTOMER));
        $dashboardServices = \App\Models\Service::query()->where('is_active', true);
        $dashboardServiceAlerts = \App\Models\Service::query()
            ->where('is_active', true)
            ->withCount('activeVariations')
            ->orderBy('category')
            ->orderBy('name')
            ->limit(3)
            ->get()
            ->map(function ($service) {
                $category = strtolower((string) ($service->category ?? ''));
                $icon = str_contains($category, 'photo') || str_contains($category, 'id')
                    ? 'image'
                    : (str_contains($category, 'lamination') || str_contains($category, 'binding')
                        ? 'book-open'
                        : (str_contains($category, 'large') || str_contains($category, 'custom')
                            ? 'package'
                            : (str_contains($category, 'copy') || str_contains($category, 'scan')
                                ? 'copy'
                                : 'printer')));
                $variationCount = (int) $service->active_variations_count;

                return [
                    'name' => $service->name,
                    'category' => $service->category ?: 'General Service',
                    'icon' => $icon,
                    'options' => $variationCount,
                    'status' => $variationCount > 0 ? 'Live' : 'Needs setup',
                    'status_class' => $variationCount > 0 ? 'completed' : 'low',
                    'message' => $variationCount > 0
                        ? "{$variationCount} live service option" . ($variationCount === 1 ? '' : 's') . ' synced from the customer catalog.'
                        : 'No active options yet. Open the catalog to finish setup.',
                ];
            })
            ->values();
        $dashboardStats = [
            'revenue' => (float) (clone $dashboardOrders)->sum('total_price'),
            'orders' => (clone $dashboardOrders)->count(),
            'customers' => (clone $dashboardActiveUsers)->count(),
            'services' => (clone $dashboardServices)->count(),
            'pending' => (clone $dashboardOrders)->whereIn('status', ['Pending', 'For Verification'])->count(),
            'ready' => (clone $dashboardOrders)->whereIn('status', ['Ready', 'Ready / Delivery'])->count(),
            'completed' => (clone $dashboardOrders)->where('status', 'Completed')->count(),
            'cancelled' => (clone $dashboardOrders)->where('status', 'Cancelled')->count(),
        ];
        $dashboardServiceAlertCount = $dashboardServiceAlerts->count();
        $dashboardActiveUsersLabel = $isDeveloperPortal
            ? 'Active Admin Clients'
            : ($isAdminClientPortal ? 'Active Customers' : 'Active Users');
        $dashboardActiveUsersRoute = $isDeveloperPortal
            ? route('developer.admin-clients.index')
            : route('admin.customers');
        $dashboardRecentOrders = \App\Models\Order::with('user')->latest()->limit(5)->get();
        $portalRoleLabel = $isDeveloperPortal
            ? 'Developer'
            : ($isAdminClientPortal ? 'Admin Client' : 'Admin');
        $portalRoleUpper = strtoupper($portalRoleLabel);
        $portalTitle = $isDeveloperPortal ? 'Developer Dashboard' : 'ADMIN DASHBOARD';
        $portalKicker = $isDeveloperPortal ? 'Developer Management Portal' : 'Admin Management Portal';
        $portalTagline = $isDeveloperPortal
            ? 'Manage admin clients, services, analytics, and platform controls from one developer workspace.'
            : ($isAdminClientPortal
                ? 'Manage assigned customers, orders, reports, and reference profile activity from one admin-client workspace.'
                : 'Manage customers, orders, products, reports, and system activity from one admin workspace.');
        $portalDisplayName = $portalUser->name ?? $portalRoleLabel;
        $portalInitial = strtoupper(substr($portalDisplayName, 0, 1));
        $headerSearchItems = $isDeveloperPortal
            ? [
                ['title' => 'Dashboard', 'meta' => 'Developer overview and platform activity', 'url' => route('admin.dashboard')],
                ['title' => 'Manage Admin Clients', 'meta' => 'Approve, assign, and review admin clients', 'url' => route('developer.admin-clients.index')],
                ['title' => 'Orders', 'meta' => 'Developer order monitoring', 'url' => route('developer.orders.index')],
                ['title' => 'Services', 'meta' => 'Manage service catalog and availability', 'url' => route('developer.services.index')],
                ['title' => 'Customers', 'meta' => 'Review customer records and activity', 'url' => route('developer.customers.index')],
                ['title' => 'Analytics', 'meta' => 'Developer analytics and platform insights', 'url' => route('developer.analytics.index')],
                ['title' => 'Reports', 'meta' => 'Operational and performance reports', 'url' => route('developer.reports.index')],
                ['title' => 'Settings', 'meta' => 'Developer preferences and system controls', 'url' => route('developer.settings.index')],
            ]
            : [
                ['title' => 'Dashboard', 'meta' => 'Overview and recent transactions', 'url' => route('admin.dashboard')],
                ['title' => 'Customer/User', 'meta' => 'Manage registered users', 'url' => route('admin.customers')],
                ['title' => 'Orders', 'meta' => 'Order management and status tracking', 'url' => route('admin.orders')],
                ['title' => 'Products', 'meta' => 'Product inventory and services', 'url' => route('admin.products')],
                ['title' => 'Reports', 'meta' => 'Sales reports and export tools', 'url' => route('admin.reports')],
                ['title' => 'Analytics', 'meta' => 'Traffic and performance charts', 'url' => route('admin.analytics')],
                ['title' => 'Settings', 'meta' => 'Preferences and system controls', 'url' => route('admin.settings')],
            ];
    @endphp
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700&display=swap');
        
        :root {
            --sidebar-width: 260px;
            --sidebar-closed-width: 85px;
            --primary-purple: #2563EB;
            --staff-blue: #2563EB;
            --staff-blue-dark: #1D4ED8;
            --staff-blue-soft: #EFF6FF;
            --staff-orange: #FF7A00;
            --staff-dark: #111827;
            --staff-panel-w: 335px;
            --staff-panel-h: 430px;
            --bg-light: #F8FAFC;
            --header-height: 300px; 
            --card-radius: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --yellow-text: #FFB000;
            --green-card: #10B981;
            --blue-card: #3B82F6;
            --yellow-card: #F59E0B;
            --pink-card: #EC4899;
            --action-gradient: linear-gradient(135deg, #60A5FA, #E879F9);
            --action-green: #4ADE80;
            --action-yellow: #FBBF24;
        }

        body { 
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; 
            background-color: var(--bg-light); 
            margin: 0; color: #1E293B;
            overflow-x: hidden;
        }
        h1, .hero-main-title { font-family: 'Playfair Display', Georgia, serif; }
        h2, h3, .sidebar-link, .visual-card-title, .tool-panel-title, .panel-title, .chat-title { font-family: 'Poppins', system-ui, sans-serif; letter-spacing: 0; }

        /* --- SIDEBAR --- */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh;
            width: var(--sidebar-width); background: #FFFFFF;
            border-right: 1px solid #E2E8F0; z-index: 1000;
            display: flex; flex-direction: column;
            transition: var(--transition);
            box-shadow: 4px 0 24px rgba(0,0,0,0.02);
        }
        .sidebar.closed { width: var(--sidebar-closed-width); }
        
        .sidebar-header {
            padding: 1.5rem; display: flex; align-items: center; gap: 15px;
            border-bottom: 1px solid #F1F5F9;
        }
        .menu-toggle {
            cursor: pointer; padding: 10px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            transition: 0.2s; color: #64748B; background: #F8FAFC;
        }
        .menu-toggle:hover { background: #F1F5F9; color: var(--staff-blue); }
        .brand-name { font-weight: 900; font-size: 1.3rem; color: #0F172A; font-style: italic; letter-spacing: -1px; white-space: nowrap; }
        
        .nav-menu { flex: 1; padding: 12px 14px; overflow-y: auto; overflow-x: hidden; }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            padding: 9px 16px; margin-bottom: 3px;
            border-radius: 12px; color: #64748B;
            text-decoration: none; font-weight: 800; 
            font-size: 10px; text-transform: uppercase;
            transition: background-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
            cursor: pointer; position: relative;
            white-space: nowrap;
        }
        
        .sidebar-link:hover {
            background: #E8F0FF;
            color: var(--staff-blue);
            box-shadow: inset 0 0 0 1px #DBEAFE;
        }
        .sidebar-link.active {
            background: var(--staff-blue-soft); color: var(--staff-blue);
            box-shadow: none;
        }
        .sidebar-link.active::before {
            content: ''; position: absolute; left: 0; top: 25%; bottom: 25%;
            width: 4px; background: var(--staff-blue); border-radius: 0 4px 4px 0;
        }
        .sidebar-link.active::after {
            content: '\203A';
            margin-left: auto;
            color: var(--staff-blue);
            font-size: 16px;
            font-weight: 950;
        }
        .sidebar.closed .sidebar-link { justify-content: center; padding-left: 0; padding-right: 0; }
        .sidebar.closed .sidebar-link.active::after { display: none; }

        .nav-text { transition: opacity 0.2s; }

        /* --- MAIN WRAPPER --- */
        .admin-main-shell { 
            margin-left: var(--sidebar-width); 
            transition: var(--transition); 
        }
        .admin-main-shell.expanded { margin-left: var(--sidebar-closed-width); }

        /* --- HERO HEADER --- */
        .hero-banner {
            height: var(--header-height);
            background-size: cover; background-position: center;
            background-repeat: no-repeat;
            transition: background-image 1s ease-in-out;
            z-index: 1;
            background-size: cover; background-position: center;
            padding: 5px 60px;
            color: white; position: relative;
            display: flex; flex-direction: column; justify-content: space-between;
            overflow: visible;
        }
        .hero-banner::before { content:''; position:absolute; inset:0; background:linear-gradient(120deg,rgba(15,23,42,.78),rgba(15,23,42,.24)); z-index:-2; }
        .hero-banner::after {
            content: '';
            position: absolute;
            right: -80px;
            bottom: -130px;
            width: 330px;
            height: 330px;
            border-radius: 999px;
            background: rgba(255,255,255,0.1);
            z-index: -1;
            pointer-events: none;
        }

        .top-nav { height:44px; display: flex; justify-content: flex-end; align-items: center; gap: 10px; margin-top: 7px; position: relative; z-index: 20; flex-wrap: nowrap; }
        .header-icon-no-box { 
            position: relative; cursor: pointer; width: 38px; height: 38px; 
            display: grid; place-items: center; 
            padding: 0;
            background: transparent;
            border: 1px solid transparent;
            border-radius: 14px;
            font: inherit;
            transition: color 0.18s, background-color 0.18s, border-color 0.18s;
            color: rgba(255,255,255,0.7);
        }
        .header-icon-no-box:hover, .header-icon-no-box.is-active {
            color: white;
            background: rgba(241,245,249,0.24);
            border-color: rgba(255,255,255,0.18);
        }
        .red-dot { position: absolute; top: 2px; right: 1px; min-width: 16px; height: 16px; padding: 0 4px; background: var(--staff-orange); color:#fff; border-radius: 999px; border: 2px solid rgba(15,23,42,.78); display:grid; place-items:center; font-size:8px; font-weight:950; line-height:1; }
        
        .profile-area { display: flex; align-items: center; gap: 10px; background: transparent; padding: 0; border-radius: 0; border: 0; }
        .profile-pic { width: 40px; height: 40px; border-radius: 50%; border: 0; position: relative; overflow:hidden; background:var(--staff-blue); display:grid; place-items:center; color:white; font-weight:900; font-size:14px; }
        .profile-pic img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
        .green-dot { position: absolute; bottom: 4px; right: 3px; width: 8px; height: 8px; background: #22C55E; border-radius: 50%; border: none; box-shadow: 0 0 0 3px rgba(34,197,94,.22); }

        .hero-title-area { display: flex; flex-direction: column; justify-content: center; flex-grow: 1; margin-top: 20px; max-width:720px; position:relative; z-index:2; }
        .hero-title-area::before { content:''; width:74px; height:4px; border-radius:999px; background:linear-gradient(90deg,var(--staff-blue),#60A5FA); margin-bottom:18px; box-shadow:0 8px 20px rgba(37,99,235,.35); }
        .hero-kicker { font-size:13px; color:white; opacity:.9; font-weight:700; margin:0 0 2px; }
        .hero-kicker::before { content:''; display:inline-block; width:7px; height:7px; margin-right:7px; border-radius:999px; background:#60A5FA; box-shadow:0 0 12px #60A5FA; }
        .hero-main-title { font-size: clamp(2.1rem,4.4vw,3.35rem); font-weight: 700; color: var(--staff-orange); margin: 0; letter-spacing: 0; line-height:1; text-shadow: 0 4px 12px rgba(0,0,0,0.4); white-space:nowrap; }
        .hero-subline { margin-top:16px; max-width:600px; font-size:13px; line-height:1.7; color:rgba(255,255,255,.78); font-weight:600; }
        .dots-container{position:absolute;bottom:15px;left:50%;transform:translateX(-50%);display:flex;gap:8px;z-index:10}
        .dot{width:8px;height:8px;border:0;border-radius:50%;background:rgba(255,255,255,.42);cursor:pointer;transition:.2s}
        .dot.active{background:var(--staff-blue);transform:scale(1.35)}
        .quick-actions-container { position: absolute; right: 32px; bottom: 58px; display: flex; align-items: center; gap: 0; z-index: 10; padding:12px 14px; border:1px solid rgba(255,255,255,.22); border-radius:14px; background:rgba(17,24,39,.42); box-shadow:0 18px 50px rgba(0,0,0,.22); backdrop-filter:blur(12px); }
        .action-circle-group { display: flex; flex-direction: column; align-items: center; gap: 7px; cursor: pointer; min-width:88px; border-right:1px solid rgba(255,255,255,.12); }
        .action-circle-group:last-child { border-right:0; }
        .action-circle {
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; transition: transform 0.2s; box-shadow: 0 4px 15px rgba(0,0,0,0.25);
        }
        .action-circle-group:hover .action-circle { transform: translateY(-4px) scale(1.04); }
        .action-label { font-size: 9px; font-weight: 900; color: #E2E8F0; text-transform: capitalize; letter-spacing: 0.4px; }
        .circle-purple { background: linear-gradient(135deg,#8B5CF6,#4F46E5); }
        .circle-green { background: linear-gradient(135deg,#22C55E,#15803D); }
        .circle-yellow { background: linear-gradient(135deg,#F59E0B,#D97706); }
        .circle-blue { background: linear-gradient(135deg,#0EA5E9,#2563EB); }

        .content-container { padding: 28px 62px 52px; }
        .option-dashboard { max-width: 1400px; margin: 0 auto; }
        .option-page-head { display:flex; justify-content:space-between; align-items:flex-start; gap:18px; margin-bottom:16px; }
        .option-title { margin:0; font-size:29px; line-height:1; color:#172033; font-weight:900; letter-spacing:0; font-family:'Inter',system-ui,sans-serif!important; position:relative; padding-bottom:10px; }
        .option-title::before { content:''; position:absolute; left:0; bottom:0; width:42px; height:4px; border-radius:999px; background:var(--staff-blue); }
        .option-subtitle { margin:6px 0 0; color:#64748B; font-size:12px; font-weight:600; }
        .option-head-actions { display:flex; flex-direction:column; align-items:flex-end; gap:8px; margin-left:auto; }
        .option-refresh { border:0; background:var(--staff-blue); color:white; min-height:32px; padding:0 13px; border-radius:8px; font-weight:900; font-size:11px; display:flex; align-items:center; gap:7px; cursor:pointer; }
        .option-refresh:hover { background:var(--staff-dark); }
        .option-metrics { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:10px; margin-bottom:16px; }
        .option-metric { background:white; border:1px solid #111827; border-radius:10px; padding:11px; display:flex; align-items:center; gap:10px; min-height:66px; box-shadow:0 8px 20px -18px rgba(15,23,42,.45); cursor:pointer; }
        .option-metric:hover { background:#F8FAFC; box-shadow:0 10px 25px -18px rgba(15,23,42,.55); }
        .option-metric.blue { border-color:#2563EB; }
        .option-metric.yellow { border-color:#FBBF24; }
        .option-metric.green { border-color:#10B981; }
        .option-metric.red { border-color:#EF4444; }
        .option-metric.orange { border-color:#EA580C; }
        .option-metric.violet { border-color:#8B5CF6; }
        .option-metric-icon { width:32px; height:32px; border-radius:9px; display:grid; place-items:center; flex-shrink:0; }
        .option-metric small { display:block; color:#64748B; font-size:9px; font-weight:900; text-transform:uppercase; letter-spacing:.03em; margin-bottom:4px; }
        .option-metric strong { display:block; color:#172033; font-size:18px; font-weight:950; line-height:1; }
        .option-metric span { display:block; margin-top:4px; color:#10B981; font-size:9px; font-weight:900; }
        .option-grid-two { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
        .option-grid-three { display:grid; grid-template-columns:1fr 1.35fr 1fr; gap:16px; margin-bottom:16px; }
        .option-panel { background:white; border:1px solid #111827; border-radius:10px; padding:14px; box-shadow:0 8px 22px -18px rgba(15,23,42,.45); }
        .option-panel-title { margin:0 0 12px; font-size:14px; font-weight:950; color:#172033; }
        .live-row { display:grid; grid-template-columns:86px 62px 1fr 46px 58px; gap:9px; align-items:center; margin-bottom:9px; font-size:10px; font-weight:800; color:#475569; }
        .live-bar { height:6px; border-radius:999px; background:#E2E8F0; overflow:hidden; }
        .live-bar span { display:block; height:100%; border-radius:999px; background:var(--staff-blue); }
        .mini-status-row { display:grid; grid-template-columns:repeat(4,1fr); gap:8px; margin-top:12px; }
        .mini-status { border-radius:9px; background:#F8FAFC; padding:8px; font-size:9px; font-weight:900; color:#64748B; }
        .mini-status strong { display:block; margin-top:4px; font-size:17px; color:#172033; }
        .donut-snapshot { display:grid; grid-template-columns:150px 1fr; gap:12px; align-items:center; }
        .donut-snapshot svg { width:145px; height:145px; }
        .donut-center { font-size:25px; font-weight:950; fill:#172033; }
        .legend-line { display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:9px; font-size:11px; font-weight:800; color:#475569; }
        .legend-dot { width:9px; height:9px; border-radius:999px; display:inline-block; margin-right:7px; }
        .alert-line, .task-line, .activity-line { display:flex; align-items:flex-start; justify-content:space-between; gap:10px; padding:7px 0; border-bottom:1px solid #F1F5F9; font-size:11px; color:#475569; }
        .alert-line:last-child, .task-line:last-child, .activity-line:last-child { border-bottom:0; }
        .option-link { margin-top:10px; display:inline-flex; color:var(--staff-blue); font-size:11px; font-weight:900; text-decoration:none; }
        .customer-admin-layout { display:grid; grid-template-columns:300px 1fr; gap:16px; align-items:start; }
        .customer-list-panel { background:white; border:1px solid #111827; border-radius:10px; padding:12px; box-shadow:0 8px 22px -18px rgba(15,23,42,.45); }
        .customer-list-search { position:relative; margin-bottom:10px; }
        .customer-list-search input { width:100%; height:34px; border:1px solid #CBD5E1; border-radius:8px; padding:0 34px 0 12px; font-size:11px; outline:none; }
        .customer-list-search svg { position:absolute; right:12px; top:10px; width:16px; color:#64748B; }
        .customer-list-item { width:100%; border:1px solid transparent; background:white; border-radius:9px; padding:8px; display:flex; align-items:center; gap:9px; text-align:left; cursor:pointer; margin-bottom:5px; }
        .customer-list-item:hover, .customer-list-item.active { background:#EFF6FF; border-color:#BFDBFE; }
        .customer-detail-pane { min-width:0; }
        .customer-detail-head { display:flex; justify-content:space-between; align-items:flex-start; gap:14px; margin-bottom:12px; }
        .customer-detail-user { display:flex; align-items:center; gap:12px; }
        .detail-avatar { width:56px; height:56px; border-radius:50%; background:#0F172A; color:white; display:grid; place-items:center; font-weight:950; font-size:20px; overflow:hidden; flex-shrink:0; }
        .detail-avatar img { width:100%; height:100%; object-fit:cover; }
        .detail-tabs { display:flex; gap:18px; border-bottom:1px solid #E2E8F0; margin:8px 0 14px; }
        .detail-tab { padding:9px 0; color:#64748B; font-size:11px; font-weight:900; border:0; border-bottom:2px solid transparent; background:transparent; cursor:pointer; }
        .detail-tab.active { color:var(--staff-blue); border-color:var(--staff-blue); }
        .detail-columns { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
        .detail-block { background:transparent; }
        .detail-block h4 { margin:0 0 10px; color:#172033; font-size:13px; font-weight:950; }
        .detail-row { display:flex; justify-content:space-between; gap:12px; padding:7px 0; color:#475569; font-size:11px; border-bottom:1px solid #F1F5F9; }
        .detail-row strong { color:#172033; }
        .option-product-grid { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; }
        .option-product-card { border:1px solid #111827; border-radius:10px; background:white; overflow:hidden; box-shadow:0 8px 22px -18px rgba(15,23,42,.45); }
        .option-product-image { height:112px; background:#F8FAFC; display:grid; place-items:center; overflow:hidden; }
        .option-product-image img { width:100%; height:100%; object-fit:cover; }
        .option-product-body { padding:10px; }
        .option-product-body h4 { margin:0 0 4px; color:#172033; font-size:12px; font-weight:950; }
        .option-product-body p { margin:0 0 8px; color:#64748B; font-size:10px; min-height:24px; }
        .option-product-foot { display:flex; justify-content:space-between; align-items:center; color:#172033; font-size:11px; font-weight:900; }
        .option-side-nav { display:grid; gap:8px; }
        .option-side-nav button { height:40px; border:1px solid #E2E8F0; border-radius:8px; background:white; color:#475569; text-align:left; padding:0 12px; font-weight:900; font-size:12px; cursor:pointer; }
        .option-side-nav button.active, .option-side-nav button:hover { background:var(--staff-blue); color:white; border-color:var(--staff-blue); }
        .overview-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px; margin-bottom: 30px; }

        .visual-card {
            background: white; border-radius: 12px; border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); position: relative;
            overflow: hidden; display: flex; flex-direction: column;
            transition: box-shadow 0.2s ease, border-color 0.2s ease, transform 0.2s ease; cursor: pointer;
            min-height: 290px;
        }
        .visual-card:hover { border-color: #CBD5E1; box-shadow: 0 14px 25px -10px rgba(15,23,42,0.2); transform: translateY(-2px); }
        .visual-card-body { padding: 24px; flex: 1; min-height: 210px; }
        .visual-card-title { font-size: 14px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; display: block; }
        
        .donut-wrapper { position: relative; width: 110px; height: 110px; }
        .donut-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-weight: 800; font-size: 14px; color: #1e293b; }
        
        .bar-chart-container { display: flex; align-items: flex-end; gap: 10px; height: 80px; margin-top: 20px; }
        .bar-item { width: 100%; background: #CBD5E1; border-radius: 4px; position: relative; }

        .visual-footer {
            position: relative;
            padding: 0 26px;
            height: 56px;
            font-weight: 800;
            font-size: 11px;
            text-transform: uppercase;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            overflow: hidden;
            border-radius: 0 0 12px 12px;
        }
        .visual-footer::after {
            content: '';
            position: absolute;
            right: -2px;
            bottom: -1px;
            width: 64px;
            height: 31px;
            background: white;
            border-radius: 28px 0 0 0;
            opacity: 0.94;
        }
        .visual-footer::before {
            content: '';
            position: absolute;
            right: 42px;
            bottom: 0;
            width: 30px;
            height: 30px;
            background: inherit;
            border-bottom-right-radius: 28px;
            box-shadow: 12px 13px 0 white;
        }
        .visual-footer i, .visual-footer svg { position: relative; z-index: 1; }
        .visual-footer span { position: relative; z-index: 1; }

        .table-section { background: white; border-radius: 20px; border: 1px solid #e2e8f0; padding: 40px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .table-header-flex { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; }
        .table-controls { display: flex; align-items: center; gap: 12px; }
        .btn-filter { display: flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 12px; border: 1px solid #E2E8F0; background: white; color: #64748B; font-weight: 700; font-size: 13px; cursor: pointer; height: 45px; }
        .btn-export { background: var(--primary-purple); color: white; border: none; padding: 10px 25px; border-radius: 12px; font-weight: 700; font-size: 13px; cursor: pointer; height: 45px; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2); }

        .custom-table { width: 100%; border-collapse: collapse; }
        .custom-table th { text-align: left; padding: 16px 18px; font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.04em; border-bottom: 1px solid #E2E8F0; background: #F8FAFC; }
        .custom-table td { padding: 16px 18px; font-size: 14px; border-bottom: 1px solid #E2E8F0; }
        
        .status-pill { padding: 6px 16px; border-radius: 20px; font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; }
        .status-pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
        .status-shipped { background: #DCFCE7; color: #15803D; }
        .status-shipped::before { background: #15803D; }
        .status-pending { background: #FEF3C7; color: #B45309; }
        .status-pending::before { background: #B45309; }

        .action-dots { width: 38px; height: 38px; border-radius: 10px; border: 1px solid #E2E8F0; display: flex; align-items: center; justify-content: center; background: white; color: #94A3B8; cursor: pointer; }

        .admin-section-content { padding: 32px 70px 70px; }
        .admin-section-content > .main-wrapper,
        .admin-section-content > .analytics-section,
        .admin-section-content > .settings-section {
            width: 100% !important;
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }
        .admin-section-content .main-wrapper,
        .admin-section-content .analytics-section,
        .admin-section-content .settings-section {
            width: 100% !important;
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }
        .admin-section-content > .settings-section,
        .admin-section-content .settings-section { padding-top: 0 !important; }
        .admin-section-content .top-header { margin: 0 0 12px 0 !important; }
        .admin-section-content .giant-title,
        .admin-section-content .brand-font {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 32px !important;
            font-weight: 900 !important;
            letter-spacing: -1px !important;
            text-transform: none !important;
            margin: 0 0 35px 0 !important;
            color: #1E293B !important;
            line-height: 1.2 !important;
        }
        .admin-section-content .box-container,
        .admin-section-content .summary-card,
        .admin-section-content .setting-card,
        .admin-section-content .glass-card {
            border-radius: 12px !important;
            border: 1px solid #CBD5E1 !important;
            box-shadow: 0 4px 6px -1px rgba(15,23,42,0.04) !important;
        }
        .admin-section-content .main-table,
        .admin-section-content .custom-table,
        .admin-section-content .modern-items-table {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            table-layout: auto !important;
        }
        .admin-section-content .main-table th,
        .admin-section-content .custom-table th,
        .admin-section-content .modern-items-table th {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            color: #475569 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.04em !important;
            padding: 14px 18px !important;
            background: #F8FAFC !important;
            border-bottom: 1px solid #E2E8F0 !important;
            text-align: left !important;
            white-space: nowrap !important;
        }
        .admin-section-content .main-table td,
        .admin-section-content .custom-table td,
        .admin-section-content .modern-items-table td {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 14px !important;
            color: #1E293B !important;
            padding: 14px 18px !important;
            border-bottom: 1px solid #E2E8F0 !important;
            vertical-align: middle !important;
        }
        .custom-table tbody tr:hover,
        .admin-section-content .main-table tbody tr:hover,
        .admin-section-content .custom-table tbody tr:hover,
        .admin-section-content .modern-items-table tbody tr:hover {
            background: #F8FAFC !important;
        }
        .admin-section-content .section-title {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 14px !important;
            font-weight: 900 !important;
            color: #1E293B !important;
        }
        .admin-section-content *,
        .sidebar *,
        .admin-main-shell,
        .hero-banner {
            transition-property: background-color, color, border-color, box-shadow, opacity !important;
        }

        .header-search-wrap { display: flex; align-items: center; position: relative; width:360px; min-width:360px; }
        .header-search-box {
            width: 100%;
            height: 34px;
            border: 1px solid rgba(255,255,255,0.20);
            background: rgba(255,255,255,0.12);
            color: white;
            border-radius: 999px;
            padding: 0 44px 0 14px;
            font-size: 11px;
            font-weight: 700;
            outline: none;
            box-shadow: 0 10px 28px rgba(0,0,0,0.18);
            backdrop-filter: blur(10px);
        }
        .header-search-submit {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 26px;
            border: none;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }
        .header-search-submit:hover { background: var(--staff-blue); color: white; }
        .header-search-box::placeholder { color: rgba(255,255,255,0.74); }
        .header-tool-panel {
            position: absolute;
            top: 48px;
            right: 0;
            width: var(--staff-panel-w);
            height: var(--staff-panel-h);
            max-height: var(--staff-panel-h);
            overflow-y: auto;
            background: white;
            color: #1E293B;
            border: 1px solid rgba(226,232,240,.95);
            border-radius: 22px;
            box-shadow: 0 28px 80px rgba(15,23,42,.26);
            padding: 12px;
            z-index: 1200;
        }
        .header-tool-panel::before { content:''; position:absolute; top:-9px; right:31px; width:18px; height:18px; background:white; border-left:1px solid rgba(226,232,240,.95); border-top:1px solid rgba(226,232,240,.95); transform:rotate(45deg); }
        .panel-header{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:8px 8px 12px;position:relative;z-index:1}
        .panel-title{font-size:13px;font-weight:900;color:#111827}
        .panel-action{border:0;background:var(--staff-blue-soft);color:var(--staff-blue);border-radius:999px;padding:7px 10px;font-size:10px;font-weight:900;cursor:pointer}
        .panel-action:hover{background:var(--staff-dark);color:white}
        .tool-panel-title { font-size: 10px; font-weight: 950; color: #64748B; text-transform: uppercase; letter-spacing: .04em; padding: 8px 8px 10px; position:relative; z-index:1; }
        .staff-search-query{height:42px;margin:0 0 12px;display:flex;align-items:center;gap:9px;padding:0 12px;border:1px solid #E2E8F0;border-radius:14px;background:#F8FAFC;position:relative;z-index:1}
        .staff-search-query i{width:15px;height:15px;color:#64748B}
        .staff-search-query span{flex:1;min-width:0;color:#111827;font-size:11px;font-weight:800}
        .staff-search-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;position:relative;z-index:1}
        .staff-search-card{border:1px solid #BFDBFE;background:#EFF6FF;border-radius:14px;padding:9px;color:#111827;display:flex;align-items:center;gap:9px;text-decoration:none;transition:background .18s,border-color .18s}
        .staff-search-card:hover{background:#DBEAFE;border-color:#93C5FD}
        .staff-search-card .search-icon-tile{width:30px;height:30px;border-radius:12px;background:#fff;color:var(--staff-blue);display:grid;place-items:center;flex-shrink:0}
        .staff-search-list{position:relative;z-index:1}
        .search-panel-footer{position:sticky;bottom:-12px;margin:12px -12px -12px;padding:10px 12px;background:white;border-top:1px solid #E2E8F0;font-size:10px;font-weight:800;color:#64748B;z-index:2}
        .notification-item, .search-result-item {
            padding: 11px 10px;
            border-radius: 14px;
            border: 1px solid #E2E8F0;
            margin-bottom: 8px;
            background: white;
            cursor: pointer;
            transition: background-color 0.18s ease, border-color 0.18s ease;
            position: relative;
            z-index: 1;
        }
        .notification-item:hover, .search-result-item:hover {
            background: #EFF6FF;
            border-color: #BFDBFE;
        }
        .notification-title, .search-result-title { font-size: 12px; font-weight: 950; color: #1E293B; }
        .notification-body, .search-result-meta { font-size: 10px; color: #64748B; margin-top: 4px; line-height: 1.35; }
        .notification-time { font-size: 9px; font-weight: 900; color: var(--staff-blue); margin-top: 6px; }
        .chat-drawer {
            position: fixed;
            right: 18px;
            bottom: 0;
            width: 360px;
            height: min(470px, calc(100vh - 96px));
            background: white;
            border: 1px solid rgba(226,232,240,.95);
            border-bottom: 0;
            border-radius: 16px 16px 0 0;
            box-shadow: 0 -8px 56px rgba(15,23,42,0.28);
            z-index: 2147483000;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .chat-head { background: #111827; color: white; padding: 10px 12px; min-height:54px; display:flex; align-items:center; justify-content:space-between; }
        .chat-thread-select { padding: 10px 12px; border-bottom: 1px solid #E2E8F0; background: white; }
        .chat-thread-select select { width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 9px 10px; font-size: 12px; font-weight: 800; color: #1E293B; outline: none; background: #F8FAFC; }
        .chat-tools { display: flex; align-items: center; gap: 8px; padding: 10px 12px; border-bottom: 1px solid #E2E8F0; background: white; }
        .chat-tools input { flex: 1; border: 1px solid #E2E8F0; border-radius: 999px; padding: 9px 12px; font-size: 11px; outline: none; }
        .chat-chip { border: 1px solid #E2E8F0; background: #F8FAFC; border-radius: 999px; padding: 8px 10px; font-size: 10px; font-weight: 800; cursor: pointer; color: #475569; }
        .chat-chip:hover { background: #EEF2FF; border-color: #C7D2FE; color: #4F46E5; }
        .chat-title { font-size: 13px; font-weight: 900; }
        .chat-status { font-size: 10px; color: #34D399; font-weight: 800; }
        .chat-body { flex: 1; padding: 12px; overflow-y: auto; background: #F8FAFC; }
        .chat-message { max-width: 84%; padding: 9px 11px; border-radius: 14px; margin-bottom: 10px; font-size: 12px; line-height: 1.4; }
        .chat-message.customer { background: white; color: #1E293B; border: 1px solid #E2E8F0; }
        .chat-message.me { margin-left: auto; background: var(--staff-blue); color: white; border-bottom-right-radius: 5px; }
        .chat-input-row { padding: 12px; display:flex; gap:8px; border-top:1px solid #E2E8F0; }
        .chat-input-row input { flex:1; border:1px solid #CBD5E1; border-radius:999px; padding:10px 12px; font-size:12px; outline:none; }
        .chat-input-row button { width:40px; height:40px; border-radius:50%; border:none; background:var(--staff-blue); color:white; display:flex; align-items:center; justify-content:center; cursor:pointer; }
        .chat-input-row button:hover { background:var(--staff-dark); }

        .date-pill { background:white; padding:10px 20px; border-radius:12px; border:1px solid #111827; display:flex; align-items:center; gap:10px; font-size:13px; font-weight:700; color:#111827; }
        .date-pill i { width:16px; color:#111827; }
        .section-main-title{font-family:'Playfair Display',Georgia,serif!important;font-size:32px!important;font-weight:700!important;letter-spacing:0!important;margin:0;color:#111827}
        .section-main-title span{color:var(--staff-blue)}
        .btn-export,.btn-filter,.chat-chip{border:0!important;background:var(--staff-orange)!important;color:#111827!important;box-shadow:none!important}
        .btn-export:hover,.btn-filter:hover,.chat-chip:hover{background:var(--staff-dark)!important;color:white!important}
        .admin-section-content .main-table,
        .admin-section-content .custom-table,
        .admin-section-content table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        .admin-section-content .main-table th,
        .admin-section-content .custom-table th,
        .admin-section-content table th {
            background: #F8FAFC !important;
            color: #172033 !important;
            font-family: 'Inter', system-ui, sans-serif !important;
            font-size: 12px !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0 !important;
            padding: 14px 18px !important;
            border-bottom: 1px solid #CBD5E1 !important;
        }
        .admin-section-content .main-table td,
        .admin-section-content .custom-table td,
        .admin-section-content table td {
            color: #1E293B !important;
            font-family: 'Inter', system-ui, sans-serif !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            padding: 14px 18px !important;
            border-bottom: 1px solid #E2E8F0 !important;
        }
        .admin-section-content tbody tr:hover { background:#F8FAFC; }

        .staff-feedback-toast {
            position: fixed;
            top: 22px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2147483600;
            min-width: 260px;
            max-width: 520px;
            padding: 12px 18px;
            border-radius: 999px;
            background: #111827;
            color: white;
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            box-shadow: 0 18px 50px rgba(15,23,42,.24);
        }

        .content-container,
        .admin-section-content {
            padding: 28px 62px 52px !important;
        }
        .option-dashboard,
        .admin-section-content > .main-wrapper,
        .admin-section-content .main-wrapper,
        .admin-section-content > .analytics-section,
        .admin-section-content .analytics-section,
        .admin-section-content > .settings-section,
        .admin-section-content .settings-section {
            max-width: 1400px !important;
            width: 100% !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }
        .option-title,
        .admin-section-content .option-title,
        .admin-section-content .giant-title,
        .admin-section-content .brand-font {
            font-family: 'Playfair Display', Georgia, serif !important;
            font-size: 34px !important;
            font-weight: 700 !important;
            line-height: 1 !important;
            letter-spacing: 0 !important;
            color: #111827 !important;
            padding-top: 11px !important;
            padding-bottom: 0 !important;
            margin: 0 0 16px 0 !important;
            text-transform: none !important;
            position: relative !important;
        }
        .option-title::before,
        .admin-section-content .giant-title::before,
        .admin-section-content .brand-font::before {
            content: '' !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            bottom: auto !important;
            width: 34px !important;
            height: 3px !important;
            background: var(--staff-blue) !important;
            border-radius: 999px !important;
        }
        .option-subtitle,
        .detail-row,
        .alert-line,
        .task-line,
        .activity-line,
        .legend-line,
        .option-link,
        .date-pill {
            font-family: 'Inter', system-ui, sans-serif !important;
            letter-spacing: 0 !important;
            font-weight: 400 !important;
        }
        .option-panel-title,
        .option-metric small,
        .option-product-body h4,
        .detail-block h4,
        .panel-title,
        .tool-panel-title,
        .sidebar-link {
            font-family: 'Poppins', system-ui, sans-serif !important;
            font-weight: 600 !important;
            letter-spacing: 0 !important;
        }
        .option-panel,
        .customer-list-panel,
        .option-product-card,
        .table-section {
            border: 1px solid #111827 !important;
            border-radius: 10px !important;
            box-shadow: none !important;
        }
        .option-panel:hover,
        .option-metric:hover,
        .customer-list-item:hover,
        .customer-list-item.active,
        .option-product-card:hover,
        .staff-search-card:hover,
        .notification-item:hover,
        .search-result-item:hover {
            background: rgba(17, 24, 39, 0.08) !important;
            border-color: #111827 !important;
        }
        .option-refresh,
        .btn-filter,
        .btn-add,
        .btn-export,
        .panel-action,
        .chat-chip,
        .option-side-nav button {
            border: 0 !important;
            background: var(--staff-blue) !important;
            color: #111827 !important;
            min-width: 104px !important;
            height: 32px !important;
            min-height: 32px !important;
            padding: 0 14px !important;
            border-radius: 8px !important;
            font-family: 'Poppins', system-ui, sans-serif !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            letter-spacing: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 7px !important;
            box-shadow: none !important;
        }
        .option-refresh:hover,
        .btn-filter:hover,
        .btn-add:hover,
        .btn-export:hover,
        .panel-action:hover,
        .chat-chip:hover,
        .option-side-nav button:hover,
        .option-side-nav button.active {
            background: #111827 !important;
            color: white !important;
        }
        .toggle-track,
        .is-active .toggle-track {
            background: #10B981 !important;
        }
        .toggle-track::after {
            background: white !important;
        }
        .date-pill {
            border: 1px solid #E5E7EB !important;
            border-radius: 8px !important;
            height: 32px !important;
            padding: 0 12px !important;
            font-size: 11px !important;
            color: #111827 !important;
            background: white !important;
            min-width: 190px !important;
            justify-content: center !important;
        }
        .option-page-head {
            margin-bottom: 16px !important;
        }
        .quick-action-line {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #F1F5F9;
            color: #111827;
            text-decoration: none;
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 11px;
            letter-spacing: 0;
        }
        .quick-action-line:last-child {
            border-bottom: 0;
        }
        .quick-action-line strong {
            display: block;
            color: #111827;
            font-family: 'Poppins', system-ui, sans-serif;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.2;
            letter-spacing: 0;
        }
        .quick-action-line small {
            display: block;
            color: #64748B;
            font-size: 10px;
            line-height: 1.25;
        }
        .quick-action-icon {
            width: 27px;
            height: 27px;
            border-radius: 8px;
            background: #EFF6FF;
            color: var(--staff-blue);
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }
        .quick-action-icon i,
        .quick-action-line > i {
            width: 14px;
            height: 14px;
        }
        .quick-action-line > i:last-child {
            margin-left: auto;
            color: #64748B;
        }
        .quick-action-line:hover {
            background: rgba(17, 24, 39, 0.08);
            border-color: #111827;
        }

        @media(max-width:1024px){
            .admin-main-shell,.admin-main-shell.expanded{margin-left:var(--sidebar-closed-width)}
            .sidebar{width:var(--sidebar-closed-width)}
            .brand-name,.sidebar-link span,.sidebar-link.active::after{display:none!important}
            .sidebar-link{justify-content:center;padding-left:0;padding-right:0}
            .hero-banner{padding:5px 28px}
            .header-search-wrap{width:225px;min-width:225px}
            .quick-actions-container{right:28px}
            .action-circle-group{min-width:82px}
            .content-container,.admin-section-content{padding:32px 40px 60px}
            .stats-grid{grid-template-columns:repeat(2,1fr)}
        }
        @media(max-width:760px){
            .admin-main-shell,.admin-main-shell.expanded{margin-left:0}
            .sidebar{transform:translateX(-100%)}
            .sidebar.mobile-open{transform:translateX(0);width:var(--sidebar-width)}
            .hero-banner{height:390px;padding:16px}
            .top-nav{justify-content:flex-start;flex-wrap:wrap;height:auto}
            .header-search-wrap{order:10;width:100%;min-width:0;flex-basis:100%;margin-top:8px}
            .header-tool-panel{left:0;right:auto;width:100%}
            .quick-actions-container{left:16px;right:16px;bottom:28px;justify-content:space-between;padding:12px}
            .action-circle-group{min-width:auto;border-right:0}
            .hero-main-title{white-space:normal}
            .content-container,.admin-section-content{padding:20px 16px}
            .stats-grid{grid-template-columns:1fr}
            .overview-header{align-items:flex-start;gap:14px;flex-direction:column}
        }

        .detail-overlay { position: fixed; inset: 0; background: rgba(15,23,42,0.8); z-index: 2000; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); }
        .modal-card { background: white; width: 450px; border-radius: 28px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); animation: modalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
        @keyframes modalPop { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        [x-cloak] { display: none !important; }
    </style>

    <div class="staff-portal-shell {{ $isDeveloperPortal ? 'staff-portal-developer' : 'staff-portal-admin' }}" x-data="{
        sidebarOpen: true, 
        showDetail: false,
        searchOpen: false,
        notificationOpen: false,
        chatOpen: false,
        searchTerm: '',
        chatDraft: '',
        chatSearch: '',
        toastMessage: '',
        toastTimer: null,
        activeThreadId: 1,
        activeSlide: 0,
        slideTimer: null,
        notificationsRead: false,
        slides: [
            '{{ asset('images/Headerslides1.jpg') }}',
            '{{ asset('images/Headerslide2.jpg') }}',
            '{{ asset('images/Headerslides1.jpg') }}'
        ],
        notifications: @js($headerNotifications),
        chatThreads: [
            {
                id: 1,
                customer: 'Maria Santos',
                subject: 'Order pickup inquiry',
                messages: [
                    { from: 'customer', text: 'Hello po, ready na po ba for pickup yung order ko?', time: 'Now' }
                ]
            },
            {
                id: 2,
                customer: 'Juan Dela Cruz',
                subject: 'Print quotation',
                messages: [
                    { from: 'customer', text: 'Magkano po ang 100 pcs flyers, full color?', time: 'Now' }
                ]
            },
            {
                id: 3,
                customer: 'Aly Reyes',
                subject: 'File upload concern',
                messages: [
                    { from: 'customer', text: 'Hindi po ma-upload yung PDF ko. Pwede po pa-check?', time: 'Now' }
                ]
            }
        ],
        init() {
            const savedThreads = window.localStorage.getItem('printifyStaffInquiryThreads');
            if (savedThreads) {
                try { this.chatThreads = JSON.parse(savedThreads); } catch (error) {}
            }
            window.addEventListener('printify-admin-feedback', event => this.showToast(event.detail?.message || 'Action completed.'));
            this.slideTimer = setInterval(() => this.nextSlide(), 12000);
        },
        searchItems: @js($headerSearchItems),
        modalTitle: '', modalData: '', modalColor: '',
        get activeThread() {
            return this.chatThreads.find(thread => thread.id == this.activeThreadId) || this.chatThreads[0];
        },
        get filteredSearchItems() {
            if (!this.searchTerm.trim()) return this.searchItems;
            const term = this.searchTerm.toLowerCase();
            return this.searchItems.filter(item => (item.title + ' ' + item.meta).toLowerCase().includes(term));
        },
        get filteredChatMessages() {
            const messages = this.activeThread ? this.activeThread.messages : [];
            if (!this.chatSearch.trim()) return messages;
            const term = this.chatSearch.toLowerCase();
            return messages.filter(message => message.text.toLowerCase().includes(term));
        },
        submitSearch() {
            const firstResult = this.filteredSearchItems[0];
            if (firstResult) window.location.href = firstResult.url;
        },
        nextSlide() {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
        },
        goToSlide(index) {
            this.activeSlide = index;
            if (this.slideTimer) clearInterval(this.slideTimer);
            this.slideTimer = setInterval(() => this.nextSlide(), 12000);
        },
        openSearchPanel() {
            this.searchOpen = true;
            this.notificationOpen = false;
        },
        openNotifications() {
            this.notificationOpen = !this.notificationOpen;
            this.searchOpen = false;
            if (this.notificationOpen) this.notificationsRead = true;
        },
        addQuickReply(text) {
            this.chatDraft = text;
            this.sendChatMessage();
        },
        clearChat() {
            if (!this.activeThread) return;
            this.activeThread.messages = [
                { from: 'customer', text: 'Conversation cleared. Waiting for the next customer inquiry.', time: 'Now' }
            ];
            window.localStorage.setItem('printifyStaffInquiryThreads', JSON.stringify(this.chatThreads));
            this.showToast('Customer conversation cleared.');
        },
        sendChatMessage() {
            if (!this.chatDraft.trim() || !this.activeThread) return;
            this.activeThread.messages.push({ from: 'me', text: this.chatDraft.trim(), time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) });
            this.chatDraft = '';
            window.localStorage.setItem('printifyStaffInquiryThreads', JSON.stringify(this.chatThreads));
            this.showToast('Reply sent to customer.');
        },
        openModal(title, info, color) {
            this.modalTitle = title; this.modalData = info;
            this.modalColor = color; this.showDetail = true;
            this.showToast(title + ' opened.');
        },
        showToast(message) {
            this.toastMessage = message;
            if (this.toastTimer) clearTimeout(this.toastTimer);
            this.toastTimer = setTimeout(() => this.toastMessage = '', 2200);
        }
    }">
        <div class="staff-feedback-toast" x-show="toastMessage" x-transition x-cloak x-text="toastMessage"></div>
        
        <!-- SIDEBAR -->
        <aside class="sidebar" :class="!sidebarOpen ? 'closed' : ''">
            <div class="sidebar-header">
                <div class="menu-toggle" @click="sidebarOpen = !sidebarOpen">
                    <i data-lucide="menu"></i>
                </div>
                <span class="brand-name" x-show="sidebarOpen" x-transition>Printify Co.</span>
            </div>
            
            <nav class="nav-menu">
                <a href="{{ route('home') }}" class="sidebar-link staff-home-link">
                    <i data-lucide="home"></i>
                    <span style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">Go to Home</span>
                    <span class="nav-text" x-show="sidebarOpen" x-transition>Home</span>
                </a>
                <div class="my-4 border-t border-slate-50 mx-2" style="border-top: 1px solid #F1F5F9; margin: 15px 0;"></div>

                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ in_array($section, ['dashboard', 'developer-dashboard', 'admin-client-dashboard'], true) ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i> 
                    <span class="nav-text" x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>

                @if(isset($portalUser) && $portalUser->isDeveloper())
                    <a href="{{ route('developer.admin-clients.index') }}" class="sidebar-link">
                        <i data-lucide="shield-check"></i>
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Manage Admin Clients</span>
                    </a>
                    <a href="{{ route('developer.orders.index') }}" class="sidebar-link">
                        <i data-lucide="shopping-cart"></i>
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Orders</span>
                    </a>
                    <a href="{{ route('developer.services.index') }}" class="sidebar-link">
                        <i data-lucide="package"></i>
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Services</span>
                    </a>
                    <a href="{{ route('developer.customers.index') }}" class="sidebar-link">
                        <i data-lucide="users"></i>
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Customers</span>
                    </a>
                    <a href="{{ route('developer.reports.index') }}" class="sidebar-link">
                        <i data-lucide="file-text"></i>
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Reports</span>
                    </a>
                    <a href="{{ route('developer.analytics.index') }}" class="sidebar-link">
                        <i data-lucide="bar-chart-3"></i>
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Analytics</span>
                    </a>
                    <a href="{{ route('developer.settings.index') }}" class="sidebar-link">
                        <i data-lucide="settings"></i>
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Settings</span>
                    </a>
                @else
                    <a href="{{ route('admin.customers') }}" class="sidebar-link {{ $section == 'customers' ? 'active' : '' }}">
                        <i data-lucide="users"></i> 
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Customer/User</span>
                    </a>
                    <a href="{{ route('admin.orders') }}" class="sidebar-link {{ $section == 'orders' ? 'active' : '' }}">
                        <i data-lucide="shopping-cart"></i> 
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Orders</span>
                    </a>
                    <a href="{{ route('admin.products') }}" class="sidebar-link {{ $section == 'products' ? 'active' : '' }}">
                        <i data-lucide="package"></i> 
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Products</span>
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="sidebar-link {{ $section == 'analytics' ? 'active' : '' }}">
                        <i data-lucide="bar-chart-3"></i> 
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Analytics</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="sidebar-link {{ $section == 'reports' ? 'active' : '' }}">
                        <i data-lucide="file-text"></i> 
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Reports</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="sidebar-link {{ $section == 'settings' ? 'active' : '' }}">
                        <i data-lucide="settings"></i> 
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Settings</span>
                    </a>
                    <a href="{{ route('admin.helpcenter') }}" class="sidebar-link {{ $section == 'help center' ? 'active' : '' }}">
                        <i data-lucide="help-circle"></i> 
                        <span class="nav-text" x-show="sidebarOpen" x-transition>Help Center</span>
                    </a>
                @endif
            </nav>

            <form method="POST" action="{{ route('admin.logout') }}" style="padding: 20px; border-top: 1px solid #F1F5F9;">
                @csrf
                <button type="submit" class="sidebar-link" style="color: #EF4444; background: #FEF2F2; width: 100%; border: none;">
                    <i data-lucide="log-out"></i> <span class="nav-text" x-show="sidebarOpen" x-transition>Log Out</span>
                </button>
            </form>
        </aside>

        <div class="admin-main-shell" :class="!sidebarOpen ? 'expanded' : ''">
                <header class="hero-banner" :style="'background-image:url(' + slides[activeSlide] + ')'">
                    <div class="top-nav">
                        <div class="header-search-wrap" @click.outside="searchOpen = false">
                            <form @submit.prevent="submitSearch()" style="position:relative;width:100%;">
                                <input class="header-search-box" x-model="searchTerm" type="search" placeholder="Search products, orders, articles..." @focus="openSearchPanel()" @input.debounce.120ms="openSearchPanel()" @keydown.escape="searchOpen = false">
                                <button type="submit" class="header-search-submit" title="Search">
                                    <i data-lucide="search" style="width:17px"></i>
                                </button>
                            </form>
                            <div class="header-tool-panel" x-show="searchOpen || searchTerm.length > 0" x-transition x-cloak>
                                <div class="staff-search-query">
                                    <i data-lucide="search"></i>
                                    <span x-text="searchTerm || '{{ $isDeveloperPortal ? 'Search developer tools, admin clients, services...' : 'Search users, orders, products, reports...' }}'"></span>
                                </div>
                                <div class="staff-search-grid" x-show="!searchTerm.trim()">
                                    <template x-for="item in searchItems.slice(0,4)" :key="item.title">
                                        <a :href="item.url" class="staff-search-card">
                                            <div class="search-icon-tile"><i data-lucide="arrow-up-right" style="width:15px"></i></div>
                                            <div>
                                                <div class="search-result-title" x-text="item.title"></div>
                                                <div class="search-result-meta" x-text="item.meta"></div>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                                <div class="staff-search-list" x-show="searchTerm.trim()">
                                    <div class="tool-panel-title">Search Results</div>
                                    <template x-for="item in filteredSearchItems" :key="item.title">
                                        <a :href="item.url" class="search-result-item" style="display:block; text-decoration:none;">
                                            <div class="search-result-title" x-text="item.title"></div>
                                            <div class="search-result-meta" x-text="item.meta"></div>
                                        </a>
                                    </template>
                                </div>
                                <div class="search-panel-footer" x-show="filteredSearchItems.length === 0">No matching admin tools found.</div>
                            </div>
                        </div>
                        <div style="position:relative;" @click.outside="notificationOpen = false">
                            <button type="button" class="header-icon-no-box" :class="notificationOpen ? 'is-active' : ''" @click="openNotifications()" title="Notifications">
                                <i data-lucide="bell" style="width:20px"></i><div class="red-dot" x-show="!notificationsRead">3</div>
                            </button>
                            <div class="header-tool-panel" x-show="notificationOpen" x-transition x-cloak>
                                <div class="panel-header">
                                    <div class="panel-title">{{ $portalRoleLabel }} Notifications</div>
                                    <button type="button" class="panel-action" @click="notificationsRead = true">Mark read</button>
                                </div>
                                <template x-for="note in notifications" :key="note.title + note.time">
                                    <div class="notification-item" @click="openModal(note.title, note.body, '#2563EB')">
                                        <div class="notification-title" x-text="note.title"></div>
                                        <div class="notification-body" x-text="note.body"></div>
                                        <div class="notification-time" x-text="note.time"></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <button type="button" class="header-icon-no-box" :class="chatOpen ? 'is-active' : ''" @click="chatOpen = !chatOpen" title="Customer inquiries"><i data-lucide="mail" style="width:20px"></i><div class="red-dot">1</div></button>
                        
                        <div class="profile-area">
                            <div class="profile-pic">
                                <span>{{ $portalInitial }}</span>
                                <div class="green-dot"></div>
                            </div>
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-weight: 900; font-size: 10px; color: white; text-transform:uppercase;">{{ $portalRoleUpper }} / {{ $portalDisplayName }}</span>
                                <span style="font-size: 9px; color: #E2E8F0; font-weight: 800; text-transform:uppercase;">{{ $portalRoleUpper }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-title-area">
                        <p class="hero-kicker">{{ $portalKicker }}</p>
                        <h1 class="hero-main-title">{{ $portalTitle }}</h1>
                        @if($isAdminClientPortal)
                            <p class="hero-subline" style="margin-top:6px;font-weight:800;">Admin Client Dashboard</p>
                        @endif
                        <p class="hero-subline">{{ $portalTagline }}</p>
                    </div>

                    <div class="dots-container">
                        <template x-for="(slide, index) in slides" :key="slide + index">
                            <button type="button" class="dot" :class="activeSlide === index ? 'active' : ''" @click="goToSlide(index)" aria-label="Change header slide"></button>
                        </template>
                    </div>

                    <div class="quick-actions-container">
                        <div class="action-circle-group" @click="openModal('New Print Job', 'Initiating new printer workflow...', '#60A5FA')">
                            <div class="action-circle circle-purple"><i data-lucide="file-plus-2" style="width:24px"></i></div>
                            <span class="action-label">New Print Job</span>
                        </div>
                        <div class="action-circle-group" @click="openModal('System Status', 'All servers are running optimally.', '#4ADE80')">
                            <div class="action-circle circle-green"><i data-lucide="bar-chart-3" style="width:24px"></i></div>
                            <span class="action-label">System Status</span>
                        </div>
                        <div class="action-circle-group" @click="openModal('Printer Queue', '3 jobs currently in queue.', '#FBBF24')">
                            <div class="action-circle circle-yellow"><i data-lucide="layers" style="width:24px"></i></div>
                            <span class="action-label">Printer Queue</span>
                        </div>
                        <div class="action-circle-group" @click="chatOpen = true">
                            <div class="action-circle circle-blue"><i data-lucide="headphones" style="width:24px"></i></div>
                            <span class="action-label">Support</span>
                        </div>
                    </div>
                </header>

            @if($section == 'dashboard' || $section == 'developer-dashboard' || $section == 'admin-client-dashboard')
                @php
                    $dashboardRecentOrdersPayload = $dashboardRecentOrders->map(fn ($order) => [
                        'id' => '#'.$order->id,
                        'customer' => $order->user?->name ?? 'Customer',
                        'email' => $order->user?->email ?? 'customer@example.com',
                        'phone' => $order->user?->phone ?? '+63 900 000 0000',
                        'service' => $order->service?->name ?? $order->service_name ?? 'Print Service',
                        'date' => optional($order->created_at)->format('M d, Y h:i A') ?? 'Today',
                        'payment' => $order->payment_status ?? 'Paid',
                        'status' => $order->status ?? 'Recorded',
                        'total' => 'PHP '.number_format((float) ($order->total_price ?? 0), 2),
                        'address' => $order->delivery_address ?? 'Customer address not provided',
                        'fulfillmentType' => $order->delivery_method ?? 'Pickup',
                        'tracking' => $order->tracking_number ?? 'N/A',
                        'notes' => $order->notes ?? 'No special instructions.',
                    ])->values();
                @endphp
                <main class="content-container admin-dashboard-final" x-data="adminDashboardFinal()" x-init="init()">
                    @if($isAdminClientPortal)
                        <section class="dash-main-box" style="margin-bottom:14px;">
                            <h2 class="dash-card-title">Access Checklist</h2>
                            <div class="dash-mini-row">
                                <div class="dash-mini"><i data-lucide="badge-check" style="width:13px"></i>Approved<strong>Yes</strong></div>
                                <div class="dash-mini"><i data-lucide="user-check" style="width:13px"></i>Reference Profile<strong>Ready</strong></div>
                                <div class="dash-mini"><i data-lucide="users-round" style="width:13px"></i>Assigned Customers<strong>{{ number_format($dashboardStats['customers']) }}</strong></div>
                                <div class="dash-mini"><i data-lucide="clipboard-list" style="width:13px"></i>Managed Orders<strong>{{ number_format($dashboardStats['orders']) }}</strong></div>
                            </div>
                        </section>
                    @endif
                    <style>
                        .admin-dashboard-final{--dash-blue:#0b63f6;--dash-blue-dark:#084ac2;--dash-black:#050816;--dash-orange:#ff7a00;--dash-green:#10b981;--dash-red:#ef4444;--dash-yellow:#f59e0b;--dash-purple:#8b5cf6;--dash-line:#e8edf5;--dash-soft:#f8fafc;max-width:1360px!important;margin:0 auto!important;padding:18px 22px 26px!important;color:var(--dash-black);font-family:'Inter',system-ui,sans-serif;letter-spacing:.005em!important}.admin-dashboard-final *{box-sizing:border-box}.admin-dashboard-final button,.admin-dashboard-final input,.admin-dashboard-final select{font-family:'Inter',system-ui,sans-serif}.dash-feedback-toast{position:fixed;top:24px;left:50%;transform:translateX(-50%);z-index:7000;background:linear-gradient(135deg,var(--dash-blue),var(--dash-blue-dark));color:#fff;border-radius:999px;padding:12px 22px;font-size:13px;font-weight:700;box-shadow:0 14px 32px rgba(11,99,246,.28);text-align:center}.dash-page-head{display:flex;justify-content:space-between;align-items:flex-start;gap:18px;margin-bottom:15px}.dash-title-wrap{position:relative;padding-left:12px}.dash-title-wrap:before{content:"";position:absolute;left:0;top:2px;width:4px;height:46px;background:var(--dash-blue);border-radius:999px}.dash-title-wrap h1{font-family:'Playfair Display',Georgia,serif!important;font-size:38px!important;font-weight:700!important;line-height:1.05!important;letter-spacing:0!important;margin:0 0 7px!important;color:var(--dash-black)!important}.dash-title-wrap p{font-size:14px!important;font-weight:400!important;color:#344054!important;margin:0!important}.dash-head-actions{display:grid;grid-template-columns:128px 128px;grid-template-areas:"date date" "export refresh";gap:9px;align-items:stretch;justify-content:end;min-width:270px}.dash-date-control{grid-area:date;justify-content:space-between;width:100%;min-width:0}.dash-export-btn{grid-area:export}.dash-refresh-btn{grid-area:refresh}.dash-btn,.dash-date-control{height:40px;min-height:40px;border:0!important;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:0 14px;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;box-shadow:none!important;transition:background-color .18s ease,color .18s ease}.dash-btn svg,.dash-date-control svg{width:17px;height:17px;stroke-width:2.1}.dash-primary{background:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;color:#fff!important}.dash-outline,.dash-date-control{background:#f8fafc!important;color:var(--dash-black)!important}.dash-btn:hover,.dash-date-control:hover{background:var(--dash-black)!important;color:#fff!important}.dash-metrics{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:12px;margin-bottom:15px}.dash-metric{min-height:82px;background:#fff;border:1.4px solid #d8dee8;border-radius:12px;padding:13px 15px;display:flex;align-items:center;gap:13px;text-align:left;cursor:pointer;box-shadow:0 5px 18px rgba(5,8,22,.04);transition:background-color .18s ease,border-color .18s ease}.dash-metric:hover,.dash-main-box.clickable:hover{background:rgba(33,37,41,.08)!important}.dash-metric.blue{border-color:#0b63f6}.dash-metric.orange{border-color:#ff7a00}.dash-metric.green{border-color:#10b981}.dash-metric.red{border-color:#ef4444}.dash-metric.cyan{border-color:#0ea5e9}.dash-icon{width:46px;height:46px;border-radius:12px;display:grid;place-items:center;flex:0 0 auto}.dash-icon svg{width:26px;height:26px}.dash-blue-soft{background:#eaf1ff;color:#0b63f6}.dash-orange-soft{background:#fff3e6;color:#ff7a00}.dash-green-soft{background:#e4f8ee;color:#10b981}.dash-red-soft{background:#ffe9e9;color:#ef4444}.dash-cyan-soft{background:#e8f8ff;color:#0ea5e9}.dash-metric small{display:block;font-family:'Poppins',system-ui,sans-serif;font-size:10px;font-weight:600;color:#344054;text-transform:uppercase;margin-bottom:5px}.dash-metric strong{display:block;font-size:22px;line-height:1;font-weight:800;color:var(--dash-black);margin-bottom:7px}.dash-metric span{display:flex;align-items:center;gap:5px;color:#10b981;font-size:11px;font-weight:700}.dash-metric span.red-trend{color:#ef4444}.dash-grid-three{display:grid;grid-template-columns:1.05fr 1.35fr .95fr;gap:14px;margin-bottom:14px}.dash-grid-three.equal{grid-template-columns:1fr 1.35fr .95fr}.dash-main-box{background:#fff;border:1.4px solid #d8dee8;border-radius:12px;box-shadow:0 5px 18px rgba(5,8,22,.04);padding:15px;min-height:188px}.dash-main-box:hover{border-color:#c5ccd8}.dash-card-title{font-family:'Poppins',system-ui,sans-serif;font-size:15px;font-weight:600;color:var(--dash-black);margin:0 0 14px;position:relative;padding-left:14px}.dash-card-title:before{content:"";position:absolute;left:0;top:9px;width:8px;height:2px;border-radius:99px;background:var(--dash-orange)}.dash-live-row{display:grid;grid-template-columns:92px 62px 1fr 40px 50px;gap:8px;align-items:center;margin-bottom:9px;font-size:11px;color:#344054;font-weight:600}.dash-bar{height:7px;border-radius:999px;background:#e2e8f0;overflow:hidden}.dash-bar span{display:block;height:100%;border-radius:999px}.dash-ontime{display:flex;align-items:center;gap:5px;color:#10b981!important;font-size:10px!important;font-weight:700!important}.dash-dot{width:7px;height:7px;border-radius:999px;display:inline-block}.dash-dot.blue{background:#0b63f6}.dash-dot.orange{background:#ff7a00}.dash-dot.green{background:#10b981}.dash-dot.red{background:#ef4444}.dash-dot.purple{background:#8b5cf6}.dash-mini-row{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-top:13px}.dash-mini{border:1px solid #eef2f7;border-radius:9px;background:#fbfcfe;min-height:50px;padding:8px 10px;font-size:10px;color:#475467;font-weight:600}.dash-mini i{color:#64748b;margin-right:4px}.dash-mini strong{display:block;margin-top:6px;color:var(--dash-black);font-size:18px;font-weight:800}.dash-donut-wrap{display:grid;grid-template-columns:170px 1fr;gap:22px;align-items:center}.dash-donut-svg{width:165px;height:165px}.dash-donut-number{font-size:28px;font-weight:800;fill:var(--dash-black)}.dash-donut-label{font-size:12px;font-weight:600;fill:#64748b}.dash-legend{display:flex;flex-direction:column;gap:12px}.dash-legend-line{display:flex;align-items:center;justify-content:space-between;gap:12px;font-size:13px;color:#344054}.dash-legend-line span{display:flex;align-items:center;gap:8px}.dash-legend-line strong{font-weight:700}.dash-action-line,.dash-alert-line,.dash-task-line,.dash-activity-line{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:9px 0;border-bottom:1px solid #edf2f7;color:#344054;text-decoration:none;font-size:12px;background:transparent}.dash-action-line:last-child,.dash-alert-line:last-child,.dash-task-line:last-child,.dash-activity-line:last-child{border-bottom:0}.dash-action-line:hover{color:var(--dash-blue)}.dash-action-icon{width:30px;height:30px;border-radius:9px;background:#eaf1ff;color:var(--dash-blue);display:grid;place-items:center;flex:0 0 auto}.dash-action-icon svg{width:17px;height:17px}.dash-action-line strong{display:block;font-family:'Poppins',system-ui,sans-serif;font-size:12px;font-weight:600;color:var(--dash-black);line-height:1.2}.dash-action-line small{display:block;color:#64748b;font-size:10px;margin-top:2px}.dash-action-line>svg{width:17px;color:var(--dash-black);margin-left:auto}.dash-alert-copy{display:flex;align-items:center;gap:10px}.dash-alert-icon{width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff7ed;color:#ff7a00;flex:0 0 auto}.dash-count-pill{min-width:28px;min-height:24px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center;padding:0 9px;background:#fff1d6;color:#c26c00;font-size:12px;font-weight:800}.dash-count-pill.blue{background:#eaf1ff;color:#0b63f6}.dash-count-pill.red{background:#ffe9e9;color:#ef4444}.dash-link{display:inline-flex;align-items:center;gap:5px;margin-top:10px;color:var(--dash-blue);text-decoration:none;font-size:12px;font-weight:700}.dash-link:hover{color:var(--dash-black)}.dash-table{width:100%;border-collapse:collapse}.dash-table th{height:36px;text-align:left;background:#fbfcfe;border-bottom:1px solid #e8edf5;color:#344054;text-transform:uppercase;font-size:10px;font-weight:800;padding:0 12px}.dash-table td{height:40px;border-bottom:1px solid #e8edf5;color:var(--dash-black);font-size:12px;font-weight:500;padding:0 12px}.dash-table tbody tr:hover{background:#f8fafc}.dash-order-link{border:0;background:transparent;padding:0;color:var(--dash-blue);font-weight:800;cursor:pointer}.dash-order-link:hover{color:var(--dash-black);text-decoration:underline}.dash-product-cell{display:flex;align-items:center;gap:8px}.dash-product-img{width:24px;height:24px;border-radius:6px;background:#e8edf5;display:grid;place-items:center;color:#64748b}.dash-pill{display:inline-flex;align-items:center;gap:5px;min-height:24px;border-radius:999px;padding:0 10px;font-size:11px;font-weight:800}.dash-pill.low{background:#fff0d4;color:#c26c00}.dash-pill.completed{background:#dff8ec;color:#0f7a4f}.dash-pill.processing{background:#fff0d4;color:#c26c00}.dash-pill.new{background:#dbeafe;color:#0b63f6}.dash-footer{display:flex;justify-content:space-between;align-items:center;margin-top:10px;color:#667085;font-size:11px}.dash-modal-overlay{position:fixed;inset:0;background:rgba(5,8,22,.36);backdrop-filter:blur(3px);z-index:6500;display:flex;align-items:center;justify-content:center;padding:24px}.dash-order-modal{width:min(790px,96vw);max-height:92vh;overflow:auto;background:#fff;border:1.5px solid #d8dee8;border-radius:13px;box-shadow:0 28px 70px rgba(5,8,22,.25)}.dash-modal-head{height:56px;border-bottom:1px solid #e8edf5;padding:0 22px;display:flex;align-items:center;justify-content:space-between}.dash-modal-heading{display:flex;align-items:center;gap:10px}.dash-modal-heading h2{font-family:'Poppins',system-ui,sans-serif;font-size:17px;font-weight:600;margin:0}.dash-modal-heading span{width:5px;height:5px;background:#667085;border-radius:50%}.dash-modal-heading b{font-size:14px;color:#475467}.dash-icon-btn{width:32px;height:32px;border:0;background:transparent;border-radius:8px;display:grid;place-items:center;cursor:pointer;color:#050816}.dash-icon-btn:hover{background:transparent!important;color:var(--dash-blue)!important}.dash-modal-grid{display:grid;grid-template-columns:1fr 1fr .95fr;gap:10px;padding:16px 20px 10px}.dash-modal-card,.dash-items-card{background:#fbfcfe;border:0;border-radius:10px;padding:13px}.dash-modal-card h3,.dash-items-card h3{font-family:'Poppins',system-ui,sans-serif;font-size:12px;font-weight:600;margin:0 0 12px}.dash-customer-flex{display:flex;gap:12px;align-items:center}.dash-avatar{width:42px;height:42px;border-radius:50%;background:#eaf1ff;color:var(--dash-blue);display:grid;place-items:center}.dash-customer-flex strong,.dash-customer-flex small{display:block}.dash-customer-flex small{color:#64748b;font-size:11px;margin-top:3px}.dash-address{display:flex;gap:9px;font-size:12px;line-height:1.55;margin:0}.dash-address svg{width:16px;color:var(--dash-blue);flex:0 0 auto}.dash-status-strip{display:grid;grid-template-columns:1fr 1.2fr 1fr 1.1fr 1fr;margin:0 20px 10px;background:#fbfcfe;border-radius:10px;overflow:hidden}.dash-status-strip>div{padding:13px;border-right:1px solid #e8edf5}.dash-status-strip>div:last-child{border-right:0}.dash-status-strip span{display:block;font-size:10px;color:#64748b;font-weight:800;margin-bottom:6px}.dash-status-strip b{display:flex;align-items:center;gap:6px;font-size:12px}.dash-items-card{margin:0 20px 12px}.dash-items-card table{width:100%;border-collapse:collapse;font-size:12px}.dash-items-card th{height:34px;text-align:left;border-bottom:1px solid #e8edf5;text-transform:uppercase;font-size:10px;color:#475467;padding:0 9px}.dash-items-card td{border-bottom:1px solid #eef2f7;padding:9px;color:#050816;font-weight:600}.dash-modal-bottom{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;padding:0 20px 20px}.dash-modal-actions{display:flex;flex-direction:column;gap:8px}.dash-modal-actions .dash-btn{width:100%}@media(max-width:1200px){.dash-metrics{grid-template-columns:repeat(2,1fr)}.dash-grid-three,.dash-grid-three.equal{grid-template-columns:1fr}.dash-head-actions{min-width:260px}}@media(max-width:760px){.admin-dashboard-final{padding:16px!important}.dash-page-head{flex-direction:column}.dash-head-actions{width:100%;grid-template-columns:1fr 1fr}.dash-metrics,.dash-modal-grid,.dash-status-strip,.dash-modal-bottom{grid-template-columns:1fr}.dash-donut-wrap{grid-template-columns:1fr}.dash-status-strip>div{border-right:0;border-bottom:1px solid #e8edf5}.dash-status-strip>div:last-child{border-bottom:0}}
                    
                        /* V2 requested dashboard final fixes */
                        .admin-dashboard-final .dash-card-title{padding-left:0!important;margin-bottom:10px!important}.admin-dashboard-final .dash-card-title:before{display:none!important}.admin-dashboard-final .dash-metrics{gap:9px!important;margin-bottom:12px!important}.admin-dashboard-final .dash-metric{min-height:68px!important;padding:10px 12px!important;gap:10px!important;border-width:1.15px!important}.admin-dashboard-final .dash-icon{width:38px!important;height:38px!important;border-radius:10px!important}.admin-dashboard-final .dash-icon svg{width:22px!important;height:22px!important}.admin-dashboard-final .dash-metric small{font-size:9px!important;margin-bottom:3px!important}.admin-dashboard-final .dash-metric strong{font-size:19px!important;margin-bottom:5px!important}.admin-dashboard-final .dash-metric span{font-size:9.5px!important}.admin-dashboard-final .dash-main-box{min-height:auto!important;padding:13px!important;border-color:#d8dee8!important}.admin-dashboard-final .dash-grid-three{gap:12px!important;margin-bottom:12px!important}.admin-dashboard-final .dash-live-row{margin-bottom:7px!important}.admin-dashboard-final .dash-mini-row{gap:7px!important;margin-top:9px!important}.admin-dashboard-final .dash-mini{min-height:42px!important;padding:7px 8px!important}.admin-dashboard-final .dash-mini strong{font-size:16px!important;margin-top:4px!important}.admin-dashboard-final .dash-donut-wrap{grid-template-columns:135px 1fr!important;gap:16px!important}.admin-dashboard-final .dash-donut-svg{width:132px!important;height:132px!important}.admin-dashboard-final .dash-donut-number{font-size:23px!important}.admin-dashboard-final .dash-donut-label{font-size:11px!important}.admin-dashboard-final .dash-legend{gap:9px!important}.admin-dashboard-final .dash-legend-line{font-size:12px!important}.dash-plain-panel{background:transparent!important;border:0!important;box-shadow:none!important;border-radius:0!important;padding:6px 2px!important;min-height:auto!important}.dash-plain-panel:hover{background:transparent!important;border-color:transparent!important}.dash-plain-panel .dash-action-line,.dash-plain-panel .dash-task-line{background:transparent!important;border-bottom:1px solid #edf2f7!important;width:100%;text-align:left}.dash-plain-panel .dash-action-line:hover,.dash-plain-panel .dash-task-line:hover{background:transparent!important;color:var(--dash-blue)!important}.dash-plain-panel .dash-action-icon{background:#eaf1ff!important;color:var(--dash-blue)!important}.dash-alert-stock-grid{display:grid;grid-template-columns:minmax(0,1.8fr) minmax(260px,.8fr);gap:12px;margin-bottom:12px}.dash-alert-stock-box{padding:13px!important}.dash-alert-stock-inner{display:grid;grid-template-columns:minmax(0,.9fr) minmax(0,1.15fr);gap:18px;align-items:start}.dash-alert-area{border-right:1px solid #e8edf5;padding-right:18px}.dash-stock-area{min-width:0}.dash-alert-line,.dash-task-line{cursor:pointer;border:0;border-bottom:1px solid #edf2f7;width:100%;font-family:'Inter',system-ui,sans-serif}.dash-alert-line:hover,.dash-task-line:hover{color:var(--dash-blue)!important;background:transparent!important}.dash-alert-icon{background:#eaf1ff!important;color:var(--dash-blue)!important}.dash-alert-icon.red{background:#ffe9e9!important;color:var(--dash-red)!important}.dash-alert-icon.orange{background:#fff3e6!important;color:var(--dash-orange)!important}.dash-alert-icon.blue{background:#eaf1ff!important;color:var(--dash-blue)!important}.dash-stock-table tbody tr{cursor:pointer}.dash-stock-table tbody tr:hover{background:#f8fafc!important}.dash-table th{height:31px!important}.dash-table td{height:36px!important}.dash-product-img{background:#eef4ff!important;color:var(--dash-blue)!important}.dash-pill{min-height:21px!important;padding:0 8px!important}.dash-action-line{padding:7px 0!important}.dash-task-line{padding:8px 0!important}.dash-action-icon{width:28px!important;height:28px!important}.dash-action-icon svg{width:16px!important;height:16px!important}.dash-footer{margin-top:6px!important}@media(max-width:1200px){.dash-alert-stock-grid{grid-template-columns:1fr}.dash-alert-stock-inner{grid-template-columns:1fr}.dash-alert-area{border-right:0;border-bottom:1px solid #e8edf5;padding-right:0;padding-bottom:12px}}
                    </style>
                    <style id="dashboard-v3-user-final-fixes">
                        /* User final dashboard fixes */
                        .admin-dashboard-final .dash-title-wrap{padding-left:0!important;padding-top:12px!important;}
                        .admin-dashboard-final .dash-title-wrap:before{left:0!important;top:0!important;width:68px!important;height:4px!important;border-radius:999px!important;background:linear-gradient(90deg,var(--dash-blue),#4a90ff)!important;}
                        .admin-dashboard-final .dash-card-title{padding-left:0!important;margin-bottom:11px!important;}
                        .admin-dashboard-final .dash-card-title:before{display:none!important;}
                        .admin-dashboard-final .dash-metrics{grid-template-columns:repeat(5,minmax(0,1fr))!important;gap:10px!important;}
                        .admin-dashboard-final .dash-metric{min-height:74px!important;padding:11px 13px!important;gap:10px!important;}
                        .admin-dashboard-final .dash-metric .dash-icon{background:transparent!important;width:30px!important;height:30px!important;border-radius:0!important;}
                        .admin-dashboard-final .dash-metric .dash-icon svg{width:25px!important;height:25px!important;}
                        .admin-dashboard-final .dash-metric small{font-size:9px!important;margin-bottom:4px!important;}
                        .admin-dashboard-final .dash-metric strong{font-size:20px!important;margin-bottom:5px!important;}
                        .admin-dashboard-final .dash-metric span span{font-size:10px!important;}
                        .admin-dashboard-final .dash-grid-three{grid-template-columns:minmax(0,1.05fr) minmax(0,1.35fr) minmax(300px,.95fr)!important;}
                        .admin-dashboard-final .dash-grid-three.equal{grid-template-columns:minmax(0,1.05fr) minmax(0,1.35fr) minmax(300px,.95fr)!important;}
                        .admin-dashboard-final .dash-alert-stock-grid{grid-template-columns:minmax(0,calc(100% - 314px)) 300px!important;gap:14px!important;}
                        .admin-dashboard-final .dash-quick-panel,.admin-dashboard-final .dash-pending-panel,.admin-dashboard-final .dash-task-panel{width:300px!important;max-width:300px!important;justify-self:stretch!important;}
                        .admin-dashboard-final .dash-main-box{min-height:168px!important;padding:14px!important;}
                        .admin-dashboard-final .dash-plain-panel{padding:2px 0!important;background:transparent!important;border:0!important;box-shadow:none!important;}
                        .admin-dashboard-final .dash-action-line,.admin-dashboard-final .dash-task-line,.admin-dashboard-final .dash-alert-line{min-height:38px!important;padding:7px 0!important;}
                        .admin-dashboard-final .dash-action-icon{background:transparent!important;color:var(--dash-blue)!important;width:24px!important;height:24px!important;border-radius:0!important;}
                        .admin-dashboard-final .dash-action-line:hover .dash-action-icon{color:var(--dash-black)!important;}
                        .admin-dashboard-final .dash-alert-icon{background:transparent!important;width:24px!important;height:24px!important;border-radius:0!important;}
                        .admin-dashboard-final .dash-product-img{background:transparent!important;color:#64748b!important;}
                        .admin-dashboard-final .dash-alert-stock-box{min-height:164px!important;}
                        .admin-dashboard-final .dash-alert-stock-inner{grid-template-columns:minmax(0,.82fr) minmax(0,1.18fr)!important;gap:14px!important;}
                        @media(max-width:1200px){.admin-dashboard-final .dash-grid-three,.admin-dashboard-final .dash-grid-three.equal,.admin-dashboard-final .dash-alert-stock-grid{grid-template-columns:1fr!important}.admin-dashboard-final .dash-quick-panel,.admin-dashboard-final .dash-pending-panel,.admin-dashboard-final .dash-task-panel{width:100%!important;max-width:100%!important}.admin-dashboard-final .dash-metrics{grid-template-columns:repeat(2,minmax(0,1fr))!important}}
                    </style>


                    <style id="dashboard-v4-low-stock-width-align-fix">
                        /* V4: align System Alerts + Low Stock Alerts with the same 3-column dashboard grid */
                        .admin-dashboard-final .dash-grid-three,
                        .admin-dashboard-final .dash-grid-three.equal{
                            grid-template-columns:minmax(0,1.05fr) minmax(0,1.35fr) minmax(300px,.95fr)!important;
                            gap:14px!important;
                        }
                        .admin-dashboard-final .dash-alert-stock-grid{
                            display:grid!important;
                            grid-template-columns:minmax(0,1.05fr) minmax(0,1.35fr) minmax(300px,.95fr)!important;
                            gap:14px!important;
                            align-items:start!important;
                            margin-bottom:12px!important;
                        }
                        .admin-dashboard-final .dash-alert-stock-box{
                            grid-column:1 / span 2!important;
                            width:100%!important;
                            max-width:100%!important;
                            min-width:0!important;
                        }
                        .admin-dashboard-final .dash-pending-panel{
                            grid-column:3!important;
                            width:100%!important;
                            max-width:100%!important;
                            min-width:0!important;
                        }
                        .admin-dashboard-final .dash-alert-stock-inner{
                            display:grid!important;
                            grid-template-columns:minmax(0,1.05fr) minmax(0,1.35fr)!important;
                            gap:14px!important;
                            align-items:start!important;
                        }
                        .admin-dashboard-final .dash-alert-area,
                        .admin-dashboard-final .dash-stock-area{
                            min-width:0!important;
                        }
                        .admin-dashboard-final .dash-stock-area{
                            overflow:hidden!important;
                        }
                        .admin-dashboard-final .dash-stock-table{
                            width:100%!important;
                            table-layout:fixed!important;
                        }
                        .admin-dashboard-final .dash-stock-table th:first-child,
                        .admin-dashboard-final .dash-stock-table td:first-child{width:52%!important;}
                        .admin-dashboard-final .dash-stock-table th:nth-child(2),
                        .admin-dashboard-final .dash-stock-table td:nth-child(2){width:23%!important;}
                        .admin-dashboard-final .dash-stock-table th:nth-child(3),
                        .admin-dashboard-final .dash-stock-table td:nth-child(3){width:25%!important;}
                        .admin-dashboard-final .dash-product-cell{
                            min-width:0!important;
                            white-space:nowrap!important;
                            overflow:hidden!important;
                            text-overflow:ellipsis!important;
                        }
                        @media(max-width:1200px){
                            .admin-dashboard-final .dash-grid-three,
                            .admin-dashboard-final .dash-grid-three.equal,
                            .admin-dashboard-final .dash-alert-stock-grid{
                                grid-template-columns:1fr!important;
                            }
                            .admin-dashboard-final .dash-alert-stock-box,
                            .admin-dashboard-final .dash-pending-panel{
                                grid-column:auto!important;
                            }
                            .admin-dashboard-final .dash-alert-stock-inner{
                                grid-template-columns:1fr!important;
                            }
                            .admin-dashboard-final .dash-alert-area{
                                border-right:0!important;
                                border-bottom:1px solid #e8edf5!important;
                                padding-right:0!important;
                                padding-bottom:12px!important;
                            }
                        }
                    </style>

                    <style id="admin-dashboard-oval-buttons-calendar-only">
                        /* Requested partial fix only: oval button shape + customer-style calendar/date UI. Admin colors stay blue. */
                        .admin-dashboard-final .dash-btn,
                        .admin-dashboard-final .dash-date-control,
                        .admin-dashboard-final .dash-icon-btn,
                        .admin-section-content .option-refresh,
                        .admin-section-content .btn-filter,
                        .admin-section-content .btn-add,
                        .admin-section-content .btn-export,
                        .admin-section-content .panel-action,
                        .admin-section-content .chat-chip,
                        .admin-section-content .option-side-nav button,
                        .admin-main-shell .option-refresh,
                        .admin-main-shell .btn-filter,
                        .admin-main-shell .btn-add,
                        .admin-main-shell .btn-export,
                        .admin-main-shell .panel-action,
                        .admin-main-shell .chat-chip,
                        .admin-main-shell .option-side-nav button{
                            border-radius:999px!important;
                        }
                        .admin-dashboard-final .dash-head-actions{
                            grid-template-columns:128px 128px!important;
                            grid-template-areas:"date date" "export refresh"!important;
                            align-items:stretch!important;
                            justify-content:end!important;
                        }
                        .admin-dashboard-final .dash-date-control{
                            grid-area:date!important;
                            width:100%!important;
                            min-width:265px!important;
                            height:42px!important;
                            padding:0 16px!important;
                            border:1px solid #d8dee8!important;
                            background:#ffffff!important;
                            color:#050816!important;
                            box-shadow:none!important;
                        }
                        .admin-dashboard-final .dash-date-control:hover,
                        .admin-dashboard-final .dash-date-control:focus{
                            background:#111827!important;
                            border-color:#111827!important;
                            color:#ffffff!important;
                        }
                        .admin-dashboard-final .dash-date-control:hover svg,
                        .admin-dashboard-final .dash-date-control:focus svg{
                            color:#ffffff!important;
                            stroke:#ffffff!important;
                        }
                        .admin-dashboard-final .dash-export-btn{grid-area:export!important;}
                        .admin-dashboard-final .dash-refresh-btn{grid-area:refresh!important;}

                        .admin-calendar-overlay{
                            position:fixed;
                            inset:0;
                            z-index:6900;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            padding:18px;
                            background:rgba(17,24,39,.36);
                            backdrop-filter:blur(9px);
                        }
                        .admin-calendar-modal{
                            width:min(920px,100%);
                            max-height:calc(100vh - 36px);
                            overflow:hidden;
                            border:1px solid #e8edf5;
                            border-radius:18px;
                            background:#fff;
                            box-shadow:0 26px 80px rgba(15,23,42,.22);
                            display:grid;
                            grid-template-columns:minmax(0,1.1fr) 310px;
                            color:#111827;
                        }
                        .admin-calendar-main{padding:18px;border-right:1px solid #e8edf5;min-width:0;}
                        .admin-calendar-side{padding:18px;background:#fbfbfb;min-width:0;}
                        .admin-calendar-top{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px;}
                        .admin-calendar-title{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:16px;font-weight:700;color:#111827;}
                        .admin-calendar-subtitle{margin:3px 0 0;font-size:11px;font-weight:400;color:#6b7280;line-height:1.45;}
                        .admin-calendar-nav{display:flex;align-items:center;gap:7px;}
                        .admin-calendar-icon-btn,
                        .admin-calendar-action-btn,
                        .admin-calendar-mini-btn,
                        .admin-calendar-save-btn,
                        .admin-calendar-clear-btn{
                            border-radius:999px!important;
                            cursor:pointer;
                            transition:background .18s ease,border-color .18s ease,color .18s ease,box-shadow .18s ease;
                            font-family:'Inter',system-ui,sans-serif;
                        }
                        .admin-calendar-icon-btn{
                            width:34px;height:34px;padding:0;border:1px solid #e8edf5;background:#fff;color:#111827;display:inline-flex;align-items:center;justify-content:center;
                        }
                        .admin-calendar-action-btn{
                            height:34px;padding:0 13px;border:1px solid #0b63f6;background:#0b63f6;color:#fff;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;gap:6px;
                        }
                        .admin-calendar-icon-btn:hover,
                        .admin-calendar-icon-btn:focus,
                        .admin-calendar-action-btn:hover,
                        .admin-calendar-action-btn:focus,
                        .admin-calendar-mini-btn:hover,
                        .admin-calendar-mini-btn:focus,
                        .admin-calendar-clear-btn:hover,
                        .admin-calendar-clear-btn:focus,
                        .admin-calendar-save-btn:hover,
                        .admin-calendar-save-btn:focus{
                            background:#111827!important;
                            border-color:#111827!important;
                            color:#fff!important;
                        }
                        .admin-calendar-weekdays,
                        .admin-calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:7px;}
                        .admin-calendar-weekdays{margin-bottom:7px;}
                        .admin-calendar-weekdays span{text-align:center;font-size:9.5px;font-weight:800;color:#6b7280;letter-spacing:.08em;text-transform:uppercase;}
                        .admin-calendar-day{position:relative;min-height:78px;border:1px solid #e8edf5;border-radius:12px;background:#fff;padding:8px;text-align:left;color:#111827;cursor:pointer;transition:.18s;overflow:hidden;}
                        .admin-calendar-day:hover,.admin-calendar-day:focus{border-color:#0b63f6;box-shadow:0 10px 24px rgba(11,99,246,.10);}
                        .admin-calendar-day.is-muted{background:#fafafa;color:#a1a1aa;cursor:default;}
                        .admin-calendar-day.is-today{border-color:#0b63f6;background:#eaf1ff;}
                        .admin-calendar-day.is-selected{border-color:#111827;background:rgba(17,24,39,.08);box-shadow:inset 0 0 0 1px #111827;}
                        .admin-calendar-day-number{display:block;font-size:12px;font-weight:800;line-height:1;}
                        .admin-calendar-day-events{display:flex;flex-wrap:wrap;gap:4px;margin-top:17px;}
                        .admin-calendar-event-dot{width:7px;height:7px;border-radius:999px;background:#0b63f6;box-shadow:0 0 0 3px rgba(11,99,246,.10);}
                        .admin-calendar-more{font-size:9px;font-weight:700;color:#6b7280;line-height:1;}
                        .admin-calendar-selected-date{margin:0 0 12px;font-family:'Poppins',system-ui,sans-serif;font-size:15px;font-weight:700;color:#111827;}
                        .admin-calendar-event-list{display:grid;gap:8px;max-height:182px;overflow:auto;padding-right:2px;margin-bottom:13px;}
                        .admin-calendar-event-item{border:1px solid #e8edf5;border-radius:12px;background:#fff;padding:10px;display:grid;gap:7px;}
                        .admin-calendar-event-title{font-size:12px;font-weight:800;color:#111827;line-height:1.3;}
                        .admin-calendar-event-meta{font-size:10px;font-weight:600;color:#0b63f6;line-height:1.35;}
                        .admin-calendar-event-note{font-size:10.5px;font-weight:400;color:#6b7280;line-height:1.45;}
                        .admin-calendar-event-actions{display:flex;gap:6px;justify-content:flex-end;}
                        .admin-calendar-mini-btn{height:27px;padding:0 10px;border:1px solid #e8edf5;background:#fff;color:#111827;font-size:9.5px;font-weight:800;}
                        .admin-calendar-mini-btn.danger{border-color:#fee2e2;color:#ef4444;}
                        .admin-calendar-mini-btn.danger:hover,.admin-calendar-mini-btn.danger:focus{background:#ef4444!important;border-color:#ef4444!important;color:#fff!important;}
                        .admin-calendar-form{display:grid;gap:9px;}
                        .admin-calendar-field{display:grid;gap:5px;}
                        .admin-calendar-field label{font-size:10px;font-weight:800;color:#4b5563;letter-spacing:.05em;text-transform:uppercase;}
                        .admin-calendar-field input,.admin-calendar-field textarea{width:100%;border:1px solid #e8edf5;border-radius:10px;background:#fff;padding:10px 11px;color:#111827;font-family:'Inter',system-ui,sans-serif;font-size:12px;font-weight:500;outline:none;transition:.18s;}
                        .admin-calendar-field textarea{min-height:68px;resize:vertical;}
                        .admin-calendar-field input:focus,.admin-calendar-field textarea:focus{border-color:#0b63f6;box-shadow:0 0 0 3px rgba(11,99,246,.10);}
                        .admin-calendar-form-actions{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:2px;}
                        .admin-calendar-save-btn{flex:1;height:36px;border:1px solid #0b63f6;background:#0b63f6;color:#fff;font-size:11px;font-weight:800;}
                        .admin-calendar-clear-btn{width:82px;height:36px;border:1px solid #e8edf5;background:#fff;color:#111827;font-size:11px;font-weight:800;}
                        .admin-calendar-empty{min-height:74px;border:1px dashed #d8dee8;border-radius:12px;display:grid;place-items:center;text-align:center;color:#6b7280;font-size:11px;font-weight:500;line-height:1.45;padding:12px;background:#fff;}
                        @media(max-width:820px){.admin-calendar-modal{grid-template-columns:1fr;overflow:auto}.admin-calendar-main{border-right:0;border-bottom:1px solid #e8edf5}.admin-calendar-day{min-height:62px}.admin-calendar-side{background:#fff}}

                        /* FINAL PATCH: customer-dashboard calendar width/design copied, admin blue retained. */
                        .admin-dashboard-final .dash-btn,
                        .admin-dashboard-final .dash-date-control,
                        .admin-dashboard-final .dash-export-btn,
                        .admin-dashboard-final .dash-refresh-btn,
                        .admin-dashboard-final .admin-calendar-action-btn,
                        .admin-dashboard-final .admin-calendar-save-btn,
                        .admin-dashboard-final .admin-calendar-clear-btn,
                        .admin-dashboard-final .admin-calendar-mini-btn{
                            border-radius:999px!important;
                        }
                        .admin-dashboard-final .dash-head-actions{
                            grid-template-columns:128px 128px!important;
                            grid-template-areas:"date date" "export refresh"!important;
                            justify-content:end!important;
                            align-items:stretch!important;
                            gap:9px!important;
                        }
                        .admin-dashboard-final .dash-date-control{
                            grid-area:date!important;
                            width:100%!important;
                            min-width:265px!important;
                            height:42px!important;
                            border-radius:999px!important;
                            background:#ffffff!important;
                            border:1px solid #d8dee8!important;
                            color:#050816!important;
                            padding:0 16px!important;
                        }
                        .admin-dashboard-final .dash-date-control:hover,
                        .admin-dashboard-final .dash-date-control:focus{
                            background:#111827!important;
                            border-color:#111827!important;
                            color:#ffffff!important;
                        }
                        .admin-dashboard-final .dash-date-control:hover svg,
                        .admin-dashboard-final .dash-date-control:focus svg{color:#ffffff!important;stroke:#ffffff!important;}
                        .admin-dashboard-final .dash-export-btn{grid-area:export!important;}
                        .admin-dashboard-final .dash-refresh-btn{grid-area:refresh!important;}

                        .admin-calendar-overlay{
                            position:fixed!important;
                            inset:0!important;
                            z-index:6900!important;
                            display:flex;
                            align-items:center!important;
                            justify-content:center!important;
                            padding:18px!important;
                            background:rgba(17,24,39,.36)!important;
                            backdrop-filter:blur(9px)!important;
                            -webkit-backdrop-filter:blur(9px)!important;
                        }
                        .admin-calendar-modal{
                            width:min(980px,calc(100vw - 48px))!important;
                            max-height:calc(100vh - 42px)!important;
                            overflow:hidden!important;
                            border:1.2px solid #111827!important;
                            border-radius:18px!important;
                            background:#ffffff!important;
                            box-shadow:0 26px 80px rgba(15,23,42,.22)!important;
                            display:grid!important;
                            grid-template-columns:minmax(0,650px) 330px!important;
                            color:#111827!important;
                        }
                        .admin-calendar-main{
                            padding:18px 18px 20px!important;
                            border-right:1px solid #e8edf5!important;
                            min-width:0!important;
                            background:#ffffff!important;
                        }
                        .admin-calendar-side{
                            padding:18px!important;
                            background:#ffffff!important;
                            min-width:0!important;
                        }
                        .admin-calendar-headline{
                            display:grid!important;
                            grid-template-columns:minmax(160px,1fr) auto 34px!important;
                            gap:14px!important;
                            align-items:start!important;
                            margin-bottom:16px!important;
                        }
                        .admin-calendar-intro h3{
                            margin:0 0 3px!important;
                            font-family:'Poppins',system-ui,sans-serif!important;
                            font-size:16px!important;
                            font-weight:700!important;
                            color:#111827!important;
                            line-height:1.2!important;
                        }
                        .admin-calendar-intro p{
                            width:150px!important;
                            margin:0!important;
                            font-size:11px!important;
                            font-weight:400!important;
                            line-height:1.45!important;
                            color:#6b7280!important;
                        }
                        .admin-calendar-nav-main{
                            display:flex;
                            align-items:center!important;
                            justify-content:center!important;
                            gap:38px!important;
                            padding-top:8px!important;
                        }
                        .admin-calendar-close-btn{margin-top:5px!important;}
                        .admin-calendar-monthbar{
                            display:flex;
                            align-items:center!important;
                            justify-content:space-between!important;
                            gap:12px!important;
                            margin-bottom:12px!important;
                        }
                        .admin-calendar-title{
                            margin:0!important;
                            font-family:'Poppins',system-ui,sans-serif!important;
                            font-size:14px!important;
                            font-weight:700!important;
                            color:#111827!important;
                            letter-spacing:0!important;
                        }
                        .admin-calendar-subtitle{display:none!important;}
                        .admin-calendar-nav{display:flex;align-items:center;gap:8px;}
                        .admin-calendar-icon-btn{
                            width:34px!important;
                            height:34px!important;
                            min-width:34px!important;
                            padding:0!important;
                            border:0!important;
                            border-radius:999px!important;
                            background:#ffffff!important;
                            color:#111827!important;
                            display:inline-flex!important;
                            align-items:center!important;
                            justify-content:center!important;
                            box-shadow:none!important;
                        }
                        .admin-calendar-icon-btn svg{width:20px!important;height:20px!important;stroke-width:2.2!important;}
                        .admin-calendar-icon-btn:hover,
                        .admin-calendar-icon-btn:focus{
                            background:#f4f6f9!important;
                            color:#111827!important;
                            border-color:transparent!important;
                            box-shadow:none!important;
                        }
                        .admin-calendar-action-btn,
                        .admin-calendar-clear-btn{
                            height:36px!important;
                            min-height:36px!important;
                            padding:0 18px!important;
                            border:1px solid #111827!important;
                            background:#ffffff!important;
                            background-image:none!important;
                            color:#111827!important;
                            font-size:11.5px!important;
                            font-weight:600!important;
                            display:inline-flex!important;
                            align-items:center!important;
                            justify-content:center!important;
                            gap:7px!important;
                            box-shadow:none!important;
                        }
                        .admin-calendar-today-btn{min-width:86px!important;}
                        .admin-calendar-use-top{min-width:104px!important;}
                        .admin-calendar-action-btn svg{width:17px!important;height:17px!important;}
                        .admin-calendar-action-btn:hover,
                        .admin-calendar-action-btn:focus,
                        .admin-calendar-clear-btn:hover,
                        .admin-calendar-clear-btn:focus{
                            background:#111827!important;
                            color:#ffffff!important;
                            border-color:#111827!important;
                            box-shadow:none!important;
                        }
                        .admin-calendar-action-btn:hover svg,
                        .admin-calendar-action-btn:focus svg{color:#ffffff!important;stroke:#ffffff!important;}
                        .admin-calendar-weekdays,
                        .admin-calendar-grid{
                            display:grid!important;
                            grid-template-columns:repeat(7,minmax(0,1fr))!important;
                            gap:7px!important;
                        }
                        .admin-calendar-weekdays{margin-bottom:7px!important;}
                        .admin-calendar-weekdays span{
                            text-align:center!important;
                            font-size:9.5px!important;
                            font-weight:800!important;
                            color:#6b7280!important;
                            letter-spacing:.08em!important;
                            text-transform:uppercase!important;
                        }
                        .admin-calendar-day{
                            min-height:78px!important;
                            border:1px solid #e8edf5!important;
                            border-radius:12px!important;
                            background:#ffffff!important;
                            padding:8px!important;
                            text-align:left!important;
                            color:#111827!important;
                            box-shadow:none!important;
                        }
                        .admin-calendar-day:hover,
                        .admin-calendar-day:focus{
                            border-color:#0b63f6!important;
                            box-shadow:0 10px 24px rgba(11,99,246,.10)!important;
                        }
                        .admin-calendar-day.is-today{
                            border-color:#0b63f6!important;
                            background:#f7fbff!important;
                        }
                        .admin-calendar-day.is-selected{
                            border-color:#111827!important;
                            background:rgba(17,24,39,.08)!important;
                            box-shadow:inset 0 0 0 1px #111827!important;
                        }
                        .admin-calendar-day-number{font-size:12px!important;font-weight:800!important;}
                        .admin-calendar-side .admin-calendar-selected-date{
                            margin:0 0 14px!important;
                            font-family:'Poppins',system-ui,sans-serif!important;
                            font-size:16px!important;
                            font-weight:700!important;
                            color:#111827!important;
                        }
                        .admin-calendar-empty{
                            min-height:74px!important;
                            border:1px dashed #d8dee8!important;
                            border-radius:12px!important;
                            display:grid!important;
                            place-items:center!important;
                            text-align:center!important;
                            color:#6b7280!important;
                            font-size:11px!important;
                            font-weight:400!important;
                            line-height:1.45!important;
                            padding:12px!important;
                            background:#ffffff!important;
                            margin-bottom:12px!important;
                        }
                        .admin-calendar-form{display:grid!important;gap:10px!important;}
                        .admin-calendar-field{display:grid!important;gap:5px!important;}
                        .admin-calendar-field label{
                            font-size:10px!important;
                            font-weight:800!important;
                            color:#4b5563!important;
                            letter-spacing:.05em!important;
                            text-transform:uppercase!important;
                        }
                        .admin-calendar-field input,
                        .admin-calendar-field textarea{
                            width:100%!important;
                            border:1px solid #e8edf5!important;
                            border-radius:10px!important;
                            background:#ffffff!important;
                            padding:10px 11px!important;
                            color:#111827!important;
                            font-size:12px!important;
                            font-weight:500!important;
                            outline:none!important;
                            box-shadow:none!important;
                        }
                        .admin-calendar-field textarea{min-height:68px!important;resize:vertical!important;}
                        .admin-calendar-field input:focus,
                        .admin-calendar-field textarea:focus{
                            border-color:#0b63f6!important;
                            box-shadow:0 0 0 3px rgba(11,99,246,.10)!important;
                        }
                        .admin-calendar-form-actions{
                            display:flex;
                            align-items:center!important;
                            justify-content:flex-end!important;
                            gap:8px!important;
                            margin-top:0!important;
                        }
                        .admin-calendar-save-btn{
                            flex:0 0 124px!important;
                            width:124px!important;
                            min-width:124px!important;
                            height:36px!important;
                            border:0!important;
                            background:#0b63f6!important;
                            background-image:none!important;
                            color:#ffffff!important;
                            font-size:11.5px!important;
                            font-weight:600!important;
                            box-shadow:none!important;
                        }
                        .admin-calendar-save-btn:hover,
                        .admin-calendar-save-btn:focus{
                            background:#111827!important;
                            color:#ffffff!important;
                        }
                        .admin-calendar-clear-btn{width:92px!important;min-width:92px!important;}
                        .admin-calendar-event-list{max-height:176px!important;margin-bottom:12px!important;}
                        @media(max-width:920px){
                            .admin-calendar-modal{grid-template-columns:1fr!important;width:min(720px,calc(100vw - 32px))!important;overflow:auto!important;}
                            .admin-calendar-main{border-right:0!important;border-bottom:1px solid #e8edf5!important;}
                            .admin-calendar-side{background:#ffffff!important;}
                            .admin-calendar-headline{grid-template-columns:1fr auto!important;}
                            .admin-calendar-nav-main{grid-column:1 / -1!important;justify-content:space-between!important;gap:12px!important;}
                        }
                    </style>
                    <style id="admin-calendar-force-close-fix">
                        /* Hard fix: hidden by default even if Alpine fails; opened only by class. */
                        .admin-calendar-overlay{display:none!important;}
                        .admin-calendar-overlay.is-open{display:flex!important;}
                        .admin-calendar-overlay[x-cloak]:not(.is-open){display:none!important;}
                        body.admin-calendar-lock{overflow:hidden!important;}
                    </style>

                    <style id="admin-final-close-save-gradient-patch">
                        /* Final requested fixes:
                           1) Calendar popup can close by X, outside click, Escape.
                           2) All SAVE / SAVED / SAVE CHANGES / SAVE PROFILE buttons are orange.
                           3) Regular blue admin buttons use blue gradient.
                           4) Oval button shape stays. */

                        .admin-dashboard-final,
                        .admin-section-content,
                        .option-dashboard{
                            --admin-blue-gradient:linear-gradient(135deg,#1274ff 0%,#0b63f6 55%,#084ac2 100%);
                            --admin-orange:#ff7a00;
                            --admin-orange-hover:#111827;
                        }

                        /* Blue admin buttons must be gradient, not flat blue. */
                        .admin-dashboard-final .dash-primary,
                        .admin-dashboard-final .dash-refresh-btn,
                        .admin-section-content .option-refresh,
                        .admin-section-content .btn-add,
                        .admin-section-content .btn-export,
                        .admin-section-content .btn-filter,
                        .admin-section-content .panel-action,
                        .admin-section-content .option-side-nav button.active,
                        .admin-section-content .option-side-nav button:hover,
                        .option-dashboard .option-refresh,
                        .option-dashboard .btn-add,
                        .option-dashboard .btn-export,
                        .option-dashboard .btn-filter,
                        .option-dashboard .panel-action{
                            background:var(--admin-blue-gradient)!important;
                            background-image:var(--admin-blue-gradient)!important;
                            color:#ffffff!important;
                            border:0!important;
                            border-radius:999px!important;
                            box-shadow:0 10px 22px rgba(11,99,246,.18)!important;
                        }
                        .admin-dashboard-final .dash-primary:hover,
                        .admin-dashboard-final .dash-refresh-btn:hover,
                        .admin-dashboard-final .dash-primary:focus,
                        .admin-dashboard-final .dash-refresh-btn:focus,
                        .admin-section-content .option-refresh:hover,
                        .admin-section-content .btn-add:hover,
                        .admin-section-content .btn-export:hover,
                        .admin-section-content .btn-filter:hover,
                        .admin-section-content .panel-action:hover,
                        .option-dashboard .option-refresh:hover,
                        .option-dashboard .btn-add:hover,
                        .option-dashboard .btn-export:hover,
                        .option-dashboard .btn-filter:hover,
                        .option-dashboard .panel-action:hover{
                            background:#111827!important;
                            background-image:none!important;
                            color:#ffffff!important;
                            box-shadow:0 10px 22px rgba(17,24,39,.18)!important;
                        }

                        /* Every save/save changes/save profile related button is always orange by default. */
                        .admin-calendar-save-btn,
                        button[class*="save" i],
                        a[class*="save" i],
                        input[type="submit"][value*="save" i],
                        button[name*="save" i],
                        button[id*="save" i],
                        button[class*="saved" i],
                        a[class*="saved" i],
                        button[class*="changes" i],
                        a[class*="changes" i],
                        button[class*="profile-save" i],
                        a[class*="profile-save" i],
                        .btn-save,
                        .save-btn,
                        .saved-btn,
                        .save-button,
                        .save-changes-btn,
                        .save-profile-btn,
                        .profile-save-btn,
                        .settings-save-btn,
                        .admin-save-btn{
                            background:var(--admin-orange)!important;
                            background-image:none!important;
                            color:#ffffff!important;
                            border:0!important;
                            border-radius:999px!important;
                            box-shadow:none!important;
                        }
                        .admin-calendar-save-btn:hover,
                        .admin-calendar-save-btn:focus,
                        button[class*="save" i]:hover,
                        button[class*="save" i]:focus,
                        a[class*="save" i]:hover,
                        a[class*="save" i]:focus,
                        input[type="submit"][value*="save" i]:hover,
                        input[type="submit"][value*="save" i]:focus,
                        button[name*="save" i]:hover,
                        button[id*="save" i]:hover,
                        button[class*="saved" i]:hover,
                        a[class*="saved" i]:hover,
                        button[class*="changes" i]:hover,
                        a[class*="changes" i]:hover,
                        .btn-save:hover,
                        .save-btn:hover,
                        .saved-btn:hover,
                        .save-button:hover,
                        .save-changes-btn:hover,
                        .save-profile-btn:hover,
                        .profile-save-btn:hover,
                        .settings-save-btn:hover,
                        .admin-save-btn:hover{
                            background:var(--admin-orange-hover)!important;
                            background-image:none!important;
                            color:#ffffff!important;
                            box-shadow:0 10px 22px rgba(17,24,39,.16)!important;
                        }

                        /* Calendar close must always be clickable and above all calendar content. */
                        .admin-calendar-overlay[x-cloak]{display:none!important;}
                        .admin-calendar-close-btn{
                            position:relative!important;
                            z-index:20!important;
                            pointer-events:auto!important;
                            cursor:pointer!important;
                            flex:0 0 34px!important;
                        }
                        .admin-calendar-close-btn:hover,
                        .admin-calendar-close-btn:focus{
                            background:#111827!important;
                            color:#ffffff!important;
                        }
                        .admin-calendar-close-btn:hover svg,
                        .admin-calendar-close-btn:focus svg{
                            color:#ffffff!important;
                            stroke:#ffffff!important;
                        }

                        /* Save Event specifically orange even inside the calendar modal. */
                        .admin-calendar-save-btn{
                            flex:0 0 124px!important;
                            width:124px!important;
                            min-width:124px!important;
                            height:36px!important;
                            min-height:36px!important;
                            font-size:11.5px!important;
                            font-weight:600!important;
                        }
                    </style>

                    
                    <style id="admin-calendar-visibility-final-fix">
                        /* FINAL FIX: do not force the calendar overlay visible.
                           Alpine x-show and x-cloak must control visibility. */
                        .admin-calendar-overlay[x-cloak]{display:none!important;}
                        .admin-calendar-overlay[style*="display: none"]{display:none!important;}
                        .admin-calendar-overlay{
                            pointer-events:auto;
                        }
                        body:not(.admin-calendar-lock) .admin-calendar-overlay:not([style*="display: none"]){
                            /* no forced display here; x-show controls it */
                        }
                    </style>

                    <style id="admin-requested-sidebar-calendar-button-final-fix">
                        /* Requested reset:
                           - restore sidebar hover/active colors
                           - restore calendar/date pill shape
                           - make all admin buttons match customer-dashboard compact sizing
                           - keep save buttons orange and blue buttons gradient
                           - calendar popup must stay closed on reload and only open by date button */

                        :root{
                            --admin-blue-gradient:linear-gradient(135deg,#1274ff 0%,#0b63f6 55%,#084ac2 100%);
                            --admin-blue:#2563EB;
                            --admin-blue-soft:#EFF6FF;
                            --admin-sidebar-hover:#E8F0FF;
                            --admin-orange:#ff7a00;
                            --admin-dark:#111827;
                        }

                        /* Sidebar restored to original admin hover/color behavior. */
                        .sidebar .sidebar-link{
                            color:#64748B!important;
                            background:transparent!important;
                            border-radius:12px!important;
                            box-shadow:none!important;
                        }
                        .sidebar .sidebar-link:hover{
                            background:var(--admin-sidebar-hover)!important;
                            color:var(--admin-blue)!important;
                            box-shadow:inset 0 0 0 1px #DBEAFE!important;
                        }
                        .sidebar .sidebar-link.active{
                            background:var(--admin-blue-soft)!important;
                            color:var(--admin-blue)!important;
                            box-shadow:none!important;
                        }
                        .sidebar .sidebar-link.active::before{
                            background:var(--admin-blue)!important;
                        }
                        .sidebar .sidebar-link.active::after{
                            color:var(--admin-blue)!important;
                        }
                        .sidebar form .sidebar-link,
                        .sidebar form .sidebar-link:hover{
                            color:#EF4444!important;
                            background:#FEF2F2!important;
                            box-shadow:none!important;
                        }

                        /* Customer-dashboard button sizing: compact, oval, same height/spacing. */
                        .admin-dashboard-final .dash-btn,
                        .admin-section-content .option-refresh,
                        .admin-section-content .btn-filter,
                        .admin-section-content .btn-add,
                        .admin-section-content .btn-export,
                        .admin-section-content .panel-action,
                        .admin-section-content .chat-chip,
                        .admin-section-content .option-side-nav button,
                        .option-dashboard .option-refresh,
                        .option-dashboard .btn-filter,
                        .option-dashboard .btn-add,
                        .option-dashboard .btn-export,
                        .option-dashboard .panel-action,
                        .admin-calendar-action-btn,
                        .admin-calendar-clear-btn,
                        .admin-calendar-save-btn,
                        .admin-calendar-mini-btn{
                            height:34px!important;
                            min-height:34px!important;
                            min-width:88px!important;
                            padding:0 16px!important;
                            border-radius:999px!important;
                            font-size:11.8px!important;
                            font-weight:500!important;
                            line-height:1!important;
                            letter-spacing:0!important;
                            display:inline-flex!important;
                            align-items:center!important;
                            justify-content:center!important;
                            gap:6px!important;
                            white-space:nowrap!important;
                            transform:none!important;
                            box-shadow:none!important;
                        }

                        /* Blue admin buttons remain blue gradient. */
                        .admin-dashboard-final .dash-primary,
                        .admin-dashboard-final .dash-refresh-btn,
                        .admin-section-content .option-refresh,
                        .admin-section-content .btn-add,
                        .admin-section-content .btn-export,
                        .admin-section-content .btn-filter,
                        .admin-section-content .panel-action,
                        .admin-section-content .option-side-nav button.active,
                        .option-dashboard .option-refresh,
                        .option-dashboard .btn-add,
                        .option-dashboard .btn-export,
                        .option-dashboard .btn-filter,
                        .option-dashboard .panel-action{
                            background:var(--admin-blue-gradient)!important;
                            background-image:var(--admin-blue-gradient)!important;
                            color:#ffffff!important;
                            border:0!important;
                        }
                        .admin-dashboard-final .dash-primary:hover,
                        .admin-dashboard-final .dash-refresh-btn:hover,
                        .admin-dashboard-final .dash-primary:focus,
                        .admin-dashboard-final .dash-refresh-btn:focus,
                        .admin-section-content .option-refresh:hover,
                        .admin-section-content .btn-add:hover,
                        .admin-section-content .btn-export:hover,
                        .admin-section-content .btn-filter:hover,
                        .admin-section-content .panel-action:hover,
                        .admin-section-content .option-side-nav button:hover,
                        .option-dashboard .option-refresh:hover,
                        .option-dashboard .btn-add:hover,
                        .option-dashboard .btn-export:hover,
                        .option-dashboard .btn-filter:hover,
                        .option-dashboard .panel-action:hover{
                            background:var(--admin-dark)!important;
                            background-image:none!important;
                            color:#ffffff!important;
                        }

                        /* Save buttons stay orange, with same customer-dashboard size. */
                        .admin-calendar-save-btn,
                        button[class*="save" i],
                        a[class*="save" i],
                        input[type="submit"][value*="save" i],
                        button[name*="save" i],
                        button[id*="save" i],
                        .btn-save,
                        .save-btn,
                        .saved-btn,
                        .save-button,
                        .save-changes-btn,
                        .save-profile-btn,
                        .profile-save-btn,
                        .settings-save-btn,
                        .admin-save-btn{
                            height:34px!important;
                            min-height:34px!important;
                            min-width:88px!important;
                            padding:0 16px!important;
                            border-radius:999px!important;
                            background:var(--admin-orange)!important;
                            background-image:none!important;
                            color:#ffffff!important;
                            border:0!important;
                            font-size:11.8px!important;
                            font-weight:500!important;
                            box-shadow:none!important;
                        }
                        .admin-calendar-save-btn:hover,
                        .admin-calendar-save-btn:focus,
                        button[class*="save" i]:hover,
                        button[class*="save" i]:focus,
                        a[class*="save" i]:hover,
                        a[class*="save" i]:focus,
                        input[type="submit"][value*="save" i]:hover,
                        input[type="submit"][value*="save" i]:focus,
                        .btn-save:hover,
                        .save-btn:hover,
                        .saved-btn:hover,
                        .save-button:hover,
                        .save-changes-btn:hover,
                        .save-profile-btn:hover,
                        .profile-save-btn:hover,
                        .settings-save-btn:hover,
                        .admin-save-btn:hover{
                            background:var(--admin-dark)!important;
                            background-image:none!important;
                            color:#ffffff!important;
                        }

                        /* Calendar/date pill restored: right-side solo pill, compact but readable. */
                        .admin-dashboard-final .dash-head-actions{
                            grid-template-columns:128px 128px!important;
                            grid-template-areas:"date date" "export refresh"!important;
                            justify-content:end!important;
                            align-items:stretch!important;
                            gap:9px!important;
                        }
                        .admin-dashboard-final .dash-date-control{
                            grid-area:date!important;
                            width:100%!important;
                            min-width:265px!important;
                            height:42px!important;
                            min-height:42px!important;
                            padding:0 16px!important;
                            border-radius:999px!important;
                            background:#ffffff!important;
                            background-image:none!important;
                            color:#050816!important;
                            border:1px solid #d8dee8!important;
                            box-shadow:none!important;
                            font-size:11.8px!important;
                            font-weight:500!important;
                        }
                        .admin-dashboard-final .dash-date-control:hover,
                        .admin-dashboard-final .dash-date-control:focus{
                            background:var(--admin-dark)!important;
                            border-color:var(--admin-dark)!important;
                            color:#ffffff!important;
                        }
                        .admin-dashboard-final .dash-date-control:hover svg,
                        .admin-dashboard-final .dash-date-control:focus svg{
                            color:#ffffff!important;
                            stroke:#ffffff!important;
                        }
                        .admin-dashboard-final .dash-export-btn{grid-area:export!important;}
                        .admin-dashboard-final .dash-refresh-btn{grid-area:refresh!important;}

                        /* Calendar popup hard visibility fix. Closed unless .is-open exists. */
                        .admin-calendar-overlay{
                            display:none!important;
                            position:fixed!important;
                            inset:0!important;
                            z-index:6900!important;
                            align-items:center!important;
                            justify-content:center!important;
                            padding:18px!important;
                            background:rgba(17,24,39,.36)!important;
                            backdrop-filter:blur(9px)!important;
                            -webkit-backdrop-filter:blur(9px)!important;
                        }
                        .admin-calendar-overlay.is-open{
                            display:flex!important;
                        }
                        .admin-calendar-overlay[x-cloak]:not(.is-open),
                        .admin-calendar-overlay[style*="display: none"]:not(.is-open){
                            display:none!important;
                        }
                        .admin-calendar-close-btn{
                            width:34px!important;
                            min-width:34px!important;
                            height:34px!important;
                            padding:0!important;
                            position:relative!important;
                            z-index:30!important;
                            pointer-events:auto!important;
                            cursor:pointer!important;
                            background:#ffffff!important;
                            color:#111827!important;
                            border:0!important;
                            border-radius:999px!important;
                        }
                        .admin-calendar-close-btn:hover,
                        .admin-calendar-close-btn:focus{
                            background:#f4f6f9!important;
                            color:#111827!important;
                        }
                    </style>


                    <style id="admin-dashboard-user-request-final-patch">
                        /* =========================================================
                           ADMIN DASHBOARD FINAL PATCH
                           - Calendar/date control restored to rounded-rectangle, not oval
                           - Admin dashboard buttons match customer dashboard sizing
                           - Export button has black border + black hover with white text
                           - Save buttons use green gradient
                           ========================================================= */
                        .admin-dashboard-final{
                            --admin-green-start:#22C55E!important;
                            --admin-green-end:#16A34A!important;
                            --admin-blue-start:#1274ff!important;
                            --admin-blue-end:#084ac2!important;
                            --admin-dark:#111827!important;
                        }

                        /* Customer-dashboard button sizing applied to admin dashboard buttons. */
                        .admin-dashboard-final .dash-btn,
                        .admin-dashboard-final .dash-export-btn,
                        .admin-dashboard-final .dash-refresh-btn,
                        .admin-dashboard-final .admin-calendar-action-btn,
                        .admin-dashboard-final .admin-calendar-mini-btn,
                        .admin-dashboard-final .admin-calendar-clear-btn,
                        .admin-dashboard-final .admin-calendar-save-btn,
                        .admin-dashboard-final button[class*="save" i],
                        .admin-dashboard-final a[class*="save" i],
                        .admin-dashboard-final input[type="submit"][value*="save" i],
                        .admin-section-content .option-refresh,
                        .admin-section-content .btn-add,
                        .admin-section-content .btn-filter,
                        .admin-section-content .btn-export,
                        .admin-section-content .panel-action,
                        .admin-section-content button[class*="save" i],
                        .admin-section-content a[class*="save" i],
                        .admin-section-content input[type="submit"][value*="save" i]{
                            height:34px!important;
                            min-height:34px!important;
                            min-width:88px!important;
                            padding:0 16px!important;
                            border-radius:8px!important;
                            font-size:11.8px!important;
                            font-weight:500!important;
                            line-height:1!important;
                            letter-spacing:0!important;
                            display:inline-flex!important;
                            align-items:center!important;
                            justify-content:center!important;
                            gap:6px!important;
                            box-shadow:none!important;
                            transform:none!important;
                            white-space:nowrap!important;
                        }

                        /* Date/calendar control: restored to customer-style rounded rectangle, not oval. */
                        .admin-dashboard-final .dash-head-actions{
                            grid-template-columns:128px 128px!important;
                            grid-template-areas:"date date" "export refresh"!important;
                            gap:9px!important;
                            justify-content:end!important;
                            align-items:stretch!important;
                        }
                        .admin-dashboard-final .dash-date-control{
                            grid-area:date!important;
                            width:100%!important;
                            min-width:265px!important;
                            height:42px!important;
                            min-height:42px!important;
                            padding:0 15px!important;
                            border-radius:8px!important;
                            border:1px solid #111827!important;
                            background:#ffffff!important;
                            background-image:none!important;
                            color:#111827!important;
                            font-size:12px!important;
                            font-weight:700!important;
                            line-height:1!important;
                            box-shadow:none!important;
                        }
                        .admin-dashboard-final .dash-date-control:hover,
                        .admin-dashboard-final .dash-date-control:focus{
                            background:#111827!important;
                            border-color:#111827!important;
                            color:#ffffff!important;
                        }
                        .admin-dashboard-final .dash-date-control:hover svg,
                        .admin-dashboard-final .dash-date-control:focus svg{
                            color:#ffffff!important;
                            stroke:#ffffff!important;
                        }

                        /* Export: white button, black border, black hover like requested. */
                        .admin-dashboard-final .dash-export-btn,
                        .admin-section-content .btn-export,
                        .option-dashboard .btn-export{
                            grid-area:export!important;
                            background:#ffffff!important;
                            background-image:none!important;
                            color:#111827!important;
                            border:1px solid #111827!important;
                            border-radius:8px!important;
                        }
                        .admin-dashboard-final .dash-export-btn:hover,
                        .admin-dashboard-final .dash-export-btn:focus,
                        .admin-section-content .btn-export:hover,
                        .admin-section-content .btn-export:focus,
                        .option-dashboard .btn-export:hover,
                        .option-dashboard .btn-export:focus{
                            background:#111827!important;
                            background-image:none!important;
                            border-color:#111827!important;
                            color:#ffffff!important;
                        }
                        .admin-dashboard-final .dash-export-btn:hover svg,
                        .admin-dashboard-final .dash-export-btn:focus svg,
                        .admin-section-content .btn-export:hover svg,
                        .admin-section-content .btn-export:focus svg,
                        .option-dashboard .btn-export:hover svg,
                        .option-dashboard .btn-export:focus svg{
                            color:#ffffff!important;
                            stroke:#ffffff!important;
                        }

                        /* Refresh and normal admin buttons keep admin blue but use the same size/shape. */
                        .admin-dashboard-final .dash-refresh-btn,
                        .admin-dashboard-final .dash-primary,
                        .admin-section-content .option-refresh,
                        .admin-section-content .btn-add,
                        .admin-section-content .btn-filter,
                        .admin-section-content .panel-action,
                        .option-dashboard .option-refresh,
                        .option-dashboard .btn-add,
                        .option-dashboard .btn-filter,
                        .option-dashboard .panel-action{
                            grid-area:refresh;
                            background:linear-gradient(135deg,var(--admin-blue-start) 0%,#0b63f6 54%,var(--admin-blue-end) 100%)!important;
                            color:#ffffff!important;
                            border:0!important;
                            border-radius:8px!important;
                        }
                        .admin-dashboard-final .dash-refresh-btn:hover,
                        .admin-dashboard-final .dash-refresh-btn:focus,
                        .admin-dashboard-final .dash-primary:hover,
                        .admin-dashboard-final .dash-primary:focus,
                        .admin-section-content .option-refresh:hover,
                        .admin-section-content .option-refresh:focus,
                        .admin-section-content .btn-add:hover,
                        .admin-section-content .btn-add:focus,
                        .admin-section-content .btn-filter:hover,
                        .admin-section-content .btn-filter:focus,
                        .admin-section-content .panel-action:hover,
                        .admin-section-content .panel-action:focus,
                        .option-dashboard .option-refresh:hover,
                        .option-dashboard .option-refresh:focus,
                        .option-dashboard .btn-add:hover,
                        .option-dashboard .btn-add:focus,
                        .option-dashboard .btn-filter:hover,
                        .option-dashboard .btn-filter:focus,
                        .option-dashboard .panel-action:hover,
                        .option-dashboard .panel-action:focus{
                            background:#111827!important;
                            background-image:none!important;
                            color:#ffffff!important;
                            border-color:#111827!important;
                        }

                        /* Save buttons: green gradient + customer-size button. */
                        .admin-dashboard-final .admin-calendar-save-btn,
                        .admin-dashboard-final button[class*="save" i],
                        .admin-dashboard-final a[class*="save" i],
                        .admin-dashboard-final input[type="submit"][value*="save" i],
                        .admin-section-content button[class*="save" i],
                        .admin-section-content a[class*="save" i],
                        .admin-section-content input[type="submit"][value*="save" i],
                        .admin-section-content .btn-save,
                        .admin-section-content .save-btn,
                        .admin-section-content .save-button,
                        .admin-section-content .save-changes-btn,
                        .admin-section-content .save-profile-btn,
                        .admin-section-content .settings-save-btn,
                        .admin-section-content .admin-save-btn{
                            height:34px!important;
                            min-height:34px!important;
                            min-width:88px!important;
                            padding:0 16px!important;
                            border-radius:8px!important;
                            border:0!important;
                            background:linear-gradient(90deg,var(--admin-green-start) 0%,var(--admin-green-end) 100%)!important;
                            background-image:linear-gradient(90deg,var(--admin-green-start) 0%,var(--admin-green-end) 100%)!important;
                            color:#ffffff!important;
                            font-size:11.8px!important;
                            font-weight:500!important;
                            line-height:1!important;
                            box-shadow:none!important;
                            display:inline-flex!important;
                            align-items:center!important;
                            justify-content:center!important;
                            gap:6px!important;
                        }
                        .admin-dashboard-final .admin-calendar-save-btn:hover,
                        .admin-dashboard-final .admin-calendar-save-btn:focus,
                        .admin-dashboard-final button[class*="save" i]:hover,
                        .admin-dashboard-final button[class*="save" i]:focus,
                        .admin-dashboard-final a[class*="save" i]:hover,
                        .admin-dashboard-final a[class*="save" i]:focus,
                        .admin-dashboard-final input[type="submit"][value*="save" i]:hover,
                        .admin-dashboard-final input[type="submit"][value*="save" i]:focus,
                        .admin-section-content button[class*="save" i]:hover,
                        .admin-section-content button[class*="save" i]:focus,
                        .admin-section-content a[class*="save" i]:hover,
                        .admin-section-content a[class*="save" i]:focus,
                        .admin-section-content input[type="submit"][value*="save" i]:hover,
                        .admin-section-content input[type="submit"][value*="save" i]:focus,
                        .admin-section-content .btn-save:hover,
                        .admin-section-content .btn-save:focus,
                        .admin-section-content .save-btn:hover,
                        .admin-section-content .save-btn:focus,
                        .admin-section-content .save-button:hover,
                        .admin-section-content .save-button:focus,
                        .admin-section-content .save-changes-btn:hover,
                        .admin-section-content .save-changes-btn:focus,
                        .admin-section-content .save-profile-btn:hover,
                        .admin-section-content .save-profile-btn:focus,
                        .admin-section-content .settings-save-btn:hover,
                        .admin-section-content .settings-save-btn:focus,
                        .admin-section-content .admin-save-btn:hover,
                        .admin-section-content .admin-save-btn:focus{
                            background:#111827!important;
                            background-image:none!important;
                            color:#ffffff!important;
                            border-color:#111827!important;
                        }

                        /* Calendar popup buttons keep clear separation. */
                        .admin-dashboard-final .admin-calendar-clear-btn{
                            background:#ffffff!important;
                            background-image:none!important;
                            color:#111827!important;
                            border:1px solid #111827!important;
                        }
                        .admin-dashboard-final .admin-calendar-clear-btn:hover,
                        .admin-dashboard-final .admin-calendar-clear-btn:focus{
                            background:#111827!important;
                            color:#ffffff!important;
                            border-color:#111827!important;
                        }

                        @media(max-width:760px){
                            .admin-dashboard-final .dash-head-actions{
                                width:100%!important;
                                grid-template-columns:1fr 1fr!important;
                            }
                            .admin-dashboard-final .dash-date-control{
                                min-width:0!important;
                            }
                        }
                    </style>

                    <div x-show="toast.show" x-transition class="dash-feedback-toast" x-text="toast.message" style="display:none"></div>



                    <style id="admin-dashboard-final-clean-fix-v2">
                        /* =========================================================
                           FINAL CLEAN FIX V2
                           - Removed "Present" from the calendar/date label through JS above
                           - Calendar/date stays rounded-rectangle, NOT oval
                           - Export and Refresh buttons restored to customer-style pill shape
                           - Export keeps black border + black hover with white text
                           - Refresh keeps admin blue + black hover with white text
                           - Calendar save button uses green gradient + black hover
                           ========================================================= */

                        .admin-dashboard-final{
                            --admin-blue-start:#1274ff!important;
                            --admin-blue-mid:#0b63f6!important;
                            --admin-blue-end:#084ac2!important;
                            --admin-green-start:#22c55e!important;
                            --admin-green-end:#16a34a!important;
                            --admin-dark:#111827!important;
                        }

                        /* Top action layout */
                        .admin-dashboard-final .dash-head-actions{
                            grid-template-columns:128px 128px!important;
                            grid-template-areas:"date date" "export refresh"!important;
                            gap:9px!important;
                            justify-content:end!important;
                            align-items:stretch!important;
                            min-width:270px!important;
                        }

                        /* Calendar/date control: not oval, same clean rounded rectangle. */
                        .admin-dashboard-final .dash-date-control{
                            grid-area:date!important;
                            width:100%!important;
                            min-width:265px!important;
                            height:42px!important;
                            min-height:42px!important;
                            padding:0 15px!important;
                            border-radius:8px!important;
                            border:1px solid #111827!important;
                            background:#ffffff!important;
                            background-image:none!important;
                            color:#111827!important;
                            font-size:12px!important;
                            font-weight:700!important;
                            line-height:1!important;
                            box-shadow:none!important;
                            display:inline-flex!important;
                            align-items:center!important;
                            justify-content:space-between!important;
                            gap:9px!important;
                            white-space:nowrap!important;
                        }
                        .admin-dashboard-final .dash-date-control:hover,
                        .admin-dashboard-final .dash-date-control:focus{
                            background:#111827!important;
                            border-color:#111827!important;
                            color:#ffffff!important;
                        }
                        .admin-dashboard-final .dash-date-control:hover svg,
                        .admin-dashboard-final .dash-date-control:focus svg{
                            color:#ffffff!important;
                            stroke:#ffffff!important;
                        }

                        /* Export + Refresh: ibinalik sa customer-style pill shape, same size. */
                        .admin-dashboard-final .dash-export-btn,
                        .admin-dashboard-final .dash-refresh-btn{
                            height:34px!important;
                            min-height:34px!important;
                            min-width:118px!important;
                            width:118px!important;
                            padding:0 16px!important;
                            border-radius:999px!important;
                            font-size:11.8px!important;
                            font-weight:500!important;
                            line-height:1!important;
                            letter-spacing:0!important;
                            display:inline-flex!important;
                            align-items:center!important;
                            justify-content:center!important;
                            gap:6px!important;
                            box-shadow:none!important;
                            transform:none!important;
                            white-space:nowrap!important;
                        }

                        .admin-dashboard-final .dash-export-btn{
                            grid-area:export!important;
                            background:#ffffff!important;
                            background-image:none!important;
                            color:#111827!important;
                            border:1px solid #111827!important;
                        }
                        .admin-dashboard-final .dash-refresh-btn{
                            grid-area:refresh!important;
                            background:linear-gradient(135deg,var(--admin-blue-start) 0%,var(--admin-blue-mid) 54%,var(--admin-blue-end) 100%)!important;
                            background-image:linear-gradient(135deg,var(--admin-blue-start) 0%,var(--admin-blue-mid) 54%,var(--admin-blue-end) 100%)!important;
                            color:#ffffff!important;
                            border:1px solid transparent!important;
                        }

                        .admin-dashboard-final .dash-export-btn:hover,
                        .admin-dashboard-final .dash-export-btn:focus,
                        .admin-dashboard-final .dash-refresh-btn:hover,
                        .admin-dashboard-final .dash-refresh-btn:focus{
                            background:#111827!important;
                            background-image:none!important;
                            border-color:#111827!important;
                            color:#ffffff!important;
                            box-shadow:none!important;
                            filter:none!important;
                            transform:none!important;
                        }
                        .admin-dashboard-final .dash-export-btn:hover svg,
                        .admin-dashboard-final .dash-export-btn:focus svg,
                        .admin-dashboard-final .dash-refresh-btn:hover svg,
                        .admin-dashboard-final .dash-refresh-btn:focus svg{
                            color:#ffffff!important;
                            stroke:#ffffff!important;
                        }

                        /* Calendar popup buttons retain consistent styling. */
                        .admin-dashboard-final .admin-calendar-save-btn,
                        .admin-dashboard-final button[class*="save" i],
                        .admin-section-content button[class*="save" i],
                        .admin-section-content input[type="submit"][value*="save" i]{
                            height:34px!important;
                            min-height:34px!important;
                            min-width:88px!important;
                            padding:0 16px!important;
                            border-radius:999px!important;
                            border:0!important;
                            background:linear-gradient(135deg,var(--admin-green-start) 0%,var(--admin-green-end) 100%)!important;
                            background-image:linear-gradient(135deg,var(--admin-green-start) 0%,var(--admin-green-end) 100%)!important;
                            color:#ffffff!important;
                            font-size:11.8px!important;
                            font-weight:500!important;
                            box-shadow:none!important;
                        }
                        .admin-dashboard-final .admin-calendar-save-btn:hover,
                        .admin-dashboard-final .admin-calendar-save-btn:focus,
                        .admin-dashboard-final button[class*="save" i]:hover,
                        .admin-dashboard-final button[class*="save" i]:focus,
                        .admin-section-content button[class*="save" i]:hover,
                        .admin-section-content button[class*="save" i]:focus,
                        .admin-section-content input[type="submit"][value*="save" i]:hover,
                        .admin-section-content input[type="submit"][value*="save" i]:focus{
                            background:#111827!important;
                            background-image:none!important;
                            color:#ffffff!important;
                        }

                        .admin-dashboard-final .admin-calendar-clear-btn,
                        .admin-dashboard-final .admin-calendar-action-btn,
                        .admin-dashboard-final .admin-calendar-mini-btn{
                            border-radius:999px!important;
                        }
                    </style>

                    <section class="dash-page-head">
                        <div class="dash-title-wrap">
                            <h1>Dashboard</h1>
                            <p>Monitor real-time print operations, performance, and key business metrics.</p>
                        </div>
                        <div class="dash-head-actions">
                            <button type="button" class="dash-date-control" @click="openCalendar()" onclick="window.openAdminCalendarPopup && window.openAdminCalendarPopup(event)">
                                <i data-lucide="calendar-days"></i><span x-text="dateRangeLabel()"></span><i data-lucide="chevron-down"></i>
                            </button>
                            <button type="button" class="dash-btn dash-outline dash-export-btn" @click="exportDashboard()"><i data-lucide="download"></i><span>Export</span></button>
                            <button type="button" class="dash-btn dash-primary dash-refresh-btn" @click="refreshDashboard()"><i data-lucide="refresh-cw"></i><span>Refresh</span></button>
                        </div>
                    </section>

                    <div id="adminCalendarOverlay" class="admin-calendar-overlay" x-show="calendarOpen === true" x-transition.opacity x-cloak style="display:none" @keydown.escape.window="closeCalendar()" @click.self="closeCalendar()" onclick="if(event.target===this){ window.closeAdminCalendarPopup && window.closeAdminCalendarPopup(event); }">
                        <div class="admin-calendar-modal" x-transition.scale>
                            <div class="admin-calendar-main">
                                <div class="admin-calendar-headline">
                                    <div class="admin-calendar-intro">
                                        <h3>Admin Calendar</h3>
                                        <p>Select dates and manage your admin dashboard reminders.</p>
                                    </div>
                                    <div class="admin-calendar-nav admin-calendar-nav-main">
                                        <button type="button" class="admin-calendar-icon-btn" @click="previousMonth()" title="Previous month"><i data-lucide="chevron-left"></i></button>
                                        <button type="button" class="admin-calendar-action-btn admin-calendar-today-btn" @click="goToday()">Today</button>
                                        <button type="button" class="admin-calendar-icon-btn" @click="nextMonth()" title="Next month"><i data-lucide="chevron-right"></i></button>
                                    </div>
                                    <button type="button" class="admin-calendar-icon-btn admin-calendar-close-btn" @click.prevent.stop="closeCalendar()" onclick="window.closeAdminCalendarPopup && window.closeAdminCalendarPopup(event)" title="Close"><i data-lucide="x"></i></button>
                                </div>
                                <div class="admin-calendar-monthbar">
                                    <h3 class="admin-calendar-title" x-text="calendarMonthLabel()"></h3>
                                    <button type="button" class="admin-calendar-action-btn admin-calendar-use-top" @click="useSelectedDate()"><i data-lucide="check"></i><span>Use Date</span></button>
                                </div>
                                <div class="admin-calendar-weekdays">
                                    <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                                </div>
                                <div class="admin-calendar-grid">
                                    <template x-for="day in calendarDays()" :key="day.key">
                                        <button type="button" class="admin-calendar-day" :class="{'is-muted': day.muted, 'is-today': day.today, 'is-selected': day.iso === selectedDate}" @click="selectCalendarDate(day)">
                                            <span class="admin-calendar-day-number" x-text="day.number"></span>
                                            <span class="admin-calendar-day-events" x-show="eventCount(day.iso) > 0">
                                                <template x-for="dot in Math.min(eventCount(day.iso), 3)">
                                                    <span class="admin-calendar-event-dot"></span>
                                                </template>
                                                <span class="admin-calendar-more" x-show="eventCount(day.iso) > 3" x-text="'+' + (eventCount(day.iso) - 3)"></span>
                                            </span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <aside class="admin-calendar-side">
                                <h3 class="admin-calendar-selected-date" x-text="formattedSelectedDate()"></h3>
                                <div class="admin-calendar-event-list" x-show="eventsForSelectedDate().length">
                                    <template x-for="event in eventsForSelectedDate()" :key="event.id">
                                        <div class="admin-calendar-event-item">
                                            <div class="admin-calendar-event-title" x-text="event.title"></div>
                                            <div class="admin-calendar-event-meta" x-text="event.time || 'All day'"></div>
                                            <div class="admin-calendar-event-note" x-text="event.note || 'No note added.'"></div>
                                            <div class="admin-calendar-event-actions">
                                                <button type="button" class="admin-calendar-mini-btn" @click="editCalendarEvent(event)">Edit</button>
                                                <button type="button" class="admin-calendar-mini-btn danger" @click="deleteCalendarEvent(event.id)">Delete</button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <div class="admin-calendar-empty" x-show="!eventsForSelectedDate().length">No reminders yet for this date. Add one below.</div>
                                <form class="admin-calendar-form" @submit.prevent="saveCalendarEvent()">
                                    <div class="admin-calendar-field">
                                        <label>Event / Reminder</label>
                                        <input type="text" x-model="calendarForm.title" placeholder="Example: Review pending orders">
                                    </div>
                                    <div class="admin-calendar-field">
                                        <label>Time</label>
                                        <input type="time" x-model="calendarForm.time">
                                    </div>
                                    <div class="admin-calendar-field">
                                        <label>Note</label>
                                        <textarea x-model="calendarForm.note" placeholder="Optional note"></textarea>
                                    </div>
                                    <div class="admin-calendar-form-actions">
                                        <button type="button" class="admin-calendar-clear-btn" @click="resetCalendarForm()">Clear</button>
                                        <button type="submit" class="admin-calendar-save-btn" x-text="calendarForm.id ? 'Update Event' : 'Save Event'"></button>
                                    </div>
                                </form>
                            </aside>
                        </div>
                    </div>


                    <section class="dash-metrics">
                        <button type="button" class="dash-metric blue" @click="openInfo('Revenue Details','Total recorded revenue: PHP {{ number_format($dashboardStats['revenue'], 2) }}. This is calculated from order totals.')">
                            <span class="dash-icon dash-blue-soft"><i data-lucide="circle-dollar-sign"></i></span><span><small>Revenue</small><strong>PHP {{ number_format($dashboardStats['revenue'], 2) }}</strong><span>&uarr; 12.6% vs last 7 days</span></span>
                        </button>
                        <button type="button" class="dash-metric orange" @click="window.location.href='{{ route('admin.orders') }}'">
                            <span class="dash-icon dash-orange-soft"><i data-lucide="shopping-bag"></i></span><span><small>Total Orders</small><strong>{{ number_format($dashboardStats['orders']) }}</strong><span>&uarr; 18.3% vs last 7 days</span></span>
                        </button>
                        <button type="button" class="dash-metric green" @click="window.location.href='{{ $dashboardActiveUsersRoute }}'">
                            <span class="dash-icon dash-green-soft"><i data-lucide="users-round"></i></span><span><small>{{ $dashboardActiveUsersLabel }}</small><strong>{{ number_format($dashboardStats['customers']) }}</strong><span>&uarr; 9.4% vs last 7 days</span></span>
                        </button>
                        <button type="button" class="dash-metric red" @click="openInfo('Pending Approvals','Pending review count: {{ number_format($dashboardStats['pending']) }}. Review order and customer requests that need action.')">
                            <span class="dash-icon dash-red-soft"><i data-lucide="clipboard-check"></i></span><span><small>Pending Approvals</small><strong>{{ number_format($dashboardStats['pending']) }}</strong><span class="red-trend">&darr; 5.1% vs last 7 days</span></span>
                        </button>
                        <button type="button" class="dash-metric cyan" @click="window.location.href='{{ route('admin.products') }}'">
                            <span class="dash-icon dash-cyan-soft"><i data-lucide="package-check"></i></span><span><small>{{ $isDeveloperPortal ? 'Services' : 'Services / Products' }}</small><strong>{{ number_format($dashboardStats['services']) }}</strong><span>&uarr; 7.2% vs last 7 days</span></span>
                        </button>
                    </section>

                    <section class="dash-grid-three">
                        <article class="dash-main-box dash-production-panel">
                            <h2 class="dash-card-title">Print Production Live Status</h2>
                            @php
                                $liveRows = [
                                    ['DTG Printing', 148, 250, '#0b63f6'],
                                    ['Sublimation', 96, 180, '#10b981'],
                                    ['UV Printing', 74, 150, '#f59e0b'],
                                    ['Packaging', 38, 120, '#ef4444'],
                                ];
                            @endphp
                            @foreach($liveRows as [$label, $done, $total, $color])
                                @php $percent = $total > 0 ? min(100, round(($done / $total) * 100)) : 0; @endphp
                                <div class="dash-live-row"><span>{{ $label }}</span><span>{{ $done }} / {{ $total }}</span><div class="dash-bar"><span style="width:{{ $percent }}%;background:{{ $color }}"></span></div><strong>{{ $percent }}%</strong><span class="dash-ontime"><i class="dash-dot green"></i>On Time</span></div>
                            @endforeach
                            <div class="dash-mini-row">
                                <div class="dash-mini"><i data-lucide="clipboard-list" style="width:13px"></i>All Orders<strong>{{ number_format($dashboardStats['orders']) }}</strong></div>
                                <div class="dash-mini"><i data-lucide="circle-check" style="width:13px"></i>Completed<strong>{{ number_format($dashboardStats['completed']) }}</strong></div>
                                <div class="dash-mini"><i data-lucide="package-check" style="width:13px"></i>Ready<strong>{{ number_format($dashboardStats['ready']) }}</strong></div>
                                <div class="dash-mini"><i data-lucide="circle-x" style="width:13px"></i>Cancelled<strong style="color:#ef4444">{{ number_format($dashboardStats['cancelled']) }}</strong></div>
                            </div>
                        </article>

                        <article class="dash-main-box dash-pipeline-panel">
                            <h2 class="dash-card-title">Order Pipeline Snapshot</h2>
                            <div class="dash-donut-wrap">
                                <svg class="dash-donut-svg" viewBox="0 0 220 220">
                                    <circle cx="110" cy="110" r="74" fill="none" stroke="#e8edf5" stroke-width="30"></circle>
                                    <circle cx="110" cy="110" r="74" fill="none" stroke="#0b63f6" stroke-width="30" stroke-dasharray="22 100" stroke-dashoffset="0" transform="rotate(-90 110 110)"></circle>
                                    <circle cx="110" cy="110" r="74" fill="none" stroke="#f59e0b" stroke-width="30" stroke-dasharray="28 100" stroke-dashoffset="-22" transform="rotate(-90 110 110)"></circle>
                                    <circle cx="110" cy="110" r="74" fill="none" stroke="#10b981" stroke-width="30" stroke-dasharray="20 100" stroke-dashoffset="-50" transform="rotate(-90 110 110)"></circle>
                                    <circle cx="110" cy="110" r="74" fill="none" stroke="#8b5cf6" stroke-width="30" stroke-dasharray="30 100" stroke-dashoffset="-70" transform="rotate(-90 110 110)"></circle>
                                    <text x="110" y="105" text-anchor="middle" class="dash-donut-number">{{ number_format($dashboardStats['orders']) }}</text>
                                    <text x="110" y="128" text-anchor="middle" class="dash-donut-label">Total Orders</text>
                                </svg>
                                <div class="dash-legend">
                                    <div class="dash-legend-line"><span><i class="dash-dot blue"></i>New</span><strong>{{ number_format($dashboardStats['pending']) }}</strong></div>
                                    <div class="dash-legend-line"><span><i class="dash-dot orange"></i>Processing</span><strong>{{ number_format(max(0, $dashboardStats['orders'] - $dashboardStats['pending'] - $dashboardStats['ready'] - $dashboardStats['completed'])) }}</strong></div>
                                    <div class="dash-legend-line"><span><i class="dash-dot green"></i>Ready</span><strong>{{ number_format($dashboardStats['ready']) }}</strong></div>
                                    <div class="dash-legend-line"><span><i class="dash-dot purple"></i>Completed</span><strong>{{ number_format($dashboardStats['completed']) }}</strong></div>
                                </div>
                            </div>
                            <a class="dash-link" href="{{ route('admin.orders') }}">View full pipeline report <i data-lucide="arrow-right" style="width:14px"></i></a>
                        </article>

                        <article class="dash-plain-panel dash-quick-panel">
                            <h2 class="dash-card-title">Quick Admin Actions</h2>
                            <a class="dash-action-line" href="{{ route('admin.orders') }}"><span class="dash-action-icon"><i data-lucide="clipboard-list"></i></span><span><strong>View Production Queue</strong><small>See current print jobs</small></span><i data-lucide="chevron-right"></i></a>
                            <a class="dash-action-line" href="{{ route('admin.customers') }}"><span class="dash-action-icon"><i data-lucide="users-round"></i></span><span><strong>Review Customer Records</strong><small>Manage customer profiles</small></span><i data-lucide="chevron-right"></i></a>
                            <a class="dash-action-line" href="{{ route('admin.products') }}"><span class="dash-action-icon"><i data-lucide="package-pen"></i></span><span><strong>{{ $isDeveloperPortal ? 'Service Catalog' : 'Product Edits' }}</strong><small>{{ $isDeveloperPortal ? 'Review service availability' : 'Add or update products' }}</small></span><i data-lucide="chevron-right"></i></a>
                            <a class="dash-action-line" href="{{ route('admin.orders') }}"><span class="dash-action-icon"><i data-lucide="rotate-ccw"></i></span><span><strong>Return Requests</strong><small>Manage return and refund</small></span><i data-lucide="chevron-right"></i></a>
                            <a class="dash-action-line" href="{{ route('admin.products') }}"><span class="dash-action-icon"><i data-lucide="boxes"></i></span><span><strong>{{ $isDeveloperPortal ? 'Service Items' : 'Catalog Items' }}</strong><small>Manage catalog and services</small></span><i data-lucide="chevron-right"></i></a>
                        </article>
                    </section>

                    <section class="dash-alert-stock-grid">
                        <article class="dash-main-box dash-alert-stock-box dash-alerts-stock-panel">
                            <div class="dash-alert-stock-inner">
                                <div class="dash-alert-area dash-system-alerts-panel">
                                    <h2 class="dash-card-title">System Alerts</h2>
                                    <button type="button" class="dash-alert-line" @click="openReal('{{ route('admin.orders') }}','Opening pending order checks...')"><span class="dash-alert-copy"><span class="dash-alert-icon red"><i data-lucide="triangle-alert" style="width:16px"></i></span><span><strong>Pending order checks</strong><br><small>Orders need verification</small></span></span><b class="dash-count-pill red">{{ number_format($dashboardStats['pending']) }}</b></button>
                                    <button type="button" class="dash-alert-line" @click="openReal('{{ route('admin.products') }}','Opening synced service catalog records...')"><span class="dash-alert-copy"><span class="dash-alert-icon orange"><i data-lucide="trophy" style="width:16px"></i></span><span><strong>Synced service records</strong><br><small>Customer catalog items live in this portal</small></span></span><b class="dash-count-pill">{{ number_format($dashboardServiceAlertCount) }}</b></button>
                                    <button type="button" class="dash-alert-line" @click="openReal('{{ route('admin.orders') }}','Opening ready for release orders...')"><span class="dash-alert-copy"><span class="dash-alert-icon blue"><i data-lucide="package-check" style="width:16px"></i></span><span><strong>Ready for release</strong><br><small>Orders ready to dispatch</small></span></span><b class="dash-count-pill blue">{{ number_format($dashboardStats['ready']) }}</b></button>
                                    <a class="dash-link" href="{{ route('admin.orders') }}">View all alerts <i data-lucide="arrow-right" style="width:14px"></i></a>
                                </div>
                                <div class="dash-stock-area dash-low-stock-panel">
                                    <h2 class="dash-card-title">{{ $isDeveloperPortal ? 'Service Alerts' : 'Low Stock Alerts' }}</h2>
                                    <table class="dash-table dash-stock-table">
                                        <thead><tr><th>Service</th><th>Options</th><th>Status</th></tr></thead>
                                        <tbody>
                                            @forelse($dashboardServiceAlerts as $serviceAlert)
                                                <tr @click="openReal('{{ route('admin.products') }}', @js('Opening ' . $serviceAlert['name'] . ' service record...'))"><td><span class="dash-product-cell"><span class="dash-product-img"><i data-lucide="{{ $serviceAlert['icon'] }}" style="width:14px"></i></span>{{ $serviceAlert['name'] }}</span></td><td>{{ number_format($serviceAlert['options']) }}</td><td><span class="dash-pill {{ $serviceAlert['status_class'] }}"><i class="dash-dot {{ $serviceAlert['status_class'] === 'completed' ? 'green' : 'orange' }}"></i>{{ $serviceAlert['status'] }}</span></td></tr>
                                            @empty
                                                <tr><td colspan="3"><span class="dash-product-cell"><span class="dash-product-img"><i data-lucide="inbox" style="width:14px"></i></span>No active services yet</span></td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <a class="dash-link" href="{{ route('admin.products') }}">View all service items <i data-lucide="arrow-right" style="width:14px"></i></a>
                                </div>
                            </div>
                        </article>

                        <article class="dash-plain-panel dash-pending-panel">
                            <h2 class="dash-card-title">Pending Approvals</h2>
                            <button type="button" class="dash-task-line" @click="openReal('{{ route('admin.customers') }}','Opening user registrations...')"><span>User registrations</span><strong>{{ number_format($dashboardStats['pending']) }}</strong></button>
                            <button type="button" class="dash-task-line" @click="openReal('{{ route('admin.orders') }}','Opening return requests...')"><span>Return requests</span><strong>{{ number_format(max(0, $dashboardStats['cancelled'])) }}</strong></button>
                            <button type="button" class="dash-task-line" @click="openReal('{{ route('admin.products') }}','Opening {{ $isDeveloperPortal ? 'service' : 'product' }} edits...')"><span>{{ $isDeveloperPortal ? 'Service edits' : 'Product edits' }}</span><strong>{{ number_format(max(0, $dashboardStats['services'])) }}</strong></button>
                            <button type="button" class="dash-task-line" @click="openReal('{{ route('admin.products') }}','Opening catalog submissions...')"><span>Catalog item submissions</span><strong>1</strong></button>
                            <a class="dash-link" href="{{ route('admin.orders') }}">Review all approvals <i data-lucide="arrow-right" style="width:14px"></i></a>
                        </article>
                    </section>

                    <section class="dash-grid-three equal">
                        <article class="dash-main-box dash-activity-panel">
                            <h2 class="dash-card-title">{{ $isDeveloperPortal ? 'Recent Audit Activity' : 'Recent Admin Activity' }}</h2>
                            @foreach($headerNotifications->take(4) as $note)
                                <div class="dash-activity-line"><span>{{ $note['title'] }}</span><strong>{{ $note['time'] }}</strong></div>
                            @endforeach
                            <a class="dash-link" href="{{ route('admin.reports') }}">View all activity <i data-lucide="arrow-right" style="width:14px"></i></a>
                        </article>

                        <article class="dash-main-box dash-transactions-panel">
                            <h2 class="dash-card-title">Latest Transactions</h2>
                            <table class="dash-table">
                                <thead><tr><th>Order ID</th><th>Customer</th><th>Amount</th><th>Status</th><th>Time</th></tr></thead>
                                <tbody>
                                    @forelse($dashboardRecentOrders as $order)
                                        <tr>
                                            <td><button type="button" class="dash-order-link" @click="openOrderById('#{{ $order->id }}')">#{{ $order->id }}</button></td>
                                            <td>{{ $order->user?->name ?? 'Customer' }}</td>
                                            <td>PHP {{ number_format((float) ($order->total_price ?? 0), 2) }}</td>
                                            <td><span class="dash-pill {{ ($order->status ?? '') === 'Pending' ? 'processing' : (($order->status ?? '') === 'Completed' ? 'completed' : 'new') }}">{{ $order->status ?? 'New' }}</span></td>
                                            <td>{{ optional($order->created_at)->diffForHumans() ?? 'Now' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5">No transactions yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <a class="dash-link" href="{{ route('admin.orders') }}">View all transactions <i data-lucide="arrow-right" style="width:14px"></i></a>
                        </article>

                        <article class="dash-plain-panel dash-task-panel">
                            <h2 class="dash-card-title">Staff Task Reminder</h2>
                            <button type="button" class="dash-task-line" @click="openReal('{{ route('admin.orders') }}','Opening pending requests...')"><span><i data-lucide="check-square" style="width:14px"></i> Review pending requests</span><strong>{{ number_format($dashboardStats['pending']) }}</strong></button>
                            <button type="button" class="dash-task-line" @click="openReal('{{ route('admin.orders') }}','Opening production queue...')"><span><i data-lucide="check-square" style="width:14px"></i> Update production queue</span><strong>{{ number_format($dashboardStats['orders']) }}</strong></button>
                            <button type="button" class="dash-task-line" @click="openReal('{{ route('admin.products') }}','Opening product records...')"><span><i data-lucide="check-square" style="width:14px"></i> Check product records</span><strong>{{ number_format($dashboardStats['services']) }}</strong></button>
                            <button type="button" class="dash-task-line" @click="openReal('{{ route('admin.customers') }}','Opening customer inquiries...')"><span><i data-lucide="check-square" style="width:14px"></i> Reply to customer inquiries</span><strong>1</strong></button>
                            <a class="dash-link" href="{{ route('admin.customers') }}">View all tasks <i data-lucide="arrow-right" style="width:14px"></i></a>
                        </article>
                    </section>

                    <div x-show="orderModal" x-transition.opacity class="dash-modal-overlay" style="display:none" @click.self="orderModal=false">
                        <div class="dash-order-modal" x-transition.scale.origin.center>
                            <header class="dash-modal-head">
                                <div class="dash-modal-heading"><h2>Order Details</h2><span></span><b x-text="selectedOrder?.id || '-'"></b></div>
                                <button type="button" class="dash-icon-btn" @click="orderModal=false"><i data-lucide="x"></i></button>
                            </header>
                            <div class="dash-modal-grid">
                                <article class="dash-modal-card"><h3>Customer</h3><div class="dash-customer-flex"><div class="dash-avatar"><i data-lucide="user"></i></div><div><strong x-text="selectedOrder?.customer || 'Customer'"></strong><small x-text="selectedOrder?.email || 'customer@example.com'"></small><small x-text="selectedOrder?.phone || '+63 900 000 0000'"></small></div></div><small style="display:inline-block;margin-top:10px;color:#64748b">Customer ID: Auto-generated</small></article>
                                <article class="dash-modal-card"><h3>Shipping Address</h3><p class="dash-address"><i data-lucide="map-pin"></i><span x-text="selectedOrder?.address || 'Customer address not provided'"></span></p></article>
                                <article class="dash-modal-card"><h3>Payment Method</h3><p style="margin:0 0 8px;font-weight:800"><span style="display:inline-block;width:16px;height:16px;border-radius:50%;background:#ef4444"></span><span style="display:inline-block;width:16px;height:16px;border-radius:50%;background:#f59e0b;margin-left:-7px"></span> VISA &bull;&bull;&bull;&bull; 4242</p><span class="dash-pill completed">Paid</span></article>
                            </div>
                            <section class="dash-status-strip">
                                <div><span>Order Status</span><b x-text="selectedOrder?.status || 'Recorded'"></b></div>
                                <div><span>Order Date</span><b><i data-lucide="calendar-days" style="width:14px"></i><em x-text="selectedOrder?.date || 'Today'" style="font-style:normal"></em></b></div>
                                <div><span>Fulfillment Type</span><b><i data-lucide="package" style="width:14px"></i><em x-text="selectedOrder?.fulfillmentType || 'Pickup'" style="font-style:normal"></em></b></div>
                                <div><span>Estimated Delivery</span><b><i data-lucide="truck" style="width:14px"></i> Ready Soon</b></div>
                                <div><span>Tracking Number</span><b x-text="selectedOrder?.tracking || 'N/A'"></b></div>
                            </section>
                            <article class="dash-items-card"><h3>Ordered Items</h3><table><thead><tr><th>Item</th><th>Description</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead><tbody><tr><td><span class="dash-product-cell"><span class="dash-product-img"><i data-lucide="package" style="width:14px"></i></span><span x-text="selectedOrder?.service || 'Print Service'"></span></span></td><td>Admin dashboard transaction item</td><td>1</td><td x-text="selectedOrder?.total || 'PHP 0.00'"></td><td x-text="selectedOrder?.total || 'PHP 0.00'"></td></tr></tbody><tfoot><tr><td colspan="4" style="text-align:right">Subtotal</td><td x-text="selectedOrder?.total || 'PHP 0.00'"></td></tr><tr><td colspan="4" style="text-align:right">Shipping Fee</td><td>PHP 0.00</td></tr><tr><td colspan="4" style="text-align:right;color:#0b63f6;font-weight:800">Total</td><td style="color:#0b63f6;font-weight:800" x-text="selectedOrder?.total || 'PHP 0.00'"></td></tr></tfoot></table></article>
                            <div class="dash-modal-bottom">
                                <article class="dash-modal-card"><h3>Notes / Special Instructions</h3><p style="font-size:12px;line-height:1.55;margin:0" x-text="selectedOrder?.notes || 'No special instructions.'"></p></article>
                                <article class="dash-modal-card"><h3>Order Timeline</h3><div class="dash-activity-line"><span>Order Placed</span><strong>Done</strong></div><div class="dash-activity-line"><span>Payment Confirmed</span><strong>Done</strong></div><div class="dash-activity-line"><span>Preparing</span><strong>Current</strong></div></article>
                                <article class="dash-modal-card dash-modal-actions"><h3>Actions</h3><button type="button" class="dash-btn dash-primary" @click="printInvoice()"><i data-lucide="printer"></i>Print Invoice</button><button type="button" class="dash-btn dash-outline" @click="markCompleted()"><i data-lucide="check-circle"></i>Mark Completed</button></article>
                            </div>
                        </div>
                    </div>

                    <script>
                        window.adminDashboardOrders = @js($dashboardRecentOrdersPayload);
                        window.adminDashboardFinal = function adminDashboardFinal(){
                            return{
                                toast:{show:false,message:''},
                                orderModal:false,
                                selectedOrder:null,
                                orders:window.adminDashboardOrders||[],
                                calendarOpen:false,
                                selectedDate:new Date().toISOString().slice(0,10),
                                calendarMonth:new Date().getMonth(),
                                calendarYear:new Date().getFullYear(),
                                calendarEvents:[],
                                calendarForm:{id:null,title:'',time:'',note:''},
                                init(){
                                    this.calendarOpen=false;
                                    this.loadCalendarEvents();
                                    this.refreshIcons();
                                },
                                refreshIcons(){this.$nextTick(()=>{if(window.lucide) window.lucide.createIcons();});},
                                showToast(message){this.toast.message=message;this.toast.show=true;setTimeout(()=>this.toast.show=false,2300);},
                                openCalendar(){this.calendarOpen=true;window.openAdminCalendarPopup && window.openAdminCalendarPopup();this.refreshIcons();},
                                pad(value){return String(value).padStart(2,'0');},
                                isoDate(year,month,day){return `${year}-${this.pad(month+1)}-${this.pad(day)}`;},
                                dateRangeLabel(){return this.formattedSelectedDate();},
                                calendarMonthLabel(){return new Date(this.calendarYear,this.calendarMonth,1).toLocaleDateString('en-US',{month:'long',year:'numeric'});},
                                formattedSelectedDate(){
                                    const parts=this.selectedDate.split('-').map(Number);
                                    return new Date(parts[0],parts[1]-1,parts[2]).toLocaleDateString('en-US',{month:'long',day:'2-digit',year:'numeric'});
                                },
                                calendarDays(){
                                    const first=new Date(this.calendarYear,this.calendarMonth,1);
                                    const total=new Date(this.calendarYear,this.calendarMonth+1,0).getDate();
                                    const lead=first.getDay();
                                    const days=[];
                                    for(let i=0;i<lead;i++) days.push({key:`blank-${i}`,number:'',iso:'',muted:true,today:false});
                                    const today=new Date().toISOString().slice(0,10);
                                    for(let d=1;d<=total;d++){
                                        const iso=this.isoDate(this.calendarYear,this.calendarMonth,d);
                                        days.push({key:iso,number:d,iso,muted:false,today:iso===today});
                                    }
                                    while(days.length%7!==0) days.push({key:`blank-end-${days.length}`,number:'',iso:'',muted:true,today:false});
                                    return days;
                                },
                                selectCalendarDate(day){
                                    if(!day || day.muted || !day.iso) return;
                                    this.selectedDate=day.iso;
                                    this.resetCalendarForm();
                                },
                                previousMonth(){
                                    if(this.calendarMonth===0){this.calendarMonth=11;this.calendarYear--;}
                                    else this.calendarMonth--;
                                    this.refreshIcons();
                                },
                                nextMonth(){
                                    if(this.calendarMonth===11){this.calendarMonth=0;this.calendarYear++;}
                                    else this.calendarMonth++;
                                    this.refreshIcons();
                                },
                                goToday(){
                                    const now=new Date();
                                    this.calendarYear=now.getFullYear();
                                    this.calendarMonth=now.getMonth();
                                    this.selectedDate=now.toISOString().slice(0,10);
                                    this.resetCalendarForm();
                                    this.refreshIcons();
                                },
                                loadCalendarEvents(){
                                    try{this.calendarEvents=JSON.parse(window.localStorage.getItem('printifyAdminCalendarEvents')||'[]');}
                                    catch(error){this.calendarEvents=[];}
                                },
                                persistCalendarEvents(){window.localStorage.setItem('printifyAdminCalendarEvents',JSON.stringify(this.calendarEvents));},
                                eventsForSelectedDate(){return this.calendarEvents.filter(event=>event.date===this.selectedDate).sort((a,b)=>(a.time||'').localeCompare(b.time||''));},
                                eventCount(iso){return iso ? this.calendarEvents.filter(event=>event.date===iso).length : 0;},
                                resetCalendarForm(){this.calendarForm={id:null,title:'',time:'',note:''};},
                                saveCalendarEvent(){
                                    if(!this.calendarForm.title.trim()){this.showToast('Please add an event title.');return;}
                                    if(this.calendarForm.id){
                                        const found=this.calendarEvents.find(event=>event.id===this.calendarForm.id);
                                        if(found){found.title=this.calendarForm.title.trim();found.time=this.calendarForm.time;found.note=this.calendarForm.note;found.date=this.selectedDate;}
                                        this.showToast('Calendar event updated.');
                                    }else{
                                        this.calendarEvents.push({id:Date.now(),date:this.selectedDate,title:this.calendarForm.title.trim(),time:this.calendarForm.time,note:this.calendarForm.note});
                                        this.showToast('Calendar event saved.');
                                    }
                                    this.persistCalendarEvents();
                                    this.resetCalendarForm();
                                    this.refreshIcons();
                                },
                                editCalendarEvent(event){this.calendarForm={id:event.id,title:event.title,time:event.time||'',note:event.note||''};},
                                deleteCalendarEvent(id){this.calendarEvents=this.calendarEvents.filter(event=>event.id!==id);this.persistCalendarEvents();this.resetCalendarForm();this.showToast('Calendar event deleted.');},
                                closeCalendar(){this.calendarOpen=false;window.closeAdminCalendarPopup && window.closeAdminCalendarPopup();this.resetCalendarForm();this.refreshIcons();},
                                useSelectedDate(){this.closeCalendar();this.showToast('Date applied: '+this.formattedSelectedDate());},
                                openInfo(title,message){this.showToast(title+' opened');window.dispatchEvent(new CustomEvent('printify-admin-feedback',{detail:{message:title+': '+message}}));},
                                openReal(url,message){this.showToast(message||'Opening...');window.dispatchEvent(new CustomEvent('printify-admin-feedback',{detail:{message:message||'Opening section...'}}));setTimeout(()=>{window.location.href=url},350);},
                                refreshDashboard(){this.showToast('Dashboard refreshed');this.refreshIcons();setTimeout(()=>window.location.reload(),450);},
                                exportDashboard(){
                                    const rows=[['Metric','Value'],['Revenue','PHP {{ number_format($dashboardStats['revenue'], 2) }}'],['Orders','{{ number_format($dashboardStats['orders']) }}'],['{{ $dashboardActiveUsersLabel }}','{{ number_format($dashboardStats['customers']) }}'],['Pending Approvals','{{ number_format($dashboardStats['pending']) }}'],['Services','{{ number_format($dashboardStats['services']) }}']];
                                    const csv=rows.map(r=>r.map(v=>'"'+String(v).replaceAll('"','""')+'"').join(',')).join('\n');
                                    const a=document.createElement('a');
                                    a.href=URL.createObjectURL(new Blob([csv],{type:'text/csv'}));
                                    a.download='dashboard-export.csv';
                                    a.click();
                                    URL.revokeObjectURL(a.href);
                                    this.showToast('Dashboard exported as CSV');
                                },
                                openOrderById(id){
                                    this.selectedOrder=this.orders.find(o=>o.id===id)||{id:id,customer:'Customer',email:'customer@example.com',phone:'+63 900 000 0000',service:'Print Service',date:'Today',status:'Recorded',total:'PHP 0.00',address:'Customer address not provided',fulfillmentType:'Pickup',tracking:'N/A',notes:'No special instructions.'};
                                    this.orderModal=true;
                                    this.refreshIcons();
                                },
                                printInvoice(){
                                    if(!this.selectedOrder){this.showToast('Select an order first');return;}
                                    const o=this.selectedOrder;
                                    const w=window.open('','_blank','width=720,height=760');
                                    w.document.write(`<title>Invoice ${o.id}</title><style>body{font-family:Inter,Arial,sans-serif;padding:32px;color:#050816}h1{font-family:Georgia,serif}.row{display:flex;justify-content:space-between;border-bottom:1px solid #ddd;padding:10px 0}.total{font-weight:800;color:#0b63f6;font-size:20px}</style><h1>Invoice</h1><p><b>${o.id}</b></p><div class=row><span>Customer</span><b>${o.customer}</b></div><div class=row><span>Service</span><b>${o.service}</b></div><div class=row><span>Date</span><b>${o.date}</b></div><div class=row><span>Status</span><b>${o.status}</b></div><div class=row><span>Total</span><b class=total>${o.total}</b></div><script>window.print()<\/script>`);
                                    w.document.close();
                                    this.showToast('Print window opened for '+o.id);
                                },
                                markCompleted(){
                                    if(!this.selectedOrder){this.showToast('Select an order first');return;}
                                    this.selectedOrder.status='Completed';
                                    const found=this.orders.find(o=>o.id===this.selectedOrder.id);
                                    if(found)found.status='Completed';
                                    this.showToast(this.selectedOrder.id+' marked as completed');
                                    this.refreshIcons();
                                }
                            }
                        }
                    </script>
                </main>

            @elseif($section == 'customers')
                <main class="admin-section-content">@include('Admin.sections.customers')</main>
            @elseif($section == 'orders')
                <main class="admin-section-content">@include('Admin.sections.orders')</main>
            @elseif($section == 'products')
                <main class="admin-section-content">@include('Admin.sections.products')</main>
            @elseif($section == 'help center')
                <main class="admin-section-content">@include('Admin.sections.helpcenter')</main>
            @elseif($section == 'analytics')
                <main class="admin-section-content">@include('Admin.sections.analytics')</main>
            @elseif($section == 'reports')
                <main class="admin-section-content">@include('Admin.sections.reports')</main>
            @elseif($section == 'settings')
                <main class="admin-section-content">@include('Admin.sections.settings')</main>
            @endif
        </div>

        <div class="chat-drawer" x-show="chatOpen" x-transition x-cloak>
            <div class="chat-head">
                <div>
                    <div class="chat-title">Customer Support</div>
                    <div class="chat-status" x-text="activeThread ? 'Chatting with ' + activeThread.customer : 'Customer inbox'"></div>
                </div>
                <button @click="chatOpen = false" style="background:none;border:none;color:white;cursor:pointer;"><i data-lucide="x"></i></button>
            </div>
            <div class="chat-thread-select">
                <select x-model="activeThreadId">
                    <template x-for="thread in chatThreads" :key="thread.id">
                        <option :value="thread.id" x-text="thread.customer + ' - ' + thread.subject"></option>
                    </template>
                </select>
            </div>
            <div class="chat-tools">
                <input type="search" x-model="chatSearch" placeholder="Search messages...">
                <button class="chat-chip" type="button" @click="addQuickReply('Hi, this is Printify Co. admin support. I am checking your inquiry now.')">Quick Reply</button>
                <button class="chat-chip" type="button" @click="clearChat()">Clear</button>
            </div>
            <div class="chat-body">
                <template x-for="(message, index) in filteredChatMessages" :key="index">
                    <div>
                        <div class="chat-message" :class="message.from === 'me' ? 'me' : 'customer'" x-text="message.text"></div>
                        <div :style="message.from === 'me' ? 'text-align:right' : 'text-align:left'" style="font-size:9px;color:#94A3B8;margin:-6px 4px 8px;" x-text="message.time || 'Now'"></div>
                    </div>
                </template>
            </div>
            <form class="chat-input-row" @submit.prevent="sendChatMessage()">
                <input type="text" x-model="chatDraft" placeholder="Reply to customer...">
                <button type="submit"><i data-lucide="send" style="width:18px"></i></button>
            </form>
        </div>

        <!-- MODAL -->
        <div class="detail-overlay" x-show="showDetail" x-transition.opacity x-cloak>
            <div class="modal-card" @click.away="showDetail = false">
                <div :style="'height: 12px; background:' + modalColor"></div>
                <div style="padding: 45px; text-align: center;">
                    <div :style="'width:70px; height:70px; border-radius:24px; background:' + modalColor + '15; color:' + modalColor + '; display:flex; align-items:center; justify-content:center; margin: 0 auto 25px auto;'">
                        <i data-lucide="activity" style="width:32px; height:32px"></i>
                    </div>
                    <h3 x-text="modalTitle" style="font-size: 26px; font-weight: 900; margin: 0 0 12px 0; color:#1e293b;"></h3>
                    <p x-text="modalData" style="color: #64748b; font-size: 15px; line-height:1.7; margin-bottom: 35px; font-weight:500; white-space:pre-line"></p>
                    <button @click="showDetail = false" :style="'width: 100%; padding: 18px; border-radius: 18px; border: none; background:' + modalColor + '; color:white; font-weight: 800; cursor: pointer;'">
                        Understood, Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        (function(){
            function getOverlay(){ return document.getElementById('adminCalendarOverlay'); }
            window.openAdminCalendarPopup = function(event){
                if(event && event.preventDefault) event.preventDefault();
                var overlay = getOverlay();
                if(!overlay) return;
                overlay.classList.add('is-open');
                overlay.removeAttribute('x-cloak');
                document.body.classList.add('admin-calendar-lock');
                try {
                    var root = overlay.closest('[x-data]');
                    if(root && window.Alpine && Alpine.$data(root)) Alpine.$data(root).calendarOpen = true;
                } catch(e) {}
            };
            window.closeAdminCalendarPopup = function(event){
                if(event && event.preventDefault) event.preventDefault();
                if(event && event.stopPropagation) event.stopPropagation();
                var overlay = getOverlay();
                if(!overlay) return;
                overlay.classList.remove('is-open');
                overlay.style.display='none';
                document.body.classList.remove('admin-calendar-lock');
                try {
                    var root = overlay.closest('[x-data]');
                    if(root && window.Alpine && Alpine.$data(root)) Alpine.$data(root).calendarOpen = false;
                } catch(e) {}
            };
            document.addEventListener('DOMContentLoaded', function(){
                var overlay = getOverlay();
                if(overlay){ overlay.classList.remove('is-open'); overlay.style.display='none'; }
                document.body.classList.remove('admin-calendar-lock');
                document.addEventListener('keydown', function(e){
                    if(e.key === 'Escape') window.closeAdminCalendarPopup(e);
                });
            });
        })();
    </script>

    <script id="admin-calendar-popup-final-js-fix">
        (function(){
            function getOverlay(){ return document.getElementById('adminCalendarOverlay'); }
            function getRootData(overlay){
                try{
                    var root = overlay && overlay.closest('[x-data]');
                    return root && window.Alpine ? Alpine.$data(root) : null;
                }catch(e){ return null; }
            }
            window.openAdminCalendarPopup = function(event){
                if(event && event.preventDefault) event.preventDefault();
                var overlay = getOverlay();
                if(!overlay) return;
                overlay.style.removeProperty('display');
                overlay.classList.add('is-open');
                overlay.removeAttribute('x-cloak');
                document.body.classList.add('admin-calendar-lock');
                var data = getRootData(overlay);
                if(data) data.calendarOpen = true;
                setTimeout(function(){ if(window.lucide) window.lucide.createIcons(); }, 30);
            };
            window.closeAdminCalendarPopup = function(event){
                if(event && event.preventDefault) event.preventDefault();
                if(event && event.stopPropagation) event.stopPropagation();
                var overlay = getOverlay();
                if(!overlay) return;
                overlay.classList.remove('is-open');
                overlay.style.display = 'none';
                document.body.classList.remove('admin-calendar-lock');
                var data = getRootData(overlay);
                if(data) data.calendarOpen = false;
            };
            document.addEventListener('DOMContentLoaded', function(){
                var overlay = getOverlay();
                if(overlay){
                    overlay.classList.remove('is-open');
                    overlay.style.display = 'none';
                }
                document.body.classList.remove('admin-calendar-lock');
            });
            document.addEventListener('keydown', function(e){
                if(e.key === 'Escape') window.closeAdminCalendarPopup(e);
            });
        })();
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => { 
            lucide.createIcons(); 
        });
        // Observer to re-run lucide when Alpine changes the DOM
        window.addEventListener('click', () => { 
            setTimeout(() => lucide.createIcons(), 50); 
        });
    </script>

    <!-- =========================================================
         FINAL FIX V3 - layout/date/buttons polish
         - Fixes content being too close/covered by sidebar
         - Keeps date label without "Present"
         - Calendar button: clean rounded rectangle, aligned icon/text/chevron
         - Export + Refresh: matching customer-style pill buttons
         - Export has black border, hover black/white
         - Refresh stays blue, hover black/white
         - Calendar Save button stays green gradient
    ========================================================== -->
    <style id="admin-dashboard-final-v3-layout-button-polish">
        html, body{
            overflow-x:hidden!important;
        }

        /* Prevent the admin content from sliding under the fixed sidebar. */
        .admin-main-shell{
            margin-left:var(--sidebar-width)!important;
            width:calc(100% - var(--sidebar-width))!important;
            max-width:calc(100% - var(--sidebar-width))!important;
            overflow-x:hidden!important;
        }
        .admin-main-shell.expanded{
            margin-left:var(--sidebar-closed-width)!important;
            width:calc(100% - var(--sidebar-closed-width))!important;
            max-width:calc(100% - var(--sidebar-closed-width))!important;
        }
        .admin-main-shell .hero-banner,
        .admin-main-shell .content-container,
        .admin-main-shell .admin-section-content{
            width:100%!important;
            max-width:100%!important;
        }
        .admin-dashboard-final{
            width:100%!important;
            max-width:1360px!important;
            margin:0 auto!important;
            padding-left:22px!important;
            padding-right:22px!important;
        }

        /* Header action area: stable two-button row below date. */
        .admin-dashboard-final .dash-head-actions{
            display:grid!important;
            grid-template-columns:118px 118px!important;
            grid-template-areas:"date date" "export refresh"!important;
            gap:9px!important;
            justify-content:end!important;
            align-items:center!important;
            min-width:245px!important;
        }

        /* Calendar/date pill: rounded rectangle, not oval, no "Present" text from JS. */
        .admin-dashboard-final .dash-date-control{
            grid-area:date!important;
            width:100%!important;
            min-width:245px!important;
            height:42px!important;
            min-height:42px!important;
            padding:0 14px!important;
            border-radius:8px!important;
            border:1px solid #111827!important;
            background:#ffffff!important;
            background-image:none!important;
            color:#111827!important;
            box-shadow:none!important;
            display:grid!important;
            grid-template-columns:18px minmax(0,1fr) 16px!important;
            align-items:center!important;
            justify-items:center!important;
            column-gap:10px!important;
            white-space:nowrap!important;
            overflow:hidden!important;
        }
        .admin-dashboard-final .dash-date-control span{
            display:block!important;
            width:100%!important;
            overflow:hidden!important;
            text-overflow:ellipsis!important;
            text-align:center!important;
            font-size:12px!important;
            font-weight:700!important;
            line-height:1!important;
            color:inherit!important;
        }
        .admin-dashboard-final .dash-date-control svg{
            width:16px!important;
            height:16px!important;
            color:currentColor!important;
            stroke:currentColor!important;
        }
        .admin-dashboard-final .dash-date-control:hover,
        .admin-dashboard-final .dash-date-control:focus{
            background:#111827!important;
            background-image:none!important;
            border-color:#111827!important;
            color:#ffffff!important;
            box-shadow:none!important;
            filter:none!important;
            transform:none!important;
        }

        /* Export + Refresh: same customer-style size/shape, clean alignment. */
        .admin-dashboard-final .dash-export-btn,
        .admin-dashboard-final .dash-refresh-btn{
            height:34px!important;
            min-height:34px!important;
            width:118px!important;
            min-width:118px!important;
            max-width:118px!important;
            padding:0 14px!important;
            border-radius:999px!important;
            font-size:11.5px!important;
            font-weight:500!important;
            line-height:1!important;
            letter-spacing:0!important;
            display:inline-flex!important;
            align-items:center!important;
            justify-content:center!important;
            gap:6px!important;
            white-space:nowrap!important;
            box-shadow:none!important;
            transform:none!important;
            filter:none!important;
        }
        .admin-dashboard-final .dash-export-btn{
            grid-area:export!important;
            background:#ffffff!important;
            background-image:none!important;
            color:#111827!important;
            border:1px solid #111827!important;
        }
        .admin-dashboard-final .dash-refresh-btn{
            grid-area:refresh!important;
            background:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;
            background-image:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;
            color:#ffffff!important;
            border:1px solid transparent!important;
        }
        .admin-dashboard-final .dash-export-btn svg,
        .admin-dashboard-final .dash-refresh-btn svg{
            width:16px!important;
            height:16px!important;
            stroke:currentColor!important;
        }
        .admin-dashboard-final .dash-export-btn:hover,
        .admin-dashboard-final .dash-export-btn:focus,
        .admin-dashboard-final .dash-refresh-btn:hover,
        .admin-dashboard-final .dash-refresh-btn:focus{
            background:#111827!important;
            background-image:none!important;
            color:#ffffff!important;
            border-color:#111827!important;
            box-shadow:none!important;
            filter:none!important;
            transform:none!important;
        }

        /* Calendar popup save button: green gradient requested. */
        .admin-dashboard-final .admin-calendar-save-btn,
        .admin-dashboard-final button[class*="save" i],
        .admin-section-content button[class*="save" i],
        .admin-section-content input[type="submit"][value*="save" i]{
            background:linear-gradient(135deg,#22c55e 0%,#16a34a 100%)!important;
            background-image:linear-gradient(135deg,#22c55e 0%,#16a34a 100%)!important;
            color:#ffffff!important;
            border:0!important;
            border-radius:999px!important;
        }
        .admin-dashboard-final .admin-calendar-save-btn:hover,
        .admin-dashboard-final .admin-calendar-save-btn:focus,
        .admin-dashboard-final button[class*="save" i]:hover,
        .admin-dashboard-final button[class*="save" i]:focus,
        .admin-section-content button[class*="save" i]:hover,
        .admin-section-content button[class*="save" i]:focus,
        .admin-section-content input[type="submit"][value*="save" i]:hover,
        .admin-section-content input[type="submit"][value*="save" i]:focus{
            background:#111827!important;
            background-image:none!important;
            color:#ffffff!important;
        }

        @media(max-width:1024px){
            .admin-main-shell,
            .admin-main-shell.expanded{
                margin-left:var(--sidebar-closed-width)!important;
                width:calc(100% - var(--sidebar-closed-width))!important;
                max-width:calc(100% - var(--sidebar-closed-width))!important;
            }
        }
        @media(max-width:760px){
            .admin-main-shell,
            .admin-main-shell.expanded{
                margin-left:0!important;
                width:100%!important;
                max-width:100%!important;
            }
            .admin-dashboard-final .dash-page-head{
                flex-direction:column!important;
                align-items:stretch!important;
            }
            .admin-dashboard-final .dash-head-actions{
                width:100%!important;
                min-width:0!important;
                grid-template-columns:1fr 1fr!important;
            }
            .admin-dashboard-final .dash-date-control{
                min-width:0!important;
            }
            .admin-dashboard-final .dash-export-btn,
            .admin-dashboard-final .dash-refresh-btn{
                width:100%!important;
                max-width:100%!important;
                min-width:0!important;
            }
        }
    </style>
    <script id="admin-dashboard-final-v3-date-cleaner">
        document.addEventListener('alpine:init', function(){
            setTimeout(function(){
                document.querySelectorAll('.admin-dashboard-final .dash-date-control span').forEach(function(el){
                    el.textContent = (el.textContent || '').replace(/\s*-\s*Present\s*$/i, '').replace(/\s+Present\s*$/i, '').trim();
                });
            }, 80);
        });
        document.addEventListener('DOMContentLoaded', function(){
            setInterval(function(){
                document.querySelectorAll('.admin-dashboard-final .dash-date-control span').forEach(function(el){
                    var cleaned = (el.textContent || '').replace(/\s*-\s*Present\s*$/i, '').replace(/\s+Present\s*$/i, '').trim();
                    if(el.textContent !== cleaned) el.textContent = cleaned;
                });
            }, 500);
        });
    </script>

    <!-- =========================================================
         FINAL REQUEST PATCH - dashboard box borders
         - {{ $isDeveloperPortal ? 'Recent Audit Activity' : 'Recent Admin Activity' }} and Latest Transactions: black border
         - System Alerts and Low Stock Alerts: black border each
         - Print Production Live Status and Order Pipeline Snapshot: box exists but border is hidden
    ========================================================== -->
    <style id="admin-dashboard-final-box-border-request">
        .admin-dashboard-final .dash-production-panel,
        .admin-dashboard-final .dash-pipeline-panel{
            border-color:transparent!important;
            box-shadow:none!important;
            background:#ffffff!important;
        }

        .admin-dashboard-final .dash-production-panel:hover,
        .admin-dashboard-final .dash-pipeline-panel:hover{
            border-color:transparent!important;
            background:#ffffff!important;
        }

        .admin-dashboard-final .dash-activity-panel,
        .admin-dashboard-final .dash-transactions-panel,
        .admin-dashboard-final .dash-alerts-stock-panel{
            border:1.4px solid #111827!important;
            box-shadow:none!important;
            background:#ffffff!important;
        }

        .admin-dashboard-final .dash-activity-panel:hover,
        .admin-dashboard-final .dash-transactions-panel:hover,
        .admin-dashboard-final .dash-alerts-stock-panel:hover{
            border-color:#111827!important;
            background:#ffffff!important;
        }

        .admin-dashboard-final .dash-alert-stock-inner{
            align-items:stretch!important;
        }

        .admin-dashboard-final .dash-system-alerts-panel,
        .admin-dashboard-final .dash-low-stock-panel{
            border:1.4px solid #111827!important;
            border-radius:12px!important;
            background:#ffffff!important;
            padding:13px!important;
            min-height:100%!important;
        }

        .admin-dashboard-final .dash-system-alerts-panel{
            border-right:1.4px solid #111827!important;
            padding-right:13px!important;
        }

        .admin-dashboard-final .dash-low-stock-panel{
            overflow:hidden!important;
        }

        @media(max-width:1200px){
            .admin-dashboard-final .dash-system-alerts-panel{
                border-right:1.4px solid #111827!important;
                border-bottom:1.4px solid #111827!important;
                padding-right:13px!important;
                padding-bottom:13px!important;
            }
        }
    </style>



    <!-- =========================================================
         USER REQUEST PATCH - single alert borders, subtle live boxes, smaller calendar
         - System Alerts and Low Stock Alerts: one black border each, no outer/double border
         - Print Production Live Status and Order Pipeline Snapshot: subtle visible boxes
         - Calendar/date control width reduced back to compact size
    ========================================================== -->
    <style id="admin-dashboard-user-request-border-calendar-fix">
        /* Print Production Live Status + Order Pipeline Snapshot: visible but subtle box */
        .admin-dashboard-final .dash-grid-three > article.dash-main-box:nth-child(1),
        .admin-dashboard-final .dash-grid-three > article.dash-main-box:nth-child(2){
            border:1px solid #D8DEE8!important;
            background:#FFFFFF!important;
            box-shadow:0 4px 14px rgba(15,23,42,.035)!important;
        }
        .admin-dashboard-final .dash-grid-three > article.dash-main-box:nth-child(1):hover,
        .admin-dashboard-final .dash-grid-three > article.dash-main-box:nth-child(2):hover{
            border-color:#CBD5E1!important;
            box-shadow:0 6px 18px rgba(15,23,42,.05)!important;
            background:#FFFFFF!important;
        }

        /* System Alerts + Low Stock Alerts: remove the parent/double border */
        .admin-dashboard-final .dash-alert-stock-box{
            border:0!important;
            background:transparent!important;
            box-shadow:none!important;
            padding:0!important;
            min-height:auto!important;
        }
        .admin-dashboard-final .dash-alert-stock-box:hover{
            border-color:transparent!important;
            background:transparent!important;
            box-shadow:none!important;
        }
        .admin-dashboard-final .dash-alert-stock-inner{
            display:grid!important;
            grid-template-columns:minmax(0,1.05fr) minmax(0,1.35fr)!important;
            gap:14px!important;
            align-items:stretch!important;
        }
        .admin-dashboard-final .dash-alert-area,
        .admin-dashboard-final .dash-stock-area{
            border:1px solid #111827!important;
            border-radius:12px!important;
            background:#FFFFFF!important;
            box-shadow:none!important;
            padding:14px!important;
            min-width:0!important;
        }
        .admin-dashboard-final .dash-alert-area{
            border-right:1px solid #111827!important;
            padding-right:14px!important;
        }
        .admin-dashboard-final .dash-stock-area{
            overflow:hidden!important;
        }
        .admin-dashboard-final .dash-alert-area:hover,
        .admin-dashboard-final .dash-stock-area:hover{
            background:#FFFFFF!important;
            border-color:#111827!important;
        }

        /* {{ $isDeveloperPortal ? 'Recent Audit Activity' : 'Recent Admin Activity' }} + Latest Transactions: black border remains only on their own cards */
        .admin-dashboard-final .dash-grid-three.equal > article.dash-main-box:nth-child(1),
        .admin-dashboard-final .dash-grid-three.equal > article.dash-main-box:nth-child(2){
            border:1px solid #111827!important;
            box-shadow:none!important;
            background:#FFFFFF!important;
        }

        /* Calendar/date control: reduce width back to compact dashboard size */
        .admin-dashboard-final .dash-head-actions{
            grid-template-columns:105px 105px!important;
            grid-template-areas:"date date" "export refresh"!important;
            min-width:219px!important;
            max-width:219px!important;
            gap:8px!important;
        }
        .admin-dashboard-final .dash-date-control{
            min-width:219px!important;
            width:219px!important;
            max-width:219px!important;
            height:40px!important;
            min-height:40px!important;
            padding:0 12px!important;
            border-radius:8px!important;
            grid-template-columns:16px minmax(0,1fr) 14px!important;
            column-gap:8px!important;
        }
        .admin-dashboard-final .dash-date-control span{
            font-size:11.5px!important;
        }
        .admin-dashboard-final .dash-export-btn,
        .admin-dashboard-final .dash-refresh-btn{
            width:105px!important;
            min-width:105px!important;
            max-width:105px!important;
            height:33px!important;
            min-height:33px!important;
            padding:0 12px!important;
        }

        @media(max-width:1200px){
            .admin-dashboard-final .dash-alert-stock-inner{
                grid-template-columns:1fr!important;
            }
            .admin-dashboard-final .dash-alert-area{
                border-right:1px solid #111827!important;
                border-bottom:1px solid #111827!important;
                padding-right:14px!important;
                padding-bottom:14px!important;
            }
        }
        @media(max-width:760px){
            .admin-dashboard-final .dash-head-actions{
                max-width:none!important;
                width:100%!important;
                grid-template-columns:1fr 1fr!important;
            }
            .admin-dashboard-final .dash-date-control{
                width:100%!important;
                max-width:none!important;
                min-width:0!important;
            }
            .admin-dashboard-final .dash-export-btn,
            .admin-dashboard-final .dash-refresh-btn{
                width:100%!important;
                max-width:none!important;
                min-width:0!important;
            }
        }
    </style>


    <!-- =========================================================
         FINAL USER PATCH V3 - System Alerts + Low Stock Alerts single shared box
         - One black border around both sections only
         - No individual boxes/borders inside
         - Keeps a light divider between System Alerts and Low Stock Alerts
    ========================================================== -->
    <style id="admin-dashboard-alert-stock-single-box-final">
        .admin-dashboard-final .dash-alert-stock-box,
        .admin-dashboard-final .dash-alerts-stock-panel{
            border:1px solid #111827!important;
            border-radius:12px!important;
            background:#FFFFFF!important;
            box-shadow:none!important;
            padding:14px!important;
            min-height:164px!important;
            overflow:hidden!important;
        }

        .admin-dashboard-final .dash-alert-stock-box:hover,
        .admin-dashboard-final .dash-alerts-stock-panel:hover{
            border-color:#111827!important;
            background:#FFFFFF!important;
            box-shadow:none!important;
        }

        .admin-dashboard-final .dash-alert-stock-inner{
            display:grid!important;
            grid-template-columns:minmax(0,1.05fr) minmax(0,1.35fr)!important;
            gap:0!important;
            align-items:stretch!important;
        }

        .admin-dashboard-final .dash-alert-area,
        .admin-dashboard-final .dash-stock-area,
        .admin-dashboard-final .dash-system-alerts-panel,
        .admin-dashboard-final .dash-low-stock-panel{
            border:0!important;
            border-radius:0!important;
            background:transparent!important;
            box-shadow:none!important;
            min-width:0!important;
            min-height:auto!important;
            overflow:visible!important;
        }

        .admin-dashboard-final .dash-alert-area,
        .admin-dashboard-final .dash-system-alerts-panel{
            padding:0 16px 0 0!important;
            border-right:1px solid #E5E7EB!important;
        }

        .admin-dashboard-final .dash-stock-area,
        .admin-dashboard-final .dash-low-stock-panel{
            padding:0 0 0 16px!important;
            overflow:hidden!important;
        }

        .admin-dashboard-final .dash-alert-area:hover,
        .admin-dashboard-final .dash-stock-area:hover,
        .admin-dashboard-final .dash-system-alerts-panel:hover,
        .admin-dashboard-final .dash-low-stock-panel:hover{
            border-color:#E5E7EB!important;
            background:transparent!important;
            box-shadow:none!important;
        }

        @media(max-width:1200px){
            .admin-dashboard-final .dash-alert-stock-inner{
                grid-template-columns:1fr!important;
                gap:14px!important;
            }
            .admin-dashboard-final .dash-alert-area,
            .admin-dashboard-final .dash-system-alerts-panel{
                padding:0 0 14px 0!important;
                border-right:0!important;
                border-bottom:1px solid #E5E7EB!important;
            }
            .admin-dashboard-final .dash-stock-area,
            .admin-dashboard-final .dash-low-stock-panel{
                padding:0!important;
            }
        }
    </style>



    <!-- =========================================================
         FINAL USER PATCH V4
         - Apply Support Center / Knowledge Base Management box style
           to Print Production Live Status and Order Pipeline Snapshot
         - Apply support center top + left spacing to Dashboard wrapper
         - Keep System Alerts + Low Stock Alerts in one shared box
         - Keep calendar compact
    ========================================================== -->
    <style id="admin-dashboard-helpcenter-spacing-and-panel-style-final">
        .admin-dashboard-final{
            max-width:1320px!important;
            margin:0 auto!important;
            padding:32px 26px 42px!important;
            background:#F8FBFF!important;
            color:#1E293B!important;
        }

        .admin-dashboard-final .dash-page-head{
            margin-top:0!important;
            margin-bottom:24px!important;
        }

        .admin-dashboard-final .dash-title-wrap{
            padding-left:0!important;
            padding-top:12px!important;
        }

        .admin-dashboard-final .dash-title-wrap:before{
            left:0!important;
            top:0!important;
            width:68px!important;
            height:4px!important;
            border-radius:999px!important;
            background:linear-gradient(90deg,#0B63F6,#4a90ff)!important;
        }

        .admin-dashboard-final .dash-title-wrap h1{
            margin:0 0 7px!important;
        }

        .admin-dashboard-final .dash-title-wrap p{
            margin:0!important;
        }

        .admin-dashboard-final .dash-metrics{
            margin-bottom:18px!important;
        }

        .admin-dashboard-final .dash-grid-three,
        .admin-dashboard-final .dash-alert-stock-grid,
        .admin-dashboard-final .dash-grid-three.equal{
            margin-bottom:16px!important;
        }

        /* Knowledge Base Management box style applied here. */
        .admin-dashboard-final .dash-grid-three:first-of-type > .dash-main-box:nth-child(1),
        .admin-dashboard-final .dash-grid-three:first-of-type > .dash-main-box:nth-child(2){
            background:#FFFFFF!important;
            border:1px solid #DDE6F2!important;
            border-radius:14px!important;
            box-shadow:0 10px 25px rgba(15,23,42,0.045)!important;
            padding:18px!important;
            overflow:hidden!important;
        }

        .admin-dashboard-final .dash-grid-three:first-of-type > .dash-main-box:nth-child(1):hover,
        .admin-dashboard-final .dash-grid-three:first-of-type > .dash-main-box:nth-child(2):hover{
            background:#FFFFFF!important;
            border-color:#DDE6F2!important;
            box-shadow:0 10px 25px rgba(15,23,42,0.045)!important;
        }

        .admin-dashboard-final .dash-grid-three:first-of-type > .dash-main-box:nth-child(1) .dash-card-title,
        .admin-dashboard-final .dash-grid-three:first-of-type > .dash-main-box:nth-child(2) .dash-card-title{
            margin:0 0 15px!important;
            color:#0F172A!important;
            font-family:'Poppins','Inter',sans-serif!important;
            font-size:17px!important;
            font-weight:800!important;
            line-height:1.25!important;
            display:flex!important;
            align-items:center!important;
            gap:9px!important;
        }

        .admin-dashboard-final .dash-grid-three:first-of-type > .dash-main-box:nth-child(1) .dash-card-title:before,
        .admin-dashboard-final .dash-grid-three:first-of-type > .dash-main-box:nth-child(2) .dash-card-title:before{
            content:''!important;
            display:inline-block!important;
            width:15px!important;
            height:3px!important;
            border-radius:999px!important;
            background:#0B63F6!important;
            position:static!important;
            margin:0!important;
            flex:0 0 auto!important;
        }

        /* Keep System Alerts + Low Stock Alerts as one combined black box only. */
        .admin-dashboard-final .dash-alert-stock-box,
        .admin-dashboard-final .dash-alerts-stock-panel{
            border:1px solid #111827!important;
            border-radius:12px!important;
            background:#FFFFFF!important;
            box-shadow:none!important;
            padding:14px!important;
            overflow:hidden!important;
        }

        .admin-dashboard-final .dash-alert-stock-inner{
            display:grid!important;
            grid-template-columns:minmax(0,1.05fr) minmax(0,1.35fr)!important;
            gap:0!important;
            align-items:stretch!important;
        }

        .admin-dashboard-final .dash-alert-area,
        .admin-dashboard-final .dash-stock-area,
        .admin-dashboard-final .dash-system-alerts-panel,
        .admin-dashboard-final .dash-low-stock-panel{
            border:0!important;
            border-radius:0!important;
            background:transparent!important;
            box-shadow:none!important;
            min-width:0!important;
            min-height:auto!important;
            overflow:visible!important;
        }

        .admin-dashboard-final .dash-alert-area,
        .admin-dashboard-final .dash-system-alerts-panel{
            padding:0 16px 0 0!important;
            border-right:1px solid #E5E7EB!important;
        }

        .admin-dashboard-final .dash-stock-area,
        .admin-dashboard-final .dash-low-stock-panel{
            padding:0 0 0 16px!important;
            overflow:hidden!important;
        }

        /* Calendar width kept compact / old size. */
        .admin-dashboard-final .dash-head-actions{
            grid-template-columns:105px 105px!important;
            grid-template-areas:"date date" "export refresh"!important;
            gap:9px!important;
            justify-content:end!important;
            align-items:center!important;
            min-width:219px!important;
            max-width:219px!important;
        }

        .admin-dashboard-final .dash-date-control{
            grid-area:date!important;
            min-width:219px!important;
            width:219px!important;
            max-width:219px!important;
            height:40px!important;
            min-height:40px!important;
            padding:0 12px!important;
            border-radius:8px!important;
            grid-template-columns:16px minmax(0,1fr) 14px!important;
            column-gap:8px!important;
        }

        .admin-dashboard-final .dash-export-btn,
        .admin-dashboard-final .dash-refresh-btn{
            width:105px!important;
            min-width:105px!important;
            max-width:105px!important;
            height:33px!important;
            min-height:33px!important;
            padding:0 12px!important;
        }

        @media(max-width:1200px){
            .admin-dashboard-final{
                padding:28px 22px 38px!important;
            }
            .admin-dashboard-final .dash-alert-stock-inner{
                grid-template-columns:1fr!important;
                gap:14px!important;
            }
            .admin-dashboard-final .dash-alert-area,
            .admin-dashboard-final .dash-system-alerts-panel{
                padding:0 0 14px 0!important;
                border-right:0!important;
                border-bottom:1px solid #E5E7EB!important;
            }
            .admin-dashboard-final .dash-stock-area,
            .admin-dashboard-final .dash-low-stock-panel{
                padding:0!important;
            }
        }

        @media(max-width:760px){
            .admin-dashboard-final{
                padding:20px 16px 34px!important;
            }
            .admin-dashboard-final .dash-page-head{
                flex-direction:column!important;
                align-items:stretch!important;
            }
            .admin-dashboard-final .dash-head-actions{
                width:100%!important;
                min-width:0!important;
                max-width:none!important;
                grid-template-columns:1fr 1fr!important;
            }
            .admin-dashboard-final .dash-date-control{
                width:100%!important;
                min-width:0!important;
                max-width:none!important;
            }
            .admin-dashboard-final .dash-export-btn,
            .admin-dashboard-final .dash-refresh-btn{
                width:100%!important;
                min-width:0!important;
                max-width:none!important;
            }
        }
    </style>

<style id="admin-developer-portal-final-cleanup">
    .staff-portal-shell,
    .admin-main-shell{
        --portal-accent: {{ $isDeveloperPortal ? '#10B981' : '#2563EB' }};
        --portal-accent-soft: {{ $isDeveloperPortal ? '#ECFDF5' : '#EFF6FF' }};
        --portal-accent-shadow: {{ $isDeveloperPortal ? 'rgba(16,185,129,.28)' : 'rgba(37,99,235,.28)' }};
    }
    body{background:#fff!important}
    .admin-main-shell,
    .content-container,
    .admin-section-content,
    .admin-dashboard-final,
    .admin-section-content > .main-wrapper,
    .admin-section-content > .analytics-section,
    .admin-section-content > .settings-section,
    .admin-section-content .main-wrapper,
    .admin-section-content .analytics-section,
    .admin-section-content .settings-section,
    .settings-admin-shell{
        background:#fff!important;
        background-image:none!important;
        box-shadow:none!important;
    }
    .admin-main-shell:before,
    .admin-main-shell:after,
    .content-container:before,
    .content-container:after,
    .admin-section-content:before,
    .admin-section-content:after,
    .admin-dashboard-final:before,
    .admin-dashboard-final:after,
    .settings-admin-shell:before,
    .settings-admin-shell:after{
        display:none!important;
        content:none!important;
    }
    .admin-main-shell .quick-actions-container,
    .admin-main-shell .action-circle-group{
        display:none!important;
    }
    .staff-portal-shell .sidebar{
        width:260px!important;
        background:#fff!important;
        border-right:1px solid #E2E8F0!important;
        box-shadow:4px 0 24px rgba(0,0,0,.025)!important;
    }
    .admin-main-shell.expanded{margin-left:85px!important}
    .admin-main-shell:not(.expanded){margin-left:260px!important}
    .staff-portal-shell .sidebar.closed{width:85px!important}
    .staff-portal-shell .sidebar-header{
        min-height:96px!important;
        padding:1.5rem!important;
        border-bottom:1px solid #F1F5F9!important;
    }
    .staff-portal-shell .sidebar-link{
        min-height:46px!important;
        margin-bottom:5px!important;
        padding:11px 16px!important;
        border-radius:12px!important;
        color:#64748B!important;
        background:transparent!important;
        border:0!important;
        box-shadow:none!important;
        font-size:10px!important;
        font-weight:800!important;
        text-transform:uppercase!important;
        transition:background .18s ease,color .18s ease,border-color .18s ease!important;
    }
    .staff-portal-shell .sidebar-link:not(.active):hover,
    .staff-portal-shell .sidebar-link:not(.active):focus-visible{
        background:rgba(17,24,39,.10)!important;
        color:#334155!important;
        border:0!important;
        box-shadow:none!important;
        transform:none!important;
        outline:0!important;
    }
    .staff-portal-shell .sidebar-link.active{
        background:var(--portal-accent-soft)!important;
        color:var(--portal-accent)!important;
        box-shadow:none!important;
    }
    .staff-portal-shell .sidebar-link.active::before{
        background:var(--portal-accent)!important;
    }
    .staff-portal-shell .sidebar-link.active::after{
        color:var(--portal-accent)!important;
        background:transparent!important;
    }
    .staff-portal-shell .sidebar-link.active i,
    .staff-portal-shell .sidebar-link.active svg{
        color:var(--portal-accent)!important;
        stroke:var(--portal-accent)!important;
    }
    .staff-portal-shell .menu-toggle:hover{
        background:#F1F5F9!important;
        color:var(--portal-accent)!important;
    }
    .admin-main-shell .hero-banner{
        height:210px!important;
        padding:5px 60px!important;
        border-radius:0!important;
        box-shadow:none!important;
    }
    .admin-main-shell .hero-title-area{
        margin-top:0!important;
        max-width:720px!important;
    }
    .admin-main-shell .hero-title-area::before{
        width:74px!important;
        height:4px!important;
        margin-bottom:10px!important;
        background:linear-gradient(90deg,var(--portal-accent),#60A5FA)!important;
        box-shadow:0 8px 20px var(--portal-accent-shadow)!important;
    }
    .admin-main-shell .hero-kicker::before{
        background:var(--portal-accent)!important;
        box-shadow:0 0 12px var(--portal-accent)!important;
    }
    .admin-main-shell .hero-main-title{
        font-size:clamp(2.1rem,4.4vw,3.35rem)!important;
        line-height:1!important;
        color:#fff!important;
        white-space:nowrap!important;
    }
    .admin-main-shell .hero-main-title span:first-child{
        color:#fff!important;
    }
    .admin-main-shell .hero-main-title .portal-dashboard-word{
        color:var(--portal-accent)!important;
    }
    .admin-main-shell .dot.active{
        background:var(--portal-accent)!important;
    }
    .admin-main-shell .top-nav{
        height:52px!important;
        margin-top:10px!important;
        gap:10px!important;
        align-items:center!important;
        justify-content:flex-end!important;
    }
    .admin-main-shell .header-search-wrap{
        width:240px!important;
        min-width:240px!important;
        height:38px!important;
    }
    .admin-main-shell .header-search-box{
        height:38px!important;
        border-radius:999px!important;
        border:1px solid rgba(15,23,42,.88)!important;
        background:#fff!important;
        color:#111827!important;
        padding:0 44px 0 42px!important;
        font-size:13px!important;
        font-weight:600!important;
        box-shadow:0 12px 26px rgba(15,23,42,.16)!important;
    }
    .admin-main-shell .header-search-box::placeholder{
        color:#64748B!important;
    }
    .admin-main-shell .header-search-submit{
        left:8px!important;
        right:auto!important;
        width:30px!important;
        height:30px!important;
        border-radius:999px!important;
        background:transparent!important;
        color:#64748B!important;
        border:0!important;
        box-shadow:none!important;
    }
    .admin-main-shell .header-search-submit:hover{
        background:#F1F5F9!important;
        color:var(--portal-accent)!important;
    }
    .admin-main-shell .header-icon-no-box{
        width:34px!important;
        height:34px!important;
        border-radius:999px!important;
        color:rgba(255,255,255,.86)!important;
        border:0!important;
        background:transparent!important;
        box-shadow:none!important;
    }
    .admin-main-shell .header-icon-no-box:hover,
    .admin-main-shell .header-icon-no-box.is-active{
        background:rgba(255,255,255,.16)!important;
        color:#fff!important;
    }
    .admin-main-shell .red-dot{
        top:-4px!important;
        right:-4px!important;
        min-width:17px!important;
        height:17px!important;
        background:#FF7A00!important;
        border:2px solid rgba(15,23,42,.82)!important;
        font-size:9px!important;
    }
    .admin-main-shell .profile-area{
        gap:8px!important;
        min-width:0!important;
        padding-left:4px!important;
    }
    .admin-main-shell .profile-pic{
        width:48px!important;
        height:48px!important;
        background:#E5E7EB!important;
        color:#111827!important;
        border:2px solid rgba(255,255,255,.5)!important;
        box-shadow:0 10px 24px rgba(15,23,42,.2)!important;
    }
    .admin-main-shell .profile-pic span{
        display:grid!important;
        place-items:center!important;
        width:100%!important;
        height:100%!important;
        font-size:16px!important;
        font-weight:900!important;
    }
    .admin-main-shell .green-dot{
        bottom:2px!important;
        right:1px!important;
        width:10px!important;
        height:10px!important;
        border:2px solid rgba(15,23,42,.72)!important;
        box-shadow:none!important;
    }
    .admin-main-shell .staff-home-link:hover,
    .admin-main-shell .staff-home-link:focus-visible{
        background:var(--portal-accent-soft)!important;
        color:var(--portal-accent)!important;
    }
    .admin-main-shell .content-container,
    .admin-main-shell .admin-section-content{
        padding:32px 70px 70px!important;
    }
    .admin-main-shell .date-pill,
    .admin-main-shell .dash-date-control,
    .admin-main-shell .admin-date-control,
    .admin-main-shell .settings-date-control,
    .admin-main-shell .settings-calendar-trigger{
        cursor:pointer!important;
    }
    .staff-portal-shell.staff-portal-admin .sidebar .sidebar-link.active,
    .staff-portal-shell.staff-portal-admin .sidebar .sidebar-link.active span,
    .staff-portal-shell.staff-portal-admin .sidebar .sidebar-link.active i,
    .staff-portal-shell.staff-portal-admin .sidebar .sidebar-link.active svg,
    .staff-portal-shell.staff-portal-admin .sidebar .sidebar-link.active svg *{
        color:#2563EB!important;
        stroke:#2563EB!important;
    }
    .staff-portal-shell.staff-portal-admin .sidebar .sidebar-link.active{
        background:#EFF6FF!important;
    }
    .staff-portal-shell.staff-portal-admin .sidebar .sidebar-link.active::before{
        background:#2563EB!important;
    }
    .staff-portal-shell.staff-portal-admin .sidebar .sidebar-link.active::after{
        color:#2563EB!important;
        background:transparent!important;
    }
    .staff-portal-shell.staff-portal-developer .sidebar .sidebar-link.active,
    .staff-portal-shell.staff-portal-developer .sidebar .sidebar-link.active span,
    .staff-portal-shell.staff-portal-developer .sidebar .sidebar-link.active i,
    .staff-portal-shell.staff-portal-developer .sidebar .sidebar-link.active svg,
    .staff-portal-shell.staff-portal-developer .sidebar .sidebar-link.active svg *{
        color:#10B981!important;
        stroke:#10B981!important;
    }
    .staff-portal-shell.staff-portal-developer .sidebar .sidebar-link.active{
        background:#ECFDF5!important;
    }
    .staff-portal-shell.staff-portal-developer .sidebar .sidebar-link.active::before{
        background:#10B981!important;
    }
    .staff-portal-shell.staff-portal-developer .sidebar .sidebar-link.active::after{
        color:#10B981!important;
        background:transparent!important;
    }
    @media(max-width:1024px){
        .admin-main-shell:not(.expanded),
        .admin-main-shell.expanded{margin-left:85px!important}
        .staff-portal-shell .sidebar{width:85px!important}
        .staff-portal-shell .brand-name,
        .staff-portal-shell .sidebar-link span,
        .staff-portal-shell .sidebar-link.active::after{display:none!important}
        .staff-portal-shell .sidebar-link{justify-content:center!important;padding-left:0!important;padding-right:0!important}
        .admin-main-shell .hero-banner{padding:5px 28px!important}
        .admin-main-shell .content-container,
        .admin-main-shell .admin-section-content{padding:32px 40px 60px!important}
    }
    @media(max-width:760px){
        .admin-main-shell:not(.expanded),
        .admin-main-shell.expanded{margin-left:0!important}
        .admin-main-shell .hero-banner{height:390px!important;padding:16px!important}
        .admin-main-shell .content-container,
        .admin-main-shell .admin-section-content{padding:20px 16px!important}
    }
</style>
</x-app-layout>
