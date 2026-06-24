@php($status = session('contact_status') ?: ($errors->any() ? 'error' : ''))
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<section id="contact" class="contact-section section {{ ($activeSection ?? '') === 'contact' ? 'active' : '' }}">
<div id="contactToast" class="contact-toast" role="status" aria-live="polite">
</div>
<div class="contact-container">
<div class="contact-head">
<span>GET IN TOUCH</span>
<h2>Contact <b>Us</b>
</h2>
<p>We're here to help! Send us your inquiry and our team will assist you as soon as possible.</p>
</div>
<?php if ($status === "success"): ?>
<div class="alert success">Your message has been sent successfully.</div>
<?php elseif ($status === "error"): ?>
<div class="alert error">Please complete all required fields properly.</div>
<?php endif; ?>
<div class="contact-grid">
<div class="contact-card main-box form-card">
<div class="card-title">
<i class="fa-solid fa-paper-plane icon-orange">
</i>
<div>
<h3>Send Us a Message</h3>
<p>Fill out the form below and we'll get back to you soon.</p>
</div>
</div>
<form method="POST" id="contactForm" action="{{ route('landing.contactus.submit') }}" enctype="multipart/form-data">
@csrf
<div class="form-fields">
<div class="form-row">
<span>Full Name *</span>
<div class="input-wrapper">
<i class="fa-solid fa-user">
</i>
<input type="text" name="name" placeholder="Enter your full name" required>
</div>
</div>
<div class="form-row">
<span>Email Address *</span>
<div class="input-wrapper">
<i class="fa-solid fa-envelope">
</i>
<input type="email" name="email" placeholder="Enter your email address" required>
</div>
</div>
<div class="form-row">
<span>Mobile Number</span>
<div class="input-wrapper">
<i class="fa-solid fa-phone">
</i>
<input type="tel" name="phone" placeholder="09171234567 or +639171234567" inputmode="tel">
</div>
</div>
<div class="form-row message-row">
<span>Message *</span>
<div class="input-wrapper textarea-wrapper">
<i class="fa-solid fa-pencil">
</i>
<textarea name="message" placeholder="Tell us about your project..." required>
</textarea>
</div>
</div>
<div class="form-row upload-row">
<span>Upload File (Optional)</span>
<label class="upload-drop">
<input type="file" name="attachment" accept=".pdf,.ai,.psd,.jpg,.jpeg,.png">
<i class="fa-solid fa-cloud-arrow-up">
</i>
<span>
<b>Click to upload or drag and drop</b>
<small>PDF, AI, PSD, JPG, PNG up to 10MB</small>
</span>
</label>
</div>
</div>
<div class="form-bottom">
<small>
<i class="fa-solid fa-lock">
</i> We respect your privacy.</small>
<button class="ui-btn orange-btn" type="submit">
Send Message
<i class="fa-solid fa-paper-plane">
</i>
</button>
</div>
</form>
</div>
<div class="contact-details">
<div class="info-card no-box">
<div class="touch-box">
<h3>
<i class="fa-solid fa-headset icon-navy">
</i> Get In Touch</h3>
<div class="contact-info-item">
<i class="fa-solid fa-phone icon-green">
</i>
<div class="contact-info-copy">
<b>Call Us</b>
<span>+63 9204334130</span>
<small>Mon-Fri, 8:00 AM - 6:00 PM</small>
</div>
</div>
<div class="contact-info-item">
<i class="fa-solid fa-envelope icon-blue">
</i>
<div class="contact-info-copy">
<b>Email Us</b>
<span>printifycoph@gmail.com</span>
</div>
</div>
<div class="contact-info-item">
<i class="fa-solid fa-message icon-black">
</i>
<div class="contact-info-copy">
<b>Live Chat <em>
</em>
</b>
<span>Available on website</span>
<small>Mon-Fri, 8:00 AM - 6:00 PM</small>
</div>
</div>
</div>
<div class="branch-card no-box">
<h3>
<i class="fa-solid fa-location-dot icon-red">
</i> Our Branches</h3>
<div class="branch-content">
<div class="branch-list">
<div class="branch-item">
<small>Main Branch</small>
<div class="branch-address">
<i class="fa-solid fa-location-dot">
</i>
<span>Makati Branch, 123 Printify Avenue</span>
</div>
<div class="branch-meta">
<i class="fa-solid fa-clock">
</i>
<span>Open Mon-Sat</span>
<b>8:00 AM - 5:00 PM</b>
</div>
<div class="branch-meta">
<i class="fa-solid fa-calendar">
</i>
<span>Printing, design, pickup</span>
</div>
</div>
<div class="branch-item">
<small>Office Branch</small>
<div class="branch-address">
<i class="fa-solid fa-location-dot">
</i>
<span>Quezon City Branch, 45 Timog Avenue</span>
</div>
<div class="branch-meta">
<i class="fa-solid fa-clock">
</i>
<span>Open Mon-Sat</span>
<b>8:00 AM - 5:00 PM</b>
</div>
<div class="branch-meta">
<i class="fa-solid fa-calendar">
</i>
<span>Orders, pickup, inquiries</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="quick-row">
<div class="quick-answer-card no-box">
<h3>
<i class="fa-solid fa-circle-question icon-orange">
</i> Quick Answers</h3>
<button type="button" onclick="contactQuickAnswer('Turnaround Time')">
<span>
<i class="fa-solid fa-truck-fast icon-purple">
</i>
</span>
<b>Turnaround Time</b>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button type="button" onclick="contactQuickAnswer('Request a Quote')">
<span>
<i class="fa-solid fa-file-lines icon-green">
</i>
</span>
<b>Request a Quote</b>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button type="button" onclick="contactQuickAnswer('File Guide')">
<span>
<i class="fa-solid fa-cube icon-purple">
</i>
</span>
<b>File & Design Guide</b>
<i class="fa-solid fa-chevron-right">
</i>
</button>
</div>
<div class="branch-notes">
<p>
<i class="fa-regular fa-clock icon-orange">
</i> Same-day assistance available for selected services.</p>
<p>
<i class="fa-regular fa-calendar icon-orange">
</i> Contact us before visiting for bulk and rush orders.</p>
</div>
</div>
</div>
</div>
</div>
</section>
<style>
:root {
  --orange:#ff6a00;
  --black:#111111;
  --text:#151515;
  --muted:#515761;
  --line:#e2e6ee
}
* {
  box-sizing:border-box
}
.contact-section {
  width:100%;
  background:#ffffff;
  color:var(--text);
  padding:42px 18px 70px 100px;
  font-family:"Inter",Arial,sans-serif;
  font-weight:400;
  letter-spacing:0
}
.contact-container {
  width:100%;
  max-width:1450px;
  margin:0
}
.contact-head {
  margin-bottom:20px
}
.contact-head span {
  display:block;
  color:var(--orange);
  font-family:"Poppins",Arial,sans-serif;
  font-size:13px;
  font-weight:600;
  letter-spacing:1.4px;
  text-transform:uppercase;
  margin-bottom:7px
}
.contact-head h2 {
  margin:0 0 8px;
  color:#000;
  font-family:"Playfair Display",Georgia,serif;
  font-size:48px;
  line-height:.96;
  font-weight:700;
  text-transform:uppercase;
  letter-spacing:0
}
.contact-head h2 b {
  color:var(--orange);
  font-weight:700
}
.contact-head p,.card-title p,.map-head p,.form-bottom small,.branch-notes p,.branch-item p,.branch-list span,.info-card p,.info-card p small,.info-card li {
  font-family:"Inter",Arial,sans-serif;
  font-weight:400;
  letter-spacing:0
}
.contact-head p {
  margin:0;
  color:#303743;
  font-size:14px;
  line-height:1.45
}
.alert {
  width:fit-content;
  padding:10px 14px;
  border-radius:10px;
  margin:0 0 18px;
  font-family:"Poppins",Arial,sans-serif;
  font-size:12px;
  font-weight:600
}
.alert.success {
  background:#e9fff0;
  color:#157a3f;
  border:1px solid #b8f3ca
}
.alert.error {
  background:#fff0f0;
  color:#b42318;
  border:1px solid #ffd1d1
}
.contact-toast {
  position:fixed;
  top:94px;
  left:50%;
  transform:translate(-50%,-15px);
  z-index:9999;
  min-width:280px;
  max-width:440px;
  padding:13px 22px;
  border-radius:18px;
  background:#111827;
  color:#ffffff;
  text-align:center;
  font-family:"Inter",Arial,sans-serif;
  font-size:13px;
  line-height:1.35;
  opacity:0;
  pointer-events:none;
  box-shadow:0 18px 40px rgba(0,0,0,.22);
  transition:opacity .2s ease,transform .2s ease
}
.contact-toast.show {
  opacity:1;
  transform:translate(-50%,0)
}
.contact-grid {
  display:grid;
  grid-template-columns:420px 705px 360px;
  gap:22px;
  align-items:stretch
}
.contact-card,.no-box {
  background:#ffffff;
  border-radius:10px
}
.main-box {
  border:1px solid #000000;
  box-shadow:none
}
.form-card,.middle-side,.contact-extra {
  min-height:565px
}
.form-card {
  padding:20px 15px 18px;
  display:flex;
  flex-direction:column
}
.form-card form {
  flex:1;
  display:flex;
  flex-direction:column;
  min-height:0
}
.card-title {
  display:flex;
  align-items:center;
  gap:13px;
  margin-bottom:22px
}
.card-title>i {
  width:44px;
  height:44px;
  display:grid;
  place-items:center;
  font-size:25px;
  flex:0 0 auto
}
.card-title h3,.info-card h3,.branch-card h3,.quick-answer-card h3,.map-card h3 {
  margin:0;
  color:#151515;
  font-family:"Poppins",Arial,sans-serif;
  font-weight:600;
  letter-spacing:0
}
.card-title h3 {
  font-size:21px;
  margin-bottom:5px;
  line-height:1.05
}
.card-title p {
  margin:0;
  color:#303743;
  font-size:10.8px;
  line-height:1.35
}
.form-fields {
  display:flex;
  flex-direction:column;
  gap:18px;
  flex:1
}
.two-col {
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:12px
}
.form-row {
  display:flex;
  flex-direction:column
}
.form-row label {
  font-family:"Poppins",Arial,sans-serif;
  font-size:11px;
  color:#181818;
  font-weight:600;
  margin-bottom:8px;
  letter-spacing:0
}
.input-wrapper {
  position:relative;
  display:flex;
  align-items:center
}
.input-wrapper i {
  position:absolute;
  left:13px;
  color:#1b1b1b;
  font-size:13px;
  pointer-events:none;
  z-index:2
}
.input-wrapper input,.input-wrapper select,.input-wrapper textarea {
  width:100%;
  height:43px;
  border:1px solid #d9dee7;
  border-radius:8px;
  background:#ffffff;
  color:#111827;
  font-family:"Inter",Arial,sans-serif;
  font-size:11.5px;
  font-weight:400;
  letter-spacing:0;
  outline:none;
  padding:10px 12px 10px 38px;
  transition:border-color .18s ease,box-shadow .18s ease
}
.input-wrapper select {
  cursor:pointer;
  appearance:auto
}
.textarea-wrapper {
  align-items:flex-start
}
.textarea-wrapper i {
  top:15px;
  font-size:13px
}
.input-wrapper textarea {
  height:130px;
  min-height:130px;
  resize:none;
  line-height:1.45;
  padding-top:14px
}
.message-row {
  flex:1
}
.input-wrapper input:focus,.input-wrapper select:focus,.input-wrapper textarea:focus {
  border-color:var(--orange);
  box-shadow:0 0 0 3px rgba(255,106,0,.11)
}
.form-bottom {
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:14px;
  margin-top:21px
}
.form-bottom small {
  display:inline-flex;
  align-items:center;
  gap:8px;
  color:#575b63;
  font-size:12px
}
.form-bottom small i {
  color:#1a1a1a
}
.ui-btn {
  width:160px;
  height:40px;
  border:0;
  border-radius:8px;
  cursor:pointer;
  font-family:"Poppins",Arial,sans-serif;
  font-size:11px;
  font-weight:600;
  letter-spacing:0;
  text-transform:uppercase;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  white-space:nowrap;
  transition:transform .18s ease,background .18s ease,color .18s ease
}
.orange-btn {
  background:var(--orange);
  color:#000000
}
.black-btn {
  background:#111827;
  color:#ffffff
}
.ui-btn:hover {
  background:#111827;
  color:#ffffff;
  transform:translateY(-1px)
}
.black-btn:hover {
  background:var(--orange);
  color:#000000
}
.middle-side {
  display:flex;
  flex-direction:column;
  gap:20px
}
.info-card {
  height:342px;
  padding:16px 0;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:10px
}
.touch-box {
  padding:0 17px 0 0;
  border-right:1px solid var(--line)
}
.hours-box {
  padding:0 0 0 13px
}
.info-card h3 {
  font-size:15px;
  line-height:1.2;
  margin-bottom:14px;
  display:flex;
  align-items:center;
  gap:10px
}
.info-card h3 i {
  font-size:22px
}
.info-card p {
  position:relative;
  margin:0 0 14px;
  padding-left:37px;
  font-size:12px;
  color:#1f2937;
  line-height:1.3
}
.info-card p>i {
  position:absolute;
  left:0;
  top:2px;
  width:24px;
  text-align:center;
  font-size:19px
}
.info-card p b,.info-card p span,.info-card p small {
  display:block
}
.info-card p b {
  color:#121212;
  font-family:"Poppins",Arial,sans-serif;
  font-weight:600;
  margin-bottom:3px
}
.info-card p span {
  color:#1f2937
}
.info-card p small {
  color:#202020;
  font-size:11px
}
.info-card ul {
  list-style:none;
  margin:0 0 14px;
  padding:0
}
.info-card li {
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:12px;
  padding:12px 0;
  border-bottom:1px solid var(--line);
  color:#1f2937;
  font-size:11.5px
}
.info-card li:first-child {
  padding-top:4px
}
.info-card li span {
  white-space:nowrap
}
.info-card li b {
  color:#111827;
  font-family:"Poppins",Arial,sans-serif;
  font-weight:600;
  white-space:nowrap
}
.socials {
  display:flex;
  align-items:center;
  gap:10px
}
.socials a {
  width:36px;
  height:36px;
  border-radius:50%;
  display:grid;
  place-items:center;
  text-decoration:none;
  color:#fff;
  font-size:17px;
  transition:transform .18s ease
}
.socials a:hover {
  transform:translateY(-2px)
}
.socials a:nth-child(1) {
  background:#1877f2
}
.socials a:nth-child(2) {
  background:#e4405f
}
.socials a:nth-child(3) {
  background:#ff0000
}
.socials a:nth-child(4) {
  background:#0a66c2
}
.branch-card {
  flex:1;
  min-height:203px;
  padding:18px 19px
}
.branch-card h3 {
  font-size:18px;
  display:flex;
  align-items:center;
  gap:10px
}
.branch-card h3 i {
  font-size:26px
}
.branch-content {
  display:grid;
  grid-template-columns:1fr 205px;
  gap:28px;
  margin-top:20px
}
.branch-list {
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:26px
}
.branch-list b,.branch-list span,.branch-list small {
  display:block
}
.branch-list b {
  color:#111827;
  font-family:"Poppins",Arial,sans-serif;
  font-size:12px;
  font-weight:600;
  margin-bottom:8px
}
.branch-list span {
  color:#303743;
  font-size:11px;
  margin-bottom:10px;
  line-height:1.35
}
.branch-list small {
  width:fit-content;
  color:#0b73e8;
  font-family:"Poppins",Arial,sans-serif;
  font-size:10px;
  font-weight:600;
  margin-bottom:12px;
  line-height:1.3
}
.branch-item p {
  margin:0 0 9px;
  color:#303743;
  font-size:11px;
  line-height:1.38;
  display:flex;
  align-items:flex-start;
  gap:8px
}
.branch-item p i {
  color:var(--orange);
  width:14px;
  text-align:center;
  flex:0 0 auto;
  margin-top:1px
}
.branch-notes {
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  min-height:148px
}
.branch-notes p {
  margin:0 0 14px;
  color:#303743;
  font-size:11.3px;
  line-height:1.5;
  display:flex;
  align-items:flex-start;
  gap:10px
}
.branch-notes p i {
  margin-top:3px;
  width:16px;
  text-align:center;
  flex:0 0 auto
}
.branch-card button {
  align-self:flex-end
}
.contact-extra {
  display:flex;
  flex-direction:column;
  gap:20px
}
.quick-answer-card {
  height:213px;
  padding:20px 0 16px
}
.quick-answer-card h3 {
  font-size:16px;
  margin-bottom:17px;
  display:flex;
  align-items:center;
  gap:10px
}
.quick-answer-card h3 i {
  font-size:24px
}
.quick-answer-card button {
  width:100%;
  height:53px;
  border:0;
  border-bottom:1px solid var(--line);
  background:transparent;
  display:grid;
  grid-template-columns:34px 1fr 14px;
  align-items:center;
  gap:11px;
  text-align:left;
  cursor:pointer;
  padding:0 5px;
  color:#111827;
  border-radius:0;
  transition:background .18s ease,color .18s ease
}
.quick-answer-card button:last-child {
  border-bottom:0
}
.quick-answer-card button span {
  width:28px;
  height:28px;
  display:grid;
  place-items:center;
  border-radius:8px
}
.quick-answer-card button span i {
  font-size:20px
}
.quick-answer-card button b {
  color:inherit;
  font-family:"Poppins",Arial,sans-serif;
  font-size:12px;
  font-weight:600;
  letter-spacing:0
}
.quick-answer-card button>i {
  color:inherit;
  font-size:13px
}
.quick-answer-card button:hover {
  background:#111827;
  color:#ffffff;
  border-bottom-color:#111827
}
.quick-answer-card button:hover i {
  color:#ffffff !important
}
.map-card {
  flex:1;
  min-height:332px;
  padding:18px 0 0;
  display:flex;
  flex-direction:column
}
.map-head h3 {
  font-size:18px;
  display:flex;
  align-items:center;
  gap:10px;
  margin-bottom:9px
}
.map-head h3 i {
  font-size:27px
}
.map-head p {
  margin:0 0 13px;
  color:var(--muted);
  font-size:12px;
  line-height:1.4
}
.map-card button {
  margin-bottom:18px
}
.map-frame {
  width:100%;
  flex:1;
  min-height:184px;
  border-radius:10px;
  overflow:hidden;
  border:1px solid #dde3ec;
  background:#edf2f7
}
.map-frame iframe {
  width:100%;
  height:100%;
  border:0;
  display:block;
  pointer-events:auto;
  touch-action:auto
}
.icon-orange {
  color:var(--orange) !important
}
.icon-black {
  color:#111111 !important
}
.icon-green {
  color:#22c55e !important
}
.icon-red {
  color:#ef233c !important
}
.icon-blue {
  color:#1888ff !important
}
.icon-purple {
  color:#7c3aed !important
}
@media (max-width:1320px) {
  .contact-section {
    padding-left:40px;
    padding-right:30px
  }
  .contact-grid {
    grid-template-columns:400px 1fr 340px;
    gap:18px
  }
}
@media (max-width:1180px) {
  .contact-section {
    padding:32px 22px 55px
  }
  .contact-container {
    max-width:100%;
    margin:0 auto
  }
  .contact-grid {
    grid-template-columns:1fr
  }
  .form-card,.middle-side,.contact-extra {
    min-height:auto
  }
  .info-card {
    height:auto;
    min-height:320px
  }
  .branch-card {
    min-height:auto
  }
  .contact-extra {
    display:grid;
    grid-template-columns:1fr 1fr;
    align-items:stretch
  }
  .quick-answer-card,.map-card {
    height:auto;
    min-height:260px
  }
}
@media (max-width:760px) {
  .contact-section {
    padding:25px 14px 45px
  }
  .contact-head h2 {
    font-size:38px
  }
  .contact-grid {
    gap:18px
  }
  .two-col,.info-card,.branch-content,.branch-list,.contact-extra {
    grid-template-columns:1fr
  }
  .info-card {
    display:grid
  }
  .touch-box {
    padding-right:0;
    border-right:0;
    border-bottom:1px solid var(--line);
    padding-bottom:16px
  }
  .hours-box {
    padding-left:0
  }
  .branch-card button {
    align-self:flex-start
  }
  .form-bottom {
    align-items:flex-start;
    flex-direction:column
  }
  .form-bottom button {
    align-self:flex-end
  }
  .map-frame {
    min-height:220px
  }
}
.printify-footer {
  width:100%;
  background:#080808;
  color:#ffffff;
  font-family:"Inter",Arial,sans-serif;
  overflow:hidden;
  box-shadow:0 -14px 40px rgba(0,0,0,0.16)
}
.footer-top-line {
  width:100%;
  height:5px;
  background:linear-gradient(90deg,#ff6a00 0%,#ff7a14 50%,#ff6a00 100%)
}
.footer-main {
  width:100%;
  padding:10px 70px 8px;
  display:grid;
  grid-template-columns:1.14fr 1.55fr 1.44fr 1.62fr 1.30fr;
  align-items:flex-start;
  gap:24px;
  background:radial-gradient(circle at 8% 0%,rgba(255,106,0,.08),transparent 28%),#080808
}
.footer-col {
  min-height:70px;
  padding-left:24px;
  border-left:1px solid rgba(255,255,255,0.22)
}
.footer-brand {
  padding-left:0;
  border-left:none
}
.footer-brand h2 {
  margin:0 0 8px;
  color:#ffffff;
  font-family:"Poppins",Arial,sans-serif;
  font-size:24px;
  line-height:.92;
  font-weight:800;
  letter-spacing:-1.4px;
  text-transform:uppercase
}
.footer-brand h4 {
  margin:0 0 8px;
  color:#ff6a00;
  font-family:"Poppins",Arial,sans-serif;
  font-size:9px;
  line-height:1;
  font-weight:800;
  letter-spacing:2px;
  text-transform:uppercase
}
.footer-brand h4 {
  white-space:nowrap
}
.footer-brand p {
  margin:0;
  max-width:none;
  color:#f2f2f2;
  font-size:12.5px;
  line-height:1.35;
  font-weight:400
}
.footer-brand p span {
  white-space:nowrap
}
.footer-col h3 {
  margin:0;
  color:#ffffff;
  font-family:"Poppins",Arial,sans-serif;
  font-size:17px;
  line-height:1;
  font-weight:800;
  letter-spacing:2.5px;
  text-transform:uppercase
}
.footer-title-line {
  display:block;
  width:40px;
  height:3px;
  margin:9px 0 11px;
  background:#ff6a00;
  border-radius:20px;
  box-shadow:0 0 12px rgba(255,106,0,.45)
}
.footer-links {
  display:flex;
  gap:18px;
  align-items:center
}
.footer-links a,.footer-contact-list p {
  color:#f5f5f5;
  text-decoration:none;
  font-size:13px;
  line-height:1.15;
  font-weight:400;
  display:flex;
  align-items:center;
  gap:9px;
  white-space:nowrap;
  transition:color .2s ease,transform .2s ease
}
.footer-links a i {
  color:#ff6a00;
  font-size:12px
}
.footer-links a:hover {
  color:#ff6a00;
  transform:translateX(3px)
}
.footer-contact-info .footer-title-line {
  margin:7px 0 8px
}
.footer-contact-list {
  display:flex;
  flex-direction:column;
  gap:5px
}
.footer-contact-list p {
  margin:0
}
.footer-contact-list i {
  width:19px;
  min-width:19px;
  height:19px;
  color:#ff6a00;
  font-size:15px;
  text-align:center;
  display:grid;
  place-items:center
}
.footer-contact-list b {
  color:#ff6a00;
  padding:0 5px;
  font-weight:800
}
.policy-grid {
  display:grid;
  grid-template-columns:max-content max-content;
  gap:10px 18px
}
.footer-policy {
  padding-left:26px
}
.footer-policy .footer-links a {
  font-size:13px;
  gap:8px;
  white-space:nowrap
}
.footer-quick .footer-links-row {
  gap:15px
}
.footer-quick .footer-links-row a {
  gap:10px
}
.footer-socials {
  display:flex;
  align-items:center;
  gap:9px;
  flex-wrap:nowrap;
  white-space:nowrap
}
.footer-follow {
  min-width:175px;
  padding-left:18px
}
.footer-follow h3 {
  white-space:nowrap
}
.footer-socials a {
  width:31px;
  height:31px;
  border-radius:50%;
  display:grid;
  place-items:center;
  color:#ffffff;
  text-decoration:none;
  font-size:13px;
  box-shadow:0 8px 18px rgba(0,0,0,.22);
  transition:transform .2s ease,opacity .2s ease,box-shadow .2s ease
}
.footer-socials a:hover {
  transform:translateY(-3px);
  opacity:.95;
  box-shadow:0 12px 22px rgba(0,0,0,.32)
}
.footer-socials .facebook {
  background:#1877f2
}
.footer-socials .instagram {
  background:#e4405f
}
.footer-socials .youtube {
  background:#ff0000
}
.footer-socials .linkedin {
  background:#0a66c2
}
.footer-bottom {
  border-top:1px solid rgba(255,255,255,0.12);
  padding:5px 70px;
  background:#080808
}
.footer-bottom p {
  margin:0;
  color:#f1f1f1;
  font-size:12px;
  font-weight:400
}
.footer-bottom span {
  color:#ff6a00;
  font-weight:800
}
@media (max-width:1500px) {
  .footer-main {
    padding:10px 45px 8px;
    gap:24px;
    grid-template-columns:1.16fr 1.58fr 1.48fr 1.86fr 1.08fr
  }
  .footer-col {
    padding-left:20px;
    min-height:70px
  }
  .footer-brand h2 {
    font-size:25px
  }
  .footer-brand h4 {
    font-size:8px;
    letter-spacing:1px;
    white-space:nowrap;
    margin-bottom:7px
  }
  .footer-brand p {
    font-size:12px;
    line-height:1.32
  }
  .footer-col h3 {
    font-size:15px;
    letter-spacing:2px
  }
  .footer-title-line {
    margin:8px 0 10px
  }
  .footer-links a,.footer-contact-list p {
    font-size:11.8px
  }
  .footer-policy .footer-links a {
    font-size:11.2px;
    gap:6px
  }
  .footer-quick .footer-links-row {
    gap:10px
  }
  .policy-grid {
    gap:8px 12px
  }
  .footer-socials a {
    width:30px;
    height:30px;
    font-size:13px
  }
  .footer-bottom {
    padding:5px 45px
  }
}
@media (max-width:1180px) {
  .footer-main {
    grid-template-columns:1fr 1fr;
    gap:25px 22px
  }
  .footer-col {
    min-height:auto
  }
  .footer-follow {
    border-left:none;
    padding-left:0
  }
}
@media (max-width:760px) {
  .footer-main {
    grid-template-columns:1fr;
    padding:30px 24px 25px;
    gap:25px
  }
  .footer-col {
    border-left:none;
    padding-left:0;
    border-bottom:1px solid rgba(255,255,255,0.14);
    padding-bottom:22px
  }
  .footer-follow {
    border-bottom:none;
    padding-bottom:0
  }
  .footer-links {
    flex-direction:column;
    align-items:flex-start;
    gap:14px
  }
  .policy-grid {
    grid-template-columns:1fr
  }
  .footer-bottom {
    padding:12px 24px
  }
}
:root {
  --ui-orange-start:#FE7B09;
  --ui-orange-end:#FFAB0A;
  --ui-orange:#ff8a00;
  --ui-black:#111827;
  --ui-hover-soft:rgba(17,24,39,.13);
  --ui-hover-blur:rgba(17,24,39,.07);
  --ui-line:#111827;
  --ui-muted:#6b7280
}
.contact-section .ui-btn,.printify-footer .ui-btn,.contact-section button.ui-btn,.contact-section a.ui-btn {
  width:auto!important;
  min-width:104px!important;
  height:34px!important;
  padding:8px 16px!important;
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(90deg,var(--ui-orange-start),var(--ui-orange-end))!important;
  color:#111827!important;
  font-family:"Poppins",Arial,sans-serif!important;
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
.contact-section .ui-btn:hover,.contact-section .ui-btn:focus,.printify-footer .ui-btn:hover,.printify-footer .ui-btn:focus {
  background:var(--ui-black)!important;
  color:#ffffff!important;
  border-color:var(--ui-black)!important;
  box-shadow:none!important;
  transform:none!important;
  outline:0!important
}
.contact-section .ui-btn:hover i,.contact-section .ui-btn:focus i {
  color:#ffffff!important
}
.contact-section .form-bottom {
  align-items:center!important
}
.contact-section .form-bottom .ui-btn {
  min-width:132px!important
}
.contact-section .map-card .ui-btn,.contact-section .branch-notes .ui-btn {
  min-width:124px!important;
  align-self:center!important
}
.contact-section .icon-orange,.printify-footer .footer-links a i,.printify-footer .footer-contact-list i,.printify-footer .footer-title-line {
  color:var(--ui-orange)!important
}
.contact-section .icon-green {
  color:#16a34a!important
}
.contact-section .icon-blue {
  color:#2563eb!important
}
.contact-section .icon-purple {
  color:#7c3aed!important
}
.contact-section .icon-red {
  color:#ef4444!important
}
.contact-section .icon-black {
  color:#111827!important
}
.contact-section .fa-phone,.printify-footer .fa-phone {
  color:#16a34a!important
}
.contact-section .fa-envelope,.printify-footer .fa-envelope {
  color:#2563eb!important
}
.contact-section .fa-clock,.printify-footer .fa-clock {
  color:var(--ui-orange)!important
}
.contact-section .fa-location-dot,.contact-section .fa-map-pin,.contact-section .fa-map-location-dot {
  color:#ef4444!important
}
.contact-section .fa-headset,.contact-section .fa-message,.contact-section .fa-comment-dots {
  color:#111827!important
}
.contact-section .fa-truck-fast,.contact-section .fa-truck {
  color:#7c3aed!important
}
.contact-section .fa-file-lines,.contact-section .fa-list-ul {
  color:#16a34a!important
}
.contact-section .fa-cube,.contact-section .fa-share-nodes {
  color:#7c3aed!important
}
.contact-section .fa-paper-plane,.contact-section .fa-circle-question {
  color:var(--ui-orange)!important
}
.contact-card,.no-box,.info-card,.quick-answer-card,.map-card,.branch-card,.branch-item,.footer-links a,.footer-socials a,.quick-answer-card button {
  transform:none!important
}
.contact-card:hover,.info-card:hover,.map-card:hover,.quick-answer-card:hover {
  background:#ffffff!important;
  box-shadow:none!important
}
.input-wrapper input:hover,.input-wrapper select:hover,.input-wrapper textarea:hover,.quick-answer-card button:hover,.branch-item:hover,.footer-links a:hover,.footer-contact-list p:hover {
  background:linear-gradient(180deg,rgba(17,24,39,.10),rgba(17,24,39,.06))!important;
  color:#111827!important;
  transform:none!important
}
.quick-answer-card button:hover i {
  color:inherit!important
}
.quick-answer-card button:hover b,.quick-answer-card button:focus b {
  color:#111827!important
}
.quick-answer-card button:focus {
  outline:0!important;
  background:linear-gradient(180deg,rgba(17,24,39,.10),rgba(17,24,39,.06))!important
}
.branch-card,.branch-card.main-box {
  border:0!important;
  box-shadow:none!important;
  background:transparent!important;
  padding:0!important;
  border-radius:0!important;
  min-height:auto!important
}
.branch-card h3 {
  margin-bottom:0!important
}
.branch-content {
  margin-top:22px!important;
  gap:38px!important;
  align-items:start!important;
  grid-template-columns:minmax(0,1fr) 215px!important
}
.branch-list {
  gap:34px!important
}
.branch-item {
  padding:3px 0!important
}
.branch-item+.branch-item {
  padding-left:20px!important;
  border-left:1px solid #eef1f5!important
}
.branch-item b {
  margin-bottom:10px!important
}
.branch-item span,.branch-item small {
  margin-bottom:12px!important
}
.branch-item p {
  margin-bottom:10px!important;
  line-height:1.42!important;
  align-items:flex-start!important
}
.branch-notes {
  min-height:154px!important;
  gap:18px!important
}
.branch-notes p {
  margin-bottom:16px!important;
  line-height:1.52!important
}
.quick-answer-card button {
  border-radius:8px!important;
  padding:0 8px!important;
  border-bottom:1px solid #eef1f5!important;
  transition:background .18s ease,color .18s ease,border-color .18s ease!important
}
.quick-answer-card button span {
  background:transparent!important
}
.quick-answer-card button b {
  font-weight:500!important
}
.printify-footer {
  box-shadow:none!important
}
.footer-top-line {
  background:linear-gradient(90deg,var(--ui-orange-start),var(--ui-orange-end))!important
}
.footer-main {
  gap:30px!important;
  padding:16px 70px 14px!important
}
.footer-col {
  min-height:82px!important
}
.footer-links {
  gap:16px 20px!important
}
.footer-links a,.footer-contact-list p {
  transition:color .18s ease,background .18s ease!important;
  border-radius:8px!important;
  padding:2px 0!important
}
.footer-links a:hover,.footer-contact-list p:hover {
  color:#ffffff!important;
  transform:none!important
}
.footer-socials {
  gap:10px!important
}
.footer-socials a {
  box-shadow:none!important;
  transition:background .18s ease,color .18s ease,border-color .18s ease!important
}
.footer-socials a:hover {
  transform:none!important;
  filter:brightness(.92)!important
}
.footer-bottom {
  padding-top:10px!important;
  padding-bottom:10px!important
}
@media (max-width:1180px) {
  .branch-card,.branch-card.main-box {
    padding:0!important
  }
  .branch-item+.branch-item {
    padding-left:0!important;
    border-left:0!important
  }
  .branch-content {
    grid-template-columns:1fr!important
  }
  .footer-main {
    padding:24px 30px!important;
    gap:26px!important
  }
}
.map-card,.map-card.no-box {
  position:relative!important;
  display:flex!important;
  flex-direction:column!important;
  gap:16px!important;
  background:#ffffff!important;
  border:0!important;
  box-shadow:none!important;
  padding:0!important;
  overflow:visible!important
}
.map-head {
  position:relative!important;
  z-index:1!important
}
.map-frame {
  position:relative!important;
  z-index:1!important;
  width:100%!important;
  min-height:235px!important;
  height:235px!important;
  border:1px solid #dde3ec!important;
  border-radius:10px!important;
  overflow:hidden!important;
  background:#edf2f7!important;
  pointer-events:auto!important;
  touch-action:auto!important
}
.map-frame iframe {
  width:100%!important;
  height:100%!important;
  min-height:235px!important;
  display:block!important;
  border:0!important;
  pointer-events:auto!important;
  touch-action:auto!important;
  user-select:auto!important
}
.map-frame::before,.map-frame::after,.map-card::before,.map-card::after {
  content:none!important;
  display:none!important;
  pointer-events:none!important
}
.contact-extra {
  display:flex!important;
  flex-direction:column!important;
  gap:24px!important
}
.quick-answer-card {
  margin-bottom:2px!important
}
.map-head p {
  margin-bottom:12px!important
}
.map-card .ui-btn {
  margin-bottom:0!important
}
</style>
<style id="contact-absolute-last-request-lock-0615">
#contact .branch-item small {
  text-align:center!important;
  width:100%!important
}
#contact .branch-address,
#contact .branch-address + .branch-meta {
  padding-bottom:10px!important;
  border-bottom:1px solid #e4e9f1!important
}
#contact .branch-address,
#contact .branch-meta,
#contact .contact-info-item {
  align-items:center!important
}
#contact .branch-address i,
#contact .branch-meta i,
#contact .contact-info-item>i,
#contact .quick-answer-card button span {
  align-self:center!important;
  justify-self:center!important
}
#contact .contact-info-copy {
  justify-content:center!important
}
#contact .form-bottom {
  display:grid!important;
  grid-template-columns:minmax(0,1fr) auto!important;
  align-items:center!important
}
#contact .form-bottom small {
  max-width:none!important;
  white-space:nowrap!important;
  line-height:1!important
}
#contact .form-bottom small i {
  flex:0 0 auto!important
}
#contact .orange-btn:hover,
#contact .orange-btn:focus,
#contact .ui-btn.orange-btn:hover,
#contact .ui-btn.orange-btn:focus {
  background:#111!important;
  color:#fff!important;
  filter:none!important
}
#contact .orange-btn:hover i,
#contact .orange-btn:focus i,
#contact .ui-btn.orange-btn:hover i,
#contact .ui-btn.orange-btn:focus i {
  color:#fff!important
}
@media(max-width:1320px) {
  #contact .form-bottom small {
    font-size:11px!important
  }
}
@media(max-width:1080px) {
  #contact .form-bottom {
    grid-template-columns:1fr!important;
    justify-items:start!important
  }
  #contact .form-bottom small {
    white-space:normal!important
  }
}
</style>
<style id="contact-input-icon-field-consistency-0615">
#contact .input-wrap i,
#contact .upload-box i,
#contact .privacy-line i {
  color:#1f2937!important;
  font-size:14px!important;
}
#contact input,
#contact textarea,
#contact .upload-box {
  border-color:#6b7280!important;
}
#contact .touch-box>i,
#contact .branch-head>i,
#contact .quick-answer-card>h3>i,
#contact .branch-notes i,
#contact .branch-meta i,
#contact .info-icon i {
  font-size:18px!important;
}
</style>
<style id="contact-requested-branch-lines-final-0615">
#contact .branch-item small {
  text-align:center!important;
  width:100%!important
}
#contact .branch-address,
#contact .branch-address + .branch-meta {
  padding-bottom:10px!important;
  border-bottom:1px solid #e4e9f1!important
}
#contact .branch-address,
#contact .branch-meta {
  align-items:center!important
}
#contact .branch-address i,
#contact .branch-meta i,
#contact .contact-info-item>i,
#contact .quick-answer-card button span {
  align-self:center!important;
  justify-self:center!important
}
#contact .contact-info-item {
  align-items:center!important
}
#contact .contact-info-copy {
  justify-content:center!important
}
#contact .form-bottom {
  display:grid!important;
  grid-template-columns:minmax(0,1fr) auto!important;
  align-items:center!important
}
#contact .form-bottom small {
  max-width:none!important;
  white-space:nowrap!important;
  line-height:1!important
}
#contact .form-bottom small i {
  flex:0 0 auto!important
}
#contact .orange-btn:hover,
#contact .orange-btn:focus,
#contact .ui-btn.orange-btn:hover,
#contact .ui-btn.orange-btn:focus {
  background:#111!important;
  color:#fff!important;
  filter:none!important
}
#contact .orange-btn:hover i,
#contact .orange-btn:focus i,
#contact .ui-btn.orange-btn:hover i,
#contact .ui-btn.orange-btn:focus i {
  color:#fff!important
}
@media(max-width:1320px) {
  #contact .form-bottom small {
    font-size:11px!important
  }
}
@media(max-width:1080px) {
  #contact .form-bottom {
    grid-template-columns:1fr!important;
    justify-items:start!important
  }
  #contact .form-bottom small {
    white-space:normal!important
  }
}
</style>
<style id="contact-absolute-last-request-lock-0615">
#contact .branch-item small {
  text-align:center!important;
  width:100%!important
}
#contact .branch-address,
#contact .branch-address + .branch-meta {
  padding-bottom:10px!important;
  border-bottom:1px solid #e4e9f1!important
}
#contact .branch-address,
#contact .branch-meta,
#contact .contact-info-item {
  align-items:center!important
}
#contact .branch-address i,
#contact .branch-meta i,
#contact .contact-info-item>i,
#contact .quick-answer-card button span {
  align-self:center!important;
  justify-self:center!important
}
#contact .contact-info-copy {
  justify-content:center!important
}
#contact .form-bottom {
  display:grid!important;
  grid-template-columns:minmax(0,1fr) auto!important;
  align-items:center!important
}
#contact .form-bottom small {
  max-width:none!important;
  white-space:nowrap!important;
  line-height:1!important
}
#contact .form-bottom small i {
  flex:0 0 auto!important
}
#contact .orange-btn:hover,
#contact .orange-btn:focus,
#contact .ui-btn.orange-btn:hover,
#contact .ui-btn.orange-btn:focus {
  background:#111!important;
  color:#fff!important;
  filter:none!important
}
#contact .orange-btn:hover i,
#contact .orange-btn:focus i,
#contact .ui-btn.orange-btn:hover i,
#contact .ui-btn.orange-btn:focus i {
  color:#fff!important
}
@media(max-width:1320px) {
  #contact .form-bottom small {
    font-size:11px!important
  }
}
@media(max-width:1080px) {
  #contact .form-bottom {
    grid-template-columns:1fr!important;
    justify-items:start!important
  }
  #contact .form-bottom small {
    white-space:normal!important
  }
}
</style>
<style id="contact-final-compact-lock-0615">
#contact.contact-section {
  padding:26px 70px 30px!important
}
#contact .contact-head {
  margin:0 0 20px!important
}
#contact .contact-head h2 {
  margin:0 0 10px!important
}
#contact .contact-grid {
  display:grid!important;
  grid-template-columns:360px minmax(0,1fr)!important;
  column-gap:42px!important;
  row-gap:18px!important;
  align-items:start!important
}
#contact .form-card {
  width:360px!important;
  max-width:360px!important;
  min-height:0!important;
  padding:16px 18px 14px!important
}
#contact .form-card .card-title {
  grid-template-columns:34px minmax(0,1fr)!important;
  gap:12px!important;
  margin-bottom:12px!important
}
#contact .form-card .card-title>i {
  width:34px!important;
  min-width:34px!important;
  font-size:28px!important
}
#contact .form-fields {
  gap:7px!important
}
#contact .form-row>span {
  margin-bottom:4px!important
}
#contact .input-wrapper i {
  left:12px!important;
  width:14px!important;
  font-size:12px!important
}
#contact .input-wrapper input {
  height:31px!important;
  min-height:31px!important;
  padding-left:34px!important
}
#contact .input-wrapper textarea {
  height:70px!important;
  min-height:70px!important;
  padding:10px 12px 8px 34px!important
}
#contact .textarea-wrapper i {
  top:12px!important
}
#contact .upload-drop {
  min-height:44px!important;
  padding:7px 10px!important;
  gap:9px!important
}
#contact .upload-drop i {
  font-size:18px!important
}
#contact .form-bottom {
  margin-top:10px!important;
  gap:12px!important
}
#contact .form-bottom small {
  display:flex!important;
  align-items:center!important;
  gap:8px!important;
  max-width:155px!important;
  line-height:1.2!important
}
#contact .orange-btn,
#contact .ui-btn.orange-btn {
  background:linear-gradient(90deg,#FE7B09,#FFAB0A)!important;
  color:#fff!important;
  border:0!important;
  box-shadow:none!important
}
#contact .orange-btn:hover,
#contact .orange-btn:focus,
#contact .ui-btn.orange-btn:hover,
#contact .ui-btn.orange-btn:focus {
  background:linear-gradient(90deg,#FE7B09,#FFAB0A)!important;
  color:#fff!important;
  filter:brightness(.98)!important
}
#contact .contact-details {
  gap:22px!important;
  padding-top:6px!important
}
#contact .contact-details .info-card {
  grid-template-columns:230px minmax(0,1fr)!important;
  gap:30px!important
}
#contact .touch-box {
  width:230px!important;
  padding-right:24px!important
}
#contact .touch-box>h3,
#contact .branch-card>h3,
#contact .quick-answer-card>h3 {
  gap:10px!important;
  margin:0 0 16px!important;
  align-items:center!important
}
#contact .touch-box>h3 i,
#contact .branch-card>h3 i,
#contact .quick-answer-card>h3 i {
  width:20px!important;
  min-width:20px!important;
  font-size:20px!important
}
#contact .contact-info-item {
  display:grid!important;
  grid-template-columns:18px minmax(0,1fr)!important;
  gap:10px!important;
  align-items:start!important;
  margin:0 0 14px!important
}
#contact .contact-info-item>i {
  width:18px!important;
  min-width:18px!important;
  font-size:15px!important;
  line-height:1.25!important;
  text-align:center!important
}
#contact .contact-info-copy {
  gap:3px!important;
  line-height:1.22!important
}
#contact .branch-list {
  display:grid!important;
  grid-template-columns:minmax(0,1fr) minmax(0,1fr)!important;
  gap:26px!important
}
#contact .branch-item+.branch-item {
  padding-left:26px!important
}
#contact .branch-item small {
  text-align:center!important;
  margin:0 0 16px!important
}
#contact .branch-address {
  gap:9px!important;
  margin-bottom:15px!important
}
#contact .branch-address i {
  flex:0 0 15px!important;
  width:15px!important;
  font-size:15px!important;
  text-align:center!important
}
#contact .branch-address span {
  white-space:nowrap!important;
  line-height:1.15!important
}
#contact .branch-meta {
  display:grid!important;
  grid-template-columns:15px max-content max-content!important;
  gap:9px!important;
  align-items:center!important;
  margin:0 0 15px!important
}
#contact .branch-meta i {
  flex:0 0 15px!important;
  width:15px!important;
  font-size:13px!important;
  text-align:center!important
}
#contact .branch-meta span,
#contact .branch-meta b {
  white-space:nowrap!important;
  line-height:1.15!important
}
#contact .quick-row {
  grid-template-columns:300px minmax(0,1fr)!important;
  gap:32px!important
}
#contact .quick-answer-card>h3 {
  margin-bottom:10px!important
}
#contact .quick-answer-card button {
  height:31px!important;
  grid-template-columns:20px minmax(0,1fr) 12px!important;
  column-gap:9px!important
}
#contact .quick-answer-card button span {
  width:20px!important;
  height:20px!important
}
#contact .quick-answer-card button span i,
#contact .quick-answer-card button>i {
  font-size:12px!important
}
#contact .branch-notes {
  min-height:74px!important;
  padding-left:32px!important;
  gap:16px!important
}
#contact .branch-notes p {
  grid-template-columns:20px max-content!important;
  gap:16px!important;
  white-space:nowrap!important
}
#contact .branch-notes p i {
  width:20px!important;
  font-size:18px!important
}
#contact .branch-notes p span,
#contact .branch-notes p {
  white-space:nowrap!important
}
@media(max-width:1320px) {
  #contact.contact-section {
    padding:24px 42px 30px!important
  }
  #contact .contact-grid {
    grid-template-columns:340px minmax(0,1fr)!important;
    column-gap:26px!important
  }
  #contact .form-card {
    width:340px!important;
    max-width:340px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:210px minmax(0,1fr)!important;
    gap:24px!important
  }
  #contact .touch-box {
    width:210px!important;
    padding-right:20px!important
  }
  #contact .branch-list {
    gap:18px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:18px!important
  }
  #contact .branch-address span,
  #contact .branch-meta span,
  #contact .branch-meta b,
  #contact .branch-notes p {
    font-size:11px!important
  }
}
@media(max-width:1080px) {
  #contact.contact-section {
    padding:28px 22px 36px!important
  }
  #contact .contact-grid,
  #contact .contact-details .info-card,
  #contact .branch-list,
  #contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .form-card,
  #contact .touch-box {
    width:100%!important;
    max-width:none!important
  }
  #contact .touch-box,
  #contact .branch-item+.branch-item,
  #contact .branch-notes {
    padding-left:0!important;
    padding-right:0!important
  }
  #contact .branch-address span,
  #contact .branch-meta span,
  #contact .branch-meta b,
  #contact .branch-notes p,
  #contact .branch-notes p span {
    white-space:normal!important
  }
}
</style>
<style id="contact-alignment-clean-pass-0615">
#contact.contact-section {
  padding-top:34px!important;
  padding-bottom:36px!important
}
#contact .contact-head {
  margin-bottom:22px!important
}
#contact .contact-head h2 {
  margin-bottom:12px!important
}
#contact .contact-grid {
  grid-template-columns:390px minmax(0,1fr)!important;
  column-gap:48px!important;
  row-gap:24px!important
}
#contact .form-card {
  width:390px!important;
  max-width:390px!important;
  padding:18px 20px 16px!important
}
#contact .form-fields {
  gap:10px!important
}
#contact .input-wrapper input {
  height:35px!important;
  min-height:35px!important
}
#contact .input-wrapper textarea {
  height:86px!important;
  min-height:86px!important
}
#contact .upload-drop {
  min-height:54px!important;
  padding:8px 12px!important
}
#contact .form-bottom {
  margin-top:12px!important
}
#contact .contact-details {
  gap:28px!important;
  padding-top:4px!important
}
#contact .contact-details .info-card {
  grid-template-columns:260px minmax(0,1fr)!important;
  gap:36px!important
}
#contact .touch-box {
  width:260px!important;
  padding-right:28px!important
}
#contact .touch-box>h3,
#contact .branch-card>h3,
#contact .quick-answer-card>h3 {
  margin-bottom:20px!important
}
#contact .touch-box>h3 i,
#contact .branch-card>h3 i,
#contact .quick-answer-card>h3 i {
  width:22px!important;
  min-width:22px!important;
  font-size:22px!important
}
#contact .contact-info-item {
  grid-template-columns:20px minmax(0,1fr)!important;
  gap:14px!important;
  margin-bottom:18px!important;
  align-items:start!important
}
#contact .contact-info-item>i {
  width:20px!important;
  min-width:20px!important;
  font-size:17px!important;
  line-height:1.2!important
}
#contact .contact-info-copy {
  gap:4px!important;
  line-height:1.25!important
}
#contact .contact-info-copy b,
#contact .contact-info-copy span,
#contact .contact-info-copy small {
  white-space:nowrap!important
}
#contact .branch-card>h3 {
  margin-left:0!important
}
#contact .branch-list {
  gap:36px!important
}
#contact .branch-item {
  text-align:left!important
}
#contact .branch-item+.branch-item {
  padding-left:36px!important
}
#contact .branch-item small {
  display:block!important;
  text-align:center!important;
  margin:0 0 20px!important
}
#contact .branch-address {
  justify-content:flex-start!important;
  gap:12px!important;
  margin-bottom:20px!important
}
#contact .branch-address i {
  flex:0 0 16px!important;
  width:16px!important;
  font-size:16px!important
}
#contact .branch-address span {
  white-space:nowrap!important
}
#contact .branch-meta {
  display:grid!important;
  grid-template-columns:16px max-content max-content!important;
  align-items:center!important;
  gap:12px!important;
  margin-bottom:18px!important
}
#contact .branch-meta i {
  flex:0 0 16px!important;
  width:16px!important;
  font-size:14px!important
}
#contact .branch-meta span,
#contact .branch-meta b {
  white-space:nowrap!important
}
#contact .quick-row {
  grid-template-columns:320px minmax(0,1fr)!important;
  gap:40px!important
}
#contact .quick-answer-card>h3 {
  margin-bottom:12px!important
}
#contact .quick-answer-card button {
  height:34px!important;
  grid-template-columns:22px minmax(0,1fr) 14px!important
}
#contact .quick-answer-card button span {
  width:22px!important;
  height:22px!important
}
#contact .branch-notes {
  min-height:82px!important;
  padding-left:40px!important;
  gap:18px!important
}
#contact .branch-notes p {
  grid-template-columns:22px max-content!important;
  gap:18px!important;
  white-space:nowrap!important
}
#contact .branch-notes p i {
  width:22px!important;
  font-size:20px!important
}
#contact .branch-notes p span,
#contact .branch-notes p {
  white-space:nowrap!important
}
@media(max-width:1320px) {
  #contact.contact-section {
    padding-left:42px!important;
    padding-right:42px!important
  }
  #contact .contact-grid {
    grid-template-columns:370px minmax(0,1fr)!important;
    column-gap:30px!important
  }
  #contact .form-card {
    width:370px!important;
    max-width:370px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:240px minmax(0,1fr)!important;
    gap:28px!important
  }
  #contact .touch-box {
    width:240px!important;
    padding-right:24px!important
  }
  #contact .branch-list {
    gap:26px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:26px!important
  }
  #contact .branch-address span,
  #contact .branch-meta span,
  #contact .branch-meta b,
  #contact .branch-notes p {
    font-size:12px!important
  }
}
@media(max-width:1080px) {
  #contact.contact-section {
    padding:30px 22px 38px!important
  }
  #contact .contact-grid,
  #contact .contact-details .info-card,
  #contact .branch-list,
  #contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .form-card,
  #contact .touch-box {
    width:100%!important;
    max-width:none!important
  }
  #contact .touch-box,
  #contact .branch-item+.branch-item,
  #contact .branch-notes {
    padding-left:0!important;
    padding-right:0!important
  }
  #contact .branch-address span,
  #contact .branch-meta span,
  #contact .branch-meta b,
  #contact .branch-notes p {
    white-space:normal!important
  }
}
</style>
<script>
const contactToast = document.getElementById("contactToast");
const contactForm = document.getElementById("contactForm");
let contactToastTimer;
function showContactFeedback(message) {
  if (!contactToast) return;
  contactToast.textContent = message;
  contactToast.classList.add("show");
  clearTimeout(contactToastTimer);
  contactToastTimer = setTimeout(() => contactToast.classList.remove("show"), 2600);
} window.addEventListener("printify-front-feedback", event => {
  showContactFeedback(event.detail?.message || "Action completed.");
});
if (contactForm) {
  contactForm.addEventListener("submit", function(e) {
    const requiredFields = contactForm.querySelectorAll("[required]");
    let valid = true;
    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        field.style.borderColor = "#d60000";
        valid = false;
      } else {
        field.style.borderColor = "#d9dee7";
      }
    });
    const email = contactForm.querySelector('input[name="email"]');
    if (email && !email.checkValidity()) {
      email.style.borderColor = "#d60000";
      valid = false;
    } if (!valid) {
      e.preventDefault();
      showContactFeedback("Please complete the required contact fields.");
    } else {
      showContactFeedback("Sending your inquiry...");
    }
  });
} const contactSubmitStatus = <?php echo json_encode($status);
?>;
if (contactSubmitStatus === "success") showContactFeedback("Your inquiry was sent successfully.");
if (contactSubmitStatus === "error") showContactFeedback("Please complete all required fields properly.");
function openMap() {
  showContactFeedback("Opening map directions...");
  window.open("https://www.google.com/maps/search/?api=1&query=Makati+City+Metro+Manila+Philippines", "_blank");
} function contactQuickAnswer(topic) {
  const service = document.querySelector('select[name="service"]');
  const turnaround = document.querySelector('select[name="turnaround"]');
  const message = document.querySelector('textarea[name="message"]');
  if (topic === "Turnaround Time" && turnaround) turnaround.value = "Rush Order";
  if ((topic === "Request a Quote" || topic === "File Guide") && service) service.value = "Custom Design";
  if (message) {
    message.value = `Hi Printify, I need help with ${topic}.`;
    message.focus();
    message.scrollIntoView({
      behavior: "smooth", block: "center"
    });
  } showContactFeedback(`${topic} selected.`);
} function focusContactMessage() {
  const message = document.querySelector('textarea[name="message"]');
  if (message) {
    message.focus();
    message.scrollIntoView({
      behavior: "smooth", block: "center"
    });
    showContactFeedback("Message box is ready.");
  }
}
</script>
<style>
.contact-section {
  padding-top:46px!important;
  padding-bottom:76px!important
}
.contact-container {
  max-width:1450px!important
}
.contact-head {
  margin-bottom:26px!important
}
.contact-grid {
  gap:30px!important;
  align-items:start!important
}
.contact-card,.no-box,.info-card,.quick-answer-card,.map-card,.branch-card {
  box-shadow:none!important
}
.form-card .input-wrapper i,.form-card .form-bottom small i {
  color:#111827!important;
  opacity:.88!important
}
.form-card .input-wrapper:focus-within i {
  color:#111827!important;
  opacity:1!important
}
.form-card .card-title>i {
  color:var(--ui-orange)!important
}
.form-card {
  padding:22px 18px 20px!important
}
.card-title {
  margin-bottom:20px!important;
  gap:14px!important
}
.card-title h3 {
  font-size:21px!important;
  line-height:1.05!important
}
.card-title p {
  font-size:10.8px!important;
  line-height:1.35!important
}
.form-fields {
  gap:20px!important
}
.two-col {
  gap:16px!important
}
.form-row label {
  margin-bottom:9px!important
}
.input-wrapper i {
  left:13px!important;
  font-size:13px!important
}
.input-wrapper input,.input-wrapper select {
  height:44px!important;
  font-size:11.5px!important;
  padding-left:38px!important
}
.input-wrapper textarea {
  height:136px!important;
  min-height:136px!important;
  font-size:11.5px!important;
  padding-left:38px!important
}
.textarea-wrapper i {
  top:15px!important
}
.form-bottom {
  margin-top:24px!important;
  gap:18px!important
}
.middle-side,.contact-extra {
  gap:28px!important
}
.info-card {
  padding:18px 0!important;
  gap:18px!important
}
.touch-box {
  padding-right:22px!important
}
.hours-box {
  padding-left:18px!important
}
.info-card h3,.quick-answer-card h3,.map-head h3,.branch-card h3 {
  margin-bottom:18px!important
}
.info-card p {
  margin-bottom:17px!important;
  line-height:1.42!important
}
.info-card li {
  padding:13px 0!important
}
.socials {
  margin-top:4px!important
}
.branch-card,.branch-card.main-box {
  padding-top:2px!important
}
.branch-content {
  margin-top:24px!important;
  gap:40px!important;
  grid-template-columns:minmax(0,1fr) 215px!important
}
.branch-list {
  gap:36px!important
}
.branch-item b {
  margin-bottom:10px!important
}
.branch-item span,.branch-item small {
  margin-bottom:12px!important
}
.branch-item p {
  margin-bottom:10px!important;
  line-height:1.45!important;
  gap:9px!important
}
.branch-notes {
  gap:18px!important
}
.branch-notes p {
  line-height:1.52!important;
  margin-bottom:16px!important
}
.quick-answer-card {
  padding-top:22px!important
}
.quick-answer-card button {
  height:58px!important;
  padding:0 10px!important
}
.map-card {
  padding-top:20px!important
}
.map-head p {
  margin-bottom:16px!important
}
.map-card button {
  margin-bottom:20px!important
}
.footer-main {
  padding-top:20px!important;
  padding-bottom:18px!important;
  gap:34px!important
}
.footer-col {
  min-height:90px!important
}
.footer-title-line {
  margin-top:10px!important;
  margin-bottom:13px!important
}
.footer-contact-list {
  gap:8px!important
}
.policy-grid {
  gap:12px 20px!important
}
.footer-socials {
  gap:12px!important
}
.footer-bottom {
  padding-top:12px!important;
  padding-bottom:12px!important
}
.contact-section *:hover,.printify-footer *:hover {
  transform:none!important
}
.input-wrapper input:hover,.input-wrapper select:hover,.input-wrapper textarea:hover,.quick-answer-card button:hover,.branch-item:hover,.footer-links a:hover,.footer-contact-list p:hover {
  background:linear-gradient(180deg,rgba(17,24,39,.09),rgba(17,24,39,.045))!important
}
@media(max-width:1320px) {
  .contact-grid {
    gap:24px!important
  }
  .middle-side,.contact-extra {
    gap:24px!important
  }
  .branch-content {
    gap:30px!important;
    grid-template-columns:minmax(0,1fr) 200px!important
  }
  .branch-list {
    gap:28px!important
  }
}
@media(max-width:1180px) {
  .branch-content {
    grid-template-columns:1fr!important
  }
}
@media(max-width:760px) {
  .contact-section {
    padding-top:30px!important;
    padding-bottom:52px!important
  }
  .contact-grid {
    gap:22px!important
  }
  .form-card {
    padding:20px 16px!important
  }
  .form-bottom {
    gap:14px!important
  }
  .branch-content {
    gap:22px!important
  }
  .branch-list {
    gap:20px!important
  }
}
</style>
<style>
#contact,#contact p,#contact span,#contact a,#contact li,#contact small,#contact div,#contact input,#contact textarea,#contact select,#contact button,#contact .btn,#contact input[type="submit"],.contact,.contact p,.contact span,.contact a,.contact li,.contact small,.contact div,.contact input,.contact textarea,.contact select,.contact button,.contact .btn,.contact input[type="submit"],.contactus,.contactus p,.contactus span,.contactus a,.contactus li,.contactus small,.contactus div,.contactus input,.contactus textarea,.contactus select,.contactus button,.contactus .btn,.contactus input[type="submit"],.contact-us,.contact-us p,.contact-us span,.contact-us a,.contact-us li,.contact-us small,.contact-us div,.contact-us input,.contact-us textarea,.contact-us select,.contact-us button,.contact-us .btn,.contact-us input[type="submit"],.pfcontact,.pfcontact p,.pfcontact span,.pfcontact a,.pfcontact li,.pfcontact small,.pfcontact div,.pfcontact input,.pfcontact textarea,.pfcontact select,.pfcontact button,.pfcontact .btn,.pfcontact input[type="submit"],.pf-contact,.pf-contact p,.pf-contact span,.pf-contact a,.pf-contact li,.pf-contact small,.pf-contact div,.pf-contact input,.pf-contact textarea,.pf-contact select,.pf-contact button,.pf-contact .btn,.pf-contact input[type="submit"] {
  font-family:'Inter Local',system-ui,sans-serif!important
}
#contact h1,#contact h2,#contact h3,#contact h4,#contact h5,#contact h6,#contact label,#contact strong,#contact b,#contact .section-title,#contact .section-subtitle,#contact .contact-title,#contact .contact-subtitle,#contact .card-title,#contact .form-title,#contact .contact-card-title,#contact .quick-title,#contact .branch-title,#contact .kicker,#contact .eyebrow,.contact h1,.contact h2,.contact h3,.contact h4,.contact h5,.contact h6,.contact label,.contact strong,.contact b,.contact .section-title,.contact .section-subtitle,.contact .contact-title,.contact .contact-subtitle,.contact .card-title,.contact .form-title,.contact .contact-card-title,.contact .quick-title,.contact .branch-title,.contact .kicker,.contact .eyebrow,.contactus h1,.contactus h2,.contactus h3,.contactus h4,.contactus h5,.contactus h6,.contactus label,.contactus strong,.contactus b,.contactus .section-title,.contactus .section-subtitle,.contactus .contact-title,.contactus .contact-subtitle,.contactus .card-title,.contactus .form-title,.contactus .contact-card-title,.contactus .quick-title,.contactus .branch-title,.contactus .kicker,.contactus .eyebrow,.contact-us h1,.contact-us h2,.contact-us h3,.contact-us h4,.contact-us h5,.contact-us h6,.contact-us label,.contact-us strong,.contact-us b,.contact-us .section-title,.contact-us .section-subtitle,.contact-us .contact-title,.contact-us .contact-subtitle,.contact-us .card-title,.contact-us .form-title,.contact-us .contact-card-title,.contact-us .quick-title,.contact-us .branch-title,.contact-us .kicker,.contact-us .eyebrow,.pfcontact h1,.pfcontact h2,.pfcontact h3,.pfcontact h4,.pfcontact h5,.pfcontact h6,.pfcontact label,.pfcontact strong,.pfcontact b,.pfcontact .section-title,.pfcontact .section-subtitle,.pfcontact .contact-title,.pfcontact .contact-subtitle,.pfcontact .card-title,.pfcontact .form-title,.pfcontact .contact-card-title,.pfcontact .quick-title,.pfcontact .branch-title,.pfcontact .kicker,.pfcontact .eyebrow,.pf-contact h1,.pf-contact h2,.pf-contact h3,.pf-contact h4,.pf-contact h5,.pf-contact h6,.pf-contact label,.pf-contact strong,.pf-contact b,.pf-contact .section-title,.pf-contact .section-subtitle,.pf-contact .contact-title,.pf-contact .contact-subtitle,.pf-contact .card-title,.pf-contact .form-title,.pf-contact .contact-card-title,.pf-contact .quick-title,.pf-contact .branch-title,.pf-contact .kicker,.pf-contact .eyebrow {
  font-family:'League Spartan',system-ui,sans-serif!important
}
.brand-main-text,.printify-brand,.printify-logo {
  font-family:'Boxing',serif!important
}
</style>
<style>
#contact p,#contact span,#contact a,#contact li,#contact small,#contact td,#contact th,#contact input,#contact textarea,#contact select,#contact button,#contact .btn,#contact input[type="submit"],.contact p,.contact span,.contact a,.contact li,.contact small,.contact td,.contact th,.contact input,.contact textarea,.contact select,.contact button,.contact .btn,.contact input[type="submit"],.contactus p,.contactus span,.contactus a,.contactus li,.contactus small,.contactus td,.contactus th,.contactus input,.contactus textarea,.contactus select,.contactus button,.contactus .btn,.contactus input[type="submit"],.contact-us p,.contact-us span,.contact-us a,.contact-us li,.contact-us small,.contact-us td,.contact-us th,.contact-us input,.contact-us textarea,.contact-us select,.contact-us button,.contact-us .btn,.contact-us input[type="submit"],.pfcontact p,.pfcontact span,.pfcontact a,.pfcontact li,.pfcontact small,.pfcontact td,.pfcontact th,.pfcontact input,.pfcontact textarea,.pfcontact select,.pfcontact button,.pfcontact .btn,.pfcontact input[type="submit"],.pf-contact p,.pf-contact span,.pf-contact a,.pf-contact li,.pf-contact small,.pf-contact td,.pf-contact th,.pf-contact input,.pf-contact textarea,.pf-contact select,.pf-contact button,.pf-contact .btn,.pf-contact input[type="submit"] {
  font-family:'Inter Local',system-ui,sans-serif!important;
  font-size:14px!important;
  line-height:1.5!important;
  letter-spacing:.18px!important
}
</style>
<style>
#contact p,#contact span,#contact a,#contact li,#contact small,#contact td,#contact th,#contact input,#contact textarea,#contact select,#contact button,#contact .btn,#contact input[type="submit"],.contact p,.contact span,.contact a,.contact li,.contact small,.contact td,.contact th,.contact input,.contact textarea,.contact select,.contact button,.contact .btn,.contact input[type="submit"],.contactus p,.contactus span,.contactus a,.contactus li,.contactus small,.contactus td,.contactus th,.contactus input,.contactus textarea,.contactus select,.contactus button,.contactus .btn,.contactus input[type="submit"],.contact-us p,.contact-us span,.contact-us a,.contact-us li,.contact-us small,.contact-us td,.contact-us th,.contact-us input,.contact-us textarea,.contact-us select,.contact-us button,.contact-us .btn,.contact-us input[type="submit"],.pfcontact p,.pfcontact span,.pfcontact a,.pfcontact li,.pfcontact small,.pfcontact td,.pfcontact th,.pfcontact input,.pfcontact textarea,.pfcontact select,.pfcontact button,.pfcontact .btn,.pfcontact input[type="submit"],.pf-contact p,.pf-contact span,.pf-contact a,.pf-contact li,.pf-contact small,.pf-contact td,.pf-contact th,.pf-contact input,.pf-contact textarea,.pf-contact select,.pf-contact button,.pf-contact .btn,.pf-contact input[type="submit"] {
  font-family:'Inter Local',system-ui,sans-serif!important;
  font-size:14px!important;
  font-weight:600!important;
  line-height:1.5!important;
  letter-spacing:.18px!important
}
#contact i,.contact i,.contactus i,.contact-us i,.pfcontact i,.pf-contact i {
  letter-spacing:0!important
}
</style>
<style id="printify-final-font-fix">
@font-face {
  font-family:'BoxingFinal';
  src:url('/Fonts/Boxing-Regular.otf') format('opentype');
  font-weight:400;
  font-style:normal;
  font-display:swap
}
@font-face {
  font-family:'LeagueSpartanFinal';
  src:url('/Fonts/LeagueSpartan-SemiBold.otf') format('opentype');
  font-weight:600;
  font-style:normal;
  font-display:swap
}
@font-face {
  font-family:'InterFinal';
  src:url('/Fonts/Inter.ttc') format('truetype-collection');
  font-weight:600;
  font-style:normal;
  font-display:swap
}
#contact,#contact:where(p,span,a,li,small,td,th,input,textarea,select,option,button,div),.contact-section,.contact-section:where(p,span,a,li,small,td,th,input,textarea,select,option,button,div),.printify-footer,.printify-footer:where(p,span,a,li,small,td,th,button,div) {
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-weight:600!important
}
#contact:where(h1,h2,h3,h4,h5,h6,label,strong,b,.card-title,.card-title *,.contact-head>span,.section-title,.section-subtitle,.contact-title,.contact-subtitle,.form-title,.contact-card-title,.quick-title,.branch-title,.kicker,.eyebrow),.contact-section:where(h1,h2,h3,h4,h5,h6,label,strong,b,.card-title,.card-title *,.contact-head>span,.section-title,.section-subtitle,.contact-title,.contact-subtitle,.form-title,.contact-card-title,.quick-title,.branch-title,.kicker,.eyebrow),.printify-footer:where(h1,h2,h3,h4,h5,h6,label,strong,b,.footer-col h3,.footer-col h4,.footer-title,.footer-heading) {
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-weight:600!important
}
#contact:where(button,.ui-btn,.btn,input[type="submit"],a.ui-btn),.contact-section:where(button,.ui-btn,.btn,input[type="submit"],a.ui-btn),.printify-footer:where(button,.ui-btn,.btn,input[type="submit"],a.ui-btn) {
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-weight:600!important
}
.printify-wordmark,.printify-logo,.printify-brand,.brand-main-text,.footer-brand h2,.footer-bottom .printify-wordmark,[aria-label*="Printify"],[title*="Printify"] {
  font-family:'BoxingFinal','Boxing',serif!important;
  font-weight:400!important;
  letter-spacing:.5px!important
}
.printify-footer .footer-brand h2,.printify-footer .footer-bottom span.printify-wordmark {
  font-family:'BoxingFinal','Boxing',serif!important;
  font-weight:400!important
}
.printify-footer .footer-brand h4,.printify-footer .footer-col h3 {
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-weight:600!important
}
.printify-footer .footer-brand p,.printify-footer .footer-brand p span,.printify-footer .footer-links a,.printify-footer .footer-contact-list p,.printify-footer .footer-contact-list p span,.printify-footer .footer-bottom p {
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-weight:600!important
}
#contact i,.contact-section i,.printify-footer i {
  font-family:"Font Awesome 6 Free","Font Awesome 6 Brands"!important
}
</style>
<style id="contact-request-final-adjustments">
#contact .form-card .card-title h3,.contact-section .form-card .card-title h3 {
  font-size:21.5px!important;
  line-height:1.05!important;
  margin-bottom:5px!important
}
#contact .form-card .card-title p,.contact-section .form-card .card-title p {
  font-size:10.5px!important;
  line-height:1.35!important;
  margin:0!important
}
#contact .form-card .input-wrapper i,.contact-section .form-card .input-wrapper i {
  left:13px!important;
  font-size:13px!important;
  width:14px!important;
  text-align:center!important
}
#contact .form-card .textarea-wrapper i,.contact-section .form-card .textarea-wrapper i {
  top:15px!important
}
#contact .form-card .input-wrapper input,#contact .form-card .input-wrapper select,#contact .form-card .input-wrapper textarea,.contact-section .form-card .input-wrapper input,.contact-section .form-card .input-wrapper select,.contact-section .form-card .input-wrapper textarea {
  font-size:11.5px!important;
  padding-left:38px!important
}
#contact .form-card .input-wrapper input,#contact .form-card .input-wrapper select,.contact-section .form-card .input-wrapper input,.contact-section .form-card .input-wrapper select {
  height:44px!important
}
#contact .form-card .input-wrapper textarea,.contact-section .form-card .input-wrapper textarea {
  height:136px!important;
  min-height:136px!important;
  line-height:1.45!important
}
#contact .branch-content,.contact-section .branch-content {
  margin-top:24px!important;
  gap:42px!important;
  grid-template-columns:minmax(0,1fr) 220px!important
}
#contact .branch-list,.contact-section .branch-list {
  gap:38px!important
}
#contact .branch-item+.branch-item,.contact-section .branch-item+.branch-item {
  padding-left:22px!important
}
#contact .branch-item b,.contact-section .branch-item b {
  margin-bottom:10px!important
}
#contact .branch-item span,#contact .branch-item small,.contact-section .branch-item span,.contact-section .branch-item small {
  margin-bottom:13px!important
}
#contact .branch-item p,.contact-section .branch-item p {
  margin-bottom:11px!important;
  line-height:1.45!important;
  gap:9px!important;
  align-items:flex-start!important
}
#contact .branch-item p i,.contact-section .branch-item p i {
  margin-top:2px!important;
  flex:0 0 auto!important
}
#contact .branch-notes,.contact-section .branch-notes {
  min-height:158px!important;
  gap:18px!important
}
#contact .branch-notes p,.contact-section .branch-notes p {
  margin-bottom:16px!important;
  line-height:1.55!important;
  gap:10px!important
}
@media(max-width:1320px) {
  #contact .branch-content,.contact-section .branch-content {
    gap:32px!important;
    grid-template-columns:minmax(0,1fr) 205px!important
  }
  #contact .branch-list,.contact-section .branch-list {
    gap:30px!important
  }
}
@media(max-width:1180px) {
  #contact .branch-content,.contact-section .branch-content {
    grid-template-columns:1fr!important
  }
  #contact .branch-item+.branch-item,.contact-section .branch-item+.branch-item {
    padding-left:0!important
  }
}
@media(max-width:760px) {
  #contact .branch-list,.contact-section .branch-list {
    gap:22px!important
  }
  #contact .branch-content,.contact-section .branch-content {
    gap:24px!important
  }
}
</style>
<style id="contact-updated-ui-match">
#contact.contact-section {
  padding:42px 70px 52px!important;
  min-height:calc(100vh - 86px)!important
}
#contact .contact-container {
  max-width:1440px!important;
  margin:0!important
}
#contact .contact-head {
  margin-bottom:24px!important
}
#contact .contact-head h2 {
  font-size:48px!important;
  line-height:.96!important
}
#contact .contact-grid {
  display:grid!important;
  grid-template-columns:500px minmax(0,1fr)!important;
  gap:58px!important;
  align-items:start!important
}
#contact .form-card {
  min-height:548px!important;
  padding:22px 20px 16px!important;
  border-radius:8px!important
}
#contact .form-card .card-title {
  margin-bottom:18px!important;
  gap:14px!important
}
#contact .form-card .card-title>i {
  width:44px!important;
  height:44px!important;
  font-size:30px!important;
  color:var(--orange)!important
}
#contact .form-card .card-title h3 {
  font-size:22px!important;
  line-height:1.05!important
}
#contact .form-card .card-title p {
  font-size:11px!important;
  line-height:1.35!important
}
#contact .form-fields {
  gap:14px!important
}
#contact .form-row>span {
  margin-bottom:8px!important;
  color:#111!important;
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-size:12px!important;
  font-weight:800!important;
  line-height:1.1!important
}
#contact .input-wrapper input {
  height:40px!important
}
#contact .input-wrapper textarea {
  height:78px!important;
  min-height:78px!important;
  resize:vertical!important
}
#contact .input-wrapper input,#contact .input-wrapper textarea {
  border-radius:7px!important;
  font-size:13px!important;
  padding-left:40px!important
}
#contact .upload-row {
  margin-top:1px!important
}
#contact .upload-drop {
  min-height:76px!important;
  border:1px dashed #9eb1c8!important;
  border-radius:8px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  gap:18px!important;
  cursor:pointer!important;
  color:#111827!important;
  background:#fff!important
}
#contact .upload-drop input {
  position:absolute!important;
  width:1px!important;
  height:1px!important;
  opacity:0!important;
  pointer-events:none!important
}
#contact .upload-drop>i {
  font-size:25px!important;
  color:#111827!important
}
#contact .upload-drop>span {
  display:flex!important;
  flex-direction:column!important;
  gap:2px!important;
  width:auto!important;
  height:auto!important
}
#contact .upload-drop b {
  color:#111827!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:12px!important;
  font-weight:800!important
}
#contact .upload-drop small {
  color:#5f6f86!important;
  font-size:11px!important;
  font-weight:600!important
}
#contact .form-bottom {
  margin-top:18px!important
}
#contact .form-bottom .ui-btn {
  width:152px!important;
  height:42px!important;
  border-radius:22px!important;
  color:#fff!important;
  font-size:12px!important;
  text-transform:none!important
}
#contact .form-bottom .ui-btn i {
  color:#fff!important
}
#contact .contact-details {
  min-height:548px!important;
  display:flex!important;
  flex-direction:column!important;
  gap:38px!important;
  padding-top:20px!important
}
#contact .contact-details .info-card {
  height:auto!important;
  min-height:314px!important;
  padding:0!important;
  display:grid!important;
  grid-template-columns:275px minmax(0,1fr)!important;
  gap:46px!important
}
#contact .touch-box {
  padding:0 34px 0 0!important;
  border-right:1px solid #cfd5df!important
}
#contact .touch-box h3,#contact .branch-card h3,#contact .quick-answer-card h3 {
  margin-bottom:28px!important;
  color:#151515!important;
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-size:20px!important;
  font-weight:800!important;
  text-transform:none!important;
  display:flex!important;
  align-items:center!important;
  gap:16px!important
}
#contact .touch-box h3 i,#contact .branch-card h3 i,#contact .quick-answer-card h3 i {
  width:34px!important;
  text-align:center!important;
  font-size:32px!important
}
#contact .touch-box p {
  margin:0 0 30px!important;
  padding-left:44px!important;
  font-size:14px!important;
  line-height:1.5!important
}
#contact .touch-box p>i {
  width:28px!important;
  font-size:22px!important;
  top:2px!important
}
#contact .touch-box p b {
  margin-bottom:5px!important;
  font-size:16px!important;
  display:flex!important;
  align-items:center!important;
  gap:8px!important
}
#contact .touch-box p b em {
  width:9px!important;
  height:9px!important;
  border-radius:50%!important;
  background:#16c76a!important;
  display:inline-block!important
}
#contact .branch-card {
  min-height:0!important;
  padding:0!important;
  border:0!important
}
#contact .branch-content {
  margin-top:0!important;
  display:block!important
}
#contact .branch-list {
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:34px!important
}
#contact .branch-item+.branch-item {
  border-left:1px solid #d6dce5!important;
  padding-left:30px!important
}
#contact .branch-item small {
  margin-bottom:16px!important;
  color:#006eff!important;
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:14px!important;
  font-weight:600!important
}
#contact .branch-item b {
  margin-bottom:18px!important;
  color:#111!important;
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-size:16px!important;
  font-weight:800!important
}
#contact .branch-item>span {
  margin-bottom:26px!important;
  color:#111827!important;
  font-size:14px!important
}
#contact .branch-item p {
  margin:0 0 18px!important;
  color:#111827!important;
  font-size:13px!important;
  gap:9px!important;
  align-items:center!important
}
#contact .branch-item p span {
  margin-left:8px!important;
  color:#111827!important;
  font-size:13px!important
}
#contact .branch-item p i {
  color:var(--orange)!important;
  font-size:14px!important
}
#contact .quick-row {
  display:grid!important;
  grid-template-columns:360px minmax(0,1fr)!important;
  gap:34px!important;
  align-items:center!important
}
#contact .quick-answer-card {
  height:auto!important;
  min-height:190px!important;
  padding:0!important
}
#contact .quick-answer-card h3 {
  margin-bottom:20px!important
}
#contact .quick-answer-card button {
  height:48px!important;
  grid-template-columns:34px 1fr 14px!important;
  padding:0 10px 0 0!important
}
#contact .quick-answer-card button span {
  width:30px!important;
  height:30px!important
}
#contact .quick-answer-card button b {
  color:#111827!important;
  font-size:14px!important;
  font-weight:600!important
}
#contact .branch-notes {
  min-height:128px!important;
  padding-left:42px!important;
  border-left:1px solid #9fa7b3!important;
  justify-content:center!important
}
#contact .branch-notes p {
  margin:0 0 30px!important;
  color:#111827!important;
  font-size:14px!important;
  line-height:1.45!important;
  gap:28px!important;
  align-items:center!important
}
#contact .branch-notes p:last-child {
  margin-bottom:0!important
}
#contact .branch-notes p i {
  width:30px!important;
  color:var(--orange)!important;
  font-size:26px!important
}
#contact .map-card,#contact .hours-box,#contact .contact-extra,#contact .middle-side {
  display:none!important
}
.printify-footer {
  display:none!important
}
#contact .icon-navy {
  color:#111827!important
}
#contact .icon-blue {
  color:#1473f9!important
}
#contact .icon-purple {
  color:#8b3dff!important
}
@media(max-width:1180px) {
  #contact.contact-section {
    padding:34px 24px 44px!important
  }
  #contact .contact-grid,#contact .contact-details .info-card,#contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .touch-box {
    border-right:0!important;
    padding-right:0!important
  }
  #contact .branch-notes {
    border-left:0!important;
    padding-left:0!important
  }
}
@media(max-width:760px) {
  #contact .contact-head h2 {
    font-size:40px!important
  }
  #contact .branch-list {
    grid-template-columns:1fr!important
  }
  #contact .branch-item+.branch-item {
    border-left:0!important;
    padding-left:0!important
  }
}
</style>
<style id="contact-user-request-final-file-patch">
#contact .contact-head>span,.contact-section .contact-head>span,#contact .touch-box>h3,.contact-section .touch-box>h3,#contact .hours-box>h3,.contact-section .hours-box>h3,#contact .branch-card>h3,.contact-section .branch-card>h3,#contact .quick-answer-card>h3,.contact-section .quick-answer-card>h3,#contact .map-head>h3,.contact-section .map-head>h3 {
  text-transform:uppercase!important
}
#contact .branch-item>b,.contact-section .branch-item>b,#contact .quick-answer-card button>b,.contact-section .quick-answer-card button>b {
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-weight:600!important;
  letter-spacing:.18px!important
}
#contact .form-bottom .ui-btn i.fa-paper-plane,.contact-section .form-bottom .ui-btn i.fa-paper-plane,#contact button[type="submit"] i.fa-paper-plane,.contact-section button[type="submit"] i.fa-paper-plane {
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  opacity:1!important;
  visibility:visible!important;
  color:#111827!important;
  font-family:"Font Awesome 6 Free"!important;
  font-weight:900!important
}
#contact .form-bottom .ui-btn:hover i.fa-paper-plane,#contact .form-bottom .ui-btn:focus i.fa-paper-plane,.contact-section .form-bottom .ui-btn:hover i.fa-paper-plane,.contact-section .form-bottom .ui-btn:focus i.fa-paper-plane,#contact button[type="submit"]:hover i.fa-paper-plane,#contact button[type="submit"]:focus i.fa-paper-plane,.contact-section button[type="submit"]:hover i.fa-paper-plane,.contact-section button[type="submit"]:focus i.fa-paper-plane {
  color:#ffffff!important;
  opacity:1!important;
  visibility:visible!important
}
</style>
<style id="contact-latest-user-request-fix">
#contact .contact-head>span,.contact-section .contact-head>span,#contact .touch-box>h3,.contact-section .touch-box>h3,#contact .hours-box>h3,.contact-section .hours-box>h3,#contact .quick-answer-card>h3,.contact-section .quick-answer-card>h3,#contact .branch-card>h3,.contact-section .branch-card>h3,#contact .map-head>h3,.contact-section .map-head>h3 {
  text-transform:uppercase!important;
  font-family:'LeagueSpartanFinal','League Spartan',Arial,sans-serif!important;
  font-weight:800!important
}
#contact .branch-item>b,.contact-section .branch-item>b,#contact .quick-answer-card button>b,.contact-section .quick-answer-card button>b {
  font-family:'InterFinal','Inter Local',Arial,sans-serif!important;
  font-size:14px!important;
  font-weight:600!important;
  line-height:1.5!important;
  letter-spacing:.18px!important
}
#contact .form-bottom .ui-btn .fa-paper-plane,.contact-section .form-bottom .ui-btn .fa-paper-plane {
  display:inline-flex!important;
  visibility:visible!important;
  opacity:1!important;
  color:#111827!important
}
#contact .form-bottom .ui-btn:hover .fa-paper-plane,#contact .form-bottom .ui-btn:focus .fa-paper-plane,.contact-section .form-bottom .ui-btn:hover .fa-paper-plane,.contact-section .form-bottom .ui-btn:focus .fa-paper-plane {
  color:#ffffff!important
}
</style>
<style id="contact-updated-ui-last-cascade">
#contact .touch-box>h3,#contact .branch-card>h3,#contact .quick-answer-card>h3 {
  text-transform:none!important
}
#contact .form-bottom .ui-btn .fa-paper-plane {
  color:#ffffff!important
}
</style>
<style id="contact-image-reference-layout-final">
#contact.contact-section {
  padding:42px 62px 70px!important;
  background:#fff!important
}
#contact .contact-container {
  max-width:1515px!important;
  margin:0 auto!important
}
#contact .contact-head {
  margin-bottom:34px!important
}
#contact .contact-head>span {
  display:block!important;
  margin-bottom:12px!important;
  color:#ff7900!important;
  text-transform:uppercase!important
}
#contact .contact-head h2 {
  margin:0 0 24px!important;
  line-height:.95!important;
  text-transform:uppercase!important
}
#contact .contact-head h2 b {
  color:#ff7900!important
}
#contact .contact-head p {
  margin:0!important;
  color:#111827!important
}
#contact .contact-grid {
  display:grid!important;
  grid-template-columns:420px minmax(0,1fr)!important;
  gap:68px!important;
  align-items:start!important
}
#contact .form-card {
  min-height:548px!important;
  padding:24px 24px 20px!important;
  border:1px solid #9ca3af!important;
  border-radius:7px!important;
  box-shadow:none!important
}
#contact .form-card .card-title {
  margin-bottom:18px!important;
  gap:18px!important
}
#contact .form-card .card-title>i {
  width:46px!important;
  height:46px!important;
  color:#ff7900!important
}
#contact .form-fields {
  gap:14px!important
}
#contact .form-row>span {
  margin-bottom:7px!important;
  color:#111827!important
}
#contact .input-wrapper input {
  height:39px!important
}
#contact .input-wrapper textarea {
  height:82px!important;
  min-height:82px!important
}
#contact .input-wrapper input,#contact .input-wrapper textarea {
  border:1px solid #cfd7e3!important;
  border-radius:6px!important;
  background:#fff!important
}
#contact .upload-drop {
  min-height:64px!important;
  border:1px dashed #b8c4d4!important;
  border-radius:6px!important;
  gap:16px!important
}
#contact .upload-drop>i {
  color:#111827!important
}
#contact .form-bottom {
  margin-top:20px!important;
  align-items:center!important
}
#contact .form-bottom .ui-btn {
  width:132px!important;
  height:38px!important;
  border-radius:22px!important;
  color:#fff!important;
  background:#ff7900!important
}
#contact .contact-details {
  min-height:548px!important;
  padding-top:18px!important;
  display:flex!important;
  flex-direction:column!important;
  gap:52px!important
}
#contact .contact-details .info-card {
  display:grid!important;
  grid-template-columns:275px minmax(0,1fr)!important;
  gap:46px!important;
  height:auto!important;
  min-height:292px!important;
  padding:0!important;
  background:transparent!important;
  box-shadow:none!important
}
#contact .touch-box {
  padding:0 34px 0 0!important;
  border-right:1px solid #d7dde7!important
}
#contact .touch-box>h3,#contact .branch-card>h3,#contact .quick-answer-card>h3 {
  margin:0 0 38px!important;
  color:#111827!important;
  display:flex!important;
  align-items:center!important;
  gap:20px!important;
  text-transform:none!important
}
#contact .touch-box>h3 i,#contact .branch-card>h3 i,#contact .quick-answer-card>h3 i {
  width:30px!important;
  text-align:center!important
}
#contact .touch-box p {
  margin:0 0 32px!important;
  padding-left:46px!important;
  line-height:1.55!important
}
#contact .touch-box p:last-child {
  margin-bottom:0!important
}
#contact .touch-box p>i {
  left:0!important;
  top:1px!important;
  width:28px!important;
  text-align:center!important
}
#contact .touch-box p b {
  margin-bottom:5px!important;
  display:flex!important;
  align-items:center!important;
  gap:8px!important;
  color:#111827!important
}
#contact .touch-box p b em {
  width:9px!important;
  height:9px!important;
  display:inline-block!important;
  border-radius:50%!important;
  background:#22c55e!important
}
#contact .branch-card {
  padding:0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important
}
#contact .branch-content {
  display:block!important;
  margin:0!important
}
#contact .branch-list {
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:44px!important
}
#contact .branch-item {
  padding:0!important
}
#contact .branch-item+.branch-item {
  padding-left:42px!important;
  border-left:1px solid #b8c2d1!important
}
#contact .branch-item small {
  display:block!important;
  margin:0 0 28px!important;
  color:#006eff!important
}
#contact .branch-item b {
  display:inline!important;
  color:#111827!important
}
#contact .branch-item>span {
  display:inline!important;
  margin:0!important;
  color:#111827!important
}
#contact .branch-item p {
  margin:36px 0 0!important;
  display:flex!important;
  align-items:center!important;
  gap:20px!important;
  color:#111827!important
}
#contact .branch-item p+p {
  margin-top:26px!important
}
#contact .branch-item p span {
  margin-left:4px!important
}
#contact .branch-item p i {
  color:#ff7900!important
}
#contact .quick-row {
  display:grid!important;
  grid-template-columns:360px minmax(0,1fr)!important;
  gap:58px!important;
  align-items:center!important
}
#contact .quick-answer-card {
  min-height:184px!important;
  height:auto!important;
  padding:0!important;
  background:transparent!important;
  box-shadow:none!important
}
#contact .quick-answer-card>h3 {
  margin-bottom:22px!important
}
#contact .quick-answer-card button {
  height:43px!important;
  padding:0!important;
  display:grid!important;
  grid-template-columns:34px 1fr 14px!important;
  gap:12px!important;
  align-items:center!important;
  border:0!important;
  border-bottom:1px solid #e5e9f0!important;
  border-radius:0!important;
  background:transparent!important
}
#contact .quick-answer-card button span {
  width:30px!important;
  height:30px!important;
  display:grid!important;
  place-items:center!important
}
#contact .branch-notes {
  min-height:110px!important;
  padding-left:48px!important;
  border-left:1px solid #b8c2d1!important;
  display:flex!important;
  flex-direction:column!important;
  justify-content:center!important;
  gap:28px!important
}
#contact .branch-notes p {
  margin:0!important;
  display:flex!important;
  align-items:center!important;
  gap:26px!important;
  color:#111827!important;
  line-height:1.45!important
}
#contact .branch-notes p i {
  width:30px!important;
  color:#ff7900!important;
  text-align:center!important
}
#contact .icon-orange {
  color:#ff7900!important
}
#contact .icon-green {
  color:#16a34a!important
}
#contact .icon-blue {
  color:#006eff!important
}
#contact .icon-purple {
  color:#8b3dff!important
}
#contact .icon-red {
  color:#ef233c!important
}
#contact .icon-navy,#contact .icon-black {
  color:#111827!important
}
@media(max-width:1280px) {
  #contact.contact-section {
    padding:36px 34px 58px!important
  }
  #contact .contact-grid {
    grid-template-columns:420px minmax(0,1fr)!important;
    gap:42px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:260px minmax(0,1fr)!important;
    gap:34px!important
  }
  #contact .branch-list {
    gap:28px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:28px!important
  }
  #contact .quick-row {
    gap:36px!important
  }
}
@media(max-width:1080px) {
  #contact .contact-grid,#contact .contact-details .info-card,#contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .touch-box,#contact .branch-notes {
    border-right:0!important;
    border-left:0!important;
    padding-left:0!important;
    padding-right:0!important
  }
}
@media(max-width:760px) {
  #contact.contact-section {
    padding:28px 18px 46px!important
  }
  #contact .contact-head h2 {
    font-size:40px!important
  }
  #contact .form-card {
    padding:20px 16px!important
  }
  #contact .branch-list {
    grid-template-columns:1fr!important
  }
  #contact .branch-item+.branch-item {
    padding-left:0!important;
    border-left:0!important
  }
}
</style>
<style id="contact-services-heading-font-match">
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
#contact .contact-head>span {
  font-family:'Clash Display','League Spartan',sans-serif!important;
  font-weight:600!important;
  letter-spacing:0!important;
  text-transform:uppercase!important
}
#contact .contact-head h2,#contact .contact-head h2 b {
  font-family:'Clash Display','League Spartan',sans-serif!important;
  font-weight:600!important;
  letter-spacing:0!important
}
</style>
<style id="contact-tight-spacing-alignment-final">
#contact.contact-section {
  padding:34px 62px 54px!important
}
#contact .contact-head {
  margin-bottom:26px!important
}
#contact .contact-head h2 {
  margin-bottom:16px!important
}
#contact .contact-grid {
  grid-template-columns:382px minmax(0,1fr)!important;
  gap:46px!important
}
#contact .form-card {
  width:382px!important;
  min-height:0!important;
  padding:21px 20px 17px!important
}
#contact .form-card .card-title {
  margin-bottom:16px!important;
  gap:14px!important
}
#contact .form-card .card-title>i {
  width:42px!important;
  height:42px!important
}
#contact .form-fields {
  gap:11px!important
}
#contact .form-row>span {
  margin-bottom:6px!important
}
#contact .input-wrapper input {
  height:34px!important
}
#contact .input-wrapper textarea {
  height:64px!important;
  min-height:64px!important
}
#contact .input-wrapper input,#contact .input-wrapper textarea {
  padding-top:8px!important;
  padding-bottom:8px!important
}
#contact .upload-drop {
  min-height:54px!important;
  padding:8px 12px!important
}
#contact .form-bottom {
  margin-top:16px!important
}
#contact .form-bottom .ui-btn {
  width:126px!important;
  height:34px!important
}
#contact .contact-details {
  padding-top:20px!important;
  gap:34px!important;
  min-height:0!important
}
#contact .contact-details .info-card {
  grid-template-columns:250px minmax(0,1fr)!important;
  gap:34px!important;
  min-height:248px!important
}
#contact .touch-box {
  padding-right:28px!important
}
#contact .touch-box>h3,#contact .branch-card>h3 {
  margin-bottom:30px!important
}
#contact .touch-box p {
  margin-bottom:24px!important;
  padding-left:42px!important
}
#contact .branch-list {
  gap:34px!important
}
#contact .branch-item+.branch-item {
  padding-left:34px!important
}
#contact .branch-item small {
  margin-bottom:26px!important
}
#contact .branch-item p {
  display:grid!important;
  grid-template-columns:22px 112px 132px!important;
  column-gap:12px!important;
  align-items:center!important;
  margin-top:30px!important;
  width:100%!important
}
#contact .branch-item p+p {
  grid-template-columns:22px minmax(0,1fr)!important;
  margin-top:23px!important
}
#contact .branch-item p i {
  grid-column:1!important;
  justify-self:start!important
}
#contact .branch-item p span {
  grid-column:3!important;
  margin-left:0!important;
  justify-self:start!important;
  white-space:nowrap!important
}
#contact .quick-row {
  grid-template-columns:330px minmax(0,1fr)!important;
  gap:42px!important
}
#contact .quick-answer-card {
  min-height:0!important
}
#contact .quick-answer-card>h3 {
  margin-bottom:18px!important
}
#contact .quick-answer-card button {
  height:38px!important
}
#contact .branch-notes {
  min-height:94px!important;
  padding-left:40px!important;
  gap:22px!important
}
#contact .branch-notes p {
  gap:22px!important
}
@media(max-width:1280px) {
  #contact.contact-section {
    padding-left:34px!important;
    padding-right:34px!important
  }
  #contact .contact-grid {
    grid-template-columns:370px minmax(0,1fr)!important;
    gap:34px!important
  }
  #contact .form-card {
    width:370px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:240px minmax(0,1fr)!important;
    gap:28px!important
  }
  #contact .branch-item p {
    grid-template-columns:22px 104px 124px!important
  }
}
@media(max-width:1080px) {
  #contact .contact-grid,#contact .contact-details .info-card,#contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .form-card {
    width:100%!important
  }
}
</style>
<style id="contact-redline-tight-alignment-final">
#contact.contact-section {
  padding-top:28px!important;
  padding-bottom:44px!important
}
#contact .contact-head {
  margin-bottom:20px!important
}
#contact .contact-grid {
  grid-template-columns:360px minmax(0,1fr)!important;
  gap:34px!important
}
#contact .form-card {
  width:360px!important;
  padding:18px 18px 15px!important
}
#contact .form-card .card-title {
  margin-bottom:13px!important;
  gap:12px!important
}
#contact .form-card .card-title>i {
  width:38px!important;
  height:38px!important
}
#contact .form-fields {
  gap:9px!important
}
#contact .form-row>span {
  margin-bottom:5px!important
}
#contact .input-wrapper input {
  height:31px!important
}
#contact .input-wrapper textarea {
  height:56px!important;
  min-height:56px!important
}
#contact .upload-drop {
  min-height:48px!important;
  padding:6px 10px!important;
  gap:12px!important
}
#contact .form-bottom {
  margin-top:13px!important
}
#contact .form-bottom .ui-btn {
  width:118px!important;
  height:32px!important
}
#contact .contact-details {
  padding-top:12px!important;
  gap:26px!important
}
#contact .contact-details .info-card {
  grid-template-columns:232px minmax(0,1fr)!important;
  gap:28px!important;
  min-height:222px!important
}
#contact .touch-box {
  padding-right:24px!important
}
#contact .touch-box>h3,#contact .branch-card>h3 {
  margin-bottom:22px!important
}
#contact .touch-box p {
  margin-bottom:18px!important;
  padding-left:38px!important
}
#contact .branch-list {
  gap:28px!important
}
#contact .branch-item+.branch-item {
  padding-left:28px!important
}
#contact .branch-item small {
  margin-bottom:20px!important
}
#contact .branch-item b,#contact .branch-item>span {
  white-space:nowrap!important
}
#contact .branch-item p {
  display:grid!important;
  grid-template-columns:20px max-content max-content!important;
  column-gap:10px!important;
  align-items:center!important;
  margin-top:22px!important;
  white-space:nowrap!important
}
#contact .branch-item p+p {
  grid-template-columns:20px max-content!important;
  margin-top:18px!important
}
#contact .branch-item p span {
  grid-column:3!important;
  margin-left:8px!important;
  white-space:nowrap!important
}
#contact .quick-row {
  grid-template-columns:310px minmax(0,1fr)!important;
  gap:34px!important
}
#contact .quick-answer-card>h3 {
  margin-bottom:14px!important
}
#contact .quick-answer-card button {
  height:34px!important
}
#contact .branch-notes {
  min-height:82px!important;
  padding-left:32px!important;
  gap:18px!important
}
#contact .branch-notes p {
  gap:18px!important
}
@media(max-width:1280px) {
  #contact .contact-grid {
    grid-template-columns:350px minmax(0,1fr)!important;
    gap:28px!important
  }
  #contact .form-card {
    width:350px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:220px minmax(0,1fr)!important;
    gap:24px!important
  }
  #contact .branch-list {
    gap:22px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:22px!important
  }
  #contact .branch-item p {
    column-gap:8px!important
  }
}
</style>
<style id="contact-section-spacing-compact-final">
#contact.contact-section {
  padding:30px 56px 48px!important
}
#contact .contact-container {
  max-width:1450px!important;
  margin:0 auto!important
}
#contact .contact-head {
  margin-bottom:18px!important
}
@media(max-width:1320px) {
  #contact.contact-section {
    padding-left:44px!important;
    padding-right:44px!important
  }
}
@media(max-width:1180px) {
  #contact.contact-section {
    padding:28px 22px 44px!important
  }
}
@media(max-width:760px) {
  #contact.contact-section {
    padding:24px 14px 38px!important
  }
}
</style>
<style id="contact-0615-compact-time-form-fontsafe-final">
#contact.contact-section {
  display:block!important;
  visibility:visible!important;
  opacity:1!important;
  position:relative!important;
  z-index:1!important;
  clear:both!important
}
#contact .contact-container,#contact .contact-head {
  display:block!important;
  visibility:visible!important;
  opacity:1!important
}
#contact .contact-grid {
  display:grid!important;
  visibility:visible!important;
  opacity:1!important
}
#contact .contact-details {
  display:flex!important;
  visibility:visible!important;
  opacity:1!important
}
#contact.contact-section {
  padding-left:50px!important;
  padding-right:0px!important
}
#contact .contact-grid {
  grid-template-columns:350px minmax(0,1fr)!important;
  gap:30px!important
}
#contact .form-card {
  width:380px!important;
  padding:16px 18px 14px!important
}
#contact .form-card .card-title {
  margin-bottom:12px!important
}
#contact .form-card .card-title>i {
  width:34px!important;
  height:34px!important;
  font-size:22px!important
}
#contact .form-fields {
  gap:8px!important
}
#contact .form-row>span {
  margin-bottom:4px!important
}
#contact .input-wrapper input {
  height:30px!important
}
#contact .input-wrapper textarea {
  height:32px!important;
  min-height:32px!important;
  resize:none!important
}
#contact .upload-drop {
  min-height:44px!important;
  padding:5px 10px!important
}
#contact .upload-drop>i {
  font-size:20px!important
}
#contact .form-bottom {
  margin-top:11px!important
}
#contact .form-bottom small {
  max-width:150px!important;
  line-height:1.25!important
}
#contact .form-bottom .ui-btn {
  width:116px!important;
  height:31px!important
}
#contact .contact-details {
  padding-top:10px!important;
  gap:24px!important
}
#contact .contact-details .info-card {
  grid-template-columns:300px minmax(0,1fr)!important;
  gap:24px!important;
  min-height:210px!important
}
#contact .touch-box {
  padding-right:22px!important
}
#contact .touch-box>h3,#contact .branch-card>h3,#contact .quick-answer-card>h3 {
  margin-bottom:18px!important;
  gap:14px!important
}
#contact .touch-box>h3 i,#contact .branch-card>h3 i,#contact .quick-answer-card>h3 i {
  width:24px!important;
  font-size:24px!important
}
#contact .touch-box p {
  margin-bottom:16px!important;
  padding-left:34px!important
}
#contact .touch-box p>i {
  width:22px!important;
  font-size:18px!important
}
#contact .branch-list {
  gap:20px!important
}
#contact .branch-item+.branch-item {
  padding-left:22px!important
}
#contact .branch-item small {
  margin-bottom:16px!important
}
#contact .branch-item b,#contact .branch-item>span {
  display:block!important
}
#contact .branch-item b {
  margin-bottom:8px!important
}
#contact .branch-item>span {
  margin-bottom:18px!important
}
#contact .branch-item p {
  display:flex!important;
  align-items:center!important;
  gap:8px!important;
  margin:0 0 14px!important;
  width:100%!important;
  white-space:nowrap!important;
  line-height:1.2!important
}
#contact .branch-item p i {
  width:16px!important;
  min-width:16px!important;
  font-size:13px!important;
  margin:0!important;
  text-align:center!important
}
#contact .branch-item p span {
  display:inline!important;
  margin-left:8px!important;
  white-space:nowrap!important;
  line-height:1.2!important
}
#contact .quick-row {
  grid-template-columns:300px minmax(0,1fr)!important;
  gap:28px!important
}
#contact .quick-answer-card>h3 {
  margin-bottom:12px!important
}
#contact .quick-answer-card button {
  height:32px!important
}
#contact .quick-answer-card button span {
  width:26px!important;
  height:26px!important
}
#contact .quick-answer-card button span i,#contact .quick-answer-card button>i {
  font-size:14px!important
}
#contact .branch-notes {
  min-height:74px!important;
  padding-left:28px!important;
  gap:16px!important
}
#contact .branch-notes p {
  gap:14px!important;
  line-height:1.35!important
}
#contact .branch-notes p i {
  width:22px!important;
  font-size:22px!important
}
@media(max-width:1280px) {
  #contact.contact-section {
    padding-left:32px!important;
    padding-right:32px!important
  }
  #contact .contact-grid {
    grid-template-columns:340px minmax(0,1fr)!important;
    gap:24px!important
  }
  #contact .form-card {
    width:340px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:212px minmax(0,1fr)!important;
    gap:22px!important
  }
  #contact .branch-list {
    gap:16px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:18px!important
  }
}
@media(max-width:1080px) {
  #contact .contact-grid,#contact .contact-details .info-card,#contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .form-card {
    width:100%!important
  }
  #contact .touch-box,#contact .branch-notes {
    border-left:0!important;
    border-right:0!important;
    padding-left:0!important;
    padding-right:0!important
  }
}
</style>
<style id="contact-about-left-spacing-match-0615">
#contact.contact-section {
  margin-left:80px!important
}
@media(max-width:1080px) {
  #contact.contact-section {
    margin-left:0!important
  }
}
</style>
<style id="contact-about-alignment-and-function-final-lock-0615">
#contact.contact-section {
  margin-left:0!important;
  padding:50px 80px!important;
  scroll-margin-top:88px!important
}
#contact .contact-container {
  width:100%!important;
  max-width:1580px!important;
  margin:0!important
}
#contact .contact-head {
  margin:0 0 28px!important
}
#contact .contact-grid {
  display:grid!important;
  grid-template-columns:430px minmax(0,1fr)!important;
  gap:58px!important;
  align-items:start!important
}
#contact .form-card {
  width:430px!important;
  padding:20px 24px 18px!important
}
#contact .card-title {
  margin-bottom:16px!important;
  gap:14px!important
}
#contact .form-fields {
  gap:12px!important
}
#contact .form-row>span {
  display:block!important;
  margin:0 0 6px!important
}
#contact .input-wrapper input {
  height:38px!important;
  min-height:38px!important
}
#contact .input-wrapper textarea {
  height:94px!important;
  min-height:94px!important
}
#contact .upload-drop {
  min-height:62px!important;
  padding:10px 12px!important
}
#contact .form-bottom {
  margin-top:16px!important;
  align-items:center!important
}
#contact .contact-details {
  min-width:0!important
}
#contact .contact-details .info-card {
  display:grid!important;
  grid-template-columns:280px minmax(0,1fr)!important;
  gap:46px!important;
  align-items:start!important
}
#contact .touch-box {
  padding-right:34px!important;
  border-right:1px solid #e7ebf1!important
}
#contact .touch-box h3,
#contact .branch-card h3,
#contact .quick-answer-card h3 {
  display:flex!important;
  align-items:center!important;
  gap:14px!important;
  margin:0 0 28px!important
}
#contact .touch-box h3 i,
#contact .branch-card h3 i,
#contact .quick-answer-card h3 i {
  width:28px!important;
  min-width:28px!important;
  font-size:28px!important;
  line-height:1!important
}
#contact .touch-box p {
  display:grid!important;
  grid-template-columns:28px minmax(0,1fr)!important;
  column-gap:18px!important;
  row-gap:5px!important;
  margin:0 0 28px!important;
  line-height:1.35!important
}
#contact .touch-box p>i {
  grid-row:1 / span 3!important;
  width:28px!important;
  min-width:28px!important;
  font-size:22px!important;
  line-height:1.1!important;
  text-align:center!important
}
#contact .touch-box p b,
#contact .touch-box p span,
#contact .touch-box p small {
  display:block!important;
  margin:0!important
}
#contact .branch-content {
  margin-top:0!important
}
#contact .branch-list {
  display:grid!important;
  grid-template-columns:minmax(0,1fr) minmax(0,1fr)!important;
  gap:46px!important
}
#contact .branch-item {
  min-width:0!important;
  padding:0!important
}
#contact .branch-item+.branch-item {
  padding-left:46px!important;
  border-left:1px solid #d9dee7!important
}
#contact .branch-item small,
#contact .branch-item b,
#contact .branch-item>span {
  display:block!important
}
#contact .branch-item small {
  margin:0 0 26px!important;
  color:#0066ff!important
}
#contact .branch-item b {
  margin:0 0 8px!important
}
#contact .branch-item>span {
  margin:0 0 30px!important
}
#contact .branch-item p {
  display:grid!important;
  grid-template-columns:24px auto minmax(120px,1fr)!important;
  align-items:center!important;
  column-gap:16px!important;
  margin:0 0 24px!important;
  line-height:1.25!important;
  white-space:nowrap!important
}
#contact .branch-item p i {
  width:24px!important;
  text-align:center!important;
  font-size:16px!important
}
#contact .branch-item p span {
  margin:0!important;
  justify-self:start!important
}
#contact .quick-row {
  display:grid!important;
  grid-template-columns:360px minmax(0,1fr)!important;
  gap:54px!important;
  align-items:start!important;
  margin-top:44px!important
}
#contact .quick-answer-card button {
  height:40px!important;
  padding:0 2px!important;
  grid-template-columns:30px minmax(0,1fr) 18px!important
}
#contact .branch-notes {
  min-height:96px!important;
  padding-left:44px!important;
  border-left:1px solid #d9dee7!important;
  display:flex!important;
  flex-direction:column!important;
  justify-content:center!important;
  gap:26px!important
}
#contact .branch-notes p {
  display:grid!important;
  grid-template-columns:28px minmax(0,1fr)!important;
  gap:24px!important;
  align-items:center!important;
  margin:0!important;
  line-height:1.35!important
}
#contact .branch-notes p i {
  width:28px!important;
  font-size:26px!important;
  text-align:center!important
}
@media(max-width:1320px) {
  #contact.contact-section {
    padding-left:50px!important;
    padding-right:50px!important
  }
  #contact .contact-grid {
    grid-template-columns:400px minmax(0,1fr)!important;
    gap:36px!important
  }
  #contact .form-card {
    width:400px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:250px minmax(0,1fr)!important;
    gap:32px!important
  }
  #contact .branch-list {
    gap:28px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:28px!important
  }
}
@media(max-width:1080px) {
  #contact.contact-section {
    padding:32px 22px 48px!important
  }
  #contact .contact-grid,
  #contact .contact-details .info-card,
  #contact .branch-list,
  #contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .form-card {
    width:100%!important
  }
  #contact .touch-box,
  #contact .branch-item+.branch-item,
  #contact .branch-notes {
    border-left:0!important;
    border-right:0!important;
    padding-left:0!important;
    padding-right:0!important
  }
  #contact .branch-item p {
    grid-template-columns:24px auto 1fr!important
  }
}
</style>
<style id="contact-reference-layout-hard-lock-0615">
#contact.contact-section {
  margin-left:0!important;
  padding:50px 80px 54px!important;
  background:#fff!important;
  overflow:visible!important
}
#contact .contact-container {
  width:100%!important;
  max-width:1580px!important;
  margin:0!important
}
#contact .contact-head {
  margin:0 0 30px!important
}
#contact .contact-head h2 {
  margin:0 0 18px!important
}
#contact .contact-grid {
  display:grid!important;
  grid-template-columns:430px minmax(0,1fr)!important;
  column-gap:68px!important;
  row-gap:34px!important;
  align-items:start!important
}
#contact .form-card {
  width:430px!important;
  max-width:430px!important;
  padding:20px 24px 18px!important;
  border:1px solid #c9d1dc!important;
  border-radius:7px!important;
  background:#fff!important;
  box-shadow:none!important
}
#contact .form-card .card-title {
  display:grid!important;
  grid-template-columns:42px minmax(0,1fr)!important;
  gap:14px!important;
  align-items:center!important;
  margin:0 0 16px!important
}
#contact .form-card .card-title>i {
  font-size:32px!important;
  width:42px!important;
  min-width:42px!important;
  line-height:1!important;
  text-align:center!important
}
#contact .form-fields {
  display:flex!important;
  flex-direction:column!important;
  gap:12px!important
}
#contact .form-row>span {
  display:block!important;
  margin:0 0 6px!important;
  line-height:1.1!important
}
#contact .input-wrapper {
  position:relative!important
}
#contact .input-wrapper i {
  position:absolute!important;
  left:14px!important;
  top:50%!important;
  transform:translateY(-50%)!important;
  width:16px!important;
  font-size:14px!important;
  text-align:center!important
}
#contact .textarea-wrapper i {
  top:15px!important;
  transform:none!important
}
#contact .input-wrapper input {
  height:38px!important;
  min-height:38px!important;
  padding-left:38px!important
}
#contact .input-wrapper textarea {
  height:94px!important;
  min-height:94px!important;
  padding-left:38px!important;
  padding-top:12px!important
}
#contact .upload-drop {
  min-height:62px!important;
  padding:10px 14px!important;
  gap:12px!important
}
#contact .form-bottom {
  margin-top:16px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  gap:14px!important
}
#contact .contact-details {
  display:grid!important;
  grid-template-rows:auto auto!important;
  gap:42px!important;
  min-width:0!important;
  padding-top:18px!important
}
#contact .contact-details .info-card {
  display:grid!important;
  grid-template-columns:300px minmax(0,1fr)!important;
  gap:50px!important;
  align-items:start!important;
  width:100%!important
}
#contact .touch-box {
  min-width:0!important;
  padding-right:36px!important;
  border-right:1px solid #e2e7ef!important
}
#contact .touch-box>h3,
#contact .branch-card>h3,
#contact .quick-answer-card>h3 {
  display:flex!important;
  align-items:center!important;
  gap:14px!important;
  margin:0 0 30px!important;
  line-height:1.15!important
}
#contact .touch-box>h3 i,
#contact .branch-card>h3 i,
#contact .quick-answer-card>h3 i {
  width:30px!important;
  min-width:30px!important;
  font-size:30px!important;
  line-height:1!important;
  text-align:center!important
}
#contact .contact-info-item {
  display:grid!important;
  grid-template-columns:30px minmax(0,1fr)!important;
  gap:18px!important;
  align-items:start!important;
  margin:0 0 28px!important
}
#contact .contact-info-item>i {
  width:30px!important;
  min-width:30px!important;
  font-size:22px!important;
  line-height:1.15!important;
  text-align:center!important
}
#contact .contact-info-copy {
  min-width:0!important;
  display:flex!important;
  flex-direction:column!important;
  gap:5px!important;
  line-height:1.25!important
}
#contact .contact-info-copy b,
#contact .contact-info-copy span,
#contact .contact-info-copy small {
  display:block!important;
  margin:0!important;
  white-space:nowrap!important
}
#contact .contact-info-copy b {
  font-weight:700!important
}
#contact .contact-info-copy b em {
  display:inline-block!important;
  width:9px!important;
  height:9px!important;
  margin-left:5px!important;
  border-radius:50%!important;
  background:#22c55e!important;
  vertical-align:middle!important
}
#contact .branch-card {
  min-width:0!important;
  padding:0!important
}
#contact .branch-content {
  margin:0!important
}
#contact .branch-list {
  display:grid!important;
  grid-template-columns:minmax(0,1fr) minmax(0,1fr)!important;
  gap:30px!important;
  align-items:start!important
}
#contact .branch-item {
  min-width:0!important;
  padding:0!important
}
#contact .branch-item+.branch-item {
  border-left:1px solid #d7dee8!important;
  padding-left:30px!important
}
#contact .branch-item small {
  display:block!important;
  width:100%!important;
  margin:0 0 16px!important;
  color:#006bff!important;
  text-align:center!important;
  line-height:1.1!important
}
#contact .branch-item b {
  display:block!important;
  margin:0 0 8px!important;
  line-height:1.2!important
}
#contact .branch-item>span {
  display:block!important;
  margin:0 0 30px!important;
  line-height:1.2!important
}
#contact .branch-meta {
  display:grid!important;
  grid-template-columns:18px max-content max-content!important;
  gap:10px!important;
  align-items:center!important;
  margin:0 0 14px!important;
  white-space:nowrap!important;
  line-height:1.2!important
}
#contact .branch-meta i {
  width:18px!important;
  font-size:14px!important;
  text-align:center!important;
  color:#ff7a00!important
}
#contact .branch-meta span,
#contact .branch-meta b {
  margin:0!important;
  white-space:nowrap!important
}
#contact .branch-meta b {
  font-weight:500!important
}
#contact .quick-row {
  display:grid!important;
  grid-template-columns:300px minmax(0,1fr)!important;
  gap:32px!important;
  align-items:start!important;
  margin:0!important
}
#contact .quick-answer-card {
  min-width:0!important;
  padding:0!important
}
#contact .quick-answer-card>h3 {
  margin-bottom:18px!important
}
#contact .quick-answer-card button {
  display:grid!important;
  grid-template-columns:22px minmax(0,1fr) 14px!important;
  align-items:center!important;
  height:32px!important;
  padding:0!important;
  border-bottom:1px solid #e8edf3!important
}
#contact .quick-answer-card button span {
  width:22px!important;
  height:22px!important;
  display:grid!important;
  place-items:center!important
}
#contact .quick-answer-card button b {
  text-align:left!important;
  white-space:nowrap!important
}
#contact .branch-notes {
  min-height:74px!important;
  padding-left:32px!important;
  border-left:1px solid #d7dee8!important;
  display:flex!important;
  flex-direction:column!important;
  justify-content:center!important;
  gap:16px!important
}
#contact .branch-notes p {
  display:grid!important;
  grid-template-columns:20px max-content!important;
  gap:16px!important;
  align-items:center!important;
  margin:0!important;
  line-height:1.35!important;
  white-space:nowrap!important
}
#contact .branch-notes p i {
  width:20px!important;
  font-size:18px!important;
  text-align:center!important;
  color:#ff7a00!important
}
#contact .branch-address,
#contact .branch-address + .branch-meta {
  padding-bottom:10px!important;
  border-bottom:1px solid #e4e9f1!important
}
#contact .branch-address {
  gap:10px!important;
  margin-bottom:14px!important
}
#contact .branch-address i {
  flex:0 0 16px!important;
  width:16px!important;
  font-size:15px!important
}
#contact .branch-address span {
  white-space:nowrap!important
}
#contact .form-bottom {
  display:grid!important;
  grid-template-columns:minmax(0,1fr) auto!important;
  align-items:center!important
}
#contact .form-bottom small {
  max-width:none!important;
  white-space:nowrap!important;
  line-height:1!important
}
#contact .ui-btn.orange-btn:hover,
#contact .ui-btn.orange-btn:focus {
  background:#111!important;
  color:#fff!important;
  filter:none!important
}
#contact .ui-btn.orange-btn:hover i,
#contact .ui-btn.orange-btn:focus i {
  color:#fff!important
}
@media(max-width:1320px) {
  #contact.contact-section {
    padding-left:50px!important;
    padding-right:50px!important
  }
  #contact .contact-grid {
    grid-template-columns:400px minmax(0,1fr)!important;
    gap:36px!important
  }
  #contact .form-card {
    width:400px!important;
    max-width:400px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:280px minmax(0,1fr)!important;
    gap:34px!important
  }
  #contact .branch-list {
    gap:34px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:34px!important
  }
}
@media(max-width:1080px) {
  #contact.contact-section {
    padding:32px 22px 48px!important
  }
  #contact .contact-grid,
  #contact .contact-details .info-card,
  #contact .branch-list,
  #contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .form-card {
    width:100%!important;
    max-width:none!important
  }
  #contact .touch-box,
  #contact .branch-item+.branch-item,
  #contact .branch-notes {
    border-left:0!important;
    border-right:0!important;
    padding-left:0!important;
    padding-right:0!important
  }
}
</style>
@include('components.front-footer')
<style id="contact-layout-last-pass-0615">
#contact .contact-info-item,
#contact .branch-meta,
#contact .branch-notes p {
  min-width:0!important;
  word-break:normal!important;
  overflow-wrap:normal!important
}
#contact .contact-info-copy {
  width:100%!important
}
#contact .contact-info-copy b,
#contact .contact-info-copy span,
#contact .contact-info-copy small,
#contact .branch-meta span,
#contact .branch-meta b {
  white-space:nowrap!important;
  letter-spacing:0!important
}
#contact .branch-meta {
  display:flex!important;
  align-items:center!important;
  gap:16px!important
}
#contact .branch-meta i {
  flex:0 0 24px!important
}
#contact .branch-meta span {
  flex:0 0 auto!important
}
#contact .branch-meta b {
  flex:0 0 auto!important
}
#contact .touch-box,
#contact .branch-card,
#contact .quick-answer-card,
#contact .branch-notes {
  box-sizing:border-box!important
}
#contact .touch-box {
  width:300px!important
}
#contact .branch-card {
  width:100%!important
}
#contact .contact-grid {
  grid-template-columns:410px minmax(0,1fr)!important;
  column-gap:56px!important
}
#contact .form-card {
  width:410px!important;
  max-width:410px!important
}
#contact .contact-details {
  gap:34px!important;
  padding-top:8px!important
}
#contact .contact-details .info-card {
  grid-template-columns:270px minmax(0,1fr)!important;
  gap:44px!important
}
#contact .touch-box {
  width:270px!important;
  padding-right:32px!important
}
#contact .touch-box>h3,
#contact .branch-card>h3,
#contact .quick-answer-card>h3 {
  gap:12px!important;
  margin-bottom:26px!important
}
#contact .touch-box>h3 i,
#contact .branch-card>h3 i,
#contact .quick-answer-card>h3 i {
  width:24px!important;
  min-width:24px!important;
  font-size:24px!important
}
#contact .contact-info-item {
  grid-template-columns:22px minmax(0,1fr)!important;
  gap:16px!important;
  margin-bottom:24px!important
}
#contact .contact-info-item>i {
  width:22px!important;
  min-width:22px!important;
  font-size:18px!important
}
#contact .branch-list {
  gap:46px!important
}
#contact .branch-item+.branch-item {
  padding-left:46px!important
}
#contact .branch-address {
  display:flex!important;
  align-items:center!important;
  gap:16px!important;
  margin:0 0 24px!important;
  min-width:0!important;
  white-space:nowrap!important
}
#contact .branch-address i {
  flex:0 0 18px!important;
  width:18px!important;
  color:#ef2f45!important;
  font-size:17px!important;
  text-align:center!important
}
#contact .branch-address span {
  white-space:nowrap!important;
  line-height:1.2!important
}
#contact .branch-meta {
  gap:14px!important;
  margin-bottom:22px!important
}
#contact .branch-meta i {
  flex:0 0 18px!important;
  width:18px!important;
  font-size:15px!important
}
#contact .quick-row {
  grid-template-columns:340px minmax(0,1fr)!important;
  gap:50px!important
}
#contact .quick-answer-card button {
  height:38px!important;
  grid-template-columns:24px minmax(0,1fr) 14px!important
}
#contact .quick-answer-card button span {
  width:24px!important;
  height:24px!important
}
#contact .quick-answer-card button span i {
  font-size:14px!important
}
#contact .branch-notes {
  min-height:94px!important;
  gap:24px!important;
  padding-left:46px!important
}
#contact .branch-notes p {
  grid-template-columns:24px minmax(0,1fr)!important;
  gap:22px!important
}
#contact .branch-notes p i {
  width:24px!important;
  font-size:22px!important
}
@media(max-width:1320px) {
  #contact .touch-box {
    width:260px!important
  }
  #contact .contact-grid {
    grid-template-columns:390px minmax(0,1fr)!important;
    column-gap:36px!important
  }
  #contact .form-card {
    width:390px!important;
    max-width:390px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:260px minmax(0,1fr)!important;
    gap:32px!important
  }
}
@media(max-width:1080px) {
  #contact .touch-box,
  #contact .branch-card {
    width:100%!important
  }
  #contact .contact-grid,
  #contact .contact-details .info-card,
  #contact .branch-list,
  #contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .form-card {
    width:100%!important;
    max-width:none!important
  }
  #contact .branch-item+.branch-item,
  #contact .branch-notes {
    padding-left:0!important
  }
  #contact .contact-info-copy b,
  #contact .contact-info-copy span,
  #contact .contact-info-copy small,
  #contact .branch-address,
  #contact .branch-address span,
  #contact .branch-meta span,
  #contact .branch-meta b {
    white-space:normal!important
  }
}
</style>
<style id="contact-yellowline-space-adjust-final-0623">
/* Final spacing adjustment based on the yellow-line reference only */
#contact.contact-section {
  padding-left:50px!important;
  padding-right:50px!important
}
#contact .contact-grid {
  grid-template-columns:410px minmax(0,1fr)!important;
  column-gap:34px!important
}
#contact .contact-details {
  gap:28px!important;
  padding-top:8px!important
}
#contact .contact-details .info-card {
  grid-template-columns:250px minmax(0,1fr)!important;
  gap:28px!important
}
#contact .touch-box {
  width:250px!important;
  padding-right:22px!important
}
#contact .touch-box>h3,
#contact .branch-card>h3,
#contact .quick-answer-card>h3 {
  margin-bottom:22px!important
}
#contact .contact-info-item {
  grid-template-columns:22px minmax(0,1fr)!important;
  gap:13px!important;
  margin-bottom:20px!important
}
#contact .branch-list {
  gap:28px!important
}
#contact .branch-item+.branch-item {
  padding-left:28px!important
}
#contact .branch-address {
  gap:12px!important;
  margin-bottom:18px!important
}
#contact .branch-meta {
  gap:10px!important;
  margin-bottom:18px!important
}
#contact .quick-row {
  grid-template-columns:310px minmax(0,1fr)!important;
  gap:30px!important
}
#contact .branch-notes {
  min-height:82px!important;
  padding-left:26px!important;
  gap:16px!important
}
#contact .branch-notes p {
  gap:14px!important
}
@media(max-width:1320px) {
  #contact.contact-section {
    padding-left:40px!important;
    padding-right:40px!important
  }
  #contact .contact-grid {
    grid-template-columns:390px minmax(0,1fr)!important;
    column-gap:28px!important
  }
  #contact .form-card {
    width:390px!important;
    max-width:390px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:240px minmax(0,1fr)!important;
    gap:24px!important
  }
  #contact .touch-box {
    width:240px!important;
    padding-right:20px!important
  }
  #contact .branch-list {
    gap:22px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:22px!important
  }
  #contact .quick-row {
    grid-template-columns:300px minmax(0,1fr)!important;
    gap:26px!important
  }
  #contact .branch-notes {
    padding-left:22px!important
  }
}
@media(max-width:1080px) {
  #contact.contact-section {
    padding:32px 22px 48px!important
  }
  #contact .contact-grid,
  #contact .contact-details .info-card,
  #contact .branch-list,
  #contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .form-card,
  #contact .touch-box {
    width:100%!important;
    max-width:none!important
  }
  #contact .touch-box,
  #contact .branch-item+.branch-item,
  #contact .branch-notes {
    border-left:0!important;
    border-right:0!important;
    padding-left:0!important;
    padding-right:0!important
  }
}
</style>
<style id="contact-yellowline-more-compact-final-0623">
/* Mas binawasan pa ang highlighted yellow-line spaces only */
#contact.contact-section {
  padding-left:50px!important;
  padding-right:32px!important
}
#contact .contact-grid {
  grid-template-columns:410px minmax(0,1fr)!important;
  column-gap:24px!important
}
#contact .contact-details {
  gap:24px!important;
  padding-top:6px!important
}
#contact .contact-details .info-card {
  grid-template-columns:236px minmax(0,1fr)!important;
  gap:18px!important
}
#contact .touch-box {
  width:236px!important;
  padding-right:16px!important;
  border-right:1px solid #e2e7ef!important
}
#contact .contact-info-item {
  grid-template-columns:20px minmax(0,1fr)!important;
  gap:10px!important;
  margin-bottom:18px!important
}
#contact .contact-info-item>i {
  width:20px!important;
  min-width:20px!important;
  font-size:17px!important
}
#contact .touch-box>h3,
#contact .branch-card>h3,
#contact .quick-answer-card>h3 {
  gap:10px!important;
  margin-bottom:20px!important
}
#contact .touch-box>h3 i,
#contact .branch-card>h3 i,
#contact .quick-answer-card>h3 i {
  width:22px!important;
  min-width:22px!important;
  font-size:22px!important
}
#contact .branch-list {
  gap:14px!important
}
#contact .branch-item+.branch-item {
  padding-left:14px!important;
  border-left:1px solid #d7dee8!important
}
#contact .branch-item small {
  margin-bottom:14px!important
}
#contact .branch-address {
  gap:9px!important;
  margin-bottom:14px!important;
  padding-bottom:8px!important
}
#contact .branch-address i {
  flex:0 0 16px!important;
  width:16px!important
}
#contact .branch-meta {
  gap:8px!important;
  margin-bottom:14px!important;
  padding-bottom:8px!important
}
#contact .branch-meta i {
  flex:0 0 16px!important;
  width:16px!important
}
#contact .quick-row {
  grid-template-columns:295px minmax(0,1fr)!important;
  gap:18px!important
}
#contact .quick-answer-card button {
  height:31px!important;
  grid-template-columns:22px minmax(0,1fr) 12px!important
}
#contact .branch-notes {
  min-height:70px!important;
  padding-left:18px!important;
  gap:12px!important;
  border-left:1px solid #d7dee8!important
}
#contact .branch-notes p {
  grid-template-columns:20px max-content!important;
  gap:10px!important;
  line-height:1.25!important
}
#contact .branch-notes p i {
  width:20px!important;
  font-size:18px!important
}
@media(max-width:1320px) {
  #contact.contact-section {
    padding-left:36px!important;
    padding-right:28px!important
  }
  #contact .contact-grid {
    grid-template-columns:388px minmax(0,1fr)!important;
    column-gap:20px!important
  }
  #contact .form-card {
    width:388px!important;
    max-width:388px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:228px minmax(0,1fr)!important;
    gap:16px!important
  }
  #contact .touch-box {
    width:228px!important;
    padding-right:14px!important
  }
  #contact .branch-list {
    gap:12px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:12px!important
  }
  #contact .branch-address,
  #contact .branch-meta {
    gap:7px!important
  }
  #contact .quick-row {
    grid-template-columns:290px minmax(0,1fr)!important;
    gap:16px!important
  }
  #contact .branch-notes {
    padding-left:16px!important
  }
}
@media(max-width:1080px) {
  #contact.contact-section {
    padding:32px 22px 48px!important
  }
  #contact .contact-grid,
  #contact .contact-details .info-card,
  #contact .branch-list,
  #contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .form-card,
  #contact .touch-box {
    width:100%!important;
    max-width:none!important
  }
  #contact .touch-box,
  #contact .branch-item+.branch-item,
  #contact .branch-notes {
    border-left:0!important;
    border-right:0!important;
    padding-left:0!important;
    padding-right:0!important
  }
}
</style>

