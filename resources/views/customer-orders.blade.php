<x-app-layout>
@once
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700&display=swap">
@endonce

@php
    $orderRows = isset($orders)
        ? (method_exists($orders, 'getCollection') ? $orders->getCollection() : collect($orders))
        : collect();

    $statusKey = fn($status) => strtolower(str_replace([' ', '_'], '-', (string) ($status ?: 'pending-payment')));
    $moneyValue = fn($order) => (float) ($order->total_price ?? $order->total_amount ?? $order->total ?? $order->amount ?? 0);
    $displayStatus = function ($status) {
        $status = trim((string) ($status ?: 'Pending Payment'));
        return $status === '' ? 'Pending Payment' : ucwords(str_replace(['_', '-'], ' ', $status));
    };
    $statusCount = fn($keys) => $orderRows->filter(fn($o) => in_array($statusKey($o->status ?? ''), $keys, true))->count();
    $fallbackProducts = ['Custom T-Shirt','Photo Mug','Canvas Tote Bag','Embroidered Cap','Wall Poster','Custom Hoodie','Phone Case'];
    $productVisual = function ($name, $status = '') {
        $text = strtolower((string) $name . ' ' . (string) $status);
        return match (true) {
            str_contains($text, 'photo'), str_contains($text, 'id') => ['icon' => 'fa-regular fa-id-card', 'tone' => 'blue'],
            str_contains($text, 'shirt'), str_contains($text, 'hoodie') => ['icon' => 'fa-solid fa-shirt', 'tone' => 'dark'],
            str_contains($text, 'mug'), str_contains($text, 'cup') => ['icon' => 'fa-solid fa-mug-hot', 'tone' => 'purple'],
            str_contains($text, 'bag'), str_contains($text, 'tote') => ['icon' => 'fa-solid fa-bag-shopping', 'tone' => 'green'],
            str_contains($text, 'cap'), str_contains($text, 'hat') => ['icon' => 'fa-solid fa-hat-cowboy', 'tone' => 'orange'],
            str_contains($text, 'poster'), str_contains($text, 'canvas') => ['icon' => 'fa-regular fa-image', 'tone' => 'yellow'],
            str_contains($text, 'case') => ['icon' => 'fa-solid fa-mobile-screen-button', 'tone' => 'red'],
            default => ['icon' => 'fa-regular fa-file-lines', 'tone' => 'orange'],
        };
    };
    $selectedOrder = $orderRows->first();
    $safeOrderItems = function ($order) {
        if (!$order) return collect();
        try { return $order->items ?? collect(); } catch (\Throwable $e) { return collect(); }
    };
    $productName = function ($order, $index = 0) use ($safeOrderItems, $fallbackProducts) {
        $item = $safeOrderItems($order)->first();
        return $item?->service?->name
            ?? $item?->service_name
            ?? $item?->product_name
            ?? $fallbackProducts[$index % count($fallbackProducts)];
    };
    $productMeta = function ($order) use ($safeOrderItems) {
        $item = $safeOrderItems($order)->first();
        return $item?->description
            ?? $item?->variation_name
            ?? $item?->paper_size
            ?? $item?->service_option
            ?? 'Custom Print Service';
    };
    $itemCount = function ($order) use ($safeOrderItems) {
        $items = $safeOrderItems($order);
        return max(1, (int) ($order->items_count ?? $items->count() ?: 1));
    };
    $statusClass = function ($status) use ($statusKey) {
        $key = $statusKey($status);
        return match (true) {
            str_contains($key, 'production'), str_contains($key, 'processing') => 'production',
            str_contains($key, 'ship'), str_contains($key, 'transit') => 'shipped',
            str_contains($key, 'deliver'), str_contains($key, 'complete') => 'delivered',
            str_contains($key, 'cancel'), str_contains($key, 'reject') => 'cancelled',
            default => 'pending',
        };
    };
    $statusStep = function ($status) use ($statusClass) {
        return match ($statusClass($status)) {
            'pending' => 1,
            'production' => 3,
            'shipped' => 4,
            'delivered' => 5,
            'cancelled' => 1,
            default => 1,
        };
    };
    $orderPayload = $orderRows->values()->map(function ($order, $index) use ($productName, $productMeta, $itemCount, $moneyValue, $displayStatus, $statusClass, $statusStep, $productVisual) {
        $name = $productName($order, $index);
        $visual = $productVisual($name, $order->status ?? '');
        return [
            'id' => $order->id,
            'ref' => '#ORD-' . str_pad((string) $order->id, 5, '0', STR_PAD_LEFT),
            'product' => $name,
            'meta' => $productMeta($order),
            'items' => $itemCount($order),
            'date' => optional($order->created_at)->format('M d, Y'),
            'time' => optional($order->created_at)->format('h:i A'),
            'amount' => $moneyValue($order),
            'amountText' => '₱' . number_format($moneyValue($order), 2),
            'status' => $displayStatus($order->status ?? 'Pending Payment'),
            'statusClass' => $statusClass($order->status ?? ''),
            'step' => $statusStep($order->status ?? ''),
            'icon' => $visual['icon'],
            'tone' => $visual['tone'],
            'url' => route('my-orders.show', $order->id),
        ];
    });
@endphp

