@php
    $frontCartCount = collect(session('cart', []))->sum(fn ($row) => max(1, (int) ($row['qty'] ?? 1)));
    $frontActive = $frontActive ?? ($activeSection ?? '');
@endphp
<style id="customer-original-front-header-style">
#customerOriginalHeader{--orange:#ff7a00;--red:#ff2b1a;position:sticky!important;top:0!important;z-index:1000!important;width:100%!important;background:rgba(7,7,7,.98)!important;border-bottom:1px solid rgba(255,255,255,.12)!important;box-shadow:0 10px 34px rgba(0,0,0,.28)!important;color:#fff!important}
#customerOriginalHeader .premium-main-navbar{position:relative!important;width:min(1680px,calc(100% - 110px))!important;min-height:70px!important;margin:0 auto!important;padding:0!important;display:flex!important;align-items:center!important;gap:34px!important}
#customerOriginalHeader .brand-logo-block{flex:0 0 230px!important;min-width:230px!important;width:auto!important;height:70px!important;color:#fff!important;text-decoration:none!important;line-height:1!important;display:flex!important;flex-direction:column!important;justify-content:center!important}
#customerOriginalHeader .brand-main-text{font-family:'Inter',system-ui,sans-serif!important;font-size:24px!important;font-weight:900!important;letter-spacing:-1.2px!important;color:#fff!important;white-space:nowrap!important}
#customerOriginalHeader .brand-sub-text{margin-top:4px!important;color:var(--red)!important;font-family:'League Spartan','Inter',system-ui,sans-serif!important;font-size:7.8px!important;font-weight:600!important;letter-spacing:1.35px!important;text-transform:uppercase!important;white-space:nowrap!important}
#customerOriginalHeader .nav-horizontal{position:absolute!important;left:50%!important;top:0!important;height:70px!important;transform:translateX(-50%)!important;display:flex!important;align-items:center!important;justify-content:center!important;gap:46px!important;flex:none!important;min-width:0!important}
#customerOriginalHeader .nav-horizontal .nav-link{position:relative!important;display:inline-flex!important;align-items:center!important;height:70px!important;min-height:70px!important;padding:0!important;color:#fff!important;text-decoration:none!important;border:0!important;font-family:'League Spartan','Inter',system-ui,sans-serif!important;font-size:13.5px!important;font-weight:600!important;line-height:1!important;letter-spacing:1.45px!important;text-transform:uppercase!important;white-space:nowrap!important;transition:color .18s ease!important}
#customerOriginalHeader .nav-horizontal .nav-link::after{content:""!important;position:absolute!important;left:0!important;right:0!important;top:auto!important;bottom:21px!important;width:100%!important;height:2px!important;border-radius:999px!important;background:var(--orange)!important;opacity:0!important;transform:scaleX(0)!important;transform-origin:center!important;transition:opacity .18s ease,transform .18s ease!important}
#customerOriginalHeader .nav-horizontal .nav-link:hover,#customerOriginalHeader .nav-horizontal .nav-link:focus-visible,#customerOriginalHeader .nav-horizontal .nav-link.active{color:var(--orange)!important;outline:0!important}
#customerOriginalHeader .nav-horizontal .nav-link:hover::after,#customerOriginalHeader .nav-horizontal .nav-link:focus-visible::after,#customerOriginalHeader .nav-horizontal .nav-link.active::after{opacity:1!important;transform:scaleX(1)!important}
#customerOriginalHeader .hero-signin-container{height:70px!important;margin-left:auto!important;min-width:0!important;display:flex!important;align-items:center!important;justify-content:flex-end!important;gap:12px!important}
#customerOriginalHeader .nav-search-box{position:relative!important;width:220px!important;height:38px!important;margin:0!important;border:1px solid #111827!important;border-radius:999px!important;background:#fff!important;display:flex!important;align-items:center!important;overflow:hidden!important;box-shadow:none!important}
#customerOriginalHeader .nav-search-box::before{content:"\f002";font-family:"Font Awesome 6 Free";font-weight:900;position:absolute;left:15px;top:50%;transform:translateY(-50%);color:#6b7280;font-size:12px;line-height:1;pointer-events:none;z-index:2}
#customerOriginalHeader .nav-search-box input{width:100%!important;height:100%!important;border:0!important;outline:0!important;padding:0 16px 0 38px!important;color:#111827!important;background:#fff!important;font-family:'Inter',system-ui,sans-serif!important;font-size:11.5px!important;font-weight:400!important}
#customerOriginalHeader .nav-search-box input::placeholder{color:#8b8b8b!important}
#customerOriginalHeader .nav-icon-link{position:relative!important;height:70px!important;min-height:70px!important;min-width:22px!important;color:#fff!important;text-decoration:none!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;gap:6px!important;font-family:'League Spartan','Inter',system-ui,sans-serif!important;font-size:13px!important;font-weight:700!important;line-height:1!important;opacity:.9!important}
#customerOriginalHeader .nav-icon-link:hover{color:var(--orange)!important}
#customerOriginalHeader .nav-svg-icon{width:22px!important;height:22px!important;object-fit:contain!important;display:block!important;filter:brightness(0) saturate(100%) invert(100%)!important;opacity:.88!important;transition:filter .2s ease,opacity .2s ease!important}
#customerOriginalHeader .nav-icon-link:hover .nav-svg-icon,#customerOriginalHeader .nav-icon-link.is-active .nav-svg-icon{filter:brightness(0) saturate(100%) invert(48%) sepia(98%) saturate(2262%) hue-rotate(351deg) brightness(101%) contrast(101%)!important}
#customerOriginalHeader .cart-badge{position:absolute!important;top:11px!important;right:-8px!important;min-width:16px!important;height:16px!important;border-radius:999px!important;background:var(--red)!important;color:#fff!important;font-size:9px!important;font-weight:800!important;line-height:16px!important;text-align:center!important;padding:0 4px!important}
#customerOriginalHeader .account-label{max-width:150px!important;color:#fff!important;font-family:'League Spartan','Inter',system-ui,sans-serif!important;font-size:13.5px!important;font-weight:600!important;line-height:1!important;white-space:nowrap!important;overflow:hidden!important;text-overflow:ellipsis!important}
#customerOriginalHeader .nav-icon-link:hover .account-label{color:var(--orange)!important}
.ot-crumb a,.od-crumb a,.mo-crumb a,.ot-crumb .current,.od-crumb .current,.mo-crumb .current{position:relative;color:#697482!important;text-decoration:none!important;padding:0 0 4px!important;transition:color .18s ease!important}
.ot-crumb a:after,.od-crumb a:after,.mo-crumb a:after,.ot-crumb .current:after,.od-crumb .current:after,.mo-crumb .current:after{content:""!important;position:absolute!important;left:50%!important;right:50%!important;bottom:0!important;height:2px!important;border-radius:999px!important;background:#ff6a21!important;transition:left .18s ease,right .18s ease!important}
.ot-crumb a:hover,.ot-crumb a:focus-visible,.od-crumb a:hover,.od-crumb a:focus-visible,.mo-crumb a:hover,.mo-crumb a:focus-visible,.ot-crumb a.active,.od-crumb a.active,.mo-crumb a.active,.ot-crumb a.current,.od-crumb a.current,.mo-crumb a.current,.ot-crumb .current,.od-crumb .current,.mo-crumb .current{color:#ff5a14!important;outline:0!important}
.ot-crumb a:hover:after,.ot-crumb a:focus-visible:after,.od-crumb a:hover:after,.od-crumb a:focus-visible:after,.mo-crumb a:hover:after,.mo-crumb a:focus-visible:after,.ot-crumb a.active:after,.od-crumb a.active:after,.mo-crumb a.active:after,.ot-crumb a.current:after,.od-crumb a.current:after,.mo-crumb a.current:after,.ot-crumb .current:after,.od-crumb .current:after,.mo-crumb .current:after{left:0!important;right:0!important}
@media(max-width:1180px){#customerOriginalHeader .premium-main-navbar{width:calc(100% - 34px)!important;gap:18px!important}#customerOriginalHeader .nav-horizontal{gap:25px!important}#customerOriginalHeader .brand-logo-block{flex-basis:205px!important;min-width:205px!important}#customerOriginalHeader .nav-search-box{width:190px!important}#customerOriginalHeader .account-label{display:none!important}}
@media(max-width:840px){#customerOriginalHeader .premium-main-navbar{min-height:auto!important;padding:14px 0!important;flex-wrap:wrap!important}#customerOriginalHeader .brand-logo-block{height:auto!important}#customerOriginalHeader .nav-horizontal{position:static!important;transform:none!important;order:3;width:100%!important;height:auto!important;justify-content:flex-start!important;overflow:auto!important;padding-top:10px!important}#customerOriginalHeader .nav-horizontal .nav-link{height:32px!important;min-height:32px!important}#customerOriginalHeader .nav-horizontal .nav-link::after{bottom:0!important}#customerOriginalHeader .hero-signin-container{height:auto!important;margin-left:auto!important}#customerOriginalHeader .nav-icon-link{height:38px!important;min-height:38px!important}#customerOriginalHeader .cart-badge{top:0!important}}
</style>
<header class="top-nav-bar premium-site-header header-dark" id="customerOriginalHeader">
  <div class="premium-main-navbar">
    <a href="{{ route('home') }}" class="brand-logo-block" aria-label="Printify and Co Home">
      <span class="brand-main-text">PRINTIFY &amp; CO.</span>
      <span class="brand-sub-text">CRAFTING YOUR VISION INTO REALITY</span>
    </a>

    <nav class="nav-horizontal" aria-label="Main navigation">
      <a class="nav-link {{ $frontActive === 'home' ? 'active' : '' }}" href="{{ route('home') }}">HOME</a>
      <a class="nav-link {{ $frontActive === 'about' ? 'active' : '' }}" href="{{ route('landing.aboutus') }}">ABOUT US</a>
      <a class="nav-link {{ in_array($frontActive, ['products', 'services'], true) ? 'active' : '' }}" href="{{ route('services.index') }}">SERVICES</a>
      <a class="nav-link {{ $frontActive === 'contact' ? 'active' : '' }}" href="{{ route('landing.contactus') }}">CONTACT US</a>
    </nav>

    <div class="hero-signin-container" id="authContainer">
      <form class="nav-search-box" method="GET" action="{{ route('customer.search') }}">
        <input type="search" name="q" id="navSearchInput" value="{{ request('q') }}" placeholder="Search products or services..." autocomplete="off">
      </form>

      <a href="{{ route('services.index') }}" class="nav-icon-link" aria-label="Wishlist">
        <img src="{{ asset('images/Heart.svg') }}" alt="Heart" class="nav-svg-icon">
      </a>

      <a href="{{ route('cart.index') }}" class="nav-icon-link" aria-label="Cart">
        <img src="{{ asset('images/Shopping cart.svg') }}" alt="Cart" class="nav-svg-icon">
        <span class="cart-badge" id="cartBadge">{{ $frontCartCount }}</span>
      </a>

      <a href="{{ route('dashboard') }}" class="nav-icon-link">
        <img src="{{ asset('images/user-logged.svg') }}" alt="Profile" class="nav-svg-icon">
        <span class="account-label">{{ auth()->user()?->name ?? 'Account' }}</span>
      </a>
    </div>
  </div>
</header>
<script id="customer-original-front-header-links">
(function(){
  var header=document.getElementById('customerOriginalHeader');
  if(!header||header.dataset.hardLinks==='1')return;
  header.dataset.hardLinks='1';
  header.addEventListener('click',function(event){
    var link=event.target.closest&&event.target.closest('a[href]');
    if(!link||!header.contains(link)||link.target||link.hasAttribute('download'))return;
    var href=link.getAttribute('href')||'';
    if(!href||href.charAt(0)==='#'||/^javascript:/i.test(href))return;
    var url;
    try{url=new URL(href,window.location.origin)}catch(error){return}
    if(url.origin!==window.location.origin)return;
    event.preventDefault();
    window.location.href=url.href;
  },true);
})();
</script>
