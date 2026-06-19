<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>My Orders | Printify & Co.</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">

@php
    $user = auth()->user();
    $rows = method_exists($orders, 'getCollection') ? $orders->getCollection() : collect($orders ?? []);
    $money = fn ($value) => '₱' . number_format((float) $value, 2);
    $orderNo = fn ($order) => 'DOC-TX-BW-A4-CS-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT);
    $itemFor = fn ($order) => optional($order->items ?? collect())->first();
    $statusKey = function ($order) {
        $value = strtolower((string) ($order->lalamove_status ?: $order->status ?: 'pending'));
        return match (true) {
            str_contains($value, 'cancel') || str_contains($value, 'fail') => 'cancelled',
            str_contains($value, 'delivered') || str_contains($value, 'completed') => 'delivered',
            str_contains($value, 'transit') || str_contains($value, 'ship') || str_contains($value, 'assigned') => 'shipped',
            str_contains($value, 'confirm') || str_contains($value, 'cod') || str_contains($value, 'paid') || str_contains($value, 'process') || str_contains($value, 'quote') => 'toship',
            default => 'topay',
        };
    };
    $stepFor = function ($order) use ($statusKey) {
        return match ($statusKey($order)) {
            'delivered' => 4,
            'shipped' => 3,
            'toship' => 2,
            default => 1,
        };
    };
    $statusLabel = function ($order) use ($statusKey) {
        return match ($statusKey($order)) {
            'cancelled' => 'Cancelled',
            'delivered' => 'Delivered',
            'shipped' => 'Shipped',
            'toship' => $order->lalamove_order_id ? 'Preparing for Shipment' : 'Ready for Dispatch',
            default => 'To Pay',
        };
    };
    $counts = [
        'all' => $rows->count(),
        'topay' => $rows->filter(fn ($o) => $statusKey($o) === 'topay')->count(),
        'toship' => $rows->filter(fn ($o) => $statusKey($o) === 'toship')->count(),
        'shipped' => $rows->filter(fn ($o) => $statusKey($o) === 'shipped')->count(),
        'delivered' => $rows->filter(fn ($o) => $statusKey($o) === 'delivered')->count(),
        'cancelled' => $rows->filter(fn ($o) => $statusKey($o) === 'cancelled')->count(),
    ];
@endphp

