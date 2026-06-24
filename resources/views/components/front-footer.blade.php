<footer class="printify-footer">
<div class="footer-top-line">
</div>
<div class="footer-policy-backdrop" id="footerPolicyBackdrop" onclick="footerClosePolicy()" hidden>
</div>
<section class="footer-policy-popover" id="footerPolicyPopover" aria-live="polite" hidden>
<div class="footer-policy-handle" aria-hidden="true">
</div>
<button type="button" class="footer-policy-close" onclick="footerClosePolicy()" aria-label="Close customer care details">
<i class="fa-solid fa-xmark">
</i>
</button>
<div class="footer-policy-head">
<span class="footer-policy-icon">
<i class="fa-solid fa-headset">
</i>
</span>
<div>
<strong>CUSTOMER CARE</strong>
<p>Important information to help you understand our policies and terms.</p>
</div>
</div>
<div class="footer-policy-content">
<div class="footer-policy-primary">
<h2 id="footerPolicyTitle">Customer Care</h2>
<div id="footerPolicyIntro">
</div>
</div>
<div class="footer-policy-details" id="footerPolicyDetails">
</div>
</div>
<div class="footer-policy-actions" aria-label="Customer care actions">
<button type="button" class="footer-policy-got-it" onclick="footerAcknowledgePolicy()">Got it</button>
</div>
</section>
<div class="footer-main">
<div class="footer-col footer-brand">
<div class="footer-brand-lockup">
<div class="footer-logo-image" role="img" aria-label="Printify and Co. logo">
<img src="{{ asset('images/printify-footer-logo.png') }}" alt="Printify and Co. logo">
</div>
<p>Crafting your vision into reality with high-quality printing and design solutions.</p>
</div>
</div>
<div class="footer-col footer-policy">
<h3>CUSTOMER CARE</h3>
<span class="footer-title-line">
</span>
<div class="footer-links policy-grid">
<button type="button" class="footer-link-button" data-policy="privacy" onclick="footerCareAction('privacy', this)">
<i class="fa-solid fa-chevron-right">
</i> Privacy Policy</button>
<button type="button" class="footer-link-button" data-policy="terms" onclick="footerCareAction('terms', this)">
<i class="fa-solid fa-chevron-right">
</i> Terms &amp; Conditions</button>
<button type="button" class="footer-link-button" data-policy="refund" onclick="footerCareAction('refund', this)">
<i class="fa-solid fa-chevron-right">
</i> Refund Policy</button>
<button type="button" class="footer-link-button" data-policy="faq" onclick="footerCareAction('faq', this)">
<i class="fa-solid fa-chevron-right">
</i> FAQ</button>
</div>
</div>
<div class="footer-col footer-follow">
<h3>FOLLOW US</h3>
<span class="footer-title-line">
</span>
<div class="footer-socials">
<a href="https://facebook.com" target="_blank" rel="noopener" class="facebook" aria-label="Facebook">
<i class="fa-brands fa-facebook-f">
</i>
</a>
<a href="https://www.instagram.com/co.printify?igsh=bzBhaTJzdzc1MnQ5" target="_blank" rel="noopener" class="instagram" aria-label="Instagram">
<i class="fa-brands fa-instagram">
</i>
</a>
<a href="https://www.tiktok.com/@printifyco.ph?_r=1&_t=ZS-97SktvYyskv" target="_blank" rel="noopener" class="tiktok" aria-label="TikTok">
<i class="fa-brands fa-tiktok">
</i>
</a>
</div>
</div>
<div class="footer-col footer-map">
<h3>GET DIRECTIONS</h3>
<span class="footer-title-line">
</span>
<p class="footer-map-copy">Find directions to us and save our map.</p>
<div class="footer-map-frame" role="button" tabindex="0" onclick="footerOpenMap()" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();footerOpenMap();}">
<iframe title="Printify & Co. footer map" src="https://www.google.com/maps?q=Makati%20City%20Metro%20Manila%20Philippines&output=embed" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade">
</iframe>
</div>
</div>
</div>
<div class="footer-bottom">
<p>&copy; 2025 <span>Printify &amp; Co.</span> All rights reserved.</p>
<nav class="footer-legal-links" aria-label="Footer legal links">
<a href="{{ route('legal.privacy') }}">Privacy Policy</a>
<a href="{{ route('legal.terms') }}">Terms of Service</a>
<a href="{{ route('support') }}">Contact / Support</a>
</nav>
</div>
</footer>
<style id="front-footer-component-style">
.printify-footer {
  display:grid!important;
  grid-template-rows:5px auto 42px!important;
  width:100%!important;
  margin:0!important;
  padding:0!important;
  background:#050505!important;
  color:#ffffff!important;
  overflow:hidden!important;
  box-shadow:none!important
}
.printify-footer .footer-top-line {
  height:5px!important;
  background:#ff7900!important
}
.printify-footer .footer-main {
  height:auto!important;
  min-height:178px!important;
  padding:18px 34px 12px!important;
  display:grid!important;
  grid-template-columns:1.22fr .92fr .72fr 1.28fr!important;
  gap:0!important;
  align-items:start!important;
  background:#050505!important
}
.printify-footer .footer-col {
  height:auto!important;
  min-height:132px!important;
  padding:0 0 0 38px!important;
  border-left:1px solid rgba(255,255,255,.18)!important
}
.printify-footer .footer-brand {
  padding-left:0!important;
  border-left:0!important
}
.printify-footer .footer-policy,.printify-footer .footer-follow,.printify-footer .footer-map {
  padding-left:38px!important
}
.printify-footer .footer-brand-lockup {
  display:flex!important;
  align-items:center!important;
  gap:14px!important;
  max-width:345px!important
}
.printify-footer .footer-logo-image {
  width:64px!important;
  height:64px!important;
  min-width:64px!important;
  border-radius:50%!important;
  overflow:hidden!important;
  display:grid!important;
  place-items:center!important;
  background:#050505!important;
  border:2px solid rgba(255,121,0,.95)!important;
  box-shadow:0 0 0 3px rgba(255,255,255,.08)!important
}
.printify-footer .footer-logo-image svg {
  width:100%!important;
  height:100%!important;
  display:block!important
}
.printify-footer .footer-brand p {
  margin:0!important;
  color:#f5f5f5!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:12px!important;
  font-weight:600!important;
  line-height:1.45!important;
  letter-spacing:0!important
}
.printify-footer .footer-col h3 {
  margin:0!important;
  color:#fff!important;
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-size:12px!important;
  line-height:1!important;
  font-weight:800!important;
  letter-spacing:1.2px!important;
  text-transform:uppercase!important
}
.printify-footer .footer-title-line {
  display:block!important;
  width:33px!important;
  height:2px!important;
  margin:8px 0 12px!important;
  border-radius:20px!important;
  background:#ff7900!important;
  box-shadow:none!important
}
.printify-footer .policy-grid {
  display:flex!important;
  flex-direction:column!important;
  gap:7px!important;
  align-items:flex-start!important
}
.printify-footer .footer-link-button {
  appearance:none!important;
  border:0!important;
  padding:0!important;
  margin:0!important;
  background:transparent!important;
  color:#f4f4f4!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:11px!important;
  font-weight:600!important;
  line-height:1.22!important;
  text-align:left!important;
  display:inline-flex!important;
  align-items:center!important;
  gap:7px!important;
  cursor:pointer!important;
  transition:color .16s ease!important
}
.printify-footer .footer-link-button i {
  width:8px!important;
  color:#ff7900!important;
  font-size:8px!important
}
.printify-footer .footer-link-button:hover,.printify-footer .footer-link-button:focus {
  color:#ff7900!important;
  outline:0!important
}
.printify-footer .footer-follow .footer-title-line {
  margin-bottom:14px!important
}
.printify-footer .footer-socials {
  display:flex!important;
  gap:12px!important;
  align-items:center!important;
  justify-content:flex-start!important
}
.printify-footer .footer-socials a {
  width:36px!important;
  height:36px!important;
  border-radius:50%!important;
  display:grid!important;
  place-items:center!important;
  color:#fff!important;
  text-decoration:none!important;
  font-size:16px!important;
  line-height:1!important;
  box-shadow:none!important;
  transform:none!important
}
.printify-footer .footer-socials a:hover,.printify-footer .footer-socials a:focus {
  transform:translateY(-1px)!important;
  outline:0!important
}
.printify-footer .footer-socials .facebook {
  background:#1877f2!important
}
.printify-footer .footer-socials .instagram {
  background:#e4405f!important
}
.printify-footer .footer-socials .tiktok {
  background:#111111!important;
  border:1px solid rgba(255,255,255,.35)!important
}
.printify-footer .footer-map {
  min-width:0!important
}
.printify-footer .footer-map-copy {
  margin:0 0 7px!important;
  max-width:310px!important;
  color:#f5f5f5!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:11px!important;
  font-weight:600!important;
  line-height:1.35!important
}
.printify-footer .footer-map-frame {
  width:310px!important;
  max-width:100%!important;
  height:92px!important;
  border:0!important;
  border-radius:5px!important;
  overflow:hidden!important;
  background:#111!important
}
.printify-footer .footer-map-frame iframe {
  width:100%!important;
  height:100%!important;
  border:0!important;
  display:block!important
}
.printify-footer .footer-bottom {
  height:42px!important;
  min-height:42px!important;
  padding:0 34px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  gap:18px!important;
  border-top:1px solid rgba(255,255,255,.12)!important;
  background:#050505!important;
  text-align:center!important
}
.printify-footer .footer-bottom p {
  margin:0!important;
  color:#f4f4f4!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:11px!important;
  font-weight:600!important;
  line-height:1!important
}
.printify-footer .footer-bottom span {
  color:#ff7900!important
}
.printify-footer .footer-legal-links {
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  flex-wrap:wrap!important;
  gap:14px!important;
  margin:0!important
}
.printify-footer .footer-legal-links a {
  color:#f4f4f4!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:11px!important;
  font-weight:600!important;
  line-height:1!important;
  text-decoration:none!important;
  transition:color .16s ease!important
}
.printify-footer .footer-legal-links a:hover,.printify-footer .footer-legal-links a:focus {
  color:#ff7900!important;
  outline:0!important
}
@media(max-width:1180px) {
  .printify-footer {
    grid-template-rows:5px auto auto!important;
    overflow:visible!important
  }
  .printify-footer .footer-main {
    grid-template-columns:1fr 1fr!important;
    padding:22px 28px 20px!important;
    gap:26px 0!important
  }
  .printify-footer .footer-col {
    min-height:auto!important
  }
  .printify-footer .footer-map-frame {
    width:100%!important;
    height:130px!important
  }
}
@media(max-width:760px) {
  .printify-footer .footer-bottom {
    flex-direction:column!important;
    gap:9px!important
  }
  .printify-footer .footer-main {
    grid-template-columns:1fr!important;
    padding:24px 22px 18px!important;
    gap:20px!important
  }
  .printify-footer .footer-col,.printify-footer .footer-policy,.printify-footer .footer-follow,.printify-footer .footer-map {
    padding-left:0!important;
    border-left:0!important
  }
  .printify-footer .footer-col {
    padding-bottom:18px!important;
    border-bottom:1px solid rgba(255,255,255,.13)!important
  }
  .printify-footer .footer-map {
    border-bottom:0!important
  }
  .printify-footer .footer-brand-lockup {
    align-items:flex-start!important
  }
  .printify-footer .footer-bottom {
    height:auto!important;
    min-height:40px!important;
    padding:12px 22px!important
  }
  .printify-footer .footer-bottom {
    flex-direction:column!important;
    gap:9px!important
  }
}
</style>
<style id="front-footer-policy-popup-style">
.printify-footer {
  position:relative!important;
  overflow:visible!important;
  z-index:40!important
}
.printify-footer .footer-link-button {
  position:relative!important;
  padding-bottom:3px!important
}
.printify-footer .footer-link-button::after {
  content:""!important;
  position:absolute!important;
  left:16px!important;
  right:auto!important;
  bottom:0!important;
  width:0!important;
  height:2px!important;
  border-radius:999px!important;
  background:#ff7900!important;
  transition:width .18s ease!important
}
.printify-footer .footer-link-button:hover::after,.printify-footer .footer-link-button:focus::after,.printify-footer .footer-link-button.active::after {
  width:calc(100% - 16px)!important
}
.footer-policy-backdrop {
  position:fixed!important;
  inset:0!important;
  z-index:100!important;
  background:rgba(15,23,42,.28)!important;
  backdrop-filter:blur(4px)!important;
  -webkit-backdrop-filter:blur(4px)!important
}
.footer-policy-backdrop[hidden] {
  display:none!important
}
.footer-policy-popover {
  position:absolute!important;
  left:44px!important;
  right:44px!important;
  bottom:100%!important;
  z-index:120!important;
  height:min(72vh,560px)!important;
  max-height:calc(100vh - 150px)!important;
  overflow-y:auto!important;
  overflow-x:hidden!important;
  padding:34px 48px 38px!important;
  border-radius:18px 18px 0 0!important;
  background:#ffffff!important;
  color:#111827!important;
  box-shadow:0 -18px 44px rgba(15,23,42,.16)!important;
  border:1px solid rgba(15,23,42,.08)!important;
  border-bottom:0!important
}
.footer-policy-popover[hidden] {
  display:none!important
}
.footer-policy-handle {
  position:absolute!important;
  top:18px!important;
  left:50%!important;
  transform:translateX(-50%)!important;
  width:70px!important;
  height:4px!important;
  border-radius:999px!important;
  background:#737373!important;
  opacity:.75!important
}
.footer-policy-close {
  position:absolute!important;
  top:30px!important;
  right:34px!important;
  width:34px!important;
  height:34px!important;
  border:0!important;
  background:transparent!important;
  color:#111827!important;
  display:grid!important;
  place-items:center!important;
  cursor:pointer!important;
  font-size:24px!important
}
.footer-policy-head {
  display:flex!important;
  align-items:center!important;
  gap:16px!important;
  margin:0 0 30px!important
}
.footer-policy-icon {
  width:46px!important;
  height:46px!important;
  border-radius:50%!important;
  display:grid!important;
  place-items:center!important;
  background:#fff1e8!important;
  color:#ff7900!important;
  font-size:23px!important
}
.footer-policy-head strong {
  display:block!important;
  margin-bottom:4px!important;
  color:#111827!important;
  font-size:14px!important;
  line-height:1!important;
  letter-spacing:.04em!important
}
.footer-policy-head p {
  margin:0!important;
  color:#4b5563!important;
  font-size:12px!important;
  line-height:1.35!important
}
.footer-policy-content {
  display:block!important;
  height:auto!important;
  min-height:0!important;
  align-items:start!important
}
.footer-policy-primary {
  padding-right:10px!important;
  border-right:0!important;
  overflow:visible!important
}
.footer-policy-primary h2 {
  margin:0 0 22px!important;
  color:#111827!important;
  font-size:34px!important;
  line-height:1!important
}
.footer-policy-primary p,.footer-policy-details p {
  margin:0 0 16px!important;
  color:#111827!important;
  font-size:13px!important;
  line-height:1.55!important;
  font-weight:400!important
}
.footer-policy-details {
  display:none!important
}
.footer-policy-details section {
  margin:0 0 24px!important
}
.footer-policy-details h3 {
  margin:22px 0 8px!important;
  color:#111827!important;
  font-size:15px!important;
  line-height:1.2!important;
  font-weight:800!important
}
.footer-policy-primary h3 {
  margin:22px 0 8px!important;
  color:#111827!important;
  font-size:17px!important;
  line-height:1.2!important;
  font-weight:800!important
}
.footer-policy-popover .policy-meta {
  margin:0 0 8px!important;
  color:#4b5563!important;
  font-size:12px!important;
  font-weight:600!important
}
.footer-policy-popover .policy-table-wrap {
  width:100%!important;
  overflow-x:auto!important;
  margin:12px 0 22px!important;
  border:1px solid #dfe3ea!important;
  border-radius:8px!important;
  background:#fff!important
}
.footer-policy-popover .policy-doc-table {
  width:100%!important;
  min-width:620px!important;
  border-collapse:collapse!important;
  color:#111827!important
}
.footer-policy-popover .policy-doc-table th,.footer-policy-popover .policy-doc-table td {
  border:1px solid #dfe3ea!important;
  padding:10px 12px!important;
  text-align:left!important;
  vertical-align:top!important;
  font-size:12px!important;
  line-height:1.45!important;
  font-weight:400!important
}
.footer-policy-popover .policy-doc-table th {
  background:#fff4ec!important;
  color:#111827!important;
  font-weight:800!important
}
.footer-policy-popover .policy-doc-table tr:nth-child(even) td {
  background:#fafafa!important
}
.footer-policy-popover h3 {
  break-after:avoid!important
}
.footer-policy-popover p {
  break-inside:avoid!important
}
.footer-policy-popover::-webkit-scrollbar {
  width:10px!important
}
.footer-policy-popover::-webkit-scrollbar-track {
  background:#f1f3f6!important;
  border-radius:999px!important
}
.footer-policy-popover::-webkit-scrollbar-thumb {
  background:#9ca3af!important;
  border-radius:999px!important;
  border:2px solid #f1f3f6!important
}
@media(max-width:900px) {
  .footer-policy-popover {
    left:18px!important;
    right:18px!important;
    padding:32px 24px 30px!important;
    max-height:78vh!important
  }
  .footer-policy-content {
    grid-template-columns:1fr!important;
    gap:20px!important
  }
  .footer-policy-primary {
    padding-right:0!important;
    border-right:0!important
  }
}
</style>
<style id="front-footer-final-adjustments-0615">
.printify-footer {
  grid-template-rows:5px auto 34px!important
}
.printify-footer .footer-main {
  min-height:142px!important;
  padding:14px 34px 8px!important
}
.printify-footer .footer-col {
  min-height:112px!important;
  padding-left:34px!important
}
.printify-footer .footer-policy,
.printify-footer .footer-follow,
.printify-footer .footer-map {
  padding-left:34px!important
}
.printify-footer .footer-brand-lockup {
  gap:12px!important
}
.printify-footer .footer-logo-image {
  width:78px!important;
  height:78px!important;
  min-width:78px!important;
  border:0!important;
  box-shadow:none!important;
  background:transparent!important;
  overflow:visible!important
}
.printify-footer .footer-logo-image img {
  display:block!important;
  width:92px!important;
  height:92px!important;
  max-width:none!important;
  object-fit:contain!important;
  transform:translate(-7px,-7px)!important
}
.printify-footer .footer-col h3 {
  font-size:15px!important;
  line-height:1!important;
  letter-spacing:1.1px!important
}
.printify-footer .footer-title-line {
  width:38px!important;
  margin:9px 0 11px!important
}
.printify-footer .policy-grid {
  gap:6px!important
}
.printify-footer .footer-link-button {
  font-size:12px!important;
  line-height:1.18!important
}
.printify-footer .footer-socials {
  gap:14px!important
}
.printify-footer .footer-socials a {
  width:44px!important;
  height:44px!important;
  font-size:20px!important
}
.printify-footer .footer-map-copy {
  margin-bottom:8px!important;
  font-size:12px!important;
  line-height:1.25!important
}
.printify-footer .footer-map-frame {
  width:310px!important;
  height:80px!important
}
.printify-footer .footer-bottom {
  height:34px!important;
  min-height:34px!important
}
.footer-policy-backdrop {
  background:rgba(15,23,42,.38)!important;
  backdrop-filter:blur(2px)!important;
  -webkit-backdrop-filter:blur(2px)!important
}
.footer-policy-popover {
  position:fixed!important;
  left:50%!important;
  right:auto!important;
  top:50%!important;
  bottom:auto!important;
  width:min(1420px,calc(100vw - 96px))!important;
  height:min(82vh,720px)!important;
  max-height:calc(100vh - 96px)!important;
  transform:translate(-50%,-50%)!important;
  border-radius:16px!important;
  border:1px solid rgba(15,23,42,.1)!important;
  padding:34px 48px 42px!important;
  box-shadow:0 24px 70px rgba(15,23,42,.24)!important;
  z-index:130!important
}
.footer-policy-close {
  top:28px!important;
  right:32px!important
}
.footer-policy-content {
  display:block!important
}
.footer-policy-primary {
  max-width:100%!important
}
.footer-policy-primary h2 {
  margin-bottom:24px!important
}
.footer-policy-popover .policy-table-wrap {
  width:min(100%,980px)!important;
  margin:16px auto 24px!important
}
.footer-policy-popover .policy-doc-table {
  margin:0 auto!important;
  min-width:720px!important
}
.footer-policy-popover .policy-doc-table th,
.footer-policy-popover .policy-doc-table td {
  text-align:center!important;
  vertical-align:middle!important
}
@media(max-width:1180px) {
  .printify-footer .footer-main {
    padding:18px 28px 16px!important
  }
}
@media(max-width:760px) {
  .footer-policy-popover {
    width:calc(100vw - 32px)!important;
    height:min(84vh,720px)!important;
    padding:32px 22px 30px!important
  }
  .printify-footer .footer-logo-image {
    width:70px!important;
    height:70px!important;
    min-width:70px!important
  }
  .printify-footer .footer-logo-image img {
    width:82px!important;
    height:82px!important;
    transform:translate(-6px,-6px)!important
  }
}
</style>
<script id="front-footer-component-script">
window.footerFeedback=function(message){
  if(typeof window.showFrontFeedback==="function"){
    window.showFrontFeedback(message);
    return;
  } window.dispatchEvent(new CustomEvent("printify-front-feedback",{
    detail:{
      message
    }
  }));
};
const footerPolicyContent={
  "terms": {
    "title": "Terms and Conditions", "blocks": [ {
      "type": "p", "text": "Printify & Co. — Web-Based Multi Business Printing Platform"
    }, {
      "type": "p", "text": "Last Updated: June 14, 2026"
    }, {
      "type": "p", "text": "1. Introduction and Acceptance of Terms"
    }, {
      "type": "p",
"text": "These Terms and Conditions (\"Terms,\" \"Agreement\") constitute a legally binding agreement between you and Printify & Co. (\"Platform,\" \"we,\" \"us,\" \"our\"), governing your access to and use of the Printify Co platform — a web-based system that enables independent printing businesses to manage ordering, file uploads, payment processing, and delivery coordination for their respective customers."
    }, {
      "type": "p",
"text": "By registering an account, accessing the platform, placing an order, or using any of our services in any capacity, you confirm that you have read, understood, and agree to be bound by these Terms and our Privacy Policy. If you do not agree, please discontinue use immediately."
    }, {
      "type": "p",
"text": "By clicking \"I Agree,\" completing registration, or otherwise using the Platform, Admin Clients represent and warrant that they have the full legal authority to bind their business entity to this Agreement."
    }, {
      "type": "p", "text": "2. Definitions"
    }, {
      "type": "table", "rows": [ [ "Term", "Meaning" ], [ "Platform", "The Printify Co web-based application, including all features, modules, and services." ], [ "Tenant / Print Business",
 "An independent printing shop, company, or vendor registered on the Platform to conduct their printing business." ], [ "Admin Client (admin_client)",
 "A registered business owner or designated administrator of a Tenant who manages their business's operations, orders, payment methods, delivery options, and settings within the Platform." ], [ "Developer",
 "Platform-level technical personnel authorized by Printify Co to maintain, configure, and support the Platform infrastructure. Developer access is strictly internal and governed separately." ], [ "Customer",
 "An end-user who places print orders with a Tenant through the Platform." ], [ "User", "Any individual accessing the Platform in any role — Customer, Admin Client, or Developer." ], [ "Order",
 "A print job request submitted by a Customer to a Tenant through the Platform." ], [ "File / Artwork", "Digital files uploaded by a Customer or Admin Client for the purpose of printing." ], [ "Services",
 "All features offered through the Platform, including ordering, file uploads, online payment processing, delivery coordination, and tenant management tools." ], [ "Payment Gateway",
 "A third-party online payment service integrated with the Platform (e.g., PayMongo, Maya, or other applicable providers)." ], [ "Delivery Partner",
"A third-party logistics provider integrated with or referenced by the Platform for order fulfillment (e.g., Lalamove, J&T Express, or other applicable couriers)." ] ]
    }, {
      "type": "p", "text": "3. Platform Role and Scope"
    }, {
      "type": "p", "text": "3.1 Printify Co as Platform Operator"
    }, {
      "type": "p",
"text": "Printify Co provides the technology platform that enables Tenants to operate their printing businesses online. Printify Co is not a printing company and does not itself produce, sell, or deliver printed goods. All print products, pricing, turnaround times, payment methods, delivery options, and customer service are the sole responsibility of the respective Tenant."
    }, {
      "type": "p", "text": "3.2 Tenant Independence"
    }, {
      "type": "p",
"text": "Each Tenant operates as an independent business on the Platform. Tenants have full discretion to configure their own prices, product offerings, accepted payment methods, delivery options, and customer-facing policies. Printify Co does not control, endorse, or guarantee the quality, accuracy, or legality of products or services offered by any Tenant."
    }, {
      "type": "p", "text": "3.3 Platform Liability Limitation"
    }, {
      "type": "p",
"text": "Printify Co shall not be held liable for any dispute, claim, loss, or damage arising between a Customer and a Tenant, including but not limited to print quality, order fulfillment, delivery, payment disputes, or refund disagreements. Such matters are governed by the policies of the respective Tenant."
    }, {
      "type": "p", "text": "4. User Roles and Access"
    }, {
      "type": "p", "text": "4.1 Admin Client (admin_client)"
    }, {
      "type": "p", "text": "Admin Clients are authorized representatives of a Tenant. By registering as an Admin Client, you agree to:"
    }, {
      "type": "p", "text": "Provide accurate and truthful information about your business during registration."
    }, {
      "type": "p", "text": "Take full responsibility for all operations conducted under your Tenant account, including orders, customer communications, payments, file handling, and delivery arrangements."
    }, {
      "type": "p", "text": "Configure and manage your business's accepted payment methods, delivery options, and customer-facing policies within the permissions granted by the Platform."
    }, {
      "type": "p", "text": "Comply with all applicable Philippine laws and regulations in operating your printing business, including consumer protection, data privacy, and taxation laws."
    }, {
      "type": "p", "text": "Ensure that your customers are clearly informed of your policies regarding orders, payments, cancellations, and delivery prior to completing a transaction."
    }, {
      "type": "p", "text": "Keep your account credentials confidential and immediately report any unauthorized access to Printify Co."
    }, {
      "type": "p", "text": "Admin Clients may not share login credentials across multiple businesses or grant access to their Tenant account to unauthorized individuals."
    }, {
      "type": "p", "text": "4.2 Customer"
    }, {
      "type": "p", "text": "Customers are end-users who access the Platform to place orders with a registered Tenant. As a Customer, you agree to:"
    }, {
      "type": "p", "text": "Provide accurate personal information, delivery details, and payment information."
    }, {
      "type": "p", "text": "Upload only files and artwork for which you own all necessary rights and permissions."
    }, {
      "type": "p", "text": "Review your order details, artwork, and specifications carefully before submission and payment."
    }, {
      "type": "p", "text": "Comply with the payment and delivery policies configured by the Tenant with whom you are placing your order."
    }, {
      "type": "p", "text": "Use the Platform solely for lawful purposes."
    }, {
      "type": "p", "text": "4.3 Developer"
    }, {
      "type": "p",
"text": "Developer accounts are reserved exclusively for authorized Printify Co technical personnel. Developers hold elevated system-level access solely for the purpose of platform maintenance, configuration, and technical support. Developer access is strictly controlled, logged, and governed by internal Printify Co policies. Developers do not access Tenant or Customer data except as required for authorized technical support. No external party may request, assume, or be granted Developer-level access."
    }, {
      "type": "p", "text": "5. Tenant Registration and Onboarding"
    }, {
      "type": "p", "text": "To operate as a Tenant, a business must complete the registration process and provide accurate, complete, and verifiable business information as required by Printify Co."
    }, {
      "type": "p",
"text": "Printify Co reserves the right to approve, reject, suspend, or terminate any Tenant registration at its sole discretion, including for failure to provide accurate information or for violation of these Terms."
    }, {
      "type": "p", "text": "Each Tenant is responsible for ensuring that their business operations on the Platform comply with all applicable local, national, and industry regulations."
    }, {
      "type": "p", "text": "Tenants must not register multiple accounts for the same business entity without prior written approval from Printify Co."
    }, {
      "type": "p", "text": "6. Account Security"
    }, {
      "type": "p", "text": "All Users are responsible for maintaining the security and confidentiality of their login credentials."
    }, {
      "type": "p", "text": "You agree to immediately notify Printify Co of any suspected unauthorized access to your account."
    }, {
      "type": "p", "text": "Printify Co shall not be liable for any loss or damage resulting from unauthorized access caused by your failure to secure your credentials."
    }, {
      "type": "p", "text": "Accounts found to be compromised, inactive for an extended period, or used in violation of these Terms may be suspended or terminated at Printify Co's discretion."
    }, {
      "type": "p", "text": "7. File Uploads and Artwork"
    }, {
      "type": "p",
      "text": "Users who upload Files to the Platform represent and warrant that they own or hold all necessary rights, licenses, and permissions to reproduce the content contained therein."
    }, {
      "type": "p",
"text": "You agree not to upload content that is unlawful, obscene, defamatory, sexually explicit, violent, fraudulent, or that infringes the intellectual property or privacy rights of any third party. Printify Co reserves the right to report content involving child exploitation, hate speech, or other illicit material to the appropriate law enforcement agencies without prior notice to the User."
    }, {
      "type": "p", "text": "Printify Co does not pre-screen uploaded Files. Tenants are responsible for reviewing Customer-submitted Files for print-readiness before proceeding to production."
    }, {
      "type": "p",
"text": "Printify Co does not claim ownership of uploaded Files. Files are stored solely to facilitate the Services and may be deleted after order completion. Users are encouraged to retain their own copies."
    }, {
      "type": "p", "text": "Printify Co is not responsible for the loss, corruption, or unauthorized access to Files, except where directly caused by our gross negligence."
    }, {
      "type": "p", "text": "8. Orders and Payment"
    }, {
      "type": "p", "text": "8.1 Order Responsibility"
    }, {
      "type": "p",
"text": "All orders placed by Customers are transactions between the Customer and the relevant Tenant. Printify Co facilitates the ordering process through its platform but is not a party to the transaction and assumes no liability for the outcome of any order."
    }, {
      "type": "p", "text": "8.2 Online Payment Processing"
    }, {
      "type": "p",
"text": "The Platform integrates with third-party Payment Gateways — which may include PayMongo, Maya, and other providers — to enable online payments. The availability of specific payment methods on any Tenant's storefront is determined solely by the Admin Client for that Tenant."
    }, {
      "type": "p",
"text": "By completing a payment through a Payment Gateway, you also agree to that gateway's terms and conditions. Printify Co is not responsible for transaction errors, payment failures, processing delays, or disputes arising from or relating to third-party Payment Gateway services."
    }, {
      "type": "p", "text": "Printify Co does not store full payment card details. Payment data is handled directly by the applicable Payment Gateway in accordance with their security standards."
    }, {
      "type": "p", "text": "All transactions are processed in Philippine Peso (PHP) unless otherwise specified by the Tenant."
    }, {
      "type": "p", "text": "8.3 Cash on Delivery (COD)"
    }, {
      "type": "p",
"text": "Cash on Delivery may be offered as a payment option at the sole discretion of the Admin Client. Customers should check whether COD is available on the relevant Tenant's storefront before placing an order. Printify Co does not mandate, guarantee, or administer COD arrangements and assumes no liability for disputes arising from COD transactions."
    }, {
      "type": "p", "text": "8.4 Pricing"
    }, {
      "type": "p",
"text": "All pricing displayed on the Platform is set independently by each Tenant. Printify Co has no control over Tenant pricing and is not responsible for pricing errors or disputes between Customers and Tenants."
    }, {
      "type": "p", "text": "8.5 Payment Disputes"
    }, {
      "type": "p",
"text": "Payment disputes between a Customer and a Tenant must be resolved directly between the parties. Customers may also raise disputes with the applicable Payment Gateway in accordance with that provider's dispute resolution procedures. Printify Co is not a party to payment disputes and will not arbitrate or mediate such matters."
    }, {
      "type": "p", "text": "9. Cancellations and Refunds"
    }, {
      "type": "p",
"text": "Cancellation and refund policies are set independently by each Tenant. Customers should review the applicable Tenant's policies before placing an order. Printify Co does not process or mediate refund or cancellation requests between Customers and Tenants. In the event of a Tenant account suspension or termination, affected Customers should contact the Tenant directly for resolution."
    }, {
      "type": "p", "text": "10. Delivery and Fulfillment"
    }, {
      "type": "p", "text": "10.1 Delivery Options"
    }, {
      "type": "p",
"text": "The Platform supports integration with third-party Delivery Partners — which may include Lalamove, J&T Express, and other applicable couriers — as well as store pickup options. The delivery methods made available to Customers are configured entirely at the discretion of the Admin Client for each Tenant. Printify Co does not mandate any specific delivery method and makes no representations regarding the availability of any particular courier or pickup option on any Tenant's storefront."
    }, {
      "type": "p", "text": "10.2 Delivery Responsibility"
    }, {
      "type": "p",
"text": "Printify Co is not a logistics provider and assumes no responsibility for the physical delivery, handling, condition, or timeliness of any printed goods. Delivery obligations and any associated liability rest solely with the Tenant and/or the chosen Delivery Partner."
    }, {
      "type": "p", "text": "10.3 Delivery Partner Terms"
    }, {
      "type": "p",
"text": "By selecting a third-party Delivery Partner for their order, Customers and Tenants agree to be bound by the terms and conditions of that provider. Printify Co is not liable for delays, losses, damages, or disputes involving third-party couriers."
    }, {
      "type": "p", "text": "10.4 Customer Delivery Information"
    }, {
      "type": "p",
"text": "Customers must provide accurate and complete delivery information. Neither the Tenant nor Printify Co is liable for delays or losses resulting from incorrect, incomplete, or outdated delivery details provided by the Customer."
    }, {
      "type": "p", "text": "10.5 Store Pickup"
    }, {
      "type": "p",
"text": "Where a Tenant enables a store pickup option, the terms of pickup — including location, hours, and holding period — are determined by the Admin Client. Printify Co is not responsible for any issues arising from store pickup arrangements."
    }, {
      "type": "p", "text": "11. Dispute Resolution"
    }, {
      "type": "p",
"text": "In the event of a dispute between a Customer and a Tenant — including disputes relating to print quality, order fulfillment, payment, or delivery — the Customer agrees to contact the Tenant directly using the contact information available on the Tenant's storefront on the Platform. Printify Co is under no obligation to intervene, facilitate, or provide legal mediation for disputes between Customers and Tenants."
    }, {
      "type": "p", "text": "If a dispute cannot be resolved directly, the parties may pursue resolution through the appropriate courts or consumer protection bodies under applicable Philippine law."
    }, {
      "type": "p", "text": "12. Intellectual Property"
    }, {
      "type": "p", "text": "12.1 Platform IP"
    }, {
      "type": "p",
"text": "All content forming part of the Printify Co platform — including software, design, trademarks, logos, and documentation — is owned by or licensed to Printify Co and is protected by applicable Philippine intellectual property laws. No User may copy, reproduce, distribute, or create derivative works from any part of the Platform without prior written consent from Printify Co."
    }, {
      "type": "p", "text": "12.2 User Content"
    }, {
      "type": "p",
"text": "Users retain ownership of content and Files they upload to the Platform. By uploading, you grant Printify Co a limited, non-exclusive, royalty-free license to store, process, and transmit your content solely for the purpose of delivering the Services."
    }, {
      "type": "p", "text": "12.3 Tenant Branding"
    }, {
      "type": "p", "text": "Tenants may not use the Printify Co name, logo, or branding in any manner that implies endorsement, partnership, or affiliation beyond what is expressly permitted in writing by Printify Co."
    }, {
      "type": "p", "text": "13. Prohibited Conduct"
    }, {
      "type": "p", "text": "All Users agree not to:"
    }, {
      "type": "p", "text": "Use the Platform for any purpose that violates applicable laws or regulations;"
    }, {
      "type": "p", "text": "Upload, distribute, or facilitate reproduction of content that infringes third-party intellectual property, privacy, or other legal rights;"
    }, {
      "type": "p", "text": "Impersonate another person, business, or entity, or misrepresent your role or affiliation;"
    }, {
      "type": "p", "text": "Submit fraudulent, falsified, or altered payment records or documentation;"
    }, {
      "type": "p", "text": "Attempt to gain unauthorized access to any part of the Platform, other Users' accounts, or Tenant systems;"
    }, {
      "type": "p", "text": "Use automated tools, bots, or scripts to interact with the Platform without prior written authorization from Printify Co;"
    }, {
      "type": "p", "text": "Interfere with the normal operation, security, or integrity of the Platform or its servers;"
    }, {
      "type": "p",
      "text": "Engage in abusive, threatening, or harassing conduct toward any other User, Tenant, Customer, or Printify Co representative."
    }, {
      "type": "p", "text": "Violations may result in immediate account suspension, cancellation of pending orders, and referral to law enforcement where appropriate."
    }, {
      "type": "p", "text": "14. Data Privacy"
    }, {
      "type": "p",
"text": "The collection, use, storage, and protection of personal data submitted through the Platform is governed by our Privacy Policy, which forms part of these Terms, and by the Republic Act No. 10173 (Data Privacy Act of 2012) and its implementing rules and regulations."
    }, {
      "type": "p",
"text": "Tenants, as independent data processors of their Customers' information, are responsible for handling such data in compliance with RA 10173. Tenants may not use Customer data obtained through the Platform for purposes beyond fulfilling print orders without the Customer's explicit consent."
    }, {
      "type": "p",
"text": "Printify Co collects and processes platform-level data (e.g., account credentials, login activity) separately from data collected by Tenants (e.g., Customer shipping addresses, order histories). The respective data handling responsibilities of Printify Co and Tenants are detailed in the Privacy Policy."
    }, {
      "type": "p", "text": "15. Service Availability and Maintenance"
    }, {
      "type": "p",
"text": "Printify Co will make reasonable efforts to maintain the availability and reliability of the Platform; however, we do not guarantee that the Platform will be available 100% of the time or that it will be free from errors, bugs, or interruptions."
    }, {
      "type": "p",
"text": "Printify Co reserves the right to perform scheduled or emergency maintenance, which may result in temporary platform unavailability. We will endeavor to provide advance notice of scheduled downtime where practicable."
    }, {
      "type": "p", "text": "Printify Co shall not be liable for data loss, order delays, or any other damages resulting from planned or unplanned maintenance, technical malfunctions, or service interruptions."
    }, {
      "type": "p", "text": "16. Force Majeure"
    }, {
      "type": "p",
"text": "Printify Co shall not be held liable for any failure or delay in performance resulting from causes beyond our reasonable control, including natural disasters, fire, flood, epidemic, government action, power or internet outages, labor disputes, or acts of God."
    }, {
      "type": "p", "text": "17. Limitation of Liability"
    }, {
      "type": "p", "text": "To the fullest extent permitted by applicable law:"
    }, {
      "type": "p",
"text": "Printify Co's total liability to any User arising out of or in connection with these Terms or the Platform shall not exceed the total platform fees paid by that User (if any) in the three (3) months preceding the event giving rise to the claim."
    }, {
      "type": "p", "text": "Printify Co shall not be liable for any indirect, incidental, consequential, special, or punitive damages, including loss of profit, data, goodwill, or business opportunity."
    }, {
      "type": "p",
"text": "Printify Co is not liable for the actions, omissions, products, services, payment processing, or delivery performance of any Tenant, Payment Gateway, or Delivery Partner operating on or integrated with the Platform."
    }, {
      "type": "p", "text": "18. Indemnification"
    }, {
      "type": "p",
"text": "You agree to indemnify and hold harmless Printify Co, its officers, employees, and representatives from and against any claims, liabilities, losses, damages, and expenses (including reasonable legal fees) arising from: (a) your breach of these Terms; (b) your use of the Platform in violation of applicable law; (c) content or Files you upload; or (d) disputes between Tenants and Customers arising from their independent transactions."
    }, {
      "type": "p", "text": "19. Modifications to These Terms"
    }, {
      "type": "p",
"text": "Printify Co reserves the right to update these Terms at any time. Changes will be posted on this page with a revised \"Last Updated\" date. Continued use of the Platform after any modification constitutes acceptance of the revised Terms. Admin Clients and Customers are encouraged to review these Terms periodically."
    }, {
      "type": "p", "text": "20. Suspension and Termination"
    }, {
      "type": "p",
"text": "Printify Co may suspend or terminate any User account — including Tenant accounts — at any time, with or without prior notice, for violation of these Terms, fraudulent activity, non-compliance with applicable law, or at our sole discretion."
    }, {
      "type": "p", "text": "Upon termination of a Tenant account, the Tenant is solely responsible for resolving any outstanding obligations to its Customers, including pending orders, payments, and deliveries."
    }, {
      "type": "p", "text": "Users who believe their account was suspended in error may contact Printify Co support to request a review."
    }, {
      "type": "p", "text": "21. Governing Law and Jurisdiction"
    }, {
      "type": "p",
"text": "These Terms shall be governed by and construed in accordance with the laws of the Republic of the Philippines. Any dispute, controversy, or claim arising out of or relating to these Terms or the use of the Platform shall be subject to the exclusive jurisdiction of the appropriate courts of the Philippines."
    }, {
      "type": "p", "text": "22. Severability"
    }, {
      "type": "p", "text": "If any provision of these Terms is found by a competent court to be invalid, illegal, or unenforceable, the remaining provisions shall continue in full force and effect."
    }, {
      "type": "p", "text": "23. Contact Information"
    }, {
      "type": "p", "text": "For questions, concerns, or support regarding these Terms, please contact:"
    }, {
      "type": "p", "text": "Printify & Co. Email: hello@printify.co Phone: +63 912 345 6789 Support Hours: Monday – Friday, 8:00 AM – 6:00 PM Address: 123 Printify Avenue, Makati City, Metro Manila"
    }, {
      "type": "p",
"text": "This document is a draft prepared for the Printify Co capstone project. It should be reviewed by a qualified legal professional and updated with complete business details, specific fee structures, and applicable timeframes before being published or used in any production environment. For click-wrap compliance, ensure that Users are presented with this document in full and must actively confirm agreement (e.g., via a non-bypassable \"I Agree\" checkbox) before completing registration."
    } ]
  }, "refund": {
    "title": "Refund Policy", "blocks": [ {
      "type": "p", "text": "Printify & Co. — Web-Based Multi Business Printing Platform"
    }, {
      "type": "p", "text": "Effective Date: June 14, 2026"
    }, {
      "type": "p", "text": "Last Updated: June 14, 2026"
    }, {
      "type": "p", "text": "1. Overview and Important Notice"
    }, {
      "type": "p", "text": "This Refund Policy governs the handling of refund, reprint, and cancellation requests made through the Printify & Co. platform."
    }, {
      "type": "p",
"text": "Printify & Co. operates as a multi-business printing platform — a technology intermediary that enables independent printing businesses (\"Tenants\") to manage their operations, orders, and customer transactions online. Printify & Co. does not produce, sell, or physically fulfill any print orders. All printed products are produced and fulfilled exclusively by the respective Tenant (independent print shop) from whom you placed your order."
    }, {
      "type": "p",
"text": "As such, refund, reprint, and cancellation requests are transactions between the Customer and the Tenant, and are subject to the individual Tenant's policies as configured within the platform. Printify & Co. is not a party to these transactions and does not process or mediate refunds between Customers and Tenants."
    }, {
      "type": "p",
"text": "However, all Tenants operating on the Printify & Co. platform are required to adhere to minimum standards consistent with this Policy, Republic Act No. 7394 (Consumer Act of the Philippines), DTI Department Administrative Order No. 2, Series of 1993, and the Joint DTI-DICT-NTC Circular No. 1-2022 on e-commerce consumer protection."
    }, {
      "type": "p",
"text": "Note: The phrase \"No Return, No Exchange\" does not exempt Tenants from their legal obligations under Philippine consumer law. Customers are entitled to the remedies described in this Policy for defective, incorrect, or undelivered orders."
    }, {
      "type": "p", "text": "2. Definitions"
    }, {
      "type": "table", "rows": [ [ "Term", "Meaning" ], [ "Customer", "The end-user who places a print order with a Tenant through the platform." ], [ "Tenant",
 "An independent printing business registered on the Printify & Co. platform." ], [ "Order", "A confirmed print job submitted by a Customer to a Tenant." ], [ "Production",
"The stage at which a Tenant has commenced printing the Customer's order." ], [ "Proof", "A digital preview of the final print provided by the Tenant for Customer approval before printing." ], [ "Defective Product",
      "A printed item that fails to meet standard print industry quality benchmarks due to a production error attributable to the Tenant." ], [ "Customer Error",
 "Any error in the final output attributable to the Customer's submitted file, specifications, or approved proof." ], [ "Reprint",
"Re-production of an order at no additional cost to the Customer, offered as an alternative remedy to a refund." ] ]
    }, {
      "type": "p", "text": "3. Custom-Made Nature of Print Products"
    }, {
      "type": "p",
"text": "All products fulfilled through the Printify & Co. platform are custom-made to order based on specifications, artwork, and configurations provided by the Customer. Because each order is uniquely personalized:"
    }, {
      "type": "p", "text": "Change-of-mind returns are not accepted once an order has been confirmed and payment has been verified, as production may commence immediately thereafter."
    }, {
      "type": "p",
"text": "Customers are strongly encouraged to carefully review all order details — including product specifications, quantity, size, paper type, finishing, and artwork files — before completing payment."
    }, {
      "type": "p",
"text": "Where a digital proof is provided by the Tenant, the Customer must thoroughly review the proof for layout, text, spelling, color, dimensions, and image placement before approving. Approval of a proof by the Customer constitutes acceptance of the design as final."
    }, {
      "type": "p", "text": "4. Eligibility for Refund or Reprint"
    }, {
      "type": "p", "text": "4.1 Grounds Eligible for Refund or Reprint"
    }, {
      "type": "p", "text": "A Customer may be entitled to a refund or reprint under the following circumstances, provided the claim is submitted within the applicable timeframe:"
    }, {
      "type": "p",
"text": "Production Defect — The printed output contains visible flaws attributable to the Tenant's production process, including but not limited to: severe color banding or streaking; significant misalignment or cropping that materially alters the design; incorrect paper stock or finishing applied contrary to what was ordered; or print quality that falls materially below industry standards."
    }, {
      "type": "p", "text": "Incorrect Order Fulfillment — The Tenant produces and delivers a product that materially differs from the confirmed order specifications (e.g., wrong product, wrong size, wrong quantity)."
    }, {
      "type": "p", "text": "Damage in Transit — The order is delivered in a damaged condition caused during shipping, provided the damage is not caused by mishandling after receipt by the Customer."
    }, {
      "type": "p",
"text": "Non-Delivery — The order is not delivered within a reasonable period beyond the estimated delivery date, and the delay is attributable to the Tenant or the Delivery Partner engaged by the Tenant."
    }, {
      "type": "p",
"text": "Tenant-Cancelled Order — The Tenant cancels a confirmed and paid order for reasons attributable to the Tenant (e.g., inability to fulfill, stock issues), in which case the Customer is entitled to a full refund."
    }, {
      "type": "p", "text": "4.2 Grounds NOT Eligible for Refund or Reprint"
    }, {
      "type": "p", "text": "The following circumstances do not qualify for a refund or reprint:"
    }, {
      "type": "p",
"text": "Customer-Approved Errors — Typographical errors, spelling mistakes, incorrect names or dates, grammatical errors, or design issues that were present in the Customer's submitted file or digital proof and were approved by the Customer before printing."
    }, {
      "type": "p",
"text": "Customer File Issues — Poor print output resulting from low-resolution images, incorrect color mode (RGB submitted instead of CMYK), missing bleed, non-embedded fonts, transparency or overprint issues, incorrect orientation, or files not prepared to the Tenant's print specifications."
    }, {
      "type": "p",
"text": "Color Variation — Minor color differences between the digital proof or screen display and the final printed output, as exact color matching cannot be guaranteed due to the inherent limitations of the printing process, differences between RGB screen color and CMYK print color, and variations across paper stocks and finishes."
    }, {
      "type": "p",
"text": "Minor Print Industry Variances — Small imperfections that fall within standard print industry tolerances, including but not limited to: slight trimming offsets; minor alignment shifts; small ink specks; minor paper texture variations; or slight color density differences between print runs."
    }, {
      "type": "p", "text": "Change of Mind — The Customer no longer wants the product after confirmation and payment, without any defect or error attributable to the Tenant."
    }, {
      "type": "p", "text": "Incorrect Information Provided by Customer — Errors or delays resulting from incorrect delivery addresses, contact details, or other information supplied by the Customer."
    }, {
      "type": "p", "text": "Post-Delivery Damage — Damage caused to the product after it has been received and accepted by the Customer."
    }, {
      "type": "p", "text": "Delayed Claims — Claims submitted beyond the applicable reporting window specified in Section 5."
    }, {
      "type": "p", "text": "5. How to File a Refund or Reprint Request"
    }, {
      "type": "p", "text": "5.1 Reporting Window"
    }, {
      "type": "p",
"text": "Customers must report any issue with their order within seven (7) calendar days of receiving the order. Claims submitted after this period will not be entertained, and the order will be considered accepted and satisfactory."
    }, {
      "type": "p", "text": "5.2 Required Documentation"
    }, {
      "type": "p", "text": "To file a refund or reprint request, the Customer must contact the Tenant directly through the platform and provide all of the following:"
    }, {
      "type": "p", "text": "Order number and date of order."
    }, {
      "type": "p", "text": "Clear photographs or video of the defective, incorrect, or damaged item — showing all affected pieces, including packaging where transit damage is claimed."
    }, {
      "type": "p", "text": "Description of the issue — specifying how the product differs from what was ordered or approved."
    }, {
      "type": "p", "text": "Proof of delivery (e.g., delivery confirmation, courier tracking record) where applicable."
    }, {
      "type": "p", "text": "Incomplete submissions may result in delays or denial of the claim."
    }, {
      "type": "p", "text": "5.3 Claim Process"
    }, {
      "type": "p", "text": "Once a claim is submitted to the Tenant:"
    }, {
      "type": "p", "text": "The Tenant will acknowledge receipt of the claim within two (2) to three (3) business days."
    }, {
      "type": "p", "text": "The Tenant will evaluate the claim — including reviewing the submitted photos/video, the original order details, and the approved proof — within five (5) business days of acknowledgment."
    }, {
      "type": "p", "text": "If the Tenant determines the claim is valid, they will propose a resolution (reprint or refund) and communicate this to the Customer within two (2) business days of the determination."
    }, {
      "type": "p", "text": "If additional information or physical return of the product is required, the Tenant will notify the Customer in writing."
    }, {
      "type": "p", "text": "6. Remedies"
    }, {
      "type": "p", "text": "6.1 Order of Remedies (3Rs under Philippine Consumer Law)"
    }, {
      "type": "p", "text": "In accordance with RA 7394 (Consumer Act of the Philippines) and DTI guidelines, the standard order of remedies for eligible claims is:"
    }, {
      "type": "p", "text": "Repair / Correction — Where applicable (e.g., minor finishing adjustments)."
    }, {
      "type": "p", "text": "Replacement / Reprint — Re-production of the order using the same approved file at no cost to the Customer."
    }, {
      "type": "p", "text": "Refund — A monetary refund of the order price, issued only where a reprint is not possible, not feasible, or has been attempted and failed to resolve the issue."
    }, {
      "type": "p", "text": "6.2 Reprint Terms"
    }, {
      "type": "p", "text": "Where a reprint is offered:"
    }, {
      "type": "p", "text": "The reprint will use the same file and specifications as the original approved order. No changes to the artwork or specifications will be accepted for the reprint."
    }, {
      "type": "p", "text": "Only one (1) reprint per order is permitted."
    }, {
      "type": "p", "text": "An order that has already been reprinted is not eligible for a further reprint or refund, unless the reprint itself is also defective due to a production error."
    }, {
      "type": "p", "text": "Reprint turnaround times are subject to the Tenant's production schedule."
    }, {
      "type": "p", "text": "6.3 Refund Terms"
    }, {
      "type": "p", "text": "Where a refund is approved:"
    }, {
      "type": "p", "text": "Refunds will be issued for the product price of the affected items only. Delivery fees are non-refundable unless the non-delivery or delay is attributable to the Tenant."
    }, {
      "type": "p",
"text": "Refunds will be processed through the original payment method used for the order (e.g., PayMongo, Maya, or other applicable payment gateway). Where the original payment method is no longer available, an alternative arrangement will be agreed upon with the Customer."
    }, {
      "type": "p", "text": "Refunds will be processed within seven (7) to fifteen (15) business days from approval of the claim, subject to the processing timelines of the applicable payment gateway or bank."
    }, {
      "type": "p", "text": "Partial refunds may be issued where only a portion of the order is found to be defective or affected."
    }, {
      "type": "p", "text": "6.4 Platform-Level Refunds"
    }, {
      "type": "p",
"text": "Where an order cannot be fulfilled due to a Tenant's suspension or termination from the Printify & Co. platform after payment has been collected, Printify & Co. will make reasonable efforts to facilitate communication between the Customer and the Tenant for resolution. Printify & Co.'s liability in such circumstances is limited to facilitating this communication and does not extend to processing refunds on behalf of the Tenant."
    }, {
      "type": "p", "text": "7. Cancellations"
    }, {
      "type": "p", "text": "7.1 Cancellation Before Production"
    }, {
      "type": "p",
"text": "Orders may be cancelled before production has commenced by submitting a cancellation request to the Tenant through the platform. A processing or administrative fee may be deducted from any refund issued for pre-production cancellations, as determined by the Tenant's policies. The remaining balance will be refunded to the Customer."
    }, {
      "type": "p", "text": "7.2 Cancellation After Production Commences"
    }, {
      "type": "p",
"text": "Once a Tenant has commenced production of an order, the order cannot be cancelled or modified. The full order price will be charged, regardless of whether the Customer accepts the finished product."
    }, {
      "type": "p", "text": "7.3 Cancellation After Proof Approval"
    }, {
      "type": "p", "text": "Once the Customer has approved a digital proof and production has begun:"
    }, {
      "type": "p", "text": "No cancellation is permitted."
    }, {
      "type": "p", "text": "100% of the product price is non-refundable."
    }, {
      "type": "p", "text": "7.4 Cancellation Stages and Applicable Fees"
    }, {
      "type": "p", "text": "The following general guidelines apply, subject to the individual Tenant's configured policies:"
    }, {
      "type": "table", "rows": [ [ "Cancellation Stage", "Applicable Fee" ], [ "Before file submission or artwork upload", "Minimal or no fee (at Tenant's discretion)" ],
 [ "After file submission but before proof issuance", "Processing fee (at Tenant's discretion)" ], [ "After proof issuance but before Customer approval", "Processing fee (at Tenant's discretion)" ],
[ "After Customer approval of proof", "100% of product price — non-refundable" ], [ "After production has commenced", "100% of product price — non-refundable" ] ]
    }, {
      "type": "p", "text": "8. Non-Refundable Items and Situations"
    }, {
      "type": "p", "text": "The following are strictly non-refundable under this Policy:"
    }, {
      "type": "p", "text": "Delivery and shipping fees (except where non-delivery is attributable to the Tenant)"
    }, {
      "type": "p", "text": "Orders where the Customer has approved a proof containing the reported error"
    }, {
      "type": "p", "text": "Orders where the issue is caused by the Customer's submitted file quality or specifications"
    }, {
      "type": "p", "text": "Orders cancelled after production has commenced"
    }, {
      "type": "p", "text": "Orders for which a reprint has already been completed"
    }, {
      "type": "p", "text": "Claims submitted beyond the seven (7)-day reporting window"
    }, {
      "type": "p", "text": "9. Abandoned and Unclaimed Orders"
    }, {
      "type": "p",
"text": "Orders that remain unclaimed or undeliverable after ninety (90) days from the scheduled delivery or pickup date, due to circumstances attributable to the Customer (e.g., incorrect address, repeated non-response, failure to collect from store), may be cancelled at the Tenant's discretion. In such cases:"
    }, {
      "type": "p", "text": "Any amounts paid may be forfeited in full."
    }, {
      "type": "p", "text": "No refund or reprint will be issued."
    }, {
      "type": "p", "text": "The Customer will be required to place a new order if they still wish to receive the printed items."
    }, {
      "type": "p", "text": "Tenants are required to make reasonable attempts to contact the Customer via the contact details provided on the order before cancelling an abandoned order."
    }, {
      "type": "p", "text": "10. Dispute Escalation"
    }, {
      "type": "p", "text": "If a Customer and a Tenant are unable to resolve a refund or reprint dispute directly through the platform within a reasonable period, the Customer may:"
    }, {
      "type": "p",
"text": "Contact Printify & Co. at hello@printify.co to report the unresolved dispute. While Printify & Co. is not obligated to mediate, we may facilitate communication between the parties as a goodwill measure."
    }, {
      "type": "p",
"text": "File a complaint with the Department of Trade and Industry (DTI) through the DTI's Fair Trade Enforcement Bureau (FTEB) or the Online Consumer Protection service at www.dti.gov.ph or by calling 1-384 (DTI Hotline)."
    }, {
      "type": "p",
"text": "Pursue civil remedies under the Consumer Act of the Philippines (RA 7394) and the Civil Code of the Philippines through the appropriate courts or the Small Claims Court for claims not exceeding the threshold prescribed by the Supreme Court."
    }, {
      "type": "p", "text": "11. Tenant Obligations"
    }, {
      "type": "p", "text": "All Tenants operating on the Printify & Co. platform are required to:"
    }, {
      "type": "p", "text": "Maintain and clearly communicate their specific refund, reprint, and cancellation policies to their Customers through their storefront on the platform."
    }, {
      "type": "p", "text": "Honor valid refund and reprint claims within the timeframes and standards set out in this Policy."
    }, {
      "type": "p", "text": "Comply with all applicable provisions of RA 7394 (Consumer Act), DTI DAO No. 2-93, and relevant DTI and e-commerce regulations."
    }, {
      "type": "p", "text": "Not enforce a blanket \"No Return, No Exchange\" policy in violation of Philippine consumer law."
    }, {
      "type": "p", "text": "Process approved refunds promptly and through the Customer's original payment method where possible."
    }, {
      "type": "p", "text": "Failure by a Tenant to comply with these obligations may result in suspension or termination of their account on the Printify & Co. platform."
    }, {
      "type": "p", "text": "12. Color Accuracy Disclaimer"
    }, {
      "type": "p", "text": "Due to the inherent nature of the printing process, exact color matching between digital files and printed output cannot be guaranteed. Variations may occur due to:"
    }, {
      "type": "p", "text": "Differences between RGB (screen) and CMYK (print) color spaces"
    }, {
      "type": "p", "text": "Monitor calibration differences between the Customer's device and production equipment"
    }, {
      "type": "p", "text": "Paper stock, coating, and finishing effects on ink appearance"
    }, {
      "type": "p", "text": "Natural variation between print runs"
    }, {
      "type": "p",
"text": "Color variations that fall within industry-standard tolerances are not grounds for a refund or reprint. Customers who require precise color accuracy are strongly encouraged to request a physical proof or sample print from the Tenant prior to placing a full production order, where such a service is offered."
    }, {
      "type": "p", "text": "13. Modifications to This Policy"
    }, {
      "type": "p",
"text": "Printify & Co. reserves the right to update or amend this Refund Policy at any time. Changes will be posted on this page with a revised \"Last Updated\" date. The version of this Policy in effect at the time of the order will govern that transaction. Continued use of the platform constitutes acceptance of the revised Policy."
    }, {
      "type": "p", "text": "14. Contact Us"
    }, {
      "type": "p", "text": "For questions, concerns, or to report an unresolved dispute, please contact:"
    }, {
      "type": "p", "text": "Printify & Co. Email: hello@printify.co Phone: +63 912 345 6789 Support Hours: Monday – Friday, 8:00 AM – 6:00 PM Address: 123 Printify Avenue, Makati City, Metro Manila"
    }, {
      "type": "p", "text": "For DTI consumer complaints: Department of Trade and Industry (DTI) Hotline: 1-384 Website: www.dti.gov.ph"
    }, {
      "type": "p",
"text": "This Refund Policy is drafted in compliance with Republic Act No. 7394 (Consumer Act of the Philippines), DTI Department Administrative Order No. 2, Series of 1993, and Joint DTI-DICT-NTC Circular No. 1-2022 on e-commerce consumer protection. This document is prepared for the Printify & Co. capstone project and should be reviewed by a qualified legal professional before deployment in a production environment."
    } ]
  }, "faq": {
    "title": "Frequently Asked Questions (FAQs)",
    "blocks": `Frequently Asked Questions (FAQs)
Printify & Co. - Capstone Project Prototype
I. General & Platform Overview
What is Printify & Co.?
Printify & Co. is a web-based multi-business printing platform. We serve as a technology intermediary or software provider that allows independent print shops ("Tenants") to register, set up their digital storefronts, manage print orders, process payments, and coordinate deliveries with their customers.
Are you a printing company? Do you fulfill the orders yourself?
No. Printify & Co. is strictly a technology platform and does not produce, print, handle, or physically fulfill any print orders. All products are manufactured and fulfilled exclusively by the independent print shop (Tenant) you choose when placing your order through the web system.
Who are the "Tenants" on the platform?
Tenants are independent, third-party printing businesses, shops, or vendors who operate their individual stores using our system infrastructure. They are solely responsible for setting their own pricing, managing their production schedules, ensuring print quality, and fulfilling your orders.
Does Printify & Co. set the rules for every tenant?
No. Printify & Co. sets a set of minimum platform-wide standards - covering areas like data privacy, payment security, and baseline consumer protections - that every tenant agrees to when joining the platform. Beyond these minimums, each tenant independently sets their own pricing, file requirements, production timelines, quality tolerances, courier partners, and specific refund or reprint conditions. Because of this, several answers in this FAQ will direct you to check the specific tenant's storefront for details that may vary from shop to shop.
II. Account Management & Privacy
Do I need to create an account to place an order?
Yes. To ensure accurate order tracking, secure file storage, and reliable delivery, you must register a Customer account with your full name, email address, contact number, and a secure password.
How is my personal information protected?
Printify & Co. is designed to comply with Republic Act No. 10173 (Data Privacy Act of 2012). The platform applies encryption and access controls to secure your data, and information is processed only to manage your account, fulfill platform transactions, and assist with order delivery. Your data will never be sold, rented, or traded to third parties.
Can I delete or modify my data on the platform?
Yes. Under the Data Privacy Act, you have the right to access, correct, or request the deletion of your personal data. You can manage your profile directly via your account settings or contact our Authorized Officer at hello@printify.co for formal data requests.
III. Ordering, Design Uploads, & Intellectual Property
What file formats are acceptable for upload?
File format capabilities depend on the specific printing shop (Tenant) you are ordering from. Generally, high-resolution formats like PDF, PNG, or TIFF are recommended. Please check the specific Tenant's storefront instructions before uploading.
Are there any restrictions on what I can upload and print?
Yes. You are strictly prohibited from uploading or ordering prints of materials that are illegal, fraudulent, defamatory, obscene, pornographic, or infringing upon third-party intellectual property rights.
Who owns the copyright of the files I upload?
You retain full ownership and intellectual property rights of any artwork or files you upload. By uploading them, you grant the selected tenant a limited, non-exclusive license solely to view, process, and reproduce the design to fulfill your order. You warrant that you own or have the legal right to use all uploaded materials.
IV. Payments & Financial Security
What payment methods are available?
Available payment options are configured by each individual tenant. They typically include online payment gateways such as credit/debit cards, GCash, Maya, PayMongo, or other secure local payment providers linked to the platform.
Is my financial data safe? Does Printify & Co. store my card details?
Your financial transactions are designed to be handled securely. Printify & Co. does not store, collect, or process your full credit/debit card numbers or e-wallet credentials. All payment processing is handled by PCI DSS-compliant, secure third-party payment gateway partners.
V. Production, Color Accuracy, & Proofing
Why does the color of my printed item look slightly different from my digital screen?
Digital screens display colors using the RGB spectrum (Light), while industrial printers print using the CMYK spectrum (Ink). Minor color variations can also occur due to the texture, absorbency, and coating of the chosen paper or substrate.
Can I complain about minor color shifting?
Natural color variations that fall within standard printing tolerances are generally normal and not automatically grounds for a refund or free reprint. What counts as an acceptable tolerance, and whether a proofing step is offered, is set by each individual tenant - we recommend asking the tenant for a physical proof or sample print before booking a large production run.
VI. Delivery, Logistics, & Transit
How are printed items shipped to me?
Deliveries are arranged through third-party logistics services (such as Lalamove or J&T Express) integrated or selected by the tenant during checkout. Available courier options and shipping arrangements can vary from tenant to tenant.
What happens if my package arrives damaged or gets lost by the courier?
If your items suffer physical damage while in transit, it qualifies as "Damage in Transit." You must report this issue directly to the tenant, with unboxing photos or video proof, so they can arrange a replacement or resolve it with their logistics provider. Exact claim windows and processes may vary by tenant, so check their storefront policy for specifics.
VII. Reprints, Refunds, & Cancellations
Can I cancel my order if I make a mistake or change my mind?
No. Because all print orders are highly customized, personalized, and made-to-order according to your specific layout, "change-of-mind" cancellations, modifications, or returns are strictly prohibited once an order has been confirmed and production has been initiated. Always double-check your spelling, sizing, and design layouts before paying.
Under what conditions can I request a refund or a reprint?
Specific refund and reprint conditions - including claim windows, accepted evidence, and qualifying reasons - are set by each individual tenant and may differ from shop to shop. As a general guide, valid reasons commonly accepted across tenants include clear production defects, incorrect fulfillment (wrong product, size, or quantity), damage in transit, or a tenant-initiated cancellation after payment. Always check the specific tenant's storefront policy before placing your order to confirm their exact terms.
How do I file a refund or reprint claim?
Since the transactional agreement is directly between you and the print shop, you must submit your refund/reprint claim directly to the specific tenant via the platform interface, providing comprehensive photo/video evidence of the defect or issue.
What is your stance on "No Return, No Exchange" policies?
As a baseline standard that all tenants agree to when joining the platform, a "No Return, No Exchange" policy cannot be used to excuse a tenant from replacing defective items, fixing fulfillment mistakes, or resolving damaged goods. Custom goods remain non-returnable for simple buyer regret, consistent with Department of Trade and Industry (DTI) guidance, but tenants are still expected to honor legitimate defect, fulfillment, or damage claims.
VIII. Support & Disputes
What should I do if a tenant ignores my refund request or fails to deliver?
While Printify & Co. does not directly process refunds, since these are transactions between you and the tenant, the platform maintains baseline standards tenants are expected to follow. If you have an unresolved dispute with a tenant, you may flag the transaction to our support team at hello@printify.co for platform-level review.
How can I contact Printify & Co. directly?
Email: hello@printify.co
Phone: +63 912 345 6789
Support Hours: Monday - Friday, 8:00 AM - 6:00 PM
Address: 123 Printify Avenue, Makati City, Metro Manila
Disclaimer
This FAQ document was prepared for the Printify & Co. capstone research project and is intended strictly for academic and prototype purposes. Printify & Co. is a conceptual, proposed system developed as part of Capstone Research 1 and is not a live, operating commercial platform. References to specific laws (e.g., the Data Privacy Act of 2012, the Consumer Act of the Philippines, and DTI guidance) reflect the intended compliance design of the proposed system and are illustrative only - they have not been verified or certified by a qualified legal professional or a registered Data Protection Officer. All contact details (email, phone number, support hours, and address) listed in this document are placeholders for demonstration purposes and are not active channels. This document, including all policies, conditions, and figures described, must be reviewed, validated, and finalized by appropriate legal, technical, and business stakeholders prior to any real-world or production deployment.`.split(/\n+/).filter(Boolean).map(text=>({type:"p", text}))
  }, "privacy": {
    "title": "Privacy Policy", "blocks": [ {
      "type": "p", "text": "Printify & Co. — Web-Based Multi Business Printing Platform Effective Date: June 14, 2026 Last Updated: June 14, 2026"
    }, {
      "type": "p", "text": "1. Introduction"
    }, {
      "type": "p",
"text": "Printify & Co. (\"Platform,\" \"we,\" \"us,\" \"our\") is committed to protecting the privacy and personal data of all individuals who interact with our platform — including Customers, Admin Clients (Tenants), and Developers. This Privacy Policy explains how we collect, use, store, share, protect, and dispose of personal data in connection with your use of the Printify & Co. web-based platform."
    }, {
      "type": "p",
"text": "This Policy is issued in compliance with Republic Act No. 10173, otherwise known as the Data Privacy Act of 2012 (DPA), its Implementing Rules and Regulations (IRR), and the applicable issuances of the National Privacy Commission (NPC) of the Philippines, including NPC Circular No. 2023-06 and NPC Advisory No. 2025-02 on Privacy Engineering in Systems Life Cycle Processes."
    }, {
      "type": "p",
"text": "By using the Platform in any capacity, you acknowledge that you have read and understood this Privacy Policy and consent to the collection and processing of your personal data as described herein."
    }, {
      "type": "p", "text": "2. Scope and Application"
    }, {
      "type": "p", "text": "This Privacy Policy applies to:"
    }, {
      "type": "p", "text": "Customers — end-users who place orders with Tenants through the Platform."
    }, {
      "type": "p", "text": "Admin Clients — business owners and administrators who register and manage a Tenant account on the Platform."
    }, {
      "type": "p", "text": "Developers — Printify & Co. technical personnel with system-level access."
    }, {
      "type": "p", "text": "Visitors — any individual who accesses the Printify & Co. website or platform without registering an account."
    }, {
      "type": "p",
"text": "This Policy covers personal data collected and processed by Printify & Co. as the Personal Information Controller (PIC) for platform-level operations. Tenants (Admin Clients) who independently collect and process Customer personal data through the Platform act as separate Personal Information Controllers or Personal Information Processors (PIPs) for their respective operations and are individually responsible for compliance with the DPA in relation to that data."
    }, {
      "type": "p", "text": "3. Personal Information Controller"
    }, {
      "type": "table", "rows": [ [ "Detail", "Information" ], [ "Business Name", "Printify & Co." ], [ "Address", "123 Printify Avenue, Makati City, Metro Manila" ], [ "Email", "hello@printify.co" ], [ "Phone",
"+63 912 345 6789" ], [ "Support Hours", "Monday – Friday, 8:00 AM – 6:00 PM" ], [ "Data Protection Officer (DPO)", "[Insert DPO Name]" ], [ "DPO Email", "[Insert DPO Email]" ] ]
    }, {
      "type": "p", "text": "4. What Personal Data We Collect"
    }, {
      "type": "p", "text": "We collect personal data that is necessary, relevant, and adequate for the purposes outlined in this Policy. The data we collect depends on your role on the Platform."
    }, {
      "type": "p", "text": "4.1 From All Users (Account Registration)"
    }, {
      "type": "p", "text": "Full name"
    }, {
      "type": "p", "text": "Email address"
    }, {
      "type": "p", "text": "Username and password (encrypted)"
    }, {
      "type": "p", "text": "Contact number"
    }, {
      "type": "p", "text": "Role on the Platform (Customer, Admin Client)"
    }, {
      "type": "p", "text": "Date and time of account creation"
    }, {
      "type": "p", "text": "Device information (browser type, operating system, IP address)"
    }, {
      "type": "p", "text": "Login activity and session data"
    }, {
      "type": "p", "text": "4.2 From Customers (Order Placement and Delivery)"
    }, {
      "type": "p", "text": "Delivery address (street, city, province, postal code)"
    }, {
      "type": "p", "text": "Order details (product specifications, quantity, file uploads)"
    }, {
      "type": "p", "text": "Uploaded artwork files and design documents"
    }, {
      "type": "p", "text": "Preferred delivery method and courier selection"
    }, {
      "type": "p", "text": "Payment method selected (processed directly by Payment Gateway)"
    }, {
      "type": "p", "text": "Order history and transaction records"
    }, {
      "type": "p", "text": "Communications with the Tenant (messages, support tickets)"
    }, {
      "type": "p", "text": "4.3 From Admin Clients (Tenant Registration and Operations)"
    }, {
      "type": "p", "text": "Business name and type"
    }, {
      "type": "p", "text": "Business address and contact information"
    }, {
      "type": "p", "text": "Government-issued identification or business registration documents (where required for verification)"
    }, {
      "type": "p", "text": "Payment and billing information for platform subscription or fees (if applicable)"
    }, {
      "type": "p", "text": "Business configuration data (products offered, pricing, delivery options, payment methods enabled)"
    }, {
      "type": "p", "text": "Order management activity and staff access logs"
    }, {
      "type": "p", "text": "4.4 Automatically Collected Data (All Users)"
    }, {
      "type": "p", "text": "IP address and geolocation data"
    }, {
      "type": "p", "text": "Browser type and version"
    }, {
      "type": "p", "text": "Operating system"
    }, {
      "type": "p", "text": "Pages visited, time spent, and navigation patterns"
    }, {
      "type": "p", "text": "Device identifiers"
    }, {
      "type": "p", "text": "Cookies and similar tracking technologies (see Section 10)"
    }, {
      "type": "p", "text": "4.5 Data We Do NOT Collect"
    }, {
      "type": "p", "text": "Printify & Co. does not collect or store:"
    }, {
      "type": "p", "text": "Full credit or debit card numbers — payment card data is handled exclusively by the integrated Payment Gateway (e.g., PayMongo, Maya) using their secure, PCI DSS-compliant infrastructure."
    }, {
      "type": "p", "text": "Government-issued ID numbers (e.g., SSS, TIN, PhilHealth) unless specifically required for Tenant verification and with explicit consent."
    }, {
      "type": "p", "text": "Biometric data."
    }, {
      "type": "p", "text": "5. Purposes and Legal Basis for Processing"
    }, {
      "type": "p", "text": "We process personal data on the following lawful bases under the Data Privacy Act of 2012:"
    }, {
      "type": "table", "rows": [ [ "Purpose", "Data Used", "Legal Basis" ], [ "Account registration and authentication", "Name, email, password, contact number", "Consent; Contract" ],
 [ "Order facilitation and fulfillment coordination", "Order details, delivery address, uploaded files", "Contract" ], [ "Payment processing (via Payment Gateway)", "Payment method selection, transaction reference",
 "Contract; Legitimate Interest" ], [ "Delivery coordination (via Delivery Partners)", "Delivery address, contact number, order details", "Contract" ], [ "Customer support and dispute resolution",
 "Account and order data, communications", "Legitimate Interest; Legal Obligation" ], [ "Platform security and fraud prevention", "IP address, login activity, device data", "Legitimate Interest" ],
 [ "Platform performance and analytics (aggregated, anonymized)", "Usage data, navigation patterns", "Legitimate Interest" ], [ "Compliance with legal obligations", "Any required data", "Legal Obligation" ],
 [ "Communications and service notifications", "Email address, contact number", "Consent; Contract" ], [ "Tenant business management and configuration", "Admin Client business data", "Contract" ],
[ "Improvement of Platform features and services", "Aggregated usage data", "Legitimate Interest" ] ]
    }, {
      "type": "p", "text": "We will not process your personal data for purposes incompatible with those stated above without obtaining your prior consent."
    }, {
      "type": "p", "text": "6. How We Share Personal Data"
    }, {
      "type": "p", "text": "Printify & Co. does not sell, rent, or trade personal data. We share personal data only as described below and only to the extent necessary."
    }, {
      "type": "p", "text": "6.1 With Tenants (Admin Clients)"
    }, {
      "type": "p",
"text": "When a Customer places an order with a Tenant through the Platform, relevant personal data (such as name, contact details, delivery address, order details, and uploaded files) is made accessible to that Tenant to enable them to process and fulfill the order. Tenants are independently responsible for handling this data in compliance with the DPA."
    }, {
      "type": "p", "text": "6.2 With Payment Gateways"
    }, {
      "type": "p",
"text": "To process online payments, transaction data is shared with integrated Payment Gateways such as PayMongo, Maya, and other applicable providers. Payment Gateways process payment data under their own privacy policies and security standards. We encourage Users to review the privacy policy of the applicable Payment Gateway. Printify & Co. does not receive or store full card details."
    }, {
      "type": "p", "text": "6.3 With Delivery Partners"
    }, {
      "type": "p",
"text": "To facilitate order delivery, relevant data (delivery address, contact number, order reference) may be shared with third-party Delivery Partners such as Lalamove, J&T Express, or other logistics providers selected by the Tenant or Customer. Delivery Partners handle this data under their own privacy policies."
    }, {
      "type": "p", "text": "6.4 With Service Providers and Processors"
    }, {
      "type": "p",
"text": "We may engage third-party service providers (e.g., cloud hosting, email delivery, analytics) who process personal data on our behalf as Personal Information Processors (PIPs). These providers are bound by data processing agreements requiring them to handle personal data in accordance with the DPA and consistent with this Policy."
    }, {
      "type": "p", "text": "6.5 For Legal Compliance and Safety"
    }, {
      "type": "p", "text": "We may disclose personal data to government authorities, law enforcement agencies, or regulatory bodies when:"
    }, {
      "type": "p", "text": "Required by law, court order, or legal process;"
    }, {
      "type": "p", "text": "Necessary to protect the rights, safety, or property of Printify & Co., our Users, or the public;"
    }, {
      "type": "p",
"text": "Required to report illegal content, including child exploitation material, hate speech, or fraud, to appropriate authorities — without prior notice to the User where notification would compromise the investigation."
    }, {
      "type": "p", "text": "6.6 Business Transfers"
    }, {
      "type": "p",
"text": "In the event of a merger, acquisition, or sale of assets involving Printify & Co., personal data may be transferred to the successor entity, subject to the same privacy protections outlined in this Policy. Affected Users will be notified of any material change in data handling."
    }, {
      "type": "p", "text": "7. Data Retention"
    }, {
      "type": "p", "text": "We retain personal data only for as long as necessary to fulfill the purposes for which it was collected, or as required by applicable law. Our general retention guidelines are as follows:"
    }, {
      "type": "table", "rows": [ [ "Data Category", "Retention Period" ], [ "Account information", "Duration of account + [X] years after account closure" ], [ "Order records and transaction history",
 "[X] years from order completion (for legal and audit compliance)" ], [ "Uploaded artwork files", "Deleted [X] days/months after order completion" ], [ "Payment transaction references",
 "[X] years as required by applicable financial regulations" ], [ "Login and activity logs", "[X] months for security monitoring purposes" ], [ "Support and communication records", "[X] years from last interaction" ],
[ "Cookies and session data", "As specified in Section 10" ] ]
    }, {
      "type": "p", "text": "Upon expiration of the applicable retention period, personal data will be securely deleted or anonymized so that it can no longer be attributed to an identifiable individual."
    }, {
      "type": "p", "text": "8. Your Rights as a Data Subject"
    }, {
      "type": "p", "text": "Under the Data Privacy Act of 2012, you have the following rights with respect to your personal data:"
    }, {
      "type": "p", "text": "Right to Be Informed — You have the right to be informed of how your personal data is being collected and processed, which this Privacy Policy fulfills."
    }, {
      "type": "p", "text": "Right to Access — You may request a copy of the personal data we hold about you, including information on how it is being used."
    }, {
      "type": "p", "text": "Right to Correction/Rectification — You may request that inaccurate or outdated personal data be corrected or updated."
    }, {
      "type": "p",
"text": "Right to Erasure or Blocking — You may request the deletion or blocking of your personal data where it is no longer necessary for the purposes for which it was collected, or where processing is unlawful."
    }, {
      "type": "p",
"text": "Right to Data Portability — You may request that your personal data be provided to you in a structured, commonly used, and machine-readable format, or transferred to another service provider where technically feasible."
    }, {
      "type": "p", "text": "Right to Object — You may object to the processing of your personal data for specific purposes, including direct marketing or processing based on legitimate interest."
    }, {
      "type": "p", "text": "Right to Restriction of Processing — You may request that we limit the processing of your personal data under certain circumstances."
    }, {
      "type": "p", "text": "Right to Lodge a Complaint — If you believe your rights under the DPA have been violated, you may lodge a complaint with the National Privacy Commission (NPC):"
    }, {
      "type": "p",
"text": "National Privacy Commission 25th–27th Floors, The Upper Class Tower, Quezon Avenue corner Scout Reyes St., Brgy. Paligsahan, Quezon City Email: info@privacy.gov.ph Website: privacy.gov.ph Tel: +632 5322 1322"
    }, {
      "type": "p",
"text": "To exercise any of the above rights, please contact our Data Protection Officer at [Insert DPO Email]. We will respond to all requests within a reasonable period and in accordance with the DPA and NPC guidelines."
    }, {
      "type": "p", "text": "9. Data Security"
    }, {
      "type": "p",
"text": "Printify & Co. implements appropriate organizational, physical, and technical security measures to protect personal data against unauthorized access, disclosure, alteration, loss, or destruction, in accordance with NPC Circular No. 2023-06."
    }, {
      "type": "p", "text": "Organizational Measures:"
    }, {
      "type": "p", "text": "Designation of a Data Protection Officer (DPO) registered with the NPC"
    }, {
      "type": "p", "text": "Role-based access controls (RBAC) limiting data access to authorized personnel only, based on their role (Customer, Admin Client, Developer)"
    }, {
      "type": "p", "text": "Employee and staff training on data privacy and security practices"
    }, {
      "type": "p", "text": "Privacy Impact Assessments (PIAs) conducted for significant data processing activities and new system features"
    }, {
      "type": "p", "text": "Data processing agreements with all third-party service providers"
    }, {
      "type": "p", "text": "Technical Measures:"
    }, {
      "type": "p", "text": "Encryption of personal data in transit (TLS/SSL) and at rest"
    }, {
      "type": "p", "text": "Secure password hashing and storage"
    }, {
      "type": "p", "text": "Session management and automatic session timeout"
    }, {
      "type": "p", "text": "Regular security audits and vulnerability assessments"
    }, {
      "type": "p", "text": "Firewall protection and intrusion detection systems"
    }, {
      "type": "p", "text": "Access logging and monitoring"
    }, {
      "type": "p", "text": "Physical Measures:"
    }, {
      "type": "p", "text": "Restricted access to servers and data storage facilities"
    }, {
      "type": "p", "text": "Secure disposal of physical records containing personal data"
    }, {
      "type": "p",
"text": "Despite these measures, no system is entirely immune to security risks. We encourage Users to use strong, unique passwords and to report any suspected security vulnerabilities or unauthorized access to us immediately."
    }, {
      "type": "p", "text": "10. Cookies and Tracking Technologies"
    }, {
      "type": "p", "text": "The Printify & Co. Platform uses cookies and similar technologies to enhance your experience, maintain session integrity, and analyze platform performance."
    }, {
      "type": "p", "text": "Types of Cookies We Use"
    }, {
      "type": "table", "rows": [ [ "Cookie Type", "Purpose" ], [ "Essential / Strictly Necessary", "Required for the Platform to function (e.g., session authentication, login state). Cannot be disabled." ],
 [ "Functional", "Remember your preferences and settings (e.g., language, saved cart items)." ], [ "Analytics", "Collect aggregated, anonymized data on how Users interact with the Platform to help us improve features." ],
[ "Security", "Detect and prevent fraudulent activity and unauthorized access." ] ]
    }, {
      "type": "p", "text": "We do not use cookies for third-party advertising or behavioral profiling."
    }, {
      "type": "p", "text": "Managing Cookies"
    }, {
      "type": "p",
"text": "You may configure your browser to refuse cookies or to alert you when cookies are being sent. However, disabling essential cookies may affect the functionality of the Platform. Where required by law, we will seek your consent before placing non-essential cookies."
    }, {
      "type": "p", "text": "11. Third-Party Links and Services"
    }, {
      "type": "p",
"text": "The Platform may contain links to third-party websites or integrate third-party services (e.g., Payment Gateways, Delivery Partners). Printify & Co. is not responsible for the privacy practices of these third parties. We encourage Users to review the privacy policies of any third-party service before providing personal data."
    }, {
      "type": "p", "text": "12. Data Breach Notification"
    }, {
      "type": "p", "text": "In the event of a personal data breach that poses a real risk of serious harm to any affected data subject, Printify & Co. will:"
    }, {
      "type": "p", "text": "Notify the National Privacy Commission (NPC) within 72 hours of discovery of the breach, in accordance with the DPA and NPC Circular No. 2016-03;"
    }, {
      "type": "p", "text": "Notify affected data subjects within 72 hours if the breach is likely to adversely affect their rights and freedoms;"
    }, {
      "type": "p", "text": "Submit a full breach report to the NPC within five (5) days of initial notification, unless additional time is granted by the NPC;"
    }, {
      "type": "p",
      "text": "Take immediate steps to contain the breach, mitigate harm, and prevent recurrence."
    }, {
      "type": "p", "text": "Notifications will include the nature of the breach, the personal data involved, the measures taken to address the breach, and contact information for further inquiries."
    }, {
      "type": "p", "text": "13. Children's Privacy"
    }, {
      "type": "p",
"text": "The Printify & Co. Platform is not intended for use by individuals under the age of 18. We do not knowingly collect personal data from minors. If we become aware that a minor has provided personal data without parental consent, we will take immediate steps to delete such data. If you believe a minor has provided us with personal data, please contact us at hello@printify.co."
    }, {
      "type": "p", "text": "14. Cross-Border Data Transfers"
    }, {
      "type": "p",
"text": "The Printify & Co. Platform is operated and hosted within the Philippines. If personal data is transferred to service providers or partners outside the Philippines, we ensure that adequate data protection safeguards are in place, as required under the DPA, including contractual protections or confirmation of adequate protection levels as recognized by the NPC."
    }, {
      "type": "p", "text": "15. Privacy by Design and Default"
    }, {
      "type": "p", "text": "In accordance with NPC Advisory No. 2025-02, Printify & Co. integrates privacy principles into the design and development of our Platform from the outset. This includes:"
    }, {
      "type": "p", "text": "Collecting only the minimum personal data necessary for each specific purpose (data minimization);"
    }, {
      "type": "p", "text": "Ensuring that privacy-protective settings are the default across all Platform features;"
    }, {
      "type": "p", "text": "Conducting Privacy Impact Assessments before deploying new features or systems that involve personal data;"
    }, {
      "type": "p", "text": "Implementing privacy engineering practices throughout the Platform's systems life cycle."
    }, {
      "type": "p", "text": "16. Tenant Responsibilities"
    }, {
      "type": "p",
"text": "Each Tenant (Admin Client) operating on the Platform is an independent business and may independently collect and process personal data from their Customers. In this capacity, Tenants may act as a separate Personal Information Controller or as a Personal Information Processor, depending on the nature of their data handling activities."
    }, {
      "type": "p", "text": "Tenants are solely responsible for:"
    }, {
      "type": "p", "text": "Complying with the Data Privacy Act of 2012 and all applicable NPC issuances in relation to the personal data of their Customers;"
    }, {
      "type": "p", "text": "Informing their Customers of how their personal data is collected and used;"
    }, {
      "type": "p", "text": "Implementing appropriate security measures to protect Customer data accessed through the Platform;"
    }, {
      "type": "p", "text": "Not using Customer personal data for any purpose beyond fulfilling print orders, without the Customer's explicit consent;"
    }, {
      "type": "p", "text": "Entering into appropriate data processing agreements with Printify & Co. and any sub-processors they engage."
    }, {
      "type": "p", "text": "Printify & Co. is not liable for any DPA violations committed by Tenants in relation to their independent handling of Customer data."
    }, {
      "type": "p", "text": "17. Changes to This Privacy Policy"
    }, {
      "type": "p",
"text": "We reserve the right to update or amend this Privacy Policy at any time to reflect changes in our data practices, applicable law, or platform features. Any material changes will be communicated to Users via email or through a notice on the Platform, and the \"Last Updated\" date at the top of this document will be revised accordingly."
    }, {
      "type": "p", "text": "Your continued use of the Platform after any changes to this Policy constitutes your acceptance of the updated Privacy Policy. We encourage all Users to review this Policy periodically."
    }, {
      "type": "p", "text": "18. Contact Us"
    }, {
      "type": "p", "text": "For any questions, concerns, or requests related to this Privacy Policy or your personal data rights, please contact:"
    }, {
      "type": "p",
"text": "Printify & Co. Attn: Data Protection Officer Email: hello@printify.co Phone: +63 912 345 6789 Support Hours: Monday – Friday, 8:00 AM – 6:00 PM Address: 123 Printify Avenue, Makati City, Metro Manila"
    }, {
      "type": "p", "text": "To file a formal complaint, you may also contact the National Privacy Commission at info@privacy.gov.ph or visit privacy.gov.ph."
    }, {
      "type": "p",
"text": "This Privacy Policy is drafted in compliance with Republic Act No. 10173 (Data Privacy Act of 2012), its Implementing Rules and Regulations, NPC Circular No. 2023-06, and NPC Advisory No. 2025-02. This document is prepared for the Printify & Co. capstone project and should be reviewed by a qualified legal professional and a registered Data Protection Officer before deployment in a production environment. Retention periods marked [X] should be defined based on your specific business and legal requirements prior to publication."
    } ]
  }
};
window.footerClosePolicy=function(){
  const popup=document.getElementById("footerPolicyPopover");
  const backdrop=document.getElementById("footerPolicyBackdrop");
  if(popup) {
    popup.classList.remove("footer-policy-animate");
    popup.hidden=true;
  }
  if(backdrop) backdrop.hidden=true;
  document.body.classList.remove("footer-policy-open");
  document.querySelectorAll(".printify-footer .footer-link-button.active").forEach(button=>button.classList.remove("active"));
};
window.footerCareAction=function(topic,button){
  const key=footerPolicyContent[topic]?topic:"terms";
  const data=footerPolicyContent[key];
  const popup=document.getElementById("footerPolicyPopover");
  const title=document.getElementById("footerPolicyTitle");
  const intro=document.getElementById("footerPolicyIntro");
  const details=document.getElementById("footerPolicyDetails");
  if(!popup||!title||!intro||!details)return;
  title.textContent=data.title;
  const blocks=Array.isArray(data.blocks)?data.blocks:[];
  const escapeHtml=value=>String(value||"").replace(/[&<>"']/g,ch=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#039;"}[ch]));
