<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Order Details | Printify & Co.</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
@php
    $user = auth()->user();
    $items = $order->items ?? collect();
    $item = $items->first();
    $subtotal = (float) $items->sum('subtotal');
    $deliveryFee = (float) ($order->delivery_fee ?? 0);
    $total = (float) ($order->total_price ?? ($subtotal + $deliveryFee));
    $quantity = max(1, (int) ($items->sum('quantity') ?: 1));
    $money = fn ($value) => '₱' . number_format((float) $value, 2);
    $orderNo = 'DOC-TX-BW-A4-CS-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT);
    $statusText = ucwords(strtolower(str_replace(['_', '-'], ' ', (string) ($order->lalamove_status ?: $order->status ?: 'Processing'))));
    $shippingName = $order->delivery_method === 'lalamove' ? 'Lalamove Delivery' : ($order->delivery_method === 'express' ? 'Express Delivery' : 'Standard Delivery');
    $fromDashboardOrders = request()->routeIs('myorders.*') || request()->routeIs('my-orders.*');
    $ordersHubRoute = $fromDashboardOrders ? route('myorders') : route('co.place-order');
    $ordersHubLabel = $fromDashboardOrders ? 'My Orders' : 'Order Tracking';
    $detailsRoute = $fromDashboardOrders ? route('myorders.show', $order) : route('co.place-order.show', $order);
