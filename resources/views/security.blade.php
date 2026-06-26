<x-app-layout>
@once
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700;800&display=swap">
@endonce

@php
    /*
        Security & Privacy is intentionally template-first.
        No hard-coded customer/device/email/location/IP records are stored here.
        When backend data is ready, pass these optional arrays from the controller:
        $securityOverview, $overviewAccessItems, $overviewLoginActivity, $overviewSessions,
        $accountVerification, $passwordStats, $recoveryMethods, $activeDevices,
        $loginActivities, $deviceSettings, $privacySummary, $privacyControls, $cookiePreferences.
    */

    $securityOverview = $securityOverview ?? [];
    $passwordStats = $passwordStats ?? [];
    $privacySummary = $privacySummary ?? [];

    $overviewAccessItems = collect($overviewAccessItems ?? [
        [
            'key' => 'password',
            'icon' => 'fa-solid fa-key',
            'tone' => 'danger',
            'title' => 'Password',
            'description' => 'Keep your password strong and unique to protect your account.',
            'meta_label' => 'Last changed',
            'meta_value' => data_get($passwordStats, 'last_changed', 'No password record yet'),
            'status' => data_get($passwordStats, 'status', 'Template only'),
            'action' => 'Change Password',
            'target' => 'password',
            'variant' => 'primary',
        ],
        [
            'key' => 'account_security',
            'icon' => 'fa-solid fa-lock',
            'tone' => 'danger',
            'title' => 'Account Security',
            'description' => 'Add an extra layer of security to your account.',
            'meta_label' => 'Status',
            'meta_value' => data_get($securityOverview, 'account_status', 'No security status yet'),
            'status' => data_get($securityOverview, 'security_badge', 'Template only'),
            'action' => 'Manage Security',
            'target' => null,
            'variant' => 'outline',
        ],
        [
            'key' => 'email_verification',
            'icon' => 'fa-regular fa-envelope',
            'tone' => 'dark',
            'title' => 'Email Verification',
            'description' => 'Your verified email will appear here after account verification is connected.',
            'meta_label' => 'Email address',
            'meta_value' => data_get($securityOverview, 'email', 'No email record yet'),
            'status' => data_get($securityOverview, 'email_status', 'No record yet'),
            'action' => 'Update Email',
            'target' => null,
            'variant' => 'outline',
        ],
    ]);

    $overviewLoginActivity = collect($overviewLoginActivity ?? []);
    $overviewSessions = collect($overviewSessions ?? []);
    $accountVerification = collect($accountVerification ?? []);
    $activeDevices = collect($activeDevices ?? []);
    $loginActivities = collect($loginActivities ?? []);
    $recoveryMethods = collect($recoveryMethods ?? []);

    $deviceSettings = collect($deviceSettings ?? [
        [
            'key' => 'session_timeout',
            'icon' => 'fa-regular fa-clock',
            'title' => 'Session timeout',
            'description' => 'Automatically sign out inactive sessions.',
            'type' => 'select',
            'value' => 'Not set',
        ],
        [
            'key' => 'new_device_alerts',
            'icon' => 'fa-regular fa-bell',
            'title' => 'New device alerts',
            'description' => 'Email me when a new device signs in.',
            'type' => 'switch',
            'enabled' => false,
        ],
        [
            'key' => 'remember_active_devices',
            'icon' => 'fa-solid fa-shield-halved',
            'title' => 'Remember active devices',
            'description' => 'Keep known devices easier to review.',
            'type' => 'switch',
            'enabled' => false,
        ],
    ]);

    $privacyControls = collect($privacyControls ?? [
        [
            'key' => 'profile_visibility',
            'icon' => 'fa-regular fa-user',
            'title' => 'Profile Visibility',
            'description' => 'Allow others to see your profile information.',
            'enabled' => false,
        ],
        [
            'key' => 'order_visibility',
            'icon' => 'fa-solid fa-bag-shopping',
            'title' => 'Order Visibility',
            'description' => 'Allow others to view your orders and purchase history.',
            'enabled' => false,
        ],
        [
            'key' => 'personalized_recommendations',
            'icon' => 'fa-solid fa-wand-magic-sparkles',
            'title' => 'Personalized Recommendations',
            'description' => 'Show product recommendations based on your activity.',
            'enabled' => false,
        ],
        [
            'key' => 'marketing_communications',
            'icon' => 'fa-regular fa-envelope',
            'title' => 'Marketing Communications',
            'description' => 'Receive promotional emails and updates from PrintifyCo.',
            'enabled' => false,
        ],
    ]);

    $cookiePreferences = collect($cookiePreferences ?? [
        [
            'key' => 'essential_cookies',
            'icon' => 'fa-solid fa-cookie',
            'title' => 'Essential Cookies',
            'description' => 'Necessary for the website to function properly.',
            'status' => 'Always Active',
            'status_tone' => 'plain',
        ],
        [
            'key' => 'analytics_cookies',
            'icon' => 'fa-solid fa-chart-simple',
            'title' => 'Analytics Cookies',
            'description' => 'Help us understand how you use our website.',
            'status' => 'Not set',
            'status_tone' => 'gray',
        ],
        [
            'key' => 'marketing_cookies',
            'icon' => 'fa-solid fa-bullhorn',
            'title' => 'Marketing Cookies',
            'description' => 'Used to deliver personalized ads and content.',
            'status' => 'Not set',
            'status_tone' => 'gray',
        ],
    ]);

    $securityScore = data_get($securityOverview, 'score');
    $securityScoreWidth = is_numeric($securityScore) ? min(100, max(0, (int) $securityScore)) : 0;

    $passwordScore = data_get($passwordStats, 'score');
    $passwordScoreWidth = is_numeric($passwordScore) ? min(100, max(0, (int) $passwordScore)) : 0;

    $privacyScore = data_get($privacySummary, 'score');
    $privacyScoreWidth = is_numeric($privacyScore) ? min(100, max(0, (int) $privacyScore)) : 0;
@endphp