const renderTextBlock=text=>{
  const value=String(text||"").trim();
  const isHeading=/^(?:\d+(?:\.\d+)*\.?|[IVX]+\.)\s+/.test(value) || /^(?:Frequently Asked Questions \(FAQs\)|Disclaimer)$/.test(value) || /\?$/.test(value);
  return isHeading?`<h3>${escapeHtml(value)}</h3>`:`<p>${escapeHtml(value).replace(/\n/g,"<br>")}</p>`;
};
const renderTable=rows=>{
  const safeRows=(Array.isArray(rows)?rows:[]).filter(row=>Array.isArray(row)&&row.length);
  if(!safeRows.length)return "";
  const first=safeRows[0]||[];
  const hasHeader=first.every(cell=>String(cell||"").length<40);
  const renderCell=(cell,tag)=>`<${tag}>${escapeHtml(cell).replace(/\n/g,"<br>")}</${tag}>`;
  return `<div class="policy-table-wrap"><table class="policy-doc-table">${safeRows.map((row,index)=>`<tr>${
    row.map(cell=>renderCell(cell,hasHeader&&index===0?"th":"td")).join("")
  }</tr>`).join("")}</table></div>`;
};
const renderedBlocks=[];
for(let index=0;index<blocks.length;index+=1){
  const block=blocks[index];
  const value=String(block?.text||"").trim();
  if(block?.type!=="table"&&/^Disclaimer$/i.test(value)){
    const next=blocks[index+1];
    const nextValue=next?.type!=="table"?String(next?.text||"").trim():"";
    renderedBlocks.push(`<section class="policy-disclaimer-block"><h3>${escapeHtml(value)}</h3>${nextValue?`<p>${escapeHtml(nextValue).replace(/\n/g,"<br>")}</p>`:""}</section>`);
    if(nextValue)index+=1;
    continue;
  }
  renderedBlocks.push(block?.type==="table"?renderTable(block.rows):renderTextBlock(block.text));
}
intro.innerHTML=renderedBlocks.join("");
details.innerHTML="";
popup.hidden=false;
popup.classList.remove("footer-policy-animate");
popup.scrollTop=0;
const contentScroller=popup.querySelector(".footer-policy-content");
if(contentScroller)contentScroller.scrollTop=0;
void popup.offsetWidth;
popup.classList.add("footer-policy-animate");
const backdrop=document.getElementById("footerPolicyBackdrop");
if(backdrop) backdrop.hidden=false;
document.body.classList.add("footer-policy-open");
document.querySelectorAll(".printify-footer .footer-link-button.active").forEach(item=>item.classList.remove("active"));
if(button)button.classList.add("active");
};
document.addEventListener("keydown",event=>{
  if(event.key==="Escape")window.footerClosePolicy();
});
window.footerOpenMap=function(){
  window.footerFeedback("Opening map directions...");
  window.open("https://www.google.com/maps/search/?api=1&query=Makati+City+Metro+Manila+Philippines","_blank");
};
</script>
<style id="front-footer-popup-clean-pass-0615">
.printify-footer .footer-logo-image {
  width:92px!important;
  height:92px!important;
  min-width:92px!important;
  padding:4px!important;
  border:3px solid rgba(255,255,255,.96)!important;
  border-radius:50%!important;
  background:rgba(255,255,255,.03)!important;
  overflow:hidden!important;
  box-shadow:0 0 0 2px rgba(255,121,0,.38)!important
}
.printify-footer .footer-logo-image img {
  display:block!important;
  width:100%!important;
  height:100%!important;
  object-fit:contain!important;
  border-radius:50%!important;
  transform:none!important
}
.printify-footer .footer-map-frame {
  cursor:pointer!important
}
.printify-footer .footer-map-frame iframe {
  pointer-events:none!important
}
body.footer-policy-open {
  overflow:hidden!important
}
.footer-policy-backdrop {
  position:fixed!important;
  inset:0!important;
  z-index:9997!important;
  background:rgba(8,13,24,.48)!important;
  backdrop-filter:blur(2px)!important;
  -webkit-backdrop-filter:blur(2px)!important
}
.footer-policy-popover {
  position:fixed!important;
  left:50%!important;
  top:50%!important;
  right:auto!important;
  bottom:auto!important;
  z-index:9998!important;
  width:min(900px,calc(100vw - 96px))!important;
  height:min(76vh,650px)!important;
  max-height:calc(100vh - 88px)!important;
  transform:translate3d(-50%,-50%,0)!important;
  margin:0!important;
  border-radius:18px!important;
  padding:0!important;
  overflow:hidden!important;
  box-shadow:0 28px 80px rgba(0,0,0,.30)!important;
  overscroll-behavior:contain!important;
  contain:layout paint!important;
  opacity:0;
  animation:footerPolicyIn .24s cubic-bezier(.22,1,.36,1) forwards!important
}
.footer-policy-head {
  position:relative!important;
  top:auto!important;
  z-index:2!important;
  max-width:none!important;
  margin:0!important;
  padding:34px 72px 18px 38px!important;
  background:#fff!important;
  border-bottom:1px solid #edf0f4!important
}
.footer-policy-close {
  display:none!important
}
.footer-policy-popover::before {
  content:""!important;
  position:absolute!important;
  top:12px!important;
  left:50%!important;
  transform:translateX(-50%)!important;
  display:block!important;
  width:70px!important;
  height:4px!important;
  border-radius:999px!important;
  background:#737373!important;
  opacity:.7!important;
  margin:0!important
}
.footer-policy-content {
  height:calc(100% - 154px)!important;
  max-height:none!important;
  overflow-y:auto!important;
  overflow-x:hidden!important;
  padding:24px 38px 22px!important;
  display:block!important;
  scrollbar-gutter:stable!important
}
.footer-policy-actions {
  display:flex!important;
  align-items:center!important;
  justify-content:flex-end!important;
  height:72px!important;
  padding:14px 38px!important;
  border-top:1px solid #edf0f4!important;
  background:#fff!important
}
.footer-policy-got-it {
  min-width:190px!important;
  height:40px!important;
  border:0!important;
  border-radius:5px!important;
  background:linear-gradient(90deg,#ff7900,#ff4f16)!important;
  color:#fff!important;
  font-weight:700!important;
  cursor:pointer!important;
  transition:background .18s ease,transform .18s ease!important
}
.footer-policy-got-it:hover,
.footer-policy-got-it:focus {
  background:#111827!important;
  transform:translateY(-1px)!important
}
.footer-policy-primary,
.footer-policy-primary p,
.footer-policy-primary h2,
.footer-policy-primary h3 {
  max-width:100%!important
}
.footer-policy-primary p,
.footer-policy-details p {
  white-space:normal!important;
  overflow-wrap:anywhere!important;
  word-break:normal!important
}
.footer-policy-popover .policy-table-wrap {
  width:min(100%,860px)!important;
  max-width:860px!important;
  margin:16px auto 24px!important;
  overflow-x:auto!important
}
.footer-policy-popover .policy-doc-table {
  width:100%!important;
  min-width:0!important;
  table-layout:fixed!important
}
.footer-policy-popover .policy-doc-table th,
.footer-policy-popover .policy-doc-table td {
  text-align:center!important;
  vertical-align:middle!important;
  overflow-wrap:anywhere!important
}
@media(max-width:1180px) {
  .footer-policy-popover {
    width:calc(100vw - 56px)!important
  }
}
@media(max-width:760px) {
  .footer-policy-popover {
    width:calc(100vw - 28px)!important;
    height:min(82vh,650px)!important
  }
  .footer-policy-head {
    padding:28px 24px 16px!important
  }
  .footer-policy-content {
    padding:20px 24px!important
  }
  .footer-policy-actions {
    padding:14px 24px!important
  }
  .footer-policy-got-it {
    width:100%!important
  }
}
@keyframes footerPolicyIn {
  from {
    opacity:0
  }
  to {
    opacity:1
  }
}
</style>
<style id="front-footer-policy-stable-last-lock-0615">
body.footer-policy-open {
  overflow:auto!important;
  padding-right:0!important;
}
#footerPolicyBackdrop[hidden],
#footerPolicyPopover[hidden] {
  display:none!important;
}
#footerPolicyBackdrop {
  position:fixed!important;
  inset:0!important;
  z-index:9997!important;
  background:rgba(8,13,24,.46)!important;
  backdrop-filter:blur(2px)!important;
  -webkit-backdrop-filter:blur(2px)!important;
}
#footerPolicyPopover {
  position:fixed!important;
  inset:auto!important;
  left:50%!important;
  top:50%!important;
  right:auto!important;
  bottom:auto!important;
  z-index:9998!important;
  width:min(860px,calc(100vw - 96px))!important;
  height:min(74vh,640px)!important;
  max-height:calc(100vh - 88px)!important;
  transform:translate3d(-50%,-50%,0)!important;
  margin:0!important;
  padding:0!important;
  display:flex!important;
  flex-direction:column!important;
  overflow:hidden!important;
  border-radius:18px!important;
  background:#fff!important;
  box-shadow:0 28px 80px rgba(0,0,0,.30)!important;
  opacity:1!important;
  animation:none!important;
  overscroll-behavior:contain!important;
  contain:layout paint!important;
}
#footerPolicyPopover.footer-policy-animate {
  animation:footerPolicyStableIn .22s cubic-bezier(.22,1,.36,1) both!important;
}
#footerPolicyPopover::before {
  content:""!important;
  position:absolute!important;
  top:12px!important;
  left:50%!important;
  transform:translateX(-50%)!important;
  width:70px!important;
  height:4px!important;
  border-radius:999px!important;
  background:#777!important;
  opacity:.75!important;
  z-index:3!important;
}
#footerPolicyPopover .footer-policy-head {
  flex:0 0 auto!important;
  position:relative!important;
  top:auto!important;
  margin:0!important;
  padding:34px 72px 18px 38px!important;
  background:#fff!important;
  border-bottom:1px solid #edf0f4!important;
}
#footerPolicyPopover .footer-policy-close {
  display:none!important;
}
#footerPolicyPopover .footer-policy-content {
  flex:1 1 auto!important;
  min-height:0!important;
  height:auto!important;
  max-height:none!important;
  display:block!important;
  overflow-y:auto!important;
  overflow-x:hidden!important;
  padding:24px 38px 22px!important;
  scrollbar-gutter:stable!important;
}
#footerPolicyPopover .footer-policy-actions {
  flex:0 0 72px!important;
  height:72px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:flex-end!important;
  padding:14px 38px!important;
  border-top:1px solid #edf0f4!important;
  background:#fff!important;
}
#footerPolicyPopover .policy-table-wrap {
  width:min(100%,820px)!important;
  max-width:820px!important;
  margin:16px auto 24px!important;
  overflow-x:auto!important;
}
#footerPolicyPopover .policy-doc-table {
  width:100%!important;
  min-width:0!important;
  table-layout:fixed!important;
}
#footerPolicyPopover .policy-doc-table th,
#footerPolicyPopover .policy-doc-table td {
  text-align:center!important;
  vertical-align:middle!important;
  overflow-wrap:anywhere!important;
}
@keyframes footerPolicyStableIn {
  from {
    opacity:0;
    transform:translate3d(-50%,calc(-50% + 14px),0) scale(.985);
  }
  to {
    opacity:1;
    transform:translate3d(-50%,-50%,0) scale(1);
  }
}
@media(max-width:760px) {
  #footerPolicyPopover {
    width:calc(100vw - 28px)!important;
    height:min(82vh,650px)!important;
  }
  #footerPolicyPopover .footer-policy-head,
  #footerPolicyPopover .footer-policy-content,
  #footerPolicyPopover .footer-policy-actions {
    padding-left:24px!important;
    padding-right:24px!important;
  }
  #footerPolicyPopover .footer-policy-got-it {
    width:100%!important;
  }
}
#footerPolicyPopover .policy-disclaimer-block {
  margin:18px 0 10px!important;
  padding:12px 14px!important;
  border-left:4px solid #ff7a00!important;
  border-radius:7px!important;
  background:#fff3e8!important;
  color:#111827!important;
}
#footerPolicyPopover .policy-disclaimer-block h3{
  margin:0 0 8px!important;
  color:#111827!important;
}
#footerPolicyPopover .policy-disclaimer-block p{
  margin:0!important;
  color:#4b5563!important;
}
</style>

