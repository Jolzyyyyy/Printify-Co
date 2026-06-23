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
    $rawStatus = strtolower(str_replace([' ', '-'], '_', (string) ($order->lalamove_status ?: $order->delivery_booking_status ?: $order->status ?: 'pending')));
    $trackingStep = match (true) {
        str_contains($rawStatus, 'delivered') || str_contains($rawStatus, 'completed') => 6,
        str_contains($rawStatus, 'out_for_delivery') => 5,
        str_contains($rawStatus, 'transit') || str_contains($rawStatus, 'picked') || str_contains($rawStatus, 'ongoing') => 4,
        str_contains($rawStatus, 'ship') || str_contains($rawStatus, 'assigned') || str_contains($rawStatus, 'booked') => 3,
        str_contains($rawStatus, 'confirm') || str_contains($rawStatus, 'paid') || str_contains($rawStatus, 'cod') || str_contains($rawStatus, 'quote') || str_contains($rawStatus, 'waiting_for_payment') => 2,
        default => 1,
    };
    $trackingLabel = match (true) {
        str_contains($rawStatus, 'delivered') || str_contains($rawStatus, 'completed') => 'Delivered',
        str_contains($rawStatus, 'out_for_delivery') => 'Out for Delivery',
        str_contains($rawStatus, 'transit') || str_contains($rawStatus, 'picked') || str_contains($rawStatus, 'ongoing') => 'In Transit',
        str_contains($rawStatus, 'ship') || str_contains($rawStatus, 'assigned') || str_contains($rawStatus, 'booked') => 'Shipped',
        str_contains($rawStatus, 'fail') => 'Booking Failed',
        str_contains($rawStatus, 'pending_payment') || str_contains($rawStatus, 'waiting_for_payment') => 'Waiting for Payment',
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
    $fileType = $file?->original_name ? strtoupper(pathinfo($file->original_name, PATHINFO_EXTENSION) ?: ($file->mime ?: 'File')) : 'No file attached';
    $trackingNumber = $order->delivery_tracking_number ?: $order->lalamove_order_id ?: null;
    $trackingUrl = $order->delivery_tracking_url ?: $order->lalamove_share_link;
    $lalamoveConfigured = filled(config('services.lalamove.api_key')) && filled(config('services.lalamove.api_secret'));
    $lalamoveHasCoordinates = filled($order->delivery_latitude) && filled($order->delivery_longitude);
    $lalamoveBackendStatus = match (true) {
        $deliveryType !== 'lalamove' => 'Not required for this delivery method',
        (bool) $trackingNumber => 'Live tracking connected',
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
@font-face{font-family:'Clash Display';src:url("{{ asset('Fonts/ClashDisplay-Semibold.otf') }}") format('opentype');font-weight:600;font-style:normal;font-display:swap}
@font-face{font-family:'League Spartan';src:url("{{ asset('Fonts/LeagueSpartan-SemiBold.otf') }}") format('opentype');font-weight:600;font-style:normal;font-display:swap}
*{box-sizing:border-box}body{margin:0;background:#fff;color:#111827;font-family:Inter,system-ui,sans-serif}.co-topbar{height:58px;background:#050505;color:#fff;display:flex;align-items:center;gap:24px;padding:0 34px;position:sticky;top:0;z-index:50;user-select:none}.co-brand{min-width:210px;color:#fff;text-decoration:none}.co-brand strong{display:block;font-family:Georgia,serif;font-size:17px;letter-spacing:.06em;line-height:1}.co-brand span{display:block;margin-top:3px;color:#ff4f16;font-size:7px;font-weight:900;letter-spacing:.18em}.co-nav{display:flex;align-items:center;gap:38px;flex:1;height:100%}.co-nav a{height:100%;display:inline-flex;align-items:center;color:#fff;text-decoration:none;font-family:"Clash Display",Inter,sans-serif;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.03em;position:relative;transition:color .16s}.co-nav a:hover,.co-nav a:focus-visible{color:#ff6a21;outline:0}.co-nav a:hover:after,.co-nav a:focus-visible:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#ff4f16}.co-top-actions{display:flex;align-items:center;gap:14px}.co-search{height:34px;width:220px;border:0;border-radius:999px;background:#fff;color:#111827;padding:0 15px;font-size:11px;outline:0}.co-icon{color:#fff;text-decoration:none;font-size:16px;position:relative}.co-cart-dot{position:absolute;right:-4px;top:-5px;width:8px;height:8px;border-radius:50%;background:#ff4f16}.co-avatar{width:30px;height:30px;border-radius:50%;background:#fff3ed;color:#ff4f16;display:grid;place-items:center;font-weight:900;font-size:11px}.co-user{display:flex;align-items:center;gap:8px;color:#fff;font-family:"Clash Display",Inter,sans-serif;font-size:11px;font-weight:800;text-decoration:none;white-space:nowrap}.ot-page{min-height:calc(100vh - 58px);background:#fff}.ot-wrap{max-width:none;margin:0;padding:12px 36px 24px 40px}.ot-crumb{display:flex;gap:8px;align-items:center;color:#8b95a1;font-size:11px;font-weight:800;margin-bottom:9px}.ot-crumb a,.ot-backline{border:0;background:transparent;color:#6b7280;text-decoration:none;font:inherit;font-family:"Clash Display",Inter,sans-serif;font-weight:800;cursor:pointer;padding:0;position:relative}.ot-crumb a:after,.ot-backline:after{content:"";position:absolute;left:0;right:0;bottom:-3px;height:1px;background:#ff4f16;transform:scaleX(0);transform-origin:left;transition:transform .16s}.ot-crumb a:hover,.ot-backline:hover,.ot-crumb a:focus-visible,.ot-backline:focus-visible{color:#ff4f16;outline:0}.ot-crumb a:hover:after,.ot-backline:hover:after,.ot-crumb a:focus-visible:after,.ot-backline:focus-visible:after{transform:scaleX(1)}.ot-crumb .current{color:#111827}.ot-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:14px}.ot-title{margin:0;font-family:"Clash Display",Inter,sans-serif;font-size:25px;letter-spacing:0;line-height:1.08;font-weight:800}.ot-sub{margin:5px 0 0;color:#6b7280;font-size:12px}.ot-btn{height:36px;border:1px solid #111827;border-radius:999px;background:#fff;color:#111827!important;display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:0 15px;text-decoration:none;font-family:"Clash Display",Inter,sans-serif;font-size:11px;font-weight:800;letter-spacing:.02em;cursor:pointer;transition:background .16s,color .16s,border-color .16s,transform .16s}.ot-btn:hover,.ot-btn:focus-visible{background:#111827;border-color:#111827;color:#fff!important;outline:0;transform:translateY(-1px)}.ot-btn.primary{border:0;background:linear-gradient(90deg,#FE7B09,#FFAB0A);color:#111827!important}.ot-btn.primary:hover,.ot-btn.primary:focus-visible{background:#111827;color:#fff!important}.ot-alert{margin-bottom:12px;padding:10px 12px;border-radius:8px;font-size:12px;font-weight:800}.ot-alert.success{background:#ecfdf3;color:#166534}.ot-alert.error{background:#fef2f2;color:#991b1b}
.ot-hero{display:grid;grid-template-columns:104px minmax(0,1fr) 225px;gap:18px;align-items:center;border:1px solid #edf0f4;border-radius:8px;padding:13px 16px;margin-bottom:12px}.ot-paper{width:76px;height:98px;border:1px solid #e5e7eb;border-radius:4px;background:linear-gradient(#fff,#f8fafc);padding:9px;display:grid;gap:4px}.ot-paper span{height:3px;border-radius:8px;background:#1118271f}.ot-pages{display:inline-flex;margin-top:6px;padding:5px 10px;border:1px solid #eef0f4;border-radius:7px;font-size:10px;font-weight:800}.ot-product{font-size:16px;font-weight:900;margin:0 0 8px}.ot-meta{display:flex;flex-wrap:wrap;gap:12px;color:#374151;font-size:10px;font-weight:700}.ot-meta i{color:#6b7280;margin-right:5px}.ot-hero-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-top:16px}.ot-label{display:block;color:#6b7280;font-size:9px;font-weight:900}.ot-value{display:block;margin-top:4px;color:#111827;font-size:11px;font-weight:900}.ot-status-card{align-self:stretch;display:grid;align-content:center;gap:9px}.ot-pill{display:inline-flex;align-items:center;gap:7px;width:max-content;padding:7px 10px;border-radius:8px;background:#fff3ed;color:#ff4f16;font-size:11px;font-weight:900}.ot-dispatch{padding:10px;border-radius:6px;background:#f5f9ff;color:#334155;font-size:10px;line-height:1.4}.ot-dispatch i{color:#2580d9;margin-right:6px}
.ot-grid{display:grid;grid-template-columns:minmax(0,1fr) 325px;gap:12px;align-items:start}.ot-stack{display:grid;gap:12px}.ot-card{border:1px solid #edf0f4;border-radius:8px;background:#fff;box-shadow:0 10px 26px rgba(15,23,42,.03)}.ot-body{padding:14px}.ot-card-title{margin:0 0 12px;font-size:13px;font-weight:900}.ot-progress{display:grid;grid-template-columns:repeat(6,1fr);position:relative}.ot-progress:before{content:"";position:absolute;left:8%;right:8%;top:14px;height:2px;background:#e5e7eb}.ot-progress-fill{position:absolute;left:8%;top:14px;height:2px;background:#ff4f16;width:calc((var(--step) - 1) * 16.8%)}.ot-step{position:relative;z-index:1;text-align:center}.ot-dot{width:28px;height:28px;margin:0 auto 6px;border-radius:50%;border:2px solid #e5e7eb;background:#fff;color:#9ca3af;display:grid;place-items:center;font-size:11px}.ot-step.done .ot-dot,.ot-step.current .ot-dot{background:#ff4f16;border-color:#ff4f16;color:#fff}.ot-step strong{display:block;font-size:9px}.ot-step small{display:block;margin-top:2px;color:#6b7280;font-size:8px}.ot-prep{display:grid;grid-template-columns:54px minmax(0,1fr);gap:12px;margin-top:13px;padding:12px;border-radius:8px;background:#fff8f2}.ot-prep i{font-size:36px;color:#ff4f16}.ot-prep strong{font-size:12px}.ot-prep p{margin:4px 0 0;font-size:10px;color:#4b5563;line-height:1.45}
.ot-map{min-height:205px;border:1px solid #dbeafe;border-radius:8px;overflow:hidden;display:grid;grid-template-columns:180px minmax(0,1fr);background:linear-gradient(135deg,#e8f2fc,#f8fff4)}.ot-map-info{background:#fff;padding:12px;display:grid;align-content:start;gap:10px;font-size:10px}.ot-map-info strong{display:block;font-size:10px}.ot-map-art{position:relative;overflow:hidden}.ot-road{position:absolute;left:42px;right:70px;top:80px;border-top:3px dashed #c56d2e;transform:rotate(7deg)}.ot-map-pin,.ot-map-truck{position:absolute;width:32px;height:32px;border-radius:50%;background:#fff;display:grid;place-items:center;box-shadow:0 10px 22px rgba(15,23,42,.12)}.ot-map-pin{left:48px;top:60px}.ot-map-truck{right:80px;top:98px}.ot-current{position:absolute;right:24px;top:72px;width:150px;background:#fff;border-radius:8px;padding:11px;font-size:10px;box-shadow:0 14px 30px rgba(15,23,42,.12)}
.ot-timeline{display:grid;gap:0}.ot-event{display:grid;grid-template-columns:135px minmax(0,1fr);gap:14px;padding:11px 12px;border-top:1px solid #f1f5f9;position:relative}.ot-event:first-child{border-top:0;background:#fff8f2}.ot-event:before{content:"";position:absolute;left:11px;top:16px;width:7px;height:7px;border-radius:50%;background:#ff4f16}.ot-event time{padding-left:17px;color:#6b7280;font-size:10px}.ot-event strong{font-size:11px}.ot-event p{margin:3px 0 0;color:#4b5563;font-size:10px;line-height:1.35}
.ot-side-item{display:grid;grid-template-columns:58px minmax(0,1fr);gap:12px;align-items:center}.ot-side-thumb{width:58px;height:74px;border:1px solid #e5e7eb;border-radius:5px;background:#f8fafc}.ot-side-item+.ot-side-item{margin-top:12px;padding-top:12px;border-top:1px solid #f1f5f9}.ot-item-meta{margin-top:4px;color:#6b7280;font-size:10px;line-height:1.4}.ot-summary-line{display:flex;justify-content:space-between;gap:12px;margin:10px 0;font-size:11px}.ot-summary-line strong{text-align:right}.ot-total{margin-top:14px;padding-top:14px;border-top:1px solid #edf0f4}.ot-total strong{font-size:20px;color:#ff4f16}.ot-paybrand{display:block;text-align:right;color:#16a34a;font-size:19px;font-weight:900}.ot-address{font-size:11px;line-height:1.5;color:#374151}.ot-file-list{display:grid;gap:8px;margin-top:8px}.ot-file{display:flex;justify-content:space-between;gap:10px;padding:8px 10px;border:1px solid #eef0f4;border-radius:7px;color:#111827;text-decoration:none;font-size:11px;font-weight:800}.ot-actions{display:grid;gap:10px;margin-top:16px}.ot-refresh{display:inline}.ot-refresh button{width:100%}
@media(max-width:1040px){.ot-grid,.ot-hero{grid-template-columns:1fr}.ot-hero-grid{grid-template-columns:repeat(2,1fr)}.ot-map{grid-template-columns:1fr}.ot-map-art{min-height:210px}.ot-progress{min-width:640px}.ot-progress-wrap{overflow:auto}}
@media(max-width:640px){.ot-wrap{padding:10px 14px 24px}.ot-head{display:grid}.ot-hero-grid,.ot-event{grid-template-columns:1fr}.ot-event time{padding-left:18px}}
@media(max-width:980px){.co-topbar{height:auto;min-height:58px;align-items:flex-start;flex-wrap:wrap;padding:13px 16px}.co-brand{min-width:150px}.co-nav{order:3;width:100%;overflow:auto;gap:20px}.co-nav a{height:35px}.co-search{width:150px}.co-user span{display:none}}
:root{--red:#ff2b1a;--orange:#ff8a00;--orange2:#FFAB0A}.top-nav-bar{height:70px;background:#050505;color:#fff;position:sticky;top:0;z-index:50;box-shadow:0 10px 34px rgba(0,0,0,.28)}.premium-main-navbar{position:relative;width:min(1680px,calc(100% - 110px));min-height:70px;margin:0 auto;display:flex;align-items:center;gap:34px}.brand-logo-block{flex:0 0 230px;min-width:230px;height:70px;color:#fff;text-decoration:none;line-height:1;display:flex;flex-direction:column;justify-content:center}.brand-main-text{font-family:Inter,sans-serif;font-size:24px;font-weight:900;letter-spacing:-1.2px;color:#fff}.brand-sub-text{margin-top:4px;color:var(--red);font-family:'League Spartan',sans-serif;font-size:7.8px;font-weight:800;letter-spacing:1.35px}.nav-horizontal{position:absolute;left:50%;top:0;height:70px;transform:translateX(-50%);display:flex;align-items:center;justify-content:center;gap:52px}.nav-link{position:relative;height:70px;display:inline-flex;align-items:center;color:#fff;text-decoration:none;font-family:'League Spartan',sans-serif;font-size:14px;font-weight:800;line-height:1;letter-spacing:1.55px;white-space:nowrap;transition:color .18s}.nav-link:after{content:"";position:absolute;left:6px;right:6px;top:calc(50% + 13px);height:2px;border-radius:999px;background:var(--orange);opacity:0;transform:scaleX(0);transform-origin:center;transition:opacity .18s,transform .18s}.nav-link:hover,.nav-link:focus-visible{color:var(--orange);outline:0}.nav-link:hover:after,.nav-link:focus-visible:after{opacity:1;transform:scaleX(1)}.hero-signin-container{height:70px;margin-left:auto;min-width:0;display:flex;align-items:center;justify-content:flex-end;gap:14px}.nav-search-box{width:285px;height:38px;border:1px solid #dedede;border-radius:16px;background:#fff;display:flex;align-items:center;overflow:hidden;box-shadow:0 8px 22px rgba(0,0,0,.05)}.nav-search-box input{width:100%;height:100%;border:0;outline:0;padding:0 15px;color:#333;font-size:11.5px;font-family:Inter,sans-serif;background:#fff}.nav-icon-link{position:relative;height:70px;color:#fff;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:6px;min-width:22px;font-family:'League Spartan',sans-serif;font-size:13px;font-weight:700;line-height:1;opacity:.92;transition:color .2s,opacity .2s}.nav-icon-link:hover,.nav-icon-link:focus-visible{color:var(--orange);outline:0}.nav-svg-icon{width:22px;height:22px;object-fit:contain;display:block;filter:brightness(0) saturate(100%) invert(100%);transition:filter .2s,opacity .2s;opacity:.9}.nav-icon-link:hover .nav-svg-icon,.nav-icon-link:focus-visible .nav-svg-icon{filter:brightness(0) saturate(100%) invert(48%) sepia(98%) saturate(2262%) hue-rotate(351deg) brightness(101%) contrast(101%)}.account-label{max-width:150px;color:#fff;font-family:'League Spartan',sans-serif;font-size:13.5px;font-weight:800;line-height:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.cart-badge{position:absolute;top:18px;right:-8px;min-width:15px;height:15px;border-radius:999px;background:var(--red);color:#fff;font-size:9px;font-weight:900;display:grid;place-items:center;padding:0 4px}.ot-page{min-height:calc(100vh - 70px)}.ot-wrap{padding:14px 38px 24px 40px}.ot-crumb{gap:12px;margin-bottom:14px;font-size:13px;letter-spacing:.02em}.ot-crumb a,.ot-backline{font-size:13px}.ot-hero{padding:11px 14px;gap:15px;margin-bottom:10px}.ot-grid{gap:10px}.ot-stack{gap:10px}.ot-body{padding:12px}.ot-card-title{margin-bottom:10px}.ot-map{min-height:180px}.ot-event{padding:9px 12px}.ot-prep{margin-top:11px;padding:10px}.ot-actions{gap:8px;margin-top:12px}
@media(max-width:1180px){.premium-main-navbar{width:calc(100% - 32px)}.nav-horizontal{position:static;transform:none;gap:26px}.nav-search-box{width:210px}}
@media(max-width:820px){.top-nav-bar{height:auto}.premium-main-navbar{min-height:70px;flex-wrap:wrap;padding-bottom:12px}.nav-horizontal{order:3;width:100%;justify-content:flex-start;overflow:auto}.hero-signin-container{margin-left:0}.nav-search-box{width:180px}}
</style>
</head>
<body>
<header class="top-nav-bar premium-site-header header-dark" id="customerOriginalHeader">
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

<div class="ot-page">
  <div class="ot-wrap">
    @if(session('success'))<div class="ot-alert success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="ot-alert error">{{ session('error') }}</div>@endif

    <div class="ot-crumb">
      <button class="ot-backline" type="button" onclick="if (window.history.length > 1) { window.history.back(); } else { window.location.href='{{ route('co.place-order') }}'; }"><i class="fa-solid fa-arrow-left"></i> Back</button>
      <a href="{{ route('home') }}">Back to Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('co.place-order') }}">My Orders</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span class="current">Order Tracking</span>
    </div>
    <div class="ot-head">
      <div>
        <h1 class="ot-title">{{ $isAdminView ? 'Order Details' : 'Order Tracking' }}</h1>
        <p class="ot-sub">Track your order status in real-time</p>
      </div>
    </div>

    <section class="ot-hero">
      <div style="text-align:center">
        <div class="ot-paper" aria-hidden="true"><span></span><span></span><span style="width:65%"></span><span></span><span></span><span style="width:55%"></span><span></span><span></span></div>
        <span class="ot-pages">{{ $quantity }} {{ $quantity === 1 ? 'page' : 'pages' }}</span>
      </div>
      <div>
        <h2 class="ot-product">{{ $primaryServiceName }} @if($items->count() > 1)<span style="color:#6b7280;font-size:12px;font-weight:800">+ {{ $items->count() - 1 }} more</span>@endif</h2>
        <div class="ot-meta">
          <span><i class="fa-regular fa-file-lines"></i>{{ $primarySize ?: $primaryVariationLabel ?: 'Size not set' }}</span>
          <span><i class="fa-regular fa-copy"></i>{{ $quantity }} {{ $quantity === 1 ? 'sheet' : 'sheets' }}</span>
          <span><i class="fa-solid fa-droplet"></i>{{ $primaryColor ?: 'Color not set' }}</span>
        </div>
        <div class="ot-hero-grid">
          <div><span class="ot-label">Order No.</span><span class="ot-value">{{ $orderNo }}</span></div>
          <div><span class="ot-label">Order Date</span><span class="ot-value">{{ optional($order->created_at)->format('M d, Y - h:i A') }}</span></div>
          <div><span class="ot-label">Payment Method</span><span class="ot-value">{{ $paymentName }}</span></div>
          <div><span class="ot-label">{{ $paymentStatus }}</span><span class="ot-value" style="color:#ff4f16">{{ $money($total) }}</span></div>
        </div>
      </div>
      <div class="ot-status-card">
          <span class="ot-pill"><i class="fa-solid fa-truck-fast"></i>{{ $trackingLabel }}</span>
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
            <h2 class="ot-card-title">Tracking Progress</h2>
            <div class="ot-progress-wrap">
              <div class="ot-progress" style="--step:{{ $trackingStep }}">
                <span class="ot-progress-fill"></span>
                @foreach([['Order Confirmed','fa-check'],['Preparing','fa-box'],['Shipped','fa-truck'],['In Transit','fa-route'],['Out for Delivery','fa-person-biking'],['Delivered','fa-house-circle-check']] as $index => $progress)
                  <div class="ot-step {{ $index + 1 < $trackingStep ? 'done' : ($index + 1 === $trackingStep ? 'current' : '') }}">
                    <span class="ot-dot"><i class="fa-solid {{ $progress[1] }}"></i></span>
                    <strong>{{ $progress[0] }}</strong>
                    <small>{{ $progressTimes[$index] ?: '-' }}</small>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="ot-prep">
              <i class="fa-solid fa-box-open"></i>
              <div><strong>{{ $trackingLabel }}</strong><p>{{ $deliveryType === 'pickup' ? 'Your print job is being prepared for store pick-up.' : 'Your print job follows the saved delivery method and courier details for this order.' }}</p></div>
            </div>
          </div>
        </section>

        <section class="ot-card">
          <div class="ot-body">
            <h2 class="ot-card-title">Shipment Tracking</h2>
            <div class="ot-map">
              <div class="ot-map-info">
                <div><strong>Origin</strong>Printify & Co. Production Hub<br>Metro Manila</div>
                <div><strong>Destination</strong>{{ $deliveryType === 'pickup' ? 'Store pick-up at Printify & Co.' : ($shippingAddress ?: 'Customer address pending') }}</div>
                <div><strong>Courier</strong>{{ $deliveryName }}</div>
                <div><strong>Tracking No.</strong>{{ $trackingNumber ?: 'Not assigned yet' }}</div>
                @if($trackingUrl)<a class="ot-btn" href="{{ $trackingUrl }}" target="_blank" rel="noopener">View on Courier Site <i class="fa-solid fa-up-right-from-square"></i></a>@endif
              </div>
              <div class="ot-map-art">
                <div class="ot-road"></div>
                <div class="ot-map-pin"><i class="fa-solid fa-building-columns"></i></div>
                <div class="ot-map-truck"><i class="fa-solid fa-truck"></i></div>
                <div class="ot-current"><strong>Current Status</strong><br>{{ $trackingLabel }}<br><span style="color:#6b7280">{{ optional($statusTimestamp)->format('M d, Y - h:i A') }}</span></div>
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
                  <div><strong>{{ $event['title'] }}</strong><p>{{ $event['body'] }}</p></div>
                </div>
              @endforeach
            </div>
            <p style="margin:14px 0 0;color:#6b7280;font-size:10px">All times shown are in Philippine Standard Time (PST).</p>
          </div>
        </section>
      </main>

      <aside class="ot-stack">
        <section class="ot-card">
          <div class="ot-body">
            <h2 class="ot-card-title" style="display:flex;justify-content:space-between;align-items:center">Order Summary @if($isAdminView && !auth()->user()?->isAdminClient())<a class="ot-btn" href="{{ route('admin.orders.edit', $order) }}"><i class="fa-solid fa-pen"></i>Edit</a>@endif</h2>
            @forelse($items as $line)
              @php
                $lineVariation = $line->serviceVariation;
                $lineName = $line->service_name ?: $line->service?->name ?: 'Print Service';
                $lineLabel = $line->variation_label ?: $lineVariation?->variation_label;
                $lineServiceId = $line->service_item_id ?: $lineVariation?->service_item_id;
              @endphp
              <div class="ot-side-item">
                <div class="ot-side-thumb"></div>
                <div>
                  <strong style="font-size:12px">{{ $lineName }}</strong>
                  <div class="ot-item-meta">
                    @if($lineServiceId)<span>{{ $lineServiceId }}</span><br>@endif
                    @if($lineLabel)<span>{{ $lineLabel }}</span><br>@endif
                    <span>{{ (int) $line->quantity }} {{ (int) $line->quantity === 1 ? 'sheet' : 'sheets' }} · {{ $money($line->subtotal) }}</span>
                  </div>
                </div>
              </div>
            @empty
              <div class="ot-side-item">
                <div class="ot-side-thumb"></div>
                <div><strong style="font-size:12px">No order items saved</strong><div class="ot-item-meta">This order has no item rows yet.</div></div>
              </div>
            @endforelse
            <div style="margin-top:18px">
              <div class="ot-summary-line"><span>Order No.</span><strong>{{ $orderNo }}</strong></div>
              <div class="ot-summary-line"><span>Service ID</span><strong>{{ $serviceId }}</strong></div>
              <div class="ot-summary-line"><span>Printing Category</span><strong>{{ $primaryCategory ?: 'Not set' }}</strong></div>
              <div class="ot-summary-line"><span>Color Variation</span><strong>{{ $primaryColor ?: 'Not set' }}</strong></div>
              <div class="ot-summary-line"><span>Print Option</span><strong>{{ $primaryFinish ?: ($item?->price_type ? str($item->price_type)->title()->toString() : 'Not set') }}</strong></div>
              <div class="ot-summary-line"><span>Paper Size</span><strong>{{ $primarySize ?: $primaryVariationLabel ?: 'Not set' }}</strong></div>
              <div class="ot-summary-line"><span>Quantity (Sheets)</span><strong>{{ $quantity }} {{ $quantity === 1 ? 'sheet' : 'sheets' }}</strong></div>
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
            <div style="margin-top:18px">
              <div class="ot-summary-line"><span>Subtotal</span><strong>{{ $money($subtotal) }}</strong></div>
              <div class="ot-summary-line"><span>Shipping Fee</span><strong>{{ $money($deliveryFee) }}</strong></div>
              <div class="ot-summary-line ot-total"><span>{{ $paymentStatus }}</span><strong>{{ $money($total) }}</strong></div>
              <div class="ot-summary-line"><span>Payment Method</span><strong>{{ $paymentName }}</strong></div>
              @if($paymentReference)
                <div class="ot-summary-line"><span>Payment Reference</span><strong>{{ $paymentReference }}</strong></div>
              @endif
            </div>
            <div style="margin-top:20px">
              <h3 class="ot-card-title" style="font-size:12px;margin-bottom:10px">Shipping Details</h3>
              <div class="ot-summary-line"><span>Shipping Method</span><strong>{{ $deliveryName }} @if($deliveryEta)<br><span style="color:#6b7280;font-weight:700">{{ $deliveryEta }}</span>@endif</strong></div>
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
              <a class="ot-btn primary" href="{{ route('co.place-order') }}"><i class="fa-solid fa-arrow-left"></i>Back to My Orders</a>
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