<style id="contact-rightspace-more-compact-final-0623">
/* Mas compact ang Contact Us right content para mas malaki ang rightspace ng section */
#contact.contact-section {
  padding-left:50px!important;
  padding-right:70px!important
}
#contact .contact-grid {
  grid-template-columns:410px max-content!important;
  column-gap:24px!important;
  justify-content:start!important
}
#contact .contact-details {
  width:790px!important;
  max-width:790px!important;
  min-width:0!important;
  gap:22px!important;
  padding-top:6px!important
}
#contact .contact-details .info-card {
  grid-template-columns:226px 540px!important;
  gap:18px!important;
  width:790px!important;
  max-width:790px!important
}
#contact .touch-box {
  width:226px!important;
  padding-right:14px!important;
  border-right:1px solid #e2e7ef!important
}
#contact .contact-info-item {
  grid-template-columns:20px minmax(0,1fr)!important;
  gap:9px!important;
  margin-bottom:16px!important
}
#contact .contact-info-item>i {
  width:20px!important;
  min-width:20px!important;
  font-size:16px!important
}
#contact .touch-box>h3,
#contact .branch-card>h3,
#contact .quick-answer-card>h3 {
  gap:9px!important;
  margin-bottom:18px!important
}
#contact .touch-box>h3 i,
#contact .branch-card>h3 i,
#contact .quick-answer-card>h3 i {
  width:21px!important;
  min-width:21px!important;
  font-size:21px!important
}
#contact .branch-card {
  width:540px!important;
  max-width:540px!important
}
#contact .branch-list {
  display:grid!important;
  grid-template-columns:260px 260px!important;
  gap:10px!important;
  width:530px!important;
  max-width:530px!important
}
#contact .branch-item+.branch-item {
  padding-left:10px!important;
  border-left:1px solid #d7dee8!important
}
#contact .branch-item small {
  margin-bottom:12px!important
}
#contact .branch-address {
  gap:7px!important;
  margin-bottom:12px!important;
  padding-bottom:7px!important
}
#contact .branch-address i {
  flex:0 0 15px!important;
  width:15px!important;
  font-size:14px!important
}
#contact .branch-meta {
  gap:6px!important;
  margin-bottom:12px!important;
  padding-bottom:7px!important
}
#contact .branch-meta i {
  flex:0 0 15px!important;
  width:15px!important;
  font-size:13px!important
}
#contact .quick-row {
  grid-template-columns:285px 380px!important;
  gap:12px!important;
  width:680px!important;
  max-width:680px!important
}
#contact .quick-answer-card button {
  height:30px!important;
  grid-template-columns:21px minmax(0,1fr) 12px!important
}
#contact .quick-answer-card button span {
  width:21px!important;
  height:21px!important
}
#contact .branch-notes {
  min-height:66px!important;
  padding-left:12px!important;
  gap:10px!important;
  border-left:1px solid #d7dee8!important
}
#contact .branch-notes p {
  grid-template-columns:18px max-content!important;
  gap:8px!important;
  line-height:1.2!important
}
#contact .branch-notes p i {
  width:18px!important;
  font-size:16px!important
}
@media(max-width:1320px) {
  #contact.contact-section {
    padding-left:36px!important;
    padding-right:58px!important
  }
  #contact .contact-grid {
    grid-template-columns:388px max-content!important;
    column-gap:20px!important
  }
  #contact .form-card {
    width:388px!important;
    max-width:388px!important
  }
  #contact .contact-details {
    width:740px!important;
    max-width:740px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:216px 504px!important;
    gap:16px!important;
    width:740px!important;
    max-width:740px!important
  }
  #contact .touch-box {
    width:216px!important;
    padding-right:12px!important
  }
  #contact .branch-card {
    width:504px!important;
    max-width:504px!important
  }
  #contact .branch-list {
    grid-template-columns:245px 245px!important;
    gap:8px!important;
    width:498px!important;
    max-width:498px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:8px!important
  }
  #contact .quick-row {
    grid-template-columns:280px 355px!important;
    gap:10px!important;
    width:645px!important;
    max-width:645px!important
  }
  #contact .branch-notes {
    padding-left:10px!important
  }
}
@media(max-width:1080px) {
  #contact.contact-section {
    padding:32px 22px 48px!important
  }
  #contact .contact-grid,
  #contact .contact-details .info-card,
  #contact .branch-list,
  #contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .contact-details,
  #contact .contact-details .info-card,
  #contact .form-card,
  #contact .touch-box,
  #contact .branch-card,
  #contact .branch-list,
  #contact .quick-row {
    width:100%!important;
    max-width:none!important
  }
  #contact .touch-box,
  #contact .branch-item+.branch-item,
  #contact .branch-notes {
    border-left:0!important;
    border-right:0!important;
    padding-left:0!important;
    padding-right:0!important
  }
}
</style>

