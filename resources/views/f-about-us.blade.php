<style>
#about.about-premium-page {
  display:block;
  background:#fff;
  color:#111;
  font-family:'Inter',sans-serif;
  font-weight:400;
  letter-spacing:.1px;
  overflow:visible;
  scroll-margin-top:95px
}
#about * {
  box-sizing:border-box
}
#about .about-wrap {
  width:min(1270px,calc(100% - 118px));
  max-width:1270px;
  margin:0 18px 0 100px;
  padding:40px 0 70px
}
#about .about-layout {
  display:grid;
  grid-template-columns:minmax(360px,500px) minmax(0,1fr);
  gap:25px;
  align-items:start
}
#about .section-label {
  margin:0 0 9px;
  color:#ff5a12;
  font-size:11px;
  font-weight:600;
  letter-spacing:2px;
  text-transform:uppercase
}
#about .about-heading {
  margin:0;
  color:#111;
  font-family:'League Spartan',serif;
  font-size:28px;
  line-height:1.12;
  font-weight:700;
  letter-spacing:0
}
#about .orange-line {
  width:42px;
  height:3px;
  margin:12px 0 17px;
  border-radius:99px;
  background:#ff5a12
}
#about .story-text {
  margin:0;
  color:#555;
  font-size:12px;
  line-height:1.38
}
#about .mission-card {
  width:100%;
  padding:12px;
  min-height:650px;
  border:1px solid #111;
  border-radius:12px;
  background:#fff;
  box-shadow:none!important
}
#about .mission-card:hover {
  background:#fff;
  box-shadow:none!important
}
#about .mission-card>p:not(.section-label) {
  margin:0;
  color:#555;
  font-size:12px;
  line-height:1.38
}
#about .mv-tabs {
  width:min(100%,430px);
  margin:16px auto 14px;
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:14px;
  align-items:center;
  justify-content:center
}
#about .mv-tab {
  width:100%;
  height:34px;
  border:0!important;
  border-radius:10px;
  background:#ff7a00;
  color:#111827;
  cursor:pointer;
  font-family:'Inter',sans-serif;
  font-size:11px;
  font-weight:600;
  letter-spacing:0;
  text-align:center;
  display:flex;
  align-items:center;
  justify-content:center;
  box-shadow:none!important;
  transition:background-color .22s ease,color .22s ease
}
#about .mv-tab:nth-child(2),#about .mv-tab:nth-child(3) {
  background:#ff7a00;
  color:#111827
}
#about .mv-tab.active,#about .mv-tab:hover {
  background:#111827!important;
  color:#fff!important
}
#about .mv-content {
  width:min(100%,470px);
  margin:0 auto;
  padding:14px 15px;
  border-radius:15px;
  background:#fff7f2;
  border:1px solid #ffe1d2;
  min-height:124px
}
#about .mv-content h3 {
  margin:0 0 7px;
  color:#111;
  font-family:'Inter',sans-serif;
  font-size:17px;
  font-weight:600
}
#about .mv-content p {
  margin:0 0 9px;
  color:#555;
  font-size:12px;
  line-height:1.38
}
#about .mv-content p:last-child {
  margin-bottom:0
}
#about .check-grid {
  margin-top:13px;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:8px 16px
}
#about .check-item {
  color:#333;
  font-size:12px;
  font-weight:600
}
#about .check-item i {
  color:#ff5a12;
  margin-right:8px
}
#about .stat-cta-box {
  width:100%;
  margin-top:14px;
  padding:0;
  border:0;
  background:transparent;
  box-shadow:none!important
}
#about .mini-stats {
  width:100%;
  padding:0;
  border:0;
  border-radius:0;
  background:transparent;
  box-shadow:none;
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:8px
}
#about .mini-stat {
  display:flex;
  align-items:flex-start;
  gap:8px;
  min-height:58px;
  padding:8px 9px;
  border-radius:10px;
  background:#fff8f4
}
#about .mini-icon {
  width:28px;
  height:28px;
  min-width:28px;
  border-radius:50%;
  display:grid;
  place-items:center;
  background:transparent;
  color:#ff7a00;
  font-size:12px
}
#about .stat-number {
  display:block;
  color:#111;
  font-size:12px;
  font-weight:700;
  line-height:1.15
}
#about .stat-label {
  display:block;
  margin-top:3px;
  color:#666;
  font-size:9.5px;
  line-height:1.25
}
#about .about-cta {
  margin-top:8px;
  padding:8px 0 0;
  border-top:1px solid #f1e7df;
  display:grid;
  grid-template-columns:minmax(0,1fr) auto;
  align-items:center;
  gap:10px
}
#about .about-cta h3 {
  margin:0;
  color:#111;
  font-family:'Inter',sans-serif;
  font-size:13px;
  font-weight:600
}
#about .about-cta p {
  margin:4px 0 0;
  color:#666;
  font-size:10px;
  line-height:1.3
}
#about .about-cta-btn {
  width:156px;
  height:34px;
  padding:0 14px;
  border:0!important;
  border-radius:10px;
  background:#ff7a00;
  color:#111827;
  font-family:'Inter',sans-serif;
  font-size:9.5px;
  font-weight:900;
  cursor:pointer;
  white-space:nowrap;
  box-shadow:none!important;
  transition:background-color .22s ease,color .22s ease
}
#about .about-cta-btn:hover {
  background:#111827!important;
  color:#fff!important
}
#about .right-showcase {
  display:flex;
  flex-direction:column;
  gap:12px
}
#about .values-grid {
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:12px
}
#about .value-card {
  min-height:104px;
  padding:11px 12px;
  border-radius:10px;
  background:#fff;
  box-shadow:none!important;
  cursor:pointer;
  transition:.22s ease
}
#about .value-card:nth-child(1) {
  border:1px solid #ff5b5b
}
#about .value-card:nth-child(2) {
  border:1px solid #18b8bd
}
#about .value-card:nth-child(3) {
  border:1px solid #f2bd2f
}
#about .value-card:nth-child(4) {
  border:1px solid #f05aa2
}
#about .value-card:hover,#about .value-card.is-active {
  transform:none!important;
  background:#fff!important;
  box-shadow:none!important
}
#about .value-icon {
  width:28px;
  height:28px;
  margin-bottom:8px;
  border-radius:50%;
  display:grid;
  place-items:center;
  font-size:17px;
  background:transparent!important;
  box-shadow:none!important
}
#about .orange {
  color:#ff1744!important;
  background:transparent!important
}
#about .blue {
  color:#009da5!important;
  background:transparent!important
}
#about .green {
  color:#e8a600!important;
  background:transparent!important
}
#about .purple {
  color:#e91e63!important;
  background:transparent!important
}
#about .value-card h3 {
  margin:0 0 5px;
  color:#111;
  font-size:12px;
  font-family:'Inter',sans-serif;
  font-weight:600
}
#about .value-card p {
  margin:0;
  color:#626262;
  font-size:10.5px;
  line-height:1.35
}
#about .top-gallery {
  position:relative;
  display:grid;
  grid-template-columns:1.15fr .85fr;
  grid-template-rows:110px 110px;
  gap:8px
}
#about .photo-box {
  overflow:hidden;
  border-radius:9px;
  background:#f7f7f7;
  border:0;
  box-shadow:none!important
}
#about .photo-box.large {
  grid-row:1/3
}
#about .photo-box img {
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
  transition:.35s ease
}
#about .photo-box:hover img {
  transform:scale(1.05)
}
#about .commit-badge {
  position:absolute;
  left:12px;
  bottom:12px;
  width:160px;
  padding:12px;
  border-radius:10px;
  color:#fff;
  background:#ff7a00;
  box-shadow:none!important
}
#about .commit-badge i {
  width:30px;
  height:30px;
  margin-bottom:6px;
  border-radius:50%;
  display:grid;
  place-items:center;
  background:transparent!important;
  color:#111827;
  box-shadow:none!important
}
#about .commit-badge strong {
  display:block;
  font-size:12.5px;
  font-family:'Inter',sans-serif;
  font-weight:600
}
#about .commit-badge small {
  display:block;
  margin-top:6px;
  font-size:10.5px;
  line-height:1.42
}
#about .about-process-strip {
  width:100%;
  padding:0;
  border:0;
  border-radius:0;
  background:transparent;
  box-shadow:none!important;
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:10px;
  position:relative;
  margin-top:2px
}
#about .process-step {
  position:relative;
  min-height:78px;
  padding:15px 10px 11px 48px;
  border-radius:10px;
  background:#fff;
  box-shadow:none!important
}
#about .process-step:nth-child(1) {
  border:1px solid #2997ff
}
#about .process-step:nth-child(2) {
  border:1px solid #33b94f
}
#about .process-step:nth-child(3) {
  border:1px solid #ff8c28
}
#about .process-step:nth-child(4) {
  border:1px solid #7c4dff
}
#about .process-step:hover {
  background:#fff
}
#about .process-num {
  position:absolute;
  left:18px;
  top:13px;
  width:auto;
  height:auto;
  background:transparent!important;
  color:#111827;
  font-size:10px;
  font-weight:700;
  box-shadow:none!important
}
#about .process-step i {
  position:absolute;
  left:16px;
  top:35px;
  font-size:20px
}
#about .process-step:nth-child(1) .process-num,#about .process-step:nth-child(1) i {
  color:#2997ff!important
}
#about .process-step:nth-child(2) .process-num,#about .process-step:nth-child(2) i {
  color:#33b94f!important
}
#about .process-step:nth-child(3) .process-num,#about .process-step:nth-child(3) i {
  color:#ff8c28!important
}
#about .process-step:nth-child(4) .process-num,#about .process-step:nth-child(4) i {
  color:#7c4dff!important
}
#about .process-step h3 {
  margin:0 0 4px;
  font-family:'Inter',sans-serif;
  font-size:12px;
  font-weight:600;
  color:#111
}
#about .process-step p {
  margin:0;
  color:#555;
  font-size:9.4px;
  line-height:1.25
}
#about .story-card {
  width:100%;
  padding:10px 4px 15px;
  border:0;
  border-radius:0;
  background:transparent;
  box-shadow:none!important;
  display:grid;
  grid-template-columns:1fr auto;
  column-gap:18px;
  align-items:end;
  margin-top:0
}
#about .story-card:hover {
  background:#fff;
  box-shadow:none!important
}
#about .story-card .section-label,#about .story-card .about-heading,#about .story-card .orange-line,#about .story-card .story-text,#about .story-card .about-more {
  grid-column:1 / 2
}
#about .story-card .orange-line {
  margin:8px 0 10px
}
#about .about-outline-btn {
  grid-column:2 / 3;
  grid-row:4 / 5;
  justify-self:end;
  align-self:end;
  width:156px;
  height:34px;
  padding:0 14px;
  border:0!important;
  border-radius:10px;
  color:#111827;
  background:#ff7a00;
  cursor:pointer;
  font-family:'Inter',sans-serif;
  font-size:9.5px;
  font-weight:900;
  white-space:nowrap;
  box-shadow:none!important;
  transition:background-color .22s ease,color .22s ease
}
#about .about-outline-btn:hover {
  background:#111827!important;
  color:#fff!important
}
#about .about-more {
  display:none;
  margin-top:9px;
  padding:10px 12px;
  border:1px solid #ffe0d2;
  border-radius:13px;
  background:#fff7f2;
  color:#444;
  font-size:11.5px;
  line-height:1.45
}
#about .about-more.show {
  display:block
}
#about .about-feedback {
  position:fixed;
  top:18px;
  left:50%;
  z-index:9999;
  transform:translate(-50%,-18px);
  min-width:260px;
  max-width:calc(100% - 32px);
  padding:10px 16px;
  border-radius:999px;
  background:#111827;
  color:#fff;
  font-family:'Inter',sans-serif;
  font-size:12px;
  font-weight:400;
  letter-spacing:.1px;
  text-align:center;
  opacity:0;
  pointer-events:none;
  box-shadow:0 10px 28px rgba(0,0,0,.18);
  transition:opacity .22s ease,transform .22s ease
}
#about .about-feedback.show {
  opacity:1;
  transform:translate(-50%,0)
}
@media(max-width:1250px) {
  #about .about-wrap {
    width:min(100% - 32px,1000px);
    margin:0 auto
  }
  #about .about-layout {
    grid-template-columns:1fr;
    gap:22px
  }
  #about .values-grid {
    grid-template-columns:repeat(2,1fr)
  }
}
@media(max-width:760px) {
  #about .about-wrap {
    width:calc(100% - 24px);
    padding-top:26px
  }
  #about .values-grid,#about .mini-stats {
    grid-template-columns:1fr
  }
  #about .about-process-strip {
    grid-template-columns:1fr;
    gap:10px
  }
  #about .mv-tabs {
    width:100%;
    grid-template-columns:repeat(3,1fr);
    gap:8px
  }
  #about .mv-tab {
    font-size:9px
  }
  #about .top-gallery {
    grid-template-columns:1fr;
    grid-template-rows:auto
  }
  #about .photo-box {
    height:180px
  }
  #about .photo-box.large {
    grid-row:auto
  }
  #about .commit-badge {
    position:static;
    width:100%;
    margin-top:12px
  }
  #about .check-grid {
    grid-template-columns:1fr
  }
  #about .about-cta {
    display:block
  }
  #about .about-cta-btn {
    margin-top:13px;
    width:100%
  }
  #about .story-card {
    display:block
  }
  #about .about-outline-btn {
    margin-top:13px;
    width:100%
  }
}
#about .about-layout {
  grid-template-columns:minmax(360px,500px) minmax(0,1fr) !important;
  column-gap:34px !important;
  align-items:start !important
}
#about .mission-card {
  min-height:650px !important;
  height:auto !important;
  padding:12px !important
}
#about .right-showcase {
  gap:14px !important
}
#about .values-grid {
  gap:14px !important
}
#about .top-gallery {
  gap:10px !important
}
#about .about-process-strip {
  gap:12px !important;
  margin-top:4px !important
}
#about .story-card {
  column-gap:22px !important;
  padding:12px 4px 16px !important
}
#about .mv-tabs {
  gap:14px !important
}
#about .mini-stats {
  gap:9px !important
}
#about .check-grid {
  gap:9px 18px !important
}
#about .about-cta {
  gap:12px !important
}
#about .mv-tab,#about .about-cta-btn,#about .about-outline-btn {
  border:0 !important;
  border-radius:999px !important;
  background:linear-gradient(90deg,#FE7B09 0%,#FFAB0A 100%) !important;
  color:#111827 !important;
  font-family:'Inter',sans-serif !important;
  font-size:10px !important;
  font-weight:600 !important;
  line-height:1 !important;
  min-height:34px !important;
  height:34px !important;
  padding:0 15px !important;
  display:inline-flex !important;
  align-items:center !important;
  justify-content:center !important;
  text-align:center !important;
  box-shadow:none !important;
  transform:none !important;
  transition:background .18s ease,color .18s ease,border-color .18s ease,filter .18s ease !important
}
#about .mv-tab.active,#about .mv-tab:hover,#about .about-cta-btn:hover,#about .about-outline-btn:hover {
  background:#111827 !important;
  color:#fff !important;
  transform:none !important;
  box-shadow:none !important
}
#about .mv-tab {
  width:100% !important
}
#about .about-cta-btn {
  width:128px !important;
  min-width:128px !important;
  max-width:128px !important
}
#about .about-outline-btn {
  width:220px !important;
  min-width:220px !important;
  max-width:220px !important;
  justify-self:end !important
}
#about .orange,#about .commit-badge i,#about .check-item i,#about .mini-icon,#about .value-card:nth-child(1) .value-icon,#about .process-step:nth-child(3) .process-num,#about .process-step:nth-child(3) i {
  color:#ff7a00 !important;
  background:transparent !important
}
#about .blue,#about .value-card:nth-child(2) .value-icon,#about .process-step:nth-child(1) .process-num,#about .process-step:nth-child(1) i {
  color:#2563eb !important;
  background:transparent !important
}
#about .green,#about .value-card:nth-child(3) .value-icon,#about .process-step:nth-child(2) .process-num,#about .process-step:nth-child(2) i {
  color:#16a34a !important;
  background:transparent !important
}
#about .purple,#about .value-card:nth-child(4) .value-icon,#about .process-step:nth-child(4) .process-num,#about .process-step:nth-child(4) i {
  color:#7c3aed !important;
  background:transparent !important
}
#about .value-icon,#about .process-step i,#about .process-num,#about .mini-icon {
  box-shadow:none !important;
  transform:none !important
}
#about .mission-card:hover,#about .story-card:hover,#about .value-card:hover,#about .value-card.is-active,#about .process-step:hover,#about .mini-stat:hover,#about .mv-content:hover {
  transform:none !important;
  box-shadow:none !important
}
#about .value-card:hover,#about .process-step:hover,#about .mini-stat:hover,#about .mv-content:hover {
  background:rgba(17,24,39,.055) !important;
  backdrop-filter:blur(2px)
}
@media(max-width:760px) {
  #about .about-layout {
    grid-template-columns:1fr !important;
    column-gap:0 !important;
    row-gap:18px !important
  }
  #about .about-cta-btn,#about .about-outline-btn {
    width:100% !important;
    min-width:0 !important;
    max-width:100% !important
  }
}
</style>
<style id="about-right-showcase-position-lock">
@media(min-width:901px){
  #about .about-layout{
    display:grid!important;
    grid-template-columns:minmax(360px,500px) minmax(0,1fr)!important;
    grid-template-areas:"mission showcase"!important;
    column-gap:34px!important;
    align-items:start!important;
  }
  #about .mission-card{grid-area:mission!important;min-width:0!important}
  #about .right-showcase{grid-area:showcase!important;min-width:0!important;align-self:start!important}
}
@media(max-width:900px){
  #about .about-layout{grid-template-columns:1fr!important;grid-template-areas:"mission" "showcase"!important}
}
</style>
<style id="about-section-spacing-compact-final">
#about.about-premium-page {
  scroll-margin-top:88px!important
}
#about .about-wrap {
  width:min(1270px,calc(100% - 112px))!important;
  max-width:1270px!important;
  margin:0 0 0 80px!important;
  padding-top:50px!important;
  padding-bottom:50px!important
}
@media(max-width:1180px) {
  #about .about-wrap {
    width:calc(100% - 44px)!important;
    padding-top:28px!important;
    padding-bottom:46px!important
  }
}
@media(max-width:760px) {
  #about .about-wrap {
    width:calc(100% - 28px)!important;
    padding-top:19px!important;
    padding-bottom:40px!important
  }
}
</style>

