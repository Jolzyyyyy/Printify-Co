<x-app-layout> @once <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700&display=swap"> @endonce @php $settingsUser = auth()->user(); $settingsPhoto = $settingsUser->profile_photo_url ?? $settingsUser->profile_photo ?? null; $settingsName = $settingsUser->name ?? ''; $settingsEmail = $settingsUser->email ?? ''; $settingsPhone = $settingsUser->phone ?? ''; $settingsBirthdate = $settingsUser->birthdate ?? ''; $settingsCompany = $settingsUser->company ?? ''; $settingsCustomerId = $settingsUser ? 'CUST-'.str_pad((string) $settingsUser->id, 5, '0', STR_PAD_LEFT) : 'Not set'; @endphp
<div class="st-page">
<div class="st-wrap">
<div class="st-top">
<div class="st-title-wrap">
<div>
<h1 class="st-title">Settings</h1>
<p class="st-subtitle">Manage your account preferences, profile, and security settings.</p>
</div>
</div>
<div class="st-date">
<i class="fa-regular fa-calendar-days">
</i>
<span>Today is {{ now()->format('M d, Y') }}</span>
</div>
</div>
<div class="st-tabs">
<button class="st-tab active" data-tab="overview">Overview</button>
<button class="st-tab" data-tab="profile">Profile</button>
<button class="st-tab" data-tab="security">Security</button>
<button class="st-tab" data-tab="notifications">Notifications</button>
<button class="st-tab" data-tab="payments">Payments</button>
<button class="st-tab" data-tab="addresses">Addresses</button>
<button class="st-tab" data-tab="preferences">Preferences</button>
<button class="st-tab" data-tab="privacy">Privacy</button>
</div>



{{-- =========================================================
   //OVERVIEW//
   HTML + CSS + JS CODES NG OVERVIEW
   ========================================================= --}}

{{-- OVERVIEW HTML --}}
<section id="panel-overview" class="st-panel active">
<div class="st-grid">
<div class="st-stack overview-left-stack">
<div class="st-card overview-profile-box">
<div class="st-body">
<div class="st-head">
<h2 class="st-card-title">Profile Summary</h2>
<button class="st-btn" type="button" data-modal-open="profileModal">Edit Profile</button>
</div>
<div class="st-profile">
<div class="st-profile-left">
<div class="st-avatar-wrap">
<img class="st-avatar" src="{{ $settingsPhoto ?: 'https://i.pravatar.cc/220?img=47' }}" alt="Profile">
<button class="st-camera" type="button" aria-label="Change photo" onclick="openPhotoPicker()">
<i class="fa-solid fa-camera">
</i>
</button>
<input id="settingsPhotoInput" type="file" accept="image/*" hidden>
</div>
<div>
<div class="st-name-row">
<h3 id="profileDisplayName" class="st-name">{{ $settingsName ?: 'Not set' }}</h3>
<span class="st-badge green">
<i class="fa-solid fa-check">
</i> Verified</span>
</div>
<div id="profileDisplayEmail" class="st-info">{{ $settingsEmail ?: 'Not set' }}</div>
<div class="st-info">Customer ID: <strong>{{ $settingsCustomerId }}</strong>
<button class="st-copy" type="button" onclick="copySettingsText(@js($settingsCustomerId))">
<i class="fa-regular fa-copy">
</i>
</button>
</div>
<div class="st-info">Member since {{ optional($settingsUser->created_at)->format('F j, Y') ?: 'Not set' }}</div>
<span class="st-badge orange">Premium Member</span>
</div>
</div>
<div class="st-profile-right">
<div class="st-detail">
<div class="st-detail-left">
<span class="st-ico">
<i class="fa-solid fa-phone">
</i>
</span>
<div>
<p class="st-label">Phone Number</p>
<p id="profileDisplayPhone" class="st-value">{{ $settingsPhone ?: 'Not set' }}</p>
</div>
</div>
<button class="st-link" type="button" data-modal-open="profileModal">Edit</button>
</div>
<div class="st-detail">
<div class="st-detail-left">
<span class="st-ico">
<i class="fa-regular fa-calendar">
</i>
</span>
<div>
<p class="st-label">Date of Birth</p>
<p id="profileDisplayBirth" class="st-value">{{ $settingsBirthdate ?: 'Not set' }}</p>
</div>
</div>
<button class="st-link" type="button" data-modal-open="profileModal">Edit</button>
</div>
<div class="st-detail">
<div class="st-detail-left">
<span class="st-ico">
<i class="fa-regular fa-building">
</i>
</span>
<div>
<p class="st-label">Company (Optional)</p>
<p id="profileDisplayCompany" class="st-value">{{ $settingsCompany ?: 'Not set' }}</p>
</div>
</div>
<button class="st-link" type="button" data-modal-open="profileModal">Edit</button>
</div>
</div>
</div>
</div>
<div class="st-section-line">
</div>
<div class="st-head st-address-head-clean">
<h2 class="st-card-title">Address Book</h2>
</div>
<div class="st-address-grid">
<div class="st-box">
<button class="st-kebab" type="button" onclick="openAddressActions('Home Address')" aria-label="Home address actions">
<i class="fa-solid fa-ellipsis-vertical">
</i>
</button>
<span class="st-mini orange">Primary</span>
<h3 class="st-box-title">Home Address</h3>
<p class="st-box-text">123 Printify Avenue<br>Makati City, Metro Manila 1200<br>Philippines<br>+63 912 345 6789</p>
</div>
<div class="st-box">
<button class="st-kebab" type="button" onclick="openAddressActions('Work')" aria-label="Work address actions">
<i class="fa-solid fa-ellipsis-vertical">
</i>
</button>
<h3 class="st-box-title">Work</h3>
<p class="st-box-text">45 Timog Avenue<br>Quezon City, Metro Manila 1103<br>Philippines<br>+63 912 345 6789</p>
</div>
<button class="st-add-box st-address-placeholder" type="button" onclick="openNewAddressModal()">
<span class="st-add-circle">
<i class="fa-solid fa-plus">
</i>
</span>Add New Address</button>
</div>
</div>
<div class="st-card overview-plain-panel overview-notif-panel">
<div class="st-body">
<h2 class="st-card-title">Notification Preferences</h2>
<p class="st-card-desc">Manage how you want to be notified.</p>
<div class="st-list" style="margin-top:10px">
@php $notifs=[ ['box','Order Updates','Get notified about order status and delivery',true], ['percent','Promotions & Offers','Receive exclusive deals and promotions',true], ['circle-plus','New Services & Features','Updates about new services and features',false], ['lightbulb','Tips & Resources','Helpful tips and printing guides',true], ['comment-dots','SMS Notifications','Receive important alerts via SMS',false], ];
@endphp
@foreach($notifs as $n) <div class="st-notif-item">
<div class="st-notif-left">
<span class="st-ico">
<i class="fa-solid fa-{{ $n[0] }}">
</i>
</span>
<div>
<p class="st-notif-title">{{ $n[1] }}</p>
<p class="st-notif-sub">{{ $n[2] }}</p>
</div>
</div>
<label class="st-switch">
<input type="checkbox" @checked($n[3]) onchange="toggleSettingMessage(this,'{{ $n[1] }}')">
<span class="st-slider">
</span>
</label>
</div>
@endforeach </div>
<button type="button" class="st-manage" data-tab-jump="notifications">Manage all notification settings <i class="fa-solid fa-arrow-right" style="float:right">
</i>
</button>
</div>
</div>
<div class="st-card overview-plain-panel overview-comm-panel">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Communication Preferences</h2>
<p class="st-card-desc">Choose which customer communication channels stay active.</p>
</div>
<button class="st-btn" type="button" data-tab-jump="notifications">Manage</button>
</div>
<div class="st-list" style="margin-top:10px">
@php $commPrefs=[ ['envelope','Email Messages','Receive account and order communication via email',true], ['comment-dots','SMS Messages','Receive short updates and urgent order alerts by SMS',true], ['bell','Dashboard Alerts','Show live alerts inside the customer dashboard',true], ['headset','Support Replies','Notify you when support sends a reply',true], ];
@endphp
@foreach($commPrefs as $pref) <div class="st-comm-item">
<div class="st-comm-left">
<span class="st-orange-ico">
<i class="fa-solid fa-{{ $pref[0] }}">
</i>
</span>
<div>
<p class="st-comm-title">{{ $pref[1] }}</p>
<p class="st-comm-sub">{{ $pref[2] }}</p>
</div>
</div>
<label class="st-switch">
<input type="checkbox" @checked($pref[3]) onchange="toggleSettingMessage(this,'{{ $pref[1] }}')">
<span class="st-slider">
</span>
</label>
</div>
@endforeach </div>
</div>
</div>
<div class="st-card st-right-slim overview-plain-panel overview-activity-panel">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Account Activity</h2>
<p class="st-card-desc">Review your recent account activity.</p>
</div>
<button class="st-btn" type="button" onclick="openActivityLogPanel()">View All Activity</button>
</div>
<div>
<div class="st-activity-row">
<div class="st-activity-left">
<span class="st-ico">
<i class="fa-regular fa-clock">
</i>
</span>
<span class="st-act-label">Last Login</span>
</div>
<div class="st-act-val">May 29, 2026&nbsp; 8:15 AM<div style="margin-top:5px">
<span class="st-mini">This Device</span>
</div>
</div>
</div>
<div class="st-activity-row">
<div class="st-activity-left">
<span class="st-ico">
<i class="fa-solid fa-location-dot">
</i>
</span>
<span class="st-act-label">Login Location</span>
</div>
<div class="st-act-val">Makati City, Metro Manila, Philippines</div>
</div>
<div class="st-activity-row">
<div class="st-activity-left">
<span class="st-ico">
<i class="fa-solid fa-laptop">
</i>
</span>
<span class="st-act-label">Active Sessions</span>
</div>
<div class="st-act-val">1 of 3<div style="margin-top:5px">
<button class="st-link" type="button" onclick="openSessionManagerPanel()">Manage Sessions</button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="st-stack overview-right-stack">
<div class="st-card overview-plain-panel overview-privacy-panel">
<div class="st-body">
<h2 class="st-card-title">Privacy Controls</h2>
<p class="st-card-desc">Manage your data and privacy settings.</p>
<div class="st-privacy-grid" style="margin-top:12px">
<button type="button" class="st-privacy" data-tab-jump="privacy">
<div class="st-privacy-left">
<span class="st-ico">
<i class="fa-solid fa-shield-halved">
</i>
</span>
<div>
<p class="st-privacy-title">Data Privacy</p>
<p class="st-privacy-sub">Manage your personal data</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
<button type="button" class="st-privacy" data-tab-jump="privacy">
<div class="st-privacy-left">
<span class="st-ico">
<i class="fa-solid fa-bullhorn">
</i>
</span>
<div>
<p class="st-privacy-title">Marketing Consent</p>
<p class="st-privacy-sub">Manage marketing permissions</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
<button type="button" class="st-privacy" onclick="showSettingsToast('Your data export request has been prepared.')">
<div class="st-privacy-left">
<span class="st-ico">
<i class="fa-solid fa-download">
</i>
</span>
<div>
<p class="st-privacy-title">Download My Data</p>
<p class="st-privacy-sub">Request a copy of your data</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
</div>
</div>
</div>
<div class="st-card st-right-slim overview-plain-panel overview-payment-panel">
<div class="st-body">
<h2 class="st-card-title">Saved Payment Methods</h2>
<div class="st-list" style="margin-top:12px">
<div class="st-pay-item">
<div class="st-pay-left">
<div class="st-card-logo visa">
<i class="fa-brands fa-cc-visa">
</i>
</div>
<div class="st-pay-text">
<p class="st-pay-title">Visa ending in 4242</p>
<p class="st-pay-sub">Expires 12/27 · {{ $settingsName ?: 'Account holder not set' }}</p>
</div>
</div>
<span class="st-mini orange">Primary</span>
</div>
<div class="st-pay-item">
<div class="st-pay-left">
<div class="st-card-logo master">
<i class="fa-solid fa-circle">
</i>
<i class="fa-solid fa-circle">
</i>
</div>
<div class="st-pay-text">
<p class="st-pay-title">Mastercard ending in 8888</p>
<p class="st-pay-sub">Expires 08/26 · {{ $settingsName ?: 'Account holder not set' }}</p>
</div>
</div>
<button class="st-kebab" style="position:static;flex:0 0 auto" type="button" onclick="openPaymentActions('Mastercard ending in 8888')" aria-label="Payment method actions">
<i class="fa-solid fa-ellipsis-vertical">
</i>
</button>
</div>
<div class="st-pay-bottom">
<button class="st-add-payment" type="button" data-modal-open="paymentModal">
<span class="st-add-circle" style="width:24px;height:24px">
<i class="fa-solid fa-plus">
</i>
</span>
<span>Add New<br>Payment Method</span>
</button>
</div>
</div>
</div>
</div>
<div class="st-card overview-plain-panel overview-quick-panel">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Quick Settings</h2>
<p class="st-card-desc">Manage key account preferences quickly.</p>
</div>
<button class="st-btn" type="button" data-tab-jump="preferences">View All Settings</button>
</div>
<div class="st-quick-grid">
<button class="st-quick" type="button" data-modal-open="profileModal">
<div class="st-quick-left">
<span class="st-orange-ico">
<i class="fa-regular fa-user">
</i>
</span>
<div>
<p class="st-quick-title">Personal Info</p>
<p class="st-quick-sub">Update your personal details</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
<button class="st-quick" type="button" data-tab-jump="security">
<div class="st-quick-left">
<span class="st-orange-ico">
<i class="fa-solid fa-lock">
</i>
</span>
<div>
<p class="st-quick-title">Login & Security</p>
<p class="st-quick-sub">Manage password & 2FA</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
<button class="st-quick" type="button" data-tab-jump="notifications">
<div class="st-quick-left">
<span class="st-orange-ico">
<i class="fa-regular fa-bell">
</i>
</span>
<div>
<p class="st-quick-title">Notification Preferences</p>
<p class="st-quick-sub">Control email & SMS alerts</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
<button class="st-quick" type="button" data-modal-open="paymentModal">
<div class="st-quick-left">
<span class="st-orange-ico">
<i class="fa-regular fa-credit-card">
</i>
</span>
<div>
<p class="st-quick-title">Payment Methods</p>
<p class="st-quick-sub">Manage saved cards & wallets</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
<button class="st-quick" type="button" data-modal-open="addressModal">
<div class="st-quick-left">
<span class="st-orange-ico">
<i class="fa-solid fa-truck-fast">
</i>
</span>
<div>
<p class="st-quick-title">Shipping / Pickup Preferences</p>
<p class="st-quick-sub">Set delivery & pickup options</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
<button class="st-quick" type="button" data-tab-jump="privacy">
<div class="st-quick-left">
<span class="st-orange-ico">
<i class="fa-solid fa-user-shield">
</i>
</span>
<div>
<p class="st-quick-title">Privacy & Permissions</p>
<p class="st-quick-sub">Manage data & visibility</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
<button class="st-quick" type="button" onclick="openSavedFilesPanel()">
<div class="st-quick-left">
<span class="st-orange-ico">
<i class="fa-regular fa-folder-open">
</i>
</span>
<div>
<p class="st-quick-title">Saved Designs / Files</p>
<p class="st-quick-sub">Access your uploaded files</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
<button class="st-quick" type="button" onclick="openConnectedAccountsPanel()">
<div class="st-quick-left">
<span class="st-orange-ico">
<i class="fa-solid fa-link">
</i>
</span>
<div>
<p class="st-quick-title">Connected Accounts</p>
<p class="st-quick-sub">Link social & other accounts</p>
</div>
</div>
<i class="fa-solid fa-chevron-right st-chev">
</i>
</button>
</div>
</div>
</div>
<div class="st-card st-right-slim overview-plain-panel overview-prefs-panel">
<div class="st-body">
<h2 class="st-card-title">Preferences</h2>
<div style="margin-top:8px">
<div class="st-pref-row">
<div class="st-pref-left">
<span class="st-orange-ico">
<i class="fa-solid fa-globe">
</i>
</span>
<span class="st-pref-label">Language</span>
</div>
<select class="st-select" data-setting-name="Language">
<option>English</option>
<option>Tagalog</option>
</select>
</div>
<div class="st-pref-row">
<div class="st-pref-left">
<span class="st-orange-ico">
<i class="fa-solid fa-peso-sign">
</i>
</span>
<span class="st-pref-label">Currency</span>
</div>
<select class="st-select" data-setting-name="Currency">
<option>Philippine Peso (PHP)</option>
<option>US Dollar (USD)</option>
</select>
</div>
<div class="st-pref-row">
<div class="st-pref-left">
<span class="st-orange-ico">
<i class="fa-regular fa-sun">
</i>
</span>
<span class="st-pref-label">Theme</span>
</div>
<select class="st-select" data-setting-name="Theme">
<option>Light Mode</option>
<option>Dark Mode</option>
</select>
</div>
<div class="st-pref-row">
<div class="st-pref-left">
<span class="st-orange-ico">
<i class="fa-regular fa-calendar-days">
</i>
</span>
<span class="st-pref-label">Date Format</span>
</div>
<select class="st-select" data-setting-name="Date Format">
<option>MM/DD/YYYY</option>
<option>DD/MM/YYYY</option>
<option>YYYY-MM-DD</option>
</select>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