<style id="contact-balanced-spacing-final-0623">
/* Balanced spacing: may space pa rin, pero hindi sobrang luwag at hindi sobrang dikit */
#contact.contact-section {
  padding-left:50px!important;
  padding-right:50px!important
}
#contact .contact-grid {
  grid-template-columns:410px minmax(0,850px)!important;
  column-gap:28px!important;
  justify-content:start!important
}
#contact .contact-details {
  width:100%!important;
  max-width:850px!important;
  min-width:0!important;
  gap:26px!important;
  padding-top:6px!important
}
#contact .contact-details .info-card {
  grid-template-columns:240px minmax(0,590px)!important;
  gap:20px!important;
  width:100%!important;
  max-width:850px!important
}
#contact .touch-box {
  width:240px!important;
  padding-right:18px!important;
  border-right:1px solid #e2e7ef!important
}
#contact .contact-info-item {
  grid-template-columns:21px minmax(0,1fr)!important;
  gap:11px!important;
  margin-bottom:18px!important
}
#contact .contact-info-item>i {
  width:21px!important;
  min-width:21px!important;
  font-size:17px!important
}
#contact .touch-box>h3,
#contact .branch-card>h3,
#contact .quick-answer-card>h3 {
  gap:11px!important;
  margin-bottom:21px!important
}
#contact .touch-box>h3 i,
#contact .branch-card>h3 i,
#contact .quick-answer-card>h3 i {
  width:23px!important;
  min-width:23px!important;
  font-size:23px!important
}
#contact .branch-card {
  width:100%!important;
  max-width:590px!important
}
#contact .branch-list {
  display:grid!important;
  grid-template-columns:minmax(0,1fr) minmax(0,1fr)!important;
  gap:24px!important;
  width:100%!important;
  max-width:590px!important
}
#contact .branch-item+.branch-item {
  padding-left:24px!important;
  border-left:1px solid #d7dee8!important
}
#contact .branch-item small {
  margin-bottom:14px!important
}
#contact .branch-address {
  gap:10px!important;
  margin-bottom:15px!important;
  padding-bottom:8px!important
}
#contact .branch-address i {
  flex:0 0 16px!important;
  width:16px!important;
  font-size:15px!important
}
#contact .branch-meta {
  gap:9px!important;
  margin-bottom:15px!important;
  padding-bottom:8px!important
}
#contact .branch-meta i {
  flex:0 0 16px!important;
  width:16px!important;
  font-size:14px!important
}
#contact .quick-row {
  grid-template-columns:300px minmax(0,440px)!important;
  gap:24px!important;
  width:100%!important;
  max-width:764px!important
}
#contact .quick-answer-card button {
  height:32px!important;
  grid-template-columns:22px minmax(0,1fr) 12px!important
}
#contact .quick-answer-card button span {
  width:22px!important;
  height:22px!important
}
#contact .branch-notes {
  min-height:72px!important;
  padding-left:22px!important;
  gap:14px!important;
  border-left:1px solid #d7dee8!important
}
#contact .branch-notes p {
  grid-template-columns:20px max-content!important;
  gap:12px!important;
  line-height:1.25!important
}
#contact .branch-notes p i {
  width:20px!important;
  font-size:18px!important
}
@media(max-width:1320px) {
  #contact.contact-section {
    padding-left:40px!important;
    padding-right:40px!important
  }
  #contact .contact-grid {
    grid-template-columns:390px minmax(0,760px)!important;
    column-gap:24px!important
  }
  #contact .form-card {
    width:390px!important;
    max-width:390px!important
  }
  #contact .contact-details {
    max-width:760px!important
  }
  #contact .contact-details .info-card {
    grid-template-columns:230px minmax(0,510px)!important;
    gap:18px!important;
    max-width:760px!important
  }
  #contact .touch-box {
    width:230px!important;
    padding-right:16px!important
  }
  #contact .branch-card,
  #contact .branch-list {
    max-width:510px!important
  }
  #contact .branch-list {
    gap:20px!important
  }
  #contact .branch-item+.branch-item {
    padding-left:20px!important
  }
  #contact .quick-row {
    grid-template-columns:295px minmax(0,405px)!important;
    gap:20px!important;
    max-width:720px!important
  }
  #contact .branch-notes {
    padding-left:20px!important
  }
}
@media(max-width:1080px) {
  #contact.contact-section {
    padding:32px 22px 48px!important
  }
  #contact .contact-grid,
  #contact .contact-details .info-card,
  #contact .branch-list,
  #contact .quick-row {
    grid-template-columns:1fr!important
  }
  #contact .contact-details,
  #contact .contact-details .info-card,
  #contact .form-card,
  #contact .touch-box,
  #contact .branch-card,
  #contact .branch-list,
  #contact .quick-row {
    width:100%!important;
    max-width:none!important
  }
  #contact .touch-box,
  #contact .branch-item+.branch-item,
  #contact .branch-notes {
    border-left:0!important;
    border-right:0!important;
    padding-left:0!important;
    padding-right:0!important
  }
}
</style>

