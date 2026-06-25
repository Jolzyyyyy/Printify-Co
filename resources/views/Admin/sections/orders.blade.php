@php
    $portalOrders = \App\Models\Order::query()
        ->visibleToPortalUser(auth()->user())
        ->with(['user', 'items.service', 'items.serviceVariation'])
        ->latest()
        ->get();

    $normalizeOrderStatus = static function (?string $status): string {
        $value = strtolower(trim((string) $status));

        return match (true) {
            str_contains($value, 'cancel') => 'Cancelled',
            str_contains($value, 'complete'), str_contains($value, 'deliver') => 'Completed',
            str_contains($value, 'ship'), str_contains($value, 'out for delivery') => 'Shipped',
            str_contains($value, 'ready') => 'Ready for Pickup',
            str_contains($value, 'paid'), str_contains($value, 'confirm'), str_contains($value, 'approved'), str_contains($value, 'process'), str_contains($value, 'production'), str_contains($value, 'verification') => 'Processing',
            default => 'Pending',
        };
    };

    $orderCounts = collect(['Pending', 'Processing', 'Completed', 'Cancelled'])
        ->mapWithKeys(fn (string $status) => [
            $status => $portalOrders->filter(fn ($order) => $normalizeOrderStatus($order->status) === $status)->count(),
        ]);
    $orderTotal = $portalOrders->count();
    $percentage = static fn (int $count): string => $orderTotal > 0
        ? number_format(($count / $orderTotal) * 100, 1).'% ('.$count.')'
        : '0.0% (0)';
    $lalamoveCount = $portalOrders->where('delivery_method', 'lalamove')->count();
    $pickupCount = $orderTotal - $lalamoveCount;

    $imageUrl = function (?string $path) {
        $path = trim((string) $path);
        if ($path === '') return null;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) return $path;
        if (str_starts_with($path, 'images/')) return asset($path);
        return \Illuminate\Support\Facades\Storage::disk('public')->exists($path)
            ? \Illuminate\Support\Facades\Storage::url($path)
            : asset($path);
    };
    $itemImage = fn ($item) => $imageUrl($item?->serviceVariation?->variation_image_path ?: $item?->service?->image_path);

    $adminOrderPayload = $portalOrders->map(function ($order) use ($normalizeOrderStatus, $itemImage) {
        $status = $normalizeOrderStatus($order->status);
        $isLalamove = $order->delivery_method === 'lalamove';
        $subtotal = max(0, (float) $order->total_price - (float) $order->delivery_fee);
        $paid = $order->paid_at
            || filled($order->payment_reference)
            || str_contains(strtolower((string) $order->status), 'paid')
            || str_contains(strtolower((string) $order->status), 'complete');
        $payment = $paid
            ? 'Paid'
            : (str_contains(strtolower((string) $order->status), 'cash on delivery')
            ? 'Cash on Delivery'
            : ($status === 'Completed' ? 'Paid' : 'Unpaid'));

        return [
            'id' => 'ORD-'.str_pad((string) $order->id, 5, '0', STR_PAD_LEFT),
            'databaseId' => $order->id,
            'customer' => $order->customer_name ?: ($order->user?->name ?? 'Customer'),
            'service' => $order->items->pluck('service_name')->filter()->unique()->join(', ') ?: 'Print order',
            'date' => optional($order->created_at)->format('M j, Y') ?? '',
            'dateIso' => optional($order->created_at)->format('Y-m-d') ?? '',
            'payment' => $payment,
            'status' => $status,
            'rawStatus' => $order->status ?: 'Pending',
            'image' => $itemImage($order->items->first()),
            'total' => 'PHP '.number_format((float) $order->total_price, 2),
            'email' => $order->customer_email ?: ($order->user?->email ?? 'Not provided'),
            'phone' => $order->customer_phone ?: ($order->user?->phone ?? 'Not provided'),
            'customerId' => 'Customer ID: '.($order->user_id ?: 'Guest'),
            'address' => $order->delivery_address ?: 'Store pickup',
            'orderDateTime' => optional($order->created_at)->format('M j, Y h:i A') ?? '',
            'fulfillmentType' => $isLalamove ? 'Lalamove' : 'Pickup',
            'estimatedDelivery' => $isLalamove ? 'See Lalamove status' : 'Store pickup',
            'tracking' => $order->delivery_tracking_number ?: $order->lalamove_order_id ?: ($order->lalamove_status ?: 'Not booked yet'),
            'deliveryStatus' => $order->lalamove_status ?: ($isLalamove ? 'Pending booking' : 'Store pickup'),
            'subtotal' => 'PHP '.number_format($subtotal, 2),
            'shippingFee' => 'PHP '.number_format((float) $order->delivery_fee, 2),
            'modalTotal' => 'PHP '.number_format((float) $order->total_price, 2),
            'notes' => $order->delivery_notes ?: 'No special instructions.',
            'items' => $order->items->map(fn ($item) => [
                'name' => $item->service_name ?: 'Print item',
                'desc' => $item->variation_label ?: 'Custom print service',
                'image' => $itemImage($item),
                'qty' => (int) $item->quantity,
                'unit' => 'PHP '.number_format((float) $item->unit_price, 2),
                'total' => 'PHP '.number_format((float) $item->subtotal, 2),
            ])->values(),
            'timeline' => collect([
                ['title' => 'Order Placed', 'date' => optional($order->created_at)->format('M j, Y h:i A') ?? '', 'done' => true],
                ['title' => $order->status ?: 'Pending', 'date' => optional($order->updated_at)->format('M j, Y h:i A') ?? '', 'done' => $status === 'Completed'],
                ...($isLalamove ? [[
                    'title' => 'Lalamove: '.($order->lalamove_status ?: 'Pending booking'),
                    'date' => optional($order->lalamove_last_synced_at)->format('M j, Y h:i A') ?? 'Not synced yet',
                    'done' => !in_array($order->lalamove_status, [null, 'BOOKING_FAILED'], true),
                ]] : []),
            ]),
        ];
    })->values();

    $adminMetricCards = [
        ['key' => 'total', 'label' => 'TOTAL ORDERS', 'value' => (string) $orderTotal, 'caption' => 'All recorded orders', 'icon' => 'shopping-cart', 'iconClass' => 'blue-soft', 'dotClass' => 'blue-dot', 'tab' => 'all'],
        ['key' => 'pending', 'label' => 'PENDING', 'value' => (string) $orderCounts['Pending'], 'caption' => 'Awaiting action', 'icon' => 'clock', 'iconClass' => 'orange-soft', 'dotClass' => 'orange-dot', 'tab' => 'Pending'],
        ['key' => 'processing', 'label' => 'PROCESSING', 'value' => (string) $orderCounts['Processing'], 'caption' => 'In progress', 'icon' => 'settings', 'iconClass' => 'cyan-soft', 'dotClass' => 'blue-dot', 'tab' => 'Processing'],
        ['key' => 'completed', 'label' => 'COMPLETED', 'value' => (string) $orderCounts['Completed'], 'caption' => 'Successfully completed', 'icon' => 'circle-check', 'iconClass' => 'green-soft', 'dotClass' => 'green-dot', 'tab' => 'Completed'],
        ['key' => 'cancelled', 'label' => 'CANCELLED', 'value' => (string) $orderCounts['Cancelled'], 'caption' => 'Cancelled orders', 'icon' => 'circle-x', 'iconClass' => 'red-soft', 'dotClass' => 'red-dot', 'tab' => 'Cancelled'],
    ];
    $adminOrderTabs = [
        ['key' => 'all', 'label' => 'All Orders', 'count' => $orderTotal],
        ['key' => 'Pending', 'label' => 'Pending', 'count' => $orderCounts['Pending']],
        ['key' => 'Processing', 'label' => 'Processing', 'count' => $orderCounts['Processing']],
        ['key' => 'Completed', 'label' => 'Completed', 'count' => $orderCounts['Completed']],
        ['key' => 'Cancelled', 'label' => 'Cancelled', 'count' => $orderCounts['Cancelled']],
    ];
    $adminStatusBreakdown = [
        ['label' => 'Completed', 'value' => $percentage($orderCounts['Completed']), 'dot' => 'green-dot'],
        ['label' => 'Processing', 'value' => $percentage($orderCounts['Processing']), 'dot' => 'blue-dot'],
        ['label' => 'Pending', 'value' => $percentage($orderCounts['Pending']), 'dot' => 'yellow-dot'],
        ['label' => 'Cancelled', 'value' => $percentage($orderCounts['Cancelled']), 'dot' => 'red-dot'],
    ];
    $adminFulfillmentBreakdown = [
        ['label' => 'Lalamove Delivery', 'value' => $percentage($lalamoveCount), 'dot' => 'orange-dot'],
        ['label' => 'Store Pickup', 'value' => $percentage($pickupCount), 'dot' => 'blue-dot'],
    ];
    $adminOrderSummary = [
        ['label' => "Today's Orders", 'value' => $portalOrders->where('created_at', '>=', now()->startOfDay())->count(), 'icon' => 'calendar-days', 'color' => 'blue-soft'],
        ['label' => 'Awaiting Action', 'value' => $orderCounts['Pending'], 'icon' => 'wallet', 'color' => 'orange-soft'],
        ['label' => 'Ready for Pickup', 'value' => $portalOrders->filter(fn ($order) => $normalizeOrderStatus($order->status) === 'Ready for Pickup')->count(), 'icon' => 'shopping-bag', 'color' => 'purple-soft'],
        ['label' => 'For Delivery', 'value' => $lalamoveCount, 'icon' => 'truck', 'color' => 'green-soft'],
    ];
@endphp

<!-- FINAL ORDERS OVERVIEW UI - Alpine.js Admin Portal Section -->
<!-- Required: Alpine.js must be loaded once in your layout. Example: <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

<div x-data="ordersOverviewApp()" x-init="init()" class="orders-admin-shell">
    <div x-show="toast.show" x-transition class="admin-feedback-toast" x-text="toast.message" style="display:none"></div>

    <section class="admin-page-head admin-title-line">
        <div>
            <h1>Orders Overview</h1>
            <p>Manage customer orders, fulfillment, payments, and delivery activity.</p>
        </div>
        <div class="admin-head-actions">
            <button type="button" class="admin-date-control" @click="calendarOpen = true; refreshIcons()">
                <i data-lucide="calendar-days"></i>
                <span x-text="dateRangeLabel"></span>
                <i data-lucide="chevron-down"></i>
            </button>
            <button class="admin-btn admin-btn-outline" @click="exportOrders()">
                <i data-lucide="upload"></i>
                <span>Export</span>
            </button>
            <button class="admin-btn admin-btn-primary" @click="createOrder()">
                <i data-lucide="plus"></i>
                <span>Create Order</span>
            </button>
        </div>
    </section>

    <div x-show="calendarOpen" x-transition.opacity class="orders-calendar-overlay" style="display:none" @click.self="calendarOpen = false">
        <section class="orders-calendar-modal" x-transition.scale.origin.top>
            <div class="orders-calendar-main">
                <header class="orders-calendar-top">
                    <div>
                        <h2 class="orders-calendar-title" x-text="calendarMonthLabel"></h2>
                        <p class="orders-calendar-subtitle">Select a date or save an order reminder for this orders overview.</p>
                    </div>
                    <div class="orders-calendar-nav">
                        <button type="button" class="orders-calendar-icon-btn" @click="showToast('Previous month ready')"><i data-lucide="chevron-left"></i></button>
                        <button type="button" class="orders-calendar-action-btn" @click="dateRangeLabel = 'June 08, 2026'; selectedCalendarDate = 'June 08, 2026'; calendarOpen = false; showToast('Date updated')">Today</button>
                        <button type="button" class="orders-calendar-icon-btn" @click="showToast('Next month ready')"><i data-lucide="chevron-right"></i></button>
                        <button type="button" class="orders-calendar-icon-btn" @click="calendarOpen = false"><i data-lucide="x"></i></button>
                    </div>
                </header>
                <div class="orders-calendar-weekdays"><span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span></div>
                <div class="orders-calendar-grid">
                    <template x-for="day in calendarDays" :key="day.key">
                        <button type="button" class="orders-calendar-day" :class="{'is-muted': day.muted, 'is-today': day.today, 'is-selected': selectedCalendarDate === day.label}" @click="chooseCalendarDate(day)">
                            <span class="orders-calendar-day-number" x-text="day.number"></span>
                            <span class="orders-calendar-day-events">
                                <template x-for="event in eventsForDay(day.label).slice(0,3)" :key="event.id">
                                    <b class="orders-calendar-event-dot"></b>
                                </template>
                                <em class="orders-calendar-more" x-show="eventsForDay(day.label).length > 3" x-text="'+' + (eventsForDay(day.label).length - 3)"></em>
                            </span>
                        </button>
                    </template>
                </div>
            </div>
            <aside class="orders-calendar-side">
                <h3 class="orders-calendar-selected-date" x-text="selectedCalendarDate"></h3>
                <div class="orders-calendar-event-list">
                    <template x-if="eventsForDay(selectedCalendarDate).length === 0">
                        <div class="orders-calendar-empty">No saved order reminders for this date.</div>
                    </template>
                    <template x-for="event in eventsForDay(selectedCalendarDate)" :key="event.id">
                        <article class="orders-calendar-event-item">
                            <div class="orders-calendar-event-title" x-text="event.title"></div>
                            <div class="orders-calendar-event-meta" x-text="event.meta"></div>
                            <p class="orders-calendar-event-note" x-text="event.note"></p>
                            <div class="orders-calendar-event-actions">
                                <button type="button" class="orders-calendar-mini-btn" @click="showToast('Reminder opened')">Open</button>
                                <button type="button" class="orders-calendar-mini-btn danger" @click="removeCalendarEvent(event.id)">Remove</button>
                            </div>
                        </article>
                    </template>
                </div>
                <div class="orders-calendar-form">
                    <label class="orders-calendar-field"><span>Title</span><input x-model="newCalendarEvent.title" placeholder="Order follow-up"></label>
                    <label class="orders-calendar-field"><span>Time / Meta</span><input x-model="newCalendarEvent.meta" placeholder="10:00 AM"></label>
                    <label class="orders-calendar-field"><span>Notes</span><textarea x-model="newCalendarEvent.note" placeholder="Reminder details..."></textarea></label>
                    <div class="orders-calendar-form-actions">
                        <button type="button" class="orders-calendar-clear-btn" @click="newCalendarEvent = {title:'', meta:'', note:''}">Clear</button>
                        <button type="button" class="orders-calendar-save-btn" @click="addCalendarEvent()"><i data-lucide="save"></i><span>Save</span></button>
                    </div>
                </div>
            </aside>
        </section>
    </div>

    <section class="metric-grid">
        <template x-for="card in metricCards" :key="card.key">
            <button class="metric-card clickable-main-box" @click="setTab(card.tab)">
                <div class="metric-icon" :class="card.iconClass">
                    <i :data-lucide="card.icon"></i>
                </div>
                <div class="metric-copy">
                    <h3 x-text="card.label"></h3>
                    <strong x-text="card.value"></strong>
                    <p><span class="dot" :class="card.dotClass"></span><span x-text="card.caption"></span></p>
                </div>
            </button>
        </template>
    </section>

    <section class="analytics-grid">
        <article class="admin-main-box performance-card">
            <div class="card-top-row">
                <h2>Order Performance</h2>
                <span class="live-pill"><span></span> LIVE</span>
            </div>
            <p class="card-kicker">Total Revenue</p>
            <div class="revenue-row">
                <strong>PHP {{ number_format((float) $portalOrders->sum('total_price'), 2) }}</strong>
                <div class="growth-text"><i data-lucide="database"></i> Live<small>from recorded orders</small></div>
            </div>
            <div class="line-chart-wrap">
                <svg viewBox="0 0 520 160" preserveAspectRatio="none" aria-label="Order performance chart">
                    <defs>
                        <linearGradient id="lineFadeBlue" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="#0b63f6" stop-opacity="0.16"/>
                            <stop offset="100%" stop-color="#0b63f6" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <g class="grid-lines">
                        <line x1="0" x2="520" y1="25" y2="25"/><line x1="0" x2="520" y1="60" y2="60"/>
                        <line x1="0" x2="520" y1="95" y2="95"/><line x1="0" x2="520" y1="130" y2="130"/>
                    </g>
                    <path d="M0 125 C45 105,65 98,105 101 C145 104,155 88,190 55 C225 22,245 50,275 80 C305 110,335 95,360 78 C390 55,410 95,440 100 C470 104,485 42,520 33 L520 160 L0 160 Z" fill="url(#lineFadeBlue)"></path>
                    <path d="M0 125 C45 105,65 98,105 101 C145 104,155 88,190 55 C225 22,245 50,275 80 C305 110,335 95,360 78 C390 55,410 95,440 100 C470 104,485 42,520 33" class="performance-line"></path>
                    <circle cx="520" cy="33" r="5" class="line-point"></circle>
                </svg>
                <div class="chart-y-axis"><span>40K</span><span>30K</span><span>20K</span><span>10K</span><span>0</span></div>
                <div class="chart-x-axis"><span>May 31</span><span>Jun 1</span><span>Jun 2</span><span>Jun 3</span><span>Jun 4</span><span>Jun 5</span><span>Jun 6</span></div>
            </div>
        </article>

        <article class="admin-main-box donut-card">
            <h2>Order Status Breakdown</h2>
            <div class="donut-content">
                <div class="donut donut-status"><div><strong>{{ $orderTotal }}</strong><span>Orders</span></div></div>
                <div class="legend-list">
                    <template x-for="row in statusBreakdown" :key="row.label">
                        <div class="legend-row"><span><b class="dot" :class="row.dot"></b><span x-text="row.label"></span></span><strong x-text="row.value"></strong></div>
                    </template>
                </div>
            </div>
        </article>

        <article class="admin-main-box donut-card">
            <h2>Fulfillment Overview</h2>
            <div class="donut-content">
                <div class="donut donut-fulfillment"><div><strong>{{ $orderTotal }}</strong><span>Orders</span></div></div>
                <div class="legend-list">
                    <template x-for="row in fulfillmentBreakdown" :key="row.label">
                        <div class="legend-row"><span><b class="dot" :class="row.dot"></b><span x-text="row.label"></span></span><strong x-text="row.value"></strong></div>
                    </template>
                </div>
            </div>
        </article>
    </section>

    <section class="tab-search-row">
        <div class="status-tabs">
            <template x-for="tab in tabs" :key="tab.key">
                <button class="tab-btn" :class="activeTab === tab.key ? 'active' : ''" @click="setTab(tab.key)">
                    <span x-text="tab.label"></span><b x-text="tab.count"></b>
                </button>
            </template>
        </div>
        <div class="search-filter-actions">
            <label class="search-box"><i data-lucide="search"></i><input x-model="search" @input="page = 1" placeholder="Search orders, customer, or service..."></label>
            <button class="admin-btn admin-btn-outline filter-btn" @click="showFilters = !showFilters"><i data-lucide="funnel"></i><span>Filters</span><i data-lucide="chevron-down"></i></button>
        </div>
    </section>

    <section class="filter-row" x-show="showFilters" x-transition>
        <label class="filter-control"><span>Date Range</span><i data-lucide="calendar"></i><select x-model="dateFilter" @change="page=1"><option value="all">All Dates</option><option value="today">Today</option><option value="yesterday">Yesterday</option></select></label>
        <label class="filter-control"><span>Status</span><select x-model="statusFilter" @change="page=1"><option value="all">All Statuses</option><option>Pending</option><option>Processing</option><option>Completed</option><option>Cancelled</option><option>Shipped</option><option>Ready for Pickup</option></select></label>
        <label class="filter-control"><span>Payment Method</span><select x-model="paymentFilter" @change="page=1"><option value="all">All Payments</option><option>Cash on Delivery</option><option>Paid</option><option>Partial</option><option>Unpaid</option></select></label>
        <label class="filter-control"><span>Fulfillment Type</span><select x-model="fulfillmentFilter" @change="page=1"><option value="all">All Types</option><option>Pickup</option><option>Lalamove</option></select></label>
    </section>

    <section class="orders-layout-grid">
        <article class="admin-main-box table-card">
            <div class="table-responsive">
                <table class="orders-table">
                    <thead><tr><th>Order ID</th><th>Customer</th><th>Service / Items</th><th>Date</th><th>Payment</th><th>Status</th><th>Total</th><th>Actions</th></tr></thead>
                    <tbody>
                        <template x-for="order in paginatedOrders" :key="order.id">
                            <tr :class="selectedOrder && selectedOrder.id === order.id ? 'selected-row' : ''">
                                <td><button class="order-link" @click="openOrder(order)" x-text="order.id"></button></td>
                                <td x-text="order.customer"></td>
                                <td><span class="item-name-with-img"><template x-if="order.image"><img :src="order.image" :alt="order.service"></template><span class="template-img" x-show="!order.image"></span><span x-text="order.service"></span></span></td>
                                <td x-text="order.date"></td>
                                <td><span class="pill" :class="paymentClass(order.payment)" x-text="order.payment"></span></td>
                                <td><span class="pill" :class="statusClass(order.status)" x-text="order.status"></span></td>
                                <td class="total-cell" x-text="order.total"></td>
                                <td>
                                    <div class="mini-action-row">
                                        <button @click="openOrder(order)" title="View"><i data-lucide="eye"></i></button>
                                        <button @click="editOrder(order)" title="Edit"><i data-lucide="pencil"></i></button>
                                        <button @click="printInvoice(order)" title="Print"><i data-lucide="printer"></i></button>
                                        <button @click="showToast('More actions opened for ' + order.id)" title="More"><i data-lucide="more-vertical"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <span>Showing <b x-text="rangeStart"></b> to <b x-text="rangeEnd"></b> of <b x-text="filteredOrders.length"></b> orders</span>
                <div class="pagination-row">
                    <button @click="prevPage()"><i data-lucide="chevron-left"></i></button>
                    <template x-for="p in visiblePages" :key="p"><button :class="page === p ? 'active' : ''" @click="page = p" x-text="p"></button></template>
                    <button @click="nextPage()"><i data-lucide="chevron-right"></i></button>
                </div>
            </div>
        </article>

        <aside class="side-stack">
            <article class="side-card order-summary-card">
                <h2>Order Summary</h2>
                <template x-for="item in orderSummary" :key="item.label">
                    <button class="summary-row clickable-main-box" @click="showToast(item.label + ' opened')">
                        <span class="summary-icon" :class="item.color"><i :data-lucide="item.icon"></i></span>
                        <span x-text="item.label"></span>
                        <strong x-text="item.value"></strong>
                    </button>
                </template>
            </article>
            <article class="side-card quick-actions-card">
                <h2>Quick Actions</h2>
                <button class="admin-btn admin-btn-outline full-btn" @click="printInvoice(selectedOrder || orders[0])"><i data-lucide="printer"></i><span>Print Invoice</span></button>
                <button class="admin-btn admin-btn-outline full-btn" @click="markSelectedComplete()"><i data-lucide="check-circle"></i><span>Mark as Completed</span></button>
                <button class="admin-btn admin-btn-outline full-btn" @click="assignDelivery()"><i data-lucide="truck"></i><span>Assign Delivery</span></button>
                <button class="admin-btn admin-btn-primary full-btn" @click="createOrder()"><i data-lucide="plus"></i><span>Create New Order</span></button>
            </article>
        </aside>
    </section>

    <div x-show="modalOpen" x-transition.opacity class="order-modal-overlay" style="display:none" @click.self="closeModal()">
        <div class="order-details-modal" x-transition.scale.origin.center>
            <header class="modal-title-row">
                <div class="modal-heading-inline"><h2>Order Details</h2><span></span><b x-text="selectedOrder?.id"></b></div>
                <button class="modal-close" @click="closeModal()"><i data-lucide="x"></i></button>
            </header>

            <div class="modal-grid-three template-exact-grid">
                <article class="modal-mini-card template-customer-card">
                    <h3>Customer</h3>
                    <div class="customer-flex">
                        <div class="template-avatar"><i data-lucide="user"></i></div>
                        <div>
                            <strong x-text="selectedOrder?.customer"></strong>
                            <small x-text="selectedOrder?.email"></small>
                            <small x-text="selectedOrder?.phone"></small>
                        </div>
                    </div>
                    <span class="customer-id" x-text="selectedOrder?.customerId"></span>
                </article>

                <article class="modal-mini-card">
                    <h3>Shipping Address</h3>
                    <p class="address-text"><i data-lucide="map-pin"></i><span x-text="selectedOrder?.address"></span></p>
                </article>

                <article class="modal-mini-card">
                    <h3>Payment Method</h3>
                    <p class="card-brand"><i data-lucide="wallet-cards"></i><b x-text="selectedOrder?.payment"></b></p>
                    <small class="template-muted" x-text="selectedOrder?.rawStatus"></small>
                    <span class="pill template-pill" :class="paymentClass(selectedOrder?.payment)" x-text="selectedOrder?.payment"></span>
                </article>
            </div>

            <section class="modal-status-strip template-status-strip">
                <div><span>Order Status</span><b x-text="selectedOrder?.status"></b></div>
                <div><span>Order Date</span><b><i data-lucide="calendar-days"></i><em x-text="selectedOrder?.orderDateTime"></em></b></div>
                <div><span>Fulfillment Type</span><b><i data-lucide="package"></i><em x-text="selectedOrder?.fulfillmentType"></em></b></div>
                <div><span>Delivery Status</span><b><i data-lucide="truck"></i><em x-text="selectedOrder?.deliveryStatus"></em></b></div>
                <div><span>Tracking Number</span><b x-text="selectedOrder?.tracking"></b></div>
            </section>

            <article class="modal-items-card template-items-card">
                <h3>Ordered Items</h3>
                <table>
                    <thead><tr><th>Item</th><th>Description</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead>
                    <tbody>
                        <template x-for="item in selectedOrder?.items || []" :key="item.name + item.qty">
                            <tr><td><span class="item-name-with-img"><template x-if="item.image"><img :src="item.image" :alt="item.name"></template><span class="template-img" x-show="!item.image"></span><span x-text="item.name"></span></span></td><td x-text="item.desc"></td><td x-text="item.qty"></td><td x-text="item.unit"></td><td x-text="item.total"></td></tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr><td colspan="4">Subtotal</td><td x-text="selectedOrder?.subtotal"></td></tr>
                        <tr><td colspan="4">Delivery Fee</td><td x-text="selectedOrder?.shippingFee"></td></tr>
                        <tr class="modal-total-row"><td colspan="4">Total</td><td x-text="selectedOrder?.modalTotal"></td></tr>
                    </tfoot>
                </table>
            </article>

            <div class="modal-bottom-grid template-bottom-grid">
                <article class="modal-mini-card">
                    <h3>Notes / Special Instructions</h3>
                    <p x-text="selectedOrder?.notes"></p>
                </article>
                <article class="modal-mini-card timeline-card">
                    <h3>Order Timeline</h3>
                    <template x-for="entry in selectedOrder?.timeline || []" :key="entry.title + entry.date">
                        <div class="timeline-row" :class="entry.done ? 'done' : ''"><span></span><div><b x-text="entry.title"></b><small x-text="entry.date"></small></div></div>
                    </template>
                </article>
                <article class="modal-mini-card modal-actions-card">
                    <h3>Actions</h3>
                    <button class="admin-btn admin-btn-primary" @click="showToast('Template saved')"><i data-lucide="save"></i><span>Save Template</span></button>
                    <button class="admin-btn admin-btn-outline" @click="printInvoice(selectedOrder)"><i data-lucide="printer"></i><span>Print</span></button>
                </article>
            </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
