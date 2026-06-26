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
    $variation = $item?->serviceVariation;
    $files = $order->files ?? collect();
    $file = $files->first();
    $subtotal = (float) $items->sum('subtotal');
    $deliveryFee = (float) ($order->delivery_fee ?? 0);
    $total = (float) ($order->total_price ?? ($subtotal + $deliveryFee));
    $money = fn ($value) => '₱' . number_format((float) $value, 2);
    $orderNo = $order->order_reference ?: 'ORD-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT);
    $paidOrder = $order->paid_at
        || filled($order->payment_reference)
        || str_contains(strtolower((string) $order->status), 'paid')
        || str_contains(strtolower((string) $order->status), 'complete');
    $statusFallback = $paidOrder ? 'paid' : ($order->status ?: 'pending');
    $rawStatusSource = (string) ($order->lalamove_status ?: $order->delivery_booking_status ?: $order->delivery_status ?: $statusFallback);
    if ($paidOrder && !str_contains(strtolower($rawStatusSource), 'cancel') && !str_contains(strtolower($rawStatusSource), 'fail')) {
        $rawStatusSource = 'paid_' . $rawStatusSource;
    }
    $rawStatus = strtolower(str_replace([' ', '-'], '_', $rawStatusSource));
    $trackingStep = match (true) {
        str_contains($rawStatus, 'cancel') || str_contains($rawStatus, 'fail') || str_contains($rawStatus, 'expired') => 1,
        str_contains($rawStatus, 'delivered') || str_contains($rawStatus, 'completed') || str_contains($rawStatus, 'dropoff_completed') => 6,
        str_contains($rawStatus, 'out_for_delivery') || str_contains($rawStatus, 'near_dropoff') || str_contains($rawStatus, 'arrived_dropoff') => 5,
        str_contains($rawStatus, 'transit') || str_contains($rawStatus, 'picked') || str_contains($rawStatus, 'ongoing') || str_contains($rawStatus, 'en_route') || str_contains($rawStatus, 'picked_up') => 4,
        str_contains($rawStatus, 'ship') || str_contains($rawStatus, 'assigned') || str_contains($rawStatus, 'booked') || str_contains($rawStatus, 'accepted') || str_contains($rawStatus, 'driver') || str_contains($rawStatus, 'courier') => 3,
        str_contains($rawStatus, 'confirm') || str_contains($rawStatus, 'paid') || str_contains($rawStatus, 'cod') || str_contains($rawStatus, 'quote') || str_contains($rawStatus, 'processing') || str_contains($rawStatus, 'placed') || str_contains($rawStatus, 'approved') || str_contains($rawStatus, 'waiting_for_payment') => 2,
        default => 1,
    };
    $trackingLabel = match (true) {
        str_contains($rawStatus, 'cancel') => 'Cancelled',
        str_contains($rawStatus, 'fail') || str_contains($rawStatus, 'expired') => 'Booking Failed',
        str_contains($rawStatus, 'delivered') || str_contains($rawStatus, 'completed') || str_contains($rawStatus, 'dropoff_completed') => 'Delivered',
        str_contains($rawStatus, 'out_for_delivery') || str_contains($rawStatus, 'near_dropoff') || str_contains($rawStatus, 'arrived_dropoff') => 'Out for Delivery',
        str_contains($rawStatus, 'transit') || str_contains($rawStatus, 'picked') || str_contains($rawStatus, 'ongoing') || str_contains($rawStatus, 'en_route') || str_contains($rawStatus, 'picked_up') => 'In Transit',
        str_contains($rawStatus, 'ship') || str_contains($rawStatus, 'assigned') || str_contains($rawStatus, 'booked') || str_contains($rawStatus, 'accepted') || str_contains($rawStatus, 'driver') || str_contains($rawStatus, 'courier') => 'Shipped',
        str_contains($rawStatus, 'pending_payment') || str_contains($rawStatus, 'waiting_for_payment') => 'Waiting for Payment',
        str_contains($rawStatus, 'confirm') || str_contains($rawStatus, 'paid') || str_contains($rawStatus, 'processing') || str_contains($rawStatus, 'placed') || str_contains($rawStatus, 'approved') => 'Preparing for Shipment',
        default => 'Preparing for Shipment',
    };
    $quantity = max(1, (int) ($items->sum('quantity') ?: 1));
    $paymentName = match ((string) $order->payment_method) {
        'gcash' => 'GCash',
        'card' => 'Credit / Debit Card',
        'grab_pay' => 'GrabPay',
        'paymaya', 'maya' => 'Maya',
        'bank' => 'Online Banking',
        'cod' => 'Cash on Delivery',
        default => $order->payment_method ? str($order->payment_method)->replace('_', ' ')->title()->toString() : 'Not selected',
    };
    $paymentStatus = $order->paid_at || in_array(strtolower((string) $order->status), ['paid', 'completed'], true)
        ? 'Payment Confirmed'
        : (str_contains(strtolower((string) $order->status), 'pending') ? 'Payment Pending' : str((string) $order->status ?: 'Pending')->replace('_', ' ')->title()->toString());
    $paymentReference = $order->payment_reference ?: $order->payment_checkout_id;
    $deliveryType = (string) ($order->delivery_method ?: data_get($order->checkout_details, 'delivery.type', 'standard'));
    $deliveryName = data_get($order->checkout_details, 'delivery.name') ?: match ($deliveryType) {
        'lalamove' => 'Lalamove On-demand',
        'express' => 'Express Delivery',
        'pickup' => 'Store Pick-up',
        default => 'Standard Delivery',
    };
    $deliveryEta = match ($deliveryType) {
        'express' => '1-2 business days',
        'pickup' => 'No delivery needed',
        'lalamove' => 'Live rider tracking after booking',
        default => '3-5 business days',
    };
    $shippingAddress = $order->delivery_address ?: collect([
        data_get($order->checkout_details, 'shippingAddress.street'),
        data_get($order->checkout_details, 'shippingAddress.apartment'),
        data_get($order->checkout_details, 'shippingAddress.barangay'),
        data_get($order->checkout_details, 'shippingAddress.city'),
        data_get($order->checkout_details, 'shippingAddress.province'),
        data_get($order->checkout_details, 'shippingAddress.postal'),
        data_get($order->checkout_details, 'shippingAddress.country'),
    ])->filter(fn ($part) => filled($part))->implode(', ');
    $customerName = $order->customer_name ?: $user?->name;
    $primaryServiceName = $item?->service_name ?: $item?->service?->name ?: 'Print Order';
    $primaryVariationLabel = $item?->variation_label ?: $variation?->variation_label;
    $primaryCategory = $variation?->printing_category ?: data_get($order->checkout_details, 'items.0.printingCategory');
    $primaryColor = $variation?->color_mode ?: data_get($order->checkout_details, 'items.0.colorVariation');
    $primarySize = $variation?->product_size ?: $primaryVariationLabel;
    $primaryFinish = $variation?->finish_type ?: data_get($order->checkout_details, 'items.0.printOption');
    $serviceId = $item?->service_item_id ?: $variation?->service_item_id ?: $orderNo;
    $imageUrl = function (?string $path) {
        $path = trim((string) $path);
        if ($path === '') return null;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) return $path;
        if (str_starts_with($path, 'images/')) return asset($path);
        return \Illuminate\Support\Facades\Storage::disk('public')->exists($path)
            ? \Illuminate\Support\Facades\Storage::url($path)
            : asset($path);
    };
    $itemImage = fn ($line) => $imageUrl($line?->serviceVariation?->variation_image_path ?: $line?->service?->image_path);
    $primaryImage = $itemImage($item);
    $fileType = $file?->original_name ? strtoupper(pathinfo($file->original_name, PATHINFO_EXTENSION) ?: ($file->mime ?: 'File')) : 'No file attached';
    $courierTrackingNumber = $order->delivery_tracking_number ?: $order->lalamove_order_id;
    $trackingNumber = $courierTrackingNumber ?: ('PFY-TRK-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT));
    $trackingUrl = $order->delivery_tracking_url ?: $order->lalamove_share_link;
    $lalamoveConfigured = filled(config('services.lalamove.api_key')) && filled(config('services.lalamove.api_secret'));
    $lalamoveHasCoordinates = filled($order->delivery_latitude) && filled($order->delivery_longitude);
    $lalamoveBackendStatus = match (true) {
        $deliveryType !== 'lalamove' => 'Not required for this delivery method',
        (bool) $courierTrackingNumber => 'Live tracking connected',
        !$lalamoveConfigured => 'Lalamove setup needs API credentials',
        !$lalamoveHasCoordinates => 'Waiting for drop-off map coordinates',
        str_contains($rawStatus, 'fail') => 'Booking failed - retry available',
        default => 'Ready for Lalamove booking',
    };
    $statusTimestamp = $order->lalamove_last_synced_at ?: $order->delivery_booked_at ?: $order->paid_at ?: $order->updated_at;
    $estimatedDispatch = $order->delivery_booked_at ?: optional($order->created_at)->copy()?->addDay();
    $progressTimes = [
        optional($order->created_at)->format('M d, h:i A'),
        optional($order->paid_at ?: $order->created_at)->format('M d, h:i A'),
        optional($order->delivery_booked_at ?: ($trackingStep >= 3 ? $order->updated_at : null))->format('M d, h:i A'),
        optional($trackingStep >= 4 ? $statusTimestamp : null)->format('M d, h:i A'),
        optional($trackingStep >= 5 ? $statusTimestamp : null)->format('M d, h:i A'),
        optional($trackingStep >= 6 ? $statusTimestamp : null)->format('M d, h:i A'),
    ];
    $timeline = collect([
        [
            'time' => $statusTimestamp,
            'title' => $trackingLabel,
            'body' => match (true) {
                str_contains($rawStatus, 'fail') => 'Delivery booking needs attention from Printify & Co.',
                str_contains($rawStatus, 'pending_payment') || str_contains($rawStatus, 'waiting_for_payment') => 'Your order is recorded and waiting for payment confirmation.',
                default => 'Latest status for this order.',
            },
        ],
        $order->delivery_booked_at ? [
            'time' => $order->delivery_booked_at,
            'title' => 'Delivery Booked',
            'body' => $trackingNumber ? 'Courier tracking number: ' . $trackingNumber : 'Delivery booking was created.',
        ] : null,
        ($order->paid_at || $paymentReference) ? [
            'time' => $order->paid_at ?: $order->created_at,
            'title' => $paymentStatus,
            'body' => 'Payment method: ' . $paymentName . ($paymentReference ? ' · Reference: ' . $paymentReference : ''),
        ] : null,
        [
            'time' => $order->created_at,
            'title' => 'Order Placed',
            'body' => 'Order ' . $orderNo . ' was placed by ' . ($customerName ?: 'the customer') . '.',
        ],
    ])->filter()->unique(fn ($event) => ($event['title'] ?? '') . optional($event['time'])->timestamp)->values();
@endphp

<style>
@font-face{
  font-family:'Clash Display';
  src:url("{{ asset('Fonts/ClashDisplay-Semibold.otf') }}") format('opentype');
  font-weight:600;
  font-style:normal;
  font-display:swap;
}
@font-face{
  font-family:'League Spartan';
  src:url("{{ asset('Fonts/LeagueSpartan-SemiBold.otf') }}") format('opentype');
  font-weight:600;
  font-style:normal;
  font-display:swap;
}
@font-face{
  font-family:'InterFinal';
  src:url("{{ asset('Fonts/Inter.ttc') }}") format('truetype-collection');
  font-weight:400 700;
  font-style:normal;
  font-display:swap;
}
:root{
  --pf-orange:#ff7900;
  --pf-orange-start:#FE7B09;
  --pf-orange-end:#FFAB0A;
  --pf-black:#111827;
  --pf-text:#111827;
  --pf-muted:#6b7280;
  --pf-soft:#f8fafc;
  --pf-soft-orange:#fff3ed;
  --pf-line:#d9dee7;
  --pf-line-soft:#edf0f4;
  --pf-blue:#006eff;
  --pf-green:#16a34a;
  --pf-radius:8px;
  --pf-body-font:'InterFinal','Inter',Arial,sans-serif;
  --pf-heading-font:'Clash Display','League Spartan',Arial,sans-serif;
}
*{box-sizing:border-box}
html{scroll-behavior:smooth}
body{
  margin:0;
  background:#ffffff;
  color:var(--pf-text);
  font-family:var(--pf-body-font);
  font-size:14px;
  font-weight:400;
  letter-spacing:.12px;
}
a{text-decoration:none;color:inherit}
button,input,select,textarea{font:inherit}
button{cursor:pointer}

/* Header, same as Order Tracking */
.top-nav-bar{
  width:100%;
  background:#050505;
  color:#ffffff;
  position:sticky;
  top:0;
  z-index:100;
}
.premium-main-navbar{
  min-height:70px;
  display:flex;
  align-items:center;
  gap:28px;
  padding:0 36px;
}
.brand-logo-block{
  width:235px;
  min-width:235px;
  display:flex;
  flex-direction:column;
  color:#ffffff;
  line-height:1;
}
.brand-main-text{
  font-family:Georgia,serif;
  font-size:20px;
  font-weight:700;
  letter-spacing:.02em;
  white-space:nowrap;
}
.brand-sub-text{
  margin-top:6px;
  color:var(--pf-orange);
  font-family:var(--pf-heading-font);
  font-size:7px;
  font-weight:600;
  letter-spacing:.22em;
  text-transform:uppercase;
  white-space:nowrap;
}
.nav-horizontal{
  display:flex;
  align-items:center;
  justify-content:center;
  gap:38px;
  flex:1;
  min-width:0;
}
.nav-link{
  min-height:70px;
  display:inline-flex;
  align-items:center;
  color:#ffffff;
  font-family:var(--pf-heading-font);
  font-size:12px;
  font-weight:600;
  letter-spacing:.03em;
  text-transform:uppercase;
  position:relative;
  transition:color .18s ease;
}
.nav-link::after{
  content:"";
  position:absolute;
  left:0;
  right:0;
  bottom:0;
  height:2px;
  background:var(--pf-orange);
  transform:scaleX(0);
  transform-origin:left;
  transition:transform .18s ease;
}
.nav-link:hover,
.nav-link:focus-visible{
  color:var(--pf-orange);
  outline:0;
}
.nav-link:hover::after,
.nav-link:focus-visible::after{
  transform:scaleX(1);
}
.hero-signin-container{
  display:flex;
  align-items:center;
  justify-content:flex-end;
  gap:14px;
  min-width:360px;
}
.nav-search-box{
  width:220px;
  height:34px;
  display:flex;
  align-items:center;
  margin:0;
}
.nav-search-box input{
  width:100%;
  height:34px;
  border:0;
  border-radius:999px;
  background:#ffffff;
  color:var(--pf-black);
  padding:0 14px;
  font-family:var(--pf-body-font);
  font-size:12px;
  font-weight:400;
  outline:none;
}
.nav-icon-link{
  position:relative;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:7px;
  min-height:34px;
  color:#ffffff;
}
.nav-svg-icon{
  width:20px;
  height:20px;
  display:block;
  filter:brightness(0) invert(1);
}
.cart-badge{
  position:absolute;
  top:-4px;
  right:-7px;
  min-width:15px;
  height:15px;
  border-radius:999px;
  background:var(--pf-orange);
  color:#ffffff;
  font-size:9px;
  line-height:15px;
  text-align:center;
  padding:0 4px;
}
.account-label{
  max-width:95px;
  overflow:hidden;
  text-overflow:ellipsis;
  white-space:nowrap;
  font-size:12px;
  font-weight:500;
}

/* Order Details */
.ot-page{
  min-height:calc(100vh - 70px);
  background:#ffffff;
}
.ot-wrap{
  width:calc(100% - 112px);
  max-width:1500px;
  margin:0 32px 0 80px;
  padding:22px 0 38px;
}
.ot-alert{
  width:fit-content;
  max-width:100%;
  margin:0 0 14px;
  padding:10px 14px;
  border-radius:8px;
  font-size:12px;
  font-weight:500;
}
.ot-alert.success{background:#e9fff0;color:#157a3f;border:1px solid #b8f3ca}
.ot-alert.error{background:#fff0f0;color:#b42318;border:1px solid #ffd1d1}
.ot-toast{
  position:fixed;
  top:88px;
  left:50%;
  transform:translate(-50%,-12px);
  z-index:9999;
  min-width:260px;
  max-width:420px;
  padding:12px 18px;
  border-radius:14px;
  background:#111827;
  color:#ffffff;
  text-align:center;
  font-size:12px;
  line-height:1.35;
  opacity:0;
  pointer-events:none;
  transition:opacity .2s ease,transform .2s ease;
}
.ot-toast.show{
  opacity:1;
  transform:translate(-50%,0);
}
.ot-crumb{
  display:flex;
  align-items:center;
  flex-wrap:wrap;
  gap:10px;
  margin:0 0 16px;
  color:#8b95a1;
  font-size:12px;
  font-weight:700;
}
.ot-crumb a,
.ot-backline{
  border:0;
  background:transparent;
  color:#6b7280;
  display:inline-flex;
  align-items:center;
  gap:6px;
  font-family:var(--pf-body-font);
  font-size:12px;
  font-weight:700;
  cursor:pointer;
  padding:0;
  position:relative;
}
.ot-crumb a::after,
.ot-backline::after{
  content:"";
  position:absolute;
  left:0;
  right:0;
  bottom:-3px;
  height:1px;
  background:var(--pf-orange);
  transform:scaleX(0);
  transform-origin:left;
  transition:transform .16s ease;
}
.ot-crumb a:hover,
.ot-backline:hover,
.ot-crumb a:focus-visible,
.ot-backline:focus-visible{
  color:var(--pf-orange);
  outline:0;
}
.ot-crumb a:hover::after,
.ot-backline:hover::after,
.ot-crumb a:focus-visible::after,
.ot-backline:focus-visible::after{
  transform:scaleX(1);
}
.ot-crumb .current{color:var(--pf-orange);font-weight:700;position:relative;display:inline-flex;align-items:center;padding-bottom:3px}
.ot-crumb .current:after{content:"";position:absolute;left:0;right:0;bottom:-3px;height:2px;border-radius:999px;background:linear-gradient(90deg,var(--pf-orange-start),var(--pf-orange-end))}
.ot-crumb a i{font-size:11px;color:inherit;line-height:1}
.ot-head{
  display:flex;
  align-items:flex-end;
  justify-content:space-between;
  gap:18px;
  margin-bottom:18px;
}
.ot-title{
  margin:0;
  color:#000000;
  font-family:var(--pf-heading-font);
  font-size:38px;
  line-height:1;
  font-weight:600;
  letter-spacing:0;
  text-transform:uppercase;
}
.ot-sub{
  margin:7px 0 0;
  color:#303743;
  font-size:14px;
  font-weight:400;
  line-height:1.45;
}
.ot-top-actions{
  display:flex;
  align-items:center;
  gap:10px;
  flex-wrap:wrap;
  justify-content:flex-end;
}
.ot-hero{
  display:grid;
  grid-template-columns:104px minmax(0,1fr) 260px;
  gap:16px;
  align-items:center;
  max-width:100%;
  margin:0 0 14px;
  padding:14px 16px;
  border:1px solid #ffb98f;
  border-radius:8px;
  background:#ffffff;
  box-shadow:0 12px 34px rgba(15,23,42,.035);
}
.ot-paper{
  width:74px;
  height:94px;
  margin:0 auto;
  border:1px solid #e5e7eb;
  border-radius:5px;
  background:linear-gradient(#ffffff,#f8fafc);
  padding:8px;
  display:grid;
  gap:4px;
}
.ot-paper span{
  height:3px;
  border-radius:8px;
  background:rgba(17,24,39,.12);
}
.ot-paper-img{
  width:74px;
  height:94px;
  margin:0 auto;
  border:1px solid #e5e7eb;
  border-radius:6px;
  object-fit:cover;
  display:block;
  background:#f8fafc;
}
.ot-pages{
  display:inline-flex;
  margin-top:7px;
  padding:5px 10px;
  border:1px solid var(--pf-line-soft);
  border-radius:7px;
  background:#ffffff;
  color:#111827;
  font-size:11px;
  font-weight:500;
}
.ot-product{
  margin:0 0 8px;
  color:#111827;
  font-family:var(--pf-heading-font);
  font-size:20px;
  line-height:1.12;
  font-weight:600;
}
.ot-product small{
  color:#6b7280;
  font-family:var(--pf-body-font);
  font-size:12px;
  font-weight:500;
}
.ot-meta{
  display:flex;
  flex-wrap:wrap;
  gap:8px 12px;
  color:#374151;
  font-size:12px;
  font-weight:400;
  margin-bottom:10px;
}
.ot-meta span{
  display:inline-flex;
  align-items:center;
  gap:5px;
}
.ot-meta i{color:#6b7280;font-size:12px}
.ot-hero-grid{
  display:grid;
  grid-template-columns:repeat(4,minmax(0,1fr));
  gap:10px;
}
.ot-label{
  display:block;
  color:#6b7280;
  font-size:11px;
  font-weight:400;
  line-height:1.3;
}
.ot-value{
  display:block;
  margin-top:4px;
  color:#111827;
  font-size:12px;
  font-weight:500;
  line-height:1.35;
}
.ot-status-card{
  min-height:116px;
  border-left:1px solid var(--pf-line-soft);
  padding-left:16px;
  display:grid;
  align-content:center;
  gap:10px;
}
.ot-pill{
  display:inline-flex;
  align-items:center;
  gap:7px;
  width:max-content;
  padding:6px 10px;
  border-radius:999px;
  background:#fff3ed;
  color:var(--pf-orange);
  font-size:12px;
  font-weight:500;
  line-height:1;
}
.ot-dispatch{
  display:flex;
  align-items:center;
  gap:8px;
  padding:8px 10px;
  border-radius:6px;
  background:#f5f9ff;
  color:#1f2937;
  font-size:12px;
  line-height:1.35;
}
.ot-dispatch i{color:#2580d9}
.ot-grid{
  display:grid;
  grid-template-columns:minmax(0,1fr) 360px;
  gap:14px;
  align-items:start;
}
.ot-stack{
  display:grid;
  gap:14px;
}
.ot-card{
  border:1px solid var(--pf-line-soft);
  border-radius:8px;
  background:#ffffff;
  box-shadow:0 12px 34px rgba(15,23,42,.035);
  overflow:hidden;
}
.ot-body{
  padding:14px 16px;
}
.ot-card-title{
  margin:0 0 12px;
  color:#111827;
  font-family:var(--pf-heading-font);
  font-size:18px;
  line-height:1.15;
  font-weight:600;
}
.ot-card-title-row{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:12px;
}
.ot-progress-tools{
  display:flex;
  align-items:center;
  justify-content:flex-end;
  flex-wrap:wrap;
  gap:8px;
}
.ot-live-pill{
  min-height:28px;
  padding:6px 10px;
  border:1px solid #d9dee7;
  border-radius:999px;
  background:#ffffff;
  color:#111827;
  display:inline-flex;
  align-items:center;
  gap:7px;
  font-size:11px;
  font-weight:700;
  line-height:1;
  white-space:nowrap;
}
.ot-live-pill i{color:#10b981;font-size:11px}
.ot-live-pill.refreshing i{animation:otPulse .75s ease-in-out infinite alternate}
@keyframes otPulse{from{opacity:.45}to{opacity:1}}
.ot-card-title-row .ot-btn{
  min-height:28px;
  height:28px;
  padding:6px 10px;
  font-size:11px;
}
.ot-progress-wrap{
  width:100%;
  overflow:auto;
  padding:4px 0 8px;
}
.ot-progress{
  --step:1;
  min-width:760px;
  position:relative;
  display:grid;
  grid-template-columns:repeat(6,1fr);
  gap:0;
  padding-top:28px;
}
.ot-progress::before,
.ot-progress-fill{
  content:"";
  position:absolute;
  left:8.5%;
  right:8.5%;
  top:43px;
  height:3px;
  border-radius:999px;
}
.ot-progress::before{background:#e5e7eb}
.ot-progress-fill{
  right:auto;
  width:calc((var(--step) - 1) / 5 * 83%);
  background:linear-gradient(90deg,var(--pf-orange-start),var(--pf-orange-end));
}
.ot-step{
  position:relative;
  z-index:1;
  display:grid;
  justify-items:center;
  gap:7px;
  text-align:center;
}
.ot-dot{
  width:32px;
  height:32px;
  border-radius:999px;
  display:grid;
  place-items:center;
  background:#ffffff;
  border:1px solid #d9dee7;
  color:#9ca3af;
  font-size:12px;
}
.ot-step.done .ot-dot,
.ot-step.current .ot-dot{
  border-color:var(--pf-orange);
  background:linear-gradient(90deg,var(--pf-orange-start),var(--pf-orange-end));
  color:#111827;
}
.ot-step strong{
  color:#111827;
  font-size:11.5px;
  font-weight:500;
}
.ot-step small{
  color:#6b7280;
  font-size:10px;
  font-weight:400;
}
.ot-prep{
  margin-top:8px;
  padding:10px 12px;
  border-radius:8px;
  background:#fff7f2;
  border:1px solid #ffe1d2;
  display:flex;
  gap:10px;
  align-items:flex-start;
}
.ot-prep i{
  color:var(--pf-orange);
  font-size:16px;
  margin-top:2px;
}
.ot-prep strong{
  display:block;
  margin-bottom:3px;
  font-weight:500;
}
.ot-prep p{
  margin:0;
  color:#4b5563;
  font-size:12px;
  line-height:1.4;
}
.ot-map{
  display:grid;
  grid-template-columns:260px minmax(0,1fr);
  gap:12px;
  min-height:320px;
}
.ot-map-info{
  display:grid;
  gap:9px;
  align-content:start;
  color:#374151;
  font-size:12px;
  line-height:1.4;
}
.ot-map-info strong{
  display:block;
  color:#111827;
  font-size:12px;
  font-weight:500;
  margin-bottom:2px;
}
.ot-map-art{
  --track-progress:12%;
  --live-progress:var(--track-progress);
  position:relative;
  min-height:320px;
  border:1px solid #d9e5f2;
  border-radius:8px;
  background:
    radial-gradient(circle at 18% 26%,rgba(255,121,0,.14),transparent 16%),
    radial-gradient(circle at 78% 72%,rgba(0,110,255,.11),transparent 18%),
    linear-gradient(135deg,#f8fbff,#eef6ff);
  overflow:hidden;
}
.ot-map-frame{
  position:absolute;
  inset:0;
  width:100%;
  height:100%;
  border:0;
  display:block;
  filter:saturate(.92) contrast(.98);
}
.ot-map-shade{
  position:absolute;
  inset:0;
  z-index:1;
  pointer-events:none;
  background:linear-gradient(180deg,rgba(255,255,255,.08),rgba(255,255,255,.18));
}
.ot-map-route{
  position:absolute;
  inset:0;
  z-index:2;
  pointer-events:none;
}
.ot-map-route path{
  fill:none;
  stroke-linecap:round;
  stroke-linejoin:round;
}
.ot-route-base-svg{
  stroke:rgba(80,88,98,.45);
  stroke-width:2.8;
}
.ot-route-live-svg{
  stroke:var(--pf-orange);
  stroke-width:2.8;
  stroke-dasharray:8 9;
  animation:routeDash 1.1s linear infinite;
}
@keyframes routeDash{
  to{stroke-dashoffset:-34}
}
.ot-map-place{
  position:absolute;
  z-index:7;
  max-width:148px;
  padding:5px 8px;
  border:1px solid #e5e7eb;
  border-radius:999px;
  background:rgba(255,255,255,.93);
  color:#111827;
  font-size:10.5px;
  font-weight:500;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
  box-shadow:0 6px 15px rgba(15,23,42,.08);
}
.ot-map-place.origin{left:46px;top:28px}
.ot-map-place.destination{right:34px;bottom:28px}
.ot-map-street{
  position:absolute;
  z-index:1;
  color:#8b95a1;
  font-size:10px;
  font-weight:400;
  letter-spacing:.2px;
  opacity:.75;
}
.ot-map-street.one{left:22%;top:20%;transform:rotate(-7deg)}
.ot-map-street.two{right:17%;top:42%;transform:rotate(12deg)}
.ot-map-street.three{left:34%;bottom:18%;transform:rotate(-9deg)}
.ot-road,.ot-route-done{display:none}
.ot-map-pin,
.ot-destination-pin{
  position:absolute;
  width:36px;
  height:36px;
  border-radius:999px;
  display:grid;
  place-items:center;
  background:#ffffff;
  box-shadow:0 8px 20px rgba(15,23,42,.12);
  z-index:5;
}
.ot-map-pin{left:9%;top:30%;color:#ef4444}
.ot-destination-pin{right:9%;bottom:20%;color:var(--pf-green)}
.ot-rider{
  position:absolute;
  left:var(--live-progress);
  top:calc(58% - 25px);
  width:42px;
  height:42px;
  border-radius:999px;
  display:grid;
  place-items:center;
  background:linear-gradient(90deg,var(--pf-orange-start),var(--pf-orange-end));
  color:#111827;
  z-index:6;
  box-shadow:0 10px 26px rgba(255,121,0,.32);
  animation:riderBounce 1.1s ease-in-out infinite;
}
.ot-rider:after{
  content:"";
  position:absolute;
  inset:-8px;
  border:1px solid rgba(255,121,0,.35);
  border-radius:999px;
  animation:riderPulse 1.4s ease-out infinite;
}
.ot-rider i{font-size:18px}
.ot-map-art.focus-rider .ot-rider{
  box-shadow:0 0 0 10px rgba(255,121,0,.18),0 10px 26px rgba(255,121,0,.32);
}
.ot-current{
  position:absolute;
  right:12px;
  top:12px;
  width:172px;
  padding:9px 10px;
  border-radius:8px;
  background:rgba(255,255,255,.92);
  border:1px solid #e5e7eb;
  color:#111827;
  font-size:12px;
  line-height:1.4;
  z-index:5;
}
.ot-map-actions{
  position:absolute;
  left:12px;
  bottom:12px;
  z-index:6;
  display:flex;
  align-items:center;
  gap:8px;
  flex-wrap:wrap;
}
.ot-map-actions .ot-btn{
  min-width:0;
  height:31px;
  padding:0 12px;
  font-size:11px;
}
.ot-courier-card{
  position:absolute;
  left:12px;
  bottom:54px;
  z-index:7;
  width:min(320px,calc(100% - 24px));
  padding:10px 12px;
  border-radius:12px;
  background:rgba(255,255,255,.94);
  border:1px solid #e5e7eb;
  display:grid;
  grid-template-columns:40px minmax(0,1fr);
  gap:10px;
  align-items:center;
  box-shadow:0 12px 30px rgba(15,23,42,.12);
}
.ot-courier-logo{
  width:40px;
  height:40px;
  border-radius:8px;
  background:#fff3ed;
  color:var(--pf-orange);
  display:grid;
  place-items:center;
  font-size:12px;
  font-weight:600;
}
.ot-courier-card strong{
  display:block;
  color:#111827;
  font-size:13px;
  font-weight:600;
}
.ot-courier-card span{
  display:block;
  margin-top:2px;
  color:#6b7280;
  font-size:11px;
  line-height:1.25;
}
.ot-map-locate{
  position:absolute;
  right:18px;
  bottom:60px;
  z-index:7;
  width:42px;
  height:42px;
  border:0;
  border-radius:50%;
  background:#ffffff;
  color:#111827;
  display:grid;
  place-items:center;
  box-shadow:0 10px 28px rgba(15,23,42,.16);
}

/* Clean map: Google map background + rider icon only */
.ot-map-street,
.ot-map-place,
.ot-road,
.ot-route-done,
.ot-map-pin,
.ot-destination-pin,
.ot-current,
.ot-courier-card,
.ot-map-locate,
.ot-map-shade{
  display:none!important;
}
.ot-map-route{
  display:block!important;
  z-index:2!important;
}
.ot-route-base-svg{
  stroke:rgba(80,88,98,.35)!important;
  stroke-width:2.8!important;
}
.ot-route-live-svg{
  stroke:#10b981!important;
  stroke-width:2.8!important;
  stroke-dasharray:none!important;
  animation:none!important;
}
.ot-map-art{
  background:#eef6ff!important;
}
.ot-rider{
  position:absolute!important;
  left:var(--track-progress)!important;
  top:58%!important;
  width:48px!important;
  height:48px!important;
  border-radius:50%!important;
  background:#ffffff!important;
  border:3px solid #10b981!important;
  color:#111827!important;
  z-index:6!important;
  box-shadow:0 10px 24px rgba(15,23,42,.22)!important;
  animation:none!important;
  transform:translate(-50%,-50%)!important;
  display:grid!important;
  place-items:center!important;
}
.ot-rider:after{
  content:none!important;
  display:none!important;
}
.ot-rider .ot-motor-icon{
  font-size:20px!important;
  color:#111827!important;
}
.ot-rider .ot-person-icon{
  position:absolute;
  right:6px;
  top:5px;
  width:15px;
  height:15px;
  border-radius:50%;
  display:grid;
  place-items:center;
  background:#10b981;
  color:#ffffff;
  font-size:8px!important;
  border:2px solid #ffffff;
}
.ot-rider:before{
  content:"";
  position:absolute;
  left:50%;
  bottom:-9px;
  transform:translateX(-50%);
  width:0;
  height:0;
  border-left:8px solid transparent;
  border-right:8px solid transparent;
  border-top:10px solid #10b981;
}

.ot-map-info-actions{
  display:flex;
  flex-wrap:wrap;
  align-items:center;
  gap:8px;
  margin-top:4px;
}
.ot-map-info-actions .ot-btn{
  min-width:0;
  height:31px;
  padding:0 12px;
  font-size:11px;
}

@keyframes riderBounce{
  0%,100%{transform:translate(-56%,0)}
  50%{transform:translate(-44%,-5px)}
}
@keyframes riderPulse{
  0%{opacity:.7;transform:scale(.85)}
  100%{opacity:0;transform:scale(1.35)}
}
.ot-timeline{
  display:grid;
  gap:0;
  border:1px solid #eef0f4;
  border-radius:8px;
  overflow:hidden;
}
.ot-event{
  position:relative;
  display:grid;
  grid-template-columns:150px minmax(0,1fr);
  gap:12px;
  padding:10px 12px 10px 28px;
  border-top:1px solid #eef0f4;
  background:#ffffff;
}
.ot-event:first-child{
  border-top:0;
  background:#fff8f2;
}
.ot-event::before{
  content:"";
  position:absolute;
  left:12px;
  top:16px;
  width:7px;
  height:7px;
  border-radius:50%;
  background:var(--pf-orange);
}
.ot-event time{
  color:#6b7280;
  font-size:11px;
  line-height:1.35;
}
.ot-event strong{
  color:#111827;
  font-size:12px;
  font-weight:500;
}
.ot-event p{
  margin:3px 0 0;
  color:#4b5563;
  font-size:12px;
  line-height:1.35;
}
.ot-side-item{
  display:grid;
  grid-template-columns:58px minmax(0,1fr);
  gap:12px;
  align-items:center;
}
.ot-side-thumb{
  width:58px;
  height:74px;
  border:1px solid #e5e7eb;
  border-radius:5px;
  background:linear-gradient(#ffffff,#f8fafc);
  padding:7px;
  display:grid;
  gap:4px;
}
.ot-side-thumb span{
  height:3px;
  border-radius:8px;
  background:rgba(17,24,39,.12);
}
.ot-side-thumb-img{
  width:58px;
  height:74px;
  border:1px solid #e5e7eb;
  border-radius:6px;
  object-fit:cover;
  display:block;
  background:#f8fafc;
}
.ot-side-item+.ot-side-item{
  margin-top:12px;
  padding-top:12px;
  border-top:1px solid #f1f5f9;
}
.ot-item-name{
  display:block;
  color:#111827;
  font-size:12px;
  font-weight:500;
  line-height:1.25;
}
.ot-item-meta{
  margin-top:4px;
  color:#6b7280;
  font-size:11px;
  line-height:1.4;
}
.ot-summary-group{
  margin-top:16px;
}
.ot-summary-line{
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  gap:12px;
  margin:9px 0;
  color:#374151;
  font-size:12px;
  line-height:1.35;
}
.ot-summary-line span:first-child{
  color:#6b7280;
  font-weight:400;
}
.ot-summary-line strong{
  color:#111827;
  text-align:right;
  font-weight:500;
}
.ot-total{
  margin-top:12px;
  padding-top:12px;
  border-top:1px solid #edf0f4;
}
.ot-total strong{
  color:var(--pf-orange);
  font-size:18px;
  font-weight:600;
}
.ot-address{
  max-width:205px;
  color:#374151!important;
  font-size:12px;
  line-height:1.5;
  word-break:break-word;
}
.ot-file-list{
  display:grid;
  gap:8px;
  margin-top:10px;
}
.ot-file{
  min-height:34px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:10px;
  padding:8px 10px;
  border:1px solid #eef0f4;
  border-radius:7px;
  color:#111827;
  font-size:12px;
  font-weight:400;
  transition:background .18s ease,color .18s ease;
}
.ot-file:hover,
.ot-file:focus-visible{
  background:#fff3ed;
  color:var(--pf-orange);
  outline:0;
}
.ot-actions{
  display:grid;
  gap:9px;
  margin-top:16px;
}
.ot-refresh{display:block;margin:0}
.ot-refresh button{width:100%}
.ot-btn{
  min-width:126px;
  height:34px;
  border:0;
  border-radius:999px;
  background:linear-gradient(90deg,var(--pf-orange-start),var(--pf-orange-end));
  color:#111827!important;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  padding:0 16px;
  font-family:var(--pf-body-font);
  font-size:11.5px;
  font-weight:500;
  letter-spacing:0;
  text-transform:none;
  text-align:center;
  box-shadow:none;
  transition:background .18s ease,color .18s ease,border-color .18s ease;
}
.ot-btn i{color:#111827}
.ot-btn:hover,
.ot-btn:focus-visible{
  background:#111827;
  color:#ffffff!important;
  outline:0;
}
.ot-btn:hover i,
.ot-btn:focus-visible i{color:#ffffff}
.ot-btn.secondary{
  background:#ffffff;
  border:1px solid #cfd7e3;
  color:#111827!important;
}
.ot-btn.secondary:hover,
.ot-btn.secondary:focus-visible{
  background:#fffaf5;
  color:#111827!important;
  border-color:#cfd7e3;
}
.ot-btn.secondary:hover i,
.ot-btn.secondary:focus-visible i{color:var(--pf-orange)}
.ot-btn.full{width:100%}
.ot-muted-note{
  margin:12px 0 0;
  color:#6b7280;
  font-size:11px;
}

@media(max-width:1180px){
  .premium-main-navbar{
    flex-wrap:wrap;
    padding:14px 24px;
  }
  .nav-horizontal{
    order:3;
    width:100%;
    justify-content:flex-start;
    gap:28px;
    overflow:auto;
  }
  .nav-link{min-height:36px}
  .hero-signin-container{min-width:0;margin-left:auto}
  .ot-wrap{
    width:calc(100% - 44px);
    max-width:none;
    margin:0 auto;
    padding:24px 0 42px;
  }
  .ot-hero,
  .ot-grid{
    grid-template-columns:1fr;
  }
  .ot-status-card{
    border-left:0;
    border-top:1px solid var(--pf-line-soft);
    padding:14px 0 0;
  }
  .ot-hero-grid{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }
}
@media(max-width:820px){
  .brand-logo-block{width:auto;min-width:190px}
  .brand-main-text{font-size:18px}
  .hero-signin-container{width:100%;justify-content:flex-start;flex-wrap:wrap}
  .nav-search-box{width:min(100%,260px)}
  .ot-wrap{
    width:calc(100% - 28px);
    max-width:none;
    margin:0 auto;
    padding:22px 0 36px;
  }
  .ot-title{font-size:34px}
  .ot-head{align-items:flex-start;flex-direction:column}
  .ot-top-actions{justify-content:flex-start}
  .ot-hero-grid,
  .ot-map,
  .ot-event{grid-template-columns:1fr}
  .ot-current{position:static;width:auto;margin:12px}
  .ot-map-actions{position:static;margin:12px}
  .ot-courier-card{position:static;width:auto;margin:12px}
  .ot-map-locate{right:16px;bottom:16px}
  .ot-progress{min-width:720px}
  .ot-event time{font-size:10.5px}
}
@media(max-width:520px){
  .ot-top-actions,.ot-btn{width:100%}
  .ot-hero{padding:12px}
  .ot-body{padding:12px}
}
@media print{
  .top-nav-bar,.customer-front-header,.ot-top-actions,.ot-actions,.ot-toast{display:none!important}
  .ot-wrap{width:100%;max-width:none;margin:0;padding:0}
  .ot-card,.ot-hero{box-shadow:none;break-inside:avoid}
}
</style>
</head>
<body>
@include('components.customer-front-header', ['frontActive' => ''])

<div id="otToast" class="ot-toast" role="status" aria-live="polite"></div>

<div class="ot-page">
  <div class="ot-wrap">
    @if(session('success'))
      <div class="ot-alert success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="ot-alert error">{{ session('error') }}</div>
    @endif

    <div class="ot-crumb">
      <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i>Back to Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('myorders') }}">My Orders</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('co.place-order') }}">Order Tracking</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span class="current">Order Details</span>
    </div>

    <div class="ot-head">
      <div>
        <h1 class="ot-title">{{ $isAdminView ? 'Order Details' : 'Order Tracking' }}</h1>
        <p class="ot-sub">Track your order status in real-time</p>
      </div>

      <div class="ot-top-actions">
        <button class="ot-btn secondary" type="button" data-copy-order="{{ $orderNo }}">
          <i class="fa-regular fa-copy"></i>Copy Order No.
        </button>
        @if($trackingUrl)
          <a class="ot-btn secondary" href="{{ $trackingUrl }}" target="_blank" rel="noopener">
            <i class="fa-solid fa-up-right-from-square"></i>Courier Link
          </a>
        @endif
        <button class="ot-btn" type="button" data-print-order>
          <i class="fa-solid fa-print"></i>Print Details
        </button>
      </div>
    </div>

    <section class="ot-hero">
      <div style="text-align:center">
        @if($primaryImage)
          <img class="ot-paper-img" src="{{ $primaryImage }}" alt="{{ $primaryServiceName }}">
        @else
          <div class="ot-paper" aria-hidden="true">
            <span></span><span></span><span style="width:65%"></span><span></span><span></span><span style="width:55%"></span><span></span><span></span>
          </div>
        @endif
        <span class="ot-pages">{{ $quantity }} {{ $quantity === 1 ? 'page' : 'pages' }}</span>
      </div>

      <div>
        <h2 class="ot-product">
          {{ $primaryServiceName }}
          @if($items->count() > 1)
            <small>+ {{ $items->count() - 1 }} more</small>
          @endif
        </h2>

        <div class="ot-meta">
          <span><i class="fa-regular fa-file-lines"></i>{{ $primarySize ?: $primaryVariationLabel ?: 'Size not set' }}</span>
          <span><i class="fa-regular fa-copy"></i>{{ $quantity }} {{ $quantity === 1 ? 'sheet' : 'sheets' }}</span>
          <span><i class="fa-solid fa-droplet"></i>{{ $primaryColor ?: 'Color not set' }}</span>
          @if($primaryFinish)
            <span><i class="fa-solid fa-print"></i>{{ $primaryFinish }}</span>
          @endif
        </div>

        <div class="ot-hero-grid">
          <div><span class="ot-label">Order No.</span><span class="ot-value">{{ $orderNo }}</span></div>
          <div><span class="ot-label">Order Date</span><span class="ot-value">{{ optional($order->created_at)->format('M d, Y - h:i A') }}</span></div>
          <div><span class="ot-label">Payment Method</span><span class="ot-value">{{ $paymentName }}</span></div>
          <div><span class="ot-label">{{ $paymentStatus }}</span><span class="ot-value" style="color:#ff7900">{{ $money($total) }}</span></div>
        </div>
      </div>

      <div class="ot-status-card">
        <span class="ot-pill" data-hero-status><i class="fa-solid fa-truck-fast"></i>{{ $trackingLabel }}</span>
        <div>
          <span class="ot-label">Estimated Dispatch</span>
          <span class="ot-value">{{ optional($estimatedDispatch)->format('M d, Y') ?: 'To be scheduled' }}</span>
        </div>
        <div class="ot-dispatch"><i class="fa-regular fa-clock"></i>{{ $deliveryName }}{{ $deliveryEta ? ' · ' . $deliveryEta : '' }}</div>
      </div>
    </section>

    <div class="ot-grid">
      <main class="ot-stack">
        <section class="ot-card">
          <div class="ot-body">
            <div class="ot-card-title-row">
              <h2 class="ot-card-title" style="margin-bottom:0">Tracking Progress</h2>
              <div class="ot-progress-tools">
                <span class="ot-live-pill" data-live-label><i class="fa-solid fa-signal"></i>{{ $trackingLabel }}</span>
                @if($order->delivery_method === 'lalamove' && $order->lalamove_order_id)
                  <button class="ot-btn secondary" type="button" data-progress-refresh><i class="fa-solid fa-rotate"></i>Refresh Live</button>
                @endif
              </div>
            </div>

            <div class="ot-progress-wrap">
              <div class="ot-progress"
                   data-live-progress
                   data-current-step="{{ $trackingStep }}"
                   data-refresh-url="{{ ($order->delivery_method === 'lalamove' && $order->lalamove_order_id) ? route('orders.delivery.refresh', $order) : '' }}"
                   data-csrf="{{ csrf_token() }}"
                   style="--step:{{ $trackingStep }}">
                <span class="ot-progress-fill"></span>
                @foreach([['Order Confirmed','fa-check'],['Preparing','fa-box'],['Shipped','fa-truck'],['In Transit','fa-route'],['Out for Delivery','fa-person-biking'],['Delivered','fa-house-circle-check']] as $index => $progress)
                  <div class="ot-step {{ $index + 1 < $trackingStep ? 'done' : ($index + 1 === $trackingStep ? 'current' : '') }}" data-step="{{ $index + 1 }}">
                    <span class="ot-dot"><i class="fa-solid {{ $progress[1] }}"></i></span>
                    <strong>{{ $progress[0] }}</strong>
                    <small data-step-time>{{ $progressTimes[$index] ?: '-' }}</small>
                  </div>
                @endforeach
              </div>
            </div>

            <div class="ot-prep">
              <i class="fa-solid fa-box-open"></i>
              <div>
                <strong data-progress-message>{{ $trackingLabel }}</strong>
                <p>{{ $deliveryType === 'pickup' ? 'Your print job is being prepared for store pick-up.' : 'This progress is based on the latest saved order status and courier refresh from the backend.' }}</p>
              </div>
            </div>
          </div>
        </section>

        @php
          $mapProgress = match (true) {
              $trackingStep >= 6 => 88,
              $trackingStep === 5 => 74,
              $trackingStep === 4 => 58,
              $trackingStep === 3 => 42,
              $trackingStep === 2 => 26,
              default => 14,
          };
          $originMapQuery = config('printify.origin_address')
              ?: config('services.printify.origin_address')
              ?: 'Printify and Co Production Hub Metro Manila Philippines';
          $exactDeliveryAddress = $deliveryType === 'pickup'
              ? $originMapQuery
              : trim((string) ($shippingAddress ?: ''));
          $coordinateFallback = filled($order->delivery_latitude) && filled($order->delivery_longitude)
              ? $order->delivery_latitude . ',' . $order->delivery_longitude
              : '';
          $destinationMapQuery = filled($exactDeliveryAddress)
              ? $exactDeliveryAddress
              : ($coordinateFallback ?: $originMapQuery);
          $destinationMapUrl = 'https://www.google.com/maps/dir/?api=1&origin=' . urlencode($originMapQuery) . '&destination=' . urlencode($destinationMapQuery);
          $destinationMapEmbedUrl = 'https://maps.google.com/maps?saddr=' . urlencode($originMapQuery) . '&daddr=' . urlencode($destinationMapQuery) . '&output=embed';
          $destinationLabel = $deliveryType === 'pickup'
              ? 'Printify Store'
              : (data_get($order->checkout_details, 'shippingAddress.city') ?: data_get($order->checkout_details, 'shippingAddress.province') ?: 'Destination');
        @endphp

        <section class="ot-card">
          <div class="ot-body">
            <h2 class="ot-card-title">Shipment Tracking</h2>
            <div class="ot-map">
              <div class="ot-map-info">
                <div><strong>Origin</strong>Printify &amp; Co. Production Hub<br>Metro Manila</div>
                <div><strong>Destination Address</strong>{{ $deliveryType === 'pickup' ? 'Store pick-up at Printify & Co.' : ($shippingAddress ?: 'Customer address pending') }}</div>
                <div><strong>Courier</strong>{{ $deliveryName }}</div>
                <div><strong>Tracking No.</strong>{{ $trackingNumber ?: 'Not assigned yet' }}</div>
                <div><strong>Rider Position</strong><span data-rider-position>{{ $trackingLabel }}</span></div>
                <div><strong>Last Update</strong>{{ optional($statusTimestamp)->format('M d, Y - h:i A') ?: 'Waiting for update' }}</div>
                <div class="ot-map-info-actions">
                  @if($trackingUrl)
                    <a class="ot-btn" href="{{ $trackingUrl }}" target="_blank" rel="noopener"><i class="fa-solid fa-location-crosshairs"></i>Live Track</a>
                  @endif
                  <a class="ot-btn secondary" href="{{ $destinationMapUrl }}" target="_blank" rel="noopener"><i class="fa-solid fa-route"></i>Directions</a>
                  @if($order->delivery_method === 'lalamove' && $order->lalamove_order_id)
                    <form class="ot-refresh" method="POST" action="{{ route('orders.delivery.refresh', $order) }}">
                      @csrf
                      <button class="ot-btn secondary" type="submit"><i class="fa-solid fa-rotate"></i>Refresh</button>
                    </form>
                  @endif
                </div>
              </div>

              <div class="ot-map-art" style="--track-progress:{{ $mapProgress }}%" aria-label="Order map with green route and rider position">
                <iframe class="ot-map-frame" src="{{ $destinationMapEmbedUrl }}" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
                <svg class="ot-map-route" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                  <path class="ot-route-base-svg" d="M10,72 C24,58 35,66 47,52 C59,36 69,42 88,28"></path>
                  <path class="ot-route-live-svg" d="M10,72 C24,58 35,66 47,52 C59,36 69,42 88,28"></path>
                </svg>
                <div class="ot-rider" title="Rider position updates when the order status or courier location changes">
                  <i class="fa-solid fa-motorcycle ot-motor-icon"></i>
                  <i class="fa-solid fa-user ot-person-icon"></i>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="ot-card">
          <div class="ot-body">
            <h2 class="ot-card-title">Order Timeline</h2>
            <div class="ot-timeline">
              @foreach($timeline as $event)
                <div class="ot-event">
                  <time>{{ optional($event['time'])->format('M d, Y - h:i A') ?: '-' }}</time>
                  <div>
                    <strong>{{ $event['title'] }}</strong>
                    <p>{{ $event['body'] }}</p>
                  </div>
                </div>
              @endforeach
            </div>
            <p class="ot-muted-note">All times shown are in Philippine Standard Time (PST).</p>
          </div>
        </section>
      </main>

      <aside class="ot-stack">
        <section class="ot-card">
          <div class="ot-body">
            <div class="ot-card-title-row">
              <h2 class="ot-card-title" style="margin-bottom:0">Order Summary</h2>
              @if($isAdminView && !auth()->user()?->isAdminClient())
                <a class="ot-btn secondary" href="{{ route('admin.orders.edit', $order) }}"><i class="fa-solid fa-pen"></i>Edit</a>
              @endif
            </div>

            <div class="ot-summary-group">
              @forelse($items as $line)
                @php
                  $lineVariation = $line->serviceVariation;
                  $lineName = $line->service_name ?: $line->service?->name ?: 'Print Service';
                  $lineLabel = $line->variation_label ?: $lineVariation?->variation_label;
                  $lineServiceId = $line->service_item_id ?: $lineVariation?->service_item_id;
                  $lineImage = $itemImage($line);
                @endphp
                <div class="ot-side-item">
                  @if($lineImage)
                    <img class="ot-side-thumb-img" src="{{ $lineImage }}" alt="{{ $lineName }}">
                  @else
                    <div class="ot-side-thumb" aria-hidden="true"><span></span><span></span><span style="width:65%"></span><span></span><span></span></div>
                  @endif
                  <div>
                    <strong class="ot-item-name">{{ $lineName }}</strong>
                    <div class="ot-item-meta">
                      @if($lineServiceId)<span>{{ $lineServiceId }}</span><br>@endif
                      @if($lineLabel)<span>{{ $lineLabel }}</span><br>@endif
                      <span>{{ (int) $line->quantity }} {{ (int) $line->quantity === 1 ? 'sheet' : 'sheets' }} · {{ $money($line->subtotal) }}</span>
                    </div>
                  </div>
                </div>
              @empty
                <div class="ot-side-item">
                  <div class="ot-side-thumb" aria-hidden="true"><span></span><span></span><span style="width:65%"></span><span></span><span></span></div>
                  <div>
                    <strong class="ot-item-name">No order items saved</strong>
                    <div class="ot-item-meta">This order has no item rows yet.</div>
                  </div>
                </div>
              @endforelse
            </div>

            <div class="ot-summary-group">
              <div class="ot-summary-line"><span>Order No.</span><strong>{{ $orderNo }}</strong></div>
              <div class="ot-summary-line"><span>Service ID</span><strong>{{ $serviceId }}</strong></div>
              <div class="ot-summary-line"><span>Printing Category</span><strong>{{ $primaryCategory ?: 'Not set' }}</strong></div>
              <div class="ot-summary-line"><span>Color Variation</span><strong>{{ $primaryColor ?: 'Not set' }}</strong></div>
              <div class="ot-summary-line"><span>Print Option</span><strong>{{ $primaryFinish ?: ($item?->price_type ? str($item->price_type)->title()->toString() : 'Not set') }}</strong></div>
              <div class="ot-summary-line"><span>Paper Size</span><strong>{{ $primarySize ?: $primaryVariationLabel ?: 'Not set' }}</strong></div>
              <div class="ot-summary-line"><span>Quantity</span><strong>{{ $quantity }} {{ $quantity === 1 ? 'sheet' : 'sheets' }}</strong></div>
              <div class="ot-summary-line"><span>File Type</span><strong>{{ $fileType }}</strong></div>

              @if($files->isNotEmpty())
                <div class="ot-file-list">
                  @foreach($files as $orderFile)
                    <a class="ot-file" href="{{ \Illuminate\Support\Facades\Storage::url($orderFile->path) }}" target="_blank" rel="noopener">
                      <span>{{ $orderFile->original_name }}</span>
                      <i class="fa-solid fa-download"></i>
                    </a>
                  @endforeach
                </div>
              @endif
            </div>

            <div class="ot-summary-group">
              <div class="ot-summary-line"><span>Subtotal</span><strong>{{ $money($subtotal) }}</strong></div>
              <div class="ot-summary-line"><span>Shipping Fee</span><strong>{{ $money($deliveryFee) }}</strong></div>
              <div class="ot-summary-line ot-total"><span>{{ $paymentStatus }}</span><strong>{{ $money($total) }}</strong></div>
              <div class="ot-summary-line"><span>Payment Method</span><strong>{{ $paymentName }}</strong></div>
              @if($paymentReference)
                <div class="ot-summary-line"><span>Payment Reference</span><strong>{{ $paymentReference }}</strong></div>
              @endif
            </div>

            <div class="ot-summary-group">
              <h3 class="ot-card-title" style="font-size:14px;margin-bottom:10px">Shipping Details</h3>
              <div class="ot-summary-line"><span>Shipping Method</span><strong>{{ $deliveryName }} @if($deliveryEta)<br><span style="color:#6b7280;font-weight:400">{{ $deliveryEta }}</span>@endif</strong></div>
              @if($deliveryType === 'lalamove')
                <div class="ot-summary-line"><span>Lalamove Backend</span><strong>{{ $lalamoveBackendStatus }}</strong></div>
              @endif
              <div class="ot-summary-line"><span>Shipping Address</span><strong class="ot-address">{{ $deliveryType === 'pickup' ? 'Store pick-up at Printify & Co.' : ($shippingAddress ?: 'No delivery address saved.') }}</strong></div>
              @if($order->delivery_notes)
                <div class="ot-summary-line"><span>Delivery Notes</span><strong class="ot-address">{{ $order->delivery_notes }}</strong></div>
              @endif
              @if($order->lalamove_driver_name)
                <div class="ot-summary-line"><span>Driver</span><strong>{{ $order->lalamove_driver_name }}</strong></div>
                <div class="ot-summary-line"><span>Driver Phone</span><strong>{{ $order->lalamove_driver_phone ?: '-' }}</strong></div>
                <div class="ot-summary-line"><span>Plate Number</span><strong>{{ $order->lalamove_plate_number ?: '-' }}</strong></div>
              @endif
            </div>

            <div class="ot-actions">
              <a class="ot-btn full" href="{{ route('co.place-order') }}"><i class="fa-solid fa-location-dot"></i>Back to Order Tracking</a>
              <a class="ot-btn secondary full" href="{{ route('help-center') }}"><i class="fa-solid fa-headset"></i>Contact Support</a>

              @if($order->delivery_method === 'lalamove' && !$order->lalamove_order_id)
                <form class="ot-refresh" method="POST" action="{{ route('orders.delivery.book', $order) }}">
                  @csrf
                  <button class="ot-btn secondary" type="submit"><i class="fa-solid fa-truck-fast"></i>Retry Lalamove Booking</button>
                </form>
              @endif

              @if($order->delivery_method === 'lalamove' && $order->lalamove_order_id)
                <form class="ot-refresh" method="POST" action="{{ route('orders.delivery.refresh', $order) }}">
                  @csrf
                  <button class="ot-btn secondary" type="submit"><i class="fa-solid fa-rotate"></i>Refresh Lalamove Tracking</button>
                </form>
              @endif
            </div>
          </div>
        </section>
      </aside>
    </div>
  </div>
</div>

<script>
const otToast = document.getElementById('otToast');
let otToastTimer;

function showOrderToast(message){
  if(!otToast) return;
  otToast.textContent = message;
  otToast.classList.add('show');
  clearTimeout(otToastTimer);
  otToastTimer = setTimeout(function(){
    otToast.classList.remove('show');
  }, 2300);
}

document.querySelectorAll('[data-copy-order]').forEach(function(button){
  button.addEventListener('click', async function(){
    const value = button.dataset.copyOrder || '';
    try{
      await navigator.clipboard.writeText(value);
      showOrderToast('Order number copied.');
    }catch(error){
      const temp = document.createElement('textarea');
      temp.value = value;
      temp.setAttribute('readonly', 'readonly');
      temp.style.position = 'fixed';
      temp.style.opacity = '0';
      document.body.appendChild(temp);
      temp.select();
      document.execCommand('copy');
      temp.remove();
      showOrderToast('Order number copied.');
    }
  });
});

document.querySelectorAll('[data-print-order]').forEach(function(button){
  button.addEventListener('click', function(){
    window.print();
  });
});

document.querySelectorAll('.ot-refresh').forEach(function(form){
  form.addEventListener('submit', function(){
    const button = form.querySelector('button[type="submit"]');
    if(button){
      button.disabled = true;
      button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>Processing...';
    }
  });
});

function normalizeTrackingStep(status){
  const value = String(status || '').toLowerCase().replace(/[\s-]+/g, '_');
  if(value.includes('cancel') || value.includes('fail') || value.includes('expired')) return 1;
  if(value.includes('delivered') || value.includes('completed') || value.includes('dropoff_completed')) return 6;
  if(value.includes('out_for_delivery') || value.includes('near_dropoff') || value.includes('arrived_dropoff')) return 5;
  if(value.includes('transit') || value.includes('picked') || value.includes('ongoing') || value.includes('en_route') || value.includes('picked_up')) return 4;
  if(value.includes('ship') || value.includes('assigned') || value.includes('booked') || value.includes('accepted') || value.includes('driver') || value.includes('courier')) return 3;
  if(value.includes('confirm') || value.includes('paid') || value.includes('cod') || value.includes('quote') || value.includes('processing') || value.includes('placed') || value.includes('approved') || value.includes('waiting_for_payment')) return 2;
  return 1;
}

function cleanTrackingLabel(status){
  const value = String(status || '').toLowerCase().replace(/[\s-]+/g, '_');
  if(value.includes('cancel')) return 'Cancelled';
  if(value.includes('fail') || value.includes('expired')) return 'Booking Failed';
  if(value.includes('delivered') || value.includes('completed') || value.includes('dropoff_completed')) return 'Delivered';
  if(value.includes('out_for_delivery') || value.includes('near_dropoff') || value.includes('arrived_dropoff')) return 'Out for Delivery';
  if(value.includes('transit') || value.includes('picked') || value.includes('ongoing') || value.includes('en_route') || value.includes('picked_up')) return 'In Transit';
  if(value.includes('ship') || value.includes('assigned') || value.includes('booked') || value.includes('accepted') || value.includes('driver') || value.includes('courier')) return 'Shipped';
  if(value.includes('pending_payment') || value.includes('waiting_for_payment')) return 'Waiting for Payment';
  return 'Preparing for Shipment';
}

function setTrackingProgress(step, label, updatedAt){
  const progress = document.querySelector('[data-live-progress]');
  if(!progress) return;

  let fixedStep = Number(step || progress.dataset.currentStep || 1);
  fixedStep = Math.max(1, Math.min(6, fixedStep));
  const cleanLabel = label || document.querySelector('[data-progress-message]')?.textContent || 'Preparing for Shipment';

  progress.dataset.currentStep = String(fixedStep);
  progress.style.setProperty('--step', fixedStep);

  progress.querySelectorAll('[data-step]').forEach(function(item){
    const itemStep = Number(item.dataset.step || 1);
    item.classList.toggle('done', itemStep < fixedStep);
    item.classList.toggle('current', itemStep === fixedStep);
  });

  if(updatedAt){
    const currentTime = progress.querySelector('[data-step="' + fixedStep + '"] [data-step-time]');
    if(currentTime) currentTime.textContent = updatedAt;
  }

  const liveLabel = document.querySelector('[data-live-label]');
  if(liveLabel) liveLabel.innerHTML = '<i class="fa-solid fa-signal"></i>' + cleanLabel;

  const heroStatus = document.querySelector('[data-hero-status]');
  if(heroStatus) heroStatus.innerHTML = '<i class="fa-solid fa-truck-fast"></i>' + cleanLabel;

  const progressMessage = document.querySelector('[data-progress-message]');
  if(progressMessage) progressMessage.textContent = cleanLabel;

  const riderPosition = document.querySelector('[data-rider-position]');
  if(riderPosition) riderPosition.textContent = cleanLabel;
}

async function refreshTrackingProgress(showToast){
  const progress = document.querySelector('[data-live-progress]');
  if(!progress) return;

  const url = progress.dataset.refreshUrl || '';
  if(!url){
    if(showToast) showOrderToast('Live tracking will update after the courier is booked.');
    return;
  }

  const liveLabel = document.querySelector('[data-live-label]');
  liveLabel?.classList.add('refreshing');

  try{
    const response = await fetch(url, {
      method:'POST',
      credentials:'same-origin',
      headers:{
        'X-CSRF-TOKEN': progress.dataset.csrf || document.querySelector('meta[name="csrf-token"]')?.content || '',
        'X-Requested-With':'XMLHttpRequest',
        'Accept':'application/json'
      }
    });

    const contentType = response.headers.get('content-type') || '';
    if(contentType.includes('application/json')){
      const data = await response.json();
      const payload = data.order || data.data || data;
      const rawStatus = payload.lalamove_status || payload.delivery_booking_status || payload.delivery_status || payload.tracking_status || payload.status || payload.status_label || payload.tracking_label;
      const nextStep = Number(payload.tracking_step || payload.progress_step || payload.delivery_step) || normalizeTrackingStep(rawStatus);
      const nextLabel = payload.tracking_label || payload.status_label || payload.delivery_label || cleanTrackingLabel(rawStatus);
      const updatedAt = payload.lalamove_last_synced_at_formatted || payload.last_synced_at_formatted || payload.updated_at_formatted || payload.lalamove_last_synced_at || payload.updated_at || '';

      setTrackingProgress(nextStep, nextLabel, updatedAt);
      if(showToast) showOrderToast('Tracking progress refreshed.');
    }else{
      if(showToast){
        showOrderToast('Tracking refreshed. Reloading latest status...');
        window.setTimeout(function(){ window.location.reload(); }, 650);
      }
    }
  }catch(error){
    if(showToast) showOrderToast('Live tracking is not available yet.');
  }finally{
    liveLabel?.classList.remove('refreshing');
  }
}

document.querySelectorAll('[data-progress-refresh]').forEach(function(button){
  button.addEventListener('click', function(){
    refreshTrackingProgress(true);
  });
});

window.setInterval(function(){
  refreshTrackingProgress(false);
}, 30000);

</script>
</body>
</html>

<style id="order-details-real-directions-fix">
/* Use Google Maps directions as the real route. Hide fake overlay line so it will not look pasted on top. */
.ot-map-route,
.ot-route-base-svg,
.ot-route-live-svg,
.ot-road,
.ot-route-done{
  display:none!important;
}
.ot-rider{
  width:36px!important;
  height:36px!important;
  border:2px solid #10b981!important;
  background:#ffffff!important;
  color:#111827!important;
  box-shadow:0 8px 18px rgba(15,23,42,.18)!important;
}
.ot-rider .ot-motor-icon,
.ot-rider .fa-motorcycle{
  font-size:16px!important;
  color:#111827!important;
}
.ot-rider .ot-person-icon{
  right:3px!important;
  top:2px!important;
  width:13px!important;
  height:13px!important;
  background:#10b981!important;
  color:#fff!important;
  font-size:7px!important;
}
.ot-rider:before{
  border-top-color:#10b981!important;
}
</style>