<style id="contact-about-us-left-spacing-only-final">
/* Left spacing only: matched to About Us desktop alignment. Nothing else changed. */
#contact.contact-section {
  padding-left:80px!important;
}
@media(max-width:1320px) {
  #contact.contact-section {
    padding-left:80px!important;
  }
}
@media(max-width:1080px) {
  #contact.contact-section {
    padding-left:22px!important;
  }
}
@media(max-width:760px) {
  #contact.contact-section {
    padding-left:14px!important;
  }
}
</style>

<style id="contact-send-message-height-compact-final-0623">
/* Final request: bawas height ng Send Us a Message main box, Message field, Upload File, at inner spacing */
#contact .form-card {
  height:auto!important;
  min-height:0!important;
  padding:14px 18px 12px!important;
}

#contact .form-card .card-title {
  margin-bottom:9px!important;
  gap:10px!important;
}

#contact .form-card .card-title>i {
  width:32px!important;
  min-width:32px!important;
  height:32px!important;
  font-size:22px!important;
}

#contact .form-card .card-title h3 {
  font-size:20px!important;
  line-height:1!important;
  margin:0 0 3px!important;
}

#contact .form-card .card-title p {
  font-size:10px!important;
  line-height:1.2!important;
  margin:0!important;
}

#contact .form-card form {
  min-height:0!important;
}