{{-- OVERVIEW CSS --}}
<style id="settings-overview-css">
/* OVERVIEW CSS + GLOBAL SETTINGS CSS. Kept complete here para buo pa rin UI ng lahat ng tabs. */
:root{ --st-bg:#fff;--st-card:#fff;--st-line:#111827;--st-line2:#dfe3ea;--st-text:#111827;--st-muted:#6b7280; --st-soft:#9a9a9a;--st-orange:#ff7a00;--st-orange2:#ff7a00;--st-orange3:#fff3e6;--st-green:#16a34a; --st-green-bg:#eef8f2;--st-danger:#d74343;--st-gray-hover:#f4f4f4;--st-gray-active:#e4e4e4;--st-gray-dark:#d2d2d2;--st-shadow:0 10px 26px rgba(35,25,12,.045);--st-radius:14px } .st-page{min-height:calc(100vh - 70px);background:#fff!important;padding:0 0 34px;color:var(--st-text);font-family:'Inter',system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;font-weight:400;letter-spacing:0} .st-wrap{width:100%;max-width:1490px;margin:0 auto;background:#fff!important} .st-top{margin:0 0 12px} .st-title{margin:0;font-family:'Playfair Display',Georgia,serif;font-size:40px;line-height:1.2;font-weight:700;text-transform:none;letter-spacing:-.02em;color:#111827} .st-subtitle{margin:6px 0 0;font-size:12px;color:#666;font-weight:400} .st-tabs{display:flex;gap:26px;align-items:center;border-bottom:1px solid var(--st-line2);margin:0 0 16px;overflow-x:auto;scrollbar-width:none} .st-tabs::-webkit-scrollbar{display:none} .st-tab{appearance:none;border:0;background:transparent;position:relative;padding:11px 0 12px;color:#252525;text-transform:uppercase;font-size:10.5px;font-weight:700;letter-spacing:.04em;cursor:pointer;white-space:nowrap;transition:.18s ease} .st-tab:hover,.st-tab.active{color:var(--st-orange2)} .st-tab.active:after{content:"";position:absolute;left:0;right:0;bottom:-1px;height:3px;background:var(--st-orange);border-radius:99px} .st-panel{display:none} .st-panel.active{display:block} .st-grid{display:grid;grid-template-columns:minmax(0,1.26fr) minmax(360px,.74fr);gap:17px;align-items:start} .st-stack{display:flex;flex-direction:column;gap:16px} .st-right-slim{width:96%;max-width:650px} .st-card{background:var(--st-card);border:1px solid #111827;border-radius:var(--st-radius);box-shadow:var(--st-shadow);overflow:hidden;transition:background .18s ease,border-color .18s ease,box-shadow .18s ease,transform .18s ease} .st-card:hover{background:rgba(17,24,39,.10);border-color:#111827;box-shadow:0 18px 42px rgba(15,23,42,.11);transform:none} .st-body{padding:15px 17px} .st-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:13px} .st-card-title{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:14.5px;font-weight:600;letter-spacing:.022em;text-transform:none;color:#111827;line-height:1.35} .st-card-desc{margin:4px 0 0;color:#7b7b7b;font-size:10.5px;font-weight:400}
.st-btn{appearance:none;border:1px solid var(--st-orange);background:var(--st-orange);color:#000;border-radius:10px;height:42px;min-width:132px;padding:0 17px;font-size:12px;font-weight:700;letter-spacing:.014em;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;transition:.18s ease;white-space:nowrap} .st-btn:hover,.st-btn:focus-visible{background:#111827;border-color:#111827;color:#fff;box-shadow:0 12px 24px rgba(17,24,39,.20);transform:none;outline:none}.st-btn:active,.st-btn.is-clicked{background:#111827;border-color:#111827;color:#fff;box-shadow:none;transform:none} .st-link{border:0;background:transparent;color:var(--st-orange2);font-size:10px;font-weight:650;cursor:pointer;padding:0} .st-link:hover,.st-link:focus-visible{background:var(--st-gray-hover);color:#222;text-decoration:none;outline:none}.st-link:active,.st-link.is-clicked{background:var(--st-gray-active);color:#111} .st-ico{width:18px;height:18px;color:#555;display:inline-flex;align-items:center;justify-content:center;flex:0 0 18px} .st-ico i{font-size:14px} .st-orange-ico{width:28px;height:28px;border-radius:9px;background:var(--st-orange3);color:var(--st-orange2);border:1px solid #f3dfcb;display:flex;align-items:center;justify-content:center;flex:0 0 auto} .st-orange-ico i{font-size:12.5px} .st-badge{display:inline-flex;align-items:center;gap:5px;border-radius:999px;padding:4px 8px;font-size:8.5px;font-weight:650;line-height:1} .st-badge.green{background:var(--st-green-bg);border:1px solid #d5ecdd;color:var(--st-green)} .st-badge.orange{background:#fff6ed;border:1px solid #efd3b3;color:var(--st-orange2)} .st-profile{display:grid;grid-template-columns:minmax(0,1fr) minmax(285px,.8fr);gap:16px} .st-profile-left{display:flex;align-items:center;gap:18px} .st-avatar-wrap{position:relative;flex:0 0 auto} .st-avatar{width:108px;height:108px;border-radius:50%;object-fit:cover;border:4px solid #fff;outline:3px solid var(--st-orange);box-shadow:0 18px 34px rgba(255,122,0,.22);background:radial-gradient(circle at 32% 25%,#ff9a37,#ff5a00 54%,#e04800)} .st-camera{position:absolute;right:-2px;bottom:5px;width:36px;height:36px;border-radius:50%;background:var(--st-orange);border:3px solid #fff;display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:none;cursor:pointer} .st-camera:hover,.st-camera:focus-visible{background:#111827;color:#fff;border-color:#fff;outline:none}.st-camera:active,.st-camera.is-clicked{background:#111827;color:#fff} .st-name-row{display:flex;align-items:center;gap:8px;flex-wrap:wrap} .st-name{margin:0;font-size:15px;font-weight:750} .st-info{margin-top:6px;color:#737373;font-size:11px;font-weight:400} .st-info strong{color:#333;font-weight:600} .st-copy{border:0;background:transparent;color:#888;margin-left:5px;padding:0;cursor:pointer} .st-copy:hover{color:var(--st-orange2)} .st-profile-right{border-left:1px solid var(--st-line);padding-left:17px;display:flex;flex-direction:column;justify-content:center;gap:14px} .st-detail{display:flex;justify-content:space-between;gap:12px;align-items:flex-start} .st-detail-left{display:flex;gap:10px} .st-label{margin:0;color:#858585;font-size:10.5px;font-weight:500} .st-value{margin:2px 0 0;color:#333;font-size:11px;font-weight:600} .st-address-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px} .st-box{position:relative;background:#fff;border:1px solid var(--st-line);border-radius:13px;padding:13px;min-height:105px;transition:.18s ease}
.st-box:hover{border-color:#e2e2e2;box-shadow:none} .st-box-title{margin:7px 0 0;font-size:11px;font-weight:700} .st-box-text{margin:7px 0 0;color:#696969;font-size:10px;line-height:1.48;font-weight:400} .st-kebab{position:absolute;right:9px;top:9px;border:0;background:transparent;color:#8b8b8b;cursor:pointer;width:22px;height:22px} .st-kebab:hover,.st-kebab:focus-visible{background:var(--st-gray-hover);border-radius:8px;color:#222;outline:none}.st-kebab:active,.st-kebab.is-clicked{background:var(--st-gray-active);color:#111;border-radius:8px} .st-add-box{border:1px dashed #ded9d3;background:#fff;border-radius:13px;min-height:105px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:9px;font-size:10.5px;font-weight:650;color:#222;cursor:pointer;transition:.18s ease} .st-add-box:hover,.st-add-box:focus-visible{border-color:var(--st-gray-dark);background:var(--st-gray-hover);color:#222;outline:none;transform:none}.st-add-box:active,.st-add-box.is-clicked{background:var(--st-gray-active);border-color:#c8c8c8;color:#111;transform:none} .st-add-circle{width:28px;height:28px;border-radius:50%;border:1px solid #ded9d3;background:#fff;display:flex;align-items:center;justify-content:center;color:#222} .st-add-box:hover .st-add-circle,.st-add-box:focus-visible .st-add-circle{border-color:var(--st-gray-dark);color:#222;background:#fff} .st-two{display:grid;grid-template-columns:minmax(0,.98fr) minmax(0,1.02fr);gap:16px} .st-list{display:flex;flex-direction:column;gap:9px} .st-pay-item{border:1px solid var(--st-line);background:#fff;border-radius:12px;min-height:52px;padding:9px 10px;display:flex;align-items:center;justify-content:space-between;gap:9px;transition:.18s ease;min-width:0} .st-pay-item:hover{border-color:var(--st-gray-dark);background:var(--st-gray-hover)} .st-pay-left{display:flex;align-items:center;gap:9px;min-width:0;overflow:hidden} .st-card-logo{width:43px;height:29px;border:1px solid var(--st-line);border-radius:7px;background:#fff;display:flex;align-items:center;justify-content:center;flex:0 0 43px} .st-card-logo.visa{background:#2157f3;border-color:#2157f3;color:#fff} .st-card-logo.master i:first-child{color:#e6483f;margin-right:-7px} .st-card-logo.master i:last-child{color:#f4a51c} .st-card-logo i{font-size:24px} .st-pay-text{min-width:0;overflow:hidden} .st-pay-title{margin:0;color:#222;font-size:10.5px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis} .st-pay-sub{margin:3px 0 0;color:#858585;font-size:9.4px;font-weight:400;white-space:nowrap;overflow:hidden;text-overflow:ellipsis} .st-mini{border-radius:999px;border:1px solid #d6efdf;background:var(--st-green-bg);color:var(--st-green);padding:3px 7px;font-size:8px;font-weight:650;white-space:nowrap;flex:0 0 auto} .st-mini.orange{border-color:#f0d4b4;background:#fff7ef;color:var(--st-orange2)} .st-pay-bottom{display:grid;grid-template-columns:minmax(0,1fr) 118px;gap:9px} .st-add-payment{border:1px dashed #ded9d3;background:#fff;border-radius:12px;min-height:63px;padding:8px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;color:#202020;font-size:9.2px;font-weight:650;line-height:1.2;cursor:pointer;transition:.18s ease;text-align:center;white-space:normal}
.st-add-payment:hover,.st-add-payment:focus-visible{border-color:var(--st-gray-dark);background:var(--st-gray-hover);color:#222;outline:none;transform:none}.st-add-payment:active,.st-add-payment.is-clicked{background:var(--st-gray-active);border-color:#c8c8c8;color:#111;transform:none} .st-notif-item{display:flex;align-items:center;justify-content:space-between;gap:11px;padding:4.5px 0} .st-notif-left{display:flex;gap:9px;min-width:0} .st-notif-title{margin:0;color:#222;font-size:10.5px;font-weight:700} .st-notif-sub{margin:3px 0 0;color:#858585;font-size:9.2px;font-weight:400;line-height:1.25} .st-comm-item{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:7px 0;border-bottom:1px solid #f0f1f3;transition:.18s} .st-comm-item:last-child{border-bottom:0}.st-comm-item:hover{background:rgba(17,24,39,.10);margin-left:-8px;margin-right:-8px;padding-left:8px;padding-right:8px;border-radius:10px} .st-comm-left{display:flex;align-items:flex-start;gap:10px;min-width:0}.st-comm-title{margin:0;color:#111827;font-family:'Poppins',system-ui,sans-serif;font-size:11px;font-weight:600;letter-spacing:.018em}.st-comm-sub{margin:3px 0 0;color:#858585;font-size:9.7px;font-weight:400;line-height:1.35} .st-switch{position:relative;width:36px;height:20px;flex:0 0 auto} .st-switch input{display:none} .st-slider{position:absolute;inset:0;border-radius:99px;background:#ddd;cursor:pointer;transition:.18s} .st-slider:before{content:"";position:absolute;width:15px;height:15px;border-radius:50%;left:3px;top:2.5px;background:#fff;box-shadow:0 2px 5px rgba(0,0,0,.16);transition:.18s} .st-switch input:checked+.st-slider{background:var(--st-green)} .st-switch input:checked+.st-slider:before{transform:translateX(15px)} .st-manage{margin-top:9px;width:100%;border:0;background:transparent;text-align:left;color:#222;font-size:9.5px;font-weight:650;cursor:pointer} .st-manage:hover{color:var(--st-orange2)} .st-quick-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:9px} .st-quick{border:1px solid var(--st-line);background:#fff;border-radius:11px;padding:9px 9px;display:flex;align-items:center;justify-content:space-between;gap:8px;text-align:left;min-height:59px;cursor:pointer;transition:.18s ease;min-width:0} .st-quick:hover,.st-quick:focus-visible{background:var(--st-gray-hover);border-color:var(--st-gray-dark);box-shadow:none;transform:none;outline:none}.st-quick:active,.st-quick.is-clicked{background:var(--st-gray-active);border-color:#c8c8c8;color:#111;box-shadow:none;transform:none} .st-quick-left{display:flex;align-items:flex-start;gap:8px;min-width:0} .st-quick-title{margin:0;color:#222;font-size:10px;font-weight:700;line-height:1.15} .st-quick-sub{margin:3px 0 0;color:#898989;font-size:8.5px;font-weight:400;line-height:1.25} .st-chev{color:#777;font-size:12px;flex:0 0 auto} .st-quick:hover .st-chev,.st-quick:hover .st-orange-ico,.st-quick:focus-visible .st-chev,.st-quick:focus-visible .st-orange-ico{color:#222} .st-pref-row,.st-activity-row{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:11px 0;border-bottom:1px solid #f1f1f1} .st-pref-row:last-child,.st-activity-row:last-child{border-bottom:0} .st-pref-left,.st-activity-left{display:flex;align-items:center;gap:10px} .st-pref-label,.st-act-label{font-size:10.5px;font-weight:650;color:#222} .st-select{border:0;background:transparent;color:#5f5f5f;font-size:10.3px;font-weight:400;outline:none;min-width:150px;text-align:right;cursor:pointer}
.st-act-val{text-align:right;color:#626262;font-size:10.4px;font-weight:400} .st-privacy-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:11px} .st-privacy{border:1px solid var(--st-line);border-radius:13px;background:#fff;padding:12px;display:flex;align-items:center;justify-content:space-between;gap:9px;text-align:left;cursor:pointer;transition:.18s ease} .st-privacy:hover,.st-privacy:focus-visible{background:var(--st-gray-hover);border-color:var(--st-gray-dark);transform:none;outline:none}.st-privacy:active,.st-privacy.is-clicked{background:var(--st-gray-active);border-color:#c8c8c8;transform:none} .st-privacy-left{display:flex;align-items:flex-start;gap:10px} .st-privacy-title{margin:0;font-size:10.5px;font-weight:700;color:#222} .st-privacy-sub{margin:3px 0 0;font-size:8.8px;font-weight:400;color:#858585} .st-settings-grid{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:18px;align-items:start} .st-setting-main,.st-setting-side{display:flex;flex-direction:column;gap:16px} .st-sec-row{display:grid;grid-template-columns:52px minmax(0,1fr) auto;align-items:center;gap:16px;padding:17px 18px;border-bottom:1px solid #e8ebf0;background:#fff;transition:.18s ease} .st-sec-row:last-child{border-bottom:0} .st-sec-row:hover,.st-privacy-panel-row:hover,.st-setting-action:hover{background:rgba(17,24,39,.10)} .st-sec-row .st-orange-ico{width:40px;height:40px;border-radius:14px} .st-sec-title{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:13px;font-weight:600;color:#111827} .st-sec-sub{margin:4px 0 0;font-size:10.5px;color:#6b7280;font-weight:400;line-height:1.35} .st-outline-btn{appearance:none;border:1px solid var(--st-orange);background:#fff;color:var(--st-orange);border-radius:10px;height:38px;min-width:128px;padding:0 15px;font-family:'Poppins',system-ui,sans-serif;font-size:11px;font-weight:600;cursor:pointer;transition:.18s ease} .st-outline-btn:hover,.st-outline-btn:focus-visible{background:#111827;border-color:#111827;color:#fff;outline:none} .st-score-ring{width:142px;height:142px;margin:10px auto 14px;border-radius:50%;background:conic-gradient(var(--st-orange) 0 331deg,#e5e7eb 331deg 360deg);display:grid;place-items:center} .st-score-inner{width:106px;height:106px;border-radius:50%;background:#fff;display:grid;place-items:center;text-align:center} .st-score-inner strong{font-family:'Poppins',system-ui,sans-serif;font-size:30px;line-height:1;color:#111827} .st-score-inner span{font-size:11px;font-weight:700;color:var(--st-green)} .st-check-line{display:flex;align-items:center;gap:10px;font-size:11px;color:#334155;padding:6px 0} .st-check-line i{color:var(--st-green)} .st-side-list{display:flex;flex-direction:column;gap:9px} .st-side-row{display:flex;align-items:center;justify-content:space-between;gap:12px;border:1px solid #e5e7eb;border-radius:10px;padding:10px 12px;background:#fff} .st-side-row:hover{background:rgba(17,24,39,.08)} .st-table-lite{border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;margin-top:12px} .st-table-lite-row{display:grid;grid-template-columns:minmax(0,1.2fr) minmax(0,.9fr) minmax(0,1fr);gap:12px;align-items:center;padding:10px 12px;border-bottom:1px solid #edf0f4;font-size:10.5px;color:#475569} .st-table-lite-row:last-child{border-bottom:0} .st-table-lite-row strong{color:#111827;font-weight:650} .st-tip-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-top:13px}
.st-tip{display:flex;gap:10px;align-items:flex-start;border:1px solid #e5e7eb;border-radius:12px;padding:11px;background:#fff} .st-privacy-panel-row{display:grid;grid-template-columns:220px minmax(0,1fr);gap:18px;align-items:center;padding:17px;border-bottom:1px solid #e8ebf0;background:#fff;transition:.18s ease} .st-privacy-panel-row:last-child{border-bottom:0} .st-privacy-control{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:8px 0} .st-privacy-control select{height:38px;border:1px solid #dfe3ea;border-radius:10px;background:#fff;padding:0 12px;font-size:11px;font-weight:650;min-width:140px} .st-status-pill{border-radius:999px;padding:5px 9px;font-size:9px;font-weight:700;background:#edf8f1;color:var(--st-green);white-space:nowrap} .st-status-pill.gray{background:#f2f4f7;color:#64748b} .st-wide-actions{display:grid;grid-template-columns:1fr 1fr;gap:14px} .st-summary-strip{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px;border:1px solid #e5e7eb;border-radius:12px;padding:12px;background:#fff} .st-summary-item{display:flex;align-items:center;gap:9px;border-right:1px solid #eef1f5;padding-right:8px} .st-summary-item:last-child{border-right:0} .st-setting-action{display:flex;align-items:center;justify-content:space-between;gap:12px;border-bottom:1px solid #eef1f5;padding:12px 0;cursor:pointer;transition:.18s ease} .st-setting-action:last-child{border-bottom:0} .st-form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:13px} .st-field{display:flex;flex-direction:column;gap:6px} .st-field label{font-size:9.5px;text-transform:uppercase;letter-spacing:.05em;color:#777;font-weight:650} .st-input,.st-textarea{width:100%;border:1px solid var(--st-line2);background:#fff;border-radius:11px;padding:10px 11px;color:#222;font-size:11.5px;font-weight:400;outline:none} .st-input:focus,.st-textarea:focus{border-color:var(--st-gray-dark);box-shadow:0 0 0 3px rgba(0,0,0,.06)} .st-textarea{min-height:100px;resize:vertical} .st-actions{display:flex;justify-content:flex-end;gap:9px;margin-top:16px} .st-modal{position:fixed;inset:0;z-index:9999;display:none} .st-modal.active{display:block} .st-modal-bg{position:absolute;inset:0;background:rgba(0,0,0,.33);backdrop-filter:blur(4px)} .st-modal-shell{position:relative;min-height:100vh;padding:20px;display:flex;align-items:center;justify-content:center} .st-modal-card{width:100%;max-width:545px;background:#fff;border-radius:18px;border:1px solid var(--st-line);box-shadow:0 20px 60px rgba(0,0,0,.16);overflow:hidden} .st-modal-head{padding:15px 17px;border-bottom:1px solid #f1f1f1;display:flex;align-items:flex-start;justify-content:space-between;gap:10px} .st-modal-title{margin:0;font-size:12px;font-weight:750;text-transform:uppercase;letter-spacing:.06em} .st-modal-desc{margin:4px 0 0;color:#868686;font-size:10.5px;font-weight:400} .st-close{width:33px;height:33px;border-radius:50%;border:1px solid var(--st-line);background:#fff;color:#666;cursor:pointer;font-size:18px} .st-close:hover,.st-close:focus-visible{background:var(--st-gray-hover);color:#222;border-color:var(--st-gray-dark);outline:none}.st-close:active,.st-close.is-clicked{background:var(--st-gray-active);color:#111} .st-modal-body{padding:17px}
.st-toast{position:fixed;left:50%;top:110px;background:#242424;color:#fff;border-radius:12px;padding:12px 15px;font-size:12px;font-weight:700;box-shadow:0 18px 50px rgba(17,24,39,.24);opacity:0;transform:translate(-50%,-12px);pointer-events:none;transition:.2s;z-index:10000} .st-toast.show{opacity:1;transform:translate(-50%,0)} .st-footer{margin:16px 0 0;text-align:center;color:#bfbfbf;font-size:8.5px;font-weight:650;letter-spacing:.16em;text-transform:uppercase} .st-page button,.st-page select,.st-page input,.st-page textarea{font-family:inherit} .st-page button,.st-page .st-select{transform:none!important} .st-tab,.st-btn,.st-link,.st-camera,.st-kebab,.st-add-box,.st-add-payment,.st-quick,.st-privacy,.st-close,.st-select{transition:background-color .16s ease,border-color .16s ease,color .16s ease,box-shadow .16s ease} .st-tab:hover,.st-tab:focus-visible{background:var(--st-gray-hover);color:#222;outline:none} .st-tab:active,.st-tab.is-clicked{background:var(--st-gray-active);color:#111;transform:none} .st-tab.active:hover{color:var(--st-orange2)} .st-link{border-radius:8px;min-height:24px;padding:0 7px;display:inline-flex;align-items:center;justify-content:center} .st-pref-row{border-radius:10px;padding-left:8px;padding-right:8px;transition:background-color .16s ease,border-color .16s ease} .st-pref-row:hover,.st-pref-row:focus-within,.st-pref-row.is-clicked{background:var(--st-gray-hover)} .st-pref-row:active{background:var(--st-gray-active)} .st-right-slim .st-body{padding:13px 15px} .st-right-slim .st-head{margin-bottom:9px} .st-right-slim .st-card-desc{margin-top:2px;line-height:1.35} .st-right-slim .st-comm-item{padding:5.5px 0} .st-right-slim .st-comm-left{gap:8px} .st-right-slim .st-comm-sub{margin-top:2px;font-size:9.2px;line-height:1.25} .st-right-slim .st-pref-row,.st-right-slim .st-activity-row{padding-top:7px;padding-bottom:7px} .st-right-slim .st-orange-ico{width:27px;height:27px} .st-select{border-radius:8px;padding:5px 7px} .st-select:hover,.st-select:focus{background:var(--st-gray-hover);color:#222} .st-orange-ico{transition:background-color .16s ease,border-color .16s ease,color .16s ease} .st-quick:hover .st-orange-ico,.st-privacy:hover .st-orange-ico,.st-pref-row:hover .st-orange-ico{background:#fff;border-color:var(--st-gray-dark);color:#222} .st-clickable-cover{background:var(--st-gray-active)!important;border-color:#c8c8c8!important;color:#111!important;transform:none!important;box-shadow:none!important} @media(max-width:1320px){.st-grid{grid-template-columns:minmax(0,1.15fr) minmax(350px,.85fr)}.st-right-slim{width:100%}} @media(max-width:1260px){.st-grid,.st-profile,.st-two,.st-settings-grid{grid-template-columns:1fr}.st-profile-right{border-left:0;border-top:1px solid var(--st-line);padding-left:0;padding-top:14px}.st-quick-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.st-right-slim{max-width:none}} @media(max-width:860px){.st-page{padding:16px 12px 28px}.st-address-grid,.st-privacy-grid,.st-form-grid,.st-quick-grid,.st-tip-grid,.st-summary-strip,.st-wide-actions{grid-template-columns:1fr}.st-profile-left{align-items:flex-start;flex-direction:column}.st-select{min-width:120px}.st-tabs{gap:20px}.st-pay-bottom{grid-template-columns:1fr}.st-sec-row,.st-privacy-panel-row{grid-template-columns:1fr}.st-outline-btn,.st-btn{width:100%}} .st-top{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin:0 0 16px}
.st-title-wrap{display:flex;align-items:flex-start;gap:10px}.st-title-wrap:before{content:'';width:18px;height:4px;margin-top:8px;border-radius:999px;background:var(--st-orange);flex:0 0 auto} .st-date{height:42px;min-width:178px;padding:0 15px;border:1px solid #111827;border-radius:8px;background:#fff;color:#111827;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-size:12px;font-weight:700;line-height:1;white-space:nowrap} .st-date i{font-size:15px;color:#111827}.st-wrap{max-width:1490px!important}.st-grid,.st-settings-grid{align-items:stretch} @media(max-width:860px){.st-top{display:grid}.st-date{width:100%}} /* Settings UI alignment update */ .st-page{padding:0 38px 38px} .st-wrap{max-width:1480px!important} .st-card,.st-main-box{border:1px solid #111827;border-radius:14px;background:#fff;box-shadow:none} .st-card:hover,.st-main-box:hover{background:rgba(17,24,39,.09);box-shadow:none;border-color:#111827} .st-plain{border:0!important;background:transparent!important;box-shadow:none!important;overflow:visible!important} .st-plain:hover{background:transparent!important;box-shadow:none!important} .st-plain .st-body{padding:0} .st-section-line{height:1px;background:#111827;margin:17px 0} .st-soft-line{height:1px;background:#e5e7eb;margin:10px 0} .st-no-box-list{display:flex;flex-direction:column;gap:9px} .st-no-box-item{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px solid #e8ebf0} .st-no-box-item:last-child{border-bottom:0} .st-stat-row{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px} .st-stat-tile{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #edf0f4} .st-action-list{display:flex;flex-direction:column;gap:0} .st-channel-row{display:grid;grid-template-columns:minmax(0,1.2fr) 84px 84px 84px 34px;gap:10px;align-items:center;padding:10px 0;border-bottom:1px solid #e8ebf0} .st-channel-row:last-child{border-bottom:0} .st-channel-head{font-size:9px;text-transform:uppercase;color:#64748b;font-weight:700;text-align:center} .st-inline-pill{display:inline-flex;align-items:center;gap:6px;border-radius:999px;padding:3px 7px;background:#edf8f1;color:var(--st-green);font-size:8px;font-weight:700} .st-setting-side .st-plain .st-body{padding:0 0 10px} .st-setting-side .st-plain{padding:0} #panel-overview .st-stack>.st-card:nth-of-type(1) .st-body{padding-bottom:17px} #panel-overview .st-two{border:1px solid #111827;border-radius:14px;padding:15px;background:#fff} #panel-overview .st-two>.st-card{border:0!important;background:transparent!important;box-shadow:none!important} #panel-overview .st-two>.st-card .st-body{padding:0} #panel-overview>.st-grid{grid-template-columns:minmax(0,1.15fr) minmax(350px,.85fr)!important;gap:17px!important;align-items:start!important} #panel-overview>.st-grid>.st-stack{min-width:0;width:100%;display:flex!important;flex-direction:column!important;gap:16px!important} #panel-overview .overview-profile-box, #panel-overview .overview-payment-box{border:1px solid #111827!important;border-radius:14px!important;background:#fff!important;box-shadow:none!important;overflow:hidden!important} #panel-overview .overview-profile-box:hover, #panel-overview .overview-payment-box:hover{background:#fff!important} #panel-overview .overview-profile-box .st-section-line{margin-left:-17px;margin-right:-17px}
#panel-overview .overview-payment-box{display:grid!important;grid-template-columns:minmax(0,.96fr) minmax(0,1.04fr)!important;gap:0!important;padding:15px!important} #panel-overview .overview-payment-box>.st-card{border:0!important;background:transparent!important;box-shadow:none!important;border-radius:0!important} #panel-overview .overview-payment-box>.st-card:first-child{border-right:1px solid #e5e7eb!important;padding-right:15px} #panel-overview .overview-payment-box>.st-card:last-child{padding-left:15px} #panel-overview .overview-payment-box>.st-card .st-body{padding:0!important} #panel-overview .overview-plain-panel{border:0!important;background:transparent!important;box-shadow:none!important;border-radius:0!important;overflow:visible!important} #panel-overview .overview-plain-panel:hover{background:transparent!important} #panel-overview .overview-plain-panel>.st-body{padding:0!important} #panel-overview .overview-quick-panel .st-head{margin-bottom:10px} #panel-overview .overview-quick-panel .st-quick-grid{grid-template-columns:repeat(2,minmax(0,1fr))!important;gap:8px!important} #panel-overview .overview-quick-panel .st-quick, #panel-overview .overview-privacy-panel .st-privacy{border:0!important;border-bottom:1px solid #e8ebf0!important;border-radius:0!important;background:transparent!important;min-height:52px!important;padding:8px 0!important} #panel-overview .overview-quick-panel .st-quick:hover, #panel-overview .overview-privacy-panel .st-privacy:hover{background:rgba(17,24,39,.08)!important;border-radius:10px!important;padding-left:8px!important;padding-right:8px!important} #panel-overview .overview-comm-panel{max-width:none!important;width:100%!important} #panel-overview .overview-activity-panel{max-width:none!important;width:100%!important} #panel-overview .overview-prefs-panel{max-width:none!important;width:100%!important} #panel-overview .overview-prefs-panel .st-pref-row, #panel-overview .overview-activity-panel .st-activity-row{border-bottom:1px solid #e8ebf0!important;border-radius:0!important;background:transparent!important;padding-left:0!important;padding-right:0!important} #panel-profile .st-profile-grid{grid-template-columns:minmax(0,1fr) 340px!important;gap:18px!important} #panel-profile .st-profile-side .st-card{border:0!important;background:transparent!important;box-shadow:none!important;border-radius:0!important} #panel-profile .st-profile-side .st-card>.st-body{padding:0!important} #panel-security .st-settings-grid, #panel-notifications .st-notif-layout{grid-template-columns:minmax(0,1fr) 300px!important;gap:16px!important;align-items:start!important} #panel-security .st-setting-side, #panel-notifications .st-notif-side{gap:14px!important} #panel-profile .st-profile-grid{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:18px;align-items:start} #panel-profile .st-profile-side{display:flex;flex-direction:column;gap:16px} #panel-profile .st-card-title,#panel-security .st-card-title,#panel-notifications .st-card-title,#panel-payments .st-card-title{font-family:'Poppins',system-ui,sans-serif;font-weight:600} #panel-profile .st-card:first-child,#panel-profile .st-connected-card,#panel-security .st-setting-main>.st-card:first-child,#panel-security .st-login-tips-box,#panel-notifications .st-card:first-child,#panel-payments .st-billing-box{border-color:#111827} #panel-security .st-setting-side>.st-card{border:0!important;background:transparent!important;box-shadow:none!important}
#panel-security .st-setting-side>.st-card .st-body{padding:0} #panel-security .st-setting-side .st-side-row{border:0!important;border-bottom:1px solid #e8ebf0!important;border-radius:0!important;background:transparent!important;padding-left:0;padding-right:0} #panel-security .st-tip{border:0;border-bottom:1px solid #e8ebf0;border-radius:0;background:transparent} #panel-notifications .st-notif-layout,#panel-payments .st-pay-layout{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:18px;align-items:start} #panel-notifications .st-notif-side,#panel-payments .st-pay-side{display:flex;flex-direction:column;gap:16px} #panel-notifications .st-notif-side>.st-card,#panel-payments .st-pay-side>.st-card{border:0!important;background:transparent!important;box-shadow:none!important} #panel-notifications .st-notif-side>.st-card .st-body,#panel-payments .st-pay-side>.st-card .st-body{padding:0} .st-btn,.st-outline-btn{border:0!important;background:var(--st-orange)!important;color:#000!important;height:42px;min-width:132px} .st-btn:hover,.st-outline-btn:hover,.st-btn:focus-visible,.st-outline-btn:focus-visible{background:#111827!important;color:#fff!important} .st-switch input:checked+.st-slider{background:#16a34a!important} @media(max-width:1260px){#panel-profile .st-profile-grid,#panel-notifications .st-notif-layout,#panel-payments .st-pay-layout{grid-template-columns:1fr}.st-channel-row{grid-template-columns:minmax(0,1fr) 56px 56px 56px 24px}} @media(max-width:860px){.st-page{padding:16px 14px 30px}.st-stat-row{grid-template-columns:1fr}.st-channel-row{grid-template-columns:1fr 1fr 1fr}.st-channel-head{text-align:left}} /* Overview uses the original two-column boxed stack. */ #panel-overview>.st-grid{display:grid!important;grid-template-columns:minmax(0,1.15fr) minmax(350px,.85fr)!important;gap:17px!important;align-items:start!important} #panel-overview>.st-grid>.st-stack{display:flex!important;flex-direction:column!important;gap:16px!important} #panel-overview .overview-profile-box,#panel-overview .overview-payment-box,#panel-overview .overview-privacy-panel,#panel-overview .overview-quick-panel,#panel-overview .overview-comm-panel,#panel-overview .overview-prefs-panel,#panel-overview .overview-activity-panel{grid-column:auto!important;grid-row:auto!important} #panel-overview .overview-profile-box{border:1px solid #111827!important;border-radius:14px!important;background:#fff!important} #panel-overview .overview-payment-box{border:1px solid #111827!important;border-radius:14px!important;background:#fff!important;display:grid!important;grid-template-columns:1fr 1fr!important;gap:0!important;padding:15px!important} #panel-overview .overview-payment-box>.st-card{border:0!important;background:transparent!important;box-shadow:none!important} #panel-overview .overview-payment-box>.st-card:first-child{border-right:1px solid #e5e7eb!important;padding-right:15px!important} #panel-overview .overview-payment-box>.st-card:last-child{padding-left:15px!important} #panel-overview .overview-plain-panel{border:0!important;background:transparent!important;box-shadow:none!important;overflow:visible!important} #panel-overview .overview-plain-panel>.st-body{padding:0!important} #panel-overview .overview-quick-panel .st-quick-grid{grid-template-columns:repeat(2,minmax(0,1fr))!important;gap:8px!important} #panel-overview .overview-quick-panel .st-quick,
#panel-overview .overview-privacy-panel .st-privacy{border:0!important;border-bottom:1px solid #e8ebf0!important;border-radius:0!important;background:transparent!important;padding:8px 0!important;min-height:50px!important} #panel-overview .overview-comm-panel .st-comm-item, #panel-overview .overview-prefs-panel .st-pref-row, #panel-overview .overview-activity-panel .st-activity-row{padding:8px 0!important;border-bottom:1px solid #e8ebf0!important} #panel-overview .overview-profile-box .st-address-grid{grid-template-columns:repeat(3,minmax(0,1fr))!important} #panel-overview .overview-profile-box .st-box, #panel-overview .overview-profile-box .st-add-box{min-height:104px!important} #panel-security .st-sec-row{padding:11px 14px!important;grid-template-columns:44px minmax(0,1fr) auto!important} #panel-security .st-sec-row .st-orange-ico{width:34px!important;height:34px!important;border-radius:11px!important} #panel-security .st-setting-side .st-score-ring, #panel-notifications .st-notif-side .st-score-ring{width:98px!important;height:98px!important;margin:8px auto!important} #panel-security .st-setting-side .st-score-inner, #panel-notifications .st-notif-side .st-score-inner{width:74px!important;height:74px!important} #panel-security .st-setting-side .st-score-inner strong, #panel-notifications .st-notif-side .st-score-inner strong{font-size:22px!important} #panel-security .st-setting-side .st-check-line, #panel-notifications .st-notif-side .st-no-box-item, #panel-notifications .st-notif-side .st-setting-action{padding:6px 0!important;font-size:10.5px!important} #panel-security .st-login-tips-box .st-body{padding:12px 14px!important} #panel-security .st-tip-grid{gap:8px!important} #panel-security .st-tip{padding:8px!important} #panel-notifications .st-card:first-child .st-body{padding:12px 14px!important} #panel-notifications .st-summary-strip{gap:6px!important} #panel-notifications .st-summary-item{gap:7px!important} #panel-notifications .st-channel-row{padding:7px 0!important;grid-template-columns:minmax(0,1.2fr) 58px 58px 58px 24px!important} #panel-notifications .st-channel-row .st-orange-ico{width:30px!important;height:30px!important} #panel-notifications .st-channel-row .st-sec-title{font-size:11px!important} #panel-notifications .st-channel-row .st-sec-sub{font-size:9px!important;margin-top:2px!important} .st-profile-hero{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(360px,.95fr);gap:16px;align-items:center} .st-profile-hero-main{display:flex;align-items:center;gap:15px;min-width:0} .st-profile-hero-meta{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;border-left:1px solid #e5e7eb;padding-left:16px} .st-profile-mini{display:flex;align-items:flex-start;gap:8px;min-width:0} .st-profile-mini .st-orange-ico{width:26px;height:26px;border-radius:8px} .st-profile-mini strong{display:block;font-size:10.5px;font-weight:700;color:#111827} .st-profile-mini span{display:block;font-size:9.5px;color:#6b7280;margin-top:2px} .st-profile-block-title{display:flex;align-items:center;gap:8px;margin:14px 0 10px} .st-profile-block-title .st-orange-ico{width:24px;height:24px} #panel-profile .st-form-grid{gap:10px!important} #panel-profile .st-field label{font-size:8.8px!important} #panel-profile .st-input{height:38px!important;padding:8px 10px!important;font-size:10.5px!important} #panel-profile .st-summary-strip .st-summary-item{padding:8px 10px;border:1px solid #e5e7eb;border-radius:10px}
@media(max-width:1260px){.st-profile-hero{grid-template-columns:1fr}.st-profile-hero-meta{border-left:0;border-top:1px solid #e5e7eb;padding-left:0;padding-top:12px}} #panel-overview .overview-profile-box .st-body{padding:13px 15px!important} #panel-overview .overview-profile-box .st-address-grid{gap:9px!important} #panel-overview .overview-profile-box .st-box, #panel-overview .overview-profile-box .st-add-box{min-height:86px!important;padding:10px!important;border-radius:11px!important} #panel-overview .overview-profile-box .st-box-text{font-size:9px!important;line-height:1.35!important;margin-top:5px!important} #panel-overview .overview-profile-box .st-box-title{font-size:10px!important;margin-top:5px!important} #panel-overview .overview-profile-box .st-add-circle{width:24px!important;height:24px!important} #panel-overview .overview-profile-box .st-section-line{margin-top:12px!important;margin-bottom:12px!important} #panel-overview .overview-payment-box{padding:12px!important} #panel-overview .overview-payment-box .st-list{gap:7px!important} #panel-overview .overview-payment-box .st-pay-item{min-height:44px!important;padding:7px 9px!important} #panel-overview .overview-payment-box .st-card-logo{width:38px!important;height:25px!important} #panel-overview .overview-payment-box .st-notif-item{padding:3px 0!important} #panel-profile .st-profile-side{gap:10px!important} #panel-profile .st-profile-side .st-head{margin-bottom:6px!important} #panel-profile .st-profile-side .st-no-box-list{gap:3px!important} #panel-profile .st-profile-side .st-no-box-item{padding:5px 0!important} #panel-profile .st-profile-side .st-btn{height:36px!important} #panel-profile .st-profile-side .st-score-ring{width:88px!important;height:88px!important;margin:6px auto!important} #panel-profile .st-profile-side .st-score-inner{width:66px!important;height:66px!important} #panel-profile .st-profile-side .st-score-inner strong{font-size:20px!important} #panel-security .st-setting-side{gap:8px!important} #panel-security .st-setting-side .st-card-title, #panel-notifications .st-notif-side .st-card-title{font-size:13px!important} #panel-security .st-setting-side .st-card-desc, #panel-notifications .st-notif-side .st-card-desc{font-size:9.5px!important;line-height:1.25!important} #panel-security .st-setting-side .st-side-list, #panel-notifications .st-notif-side .st-no-box-list{gap:3px!important;margin-top:7px!important} #panel-security .st-setting-side .st-side-row, #panel-security .st-setting-side .st-setting-action, #panel-notifications .st-notif-side .st-setting-action, #panel-notifications .st-notif-side .st-no-box-item{padding:5px 0!important} #panel-security .st-setting-side .st-btn, #panel-notifications .st-notif-side .st-btn{height:36px!important;margin-top:8px!important} #panel-notifications .st-notif-side{gap:8px!important} #panel-notifications .st-card:first-child .st-body{padding:10px 12px!important} #panel-notifications .st-channel-row{padding:5px 0!important} #panel-notifications .st-summary-strip{margin-bottom:8px!important}
@media(min-width:981px){#panel-overview>.st-grid{display:grid!important;grid-template-columns:minmax(0,1.15fr) minmax(350px,.85fr)!important;gap:17px!important;align-items:start!important}#panel-overview>.st-grid>.st-stack{display:flex!important;flex-direction:column!important;gap:16px!important}#panel-overview .overview-profile-box,#panel-overview .overview-payment-box,#panel-overview .overview-privacy-panel,#panel-overview .overview-quick-panel,#panel-overview .overview-comm-panel,#panel-overview .overview-prefs-panel,#panel-overview .overview-activity-panel{grid-column:auto!important;grid-row:auto!important}} @media(max-width:980px){#panel-overview>.st-grid{grid-template-columns:1fr!important}#panel-overview .overview-payment-box{grid-template-columns:1fr!important}} #panel-overview .overview-privacy-panel, #panel-overview .overview-quick-panel, #panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel{border:1px solid #111827!important;border-radius:14px!important;background:#fff!important;box-shadow:none!important;overflow:hidden!important} #panel-overview .overview-privacy-panel>.st-body, #panel-overview .overview-quick-panel>.st-body, #panel-overview .overview-comm-panel>.st-body, #panel-overview .overview-prefs-panel>.st-body, #panel-overview .overview-activity-panel>.st-body{padding:13px 15px!important} #panel-overview .overview-quick-panel .st-quick, #panel-overview .overview-privacy-panel .st-privacy{border:1px solid #111827!important;border-radius:11px!important;background:#fff!important;padding:9px!important;min-height:56px!important} #panel-overview .overview-payment-box{padding:0!important;gap:16px!important} #panel-overview .overview-payment-box>.st-card .st-body{padding:13px 15px!important} #panel-profile .st-profile-grid, #panel-security .st-settings-grid, #panel-notifications .st-notif-layout{grid-template-columns:minmax(0,1fr) 300px!important;gap:16px!important;align-items:start!important} #panel-profile .st-profile-side, #panel-security .st-setting-side, #panel-notifications .st-notif-side{gap:8px!important} #panel-profile .st-profile-side .st-card-title, #panel-security .st-setting-side .st-card-title, #panel-notifications .st-notif-side .st-card-title{font-size:13px!important} #panel-profile .st-profile-side .st-card-desc, #panel-security .st-setting-side .st-card-desc, #panel-notifications .st-notif-side .st-card-desc{font-size:9.5px!important;line-height:1.25!important} .st-page{padding:0 0 34px!important} .st-wrap{max-width:1490px!important;margin:0 auto!important;width:100%!important} .st-top{margin-top:0!important} #panel-overview>.st-grid{grid-template-columns:minmax(0,1.2fr) minmax(360px,.8fr)!important} #panel-overview>.st-grid{display:grid!important;grid-template-columns:minmax(0,1.15fr) minmax(350px,.85fr)!important;gap:17px!important;align-items:start!important} #panel-overview>.st-grid>.st-stack{display:flex!important;flex-direction:column!important;gap:16px!important;min-width:0!important;width:100%!important} #panel-overview .overview-profile-box, #panel-overview .overview-payment-box, #panel-overview .overview-privacy-panel, #panel-overview .overview-quick-panel, #panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel{grid-column:auto!important;grid-row:auto!important} @media(max-width:760px){#panel-overview>.st-grid{grid-template-columns:1fr!important}}
/* Settings tab grouping: Notifications style applied to all remaining tabs */ .st-section-layout{display:grid;grid-template-columns:minmax(0,1fr) 300px;gap:16px;align-items:start} .st-section-main,.st-section-side{display:flex;flex-direction:column;gap:12px;min-width:0} .st-main-group{border:1px solid #111827!important;border-radius:14px!important;background:#fff!important;box-shadow:none!important;overflow:hidden!important} .st-main-group:hover{background:#fff!important;box-shadow:none!important;border-color:#111827!important} .st-main-group>.st-body{padding:13px 15px!important} .st-plain-panel{border:0!important;background:transparent!important;box-shadow:none!important;border-radius:0!important;overflow:visible!important} .st-plain-panel:hover{background:transparent!important;box-shadow:none!important} .st-plain-panel>.st-body{padding:0!important} .st-line-row{display:grid;grid-template-columns:38px minmax(0,1fr) auto;gap:11px;align-items:center;padding:9px 0;border-bottom:1px solid #e8ebf0;background:transparent} .st-line-row:last-child{border-bottom:0} .st-line-row:hover{background:rgba(17,24,39,.08);margin-left:-8px;margin-right:-8px;padding-left:8px;padding-right:8px;border-radius:10px} .st-row-actions{display:flex;align-items:center;gap:7px;justify-content:flex-end;flex-wrap:wrap} .st-mini-tabs{display:flex;align-items:center;gap:26px;border-bottom:1px solid #e8ebf0;margin:2px 0 8px;padding-bottom:8px} .st-mini-tabs span{font-size:10px;font-weight:700;color:#64748b} .st-mini-tabs .active{color:#111827} .st-map-mini{height:72px;border-radius:10px;background:linear-gradient(135deg,#eaf8ef,#eef4ff);display:flex;align-items:center;justify-content:center;color:var(--st-green);font-size:24px;min-width:190px} .st-tip-inline{display:flex;align-items:center;gap:9px;border-radius:10px;background:#f3f8ff;color:#2563eb;font-size:10.5px;padding:9px 10px;margin-top:9px} .st-right-metric{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px solid #e8ebf0;font-size:11px} .st-right-metric:last-child{border-bottom:0} .st-section-layout .st-section-side .st-score-ring{width:98px!important;height:98px!important;margin:8px auto!important} .st-section-layout .st-section-side .st-score-inner{width:74px!important;height:74px!important} .st-section-layout .st-section-side .st-score-inner strong{font-size:22px!important} .st-section-layout .st-section-side .st-card-title{font-size:13px!important} .st-section-layout .st-section-side .st-card-desc{font-size:9.5px!important;line-height:1.25!important} #panel-payments .st-billing-box{border:1px solid #111827!important;border-radius:14px!important;background:#fff!important} #panel-payments .st-pay-side>.st-card{border:0!important;background:transparent!important;box-shadow:none!important} #panel-payments .st-pay-side>.st-card>.st-body{padding:0!important} #panel-addresses .st-address-grid{grid-template-columns:1fr!important;gap:0!important} #panel-addresses .st-address-row{grid-template-columns:38px minmax(0,1fr) minmax(190px,auto)} #panel-preferences .st-section-main .st-plain-panel, #panel-privacy .st-section-main .st-plain-panel{border:0!important;background:transparent!important} #panel-privacy .st-privacy-panel-row{padding:12px 0!important;grid-template-columns:210px minmax(0,1fr)!important} #panel-privacy .st-privacy-panel-row:first-child{padding-top:0!important} #panel-privacy .st-privacy-panel-row:last-child{padding-bottom:0!important}
@media(max-width:1260px){.st-section-layout,#panel-payments .st-pay-layout{grid-template-columns:1fr!important}.st-map-mini{min-width:0}} @media(max-width:860px){.st-section-layout{gap:14px}.st-mini-tabs{gap:14px;flex-wrap:wrap}.st-line-row,#panel-addresses .st-address-row{grid-template-columns:1fr}.st-row-actions{justify-content:flex-start}.st-map-mini{width:100%}#panel-privacy .st-privacy-panel-row{grid-template-columns:1fr!important}} /* Keep Overview bottom panels in the right column, matching the original Settings UI */ @media(min-width:1261px){ #panel-overview>.st-grid{display:grid!important;grid-template-columns:minmax(0,1fr) 540px!important;gap:18px!important;align-items:start!important} #panel-overview>.st-grid>.st-stack:first-child{grid-column:1!important;grid-row:1!important;min-width:0!important;width:100%!important} #panel-overview>.st-grid>.st-stack:nth-child(2){grid-column:2!important;grid-row:1!important;min-width:0!important;width:100%!important;max-width:540px!important;align-self:start!important} #panel-overview .overview-quick-panel, #panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel{width:100%!important;max-width:none!important} #panel-overview .overview-quick-panel .st-quick-grid{grid-template-columns:repeat(2,minmax(0,1fr))!important} } @media(max-width:1260px){ #panel-overview>.st-grid{grid-template-columns:1fr!important} #panel-overview>.st-grid>.st-stack:nth-child(2){max-width:none!important;width:100%!important} } /* ========================================================= FINAL REQUEST SYNC: Settings reference UI, buttons, boxes, icon colors, hover behavior, and consistent spacing ========================================================= */ .st-page, .st-wrap{ background:#fff!important; } .st-wrap{ max-width:1490px!important; padding:0 18px 34px!important; } .st-top{ margin:0 0 14px!important; align-items:flex-start!important; } .st-title{ font-family:'Playfair Display',Georgia,serif!important; font-size:30px!important; line-height:1.1!important; letter-spacing:-.02em!important; text-transform:uppercase!important; } .st-subtitle{ margin-top:4px!important; font-size:11px!important; color:#6b7280!important; } .st-title-wrap:before{ display:none!important; } .st-tabs{ gap:28px!important; margin-bottom:16px!important; border-bottom:1px solid #e5e7eb!important; } .st-tab{ padding:10px 0 11px!important; border-radius:0!important; font-size:10px!important; color:#111827!important; background:transparent!important; transform:none!important; } .st-tab:hover, .st-tab:focus-visible{ color:var(--st-orange)!important; background:transparent!important; transform:none!important; } .st-tab.active{ color:var(--st-orange)!important; } .st-tab.active:after{ height:2px!important; background:var(--st-orange)!important; } /* Main overview layout like the supplied Settings reference */ @media(min-width:1261px){ #panel-overview>.st-grid{ grid-template-columns:minmax(0,1.12fr) minmax(420px,.88fr)!important; gap:22px!important; align-items:start!important; } #panel-overview>.st-grid>.st-stack:nth-child(2){ max-width:none!important; width:100%!important; } } .st-stack{ gap:18px!important; } .st-body{ padding:15px 16px!important; } .st-head{ align-items:flex-start!important; margin-bottom:12px!important; } .st-card-title{ font-family:'Poppins',system-ui,sans-serif!important; font-size:13px!important; font-weight:700!important; letter-spacing:.02em!important;
text-transform:uppercase!important; color:#111827!important; } .st-card-desc{ color:#6b7280!important; font-size:9.8px!important; line-height:1.35!important; } /* Box logic: main grouped boxes have subtle/black borders, requested plain sections have no outer box */ #panel-overview .overview-profile-box, #panel-overview .overview-payment-box, #panel-overview .overview-quick-panel, #panel-profile .st-card:first-child, #panel-security .st-setting-main>.st-card:first-child, #panel-notifications .st-card:first-child, #panel-payments .st-billing-box, .st-main-group{ border:1px solid rgba(17,24,39,.55)!important; border-radius:12px!important; background:#fff!important; box-shadow:0 8px 22px rgba(15,23,42,.045)!important; overflow:hidden!important; } #panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel, #panel-overview .overview-privacy-panel, #panel-profile .st-profile-side .st-card, #panel-security .st-setting-side>.st-card, #panel-notifications .st-notif-side>.st-card, #panel-payments .st-pay-side>.st-card, .st-plain, .st-plain-panel{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; overflow:visible!important; } #panel-overview .overview-comm-panel>.st-body, #panel-overview .overview-prefs-panel>.st-body, #panel-overview .overview-activity-panel>.st-body, #panel-overview .overview-privacy-panel>.st-body, .st-plain>.st-body, .st-plain-panel>.st-body{ padding:0!important; } .st-card:hover, .st-main-group:hover, .st-plain:hover, .st-plain-panel:hover, #panel-overview .overview-profile-box:hover, #panel-overview .overview-payment-box:hover, #panel-overview .overview-quick-panel:hover, #panel-overview .overview-comm-panel:hover, #panel-overview .overview-prefs-panel:hover, #panel-overview .overview-activity-panel:hover, #panel-overview .overview-privacy-panel:hover{ background:#fff!important; border-color:inherit!important; box-shadow:0 8px 22px rgba(15,23,42,.045)!important; transform:none!important; backdrop-filter:none!important; } #panel-overview .overview-comm-panel:hover, #panel-overview .overview-prefs-panel:hover, #panel-overview .overview-activity-panel:hover, #panel-overview .overview-privacy-panel:hover, .st-plain:hover, .st-plain-panel:hover{ box-shadow:none!important; } /* Buttons: orange buttons match reference and hover black. Non-orange buttons stay white/transparent and hover black. */ .st-btn, .st-page .st-btn{ height:34px!important; min-width:112px!important; padding:0 15px!important; border:1px solid transparent!important; border-radius:999px!important; background:linear-gradient(90deg,var(--st-orange),#ffab0a)!important; color:#111827!important; font-family:'Poppins',system-ui,sans-serif!important; font-size:10.5px!important; font-weight:600!important; letter-spacing:0!important; box-shadow:none!important; transform:none!important; } .st-btn:hover, .st-btn:focus-visible, .st-btn:active, .st-btn.is-clicked, .st-btn.st-clickable-cover{ background:#111827!important; border-color:#111827!important; color:#fff!important; box-shadow:none!important; transform:none!important; outline:none!important; } .st-outline-btn, .st-page .st-outline-btn, .st-link, .st-close, .st-kebab, .st-add-box, .st-add-payment, .st-quick, .st-privacy, .st-setting-action, .st-select, .st-date{ box-shadow:none!important; transform:none!important; } .st-outline-btn, .st-page .st-outline-btn{ height:34px!important;
min-width:112px!important; padding:0 14px!important; border:1px solid #111827!important; border-radius:999px!important; background:#fff!important; color:#111827!important; font-family:'Poppins',system-ui,sans-serif!important; font-size:10.5px!important; font-weight:600!important; } .st-outline-btn:hover, .st-outline-btn:focus-visible, .st-outline-btn:active, .st-outline-btn.is-clicked{ background:#111827!important; border-color:#111827!important; color:#fff!important; outline:none!important; } .st-link{ min-height:24px!important; padding:0 8px!important; border:1px solid transparent!important; border-radius:999px!important; background:transparent!important; color:var(--st-orange)!important; font-size:9.5px!important; font-weight:700!important; } .st-link:hover, .st-link:focus-visible, .st-link:active, .st-link.is-clicked{ background:#111827!important; border-color:#111827!important; color:#fff!important; text-decoration:none!important; outline:none!important; } .st-close{ border:1px solid #e5e7eb!important; background:#fff!important; color:#111827!important; } .st-close:hover, .st-close:focus-visible, .st-close:active{ background:#111827!important; border-color:#111827!important; color:#fff!important; } .st-date{ height:38px!important; min-width:176px!important; border:1px solid #111827!important; border-radius:8px!important; background:#fff!important; color:#111827!important; font-size:11px!important; font-weight:600!important; } .st-date:hover, .st-date:focus-visible{ background:#111827!important; color:#fff!important; } .st-date:hover i, .st-date:focus-visible i{ color:#fff!important; } /* Quick cards and privacy controls: subtle rows; hover black without moving */ .st-quick, .st-privacy, .st-setting-action{ border:1px solid rgba(17,24,39,.13)!important; border-radius:9px!important; background:#fff!important; color:#111827!important; } .st-quick:hover, .st-quick:focus-visible, .st-quick:active, .st-quick.is-clicked, .st-privacy:hover, .st-privacy:focus-visible, .st-privacy:active, .st-privacy.is-clicked, .st-setting-action:hover, .st-setting-action:focus-visible, .st-setting-action:active, .st-setting-action.is-clicked{ background:#111827!important; border-color:#111827!important; color:#fff!important; transform:none!important; outline:none!important; } .st-quick:hover .st-quick-title, .st-quick:hover .st-quick-sub, .st-quick:hover .st-chev, .st-quick:focus-visible .st-quick-title, .st-quick:focus-visible .st-quick-sub, .st-quick:focus-visible .st-chev, .st-privacy:hover .st-privacy-title, .st-privacy:hover .st-privacy-sub, .st-privacy:hover .st-chev, .st-setting-action:hover span, .st-setting-action:hover i{ color:#fff!important; } .st-add-box, .st-add-payment{ border:1px dashed rgba(17,24,39,.28)!important; border-radius:10px!important; background:#fff!important; color:#111827!important; } .st-add-box:hover, .st-add-box:focus-visible, .st-add-payment:hover, .st-add-payment:focus-visible{ background:#111827!important; border-color:#111827!important; color:#fff!important; transform:none!important; } .st-add-box:hover .st-add-circle, .st-add-payment:hover .st-add-circle{ background:#fff!important; border-color:#fff!important; color:#111827!important; } /* Consistent icon color system */ .st-orange-ico, .st-profile-mini .st-orange-ico, .st-summary-item .st-orange-ico, .st-comm-left .st-orange-ico, .st-privacy-left .st-orange-ico{ background:#fff3e6!important; border:1px solid #f3dfcb!important; color:var(--st-orange)!important; }
.st-ico{ color:#64748b!important; } .st-camera{ background:var(--st-orange)!important; border-color:#fff!important; color:#fff!important; } .st-camera:hover, .st-camera:focus-visible{ background:#111827!important; color:#fff!important; } .st-quick:hover .st-orange-ico, .st-privacy:hover .st-orange-ico, .st-comm-item:hover .st-orange-ico, .st-pref-row:hover .st-orange-ico, .st-setting-action:hover .st-orange-ico{ background:#fff!important; border-color:#fff!important; color:#111827!important; } /* Overview section spacing/positions */ #panel-overview .overview-profile-box .st-body{ padding:14px 16px!important; } #panel-overview .overview-profile-box .st-head, #panel-overview .overview-quick-panel .st-head, #panel-overview .overview-activity-panel .st-head, #panel-overview .overview-comm-panel .st-head{ margin-bottom:10px!important; } #panel-overview .overview-profile-box .st-profile{ grid-template-columns:minmax(0,1.1fr) minmax(280px,.9fr)!important; gap:14px!important; } #panel-overview .overview-profile-box .st-avatar{ width:102px!important; height:102px!important; } #panel-overview .overview-profile-box .st-section-line{ height:1px!important; background:#e5e7eb!important; margin:15px 0!important; } #panel-overview .overview-profile-box .st-address-grid{ gap:10px!important; } #panel-overview .overview-profile-box .st-box, #panel-overview .overview-profile-box .st-add-box{ border-color:rgba(17,24,39,.16)!important; min-height:96px!important; } #panel-overview .overview-payment-box{ display:grid!important; grid-template-columns:minmax(0,1fr) minmax(0,1fr)!important; gap:0!important; padding:0!important; } #panel-overview .overview-payment-box>.st-card:first-child{ border-right:1px solid #e5e7eb!important; } #panel-overview .overview-payment-box>.st-card .st-body{ padding:14px 16px!important; } #panel-overview .overview-quick-panel{ border-color:rgba(17,24,39,.16)!important; } #panel-overview .overview-quick-panel .st-quick-grid{ grid-template-columns:repeat(2,minmax(0,1fr))!important; gap:9px!important; } #panel-overview .overview-quick-panel .st-quick{ min-height:56px!important; padding:9px!important; } #panel-overview .overview-comm-panel .st-list, #panel-overview .overview-prefs-panel> .st-body > div, #panel-overview .overview-activity-panel> .st-body > div:last-child{ margin-top:8px!important; } .st-comm-item, .st-pref-row, .st-activity-row, .st-no-box-item, .st-right-metric{ border-bottom:1px solid #e8ebf0!important; border-radius:0!important; background:transparent!important; margin:0!important; padding:8px 0!important; transform:none!important; } .st-comm-item:hover, .st-pref-row:hover, .st-activity-row:hover, .st-no-box-item:hover, .st-right-metric:hover{ background:transparent!important; margin:0!important; padding-left:0!important; padding-right:0!important; transform:none!important; } .st-privacy-grid{ grid-template-columns:repeat(3,minmax(0,1fr))!important; gap:10px!important; } #panel-overview .overview-privacy-panel .st-privacy{ min-height:54px!important; padding:9px!important; } /* Toggles consistent green/off gray */ .st-switch{ width:36px!important; height:20px!important; } .st-slider{ background:#d1d5db!important; } .st-switch input:checked+.st-slider{ background:#16a34a!important; } .st-switch input:checked+.st-slider:before{ transform:translateX(15px)!important; } /* Forms and modals: transparent cancel / green save where applicable */ .st-input, .st-textarea{ border:1px solid rgba(17,24,39,.16)!important;
border-radius:10px!important; background:#fff!important; } .st-input:focus, .st-textarea:focus{ border-color:#111827!important; box-shadow:0 0 0 3px rgba(17,24,39,.08)!important; } .st-modal-card{ border:1px solid #111827!important; border-radius:16px!important; } .st-modal .st-actions .st-btn:first-child{ background:#fff!important; border:1px solid #111827!important; color:#111827!important; } .st-modal .st-actions .st-btn:first-child:hover, .st-modal .st-actions .st-btn:first-child:focus-visible{ background:#111827!important; border-color:#111827!important; color:#fff!important; } .st-modal .st-actions .st-btn[type="submit"], #panel-profile .st-actions .st-btn, #panel-notifications .st-head .st-btn[onclick*="Save"], #panel-preferences .st-head .st-btn[onclick*="Save"]{ background:#16a34a!important; border-color:#16a34a!important; color:#fff!important; } .st-modal .st-actions .st-btn[type="submit"]:hover, #panel-profile .st-actions .st-btn:hover, #panel-notifications .st-head .st-btn[onclick*="Save"]:hover, #panel-preferences .st-head .st-btn[onclick*="Save"]:hover{ background:#111827!important; border-color:#111827!important; color:#fff!important; } /* Reduce visual redundancy in side panels */ .st-section-side .st-card-title, .st-setting-side .st-card-title, .st-notif-side .st-card-title, .st-pay-side .st-card-title{ font-size:12.5px!important; } .st-section-side .st-card-desc, .st-setting-side .st-card-desc, .st-notif-side .st-card-desc, .st-pay-side .st-card-desc{ font-size:9.5px!important; } .st-section-side .st-no-box-list, .st-setting-side .st-side-list, .st-notif-side .st-no-box-list, .st-pay-side .st-no-box-list{ gap:0!important; } /* Never move items on hover */ .st-page *, .st-page *:hover, .st-page *:focus, .st-page *:active{ transform:none!important; } @media(max-width:1260px){ #panel-overview>.st-grid, #panel-overview .overview-payment-box, .st-grid, .st-settings-grid, .st-section-layout, .st-profile, .st-two{ grid-template-columns:1fr!important; } #panel-overview .overview-payment-box>.st-card:first-child{ border-right:0!important; border-bottom:1px solid #e5e7eb!important; } } @media(max-width:860px){ .st-wrap{padding:0 12px 28px!important;} .st-tabs{gap:18px!important;} .st-privacy-grid, #panel-overview .overview-quick-panel .st-quick-grid, .st-address-grid, .st-form-grid, .st-summary-strip{ grid-template-columns:1fr!important; } .st-btn, .st-outline-btn, .st-date{width:100%!important;} } /* ========================================================= FINAL OVERVIEW REQUEST PATCH - 2026-06-08 Layout follows My Profile button/font/hover flow: left = Profile+Address boxed, Payment/Notifications plain, Quick/Activity plain; right = Privacy, Communication, Preferences plain. ========================================================= */ #panel-overview>.st-grid{ display:grid!important; grid-template-columns:minmax(0,1.08fr) minmax(360px,.72fr)!important; gap:22px!important; align-items:start!important; } #panel-overview .overview-left-stack, #panel-overview .overview-right-stack{ display:flex!important; flex-direction:column!important; gap:18px!important; min-width:0!important; width:100%!important; } #panel-overview .overview-right-stack{ max-width:520px!important; justify-self:stretch!important; } #panel-overview .overview-profile-box{ border:1.5px solid #111827!important; border-radius:14px!important; background:#fff!important; box-shadow:none!important; overflow:hidden!important; }
#panel-overview .overview-profile-box:hover{ background:#fff!important; border-color:#111827!important; box-shadow:none!important; } #panel-overview .overview-profile-box>.st-body{ padding:16px!important; } #panel-overview .overview-profile-box .st-section-line{ height:1px!important; background:#111827!important; opacity:1!important; margin:16px 0!important; } #panel-overview .overview-profile-box .st-address-grid{ display:grid!important; grid-template-columns:repeat(3,minmax(0,1fr))!important; gap:12px!important; align-items:stretch!important; } #panel-overview .overview-profile-box .st-box, #panel-overview .overview-profile-box .st-add-box{ border:1px solid #d9dee7!important; border-radius:12px!important; background:#fff!important; min-height:118px!important; padding:12px!important; box-shadow:none!important; } #panel-overview .overview-profile-box .st-box:hover, #panel-overview .overview-profile-box .st-add-box:hover{ border-color:#111827!important; background:#fff!important; } #panel-overview .overview-profile-box .st-box-text{ font-size:9.6px!important; line-height:1.42!important; color:#5f6673!important; word-break:break-word!important; } /* Plain overview panels: no outside box for payment/notification, quick, activity, privacy, communication, preferences */ #panel-overview .overview-payment-box, #panel-overview .overview-quick-panel, #panel-overview .overview-activity-panel, #panel-overview .overview-privacy-panel, #panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; overflow:visible!important; padding:0!important; } #panel-overview .overview-payment-box:hover, #panel-overview .overview-quick-panel:hover, #panel-overview .overview-activity-panel:hover, #panel-overview .overview-privacy-panel:hover, #panel-overview .overview-comm-panel:hover, #panel-overview .overview-prefs-panel:hover{ background:transparent!important; border-color:transparent!important; box-shadow:none!important; } #panel-overview .overview-payment-box>.st-card, #panel-overview .overview-quick-panel, #panel-overview .overview-activity-panel, #panel-overview .overview-privacy-panel, #panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel{ border:0!important; background:transparent!important; box-shadow:none!important; } #panel-overview .overview-payment-box>.st-card>.st-body, #panel-overview .overview-quick-panel>.st-body, #panel-overview .overview-activity-panel>.st-body, #panel-overview .overview-privacy-panel>.st-body, #panel-overview .overview-comm-panel>.st-body, #panel-overview .overview-prefs-panel>.st-body{ padding:0!important; } #panel-overview .overview-payment-box{ display:grid!important; grid-template-columns:minmax(0,1fr) minmax(0,1fr)!important; gap:18px!important; } #panel-overview .overview-payment-box>.st-card:first-child{ border-right:0!important; padding-right:0!important; } #panel-overview .overview-payment-box>.st-card:last-child{ padding-left:0!important; } #panel-overview .overview-payment-box .st-list, #panel-overview .overview-comm-panel .st-list{ margin-top:10px!important; } #panel-overview .st-notif-item, #panel-overview .st-comm-item, #panel-overview .st-pref-row, #panel-overview .st-activity-row{ border-bottom:1px solid #e8ebf0!important; padding:9px 0!important; margin:0!important; background:transparent!important; border-radius:0!important; }
#panel-overview .st-notif-item:last-child, #panel-overview .st-comm-item:last-child, #panel-overview .st-pref-row:last-child, #panel-overview .st-activity-row:last-child{ border-bottom:0!important; } #panel-overview .st-notif-item:hover, #panel-overview .st-comm-item:hover, #panel-overview .st-pref-row:hover, #panel-overview .st-activity-row:hover{ background:transparent!important; padding-left:0!important; padding-right:0!important; } #panel-overview .overview-quick-panel .st-quick-grid{ display:grid!important; grid-template-columns:repeat(2,minmax(0,1fr))!important; gap:10px!important; } #panel-overview .overview-privacy-panel .st-privacy-grid{ display:grid!important; grid-template-columns:1fr!important; gap:8px!important; } #panel-overview .overview-quick-panel .st-quick, #panel-overview .overview-privacy-panel .st-privacy{ border:1px solid #e5e7eb!important; border-radius:10px!important; background:#fff!important; min-height:54px!important; padding:9px!important; box-shadow:none!important; } #panel-overview .overview-quick-panel .st-quick:hover, #panel-overview .overview-quick-panel .st-quick:focus-visible, #panel-overview .overview-privacy-panel .st-privacy:hover, #panel-overview .overview-privacy-panel .st-privacy:focus-visible{ background:#111827!important; border-color:#111827!important; color:#fff!important; } #panel-overview .overview-quick-panel .st-quick:hover .st-quick-title, #panel-overview .overview-quick-panel .st-quick:hover .st-quick-sub, #panel-overview .overview-quick-panel .st-quick:hover .st-chev, #panel-overview .overview-privacy-panel .st-privacy:hover .st-privacy-title, #panel-overview .overview-privacy-panel .st-privacy:hover .st-privacy-sub, #panel-overview .overview-privacy-panel .st-privacy:hover .st-chev{ color:#fff!important; } /* My Profile-like buttons and hover behavior */ .st-btn, .st-page .st-btn, .st-outline-btn, .st-page .st-outline-btn{ height:36px!important; min-width:118px!important; padding:0 16px!important; border-radius:10px!important; font-family:'Poppins',system-ui,sans-serif!important; font-size:10.5px!important; font-weight:600!important; letter-spacing:.01em!important; box-shadow:none!important; transform:none!important; } .st-btn, .st-page .st-btn{ border:1px solid var(--st-orange)!important; background:var(--st-orange)!important; color:#111827!important; } .st-outline-btn, .st-page .st-outline-btn{ border:1px solid var(--st-orange)!important; background:#fff!important; color:var(--st-orange)!important; } .st-btn:hover, .st-btn:focus-visible, .st-btn:active, .st-outline-btn:hover, .st-outline-btn:focus-visible, .st-outline-btn:active, .st-link:hover, .st-link:focus-visible, .st-link:active{ background:#111827!important; border-color:#111827!important; color:#fff!important; outline:none!important; transform:none!important; } .st-link{ min-height:24px!important; padding:0 8px!important; border-radius:8px!important; color:var(--st-orange)!important; background:transparent!important; } /* Icons and toggles consistency */ #panel-overview .st-orange-ico, #panel-overview .st-ico{ color:var(--st-orange)!important; } #panel-overview .st-orange-ico{ background:#fff3e6!important; border:1px solid #f3dfcb!important; } #panel-overview .overview-quick-panel .st-quick:hover .st-orange-ico, #panel-overview .overview-privacy-panel .st-privacy:hover .st-ico, #panel-overview .overview-privacy-panel .st-privacy:hover .st-orange-ico{ background:#fff!important; border-color:#fff!important;
color:#111827!important; } .st-switch input:checked+.st-slider{ background:#16a34a!important; } .st-slider{ background:#d1d5db!important; } /* Profile settings tab: same compact flow as My Profile */ #panel-profile .st-card-title, #panel-security .st-card-title, #panel-notifications .st-card-title, #panel-payments .st-card-title, #panel-addresses .st-card-title, #panel-preferences .st-card-title, #panel-privacy .st-card-title{ font-size:12.5px!important; letter-spacing:.025em!important; } #panel-profile .st-card-desc, #panel-security .st-card-desc, #panel-notifications .st-card-desc, #panel-payments .st-card-desc, #panel-addresses .st-card-desc, #panel-preferences .st-card-desc, #panel-privacy .st-card-desc{ font-size:9.5px!important; line-height:1.35!important; } #panel-profile .st-input, #panel-preferences .st-input, #panel-privacy select{ min-height:38px!important; font-size:10.5px!important; border-radius:10px!important; } @media(max-width:1260px){ #panel-overview>.st-grid, #panel-overview .overview-payment-box{ grid-template-columns:1fr!important; } #panel-overview .overview-right-stack{ max-width:none!important; } } @media(max-width:860px){ #panel-overview .overview-profile-box .st-address-grid, #panel-overview .overview-quick-panel .st-quick-grid{ grid-template-columns:1fr!important; } } /* ========================================================= USER REVISION V2: Right side width/endpoints + My Profile button/date shape, color, hover, and readable sizing ========================================================= */ :root{ --st-btn-height-final:38px; --st-btn-radius-final:999px; --st-right-width-final:420px; } /* Keep all Settings action buttons exactly aligned with My Profile button behavior */ .st-page .st-btn, .st-page button.st-btn{ height:var(--st-btn-height-final)!important; min-width:112px!important; padding:0 14px!important; border:1px solid transparent!important; border-radius:var(--st-btn-radius-final)!important; background:linear-gradient(90deg,var(--st-orange),#ffab0a)!important; color:#111827!important; font-family:'Inter',system-ui,sans-serif!important; font-size:11px!important; font-weight:600!important; line-height:1!important; letter-spacing:0!important; display:inline-flex!important; align-items:center!important; justify-content:center!important; gap:8px!important; white-space:nowrap!important; box-shadow:none!important; transform:none!important; transition:background .18s ease,color .18s ease,border-color .18s ease!important; } .st-page .st-btn:hover, .st-page .st-btn:focus-visible, .st-page .st-btn:active, .st-page .st-btn.is-clicked, .st-page .st-btn.st-clickable-cover{ background:#111827!important; border-color:#111827!important; color:#fff!important; outline:0!important; box-shadow:none!important; transform:none!important; } .st-page .st-btn:hover i, .st-page .st-btn:focus-visible i, .st-page .st-btn:active i{ color:#fff!important; } /* Secondary / outline buttons: same My Profile shape, white default, black hover */ .st-page .st-outline-btn, .st-page button.st-outline-btn{ height:var(--st-btn-height-final)!important; min-width:112px!important; padding:0 14px!important; border:1px solid #111827!important; border-radius:var(--st-btn-radius-final)!important; background:#fff!important; color:#111827!important; font-family:'Inter',system-ui,sans-serif!important; font-size:11px!important; font-weight:600!important; line-height:1!important; display:inline-flex!important; align-items:center!important;
justify-content:center!important; gap:8px!important; white-space:nowrap!important; box-shadow:none!important; transform:none!important; transition:background .18s ease,color .18s ease,border-color .18s ease!important; } .st-page .st-outline-btn:hover, .st-page .st-outline-btn:focus-visible, .st-page .st-outline-btn:active, .st-page .st-outline-btn.is-clicked{ background:#111827!important; border-color:#111827!important; color:#fff!important; outline:0!important; } .st-page .st-outline-btn:hover i, .st-page .st-outline-btn:focus-visible i{ color:#fff!important; } /* Calendar / date pill: same My Profile shape, height, hover behavior */ .st-page .st-date{ height:var(--st-btn-height-final)!important; min-width:164px!important; width:auto!important; padding:0 13px!important; border:1px solid #111827!important; border-radius:8px!important; background:#fff!important; color:#111827!important; font-family:'Inter',system-ui,sans-serif!important; font-size:11.5px!important; font-weight:500!important; line-height:1!important; display:inline-flex!important; align-items:center!important; justify-content:center!important; gap:8px!important; white-space:nowrap!important; box-shadow:none!important; transform:none!important; cursor:pointer!important; transition:background .18s ease,color .18s ease,border-color .18s ease!important; } .st-page .st-date i{ color:#111827!important; transition:color .18s ease!important; } .st-page .st-date:hover, .st-page .st-date:focus-visible, .st-page .st-date:active{ background:#111827!important; border-color:#111827!important; color:#fff!important; outline:0!important; } .st-page .st-date:hover i, .st-page .st-date:focus-visible i, .st-page .st-date:active i{ color:#fff!important; } /* Overview: reduce the right-side column, but keep readable font/spacing */ @media(min-width:1261px){ #panel-overview>.st-grid{ display:grid!important; grid-template-columns:minmax(0,1fr) var(--st-right-width-final)!important; gap:22px!important; align-items:start!important; } #panel-overview>.st-grid>.st-stack:first-child{ grid-column:1!important; width:100%!important; min-width:0!important; } #panel-overview>.st-grid>.st-stack:nth-child(2){ grid-column:2!important; width:var(--st-right-width-final)!important; max-width:var(--st-right-width-final)!important; min-width:0!important; justify-self:end!important; align-self:start!important; } } /* Every right-side Overview section has the exact same endpoint/width */ #panel-overview>.st-grid>.st-stack:nth-child(2) > .st-card, #panel-overview .overview-quick-panel, #panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel, #panel-overview .overview-privacy-panel{ width:100%!important; max-width:100%!important; min-width:0!important; box-sizing:border-box!important; margin-left:0!important; margin-right:0!important; } /* Plain right-side panels should not look boxed, but their inner endpoints remain aligned */ #panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-privacy-panel, #panel-overview .overview-activity-panel{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; overflow:visible!important; } #panel-overview .overview-comm-panel>.st-body, #panel-overview .overview-prefs-panel>.st-body, #panel-overview .overview-privacy-panel>.st-body, #panel-overview .overview-activity-panel>.st-body{ padding:0!important; }
/* Keep Quick Settings as the first clean right-side block, with same endpoint */ #panel-overview .overview-quick-panel{ border:1px solid rgba(17,24,39,.18)!important; border-radius:12px!important; background:#fff!important; box-shadow:0 8px 22px rgba(15,23,42,.045)!important; overflow:hidden!important; } #panel-overview .overview-quick-panel>.st-body{ padding:14px 15px!important; } /* Make right-side content readable, not tiny */ #panel-overview>.st-grid>.st-stack:nth-child(2) .st-card-title{ font-size:13.5px!important; line-height:1.35!important; } #panel-overview>.st-grid>.st-stack:nth-child(2) .st-card-desc{ font-size:10.5px!important; line-height:1.45!important; } #panel-overview>.st-grid>.st-stack:nth-child(2) .st-quick-title, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-comm-title, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-pref-label, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-act-label, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-privacy-title{ font-size:11.2px!important; line-height:1.25!important; } #panel-overview>.st-grid>.st-stack:nth-child(2) .st-quick-sub, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-comm-sub, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-privacy-sub{ font-size:9.8px!important; line-height:1.35!important; } #panel-overview>.st-grid>.st-stack:nth-child(2) .st-orange-ico{ width:30px!important; height:30px!important; border-radius:9px!important; flex:0 0 30px!important; } /* Right side rows must start/end cleanly and never shift on hover */ #panel-overview>.st-grid>.st-stack:nth-child(2) .st-comm-item, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-pref-row, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-activity-row, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-no-box-item, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-right-metric{ width:100%!important; box-sizing:border-box!important; padding:8px 0!important; margin:0!important; border-bottom:1px solid #e8ebf0!important; border-radius:0!important; background:transparent!important; } #panel-overview>.st-grid>.st-stack:nth-child(2) .st-comm-item:hover, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-pref-row:hover, #panel-overview>.st-grid>.st-stack:nth-child(2) .st-activity-row:hover{ padding-left:0!important; padding-right:0!important; margin-left:0!important; margin-right:0!important; background:transparent!important; transform:none!important; } /* Quick Settings cards: equal endpoints inside the right column */ #panel-overview .overview-quick-panel .st-quick-grid{ display:grid!important; grid-template-columns:1fr!important; gap:8px!important; } #panel-overview .overview-quick-panel .st-quick{ width:100%!important; min-height:58px!important; padding:10px!important; box-sizing:border-box!important; } /* Privacy Controls on right: reduce to one-column so endpoints stay even in the narrower column */ #panel-overview .overview-privacy-panel .st-privacy-grid{ display:grid!important; grid-template-columns:1fr!important; gap:8px!important; } #panel-overview .overview-privacy-panel .st-privacy{ width:100%!important; min-height:58px!important; padding:10px!important; box-sizing:border-box!important; } /* Saved Payment + Notification area stays under Profile/Address but is not too compressed */ #panel-overview .overview-payment-box{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; display:grid!important;
grid-template-columns:minmax(0,1fr) minmax(0,1fr)!important; gap:18px!important; padding:0!important; overflow:visible!important; } #panel-overview .overview-payment-box>.st-card{ border:0!important; background:transparent!important; box-shadow:none!important; border-radius:0!important; overflow:visible!important; } #panel-overview .overview-payment-box>.st-card:first-child{ border-right:0!important; padding-right:0!important; } #panel-overview .overview-payment-box>.st-card:last-child{ padding-left:0!important; } #panel-overview .overview-payment-box>.st-card .st-body{ padding:0!important; } /* Keep font sizes balanced globally; not too small */ .st-page .st-card-title{font-size:13.5px!important;} .st-page .st-card-desc{font-size:10.5px!important;} .st-page .st-sec-title, .st-page .st-pay-title, .st-page .st-notif-title{font-size:11.2px!important;} .st-page .st-sec-sub, .st-page .st-pay-sub, .st-page .st-notif-sub{font-size:9.8px!important;line-height:1.35!important;} @media(max-width:1260px){ #panel-overview>.st-grid{ grid-template-columns:1fr!important; } #panel-overview>.st-grid>.st-stack:nth-child(2){ width:100%!important; max-width:100%!important; justify-self:stretch!important; } #panel-overview .overview-payment-box{ grid-template-columns:1fr!important; gap:16px!important; } } @media(max-width:860px){ .st-page .st-date, .st-page .st-btn, .st-page .st-outline-btn{ width:100%!important; min-width:0!important; } } /* ========================================================= USER REVISION V3: Exact Overview order + narrow right side Right order: Privacy Controls > Saved Payment Methods > Communication Preferences > Quick Settings > Preferences Left order: Profile/Address box > Notification Preferences > Account Activity ========================================================= */ :root{ --st-right-width-final:390px; --st-overview-gap-final:24px; --st-button-orange-final:#ff7a00; --st-button-orange-hover:#111827; } @media(min-width:1261px){ #panel-overview>.st-grid{ display:grid!important; grid-template-columns:minmax(0,1fr) var(--st-right-width-final)!important; gap:var(--st-overview-gap-final)!important; align-items:start!important; } #panel-overview .overview-left-stack{ width:100%!important; max-width:100%!important; min-width:0!important; justify-self:stretch!important; } #panel-overview .overview-right-stack{ width:var(--st-right-width-final)!important; max-width:var(--st-right-width-final)!important; min-width:0!important; justify-self:end!important; align-self:start!important; } } #panel-overview .overview-left-stack, #panel-overview .overview-right-stack{ display:flex!important; flex-direction:column!important; gap:18px!important; } #panel-overview .overview-right-stack > *, #panel-overview .overview-left-stack > *{ width:100%!important; max-width:100%!important; min-width:0!important; box-sizing:border-box!important; margin-left:0!important; margin-right:0!important; } #panel-overview .overview-right-stack .st-right-slim{ width:100%!important; max-width:100%!important; } /* Outer box rules: only Profile+Address remains boxed on Overview */ #panel-overview .overview-profile-box{ border:1.5px solid #111827!important; border-radius:14px!important; background:#fff!important; box-shadow:none!important; overflow:hidden!important; } #panel-overview .overview-profile-box:hover{ border-color:#111827!important; background:#fff!important; box-shadow:none!important; } #panel-overview .overview-profile-box>.st-body{
padding:16px!important; } #panel-overview .overview-profile-box .st-section-line{ background:#111827!important; height:1px!important; margin:16px 0!important; } #panel-overview .overview-notif-panel, #panel-overview .overview-activity-panel, #panel-overview .overview-privacy-panel, #panel-overview .overview-payment-panel, #panel-overview .overview-comm-panel, #panel-overview .overview-quick-panel, #panel-overview .overview-prefs-panel{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; overflow:visible!important; padding:0!important; } #panel-overview .overview-notif-panel:hover, #panel-overview .overview-activity-panel:hover, #panel-overview .overview-privacy-panel:hover, #panel-overview .overview-payment-panel:hover, #panel-overview .overview-comm-panel:hover, #panel-overview .overview-quick-panel:hover, #panel-overview .overview-prefs-panel:hover{ border:0!important; background:transparent!important; box-shadow:none!important; } #panel-overview .overview-notif-panel>.st-body, #panel-overview .overview-activity-panel>.st-body, #panel-overview .overview-privacy-panel>.st-body, #panel-overview .overview-payment-panel>.st-body, #panel-overview .overview-comm-panel>.st-body, #panel-overview .overview-quick-panel>.st-body, #panel-overview .overview-prefs-panel>.st-body{ padding:0!important; } /* Endpoint alignment: all right-side cards/rows/cards end at same edge */ #panel-overview .overview-right-stack .st-head, #panel-overview .overview-right-stack .st-list, #panel-overview .overview-right-stack .st-privacy-grid, #panel-overview .overview-right-stack .st-quick-grid, #panel-overview .overview-right-stack .st-pref-row, #panel-overview .overview-right-stack .st-pay-item, #panel-overview .overview-right-stack .st-pay-bottom, #panel-overview .overview-right-stack .st-add-payment, #panel-overview .overview-right-stack .st-quick, #panel-overview .overview-right-stack .st-privacy, #panel-overview .overview-right-stack .st-comm-item{ width:100%!important; max-width:100%!important; box-sizing:border-box!important; } #panel-overview .overview-right-stack .st-pay-bottom{ display:grid!important; grid-template-columns:1fr!important; gap:8px!important; } #panel-overview .overview-right-stack .st-list{ display:flex!important; flex-direction:column!important; gap:8px!important; margin-top:10px!important; } #panel-overview .overview-right-stack .st-quick-grid, #panel-overview .overview-right-stack .st-privacy-grid{ display:grid!important; grid-template-columns:1fr!important; gap:8px!important; margin-top:10px!important; } /* Right side readable sizes but not wide */ #panel-overview .overview-right-stack .st-card-title, #panel-overview .overview-left-stack .st-card-title{ font-size:13.5px!important; line-height:1.3!important; } #panel-overview .overview-right-stack .st-card-desc, #panel-overview .overview-left-stack .st-card-desc{ font-size:10.5px!important; line-height:1.4!important; } #panel-overview .overview-right-stack .st-pay-title, #panel-overview .overview-right-stack .st-comm-title, #panel-overview .overview-right-stack .st-quick-title, #panel-overview .overview-right-stack .st-privacy-title, #panel-overview .overview-right-stack .st-pref-label, #panel-overview .overview-left-stack .st-notif-title, #panel-overview .overview-left-stack .st-act-label{ font-size:11.2px!important; line-height:1.25!important; } #panel-overview .overview-right-stack .st-pay-sub,
#panel-overview .overview-right-stack .st-comm-sub, #panel-overview .overview-right-stack .st-quick-sub, #panel-overview .overview-right-stack .st-privacy-sub, #panel-overview .overview-left-stack .st-notif-sub{ font-size:9.8px!important; line-height:1.35!important; } /* Cards/rows inside plain panels: clean, aligned, no shifting */ #panel-overview .st-pay-item, #panel-overview .st-notif-item, #panel-overview .st-comm-item, #panel-overview .st-pref-row, #panel-overview .st-activity-row{ width:100%!important; margin:0!important; padding:8px 0!important; border-bottom:1px solid #e8ebf0!important; border-radius:0!important; background:transparent!important; transform:none!important; box-shadow:none!important; } #panel-overview .st-pay-item:last-child, #panel-overview .st-notif-item:last-child, #panel-overview .st-comm-item:last-child, #panel-overview .st-pref-row:last-child, #panel-overview .st-activity-row:last-child{ border-bottom:0!important; } #panel-overview .st-pay-item:hover, #panel-overview .st-notif-item:hover, #panel-overview .st-comm-item:hover, #panel-overview .st-pref-row:hover, #panel-overview .st-activity-row:hover{ margin:0!important; padding-left:0!important; padding-right:0!important; background:transparent!important; transform:none!important; box-shadow:none!important; } #panel-overview .overview-quick-panel .st-quick, #panel-overview .overview-privacy-panel .st-privacy{ border:1px solid #e5e7eb!important; border-radius:10px!important; background:#fff!important; min-height:58px!important; padding:10px!important; transform:none!important; box-shadow:none!important; } #panel-overview .overview-quick-panel .st-quick:hover, #panel-overview .overview-quick-panel .st-quick:focus-visible, #panel-overview .overview-privacy-panel .st-privacy:hover, #panel-overview .overview-privacy-panel .st-privacy:focus-visible{ background:#111827!important; border-color:#111827!important; color:#fff!important; transform:none!important; outline:none!important; } #panel-overview .overview-quick-panel .st-quick:hover .st-quick-title, #panel-overview .overview-quick-panel .st-quick:hover .st-quick-sub, #panel-overview .overview-quick-panel .st-quick:hover .st-chev, #panel-overview .overview-privacy-panel .st-privacy:hover .st-privacy-title, #panel-overview .overview-privacy-panel .st-privacy:hover .st-privacy-sub, #panel-overview .overview-privacy-panel .st-privacy:hover .st-chev{ color:#fff!important; } /* My Profile button/date exact behavior */ .st-page .st-btn, .st-page button.st-btn, .st-page .st-outline-btn, .st-page button.st-outline-btn, .st-page .st-date{ height:38px!important; border-radius:999px!important; font-family:'Inter',system-ui,sans-serif!important; font-size:11px!important; font-weight:600!important; line-height:1!important; display:inline-flex!important; align-items:center!important; justify-content:center!important; gap:8px!important; white-space:nowrap!important; box-shadow:none!important; transform:none!important; transition:background .18s ease,color .18s ease,border-color .18s ease!important; } .st-page .st-btn, .st-page button.st-btn{ min-width:112px!important; padding:0 15px!important; border:1px solid #ff7a00!important; background:#ff7a00!important; color:#111827!important; } .st-page .st-outline-btn, .st-page button.st-outline-btn, .st-page .st-date{ min-width:112px!important; padding:0 15px!important; border:1px solid #111827!important; background:#fff!important; color:#111827!important; } .st-page .st-date{
min-width:166px!important; border-radius:999px!important; cursor:pointer!important; } .st-page .st-date i{color:#111827!important;} .st-page .st-btn:hover, .st-page .st-btn:focus-visible, .st-page .st-btn:active, .st-page .st-outline-btn:hover, .st-page .st-outline-btn:focus-visible, .st-page .st-outline-btn:active, .st-page .st-date:hover, .st-page .st-date:focus-visible, .st-page .st-date:active, .st-page .st-link:hover, .st-page .st-link:focus-visible, .st-page .st-link:active{ background:#111827!important; border-color:#111827!important; color:#fff!important; outline:0!important; box-shadow:none!important; transform:none!important; } .st-page .st-date:hover i, .st-page .st-date:focus-visible i, .st-page .st-btn:hover i, .st-page .st-outline-btn:hover i{color:#fff!important;} /* Icons/toggles consistency */ #panel-overview .st-orange-ico{ background:#fff3e6!important; border:1px solid #f3dfcb!important; color:#ff7a00!important; } #panel-overview .st-ico{ color:#ff7a00!important; } #panel-overview .overview-quick-panel .st-quick:hover .st-orange-ico, #panel-overview .overview-privacy-panel .st-privacy:hover .st-ico, #panel-overview .overview-privacy-panel .st-privacy:hover .st-orange-ico{ background:#fff!important; border-color:#fff!important; color:#111827!important; } .st-switch input:checked+.st-slider{background:#16a34a!important;} .st-slider{background:#d1d5db!important;} @media(max-width:1260px){ #panel-overview>.st-grid{ grid-template-columns:1fr!important; } #panel-overview .overview-right-stack{ width:100%!important; max-width:100%!important; justify-self:stretch!important; } } @media(max-width:860px){ .st-page .st-date, .st-page .st-btn, .st-page .st-outline-btn{ width:100%!important; min-width:0!important; } } /* ========================================================= FINAL POLISH: exact overview order, right-side width, consistent buttons/date, and unified score rings ========================================================= */ :root{ --st-primary-orange:#ff7a00; --st-primary-orange-2:#ffab0a; --st-action-hover:#111827; } /* Overview columns: right side narrower, all cards end evenly */ @media(min-width:1261px){ #panel-overview > .st-grid{ grid-template-columns:minmax(0,1fr) 455px!important; gap:22px!important; align-items:start!important; } #panel-overview .overview-left-stack, #panel-overview .overview-right-stack{ width:100%!important; max-width:none!important; display:flex!important; flex-direction:column!important; gap:18px!important; } #panel-overview .overview-right-stack > .st-card, #panel-overview .overview-right-stack > .st-card.st-right-slim, #panel-overview .overview-left-stack > .st-card, #panel-overview .overview-left-stack > .st-card.st-right-slim{ width:100%!important; max-width:none!important; margin-left:0!important; margin-right:0!important; box-sizing:border-box!important; } } @media(max-width:1260px){ #panel-overview > .st-grid{grid-template-columns:1fr!important;} #panel-overview .overview-right-stack, #panel-overview .overview-left-stack{width:100%!important;max-width:none!important;} } /* Requested no-box panels stay clean but keep exact aligned width */ #panel-overview .overview-notif-panel, #panel-overview .overview-comm-panel, #panel-overview .overview-quick-panel, #panel-overview .overview-privacy-panel, #panel-overview .overview-payment-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel{ width:100%!important; max-width:none!important;
box-sizing:border-box!important; } #panel-overview .overview-notif-panel, #panel-overview .overview-comm-panel, #panel-overview .overview-payment-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel{ border:0!important; background:transparent!important; box-shadow:none!important; border-radius:0!important; overflow:visible!important; } #panel-overview .overview-notif-panel > .st-body, #panel-overview .overview-comm-panel > .st-body, #panel-overview .overview-payment-panel > .st-body, #panel-overview .overview-prefs-panel > .st-body, #panel-overview .overview-activity-panel > .st-body{ padding:0!important; } #panel-overview .overview-privacy-panel, #panel-overview .overview-quick-panel{ border:0!important; background:transparent!important; box-shadow:none!important; border-radius:0!important; overflow:visible!important; } #panel-overview .overview-privacy-panel > .st-body, #panel-overview .overview-quick-panel > .st-body{ padding:0!important; } /* Right-side cards/cards lists: same endpoint and comfortable size */ #panel-overview .overview-right-stack .st-privacy-grid, #panel-overview .overview-right-stack .st-quick-grid{ grid-template-columns:1fr!important; gap:9px!important; } #panel-overview .overview-left-stack .st-quick-grid{ grid-template-columns:repeat(2,minmax(0,1fr))!important; gap:10px!important; } #panel-overview .overview-right-stack .st-privacy, #panel-overview .overview-right-stack .st-quick, #panel-overview .overview-left-stack .st-quick, #panel-overview .overview-left-stack .st-privacy{ width:100%!important; min-height:54px!important; padding:10px!important; box-sizing:border-box!important; } #panel-overview .overview-payment-panel .st-pay-bottom{ grid-template-columns:1fr!important; } #panel-overview .overview-payment-panel .st-add-payment{ min-height:50px!important; } /* Buttons and Date: one consistent My Profile-style button system */ .st-page .st-btn, .st-page .st-outline-btn, .st-page .st-date, .st-modal .st-actions .st-btn, #panel-profile .st-actions .st-btn, #panel-notifications .st-head .st-btn, #panel-preferences .st-head .st-btn{ height:36px!important; min-width:120px!important; padding:0 16px!important; border-radius:999px!important; border:1px solid transparent!important; background:linear-gradient(90deg,var(--st-primary-orange),var(--st-primary-orange-2))!important; color:#111827!important; font-family:'Poppins',system-ui,sans-serif!important; font-size:10.5px!important; font-weight:700!important; letter-spacing:.01em!important; display:inline-flex!important; align-items:center!important; justify-content:center!important; gap:7px!important; box-shadow:none!important; transform:none!important; white-space:nowrap!important; cursor:pointer!important; } .st-page .st-btn:hover, .st-page .st-btn:focus-visible, .st-page .st-btn:active, .st-page .st-btn.is-clicked, .st-page .st-outline-btn:hover, .st-page .st-outline-btn:focus-visible, .st-page .st-outline-btn:active, .st-page .st-outline-btn.is-clicked, .st-page .st-date:hover, .st-page .st-date:focus-visible, .st-modal .st-actions .st-btn:hover, .st-modal .st-actions .st-btn:focus-visible, #panel-profile .st-actions .st-btn:hover, #panel-notifications .st-head .st-btn:hover, #panel-preferences .st-head .st-btn:hover{ background:var(--st-action-hover)!important; border-color:var(--st-action-hover)!important; color:#fff!important; box-shadow:none!important; outline:none!important; transform:none!important; } .st-page .st-date i,
.st-page .st-date span{color:inherit!important;} .st-modal .st-actions .st-btn:first-child{ background:#fff!important; border-color:#111827!important; color:#111827!important; } .st-modal .st-actions .st-btn:first-child:hover, .st-modal .st-actions .st-btn:first-child:focus-visible{ background:#111827!important; border-color:#111827!important; color:#fff!important; } .st-page .st-link{ color:var(--st-primary-orange)!important; border-radius:999px!important; } .st-page .st-link:hover, .st-page .st-link:focus-visible{ background:#111827!important; color:#fff!important; } /* Unified Profile Completion / Security Score / Notification Summary rings */ .st-score-ring, #panel-profile .st-profile-side .st-score-ring, #panel-security .st-setting-side .st-score-ring, #panel-notifications .st-notif-side .st-score-ring, .st-section-layout .st-section-side .st-score-ring{ width:112px!important; height:112px!important; margin:10px auto 12px!important; border-radius:50%!important; background:conic-gradient(var(--st-primary-orange) 0 331deg,#f1f5f9 331deg 360deg)!important; display:grid!important; place-items:center!important; box-shadow:0 8px 22px rgba(255,122,0,.14)!important; } .st-score-inner, #panel-profile .st-profile-side .st-score-inner, #panel-security .st-setting-side .st-score-inner, #panel-notifications .st-notif-side .st-score-inner, .st-section-layout .st-section-side .st-score-inner{ width:82px!important; height:82px!important; border-radius:50%!important; background:#fff!important; display:grid!important; place-items:center!important; text-align:center!important; border:1px solid #fff3e6!important; } .st-score-inner strong, #panel-profile .st-profile-side .st-score-inner strong, #panel-security .st-setting-side .st-score-inner strong, #panel-notifications .st-notif-side .st-score-inner strong, .st-section-layout .st-section-side .st-score-inner strong{ font-family:'Poppins',system-ui,sans-serif!important; font-size:24px!important; line-height:1!important; color:#111827!important; font-weight:800!important; } .st-score-inner span, #panel-profile .st-profile-side .st-score-inner span, #panel-security .st-setting-side .st-score-inner span, #panel-notifications .st-notif-side .st-score-inner span, .st-section-layout .st-section-side .st-score-inner span{ color:var(--st-primary-orange)!important; font-size:10px!important; font-weight:800!important; text-transform:uppercase!important; letter-spacing:.03em!important; } /* Keep switch colors consistent */ .st-switch input:checked + .st-slider{background:#16a34a!important;} .st-slider{background:#d1d5db!important;} @media(max-width:860px){ #panel-overview .overview-left-stack .st-quick-grid{grid-template-columns:1fr!important;} .st-page .st-btn, .st-page .st-outline-btn, .st-page .st-date{width:100%!important;} } /* ========================================================= FINAL FIX V5: exact overview alignment + icon-only colors ========================================================= */ @media(min-width:1261px){ #panel-overview>.st-grid{ grid-template-columns:minmax(0,1fr) 430px!important; gap:24px!important; align-items:start!important; } #panel-overview .overview-right-stack{ width:430px!important; max-width:430px!important; min-width:430px!important; display:flex!important; flex-direction:column!important; gap:18px!important; } #panel-overview .overview-left-stack{ min-width:0!important; width:100%!important; } } @media(max-width:1260px){
#panel-overview>.st-grid{grid-template-columns:1fr!important;} #panel-overview .overview-right-stack{width:100%!important;max-width:none!important;min-width:0!important;} } #panel-overview .overview-right-stack>*, #panel-overview .overview-right-stack .st-card, #panel-overview .overview-right-stack .st-body, #panel-overview .overview-right-stack .st-list, #panel-overview .overview-right-stack .st-privacy-grid, #panel-overview .overview-right-stack .st-quick-grid, #panel-overview .overview-right-stack .st-pay-bottom{ width:100%!important; max-width:100%!important; box-sizing:border-box!important; } #panel-overview .overview-right-stack .st-right-slim{max-width:none!important;width:100%!important;} #panel-overview .overview-right-stack .st-head{width:100%!important;box-sizing:border-box!important;} #panel-overview .overview-right-stack .st-card-title, #panel-overview .overview-left-stack .st-card-title{ background:transparent!important; color:#111827!important; display:block!important; padding:0!important; } /* Address Book: remove bulky individual boxes while keeping clean columns */ #panel-overview .overview-profile-box .st-address-grid{ display:grid!important; grid-template-columns:repeat(3,minmax(0,1fr))!important; gap:14px!important; align-items:stretch!important; } #panel-overview .overview-profile-box .st-box, #panel-overview .overview-profile-box .st-add-box{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; padding:6px 8px 8px 0!important; min-height:96px!important; border-right:1px solid #e5e7eb!important; } #panel-overview .overview-profile-box .st-address-grid>*:last-child{ border-right:0!important; padding-right:0!important; } #panel-overview .overview-profile-box .st-box:hover, #panel-overview .overview-profile-box .st-add-box:hover{ background:transparent!important; border-color:#e5e7eb!important; color:#111827!important; } #panel-overview .overview-profile-box .st-add-box{ justify-content:center!important; text-align:center!important; } #panel-overview .overview-profile-box .st-add-box:hover .st-add-circle{ background:transparent!important; color:var(--st-orange)!important; border-color:#d1d5db!important; } /* Saved Payment Methods: no card/box look, just aligned rows */ #panel-overview .overview-payment-panel .st-pay-item, #panel-overview .overview-payment-panel .st-add-payment{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; padding:9px 0!important; min-height:52px!important; border-bottom:1px solid #e8ebf0!important; width:100%!important; } #panel-overview .overview-payment-panel .st-pay-item:hover, #panel-overview .overview-payment-panel .st-add-payment:hover{ background:transparent!important; border-color:#e8ebf0!important; color:#111827!important; } #panel-overview .overview-payment-panel .st-pay-bottom{ display:block!important; } #panel-overview .overview-payment-panel .st-add-payment{ display:flex!important; flex-direction:row!important; justify-content:center!important; gap:8px!important; border-bottom:0!important; border-top:1px dashed #d1d5db!important; margin-top:8px!important; } #panel-overview .overview-payment-panel .st-add-payment br{display:none!important;} #panel-overview .overview-payment-panel .st-card-logo{ border:1px solid #d1d5db!important; border-radius:7px!important; } /* Quick Settings back on right: compact, same endpoint */
#panel-overview .overview-right-stack .overview-quick-panel{ width:100%!important; max-width:100%!important; } #panel-overview .overview-right-stack .overview-quick-panel .st-quick-grid{ grid-template-columns:1fr!important; gap:0!important; } #panel-overview .overview-right-stack .overview-quick-panel .st-quick{ width:100%!important; border:0!important; border-bottom:1px solid #e8ebf0!important; border-radius:0!important; background:transparent!important; min-height:52px!important; padding:8px 0!important; } #panel-overview .overview-right-stack .overview-quick-panel .st-quick:hover, #panel-overview .overview-right-stack .overview-quick-panel .st-quick:focus-visible{ background:transparent!important; color:#111827!important; border-color:#e8ebf0!important; } #panel-overview .overview-right-stack .overview-quick-panel .st-quick:hover .st-quick-title, #panel-overview .overview-right-stack .overview-quick-panel .st-quick:hover .st-quick-sub, #panel-overview .overview-right-stack .overview-quick-panel .st-quick:hover .st-chev{ color:inherit!important; } /* Icon-only colors: no background shape, varied colors per function */ #panel-overview .st-orange-ico, #panel-overview .st-ico, #panel-profile .st-score-ring ~ .st-no-box-list .st-orange-ico, #panel-security .st-orange-ico, #panel-notifications .st-orange-ico{ background:transparent!important; border:0!important; border-radius:0!important; width:22px!important; height:22px!important; flex:0 0 22px!important; color:var(--st-orange)!important; } #panel-overview .st-orange-ico i, #panel-overview .st-ico i{font-size:14px!important;} #panel-overview .fa-user,#panel-overview .fa-phone{color:#ff7a00!important;} #panel-overview .fa-lock,#panel-overview .fa-shield-halved,#panel-overview .fa-user-shield{color:#16a34a!important;} #panel-overview .fa-bell,#panel-overview .fa-comment-dots,#panel-overview .fa-envelope,#panel-overview .fa-headset{color:#2563eb!important;} #panel-overview .fa-credit-card,#panel-overview .fa-cc-visa,#panel-overview .fa-peso-sign{color:#7c3aed!important;} #panel-overview .fa-truck-fast,#panel-overview .fa-location-dot,#panel-overview .fa-route{color:#ea580c!important;} #panel-overview .fa-folder-open,#panel-overview .fa-download{color:#0891b2!important;} #panel-overview .fa-link,#panel-overview .fa-globe{color:#db2777!important;} #panel-overview .fa-calendar,#panel-overview .fa-calendar-days,#panel-overview .fa-clock{color:#64748b!important;} #panel-overview .fa-bullhorn,#panel-overview .fa-percent{color:#dc2626!important;} #panel-overview .fa-lightbulb,#panel-overview .fa-sun{color:#ca8a04!important;} #panel-overview .fa-circle-plus,#panel-overview .fa-plus{color:#f97316!important;} #panel-overview .st-quick:hover .st-orange-ico, #panel-overview .st-privacy:hover .st-ico, #panel-overview .st-comm-item:hover .st-orange-ico, #panel-overview .st-pref-row:hover .st-orange-ico{ background:transparent!important; border:0!important; } /* Keep all right-side row endpoints perfectly aligned */ #panel-overview .overview-right-stack .st-privacy, #panel-overview .overview-right-stack .st-pay-item, #panel-overview .overview-right-stack .st-add-payment, #panel-overview .overview-right-stack .st-pref-row, #panel-overview .overview-right-stack .st-quick, #panel-overview .overview-right-stack .st-comm-item{ margin-left:0!important; margin-right:0!important; padding-left:0!important; padding-right:0!important; box-sizing:border-box!important; }
#panel-overview .overview-right-stack .st-privacy-grid{ grid-template-columns:1fr!important; gap:8px!important; } #panel-overview .overview-right-stack .st-privacy{ border:1px solid #e5e7eb!important; border-radius:10px!important; padding:10px 12px!important; background:#fff!important; } #panel-overview .overview-right-stack .st-privacy:hover{ background:#fff!important; color:#111827!important; } #panel-overview .overview-right-stack .st-privacy:hover .st-privacy-title, #panel-overview .overview-right-stack .st-privacy:hover .st-privacy-sub, #panel-overview .overview-right-stack .st-privacy:hover .st-chev{color:inherit!important;} /* Button/calendar consistency restored */ .st-btn, .st-outline-btn, .st-date{ height:38px!important; min-width:122px!important; border-radius:999px!important; font-family:'Poppins',system-ui,sans-serif!important; font-size:10.5px!important; font-weight:700!important; transform:none!important; box-shadow:none!important; } .st-btn{ background:linear-gradient(90deg,#ff7a00,#ff9d00)!important; border:1px solid #ff7a00!important; color:#111827!important; } .st-date{ background:linear-gradient(90deg,#ff7a00,#ff9d00)!important; border:1px solid #ff7a00!important; color:#111827!important; justify-content:center!important; } .st-date i{color:#111827!important;} .st-btn:hover,.st-btn:focus-visible,.st-btn:active, .st-outline-btn:hover,.st-outline-btn:focus-visible,.st-outline-btn:active, .st-date:hover,.st-date:focus-visible,.st-date:active{ background:#111827!important; border-color:#111827!important; color:#fff!important; outline:none!important; } .st-date:hover i,.st-date:focus-visible i,.st-date:active i{color:#fff!important;} /* Score circles equalized */ #panel-profile .st-score-ring, #panel-security .st-score-ring, #panel-notifications .st-score-ring{ width:108px!important; height:108px!important; margin:8px auto 12px!important; background:conic-gradient(#ff7a00 0 331deg,#e5e7eb 331deg 360deg)!important; } #panel-profile .st-score-inner, #panel-security .st-score-inner, #panel-notifications .st-score-inner{ width:80px!important; height:80px!important; background:#fff!important; } #panel-profile .st-score-inner strong, #panel-security .st-score-inner strong, #panel-notifications .st-score-inner strong{ font-size:23px!important; color:#111827!important; } #panel-profile .st-score-inner span, #panel-security .st-score-inner span, #panel-notifications .st-score-inner span{ color:#16a34a!important; font-size:9.5px!important; font-weight:700!important; } /* ========================================================= V6 EXACT UI FIXES: tighter content gap, readable text, plain status text, consistent icon colors, original orange ========================================================= */ :root{ --st-orange:#ff7a00!important; --st-orange2:#ff7a00!important; --st-orange3:#fff3e6!important; --st-green:#16a34a!important; } /* Make the main left/right content closer without making the right column too wide */ @media(min-width:1261px){ #panel-overview>.st-grid{ grid-template-columns:minmax(0,1fr) 390px!important; gap:14px!important; column-gap:14px!important; align-items:start!important; } #panel-overview>.st-grid>.st-stack:first-child{ width:100%!important; max-width:none!important; } #panel-overview>.st-grid>.overview-right-stack, #panel-overview>.st-grid>.st-stack:nth-child(2){ width:390px!important; max-width:390px!important; min-width:390px!important; justify-self:end!important; } } @media(min-width:1440px){
#panel-overview>.st-grid{ grid-template-columns:minmax(0,1fr) 410px!important; gap:16px!important; column-gap:16px!important; } #panel-overview>.st-grid>.overview-right-stack, #panel-overview>.st-grid>.st-stack:nth-child(2){ width:410px!important; max-width:410px!important; min-width:410px!important; } } /* Right-side endpoints must always align */ #panel-overview .overview-right-stack{ display:flex!important; flex-direction:column!important; gap:18px!important; align-items:stretch!important; } #panel-overview .overview-right-stack>*, #panel-overview .overview-privacy-panel, #panel-overview .overview-payment-panel, #panel-overview .overview-quick-panel, #panel-overview .overview-prefs-panel{ width:100%!important; max-width:100%!important; margin-left:0!important; margin-right:0!important; } /* Make small-looking text readable again */ .st-page{ font-size:12px!important; } .st-card-title{ font-size:14px!important; line-height:1.25!important; font-weight:700!important; } .st-card-desc, .st-sec-sub, .st-box-text, .st-pay-sub, .st-notif-sub, .st-comm-sub, .st-quick-sub, .st-privacy-sub{ font-size:10.5px!important; line-height:1.35!important; } .st-sec-title, .st-box-title, .st-pay-title, .st-notif-title, .st-comm-title, .st-quick-title, .st-privacy-title, .st-pref-label, .st-act-label{ font-size:11.5px!important; line-height:1.25!important; } .st-label{font-size:11px!important;} .st-value{font-size:11.5px!important;} .st-info{font-size:11.5px!important;} .st-name{font-size:16px!important;} .st-tab{font-size:10.5px!important;} /* Restore the original orange button/date color. No gradient change anymore. */ .st-btn, .st-page .st-btn, .st-outline-btn.st-orange-btn{ background:#ff7a00!important; border-color:#ff7a00!important; color:#111827!important; border-radius:999px!important; height:38px!important; min-width:128px!important; padding:0 18px!important; font-size:11.2px!important; font-weight:700!important; } .st-btn:hover, .st-btn:focus-visible, .st-btn:active, .st-btn.is-clicked, .st-page .st-btn:hover, .st-page .st-btn:focus-visible, .st-page .st-btn:active{ background:#111827!important; border-color:#111827!important; color:#fff!important; } .st-outline-btn, .st-page .st-outline-btn{ background:#fff!important; border:1px solid #ff7a00!important; color:#ff7a00!important; border-radius:999px!important; height:38px!important; min-width:128px!important; padding:0 18px!important; font-size:11.2px!important; font-weight:700!important; } .st-outline-btn:hover, .st-outline-btn:focus-visible, .st-outline-btn:active{ background:#111827!important; border-color:#111827!important; color:#fff!important; } .st-date{ background:#ff7a00!important; border-color:#ff7a00!important; color:#111827!important; border-radius:999px!important; height:38px!important; min-width:190px!important; font-size:11.5px!important; font-weight:700!important; } .st-date i{color:#111827!important;} .st-date:hover, .st-date:focus-visible{ background:#111827!important; border-color:#111827!important; color:#fff!important; } .st-date:hover i, .st-date:focus-visible i{color:#fff!important;} /* Plain text badges/statuses: no background shape, only colored text + inline hover */ .st-badge, .st-mini, .st-status-pill, .st-inline-pill{ background:transparent!important; border:0!important; box-shadow:none!important; border-radius:0!important; padding:0!important; min-height:auto!important; line-height:1.25!important; font-size:10.5px!important; font-weight:700!important;
display:inline-flex!important; align-items:center!important; gap:4px!important; text-decoration:none!important; } .st-badge.green, .st-mini, .st-status-pill, .st-inline-pill{color:#16a34a!important;} .st-badge.orange, .st-mini.orange, .st-status-pill.orange{color:#ff7a00!important;} .st-mini.gray, .st-status-pill.gray{color:#64748b!important;} .st-badge:hover, .st-mini:hover, .st-status-pill:hover, .st-inline-pill:hover{ background:transparent!important; text-decoration:underline!important; text-underline-offset:3px!important; } .st-act-val .st-mini, .st-pay-item .st-mini, .st-box .st-mini{ white-space:nowrap!important; } /* Add a clean inline hover for manage session / small action links */ .st-link{ background:transparent!important; border:0!important; color:#ff7a00!important; border-radius:0!important; padding:0!important; min-height:auto!important; font-size:10.5px!important; font-weight:700!important; } .st-link:hover, .st-link:focus-visible, .st-link:active, .st-link.is-clicked{ background:transparent!important; border:0!important; color:#111827!important; text-decoration:underline!important; text-underline-offset:3px!important; } /* Icons: icon color only, no bg-shape. Consistent by icon type everywhere. */ .st-orange-ico, .st-ico, .st-profile-mini .st-orange-ico, .st-summary-item .st-orange-ico, .st-comm-left .st-orange-ico, .st-privacy-left .st-orange-ico, .st-quick-left .st-orange-ico, .st-pref-left .st-orange-ico{ background:transparent!important; border:0!important; border-radius:0!important; width:22px!important; height:22px!important; min-width:22px!important; flex:0 0 22px!important; color:#64748b!important; box-shadow:none!important; } .st-orange-ico i, .st-ico i{ font-size:14px!important; } /* Message / communication icons always blue */ .st-page .fa-envelope, .st-page .fa-comment-dots, .st-page .fa-message, .st-page .fa-bell, .st-page .fa-paper-plane, .st-page .fa-headset{ color:#2563eb!important; } /* Phone always green */ .st-page .fa-phone, .st-page .fa-mobile-screen, .st-page .fa-mobile-screen-button{ color:#16a34a!important; } /* Calendar/date always slate */ .st-page .fa-calendar, .st-page .fa-calendar-days, .st-page .fa-clock{ color:#64748b!important; } /* Security/privacy always green */ .st-page .fa-shield-halved, .st-page .fa-shield, .st-page .fa-user-shield, .st-page .fa-lock, .st-page .fa-circle-check, .st-page .fa-check{ color:#16a34a!important; } /* Payment always violet/blue */ .st-page .fa-credit-card, .st-page .fa-cc-visa, .st-page .fa-receipt, .st-page .fa-file-invoice, .st-page .fa-wallet, .st-page .fa-peso-sign{ color:#7c3aed!important; } /* Address/location/delivery always orange */ .st-page .fa-location-dot, .st-page .fa-house, .st-page .fa-building, .st-page .fa-store, .st-page .fa-truck-fast, .st-page .fa-route, .st-page .fa-box{ color:#ff7a00!important; } /* Marketing/promos always red */ .st-page .fa-bullhorn, .st-page .fa-percent, .st-page .fa-gift, .st-page .fa-triangle-exclamation{ color:#ef4444!important; } /* Data/download/preferences */ .st-page .fa-download{color:#0891b2!important;} .st-page .fa-globe{color:#0ea5e9!important;} .st-page .fa-sun, .st-page .fa-palette{color:#f59e0b!important;} .st-page .fa-user, .st-page .fa-address-card{color:#ff7a00!important;} .st-page .fa-folder-open, .st-page .fa-link{color:#7c3aed!important;} /* Do not turn colored icons into white/black on hover; keep their semantic color. */ .st-quick:hover .st-orange-ico,
.st-privacy:hover .st-orange-ico, .st-comm-item:hover .st-orange-ico, .st-pref-row:hover .st-orange-ico, .st-setting-action:hover .st-orange-ico, .st-add-box:hover .st-add-circle, .st-add-payment:hover .st-add-circle{ background:transparent!important; border:0!important; } /* Cleaner rows while maintaining endpoint alignment */ #panel-overview .overview-payment-panel .st-pay-item, #panel-overview .overview-privacy-panel .st-privacy, #panel-overview .overview-quick-panel .st-quick, #panel-overview .overview-prefs-panel .st-pref-row{ width:100%!important; box-sizing:border-box!important; } #panel-overview .overview-payment-panel .st-pay-item{ min-height:50px!important; padding:9px 0!important; } #panel-overview .overview-quick-panel .st-quick, #panel-overview .overview-privacy-panel .st-privacy{ padding:10px 0!important; min-height:56px!important; } #panel-overview .overview-quick-panel .st-quick:hover, #panel-overview .overview-privacy-panel .st-privacy:hover{ background:transparent!important; border-color:#e5e7eb!important; } #panel-overview .overview-quick-panel .st-quick:hover .st-quick-title, #panel-overview .overview-quick-panel .st-quick:hover .st-quick-sub, #panel-overview .overview-privacy-panel .st-privacy:hover .st-privacy-title, #panel-overview .overview-privacy-panel .st-privacy:hover .st-privacy-sub{ color:#111827!important; } /* Keep address book clean but readable */ #panel-overview .overview-profile-box .st-address-grid{ gap:0!important; } #panel-overview .overview-profile-box .st-box, #panel-overview .overview-profile-box .st-add-box{ padding:12px 14px!important; min-height:116px!important; } #panel-overview .overview-profile-box .st-box:not(:last-child), #panel-overview .overview-profile-box .st-add-box:not(:last-child){ border-right:1px solid #e5e7eb!important; } /* Switches remain consistent green */ .st-switch input:checked+.st-slider{background:#16a34a!important;} .st-slider{background:#cfd5dd!important;} @media(max-width:1260px){ #panel-overview>.st-grid{gap:18px!important;} #panel-overview>.st-grid>.overview-right-stack, #panel-overview>.st-grid>.st-stack:nth-child(2){ width:100%!important;max-width:none!important;min-width:0!important; } } /* ========================================================= V7 FINAL CORRECTION: balanced left/right spacing, plain inline status text, cleaned Address Book placement, original orange buttons, no black bg on text links ========================================================= */ :root{ --st-orange:#ff7a00!important; --st-orange2:#ff7a00!important; --st-orange3:#fff3e6!important; } /* Give a little more breathing room between left and right, but keep endpoints aligned */ @media(min-width:1261px){ #panel-overview>.st-grid{ grid-template-columns:minmax(0,1fr) 405px!important; gap:26px!important; column-gap:26px!important; align-items:start!important; } #panel-overview>.st-grid>.overview-right-stack, #panel-overview>.st-grid>.st-stack:nth-child(2){ width:405px!important; max-width:405px!important; min-width:405px!important; justify-self:end!important; } } @media(min-width:1440px){ #panel-overview>.st-grid{ grid-template-columns:minmax(0,1fr) 420px!important; gap:28px!important; column-gap:28px!important; } #panel-overview>.st-grid>.overview-right-stack, #panel-overview>.st-grid>.st-stack:nth-child(2){ width:420px!important; max-width:420px!important; min-width:420px!important; } } /* Make text more readable without making the UI bulky */ .st-page{font-size:12.5px!important;}
.st-card-title{font-size:14.5px!important;line-height:1.3!important;} .st-card-desc, .st-sec-sub, .st-box-text, .st-pay-sub, .st-notif-sub, .st-comm-sub, .st-quick-sub, .st-privacy-sub{font-size:10.9px!important;line-height:1.4!important;} .st-sec-title, .st-box-title, .st-pay-title, .st-notif-title, .st-comm-title, .st-quick-title, .st-privacy-title, .st-pref-label, .st-act-label{font-size:11.8px!important;line-height:1.3!important;} .st-label,.st-value,.st-info{font-size:11.8px!important;} .st-name{font-size:16.5px!important;} /* Original orange only: no yellow gradient, no different orange */ .st-btn, .st-page .st-btn, .st-date{ background:#ff7a00!important; background-image:none!important; border:1px solid #ff7a00!important; color:#111827!important; border-radius:999px!important; box-shadow:none!important; } .st-btn, .st-page .st-btn{ height:38px!important; min-width:128px!important; padding:0 18px!important; font-size:11.2px!important; font-weight:700!important; } .st-date{ height:38px!important; min-width:190px!important; padding:0 18px!important; font-size:11.5px!important; font-weight:700!important; } .st-btn:hover, .st-btn:focus-visible, .st-btn:active, .st-btn.is-clicked, .st-date:hover, .st-date:focus-visible, .st-date:active, .st-date.is-clicked{ background:#111827!important; background-image:none!important; border-color:#111827!important; color:#fff!important; outline:none!important; } .st-date i{color:#111827!important;} .st-date:hover i,.st-date:focus-visible i,.st-date:active i{color:#fff!important;} .st-outline-btn{ background:#fff!important; background-image:none!important; border:1px solid #ff7a00!important; color:#ff7a00!important; border-radius:999px!important; height:38px!important; min-width:128px!important; padding:0 18px!important; font-size:11.2px!important; font-weight:700!important; } .st-outline-btn:hover, .st-outline-btn:focus-visible, .st-outline-btn:active, .st-outline-btn.is-clicked{ background:#111827!important; border-color:#111827!important; color:#fff!important; } /* Any text-only status/link: no background color ever, even when clicked */ .st-badge, .st-mini, .st-status-pill, .st-inline-pill, .st-link, .st-badge.st-clickable-cover, .st-mini.st-clickable-cover, .st-status-pill.st-clickable-cover, .st-inline-pill.st-clickable-cover, .st-link.st-clickable-cover, .st-link.is-clicked, .st-link:active, .st-link:hover, .st-link:focus-visible{ background:transparent!important; background-image:none!important; border:0!important; border-radius:0!important; box-shadow:none!important; padding:0!important; min-height:0!important; transform:none!important; } .st-link, .st-link.st-clickable-cover, .st-link.is-clicked, .st-link:active{ color:#ff7a00!important; font-size:10.8px!important; font-weight:700!important; } .st-link:hover, .st-link:focus-visible{ color:#111827!important; text-decoration:underline!important; text-underline-offset:3px!important; } .st-badge, .st-mini, .st-status-pill, .st-inline-pill{ font-size:10.8px!important; font-weight:700!important; line-height:1.25!important; } .st-badge.green,.st-mini,.st-status-pill,.st-inline-pill{color:#16a34a!important;} .st-badge.orange,.st-mini.orange,.st-status-pill.orange{color:#ff7a00!important;} .st-mini.gray,.st-status-pill.gray{color:#64748b!important;} .st-badge:hover,.st-mini:hover,.st-status-pill:hover,.st-inline-pill:hover{ text-decoration:underline!important; text-underline-offset:3px!important; }
/* Clean Address Book placement: no individual card boxes, clear columns, equal endpoints */ #panel-overview .overview-profile-box .st-section-line{ margin:18px 0 0!important; background:#111827!important; } #panel-overview .overview-profile-box .st-head:nth-of-type(2){ padding:13px 0 8px!important; margin:0!important; align-items:center!important; } #panel-overview .overview-profile-box .st-address-grid{ display:grid!important; grid-template-columns:repeat(3,minmax(0,1fr))!important; gap:0!important; border-top:1px solid #e5e7eb!important; overflow:hidden!important; align-items:stretch!important; } #panel-overview .overview-profile-box .st-box, #panel-overview .overview-profile-box .st-add-box{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; min-height:128px!important; padding:16px 16px!important; box-sizing:border-box!important; display:flex!important; flex-direction:column!important; justify-content:flex-start!important; } #panel-overview .overview-profile-box .st-box:not(:last-child), #panel-overview .overview-profile-box .st-add-box:not(:last-child){ border-right:1px solid #e5e7eb!important; } #panel-overview .overview-profile-box .st-box:hover, #panel-overview .overview-profile-box .st-add-box:hover{ background:#fff!important; } #panel-overview .overview-profile-box .st-box-title{ margin:0 0 7px!important; font-size:11.8px!important; font-weight:800!important; } #panel-overview .overview-profile-box .st-box .st-mini{ order:0!important; margin-bottom:7px!important; } #panel-overview .overview-profile-box .st-box-text{ margin:0!important; font-size:10.9px!important; line-height:1.38!important; color:#374151!important; } #panel-overview .overview-profile-box .st-kebab{ top:15px!important; right:14px!important; background:transparent!important; border:0!important; color:#64748b!important; } #panel-overview .overview-profile-box .st-kebab:hover, #panel-overview .overview-profile-box .st-kebab:focus-visible, #panel-overview .overview-profile-box .st-kebab:active, #panel-overview .overview-profile-box .st-kebab.is-clicked{ background:transparent!important; color:#111827!important; } #panel-overview .overview-profile-box .st-add-box{ align-items:center!important; justify-content:center!important; text-align:center!important; font-size:11.4px!important; font-weight:800!important; color:#111827!important; } #panel-overview .overview-profile-box .st-add-circle{ width:24px!important; height:24px!important; border:1px solid #e5e7eb!important; background:#fff!important; color:#ff7a00!important; margin-bottom:8px!important; } #panel-overview .overview-profile-box .st-add-box:hover .st-add-circle{ border-color:#ff7a00!important; color:#ff7a00!important; } /* Keep right-side rows aligned, no boxy status backgrounds */ #panel-overview .overview-right-stack{gap:20px!important;} #panel-overview .overview-payment-panel .st-pay-item, #panel-overview .overview-quick-panel .st-quick, #panel-overview .overview-prefs-panel .st-pref-row, #panel-overview .overview-privacy-panel .st-privacy{ width:100%!important; box-sizing:border-box!important; border-left:0!important; border-right:0!important; border-top:0!important; border-radius:0!important; background:transparent!important; } #panel-overview .overview-payment-panel .st-pay-item:hover, #panel-overview .overview-quick-panel .st-quick:hover, #panel-overview .overview-prefs-panel .st-pref-row:hover,
#panel-overview .overview-privacy-panel .st-privacy:hover{ background:transparent!important; color:#111827!important; } /* Icon color mapping remains consistent by icon type; icon only, no bg shape */ .st-orange-ico,.st-ico,.st-add-circle{ background:transparent!important; box-shadow:none!important; } .st-page .fa-envelope,.st-page .fa-comment-dots,.st-page .fa-message,.st-page .fa-bell,.st-page .fa-paper-plane,.st-page .fa-headset{color:#2563eb!important;} .st-page .fa-phone,.st-page .fa-mobile-screen,.st-page .fa-mobile-screen-button{color:#16a34a!important;} .st-page .fa-location-dot,.st-page .fa-house,.st-page .fa-building,.st-page .fa-store,.st-page .fa-truck-fast,.st-page .fa-route,.st-page .fa-box{color:#ff7a00!important;} .st-page .fa-credit-card,.st-page .fa-cc-visa,.st-page .fa-receipt,.st-page .fa-file-invoice,.st-page .fa-wallet,.st-page .fa-peso-sign{color:#7c3aed!important;} .st-page .fa-shield-halved,.st-page .fa-shield,.st-page .fa-user-shield,.st-page .fa-lock,.st-page .fa-circle-check,.st-page .fa-check{color:#16a34a!important;} .st-page .fa-bullhorn,.st-page .fa-percent,.st-page .fa-gift,.st-page .fa-triangle-exclamation{color:#ef4444!important;} .st-page .fa-download{color:#0891b2!important;} .st-page .fa-calendar,.st-page .fa-calendar-days,.st-page .fa-clock{color:#64748b!important;} .st-page .fa-globe{color:#0ea5e9!important;} .st-page .fa-sun,.st-page .fa-palette{color:#f59e0b!important;} .st-page .fa-user,.st-page .fa-address-card{color:#ff7a00!important;} .st-page .fa-folder-open,.st-page .fa-link{color:#7c3aed!important;} @media(max-width:1260px){ #panel-overview>.st-grid{gap:22px!important;} #panel-overview>.st-grid>.overview-right-stack, #panel-overview>.st-grid>.st-stack:nth-child(2){ width:100%!important;max-width:none!important;min-width:0!important; } } @media(max-width:860px){ #panel-overview .overview-profile-box .st-address-grid{grid-template-columns:1fr!important;} #panel-overview .overview-profile-box .st-box:not(:last-child), #panel-overview .overview-profile-box .st-add-box:not(:last-child){ border-right:0!important; border-bottom:1px solid #e5e7eb!important; } } /* ========================================================= FINAL V8: Match My Profile date flow, one Edit button for profile/address, cleaner address book, exact orange buttons ========================================================= */ :root{--st-orange:#ff7a00!important;--st-orange2:#ff7a00!important;--st-primary-orange:#ff7a00!important;} /* My Profile-like header/calendar/date */ .st-title{font-family:'Playfair Display',Georgia,serif!important;font-size:40px!important;line-height:1.2!important;font-weight:700!important;letter-spacing:-.02em!important;text-transform:none!important;color:#111827!important;margin:0 0 3px!important;} .st-title-wrap:before{content:''!important;display:block!important;width:18px!important;height:4px!important;margin-top:8px!important;border-radius:999px!important;background:#ff7a00!important;flex:0 0 auto!important;} .st-subtitle{font-size:12px!important;line-height:1.45!important;color:#6b7280!important;} .st-page .st-date{height:38px!important;min-width:164px!important;padding:0 13px!important;border:1px solid #111827!important;border-radius:8px!important;background:#fff!important;color:#111827!important;font-size:11.5px!important;font-weight:500!important;box-shadow:none!important;cursor:pointer!important;} .st-page .st-date i{color:#111827!important;font-size:14px!important;}
.st-page .st-date:hover,.st-page .st-date:focus-visible,.st-page .st-date:active{background:#111827!important;color:#fff!important;border-color:#111827!important;outline:0!important;} .st-page .st-date:hover i,.st-page .st-date:focus-visible i,.st-page .st-date:active i{color:#fff!important;} /* Keep the original orange buttons but use My Profile hover behavior */ .st-page .st-btn,.st-page button.st-btn{height:38px!important;min-width:112px!important;padding:0 15px!important;border:1px solid #ff7a00!important;border-radius:999px!important;background:#ff7a00!important;color:#111827!important;font-family:'Inter',system-ui,sans-serif!important;font-size:11px!important;font-weight:600!important;box-shadow:none!important;transform:none!important;} .st-page .st-btn:hover,.st-page .st-btn:focus-visible,.st-page .st-btn:active,.st-page .st-btn.is-clicked{background:#111827!important;border-color:#111827!important;color:#fff!important;outline:0!important;box-shadow:none!important;transform:none!important;} .st-page .st-btn:hover i,.st-page .st-btn:focus-visible i,.st-page .st-btn:active i{color:#fff!important;} /* My Profile section flow: grouped Profile + Address, one button only */ #panel-overview .overview-profile-box{border:1px solid #111827!important;border-radius:8px!important;background:#fff!important;box-shadow:none!important;overflow:hidden!important;} #panel-overview .overview-profile-box>.st-body{padding:0!important;} #panel-overview .overview-profile-box>.st-body>.st-head:first-child{padding:18px 18px 0!important;margin:0 0 12px!important;} #panel-overview .overview-profile-box .st-profile{padding:0 18px 18px!important;border-bottom:1px solid #111827!important;grid-template-columns:minmax(0,1fr) minmax(300px,.82fr)!important;gap:18px!important;} #panel-overview .overview-profile-box .st-profile-right{border-left:1px solid #111827!important;padding-left:18px!important;} #panel-overview .overview-profile-box .st-section-line{display:none!important;} #panel-overview .overview-profile-box .st-address-head-clean{padding:16px 0 8px!important;margin:0!important;border:0!important;display:block!important;} #panel-overview .overview-profile-box .st-address-head-clean .st-card-title{padding-left:0!important;} #panel-overview .overview-profile-box .st-address-head-clean{padding-left:0!important;} #panel-overview .overview-profile-box .st-address-grid{display:grid!important;grid-template-columns:repeat(3,minmax(0,1fr))!important;gap:0!important;border-top:0!important;border-bottom:0!important;align-items:stretch!important;} #panel-overview .overview-profile-box .st-address-head-clean, #panel-overview .overview-profile-box .st-address-grid{margin-left:0!important;margin-right:0!important;} #panel-overview .overview-profile-box .st-address-head-clean{padding-left:0!important;} #panel-overview .overview-profile-box .st-address-head-clean h2{padding-left:0!important;} #panel-overview .overview-profile-box>.st-body>.st-address-head-clean, #panel-overview .overview-profile-box>.st-body>.st-address-grid{padding-left:18px!important;padding-right:18px!important;} #panel-overview .overview-profile-box>.st-body>.st-address-grid{padding-bottom:18px!important;} #panel-overview .overview-profile-box .st-box,
#panel-overview .overview-profile-box .st-add-box{border:0!important;border-radius:0!important;background:transparent!important;box-shadow:none!important;min-height:108px!important;padding:10px 14px!important;display:flex!important;flex-direction:column!important;justify-content:flex-start!important;cursor:default!important;} #panel-overview .overview-profile-box .st-box:first-child{padding-left:0!important;} #panel-overview .overview-profile-box .st-add-box:last-child{padding-right:0!important;align-items:center!important;justify-content:center!important;text-align:center!important;} #panel-overview .overview-profile-box .st-box:not(:last-child), #panel-overview .overview-profile-box .st-add-box:not(:last-child){border-right:1px solid #e5e7eb!important;} #panel-overview .overview-profile-box .st-box:hover, #panel-overview .overview-profile-box .st-add-box:hover{background:transparent!important;color:#111827!important;border-color:#e5e7eb!important;} #panel-overview .overview-profile-box .st-add-box:hover .st-add-circle{background:#fff!important;border-color:#e5e7eb!important;color:#ff7a00!important;} #panel-overview .overview-profile-box .st-box-title{font-size:12px!important;font-weight:700!important;margin:0 0 6px!important;} #panel-overview .overview-profile-box .st-box-text{font-size:11px!important;line-height:1.42!important;color:#374151!important;margin:0!important;} #panel-overview .overview-profile-box .st-kebab{color:#64748b!important;} #panel-overview .overview-profile-box .st-kebab:hover{background:transparent!important;color:#111827!important;} /* More balanced left-right spacing */ @media(min-width:1261px){#panel-overview>.st-grid{grid-template-columns:minmax(0,1fr) 435px!important;gap:26px!important;align-items:start!important;}#panel-overview .overview-right-stack{width:100%!important;max-width:435px!important;justify-self:stretch!important;}#panel-overview .overview-right-stack>*{width:100%!important;max-width:100%!important;}} /* Slightly larger readable overview text */ #panel-overview .st-card-title{font-size:14px!important;line-height:1.28!important;} #panel-overview .st-card-desc{font-size:11px!important;line-height:1.35!important;} #panel-overview .st-notif-title,#panel-overview .st-comm-title,#panel-overview .st-pay-title,#panel-overview .st-quick-title,#panel-overview .st-privacy-title,#panel-overview .st-pref-label,#panel-overview .st-act-label{font-size:12px!important;} #panel-overview .st-notif-sub,#panel-overview .st-comm-sub,#panel-overview .st-pay-sub,#panel-overview .st-quick-sub,#panel-overview .st-privacy-sub,#panel-overview .st-act-val{font-size:10.8px!important;} /* Colored inline labels: no bg even on hover/click */ .st-page .st-badge,.st-page .st-mini,.st-page .st-status-pill,.st-page .st-inline-pill{background:transparent!important;border:0!important;border-radius:0!important;padding:0!important;box-shadow:none!important;} .st-page .st-badge:hover,.st-page .st-mini:hover,.st-page .st-status-pill:hover,.st-page .st-inline-pill:hover{background:transparent!important;text-decoration:underline!important;text-underline-offset:3px!important;color:inherit!important;} .st-page .st-link,.st-page .st-manage{background:transparent!important;border:0!important;color:#ff7a00!important;border-radius:0!important;box-shadow:none!important;}
.st-page .st-link:hover,.st-page .st-link:focus-visible,.st-page .st-link:active,.st-page .st-manage:hover,.st-page .st-manage:focus-visible{background:transparent!important;color:#111827!important;text-decoration:underline!important;text-underline-offset:3px!important;} /* Icon colors remain type-consistent and without background shapes */ #panel-overview .st-orange-ico{background:transparent!important;border:0!important;width:18px!important;height:18px!important;border-radius:0!important;} #panel-overview .st-ico{background:transparent!important;border:0!important;} #panel-overview .fa-envelope,#panel-overview .fa-comment-dots,#panel-overview .fa-bell,#panel-overview .fa-headset{color:#2563eb!important;} #panel-overview .fa-phone{color:#16a34a!important;} #panel-overview .fa-location-dot,#panel-overview .fa-truck-fast,#panel-overview .fa-route,#panel-overview .fa-box,#panel-overview .fa-calendar-days{color:#ff7a00!important;} #panel-overview .fa-lock,#panel-overview .fa-shield-halved,#panel-overview .fa-user-shield{color:#16a34a!important;} #panel-overview .fa-bullhorn,#panel-overview .fa-percent{color:#dc2626!important;} #panel-overview .fa-credit-card,#panel-overview .fa-wallet,#panel-overview .fa-cc-visa{color:#7c3aed!important;} #panel-overview .fa-user,#panel-overview .fa-building{color:#f97316!important;} #panel-overview .fa-folder-open{color:#0891b2!important;} #panel-overview .fa-link{color:#db2777!important;} #panel-overview .fa-lightbulb{color:#ca8a04!important;} #panel-overview .overview-quick-panel .st-quick:hover .st-orange-ico i, #panel-overview .overview-privacy-panel .st-privacy:hover i{color:#fff!important;} @media(max-width:1260px){#panel-overview .overview-profile-box .st-profile{grid-template-columns:1fr!important;}#panel-overview .overview-profile-box .st-profile-right{border-left:0!important;border-top:1px solid #111827!important;padding-left:0!important;padding-top:14px!important;}#panel-overview .overview-profile-box .st-address-grid{grid-template-columns:1fr!important;}#panel-overview .overview-profile-box .st-box:not(:last-child),#panel-overview .overview-profile-box .st-add-box:not(:last-child){border-right:0!important;border-bottom:1px solid #e5e7eb!important;}#panel-overview .overview-profile-box .st-box:first-child{padding-left:14px!important;}#panel-overview .overview-profile-box .st-add-box:last-child{padding-right:14px!important;}} /* FINAL ADDRESS + FLOW FIX 2026-06-08 */ :root{--st-orange:#ff7a00!important;--st-orange2:#ff7a00!important;--st-orange3:#fff3e6!important;--st-blue:#2563eb;--st-green:#16a34a;--st-red:#ef4444;--st-violet:#7c3aed;--st-cyan:#0891b2;--st-gray-icon:#64748b} @media(min-width:1261px){#panel-overview>.st-grid{grid-template-columns:minmax(0,1fr) 410px!important;gap:24px!important;align-items:start!important}#panel-overview>.st-grid>.st-stack:nth-child(2){max-width:410px!important;width:410px!important}} #panel-overview .overview-profile-box .st-section-line{display:none!important}.st-address-head-clean{padding-top:20px!important;margin-top:18px!important;border-top:0!important}.st-address-head-clean h2{margin:0!important} #panel-overview .overview-profile-box .st-address-grid{display:grid!important;grid-template-columns:minmax(0,1fr) minmax(0,1fr) minmax(170px,.68fr)!important;gap:0!important;margin-top:12px!important;border:1px solid #e5e7eb!important;border-radius:11px!important;overflow:hidden!important;background:#fff!important}
#panel-overview .overview-profile-box .st-box,#panel-overview .overview-profile-box .st-add-box{min-height:132px!important;padding:18px 20px!important;border:0!important;border-right:1px solid #e5e7eb!important;border-radius:0!important;background:#fff!important;box-shadow:none!important;display:flex!important;flex-direction:column!important;justify-content:flex-start!important;align-items:flex-start!important;gap:6px!important}.st-address-grid>*:last-child{border-right:0!important} #panel-overview .overview-profile-box .st-box-title{font-size:12px!important;line-height:1.25!important;margin:0!important;color:#111827!important}.st-box-text{font-size:11px!important;line-height:1.45!important;margin:2px 0 0!important;color:#374151!important}.st-address-placeholder{align-items:center!important;justify-content:center!important;text-align:center!important;font-size:11.5px!important;font-weight:700!important;color:#111827!important;cursor:pointer!important}.st-add-circle{width:25px!important;height:25px!important;border-radius:999px!important;border:1px solid #e5e7eb!important;color:#ff7a00!important;background:#fff!important}.st-kebab{top:14px!important;right:14px!important;color:#64748b!important}.st-kebab:hover,.st-kebab:focus-visible{background:transparent!important;color:#ff7a00!important} .st-mini,.st-badge{background:transparent!important;border:0!important;padding:0!important;border-radius:0!important;font-size:10.5px!important;font-weight:700!important;box-shadow:none!important}.st-mini.orange,.st-badge.orange{color:#ff7a00!important}.st-mini.green,.st-badge.green,.st-status-pill{background:transparent!important;border:0!important;color:#16a34a!important;padding:0!important}.st-status-pill.gray{background:transparent!important;color:#64748b!important}.st-link,.st-manage{background:transparent!important;border:0!important;color:#ff7a00!important;border-radius:0!important;padding:0!important;min-height:0!important;font-size:10.8px!important;font-weight:700!important}.st-link:hover,.st-link:focus-visible,.st-manage:hover,.st-manage:focus-visible{background:transparent!important;color:#111827!important;text-decoration:underline!important}.st-link.st-clickable-cover,.st-manage.st-clickable-cover{background:transparent!important;color:#ff7a00!important} .st-btn,.st-page .st-btn{background:#ff7a00!important;border:1px solid #ff7a00!important;color:#111827!important;border-radius:999px!important;height:40px!important;min-width:128px!important;font-size:11.5px!important;font-weight:700!important}.st-btn:hover,.st-btn:focus-visible,.st-btn:active,.st-btn.is-clicked{background:#111827!important;border-color:#111827!important;color:#fff!important}.st-date{height:42px!important;min-width:188px!important;border:1px solid #111827!important;border-radius:8px!important;background:#fff!important;color:#111827!important;font-size:12px!important;font-weight:700!important}.st-date i{color:#111827!important}.st-date:hover,.st-date:focus-visible{background:#111827!important;color:#fff!important}.st-date:hover i,.st-date:focus-visible i{color:#fff!important} .st-card-title{font-size:14px!important}.st-card-desc,.st-sec-sub,.st-quick-sub,.st-privacy-sub,.st-comm-sub,.st-notif-sub{font-size:10.8px!important;line-height:1.35!important}.st-sec-title,.st-quick-title,.st-privacy-title,.st-comm-title,.st-notif-title,.st-pref-label,.st-act-label{font-size:11.5px!important}.st-value,.st-label,.st-info,.st-act-val{font-size:11.2px!important}
.st-ico,.st-orange-ico{background:transparent!important;border:0!important;width:20px!important;height:20px!important;border-radius:0!important;flex:0 0 20px!important}.st-ico i,.st-orange-ico i{font-size:15px!important}.fa-envelope,.fa-message,.fa-comment-dots,.fa-bell{color:#2563eb!important}.fa-phone{color:#16a34a!important}.fa-location-dot,.fa-truck-fast,.fa-route,.fa-store,.fa-house{color:#ff7a00!important}.fa-credit-card,.fa-cc-visa,.fa-wallet,.fa-file-invoice,.fa-receipt{color:#7c3aed!important}.fa-shield-halved,.fa-user-shield,.fa-lock,.fa-circle-check,.fa-check{color:#16a34a!important}.fa-bullhorn,.fa-percent,.fa-triangle-exclamation{color:#ef4444!important}.fa-calendar,.fa-calendar-days,.fa-clock{color:#64748b!important}.fa-download,.fa-folder-open{color:#0891b2!important}.fa-user,.fa-id-card,.fa-building{color:#ff7a00!important} .st-pay-item,.st-quick,.st-privacy,.st-comm-item,.st-notif-item,.st-pref-row,.st-activity-row{min-height:54px!important}.st-pay-title,.st-pay-sub{font-size:11px!important}.st-pay-item{border:0!important;border-bottom:1px solid #e5e7eb!important;border-radius:0!important;background:transparent!important;padding:10px 0!important}.st-pay-item:hover{background:transparent!important}.st-card-logo{background:#fff!important;border:1px solid #e5e7eb!important;border-radius:7px!important}.overview-quick-panel .st-quick,.overview-privacy-panel .st-privacy{border:0!important;border-bottom:1px solid #e5e7eb!important;border-radius:0!important;background:transparent!important;padding:10px 0!important}.overview-quick-panel .st-quick:hover,.overview-privacy-panel .st-privacy:hover{background:transparent!important;color:#111827!important}.overview-quick-panel .st-quick:hover .st-quick-title,.overview-quick-panel .st-quick:hover .st-quick-sub,.overview-privacy-panel .st-privacy:hover .st-privacy-title,.overview-privacy-panel .st-privacy:hover .st-privacy-sub{color:#111827!important} @media(max-width:1260px){#panel-overview>.st-grid{grid-template-columns:1fr!important}#panel-overview>.st-grid>.st-stack:nth-child(2){max-width:none!important;width:100%!important}#panel-overview .overview-profile-box .st-address-grid{grid-template-columns:1fr!important}#panel-overview .overview-profile-box .st-box,#panel-overview .overview-profile-box .st-add-box{border-right:0!important;border-bottom:1px solid #e5e7eb!important}.st-address-grid>*:last-child{border-bottom:0!important}} 
/* =========================================================
   FINAL USER REQUEST PATCH: orange buttons, green save-only,
   no , plain non-button hover, address edit-only, and
   Settings/Profile edit flow without moving existing layout.
   ========================================================= */
:root{
    --st-orange:#ff7a00!important;
    --st-orange2:#ff7a00!important;
    --st-orange3:#fff3e6!important;
    --st-green:#16a34a!important;
    --st-save:#16a34a!important;
    --st-hover-dark:#111827!important;
}

/* Exact orange touch used by Contact/Services buttons; same size/shape everywhere. */
.st-page .st-btn,
.st-page button.st-btn{
    background:#ff7a00!important;
    background-image:none!important;
    border:1px solid #ff7a00!important;
    color:#111827!important;
    height:40px!important;
    min-width:128px!important;
    padding:0 18px!important;
    border-radius:999px!important;
    font-family:'Inter',system-ui,sans-serif!important;
    font-size:11.5px!important;
    font-weight:700!important;
    line-height:1!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:8px!important;
    white-space:nowrap!important;
    box-shadow:none!important;
    transform:none!important;
}
.st-page .st-btn:hover,
.st-page .st-btn:focus-visible,
.st-page .st-btn:active,
.st-page .st-btn.is-clicked{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:none!important;
    box-shadow:none!important;
    transform:none!important;
}
.st-page .st-btn:hover i,
.st-page .st-btn:focus-visible i,
.st-page .st-btn:active i{color:#fff!important;}

/* Outline buttons follow the same sizing; hover only turns black/white. */
.st-page .st-outline-btn,
.st-page button.st-outline-btn{
    background:#fff!important;
    border:1px solid #ff7a00!important;
    color:#ff7a00!important;
    height:40px!important;
    min-width:128px!important;
    padding:0 18px!important;
    border-radius:999px!important;
    font-family:'Inter',system-ui,sans-serif!important;
    font-size:11.5px!important;
    font-weight:700!important;
    box-shadow:none!important;
    transform:none!important;
}
.st-page .st-outline-btn:hover,
.st-page .st-outline-btn:focus-visible,
.st-page .st-outline-btn:active{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:none!important;
}

/* SAVE/SAVED/SAVE PROFILE buttons: green only, and hidden until an edit happens. */
.st-page .st-save-action,
.st-page button.st-save-action{
    background:#16a34a!important;
    border-color:#16a34a!important;
    color:#fff!important;
}
.st-page .st-save-action:hover,
.st-page .st-save-action:focus-visible,
.st-page .st-save-action:active{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
}
.st-page .st-save-hidden{display:none!important;}

/* Right-side buttons stay centered and equal. */
.st-section-side .st-btn,
.st-setting-side .st-btn,
.st-notif-side .st-btn,
.st-pay-side .st-btn,
.st-profile-side .st-btn,
.overview-right-stack .st-btn{
    margin-left:auto!important;
    margin-right:auto!important;
}

/* Non-button / text-only hovers: no background shape, only text/icon hover color. */
.st-page .st-link,
.st-page .st-manage,
.st-page .st-setting-action,
.st-page .st-no-box-item,
.st-page .st-right-metric,
.st-page .st-pref-row,
.st-page .st-activity-row,
.st-page .st-comm-item,
.st-page .st-notif-item{
    background:transparent!important;
    box-shadow:none!important;
    transform:none!important;
}
.st-page .st-link:hover,
.st-page .st-link:focus-visible,
.st-page .st-link:active,
.st-page .st-manage:hover,
.st-page .st-manage:focus-visible,
.st-page .st-setting-action:hover,
.st-page .st-setting-action:focus-visible,
.st-page .st-no-box-item:hover,
.st-page .st-right-metric:hover,
.st-page .st-pref-row:hover,
.st-page .st-activity-row:hover,
.st-page .st-comm-item:hover,
.st-page .st-notif-item:hover{
    background:transparent!important;
    border-radius:0!important;
    box-shadow:none!important;
    transform:none!important;
    color:#ff7a00!important;
    padding-left:0!important;
    padding-right:0!important;
}
.st-page .st-setting-action:hover span,
.st-page .st-setting-action:hover i{color:#ff7a00!important;}

/* Notification Quick Actions and Billing Help: no bg shape; hover color only. */
#panel-notifications .st-notif-side .st-action-list .st-setting-action,
#panel-payments .st-pay-side .st-action-list .st-setting-action{
    border:0!important;
    border-bottom:1px solid #e8ebf0!important;
    border-radius:0!important;
    background:transparent!important;
    padding:10px 0!important;
}
#panel-notifications .st-notif-side .st-action-list .st-setting-action:hover,
#panel-payments .st-pay-side .st-action-list .st-setting-action:hover{
    background:transparent!important;
    color:#ff7a00!important;
}

/* Addresses panel: remove duplicate/delete and keep only Edit, aligned evenly. */
#panel-addresses .st-row-actions .st-link{display:none!important;}
#panel-addresses .st-address-row{
    grid-template-columns:40px minmax(0,1fr) minmax(210px,260px)!important;
    align-items:center!important;
}
#panel-addresses .st-row-actions{
    justify-content:flex-end!important;
    align-items:center!important;
    gap:12px!important;
}
#panel-addresses .st-row-actions .st-outline-btn{
    min-width:112px!important;
    height:38px!important;
}
#panel-addresses .st-map-mini{
    width:118px!important;
    min-width:118px!important;
    height:66px!important;
}

/* Profile Settings: compact My Profile-like flow; do not enlarge fonts. */
#panel-profile .st-card-title,
#panel-security .st-card-title,
#panel-notifications .st-card-title,
#panel-payments .st-card-title,
#panel-addresses .st-card-title,
#panel-preferences .st-card-title,
#panel-privacy .st-card-title{
    font-size:14px!important;
    line-height:1.3!important;
}
#panel-profile .st-card-desc,
#panel-security .st-card-desc,
#panel-notifications .st-card-desc,
#panel-payments .st-card-desc,
#panel-addresses .st-card-desc,
#panel-preferences .st-card-desc,
#panel-privacy .st-card-desc{
    font-size:10.5px!important;
    line-height:1.35!important;
}
#panel-profile .st-input,
#panel-profile .st-textarea,
#panel-preferences .st-input,
#panel-privacy select{
    min-height:38px!important;
    font-size:10.8px!important;
    border-radius:10px!important;
}

/* On/off switches: consistent green when enabled. */
.st-switch input:checked + .st-slider{background:#16a34a!important;}
.st-slider{background:#cfd5dd!important;}

/* Consistent semantic icon colors, icon only; no background shape. */
.st-page .st-orange-ico,
.st-page .st-ico{
    background:transparent!important;
    border:0!important;
    border-radius:0!important;
    box-shadow:none!important;
    width:20px!important;
    height:20px!important;
    flex:0 0 20px!important;
}
.st-page .fa-envelope,.st-page .fa-message,.st-page .fa-comment-dots,.st-page .fa-bell,.st-page .fa-paper-plane,.st-page .fa-headset{color:#2563eb!important;}
.st-page .fa-phone,.st-page .fa-mobile-screen,.st-page .fa-mobile-screen-button{color:#16a34a!important;}
.st-page .fa-location-dot,.st-page .fa-house,.st-page .fa-building,.st-page .fa-store,.st-page .fa-truck-fast,.st-page .fa-route,.st-page .fa-box{color:#ff7a00!important;}
.st-page .fa-credit-card,.st-page .fa-cc-visa,.st-page .fa-receipt,.st-page .fa-file-invoice,.st-page .fa-wallet,.st-page .fa-peso-sign{color:#7c3aed!important;}
.st-page .fa-shield-halved,.st-page .fa-shield,.st-page .fa-user-shield,.st-page .fa-lock,.st-page .fa-circle-check,.st-page .fa-check{color:#16a34a!important;}
.st-page .fa-bullhorn,.st-page .fa-percent,.st-page .fa-gift,.st-page .fa-triangle-exclamation{color:#ef4444!important;}
.st-page .fa-download,.st-page .fa-folder-open{color:#0891b2!important;}
.st-page .fa-calendar,.st-page .fa-calendar-days,.st-page .fa-clock{color:#64748b!important;}
.st-page .fa-globe{color:#0ea5e9!important;}
.st-page .fa-sun,.st-page .fa-palette{color:#f59e0b!important;}
.st-page .fa-user,.st-page .fa-address-card,.st-page .fa-id-card{color:#ff7a00!important;}

@media(max-width:860px){
    #panel-addresses .st-address-row{grid-template-columns:1fr!important;}
    #panel-addresses .st-row-actions{justify-content:center!important;}
    #panel-addresses .st-map-mini{width:100%!important;}
}
</style>

{{-- OVERVIEW JS --}}
<script id="settings-overview-js">
/* OVERVIEW JS + GLOBAL SETTINGS JS. Complete script kept once only para hindi maduplicate listeners/functions. */
const settingsSaveRoute=@json(Route::has('settings.save') ? route('settings.save') : ''); const settingsProfileRoute=@json(Route::has('profile.update') ? route('profile.update') : ''); const settingsDisplayEmail=@json($settingsEmail ?: 'Not set'); const settingsDisplayPhone=@json($settingsPhone ?: 'Not set'); const settingsCsrf=document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || @json(csrf_token()); document.addEventListener('DOMContentLoaded',function(){ const tabs=document.querySelectorAll('.st-tab'),panels=document.querySelectorAll('.st-panel'),jumps=document.querySelectorAll('[data-tab-jump]'),opens=document.querySelectorAll('[data-modal-open]'),closes=document.querySelectorAll('[data-modal-close]'); function activateTab(name,updateUrl=true){tabs.forEach(b=>b.classList.toggle('active',b.dataset.tab===name));panels.forEach(p=>p.classList.remove('active'));const panel=document.getElementById('panel-'+name);if(panel)panel.classList.add('active');if(updateUrl)history.replaceState(null,'',window.location.pathname+'#'+name);window.scrollTo({top:0,behavior:'smooth'})} tabs.forEach(b=>b.addEventListener('click',()=>activateTab(b.dataset.tab))); jumps.forEach(b=>b.addEventListener('click',()=>activateTab(b.dataset.tabJump))); opens.forEach(b=>b.addEventListener('click',()=>openSettingsModal(b.dataset.modalOpen))); closes.forEach(b=>b.addEventListener('click',closeAllSettingsModals)); document.addEventListener('keydown',e=>{if(e.key==='Escape')closeAllSettingsModals()}); document.querySelectorAll('.st-select[data-setting-name]').forEach(select=>{ const key='printify_setting_'+select.dataset.settingName.toLowerCase().replace(/\s+/g,'_'); const saved=localStorage.getItem(key); if(saved){Array.from(select.options).forEach(o=>{if(o.value===saved||o.text===saved)select.value=o.value})} select.addEventListener('change',()=>{localStorage.setItem(key,select.value);persistSettingsValue('preferences',key,select.value,select.dataset.settingName)}); }); document.querySelectorAll('button,.st-select').forEach(el=>{
el.addEventListener('click',()=>{el.classList.add('is-clicked','st-clickable-cover');setTimeout(()=>el.classList.remove('is-clicked','st-clickable-cover'),180)}) }); document.querySelectorAll('.st-pref-row').forEach(row=>{ row.addEventListener('click',e=>{if(e.target.tagName.toLowerCase()==='select')return;const s=row.querySelector('select');if(s){s.focus();row.classList.add('is-clicked');setTimeout(()=>row.classList.remove('is-clicked'),180)}}) }); const initialTab=(window.location.hash||'').replace('#','');if(initialTab&&document.getElementById('panel-'+initialTab))activateTab(initialTab,false); window.activateSettingsTab=activateTab; }); function openSettingsModal(id){const m=document.getElementById(id);if(!m)return;m.classList.add('active');document.body.style.overflow='hidden'} function closeAllSettingsModals(){document.querySelectorAll('.st-modal').forEach(m=>m.classList.remove('active'));document.body.style.overflow=''} function splitSettingsName(name){const parts=(name||'').trim().split(/\s+/).filter(Boolean);return{first_name:parts.shift()||'',last_name:parts.join(' ')}} function setProfileDisplays(data){const fallback='Not set';profileDisplayName.textContent=data.name||fallback;profileDisplayEmail.textContent=data.email||fallback;profileDisplayPhone.textContent=data.phone||fallback;profileDisplayBirth.textContent=data.birthdate||fallback;profileDisplayCompany.textContent=data.company||fallback} async function saveSettingsProfilePayload(payload){if(!settingsProfileRoute){showSettingsToast('Profile save route is unavailable.');return false}try{const response=await fetch(settingsProfileRoute,{method:'PATCH',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':settingsCsrf},body:JSON.stringify(payload)});if(!response.ok)throw new Error('Profile save failed');return true}catch(e){console.warn('Profile save failed.',e);showSettingsToast('Profile was not saved. Please check the details.');return false}} async function saveProfileModal(e){e.preventDefault();const n=profileNameInput.value.trim(),em=profileEmailInput.value.trim(),p=profilePhoneInput.value.trim(),b=profileBirthInput.value.trim(),c=profileCompanyInput.value.trim(),parts=splitSettingsName(n);const payload={name:n,first_name:parts.first_name,last_name:parts.last_name,email:em,phone:p,birthdate:b,company:c};if(!await saveSettingsProfilePayload(payload))return;setProfileDisplays(payload);const panelInputs=document.querySelectorAll('#panel-profile .st-input');if(panelInputs.length){panelInputs[0].value=n;panelInputs[1].value=em;panelInputs[2].value=p;panelInputs[3].value=c}updateOverviewAddress('Home Address',profilePrimaryAddressInput?.value||'');updateOverviewAddress('Work',profileWorkAddressInput?.value||'');window.dispatchEvent(new CustomEvent('printify-profile-updated',{detail:{name:n,initials:n? n.split(/\s+/).map(part=>part[0]).join('').slice(0,2).toUpperCase():''}}));closeAllSettingsModals();showSettingsToast('Profile and address details updated successfully.')}
async function saveProfilePanelSettings(){const inputs=document.querySelectorAll('#panel-profile .st-input');if(!inputs.length)return;const n=inputs[0].value.trim(),em=inputs[1].value.trim(),p=inputs[2].value.trim(),c=inputs[3].value.trim(),b=profileBirthInput.value.trim(),parts=splitSettingsName(n);const payload={name:n,first_name:parts.first_name,last_name:parts.last_name,email:em,phone:p,birthdate:b,company:c};if(!await saveSettingsProfilePayload(payload))return;profileNameInput.value=n;profileEmailInput.value=em;profilePhoneInput.value=p;profileCompanyInput.value=c;setProfileDisplays(payload);window.dispatchEvent(new CustomEvent('printify-profile-updated',{detail:{name:n,initials:n? n.split(/\s+/).map(part=>part[0]).join('').slice(0,2).toUpperCase():''}}));showSettingsToast('Profile settings saved.')} function saveGenericSettings(e,msg){e.preventDefault();closeAllSettingsModals();showSettingsToast(msg||'Settings saved successfully.')} async function persistSettingsValue(group,key,value,label){ localStorage.setItem('printify_setting_'+group+'_'+key,value); if(settingsSaveRoute){ try{ const response=await fetch(settingsSaveRoute,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':settingsCsrf},body:JSON.stringify({group,key,value})}); if(response.ok){showSettingsToast((label||'Setting')+' saved successfully.');return} }catch(e){console.warn('Settings backend sync skipped.',e)} } showSettingsToast((label||'Setting')+' saved locally.'); } function toggleSettingMessage(input,label){const key=label.toLowerCase().replace(/[^a-z0-9]+/g,'_').replace(/^_|_$/g,'');const value=input.checked?'enabled':'disabled';localStorage.setItem('printify_toggle_'+key,value);persistSettingsValue('toggles',key,value,label)} function copySettingsText(text){if(navigator.clipboard){navigator.clipboard.writeText(text).then(()=>showSettingsToast('Copied: '+text)).catch(()=>showSettingsToast('Copy failed.'))}else showSettingsToast('Copied: '+text)} function openPhotoPicker(){const input=document.getElementById('settingsPhotoInput');if(input)input.click()} document.addEventListener('change',function(e){if(e.target&&e.target.id==='settingsPhotoInput'&&e.target.files&&e.target.files[0]){const reader=new FileReader();reader.onload=function(ev){document.querySelectorAll('.st-avatar').forEach(img=>img.src=ev.target.result);window.dispatchEvent(new CustomEvent('printify-profile-updated',{detail:{photo:ev.target.result}}));showSettingsToast('Profile photo preview updated. Save from My Profile to keep it on every device.')};reader.readAsDataURL(e.target.files[0])}}); function openUtilityModal(title,desc,body){const t=document.getElementById('settingsUtilityTitle'),d=document.getElementById('settingsUtilityDesc'),b=document.getElementById('settingsUtilityBody');if(t)t.textContent=title;if(d)d.textContent=desc;if(b)b.innerHTML=body;openSettingsModal('settingsUtilityModal')} function openPaymentActions(label){openUtilityModal(label+' Actions','Manage this saved payment method.','<div class="st-list"><button type="button" class="st-btn" onclick="showSettingsToast(\''+label+' set as primary.\');closeAllSettingsModals()">Set as Primary</button><button type="button" class="st-btn" onclick="closeAllSettingsModals();openSettingsModal(\'paymentModal\')">Update Payment</button><button type="button" class="st-btn" onclick="showSettingsToast(\''+label+' removed.\');closeAllSettingsModals()">Remove Payment</button></div>')}
function openSavedFilesPanel(){openUtilityModal('Saved Designs / Files','Access uploaded design files connected to your account.','<div class="st-list"><div class="st-pay-item"><div><p class="st-pay-title">Business Card Layout</p><p class="st-pay-sub">Ready for reorder · PDF</p></div><button type="button" class="st-btn" onclick="showSettingsToast(\'Business Card Layout opened.\')">Open</button></div><div class="st-pay-item"><div><p class="st-pay-title">Sticker Draft</p><p class="st-pay-sub">Last updated recently · PNG</p></div><button type="button" class="st-btn" onclick="showSettingsToast(\'Sticker Draft opened.\')">Open</button></div></div>')} function openConnectedAccountsPanel(){openUtilityModal('Connected Accounts','Link or review accounts connected to your Printify & Co. profile.','<div class="st-list"><div class="st-pay-item"><div><p class="st-pay-title">Google</p><p class="st-pay-sub">Connected for sign-in.</p></div><span class="st-mini">Connected</span></div><div class="st-pay-item"><div><p class="st-pay-title">Facebook</p><p class="st-pay-sub">Not linked.</p></div><button type="button" class="st-btn" onclick="showSettingsToast(\'Facebook linking started.\')">Connect</button></div></div>')} function openActivityLogPanel(){openUtilityModal('Account Activity','Recent account activity and security events.','<div class="st-list"><div class="st-activity-row"><div class="st-activity-left"><span class="st-ico"><i class="fa-regular fa-clock"></i></span><span class="st-act-label">Login</span></div><div class="st-act-val">May 29, 2026 8:15 AM</div></div><div class="st-activity-row"><div class="st-activity-left"><span class="st-ico"><i class="fa-solid fa-user-pen"></i></span><span class="st-act-label">Profile Viewed</span></div><div class="st-act-val">Today</div></div></div>')} function openSessionManagerPanel(){openUtilityModal('Active Sessions','Manage devices currently signed in to your account.','<div class="st-list"><div class="st-pay-item"><div><p class="st-pay-title">Chrome on Windows</p><p class="st-pay-sub">Makati City · Current device</p></div><span class="st-mini">Active</span></div><div class="st-pay-item"><div><p class="st-pay-title">Mobile Browser</p><p class="st-pay-sub">Last active recently</p></div><button type="button" class="st-btn" onclick="showSettingsToast(\'Mobile browser session removed.\')">Remove</button></div></div>')} function openRecoveryPanel(){openUtilityModal('Recovery Options','Manage recovery email, phone, and backup access.','<div class="st-list"><div class="st-pay-item"><div><p class="st-pay-title">Recovery Email</p><p class="st-pay-sub">'+settingsDisplayEmail+'</p></div><span class="st-mini">Verified</span></div><div class="st-pay-item"><div><p class="st-pay-title">Recovery Phone</p><p class="st-pay-sub">'+settingsDisplayPhone+'</p></div><span class="st-mini">Verified</span></div><button type="button" class="st-btn" onclick="persistSettingsValue(\'security\',\'recovery_reviewed\',new Date().toISOString(),\'Recovery options\');closeAllSettingsModals()">Save Recovery Review</button></div>')}
function openPasswordPanel(){openUtilityModal('Change Password','Update your password securely.','<form onsubmit="saveGenericSettings(event,\'Password updated successfully.\')"><div class="st-field"><label>Current Password</label><input class="st-input" type="password" required></div><div class="st-field" style="margin-top:12px"><label>New Password</label><input class="st-input" type="password" required></div><div class="st-actions"><button type="button" class="st-btn" onclick="closeAllSettingsModals()">Cancel</button><button type="submit" class="st-btn">Save Password</button></div></form>')} function openTrustedDevicesPanel(){openUtilityModal('Trusted Devices','Review devices with saved login access.','<div class="st-list"><div class="st-pay-item"><div><p class="st-pay-title">Windows Desktop</p><p class="st-pay-sub">Trusted · Current device</p></div><span class="st-mini">Trusted</span></div><div class="st-pay-item"><div><p class="st-pay-title">Android Phone</p><p class="st-pay-sub">Trusted device</p></div><button type="button" class="st-btn" onclick="showSettingsToast(\'Android Phone removed from trusted devices.\')">Remove</button></div></div>')} function requestDataExport(){localStorage.setItem('printify_data_export_requested_at',new Date().toISOString());openUtilityModal('Data Export Requested','Your downloadable copy request has been recorded.','<div class="st-box" style="min-height:auto"><h3 class="st-box-title" style="margin-top:0">Request submitted</h3><p class="st-box-text">A copy of your account data will be prepared for download once available.</p></div><div class="st-actions"><button type="button" class="st-btn" onclick="closeAllSettingsModals()">Done</button></div>');showSettingsToast('Data download request submitted.')} function openDeactivatePanel(){openUtilityModal('Deactivate Account','Confirm before deactivating your account.','<div class="st-box" style="min-height:auto"><h3 class="st-box-title" style="margin-top:0;color:var(--st-danger)">Deactivate account?</h3><p class="st-box-text">This will hide your account access until it is restored by support.</p></div><div class="st-actions"><button type="button" class="st-btn" onclick="closeAllSettingsModals()">Cancel</button><button type="button" class="st-btn" onclick="showSettingsToast(\'Deactivate request prepared.\');closeAllSettingsModals()">Continue</button></div>')} function showSettingsToast(msg){const t=document.getElementById('settingsToast');if(!t)return;t.textContent=msg;t.classList.add('show');clearTimeout(window.settingsToastTimeout);window.settingsToastTimeout=setTimeout(()=>t.classList.remove('show'),2200)} function getAddressBoxes(){return Array.from(document.querySelectorAll('#panel-overview .st-address-grid .st-box'))} function normalizeAddressText(text){return (text||'').split(/\n+/).map(x=>x.trim()).filter(Boolean).join('<br>')} function updateOverviewAddress(label,text){const boxes=getAddressBoxes();let box=boxes.find(b=>(b.querySelector('.st-box-title')?.textContent||'').trim()===label);if(!box&&boxes.length)box=boxes[0];if(!box)return;box.querySelector('.st-box-title').textContent=label;box.querySelector('.st-box-text').innerHTML=normalizeAddressText(text);localStorage.setItem('printify_address_'+label.toLowerCase().replace(/[^a-z0-9]+/g,'_'),text)} function openNewAddressModal(){addressModeInput.value='new';addressTargetInput.value='';addressLabelInput.value='';addressFullInput.value='';openSettingsModal('addressModal')}
function fillAddressModal(label){const box=getAddressBoxes().find(b=>(b.querySelector('.st-box-title')?.textContent||'').trim()===label);addressModeInput.value='edit';addressTargetInput.value=label;addressLabelInput.value=label;addressFullInput.value=box?(box.querySelector('.st-box-text')?.innerText||''):'';openSettingsModal('addressModal')} function saveAddressModal(e){e.preventDefault();const label=addressLabelInput.value.trim()||'New Address',text=addressFullInput.value.trim();const old=addressTargetInput.value.trim();let box=getAddressBoxes().find(b=>(b.querySelector('.st-box-title')?.textContent||'').trim()===(old||label));if(!box){const grid=document.querySelector('#panel-overview .st-address-grid'),add=document.querySelector('#panel-overview .st-address-placeholder');box=document.createElement('div');box.className='st-box';box.innerHTML='<button class="st-kebab" type="button" aria-label="Address actions"><i class="fa-solid fa-ellipsis-vertical"></i></button><h3 class="st-box-title"></h3><p class="st-box-text"></p>';grid.insertBefore(box,add)}box.querySelector('.st-kebab').setAttribute('onclick',"openAddressActions('"+label.replace(/'/g,"\\'")+"')");box.querySelector('.st-box-title').textContent=label;box.querySelector('.st-box-text').innerHTML=normalizeAddressText(text);localStorage.setItem('printify_address_'+label.toLowerCase().replace(/[^a-z0-9]+/g,'_'),text);closeAllSettingsModals();showSettingsToast('Address saved and updated on the page.')} function openAddressActions(label){openUtilityModal(label+' Actions','Edit, set primary, or remove this saved address.','<div class="st-list"><button type="button" class="st-btn" onclick="closeAllSettingsModals();fillAddressModal(\''+label.replace(/'/g,"\\'")+'\')">Edit Address</button><button type="button" class="st-btn" onclick="setPrimaryAddress(\''+label.replace(/'/g,"\\'")+'\')">Set as Primary</button><button type="button" class="st-btn" onclick="removeOverviewAddress(\''+label.replace(/'/g,"\\'")+'\')">Remove Address</button></div>')} function setPrimaryAddress(label){document.querySelectorAll('#panel-overview .st-address-grid .st-mini.orange').forEach(e=>e.remove());const box=getAddressBoxes().find(b=>(b.querySelector('.st-box-title')?.textContent||'').trim()===label);if(box){box.insertAdjacentHTML('afterbegin','<span class="st-mini orange">Primary</span>')}closeAllSettingsModals();showSettingsToast(label+' set as primary address.')} function removeOverviewAddress(label){const box=getAddressBoxes().find(b=>(b.querySelector('.st-box-title')?.textContent||'').trim()===label);if(box)box.remove();closeAllSettingsModals();showSettingsToast(label+' removed from saved addresses.')} document.addEventListener('DOMContentLoaded',function(){document.querySelectorAll('#panel-overview .st-address-placeholder').forEach(b=>b.addEventListener('click',openNewAddressModal));}); 
/* FINAL SAVE FLOW PATCH: save buttons show only after edits, and save buttons are green. */
document.addEventListener('DOMContentLoaded', function(){
    const saveWords = /\b(save|saved|save profile|save changes|save password|save recovery)\b/i;
    document.querySelectorAll('.st-page button').forEach(function(btn){
        const label = (btn.textContent || '').trim();
        if(saveWords.test(label)){
            btn.classList.add('st-save-action','st-save-hidden');
        }
    });

    function showPanelSave(el){
        const panel = el.closest('.st-panel, .st-modal-card');
        if(!panel) return;
        panel.querySelectorAll('.st-save-action').forEach(function(btn){
            btn.classList.remove('st-save-hidden');
        });
    }

    document.querySelectorAll('.st-page input:not([type="hidden"]), .st-page textarea, .st-page select').forEach(function(el){
        el.addEventListener('input', function(){ showPanelSave(el); });
        el.addEventListener('change', function(){ showPanelSave(el); });
    });

    document.querySelectorAll('.st-page .st-save-action').forEach(function(btn){
        btn.addEventListener('click', function(){
            const panel = btn.closest('.st-panel, .st-modal-card');
            window.setTimeout(function(){
                if(panel){
                    panel.querySelectorAll('.st-save-action').forEach(function(b){ b.classList.add('st-save-hidden'); });
                }
            }, 180);
        });
    });
});
</script>



{{-- =========================================================
   //PROFILE//
   HTML + CSS + JS CODES NG PROFILE
   ========================================================= --}}

{{-- PROFILE HTML --}}
<section id="panel-profile" class="st-panel">
<div class="st-profile-grid">
<div class="st-stack">
<div class="st-card">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Profile Settings</h2>
<p class="st-card-desc">Update your profile information and public account details.</p>
</div>
<button class="st-btn" type="button" data-modal-open="profileModal">
<i class="fa-solid fa-pen">
</i> Edit Profile</button>
</div>
<div class="st-profile-hero">
<div class="st-profile-hero-main">
<div class="st-avatar-wrap">
<img class="st-avatar" src="{{ $settingsPhoto ?: 'https://i.pravatar.cc/220?img=47' }}" alt="Profile">
<button class="st-camera" type="button" aria-label="Change photo" onclick="openPhotoPicker()">
<i class="fa-solid fa-camera">
</i>
</button>
</div>
<div>
<div class="st-name-row">
<h3 class="st-name">{{ $settingsName ?: 'Not set' }}</h3>
<span class="st-badge green">
<i class="fa-solid fa-check">
</i> Verified</span>
</div>
<div class="st-info">
<i class="fa-solid fa-location-dot">
</i> Quezon City, Metro Manila</div>
<div class="st-info">Customer ID: <strong>{{ $settingsCustomerId }}</strong>
<button class="st-copy" type="button" onclick="copySettingsText(@js($settingsCustomerId))">
<i class="fa-regular fa-copy">
</i>
</button>
</div>
<span class="st-badge orange" style="margin-top:8px">Premium Member</span>
</div>
</div>
<div class="st-profile-hero-meta">
<div class="st-profile-mini">
<span class="st-orange-ico" style="background:#f8fafc;color:#64748b">
<i class="fa-solid fa-phone">
</i>
</span>
<div>
<strong>Phone Number</strong>
<span>{{ $settingsPhone ?: 'Not set' }}</span>
</div>
</div>
<div class="st-profile-mini">
<span class="st-orange-ico" style="background:#f8fafc;color:#64748b">
<i class="fa-regular fa-calendar">
</i>
</span>
<div>
<strong>Member Since</strong>
<span>{{ optional($settingsUser->created_at)->format('M d, Y') ?: 'Not set' }}</span>
</div>
</div>
<div class="st-profile-mini">
<span class="st-orange-ico" style="background:#f8fafc;color:#64748b">
<i class="fa-solid fa-envelope">
</i>
</span>
<div>
<strong>Email Address</strong>
<span>{{ $settingsEmail ?: 'Not set' }}</span>
</div>
</div>
<div class="st-profile-mini">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-shield-halved">
</i>
</span>
<div>
<strong>Account Status</strong>
<span style="color:var(--st-green)">Active</span>
</div>
</div>
</div>
</div>
<div class="st-section-line">
</div>
<div class="st-profile-block-title">
<span class="st-orange-ico">
<i class="fa-regular fa-user">
</i>
</span>
<h2 class="st-card-title">Personal Information</h2>
</div>
<div class="st-form-grid" style="margin-top:14px">
<div class="st-field">
<label>Full Name</label>
<input class="st-input" value="{{ $settingsName }}">
</div>
<div class="st-field">
<label>Email Address</label>
<input class="st-input" type="email" value="{{ $settingsEmail }}">
</div>
<div class="st-field">
<label>Phone Number</label>
<input class="st-input" value="{{ $settingsPhone }}">
</div>
<div class="st-field">
<label>Company</label>
<input class="st-input" value="{{ $settingsCompany }}" placeholder="Optional">
</div>
</div>
<div class="st-profile-block-title">
<span class="st-orange-ico">
<i class="fa-regular fa-address-card">
</i>
</span>
<h2 class="st-card-title">Account Details</h2>
</div>
<div class="st-form-grid">
<div class="st-field">
<label>Account Type</label>
<input class="st-input" value="Customer" readonly>
</div>
<div class="st-field">
<label>Two-Factor Authentication</label>
<input class="st-input" value="Enabled" readonly>
</div>
</div>
<div class="st-actions">
<button type="button" class="st-btn" onclick="saveProfilePanelSettings()">Save Profile</button>
</div>
</div>
</div>
<div class="st-card st-connected-card">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Connected Accounts</h2>
<p class="st-card-desc">Manage connected social and third-party accounts.</p>
</div>
<button class="st-btn" type="button" onclick="openConnectedAccountsPanel()">Manage</button>
</div>
<div class="st-three st-summary-strip" style="grid-template-columns:repeat(2,minmax(0,1fr));border:0;padding:0">
<div class="st-summary-item">
<span class="st-orange-ico" style="background:#fff;color:#4285f4">
<i class="fa-brands fa-google">
</i>
</span>
<div>
<p class="st-sec-title">Google</p>
<p class="st-sec-sub">{{ $settingsEmail ?: 'Not set' }}</p>
</div>
</div>
<div class="st-summary-item">
<span class="st-orange-ico" style="background:#eef4ff;color:#1877f2">
<i class="fa-brands fa-facebook-f">
</i>
</span>
<div>
<p class="st-sec-title">Facebook</p>
<p class="st-sec-sub">Connected</p>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="st-profile-side">
<div class="st-card st-plain">
<div class="st-body">
<h2 class="st-card-title">Profile Completion</h2>
<div class="st-score-ring" style="width:112px;height:112px">
<div class="st-score-inner" style="width:82px;height:82px">
<div>
<strong style="font-size:24px">92%</strong>
<br>
<span>Complete</span>
</div>
</div>
</div>
<button class="st-btn" type="button" onclick="showSettingsToast('Profile suggestions opened.')">View Suggestions</button>
</div>
</div>
<div class="st-card st-plain">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Communication Preferences</h2>
<p class="st-card-desc">Use these channels for order and account updates.</p>
</div>
</div>
<div class="st-no-box-list">
@foreach([['Email Notifications',true],['SMS Notifications',true],['Marketing Updates',false],['Order Updates',true]] as $pref) <div class="st-no-box-item">
<span class="st-sec-title">{{ $pref[0] }}</span>
<label class="st-switch">
<input type="checkbox" @checked($pref[1]) onchange="toggleSettingMessage(this,'{{ $pref[0] }}')">
<span class="st-slider">
</span>
</label>
</div>
@endforeach </div>
<button class="st-btn" style="margin-top:12px;width:100%" type="button" data-tab-jump="notifications">Manage Preferences</button>
</div>
</div>
<div class="st-card st-plain">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Recent Activity</h2>
<p class="st-card-desc">Latest profile and account updates.</p>
</div>
<button class="st-link" type="button" onclick="openActivityLogPanel()">View All</button>
</div>
<div class="st-no-box-list">
<div class="st-no-box-item">
<div class="st-comm-left">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-check">
</i>
</span>
<div>
<p class="st-sec-title">Profile updated</p>
<p class="st-sec-sub">Today</p>
</div>
</div>
</div>
<div class="st-no-box-item">
<div class="st-comm-left">
<span class="st-orange-ico" style="background:#eef4ff;color:#2563eb">
<i class="fa-solid fa-cloud-arrow-up">
</i>
</span>
<div>
<p class="st-sec-title">Design file uploaded</p>
<p class="st-sec-sub">Recently</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- PROFILE MODAL HTML -->
<div id="profileModal" class="st-modal">
<div class="st-modal-bg" data-modal-close>
</div>
<div class="st-modal-shell">
<div class="st-modal-card">
<div class="st-modal-head">
<div>
<h3 class="st-modal-title">Edit Profile</h3>
<p class="st-modal-desc">Update your personal details.</p>
</div>
<button type="button" class="st-close" data-modal-close>×</button>
</div>
<form class="st-modal-body" onsubmit="saveProfileModal(event)">
<div class="st-field">
<label>Full Name</label>
<input id="profileNameInput" class="st-input" value="{{ $settingsName }}">
</div>
<div class="st-field" style="margin-top:12px">
<label>Email Address</label>
<input id="profileEmailInput" class="st-input" type="email" value="{{ $settingsEmail }}">
</div>
<div class="st-form-grid" style="margin-top:12px">
<div class="st-field">
<label>Phone Number</label>
<input id="profilePhoneInput" class="st-input" value="{{ $settingsPhone }}">
</div>
<div class="st-field">
<label>Date of Birth</label>
<input id="profileBirthInput" class="st-input" value="{{ $settingsBirthdate }}">
</div>
</div>
<div class="st-field" style="margin-top:12px">
<label>Company</label>
<input id="profileCompanyInput" class="st-input" value="{{ $settingsCompany }}" placeholder="Optional">
</div>
<div class="st-section-line" style="margin:16px 0">
</div>
<h3 class="st-modal-title" style="margin-bottom:10px">Address Book</h3>
<div class="st-field">
<label>Primary Address</label>
<textarea id="profilePrimaryAddressInput" class="st-textarea" placeholder="Complete home address">123 Printify Avenue Makati City, Metro Manila 1200 Philippines +63 912 345 6789</textarea>
</div>
<div class="st-field" style="margin-top:12px">
<label>Work Address</label>
<textarea id="profileWorkAddressInput" class="st-textarea" placeholder="Complete work address">45 Timog Avenue Quezon City, Metro Manila 1103 Philippines +63 912 345 6789</textarea>
</div>
<div class="st-actions">
<button type="button" class="st-btn" data-modal-close>Cancel</button>
<button type="submit" class="st-btn">Save Changes</button>
</div>
</form>
</div>
</div>
</div>

{{-- PROFILE CSS --}}
<style id="settings-profile-css">
/* PROFILE CSS: section-specific overrides/rules. */
#panel-profile .st-profile-grid{grid-template-columns:minmax(0,1fr) 340px!important;gap:18px!important}
#panel-profile .st-profile-side .st-card{border:0!important;background:transparent!important;box-shadow:none!important;border-radius:0!important}
#panel-profile .st-profile-side .st-card>.st-body{padding:0!important}
#panel-profile .st-profile-grid{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:18px;align-items:start}
#panel-profile .st-profile-side{display:flex;flex-direction:column;gap:16px}
#panel-profile .st-card-title,#panel-security .st-card-title,#panel-notifications .st-card-title,#panel-payments .st-card-title{font-family:'Poppins',system-ui,sans-serif;font-weight:600}
#panel-profile .st-card:first-child,#panel-profile .st-connected-card,#panel-security .st-setting-main>.st-card:first-child,#panel-security .st-login-tips-box,#panel-notifications .st-card:first-child,#panel-payments .st-billing-box{border-color:#111827}
@media(max-width:1260px){#panel-profile .st-profile-grid,#panel-notifications .st-notif-layout,#panel-payments .st-pay-layout{grid-template-columns:1fr}
#panel-profile .st-form-grid{gap:10px!important}
#panel-profile .st-field label{font-size:8.8px!important}
#panel-profile .st-input{height:38px!important;padding:8px 10px!important;font-size:10.5px!important}
#panel-profile .st-summary-strip .st-summary-item{padding:8px 10px;border:1px solid #e5e7eb;border-radius:10px}
#panel-profile .st-profile-side{gap:10px!important}
#panel-profile .st-profile-side .st-head{margin-bottom:6px!important}
#panel-profile .st-profile-side .st-no-box-list{gap:3px!important}
#panel-profile .st-profile-side .st-no-box-item{padding:5px 0!important}
#panel-profile .st-profile-side .st-btn{height:36px!important}
#panel-profile .st-profile-side .st-score-ring{width:88px!important;height:88px!important;margin:6px auto!important}
#panel-profile .st-profile-side .st-score-inner{width:66px!important;height:66px!important}
#panel-profile .st-profile-side .st-score-inner strong{font-size:20px!important}
#panel-profile .st-profile-grid, #panel-security .st-settings-grid, #panel-notifications .st-notif-layout{grid-template-columns:minmax(0,1fr) 300px!important;gap:16px!important;align-items:start!important}
#panel-profile .st-profile-side, #panel-security .st-setting-side, #panel-notifications .st-notif-side{gap:8px!important}
#panel-profile .st-profile-side .st-card-title, #panel-security .st-setting-side .st-card-title, #panel-notifications .st-notif-side .st-card-title{font-size:13px!important}
#panel-profile .st-profile-side .st-card-desc, #panel-security .st-setting-side .st-card-desc, #panel-notifications .st-notif-side .st-card-desc{font-size:9.5px!important;line-height:1.25!important}
/* Box logic: main grouped boxes have subtle/black borders, requested plain sections have no outer box */ #panel-overview .overview-profile-box, #panel-overview .overview-payment-box, #panel-overview .overview-quick-panel, #panel-profile .st-card:first-child, #panel-security .st-setting-main>.st-card:first-child, #panel-notifications .st-card:first-child, #panel-payments .st-billing-box, .st-main-group{ border:1px solid rgba(17,24,39,.55)!important; border-radius:12px!important; background:#fff!important; box-shadow:0 8px 22px rgba(15,23,42,.045)!important; overflow:hidden!important; }
#panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel, #panel-overview .overview-privacy-panel, #panel-profile .st-profile-side .st-card, #panel-security .st-setting-side>.st-card, #panel-notifications .st-notif-side>.st-card, #panel-payments .st-pay-side>.st-card, .st-plain, .st-plain-panel{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; overflow:visible!important; }
.st-modal .st-actions .st-btn[type="submit"], #panel-profile .st-actions .st-btn, #panel-notifications .st-head .st-btn[onclick*="Save"], #panel-preferences .st-head .st-btn[onclick*="Save"]{ background:#16a34a!important; border-color:#16a34a!important; color:#fff!important; }
.st-modal .st-actions .st-btn[type="submit"]:hover, #panel-profile .st-actions .st-btn:hover, #panel-notifications .st-head .st-btn[onclick*="Save"]:hover, #panel-preferences .st-head .st-btn[onclick*="Save"]:hover{ background:#111827!important; border-color:#111827!important; color:#fff!important; }
/* Profile settings tab: same compact flow as My Profile */ #panel-profile .st-card-title, #panel-security .st-card-title, #panel-notifications .st-card-title, #panel-payments .st-card-title, #panel-addresses .st-card-title, #panel-preferences .st-card-title, #panel-privacy .st-card-title{ font-size:12.5px!important; letter-spacing:.025em!important; }
#panel-profile .st-card-desc, #panel-security .st-card-desc, #panel-notifications .st-card-desc, #panel-payments .st-card-desc, #panel-addresses .st-card-desc, #panel-preferences .st-card-desc, #panel-privacy .st-card-desc{ font-size:9.5px!important; line-height:1.35!important; }
#panel-profile .st-input, #panel-preferences .st-input, #panel-privacy select{ min-height:38px!important; font-size:10.5px!important; border-radius:10px!important; }
/* Buttons and Date: one consistent My Profile-style button system */ .st-page .st-btn, .st-page .st-outline-btn, .st-page .st-date, .st-modal .st-actions .st-btn, #panel-profile .st-actions .st-btn, #panel-notifications .st-head .st-btn, #panel-preferences .st-head .st-btn{ height:36px!important; min-width:120px!important; padding:0 16px!important; border-radius:999px!important; border:1px solid transparent!important; background:linear-gradient(90deg,var(--st-primary-orange),var(--st-primary-orange-2))!important; color:#111827!important; font-family:'Poppins',system-ui,sans-serif!important; font-size:10.5px!important; font-weight:700!important; letter-spacing:.01em!important; display:inline-flex!important; align-items:center!important; justify-content:center!important; gap:7px!important; box-shadow:none!important; transform:none!important; white-space:nowrap!important; cursor:pointer!important; }
.st-page .st-btn:hover, .st-page .st-btn:focus-visible, .st-page .st-btn:active, .st-page .st-btn.is-clicked, .st-page .st-outline-btn:hover, .st-page .st-outline-btn:focus-visible, .st-page .st-outline-btn:active, .st-page .st-outline-btn.is-clicked, .st-page .st-date:hover, .st-page .st-date:focus-visible, .st-modal .st-actions .st-btn:hover, .st-modal .st-actions .st-btn:focus-visible, #panel-profile .st-actions .st-btn:hover, #panel-notifications .st-head .st-btn:hover, #panel-preferences .st-head .st-btn:hover{ background:var(--st-action-hover)!important; border-color:var(--st-action-hover)!important; color:#fff!important; box-shadow:none!important; outline:none!important; transform:none!important; }
/* Unified Profile Completion / Security Score / Notification Summary rings */ .st-score-ring, #panel-profile .st-profile-side .st-score-ring, #panel-security .st-setting-side .st-score-ring, #panel-notifications .st-notif-side .st-score-ring, .st-section-layout .st-section-side .st-score-ring{ width:112px!important; height:112px!important; margin:10px auto 12px!important; border-radius:50%!important; background:conic-gradient(var(--st-primary-orange) 0 331deg,#f1f5f9 331deg 360deg)!important; display:grid!important; place-items:center!important; box-shadow:0 8px 22px rgba(255,122,0,.14)!important; }
.st-score-inner, #panel-profile .st-profile-side .st-score-inner, #panel-security .st-setting-side .st-score-inner, #panel-notifications .st-notif-side .st-score-inner, .st-section-layout .st-section-side .st-score-inner{ width:82px!important; height:82px!important; border-radius:50%!important; background:#fff!important; display:grid!important; place-items:center!important; text-align:center!important; border:1px solid #fff3e6!important; }
.st-score-inner strong, #panel-profile .st-profile-side .st-score-inner strong, #panel-security .st-setting-side .st-score-inner strong, #panel-notifications .st-notif-side .st-score-inner strong, .st-section-layout .st-section-side .st-score-inner strong{ font-family:'Poppins',system-ui,sans-serif!important; font-size:24px!important; line-height:1!important; color:#111827!important; font-weight:800!important; }
.st-score-inner span, #panel-profile .st-profile-side .st-score-inner span, #panel-security .st-setting-side .st-score-inner span, #panel-notifications .st-notif-side .st-score-inner span, .st-section-layout .st-section-side .st-score-inner span{ color:var(--st-primary-orange)!important; font-size:10px!important; font-weight:800!important; text-transform:uppercase!important; letter-spacing:.03em!important; }
/* Icon-only colors: no background shape, varied colors per function */ #panel-overview .st-orange-ico, #panel-overview .st-ico, #panel-profile .st-score-ring ~ .st-no-box-list .st-orange-ico, #panel-security .st-orange-ico, #panel-notifications .st-orange-ico{ background:transparent!important; border:0!important; border-radius:0!important; width:22px!important; height:22px!important; flex:0 0 22px!important; color:var(--st-orange)!important; }
/* Score circles equalized */ #panel-profile .st-score-ring, #panel-security .st-score-ring, #panel-notifications .st-score-ring{ width:108px!important; height:108px!important; margin:8px auto 12px!important; background:conic-gradient(#ff7a00 0 331deg,#e5e7eb 331deg 360deg)!important; }
#panel-profile .st-score-inner, #panel-security .st-score-inner, #panel-notifications .st-score-inner{ width:80px!important; height:80px!important; background:#fff!important; }
#panel-profile .st-score-inner strong, #panel-security .st-score-inner strong, #panel-notifications .st-score-inner strong{ font-size:23px!important; color:#111827!important; }
#panel-profile .st-score-inner span, #panel-security .st-score-inner span, #panel-notifications .st-score-inner span{ color:#16a34a!important; font-size:9.5px!important; font-weight:700!important; }
#panel-profile .st-card-title,
#panel-profile .st-card-desc,
#panel-profile .st-input,
#panel-profile .st-textarea,
</style>

{{-- PROFILE JS --}}
<script id="settings-profile-js">
/* PROFILE JS: uses global functions from OVERVIEW JS: openPhotoPicker(), saveProfileModal(), saveProfilePanelSettings(), openConnectedAccountsPanel(). */
</script>



{{-- =========================================================
   //SECURITY//
   HTML + CSS + JS CODES NG SECURITY
   ========================================================= --}}

{{-- SECURITY HTML --}}
<section id="panel-security" class="st-panel">
<div class="st-settings-grid">
<div class="st-setting-main">
<div class="st-card">
<div class="st-sec-row">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-shield-halved">
</i>
</span>
<div>
<h2 class="st-card-title">Security Overview</h2>
<p class="st-card-desc">Review and manage your account security.</p>
</div>
<span class="st-status-pill">
<i class="fa-solid fa-check">
</i> Your account is well protected</span>
</div>
<div class="st-sec-row">
<span class="st-orange-ico">
<i class="fa-solid fa-lock">
</i>
</span>
<div>
<p class="st-sec-title">Password</p>
<p class="st-sec-sub">Last changed 30 days ago</p>
</div>
<button class="st-outline-btn" type="button" onclick="openPasswordPanel()">Change Password</button>
</div>
<div class="st-sec-row">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-shield-halved">
</i>
</span>
<div>
<p class="st-sec-title">Two-Factor Authentication</p>
<p class="st-sec-sub">Add an extra layer of security to your account.</p>
</div>
<label class="st-switch">
<input type="checkbox" checked onchange="toggleSettingMessage(this,'Two-factor authentication')">
<span class="st-slider">
</span>
</label>
</div>
<div class="st-sec-row">
<span class="st-orange-ico" style="background:#f4efff;color:#7c3aed">
<i class="fa-regular fa-clock">
</i>
</span>
<div>
<p class="st-sec-title">Login Activity</p>
<p class="st-sec-sub">Review your recent account activity.</p>
</div>
<button class="st-outline-btn" type="button" onclick="openActivityLogPanel()">View Activity</button>
</div>
<div class="st-sec-row">
<span class="st-orange-ico" style="background:#eef4ff;color:#2563eb">
<i class="fa-solid fa-laptop">
</i>
</span>
<div>
<p class="st-sec-title">Active Sessions / Devices</p>
<p class="st-sec-sub">Manage devices that are signed in to your account.</p>
</div>
<button class="st-outline-btn" type="button" onclick="openSessionManagerPanel()">Manage Devices</button>
</div>
<div class="st-sec-row">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-circle-check">
</i>
</span>
<div>
<p class="st-sec-title">Account Verification</p>
<p class="st-sec-sub">Your account is verified.</p>
</div>
<span class="st-status-pill">Verified</span>
</div>
<div class="st-sec-row">
<span class="st-orange-ico">
<i class="fa-solid fa-life-ring">
</i>
</span>
<div>
<p class="st-sec-title">Recovery Options</p>
<p class="st-sec-sub">Update your recovery information to stay in control.</p>
</div>
<button class="st-outline-btn" type="button" onclick="openRecoveryPanel()">Manage Recovery</button>
</div>
<div class="st-sec-row">
<span class="st-orange-ico" style="background:#f4efff;color:#7c3aed">
<i class="fa-solid fa-display">
</i>
</span>
<div>
<p class="st-sec-title">Trusted Devices</p>
<p class="st-sec-sub">Devices that you trust and use to access your account.</p>
</div>
<button class="st-outline-btn" type="button" onclick="openTrustedDevicesPanel()">Manage Devices</button>
</div>
</div>
<div class="st-card st-login-tips-box">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Recent Login Activity</h2>
<p class="st-card-desc">Review your most recent account access.</p>
</div>
<button class="st-outline-btn" type="button" onclick="openActivityLogPanel()">View All Activity</button>
</div>
<div class="st-table-lite">
<div class="st-table-lite-row">
<strong>Quezon City, Metro Manila, Philippines</strong>
<span class="st-status-pill">Current</span>
<span>Windows - Chrome<br>Jun 03, 2026 at 09:41 AM</span>
</div>
<div class="st-table-lite-row">
<strong>Quezon City, Metro Manila, Philippines</strong>
<span>iPhone - iOS</span>
<span>Jun 02, 2026 at 10:12 PM</span>
</div>
<div class="st-table-lite-row">
<strong>Makati City, Metro Manila, Philippines</strong>
<span>MacOS - Safari</span>
<span>Jun 01, 2026 at 08:05 PM</span>
</div>
</div>
<button class="st-link" type="button" style="margin:12px auto 0;display:flex" onclick="openActivityLogPanel()">View All Activity</button>
<div class="st-section-line">
</div>
<h2 class="st-card-title">Security Tips</h2>
<p class="st-card-desc">Simple steps to keep your account safe.</p>
<div class="st-tip-grid">
<div class="st-tip">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-lock">
</i>
</span>
<div>
<p class="st-sec-title">Use a strong password</p>
<p class="st-sec-sub">Use letters, numbers, and symbols.</p>
</div>
</div>
<div class="st-tip">
<span class="st-orange-ico" style="background:#f4efff;color:#7c3aed">
<i class="fa-solid fa-shield">
</i>
</span>
<div>
<p class="st-sec-title">Enable 2FA</p>
<p class="st-sec-sub">Add an extra verification layer.</p>
</div>
</div>
<div class="st-tip">
<span class="st-orange-ico">
<i class="fa-solid fa-triangle-exclamation">
</i>
</span>
<div>
<p class="st-sec-title">Beware of phishing</p>
<p class="st-sec-sub">Never share your password or OTP.</p>
</div>
</div>
<div class="st-tip">
<span class="st-orange-ico" style="background:#eef4ff;color:#2563eb">
<i class="fa-solid fa-rotate">
</i>
</span>
<div>
<p class="st-sec-title">Keep devices updated</p>
<p class="st-sec-sub">Use current browsers and OS versions.</p>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="st-setting-side">
<div class="st-card">
<div class="st-body">
<h2 class="st-card-title">Security Score</h2>
<div class="st-score-ring">
<div class="st-score-inner">
<div>
<strong>92%</strong>
<br>
<span>Excellent</span>
</div>
</div>
</div>
<p class="st-card-desc" style="text-align:center">Great job! Your account security is strong.</p>
<div style="margin-top:14px">
<div class="st-check-line">
<i class="fa-solid fa-circle-check">
</i>Strong password</div>
<div class="st-check-line">
<i class="fa-solid fa-circle-check">
</i>Two-factor authentication enabled</div>
<div class="st-check-line">
<i class="fa-solid fa-circle-check">
</i>Recovery information verified</div>
<div class="st-check-line">
<i class="fa-solid fa-circle-check">
</i>No compromised devices found</div>
</div>
</div>
</div>
<div class="st-card">
<div class="st-body">
<h2 class="st-card-title">Verification Status</h2>
<div class="st-side-list" style="margin-top:12px">
<div class="st-side-row">
<span>
<i class="fa-regular fa-envelope">
</i> Email Address</span>
<span class="st-status-pill">Verified</span>
</div>
<div class="st-side-row">
<span>
<i class="fa-solid fa-phone">
</i> Phone Number</span>
<span class="st-status-pill">Verified</span>
</div>
<div class="st-side-row">
<span>
<i class="fa-solid fa-id-card">
</i> Identity Verification</span>
<span class="st-status-pill gray">Not required</span>
</div>
<button class="st-link" type="button" onclick="showSettingsToast('Verification options opened.')">Manage Verification <i class="fa-solid fa-chevron-right">
</i>
</button>
</div>
</div>
</div>
<div class="st-card">
<div class="st-body">
<h2 class="st-card-title">Need Help?</h2>
<p class="st-card-desc">We're here to help you stay secure.</p>
<div class="st-side-list" style="margin-top:12px">
<button class="st-setting-action" type="button" onclick="showSettingsToast('Security guide opened.')">
<span>How to secure your account</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="openPasswordPanel()">
<span>Reset your password</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('2FA guide opened.')">
<span>Enable two-factor authentication</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Suspicious activity report opened.')">
<span>Report suspicious activity</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-btn" type="button" onclick="window.location.href='{{ Route::has('help-center') ? route('help-center') : '#' }}'">Visit Help Center</button>
</div>
</div>
</div>
</div>
</div>
</section>

{{-- SECURITY CSS --}}
<style id="settings-security-css">
/* SECURITY CSS: section-specific overrides/rules. */
#panel-security .st-settings-grid, #panel-notifications .st-notif-layout{grid-template-columns:minmax(0,1fr) 300px!important;gap:16px!important;align-items:start!important}
#panel-security .st-setting-side, #panel-notifications .st-notif-side{gap:14px!important}
#panel-profile .st-card-title,#panel-security .st-card-title,#panel-notifications .st-card-title,#panel-payments .st-card-title{font-family:'Poppins',system-ui,sans-serif;font-weight:600}
#panel-profile .st-card:first-child,#panel-profile .st-connected-card,#panel-security .st-setting-main>.st-card:first-child,#panel-security .st-login-tips-box,#panel-notifications .st-card:first-child,#panel-payments .st-billing-box{border-color:#111827}
#panel-security .st-setting-side>.st-card{border:0!important;background:transparent!important;box-shadow:none!important}
#panel-security .st-setting-side>.st-card .st-body{padding:0}
#panel-security .st-setting-side .st-side-row{border:0!important;border-bottom:1px solid #e8ebf0!important;border-radius:0!important;background:transparent!important;padding-left:0;padding-right:0}
#panel-security .st-tip{border:0;border-bottom:1px solid #e8ebf0;border-radius:0;background:transparent}
#panel-security .st-sec-row{padding:11px 14px!important;grid-template-columns:44px minmax(0,1fr) auto!important}
#panel-security .st-sec-row .st-orange-ico{width:34px!important;height:34px!important;border-radius:11px!important}
#panel-security .st-setting-side .st-score-ring, #panel-notifications .st-notif-side .st-score-ring{width:98px!important;height:98px!important;margin:8px auto!important}
#panel-security .st-setting-side .st-score-inner, #panel-notifications .st-notif-side .st-score-inner{width:74px!important;height:74px!important}
#panel-security .st-setting-side .st-score-inner strong, #panel-notifications .st-notif-side .st-score-inner strong{font-size:22px!important}
#panel-security .st-setting-side .st-check-line, #panel-notifications .st-notif-side .st-no-box-item, #panel-notifications .st-notif-side .st-setting-action{padding:6px 0!important;font-size:10.5px!important}
#panel-security .st-login-tips-box .st-body{padding:12px 14px!important}
#panel-security .st-tip-grid{gap:8px!important}
#panel-security .st-tip{padding:8px!important}
#panel-security .st-setting-side{gap:8px!important}
#panel-security .st-setting-side .st-card-title, #panel-notifications .st-notif-side .st-card-title{font-size:13px!important}
#panel-security .st-setting-side .st-card-desc, #panel-notifications .st-notif-side .st-card-desc{font-size:9.5px!important;line-height:1.25!important}
#panel-security .st-setting-side .st-side-list, #panel-notifications .st-notif-side .st-no-box-list{gap:3px!important;margin-top:7px!important}
#panel-security .st-setting-side .st-side-row, #panel-security .st-setting-side .st-setting-action, #panel-notifications .st-notif-side .st-setting-action, #panel-notifications .st-notif-side .st-no-box-item{padding:5px 0!important}
#panel-security .st-setting-side .st-btn, #panel-notifications .st-notif-side .st-btn{height:36px!important;margin-top:8px!important}
#panel-profile .st-profile-grid, #panel-security .st-settings-grid, #panel-notifications .st-notif-layout{grid-template-columns:minmax(0,1fr) 300px!important;gap:16px!important;align-items:start!important}
#panel-profile .st-profile-side, #panel-security .st-setting-side, #panel-notifications .st-notif-side{gap:8px!important}
#panel-profile .st-profile-side .st-card-title, #panel-security .st-setting-side .st-card-title, #panel-notifications .st-notif-side .st-card-title{font-size:13px!important}
#panel-profile .st-profile-side .st-card-desc, #panel-security .st-setting-side .st-card-desc, #panel-notifications .st-notif-side .st-card-desc{font-size:9.5px!important;line-height:1.25!important}
/* Box logic: main grouped boxes have subtle/black borders, requested plain sections have no outer box */ #panel-overview .overview-profile-box, #panel-overview .overview-payment-box, #panel-overview .overview-quick-panel, #panel-profile .st-card:first-child, #panel-security .st-setting-main>.st-card:first-child, #panel-notifications .st-card:first-child, #panel-payments .st-billing-box, .st-main-group{ border:1px solid rgba(17,24,39,.55)!important; border-radius:12px!important; background:#fff!important; box-shadow:0 8px 22px rgba(15,23,42,.045)!important; overflow:hidden!important; }
#panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel, #panel-overview .overview-privacy-panel, #panel-profile .st-profile-side .st-card, #panel-security .st-setting-side>.st-card, #panel-notifications .st-notif-side>.st-card, #panel-payments .st-pay-side>.st-card, .st-plain, .st-plain-panel{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; overflow:visible!important; }
/* Profile settings tab: same compact flow as My Profile */ #panel-profile .st-card-title, #panel-security .st-card-title, #panel-notifications .st-card-title, #panel-payments .st-card-title, #panel-addresses .st-card-title, #panel-preferences .st-card-title, #panel-privacy .st-card-title{ font-size:12.5px!important; letter-spacing:.025em!important; }
#panel-profile .st-card-desc, #panel-security .st-card-desc, #panel-notifications .st-card-desc, #panel-payments .st-card-desc, #panel-addresses .st-card-desc, #panel-preferences .st-card-desc, #panel-privacy .st-card-desc{ font-size:9.5px!important; line-height:1.35!important; }
/* Unified Profile Completion / Security Score / Notification Summary rings */ .st-score-ring, #panel-profile .st-profile-side .st-score-ring, #panel-security .st-setting-side .st-score-ring, #panel-notifications .st-notif-side .st-score-ring, .st-section-layout .st-section-side .st-score-ring{ width:112px!important; height:112px!important; margin:10px auto 12px!important; border-radius:50%!important; background:conic-gradient(var(--st-primary-orange) 0 331deg,#f1f5f9 331deg 360deg)!important; display:grid!important; place-items:center!important; box-shadow:0 8px 22px rgba(255,122,0,.14)!important; }
.st-score-inner, #panel-profile .st-profile-side .st-score-inner, #panel-security .st-setting-side .st-score-inner, #panel-notifications .st-notif-side .st-score-inner, .st-section-layout .st-section-side .st-score-inner{ width:82px!important; height:82px!important; border-radius:50%!important; background:#fff!important; display:grid!important; place-items:center!important; text-align:center!important; border:1px solid #fff3e6!important; }
.st-score-inner strong, #panel-profile .st-profile-side .st-score-inner strong, #panel-security .st-setting-side .st-score-inner strong, #panel-notifications .st-notif-side .st-score-inner strong, .st-section-layout .st-section-side .st-score-inner strong{ font-family:'Poppins',system-ui,sans-serif!important; font-size:24px!important; line-height:1!important; color:#111827!important; font-weight:800!important; }
.st-score-inner span, #panel-profile .st-profile-side .st-score-inner span, #panel-security .st-setting-side .st-score-inner span, #panel-notifications .st-notif-side .st-score-inner span, .st-section-layout .st-section-side .st-score-inner span{ color:var(--st-primary-orange)!important; font-size:10px!important; font-weight:800!important; text-transform:uppercase!important; letter-spacing:.03em!important; }
/* Icon-only colors: no background shape, varied colors per function */ #panel-overview .st-orange-ico, #panel-overview .st-ico, #panel-profile .st-score-ring ~ .st-no-box-list .st-orange-ico, #panel-security .st-orange-ico, #panel-notifications .st-orange-ico{ background:transparent!important; border:0!important; border-radius:0!important; width:22px!important; height:22px!important; flex:0 0 22px!important; color:var(--st-orange)!important; }
/* Score circles equalized */ #panel-profile .st-score-ring, #panel-security .st-score-ring, #panel-notifications .st-score-ring{ width:108px!important; height:108px!important; margin:8px auto 12px!important; background:conic-gradient(#ff7a00 0 331deg,#e5e7eb 331deg 360deg)!important; }
#panel-profile .st-score-inner, #panel-security .st-score-inner, #panel-notifications .st-score-inner{ width:80px!important; height:80px!important; background:#fff!important; }
#panel-profile .st-score-inner strong, #panel-security .st-score-inner strong, #panel-notifications .st-score-inner strong{ font-size:23px!important; color:#111827!important; }
#panel-profile .st-score-inner span, #panel-security .st-score-inner span, #panel-notifications .st-score-inner span{ color:#16a34a!important; font-size:9.5px!important; font-weight:700!important; }
#panel-security .st-card-title,
#panel-security .st-card-desc,
</style>

{{-- SECURITY JS --}}
<script id="settings-security-js">
/* SECURITY JS: uses global functions from OVERVIEW JS: openPasswordPanel(), openRecoveryPanel(), openTrustedDevicesPanel(), openSessionManagerPanel(). */
</script>



{{-- =========================================================
   //NOTIFICATIONS//
   HTML + CSS + JS CODES NG NOTIFICATIONS
   ========================================================= --}}

{{-- NOTIFICATIONS HTML --}}
<section id="panel-notifications" class="st-panel">
<div class="st-notif-layout">
<div class="st-card">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Notification Channels</h2>
<p class="st-card-desc">Choose how you receive different types of notifications.</p>
</div>
<button class="st-btn" type="button" onclick="persistSettingsValue('notifications','all_channels','saved','Notification channels')">Save Changes</button>
</div>
<div class="st-summary-strip" style="grid-template-columns:repeat(4,minmax(0,1fr));padding:0;border:0">
@foreach([['envelope','Email',$settingsEmail ?: 'Not set'],['comment-dots','SMS',$settingsPhone ?: 'Not set'],['bell','In-App','Enabled'],['paper-plane','Marketing','Receive offers']] as $channel)
<div class="st-summary-item">
<span class="st-orange-ico" style="background:#eef4ff;color:#2563eb">
<i class="fa-solid fa-{{ $channel[0] }}">
</i>
</span>
<div>
<p class="st-sec-title">{{ $channel[1] }}</p>
<p class="st-sec-sub">{{ $channel[2] }}</p>
</div>
<span class="st-inline-pill">On</span>
</div>
@endforeach </div>
<div class="st-section-line">
</div>
<div class="st-channel-row">
<div>
</div>
<div class="st-channel-head">Email</div>
<div class="st-channel-head">SMS</div>
<div class="st-channel-head">In-App</div>
<div>
</div>
</div>
@php $channelRows=[ ['box','Order Confirmations','Get notified when your order is placed.',true,true,true], ['truck-fast','Order Updates','Receive updates on status changes and progress.',true,true,true], ['route','Shipping & Delivery','Track your shipment and delivery updates.',true,true,true], ['triangle-exclamation','Delivery Exceptions','Be alerted for delays, failures, or delivery issues.',true,false,true], ['credit-card','Payment Confirmations','Receive confirmation after payment.',true,true,true], ['receipt','Invoice & Receipt','Get notified when invoices and receipts are available.',true,false,true], ['shield-halved','Security & Account Alerts','Important updates about your account and security.',true,true,true], ['headset','Support & Messages','Updates about support tickets and replies.',true,false,true], ['gift','Promotions & Offers','Exclusive deals, new products, and special offers.',true,false,false], ];
@endphp
@foreach($channelRows as $row) <div class="st-channel-row">
<div class="st-comm-left">
<span class="st-orange-ico">
<i class="fa-solid fa-{{ $row[0] }}">
</i>
</span>
<div>
<p class="st-sec-title">{{ $row[1] }}</p>
<p class="st-sec-sub">{{ $row[2] }}</p>
</div>
</div> @for($i=3;$i<=5;$i++) <label class="st-switch" style="margin:auto">
<input type="checkbox" @checked($row[$i]) onchange="toggleSettingMessage(this,'{{ $row[1] }} channel {{ $i }}')">
<span class="st-slider">
</span>
</label> @endfor <button class="st-link" type="button" onclick="showSettingsToast('{{ $row[1] }} details opened.')">
<i class="fa-solid fa-chevron-down">
</i>
</button>
</div>
@endforeach </div>
</div>
<div class="st-notif-side">
<div class="st-card st-plain">
<div class="st-body">
<h2 class="st-card-title">Notification Summary</h2>
<p class="st-card-desc">Overview of your current notification settings.</p>
<div class="st-score-ring" style="width:112px;height:112px">
<div class="st-score-inner" style="width:82px;height:82px">
<div>
<strong style="font-size:24px">92%</strong>
<br>
<span>All set</span>
</div>
</div>
</div>
<div class="st-no-box-list">
<div class="st-no-box-item">
<span>Email Notifications</span>
<span>24 enabled</span>
</div>
<div class="st-no-box-item">
<span>SMS Notifications</span>
<span>12 enabled</span>
</div>
<div class="st-no-box-item">
<span>In-App Notifications</span>
<span>18 enabled</span>
</div>
<div class="st-no-box-item">
<span>Marketing Notifications</span>
<span>6 enabled</span>
</div>
</div>
</div>
</div>
<div class="st-card st-plain">
<div class="st-body">
<h2 class="st-card-title">Unread & Alerts</h2>
<div class="st-no-box-list">
<div class="st-no-box-item">
<span>Unread Notifications</span>
<strong style="color:var(--st-orange)">2</strong>
</div>
<div class="st-no-box-item">
<span>High Priority Alerts</span>
<strong style="color:var(--st-orange)">1</strong>
</div>
<div class="st-no-box-item">
<span>Support Replies</span>
<strong style="color:var(--st-orange)">1</strong>
</div>
</div>
<button class="st-btn" style="margin-top:12px;width:100%" type="button" onclick="showSettingsToast('All notifications opened.')">View All Notifications</button>
</div>
</div>
<div class="st-card st-plain">
<div class="st-body">
<h2 class="st-card-title">Quick Actions</h2>
<div class="st-action-list">
<button class="st-setting-action" type="button" onclick="persistSettingsValue('notifications','test','sent','Test notification')">
<span>Test Notification</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="openSettingsModal('profileModal')">
<span>Update Contact Info</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Advanced notification preferences opened.')">
<span>Notification Preferences</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
</div>
</div>
</div>
<div class="st-card st-plain">
<div class="st-body">
<h2 class="st-card-title">Need Help?</h2>
<p class="st-card-desc">Our support team is here to help you.</p>
<button class="st-btn" style="margin-top:12px;width:100%" type="button" onclick="window.location.href='{{ Route::has('help-center') ? route('help-center') : '#' }}'">Contact Support</button>
</div>
</div>
</div>
</div>
</section>

{{-- NOTIFICATIONS CSS --}}
<style id="settings-notifications-css">
/* NOTIFICATIONS CSS: section-specific overrides/rules. */
#panel-security .st-settings-grid, #panel-notifications .st-notif-layout{grid-template-columns:minmax(0,1fr) 300px!important;gap:16px!important;align-items:start!important}
#panel-security .st-setting-side, #panel-notifications .st-notif-side{gap:14px!important}
#panel-profile .st-card-title,#panel-security .st-card-title,#panel-notifications .st-card-title,#panel-payments .st-card-title{font-family:'Poppins',system-ui,sans-serif;font-weight:600}
#panel-profile .st-card:first-child,#panel-profile .st-connected-card,#panel-security .st-setting-main>.st-card:first-child,#panel-security .st-login-tips-box,#panel-notifications .st-card:first-child,#panel-payments .st-billing-box{border-color:#111827}
#panel-notifications .st-notif-layout,#panel-payments .st-pay-layout{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:18px;align-items:start}
#panel-notifications .st-notif-side,#panel-payments .st-pay-side{display:flex;flex-direction:column;gap:16px}
#panel-notifications .st-notif-side>.st-card,#panel-payments .st-pay-side>.st-card{border:0!important;background:transparent!important;box-shadow:none!important}
#panel-notifications .st-notif-side>.st-card .st-body,#panel-payments .st-pay-side>.st-card .st-body{padding:0}
@media(max-width:1260px){#panel-profile .st-profile-grid,#panel-notifications .st-notif-layout,#panel-payments .st-pay-layout{grid-template-columns:1fr}
#panel-security .st-setting-side .st-score-ring, #panel-notifications .st-notif-side .st-score-ring{width:98px!important;height:98px!important;margin:8px auto!important}
#panel-security .st-setting-side .st-score-inner, #panel-notifications .st-notif-side .st-score-inner{width:74px!important;height:74px!important}
#panel-security .st-setting-side .st-score-inner strong, #panel-notifications .st-notif-side .st-score-inner strong{font-size:22px!important}
#panel-security .st-setting-side .st-check-line, #panel-notifications .st-notif-side .st-no-box-item, #panel-notifications .st-notif-side .st-setting-action{padding:6px 0!important;font-size:10.5px!important}
#panel-notifications .st-card:first-child .st-body{padding:12px 14px!important}
#panel-notifications .st-summary-strip{gap:6px!important}
#panel-notifications .st-summary-item{gap:7px!important}
#panel-notifications .st-channel-row{padding:7px 0!important;grid-template-columns:minmax(0,1.2fr) 58px 58px 58px 24px!important}
#panel-notifications .st-channel-row .st-orange-ico{width:30px!important;height:30px!important}
#panel-notifications .st-channel-row .st-sec-title{font-size:11px!important}
#panel-notifications .st-channel-row .st-sec-sub{font-size:9px!important;margin-top:2px!important}
#panel-security .st-setting-side .st-card-title, #panel-notifications .st-notif-side .st-card-title{font-size:13px!important}
#panel-security .st-setting-side .st-card-desc, #panel-notifications .st-notif-side .st-card-desc{font-size:9.5px!important;line-height:1.25!important}
#panel-security .st-setting-side .st-side-list, #panel-notifications .st-notif-side .st-no-box-list{gap:3px!important;margin-top:7px!important}
#panel-security .st-setting-side .st-side-row, #panel-security .st-setting-side .st-setting-action, #panel-notifications .st-notif-side .st-setting-action, #panel-notifications .st-notif-side .st-no-box-item{padding:5px 0!important}
#panel-security .st-setting-side .st-btn, #panel-notifications .st-notif-side .st-btn{height:36px!important;margin-top:8px!important}
#panel-notifications .st-notif-side{gap:8px!important}
#panel-notifications .st-card:first-child .st-body{padding:10px 12px!important}
#panel-notifications .st-channel-row{padding:5px 0!important}
#panel-notifications .st-summary-strip{margin-bottom:8px!important}
#panel-profile .st-profile-grid, #panel-security .st-settings-grid, #panel-notifications .st-notif-layout{grid-template-columns:minmax(0,1fr) 300px!important;gap:16px!important;align-items:start!important}
#panel-profile .st-profile-side, #panel-security .st-setting-side, #panel-notifications .st-notif-side{gap:8px!important}
#panel-profile .st-profile-side .st-card-title, #panel-security .st-setting-side .st-card-title, #panel-notifications .st-notif-side .st-card-title{font-size:13px!important}
#panel-profile .st-profile-side .st-card-desc, #panel-security .st-setting-side .st-card-desc, #panel-notifications .st-notif-side .st-card-desc{font-size:9.5px!important;line-height:1.25!important}
/* Box logic: main grouped boxes have subtle/black borders, requested plain sections have no outer box */ #panel-overview .overview-profile-box, #panel-overview .overview-payment-box, #panel-overview .overview-quick-panel, #panel-profile .st-card:first-child, #panel-security .st-setting-main>.st-card:first-child, #panel-notifications .st-card:first-child, #panel-payments .st-billing-box, .st-main-group{ border:1px solid rgba(17,24,39,.55)!important; border-radius:12px!important; background:#fff!important; box-shadow:0 8px 22px rgba(15,23,42,.045)!important; overflow:hidden!important; }
#panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel, #panel-overview .overview-privacy-panel, #panel-profile .st-profile-side .st-card, #panel-security .st-setting-side>.st-card, #panel-notifications .st-notif-side>.st-card, #panel-payments .st-pay-side>.st-card, .st-plain, .st-plain-panel{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; overflow:visible!important; }
.st-modal .st-actions .st-btn[type="submit"], #panel-profile .st-actions .st-btn, #panel-notifications .st-head .st-btn[onclick*="Save"], #panel-preferences .st-head .st-btn[onclick*="Save"]{ background:#16a34a!important; border-color:#16a34a!important; color:#fff!important; }
.st-modal .st-actions .st-btn[type="submit"]:hover, #panel-profile .st-actions .st-btn:hover, #panel-notifications .st-head .st-btn[onclick*="Save"]:hover, #panel-preferences .st-head .st-btn[onclick*="Save"]:hover{ background:#111827!important; border-color:#111827!important; color:#fff!important; }
/* Profile settings tab: same compact flow as My Profile */ #panel-profile .st-card-title, #panel-security .st-card-title, #panel-notifications .st-card-title, #panel-payments .st-card-title, #panel-addresses .st-card-title, #panel-preferences .st-card-title, #panel-privacy .st-card-title{ font-size:12.5px!important; letter-spacing:.025em!important; }
#panel-profile .st-card-desc, #panel-security .st-card-desc, #panel-notifications .st-card-desc, #panel-payments .st-card-desc, #panel-addresses .st-card-desc, #panel-preferences .st-card-desc, #panel-privacy .st-card-desc{ font-size:9.5px!important; line-height:1.35!important; }
/* Buttons and Date: one consistent My Profile-style button system */ .st-page .st-btn, .st-page .st-outline-btn, .st-page .st-date, .st-modal .st-actions .st-btn, #panel-profile .st-actions .st-btn, #panel-notifications .st-head .st-btn, #panel-preferences .st-head .st-btn{ height:36px!important; min-width:120px!important; padding:0 16px!important; border-radius:999px!important; border:1px solid transparent!important; background:linear-gradient(90deg,var(--st-primary-orange),var(--st-primary-orange-2))!important; color:#111827!important; font-family:'Poppins',system-ui,sans-serif!important; font-size:10.5px!important; font-weight:700!important; letter-spacing:.01em!important; display:inline-flex!important; align-items:center!important; justify-content:center!important; gap:7px!important; box-shadow:none!important; transform:none!important; white-space:nowrap!important; cursor:pointer!important; }
.st-page .st-btn:hover, .st-page .st-btn:focus-visible, .st-page .st-btn:active, .st-page .st-btn.is-clicked, .st-page .st-outline-btn:hover, .st-page .st-outline-btn:focus-visible, .st-page .st-outline-btn:active, .st-page .st-outline-btn.is-clicked, .st-page .st-date:hover, .st-page .st-date:focus-visible, .st-modal .st-actions .st-btn:hover, .st-modal .st-actions .st-btn:focus-visible, #panel-profile .st-actions .st-btn:hover, #panel-notifications .st-head .st-btn:hover, #panel-preferences .st-head .st-btn:hover{ background:var(--st-action-hover)!important; border-color:var(--st-action-hover)!important; color:#fff!important; box-shadow:none!important; outline:none!important; transform:none!important; }
/* Unified Profile Completion / Security Score / Notification Summary rings */ .st-score-ring, #panel-profile .st-profile-side .st-score-ring, #panel-security .st-setting-side .st-score-ring, #panel-notifications .st-notif-side .st-score-ring, .st-section-layout .st-section-side .st-score-ring{ width:112px!important; height:112px!important; margin:10px auto 12px!important; border-radius:50%!important; background:conic-gradient(var(--st-primary-orange) 0 331deg,#f1f5f9 331deg 360deg)!important; display:grid!important; place-items:center!important; box-shadow:0 8px 22px rgba(255,122,0,.14)!important; }
.st-score-inner, #panel-profile .st-profile-side .st-score-inner, #panel-security .st-setting-side .st-score-inner, #panel-notifications .st-notif-side .st-score-inner, .st-section-layout .st-section-side .st-score-inner{ width:82px!important; height:82px!important; border-radius:50%!important; background:#fff!important; display:grid!important; place-items:center!important; text-align:center!important; border:1px solid #fff3e6!important; }
.st-score-inner strong, #panel-profile .st-profile-side .st-score-inner strong, #panel-security .st-setting-side .st-score-inner strong, #panel-notifications .st-notif-side .st-score-inner strong, .st-section-layout .st-section-side .st-score-inner strong{ font-family:'Poppins',system-ui,sans-serif!important; font-size:24px!important; line-height:1!important; color:#111827!important; font-weight:800!important; }
.st-score-inner span, #panel-profile .st-profile-side .st-score-inner span, #panel-security .st-setting-side .st-score-inner span, #panel-notifications .st-notif-side .st-score-inner span, .st-section-layout .st-section-side .st-score-inner span{ color:var(--st-primary-orange)!important; font-size:10px!important; font-weight:800!important; text-transform:uppercase!important; letter-spacing:.03em!important; }
/* Icon-only colors: no background shape, varied colors per function */ #panel-overview .st-orange-ico, #panel-overview .st-ico, #panel-profile .st-score-ring ~ .st-no-box-list .st-orange-ico, #panel-security .st-orange-ico, #panel-notifications .st-orange-ico{ background:transparent!important; border:0!important; border-radius:0!important; width:22px!important; height:22px!important; flex:0 0 22px!important; color:var(--st-orange)!important; }
/* Score circles equalized */ #panel-profile .st-score-ring, #panel-security .st-score-ring, #panel-notifications .st-score-ring{ width:108px!important; height:108px!important; margin:8px auto 12px!important; background:conic-gradient(#ff7a00 0 331deg,#e5e7eb 331deg 360deg)!important; }
#panel-profile .st-score-inner, #panel-security .st-score-inner, #panel-notifications .st-score-inner{ width:80px!important; height:80px!important; background:#fff!important; }
#panel-profile .st-score-inner strong, #panel-security .st-score-inner strong, #panel-notifications .st-score-inner strong{ font-size:23px!important; color:#111827!important; }
#panel-profile .st-score-inner span, #panel-security .st-score-inner span, #panel-notifications .st-score-inner span{ color:#16a34a!important; font-size:9.5px!important; font-weight:700!important; }
#panel-notifications .st-notif-side .st-action-list .st-setting-action,
#panel-notifications .st-notif-side .st-action-list .st-setting-action:hover,
#panel-notifications .st-card-title,
#panel-notifications .st-card-desc,
</style>

{{-- NOTIFICATIONS JS --}}
<script id="settings-notifications-js">
/* NOTIFICATIONS JS: uses global functions from OVERVIEW JS: toggleSettingMessage() and notification preference listeners. */
</script>



{{-- =========================================================
   //PAYMENTS//
   HTML + CSS + JS CODES NG PAYMENTS
   ========================================================= --}}

{{-- PAYMENTS HTML --}}
<section id="panel-payments" class="st-panel">
<div class="st-pay-layout">
<div class="st-card st-billing-box">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Billing Address</h2>
<p class="st-card-desc">Use this address for invoices, receipts, and official billing records.</p>
</div>
<button class="st-btn" type="button" data-modal-open="addressModal">Edit Address</button>
</div>
<div class="st-address-grid">
<div class="st-box">
<span class="st-mini orange">Primary</span>
<h3 class="st-box-title">Home Billing</h3>
<p class="st-box-text">123 Printify Avenue<br>Makati City, Metro Manila 1200<br>Philippines<br>+63 912 345 6789</p>
</div>
<div class="st-box">
<h3 class="st-box-title">Business Billing</h3>
<p class="st-box-text">45 Timog Avenue<br>Quezon City, Metro Manila 1103<br>Philippines<br>{{ $settingsEmail ?: 'Email not set' }}</p>
</div>
<button class="st-add-box" type="button" data-modal-open="addressModal">
<span class="st-add-circle">
<i class="fa-solid fa-plus">
</i>
</span>Add Billing Address</button>
</div>
<div class="st-section-line">
</div>
<div class="st-head">
<div>
<h2 class="st-card-title">Preferred Payment</h2>
<p class="st-card-desc">Cards and wallets used for checkout and automatic billing.</p>
</div>
<button class="st-btn" type="button" data-modal-open="paymentModal">Add Payment Method</button>
</div>
<div class="st-list">
<div class="st-pay-item">
<div class="st-pay-left">
<div class="st-card-logo visa">
<i class="fa-brands fa-cc-visa">
</i>
</div>
<div class="st-pay-text">
<p class="st-pay-title">Visa ending in 4242</p>
<p class="st-pay-sub">Primary card · Expires 12/27</p>
</div>
</div>
<span class="st-mini orange">Primary</span>
</div>
</div>
<div class="st-section-line">
</div>
<div class="st-head">
<div>
<h2 class="st-card-title">Invoice & Billing</h2>
<p class="st-card-desc">Manage invoices, receipts, and billing preferences.</p>
</div>
<button class="st-btn" type="button" onclick="showSettingsToast('Invoice center opened.')">Open Invoices</button>
</div>
<div class="st-channel-row" style="grid-template-columns:minmax(0,1fr) 140px 110px 110px">
<div class="st-comm-left">
<span class="st-orange-ico">
<i class="fa-solid fa-file-invoice">
</i>
</span>
<div>
<p class="st-sec-title">Monthly Invoice</p>
<p class="st-sec-sub">Automatically send PDF invoice every month.</p>
</div>
</div>
<span class="st-status-pill">Enabled</span>
<button class="st-link" type="button" onclick="showSettingsToast('Invoice downloaded.')">Download</button>
<button class="st-link" type="button" onclick="showSettingsToast('Invoice emailed.')">Email</button>
</div>
<div class="st-section-line">
</div>
<div class="st-head">
<div>
<h2 class="st-card-title">Billing Activity</h2>
<p class="st-card-desc">Latest payment and checkout activity.</p>
</div>
<button class="st-btn" type="button" onclick="showSettingsToast('Full billing history opened.')">View History</button>
</div>
<div class="st-table-lite">
<div class="st-table-lite-row">
<strong>Document Printing</strong>
<span>Paid</span>
<span>Jun 05, 2026<br>PHP 1,200.00</span>
</div>
<div class="st-table-lite-row">
<strong>Photo Services</strong>
<span>Processing</span>
<span>Jun 03, 2026<br>PHP 850.00</span>
</div>
<div class="st-table-lite-row">
<strong>Large Format Printing</strong>
<span>Paid</span>
<span>May 30, 2026<br>PHP 2,100.00</span>
</div>
</div>
</div>
</div>
<div class="st-pay-side">
<div class="st-card st-plain">
<div class="st-body">
<h2 class="st-card-title">Payment Summary</h2>
<div class="st-stat-row" style="margin-top:12px">
<div class="st-stat-tile">
<span class="st-orange-ico">
<i class="fa-solid fa-wallet">
</i>
</span>
<div>
<p class="st-sec-title">3</p>
<p class="st-sec-sub">Saved Methods</p>
</div>
</div>
<div class="st-stat-tile">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-check">
</i>
</span>
<div>
<p class="st-sec-title">2</p>
<p class="st-sec-sub">Verified</p>
</div>
</div>
</div>
</div>
</div>
<div class="st-card st-plain">
<div class="st-body">
<h2 class="st-card-title">Secured Payment</h2>
<div class="st-no-box-list">
<div class="st-no-box-item">
<span>Encrypted checkout</span>
<i class="fa-solid fa-circle-check" style="color:var(--st-green)">
</i>
</div>
<div class="st-no-box-item">
<span>Card data protected</span>
<i class="fa-solid fa-circle-check" style="color:var(--st-green)">
</i>
</div>
<div class="st-no-box-item">
<span>Fraud monitoring</span>
<i class="fa-solid fa-circle-check" style="color:var(--st-green)">
</i>
</div>
</div>
</div>
</div>
<div class="st-card st-plain">
<div class="st-body">
<h2 class="st-card-title">Billing Help</h2>
<div class="st-action-list">
<button class="st-setting-action" type="button" onclick="showSettingsToast('Receipt guide opened.')">
<span>How to read receipts</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Refund policy opened.')">
<span>Refund policy</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
</div>
</div>
</div>
<div class="st-card st-plain">
<div class="st-body">
<h2 class="st-card-title">Need More Help?</h2>
<p class="st-card-desc">Contact support for billing questions.</p>
<button class="st-btn" style="margin-top:12px;width:100%" type="button" onclick="window.location.href='{{ Route::has('help-center') ? route('help-center') : '#' }}'">Contact Support</button>
</div>
</div>
</div>
</div>
</section>

<!-- PAYMENT MODAL HTML -->
<div id="paymentModal" class="st-modal">
<div class="st-modal-bg" data-modal-close>
</div>
<div class="st-modal-shell">
<div class="st-modal-card">
<div class="st-modal-head">
<div>
<h3 class="st-modal-title">Add Payment Method</h3>
<p class="st-modal-desc">Add a card or digital wallet.</p>
</div>
<button type="button" class="st-close" data-modal-close>×</button>
</div>
<form class="st-modal-body" onsubmit="saveGenericSettings(event,'Payment method saved successfully.')">
<div class="st-field">
<label>Cardholder Name</label>
<input class="st-input" placeholder="{{ $settingsName ?: 'Cardholder name' }}">
</div>
<div class="st-field" style="margin-top:12px">
<label>Card Number</label>
<input class="st-input" placeholder="0000 0000 0000 0000">
</div>
<div class="st-form-grid" style="margin-top:12px">
<div class="st-field">
<label>Expiry</label>
<input class="st-input" placeholder="MM/YY">
</div>
<div class="st-field">
<label>CVC</label>
<input class="st-input" placeholder="123">
</div>
</div>
<div class="st-actions">
<button type="button" class="st-btn" data-modal-close>Cancel</button>
<button type="submit" class="st-btn">Save Payment</button>
</div>
</form>
</div>
</div>
</div>

{{-- PAYMENTS CSS --}}
<style id="settings-payments-css">
/* PAYMENTS CSS: section-specific overrides/rules. */
#panel-profile .st-card-title,#panel-security .st-card-title,#panel-notifications .st-card-title,#panel-payments .st-card-title{font-family:'Poppins',system-ui,sans-serif;font-weight:600}
#panel-profile .st-card:first-child,#panel-profile .st-connected-card,#panel-security .st-setting-main>.st-card:first-child,#panel-security .st-login-tips-box,#panel-notifications .st-card:first-child,#panel-payments .st-billing-box{border-color:#111827}
#panel-notifications .st-notif-layout,#panel-payments .st-pay-layout{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:18px;align-items:start}
#panel-notifications .st-notif-side,#panel-payments .st-pay-side{display:flex;flex-direction:column;gap:16px}
#panel-notifications .st-notif-side>.st-card,#panel-payments .st-pay-side>.st-card{border:0!important;background:transparent!important;box-shadow:none!important}
#panel-notifications .st-notif-side>.st-card .st-body,#panel-payments .st-pay-side>.st-card .st-body{padding:0}
@media(max-width:1260px){#panel-profile .st-profile-grid,#panel-notifications .st-notif-layout,#panel-payments .st-pay-layout{grid-template-columns:1fr}
#panel-payments .st-billing-box{border:1px solid #111827!important;border-radius:14px!important;background:#fff!important}
#panel-payments .st-pay-side>.st-card{border:0!important;background:transparent!important;box-shadow:none!important}
#panel-payments .st-pay-side>.st-card>.st-body{padding:0!important}
@media(max-width:1260px){.st-section-layout,#panel-payments .st-pay-layout{grid-template-columns:1fr!important}
/* Box logic: main grouped boxes have subtle/black borders, requested plain sections have no outer box */ #panel-overview .overview-profile-box, #panel-overview .overview-payment-box, #panel-overview .overview-quick-panel, #panel-profile .st-card:first-child, #panel-security .st-setting-main>.st-card:first-child, #panel-notifications .st-card:first-child, #panel-payments .st-billing-box, .st-main-group{ border:1px solid rgba(17,24,39,.55)!important; border-radius:12px!important; background:#fff!important; box-shadow:0 8px 22px rgba(15,23,42,.045)!important; overflow:hidden!important; }
#panel-overview .overview-comm-panel, #panel-overview .overview-prefs-panel, #panel-overview .overview-activity-panel, #panel-overview .overview-privacy-panel, #panel-profile .st-profile-side .st-card, #panel-security .st-setting-side>.st-card, #panel-notifications .st-notif-side>.st-card, #panel-payments .st-pay-side>.st-card, .st-plain, .st-plain-panel{ border:0!important; border-radius:0!important; background:transparent!important; box-shadow:none!important; overflow:visible!important; }
/* Profile settings tab: same compact flow as My Profile */ #panel-profile .st-card-title, #panel-security .st-card-title, #panel-notifications .st-card-title, #panel-payments .st-card-title, #panel-addresses .st-card-title, #panel-preferences .st-card-title, #panel-privacy .st-card-title{ font-size:12.5px!important; letter-spacing:.025em!important; }
#panel-profile .st-card-desc, #panel-security .st-card-desc, #panel-notifications .st-card-desc, #panel-payments .st-card-desc, #panel-addresses .st-card-desc, #panel-preferences .st-card-desc, #panel-privacy .st-card-desc{ font-size:9.5px!important; line-height:1.35!important; }
#panel-payments .st-pay-side .st-action-list .st-setting-action{
#panel-payments .st-pay-side .st-action-list .st-setting-action:hover{
#panel-payments .st-card-title,
#panel-payments .st-card-desc,
</style>

{{-- PAYMENTS JS --}}
<script id="settings-payments-js">
/* PAYMENTS JS: uses global functions from OVERVIEW JS: openPaymentActions(), paymentModal open/save handlers, and billing helper modal. */
</script>



{{-- =========================================================
   //ADDRESSES//
   HTML + CSS + JS CODES NG ADDRESSES
   ========================================================= --}}

{{-- ADDRESSES HTML --}}
<section id="panel-addresses" class="st-panel">
<div class="st-section-layout">
<div class="st-section-main">
<div class="st-card st-main-group">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Manage Your Addresses</h2>
<p class="st-card-desc">Add, edit, and organize shipping, billing, and pickup addresses.</p>
</div>
<button class="st-btn" type="button" data-modal-open="addressModal">
<i class="fa-solid fa-plus">
</i> Add Address</button>
</div>
<div class="st-mini-tabs">
<span class="active">Shipping Addresses <b class="st-mini">2</b>
</span>
<span>Billing Address <b class="st-mini">1</b>
</span>
<span>Pickup & Branch <b class="st-mini">1</b>
</span>
</div>
<div class="st-line-row st-address-row">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-house">
</i>
</span>
<div>
<p class="st-sec-title">Eyra Mae Alla <span class="st-mini">Default</span>
</p>
<p class="st-sec-sub">
<i class="fa-solid fa-phone">
</i> +63 912 345 6789<br>Blk 6 Lot 8 Ninada St. Litex Rd.<br>Commonwealth, Quezon City, Metro Manila 1121<br>Estimated Delivery: 2-4 business days</p>
</div>
<div class="st-row-actions">
<div class="st-map-mini">
<i class="fa-solid fa-location-dot">
</i>
</div>
<button class="st-outline-btn" type="button" data-modal-open="addressModal">
<i class="fa-regular fa-pen-to-square">
</i> Edit</button>
<button class="st-link" type="button" onclick="showSettingsToast('Address duplicated.')">Duplicate</button>
</div>
</div>
<div class="st-line-row st-address-row">
<span class="st-orange-ico" style="background:#f4efff;color:#7c3aed">
<i class="fa-solid fa-building">
</i>
</span>
<div>
<p class="st-sec-title">Mae Alla <span class="st-mini gray">Work</span>
</p>
<p class="st-sec-sub">
<i class="fa-solid fa-phone">
</i> +63 917 888 2345<br>14F Printify Tower, 32nd St. Corner 9th Ave.<br>Bonifacio Global City, Taguig City, Metro Manila 1634<br>Estimated Delivery: 1-3 business days</p>
</div>
<div class="st-row-actions">
<div class="st-map-mini" style="color:#7c3aed;background:linear-gradient(135deg,#f4efff,#eef4ff)">
<i class="fa-solid fa-location-dot">
</i>
</div>
<button class="st-outline-btn" type="button" data-modal-open="addressModal">
<i class="fa-regular fa-pen-to-square">
</i> Edit</button>
<button class="st-link" type="button" onclick="showSettingsToast('Work address duplicated.')">Duplicate</button>
<button class="st-link" style="color:var(--st-danger)" type="button" onclick="showSettingsToast('Delete confirmation opened.')">Delete</button>
</div>
</div>
<div class="st-line-row st-address-row">
<span class="st-orange-ico">
<i class="fa-solid fa-store">
</i>
</span>
<div>
<p class="st-sec-title">PrintifyCo. SM North EDSA Branch <span class="st-mini orange">Branch Pickup</span>
</p>
<p class="st-sec-sub">
<i class="fa-solid fa-phone">
</i> +63 2 8356 7890<br>SM City North EDSA, The Block, 2nd Level<br>Epifanio de los Santos Ave., Quezon City, 1105<br>Pick-up Hours: Mon-Sun, 10:00 AM - 9:00 PM</p>
</div>
<div class="st-row-actions">
<div class="st-map-mini" style="color:var(--st-orange);background:linear-gradient(135deg,#fff3e6,#eef4ff)">
<i class="fa-solid fa-location-dot">
</i>
</div>
<button class="st-outline-btn" type="button" data-modal-open="addressModal">
<i class="fa-regular fa-pen-to-square">
</i> Edit</button>
<button class="st-link" type="button" onclick="showSettingsToast('Branch duplicated.')">Duplicate</button>
</div>
</div>
<div class="st-tip-inline">
<i class="fa-solid fa-circle-info">
</i> Tip: Set a default shipping address to save time during checkout. <button class="st-link" type="button" onclick="showSettingsToast('Address tips opened.')">Learn More</button>
</div>
</div>
</div>
</div>
<div class="st-section-side">
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Address Summary</h2>
<div class="st-no-box-list" style="margin-top:8px">
<div class="st-right-metric">
<span>Shipping Addresses</span>
<strong>2</strong>
</div>
<div class="st-right-metric">
<span>Billing Address</span>
<strong>1</strong>
</div>
<div class="st-right-metric">
<span>Pickup / Branch</span>
<strong>1</strong>
</div>
<div class="st-right-metric">
<span>Total Saved Addresses</span>
<strong>4</strong>
</div>
</div>
</div>
</div>
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Delivery Preferences</h2>
<div class="st-no-box-list" style="margin-top:8px">
<div class="st-right-metric">
<span>Preferred Courier</span>
<strong style="color:var(--st-orange)">J&T Express</strong>
</div>
<div class="st-right-metric">
<span>Delivery Speed</span>
<span>Standard</span>
</div>
<div class="st-right-metric">
<span>Weekend Delivery</span>
<span class="st-status-pill">Enabled</span>
</div>
<div class="st-right-metric">
<span>Leave at Door</span>
<span class="st-status-pill">Enabled</span>
</div>
</div>
<button class="st-btn" style="width:100%;margin-top:10px" type="button" onclick="showSettingsToast('Delivery preferences opened.')">Manage Preferences</button>
</div>
</div>
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Quick Tips</h2>
<div class="st-action-list" style="margin-top:8px">
<button class="st-setting-action" type="button" onclick="showSettingsToast('Default address guide opened.')">
<span>Set a default address<br>
<small>Save time at checkout.</small>
</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Address update guide opened.')">
<span>Keep addresses updated<br>
<small>Make sure delivery info is current.</small>
</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Branch pickup guide opened.')">
<span>Use branch pickup<br>
<small>Pickup at a nearby branch.</small>
</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- ADDRESS MODAL HTML -->
<div id="addressModal" class="st-modal">
<div class="st-modal-bg" data-modal-close>
</div>
<div class="st-modal-shell">
<div class="st-modal-card">
<div class="st-modal-head">
<div>
<h3 class="st-modal-title">Manage Address</h3>
<p class="st-modal-desc">Add a shipping or pickup address.</p>
</div>
<button type="button" class="st-close" data-modal-close>×</button>
</div>
<form class="st-modal-body" onsubmit="saveAddressModal(event)">
<input id="addressModeInput" type="hidden" value="new">
<input id="addressTargetInput" type="hidden" value="">
<div class="st-field">
<label>Address Label</label>
<input id="addressLabelInput" class="st-input" placeholder="Home, Work, Branch, etc." required>
</div>
<div class="st-field" style="margin-top:12px">
<label>Complete Address</label>
<textarea id="addressFullInput" class="st-textarea" placeholder="Street, barangay, city, province, ZIP code" required>
</textarea>
</div>
<div class="st-actions">
<button type="button" class="st-btn" data-modal-close>Cancel</button>
<button type="submit" class="st-btn">Save Address</button>
</div>
</form>
</div>
</div>
</div>

{{-- ADDRESSES CSS --}}
<style id="settings-addresses-css">
/* ADDRESSES CSS: section-specific overrides/rules. */
#panel-addresses .st-address-grid{grid-template-columns:1fr!important;gap:0!important}
#panel-addresses .st-address-row{grid-template-columns:38px minmax(0,1fr) minmax(190px,auto)}
.st-line-row,#panel-addresses .st-address-row{grid-template-columns:1fr}
/* Profile settings tab: same compact flow as My Profile */ #panel-profile .st-card-title, #panel-security .st-card-title, #panel-notifications .st-card-title, #panel-payments .st-card-title, #panel-addresses .st-card-title, #panel-preferences .st-card-title, #panel-privacy .st-card-title{ font-size:12.5px!important; letter-spacing:.025em!important; }
#panel-profile .st-card-desc, #panel-security .st-card-desc, #panel-notifications .st-card-desc, #panel-payments .st-card-desc, #panel-addresses .st-card-desc, #panel-preferences .st-card-desc, #panel-privacy .st-card-desc{ font-size:9.5px!important; line-height:1.35!important; }
#panel-addresses .st-row-actions .st-link{display:none!important;}
#panel-addresses .st-address-row{
#panel-addresses .st-row-actions{
#panel-addresses .st-row-actions .st-outline-btn{
#panel-addresses .st-map-mini{
#panel-addresses .st-card-title,
#panel-addresses .st-card-desc,
#panel-addresses .st-address-row{grid-template-columns:1fr!important;}
#panel-addresses .st-row-actions{justify-content:center!important;}
#panel-addresses .st-map-mini{width:100%!important;}
</style>

{{-- ADDRESSES JS --}}
<script id="settings-addresses-js">
/* ADDRESSES JS: uses global functions from OVERVIEW JS: openNewAddressModal(), fillAddressModal(), saveAddressModal(), openAddressActions(), setPrimaryAddress(), removeOverviewAddress(). */
</script>



{{-- =========================================================
   //PREFERENCES//
   HTML + CSS + JS CODES NG PREFERENCES
   ========================================================= --}}

{{-- PREFERENCES HTML --}}
<section id="panel-preferences" class="st-panel">
<div class="st-section-layout">
<div class="st-section-main">
<div class="st-card st-main-group">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Region & Localization</h2>
<p class="st-card-desc">Set your language, currency, time zone, and date format.</p>
</div>
<button class="st-btn" type="button" onclick="saveGenericSettings(event,'Localization preferences saved.')">Save Preferences</button>
</div>
<div class="st-form-grid">
<div class="st-field">
<label>Language</label>
<select class="st-input" onchange="persistSettingsValue('preferences','language',this.value,'Language')">
<option>English</option>
<option>Filipino</option>
</select>
</div>
<div class="st-field">
<label>Currency</label>
<select class="st-input" onchange="persistSettingsValue('preferences','currency',this.value,'Currency')">
<option>Philippine Peso (PHP)</option>
<option>US Dollar (USD)</option>
</select>
</div>
<div class="st-field">
<label>Time Zone</label>
<select class="st-input" onchange="persistSettingsValue('preferences','timezone',this.value,'Time zone')">
<option>(GMT+08:00) Manila</option>
<option>(GMT+08:00) Singapore</option>
</select>
</div>
<div class="st-field">
<label>Date Format</label>
<select class="st-input" onchange="persistSettingsValue('preferences','date_format',this.value,'Date format')">
<option>MM/DD/YYYY</option>
<option>DD/MM/YYYY</option>
</select>
</div>
</div>
<div class="st-section-line">
</div>
<div class="st-head" style="margin-bottom:8px">
<div>
<h2 class="st-card-title">Appearance & Display</h2>
<p class="st-card-desc">Choose how the dashboard looks and feels.</p>
</div>
</div>
<div class="st-line-row">
<span class="st-orange-ico">
<i class="fa-solid fa-sun">
</i>
</span>
<div>
<p class="st-sec-title">Theme Mode</p>
<p class="st-sec-sub">Light mode is active.</p>
</div>
<select class="st-input" style="max-width:160px" onchange="persistSettingsValue('preferences','theme',this.value,'Theme')">
<option>Light</option>
<option>Dark</option>
</select>
</div>
<div class="st-line-row">
<span class="st-orange-ico" style="background:#eef4ff;color:#2563eb">
<i class="fa-solid fa-palette">
</i>
</span>
<div>
<p class="st-sec-title">Accent Color</p>
<p class="st-sec-sub">Orange is used for primary actions.</p>
</div>
<span class="st-status-pill orange">Orange</span>
</div>
</div>
</div>
<div class="st-card st-main-group">
<div class="st-body">
<div class="st-head">
<div>
<h2 class="st-card-title">Accessibility</h2>
<p class="st-card-desc">Make controls easier to read and use.</p>
</div>
</div>
<div class="st-line-row">
<span class="st-orange-ico">
<i class="fa-solid fa-eye">
</i>
</span>
<div>
<p class="st-sec-title">High Contrast Mode</p>
<p class="st-sec-sub">Improve contrast for important controls.</p>
</div>
<label class="st-switch">
<input type="checkbox" onchange="toggleSettingMessage(this,'High contrast mode')">
<span class="st-slider">
</span>
</label>
</div>
<div class="st-line-row">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-keyboard">
</i>
</span>
<div>
<p class="st-sec-title">Keyboard Shortcuts</p>
<p class="st-sec-sub">Enable shortcut keys across the portal.</p>
</div>
<label class="st-switch">
<input type="checkbox" checked onchange="toggleSettingMessage(this,'Keyboard shortcuts')">
<span class="st-slider">
</span>
</label>
</div>
<div class="st-section-line">
</div>
<div class="st-head" style="margin-bottom:8px">
<div>
<h2 class="st-card-title">Communication & Reminders</h2>
<p class="st-card-desc">Control alerts and reminder behavior.</p>
</div>
</div>
<div class="st-line-row">
<span class="st-orange-ico">
<i class="fa-solid fa-bell">
</i>
</span>
<div>
<p class="st-sec-title">Order Updates</p>
<p class="st-sec-sub">Notify me about order and delivery progress.</p>
</div>
<label class="st-switch">
<input type="checkbox" checked onchange="toggleSettingMessage(this,'Order reminders')">
<span class="st-slider">
</span>
</label>
</div>
<div class="st-line-row">
<span class="st-orange-ico" style="background:#eef4ff;color:#2563eb">
<i class="fa-solid fa-comment-dots">
</i>
</span>
<div>
<p class="st-sec-title">Message Reminders</p>
<p class="st-sec-sub">Remind me when support replies arrive.</p>
</div>
<label class="st-switch">
<input type="checkbox" checked onchange="toggleSettingMessage(this,'Message reminders')">
<span class="st-slider">
</span>
</label>
</div>
</div>
</div>
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Dashboard Display</h2>
<div class="st-action-list">
<button class="st-setting-action" type="button" onclick="showSettingsToast('Dashboard display opened.')">
<span>Show revenue cards</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Dashboard widgets reordered.')">
<span>Manage widgets</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
</div>
</div>
</div>
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Order & Design Workspace</h2>
<div class="st-action-list">
<button class="st-setting-action" type="button" onclick="showSettingsToast('Order workspace opened.')">
<span>Default order view</span>
<span>Card View</span>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Design settings opened.')">
<span>Design tools mode</span>
<span>Advanced</span>
</button>
</div>
</div>
</div>
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Saved & Print</h2>
<div class="st-action-list">
<button class="st-setting-action" type="button" onclick="showSettingsToast('Print output preferences opened.')">
<span>Default paper size</span>
<span>A4</span>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Saved files preferences opened.')">
<span>Auto-save designs</span>
<span class="st-status-pill">Enabled</span>
</button>
</div>
</div>
</div>
</div>
<div class="st-section-side">
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Your Preferences Summary</h2>
<div class="st-no-box-list" style="margin-top:8px">
<div class="st-right-metric">
<span>Language</span>
<strong>English</strong>
</div>
<div class="st-right-metric">
<span>Currency</span>
<strong>PHP</strong>
</div>
<div class="st-right-metric">
<span>Time Zone</span>
<strong>Manila</strong>
</div>
<div class="st-right-metric">
<span>Theme</span>
<strong>Light</strong>
</div>
</div>
</div>
</div>
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Quick Personalization</h2>
<div class="st-action-list" style="margin-top:8px">
<button class="st-setting-action" type="button" onclick="showSettingsToast('Dashboard personalization opened.')">
<span>Set your dashboard layout</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Color settings opened.')">
<span>Choose accent color</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Theme guide opened.')">
<span>Try dark mode</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
</div>
</div>
</div>
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Need Help?</h2>
<p class="st-card-desc">Quick access to preference support.</p>
<button class="st-btn" style="width:100%;margin-top:10px" type="button" onclick="window.location.href='{{ Route::has('help-center') ? route('help-center') : '#' }}'">Visit Help Center</button>
</div>
</div>
</div>
</div>
</section>

{{-- PREFERENCES CSS --}}
<style id="settings-preferences-css">
/* PREFERENCES CSS: section-specific overrides/rules. */
#panel-preferences .st-section-main .st-plain-panel, #panel-privacy .st-section-main .st-plain-panel{border:0!important;background:transparent!important}
.st-modal .st-actions .st-btn[type="submit"], #panel-profile .st-actions .st-btn, #panel-notifications .st-head .st-btn[onclick*="Save"], #panel-preferences .st-head .st-btn[onclick*="Save"]{ background:#16a34a!important; border-color:#16a34a!important; color:#fff!important; }
.st-modal .st-actions .st-btn[type="submit"]:hover, #panel-profile .st-actions .st-btn:hover, #panel-notifications .st-head .st-btn[onclick*="Save"]:hover, #panel-preferences .st-head .st-btn[onclick*="Save"]:hover{ background:#111827!important; border-color:#111827!important; color:#fff!important; }
/* Profile settings tab: same compact flow as My Profile */ #panel-profile .st-card-title, #panel-security .st-card-title, #panel-notifications .st-card-title, #panel-payments .st-card-title, #panel-addresses .st-card-title, #panel-preferences .st-card-title, #panel-privacy .st-card-title{ font-size:12.5px!important; letter-spacing:.025em!important; }
#panel-profile .st-card-desc, #panel-security .st-card-desc, #panel-notifications .st-card-desc, #panel-payments .st-card-desc, #panel-addresses .st-card-desc, #panel-preferences .st-card-desc, #panel-privacy .st-card-desc{ font-size:9.5px!important; line-height:1.35!important; }
#panel-profile .st-input, #panel-preferences .st-input, #panel-privacy select{ min-height:38px!important; font-size:10.5px!important; border-radius:10px!important; }
/* Buttons and Date: one consistent My Profile-style button system */ .st-page .st-btn, .st-page .st-outline-btn, .st-page .st-date, .st-modal .st-actions .st-btn, #panel-profile .st-actions .st-btn, #panel-notifications .st-head .st-btn, #panel-preferences .st-head .st-btn{ height:36px!important; min-width:120px!important; padding:0 16px!important; border-radius:999px!important; border:1px solid transparent!important; background:linear-gradient(90deg,var(--st-primary-orange),var(--st-primary-orange-2))!important; color:#111827!important; font-family:'Poppins',system-ui,sans-serif!important; font-size:10.5px!important; font-weight:700!important; letter-spacing:.01em!important; display:inline-flex!important; align-items:center!important; justify-content:center!important; gap:7px!important; box-shadow:none!important; transform:none!important; white-space:nowrap!important; cursor:pointer!important; }
.st-page .st-btn:hover, .st-page .st-btn:focus-visible, .st-page .st-btn:active, .st-page .st-btn.is-clicked, .st-page .st-outline-btn:hover, .st-page .st-outline-btn:focus-visible, .st-page .st-outline-btn:active, .st-page .st-outline-btn.is-clicked, .st-page .st-date:hover, .st-page .st-date:focus-visible, .st-modal .st-actions .st-btn:hover, .st-modal .st-actions .st-btn:focus-visible, #panel-profile .st-actions .st-btn:hover, #panel-notifications .st-head .st-btn:hover, #panel-preferences .st-head .st-btn:hover{ background:var(--st-action-hover)!important; border-color:var(--st-action-hover)!important; color:#fff!important; box-shadow:none!important; outline:none!important; transform:none!important; }
#panel-preferences .st-card-title,
#panel-preferences .st-card-desc,
#panel-preferences .st-input,
</style>

{{-- PREFERENCES JS --}}
<script id="settings-preferences-js">
/* PREFERENCES JS: uses global functions from OVERVIEW JS: persistSettingsValue(), saveGenericSettings(), select change listeners, and save-button flow. */
</script>



{{-- =========================================================
   //PRIVACY//
   HTML + CSS + JS CODES NG PRIVACY
   ========================================================= --}}

{{-- PRIVACY HTML --}}
<section id="panel-privacy" class="st-panel">
<div class="st-section-layout">
<div class="st-section-main">
<div class="st-card st-main-group">
<div class="st-body">
<div class="st-privacy-panel-row">
<div class="st-comm-left">
<span class="st-orange-ico">
<i class="fa-regular fa-user">
</i>
</span>
<div>
<h2 class="st-card-title">Profile Visibility</h2>
<p class="st-card-desc">Control what information is visible to other users.</p>
</div>
</div>
<div>
<div class="st-privacy-control">
<div>
<p class="st-sec-title">Profile Visibility</p>
<p class="st-sec-sub">Choose who can view your profile information.</p>
</div>
<select onchange="persistSettingsValue('privacy','profile_visibility',this.value,'Profile visibility')">
<option>Everyone</option>
<option>Customers only</option>
<option>Only Me</option>
</select>
</div>
<div class="st-privacy-control">
<div>
<p class="st-sec-title">Show Member Since Date</p>
<p class="st-sec-sub">Allow others to see when you joined.</p>
</div>
<label class="st-switch">
<input type="checkbox" checked onchange="toggleSettingMessage(this,'Show member since date')">
<span class="st-slider">
</span>
</label>
</div>
</div>
</div>
<div class="st-privacy-panel-row">
<div class="st-comm-left">
<span class="st-orange-ico" style="background:#fff1f2;color:#e11d48">
<i class="fa-solid fa-lock">
</i>
</span>
<div>
<h2 class="st-card-title">Order Visibility</h2>
<p class="st-card-desc">Choose who can view your orders and purchase activity.</p>
</div>
</div>
<div>
<div class="st-privacy-control">
<div>
<p class="st-sec-title">Order History Visibility</p>
<p class="st-sec-sub">Control who can see your past orders.</p>
</div>
<select onchange="persistSettingsValue('privacy','order_visibility',this.value,'Order visibility')">
<option>Only Me</option>
<option>Support Team</option>
<option>Everyone</option>
</select>
</div>
<div class="st-privacy-control">
<div>
<p class="st-sec-title">Show Product Reviews</p>
<p class="st-sec-sub">Show your product reviews and ratings.</p>
</div>
<label class="st-switch">
<input type="checkbox" checked onchange="toggleSettingMessage(this,'Product reviews visibility')">
<span class="st-slider">
</span>
</label>
</div>
</div>
</div>
<div class="st-privacy-panel-row">
<div class="st-comm-left">
<span class="st-orange-ico">
<i class="fa-solid fa-bullhorn">
</i>
</span>
<div>
<h2 class="st-card-title">Marketing Consent</h2>
<p class="st-card-desc">Manage updates, offers, and promo communication.</p>
</div>
</div>
<div>
<div class="st-privacy-control">
<div>
<p class="st-sec-title">Email Marketing</p>
<p class="st-sec-sub">Receive emails about products and offers.</p>
</div>
<label class="st-switch">
<input type="checkbox" checked onchange="toggleSettingMessage(this,'Email marketing')">
<span class="st-slider">
</span>
</label>
</div>
<div class="st-privacy-control">
<div>
<p class="st-sec-title">SMS Marketing</p>
<p class="st-sec-sub">Receive marketing text messages.</p>
</div>
<label class="st-switch">
<input type="checkbox" onchange="toggleSettingMessage(this,'SMS marketing')">
<span class="st-slider">
</span>
</label>
</div>
</div>
</div>
<div class="st-privacy-panel-row">
<div class="st-comm-left">
<span class="st-orange-ico" style="background:#eef4ff;color:#2563eb">
<i class="fa-solid fa-cookie-bite">
</i>
</span>
<div>
<h2 class="st-card-title">Cookie Preferences</h2>
<p class="st-card-desc">Control cookies used to improve your experience.</p>
</div>
</div>
<div>
<div class="st-privacy-control">
<div>
<p class="st-sec-title">Essential Cookies</p>
<p class="st-sec-sub">Required for core site functionality.</p>
</div>
<span class="st-status-pill">Always Active</span>
</div>
<div class="st-privacy-control">
<div>
<p class="st-sec-title">Analytics Cookies</p>
<p class="st-sec-sub">Help us understand how the portal is used.</p>
</div>
<label class="st-switch">
<input type="checkbox" checked onchange="toggleSettingMessage(this,'Analytics cookies')">
<span class="st-slider">
</span>
</label>
</div>
</div>
</div>
</div>
</div>
<div class="st-card st-main-group">
<div class="st-body">
<div class="st-line-row">
<span class="st-orange-ico">
<i class="fa-solid fa-wand-magic-sparkles">
</i>
</span>
<div>
<p class="st-sec-title">Personalized Recommendations</p>
<p class="st-sec-sub">Allow personalized product and order suggestions.</p>
</div>
<label class="st-switch">
<input type="checkbox" checked onchange="toggleSettingMessage(this,'Personalized recommendations')">
<span class="st-slider">
</span>
</label>
</div>
<div class="st-section-line">
</div>
<div class="st-line-row">
<span class="st-orange-ico" style="background:#eef4ff;color:#2563eb">
<i class="fa-solid fa-download">
</i>
</span>
<div>
<p class="st-sec-title">Download My Data</p>
<p class="st-sec-sub">Download a copy of your personal data.</p>
</div>
<button class="st-outline-btn" type="button" onclick="requestDataExport()">Request Data Export</button>
</div>
<div class="st-line-row">
<span class="st-orange-ico" style="background:#f4efff;color:#7c3aed">
<i class="fa-regular fa-clock">
</i>
</span>
<div>
<p class="st-sec-title">Data Retention</p>
<p class="st-sec-sub">We retain your data only as long as necessary.</p>
</div>
<button class="st-outline-btn" type="button" onclick="showSettingsToast('Data retention policy opened.')">View Retention Policy</button>
</div>
<div class="st-section-line">
</div>
<h2 class="st-card-title">Account Verification</h2>
<p class="st-card-desc">Review your verification and privacy status.</p>
<div class="st-summary-strip" style="margin-top:10px">
<div class="st-summary-item">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-check">
</i>
</span>
<div>
<p class="st-sec-title">Email Verified</p>
<p class="st-sec-sub">{{ $settingsEmail ?: 'Not set' }}</p>
</div>
</div>
<div class="st-summary-item">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-phone">
</i>
</span>
<div>
<p class="st-sec-title">Phone Verified</p>
<p class="st-sec-sub">{{ $settingsPhone ?: 'Not set' }}</p>
</div>
</div>
<div class="st-summary-item">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-shield">
</i>
</span>
<div>
<p class="st-sec-title">Two-Factor Auth</p>
<p class="st-sec-sub">Enabled</p>
</div>
</div>
<div class="st-summary-item">
<span class="st-orange-ico" style="background:#eaf8ef;color:var(--st-green)">
<i class="fa-solid fa-user-shield">
</i>
</span>
<div>
<p class="st-sec-title">Privacy Level</p>
<p class="st-sec-sub">High</p>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="st-section-side">
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Consent Status</h2>
<p class="st-card-desc">Overview of your marketing consent.</p>
<div class="st-no-box-list" style="margin-top:8px">
<div class="st-right-metric">
<span>Email Marketing</span>
<span>Subscribed <i class="fa-solid fa-circle-check" style="color:var(--st-green)">
</i>
</span>
</div>
<div class="st-right-metric">
<span>SMS Marketing</span>
<span>Not Subscribed <i class="fa-regular fa-circle" style="color:#9ca3af">
</i>
</span>
</div>
<div class="st-right-metric">
<span>Push Notifications</span>
<span>Subscribed <i class="fa-solid fa-circle-check" style="color:var(--st-green)">
</i>
</span>
</div>
</div>
<button class="st-btn" style="width:100%;margin-top:10px" type="button" onclick="showSettingsToast('Consent preferences opened.')">Manage Consent</button>
</div>
</div>
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Data Protection</h2>
<p class="st-card-desc">Your data is secure with PrintifyCo.</p>
<div style="margin-top:8px">
<div class="st-check-line">
<i class="fa-regular fa-circle-check">
</i>Your data is encrypted in transit and at rest.</div>
<div class="st-check-line">
<i class="fa-regular fa-circle-check">
</i>We never sell your personal data.</div>
<div class="st-check-line">
<i class="fa-regular fa-circle-check">
</i>You can update or delete your data anytime.</div>
</div>
<button class="st-outline-btn" style="width:100%;margin-top:10px" type="button" onclick="showSettingsToast('Privacy policy opened.')">View Privacy Policy</button>
</div>
</div>
<div class="st-card st-plain-panel">
<div class="st-body">
<h2 class="st-card-title">Privacy Actions</h2>
<div class="st-action-list" style="margin-top:8px">
<button class="st-setting-action" type="button" onclick="showSettingsToast('Privacy preferences opened.')">
<span>Update Privacy Preferences</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Data permissions opened.')">
<span>Manage Data & Permissions</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="openDeactivatePanel()">
<span>Delete My Account</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
<button class="st-setting-action" type="button" onclick="showSettingsToast('Privacy team contact opened.')">
<span>Contact Privacy Team</span>
<i class="fa-solid fa-chevron-right">
</i>
</button>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- SETTINGS FOOTER / WRAPPER CLOSE -->
<p class="st-footer">Printify & Co. Client Portal v1.0</p>
</div>
</div>

<!-- PRIVACY / UTILITY MODAL HTML -->
<div id="settingsUtilityModal" class="st-modal">
<div class="st-modal-bg" data-modal-close>
</div>
<div class="st-modal-shell">
<div class="st-modal-card">
<div class="st-modal-head">
<div>
<h3 id="settingsUtilityTitle" class="st-modal-title">Settings</h3>
<p id="settingsUtilityDesc" class="st-modal-desc">Manage account settings.</p>
</div>
<button type="button" class="st-close" data-modal-close>×</button>
</div>
<div id="settingsUtilityBody" class="st-modal-body">
</div>
</div>
</div>
</div>
<div id="settingsToast" class="st-toast">Settings updated.</div>

{{-- PRIVACY CSS --}}
<style id="settings-privacy-css">
/* PRIVACY CSS: section-specific overrides/rules. */
#panel-preferences .st-section-main .st-plain-panel, #panel-privacy .st-section-main .st-plain-panel{border:0!important;background:transparent!important}
#panel-privacy .st-privacy-panel-row{padding:12px 0!important;grid-template-columns:210px minmax(0,1fr)!important}
#panel-privacy .st-privacy-panel-row:first-child{padding-top:0!important}
#panel-privacy .st-privacy-panel-row:last-child{padding-bottom:0!important}
#panel-privacy .st-privacy-panel-row{grid-template-columns:1fr!important}
/* Profile settings tab: same compact flow as My Profile */ #panel-profile .st-card-title, #panel-security .st-card-title, #panel-notifications .st-card-title, #panel-payments .st-card-title, #panel-addresses .st-card-title, #panel-preferences .st-card-title, #panel-privacy .st-card-title{ font-size:12.5px!important; letter-spacing:.025em!important; }
#panel-profile .st-card-desc, #panel-security .st-card-desc, #panel-notifications .st-card-desc, #panel-payments .st-card-desc, #panel-addresses .st-card-desc, #panel-preferences .st-card-desc, #panel-privacy .st-card-desc{ font-size:9.5px!important; line-height:1.35!important; }
#panel-profile .st-input, #panel-preferences .st-input, #panel-privacy select{ min-height:38px!important; font-size:10.5px!important; border-radius:10px!important; }
#panel-privacy .st-card-title{
#panel-privacy .st-card-desc{
#panel-privacy select{
</style>

{{-- PRIVACY JS --}}
<script id="settings-privacy-js">
/* PRIVACY JS: uses global functions from OVERVIEW JS: requestDataExport(), openDeactivatePanel(), and settingsUtilityModal handlers. */
</script>



</x-app-layout>