<style>
:root{
    --sp-orange:#ff7a00;
    --sp-orange-soft:#fff3e6;
    --sp-green:#16a34a;
    --sp-green-soft:#eaf8ef;
    --sp-red:#ef4444;
    --sp-red-soft:#fff1f1;
    --sp-blue:#2563eb;
    --sp-blue-soft:#eef4ff;
    --sp-ink:#111827;
    --sp-muted:#6b7280;
    --sp-line:#d8dee8;
    --sp-line-soft:#e5e7eb;
    --sp-bg:#ffffff;
    --sp-radius:12px;
}
.security-page{
    min-height:calc(100vh - 70px);
    padding:0 0 44px;
    background:#fff;
    color:var(--sp-ink);
    font-family:'Inter',system-ui,sans-serif;
}
.security-wrap{
    width:100%;
    max-width:1490px;
    margin:0 auto;
}
.security-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:18px;
    margin:0 0 14px;
}
.security-title-box{
    display:flex;
    align-items:flex-start;
    gap:10px;
}
.security-title-box:before{
    content:'\f3ed';
    font-family:'Font Awesome 6 Free';
    font-weight:900;
    width:34px;
    height:34px;
    margin-top:4px;
    display:grid;
    place-items:center;
    color:var(--sp-orange);
    font-size:28px;
    line-height:1;
    flex:0 0 auto;
}
.security-title{
    margin:0;
    font-family:'Playfair Display',Georgia,serif;
    font-size:40px;
    line-height:1.1;
    font-weight:700;
    color:#111827;
}
.security-subtitle{
    margin:4px 0 0;
    font-size:12px;
    line-height:1.45;
    color:#111827;
}
.security-date{
    height:42px;
    min-width:178px;
    padding:0 15px;
    border:1px solid #111827;
    border-radius:8px;
    background:#fff;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    font-size:12px;
    font-weight:700;
    line-height:1;
    white-space:nowrap;
}
.security-date i,
.security-date [data-lucide]{
    width:16px;
    height:16px;
    color:#111827;
}
.security-tabs{
    display:flex;
    align-items:flex-end;
    gap:30px;
    width:100%;
    margin:0 0 22px;
    padding:0;
    border:0;
    background:transparent;
    overflow-x:auto;
    scrollbar-width:none;
}
.security-tabs::-webkit-scrollbar{display:none;}
.security-tab{
    position:relative;
    height:34px;
    padding:0;
    border:0;
    border-radius:0;
    background:transparent;
    color:#111827;
    font-family:'Poppins',system-ui,sans-serif;
    font-size:11px;
    font-weight:600;
    cursor:pointer;
    white-space:nowrap;
    transition:.16s ease;
}
.security-tab:hover,
.security-tab.active{color:var(--sp-orange);}
.security-tab.active:after{
    content:'';
    position:absolute;
    left:0;
    right:0;
    bottom:-1px;
    height:3px;
    border-radius:999px;
    background:var(--sp-orange);
}
.sp-panel{display:none;animation:spFade .18s ease;}
.sp-panel.active{display:block;}
@keyframes spFade{from{opacity:.45;transform:translateY(5px)}to{opacity:1;transform:translateY(0)}}
.sp-card{
    background:#fff;
    border:1px solid var(--sp-line);
    border-radius:10px;
    box-shadow:none;
    overflow:hidden;
}
.sp-card-pad{padding:20px 24px;}
.sp-card-title{
    margin:0;
    font-family:'Poppins',system-ui,sans-serif;
    font-size:16px;
    font-weight:700;
    line-height:1.25;
    color:#111827;
}
.sp-card-title.sm{font-size:15px;}
.sp-card-desc,
.sp-muted{
    margin:5px 0 0;
    color:#111827;
    font-size:11.5px;
    line-height:1.45;
}
.sp-section-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:16px;
}
.sp-title-left,
.sp-row-left{
    display:flex;
    align-items:flex-start;
    gap:12px;
    min-width:0;
}
.sp-icon{
    width:28px;
    height:28px;
    display:grid;
    place-items:center;
    flex:0 0 auto;
    color:var(--sp-orange);
    font-size:18px;
}
.sp-icon.green{color:var(--sp-green);}
.sp-icon.red{color:var(--sp-red);}
.sp-icon.blue{color:var(--sp-blue);}
.sp-btn,
.sp-action,
.sp-link-button{
    height:35px;
    min-width:128px;
    border-radius:10px;
    border:1px solid #111827;
    background:#fff;
    color:#111827;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:0 16px;
    font-family:'Poppins',system-ui,sans-serif;
    font-size:11px;
    font-weight:600;
    text-decoration:none;
    cursor:pointer;
    white-space:nowrap;
    transition:.16s ease;
}
.sp-btn.primary,
.sp-action.primary{
    border-color:var(--sp-orange);
    background:var(--sp-orange);
    color:#111827;
}
.sp-btn.pill{border-radius:999px;}
.sp-btn:hover,
.sp-action:hover,
.sp-link-button:hover{
    background:#111827;
    border-color:#111827;
    color:#fff;
}
.sp-btn.block{width:100%;min-width:0;}
.sp-status{
    min-height:22px;
    width:max-content;
    border-radius:999px;
    padding:4px 10px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    background:#f3f4f6;
    color:#64748b;
    font-size:10.5px;
    font-weight:700;
    white-space:nowrap;
}
.sp-status.green{background:var(--sp-green-soft);color:var(--sp-green);}
.sp-status.orange{background:var(--sp-orange-soft);color:var(--sp-orange);}
.sp-status.gray{background:#f3f4f6;color:#64748b;}
.sp-status.plain{background:transparent;color:#64748b;padding-left:0;padding-right:0;}
.sp-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
    padding:12px 0;
    border-bottom:1px solid #eef1f5;
}
.sp-row:last-child{border-bottom:0;}
.sp-mini-title,
.sp-row strong{
    display:block;
    font-family:'Poppins',system-ui,sans-serif;
    font-size:13px;
    font-weight:700;
    line-height:1.25;
    color:#111827;
}
.sp-row small,
.sp-mini-desc{
    display:block;
    margin-top:4px;
    color:#111827;
    font-size:11px;
    line-height:1.4;
}
.sp-empty{
    min-height:58px;
    display:grid;
    place-items:center;
    text-align:center;
    color:#6b7280;
    font-size:11.5px;
    line-height:1.45;
}
.sp-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    margin-top:18px;
}
.sp-table th,
.sp-table td{
    padding:12px 14px;
    text-align:left;
    border-bottom:1px solid #dfe3ea;
    font-size:12px;
    vertical-align:middle;
    color:#111827;
}
.sp-table th{
    font-size:10px;
    text-transform:uppercase;
    letter-spacing:.03em;
    color:#4b5563;
    font-weight:700;
}
.sp-table tr:last-child td{border-bottom:0;}
.sp-table small{display:block;margin-top:3px;font-size:10.5px;color:#6b7280;}
.sp-device{display:flex;align-items:center;gap:10px;min-width:0;}
.sp-list{display:grid;gap:0;margin-top:14px;}
.sp-switch{position:relative;display:inline-block;width:42px;height:24px;flex:0 0 auto;}
.sp-switch input{opacity:0;width:0;height:0;}
.sp-slider{position:absolute;inset:0;background:#cbd5e1;border-radius:999px;transition:.18s;cursor:pointer;}
.sp-slider:before{content:'';position:absolute;width:18px;height:18px;left:3px;top:3px;border-radius:50%;background:#fff;box-shadow:0 2px 4px rgba(0,0,0,.18);transition:.18s;}
.sp-switch input:checked+.sp-slider{background:var(--sp-green);}
.sp-switch input:checked+.sp-slider:before{transform:translateX(18px);}
.sp-template-badge{
    height:25px;
    display:inline-flex;
    align-items:center;
    gap:7px;
    padding:0 10px;
    border-radius:999px;
    background:#fff8f1;
    color:#ff7a00;
    font-size:10.5px;
    font-weight:700;
}
.sp-toast{
    position:fixed;
    left:50%;
    top:92px;
    z-index:9999;
    transform:translate(-50%,-12px);
    opacity:0;
    pointer-events:none;
    background:#111827;
    color:#fff;
    padding:13px 16px;
    border-radius:12px;
    font-weight:800;
    font-size:12px;
    box-shadow:0 18px 50px rgba(17,24,39,.25);
    transition:.2s;
}
.sp-toast.show{opacity:1;transform:translate(-50%,0);}

/* OVERVIEW */
.overview-reference-layout{
    display:grid;
    grid-template-columns:minmax(0,1fr) 430px;
    gap:18px;
    align-items:start;
}
.overview-left,
.overview-right{display:grid;gap:18px;min-width:0;}
.overview-main-header{
    display:flex;
    align-items:center;
    gap:12px;
    padding:20px 24px 10px;
}
.overview-access-list{padding:0 24px;}
.overview-access-row{
    display:grid;
    grid-template-columns:34px minmax(0,1fr) auto;
    gap:16px;
    align-items:center;
    padding:21px 0;
    border-bottom:1px solid var(--sp-line-soft);
}
.overview-access-row:last-child{border-bottom:0;}
.overview-row-icon{
    width:28px;
    height:28px;
    display:grid;
    place-items:center;
    color:var(--sp-red);
    font-size:18px;
}
.overview-row-icon.dark{color:#111827;}
.overview-bottom-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    border-top:1px solid var(--sp-line);
}
.overview-mini-panel{min-width:0;padding:18px 22px;}
.overview-mini-panel:first-child{border-right:1px solid var(--sp-line);}
.overview-mini-head{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:12px;
    margin-bottom:12px;
}
.overview-side-card{padding:24px 22px;}
.overview-secure-head{display:flex;align-items:center;gap:14px;margin-bottom:14px;}
.overview-secure-badge{
    width:54px;
    height:54px;
    border-radius:50%;
    display:grid;
    place-items:center;
    border:1px solid #ffd8b0;
    background:#fff8f1;
    color:var(--sp-red);
    font-size:24px;
    flex:0 0 auto;
}
.overview-chips{display:flex;flex-wrap:wrap;gap:8px;padding-bottom:20px;border-bottom:1px solid var(--sp-line-soft);}
.overview-chip{height:24px;border-radius:999px;display:inline-flex;align-items:center;gap:6px;padding:0 9px;background:var(--sp-green-soft);color:var(--sp-green);font-size:10px;font-weight:700;}
.overview-score-box{padding-top:18px;}
.overview-score-number strong{color:var(--sp-green);font-size:38px;line-height:1;font-family:'Poppins',system-ui,sans-serif;}
.overview-score-number span{color:#111827;font-size:20px;font-weight:700;}
.overview-score-meter{width:100%;height:8px;border-radius:999px;background:#e5eaf0;overflow:hidden;margin:12px 0 13px;}
.overview-score-meter i{display:block;height:100%;border-radius:inherit;background:var(--sp-green);}
.overview-danger{background:transparent;border:0;border-radius:0;overflow:visible;}
.overview-danger-inner{padding:0 2px;}
.overview-danger h3{margin:0;color:var(--sp-red);display:flex;align-items:center;gap:9px;font-family:'Poppins',system-ui,sans-serif;font-size:16px;}
.overview-danger-line{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:16px 0 0;}
.overview-danger-action{border:0;background:transparent;color:var(--sp-red);min-width:0;padding:0;}

/* PASSWORD */
.password-reference-layout{display:block;width:100%;}
.password-full{display:grid;gap:18px;width:100%;}
.password-management{padding:22px 24px 16px;}
.password-head-row{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:18px;}
.password-change{border-top:1px solid var(--sp-line);padding:22px 24px 18px;}
.password-strength-panel{
    min-height:88px;
    border:1px solid var(--sp-line);
    border-radius:10px;
    padding:14px 20px;
    display:grid;
    grid-template-columns:auto minmax(0,1fr) minmax(210px,280px);
    gap:28px;
    align-items:center;
}
.password-score-left{display:flex;align-items:center;gap:18px;}
.password-score-circle{
    width:70px;
    height:70px;
    border-radius:50%;
    border:8px solid var(--sp-green);
    display:grid;
    place-items:center;
    color:var(--sp-green);
    font-family:'Poppins',system-ui,sans-serif;
    font-size:24px;
    font-weight:800;
    line-height:1;
    text-align:center;
}
.password-score-circle small{display:block;margin:2px 0 0;color:#111827;font-size:11px;font-weight:700;}
.password-strength-name b{display:block;margin-top:2px;color:var(--sp-green);font-family:'Poppins',system-ui,sans-serif;font-size:20px;line-height:1;}
.password-bars{display:flex;align-items:center;gap:12px;width:100%;}
.password-bars i{height:5px;flex:1;min-width:38px;border-radius:999px;background:var(--sp-green);}
.password-bars i.off{background:var(--sp-line);}
.password-last-changed{justify-self:end;text-align:left;}
.password-last-changed small{display:block;font-size:11px;color:#111827;}
.password-last-changed b{display:block;margin-top:6px;font-family:'Poppins',system-ui,sans-serif;font-size:12px;color:#111827;}
.password-form{margin-top:14px;}
.password-field{display:grid;gap:7px;margin-top:12px;}
.password-field label{color:#111827;font-size:12px;font-weight:600;}
.password-input-wrap{position:relative;}
.password-input{width:100%;height:40px;border:1px solid var(--sp-line);border-radius:8px;background:#fff;color:#111827;outline:none;padding:0 42px 0 12px;font-size:13px;}
.password-input:focus{border-color:#111827;box-shadow:0 0 0 3px rgba(17,24,39,.08);}
.password-eye{width:34px;height:34px;border:0;background:transparent;position:absolute;top:50%;right:5px;transform:translateY(-50%);display:grid;place-items:center;color:#64748b;cursor:pointer;}
.password-inline-strength{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:10px;align-items:center;margin-top:7px;}
.password-inline-strength .password-bars{gap:8px;}
.password-inline-strength .password-bars i{height:4px;min-width:0;background:var(--sp-line);}
.password-inline-strength span{font-size:11px;font-weight:700;color:#6b7280;}
.password-submit-row{display:flex;justify-content:flex-end;margin-top:18px;}
.password-bottom-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:18px;}
.password-bottom-card{padding:18px 20px;}
.password-check-list{display:grid;gap:10px;margin-top:14px;}
.password-check{display:flex;align-items:center;gap:10px;font-size:12px;line-height:1.35;color:#111827;}
.password-check i{color:var(--sp-green);flex:0 0 auto;}
.password-recovery-row{display:grid;grid-template-columns:minmax(0,1fr) auto auto;align-items:center;gap:12px;padding:11px 0;border-bottom:1px solid #eef1f5;}
.password-recovery-row:last-child{border-bottom:0;}
.password-edit-button{height:30px;min-width:72px;border:1px solid var(--sp-line);background:#fff;border-radius:8px;padding:0 12px;color:#111827;font-family:'Poppins',system-ui,sans-serif;font-size:11px;font-weight:600;cursor:pointer;}
.password-edit-button:hover{background:#111827;color:#fff;border-color:#111827;}

/* DEVICES - reference screenshot flow */
.devices-reference-layout{display:grid;gap:24px;width:100%;}
.devices-card .sp-card-pad{padding:24px 28px;}
.devices-summary{
    display:grid;
    grid-template-columns:180px repeat(3,minmax(0,1fr));
    align-items:center;
    gap:24px;
    margin-top:28px;
    padding-bottom:24px;
    border-bottom:1px solid var(--sp-line);
}
.devices-count-box{display:flex;align-items:center;gap:16px;border-right:1px solid var(--sp-line);padding-right:22px;}
.devices-count-circle{
    width:74px;
    height:74px;
    border-radius:50%;
    border:8px solid var(--sp-green);
    display:grid;
    place-items:center;
    color:#111827;
    font-family:'Poppins',system-ui,sans-serif;
    font-size:25px;
    font-weight:800;
}
.devices-feature{display:flex;align-items:center;justify-content:space-between;gap:12px;color:#111827;font-size:12px;font-weight:600;}
.devices-feature i:first-child{color:var(--sp-green);font-size:18px;}
.devices-warning-row{display:flex;align-items:center;justify-content:space-between;gap:18px;margin-top:18px;}
.devices-warning-row p{display:flex;align-items:center;gap:9px;margin:0;color:#111827;font-size:11.5px;line-height:1.45;}
.devices-warning-row p i{color:var(--sp-red);}
.devices-activity-settings{
    display:grid;
    grid-template-columns:minmax(0,1fr) 310px;
    gap:28px;
}
.devices-settings-side{border-left:1px solid var(--sp-line);padding-left:26px;display:grid;gap:18px;align-content:start;}
.device-setting-row{display:flex;align-items:center;justify-content:space-between;gap:18px;}
.device-setting-row + .device-setting-row{padding-top:8px;}
.safety-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:28px;margin-top:22px;}
.safety-item{display:flex;align-items:center;gap:16px;}
.safety-icon{width:36px;height:36px;display:grid;place-items:center;font-size:28px;color:var(--sp-orange);}
.safety-icon.red{color:var(--sp-red);}
.safety-icon.dark{color:#111827;}

/* PRIVACY - reference screenshot flow */
.privacy-reference-layout{display:grid;gap:24px;width:100%;max-width:1120px;}
.privacy-card .sp-card-pad{padding:24px 28px;}
.privacy-main-summary{
    display:grid;
    grid-template-columns:96px minmax(0,1fr) auto;
    align-items:center;
    gap:20px;
    margin-top:22px;
    padding-bottom:22px;
    border-bottom:1px solid var(--sp-line);
}
.privacy-score-circle{
    width:84px;
    height:84px;
    border-radius:50%;
    border:8px solid var(--sp-green);
    display:grid;
    place-items:center;
    color:#111827;
    font-family:'Poppins',system-ui,sans-serif;
    font-size:24px;
    font-weight:800;
    line-height:1;
    text-align:center;
}
.privacy-score-circle small{display:block;margin-top:2px;font-size:11px;font-weight:700;color:#111827;}
.privacy-score-meter{width:100%;max-width:220px;height:7px;border-radius:999px;background:#e5eaf0;overflow:hidden;margin-top:10px;}
.privacy-score-meter i{display:block;height:100%;border-radius:inherit;background:var(--sp-green);}
.privacy-controls-list{display:grid;gap:0;margin-top:12px;}
.privacy-control-row{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:17px 0;border-bottom:1px solid var(--sp-line-soft);}
.privacy-control-row:last-child{border-bottom:0;}
.privacy-control-left{display:flex;align-items:center;gap:18px;min-width:0;}
.privacy-control-icon{width:28px;height:28px;display:grid;place-items:center;color:#111827;font-size:20px;flex:0 0 auto;}
.cookie-download-head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;}
.cookie-list{display:grid;gap:0;margin-top:22px;}
.cookie-row{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:16px 0;border-bottom:1px solid var(--sp-line-soft);}
.cookie-row:last-child{border-bottom:0;}
.cookie-left{display:flex;align-items:center;gap:18px;min-width:0;}
.cookie-left i{width:28px;text-align:center;font-size:20px;color:#111827;}
.download-row{display:flex;align-items:center;justify-content:space-between;gap:18px;padding-top:18px;margin-top:4px;border-top:1px solid var(--sp-line);}
.data-note-card .sp-card-pad{padding:22px 28px;}
.data-note-card .sp-title-left{align-items:flex-start;}

@media(max-width:1180px){
    .overview-reference-layout{grid-template-columns:1fr;}
    .overview-right{grid-template-columns:1fr 1fr;}
    .password-strength-panel{grid-template-columns:1fr;gap:16px;}
    .password-last-changed{justify-self:start;}
    .password-bottom-grid{grid-template-columns:1fr;}
    .devices-summary{grid-template-columns:1fr 1fr;}
    .devices-count-box{border-right:0;border-bottom:1px solid var(--sp-line);padding:0 0 18px;}
    .devices-activity-settings{grid-template-columns:1fr;}
    .devices-settings-side{border-left:0;border-top:1px solid var(--sp-line);padding:20px 0 0;}
    .privacy-reference-layout{max-width:none;}
}
@media(max-width:760px){
    .security-page{padding:0 18px 44px;}
    .security-top{display:grid;}
    .security-title{font-size:32px;}
    .security-date{width:100%;}
    .overview-bottom-grid,
    .overview-right,
    .devices-summary,
    .safety-grid,
    .privacy-main-summary{grid-template-columns:1fr;}
    .overview-mini-panel:first-child{border-right:0;border-bottom:1px solid var(--sp-line);}
    .overview-access-row{grid-template-columns:30px minmax(0,1fr);}
    .overview-access-row .sp-action{grid-column:1 / -1;width:100%;}
    .overview-danger-line,
    .password-head-row,
    .password-submit-row,
    .cookie-download-head,
    .download-row,
    .devices-warning-row{display:grid;}
    .sp-action,.sp-btn,.sp-link-button{width:100%;}
    .password-recovery-row{grid-template-columns:1fr;}
    .sp-table{display:block;overflow-x:auto;}
    .privacy-main-summary{gap:12px;}
}
</style>

<div class="security-page">
    <div class="security-wrap">
        <div class="security-top">
            <div class="security-title-box">
                <div>
                    <h1 class="security-title">Security &amp; Privacy</h1>
                    <p class="security-subtitle">Manage your account security, privacy settings, and data protection.</p>
                </div>
            </div>
            <div class="security-date">
                <i data-lucide="calendar-days"></i>
                <span>Today is {{ now()->format('M d, Y') }}</span>
            </div>
        </div>

        <div class="security-tabs" role="tablist" aria-label="Security and Privacy tabs">
            <button type="button" class="security-tab active" data-tab="overview">OVERVIEW</button>
            <button type="button" class="security-tab" data-tab="password">PASSWORD</button>
            <button type="button" class="security-tab" data-tab="devices">DEVICES</button>
            <button type="button" class="security-tab" data-tab="privacy">PRIVACY</button>
        </div>

        <!-- OVERVIEW TAB -->
        <section class="sp-panel active" id="overview-panel">
            <div class="overview-reference-layout">
                <main class="overview-left">
                    <section class="sp-card">
                        <div class="overview-main-header">
                            <span class="sp-icon green"><i class="fa-solid fa-desktop"></i></span>
                            <h2 class="sp-card-title">Device Access &amp; Sign-in Settings</h2>
                        </div>

                        <div class="overview-access-list">
                            @foreach($overviewAccessItems as $item)
                                <div class="overview-access-row">
                                    <span class="overview-row-icon {{ data_get($item, 'tone') === 'dark' ? 'dark' : '' }}"><i class="{{ data_get($item, 'icon') }}"></i></span>
                                    <div>
                                        <h4 class="sp-mini-title">{{ data_get($item, 'title') }}</h4>
                                        <p class="sp-mini-desc">{{ data_get($item, 'description') }}</p>
                                        <div style="margin-top:8px">
                                            <span class="sp-status {{ data_get($item, 'status_tone', 'gray') }}">{{ data_get($item, 'status', 'Template only') }}</span>
                                        </div>
                                        <small class="sp-mini-desc"><b>{{ data_get($item, 'meta_label') }}:</b> {{ data_get($item, 'meta_value', 'No record yet') }}</small>
                                    </div>
                                    <button type="button" class="sp-action {{ data_get($item, 'variant') === 'primary' ? 'primary' : '' }}" @if(data_get($item, 'target')) data-tab-jump="{{ data_get($item, 'target') }}" @endif>
                                        {{ data_get($item, 'action', 'Manage') }}
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <div class="overview-bottom-grid">
                            <section class="overview-mini-panel">
                                <div class="overview-mini-head">
                                    <div class="sp-title-left">
                                        <span class="sp-icon"><i class="fa-regular fa-clock"></i></span>
                                        <div>
                                            <h3 class="sp-card-title sm">Login Activity</h3>
                                            <p class="sp-card-desc">Recent login records will appear here once backend tracking is connected.</p>
                                        </div>
                                    </div>
                                    <button type="button" class="sp-link-button" data-tab-jump="devices">View All <i class="fa-solid fa-chevron-right"></i></button>
                                </div>

                                <div class="sp-list">
                                    @forelse($overviewLoginActivity as $activity)
                                        <div class="sp-row">
                                            <div>
                                                <strong>{{ data_get($activity, 'location', 'Unknown location') }}</strong>
                                                <small>{{ data_get($activity, 'browser', 'Unknown browser') }}</small>
                                            </div>
                                            <span class="sp-status {{ data_get($activity, 'status_tone', 'green') }}">{{ data_get($activity, 'status', 'Recorded') }}</span>
                                        </div>
                                    @empty
                                        <div class="sp-empty">No login activity recorded yet. This section is ready for backend data.</div>
                                    @endforelse
                                </div>
                            </section>

                            <section class="overview-mini-panel">
                                <div class="overview-mini-head">
                                    <div class="sp-title-left">
                                        <span class="sp-icon blue"><i class="fa-regular fa-id-badge"></i></span>
                                        <div>
                                            <h3 class="sp-card-title sm">Active Sessions</h3>
                                            <p class="sp-card-desc">Signed-in sessions will be listed here after authentication tracking is added.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="sp-list">
                                    @forelse($overviewSessions as $session)
                                        <div class="sp-row">
                                            <div class="sp-row-left">
                                                <span class="sp-icon blue"><i class="{{ data_get($session, 'icon', 'fa-solid fa-display') }}"></i></span>
                                                <div>
                                                    <strong>{{ data_get($session, 'device', 'Device') }}</strong>
                                                    <small>{{ data_get($session, 'meta', 'Session details') }}</small>
                                                </div>
                                            </div>
                                            @if(data_get($session, 'can_sign_out', false))
                                                <button type="button" class="sp-action">Sign Out</button>
                                            @else
                                                <span class="sp-status green">{{ data_get($session, 'status', 'Active') }}</span>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="sp-empty">No active session record yet. Device sessions will appear here after backend connection.</div>
                                    @endforelse
                                </div>
                            </section>
                        </div>
                    </section>

                    <section class="overview-danger">
                        <div class="overview-danger-inner">
                            <h3><i class="fa-solid fa-triangle-exclamation"></i> Danger Zone</h3>
                            <p class="sp-card-desc">These account actions are placeholders until backend account controls are connected.</p>
                            <div class="overview-danger-line">
                                <div class="sp-row-left">
                                    <span class="sp-icon red"><i class="fa-solid fa-user-xmark"></i></span>
                                    <div>
                                        <strong class="sp-mini-title">Deactivate Account</strong>
                                        <small class="sp-mini-desc">Temporarily deactivate your account after backend confirmation is available.</small>
                                    </div>
                                </div>
                                <button type="button" class="sp-action overview-danger-action">Deactivate Account <i class="fa-solid fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </section>
                </main>

                <aside class="overview-right">
                    <section class="sp-card overview-side-card">
                        <div class="overview-secure-head">
                            <span class="overview-secure-badge"><i class="fa-solid fa-shield-halved"></i></span>
                            <div>
                                <h3 class="sp-card-title">Account Security Template</h3>
                                <p class="sp-card-desc">Security score and recommendations will update once real account checks are connected.</p>
                            </div>
                        </div>
                        <div class="overview-chips">
                            <span class="overview-chip"><i class="fa-solid fa-check"></i> Password check ready</span>
                            <span class="overview-chip"><i class="fa-solid fa-check"></i> Verification check ready</span>
                            <span class="overview-chip"><i class="fa-solid fa-check"></i> Email check ready</span>
                        </div>
                        <div class="overview-score-box">
                            <p class="sp-card-desc">Security Score</p>
                            <div class="overview-score-number"><strong>{{ $securityScore ?? '—' }}</strong><span>/100</span></div>
                            <div class="overview-score-meter"><i style="width:{{ $securityScoreWidth }}%"></i></div>
                            <button type="button" class="sp-link-button">View Security Recommendations <i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </section>

                    <section class="sp-card overview-side-card">
                        <h3 class="sp-card-title">Account Verification</h3>
                        <p class="sp-card-desc">Verified contact and identity records will appear here once backend verification is connected.</p>
                        <div class="sp-list">
                            @forelse($accountVerification as $verification)
                                <div class="sp-row">
                                    <div class="sp-row-left">
                                        <span class="sp-icon {{ data_get($verification, 'tone', '') }}"><i class="{{ data_get($verification, 'icon', 'fa-regular fa-id-card') }}"></i></span>
                                        <div>
                                            <strong>{{ data_get($verification, 'title', 'Verification') }}</strong>
                                            <small>{{ data_get($verification, 'value', 'No value') }}</small>
                                        </div>
                                    </div>
                                    <span class="sp-status {{ data_get($verification, 'status_tone', 'green') }}">{{ data_get($verification, 'status', 'Verified') }}</span>
                                </div>
                            @empty
                                <div class="sp-empty">No verification records yet. This is only a visual template.</div>
                            @endforelse
                        </div>
                    </section>
                </aside>
            </div>
        </section>

        <!-- PASSWORD TAB -->
        <section class="sp-panel" id="password-panel">
            <div class="password-reference-layout">
                <main class="password-full">
                    <section class="sp-card">
                        <div class="password-management">
                            <div class="password-head-row">
                                <div class="sp-title-left">
                                    <span class="sp-icon red"><i class="fa-solid fa-lock"></i></span>
                                    <div>
                                        <h2 class="sp-card-title">Password Management</h2>
                                        <p class="sp-card-desc">A strong password helps keep your account safe and secure.</p>
                                    </div>
                                </div>
                                <button type="button" class="sp-btn pill">Password Tips</button>
                            </div>

                            <div class="password-strength-panel">
                                <div class="password-score-left">
                                    <div class="password-score-circle">{{ $passwordScore ?? '—' }}<small>/100</small></div>
                                    <div class="password-strength-name">
                                        <span class="sp-card-desc">Password strength</span>
                                        <b>{{ data_get($passwordStats, 'label', 'No record yet') }}</b>
                                    </div>
                                </div>
                                <div class="password-bars" aria-label="Password strength meter">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $passwordScoreWidth >= ($i * 20) ? '' : 'off' }}"></i>
                                    @endfor
                                </div>
                                <div class="password-last-changed">
                                    <small>Last changed</small>
                                    <b>{{ data_get($passwordStats, 'last_changed', 'No password record yet') }}</b>
                                </div>
                            </div>
                        </div>

                        <div class="password-change">
                            <div class="sp-title-left">
                                <span class="sp-icon red"><i class="fa-solid fa-key"></i></span>
                                <div>
                                    <h2 class="sp-card-title">Change Password</h2>
                                    <p class="sp-card-desc">Use a strong password that you don't use on other websites.</p>
                                </div>
                            </div>

                            <form class="password-form" method="POST" action="{{ Route::has('password.change') ? route('password.change') : '#' }}">
                                @csrf
                                @if(Route::has('password.change'))
                                    @method('put')
                                @endif

                                <div class="password-field">
                                    <label for="current_password">Current Password</label>
                                    <div class="password-input-wrap">
                                        <input id="current_password" class="password-input" type="password" name="current_password" placeholder="••••••••••••" autocomplete="current-password">
                                        <button class="password-eye" type="button" data-toggle-pass><i class="fa-regular fa-eye"></i></button>
                                    </div>
                                </div>

                                <div class="password-field">
                                    <label for="password">New Password</label>
                                    <div class="password-input-wrap">
                                        <input id="password" class="password-input" type="password" name="password" placeholder="••••••••••" autocomplete="new-password">
                                        <button class="password-eye" type="button" data-toggle-pass><i class="fa-regular fa-eye"></i></button>
                                    </div>
                                    <div class="password-inline-strength">
                                        <div class="password-bars" aria-label="New password strength meter"><i></i><i></i><i></i><i></i><i></i></div>
                                        <span>Template only</span>
                                    </div>
                                    <p class="sp-card-desc">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</p>
                                </div>

                                <div class="password-field">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <div class="password-input-wrap">
                                        <input id="password_confirmation" class="password-input" type="password" name="password_confirmation" placeholder="••••••••••" autocomplete="new-password">
                                        <button class="password-eye" type="button" data-toggle-pass><i class="fa-regular fa-eye"></i></button>
                                    </div>
                                </div>

                                <div class="password-submit-row">
                                    <button type="submit" class="sp-btn primary pill">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </section>

                    <div class="password-bottom-grid">
                        <section class="sp-card password-bottom-card">
                            <div class="sp-title-left">
                                <span class="sp-icon red"><i class="fa-solid fa-shield-halved"></i></span>
                                <div>
                                    <h3 class="sp-card-title sm">Password Requirements</h3>
                                    <p class="sp-card-desc">Your password must include:</p>
                                </div>
                            </div>
                            <div class="password-check-list">
                                <span class="password-check"><i class="fa-solid fa-circle-check"></i> At least 8 characters long</span>
                                <span class="password-check"><i class="fa-solid fa-circle-check"></i> At least one number (0–9)</span>
                                <span class="password-check"><i class="fa-solid fa-circle-check"></i> At least one special character (!@#$%^&amp;*)</span>
                            </div>
                        </section>

                        <section class="sp-card password-bottom-card">
                            <div class="sp-title-left">
                                <span class="sp-icon"><i class="fa-solid fa-arrows-rotate"></i></span>
                                <div>
                                    <h3 class="sp-card-title sm">Recovery Options</h3>
                                    <p class="sp-card-desc">Recovery records will appear here after backend verification is connected.</p>
                                </div>
                            </div>
                            <div class="password-check-list">
                                @forelse($recoveryMethods as $method)
                                    <div class="password-recovery-row">
                                        <div class="sp-row-left">
                                            <span class="sp-icon blue"><i class="{{ data_get($method, 'icon', 'fa-regular fa-envelope') }}"></i></span>
                                            <div>
                                                <strong class="sp-mini-title">{{ data_get($method, 'title', 'Recovery Method') }}</strong>
                                                <small class="sp-mini-desc">{{ data_get($method, 'value', 'No value') }}</small>
                                            </div>
                                        </div>
                                        <span class="sp-status {{ data_get($method, 'status_tone', 'green') }}">{{ data_get($method, 'status', 'Verified') }}</span>
                                        <button type="button" class="password-edit-button">Edit</button>
                                    </div>
                                @empty
                                    <div class="sp-empty">No recovery email or phone record yet. This card is only a template.</div>
                                @endforelse
                            </div>
                        </section>

                        <section class="sp-card password-bottom-card">
                            <div class="sp-title-left">
                                <span class="sp-icon green"><i class="fa-solid fa-shield"></i></span>
                                <div>
                                    <h3 class="sp-card-title sm">Password Best Practices</h3>
                                    <p class="sp-card-desc">Keep your sign-in details safe.</p>
                                </div>
                            </div>
                            <div class="password-check-list">
                                <span class="password-check"><i class="fa-solid fa-circle-check"></i> Use a unique password for your account</span>
                                <span class="password-check"><i class="fa-solid fa-circle-check"></i> Avoid using personal information</span>
                                <span class="password-check"><i class="fa-solid fa-circle-check"></i> Change your password regularly</span>
                                <span class="password-check"><i class="fa-solid fa-circle-check"></i> Don't share your password with anyone</span>
                            </div>
                        </section>
                    </div>
                </main>
            </div>
        </section>

        <!-- DEVICES TAB -->
        <section class="sp-panel" id="devices-panel">
            <div class="devices-reference-layout">
                <section class="sp-card devices-card">
                    <div class="sp-card-pad">
                        <div class="sp-title-left">
                            <span class="sp-icon green"><i class="fa-solid fa-desktop"></i></span>
                            <div>
                                <h2 class="sp-card-title">Active Devices &amp; Sessions</h2>
                                <p class="sp-card-desc">These are the devices currently signed in to your account.</p>
                            </div>
                        </div>

                        <div class="devices-summary">
                            <div class="devices-count-box">
                                <div class="devices-count-circle">{{ $activeDevices->count() }}</div>
                                <div>
                                    <strong class="sp-mini-title">Active<br>Devices</strong>
                                    <small class="sp-mini-desc">{{ $activeDevices->count() ? 'Backend device records loaded.' : 'No device record yet.' }}</small>
                                </div>
                            </div>
                            <div class="devices-feature"><span><i class="fa-regular fa-circle-check"></i> Regular monitoring</span><i class="fa-solid fa-chevron-down"></i></div>
                            <div class="devices-feature"><span><i class="fa-regular fa-circle-check"></i> Device verification ready</span><i class="fa-solid fa-chevron-down"></i></div>
                            <div class="devices-feature"><span><i class="fa-regular fa-circle-check"></i> Secure sessions</span><i class="fa-solid fa-chevron-down"></i></div>
                        </div>

                        <table class="sp-table" aria-label="Active devices and sessions">
                            <thead>
                                <tr>
                                    <th>Device</th>
                                    <th>Browser</th>
                                    <th>Location</th>
                                    <th>Last Active</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeDevices as $device)
                                    <tr>
                                        <td>
                                            <div class="sp-device">
                                                <i class="{{ data_get($device, 'icon', 'fa-solid fa-display') }}"></i>
                                                <div>
                                                    <b>{{ data_get($device, 'name', 'Device') }}</b>
                                                    <small>{{ data_get($device, 'os', 'Operating system') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ data_get($device, 'browser', 'Browser') }}</td>
                                        <td>{{ data_get($device, 'location', 'Location') }}<small>{{ data_get($device, 'country', '') }}</small></td>
                                        <td>{{ data_get($device, 'last_active', 'Last active') }}</td>
                                        <td><span class="sp-status {{ data_get($device, 'status_tone', 'green') }}">{{ data_get($device, 'status', 'Active') }}</span></td>
                                        <td>
                                            @if(data_get($device, 'is_current', false))
                                                —
                                            @else
                                                <button type="button" class="sp-btn">Sign Out</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="sp-empty">No device/session records yet. Connected devices will appear here once backend session tracking is added.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="devices-warning-row">
                            <p><i class="fa-solid fa-shield-halved"></i> Didn’t recognize a device? Sign out controls will work once backend sessions are connected.</p>
                            <button type="button" class="sp-btn primary pill">Sign Out All Other Sessions</button>
                        </div>
                    </div>
                </section>

                <section class="sp-card devices-card">
                    <div class="sp-card-pad">
                        <div class="devices-activity-settings">
                            <div>
                                <div class="sp-title-left">
                                    <span class="sp-icon"><i class="fa-solid fa-chart-line"></i></span>
                                    <div>
                                        <h3 class="sp-card-title">Recent Login Activity &amp; Device Security Settings</h3>
                                        <p class="sp-card-desc">Review your most recent account access and manage security preferences.</p>
                                    </div>
                                </div>
                                <table class="sp-table" aria-label="Recent login activity">
                                    <thead>
                                        <tr>
                                            <th>Date &amp; Time</th>
                                            <th>Device / Browser</th>
                                            <th>Location</th>
                                            <th>IP Address</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($loginActivities as $activity)
                                            <tr>
                                                <td>{{ data_get($activity, 'datetime', 'Date and time') }}</td>
                                                <td>{{ data_get($activity, 'device_browser', 'Device / Browser') }}</td>
                                                <td>{{ data_get($activity, 'location', 'Location') }}</td>
                                                <td>{{ data_get($activity, 'ip_address', 'IP address') }}</td>
                                                <td><span class="sp-status {{ data_get($activity, 'status_tone', 'green') }}">{{ data_get($activity, 'status', 'Success') }}</span></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <div class="sp-empty">No login activity yet. Login history will appear here after backend tracking is connected.</div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <aside class="devices-settings-side">
                                @foreach($deviceSettings as $setting)
                                    <div class="device-setting-row">
                                        <div class="sp-row-left">
                                            <span class="sp-icon green"><i class="{{ data_get($setting, 'icon') }}"></i></span>
                                            <div>
                                                <strong class="sp-mini-title">{{ data_get($setting, 'title') }}</strong>
                                                <small class="sp-mini-desc">{{ data_get($setting, 'description') }}</small>
                                            </div>
                                        </div>
                                        @if(data_get($setting, 'type') === 'select')
                                            <button type="button" class="sp-btn">{{ data_get($setting, 'value', 'Not set') }} <i class="fa-solid fa-chevron-down"></i></button>
                                        @else
                                            <label class="sp-switch" title="Template toggle only">
                                                <input type="checkbox" data-template-switch @checked(data_get($setting, 'enabled', false))>
                                                <span class="sp-slider"></span>
                                            </label>
                                        @endif
                                    </div>
                                @endforeach
                            </aside>
                        </div>
                    </div>
                </section>

                <section class="sp-card devices-card">
                    <div class="sp-card-pad">
                        <div class="sp-title-left">
                            <span class="sp-icon"><i class="fa-solid fa-shield-halved"></i></span>
                            <div>
                                <h3 class="sp-card-title">Safety Reminder</h3>
                                <p class="sp-card-desc">Follow these tips to keep your account secure.</p>
                            </div>
                        </div>
                        <div class="safety-grid">
                            <div class="safety-item">
                                <span class="safety-icon red"><i class="fa-solid fa-lock"></i></span>
                                <div>
                                    <strong class="sp-mini-title">Always log out</strong>
                                    <small class="sp-mini-desc">Log out of shared or public devices.</small>
                                </div>
                            </div>
                            <div class="safety-item">
                                <span class="safety-icon"><i class="fa-regular fa-eye"></i></span>
                                <div>
                                    <strong class="sp-mini-title">Review unknown logins</strong>
                                    <small class="sp-mini-desc">Check login activity regularly.</small>
                                </div>
                            </div>
                            <div class="safety-item">
                                <span class="safety-icon dark"><i class="fa-regular fa-envelope"></i></span>
                                <div>
                                    <strong class="sp-mini-title">Enable alerts</strong>
                                    <small class="sp-mini-desc">Keep new device alerts on.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>

        <!-- PRIVACY TAB -->
        <section class="sp-panel" id="privacy-panel">
            <div class="privacy-reference-layout">
                <section class="sp-card privacy-card">
                    <div class="sp-card-pad">
                        <div class="sp-title-left">
                            <span class="sp-icon red"><i class="fa-solid fa-shield-halved"></i></span>
                            <div>
                                <h2 class="sp-card-title">Privacy Controls &amp; Data &amp; Privacy Settings</h2>
                                <p class="sp-card-desc">You’re in control of how your personal data is used and shared. Adjust your privacy settings to match your preferences.</p>
                            </div>
                        </div>

                        <div class="privacy-main-summary">
                            <div class="privacy-score-circle">{{ $privacyScore ?? '—' }}<small>/100</small></div>
                            <div>
                                <strong class="sp-mini-title">{{ data_get($privacySummary, 'label', 'No saved privacy review yet') }}</strong>
                                <small class="sp-mini-desc">{{ data_get($privacySummary, 'description', 'Privacy score and saved preferences will appear after backend settings are connected.') }}</small>
                                <div class="privacy-score-meter"><i style="width:{{ $privacyScoreWidth }}%"></i></div>
                            </div>
                            <div style="text-align:right">
                                <small class="sp-mini-desc">Last reviewed: {{ data_get($privacySummary, 'last_reviewed', 'No record yet') }}</small>
                            </div>
                        </div>

                        <div class="privacy-controls-list">
                            @foreach($privacyControls as $control)
                                <div class="privacy-control-row">
                                    <div class="privacy-control-left">
                                        <span class="privacy-control-icon"><i class="{{ data_get($control, 'icon') }}"></i></span>
                                        <div>
                                            <strong class="sp-mini-title">{{ data_get($control, 'title') }}</strong>
                                            <small class="sp-mini-desc">{{ data_get($control, 'description') }}</small>
                                        </div>
                                    </div>
                                    <label class="sp-switch" title="Template toggle only">
                                        <input type="checkbox" data-template-switch @checked(data_get($control, 'enabled', false))>
                                        <span class="sp-slider"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section class="sp-card privacy-card">
                    <div class="sp-card-pad">
                        <div class="cookie-download-head">
                            <div class="sp-title-left">
                                <span class="sp-icon"><i class="fa-solid fa-cookie-bite"></i></span>
                                <div>
                                    <h3 class="sp-card-title">Cookie Preferences &amp; Download My Data</h3>
                                    <p class="sp-card-desc">Manage how we use cookies to improve your experience and request a copy of your data.</p>
                                </div>
                            </div>
                            <button type="button" class="sp-btn">Manage Cookies</button>
                        </div>

                        <div class="cookie-list">
                            @foreach($cookiePreferences as $cookie)
                                <div class="cookie-row">
                                    <div class="cookie-left">
                                        <i class="{{ data_get($cookie, 'icon') }}"></i>
                                        <div>
                                            <strong class="sp-mini-title">{{ data_get($cookie, 'title') }}</strong>
                                            <small class="sp-mini-desc">{{ data_get($cookie, 'description') }}</small>
                                        </div>
                                    </div>
                                    <span class="sp-status {{ data_get($cookie, 'status_tone', 'gray') }}">{{ data_get($cookie, 'status', 'Not set') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="download-row">
                            <div class="cookie-left">
                                <i class="fa-solid fa-download" style="color:var(--sp-blue)"></i>
                                <div>
                                    <strong class="sp-mini-title">Download My Data</strong>
                                    <small class="sp-mini-desc">Request a copy of your personal data that we have collected and stored.</small>
                                </div>
                            </div>
                            <button type="button" class="sp-btn">Request Data Export</button>
                        </div>
                    </div>
                </section>

                <section class="sp-card data-note-card">
                    <div class="sp-card-pad">
                        <div class="sp-title-left">
                            <span class="sp-icon"><i class="fa-solid fa-shield-halved"></i></span>
                            <div>
                                <h3 class="sp-card-title">Data Protection Note</h3>
                                <p class="sp-card-desc">We use industry-standard security measures to protect your personal data.</p>
                                <p class="sp-card-desc">You can manage your privacy preferences at any time.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>

    <div id="spToast" class="sp-toast">Template only. Backend is not connected yet.</div>
</div>

<script>
(function(){
    const tabs = document.querySelectorAll('.security-tab');
    const panels = document.querySelectorAll('.sp-panel');
    const tabNames = ['overview', 'password', 'devices', 'privacy'];

    function showSpToast(message){
        const toast = document.getElementById('spToast');
        if(!toast) return;
        toast.textContent = message || 'Template only. Backend is not connected yet.';
        toast.classList.add('show');
        clearTimeout(window.spToastTimer);
        window.spToastTimer = setTimeout(() => toast.classList.remove('show'), 2200);
    }
    window.showSpToast = showSpToast;

    function activateTab(name){
        if(!tabNames.includes(name)) name = 'overview';
        tabs.forEach(btn => btn.classList.toggle('active', btn.dataset.tab === name));
        panels.forEach(panel => panel.classList.toggle('active', panel.id === name + '-panel'));
        history.replaceState(null, '', window.location.pathname + '#' + name);
        window.scrollTo({top:0, behavior:'smooth'});
    }

    tabs.forEach(btn => btn.addEventListener('click', () => activateTab(btn.dataset.tab)));
    document.querySelectorAll('[data-tab-jump]').forEach(btn => btn.addEventListener('click', () => activateTab(btn.dataset.tabJump)));

    const hash = (window.location.hash || '').replace('#','');
    if(tabNames.includes(hash)) activateTab(hash);

    document.querySelectorAll('[data-toggle-pass]').forEach(btn => {
        btn.addEventListener('click', function(){
            const input = this.closest('.password-input-wrap')?.querySelector('input');
            if(!input) return;
            input.type = input.type === 'password' ? 'text' : 'password';
            this.innerHTML = input.type === 'password' ? '<i class="fa-regular fa-eye"></i>' : '<i class="fa-regular fa-eye-slash"></i>';
        });
    });

    document.querySelectorAll('[data-template-switch]').forEach(input => {
        input.addEventListener('change', () => {
            showSpToast('Template only. This preference is not saved yet. Connect backend saving first.');
        });
    });

    document.querySelectorAll('.sp-btn,.sp-action,.sp-link-button,.password-edit-button').forEach(button => {
        button.addEventListener('click', event => {
            const target = event.currentTarget;
            if(target.matches('[data-tab-jump],[data-toggle-pass]') || target.type === 'submit' || target.closest('form')) return;
            showSpToast('Template only. No data is saved until backend functions are connected.');
        });
    });
})();
</script>
</x-app-layout>
