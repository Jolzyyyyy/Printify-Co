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
    $orderNo = fn ($order) => $order->order_reference ?: 'ORD-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT);
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
@font-face{font-family:'Clash Display';src:url("{{ asset('Fonts/ClashDisplay-Semibold.otf') }}") format('opentype');font-weight:600;font-style:normal;font-display:swap}
@font-face{font-family:'League Spartan';src:url("{{ asset('Fonts/LeagueSpartan-SemiBold.otf') }}") format('opentype');font-weight:600;font-style:normal;font-display:swap}
*{box-sizing:border-box}body{margin:0;background:#fff;color:#111827;font-family:Inter,system-ui,sans-serif}.co-topbar{height:58px;background:#050505;color:#fff;display:flex;align-items:center;gap:24px;padding:0 34px;position:sticky;top:0;z-index:50;user-select:none}.co-brand{min-width:210px;color:#fff;text-decoration:none}.co-brand strong{display:block;font-family:Georgia,serif;font-size:17px;letter-spacing:.06em;line-height:1}.co-brand span{display:block;margin-top:3px;color:#ff4f16;font-size:7px;font-weight:900;letter-spacing:.18em}.co-nav{display:flex;align-items:center;gap:38px;flex:1;height:100%}.co-nav a{height:100%;display:inline-flex;align-items:center;color:#fff;text-decoration:none;font-family:"Clash Display",Inter,sans-serif;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.03em;position:relative;transition:color .16s}.co-nav a:hover,.co-nav a:focus-visible{color:#ff6a21;outline:0}.co-nav a:hover:after,.co-nav a:focus-visible:after,.co-nav a.active:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#ff4f16}.co-top-actions{display:flex;align-items:center;gap:14px}.co-search{height:34px;width:220px;border:0;border-radius:999px;background:#fff;color:#111827;padding:0 15px;font-size:11px;outline:0}.co-icon{color:#fff;text-decoration:none;font-size:16px;position:relative}.co-cart-dot{position:absolute;right:-4px;top:-5px;width:8px;height:8px;border-radius:50%;background:#ff4f16}.co-avatar{width:30px;height:30px;border-radius:50%;background:#fff3ed;color:#ff4f16;display:grid;place-items:center;font-weight:900;font-size:11px}.co-user{display:flex;align-items:center;gap:8px;color:#fff;font-family:"Clash Display",Inter,sans-serif;font-size:11px;font-weight:800;text-decoration:none;white-space:nowrap}.mo-page{min-height:calc(100vh - 58px);background:#fff}
.mo-wrap{max-width:none;margin:0;padding:12px 36px 28px 40px}
.mo-crumb{display:flex;align-items:center;gap:8px;margin:0 0 10px;color:#8b95a1;font-size:11px;font-weight:800}.mo-crumb a,.mo-backline{border:0;background:transparent;color:#6b7280;text-decoration:none;font:inherit;font-family:"Clash Display",Inter,sans-serif;font-weight:800;cursor:pointer;padding:0;position:relative}.mo-crumb a:after,.mo-backline:after{content:"";position:absolute;left:0;right:0;bottom:-3px;height:1px;background:#ff4f16;transform:scaleX(0);transform-origin:left;transition:transform .16s}.mo-crumb a:hover,.mo-backline:hover,.mo-crumb a:focus-visible,.mo-backline:focus-visible{color:#ff4f16;outline:0}.mo-crumb a:hover:after,.mo-backline:hover:after,.mo-crumb a:focus-visible:after,.mo-backline:focus-visible:after{transform:scaleX(1)}.mo-crumb .current{color:#111827}
.mo-title{font-family:"Clash Display",Inter,sans-serif;font-size:28px;line-height:1.1;margin:0;font-weight:800;letter-spacing:0}
.mo-sub{margin:7px 0 20px;color:#6b7280;font-size:13px}
.mo-tabs{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px}
.mo-tab-list{display:flex;align-items:center;gap:0;border:1px solid #eef0f4;border-radius:8px;background:#fff;overflow:hidden}
.mo-tab{height:42px;min-width:116px;border:0;background:#fff;color:#374151;font-family:"Clash Display",Inter,sans-serif;font-size:11px;font-weight:800;cursor:pointer}
.mo-tab.active{color:#ff4f16;background:#fff7ed;box-shadow:inset 0 -2px 0 #ff4f16}
.mo-tab b{display:inline-grid;place-items:center;min-width:19px;height:19px;margin-left:5px;border-radius:999px;background:#f3f4f6;color:#6b7280;font-size:10px}
.mo-tab.active b{background:#ff4f16;color:#fff}
.mo-tools{display:flex;gap:10px}.mo-select,.mo-tool{height:40px;border:1px solid #111827;border-radius:999px;background:#fff;padding:0 15px;font-family:"Clash Display",Inter,sans-serif;font-size:11px;font-weight:800;color:#111827;transition:background .16s,color .16s,border-color .16s}
.mo-tool{display:inline-flex;align-items:center;gap:8px;cursor:pointer}.mo-tool:hover,.mo-tool:focus-visible{background:#111827;color:#fff;outline:0}
.mo-list{display:grid;gap:16px}.mo-card{display:grid;grid-template-columns:126px minmax(0,1fr) 190px;gap:22px;border:1px solid #edf0f4;border-radius:8px;background:#fff;padding:18px 20px;box-shadow:0 12px 34px rgba(15,23,42,.035);cursor:pointer;transition:border-color .16s,box-shadow .16s,transform .16s}.mo-card:hover{border-color:#ffb38f;box-shadow:0 14px 36px rgba(255,79,22,.08);transform:translateY(-1px)}
.mo-thumb{width:94px;margin:0 auto;text-align:center}.mo-paper{height:124px;border:1px solid #e5e7eb;border-radius:4px;background:linear-gradient(#fff,#f8fafc);padding:10px;display:grid;gap:5px}.mo-paper span{height:3px;border-radius:8px;background:#1118271f}.mo-paper .short{width:62%}.mo-pages{display:inline-flex;margin-top:8px;padding:6px 12px;border:1px solid #eef0f4;border-radius:7px;background:#fff;font-size:11px;font-weight:800}
.mo-main{min-width:0}.mo-product{font-family:"Clash Display",Inter,sans-serif;font-size:17px;margin:0 0 10px;font-weight:800}.mo-meta{display:flex;flex-wrap:wrap;gap:14px;color:#374151;font-size:11px;font-weight:700;margin-bottom:15px}.mo-meta i{color:#6b7280;margin-right:5px}
.mo-details{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-bottom:14px}.mo-label{display:block;color:#6b7280;font-size:10px;font-weight:800}.mo-value{display:block;margin-top:4px;color:#111827;font-size:11px;font-weight:800}
.mo-dispatch{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 12px;border-radius:6px;background:#f5f9ff;color:#1f2937;font-size:11px}.mo-dispatch i{color:#2580d9}.mo-side{border-left:1px solid #edf0f4;padding-left:18px;display:grid;align-content:center;gap:12px}.mo-status-pill{display:inline-flex;align-items:center;gap:6px;padding:7px 11px;border-radius:999px;background:#fff3ed;color:#ff4f16;font-size:11px;font-weight:900;width:max-content}.mo-side-total{display:grid;gap:4px}.mo-side-total span{font-size:10px;color:#6b7280;font-weight:800}.mo-side-total strong{font-size:20px;color:#ff4f16;font-weight:900}.mo-btn{height:38px;border:0;border-radius:999px;background:linear-gradient(90deg,#FE7B09,#FFAB0A);color:#111827!important;display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;font-family:"Clash Display",Inter,sans-serif;font-size:11px;font-weight:800;letter-spacing:.02em;transition:background .16s,color .16s,transform .16s}.mo-btn:hover,.mo-btn:focus-visible{background:#111827;color:#fff!important;outline:0;transform:translateY(-1px)}.mo-empty{border:1px dashed #e5e7eb;border-radius:8px;padding:42px 20px;text-align:center;color:#6b7280}
.mo-footer{display:flex;align-items:center;justify-content:center;margin-top:16px;color:#6b7280;font-size:12px}.mo-page-num{display:inline-grid;place-items:center;width:31px;height:31px;margin:0 10px;border:1px solid #ff4f16;border-radius:8px;color:#ff4f16;font-weight:900}
@media(max-width:1120px){.mo-card{grid-template-columns:110px minmax(0,1fr);}.mo-side{grid-column:1/-1;border-left:0;border-top:1px solid #edf0f4;padding:14px 0 0;grid-template-columns:1fr auto auto;align-items:center}.mo-tabs{display:grid}.mo-tab-list{overflow:auto}.mo-tab{min-width:104px}}
@media(max-width:720px){.mo-wrap{padding:10px 14px 22px}.mo-card{grid-template-columns:1fr}.mo-details,.mo-side{grid-template-columns:1fr}.mo-tools{display:none}.mo-thumb{margin:0}.mo-main{overflow:auto}}
@media(max-width:980px){.co-topbar{height:auto;min-height:58px;align-items:flex-start;flex-wrap:wrap;padding:13px 16px}.co-brand{min-width:150px}.co-nav{order:3;width:100%;overflow:auto;gap:20px}.co-nav a{height:35px}.co-search{width:150px}.co-user span{display:none}}
:root{--red:#ff2b1a;--orange:#ff8a00;--orange2:#FFAB0A}.top-nav-bar{height:70px;background:#050505;color:#fff;position:sticky;top:0;z-index:50;box-shadow:0 10px 34px rgba(0,0,0,.28)}.premium-main-navbar{position:relative;width:min(1680px,calc(100% - 110px));min-height:70px;margin:0 auto;display:flex;align-items:center;gap:34px}.brand-logo-block{flex:0 0 230px;min-width:230px;height:70px;color:#fff;text-decoration:none;line-height:1;display:flex;flex-direction:column;justify-content:center}.brand-main-text{font-family:Inter,sans-serif;font-size:24px;font-weight:900;letter-spacing:-1.2px;color:#fff}.brand-sub-text{margin-top:4px;color:var(--red);font-family:'League Spartan',sans-serif;font-size:7.8px;font-weight:800;letter-spacing:1.35px}.nav-horizontal{position:absolute;left:50%;top:0;height:70px;transform:translateX(-50%);display:flex;align-items:center;justify-content:center;gap:52px}.nav-link{position:relative;height:70px;display:inline-flex;align-items:center;color:#fff;text-decoration:none;font-family:'League Spartan',sans-serif;font-size:14px;font-weight:800;line-height:1;letter-spacing:1.55px;white-space:nowrap;transition:color .18s}.nav-link:after{content:"";position:absolute;left:6px;right:6px;top:calc(50% + 13px);height:2px;border-radius:999px;background:var(--orange);opacity:0;transform:scaleX(0);transform-origin:center;transition:opacity .18s,transform .18s}.nav-link:hover,.nav-link:focus-visible{color:var(--orange);outline:0}.nav-link:hover:after,.nav-link:focus-visible:after{opacity:1;transform:scaleX(1)}.hero-signin-container{height:70px;margin-left:auto;min-width:0;display:flex;align-items:center;justify-content:flex-end;gap:14px}.nav-search-box{width:285px;height:38px;border:1px solid #dedede;border-radius:16px;background:#fff;display:flex;align-items:center;overflow:hidden;box-shadow:0 8px 22px rgba(0,0,0,.05)}.nav-search-box input{width:100%;height:100%;border:0;outline:0;padding:0 15px;color:#333;font-size:11.5px;font-family:Inter,sans-serif;background:#fff}.nav-icon-link{position:relative;height:70px;color:#fff;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:6px;min-width:22px;font-family:'League Spartan',sans-serif;font-size:13px;font-weight:700;line-height:1;opacity:.92;transition:color .2s,opacity .2s}.nav-icon-link:hover,.nav-icon-link:focus-visible{color:var(--orange);outline:0}.nav-svg-icon{width:22px;height:22px;object-fit:contain;display:block;filter:brightness(0) saturate(100%) invert(100%);transition:filter .2s,opacity .2s;opacity:.9}.nav-icon-link:hover .nav-svg-icon,.nav-icon-link:focus-visible .nav-svg-icon{filter:brightness(0) saturate(100%) invert(48%) sepia(98%) saturate(2262%) hue-rotate(351deg) brightness(101%) contrast(101%)}.account-label{max-width:150px;color:#fff;font-family:'League Spartan',sans-serif;font-size:13.5px;font-weight:800;line-height:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.cart-badge{position:absolute;top:18px;right:-8px;min-width:15px;height:15px;border-radius:999px;background:var(--red);color:#fff;font-size:9px;font-weight:900;display:grid;place-items:center;padding:0 4px}.mo-page{min-height:calc(100vh - 70px)}.mo-wrap{padding:14px 38px 28px 40px}.mo-crumb{gap:12px;margin-bottom:14px;font-size:13px;letter-spacing:.02em}.mo-crumb a,.mo-backline{font-size:13px}.mo-tabs{gap:24px;margin-bottom:16px}.mo-tab-list{border:0;border-radius:0;background:transparent;gap:28px;overflow:visible}.mo-tab{height:auto;min-width:0;padding:0 0 9px;background:transparent;position:relative}.mo-tab.active{background:transparent;box-shadow:none}.mo-tab:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;border-radius:999px;background:#ff4f16;opacity:0;transform:scaleX(0);transition:opacity .16s,transform .16s}.mo-tab:hover:after,.mo-tab.active:after{opacity:1;transform:scaleX(1)}.mo-list{gap:12px}.mo-card{grid-template-columns:104px minmax(0,1fr) 170px;gap:16px;padding:12px 16px}.mo-thumb{width:76px}.mo-paper{height:88px;padding:8px;gap:4px}.mo-pages{margin-top:6px;padding:4px 9px;font-size:10px}.mo-product{font-size:16px;margin-bottom:7px}.mo-meta{gap:10px;margin-bottom:10px}.mo-details{gap:10px;margin-bottom:9px}.mo-dispatch{padding:8px 10px}.mo-side{gap:8px;padding-left:15px}.mo-status-pill{padding:6px 10px}.mo-side-total strong{font-size:18px}.mo-btn{height:34px}
@media(max-width:1180px){.premium-main-navbar{width:calc(100% - 32px)}.nav-horizontal{position:static;transform:none;gap:26px}.nav-search-box{width:210px}}
@media(max-width:820px){.top-nav-bar{height:auto}.premium-main-navbar{min-height:70px;flex-wrap:wrap;padding-bottom:12px}.nav-horizontal{order:3;width:100%;justify-content:flex-start;overflow:auto}.hero-signin-container{margin-left:0}.nav-search-box{width:180px}}
</style>
</head>
<body>
<header class="top-nav-bar premium-site-header header-dark" id="mainHeader">
  <div class="premium-main-navbar">
    <a href="{{ route('home') }}" class="brand-logo-block" aria-label="Printify and Co Home">
      <span class="brand-main-text">PRINTIFY &amp; CO.</span>
      <span class="brand-sub-text">CRAFTING YOUR VISION INTO REALITY</span>
    </a>
    <nav class="nav-horizontal" aria-label="Main navigation">
      <a href="{{ route('home') }}" class="nav-link">HOME</a>
      <a href="{{ route('landing.aboutus') }}" class="nav-link">ABOUT US</a>
      <a href="{{ route('services.index') }}" class="nav-link">SERVICES</a>
      <a href="{{ route('landing.contactus') }}" class="nav-link">CONTACT US</a>
    </nav>
    <div class="hero-signin-container" id="authContainer">
      <div class="nav-search-box">
        <input type="text" id="navSearchInput" placeholder="Search products or services..." autocomplete="off">
      </div>
      <a href="{{ route('help-center') }}" class="nav-icon-link" aria-label="Wishlist">
        <img src="{{ asset('images/Heart.svg') }}" alt="Heart" class="nav-svg-icon">
      </a>
      <a href="{{ route('cart.index') }}" class="nav-icon-link" aria-label="Cart">
        <img src="{{ asset('images/Shopping cart.svg') }}" alt="Cart" class="nav-svg-icon">
        <span class="cart-badge" id="cartBadge">{{ session('cart') ? count(session('cart')) : 0 }}</span>
      </a>
      <a href="{{ route('dashboard') }}" class="nav-icon-link">
        <img src="{{ asset('images/user-logged.svg') }}" alt="Profile" class="nav-svg-icon">
        <span class="account-label">{{ $user?->name ?? 'Account' }}</span>
      </a>
    </div>
  </div>
</header>

<div class="mo-page">
  <div class="mo-wrap">
    <div class="mo-crumb">
      <button class="mo-backline" type="button" onclick="if (window.history.length > 1) { window.history.back(); } else { window.location.href='{{ route('home') }}'; }"><i class="fa-solid fa-arrow-left"></i> Back</button>
      <a href="{{ route('home') }}">Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('co.place-order') }}" class="current">My Orders</a>
    </div>
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
          $variation = $item?->serviceVariation;
          $file = $order->files?->first();
          $quantity = max(1, (int) ($order->items_count ?: ($order->items?->sum('quantity') ?? 1)));
          $subtotal = (float) ($order->items?->sum('subtotal') ?? 0);
          $delivery = (float) ($order->delivery_fee ?? 0);
          $step = $stepFor($order);
          $trackingUrl = route('co.place-order.tracking', $order);
          $serviceName = $item?->service_name ?: $item?->service?->name ?: 'Print Order';
          $variationLabel = $item?->variation_label ?: $variation?->variation_label;
          $color = $variation?->color_mode;
          $paperSize = $variation?->product_size ?: $variationLabel;
          $printOption = $variation?->finish_type ?: ($item?->price_type ? str($item->price_type)->title()->toString() : null);
          $fileType = $file?->original_name ? strtoupper(pathinfo($file->original_name, PATHINFO_EXTENSION) ?: 'FILE') : null;
        @endphp
        <article class="mo-card" data-order-card data-status="{{ $statusKey($order) }}" data-href="{{ $trackingUrl }}" tabindex="0" role="link" aria-label="Track order {{ $orderNo($order) }}">
          <div class="mo-thumb">
            <div class="mo-paper" aria-hidden="true">
              <span></span><span></span><span class="short"></span><span></span><span></span><span class="short"></span><span></span><span></span><span></span>
            </div>
            <span class="mo-pages">{{ $quantity }} {{ $quantity === 1 ? 'page' : 'pages' }}</span>
          </div>

          <div class="mo-main">
            <h2 class="mo-product">{{ $serviceName }}</h2>
            <div class="mo-meta">
              @if($paperSize)<span><i class="fa-regular fa-file-lines"></i>{{ $paperSize }}</span>@endif
              <span><i class="fa-regular fa-copy"></i>{{ $quantity }} {{ $quantity === 1 ? 'sheet' : 'sheets' }}</span>
              @if($color)<span><i class="fa-solid fa-droplet"></i>{{ $color }}</span>@endif
              @if($printOption)<span>Print: {{ $printOption }}</span>@endif
              @if($fileType)<span>File: {{ $fileType }}</span>@endif
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
            <a class="mo-btn" href="{{ $trackingUrl }}" onclick="event.stopPropagation()"><i class="fa-solid fa-location-dot"></i>View &amp; Track</a>
          </div>
        </article>
      @empty
        <div class="mo-empty"><i class="fa-regular fa-folder-open" style="font-size:34px;color:#cbd5e1"></i><p style="margin-top:10px">You have no orders yet.</p></div>
      @endforelse
    </div>

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
