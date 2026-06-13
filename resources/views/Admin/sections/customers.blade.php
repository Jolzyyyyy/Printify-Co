<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
:root{
    --admin-blue:#0b63f6;
    --admin-blue-2:#084ac2;
    --admin-black:#050816;
    --admin-soft-black:#111827;
    --admin-green:#10b981;
    --admin-orange:#f59e0b;
    --admin-red:#ef4444;
    --admin-purple:#7c3aed;
    --admin-muted:#667085;
    --admin-line:#e7edf6;
    --admin-soft:#f8fafc;
    --admin-hover:rgba(17,24,39,.08);
    --admin-shadow:0 8px 22px rgba(5,8,22,.055);
    --radius:14px;
}

.customer-management-main,
.customer-management-main *{box-sizing:border-box}
.customer-management-main{
    font-family:'Inter',system-ui,sans-serif;
    color:var(--admin-black);
    background:#fff;
    max-width:1360px;
    margin:0 auto;
    padding:20px 24px 26px;
    letter-spacing:.005em;
}
.customer-management-main button,
.customer-management-main input,
.customer-management-main select{font-family:'Inter',system-ui,sans-serif}
.customer-management-main h1{
    font-family:'Playfair Display',Georgia,serif;
    font-size:38px;
    line-height:1.04;
    font-weight:700;
    margin:0 0 7px;
    color:var(--admin-black);
}
.customer-management-main h2,
.customer-management-main h3,
.customer-management-main h4,
.card-title{
    font-family:'Poppins',sans-serif;
    font-weight:600;
    color:var(--admin-black);
}
.customer-management-main p{font-weight:400;margin:0;color:#344054}
.customer-title-line{position:relative;padding-top:14px}
.customer-title-line:before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:64px;
    height:4px;
    border-radius:999px;
    background:linear-gradient(90deg,#0b63f6,#4a90ff);
}
.customer-toast{
    position:fixed;
    top:24px;
    left:50%;
    transform:translateX(-50%);
    z-index:9999;
    padding:12px 22px;
    border-radius:999px;
    background:linear-gradient(135deg,#1274ff,#084ac2);
    color:#fff;
    font-size:13px;
    font-weight:700;
    box-shadow:0 14px 35px rgba(11,99,246,.25);
}
.customer-topbar{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:18px;
    margin-bottom:17px;
}
.customer-subtitle{font-size:14px;color:#344054}
.customer-actions{
    margin-left:auto;
    display:grid;
    grid-template-columns:128px 128px 128px;
    grid-template-areas:
        ". . date"
        "export filter create";
    gap:10px;
    align-items:stretch;
    justify-content:end;
    justify-items:stretch;
    width:404px;
    min-width:404px;
    margin-top:0;
}
.customer-date-control{
    grid-area:date;
    width:128px;
    min-width:128px;
    justify-content:center!important;
    padding:0 10px!important;
}
.customer-date-control span{max-width:78px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.customer-export-btn{grid-area:export;width:128px;min-width:128px}
.customer-filter-btn{grid-area:filter;width:128px;min-width:128px}
.customer-create-btn{grid-area:create;width:128px;min-width:128px}
.customer-btn{
    height:40px;
    min-width:128px;
    border:0;
    border-radius:9px;
    padding:0 15px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    cursor:pointer;
    white-space:nowrap;
    font-size:13px;
    font-weight:700;
    transition:background-color .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease;
}
.customer-btn svg{width:17px;height:17px;stroke-width:2.2}
.customer-btn-outline{
    background:#fff;
    color:var(--admin-black);
    box-shadow:inset 0 0 0 1.4px #cfd6e2;
}
.customer-btn-primary{
    background:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%);
    color:#fff;
    box-shadow:0 8px 16px rgba(11,99,246,.18);
}
.customer-btn:hover{
    background:var(--admin-black)!important;
    color:#fff!important;
    box-shadow:none!important;
}

.customer-metrics{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:14px;
    margin-bottom:16px;
}
.customer-metric-card{
    min-height:96px;
    border:1px solid var(--admin-line);
    border-radius:12px;
    background:#fff;
    padding:16px 18px;
    display:flex;
    align-items:center;
    gap:16px;
    box-shadow:var(--admin-shadow);
    cursor:pointer;
    transition:background-color .18s ease,border-color .18s ease;
}
.customer-metric-card:hover{background:var(--admin-hover)}
.metric-icon-box{
    width:56px;
    height:56px;
    border-radius:50%;
    display:grid;
    place-items:center;
    flex:0 0 auto;
}
.metric-icon-box svg{width:28px;height:28px;stroke-width:2.1}
.customer-metric-card.blue .metric-icon-box{background:#eaf1ff;color:#0b63f6}
.customer-metric-card.green .metric-icon-box{background:#dcfce9;color:#0f9f63}
.customer-metric-card.orange .metric-icon-box{background:#fff1d8;color:#f59e0b}
.customer-metric-card.red .metric-icon-box{background:#ffe4e6;color:#ef4444}
.metric-info h3{
    margin:0 0 5px;
    font-size:11px;
    line-height:1;
    text-transform:uppercase;
    letter-spacing:.01em;
    color:#344054;
}
.metric-info strong{display:block;font-size:24px;line-height:1;font-weight:800;margin-bottom:8px}
.metric-info p{font-size:11px;display:flex;align-items:center;gap:5px;color:#667085}
.trend-up{color:#0f9f63;font-weight:800}.trend-down{color:#ef4444;font-weight:800}

.customer-content-grid{
    display:grid;
    grid-template-columns:405px minmax(0,1fr);
    gap:16px;
    align-items:stretch;
}
.customer-list-box,
.customer-profile-box{
    background:#fff;
    border:1px solid var(--admin-line);
    border-radius:14px;
    box-shadow:var(--admin-shadow);
}
.customer-list-box{padding:14px}
.customer-list-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:12px;
}
.customer-list-head strong{font-family:'Poppins',sans-serif;font-size:16px;font-weight:600}
.customer-list-head span{font-family:'Inter',sans-serif;color:#667085;font-weight:400}
.icon-square{
    width:34px;height:34px;
    border:0;
    border-radius:9px;
    background:#fff;
    color:var(--admin-black);
    box-shadow:inset 0 0 0 1px #d9e0eb;
    display:inline-grid;place-items:center;
    cursor:pointer;
    transition:background-color .18s ease,color .18s ease;
}
.icon-square svg{width:17px;height:17px}
.icon-square:hover{background:var(--admin-black);color:#fff}
.user-search{
    height:42px;
    border:1px solid #dbe3ef;
    border-radius:9px;
    display:flex;
    align-items:center;
    gap:10px;
    padding:0 13px;
    margin-bottom:12px;
    background:#fff;
}
.user-search svg{width:18px;height:18px;color:#667085}
.user-search input{border:0;outline:0;width:100%;font-size:13px;color:#111827;background:transparent}
.user-search input::placeholder{color:#98a2b3}
.user-list{display:flex;flex-direction:column;gap:7px}
.user-row{
    width:100%;
    border:0;
    border-radius:9px;
    background:#fff;
    display:flex;
    align-items:center;
    gap:10px;
    padding:8px 9px;
    min-height:58px;
    cursor:pointer;
    color:var(--admin-black);
    text-align:left;
    transition:background-color .18s ease,box-shadow .18s ease;
}
.user-row:hover{background:var(--admin-hover)}
.user-row.active{background:#eef6ff;box-shadow:inset 0 0 0 1.4px #9cc5ff}
.avatar{
    width:38px;height:38px;border-radius:50%;overflow:hidden;
    background:#e7edf6;display:grid;place-items:center;flex:0 0 auto;
    font-weight:800;color:#0b63f6;
}
.avatar img{width:100%;height:100%;object-fit:cover}
.user-name{display:block;font-size:13px;font-weight:700;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.user-email{display:block;font-size:11px;color:#667085;line-height:1.25;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.status-pill{
    min-width:68px;
    height:24px;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    font-size:11px;
    font-weight:800;
    flex:0 0 auto;
}
.status-active{background:#dcfce9;color:#0f9f63}.status-inactive{background:#f2f4f7;color:#667085}.status-suspended{background:#ffe4e6;color:#ef4444}.status-invited{background:#fff1d8;color:#d97706}
.user-row-chevron{width:16px;height:16px;color:#667085;flex:0 0 auto}
.customer-list-footer{
    display:flex;
    align-items:center;
    gap:7px;
    margin-top:13px;
    padding:0 4px;
    font-size:12px;
    color:#667085;
}
.page-btn{
    width:32px;height:32px;border-radius:8px;
    border:1px solid #dbe3ef;background:#fff;color:#111827;
    display:grid;place-items:center;font-size:12px;font-weight:800;cursor:pointer;
    transition:color .18s ease,border-color .18s ease,background-color .18s ease;
}
.page-btn:hover{color:#0b63f6;border-color:#0b63f6;background:#fff}
.page-btn.active{background:linear-gradient(135deg,#1274ff,#084ac2);color:#fff;border-color:#0b63f6}
.page-btn.plain{border-color:transparent;background:transparent;color:#111827}
.page-btn.plain:hover{background:transparent;color:#0b63f6;border-color:transparent}

.customer-profile-box{padding:18px}
.profile-main-head{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:12px}
.profile-user-block{display:flex;align-items:center;gap:16px;min-width:0}
.profile-avatar{width:74px;height:74px;border-radius:50%;overflow:hidden;background:#e7edf6;display:grid;place-items:center;font-size:22px;font-weight:800;color:#0b63f6;flex:0 0 auto}
.profile-avatar img{width:100%;height:100%;object-fit:cover}
.profile-name-line{display:flex;align-items:center;gap:10px;margin-bottom:4px}
.profile-name-line h2{margin:0;font-size:24px;line-height:1.1}
.profile-email{font-size:13px;color:#344054;margin-bottom:9px}
.profile-meta{display:flex;align-items:center;gap:12px;flex-wrap:wrap;color:#667085;font-size:12px}
.profile-meta span{display:inline-flex;align-items:center;gap:6px}
.profile-meta svg{width:14px;height:14px}
.profile-actions{display:flex;align-items:center;gap:8px;flex:0 0 auto}
.more-btn{min-width:48px;width:48px;padding:0}
.profile-tabs{display:flex;align-items:center;gap:28px;border-bottom:1px solid #e8edf5;margin:12px -18px 16px;padding:0 18px}
.profile-tab{
    border:0;background:transparent;color:#344054;padding:0 0 13px;position:relative;font-size:13px;font-weight:700;cursor:pointer;
}
.profile-tab.active{color:#0b63f6}
.profile-tab.active:after{content:"";position:absolute;left:0;right:0;bottom:-1px;height:3px;border-radius:999px;background:#0b63f6}
.profile-tab:hover{color:#0b63f6}
.detail-grid{display:grid;grid-template-columns:minmax(0,1.35fr) 365px;gap:14px}
.info-card{
    border:1px solid var(--admin-line);
    border-radius:12px;
    background:#fff;
    padding:16px;
}
.info-card h3{font-size:15px;margin:0 0 13px}
.info-table{display:grid;gap:11px}
.info-row{display:grid;grid-template-columns:145px minmax(0,1fr);gap:10px;align-items:center;font-size:13px}
.info-label{color:#667085}.info-value{font-weight:600;color:#111827;min-width:0;word-break:break-word}
.recent-activity{margin-top:14px}
.activity-list{display:flex;flex-direction:column;gap:12px}
.activity-item{display:grid;grid-template-columns:28px minmax(0,1fr) auto;gap:10px;align-items:flex-start}
.activity-icon{width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#f2f6fb;color:#475467}.activity-icon svg{width:15px;height:15px}
.activity-copy b{display:block;font-size:13px}.activity-copy span{display:block;font-size:11px;color:#667085;line-height:1.2}.activity-time{font-size:11px;color:#667085;white-space:nowrap}
.link-action{border:0;background:transparent;color:#0b63f6;font-size:13px;font-weight:800;padding:0;display:inline-flex;align-items:center;gap:7px;cursor:pointer}.link-action svg{width:15px;height:15px}
.access-card{margin-bottom:14px}
.access-grid{display:grid;gap:12px}.access-row{display:flex;align-items:center;justify-content:space-between;font-size:13px;color:#667085}.access-row b{color:#111827;font-weight:600}.role-pill{height:26px;padding:0 12px;border-radius:999px;background:#eaf1ff;color:#0b63f6;display:inline-flex;align-items:center;font-size:12px;font-weight:800}
.quick-actions{display:flex;flex-direction:column;gap:8px}
.quick-btn{height:42px;border:1px solid #dbe3ef;border-radius:9px;background:#fff;color:#111827;display:flex;align-items:center;justify-content:space-between;gap:10px;padding:0 12px;font-size:13px;font-weight:700;cursor:pointer;transition:background-color .18s ease,color .18s ease,border-color .18s ease}
.quick-btn:hover{background:var(--admin-black);color:#fff;border-color:var(--admin-black)}
.quick-left{display:flex;align-items:center;gap:10px}.quick-left svg,.quick-btn>svg{width:16px;height:16px}.quick-btn.red{color:#ef4444}.quick-btn.red:hover{color:#fff}.quick-btn.orange .quick-left svg{color:#f59e0b}.quick-btn.blue .quick-left svg{color:#0b63f6}.quick-btn.red .quick-left svg{color:#ef4444}
.orders-table{width:100%;border-collapse:collapse;border:1.5px solid var(--admin-black);border-radius:12px;overflow:hidden;display:table}.orders-table th{height:42px;background:#f8fafc;text-align:left;padding:0 12px;font-size:11px;text-transform:uppercase;color:#344054;font-family:'Poppins';font-weight:600}.orders-table td{border-top:1px solid #e8edf5;padding:12px;font-size:13px}.order-link{border:0;background:transparent;color:#0b63f6;font-weight:800;cursor:pointer;padding:0}.order-link:hover{text-decoration:underline}.security-grid,.roles-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}.toggle-line{display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid #e8edf5}.toggle-line:last-child{border-bottom:0}.toggle{width:44px;height:24px;border-radius:999px;background:#d0d5dd;position:relative;cursor:pointer;transition:background .18s ease}.toggle:before{content:"";position:absolute;top:3px;left:3px;width:18px;height:18px;border-radius:50%;background:#fff;transition:transform .18s ease}.toggle.on{background:#10b981}.toggle.on:before{transform:translateX(20px)}.role-select-row{display:grid;grid-template-columns:1fr 128px;gap:10px;margin-top:12px}.role-select-row select{height:40px;border:1px solid #dbe3ef;border-radius:9px;padding:0 11px;font-size:13px;background:#fff;color:var(--admin-black);outline:none}.permission-card{display:grid;gap:9px}.permission-item{display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid #edf2f7}.permission-item:last-child{border-bottom:0}.permission-title{display:flex;flex-direction:column;gap:2px}.permission-title b{font-size:13px}.permission-title span{font-size:12px;color:#667085}.activity-tools{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:12px}.activity-tools select{height:38px;border:1px solid #dbe3ef;border-radius:9px;background:#fff;padding:0 10px;font-size:13px}.security-card-actions{display:grid;gap:9px;margin-top:12px}.mini-action-row{height:38px;border:1px solid #dbe3ef;border-radius:9px;background:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 12px;font-size:13px;font-weight:700;cursor:pointer}.mini-action-row:hover{background:var(--admin-black);color:#fff}.mini-action-row svg{width:16px;height:16px}

.modal-backdrop{position:fixed;inset:0;background:rgba(5,8,22,.45);backdrop-filter:blur(5px);z-index:8000;display:grid;place-items:center;padding:20px}
.modal-panel{width:min(820px,96vw);max-height:92vh;overflow:auto;background:#fff;border:1.5px solid var(--admin-black);border-radius:14px;box-shadow:0 30px 80px rgba(5,8,22,.28)}
.modal-header{height:58px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #e8edf5;padding:0 20px}.modal-header h3{font-size:18px;margin:0}.close-x{border:0;background:transparent;color:#111827;cursor:pointer}.close-x svg{width:22px;height:22px}.modal-body{padding:18px 20px}.modal-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}.modal-field label{display:block;font-size:11px;font-weight:800;color:#667085;text-transform:uppercase;margin-bottom:6px}.modal-field input,.modal-field select{width:100%;height:40px;border:1px solid #dbe3ef;border-radius:8px;padding:0 11px;font-size:13px;outline:none}.modal-field input:focus,.modal-field select:focus{border-color:#0b63f6}.modal-footer{display:flex;justify-content:flex-end;gap:10px;padding:0 20px 20px}.template-notice{border:1px solid var(--admin-black);border-radius:9px;padding:11px 13px;font-size:12px;color:#344054;margin-bottom:12px}.template-cards{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:12px}.template-card{border:1px solid #e8edf5;border-radius:10px;padding:12px}.template-card h4{font-size:13px;margin:0 0 10px}.template-row{display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #edf2f7;padding:7px 0;font-size:12px}.template-row:last-child{border-bottom:0}.template-label{color:#667085}.template-value{font-weight:700}.template-items{border:1px solid #e8edf5;border-radius:10px;padding:12px}.template-items h4{font-size:13px;margin:0 0 10px}.template-items table{width:100%;border-collapse:collapse}.template-items th{height:34px;background:#f8fafc;border-bottom:1px solid #e8edf5;padding:0 10px;text-align:left;font-size:11px;text-transform:uppercase}.template-items td{height:42px;border-bottom:1px solid #edf2f7;padding:0 10px;font-size:13px}
@media(max-width:1180px){.customer-content-grid,.detail-grid{grid-template-columns:1fr}.customer-metrics{grid-template-columns:repeat(2,1fr)}}
@media(max-width:760px){.customer-management-main{padding:16px}.customer-topbar{flex-direction:column}.customer-actions{width:100%;min-width:0;display:grid;grid-template-columns:1fr;grid-template-areas:"date" "export" "filter" "create"}.customer-date-control,.customer-export-btn,.customer-filter-btn,.customer-create-btn{width:100%;min-width:0}.customer-btn{width:100%;min-width:0}.customer-metrics,.security-grid,.roles-grid,.template-cards,.modal-grid{grid-template-columns:1fr}.profile-main-head{flex-direction:column}.profile-actions{width:100%;display:grid;grid-template-columns:1fr 48px}.profile-tabs{gap:16px;overflow-x:auto}.customer-list-footer{flex-wrap:wrap}}

/* =========================================================
   FINAL ADMIN CUSTOMER/USER BUTTON + CALENDAR PATCH
   - Blue gradient primary buttons
   - Export/Filter outline buttons with black border
   - Same compact pill size/shape
   - Calendar/date pill clean rounded rectangle, no "Present"
   - Calendar popup included and styled with admin blue
========================================================= */
.customer-management-main{
    --admin-button-start:#1274ff!important;
    --admin-button-mid:#0b63f6!important;
    --admin-button-end:#084ac2!important;
    --admin-button-hover:#111827!important;
}
.customer-management-main [x-cloak]{display:none!important}
.customer-actions{
    grid-template-columns:128px 128px 128px!important;
    grid-template-areas:
        ". date date"
        "export filter create"!important;
    gap:10px!important;
    align-items:stretch!important;
    justify-content:end!important;
    justify-items:stretch!important;
    width:404px!important;
    min-width:404px!important;
}
.customer-date-control{
    grid-area:date!important;
    width:266px!important;
    min-width:266px!important;
    height:42px!important;
    min-height:42px!important;
    padding:0 16px!important;
    border-radius:8px!important;
    border:1px solid #111827!important;
    background:#fff!important;
    background-image:none!important;
    color:#111827!important;
    box-shadow:none!important;
    justify-content:space-between!important;
}
.customer-date-control span{
    max-width:none!important;
    width:100%!important;
    text-align:center!important;
    overflow:hidden!important;
    text-overflow:ellipsis!important;
    white-space:nowrap!important;
    font-size:12px!important;
    font-weight:700!important;
}
.customer-date-control:hover,
.customer-date-control:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
}
.customer-date-control:hover svg,
.customer-date-control:focus svg{stroke:#fff!important;color:#fff!important}

.customer-btn{
    height:40px!important;
    min-height:40px!important;
    min-width:112px!important;
    padding:0 16px!important;
    border-radius:999px!important;
    font-size:12px!important;
    font-weight:600!important;
    line-height:1!important;
    letter-spacing:0!important;
    gap:8px!important;
    box-shadow:none!important;
    transform:none!important;
    transition:background .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease,filter .18s ease!important;
}
.customer-export-btn,
.customer-filter-btn,
.customer-create-btn{
    width:128px!important;
    min-width:128px!important;
}
.customer-btn-outline{
    background:#fff!important;
    background-image:none!important;
    color:#111827!important;
    border:1.4px solid #111827!important;
    box-shadow:none!important;
}
.customer-btn-primary{
    background:linear-gradient(135deg,var(--admin-button-start) 0%,var(--admin-button-mid) 52%,var(--admin-button-end) 100%)!important;
    background-image:linear-gradient(135deg,var(--admin-button-start) 0%,var(--admin-button-mid) 52%,var(--admin-button-end) 100%)!important;
    color:#fff!important;
    border:1px solid transparent!important;
    box-shadow:0 8px 18px rgba(11,99,246,.18)!important;
}
.customer-btn:hover,
.customer-btn:focus,
.customer-btn:active{
    background:#111827!important;
    background-image:none!important;
    color:#fff!important;
    border-color:#111827!important;
    box-shadow:0 10px 22px rgba(17,24,39,.14)!important;
    filter:none!important;
    transform:none!important;
}
.customer-btn:hover svg,
.customer-btn:focus svg,
.customer-btn:active svg{stroke:currentColor!important;color:currentColor!important}

.page-btn.active{
    background:linear-gradient(135deg,var(--admin-button-start),var(--admin-button-end))!important;
    border-color:var(--admin-button-mid)!important;
    color:#fff!important;
}
.quick-btn:hover{background:#111827!important;color:#fff!important;border-color:#111827!important}
.icon-square:hover{background:#111827!important;color:#fff!important;border-color:#111827!important}

/* Calendar modal */
.customer-calendar-overlay{
    position:fixed;
    inset:0;
    z-index:9998;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:18px;
    background:rgba(17,24,39,.36);
    backdrop-filter:blur(9px);
}
.customer-calendar-modal{
    width:min(920px,100%);
    max-height:calc(100vh - 36px);
    overflow:hidden;
    border:1px solid #e8edf5;
    border-radius:18px;
    background:#fff;
    box-shadow:0 26px 80px rgba(15,23,42,.22);
    display:grid;
    grid-template-columns:minmax(0,1.1fr) 310px;
    color:#111827;
}
.customer-calendar-main{padding:18px;border-right:1px solid #e8edf5;min-width:0}
.customer-calendar-side{padding:18px;background:#fbfbfb;min-width:0}
.customer-calendar-top{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}
.customer-calendar-title{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:16px;font-weight:700;color:#111827}
.customer-calendar-subtitle{margin:3px 0 0;font-size:11px;font-weight:400;color:#667085;line-height:1.45}
.customer-calendar-nav{display:flex;align-items:center;gap:7px}
.customer-calendar-icon-btn,
.customer-calendar-action-btn,
.customer-calendar-mini-btn,
.customer-calendar-save-btn,
.customer-calendar-clear-btn{
    border-radius:999px!important;
    cursor:pointer;
    transition:background .18s ease,border-color .18s ease,color .18s ease,box-shadow .18s ease;
    font-family:'Inter',system-ui,sans-serif;
}
.customer-calendar-icon-btn{
    width:34px;height:34px;padding:0;border:1px solid #e8edf5;background:#fff;color:#111827;display:inline-flex;align-items:center;justify-content:center;
}
.customer-calendar-action-btn,
.customer-calendar-mini-btn,
.customer-calendar-clear-btn{
    height:34px;padding:0 13px;border:1px solid #111827;background:#fff;color:#111827;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;gap:6px;
}
.customer-calendar-save-btn{
    height:36px;flex:1;border:0;background:linear-gradient(135deg,var(--admin-button-start),var(--admin-button-end));color:#fff;font-size:11px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;gap:6px;
}
.customer-calendar-icon-btn:hover,
.customer-calendar-icon-btn:focus,
.customer-calendar-action-btn:hover,
.customer-calendar-action-btn:focus,
.customer-calendar-mini-btn:hover,
.customer-calendar-mini-btn:focus,
.customer-calendar-clear-btn:hover,
.customer-calendar-clear-btn:focus,
.customer-calendar-save-btn:hover,
.customer-calendar-save-btn:focus{
    background:#111827!important;
    background-image:none!important;
    border-color:#111827!important;
    color:#fff!important;
}
.customer-calendar-weekdays,
.customer-calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:7px}
.customer-calendar-weekdays{margin-bottom:7px}
.customer-calendar-weekdays span{text-align:center;font-size:9.5px;font-weight:800;color:#6b7280;letter-spacing:.08em;text-transform:uppercase}
.customer-calendar-day{
    position:relative;min-height:78px;border:1px solid #e8edf5;border-radius:12px;background:#fff;padding:8px;text-align:left;color:#111827;cursor:pointer;transition:.18s;overflow:hidden;
}
.customer-calendar-day:hover,.customer-calendar-day:focus{border-color:var(--admin-button-mid);box-shadow:0 10px 24px rgba(11,99,246,.10)}
.customer-calendar-day.is-muted{background:#fafafa;color:#a1a1aa;cursor:default}
.customer-calendar-day.is-today{border-color:var(--admin-button-mid);background:#eaf1ff}
.customer-calendar-day.is-selected{border-color:#111827;background:rgba(17,24,39,.08);box-shadow:inset 0 0 0 1px #111827}
.customer-calendar-day-number{display:block;font-size:12px;font-weight:800;line-height:1}
.customer-calendar-day-events{display:flex;flex-wrap:wrap;gap:4px;margin-top:17px}
.customer-calendar-event-dot{width:7px;height:7px;border-radius:999px;background:var(--admin-button-mid);box-shadow:0 0 0 3px rgba(11,99,246,.10)}
.customer-calendar-more{font-size:9px;font-weight:700;color:#667085;line-height:1}
.customer-calendar-selected-date{margin:0 0 12px;font-family:'Poppins',system-ui,sans-serif;font-size:15px;font-weight:700;color:#111827}
.customer-calendar-event-list{display:grid;gap:8px;max-height:182px;overflow:auto;padding-right:2px;margin-bottom:13px}
.customer-calendar-event-item{border:1px solid #e8edf5;border-radius:12px;background:#fff;padding:10px;display:grid;gap:7px}
.customer-calendar-event-title{font-size:12px;font-weight:800;color:#111827;line-height:1.3}
.customer-calendar-event-meta{font-size:10px;font-weight:600;color:var(--admin-button-mid);line-height:1.35}
.customer-calendar-event-note{font-size:10.5px;font-weight:400;color:#667085;line-height:1.45}
.customer-calendar-empty{min-height:74px;border:1px dashed #d8dee8;border-radius:12px;display:grid;place-items:center;text-align:center;color:#667085;font-size:11px;font-weight:500;line-height:1.45;padding:12px;background:#fff}
.customer-calendar-form{display:grid;gap:9px}
.customer-calendar-field{display:grid;gap:5px}
.customer-calendar-field label{font-size:10px;font-weight:800;color:#4b5563;letter-spacing:.05em;text-transform:uppercase}
.customer-calendar-field input,
.customer-calendar-field textarea{
    width:100%;border:1px solid #e8edf5;border-radius:10px;background:#fff;padding:10px 11px;color:#111827;font-family:'Inter',system-ui,sans-serif;font-size:12px;font-weight:500;outline:none;transition:.18s;
}
.customer-calendar-field textarea{min-height:68px;resize:vertical}
.customer-calendar-field input:focus,
.customer-calendar-field textarea:focus{border-color:var(--admin-button-mid);box-shadow:0 0 0 3px rgba(11,99,246,.10)}
.customer-calendar-form-actions{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:2px}
.customer-calendar-clear-btn{width:82px;height:36px}

@media(max-width:820px){
    .customer-calendar-modal{grid-template-columns:1fr;overflow:auto}
    .customer-calendar-main{border-right:0;border-bottom:1px solid #e8edf5}
    .customer-calendar-side{background:#fff}
    .customer-calendar-day{min-height:62px}
}
@media(max-width:760px){
    .customer-actions{width:100%!important;min-width:0!important;display:grid!important;grid-template-columns:1fr!important;grid-template-areas:"date" "export" "filter" "create"!important}
    .customer-date-control,.customer-export-btn,.customer-filter-btn,.customer-create-btn,.customer-btn{width:100%!important;min-width:0!important}
}



/* =========================================================
   CUSTOMER FINAL PATCH - Requested Design Sync
   - Metric box colors:
     TOTAL USERS = Blue
     ACTIVE USERS = Green
     PENDING INVITES = Yellow
     SUSPENDED ACCOUNTS = Red
   - Calendar/date control uses the same Dashboard shape/style
   - Customer buttons use Dashboard button size
   - Customer boxes use Knowledge Base Management box color/style
========================================================= */
.customer-management-main{
    --kb-card:#ffffff;
    --kb-border:#DDE6F2;
    --kb-soft-border:#E7EEF8;
    --kb-shadow:0 10px 25px rgba(15,23,42,0.045);
    --kb-radius:14px;
    --metric-blue:#0B63F6;
    --metric-green:#10B981;
    --metric-yellow:#F59E0B;
    --metric-red:#EF4444;
}

/* Metric boxes color mapping */
.customer-management-main .customer-metric-card{
    background:#ffffff!important;
    border-width:1.4px!important;
    border-style:solid!important;
    border-radius:12px!important;
    box-shadow:var(--kb-shadow)!important;
}
.customer-management-main .customer-metric-card.blue{
    border-color:var(--metric-blue)!important;
}
.customer-management-main .customer-metric-card.green{
    border-color:var(--metric-green)!important;
}
.customer-management-main .customer-metric-card.orange{
    border-color:var(--metric-yellow)!important;
}
.customer-management-main .customer-metric-card.red{
    border-color:var(--metric-red)!important;
}
.customer-management-main .customer-metric-card.blue .metric-icon-box{
    background:#EAF2FF!important;
    color:var(--metric-blue)!important;
}
.customer-management-main .customer-metric-card.green .metric-icon-box{
    background:#EAFBF0!important;
    color:var(--metric-green)!important;
}
.customer-management-main .customer-metric-card.orange .metric-icon-box{
    background:#FFF3E3!important;
    color:var(--metric-yellow)!important;
}
.customer-management-main .customer-metric-card.red .metric-icon-box{
    background:#FFE4E6!important;
    color:var(--metric-red)!important;
}
.customer-management-main .customer-metric-card:hover{
    background:rgba(17,24,39,.08)!important;
}

/* Knowledge Base Management box style applied to Customer boxes */
.customer-management-main .customer-list-box,
.customer-management-main .customer-profile-box,
.customer-management-main .info-card,
.customer-management-main .modal-panel,
.customer-management-main .template-card,
.customer-management-main .template-items,
.customer-management-main .template-notice,
.customer-management-main .orders-table{
    background:var(--kb-card)!important;
    border:1px solid var(--kb-border)!important;
    border-radius:var(--kb-radius)!important;
    box-shadow:var(--kb-shadow)!important;
}
.customer-management-main .customer-list-box,
.customer-management-main .customer-profile-box{
    padding:16px!important;
}
.customer-management-main .info-card{
    padding:16px!important;
}
.customer-management-main .orders-table{
    overflow:hidden!important;
}

/* Dashboard-size Customer buttons */
.customer-management-main .customer-actions{
    grid-template-columns:118px 118px 118px!important;
    grid-template-areas:
        ". date date"
        "export filter create"!important;
    gap:9px!important;
    width:372px!important;
    min-width:372px!important;
}
.customer-management-main .customer-btn,
.customer-management-main .customer-export-btn,
.customer-management-main .customer-filter-btn,
.customer-management-main .customer-create-btn,
.customer-management-main .profile-actions .customer-btn,
.customer-management-main .modal-footer .customer-btn,
.customer-management-main .role-select-row .customer-btn,
.customer-management-main .activity-tools .customer-btn{
    height:34px!important;
    min-height:34px!important;
    min-width:118px!important;
    padding:0 14px!important;
    border-radius:999px!important;
    font-size:11.5px!important;
    font-weight:500!important;
    line-height:1!important;
    letter-spacing:0!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:6px!important;
    box-shadow:none!important;
    transform:none!important;
    filter:none!important;
    white-space:nowrap!important;
}
.customer-management-main .customer-export-btn,
.customer-management-main .customer-filter-btn,
.customer-management-main .customer-create-btn{
    width:118px!important;
    min-width:118px!important;
    max-width:118px!important;
}
.customer-management-main .profile-actions .more-btn{
    width:42px!important;
    min-width:42px!important;
    max-width:42px!important;
    padding:0!important;
}
.customer-management-main .customer-btn-outline{
    background:#ffffff!important;
    background-image:none!important;
    color:#111827!important;
    border:1px solid #111827!important;
}
.customer-management-main .customer-btn-primary{
    background:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;
    background-image:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;
    color:#ffffff!important;
    border:1px solid transparent!important;
}
.customer-management-main .customer-btn:hover,
.customer-management-main .customer-btn:focus,
.customer-management-main .customer-btn:active{
    background:#111827!important;
    background-image:none!important;
    border-color:#111827!important;
    color:#ffffff!important;
    box-shadow:none!important;
    transform:none!important;
    filter:none!important;
}
.customer-management-main .customer-btn svg{
    width:16px!important;
    height:16px!important;
    stroke:currentColor!important;
}

/* Calendar/date shape copied from Dashboard: compact rounded rectangle, not oval */
.customer-management-main .customer-date-control{
    grid-area:date!important;
    width:245px!important;
    min-width:245px!important;
    max-width:245px!important;
    height:42px!important;
    min-height:42px!important;
    padding:0 14px!important;
    border-radius:8px!important;
    border:1px solid #111827!important;
    background:#ffffff!important;
    background-image:none!important;
    color:#111827!important;
    box-shadow:none!important;
    display:grid!important;
    grid-template-columns:18px minmax(0,1fr) 16px!important;
    align-items:center!important;
    justify-items:center!important;
    column-gap:10px!important;
    white-space:nowrap!important;
    overflow:hidden!important;
}
.customer-management-main .customer-date-control span{
    display:block!important;
    width:100%!important;
    max-width:none!important;
    overflow:hidden!important;
    text-overflow:ellipsis!important;
    text-align:center!important;
    font-size:12px!important;
    font-weight:700!important;
    line-height:1!important;
    color:inherit!important;
}
.customer-management-main .customer-date-control svg{
    width:16px!important;
    height:16px!important;
    stroke:currentColor!important;
    color:currentColor!important;
}
.customer-management-main .customer-date-control:hover,
.customer-management-main .customer-date-control:focus{
    background:#111827!important;
    background-image:none!important;
    border-color:#111827!important;
    color:#ffffff!important;
    box-shadow:none!important;
    filter:none!important;
    transform:none!important;
}

/* Calendar modal button sizes aligned with Dashboard buttons */
.customer-management-main .customer-calendar-action-btn,
.customer-management-main .customer-calendar-mini-btn,
.customer-management-main .customer-calendar-clear-btn,
.customer-management-main .customer-calendar-save-btn{
    height:34px!important;
    min-height:34px!important;
    border-radius:999px!important;
    font-size:11.5px!important;
    font-weight:500!important;
    box-shadow:none!important;
}
.customer-management-main .customer-calendar-save-btn{
    background:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;
    background-image:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;
    color:#ffffff!important;
}

@media(max-width:760px){
    .customer-management-main .customer-actions{
        width:100%!important;
        min-width:0!important;
        grid-template-columns:1fr!important;
        grid-template-areas:"date" "export" "filter" "create"!important;
    }
    .customer-management-main .customer-date-control,
    .customer-management-main .customer-export-btn,
    .customer-management-main .customer-filter-btn,
    .customer-management-main .customer-create-btn,
    .customer-management-main .customer-btn{
        width:100%!important;
        min-width:0!important;
        max-width:100%!important;
    }
}

</style>

<div x-data="customerManagementExactApp()" x-init="init()" class="customer-management-main">
    <div x-show="toast.show" x-transition class="customer-toast" x-text="toast.message" style="display:none"></div>

    <div class="customer-calendar-overlay" x-show="calendarOpen" x-transition.opacity @click.self="calendarOpen=false" @keydown.escape.window="calendarOpen=false" x-cloak>
        <div class="customer-calendar-modal" role="dialog" aria-modal="true" aria-label="Customer calendar">
            <div class="customer-calendar-main">
                <div class="customer-calendar-top">
                    <div>
                        <h2 class="customer-calendar-title" x-text="calendarMonthTitle"></h2>
                        <p class="customer-calendar-subtitle">Select a date to review customer activity, exports, and scheduled account tasks.</p>
                    </div>
                    <div class="customer-calendar-nav">
                        <button type="button" class="customer-calendar-icon-btn" @click="prevCalendarMonth()" aria-label="Previous month"><i data-lucide="chevron-left"></i></button>
                        <button type="button" class="customer-calendar-action-btn" @click="goToday()">Today</button>
                        <button type="button" class="customer-calendar-icon-btn" @click="nextCalendarMonth()" aria-label="Next month"><i data-lucide="chevron-right"></i></button>
                        <button type="button" class="customer-calendar-icon-btn" @click="calendarOpen=false" aria-label="Close calendar"><i data-lucide="x"></i></button>
                    </div>
                </div>
                <div class="customer-calendar-weekdays">
                    <template x-for="day in weekDays" :key="day"><span x-text="day"></span></template>
                </div>
                <div class="customer-calendar-grid">
                    <template x-for="day in calendarDays" :key="day.key">
                        <button type="button" class="customer-calendar-day" :class="{'is-muted':!day.currentMonth,'is-today':day.isToday,'is-selected':day.iso===selectedDate}" @click="selectCalendarDate(day)">
                            <span class="customer-calendar-day-number" x-text="day.date"></span>
                            <span class="customer-calendar-day-events" x-show="day.events.length">
                                <template x-for="event in day.events.slice(0,3)" :key="event.title">
                                    <span class="customer-calendar-event-dot" :title="event.title"></span>
                                </template>
                                <span class="customer-calendar-more" x-show="day.events.length > 3" x-text="'+' + (day.events.length - 3)"></span>
                            </span>
                        </button>
                    </template>
                </div>
            </div>
            <aside class="customer-calendar-side">
                <h3 class="customer-calendar-selected-date" x-text="selectedDateLabel"></h3>
                <div class="customer-calendar-event-list" x-show="selectedDateEvents.length">
                    <template x-for="event in selectedDateEvents" :key="event.title + event.time">
                        <div class="customer-calendar-event-item">
                            <div class="customer-calendar-event-title" x-text="event.title"></div>
                            <div class="customer-calendar-event-meta" x-text="event.time"></div>
                            <div class="customer-calendar-event-note" x-text="event.note"></div>
                        </div>
                    </template>
                </div>
                <div class="customer-calendar-empty" x-show="!selectedDateEvents.length">No customer tasks scheduled for this date.</div>
                <form class="customer-calendar-form" @submit.prevent="saveCalendarTask()">
                    <div class="customer-calendar-field">
                        <label>Task title</label>
                        <input type="text" x-model="calendarDraft.title" placeholder="Follow up with customer">
                    </div>
                    <div class="customer-calendar-field">
                        <label>Time</label>
                        <input type="time" x-model="calendarDraft.time">
                    </div>
                    <div class="customer-calendar-field">
                        <label>Note</label>
                        <textarea x-model="calendarDraft.note" placeholder="Add a quick note..."></textarea>
                    </div>
                    <div class="customer-calendar-form-actions">
                        <button type="button" class="customer-calendar-clear-btn" @click="clearCalendarDraft()">Clear</button>
                        <button type="submit" class="customer-calendar-save-btn"><i data-lucide="save"></i>Save Task</button>
                    </div>
                </form>
            </aside>
        </div>
    </div>


    <section class="customer-topbar customer-title-line">
        <div>
            <h1>Customer Management</h1>
            <p class="customer-subtitle">Manage users, permissions, account status, and recent activity.</p>
        </div>
        <div class="customer-actions">
            <button type="button" class="customer-btn customer-btn-outline customer-date-control" @click="openCalendar()">
                <i data-lucide="calendar-days"></i><span x-text="selectedDateLabel"></span><i data-lucide="chevron-down"></i>
            </button>
            <button type="button" class="customer-btn customer-btn-outline customer-export-btn" @click="exportCustomers()">
                <i data-lucide="download"></i><span>Export</span>
            </button>
            <button type="button" class="customer-btn customer-btn-outline customer-filter-btn" @click="cycleFilter()">
                <i data-lucide="funnel"></i><span>Filter</span>
            </button>
            <button type="button" class="customer-btn customer-btn-primary customer-create-btn" @click="openAddModal()">
                <i data-lucide="plus"></i><span>Add New User</span>
            </button>
        </div>
    </section>

    <section class="customer-metrics">
        <button type="button" class="customer-metric-card blue" @click="setFilter('')">
            <span class="metric-icon-box"><i data-lucide="users-round"></i></span>
            <span class="metric-info"><h3>Total Users</h3><strong>1,452</strong><p><span class="trend-up">↑ 12.4%</span><span>vs last 30 days</span></p></span>
        </button>
        <button type="button" class="customer-metric-card green" @click="setFilter('ACTIVE')">
            <span class="metric-icon-box"><i data-lucide="user-round-check"></i></span>
            <span class="metric-info"><h3>Active Users</h3><strong>1,156</strong><p><span class="trend-up">↑ 9.8%</span><span>vs last 30 days</span></p></span>
        </button>
        <button type="button" class="customer-metric-card orange" @click="setFilter('INVITED')">
            <span class="metric-icon-box"><i data-lucide="mail"></i></span>
            <span class="metric-info"><h3>Pending Invites</h3><strong>246</strong><p><span class="trend-up">↑ 18.6%</span><span>vs last 30 days</span></p></span>
        </button>
        <button type="button" class="customer-metric-card red" @click="setFilter('SUSPENDED')">
            <span class="metric-icon-box"><i data-lucide="shield-alert"></i></span>
            <span class="metric-info"><h3>Suspended Accounts</h3><strong>50</strong><p><span class="trend-down">↓ 2.3%</span><span>vs last 30 days</span></p></span>
        </button>
    </section>

    <section class="customer-content-grid">
        <aside class="customer-list-box">
            <div class="customer-list-head">
                <strong>All Users <span x-text="'(' + filteredUsers.length.toLocaleString() + ')' "></span></strong>
                <button type="button" class="icon-square" @click="cycleFilter()" title="Filter users"><i data-lucide="sliders-horizontal"></i></button>
            </div>

            <label class="user-search">
                <i data-lucide="search"></i>
                <input type="search" placeholder="Search users..." x-model="searchQuery" @input="page=1">
            </label>

            <div class="user-list">
                <template x-for="user in pagedUsers" :key="user.id">
                    <button type="button" class="user-row" :class="selectedUser.id === user.id ? 'active' : ''" @click="selectUser(user)">
                        <span class="avatar">
                            <template x-if="user.photo"><img :src="user.photo" alt="Avatar"></template>
                            <template x-if="!user.photo"><span x-text="initials(user.name)"></span></template>
                        </span>
                        <span style="min-width:0;flex:1">
                            <span class="user-name" x-text="user.name"></span>
                            <span class="user-email" x-text="user.email"></span>
                        </span>
                        <span class="status-pill" :class="statusClass(user.status)" x-text="statusLabel(user.status)"></span>
                        <i data-lucide="chevron-right" class="user-row-chevron"></i>
                    </button>
                </template>
            </div>

            <div class="customer-list-footer">
                <span x-text="'Showing ' + rangeStart + ' to ' + rangeEnd + ' of ' + filteredUsers.length.toLocaleString()"></span>
                <span style="flex:1"></span>
                <button type="button" class="page-btn" :class="page===1?'active':''" @click="page=1">1</button>
                <button type="button" class="page-btn" :class="page===2?'active':''" @click="page=2">2</button>
                <button type="button" class="page-btn" :class="page===3?'active':''" @click="page=3">3</button>
                <span class="page-btn plain">...</span>
                <button type="button" class="page-btn" @click="page=totalPages" x-text="totalPages"></button>
                <button type="button" class="page-btn plain" @click="nextPage()"><i data-lucide="chevron-right"></i></button>
            </div>
        </aside>

        <article class="customer-profile-box" x-show="selectedUser" x-transition>
            <header class="profile-main-head">
                <div class="profile-user-block">
                    <div class="profile-avatar">
                        <template x-if="selectedUser.photo"><img :src="selectedUser.photo" alt="Profile"></template>
                        <template x-if="!selectedUser.photo"><span x-text="initials(selectedUser.name)"></span></template>
                    </div>
                    <div>
                        <div class="profile-name-line">
                            <h2 x-text="selectedUser.name"></h2>
                            <span class="status-pill" :class="statusClass(selectedUser.status)" x-text="statusLabel(selectedUser.status)"></span>
                        </div>
                        <div class="profile-email" x-text="selectedUser.email"></div>
                        <div class="profile-meta">
                            <span><i data-lucide="briefcase-business"></i><span x-text="selectedUser.role"></span></span>
                            <span>|</span>
                            <span>Joined <span x-text="selectedUser.joined"></span></span>
                            <span>|</span>
                            <span>Customer ID: <span x-text="selectedUser.id"></span></span>
                        </div>
                    </div>
                </div>
                <div class="profile-actions">
                    <button type="button" class="customer-btn customer-btn-primary" @click="openEditModal(selectedUser)">Edit User</button>
                    <button type="button" class="customer-btn customer-btn-outline more-btn" @click="showToast('More actions opened')"><i data-lucide="ellipsis"></i></button>
                </div>
            </header>

            <nav class="profile-tabs">
                <button type="button" class="profile-tab" :class="activeTab==='overview'?'active':''" @click="activeTab='overview'">Overview</button>
                <button type="button" class="profile-tab" :class="activeTab==='roles'?'active':''" @click="activeTab='roles'">Roles & Permissions</button>
                <button type="button" class="profile-tab" :class="activeTab==='orders'?'active':''" @click="activeTab='orders'">Orders</button>
                <button type="button" class="profile-tab" :class="activeTab==='activity'?'active':''" @click="activeTab='activity'">Activity Log</button>
                <button type="button" class="profile-tab" :class="activeTab==='security'?'active':''" @click="activeTab='security'">Security</button>
            </nav>

            <div x-show="activeTab==='overview'" class="detail-grid">
                <div>
                    <section class="info-card">
                        <h3>Account Information</h3>
                        <div class="info-table">
                            <div class="info-row"><span class="info-label">Full Name</span><span class="info-value" x-text="selectedUser.name"></span></div>
                            <div class="info-row"><span class="info-label">Email</span><span class="info-value" x-text="selectedUser.email"></span></div>
                            <div class="info-row"><span class="info-label">Phone</span><span class="info-value" x-text="selectedUser.phone"></span></div>
                            <div class="info-row"><span class="info-label">Company</span><span class="info-value" x-text="selectedUser.company"></span></div>
                            <div class="info-row"><span class="info-label">Status</span><span><span class="status-pill" :class="statusClass(selectedUser.status)" x-text="statusLabel(selectedUser.status)"></span></span></div>
                            <div class="info-row"><span class="info-label">Email Verified</span><span><span class="status-pill status-active">✓ Verified</span></span></div>
                            <div class="info-row"><span class="info-label">Last Login</span><span class="info-value" x-text="selectedUser.lastLogin"></span></div>
                            <div class="info-row"><span class="info-label">Customer Since</span><span class="info-value" x-text="selectedUser.since"></span></div>
                        </div>
                    </section>

                    <section class="info-card recent-activity">
                        <h3>Recent Activity</h3>
                        <div class="activity-list">
                            <template x-for="activity in selectedUser.activities" :key="activity.title">
                                <div class="activity-item">
                                    <span class="activity-icon"><i :data-lucide="activity.icon"></i></span>
                                    <span class="activity-copy"><b x-text="activity.title"></b><span x-text="activity.desc"></span></span>
                                    <span class="activity-time" x-text="activity.time"></span>
                                </div>
                            </template>
                        </div>
                        <button type="button" class="link-action" style="margin-top:12px" @click="activeTab='activity'">View full activity log <i data-lucide="arrow-right"></i></button>
                    </section>
                </div>

                <aside>
                    <section class="info-card access-card">
                        <h3>Roles & Access</h3>
                        <div class="access-grid">
                            <div class="access-row"><span>Primary Role</span><b class="role-pill" x-text="selectedUser.roleShort"></b></div>
                            <div class="access-row"><span>Scope</span><b x-text="selectedUser.scope"></b></div>
                            <div class="access-row"><span>Permissions</span><b x-text="selectedUser.permissions"></b></div>
                        </div>
                        <button type="button" class="link-action" style="margin-top:18px" @click="activeTab='roles'">View all permissions <i data-lucide="arrow-right"></i></button>
                    </section>

                    <section class="info-card">
                        <h3>Quick Actions</h3>
                        <div class="quick-actions">
                            <button type="button" class="quick-btn blue" @click="resetPassword()"><span class="quick-left"><i data-lucide="lock-keyhole"></i>Reset Password</span><i data-lucide="chevron-right"></i></button>
                            <button type="button" class="quick-btn blue" @click="sendInvite()"><span class="quick-left"><i data-lucide="mail"></i>Send Invite</span><i data-lucide="chevron-right"></i></button>
                            <button type="button" class="quick-btn orange" @click="suspendSelected()"><span class="quick-left"><i data-lucide="shield-alert"></i>Suspend Account</span><i data-lucide="chevron-right"></i></button>
                            <button type="button" class="quick-btn red" @click="deleteSelected()"><span class="quick-left"><i data-lucide="trash-2"></i>Delete Account</span><i data-lucide="chevron-right"></i></button>
                        </div>
                    </section>
                </aside>
            </div>

            <div x-show="activeTab==='roles'" class="roles-grid">
                <section class="info-card">
                    <h3>Assigned Role</h3>
                    <div class="info-table">
                        <div class="info-row"><span class="info-label">Primary Role</span><span class="info-value" x-text="selectedUser.role"></span></div>
                        <div class="info-row"><span class="info-label">Access Scope</span><span class="info-value" x-text="selectedUser.scope"></span></div>
                        <div class="info-row"><span class="info-label">Permissions Enabled</span><span class="info-value" x-text="enabledPermissionCount + ' of ' + permissions.length"></span></div>
                        <div class="info-row"><span class="info-label">Access Level</span><span class="info-value" x-text="accessLevelLabel"></span></div>
                    </div>
                    <div class="role-select-row">
                        <select x-model="roleDraft">
                            <option>Product Admin</option>
                            <option>Manager</option>
                            <option>Customer Support</option>
                            <option>Print Staff</option>
                            <option>Customer User</option>
                        </select>
                        <button type="button" class="customer-btn customer-btn-primary" @click="applyRole()">Save Role</button>
                    </div>
                </section>
                <section class="info-card">
                    <h3>Permission Controls</h3>
                    <div class="permission-card">
                        <template x-for="permission in permissions" :key="permission.key">
                            <div class="permission-item">
                                <span class="permission-title"><b x-text="permission.label"></b><span x-text="permission.desc"></span></span>
                                <span class="toggle" :class="permission.enabled ? 'on' : ''" @click="togglePermission(permission.key)"></span>
                            </div>
                        </template>
                    </div>
                </section>
            </div>

            <div x-show="activeTab==='orders'">
                <section class="info-card">
                    <h3>Customer Orders</h3>
                    <table class="orders-table">
                        <thead><tr><th>Order ID</th><th>Service / Item</th><th>Date</th><th>Status</th><th>Total</th></tr></thead>
                        <tbody>
                            <template x-for="order in selectedUser.orders" :key="order.id">
                                <tr>
                                    <td><button type="button" class="order-link" @click="openOrderTemplate(order.id)" x-text="order.id"></button></td>
                                    <td x-text="order.item"></td>
                                    <td x-text="order.date"></td>
                                    <td><span class="status-pill status-active" x-text="order.status"></span></td>
                                    <td><b x-text="order.total"></b></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </section>
            </div>

            <div x-show="activeTab==='activity'">
                <section class="info-card">
                    <div class="activity-tools">
                        <h3 style="margin:0">Activity Log</h3>
                        <div style="display:flex;gap:8px;align-items:center">
                            <select x-model="activityFilter">
                                <option value="">All Activity</option>
                                <option value="Logged">Login</option>
                                <option value="Updated">Profile Updates</option>
                                <option value="Order">Orders</option>
                                <option value="Security">Security</option>
                            </select>
                            <button type="button" class="customer-btn customer-btn-outline" @click="clearActivityFilter()">Clear</button>
                        </div>
                    </div>
                    <div class="activity-list">
                        <template x-for="activity in visibleActivities" :key="activity.title + activity.time">
                            <div class="activity-item">
                                <span class="activity-icon"><i :data-lucide="activity.icon"></i></span>
                                <span class="activity-copy"><b x-text="activity.title"></b><span x-text="activity.desc"></span></span>
                                <span class="activity-time" x-text="activity.time"></span>
                            </div>
                        </template>
                    </div>
                </section>
            </div>

            <div x-show="activeTab==='security'" class="security-grid">
                <section class="info-card">
                    <h3>Security Settings</h3>
                    <div class="toggle-line"><b>Two-Factor Authentication</b><span class="toggle" :class="security.twoFactor ? 'on' : ''" @click="toggleSecurity('twoFactor')"></span></div>
                    <div class="toggle-line"><b>Email Login Alerts</b><span class="toggle" :class="security.loginAlerts ? 'on' : ''" @click="toggleSecurity('loginAlerts')"></span></div>
                    <div class="toggle-line"><b>Require Password Reset</b><span class="toggle" :class="security.forceReset ? 'on' : ''" @click="toggleSecurity('forceReset')"></span></div>
                    <div class="toggle-line"><b>Block Suspicious Login</b><span class="toggle" :class="security.blockSuspicious ? 'on' : ''" @click="toggleSecurity('blockSuspicious')"></span></div>
                    <div class="security-card-actions">
                        <button type="button" class="mini-action-row" @click="resetPassword()"><span>Send password reset</span><i data-lucide="chevron-right"></i></button>
                        <button type="button" class="mini-action-row" @click="showToast('Device sessions refreshed')"><span>Refresh device sessions</span><i data-lucide="chevron-right"></i></button>
                    </div>
                </section>
                <section class="info-card">
                    <h3>Security Summary</h3>
                    <div class="info-table">
                        <div class="info-row"><span class="info-label">Last Password Change</span><span class="info-value">May 10, 2026</span></div>
                        <div class="info-row"><span class="info-label">Known Devices</span><span class="info-value" x-text="security.knownDevices + ' Devices'"></span></div>
                        <div class="info-row"><span class="info-label">Login Risk</span><span class="status-pill status-active">Low</span></div>
                        <div class="info-row"><span class="info-label">2FA Status</span><span class="status-pill" :class="security.twoFactor ? 'status-active' : 'status-inactive'" x-text="security.twoFactor ? 'Enabled' : 'Disabled'"></span></div>
                        <div class="info-row"><span class="info-label">Alerts</span><span class="status-pill" :class="security.loginAlerts ? 'status-active' : 'status-inactive'" x-text="security.loginAlerts ? 'On' : 'Off'"></span></div>
                    </div>
                </section>
            </div>
        </article>
    </section>

    <div class="modal-backdrop" x-show="userModal.open" x-transition style="display:none">
        <div class="modal-panel" @click.stop>
            <div class="modal-header">
                <h3 x-text="userModal.mode === 'add' ? 'Add New User' : 'Edit User'"></h3>
                <button type="button" class="close-x" @click="userModal.open=false"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <div class="modal-grid">
                    <div class="modal-field"><label>Full Name</label><input x-model="userModal.form.name"></div>
                    <div class="modal-field"><label>Email</label><input x-model="userModal.form.email"></div>
                    <div class="modal-field"><label>Phone</label><input x-model="userModal.form.phone"></div>
                    <div class="modal-field"><label>Company</label><input x-model="userModal.form.company"></div>
                    <div class="modal-field"><label>Role</label><select x-model="userModal.form.role"><option>Product Admin</option><option>Customer Support</option><option>Print Staff</option><option>Manager</option></select></div>
                    <div class="modal-field"><label>Status</label><select x-model="userModal.form.status"><option value="ACTIVE">Active</option><option value="INACTIVE">Inactive</option><option value="INVITED">Invited</option><option value="SUSPENDED">Suspended</option></select></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="customer-btn customer-btn-outline" @click="userModal.open=false">Cancel</button>
                <button type="button" class="customer-btn customer-btn-primary" @click="saveUser()">Save User</button>
            </div>
        </div>
    </div>

    <div class="modal-backdrop" x-show="orderModal.open" x-transition style="display:none">
        <div class="modal-panel" @click.stop>
            <div class="modal-header">
                <h3>Order Details <span style="color:#667085;font-family:Inter;font-size:14px;font-weight:700">• <span x-text="orderModal.orderId"></span></span></h3>
                <button type="button" class="close-x" @click="orderModal.open=false"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <div class="template-notice">Order details template only. Fields are ready for backend connection and can be filled with live order records later.</div>
                <div class="template-cards">
                    <section class="template-card"><h4>Customer Information</h4><div class="template-row"><span class="template-label">Order ID</span><span class="template-value" x-text="orderModal.orderId"></span></div><div class="template-row"><span class="template-label">Customer Name</span><span class="template-value">—</span></div><div class="template-row"><span class="template-label">Email Address</span><span class="template-value">—</span></div><div class="template-row"><span class="template-label">Contact Number</span><span class="template-value">—</span></div></section>
                    <section class="template-card"><h4>Order Information</h4><div class="template-row"><span class="template-label">Service / Item</span><span class="template-value">—</span></div><div class="template-row"><span class="template-label">Order Date</span><span class="template-value">—</span></div><div class="template-row"><span class="template-label">Payment Status</span><span class="template-value">—</span></div><div class="template-row"><span class="template-label">Order Status</span><span class="template-value">—</span></div></section>
                    <section class="template-card"><h4>Fulfillment</h4><div class="template-row"><span class="template-label">Fulfillment Type</span><span class="template-value">—</span></div><div class="template-row"><span class="template-label">Delivery / Pickup Date</span><span class="template-value">—</span></div><div class="template-row"><span class="template-label">Tracking Number</span><span class="template-value">—</span></div><div class="template-row"><span class="template-label">Total Amount</span><span class="template-value">—</span></div></section>
                </div>
                <section class="template-items"><h4>Items Template</h4><table><thead><tr><th>Item</th><th>Description</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead><tbody><tr><td>—</td><td>—</td><td>—</td><td>—</td><td>—</td></tr><tr><td>—</td><td>—</td><td>—</td><td>—</td><td>—</td></tr></tbody></table></section>
            </div>
            <div class="modal-footer">
                <button type="button" class="customer-btn customer-btn-primary" @click="showToast('Template saved')">Save Template</button>
                <button type="button" class="customer-btn customer-btn-outline" @click="printModal()"><i data-lucide="printer"></i>Print</button>
            </div>
        </div>
    </div>
</div>

<script>
function customerManagementExactApp(){
    return {
        toast:{show:false,message:''},
        calendarOpen:false,
        selectedDate:'2026-05-14',
        calendarYear:2026,
        calendarMonth:4,
        weekDays:['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
        calendarDraft:{title:'',time:'09:00',note:''},
        calendarEvents:{
            '2026-05-14':[
                {title:'Customer records review',time:'09:00 AM',note:'Check new account updates and pending profile changes.'},
                {title:'Export customer list',time:'02:00 PM',note:'Prepare customer report for admin review.'}
            ],
            '2026-05-18':[
                {title:'Invite follow-up',time:'10:30 AM',note:'Send reminders to pending invited users.'}
            ],
            '2026-05-22':[
                {title:'Role audit',time:'03:00 PM',note:'Review roles and permissions for active admin users.'}
            ]
        },
        searchQuery:'',
        statusFilter:'',
        page:1,
        perPage:10,
        activeTab:'overview',
        activityFilter:'',
        roleDraft:'Product Admin',
        selectedUser:null,
        permissions:[
            {key:'orders',label:'Manage Orders',desc:'View, create, edit and complete orders',enabled:true},
            {key:'products',label:'Manage Products',desc:'Update products, prices and stock status',enabled:true},
            {key:'customers',label:'Manage Customers',desc:'Edit users and customer account details',enabled:true},
            {key:'reports',label:'View Reports',desc:'Open analytics and export report data',enabled:true},
            {key:'settings',label:'System Settings',desc:'Access admin configuration screens',enabled:false}
        ],
        security:{twoFactor:true,loginAlerts:true,forceReset:false,blockSuspicious:true,knownDevices:3},
        filterOrder:['','ACTIVE','INVITED','SUSPENDED','INACTIVE'],
        userModal:{open:false,mode:'add',form:{id:null,name:'',email:'',phone:'',company:'',role:'Product Admin',status:'ACTIVE'}},
        orderModal:{open:false,orderId:'ORD-1024'},
        users:[
            {id:'CUST-1024',name:'Ethan Carter',email:'ethan.carter@example.com',phone:'+1 (555) 123-4567',company:'Carter Designs',status:'ACTIVE',role:'Product Admin',roleShort:'Admin',scope:'All Access',permissions:'23 of 23',joined:'Apr 15, 2024 (1 year ago)',since:'Apr 15, 2024 02:15 PM',lastLogin:'May 18, 2025 10:30 AM',photo:'https://i.pravatar.cc/120?img=12',orders:[{id:'ORD-1024',item:'Document Printing',date:'Jun 6, 2026',status:'Completed',total:'PHP 350.00'},{id:'ORD-1029',item:'Document Scanning',date:'Jun 4, 2026',status:'Shipped',total:'PHP 650.00'}]},
            {id:'CUST-1025',name:'Sophia Lee',email:'sophia.lee@example.com',phone:'+1 (555) 234-5678',company:'Lee Studio',status:'ACTIVE',role:'Customer Support',roleShort:'Support',scope:'Customer Access',permissions:'16 of 23',joined:'Mar 10, 2024',since:'Mar 10, 2024 08:40 AM',lastLogin:'Jun 5, 2026 09:11 AM',photo:'https://i.pravatar.cc/120?img=47',orders:[{id:'ORD-1030',item:'2x2 ID Photo Package',date:'Jun 4, 2026',status:'Ready',total:'PHP 180.00'}]},
            {id:'CUST-1026',name:'Liam Johnson',email:'liam.johnson@example.com',phone:'+1 (555) 345-6789',company:'Johnson Prints',status:'ACTIVE',role:'Manager',roleShort:'Manager',scope:'Branch Access',permissions:'20 of 23',joined:'Feb 2, 2024',since:'Feb 2, 2024 11:25 AM',lastLogin:'Jun 6, 2026 01:45 PM',photo:'https://i.pravatar.cc/120?img=33',orders:[{id:'ORD-1026',item:'Tarpaulin Print',date:'Jun 5, 2026',status:'Pending',total:'PHP 1,800.00'}]},
            {id:'CUST-1027',name:'Olivia Martinez',email:'olivia.martinez@example.com',phone:'+1 (555) 456-7890',company:'OM Creatives',status:'ACTIVE',role:'Print Staff',roleShort:'Staff',scope:'Orders Only',permissions:'12 of 23',joined:'Jan 18, 2024',since:'Jan 18, 2024 03:05 PM',lastLogin:'Jun 1, 2026 07:32 AM',photo:'https://i.pravatar.cc/120?img=44',orders:[{id:'ORD-1028',item:'Laminating & Binding',date:'Jun 5, 2026',status:'Cancelled',total:'PHP 480.00'}]},
            {id:'CUST-1028',name:'Noah Wilson',email:'noah.wilson@example.com',phone:'+1 (555) 567-8901',company:'Wilson Co.',status:'INACTIVE',role:'Customer User',roleShort:'User',scope:'Self Account',permissions:'5 of 23',joined:'Dec 7, 2023',since:'Dec 7, 2023 06:20 PM',lastLogin:'May 1, 2026 04:21 PM',photo:'https://i.pravatar.cc/120?img=16',orders:[{id:'ORD-1025',item:'Passport Photo Package',date:'Jun 6, 2026',status:'Processing',total:'PHP 900.00'}]},
            {id:'CUST-1029',name:'Ava Anderson',email:'ava.anderson@example.com',phone:'+1 (555) 678-9012',company:'Ava Brands',status:'ACTIVE',role:'Product Admin',roleShort:'Admin',scope:'All Access',permissions:'23 of 23',joined:'Nov 11, 2023',since:'Nov 11, 2023 01:10 PM',lastLogin:'Jun 3, 2026 11:00 AM',photo:'https://i.pravatar.cc/120?img=49',orders:[{id:'ORD-1031',item:'Custom Mug Print',date:'Jun 3, 2026',status:'Processing',total:'PHP 1,250.00'}]},
            {id:'CUST-1030',name:'Mason Taylor',email:'mason.taylor@example.com',phone:'+1 (555) 789-0123',company:'Taylor Goods',status:'ACTIVE',role:'Customer Support',roleShort:'Support',scope:'Customer Access',permissions:'16 of 23',joined:'Oct 8, 2023',since:'Oct 8, 2023 12:35 PM',lastLogin:'Jun 2, 2026 02:30 PM',photo:'https://i.pravatar.cc/120?img=18',orders:[{id:'ORD-1032',item:'Photo Copy Bundle',date:'Jun 2, 2026',status:'Completed',total:'PHP 220.00'}]},
            {id:'CUST-1031',name:'Isabella Thomas',email:'isabella.thomas@example.com',phone:'+1 (555) 890-1234',company:'Thomas Print',status:'SUSPENDED',role:'Customer User',roleShort:'User',scope:'No Access',permissions:'0 of 23',joined:'Sep 3, 2023',since:'Sep 3, 2023 05:20 PM',lastLogin:'Apr 9, 2026 08:45 PM',photo:'https://i.pravatar.cc/120?img=45',orders:[{id:'ORD-1033',item:'Custom Special Printing',date:'May 30, 2026',status:'Hold',total:'PHP 150.00'}]},
            {id:'CUST-1032',name:'Lucas Brown',email:'lucas.brown@example.com',phone:'+1 (555) 901-2345',company:'Brown Media',status:'INVITED',role:'Print Staff',roleShort:'Staff',scope:'Pending Access',permissions:'0 of 23',joined:'Jun 1, 2026',since:'Jun 1, 2026 10:00 AM',lastLogin:'Not yet logged in',photo:'https://i.pravatar.cc/120?img=11',orders:[]},
            {id:'CUST-1033',name:'Mia Garcia',email:'mia.garcia@example.com',phone:'+1 (555) 012-3456',company:'Garcia Studio',status:'ACTIVE',role:'Manager',roleShort:'Manager',scope:'Branch Access',permissions:'20 of 23',joined:'Aug 22, 2023',since:'Aug 22, 2023 09:20 AM',lastLogin:'Jun 5, 2026 03:10 PM',photo:'https://i.pravatar.cc/120?img=32',orders:[{id:'ORD-1034',item:'Full Color Print',date:'May 29, 2026',status:'Completed',total:'PHP 10.00'}]},
            {id:'CUST-1034',name:'James Miller',email:'james.miller@example.com',phone:'+1 (555) 111-2222',company:'Miller Logistics',status:'ACTIVE',role:'Customer User',roleShort:'User',scope:'Self Account',permissions:'5 of 23',joined:'Jul 13, 2023',since:'Jul 13, 2023 11:20 AM',lastLogin:'Jun 4, 2026 06:15 PM',photo:'https://i.pravatar.cc/120?img=52',orders:[]},
            {id:'CUST-1035',name:'Amelia Davis',email:'amelia.davis@example.com',phone:'+1 (555) 222-3333',company:'Davis Events',status:'ACTIVE',role:'Customer User',roleShort:'User',scope:'Self Account',permissions:'5 of 23',joined:'Jun 9, 2023',since:'Jun 9, 2023 01:30 PM',lastLogin:'Jun 4, 2026 11:18 AM',photo:'https://i.pravatar.cc/120?img=5',orders:[]}
        ],
        init(){
            this.users = this.users.map(u => ({...u, activities:this.baseActivities(), fullActivity:this.fullActivities()}));
            this.selectedUser = this.users[0];
            this.roleDraft = this.selectedUser.role;
            this.refreshIcons();
        },

        get selectedDateLabel(){
            return this.formatDateLabel(this.selectedDate);
        },
        get calendarMonthTitle(){
            return new Date(this.calendarYear,this.calendarMonth,1).toLocaleDateString('en-US',{month:'long',year:'numeric'});
        },
        get selectedDateEvents(){
            return this.calendarEvents[this.selectedDate] || [];
        },
        get calendarDays(){
            const days=[];
            const first=new Date(this.calendarYear,this.calendarMonth,1);
            const start=new Date(first);
            start.setDate(first.getDate()-first.getDay());
            const todayIso=this.toIso(new Date());
            for(let i=0;i<42;i++){
                const date=new Date(start);
                date.setDate(start.getDate()+i);
                const iso=this.toIso(date);
                days.push({
                    key:iso+'-'+i,
                    iso,
                    date:date.getDate(),
                    currentMonth:date.getMonth()===this.calendarMonth,
                    isToday:iso===todayIso,
                    events:this.calendarEvents[iso] || []
                });
            }
            return days;
        },
        get filteredUsers(){
            const q=this.searchQuery.trim().toLowerCase();
            return this.users.filter(u=>{
                const matchesStatus = !this.statusFilter || u.status===this.statusFilter;
                const matchesSearch = !q || [u.name,u.email,u.company,u.role,u.id].join(' ').toLowerCase().includes(q);
                return matchesStatus && matchesSearch;
            });
        },
        get totalPages(){return Math.max(1,Math.ceil(this.filteredUsers.length/this.perPage));},
        get pagedUsers(){
            if(this.page>this.totalPages) this.page=this.totalPages;
            const start=(this.page-1)*this.perPage;
            return this.filteredUsers.slice(start,start+this.perPage);
        },
        get rangeStart(){return this.filteredUsers.length ? ((this.page-1)*this.perPage)+1 : 0;},
        get rangeEnd(){return Math.min(this.page*this.perPage,this.filteredUsers.length);},
        get enabledPermissionCount(){return this.permissions.filter(p=>p.enabled).length;},
        get accessLevelLabel(){return this.enabledPermissionCount>=4?'Full Dashboard Access':(this.enabledPermissionCount>=2?'Limited Dashboard Access':'Restricted Access');},
        get visibleActivities(){
            if(!this.selectedUser) return [];
            if(!this.activityFilter) return this.selectedUser.fullActivity;
            return this.selectedUser.fullActivity.filter(a => (a.title+' '+a.desc).toLowerCase().includes(this.activityFilter.toLowerCase()));
        },
        selectUser(user){this.selectedUser=user;this.roleDraft=user.role;this.activeTab='overview';this.activityFilter='';this.showToast(user.name+' selected');this.refreshIcons();},
        setFilter(status){this.statusFilter=status;this.page=1;this.showToast(status ? 'Showing '+this.statusLabel(status)+' users' : 'Showing all users');},
        cycleFilter(){
            const i=this.filterOrder.indexOf(this.statusFilter);
            this.statusFilter=this.filterOrder[(i+1)%this.filterOrder.length];
            this.page=1;this.showToast(this.statusFilter ? 'Filter: '+this.statusLabel(this.statusFilter) : 'Filter cleared');
        },
        nextPage(){this.page=this.page>=this.totalPages?1:this.page+1;this.refreshIcons();},
        initials(name){return name.split(' ').map(n=>n[0]).slice(0,2).join('').toUpperCase();},
        statusLabel(status){return {ACTIVE:'Active',INACTIVE:'Inactive',SUSPENDED:'Suspended',INVITED:'Invited'}[status] || status;},
        statusClass(status){return {ACTIVE:'status-active',INACTIVE:'status-inactive',SUSPENDED:'status-suspended',INVITED:'status-invited'}[status] || 'status-inactive';},
        baseActivities(){return [
            {icon:'log-in',title:'Logged in',desc:'Web Browser',time:'2 minutes ago'},
            {icon:'pencil',title:'Updated profile',desc:'Name, email, phone',time:'1 day ago'},
            {icon:'users-round',title:'Changed role',desc:'From Editor to Admin',time:'3 days ago'},
            {icon:'file-text',title:'Order created',desc:'#ORD-301982',time:'5 days ago'}
        ];},
        fullActivities(){return [
            {icon:'log-in',title:'Logged in',desc:'Chrome on Windows',time:'2 minutes ago'},
            {icon:'pencil',title:'Updated profile',desc:'Profile fields updated',time:'1 day ago'},
            {icon:'users-round',title:'Changed role',desc:'Role permission changed',time:'3 days ago'},
            {icon:'file-text',title:'Order created',desc:'Created order #ORD-301982',time:'5 days ago'},
            {icon:'mail',title:'Email verified',desc:'User verified account email',time:'1 week ago'},
            {icon:'shield-check',title:'Security check passed',desc:'Login risk remained low',time:'2 weeks ago'}
        ];},
        openAddModal(){this.userModal={open:true,mode:'add',form:{id:null,name:'',email:'',phone:'',company:'',role:'Product Admin',status:'ACTIVE'}};this.refreshIcons();},
        openEditModal(user){this.userModal={open:true,mode:'edit',form:{...user}};this.refreshIcons();},
        saveUser(){
            if(!this.userModal.form.name || !this.userModal.form.email){this.showToast('Please complete name and email');return;}
            if(this.userModal.mode==='add'){
                const newUser={...this.userModal.form,id:'CUST-'+(1100+this.users.length),roleShort:this.shortRole(this.userModal.form.role),scope:'All Access',permissions:'23 of 23',joined:'Jun 7, 2026',since:'Jun 7, 2026 09:00 AM',lastLogin:'Not yet logged in',photo:'',orders:[],activities:this.baseActivities(),fullActivity:this.fullActivities()};
                this.users.unshift(newUser);this.selectedUser=newUser;this.showToast('New user added');
            }else{
                const index=this.users.findIndex(u=>u.id===this.userModal.form.id);
                if(index>-1){this.users[index]={...this.users[index],...this.userModal.form,roleShort:this.shortRole(this.userModal.form.role)};this.selectedUser=this.users[index];this.showToast('User updated');}
            }
            this.userModal.open=false;this.refreshIcons();
        },
        shortRole(role){return role.includes('Admin')?'Admin':role.includes('Support')?'Support':role.includes('Manager')?'Manager':role.includes('User')?'User':'Staff';},
        applyRole(){
            if(!this.selectedUser) return;
            this.selectedUser.role=this.roleDraft;
            this.selectedUser.roleShort=this.shortRole(this.roleDraft);
            this.selectedUser.scope=this.roleDraft.includes('Admin')?'All Access':this.roleDraft.includes('Manager')?'Branch Access':this.roleDraft.includes('Support')?'Customer Access':this.roleDraft.includes('User')?'Self Account':'Orders Only';
            this.selectedUser.permissions=this.enabledPermissionCount + ' of ' + this.permissions.length;
            this.showToast('Role saved for '+this.selectedUser.name);
            this.refreshIcons();
        },
        togglePermission(key){
            const p=this.permissions.find(item=>item.key===key);
            if(p){p.enabled=!p.enabled; if(this.selectedUser){this.selectedUser.permissions=this.enabledPermissionCount + ' of ' + this.permissions.length;} this.showToast(p.label+' '+(p.enabled?'enabled':'disabled'));}
        },

        openCalendar(){
            const current=new Date(this.selectedDate+'T00:00:00');
            this.calendarYear=current.getFullYear();
            this.calendarMonth=current.getMonth();
            this.calendarOpen=true;
            this.refreshIcons();
        },
        selectCalendarDate(day){
            if(!day.currentMonth){
                const date=new Date(day.iso+'T00:00:00');
                this.calendarYear=date.getFullYear();
                this.calendarMonth=date.getMonth();
            }
            this.selectedDate=day.iso;
            this.refreshIcons();
        },
        prevCalendarMonth(){
            if(this.calendarMonth===0){this.calendarMonth=11;this.calendarYear--;}else{this.calendarMonth--;}
            this.refreshIcons();
        },
        nextCalendarMonth(){
            if(this.calendarMonth===11){this.calendarMonth=0;this.calendarYear++;}else{this.calendarMonth++;}
            this.refreshIcons();
        },
        goToday(){
            const today=new Date();
            this.selectedDate=this.toIso(today);
            this.calendarYear=today.getFullYear();
            this.calendarMonth=today.getMonth();
            this.refreshIcons();
        },
        saveCalendarTask(){
            if(!this.calendarDraft.title.trim()){
                this.showToast('Please add a task title');
                return;
            }
            const timeLabel=this.calendarDraft.time ? this.formatTimeLabel(this.calendarDraft.time) : 'All day';
            const newTask={
                title:this.calendarDraft.title.trim(),
                time:timeLabel,
                note:this.calendarDraft.note.trim() || 'No additional notes.'
            };
            if(!this.calendarEvents[this.selectedDate]) this.calendarEvents[this.selectedDate]=[];
            this.calendarEvents[this.selectedDate].push(newTask);
            this.clearCalendarDraft(false);
            this.showToast('Calendar task saved');
            this.refreshIcons();
        },
        clearCalendarDraft(showMessage=true){
            this.calendarDraft={title:'',time:'09:00',note:''};
            if(showMessage) this.showToast('Calendar form cleared');
        },
        toIso(date){
            const y=date.getFullYear();
            const m=String(date.getMonth()+1).padStart(2,'0');
            const d=String(date.getDate()).padStart(2,'0');
            return `${y}-${m}-${d}`;
        },
        formatDateLabel(iso){
            return new Date(iso+'T00:00:00').toLocaleDateString('en-US',{month:'long',day:'2-digit',year:'numeric'});
        },
        formatTimeLabel(value){
            const [hour,minute]=value.split(':').map(Number);
            const suffix=hour>=12?'PM':'AM';
            const displayHour=((hour+11)%12)+1;
            return `${displayHour}:${String(minute).padStart(2,'0')} ${suffix}`;
        },
        clearActivityFilter(){this.activityFilter='';this.showToast('Activity filter cleared');},
        toggleSecurity(key){this.security[key]=!this.security[key];this.showToast('Security setting updated');},
        resetPassword(){this.showToast('Password reset link sent to '+this.selectedUser.email);},
        sendInvite(){this.showToast('Invite sent to '+this.selectedUser.email);},
        suspendSelected(){this.selectedUser.status='SUSPENDED';this.showToast('Account suspended');this.refreshIcons();},
        deleteSelected(){
            const idx=this.users.findIndex(u=>u.id===this.selectedUser.id);
            if(idx>-1){const name=this.selectedUser.name;this.users.splice(idx,1);this.selectedUser=this.users[0]||null;this.showToast(name+' deleted');}
            this.refreshIcons();
        },
        openOrderTemplate(orderId){this.orderModal.orderId=orderId;this.orderModal.open=true;this.refreshIcons();},
        printModal(){window.print();this.showToast('Print dialog opened');},
        exportCustomers(){
            const rows=[['Customer ID','Name','Email','Phone','Company','Role','Status'],...this.filteredUsers.map(u=>[u.id,u.name,u.email,u.phone,u.company,u.role,this.statusLabel(u.status)])];
            const csv=rows.map(r=>r.map(v=>'"'+String(v).replaceAll('"','""')+'"').join(',')).join('\n');
            const blob=new Blob([csv],{type:'text/csv'});
            const url=URL.createObjectURL(blob);
            const a=document.createElement('a');a.href=url;a.download='customers_export.csv';a.click();URL.revokeObjectURL(url);
            this.showToast('Customers exported');
        },
        showToast(message){this.toast.message=message;this.toast.show=true;clearTimeout(this.toastTimer);this.toastTimer=setTimeout(()=>this.toast.show=false,2200);},
        refreshIcons(){this.$nextTick(()=>{if(window.lucide){window.lucide.createIcons();}});}
    }
}
</script>
