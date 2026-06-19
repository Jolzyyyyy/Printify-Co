<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Order Tracking | Printify & Co.</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">

@php
    $user = auth()->user();
    $isAdminView = false;
    $items = $order->items ?? collect();
    $item = $items->first();
    $subtotal = (float) $items->sum('subtotal');
    $deliveryFee = (float) ($order->delivery_fee ?? 0);
    $total = (float) ($order->total_price ?? ($subtotal + $deliveryFee));
    $money = fn ($value) => '₱' . number_format((float) $value, 2);
    $orderNo = 'DOC-TX-BW-A4-CS-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT);
    $rawStatus = strtolower((string) ($order->lalamove_status ?: $order->status ?: 'pending'));
    $trackingStep = match (true) {
        str_contains($rawStatus, 'delivered') || str_contains($rawStatus, 'completed') => 6,
        str_contains($rawStatus, 'out_for_delivery') => 5,
        str_contains($rawStatus, 'transit') || str_contains($rawStatus, 'picked') => 4,
        str_contains($rawStatus, 'ship') || str_contains($rawStatus, 'assigned') => 3,
        str_contains($rawStatus, 'confirm') || str_contains($rawStatus, 'paid') || str_contains($rawStatus, 'cod') || str_contains($rawStatus, 'quote') => 2,
        default => 1,
    };
    $trackingLabel = match (true) {
        str_contains($rawStatus, 'delivered') || str_contains($rawStatus, 'completed') => 'Delivered',
        str_contains($rawStatus, 'transit') || str_contains($rawStatus, 'picked') => 'In Transit',
        str_contains($rawStatus, 'ship') || str_contains($rawStatus, 'assigned') => 'Shipped',
        str_contains($rawStatus, 'fail') => 'Booking Failed',
        default => 'Preparing for Shipment',
    };
    $quantity = max(1, (int) ($items->sum('quantity') ?: 1));
    $paymentName = str_contains(strtolower((string) $order->status), 'cod') ? 'Cash on Delivery' : 'Maya';
@endphp

