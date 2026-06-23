@php
    $frontCartCount = collect(session('cart', []))->sum(fn ($row) => max(1, (int) ($row['qty'] ?? 1)));
@endphp
<style id="customer-original-front-header-style">
@font-face{font-family:'CustomerFrontLeague';src:url('/Fonts/LeagueSpartan-SemiBold.otf') format('opentype');font-weight:600;font-display:swap}
@font-face{font-family:'CustomerFrontInter';src:url('/Fonts/Inter.ttc') format('truetype-collection'),url('/Fonts/Inter.ttc') format('truetype');font-weight:400 800;font-display:swap}
.customer-front-header{height:82px;background:#080808;color:#fff;display:flex;align-items:center;position:sticky;top:0;z-index:1000;box-shadow:0 12px 28px rgba(0,0,0,.13);font-family:'CustomerFrontInter',Arial,sans-serif}
.customer-front-header__inner{width:100%;display:grid;grid-template-columns:minmax(265px,1fr) auto minmax(420px,1fr);align-items:center;gap:30px;padding:0 60px}
.customer-front-brand{width:max-content;color:#fff!important;text-decoration:none!important;display:flex;flex-direction:column;line-height:1}
.customer-front-brand strong{font-family:Georgia,serif;font-size:25px;letter-spacing:.025em;font-weight:900}
.customer-front-brand small{margin-top:7px;color:#ff4f16;font-size:7px;font-weight:800;letter-spacing:.16em}
.customer-front-nav{height:82px;display:flex;align-items:center;justify-content:center;gap:50px}
.customer-front-nav a{height:100%;display:inline-flex;align-items:center;position:relative;color:#fff!important;text-decoration:none!important;font-family:'CustomerFrontLeague',Arial,sans-serif;font-size:13px;font-weight:600;letter-spacing:.08em;white-space:nowrap}
.customer-front-nav a:after,.customer-front-actions a.customer-front-action:after{content:"";position:absolute;left:50%;right:50%;bottom:18px;height:2px;background:#ff7a00;transition:left .18s ease,right .18s ease}
.customer-front-nav a:hover,.customer-front-nav a:focus-visible{color:#ff8a00!important;outline:0}
.customer-front-nav a:hover:after,.customer-front-nav a:focus-visible:after,.customer-front-nav a.active:after{left:0;right:0}
.customer-front-nav a.active{color:#ff8a00!important}
.customer-front-actions{display:flex;align-items:center;justify-content:flex-end;gap:18px;min-width:0}
.customer-front-search{width:240px;height:40px;border:0;border-radius:999px;background:#fff;color:#111827;padding:0 18px;font:400 12px 'CustomerFrontInter',Arial,sans-serif;outline:0}
.customer-front-search:focus{box-shadow:0 0 0 3px rgba(255,122,0,.3)}
.customer-front-action{position:relative;color:#fff!important;text-decoration:none!important;display:inline-flex;align-items:center;justify-content:center;min-width:25px;height:44px;font-size:21px}
.customer-front-actions a.customer-front-action:after{bottom:3px}
.customer-front-actions a.customer-front-action:hover:after,.customer-front-actions a.customer-front-action:focus-visible:after{left:2px;right:2px}
.customer-front-cart-count{position:absolute;top:1px;right:-8px;min-width:17px;height:17px;border-radius:999px;background:#ff4f16;color:#fff;display:grid;place-items:center;padding:0 4px;font-size:9px;font-weight:800}
.customer-front-account{max-width:190px;gap:8px;justify-content:flex-start;font-family:'CustomerFrontLeague',Arial,sans-serif;font-size:12px;font-weight:600;white-space:nowrap}
.customer-front-account span{overflow:hidden;text-overflow:ellipsis}
.ot-crumb a,.od-crumb a,.mo-crumb a{position:relative;color:#697482!important;text-decoration:none!important;padding:0 0 4px;transition:color .18s ease}
.ot-crumb a:after,.od-crumb a:after,.mo-crumb a:after{content:"";position:absolute;left:50%;right:50%;bottom:0;height:2px;background:#ff6a21;transition:left .18s ease,right .18s ease}
.ot-crumb a:hover,.ot-crumb a:focus-visible,.od-crumb a:hover,.od-crumb a:focus-visible,.mo-crumb a:hover,.mo-crumb a:focus-visible,.ot-crumb a.active,.od-crumb a.active,.mo-crumb a.active{color:#ff5a14!important;outline:0}
.ot-crumb a:hover:after,.ot-crumb a:focus-visible:after,.od-crumb a:hover:after,.od-crumb a:focus-visible:after,.mo-crumb a:hover:after,.mo-crumb a:focus-visible:after,.ot-crumb a.active:after,.od-crumb a.active:after,.mo-crumb a.active:after{left:0;right:0}
@media(max-width:1180px){.customer-front-header__inner{grid-template-columns:auto 1fr auto;padding:0 26px;gap:20px}.customer-front-nav{gap:24px}.customer-front-search{width:190px}.customer-front-brand strong{font-size:21px}}
@media(max-width:880px){.customer-front-header{height:auto;min-height:72px}.customer-front-header__inner{grid-template-columns:1fr auto;padding:12px 18px}.customer-front-nav{grid-column:1/-1;grid-row:2;height:42px;justify-content:flex-start;overflow-x:auto}.customer-front-nav a{height:42px}.customer-front-nav a:after{bottom:0}.customer-front-search{display:none}.customer-front-account span{display:none}}
</style>
<header class="customer-front-header" id="customerOriginalHeader">
  <div class="customer-front-header__inner">
    <a class="customer-front-brand" href="{{ route('home') }}" aria-label="Printify and Co Home">
      <strong>PRINTIFY &amp; CO.</strong>
      <small>CRAFTING YOUR VISION INTO REALITY</small>
    </a>
    <nav class="customer-front-nav" aria-label="Main navigation">
      <a href="{{ route('home') }}">HOME</a>
      <a href="{{ route('landing.aboutus') }}">ABOUT US</a>
      <a class="active" href="{{ route('services.index') }}">SERVICES</a>
      <a href="{{ route('landing.contactus') }}">CONTACT US</a>
    </nav>
    <div class="customer-front-actions">
      <input class="customer-front-search" type="search" placeholder="Search products or services..." aria-label="Search products or services">
      <a class="customer-front-action" href="{{ route('services.index') }}" aria-label="Wishlist"><i class="fa-regular fa-heart"></i></a>
      <a class="customer-front-action" href="{{ route('cart.index') }}" aria-label="Cart"><i class="fa-solid fa-cart-shopping"></i>@if($frontCartCount)<span class="customer-front-cart-count">{{ $frontCartCount }}</span>@endif</a>
      <a class="customer-front-action customer-front-account" href="{{ route('dashboard') }}" aria-label="Customer dashboard"><i class="fa-regular fa-user"></i><span>{{ strtoupper(auth()->user()?->name ?? 'CUSTOMER') }}</span></a>
    </div>
  </div>
</header>
