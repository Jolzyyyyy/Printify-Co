<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Printing Business Solution | Printify &amp; Co.</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="preload" as="font" href="/Fonts/Boxing-Regular.otf" type="font/otf" crossorigin>
<link rel="preload" as="font" href="/Fonts/LeagueSpartan-SemiBold.otf" type="font/otf" crossorigin>
<link rel="preload" as="font" href="/Fonts/Inter.ttc" type="font/collection" crossorigin>
<link rel="preload" as="font" href="/Fonts/Boxing-Regular.otf" type="font/otf" crossorigin>
<link rel="preload" as="font" href="/Fonts/LeagueSpartan-SemiBold.otf" type="font/otf" crossorigin>
<link rel="preload" as="font" href="/Fonts/Inter.ttc" type="font/collection" crossorigin>
<link rel="preload" as="image" href="{{ asset('images/Document PS.png') }}" type="image/png" fetchpriority="high">
<link rel="preload" as="image" href="{{ asset('images/Photocopy & ScanningS.png') }}" type="image/png" fetchpriority="high">
<link rel="preload" as="image" href="{{ asset('images/Photo IDS.png') }}" type="image/png" fetchpriority="high">
<link rel="preload" as="image" href="{{ asset('images/Lamination & BindingS.png') }}" type="image/png">
<link rel="preload" as="image" href="{{ asset('images/Large FormatPS.png') }}" type="image/png">
<link rel="preload" as="image" href="{{ asset('images/Custom Special PS.png') }}" type="image/png">
<link rel="preload" as="image" href="{{ asset('images/Homesld1.jpg') }}" fetchpriority="high">
<link rel="preload" as="image" href="{{ asset('images/Homesld2.jpg') }}">
<link rel="preload" as="image" href="{{ asset('images/Homesld3.jpg') }}">
<style>
@font-face {
  font-family:'Boxing';
  src:url('/Fonts/Boxing-Regular.otf') format('opentype');
  font-weight:400;
  font-style:normal;
  font-display:block
}
@font-face {
  font-family:'League Spartan';
  src:url('/Fonts/LeagueSpartan-SemiBold.otf') format('opentype');
  font-weight:600;
  font-style:normal;
  font-display:block
}
@font-face {
  font-family:'Inter';
  src:url('/Fonts/Inter.ttc') format('truetype-collection'),url('/Fonts/Inter.ttc') format('truetype');
  font-weight:600;
  font-style:normal;
  font-display:block
}
:root {
  --red:#ff2b1a;
  --orange:#ff8a00;
  --orange2:#FFAB0A;
  --ui-orange-start:#FE7B09;
  --ui-orange-end:#FFAB0A;
  --ui-black:#111827;
  --dark:#070707;
  --text:#111111;
  --muted:#707070;
  --line:#ececec;
  --white:#ffffff
}
* {
  box-sizing:border-box
}
html {
  scroll-behavior:smooth
}
body {
  margin:0;
  overflow-x:hidden;
  color:var(--text);
  background:#ffffff;
  font-family:'Inter',sans-serif
}
.premium-site-header {
  position:sticky;
  top:0;
  z-index:1000;
  width:100%;
  background:rgba(255,255,255,0.98);
  border-bottom:1px solid #eeeeee;
  box-shadow:0 8px 30px rgba(0,0,0,0.05);
  transition:background .34s ease,border-color .34s ease,box-shadow .34s ease
}
.premium-site-header.header-dark {
  background:rgba(7,7,7,0.98);
  border-bottom-color:rgba(255,255,255,0.12);
  box-shadow:0 10px 34px rgba(0,0,0,0.28)
}
.premium-main-navbar {
  position:relative;
  width:min(1680px,calc(100% - 110px));
  min-height:70px;
  margin:0 auto;
  display:flex;
  align-items:center;
  gap:34px
}
.brand-logo-block {
  flex:0 0 230px;
  min-width:230px;
  height:70px;
  color:#111111;
  text-decoration:none;
  line-height:1;
  display:flex;
  flex-direction:column;
  justify-content:center
}
.brand-main-text {
  font-family:'Inter',sans-serif;
  font-size:24px;
  font-weight:900;
  letter-spacing:-1.2px;
  color:#111111;
  transition:color .2s ease
}
.brand-sub-text {
  margin-top:4px;
  color:var(--red);
  font-family:'League Spartan',sans-serif;
  font-size:7.8px;
  font-weight:800;
  letter-spacing:1.35px;
  transition:color .2s ease
}
.premium-site-header.header-dark .brand-main-text {
  color:#ffffff
}
.nav-horizontal {
  position:absolute;
  left:50%;
  top:0;
  height:70px;
  transform:translateX(-50%);
  display:flex;
  align-items:center;
  justify-content:center;
  gap:46px
}
.nav-link {
  position:relative;
  height:70px;
  display:inline-flex;
  align-items:center;
  color:#111111;
  text-decoration:none;
  border-bottom:0;
  font-family:'League Spartan',sans-serif;
  font-size:13.5px;
  font-weight:800;
  line-height:1;
  letter-spacing:1.45px;
  white-space:nowrap;
  transition:color 0.18s ease
}
.nav-link::after {
  content:"";
  position:absolute;
  left:6px;
  right:6px;
  top:calc(50%+13px);
  height:2px;
  border-radius:999px;
  background:var(--orange);
  opacity:0;
  transform:scaleX(0);
  transform-origin:center;
  transition:opacity .18s ease,transform .18s ease
}
.nav-link:hover {
  color:var(--orange)
}
.nav-link.active {
  color:var(--orange)
}
.nav-link:hover::after,.nav-link.active::after {
  opacity:1;
  transform:scaleX(1)
}
.premium-site-header.header-dark .nav-link {
  color:#ffffff
}
.premium-site-header.header-dark .nav-link:hover,.premium-site-header.header-dark .nav-link.active {
  color:var(--orange)
}
.hero-signin-container {
  height:70px;
  margin-left:auto;
  min-width:0;
  display:flex;
  align-items:center;
  justify-content:flex-end;
  gap:12px
}
.nav-search-box {
  width:285px;
  height:38px;
  border:1px solid #dedede;
  border-radius:16px;
  background:#ffffff;
  display:flex;
  align-items:center;
  overflow:hidden;
  box-shadow:0 8px 22px rgba(0,0,0,0.05);
  transition:border-color .22s ease,box-shadow .22s ease
}
.nav-search-box:focus-within {
  border-color:var(--orange);
  box-shadow:0 12px 28px rgba(255,90,18,0.14)
}
.nav-search-box input {
  width:100%;
  height:100%;
  border:0;
  outline:0;
  padding:0 15px;
  color:#333333;
  font-size:11.5px;
  font-family:'Inter',sans-serif;
  background:#ffffff
}
.nav-search-box input::placeholder {
  color:#8b8b8b
}
.nav-search-btn {
  width:44px;
  height:38px;
  border:0;
  border-left:1px solid rgba(0,0,0,.04);
  border-radius:0 15px 15px 0;
  cursor:pointer;
  background:var(--orange);
  display:grid;
  place-items:center;
  color:#ffffff;
  font-size:15px;
  transition:background .22s ease,box-shadow .22s ease
}
.nav-search-btn i {
  color:inherit
}
.nav-search-btn:hover {
  background:var(--red);
  box-shadow:0 8px 18px rgba(255,43,26,.24);
  transform:none
}
.nav-icon-link {
  position:relative;
  height:70px;
  color:#111111;
  text-decoration:none;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:6px;
  min-width:22px;
  cursor:pointer;
  font-family:'League Spartan',sans-serif;
  font-size:13px;
  font-weight:700;
  line-height:1;
  transition:color .2s ease,opacity .2s ease;
  opacity:.9
}
.nav-icon-link:hover {
  color:var(--orange)
}
.nav-click-pulse {
  transform:scale(.96)
}
.nav-icon-link i {
  color:inherit;
  transition:color .2s ease
}
.nav-svg-icon {
  width:22px;
  height:22px;
  object-fit:contain;
  display:block;
  filter:brightness(0) saturate(100%);
  transition:filter .2s ease,opacity .2s ease;
  opacity:.88
}
.nav-icon-link:hover .nav-svg-icon,.nav-icon-link.is-active .nav-svg-icon {
  filter:brightness(0) saturate(100%) invert(48%) sepia(98%) saturate(2262%) hue-rotate(351deg) brightness(101%) contrast(101%)
}
.premium-site-header.header-dark .nav-icon-link {
  color:#ffffff
}
.premium-site-header.header-dark .nav-svg-icon {
  filter:brightness(0) saturate(100%) invert(100%)
}
.premium-site-header.header-dark .nav-icon-link:hover .nav-svg-icon,.premium-site-header.header-dark .nav-icon-link.is-active .nav-svg-icon {
  filter:brightness(0) saturate(100%) invert(48%) sepia(98%) saturate(2262%) hue-rotate(351deg) brightness(101%) contrast(101%)
}
.account-label {
  max-width:150px;
  color:#111111;
  font-family:'League Spartan',sans-serif;
  font-size:13.5px;
  font-weight:800;
  line-height:1;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
  transition:color .2s ease
}
.premium-site-header.header-dark .account-label {
  color:#ffffff
}
.nav-icon-link:hover .account-label,.premium-site-header.header-dark .nav-icon-link:hover .account-label {
  color:var(--orange)
}
.main-content {
  padding-top:0
}
.section {
  display:none
}
.section.active {
  display:block
}
#home,#products,#services,#about,#contact {
  display:block!important;
  scroll-margin-top:76px
}
.home-premium-page {
  width:100%;
  background:#ffffff
}
.home-premium-hero {
  position:relative;
  height:400px;
  min-height:400px;
  overflow:hidden;
  background:#070707
}
.home-premium-slider,.hero-slide,.hero-overlay,.home-hero-light-streaks,.home-hero-particles {
  position:absolute;
  inset:0
}
.hero-slide {
  opacity:0;
  background-size:cover;
  background-position:center center;
  transform:scale(1.01);
  will-change:opacity;
  transition:opacity .75s ease
}
.hero-slide.active {
  opacity:1;
  transform:scale(1)
}
.home-premium-overlay {
  z-index:1;
  background:linear-gradient(90deg,rgba(0,0,0,0.84)0%,rgba(0,0,0,0.58)33%,rgba(0,0,0,0.22)62%,rgba(0,0,0,0.56)100%),radial-gradient(circle at 28% 55%,rgba(255,91,18,0.23),transparent 35%),radial-gradient(circle at 84% 40%,rgba(18,85,120,0.28),transparent 35%)
}
.home-hero-light-streaks {
  z-index:2;
  pointer-events:none;
  mix-blend-mode:screen;
  opacity:.74;
  background:linear-gradient(115deg,transparent 15%,rgba(255,91,18,.22)30%,transparent 41%),linear-gradient(108deg,transparent 62%,rgba(255,255,255,.14)70%,transparent 80%)
}
.home-hero-particles {
  display:none
}
.home-premium-hero-inner {
  position:relative;
  z-index:5;
  width:min(1500px,calc(100% - 150px));
  height:400px;
  margin:0 auto;
  display:grid;
  grid-template-columns:minmax(470px,610px);
  align-items:center;
  justify-content:start;
  gap:0;
  padding:27px 0 46px
}
.home-premium-copy {
  color:#ffffff;
  max-width:600px;
  transform:translateY(-2px)
}
.home-premium-kicker {
  margin:0 0 9px;
  color:#ffffff;
  font-family:'League Spartan',sans-serif;
  font-size:11px;
  font-weight:800;
  letter-spacing:2px;
  text-transform:uppercase
}
.home-premium-title {
  margin:0;
  color:#ffffff;
  font-family:'Inter',sans-serif;
  font-size:clamp(39px,3.3vw,58px);
  line-height:0.96;
  letter-spacing:-1.6px;
  font-weight:900;
  text-transform:uppercase;
  text-shadow:0 8px 28px rgba(0,0,0,0.58)
}
.home-premium-title .title-line {
  display:block;
  white-space:nowrap
}
.home-premium-title .title-accent {
  color:var(--orange)
}
.home-premium-title .letter {
  display:inline-block;
  opacity:0;
  transform:translateY(10px);
  animation:letterIgnite .52s cubic-bezier(.2,.8,.2,1)forwards
}
.home-premium-title .letter.space {
  width:0.32em
}
.home-premium-description {
  max-width:585px;
  margin:14px 0 0;
  color:rgba(255,255,255,0.9);
  font-family:'Inter',sans-serif;
  font-size:15px;
  font-weight:400;
  line-height:1.52
}
.home-premium-dots {
  position:absolute;
  left:50%;
  bottom:21px;
  z-index:6;
  display:flex;
  align-items:center;
  gap:10px;
  transform:translateX(-50%)
}
.home-premium-dots .dot {
  width:11px;
  height:11px;
  cursor:pointer;
  border-radius:999px;
  background:rgba(255,255,255,0.65);
  transition:0.25s ease
}
.home-premium-dots .dot.active {
  width:31px;
  background:var(--orange)
}
@keyframes letterIgnite {
  from {
    opacity:0;
    transform:translateY(10px)
  }
  to {
    opacity:1;
    transform:translateY(0)
  }
}
@media(max-width:1320px) {
  .premium-main-navbar {
    width:min(100% - 34px,1180px);
    display:flex;
    flex-wrap:wrap;
    padding:10px 0
  }
  .nav-horizontal {
    position:static;
    order:3;
    flex-basis:100%;
    height:auto;
    transform:none;
    gap:34px
  }
  .nav-link {
    height:auto;
    padding:17px 0
  }
  .nav-link::after {
    top:auto;
    bottom:8px
  }
  .hero-signin-container {
    min-width:0;
    margin-left:auto
  }
  .nav-search-box {
    width:230px
  }
}
@media(max-width:1180px) {
  .brand-logo-block {
    min-width:190px
  }
  .nav-search-box {
    display:none
  }
  .home-premium-hero,.home-premium-hero-inner {
    height:320px;
    min-height:320px
  }
  .home-premium-hero-inner {
    width:min(100% - 44px,1000px);
    grid-template-columns:1fr;
    gap:0;
    align-content:center
  }
}
@media(max-width:720px) {
  .premium-main-navbar {
    width:calc(100% - 26px);
    gap:14px
  }
  .brand-main-text {
    font-size:21px
  }
  .nav-horizontal {
    justify-content:flex-start;
    overflow-x:auto;
    gap:24px
  }
  .nav-link {
    font-size:12px;
    padding:17px 0
  }
  .hero-signin-container {
    gap:13px
  }
  .account-label {
    display:none
  }
  .home-premium-hero,.home-premium-hero-inner {
    height:360px;
    min-height:360px
  }
  .home-premium-title {
    font-size:38px
  }
  .home-premium-title .title-line {
    white-space:normal
  }
  .home-premium-description {
    font-size:13px
  }
}
.checkout-section {
  display:none;
  min-height:calc(100vh - 70px);
  background:#fbfaf8
}
.checkout-section.active {
  display:block
}
body.checkout-open {
  background:#fbfaf8
}
body.checkout-open #pageWrapper,body.service-detail-open #pageWrapper {
  display:none!important
}
body.front-route-service-details #pageWrapper,body.front-route-checkout #pageWrapper,
body.front-route-service-details .printify-footer,body.front-route-checkout .printify-footer {
  display:none!important
}
body.front-route-service-details #serviceDetail,body.service-detail-open #serviceDetail {
  display:block
}
body.front-route-service-details #checkout,
body.front-route-checkout #serviceDetail {
  display:none!important
}
body.front-route-checkout #checkout {
  display:block!important
}
/* Standalone sections are route-authoritative. A stale JS/open-state class must
   never leak Service Details or Checkout below another public page/footer. */