<!-- =========================================================
  FINAL CUSTOMER CARE MODAL TEMPLATE PATCH
  Applies one clean template to Privacy Policy, Terms & Conditions,
  Refund Policy, and FAQ. Bottom action has no divider line, the
  button stays inside the modal, top header remains compact with a
  small border, and important notes are highlighted automatically.
========================================================= -->
<style id="front-footer-customer-care-final-template-0622">
body.footer-policy-open {
  overflow:auto!important;
  padding-right:0!important;
}
#footerPolicyBackdrop[hidden],
#footerPolicyPopover[hidden] {
  display:none!important;
}
#footerPolicyBackdrop {
  position:fixed!important;
  inset:0!important;
  z-index:9997!important;
  background:rgba(8,13,24,.48)!important;
  backdrop-filter:blur(2px)!important;
  -webkit-backdrop-filter:blur(2px)!important;
}
#footerPolicyPopover {
  position:fixed!important;
  inset:auto!important;
  left:50%!important;
  top:50%!important;
  right:auto!important;
  bottom:auto!important;
  z-index:9998!important;
  width:min(900px,calc(100vw - 96px))!important;
  height:min(76vh,650px)!important;
  max-height:calc(100vh - 88px)!important;
  transform:translate3d(-50%,-50%,0)!important;
  margin:0!important;
  padding:0!important;
  display:flex!important;
  flex-direction:column!important;
  overflow:hidden!important;
  border-radius:18px!important;
  background:#fff!important;
  color:#111827!important;
  border:1px solid rgba(15,23,42,.08)!important;
  box-shadow:0 28px 80px rgba(0,0,0,.30)!important;
  opacity:1!important;
  animation:none!important;
  overscroll-behavior:contain!important;
  contain:layout paint!important;
}
#footerPolicyPopover.footer-policy-animate {
  animation:footerPolicyFinalIn .22s cubic-bezier(.22,1,.36,1) both!important;
}
#footerPolicyPopover::before {
  content:""!important;
  position:absolute!important;
  top:10px!important;
  left:50%!important;
  transform:translateX(-50%)!important;
  width:64px!important;
  height:4px!important;
  border-radius:999px!important;
  background:#ff7900!important;
  opacity:.92!important;
  z-index:4!important;
}
#footerPolicyPopover .footer-policy-handle,
#footerPolicyPopover .footer-policy-close {
  display:none!important;
}
#footerPolicyPopover .footer-policy-head {
  flex:0 0 auto!important;
  position:relative!important;
  top:auto!important;
  z-index:3!important;
  margin:0!important;
  padding:24px 72px 12px 34px!important;
  display:flex!important;
  align-items:center!important;
  gap:12px!important;
  background:#fff!important;
  border-bottom:1px solid #e9edf3!important;
}
#footerPolicyPopover .footer-policy-icon {
  width:42px!important;
  height:42px!important;
  min-width:42px!important;
  border-radius:999px!important;
  display:grid!important;
  place-items:center!important;
  background:#fff2e8!important;
  color:#ff7900!important;
  font-size:20px!important;
}
#footerPolicyPopover .footer-policy-head strong {
  display:block!important;
  margin:0 0 3px!important;
  color:#111827!important;
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-size:13px!important;
  line-height:1!important;
  font-weight:900!important;
  letter-spacing:.08em!important;
}
#footerPolicyPopover .footer-policy-head p {
  margin:0!important;
  color:#4b5563!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:12px!important;
  line-height:1.2!important;
  font-weight:500!important;
}
#footerPolicyPopover .footer-policy-content {
  flex:1 1 auto!important;
  min-height:0!important;
  height:auto!important;
  max-height:none!important;
  display:block!important;
  overflow-y:auto!important;
  overflow-x:hidden!important;
  padding:22px 34px 14px!important;
  background:#fff!important;
  scrollbar-gutter:stable!important;
}
#footerPolicyPopover .footer-policy-actions {
  flex:0 0 62px!important;
  height:62px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:flex-end!important;
  gap:12px!important;
  padding:10px 34px 18px!important;
  border-top:0!important;
  background:#fff!important;
}
#footerPolicyPopover .footer-policy-got-it {
  min-width:150px!important;
  height:38px!important;
  padding:0 28px!important;
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(90deg,#ff7900,#ff5a14)!important;
  color:#fff!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:12px!important;
  font-weight:800!important;
  cursor:pointer!important;
  box-shadow:0 8px 18px rgba(255,121,0,.18)!important;
  transition:transform .16s ease,box-shadow .16s ease,background .16s ease!important;
}
#footerPolicyPopover .footer-policy-got-it:hover,
#footerPolicyPopover .footer-policy-got-it:focus {
  transform:translateY(-1px)!important;
  background:linear-gradient(90deg,#ff8a18,#ff5a14)!important;
  box-shadow:0 10px 22px rgba(255,121,0,.25)!important;
  outline:0!important;
}
#footerPolicyPopover .footer-policy-got-it:disabled {
  cursor:wait!important;
  opacity:.72!important;
  transform:none!important;
}
#footerPolicyPopover .footer-policy-primary,
#footerPolicyPopover .footer-policy-primary p,
#footerPolicyPopover .footer-policy-primary h2,
#footerPolicyPopover .footer-policy-primary h3 {
  max-width:100%!important;
}
#footerPolicyPopover .footer-policy-primary h2 {
  margin:0 0 18px!important;
  color:#111827!important;
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-size:31px!important;
  line-height:1!important;
  font-weight:900!important;
  letter-spacing:.01em!important;
}
#footerPolicyPopover .footer-policy-primary h3 {
  margin:18px 0 8px!important;
  color:#111827!important;
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-size:16px!important;
  line-height:1.22!important;
  font-weight:900!important;
}
#footerPolicyPopover .footer-policy-primary p,
#footerPolicyPopover .footer-policy-details p {
  margin:0 0 14px!important;
  color:#111827!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:13px!important;
  line-height:1.55!important;
  font-weight:400!important;
  white-space:normal!important;
  overflow-wrap:anywhere!important;
  word-break:normal!important;
}
#footerPolicyPopover .policy-highlight-note,
#footerPolicyPopover .policy-disclaimer-block {
  margin:14px 0!important;
  padding:12px 14px!important;
  border:1px solid rgba(255,121,0,.22)!important;
  border-left:4px solid #ff7900!important;
  border-radius:12px!important;
  background:#fff4e8!important;
  color:#111827!important;
  box-shadow:0 8px 20px rgba(255,121,0,.06)!important;
}
#footerPolicyPopover .policy-highlight-note .policy-highlight-label {
  display:inline-flex!important;
  align-items:center!important;
  gap:6px!important;
  margin:0 0 6px!important;
  color:#e86100!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:11px!important;
  line-height:1!important;
  font-weight:900!important;
  letter-spacing:.04em!important;
  text-transform:uppercase!important;
}
#footerPolicyPopover .policy-highlight-note p,
#footerPolicyPopover .policy-disclaimer-block p {
  margin:0!important;
  color:#374151!important;
}
#footerPolicyPopover .policy-disclaimer-block h3 {
  margin:0 0 8px!important;
  color:#111827!important;
}
#footerPolicyPopover .policy-table-wrap {
  width:min(100%,820px)!important;
  max-width:820px!important;
  margin:14px auto 22px!important;
  overflow-x:auto!important;
  border:1px solid #dfe3ea!important;
  border-radius:12px!important;
  background:#fff!important;
}
#footerPolicyPopover .policy-doc-table {
  width:100%!important;
  min-width:0!important;
  table-layout:fixed!important;
  border-collapse:collapse!important;
}
#footerPolicyPopover .policy-doc-table th,
#footerPolicyPopover .policy-doc-table td {
  text-align:center!important;
  vertical-align:middle!important;
  overflow-wrap:anywhere!important;
  border:1px solid #dfe3ea!important;
  padding:10px 12px!important;
  font-size:12px!important;
  line-height:1.4!important;
}
#footerPolicyPopover .policy-doc-table th {
  background:#fff4ec!important;
  color:#111827!important;
  font-weight:900!important;
}
#footerPolicyPopover .footer-policy-content::-webkit-scrollbar {
  width:9px!important;
}
#footerPolicyPopover .footer-policy-content::-webkit-scrollbar-track {
  background:#f3f4f6!important;
  border-radius:999px!important;
}
#footerPolicyPopover .footer-policy-content::-webkit-scrollbar-thumb {
  background:#9ca3af!important;
  border-radius:999px!important;
  border:2px solid #f3f4f6!important;
}
@keyframes footerPolicyFinalIn {
  from {
    opacity:0;
    transform:translate3d(-50%,calc(-50% + 12px),0) scale(.985);
  }
  to {
    opacity:1;
    transform:translate3d(-50%,-50%,0) scale(1);
  }
}
@media(max-width:760px) {
  #footerPolicyPopover {
    width:calc(100vw - 28px)!important;
    height:min(82vh,650px)!important;
  }
  #footerPolicyPopover .footer-policy-head {
    padding:24px 24px 12px!important;
  }
  #footerPolicyPopover .footer-policy-content {
    padding:20px 24px 12px!important;
  }
  #footerPolicyPopover .footer-policy-actions {
    padding:10px 24px 16px!important;
  }
  #footerPolicyPopover .footer-policy-got-it {
    width:100%!important;
  }
}
</style>

