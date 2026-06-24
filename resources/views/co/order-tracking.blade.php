<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Order Tracking | Printify & Co.</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

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
  --pf-line:#d9dee7;
  --pf-line-soft:#edf0f4;
  --pf-blue:#006eff;
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

/* Header */
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
  font-size:18px;
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

/* Order Tracking Section */
.mo-page{
  min-height:calc(100vh - 70px);
  background:#ffffff;
}
.mo-wrap{
  width:min(1270px,calc(100% - 112px));
  max-width:1270px;
  margin:0 0 0 80px;
  padding:22px 0 38px;
}
.mo-crumb{
  display:flex;
  align-items:center;
  flex-wrap:wrap;
  gap:10px;
  margin:0 0 16px;
  color:#8b95a1;
  font-size:12px;
  font-weight:700;
}
.mo-crumb a,
.mo-backline{
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
.mo-crumb a::after,
.mo-backline::after{
  content:"";
  position:absolute;
  left:0;
  right:0;
  bottom:-3px;
  height:1px;
  border-radius:999px;
  background:var(--pf-orange);
  transform:scaleX(0);
  transform-origin:left;
  transition:transform .16s ease,background .16s ease,height .16s ease,color .16s ease;
}
.mo-crumb a:hover,
.mo-backline:hover,
.mo-crumb a:focus-visible,
.mo-backline:focus-visible{
  color:var(--pf-orange);
  outline:0;
}
.mo-crumb a:hover::after,
.mo-backline:hover::after,
.mo-crumb a:focus-visible::after,
.mo-backline:focus-visible::after{
  transform:scaleX(1);
  height:1px;
  background:var(--pf-orange);
}
.mo-crumb .current{
  color:var(--pf-orange);
  font-weight:700;
  padding-bottom:3px;
}
.mo-crumb .current::after{
  transform:scaleX(1);
  height:2px;
  background:linear-gradient(90deg,var(--pf-orange-start),var(--pf-orange-end));
}
.mo-crumb a i{
  font-size:11px;
  color:inherit;
  line-height:1;
}
.mo-title{
  margin:0;
  color:#000000;
  font-family:var(--pf-heading-font);
  font-size:38px;
  line-height:1;
  font-weight:600;
  letter-spacing:0;
  text-transform:uppercase;
}
.mo-sub{
  margin:7px 0 22px;
  color:#303743;
  font-family:var(--pf-body-font);
  font-size:14px;
  font-weight:400;
  line-height:1.45;
}

/* Status tabs: same clean Contact Us font and wider spacing */
.mo-tabs{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:18px;
  margin-bottom:18px;
  max-width:100%;
}
.mo-tab-list{
  display:flex;
  align-items:center;
  flex-wrap:wrap;
  gap:30px;
  border:0;
  border-radius:0;
  background:transparent;
  overflow:visible;
}
.mo-tab{
  height:auto;
  min-width:0;
  border:0;
  background:transparent;
  color:#111827;
  padding:0 0 10px;
  font-family:var(--pf-body-font);
  font-size:14px;
  font-weight:500;
  letter-spacing:.16px;
  text-transform:uppercase;
  position:relative;
  cursor:pointer;
  transition:color .18s ease;
}
.mo-tab::after{
  content:"";
  position:absolute;
  left:0;
  right:0;
  bottom:0;
  height:2px;
  border-radius:999px;
  background:linear-gradient(90deg,var(--pf-orange-start),var(--pf-orange-end));
  opacity:0;
  transform:scaleX(0);
  transform-origin:left;
  transition:opacity .18s ease,transform .18s ease;
}
.mo-tab b{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  min-width:auto;
  height:auto;
  margin-left:6px;
  border-radius:0;
  background:transparent;
  color:inherit;
  font-family:var(--pf-body-font);
  font-size:14px;
  font-weight:500;
  line-height:1;
}
.mo-tab:hover,
.mo-tab:focus-visible,
.mo-tab.active{
  color:var(--pf-orange);
  outline:0;
}
.mo-tab:hover::after,
.mo-tab:focus-visible::after,
.mo-tab.active::after{
  opacity:1;
  transform:scaleX(1);
}

/* Boxed Sort By and Filter controls */
.mo-tools{
  display:flex;
  align-items:center;
  gap:12px;
  flex:0 0 auto;
}
.mo-control-box,
.mo-tool{
  height:32px;
  border:1px solid #cfd7e3;
  border-radius:7px;
  background:#ffffff;
  color:var(--pf-black);
  display:inline-flex;
  align-items:center;
  justify-content:center;
  box-shadow:none;
  transition:border-color .18s ease,background .18s ease,color .18s ease;
}
.mo-control-box{
  gap:7px;
  padding:0 9px;
}
.mo-control-box span,
.mo-tool span{
  color:#111827;
  font-family:var(--pf-body-font);
  font-size:12px;
  font-weight:500;
  line-height:1;
  white-space:nowrap;
}
.mo-select{
  height:26px;
  min-width:106px;
  border:0;
  border-left:1px solid #e4e9f1;
  background:transparent;
  color:#111827;
  padding:0 4px 0 10px;
  font-family:var(--pf-body-font);
  font-size:12px;
  font-weight:400;
  outline:0;
  cursor:pointer;
}
.mo-tool{
  gap:7px;
  padding:0 11px;
  font-family:var(--pf-body-font);
  font-size:13px;
  font-weight:500;
}
.mo-tool i{
  color:var(--pf-orange);
  font-size:12px;
}
.mo-control-box:hover,
.mo-control-box:focus-within{
  border-color:#cfd7e3;
  background:#ffffff;
  color:var(--pf-black);
  outline:0;
}
.mo-tool:hover,
.mo-tool:focus-visible{
  border-color:#cfd7e3;
  background:#fffaf5;
  color:var(--pf-black);
  outline:0;
}
.mo-tool:hover i,
.mo-tool:focus-visible i{
  color:var(--pf-orange);
}
.mo-filter-wrap{
  position:relative;
  display:inline-flex;
}
.mo-filter-menu{
  position:absolute;
  top:38px;
  right:0;
  z-index:20;
  width:170px;
  padding:8px;
  border:1px solid #d9dee7;
  border-radius:8px;
  background:#ffffff;
  box-shadow:0 16px 34px rgba(15,23,42,.10);
}
.mo-filter-menu[hidden]{
  display:none;
}
.mo-filter-menu button{
  width:100%;
  height:30px;
  border:0;
  border-radius:6px;
  background:#ffffff;
  color:#111827;
  display:flex;
  align-items:center;
  justify-content:flex-start;
  padding:0 10px;
  font-family:var(--pf-body-font);
  font-size:12px;
  font-weight:400;
}
.mo-filter-menu button:hover,
.mo-filter-menu button:focus-visible,
.mo-filter-menu button.active{
  background:#fff3ed;
  color:var(--pf-orange);
  outline:0;
}

/* Cards */
.mo-list{
  display:grid;
  gap:12px;
  max-width:100%;
}
.mo-card{
  display:grid;
  grid-template-columns:104px minmax(0,1fr) 166px;
  gap:14px;
  border:1px solid var(--pf-line-soft);
  border-radius:8px;
  background:#ffffff;
  padding:12px 16px;
  box-shadow:0 12px 34px rgba(15,23,42,.035);
  cursor:pointer;
  transition:border-color .18s ease,box-shadow .18s ease,transform .18s ease;
}
.mo-card:hover,
.mo-card:focus-visible{
  border-color:#ffb98f;
  box-shadow:0 14px 36px rgba(255,121,0,.08);
  transform:translateY(-1px);
  outline:0;
}
.mo-thumb{
  width:92px;
  margin:0 auto;
  text-align:center;
}
.mo-paper{
  height:92px;
  border:1px solid #e5e7eb;
  border-radius:5px;
  background:linear-gradient(#ffffff,#f8fafc);
  padding:8px;
  display:grid;
  gap:4px;
}
.mo-paper span{
  height:3px;
  border-radius:8px;
  background:rgba(17,24,39,.12);
}
.mo-paper .short{
  width:62%;
}
.mo-pages{
  display:inline-flex;
  margin-top:6px;
  padding:5px 10px;
  border:1px solid var(--pf-line-soft);
  border-radius:7px;
  background:#ffffff;
  color:#111827;
  font-size:11px;
  font-weight:500;
}
.mo-main{
  min-width:0;
}
.mo-product{
  margin:0 0 8px;
  color:#111827;
  font-family:var(--pf-heading-font);
  font-size:18px;
  line-height:1.12;
  font-weight:600;
  letter-spacing:0;
}
.mo-meta{
  display:flex;
  flex-wrap:wrap;
  gap:8px 12px;
  color:#374151;
  font-size:12px;
  font-weight:400;
  margin-bottom:10px;
}
.mo-meta span{
  display:inline-flex;
  align-items:center;
  gap:5px;
}
.mo-meta i{
  color:#6b7280;
  font-size:12px;
}
.mo-details{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:10px;
  margin-bottom:10px;
}
.mo-label{
  display:block;
  color:#6b7280;
  font-size:11px;
  font-weight:400;
  line-height:1.3;
}
.mo-value{
  display:block;
  margin-top:4px;
  color:#111827;
  font-size:12px;
  font-weight:500;
  line-height:1.35;
}
.mo-dispatch{
  display:flex;
  align-items:center;
  justify-content:flex-start;
  gap:18px;
  padding:8px 10px;
  border-radius:6px;
  background:#f5f9ff;
  color:#1f2937;
  font-size:12px;
  font-weight:400;
  line-height:1.35;
}
.mo-dispatch i{
  color:#2580d9;
  margin-right:5px;
}
.mo-dispatch strong{
  font-weight:500;
}
.mo-side{
  border-left:1px solid var(--pf-line-soft);
  padding-left:14px;
  display:grid;
  align-content:center;
  gap:10px;
}
.mo-status-pill{
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
.mo-status-pill i{
  color:var(--pf-orange);
}
.mo-side-total{
  display:grid;
  gap:4px;
}
.mo-side-total span{
  color:#6b7280;
  font-size:11px;
  font-weight:400;
}
.mo-side-total strong{
  color:var(--pf-orange);
  font-size:18px;
  font-weight:600;
  line-height:1.1;
}

/* Contact Us button theme */
.mo-btn{
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
  transition:background .18s ease,color .18s ease,border-color .18s ease;
}
.mo-btn i{
  color:#111827;
}
.mo-btn:hover,
.mo-btn:focus-visible{
  background:#111827;
  color:#ffffff!important;
  outline:0;
}
.mo-btn:hover i,
.mo-btn:focus-visible i{
  color:#ffffff;
}
.mo-empty{
  border:1px dashed #d9dee7;
  border-radius:8px;
  padding:44px 20px;
  text-align:center;
  color:#6b7280;
  font-weight:400;
}
.mo-empty p{
  margin:10px 0 0;
}
.mo-footer{
  display:flex;
  align-items:center;
  justify-content:center;
  margin-top:16px;
  color:#6b7280;
  font-size:12px;
}
.mo-page-num{
  display:inline-grid;
  place-items:center;
  width:31px;
  height:31px;
  margin:0 10px;
  border:1px solid var(--pf-line-soft);
  border-radius:8px;
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
  .nav-link{
    min-height:36px;
  }
  .hero-signin-container{
    min-width:0;
    margin-left:auto;
  }
  .mo-wrap{
    width:calc(100% - 44px);
    max-width:none;
    margin:0 auto;
    padding:24px 0 42px;
  }
  .mo-tabs{
    align-items:flex-start;
    flex-direction:column;
  }
  .mo-tab-list{
    gap:24px;
  }
  .mo-tools{
    width:100%;
    justify-content:flex-start;
    flex-wrap:wrap;
  }
  .mo-card{
    grid-template-columns:100px minmax(0,1fr);
  }
  .mo-side{
    grid-column:1 / -1;
    border-left:0;
    border-top:1px solid var(--pf-line-soft);
    padding:14px 0 0;
    grid-template-columns:repeat(3,max-content);
    align-items:center;
    justify-content:space-between;
  }
}
@media(max-width:820px){
  .brand-logo-block{
    width:auto;
    min-width:190px;
  }
  .brand-main-text{
    font-size:18px;
  }
  .hero-signin-container{
    width:100%;
    justify-content:flex-start;
    flex-wrap:wrap;
  }
  .nav-search-box{
    width:min(100%,260px);
  }
  .mo-wrap{
    width:calc(100% - 28px);
    max-width:none;
    margin:0 auto;
    padding:22px 0 36px;
  }
  .mo-title{
    font-size:34px;
  }
  .mo-tab-list{
    gap:22px;
  }
  .mo-tab,
  .mo-tab b{
    font-size:13px;
  }
  .mo-control-box,
  .mo-tool{
    height:32px;
  }
  .mo-card{
    grid-template-columns:1fr;
    padding:16px;
  }
  .mo-thumb{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:flex-start;
    gap:14px;
    text-align:left;
  }
  .mo-paper{
    width:74px;
    height:92px;
  }
  .mo-details{
    grid-template-columns:1fr;
  }
  .mo-dispatch{
    flex-direction:column;
    align-items:flex-start;
  }
  .mo-side{
    grid-template-columns:1fr;
    justify-content:start;
  }
}
@media(max-width:520px){
  .mo-tab-list{
    gap:18px 20px;
  }
  .mo-tools,
  .mo-control-box,
  .mo-filter-wrap,
  .mo-tool{
    width:100%;
  }
  .mo-control-box{
    justify-content:space-between;
  }
  .mo-select{
    flex:1;
    min-width:0;
  }
  .mo-filter-menu{
    left:0;
    right:auto;
    width:100%;
  }
}
</style>
</head>
<body>
@include('components.customer-front-header', ['frontActive' => ''])

<div class="mo-page">
  <div class="mo-wrap">
    <div class="mo-crumb">
      <a href="{{ route('home') }}" class="mo-home-link"><i class="fa-solid fa-house"></i>Back to Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('co.place-order') }}" class="current" aria-current="page">Order Tracking</a>
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

      <div class="mo-tools" aria-label="Order tools">
        <label class="mo-control-box">
          <span>Sort By</span>
          <select class="mo-select" aria-label="Sort orders">
            <option value="newest">Newest First</option>
            <option value="oldest">Oldest First</option>
            <option value="highest">Highest Total</option>
            <option value="lowest">Lowest Total</option>
          </select>
        </label>

        <div class="mo-filter-wrap">
          <button class="mo-tool" type="button" id="moFilterBtn" aria-haspopup="true" aria-expanded="false" aria-controls="moFilterMenu">
            <i class="fa-solid fa-filter"></i>
            <span>Filter</span>
          </button>

          <div class="mo-filter-menu" id="moFilterMenu" hidden>
            <button type="button" data-menu-filter="all" class="active">All Orders</button>
            <button type="button" data-menu-filter="topay">To Pay</button>
            <button type="button" data-menu-filter="toship">To Ship</button>
            <button type="button" data-menu-filter="shipped">To Receive</button>
            <button type="button" data-menu-filter="delivered">To Review</button>
            <button type="button" data-menu-filter="cancelled">Cancelled</button>
          </div>
        </div>
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
          $detailUrl = route('co.place-order.show', $order);
          $serviceName = $item?->service_name ?: $item?->service?->name ?: 'Print Order';
          $variationLabel = $item?->variation_label ?: $variation?->variation_label;
          $color = $variation?->color_mode;
          $paperSize = $variation?->product_size ?: $variationLabel;
          $printOption = $variation?->finish_type ?: ($item?->price_type ? str($item->price_type)->title()->toString() : null);
          $fileType = $file?->original_name ? strtoupper(pathinfo($file->original_name, PATHINFO_EXTENSION) ?: 'FILE') : null;
        @endphp

        <article class="mo-card" data-order-card data-status="{{ $statusKey($order) }}" data-created="{{ optional($order->created_at)->timestamp ?? 0 }}" data-total="{{ (float) $order->total_price }}" data-href="{{ $detailUrl }}" tabindex="0" role="link" aria-label="Track order {{ $orderNo($order) }}">
          <div class="mo-thumb">
            <div class="mo-paper" aria-hidden="true">
              <span></span>
              <span></span>
              <span class="short"></span>
              <span></span>
              <span></span>
              <span class="short"></span>
              <span></span>
              <span></span>
              <span></span>
            </div>
            <span class="mo-pages">{{ $quantity }} {{ $quantity === 1 ? 'page' : 'pages' }}</span>
          </div>

          <div class="mo-main">
            <h2 class="mo-product">{{ $serviceName }}</h2>

            <div class="mo-meta">
              @if($paperSize)
                <span><i class="fa-regular fa-file-lines"></i>{{ $paperSize }}</span>
              @endif
              <span><i class="fa-regular fa-copy"></i>{{ $quantity }} {{ $quantity === 1 ? 'sheet' : 'sheets' }}</span>
              @if($color)
                <span><i class="fa-solid fa-droplet"></i>{{ $color }}</span>
              @endif
              @if($printOption)
                <span>Print: {{ $printOption }}</span>
              @endif
              @if($fileType)
                <span>File: {{ $fileType }}</span>
              @endif
            </div>

            <div class="mo-details">
              <div>
                <span class="mo-label">Order No.</span>
                <span class="mo-value">{{ $orderNo($order) }}</span>
              </div>
              <div>
                <span class="mo-label">Order Date</span>
                <span class="mo-value">{{ optional($order->created_at)->format('M d, Y - h:i A') }}</span>
              </div>
              <div>
                <span class="mo-label">Order Confirmed</span>
                <span class="mo-value">{{ optional($order->created_at)->format('M d, h:i A') }}</span>
              </div>
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
            <a class="mo-btn" href="{{ $detailUrl }}" onclick="event.stopPropagation()">
              <i class="fa-solid fa-location-dot"></i>
              View &amp; Track
            </a>
          </div>
        </article>
      @empty
        <div class="mo-empty">
          <i class="fa-regular fa-folder-open" style="font-size:34px;color:#cbd5e1"></i>
          <p>You have no orders yet.</p>
        </div>
      @endforelse
    </div>
  </div>
</div>

<script>
const ordersList = document.getElementById('ordersList');
const sortSelect = document.querySelector('.mo-select');
const filterButton = document.getElementById('moFilterBtn');
const filterMenu = document.getElementById('moFilterMenu');

function getOrderCards(){
  return Array.from(document.querySelectorAll('[data-order-card]'));
}

function setActiveFilter(filter){
  document.querySelectorAll('.mo-tab').forEach(function(tab){
    tab.classList.toggle('active', (tab.dataset.filter || 'all') === filter);
  });

  document.querySelectorAll('[data-menu-filter]').forEach(function(item){
    item.classList.toggle('active', (item.dataset.menuFilter || 'all') === filter);
  });
}

function applyFilter(filter){
  const activeFilter = filter || 'all';
  setActiveFilter(activeFilter);

  getOrderCards().forEach(function(card){
    card.style.display = activeFilter === 'all' || card.dataset.status === activeFilter ? '' : 'none';
  });
}

function sortOrders(sortType){
  if(!ordersList) return;

  const cards = getOrderCards();
  const sortedCards = cards.sort(function(a, b){
    const createdA = Number(a.dataset.created || 0);
    const createdB = Number(b.dataset.created || 0);
    const totalA = Number(a.dataset.total || 0);
    const totalB = Number(b.dataset.total || 0);

    if(sortType === 'oldest') return createdA - createdB;
    if(sortType === 'highest') return totalB - totalA;
    if(sortType === 'lowest') return totalA - totalB;
    return createdB - createdA;
  });

  sortedCards.forEach(function(card){
    ordersList.appendChild(card);
  });
}

function closeFilterMenu(){
  if(!filterMenu || !filterButton) return;
  filterMenu.hidden = true;
  filterButton.setAttribute('aria-expanded', 'false');
}

document.querySelectorAll('.mo-tab').forEach(function(tab){
  tab.addEventListener('click', function(){
    applyFilter(tab.dataset.filter || 'all');
    closeFilterMenu();
  });
});

if(sortSelect){
  sortSelect.addEventListener('change', function(){
    sortOrders(sortSelect.value || 'newest');
  });
}

if(filterButton && filterMenu){
  filterButton.addEventListener('click', function(event){
    event.stopPropagation();
    filterMenu.hidden = !filterMenu.hidden;
    filterButton.setAttribute('aria-expanded', filterMenu.hidden ? 'false' : 'true');
  });

  filterMenu.querySelectorAll('[data-menu-filter]').forEach(function(item){
    item.addEventListener('click', function(){
      applyFilter(item.dataset.menuFilter || 'all');
      closeFilterMenu();
    });
  });

  document.addEventListener('click', function(event){
    if(!filterMenu.hidden && !filterMenu.contains(event.target) && !filterButton.contains(event.target)){
      closeFilterMenu();
    }
  });

  document.addEventListener('keydown', function(event){
    if(event.key === 'Escape') closeFilterMenu();
  });
}

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
