<x-app-layout>
@php
    $user = Auth::user();
    $firstName = $user->first_name ?? $user->name ?? '';
    $lastName = $user->last_name ?? '';
    $photo = $user->profile_photo_url ?? $user->profile_photo ?? $user->avatar ?? null;
    if (!$photo && !empty($user->profile_photo_path)) $photo = asset('storage/' . $user->profile_photo_path);
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700&display=swap');
[x-cloak]{display:none!important}
:root{
    --p-bg:#ffffff;--p-card:#fff;--p-ink:#111827;--p-muted:#6b7280;--p-line:#edf0f4;--p-line2:#dfe3ea;
    --p-orange:#ff7a00;--p-orange-soft:#fff3e6;--p-green:#16a34a;--p-green-soft:#eaf8ef;
    --p-purple:#7c3aed;--p-purple-soft:#f2ebff;--p-yellow:#f59e0b;--p-yellow-soft:#fff7df;--p-complete:#2563eb;--p-complete-soft:#eff6ff;
    --p-shadow:0 12px 30px rgba(15,23,42,.07);--p-shadow2:0 18px 42px rgba(15,23,42,.11);
    --p-radius:14px;--btn-h:42px;--btn-r:10px;--font:'Inter',system-ui,sans-serif;
    --head:'Playfair Display',Georgia,serif;--title:'Poppins',system-ui,sans-serif;
}
*{box-sizing:border-box}
.profile-page{min-height:calc(100vh - 70px);padding:0 0 34px;background:var(--p-bg);color:var(--p-ink);font-family:var(--font);overflow-x:hidden;-webkit-font-smoothing:antialiased}
.profile-page button,.profile-page input{font-family:var(--font)}
.profile-shell{max-width:1490px;margin:0 auto;padding:0}
.profile-head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin:0 0 16px}
.profile-title-wrap{display:flex;align-items:flex-start;gap:10px}
.profile-title-wrap:before{content:'';width:18px;height:4px;margin-top:8px;border-radius:999px;background:var(--p-orange);flex:0 0 auto}
.profile-title{margin:0 0 3px;font-family:var(--head);font-size:40px;font-weight:700;line-height:1.2;color:#111827;letter-spacing:-.02em}
.profile-sub{margin:0;color:var(--p-muted);font-size:12px;font-weight:400;line-height:1.45}
.profile-date{height:42px;min-width:178px;padding:0 15px;border:1px solid #111827;border-radius:8px;background:#fff;color:#111827;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-size:12px;font-weight:700;line-height:1;white-space:nowrap}
.profile-date svg{color:#111827}
.profile-grid{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:18px;align-items:start}
.profile-left,.profile-right{display:grid;gap:18px;align-content:start}
.profile-left{border:1px solid #111827;border-radius:8px;background:#fff;padding:18px;gap:0}
.prof-card{background:var(--p-card);border:1px solid #111827;border-radius:8px;box-shadow:none;transition:background .18s ease,border-color .18s ease,transform .18s ease}
.prof-card:hover{background:#fff;border-color:#111827;transform:none}
.prof-hero{min-height:138px;padding:0 0 18px;display:flex;align-items:center;justify-content:space-between;gap:18px;border:0;border-radius:0;border-bottom:1px solid #111827}
.prof-main{display:flex;align-items:center;gap:18px;min-width:0}
.prof-avatar-wrap{width:108px;height:108px;position:relative;flex:0 0 auto}
.prof-avatar{width:108px;height:108px;border-radius:50%;overflow:hidden;display:grid;place-items:center;background:radial-gradient(circle at 32% 25%,#ff9a37,#ff5a00 54%,#e04800);border:4px solid #fff;outline:3px solid #ff6a14;box-shadow:0 18px 34px rgba(255,122,0,.22);color:#fff;font-size:44px;font-weight:800;letter-spacing:-.08em}
.prof-avatar img{width:100%;height:100%;object-fit:cover;display:block}
.prof-avatar-initials{transform:translateX(-2px)}
.prof-camera-btn{position:absolute;right:-2px;bottom:5px;width:36px;height:36px;border-radius:50%;border:3px solid #fff;background:var(--p-orange);color:#fff;display:grid;place-items:center;cursor:pointer;box-shadow:none;transition:.18s ease}
.prof-camera-btn:hover,.prof-camera-btn:focus{background:#111827;color:#fff;transform:translateY(-1px)}
.prof-online{position:absolute;right:-10px;top:80px;width:14px;height:14px;border-radius:50%;background:#22c55e;border:4px solid #fff;box-shadow:0 0 0 1px rgba(22,163,74,.08);pointer-events:none;z-index:3}
.prof-name{margin:0;font-family:var(--head);font-size:34px;font-weight:700;line-height:1.02;color:#111827;letter-spacing:-.028em}
.prof-role{margin:7px 0 8px;color:#111827;font-family:var(--title);font-size:12px;font-weight:600;letter-spacing:.16em;text-transform:uppercase}
.prof-loc{display:flex;align-items:center;gap:6px;margin:0;color:#4b5563;font-size:13px;font-weight:500}
.prof-profile-meta{display:grid;gap:4px;margin-top:8px;color:#111827;font-size:12px;line-height:1.35}
.prof-email-line,.prof-member-line,.prof-premium-line{margin:0}
.prof-email-line{color:#4b5563;font-size:12px}
.prof-id-line{display:flex;align-items:center;gap:7px;flex-wrap:wrap;margin:0;color:#111827}
.prof-id-line strong{font-weight:600;letter-spacing:.01em}
.prof-copy-mini{width:20px;height:20px;border:0;background:transparent;color:#6b7280;display:inline-grid;place-items:center;padding:0;cursor:pointer;border-radius:5px;transition:background .18s ease,color .18s ease}
.prof-copy-mini:hover,.prof-copy-mini:focus{background:#111827;color:#fff;outline:0}
.prof-premium-line{color:var(--p-orange);font-weight:600}
.prof-chips{display:flex;flex-wrap:wrap;gap:8px;margin-top:12px}
.prof-chip{display:inline-flex;align-items:center;gap:6px;min-height:27px;padding:5px 11px;border-radius:999px;background:var(--p-green-soft);color:var(--p-green);font-size:12px;font-weight:700}
.prof-actions{width:184px;display:grid;gap:10px;flex:0 0 auto}
.prof-btn,.prof-mini,.prof-link{height:var(--btn-h);min-width:132px;padding:0 17px;border:0!important;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;gap:8px;background:#fff;color:#000!important;font-size:12px;font-weight:600;letter-spacing:0;line-height:1;white-space:nowrap;cursor:pointer;box-shadow:none!important;transition:background .18s ease,color .18s ease;transform:none!important}
.prof-btn svg,.prof-mini svg,.prof-link svg{flex:0 0 auto}
.prof-primary{background:var(--p-orange)!important;color:#111827!important}
.prof-link-primary{background:var(--p-orange)!important;color:#111827!important}
.prof-btn:hover,.prof-btn:focus,.prof-mini:hover,.prof-mini:focus,.prof-link:hover,.prof-link:focus{background:#111827!important;color:#fff!important}
.prof-btn:hover svg,.prof-mini:hover svg,.prof-link:hover svg{color:#fff}
.prof-btn:disabled{opacity:.58;cursor:not-allowed}
.prof-btn:disabled:hover{background:var(--p-orange)!important;border-color:transparent!important;color:#fff!important}
.prof-mini{min-width:74px}
.prof-link{width:100%;margin-top:10px;justify-content:space-between}
.prof-link span:first-child{color:inherit}
.prof-link span:last-child{font-size:18px;line-height:1}
.prof-info,.prof-widget{padding:18px;background:#fff}
.profile-left .prof-info{border:0;border-radius:0;padding:18px 0 0;box-shadow:none}
.profile-left .prof-info:hover,.profile-left .prof-hero:hover{background:#fff}
.profile-right .prof-widget{border:0;border-radius:0;background:transparent;padding:0;box-shadow:none}
.profile-right .prof-widget:hover{background:transparent}
.profile-right .prof-complete,.profile-right .prof-progress,.profile-right .prof-suggest{display:none!important}
.profile-right .prof-widget:first-child{display:none!important}
.profile-right .prof-widget:nth-child(3){display:none!important}
.prof-head{min-height:42px;display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin-bottom:12px}
.prof-title-wrap{display:flex;align-items:flex-start;gap:10px}
.prof-title-wrap:before{content:'';width:18px;height:4px;margin-top:8px;border-radius:999px;background:var(--p-orange);box-shadow:none;flex:0 0 auto}
.prof-card-title,.prof-widget-title{margin:0;color:#111827;font-family:var(--title);font-size:14.5px;font-weight:600;letter-spacing:.022em;line-height:1.35}
.prof-widget-title{display:flex;align-items:center;gap:9px;margin-bottom:12px}
.prof-widget-title svg{color:var(--p-orange);flex:0 0 auto}
.prof-subtitle{margin:4px 0 0;color:#4b5563;font-size:11px;font-weight:400;line-height:1.45}
.prof-section{padding:16px 0;border-top:1px solid var(--p-line)}
.prof-section:first-of-type{border-top:0;padding-top:4px}
.prof-section-title{display:flex;align-items:center;gap:9px;margin:0 0 12px;color:#111827;font-family:var(--title);font-size:14.5px;font-weight:600;letter-spacing:.022em}
.prof-section-title svg{color:var(--p-orange);flex:0 0 auto}
.prof-fields{display:grid;grid-template-columns:1fr 1fr;column-gap:42px}
.prof-field{display:grid;grid-template-columns:142px minmax(0,1fr);align-items:center;gap:12px;min-height:38px;padding:4px 0;border-bottom:1px dashed #e5e7eb}
.prof-field:nth-last-child(-n+2){border-bottom-color:transparent}
.prof-label{color:#111827;font-family:var(--font);font-size:12px;font-weight:600;letter-spacing:.003em}
.prof-value{color:#263244;font-size:13px;font-weight:400;line-height:1.35;word-break:break-word}
.prof-input{width:100%;height:36px;border:1px solid #d9dee8;border-radius:9px;background:#fff;color:#111827;padding:0 11px;font-size:13px;font-weight:500;outline:0;transition:.18s ease}
.prof-input:focus{border-color:var(--p-orange);box-shadow:0 0 0 4px rgba(255,122,0,.11)}
.prof-badge{display:inline-flex;align-items:center;justify-content:center;min-height:24px;padding:4px 10px;border-radius:999px;background:var(--p-green-soft);color:var(--p-green);font-size:11px;font-weight:700}
.prof-savebar{position:sticky;bottom:18px;z-index:10;margin-top:10px;padding:12px;border:1px solid #111827;border-radius:8px;background:rgba(255,255,255,.94);box-shadow:none;backdrop-filter:blur(14px);display:flex;align-items:center;justify-content:space-between;gap:12px}
.prof-save-text{margin:0;color:#4b5563;font-size:12px;font-weight:500;line-height:1.35}
.prof-save-actions{display:flex;gap:10px;align-items:center;justify-content:flex-end}
.prof-complete{display:grid;grid-template-columns:66px 1fr;gap:12px;align-items:center}
.prof-ring{--v:88;width:66px;height:66px;border-radius:50%;display:grid;place-items:center;background:conic-gradient(var(--p-complete) calc(var(--v)*1%),#edf0f4 0);position:relative}
.prof-ring:before{content:'';position:absolute;width:48px;height:48px;border-radius:50%;background:#fff}
.prof-ring span{position:relative;color:#111827;font-size:14px;font-weight:800}
.prof-widget-copy{margin:0;color:#4b5563;font-size:12px;line-height:1.45}
.prof-progress{height:7px;margin:12px 0;border-radius:999px;background:#edf0f4;overflow:hidden}
.prof-progress span{display:block;width:88%;height:100%;border-radius:999px;background:var(--p-complete)}
.prof-suggest{margin-top:10px;padding:12px;border-radius:13px;background:var(--p-orange-soft);border:1px dashed rgba(255,122,0,.42);color:#7c4a28;font-size:12px;font-weight:500;line-height:1.55}
.prof-pref,.prof-act{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:7px 0;color:#4b5563;font-size:12px;font-weight:500;line-height:1.35}
.prof-pref-label{color:#263244;font-size:12px;font-weight:500}
.prof-pref-side{display:inline-flex;align-items:center;gap:0;flex:0 0 auto}
.prof-toggle{width:39px;height:22px;padding:3px;border:0;border-radius:999px;background:#d1d5db;display:inline-flex;align-items:center;justify-content:flex-start;cursor:pointer;box-shadow:inset 0 1px 3px rgba(15,23,42,.12);transition:.18s ease}
.prof-toggle.is-off{background:#d1d5db;box-shadow:inset 0 1px 3px rgba(15,23,42,.12)}
.prof-toggle.is-on{background:var(--p-green);box-shadow:none}
.prof-toggle-knob{width:16px;height:16px;border-radius:999px;background:#fff;color:var(--p-green);display:grid;place-items:center;box-shadow:0 2px 5px rgba(0,0,0,.14);transform:translateX(0);transition:.18s ease}
.prof-toggle-knob svg{display:none}
.prof-toggle.is-on .prof-toggle-knob{transform:translateX(17px);color:var(--p-green)}
.prof-pref-state{display:none!important;min-width:22px;text-align:right;font-size:11px;font-weight:800}
.prof-pref-state.on{color:var(--p-green)}
.prof-pref-state.off{color:var(--p-green)}
.prof-stats{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.prof-stat{min-height:72px;border:1px solid #111827;border-radius:8px;padding:11px;display:flex;align-items:center;gap:11px;background:#fff;transition:.18s ease}
.prof-stat:hover{background:#fff3e6;border-color:#111827}
.prof-ico{width:38px;height:38px;border-radius:13px;display:grid;place-items:center;flex:0 0 auto}
.ico-orange{background:var(--p-orange-soft);color:var(--p-orange)}
.ico-green{background:var(--p-green-soft);color:var(--p-green)}
.ico-purple{background:var(--p-purple-soft);color:var(--p-purple)}
.ico-yellow{background:var(--p-yellow-soft);color:var(--p-yellow)}
.prof-num{display:block;color:#111827;font-size:16px;font-weight:800;line-height:1}
.prof-small{display:block;margin-top:4px;color:#6b7280;font-size:11px;font-weight:500;line-height:1.15}
.prof-act{align-items:flex-start;border-bottom:1px solid #eef0f4;padding:8px 0}
.prof-act:last-of-type{border-bottom:0}
.prof-act-main{display:flex;gap:8px;min-width:0}
.prof-dot2{width:17px;height:17px;border-radius:50%;border:1px solid #9ca3af;display:grid;place-items:center;flex:0 0 auto}
.prof-dot2:after{content:'';width:5px;height:5px;border-radius:50%;background:#6b7280}
.prof-act-text{font-size:12px;font-weight:500;color:#374151}
.prof-time{font-size:11px;font-weight:500;color:#7c8797;white-space:nowrap}
.prof-toast{position:fixed;left:50%;top:88px;right:auto;bottom:auto;z-index:100000;min-width:260px;max-width:420px;border:1px solid #111827;border-radius:10px;padding:12px 15px;background:#111827;color:#fff;box-shadow:none;display:flex;align-items:center;justify-content:center;gap:10px;font-family:var(--title);font-size:12px;font-weight:600;letter-spacing:0;transform:translateX(-50%)}
.prof-modal{position:fixed;inset:0;z-index:80;background:rgba(15,23,42,.56);display:grid;place-items:center;padding:20px}
.prof-crop{width:min(640px,100%);background:#fff;border-radius:8px;border:1px solid #111827;box-shadow:none;overflow:hidden}
.prof-crop-head{padding:18px 20px;border-bottom:1px solid #eef0f4;display:flex;align-items:flex-start;justify-content:space-between;gap:16px}
.prof-crop-head h3{margin:0;font-family:var(--title);font-size:18px;font-weight:600;color:#111827;letter-spacing:.005em}
.prof-crop-sub{margin:3px 0 0;color:#6b7280;font-size:12px;font-weight:400;line-height:1.45}
.prof-x{border:1px solid var(--p-line);background:#fff;border-radius:11px;width:36px;height:36px;cursor:pointer;color:#111827;display:grid;place-items:center;transition:background .18s ease,border-color .18s ease,color .18s ease}
.prof-x:hover{background:#111827;border-color:#111827;color:#fff}
.prof-stage{height:390px;background:#090d16;position:relative;overflow:hidden;display:grid;place-items:center;touch-action:none;user-select:none;cursor:grab}
.prof-stage.is-dragging{cursor:grabbing}
.prof-stage:before{content:'';position:absolute;inset:0;background:linear-gradient(rgba(255,255,255,.045) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.045) 1px,transparent 1px),radial-gradient(circle at center,rgba(255,255,255,.05),transparent 58%);background-size:24px 24px,24px 24px,100% 100%;pointer-events:none}
.prof-stage:after{content:'';position:absolute;width:var(--crop);height:var(--crop);border-radius:50%;box-shadow:0 0 0 999px rgba(0,0,0,.54);border:3px solid #fff;pointer-events:none}
.prof-stage img{position:absolute;left:50%;top:50%;width:var(--w);height:var(--h);max-width:none;max-height:none;user-select:none;pointer-events:none;transform:translate(-50%,-50%) translate(var(--x),var(--y)) scale(var(--z));transform-origin:center;will-change:transform}
.prof-stage-tip{position:absolute;left:50%;bottom:18px;transform:translateX(-50%);z-index:2;padding:7px 12px;border-radius:999px;background:rgba(255,255,255,.92);color:#111827;font-size:11px;font-weight:600;letter-spacing:.01em;box-shadow:0 8px 20px rgba(0,0,0,.16);pointer-events:none}
.prof-crop-body{padding:16px 20px;background:#fff}
.prof-crop-toolrow{display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:14px}
.prof-preview-wrap{display:flex;align-items:center;gap:10px;min-width:0}
.prof-preview{width:58px;height:58px;border-radius:50%;overflow:hidden;position:relative;background:#f3f4f6;border:2px solid #fff;box-shadow:0 8px 22px rgba(15,23,42,.14);flex:0 0 auto}
.prof-preview img{position:absolute;left:50%;top:50%;width:var(--pw);height:var(--ph);max-width:none;max-height:none;transform:translate(-50%,-50%) translate(var(--px),var(--py)) scale(var(--pz));transform-origin:center;pointer-events:none;user-select:none}
.prof-crop-help{min-width:0}
.prof-crop-help strong{display:block;color:#111827;font-family:var(--title);font-size:13px;font-weight:600;letter-spacing:.006em;line-height:1.2}
.prof-crop-help span{display:block;margin-top:3px;color:#6b7280;font-size:11px;font-weight:400;line-height:1.35}
.prof-zoom-pct{min-width:48px;text-align:right;color:#111827;font-size:12px;font-weight:700}
.prof-zoom-row{display:grid;grid-template-columns:38px minmax(0,1fr) 38px;align-items:center;gap:10px}
.prof-icon-btn{width:38px;height:38px;min-width:0;padding:0;border:1px solid var(--p-line2);border-radius:11px;background:#fff;color:#111827;display:grid;place-items:center;cursor:pointer;font-size:18px;font-weight:700;box-shadow:0 6px 16px rgba(15,23,42,.04);transition:background .18s ease,border-color .18s ease,color .18s ease,box-shadow .18s ease}
.prof-icon-btn:hover,.prof-icon-btn:focus{background:#111827;border-color:#111827;color:#fff;box-shadow:0 12px 24px rgba(17,24,39,.20)}
.prof-range-wrap{min-width:0}
.prof-range-head{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:5px}
.prof-range{width:100%;accent-color:var(--p-orange);display:block}
.prof-controls{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:13px}
.prof-crop-actions{display:flex;justify-content:flex-end;gap:10px;padding:15px 20px;border-top:1px solid #eef0f4;background:#fff}
@media(max-width:1180px){.profile-grid{grid-template-columns:1fr}
.profile-right{display:grid;grid-template-columns:repeat(2,minmax(0,1fr))}
}
@media(max-width:760px){.profile-shell{padding:0 12px 18px}
.profile-head{display:grid}.profile-date{width:100%}
.prof-hero,.prof-main{flex-direction:column;align-items:flex-start}
.prof-actions{width:100%;grid-template-columns:1fr 1fr}
.prof-fields,.profile-right{grid-template-columns:1fr}
.prof-field{grid-template-columns:1fr;gap:4px;padding:8px 0}
.prof-savebar{position:static;flex-direction:column;align-items:stretch}
.prof-save-actions{display:grid;grid-template-columns:1fr 1fr}
.prof-btn{width:100%;min-width:0}
}
@media(max-width:480px){.prof-actions,.prof-save-actions,.prof-stats,.prof-controls{grid-template-columns:1fr}
.prof-stage{height:300px}
.prof-name{font-size:32px}
}
.profile-page .profile-grid{align-items:stretch!important}
.profile-page .profile-left{border:1px solid #111827!important;border-radius:8px!important;background:#fff!important;padding:18px!important;gap:0!important}
.profile-page .profile-left>.prof-card{border:0!important;border-radius:0!important;background:transparent!important;box-shadow:none!important}
.profile-page .profile-left>.prof-hero{padding:0 0 18px!important;border-bottom:1px solid #111827!important}
.profile-page .profile-left>.prof-info{padding:18px 0 0!important}
.profile-page .profile-left>.prof-card:hover{background:transparent!important;box-shadow:none!important}
.profile-page .profile-right{border:0!important;background:transparent!important;box-shadow:none!important;align-content:start!important}
.profile-page .profile-right>.prof-widget{border:0!important;border-radius:0!important;background:transparent!important;box-shadow:none!important;padding:0!important}
.profile-page .profile-right>.prof-widget:hover{border:0!important;background:transparent!important;box-shadow:none!important}
.profile-page .profile-right>.prof-widget:first-child,.profile-page .profile-right>.prof-widget:nth-child(3){display:none!important}
.profile-page .profile-right .prof-pref,.profile-page .profile-right .prof-act{border-bottom:1px solid #eef1f5!important}
.profile-page .profile-right .prof-link{width:100%!important}



/* FINAL PROFILE CLEANUP: consistent buttons, subtle layout, calendar, and spacing */
.profile-page{background:#fff!important;}
.profile-page .profile-left{border:0!important;border-radius:0!important;background:transparent!important;padding:0!important;gap:0!important;box-shadow:none!important;}
.profile-page .profile-left>.prof-card{border:0!important;border-radius:0!important;background:#fff!important;box-shadow:none!important;}
.profile-page .profile-left>.prof-hero{padding:0 0 16px!important;border-bottom:1px solid rgba(17,24,39,.18)!important;}
.profile-page .profile-left>.prof-info{padding:14px 0 0!important;background:#fff!important;}
.profile-page .prof-title-wrap:before{display:none!important;}
.profile-page .prof-head{min-height:auto!important;margin-bottom:6px!important;}
.profile-page .prof-section{padding:10px 0!important;border-top:1px solid rgba(17,24,39,.08)!important;}
.profile-page .prof-section:first-of-type{border-top:0!important;padding-top:2px!important;}
.profile-page .prof-section-title{margin-bottom:8px!important;font-size:13.5px!important;}
.profile-page .prof-fields{column-gap:28px!important;row-gap:0!important;}
.profile-page .prof-field{min-height:32px!important;padding:3px 0!important;border-bottom:1px dashed rgba(17,24,39,.10)!important;grid-template-columns:132px minmax(0,1fr)!important;}
.profile-page .prof-label{font-size:11.5px!important;}
.profile-page .prof-value{font-size:12.5px!important;}
.profile-page .prof-input{height:34px!important;border-radius:8px!important;}
.profile-page .profile-date{height:38px!important;min-width:164px!important;padding:0 13px!important;border:1px solid #111827!important;border-radius:8px!important;background:#fff!important;color:#111827!important;font-size:11.5px!important;font-weight:500!important;box-shadow:none!important;cursor:pointer!important;transition:background .18s ease,color .18s ease,border-color .18s ease!important;}
.profile-page .profile-date:hover,.profile-page .profile-date:focus{background:#111827!important;color:#fff!important;border-color:#111827!important;outline:0!important;}
.profile-page .profile-date:hover svg,.profile-page .profile-date:focus svg{color:#fff!important;}
.profile-page .prof-btn,.profile-page .prof-mini,.profile-page .prof-link{height:38px!important;min-width:112px!important;padding:0 14px!important;border:1px solid #111827!important;border-radius:999px!important;background:#fff!important;color:#111827!important;font-size:11px!important;font-weight:600!important;box-shadow:none!important;transition:background .18s ease,color .18s ease,border-color .18s ease!important;}
.profile-page .prof-btn:hover,.profile-page .prof-btn:focus,.profile-page .prof-mini:hover,.profile-page .prof-mini:focus,.profile-page .prof-link:hover,.profile-page .prof-link:focus{background:#111827!important;border-color:#111827!important;color:#fff!important;outline:0!important;}
.profile-page .prof-btn:hover svg,.profile-page .prof-btn:focus svg,.profile-page .prof-mini:hover svg,.profile-page .prof-mini:focus svg,.profile-page .prof-link:hover svg,.profile-page .prof-link:focus svg{color:#fff!important;}
.profile-page .prof-primary,.profile-page .prof-link-primary{border-color:transparent!important;background:linear-gradient(90deg,var(--p-orange),#ffab0a)!important;color:#111827!important;}
.profile-page .prof-primary:hover,.profile-page .prof-primary:focus,.profile-page .prof-link-primary:hover,.profile-page .prof-link-primary:focus{background:#111827!important;border-color:#111827!important;color:#fff!important;}
.profile-page .prof-save-actions .prof-primary{background:var(--p-green)!important;border-color:var(--p-green)!important;color:#fff!important;}
.profile-page .prof-save-actions .prof-primary:hover,.profile-page .prof-save-actions .prof-primary:focus{background:#111827!important;border-color:#111827!important;color:#fff!important;}
.profile-page .prof-actions{width:172px!important;gap:8px!important;}
.profile-page .prof-actions .prof-btn{width:100%!important;min-width:0!important;}
.profile-page .prof-link{width:auto!important;min-width:150px!important;margin:10px auto 0!important;justify-content:center!important;gap:10px!important;}
.profile-page .profile-right .prof-link{width:calc(100% - 44px)!important;max-width:210px!important;min-width:0!important;}
.profile-page .prof-widget-title{justify-content:flex-start!important;text-align:left!important;margin-bottom:10px!important;}
.profile-page .prof-widget-title svg{color:var(--p-orange)!important;}
.profile-page .profile-right .prof-widget:nth-of-type(2) .prof-widget-title svg{color:var(--p-orange)!important;}
.profile-page .profile-right .prof-widget:nth-of-type(4) .prof-widget-title svg{color:var(--p-orange)!important;}
.profile-page .prof-pref{min-height:34px!important;padding:7px 0!important;}
.profile-page .prof-pref-label{font-size:11.5px!important;}
.profile-page .prof-toggle{width:40px!important;height:22px!important;padding:3px!important;background:#d1d5db!important;border:0!important;}
.profile-page .prof-toggle.is-on{background:var(--p-green)!important;}
.profile-page .prof-toggle-knob{width:16px!important;height:16px!important;}
.profile-page .prof-toggle.is-on .prof-toggle-knob{transform:translateX(18px)!important;}
.profile-page .prof-act{padding:7px 0!important;}
.profile-page .prof-dot2{border-color:#94a3b8!important;}
.profile-page .prof-dot2:after{background:#64748b!important;}
.profile-page .prof-savebar{border:1px solid rgba(17,24,39,.18)!important;background:#fff!important;border-radius:8px!important;box-shadow:none!important;padding:10px!important;}
.profile-page .prof-crop-actions .prof-light:hover,.profile-page .prof-crop-actions .prof-light:focus{background:#111827!important;color:#fff!important;border-color:#111827!important;}
.profile-page .prof-icon-btn:hover,.profile-page .prof-icon-btn:focus{background:#111827!important;border-color:#111827!important;color:#fff!important;}
.profile-page .prof-controls{display:none!important;}
.profile-calendar-overlay{position:fixed;inset:0;z-index:99990;display:grid;place-items:center;padding:18px;background:rgba(17,24,39,.36);backdrop-filter:blur(9px);}
.profile-calendar-modal{width:min(390px,100%);border:1px solid #111827;border-radius:16px;background:#fff;box-shadow:0 26px 80px rgba(15,23,42,.22);overflow:hidden;}
.profile-calendar-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;padding:18px;border-bottom:1px solid #eef0f4;}
.profile-calendar-head h3{margin:0;font-family:var(--title);font-size:16px;font-weight:700;color:#111827;}
.profile-calendar-head p{margin:4px 0 0;color:#6b7280;font-size:11px;line-height:1.4;}
.profile-calendar-x{width:34px;height:34px;border:0;border-radius:9px;background:#fff;color:#111827;font-size:22px;line-height:1;cursor:pointer;transition:.18s;}
.profile-calendar-x:hover,.profile-calendar-x:focus{background:#111827;color:#fff;outline:0;}
.profile-calendar-body{padding:18px;}
.profile-calendar-input{width:100%;height:42px;border:1px solid #111827;border-radius:8px;background:#fff;color:#111827;padding:0 12px;font-family:var(--font);font-size:12px;font-weight:600;outline:0;}
.profile-calendar-input:focus{border-color:#111827;box-shadow:0 0 0 3px rgba(17,24,39,.08);}
.profile-calendar-actions{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:15px 18px;border-top:1px solid #eef0f4;}
@media(max-width:760px){.profile-page .profile-left{padding:0!important}.profile-page .prof-field{grid-template-columns:1fr!important}.profile-page .prof-actions{width:100%!important}.profile-page .prof-link{width:100%!important;max-width:none!important}.profile-calendar-actions{display:grid;grid-template-columns:1fr 1fr}.profile-calendar-actions .prof-btn{width:100%!important;}}


/* FINAL USER FIX: upload hover black, centered right-side buttons, green upload crop button */
.profile-page .prof-actions .prof-light,
.profile-page button.prof-light,
.profile-page .prof-crop-actions .prof-light{
    border:1px solid #111827!important;
    background:#fff!important;
    color:#111827!important;
    border-radius:999px!important;
    height:38px!important;
    min-width:112px!important;
    padding:0 14px!important;
    box-shadow:none!important;
}
.profile-page .prof-actions .prof-light:hover,
.profile-page .prof-actions .prof-light:focus,
.profile-page button.prof-light:hover,
.profile-page button.prof-light:focus,
.profile-page .prof-crop-actions .prof-light:hover,
.profile-page .prof-crop-actions .prof-light:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:0!important;
    box-shadow:none!important;
}
.profile-page .prof-actions .prof-light:hover svg,
.profile-page .prof-actions .prof-light:focus svg,
.profile-page button.prof-light:hover svg,
.profile-page button.prof-light:focus svg{
    color:#fff!important;
}
.profile-page .profile-right .prof-widget-title{
    justify-content:flex-start!important;
    text-align:left!important;
}
.profile-page .profile-right .prof-link,
.profile-page .profile-right .prof-link-primary{
    width:190px!important;
    max-width:190px!important;
    min-width:190px!important;
    height:38px!important;
    margin:12px auto 0!important;
    padding:0 16px!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:10px!important;
    border-radius:999px!important;
    text-align:center!important;
}
.profile-page .profile-right .prof-link span:first-child,
.profile-page .profile-right .prof-link-primary span:first-child{
    flex:0 0 auto!important;
}
.profile-page .profile-right .prof-link span:last-child,
.profile-page .profile-right .prof-link-primary span:last-child{
    flex:0 0 auto!important;
    font-size:16px!important;
    line-height:1!important;
}
.profile-page .prof-success{
    background:var(--p-green)!important;
    border:1px solid var(--p-green)!important;
    color:#fff!important;
    border-radius:999px!important;
    height:38px!important;
    min-width:112px!important;
    padding:0 18px!important;
    box-shadow:none!important;
}
.profile-page .prof-success:hover,
.profile-page .prof-success:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:0!important;
    box-shadow:none!important;
}
.profile-page .prof-crop-actions{
    justify-content:flex-end!important;
    gap:10px!important;
}
.profile-page .prof-crop-actions .prof-btn{
    width:120px!important;
    min-width:120px!important;
    max-width:120px!important;
}



/* FINAL FIX: green modal Upload button + aligned activity/preference buttons + hidden show less until view all */
.profile-page .prof-crop-actions .prof-success,
.profile-page button.prof-success,
.profile-page .prof-btn.prof-success{
    background:var(--p-green)!important;
    border:1px solid var(--p-green)!important;
    color:#fff!important;
    border-radius:999px!important;
    height:38px!important;
    width:120px!important;
    min-width:120px!important;
    max-width:120px!important;
    padding:0 18px!important;
    box-shadow:none!important;
}
.profile-page .prof-crop-actions .prof-success:hover,
.profile-page .prof-crop-actions .prof-success:focus,
.profile-page button.prof-success:hover,
.profile-page button.prof-success:focus,
.profile-page .prof-btn.prof-success:hover,
.profile-page .prof-btn.prof-success:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:0!important;
    box-shadow:none!important;
}
.profile-page .profile-right .prof-widget{
    display:block!important;
    width:100%!important;
}
.profile-page .profile-right .prof-widget .prof-link,
.profile-page .profile-right .prof-widget .prof-link-primary{
    width:190px!important;
    min-width:190px!important;
    max-width:190px!important;
    height:38px!important;
    margin:12px auto 0!important;
    padding:0 16px!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:10px!important;
    border-radius:999px!important;
    text-align:center!important;
    position:relative!important;
    left:0!important;
    right:0!important;
    float:none!important;
}
.profile-page .profile-right .prof-widget .prof-link-primary{
    background:linear-gradient(90deg,var(--p-orange),#ffab0a)!important;
    border:1px solid transparent!important;
    color:#111827!important;
}
.profile-page .profile-right .prof-widget .prof-link{
    background:#fff!important;
    border:1px solid #111827!important;
    color:#111827!important;
}
.profile-page .profile-right .prof-widget .prof-link-primary:hover,
.profile-page .profile-right .prof-widget .prof-link-primary:focus,
.profile-page .profile-right .prof-widget .prof-link:hover,
.profile-page .profile-right .prof-widget .prof-link:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:0!important;
    box-shadow:none!important;
}
.profile-page .profile-right .prof-widget .prof-link span,
.profile-page .profile-right .prof-widget .prof-link-primary span{
    flex:0 0 auto!important;
}
.profile-page .profile-right .prof-widget .prof-link span:last-child,
.profile-page .profile-right .prof-widget .prof-link-primary span:last-child{
    font-size:16px!important;
    line-height:1!important;
}
.profile-page .prof-act[x-cloak],
.profile-page button[x-cloak]{display:none!important;}


/* FINAL OVERRIDE: restore Manage Preferences and View All Activity to same orange style as Edit Profile */
.profile-page .profile-right .prof-widget .prof-link-primary{
    background:linear-gradient(90deg,var(--p-orange),#ffab0a)!important;
    border:1px solid transparent!important;
    color:#111827!important;
    box-shadow:none!important;
}
.profile-page .profile-right .prof-widget .prof-link-primary:hover,
.profile-page .profile-right .prof-widget .prof-link-primary:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:0!important;
    box-shadow:none!important;
}
.profile-page .profile-right .prof-widget .prof-link-primary:hover span,
.profile-page .profile-right .prof-widget .prof-link-primary:focus span{
    color:#fff!important;
}



/* FINAL FIX: restore one combined box for Eyra Mae Alla + Profile Information */
.profile-page .profile-left{
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    padding:18px!important;
    gap:0!important;
    box-shadow:none!important;
}
.profile-page .profile-left>.prof-card{
    border:0!important;
    border-radius:0!important;
    background:transparent!important;
    box-shadow:none!important;
}
.profile-page .profile-left>.prof-hero{
    padding:0 0 16px!important;
    border-bottom:1px solid rgba(17,24,39,.18)!important;
}
.profile-page .profile-left>.prof-info{
    padding:14px 0 0!important;
    background:transparent!important;
}
.profile-page .profile-left>.prof-card:hover{
    background:transparent!important;
    box-shadow:none!important;
}


/* FINAL PROFILE PHOTO FLOW: initials avatar, crop upload, Facebook-style view/change menu */
.profile-page .prof-avatar{cursor:pointer;position:relative;transition:filter .18s ease,transform .18s ease;}
.profile-page .prof-avatar:hover,.profile-page .prof-avatar:focus{filter:brightness(.96);outline:0;transform:none!important;}
.profile-page .prof-photo-menu{position:absolute;left:0;top:calc(100% + 10px);z-index:70;width:190px;border:1px solid #111827;border-radius:12px;background:#fff;box-shadow:0 18px 42px rgba(15,23,42,.14);padding:7px;}
.profile-page .prof-photo-menu:before{content:'';position:absolute;left:18px;top:-7px;width:12px;height:12px;background:#fff;border-left:1px solid #111827;border-top:1px solid #111827;transform:rotate(45deg);}
.profile-page .prof-photo-option{position:relative;z-index:1;width:100%;height:36px;border:0;border-radius:9px;background:#fff;color:#111827;display:flex;align-items:center;gap:9px;padding:0 10px;font-size:11.5px;font-weight:600;text-align:left;cursor:pointer;transition:background .18s ease,color .18s ease;}
.profile-page .prof-photo-option svg{flex:0 0 auto;color:currentColor;}
.profile-page .prof-photo-option:hover,.profile-page .prof-photo-option:focus{background:#111827;color:#fff;outline:0;}
.profile-page .prof-photo-view-modal{width:min(680px,100%);border:1px solid #111827;border-radius:14px;background:#fff;box-shadow:0 26px 80px rgba(15,23,42,.22);overflow:hidden;}
.profile-page .prof-photo-view-head{padding:14px 16px;border-bottom:1px solid #eef0f4;display:flex;align-items:center;justify-content:space-between;gap:12px;}
.profile-page .prof-photo-view-head h3{margin:0;font-family:var(--title);font-size:16px;font-weight:600;color:#111827;}
.profile-page .prof-photo-view-body{padding:18px;background:#0b0f16;display:flex;align-items:center;justify-content:center;height:min(70vh,520px);min-height:380px;overflow:hidden;}
.profile-page .prof-photo-view-body img{width:auto!important;height:auto!important;max-width:100%!important;max-height:100%!important;border:0!important;border-radius:0!important;object-fit:contain!important;background:transparent!important;display:block!important;box-shadow:none!important;clip-path:none!important;}
.profile-page .prof-photo-view-actions{padding:14px 16px;display:flex;justify-content:flex-end;gap:10px;border-top:1px solid #eef0f4;background:#fff;}
.profile-page .prof-crop-actions .prof-success{background:var(--p-green)!important;border-color:var(--p-green)!important;color:#fff!important;}
.profile-page .prof-crop-actions .prof-success:hover,.profile-page .prof-crop-actions .prof-success:focus{background:#111827!important;border-color:#111827!important;color:#fff!important;}



/* FINAL USER REQUEST: remove right-side widgets, keep calendar/left spacing, and set My Profile box to 1200px */
.profile-page .profile-shell{
    max-width:1490px!important;
}
.profile-page .profile-grid{
    grid-template-columns:minmax(0,1200px)!important;
    justify-content:start!important;
    gap:0!important;
    width:100%!important;
}
.profile-page .profile-left{
    width:100%!important;
    max-width:1200px!important;
}
.profile-page .profile-right{
    display:none!important;
}
.profile-page .profile-title-wrap .profile-sub{
    max-width:620px!important;
}
@media(max-width:1180px){
    .profile-page .profile-grid{grid-template-columns:minmax(0,1fr)!important;}
    .profile-page .profile-left{max-width:none!important;}
}

/* FINAL USER REQUEST: My Profile Address Details hidden Manage Address dropdown only */
.profile-page .prof-manage-address-wrap{
    margin-top:12px!important;
    border-top:1px solid rgba(17,24,39,.10)!important;
    padding-top:10px!important;
}
.profile-page .prof-manage-address-toggle{
    width:100%!important;
    min-height:42px!important;
    border:0!important;
    border-bottom:1px solid #e5e7eb!important;
    background:transparent!important;
    color:#111827!important;
    display:grid!important;
    grid-template-columns:minmax(0,1fr) auto 20px!important;
    align-items:center!important;
    gap:12px!important;
    padding:8px 0!important;
    text-align:left!important;
    cursor:pointer!important;
    box-shadow:none!important;
    transform:none!important;
}
.profile-page .prof-manage-address-toggle:hover,
.profile-page .prof-manage-address-toggle:focus{
    background:transparent!important;
    color:#ff7a00!important;
    outline:none!important;
}
.profile-page .prof-manage-address-title{
    display:inline-flex!important;
    align-items:center!important;
    gap:8px!important;
    color:inherit!important;
    font-family:var(--title)!important;
    font-size:13.5px!important;
    font-weight:700!important;
    line-height:1.25!important;
}
.profile-page .prof-manage-address-title svg,
.profile-page .prof-manage-address-chevron{
    color:currentColor!important;
    flex:0 0 auto!important;
}
.profile-page .prof-manage-address-meta{
    color:#6b7280!important;
    font-size:11px!important;
    font-weight:500!important;
    white-space:nowrap!important;
}
.profile-page .prof-manage-address-toggle:hover .prof-manage-address-meta,
.profile-page .prof-manage-address-toggle:focus .prof-manage-address-meta{
    color:#ff7a00!important;
}
.profile-page .prof-manage-address-chevron{
    transition:transform .18s ease!important;
}
.profile-page .prof-manage-address-chevron.is-open{
    transform:rotate(180deg)!important;
}
.profile-page .prof-manage-address-panel{
    padding:8px 0 2px!important;
    background:transparent!important;
}
.profile-page .prof-manage-address-row{
    display:grid!important;
    grid-template-columns:minmax(0,1fr) 84px!important;
    align-items:center!important;
    gap:14px!important;
    min-height:56px!important;
    padding:9px 0!important;
    border-bottom:1px solid #e8ebf0!important;
    background:transparent!important;
}
.profile-page .prof-manage-address-row:last-child{
    border-bottom:0!important;
}
.profile-page .prof-manage-address-left{
    display:flex!important;
    align-items:flex-start!important;
    gap:10px!important;
    min-width:0!important;
}
.profile-page .prof-manage-address-icon{
    width:21px!important;
    height:21px!important;
    flex:0 0 21px!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    color:#ff7a00!important;
    background:transparent!important;
    border:0!important;
    margin-top:1px!important;
}
.profile-page .prof-manage-address-name{
    margin:0!important;
    color:#111827!important;
    font-size:12px!important;
    font-weight:700!important;
    line-height:1.25!important;
}
.profile-page .prof-manage-address-text{
    margin:3px 0 0!important;
    color:#4b5563!important;
    font-size:11px!important;
    font-weight:400!important;
    line-height:1.35!important;
}
.profile-page .prof-manage-address-edit{
    height:32px!important;
    min-width:76px!important;
    border:1px solid #ff7a00!important;
    border-radius:999px!important;
    background:#fff!important;
    color:#ff7a00!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    padding:0 13px!important;
    font-size:11px!important;
    font-weight:700!important;
    cursor:pointer!important;
    box-shadow:none!important;
    transform:none!important;
}
.profile-page .prof-manage-address-edit:hover,
.profile-page .prof-manage-address-edit:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:none!important;
}
@media(max-width:760px){
    .profile-page .prof-manage-address-toggle{
        grid-template-columns:1fr 20px!important;
    }
    .profile-page .prof-manage-address-meta{
        grid-column:1 / -1!important;
        white-space:normal!important;
    }
    .profile-page .prof-manage-address-row{
        grid-template-columns:1fr!important;
    }
    .profile-page .prof-manage-address-edit{
        justify-self:start!important;
    }
}


/* FINAL FIX: Manage Address must display exact saved text first; editable fields appear only after clicking its Edit button. */
.profile-page .prof-manage-address-row.is-editing{
    grid-template-columns:1fr!important;
    align-items:start!important;
    gap:10px!important;
    padding:12px 0!important;
}
.profile-page .prof-manage-address-editor{
    width:100%!important;
    display:grid!important;
    gap:10px!important;
    background:transparent!important;
    border:0!important;
    box-shadow:none!important;
}
.profile-page .prof-manage-address-editor-head{
    display:flex!important;
    align-items:center!important;
    justify-content:space-between!important;
    gap:12px!important;
}
.profile-page .prof-manage-address-editor-title{
    margin:0!important;
    font-size:12px!important;
    font-weight:700!important;
    color:#111827!important;
}
.profile-page .prof-manage-address-editor-grid{
    display:grid!important;
    grid-template-columns:repeat(2,minmax(0,1fr))!important;
    gap:9px 14px!important;
}
.profile-page .prof-manage-address-field{
    display:grid!important;
    gap:5px!important;
}
.profile-page .prof-manage-address-field label{
    color:#111827!important;
    font-size:11px!important;
    font-weight:600!important;
}
.profile-page .prof-manage-address-input{
    width:100%!important;
    height:36px!important;
    border:1px solid #d9dee8!important;
    border-radius:9px!important;
    background:#fff!important;
    color:#111827!important;
    padding:0 11px!important;
    font-size:12px!important;
    font-weight:500!important;
    outline:0!important;
}
.profile-page .prof-manage-address-input:focus{
    border-color:#ff7a00!important;
    box-shadow:0 0 0 3px rgba(255,122,0,.10)!important;
}
.profile-page .prof-manage-address-editor-actions{
    display:flex!important;
    justify-content:flex-end!important;
    align-items:center!important;
    gap:8px!important;
}
.profile-page .prof-manage-address-cancel,
.profile-page .prof-manage-address-save{
    height:32px!important;
    min-width:76px!important;
    border-radius:999px!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    padding:0 13px!important;
    font-size:11px!important;
    font-weight:700!important;
    cursor:pointer!important;
    box-shadow:none!important;
    transform:none!important;
}
.profile-page .prof-manage-address-cancel{
    border:1px solid #111827!important;
    background:#fff!important;
    color:#111827!important;
}
.profile-page .prof-manage-address-save{
    border:1px solid #16a34a!important;
    background:#16a34a!important;
    color:#fff!important;
}
.profile-page .prof-manage-address-cancel:hover,
.profile-page .prof-manage-address-cancel:focus,
.profile-page .prof-manage-address-save:hover,
.profile-page .prof-manage-address-save:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:none!important;
}
.profile-page .prof-manage-address-value{
    margin:3px 0 0!important;
    color:#374151!important;
    font-size:11px!important;
    line-height:1.35!important;
    font-weight:500!important;
}
@media(max-width:760px){
    .profile-page .prof-manage-address-editor-grid{grid-template-columns:1fr!important;}
    .profile-page .prof-manage-address-editor-actions{justify-content:flex-start!important;}
}


/* FINAL ADDRESS DROPDOWN V3: Shopee-like saved address list with Default / Work / Branch Pickup labels */
.profile-page .prof-manage-address-panel{
    padding:10px 0 2px!important;
}
.profile-page .prof-manage-address-option{
    width:100%!important;
    display:grid!important;
    grid-template-columns:28px minmax(0,1fr) 86px!important;
    align-items:center!important;
    gap:14px!important;
    min-height:74px!important;
    padding:12px 0!important;
    border-bottom:1px solid #e8ebf0!important;
    background:transparent!important;
}
.profile-page .prof-manage-address-option:last-child{
    border-bottom:0!important;
}
.profile-page .prof-manage-address-option:hover{
    background:transparent!important;
}
.profile-page .prof-manage-address-main{
    min-width:0!important;
}
.profile-page .prof-manage-address-topline{
    display:flex!important;
    align-items:center!important;
    gap:7px!important;
    flex-wrap:wrap!important;
    margin:0 0 3px!important;
}
.profile-page .prof-manage-address-recipient{
    color:#111827!important;
    font-size:12.3px!important;
    font-weight:750!important;
    line-height:1.25!important;
}
.profile-page .prof-manage-address-chip{
    display:inline-flex!important;
    align-items:center!important;
    min-height:18px!important;
    padding:0!important;
    border:0!important;
    background:transparent!important;
    border-radius:0!important;
    font-size:10.5px!important;
    font-weight:800!important;
    line-height:1!important;
}
.profile-page .prof-manage-address-chip.default,
.profile-page .prof-manage-address-phone{
    color:#16a34a!important;
}
.profile-page .prof-manage-address-chip.work,
.profile-page .prof-manage-address-chip.branch{
    color:#ff7a00!important;
}
.profile-page .prof-manage-address-phone{
    margin:0 0 3px!important;
    font-size:11.2px!important;
    font-weight:650!important;
    line-height:1.25!important;
}
.profile-page .prof-manage-address-line{
    margin:0!important;
    color:#374151!important;
    font-size:11.2px!important;
    font-weight:400!important;
    line-height:1.35!important;
}
.profile-page .prof-manage-address-note{
    margin:3px 0 0!important;
    color:#6b7280!important;
    font-size:10.5px!important;
    font-weight:500!important;
    line-height:1.25!important;
}
.profile-page .prof-manage-address-action{
    justify-self:end!important;
    height:32px!important;
    min-width:76px!important;
    border:1px solid #ff7a00!important;
    border-radius:999px!important;
    background:#fff!important;
    color:#ff7a00!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    padding:0 13px!important;
    font-size:11px!important;
    font-weight:800!important;
    cursor:pointer!important;
    box-shadow:none!important;
    transform:none!important;
}
.profile-page .prof-manage-address-action:hover,
.profile-page .prof-manage-address-action:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    outline:none!important;
}
.profile-page .prof-manage-address-editor.is-work .prof-manage-address-editor-grid{
    grid-template-columns:repeat(2,minmax(0,1fr))!important;
}
@media(max-width:760px){
    .profile-page .prof-manage-address-option{
        grid-template-columns:24px minmax(0,1fr)!important;
        align-items:flex-start!important;
    }
    .profile-page .prof-manage-address-action{
        grid-column:2!important;
        justify-self:start!important;
        margin-top:4px!important;
    }
}

</style>

<div class="profile-page" x-data="printifyProfile()" x-init="init()">
    <div class="profile-shell">
<div class="profile-head">
<div class="profile-title-wrap">
<div>
<h1 class="profile-title">My Profile</h1>
<p class="profile-sub">Manage your customer account, photo, and profile information.</p>
</div>
</div>
<button type="button" class="profile-date" @click="openDatePicker()" aria-label="Open calendar date picker">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
<path d="M8 2v4M16 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
<path d="M5 5h14a2 2 0 0 1 2 2v14H3V7a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
</svg>
<span x-text="selectedDateText"></span>
</button>
</div>
<div class="profile-calendar-overlay" x-show="datePickerOpen" x-transition.opacity x-cloak @click.self="closeDatePicker()">
    <div class="profile-calendar-modal" role="dialog" aria-modal="true" aria-label="Profile calendar date picker">
        <div class="profile-calendar-head">
            <div>
                <h3>Calendar</h3>
                <p>Select a date to update the profile date display.</p>
            </div>
            <button type="button" class="profile-calendar-x" @click="closeDatePicker()" aria-label="Close calendar">×</button>
        </div>
        <div class="profile-calendar-body">
            <input class="profile-calendar-input" type="date" x-model="selectedDateValue">
        </div>
        <div class="profile-calendar-actions">
            <button type="button" class="prof-btn prof-light" @click="closeDatePicker()">Cancel</button>
            <button type="button" class="prof-btn prof-primary" @click="applySelectedDate()">Use Date</button>
        </div>
    </div>
</div>
<div class="profile-grid">
<main class="profile-left">
        <section class="prof-card prof-hero">
<div class="prof-main">
<div class="prof-avatar-wrap">
            <div class="prof-avatar" :class="photo ? 'has-photo' : 'no-photo'" role="button" tabindex="0" @click.stop="handleProfilePhotoClick()" @keydown.enter.prevent="handleProfilePhotoClick()" @keydown.space.prevent="handleProfilePhotoClick()">
<template x-if="photo">
<img :src="photo" alt="Profile photo">
</template>
<template x-if="!photo">
<span class="prof-avatar-initials" x-text="initials">
</span>
</template>
</div>
            <button class="prof-camera-btn" type="button" title="Profile photo options" aria-label="Profile photo options" @click.stop="handleProfilePhotoClick()">
<svg width="17" height="17" viewBox="0 0 24 24" fill="none">
<path d="M9 6l1.5-2h3L15 6h3a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V9a3 3 0 0 1 3-3h3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
<circle cx="12" cy="13" r="4" stroke="currentColor" stroke-width="2"/>
</svg>
</button>
            <div class="prof-photo-menu" x-show="photoMenu.open && photo" x-transition x-cloak @click.outside="photoMenu.open=false">
                <button type="button" class="prof-photo-option" @click="viewProfilePhoto()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                    View Profile Photo
                </button>
                <button type="button" class="prof-photo-option" @click="changeProfilePhoto()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M9 6l1.5-2h3L15 6h3a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V9a3 3 0 0 1 3-3h3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><circle cx="12" cy="13" r="4" stroke="currentColor" stroke-width="2"/></svg>
                    Change Profile Photo
                </button>
            </div>
            <span class="prof-online">
</span>
<input x-ref="profilePhotoInput" id="profilePhoto" type="file" accept="image/*" hidden @change="openCrop($event)">
        </div>
<div>
<h1 class="prof-name" x-text="displayName">
</h1>
<div class="prof-profile-meta">
<p class="prof-email-line" x-text="p.email"></p>
<p class="prof-id-line">
<span>Customer ID: <strong x-text="p.customerId"></strong></span>
<button class="prof-copy-mini" type="button" title="Copy Customer ID" aria-label="Copy Customer ID" @click="copyCustomerId()">
<svg width="13" height="13" viewBox="0 0 24 24" fill="none">
<path d="M8 8h10v12H8V8Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
<path d="M6 16H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
</svg>
</button>
</p>
<p class="prof-member-line">Member since <span x-text="p.memberSince"></span></p>
<p class="prof-premium-line" x-text="p.memberType"></p>
</div>
<div class="prof-chips">
<span class="prof-chip">✓ Verified Email</span>
<span class="prof-chip">● Active Account</span>
</div>
</div>
</div>
        <div class="prof-actions">
<button class="prof-btn prof-light" type="button" @click="handleUploadButton()">
<svg width="15" height="15" viewBox="0 0 24 24" fill="none">
<path d="M12 16V4m0 0 4 4m-4-4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
</svg>Upload Photo</button>
<button class="prof-btn prof-primary" type="button" @click="editAll()">
<svg width="15" height="15" viewBox="0 0 24 24" fill="none">
<path d="M12 20h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
<path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
</svg>
<span x-text="editing ? 'Editing Profile' : 'Edit Profile'">
</span>
</button>
</div>
</section>

        <section class="prof-card prof-info">
<div class="prof-head">
<div class="prof-title-wrap">
<div>
<h2 class="prof-card-title">Profile Information</h2>
<p class="prof-subtitle">Personal Information, Philippine Address Details, and Account Details are combined in one clean box.</p>
</div>
</div>

</div>
        <div class="prof-section">
<h3 class="prof-section-title">
<svg width="18" height="18" viewBox="0 0 24 24" fill="none">
<path d="M20 21a8 8 0 0 0-16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
<circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
</svg>Personal Information</h3>
<div class="prof-fields">
<template x-for="f in personal" :key="f.k">
<div class="prof-field">
<span class="prof-label" x-text="f.l">
</span>
<template x-if="!editing">
<span class="prof-value" x-text="p[f.k]">
</span>
</template>
<template x-if="editing">
<input class="prof-input" :type="f.t || 'text'" x-model="p[f.k]" @input="markDirty()">
</template>
</div>
</template>
</div>
</div>
        <div class="prof-section">
<h3 class="prof-section-title">
<svg width="18" height="18" viewBox="0 0 24 24" fill="none">
<path d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 1 1 18 0Z" stroke="currentColor" stroke-width="2"/>
<circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/>
</svg>Address Details</h3>
<p class="prof-subtitle" style="margin-bottom:10px">Use Philippine address suggestions: start with region, then province/city, then barangay. Street/unit is the only free-form line.</p>
<div class="prof-fields">
<template x-for="f in address" :key="f.k">
<div class="prof-field">
<span class="prof-label" x-text="f.l">
</span>
<template x-if="!editing">
<span class="prof-value" x-text="p[f.k]">
</span>
</template>
<template x-if="editing">
<div>
<template x-if="!isPsgcAddressField(f.k)">
<input class="prof-input" type="text" x-model="p[f.k]" @input="markDirty()" :placeholder="f.ph || ''">
</template>
<template x-if="isPsgcAddressField(f.k)">
<select class="prof-input" x-model="p[f.k]" :disabled="addressSelectDisabled(f.k)" @change="handleProfileAddressSelect(f.k)">
<template x-for="option in addressOptions(f.k)" :key="option.value">
<option :value="option.value" x-text="option.label"></option>
</template>
</select>
</template>
</div>
</template>
</div>
</template>
</div>
<div class="prof-manage-address-wrap">
<button type="button" class="prof-manage-address-toggle" @click="toggleManageAddress()" :aria-expanded="manageAddressOpen.toString()" aria-controls="profileManageAddressDropdown">
<span class="prof-manage-address-title">
<svg width="17" height="17" viewBox="0 0 24 24" fill="none">
<path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
</svg>
Manage Address
</span>
<span class="prof-manage-address-meta">Click to view saved address options</span>
<svg class="prof-manage-address-chevron" :class="manageAddressOpen ? 'is-open' : ''" width="16" height="16" viewBox="0 0 24 24" fill="none">
<path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</button>
<div id="profileManageAddressDropdown" class="prof-manage-address-panel" x-show="manageAddressOpen" x-transition x-cloak>
<template x-if="!manageAddressEditing">
<div>
<div class="prof-manage-address-option">
<span class="prof-manage-address-icon">
<svg width="17" height="17" viewBox="0 0 24 24" fill="none">
<path d="M3 10.5 12 3l9 7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5 10v10h14V10" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
</svg>
</span>
<div class="prof-manage-address-main">
<p class="prof-manage-address-topline">
<span class="prof-manage-address-recipient" x-text="displayName || 'Eyra Mae Alla'"></span>
<span class="prof-manage-address-chip default">Default</span>
</p>
<p class="prof-manage-address-phone" x-text="p.phone || '+63 912 345 6789'"></p>
<p class="prof-manage-address-line" x-text="addressFallback('street')"></p>
<p class="prof-manage-address-line" x-text="[addressFallback('barangay'), addressFallback('city'), addressFallback('region'), addressFallback('postalCode')].filter(Boolean).join(', ')"></p>
<p class="prof-manage-address-note">Estimated Delivery: 2–4 business days</p>
</div>
<button type="button" class="prof-manage-address-action" @click.stop="startManageAddressEdit('primary')">Edit</button>
</div>
<div class="prof-manage-address-option">
<span class="prof-manage-address-icon">
<svg width="17" height="17" viewBox="0 0 24 24" fill="none">
<path d="M4 21V9l8-5 8 5v12" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
<path d="M9 21v-7h6v7M8 10h.01M16 10h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
</svg>
</span>
<div class="prof-manage-address-main">
<p class="prof-manage-address-topline">
<span class="prof-manage-address-recipient" x-text="workAddress.recipient"></span>
<span class="prof-manage-address-chip work">Work</span>
</p>
<p class="prof-manage-address-phone" x-text="workAddress.phone"></p>
<p class="prof-manage-address-line" x-text="workAddress.line1"></p>
<p class="prof-manage-address-line" x-text="workAddress.line2"></p>
</div>
<button type="button" class="prof-manage-address-action" @click.stop="startManageAddressEdit('work')">Edit</button>
</div>
<div class="prof-manage-address-option">
<span class="prof-manage-address-icon">
<svg width="17" height="17" viewBox="0 0 24 24" fill="none">
<path d="M5 21V7l7-4 7 4v14" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
<path d="M9 21v-7h6v7M9 10h.01M15 10h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
</svg>
</span>
<div class="prof-manage-address-main">
<p class="prof-manage-address-topline">
<span class="prof-manage-address-recipient">PrintifyCo. SM North EDSA Branch</span>
<span class="prof-manage-address-chip branch">Branch Pickup</span>
</p>
<p class="prof-manage-address-phone">+63 2 8356 7890</p>
<p class="prof-manage-address-line">SM City North EDSA, The Block, 2nd Level</p>
<p class="prof-manage-address-line">Epifanio de los Santos Ave., Quezon City 1105</p>
<p class="prof-manage-address-note">Pick-up Hours: Mon-Sun, 10:00 AM - 9:00 PM</p>
</div>
<button type="button" class="prof-manage-address-action" @click.stop="toastMsg('Branch pickup details displayed.')">View</button>
</div>
</div>
</template>
<template x-if="manageAddressEditing === 'primary'">
<div class="prof-manage-address-row is-editing">
<div class="prof-manage-address-editor">
<div class="prof-manage-address-editor-head">
<p class="prof-manage-address-editor-title">Edit Default Shipping Address</p>
<p class="prof-manage-address-value">Display muna ang saved address; editable lang ito after clicking Edit.</p>
</div>
<div class="prof-manage-address-editor-grid">
<div class="prof-manage-address-field"><label>Street / Unit / House No.</label><input class="prof-manage-address-input" type="text" x-model="addressDraft.street"></div>
<div class="prof-manage-address-field"><label>Region</label><select class="prof-manage-address-input" x-model="addressDraft.region" @change="handleDraftAddressSelect('region')"><template x-for="option in addressOptions('region')" :key="'draft-'+option.value"><option :value="option.value" x-text="option.label"></option></template></select></div>
<div class="prof-manage-address-field"><label>Province</label><select class="prof-manage-address-input" x-model="addressDraft.province" :disabled="draftAddressSelectDisabled('province')" @change="handleDraftAddressSelect('province')"><template x-for="option in draftAddressOptions('province')" :key="'draft-'+option.value"><option :value="option.value" x-text="option.label"></option></template></select></div>
<div class="prof-manage-address-field"><label>City / Municipality</label><select class="prof-manage-address-input" x-model="addressDraft.city" :disabled="draftAddressSelectDisabled('city')" @change="handleDraftAddressSelect('city')"><template x-for="option in draftAddressOptions('city')" :key="'draft-'+option.value"><option :value="option.value" x-text="option.label"></option></template></select></div>
<div class="prof-manage-address-field"><label>Barangay</label><select class="prof-manage-address-input" x-model="addressDraft.barangay" :disabled="draftAddressSelectDisabled('barangay')" @change="handleDraftAddressSelect('barangay')"><template x-for="option in draftAddressOptions('barangay')" :key="'draft-'+option.value"><option :value="option.value" x-text="option.label"></option></template></select></div>
<div class="prof-manage-address-field"><label>Postal Code</label><input class="prof-manage-address-input" type="text" x-model="addressDraft.postalCode"></div>
</div>
<div class="prof-manage-address-editor-actions">
<button type="button" class="prof-manage-address-cancel" @click="cancelManageAddressEdit()">Cancel</button>
<button type="button" class="prof-manage-address-save" @click="saveManageAddressEdit()">Apply</button>
</div>
</div>
</div>
</template>
<template x-if="manageAddressEditing === 'work'">
<div class="prof-manage-address-row is-editing">
<div class="prof-manage-address-editor is-work">
<div class="prof-manage-address-editor-head">
<p class="prof-manage-address-editor-title">Edit Work Address</p>
<p class="prof-manage-address-value">Work address display lang ito sa Manage Address dropdown.</p>
</div>
<div class="prof-manage-address-editor-grid">
<div class="prof-manage-address-field"><label>Recipient</label><input class="prof-manage-address-input" type="text" x-model="workDraft.recipient"></div>
<div class="prof-manage-address-field"><label>Phone Number</label><input class="prof-manage-address-input" type="text" x-model="workDraft.phone"></div>
<div class="prof-manage-address-field"><label>Address Line 1</label><input class="prof-manage-address-input" type="text" x-model="workDraft.line1"></div>
<div class="prof-manage-address-field"><label>Address Line 2</label><input class="prof-manage-address-input" type="text" x-model="workDraft.line2"></div>
</div>
<div class="prof-manage-address-editor-actions">
<button type="button" class="prof-manage-address-cancel" @click="cancelManageAddressEdit()">Cancel</button>
<button type="button" class="prof-manage-address-save" @click="saveManageAddressEdit()">Apply</button>
</div>
</div>
</div>
</template>
</div>
</div>
        <div class="prof-section">
<h3 class="prof-section-title">
<svg width="18" height="18" viewBox="0 0 24 24" fill="none">
<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" stroke="currentColor" stroke-width="2"/>
<path d="m9 12 2 2 4-5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
</svg>Account Details</h3>
<div class="prof-fields">
<template x-for="f in account" :key="f.k">
<div class="prof-field">
<span class="prof-label" x-text="f.l"></span>
<template x-if="!f.badge">
<span class="prof-value" x-text="p[f.k]"></span>
</template>
<template x-if="f.badge">
<span class="prof-badge" x-text="p[f.k]"></span>
</template>
</div>
</template>
</div>
</div>
        <div class="prof-savebar" x-show="editing || dirty || photoDirty" x-transition x-cloak>
<p class="prof-save-text" x-text="photoDirty && !dirty ? 'Profile photo preview is ready. Save Changes will update the photo only.' : (dirty ? 'You have unsaved changes. Click Save Changes to apply them.' : 'Edit mode is active. Change any field to enable saving.')">
</p>
<div class="prof-save-actions">
<button class="prof-btn prof-light" type="button" @click="cancel()" :disabled="saving">Cancel</button>
<button class="prof-btn prof-primary" type="button" @click="save()" :disabled="saving || (!dirty && !photoDirty)">
<span x-text="saving ? 'Saving...' : 'Save Changes'">
</span>
</button>
</div>
</div>
        </section>
</main>

        <!-- Right-side widgets removed as requested: Communication Preferences and Recent Activity. Main My Profile box now uses the full available width. -->
    </div>
</div>

    <div class="prof-modal" x-show="crop.open" x-transition x-cloak>
<div class="prof-crop">
<div class="prof-crop-head">
<div>
<h3>Adjust Profile Photo</h3>
<p class="prof-crop-sub">Drag to reposition, use the zoom control, then apply your circular profile photo.</p>
</div>
<button class="prof-x" type="button" @click="closeCrop()" aria-label="Close photo cropper">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
<path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
</svg>
</button>
</div>
<div class="prof-stage" :class="crop.drag ? 'is-dragging' : ''" :style="'--x:' + crop.x + 'px; --y:' + crop.y + 'px; --z:' + crop.z + '; --w:' + crop.baseW + 'px; --h:' + crop.baseH + 'px; --crop:' + crop.cropSize + 'px;'" @wheel.prevent="wheelZoom($event)" @pointerdown.prevent="dragStart($event)">
<img :src="crop.src" alt="Crop preview" draggable="false">
<div class="prof-stage-tip">Drag photo to reposition</div>
</div>
<div class="prof-crop-body">
<div class="prof-crop-toolrow">
<div class="prof-preview-wrap">
<div class="prof-preview" :style="previewVars()">
<img :src="crop.src" alt="Circular preview" draggable="false">
</div>
<div class="prof-crop-help">
<strong>Live profile preview</strong>
<span>This is how your avatar will look after applying.</span>
</div>
</div>
<div class="prof-zoom-pct" x-text="Math.round(crop.z * 100) + '%'">
</div>
</div>
<div class="prof-zoom-row">
<button class="prof-icon-btn" type="button" @click="zoomBy(-0.08)" aria-label="Zoom out">−</button>
<div class="prof-range-wrap">
<div class="prof-range-head">
<label class="prof-label">Zoom</label>
<span class="prof-crop-sub" x-text="crop.z > 1 ? 'Enhanced crop mode' : 'Original fit'">
</span>
</div>
<input class="prof-range" type="range" min="1" max="2.8" step="0.01" x-model.number="crop.z">
</div>
<button class="prof-icon-btn" type="button" @click="zoomBy(0.08)" aria-label="Zoom in">+</button>
</div>

</div>
<div class="prof-crop-actions">
<button class="prof-btn prof-light" type="button" @click="closeCrop()">Cancel</button>
<button class="prof-btn prof-success" type="button" @click="applyCrop()">Upload</button>
</div>
</div>
</div>

    <div class="prof-modal" x-show="viewPhoto.open" x-transition x-cloak @click.self="closeViewProfilePhoto()">
        <div class="prof-photo-view-modal">
            <div class="prof-photo-view-head">
                <h3>Profile Photo</h3>
                <button class="prof-x" type="button" @click="closeViewProfilePhoto()" aria-label="Close profile photo viewer">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                </button>
            </div>
            <div class="prof-photo-view-body">
                <img :src="viewPhotoSrc" alt="Profile photo preview">
            </div>
            <div class="prof-photo-view-actions">
                <button class="prof-btn prof-light" type="button" @click="closeViewProfilePhoto()">Cancel</button>
                <button class="prof-btn prof-primary" type="button" @click="changeProfilePhoto()">Change Profile Photo</button>
            </div>
        </div>
    </div>
    <div class="prof-toast" x-show="toast.show" x-transition x-cloak>
<svg width="18" height="18" viewBox="0 0 24 24" fill="none">
<path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<span x-text="toast.text">
</span>
</div>
</div>

<script src="{{ asset('js/psgc-cascade.js') }}"></script>
<script>
function printifyProfile(){return{
csrf:@json(csrf_token()),updateUrl:@json(Route::has('profile.update')?route('profile.update'):url()->current()),saving:false,editing:false,dirty:false,photoDirty:false,suggest:false,allActs:false,datePickerOpen:false,manageAddressOpen:false,manageAddressEditing:null,addressDraft:{street:'',barangay:'',city:'',province:'',region:'',postalCode:''},psgc:{ready:false,regions:[]},workAddress:{recipient:'Mae Alla',phone:'+63 917 888 2345',line1:'114F Printify Tower, 32nd St. Corner 9th Ave.',line2:'Bonifacio Global City, Taguig City, Metro Manila 1634'},workDraft:{recipient:'',phone:'',line1:'',line2:''},selectedDateValue:@json(now()->format('Y-m-d')),selectedDateText:'Today is '+@json(now()->format('M d, Y')),photo:@json($photo),fullPhoto:@json($photo),saved:null,photoMenu:{open:false},viewPhoto:{open:false},toast:{show:false,text:''},to:null,
crop:{open:false,src:'',x:0,y:0,z:1,file:null,drag:false,sx:0,sy:0,ox:0,oy:0,naturalW:0,naturalH:0,baseW:270,baseH:270,cropSize:270},
p:{firstName:@json($firstName),lastName:@json($lastName),username:@json($user->username ?? ''),email:@json($user->email ?? ''),alternateEmail:@json($user->backup_email ?? ''),phone:@json($user->phone ?? ''),birthdate:@json($user->birthdate ?? ''),gender:@json($user->gender ?? ''),street:@json($user->street ?: 'Blk 6 Lot 8 Ninada St.'),barangay:@json($user->barangay ?: 'Commonwealth'),region:@json($user->region ?: 'National Capital Region'),province:@json($user->province ?? ''),city:@json($user->city ?: 'Quezon City'),postalCode:@json($user->postal_code ?: '1121'),customerId:@json($user->customer_id ?? 'CUST-00002'),memberSince:@json(optional($user->created_at)->format('F d, Y') ?? 'June 14, 2026'),memberType:@json($user->membership_type ?? 'Premium Member'),lastLogin:'Current session',emailStatus:@json($user->email_verified_at ? 'Verified' : 'Unverified'),recoveryStatus:@json($user->backup_email ? 'Recovery email added' : 'Not set'),accountType:'Customer',accountStatus:'Active'},
personal:[{k:'firstName',l:'First Name'},{k:'lastName',l:'Last Name'},{k:'username',l:'Username'},{k:'email',l:'Email Address',t:'email'},{k:'alternateEmail',l:'Alternate Email',t:'email'},{k:'phone',l:'Phone Number'},{k:'birthdate',l:'Birthdate'},{k:'gender',l:'Gender'}],address:[{k:'street',l:'Street / Unit / House No.',ph:'House no., street, subdivision'},{k:'region',l:'Region'},{k:'province',l:'Province'},{k:'city',l:'City / Municipality'},{k:'barangay',l:'Barangay'},{k:'postalCode',l:'Postal Code'}],account:[{k:'customerId',l:'Customer ID'},{k:'memberSince',l:'Member Since'},{k:'memberType',l:'Membership'},{k:'lastLogin',l:'Last Login'},{k:'emailStatus',l:'Email Verification',badge:true},{k:'recoveryStatus',l:'Recovery Email',badge:true},{k:'accountType',l:'Account Type'},{k:'accountStatus',l:'Account Status',badge:true}],prefs:[{k:'email',l:'Email Notifications',on:true},{k:'sms',l:'SMS Notifications',on:true},{k:'marketing',l:'Marketing Updates',on:false},{k:'orders',l:'Order Updates',on:true}],
stats:[{n:24,l:'Total Orders',c:'ico-orange',i:'<svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M6 7h12l1 14H5L6 7Z" stroke="currentColor" stroke-width="2"/><path d="M9 7a3 3 0 0 1 6 0" stroke="currentColor" stroke-width="2"/></svg>'},{n:18,l:'Completed Orders',c:'ico-green',i:'<svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5" stroke="currentColor" stroke-width="2"/></svg>'},{n:7,l:'Saved Designs',c:'ico-purple',i:'<svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6Z" stroke="currentColor" stroke-width="2"/><path d="M14 2v6h6M9 15l2 2 4-5" stroke="currentColor" stroke-width="2"/></svg>'},{n:3,l:'Pending Jobs',c:'ico-yellow',i:'<svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M12 8v5l3 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="currentColor" stroke-width="2"/></svg>'}],
acts:[{t:'Order #PRN-2026-0054 completed',d:'May 31, 2026 11:24 AM'},{t:'Uploaded design for Order #PRN-2026-0055',d:'May 31, 2026 10:43 AM'},{t:'Updated profile information',d:'May 31, 2026 10:15 AM'},{t:'Changed communication preference settings',d:'May 30, 2026 6:10 PM'},{t:'Logged in successfully',d:'May 30, 2026 5:58 PM'}],
init(){this.saved=this.clone({p:this.p,photo:this.photo,fullPhoto:this.fullPhoto,prefs:this.prefs,workAddress:this.workAddress});this.loadPsgcLocations();this.syncHeader();window.addEventListener('pointermove',e=>this.dragMove(e));window.addEventListener('pointerup',()=>this.dragEnd());window.addEventListener('pointercancel',()=>this.dragEnd())},
get fullName(){return `${this.p.firstName} ${this.p.lastName}`.trim()},get displayName(){return (this.p.username||'').trim()||this.fullName},get initials(){let parts=(this.fullName||this.displayName).trim().split(/\s+/).filter(Boolean);return ((parts[0]?.[0]||'E')+(parts[1]?.[0]||'M')).toUpperCase()},get shownActs(){return this.allActs?this.acts:this.acts.slice(0,3)},get viewPhotoSrc(){return this.fullPhoto||this.photo},isPsgcAddressField(k){return ['region','province','city','barangay'].includes(k)},sameAddressName(a,b){return String(a||'').trim().toLowerCase().replace(/\s*\(ncr\)\s*/g,'')===String(b||'').trim().toLowerCase().replace(/\s*\(ncr\)\s*/g,'')},optionRows(values,label){return [{value:'',label}].concat((values||[]).map(v=>({value:v,label:v})))},findRegion(name,province){let n=String(name||'').trim().toLowerCase();let alias=['metro manila','ncr','national capital region (ncr)'].includes(n)?'National Capital Region':name;return (this.psgc.regions||[]).find(r=>this.sameAddressName(r.name,alias))||(province?(this.psgc.regions||[]).find(r=>(r.provinces||[]).some(p=>this.sameAddressName(p.name,province))):null)||null},findProvince(regionName,provinceName){let region=this.findRegion(regionName,provinceName);return region?(region.provinces||[]).find(p=>this.sameAddressName(p.name,provinceName))||null:null},findCity(source,cityName){let province=this.findProvince(source.region,source.province);return province?(province.cities||[]).find(c=>this.sameAddressName(c.name,cityName))||null:null},addressOptions(k){if(k==='region')return this.optionRows((this.psgc.regions||[]).map(r=>r.name),'Select region');if(k==='province'){let region=this.findRegion(this.p.region,this.p.province);return this.optionRows(region?(region.provinces||[]).map(p=>p.name):[],'Select province')}if(k==='city'){let province=this.findProvince(this.p.region,this.p.province);return this.optionRows(province?(province.cities||[]).map(c=>c.name):[],'Select city / municipality')}if(k==='barangay'){let city=this.findCity(this.p,this.p.city);return this.optionRows(city?(city.barangays||[]).map(b=>b.name):[],'Select barangay')}return []},draftAddressOptions(k){if(k==='province'){let region=this.findRegion(this.addressDraft.region,this.addressDraft.province);return this.optionRows(region?(region.provinces||[]).map(p=>p.name):[],'Select province')}if(k==='city'){let province=this.findProvince(this.addressDraft.region,this.addressDraft.province);return this.optionRows(province?(province.cities||[]).map(c=>c.name):[],'Select city / municipality')}if(k==='barangay'){let city=this.findCity(this.addressDraft,this.addressDraft.city);return this.optionRows(city?(city.barangays||[]).map(b=>b.name):[],'Select barangay')}return this.addressOptions(k)},addressSelectDisabled(k){return (k==='province'&&!this.p.region)||(k==='city'&&!this.p.province)||(k==='barangay'&&!this.p.city)},draftAddressSelectDisabled(k){return (k==='province'&&!this.addressDraft.region)||(k==='city'&&!this.addressDraft.province)||(k==='barangay'&&!this.addressDraft.city)},handleProfileAddressSelect(k){if(k==='region'){this.p.province='';this.p.city='';this.p.barangay=''}if(k==='province'){this.p.city='';this.p.barangay=''}if(k==='city')this.p.barangay='';this.markDirty()},handleDraftAddressSelect(k){if(k==='region'){this.addressDraft.province='';this.addressDraft.city='';this.addressDraft.barangay=''}if(k==='province'){this.addressDraft.city='';this.addressDraft.barangay=''}if(k==='city')this.addressDraft.barangay=''},inferAddressFromCity(source){if(source.province||!source.city)return;for(let region of (this.psgc.regions||[])){for(let province of (region.provinces||[])){if((province.cities||[]).some(city=>this.sameAddressName(city.name,source.city))){source.region=region.name;source.province=province.name;return}}}},loadPsgcLocations(){if(!window.PrintifyPsgc)return;window.PrintifyPsgc.load('/data/ph-locations.json').then(data=>{this.psgc={ready:true,regions:data.regions||[]};this.inferAddressFromCity(this.p)}).catch(()=>{this.toastMsg('Philippine address list could not be loaded.')})},addressFallback(k){let defaults={street:'Blk 6 Lot 8 Ninada St.',barangay:'Commonwealth',city:'Quezon City',province:'Metro Manila',region:'National Capital Region',postalCode:'1121'};let v=(this.p[k]||'').toString().trim();return v || defaults[k] || ''},get primaryAddressText(){return [this.addressFallback('street'),this.addressFallback('barangay'),this.addressFallback('city'),this.addressFallback('province'),this.addressFallback('region'),this.addressFallback('postalCode')].filter(Boolean).join(', ')},get billingAddressText(){return 'Same as primary address'},toggleManageAddress(){this.manageAddressOpen=!this.manageAddressOpen;if(!this.manageAddressOpen)this.manageAddressEditing=null},startManageAddressEdit(type){this.manageAddressOpen=true;this.manageAddressEditing=type;if(type==='work'){this.workDraft=this.clone(this.workAddress)}else{this.addressDraft={street:this.addressFallback('street'),barangay:this.addressFallback('barangay'),city:this.addressFallback('city'),province:this.addressFallback('province'),region:this.addressFallback('region'),postalCode:this.addressFallback('postalCode')}}this.$nextTick(()=>{let input=document.querySelector('.profile-page .prof-manage-address-input');if(input)input.focus()})},cancelManageAddressEdit(){this.manageAddressEditing=null;this.addressDraft={street:'',barangay:'',city:'',province:'',region:'',postalCode:''};this.workDraft={recipient:'',phone:'',line1:'',line2:''}},saveManageAddressEdit(){if(this.manageAddressEditing==='work'){this.workAddress=this.clone(this.workDraft);this.manageAddressEditing=null;this.toastMsg('Work address display updated.');return}this.p.street=this.addressDraft.street;this.p.barangay=this.addressDraft.barangay;this.p.city=this.addressDraft.city;this.p.province=this.addressDraft.province;this.p.region=this.addressDraft.region;this.p.postalCode=this.addressDraft.postalCode;this.manageAddressEditing=null;this.markDirty();this.toastMsg('Address details applied. Click Save Changes to keep it.')},editProfileAddress(){this.startManageAddressEdit('primary')},openDatePicker(){this.datePickerOpen=true},closeDatePicker(){this.datePickerOpen=false},applySelectedDate(){let d=new Date((this.selectedDateValue||'')+'T00:00:00');if(!Number.isNaN(d.getTime())){this.selectedDateText='Today is '+d.toLocaleDateString('en-US',{month:'short',day:'2-digit',year:'numeric'});this.toastMsg('Calendar date selected.')}this.closeDatePicker()},copyCustomerId(){let id=this.p.customerId||'CUST-00002';if(navigator.clipboard&&navigator.clipboard.writeText){navigator.clipboard.writeText(id).then(()=>this.toastMsg('Customer ID copied.')).catch(()=>this.toastMsg('Customer ID: '+id));}else{this.toastMsg('Customer ID: '+id)}},clone(v){return JSON.parse(JSON.stringify(v))},editAll(){this.editing=true;this.toastMsg('Edit mode enabled. Save Changes will appear after edits.')},markDirty(){this.dirty=true},markPhotoDirty(){this.photoDirty=true},togglePref(pr){pr.on=!pr.on;this.editing=true;this.markDirty();this.toastMsg(`${pr.l} turned ${pr.on?'On':'Off'}. Click Save Changes to keep it.`)},cancel(){let d=this.clone(this.saved);this.p=d.p;this.photo=d.photo;this.fullPhoto=d.fullPhoto||d.photo;this.prefs=d.prefs;if(d.workAddress)this.workAddress=d.workAddress;this.editing=false;this.dirty=false;this.photoDirty=false;this.manageAddressEditing=null;this.photoMenu.open=false;this.viewPhoto.open=false;this.syncHeader();this.toastMsg('Changes cancelled.')},
openProfileFilePicker(){this.photoMenu.open=false;this.viewPhoto.open=false;this.$nextTick(()=>this.$refs.profilePhotoInput?.click())},handleProfilePhotoClick(){if(this.photo){this.photoMenu.open=!this.photoMenu.open}else{this.openProfileFilePicker()}},handleUploadButton(){if(this.photo){this.photoMenu.open=!this.photoMenu.open}else{this.openProfileFilePicker()}},viewProfilePhoto(){if(!this.photo){this.openProfileFilePicker();return}this.photoMenu.open=false;this.viewPhoto.open=true},closeViewProfilePhoto(){this.viewPhoto.open=false},changeProfilePhoto(){this.photoMenu.open=false;this.viewPhoto.open=false;this.openProfileFilePicker()},
profilePayload(source=this.p,prefs=this.prefs){return{first_name:source.firstName,last_name:source.lastName,name:`${source.firstName||''} ${source.lastName||''}`.trim(),username:source.username,email:source.email,backup_email:source.alternateEmail,phone:source.phone,birthdate:source.birthdate,gender:source.gender,street:source.street,barangay:source.barangay,region:source.region,province:source.province,city:source.city,postal_code:source.postalCode,preferences:prefs}},
async save(){this.saving=true;let wasPhotoOnly=this.photoDirty&&!this.dirty,base=this.dirty?this.profilePayload(this.p,this.prefs):this.profilePayload(this.saved.p,this.saved.prefs);let payload={...base};if(this.photoDirty)payload.photo_base64=this.photo;let serverSaved=false;try{let r=await fetch(this.updateUrl,{method:'PATCH',headers:{'X-CSRF-TOKEN':this.csrf,'Accept':'application/json','Content-Type':'application/json'},body:JSON.stringify(payload)});serverSaved=r.ok;if(!r.ok)throw new Error('Profile save failed')}catch(e){this.saving=false;this.toastMsg('Profile was not saved. Please check the details and try again.');return}this.saved=this.clone({p:this.p,photo:this.photo,fullPhoto:this.fullPhoto,prefs:this.prefs,workAddress:this.workAddress});this.editing=false;this.dirty=false;this.photoDirty=false;this.saving=false;this.syncHeader();this.toastMsg(serverSaved?(wasPhotoOnly?'Profile photo updated successfully.':'Profile updated successfully.'):'Profile saved successfully.')},
openCrop(e){let f=e.target.files[0];e.target.value='';if(!f)return;if(!f.type.startsWith('image/')){this.toastMsg('Please upload a valid image file.');return}let reader=new FileReader();reader.onload=()=>{let src=reader.result,img=new Image();img.onload=()=>{let cropSize=286,aspect=img.naturalWidth/img.naturalHeight,baseW=cropSize,baseH=cropSize;if(aspect>=1){baseW=cropSize*aspect}else{baseH=cropSize/aspect}this.fullPhoto=src;this.crop={open:true,src,x:0,y:0,z:1,file:f,drag:false,sx:0,sy:0,ox:0,oy:0,naturalW:img.naturalWidth,naturalH:img.naturalHeight,baseW,baseH,cropSize};this.toastMsg('Drag, zoom, preview, then apply the profile photo.')};img.src=src};reader.readAsDataURL(f)},closeCrop(){this.crop.open=false;this.crop.drag=false},resetCrop(){this.crop.x=0;this.crop.y=0;this.crop.z=1},centerCrop(){this.crop.x=0;this.crop.y=0},clampZoom(v){return Math.max(1,Math.min(2.8,Number(v.toFixed(2))))},zoomBy(v){this.crop.z=this.clampZoom(this.crop.z+v)},wheelZoom(e){this.zoomBy((e.deltaY < 0 ? 0.06 : -0.06))},previewVars(){let preview=58,scale=preview/(this.crop.cropSize||286);return `--pw:${this.crop.baseW*scale}px; --ph:${this.crop.baseH*scale}px; --px:${this.crop.x*scale}px; --py:${this.crop.y*scale}px; --pz:${this.crop.z};`},dragStart(e){if(!this.crop.open)return;this.crop.drag=true;this.crop.sx=e.clientX;this.crop.sy=e.clientY;this.crop.ox=this.crop.x;this.crop.oy=this.crop.y;if(e.currentTarget&&e.currentTarget.setPointerCapture){try{e.currentTarget.setPointerCapture(e.pointerId)}catch(err){}}},dragMove(e){if(!this.crop.drag||!e)return;this.crop.x=this.crop.ox+(e.clientX-this.crop.sx);this.crop.y=this.crop.oy+(e.clientY-this.crop.sy)},dragEnd(){this.crop.drag=false},
async savePhotoOnly(){this.saving=true;let payload={...this.profilePayload(this.saved?.p||this.p,this.saved?.prefs||this.prefs),photo_base64:this.photo};try{let r=await fetch(this.updateUrl,{method:'PATCH',headers:{'X-CSRF-TOKEN':this.csrf,'Accept':'application/json','Content-Type':'application/json'},body:JSON.stringify(payload)});if(!r.ok)throw new Error('Profile photo upload failed');this.saved=this.clone({p:this.p,photo:this.photo,fullPhoto:this.fullPhoto,prefs:this.prefs,workAddress:this.workAddress});this.photoDirty=false;this.saving=false;this.syncHeader();this.toastMsg('Profile photo uploaded successfully.')}catch(e){this.saving=false;this.photoDirty=true;this.toastMsg('Photo preview is ready, but upload failed. Click Save Changes to try again.')}},
applyCrop(){let img=new Image();img.onload=async()=>{let c=document.createElement('canvas'),ctx=c.getContext('2d'),out=512,crop=this.crop.cropSize||286,f=out/crop;c.width=out;c.height=out;ctx.fillStyle='#fff';ctx.fillRect(0,0,out,out);let w=this.crop.baseW*this.crop.z*f,h=this.crop.baseH*this.crop.z*f,x=out/2-w/2+this.crop.x*f,y=out/2-h/2+this.crop.y*f;ctx.drawImage(img,x,y,w,h);this.photo=c.toDataURL('image/png');this.fullPhoto=this.crop.src;this.crop.open=false;this.crop.drag=false;this.markPhotoDirty();this.syncHeader();this.toastMsg('Uploading profile photo...');await this.savePhotoOnly()};img.src=this.crop.src},
syncHeader(){let d={name:this.displayName,photo:this.photo,initials:this.initials};window.dispatchEvent(new CustomEvent('printify-profile-updated',{detail:d}));document.querySelectorAll('[data-profile-name],.header-profile-name,.user-name').forEach(el=>el.textContent=d.name);document.querySelectorAll('[data-profile-avatar],.header-profile-img,.profile-avatar-img').forEach(el=>{if(d.photo){if(el.tagName==='IMG')el.src=d.photo;else el.style.backgroundImage=`url(${d.photo})`}});document.querySelectorAll('[data-profile-initials],.header-profile-initials').forEach(el=>el.textContent=d.initials)},toastMsg(t){this.toast.text=t;this.toast.show=true;clearTimeout(this.to);this.to=setTimeout(()=>this.toast.show=false,2400)}
}}
</script></x-app-layout>