<style>
*{box-sizing:border-box}body{margin:0;background:#fff;color:#111827;font-family:Inter,system-ui,sans-serif}.co-topbar{height:58px;background:#050505;color:#fff;display:flex;align-items:center;gap:24px;padding:0 34px;position:sticky;top:0;z-index:50}.co-brand{min-width:190px;color:#fff;text-decoration:none}.co-brand strong{display:block;font-family:Georgia,serif;font-size:17px;letter-spacing:.06em;line-height:1}.co-brand span{display:block;margin-top:3px;color:#ff4f16;font-size:7px;font-weight:900;letter-spacing:.18em}.co-nav{display:flex;align-items:center;gap:29px;flex:1;height:100%}.co-nav a{height:100%;display:inline-flex;align-items:center;color:#fff;text-decoration:none;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.02em;position:relative}.co-nav a.active{color:#ff6a21}.co-nav a.active:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#ff4f16}.co-top-actions{display:flex;align-items:center;gap:14px}.co-search{height:30px;width:148px;border:0;border-radius:999px;background:#fff;color:#111827;padding:0 13px;font-size:10px;outline:0}.co-icon{color:#fff;text-decoration:none;font-size:16px;position:relative}.co-cart-dot{position:absolute;right:-4px;top:-5px;width:8px;height:8px;border-radius:50%;background:#ff4f16}.co-avatar{width:28px;height:28px;border-radius:50%;background:#fff3ed;color:#ff4f16;display:grid;place-items:center;font-weight:900;font-size:11px}.co-user{display:flex;align-items:center;gap:8px;color:#fff;font-size:11px;font-weight:900;text-decoration:none;white-space:nowrap}.ot-page{min-height:calc(100vh - 58px);background:#fff}.ot-wrap{max-width:1210px;margin:0 auto;padding:24px 18px 30px}.ot-crumb{display:flex;gap:8px;align-items:center;color:#8b95a1;font-size:11px;font-weight:700;margin-bottom:13px}.ot-head{display:flex;justify-content:space-between;align-items:flex-start;gap:18px;margin-bottom:20px}.ot-title{margin:0;font-size:29px;letter-spacing:-.02em;line-height:1.1;font-weight:900}.ot-sub{margin:7px 0 0;color:#6b7280;font-size:13px}.ot-btn{height:38px;border:1px solid #e5e7eb;border-radius:8px;background:#fff;color:#111827!important;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:0 14px;text-decoration:none;font-size:12px;font-weight:900;cursor:pointer}.ot-btn.primary{border:0;background:#ff4f16;color:#fff!important}.ot-alert{margin-bottom:14px;padding:11px 13px;border-radius:8px;font-size:12px;font-weight:800}.ot-alert.success{background:#ecfdf3;color:#166534}.ot-alert.error{background:#fef2f2;color:#991b1b}
.ot-hero{display:grid;grid-template-columns:126px minmax(0,1fr) 240px;gap:24px;align-items:center;border:1px solid #edf0f4;border-radius:8px;padding:18px 20px;margin-bottom:14px}.ot-paper{width:94px;height:124px;border:1px solid #e5e7eb;border-radius:4px;background:linear-gradient(#fff,#f8fafc);padding:10px;display:grid;gap:5px}.ot-paper span{height:3px;border-radius:8px;background:#1118271f}.ot-pages{display:inline-flex;margin-top:8px;padding:6px 12px;border:1px solid #eef0f4;border-radius:7px;font-size:11px;font-weight:800}.ot-product{font-size:17px;font-weight:900;margin:0 0 10px}.ot-meta{display:flex;flex-wrap:wrap;gap:14px;color:#374151;font-size:11px;font-weight:700}.ot-meta i{color:#6b7280;margin-right:5px}.ot-hero-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:18px;margin-top:22px}.ot-label{display:block;color:#6b7280;font-size:10px;font-weight:900}.ot-value{display:block;margin-top:6px;color:#111827;font-size:12px;font-weight:900}.ot-status-card{align-self:stretch;display:grid;align-content:center;gap:12px}.ot-pill{display:inline-flex;align-items:center;gap:7px;width:max-content;padding:8px 12px;border-radius:8px;background:#fff3ed;color:#ff4f16;font-size:12px;font-weight:900}.ot-dispatch{padding:12px;border-radius:6px;background:#f5f9ff;color:#334155;font-size:11px;line-height:1.45}.ot-dispatch i{color:#2580d9;margin-right:6px}
.ot-grid{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:18px;align-items:start}.ot-stack{display:grid;gap:14px}.ot-card{border:1px solid #edf0f4;border-radius:8px;background:#fff;box-shadow:0 12px 34px rgba(15,23,42,.035)}.ot-body{padding:18px}.ot-card-title{margin:0 0 16px;font-size:14px;font-weight:900}.ot-progress{display:grid;grid-template-columns:repeat(6,1fr);position:relative}.ot-progress:before{content:"";position:absolute;left:8%;right:8%;top:17px;height:2px;background:#e5e7eb}.ot-progress-fill{position:absolute;left:8%;top:17px;height:2px;background:#ff4f16;width:calc((var(--step) - 1) * 16.8%)}.ot-step{position:relative;z-index:1;text-align:center}.ot-dot{width:34px;height:34px;margin:0 auto 7px;border-radius:50%;border:2px solid #e5e7eb;background:#fff;color:#9ca3af;display:grid;place-items:center}.ot-step.done .ot-dot,.ot-step.current .ot-dot{background:#ff4f16;border-color:#ff4f16;color:#fff}.ot-step strong{display:block;font-size:10px}.ot-step small{display:block;margin-top:3px;color:#6b7280;font-size:9px}.ot-prep{display:grid;grid-template-columns:80px minmax(0,1fr);gap:16px;margin-top:18px;padding:18px;border-radius:8px;background:#fff8f2}.ot-prep i{font-size:48px;color:#ff4f16}.ot-prep strong{font-size:13px}.ot-prep p{margin:6px 0 0;font-size:11px;color:#4b5563;line-height:1.5}
.ot-map{min-height:245px;border:1px solid #dbeafe;border-radius:8px;overflow:hidden;display:grid;grid-template-columns:195px minmax(0,1fr);background:linear-gradient(135deg,#e8f2fc,#f8fff4)}.ot-map-info{background:#fff;padding:16px;display:grid;align-content:start;gap:14px;font-size:11px}.ot-map-info strong{display:block;font-size:11px}.ot-map-art{position:relative;overflow:hidden}.ot-road{position:absolute;left:48px;right:80px;top:95px;border-top:3px dashed #c56d2e;transform:rotate(7deg)}.ot-map-pin,.ot-map-truck{position:absolute;width:36px;height:36px;border-radius:50%;background:#fff;display:grid;place-items:center;box-shadow:0 10px 22px rgba(15,23,42,.12)}.ot-map-pin{left:52px;top:72px}.ot-map-truck{right:84px;top:114px}.ot-current{position:absolute;right:30px;top:88px;width:155px;background:#fff;border-radius:8px;padding:13px;font-size:10px;box-shadow:0 14px 30px rgba(15,23,42,.12)}
.ot-timeline{display:grid;gap:0}.ot-event{display:grid;grid-template-columns:150px minmax(0,1fr);gap:18px;padding:14px;border-top:1px solid #f1f5f9;position:relative}.ot-event:first-child{border-top:0;background:#fff8f2}.ot-event:before{content:"";position:absolute;left:12px;top:20px;width:7px;height:7px;border-radius:50%;background:#ff4f16}.ot-event time{padding-left:18px;color:#6b7280;font-size:11px}.ot-event strong{font-size:12px}.ot-event p{margin:4px 0 0;color:#4b5563;font-size:11px;line-height:1.4}
.ot-side-item{display:grid;grid-template-columns:58px minmax(0,1fr);gap:12px;align-items:center}.ot-side-thumb{width:58px;height:74px;border:1px solid #e5e7eb;border-radius:5px;background:#f8fafc}.ot-summary-line{display:flex;justify-content:space-between;gap:12px;margin:10px 0;font-size:11px}.ot-summary-line strong{text-align:right}.ot-total{margin-top:14px;padding-top:14px;border-top:1px solid #edf0f4}.ot-total strong{font-size:20px;color:#ff4f16}.ot-paybrand{display:block;text-align:right;color:#16a34a;font-size:19px;font-weight:900}.ot-address{font-size:11px;line-height:1.5;color:#374151}.ot-actions{display:grid;gap:10px;margin-top:16px}.ot-refresh{display:inline}.ot-refresh button{width:100%}
@media(max-width:1040px){.ot-grid,.ot-hero{grid-template-columns:1fr}.ot-hero-grid{grid-template-columns:repeat(2,1fr)}.ot-map{grid-template-columns:1fr}.ot-map-art{min-height:210px}.ot-progress{min-width:640px}.ot-progress-wrap{overflow:auto}}
@media(max-width:640px){.ot-wrap{padding:0 4px 24px}.ot-head{display:grid}.ot-hero-grid,.ot-event{grid-template-columns:1fr}.ot-event time{padding-left:18px}}
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

<div class="ot-page">
  <div class="ot-wrap">
    @if(session('success'))<div class="ot-alert success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="ot-alert error">{{ session('error') }}</div>@endif

    <div class="ot-crumb">Home <i class="fa-solid fa-chevron-right"></i> My Orders <i class="fa-solid fa-chevron-right"></i> Order Tracking</div>
    <div class="ot-head">
      <div>
        <h1 class="ot-title">{{ $isAdminView ? 'Order Details' : 'Order Tracking' }}</h1>
        <p class="ot-sub">Track your order status in real-time</p>
      </div>
      <a class="ot-btn" href="{{ route('co.place-order.show', $order) }}"><i class="fa-solid fa-arrow-left"></i>Back to Order</a>
    </div>

    <section class="ot-hero">
      <div style="text-align:center">
        <div class="ot-paper" aria-hidden="true"><span></span><span></span><span style="width:65%"></span><span></span><span></span><span style="width:55%"></span><span></span><span></span></div>
        <span class="ot-pages">{{ $quantity }} {{ $quantity === 1 ? 'page' : 'pages' }}</span>
      </div>
      <div>
        <h2 class="ot-product">{{ $item?->service_name ?? $item?->service?->name ?? 'Text Only Printing' }}</h2>
        <div class="ot-meta">
          <span><i class="fa-regular fa-file-lines"></i>{{ $item?->variation_label ?? 'A4 (8.27 x 11.69)' }}</span>
          <span><i class="fa-regular fa-copy"></i>{{ $quantity }} {{ $quantity === 1 ? 'sheet' : 'sheets' }}</span>
          <span><i class="fa-solid fa-droplet"></i>Black & White</span>
        </div>
        <div class="ot-hero-grid">
          <div><span class="ot-label">Service ID</span><span class="ot-value">{{ $orderNo }}</span></div>
          <div><span class="ot-label">Order Date</span><span class="ot-value">{{ optional($order->created_at)->format('M d, Y - h:i A') }}</span></div>
          <div><span class="ot-label">Payment Method</span><span class="ot-value">{{ $paymentName }}</span></div>
          <div><span class="ot-label">Total Paid</span><span class="ot-value" style="color:#ff4f16">{{ $money($total) }}</span></div>
        </div>
      </div>
      <div class="ot-status-card">
        <span class="ot-pill"><i class="fa-solid fa-truck-fast"></i>{{ $trackingLabel }}</span>
        <div>
          <span class="ot-label">Estimated Dispatch</span>
          <span class="ot-value">{{ optional($order->created_at)->addDay()->format('M d, Y') }}</span>
        </div>
        <div class="ot-dispatch"><i class="fa-regular fa-clock"></i>We're getting your order ready to ship.</div>
      </div>
    </section>

    <div class="ot-grid">
      <main class="ot-stack">
        <section class="ot-card">
          <div class="ot-body">
            <h2 class="ot-card-title">Tracking Progress</h2>
            <div class="ot-progress-wrap">
              <div class="ot-progress" style="--step:{{ $trackingStep }}">
                <span class="ot-progress-fill"></span>
                @foreach([['Order Confirmed','fa-check'],['Preparing','fa-box'],['Shipped','fa-truck'],['In Transit','fa-route'],['Out for Delivery','fa-person-biking'],['Delivered','fa-house-circle-check']] as $index => $progress)
                  <div class="ot-step {{ $index + 1 < $trackingStep ? 'done' : ($index + 1 === $trackingStep ? 'current' : '') }}">
                    <span class="ot-dot"><i class="fa-solid {{ $progress[1] }}"></i></span>
                    <strong>{{ $progress[0] }}</strong>
                    <small>{{ $index < 2 ? optional($order->created_at)->format('M d, h:i A') : '-' }}</small>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="ot-prep">
              <i class="fa-solid fa-box-open"></i>
              <div><strong>Your order is being prepared</strong><p>We're printing and preparing your items for shipment. Once it is shipped, we will update the tracking information.</p></div>
            </div>
          </div>
        </section>

        <section class="ot-card">
          <div class="ot-body">
            <h2 class="ot-card-title">Shipment Tracking</h2>
            <div class="ot-map">
              <div class="ot-map-info">
                <div><strong>Origin</strong>Printify & Co. Production Hub<br>Metro Manila</div>
                <div><strong>Destination</strong>{{ $order->delivery_address ?: 'Customer address pending' }}</div>
                <div><strong>Courier</strong>{{ $order->delivery_method === 'lalamove' ? 'Lalamove' : 'Printify Delivery' }}</div>
                <div><strong>Tracking No.</strong>{{ $order->lalamove_order_id ?: $orderNo }}</div>
                @if($order->lalamove_share_link)<a class="ot-btn" href="{{ $order->lalamove_share_link }}" target="_blank" rel="noopener">View on Courier Site <i class="fa-solid fa-up-right-from-square"></i></a>@endif
              </div>
              <div class="ot-map-art">
                <div class="ot-road"></div>
                <div class="ot-map-pin"><i class="fa-solid fa-building-columns"></i></div>
                <div class="ot-map-truck"><i class="fa-solid fa-truck"></i></div>
                <div class="ot-current"><strong>Current Status</strong><br>{{ $trackingLabel }}<br><span style="color:#6b7280">{{ optional($order->lalamove_last_synced_at ?: $order->updated_at)->format('M d, Y - h:i A') }}</span></div>
              </div>
            </div>
          </div>
        </section>

        <section class="ot-card">
          <div class="ot-body">
            <h2 class="ot-card-title">Order Timeline</h2>
            <div class="ot-timeline">
              <div class="ot-event"><time>{{ optional($order->updated_at)->format('M d, Y - h:i A') }}</time><div><strong>{{ $trackingLabel }}</strong><p>We are preparing your order for shipment.</p></div></div>
              <div class="ot-event"><time>{{ optional($order->created_at)->format('M d, Y - h:i A') }}</time><div><strong>Order Confirmed</strong><p>Your order has been confirmed and is being processed.</p></div></div>
              <div class="ot-event"><time>{{ optional($order->created_at)->format('M d, Y - h:i A') }}</time><div><strong>Payment Confirmed</strong><p>Payment of {{ $money($total) }} via {{ $paymentName }} was successful.</p></div></div>
            </div>
            <p style="margin:14px 0 0;color:#6b7280;font-size:10px">All times shown are in Philippine Standard Time (PST).</p>
          </div>
        </section>
      </main>

      <aside class="ot-stack">
        <section class="ot-card">
          <div class="ot-body">
            <h2 class="ot-card-title" style="display:flex;justify-content:space-between;align-items:center">Order Summary @if($isAdminView && !auth()->user()?->isAdminClient())<a class="ot-btn" href="{{ route('admin.orders.edit', $order) }}"><i class="fa-solid fa-pen"></i>Edit</a>@endif</h2>
            <div class="ot-side-item">
              <div class="ot-side-thumb"></div>
              <div><strong style="font-size:12px">{{ $item?->service_name ?? $item?->service?->name ?? 'Text Only Printing' }}</strong></div>
            </div>
            <div style="margin-top:18px">
              <div class="ot-summary-line"><span>Service ID</span><strong>{{ $orderNo }}</strong></div>
              <div class="ot-summary-line"><span>Printing Category</span><strong>Text Only</strong></div>
              <div class="ot-summary-line"><span>Color Variation</span><strong>Black & White</strong></div>
              <div class="ot-summary-line"><span>Paper</span><strong>80gsm White</strong></div>
              <div class="ot-summary-line"><span>Paper Size</span><strong>{{ $item?->variation_label ?? 'A4 (8.27 x 11.69)' }}</strong></div>
              <div class="ot-summary-line"><span>Quantity (Sheets)</span><strong>{{ $quantity }} {{ $quantity === 1 ? 'sheet' : 'sheets' }}</strong></div>
              <div class="ot-summary-line"><span>File Type</span><strong>PDF</strong></div>
            </div>
            <div style="margin-top:18px">
              <div class="ot-summary-line"><span>Subtotal</span><strong>{{ $money($subtotal) }}</strong></div>
              <div class="ot-summary-line"><span>Shipping Fee</span><strong>{{ $money($deliveryFee) }}</strong></div>
              <div class="ot-summary-line ot-total"><span>Total Paid</span><strong>{{ $money($total) }}</strong></div>
              <div class="ot-summary-line"><span>Paid via {{ $paymentName }}</span><span class="ot-paybrand">{{ $paymentName === 'Maya' ? 'maya' : 'COD' }}</span></div>
            </div>
            <div style="margin-top:20px">
              <h3 class="ot-card-title" style="font-size:12px;margin-bottom:10px">Shipping Details</h3>
              <div class="ot-summary-line"><span>Shipping Method</span><strong>{{ $order->delivery_method === 'lalamove' ? 'Lalamove Delivery' : 'Standard Delivery' }}</strong></div>
              <div class="ot-summary-line"><span>Shipping Address</span><strong class="ot-address">{{ $order->delivery_address ?: 'No delivery address saved.' }}</strong></div>
              @if($order->lalamove_driver_name)
                <div class="ot-summary-line"><span>Driver</span><strong>{{ $order->lalamove_driver_name }}</strong></div>
                <div class="ot-summary-line"><span>Driver Phone</span><strong>{{ $order->lalamove_driver_phone ?: '-' }}</strong></div>
                <div class="ot-summary-line"><span>Plate Number</span><strong>{{ $order->lalamove_plate_number ?: '-' }}</strong></div>
              @endif
            </div>
            <div class="ot-actions">
              <a class="ot-btn primary" href="{{ route('co.place-order.show', $order) }}">Back to Order Details</a>
              <a class="ot-btn" href="{{ route('help-center') }}"><i class="fa-solid fa-headset"></i>Contact Support</a>
              @if($order->delivery_method === 'lalamove' && !$order->lalamove_order_id)
                <form class="ot-refresh" method="POST" action="{{ route('orders.delivery.book', $order) }}">@csrf<button class="ot-btn" type="submit"><i class="fa-solid fa-truck-fast"></i>Retry Lalamove Booking</button></form>
              @endif
              @if($order->delivery_method === 'lalamove' && $order->lalamove_order_id)
                <form class="ot-refresh" method="POST" action="{{ route('orders.delivery.refresh', $order) }}">@csrf<button class="ot-btn" type="submit"><i class="fa-solid fa-rotate"></i>Refresh Lalamove Tracking</button></form>
              @endif
            </div>
          </div>
        </section>
      </aside>
    </div>
  </div>
</div>
</body>
</html>