#contact .form-fields {
  gap:6px!important;
  flex:0 0 auto!important;
}

#contact .form-row,
#contact .message-row,
#contact .upload-row {
  flex:0 0 auto!important;
  margin:0!important;
}

#contact .form-row>span {
  margin:0 0 3px!important;
  font-size:11px!important;
  line-height:1!important;
}

#contact .input-wrapper i {
  left:12px!important;
  width:14px!important;
  font-size:12px!important;
}

#contact .input-wrapper input {
  height:28px!important;
  min-height:28px!important;
  padding:6px 10px 6px 34px!important;
  font-size:12px!important;
  line-height:1.1!important;
}

#contact .input-wrapper textarea {
  height:44px!important;
  min-height:44px!important;
  max-height:44px!important;
  padding:8px 10px 6px 34px!important;
  font-size:12px!important;
  line-height:1.2!important;
  resize:none!important;
}

#contact .textarea-wrapper i {
  top:9px!important;
  transform:none!important;
}

#contact .upload-drop {
  min-height:36px!important;
  height:36px!important;
  padding:4px 9px!important;
  gap:8px!important;
  align-items:center!important;
  justify-content:center!important;
}

#contact .upload-drop>i {
  font-size:16px!important;
}

#contact .upload-drop>span {
  gap:0!important;
  line-height:1!important;
}

#contact .upload-drop b {
  font-size:10.5px!important;
  line-height:1!important;
}

#contact .upload-drop small {
  font-size:9.5px!important;
  line-height:1!important;
}

#contact .form-bottom {
  margin-top:8px!important;
  gap:10px!important;
}

#contact .form-bottom small {
  font-size:10px!important;
  line-height:1.05!important;
}

#contact .form-bottom .ui-btn {
  width:112px!important;
  min-width:112px!important;
  height:28px!important;
  min-height:28px!important;
  padding:6px 12px!important;
  font-size:10.5px!important;
}

@media(max-width:1320px) {
  #contact .form-card {
    padding:13px 16px 11px!important;
  }

  #contact .form-fields {
    gap:6px!important;
  }

  #contact .input-wrapper input {
    height:28px!important;
    min-height:28px!important;
  }

  #contact .input-wrapper textarea {
    height:42px!important;
    min-height:42px!important;
    max-height:42px!important;
  }

  #contact .upload-drop {
    min-height:35px!important;
    height:35px!important;
  }
}

@media(max-width:1080px) {
  #contact .form-card {
    width:100%!important;
    max-width:none!important;
  }
}
</style>
