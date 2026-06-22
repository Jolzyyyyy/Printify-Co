<x-app-layout>
@php
    $orders = $orders instanceof \Illuminate\Support\Collection ? $orders : collect($orders ?? []);
    $selectedStatus = $selectedStatus ?? request('status', 'all');
    $searchTerm = $searchTerm ?? trim((string) request('q', ''));
    $money = fn ($value) => '₱' . number_format((float) $value, 2);
    $orderNo = fn ($order) => $order->order_reference ?: 'ORD-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT);
    $itemFor = fn ($order) => optional($order->items ?? collect())->first();
    $serviceName = function ($order) use ($itemFor) {
        $item = $itemFor($order);
        return $item?->service_name ?: $item?->service?->name ?: 'Print Job';
    };
    $statusKey = function ($order) {
        $raw = strtolower(str_replace([' ', '-'], '_', (string) ($order->lalamove_status ?: $order->delivery_booking_status ?: $order->status ?: 'pending')));

        return match (true) {
            str_contains($raw, 'cancel') || str_contains($raw, 'fail') => 'cancelled',
            str_contains($raw, 'delivered') || str_contains($raw, 'completed') => 'toreview',
            str_contains($raw, 'transit') || str_contains($raw, 'ongoing') || str_contains($raw, 'picked') || str_contains($raw, 'out_for_delivery') || str_contains($raw, 'ship') || str_contains($raw, 'assigned') => 'toreceive',
            str_contains($raw, 'paid') || str_contains($raw, 'process') || str_contains($raw, 'ready') || str_contains($raw, 'booked') || str_contains($raw, 'confirm') => 'toship',
            default => 'topay',
        };
    };
    $statusMeta = function ($order) use ($statusKey) {
        return match ($statusKey($order)) {
            'cancelled' => ['label' => 'Cancelled', 'class' => 'status-cancelled'],
            'toreview' => ['label' => 'Completed', 'class' => 'status-delivered'],
            'toreceive' => ['label' => 'In Transit', 'class' => 'status-shipped'],
            'toship' => ['label' => 'Processing', 'class' => 'status-processing'],
            default => ['label' => 'To Pay', 'class' => 'status-pending'],
        };
    };
    $tabs = [
        'all' => 'All',
        'topay' => 'To Pay',
        'toship' => 'To Ship',
        'toreceive' => 'To Receive',
        'toreview' => 'To Review',
        'cancelled' => 'Cancelled',
    ];
    $counts = collect($tabs)->mapWithKeys(fn ($label, $key) => [
        $key => $key === 'all' ? $orders->count() : $orders->filter(fn ($order) => $statusKey($order) === $key)->count(),
    ]);
    $visibleOrders = $orders
        ->filter(fn ($order) => $selectedStatus === 'all' || $statusKey($order) === $selectedStatus)
        ->filter(function ($order) use ($searchTerm, $orderNo, $serviceName) {
            if ($searchTerm === '') return true;
            $haystack = strtolower($orderNo($order) . ' ' . $serviceName($order) . ' ' . ($order->delivery_method ?? '') . ' ' . ($order->payment_method ?? ''));
            return str_contains($haystack, strtolower($searchTerm));
        })
        ->values();
@endphp