@endphp
<style>
*{box-sizing:border-box}body{margin:0;background:#f7f7f8;color:#111827;font-family:Inter,system-ui,sans-serif}.co-topbar{height:58px;background:#050505;color:#fff;display:flex;align-items:center;gap:24px;padding:0 34px;position:sticky;top:0;z-index:50}.co-brand{min-width:190px;color:#fff;text-decoration:none}.co-brand strong{display:block;font-family:Georgia,serif;font-size:17px;letter-spacing:.06em;line-height:1}.co-brand span{display:block;margin-top:3px;color:#ff4f16;font-size:7px;font-weight:900;letter-spacing:.18em}.co-nav{display:flex;align-items:center;gap:29px;flex:1;height:100%}.co-nav a{height:100%;display:inline-flex;align-items:center;color:#fff;text-decoration:none;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.02em;position:relative}.co-nav a.active{color:#ff6a21}.co-nav a.active:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#ff4f16}.co-top-actions{display:flex;align-items:center;gap:14px}.co-search{height:30px;width:148px;border:0;border-radius:999px;background:#fff;color:#111827;padding:0 13px;font-size:10px;outline:0}.co-icon{color:#fff;text-decoration:none;font-size:16px;position:relative}.co-cart-dot{position:absolute;right:-4px;top:-5px;width:8px;height:8px;border-radius:50%;background:#ff4f16}.co-avatar{width:28px;height:28px;border-radius:50%;background:#fff3ed;color:#ff4f16;display:grid;place-items:center;font-weight:900;font-size:11px}.co-user{display:flex;align-items:center;gap:8px;color:#fff;font-size:11px;font-weight:900;text-decoration:none;white-space:nowrap}.od-page{max-width:980px;margin:0 auto;padding:24px 18px 42px}.od-crumb{display:flex;gap:8px;align-items:center;color:#8b95a1;font-size:11px;font-weight:800;margin-bottom:14px}.od-head{display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:14px}.od-title{font-size:25px;font-weight:900;margin:0}.od-back{height:38px;display:inline-flex;align-items:center;gap:8px;border:1px solid #e5e7eb;border-radius:8px;background:#fff;color:#111827;text-decoration:none;padding:0 13px;font-size:12px;font-weight:900}.od-card{background:#fff;border:1px solid #eceff3;border-radius:8px;margin-bottom:12px;overflow:hidden}.od-body{padding:18px}.od-shop{display:flex;align-items:center;justify-content:space-between;gap:12px;border-bottom:1px solid #f1f5f9;padding-bottom:14px}.od-shop strong{font-size:13px}.od-status{display:inline-flex;align-items:center;gap:7px;color:#ff4f16;font-size:12px;font-weight:900}.od-product{display:grid;grid-template-columns:82px minmax(0,1fr) auto;gap:14px;align-items:start;padding-top:16px}.od-thumb{width:82px;height:104px;border:1px solid #e5e7eb;border-radius:6px;background:linear-gradient(#fff,#f8fafc);padding:10px;display:grid;gap:5px}.od-thumb span{height:3px;border-radius:8px;background:#1118271f}.od-name{margin:0 0 8px;font-size:15px;font-weight:900}.od-meta{display:flex;flex-wrap:wrap;gap:9px;color:#6b7280;font-size:11px;font-weight:700}.od-price{text-align:right;font-weight:900}.od-section-title{font-size:14px;font-weight:900;margin:0 0 14px}.od-line{display:flex;justify-content:space-between;gap:16px;margin:10px 0;color:#374151;font-size:12px}.od-line strong{text-align:right;color:#111827}.od-total{padding-top:12px;border-top:1px solid #f1f5f9;margin-top:14px}.od-total strong{font-size:20px;color:#ff4f16}.od-actions{display:grid;grid-template-columns:1fr 1fr;gap:10px}.od-btn{height:44px;border:1px solid #e5e7eb;border-radius:8px;background:#fff;color:#111827;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-size:12px;font-weight:900}.od-btn.primary{border:0;background:#ff4f16;color:#fff}.od-note{padding:12px 14px;background:#fff8f2;border:1px solid #fed7aa;border-radius:8px;color:#6b3b18;font-size:12px;line-height:1.5}.od-address{line-height:1.45;text-align:right;max-width:420px}.od-files{display:grid;gap:8px}.od-file{height:38px;display:flex;align-items:center;justify-content:space-between;gap:10px;border:1px solid #edf0f4;border-radius:8px;padding:0 12px;color:#111827;text-decoration:none;font-size:12px;font-weight:800}
@media(max-width:720px){.co-topbar{height:auto;min-height:58px;align-items:flex-start;flex-wrap:wrap;padding:13px 16px}.co-brand{min-width:140px}.co-nav{order:3;width:100%;overflow:auto;gap:20px}.co-nav a{height:35px}.co-search{width:132px}.co-user span{display:none}.od-head{display:grid}.od-product{grid-template-columns:70px minmax(0,1fr)}.od-price{grid-column:2;text-align:left}.od-actions{grid-template-columns:1fr}.od-line{display:grid}.od-line strong{text-align:left}.od-address{text-align:left}}
</style>
</head>
<body>
@include('components.customer-front-header')

<main class="od-page">
  <nav class="od-crumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Back to Home</a><i class="fa-solid fa-chevron-right"></i><a href="{{ route('dashboard') }}">Dashboard</a><i class="fa-solid fa-chevron-right"></i><a href="{{ $ordersHubRoute }}">{{ $ordersHubLabel }}</a><i class="fa-solid fa-chevron-right"></i><a class="active" href="{{ $detailsRoute }}">Order Details</a></nav>
  <div class="od-head">
    <h1 class="od-title">Order Details</h1>
    <a class="od-back" href="{{ $ordersHubRoute }}"><i class="fa-solid fa-arrow-left"></i>Back to {{ $ordersHubLabel }}</a>
  </div>

  <section class="od-card">
    <div class="od-body">
      <div class="od-shop">
        <strong><i class="fa-solid fa-store" style="color:#ff4f16;margin-right:7px"></i>Printify &amp; Co.</strong>
        <span class="od-status"><i class="fa-solid fa-truck-fast"></i>{{ $statusText }}</span>
      </div>
      <div class="od-product">
        <div class="od-thumb" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span><span></span></div>
        <div>
          <h2 class="od-name">{{ $item?->service_name ?? $item?->service?->name ?? 'Text Only Printing' }}</h2>
          <div class="od-meta">
            <span>{{ $item?->variation_label ?? 'A4 (8.27 x 11.69)' }}</span>
            <span>{{ $quantity }} {{ $quantity === 1 ? 'sheet' : 'sheets' }}</span>
            <span>Black & White</span>
            <span>PDF</span>
          </div>
        </div>
        <div class="od-price">{{ $money($item?->subtotal ?? $subtotal) }}</div>
      </div>
    </div>
  </section>

  <section class="od-card">
    <div class="od-body">
      <h2 class="od-section-title">Order Information</h2>
      <div class="od-line"><span>Order No.</span><strong>{{ $orderNo }}</strong></div>
      <div class="od-line"><span>Order Date</span><strong>{{ optional($order->created_at)->format('M d, Y - h:i A') }}</strong></div>
      <div class="od-line"><span>Shipping Method</span><strong>{{ $shippingName }}</strong></div>
      <div class="od-line"><span>Shipping Address</span><strong class="od-address">{{ $order->delivery_address ?: 'No delivery address saved.' }}</strong></div>
    </div>
  </section>

  <section class="od-card">
    <div class="od-body">
      <h2 class="od-section-title">Payment Summary</h2>
      <div class="od-line"><span>Subtotal</span><strong>{{ $money($subtotal) }}</strong></div>
      <div class="od-line"><span>Shipping Fee</span><strong>{{ $money($deliveryFee) }}</strong></div>
      <div class="od-line od-total"><span>Total Paid</span><strong>{{ $money($total) }}</strong></div>
    </div>
  </section>

  @if(isset($order->files) && $order->files->count())
  <section class="od-card">
    <div class="od-body">
      <h2 class="od-section-title">Uploaded Files</h2>
      <div class="od-files">
        @foreach($order->files as $file)
          <a class="od-file" href="{{ \Illuminate\Support\Facades\Storage::url($file->path) }}" target="_blank" rel="noopener"><span>{{ $file->original_name }}</span><i class="fa-solid fa-download"></i></a>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <section class="od-card">
    <div class="od-body">
      <div class="od-note">Tracking details are available after opening this order, just like a shop order history flow.</div>
      <div class="od-actions" style="margin-top:14px">
        <a class="od-btn primary" href="{{ route('co.place-order.tracking', $order) }}"><i class="fa-solid fa-location-dot"></i>View &amp; Track</a>
        <a class="od-btn" href="{{ route('help-center') }}"><i class="fa-solid fa-headset"></i>Contact Support</a>
      </div>
    </div>
  </section>
</main>
</body>
</html>