<script id="front-footer-customer-care-final-functions-0622">
(function(){
  const ACK_URL = "{{ route('customer-care.policy.acknowledge') }}";
  const getCsrfToken = () => {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : "{{ csrf_token() }}";
  };
  const escapeHtml = value => String(value || "").replace(/[&<>"']/g, ch => ({
    "&":"&amp;", "<":"&lt;", ">":"&gt;", "\"":"&quot;", "'":"&#039;"
  }[ch]));
  const isHeadingText = value => /^(?:\d+(?:\.\d+)*\.?|[IVX]+\.)\s+/.test(value)
    || /^(?:Frequently Asked Questions \(FAQs\)|Disclaimer|Overview and Important Notice)$/i.test(value)
    || /\?$/.test(value);
  const isImportantText = value => {
    const text = String(value || "").trim();
    if(!text || isHeadingText(text)) return false;
    return [
      /^note\s*:/i,
      /^important/i,
      /^disclaimer$/i,
      /no return,?\s*no exchange/i,
      /does not collect or store/i,
      /does not sell|rent|trade/i,
      /strictly prohibited|strictly non-refundable/i,
      /must report|must provide|must contact|must be reviewed|must be resolved/i,
      /required documentation|required by law|required to/i,
      /within\s+(?:seven|7|seventy-two|72|five|5|two|2)/i,
      /not liable|not responsible|not a party|does not process|does not produce/i,
      /Data Privacy Act|Consumer Act|National Privacy Commission|DTI/i,
      /qualified legal professional|prototype purposes|capstone project/i
    ].some(pattern => pattern.test(text));
  };
  const renderTextBlock = text => {
    const value = String(text || "").trim();
    if(!value) return "";
    if(isHeadingText(value)) return `<h3>${escapeHtml(value)}</h3>`;
    if(isImportantText(value)) {
      return `<div class="policy-highlight-note"><span class="policy-highlight-label"><i class="fa-solid fa-circle-info"></i> Important Note</span><p>${escapeHtml(value).replace(/\n/g,"<br>")}</p></div>`;
    }
    return `<p>${escapeHtml(value).replace(/\n/g,"<br>")}</p>`;
  };
  const renderTable = rows => {
    const safeRows = (Array.isArray(rows) ? rows : []).filter(row => Array.isArray(row) && row.length);
    if(!safeRows.length) return "";
    const first = safeRows[0] || [];
    const hasHeader = first.every(cell => String(cell || "").length < 40);
    const renderCell = (cell, tag) => `<${tag}>${escapeHtml(cell).replace(/\n/g,"<br>")}</${tag}>`;
    return `<div class="policy-table-wrap"><table class="policy-doc-table">${safeRows.map((row,index) => `<tr>${row.map(cell => renderCell(cell, hasHeader && index === 0 ? "th" : "td")).join("")}</tr>`).join("")}</table></div>`;
  };
  const renderPolicyBlocks = blocks => {
    const renderedBlocks = [];
    for(let index = 0; index < blocks.length; index += 1) {
      const block = blocks[index];
      const value = String(block?.text || "").trim();
      if(block?.type !== "table" && /^Disclaimer$/i.test(value)) {
        const next = blocks[index + 1];
        const nextValue = next?.type !== "table" ? String(next?.text || "").trim() : "";
        renderedBlocks.push(`<section class="policy-disclaimer-block"><h3>${escapeHtml(value)}</h3>${nextValue ? `<p>${escapeHtml(nextValue).replace(/\n/g,"<br>")}</p>` : ""}</section>`);
        if(nextValue) index += 1;
        continue;
      }
      renderedBlocks.push(block?.type === "table" ? renderTable(block.rows) : renderTextBlock(block.text));
    }
    return renderedBlocks.join("");
  };
  window.footerCareAction = function(topic, button) {
    if(typeof footerPolicyContent === "undefined") return;
    const key = footerPolicyContent[topic] ? topic : "terms";
    const data = footerPolicyContent[key];
    const popup = document.getElementById("footerPolicyPopover");
    const title = document.getElementById("footerPolicyTitle");
    const intro = document.getElementById("footerPolicyIntro");
    const details = document.getElementById("footerPolicyDetails");
    const backdrop = document.getElementById("footerPolicyBackdrop");
    if(!popup || !title || !intro || !details) return;
    window.footerPolicyCurrentTopic = key;
    title.textContent = data.title || "Customer Care";
    intro.innerHTML = renderPolicyBlocks(Array.isArray(data.blocks) ? data.blocks : []);
    details.innerHTML = "";
    popup.hidden = false;
    popup.setAttribute("data-policy", key);
    popup.classList.remove("footer-policy-animate");
    popup.scrollTop = 0;
    const contentScroller = popup.querySelector(".footer-policy-content");
    if(contentScroller) contentScroller.scrollTop = 0;
    void popup.offsetWidth;
    popup.classList.add("footer-policy-animate");
    if(backdrop) backdrop.hidden = false;
    document.body.classList.add("footer-policy-open");
    document.querySelectorAll(".printify-footer .footer-link-button.active").forEach(item => item.classList.remove("active"));
    if(button) button.classList.add("active");
    const gotIt = popup.querySelector(".footer-policy-got-it");
    if(gotIt) gotIt.onclick = window.footerAcknowledgePolicy;
  };
  window.footerAcknowledgePolicy = async function() {
    const topic = window.footerPolicyCurrentTopic || "unknown";
    const button = document.querySelector("#footerPolicyPopover .footer-policy-got-it");
    const originalText = button ? button.textContent : "Got it";
    if(button) {
      button.disabled = true;
      button.textContent = "Saving...";
    }
    try {
      await fetch(ACK_URL, {
        method:"POST",
        credentials:"same-origin",
        headers:{
          "Content-Type":"application/json",
          "Accept":"application/json",
          "X-CSRF-TOKEN":getCsrfToken()
        },
        body:JSON.stringify({ topic })
      });
    } catch(error) {
      // Close the modal even if the backend endpoint is unavailable during local UI testing.
      console.warn("Customer care acknowledgement was not saved.", error);
    } finally {
      if(button) {
        button.disabled = false;
        button.textContent = originalText;
      }
      if(typeof window.footerClosePolicy === "function") window.footerClosePolicy();
    }
  };
  document.addEventListener("DOMContentLoaded", function(){
    const gotIt = document.querySelector("#footerPolicyPopover .footer-policy-got-it");
    if(gotIt) gotIt.onclick = window.footerAcknowledgePolicy;
  });
})();
</script>