function ordersOverviewApp(){return{
    activeTab:'all', search:'', page:1, perPage:8, showFilters:true, modalOpen:false, selectedOrder:null, calendarOpen:false, calendarMonthLabel:'June 2026', dateRangeLabel:'{{ now()->subDays(6)->format('M j') }} – {{ now()->format('M j, Y') }}', selectedCalendarDate:'{{ now()->format('F d, Y') }}', dateFilter:'all', statusFilter:'all', paymentFilter:'all', fulfillmentFilter:'all', toast:{show:false,message:''},
    newCalendarEvent:{title:'', meta:'', note:''},
    calendarDays:[
        {key:'m31',number:31,label:'May 31, 2026',muted:true,today:false},{key:'j1',number:1,label:'June 01, 2026',muted:false,today:false},{key:'j2',number:2,label:'June 02, 2026',muted:false,today:false},{key:'j3',number:3,label:'June 03, 2026',muted:false,today:false},{key:'j4',number:4,label:'June 04, 2026',muted:false,today:false},{key:'j5',number:5,label:'June 05, 2026',muted:false,today:false},{key:'j6',number:6,label:'June 06, 2026',muted:false,today:false},
        {key:'j7',number:7,label:'June 07, 2026',muted:false,today:false},{key:'j8',number:8,label:'June 08, 2026',muted:false,today:true},{key:'j9',number:9,label:'June 09, 2026',muted:false,today:false},{key:'j10',number:10,label:'June 10, 2026',muted:false,today:false},{key:'j11',number:11,label:'June 11, 2026',muted:false,today:false},{key:'j12',number:12,label:'June 12, 2026',muted:false,today:false},{key:'j13',number:13,label:'June 13, 2026',muted:false,today:false},
        {key:'j14',number:14,label:'June 14, 2026',muted:false,today:false},{key:'j15',number:15,label:'June 15, 2026',muted:false,today:false},{key:'j16',number:16,label:'June 16, 2026',muted:false,today:false},{key:'j17',number:17,label:'June 17, 2026',muted:false,today:false},{key:'j18',number:18,label:'June 18, 2026',muted:false,today:false},{key:'j19',number:19,label:'June 19, 2026',muted:false,today:false},{key:'j20',number:20,label:'June 20, 2026',muted:false,today:false},
        {key:'j21',number:21,label:'June 21, 2026',muted:false,today:false},{key:'j22',number:22,label:'June 22, 2026',muted:false,today:false},{key:'j23',number:23,label:'June 23, 2026',muted:false,today:false},{key:'j24',number:24,label:'June 24, 2026',muted:false,today:false},{key:'j25',number:25,label:'June 25, 2026',muted:false,today:false},{key:'j26',number:26,label:'June 26, 2026',muted:false,today:false},{key:'j27',number:27,label:'June 27, 2026',muted:false,today:false},
        {key:'j28',number:28,label:'June 28, 2026',muted:false,today:false},{key:'j29',number:29,label:'June 29, 2026',muted:false,today:false},{key:'j30',number:30,label:'June 30, 2026',muted:false,today:false},{key:'jul1',number:1,label:'July 01, 2026',muted:true,today:false},{key:'jul2',number:2,label:'July 02, 2026',muted:true,today:false},{key:'jul3',number:3,label:'July 03, 2026',muted:true,today:false},{key:'jul4',number:4,label:'July 04, 2026',muted:true,today:false}
    ],
    calendarEvents:[
        {id:1,date:'June 06, 2026',title:'Follow up pending orders',meta:'9:00 AM',note:'Check payment and artwork approvals.'},
        {id:2,date:'June 08, 2026',title:'Delivery status review',meta:'2:00 PM',note:'Review shipped and ready-for-pickup orders.'}
    ],
    metricCards:@json($adminMetricCards),
    tabs:@json($adminOrderTabs),
    statusBreakdown:@json($adminStatusBreakdown),
    fulfillmentBreakdown:@json($adminFulfillmentBreakdown),
    orderSummary:@json($adminOrderSummary),
    orders:@json($adminOrderPayload),
    init(){this.refreshIcons();}, refreshIcons(){this.$nextTick(()=>{if(window.lucide) window.lucide.createIcons();});},
    get filteredOrders(){let data=this.orders;if(this.activeTab!=='all')data=data.filter(o=>o.status===this.activeTab);if(this.statusFilter!=='all')data=data.filter(o=>o.status===this.statusFilter);if(this.paymentFilter!=='all')data=data.filter(o=>o.payment===this.paymentFilter);if(this.fulfillmentFilter!=='all')data=data.filter(o=>o.fulfillmentType===this.fulfillmentFilter);const today=new Date().toISOString().slice(0,10);const yesterday=new Date(Date.now()-86400000).toISOString().slice(0,10);if(this.dateFilter==='today')data=data.filter(o=>o.dateIso===today);if(this.dateFilter==='yesterday')data=data.filter(o=>o.dateIso===yesterday);if(this.search.trim()){const q=this.search.toLowerCase();data=data.filter(o=>[o.id,o.customer,o.service,o.status,o.rawStatus,o.payment,o.fulfillmentType,o.deliveryStatus].join(' ').toLowerCase().includes(q));}return data;},
    get paginatedOrders(){return this.filteredOrders.slice((this.page-1)*this.perPage,this.page*this.perPage);}, get totalPages(){return Math.max(1,Math.ceil(this.filteredOrders.length/this.perPage));}, get visiblePages(){return Array.from({length:this.totalPages},(_,i)=>i+1).slice(0,5);}, get rangeStart(){return this.filteredOrders.length?((this.page-1)*this.perPage)+1:0;}, get rangeEnd(){return Math.min(this.page*this.perPage,this.filteredOrders.length);},
    setTab(tab){this.activeTab=tab;this.page=1;this.refreshIcons();}, nextPage(){if(this.page<this.totalPages)this.page++;this.refreshIcons();}, prevPage(){if(this.page>1)this.page--;this.refreshIcons();},
    statusClass(status){return {'Completed':'pill-completed','Processing':'pill-processing','Pending':'pill-pending','Cancelled':'pill-cancelled','Shipped':'pill-shipped','Ready for Pickup':'pill-ready'}[status]||'pill-processing';}, paymentClass(payment){return {'Paid':'pill-paid','Partial':'pill-partial','Unpaid':'pill-unpaid','Cash on Delivery':'pill-pending'}[payment]||'pill-paid';},
    openOrder(order){this.selectedOrder=JSON.parse(JSON.stringify(order));this.modalOpen=true;this.refreshIcons();}, closeModal(){this.modalOpen=false;}, editOrder(order){this.showToast('Edit mode opened for '+order.id);this.openOrder(order);},
    printInvoice(order){if(!order){this.showToast('Select an order first');return;} const w=window.open('','_blank','width=720,height=760');w.document.write(`<title>Invoice ${order.id}</title><style>body{font-family:Inter,Arial,sans-serif;padding:32px;color:#050816}h1{font-family:Playfair Display,serif}.row{display:flex;justify-content:space-between;border-bottom:1px solid #ddd;padding:10px 0}.total{font-weight:800;color:#0b63f6;font-size:20px}

/* FINAL UI FIXES: fewer boxes, tighter sizes, working-control styling */
:root{--admin-blue:#0b63f6;--admin-blue-2:#084fd1;--admin-black:#050816;--admin-border:#050816;--box-hover:rgba(33,37,41,.12)}
.orders-admin-shell{max-width:1440px;padding:22px 24px 26px;letter-spacing:.01em}.admin-page-head{margin-bottom:16px}.admin-title-line{padding-top:12px}.admin-title-line:before{top:0;width:68px;height:4px;border-radius:999px;background:linear-gradient(90deg,var(--admin-blue),#4a90ff)}.admin-page-head h1{font-size:36px;line-height:1.05}.admin-page-head p{font-size:14px;margin-top:7px}.admin-head-actions{gap:12px}.admin-btn,.admin-date-control,.tab-btn,.filter-control,.full-btn{height:40px;min-height:40px;border:0!important;box-shadow:none!important}.admin-btn{min-width:124px;border-radius:8px;font-weight:700}.admin-btn-primary{background:linear-gradient(135deg,#0b63f6 0%,#095be2 52%,#084ac2 100%)!important;color:#fff!important}.admin-btn-outline,.admin-date-control,.filter-btn{background:#f8fafc!important;color:var(--admin-black)!important}.admin-btn:hover,.admin-date-control:hover,.tab-btn:hover,.filter-control:hover,.mini-action-row button:hover,.pagination-row button:hover,.modal-close:hover{background:var(--admin-black)!important;color:#fff!important}.admin-main-box,.metric-card,.order-details-modal{border:1.5px solid var(--admin-border)!important;box-shadow:0 8px 18px rgba(5,8,22,.06)!important}.clickable-main-box:hover,.admin-main-box:hover{background:rgba(33,37,41,.08)!important}.metric-grid{gap:14px;margin-bottom:16px}.metric-card{min-height:92px;padding:16px 18px;border-radius:12px}.metric-icon{width:50px;height:50px;border-radius:10px}.metric-icon svg{width:27px;height:27px}.metric-copy h3{font-size:11px}.metric-copy strong{font-size:25px}.metric-copy p{font-size:12px}.analytics-grid{gap:16px;margin-bottom:16px;grid-template-columns:1fr .9fr .95fr}.performance-card,.donut-card{min-height:228px;padding:18px}.donut{width:142px;height:142px;flex-basis:142px}.donut>div{width:80px;height:80px}.donut-content{gap:20px}.legend-list{gap:13px}.status-tabs{gap:9px}.tab-btn{min-width:118px;padding:0 14px;background:#f8fafc;color:var(--admin-black);border-radius:8px}.tab-btn.active{background:linear-gradient(135deg,#0b63f6,#084ac2)!important;color:#fff!important}.tab-btn b{background:rgba(5,8,22,.07)}.search-box{height:40px;width:390px;border:0;background:#f8fafc;border-radius:8px}.filter-row{gap:10px;margin-bottom:14px}.filter-control{background:#f8fafc;border-radius:8px;padding:0 13px}.filter-control select{border:0;background:transparent;outline:0;font-family:'Inter';font-weight:700;color:var(--admin-black);max-width:150px}.orders-layout-grid{grid-template-columns:minmax(0,1fr) 300px;gap:15px}.orders-table th{height:48px;padding:0 15px}.orders-table td{height:45px;padding:0 15px}.mini-action-row{gap:5px}.mini-action-row button,.pagination-row button,.modal-close{border:0!important;background:transparent;width:30px;height:30px;border-radius:8px}.table-footer{height:62px}.side-card{padding:17px}.summary-row{min-height:55px;border-bottom:1px solid #eef2f7}.summary-icon{width:36px;height:36px}.summary-row strong{font-size:20px}.quick-actions-card{gap:8px}.full-btn{height:40px}.order-details-modal{width:min(790px,95vw);border-radius:13px}.modal-title-row{height:56px}.modal-grid-three{padding:16px 20px 10px;gap:10px}.modal-mini-card,.modal-items-card{border:0!important;background:#fbfcfe;border-radius:10px;padding:13px}.modal-status-strip{border:0!important;background:#fbfcfe;margin:0 20px 10px}.modal-status-strip>div{border-right:1px solid #e8edf5}.modal-items-card{margin:0 20px 12px}.modal-bottom-grid{padding:0 20px 20px;gap:10px}.admin-feedback-toast{background:linear-gradient(135deg,#0b63f6,#084ac2);border:0;color:#fff;box-shadow:0 14px 32px rgba(11,99,246,.28)}
@media(max-width:1200px){.analytics-grid{grid-template-columns:1fr}.orders-layout-grid{grid-template-columns:1fr}.side-stack{grid-template-columns:1fr 1fr}.search-box{width:320px}}@media(max-width:760px){.orders-admin-shell{padding:16px}.metric-card{min-height:86px}.admin-page-head h1{font-size:30px}.side-stack{grid-template-columns:1fr}.search-box{width:100%}}

</style><h1>Invoice</h1><p><b>${order.id}</b></p><div class=row><span>Customer</span><b>${order.customer}</b></div><div class=row><span>Service</span><b>${order.service}</b></div><div class=row><span>Date</span><b>${order.date}</b></div><div class=row><span>Status</span><b>${order.status}</b></div><div class=row><span>Total</span><b class=total>${order.total}</b></div><script>window.print()<\/script>`);w.document.close();this.showToast('Print window opened for '+order.id);}, markSelectedComplete(){if(this.selectedOrder){this.selectedOrder.status='Completed';const found=this.orders.find(o=>o.id===this.selectedOrder.id);if(found) found.status='Completed';this.showToast(this.selectedOrder.id+' marked as completed');}else this.showToast('Select an order first');this.refreshIcons();},
    assignDelivery(){const o=this.selectedOrder||this.orders[0];o.fulfillmentType='Shipping';o.status='Shipped';this.selectedOrder=o;this.showToast('Delivery assigned to '+o.id);this.refreshIcons();}, createOrder(){const next=1032+this.orders.length;const order={...this.orders[0],id:'ORD-'+next,customer:'New Customer',service:'New Print Order',date:'Jun 6, 2026',payment:'Unpaid',status:'Pending',total:'PHP 0.00'};this.orders.unshift(order);this.selectedOrder=order;this.page=1;this.showToast(order.id+' created. You can now edit the order.');this.refreshIcons();}, contactCustomer(){if(!this.selectedOrder){this.showToast('Select an order first');return;} window.location.href='mailto:'+this.selectedOrder.email+'?subject=Update for '+this.selectedOrder.id;}, exportOrders(){const rows=[['Order ID','Customer','Service','Date','Payment','Status','Total'],...this.filteredOrders.map(o=>[o.id,o.customer,o.service,o.date,o.payment,o.status,o.total])];const csv=rows.map(r=>r.map(v=>'"'+String(v).replaceAll('"','""')+'"').join(',')).join('\n');const a=document.createElement('a');a.href=URL.createObjectURL(new Blob([csv],{type:'text/csv'}));a.download='orders-export.csv';a.click();URL.revokeObjectURL(a.href);this.showToast('Orders exported as CSV');},
    eventsForDay(dateLabel){return this.calendarEvents.filter(event=>event.date===dateLabel);},
    chooseCalendarDate(day){if(day.muted)return;this.selectedCalendarDate=day.label;this.dateRangeLabel=day.label;this.refreshIcons();},
    addCalendarEvent(){const title=(this.newCalendarEvent.title||'Order reminder').trim();const meta=(this.newCalendarEvent.meta||'Any time').trim();const note=(this.newCalendarEvent.note||'No notes added.').trim();this.calendarEvents.push({id:Date.now(),date:this.selectedCalendarDate,title,meta,note});this.newCalendarEvent={title:'',meta:'',note:''};this.showToast('Calendar reminder saved');this.refreshIcons();},
    removeCalendarEvent(id){this.calendarEvents=this.calendarEvents.filter(event=>event.id!==id);this.showToast('Calendar reminder removed');this.refreshIcons();},
    showToast(message){this.toast.message=message;this.toast.show=true;setTimeout(()=>this.toast.show=false,2400);}
}}
</script>