<style>
.customer-dashboard-v2.orders-portal-page{padding:0 0 36px;background:#fff;min-height:calc(100vh - 70px)}
.orders-portal-page .dashboard-shell{max-width:1490px;margin:0 auto;padding:0}
.orders-portal-page .orders-portal-head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin-bottom:18px}
.orders-portal-page .orders-crumb{display:flex;align-items:center;gap:10px;margin-bottom:12px;color:#6b7280;font-size:12px;font-weight:700}
.orders-portal-page .orders-crumb a{position:relative;color:#6b7280;text-decoration:none;transition:color .18s ease}
.orders-portal-page .orders-crumb a:after{content:'';position:absolute;left:0;right:0;bottom:-4px;height:2px;border-radius:999px;background:#ff7a00;transform:scaleX(0);transform-origin:left;transition:transform .18s ease}
.orders-portal-page .orders-crumb a:hover,.orders-portal-page .orders-crumb a:focus{color:#111827;outline:0}
.orders-portal-page .orders-crumb a:hover:after,.orders-portal-page .orders-crumb a:focus:after{transform:scaleX(1)}
.orders-portal-page .orders-crumb .current{color:#111827}
.orders-portal-page .orders-summary-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:14px;margin-bottom:18px}
.orders-portal-page .stat-card{min-height:92px;padding:15px 16px;border-radius:8px;border:1px solid var(--stat-color,#111827);background:var(--stat-soft,#fff3e6);box-shadow:none;display:grid;gap:6px;color:#111827}
.orders-portal-page .stat-title{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#374151}
.orders-portal-page .stat-value{font-size:24px;font-weight:700;line-height:1;color:var(--stat-color,#ff7a00)}
.orders-portal-page .stat-note{font-size:10.5px;color:#4b5563;line-height:1.35}
.orders-portal-page .orders-card{border:1px solid #111827;border-radius:8px;background:#fff;box-shadow:none;overflow:hidden}
.orders-portal-page .portal-filter-row{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 18px 0;flex-wrap:wrap}
.orders-portal-page .portal-tabs{display:flex;align-items:center;gap:18px;flex-wrap:wrap}
.orders-portal-page .portal-tab{position:relative;border:0;background:transparent;color:#111827;padding:0 0 9px;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.035em;cursor:pointer;text-decoration:none}
.orders-portal-page .portal-tab:after{content:'';position:absolute;left:0;right:0;bottom:0;height:2px;border-radius:999px;background:#ff7a00;opacity:0;transform:scaleX(0);transition:opacity .18s ease,transform .18s ease}
.orders-portal-page .portal-tab:hover:after,.orders-portal-page .portal-tab.is-active:after{opacity:1;transform:scaleX(1)}
.orders-portal-page .portal-tab .count{display:inline-grid;place-items:center;min-width:18px;height:18px;margin-left:6px;border-radius:999px;background:#f1f5f9;color:#64748b;font-size:9px;font-weight:900}
.orders-portal-page .portal-tab.is-active{color:#ff7a00}.orders-portal-page .portal-tab.is-active .count{background:#ff7a00;color:#fff}
.orders-portal-page .portal-search{display:flex;align-items:center;gap:8px;min-width:320px;height:38px;border:1px solid #111827;border-radius:10px;background:#fff;padding:0 10px}
.orders-portal-page .portal-search input{flex:1;min-width:0;border:0;outline:0;background:transparent;font-size:12px;color:#111827}
.orders-portal-page .portal-search button{width:30px;height:30px;border:0;border-radius:8px;background:#ff7a00;color:#111827;display:grid;place-items:center;cursor:pointer}
.orders-portal-page .portal-search button:hover{background:#111827;color:#fff}
.orders-portal-page .recent-table-wrap{padding:14px 18px 18px;overflow-x:auto}
.orders-portal-page .orders-table{width:100%;border-collapse:separate;border-spacing:0;font-size:11px;color:#374151}
.orders-portal-page .orders-table thead th{height:34px;padding:0 10px;background:#fafafa;border-top:1px solid #e5e7eb;border-bottom:1px solid #e5e7eb;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.035em;color:#4b5563;text-align:left;white-space:nowrap}
.orders-portal-page .orders-table thead th:first-child{border-left:1px solid #e5e7eb;border-radius:9px 0 0 9px}.orders-portal-page .orders-table thead th:last-child{border-right:1px solid #e5e7eb;border-radius:0 9px 9px 0;text-align:center}
.orders-portal-page .orders-table tbody td{height:58px;padding:9px 10px;border-bottom:1px solid #f0f1f3;white-space:nowrap;vertical-align:middle}
.orders-portal-page .orders-table tbody tr:hover{background:rgba(17,24,39,.08)}
.orders-portal-page .order-id{font-weight:700;color:#111827;letter-spacing:.016em}.orders-portal-page .product-name{max-width:220px;overflow:hidden;text-overflow:ellipsis}.orders-portal-page .amount-cell{font-weight:700;color:#111827}
.orders-portal-page .status-pill{display:inline-flex;align-items:center;justify-content:center;min-width:78px;height:24px;padding:0 10px;border-radius:999px;font-size:9.5px;font-weight:700;line-height:1.1}.orders-portal-page .status-pending{background:#fff7df;color:#b7791f}.orders-portal-page .status-processing{background:#f2ebff;color:#7c3aed}.orders-portal-page .status-shipped{background:#eaf2ff;color:#2563eb}.orders-portal-page .status-delivered{background:#eaf8ef;color:#16a34a}.orders-portal-page .status-cancelled{background:#fff0f0;color:#ef4444}
.orders-portal-page .view-button{height:30px;min-width:92px;padding:0 12px;border:0;border-radius:8px;background:#ff7a00;color:#111827!important;font-size:10px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;gap:6px;text-decoration:none}.orders-portal-page .view-button:hover,.orders-portal-page .view-button:focus{background:#111827!important;color:#fff!important;outline:0}
.orders-portal-page .empty-state{min-height:220px;display:grid;place-items:center;text-align:center;color:#6b7280;padding:26px}.orders-portal-page .empty-title{margin-top:10px;font-size:15px;font-weight:700;color:#111827}.orders-portal-page .empty-text{margin-top:5px;font-size:12px}.orders-portal-page .empty-state .primary-button{margin-top:14px;height:36px;min-width:132px;border-radius:8px;background:#ff7a00;color:#111827!important;font-size:11px;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}.orders-portal-page .empty-state .primary-button:hover{background:#111827;color:#fff!important}
@media(max-width:1080px){.orders-portal-page .orders-summary-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.orders-portal-page .orders-portal-head{display:grid}.orders-portal-page .portal-search{min-width:0;width:100%}}
@media(max-width:720px){.orders-portal-page{padding:14px 12px 28px}.orders-portal-page .orders-summary-grid{grid-template-columns:1fr}.orders-portal-page .portal-filter-row{padding:14px}.orders-portal-page .orders-table{min-width:760px}}
</style>

<div class="customer-dashboard-v2 orders-portal-page">
    <div class="dashboard-shell">
        <div class="orders-portal-head reveal-card" style="--delay:0ms">
            <div>
                <nav class="orders-crumb" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
                    <i data-lucide="chevron-right" size="14"></i>
                    <span class="current">My Orders</span>
                </nav>
                <div class="overview-title-wrap">
                    <div>
                        <h1 class="overview-kicker">My Orders</h1>
                        <p class="overview-copy">Customer portal order history and real-time tracking links.</p>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('services.index') }}" class="primary-button"><i data-lucide="plus" size="15"></i>New Order</a>
            </div>
        </div>

        <section class="orders-summary-grid" aria-label="Order summary">
            @foreach([
                ['key' => 'all', 'title' => 'Total Orders', 'note' => 'All placed requests', 'color' => 'var(--dash-orange)', 'soft' => 'var(--dash-orange-soft)'],
                ['key' => 'topay', 'title' => 'To Pay', 'note' => 'Waiting payment', 'color' => 'var(--dash-yellow)', 'soft' => 'var(--dash-yellow-soft)'],
                ['key' => 'toship', 'title' => 'To Ship', 'note' => 'Processing prints', 'color' => 'var(--dash-purple)', 'soft' => 'var(--dash-purple-soft)'],
                ['key' => 'toreceive', 'title' => 'To Receive', 'note' => 'Delivery movement', 'color' => 'var(--dash-blue)', 'soft' => 'var(--dash-blue-soft)'],
                ['key' => 'cancelled', 'title' => 'Cancelled', 'note' => 'Needs attention', 'color' => 'var(--dash-red)', 'soft' => 'var(--dash-red-soft)'],
            ] as $card)
                <a href="{{ route('my-orders', array_filter(['status' => $card['key'] === 'all' ? null : $card['key'], 'q' => $searchTerm ?: null])) }}" class="stat-card" style="--stat-color:{{ $card['color'] }};--stat-soft:{{ $card['soft'] }}">
                    <div class="stat-title">{{ $card['title'] }}</div>
                    <div class="stat-value">{{ $counts[$card['key']] ?? 0 }}</div>
                    <div class="stat-note">{{ $card['note'] }}</div>
                </a>
            @endforeach
        </section>

        <section class="orders-card reveal-card" style="--delay:120ms" aria-label="Portal orders list">
            <div class="panel-head">
                <div>
                    <h2 class="card-title">Order History</h2>
                    <p class="card-subtitle">Showing {{ $visibleOrders->count() }} of {{ $orders->count() }} orders.</p>
                </div>
            </div>
            <div class="portal-filter-row">
                <div class="portal-tabs" role="tablist" aria-label="Order filters">
                    @foreach($tabs as $key => $label)
                        <a class="portal-tab {{ $selectedStatus === $key ? 'is-active' : '' }}" href="{{ route('my-orders', array_filter(['status' => $key === 'all' ? null : $key, 'q' => $searchTerm ?: null])) }}">
                            {{ $label }} <span class="count">{{ $counts[$key] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
                <form class="portal-search" method="GET" action="{{ route('my-orders') }}">
                    @if($selectedStatus !== 'all')<input type="hidden" name="status" value="{{ $selectedStatus }}">@endif
                    <i data-lucide="search" size="15"></i>
                    <input type="search" name="q" value="{{ $searchTerm }}" placeholder="Search order, service, payment...">
                    <button type="submit" aria-label="Search orders"><i data-lucide="arrow-right" size="15"></i></button>
                </form>
            </div>

            <div class="recent-table-wrap">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Service</th>
                            <th>Delivery</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visibleOrders as $order)
                            @php
                                $item = $itemFor($order);
                                $meta = $statusMeta($order);
                                $deliveryMethod = $order->delivery_method ? ucwords(str_replace('_', ' ', $order->delivery_method)) : 'Not set';
                            @endphp
                            <tr>
                                <td class="order-id">{{ $orderNo($order) }}</td>
                                <td>{{ optional($order->created_at)->format('M d, Y') }}</td>
                                <td><span class="status-pill {{ $meta['class'] }}">{{ $meta['label'] }}</span></td>
                                <td class="product-name">{{ $serviceName($order) }}</td>
                                <td>{{ $deliveryMethod }}</td>
                                <td class="amount-cell">{{ $money($order->total_price) }}</td>
                                <td style="text-align:center"><a href="{{ route('my-orders.show', $order) }}" class="view-button"><i data-lucide="map-pin" size="13"></i>View</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div>
                                            <i data-lucide="folder-open" size="42"></i>
                                            <div class="empty-title">You have no orders yet.</div>
                                            <div class="empty-text">Place an order and it will appear here with live tracking.</div>
                                            <a href="{{ route('services.index') }}" class="primary-button">Browse Services</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) {
        window.lucide.createIcons();
    }
});
</script>
</x-app-layout>