<!-- =========================================================
  FINAL CUSTOMER CARE HOTFIX 0622B
  - Smaller orange gradient button, no border
  - Hover color becomes black
  - Background page scroll locked when modal opens
  - Only the modal content area scrolls
========================================================= -->
<style id="front-footer-customer-care-hotfix-0622b">
html.footer-policy-open,
body.footer-policy-open {
  overflow:hidden!important;
  overscroll-behavior:none!important;
}
body.footer-policy-open {
  position:fixed!important;
  width:100%!important;
  left:0!important;
  right:0!important;
}
#footerPolicyBackdrop {
  touch-action:none!important;
}
#footerPolicyPopover {
  overscroll-behavior:contain!important;
}
#footerPolicyPopover .footer-policy-content {
  overflow-y:auto!important;
  overflow-x:hidden!important;
  -webkit-overflow-scrolling:touch!important;
}
#footerPolicyPopover .footer-policy-actions {
  padding:10px 34px 16px!important;
  border-top:0!important;
  background:#fff!important;
}
#footerPolicyPopover .footer-policy-got-it {
  width:auto!important;
  min-width:128px!important;
  height:34px!important;
  padding:0 20px!important;
  border:none!important;
  outline:none!important;
  border-radius:999px!important;
  background:linear-gradient(90deg,#ff7900 0%,#ff5a14 100%)!important;
  color:#ffffff!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:12px!important;
  font-weight:800!important;
  line-height:1!important;
  letter-spacing:.01em!important;
  box-shadow:0 6px 14px rgba(255,121,0,.18)!important;
  transition:background .16s ease, transform .16s ease, box-shadow .16s ease!important;
}
#footerPolicyPopover .footer-policy-got-it:hover,
#footerPolicyPopover .footer-policy-got-it:focus {
  background:#111111!important;
  color:#ffffff!important;
  border:none!important;
  outline:none!important;
  transform:translateY(-1px)!important;
  box-shadow:0 8px 16px rgba(17,17,17,.18)!important;
}
#footerPolicyPopover .footer-policy-got-it:disabled {
  background:linear-gradient(90deg,#ff7900 0%,#ff5a14 100%)!important;
  opacity:.78!important;
  box-shadow:none!important;
}
@media(max-width:760px){
  #footerPolicyPopover .footer-policy-actions {
    padding:10px 24px 14px!important;
  }
  #footerPolicyPopover .footer-policy-got-it {
    min-width:118px!important;
    height:33px!important;
    padding:0 18px!important;
  }
}
</style>

