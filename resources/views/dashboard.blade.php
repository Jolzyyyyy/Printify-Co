<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700&display=swap');
:root{
    --dash-bg:#ffffff;
    --dash-page:#fbfbfb;
    --dash-card:#ffffff;
    --dash-ink:#111827;
    --dash-muted:#6b7280;
    --dash-soft:#f7f7f8;
    --dash-line:#eceff3;
    --dash-line-strong:#e2e5ea;
    --dash-orange:#ff7a00;
    --dash-orange-dark:#e86f00;
    --dash-orange-soft:#fff3e6;
    --dash-blue:#2563eb;
    --dash-blue-soft:#eaf2ff;
    --dash-green:#16a34a;
    --dash-green-soft:#eaf8ef;
    --dash-yellow:#f59e0b;
    --dash-yellow-soft:#fff7df;
    --dash-red:#ef4444;
    --dash-red-soft:#fff0f0;
    --dash-purple:#7c3aed;
    --dash-purple-soft:#f2ebff;
    --dash-shadow:0 12px 30px rgba(15,23,42,.07);
    --dash-shadow-hover:0 18px 42px rgba(15,23,42,.11);
    --dash-radius:14px;
    --dash-font:'Inter',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;--dash-header-font:'Playfair Display',Georgia,serif;--dash-title-font:'Poppins',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
}
*{box-sizing:border-box}
.customer-dashboard-v2{min-height:calc(100vh - 70px);padding:0px 0px 34px;background:var(--dash-bg);color:var(--dash-ink);font-family:var(--dash-font);font-weight:400;overflow-x:hidden;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;text-rendering:optimizeLegibility}
.customer-dashboard-v2 a{text-decoration:none;color:inherit}
.dashboard-shell{max-width:1490px;margin:0 auto}
.dashboard-loader{position:fixed;inset:0;z-index:9999;display:grid;place-items:center;background:rgba(255,255,255,.92);backdrop-filter:blur(12px);transition:opacity .28s ease,visibility .28s ease}
.dashboard-loader.is-hidden{opacity:0;visibility:hidden;pointer-events:none}
.loader-card{width:210px;padding:18px;text-align:center;border:1px solid var(--dash-line);border-radius:18px;background:#fff;box-shadow:var(--dash-shadow)}
.loader-ring{width:42px;height:42px;margin:0 auto 12px;border:3px solid var(--dash-orange-soft);border-top-color:var(--dash-orange);border-radius:999px;animation:spin .85s linear infinite}
.loader-text{font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--dash-muted)}
@keyframes spin{to{transform:rotate(360deg)}}
@keyframes revealUp{to{opacity:1;transform:none}}
@keyframes donutIn{to{stroke-dasharray:var(--dash-slice) var(--dash-gap)}}
@keyframes growX{to{width:var(--bar-width)}}
@keyframes growY{to{height:var(--bar-height)}}
.reveal-card{opacity:0;transform:translateY(14px);animation:revealUp .56s cubic-bezier(.2,.8,.2,1) forwards;animation-delay:var(--delay,0ms)}
.dashboard-header-row{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin:0 0 16px}
.overview-title-wrap{display:flex;align-items:flex-start;gap:10px}
.overview-title-wrap::before{content:'';width:18px;height:4px;margin-top:8px;border-radius:999px;background:var(--dash-orange);box-shadow:0 0 0 3px rgba(255,122,0,.08)}
.overview-kicker{margin:0 0 3px;font-family:var(--dash-header-font);font-size:40px;font-weight:700;line-height:1.2;color:#111827;letter-spacing:-.02em}
.overview-copy{margin:0;font-size:12px;line-height:1.45;color:var(--dash-muted)}
.header-actions{display:flex;align-items:center;justify-content:flex-end;gap:10px;flex-wrap:wrap}
.date-pill,.primary-button,.light-button,.tiny-button,.view-button,.clear-filter-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;height:42px;border-radius:10px;font-size:12px;font-weight:700;line-height:1;white-space:nowrap;transition:background .18s ease,border-color .18s ease,color .18s ease,box-shadow .18s ease,transform .18s ease}
.date-pill{min-width:178px;padding:0 15px;background:#fff;border:1px solid var(--dash-line);box-shadow:0 6px 16px rgba(15,23,42,.04);color:#111827;font-weight:700}
.date-pill.calendar-toggle{cursor:pointer;font-family:var(--dash-font)}
.date-pill.calendar-toggle:focus{outline:2px solid rgba(255,122,0,.28);outline-offset:3px}
.dashboard-calendar-overlay{position:fixed;inset:0;z-index:9998;display:flex;align-items:center;justify-content:center;padding:18px;background:rgba(17,24,39,.36);backdrop-filter:blur(9px);opacity:0;visibility:hidden;pointer-events:none;transition:opacity .2s ease,visibility .2s ease}
.dashboard-calendar-overlay.is-open{opacity:1;visibility:visible;pointer-events:auto}
.dashboard-calendar-modal{width:min(920px,100%);max-height:calc(100vh - 36px);overflow:hidden;border:1px solid var(--dash-line);border-radius:18px;background:#fff;box-shadow:0 26px 80px rgba(15,23,42,.22);display:grid;grid-template-columns:minmax(0,1.1fr) 310px}
.calendar-main{padding:18px;border-right:1px solid var(--dash-line);min-width:0}
.calendar-side{padding:18px;background:#fbfbfb;min-width:0}
.calendar-top{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}
.calendar-title{margin:0;font-family:var(--dash-title-font);font-size:16px;font-weight:700;color:#111827;letter-spacing:.01em}
.calendar-subtitle{margin:3px 0 0;font-size:11px;font-weight:400;color:var(--dash-muted);line-height:1.45}
.calendar-nav{display:flex;align-items:center;gap:7px}
.calendar-icon-btn,.calendar-action-btn{height:34px;border:1px solid var(--dash-line);border-radius:9px;background:#fff;color:#111827;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;gap:6px;cursor:pointer;transition:.18s}
.calendar-icon-btn{width:34px;padding:0}
.calendar-action-btn{padding:0 12px}
.calendar-icon-btn:hover,.calendar-action-btn:hover,.calendar-icon-btn:focus,.calendar-action-btn:focus{background:#111827;border-color:#111827;color:#fff}
.calendar-weekdays,.calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:7px}
.calendar-weekdays{margin-bottom:7px}
.calendar-weekdays span{text-align:center;font-size:9.5px;font-weight:800;color:#6b7280;letter-spacing:.08em;text-transform:uppercase}
.calendar-day{position:relative;min-height:78px;border:1px solid var(--dash-line);border-radius:12px;background:#fff;padding:8px;text-align:left;color:#111827;cursor:pointer;transition:.18s;overflow:hidden}
.calendar-day:hover,.calendar-day:focus{border-color:var(--dash-orange);box-shadow:0 10px 24px rgba(255,122,0,.10)}
.calendar-day.is-muted{background:#fafafa;color:#a1a1aa;cursor:default}
.calendar-day.is-today{border-color:var(--dash-orange);background:var(--dash-orange-soft)}
.calendar-day.is-selected{border-color:#111827;background:rgba(17,24,39,.08);box-shadow:inset 0 0 0 1px #111827}
.calendar-day-number{display:block;font-size:12px;font-weight:800;line-height:1}
.calendar-day-events{display:flex;flex-wrap:wrap;gap:4px;margin-top:17px}
.calendar-event-dot{width:7px;height:7px;border-radius:999px;background:var(--dash-orange);box-shadow:0 0 0 3px rgba(255,122,0,.10)}
.calendar-more{font-size:9px;font-weight:700;color:var(--dash-muted);line-height:1}
.calendar-selected-date{margin:0 0 12px;font-family:var(--dash-title-font);font-size:15px;font-weight:700;color:#111827}
.calendar-event-list{display:grid;gap:8px;max-height:182px;overflow:auto;padding-right:2px;margin-bottom:13px}
.calendar-event-item{border:1px solid var(--dash-line);border-radius:12px;background:#fff;padding:10px;display:grid;gap:7px}
.calendar-event-title{font-size:12px;font-weight:800;color:#111827;line-height:1.3}
.calendar-event-meta{font-size:10px;font-weight:600;color:var(--dash-orange);line-height:1.35}
.calendar-event-note{font-size:10.5px;font-weight:400;color:var(--dash-muted);line-height:1.45}
.calendar-event-actions{display:flex;gap:6px;justify-content:flex-end}
.calendar-mini-btn{height:27px;padding:0 9px;border:1px solid var(--dash-line);border-radius:8px;background:#fff;color:#111827;font-size:9.5px;font-weight:800;cursor:pointer;transition:.18s}
.calendar-mini-btn:hover,.calendar-mini-btn:focus{background:#111827;border-color:#111827;color:#fff}
.calendar-mini-btn.danger{border-color:var(--dash-red-soft);color:var(--dash-red)}
.calendar-mini-btn.danger:hover,.calendar-mini-btn.danger:focus{background:var(--dash-red);border-color:var(--dash-red);color:#fff}
.calendar-form{display:grid;gap:9px}
.calendar-field{display:grid;gap:5px}
.calendar-field label{font-size:10px;font-weight:800;color:#4b5563;letter-spacing:.05em;text-transform:uppercase}
.calendar-field input,.calendar-field textarea{width:100%;border:1px solid var(--dash-line);border-radius:10px;background:#fff;padding:10px 11px;color:#111827;font-family:var(--dash-font);font-size:12px;font-weight:500;outline:none;transition:.18s}
.calendar-field textarea{min-height:68px;resize:vertical}
.calendar-field input:focus,.calendar-field textarea:focus{border-color:var(--dash-orange);box-shadow:0 0 0 3px rgba(255,122,0,.10)}
.calendar-form-actions{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:2px}
.calendar-save-btn,.calendar-clear-btn{height:36px;border-radius:9px;font-size:11px;font-weight:800;cursor:pointer;transition:.18s}
.calendar-save-btn{flex:1;border:1px solid var(--dash-orange);background:var(--dash-orange);color:#fff}
.calendar-clear-btn{width:82px;border:1px solid var(--dash-line);background:#fff;color:#111827}
.calendar-save-btn:hover,.calendar-save-btn:focus,.calendar-clear-btn:hover,.calendar-clear-btn:focus{background:#111827;border-color:#111827;color:#fff}
.calendar-empty{min-height:74px;border:1px dashed var(--dash-line-strong);border-radius:12px;display:grid;place-items:center;text-align:center;color:var(--dash-muted);font-size:11px;font-weight:500;line-height:1.45;padding:12px;background:#fff}
@media(max-width:820px){.dashboard-calendar-modal{grid-template-columns:1fr;overflow:auto}.calendar-main{border-right:0;border-bottom:1px solid var(--dash-line)}.calendar-day{min-height:62px}.calendar-side{background:#fff}}
.primary-button{min-width:132px;padding:0 17px;border:1px solid var(--dash-orange);background:var(--dash-orange);color:#fff;box-shadow:0 10px 18px rgba(255,122,0,.18);letter-spacing:.014em}
.primary-button:hover,.primary-button:focus{background:#111827 !important;border-color:#111827 !important;color:#fff !important;transform:none;box-shadow:0 12px 24px rgba(17,24,39,.20)}
.light-button{min-width:126px;padding:0 16px;border:1px solid var(--dash-orange);background:var(--dash-orange);color:#111827}
.light-button:hover,.light-button:focus{background:#111827;border-color:#111827;color:#fff}
.dashboard-board{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:18px;align-items:start}
.left-column,.right-column{display:grid;gap:18px;align-content:start}
.analytics-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}
.card{background:var(--dash-card);border:1px solid var(--dash-line);border-radius:var(--dash-radius);box-shadow:var(--dash-shadow);transition:background .18s ease,box-shadow .18s ease,border-color .18s ease,transform .18s ease}
.card:hover{background:rgba(17,24,39,.10);box-shadow:var(--dash-shadow-hover);transform:none}
.chart-card{min-height:198px;padding:18px 18px 15px;overflow:hidden;position:relative;border-color:#111827;background:linear-gradient(180deg,#fff 0%,var(--chart-soft,#fff) 100%);--chart-color:var(--dash-orange);--chart-soft:var(--dash-orange-soft)}
.chart-card:hover{background:rgba(17,24,39,.10);border-color:#111827;transform:none}.chart-card.is-active{background:rgba(17,24,39,.16);border-color:#111827;box-shadow:0 18px 42px rgba(17,24,39,.14);transform:none}
.card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:14px}
.card-title-group{min-width:0}
.card-title{margin:0;color:#111827;font-family:var(--dash-title-font);font-size:14.5px;font-weight:600;letter-spacing:.022em;line-height:1.35}
.card-subtitle{margin:4px 0 0;color:#4b5563;font-size:11px;font-weight:400;line-height:1.45}
.select-chip{height:28px;min-width:78px;padding:0 10px;border:1px solid var(--dash-orange);border-radius:7px;background:var(--dash-orange);color:#fff;font-size:10px;font-weight:700;cursor:pointer;transition:.18s}
.select-chip:hover,.select-chip:focus,.select-chip.is-active{border-color:#111827;background:#111827;color:#fff}
.status-chart-layout{display:grid;grid-template-columns:118px minmax(0,1fr);gap:16px;align-items:center}
.donut-wrap{width:116px;height:116px;display:grid;place-items:center;position:relative}
.donut-svg{width:116px;height:116px;transform:rotate(-90deg);overflow:visible}
.donut-base{fill:none;stroke:#f1f3f5;stroke-width:20}
.donut-slice{fill:none;stroke:var(--slice-color);stroke-width:20;stroke-dasharray:0 100.531;stroke-dashoffset:var(--slice-offset);cursor:pointer;transition:stroke-width .18s ease,filter .18s ease}
.reveal-card .donut-slice{animation:donutIn .9s cubic-bezier(.2,.8,.2,1) forwards;animation-delay:var(--slice-delay,0ms)}
.donut-slice:hover,.donut-slice.is-active{stroke-width:22;filter:brightness(.96)}
.donut-center{position:absolute;inset:50% auto auto 50%;width:60px;height:60px;display:grid;place-items:center;border-radius:999px;background:#fff;border:7px solid #f4f4f5;box-shadow:inset 0 0 0 1px #fff;transform:translate(-50%,-50%);text-align:center}
.donut-number{display:block;font-size:18px;font-weight:700;line-height:1;color:#111827;letter-spacing:-.04em}
.donut-label{display:block;margin-top:2px;font-size:8px;font-weight:600;color:var(--dash-muted);line-height:1.15}
.legend-list{display:grid;gap:7px}
.legend-button{display:grid;grid-template-columns:9px minmax(0,1fr) auto;align-items:center;gap:8px;width:100%;padding:0;border:0;background:transparent;color:#374151;font-size:10.8px;font-weight:600;letter-spacing:.018em;text-align:left;line-height:1.35;cursor:pointer;transition:color .18s ease,background .18s ease,transform .18s ease}
.legend-button:hover,.legend-button.is-active{background:rgba(17,24,39,.10);color:var(--legend-color);transform:none}
.legend-dot{width:9px;height:9px;border-radius:999px;background:var(--legend-color)}
.legend-name{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.legend-meta{color:var(--dash-muted);font-size:10px;font-weight:600;letter-spacing:.018em}
.payment-list{display:grid;gap:10px;margin-top:5px}
.payment-row{display:grid;grid-template-columns:70px minmax(0,1fr) 82px;align-items:center;gap:11px;width:100%;border:0;background:transparent;padding:0;text-align:left;cursor:pointer;border-radius:8px;transition:background .18s ease,color .18s ease}
.payment-label{font-size:10.8px;font-weight:600;letter-spacing:.018em;color:#374151;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;line-height:1.35}
.payment-track{height:8px;border-radius:999px;background:#f0f1f3;overflow:hidden}
.payment-fill{display:block;width:0;height:100%;border-radius:999px;background:var(--bar-color);animation:growX .82s cubic-bezier(.2,.8,.2,1) forwards;animation-delay:var(--bar-delay,0ms)}
.payment-value{font-size:10.2px;font-weight:700;letter-spacing:.016em;color:#111827;text-align:right;white-space:nowrap;line-height:1.35}
.payment-row:hover,.payment-row.is-active{background:rgba(17,24,39,.10)}.payment-row:active{background:rgba(17,24,39,.16)}.payment-row:hover .payment-fill,.payment-row.is-active .payment-fill{filter:brightness(.92);transform:none}
.payment-total{margin-top:11px;font-size:11px;font-weight:500;color:#4b5563;line-height:1.4}.payment-total strong{color:var(--dash-green);font-weight:700}
.revenue-chart{height:128px;display:grid;grid-template-columns:28px minmax(0,1fr);gap:8px;align-items:end}
.revenue-axis{height:112px;display:grid;grid-template-rows:repeat(5,1fr);align-items:start;color:#6b7280;font-size:9px;font-weight:600;letter-spacing:.018em;line-height:1.25}
.revenue-bars{height:120px;display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:11px;align-items:end;padding:0 4px;border-bottom:1px solid var(--dash-line);background:repeating-linear-gradient(to top,transparent 0,transparent 27px,rgba(17,24,39,.045) 28px)}
.revenue-bar-button{height:100%;display:grid;align-items:end;justify-items:center;gap:5px;border:0;background:transparent;padding:0;cursor:pointer;position:relative}
.bar-value{position:absolute;top:auto;bottom:calc(var(--bar-height) + 6px);font-size:9px;font-weight:700;color:#8a5a12;white-space:nowrap;opacity:0;transform:translateY(3px);transition:.18s}
.revenue-bar-button:hover .bar-value,.revenue-bar-button.is-active .bar-value{opacity:1;transform:none}
.revenue-fill{width:28px;height:0;border-radius:8px 8px 0 0;background:var(--bar-color);animation:growY .85s cubic-bezier(.2,.8,.2,1) forwards;animation-delay:var(--bar-delay,0ms);box-shadow:0 7px 14px rgba(15,23,42,.08)}
.revenue-bar-button:hover .revenue-fill,.revenue-bar-button.is-active .revenue-fill{filter:brightness(.94);transform:none}
.revenue-labels{display:grid;grid-template-columns:28px minmax(0,1fr);gap:8px;margin-top:8px}
.revenue-label-spacer{display:block}.month-labels{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:11px;color:#4b5563;font-size:9.7px;font-weight:600;letter-spacing:.018em;text-align:center;line-height:1.25}
.revenue-total{margin-top:10px;font-size:11px;font-weight:500;color:#4b5563;line-height:1.4}.revenue-total strong{color:var(--dash-green);font-weight:700}
.quick-actions-card{padding:18px}
.quick-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:13px 10px;margin-top:16px}
.quick-action{min-height:70px;display:grid;justify-items:center;gap:8px;color:#111827;text-align:center;border-radius:12px;transition:background .18s ease,color .18s ease,transform .18s ease}
.quick-action:hover,.quick-action:focus{background:rgba(17,24,39,.10);transform:none;color:var(--dash-orange)}.quick-action:active{background:rgba(17,24,39,.16);transform:none}
.quick-icon{width:44px;height:44px;display:grid;place-items:center;border-radius:999px;border:1px solid var(--dash-line);background:#fff;color:var(--quick-color);box-shadow:0 8px 18px rgba(15,23,42,.06);transition:.18s}
.quick-action:hover .quick-icon,.quick-action:focus .quick-icon{background:var(--quick-soft);border-color:var(--quick-color);box-shadow:0 10px 22px rgba(15,23,42,.1)}
.quick-label{font-size:10.2px;font-weight:700;line-height:1.25;letter-spacing:.018em}
.stats-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:18px}
.stat-card{min-height:106px;padding:17px 18px;display:grid;align-content:start;gap:8px;position:relative;overflow:hidden;background:var(--stat-soft);border-color:var(--stat-color);color:#111827}
.stat-card::after{content:'';position:absolute;inset:auto -18px -26px auto;width:88px;height:88px;border-radius:999px;background:var(--stat-color);opacity:.18}
.stat-card:hover{background:rgba(17,24,39,.10);transform:none;border-color:var(--stat-color)}.stat-card:active,.stat-card:focus,.stat-card.is-active{background:rgba(17,24,39,.16);border-color:var(--stat-color);color:#111827;transform:none}.stat-card:active .stat-icon,.stat-card:focus .stat-icon,.stat-card.is-active .stat-icon{background:#f9fafb;color:#111827}.stat-card:active .stat-title,.stat-card:active .stat-value,.stat-card:active .stat-note,.stat-card:active .stat-link,.stat-card:focus .stat-title,.stat-card:focus .stat-value,.stat-card:focus .stat-note,.stat-card:focus .stat-link,.stat-card.is-active .stat-title,.stat-card.is-active .stat-value,.stat-card.is-active .stat-note,.stat-card.is-active .stat-link{color:#111827}
.stat-top{display:flex;align-items:center;gap:10px}
.stat-icon{width:34px;height:34px;display:grid;place-items:center;border-radius:10px;background:var(--stat-soft);color:var(--stat-color)}
.stat-title{font-size:11px;font-weight:600;letter-spacing:.018em;color:#374151;line-height:1.35}.stat-value{font-size:24px;font-weight:700;line-height:1;color:var(--stat-color);letter-spacing:-.015em}.stat-note{font-size:10.5px;font-weight:400;line-height:1.45;color:#4b5563}
.stat-link{margin-top:2px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.035em;color:var(--stat-color)}
.content-grid{display:grid;grid-template-columns:minmax(0,1.02fr) minmax(0,1.08fr);gap:18px;align-items:start}
.latest-card,.recent-card,.account-card,.notification-card,.quick-actions-card{overflow:hidden;border-color:#111827}
.panel-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:17px 18px 0}
.view-all-link{display:inline-flex;align-items:center;gap:5px;border:0;background:transparent;color:#111827;font-size:10.5px;font-weight:700;white-space:nowrap;cursor:pointer;transition:.18s}
.view-all-link:hover,.view-all-link:focus{color:#111827;transform:none}
.latest-body{padding:15px 18px 18px;display:grid;grid-template-columns:92px minmax(0,1fr);gap:16px;align-items:start}
.latest-thumb{width:92px;height:110px;border-radius:12px;overflow:hidden;background:linear-gradient(135deg,#171717,#3d2f23);display:grid;place-items:center;color:#fff;box-shadow:0 14px 24px rgba(15,23,42,.14)}
.latest-thumb img{width:100%;height:100%;object-fit:cover}.latest-info{min-width:0}.latest-title{font-size:12px;font-weight:700;letter-spacing:.018em;color:#111827;line-height:1.35}.latest-meta{margin-top:3px;font-size:10.5px;font-weight:400;color:#4b5563;line-height:1.45}.tracking-line{position:relative;margin:17px 0 15px;height:2px;background:#dbeafe}
.tracking-line::before{content:'';position:absolute;left:0;top:0;height:100%;width:var(--progress-width);background:var(--dash-green)}
.timeline-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:7px;margin-bottom:15px}
.timeline-node{position:relative;text-align:center;color:#9ca3af}.timeline-dot{width:18px;height:18px;margin:0 auto 5px;display:grid;place-items:center;border-radius:999px;background:#fff;border:2px solid #cbd5e1;color:#cbd5e1}.timeline-node.done .timeline-dot{border-color:var(--dash-green);color:#fff;background:var(--dash-green)}.timeline-node.active .timeline-dot{border-color:var(--dash-blue);color:#fff;background:var(--dash-blue);box-shadow:0 0 0 4px rgba(37,99,235,.12)}.timeline-name{display:block;font-size:8.9px;font-weight:700;letter-spacing:.018em;line-height:1.25;color:#374151}.timeline-date{display:block;margin-top:2px;font-size:8px;font-weight:600;letter-spacing:.018em;color:#9ca3af}
.latest-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.tiny-button{height:34px;min-width:104px;padding:0 12px;border-radius:8px;border:1px solid var(--dash-orange);background:var(--dash-orange);color:#fff;font-size:10px}
.tiny-button:hover,.tiny-button:focus{background:#111827;border-color:#111827;color:#fff;transform:none}
.tiny-button.primary{background:var(--dash-orange);border-color:var(--dash-orange);color:#fff}.tiny-button.primary:hover{background:#111827;border-color:#111827;color:#fff;transform:none}
.recent-table-wrap{padding:12px 18px 18px;overflow-x:auto}
.orders-table{width:100%;border-collapse:separate;border-spacing:0;font-size:11px;color:#374151}
.orders-table thead th{height:34px;padding:0 10px;background:#fafafa;border-top:1px solid var(--dash-line);border-bottom:1px solid var(--dash-line);font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.035em;color:#4b5563;text-align:left;white-space:nowrap}.orders-table thead th:first-child{border-left:1px solid var(--dash-line);border-radius:9px 0 0 9px}.orders-table thead th:last-child{border-right:1px solid var(--dash-line);border-radius:0 9px 9px 0;text-align:center}
.orders-table tbody td{height:100px;padding:8px 10px;border-bottom:1px solid #f0f1f3;white-space:nowrap}.orders-table tbody tr{transition:background .18s ease}.orders-table tbody tr:hover{background:rgba(17,24,39,.10)}.orders-table tbody tr:active{background:rgba(17,24,39,.16)}.order-id{font-weight:700;letter-spacing:.016em;color:#111827}.product-name{max-width:150px;overflow:hidden;text-overflow:ellipsis}.amount-cell{font-weight:700;letter-spacing:.016em;color:#111827}.view-button{height:28px;min-width:54px;padding:0 10px;border:1px solid var(--dash-orange);border-radius:7px;background:var(--dash-orange);color:#fff;font-size:10px}.view-button:hover,.view-button:focus{border-color:#111827;background:#111827;color:#fff;transform:none}
.status-pill{display:inline-flex;align-items:center;justify-content:center;min-width:72px;height:24px;padding:0 10px;border-radius:999px;font-size:9.5px;font-weight:700;line-height:1.1}.status-pending{background:var(--dash-yellow-soft);color:#b7791f}.status-processing{background:var(--dash-purple-soft);color:var(--dash-purple)}.status-ready,.status-shipped{background:var(--dash-blue-soft);color:var(--dash-blue)}.status-delivered{background:var(--dash-green-soft);color:var(--dash-green)}.status-cancelled{background:var(--dash-red-soft);color:var(--dash-red)}.status-refunded{background:var(--dash-purple-soft);color:var(--dash-purple)}
.account-list,.notification-list{display:grid;gap:0;padding:10px 18px 18px}
.account-row,.notification-row{display:grid;grid-template-columns:34px minmax(0,1fr) auto;gap:10px;align-items:center;min-height:10px;padding:10px 0;border-bottom:1px solid #f0f1f3;border-radius:10px;transition:background .18s ease,transform .18s ease}.account-row:hover,.account-row:focus,.notification-row:hover{background:rgba(17,24,39,.10);transform:none}.account-row:active,.notification-row:active{background:rgba(17,24,39,.16);transform:none}.account-row:last-child,.notification-row:last-child{border-bottom:0}.row-icon{width:32px;height:32px;display:grid;place-items:center;border-radius:10px;background:var(--row-soft);color:var(--row-color)}.account-text{display:flex;align-items:baseline;gap:12px;min-width:0;white-space:nowrap}.row-title{display:inline-block;font-size:11px;font-weight:700;letter-spacing:.018em;color:#111827;line-height:1.3}.row-sub{display:inline-block;min-width:0;margin-top:0;font-size:10.2px;font-weight:400;color:#6b7280;line-height:1.35;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.row-chevron{color:#9ca3af}.edit-profile-button{height:36px;margin-top:8px;border-radius:8px;background:var(--dash-orange);color:#111827;font-size:11px;font-weight:700;letter-spacing:.018em;display:flex;align-items:center;justify-content:center;transition:.18s}.edit-profile-button:hover{background:#111827;color:#fff;transform:none}
.notification-row{grid-template-columns:34px minmax(0,1fr) 40px}.notification-time{font-size:9px;font-weight:600;letter-spacing:.018em;color:#9ca3af;text-align:right;white-space:nowrap}.empty-state{min-height:130px;display:grid;place-items:center;text-align:center;color:var(--dash-muted);padding:22px}.empty-state i{margin-bottom:8px}.empty-state .primary-button{height:36px;min-width:132px;padding:0 17px;border-radius:8px;background:var(--dash-orange);border-color:var(--dash-orange);color:#111827!important;font-size:11px;font-weight:700;letter-spacing:.018em;box-shadow:none}.empty-state .primary-button:hover,.empty-state .primary-button:focus,.empty-state .primary-button:active{background:#111827!important;border-color:#111827!important;color:#fff!important;box-shadow:none;transform:none}.empty-title{font-size:13px;font-weight:700;letter-spacing:.018em;color:#111827}.empty-text{font-size:11px;margin-top:4px}.is-hidden{display:none!important}.clear-filter-btn{height:28px;min-width:88px;padding:0 10px;border:1px solid var(--dash-orange);background:var(--dash-orange);color:#fff;font-size:10px;cursor:pointer}.clear-filter-btn:hover{background:#111827;border-color:#111827;color:#fff;transform:none}
.dashboard-feedback{position:fixed;top:88px;left:50%;z-index:99999;min-width:248px;height:38px;padding:0 16px;border:1px solid #111827;border-radius:10px;background:#111827;color:#fff;display:flex;align-items:center;justify-content:center;gap:9px;font-family:var(--dash-title-font);font-size:11px;font-weight:600;letter-spacing:0;box-shadow:0 16px 34px rgba(17,24,39,.18);opacity:0;pointer-events:none;transform:translate(-50%,-12px);transition:opacity .22s ease,transform .22s ease}.dashboard-feedback.is-visible{opacity:1;transform:translate(-50%,0)}.dashboard-feedback i,.dashboard-feedback svg{color:var(--dash-orange)}
.customer-dashboard-v2 .card{border:1px solid #111827;border-radius:8px;box-shadow:none;background:#fff;letter-spacing:0}.customer-dashboard-v2 .card:hover{background:#fff;box-shadow:none;transform:none}
.customer-dashboard-v2 .chart-card,.customer-dashboard-v2 .latest-card,.customer-dashboard-v2 .recent-card{border-color:#111827;background:#fff}.customer-dashboard-v2 .chart-card:hover,.customer-dashboard-v2 .chart-card.is-active{background:#fff;border-color:#111827;box-shadow:none}
.customer-dashboard-v2 .stat-card{border-color:var(--stat-color);background:var(--stat-soft);box-shadow:none}.customer-dashboard-v2 .stat-card:hover,.customer-dashboard-v2 .stat-card:focus,.customer-dashboard-v2 .stat-card:active,.customer-dashboard-v2 .stat-card.is-active{background:var(--stat-soft);border-color:var(--stat-color);box-shadow:none}
.customer-dashboard-v2 .right-column .quick-actions-card,.customer-dashboard-v2 .right-column .account-card,.customer-dashboard-v2 .right-column .notification-card{padding:0;border:0;border-radius:0;background:transparent;box-shadow:none;overflow:visible}
.customer-dashboard-v2 .right-column .quick-actions-card:hover,.customer-dashboard-v2 .right-column .account-card:hover,.customer-dashboard-v2 .right-column .notification-card:hover{background:transparent;box-shadow:none}
.customer-dashboard-v2 .quick-grid{margin-top:12px}.customer-dashboard-v2 .quick-action{border-radius:8px}.customer-dashboard-v2 .quick-action:hover,.customer-dashboard-v2 .quick-action:focus{background:#fff3e6;color:#111827}.customer-dashboard-v2 .quick-icon{box-shadow:none;border-color:#e5e7eb}
.customer-dashboard-v2 .account-list,.customer-dashboard-v2 .notification-list{padding:8px 0 0}.customer-dashboard-v2 .account-row,.customer-dashboard-v2 .notification-row{border-radius:8px;padding:10px 0}.customer-dashboard-v2 .account-row:hover,.customer-dashboard-v2 .notification-row:hover{background:#fff3e6}
.customer-dashboard-v2 .primary-button,.customer-dashboard-v2 .light-button,.customer-dashboard-v2 .tiny-button,.customer-dashboard-v2 .view-button,.customer-dashboard-v2 .clear-filter-btn,.customer-dashboard-v2 .select-chip,.customer-dashboard-v2 .calendar-save-btn,.customer-dashboard-v2 .edit-profile-button{border:0!important;box-shadow:none!important}.customer-dashboard-v2 .primary-button,.customer-dashboard-v2 .light-button,.customer-dashboard-v2 .tiny-button,.customer-dashboard-v2 .view-button,.customer-dashboard-v2 .clear-filter-btn,.customer-dashboard-v2 .select-chip,.customer-dashboard-v2 .calendar-save-btn,.customer-dashboard-v2 .edit-profile-button{background:var(--dash-orange);color:#111827}.customer-dashboard-v2 .primary-button:hover,.customer-dashboard-v2 .primary-button:focus,.customer-dashboard-v2 .light-button:hover,.customer-dashboard-v2 .light-button:focus,.customer-dashboard-v2 .tiny-button:hover,.customer-dashboard-v2 .tiny-button:focus,.customer-dashboard-v2 .view-button:hover,.customer-dashboard-v2 .view-button:focus,.customer-dashboard-v2 .clear-filter-btn:hover,.customer-dashboard-v2 .clear-filter-btn:focus,.customer-dashboard-v2 .select-chip:hover,.customer-dashboard-v2 .select-chip:focus,.customer-dashboard-v2 .select-chip.is-active,.customer-dashboard-v2 .calendar-save-btn:hover,.customer-dashboard-v2 .calendar-save-btn:focus,.customer-dashboard-v2 .edit-profile-button:hover{background:#111827!important;color:#fff!important}
.customer-dashboard-v2 .date-pill{border-color:#111827;box-shadow:none;border-radius:8px}.customer-dashboard-v2 .panel-head{padding:16px 18px 0}.customer-dashboard-v2 .right-column .panel-head{padding:0}.customer-dashboard-v2 .right-column .card-title{font-size:14px}.customer-dashboard-v2 .orders-table thead th{background:#fafafa;border-color:#e5e7eb}
@media(max-width:1320px){.dashboard-board{grid-template-columns:1fr}.right-column{grid-template-columns:repeat(3,minmax(0,1fr))}.quick-actions-card{grid-column:auto}.stats-grid{grid-template-columns:repeat(5,minmax(180px,1fr));overflow-x:auto;padding-bottom:2px}}
@media(max-width:1120px){.analytics-grid,.content-grid{grid-template-columns:1fr}.right-column{grid-template-columns:1fr}.chart-card{min-height:auto}.stats-grid{grid-template-columns:repeat(2,minmax(0,1fr));overflow:visible}.latest-body{grid-template-columns:1fr}.latest-thumb{width:100%;height:160px}}
@media(max-width:720px){.customer-dashboard-v2{padding:16px 12px 28px}.dashboard-header-row{display:grid}.header-actions{justify-content:stretch}.date-pill,.primary-button{width:100%}.analytics-grid,.stats-grid{grid-template-columns:1fr}.status-chart-layout{grid-template-columns:1fr;justify-items:center}.legend-list{width:100%}.quick-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.panel-head{align-items:flex-start;flex-direction:column}.timeline-grid{grid-template-columns:repeat(5,70px);overflow-x:auto;padding-bottom:4px}.orders-table{min-width:630px}}
.customer-dashboard-v2 .right-column{gap:18px!important}
.customer-dashboard-v2 .right-column>.card{border:0!important;border-radius:0!important;background:transparent!important;box-shadow:none!important;padding:0!important;overflow:visible!important}
.customer-dashboard-v2 .right-column>.card:hover{border:0!important;background:transparent!important;box-shadow:none!important}
.customer-dashboard-v2 .right-column .quick-actions-card,.customer-dashboard-v2 .right-column .account-card,.customer-dashboard-v2 .right-column .notification-card{border:0!important;border-radius:0!important;background:transparent!important;box-shadow:none!important;padding:0!important}
.customer-dashboard-v2 .right-column .panel-head{padding:0!important}
.customer-dashboard-v2 .right-column .account-list,.customer-dashboard-v2 .right-column .notification-list{padding:8px 0 0!important}
.customer-dashboard-v2 .right-column .account-row,.customer-dashboard-v2 .right-column .notification-row{border-bottom:1px solid #eef1f5!important;border-radius:0!important;padding:10px 0!important}
.customer-dashboard-v2 .right-column .account-row:hover,.customer-dashboard-v2 .right-column .notification-row:hover{background:#fff3e6!important;border-radius:8px!important;padding-left:8px!important;padding-right:8px!important}
.customer-dashboard-v2 .dashboard-board{align-items:stretch!important}
.customer-dashboard-v2 .left-column,.customer-dashboard-v2 .right-column{height:100%}
.customer-dashboard-v2 .stats-grid>.stat-card{border-color:var(--stat-color)!important;background:var(--stat-soft)!important;box-shadow:none!important}
.customer-dashboard-v2 .stats-grid>.stat-card:hover,.customer-dashboard-v2 .stats-grid>.stat-card:focus,.customer-dashboard-v2 .stats-grid>.stat-card.is-active{border-color:var(--stat-color)!important;background:var(--stat-soft)!important}
.customer-dashboard-v2 .content-grid{align-items:stretch!important}
.customer-dashboard-v2 .latest-card,.customer-dashboard-v2 .recent-card{height:100%!important;min-height:260px!important;display:flex!important;flex-direction:column!important}
.customer-dashboard-v2 .latest-body,.customer-dashboard-v2 .recent-table-wrap{flex:1!important}
.customer-dashboard-v2 .latest-card .empty-state,.customer-dashboard-v2 .recent-card .empty-state{min-height:170px!important}


/* =========================================================
   FINAL DASHBOARD CLEANUP OVERRIDES
   - Main content background set to white
   - Dashboard wrapper/outer box removed
   - Top 3 analytics borders softened only
   - Right panel width reduced
   - Edit Profile button centered and medium-sized
   - Right panel hover colors made light cream with no movement/layout shift
   ========================================================= */
body:has(.customer-dashboard-v2),
body:has(.customer-dashboard-v2) main,
body:has(.customer-dashboard-v2) .min-h-screen{
    background:#ffffff!important;
}
.customer-dashboard-v2,
.customer-dashboard-v2 .dashboard-shell,
.customer-dashboard-v2 .dashboard-board,
.customer-dashboard-v2 .left-column,
.customer-dashboard-v2 .right-column{
    background:#ffffff!important;
    border:0!important;
    box-shadow:none!important;
}
.customer-dashboard-v2 .dashboard-shell{
    padding:0!important;
    border-radius:0!important;
}
.customer-dashboard-v2 .dashboard-board{
    align-items:stretch!important;
}
@media(min-width:1321px){
    .customer-dashboard-v2 .dashboard-board{
        grid-template-columns:minmax(0,1fr) 280px!important;
        gap:18px!important;
    }
    .customer-dashboard-v2 .right-column{
        width:280px!important;
        max-width:280px!important;
        justify-self:end!important;
    }
}
.customer-dashboard-v2 .analytics-grid>.chart-card{
    border-color:#e7ebf0!important;
    border-width:1px!important;
    box-shadow:none!important;
}
.customer-dashboard-v2 .analytics-grid>.chart-card:hover,
.customer-dashboard-v2 .analytics-grid>.chart-card:focus-within,
.customer-dashboard-v2 .analytics-grid>.chart-card.is-active{
    border-color:#e7ebf0!important;
    background:#ffffff!important;
    box-shadow:none!important;
    transform:none!important;
}
.customer-dashboard-v2 .right-column .quick-actions-card,
.customer-dashboard-v2 .right-column .account-card,
.customer-dashboard-v2 .right-column .notification-card{
    width:100%!important;
    max-width:100%!important;
}
.customer-dashboard-v2 .quick-grid{
    grid-template-columns:repeat(3,minmax(0,1fr))!important;
    gap:10px 8px!important;
}
.customer-dashboard-v2 .quick-action{
    min-height:64px!important;
    border-radius:10px!important;
    padding:6px 4px!important;
    transition:background .18s ease,color .18s ease!important;
    transform:none!important;
}
.customer-dashboard-v2 .quick-action:hover,
.customer-dashboard-v2 .quick-action:focus,
.customer-dashboard-v2 .quick-action:active{
    background:rgba(255,248,239,.86)!important;
    color:#111827!important;
    transform:none!important;
    box-shadow:none!important;
    backdrop-filter:blur(3px);
}
.customer-dashboard-v2 .quick-icon{
    width:38px!important;
    height:38px!important;
    box-shadow:none!important;
}
.customer-dashboard-v2 .quick-action:hover .quick-icon,
.customer-dashboard-v2 .quick-action:focus .quick-icon,
.customer-dashboard-v2 .quick-action:active .quick-icon{
    background:#ffffff!important;
    border-color:#e8edf3!important;
    box-shadow:none!important;
    transform:none!important;
}
.customer-dashboard-v2 .account-row,
.customer-dashboard-v2 .notification-row{
    border-radius:10px!important;
    padding:10px 0!important;
    transition:background .18s ease,color .18s ease!important;
    transform:none!important;
}
.customer-dashboard-v2 .account-row:hover,
.customer-dashboard-v2 .account-row:focus,
.customer-dashboard-v2 .account-row:active,
.customer-dashboard-v2 .notification-row:hover,
.customer-dashboard-v2 .notification-row:focus,
.customer-dashboard-v2 .notification-row:active{
    background:rgba(255,248,239,.86)!important;
    border-radius:10px!important;
    padding:10px 0!important;
    transform:none!important;
    box-shadow:none!important;
    backdrop-filter:blur(3px);
}
.customer-dashboard-v2 .edit-profile-button{
    width:154px!important;
    max-width:154px!important;
    height:34px!important;
    min-height:34px!important;
    margin:12px auto 0!important;
    border-radius:8px!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    text-align:center!important;
}
@media(max-width:1320px){
    .customer-dashboard-v2 .right-column{
        width:100%!important;
        max-width:100%!important;
        justify-self:stretch!important;
    }
}



/* =========================================================
   FINAL DASHBOARD CLEANUP - requested last revision
   - Main dashboard content has no visible wrapper/box
   - Dashboard background is one flat white color
   - Analytics + stat cards use one consistent soft blurred hover
   - Right panel hover is extra light and never shifts/moves
   - Icons keep their assigned real/original colors on hover/active
   ========================================================= */
html:has(.customer-dashboard-v2),
body:has(.customer-dashboard-v2){
    background:#ffffff!important;
}
body:has(.customer-dashboard-v2) main,
body:has(.customer-dashboard-v2) .min-h-screen,
body:has(.customer-dashboard-v2) .py-12,
body:has(.customer-dashboard-v2) .max-w-7xl,
body:has(.customer-dashboard-v2) .mx-auto,
body:has(.customer-dashboard-v2) .sm\:px-6,
body:has(.customer-dashboard-v2) .lg\:px-8,
body:has(.customer-dashboard-v2) .bg-white,
body:has(.customer-dashboard-v2) .overflow-hidden,
body:has(.customer-dashboard-v2) .shadow-sm,
body:has(.customer-dashboard-v2) .sm\:rounded-lg,
body:has(.customer-dashboard-v2) .p-6,
body:has(.customer-dashboard-v2) .text-gray-900{
    background:#ffffff!important;
    border:0!important;
    box-shadow:none!important;
    border-radius:0!important;
    outline:0!important;
}
.customer-dashboard-v2{
    background:#ffffff!important;
    padding:0 0 34px!important;
}
.customer-dashboard-v2 .dashboard-shell,
.customer-dashboard-v2 .dashboard-board,
.customer-dashboard-v2 .left-column,
.customer-dashboard-v2 .right-column{
    background:#ffffff!important;
    border:0!important;
    box-shadow:none!important;
    outline:0!important;
    border-radius:0!important;
}
.customer-dashboard-v2 .dashboard-shell::before,
.customer-dashboard-v2 .dashboard-shell::after,
.customer-dashboard-v2 .dashboard-board::before,
.customer-dashboard-v2 .dashboard-board::after{
    display:none!important;
    content:none!important;
}
.customer-dashboard-v2 .analytics-grid>.chart-card{
    border-color:#e8ecf2!important;
    background:#ffffff!important;
    box-shadow:none!important;
    transform:none!important;
    transition:background .18s ease, border-color .18s ease, box-shadow .18s ease!important;
}
.customer-dashboard-v2 .analytics-grid>.chart-card:hover,
.customer-dashboard-v2 .analytics-grid>.chart-card:focus-within,
.customer-dashboard-v2 .analytics-grid>.chart-card.is-active,
.customer-dashboard-v2 .stats-grid>.stat-card:hover,
.customer-dashboard-v2 .stats-grid>.stat-card:focus,
.customer-dashboard-v2 .stats-grid>.stat-card:active,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active{
    background:rgba(255,248,239,.74)!important;
    border-color:#e8ecf2!important;
    box-shadow:0 0 0 1px rgba(255,122,0,.025), inset 0 0 28px rgba(255,255,255,.65)!important;
    backdrop-filter:blur(6px)!important;
    transform:none!important;
}
.customer-dashboard-v2 .analytics-grid>.chart-card:hover *,
.customer-dashboard-v2 .analytics-grid>.chart-card:focus-within *,
.customer-dashboard-v2 .analytics-grid>.chart-card.is-active *,
.customer-dashboard-v2 .stats-grid>.stat-card:hover *,
.customer-dashboard-v2 .stats-grid>.stat-card:focus *,
.customer-dashboard-v2 .stats-grid>.stat-card:active *,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active *{
    transform:none!important;
}
.customer-dashboard-v2 .stats-grid>.stat-card,
.customer-dashboard-v2 .stats-grid>.stat-card:hover,
.customer-dashboard-v2 .stats-grid>.stat-card:focus,
.customer-dashboard-v2 .stats-grid>.stat-card:active,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active{
    color:#111827!important;
}
.customer-dashboard-v2 .stats-grid>.stat-card .stat-icon,
.customer-dashboard-v2 .stats-grid>.stat-card:hover .stat-icon,
.customer-dashboard-v2 .stats-grid>.stat-card:focus .stat-icon,
.customer-dashboard-v2 .stats-grid>.stat-card:active .stat-icon,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active .stat-icon{
    background:var(--stat-soft)!important;
    color:var(--stat-color)!important;
}
.customer-dashboard-v2 .stats-grid>.stat-card .stat-value,
.customer-dashboard-v2 .stats-grid>.stat-card:hover .stat-value,
.customer-dashboard-v2 .stats-grid>.stat-card:focus .stat-value,
.customer-dashboard-v2 .stats-grid>.stat-card:active .stat-value,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active .stat-value,
.customer-dashboard-v2 .stats-grid>.stat-card .stat-link,
.customer-dashboard-v2 .stats-grid>.stat-card:hover .stat-link,
.customer-dashboard-v2 .stats-grid>.stat-card:focus .stat-link,
.customer-dashboard-v2 .stats-grid>.stat-card:active .stat-link,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active .stat-link{
    color:var(--stat-color)!important;
}
.customer-dashboard-v2 .quick-action,
.customer-dashboard-v2 .account-row,
.customer-dashboard-v2 .notification-row{
    transform:none!important;
    translate:none!important;
    scale:1!important;
    box-shadow:none!important;
    transition:background .18s ease, color .18s ease!important;
}
.customer-dashboard-v2 .quick-action:hover,
.customer-dashboard-v2 .quick-action:focus,
.customer-dashboard-v2 .quick-action:active,
.customer-dashboard-v2 .account-row:hover,
.customer-dashboard-v2 .account-row:focus,
.customer-dashboard-v2 .account-row:active,
.customer-dashboard-v2 .notification-row:hover,
.customer-dashboard-v2 .notification-row:focus,
.customer-dashboard-v2 .notification-row:active,
.customer-dashboard-v2 .right-column .account-row:hover,
.customer-dashboard-v2 .right-column .account-row:focus,
.customer-dashboard-v2 .right-column .account-row:active,
.customer-dashboard-v2 .right-column .notification-row:hover,
.customer-dashboard-v2 .right-column .notification-row:focus,
.customer-dashboard-v2 .right-column .notification-row:active{
    background:rgba(255,250,244,.55)!important;
    border-radius:10px!important;
    padding-left:0!important;
    padding-right:0!important;
    margin-left:0!important;
    margin-right:0!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    box-shadow:none!important;
    backdrop-filter:blur(7px)!important;
}
.customer-dashboard-v2 .quick-action,
.customer-dashboard-v2 .quick-action:hover,
.customer-dashboard-v2 .quick-action:focus,
.customer-dashboard-v2 .quick-action:active{
    color:#111827!important;
}
.customer-dashboard-v2 .quick-action .quick-icon,
.customer-dashboard-v2 .quick-action:hover .quick-icon,
.customer-dashboard-v2 .quick-action:focus .quick-icon,
.customer-dashboard-v2 .quick-action:active .quick-icon{
    background:#ffffff!important;
    color:var(--quick-color)!important;
    border-color:#e8edf3!important;
    box-shadow:none!important;
    transform:none!important;
}
.customer-dashboard-v2 .account-row .row-icon,
.customer-dashboard-v2 .account-row:hover .row-icon,
.customer-dashboard-v2 .account-row:focus .row-icon,
.customer-dashboard-v2 .account-row:active .row-icon,
.customer-dashboard-v2 .notification-row .row-icon,
.customer-dashboard-v2 .notification-row:hover .row-icon,
.customer-dashboard-v2 .notification-row:focus .row-icon,
.customer-dashboard-v2 .notification-row:active .row-icon{
    background:var(--row-soft)!important;
    color:var(--row-color)!important;
    transform:none!important;
}
.customer-dashboard-v2 .edit-profile-button{
    width:150px!important;
    max-width:150px!important;
    height:34px!important;
    margin:12px auto 0!important;
    justify-self:center!important;
}



/* =========================================================
   FINAL FIX - requested: Total Orders stable, account icons
   plain, button gradient palette #FF9A32 -> #FDFD23,
   keep calendar/date unchanged, preserve all functions.
   ========================================================= */
:root{
    --dash-button-start:#FF9A32;
    --dash-button-end:#FDFD23;
    --dash-hover-soft:rgba(255,250,244,.42);
    --dash-card-hover:rgba(255,248,239,.66);
}

/* Keep the main dashboard content as one clean white surface with no outer box. */
html:has(.customer-dashboard-v2),
body:has(.customer-dashboard-v2),
body:has(.customer-dashboard-v2) main,
body:has(.customer-dashboard-v2) .min-h-screen,
body:has(.customer-dashboard-v2) .py-12,
body:has(.customer-dashboard-v2) .max-w-7xl,
body:has(.customer-dashboard-v2) .mx-auto,
body:has(.customer-dashboard-v2) .sm\:px-6,
body:has(.customer-dashboard-v2) .lg\:px-8,
body:has(.customer-dashboard-v2) .bg-white,
body:has(.customer-dashboard-v2) .overflow-hidden,
body:has(.customer-dashboard-v2) .shadow-sm,
body:has(.customer-dashboard-v2) .sm\:rounded-lg,
body:has(.customer-dashboard-v2) .p-6,
body:has(.customer-dashboard-v2) .text-gray-900,
.customer-dashboard-v2,
.customer-dashboard-v2 .dashboard-shell,
.customer-dashboard-v2 .dashboard-board,
.customer-dashboard-v2 .left-column,
.customer-dashboard-v2 .right-column{
    background:#ffffff!important;
    border:0!important;
    box-shadow:none!important;
    outline:0!important;
}
.customer-dashboard-v2 .dashboard-shell,
.customer-dashboard-v2 .dashboard-board{
    border-radius:0!important;
}

/* Top 3 chart boxes: subtle border, same hover color, no movement. */
.customer-dashboard-v2 .analytics-grid>.chart-card{
    border:1px solid #e7ebf0!important;
    background:#ffffff!important;
    box-shadow:none!important;
    transform:none!important;
    transition:background .18s ease,border-color .18s ease,box-shadow .18s ease!important;
}
.customer-dashboard-v2 .analytics-grid>.chart-card:hover,
.customer-dashboard-v2 .analytics-grid>.chart-card:focus-within,
.customer-dashboard-v2 .analytics-grid>.chart-card.is-active{
    background:var(--dash-card-hover)!important;
    border-color:#e7ebf0!important;
    box-shadow:inset 0 0 34px rgba(255,255,255,.68)!important;
    backdrop-filter:blur(7px)!important;
    transform:none!important;
}

/* Fix / restore the 5 summary cards so Total Orders and the rest do not shift. */
.customer-dashboard-v2 .stats-grid>.stat-card{
    min-height:106px!important;
    padding:17px 18px!important;
    display:grid!important;
    align-content:start!important;
    gap:8px!important;
    border-color:var(--stat-color)!important;
    background:var(--stat-soft)!important;
    box-shadow:none!important;
    transform:none!important;
    transition:background .18s ease,border-color .18s ease,box-shadow .18s ease!important;
}
.customer-dashboard-v2 .stats-grid>.stat-card:hover,
.customer-dashboard-v2 .stats-grid>.stat-card:focus,
.customer-dashboard-v2 .stats-grid>.stat-card:active,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active{
    background:var(--dash-card-hover)!important;
    border-color:var(--stat-color)!important;
    box-shadow:inset 0 0 34px rgba(255,255,255,.68)!important;
    backdrop-filter:blur(7px)!important;
    transform:none!important;
}
.customer-dashboard-v2 .stats-grid>.stat-card .stat-top{
    display:flex!important;
    align-items:center!important;
    gap:10px!important;
    min-height:34px!important;
}
.customer-dashboard-v2 .stats-grid>.stat-card .stat-icon,
.customer-dashboard-v2 .stats-grid>.stat-card:hover .stat-icon,
.customer-dashboard-v2 .stats-grid>.stat-card:focus .stat-icon,
.customer-dashboard-v2 .stats-grid>.stat-card:active .stat-icon,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active .stat-icon{
    width:34px!important;
    height:34px!important;
    flex:0 0 34px!important;
    display:grid!important;
    place-items:center!important;
    background:var(--stat-soft)!important;
    color:var(--stat-color)!important;
    border-radius:10px!important;
    transform:none!important;
}
.customer-dashboard-v2 .stats-grid>.stat-card .stat-title,
.customer-dashboard-v2 .stats-grid>.stat-card:hover .stat-title,
.customer-dashboard-v2 .stats-grid>.stat-card:focus .stat-title,
.customer-dashboard-v2 .stats-grid>.stat-card:active .stat-title,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active .stat-title,
.customer-dashboard-v2 .stats-grid>.stat-card .stat-note,
.customer-dashboard-v2 .stats-grid>.stat-card:hover .stat-note,
.customer-dashboard-v2 .stats-grid>.stat-card:focus .stat-note,
.customer-dashboard-v2 .stats-grid>.stat-card:active .stat-note,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active .stat-note{
    color:#111827!important;
    transform:none!important;
}
.customer-dashboard-v2 .stats-grid>.stat-card .stat-value,
.customer-dashboard-v2 .stats-grid>.stat-card:hover .stat-value,
.customer-dashboard-v2 .stats-grid>.stat-card:focus .stat-value,
.customer-dashboard-v2 .stats-grid>.stat-card:active .stat-value,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active .stat-value,
.customer-dashboard-v2 .stats-grid>.stat-card .stat-link,
.customer-dashboard-v2 .stats-grid>.stat-card:hover .stat-link,
.customer-dashboard-v2 .stats-grid>.stat-card:focus .stat-link,
.customer-dashboard-v2 .stats-grid>.stat-card:active .stat-link,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active .stat-link{
    color:var(--stat-color)!important;
    transform:none!important;
}

/* Right side: light blurred hover only, absolutely no movement or padding shift. */
.customer-dashboard-v2 .quick-action,
.customer-dashboard-v2 .account-row,
.customer-dashboard-v2 .notification-row,
.customer-dashboard-v2 .right-column .account-row,
.customer-dashboard-v2 .right-column .notification-row{
    transform:none!important;
    translate:none!important;
    scale:1!important;
    box-shadow:none!important;
    transition:background .18s ease,color .18s ease!important;
}
.customer-dashboard-v2 .quick-action:hover,
.customer-dashboard-v2 .quick-action:focus,
.customer-dashboard-v2 .quick-action:active,
.customer-dashboard-v2 .account-row:hover,
.customer-dashboard-v2 .account-row:focus,
.customer-dashboard-v2 .account-row:active,
.customer-dashboard-v2 .notification-row:hover,
.customer-dashboard-v2 .notification-row:focus,
.customer-dashboard-v2 .notification-row:active,
.customer-dashboard-v2 .right-column .account-row:hover,
.customer-dashboard-v2 .right-column .account-row:focus,
.customer-dashboard-v2 .right-column .account-row:active,
.customer-dashboard-v2 .right-column .notification-row:hover,
.customer-dashboard-v2 .right-column .notification-row:focus,
.customer-dashboard-v2 .right-column .notification-row:active{
    background:var(--dash-hover-soft)!important;
    border-radius:10px!important;
    padding-left:0!important;
    padding-right:0!important;
    margin-left:0!important;
    margin-right:0!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    box-shadow:none!important;
    backdrop-filter:blur(9px)!important;
}

/* Account Status icons only: remove background shape. Notification icons remain unchanged. */
.customer-dashboard-v2 .account-card .row-icon,
.customer-dashboard-v2 .account-card .account-row:hover .row-icon,
.customer-dashboard-v2 .account-card .account-row:focus .row-icon,
.customer-dashboard-v2 .account-card .account-row:active .row-icon{
    width:24px!important;
    height:24px!important;
    min-width:24px!important;
    background:transparent!important;
    border:0!important;
    border-radius:0!important;
    color:var(--row-color)!important;
    box-shadow:none!important;
    transform:none!important;
}
.customer-dashboard-v2 .account-card .row-icon svg,
.customer-dashboard-v2 .account-card .row-icon i{
    color:var(--row-color)!important;
    stroke:currentColor!important;
}

/* Preserve quick action icon real colors on hover/active. */
.customer-dashboard-v2 .quick-action .quick-icon,
.customer-dashboard-v2 .quick-action:hover .quick-icon,
.customer-dashboard-v2 .quick-action:focus .quick-icon,
.customer-dashboard-v2 .quick-action:active .quick-icon{
    background:#ffffff!important;
    color:var(--quick-color)!important;
    border-color:#e8edf3!important;
    box-shadow:none!important;
    transform:none!important;
}
.customer-dashboard-v2 .quick-action .quick-icon svg,
.customer-dashboard-v2 .quick-action .quick-icon i{
    color:var(--quick-color)!important;
    stroke:currentColor!important;
}

/* Gradient buttons based on the circled palette. Exclude calendar/date buttons. */
.customer-dashboard-v2 .primary-button,
.customer-dashboard-v2 .light-button,
.customer-dashboard-v2 .tiny-button,
.customer-dashboard-v2 .view-button,
.customer-dashboard-v2 .clear-filter-btn,
.customer-dashboard-v2 .select-chip,
.customer-dashboard-v2 .edit-profile-button,
.customer-dashboard-v2 .empty-state .primary-button{
    min-height:auto!important;
    height:auto!important;
    min-width:auto!important;
    padding:0.625rem 2rem!important;
    border-radius:0.375rem!important;
    border:0!important;
    background:linear-gradient(90deg,var(--dash-button-start) 0%,var(--dash-button-end) 100%)!important;
    color:#111827!important;
    font-size:18px!important;
    line-height:1.2!important;
    font-weight:700!important;
    box-shadow:none!important;
    text-align:center!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:8px!important;
    transform:none!important;
    transition:filter .18s ease,opacity .18s ease,color .18s ease!important;
}
.customer-dashboard-v2 .primary-button:hover,
.customer-dashboard-v2 .primary-button:focus,
.customer-dashboard-v2 .light-button:hover,
.customer-dashboard-v2 .light-button:focus,
.customer-dashboard-v2 .tiny-button:hover,
.customer-dashboard-v2 .tiny-button:focus,
.customer-dashboard-v2 .view-button:hover,
.customer-dashboard-v2 .view-button:focus,
.customer-dashboard-v2 .clear-filter-btn:hover,
.customer-dashboard-v2 .clear-filter-btn:focus,
.customer-dashboard-v2 .select-chip:hover,
.customer-dashboard-v2 .select-chip:focus,
.customer-dashboard-v2 .select-chip.is-active,
.customer-dashboard-v2 .edit-profile-button:hover,
.customer-dashboard-v2 .edit-profile-button:focus,
.customer-dashboard-v2 .empty-state .primary-button:hover,
.customer-dashboard-v2 .empty-state .primary-button:focus{
    background:linear-gradient(90deg,var(--dash-button-start) 0%,var(--dash-button-end) 100%)!important;
    color:#111827!important;
    filter:brightness(.96)!important;
    box-shadow:none!important;
    transform:none!important;
}
.customer-dashboard-v2 .edit-profile-button{
    width:max-content!important;
    max-width:none!important;
    margin:12px auto 0!important;
}
.customer-dashboard-v2 .select-chip{
    font-size:13px!important;
    padding:0.5rem 1.1rem!important;
}
.customer-dashboard-v2 .view-button,
.customer-dashboard-v2 .clear-filter-btn{
    font-size:12px!important;
    padding:0.45rem 1rem!important;
}

/* Do not alter calendar/date appearance. */
.customer-dashboard-v2 .date-pill,
.customer-dashboard-v2 .calendar-toggle,
.customer-dashboard-v2 .calendar-icon-btn,
.customer-dashboard-v2 .calendar-action-btn,
.customer-dashboard-v2 .calendar-mini-btn,
.customer-dashboard-v2 .calendar-save-btn,
.customer-dashboard-v2 .calendar-clear-btn{
    background:inherit;
}



/* =========================================================
   FINAL SMALL BUTTON + SPACING FIX
   Requested: Small px-4 py-2 rounded-full text-sm
   Palette: #FF9A02 -> #FED404
   Calendar/date button remains unchanged.
========================================================= */
.customer-dashboard-v2{
    --dash-button-start:#FF9A02!important;
    --dash-button-end:#FED404!important;
    --dash-hover-soft:rgba(255,154,2,.045)!important;
    --dash-hover-muted:rgba(17,24,39,.055)!important;
}

/* Slight extra breathing space between box groups only. */
.customer-dashboard-v2 .dashboard-board{gap:20px!important;}
.customer-dashboard-v2 .left-column,
.customer-dashboard-v2 .right-column{gap:20px!important;}
.customer-dashboard-v2 .analytics-grid,
.customer-dashboard-v2 .stats-grid,
.customer-dashboard-v2 .content-grid{gap:20px!important;}

/* Keep Total Orders and the rest of the 5 summary boxes aligned and steady. */
.customer-dashboard-v2 .stats-grid>.stat-card{
    min-height:112px!important;
    padding:17px 18px!important;
    display:grid!important;
    align-content:start!important;
    gap:8px!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
}
.customer-dashboard-v2 .stats-grid>.stat-card:hover,
.customer-dashboard-v2 .stats-grid>.stat-card:focus,
.customer-dashboard-v2 .stats-grid>.stat-card:active,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active{
    background:linear-gradient(180deg,rgba(17,24,39,.045),rgba(255,154,2,.035))!important;
    border-color:var(--stat-color)!important;
    box-shadow:none!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    backdrop-filter:blur(8px)!important;
}
.customer-dashboard-v2 .stat-icon,
.customer-dashboard-v2 .stat-card:hover .stat-icon,
.customer-dashboard-v2 .stat-card:focus .stat-icon,
.customer-dashboard-v2 .stat-card:active .stat-icon,
.customer-dashboard-v2 .stat-card.is-active .stat-icon{
    color:var(--stat-color)!important;
    background:var(--stat-soft)!important;
    transform:none!important;
}
.customer-dashboard-v2 .stat-icon svg,
.customer-dashboard-v2 .stat-icon i{
    color:var(--stat-color)!important;
    stroke:currentColor!important;
}
.customer-dashboard-v2 .stat-title,
.customer-dashboard-v2 .stat-value,
.customer-dashboard-v2 .stat-note,
.customer-dashboard-v2 .stat-link{
    transform:none!important;
}

/* One soft hover style for the 3 chart boxes and 5 summary boxes. */
.customer-dashboard-v2 .chart-card:hover,
.customer-dashboard-v2 .chart-card:focus-within,
.customer-dashboard-v2 .chart-card.is-active{
    background:linear-gradient(180deg,rgba(17,24,39,.045),rgba(255,154,2,.035))!important;
    border-color:#e3e7ee!important;
    box-shadow:none!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    backdrop-filter:blur(8px)!important;
}

/* Right side hover: very light blurred/dark-light mix, no movement. */
.customer-dashboard-v2 .right-column .quick-action:hover,
.customer-dashboard-v2 .right-column .quick-action:focus,
.customer-dashboard-v2 .right-column .quick-action:active,
.customer-dashboard-v2 .right-column .account-row:hover,
.customer-dashboard-v2 .right-column .account-row:focus,
.customer-dashboard-v2 .right-column .account-row:active,
.customer-dashboard-v2 .right-column .notification-row:hover,
.customer-dashboard-v2 .right-column .notification-row:focus,
.customer-dashboard-v2 .right-column .notification-row:active{
    background:linear-gradient(90deg,rgba(17,24,39,.035),rgba(255,154,2,.04))!important;
    border-radius:10px!important;
    padding-left:0!important;
    padding-right:0!important;
    margin-left:0!important;
    margin-right:0!important;
    box-shadow:none!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    backdrop-filter:blur(10px)!important;
}

/* Account Status only: remove icon background/shape, keep icon real color. */
.customer-dashboard-v2 .account-card .row-icon,
.customer-dashboard-v2 .account-card .account-row:hover .row-icon,
.customer-dashboard-v2 .account-card .account-row:focus .row-icon,
.customer-dashboard-v2 .account-card .account-row:active .row-icon{
    width:24px!important;
    height:24px!important;
    min-width:24px!important;
    background:transparent!important;
    border:0!important;
    border-radius:0!important;
    box-shadow:none!important;
    color:var(--row-color)!important;
    transform:none!important;
}
.customer-dashboard-v2 .account-card .row-icon svg,
.customer-dashboard-v2 .account-card .row-icon i{
    color:var(--row-color)!important;
    stroke:currentColor!important;
}

/* Quick action icons: keep their assigned icon colors, no color switching. */
.customer-dashboard-v2 .quick-action .quick-icon,
.customer-dashboard-v2 .quick-action:hover .quick-icon,
.customer-dashboard-v2 .quick-action:focus .quick-icon,
.customer-dashboard-v2 .quick-action:active .quick-icon{
    background:#fff!important;
    color:var(--quick-color)!important;
    border-color:#e8edf3!important;
    box-shadow:none!important;
    transform:none!important;
}
.customer-dashboard-v2 .quick-action .quick-icon svg,
.customer-dashboard-v2 .quick-action .quick-icon i{
    color:var(--quick-color)!important;
    stroke:currentColor!important;
}

/* Small button style: px-4 py-2 rounded-full text-sm. */
.customer-dashboard-v2 .primary-button,
.customer-dashboard-v2 .light-button,
.customer-dashboard-v2 .tiny-button,
.customer-dashboard-v2 .view-button,
.customer-dashboard-v2 .clear-filter-btn,
.customer-dashboard-v2 .select-chip,
.customer-dashboard-v2 .edit-profile-button,
.customer-dashboard-v2 .empty-state .primary-button{
    width:auto!important;
    min-width:auto!important;
    max-width:max-content!important;
    min-height:auto!important;
    height:auto!important;
    padding:0.5rem 1rem!important;
    border-radius:9999px!important;
    border:0!important;
    background:linear-gradient(90deg,#FF9A02 0%,#FED404 100%)!important;
    color:#111827!important;
    font-size:0.875rem!important;
    line-height:1.25rem!important;
    font-weight:700!important;
    box-shadow:none!important;
    text-align:center!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:0.35rem!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    transition:filter .18s ease,opacity .18s ease,background .18s ease,box-shadow .18s ease,color .18s ease!important;
}
.customer-dashboard-v2 .primary-button:hover,
.customer-dashboard-v2 .primary-button:focus,
.customer-dashboard-v2 .primary-button:active,
.customer-dashboard-v2 .light-button:hover,
.customer-dashboard-v2 .light-button:focus,
.customer-dashboard-v2 .light-button:active,
.customer-dashboard-v2 .tiny-button:hover,
.customer-dashboard-v2 .tiny-button:focus,
.customer-dashboard-v2 .tiny-button:active,
.customer-dashboard-v2 .view-button:hover,
.customer-dashboard-v2 .view-button:focus,
.customer-dashboard-v2 .view-button:active,
.customer-dashboard-v2 .clear-filter-btn:hover,
.customer-dashboard-v2 .clear-filter-btn:focus,
.customer-dashboard-v2 .clear-filter-btn:active,
.customer-dashboard-v2 .select-chip:hover,
.customer-dashboard-v2 .select-chip:focus,
.customer-dashboard-v2 .select-chip:active,
.customer-dashboard-v2 .select-chip.is-active,
.customer-dashboard-v2 .edit-profile-button:hover,
.customer-dashboard-v2 .edit-profile-button:focus,
.customer-dashboard-v2 .edit-profile-button:active,
.customer-dashboard-v2 .empty-state .primary-button:hover,
.customer-dashboard-v2 .empty-state .primary-button:focus,
.customer-dashboard-v2 .empty-state .primary-button:active{
    background:linear-gradient(90deg,#FF9A02 0%,#FED404 100%)!important;
    color:#111827!important;
    filter:brightness(.93) saturate(.94)!important;
    box-shadow:0 0 0 999px rgba(17,24,39,.025) inset!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    backdrop-filter:blur(8px)!important;
}
.customer-dashboard-v2 .edit-profile-button{
    margin:12px auto 0!important;
}
.customer-dashboard-v2 .empty-state .primary-button{
    margin-inline:auto!important;
}

/* Keep calendar/date controls exactly as the dashboard style, not the small gradient style. */
.customer-dashboard-v2 .date-pill,
.customer-dashboard-v2 .date-pill.calendar-toggle{
    min-width:178px!important;
    height:42px!important;
    padding:0 15px!important;
    border-radius:8px!important;
    border:1px solid #111827!important;
    background:#fff!important;
    color:#111827!important;
    font-size:12px!important;
    font-weight:700!important;
    line-height:1!important;
    box-shadow:none!important;
}
.customer-dashboard-v2 .calendar-icon-btn,
.customer-dashboard-v2 .calendar-action-btn,
.customer-dashboard-v2 .calendar-mini-btn,
.customer-dashboard-v2 .calendar-save-btn,
.customer-dashboard-v2 .calendar-clear-btn{
    transform:none!important;
}



/* =========================================================
   FINAL BUTTON PALETTE + SHAPE UPDATE
   Requested final: Small px-4 py-2 rounded-md text-sm
   Palette: #E64904 -> #F3B40D
   Calendar/date button remains unchanged.
========================================================= */
.customer-dashboard-v2{
    --dash-button-start:#E64904!important;
    --dash-button-end:#F3B40D!important;
    --dash-hover-soft:rgba(230,73,4,.04)!important;
    --dash-hover-muted:rgba(17,24,39,.045)!important;
}

.customer-dashboard-v2 .primary-button,
.customer-dashboard-v2 .light-button,
.customer-dashboard-v2 .tiny-button,
.customer-dashboard-v2 .view-button,
.customer-dashboard-v2 .clear-filter-btn,
.customer-dashboard-v2 .select-chip,
.customer-dashboard-v2 .edit-profile-button,
.customer-dashboard-v2 .empty-state .primary-button{
    width:auto!important;
    min-width:auto!important;
    max-width:max-content!important;
    min-height:auto!important;
    height:auto!important;
    padding:0.5rem 1rem!important;
    border-radius:0.375rem!important;
    border:0!important;
    background:linear-gradient(90deg,#E64904 0%,#F3B40D 100%)!important;
    color:#111827!important;
    font-size:0.875rem!important;
    line-height:1.25rem!important;
    font-weight:700!important;
    box-shadow:none!important;
    text-align:center!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:0.35rem!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    transition:filter .18s ease,opacity .18s ease,background .18s ease,box-shadow .18s ease,color .18s ease!important;
}
.customer-dashboard-v2 .primary-button:hover,
.customer-dashboard-v2 .primary-button:focus,
.customer-dashboard-v2 .primary-button:active,
.customer-dashboard-v2 .light-button:hover,
.customer-dashboard-v2 .light-button:focus,
.customer-dashboard-v2 .light-button:active,
.customer-dashboard-v2 .tiny-button:hover,
.customer-dashboard-v2 .tiny-button:focus,
.customer-dashboard-v2 .tiny-button:active,
.customer-dashboard-v2 .view-button:hover,
.customer-dashboard-v2 .view-button:focus,
.customer-dashboard-v2 .view-button:active,
.customer-dashboard-v2 .clear-filter-btn:hover,
.customer-dashboard-v2 .clear-filter-btn:focus,
.customer-dashboard-v2 .clear-filter-btn:active,
.customer-dashboard-v2 .select-chip:hover,
.customer-dashboard-v2 .select-chip:focus,
.customer-dashboard-v2 .select-chip:active,
.customer-dashboard-v2 .select-chip.is-active,
.customer-dashboard-v2 .edit-profile-button:hover,
.customer-dashboard-v2 .edit-profile-button:focus,
.customer-dashboard-v2 .edit-profile-button:active,
.customer-dashboard-v2 .empty-state .primary-button:hover,
.customer-dashboard-v2 .empty-state .primary-button:focus,
.customer-dashboard-v2 .empty-state .primary-button:active{
    background:linear-gradient(90deg,#E64904 0%,#F3B40D 100%)!important;
    color:#111827!important;
    filter:brightness(.94) saturate(.92)!important;
    box-shadow:0 0 0 999px rgba(17,24,39,.028) inset!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    backdrop-filter:blur(8px)!important;
}
.customer-dashboard-v2 .edit-profile-button{
    margin:12px auto 0!important;
}
.customer-dashboard-v2 .empty-state .primary-button{
    margin-inline:auto!important;
}

/* Keep calendar/date controls exactly as requested: unchanged. */
.customer-dashboard-v2 .date-pill,
.customer-dashboard-v2 .date-pill.calendar-toggle{
    min-width:178px!important;
    height:42px!important;
    padding:0 15px!important;
    border-radius:8px!important;
    border:1px solid #111827!important;
    background:#fff!important;
    color:#111827!important;
    font-size:12px!important;
    font-weight:700!important;
    line-height:1!important;
    box-shadow:none!important;
}

/* Extra-light blurred hover for cards/rows, no movement. */
.customer-dashboard-v2 .chart-card:hover,
.customer-dashboard-v2 .chart-card:focus-within,
.customer-dashboard-v2 .chart-card.is-active,
.customer-dashboard-v2 .stats-grid>.stat-card:hover,
.customer-dashboard-v2 .stats-grid>.stat-card:focus,
.customer-dashboard-v2 .stats-grid>.stat-card:active,
.customer-dashboard-v2 .stats-grid>.stat-card.is-active{
    background:linear-gradient(180deg,rgba(17,24,39,.04),rgba(230,73,4,.025))!important;
    box-shadow:none!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    backdrop-filter:blur(8px)!important;
}
.customer-dashboard-v2 .right-column .quick-action:hover,
.customer-dashboard-v2 .right-column .quick-action:focus,
.customer-dashboard-v2 .right-column .quick-action:active,
.customer-dashboard-v2 .right-column .account-row:hover,
.customer-dashboard-v2 .right-column .account-row:focus,
.customer-dashboard-v2 .right-column .account-row:active,
.customer-dashboard-v2 .right-column .notification-row:hover,
.customer-dashboard-v2 .right-column .notification-row:focus,
.customer-dashboard-v2 .right-column .notification-row:active{
    background:linear-gradient(90deg,rgba(17,24,39,.028),rgba(230,73,4,.025))!important;
    border-radius:10px!important;
    padding-left:0!important;
    padding-right:0!important;
    margin-left:0!important;
    margin-right:0!important;
    box-shadow:none!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    backdrop-filter:blur(10px)!important;
}



/* =========================================================
   LAST FIX: compact rounded-full buttons + icon-only notification
   - Buttons: px-4 py-2 rounded-full, smaller non-bold text
   - Calendar/date button intentionally untouched
   - Notification icon: green icon only, no background shape
========================================================= */
.customer-dashboard-v2 .primary-button,
.customer-dashboard-v2 .light-button,
.customer-dashboard-v2 .tiny-button,
.customer-dashboard-v2 .view-button,
.customer-dashboard-v2 .clear-filter-btn,
.customer-dashboard-v2 .select-chip,
.customer-dashboard-v2 .edit-profile-button,
.customer-dashboard-v2 .empty-state .primary-button{
    width:auto!important;
    min-width:auto!important;
    max-width:max-content!important;
    height:auto!important;
    min-height:auto!important;
    padding:0.5rem 1rem!important; /* py-2 px-4 */
    border-radius:9999px!important; /* rounded-full */
    border:0!important;
    background:linear-gradient(90deg,#E64904 0%,#F3B40D 100%)!important;
    color:#111827!important;
    font-size:0.8125rem!important;
    line-height:1.15!important;
    font-weight:500!important;
    letter-spacing:0!important;
    text-transform:none!important;
    box-shadow:none!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:0.35rem!important;
    text-align:center!important;
    white-space:nowrap!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    transition:filter .18s ease,background .18s ease,box-shadow .18s ease,color .18s ease,opacity .18s ease!important;
}
.customer-dashboard-v2 .primary-button:hover,
.customer-dashboard-v2 .primary-button:focus,
.customer-dashboard-v2 .primary-button:active,
.customer-dashboard-v2 .light-button:hover,
.customer-dashboard-v2 .light-button:focus,
.customer-dashboard-v2 .light-button:active,
.customer-dashboard-v2 .tiny-button:hover,
.customer-dashboard-v2 .tiny-button:focus,
.customer-dashboard-v2 .tiny-button:active,
.customer-dashboard-v2 .view-button:hover,
.customer-dashboard-v2 .view-button:focus,
.customer-dashboard-v2 .view-button:active,
.customer-dashboard-v2 .clear-filter-btn:hover,
.customer-dashboard-v2 .clear-filter-btn:focus,
.customer-dashboard-v2 .clear-filter-btn:active,
.customer-dashboard-v2 .select-chip:hover,
.customer-dashboard-v2 .select-chip:focus,
.customer-dashboard-v2 .select-chip:active,
.customer-dashboard-v2 .select-chip.is-active,
.customer-dashboard-v2 .edit-profile-button:hover,
.customer-dashboard-v2 .edit-profile-button:focus,
.customer-dashboard-v2 .edit-profile-button:active,
.customer-dashboard-v2 .empty-state .primary-button:hover,
.customer-dashboard-v2 .empty-state .primary-button:focus,
.customer-dashboard-v2 .empty-state .primary-button:active{
    background:linear-gradient(90deg,#E64904 0%,#F3B40D 100%)!important;
    color:#111827!important;
    filter:brightness(.92) saturate(.90)!important;
    box-shadow:0 0 0 999px rgba(17,24,39,.035) inset!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    backdrop-filter:blur(8px)!important;
}
.customer-dashboard-v2 .edit-profile-button{
    margin:12px auto 0!important;
    font-weight:500!important;
}
.customer-dashboard-v2 .empty-state .primary-button{
    margin-inline:auto!important;
}

/* Do not let the date/calendar button inherit the compact gradient button style. */
.customer-dashboard-v2 .date-pill,
.customer-dashboard-v2 .date-pill.calendar-toggle{
    min-width:178px!important;
    height:42px!important;
    padding:0 15px!important;
    border-radius:8px!important;
    border:1px solid #111827!important;
    background:#fff!important;
    color:#111827!important;
    font-size:12px!important;
    font-weight:700!important;
    line-height:1!important;
    box-shadow:none!important;
}

/* Notification icon should be green icon only, without the green bg circle/square. */
.customer-dashboard-v2 .notification-card .notification-row .row-icon{
    width:28px!important;
    height:28px!important;
    background:transparent!important;
    border:0!important;
    border-radius:0!important;
    box-shadow:none!important;
    color:var(--dash-green)!important;
}
.customer-dashboard-v2 .notification-card .notification-row .row-icon svg,
.customer-dashboard-v2 .notification-card .notification-row .row-icon i{
    color:var(--dash-green)!important;
    stroke:currentColor!important;
}

/* Keep large content cards from turning visibly gray on hover. */
.customer-dashboard-v2 .latest-card:hover,
.customer-dashboard-v2 .recent-card:hover,
.customer-dashboard-v2 .latest-card:focus-within,
.customer-dashboard-v2 .recent-card:focus-within{
    background:rgba(17,24,39,.018)!important;
    box-shadow:none!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    backdrop-filter:blur(6px)!important;
}



/* =========================================================
   FINAL BUTTON COLOR/TEXT FIX
   - Use #FF9800 button color from latest reference
   - Small rounded-full buttons with smaller non-bold text
   - Calendar/date pill is intentionally untouched
   ========================================================= */
.customer-dashboard-v2{
    --dash-button-start:#FF9800!important;
    --dash-button-end:#FF9800!important;
    --dash-button-solid:#FF9800!important;
}

.customer-dashboard-v2 .primary-button,
.customer-dashboard-v2 .light-button,
.customer-dashboard-v2 .tiny-button,
.customer-dashboard-v2 .view-button,
.customer-dashboard-v2 .clear-filter-btn,
.customer-dashboard-v2 .select-chip,
.customer-dashboard-v2 .edit-profile-button,
.customer-dashboard-v2 .empty-state .primary-button{
    height:auto!important;
    min-height:30px!important;
    min-width:auto!important;
    width:auto!important;
    padding:8px 16px!important;
    border:0!important;
    border-radius:999px!important;
    background:#FF9800!important;
    background-image:none!important;
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:10.5px!important;
    font-weight:500!important;
    line-height:1.15!important;
    letter-spacing:.005em!important;
    box-shadow:none!important;
    transform:none!important;
    white-space:nowrap!important;
}

.customer-dashboard-v2 .primary-button:hover,
.customer-dashboard-v2 .primary-button:focus,
.customer-dashboard-v2 .primary-button:active,
.customer-dashboard-v2 .light-button:hover,
.customer-dashboard-v2 .light-button:focus,
.customer-dashboard-v2 .light-button:active,
.customer-dashboard-v2 .tiny-button:hover,
.customer-dashboard-v2 .tiny-button:focus,
.customer-dashboard-v2 .tiny-button:active,
.customer-dashboard-v2 .view-button:hover,
.customer-dashboard-v2 .view-button:focus,
.customer-dashboard-v2 .view-button:active,
.customer-dashboard-v2 .clear-filter-btn:hover,
.customer-dashboard-v2 .clear-filter-btn:focus,
.customer-dashboard-v2 .clear-filter-btn:active,
.customer-dashboard-v2 .select-chip:hover,
.customer-dashboard-v2 .select-chip:focus,
.customer-dashboard-v2 .select-chip:active,
.customer-dashboard-v2 .select-chip.is-active,
.customer-dashboard-v2 .edit-profile-button:hover,
.customer-dashboard-v2 .edit-profile-button:focus,
.customer-dashboard-v2 .edit-profile-button:active,
.customer-dashboard-v2 .empty-state .primary-button:hover,
.customer-dashboard-v2 .empty-state .primary-button:focus,
.customer-dashboard-v2 .empty-state .primary-button:active{
    background:rgba(255,152,0,.88)!important;
    color:#111827!important;
    box-shadow:0 10px 24px rgba(17,24,39,.08), inset 0 0 0 999px rgba(255,255,255,.08)!important;
    filter:saturate(.95) brightness(.98)!important;
    transform:none!important;
}

.customer-dashboard-v2 .edit-profile-button{
    margin-left:auto!important;
    margin-right:auto!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
}

.customer-dashboard-v2 .empty-state .primary-button{
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
}

/* keep the calendar/date button exactly as a date pill */
.customer-dashboard-v2 .date-pill,
.customer-dashboard-v2 .date-pill.calendar-toggle{
    height:42px!important;
    min-width:178px!important;
    padding:0 15px!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:12px!important;
    font-weight:700!important;
    box-shadow:none!important;
}

/* notification icon stays green icon-only, no background shape */
.customer-dashboard-v2 .notification-card .row-icon{
    width:28px!important;
    height:28px!important;
    background:transparent!important;
    border-radius:0!important;
    box-shadow:none!important;
    color:var(--dash-green)!important;
}


/* =========================================================
   FINAL COLOR UPDATE ONLY
   Button palette changed to #FE7B09 -> #FFAB0A.
   Button text remains small/light. Calendar/date button untouched.
   ========================================================= */
.customer-dashboard-v2{
    --dash-button-start:#FE7B09!important;
    --dash-button-end:#FFAB0A!important;
    --dash-button-solid:#FE7B09!important;
}

.customer-dashboard-v2 .primary-button,
.customer-dashboard-v2 .light-button,
.customer-dashboard-v2 .tiny-button,
.customer-dashboard-v2 .view-button,
.customer-dashboard-v2 .clear-filter-btn,
.customer-dashboard-v2 .select-chip,
.customer-dashboard-v2 .edit-profile-button,
.customer-dashboard-v2 .empty-state .primary-button{
    background:linear-gradient(90deg,#FE7B09 0%,#FFAB0A 100%)!important;
    background-image:linear-gradient(90deg,#FE7B09 0%,#FFAB0A 100%)!important;
    color:#111827!important;
    font-size:10px!important;
    font-weight:500!important;
    letter-spacing:0!important;
    padding:8px 16px!important;
    border-radius:999px!important;
    border:0!important;
    box-shadow:none!important;
    transform:none!important;
}

.customer-dashboard-v2 .primary-button:hover,
.customer-dashboard-v2 .primary-button:focus,
.customer-dashboard-v2 .primary-button:active,
.customer-dashboard-v2 .light-button:hover,
.customer-dashboard-v2 .light-button:focus,
.customer-dashboard-v2 .light-button:active,
.customer-dashboard-v2 .tiny-button:hover,
.customer-dashboard-v2 .tiny-button:focus,
.customer-dashboard-v2 .tiny-button:active,
.customer-dashboard-v2 .view-button:hover,
.customer-dashboard-v2 .view-button:focus,
.customer-dashboard-v2 .view-button:active,
.customer-dashboard-v2 .clear-filter-btn:hover,
.customer-dashboard-v2 .clear-filter-btn:focus,
.customer-dashboard-v2 .clear-filter-btn:active,
.customer-dashboard-v2 .select-chip:hover,
.customer-dashboard-v2 .select-chip:focus,
.customer-dashboard-v2 .select-chip:active,
.customer-dashboard-v2 .select-chip.is-active,
.customer-dashboard-v2 .edit-profile-button:hover,
.customer-dashboard-v2 .edit-profile-button:focus,
.customer-dashboard-v2 .edit-profile-button:active,
.customer-dashboard-v2 .empty-state .primary-button:hover,
.customer-dashboard-v2 .empty-state .primary-button:focus,
.customer-dashboard-v2 .empty-state .primary-button:active{
    background:linear-gradient(90deg,rgba(254,123,9,.92) 0%,rgba(255,171,10,.92) 100%)!important;
    color:#111827!important;
    box-shadow:0 10px 22px rgba(17,24,39,.07), inset 0 0 0 999px rgba(17,24,39,.035)!important;
    filter:saturate(.95) brightness(.98)!important;
    transform:none!important;
}

.customer-dashboard-v2 .date-pill,
.customer-dashboard-v2 .date-pill.calendar-toggle{
    background:#fff!important;
    background-image:none!important;
    color:#111827!important;
}



/* =========================================================
   FINAL SIZE ALIGNMENT UPDATE
   - Keep approved #FE7B09 -> #FFAB0A color
   - Button text slightly larger but still normal/non-bold
   - Edit Profile and Create Order a little wider
   - This Month and This Year same height + width
   - Calendar/date pill remains untouched
========================================================= */
.customer-dashboard-v2{
    --dash-button-start:#FE7B09!important;
    --dash-button-end:#FFAB0A!important;
}

.customer-dashboard-v2 .primary-button,
.customer-dashboard-v2 .light-button,
.customer-dashboard-v2 .tiny-button,
.customer-dashboard-v2 .view-button,
.customer-dashboard-v2 .clear-filter-btn,
.customer-dashboard-v2 .select-chip,
.customer-dashboard-v2 .edit-profile-button,
.customer-dashboard-v2 .empty-state .primary-button{
    min-height:34px!important;
    height:34px!important;
    width:auto!important;
    min-width:88px!important;
    padding:0 16px!important;
    border:0!important;
    border-radius:999px!important;
    background:linear-gradient(90deg,#FE7B09 0%,#FFAB0A 100%)!important;
    background-image:linear-gradient(90deg,#FE7B09 0%,#FFAB0A 100%)!important;
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:11.5px!important;
    font-weight:500!important;
    line-height:1!important;
    letter-spacing:0!important;
    text-transform:none!important;
    box-shadow:none!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:6px!important;
    white-space:nowrap!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    transition:filter .18s ease,box-shadow .18s ease,background .18s ease,color .18s ease!important;
}

.customer-dashboard-v2 .primary-button:hover,
.customer-dashboard-v2 .primary-button:focus,
.customer-dashboard-v2 .primary-button:active,
.customer-dashboard-v2 .light-button:hover,
.customer-dashboard-v2 .light-button:focus,
.customer-dashboard-v2 .light-button:active,
.customer-dashboard-v2 .tiny-button:hover,
.customer-dashboard-v2 .tiny-button:focus,
.customer-dashboard-v2 .tiny-button:active,
.customer-dashboard-v2 .view-button:hover,
.customer-dashboard-v2 .view-button:focus,
.customer-dashboard-v2 .view-button:active,
.customer-dashboard-v2 .clear-filter-btn:hover,
.customer-dashboard-v2 .clear-filter-btn:focus,
.customer-dashboard-v2 .clear-filter-btn:active,
.customer-dashboard-v2 .select-chip:hover,
.customer-dashboard-v2 .select-chip:focus,
.customer-dashboard-v2 .select-chip:active,
.customer-dashboard-v2 .select-chip.is-active,
.customer-dashboard-v2 .edit-profile-button:hover,
.customer-dashboard-v2 .edit-profile-button:focus,
.customer-dashboard-v2 .edit-profile-button:active,
.customer-dashboard-v2 .empty-state .primary-button:hover,
.customer-dashboard-v2 .empty-state .primary-button:focus,
.customer-dashboard-v2 .empty-state .primary-button:active{
    background:linear-gradient(90deg,rgba(254,123,9,.92) 0%,rgba(255,171,10,.92) 100%)!important;
    color:#111827!important;
    filter:brightness(.96) saturate(.95)!important;
    box-shadow:0 8px 18px rgba(17,24,39,.07), inset 0 0 0 999px rgba(17,24,39,.025)!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
}

/* This Month and This Year: exact same size. */
.customer-dashboard-v2 .select-chip{
    width:96px!important;
    min-width:96px!important;
    height:34px!important;
    min-height:34px!important;
    padding:0 14px!important;
    font-size:11.5px!important;
    font-weight:500!important;
}

/* Edit Profile and Create Order: slightly wider outside buttons, same visual height. */
.customer-dashboard-v2 .edit-profile-button,
.customer-dashboard-v2 .empty-state .primary-button{
    min-width:116px!important;
    height:36px!important;
    min-height:36px!important;
    padding:0 18px!important;
    margin-left:auto!important;
    margin-right:auto!important;
    font-size:11.5px!important;
    font-weight:500!important;
}

.customer-dashboard-v2 .clear-filter-btn,
.customer-dashboard-v2 .view-button,
.customer-dashboard-v2 .tiny-button{
    min-width:74px!important;
    height:34px!important;
    min-height:34px!important;
    font-size:11px!important;
    font-weight:500!important;
}

/* Keep calendar/date button unchanged. */
.customer-dashboard-v2 .date-pill,
.customer-dashboard-v2 .date-pill.calendar-toggle{
    height:42px!important;
    min-height:42px!important;
    min-width:178px!important;
    padding:0 15px!important;
    border-radius:8px!important;
    border:1px solid #111827!important;
    background:#fff!important;
    background-image:none!important;
    color:#111827!important;
    font-size:12px!important;
    font-weight:700!important;
    line-height:1!important;
    box-shadow:none!important;
}



/* =========================================================
   FINAL DASHBOARD BUTTON + HOVER CONSISTENCY PATCH
   - All dashboard buttons use same approved orange gradient
   - All dashboard buttons hover black with white text
   - Save/Clear buttons inside calendar included
   - Date/calendar pill is wide enough and has no double orange border
   - Card hover uses one stronger dark-gray blurred hover, no movement
========================================================= */
.customer-dashboard-v2{
    --dash-button-start:#FE7B09!important;
    --dash-button-end:#FFAB0A!important;
    --dash-button-hover:#111827!important;
    --dash-card-hover:rgba(17,24,39,.105)!important;
    --dash-card-hover-soft:rgba(17,24,39,.075)!important;
}

.customer-dashboard-v2 .primary-button,
.customer-dashboard-v2 .light-button,
.customer-dashboard-v2 .tiny-button,
.customer-dashboard-v2 .view-button,
.customer-dashboard-v2 .clear-filter-btn,
.customer-dashboard-v2 .select-chip,
.customer-dashboard-v2 .edit-profile-button,
.customer-dashboard-v2 .empty-state .primary-button,
.customer-dashboard-v2 .calendar-save-btn,
.customer-dashboard-v2 .calendar-clear-btn,
.customer-dashboard-v2 .calendar-action-btn,
.customer-dashboard-v2 .calendar-mini-btn{
    height:34px!important;
    min-height:34px!important;
    min-width:88px!important;
    padding:0 16px!important;
    border:0!important;
    border-radius:999px!important;
    background:linear-gradient(90deg,var(--dash-button-start) 0%,var(--dash-button-end) 100%)!important;
    background-image:linear-gradient(90deg,var(--dash-button-start) 0%,var(--dash-button-end) 100%)!important;
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:11.8px!important;
    font-weight:500!important;
    line-height:1!important;
    letter-spacing:0!important;
    text-transform:none!important;
    box-shadow:none!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:6px!important;
    white-space:nowrap!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
    outline:none!important;
    cursor:pointer!important;
    transition:background .18s ease,color .18s ease,box-shadow .18s ease,filter .18s ease!important;
}

.customer-dashboard-v2 .primary-button:hover,
.customer-dashboard-v2 .primary-button:focus,
.customer-dashboard-v2 .primary-button:active,
.customer-dashboard-v2 .light-button:hover,
.customer-dashboard-v2 .light-button:focus,
.customer-dashboard-v2 .light-button:active,
.customer-dashboard-v2 .tiny-button:hover,
.customer-dashboard-v2 .tiny-button:focus,
.customer-dashboard-v2 .tiny-button:active,
.customer-dashboard-v2 .view-button:hover,
.customer-dashboard-v2 .view-button:focus,
.customer-dashboard-v2 .view-button:active,
.customer-dashboard-v2 .clear-filter-btn:hover,
.customer-dashboard-v2 .clear-filter-btn:focus,
.customer-dashboard-v2 .clear-filter-btn:active,
.customer-dashboard-v2 .select-chip:hover,
.customer-dashboard-v2 .select-chip:focus,
.customer-dashboard-v2 .select-chip:active,
.customer-dashboard-v2 .select-chip.is-active,
.customer-dashboard-v2 .edit-profile-button:hover,
.customer-dashboard-v2 .edit-profile-button:focus,
.customer-dashboard-v2 .edit-profile-button:active,
.customer-dashboard-v2 .empty-state .primary-button:hover,
.customer-dashboard-v2 .empty-state .primary-button:focus,
.customer-dashboard-v2 .empty-state .primary-button:active,
.customer-dashboard-v2 .calendar-save-btn:hover,
.customer-dashboard-v2 .calendar-save-btn:focus,
.customer-dashboard-v2 .calendar-save-btn:active,
.customer-dashboard-v2 .calendar-clear-btn:hover,
.customer-dashboard-v2 .calendar-clear-btn:focus,
.customer-dashboard-v2 .calendar-clear-btn:active,
.customer-dashboard-v2 .calendar-action-btn:hover,
.customer-dashboard-v2 .calendar-action-btn:focus,
.customer-dashboard-v2 .calendar-action-btn:active,
.customer-dashboard-v2 .calendar-mini-btn:hover,
.customer-dashboard-v2 .calendar-mini-btn:focus,
.customer-dashboard-v2 .calendar-mini-btn:active{
    background:#111827!important;
    background-image:none!important;
    color:#ffffff!important;
    box-shadow:0 10px 22px rgba(17,24,39,.16)!important;
    filter:none!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
}

/* This Month and This Year same height and width. */
.customer-dashboard-v2 .select-chip{
    width:96px!important;
    min-width:96px!important;
    height:34px!important;
    min-height:34px!important;
}

/* Outside buttons slightly wider but same family. */
.customer-dashboard-v2 .edit-profile-button,
.customer-dashboard-v2 .empty-state .primary-button{
    min-width:128px!important;
    height:36px!important;
    min-height:36px!important;
    padding:0 20px!important;
    margin-left:auto!important;
    margin-right:auto!important;
}

/* Calendar form save button takes available space but keeps same height/color/hover. */
.customer-dashboard-v2 .calendar-save-btn{
    flex:1!important;
    height:34px!important;
    min-height:34px!important;
}
.customer-dashboard-v2 .calendar-clear-btn{
    width:auto!important;
    min-width:82px!important;
    height:34px!important;
    min-height:34px!important;
}

/* Date/calendar pill: full visible text, no orange/double border; black hover with white font. */
.customer-dashboard-v2 .date-pill,
.customer-dashboard-v2 .date-pill.calendar-toggle{
    width:auto!important;
    min-width:224px!important;
    height:44px!important;
    min-height:44px!important;
    padding:0 18px!important;
    border:1px solid #111827!important;
    border-radius:10px!important;
    background:#ffffff!important;
    background-image:none!important;
    color:#111827!important;
    font-size:12px!important;
    font-weight:600!important;
    line-height:1!important;
    box-shadow:none!important;
    outline:none!important;
}
.customer-dashboard-v2 .date-pill.calendar-toggle:hover,
.customer-dashboard-v2 .date-pill.calendar-toggle:focus,
.customer-dashboard-v2 .date-pill.calendar-toggle:active{
    border-color:#111827!important;
    background:#111827!important;
    background-image:none!important;
    color:#ffffff!important;
    box-shadow:none!important;
    outline:none!important;
}
.customer-dashboard-v2 .date-pill.calendar-toggle:hover i,
.customer-dashboard-v2 .date-pill.calendar-toggle:focus i,
.customer-dashboard-v2 .date-pill.calendar-toggle:active i,
.customer-dashboard-v2 .date-pill.calendar-toggle:hover svg,
.customer-dashboard-v2 .date-pill.calendar-toggle:focus svg,
.customer-dashboard-v2 .date-pill.calendar-toggle:active svg{
    color:#ffffff!important;
    stroke:#ffffff!important;
}

/* Stronger but still clean unified hover for every dashboard card/row area, no movement. */
.customer-dashboard-v2 .chart-card:hover,
.customer-dashboard-v2 .chart-card.is-active,
.customer-dashboard-v2 .stat-card:hover,
.customer-dashboard-v2 .stat-card:focus,
.customer-dashboard-v2 .stat-card:active,
.customer-dashboard-v2 .stat-card.is-active,
.customer-dashboard-v2 .latest-card:hover,
.customer-dashboard-v2 .recent-card:hover{
    background:linear-gradient(180deg,rgba(17,24,39,.105),rgba(17,24,39,.055))!important;
    box-shadow:inset 0 0 0 999px rgba(255,255,255,.38), 0 12px 30px rgba(17,24,39,.055)!important;
    backdrop-filter:blur(4px)!important;
    -webkit-backdrop-filter:blur(4px)!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
}
.customer-dashboard-v2 .quick-action:hover,
.customer-dashboard-v2 .quick-action:focus,
.customer-dashboard-v2 .account-row:hover,
.customer-dashboard-v2 .account-row:focus,
.customer-dashboard-v2 .notification-row:hover,
.customer-dashboard-v2 .notification-row:focus,
.customer-dashboard-v2 .payment-row:hover,
.customer-dashboard-v2 .payment-row.is-active,
.customer-dashboard-v2 .legend-button:hover,
.customer-dashboard-v2 .legend-button.is-active,
.customer-dashboard-v2 .orders-table tbody tr:hover{
    background:rgba(17,24,39,.085)!important;
    box-shadow:inset 0 0 0 999px rgba(255,255,255,.32)!important;
    backdrop-filter:blur(4px)!important;
    -webkit-backdrop-filter:blur(4px)!important;
    color:#111827!important;
    transform:none!important;
    translate:none!important;
    scale:1!important;
}

/* Account Status and Notifications icons remain icon-only, no colored shape. */
.customer-dashboard-v2 .account-card .row-icon,
.customer-dashboard-v2 .notification-card .row-icon{
    width:28px!important;
    height:28px!important;
    background:transparent!important;
    border-radius:0!important;
    box-shadow:none!important;
}
.customer-dashboard-v2 .notification-card .row-icon{
    color:var(--dash-green)!important;
}



/* =========================================================
   FINAL REQUEST PATCH - do not change other dashboard styles
   - Date/calendar box reduced width but text remains fully visible
   - Latest Order Tracking and Recent Orders height reduced
   - Calendar Today / Use Date / Clear transparent with black border
   - Save Event smaller green button with black hover
========================================================= */
.customer-dashboard-v2 .date-pill,
.customer-dashboard-v2 .date-pill.calendar-toggle{
    min-width:196px!important;
    width:196px!important;
    max-width:196px!important;
    height:42px!important;
    min-height:42px!important;
    padding:0 14px!important;
    border:1px solid #111827!important;
    border-radius:10px!important;
    background:#ffffff!important;
    background-image:none!important;
    color:#111827!important;
    font-size:11.5px!important;
    font-weight:600!important;
    line-height:1!important;
    box-shadow:none!important;
    outline:none!important;
}
.customer-dashboard-v2 .date-pill.calendar-toggle:hover,
.customer-dashboard-v2 .date-pill.calendar-toggle:focus,
.customer-dashboard-v2 .date-pill.calendar-toggle:active{
    border-color:#111827!important;
    background:#111827!important;
    background-image:none!important;
    color:#ffffff!important;
    box-shadow:none!important;
    outline:none!important;
}
.customer-dashboard-v2 .date-pill.calendar-toggle:hover i,
.customer-dashboard-v2 .date-pill.calendar-toggle:focus i,
.customer-dashboard-v2 .date-pill.calendar-toggle:active i,
.customer-dashboard-v2 .date-pill.calendar-toggle:hover svg,
.customer-dashboard-v2 .date-pill.calendar-toggle:focus svg,
.customer-dashboard-v2 .date-pill.calendar-toggle:active svg{
    color:#ffffff!important;
    stroke:#ffffff!important;
}

.customer-dashboard-v2 .latest-card,
.customer-dashboard-v2 .recent-card{
    height:228px!important;
    min-height:228px!important;
    max-height:228px!important;
}
.customer-dashboard-v2 .latest-body,
.customer-dashboard-v2 .recent-table-wrap{
    min-height:0!important;
    height:auto!important;
    flex:1 1 auto!important;
    padding-bottom:12px!important;
}
.customer-dashboard-v2 .latest-card .empty-state,
.customer-dashboard-v2 .recent-card .empty-state,
.customer-dashboard-v2 #filterEmptyState{
    min-height:108px!important;
    padding:10px 16px!important;
}
.customer-dashboard-v2 .orders-table tbody td{
    height:72px!important;
}

.customer-dashboard-v2 .calendar-action-btn,
.customer-dashboard-v2 .calendar-clear-btn{
    height:30px!important;
    min-height:30px!important;
    min-width:80px!important;
    padding:0 16px!important;
    border:1px solid #111827!important;
    border-radius:999px!important;
    background:#ffffff!important;
    background-image:none!important;
    color:#111827!important;
    font-size:11.5px!important;
    font-weight:500!important;
    line-height:1!important;
    box-shadow:none!important;
    transform:none!important;
}
.customer-dashboard-v2 .calendar-action-btn:hover,
.customer-dashboard-v2 .calendar-action-btn:focus,
.customer-dashboard-v2 .calendar-action-btn:active,
.customer-dashboard-v2 .calendar-clear-btn:hover,
.customer-dashboard-v2 .calendar-clear-btn:focus,
.customer-dashboard-v2 .calendar-clear-btn:active{
    border-color:#111827!important;
    background:#111827!important;
    background-image:none!important;
    color:#ffffff!important;
    box-shadow:0 8px 18px rgba(17,24,39,.14)!important;
    transform:none!important;
}
.customer-dashboard-v2 .calendar-action-btn:hover i,
.customer-dashboard-v2 .calendar-action-btn:focus i,
.customer-dashboard-v2 .calendar-action-btn:active i,
.customer-dashboard-v2 .calendar-action-btn:hover svg,
.customer-dashboard-v2 .calendar-action-btn:focus svg,
.customer-dashboard-v2 .calendar-action-btn:active svg,
.customer-dashboard-v2 .calendar-clear-btn:hover i,
.customer-dashboard-v2 .calendar-clear-btn:focus i,
.customer-dashboard-v2 .calendar-clear-btn:active i,
.customer-dashboard-v2 .calendar-clear-btn:hover svg,
.customer-dashboard-v2 .calendar-clear-btn:focus svg,
.customer-dashboard-v2 .calendar-clear-btn:active svg{
    color:#ffffff!important;
    stroke:#ffffff!important;
}

.customer-dashboard-v2 .calendar-form-actions{
    justify-content:flex-end!important;
    gap:8px!important;
}
.customer-dashboard-v2 .calendar-save-btn{
    flex:0 0 124px!important;
    width:124px!important;
    min-width:124px!important;
    max-width:124px!important;
    height:34px!important;
    min-height:34px!important;
    padding:0 16px!important;
    border:0!important;
    border-radius:999px!important;
    background:#16a34a!important;
    background-image:none!important;
    color:#ffffff!important;
    font-size:11.5px!important;
    font-weight:500!important;
    line-height:1!important;
    box-shadow:none!important;
    transform:none!important;
}
.customer-dashboard-v2 .calendar-save-btn:hover,
.customer-dashboard-v2 .calendar-save-btn:focus,
.customer-dashboard-v2 .calendar-save-btn:active{
    background:#111827!important;
    background-image:none!important;
    color:#ffffff!important;
    box-shadow:0 8px 18px rgba(17,24,39,.14)!important;
    transform:none!important;
}


/* =========================================================
   CUSTOMER CALENDAR FINAL UI - UPDATED REFERENCE DESIGN
   Integrated directly in this file. Other dashboard sections unchanged.
========================================================= */
.customer-dashboard-v2 .dashboard-calendar-overlay{
    position:fixed!important;
    inset:0!important;
    z-index:9998!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    padding:24px!important;
    background:rgba(17,24,39,.38)!important;
    backdrop-filter:blur(8px)!important;
    -webkit-backdrop-filter:blur(8px)!important;
    opacity:0!important;
    visibility:hidden!important;
    pointer-events:none!important;
    transition:opacity .2s ease,visibility .2s ease!important;
}
.customer-dashboard-v2 .dashboard-calendar-overlay.is-open{
    opacity:1!important;
    visibility:visible!important;
    pointer-events:auto!important;
}
.customer-dashboard-v2 .dashboard-calendar-modal{
    width:min(850px,calc(100vw - 40px))!important;
    min-height:540px!important;
    max-height:calc(100vh - 48px)!important;
    display:grid!important;
    grid-template-columns:minmax(0,1fr) 320px!important;
    overflow:hidden!important;
    border:1px solid #e5e7eb!important;
    border-radius:14px!important;
    background:#ffffff!important;
    box-shadow:0 28px 90px rgba(15,23,42,.28)!important;
}
.customer-dashboard-v2 .calendar-main{
    min-width:0!important;
    padding:26px 24px 24px!important;
    border-right:1px solid #e5e7eb!important;
    background:#ffffff!important;
}
.customer-dashboard-v2 .calendar-side{
    min-width:0!important;
    padding:0!important;
    background:#ffffff!important;
}
.customer-dashboard-v2 .calendar-side-inner{
    height:100%!important;
    padding:26px 22px 20px!important;
    display:flex!important;
    flex-direction:column!important;
}
.customer-dashboard-v2 .calendar-modal-head{
    display:flex!important;
    align-items:flex-start!important;
    justify-content:space-between!important;
    gap:18px!important;
    margin-bottom:30px!important;
}
.customer-dashboard-v2 .calendar-title{
    margin:0!important;
    color:#111827!important;
    font-family:var(--dash-title-font)!important;
    font-size:23px!important;
    font-weight:700!important;
    line-height:1.2!important;
    letter-spacing:-.02em!important;
}
.customer-dashboard-v2 .calendar-subtitle{
    width:250px!important;
    margin:12px 0 0!important;
    color:#6b7280!important;
    font-family:var(--dash-font)!important;
    font-size:12px!important;
    font-weight:400!important;
    line-height:1.7!important;
}
.customer-dashboard-v2 .calendar-nav{
    display:flex!important;
    align-items:center!important;
    justify-content:flex-end!important;
    gap:10px!important;
    flex:0 0 auto!important;
}
.customer-dashboard-v2 .calendar-icon-btn{
    width:34px!important;
    height:34px!important;
    min-width:34px!important;
    min-height:34px!important;
    padding:0!important;
    border:1px solid #e5e7eb!important;
    border-radius:999px!important;
    background:#ffffff!important;
    background-image:none!important;
    color:#111827!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    box-shadow:none!important;
    cursor:pointer!important;
    transition:background .18s ease,color .18s ease,border-color .18s ease!important;
}
.customer-dashboard-v2 .calendar-icon-btn:hover,
.customer-dashboard-v2 .calendar-icon-btn:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#ffffff!important;
}
.customer-dashboard-v2 .calendar-icon-btn:hover svg,
.customer-dashboard-v2 .calendar-icon-btn:focus svg{
    stroke:#ffffff!important;
}
.customer-dashboard-v2 .calendar-close-x{
    margin-left:20px!important;
    border-color:transparent!important;
    background:transparent!important;
}
.customer-dashboard-v2 .calendar-action-btn{
    width:auto!important;
    min-width:62px!important;
    height:34px!important;
    min-height:34px!important;
    padding:0 16px!important;
    border:1px solid #e5e7eb!important;
    border-radius:999px!important;
    background:#ffffff!important;
    background-image:none!important;
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:11px!important;
    font-weight:500!important;
    line-height:1!important;
    box-shadow:none!important;
    cursor:pointer!important;
}
.customer-dashboard-v2 .calendar-action-btn:hover,
.customer-dashboard-v2 .calendar-action-btn:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#ffffff!important;
}
.customer-dashboard-v2 .calendar-month-row{
    display:flex!important;
    align-items:center!important;
    justify-content:space-between!important;
    gap:18px!important;
    margin-bottom:22px!important;
}
.customer-dashboard-v2 .calendar-month-title{
    margin:0!important;
    color:#111827!important;
    font-family:var(--dash-title-font)!important;
    font-size:19px!important;
    font-weight:700!important;
    line-height:1.2!important;
    letter-spacing:-.01em!important;
}
.customer-dashboard-v2 .calendar-use-date-btn{
    width:auto!important;
    height:36px!important;
    min-height:36px!important;
    padding:0 18px!important;
    border:1px solid #fed7aa!important;
    border-radius:10px!important;
    background:#ffffff!important;
    background-image:none!important;
    color:#ea580c!important;
    font-family:var(--dash-font)!important;
    font-size:12px!important;
    font-weight:600!important;
    line-height:1!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:8px!important;
    box-shadow:none!important;
    cursor:pointer!important;
}
.customer-dashboard-v2 .calendar-use-date-btn:hover,
.customer-dashboard-v2 .calendar-use-date-btn:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#ffffff!important;
}
.customer-dashboard-v2 .calendar-use-date-btn:hover svg,
.customer-dashboard-v2 .calendar-use-date-btn:focus svg{
    stroke:#ffffff!important;
}
.customer-dashboard-v2 .calendar-weekdays{
    display:grid!important;
    grid-template-columns:repeat(7,minmax(0,1fr))!important;
    gap:10px!important;
    margin-bottom:10px!important;
}
.customer-dashboard-v2 .calendar-weekdays span{
    height:18px!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    color:#6b7280!important;
    font-family:var(--dash-font)!important;
    font-size:9px!important;
    font-weight:600!important;
    text-transform:uppercase!important;
    letter-spacing:.04em!important;
}
.customer-dashboard-v2 .calendar-grid{
    display:grid!important;
    grid-template-columns:repeat(7,minmax(0,1fr))!important;
    gap:8px!important;
}
.customer-dashboard-v2 .calendar-day{
    position:relative!important;
    width:100%!important;
    min-height:58px!important;
    height:58px!important;
    padding:0!important;
    border:1px solid #edf0f4!important;
    border-radius:9px!important;
    background:#ffffff!important;
    color:#111827!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    text-align:center!important;
    cursor:pointer!important;
    box-shadow:none!important;
    overflow:hidden!important;
    transition:background .18s ease,border-color .18s ease,color .18s ease,box-shadow .18s ease!important;
}
.customer-dashboard-v2 .calendar-day:hover,
.customer-dashboard-v2 .calendar-day:focus{
    border-color:#fb923c!important;
    background:#fff7ed!important;
    box-shadow:0 8px 18px rgba(249,115,22,.08)!important;
    outline:none!important;
}
.customer-dashboard-v2 .calendar-day.is-muted{
    background:#fbfbfc!important;
    color:#c7cbd1!important;
    border-color:#edf0f4!important;
    cursor:default!important;
    box-shadow:none!important;
}
.customer-dashboard-v2 .calendar-day.is-today,
.customer-dashboard-v2 .calendar-day.is-selected{
    border-color:#fb923c!important;
    background:#fff7ed!important;
    color:#f97316!important;
    box-shadow:inset 0 0 0 1px #fb923c!important;
}
.customer-dashboard-v2 .calendar-day-number{
    display:block!important;
    color:inherit!important;
    font-family:var(--dash-font)!important;
    font-size:14px!important;
    font-weight:500!important;
    line-height:1!important;
}
.customer-dashboard-v2 .calendar-day-events{
    position:absolute!important;
    left:50%!important;
    bottom:8px!important;
    transform:translateX(-50%)!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:3px!important;
    margin:0!important;
}
.customer-dashboard-v2 .calendar-event-dot{
    width:5px!important;
    height:5px!important;
    border-radius:999px!important;
    background:#22c55e!important;
    box-shadow:none!important;
}
.customer-dashboard-v2 .calendar-more{
    color:#6b7280!important;
    font-size:8px!important;
    font-weight:600!important;
}
.customer-dashboard-v2 .calendar-side-title{
    margin:0 0 14px!important;
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:12px!important;
    font-weight:700!important;
    line-height:1!important;
}
.customer-dashboard-v2 .selected-date-card{
    min-height:72px!important;
    margin:0 0 22px!important;
    padding:15px 16px!important;
    border:1px solid #fed7aa!important;
    border-radius:10px!important;
    background:#fff7ed!important;
    display:grid!important;
    grid-template-columns:22px minmax(0,1fr)!important;
    gap:12px!important;
    align-items:flex-start!important;
}
.customer-dashboard-v2 .selected-date-icon{
    width:22px!important;
    height:22px!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    color:#f97316!important;
}
.customer-dashboard-v2 .selected-date-icon svg{
    stroke:#f97316!important;
}
.customer-dashboard-v2 .calendar-selected-date{
    margin:0!important;
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:12px!important;
    font-weight:700!important;
    line-height:1.35!important;
}
.customer-dashboard-v2 .selected-date-card p{
    margin:6px 0 0!important;
    color:#6b7280!important;
    font-family:var(--dash-font)!important;
    font-size:10px!important;
    font-weight:400!important;
    line-height:1.45!important;
}
.customer-dashboard-v2 .calendar-form{
    display:flex!important;
    flex-direction:column!important;
    gap:16px!important;
    flex:1!important;
}
.customer-dashboard-v2 .calendar-field{
    display:grid!important;
    gap:8px!important;
}
.customer-dashboard-v2 .calendar-field label{
    margin:0!important;
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:11px!important;
    font-weight:700!important;
    line-height:1!important;
    letter-spacing:0!important;
    text-transform:none!important;
}
.customer-dashboard-v2 .calendar-field input,
.customer-dashboard-v2 .calendar-field textarea{
    width:100%!important;
    border:1px solid #e5e7eb!important;
    border-radius:9px!important;
    background:#ffffff!important;
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:11px!important;
    font-weight:400!important;
    outline:none!important;
    box-shadow:none!important;
    transition:border-color .18s ease,box-shadow .18s ease!important;
}
.customer-dashboard-v2 .calendar-field input{
    height:42px!important;
    padding:0 14px!important;
}
.customer-dashboard-v2 .calendar-field textarea{
    min-height:82px!important;
    resize:none!important;
    padding:14px!important;
    line-height:1.5!important;
}
.customer-dashboard-v2 .calendar-field input::placeholder,
.customer-dashboard-v2 .calendar-field textarea::placeholder{
    color:#9ca3af!important;
}
.customer-dashboard-v2 .calendar-field input:focus,
.customer-dashboard-v2 .calendar-field textarea:focus{
    border-color:#fb923c!important;
    box-shadow:0 0 0 3px rgba(251,146,60,.12)!important;
}
.customer-dashboard-v2 .calendar-time-wrap{
    position:relative!important;
}
.customer-dashboard-v2 .calendar-time-wrap input[type="time"]{
    padding-right:16px!important;
}
/* Time field: one icon only. Make the native browser time icon bigger. */
.customer-dashboard-v2 .calendar-time-wrap input[type="time"]::-webkit-calendar-picker-indicator{
    width:22px!important;
    height:22px!important;
    opacity:1!important;
    cursor:pointer!important;
    margin-right:0!important;
    transform:scale(1.18)!important;
    transform-origin:center!important;
}
.customer-dashboard-v2 .calendar-time-wrap input[type="time"]::-webkit-inner-spin-button,
.customer-dashboard-v2 .calendar-time-wrap input[type="time"]::-webkit-clear-button{
    display:none!important;
}
/* Hide extra manual icon so only one time icon appears. */
.customer-dashboard-v2 .calendar-time-wrap > i,
.customer-dashboard-v2 .calendar-time-wrap > svg{
    display:none!important;
}
.customer-dashboard-v2 .calendar-info-box{
    min-height:58px!important;
    padding:13px 14px!important;
    border:1px solid #fed7aa!important;
    border-radius:10px!important;
    background:#fff7ed!important;
    color:#6b7280!important;
    font-family:var(--dash-font)!important;
    font-size:10px!important;
    font-weight:400!important;
    line-height:1.45!important;
    display:grid!important;
    grid-template-columns:18px minmax(0,1fr)!important;
    gap:10px!important;
    align-items:flex-start!important;
}
.customer-dashboard-v2 .calendar-info-box i,
.customer-dashboard-v2 .calendar-info-box svg{
    color:#f97316!important;
    stroke:#f97316!important;
}
.customer-dashboard-v2 .calendar-event-list{
    max-height:78px!important;
    overflow:auto!important;
    display:grid!important;
    gap:8px!important;
    margin:0!important;
    padding:0!important;
}
.customer-dashboard-v2 .calendar-empty{
    min-height:0!important;
    padding:0!important;
    border:0!important;
    background:transparent!important;
    color:#9ca3af!important;
    font-family:var(--dash-font)!important;
    font-size:10px!important;
    font-weight:400!important;
    text-align:left!important;
    display:none!important;
}
.customer-dashboard-v2 .calendar-event-item{
    padding:9px 10px!important;
    border:1px solid #e5e7eb!important;
    border-radius:9px!important;
    background:#ffffff!important;
    display:grid!important;
    gap:5px!important;
}
.customer-dashboard-v2 .calendar-event-title{
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:11px!important;
    font-weight:700!important;
    line-height:1.25!important;
}
.customer-dashboard-v2 .calendar-event-meta,
.customer-dashboard-v2 .calendar-event-note{
    color:#6b7280!important;
    font-family:var(--dash-font)!important;
    font-size:10px!important;
    font-weight:400!important;
    line-height:1.35!important;
}
.customer-dashboard-v2 .calendar-event-actions{
    display:flex!important;
    align-items:center!important;
    justify-content:flex-end!important;
    gap:6px!important;
    margin-top:2px!important;
}
.customer-dashboard-v2 .calendar-mini-btn{
    height:24px!important;
    min-height:24px!important;
    min-width:auto!important;
    padding:0 9px!important;
    border:1px solid #e5e7eb!important;
    border-radius:999px!important;
    background:#ffffff!important;
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:9px!important;
    font-weight:600!important;
    box-shadow:none!important;
}
.customer-dashboard-v2 .calendar-mini-btn:hover,
.customer-dashboard-v2 .calendar-mini-btn:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#ffffff!important;
}
.customer-dashboard-v2 .calendar-mini-btn.danger{
    color:#ef4444!important;
    border-color:#fee2e2!important;
}
.customer-dashboard-v2 .calendar-mini-btn.danger:hover,
.customer-dashboard-v2 .calendar-mini-btn.danger:focus{
    background:#ef4444!important;
    border-color:#ef4444!important;
    color:#ffffff!important;
}
.customer-dashboard-v2 .calendar-form-actions{
    margin-top:auto!important;
    padding-top:14px!important;
    display:flex!important;
    align-items:center!important;
    justify-content:flex-end!important;
    gap:14px!important;
}
.customer-dashboard-v2 .calendar-clear-btn{
    width:118px!important;
    min-width:118px!important;
    height:44px!important;
    min-height:44px!important;
    padding:0 18px!important;
    border:1px solid #d1d5db!important;
    border-radius:999px!important;
    background:#ffffff!important;
    background-image:none!important;
    color:#111827!important;
    font-family:var(--dash-font)!important;
    font-size:12px!important;
    font-weight:600!important;
    box-shadow:none!important;
    cursor:pointer!important;
}
.customer-dashboard-v2 .calendar-save-btn{
    width:146px!important;
    min-width:146px!important;
    height:44px!important;
    min-height:44px!important;
    padding:0 20px!important;
    border:0!important;
    border-radius:999px!important;
    background:#16a34a!important;
    background-image:none!important;
    color:#ffffff!important;
    font-family:var(--dash-font)!important;
    font-size:12px!important;
    font-weight:600!important;
    box-shadow:0 10px 20px rgba(22,163,74,.14)!important;
    cursor:pointer!important;
    flex:0 0 auto!important;
}
.customer-dashboard-v2 .calendar-clear-btn:hover,
.customer-dashboard-v2 .calendar-clear-btn:focus,
.customer-dashboard-v2 .calendar-save-btn:hover,
.customer-dashboard-v2 .calendar-save-btn:focus{
    background:#111827!important;
    background-image:none!important;
    border-color:#111827!important;
    color:#ffffff!important;
    box-shadow:0 10px 20px rgba(17,24,39,.16)!important;
}
@media(max-width:900px){
    .customer-dashboard-v2 .dashboard-calendar-modal{
        grid-template-columns:1fr!important;
        overflow:auto!important;
        min-height:auto!important;
    }
    .customer-dashboard-v2 .calendar-main{
        border-right:0!important;
        border-bottom:1px solid #e5e7eb!important;
    }
    .customer-dashboard-v2 .calendar-side-inner{
        padding:24px!important;
    }
}
@media(max-width:640px){
    .customer-dashboard-v2 .dashboard-calendar-overlay{
        padding:12px!important;
        align-items:flex-start!important;
        overflow:auto!important;
    }
    .customer-dashboard-v2 .dashboard-calendar-modal{
        width:100%!important;
        max-height:none!important;
    }
    .customer-dashboard-v2 .calendar-main{
        padding:24px 18px!important;
    }
    .customer-dashboard-v2 .calendar-modal-head{
        display:grid!important;
    }
    .customer-dashboard-v2 .calendar-nav{
        justify-content:flex-start!important;
        flex-wrap:wrap!important;
    }
    .customer-dashboard-v2 .calendar-close-x{
        margin-left:0!important;
    }
    .customer-dashboard-v2 .calendar-grid,
    .customer-dashboard-v2 .calendar-weekdays{
        gap:6px!important;
    }
    .customer-dashboard-v2 .calendar-day{
        height:48px!important;
        min-height:48px!important;
    }
    .customer-dashboard-v2 .calendar-form-actions{
        justify-content:stretch!important;
    }
    .customer-dashboard-v2 .calendar-clear-btn,
    .customer-dashboard-v2 .calendar-save-btn{
        width:100%!important;
        min-width:0!important;
    }
}


/* =========================================================
   FINAL TIME ICON + CALENDAR WIDTH SAFETY PATCH
   - Calendar modal smaller
   - Time field has one bigger native icon only
========================================================= */
.customer-dashboard-v2 .dashboard-calendar-modal{
    width:min(850px,calc(100vw - 40px))!important;
    grid-template-columns:minmax(0,1fr) 320px!important;
    min-height:540px!important;
}
.customer-dashboard-v2 .calendar-main{
    padding:26px 24px 24px!important;
}
.customer-dashboard-v2 .calendar-side-inner{
    padding:26px 22px 20px!important;
}
.customer-dashboard-v2 .calendar-time-wrap input[type="time"]{
    padding-right:16px!important;
}
.customer-dashboard-v2 .calendar-time-wrap input[type="time"]::-webkit-calendar-picker-indicator{
    width:22px!important;
    height:22px!important;
    opacity:1!important;
    cursor:pointer!important;
    transform:scale(1.18)!important;
    transform-origin:center!important;
}
.customer-dashboard-v2 .calendar-time-wrap > i,
.customer-dashboard-v2 .calendar-time-wrap > svg{
    display:none!important;
}



/* =========================================================
   FINAL LAYOUT PATCH - requested spacing + wider boxes
   - Right-side widgets remain removed/hidden
   - Main dashboard starts with left spacing
   - Content is pushed wider to the right with small right gap
   - Same UI/design preserved
========================================================= */
body:has(.customer-dashboard-v2) .max-w-7xl,
body:has(.customer-dashboard-v2) .mx-auto{
    width:100%!important;
    max-width:none!important;
    margin-left:0!important;
    margin-right:0!important;
}
body:has(.customer-dashboard-v2) .sm\:px-6,
body:has(.customer-dashboard-v2) .lg\:px-8,
body:has(.customer-dashboard-v2) .p-6{
    padding-left:0!important;
    padding-right:0!important;
}

.customer-dashboard-v2{
    width:100%!important;
    max-width:none!important;
    padding:0 26px 34px 58px!important; /* left spacing + small right spacing */
    overflow-x:hidden!important;
}

.customer-dashboard-v2 .dashboard-shell{
    width:100%!important;
    max-width:none!important;
    margin:0!important;
    padding:0!important;
}

.customer-dashboard-v2 .dashboard-header-row,
.customer-dashboard-v2 .dashboard-board{
    width:100%!important;
    max-width:none!important;
    margin-left:0!important;
    margin-right:0!important;
}

.customer-dashboard-v2 .dashboard-board{
    display:grid!important;
    grid-template-columns:minmax(0,1fr)!important;
    gap:20px!important;
    align-items:start!important;
}

.customer-dashboard-v2 .left-column{
    width:100%!important;
    max-width:none!important;
    min-width:0!important;
    justify-self:stretch!important;
}

.customer-dashboard-v2 .right-column{
    display:none!important;
    width:0!important;
    max-width:0!important;
    overflow:hidden!important;
}

/* Make the boxes occupy the widened area cleanly. */
.customer-dashboard-v2 .analytics-grid{
    width:100%!important;
    grid-template-columns:repeat(3,minmax(0,1fr))!important;
    gap:20px!important;
}

.customer-dashboard-v2 .stats-grid{
    width:100%!important;
    grid-template-columns:repeat(5,minmax(0,1fr))!important;
    gap:20px!important;
    overflow:visible!important;
}

.customer-dashboard-v2 .content-grid{
    width:100%!important;
    grid-template-columns:minmax(0,1fr) minmax(0,1fr)!important;
    gap:20px!important;
}

.customer-dashboard-v2 .chart-card,
.customer-dashboard-v2 .stat-card,
.customer-dashboard-v2 .latest-card,
.customer-dashboard-v2 .recent-card{
    width:100%!important;
    max-width:none!important;
}

/* Keep latest/recent compact but allow them to stretch horizontally. */
.customer-dashboard-v2 .latest-card,
.customer-dashboard-v2 .recent-card{
    min-width:0!important;
}

/* Responsive safety: keep clean layout on smaller screens. */
@media(max-width:1120px){
    .customer-dashboard-v2{
        padding:16px 18px 30px 28px!important;
    }
    .customer-dashboard-v2 .analytics-grid,
    .customer-dashboard-v2 .content-grid{
        grid-template-columns:1fr!important;
    }
    .customer-dashboard-v2 .stats-grid{
        grid-template-columns:repeat(2,minmax(0,1fr))!important;
    }
}

@media(max-width:720px){
    .customer-dashboard-v2{
        padding:16px 12px 28px 12px!important;
    }
    .customer-dashboard-v2 .stats-grid{
        grid-template-columns:1fr!important;
    }
}


</style>

@php
    $customer = auth()->user();
    $orders = $orders ?? collect();
    $orders = $orders instanceof \Illuminate\Support\Collection ? $orders : collect($orders);
    $activeOrders = $activeOrders ?? $orders->filter(fn($o) => ! in_array(strtolower($o->status ?? ''), ['completed','delivered','cancelled','canceled','refunded'], true));
    $activeOrders = $activeOrders instanceof \Illuminate\Support\Collection ? $activeOrders : collect($activeOrders);
    $readyOrders = $readyOrders ?? $orders->filter(fn($o) => in_array(strtolower($o->status ?? ''), ['ready','ready_for_pickup','shipped','out_for_delivery'], true));
    $readyOrders = $readyOrders instanceof \Illuminate\Support\Collection ? $readyOrders : collect($readyOrders);
    $savedDesigns = $savedDesigns ?? collect();
    $savedDesigns = $savedDesigns instanceof \Illuminate\Support\Collection ? $savedDesigns : collect($savedDesigns);
    $wishlistItems = $wishlistItems ?? $savedDesigns;
    $wishlistItems = $wishlistItems instanceof \Illuminate\Support\Collection ? $wishlistItems : collect($wishlistItems);
    $notifications = $notifications ?? collect();
    $notifications = $notifications instanceof \Illuminate\Support\Collection ? $notifications : collect($notifications);
    $paymentMethodsCount = $paymentMethodsCount ?? 0;

    $money = function ($value) {
        return (float) preg_replace('/[^0-9.\-]/', '', (string) ($value ?? 0));
    };
    $formatMoneyShort = function ($value) {
        $value = (float) $value;
        if ($value >= 1000000) return '₱'.number_format($value / 1000000, 1).'M';
        if ($value >= 1000) return '₱'.number_format($value / 1000, 0).'K';
        return '₱'.number_format($value, 0);
    };
    $getDate = function ($date, $format = 'M d, Y') {
        if (! $date) return null;
        try { return \Carbon\Carbon::parse($date)->format($format); }
        catch (\Throwable $e) { return null; }
    };

    $totalOrdersCount = $orders->count();
    $totalSpentAmount = $orders->sum(fn($o) => $money($o->total_amount ?? $o->total ?? 0));
    $paymentSettledOrders = $orders->filter(fn($o) => in_array(strtolower($o->payment_status ?? ''), ['paid','settled','completed'], true));
    $paymentSettledCount = $paymentSettledOrders->count();
    $paymentSettledAmount = $paymentSettledOrders->sum(fn($o) => $money($o->total_amount ?? $o->total ?? 0));
    $wishlistCount = $wishlistItems->count();
    $latestOrder = $latestOrder ?? $activeOrders->first() ?? $orders->first();

    $statusMap = [
        'pending'=>['label'=>'Pending','class'=>'status-pending'],
        'approved'=>['label'=>'Processing','class'=>'status-processing'],
        'processing'=>['label'=>'Processing','class'=>'status-processing'],
        'in_production'=>['label'=>'Processing','class'=>'status-processing'],
        'ready'=>['label'=>'Ready','class'=>'status-ready'],
        'ready_for_pickup'=>['label'=>'Ready','class'=>'status-ready'],
        'shipped'=>['label'=>'In Transit','class'=>'status-shipped'],
        'out_for_delivery'=>['label'=>'In Transit','class'=>'status-shipped'],
        'completed'=>['label'=>'Delivered','class'=>'status-delivered'],
        'delivered'=>['label'=>'Delivered','class'=>'status-delivered'],
        'cancelled'=>['label'=>'Cancelled','class'=>'status-cancelled'],
        'canceled'=>['label'=>'Cancelled','class'=>'status-cancelled'],
        'refunded'=>['label'=>'Refunded','class'=>'status-refunded'],
        'refund'=>['label'=>'Refunded','class'=>'status-refunded'],
        'partially_refunded'=>['label'=>'Refunded','class'=>'status-refunded'],
    ];

    $ordersUrl = Route::has('customer.orders.index') ? route('customer.orders.index') : '#recentOrdersCard';
    $readyOrdersUrl = Route::has('customer.orders.index') ? route('customer.orders.index', ['status'=>'shipped']) : '#recentOrdersCard';
    $paymentsUrl = Route::has('customer.payments.index') ? route('customer.payments.index') : '#recentOrdersCard';
    $settledPaymentsUrl = Route::has('customer.payments.index') ? route('customer.payments.index', ['status'=>'paid']) : $paymentsUrl;
    $newOrderUrl = Route::has('customer.orders.create') ? route('customer.orders.create') : $ordersUrl;
    $uploadUrl = Route::has('customer.files.create') ? route('customer.files.create') : (Route::has('customer.orders.create') ? route('customer.orders.create', ['upload'=>1]) : $ordersUrl);
    $wishlistUrl = Route::has('customer.wishlist.index') ? route('customer.wishlist.index') : '#';
    $supportUrl = Route::has('customer.support.index') ? route('customer.support.index') : '#';
    $supportCreateUrl = Route::has('customer.support.create') ? route('customer.support.create') : $supportUrl;
    $profileUrl = Route::has('profile.edit') ? route('profile.edit') : '#';
    $notificationsUrl = Route::has('customer.notifications.index') ? route('customer.notifications.index') : '#notificationsCard';
    $reorderUrl = Route::has('customer.orders.index') ? route('customer.orders.index', ['reorder'=>1]) : $ordersUrl;
    $quoteUrl = Route::has('customer.support.create') ? route('customer.support.create', ['topic'=>'quote']) : $supportCreateUrl;

    $statusChartData = collect([
        ['key'=>'pending','label'=>'Pending','count'=>$orders->filter(fn($o)=>strtolower($o->status ?? '')==='pending')->count(),'color'=>'var(--dash-yellow)'],
        ['key'=>'processing','label'=>'Processing','count'=>$orders->filter(fn($o)=>in_array(strtolower($o->status ?? ''), ['approved','processing','in_production'], true))->count(),'color'=>'var(--dash-orange)'],
        ['key'=>'shipped','label'=>'Shipped','count'=>$orders->filter(fn($o)=>in_array(strtolower($o->status ?? ''), ['ready','ready_for_pickup','shipped','out_for_delivery'], true))->count(),'color'=>'var(--dash-blue)'],
        ['key'=>'delivered','label'=>'Delivered','count'=>$orders->filter(fn($o)=>in_array(strtolower($o->status ?? ''), ['completed','delivered'], true))->count(),'color'=>'var(--dash-green)'],
        ['key'=>'cancelled','label'=>'Cancelled','count'=>$orders->filter(fn($o)=>in_array(strtolower($o->status ?? ''), ['cancelled','canceled'], true))->count(),'color'=>'var(--dash-red)'],
        ['key'=>'refunded','label'=>'Refunded','count'=>$orders->filter(fn($o)=>in_array(strtolower($o->status ?? ''), ['refunded','refund','partially_refunded'], true))->count(),'color'=>'var(--dash-purple)'],
    ]);
    $statusTotal = max(1, (float) $statusChartData->sum('count'));
    $donutCircumference = 100.5310;
    $donutOffset = 0;

    $paymentChartData = collect([
        ['key'=>'paid','label'=>'Paid','count'=>$paymentSettledCount,'amount'=>$paymentSettledAmount,'color'=>'var(--dash-green)'],
        ['key'=>'pending','label'=>'Pending','count'=>$orders->filter(fn($o)=>in_array(strtolower($o->payment_status ?? ''), ['pending','unpaid'], true))->count(),'amount'=>$orders->filter(fn($o)=>in_array(strtolower($o->payment_status ?? ''), ['pending','unpaid'], true))->sum(fn($o)=>$money($o->total_amount ?? $o->total ?? 0)),'color'=>'var(--dash-yellow)'],
        ['key'=>'failed','label'=>'Failed','count'=>$orders->filter(fn($o)=>in_array(strtolower($o->payment_status ?? ''), ['failed','declined'], true))->count(),'amount'=>$orders->filter(fn($o)=>in_array(strtolower($o->payment_status ?? ''), ['failed','declined'], true))->sum(fn($o)=>$money($o->total_amount ?? $o->total ?? 0)),'color'=>'var(--dash-red)'],
        ['key'=>'cancelled','label'=>'Cancelled','count'=>$orders->filter(fn($o)=>in_array(strtolower($o->payment_status ?? ''), ['cancelled','canceled'], true) || in_array(strtolower($o->status ?? ''), ['cancelled','canceled'], true))->count(),'amount'=>$orders->filter(fn($o)=>in_array(strtolower($o->payment_status ?? ''), ['cancelled','canceled'], true) || in_array(strtolower($o->status ?? ''), ['cancelled','canceled'], true))->sum(fn($o)=>$money($o->total_amount ?? $o->total ?? 0)),'color'=>'var(--dash-purple)'],
        ['key'=>'refunded','label'=>'Refunded','count'=>$orders->filter(fn($o)=>in_array(strtolower($o->payment_status ?? ''), ['refunded','refund','partially_refunded'], true) || in_array(strtolower($o->status ?? ''), ['refunded','refund','partially_refunded'], true))->count(),'amount'=>$orders->filter(fn($o)=>in_array(strtolower($o->payment_status ?? ''), ['refunded','refund','partially_refunded'], true) || in_array(strtolower($o->status ?? ''), ['refunded','refund','partially_refunded'], true))->sum(fn($o)=>$money($o->total_amount ?? $o->total ?? 0)),'color'=>'var(--dash-blue)'],
    ]);
    $paymentMax = max(1, (float) $paymentChartData->max('amount'));

    $monthKeys = collect(range(5,0))->map(fn($i)=>now()->subMonths($i)->format('Y-m'));
    $revenueChartData = $monthKeys->map(function($month) use ($orders, $money) {
        $monthOrders = $orders->filter(function($o) use ($month) {
            if (! ($o->created_at ?? null)) return false;
            try { return \Carbon\Carbon::parse($o->created_at)->format('Y-m') === $month; }
            catch (\Throwable $e) { return false; }
        });
        return [
            'key'=>$month,
            'label'=>\Carbon\Carbon::createFromFormat('Y-m', $month)->format('M'),
            'count'=>$monthOrders->count(),
            'amount'=>$monthOrders->sum(fn($o)=>$money($o->total_amount ?? $o->total ?? 0)),
        ];
    });
    $revenueMax = max(1, (float) $revenueChartData->max('amount'));
    $spendingAxisMax = 3000;
    $spendingAxisLabels = ['₱3K','₱1K','₱500','₱100','₱0'];
    $revenueTotal = $revenueChartData->sum('amount');
    $barColors = ['#5bc0de','#2563eb','#f59e0b','#16a34a','#2563eb','#14b8a6'];

    $statCards = [
        ['title'=>'Total Orders','value'=>number_format($totalOrdersCount),'note'=>'All your print orders.','url'=>$ordersUrl,'icon'=>'shopping-bag','color'=>'var(--dash-orange)','soft'=>'var(--dash-orange-soft)','link'=>'View Orders'],
        ['title'=>'Total Spent','value'=>'₱'.number_format($totalSpentAmount,2),'note'=>'Total amount spent.','url'=>$paymentsUrl,'icon'=>'wallet','color'=>'var(--dash-blue)','soft'=>'var(--dash-blue-soft)','link'=>'View Payments'],
        ['title'=>'Paid Orders','value'=>number_format($paymentSettledCount),'note'=>'Orders paid in full.','url'=>$settledPaymentsUrl,'icon'=>'check-circle','color'=>'var(--dash-green)','soft'=>'var(--dash-green-soft)','link'=>'View Payments'],
        ['title'=>'Orders In Transit','value'=>number_format($readyOrders->count()),'note'=>'Shipped or out for delivery.','url'=>$readyOrdersUrl,'icon'=>'truck','color'=>'var(--dash-purple)','soft'=>'var(--dash-purple-soft)','link'=>'Track Orders'],
        ['title'=>'Wishlist Items','value'=>number_format($wishlistCount),'note'=>'Saved for later.','url'=>$wishlistUrl,'icon'=>'heart','color'=>'var(--dash-red)','soft'=>'var(--dash-red-soft)','link'=>'View Wishlist'],
    ];

    $quickActions = [
        ['label'=>'Upload Files','url'=>$uploadUrl,'icon'=>'upload','color'=>'var(--dash-green)','soft'=>'var(--dash-green-soft)'],
        ['label'=>'Track Order','url'=>$ordersUrl,'icon'=>'package-search','color'=>'var(--dash-blue)','soft'=>'var(--dash-blue-soft)'],
        ['label'=>'Reorder','url'=>$reorderUrl,'icon'=>'rotate-ccw','color'=>'var(--dash-orange)','soft'=>'var(--dash-orange-soft)'],
        ['label'=>'Payment Methods','url'=>$paymentsUrl,'icon'=>'credit-card','color'=>'var(--dash-blue)','soft'=>'var(--dash-blue-soft)'],
        ['label'=>'Request Quote','url'=>$quoteUrl,'icon'=>'clipboard-list','color'=>'var(--dash-purple)','soft'=>'var(--dash-purple-soft)'],
    ];

    $trackingSteps = [
        'pending'=>['label'=>'Order Placed','icon'=>'check'],
        'processing'=>['label'=>'Processing','icon'=>'settings'],
        'shipped'=>['label'=>'Shipped','icon'=>'truck'],
        'out_for_delivery'=>['label'=>'In Transit','icon'=>'map-pin'],
        'delivered'=>['label'=>'Delivered','icon'=>'home'],
    ];
    $currentStatus = strtolower($latestOrder->status ?? 'pending');
    $normalizedStatus = match($currentStatus) {
        'approved','processing','in_production'=>'processing',
        'ready','ready_for_pickup','shipped'=>'shipped',
        'out_for_delivery'=>'out_for_delivery',
        'completed','delivered'=>'delivered',
        default=>'pending',
    };
    $stepKeys = array_keys($trackingSteps);
    $currentStepIndex = array_search($normalizedStatus, $stepKeys, true);
    $currentStepIndex = $currentStepIndex === false ? 0 : $currentStepIndex;
    $progressPercent = count($stepKeys) > 1 ? (($currentStepIndex) / (count($stepKeys) - 1)) * 100 : 0;
    $latestOrderUrl = $latestOrder && Route::has('customer.orders.show') ? route('customer.orders.show', $latestOrder->id) : $ordersUrl;
    $latestOrderImage = $latestOrder->thumbnail_url ?? $latestOrder->image_url ?? $latestOrder->product_image ?? $latestOrder->photo_url ?? null;
@endphp

<div class="dashboard-loader" id="dashboardLoader" aria-hidden="true">
    <div class="loader-card">
        <div class="loader-ring"></div>
        <div class="loader-text">Loading Dashboard</div>
    </div>
</div>

<div class="customer-dashboard-v2">
    <div class="dashboard-feedback" id="dashboardFeedback" role="status" aria-live="polite">
        <i data-lucide="check-circle" size="15"></i>
        <span>Dashboard ready.</span>
    </div>
    <div class="dashboard-shell">
        <div class="dashboard-header-row reveal-card" style="--delay:0ms">
            <div class="overview-title-wrap">
                <div>
                    <h2 class="overview-kicker">Dashboard Overview</h2>
                    <p class="overview-copy">Here’s what’s happening with your account.</p>
                </div>
            </div>
            <div class="header-actions">
                <button type="button" class="date-pill calendar-toggle" id="customerCalendarToggle" aria-haspopup="dialog" aria-controls="customerCalendarOverlay" aria-expanded="false"><i data-lucide="calendar-days" size="16"></i><span id="customerCalendarToggleText">Today is {{ now()->format('M d, Y') }}</span></button>
            </div>
        </div>

        <div class="dashboard-calendar-overlay" id="customerCalendarOverlay" aria-hidden="true">
            <section class="dashboard-calendar-modal" role="dialog" aria-modal="true" aria-labelledby="customerCalendarTitle">
                <div class="calendar-main">
                    <div class="calendar-modal-head">
                        <div>
                            <h3 class="calendar-title" id="customerCalendarTitle">Customer Calendar</h3>
                            <p class="calendar-subtitle">Select dates and manage your customer reminders.</p>
                        </div>

                        <div class="calendar-nav">
                            <button type="button" class="calendar-icon-btn" id="calendarPrevMonth" aria-label="Previous month">
                                <i data-lucide="chevron-left" size="16"></i>
                            </button>

                            <button type="button" class="calendar-action-btn" id="calendarTodayBtn">Today</button>

                            <button type="button" class="calendar-icon-btn" id="calendarNextMonth" aria-label="Next month">
                                <i data-lucide="chevron-right" size="16"></i>
                            </button>

                            <button type="button" class="calendar-icon-btn calendar-close-x" id="calendarCloseBtn" aria-label="Close calendar">
                                <i data-lucide="x" size="17"></i>
                            </button>
                        </div>
                    </div>

                    <div class="calendar-month-row">
                        <h4 class="calendar-month-title" id="calendarMonthLabel"></h4>

                        <button type="button" class="calendar-use-date-btn" id="calendarUseDateBtn">
                            <i data-lucide="check" size="14"></i>
                            Use Date
                        </button>
                    </div>

                    <div class="calendar-weekdays" aria-hidden="true">
                        <span>Sun</span>
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                    </div>

                    <div class="calendar-grid" id="customerCalendarGrid"></div>
                </div>

                <aside class="calendar-side">
                    <div class="calendar-side-inner">
                        <div class="calendar-side-title">Selected Date</div>

                        <div class="selected-date-card">
                            <div class="selected-date-icon">
                                <i data-lucide="calendar-days" size="18"></i>
                            </div>

                            <div>
                                <h4 class="calendar-selected-date" id="calendarSelectedDateLabel"></h4>
                                <p>Add details for your reminder or event on this date.</p>
                            </div>
                        </div>

                        <form class="calendar-form" id="calendarEventForm">
                            <input type="hidden" id="calendarEventId">

                            <div class="calendar-field">
                                <label for="calendarEventTitle">Event / Reminder</label>
                                <input type="text" id="calendarEventTitle" maxlength="80" placeholder="Example: Follow up call with customer" required>
                            </div>

                            <div class="calendar-field">
                                <label for="calendarEventTime">Time</label>
                                <div class="calendar-time-wrap">
                                    <input type="time" id="calendarEventTime">
                                </div>
                            </div>

                            <div class="calendar-field">
                                <label for="calendarEventNote">Note (Optional)</label>
                                <textarea id="calendarEventNote" maxlength="180" placeholder="Add any notes or details about this reminder..."></textarea>
                            </div>

                            <div class="calendar-info-box">
                                <i data-lucide="info" size="17"></i>
                                <span>Your reminder will be saved and visible in your calendar and customer timeline.</span>
                            </div>

                            <div class="calendar-event-list" id="calendarEventList"></div>

                            <div class="calendar-form-actions">
                                <button type="button" class="calendar-clear-btn" id="calendarClearFormBtn">Cancel</button>
                                <button type="submit" class="calendar-save-btn" id="calendarSaveBtn">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </aside>
            </section>
        </div>

        <div class="dashboard-board">
            <main class="left-column" aria-label="Customer dashboard main content">
                <section class="analytics-grid" aria-label="Account analytics">
                    <article class="card chart-card reveal-card" style="--delay:60ms;--chart-color:var(--dash-orange);--chart-soft:var(--dash-orange-soft)" aria-label="Order Status Summary">
                        <div class="card-head">
                            <div class="card-title-group">
                                <h3 class="card-title">Order Status Summary</h3>
                                <p class="card-subtitle">Breakdown of your orders by status.</p>
                            </div>
                        </div>
                        <div class="status-chart-layout">
                            <div class="donut-wrap">
                                <svg class="donut-svg" viewBox="0 0 100 100" role="img" aria-label="Order status donut chart">
                                    <circle class="donut-base" cx="50" cy="50" r="16"></circle>
                                    @foreach($statusChartData as $status)
                                        @php
                                            $slice = (((float) $status['count']) / $statusTotal) * $donutCircumference;
                                            $dash = max(0, $slice - .32);
                                            $gap = $donutCircumference - $dash;
                                            $offset = -$donutOffset;
                                            $donutOffset += $slice;
                                        @endphp
                                        <circle class="donut-slice js-filter-trigger" cx="50" cy="50" r="16" data-filter-type="status" data-filter-value="{{ $status['key'] }}" style="--slice-color:{{ $status['color'] }};--dash-slice:{{ number_format($dash,4,'.','') }};--dash-gap:{{ number_format($gap,4,'.','') }};--slice-offset:{{ number_format($offset,4,'.','') }};--slice-delay:{{ 130 + ($loop->index * 90) }}ms"></circle>
                                    @endforeach
                                </svg>
                                <div class="donut-center">
                                    <span><span class="donut-number">{{ number_format($totalOrdersCount) }}</span><span class="donut-label">Total Orders</span></span>
                                </div>
                            </div>
                            <div class="legend-list">
                                @foreach($statusChartData as $status)
                                    @php $percent = $statusTotal > 0 ? (($status['count'] / $statusTotal) * 100) : 0; @endphp
                                    <button type="button" class="legend-button js-filter-trigger" data-filter-type="status" data-filter-value="{{ $status['key'] }}" style="--legend-color:{{ $status['color'] }}">
                                        <span class="legend-dot"></span>
                                        <span class="legend-name">{{ $status['label'] }}</span>
                                        <span class="legend-meta">{{ $status['count'] }} ({{ number_format($percent,1) }}%)</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <article class="card chart-card reveal-card" style="--delay:120ms;--chart-color:var(--dash-green);--chart-soft:var(--dash-green-soft)" aria-label="My Payments">
                        <div class="card-head">
                            <div class="card-title-group">
                                <h3 class="card-title">My Payments</h3>
                                <p class="card-subtitle">Overview of your paid, pending, failed, cancelled, and refunded payments.</p>
                            </div>
                            <button type="button" class="select-chip js-filter-trigger" data-filter-type="payment" data-filter-value="paid">This Month</button>
                        </div>
                        <div class="payment-list">
                            @foreach($paymentChartData as $payment)
                                @php $width = max(8, ((float) $payment['amount'] / $paymentMax) * 100); @endphp
                                <button type="button" class="payment-row js-filter-trigger" data-filter-type="payment" data-filter-value="{{ $payment['key'] }}">
                                    <span class="payment-label">{{ $payment['label'] }}</span>
                                    <span class="payment-track"><span class="payment-fill" style="--bar-color:{{ $payment['color'] }};--bar-width:{{ number_format($width,4,'.','') }}%;--bar-delay:{{ 130 + ($loop->index * 100) }}ms"></span></span>
                                    <span class="payment-value">₱{{ number_format($payment['amount'],2) }}</span>
                                </button>
                            @endforeach
                        </div>
                        <div class="payment-total">Total Paid <strong>₱{{ number_format($paymentSettledAmount,2) }}</strong></div>
                    </article>

                    <article class="card chart-card reveal-card" style="--delay:180ms;--chart-color:var(--dash-blue);--chart-soft:var(--dash-blue-soft)" aria-label="Monthly Spending">
                        <div class="card-head">
                            <div class="card-title-group">
                                <h3 class="card-title">Monthly Spending</h3>
                                <p class="card-subtitle">Your spending movement by month.</p>
                            </div>
                            <button type="button" class="select-chip js-filter-trigger" data-filter-type="month" data-filter-value="{{ now()->format('Y-m') }}">This Year</button>
                        </div>
                        <div class="revenue-chart">
                            <div class="revenue-axis">@foreach($spendingAxisLabels as $axisLabel)<span>{{ $axisLabel }}</span>@endforeach</div>
                            <div class="revenue-bars">
                                @foreach($revenueChartData as $month)
                                    @php
                                        $height = max(7, min(100, ((float) $month['amount'] / $spendingAxisMax) * 100));
                                        $barColor = $barColors[$loop->index % count($barColors)];
                                    @endphp
                                    <button type="button" class="revenue-bar-button js-filter-trigger" data-filter-type="month" data-filter-value="{{ $month['key'] }}" style="--bar-height:{{ number_format($height,4,'.','') }}%">
                                        <span class="bar-value">{{ $formatMoneyShort($month['amount']) }}</span>
                                        <span class="revenue-fill" style="--bar-color:{{ $barColor }};--bar-delay:{{ 120 + ($loop->index * 90) }}ms"></span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <div class="revenue-labels"><span class="revenue-label-spacer"></span><div class="month-labels">@foreach($revenueChartData as $month)<span>{{ $month['label'] }}</span>@endforeach</div></div>
                        <div class="revenue-total">Total Spending <strong>₱{{ number_format($revenueTotal,2) }}</strong></div>
                    </article>
                </section>

                <section class="stats-grid" aria-label="Account summary cards">
                    @foreach($statCards as $stat)
                        <a href="{{ $stat['url'] }}" class="card stat-card reveal-card" style="--delay:{{ 240 + ($loop->index * 55) }}ms;--stat-color:{{ $stat['color'] }};--stat-soft:{{ $stat['soft'] }}">
                            <div class="stat-top">
                                <div class="stat-icon"><i data-lucide="{{ $stat['icon'] }}" size="18"></i></div>
                                <div class="stat-title">{{ $stat['title'] }}</div>
                            </div>
                            <div class="stat-value">{{ $stat['value'] }}</div>
                            <div class="stat-note">{{ $stat['note'] }}</div>
                            <div class="stat-link">{{ $stat['link'] }}</div>
                        </a>
                    @endforeach
                </section>

                <section class="content-grid" aria-label="Orders and tracking">
                    <article class="card latest-card reveal-card" style="--delay:520ms" aria-label="Latest Order Tracking">
                        <div class="panel-head">
                            <div>
                                <h3 class="card-title">Latest Order Tracking</h3>
                                <p class="card-subtitle">Your most recent active print job.</p>
                            </div>
                            @if($latestOrder)
                                @php
                                    $latestStatus = $statusMap[strtolower($latestOrder->status ?? 'pending')] ?? ['label'=>ucfirst(str_replace('_',' ', $latestOrder->status ?? 'Pending')),'class'=>'status-pending'];
                                @endphp
                                <span class="status-pill {{ $latestStatus['class'] }}">{{ $latestStatus['label'] }}</span>
                            @endif
                        </div>
                        @if($latestOrder)
                            <div class="latest-body">
                                <a href="{{ $latestOrderUrl }}" class="latest-thumb" aria-label="Open latest order">
                                    @if($latestOrderImage)
                                        <img src="{{ $latestOrderImage }}" alt="{{ $latestOrder->product_name ?? $latestOrder->project_name ?? 'Latest order' }}">
                                    @else
                                        <i data-lucide="image" size="32"></i>
                                    @endif
                                </a>
                                <div class="latest-info">
                                    <div class="latest-title">Order #{{ $latestOrder->order_number ?? $latestOrder->id }}</div>
                                    <div class="latest-meta">{{ $latestOrder->product_name ?? $latestOrder->project_name ?? 'Print Job' }}<br>{{ $getDate($latestOrder->created_at ?? null) ?? 'Date unavailable' }} · ₱{{ number_format($money($latestOrder->total_amount ?? $latestOrder->total ?? 0),2) }}</div>
                                    <div class="tracking-line" style="--progress-width:{{ number_format($progressPercent,4,'.','') }}%"></div>
                                    <div class="timeline-grid">
                                        @foreach($trackingSteps as $key => $step)
                                            @php
                                                $stepIndex = array_search($key, $stepKeys, true);
                                                $nodeClass = $stepIndex < $currentStepIndex ? 'done' : ($stepIndex === $currentStepIndex ? 'active' : '');
                                            @endphp
                                            <div class="timeline-node {{ $nodeClass }}">
                                                <span class="timeline-dot"><i data-lucide="{{ $stepIndex <= $currentStepIndex ? 'check' : $step['icon'] }}" size="10"></i></span>
                                                <span class="timeline-name">{{ $step['label'] }}</span>
                                                <span class="timeline-date">{{ $stepIndex <= $currentStepIndex ? ($getDate($latestOrder->updated_at ?? $latestOrder->created_at ?? null, 'M d') ?? 'Done') : 'Est.' }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="latest-actions">
                                        <a href="{{ $latestOrderUrl }}" class="tiny-button primary">Track This Order</a>
                                        <a href="{{ $supportCreateUrl }}" class="tiny-button">Get Support</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <div>
                                    <i data-lucide="shopping-bag" size="42"></i>
                                    <div class="empty-title">No active order yet.</div>
                                    <div class="empty-text">Create your first print job to start tracking.</div>
                                    <br><a href="{{ $newOrderUrl }}" class="primary-button">Create Order</a>
                                </div>
                            </div>
                        @endif
                    </article>

                    <article class="card recent-card reveal-card" id="recentOrdersCard" style="--delay:580ms" aria-label="Recent Orders">
                        <div class="panel-head">
                            <div>
                                <h3 class="card-title">Recent Orders</h3>
                                <p class="card-subtitle" id="filterLabel">Showing all recent orders.</p>
                            </div>
                            <div style="display:flex;gap:8px;align-items:center">
                                <button type="button" class="clear-filter-btn is-hidden" id="clearFilters">Clear</button>
                                <a href="{{ $ordersUrl }}" class="view-all-link">View All<i data-lucide="arrow-right" size="13"></i></a>
                            </div>
                        </div>
                        <div class="recent-table-wrap">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Product</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="ordersTableBody">
                                    @forelse($orders->take(6) as $order)
                                        @php
                                            $orderStatusKey = strtolower($order->status ?? 'pending');
                                            $filterStatusKey = match($orderStatusKey) {
                                                'approved','processing','in_production'=>'processing',
                                                'ready','ready_for_pickup','shipped','out_for_delivery'=>'shipped',
                                                'completed','delivered'=>'delivered',
                                                'cancelled','canceled'=>'cancelled',
                                                'refunded','refund','partially_refunded'=>'refunded',
                                                default=>$orderStatusKey,
                                            };
                                            $paymentStatusKey = strtolower($order->payment_status ?? 'pending');
                                            $orderStatus = $statusMap[$orderStatusKey] ?? ['label'=>ucfirst(str_replace('_',' ', $orderStatusKey)),'class'=>'status-pending'];
                                            $orderShowUrl = Route::has('customer.orders.show') ? route('customer.orders.show', $order->id) : $ordersUrl;
                                            $orderMonth = $getDate($order->created_at ?? null, 'Y-m') ?? '';
                                            $orderDate = $getDate($order->created_at ?? null) ?? 'No date';
                                        @endphp
                                        <tr class="js-order-row" data-status="{{ $filterStatusKey }}" data-payment="{{ $paymentStatusKey }}" data-month="{{ $orderMonth }}">
                                            <td class="order-id">#{{ $order->order_number ?? $order->id }}</td>
                                            <td>{{ $orderDate }}</td>
                                            <td><span class="status-pill {{ $orderStatus['class'] }}">{{ $orderStatus['label'] }}</span></td>
                                            <td class="product-name">{{ $order->product_name ?? $order->project_name ?? 'Print Job' }}</td>
                                            <td class="amount-cell">₱{{ number_format($money($order->total_amount ?? $order->total ?? 0),2) }}</td>
                                            <td style="text-align:center"><a href="{{ $orderShowUrl }}" class="view-button">View</a></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6"><div class="empty-state"><div><i data-lucide="inbox" size="38"></i><div class="empty-title">No orders yet.</div><div class="empty-text">Start a new print job to see it here.</div></div></div></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="empty-state is-hidden" id="filterEmptyState"><div><i data-lucide="search-x" size="38"></i><div class="empty-title">No orders match this filter.</div><div class="empty-text">Clear the filter or view all orders.</div></div></div>
                        </div>
                    </article>
                </section>
            </main>


        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('dashboardLoader');
    setTimeout(() => loader?.classList.add('is-hidden'), 420);

    const bootIcons = () => { if (window.lucide) window.lucide.createIcons(); };
    bootIcons();

    const $ = (selector, root = document) => root.querySelector(selector);
    const $$ = (selector, root = document) => Array.from(root.querySelectorAll(selector));
    const rows = $$('.js-order-row');
    const filterButtons = $$('.js-filter-trigger'), chartCards = $$('.chart-card'), statCards = $$('.stat-card');
    const clearButton = $('#clearFilters');
    const emptyState = $('#filterEmptyState');
    const filterLabel = $('#filterLabel');
    const recentOrdersCard = $('#recentOrdersCard');
    const dashboardFeedback = $('#dashboardFeedback');
    const clean = value => String(value || '').toLowerCase().trim();

    function showDashboardFeedback(message) {
        if (!dashboardFeedback) return;
        const label = dashboardFeedback.querySelector('span');
        if (label) label.textContent = message;
        dashboardFeedback.classList.add('is-visible');
        clearTimeout(window.customerDashboardFeedbackTimer);
        window.customerDashboardFeedbackTimer = setTimeout(() => dashboardFeedback.classList.remove('is-visible'), 2200);
    }

    const calendarStorageKey = @json('customer_dashboard_calendar_events_' . ($customer->id ?? 'guest'));
    const calendarToggle = $('#customerCalendarToggle');
    const calendarToggleText = $('#customerCalendarToggleText');
    const calendarOverlay = $('#customerCalendarOverlay');
    const calendarCloseBtn = $('#calendarCloseBtn');
    const calendarPrevMonth = $('#calendarPrevMonth');
    const calendarNextMonth = $('#calendarNextMonth');
    const calendarTodayBtn = $('#calendarTodayBtn');
    const calendarUseDateBtn = $('#calendarUseDateBtn');
    const calendarGrid = $('#customerCalendarGrid');
    const calendarMonthLabel = $('#calendarMonthLabel');
    const calendarSelectedDateLabel = $('#calendarSelectedDateLabel');
    const calendarEventList = $('#calendarEventList');
    const calendarEventForm = $('#calendarEventForm');
    const calendarEventId = $('#calendarEventId');
    const calendarEventTitle = $('#calendarEventTitle');
    const calendarEventTime = $('#calendarEventTime');
    const calendarEventNote = $('#calendarEventNote');
    const calendarClearFormBtn = $('#calendarClearFormBtn');
    const calendarSaveBtn = $('#calendarSaveBtn');
    const datePad = value => String(value).padStart(2, '0');
    const dateKey = date => `${date.getFullYear()}-${datePad(date.getMonth() + 1)}-${datePad(date.getDate())}`;
    const sameDate = (a, b) => dateKey(a) === dateKey(b);
    const calendarFormat = (date, options = {}) => date.toLocaleDateString('en-US', options);
    const calendarFormatLong = date => calendarFormat(date, {weekday:'long', month:'long', day:'numeric', year:'numeric'});
    const calendarFormatShort = date => calendarFormat(date, {month:'short', day:'numeric', year:'numeric'});
    const calendarFormatMonth = date => calendarFormat(date, {month:'long', year:'numeric'});
    let calendarEvents = [];
    let calendarToday = new Date();
    let calendarSelectedDate = new Date(calendarToday.getFullYear(), calendarToday.getMonth(), calendarToday.getDate());
    let calendarViewDate = new Date(calendarSelectedDate.getFullYear(), calendarSelectedDate.getMonth(), 1);

    function loadCalendarEvents() {
        try {
            const saved = JSON.parse(localStorage.getItem(calendarStorageKey) || '[]');
            calendarEvents = Array.isArray(saved) ? saved.filter(item => item && item.date && item.title) : [];
        } catch (error) {
            calendarEvents = [];
        }
    }

    function saveCalendarEvents() {
        localStorage.setItem(calendarStorageKey, JSON.stringify(calendarEvents));
    }

    function openCalendar() {
        calendarOverlay?.classList.add('is-open');
        calendarOverlay?.setAttribute('aria-hidden', 'false');
        calendarToggle?.setAttribute('aria-expanded', 'true');
        renderCalendar();
        showDashboardFeedback('Calendar opened.');
        setTimeout(() => calendarGrid?.querySelector('.calendar-day.is-selected')?.focus(), 40);
    }

    function closeCalendar() {
        calendarOverlay?.classList.remove('is-open');
        calendarOverlay?.setAttribute('aria-hidden', 'true');
        calendarToggle?.setAttribute('aria-expanded', 'false');
        calendarToggle?.focus();
    }

    function eventsForDate(key) {
        return calendarEvents.filter(item => item.date === key).sort((a, b) => String(a.time || '').localeCompare(String(b.time || '')));
    }

    function clearCalendarForm() {
        if (calendarEventId) calendarEventId.value = '';
        if (calendarEventTitle) calendarEventTitle.value = '';
        if (calendarEventTime) calendarEventTime.value = '';
        if (calendarEventNote) calendarEventNote.value = '';
        if (calendarSaveBtn) calendarSaveBtn.textContent = 'Save Changes';
    }

    function renderEventList() {
        if (!calendarEventList || !calendarSelectedDateLabel) return;
        const selectedKey = dateKey(calendarSelectedDate);
        const selectedEvents = eventsForDate(selectedKey);
        calendarSelectedDateLabel.textContent = calendarFormatLong(calendarSelectedDate);
        calendarEventList.innerHTML = '';

        if (!selectedEvents.length) {
            const empty = document.createElement('div');
            empty.className = 'calendar-empty';
            empty.textContent = 'No reminders yet for this date.';
            calendarEventList.appendChild(empty);
            return;
        }

        selectedEvents.forEach(eventItem => {
            const eventCard = document.createElement('div');
            eventCard.className = 'calendar-event-item';

            const title = document.createElement('div');
            title.className = 'calendar-event-title';
            title.textContent = eventItem.title;

            const meta = document.createElement('div');
            meta.className = 'calendar-event-meta';
            meta.textContent = eventItem.time ? `Time: ${eventItem.time}` : 'No time set';

            const note = document.createElement('div');
            note.className = 'calendar-event-note';
            note.textContent = eventItem.note || 'No note added.';

            const actions = document.createElement('div');
            actions.className = 'calendar-event-actions';

            const editBtn = document.createElement('button');
            editBtn.type = 'button';
            editBtn.className = 'calendar-mini-btn';
            editBtn.textContent = 'Edit';
            editBtn.addEventListener('click', () => {
                if (calendarEventId) calendarEventId.value = eventItem.id;
                if (calendarEventTitle) calendarEventTitle.value = eventItem.title;
                if (calendarEventTime) calendarEventTime.value = eventItem.time || '';
                if (calendarEventNote) calendarEventNote.value = eventItem.note || '';
                if (calendarSaveBtn) calendarSaveBtn.textContent = 'Update';
                calendarEventTitle?.focus();
            });

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'calendar-mini-btn danger';
            deleteBtn.textContent = 'Delete';
            deleteBtn.addEventListener('click', () => {
                calendarEvents = calendarEvents.filter(item => item.id !== eventItem.id);
                saveCalendarEvents();
                clearCalendarForm();
                renderCalendar();
                showDashboardFeedback('Reminder deleted.');
            });

            actions.append(editBtn, deleteBtn);
            eventCard.append(title, meta, note, actions);
            calendarEventList.appendChild(eventCard);
        });
    }

    function renderCalendar() {
        if (!calendarGrid || !calendarMonthLabel) return;
        const year = calendarViewDate.getFullYear();
        const month = calendarViewDate.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startOffset = firstDay.getDay();
        const totalCells = 35;

        calendarMonthLabel.textContent = calendarFormatMonth(calendarViewDate);
        calendarGrid.innerHTML = '';

        for (let index = 0; index < totalCells; index++) {
            const dayNumber = index - startOffset + 1;
            const cell = document.createElement('button');
            cell.type = 'button';
            cell.className = 'calendar-day';

            if (dayNumber < 1 || dayNumber > lastDay.getDate()) {
                cell.classList.add('is-muted');
                cell.setAttribute('tabindex', '-1');
                cell.disabled = true;
                calendarGrid.appendChild(cell);
                continue;
            }

            const cellDate = new Date(year, month, dayNumber);
            const cellKey = dateKey(cellDate);
            const dayEvents = eventsForDate(cellKey);
            cell.setAttribute('aria-label', `${calendarFormatLong(cellDate)}${dayEvents.length ? `, ${dayEvents.length} reminder${dayEvents.length > 1 ? 's' : ''}` : ''}`);
            cell.classList.toggle('is-today', sameDate(cellDate, calendarToday));
            cell.classList.toggle('is-selected', sameDate(cellDate, calendarSelectedDate));

            const number = document.createElement('span');
            number.className = 'calendar-day-number';
            number.textContent = dayNumber;

            const eventWrap = document.createElement('span');
            eventWrap.className = 'calendar-day-events';
            dayEvents.slice(0, 3).forEach(() => {
                const dot = document.createElement('span');
                dot.className = 'calendar-event-dot';
                eventWrap.appendChild(dot);
            });
            if (dayEvents.length > 3) {
                const more = document.createElement('span');
                more.className = 'calendar-more';
                more.textContent = `+${dayEvents.length - 3}`;
                eventWrap.appendChild(more);
            }

            cell.append(number, eventWrap);
            cell.addEventListener('click', () => {
                calendarSelectedDate = cellDate;
                clearCalendarForm();
                renderCalendar();
            });
            calendarGrid.appendChild(cell);
        }

        renderEventList();
        if (window.lucide) window.lucide.createIcons();
    }

    calendarToggle?.addEventListener('click', openCalendar);
    calendarCloseBtn?.addEventListener('click', closeCalendar);
    calendarOverlay?.addEventListener('click', event => { if (event.target === calendarOverlay) closeCalendar(); });
    calendarPrevMonth?.addEventListener('click', () => { calendarViewDate = new Date(calendarViewDate.getFullYear(), calendarViewDate.getMonth() - 1, 1); renderCalendar(); });
    calendarNextMonth?.addEventListener('click', () => { calendarViewDate = new Date(calendarViewDate.getFullYear(), calendarViewDate.getMonth() + 1, 1); renderCalendar(); });
    calendarTodayBtn?.addEventListener('click', () => {
        calendarToday = new Date();
        calendarSelectedDate = new Date(calendarToday.getFullYear(), calendarToday.getMonth(), calendarToday.getDate());
        calendarViewDate = new Date(calendarSelectedDate.getFullYear(), calendarSelectedDate.getMonth(), 1);
        clearCalendarForm();
        renderCalendar();
    });
    calendarUseDateBtn?.addEventListener('click', () => {
        if (calendarToggleText) calendarToggleText.textContent = `Selected ${calendarFormatShort(calendarSelectedDate)}`;
        showDashboardFeedback('Dashboard date selected.');
        closeCalendar();
    });
    calendarClearFormBtn?.addEventListener('click', clearCalendarForm);
    calendarEventForm?.addEventListener('submit', event => {
        event.preventDefault();
        const title = String(calendarEventTitle?.value || '').trim();
        if (!title) {
            calendarEventTitle?.focus();
            return;
        }
        const selectedKey = dateKey(calendarSelectedDate);
        const existingId = String(calendarEventId?.value || '').trim();
        const payload = {
            id: existingId || `evt-${Date.now()}-${Math.random().toString(16).slice(2)}`,
            date: selectedKey,
            title,
            time: String(calendarEventTime?.value || '').trim(),
            note: String(calendarEventNote?.value || '').trim(),
            updated_at: new Date().toISOString()
        };

        if (existingId) calendarEvents = calendarEvents.map(item => item.id === existingId ? {...item, ...payload} : item);
        else calendarEvents.push(payload);

        saveCalendarEvents();
        clearCalendarForm();
        renderCalendar();
        showDashboardFeedback(existingId ? 'Reminder updated.' : 'Reminder saved.');
    });
    document.addEventListener('keydown', event => { if (event.key === 'Escape' && calendarOverlay?.classList.contains('is-open')) closeCalendar(); });
    loadCalendarEvents();

        const statusGroups = {
        pending:['pending'],
        processing:['processing','approved','in_production'],
        shipped:['shipped','ready','ready_for_pickup','out_for_delivery'],
        delivered:['delivered','completed'],
        cancelled:['cancelled','canceled'],
        refunded:['refunded','refund','partially_refunded']
    };
    const paymentGroups = {
        paid:['paid','settled','completed'],
        pending:['pending','unpaid'],
        failed:['failed','declined'],
        cancelled:['cancelled','canceled'],
        refunded:['refunded','refund','partially_refunded']
    };

    const labels = {
        status:{pending:'Pending orders',processing:'Processing orders',shipped:'Shipped / transit orders',delivered:'Delivered orders',cancelled:'Cancelled orders',refunded:'Refunded orders'},
        payment:{paid:'Paid payments',pending:'Pending payments',failed:'Failed payments',cancelled:'Cancelled payments',refunded:'Refunded payments'},
        month:{}
    };

    let activeType = '';
    let activeValue = '';

    function scrollToOrders() {
        if (!recentOrdersCard) return;
        window.scrollTo({top:recentOrdersCard.getBoundingClientRect().top + window.pageYOffset - 18,behavior:'smooth'});
    }

    function setActiveButtons() {
        filterButtons.forEach(button => { const isActive = clean(button.dataset.filterType) === activeType && clean(button.dataset.filterValue) === activeValue; button.classList.toggle('is-active', isActive); button.setAttribute('aria-pressed', isActive ? 'true' : 'false'); });
        chartCards.forEach(card => { const cardActive = !!activeType && $$('.js-filter-trigger', card).some(button => clean(button.dataset.filterType) === activeType && clean(button.dataset.filterValue) === activeValue); card.classList.toggle('is-active', cardActive); });
    }

    function filterRows() {
        let visible = 0;
        const statusList = activeType === 'status' ? (statusGroups[activeValue] || [activeValue]) : [];
        const paymentList = activeType === 'payment' ? (paymentGroups[activeValue] || [activeValue]) : [];

        rows.forEach(row => {
            const status = clean(row.dataset.status);
            const payment = clean(row.dataset.payment);
            const month = clean(row.dataset.month);
            const showStatus = activeType !== 'status' || statusList.includes(status) || status === activeValue;
            const showPayment = activeType !== 'payment' || paymentList.includes(payment) || payment === activeValue;
            const showMonth = activeType !== 'month' || month === activeValue;
            const shouldShow = showStatus && showPayment && showMonth;
            row.classList.toggle('is-hidden', !shouldShow);
            if (shouldShow) visible++;
        });

        if (emptyState) emptyState.classList.toggle('is-hidden', !(rows.length > 0 && visible === 0));
        if (clearButton) clearButton.classList.toggle('is-hidden', !activeType);
        if (filterLabel) {
            if (!activeType) filterLabel.textContent = 'Showing all recent orders.';
            else if (activeType === 'month') filterLabel.textContent = 'Filtered by selected spending month.';
            else filterLabel.textContent = labels[activeType]?.[activeValue] || 'Filtered recent orders.';
        }
        setActiveButtons();
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            const type = clean(this.dataset.filterType);
            const value = clean(this.dataset.filterValue);
            if (activeType === type && activeValue === value) {
                activeType = '';
                activeValue = '';
            } else {
                activeType = type;
                activeValue = value;
            }
            filterRows();
            showDashboardFeedback(activeType ? 'Recent orders filtered.' : 'Recent order filter cleared.');
            scrollToOrders();
        });
        button.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                this.click();
            }
        });
    });

    clearButton?.addEventListener('click', function () {
        activeType = '';
        activeValue = '';
        filterRows();
        showDashboardFeedback('Showing all recent orders.');
    });

    statCards.forEach(card => card.addEventListener('click', function () { statCards.forEach(item => item.classList.remove('is-active')); this.classList.add('is-active'); showDashboardFeedback(`${this.querySelector('.stat-title')?.textContent || 'Summary'} opened.`); }));

    $$('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (event) {
            const id = this.getAttribute('href');
            if (!id || id === '#') return;
            const target = document.querySelector(id);
            if (!target) return;
            event.preventDefault();
            window.scrollTo({top:target.getBoundingClientRect().top + window.pageYOffset - 18,behavior:'smooth'});
        });
    });

    filterRows();
});
</script>
</x-app-layout>