<style>
:root{--admin-blue:#0b63f6;--admin-black:#050816;--admin-orange:#f59e0b;--admin-border:#050816;--admin-muted:#667085;--admin-line:#e8edf5;--admin-bg:#ffffff;--admin-green:#0f9f63;--admin-red:#ef2f2f;--admin-purple:#7c3aed;--admin-radius:13px;--admin-shadow:0 5px 18px rgba(5,8,22,.06);--hover-blur:rgba(22,24,29,.72)}
.orders-admin-shell{font-family:'Inter',system-ui,sans-serif;color:var(--admin-black);background:#fff;max-width:1580px;margin:0 auto;padding:22px 24px 28px;letter-spacing:-.012em}.orders-admin-shell *{box-sizing:border-box}.orders-admin-shell button{font-family:'Inter',system-ui,sans-serif}.orders-admin-shell h1{font-family:'Playfair Display',serif;font-weight:700;font-size:38px;line-height:1.05;margin:0 0 7px}.orders-admin-shell h2,.orders-admin-shell h3,.card-title{font-family:'Poppins',sans-serif;font-weight:600}.orders-admin-shell p{font-family:'Inter',sans-serif;font-weight:400}.admin-title-line{position:relative;padding-left:12px}.admin-title-line:before{content:"";position:absolute;left:0;top:2px;width:4px;height:46px;background:var(--admin-blue);border-radius:10px}.admin-page-head{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:22px}.admin-page-head p{font-size:14px;color:#344054;margin:0}.admin-head-actions{display:flex;gap:14px;align-items:center}.admin-btn,.admin-date-control{height:48px;min-width:116px;padding:0 18px;border:0;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;gap:10px;font-size:14px;font-weight:700;cursor:pointer;transition:.18s ease;white-space:nowrap}.admin-btn svg,.admin-date-control svg{width:18px;height:18px;stroke-width:2.1}.admin-btn-primary{background:var(--admin-blue);color:#050816}.admin-btn-outline,.admin-date-control{background:#fff;color:#050816;box-shadow:inset 0 0 0 1.5px #050816}.admin-btn:hover,.admin-date-control:hover{background:#050816!important;color:#fff!important;box-shadow:none;transform:translateY(-1px)}.admin-date-control{min-width:250px}.admin-feedback-toast{position:fixed;top:24px;left:50%;transform:translateX(-50%);z-index:6000;background:#050816;color:#fff;border-radius:999px;padding:13px 24px;font-size:14px;font-weight:700;box-shadow:0 16px 50px rgba(5,8,22,.22);text-align:center}.admin-main-box,.metric-card{background:#fff;border:1.8px solid var(--admin-border);border-radius:var(--admin-radius);box-shadow:var(--admin-shadow)}.clickable-main-box{position:relative;overflow:hidden}.clickable-main-box:after{content:"";position:absolute;inset:0;background:var(--hover-blur);opacity:0;backdrop-filter:blur(2px);transition:.16s}.clickable-main-box:hover:after{opacity:.10}.metric-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:18px}.metric-card{min-height:116px;padding:20px;border-color:#d8dee8;text-align:left;display:flex;align-items:center;gap:20px;cursor:pointer}.metric-icon,.summary-icon{width:68px;height:68px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex:0 0 auto}.metric-icon svg{width:36px;height:36px}.blue-soft{background:#eaf1ff;color:#0b63f6}.cyan-soft{background:#e8f8ff;color:#0b85c8}.orange-soft{background:#fff5df;color:var(--admin-orange)}.green-soft{background:#e4f8ee;color:#0f9f63}.red-soft{background:#ffe9e9;color:#ef2f2f}.purple-soft{background:#f0e8ff;color:#7c3aed}.metric-copy h3{font-size:12px;color:#344054;margin:0 0 6px;text-transform:uppercase;letter-spacing:.012em}.metric-copy strong{display:block;font-size:28px;line-height:1;font-weight:800;margin-bottom:10px}.metric-copy p{font-size:13px;color:#475467;display:flex;align-items:center;gap:9px;margin:0}.dot{width:10px;height:10px;border-radius:50%;display:inline-block;flex:0 0 auto}.blue-dot{background:#0b63f6}.orange-dot,.yellow-dot{background:var(--admin-orange)}.green-dot{background:#0f9f63}.red-dot{background:#ef2f2f}.purple-dot{background:#7c3aed}.analytics-grid{display:grid;grid-template-columns:1.08fr .92fr 1.05fr;gap:16px;margin-bottom:20px}.analytics-grid article{min-height:270px;padding:22px}.analytics-grid h2,.side-card h2{font-size:16px;margin:0 0 16px}.card-top-row{display:flex;align-items:center;justify-content:space-between}.live-pill{font-size:12px;color:#0f9f63;font-weight:800}.live-pill span{display:inline-block;width:7px;height:7px;background:#0f9f63;border-radius:50%;margin-right:5px}.card-kicker{font-size:13px;color:#344054;margin:0 0 6px}.revenue-row{display:flex;justify-content:space-between;align-items:flex-start}.revenue-row>strong{font-size:23px;font-weight:800}.growth-text{color:#0f9f63;font-weight:800;display:flex;flex-direction:column;align-items:flex-start;gap:0}.growth-text svg{width:14px;display:inline}.growth-text small{font-size:12px;color:#475467;font-weight:500}.line-chart-wrap{position:relative;height:166px;padding-left:40px;margin-top:8px}.line-chart-wrap svg{width:100%;height:132px;overflow:visible}.grid-lines line{stroke:#e5e9f1;stroke-width:1}.performance-line{fill:none;stroke:#0b63f6;stroke-width:5;stroke-linecap:round}.line-point{fill:#0b63f6;stroke:#fff;stroke-width:3}.chart-y-axis{position:absolute;left:0;top:0;height:130px;display:flex;flex-direction:column;justify-content:space-between;font-size:11px;color:#667085}.chart-x-axis{display:flex;justify-content:space-between;font-size:12px;color:#344054;padding-top:3px}.donut-content{display:flex;align-items:center;gap:30px}.donut{width:170px;height:170px;border-radius:50%;display:grid;place-items:center;flex:0 0 170px}.donut:before{content:"";position:absolute}.donut>div{width:96px;height:96px;background:white;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;box-shadow:inset 0 0 0 1px #eef2f7;z-index:1}.donut{position:relative}.donut strong{font-size:24px}.donut span{font-size:12px;color:#475467}.donut-status{background:conic-gradient(#0f9f63 0 57.3%,#0b63f6 57.3% 79.1%,#f59e0b 79.1% 93.6%,#ef2f2f 93.6% 100%)}.donut-fulfillment{background:conic-gradient(#0b63f6 0 32.3%,#7c3aed 32.3% 60.9%,#f97316 60.9% 81.9%,#0f9f63 81.9% 100%)}.legend-list{flex:1;display:flex;flex-direction:column;gap:17px}.legend-row{display:flex;justify-content:space-between;gap:14px;font-size:14px;color:#344054}.legend-row span{display:flex;align-items:center;gap:9px}.legend-row strong{font-weight:700}.tab-search-row{display:flex;align-items:center;justify-content:space-between;gap:18px;margin-bottom:16px}.status-tabs{display:flex;gap:12px;flex-wrap:wrap}.tab-btn{height:43px;min-width:132px;padding:0 18px;border:1.5px solid #b6bfcc;background:#fff;border-radius:7px;color:#050816;font-size:14px;font-weight:800;display:flex;align-items:center;justify-content:center;gap:12px;cursor:pointer}.tab-btn b{background:#f1f5f9;color:#050816;border-radius:6px;padding:3px 8px}.tab-btn.active{background:var(--admin-blue);color:#fff;border-color:var(--admin-blue)}.tab-btn.active b{background:rgba(255,255,255,.18);color:#fff}.tab-btn:hover{background:#050816;color:#fff;border-color:#050816}.search-filter-actions{display:flex;gap:14px;align-items:center}.search-box{width:420px;height:43px;border:1.5px solid #b6bfcc;border-radius:7px;display:flex;align-items:center;gap:12px;padding:0 16px;background:#fff;color:#667085}.search-box svg{width:19px;height:19px}.search-box input{border:0;outline:0;width:100%;font-size:14px;font-family:'Inter';color:#050816}.filter-btn{height:43px;min-width:145px}.filter-row{display:flex;gap:14px;margin-bottom:16px}.filter-control{height:43px;padding:0 16px;border:1.5px solid #b6bfcc;border-radius:7px;background:#fff;display:flex;align-items:center;gap:13px;font-size:13px;font-weight:700;color:#050816}.filter-control span{font-weight:800}.filter-control strong{font-weight:600}.filter-control svg{width:16px}.orders-layout-grid{display:grid;grid-template-columns:minmax(0,1fr) 315px;gap:17px;align-items:start}.table-card{overflow:hidden}.table-responsive{overflow-x:auto}.orders-table{width:100%;border-collapse:collapse;min-width:950px}.orders-table th{height:58px;text-align:left;background:#fbfcfe;border-bottom:1.5px solid #dbe2ec;padding:0 18px;font-size:12px;font-weight:800;text-transform:uppercase;color:#344054}.orders-table td{height:49px;border-bottom:1px solid #dbe2ec;padding:0 18px;font-size:13px;color:#050816;vertical-align:middle}.orders-table tr.selected-row{background:#edf4ff}.order-link{background:transparent;border:0;color:#0b63f6;font-weight:800;font-size:13px;cursor:pointer}.order-link:hover{text-decoration:underline}.pill{display:inline-flex;align-items:center;justify-content:center;min-height:24px;padding:4px 12px;border-radius:6px;font-size:12px;font-weight:800}.pill-paid,.pill-completed{background:#dff8ec;color:#0f7a4f}.pill-partial,.pill-pending{background:#fff0d4;color:#c26c00}.pill-unpaid,.pill-cancelled{background:#ffe2e2;color:#dc2626}.pill-processing{background:#dbeafe;color:#0b63f6}.pill-shipped{background:#ede7ff;color:#5b21b6}.pill-ready{background:#d8f5fb;color:#087786}.total-cell{font-weight:800}.mini-action-row{display:flex;gap:8px}.mini-action-row button{width:31px;height:31px;border:1.5px solid #aeb8c8;background:#fff;border-radius:6px;display:grid;place-items:center;color:#050816;cursor:pointer}.mini-action-row svg{width:16px;height:16px}.mini-action-row button:hover{background:#050816;color:#fff;border-color:#050816}.table-footer{height:75px;display:flex;align-items:center;justify-content:space-between;padding:0 18px;font-size:13px;color:#475467}.pagination-row{display:flex;align-items:center;gap:10px}.pagination-row button{width:36px;height:36px;border:1.5px solid #b6bfcc;border-radius:7px;background:#fff;color:#050816;font-weight:800;cursor:pointer}.pagination-row button.active,.pagination-row button:hover{background:#0b63f6;color:#fff;border-color:#0b63f6}.pagination-row svg{width:15px}.side-stack{display:flex;flex-direction:column;gap:15px}.side-card{padding:21px}.summary-row{width:100%;border:0;background:#fff;min-height:67px;border-bottom:1px solid #dbe2ec;display:grid;grid-template-columns:47px 1fr auto;gap:12px;align-items:center;text-align:left;cursor:pointer;font-size:14px;font-weight:700;color:#344054}.summary-row:last-child{border-bottom:0}.summary-icon{width:42px;height:42px;border-radius:50%}.summary-icon svg{width:20px;height:20px}.summary-row strong{font-size:22px;color:#050816}.quick-actions-card{display:flex;flex-direction:column;gap:10px}.quick-actions-card h2{margin-bottom:2px}.full-btn{width:100%;height:42px}.order-modal-overlay{position:fixed;inset:0;background:rgba(5,8,22,.36);backdrop-filter:blur(2.5px);z-index:5000;display:flex;align-items:center;justify-content:center;padding:24px}.order-details-modal{width:min(815px,96vw);max-height:92vh;overflow:auto;background:#fff;border:1.8px solid var(--admin-border);border-radius:12px;box-shadow:0 28px 70px rgba(5,8,22,.25)}.modal-title-row{height:60px;border-bottom:1px solid #dbe2ec;padding:0 24px;display:flex;align-items:center;justify-content:space-between}.modal-heading-inline{display:flex;align-items:center;gap:12px}.modal-heading-inline h2{font-size:17px;margin:0}.modal-heading-inline span{width:5px;height:5px;background:#667085;border-radius:50%}.modal-heading-inline b{font-size:14px;color:#475467}.modal-close{width:34px;height:34px;border:0;background:#fff;border-radius:50%;cursor:pointer;color:#050816}.modal-close:hover{background:#050816;color:#fff}.modal-close svg{width:19px}.modal-grid-three{display:grid;grid-template-columns:1fr 1fr .95fr;gap:12px;padding:20px 24px 12px}.modal-mini-card{border:1.5px solid #dbe2ec;border-radius:9px;background:#fff;padding:15px}.modal-mini-card h3,.modal-items-card h3{margin:0 0 13px;font-size:12px;text-transform:none;color:#050816}.customer-flex{display:flex;align-items:center;gap:14px}.customer-flex img{width:44px;height:44px;border-radius:50%;object-fit:cover}.customer-flex strong{display:block;font-size:13px}.customer-flex small{display:block;color:#475467;font-size:12px;margin-top:3px}.customer-id{display:inline-block;margin-top:10px;background:#f5f7fb;border:1px solid #dbe2ec;border-radius:5px;padding:4px 8px;font-size:11px;color:#475467}.address-text{display:flex;gap:10px;margin:0;color:#050816;font-size:12.5px;line-height:1.65}.address-text svg{width:17px;min-width:17px;color:#0b63f6}.card-brand{display:flex;align-items:center;gap:3px;margin:0 0 6px}.card-brand b{margin-left:9px}.mc-dot{width:17px;height:17px;border-radius:50%;display:inline-block}.mc-dot.red{background:red}.mc-dot.orange{background:#ff9d00;margin-left:-6px}.modal-status-strip{margin:0 24px 12px;border:1.5px solid #dbe2ec;border-radius:9px;display:grid;grid-template-columns:1fr 1.25fr 1fr 1.12fr 1.1fr}.modal-status-strip>div{padding:14px 15px;border-right:1px solid #dbe2ec}.modal-status-strip>div:last-child{border-right:0}.modal-status-strip span{display:block;font-size:11px;color:#475467;font-weight:800;margin-bottom:7px}.modal-status-strip b{display:flex;align-items:center;gap:7px;font-size:12px;font-style:normal;color:#050816}.modal-status-strip em{font-style:normal}.modal-status-strip svg{width:15px}.modal-items-card{margin:0 24px 14px;border:1.5px solid #dbe2ec;border-radius:9px;padding:15px}.modal-items-card table{width:100%;border-collapse:collapse;font-size:12px}.modal-items-card th{height:38px;text-align:left;background:#fbfcfe;border-bottom:1px solid #dbe2ec;color:#475467;text-transform:uppercase;font-size:10px;padding:0 10px}.modal-items-card td{border-bottom:1px solid #eef2f7;padding:9px 10px;color:#050816;font-weight:600}.item-name-with-img{display:flex;align-items:center;gap:11px}.item-name-with-img img{width:30px;height:30px;object-fit:cover;border-radius:4px;border:1px solid #dbe2ec}.modal-items-card tfoot td{border-bottom:0;text-align:right}.modal-total-row td{font-size:14px;color:#0b63f6!important;font-weight:800!important}.modal-bottom-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;padding:0 24px 24px}.modal-bottom-grid p{font-size:12px;line-height:1.6;color:#050816;margin:0}.timeline-card{position:relative}.timeline-row{display:flex;gap:10px;padding-bottom:9px}.timeline-row span{width:13px;height:13px;background:#0b63f6;border-radius:50%;margin-top:2px;box-shadow:0 0 0 4px #e8f0ff}.timeline-row.done span{background:#0f9f63;box-shadow:0 0 0 4px #e4f8ee}.timeline-row b{display:block;font-size:12px}.timeline-row small{font-size:11px;color:#475467}.modal-actions-card{display:flex;flex-direction:column;gap:9px}.modal-actions-card h3{margin-bottom:2px}@media(max-width:1200px){.metric-grid{grid-template-columns:repeat(2,1fr)}.analytics-grid,.orders-layout-grid{grid-template-columns:1fr}.side-stack{display:grid;grid-template-columns:1fr 1fr}.search-box{width:340px}}@media(max-width:760px){.orders-admin-shell{padding:18px 14px}.admin-page-head,.tab-search-row,.admin-head-actions,.search-filter-actions,.filter-row{flex-direction:column;align-items:stretch}.admin-date-control,.admin-btn,.search-box{width:100%;min-width:0}.metric-grid,.analytics-grid,.side-stack,.modal-grid-three,.modal-bottom-grid,.modal-status-strip{grid-template-columns:1fr}.modal-status-strip>div{border-right:0;border-bottom:1px solid #dbe2ec}.modal-status-strip>div:last-child{border-bottom:0}.donut-content{flex-direction:column;align-items:flex-start}.table-footer{height:auto;gap:14px;flex-direction:column;padding:18px}}


/* FINAL UI FIXES: fewer boxes, tighter sizes, working-control styling */
:root{--admin-blue:#0b63f6;--admin-blue-2:#084fd1;--admin-black:#050816;--admin-border:#050816;--box-hover:rgba(33,37,41,.12)}
.orders-admin-shell{max-width:1440px;padding:22px 24px 26px;letter-spacing:.01em}.admin-page-head{margin-bottom:16px}.admin-title-line{padding-top:12px}.admin-title-line:before{top:0;width:68px;height:4px;border-radius:999px;background:linear-gradient(90deg,var(--admin-blue),#4a90ff)}.admin-page-head h1{font-size:36px;line-height:1.05}.admin-page-head p{font-size:14px;margin-top:7px}.admin-head-actions{gap:12px}.admin-btn,.admin-date-control,.tab-btn,.filter-control,.full-btn{height:40px;min-height:40px;border:0!important;box-shadow:none!important}.admin-btn{min-width:124px;border-radius:8px;font-weight:700}.admin-btn-primary{background:linear-gradient(135deg,#0b63f6 0%,#095be2 52%,#084ac2 100%)!important;color:#fff!important}.admin-btn-outline,.admin-date-control,.filter-btn{background:#f8fafc!important;color:var(--admin-black)!important}.admin-btn:hover,.admin-date-control:hover,.tab-btn:hover,.filter-control:hover,.mini-action-row button:hover,.pagination-row button:hover,.modal-close:hover{background:var(--admin-black)!important;color:#fff!important}.admin-main-box,.metric-card,.order-details-modal{border:1.5px solid var(--admin-border)!important;box-shadow:0 8px 18px rgba(5,8,22,.06)!important}.clickable-main-box:hover,.admin-main-box:hover{background:rgba(33,37,41,.08)!important}.metric-grid{gap:14px;margin-bottom:16px}.metric-card{min-height:92px;padding:16px 18px;border-radius:12px}.metric-icon{width:50px;height:50px;border-radius:10px}.metric-icon svg{width:27px;height:27px}.metric-copy h3{font-size:11px}.metric-copy strong{font-size:25px}.metric-copy p{font-size:12px}.analytics-grid{gap:16px;margin-bottom:16px;grid-template-columns:1fr .9fr .95fr}.performance-card,.donut-card{min-height:228px;padding:18px}.donut{width:142px;height:142px;flex-basis:142px}.donut>div{width:80px;height:80px}.donut-content{gap:20px}.legend-list{gap:13px}.status-tabs{gap:9px}.tab-btn{min-width:118px;padding:0 14px;background:#f8fafc;color:var(--admin-black);border-radius:8px}.tab-btn.active{background:linear-gradient(135deg,#0b63f6,#084ac2)!important;color:#fff!important}.tab-btn b{background:rgba(5,8,22,.07)}.search-box{height:40px;width:390px;border:0;background:#f8fafc;border-radius:8px}.filter-row{gap:10px;margin-bottom:14px}.filter-control{background:#f8fafc;border-radius:8px;padding:0 13px}.filter-control select{border:0;background:transparent;outline:0;font-family:'Inter';font-weight:700;color:var(--admin-black);max-width:150px}.orders-layout-grid{grid-template-columns:minmax(0,1fr) 300px;gap:15px}.orders-table th{height:48px;padding:0 15px}.orders-table td{height:45px;padding:0 15px}.mini-action-row{gap:5px}.mini-action-row button,.pagination-row button,.modal-close{border:0!important;background:transparent;width:30px;height:30px;border-radius:8px}.table-footer{height:62px}.side-card{padding:17px}.summary-row{min-height:55px;border-bottom:1px solid #eef2f7}.summary-icon{width:36px;height:36px}.summary-row strong{font-size:20px}.quick-actions-card{gap:8px}.full-btn{height:40px}.order-details-modal{width:min(790px,95vw);border-radius:13px}.modal-title-row{height:56px}.modal-grid-three{padding:16px 20px 10px;gap:10px}.modal-mini-card,.modal-items-card{border:0!important;background:#fbfcfe;border-radius:10px;padding:13px}.modal-status-strip{border:0!important;background:#fbfcfe;margin:0 20px 10px}.modal-status-strip>div{border-right:1px solid #e8edf5}.modal-items-card{margin:0 20px 12px}.modal-bottom-grid{padding:0 20px 20px;gap:10px}.admin-feedback-toast{background:linear-gradient(135deg,#0b63f6,#084ac2);border:0;color:#fff;box-shadow:0 14px 32px rgba(11,99,246,.28)}
@media(max-width:1200px){.analytics-grid{grid-template-columns:1fr}.orders-layout-grid{grid-template-columns:1fr}.side-stack{grid-template-columns:1fr 1fr}.search-box{width:320px}}@media(max-width:760px){.orders-admin-shell{padding:16px}.metric-card{min-height:86px}.admin-page-head h1{font-size:30px}.side-stack{grid-template-columns:1fr}.search-box{width:100%}}

</style>

<style id="orders-v3-final-fixes">
/* V3 FINAL FIXES - compact charts, stable hover, real bordered controls */
.orders-admin-shell{max-width:1360px!important;padding:18px 22px 22px!important;letter-spacing:.005em!important;}
.admin-page-head{display:flex!important;align-items:flex-start!important;justify-content:space-between!important;gap:18px!important;margin-bottom:14px!important;}
.admin-head-actions{display:grid!important;grid-template-columns:128px 146px!important;grid-template-areas:"date date" "export create"!important;gap:9px!important;align-items:stretch!important;justify-content:end!important;min-width:286px!important;}
.admin-head-actions .admin-date-control{grid-area:date!important;width:100%!important;min-width:0!important;justify-content:space-between!important;}
.admin-head-actions .admin-btn-outline{grid-area:export!important;width:100%!important;min-width:0!important;}
.admin-head-actions .admin-btn-primary{grid-area:create!important;width:100%!important;min-width:0!important;}
.admin-btn,.admin-date-control,.tab-btn,.filter-control,.full-btn,.search-box,.mini-action-row button,.pagination-row button{transition:background-color .18s ease,color .18s ease,border-color .18s ease!important;transform:none!important;}
.admin-btn:hover,.admin-date-control:hover,.tab-btn:hover,.filter-control:hover,.full-btn:hover,.search-box:hover,.mini-action-row button:hover,.pagination-row button:hover,.summary-row:hover{transform:none!important;}
.admin-btn-primary{background:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;color:#fff!important;border:0!important;box-shadow:none!important;}
.admin-btn-outline,.admin-date-control,.tab-btn:not(.active),.filter-btn,.filter-control,.search-box,.full-btn:not(.admin-btn-primary){background:#fff!important;color:#050816!important;border:1.5px solid #050816!important;box-shadow:none!important;}
.admin-btn-outline:hover,.admin-date-control:hover,.tab-btn:not(.active):hover,.filter-btn:hover,.filter-control:hover,.full-btn:not(.admin-btn-primary):hover,.mini-action-row button:hover,.pagination-row button:hover{background:#050816!important;color:#fff!important;border-color:#050816!important;}
.admin-main-box,.metric-card,.order-details-modal{border:1.5px solid #050816!important;box-shadow:0 6px 14px rgba(5,8,22,.045)!important;}
.metric-card:hover,.admin-main-box:hover,.side-card:hover,.clickable-main-box:hover{background:rgba(33,37,41,.10)!important;}
.metric-grid{gap:12px!important;margin-bottom:13px!important;}
.metric-card{min-height:82px!important;padding:13px 16px!important;border-radius:11px!important;}
.metric-icon{width:44px!important;height:44px!important;border-radius:9px!important;}
.metric-icon svg{width:24px!important;height:24px!important;}
.metric-copy strong{font-size:23px!important;line-height:1!important;}
.metric-copy h3{font-size:10.5px!important;margin-bottom:5px!important;}
.metric-copy p{font-size:11.5px!important;margin-top:7px!important;}
.analytics-grid{grid-template-columns:1.03fr .92fr .92fr!important;gap:12px!important;margin-bottom:13px!important;align-items:stretch!important;}
.performance-card,.donut-card{min-height:190px!important;height:190px!important;padding:15px 17px!important;overflow:hidden!important;border-radius:12px!important;}
.card-top-row h2,.donut-card h2{font-size:15.5px!important;margin:0!important;}
.card-kicker{font-size:12px!important;margin:10px 0 6px!important;}
.revenue-row{margin-bottom:4px!important;align-items:flex-start!important;}
.revenue-row strong{font-size:21px!important;}
.growth-text{font-size:15px!important;line-height:1.1!important;}
.growth-text small{font-size:11px!important;margin-top:4px!important;}
.line-chart-wrap{height:96px!important;margin-top:3px!important;}
.line-chart-wrap svg{height:76px!important;}
.chart-y-axis{height:76px!important;font-size:10.5px!important;}
.chart-x-axis{font-size:10.5px!important;padding-left:38px!important;}
.donut-content{gap:15px!important;align-items:center!important;height:140px!important;}
.donut{width:118px!important;height:118px!important;flex:0 0 118px!important;}
.donut>div{width:66px!important;height:66px!important;}
.donut>div strong{font-size:22px!important;}
.donut>div span{font-size:10.5px!important;}
.legend-list{gap:9px!important;font-size:12.5px!important;min-width:165px!important;}
.legend-row strong{font-size:12.5px!important;}
.tab-search-row{margin-bottom:12px!important;align-items:flex-start!important;gap:12px!important;}
.status-tabs{gap:8px!important;display:flex!important;flex-wrap:wrap!important;}
.tab-btn{height:38px!important;min-height:38px!important;min-width:auto!important;padding:0 13px!important;border-radius:8px!important;background:#fff!important;}
.tab-btn.active{background:linear-gradient(135deg,#1274ff 0%,#0b63f6 55%,#084ac2 100%)!important;color:#fff!important;border-color:transparent!important;}
.tab-btn b{background:rgba(5,8,22,.08)!important;border-radius:6px!important;padding:3px 8px!important;}
.tab-btn.active b{background:rgba(255,255,255,.20)!important;color:#fff!important;}
.search-filter-actions{gap:10px!important;}
.search-box{height:38px!important;width:380px!important;border-radius:8px!important;padding:0 12px!important;}
.search-box input{font-size:13px!important;}
.filter-row{gap:9px!important;margin-bottom:12px!important;}
.filter-control{height:38px!important;min-height:38px!important;border-radius:8px!important;padding:0 11px!important;}
.filter-control span{font-size:11px!important;}
.filter-control select{max-width:150px!important;font-size:13px!important;}
.orders-layout-grid{grid-template-columns:minmax(0,1fr) 280px!important;gap:13px!important;align-items:start!important;}
.table-card{border-radius:12px!important;overflow:hidden!important;}
.table-responsive{overflow-x:auto!important;}
.orders-table{min-width:920px!important;table-layout:fixed!important;}
.orders-table th,.orders-table td{height:42px!important;padding:0 12px!important;font-size:12px!important;vertical-align:middle!important;}
.orders-table th:nth-child(1),.orders-table td:nth-child(1){width:92px!important;white-space:nowrap!important;word-break:normal!important;overflow-wrap:normal!important;}
.orders-table th:nth-child(2),.orders-table td:nth-child(2){width:130px!important;}
.orders-table th:nth-child(3),.orders-table td:nth-child(3){width:150px!important;}
.orders-table th:nth-child(4),.orders-table td:nth-child(4){width:105px!important;}
.orders-table th:nth-child(5),.orders-table td:nth-child(5){width:98px!important;}
.orders-table th:nth-child(6),.orders-table td:nth-child(6){width:132px!important;}
.orders-table th:nth-child(7),.orders-table td:nth-child(7){width:105px!important;}
.orders-table th:nth-child(8),.orders-table td:nth-child(8){width:132px!important;}
.orders-table th{font-size:10.5px!important;letter-spacing:.015em!important;background:#fff!important;}
.order-link{white-space:nowrap!important;display:inline-block!important;line-height:1!important;word-break:normal!important;overflow-wrap:normal!important;}
.orders-table td{white-space:normal!important;line-height:1.25!important;}
.orders-table td:nth-child(1),.orders-table td:nth-child(4),.orders-table td:nth-child(5),.orders-table td:nth-child(6),.orders-table td:nth-child(7),.orders-table td:nth-child(8){white-space:nowrap!important;}
.mini-action-row{gap:4px!important;justify-content:flex-start!important;}
.mini-action-row button{width:27px!important;height:27px!important;border:1.3px solid #050816!important;background:#fff!important;border-radius:7px!important;}
.mini-action-row button svg{width:14px!important;height:14px!important;}
.table-footer{height:54px!important;padding:0 14px!important;}
.pagination-row{gap:7px!important;}
.pagination-row button{width:31px!important;height:31px!important;border:1.4px solid #050816!important;background:#fff!important;border-radius:7px!important;}
.pagination-row button.active{background:#0b63f6!important;color:#fff!important;border-color:#0b63f6!important;}
.side-card{padding:14px!important;border-radius:12px!important;}
.summary-row{min-height:48px!important;grid-template-columns:38px 1fr auto!important;gap:10px!important;background:#fff!important;border-bottom:1px solid #e8edf5!important;}
.summary-icon{width:32px!important;height:32px!important;}
.summary-icon svg{width:17px!important;height:17px!important;}
.summary-row strong{font-size:18px!important;}
.quick-actions-card{gap:8px!important;}
.full-btn{height:36px!important;border-radius:8px!important;}
.order-details-modal{width:min(760px,95vw)!important;}
@media(max-width:1200px){.admin-head-actions{grid-template-columns:1fr 1fr!important}.analytics-grid{grid-template-columns:1fr!important}.performance-card,.donut-card{height:auto!important;min-height:185px!important}.orders-layout-grid{grid-template-columns:1fr!important}.side-stack{display:grid!important;grid-template-columns:1fr 1fr!important}.search-box{width:320px!important}}
@media(max-width:760px){.admin-page-head{flex-direction:column!important}.admin-head-actions{width:100%!important;grid-template-columns:1fr 1fr!important}.search-box{width:100%!important}.side-stack{grid-template-columns:1fr!important}.orders-table{min-width:900px!important}}
</style>


<style id="orders-v4-clean-final-fixes">
/* V4 clean final: plain white right side, compact analytics, stable hover, fixed full functions */
.orders-admin-shell{background:#fff!important;max-width:1320px!important;padding:18px 22px 24px!important;}
.admin-page-head{margin-bottom:12px!important;}
.admin-page-head h1{font-size:36px!important;line-height:1!important;margin:0!important;}
.admin-page-head p{font-size:13px!important;margin-top:6px!important;}
.admin-title-line:before{width:52px!important;height:4px!important;top:-12px!important;background:#0b63f6!important;border-radius:999px!important;}
.admin-head-actions{grid-template-columns:120px 136px!important;grid-template-areas:"date date" "export create"!important;gap:8px!important;min-width:264px!important;}
.admin-date-control{height:36px!important;border-radius:7px!important;font-size:12.5px!important;background:#fff!important;border:1.5px solid #050816!important;}
.admin-btn{height:36px!important;min-height:36px!important;border-radius:7px!important;padding:0 13px!important;font-size:12.5px!important;font-family:'Poppins',sans-serif!important;font-weight:600!important;letter-spacing:.005em!important;}
.admin-btn-primary,.tab-btn.active,.pagination-row button.active{background:linear-gradient(135deg,#1e7bff 0%,#0d65f2 52%,#0649bf 100%)!important;color:#fff!important;border:0!important;box-shadow:none!important;}
.admin-btn-primary:hover,.tab-btn.active:hover,.pagination-row button.active:hover{background:#050816!important;color:#fff!important;}
.admin-btn-outline,.admin-date-control,.tab-btn:not(.active),.filter-control,.search-box,.full-btn:not(.admin-btn-primary){background:#fff!important;border:1.5px solid #050816!important;color:#050816!important;box-shadow:none!important;}
.admin-btn-outline:hover,.admin-date-control:hover,.tab-btn:not(.active):hover,.filter-control:hover,.search-box:hover,.full-btn:not(.admin-btn-primary):hover{background:#050816!important;color:#fff!important;border-color:#050816!important;}
.admin-btn,.admin-date-control,.tab-btn,.filter-control,.search-box,.summary-row,.mini-action-row button,.pagination-row button,.metric-card,.admin-main-box{transform:none!important;transition:background-color .16s ease,color .16s ease,border-color .16s ease!important;}
.admin-btn:hover,.admin-date-control:hover,.tab-btn:hover,.filter-control:hover,.search-box:hover,.summary-row:hover,.mini-action-row button:hover,.pagination-row button:hover,.metric-card:hover,.admin-main-box:hover{transform:none!important;}
.metric-grid{grid-template-columns:repeat(5,minmax(0,1fr))!important;gap:10px!important;margin-bottom:10px!important;}
.metric-card{min-height:74px!important;padding:11px 13px!important;border:1.5px solid #050816!important;border-radius:10px!important;background:#fff!important;box-shadow:none!important;}
.metric-card:hover{background:rgba(33,37,41,.10)!important;}
.metric-icon{width:40px!important;height:40px!important;border-radius:8px!important;}
.metric-icon svg{width:21px!important;height:21px!important;}
.metric-copy h3{font-size:9.8px!important;margin-bottom:4px!important;}
.metric-copy strong{font-size:21px!important;line-height:1!important;}
.metric-copy p{font-size:10.5px!important;margin-top:6px!important;}
.analytics-grid{grid-template-columns:.95fr .88fr .88fr!important;gap:10px!important;margin-bottom:10px!important;}
.performance-card,.donut-card{height:168px!important;min-height:168px!important;padding:13px 15px!important;border:1.5px solid #050816!important;border-radius:10px!important;background:#fff!important;box-shadow:none!important;overflow:hidden!important;}
.performance-card:hover,.donut-card:hover,.table-card:hover{background:rgba(33,37,41,.08)!important;}
.card-top-row h2,.donut-card h2{font-size:14px!important;line-height:1.1!important;}
.card-kicker{font-size:11px!important;margin:8px 0 4px!important;}
.revenue-row strong{font-size:18px!important;}
.growth-text{font-size:14px!important;}
.growth-text small{font-size:10px!important;}
.line-chart-wrap{height:76px!important;margin-top:0!important;}
.line-chart-wrap svg{height:58px!important;}
.chart-y-axis{height:58px!important;font-size:9.5px!important;width:28px!important;}
.chart-x-axis{font-size:9.5px!important;padding-left:34px!important;margin-top:2px!important;}
.donut-content{height:116px!important;gap:12px!important;align-items:center!important;}
.donut{width:98px!important;height:98px!important;flex-basis:98px!important;}
.donut>div{width:56px!important;height:56px!important;}
.donut>div strong{font-size:19px!important;}
.donut>div span{font-size:9.5px!important;}
.legend-list{gap:7px!important;font-size:11.5px!important;min-width:150px!important;}
.legend-row strong{font-size:11.5px!important;}
.tab-search-row{margin:0 0 9px!important;gap:10px!important;align-items:center!important;}
.status-tabs{gap:7px!important;}
.tab-btn{height:34px!important;min-height:34px!important;padding:0 11px!important;border-radius:7px!important;font-size:12px!important;}
.tab-btn b{padding:2px 7px!important;border-radius:5px!important;}
.search-filter-actions{gap:8px!important;}
.search-box{height:34px!important;width:360px!important;border-radius:7px!important;padding:0 10px!important;}
.search-box input{font-size:12.5px!important;}
.filter-row{gap:8px!important;margin-bottom:10px!important;}
.filter-control{height:34px!important;min-height:34px!important;border-radius:7px!important;padding:0 10px!important;background:#fff!important;}
.filter-control span{font-size:10.5px!important;}
.filter-control select{font-size:12px!important;max-width:135px!important;}
.orders-layout-grid{grid-template-columns:minmax(0,1fr) 250px!important;gap:12px!important;align-items:start!important;}
.table-card{border:1.5px solid #050816!important;border-radius:10px!important;background:#fff!important;box-shadow:none!important;overflow:hidden!important;}
.orders-table{min-width:860px!important;table-layout:fixed!important;}
.orders-table th,.orders-table td{height:39px!important;padding:0 10px!important;font-size:11.5px!important;line-height:1.18!important;}
.orders-table th{font-size:10px!important;background:#fff!important;}
.orders-table th:nth-child(1),.orders-table td:nth-child(1){width:82px!important;white-space:nowrap!important;}
.orders-table th:nth-child(2),.orders-table td:nth-child(2){width:122px!important;}
.orders-table th:nth-child(3),.orders-table td:nth-child(3){width:138px!important;}
.orders-table th:nth-child(4),.orders-table td:nth-child(4){width:94px!important;}
.orders-table th:nth-child(5),.orders-table td:nth-child(5){width:88px!important;}
.orders-table th:nth-child(6),.orders-table td:nth-child(6){width:118px!important;}
.orders-table th:nth-child(7),.orders-table td:nth-child(7){width:98px!important;}
.orders-table th:nth-child(8),.orders-table td:nth-child(8){width:112px!important;}
.order-link{white-space:nowrap!important;word-break:keep-all!important;overflow-wrap:normal!important;line-height:1!important;font-size:11.5px!important;}
.mini-action-row{gap:3px!important;}
.mini-action-row button{width:24px!important;height:24px!important;border:1.3px solid #050816!important;background:#fff!important;border-radius:6px!important;}
.mini-action-row button svg{width:13px!important;height:13px!important;}
.pill{padding:4px 9px!important;font-size:10.5px!important;border-radius:6px!important;}
.table-footer{height:48px!important;padding:0 12px!important;font-size:11.5px!important;}
.pagination-row button{width:28px!important;height:28px!important;border-radius:6px!important;border:1.3px solid #050816!important;background:#fff!important;}
.side-stack{gap:10px!important;}
.side-card,.quick-actions-card{border:0!important;background:#fff!important;box-shadow:none!important;padding:0!important;border-radius:0!important;}
.side-card:hover,.quick-actions-card:hover{background:#fff!important;}
.side-card h2{font-size:15px!important;margin:0 0 10px!important;}
.summary-row{height:43px!important;min-height:43px!important;grid-template-columns:32px 1fr auto!important;gap:9px!important;background:#fff!important;border:0!important;border-bottom:1px solid #e7ebf2!important;border-radius:0!important;padding:0!important;box-shadow:none!important;}
.summary-row:hover{background:rgba(33,37,41,.10)!important;}
.summary-icon{width:28px!important;height:28px!important;border-radius:8px!important;}
.summary-icon svg{width:15px!important;height:15px!important;}
.summary-row span:not(.summary-icon){font-size:11.8px!important;}
.summary-row strong{font-size:17px!important;}
.quick-actions-card .full-btn{width:100%!important;height:34px!important;margin:0 0 7px!important;border-radius:7px!important;background:#fff!important;}
.quick-actions-card .admin-btn-primary{background:linear-gradient(135deg,#1e7bff 0%,#0d65f2 52%,#0649bf 100%)!important;color:#fff!important;}
.order-details-modal{width:min(690px,94vw)!important;border:1.5px solid #050816!important;border-radius:11px!important;box-shadow:0 16px 38px rgba(5,8,22,.18)!important;}
.modal-title-row{height:50px!important;padding:0 18px!important;border-bottom:1px solid #e7ebf2!important;}
.modal-heading-inline h2{font-size:16px!important;}
.order-template-note{margin:14px 18px 10px!important;padding:9px 11px!important;border:1.3px solid #050816!important;border-radius:8px!important;display:flex!important;align-items:center!important;gap:8px!important;font-family:'Inter',sans-serif!important;font-size:12px!important;background:#fff!important;}
.order-template-note svg{width:16px!important;height:16px!important;color:#0b63f6!important;}
.modal-template-grid{display:grid!important;grid-template-columns:repeat(3,1fr)!important;gap:9px!important;padding:0 18px 10px!important;}
.modal-template-card,.modal-template-table{background:#fff!important;border:1.3px solid #050816!important;border-radius:8px!important;padding:11px!important;box-shadow:none!important;}
.modal-template-card h3,.modal-template-table h3{font-family:'Poppins',sans-serif!important;font-weight:600!important;font-size:12px!important;margin:0 0 8px!important;}
.template-field{display:flex!important;justify-content:space-between!important;gap:8px!important;border-bottom:1px solid #edf1f6!important;padding:6px 0!important;font-family:'Inter',sans-serif!important;font-size:11.2px!important;}
.template-field span{color:#5c6678!important;}
.template-field b,.template-field em{font-style:normal!important;color:#050816!important;font-weight:600!important;white-space:nowrap!important;}
.modal-template-table{margin:0 18px 10px!important;padding:11px!important;}
.modal-template-table table{width:100%!important;border-collapse:collapse!important;font-size:11.5px!important;}
.modal-template-table th,.modal-template-table td{height:30px!important;border-bottom:1px solid #e7ebf2!important;text-align:left!important;padding:0 8px!important;}
.modal-template-table th{font-family:'Poppins',sans-serif!important;font-size:10px!important;text-transform:uppercase!important;}
.modal-template-actions{display:flex!important;justify-content:flex-end!important;gap:8px!important;padding:0 18px 16px!important;}
.modal-template-actions .admin-btn{width:auto!important;min-width:96px!important;}
@media(max-width:1180px){.metric-grid{grid-template-columns:repeat(2,1fr)!important}.analytics-grid{grid-template-columns:1fr!important}.performance-card,.donut-card{height:auto!important;min-height:158px!important}.orders-layout-grid{grid-template-columns:1fr!important}.side-stack{display:block!important}.quick-actions-card{margin-top:16px!important}.search-box{width:300px!important}}
@media(max-width:760px){.admin-page-head{flex-direction:column!important}.admin-head-actions{width:100%!important}.metric-grid{grid-template-columns:1fr!important}.modal-template-grid{grid-template-columns:1fr!important}.search-filter-actions{width:100%!important}.search-box{width:100%!important}.orders-table{min-width:860px!important}}
</style>


<style>
/* FINAL ALIGNMENT PATCH - compact, functional, no extra boxes */
.orders-admin-shell{
    background:#fff!important;
    padding-top:24px!important;
}
.admin-page-head{
    align-items:flex-start!important;
    margin-bottom:18px!important;
}
.admin-head-actions{
    display:grid!important;
    grid-template-columns:1fr 1fr!important;
    gap:8px!important;
    min-width:275px!important;
    justify-items:stretch!important;
}
.admin-date-control{
    grid-column:1 / -1!important;
    width:100%!important;
    min-width:0!important;
    height:38px!important;
    border:1.4px solid #050816!important;
    background:#fff!important;
}
.admin-head-actions .admin-btn{
    width:100%!important;
    min-width:0!important;
    height:36px!important;
    padding:0 12px!important;
    border-radius:7px!important;
}
.admin-btn-primary,
.tab-btn.active,
.pagination-row button.active{
    background:linear-gradient(135deg,#2486ff 0%,#0d66f2 50%,#0849c8 100%)!important;
    color:#fff!important;
    border:0!important;
}
.admin-btn-outline,
.filter-btn,
.full-btn:not(.admin-btn-primary){
    background:#fff!important;
    color:#050816!important;
    border:1.4px solid #050816!important;
}
.admin-btn:hover,
.admin-date-control:hover,
.tab-btn:hover,
.filter-control:hover,
.full-btn:hover,
.search-box button:hover,
.pagination-row button:hover{
    background:#050816!important;
    color:#fff!important;
    transform:none!important;
}
.metric-grid{gap:10px!important;margin-bottom:12px!important;}
.metric-card{height:82px!important;min-height:82px!important;padding:12px 15px!important;gap:13px!important;border:1.4px solid #050816!important;}
.metric-icon{width:42px!important;height:42px!important;border-radius:9px!important;}
.metric-icon svg{width:23px!important;height:23px!important;}
.metric-copy h3{font-size:10px!important;margin-bottom:3px!important;}
.metric-copy strong{font-size:22px!important;margin-bottom:5px!important;}
.metric-copy p{font-size:11px!important;}
.analytics-grid{
    grid-template-columns:1.02fr .94fr .98fr!important;
    gap:10px!important;
    margin-bottom:22px!important; /* spacing before All Orders */
}
.analytics-grid article{
    min-height:170px!important;
    height:170px!important;
    padding:12px 16px!important;
    border:1.4px solid #050816!important;
    overflow:hidden!important;
}
.analytics-grid h2{font-size:14px!important;margin-bottom:9px!important;}
.card-kicker{font-size:11px!important;margin-bottom:4px!important;}
.revenue-row>strong{font-size:18px!important;}
.growth-text{font-size:14px!important;}
.growth-text small{font-size:10px!important;}
.line-chart-wrap{height:94px!important;margin-top:3px!important;padding-left:34px!important;}
.line-chart-wrap svg{height:84px!important;}
.chart-y-axis{height:84px!important;font-size:10px!important;}
.chart-x-axis{font-size:10px!important;bottom:-4px!important;}
.donut-content{gap:12px!important;align-items:center!important;}
.donut{width:112px!important;height:112px!important;flex-basis:112px!important;}
.donut>div{width:62px!important;height:62px!important;}
.donut>div strong{font-size:21px!important;}
.donut>div span{font-size:9px!important;}
.legend-list{gap:8px!important;font-size:12px!important;}
.legend-row{gap:14px!important;}
.tab-search-row{
    align-items:center!important;
    gap:14px!important;
    margin-top:0!important;
    margin-bottom:10px!important;
}
.status-tabs{gap:7px!important;flex-wrap:wrap!important;}
.tab-btn{
    height:34px!important;
    min-height:34px!important;
    min-width:104px!important;
    padding:0 12px!important;
    border:1.4px solid #050816!important;
    background:#fff!important;
    border-radius:7px!important;
    font-size:12px!important;
}
.tab-btn b{padding:4px 9px!important;border-radius:6px!important;}
.search-filter-actions{
    display:flex!important;
    align-items:center!important;
    gap:8px!important;
    margin-left:auto!important;
}
.search-box{
    height:34px!important;
    width:360px!important;
    border:1.4px solid #050816!important;
    background:#fff!important;
    border-radius:7px!important;
    display:flex!important;
    align-items:center!important;
    gap:9px!important;
    padding:0 11px!important;
    overflow:hidden!important;
}
.search-box svg,
.search-box i{
    width:16px!important;
    height:16px!important;
    flex:0 0 auto!important;
    color:#050816!important;
}
.search-box input{
    height:32px!important;
    line-height:32px!important;
    border:0!important;
    outline:0!important;
    background:transparent!important;
    padding:0!important;
    font-size:12px!important;
    flex:1!important;
    min-width:0!important;
}
.search-box i:last-child{display:none!important;}
.filter-btn{
    height:34px!important;
    min-height:34px!important;
    min-width:116px!important;
    padding:0 12px!important;
}
.filter-row{gap:8px!important;margin-bottom:10px!important;}
.filter-control{
    height:34px!important;
    min-height:34px!important;
    border:1.4px solid #050816!important;
    background:#fff!important;
    border-radius:7px!important;
    padding:0 10px!important;
    gap:8px!important;
}
.filter-control span{font-size:10.5px!important;}
.filter-control select{font-size:12px!important;max-width:155px!important;}
.orders-layout-grid{
    grid-template-columns:minmax(0,1fr) 270px!important;
    gap:12px!important;
    align-items:start!important;
}
.table-card{border:1.4px solid #050816!important;box-shadow:none!important;}
.orders-table{table-layout:fixed!important;}
.orders-table th{height:38px!important;padding:0 12px!important;font-size:11px!important;white-space:nowrap!important;}
.orders-table td{height:45px!important;padding:0 12px!important;font-size:12px!important;}
.orders-table th:nth-child(1),.orders-table td:nth-child(1){width:94px!important;}
.orders-table th:nth-child(2),.orders-table td:nth-child(2){width:130px!important;}
.orders-table th:nth-child(3),.orders-table td:nth-child(3){width:170px!important;}
.orders-table th:nth-child(4),.orders-table td:nth-child(4){width:105px!important;}
.orders-table th:nth-child(5),.orders-table td:nth-child(5){width:96px!important;}
.orders-table th:nth-child(6),.orders-table td:nth-child(6){width:130px!important;}
.orders-table th:nth-child(7),.orders-table td:nth-child(7){width:120px!important;}
.orders-table th:nth-child(8),.orders-table td:nth-child(8){width:96px!important;}
.order-link{white-space:nowrap!important;font-size:12px!important;}
.mini-action-row{gap:4px!important;justify-content:flex-start!important;}
.mini-action-row button{
    width:19px!important;
    height:19px!important;
    border:0!important;
    background:transparent!important;
    box-shadow:none!important;
    padding:0!important;
    border-radius:4px!important;
    color:#050816!important;
}
.mini-action-row button svg{width:14px!important;height:14px!important;stroke-width:2.1!important;}
.mini-action-row button:hover{background:#050816!important;color:#fff!important;}
.table-footer{
    height:45px!important;
    padding:0 12px!important;
    background:#fff!important;
    border-top:1px solid #e6ebf2!important;
}
.pagination-row{gap:9px!important;align-items:center!important;}
.pagination-row button{
    width:auto!important;
    min-width:18px!important;
    height:24px!important;
    border:0!important;
    background:transparent!important;
    box-shadow:none!important;
    padding:0 4px!important;
    border-radius:5px!important;
    color:#050816!important;
    font-size:12px!important;
    font-weight:800!important;
}
.pagination-row button svg{width:15px!important;height:15px!important;}
.pagination-row button.active{
    min-width:26px!important;
    color:#fff!important;
    border-radius:6px!important;
}
.side-stack{display:block!important;}
.side-card,
.order-summary-card,
.quick-actions-card{
    border:0!important;
    box-shadow:none!important;
    background:transparent!important;
    padding:0!important;
}
.order-summary-card{margin-top:4px!important;margin-bottom:16px!important;}
.side-card h2{font-size:16px!important;margin:0 0 11px!important;}
.summary-row{
    height:46px!important;
    min-height:46px!important;
    border:0!important;
    border-bottom:1px solid #eef2f7!important;
    background:#fff!important;
    border-radius:0!important;
    padding:0 4px!important;
    display:grid!important;
    grid-template-columns:34px 1fr auto!important;
    gap:9px!important;
}
.summary-row:hover{background:rgba(33,37,41,.08)!important;color:#050816!important;}
.summary-icon{width:28px!important;height:28px!important;border-radius:8px!important;}
.summary-icon svg{width:16px!important;height:16px!important;}
.summary-row span:not(.summary-icon){font-size:12px!important;}
.summary-row strong{font-size:18px!important;}
.quick-actions-card{display:flex!important;flex-direction:column!important;gap:8px!important;}
.quick-actions-card .full-btn{
    width:100%!important;
    height:34px!important;
    min-height:34px!important;
    border-radius:7px!important;
    font-size:12px!important;
    padding:0 10px!important;
}
.quick-actions-card .admin-btn-primary{height:36px!important;}
/* Modal remains functional but cleaner/template-like */
.order-details-modal{width:min(760px,94vw)!important;border:1.4px solid #050816!important;box-shadow:0 18px 46px rgba(5,8,22,.20)!important;}
.modal-grid-three{gap:10px!important;padding:14px 18px 8px!important;}
.modal-mini-card,.modal-items-card,.modal-status-strip{background:#fff!important;border:1px solid #e3e8f0!important;}
.modal-bottom-grid{gap:10px!important;padding:0 18px 18px!important;}
@media(max-width:1200px){
    .analytics-grid{grid-template-columns:1fr!important;}
    .analytics-grid article{height:auto!important;min-height:170px!important;}
    .orders-layout-grid{grid-template-columns:1fr!important;}
    .search-filter-actions{margin-left:0!important;width:100%!important;}
    .search-box{width:100%!important;}
    .side-stack{display:grid!important;grid-template-columns:1fr 1fr!important;gap:16px!important;}
}
</style>

<style>
/* =========================================================
   FINAL V6 COMPACT FIXES
   - Narrower Order Summary / Quick Actions
   - Smaller buttons
   - Metric cards use exact soft color per status
   - Light gray subtle boxes for non-table sections
   - Table keeps black border
   ========================================================= */
:root{
    --v6-blue:#0b63f6;
    --v6-blue-dark:#0649bf;
    --v6-black:#050816;
    --v6-soft-border:#dfe4ec;
    --v6-light-line:#edf1f6;
}

.orders-admin-shell{
    background:#fff!important;
}

/* Header buttons: smaller and not too wide */
.admin-head-actions{
    grid-template-columns:250px 112px 132px!important;
    gap:8px!important;
}
.admin-btn,
.admin-date-control,
.full-btn,
.filter-btn{
    height:34px!important;
    min-height:34px!important;
    min-width:auto!important;
    padding:0 12px!important;
    border-radius:7px!important;
    font-size:12px!important;
    line-height:1!important;
    letter-spacing:.005em!important;
}
.admin-date-control{
    width:250px!important;
}
.admin-btn svg,
.admin-date-control svg,
.full-btn svg,
.filter-btn svg{
    width:15px!important;
    height:15px!important;
}
.admin-btn-primary,
.tab-btn.active,
.pagination-row button.active{
    background:linear-gradient(135deg,#2b85ff 0%,#0b63f6 52%,#0649bf 100%)!important;
    color:#fff!important;
    border:0!important;
    box-shadow:none!important;
}
.admin-btn-primary:hover,
.tab-btn.active:hover,
.pagination-row button.active:hover{
    background:#050816!important;
    color:#fff!important;
}

/* Subtle gray borders for top boxes/charts, black only for table */
.admin-main-box,
.metric-card{
    border:1px solid var(--v6-soft-border)!important;
    box-shadow:0 6px 16px rgba(5,8,22,.035)!important;
    background:#fff!important;
}
.table-card{
    border:1.5px solid var(--v6-black)!important;
    box-shadow:none!important;
}
.admin-main-box:hover,
.metric-card:hover{
    background:rgba(33,37,41,.055)!important;
}
.table-card:hover{
    background:#fff!important;
}

/* Metric card color boxes per request */
.metric-grid{
    gap:10px!important;
    margin-bottom:12px!important;
}
.metric-card{
    min-height:72px!important;
    padding:10px 12px!important;
    gap:12px!important;
    border-radius:10px!important;
}
.metric-card:has(.blue-soft){
    background:#eef5ff!important;
    border-color:#cfe1ff!important;
}
.metric-card:has(.orange-soft){
    background:#fff6e6!important;
    border-color:#ffe1aa!important;
}
.metric-card:has(.cyan-soft){
    background:#f3ecff!important;
    border-color:#ddccff!important;
}
.metric-card:has(.green-soft){
    background:#eaf8f0!important;
    border-color:#c8efd9!important;
}
.metric-card:has(.red-soft){
    background:#fff0f0!important;
    border-color:#ffd2d2!important;
}
.metric-card:has(.blue-soft):hover,
.metric-card:has(.orange-soft):hover,
.metric-card:has(.cyan-soft):hover,
.metric-card:has(.green-soft):hover,
.metric-card:has(.red-soft):hover{
    background:rgba(33,37,41,.10)!important;
}
.metric-icon{
    width:40px!important;
    height:40px!important;
    border-radius:8px!important;
    background:rgba(255,255,255,.62)!important;
}
.metric-icon svg{
    width:23px!important;
    height:23px!important;
}
.metric-copy h3{
    font-size:10px!important;
    margin-bottom:3px!important;
}
.metric-copy strong{
    font-size:22px!important;
    margin-bottom:5px!important;
}
.metric-copy p{
    font-size:11px!important;
}

/* Charts remain compact, light border only */
.analytics-grid{
    gap:10px!important;
    margin-bottom:20px!important;
    grid-template-columns:1fr .92fr .98fr!important;
}
.performance-card,
.donut-card{
    height:168px!important;
    min-height:168px!important;
    padding:12px 14px!important;
    border:1px solid var(--v6-soft-border)!important;
    border-radius:10px!important;
}
.card-top-row h2,
.donut-card h2{
    font-size:14px!important;
}
.donut{width:124px!important;height:124px!important;flex-basis:124px!important;}
.donut>div{width:68px!important;height:68px!important;}
.donut>div strong{font-size:22px!important;}
.legend-row{font-size:12px!important;}
.line-chart-wrap{height:92px!important;}

/* Search/filter row alignment and smaller controls */
.tab-search-row{
    margin-top:0!important;
    margin-bottom:9px!important;
    gap:12px!important;
    align-items:center!important;
}
.status-tabs{gap:7px!important;}
.tab-btn{
    height:33px!important;
    min-height:33px!important;
    padding:0 10px!important;
    border-radius:7px!important;
    font-size:11.8px!important;
    border:1.3px solid var(--v6-black)!important;
}
.tab-btn b{
    padding:2px 7px!important;
    font-size:11px!important;
}
.search-filter-actions{gap:8px!important;align-items:center!important;}
.search-box{
    height:33px!important;
    min-height:33px!important;
    width:330px!important;
    border:1.3px solid var(--v6-black)!important;
    border-radius:7px!important;
    background:#fff!important;
    display:flex!important;
    align-items:center!important;
    padding:0 10px!important;
}
.search-box input{
    height:100%!important;
    line-height:33px!important;
    font-size:12px!important;
}
.search-box svg{
    width:15px!important;
    height:15px!important;
    flex:0 0 auto!important;
}
.filter-row{
    gap:8px!important;
    margin-bottom:9px!important;
}
.filter-control{
    height:33px!important;
    min-height:33px!important;
    border:1.3px solid var(--v6-black)!important;
    border-radius:7px!important;
    background:#fff!important;
    padding:0 10px!important;
    min-width:0!important;
}
.filter-control span{font-size:11px!important;}
.filter-control select{font-size:12px!important;max-width:128px!important;}

/* Main layout: wider table, narrower right side */
.orders-layout-grid{
    grid-template-columns:minmax(0,1fr) 248px!important;
    gap:12px!important;
    align-items:start!important;
}
.side-stack{
    width:248px!important;
    max-width:248px!important;
    gap:12px!important;
}
.side-card,
.quick-actions-card{
    width:248px!important;
    max-width:248px!important;
    background:#fff!important;
    border:0!important;
    box-shadow:none!important;
    padding:0!important;
    border-radius:0!important;
}
.side-card h2,
.quick-actions-card h2{
    font-size:15px!important;
    margin:0 0 10px!important;
}
.summary-row{
    width:100%!important;
    height:42px!important;
    min-height:42px!important;
    grid-template-columns:30px 1fr auto!important;
    gap:8px!important;
    padding:0!important;
    border-bottom:1px solid var(--v6-light-line)!important;
    background:#fff!important;
}
.summary-icon{
    width:27px!important;
    height:27px!important;
    border-radius:8px!important;
}
.summary-icon svg{width:14px!important;height:14px!important;}
.summary-row span:not(.summary-icon){font-size:11.5px!important;}
.summary-row strong{font-size:16px!important;}
.quick-actions-card .full-btn{
    width:100%!important;
    height:32px!important;
    min-height:32px!important;
    margin:0 0 7px!important;
    border-radius:7px!important;
    padding:0 10px!important;
    justify-content:center!important;
    font-size:11.8px!important;
}
.quick-actions-card .admin-btn-primary{
    height:34px!important;
    background:linear-gradient(135deg,#2b85ff 0%,#0b63f6 52%,#0649bf 100%)!important;
}

/* Table has black border, cleaner internal lines */
.orders-table th{
    height:39px!important;
    padding:0 13px!important;
    white-space:nowrap!important;
}
.orders-table td{
    height:44px!important;
    padding:0 13px!important;
}
.order-link{
    white-space:nowrap!important;
}
.orders-table tbody tr.selected-row,
.orders-table tbody tr:hover{
    background:#f1f6ff!important;
}
.mini-action-row{
    gap:4px!important;
    justify-content:flex-end!important;
}
.mini-action-row button{
    width:20px!important;
    height:20px!important;
    border:0!important;
    background:transparent!important;
    padding:0!important;
    border-radius:5px!important;
}
.mini-action-row button svg{
    width:15px!important;
    height:15px!important;
}
.mini-action-row button:hover{
    background:#050816!important;
    color:#fff!important;
}
.table-footer{
    height:49px!important;
    padding:0 13px!important;
}
.pagination-row{gap:5px!important;}
.pagination-row button{
    width:24px!important;
    height:24px!important;
    border:0!important;
    background:transparent!important;
    padding:0!important;
    border-radius:6px!important;
    font-size:12px!important;
}
.pagination-row button svg{width:14px!important;height:14px!important;}

/* Modal still functional but lighter */
.order-details-modal{
    border:1.5px solid var(--v6-black)!important;
}
.modal-template-card,
.modal-template-table{
    border:1px solid var(--v6-soft-border)!important;
}

@media(max-width:1200px){
    .analytics-grid{grid-template-columns:1fr!important;}
    .orders-layout-grid{grid-template-columns:1fr!important;}
    .side-stack,.side-card,.quick-actions-card{width:100%!important;max-width:none!important;}
    .side-stack{display:grid!important;grid-template-columns:1fr 1fr!important;}
    .search-box{width:300px!important;}
}
@media(max-width:760px){
    .admin-head-actions{grid-template-columns:1fr 1fr!important;width:100%!important;}
    .admin-date-control{width:100%!important;grid-column:1/-1!important;}
    .side-stack{grid-template-columns:1fr!important;}
    .search-box{width:100%!important;}
}
</style>

<style>
/* =========================================================
   FINAL V7 SPACING + CHART BOX VISIBILITY PATCH
   Requested fixes:
   1) Make the 3 chart boxes, especially Order Performance, clearer/visible but still subtle.
   2) Add better vertical spacing between buttons/controls going downward.
   3) Keep compact widths and working functions from V6.
   ========================================================= */
:root{
    --v7-black:#050816;
    --v7-subtle-border:#b8c0cc;
    --v7-soft-border:#d5dbe5;
    --v7-light-gray:#f8fafc;
    --v7-blue:#0b63f6;
    --v7-blue-dark:#0649bf;
}

/* Whole orders section still white, no background box */
.orders-admin-shell{
    background:#fff!important;
}

/* Header spacing */
.admin-page-head{
    margin-bottom:24px!important;
}

/* Metric cards spacing below title */
.metric-grid{
    gap:12px!important;
    margin-bottom:18px!important;
}

/* Make the 3 analytics boxes visible enough but not heavy black */
.analytics-grid{
    gap:14px!important;
    margin-bottom:28px!important; /* clearer spacing before All Orders buttons */
}
.performance-card,
.donut-card,
.analytics-grid .admin-main-box{
    border:1.45px solid var(--v7-subtle-border)!important;
    background:#fff!important;
    box-shadow:0 8px 20px rgba(5,8,22,.055)!important;
    border-radius:11px!important;
}
.performance-card{
    border-color:#aeb7c4!important; /* Order Performance slightly clearer */
}
.performance-card:hover,
.donut-card:hover{
    background:#f8fafc!important;
    border-color:#8f99a8!important;
    box-shadow:0 10px 22px rgba(5,8,22,.075)!important;
    transform:none!important;
}

/* Card inner breathing room */
.performance-card,
.donut-card{
    padding:14px 16px!important;
    height:174px!important;
    min-height:174px!important;
}
.card-top-row h2,
.donut-card h2{
    margin-bottom:10px!important;
}
.line-chart-wrap{
    margin-top:8px!important;
    height:90px!important;
}
.donut-content{
    padding-top:2px!important;
}

/* More vertical spacing between tab buttons, filters, and table */
.tab-search-row{
    margin-top:0!important;
    margin-bottom:14px!important;
    gap:14px!important;
}
.filter-row{
    margin-top:0!important;
    margin-bottom:16px!important;
    gap:10px!important;
}
.orders-layout-grid{
    margin-top:0!important;
    gap:14px!important;
}

/* Give each control room but keep compact sizing */
.status-tabs{
    gap:8px!important;
    row-gap:10px!important;
}
.tab-btn{
    height:34px!important;
    min-height:34px!important;
    padding:0 12px!important;
}
.search-filter-actions{
    gap:10px!important;
}
.search-box{
    height:34px!important;
    min-height:34px!important;
}
.filter-btn{
    height:34px!important;
    min-height:34px!important;
}
.filter-control{
    height:34px!important;
    min-height:34px!important;
}

/* Keep table black border only */
.table-card{
    border:1.55px solid var(--v7-black)!important;
    box-shadow:none!important;
    background:#fff!important;
}
.table-card:hover{
    background:#fff!important;
    border-color:var(--v7-black)!important;
    box-shadow:none!important;
}

/* Right side remains narrow and plain white, with better vertical spacing */
.orders-layout-grid{
    grid-template-columns:minmax(0,1fr) 236px!important;
}
.side-stack,
.side-card,
.quick-actions-card{
    width:236px!important;
    max-width:236px!important;
}
.order-summary-card{
    margin-bottom:22px!important;
}
.summary-row{
    height:44px!important;
    min-height:44px!important;
}
.quick-actions-card{
    gap:10px!important;
}
.quick-actions-card .full-btn{
    height:33px!important;
    min-height:33px!important;
    margin:0 0 9px!important;
    width:100%!important;
}
.quick-actions-card .admin-btn-primary{
    height:35px!important;
}

/* Gradient buttons cleaner and not oversized */
.admin-btn-primary,
.tab-btn.active,
.pagination-row button.active{
    background:linear-gradient(135deg,#2b8cff 0%,#0b63f6 50%,#0649bf 100%)!important;
    color:#fff!important;
    border:0!important;
    box-shadow:0 4px 10px rgba(11,99,246,.18)!important;
}
.admin-btn-primary:hover,
.tab-btn.active:hover,
.pagination-row button.active:hover{
    background:#050816!important;
    box-shadow:none!important;
    color:#fff!important;
}

/* Avoid layout movement on hover */
.admin-btn,
.admin-date-control,
.metric-card,
.tab-btn,
.filter-control,
.search-box,
.summary-row,
.mini-action-row button,
.pagination-row button{
    transition:background-color .15s ease,color .15s ease,border-color .15s ease,box-shadow .15s ease!important;
    transform:none!important;
}
.admin-btn:hover,
.admin-date-control:hover,
.metric-card:hover,
.tab-btn:hover,
.filter-control:hover,
.search-box:hover,
.summary-row:hover,
.mini-action-row button:hover,
.pagination-row button:hover{
    transform:none!important;
}

/* Keep small buttons not too wide */
.admin-head-actions{
    grid-template-columns:250px 110px 128px!important;
}
.admin-btn,
.admin-date-control,
.full-btn,
.filter-btn{
    padding-left:11px!important;
    padding-right:11px!important;
}

@media(max-width:1200px){
    .analytics-grid{grid-template-columns:1fr!important;gap:14px!important;}
    .orders-layout-grid{grid-template-columns:1fr!important;}
    .side-stack,.side-card,.quick-actions-card{width:100%!important;max-width:none!important;}
    .side-stack{display:grid!important;grid-template-columns:1fr 1fr!important;gap:18px!important;}
}
@media(max-width:760px){
    .side-stack{grid-template-columns:1fr!important;}
    .admin-head-actions{grid-template-columns:1fr 1fr!important;}
}


/* === FINAL REQUEST PATCH: right actions, cleaner spacing, subtle borders === */
.orders-admin-shell{
    max-width:1480px!important;
    padding:28px 28px 34px!important;
    background:#fff!important;
}
.admin-page-head{
    width:100%!important;
    display:flex!important;
    align-items:flex-start!important;
    justify-content:space-between!important;
    gap:28px!important;
    margin-bottom:30px!important;
}
.admin-page-head>div:first-child{flex:1 1 auto!important;min-width:0!important;}
.admin-head-actions{
    margin-left:auto!important;
    margin-right:0!important;
    justify-self:end!important;
    align-self:flex-start!important;
    width:438px!important;
    display:grid!important;
    grid-template-columns:1fr 124px!important;
    grid-template-areas:
        "date date"
        "export create"!important;
    gap:10px!important;
}
.admin-date-control{grid-area:date!important;width:100%!important;min-width:0!important;}
.admin-head-actions .admin-btn-outline{grid-area:export!important;width:100%!important;min-width:0!important;}
.admin-head-actions .admin-btn-primary{grid-area:create!important;width:100%!important;min-width:0!important;}
.admin-date-control,.admin-head-actions .admin-btn{
    height:38px!important;
    min-height:38px!important;
    padding:0 13px!important;
    border-radius:8px!important;
    font-size:12.5px!important;
}
.admin-head-actions .admin-btn svg,.admin-date-control svg{width:16px!important;height:16px!important;}

/* Main cards: light border lang, table lang ang black */
:root{--final-soft-border:#d8dee8;--final-softer-border:#e2e7ef;--final-table-border:#050816;}
.admin-main-box:not(.table-card),
.performance-card,
.donut-card{
    border:1.15px solid var(--final-soft-border)!important;
    box-shadow:0 6px 14px rgba(5,8,22,.035)!important;
    background:#fff!important;
}
.admin-main-box:not(.table-card):hover,
.performance-card:hover,
.donut-card:hover{
    border-color:#cfd6e2!important;
    background:#f7f8fa!important;
    box-shadow:0 8px 18px rgba(5,8,22,.045)!important;
}
.table-card{
    border:1.55px solid var(--final-table-border)!important;
    box-shadow:none!important;
}

/* Colored summary metric boxes */
.metric-card{
    height:82px!important;
    min-height:82px!important;
    padding:12px 15px!important;
    gap:13px!important;
    border-width:1.15px!important;
    box-shadow:none!important;
}
.metric-card:nth-child(1){background:#eef5ff!important;border-color:#bfd8ff!important;}
.metric-card:nth-child(2){background:#fff6e8!important;border-color:#ffdca3!important;}
.metric-card:nth-child(3){background:#f3edff!important;border-color:#d9c8ff!important;}
.metric-card:nth-child(4){background:#ecf9f2!important;border-color:#bee9d1!important;}
.metric-card:nth-child(5){background:#fff0f0!important;border-color:#ffcaca!important;}
.metric-card:hover{background:#f2f4f7!important;border-color:#c9d0dc!important;}
.metric-grid{
    gap:14px!important;
    margin-bottom:22px!important;
}

/* Chart section visible but not heavy; more breathing room below */
.analytics-grid{
    gap:18px!important;
    margin-bottom:30px!important;
}
.performance-card,.donut-card{
    height:182px!important;
    min-height:182px!important;
    padding:15px 17px!important;
    border-radius:11px!important;
    overflow:hidden!important;
}
.analytics-grid h2{margin-bottom:12px!important;}
.line-chart-wrap{height:92px!important;margin-top:6px!important;padding-left:34px!important;}
.line-chart-wrap svg{height:80px!important;}
.chart-y-axis{height:80px!important;}
.chart-x-axis{bottom:-2px!important;}
.donut{width:112px!important;height:112px!important;flex-basis:112px!important;}
.donut>div{width:66px!important;height:66px!important;}
.donut strong{font-size:20px!important;}
.donut span{font-size:10px!important;}
.donut-content{gap:20px!important;}
.legend-list{gap:10px!important;}

/* More vertical spacing between buttons/filter/table */
.tab-search-row{
    margin-top:0!important;
    margin-bottom:14px!important;
    row-gap:14px!important;
}
.status-tabs{
    gap:11px!important;
}
.search-filter-actions{
    gap:12px!important;
}
.filter-row{
    gap:12px!important;
    margin-bottom:20px!important;
}
.orders-layout-grid{
    gap:20px!important;
    grid-template-columns:minmax(0,1fr) 228px!important;
    align-items:start!important;
}
.table-card{margin-top:0!important;}

/* Controls: subtle line except active/primary; compact sizes */
.admin-btn-outline,
.admin-date-control,
.tab-btn:not(.active),
.filter-control,
.search-box,
.full-btn:not(.admin-btn-primary){
    background:#fff!important;
    border:1.15px solid #d3dae5!important;
    color:#050816!important;
    box-shadow:none!important;
}
.admin-btn-outline:hover,
.admin-date-control:hover,
.tab-btn:not(.active):hover,
.filter-control:hover,
.search-box:hover,
.full-btn:not(.admin-btn-primary):hover{
    background:#050816!important;
    border-color:#050816!important;
    color:#fff!important;
}
.admin-btn-primary,
.tab-btn.active,
.pagination-row button.active{
    background:linear-gradient(135deg,#2d8dff 0%,#0b63f6 52%,#0648bd 100%)!important;
    color:#fff!important;
    border:0!important;
    box-shadow:0 5px 10px rgba(11,99,246,.16)!important;
}
.tab-btn{
    height:36px!important;
    min-height:36px!important;
    padding:0 12px!important;
    border-radius:8px!important;
}
.search-box,.filter-btn,.filter-control{
    height:36px!important;
    min-height:36px!important;
    border-radius:8px!important;
}
.search-box{width:380px!important;}
.filter-control{padding:0 12px!important;}

/* Right side narrower, plain white, with no outside box */
.side-stack,.side-card,.quick-actions-card{
    width:228px!important;
    max-width:228px!important;
    border:0!important;
    box-shadow:none!important;
    background:#fff!important;
    padding:0!important;
}
.side-card h2{font-size:16px!important;margin:0 0 13px!important;}
.order-summary-card{margin-bottom:26px!important;}
.summary-row{
    height:46px!important;
    min-height:46px!important;
    border:0!important;
    border-bottom:1px solid #e7ebf2!important;
    background:#fff!important;
    padding:0!important;
}
.quick-actions-card{gap:10px!important;}
.quick-actions-card .full-btn{
    height:34px!important;
    min-height:34px!important;
    margin:0 0 10px!important;
    width:100%!important;
    border-radius:8px!important;
}
.quick-actions-card .admin-btn-primary{
    height:36px!important;
    min-height:36px!important;
}

/* Action icons and pagination remain simple; no heavy box */
.mini-action-row button{
    border:0!important;
    background:transparent!important;
    box-shadow:none!important;
    width:23px!important;
    height:23px!important;
    border-radius:6px!important;
}
.mini-action-row button:hover{background:#050816!important;color:#fff!important;}
.pagination-row button{
    border:0!important;
    background:transparent!important;
    box-shadow:none!important;
    width:27px!important;
    height:27px!important;
    border-radius:7px!important;
}
.pagination-row button.active{border:0!important;}

/* Keep layout stable on hover */
.admin-btn,.admin-date-control,.metric-card,.admin-main-box,.tab-btn,.filter-control,.search-box,.summary-row,.mini-action-row button,.pagination-row button{
    transform:none!important;
    transition:background-color .15s ease,color .15s ease,border-color .15s ease,box-shadow .15s ease!important;
}
.admin-btn:hover,.admin-date-control:hover,.metric-card:hover,.admin-main-box:hover,.tab-btn:hover,.filter-control:hover,.search-box:hover,.summary-row:hover,.mini-action-row button:hover,.pagination-row button:hover{
    transform:none!important;
}

@media(max-width:1200px){
    .admin-head-actions{width:100%!important;max-width:438px!important;}
    .orders-layout-grid{grid-template-columns:1fr!important;}
    .side-stack,.side-card,.quick-actions-card{width:100%!important;max-width:none!important;}
}
@media(max-width:760px){
    .admin-page-head{flex-direction:column!important;}
    .admin-head-actions{max-width:none!important;grid-template-columns:1fr 1fr!important;grid-template-areas:"date date" "export create"!important;}
    .search-box{width:100%!important;}
}
</style>

<style>
/* V9 FINAL: button width consistency, unified filters, fixed select hover, compact quick actions */
:root{
    --soft-border:#dbe3ee;
    --soft-border-2:#e4eaf2;
    --black-border:#050816;
}

/* Header actions: push to far right, date on top, Export/Create below */
.orders-admin-shell .admin-page-head{
    align-items:flex-start!important;
    justify-content:space-between!important;
    gap:24px!important;
}
.orders-admin-shell .admin-head-actions{
    margin-left:auto!important;
    justify-self:end!important;
    align-self:flex-start!important;
    width:392px!important;
    max-width:392px!important;
    min-width:392px!important;
    display:grid!important;
    grid-template-columns:1fr 1fr!important;
    grid-template-areas:"date date" "export create"!important;
    gap:8px!important;
}
.orders-admin-shell .admin-date-control{
    grid-area:date!important;
    width:100%!important;
    justify-content:space-between!important;
    border:1px solid var(--soft-border)!important;
    background:#fff!important;
}
.orders-admin-shell .admin-head-actions .admin-btn-outline{grid-area:export!important;width:100%!important;}
.orders-admin-shell .admin-head-actions .admin-btn-primary{grid-area:create!important;width:100%!important;}

/* Same base width for Export, Create, Filter and status tabs */
.orders-admin-shell .admin-btn,
.orders-admin-shell .tab-btn,
.orders-admin-shell .filter-btn{
    width:118px!important;
    min-width:118px!important;
    max-width:118px!important;
    height:36px!important;
    min-height:36px!important;
    padding:0 10px!important;
    border-radius:8px!important;
    font-size:12px!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:7px!important;
    white-space:nowrap!important;
}
.orders-admin-shell .tab-btn b{
    margin-left:4px!important;
    padding:2px 7px!important;
    min-width:24px!important;
    text-align:center!important;
}
.orders-admin-shell .admin-btn-primary,
.orders-admin-shell .tab-btn.active,
.orders-admin-shell .pagination-row button.active{
    background:linear-gradient(135deg,#1e7bff 0%,#0b63f6 55%,#0647bd 100%)!important;
    color:#fff!important;
    border:1px solid transparent!important;
}
.orders-admin-shell .admin-btn-primary:hover,
.orders-admin-shell .tab-btn.active:hover,
.orders-admin-shell .pagination-row button.active:hover{
    background:#050816!important;
    color:#fff!important;
}
.orders-admin-shell .admin-btn-outline,
.orders-admin-shell .tab-btn:not(.active),
.orders-admin-shell .filter-btn{
    background:#fff!important;
    border:1px solid var(--soft-border)!important;
    color:#050816!important;
}
.orders-admin-shell .admin-btn-outline:hover,
.orders-admin-shell .tab-btn:not(.active):hover,
.orders-admin-shell .filter-btn:hover{
    background:#050816!important;
    color:#fff!important;
    border-color:#050816!important;
}

/* Search aligned with filter */
.orders-admin-shell .search-filter-actions{
    gap:10px!important;
    align-items:center!important;
}
.orders-admin-shell .search-box{
    height:36px!important;
    min-height:36px!important;
    width:360px!important;
    border:1px solid var(--soft-border)!important;
    background:#fff!important;
    border-radius:8px!important;
    padding:0 11px!important;
}
.orders-admin-shell .search-box:hover{
    background:#fff!important;
    color:#050816!important;
    border-color:#b9c4d3!important;
}

/* More breathing room between main rows */
.orders-admin-shell .metric-grid{margin-bottom:22px!important;gap:15px!important;}
.orders-admin-shell .analytics-grid{margin-bottom:26px!important;gap:18px!important;}
.orders-admin-shell .tab-search-row{margin-bottom:14px!important;gap:15px!important;align-items:center!important;}
.orders-admin-shell .filter-row{margin-bottom:20px!important;}
.orders-admin-shell .orders-layout-grid{gap:18px!important;}

/* Light/subtle box borders except table */
.orders-admin-shell .admin-main-box:not(.table-card),
.orders-admin-shell .performance-card,
.orders-admin-shell .donut-card{
    border:1px solid var(--soft-border)!important;
    box-shadow:0 6px 16px rgba(15,23,42,.045)!important;
    background:#fff!important;
}
.orders-admin-shell .performance-card:hover,
.orders-admin-shell .donut-card:hover{
    background:#f9fafb!important;
    border-color:#cfd8e6!important;
}
.orders-admin-shell .table-card{
    border:1.5px solid var(--black-border)!important;
    background:#fff!important;
}

/* Unified filter box: Date Range + Status + Payment + Fulfillment in one container */
.orders-admin-shell .filter-row{
    display:flex!important;
    flex-wrap:wrap!important;
    gap:0!important;
    width:max-content!important;
    max-width:100%!important;
    border:1px solid var(--soft-border)!important;
    border-radius:8px!important;
    overflow:visible!important;
    background:#fff!important;
}
.orders-admin-shell .filter-control{
    width:210px!important;
    min-width:210px!important;
    height:36px!important;
    min-height:36px!important;
    border:0!important;
    border-right:1px solid var(--soft-border-2)!important;
    border-radius:0!important;
    background:#fff!important;
    color:#050816!important;
    padding:0 11px!important;
    gap:8px!important;
}
.orders-admin-shell .filter-control:first-child{border-radius:8px 0 0 8px!important;}
.orders-admin-shell .filter-control:last-child{border-right:0!important;border-radius:0 8px 8px 0!important;}
.orders-admin-shell .filter-control:hover,
.orders-admin-shell .filter-control:focus-within{
    background:#f8fafc!important;
    color:#050816!important;
    border-color:var(--soft-border-2)!important;
}
.orders-admin-shell .filter-control span{
    font-size:10.5px!important;
    font-weight:700!important;
    color:#050816!important;
    flex:0 0 auto!important;
}
.orders-admin-shell .filter-control svg{
    width:15px!important;
    height:15px!important;
    color:#050816!important;
    flex:0 0 auto!important;
}
.orders-admin-shell .filter-control select{
    flex:1 1 auto!important;
    min-width:0!important;
    max-width:none!important;
    width:100%!important;
    height:34px!important;
    color:#050816!important;
    background:#fff!important;
    border:0!important;
    outline:0!important;
    box-shadow:none!important;
    font-size:12px!important;
    font-weight:700!important;
    cursor:pointer!important;
    appearance:auto!important;
}
.orders-admin-shell .filter-control select:hover,
.orders-admin-shell .filter-control select:focus{
    background:#fff!important;
    color:#050816!important;
}
.orders-admin-shell .filter-control select option{
    background:#fff!important;
    color:#050816!important;
    font-family:'Inter',sans-serif!important;
    font-size:12px!important;
}
.orders-admin-shell .filter-control select option:checked{
    background:#eaf2ff!important;
    color:#050816!important;
}

/* Right panel: narrower actions + tighter gaps */
.orders-admin-shell .orders-layout-grid{
    grid-template-columns:minmax(0,1fr) 224px!important;
}
.orders-admin-shell .side-stack,
.orders-admin-shell .side-card,
.orders-admin-shell .quick-actions-card{
    width:224px!important;
    max-width:224px!important;
}
.orders-admin-shell .order-summary-card{margin-bottom:22px!important;}
.orders-admin-shell .quick-actions-card{
    gap:0!important;
}
.orders-admin-shell .quick-actions-card .full-btn{
    width:190px!important;
    min-width:190px!important;
    max-width:190px!important;
    height:33px!important;
    min-height:33px!important;
    margin:0 0 7px 0!important;
    padding:0 10px!important;
    border-radius:8px!important;
    font-size:12px!important;
}
.orders-admin-shell .quick-actions-card .admin-btn-primary{
    width:190px!important;
    min-width:190px!important;
    max-width:190px!important;
}

/* Keep action icons/pagination simple and stable */
.orders-admin-shell .mini-action-row button,
.orders-admin-shell .pagination-row button{
    border:0!important;
    background:transparent!important;
    box-shadow:none!important;
}
.orders-admin-shell .mini-action-row button:hover,
.orders-admin-shell .pagination-row button:hover{
    background:#050816!important;
    color:#fff!important;
}

@media(max-width:1200px){
    .orders-admin-shell .admin-head-actions{width:100%!important;max-width:392px!important;min-width:0!important;}
    .orders-admin-shell .orders-layout-grid{grid-template-columns:1fr!important;}
    .orders-admin-shell .side-stack,.orders-admin-shell .side-card,.orders-admin-shell .quick-actions-card{width:100%!important;max-width:none!important;}
    .orders-admin-shell .quick-actions-card .full-btn{width:190px!important;}
}
@media(max-width:880px){
    .orders-admin-shell .filter-row{width:100%!important;}
    .orders-admin-shell .filter-control{width:50%!important;min-width:50%!important;border-bottom:1px solid var(--soft-border-2)!important;}
    .orders-admin-shell .filter-control:nth-child(2){border-right:0!important;}
    .orders-admin-shell .filter-control:nth-child(3),.orders-admin-shell .filter-control:nth-child(4){border-bottom:0!important;}
}
@media(max-width:760px){
    .orders-admin-shell .admin-head-actions{max-width:none!important;grid-template-columns:1fr 1fr!important;}
    .orders-admin-shell .search-box{width:100%!important;}
    .orders-admin-shell .admin-btn,.orders-admin-shell .tab-btn,.orders-admin-shell .filter-btn{width:112px!important;min-width:112px!important;}
}
</style>


<style>
/* V10 FINAL EXACT PATCH: action colors, wider unified filters, clean modal template */
.orders-admin-shell{position:relative!important;}
/* remove any floating/decorative side indicator dots */
.orders-admin-shell::before,.orders-admin-shell::after{display:none!important;content:none!important;}
.orders-admin-shell .clickable-main-box::after{display:none!important;content:none!important;}

/* Header export/create together */
.orders-admin-shell .admin-head-actions{
    width:392px!important;max-width:392px!important;min-width:392px!important;
    grid-template-columns:1fr 1fr!important;grid-template-areas:"date date" "export create"!important;
    gap:8px!important;margin-left:auto!important;justify-content:end!important;
}
.orders-admin-shell .admin-head-actions .admin-btn-outline,
.orders-admin-shell .admin-head-actions .admin-btn-primary{width:100%!important;min-width:0!important;max-width:none!important;}

/* Metric cards: only border line carries color, inside remains white */
.orders-admin-shell .metric-card{background:#fff!important;box-shadow:0 4px 10px rgba(15,23,42,.025)!important;}
.orders-admin-shell .metric-card:has(.blue-soft){border-color:#b8d4ff!important;background:#fff!important;}
.orders-admin-shell .metric-card:has(.orange-soft){border-color:#ffd89a!important;background:#fff!important;}
.orders-admin-shell .metric-card:has(.cyan-soft){border-color:#d5c1ff!important;background:#fff!important;}
.orders-admin-shell .metric-card:has(.green-soft){border-color:#bdebd3!important;background:#fff!important;}
.orders-admin-shell .metric-card:has(.red-soft){border-color:#ffc7c7!important;background:#fff!important;}
.orders-admin-shell .metric-card:hover{background:#f7f8fa!important;}
.orders-admin-shell .metric-card .metric-copy p .dot{width:9px!important;height:9px!important;position:static!important;box-shadow:none!important;}
.orders-admin-shell .metric-card:before,.orders-admin-shell .metric-card:after{display:none!important;content:none!important;}

/* Tabs: same width but count badge has NO background */
.orders-admin-shell .tab-btn{width:118px!important;min-width:118px!important;max-width:118px!important;justify-content:center!important;}
.orders-admin-shell .tab-btn b,
.orders-admin-shell .tab-btn.active b{background:transparent!important;border:0!important;color:inherit!important;padding:0!important;margin-left:5px!important;min-width:auto!important;}

/* Search: one icon only + a bit narrower */
.orders-admin-shell .search-box{width:330px!important;max-width:330px!important;height:36px!important;min-height:36px!important;gap:10px!important;}
.orders-admin-shell .search-box svg:last-child{display:none!important;}
.orders-admin-shell .search-box input{font-size:12px!important;}

/* Filter row: one unified box stretched to table width */
.orders-admin-shell .filter-row{
    width:calc(100% - 242px)!important;
    max-width:calc(100% - 242px)!important;
    display:grid!important;
    grid-template-columns:1.18fr 1fr 1.12fr 1.12fr!important;
    gap:0!important;
    border:1px solid #dbe3ee!important;
    border-radius:8px!important;
    overflow:visible!important;
    background:#fff!important;
    margin-bottom:22px!important;
}
.orders-admin-shell .filter-control{width:100%!important;min-width:0!important;max-width:none!important;height:36px!important;border:0!important;border-right:1px solid #e4eaf2!important;border-radius:0!important;background:#fff!important;padding:0 12px!important;}
.orders-admin-shell .filter-control:first-child{border-radius:8px 0 0 8px!important;}
.orders-admin-shell .filter-control:last-child{border-right:0!important;border-radius:0 8px 8px 0!important;}
.orders-admin-shell .filter-control select{width:100%!important;max-width:none!important;color:#050816!important;background:#fff!important;overflow:visible!important;text-overflow:clip!important;}
.orders-admin-shell .filter-control select option{background:#fff!important;color:#050816!important;}
.orders-admin-shell .filter-control select option:hover,.orders-admin-shell .filter-control select option:checked{background:#eef5ff!important;color:#050816!important;}
.orders-admin-shell .filter-control:hover,.orders-admin-shell .filter-control:focus-within{background:#f8fafc!important;color:#050816!important;}

/* Action icons: no hover background; color only */
.orders-admin-shell .mini-action-row{gap:8px!important;}
.orders-admin-shell .mini-action-row button{background:transparent!important;border:0!important;box-shadow:none!important;border-radius:0!important;width:18px!important;height:18px!important;color:#050816!important;padding:0!important;}
.orders-admin-shell .mini-action-row button svg{width:15px!important;height:15px!important;stroke-width:2.15!important;}
.orders-admin-shell .mini-action-row button:nth-child(1){color:#050816!important;}
.orders-admin-shell .mini-action-row button:nth-child(2){color:#0f9f63!important;}
.orders-admin-shell .mini-action-row button:nth-child(3){color:#0b63f6!important;}
.orders-admin-shell .mini-action-row button:nth-child(4){color:#050816!important;}
.orders-admin-shell .mini-action-row button:hover{background:transparent!important;border:0!important;box-shadow:none!important;}
.orders-admin-shell .mini-action-row button:nth-child(1):hover{color:#111827!important;}
.orders-admin-shell .mini-action-row button:nth-child(2):hover{color:#087a4a!important;}
.orders-admin-shell .mini-action-row button:nth-child(3):hover{color:#0647bd!important;}
.orders-admin-shell .mini-action-row button:nth-child(4):hover{color:#475467!important;}

/* Right side quick action buttons: keep compact */
.orders-admin-shell .quick-actions-card .full-btn{width:180px!important;min-width:180px!important;max-width:180px!important;height:32px!important;min-height:32px!important;margin-bottom:6px!important;}

/* Modal closer to reference, template only */
.orders-admin-shell .order-details-modal{width:min(820px,94vw)!important;border:1.5px solid #050816!important;border-radius:12px!important;box-shadow:0 24px 70px rgba(5,8,22,.26)!important;}
.orders-admin-shell .modal-title-row{height:58px!important;padding:0 24px!important;border-bottom:1px solid #e2e8f0!important;}
.orders-admin-shell .template-exact-grid{padding:18px 24px 12px!important;gap:12px!important;}
.orders-admin-shell .modal-mini-card,.orders-admin-shell .modal-items-card{border:1px solid #dbe3ee!important;background:#fff!important;border-radius:9px!important;box-shadow:none!important;}
.orders-admin-shell .template-avatar{width:44px;height:44px;border-radius:50%;background:#eef2f7;color:#64748b;display:grid;place-items:center;}
.orders-admin-shell .template-avatar svg{width:22px;height:22px;}
.orders-admin-shell .template-muted{display:block;color:#64748b;font-size:11px;margin:2px 0 8px;}
.orders-admin-shell .template-pill{width:max-content;min-height:22px;padding:3px 10px;}
.orders-admin-shell .template-status-strip{margin:0 24px 12px!important;border:1px solid #dbe3ee!important;border-radius:9px!important;background:#fff!important;}
.orders-admin-shell .template-status-strip>div{padding:13px 14px!important;border-right:1px solid #e8edf5!important;}
.orders-admin-shell .template-status-strip>div:last-child{border-right:0!important;}
.orders-admin-shell .template-items-card{margin:0 24px 14px!important;padding:15px!important;}
.orders-admin-shell .template-items-card table{width:100%;border-collapse:collapse;}
.orders-admin-shell .template-items-card th{height:38px;background:#fbfcfe!important;border-bottom:1px solid #dbe3ee!important;color:#475467!important;text-transform:uppercase;font-size:10px!important;}
.orders-admin-shell .template-items-card td{height:42px;border-bottom:1px solid #eef2f7!important;font-weight:600!important;}
.orders-admin-shell .template-img{display:inline-block;width:30px;height:30px;border-radius:4px;border:1px solid #dbe3ee;background:#f1f5f9;vertical-align:middle;margin-right:8px;}
.orders-admin-shell .template-bottom-grid{padding:0 24px 24px!important;gap:12px!important;}
.orders-admin-shell .modal-actions-card{align-items:stretch!important;}
.orders-admin-shell .modal-actions-card .admin-btn{width:100%!important;max-width:none!important;min-width:0!important;height:36px!important;}
.orders-admin-shell .modal-template-actions{display:none!important;}

@media(max-width:1200px){
  .orders-admin-shell .filter-row{width:100%!important;max-width:100%!important;}
}
@media(max-width:880px){
  .orders-admin-shell .filter-row{grid-template-columns:1fr 1fr!important;}
  .orders-admin-shell .filter-control:nth-child(2){border-right:0!important;}
  .orders-admin-shell .filter-control:nth-child(3),.orders-admin-shell .filter-control:nth-child(4){border-top:1px solid #e4eaf2!important;}
}
@media(max-width:760px){
  .orders-admin-shell .search-box{width:100%!important;max-width:100%!important;}
  .orders-admin-shell .filter-row{grid-template-columns:1fr!important;}
  .orders-admin-shell .filter-control{border-right:0!important;border-bottom:1px solid #e4eaf2!important;}
  .orders-admin-shell .filter-control:last-child{border-bottom:0!important;}
}
</style>

<style id="orders-blue-gradient-calendar-final-patch">
/* FINAL REQUEST PATCH: Blue gradient button style/shape/size + working calendar UI */
.orders-admin-shell{
    --orders-blue:#0b63f6;
    --orders-blue-mid:#0d66f2;
    --orders-blue-dark:#0647bd;
    --orders-black:#050816;
    --orders-soft-line:#dbe3ee;
    --orders-green-start:#22c55e;
    --orders-green-end:#0f9f63;
}
.orders-admin-shell .admin-head-actions{
    margin-left:auto!important;
    width:392px!important;
    max-width:392px!important;
    min-width:392px!important;
    display:grid!important;
    grid-template-columns:1fr 1fr!important;
    grid-template-areas:"date date" "export create"!important;
    gap:8px!important;
    justify-content:end!important;
}
.orders-admin-shell .admin-date-control{
    grid-area:date!important;
    width:100%!important;
    min-width:0!important;
    height:38px!important;
    min-height:38px!important;
    padding:0 14px!important;
    border-radius:8px!important;
    border:1.5px solid var(--orders-black)!important;
    background:#fff!important;
    background-image:none!important;
    color:var(--orders-black)!important;
    box-shadow:none!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:space-between!important;
    gap:10px!important;
    font-size:12.5px!important;
    font-weight:700!important;
    white-space:nowrap!important;
    cursor:pointer!important;
}
.orders-admin-shell .admin-date-control:hover,
.orders-admin-shell .admin-date-control:focus{
    background:var(--orders-black)!important;
    border-color:var(--orders-black)!important;
    color:#fff!important;
}
.orders-admin-shell .admin-date-control svg{width:16px!important;height:16px!important;stroke:currentColor!important;}
.orders-admin-shell .admin-btn,
.orders-admin-shell .filter-btn,
.orders-admin-shell .full-btn,
.orders-admin-shell .tab-btn,
.orders-admin-shell .orders-calendar-action-btn,
.orders-admin-shell .orders-calendar-save-btn,
.orders-admin-shell .orders-calendar-clear-btn,
.orders-admin-shell .orders-calendar-mini-btn{
    height:36px!important;
    min-height:36px!important;
    min-width:118px!important;
    padding:0 14px!important;
    border-radius:999px!important;
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:12px!important;
    font-weight:600!important;
    line-height:1!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:7px!important;
    white-space:nowrap!important;
    box-shadow:none!important;
    transform:none!important;
    transition:background .16s ease,color .16s ease,border-color .16s ease,box-shadow .16s ease!important;
}
.orders-admin-shell .admin-head-actions .admin-btn-outline{grid-area:export!important;width:100%!important;min-width:0!important;max-width:none!important;}
.orders-admin-shell .admin-head-actions .admin-btn-primary{grid-area:create!important;width:100%!important;min-width:0!important;max-width:none!important;}
.orders-admin-shell .admin-btn-primary,
.orders-admin-shell .tab-btn.active,
.orders-admin-shell .pagination-row button.active,
.orders-admin-shell .quick-actions-card .admin-btn-primary,
.orders-admin-shell .orders-calendar-action-btn{
    background:linear-gradient(135deg,var(--orders-blue) 0%,var(--orders-blue-mid) 52%,var(--orders-blue-dark) 100%)!important;
    background-image:linear-gradient(135deg,var(--orders-blue) 0%,var(--orders-blue-mid) 52%,var(--orders-blue-dark) 100%)!important;
    color:#fff!important;
    border:1.5px solid transparent!important;
}
.orders-admin-shell .admin-btn-outline,
.orders-admin-shell .filter-btn,
.orders-admin-shell .full-btn:not(.admin-btn-primary),
.orders-admin-shell .tab-btn:not(.active),
.orders-admin-shell .orders-calendar-clear-btn,
.orders-admin-shell .orders-calendar-mini-btn{
    background:#fff!important;
    background-image:none!important;
    color:var(--orders-black)!important;
    border:1.5px solid var(--orders-black)!important;
}
.orders-admin-shell .admin-btn:hover,
.orders-admin-shell .admin-btn:focus,
.orders-admin-shell .filter-btn:hover,
.orders-admin-shell .filter-btn:focus,
.orders-admin-shell .full-btn:hover,
.orders-admin-shell .full-btn:focus,
.orders-admin-shell .tab-btn:hover,
.orders-admin-shell .tab-btn:focus,
.orders-admin-shell .orders-calendar-action-btn:hover,
.orders-admin-shell .orders-calendar-action-btn:focus,
.orders-admin-shell .orders-calendar-clear-btn:hover,
.orders-admin-shell .orders-calendar-clear-btn:focus,
.orders-admin-shell .orders-calendar-mini-btn:hover,
.orders-admin-shell .orders-calendar-mini-btn:focus{
    background:var(--orders-black)!important;
    background-image:none!important;
    color:#fff!important;
    border-color:var(--orders-black)!important;
    box-shadow:none!important;
    transform:none!important;
}
.orders-admin-shell .orders-calendar-save-btn{
    background:linear-gradient(135deg,var(--orders-green-start) 0%,var(--orders-green-end) 100%)!important;
    background-image:linear-gradient(135deg,var(--orders-green-start) 0%,var(--orders-green-end) 100%)!important;
    color:#fff!important;
    border:1.5px solid transparent!important;
}
.orders-admin-shell .orders-calendar-save-btn:hover,
.orders-admin-shell .orders-calendar-save-btn:focus{
    background:var(--orders-black)!important;
    background-image:none!important;
    color:#fff!important;
    border-color:var(--orders-black)!important;
}
.orders-admin-shell .quick-actions-card .full-btn{
    width:190px!important;
    max-width:190px!important;
    min-width:190px!important;
    height:34px!important;
    min-height:34px!important;
    margin:0 0 8px!important;
    border-radius:999px!important;
}
.orders-admin-shell .tab-btn b,
.orders-admin-shell .tab-btn.active b{background:transparent!important;color:inherit!important;border:0!important;padding:0!important;margin-left:5px!important;}
.orders-calendar-overlay{
    position:fixed;
    inset:0;
    z-index:7000;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:18px;
    background:rgba(5,8,22,.38);
    backdrop-filter:blur(9px);
}
.orders-calendar-modal{
    width:min(920px,100%);
    max-height:calc(100vh - 36px);
    overflow:hidden;
    border:1px solid var(--orders-soft-line);
    border-radius:18px;
    background:#fff;
    box-shadow:0 26px 80px rgba(15,23,42,.22);
    display:grid;
    grid-template-columns:minmax(0,1.1fr) 310px;
    color:var(--orders-black);
}
.orders-calendar-main{padding:18px;border-right:1px solid var(--orders-soft-line);min-width:0;}
.orders-calendar-side{padding:18px;background:#fbfbfb;min-width:0;}
.orders-calendar-top{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px;}
.orders-calendar-title{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:16px;font-weight:700;color:var(--orders-black);}
.orders-calendar-subtitle{margin:3px 0 0;font-size:11px;font-weight:400;color:#667085;line-height:1.45;}
.orders-calendar-nav{display:flex;align-items:center;gap:7px;}
.orders-calendar-icon-btn{
    width:34px!important;
    height:34px!important;
    min-width:34px!important;
    padding:0!important;
    border:1px solid var(--orders-soft-line)!important;
    border-radius:9px!important;
    background:#fff!important;
    color:var(--orders-black)!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    cursor:pointer!important;
}
.orders-calendar-icon-btn:hover{background:var(--orders-black)!important;color:#fff!important;border-color:var(--orders-black)!important;}
.orders-calendar-icon-btn svg{width:16px;height:16px;stroke:currentColor;}
.orders-calendar-weekdays,.orders-calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:7px;}
.orders-calendar-weekdays{margin-bottom:7px;}
.orders-calendar-weekdays span{text-align:center;font-size:9.5px;font-weight:800;color:#667085;letter-spacing:.08em;text-transform:uppercase;}
.orders-calendar-day{position:relative;min-height:78px;border:1px solid var(--orders-soft-line);border-radius:12px;background:#fff;padding:8px;text-align:left;color:var(--orders-black);cursor:pointer;transition:.18s;overflow:hidden;}
.orders-calendar-day:hover,.orders-calendar-day:focus{border-color:var(--orders-blue);box-shadow:0 10px 24px rgba(11,99,246,.10);}
.orders-calendar-day.is-muted{background:#fafafa;color:#a1a1aa;cursor:default;}
.orders-calendar-day.is-today{border-color:var(--orders-blue);background:#eaf2ff;}
.orders-calendar-day.is-selected{border-color:var(--orders-black);background:rgba(17,24,39,.08);box-shadow:inset 0 0 0 1px var(--orders-black);}
.orders-calendar-day-number{display:block;font-size:12px;font-weight:800;line-height:1;}
.orders-calendar-day-events{display:flex;flex-wrap:wrap;gap:4px;margin-top:17px;}
.orders-calendar-event-dot{width:7px;height:7px;border-radius:999px;background:var(--orders-blue);box-shadow:0 0 0 3px rgba(11,99,246,.10);}
.orders-calendar-more{font-style:normal;font-size:9px;font-weight:700;color:#667085;line-height:1;}
.orders-calendar-selected-date{margin:0 0 12px;font-family:'Poppins',system-ui,sans-serif;font-size:15px;font-weight:700;color:var(--orders-black);}
.orders-calendar-event-list{display:grid;gap:8px;max-height:182px;overflow:auto;padding-right:2px;margin-bottom:13px;}
.orders-calendar-event-item{border:1px solid var(--orders-soft-line);border-radius:12px;background:#fff;padding:10px;display:grid;gap:7px;}
.orders-calendar-event-title{font-size:12px;font-weight:800;color:var(--orders-black);line-height:1.3;}
.orders-calendar-event-meta{font-size:10px;font-weight:700;color:var(--orders-blue);line-height:1.35;}
.orders-calendar-event-note{font-size:10.5px;font-weight:400;color:#667085;line-height:1.45;margin:0;}
.orders-calendar-event-actions{display:flex;gap:6px;justify-content:flex-end;}
.orders-calendar-mini-btn{height:27px!important;min-height:27px!important;min-width:auto!important;padding:0 9px!important;font-size:9.5px!important;border-radius:8px!important;}
.orders-calendar-mini-btn.danger{border-color:#ef4444!important;color:#ef4444!important;}
.orders-calendar-mini-btn.danger:hover{background:#ef4444!important;border-color:#ef4444!important;color:#fff!important;}
.orders-calendar-form{display:grid;gap:9px;}
.orders-calendar-field{display:grid;gap:5px;}
.orders-calendar-field span{font-size:10px;font-weight:800;color:#4b5563;letter-spacing:.05em;text-transform:uppercase;}
.orders-calendar-field input,.orders-calendar-field textarea{width:100%;border:1px solid var(--orders-soft-line);border-radius:10px;background:#fff;padding:10px 11px;color:var(--orders-black);font-family:'Inter',system-ui,sans-serif;font-size:12px;font-weight:500;outline:none;transition:.18s;}
.orders-calendar-field textarea{min-height:68px;resize:vertical;}
.orders-calendar-field input:focus,.orders-calendar-field textarea:focus{border-color:var(--orders-blue);box-shadow:0 0 0 3px rgba(11,99,246,.10);}
.orders-calendar-form-actions{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:2px;}
.orders-calendar-clear-btn{width:82px!important;min-width:82px!important;height:36px!important;}
.orders-calendar-save-btn{flex:1!important;min-width:0!important;height:36px!important;}
.orders-calendar-empty{min-height:74px;border:1px dashed #d0d7e2;border-radius:12px;display:grid;place-items:center;text-align:center;color:#667085;font-size:11px;font-weight:500;line-height:1.45;padding:12px;background:#fff;}
@media(max-width:820px){.orders-calendar-modal{grid-template-columns:1fr;overflow:auto}.orders-calendar-main{border-right:0;border-bottom:1px solid var(--orders-soft-line)}.orders-calendar-day{min-height:62px}.orders-calendar-side{background:#fff}}
@media(max-width:760px){.orders-admin-shell .admin-head-actions{width:100%!important;min-width:0!important;max-width:none!important;grid-template-columns:1fr 1fr!important}.orders-admin-shell .admin-btn,.orders-admin-shell .tab-btn,.orders-admin-shell .filter-btn{min-width:112px!important;width:auto!important}.orders-admin-shell .quick-actions-card .full-btn{width:100%!important;max-width:none!important}}
</style>




<style id="orders-final-kbm-dashboard-customer-patch">
/* =========================================================
   FINAL PATCH - Orders Overview
   Requested:
   - Order Performance, Order Status Breakdown, Fulfillment Overview:
     same box color/style as Knowledge Base Management
   - Date Range/filter box:
     same box color/style as Knowledge Base Management
   - Calendar/date shape/style:
     same as Dashboard
   - Buttons:
     same size/style as Dashboard/Customer
   ========================================================= */
.orders-admin-shell{
    --kbm-box-bg:#ffffff;
    --kbm-box-border:#050816;
    --kbm-box-radius:14px;
    --kbm-box-shadow:0 8px 22px rgba(5,8,22,.055);
    --dash-blue:#0b63f6;
    --dash-blue-mid:#0d66f2;
    --dash-blue-dark:#0647bd;
    --dash-black:#050816;
}

/* Header calendar/date - Dashboard style */
.orders-admin-shell .admin-head-actions{
    margin-left:auto!important;
    width:392px!important;
    max-width:392px!important;
    min-width:392px!important;
    display:grid!important;
    grid-template-columns:1fr 1fr!important;
    grid-template-areas:
        "date date"
        "export create"!important;
    gap:10px!important;
    align-items:stretch!important;
    justify-content:end!important;
}
.orders-admin-shell .admin-date-control{
    grid-area:date!important;
    width:100%!important;
    min-width:0!important;
    height:42px!important;
    min-height:42px!important;
    padding:0 16px!important;
    border-radius:8px!important;
    border:1.5px solid var(--dash-black)!important;
    background:#fff!important;
    background-image:none!important;
    color:var(--dash-black)!important;
    box-shadow:none!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:space-between!important;
    gap:10px!important;
    font-family:'Inter',system-ui,sans-serif!important;
    font-size:12px!important;
    font-weight:700!important;
    line-height:1!important;
    white-space:nowrap!important;
}
.orders-admin-shell .admin-date-control span{
    flex:1!important;
    text-align:center!important;
    overflow:hidden!important;
    text-overflow:ellipsis!important;
    white-space:nowrap!important;
}
.orders-admin-shell .admin-date-control svg{
    width:16px!important;
    height:16px!important;
    stroke:currentColor!important;
}
.orders-admin-shell .admin-date-control:hover,
.orders-admin-shell .admin-date-control:focus{
    background:var(--dash-black)!important;
    color:#fff!important;
    border-color:var(--dash-black)!important;
}

/* Dashboard/Customer button sizing and style */
.orders-admin-shell .admin-btn,
.orders-admin-shell .filter-btn,
.orders-admin-shell .full-btn,
.orders-admin-shell .tab-btn,
.orders-admin-shell .orders-calendar-action-btn,
.orders-admin-shell .orders-calendar-save-btn,
.orders-admin-shell .orders-calendar-clear-btn,
.orders-admin-shell .orders-calendar-mini-btn{
    height:40px!important;
    min-height:40px!important;
    min-width:128px!important;
    padding:0 16px!important;
    border-radius:999px!important;
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:12px!important;
    font-weight:600!important;
    line-height:1!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:8px!important;
    white-space:nowrap!important;
    box-shadow:none!important;
    transform:none!important;
    transition:background .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease!important;
}
.orders-admin-shell .admin-head-actions .admin-btn-outline{
    grid-area:export!important;
    width:100%!important;
    min-width:0!important;
    max-width:none!important;
}
.orders-admin-shell .admin-head-actions .admin-btn-primary{
    grid-area:create!important;
    width:100%!important;
    min-width:0!important;
    max-width:none!important;
}
.orders-admin-shell .admin-btn-primary,
.orders-admin-shell .tab-btn.active,
.orders-admin-shell .pagination-row button.active,
.orders-admin-shell .quick-actions-card .admin-btn-primary,
.orders-admin-shell .orders-calendar-action-btn,
.orders-admin-shell .orders-calendar-save-btn{
    background:linear-gradient(135deg,var(--dash-blue) 0%,var(--dash-blue-mid) 52%,var(--dash-blue-dark) 100%)!important;
    background-image:linear-gradient(135deg,var(--dash-blue) 0%,var(--dash-blue-mid) 52%,var(--dash-blue-dark) 100%)!important;
    color:#fff!important;
    border:1.5px solid transparent!important;
}
.orders-admin-shell .admin-btn-outline,
.orders-admin-shell .filter-btn,
.orders-admin-shell .full-btn:not(.admin-btn-primary),
.orders-admin-shell .tab-btn:not(.active),
.orders-admin-shell .orders-calendar-clear-btn,
.orders-admin-shell .orders-calendar-mini-btn{
    background:#fff!important;
    background-image:none!important;
    color:var(--dash-black)!important;
    border:1.5px solid var(--dash-black)!important;
}
.orders-admin-shell .admin-btn:hover,
.orders-admin-shell .admin-btn:focus,
.orders-admin-shell .filter-btn:hover,
.orders-admin-shell .filter-btn:focus,
.orders-admin-shell .full-btn:hover,
.orders-admin-shell .full-btn:focus,
.orders-admin-shell .tab-btn:hover,
.orders-admin-shell .tab-btn:focus,
.orders-admin-shell .orders-calendar-action-btn:hover,
.orders-admin-shell .orders-calendar-action-btn:focus,
.orders-admin-shell .orders-calendar-save-btn:hover,
.orders-admin-shell .orders-calendar-save-btn:focus,
.orders-admin-shell .orders-calendar-clear-btn:hover,
.orders-admin-shell .orders-calendar-clear-btn:focus,
.orders-admin-shell .orders-calendar-mini-btn:hover,
.orders-admin-shell .orders-calendar-mini-btn:focus{
    background:var(--dash-black)!important;
    background-image:none!important;
    color:#fff!important;
    border-color:var(--dash-black)!important;
    box-shadow:none!important;
    transform:none!important;
}
.orders-admin-shell .admin-btn svg,
.orders-admin-shell .filter-btn svg,
.orders-admin-shell .full-btn svg,
.orders-admin-shell .tab-btn svg{
    width:16px!important;
    height:16px!important;
    stroke:currentColor!important;
}

/* Knowledge Base Management box style for analytics cards */
.orders-admin-shell .analytics-grid{
    gap:16px!important;
    margin-bottom:24px!important;
    align-items:stretch!important;
}
.orders-admin-shell .analytics-grid .admin-main-box,
.orders-admin-shell .performance-card,
.orders-admin-shell .donut-card{
    background:var(--kbm-box-bg)!important;
    border:1.5px solid var(--kbm-box-border)!important;
    border-radius:var(--kbm-box-radius)!important;
    box-shadow:var(--kbm-box-shadow)!important;
    color:var(--dash-black)!important;
}
.orders-admin-shell .analytics-grid .admin-main-box:hover,
.orders-admin-shell .performance-card:hover,
.orders-admin-shell .donut-card:hover{
    background:rgba(17,24,39,.06)!important;
    border-color:var(--kbm-box-border)!important;
    box-shadow:var(--kbm-box-shadow)!important;
    transform:none!important;
}

/* Keep analytics compact but readable */
.orders-admin-shell .performance-card,
.orders-admin-shell .donut-card{
    height:190px!important;
    min-height:190px!important;
    padding:17px 18px!important;
    overflow:hidden!important;
}
.orders-admin-shell .analytics-grid h2,
.orders-admin-shell .card-top-row h2,
.orders-admin-shell .donut-card h2{
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:15px!important;
    font-weight:600!important;
    margin:0 0 12px!important;
    color:var(--dash-black)!important;
}
.orders-admin-shell .line-chart-wrap{
    height:94px!important;
    margin-top:6px!important;
    padding-left:36px!important;
}
.orders-admin-shell .line-chart-wrap svg{
    height:80px!important;
}
.orders-admin-shell .chart-y-axis{
    height:80px!important;
    font-size:10px!important;
}
.orders-admin-shell .chart-x-axis{
    font-size:10px!important;
}
.orders-admin-shell .donut-content{
    height:130px!important;
    gap:18px!important;
    align-items:center!important;
}
.orders-admin-shell .donut{
    width:112px!important;
    height:112px!important;
    flex:0 0 112px!important;
}
.orders-admin-shell .donut>div{
    width:64px!important;
    height:64px!important;
}
.orders-admin-shell .donut>div strong{
    font-size:20px!important;
}
.orders-admin-shell .donut>div span{
    font-size:10px!important;
}
.orders-admin-shell .legend-list{
    gap:9px!important;
}
.orders-admin-shell .legend-row{
    font-size:12px!important;
}
.orders-admin-shell .legend-row strong{
    font-size:12px!important;
}

/* Knowledge Base Management box style for Date Range/filter group */
.orders-admin-shell .filter-row{
    width:calc(100% - 246px)!important;
    max-width:calc(100% - 246px)!important;
    display:grid!important;
    grid-template-columns:1.2fr 1fr 1.1fr 1.1fr!important;
    gap:0!important;
    background:var(--kbm-box-bg)!important;
    border:1.5px solid var(--kbm-box-border)!important;
    border-radius:var(--kbm-box-radius)!important;
    box-shadow:var(--kbm-box-shadow)!important;
    overflow:visible!important;
    margin:0 0 22px!important;
    padding:0!important;
}
.orders-admin-shell .filter-control{
    width:100%!important;
    min-width:0!important;
    max-width:none!important;
    height:42px!important;
    min-height:42px!important;
    padding:0 14px!important;
    border:0!important;
    border-right:1px solid #e7ebf2!important;
    border-radius:0!important;
    background:transparent!important;
    color:var(--dash-black)!important;
    box-shadow:none!important;
    display:flex!important;
    align-items:center!important;
    gap:9px!important;
}
.orders-admin-shell .filter-control:first-child{
    border-radius:var(--kbm-box-radius) 0 0 var(--kbm-box-radius)!important;
}
.orders-admin-shell .filter-control:last-child{
    border-right:0!important;
    border-radius:0 var(--kbm-box-radius) var(--kbm-box-radius) 0!important;
}
.orders-admin-shell .filter-control:hover,
.orders-admin-shell .filter-control:focus-within{
    background:rgba(17,24,39,.06)!important;
    color:var(--dash-black)!important;
}
.orders-admin-shell .filter-control span{
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:11px!important;
    font-weight:600!important;
    color:var(--dash-black)!important;
    white-space:nowrap!important;
}
.orders-admin-shell .filter-control svg{
    width:15px!important;
    height:15px!important;
    color:var(--dash-black)!important;
    flex:0 0 auto!important;
}
.orders-admin-shell .filter-control select{
    flex:1!important;
    min-width:0!important;
    width:100%!important;
    max-width:none!important;
    height:40px!important;
    border:0!important;
    outline:0!important;
    background:#fff!important;
    color:var(--dash-black)!important;
    font-family:'Inter',system-ui,sans-serif!important;
    font-size:12px!important;
    font-weight:700!important;
    cursor:pointer!important;
    appearance:auto!important;
}
.orders-admin-shell .filter-control select option{
    background:#fff!important;
    color:var(--dash-black)!important;
}

/* Search and tab row spacing remains clean */
.orders-admin-shell .tab-search-row{
    margin-bottom:14px!important;
    gap:14px!important;
    align-items:center!important;
}
.orders-admin-shell .search-filter-actions{
    gap:10px!important;
    align-items:center!important;
}
.orders-admin-shell .search-box{
    height:40px!important;
    min-height:40px!important;
    width:360px!important;
    border:1.5px solid var(--dash-black)!important;
    border-radius:9px!important;
    background:#fff!important;
    padding:0 13px!important;
    box-shadow:none!important;
}
.orders-admin-shell .search-box:hover{
    background:#fff!important;
    border-color:var(--dash-black)!important;
    color:var(--dash-black)!important;
}
.orders-admin-shell .search-box input{
    height:38px!important;
    font-size:12px!important;
}
.orders-admin-shell .status-tabs{
    gap:10px!important;
}
.orders-admin-shell .tab-btn b,
.orders-admin-shell .tab-btn.active b{
    background:transparent!important;
    color:inherit!important;
    border:0!important;
    padding:0!important;
    margin-left:5px!important;
}

/* Quick actions follow same dashboard/customer button height, but fit narrow column */
.orders-admin-shell .quick-actions-card .full-btn{
    width:100%!important;
    max-width:none!important;
    min-width:0!important;
    height:40px!important;
    min-height:40px!important;
    margin:0 0 8px!important;
    border-radius:999px!important;
}

/* Calendar popup button consistency */
.orders-admin-shell .orders-calendar-icon-btn{
    border:1.5px solid var(--dash-black)!important;
    border-radius:9px!important;
    background:#fff!important;
    color:var(--dash-black)!important;
}
.orders-admin-shell .orders-calendar-icon-btn:hover,
.orders-admin-shell .orders-calendar-icon-btn:focus{
    background:var(--dash-black)!important;
    color:#fff!important;
    border-color:var(--dash-black)!important;
}

/* Responsive */
@media(max-width:1200px){
    .orders-admin-shell .analytics-grid{
        grid-template-columns:1fr!important;
    }
    .orders-admin-shell .performance-card,
    .orders-admin-shell .donut-card{
        height:auto!important;
        min-height:190px!important;
    }
    .orders-admin-shell .filter-row{
        width:100%!important;
        max-width:100%!important;
    }
}
@media(max-width:880px){
    .orders-admin-shell .filter-row{
        grid-template-columns:1fr 1fr!important;
    }
    .orders-admin-shell .filter-control:nth-child(2){
        border-right:0!important;
    }
    .orders-admin-shell .filter-control:nth-child(3),
    .orders-admin-shell .filter-control:nth-child(4){
        border-top:1px solid #e7ebf2!important;
    }
}
@media(max-width:760px){
    .orders-admin-shell .admin-head-actions{
        width:100%!important;
        max-width:none!important;
        min-width:0!important;
        grid-template-columns:1fr 1fr!important;
    }
    .orders-admin-shell .filter-row{
        grid-template-columns:1fr!important;
    }
    .orders-admin-shell .filter-control{
        border-right:0!important;
        border-bottom:1px solid #e7ebf2!important;
    }
    .orders-admin-shell .filter-control:last-child{
        border-bottom:0!important;
    }
    .orders-admin-shell .search-box{
        width:100%!important;
    }
}
</style>

<!-- =========================================================
     FINAL REQUEST PATCH V3
     Reference files only:
     - Knowledge Base Management box style applied to analytics boxes + Date Range filter
     - Dashboard calendar/date style applied to Orders calendar/date control
     - Dashboard button size/style applied to Orders buttons
========================================================== -->
<style id="orders-final-kb-dashboard-reference-patch-v3">
    .orders-admin-shell{
        --orders-kb-blue:#0B63F6!important;
        --orders-kb-border:#DDE6F2!important;
        --orders-kb-soft-border:#E7EEF8!important;
        --orders-kb-card:#FFFFFF!important;
        --orders-kb-title:#0F172A!important;
        --orders-kb-shadow:0 10px 25px rgba(15,23,42,0.045)!important;
        --orders-kb-radius:14px!important;
        --orders-dashboard-black:#111827!important;
        --orders-dashboard-gradient:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;
    }

    /* SAME BOX COLOR / STYLE NG KNOWLEDGE BASE MANAGEMENT */
    .orders-admin-shell .analytics-grid .performance-card,
    .orders-admin-shell .analytics-grid .donut-card,
    .orders-admin-shell .analytics-grid .admin-main-box{
        background:var(--orders-kb-card)!important;
        border:1px solid var(--orders-kb-border)!important;
        border-radius:var(--orders-kb-radius)!important;
        box-shadow:var(--orders-kb-shadow)!important;
        color:var(--orders-kb-title)!important;
    }

    .orders-admin-shell .analytics-grid .performance-card:hover,
    .orders-admin-shell .analytics-grid .donut-card:hover,
    .orders-admin-shell .analytics-grid .admin-main-box:hover{
        background:var(--orders-kb-card)!important;
        border-color:var(--orders-kb-border)!important;
        box-shadow:var(--orders-kb-shadow)!important;
        transform:none!important;
    }

    /* Date Range filter box - KB Management panel style */
    .orders-admin-shell .filter-row{
        background:var(--orders-kb-card)!important;
        border:1px solid var(--orders-kb-border)!important;
        border-radius:var(--orders-kb-radius)!important;
        box-shadow:var(--orders-kb-shadow)!important;
        overflow:hidden!important;
        gap:0!important;
    }

    .orders-admin-shell .filter-row .filter-control,
    .orders-admin-shell .filter-row .filter-control:first-child{
        background:var(--orders-kb-card)!important;
        border:0!important;
        border-right:1px solid var(--orders-kb-soft-border)!important;
        border-radius:0!important;
        box-shadow:none!important;
        color:var(--orders-kb-title)!important;
    }

    .orders-admin-shell .filter-row .filter-control:last-child{
        border-right:0!important;
    }

    .orders-admin-shell .filter-row .filter-control:hover,
    .orders-admin-shell .filter-row .filter-control:focus-within{
        background:#F8FBFF!important;
        color:var(--orders-kb-title)!important;
        border-color:var(--orders-kb-soft-border)!important;
        box-shadow:none!important;
        transform:none!important;
    }

    .orders-admin-shell .filter-row .filter-control select,
    .orders-admin-shell .filter-row .filter-control select:hover,
    .orders-admin-shell .filter-row .filter-control select:focus{
        background:transparent!important;
        color:var(--orders-kb-title)!important;
        border:0!important;
        outline:0!important;
        box-shadow:none!important;
    }

    /* CALENDAR / DATE SHAPE STYLE - SAME NG DASHBOARD */
    .orders-admin-shell .admin-head-actions{
        display:grid!important;
        grid-template-columns:118px 118px!important;
        grid-template-areas:"date date" "export create"!important;
        gap:9px!important;
        justify-content:end!important;
        align-items:center!important;
        min-width:245px!important;
        width:245px!important;
        max-width:245px!important;
        margin-left:auto!important;
    }

    .orders-admin-shell .admin-date-control{
        grid-area:date!important;
        width:100%!important;
        min-width:245px!important;
        height:42px!important;
        min-height:42px!important;
        padding:0 14px!important;
        border-radius:8px!important;
        border:1px solid var(--orders-dashboard-black)!important;
        background:#ffffff!important;
        background-image:none!important;
        color:var(--orders-dashboard-black)!important;
        box-shadow:none!important;
        display:grid!important;
        grid-template-columns:18px minmax(0,1fr) 16px!important;
        align-items:center!important;
        justify-items:center!important;
        column-gap:10px!important;
        font-size:12px!important;
        font-weight:700!important;
        line-height:1!important;
        white-space:nowrap!important;
        overflow:hidden!important;
    }

    .orders-admin-shell .admin-date-control span{
        display:block!important;
        width:100%!important;
        overflow:hidden!important;
        text-overflow:ellipsis!important;
        text-align:center!important;
        color:inherit!important;
    }

    .orders-admin-shell .admin-date-control svg,
    .orders-admin-shell .admin-date-control i svg{
        width:16px!important;
        height:16px!important;
        color:currentColor!important;
        stroke:currentColor!important;
    }

    .orders-admin-shell .admin-date-control:hover,
    .orders-admin-shell .admin-date-control:focus{
        background:var(--orders-dashboard-black)!important;
        background-image:none!important;
        border-color:var(--orders-dashboard-black)!important;
        color:#ffffff!important;
        box-shadow:none!important;
        filter:none!important;
        transform:none!important;
    }

    /* BUTTONS - SAME SIZE / STYLE NG DASHBOARD BUTTONS */
    .orders-admin-shell .admin-head-actions .admin-btn,
    .orders-admin-shell .admin-btn,
    .orders-admin-shell .filter-btn,
    .orders-admin-shell .tab-btn,
    .orders-admin-shell .full-btn,
    .orders-admin-shell .orders-calendar-action-btn,
    .orders-admin-shell .orders-calendar-save-btn,
    .orders-admin-shell .orders-calendar-clear-btn,
    .orders-admin-shell .orders-calendar-mini-btn{
        height:34px!important;
        min-height:34px!important;
        min-width:118px!important;
        max-width:118px!important;
        padding:0 14px!important;
        border-radius:999px!important;
        font-family:'Poppins',system-ui,sans-serif!important;
        font-size:11.5px!important;
        font-weight:500!important;
        line-height:1!important;
        display:inline-flex!important;
        align-items:center!important;
        justify-content:center!important;
        gap:6px!important;
        white-space:nowrap!important;
        box-shadow:none!important;
        transform:none!important;
        filter:none!important;
        transition:background-color .15s ease,color .15s ease,border-color .15s ease,box-shadow .15s ease!important;
    }

    .orders-admin-shell .admin-head-actions .admin-btn-outline{
        grid-area:export!important;
        width:118px!important;
        min-width:118px!important;
        max-width:118px!important;
    }

    .orders-admin-shell .admin-head-actions .admin-btn-primary{
        grid-area:create!important;
        width:118px!important;
        min-width:118px!important;
        max-width:118px!important;
    }

    .orders-admin-shell .admin-btn-primary,
    .orders-admin-shell .tab-btn.active,
    .orders-admin-shell .pagination-row button.active,
    .orders-admin-shell .quick-actions-card .admin-btn-primary,
    .orders-admin-shell .orders-calendar-action-btn{
        background:var(--orders-dashboard-gradient)!important;
        background-image:var(--orders-dashboard-gradient)!important;
        color:#ffffff!important;
        border:1px solid transparent!important;
    }

    .orders-admin-shell .admin-btn-outline,
    .orders-admin-shell .filter-btn,
    .orders-admin-shell .full-btn:not(.admin-btn-primary),
    .orders-admin-shell .tab-btn:not(.active),
    .orders-admin-shell .orders-calendar-clear-btn,
    .orders-admin-shell .orders-calendar-mini-btn{
        background:#ffffff!important;
        background-image:none!important;
        color:var(--orders-dashboard-black)!important;
        border:1px solid var(--orders-dashboard-black)!important;
    }

    .orders-admin-shell .admin-btn:hover,
    .orders-admin-shell .admin-btn:focus,
    .orders-admin-shell .filter-btn:hover,
    .orders-admin-shell .filter-btn:focus,
    .orders-admin-shell .full-btn:hover,
    .orders-admin-shell .full-btn:focus,
    .orders-admin-shell .tab-btn:hover,
    .orders-admin-shell .tab-btn:focus,
    .orders-admin-shell .orders-calendar-action-btn:hover,
    .orders-admin-shell .orders-calendar-action-btn:focus,
    .orders-admin-shell .orders-calendar-clear-btn:hover,
    .orders-admin-shell .orders-calendar-clear-btn:focus,
    .orders-admin-shell .orders-calendar-mini-btn:hover,
    .orders-admin-shell .orders-calendar-mini-btn:focus{
        background:var(--orders-dashboard-black)!important;
        background-image:none!important;
        color:#ffffff!important;
        border-color:var(--orders-dashboard-black)!important;
        box-shadow:none!important;
        transform:none!important;
    }

    .orders-admin-shell .tab-btn b,
    .orders-admin-shell .tab-btn.active b{
        background:transparent!important;
        color:inherit!important;
        border:0!important;
        padding:0!important;
        margin-left:5px!important;
        min-width:auto!important;
    }

    /* Quick Actions buttons follow dashboard button size but fit inside the right column */
    .orders-admin-shell .quick-actions-card .full-btn{
        width:190px!important;
        max-width:190px!important;
        min-width:190px!important;
        height:34px!important;
        min-height:34px!important;
        margin:0 0 8px!important;
        border-radius:999px!important;
    }

    /* Keep table border separate; request only targets analytics/date/buttons */
    .orders-admin-shell .table-card{
        border:1.5px solid var(--orders-dashboard-black)!important;
        background:#ffffff!important;
    }

    @media(max-width:1200px){
        .orders-admin-shell .admin-head-actions{
            width:245px!important;
            max-width:245px!important;
            min-width:0!important;
        }
        .orders-admin-shell .filter-row{
            width:100%!important;
            max-width:100%!important;
        }
    }

    @media(max-width:880px){
        .orders-admin-shell .filter-row{
            display:grid!important;
            grid-template-columns:1fr 1fr!important;
        }
        .orders-admin-shell .filter-row .filter-control:nth-child(2){border-right:0!important;}
        .orders-admin-shell .filter-row .filter-control:nth-child(3),
        .orders-admin-shell .filter-row .filter-control:nth-child(4){border-top:1px solid var(--orders-kb-soft-border)!important;}
    }

    @media(max-width:760px){
        .orders-admin-shell .admin-head-actions{
            width:100%!important;
            max-width:none!important;
            grid-template-columns:1fr 1fr!important;
        }
        .orders-admin-shell .admin-date-control{
            min-width:0!important;
        }
        .orders-admin-shell .admin-head-actions .admin-btn,
        .orders-admin-shell .admin-btn,
        .orders-admin-shell .filter-btn,
        .orders-admin-shell .tab-btn{
            width:auto!important;
            min-width:112px!important;
            max-width:none!important;
        }
        .orders-admin-shell .quick-actions-card .full-btn{
            width:100%!important;
            max-width:none!important;
            min-width:0!important;
        }
        .orders-admin-shell .filter-row{
            grid-template-columns:1fr!important;
        }
        .orders-admin-shell .filter-row .filter-control{
            border-right:0!important;
            border-bottom:1px solid var(--orders-kb-soft-border)!important;
        }
        .orders-admin-shell .filter-row .filter-control:last-child{
            border-bottom:0!important;
        }
    }
</style>