<script id="front-footer-customer-care-scroll-lock-hotfix-0622b">
(function(){
  const originalOpen = window.footerCareAction;
  const originalClose = window.footerClosePolicy;

  function lockBackgroundScroll(){
    const body = document.body;
    const root = document.documentElement;
    if(body.dataset.footerPolicyLocked === '1') return;
    const scrollY = window.scrollY || window.pageYOffset || root.scrollTop || 0;
    body.dataset.footerPolicyLocked = '1';
    body.dataset.footerPolicyScrollY = String(scrollY);
    body.style.top = `-${scrollY}px`;
    body.style.left = '0';
    body.style.right = '0';
    body.style.width = '100%';
    body.classList.add('footer-policy-open');
    root.classList.add('footer-policy-open');
  }

  function unlockBackgroundScroll(){
    const body = document.body;
    const root = document.documentElement;
    const scrollY = parseInt(body.dataset.footerPolicyScrollY || '0', 10) || 0;
    body.classList.remove('footer-policy-open');
    root.classList.remove('footer-policy-open');
    body.style.top = '';
    body.style.left = '';
    body.style.right = '';
    body.style.width = '';
    delete body.dataset.footerPolicyLocked;
    delete body.dataset.footerPolicyScrollY;
    window.scrollTo(0, scrollY);
  }

  window.footerCareAction = function(topic, button){
    if(typeof originalOpen === 'function') {
      originalOpen(topic, button);
    }
    lockBackgroundScroll();
  };

  window.footerClosePolicy = function(){
    if(typeof originalClose === 'function') {
      originalClose();
    }
    unlockBackgroundScroll();
  };

  document.addEventListener('DOMContentLoaded', function(){
    const backdrop = document.getElementById('footerPolicyBackdrop');
    if(backdrop){
      backdrop.addEventListener('wheel', function(event){ event.preventDefault(); }, { passive:false });
      backdrop.addEventListener('touchmove', function(event){ event.preventDefault(); }, { passive:false });
    }
  });
})();
</script>