<style id="about-rightside-endpoint-align-final">
/* Final alignment only: colored-border boxes are shorter while the image area is slightly taller, keeping the same endpoint. */
@media(min-width:901px){
  #about .about-layout{
    align-items:start!important;
  }

  #about .mission-card{
    height:650px!important;
    min-height:650px!important;
  }

  #about .right-showcase{
    height:650px!important;
    min-height:650px!important;
    display:grid!important;
    grid-template-rows:140px 347px 135px!important;
    gap:14px!important;
    align-self:start!important;
  }

  #about .values-grid{
    height:140px!important;
    min-height:140px!important;
    display:grid!important;
    grid-template-columns:repeat(4,1fr)!important;
    gap:14px!important;
  }

  #about .value-card{
    height:140px!important;
    min-height:140px!important;
    padding:14px 14px!important;
  }

  #about .top-gallery{
    height:347px!important;
    min-height:347px!important;
    grid-template-rows:168.5px 168.5px!important;
    gap:10px!important;
  }

  #about .about-process-strip{
    height:135px!important;
    min-height:135px!important;
    margin-top:0!important;
    gap:12px!important;
  }

  #about .process-step{
    height:135px!important;
    min-height:135px!important;
    padding:19px 14px 14px 58px!important;
  }

  #about .process-num{
    left:18px!important;
    top:19px!important;
  }

  #about .process-step i{
    left:16px!important;
    top:46px!important;
  }
}