body:not(.front-route-service-details):not(.service-detail-open) #serviceDetail {
  display:none!important
}
body:not(.front-route-checkout):not(.checkout-open) #checkout {
  display:none!important
}
body.front-route-service-details:not(.service-detail-ready) #serviceDetail {
  visibility:hidden!important
}
body.front-route-checkout:not(.checkout-ready) #checkout {
  visibility:hidden!important
}
body:not(.cart-ui-ready) #pfyCartPanel,
body:not(.cart-ui-ready) #pfyCartBackdrop {
  visibility:hidden!important;
  pointer-events:none!important
}
body.cart-ui-ready #pfyCartPanel,
body.cart-ui-ready #pfyCartBackdrop {
  visibility:visible!important
}
body.checkout-open #serviceDetail {
  display:none!important
}
.front-feedback-toast {
  position:fixed;
  left:50%;
  top:50%;
  z-index:100000;
  min-width:0;
  max-width:min(440px,calc(100vw - 32px));
  transform:translate(-50%,-48%) scale(.98);
  opacity:0;
  pointer-events:none;
  background:transparent!important;
  color:#fff!important;
  border:0!important;
  border-radius:0!important;
  padding:0!important;
  text-align:center;
  font:400 12px/1.45 'Inter','Inter',sans-serif!important;
  box-shadow:none!important;
  backdrop-filter:none!important;
  text-shadow:0 1px 12px rgba(0,0,0,.68);
  transition:opacity .18s ease,transform .18s ease
}
.front-feedback-toast.show {
  opacity:1;
  transform:translate(-50%,-50%) scale(1)
}
.home-premium-page,.premium-site-header {
  font-family:'Inter',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
  letter-spacing:0
}
.home-premium-title {
  font-family:'League Spartan',Georgia,serif;
  font-weight:700;
  letter-spacing:0
}
.nav-search-btn {
  border:0!important;
  background:linear-gradient(90deg,var(--ui-orange-start),var(--ui-orange-end))!important;
  color:#111827!important;
  box-shadow:none!important;
  font-family:'Inter',system-ui,sans-serif;
  font-weight:600;
  letter-spacing:0
}
.nav-search-btn:hover {
  background:#111827!important;
  color:#fff!important;
  box-shadow:none!important;
  transform:none!important
}
.front-feedback-toast {
  box-shadow:none
}
.home-premium-page,.premium-site-header,.home-premium-page * {
  letter-spacing:0!important
}
.home-premium-title,.pfsvc-head h2,#about h2,#contact h2,.pdv-title,.pfy-title {
  font-family:'League Spartan',Georgia,serif!important;
  font-weight:700!important;
  letter-spacing:0!important
}
.pfsvc-body h3,#about h3,#contact h3,.pdv-card-title,.pfy-card-title,.pfy-summary h3 {
  font-family:'Inter',system-ui,sans-serif!important;
  font-weight:600!important;
  letter-spacing:0!important
}
.home-premium-page p,.home-premium-page input,.home-premium-page select,.home-premium-page textarea {
  font-family:'Inter',system-ui,sans-serif!important;
  font-weight:400!important;
  letter-spacing:0!important
}
.pfsvc-view,.pfy-promo button:not(:hover),.pdv-summary-head button:not(:hover) {
  background:linear-gradient(90deg,var(--ui-orange-start),var(--ui-orange-end))!important;
  color:#111827!important;
  border:0!important;
  box-shadow:none!important
}
.nav-search-btn,.pfsvc-chip,.pfsvc-bottom a,.pfdetail button,.pdv-cart,.pdv-choose-file,.pfy-check,.pfy-place-order {
  background:linear-gradient(90deg,var(--ui-orange-start),var(--ui-orange-end))!important;
  color:#111827!important;
  border:0!important;
  box-shadow:none!important
}
.nav-search-btn:hover,.pfsvc-chip:hover,.pfsvc-bottom a:hover,.pfdetail button:hover,.pdv-cart:hover,.pdv-choose-file:hover,.pfy-check:hover,.pfy-place-order:hover,.pfy-promo button:hover,.pdv-summary-head button:hover {
  background:#111827!important;
  color:#fff!important;
  border:0!important;
  box-shadow:none!important;
  transform:none!important
}
.home-premium-page .fa-shield,.home-premium-page .fa-shield-halved,.home-premium-page .fa-lock,.home-premium-page .fa-key {
  color:#dc2626!important
}
.home-premium-page .fa-envelope,.home-premium-page .fa-at {
  color:#111827!important
}
.home-premium-page .fa-phone,.home-premium-page .fa-mobile-screen {
  color:#2563eb!important
}
.home-premium-page .fa-location-dot,.home-premium-page .fa-map-location-dot {
  color:#16a34a!important
}
.home-premium-page .fa-cart-shopping {
  color:#ff8a00!important
}
.home-premium-page input[type="checkbox"]:checked {
  accent-color:#16a34a!important
}
.premium-site-header .nav-search-btn {
  width:auto!important;
  min-width:104px!important;
  height:34px!important;
  padding:8px 16px!important;
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(90deg,#FE7B09 0%,#FFAB0A 100%)!important;
  color:#111827!important;
  font-family:'Inter',system-ui,sans-serif!important;
  font-size:11px!important;
  font-weight:500!important;
  line-height:1!important;
  letter-spacing:0!important;
  text-transform:none!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  gap:7px!important;
  white-space:nowrap!important;
  box-shadow:none!important;
  transform:none!important;
  transition:background .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease!important
}
.premium-site-header .nav-search-btn:hover,.premium-site-header .nav-search-btn:focus {
  background:#111827!important;
  color:#ffffff!important;
  border-color:#111827!important;
  box-shadow:none!important;
  transform:none!important;
  outline:0!important
}
.premium-site-header .nav-search-btn:hover i,.premium-site-header .nav-search-btn:focus i {
  color:#ffffff!important
}
.nav-link::after,.home-premium-title .title-accent,.home-premium-dots .dot.active {
  color:#ff8a00!important;
  background:#ff8a00!important
}
.nav-link:hover,.nav-link.active,.premium-site-header.header-dark .nav-link:hover,.premium-site-header.header-dark .nav-link.active {
  color:#ff8a00!important
}
.home-premium-page .home-premium-title .title-line,.home-premium-page .home-premium-title .title-accent,.home-premium-title .title-line,.home-premium-title .title-accent {
  background:transparent!important;
  background-image:none!important;
  box-shadow:none!important
}
.home-premium-page .home-premium-title .title-accent,.home-premium-title .title-accent {
  color:#FE7B09!important
}
.premium-site-header .nav-search-box {
  position:relative!important;
  width:220px!important;
  height:38px!important;
  border:1px solid #111827!important;
  border-radius:999px!important;
  background:#ffffff!important;
  display:flex!important;
  align-items:center!important;
  overflow:hidden!important;
  box-shadow:none!important;
  transition:border-color .18s ease,box-shadow .18s ease!important
}
.premium-site-header .nav-search-box::before {
  content:"\f002";
  font-family:"Font Awesome 6 Free";
  font-weight:900;
  position:absolute;
  left:15px;
  top:50%;
  transform:translateY(-50%);
  color:#6b7280;
  font-size:12px;
  line-height:1;
  pointer-events:none;
  z-index:2
}
.premium-site-header .nav-search-box:focus-within {
  border-color:#111827!important;
  box-shadow:none!important
}
.premium-site-header .nav-search-box input {
  width:100%!important;
  height:100%!important;
  border:0!important;
  outline:0!important;
  padding:0 16px 0 38px!important;
  color:#111827!important;
  background:#ffffff!important;
  font-family:'Inter',system-ui,sans-serif!important;
  font-size:11.5px!important;
  font-weight:400!important
}
.premium-site-header .nav-search-box input::placeholder {
  color:#8b8b8b!important
}
.premium-site-header .nav-search-btn {
  display:none!important
}
.brand-logo-block {
  flex:0 0 330px!important;
  min-width:330px!important
}
.brand-main-text {
  font-family:'Boxing',serif!important;
  font-weight:500!important;
  font-size:26px!important;
  letter-spacing:1px!important;
  line-height:1!important;
  white-space:nowrap!important;
  word-break:keep-all!important;
  overflow:visible!important
}
.home-premium-kicker,.home-premium-description {
  font-family:'Inter',sans-serif!important;
  font-weight:400!important
}
.brand-sub-text,.nav-link,.nav-icon-link,.account-label,.home-premium-title,.pfsvc-head h2,#about h2,#contact h2,.pdv-title,.pfy-title,.pfsvc-body h3,#about h3,#contact h3,.pdv-card-title,.pfy-card-title,.pfy-summary h3 {
  font-family:'League Spartan',sans-serif!important;
  font-weight:600!important
}
.account-label {
  text-transform:uppercase!important
}
html,body,body:where(p,span,a,li,small,td,th,input,textarea,select,option,button,div),.home-premium-page,.home-premium-page:where(p,span,a,li,small,td,th,input,textarea,select,option,button,div),.premium-site-header,.premium-site-header:where(input,button,span,small,div),.hero-signin-container,.hero-signin-container:where(input,button,span,div),.front-feedback-toast,.modal,.modal:where(p,span,a,li,small,td,th,input,textarea,select,option,button,div),.cart-drawer,.cart-drawer:where(p,span,a,li,small,td,th,input,textarea,select,option,button,div),.service-card,.service-card:where(p,span,a,li,small,td,th,input,textarea,select,option,button,div),.product-card,.product-card:where(p,span,a,li,small,td,th,input,textarea,select,option,button,div) {
  font-family:'Inter','Inter',Arial,sans-serif!important;
  font-weight:600!important
}
body:where(h1,h2,h3,h4,h5,h6,label,strong,b),.home-premium-page:where(h1,h2,h3,h4,h5,h6,label,strong,b),.premium-site-header:where(.nav-link,.account-label,.brand-sub-text),.home-premium-kicker,.home-premium-title,.home-premium-title *,.home-feature-card-title,.home-feature-card h3,.home-service-title,.home-service-card h3,.home-service-card-title,.home-section-kicker,.home-section-title,.home-section-title *,.home-section-subtitle,.section-kicker,.section-title,.section-title *,.section-subtitle,.category-title,.card-title,.card-title *,.card-subtitle,.service-title,.service-title *,.service-subtitle,.product-title,.product-title *,.product-subtitle,.feature-title,.feature-subtitle,.browse-title,.filter-title,.sort-label,.form-title,.modal-title,.drawer-title,.nav-link,.account-label,.brand-sub-text,[class*='title'],[class*='subtitle'],[class*='heading'],[class*='kicker'],[class*='label'] {
  font-family:'League Spartan','League Spartan',Arial,sans-serif!important;
  font-weight:600!important
}
body:where(button,.btn,.ui-btn,.home-btn,.hero-btn,.service-btn,.product-btn,.nav-search-btn,input[type='submit'],input[type='button'],a.btn,a.ui-btn,a.home-btn,a.hero-btn),.home-premium-page:where(button,.btn,.ui-btn,.home-btn,.hero-btn,.service-btn,.product-btn,.nav-search-btn,input[type='submit'],input[type='button'],a.btn,a.ui-btn,a.home-btn,a.hero-btn),.premium-site-header:where(button,.nav-search-btn,input) {
  font-family:'Inter','Inter',Arial,sans-serif!important;
  font-weight:600!important
}
.brand-main-text,.printify-wordmark,.printify-logo,.printify-brand,.brand-logo,.logo-text,.footer-brand h2,.footer-bottom .printify-wordmark,[aria-label*='Printify'],[title*='Printify'] {
  font-family:'Boxing','Boxing',serif!important;
  font-weight:400!important
}
i,.fa,.fas,.far,.fab,.fa-solid,.fa-regular,.fa-brands {
  font-family:'Font Awesome 6 Free','Font Awesome 6 Brands'!important
}
</style>
<style id="home-services-heading-font-match">
@font-face {
  font-family:'Clash Display';
  src:url(" {
    {
      asset('Fonts/ClashDisplay-Semibold.otf')
    }
  }
  ") format('opentype');
  font-weight:600;
  font-style:normal;
  font-display:block
}
.home-premium-kicker {
  font-family:'Clash Display','League Spartan',sans-serif!important;
  font-weight:600!important;
  letter-spacing:0!important;
  text-transform:uppercase!important
}
.home-premium-title,.home-premium-title .title-line {
  font-family:'Clash Display','League Spartan',sans-serif!important;
  font-weight:600!important;
  letter-spacing:0!important
}
</style>
<style id="front-nav-hero-polish-0615">
.premium-site-header .nav-horizontal .nav-link {
  position:relative!important;
  display:inline-flex!important;
  align-items:center!important;
  height:70px!important;
  padding:0!important;
  line-height:1!important;
  text-decoration:none!important;
  border:0!important
}
.premium-site-header .nav-horizontal .nav-link::after {
  content:""!important;
  position:absolute!important;
  left:0!important;
  right:0!important;
  top:auto!important;
  bottom:21px!important;
  width:100%!important;
  height:2px!important;
  border-radius:999px!important;
  background:#ff7a00!important;
  opacity:0!important;
  transform:scaleX(0)!important;
  transform-origin:center!important;
  transition:opacity .18s ease,transform .18s ease!important
}
.premium-site-header .nav-horizontal .nav-link:hover::after,
.premium-site-header .nav-horizontal .nav-link.active::after {
  opacity:1!important;
  transform:scaleX(1)!important
}
.home-hero-brand-mark {
  position:absolute;
  right:4.8%;
  top:50%;
  width:clamp(175px,16vw,285px);
  height:auto;
  opacity:.58;
  z-index:3;
  pointer-events:none;
  user-select:none;
  object-fit:contain;
  filter:drop-shadow(0 22px 44px rgba(0,0,0,.45));
  transform:translateY(-50%)
}
.home-premium-hero-inner {
  z-index:5
}
@media(max-width:980px) {
  .home-hero-brand-mark {
    right:22px;
    width:150px;
    opacity:.16
  }
}
@media(max-width:720px) {
  .home-hero-brand-mark {
    display:none
  }
}
</style>
<style id="service-checkout-contact-typography-lock">
@font-face{font-family:'LeagueSpartanFinal';src:url('/Fonts/LeagueSpartan-SemiBold.otf') format('opentype');font-weight:600;font-style:normal;font-display:swap}
@font-face{font-family:'InterFinal';src:url('/Fonts/Inter.ttc') format('truetype-collection');font-weight:600;font-style:normal;font-display:swap}
#serviceDetail,
#checkout,
#serviceDetail :where(p,span,a,li,small,td,th,input,textarea,select,option,button,div),
#checkout :where(p,span,a,li,small,td,th,input,textarea,select,option,button,div){
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-weight:600!important;
}
#serviceDetail :where(h1,h2,h3,h4,h5,h6,label,strong,b,.pdv-title,.pdv-card-title,.pdv-section-title,.service-title,.summary-title),
#checkout :where(h1,h2,h3,h4,h5,h6,label,strong,b,.pfy-title,.pfy-card-title,.pfy-section-title,.checkout-title){
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-weight:600!important;
}
#serviceDetail :where(button,input,textarea,select,option),
#checkout :where(button,input,textarea,select,option){
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
}
</style>
</head>
@php($activeSection = $activeSection ?? 'home')
<body class="front-route-{{ str_replace('_', '-', $activeSection) }} {{ auth()->check() ? 'auth-user' : 'guest-user' }}">
<div id="frontFeedbackToast" class="front-feedback-toast" role="status" aria-live="polite">
</div>
<header class="top-nav-bar premium-site-header" id="mainHeader">
<div class="premium-main-navbar">
<a href="{{ route('home') }}" class="brand-logo-block" aria-label="Printify and Co Home">
<span class="brand-main-text">PRINTIFY &amp; CO.</span>
<span class="brand-sub-text">CRAFTING YOUR VISION INTO REALITY</span>
</a>
<nav class="nav-horizontal" aria-label="Main navigation">
<a href="{{ route('home') }}" class="nav-link {{ $activeSection === 'home' ? 'active' : '' }}" data-section="home">HOME</a>
<a href="{{ route('landing.aboutus') }}" class="nav-link {{ $activeSection === 'about' ? 'active' : '' }}" data-section="about">ABOUT US</a>
<a href="{{ route('services.index') }}" class="nav-link {{ $activeSection === 'products' || $activeSection === 'service-details' ? 'active' : '' }}" data-section="products">SERVICES</a>
<a href="{{ route('landing.contactus') }}" class="nav-link {{ $activeSection === 'contact' ? 'active' : '' }}" data-section="contact">CONTACT US</a>
</nav>
<div class="hero-signin-container" id="authContainer">
<div class="nav-search-box">
<input type="text" id="navSearchInput" placeholder="Search products or services..." autocomplete="off">
</div>
<a href="javascript:void(0)" id="navHeart" class="nav-icon-link" onclick="toggleWishlist();return false;" aria-label="Wishlist" aria-pressed="false">
<img src="{{ asset('images/Heart.svg') }}" alt="Heart" class="nav-svg-icon">
</a>
<a href="javascript:void(0)" onclick="if(typeof requireSignedInForOrder==='function'&&!requireSignedInForOrder('/cart'))return false;if(typeof toggleCart==='function'){return toggleCart();}return false;" id="navCart" class="nav-icon-link" aria-label="Cart">
<img src="{{ asset('images/Shopping cart.svg') }}" alt="Cart" class="nav-svg-icon">
<span class="cart-badge" id="cartBadge">0</span>
</a>
@auth
@if(Auth::user()->role === 'admin')
<a href="{{ route('admin.dashboard') }}" class="nav-icon-link" title="Admin Panel">
<img src="{{ asset('images/user-logged.svg') }}" alt="Admin Profile" class="nav-svg-icon">
<span class="account-label">{{ Auth::user()->name }}</span>
</a>
@else
<a href="{{ route('dashboard') }}" class="nav-icon-link">
<img src="{{ asset('images/user-logged.svg') }}" alt="Profile" class="nav-svg-icon">
<span class="account-label">{{ Auth::user()->name }}</span>
</a>
@endif
@else
<a href="{{ route('login') }}" id="navUserPlus" class="nav-icon-link">
<img src="{{ asset('images/User plus.svg') }}" alt="User Plus" class="nav-svg-icon">
<span class="account-label">Account</span>
<i class="fa-solid fa-chevron-down" style="font-size:10px">
</i>
</a>
@endauth
</div>
</div>
</header>
@php($isStandaloneFrontRoute = in_array($activeSection, ['service-details', 'checkout'], true))
@unless($isStandaloneFrontRoute)
<div class="main-content" id="pageWrapper">
<section id="home" class="section active">
<div class="home-premium-page">
<div class="home-premium-hero">
<div class="hero-slider home-premium-slider">
<div class="hero-slide active" style="background-image:url('{{ asset('images/Homesld1.jpg') }}')">
</div>
<div class="hero-slide" style="background-image:url('{{ asset('images/Homesld2.jpg') }}')">
</div>
<div class="hero-slide" style="background-image:url('{{ asset('images/Homesld3.jpg') }}')">
</div>
</div>
<div class="hero-overlay home-premium-overlay">
</div>
<div class="home-hero-light-streaks" aria-hidden="true">
</div>
<div class="home-hero-particles" aria-hidden="true">
</div>
<img class="home-hero-brand-mark" src="{{ asset('images/printify-footer-logo.png') }}" alt="" aria-hidden="true">
<div class="home-premium-hero-inner">
<div class="home-premium-copy">
<p class="home-premium-kicker">HIGH-QUALITY PRINTING SOLUTIONS</p>
<h1 class="home-premium-title" id="kineticHeroTitle" aria-label="Premium prints. Fast delivery. Unlimited possibilities.">
<span class="title-line">PREMIUM PRINTS.</span>
<span class="title-line">FAST DELIVERY.</span>
<span class="title-line title-accent">UNLIMITED</span>
<span class="title-line">POSSIBILITIES.</span>
</h1>
<p class="home-premium-description">High-quality printing solutions for every need. From documents to large formats, we deliver precision, color, and impact.</p>
</div>
</div>
<div class="slide-indicators home-premium-dots">
<div class="dot active" onclick="jumpToHero(0)">
</div>
<div class="dot" onclick="jumpToHero(1)">
</div>
<div class="dot" onclick="jumpToHero(2)">
</div>
</div>
</div>
</div>
</section>
@include('f-services')
@include('f-about-us')
@include('f-contact-us')
</div>
@endunless
@include('f-service-details')
@if($activeSection === 'checkout')
@include('f-checkout')
@endif
<script>
let currentHeroIndex=0,heroTimer=null,isAutoScrolling=false,autoScrollTarget='{{ $activeSection }}',scrollSpyTick=null;
const initialRouteSection=(()=>{
  const path=(window.location.pathname||'').toLowerCase();
  if(/checkout|payment|confirmation|e-receipt/.test(path))return'checkout';
  if(/service-detail|service_details|details|detail-info/.test(path))return'service-details';
  if(/service|product/.test(path))return'products';
  if(/about/.test(path))return'about';
  if(/contact|quote|inquiry/.test(path))return'contact';
  return '{{ $activeSection }}';
})();
const isSignedIn=@json(Auth::check());
const loginUrl='{{ route('login') }}';
const darkHeaderSections=new Set(['products','about','contact','service-details','checkout','cart','payment','confirmation']);
const standaloneRouteSections=new Set(['service-details','checkout']);
const sectionAliases={
  services:'products',service:'products',product:'products',products:'products',aboutus:'about','about-us':'about',contactus:'contact','contact-us':'contact','service-details':'service-details',
'service-detail':'service-details',serviceDetails:'service-details',serviceDetail:'service-details',cart:'cart',search:'search',checkout:'checkout'
};
const sectionSelectors={
  home:['#home'],products:['#products','#services','[data-section-id="products"]','[data-section="products"]'],about:['#about','#about-us','[data-section-id="about"]','[data-section="about"]'],contact:['#contact',
'#contact-us','[data-section-id="contact"]','[data-section="contact"]'],search:['#home'],'service-details':['#service-details','#serviceDetail','#serviceDetails','.service-details','.service-detail',
'[data-page="service-details"]'],checkout:['#checkout','[data-section-id="checkout"]','[data-page="checkout"]']
};
function normalizeSectionId(sectionId){
  const raw=(sectionId||'home').toString().replace(/^#/,'').trim();
  return sectionAliases[raw]||raw||'home';
} function getSectionEl(sectionId){
  const normalized=normalizeSectionId(sectionId),list=sectionSelectors[normalized]||['#'+normalized];
  for(const selector of list){
    const el=document.querySelector(selector);
    if(el)return el;
  }return null;
} function routeSectionFromPath(){
  const path=(window.location.pathname||'').toLowerCase();
  if(/checkout|payment|confirmation|e-receipt/.test(path))return 'checkout';
  if(/cart/.test(path))return 'cart';
  if(/search/.test(path))return 'search';
  if(/service-detail|service_details|details|detail-info/.test(path))return 'service-details';
  if(/service|product/.test(path))return 'products';
  if(/about/.test(path))return 'about';
  if(/contact|quote|inquiry/.test(path))return 'contact';
  return 'home';
} function sectionFromLocation(){
  const hash=normalizeSectionId(window.location.hash||'');
  return hash&&hash!=='home'?hash:routeSectionFromPath();
} function navSectionFor(sectionId){
  const normalized=normalizeSectionId(sectionId);
  if(normalized==='service-details')return 'products';
  if(['checkout','cart','payment','confirmation'].includes(normalized))return '';
  return normalized;
} function updateHeaderTheme(sectionId){
  const header=document.getElementById('mainHeader');
  if(header)header.classList.toggle('header-dark',darkHeaderSections.has(normalizeSectionId(sectionId)));
} function setActiveNav(sectionId){
  const normalized=normalizeSectionId(sectionId),navTarget=navSectionFor(normalized);
  document.querySelectorAll('.nav-link').forEach(link=>link.classList.toggle('active',!!navTarget&&link.dataset.section===navTarget));
  updateHeaderTheme(normalized);
} function sectionPath(sectionId){
  const normalized=normalizeSectionId(sectionId);
  return ({
    home:'/home',products:'/services',about:'/aboutus',contact:'/contactus','service-details':'/service-details',cart:'/cart',search:'/search',checkout:'/checkout'
  }[normalized])||('/'+normalized);
} function updateBrowserUrl(sectionId,replaceUrl=false){
  const normalized=normalizeSectionId(sectionId);
  if(!normalized||['payment','confirmation'].includes(normalized))return;
  const nextPath=sectionPath(normalized);
  if(window.location.pathname===nextPath&&!window.location.hash)return;
  const nextUrl=new URL(window.location.href);
  nextUrl.pathname=nextPath;
  nextUrl.hash='';
  (replaceUrl?window.history.replaceState:window.history.pushState).call(window.history,{
    sectionId:normalized
  },'',nextUrl);
} function setStandalonePage(sectionId){
  const normalized=normalizeSectionId(sectionId);
  const checkout=getSectionEl('checkout'),detail=getSectionEl('service-details');
  document.body.classList.toggle('checkout-open',normalized==='checkout');
  document.body.classList.toggle('service-detail-open',normalized==='service-details');
  if(checkout)checkout.classList.toggle('active',normalized==='checkout');
  if(detail)detail.classList.toggle('pdv-is-open',normalized==='service-details');
  if(normalized!=='checkout'&&checkout)checkout.classList.remove('active');
  if(normalized!=='service-details'&&detail)detail.classList.remove('pdv-is-open');
} function jumpTo(sectionId,options={
}){
  const normalized=normalizeSectionId(sectionId);
  setStandalonePage(normalized);
  const target=getSectionEl(normalized);
  autoScrollTarget=normalized;
  isAutoScrolling=true;
  setActiveNav(normalized);
  if(target)window.scrollTo({
    top:Math.max(0,target.getBoundingClientRect().top+window.scrollY-70),behavior:options.instant?'auto':'smooth'
  });
  if(options.updateUrl!==false)updateBrowserUrl(normalized,!!options.replaceUrl);
  if(normalized==='checkout')document.dispatchEvent(new CustomEvent('printify:checkout-opened',{
    detail:{
      source:'jumpTo'
    }
  }));
  clearTimeout(window.__pfyScrollEnd);
  window.__pfyScrollEnd=setTimeout(()=>{
    isAutoScrolling=false;
    syncScrollSpy(true);
  },options.instant?120:760);
} function getVisibleMainSection(){
  const marker=window.scrollY+74+(window.innerHeight*.26);
  let current='home';
  ['home','products','about','contact'].forEach(id=>{
    const el=getSectionEl(id);
    if(!el||el.offsetParent===null)return;
    const top=el.getBoundingClientRect().top+window.scrollY;
    if(marker>=top)current=id;
  });
  return current;
} function syncScrollSpy(forceUrl=false){
  if(document.body.classList.contains('service-detail-open')){
    setActiveNav('service-details');
    if(forceUrl)updateBrowserUrl('service-details',true);
    return;
  }if(document.body.classList.contains('checkout-open')){
    setActiveNav('checkout');
    if(forceUrl)updateBrowserUrl('checkout',true);
    return;
  }if(isAutoScrolling){
    setActiveNav(autoScrollTarget);
    return;
  }const detail=getSectionEl('service-details');
  if(detail&&detail.classList.contains('active')){
    setActiveNav('service-details');
    if(forceUrl)updateBrowserUrl('service-details',true);
    return;
  }const section=getVisibleMainSection();
  setActiveNav(section);
  if(window.location.pathname==='/search')return;
  if(forceUrl||window.location.pathname!==sectionPath(section)||window.location.hash)updateBrowserUrl(section,true);
} function setupScrollSpy(){
  window.addEventListener('scroll',()=>{
    if(scrollSpyTick)return;
    scrollSpyTick=requestAnimationFrame(()=>{
      scrollSpyTick=null;
      syncScrollSpy(false);
    });
  },{
    passive:true
  });
  window.addEventListener('resize',()=>syncScrollSpy(true));
  syncScrollSpy(true);
} function syncSectionFromHash(replaceUrl=true){
  const section=sectionFromLocation()||initialRouteSection;
  jumpTo(section,{
    instant:true,replaceUrl:replaceUrl,updateUrl:false
  });
} function setupHeaderObserver(){
  let tick=null;
  const observer=new MutationObserver(()=>{
    clearTimeout(tick);
    tick=setTimeout(()=>syncScrollSpy(true),35);
  });
  observer.observe(document.body,{
    subtree:true,attributes:true,attributeFilter:['class']
  });
} function setupArtisanNavScroll(){
  const shouldUsePageNavigation=()=>standaloneRouteSections.has(initialRouteSection)||document.body.classList.contains('front-route-service-details')||document.body.classList.contains('front-route-checkout')||document.body.classList.contains('checkout-open')||document.body.classList.contains('service-detail-open');
  document.querySelectorAll('.nav-link[data-section]').forEach(link=>{
    link.addEventListener('click',event=>{
      const target=normalizeSectionId(link.dataset.section);
      if(!['home','products','about','contact'].includes(target))return;
      if(shouldUsePageNavigation()&&link.href){
        event.preventDefault();
        window.location.href=link.href;
        return;
      }
      event.preventDefault();
      document.body.classList.remove('checkout-open','service-detail-open');
      jumpTo(target,{
        updateUrl:true
      });
    });
  });
  document.addEventListener('click',event=>{
    const link=event.target.closest('a[href]');
    if(!link||link.target||link.hasAttribute('download'))return;
    if(shouldUsePageNavigation())return;
    const href=link.getAttribute('href')||'';
    const localMap={
      '/home':'home','/':'home','/services':'products','/products':'products','/about':'about','/aboutus':'about','/contact':'contact','/contactus':'contact'
    };
    let url;
    try{
      url=new URL(href,window.location.origin);
    }catch(e){
      return;
    } if(url.origin!==window.location.origin)return;
    const target=localMap[url.pathname.replace(/\/$/,'')||'/'];
    if(!target)return;
    event.preventDefault();
    document.body.classList.remove('checkout-open','service-detail-open');
    jumpTo(target,{
      updateUrl:true
    });
  });
} function jumpToHero(index){
  const slides=document.querySelectorAll('.hero-slide'),dots=document.querySelectorAll('.home-premium-dots .dot');
  if(!slides.length)return;
  currentHeroIndex=(index+slides.length)%slides.length;
  slides.forEach((slide,i)=>slide.classList.toggle('active',i===currentHeroIndex));
  dots.forEach((dot,i)=>dot.classList.toggle('active',i===currentHeroIndex));
} function startHeroSlider(){
  clearInterval(heroTimer);
  heroTimer=setInterval(()=>{
    if(!document.hidden)jumpToHero(currentHeroIndex+1);
  },6800);
} function toggleWishlist(){
  const heart=document.getElementById('navHeart');
  if(heart){
    heart.classList.remove('is-active');
    heart.classList.add('nav-click-pulse');
    setTimeout(()=>heart.classList.remove('nav-click-pulse'),180);
    heart.setAttribute('aria-pressed','false');
    heart.title='Wishlist';
  } document.dispatchEvent(new CustomEvent('printify:wishlist-toggled',{
    detail:{
      active:false,source:'home-header'
    }
  }));
  syncScrollSpy(true);
  return false;
} function restoreWishlistState(){
  localStorage.removeItem('printifyHomeWishlist');
  const heart=document.getElementById('navHeart');
  if(heart){
    heart.classList.remove('is-active','nav-click-pulse');
    heart.setAttribute('aria-pressed','false');
    heart.title='Wishlist';
  }
} function requireSignedInForOrder(intendedPath='/checkout'){
  if(isSignedIn)return true;
  const safePath=['/cart','/checkout','/payment/checkout'].includes(intendedPath)?intendedPath:'/checkout';
  sessionStorage.setItem('printifyIntendedUrl',safePath);
  const loginTarget=new URL(loginUrl,window.location.origin);
  loginTarget.searchParams.set('intended',safePath);
  window.location.href=loginTarget.toString();
  return false;
} function animateHeroTitle(){
  const title=document.getElementById('kineticHeroTitle');
  if(!title||title.dataset.animated==='true')return;
  let delay=0;
  title.querySelectorAll('.title-line').forEach(line=>{
    const text=line.textContent;
    line.textContent='';
    text.split('').forEach(char=>{
      const letter=document.createElement('span');
      letter.className=char===' '?'letter space':'letter';
      letter.textContent=char===' '?'\u00A0':char;
      letter.style.animationDelay=delay+'ms';
      line.appendChild(letter);
      delay+=10;
    });
    delay+=45;
  });
  title.dataset.animated='true';
} function setupSearch(){
  const input=document.getElementById('navSearchInput'),button=document.getElementById('navSearchBtn');
  const runSearch=()=>{
    const term=(input.value||'').toLowerCase().trim();
    if(!term){
      if(input)input.focus();
      return;
    } let target='products';
    if(term.includes('home'))target='home';
    else if(term.includes('about'))target='about';
    else if(term.includes('contact')||term.includes('quote')||term.includes('inquiry'))target='contact';
    else if(term.includes('service')||term.includes('print')||term.includes('product')||term.includes('premium')||term.includes('document')||term.includes('large format'))target='products';
    updateBrowserUrl('search');
    showFrontFeedback(`Search result opened for "${term}".`);
    jumpTo(target,{
      updateUrl:false
    });
    document.dispatchEvent(new CustomEvent('printify:search-submitted',{
      detail:{
        term:term,source:'home-header'
      }
    }));
  };
  if(button)button.addEventListener('click',runSearch);
  if(input)input.addEventListener('keydown',event=>{
    if(event.key==='Enter')runSearch();
  });
} function showFrontFeedback(message){
  const toast=document.getElementById('frontFeedbackToast');
  if(!toast)return;
  toast.textContent=message||'Action completed.';
  toast.classList.add('show');
  clearTimeout(window.__frontFeedbackTimer);
  window.__frontFeedbackTimer=setTimeout(()=>toast.classList.remove('show'),2600);
} window.showFrontFeedback=showFrontFeedback;
window.addEventListener('printify-front-feedback',event=>showFrontFeedback(event.detail&&event.detail.message));
function parsePesoAmount(text){
  const value=String(text||'').replace(/,/g,'').match(/(?:₱|P)?\s*([0-9]+(?:\.[0-9]+)?)/i);
  return value?Number(value[1]):0;
} function visibleText(selector,root=document){
  const el=root.querySelector(selector);
  return el?(el.textContent||'').trim():'';
} function ensureCheckoutStorageFromVisibleOrder(){
  try{
    const hasActive=localStorage.getItem('printifyActiveCheckout');
    const hasItems=localStorage.getItem('printifyCheckoutItems');
    if(hasActive||hasItems)return;
    const root=getSectionEl('service-details')||document;
    const summary=root.querySelector('.order-summary,.summary-card,.service-summary,.checkout-summary,[data-order-summary]')||root;
    const name=visibleText('[data-checkout-name],.summary-title,.order-title,.service-title,h1,h2,h3',summary)||'Printing Service';
    const fileName=visibleText('[data-file-name],.file-name,.uploaded-file-name,.upload-file-name',summary).replace(/^file:\s*/i,'');
    const qtyText=visibleText('[data-qty],.quantity,.qty',summary);
    const totalText=visibleText('[data-total],.total-amount,.grand-total,.total,.retail-price,.price',summary)||summary.textContent;
    const qty=parseInt((qtyText.match(/\d+/)||['1'])[0],10)||1;
    const total=parsePesoAmount(totalText)||0;
    const item={
      id:'checkout-'+Date.now(),name:name,qty:qty,quantity:qty,price:total&&qty?Number((total/qty).toFixed(2)):0,lineTotal:total,total:total,category:visibleText('[data-category],.printing-category',summary),
paperSize:visibleText('[data-paper-size],.paper-size',summary),colorVariation:visibleText('[data-color],.color-variation',summary),serviceOption:visibleText('[data-service-option],.service-option',summary),
fileName:fileName
    };
    localStorage.setItem('printifyActiveCheckout',JSON.stringify(item));
    localStorage.setItem('printifyCheckoutItems',JSON.stringify([item]));
    localStorage.setItem('printifyCheckoutSource','service-details');
  }catch(error){
    console.warn('Checkout storage fallback skipped:',error);
  }
} window.openCheckoutSection=function(item){
  if(!requireSignedInForOrder())return false;
  if(item&&typeof item==='object'){
    localStorage.setItem('printifyActiveCheckout',JSON.stringify(item));
    localStorage.setItem('printifyCheckoutItems',JSON.stringify([item]));
    localStorage.setItem('printifyCheckoutSource','direct');
  } else ensureCheckoutStorageFromVisibleOrder();
  if(initialRouteSection!=='checkout'||!getSectionEl('checkout')){
    window.location.assign('/checkout');
    return false;
  }
  if(window.location.pathname!=='/checkout'){
    window.location.href='/checkout';
    return false;
  } jumpTo('checkout',{
    updateUrl:true
  });
  document.dispatchEvent(new CustomEvent('printify:checkout-opened',{
    detail:{
      source:'openCheckoutSection'
    }
  }));
  return false;
};
window.goToCheckoutNow=window.openCheckoutSection;
document.addEventListener('click',event=>{
  const trigger=event.target.closest('[data-open-checkout],[data-checkout],a[href="#checkout"],button,a');
  if(!trigger)return;
  const href=(trigger.getAttribute('href')||'').trim().toLowerCase();
  const text=(trigger.textContent||'').replace(/\s+/g,' ').trim().toLowerCase();
  const opensCheckout=href==='#checkout'||trigger.hasAttribute('data-open-checkout')||trigger.hasAttribute('data-checkout')||text==='checkout now'||text==='proceed to checkout'||text.includes('checkout now');
  if(!opensCheckout)return;
  event.preventDefault();
  window.openCheckoutSection();
});
document.addEventListener('DOMContentLoaded',()=>{
  if(initialRouteSection!=='service-details'){
    document.body.classList.remove('service-detail-open');
    document.getElementById('serviceDetail')?.classList.remove('pdv-is-open');
  }
  if(initialRouteSection!=='checkout'){
    document.body.classList.remove('checkout-open');
    document.getElementById('checkout')?.classList.remove('active');
  }
  requestAnimationFrame(animateHeroTitle);
  startHeroSlider();
  setupSearch();
  if(typeof window.updateCartBadge==='function')window.updateCartBadge();
  if(typeof window.renderPrintifyCart==='function'&&!window.__pfyCartInitialRenderComplete)window.renderPrintifyCart();
  restoreWishlistState();
  syncSectionFromHash(true);
  setupScrollSpy();
  setActiveNav(initialRouteSection);
  requestAnimationFrame(()=>{
    if(initialRouteSection==='home')window.scrollTo({
      top:0,left:0,behavior:'auto'
    });
    else jumpTo(initialRouteSection,{
      instant:true,updateUrl:false
    });
  });
  setupHeaderObserver();
  setupArtisanNavScroll();
  window.addEventListener('popstate',()=>syncSectionFromHash(true));
  window.addEventListener('hashchange',()=>syncSectionFromHash(true));
  if(typeof window.openModal!=='function'){
    window.openModal=function(){
      jumpTo('products');
    };
  }
});
</script>
<style id="front-0615-font-consistency-final">
@font-face {
  font-family:'FrontLeague0615';
  src:url('/Fonts/LeagueSpartan-SemiBold.otf') format('opentype');
  font-weight:600;
  font-style:normal;
  font-display:swap
}
@font-face {
  font-family:'FrontInter0615';
  src:url('/Fonts/Inter.ttc') format('truetype-collection'),url('/Fonts/Inter.ttc') format('truetype');
  font-weight:400 800;
  font-style:normal;
  font-display:swap
}
@font-face {
  font-family:'FrontBoxing0615';
  src:url('/Fonts/Boxing-Regular.otf') format('opentype');
  font-weight:400;
  font-style:normal;
  font-display:swap
}
#pageWrapper:where(p,span,a,li,small,td,th,input,textarea,select,option,button,label),#serviceDetail:where(p,span,a,li,small,td,th,input,textarea,select,option,button,label),#checkout:where(p,span,a,li,small,td,th,input,textarea,select,option,button,label),.printify-footer:where(p,span,a,li,small,td,th,input,textarea,select,option,button,label),.footer-policy-popover:where(p,span,a,li,small,td,th,input,textarea,select,option,button,label) {
  font-family:'FrontInter0615','Inter',system-ui,sans-serif!important;
  letter-spacing:0!important
}
#pageWrapper:where(h1,h2,h3,h4,h5,h6,strong,b,.home-premium-kicker,.section-title,.section-subtitle,.pfsvc-head span,.pfsvc-head h2,.pfsvc-side h3,.pfsvc-card-title,.pfsvc-card-subtitle,.about-title,.about-subtitle,.contact-head>span,.contact-head h2,.card-title h3,.touch-box>h3,.branch-card>h3,.quick-answer-card>h3),#serviceDetail:where(h1,h2,h3,h4,h5,h6,strong,b,.pdv-title,.pdv-card-title,.pdv-section-title,.service-title,.summary-title),#checkout:where(h1,h2,h3,h4,h5,h6,strong,b,.pfy-title,.pfy-card-title,.pfy-section-title,.checkout-title),.printify-footer:where(h1,h2,h3,h4,h5,h6,strong,b,.footer-col h3),.footer-policy-popover:where(h1,h2,h3,h4,h5,h6,strong,b,.footer-policy-head strong) {
  font-family:'FrontLeague0615','League Spartan',system-ui,sans-serif!important;
  letter-spacing:0!important
}
.brand-main-text,.printify-logo,.printify-brand,.printify-wordmark,.printify-footer .footer-bottom span {
  font-family:'FrontBoxing0615','Boxing',serif!important;
  font-weight:400!important
}
#pageWrapper i,#serviceDetail i,#checkout i,.printify-footer i,.footer-policy-popover i {
  font-family:"Font Awesome 6 Free","Font Awesome 6 Brands"!important
}
</style>
</body>
</html>