<!-- =========================================================
  FINAL CUSTOMER CARE FOOTER BACKGROUND LOCK 0622C
  When any Customer Care item in the footer is opened, the page
  first anchors to the footer area, then locks the background there.
  This keeps the outer/backdrop background steady on the footer section.
========================================================= -->
<script id="front-footer-customer-care-footer-anchor-lock-0622c">
(function(){
  const previousFooterCareAction = window.footerCareAction;

  function getFooterScrollTarget(button){
    const footerFromButton = button && typeof button.closest === 'function'
      ? button.closest('.printify-footer')
      : null;
    return footerFromButton || document.querySelector('.printify-footer');
  }

  function keepFooterBehindModal(button){
    const footer = getFooterScrollTarget(button);
    if(!footer) return;

    const footerRect = footer.getBoundingClientRect();
    const footerHeight = Math.max(footerRect.height, 1);
    const viewportHeight = window.innerHeight || document.documentElement.clientHeight || 1;
    const currentScroll = window.scrollY || window.pageYOffset || document.documentElement.scrollTop || 0;

    /*
      Keep the footer section visible behind the modal:
      - If footer is already visible, do not jump.
      - If footer is not visible or only partly visible, move the page so the footer
        area is steady behind the modal before the backdrop is shown.
    */
    const footerVisibleEnough = footerRect.top < viewportHeight * 0.72 && footerRect.bottom > viewportHeight * 0.28;

    if(!footerVisibleEnough){
      const footerTop = footerRect.top + currentScroll;
      const targetScroll = Math.max(0, footerTop - Math.max(24, (viewportHeight - footerHeight) / 2));
      window.scrollTo({ top: targetScroll, left: 0, behavior: 'auto' });
    }
  }

  window.footerCareAction = function(topic, button){
    keepFooterBehindModal(button);

    /*
      Use requestAnimationFrame so the browser finishes placing the footer in the
      background before the existing modal template opens and locks scrolling.
    */
    window.requestAnimationFrame(function(){
      if(typeof previousFooterCareAction === 'function'){
        previousFooterCareAction(topic, button);
      }
    });
  };
})();
</script>