<style>
:root{--co-orange:#FE7B09;--co-orange-2:#FFAB0A;--co-ink:#111827;--co-muted:#6b7280;--co-line:#111827;--co-soft:#f7f7f8;--co-shadow:0 12px 30px rgba(15,23,42,.07);--co-shadow2:0 18px 42px rgba(15,23,42,.11);--co-radius:14px;--co-green:#16a34a;--co-blue:#2563eb;--co-purple:#7c3aed;--co-red:#ef4444;--co-yellow:#f59e0b}
.co-page{background:#fff;color:var(--co-ink);font-family:'Inter',system-ui,sans-serif;font-weight:400;letter-spacing:0;min-height:calc(100vh - 70px)}
.co-wrap{max-width:1490px;margin:0 auto}.co-head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin:0 0 16px}.co-title-wrap{display:flex;align-items:flex-start;gap:10px}.co-title-wrap:before{content:'';width:18px;height:4px;margin-top:8px;border-radius:999px;background:var(--co-orange);flex:0 0 auto}.co-title{margin:0 0 3px;font-family:'Playfair Display',Georgia,serif;font-size:40px;font-weight:700;line-height:1.2;letter-spacing:-.02em;color:#111827}.co-sub{margin:0;color:var(--co-muted);font-size:12px;font-weight:400;line-height:1.45}.co-head-actions{display:flex;align-items:center;justify-content:flex-end;gap:10px;flex-wrap:wrap}.co-date{height:42px;min-width:178px;padding:0 15px;border:1px solid #111827;border-radius:8px;background:#fff;color:#111827;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-size:12px;font-weight:700;line-height:1;white-space:nowrap}.co-date i{font-size:15px}
.co-btn{height:40px;min-width:124px;border:1px solid var(--co-orange);border-radius:10px;background:var(--co-orange);color:#000!important;padding:0 16px;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-size:12px;font-weight:700;letter-spacing:.014em;cursor:pointer;transition:.18s;text-decoration:none;position:relative;z-index:2}.co-btn:hover,.co-btn:focus{background:#111827!important;border-color:#111827!important;color:#fff!important;box-shadow:0 12px 24px rgba(17,24,39,.20);outline:0}.co-icon-btn{width:34px;height:34px;border:1px solid #dfe3ea;border-radius:10px;background:#fff;color:#111827;display:inline-grid;place-items:center;cursor:pointer;transition:.18s}.co-icon-btn:hover,.co-icon-btn:focus{background:#111827;border-color:#111827;color:#fff}
.co-card{background:#fff;border:1px solid #111827;border-radius:var(--co-radius);box-shadow:var(--co-shadow);transition:background .18s ease,box-shadow .18s ease,border-color .18s ease;overflow:hidden}.co-card:hover{background:rgba(17,24,39,.10);box-shadow:var(--co-shadow2);border-color:#111827}.co-body{padding:15px 17px}.co-card-title{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:14.5px;font-weight:600;letter-spacing:.022em;line-height:1.35;color:#111827}.co-card-desc{margin:5px 0 0;color:var(--co-muted);font-size:11.5px;line-height:1.5}
.co-stats{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:12px;margin-bottom:16px}.co-stat{min-height:104px;padding:15px;display:grid;align-content:start;gap:8px;text-align:left;cursor:pointer}.co-stat:hover,.co-stat.active{background:#fff7ed;transform:translateY(-1px)}button.co-stat{font:inherit;color:inherit}.co-stat-top{display:flex;align-items:center;gap:10px}.co-stat i,.co-mini-icon{width:34px;height:34px;border-radius:11px;display:grid;place-items:center}.co-stat .tone-orange,.co-mini-icon{background:#fff3e6;color:var(--co-orange)}.co-stat .tone-blue,.co-mini-icon.blue{background:#eaf2ff;color:var(--co-blue)}.co-stat .tone-purple,.co-mini-icon.purple{background:#f2ebff;color:var(--co-purple)}.co-stat .tone-green,.co-mini-icon.green{background:#eaf8ef;color:var(--co-green)}.co-stat .tone-red,.co-mini-icon.red{background:#fff0f0;color:var(--co-red)}.co-stat strong{display:block;font-family:'Poppins',system-ui,sans-serif;font-size:22px;font-weight:600;line-height:1}.co-stat span{font-size:11px;color:var(--co-muted)}
.co-layout{display:grid;grid-template-columns:minmax(0,1fr) 300px;gap:22px;align-items:start}.co-left,.co-right{display:grid;gap:12px;align-content:start}
.co-section-head{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;margin:0 0 -1px;position:relative;z-index:3}.co-section-copy{min-width:0;padding-bottom:7px}.co-section-titleline{display:flex;align-items:center;gap:9px}.co-section-hint{display:block;margin-top:3px;color:var(--co-muted);font-size:11px}.co-section-tools{display:grid;grid-template-columns:112px 134px 92px;gap:7px;align-items:center;max-width:352px;flex:0 0 352px}.co-toolbar{display:grid;grid-template-columns:minmax(0,1fr);gap:10px;align-items:center;margin-bottom:9px}.co-input,.co-select{height:38px;border:1px solid #dfe3ea;border-radius:10px;background:#fff;color:#111827;padding:0 11px;font-size:11.5px;font-weight:500;outline:0}.co-input:focus,.co-select:focus{border-color:var(--co-orange);box-shadow:0 0 0 4px rgba(255,122,0,.11)}
.co-table{width:100%;border-collapse:collapse;background:#fff}.co-table th{height:44px;background:#fafafa;text-align:left;padding:0 14px;color:#64748b;font-size:10.5px;font-weight:800;letter-spacing:.04em}.co-table td{padding:12px 14px;border-top:1px solid #f1f5f9;color:#111827;font-size:12px;vertical-align:middle}.co-table tr{transition:.18s}.co-table tbody tr{cursor:pointer}.co-table tbody tr:hover,.co-table tbody tr.active{background:rgba(17,24,39,.10)}.co-check{width:15px;height:15px;accent-color:var(--co-orange)}
.co-product{display:flex;align-items:center;gap:12px;min-width:230px}.co-thumb{width:52px;height:52px;border-radius:12px;display:grid;place-items:center;color:#fff;font-size:20px;flex:0 0 auto}.co-tone-dark{background:linear-gradient(135deg,#111827,#ff7a00)}.co-tone-blue{background:linear-gradient(135deg,#2563eb,#0ea5e9)}.co-tone-purple{background:linear-gradient(135deg,#7c3aed,#a855f7)}.co-tone-green{background:linear-gradient(135deg,#16a34a,#22c55e)}.co-tone-orange{background:linear-gradient(135deg,#f97316,#f59e0b)}.co-tone-yellow{background:linear-gradient(135deg,#f59e0b,#facc15)}.co-tone-red{background:linear-gradient(135deg,#ef4444,#fb7185)}.co-ref,.co-product-name{font-family:'Poppins',system-ui,sans-serif;font-weight:600}.co-product-meta,.co-small{display:block;margin-top:4px;color:#6b7280;font-size:10.5px;line-height:1.35}.co-amount{font-weight:800}
.co-pill{display:inline-flex;align-items:center;gap:6px;border-radius:999px;padding:6px 9px;background:#fff3e6;color:var(--co-orange);font-size:10px;font-weight:800;white-space:nowrap}.co-pill.production{background:#f2ebff;color:var(--co-purple)}.co-pill.shipped{background:#eaf2ff;color:var(--co-blue)}.co-pill.delivered{background:#eaf8ef;color:var(--co-green)}.co-pill.cancelled{background:#fff0f0;color:var(--co-red)}
.co-actions-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:9px}.co-action{border:1px solid #dfe3ea;border-radius:12px;background:#fff;padding:8px;min-height:58px;display:grid;grid-template-columns:28px minmax(0,1fr) 10px;gap:7px;align-items:center;text-align:left;cursor:pointer;transition:.18s}.co-action:hover,.co-action:focus{background:rgba(17,24,39,.10);border-color:#111827;outline:0}.co-action strong{font-family:'Poppins',system-ui,sans-serif;font-size:10.5px;font-weight:600}.co-action small{display:block;margin-top:1px;color:#6b7280;font-size:9px;line-height:1.25}
.co-selected{display:grid;gap:13px}.co-selected-top{display:grid;grid-template-columns:106px minmax(0,1fr);gap:13px}.co-selected-img{width:106px;height:106px;border-radius:12px;display:grid;place-items:center;color:#fff;font-size:38px}.co-selected-title{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:15px;font-weight:600}.co-price-line{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}.co-selected-price{font-size:22px;font-weight:800}.co-progress{display:grid;grid-template-columns:repeat(5,1fr);gap:0;position:relative;margin:4px 0 2px}.co-progress:before{content:'';position:absolute;left:7%;right:7%;top:13px;height:2px;background:#e5e7eb}.co-progress-fill{position:absolute;left:7%;top:13px;height:2px;background:var(--co-orange);width:var(--progress,0);max-width:86%}.co-step{position:relative;z-index:1;text-align:center}.co-step-dot{width:26px;height:26px;border-radius:50%;border:2px solid #d1d5db;background:#fff;margin:0 auto 5px;display:grid;place-items:center;color:#9ca3af;font-size:9px;font-weight:800}.co-step.done .co-step-dot,.co-step.current .co-step-dot{border-color:var(--co-orange);background:var(--co-orange);color:#fff}.co-step-label{display:block;color:#6b7280;font-size:9px;font-weight:700}.co-filter-empty{display:none;text-align:center;padding:34px 14px;color:#6b7280}.co-filter-empty.show{display:block}.co-filter-empty i{font-size:36px;color:#cbd5e1;margin-bottom:10px}
.co-breakdown{display:grid;gap:9px}.co-break-row{display:flex;justify-content:space-between;gap:12px;color:#374151;font-size:11.5px}.co-break-row strong{color:#111827}.co-pagination{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:14px;color:#6b7280;font-size:11px}.co-toast{position:fixed;left:50%;top:110px;z-index:10000;transform:translate(-50%,-12px);opacity:0;background:#111827;color:#fff;border-radius:13px;padding:13px 16px;box-shadow:0 18px 50px rgba(17,24,39,.25);font-size:12px;font-weight:700;transition:.18s;pointer-events:none}.co-toast.show{opacity:1;transform:translate(-50%,0)}
.co-empty{text-align:center;padding:40px 18px}.co-empty i{font-size:46px;color:#cbd5e1;margin-bottom:12px}
.co-page{--co-radius:8px}.co-page .co-card{border:1px solid #111827;border-radius:8px;box-shadow:none;background:#fff}.co-page .co-card:hover{background:#fff;box-shadow:none}.co-page .co-card-title{letter-spacing:0}.co-page .co-btn{border:0!important;border-radius:8px;background:var(--co-orange);color:#111827!important;font-weight:600;letter-spacing:0;box-shadow:none!important}.co-page .co-btn:hover,.co-page .co-btn:focus{background:#111827!important;color:#fff!important}.co-page .co-icon-btn{border:0;border-radius:8px;box-shadow:none}.co-page .co-layout{align-items:stretch}.co-page .co-left,.co-page .co-right{height:100%}.co-page .co-stat{border-color:var(--stat-border,#111827);background:var(--stat-soft,#fff);box-shadow:none}.co-page .co-stat:hover,.co-page .co-stat.active{background:var(--stat-soft,#fff);transform:none}.co-page .co-stat[data-stat-card=all]{--stat-border:var(--co-orange);--stat-soft:#fff7ed}.co-page .co-stat[data-stat-card=pending],.co-page .co-stat[data-stat-card=shipped]{--stat-border:var(--co-blue);--stat-soft:#eff6ff}.co-page .co-stat[data-stat-card=production]{--stat-border:var(--co-purple);--stat-soft:#f5f0ff}.co-page .co-stat[data-stat-card=delivered]{--stat-border:var(--co-green);--stat-soft:#effaf3}.co-page .co-stat[data-stat-card=cancelled]{--stat-border:var(--co-red);--stat-soft:#fff1f1}.co-page .co-table tbody tr:hover,.co-page .co-table tbody tr.active{background:#fff3e6}.co-page .co-right .co-card:first-child{display:none!important}.co-page .co-right .co-card:last-child{height:100%;display:flex;flex-direction:column}.co-page #selectedOrderPanel{height:100%;display:flex;flex-direction:column}.co-page #selectedOrderPanel .co-breakdown{margin-top:auto}.co-page .co-action{border:0;border-radius:8px;background:#fff}.co-page .co-action:hover,.co-page .co-action:focus{background:#fff3e6}.co-page .co-toast{border:1px solid #111827;border-radius:10px;font-family:'Poppins',system-ui,sans-serif;font-weight:600;letter-spacing:0;box-shadow:none}
@media(max-width:1320px){.co-layout{grid-template-columns:1fr}.co-stats{grid-template-columns:repeat(3,minmax(0,1fr))}.co-right{grid-template-columns:repeat(2,minmax(0,1fr))}.co-right .co-card:last-child{grid-column:1/-1}}
@media(max-width:900px){.co-head,.co-section-head{display:grid}.co-stats,.co-toolbar,.co-section-tools,.co-right,.co-actions-grid{grid-template-columns:1fr}.co-scroll{overflow:auto}.co-table{min-width:860px}.co-btn{width:100%}}
.co-page .co-action-row{display:flex;justify-content:flex-end;margin:-2px 0 16px}
@media(max-width:900px){.co-page .co-action-row{justify-content:stretch}.co-page .co-action-row .co-btn{width:100%}}


/* Final My Orders UI sync with Dashboard */
.co-page{background:#fff!important;font-family:'Poppins',system-ui,sans-serif!important}
.co-title{font-family:'Playfair Display',Georgia,serif!important}
.co-head{margin-bottom:18px!important}.co-action-row{display:flex;justify-content:flex-end;margin:0 0 14px!important}.co-action-row .co-btn{min-width:118px!important}
.co-date{width:164px!important;min-width:164px!important;height:38px!important;padding:0 12px!important;border:1px solid #111827!important;border-radius:8px!important;background:#fff!important;color:#111827!important;font-size:11.5px!important;font-weight:500!important;box-shadow:none!important;cursor:pointer;transition:background .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease!important}
.co-date:hover,.co-date:focus{background:#111827!important;color:#fff!important;border-color:#111827!important;box-shadow:none!important;outline:0!important}.co-date:hover i,.co-date:focus i{color:#fff!important}
.co-btn,.co-page .co-btn{height:34px!important;min-width:104px!important;width:auto!important;padding:8px 16px!important;border:1px solid transparent!important;border-radius:999px!important;background:linear-gradient(90deg,var(--co-orange),var(--co-orange-2))!important;color:#111827!important;font-size:11.5px!important;font-weight:500!important;line-height:1!important;letter-spacing:0!important;box-shadow:none!important;white-space:nowrap!important}.co-btn i{font-size:11px!important}.co-btn:hover,.co-btn:focus,.co-page .co-btn:hover,.co-page .co-btn:focus{background:#111827!important;border-color:#111827!important;color:#fff!important;box-shadow:none!important;outline:0!important}.co-btn:hover i,.co-btn:focus i{color:#fff!important}
.co-stats{grid-template-columns:repeat(6,minmax(0,1fr))!important;gap:14px!important;margin-bottom:20px!important}.co-stat{min-height:86px!important;padding:12px 14px!important;gap:6px!important;border-radius:8px!important}.co-stat-top{gap:9px!important}.co-stat i{width:28px!important;height:28px!important;border-radius:8px!important;font-size:13px!important}.co-stat strong{font-size:19px!important;font-weight:600!important}.co-stat span{font-size:10.5px!important}.co-page .co-stat:hover,.co-page .co-stat.active,.co-card:hover,.co-page .co-card:hover,.co-table tbody tr:hover,.co-table tbody tr.active,.co-page .co-table tbody tr:hover,.co-page .co-table tbody tr.active{background:rgba(17,24,39,.075)!important;box-shadow:0 14px 32px rgba(17,24,39,.08)!important;transform:none!important;backdrop-filter:blur(7px)!important}.co-page .co-stat.active{background:rgba(17,24,39,.085)!important}
.co-section-head{align-items:flex-end!important;gap:16px!important;margin-bottom:8px!important}.co-section-tools{display:grid!important;grid-template-columns:112px 112px 96px!important;gap:8px!important;align-items:center!important;max-width:324px!important;flex:0 0 324px!important;margin-right:20px!important}.co-select,.co-input,.co-filter-date{width:112px!important;min-width:112px!important;height:34px!important;border:1px solid #111827!important;border-radius:8px!important;background:#fff!important;color:#111827!important;padding:0 10px!important;font-size:11px!important;font-weight:500!important;box-shadow:none!important;text-align:center!important}.co-select:hover,.co-select:focus,.co-input:hover,.co-input:focus,.co-filter-date:hover,.co-filter-date:focus{border-color:#111827!important;background:#111827!important;color:#fff!important;box-shadow:none!important;outline:0!important}.co-section-tools .co-btn{width:96px!important;min-width:96px!important}.co-toolbar .co-input{width:100%!important;min-width:0!important;text-align:left!important;border-color:#dfe3ea!important}.co-toolbar .co-input:hover,.co-toolbar .co-input:focus{background:#fff!important;color:#111827!important;border-color:#111827!important}
.co-left>.co-card{min-height:300px!important}.co-empty{padding:34px 18px!important}.co-right{gap:14px!important}.co-right .co-card{border-color:#111827!important}.co-page #selectedDetailsLink{width:100%!important;min-width:0!important}.co-icon-btn:hover,.co-icon-btn:focus{background:#111827!important;color:#fff!important;border-color:#111827!important}.co-mini-icon{background:transparent!important}
.co-calendar-overlay{position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:18px;background:rgba(17,24,39,.36);backdrop-filter:blur(9px);opacity:0;visibility:hidden;pointer-events:none;transition:opacity .2s ease,visibility .2s ease}.co-calendar-overlay.is-open{opacity:1;visibility:visible;pointer-events:auto}.co-calendar-modal{width:min(920px,100%);max-height:calc(100vh - 36px);overflow:hidden;border:1px solid #111827;border-radius:18px;background:#fff;box-shadow:0 26px 80px rgba(15,23,42,.22);display:grid;grid-template-columns:minmax(0,1.1fr) 310px}.co-calendar-main{padding:18px;border-right:1px solid #eceff3;min-width:0}.co-calendar-side{padding:18px;background:#fbfbfb;min-width:0}.co-calendar-top,.co-calendar-bar{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}.co-calendar-title,.co-calendar-month,.co-calendar-selected{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:16px;font-weight:600;color:#111827}.co-calendar-subtitle{margin:4px 0 0;font-size:11px;color:#6b7280;line-height:1.45}.co-calendar-nav{display:flex;align-items:center;gap:7px}.co-calendar-plain{height:34px;min-width:74px;padding:0 12px;border:1px solid #111827;border-radius:8px;background:#fff;color:#111827;font-size:11px;font-weight:500;display:inline-flex;align-items:center;justify-content:center;gap:6px;cursor:pointer;transition:.18s}.co-calendar-plain:hover,.co-calendar-plain:focus{background:#111827;color:#fff;outline:0}.co-calendar-nav .co-calendar-plain{min-width:34px}.co-calendar-weekdays,.co-calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:7px}.co-calendar-weekdays{margin-bottom:7px}.co-calendar-weekdays span{text-align:center;font-size:9.5px;font-weight:700;color:#6b7280;text-transform:uppercase}.co-calendar-day{position:relative;min-height:72px;border:1px solid #eceff3;border-radius:12px;background:#fff;padding:8px;text-align:left;color:#111827;cursor:pointer;transition:.18s;overflow:hidden}.co-calendar-day:hover,.co-calendar-day:focus{background:rgba(17,24,39,.075);box-shadow:0 14px 32px rgba(17,24,39,.08);outline:0}.co-calendar-day.is-muted{background:#fafafa;color:#a1a1aa;cursor:default}.co-calendar-day.is-today{border-color:var(--co-orange);background:#fff7ed}.co-calendar-day.is-selected{border-color:#111827;background:rgba(17,24,39,.08);box-shadow:inset 0 0 0 1px #111827}.co-calendar-day-number{display:block;font-size:12px;font-weight:700;line-height:1}.co-calendar-events{display:grid;gap:8px;max-height:182px;overflow:auto;padding-right:2px;margin:12px 0}.co-calendar-empty{min-height:74px;border:1px dashed #e2e5ea;border-radius:12px;display:grid;place-items:center;text-align:center;color:#6b7280;font-size:11px;line-height:1.45;padding:12px;background:#fff}.co-calendar-event{border:1px solid #eceff3;border-radius:12px;background:#fff;padding:10px;display:grid;gap:5px}.co-calendar-event strong{font-size:12px}.co-calendar-event span{font-size:10.5px;color:#6b7280}.co-calendar-form{display:grid;gap:9px}.co-calendar-form label{display:grid;gap:5px;font-size:10px;font-weight:700;color:#4b5563;text-transform:uppercase}.co-calendar-form input,.co-calendar-form textarea{width:100%;border:1px solid #eceff3;border-radius:10px;background:#fff;padding:10px 11px;color:#111827;font-family:'Poppins',system-ui,sans-serif;font-size:12px;font-weight:400;outline:0}.co-calendar-form textarea{min-height:68px;resize:vertical}.co-calendar-form input:focus,.co-calendar-form textarea:focus{border-color:#111827}.co-calendar-form-actions{display:flex;align-items:center;justify-content:flex-end;gap:8px;margin-top:2px}.co-calendar-form-actions .co-calendar-plain{min-width:74px}.co-calendar-save{height:34px;min-width:104px;padding:0 14px;border:1px solid var(--co-green);border-radius:8px;background:var(--co-green);color:#fff;font-size:11px;font-weight:500;cursor:pointer;transition:.18s}.co-calendar-save:hover,.co-calendar-save:focus{background:#111827;border-color:#111827;color:#fff;outline:0}
@media(max-width:1320px){.co-stats{grid-template-columns:repeat(3,minmax(0,1fr))!important}.co-section-tools{margin-right:0!important}}
@media(max-width:900px){.co-section-tools{grid-template-columns:1fr!important;max-width:none!important;flex:1 1 auto!important}.co-select,.co-input,.co-filter-date,.co-section-tools .co-btn{width:100%!important}.co-calendar-modal{grid-template-columns:1fr;overflow:auto}.co-calendar-main{border-right:0;border-bottom:1px solid #eceff3}.co-calendar-side{background:#fff}}


/* FINAL FIX: My Orders calendar/date sizing + functional filter + cleaner UI */
.co-page{
    --co-orange:#fe7b09!important;
    --co-orange-2:#ffab0a!important;
    --co-hover:rgba(17,24,39,.105)!important;
}
.co-head-actions{align-items:center!important}
.co-date,
.co-page .co-date,
.co-select,
.co-filter-date{
    width:164px!important;
    min-width:164px!important;
    max-width:164px!important;
    height:38px!important;
    min-height:38px!important;
    padding:0 13px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:8px!important;
    font-size:11.5px!important;
    font-weight:500!important;
    line-height:1.15!important;
    white-space:nowrap!important;
    text-align:center!important;
    box-shadow:none!important;
    outline:0!important;
    cursor:pointer!important;
    transition:background .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease,filter .18s ease!important;
}
.co-filter-date span{display:block!important;max-width:100%!important;overflow:hidden!important;text-overflow:ellipsis!important;white-space:normal!important;line-height:1.15!important}
.co-date:hover,
.co-date:focus,
.co-select:hover,
.co-select:focus,
.co-filter-date:hover,
.co-filter-date:focus{
    background:#111827!important;
    color:#fff!important;
    border-color:#111827!important;
    box-shadow:none!important;
}
.co-date:hover i,
.co-date:focus i{color:#fff!important}
.co-section-head{align-items:flex-end!important;margin-bottom:12px!important;gap:18px!important}
.co-section-tools{
    display:grid!important;
    grid-template-columns:164px 164px 104px!important;
    gap:10px!important;
    align-items:center!important;
    justify-content:end!important;
    max-width:452px!important;
    flex:0 0 452px!important;
    margin-right:30px!important;
}
.co-section-tools .co-btn{
    width:104px!important;
    min-width:104px!important;
    height:38px!important;
    padding:8px 16px!important;
    border-radius:999px!important;
    font-size:11.5px!important;
    font-weight:500!important;
}
.co-btn,
.co-page .co-btn{
    background:linear-gradient(90deg,var(--co-orange),var(--co-orange-2))!important;
    border:1px solid transparent!important;
    border-radius:999px!important;
    color:#111827!important;
    font-size:11.5px!important;
    font-weight:500!important;
    line-height:1!important;
    height:38px!important;
    padding:8px 16px!important;
    box-shadow:none!important;
}
.co-btn:hover,
.co-btn:focus,
.co-page .co-btn:hover,
.co-page .co-btn:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    box-shadow:none!important;
    outline:0!important;
}
.co-action-row{margin:0 0 16px!important}.co-action-row .co-btn{min-width:118px!important}
.co-stats{
    grid-template-columns:repeat(6,minmax(0,1fr))!important;
    gap:14px!important;
    margin:10px 0 22px!important;
}
.co-stat{
    min-height:86px!important;
    padding:12px 14px!important;
    border-radius:8px!important;
    box-shadow:none!important;
}
.co-stat i{background:transparent!important;width:24px!important;height:24px!important;font-size:14px!important}
.co-stat strong{font-size:18px!important;font-weight:600!important}
.co-stat span{font-size:10.5px!important}
.co-card,
.co-page .co-card{box-shadow:none!important}
.co-card:hover,
.co-page .co-card:hover,
.co-page .co-stat:hover,
.co-page .co-stat.active,
.co-table tbody tr:hover,
.co-table tbody tr.active,
.co-page .co-table tbody tr:hover,
.co-page .co-table tbody tr.active{
    background:var(--co-hover)!important;
    box-shadow:0 14px 34px rgba(17,24,39,.09)!important;
    transform:none!important;
    backdrop-filter:blur(8px)!important;
}
.co-left>.co-card{min-height:285px!important}.co-empty{padding:30px 18px!important}
.co-calendar-overlay{z-index:99999!important}
.co-calendar-plain{
    height:34px!important;
    min-width:78px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
}
.co-calendar-plain:hover,.co-calendar-plain:focus{background:#111827!important;color:#fff!important;border-color:#111827!important}
.co-calendar-save{
    height:34px!important;
    width:104px!important;
    min-width:104px!important;
    border-radius:8px!important;
    background:var(--co-green)!important;
    border-color:var(--co-green)!important;
    color:#fff!important;
    font-size:11px!important;
    font-weight:500!important;
}
.co-calendar-save:hover,.co-calendar-save:focus{background:#111827!important;border-color:#111827!important;color:#fff!important}
.co-calendar-day:hover,.co-calendar-day:focus{background:var(--co-hover)!important;box-shadow:0 14px 34px rgba(17,24,39,.09)!important;backdrop-filter:blur(8px)!important}
@media(max-width:1320px){
    .co-section-tools{grid-template-columns:150px 150px 104px!important;max-width:424px!important;flex-basis:424px!important;margin-right:0!important}
    .co-select,.co-filter-date{width:150px!important;min-width:150px!important;max-width:150px!important}
}
@media(max-width:900px){
    .co-section-tools{grid-template-columns:1fr!important;max-width:none!important;flex:1 1 auto!important}
    .co-select,.co-filter-date,.co-section-tools .co-btn,.co-date{width:100%!important;min-width:0!important;max-width:none!important}
}



/* FINAL REQUEST FIX: selected plain text, toolbar alignment, icon color consistency */
.co-page .co-section-head{
    align-items:flex-end!important;
    gap:18px!important;
    margin-bottom:12px!important;
}
.co-page .co-section-tools{
    display:grid!important;
    grid-template-columns:96px 164px 96px!important;
    gap:10px!important;
    align-items:center!important;
    justify-content:end!important;
    width:366px!important;
    max-width:366px!important;
    flex:0 0 366px!important;
    margin-right:0!important;
}
.co-page .co-select{
    width:96px!important;
    min-width:96px!important;
    max-width:96px!important;
    height:38px!important;
    padding:0 9px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    text-align:center!important;
    text-align-last:center!important;
    box-shadow:none!important;
}
.co-page .co-filter-date{
    width:164px!important;
    min-width:164px!important;
    max-width:164px!important;
    height:38px!important;
    padding:0 12px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    box-shadow:none!important;
}
.co-page .co-section-tools .co-btn{
    width:96px!important;
    min-width:96px!important;
    max-width:96px!important;
    height:38px!important;
    padding:8px 14px!important;
    border-radius:999px!important;
    font-size:11px!important;
    font-weight:500!important;
}
.co-page .co-select:hover,
.co-page .co-select:focus,
.co-page .co-filter-date:hover,
.co-page .co-filter-date:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:0!important;
    box-shadow:none!important;
}
.co-page #selectedRef,
.co-page #selectedStatus{
    background:transparent!important;
    border:0!important;
    border-radius:0!important;
    padding:0!important;
    min-width:auto!important;
    height:auto!important;
    box-shadow:none!important;
    color:var(--co-orange)!important;
    font-size:10.5px!important;
    font-weight:600!important;
    line-height:1.2!important;
    display:inline!important;
}
.co-page #selectedStatus{color:#2563eb!important;}
.co-page .co-card-title #selectedRef,
.co-page .co-card-title #selectedStatus{background:transparent!important;}
.co-page .co-stat[data-stat-card="all"] i{color:var(--co-orange)!important;background:#fff3e6!important;}
.co-page .co-stat[data-stat-card="pending"] i{color:var(--co-blue)!important;background:#eaf2ff!important;}
.co-page .co-stat[data-stat-card="production"] i{color:var(--co-purple)!important;background:#f2ebff!important;}
.co-page .co-stat[data-stat-card="shipped"] i{color:var(--co-purple)!important;background:#f2ebff!important;}
.co-page .co-stat[data-stat-card="delivered"] i{color:var(--co-green)!important;background:#eaf8ef!important;}
.co-page .co-stat[data-stat-card="cancelled"] i{color:var(--co-red)!important;background:#fff0f0!important;}
.co-page .co-card:hover,
.co-page .co-stat:hover,
.co-page .co-stat.active,
.co-page .co-table tbody tr:hover,
.co-page .co-table tbody tr.active,
.co-page .co-action:hover,
.co-page .co-action:focus{
    background:rgba(17,24,39,.09)!important;
    box-shadow:0 14px 32px rgba(17,24,39,.08)!important;
    transform:none!important;
    backdrop-filter:blur(7px)!important;
}
@media(max-width:900px){
    .co-page .co-section-tools{grid-template-columns:1fr!important;width:100%!important;max-width:none!important;flex:1 1 auto!important;}
    .co-page .co-select,.co-page .co-filter-date,.co-page .co-section-tools .co-btn{width:100%!important;max-width:none!important;}
}


/* FINAL MATCH: My Orders calendar modal made identical to Dashboard calendar style */
.co-page .co-calendar-overlay{
    position:fixed!important;
    inset:0!important;
    z-index:99999!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    padding:18px!important;
    background:rgba(17,24,39,.36)!important;
    backdrop-filter:blur(9px)!important;
    opacity:0;
    visibility:hidden;
    pointer-events:none;
    transition:opacity .2s ease,visibility .2s ease!important;
}
.co-page .co-calendar-overlay.is-open{
    opacity:1!important;
    visibility:visible!important;
    pointer-events:auto!important;
}
.co-page .co-calendar-modal{
    width:min(920px,100%)!important;
    max-height:calc(100vh - 36px)!important;
    overflow:hidden!important;
    border:1px solid #111827!important;
    border-radius:18px!important;
    background:#fff!important;
    box-shadow:0 26px 80px rgba(15,23,42,.22)!important;
    display:grid!important;
    grid-template-columns:minmax(0,1.1fr) 310px!important;
}
.co-page .co-calendar-main{
    padding:18px!important;
    border-right:1px solid #eceff3!important;
    min-width:0!important;
    background:#fff!important;
}
.co-page .co-calendar-side{
    padding:18px!important;
    background:#fbfbfb!important;
    min-width:0!important;
}
.co-page .co-calendar-top{
    display:flex!important;
    align-items:flex-start!important;
    justify-content:space-between!important;
    gap:12px!important;
    margin-bottom:14px!important;
}
.co-page .co-calendar-title{
    margin:0!important;
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:16px!important;
    font-weight:700!important;
    line-height:1.25!important;
    letter-spacing:.01em!important;
    color:#111827!important;
}
.co-page .co-calendar-subtitle{
    margin:3px 0 0!important;
    width:126px!important;
    max-width:126px!important;
    font-size:11px!important;
    font-weight:400!important;
    line-height:1.45!important;
    color:#6b7280!important;
}
.co-page .co-calendar-nav{
    display:flex!important;
    align-items:center!important;
    justify-content:flex-end!important;
    gap:7px!important;
    flex:0 0 auto!important;
}
.co-page #ordersCalendarPrev,
.co-page #ordersCalendarNext,
.co-page #ordersCalendarClose{
    width:34px!important;
    min-width:34px!important;
    height:34px!important;
    padding:0!important;
    border:0!important;
    border-radius:9px!important;
    background:transparent!important;
    color:#111827!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    font-size:14px!important;
    font-weight:700!important;
    box-shadow:none!important;
}
.co-page #ordersCalendarToday,
.co-page #ordersCalendarUseDate,
.co-page #ordersCalendarClearForm{
    height:34px!important;
    min-width:82px!important;
    width:auto!important;
    padding:0 12px!important;
    border:1px solid #111827!important;
    border-radius:999px!important;
    background:#fff!important;
    color:#111827!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:6px!important;
    font-size:11px!important;
    font-weight:600!important;
    box-shadow:none!important;
}
.co-page #ordersCalendarPrev:hover,
.co-page #ordersCalendarNext:hover,
.co-page #ordersCalendarClose:hover,
.co-page #ordersCalendarPrev:focus,
.co-page #ordersCalendarNext:focus,
.co-page #ordersCalendarClose:focus,
.co-page #ordersCalendarToday:hover,
.co-page #ordersCalendarToday:focus,
.co-page #ordersCalendarUseDate:hover,
.co-page #ordersCalendarUseDate:focus,
.co-page #ordersCalendarClearForm:hover,
.co-page #ordersCalendarClearForm:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:0!important;
}
.co-page .co-calendar-bar{
    display:flex!important;
    align-items:center!important;
    justify-content:space-between!important;
    gap:12px!important;
    margin-bottom:12px!important;
}
.co-page .co-calendar-month{
    margin:0!important;
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:14px!important;
    font-weight:700!important;
    line-height:1.3!important;
    color:#111827!important;
}
.co-page .co-calendar-weekdays,
.co-page .co-calendar-grid{
    display:grid!important;
    grid-template-columns:repeat(7,minmax(0,1fr))!important;
    gap:7px!important;
}
.co-page .co-calendar-weekdays{margin-bottom:7px!important;}
.co-page .co-calendar-weekdays span{
    text-align:center!important;
    font-size:9.5px!important;
    font-weight:800!important;
    color:#6b7280!important;
    letter-spacing:.08em!important;
    text-transform:uppercase!important;
}
.co-page .co-calendar-day{
    position:relative!important;
    min-height:78px!important;
    border:1px solid #eceff3!important;
    border-radius:12px!important;
    background:#fff!important;
    padding:8px!important;
    text-align:left!important;
    color:#111827!important;
    cursor:pointer!important;
    transition:background .18s ease,border-color .18s ease,box-shadow .18s ease!important;
    overflow:hidden!important;
}
.co-page .co-calendar-day:hover,
.co-page .co-calendar-day:focus{
    border-color:var(--co-orange)!important;
    background:#fff!important;
    box-shadow:0 10px 24px rgba(255,122,0,.10)!important;
    backdrop-filter:none!important;
    outline:0!important;
}
.co-page .co-calendar-day.is-muted{
    background:#fafafa!important;
    color:#a1a1aa!important;
    cursor:default!important;
}
.co-page .co-calendar-day.is-today{
    border-color:var(--co-orange)!important;
    background:#fff3e6!important;
}
.co-page .co-calendar-day.is-selected{
    border-color:#111827!important;
    background:rgba(17,24,39,.08)!important;
    box-shadow:inset 0 0 0 1px #111827!important;
}
.co-page .co-calendar-day-number{
    display:block!important;
    font-size:12px!important;
    font-weight:800!important;
    line-height:1!important;
}
.co-page .co-calendar-selected{
    margin:0 0 12px!important;
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:15px!important;
    font-weight:700!important;
    color:#111827!important;
}
.co-page .co-calendar-events{
    display:grid!important;
    gap:8px!important;
    max-height:182px!important;
    overflow:auto!important;
    padding-right:2px!important;
    margin:0 0 13px!important;
}
.co-page .co-calendar-empty{
    min-height:74px!important;
    border:1px dashed #e2e5ea!important;
    border-radius:12px!important;
    display:grid!important;
    place-items:center!important;
    text-align:center!important;
    color:#6b7280!important;
    font-size:11px!important;
    font-weight:500!important;
    line-height:1.45!important;
    padding:12px!important;
    background:#fff!important;
}
.co-page .co-calendar-event{
    border:1px solid #eceff3!important;
    border-radius:12px!important;
    background:#fff!important;
    padding:10px!important;
    display:grid!important;
    gap:7px!important;
}
.co-page .co-calendar-form{
    display:grid!important;
    gap:9px!important;
}
.co-page .co-calendar-form label{
    display:grid!important;
    gap:5px!important;
    font-size:10px!important;
    font-weight:800!important;
    color:#4b5563!important;
    letter-spacing:.05em!important;
    text-transform:uppercase!important;
}
.co-page .co-calendar-form input,
.co-page .co-calendar-form textarea{
    width:100%!important;
    border:1px solid #eceff3!important;
    border-radius:10px!important;
    background:#fff!important;
    padding:10px 11px!important;
    color:#111827!important;
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:12px!important;
    font-weight:500!important;
    outline:none!important;
    transition:border-color .18s ease,box-shadow .18s ease!important;
}
.co-page .co-calendar-form textarea{
    min-height:68px!important;
    resize:vertical!important;
}
.co-page .co-calendar-form input:focus,
.co-page .co-calendar-form textarea:focus{
    border-color:var(--co-orange)!important;
    box-shadow:0 0 0 3px rgba(254,123,9,.10)!important;
}
.co-page .co-calendar-form-actions{
    display:flex!important;
    align-items:center!important;
    justify-content:flex-end!important;
    gap:8px!important;
    margin-top:2px!important;
}
.co-page .co-calendar-save{
    height:34px!important;
    width:104px!important;
    min-width:104px!important;
    padding:0 14px!important;
    border:1px solid var(--co-green)!important;
    border-radius:999px!important;
    background:var(--co-green)!important;
    color:#fff!important;
    font-size:11px!important;
    font-weight:600!important;
    cursor:pointer!important;
    transition:background .18s ease,border-color .18s ease,color .18s ease!important;
}
.co-page .co-calendar-save:hover,
.co-page .co-calendar-save:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:0!important;
}
@media(max-width:820px){
    .co-page .co-calendar-modal{grid-template-columns:1fr!important;overflow:auto!important;}
    .co-page .co-calendar-main{border-right:0!important;border-bottom:1px solid #eceff3!important;}
    .co-page .co-calendar-day{min-height:62px!important;}
    .co-page .co-calendar-side{background:#fff!important;}
}


/* FINAL REQUEST FIX: My Orders search field uses subtle Help Center pill shape while keeping original size */
.co-page .co-toolbar{
    grid-template-columns:minmax(0,1fr)!important;
}
.co-page .co-order-search-wrap{
    position:relative!important;
    width:100%!important;
}
.co-page .co-order-search-icon{
    position:absolute!important;
    left:16px!important;
    top:50%!important;
    transform:translateY(-50%)!important;
    width:16px!important;
    height:16px!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    pointer-events:none!important;
    z-index:2!important;
}
.co-page .co-toolbar .co-order-search-input{
    width:100%!important;
    min-width:0!important;
    height:34px!important;
    border:1px solid #e5e7eb!important;
    border-radius:999px!important;
    background:#fff!important;
    color:#000!important;
    padding:0 16px 0 46px!important;
    font-size:11.5px!important;
    font-weight:500!important;
    text-align:left!important;
    box-shadow:none!important;
    outline:0!important;
}
.co-page .co-toolbar .co-order-search-input::placeholder{
    color:#6b7280!important;
}
.co-page .co-toolbar .co-order-search-input:hover,
.co-page .co-toolbar .co-order-search-input:focus{
    border-color:#d1d5db!important;
    background:#fff!important;
    color:#000!important;
    box-shadow:none!important;
    outline:0!important;
}

</style>

<div class="co-page">
<div class="co-wrap">
    <div class="co-head">
        <div class="co-title-wrap"><div><h1 class="co-title">My Orders</h1><p class="co-sub">Track and manage all your custom print orders.</p></div></div>
        <div class="co-head-actions">
            <button type="button" class="co-date co-calendar-toggle" id="ordersCalendarToggle" data-calendar-target="main"><i class="fa-regular fa-calendar-days"></i><span id="ordersCalendarToggleText">Today is {{ now()->format('M d, Y') }}</span></button>
        </div>
    </div>

    <div class="co-calendar-overlay" id="ordersCalendarOverlay" aria-hidden="true">
        <section class="co-calendar-modal" role="dialog" aria-modal="true" aria-labelledby="ordersCalendarTitle">
            <div class="co-calendar-main">
                <div class="co-calendar-top">
                    <div>
                        <h3 class="co-calendar-title" id="ordersCalendarTitle">Customer Calendar</h3>
                        <p class="co-calendar-subtitle">Select dates and manage your personal order reminders.</p>
                    </div>
                    <div class="co-calendar-nav">
                        <button type="button" class="co-calendar-plain" id="ordersCalendarPrev" aria-label="Previous month"><i class="fa-solid fa-chevron-left"></i></button>
                        <button type="button" class="co-calendar-plain" id="ordersCalendarToday">Today</button>
                        <button type="button" class="co-calendar-plain" id="ordersCalendarNext" aria-label="Next month"><i class="fa-solid fa-chevron-right"></i></button>
                        <button type="button" class="co-calendar-plain" id="ordersCalendarClose" aria-label="Close calendar"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
                <div class="co-calendar-bar">
                    <h4 class="co-calendar-month" id="ordersCalendarMonthLabel"></h4>
                    <button type="button" class="co-calendar-plain" id="ordersCalendarUseDate"><i class="fa-solid fa-check"></i>Use Date</button>
                </div>
                <div class="co-calendar-weekdays" aria-hidden="true"><span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span></div>
                <div class="co-calendar-grid" id="ordersCalendarGrid"></div>
            </div>
            <aside class="co-calendar-side">
                <h4 class="co-calendar-selected" id="ordersCalendarSelectedLabel"></h4>
                <div class="co-calendar-events" id="ordersCalendarEventList"></div>
                <form class="co-calendar-form" id="ordersCalendarForm">
                    <input type="hidden" id="ordersCalendarEventId">
                    <label>Event / Reminder<input type="text" id="ordersCalendarEventTitle" maxlength="80" placeholder="Example: Pickup order" required></label>
                    <label>Time<input type="time" id="ordersCalendarEventTime"></label>
                    <label>Note<textarea id="ordersCalendarEventNote" maxlength="180" placeholder="Optional note"></textarea></label>
                    <div class="co-calendar-form-actions">
                        <button type="button" class="co-calendar-plain" id="ordersCalendarClearForm">Clear</button>
                        <button type="submit" class="co-calendar-save" id="ordersCalendarSave">Save Event</button>
                    </div>
                </form>
            </aside>
        </section>
    </div>

    <div class="co-action-row">
        <a href="{{ route('services.index') }}" class="co-btn" onclick="window.location.href=this.href;return false;"><i class="fa-solid fa-plus"></i>New Order</a>
    </div>

    <div class="co-stats">
        <button type="button" class="co-card co-stat active" data-stat-card="all" onclick="applyStatFilter('all')"><div class="co-stat-top"><i class="fa-solid fa-layer-group tone-orange"></i><span>Total Orders</span></div><strong>{{ $orders?->total() ?? $orderRows->count() }}</strong><span>All time orders</span></button>
        <button type="button" class="co-card co-stat" data-stat-card="pending" onclick="applyStatFilter('pending')"><div class="co-stat-top"><i class="fa-regular fa-credit-card tone-blue"></i><span>Pending Payment</span></div><strong>{{ $statusCount(['pending','pending-payment','unpaid']) }}</strong><span>Awaiting payment</span></button>
        <button type="button" class="co-card co-stat" data-stat-card="production" onclick="applyStatFilter('production')"><div class="co-stat-top"><i class="fa-solid fa-gears tone-purple"></i><span>In Production</span></div><strong>{{ $statusCount(['processing','in-production','production','approved']) }}</strong><span>Being printed</span></button>
        <button type="button" class="co-card co-stat" data-stat-card="shipped" onclick="applyStatFilter('shipped')"><div class="co-stat-top"><i class="fa-solid fa-truck-fast tone-purple"></i><span>Shipped</span></div><strong>{{ $statusCount(['shipped','out-for-delivery','in-transit','ready']) }}</strong><span>On the way</span></button>
        <button type="button" class="co-card co-stat" data-stat-card="delivered" onclick="applyStatFilter('delivered')"><div class="co-stat-top"><i class="fa-regular fa-circle-check tone-green"></i><span>Delivered</span></div><strong>{{ $statusCount(['delivered','completed']) }}</strong><span>Completed</span></button>
        <button type="button" class="co-card co-stat" data-stat-card="cancelled" onclick="applyStatFilter('cancelled')"><div class="co-stat-top"><i class="fa-regular fa-circle-xmark tone-red"></i><span>Cancelled</span></div><strong>{{ $statusCount(['cancelled','canceled','rejected']) }}</strong><span>Cancelled orders</span></button>
    </div>

    <div class="co-layout">
        <main class="co-left">
            <div class="co-section-head">
                <div class="co-section-copy">
                    <div class="co-section-titleline"><h2 class="co-card-title" id="ordersSectionTitle">Orders</h2><span class="co-pill" id="ordersSectionCount">{{ $orders?->total() ?? $orderRows->count() }} visible</span></div>
                    <span class="co-section-hint" id="ordersSectionHint">Showing all order tracking records for your account.</span>
                </div>
                <div class="co-section-tools">
                    <select id="statusFilter" class="co-select"><option value="all">All Status</option><option value="pending">Pending Payment</option><option value="production">In Production</option><option value="shipped">Shipped</option><option value="delivered">Delivered</option><option value="cancelled">Cancelled</option></select>
                    <button id="dateFilter" class="co-input co-filter-date co-calendar-toggle" type="button" data-calendar-target="filter" aria-label="Date range"><span id="ordersDateFilterText">{{ now()->startOfMonth()->format('M j') }} - {{ now()->format('M j, Y') }}</span></button>
                    <button class="co-btn" type="button" onclick="exportOrderSummary()"><i class="fa-solid fa-download"></i>Export</button>
                </div>
            </div>
            <section class="co-card">
                <div class="co-body">
                    <div class="co-toolbar">
                        <div class="co-order-search-wrap">
                            <span class="co-order-search-icon" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4601 10.3188L15.7639 14.6226C15.9151 14.7739 16.0001 14.9792 16 15.1932C15.9999 15.4072 15.9148 15.6124 15.7635 15.7637C15.6121 15.915 15.4068 15.9999 15.1928 15.9998C14.9788 15.9998 14.7736 15.9147 14.6223 15.7633L10.3185 11.4595C9.03194 12.456 7.41407 12.9249 5.79403 12.7709C4.17398 12.6169 2.67346 11.8515 1.59771 10.6304C0.521957 9.40936 -0.0482098 7.82433 0.00319691 6.19779C0.0546036 4.57125 0.723722 3.02539 1.87443 1.87468C3.02514 0.723966 4.57101 0.0548478 6.19754 0.00344105C7.82408 -0.0479657 9.40911 0.522201 10.6302 1.59795C11.8513 2.6737 12.6167 4.17423 12.7707 5.79427C12.9247 7.41432 12.4558 9.03219 11.4593 10.3188H11.4601ZM6.4003 11.1995C7.67328 11.1995 8.89412 10.6938 9.79425 9.7937C10.6944 8.89356 11.2001 7.67272 11.2001 6.39974C11.2001 5.12676 10.6944 3.90592 9.79425 3.00579C8.89412 2.10565 7.67328 1.59997 6.4003 1.59997C5.12732 1.59997 3.90648 2.10565 3.00634 3.00579C2.10621 3.90592 1.60052 5.12676 1.60052 6.39974C1.60052 7.67272 2.10621 8.89356 3.00634 9.7937C3.90648 10.6938 5.12732 11.1995 6.4003 11.1995Z" fill="#9ca3af"/>
                                </svg>
                            </span>
                            <input id="orderSearch" class="co-input co-order-search-input" type="search" placeholder="Search orders, products, or order IDs...">
                        </div>
                    </div>
                    @if($orderRows->count() > 0)
                    <div class="co-scroll">
                        <table class="co-table" id="ordersTable">
                            <thead><tr><th><input class="co-check" type="checkbox" onclick="toggleAllOrders(this)"></th><th>Order ID</th><th>Product</th><th>Date</th><th>Amount</th><th>Status</th><th>Action</th></tr></thead>
                            <tbody>
                            @foreach($orderPayload as $row)
                                <tr data-order-row data-index="{{ $loop->index }}" data-status="{{ $row['statusClass'] }}" data-search="{{ strtolower($row['ref'].' '.$row['product'].' '.$row['meta'].' '.$row['status']) }}">
                                    <td><input class="co-check" type="checkbox" onclick="event.stopPropagation()"></td>
                                    <td><span class="co-ref">{{ $row['ref'] }}</span><span class="co-small">{{ $row['items'] }} {{ \Illuminate\Support\Str::plural('item', $row['items']) }}</span></td>
                                    <td><div class="co-product"><span class="co-thumb co-tone-{{ $row['tone'] }}"><i class="{{ $row['icon'] }}"></i></span><div><span class="co-product-name">{{ $row['product'] }}</span><span class="co-product-meta">{{ $row['meta'] }}</span></div></div></td>
                                    <td>{{ $row['date'] }}<span class="co-small">{{ $row['time'] }}</span></td>
                                    <td><span class="co-amount">{{ $row['amountText'] }}</span></td>
                                    <td><span class="co-pill {{ $row['statusClass'] }}">{{ $row['status'] }}</span></td>
                                    <td><button class="co-icon-btn" type="button" onclick="event.stopPropagation();selectOrder({{ $loop->index }})"><i class="fa-regular fa-eye"></i></button> <a class="co-icon-btn" href="{{ $row['url'] }}" onclick="event.stopPropagation()"><i class="fa-solid fa-ellipsis-vertical"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="co-filter-empty" id="filterEmptyState"><i class="fa-solid fa-route"></i><h2 class="co-card-title">No matching order tracking yet.</h2><p class="co-card-desc">This status has no visible order record for your account right now.</p></div>
                    <div class="co-pagination">
                        <span>Showing {{ $orders->firstItem() ?? 1 }} to {{ $orders->lastItem() ?? $orderRows->count() }} of {{ $orders->total() ?? $orderRows->count() }} orders</span>
                        @if(method_exists($orders, 'hasPages') && $orders->hasPages())<span>{{ $orders->links() }}</span>@endif
                    </div>
                    @else
                    <div class="co-empty"><i class="fa-solid fa-box-open"></i><h2 class="co-card-title">No orders yet.</h2><p class="co-card-desc">Start a print job to see your orders, status, payment, and progress here.</p><div style="margin-top:16px"><a href="{{ route('services.index') }}" class="co-btn">Create Order</a></div></div>
                    @endif
                </div>
            </section>
        </main>

        <aside class="co-right">
            <section class="co-card">
                <div class="co-body">
                    <h2 class="co-card-title"><i class="fa-solid fa-bolt" style="color:var(--co-orange);margin-right:8px"></i>Quick Actions</h2>
                    <div class="co-actions-grid">
                        <button class="co-action" type="button" onclick="focusOrderSearch()"><span class="co-mini-icon blue"><i class="fa-solid fa-magnifying-glass"></i></span><span><strong>Track Order</strong><small>Check delivery status</small></span><i class="fa-solid fa-chevron-right"></i></button>
                        <button class="co-action" type="button" onclick="exportOrderSummary()"><span class="co-mini-icon green"><i class="fa-solid fa-download"></i></span><span><strong>Download Invoice</strong><small>Get order invoice</small></span><i class="fa-solid fa-chevron-right"></i></button>
                        <button class="co-action" type="button" onclick="location.href='{{ route('services.index') }}'"><span class="co-mini-icon purple"><i class="fa-solid fa-rotate-right"></i></span><span><strong>Reorder</strong><small>Order again quickly</small></span><i class="fa-solid fa-chevron-right"></i></button>
                        <button class="co-action" type="button" onclick="location.href='{{ route('help-center') }}#support-ticket'"><span class="co-mini-icon red"><i class="fa-solid fa-headset"></i></span><span><strong>Contact Support</strong><small>Get help from team</small></span><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </section>

            <section class="co-card">
                <div class="co-body co-selected" id="selectedOrderPanel">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px"><h2 class="co-card-title">Selected Order</h2><span class="co-pill" id="selectedRef">{{ $selectedOrder ? '#ORD-' . str_pad((string) $selectedOrder->id, 5, '0', STR_PAD_LEFT) : '#ORD-00000' }}</span></div>
                    <div class="co-selected-top">
                        <div class="co-selected-img co-tone-{{ $selectedOrder ? $productVisual($productName($selectedOrder, 0), $selectedOrder->status ?? '')['tone'] : 'orange' }}" id="selectedIconBox"><i id="selectedIcon" class="{{ $selectedOrder ? $productVisual($productName($selectedOrder, 0), $selectedOrder->status ?? '')['icon'] : 'fa-regular fa-file-lines' }}"></i></div>
                        <div><h3 class="co-selected-title" id="selectedProduct">{{ $selectedOrder ? $productName($selectedOrder, 0) : 'No selected order' }}</h3><p class="co-card-desc" id="selectedMeta">{{ $selectedOrder ? $productMeta($selectedOrder) : 'Choose an order to preview details.' }}</p><p class="co-card-desc" id="selectedDate">{{ $selectedOrder ? optional($selectedOrder->created_at)->format('M d, Y, h:i A') : '' }}</p></div>
                    </div>
                    <div class="co-price-line"><span class="co-selected-price" id="selectedAmount">{{ $selectedOrder ? '₱' . number_format($moneyValue($selectedOrder), 2) : '₱0.00' }}</span><span class="co-pill {{ $selectedOrder ? $statusClass($selectedOrder->status ?? '') : '' }}" id="selectedStatus">{{ $selectedOrder ? $displayStatus($selectedOrder->status ?? '') : 'No Order' }}</span></div>
                    <div class="co-progress" id="selectedProgress" style="--progress:{{ $selectedOrder ? (($statusStep($selectedOrder->status ?? '') - 1) * 21.5) : 0 }}%">
                        <span class="co-progress-fill"></span>
                        @foreach(['Placed','Confirmed','In Production','Shipped','Delivered'] as $step)
                        <span class="co-step {{ $selectedOrder && $loop->iteration < $statusStep($selectedOrder->status ?? '') ? 'done' : ($selectedOrder && $loop->iteration === $statusStep($selectedOrder->status ?? '') ? 'current' : '') }}"><span class="co-step-dot">{{ $loop->iteration }}</span><span class="co-step-label">{{ $step }}</span></span>
                        @endforeach
                    </div>
                    <div class="co-breakdown">
                        <h3 class="co-card-title" style="font-size:13px">Price Breakdown</h3>
                        <div class="co-break-row"><span>Subtotal</span><strong id="selectedSubtotal">{{ $selectedOrder ? '₱' . number_format(max(0, $moneyValue($selectedOrder) - 250 - ($moneyValue($selectedOrder) * .12)), 2) : '₱0.00' }}</strong></div>
                        <div class="co-break-row"><span>Shipping Fee</span><strong>₱250.00</strong></div>
                        <div class="co-break-row"><span>Tax (12%)</span><strong id="selectedTax">{{ $selectedOrder ? '₱' . number_format($moneyValue($selectedOrder) * .12, 2) : '₱0.00' }}</strong></div>
                        <div class="co-break-row"><span>Total Amount</span><strong id="selectedTotal" style="color:var(--co-orange)">{{ $selectedOrder ? '₱' . number_format($moneyValue($selectedOrder), 2) : '₱0.00' }}</strong></div>
                    </div>
                    <button id="selectedDetailsLink" type="button" data-href="{{ $selectedOrder ? route('my-orders.show', $selectedOrder->id) : '' }}" class="co-btn" style="width:100%" onclick="openSelectedDetails()"><i class="fa-regular fa-eye"></i>View Order Details</button>
                </div>
            </section>
        </aside>
    </div>
</div>
<div id="orderToast" class="co-toast">Ready.</div>
</div>

<script>
const orderData=@json($orderPayload);
function orderToast(msg){const t=document.getElementById('orderToast');if(!t)return;t.textContent=msg;t.classList.add('show');clearTimeout(window.orderToastTimer);window.orderToastTimer=setTimeout(()=>t.classList.remove('show'),2200)}
function peso(value){return '₱'+Number(value||0).toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2})}
const statusMeta={all:{title:'Orders',hint:'Showing all order tracking records for your account.'},pending:{title:'Pending Payment Orders',hint:'Orders waiting for payment confirmation and next processing step.'},production:{title:'In Production Orders',hint:'Orders currently approved, queued, or being printed.'},shipped:{title:'Shipped Orders',hint:'Orders already dispatched or moving through delivery.'},delivered:{title:'Delivered Orders',hint:'Completed orders with finished delivery tracking.'},cancelled:{title:'Cancelled Orders',hint:'Cancelled or rejected order records for review.'}};
function updateSectionHeader(status,count){const meta=statusMeta[status]||statusMeta.all;setText('ordersSectionTitle',meta.title);setText('ordersSectionHint',meta.hint);setText('ordersSectionCount',count+' visible');document.querySelectorAll('[data-stat-card]').forEach(card=>card.classList.toggle('active',card.dataset.statCard===status))}
function filterOrders(selectFirst=false){const q=(document.getElementById('orderSearch')?.value||'').toLowerCase();const s=document.getElementById('statusFilter')?.value||'all';let count=0,firstVisible=null;document.querySelectorAll('[data-order-row]').forEach(row=>{const okText=row.dataset.search.includes(q);const okStatus=s==='all'||row.dataset.status===s;const show=okText&&okStatus;row.style.display=show?'':'none';if(show){count++;if(!firstVisible)firstVisible=row}});updateSectionHeader(s,count);document.getElementById('filterEmptyState')?.classList.toggle('show',count===0);if(selectFirst){firstVisible?selectOrder(Number(firstVisible.dataset.index)):clearSelectedOrder(s)}orderToast(count+' order'+(count===1?'':'s')+' visible.')}
function applyStatFilter(status){const filter=document.getElementById('statusFilter');if(filter)filter.value=status;filterOrders(true);orderToast(status==='all'?'Showing all orders.':'Showing '+(statusMeta[status]?.title||status)+' records.')}
function setText(id,value){const el=document.getElementById(id);if(el)el.textContent=value}
function selectOrder(index){const order=orderData[index];if(!order)return;document.querySelectorAll('[data-order-row]').forEach(row=>row.classList.toggle('active',Number(row.dataset.index)===Number(index)));setText('selectedRef',order.ref);setText('selectedProduct',order.product);setText('selectedMeta',order.meta+' · '+order.items+' item'+(order.items===1?'':'s'));setText('selectedDate',(order.date||'')+', '+(order.time||''));setText('selectedAmount',order.amountText);setText('selectedStatus',order.status);const status=document.getElementById('selectedStatus');if(status){status.className='co-pill '+order.statusClass}const iconBox=document.getElementById('selectedIconBox');if(iconBox){iconBox.className='co-selected-img co-tone-'+(order.tone||'orange')}const icon=document.getElementById('selectedIcon');if(icon){icon.className=order.icon||'fa-regular fa-file-lines'}const progress=document.getElementById('selectedProgress');if(progress){progress.style.setProperty('--progress',((order.step-1)*21.5)+'%');progress.querySelectorAll('.co-step').forEach((step,i)=>{step.classList.toggle('done',i+1<order.step);step.classList.toggle('current',i+1===order.step)})}setText('selectedSubtotal',peso(Math.max(0,order.amount-250-(order.amount*.12))));setText('selectedTax',peso(order.amount*.12));setText('selectedTotal',order.amountText);const link=document.getElementById('selectedDetailsLink');if(link)link.dataset.href=order.url;localStorage.setItem('printify_selected_order',JSON.stringify(order));orderToast(order.ref+' selected.')}
function clearSelectedOrder(status){const meta=statusMeta[status]||statusMeta.all;document.querySelectorAll('[data-order-row]').forEach(row=>row.classList.remove('active'));setText('selectedRef','No order');setText('selectedProduct',meta.title);setText('selectedMeta','No order tracking record is available under this status.');setText('selectedDate','');setText('selectedAmount',peso(0));setText('selectedStatus','No Match');const statusEl=document.getElementById('selectedStatus');if(statusEl)statusEl.className='co-pill';const iconBox=document.getElementById('selectedIconBox');if(iconBox)iconBox.className='co-selected-img co-tone-orange';const icon=document.getElementById('selectedIcon');if(icon)icon.className='fa-solid fa-route';const progress=document.getElementById('selectedProgress');if(progress){progress.style.setProperty('--progress','0%');progress.querySelectorAll('.co-step').forEach(step=>{step.classList.remove('done','current')})}setText('selectedSubtotal',peso(0));setText('selectedTax',peso(0));setText('selectedTotal',peso(0));const link=document.getElementById('selectedDetailsLink');if(link)link.dataset.href=''}
function openSelectedDetails(){const link=document.getElementById('selectedDetailsLink'),href=link?.dataset?.href;if(!href){orderToast('Please select an order first.');return}window.location.href=href}
function toggleAllOrders(input){document.querySelectorAll('tbody .co-check').forEach(cb=>cb.checked=input.checked);orderToast(input.checked?'Visible orders selected.':'Selection cleared.')}
function focusOrderSearch(){const el=document.getElementById('orderSearch');if(el){el.focus();el.select()}orderToast('Search an order ID or product.')}
function exportOrderSummary(){const rows=[...document.querySelectorAll('[data-order-row]')].filter(r=>r.style.display!=='none').map(r=>orderData[Number(r.dataset.index)]).filter(Boolean);localStorage.setItem('printify_last_order_export',JSON.stringify({rows,createdAt:new Date().toISOString()}));orderToast('Order summary prepared in this browser.')}

const ordersCalendarState={target:'main',events:[],today:new Date(),selected:null,view:null,storageKey:'printify_orders_calendar_events'};
ordersCalendarState.selected=new Date(ordersCalendarState.today.getFullYear(),ordersCalendarState.today.getMonth(),ordersCalendarState.today.getDate());
ordersCalendarState.view=new Date(ordersCalendarState.selected.getFullYear(),ordersCalendarState.selected.getMonth(),1);
function pad2(v){return String(v).padStart(2,'0')}
function keyDate(d){return `${d.getFullYear()}-${pad2(d.getMonth()+1)}-${pad2(d.getDate())}`}
function longDate(d){return d.toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'})}
function monthDate(d){return d.toLocaleDateString('en-US',{month:'long',year:'numeric'})}
function shortDate(d){return d.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})}
function sameDay(a,b){return keyDate(a)===keyDate(b)}
function loadOrdersCalendarEvents(){try{ordersCalendarState.events=JSON.parse(localStorage.getItem(ordersCalendarState.storageKey)||'[]')||[]}catch(e){ordersCalendarState.events=[]}}
function saveOrdersCalendarEvents(){localStorage.setItem(ordersCalendarState.storageKey,JSON.stringify(ordersCalendarState.events))}
function eventsForOrdersDate(key){return ordersCalendarState.events.filter(e=>e.date===key).sort((a,b)=>String(a.time||'').localeCompare(String(b.time||'')))}
function clearOrdersCalendarForm(){setValue('ordersCalendarEventId','');setValue('ordersCalendarEventTitle','');setValue('ordersCalendarEventTime','');setValue('ordersCalendarEventNote','');setText('ordersCalendarSave','Save Event')}
function setValue(id,value){const el=document.getElementById(id);if(el)el.value=value}
function openOrdersCalendar(target='main'){ordersCalendarState.target=target;document.getElementById('ordersCalendarOverlay')?.classList.add('is-open');document.getElementById('ordersCalendarOverlay')?.setAttribute('aria-hidden','false');renderOrdersCalendar()}
function closeOrdersCalendar(){document.getElementById('ordersCalendarOverlay')?.classList.remove('is-open');document.getElementById('ordersCalendarOverlay')?.setAttribute('aria-hidden','true')}
function renderOrdersCalendarEvents(){const list=document.getElementById('ordersCalendarEventList');const label=document.getElementById('ordersCalendarSelectedLabel');if(!list||!label)return;const k=keyDate(ordersCalendarState.selected);const events=eventsForOrdersDate(k);label.textContent=longDate(ordersCalendarState.selected);list.innerHTML='';if(!events.length){const empty=document.createElement('div');empty.className='co-calendar-empty';empty.textContent='No reminders yet for this date. Add one below.';list.appendChild(empty);return}events.forEach(ev=>{const card=document.createElement('div');card.className='co-calendar-event';card.innerHTML=`<strong>${ev.title}</strong><span>${ev.time?('Time: '+ev.time):'No time set'}</span><span>${ev.note||'No note added.'}</span>`;list.appendChild(card)})}
function renderOrdersCalendar(){const grid=document.getElementById('ordersCalendarGrid');const month=document.getElementById('ordersCalendarMonthLabel');if(!grid||!month)return;const y=ordersCalendarState.view.getFullYear();const m=ordersCalendarState.view.getMonth();const first=new Date(y,m,1);const last=new Date(y,m+1,0);const offset=first.getDay();const cells=Math.ceil((offset+last.getDate())/7)*7;month.textContent=monthDate(ordersCalendarState.view);grid.innerHTML='';for(let i=0;i<cells;i++){const n=i-offset+1;const btn=document.createElement('button');btn.type='button';btn.className='co-calendar-day';if(n<1||n>last.getDate()){btn.classList.add('is-muted');btn.disabled=true;grid.appendChild(btn);continue}const d=new Date(y,m,n);const k=keyDate(d);btn.classList.toggle('is-today',sameDay(d,ordersCalendarState.today));btn.classList.toggle('is-selected',sameDay(d,ordersCalendarState.selected));btn.innerHTML=`<span class="co-calendar-day-number">${n}</span>`;const evs=eventsForOrdersDate(k);if(evs.length){const dot=document.createElement('span');dot.style.cssText='position:absolute;left:8px;bottom:8px;width:7px;height:7px;border-radius:50%;background:var(--co-orange)';btn.appendChild(dot)}btn.addEventListener('click',()=>{ordersCalendarState.selected=d;clearOrdersCalendarForm();renderOrdersCalendar()});grid.appendChild(btn)}renderOrdersCalendarEvents()}
document.querySelectorAll('.co-calendar-toggle').forEach(btn=>btn.addEventListener('click',()=>openOrdersCalendar(btn.dataset.calendarTarget||'main')));
document.getElementById('ordersCalendarClose')?.addEventListener('click',closeOrdersCalendar);
document.getElementById('ordersCalendarOverlay')?.addEventListener('click',e=>{if(e.target.id==='ordersCalendarOverlay')closeOrdersCalendar()});
document.getElementById('ordersCalendarPrev')?.addEventListener('click',()=>{ordersCalendarState.view=new Date(ordersCalendarState.view.getFullYear(),ordersCalendarState.view.getMonth()-1,1);renderOrdersCalendar()});
document.getElementById('ordersCalendarNext')?.addEventListener('click',()=>{ordersCalendarState.view=new Date(ordersCalendarState.view.getFullYear(),ordersCalendarState.view.getMonth()+1,1);renderOrdersCalendar()});
document.getElementById('ordersCalendarToday')?.addEventListener('click',()=>{ordersCalendarState.today=new Date();ordersCalendarState.selected=new Date(ordersCalendarState.today.getFullYear(),ordersCalendarState.today.getMonth(),ordersCalendarState.today.getDate());ordersCalendarState.view=new Date(ordersCalendarState.selected.getFullYear(),ordersCalendarState.selected.getMonth(),1);clearOrdersCalendarForm();renderOrdersCalendar()});
document.getElementById('ordersCalendarUseDate')?.addEventListener('click',()=>{const chosen=shortDate(ordersCalendarState.selected);if(ordersCalendarState.target==='filter'){setText('ordersDateFilterText',chosen);orderToast('Date filter selected.')}else{setText('ordersCalendarToggleText','Today is '+chosen);orderToast('Calendar date selected.')}closeOrdersCalendar()});
document.getElementById('ordersCalendarClearForm')?.addEventListener('click',clearOrdersCalendarForm);
document.getElementById('ordersCalendarForm')?.addEventListener('submit',e=>{e.preventDefault();const title=(document.getElementById('ordersCalendarEventTitle')?.value||'').trim();if(!title){document.getElementById('ordersCalendarEventTitle')?.focus();return}const id=(document.getElementById('ordersCalendarEventId')?.value||'').trim()||`evt-${Date.now()}`;ordersCalendarState.events.push({id,date:keyDate(ordersCalendarState.selected),title,time:(document.getElementById('ordersCalendarEventTime')?.value||'').trim(),note:(document.getElementById('ordersCalendarEventNote')?.value||'').trim()});saveOrdersCalendarEvents();clearOrdersCalendarForm();renderOrdersCalendar();orderToast('Reminder saved.')});
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeOrdersCalendar()});
loadOrdersCalendarEvents();

document.getElementById('orderSearch')?.addEventListener('input',()=>filterOrders(true));document.getElementById('statusFilter')?.addEventListener('change',()=>filterOrders(true));document.getElementById('dateFilter')?.addEventListener('click',()=>openOrdersCalendar('filter')); 
document.querySelectorAll('[data-order-row]').forEach(row=>row.addEventListener('click',()=>selectOrder(Number(row.dataset.index))));
if(orderData.length){filterOrders(true)}else{updateSectionHeader('all',0);clearSelectedOrder('all')}

/* FINAL FIX: exact calendar behavior for top date and filter date */
let ordersActiveDateFilter = '';
function orderDateKeyFromText(value){
    const d = new Date(value || '');
    if (Number.isNaN(d.getTime())) return '';
    return `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
}
function orderPayloadDateKey(order){ return orderDateKeyFromText(order?.date || ''); }
function setOrdersDateButtonText(target){
    const selected = ordersCalendarState?.selected || new Date();
    if(target === 'filter'){
        ordersActiveDateFilter = keyDate(selected);
        setText('ordersDateFilterText', shortDate(selected));
        filterOrders(true);
        orderToast('Date filter selected.');
    }else{
        setText('ordersCalendarToggleText','Today is '+shortDate(selected));
        orderToast('Calendar date selected.');
    }
}
const originalFilterOrdersFinal = filterOrders;
filterOrders = function(selectFirst=false){
    const q=(document.getElementById('orderSearch')?.value||'').toLowerCase();
    const s=document.getElementById('statusFilter')?.value||'all';
    let count=0,firstVisible=null;
    document.querySelectorAll('[data-order-row]').forEach(row=>{
        const order = orderData[Number(row.dataset.index)] || null;
        const okText=row.dataset.search.includes(q);
        const okStatus=s==='all'||row.dataset.status===s;
        const okDate=!ordersActiveDateFilter || orderPayloadDateKey(order)===ordersActiveDateFilter;
        const show=okText&&okStatus&&okDate;
        row.style.display=show?'':'none';
        if(show){count++;if(!firstVisible)firstVisible=row}
    });
    updateSectionHeader(s,count);
    document.getElementById('filterEmptyState')?.classList.toggle('show',count===0);
    if(selectFirst){firstVisible?selectOrder(Number(firstVisible.dataset.index)):clearSelectedOrder(s)}
};
function bindOrdersCalendarButtonsFinal(){
    document.querySelectorAll('.co-calendar-toggle').forEach(btn=>{
        btn.onclick=function(e){
            e.preventDefault();
            e.stopPropagation();
            openOrdersCalendar(this.dataset.calendarTarget||'main');
        };
    });
    const useBtn=document.getElementById('ordersCalendarUseDate');
    if(useBtn){
        useBtn.onclick=function(e){
            e.preventDefault();
            setOrdersDateButtonText(ordersCalendarState.target || 'main');
            closeOrdersCalendar();
        };
    }
    const clearBtn=document.getElementById('ordersCalendarClearForm');
    if(clearBtn){clearBtn.onclick=function(e){e.preventDefault();clearOrdersCalendarForm();};}
}
bindOrdersCalendarButtonsFinal();

</script>
</x-app-layout>