<style>
*{box-sizing:border-box}body{margin:0;background:#fff;color:#111827;font-family:Inter,system-ui,sans-serif}.co-topbar{height:58px;background:#050505;color:#fff;display:flex;align-items:center;gap:24px;padding:0 34px;position:sticky;top:0;z-index:50}.co-brand{min-width:190px;color:#fff;text-decoration:none}.co-brand strong{display:block;font-family:Georgia,serif;font-size:17px;letter-spacing:.06em;line-height:1}.co-brand span{display:block;margin-top:3px;color:#ff4f16;font-size:7px;font-weight:900;letter-spacing:.18em}.co-nav{display:flex;align-items:center;gap:29px;flex:1;height:100%}.co-nav a{height:100%;display:inline-flex;align-items:center;color:#fff;text-decoration:none;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.02em;position:relative}.co-nav a.active{color:#ff6a21}.co-nav a.active:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#ff4f16}.co-top-actions{display:flex;align-items:center;gap:14px}.co-search{height:30px;width:148px;border:0;border-radius:999px;background:#fff;color:#111827;padding:0 13px;font-size:10px;outline:0}.co-icon{color:#fff;text-decoration:none;font-size:16px;position:relative}.co-cart-dot{position:absolute;right:-4px;top:-5px;width:8px;height:8px;border-radius:50%;background:#ff4f16}.co-avatar{width:28px;height:28px;border-radius:50%;background:#fff3ed;color:#ff4f16;display:grid;place-items:center;font-weight:900;font-size:11px}.co-user{display:flex;align-items:center;gap:8px;color:#fff;font-size:11px;font-weight:900;text-decoration:none;white-space:nowrap}.mo-page{min-height:calc(100vh - 58px);background:#fff}
.mo-wrap{max-width:1260px;margin:0 auto;padding:24px 18px 28px}
.mo-crumb{display:flex;gap:8px;align-items:center;color:#8b95a1;font-size:11px;font-weight:700;margin-bottom:12px}
.mo-title{font-size:28px;line-height:1.1;margin:0;font-weight:900;letter-spacing:-.02em}
.mo-sub{margin:7px 0 20px;color:#6b7280;font-size:13px}
.mo-tabs{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px}
.mo-tab-list{display:flex;align-items:center;gap:0;border:1px solid #eef0f4;border-radius:8px;background:#fff;overflow:hidden}
.mo-tab{height:42px;min-width:116px;border:0;background:#fff;color:#374151;font-size:11px;font-weight:800;cursor:pointer}
.mo-tab.active{color:#ff4f16;background:#fff7ed;box-shadow:inset 0 -2px 0 #ff4f16}
.mo-tab b{display:inline-grid;place-items:center;min-width:19px;height:19px;margin-left:5px;border-radius:999px;background:#f3f4f6;color:#6b7280;font-size:10px}
.mo-tab.active b{background:#ff4f16;color:#fff}
.mo-tools{display:flex;gap:10px}.mo-select,.mo-tool{height:40px;border:1px solid #e5e7eb;border-radius:8px;background:#fff;padding:0 13px;font-size:11px;font-weight:800;color:#111827}
.mo-tool{display:inline-flex;align-items:center;gap:8px;cursor:pointer}
.mo-list{display:grid;gap:16px}.mo-card{display:grid;grid-template-columns:126px minmax(0,1fr) 190px;gap:22px;border:1px solid #edf0f4;border-radius:8px;background:#fff;padding:18px 20px;box-shadow:0 12px 34px rgba(15,23,42,.035);cursor:pointer;transition:border-color .16s,box-shadow .16s,transform .16s}.mo-card:hover{border-color:#ffb38f;box-shadow:0 14px 36px rgba(255,79,22,.08);transform:translateY(-1px)}
.mo-thumb{width:94px;margin:0 auto;text-align:center}.mo-paper{height:124px;border:1px solid #e5e7eb;border-radius:4px;background:linear-gradient(#fff,#f8fafc);padding:10px;display:grid;gap:5px}.mo-paper span{height:3px;border-radius:8px;background:#1118271f}.mo-paper .short{width:62%}.mo-pages{display:inline-flex;margin-top:8px;padding:6px 12px;border:1px solid #eef0f4;border-radius:7px;background:#fff;font-size:11px;font-weight:800}
.mo-main{min-width:0}.mo-product{font-size:17px;margin:0 0 10px;font-weight:900}.mo-meta{display:flex;flex-wrap:wrap;gap:14px;color:#374151;font-size:11px;font-weight:700;margin-bottom:15px}.mo-meta i{color:#6b7280;margin-right:5px}
.mo-details{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-bottom:14px}.mo-label{display:block;color:#6b7280;font-size:10px;font-weight:800}.mo-value{display:block;margin-top:4px;color:#111827;font-size:11px;font-weight:800}
.mo-dispatch{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 12px;border-radius:6px;background:#f5f9ff;color:#1f2937;font-size:11px}.mo-dispatch i{color:#2580d9}.mo-side{border-left:1px solid #edf0f4;padding-left:18px;display:grid;align-content:center;gap:12px}.mo-status-pill{display:inline-flex;align-items:center;gap:6px;padding:7px 11px;border-radius:7px;background:#fff3ed;color:#ff4f16;font-size:11px;font-weight:900;width:max-content}.mo-side-total{display:grid;gap:4px}.mo-side-total span{font-size:10px;color:#6b7280;font-weight:800}.mo-side-total strong{font-size:20px;color:#ff4f16;font-weight:900}.mo-btn{height:38px;border:0;border-radius:8px;background:#ff4f16;color:#fff!important;display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;font-size:11px;font-weight:900}.mo-empty{border:1px dashed #e5e7eb;border-radius:8px;padding:42px 20px;text-align:center;color:#6b7280}
.mo-footer{display:flex;align-items:center;justify-content:center;margin-top:16px;color:#6b7280;font-size:12px}.mo-page-num{display:inline-grid;place-items:center;width:31px;height:31px;margin:0 10px;border:1px solid #ff4f16;border-radius:8px;color:#ff4f16;font-weight:900}
@media(max-width:1120px){.mo-card{grid-template-columns:110px minmax(0,1fr);}.mo-side{grid-column:1/-1;border-left:0;border-top:1px solid #edf0f4;padding:14px 0 0;grid-template-columns:1fr auto auto;align-items:center}.mo-tabs{display:grid}.mo-tab-list{overflow:auto}.mo-tab{min-width:104px}}
@media(max-width:720px){.mo-wrap{padding:0 4px 22px}.mo-card{grid-template-columns:1fr}.mo-details,.mo-side{grid-template-columns:1fr}.mo-tools{display:none}.mo-thumb{margin:0}.mo-main{overflow:auto}}
@media(max-width:980px){.co-topbar{height:auto;min-height:58px;align-items:flex-start;flex-wrap:wrap;padding:13px 16px}.co-brand{min-width:140px}.co-nav{order:3;width:100%;overflow:auto;gap:20px}.co-nav a{height:35px}.co-search{width:132px}.co-user span{display:none}}
</style>
</head>
<body>
<header class="co-topbar">
  <a class="co-brand" href="{{ route('home') }}"><strong>PRINTIFY &amp; CO.</strong><span>PRINTING SERVICES</span></a>
  <nav class="co-nav" aria-label="Primary navigation">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a class="active" href="{{ route('co.place-order') }}">My Orders</a>
    <a href="{{ route('landing.service-detail') }}">My Templates</a>
    <a href="{{ route('services.index') }}">Add-ons</a>
    <a href="{{ route('settings') }}">Settings</a>
  </nav>
  <div class="co-top-actions">
    <input class="co-search" type="search" placeholder="Search orders...">
    <a class="co-icon" href="{{ route('help-center') }}" aria-label="Support"><i class="fa-regular fa-heart"></i></a>
    <a class="co-icon" href="{{ route('cart.index') }}" aria-label="Cart"><i class="fa-solid fa-cart-shopping"></i><span class="co-cart-dot"></span></a>
    <a class="co-user" href="{{ route('profile.edit') }}"><span class="co-avatar">{{ strtoupper(substr($user?->name ?? 'C', 0, 1)) }}</span><span>{{ strtoupper($user?->name ?? 'Customer') }}</span><i class="fa-solid fa-chevron-down" style="font-size:9px"></i></a>
  </div>
</header>

<div class="mo-page">
  <div class="mo-wrap">
    <div class="mo-crumb">Home <i class="fa-solid fa-chevron-right"></i> My Orders</div>
    <h1 class="mo-title">My Orders</h1>
    <p class="mo-sub">Manage and track your recent orders</p>

    <div class="mo-tabs">
      <div class="mo-tab-list" role="tablist" aria-label="Order status filters">
        <button class="mo-tab active" type="button" data-filter="all">ALL <b>{{ $counts['all'] }}</b></button>
        <button class="mo-tab" type="button" data-filter="topay">TO PAY <b>{{ $counts['topay'] }}</b></button>
        <button class="mo-tab" type="button" data-filter="toship">TO SHIP <b>{{ $counts['toship'] }}</b></button>
        <button class="mo-tab" type="button" data-filter="shipped">TO RECEIVE <b>{{ $counts['shipped'] }}</b></button>
        <button class="mo-tab" type="button" data-filter="delivered">TO REVIEW <b>{{ $counts['delivered'] }}</b></button>
        <button class="mo-tab" type="button" data-filter="cancelled">CANCELLED <b>{{ $counts['cancelled'] }}</b></button>
      </div>
      <div class="mo-tools">
        <select class="mo-select" aria-label="Sort orders"><option>Sort by: Newest First</option></select>
        <button class="mo-tool" type="button"><i class="fa-solid fa-filter"></i> Filter</button>
      </div>
    </div>

    <div class="mo-list" id="ordersList">
      @forelse($rows as $order)
        @php
          $item = $itemFor($order);
          $quantity = max(1, (int) ($order->items_count ?: ($order->items?->sum('quantity') ?? 1)));
          $subtotal = (float) ($order->items?->sum('subtotal') ?? 0);
          $delivery = (float) ($order->delivery_fee ?? 0);
          $step = $stepFor($order);
          $paymentName = str_contains(strtolower((string) $order->status), 'cod') ? 'Cash on Delivery' : 'Maya';
        @endphp
        <article class="mo-card" data-order-card data-status="{{ $statusKey($order) }}" data-href="{{ route('co.place-order.show', $order) }}" tabindex="0" role="link" aria-label="Open order {{ $orderNo($order) }}">
          <div class="mo-thumb">
            <div class="mo-paper" aria-hidden="true">
              <span></span><span></span><span class="short"></span><span></span><span></span><span class="short"></span><span></span><span></span><span></span>
            </div>
            <span class="mo-pages">{{ $quantity }} {{ $quantity === 1 ? 'page' : 'pages' }}</span>
          </div>

          <div class="mo-main">
            <h2 class="mo-product">{{ $item?->service_name ?? $item?->service?->name ?? 'Text Only Printing' }}</h2>
            <div class="mo-meta">
              <span><i class="fa-regular fa-file-lines"></i>{{ $item?->variation_label ?? 'A4 (8.27 x 11.69)' }}</span>
              <span><i class="fa-regular fa-copy"></i>{{ $quantity }} {{ $quantity === 1 ? 'sheet' : 'sheets' }}</span>
              <span><i class="fa-solid fa-droplet"></i>Black & White</span>
              <span>Paper: 80gsm White</span>
              <span>Print: Collated Set</span>
              <span>File: PDF</span>
            </div>

            <div class="mo-details">
              <div><span class="mo-label">Order No.</span><span class="mo-value">{{ $orderNo($order) }}</span></div>
              <div><span class="mo-label">Order Date</span><span class="mo-value">{{ optional($order->created_at)->format('M d, Y - h:i A') }}</span></div>
              <div><span class="mo-label">Order Confirmed</span><span class="mo-value">{{ optional($order->created_at)->format('M d, h:i A') }}</span></div>
            </div>

            <div class="mo-dispatch">
              <span><i class="fa-regular fa-clock"></i> Estimated dispatch: <strong>{{ optional($order->created_at)->addDay()->format('M d, Y') }}</strong></span>
              <span>{{ $statusKey($order) === 'shipped' ? 'Your delivery is on the way.' : "We're getting your order ready to ship." }}</span>
            </div>
          </div>

          <div class="mo-side">
            <span class="mo-status-pill"><i class="fa-solid fa-truck-fast"></i>{{ $statusLabel($order) }}</span>
            <div class="mo-side-total">
              <span>Total Paid</span>
              <strong>{{ $money($order->total_price) }}</strong>
            </div>
            <a class="mo-btn" href="{{ route('co.place-order.show', $order) }}" onclick="event.stopPropagation()">View Order</a>
          </div>
        </article>
      @empty
        <div class="mo-empty"><i class="fa-regular fa-folder-open" style="font-size:34px;color:#cbd5e1"></i><p style="margin-top:10px">You have no orders yet.</p></div>
      @endforelse
    </div>

    @if($rows->count())
      <div class="mo-footer">
        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
        <span class="mo-page-num">{{ $orders->currentPage() }}</span>
      </div>
      {{ $orders->links() }}
    @endif
  </div>
</div>

<script>
document.querySelectorAll('.mo-tab').forEach(function(tab){
  tab.addEventListener('click', function(){
    const filter = tab.dataset.filter || 'all';
    document.querySelectorAll('.mo-tab').forEach(function(item){ item.classList.toggle('active', item === tab); });
    document.querySelectorAll('[data-order-card]').forEach(function(card){
      card.style.display = filter === 'all' || card.dataset.status === filter ? '' : 'none';
    });
  });
});
document.querySelectorAll('[data-order-card]').forEach(function(card){
  card.addEventListener('click', function(){
    if(card.dataset.href) window.location.href = card.dataset.href;
  });
  card.addEventListener('keydown', function(event){
    if((event.key === 'Enter' || event.key === ' ') && card.dataset.href){
      event.preventDefault();
      window.location.href = card.dataset.href;
    }
  });
});
</script>
</body>
</html>