<!-- =========================================================
  FINAL CUSTOMER CARE FOOTER ANCHOR FIX 0622D
  This force-locks the modal background on the CONTACT US + FOOTER area.
  It resets any previous modal scroll-lock, moves the page so the footer
  is visible at the bottom of the viewport, then opens the modal and locks
  the page in that exact position.
========================================================= -->
<script id="front-footer-customer-care-force-footer-bg-0622d">
(function(){
  const previousOpen = window.footerCareAction;

  function resetPolicyScrollLockBeforeReposition(){
    const body = document.body;
    const root = document.documentElement;
    body.classList.remove('footer-policy-open');
    root.classList.remove('footer-policy-open');
    body.style.position = '';
    body.style.top = '';
    body.style.left = '';
    body.style.right = '';
    body.style.width = '';
    delete body.dataset.footerPolicyLocked;
    delete body.dataset.footerPolicyScrollY;
  }

  function findFooter(button){
    if(button && typeof button.closest === 'function'){
      const footerFromButton = button.closest('.printify-footer');
      if(footerFromButton) return footerFromButton;
    }
    return document.querySelector('.printify-footer');
  }

  function placeContactAndFooterBehindModal(button){
    const footer = findFooter(button);
    if(!footer) return;

    resetPolicyScrollLockBeforeReposition();

    const viewportHeight = window.innerHeight || document.documentElement.clientHeight || 1;
    const currentScroll = window.scrollY || window.pageYOffset || document.documentElement.scrollTop || 0;
    const footerRect = footer.getBoundingClientRect();
    const footerTop = footerRect.top + currentScroll;
    const footerHeight = Math.max(footerRect.height, 1);

    /*
      Target layout:
      - Contact area remains visible above.
      - Footer stays visible at the bottom/background.
      - When the modal opens, this viewport is locked and cannot scroll.
    */
    const visibleFooterHeight = Math.min(footerHeight, viewportHeight * 0.38);
    const targetScroll = Math.max(0, footerTop - viewportHeight + visibleFooterHeight + 24);

    window.scrollTo({ top: targetScroll, left: 0, behavior: 'auto' });
  }

  window.footerCareAction = function(topic, button){
    placeContactAndFooterBehindModal(button);

    window.requestAnimationFrame(function(){
      window.requestAnimationFrame(function(){
        if(typeof previousOpen === 'function'){
          previousOpen(topic, button);
        }
      });
    });
  };
})();
</script>