@media(max-width:900px){
  #about .mission-card,
  #about .right-showcase,
  #about .values-grid,
  #about .value-card,
  #about .top-gallery,
  #about .about-process-strip,
  #about .process-step{
    height:auto!important;
    min-height:0!important;
  }
}
</style>
<section id="about" class="about-premium-page section {{ ($activeSection ?? '') === 'about' ? 'active' : '' }}">
<div class="about-feedback" id="aboutFeedback" role="status" aria-live="polite">
</div>
<div class="about-wrap">
<div class="about-layout">
<div class="mission-card">
<p class="section-label">ABOUT US</p>
<h2 class="about-heading">Mission, Vision &amp; Process</h2>
<div class="orange-line">
</div>
<p>Printify &amp; Co. provides independent printing shops with a secure, multi-business platform for ordering, payment validation, and delivery coordination.</p>
<div class="mv-tabs">
<button type="button" class="mv-tab active" data-type="mission">MISSION</button>
<button type="button" class="mv-tab" data-type="vision">VISION</button>
<button type="button" class="mv-tab" data-type="process">PROCESS</button>
</div>
<div class="mv-content">
<h3 id="mvTitle">Our Mission</h3>
<div id="mvText">
<p>Printify &amp; Co. provides independent printing shops with a secure, multi-business platform that automates order management, payment validation, and delivery coordination, enabling reliable and efficient service delivery to their customers.</p>
</div>
</div>
<div class="story-card about-story-inline">
<p class="section-label">OUR STORY</p>
<div class="orange-line">
</div>
<p class="story-text">
<span class="brand-font">Printify &amp; Co.</span> was built for printing shops still running on manual processes - orders scattered across messaging apps, payments confirmed through screenshots, deliveries arranged outside any real system. As demand grew, these gaps made it harder to track orders, verify payments, and deliver consistent service.
</p>
<p class="story-text">
We built a shared platform instead. Multiple printing businesses now operate securely under one infrastructure, each with its own protected workspace, without the cost of running separate systems.
</p>
<p class="story-text">
One platform for ordering, payment validation, and delivery coordination - turning scattered operations into traceable, scalable workflows.
</p>
</div><div class="about-cta">
<div>
<h3>Ready to manage printing orders in one platform?</h3>
<p>Submit files, validate payments, track status, and coordinate delivery through a secure workflow.</p>
</div>
<button type="button" class="about-cta-btn" onclick="aboutGoToContact()">
CONTACT US <i class="fa-solid fa-arrow-right">
</i>
</button>
</div>
</div>
<div class="right-showcase">
<div class="values-grid">
<div class="value-card is-active" tabindex="0">
<div class="value-icon orange">
<i class="fa-solid fa-lock">
</i>
</div>
<h3>Secure Platform</h3>
<p>Tenant-isolated data and role-based access keep every business's records protected.</p>
</div>
<div class="value-card" tabindex="0">
<div class="value-icon blue">
<i class="fa-solid fa-location-dot">
</i>
</div>
<h3>Real-Time Tracking</h3>
<p>Know exactly where your order stands, from submission to delivery.</p>
</div>
<div class="value-card" tabindex="0">
<div class="value-icon green">
<i class="fa-solid fa-credit-card">
</i>
</div>
<h3>Verified Payments</h3>
<p>GCash, Maya, and cash transactions are validated and logged for full transparency.</p>
</div>
<div class="value-card" tabindex="0">
<div class="value-icon purple">
<i class="fa-solid fa-truck-fast">
</i>
</div>
<h3>Coordinated Delivery</h3>
<p>Trusted couriers like Lalamove and J&amp;T Express, tracked to completion.</p>
</div>
</div>
<div class="top-gallery">
<div class="photo-box large">
<img src="{{ asset('images/Homesld1.jpg') }}" alt="Printing machine" loading="eager" decoding="sync" fetchpriority="high">
</div>
<div class="photo-box">
<img src="{{ asset('images/Homesld2.jpg') }}" alt="Print workspace" loading="eager" decoding="sync" fetchpriority="high">
</div>
<div class="photo-box">
<img src="{{ asset('images/Homesld3.jpg') }}" alt="Printed materials" loading="eager" decoding="sync" fetchpriority="high">
</div>
<div class="commit-badge">
<i class="fa-solid fa-shield-halved">
</i>
<strong>Secure Multi-Business Platform</strong>
<small>Multiple printing businesses operate under one protected infrastructure.</small>
</div>
</div>
<div class="about-process-strip">
<div class="process-step">
<span class="process-num">01</span>
<i class="fa-solid fa-file-arrow-up">
</i>
<h3>Secure File Upload</h3>
<p>Customers submit print files through the platform for organized processing.</p>
</div>
<div class="process-step">
<span class="process-num">02</span>
<i class="fa-solid fa-receipt">
</i>
<h3>Payment Validation</h3>
<p>GCash, Maya, and cash payments are verified and logged transparently.</p>
</div>
<div class="process-step">
<span class="process-num">03</span>
<i class="fa-solid fa-route">
</i>
<h3>Status Tracking</h3>
<p>Orders stay traceable from submission until completion.</p>
</div>
<div class="process-step">
<span class="process-num">04</span>
<i class="fa-solid fa-truck">
</i>
<h3>Delivery Coordination</h3>
<p>Delivery is coordinated through couriers like Lalamove and J&amp;T Express.</p>
</div>
</div>
</div>
</div>
</div>
</section>
<script>
document.addEventListener('DOMContentLoaded',function(){
  const about=document.getElementById('about');
  const counters=document.querySelectorAll('#about .about-counter');
  const feedback=document.getElementById('aboutFeedback');
  let countersStarted=false;
  let feedbackTimer=null;
  function showAboutFeedback(message){
    if(!feedback)return;
    feedback.textContent=message;
    feedback.classList.add('show');
    clearTimeout(feedbackTimer);
    feedbackTimer=setTimeout(()=>{
      feedback.classList.remove('show');
    },1800);
  } window.aboutGoToContact=function(){
    const contact=document.getElementById('contact');
    if(contact){
      contact.scrollIntoView({
        behavior:'smooth', block:'start'
      });
      showAboutFeedback('Contact section opened.');
    }else{
      showAboutFeedback('Contact section is not available on this page yet.');
    }
  };
  function formatNumber(num,suffix){
    return num.toLocaleString('en-US') + suffix;
  } function runCounters(){
    if(countersStarted)return;
    countersStarted=true;
    counters.forEach(counter=>{
      const target=parseInt(counter.dataset.value,10);
      const suffix=counter.dataset.suffix || '';
      const step=Math.max(1,Math.ceil(target/42));
      let value=0;
      counter.textContent=formatNumber(0,suffix);
      const timer=setInterval(()=>{
        value+=step;
        if(value>=target){
          value=target;
          clearInterval(timer);
        } counter.textContent=formatNumber(value,suffix);
      },22);
    });
  } if('IntersectionObserver' in window && about){
    const observer=new IntersectionObserver(entries=>{
      entries.forEach(entry=>{
        if(entry.isIntersecting)runCounters();
      });
    },{
      threshold:.22
    });
    observer.observe(about);
  }else{
    setTimeout(runCounters,500);
  } const cards=document.querySelectorAll('#about .value-card');
  cards.forEach(card=>{
    const activate=()=>{
      cards.forEach(c=>c.classList.remove('is-active'));
      card.classList.add('is-active');
      const title=card.querySelector('h3');
      if(title)showAboutFeedback(title.textContent + ' selected.');
    };
    card.addEventListener('click',activate);
    card.addEventListener('keypress',e=>{
      if(e.key==='Enter')activate();
    });
  });
  const content={
    mission:{
      title:'Our Mission', text:[ 'Printify & Co. provides independent printing shops with a secure, multi-business platform that automates order management, payment validation, and delivery coordination, enabling reliable and efficient service delivery to their customers.' ]
    }, vision:{
      title:'Our Vision', text:[ 'To be the leading multi-business platform for printing shop operations, empowering small and medium enterprises with centralized, secure, and scalable digital infrastructure for sustained growth.' ]
    }, process:{
      title:'Our Process', text:[ 'We connect you with the right printing shop and guide your order from submission to delivery - secure file upload, transparent payment validation, real-time status tracking, and coordinated delivery, all in one platform.' ]
    }
  };
  const tabs=document.querySelectorAll('#about .mv-tab');
  const mvTitle=document.getElementById('mvTitle');
  const mvText=document.getElementById('mvText');
  tabs.forEach(tab=>{
    tab.addEventListener('click',function(){
      const data=content[tab.dataset.type];
      tabs.forEach(t=>t.classList.remove('active'));
      tab.classList.add('active');
      if(mvTitle){
        mvTitle.textContent=data.title;
      } if(mvText){
        mvText.innerHTML=data.text.map(paragraph=>`<p>${paragraph}</p>`).join('');
      } showAboutFeedback(data.title + ' loaded.');
    });
  });
});
</script>
<style id="printify-font-apply-final">
body,body p,body span,body a,body li,body small,body td,body th,body div,body input,body textarea,body select,body option,body button,body .btn,body input[type="submit"],body .form-control,body .form-input,body .form-textarea,body .contact-text,body .contact-detail,body .contact-info,body .footer-text,body .footer-link,body .copyright {
  font-family:'Inter',sans-serif!important
}
body h1,body h2,body h3,body h4,body h5,body h6,body label,body strong,body b,body .section-title,body .section-subtitle,body .card-title,body .card-subtitle,body .contact-title,body .contact-subtitle,body .form-title,body .contact-card-title,body .quick-title,body .branch-title,body .footer-title,body .footer-subtitle,body .footer-heading,body .kicker,body .eyebrow,body .nav-link,body .nav-item,body .navigation a {
  font-family:'League Spartan',sans-serif!important;
  font-weight:600!important
}
.brand-font,.brand-main-text,.printify-wordmark,.printify-brand,.printify-logo {
  font-family:'Boxing',serif!important;
  font-weight:400!important
}
body i,body .fa,body .fa-solid,body .fa-regular,body .fa-brands {
  font-family:"Font Awesome 6 Free","Font Awesome 6 Brands"!important
}
</style>
<style id="about-services-heading-font-match">
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
#about .section-label {
  font-family:'Clash Display','League Spartan',sans-serif!important;
  font-weight:600!important;
  letter-spacing:0!important;
  text-transform:uppercase!important
}
#about .about-heading {
  font-family:'Clash Display','League Spartan',sans-serif!important;
  font-weight:600!important;
  letter-spacing:0!important
}
</style>

<style id="about-color-border-text-size-final">
@media(min-width:901px){
  #about .value-card h3{
    font-size:13.5px!important;
    line-height:1.12!important;
    margin:0 0 6px!important;
  }

  #about .value-card p{
    font-size:11.2px!important;
    line-height:1.26!important;
  }

  #about .value-icon{
    font-size:19px!important;
    margin-bottom:8px!important;
  }

  #about .process-num{
    font-size:11px!important;
    line-height:1!important;
  }

  #about .process-step h3{
    font-size:13px!important;
    line-height:1.12!important;
    margin:0 0 5px!important;
  }

  #about .process-step p{
    font-size:10.8px!important;
    line-height:1.27!important;
  }

  #about .process-step i{
    font-size:21px!important;
  }
}
</style>
