<x-app-layout>
@once
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700&display=swap">
@endonce

<style>
:root{--hc-orange:#FE7B09;--hc-orange2:#FFAB0A;--hc-ink:#111827;--hc-muted:#6b7280;--hc-line:#111827;--hc-soft:#fff;--hc-hover:rgba(17,24,39,.075);--hc-shadow:none;--hc-shadow2:none;--hc-radius:8px;--hc-green:#16a34a;--hc-blue:#2563eb;--hc-purple:#7c3aed;--hc-red:#ef4444}
.hc-page{min-height:calc(100vh - 70px);background:#fff;color:var(--hc-ink);font-family:'Inter',system-ui,sans-serif;font-weight:400;letter-spacing:0}
.hc-wrap{max-width:1490px;margin:0 auto;background:#fff}
.hc-title{margin:0;font-family:'Playfair Display',Georgia,serif;font-size:40px;font-weight:700;line-height:1.2;letter-spacing:-.02em;color:#111827}.hc-sub{margin:4px 0 0;color:var(--hc-muted);font-size:12px;line-height:1.45}
.hc-grid{display:grid;grid-template-columns:minmax(0,1fr) 350px;gap:18px;align-items:start}.hc-stack{display:grid;gap:18px}.hc-main-stack{display:grid;gap:12px}
.hc-card{background:#fff;border:1px solid #e4e7ec;border-radius:var(--hc-radius);box-shadow:none;transition:background .18s ease,border-color .18s ease;overflow:hidden}.hc-card:hover{background:#fff;box-shadow:none;border-color:#d7dce3}.hc-body{padding:13px 16px}.hc-card-title{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:14.5px;font-weight:600;letter-spacing:.022em;line-height:1.35;color:#111827}.hc-card-desc{margin:5px 0 0;color:var(--hc-muted);font-size:11.5px;line-height:1.5}
.hc-hero{display:grid;grid-template-columns:44px minmax(0,1fr);gap:13px;align-items:start}.hc-hero-icon,.hc-icon{width:34px;height:34px;border-radius:0;background:transparent;color:var(--hc-orange);display:grid;place-items:center;flex:0 0 auto}.hc-icon{width:32px;height:32px}.hc-icon.green{background:transparent;color:var(--hc-green)}.hc-icon.purple{background:transparent;color:var(--hc-purple)}.hc-icon.blue{background:transparent;color:var(--hc-blue)}
.hc-search-row{position:relative;margin-top:12px;margin-bottom:18px;width:min(100%,650px);background:transparent!important;border:0!important;padding:0!important;overflow:visible}.hc-search-row:focus-within{box-shadow:none!important}.hc-search-left-icon{pointer-events:none;position:absolute;inset-block:0;left:0;display:flex;align-items:center;padding-left:24px;color:#9ca3af;z-index:2}.hc-search-left-icon svg{width:16px;height:16px;display:block}.hc-search-left-icon svg path{fill:#9ca3af}.hc-search-input{width:100%;height:42px;border:1px solid #000!important;border-radius:999px!important;background:#fff!important;color:#000!important;padding:8px 24px 8px 64px!important;font-size:16px!important;font-weight:500;line-height:1.2;outline:0;box-shadow:none!important}.hc-search-input::placeholder{color:#6b7280!important}.hc-search-input:focus{border-color:#000!important;background:#fff!important;color:#000!important}.hc-search-icon{display:none!important}.hc-chip-row{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}.hc-chip{height:34px;border:0;border-radius:999px;background:linear-gradient(90deg,var(--hc-orange),var(--hc-orange2));color:#111827;padding:0 15px;font-size:11px;font-weight:500;cursor:pointer;transition:background .18s ease,color .18s ease,box-shadow .18s ease}.hc-chip:hover,.hc-chip:focus{background:#111827!important;color:#fff!important;outline:0;box-shadow:0 12px 24px rgba(17,24,39,.16)}
.hc-category-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}.hc-category{min-height:88px;border:1px solid #dfe3ea;border-radius:8px;background:#fff;padding:12px;display:grid;grid-template-columns:34px minmax(0,1fr) 14px;gap:10px;align-items:center;text-align:left;cursor:pointer;transition:background .18s ease,border-color .18s ease,box-shadow .18s ease}.hc-category:hover,.hc-category:focus{background:var(--hc-hover);border-color:#cfd5dd;box-shadow:inset 0 0 0 1px rgba(17,24,39,.02);outline:0}.hc-category strong{display:block;font-family:'Poppins',system-ui,sans-serif;font-size:12px;font-weight:600;color:#111827}.hc-category small{display:block;margin-top:3px;color:#6b7280;font-size:10.5px;line-height:1.35}.hc-category em{display:block;margin-top:8px;color:#111827;font-style:normal;font-size:10px;font-weight:700}
.hc-list{display:grid;gap:0}.hc-article,.hc-support,.hc-announcement,.hc-shortcut,.hc-ticket{display:grid;grid-template-columns:auto minmax(0,1fr) auto;gap:12px;align-items:center;border-bottom:1px solid #f0f1f3;padding:10px 0;transition:background .18s ease,border-color .18s ease}.hc-article:hover,.hc-support:hover,.hc-announcement:hover,.hc-shortcut:hover,.hc-ticket:hover{background:var(--hc-hover)}.hc-article:last-child,.hc-support:last-child,.hc-announcement:last-child,.hc-shortcut:last-child,.hc-ticket:last-child{border-bottom:0}.hc-article button,.hc-support button,.hc-announcement button,.hc-shortcut button{border:0;background:transparent;color:#111827;cursor:pointer;padding:0;text-align:left}.hc-row-title{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:12px;font-weight:600;color:#111827}.hc-row-sub{margin:3px 0 0;color:#6b7280;font-size:10.5px;line-height:1.35}.hc-tag{display:inline-flex;align-items:center;justify-content:center;min-width:auto;border-radius:0;background:transparent!important;color:var(--hc-orange);padding:0;font-size:10px;font-weight:700}.hc-tag.green,.hc-tag.purple{background:transparent!important;color:var(--hc-orange)}
.hc-btn{height:34px;min-width:112px;border:0;border-radius:999px;background:linear-gradient(90deg,var(--hc-orange),var(--hc-orange2));color:#111827!important;padding:0 16px;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-size:11px;font-weight:500;letter-spacing:0;cursor:pointer;transition:background .18s ease,color .18s ease,box-shadow .18s ease;text-decoration:none}.hc-btn:hover,.hc-btn:focus{background:#111827!important;border-color:#111827!important;color:#fff!important;box-shadow:0 12px 24px rgba(17,24,39,.18);outline:0}.hc-btn.full{width:100%}.hc-btn.plain{background:#fff!important;color:#111827!important;border:1px solid #111827!important}.hc-btn.plain:hover,.hc-btn.plain:focus{background:#111827!important;border-color:#111827!important;color:#fff!important}
.hc-shortcut-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:12px}.hc-main-stack .hc-shortcut-grid{grid-template-columns:repeat(5,minmax(0,1fr));gap:10px}.hc-shortcut{border:1px solid #dfe3ea;border-radius:8px;padding:12px;background:#fff;min-height:64px}.hc-main-stack .hc-shortcut{min-height:58px;padding:10px;gap:8px}.hc-shortcut:hover{background:var(--hc-hover);border-color:#cfd5dd}
.hc-status{display:flex;align-items:center;gap:7px;color:#6b7280;font-size:10.5px;font-weight:600}.hc-dot{width:7px;height:7px;border-radius:50%;background:var(--hc-green)}.hc-link{border:0;background:transparent;color:var(--hc-orange);font-size:10.5px;font-weight:800;cursor:pointer;padding:0}.hc-link:hover{color:#111827}
.hc-modal{position:fixed;inset:0;z-index:10000;display:none;place-items:center;padding:20px;background:rgba(15,23,42,.55)}.hc-modal.active{display:grid}.hc-modal-card{width:min(560px,100%);background:#fff;border:1px solid #111827;border-radius:16px;box-shadow:0 30px 80px rgba(15,23,42,.28);overflow:hidden}.hc-modal-head{display:flex;justify-content:space-between;gap:14px;align-items:flex-start;padding:18px;border-bottom:1px solid #eef0f4}.hc-close{width:34px;height:34px;border:1px solid #dfe3ea;border-radius:10px;background:#fff;color:#111827;cursor:pointer}.hc-close:hover{background:#111827;color:#fff}.hc-field-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}.hc-input,.hc-textarea,.hc-select{width:100%;border:1px solid #dfe3ea;border-radius:10px;background:#fff;color:#111827;padding:0 12px;font-size:12px;font-weight:500;outline:0}.hc-input,.hc-select{height:42px}.hc-textarea{min-height:110px;padding:12px;resize:vertical}.hc-input:focus,.hc-textarea:focus,.hc-select:focus{border-color:var(--hc-orange);box-shadow:0 0 0 4px rgba(255,122,0,.11)}
.hc-toast{position:fixed;left:50%;top:110px;z-index:11000;transform:translate(-50%,-12px);opacity:0;pointer-events:none;background:#111827;color:#fff;border-radius:13px;padding:13px 16px;box-shadow:0 18px 50px rgba(17,24,39,.25);font-size:12px;font-weight:700;transition:.18s}.hc-toast.show{opacity:1;transform:translate(-50%,0)}
@media(max-width:1320px){.hc-grid{grid-template-columns:1fr}.hc-stack{grid-template-columns:repeat(2,minmax(0,1fr))}.hc-stack .hc-card:first-child{grid-column:1/-1}.hc-shortcut-grid,.hc-main-stack .hc-shortcut-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:900px){.hc-category-grid,.hc-stack,.hc-field-grid,.hc-shortcut-grid{grid-template-columns:1fr}.hc-title{font-size:34px}}
.hc-head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin:0 0 16px}
.hc-title-wrap{display:flex;align-items:flex-start;gap:10px}.hc-title-wrap:before{content:'';width:18px;height:4px;margin-top:8px;border-radius:999px;background:var(--hc-orange);flex:0 0 auto}
.hc-date{height:38px;min-width:174px;padding:0 14px;border:1px solid #111827;border-radius:8px;background:#fff;color:#111827;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-size:12px;font-weight:600;line-height:1;white-space:nowrap;cursor:pointer;transition:background .18s ease,color .18s ease,border-color .18s ease}.hc-date:hover,.hc-date:focus{background:#111827;color:#fff;border-color:#111827;outline:0}
.hc-date i{font-size:15px}.hc-grid{align-items:stretch}.hc-main-stack,.hc-stack{height:100%}
.hc-main-stack{gap:0}.hc-main-stack>.hc-card:nth-child(1){border-bottom:0;border-radius:8px 8px 0 0;box-shadow:none}.hc-main-stack>.hc-card:nth-child(2){border-top:0;border-bottom:0;border-radius:0;box-shadow:none}.hc-main-stack>.hc-card:nth-child(3){border-top:0;border-radius:0 0 8px 8px;box-shadow:none}.hc-main-stack>.hc-card:nth-child(4){margin-top:18px;border-color:#111827;border-radius:8px;box-shadow:none}
.hc-main-stack>.hc-card:nth-child(1):hover,.hc-main-stack>.hc-card:nth-child(2):hover,.hc-main-stack>.hc-card:nth-child(3):hover,.hc-main-stack>.hc-card:nth-child(4):hover{background:#fff;box-shadow:none}
.hc-stack>.hc-card{border:0!important;border-radius:0!important;background:transparent!important;box-shadow:none!important;overflow:visible!important}.hc-stack>.hc-card:hover{background:transparent!important;box-shadow:none!important}.hc-stack>.hc-card>.hc-body{padding:0!important}
.hc-stack .hc-support,.hc-stack .hc-announcement,.hc-stack .hc-ticket{padding:12px 0}.hc-card,.hc-category,.hc-shortcut,.hc-modal-card{border-radius:8px}.hc-btn{border:0!important;border-radius:8px}
@media(max-width:900px){.hc-head{display:grid}.hc-date{width:100%}.hc-main-stack{gap:12px}.hc-main-stack>.hc-card:nth-child(1),.hc-main-stack>.hc-card:nth-child(2),.hc-main-stack>.hc-card:nth-child(3),.hc-main-stack>.hc-card:nth-child(4){border:1px solid #111827;border-radius:8px}.hc-stack{gap:18px}}

.hc-calendar-overlay{position:fixed;inset:0;z-index:10000;display:flex;align-items:center;justify-content:center;padding:18px;background:rgba(17,24,39,.36);backdrop-filter:blur(9px);opacity:0;visibility:hidden;pointer-events:none;transition:.2s}.hc-calendar-overlay.open{opacity:1;visibility:visible;pointer-events:auto}.hc-calendar-card{width:min(920px,100%);max-height:calc(100vh - 36px);overflow:hidden;border:1px solid #111827;border-radius:18px;background:#fff;box-shadow:0 26px 80px rgba(15,23,42,.22);display:grid;grid-template-columns:minmax(0,1.1fr) 310px}.hc-calendar-main{padding:18px;border-right:1px solid #eceff3}.hc-calendar-side{padding:18px;background:#fbfbfb}.hc-calendar-top{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}.hc-calendar-title{margin:0;font-family:'Poppins',system-ui,sans-serif;font-size:15px;font-weight:700;color:#111827}.hc-calendar-sub{margin:3px 0 0;font-size:11px;color:#6b7280}.hc-calendar-actions{display:flex;gap:7px}.hc-calendar-actions button,#hcCalUse,#hcCalClear{height:34px;min-width:34px;border:1px solid #111827;border-radius:9px;background:#fff;color:#111827;font-size:11px;font-weight:600;cursor:pointer;transition:.18s}#hcCalUse{padding:0 12px}#hcCalSave{height:34px;min-width:112px;border:0;border-radius:999px;background:#16a34a;color:#fff;font-size:11px;font-weight:500;cursor:pointer;transition:.18s}.hc-calendar-actions button:hover,#hcCalUse:hover,#hcCalClear:hover,#hcCalSave:hover{background:#111827!important;border-color:#111827!important;color:#fff!important}.hc-weekdays,.hc-days{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:7px}.hc-weekdays{margin-bottom:7px}.hc-weekdays span{text-align:center;font-size:9.5px;font-weight:800;color:#6b7280;text-transform:uppercase}.hc-day{min-height:72px;border:1px solid #eceff3;border-radius:12px;background:#fff;padding:8px;text-align:left;color:#111827;cursor:pointer;transition:.18s}.hc-day:hover{background:rgba(17,24,39,.065);border-color:#111827}.hc-day.muted{background:#fafafa;color:#a1a1aa;cursor:default}.hc-day.selected{border-color:#111827;background:rgba(17,24,39,.08);box-shadow:inset 0 0 0 1px #111827}.hc-day.today{border-color:var(--hc-orange);background:#fff8ef}.hc-calendar-side label{display:grid;gap:5px;margin-top:9px;font-size:10px;font-weight:800;text-transform:uppercase;color:#4b5563}.hc-calendar-side input,.hc-calendar-side textarea{width:100%;border:1px solid #eceff3;border-radius:10px;background:#fff;padding:10px 11px;font-family:'Inter',system-ui,sans-serif;font-size:12px;outline:0}.hc-calendar-side textarea{min-height:66px;resize:vertical}.hc-calendar-empty{min-height:68px;border:1px dashed #e2e5ea;border-radius:12px;display:grid;place-items:center;text-align:center;color:#6b7280;font-size:11px;padding:12px;background:#fff}.hc-cal-form-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:10px}@media(max-width:820px){.hc-calendar-card{grid-template-columns:1fr;overflow:auto}.hc-calendar-main{border-right:0;border-bottom:1px solid #eceff3}.hc-calendar-side{background:#fff}}
/* ===== FINAL HELP CENTER CLEANUP: one white wrapper, no redundant inner background ===== */
.hc-page,.hc-wrap,.hc-grid,.hc-main-stack{background:#fff!important;}
.hc-main-stack{gap:12px!important;}
.hc-main-stack>.hc-card{border:0!important;border-radius:0!important;box-shadow:none!important;background:#fff!important;overflow:visible!important;}
.hc-main-stack>.hc-card:hover{background:#fff!important;box-shadow:none!important;}
.hc-main-stack>.hc-card>.hc-body{padding:10px 16px!important;}
.hc-main-stack>.hc-card:nth-child(1)>.hc-body{padding-top:6px!important;padding-bottom:10px!important;}
.hc-main-stack>.hc-card:nth-child(4){margin-top:8px!important;}
.hc-main-stack>.hc-card:nth-child(4)>.hc-body{padding:0!important;}
.hc-main-stack>.hc-card:nth-child(4) .hc-shortcut-grid{margin-top:10px!important;}
.hc-category-grid,.hc-list,.hc-shortcut-grid{background:#fff!important;}
.hc-article{padding-left:0!important;padding-right:0!important;}
.hc-article:hover{background:rgba(17,24,39,.065)!important;}
.hc-tag,.hc-tag.green,.hc-tag.purple{background:transparent!important;box-shadow:none!important;border:0!important;color:var(--hc-orange)!important;padding:0!important;min-width:0!important;}
.hc-chip{background:linear-gradient(90deg,var(--hc-orange),var(--hc-orange2))!important;color:#111827!important;border:0!important;}
.hc-chip:hover,.hc-chip:focus,.hc-btn:hover,.hc-btn:focus{background:#111827!important;color:#fff!important;}
.hc-search-row{margin-top:12px!important;margin-bottom:18px!important;}
.hc-search-input{height:42px!important;border-radius:999px!important;background:#fff!important;color:#000!important;border:.5px solid rgba(17,24,39,.22)!important;padding:8px 24px 8px 64px!important;font-size:16px!important;}
.hc-search-input::placeholder{color:#6b7280!important;}
.hc-search-input:hover,.hc-search-input:focus{border-color:rgba(17,24,39,.34)!important;outline:0!important;box-shadow:none!important;}
.hc-hero{grid-template-columns:30px minmax(0,1fr)!important;gap:10px!important;}
.hc-hero-icon{width:28px!important;height:28px!important;background:transparent!important;border-radius:0!important;}
.hc-support .hc-icon{background:transparent!important;border-radius:0!important;}
.hc-support:nth-child(1) .hc-icon{color:var(--hc-green)!important;}.hc-support:nth-child(2) .hc-icon{color:var(--hc-orange)!important;}.hc-support:nth-child(3) .hc-icon{color:#111827!important;}.hc-support:nth-child(4) .hc-icon{color:var(--hc-purple)!important;}
.hc-category:nth-child(1) .hc-icon{color:var(--hc-orange)!important;}.hc-category:nth-child(2) .hc-icon{color:var(--hc-blue)!important;}.hc-category:nth-child(3) .hc-icon{color:var(--hc-red)!important;}.hc-category:nth-child(4) .hc-icon{color:var(--hc-blue)!important;}.hc-category:nth-child(5) .hc-icon{color:var(--hc-purple)!important;}.hc-category:nth-child(6) .hc-icon{color:var(--hc-orange)!important;}
.hc-shortcut>i,.hc-shortcut .hc-shortcut-icon{font-size:17px!important;width:22px;text-align:center;line-height:1;color:#111827;}
.hc-shortcut-icon.track{color:var(--hc-blue)!important;}
.hc-shortcut-icon.change{color:var(--hc-purple)!important;}
.hc-shortcut-icon.issue{color:var(--hc-red)!important;}
.hc-shortcut-icon.return{color:var(--hc-green)!important;}
.hc-shortcut-icon.history{color:var(--hc-orange)!important;}
.hc-link{height:34px;min-width:118px;border:0!important;border-radius:999px!important;background:linear-gradient(90deg,var(--hc-orange),var(--hc-orange2))!important;color:#111827!important;padding:0 16px!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;gap:8px!important;font-size:11px!important;font-weight:500!important;transition:background .18s ease,color .18s ease,box-shadow .18s ease!important;}
.hc-link:hover,.hc-link:focus{background:#111827!important;color:#fff!important;box-shadow:0 12px 24px rgba(17,24,39,.18)!important;outline:0!important;}
@media(max-width:900px){.hc-main-stack>.hc-card{border:0!important;border-radius:0!important}.hc-main-stack>.hc-card>.hc-body{padding:10px 0!important}}



/* === FINAL IMAGE UI PATCH: Help Center matches screenshot + My Profile/Notifications spacing === */
.hc-page{
    background:#fff!important;
}
.hc-wrap{
    max-width:1490px!important;
    width:auto!important;
    margin-left:auto!important;
    margin-right:auto!important;
    padding:0 0 26px!important;
    background:#fff!important;
}
.hc-head{
    display:flex!important;
    align-items:flex-start!important;
    justify-content:space-between!important;
    gap:18px!important;
    margin:0 0 16px!important;
    width:100%!important;
}
.hc-date{
    width:178px!important;
    min-width:178px!important;
    max-width:178px!important;
    height:42px!important;
    padding:0 13px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:8px!important;
    font-size:12px!important;
    font-weight:600!important;
    line-height:1!important;
    white-space:nowrap!important;
    box-shadow:none!important;
}
.hc-date:hover,.hc-date:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:0!important;
}
.hc-grid{
    display:block!important;
    width:100%!important;
    max-width:1200px!important;
    background:#fff!important;
}
.hc-main-stack{
    display:block!important;
    width:100%!important;
    max-width:1200px!important;
    background:#fff!important;
}
.hc-main-stack>.hc-card,
.hc-main-stack>.hc-card:nth-child(1),
.hc-main-stack>.hc-card:nth-child(2),
.hc-main-stack>.hc-card:nth-child(3),
.hc-main-stack>.hc-card:nth-child(4){
    border:0!important;
    border-radius:0!important;
    box-shadow:none!important;
    background:#fff!important;
    margin:0!important;
    overflow:visible!important;
}
.hc-main-stack>.hc-card:hover{
    background:#fff!important;
    box-shadow:none!important;
}
.hc-main-stack>.hc-card>.hc-body{
    padding:0!important;
}
.hc-main-stack>.hc-card:nth-child(1)>.hc-body{
    padding:0 0 18px!important;
}
.hc-main-stack>.hc-card:nth-child(2)>.hc-body{
    padding:0 0 22px!important;
}
.hc-main-stack>.hc-card:nth-child(3)>.hc-body{
    padding:0 0 34px!important;
}
.hc-main-stack>.hc-ticket-activity-card>.hc-body{
    padding:0!important;
}
.hc-hero{
    display:grid!important;
    grid-template-columns:24px minmax(0,1fr)!important;
    gap:12px!important;
    align-items:start!important;
    max-width:760px!important;
}
.hc-hero-icon{
    width:18px!important;
    height:18px!important;
    margin-top:1px!important;
    color:var(--hc-orange)!important;
    background:transparent!important;
}
.hc-card-title{
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:14px!important;
    font-weight:600!important;
    letter-spacing:.018em!important;
    color:#111827!important;
}
.hc-card-desc{
    font-size:11.5px!important;
    color:#6b7280!important;
    line-height:1.45!important;
}
.hc-search-row{
    width:650px!important;
    max-width:100%!important;
    margin-top:14px!important;
    margin-bottom:0!important;
}
.hc-search-input{
    height:42px!important;
    border:1px solid #d1d5db!important;
    border-radius:999px!important;
    background:#fff!important;
    color:#111827!important;
    padding:8px 24px 8px 64px!important;
    font-size:16px!important;
    font-weight:500!important;
    box-shadow:none!important;
}
.hc-search-input:hover,.hc-search-input:focus{
    border-color:#9ca3af!important;
    box-shadow:none!important;
    outline:0!important;
}
.hc-chip-row,
.hc-shortcut-grid,
.hc-stack{
    display:none!important;
}
.hc-category-grid{
    display:grid!important;
    grid-template-columns:repeat(3,minmax(0,1fr))!important;
    gap:18px!important;
    width:100%!important;
}
.hc-category{
    min-height:100px!important;
    border:1px solid #dfe3ea!important;
    border-radius:8px!important;
    background:#fff!important;
    padding:15px 20px!important;
    display:grid!important;
    grid-template-columns:34px minmax(0,1fr) 16px!important;
    gap:14px!important;
    align-items:center!important;
    box-shadow:none!important;
}
.hc-category:hover,.hc-category:focus{
    background:rgba(17,24,39,.055)!important;
    border-color:#cfd5dd!important;
    box-shadow:none!important;
    outline:0!important;
}
.hc-category strong{
    font-size:12px!important;
    font-weight:600!important;
}
.hc-category small{
    font-size:10.5px!important;
    line-height:1.35!important;
}
.hc-category em{
    margin-top:8px!important;
    font-size:10.5px!important;
    font-weight:700!important;
}
.hc-list{
    width:100%!important;
}
.hc-article,
.hc-ticket{
    min-height:36px!important;
    padding:7px 0!important;
    border-bottom:1px solid #f0f1f3!important;
    background:#fff!important;
}
.hc-article:hover,
.hc-ticket:hover{
    background:rgba(17,24,39,.055)!important;
}
.hc-row-title{
    font-size:12px!important;
    font-weight:600!important;
}
.hc-tag{
    color:var(--hc-orange)!important;
    font-size:10px!important;
    font-weight:700!important;
}
.hc-link,
.hc-main-stack .hc-link{
    display:none!important;
}
.hc-ticket-activity-card{
    margin-top:20px!important;
}
@media(max-width:1320px){
    .hc-grid,.hc-main-stack{max-width:none!important;}
}
@media(max-width:940px){
    .hc-category-grid{grid-template-columns:1fr!important;}
    .hc-search-row{width:100%!important;}
}
@media(max-width:620px){
    .hc-head{display:grid!important;}
    .hc-date{width:100%!important;max-width:none!important;}
}


/* === FINAL CALENDAR + INNER UI MATCH: same button, modal, and spacing style as Notifications === */
.hc-date,
.hc-calendar-trigger{
    width:178px!important;
    min-width:178px!important;
    max-width:178px!important;
    height:42px!important;
    padding:0 13px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    box-shadow:none!important;
    font-size:12px!important;
    font-weight:600!important;
    line-height:1!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:8px!important;
    white-space:nowrap!important;
    cursor:pointer!important;
    transition:background .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease!important;
}
.hc-date:hover,
.hc-date:focus,
.hc-calendar-trigger:hover,
.hc-calendar-trigger:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    box-shadow:none!important;
    outline:0!important;
}
.hc-date svg,
.hc-calendar-trigger svg{
    width:16px!important;
    height:16px!important;
    flex:0 0 auto!important;
}
.hc-date i{display:none!important;}
.hc-calendar-overlay{
    position:fixed!important;
    inset:0!important;
    z-index:9998!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    padding:18px!important;
    background:rgba(17,24,39,.36)!important;
    backdrop-filter:blur(9px)!important;
    opacity:0!important;
    visibility:hidden!important;
    pointer-events:none!important;
    transition:opacity .2s ease,visibility .2s ease!important;
}
.hc-calendar-overlay.open{
    opacity:1!important;
    visibility:visible!important;
    pointer-events:auto!important;
}
.hc-calendar-card{
    width:min(920px,100%)!important;
    max-height:calc(100vh - 36px)!important;
    overflow:hidden!important;
    border:1px solid #111827!important;
    border-radius:18px!important;
    background:#fff!important;
    box-shadow:0 26px 80px rgba(15,23,42,.22)!important;
    display:grid!important;
    grid-template-columns:minmax(0,1.1fr) 310px!important;
}
.hc-calendar-main{
    padding:18px!important;
    border-right:1px solid #eceff3!important;
    min-width:0!important;
    background:#fff!important;
}
.hc-calendar-side{
    padding:18px!important;
    background:#fff!important;
    min-width:0!important;
}
.hc-calendar-top{
    display:flex!important;
    align-items:center!important;
    justify-content:space-between!important;
    gap:12px!important;
    margin-bottom:14px!important;
}
.hc-calendar-title{
    margin:0!important;
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:16px!important;
    font-weight:700!important;
    color:#111827!important;
}
.hc-calendar-sub{
    margin:3px 0 0!important;
    font-size:11px!important;
    font-weight:400!important;
    color:#6b7280!important;
    line-height:1.45!important;
}
.hc-calendar-actions{
    display:flex!important;
    align-items:center!important;
    gap:7px!important;
}
.hc-calendar-actions button,
#hcCalUse,
#hcCalClear{
    height:34px!important;
    border:1px solid #111827!important;
    border-radius:999px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:6px!important;
    cursor:pointer!important;
    transition:.18s!important;
    box-shadow:none!important;
}
.hc-calendar-actions button{
    min-width:42px!important;
    padding:0!important;
}
#hcCalUse{
    min-width:92px!important;
    padding:0 13px!important;
}
#hcCalClear{
    min-width:76px!important;
    padding:0 13px!important;
}
.hc-calendar-actions button:hover,
.hc-calendar-actions button:focus,
#hcCalUse:hover,
#hcCalUse:focus,
#hcCalClear:hover,
#hcCalClear:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:0!important;
}
#hcCalSave{
    height:34px!important;
    min-width:118px!important;
    padding:0 14px!important;
    border:0!important;
    border-radius:999px!important;
    background:#16a34a!important;
    color:#fff!important;
    font-size:11px!important;
    font-weight:500!important;
    cursor:pointer!important;
    transition:.18s!important;
}
#hcCalSave:hover,
#hcCalSave:focus{
    background:#111827!important;
    color:#fff!important;
    outline:0!important;
}
.hc-weekdays,
.hc-days{
    display:grid!important;
    grid-template-columns:repeat(7,minmax(0,1fr))!important;
    gap:7px!important;
}
.hc-weekdays{
    margin-bottom:7px!important;
}
.hc-weekdays span{
    text-align:center!important;
    font-size:9.5px!important;
    font-weight:800!important;
    color:#6b7280!important;
    letter-spacing:.08em!important;
    text-transform:uppercase!important;
}
.hc-day{
    position:relative!important;
    min-height:78px!important;
    border:1px solid #eceff3!important;
    border-radius:12px!important;
    background:#fff!important;
    padding:8px!important;
    text-align:left!important;
    color:#111827!important;
    cursor:pointer!important;
    transition:.18s!important;
    overflow:hidden!important;
}
.hc-day:hover,
.hc-day:focus{
    border-color:#111827!important;
    background:rgba(17,24,39,.14)!important;
    box-shadow:0 10px 24px rgba(17,24,39,.08)!important;
    backdrop-filter:blur(7px)!important;
    outline:0!important;
}
.hc-day.muted{
    background:#fafafa!important;
    color:#a1a1aa!important;
    cursor:default!important;
}
.hc-day.today{
    border-color:var(--hc-orange)!important;
    background:#fff3e6!important;
}
.hc-day.selected{
    border-color:#111827!important;
    background:rgba(17,24,39,.16)!important;
    box-shadow:inset 0 0 0 1px #111827!important;
}
.hc-calendar-side h4,
#hcCalSelected{
    margin:0 0 12px!important;
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:15px!important;
    font-weight:700!important;
    color:#111827!important;
}
.hc-calendar-empty{
    min-height:74px!important;
    border:1px dashed #e2e5ea!important;
    border-radius:12px!important;
    display:grid!important;
    place-items:center!important;
    text-align:center!important;
    color:#6b7280!important;
    font-size:11px!important;
    font-weight:500!important;
    line-height:1.45!important;
    padding:12px!important;
    background:#fff!important;
    margin-bottom:13px!important;
}
.hc-calendar-side label{
    display:grid!important;
    gap:5px!important;
    margin-top:9px!important;
    font-size:10px!important;
    font-weight:800!important;
    text-transform:uppercase!important;
    letter-spacing:.05em!important;
    color:#4b5563!important;
}
.hc-calendar-side input,
.hc-calendar-side textarea{
    width:100%!important;
    border:1px solid #eceff3!important;
    border-radius:10px!important;
    background:#fff!important;
    padding:10px 11px!important;
    color:#111827!important;
    font-family:'Inter',system-ui,sans-serif!important;
    font-size:12px!important;
    font-weight:500!important;
    outline:none!important;
    transition:.18s!important;
}
.hc-calendar-side textarea{
    min-height:68px!important;
    resize:vertical!important;
}
.hc-calendar-side input:focus,
.hc-calendar-side textarea:focus{
    border-color:var(--hc-orange)!important;
    box-shadow:0 0 0 3px rgba(255,122,0,.10)!important;
}
.hc-cal-form-actions{
    display:flex!important;
    align-items:center!important;
    justify-content:flex-end!important;
    gap:8px!important;
    margin-top:10px!important;
}
@media(max-width:820px){
    .hc-calendar-card{grid-template-columns:1fr!important;overflow:auto!important;}
    .hc-calendar-main{border-right:0!important;border-bottom:1px solid #eceff3!important;}
    .hc-day{min-height:62px!important;}
}
</style>

<div class="hc-page">
<div class="hc-wrap">
    <div class="hc-head">
        <div class="hc-title-wrap">
            <div>
                <h1 class="hc-title">Help Center</h1>
                <p class="hc-sub">Find answers, get support, and manage your orders with ease.</p>
            </div>
        </div>
        <button type="button" class="hc-date" id="hcCalendarToggle" aria-haspopup="dialog" aria-controls="hcCalendarOverlay">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M8 2v4M16 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M5 5h14a2 2 0 0 1 2 2v14H3V7a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
            <span id="hcDateText">Today is {{ now()->format('M d, Y') }}</span>
        </button>
    </div>

    <div class="hc-grid">
        <main class="hc-main-stack">
            <section class="hc-card">
                <div class="hc-body">
                    <div class="hc-hero">
                        <span class="hc-hero-icon"><i class="fa-solid fa-circle-question"></i></span>
                        <div>
                            <h2 class="hc-card-title">How can we help you today?</h2>
                            <p class="hc-card-desc">Search our help articles or browse by category to find the answers you need.</p>
                            <div class="hc-search-row">
                                <div class="hc-search-left-icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4601 10.3188L15.7639 14.6226C15.9151 14.7739 16.0001 14.9792 16 15.1932C15.9999 15.4072 15.9148 15.6124 15.7635 15.7637C15.6121 15.915 15.4068 15.9999 15.1928 15.9998C14.9788 15.9998 14.7736 15.9147 14.6223 15.7633L10.3185 11.4595C9.03194 12.456 7.41407 12.9249 5.79403 12.7709C4.17398 12.6169 2.67346 11.8515 1.59771 10.6304C0.521957 9.40936 -0.0482098 7.82433 0.00319691 6.19779C0.0546036 4.57125 0.723722 3.02539 1.87443 1.87468C3.02514 0.723966 4.57101 0.0548478 6.19754 0.00344105C7.82408 -0.0479657 9.40911 0.522201 10.6302 1.59795C11.8513 2.6737 12.6167 4.17423 12.7707 5.79427C12.9247 7.41432 12.4558 9.03219 11.4593 10.3188H11.4601ZM6.4003 11.1995C7.67328 11.1995 8.89412 10.6938 9.79425 9.7937C10.6944 8.89356 11.2001 7.67272 11.2001 6.39974C11.2001 5.12676 10.6944 3.90592 9.79425 3.00579C8.89412 2.10565 7.67328 1.59997 6.4003 1.59997C5.12732 1.59997 3.90648 2.10565 3.00634 3.00579C2.10621 3.90592 1.60052 5.12676 1.60052 6.39974C1.60052 7.67272 2.10621 8.89356 3.00634 9.7937C3.90648 10.6938 5.12732 11.1995 6.4003 11.1995Z" fill="gray" />
                                    </svg>
                                </div>
                                <input id="helpSearch" class="hc-search-input" type="search" placeholder="Search" onkeydown="if(event.key==='Enter') runHelpSearch()">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="hc-card">
                <div class="hc-body">
                    <div class="hc-category-grid" id="categoryGrid">
                        @foreach([
                            ['bag-shopping','Orders & Shipping','Track orders, shipping times, delivery updates and more.','18 articles','Orders & Shipping'],
                            ['credit-card','Payments & Billing','Payment methods, billing issues, invoices and refunds.','16 articles','Payments & Billing'],
                            ['lock','Account & Security','Account settings, login help, security and privacy.','14 articles','Account & Security'],
                            ['pen-to-square','Product Design Help','Design tools, file requirements, templates and tips.','12 articles','Product Design'],
                            ['truck-arrow-right','Returns & Refunds','Return process, eligibility, refund status and more.','10 articles','Returns & Refunds'],
                            ['circle-question','General FAQs','Browse common questions about our services.','20 articles','General FAQs'],
                        ] as $cat)
                        <button class="hc-category" type="button" data-help-item="{{ strtolower($cat[1].' '.$cat[2]) }}" onclick="selectHelpCategory('{{ $cat[4] }}')">
                            <span class="hc-icon {{ $loop->index === 1 ? 'green' : ($loop->index === 2 ? 'purple' : ($loop->index === 3 ? 'blue' : '')) }}"><i class="fa-solid fa-{{ $cat[0] }}"></i></span>
                            <span><strong>{{ $cat[1] }}</strong><small>{{ $cat[2] }}</small><em>{{ $cat[3] }}</em></span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="hc-card">
                <div class="hc-body">
                    <h2 class="hc-card-title">Popular Articles</h2>
                    <div class="hc-list" id="articleList">
                        @foreach([
                            ['How do I track my order?','Orders & Shipping',''],
                            ['What payment methods do you accept?','Payments & Billing','green'],
                            ['How do I change or cancel my order?','Orders & Shipping',''],
                            ['How do I start a return or request a refund?','Returns & Refunds',''],
                            ['I forgot my password. How can I reset it?','Account & Security','purple'],
                        ] as $article)
                        <div class="hc-article" data-help-item="{{ strtolower($article[0].' '.$article[1]) }}">
                            <i class="fa-regular fa-file-lines"></i>
                            <button type="button" onclick="openArticle('{{ $article[0] }}')"><p class="hc-row-title">{{ $article[0] }}</p></button>
                            <span class="hc-tag {{ $article[2] }}">{{ $article[1] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>


            <section class="hc-card hc-ticket-activity-card">
                <div class="hc-body">
                    <h2 class="hc-card-title">Ticket Activity</h2>
                    <p class="hc-card-desc">Recent support activity saved for this account.</p>
                    <div class="hc-list" id="ticketList" style="margin-top:10px"></div>
                </div>
            </section>
        </main>
</div>

</div>

<div id="ticketModal" class="hc-modal" aria-hidden="true">
    <div class="hc-modal-card">
        <div class="hc-modal-head">
            <div><h2 class="hc-card-title">Submit a Ticket</h2><p class="hc-card-desc">This creates a real support ticket in the database.</p></div>
            <button type="button" class="hc-close" onclick="closeTicketModal()">x</button>
        </div>
        <div class="hc-body">
            <form id="supportForm">
                <div class="hc-field-grid">
                    <select id="supportTopic" class="hc-select"><option>Order Concern</option><option>Artwork Upload</option><option>Payment & Billing</option><option>Delivery / Pickup</option><option>Change Request</option><option>Report an Issue</option><option>Return Request</option></select>
                    <input id="supportOrder" class="hc-input" placeholder="Order reference (optional)">
                </div>
                <textarea id="supportMessage" class="hc-textarea" style="margin-top:10px" placeholder="Describe your concern..." required></textarea>
                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:12px;flex-wrap:wrap"><button class="hc-btn plain" type="button" onclick="saveHelpDraft()">Save Draft</button><button class="hc-btn" type="submit">Submit Ticket</button></div>
            </form>
        </div>
    </div>
</div>


<div class="hc-calendar-overlay" id="hcCalendarOverlay" aria-hidden="true">
  <div class="hc-calendar-card" role="dialog" aria-modal="true" aria-label="Help Center Calendar">
    <div class="hc-calendar-main">
      <div class="hc-calendar-top">
        <div><h3 class="hc-calendar-title">Customer Calendar</h3><p class="hc-calendar-sub">Select a date for this section.</p></div>
        <div class="hc-calendar-actions"><button type="button" id="hcCalPrev">‹</button><button type="button" id="hcCalToday">Today</button><button type="button" id="hcCalNext">›</button><button type="button" id="hcCalClose">×</button></div>
      </div>
      <div class="hc-calendar-top"><h4 class="hc-calendar-title" id="hcCalMonth"></h4><button type="button" id="hcCalUse">✓ Use Date</button></div>
      <div class="hc-weekdays"><span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span></div>
      <div class="hc-days" id="hcCalDays"></div>
    </div>
    <aside class="hc-calendar-side"><h4 id="hcCalSelected"></h4><div class="hc-calendar-empty">No reminders yet for this date. Add one below.</div><label>Event / Reminder<input id="hcCalEvent" placeholder="Example: Pickup order"></label><label>Time<input type="time" id="hcCalTime"></label><label>Note<textarea id="hcCalNote" placeholder="Optional note"></textarea></label><div class="hc-cal-form-actions"><button type="button" id="hcCalClear">Clear</button><button type="button" id="hcCalSave">Save Event</button></div></aside>
  </div>
</div>

<div id="helpToast" class="hc-toast">Saved.</div>
</div>

<script>
const helpKey='printify_help_tickets';
const helpTicketStoreUrl=@json(Route::has('help-center.tickets.store') ? route('help-center.tickets.store') : null);
const helpCsrf=@json(csrf_token());
function helpToast(msg){const t=document.getElementById('helpToast');if(!t)return;t.textContent=msg;t.classList.add('show');clearTimeout(window.helpToastTimer);window.helpToastTimer=setTimeout(()=>t.classList.remove('show'),2400)}
function helpTickets(){try{return JSON.parse(localStorage.getItem(helpKey)||'[]')}catch(e){return []}}
function saveTickets(items){localStorage.setItem(helpKey,JSON.stringify(items))}
function helpField(id){return document.getElementById(id)}
function escapeHelpText(value){return String(value||'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]))}
function updateHelpUrl(view){history.replaceState(null,'',window.location.pathname+(view?'#'+view:''))}
function renderTickets(){const box=helpField('ticketList');if(!box)return;const items=helpTickets();box.innerHTML=items.length?items.slice(-3).reverse().map(t=>`<div class="hc-ticket"><i class="fa-regular fa-message"></i><div><p class="hc-row-title">${escapeHelpText(t.ref||t.topic)}</p><p class="hc-row-sub">${escapeHelpText(t.topic)} - ${escapeHelpText((t.message||'').slice(0,62))}</p></div><span class="hc-tag">${escapeHelpText(t.status)}</span></div>`).join(''):'<div class="hc-ticket"><i class="fa-regular fa-message"></i><div><p class="hc-row-title">No tickets yet</p><p class="hc-row-sub">Submit a ticket to see it here.</p></div><span class="hc-tag">Ready</span></div>'}
function openTicketModal(topicValue){const modal=helpField('ticketModal'),topic=helpField('supportTopic'),message=helpField('supportMessage');if(topic&&topicValue)topic.value=topicValue;if(modal){modal.classList.add('active');modal.setAttribute('aria-hidden','false');document.body.style.overflow='hidden'}setTimeout(()=>message?.focus(),80);updateHelpUrl('support-ticket')}
function closeTicketModal(){const modal=helpField('ticketModal');if(modal){modal.classList.remove('active');modal.setAttribute('aria-hidden','true');document.body.style.overflow=''}}
function saveHelpDraft(){const topic=helpField('supportTopic'),order=helpField('supportOrder'),message=helpField('supportMessage');localStorage.setItem('printify_help_draft',JSON.stringify({topic:topic?.value||'',order:order?.value||'',message:message?.value||'',savedAt:new Date().toISOString()}));updateHelpUrl('draft-saved');helpToast('Draft saved.')}
function startLiveChat(){localStorage.setItem('printify_live_chat_requested_at',new Date().toISOString());updateHelpUrl('live-chat');helpToast('Live chat request opened.')}
function selectHelpCategory(category){const search=helpField('helpSearch');if(search)search.value=category;runHelpSearch();helpToast(category+' articles shown.')}
function quickHelpSearch(term){const search=helpField('helpSearch');if(search)search.value=term;runHelpSearch()}
function runHelpSearch(){const search=helpField('helpSearch');const q=(search?.value||'').toLowerCase().trim();document.querySelectorAll('[data-help-item]').forEach(item=>{item.style.display=!q||item.dataset.helpItem.includes(q)?'':'none'});updateHelpUrl(q?'search':'help-center');helpToast(q?'Filtered help results.':'Showing all help results.')}
function openArticle(title){localStorage.setItem('printify_help_last_article',title);updateHelpUrl(title.toLowerCase().replace(/[^a-z0-9]+/g,'-'));helpToast(title)}
function openAnnouncement(title){localStorage.setItem('printify_help_last_announcement',title);updateHelpUrl('announcements');helpToast(title)}
function showAllArticles(){const search=helpField('helpSearch');if(search)search.value='';runHelpSearch();helpToast('All articles visible.')}
helpField('ticketModal')?.addEventListener('click',e=>{if(e.target.id==='ticketModal')closeTicketModal()});
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeTicketModal()});
helpField('supportForm')?.addEventListener('submit',async e=>{e.preventDefault();const topic=helpField('supportTopic'),order=helpField('supportOrder'),message=helpField('supportMessage');const body=(message?.value||'').trim();if(!body){helpToast('Please describe your concern.');return}const fallbackRef='TKT-'+Date.now().toString().slice(-6);let ticket={ref:fallbackRef,topic:topic?.value||'Order Concern',order:(order?.value||'').trim(),message:body,status:'Open',createdAt:new Date().toISOString()};let savedToServer=false;try{if(helpTicketStoreUrl){const res=await fetch(helpTicketStoreUrl,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':helpCsrf},body:JSON.stringify({topic:ticket.topic,order_reference:ticket.order,message:ticket.message})});if(!res.ok)throw new Error('Ticket save failed');const data=await res.json();if(data.ticket){ticket={ref:data.ticket.ref||data.ticket.reference||ticket.ref,topic:data.ticket.topic||ticket.topic,order:data.ticket.order||data.ticket.order_reference||ticket.order,message:data.ticket.message||ticket.message,status:data.ticket.status||ticket.status,createdAt:data.ticket.createdAt||data.ticket.created_at||ticket.createdAt};savedToServer=true;}}}catch(err){console.warn(err)}const items=helpTickets();items.push(ticket);saveTickets(items);localStorage.removeItem('printify_help_draft');if(message)message.value='';if(order)order.value='';renderTickets();closeTicketModal();updateHelpUrl('ticket-'+String(ticket.ref).toLowerCase());helpToast((savedToServer?'Support ticket saved: ':'Support ticket saved locally: ')+ticket.ref);});
try{const d=JSON.parse(localStorage.getItem('printify_help_draft')||'null');if(d){const topic=helpField('supportTopic'),order=helpField('supportOrder'),message=helpField('supportMessage');if(topic)topic.value=d.topic||topic.value;if(order)order.value=d.order||'';if(message)message.value=d.message||''}}catch(e){}

(function(){
 const toggle=document.getElementById('hcCalendarToggle'),overlay=document.getElementById('hcCalendarOverlay'),days=document.getElementById('hcCalDays'),month=document.getElementById('hcCalMonth'),selLabel=document.getElementById('hcCalSelected'),dateText=document.getElementById('hcDateText');
 if(!toggle||!overlay||!days)return;
 const pad=n=>String(n).padStart(2,'0');
 const key=d=>`${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
 const fmt=d=>d.toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'});
 let today=new Date(), selected=new Date(today.getFullYear(),today.getMonth(),today.getDate()), view=new Date(selected.getFullYear(),selected.getMonth(),1);
 function render(){
  month.textContent=view.toLocaleDateString('en-US',{month:'long',year:'numeric'}); selLabel.textContent=fmt(selected); days.innerHTML='';
  const y=view.getFullYear(),m=view.getMonth(),first=new Date(y,m,1),last=new Date(y,m+1,0),offset=first.getDay(),cells=Math.ceil((offset+last.getDate())/7)*7;
  for(let i=0;i<cells;i++){const num=i-offset+1,b=document.createElement('button');b.type='button';b.className='hc-day';if(num<1||num>last.getDate()){b.className+=' muted';b.disabled=true;days.appendChild(b);continue}const d=new Date(y,m,num);b.textContent=num;if(key(d)===key(today))b.classList.add('today');if(key(d)===key(selected))b.classList.add('selected');b.onclick=()=>{selected=d;render()};days.appendChild(b)}
 }
 function open(){overlay.classList.add('open');overlay.setAttribute('aria-hidden','false');render()}
 function close(){overlay.classList.remove('open');overlay.setAttribute('aria-hidden','true')}
 toggle.addEventListener('click',open);document.getElementById('hcCalClose')?.addEventListener('click',close);overlay.addEventListener('click',e=>{if(e.target===overlay)close()});
 document.getElementById('hcCalPrev')?.addEventListener('click',()=>{view=new Date(view.getFullYear(),view.getMonth()-1,1);render()});
 document.getElementById('hcCalNext')?.addEventListener('click',()=>{view=new Date(view.getFullYear(),view.getMonth()+1,1);render()});
 document.getElementById('hcCalToday')?.addEventListener('click',()=>{today=new Date();selected=new Date(today.getFullYear(),today.getMonth(),today.getDate());view=new Date(selected.getFullYear(),selected.getMonth(),1);render()});
 document.getElementById('hcCalUse')?.addEventListener('click',()=>{if(dateText)dateText.textContent='Today is '+selected.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});close();helpToast('Calendar date selected.')});
 document.getElementById('hcCalClear')?.addEventListener('click',()=>{['hcCalEvent','hcCalTime','hcCalNote'].forEach(id=>{const el=document.getElementById(id);if(el)el.value=''})});
 document.getElementById('hcCalSave')?.addEventListener('click',()=>{localStorage.setItem('printify_help_calendar_last',JSON.stringify({date:key(selected),event:document.getElementById('hcCalEvent')?.value||'',time:document.getElementById('hcCalTime')?.value||'',note:document.getElementById('hcCalNote')?.value||''}));helpToast('Calendar reminder saved.')});
 document.addEventListener('keydown',e=>{if(e.key==='Escape'&&overlay.classList.contains('open'))close()});
})();

renderTickets();
</script>
</x-app-layout>
