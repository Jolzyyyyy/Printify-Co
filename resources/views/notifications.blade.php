<x-app-layout>
@php
    $customer = auth()->user();
    $customerName = $customer->name ?? trim(($customer->first_name ?? 'Eyra').' '.($customer->last_name ?? 'Mae'));
    $tabs = [
        'all' => 'All',
        'order' => 'Order Updates',
        'security' => 'Security',
        'billing' => 'Billing',
        'promotions' => 'Promotions',
        'messages' => 'Messages',
    ];
    $notifications = [
        ['category'=>'billing','step'=>2,'order'=>'#ORD-55201','chip'=>'Order Update','title'=>'Payment Pending Reminder','time'=>'2 mins ago','icon'=>'card','color'=>'orange','preview'=>'Payment for Order <strong>#ORD-55201</strong> is pending. Complete payment to proceed.','message'=>'This is a friendly reminder that the payment for your order is still pending. To avoid delays, please complete your payment at your earliest convenience.','total'=>'₱2,850.00','balance'=>'₱2,850.00','payment'=>'Bank Transfer (BPI)','due'=>'May 29, 2026, 11:59 PM','unread'=>true],
        ['category'=>'order','step'=>1,'order'=>'#ORD-55198','chip'=>'Proof Approved','title'=>'Proof Approved','time'=>'28 mins ago','icon'=>'check','color'=>'green','preview'=>'Your proof for Order <strong>#ORD-55198</strong> has been approved. Production will start next.','message'=>'Your proof has been approved. We will start production shortly and notify you once your order moves to the next stage.','total'=>'₱1,950.00','balance'=>'Paid','payment'=>'GCash','due'=>'Production starts today','unread'=>true],
        ['category'=>'order','step'=>1,'order'=>'#ORD-55196','chip'=>'File Alert','title'=>'File Rejected - Low Resolution','time'=>'1 hour ago','icon'=>'warn','color'=>'red','preview'=>'The file uploaded for Order <strong>#ORD-55196</strong> is too low resolution.','message'=>'The uploaded file is below our recommended resolution. Please upload a clearer file so our team can continue processing.','total'=>'₱980.00','balance'=>'Paid','payment'=>'Credit Card','due'=>'Upload replacement file','unread'=>true],
        ['category'=>'order','step'=>4,'order'=>'#ORD-55190','chip'=>'Order Complete','title'=>'Production Completed','time'=>'3 hours ago','icon'=>'file','color'=>'blue','preview'=>'Great news! Your order <strong>#ORD-55190</strong> has been completed.','message'=>'Great news! Your order has been completed and is now ready for pickup or delivery based on your selected option.','total'=>'₱3,120.00','balance'=>'Paid','payment'=>'GCash','due'=>'Ready for pickup / delivery','unread'=>false],
        ['category'=>'order','step'=>4,'order'=>'#ORD-55188','chip'=>'Shipping Update','title'=>'Order Shipped','time'=>'5 hours ago','icon'=>'truck','color'=>'blue','preview'=>'Your order <strong>#ORD-55188</strong> has been shipped via LBC Express.','message'=>'Your order has been shipped via LBC Express. Please monitor your tracking link for delivery updates.','total'=>'₱1,450.00','balance'=>'Paid','payment'=>'Maya','due'=>'In transit via LBC Express','unread'=>false],
        ['category'=>'order','step'=>3,'order'=>'#ORD-55185','chip'=>'Pickup Reminder','title'=>'Pickup Schedule Reminder','time'=>'8 hours ago','icon'=>'calendar','color'=>'purple','preview'=>'Your order <strong>#ORD-55185</strong> is ready for pickup tomorrow.','message'=>'This is a reminder that your order is ready for pickup tomorrow. Please bring your valid ID and order confirmation.','total'=>'₱2,280.00','balance'=>'Paid','payment'=>'Credit Card','due'=>'May 30, 2026, 3:00 PM','unread'=>false],
        ['category'=>'messages','step'=>0,'order'=>'Message','chip'=>'Branch Reply','title'=>'Branch Reply - Makati','time'=>'Yesterday, 2:15 PM','icon'=>'msg','color'=>'orange','preview'=>'Glokal branch replied to your inquiry about bulk pricing.','message'=>'Glokal branch replied to your inquiry about bulk pricing. You may reply to the branch or contact support for assistance.','total'=>'Not applicable','balance'=>'Not applicable','payment'=>'Not applicable','due'=>'Reply available','unread'=>false],
        ['category'=>'promotions','step'=>0,'order'=>'Promo','chip'=>'Exclusive Coupon','title'=>'Exclusive Coupon - Expires Soon!','time'=>'Yesterday, 9:00 AM','icon'=>'tag','color'=>'green','preview'=>'Get 15% OFF on your next order. Use code PRINT15.','message'=>'Get 15% OFF your next order. Use code PRINT15 before it expires.','total'=>'15% OFF','balance'=>'Promo code: PRINT15','payment'=>'Valid until May 31, 2026','due'=>'Apply before checkout','unread'=>false],
        ['category'=>'security','step'=>0,'order'=>'Account','chip'=>'Security','title'=>'Account Verified Successfully','time'=>'May 27, 2026, 4:20 PM','icon'=>'shield','color'=>'green','preview'=>'Your account has been verified. Thank you!','message'=>'Your account has been verified successfully. Thank you for completing the verification process.','total'=>'Verified','balance'=>'No action needed','payment'=>'Account Security','due'=>'Completed','unread'=>false],
        ['category'=>'security','step'=>0,'order'=>'Account','chip'=>'Security Alert','title'=>'Suspicious Login Detected','time'=>'May 27, 2026, 1:05 PM','icon'=>'shield','color'=>'red','preview'=>'We detected a login attempt from a new device in Quezon City.','message'=>'We detected a login attempt from a new device in Quezon City. If this was not you, please secure your account immediately.','total'=>'Security alert','balance'=>'Review needed','payment'=>'Login Protection','due'=>'Immediate action recommended','unread'=>false],
        ['category'=>'billing','step'=>4,'order'    =>'#ORD-55180','chip'=>'Billing','title'=>'Invoice Available','time'=>'May 27, 2026, 10:30 AM','icon'=>'file','color'=>'blue','preview'=>'Invoice for Order <strong>#ORD-55180</strong> is now available for download.','message'=>'Your invoice is now available for download. You may view or save it from your account billing records.','total'=>'₱2,050.00','balance'=>'Paid','payment'=>'Credit Card','due'=>'Invoice ready','unread'=>false],
        ['category'=>'promotions','step'=>0,'order'=>'Promo','chip'=>'Recommendation','title'=>'Re-order Recommendation','time'=>'May 26, 2026, 11:20 AM','icon'=>'card','color'=>'blue','preview'=>'Need more business cards? Re-order in one click.','message'=>'Need more business cards? You can re-order your previous design in one click.','total'=>'Re-order available','balance'=>'Optional','payment'=>'Previous design saved','due'=>'Anytime','unread'=>false],
    ];
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700&display=swap');
:root{
    --nf-bg:#ffffff;--nf-card:#ffffff;--nf-ink:#111827;--nf-muted:#6b7280;--nf-soft:#f7f7f8;
    --nf-line:#eceff3;--nf-line2:#e2e5ea;--nf-orange:#ff7a00;--nf-orange-dark:#e86f00;--nf-orange-soft:#fff3e6;
    --nf-blue:#2563eb;--nf-blue-soft:#eaf2ff;--nf-green:#16a34a;--nf-green-soft:#eaf8ef;--nf-yellow:#f59e0b;
    --nf-yellow-soft:#fff7df;--nf-red:#ef4444;--nf-red-soft:#fff0f0;--nf-purple:#7c3aed;--nf-purple-soft:#f2ebff;
    --nf-shadow:0 12px 30px rgba(15,23,42,.07);--nf-shadow-hover:0 18px 42px rgba(15,23,42,.11);
    --nf-radius:14px;--nf-font:'Inter',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    --nf-header:'Playfair Display',Georgia,serif;--nf-title:'Poppins',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
}
*{box-sizing:border-box}
.nf-page{min-height:calc(100vh - 70px);padding:0 0 34px;background:var(--nf-bg);color:var(--nf-ink);font-family:var(--nf-font);font-weight:400;overflow-x:hidden;-webkit-font-smoothing:antialiased;text-rendering:optimizeLegibility}
.nf-page a{text-decoration:none;color:inherit}.nf-page button,.nf-page select,.nf-page input,.nf-page textarea{font-family:var(--nf-font)}
.nf-wrap{max-width:1490px;margin:0 auto}.nf-head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin:0 0 16px}
.nf-title-wrap{display:flex;align-items:flex-start;gap:10px}.nf-title-wrap:before{content:'';width:18px;height:4px;margin-top:8px;border-radius:999px;background:var(--nf-orange);box-shadow:0 0 0 3px rgba(255,122,0,.08)}
.nf-title{margin:0 0 3px;font-family:var(--nf-header);font-size:40px;font-weight:700;line-height:1.2;color:#111827;letter-spacing:-.02em}.nf-sub{margin:0;font-size:12px;line-height:1.45;color:var(--nf-muted)}
.nf-date{height:42px;min-width:178px;padding:0 15px;border:1px solid #111827;border-radius:8px;background:#fff;color:#111827;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-size:12px;font-weight:700;line-height:1;white-space:nowrap}
.nf-date svg{width:16px;height:16px}
.nf-head-actions,.nf-tools,.nf-control,.nf-detail-row,.nf-actions,.nf-modal-head,.nf-modal-actions,.nf-quick{display:flex;align-items:center;justify-content:space-between;gap:10px}.nf-head-actions,.nf-control{justify-content:flex-end;flex-wrap:wrap}
.nf-tools{margin-bottom:18px;align-items:center}.nf-tabs{display:flex;align-items:center;gap:10px;overflow:auto;padding-bottom:2px}
.nf-btn,.nf-select,.nf-tab,.nf-action,.nf-link-btn{height:42px;border-radius:10px;border:1px solid var(--nf-orange);background:var(--nf-orange);color:#000;font-size:12px;font-weight:700;line-height:1;letter-spacing:.014em;display:inline-flex;align-items:center;justify-content:center;gap:8px;white-space:nowrap;cursor:pointer;outline:0;transition:background .18s ease,border-color .18s ease,color .18s ease,box-shadow .18s ease,transform .18s ease}
.nf-btn,.nf-tab,.nf-action,.nf-link-btn{min-width:132px;padding:0 16px}.nf-select{min-width:148px;padding:0 34px 0 13px;color:#000;background:var(--nf-orange);border-color:var(--nf-orange)}
.nf-btn svg,.nf-action svg,.nf-link-btn svg{width:15px;height:15px}.nf-btn.secondary,.nf-tab,.nf-action.secondary{background:#fff;color:#000;border-color:var(--nf-line2);box-shadow:0 6px 16px rgba(15,23,42,.04)}
.nf-btn:hover,.nf-btn:focus,.nf-tab:hover,.nf-tab:focus,.nf-tab.active,.nf-action:hover,.nf-action:focus,.nf-select:hover,.nf-select:focus,.nf-link-btn:hover,.nf-link-btn:focus{background:#111827!important;border-color:#111827!important;color:#fff!important;box-shadow:0 12px 24px rgba(17,24,39,.20);transform:none}
.nf-tab.active{box-shadow:none}.nf-layout{display:grid;grid-template-columns:minmax(380px,.74fr) minmax(0,1.26fr);gap:18px;align-items:start}.nf-workspace{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:18px;align-items:start}.nf-center,.nf-side{display:grid;gap:18px;align-content:start;min-width:0}
.nf-card{background:var(--nf-card);border:1px solid #111827;border-radius:var(--nf-radius);box-shadow:var(--nf-shadow);transition:background .18s ease,box-shadow .18s ease,border-color .18s ease,transform .18s ease}.nf-card:hover{background:rgba(17,24,39,.10);box-shadow:var(--nf-shadow-hover);border-color:#111827;transform:none}.nf-list-card{overflow:hidden}.nf-scroll{height:702px;overflow:auto}.nf-scroll::-webkit-scrollbar{width:8px}.nf-scroll::-webkit-scrollbar-track{background:#f3f4f6}.nf-scroll::-webkit-scrollbar-thumb{background:#9ca3af;border-radius:999px}
.nf-item{width:100%;border:0;border-bottom:1px solid #f0f1f3;background:#fff;padding:13px 14px;display:grid;grid-template-columns:20px 34px minmax(0,1fr) auto;gap:12px;align-items:center;text-align:left;cursor:pointer;transition:background .18s ease,color .18s ease,transform .18s ease}.nf-item:hover,.nf-item:focus{background:rgba(17,24,39,.10);transform:none}.nf-item:active,.nf-item.active{background:rgba(17,24,39,.16);box-shadow:inset 3px 0 0 var(--nf-orange)}
.nf-check{-webkit-appearance:none;appearance:none;width:14px;height:14px;border:1px solid #cfd4dc;border-radius:4px;background:#fff;display:grid;place-content:center;cursor:pointer}.nf-check:checked{background:var(--nf-orange);border-color:var(--nf-orange)}.nf-check:checked:after{content:'';width:4px;height:7px;border:solid #fff;border-width:0 2px 2px 0;transform:rotate(45deg);margin-top:-1px}
.nf-ico{width:32px;height:32px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.nf-ico svg{width:16px;height:16px}.orange{background:var(--nf-orange-soft);color:var(--nf-orange)}.green{background:var(--nf-green-soft);color:var(--nf-green)}.red{background:var(--nf-red-soft);color:var(--nf-red)}.blue{background:var(--nf-blue-soft);color:var(--nf-blue)}.purple{background:var(--nf-purple-soft);color:var(--nf-purple)}.yellow{background:var(--nf-yellow-soft);color:var(--nf-yellow)}
.nf-item-title{margin:0;color:#111827;font-family:var(--nf-title);font-size:12px;font-weight:600;letter-spacing:.022em;line-height:1.35}.nf-item-sub{margin:4px 0 0;color:#4b5563;font-size:10.5px;line-height:1.45;font-weight:400}.nf-item-sub strong{color:var(--nf-orange);font-weight:700}.nf-time{align-self:start;color:#6b7280;font-size:10px;font-weight:600;white-space:nowrap;display:inline-flex;align-items:center;gap:8px;margin-top:3px}.nf-dot{width:7px;height:7px;border-radius:999px;background:var(--nf-orange);display:inline-block}.nf-foot{padding:10px 14px;color:var(--nf-muted);font-size:10px;font-weight:600;background:#fff}.nf-empty{min-height:132px;display:grid;place-items:center;text-align:center;color:var(--nf-muted);font-size:12px;font-weight:600;padding:24px;background:#fff}
.nf-detail{padding:18px}.nf-detail-top{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:14px}.nf-chip{display:inline-flex;align-items:center;justify-content:center;border-radius:999px;padding:6px 10px;background:var(--nf-orange-soft);color:var(--nf-orange);font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.05em}.nf-close{width:32px;height:32px;border:1px solid var(--nf-line);border-radius:9px;background:#fff;color:#111827;font-size:20px;line-height:1;cursor:pointer;transition:.18s}.nf-close:hover,.nf-close:focus{background:#111827;border-color:#111827;color:#fff}
.nf-detail-title{margin:0 0 6px;font-family:var(--nf-title);font-size:22px;line-height:1.18;font-weight:600;letter-spacing:.01em;color:#111827}.nf-order{margin:0;color:#4b5563;font-size:12px;font-weight:600}.nf-order span{color:var(--nf-orange);font-weight:700}.nf-letter{margin-top:12px;color:#374151;font-size:12px;line-height:1.75;font-weight:400}.nf-letter strong{font-weight:700;color:#111827}.nf-summary{margin-top:15px;border:1px solid var(--nf-line);border-radius:12px;overflow:hidden;background:#fff}.nf-row{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:13px 16px;border-bottom:1px solid #f0f1f3;font-size:12px}.nf-row:last-child{border-bottom:0}.nf-row span:first-child{font-weight:600;color:#374151}.nf-row span:last-child{text-align:right;font-weight:700;color:#111827}.money{color:var(--nf-orange)!important;font-weight:800!important}.nf-actions{justify-content:flex-start;flex-wrap:wrap;margin-top:18px}
.nf-process-card{padding:16px;min-height:150px;overflow:hidden}.nf-process-card.is-highlighted{box-shadow:0 0 0 3px rgba(255,122,0,.16),var(--nf-shadow-hover);border-color:var(--nf-orange)}.nf-process-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}.nf-side-title,.nf-process-title{margin:0;color:#111827;font-family:var(--nf-title);font-size:13px;font-weight:600;letter-spacing:.04em}.nf-process-badge{display:inline-flex;align-items:center;gap:6px;color:var(--nf-orange);background:var(--nf-orange-soft);border-radius:999px;padding:6px 9px;font-size:9.5px;font-weight:800;white-space:nowrap}.nf-process-badge svg{width:13px;height:13px}.nf-progress{position:relative;display:grid;grid-template-columns:repeat(5,1fr);overflow:hidden;padding:0 2px}.nf-progress:before{content:'';position:absolute;top:15px;left:10%;right:10%;height:3px;background:#e5e7eb;z-index:0}.nf-fill{position:absolute;top:15px;left:10%;height:3px;max-width:80%;background:var(--nf-green);z-index:1;width:0;transition:.22s ease}.nf-step{position:relative;z-index:2;text-align:center;min-width:0}.nf-step-dot{width:31px;height:31px;border-radius:999px;margin:0 auto 7px;display:flex;align-items:center;justify-content:center;background:#fff;border:2px solid #cbd5e1;color:#94a3b8;font-size:12px;font-weight:800}.nf-step.done .nf-step-dot{border-color:var(--nf-green);background:var(--nf-green);color:#fff}.nf-step.current .nf-step-dot{border-color:var(--nf-orange);background:var(--nf-orange);color:#fff}.nf-step-label{display:block;color:#374151;font-size:9.5px;font-weight:700;line-height:1.25}.nf-step-status{display:block;margin-top:3px;color:#6b7280;font-size:9px;font-weight:500}.nf-process-meta{margin:12px 0 0;color:#6b7280;font-size:10.5px;font-weight:500}.nf-process-meta span{color:var(--nf-orange);font-weight:700}
.nf-side-card{padding:15px 16px}.nf-side-desc{margin:4px 0 10px;color:var(--nf-muted);font-size:11px;line-height:1.35;font-weight:400}.nf-pref{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:7px 0;border-bottom:1px solid #f0f1f3;transition:.18s}.nf-pref:hover{background:rgba(17,24,39,.10);margin-left:-8px;margin-right:-8px;padding-left:8px;padding-right:8px;border-radius:10px}.nf-pref:last-of-type{border-bottom:0}.nf-pref-left{display:flex;align-items:flex-start;gap:9px}.nf-pref-title{margin:0;color:#111827;font-family:var(--nf-title);font-size:11px;font-weight:600;letter-spacing:.018em}.nf-pref-sub{margin:2px 0 0;color:var(--nf-muted);font-size:9.3px;font-weight:400;line-height:1.3}.nf-switch{width:39px;height:22px;position:relative;flex:0 0 auto}.nf-switch input{opacity:0;width:0;height:0}.nf-slider{position:absolute;inset:0;border-radius:999px;background:#d1d5db;cursor:pointer;transition:.18s}.nf-slider:before{content:'';position:absolute;width:16px;height:16px;left:3px;top:3px;background:#fff;border-radius:50%;box-shadow:0 2px 5px rgba(0,0,0,.14);transition:.18s}.nf-switch input:checked+.nf-slider{background:var(--nf-green)}.nf-switch input:checked+.nf-slider:before{transform:translateX(17px)}.nf-wide{width:100%;margin-top:10px}.nf-quick{padding:7px 0;border-bottom:1px solid #f0f1f3;color:#374151;font-size:11px;font-weight:600}.nf-quick:last-child{border-bottom:0}.nf-quick strong{color:var(--nf-orange);font-weight:800}.nf-link{border:0;background:transparent;color:#111827;font-size:10px;font-weight:800;cursor:pointer;padding:0;transition:.18s}.nf-link:hover,.nf-link:focus{color:var(--nf-orange)}.nf-help{display:flex;align-items:center;gap:10px;margin-bottom:6px}.nf-help-icon{width:36px;height:36px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:var(--nf-orange-soft);color:var(--nf-orange)}.nf-help-icon svg{width:19px;height:19px}.nf-footer{margin-top:18px;display:flex;justify-content:space-between;gap:14px;color:var(--nf-muted);font-size:10px;font-weight:500}.nf-footer a{color:var(--nf-muted);margin-left:18px}
.nf-modal{display:none;position:fixed;inset:0;z-index:9999}.nf-modal.active{display:block}.nf-backdrop{position:absolute;inset:0;background:rgba(17,24,39,.38);backdrop-filter:blur(8px)}.nf-modal-shell{position:relative;min-height:100vh;padding:24px;display:flex;align-items:center;justify-content:center}.nf-modal-card{width:100%;max-width:520px;background:#fff;border:1px solid var(--nf-line);border-radius:16px;box-shadow:0 26px 80px rgba(15,23,42,.22);overflow:hidden}.nf-modal-head{padding:18px 20px;border-bottom:1px solid var(--nf-line)}.nf-modal-title{margin:0;font-family:var(--nf-title);font-size:14px;font-weight:600;letter-spacing:.04em;color:#111827}.nf-modal-body{padding:20px}.nf-field{display:flex;flex-direction:column;gap:7px;margin-bottom:13px}.nf-label{color:#4b5563;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.06em}.nf-input,.nf-textarea{border:1px solid var(--nf-line2);border-radius:10px;background:#fff;color:#111827;font-size:12px;font-weight:500;padding:11px 12px;outline:0;width:100%;transition:.18s}.nf-textarea{min-height:115px;resize:vertical}.nf-input:focus,.nf-textarea:focus{border-color:var(--nf-orange);box-shadow:0 0 0 3px rgba(255,122,0,.10)}.nf-modal-actions{justify-content:flex-end;margin-top:14px}.nf-toast{position:fixed;left:50%;top:110px;z-index:10000;background:#111827;color:#fff;padding:12px 15px;border-radius:12px;font-size:12px;font-weight:700;box-shadow:0 18px 50px rgba(17,24,39,.24);opacity:0;transform:translate(-50%,-12px);pointer-events:none;transition:.18s}.nf-toast.show{opacity:1;transform:translate(-50%,0)}.nf-hidden{display:none!important}
body:has(.nf-page) main,body:has(.nf-page) .main-content,body:has(.nf-page) .content-wrapper{background:#fff!important}body:has(.nf-page) aside:not(.nf-side) a[href*="notification"],body:has(.nf-page) aside:not(.nf-side) a[href*="notifications"],body:has(.nf-page) nav a[href*="notification"],body:has(.nf-page) nav a[href*="notifications"]{background:transparent!important;box-shadow:none!important}
@media(max-width:1320px){.nf-layout,.nf-workspace{grid-template-columns:1fr}.nf-side{grid-template-columns:repeat(3,minmax(0,1fr))}.nf-scroll{height:560px}}
@media(max-width:940px){.nf-side{grid-template-columns:1fr}.nf-tools,.nf-head{display:grid}.nf-head-actions,.nf-control{justify-content:stretch}.nf-btn,.nf-select{width:100%}.nf-detail-row{display:grid;justify-content:start}}
.nf-page .nf-card{border:1px solid #111827;border-radius:8px;box-shadow:none;background:#fff}.nf-page .nf-card:hover{background:#fff;box-shadow:none}.nf-page .nf-btn,.nf-page .nf-select,.nf-page .nf-action,.nf-page .nf-link-btn{border:0!important;border-radius:8px;background:var(--nf-orange);color:#111827;font-weight:600;letter-spacing:0;box-shadow:none!important}.nf-page .nf-btn.secondary,.nf-page .nf-action.secondary{background:#fff;color:#111827}.nf-page .nf-btn:hover,.nf-page .nf-btn:focus,.nf-page .nf-select:hover,.nf-page .nf-select:focus,.nf-page .nf-action:hover,.nf-page .nf-action:focus,.nf-page .nf-link-btn:hover,.nf-page .nf-link-btn:focus{background:#111827!important;color:#fff!important}.nf-page .nf-tab{border:1px solid var(--nf-line2);border-radius:8px;background:#fff;color:#111827;box-shadow:none;font-weight:600;letter-spacing:0}.nf-page .nf-tab:hover,.nf-page .nf-tab:focus,.nf-page .nf-tab.active{background:#111827!important;border-color:#111827!important;color:#fff!important}.nf-page .nf-side>.nf-card{border:0!important;border-radius:0!important;background:transparent!important;box-shadow:none!important;padding:0!important}.nf-page .nf-side>.nf-card:hover{border:0!important;background:transparent!important;box-shadow:none!important}.nf-page .nf-pref,.nf-page .nf-quick{border-bottom:1px solid #eef1f5}.nf-page .nf-toast{border:1px solid #111827;border-radius:10px;box-shadow:none;font-family:var(--nf-title);font-weight:600;letter-spacing:0}
@media(max-width:620px){.nf-page{padding:16px 12px 28px}.nf-title{font-size:30px}.nf-date{width:100%}.nf-item{grid-template-columns:20px 32px minmax(0,1fr)}.nf-time{grid-column:3}.nf-progress{grid-template-columns:1fr;gap:14px}.nf-progress:before,.nf-fill{display:none}.nf-step{text-align:left;display:grid;grid-template-columns:34px minmax(0,1fr);gap:8px;align-items:center}.nf-step-dot{margin:0}.nf-step-status{grid-column:2}.nf-footer{display:grid}}
.nf-page .nf-head-actions{margin-left:auto;justify-content:flex-end}
.nf-page .nf-action-row{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;margin:-2px 0 16px}
.nf-page .nf-center>.nf-card{border:0!important;border-radius:0!important;background:transparent!important;box-shadow:none!important}
.nf-page .nf-detail,.nf-page .nf-process-card{padding:0!important;min-height:0!important;overflow:visible!important}
.nf-page .nf-detail:hover,.nf-page .nf-process-card:hover{background:transparent!important;box-shadow:none!important;border-color:transparent!important}
.nf-page .nf-process-card.is-highlighted{box-shadow:0 0 0 3px rgba(255,122,0,.16)!important;border-color:transparent!important}
@media(max-width:940px){.nf-page .nf-action-row{justify-content:stretch}.nf-page .nf-action-row .nf-btn{width:100%}}


/* === Dashboard / My Orders unified notification refinements === */
:root{
    --nf-btn-a:#FE7B09;
    --nf-btn-b:#FFAB0A;
    --nf-hover-blur:rgba(17,24,39,.145);
    --nf-hover-blur-strong:rgba(17,24,39,.20);
}
.nf-page{background:#fff!important}
.nf-wrap{max-width:1490px!important;margin:0 auto!important;padding:0 0 26px!important}
.nf-head{align-items:flex-start!important;margin-bottom:22px!important}
.nf-date,
.nf-calendar-trigger{
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
.nf-date:hover,
.nf-date:focus,
.nf-calendar-trigger:hover,
.nf-calendar-trigger:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    box-shadow:none!important;
    outline:none!important;
}
.nf-date svg,
.nf-calendar-trigger svg{width:16px!important;height:16px!important;flex:0 0 auto!important}
.nf-tools{display:grid!important;grid-template-columns:minmax(0,1fr) auto!important;gap:18px!important;align-items:center!important;margin-bottom:18px!important}
.nf-tabs{display:grid!important;grid-template-columns:repeat(6,minmax(110px,1fr))!important;gap:12px!important;overflow:visible!important;padding:0!important}
.nf-tab{
    min-width:0!important;
    width:100%!important;
    height:38px!important;
    padding:0 12px!important;
    border-radius:8px!important;
    border:1px solid #e6e9ee!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    letter-spacing:0!important;
    box-shadow:none!important;
}
.nf-tab:hover,.nf-tab:focus,.nf-tab.active{
    background:rgba(17,24,39,.14)!important;
    border-color:#111827!important;
    color:#111827!important;
    box-shadow:0 10px 24px rgba(17,24,39,.08)!important;
    backdrop-filter:blur(7px)!important;
    transform:none!important;
}
.nf-control{display:flex!important;gap:10px!important;justify-content:flex-end!important;align-items:center!important;flex-wrap:nowrap!important}
.nf-filter-select,
.nf-filter-date,
.nf-select.nf-filter-select{
    width:112px!important;
    min-width:112px!important;
    max-width:112px!important;
    height:38px!important;
    padding:0 12px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    text-align:center!important;
    text-align-last:center!important;
    box-shadow:none!important;
    outline:none!important;
}
.nf-filter-date{
    width:154px!important;
    min-width:154px!important;
    max-width:154px!important;
}
.nf-filter-select:hover,
.nf-filter-select:focus,
.nf-filter-date:hover,
.nf-filter-date:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
}
.nf-export-btn,
.nf-btn,
.nf-action,
.nf-link-btn{
    height:38px!important;
    min-width:112px!important;
    width:auto!important;
    padding:0 16px!important;
    border-radius:999px!important;
    border:0!important;
    background:linear-gradient(90deg,var(--nf-btn-a),var(--nf-btn-b))!important;
    color:#111827!important;
    font-size:11.5px!important;
    font-weight:500!important;
    letter-spacing:0!important;
    box-shadow:none!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:8px!important;
    white-space:nowrap!important;
    cursor:pointer!important;
    transition:background .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease!important;
}
.nf-btn.secondary,
.nf-action.secondary{
    border:1px solid #111827!important;
    background:#fff!important;
    color:#111827!important;
}
.nf-export-btn:hover,.nf-export-btn:focus,
.nf-btn:hover,.nf-btn:focus,
.nf-action:hover,.nf-action:focus,
.nf-link-btn:hover,.nf-link-btn:focus,
.nf-btn.secondary:hover,.nf-btn.secondary:focus,
.nf-action.secondary:hover,.nf-action.secondary:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    box-shadow:none!important;
    transform:none!important;
}
.nf-select:not(.nf-filter-select){
    height:38px!important;
    min-width:138px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    box-shadow:none!important;
}
.nf-select:not(.nf-filter-select):hover,.nf-select:not(.nf-filter-select):focus{background:#111827!important;color:#fff!important}
.nf-card{border:1px solid #111827!important;border-radius:8px!important;background:#fff!important;box-shadow:none!important;transform:none!important}
.nf-card:hover,.nf-item:hover,.nf-item:focus,.nf-pref:hover,.nf-quick:hover{
    background:var(--nf-hover-blur)!important;
    box-shadow:0 12px 28px rgba(17,24,39,.08)!important;
    backdrop-filter:blur(7px)!important;
    transform:none!important;
}
.nf-item:active,.nf-item.active{background:var(--nf-hover-blur-strong)!important;box-shadow:inset 3px 0 0 var(--nf-orange)!important;transform:none!important}
.nf-ico{background:transparent!important;border-radius:0!important;width:28px!important;height:28px!important}
.nf-ico svg{width:17px!important;height:17px!important}
.orange{color:#ff7a00!important}.blue{color:#2563eb!important}.green{color:#16a34a!important}.purple{color:#7c3aed!important}.red{color:#ef4444!important}.yellow{color:#f59e0b!important}
.nf-help-icon{background:transparent!important;color:#ff7a00!important}
.nf-action-row{margin:-2px 0 16px!important;gap:10px!important}
.nf-action-row .nf-btn{min-width:150px!important}
.nf-detail,.nf-process-card{background:#fff!important;border:1px solid #111827!important;border-radius:8px!important;padding:16px!important}
.nf-page .nf-center>.nf-card{border:1px solid #111827!important;border-radius:8px!important;background:#fff!important;padding:16px!important}
.nf-page .nf-detail,.nf-page .nf-process-card{padding:16px!important;min-height:0!important;overflow:hidden!important}
.nf-page .nf-detail:hover,.nf-page .nf-process-card:hover{background:var(--nf-hover-blur)!important;box-shadow:0 12px 28px rgba(17,24,39,.08)!important;border-color:#111827!important}
.nf-side>.nf-card{padding:0!important;border:0!important;background:transparent!important;box-shadow:none!important}
.nf-side>.nf-card:hover{background:transparent!important;box-shadow:none!important}
.nf-pref:hover{margin-left:0!important;margin-right:0!important;padding-left:7px!important;padding-right:7px!important;border-radius:8px!important}
.nf-wide{width:auto!important;min-width:150px!important;margin-top:10px!important}
.nf-process-badge,.nf-chip{background:transparent!important;color:var(--nf-orange)!important;border:0!important;padding-left:0!important}
.nf-hidden-tools{display:none!important}
@media(max-width:1320px){.nf-tools{grid-template-columns:1fr!important}.nf-control{justify-content:flex-start!important}.nf-tabs{grid-template-columns:repeat(3,minmax(120px,1fr))!important}}
@media(max-width:720px){.nf-tabs{grid-template-columns:1fr!important}.nf-control{flex-wrap:wrap!important}.nf-filter-select,.nf-filter-date,.nf-export-btn{width:100%!important;max-width:none!important}.nf-date,.nf-calendar-trigger{width:100%!important;max-width:none!important}.nf-action-row .nf-btn{width:100%!important}}

/* Unified customer calendar used by Notification date buttons */
.nf-calendar-overlay{position:fixed;inset:0;z-index:9998;display:flex;align-items:center;justify-content:center;padding:18px;background:rgba(17,24,39,.36);backdrop-filter:blur(9px);opacity:0;visibility:hidden;pointer-events:none;transition:opacity .2s ease,visibility .2s ease}
.nf-calendar-overlay.is-open{opacity:1;visibility:visible;pointer-events:auto}
.nf-calendar-modal{width:min(920px,100%);max-height:calc(100vh - 36px);overflow:hidden;border:1px solid #111827;border-radius:18px;background:#fff;box-shadow:0 26px 80px rgba(15,23,42,.22);display:grid;grid-template-columns:minmax(0,1.1fr) 310px}
.nf-cal-main{padding:18px;border-right:1px solid var(--nf-line);min-width:0}.nf-cal-side{padding:18px;background:#fff;min-width:0}.nf-cal-top{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}.nf-cal-title{margin:0;font-family:var(--nf-title);font-size:16px;font-weight:700;color:#111827}.nf-cal-subtitle{margin:3px 0 0;font-size:11px;font-weight:400;color:var(--nf-muted);line-height:1.45}.nf-cal-nav{display:flex;align-items:center;gap:7px}.nf-cal-icon-btn,.nf-cal-action-btn,.nf-cal-clear-btn{height:34px;border:1px solid #111827;border-radius:999px;background:#fff;color:#111827;font-size:11px;font-weight:500;display:inline-flex;align-items:center;justify-content:center;gap:6px;cursor:pointer;transition:.18s;box-shadow:none}.nf-cal-icon-btn{width:42px;padding:0}.nf-cal-action-btn{min-width:82px;padding:0 13px}.nf-cal-clear-btn{min-width:76px;padding:0 13px}.nf-cal-icon-btn:hover,.nf-cal-icon-btn:focus,.nf-cal-action-btn:hover,.nf-cal-action-btn:focus,.nf-cal-clear-btn:hover,.nf-cal-clear-btn:focus{background:#111827!important;border-color:#111827!important;color:#fff!important}.nf-cal-weekdays,.nf-cal-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:7px}.nf-cal-weekdays{margin-bottom:7px}.nf-cal-weekdays span{text-align:center;font-size:9.5px;font-weight:800;color:#6b7280;letter-spacing:.08em;text-transform:uppercase}.nf-cal-day{position:relative;min-height:78px;border:1px solid var(--nf-line);border-radius:12px;background:#fff;padding:8px;text-align:left;color:#111827;cursor:pointer;transition:.18s;overflow:hidden}.nf-cal-day:hover,.nf-cal-day:focus{border-color:#111827;background:rgba(17,24,39,.14);box-shadow:0 10px 24px rgba(17,24,39,.08);backdrop-filter:blur(7px)}.nf-cal-day.is-muted{background:#fafafa;color:#a1a1aa;cursor:default}.nf-cal-day.is-today{border-color:var(--nf-orange);background:var(--nf-orange-soft)}.nf-cal-day.is-selected{border-color:#111827;background:rgba(17,24,39,.16);box-shadow:inset 0 0 0 1px #111827}.nf-cal-day-number{display:block;font-size:12px;font-weight:800;line-height:1}.nf-cal-day-events{display:flex;flex-wrap:wrap;gap:4px;margin-top:17px}.nf-cal-event-dot{width:7px;height:7px;border-radius:999px;background:var(--nf-orange);box-shadow:0 0 0 3px rgba(255,122,0,.10)}.nf-cal-selected-date{margin:0 0 12px;font-family:var(--nf-title);font-size:15px;font-weight:700;color:#111827}.nf-cal-event-list{display:grid;gap:8px;max-height:182px;overflow:auto;padding-right:2px;margin-bottom:13px}.nf-cal-empty{min-height:74px;border:1px dashed var(--nf-line2);border-radius:12px;display:grid;place-items:center;text-align:center;color:var(--nf-muted);font-size:11px;font-weight:500;line-height:1.45;padding:12px;background:#fff}.nf-cal-event-item{border:1px solid var(--nf-line);border-radius:12px;background:#fff;padding:10px;display:grid;gap:7px}.nf-cal-event-title{font-size:12px;font-weight:800;color:#111827;line-height:1.3}.nf-cal-event-meta{font-size:10px;font-weight:600;color:var(--nf-orange);line-height:1.35}.nf-cal-event-note{font-size:10.5px;font-weight:400;color:var(--nf-muted);line-height:1.45}.nf-cal-event-actions{display:flex;gap:6px;justify-content:flex-end}.nf-cal-mini-btn{height:27px;padding:0 9px;border:1px solid #111827;border-radius:999px;background:#fff;color:#111827;font-size:9.5px;font-weight:600;cursor:pointer;transition:.18s}.nf-cal-mini-btn:hover,.nf-cal-mini-btn:focus{background:#111827;border-color:#111827;color:#fff}.nf-cal-mini-btn.danger{border-color:var(--nf-red-soft);color:var(--nf-red)}.nf-cal-form{display:grid;gap:9px}.nf-cal-field{display:grid;gap:5px}.nf-cal-field label{font-size:10px;font-weight:800;color:#4b5563;letter-spacing:.05em;text-transform:uppercase}.nf-cal-field input,.nf-cal-field textarea{width:100%;border:1px solid var(--nf-line);border-radius:10px;background:#fff;padding:10px 11px;color:#111827;font-family:var(--nf-font);font-size:12px;font-weight:500;outline:none;transition:.18s}.nf-cal-field textarea{min-height:68px;resize:vertical}.nf-cal-field input:focus,.nf-cal-field textarea:focus{border-color:var(--nf-orange);box-shadow:0 0 0 3px rgba(255,122,0,.10)}.nf-cal-form-actions{display:flex;align-items:center;justify-content:flex-end;gap:8px;margin-top:2px}.nf-cal-save-btn{height:34px;min-width:118px;padding:0 14px;border:0;border-radius:999px;background:#16a34a;color:#fff;font-size:11px;font-weight:500;cursor:pointer;transition:.18s}.nf-cal-save-btn:hover,.nf-cal-save-btn:focus{background:#111827!important;color:#fff!important}.nf-cal-use-date{margin-left:auto}
@media(max-width:820px){.nf-calendar-modal{grid-template-columns:1fr;overflow:auto}.nf-cal-main{border-right:0;border-bottom:1px solid var(--nf-line)}.nf-cal-day{min-height:62px}}



/* === Final Notification cleanup: keep only Bulk + Sort controls === */
.nf-page #detailChip{display:none!important}
.nf-page .nf-detail-top{justify-content:flex-end!important;margin-bottom:8px!important}
.nf-page .nf-notification-controls{gap:10px!important;justify-content:flex-end!important;align-items:center!important}
.nf-page .nf-tool-select{
    width:154px!important;
    min-width:154px!important;
    max-width:154px!important;
    height:38px!important;
    padding:0 13px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    text-align:center!important;
    text-align-last:center!important;
    box-shadow:none!important;
    outline:none!important;
    appearance:auto!important;
}
.nf-page .nf-tool-select:hover,
.nf-page .nf-tool-select:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
}
.nf-page .nf-filter-select,
.nf-page .nf-filter-date,
.nf-page #notificationExportBtn{display:none!important}
.nf-page .nf-tab:hover,
.nf-page .nf-tab:focus,
.nf-page .nf-tab.active,
.nf-page .nf-item:hover,
.nf-page .nf-item:focus,
.nf-page .nf-item.active,
.nf-page .nf-pref:hover,
.nf-page .nf-quick:hover{
    background:rgba(17,24,39,.16)!important;
    box-shadow:0 12px 28px rgba(17,24,39,.09)!important;
    backdrop-filter:blur(8px)!important;
    transform:none!important;
}
@media(max-width:940px){
    .nf-page .nf-notification-controls{justify-content:stretch!important;flex-wrap:wrap!important}
    .nf-page .nf-tool-select{width:100%!important;min-width:0!important;max-width:none!important}
}



/* === FINAL requested notification fixes: tabs, centered buttons, cleaner detail/process === */
.nf-page .nf-tabs{
    display:flex!important;
    align-items:center!important;
    gap:10px!important;
    overflow-x:auto!important;
    padding-bottom:2px!important;
}
.nf-page .nf-tab{
    width:auto!important;
    min-width:112px!important;
    max-width:none!important;
    height:38px!important;
    padding:0 16px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    letter-spacing:0!important;
    box-shadow:none!important;
    transform:none!important;
}
.nf-page .nf-tab:hover,
.nf-page .nf-tab:focus,
.nf-page .nf-tab.active{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    box-shadow:none!important;
    backdrop-filter:none!important;
    transform:none!important;
}
.nf-page .nf-tab[data-filter="all"]{
    min-width:92px!important;
}
.nf-page .nf-action-row #markAllTop,
.nf-page #markAllTop{
    background:linear-gradient(90deg,var(--nf-btn-a),var(--nf-btn-b))!important;
    color:#111827!important;
    border:0!important;
}
.nf-page .nf-action-row #markAllTop:hover,
.nf-page .nf-action-row #markAllTop:focus,
.nf-page #markAllTop:hover,
.nf-page #markAllTop:focus{
    background:#111827!important;
    color:#fff!important;
    border-color:#111827!important;
}
.nf-page .nf-side-card .nf-wide{
    display:inline-flex!important;
    width:auto!important;
    min-width:150px!important;
    margin:12px auto 0!important;
}
.nf-page .nf-side-card{
    text-align:left!important;
}
.nf-page .nf-side-card > .nf-wide{
    margin-left:auto!important;
    margin-right:auto!important;
}
.nf-page .nf-help + .nf-wide,
.nf-page .nf-pref + .nf-wide,
.nf-page .nf-side-card button.nf-wide{
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
}
/* remove the boxed/selected look from the active Payment Pending Reminder row */
.nf-page .nf-item,
.nf-page .nf-item.active,
.nf-page .nf-item:active{
    background:#fff!important;
    box-shadow:none!important;
    border-left:0!important;
    transform:none!important;
}
.nf-page .nf-item:hover,
.nf-page .nf-item:focus{
    background:rgba(17,24,39,.13)!important;
    box-shadow:0 10px 24px rgba(17,24,39,.08)!important;
    backdrop-filter:blur(7px)!important;
    transform:none!important;
}
/* keep the detail message clean, without a heavy visible box */
.nf-page .nf-detail,
.nf-page .nf-center .nf-detail{
    border:0!important;
    background:#fff!important;
    box-shadow:none!important;
    padding:16px!important;
}
.nf-page .nf-detail:hover,
.nf-page .nf-center .nf-detail:hover{
    background:#fff!important;
    border:0!important;
    box-shadow:none!important;
    backdrop-filter:none!important;
}
/* make Order Process present but not too visible */
.nf-page .nf-process-card,
.nf-page .nf-center .nf-process-card{
    border:1px solid #e6e9ee!important;
    background:rgba(255,255,255,.72)!important;
    box-shadow:none!important;
    padding:16px!important;
}
.nf-page .nf-process-card:hover,
.nf-page .nf-center .nf-process-card:hover{
    border-color:#d7dce3!important;
    background:rgba(17,24,39,.06)!important;
    box-shadow:0 10px 24px rgba(17,24,39,.05)!important;
    backdrop-filter:blur(6px)!important;
    transform:none!important;
}
.nf-page .nf-process-card.is-highlighted{
    border-color:#e6e9ee!important;
    box-shadow:0 0 0 3px rgba(254,123,9,.10)!important;
}
@media(max-width:1320px){
    .nf-page .nf-tabs{flex-wrap:wrap!important;overflow:visible!important}
}
@media(max-width:720px){
    .nf-page .nf-tab{width:100%!important;min-width:0!important}
}



/* === Final notification cleanup: no X bg, steady preference hover, consistent endpoints === */
.nf-page .nf-close,
.nf-page button.nf-close,
.nf-page .nf-modal-head .nf-close{
    width:30px!important;
    height:30px!important;
    min-width:30px!important;
    padding:0!important;
    border:0!important;
    border-radius:0!important;
    background:transparent!important;
    color:#111827!important;
    box-shadow:none!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    font-size:24px!important;
    font-weight:400!important;
    line-height:1!important;
    cursor:pointer!important;
    transform:none!important;
    transition:color .18s ease, opacity .18s ease!important;
}
.nf-page .nf-close:hover,
.nf-page .nf-close:focus,
.nf-page button.nf-close:hover,
.nf-page button.nf-close:focus{
    background:transparent!important;
    border:0!important;
    color:#111827!important;
    opacity:.68!important;
    box-shadow:none!important;
    transform:none!important;
    outline:none!important;
}

/* keep Notification Preferences steady, no layout movement */
.nf-page .nf-pref,
.nf-page .nf-quick,
.nf-page .nf-side-card,
.nf-page .nf-help,
.nf-page .nf-side .nf-card{
    transform:none!important;
    transition:background .18s ease, box-shadow .18s ease, border-color .18s ease!important;
}
.nf-page .nf-pref:hover,
.nf-page .nf-pref:focus,
.nf-page .nf-quick:hover,
.nf-page .nf-quick:focus,
.nf-page .nf-help:hover,
.nf-page .nf-help:focus{
    background:rgba(17,24,39,.08)!important;
    box-shadow:0 8px 22px rgba(17,24,39,.045)!important;
    backdrop-filter:blur(6px)!important;
    transform:none!important;
}
.nf-page .nf-side-card:hover,
.nf-page .nf-side .nf-card:hover{
    background:transparent!important;
    box-shadow:none!important;
    transform:none!important;
}

/* consistent button sizing and hover: orange buttons black on hover; transparent buttons black border */
.nf-page .nf-btn:not(.secondary),
.nf-page .nf-action:not(.secondary),
.nf-page .nf-link-btn:not(.secondary){
    min-width:118px!important;
    height:38px!important;
    padding:0 16px!important;
    border-radius:999px!important;
    border:0!important;
    background:linear-gradient(90deg,#FE7B09 0%,#FFAB0A 100%)!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    letter-spacing:0!important;
    box-shadow:none!important;
    transform:none!important;
}
.nf-page .nf-btn.secondary,
.nf-page .nf-action.secondary,
.nf-page .nf-select{
    min-width:118px!important;
    height:38px!important;
    padding:0 16px!important;
    border-radius:999px!important;
    border:1px solid #111827!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    letter-spacing:0!important;
    box-shadow:none!important;
    transform:none!important;
}
.nf-page .nf-btn:hover,
.nf-page .nf-btn:focus,
.nf-page .nf-action:hover,
.nf-page .nf-action:focus,
.nf-page .nf-link-btn:hover,
.nf-page .nf-link-btn:focus,
.nf-page .nf-select:hover,
.nf-page .nf-select:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    box-shadow:none!important;
    transform:none!important;
}

/* tabs: All black, others transparent, clicked/active black */
.nf-page .nf-tab{
    height:38px!important;
    border-radius:8px!important;
    border:1px solid #111827!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    box-shadow:none!important;
    transform:none!important;
}
.nf-page .nf-tab.active,
.nf-page .nf-tab:hover,
.nf-page .nf-tab:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    box-shadow:none!important;
    transform:none!important;
}

/* cleaner detail panel and process area */
.nf-page .nf-detail-top{align-items:flex-start!important;margin-bottom:12px!important}
.nf-page .nf-detail-card,
.nf-page .nf-breakdown,
.nf-page .nf-data-card{
    border:1px solid #edf0f4!important;
    background:#fff!important;
    box-shadow:none!important;
}
.nf-page .nf-process-card{
    opacity:.82!important;
    border-color:#eef1f5!important;
    background:rgba(255,255,255,.64)!important;
}
.nf-page .nf-process-card:hover{
    opacity:1!important;
    background:rgba(17,24,39,.055)!important;
    box-shadow:0 10px 24px rgba(17,24,39,.045)!important;
    transform:none!important;
}

/* endpoint alignment and consistent gutters */
.nf-page .nf-layout,
.nf-page .nf-workspace{
    align-items:start!important;
}
.nf-page .nf-tools,
.nf-page .nf-action-row,
.nf-page .nf-workspace{
    width:100%!important;
}
.nf-page .nf-center,
.nf-page .nf-list-card,
.nf-page .nf-detail,
.nf-page .nf-process-card,
.nf-page .nf-side-card{
    transform:none!important;
}
.nf-page .nf-side-card .nf-wide,
.nf-page .nf-help .nf-wide,
.nf-page button.nf-wide{
    margin-left:auto!important;
    margin-right:auto!important;
    min-width:150px!important;
    width:auto!important;
}



/* === Final fix: X close is icon-only, no bg shape; hover changes color only === */
.nf-page .nf-close,
.nf-page button.nf-close,
.nf-page #clearDetailBtn{
    width:auto!important;
    height:auto!important;
    min-width:0!important;
    max-width:none!important;
    padding:0!important;
    margin:0!important;
    border:0!important;
    outline:0!important;
    border-radius:0!important;
    background:transparent!important;
    box-shadow:none!important;
    color:#111827!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    font-size:24px!important;
    font-weight:400!important;
    line-height:1!important;
    cursor:pointer!important;
    transform:none!important;
    transition:color .18s ease, opacity .18s ease!important;
}
.nf-page .nf-close:hover,
.nf-page .nf-close:focus,
.nf-page button.nf-close:hover,
.nf-page button.nf-close:focus,
.nf-page #clearDetailBtn:hover,
.nf-page #clearDetailBtn:focus{
    background:transparent!important;
    border:0!important;
    box-shadow:none!important;
    color:#000!important;
    opacity:1!important;
    transform:none!important;
    outline:0!important;
}
.nf-page .nf-close:active,
.nf-page #clearDetailBtn:active{
    background:transparent!important;
    color:#000!important;
    box-shadow:none!important;
    transform:none!important;
}

/* keep detail top aligned after icon-only close */
.nf-page .nf-detail-top{
    display:flex!important;
    align-items:flex-start!important;
    justify-content:flex-end!important;
    gap:12px!important;
}



/* === FINAL IMAGE-BASED UI PATCH: Mark All beside All, no extra preference button, wide list + narrower pending box === */
.nf-page .nf-wrap{
    max-width:1490px!important;
    margin:0 auto!important;
    padding:0 0 26px!important;
}
.nf-page .nf-head{
    margin-bottom:22px!important;
}
.nf-page .nf-action-row{
    display:none!important;
}
.nf-page .nf-tools{
    display:grid!important;
    grid-template-columns:minmax(0,1fr) auto!important;
    gap:18px!important;
    align-items:center!important;
    margin-bottom:18px!important;
    width:100%!important;
}
.nf-page .nf-tabs{
    display:flex!important;
    align-items:center!important;
    gap:10px!important;
    overflow-x:auto!important;
    padding:0 0 2px!important;
    min-width:0!important;
}
.nf-page .nf-tab,
.nf-page .nf-mark-read-tab{
    width:auto!important;
    min-width:112px!important;
    max-width:none!important;
    height:38px!important;
    padding:0 16px!important;
    border:1px solid #e6e9ee!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    letter-spacing:0!important;
    box-shadow:none!important;
    transform:none!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:8px!important;
    white-space:nowrap!important;
}
.nf-page .nf-tab[data-filter="all"]{
    min-width:92px!important;
}
.nf-page .nf-tab.active,
.nf-page .nf-tab:hover,
.nf-page .nf-tab:focus,
.nf-page .nf-mark-read-tab:hover,
.nf-page .nf-mark-read-tab:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    box-shadow:none!important;
    backdrop-filter:none!important;
    transform:none!important;
}
.nf-page .nf-mark-read-tab svg{
    width:14px!important;
    height:14px!important;
    flex:0 0 auto!important;
}
.nf-page .nf-layout{
    grid-template-columns:minmax(0,1fr) minmax(360px,420px)!important;
    gap:18px!important;
    align-items:start!important;
    width:100%!important;
}
.nf-page .nf-list-card{
    width:100%!important;
    min-width:0!important;
}
.nf-page .nf-workspace{
    display:block!important;
    width:100%!important;
    max-width:420px!important;
}
.nf-page .nf-detail{
    width:100%!important;
    max-width:420px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    padding:18px!important;
    box-shadow:none!important;
}
.nf-page .nf-detail:hover{
    background:#fff!important;
    border-color:#111827!important;
    box-shadow:none!important;
}
.nf-page .nf-detail-title{
    font-size:18px!important;
    line-height:1.25!important;
}
.nf-page .nf-actions{
    display:grid!important;
    grid-template-columns:1fr 1fr!important;
    gap:10px!important;
    width:100%!important;
    margin-top:18px!important;
}
.nf-page .nf-actions .nf-action{
    width:100%!important;
    min-width:0!important;
    margin:0!important;
}
.nf-page .nf-actions [data-open-modal="supportModal"]{
    grid-column:1 / -1!important;
}
.nf-page .nf-side,
.nf-page .nf-process-card{
    display:none!important;
}
@media(max-width:1320px){
    .nf-page .nf-layout{grid-template-columns:1fr!important;}
    .nf-page .nf-workspace,.nf-page .nf-detail{max-width:none!important;}
}
@media(max-width:940px){
    .nf-page .nf-tools{grid-template-columns:1fr!important;}
    .nf-page .nf-notification-controls{justify-content:flex-start!important;flex-wrap:wrap!important;}
}
@media(max-width:720px){
    .nf-page .nf-tab,.nf-page .nf-mark-read-tab{width:100%!important;min-width:0!important;}
    .nf-page .nf-actions{grid-template-columns:1fr!important;}
}
</style>
<div class="nf-page">
<svg width="0" height="0" style="position:absolute;visibility:hidden">
    <symbol id="i-card" viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2" fill="none" stroke="currentColor" stroke-width="1.9"/><path d="M3 10h18" stroke="currentColor" stroke-width="1.9"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.9"/><path d="M8 12.5l2.5 2.5L16.5 9" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/></symbol>
    <symbol id="i-warn" viewBox="0 0 24 24"><path d="M12 4l9 16H3L12 4z" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/><path d="M12 9v5M12 17h.01" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></symbol>
    <symbol id="i-file" viewBox="0 0 24 24"><path d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" fill="none" stroke="currentColor" stroke-width="1.9"/><path d="M14 3v5h5" fill="none" stroke="currentColor" stroke-width="1.9"/></symbol>
    <symbol id="i-truck" viewBox="0 0 24 24"><path d="M4 13V7h10v6h2l3 3H7l-3-3z" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/><circle cx="8" cy="19" r="1.8" fill="none" stroke="currentColor" stroke-width="1.9"/><circle cx="17" cy="19" r="1.8" fill="none" stroke="currentColor" stroke-width="1.9"/></symbol>
    <symbol id="i-calendar" viewBox="0 0 24 24"><path d="M8 3v4M16 3v4M4 10h16M6 5h12a2 2 0 0 1 2 2v13H4V7a2 2 0 0 1 2-2z" fill="none" stroke="currentColor" stroke-width="1.9"/></symbol>
    <symbol id="i-msg" viewBox="0 0 24 24"><path d="M4 5h16v11H8l-4 4V5z" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/><path d="M8 9h8M8 13h5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></symbol>
    <symbol id="i-tag" viewBox="0 0 24 24"><path d="M4 12V5h7l9 9-7 7-9-9z" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/><circle cx="8.5" cy="8.5" r="1.2" fill="currentColor"/></symbol>
    <symbol id="i-shield" viewBox="0 0 24 24"><path d="M12 3l7 3v5c0 5-3.5 8-7 10-3.5-2-7-5-7-10V6l7-3z" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/></symbol>
    <symbol id="i-headset" viewBox="0 0 24 24"><path d="M4 13v-1a8 8 0 0 1 16 0v1M4 13h4v6H6a2 2 0 0 1-2-2v-4zM20 13h-4v6h2a2 2 0 0 0 2-2v-4z" fill="none" stroke="currentColor" stroke-width="1.9"/></symbol>
    <symbol id="i-bell" viewBox="0 0 24 24"><path d="M6 17h12l-2-2v-4a4 4 0 0 0-8 0v4l-2 2z" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/><path d="M10 19a2 2 0 0 0 4 0" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></symbol>
    <symbol id="i-mail" viewBox="0 0 24 24"><rect x="4" y="6" width="16" height="12" rx="2" fill="none" stroke="currentColor" stroke-width="1.9"/><path d="M4 8l8 6 8-6" fill="none" stroke="currentColor" stroke-width="1.9"/></symbol>
    <symbol id="i-phone" viewBox="0 0 24 24"><rect x="7" y="3" width="10" height="18" rx="2" fill="none" stroke="currentColor" stroke-width="1.9"/><path d="M12 17h.01" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></symbol>
    <symbol id="i-grid" viewBox="0 0 24 24"><rect x="4" y="4" width="7" height="7" rx="1.5" fill="none" stroke="currentColor" stroke-width="1.9"/><rect x="13" y="4" width="7" height="7" rx="1.5" fill="none" stroke="currentColor" stroke-width="1.9"/><rect x="4" y="13" width="7" height="7" rx="1.5" fill="none" stroke="currentColor" stroke-width="1.9"/><rect x="13" y="13" width="7" height="7" rx="1.5" fill="none" stroke="currentColor" stroke-width="1.9"/></symbol>
    <symbol id="i-gear" viewBox="0 0 24 24"><path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z" fill="none" stroke="currentColor" stroke-width="1.9"/><path d="M4 12h2M18 12h2M12 4v2M12 18v2M6.3 6.3l1.4 1.4M16.3 16.3l1.4 1.4M17.7 6.3l-1.4 1.4M7.7 16.3l-1.4 1.4" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></symbol>
</svg>

<div class="nf-wrap">
    <div class="nf-head">
        <div class="nf-title-wrap">
            <div>
                <h1 class="nf-title">Notifications</h1>
                <p class="nf-sub">Stay updated with your orders, account, billing, and important messages.</p>
            </div>
        </div>
        <div class="nf-head-actions">
            <button type="button" class="nf-date nf-calendar-trigger" id="nfCalendarToggle" data-calendar-target="header"><svg><use href="#i-calendar"/></svg><span id="nfCalendarToggleText">Today is {{ now()->format('M d, Y') }}</span></button>
        </div>
    </div>
    <div class="nf-tools">
        <div class="nf-tabs">
            @foreach($tabs as $key => $label)
                <button class="nf-tab {{ $key === 'all' ? 'active' : '' }}" data-filter="{{ $key }}" type="button">{{ $label }} (0)</button>
                @if($key === 'all')
                    <button class="nf-tab nf-mark-read-tab" type="button" id="markAllTop"><svg><use href="#i-check"/></svg>Mark All Read</button>
                @endif
            @endforeach
        </div>
        <div class="nf-control nf-notification-controls">
            <select class="nf-select nf-tool-select" id="bulkAction" aria-label="Bulk action">
                <option value="">Bulk Actions</option>
                <option value="read">Mark selected as read</option>
                <option value="archive">Archive selected</option>
                <option value="delete">Delete selected</option>
            </select>
            <select class="nf-select nf-tool-select" id="sortSelect" aria-label="Sort notifications">
                <option value="latest">Sort by: Latest</option>
                <option value="oldest">Sort by: Oldest</option>
                <option value="unread">Sort by: Unread First</option>
            </select>
        </div>
    </div>

    <style id="notifications-clean-wide-layout-0621">
        .nf-page .nf-layout{
            grid-template-columns:minmax(0,1fr) minmax(360px,420px)!important;
            gap:18px!important;
            align-items:start!important;
            width:100%!important;
        }
        .nf-page .nf-list-card{
            width:100%!important;
            min-width:0!important;
        }
        .nf-page .nf-workspace{
            display:block!important;
            width:100%!important;
            max-width:420px!important;
        }
        .nf-page .nf-center{
            display:block!important;
            width:100%!important;
        }
        .nf-page .nf-detail{
            width:100%!important;
            max-width:420px!important;
        }
        .nf-page .nf-side,
        .nf-page .nf-process-card{
            display:none!important;
        }
        @media(max-width:1320px){
            .nf-page .nf-layout{
                grid-template-columns:1fr!important;
            }
            .nf-page .nf-workspace,
            .nf-page .nf-detail{
                max-width:none!important;
            }
        }
    </style>

    <div class="nf-layout">
        <section class="nf-card nf-list-card" aria-label="Notification list">
            <div class="nf-scroll" id="notificationList">
                @foreach($notifications as $notification)
                    <button class="nf-item {{ $loop->first ? 'active' : '' }} {{ $notification['unread'] ? 'unread' : '' }}"
                        type="button"
                        data-category="{{ $notification['category'] }}"
                        data-index="{{ $loop->index }}"
                        data-archived="0"
                        data-deleted="0"
                        data-step="{{ $notification['step'] }}"
                        data-order="{{ $notification['order'] }}"
                        data-chip="{{ $notification['chip'] }}"
                        data-title="{{ $notification['title'] }}"
                        data-time="{{ $notification['time'] }}"
                        data-icon="{{ $notification['icon'] }}"
                        data-color="{{ $notification['color'] }}"
                        data-message="{{ $notification['message'] }}"
                        data-total="{{ $notification['total'] }}"
                        data-balance="{{ $notification['balance'] }}"
                        data-payment="{{ $notification['payment'] }}"
                        data-due="{{ $notification['due'] }}">
                        <input class="nf-check" type="checkbox" aria-label="Select notification" onclick="event.stopPropagation()">
                        <span class="nf-ico {{ $notification['color'] }}"><svg><use href="#i-{{ $notification['icon'] }}"/></svg></span>
                        <span>
                            <p class="nf-item-title">{{ $notification['title'] }}</p>
                            <p class="nf-item-sub">{!! $notification['preview'] !!}</p>
                        </span>
                        <span class="nf-time">{{ $notification['time'] }} @if($notification['unread'])<i class="nf-dot"></i>@endif</span>
                    </button>
                @endforeach
                <div class="nf-empty nf-hidden" id="emptyState">No notifications found.</div>
            </div>
            <div class="nf-foot" id="listFoot">Showing notifications</div>
        </section>

        <div class="nf-workspace">
            <div class="nf-center">
                <section class="nf-card nf-detail" aria-label="Notification detail">
                    <div class="nf-detail-top">
                        <span class="nf-chip" id="detailChip">Order Update</span>
                        <button class="nf-close" type="button" id="clearDetailBtn" aria-label="Clear notification detail">×</button>
                    </div>
                    <h2 class="nf-detail-title" id="detailTitle">Payment Pending Reminder</h2>
                    <div class="nf-detail-row">
                        <p class="nf-order">Reference <span id="detailOrder">#ORD-55201</span></p>
                        <span class="nf-time" id="detailTime">2 mins ago <i class="nf-dot"></i></span>
                    </div>
                    <div class="nf-letter">
                        <p><strong>Hello {{ $customerName ?: 'Customer' }},</strong></p>
                        <p id="detailMessage">This is a friendly reminder that the payment for your order is still pending. To avoid delays, please complete your payment at your earliest convenience.</p>
                    </div>
                    <div class="nf-summary">
                        <div class="nf-row"><span>Total Amount</span><span class="money" id="detailTotal">₱2,850.00</span></div>
                        <div class="nf-row"><span>Outstanding Balance</span><span class="money" id="detailBalance">₱2,850.00</span></div>
                        <div class="nf-row"><span>Payment Method</span><span id="detailPayment">Bank Transfer (BPI)</span></div>
                        <div class="nf-row"><span>Due Date / Status</span><span id="detailDue">May 29, 2026, 11:59 PM</span></div>
                    </div>
                    <div class="nf-letter">
                        <p>Use the actions below if you need to track the related order, view the invoice, or contact support.</p>
                    </div>
                    <div class="nf-actions">
                        <button class="nf-action" type="button" id="trackOrderBtn"><svg><use href="#i-truck"/></svg>Track Order</button>
                        <button class="nf-action secondary" type="button" id="invoiceBtn"><svg><use href="#i-file"/></svg>View Invoice</button>
                        <button class="nf-action secondary" type="button" data-open-modal="supportModal"><svg><use href="#i-msg"/></svg>Reply to Support</button>
                    </div>
                </section>

                <section class="nf-card nf-process-card" aria-label="Order process">
                    <div class="nf-process-head">
                        <h3 class="nf-process-title">Order Process</h3>
                        <span class="nf-process-badge"><svg><use href="#i-bell"/></svg>Current Tracking</span>
                    </div>
                    <div class="nf-progress">
                        <div class="nf-fill" id="progressFill"></div>
                        @foreach(['Order Placed','Proof Approved','Payment Pending','In Production','Completed'] as $label)
                            <div class="nf-step" data-step-index="{{ $loop->index }}">
                                <span class="nf-step-dot">{{ $loop->index < 2 ? '✓' : ($loop->index === 2 ? '₱' : '•') }}</span>
                                <span class="nf-step-label">{{ $label }}</span>
                                <span class="nf-step-status">{{ $loop->index === 2 ? 'Current Step' : ($loop->index < 2 ? 'Done' : 'Pending') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <p class="nf-process-meta">Reference: <span id="progressOrder">#ORD-55201</span> &nbsp;&nbsp;•&nbsp;&nbsp; Updates are based on your selected notification.</p>
                </section>
            </div>
        </div>
    </div>



    <div class="nf-calendar-overlay" id="nfCalendarOverlay" aria-hidden="true">
        <section class="nf-calendar-modal" role="dialog" aria-modal="true" aria-labelledby="nfCalendarTitle">
            <div class="nf-cal-main">
                <div class="nf-cal-top">
                    <div>
                        <h3 class="nf-cal-title" id="nfCalendarTitle">Customer Calendar</h3>
                        <p class="nf-cal-subtitle">Select dates and manage your personal notification reminders.</p>
                    </div>
                    <div class="nf-cal-nav">
                        <button type="button" class="nf-cal-icon-btn" id="nfCalPrevMonth" aria-label="Previous month">‹</button>
                        <button type="button" class="nf-cal-action-btn" id="nfCalTodayBtn">Today</button>
                        <button type="button" class="nf-cal-icon-btn" id="nfCalNextMonth" aria-label="Next month">›</button>
                        <button type="button" class="nf-cal-icon-btn" id="nfCalCloseBtn" aria-label="Close calendar">×</button>
                    </div>
                </div>
                <div class="nf-cal-top" style="margin-bottom:12px">
                    <h4 class="nf-cal-title" id="nfCalMonthLabel" style="font-size:14px"></h4>
                    <button type="button" class="nf-cal-action-btn nf-cal-use-date" id="nfCalUseDateBtn">✓ Use Date</button>
                </div>
                <div class="nf-cal-weekdays" aria-hidden="true">
                    <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                </div>
                <div class="nf-cal-grid" id="nfCalendarGrid"></div>
            </div>
            <aside class="nf-cal-side">
                <h4 class="nf-cal-selected-date" id="nfCalSelectedDateLabel"></h4>
                <div class="nf-cal-event-list" id="nfCalEventList"></div>
                <form class="nf-cal-form" id="nfCalendarEventForm">
                    <input type="hidden" id="nfCalendarEventId">
                    <div class="nf-cal-field">
                        <label for="nfCalendarEventTitle">Event / Reminder</label>
                        <input type="text" id="nfCalendarEventTitle" maxlength="80" placeholder="Example: Review notification" required>
                    </div>
                    <div class="nf-cal-field">
                        <label for="nfCalendarEventTime">Time</label>
                        <input type="time" id="nfCalendarEventTime">
                    </div>
                    <div class="nf-cal-field">
                        <label for="nfCalendarEventNote">Note</label>
                        <textarea id="nfCalendarEventNote" maxlength="180" placeholder="Optional note"></textarea>
                    </div>
                    <div class="nf-cal-form-actions">
                        <button type="button" class="nf-cal-clear-btn" id="nfCalClearFormBtn">Clear</button>
                        <button type="submit" class="nf-cal-save-btn" id="nfCalSaveBtn">Save Event</button>
                    </div>
                </form>
            </aside>
        </section>
    </div>

    <div class="nf-footer">
        <span>© 2026 Printify & Co. All rights reserved.</span>
        <span><a href="javascript:void(0)">Privacy Policy</a><a href="javascript:void(0)">Terms of Service</a></span>
    </div>
</div>
</div>

<div id="preferencesModal" class="nf-modal" aria-hidden="true">
    <div class="nf-backdrop" data-modal-close></div>
    <div class="nf-modal-shell">
        <div class="nf-modal-card" role="dialog" aria-modal="true" aria-labelledby="preferencesTitle">
            <div class="nf-modal-head"><h3 class="nf-modal-title" id="preferencesTitle">Notification Preferences</h3><button class="nf-close" type="button" data-modal-close>×</button></div>
            <form class="nf-modal-body" id="preferencesForm">
                @foreach(['Email Notifications','SMS Notifications','In-App Notifications','Promotions & Offers'] as $prefLabel)
                    <div class="nf-pref">
                        <div><p class="nf-pref-title">{{ $prefLabel }}</p><p class="nf-pref-sub">Update preference and click save.</p></div>
                        <label class="nf-switch"><input type="checkbox" data-modal-pref="{{ $loop->index }}" {{ $loop->index < 3 ? 'checked' : '' }}><span class="nf-slider"></span></label>
                    </div>
                @endforeach
                <div class="nf-modal-actions"><button class="nf-action secondary" type="button" data-modal-close>Cancel</button><button class="nf-action" type="submit" id="savePrefBtn">Save Preferences</button></div>
            </form>
        </div>
    </div>
</div>

<div id="supportModal" class="nf-modal" aria-hidden="true">
    <div class="nf-backdrop" data-modal-close></div>
    <div class="nf-modal-shell">
        <div class="nf-modal-card" role="dialog" aria-modal="true" aria-labelledby="supportTitle">
            <div class="nf-modal-head"><h3 class="nf-modal-title" id="supportTitle">Reply to Support</h3><button class="nf-close" type="button" data-modal-close>×</button></div>
            <form class="nf-modal-body" id="supportForm">
                <div class="nf-field"><label class="nf-label" for="supportSubject">Subject</label><input class="nf-input" id="supportSubject" type="text" value="Payment Pending Reminder" required></div>
                <div class="nf-field"><label class="nf-label" for="supportMessage">Message</label><textarea class="nf-textarea" id="supportMessage" placeholder="Type your reply here..." required></textarea></div>
                <div class="nf-modal-actions"><button class="nf-action secondary" type="button" data-modal-close>Cancel</button><button class="nf-action" type="submit" id="sendSupportBtn">Send Reply</button></div>
            </form>
        </div>
    </div>
</div>

<div id="invoiceModal" class="nf-modal" aria-hidden="true">
    <div class="nf-backdrop" data-modal-close></div>
    <div class="nf-modal-shell">
        <div class="nf-modal-card" role="dialog" aria-modal="true" aria-labelledby="invoiceTitle">
            <div class="nf-modal-head"><h3 class="nf-modal-title" id="invoiceTitle">Invoice Preview</h3><button class="nf-close" type="button" data-modal-close>×</button></div>
            <div class="nf-modal-body">
                <div class="nf-summary">
                    <div class="nf-row"><span>Reference</span><span id="invoiceOrder">#ORD-55201</span></div>
                    <div class="nf-row"><span>Total</span><span class="money" id="invoiceTotal">₱2,850.00</span></div>
                    <div class="nf-row"><span>Balance</span><span id="invoiceBalance">₱2,850.00</span></div>
                    <div class="nf-row"><span>Payment</span><span id="invoicePayment">Bank Transfer (BPI)</span></div>
                    <div class="nf-row"><span>Due / Status</span><span id="invoiceDue">May 29, 2026, 11:59 PM</span></div>
                </div>
                <div class="nf-modal-actions"><button class="nf-action secondary" type="button" data-modal-close>Close</button><button class="nf-action" type="button" id="printInvoiceBtn">Print Invoice</button></div>
            </div>
        </div>
    </div>
</div>

<div class="nf-toast" id="notifToast" role="status" aria-live="polite"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const $ = (s, r = document) => r.querySelector(s);
    const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
    const list = $('#notificationList');
    const emptyState = $('#emptyState');
    const listFoot = $('#listFoot');
    const tabs = $$('.nf-tab');
    const cards = $$('.nf-item');
    const bulkAction = $('#bulkAction');
    const sortSelect = $('#sortSelect');
    const unreadCount = $('#unreadCount');
    const toast = $('#notifToast');
    const prefKey = 'printify_notification_preferences_v2';
    let activeFilter = 'all';
    let toastTimer = null;

    function showToast(message) {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toast.classList.remove('show'), 2300);
    }
    function updateNotificationUrl(extra = {}) {
        const params = new URLSearchParams(window.location.search);
        params.set('filter', extra.filter || activeFilter || 'all');
        params.set('sort', extra.sort || sortSelect?.value || 'latest');
        if (extra.view) params.set('view', extra.view); else params.delete('view');
        if (extra.action) params.set('action', extra.action); else params.delete('action');
        const query = params.toString();
        history.replaceState(null, '', window.location.pathname + (query ? '?' + query : ''));
    }
    function visibleCards() {
        return cards.filter(card => !card.classList.contains('nf-hidden'));
    }
    function activeCards() {
        return cards.filter(card => card.dataset.deleted !== '1' && card.dataset.archived !== '1');
    }
    function removeUnread(card) {
        if (!card || !card.classList.contains('unread')) return false;
        card.classList.remove('unread');
        const dot = card.querySelector('.nf-dot');
        if (dot) dot.remove();
        return true;
    }
    function setProgress(step, orderId) {
        const fill = $('#progressFill');
        const map = [0,20,40,60,80];
        const safeStep = Math.max(0, Math.min(4, Number(step) || 0));
        $$('.nf-step').forEach(stepEl => {
            const i = Number(stepEl.dataset.stepIndex);
            stepEl.classList.remove('done','current');
            if (i < safeStep) stepEl.classList.add('done');
            if (i === safeStep) stepEl.classList.add('current');
        });
        if (fill) fill.style.width = `${map[safeStep]}%`;
        $('#progressOrder').textContent = orderId || 'Account';
    }
    function selectNotification(card, silent = false) {
        if (!card) return;
        cards.forEach(item => item.classList.remove('active'));
        card.classList.add('active');
        $('#detailChip').textContent = card.dataset.chip || 'Notification';
        $('#detailTitle').textContent = card.dataset.title || 'Notification';
        $('#detailOrder').textContent = card.dataset.order || '—';
        $('#detailTime').innerHTML = `${card.dataset.time || 'Now'} ${card.classList.contains('unread') ? '<i class="nf-dot"></i>' : ''}`;
        $('#detailMessage').textContent = card.dataset.message || 'Select a notification from the list to view details.';
        $('#detailTotal').textContent = card.dataset.total || '—';
        $('#detailBalance').textContent = card.dataset.balance || '—';
        $('#detailPayment').textContent = card.dataset.payment || '—';
        $('#detailDue').textContent = card.dataset.due || '—';
        $('#supportSubject').value = card.dataset.title || 'Notification support request';
        setProgress(card.dataset.step, card.dataset.order);
        const wasUnread = removeUnread(card);
        updateAllStates();
        if (wasUnread && !silent) showToast('Notification opened and marked as read.');
        if (!silent) updateNotificationUrl({view:'detail'});
    }
    function applyFilter(filter = activeFilter) {
        activeFilter = filter;
        let first = null;
        cards.forEach(card => {
            const removed = card.dataset.deleted === '1' || card.dataset.archived === '1';
            const matches = filter === 'all' || card.dataset.category === filter;
            const show = !removed && matches;
            card.classList.toggle('nf-hidden', !show);
            if (show && !first) first = card;
        });
        tabs.forEach(tab => tab.classList.toggle('active', tab.dataset.filter === filter));
        if (typeof notificationStatusFilter !== 'undefined' && notificationStatusFilter) notificationStatusFilter.value = filter;
        updateAllStates();
        if (first) selectNotification(first, true); else clearDetail(true);
        updateNotificationUrl({filter});
    }
    function updateTabCounts() {
        const counts = {all:0, order:0, security:0, billing:0, promotions:0, messages:0};
        activeCards().forEach(card => { counts.all++; if (counts[card.dataset.category] !== undefined) counts[card.dataset.category]++; });
        tabs.forEach(tab => {
            const base = tab.textContent.replace(/\s*\(\d+\)\s*$/, '');
            tab.textContent = `${base} (${counts[tab.dataset.filter] || 0})`;
        });
    }
    function updateListState() {
        const visible = visibleCards().length;
        if (emptyState) emptyState.classList.toggle('nf-hidden', visible !== 0);
        if (listFoot) listFoot.textContent = visible ? `Showing 1 to ${visible} of ${visible} notifications` : 'No notifications found';
    }
    function updateUnreadCount() {
        if (unreadCount) unreadCount.textContent = cards.filter(card => card.classList.contains('unread') && card.dataset.deleted !== '1' && card.dataset.archived !== '1').length;
    }
    function updateAllStates() {
        updateTabCounts();
        updateListState();
        updateUnreadCount();
    }
    function clearDetail(silent = false) {
        cards.forEach(item => item.classList.remove('active'));
        $('#detailChip').textContent = 'Notification';
        $('#detailTitle').textContent = 'No notification selected';
        $('#detailOrder').textContent = '—';
        $('#detailTime').textContent = '—';
        $('#detailMessage').textContent = 'Select a notification from the list to view its full details.';
        $('#detailTotal').textContent = '—';
        $('#detailBalance').textContent = '—';
        $('#detailPayment').textContent = '—';
        $('#detailDue').textContent = '—';
        $('#supportSubject').value = 'Notification support request';
        setProgress(0, '—');
        if (!silent) showToast('Notification detail cleared.');
    }
    function ensureActive() {
        const active = $('.nf-item.active:not(.nf-hidden)');
        const first = $('.nf-item:not(.nf-hidden)');
        if (!active && first) selectNotification(first, true);
        if (!first) clearDetail(true);
    }
    function markAllAsRead() {
        let count = 0;
        cards.forEach(card => { if (removeUnread(card)) count++; });
        updateAllStates();
        updateNotificationUrl({action:'mark-all-read'});
        showToast(count ? 'All notifications marked as read.' : 'No unread notifications left.');
    }
    function runBulkAction(action) {
        if (!action) return;
        const selected = $$('.nf-check:checked').map(input => input.closest('.nf-item')).filter(Boolean);
        if (!selected.length) { showToast('Select at least one notification first.'); bulkAction.value = ''; return; }
        selected.forEach(card => {
            if (action === 'read') removeUnread(card);
            if (action === 'archive') { card.dataset.archived = '1'; card.classList.add('nf-hidden'); }
            if (action === 'delete') { card.dataset.deleted = '1'; card.classList.add('nf-hidden'); }
            const check = card.querySelector('.nf-check');
            if (check) check.checked = false;
        });
        bulkAction.value = '';
        applyFilter(activeFilter);
        ensureActive();
        const actionText = action === 'read' ? 'marked as read' : action === 'archive' ? 'archived' : 'deleted';
        updateNotificationUrl({action});
        showToast(`${selected.length} notification${selected.length > 1 ? 's' : ''} ${actionText}.`);
    }
    function sortNotifications(type) {
        const empty = $('#emptyState');
        const sorted = [...cards].sort((a,b) => {
            if (type === 'oldest') return Number(b.dataset.index) - Number(a.dataset.index);
            if (type === 'unread') {
                const diff = Number(b.classList.contains('unread')) - Number(a.classList.contains('unread'));
                if (diff !== 0) return diff;
            }
            return Number(a.dataset.index) - Number(b.dataset.index);
        });
        sorted.forEach(card => list.appendChild(card));
        if (empty) list.appendChild(empty);
        updateAllStates();
        updateNotificationUrl({sort:type});
        showToast('Notifications sorted.');
    }
    function syncInvoiceModal() {
        const pairs = {invoiceOrder:'detailOrder', invoiceTotal:'detailTotal', invoiceBalance:'detailBalance', invoicePayment:'detailPayment', invoiceDue:'detailDue'};
        Object.keys(pairs).forEach(target => { const src = $(`#${pairs[target]}`); const dest = $(`#${target}`); if (src && dest) dest.textContent = src.textContent; });
    }
    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        if (id === 'invoiceModal') syncInvoiceModal();
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        updateNotificationUrl({view:id.replace('Modal','')});
    }
    function closeModals() {
        $$('.nf-modal').forEach(modal => { modal.classList.remove('active'); modal.setAttribute('aria-hidden', 'true'); });
        document.body.style.overflow = '';
    }
    function savePreferenceState() {
        const values = $$('.nf-switch input').map(input => input.checked ? '1' : '0');
        try { localStorage.setItem(prefKey, values.join(',')); } catch (e) {}
    }
    function loadPreferenceState() {
        try {
            const saved = localStorage.getItem(prefKey);
            if (!saved) return;
            const values = saved.split(',');
            $$('.nf-switch input').forEach((input, index) => { if (values[index] !== undefined) input.checked = values[index] === '1'; });
        } catch (e) {}
    }

    cards.forEach(card => card.addEventListener('click', () => selectNotification(card)));
    tabs.forEach(tab => tab.addEventListener('click', () => applyFilter(tab.dataset.filter || 'all')));
    bulkAction?.addEventListener('change', () => runBulkAction(bulkAction.value));
    sortSelect?.addEventListener('change', () => sortNotifications(sortSelect.value));
    $('#clearDetailBtn')?.addEventListener('click', () => clearDetail());
    $('#markAllTop')?.addEventListener('click', markAllAsRead);
    $('#markAllSide')?.addEventListener('click', markAllAsRead);
    $('#unreadBtn')?.addEventListener('click', () => { sortSelect.value = 'unread'; sortNotifications('unread'); updateNotificationUrl({view:'unread', sort:'unread'}); showToast('Unread notifications shown first.'); });
    $('#historyBtn')?.addEventListener('click', () => { activeFilter = 'all'; tabs.forEach(t => t.classList.toggle('active', t.dataset.filter === 'all')); applyFilter('all'); updateNotificationUrl({filter:'all', view:'history'}); showToast('Notification history opened.'); });
    $('#trackOrderBtn')?.addEventListener('click', () => { const card = $('.nf-process-card'); if (card) { card.scrollIntoView({behavior:'smooth', block:'center'}); card.classList.add('is-highlighted'); setTimeout(() => card.classList.remove('is-highlighted'), 1400); } showToast(`Tracking opened for ${$('#detailOrder').textContent}.`); });
    $('#invoiceBtn')?.addEventListener('click', () => { syncInvoiceModal(); openModal('invoiceModal'); showToast('Invoice preview opened.'); });
    $('#printInvoiceBtn')?.addEventListener('click', () => { syncInvoiceModal(); showToast('Preparing invoice for print.'); setTimeout(() => window.print(), 180); });
    $$('[data-open-modal]').forEach(btn => btn.addEventListener('click', () => openModal(btn.dataset.openModal)));
    $$('[data-modal-close]').forEach(el => el.addEventListener('click', closeModals));
    document.addEventListener('keydown', event => { if (event.key === 'Escape') { closeModals(); nfCloseCalendar(); } });
    $$('.nf-switch input').forEach(input => input.addEventListener('change', () => { savePreferenceState(); if (input.dataset.prefLabel) showToast(`${input.dataset.prefLabel} ${input.checked ? 'enabled' : 'disabled'}.`); }));
    $('#preferencesForm')?.addEventListener('submit', event => { event.preventDefault(); const btn = $('#savePrefBtn'); const old = btn.textContent; btn.textContent = 'Saving...'; btn.disabled = true; savePreferenceState(); setTimeout(() => { btn.textContent = old; btn.disabled = false; closeModals(); showToast('Notification preferences saved.'); }, 420); });
    $('#supportForm')?.addEventListener('submit', event => { event.preventDefault(); const subject = $('#supportSubject').value.trim(); const message = $('#supportMessage').value.trim(); const btn = $('#sendSupportBtn'); if (!subject || !message) { showToast('Please complete the subject and message.'); return; } const old = btn.textContent; btn.textContent = 'Sending...'; btn.disabled = true; setTimeout(() => { btn.textContent = old; btn.disabled = false; $('#supportMessage').value = ''; closeModals(); showToast('Support reply sent successfully.'); }, 520); });


    const notificationStatusFilter = $('#notificationStatusFilter');
    const notificationExportBtn = $('#notificationExportBtn');
    const nfCalendarOverlay = $('#nfCalendarOverlay');
    const nfCalendarToggle = $('#nfCalendarToggle');
    const nfCalendarToggleText = $('#nfCalendarToggleText');
    const nfDateFilterBtn = $('#nfDateFilterBtn');
    const nfCalCloseBtn = $('#nfCalCloseBtn');
    const nfCalPrevMonth = $('#nfCalPrevMonth');
    const nfCalNextMonth = $('#nfCalNextMonth');
    const nfCalTodayBtn = $('#nfCalTodayBtn');
    const nfCalUseDateBtn = $('#nfCalUseDateBtn');
    const nfCalendarGrid = $('#nfCalendarGrid');
    const nfCalMonthLabel = $('#nfCalMonthLabel');
    const nfCalSelectedDateLabel = $('#nfCalSelectedDateLabel');
    const nfCalEventList = $('#nfCalEventList');
    const nfCalendarEventForm = $('#nfCalendarEventForm');
    const nfCalendarEventId = $('#nfCalendarEventId');
    const nfCalendarEventTitle = $('#nfCalendarEventTitle');
    const nfCalendarEventTime = $('#nfCalendarEventTime');
    const nfCalendarEventNote = $('#nfCalendarEventNote');
    const nfCalClearFormBtn = $('#nfCalClearFormBtn');
    const nfCalSaveBtn = $('#nfCalSaveBtn');
    const nfCalStorageKey = 'printify_notification_calendar_events_v1';
    const nfPad = value => String(value).padStart(2, '0');
    const nfDateKey = date => `${date.getFullYear()}-${nfPad(date.getMonth() + 1)}-${nfPad(date.getDate())}`;
    const nfSameDate = (a, b) => nfDateKey(a) === nfDateKey(b);
    const nfFormatDate = (date, options = {}) => date.toLocaleDateString('en-US', options);
    const nfFormatLong = date => nfFormatDate(date, {month:'long', day:'numeric', year:'numeric'});
    const nfFormatMonth = date => nfFormatDate(date, {month:'long', year:'numeric'});
    let nfCalendarEvents = [];
    let nfCalendarTarget = 'header';
    let nfToday = new Date();
    let nfSelectedDate = new Date(nfToday.getFullYear(), nfToday.getMonth(), nfToday.getDate());
    let nfViewDate = new Date(nfSelectedDate.getFullYear(), nfSelectedDate.getMonth(), 1);

    function nfLoadCalendarEvents() {
        try {
            const saved = JSON.parse(localStorage.getItem(nfCalStorageKey) || '[]');
            nfCalendarEvents = Array.isArray(saved) ? saved.filter(item => item && item.date && item.title) : [];
        } catch (e) { nfCalendarEvents = []; }
    }
    function nfSaveCalendarEvents() {
        try { localStorage.setItem(nfCalStorageKey, JSON.stringify(nfCalendarEvents)); } catch (e) {}
    }
    function nfEventsForDate(key) {
        return nfCalendarEvents.filter(item => item.date === key).sort((a, b) => String(a.time || '').localeCompare(String(b.time || '')));
    }
    function nfClearCalendarForm() {
        if (nfCalendarEventId) nfCalendarEventId.value = '';
        if (nfCalendarEventTitle) nfCalendarEventTitle.value = '';
        if (nfCalendarEventTime) nfCalendarEventTime.value = '';
        if (nfCalendarEventNote) nfCalendarEventNote.value = '';
        if (nfCalSaveBtn) nfCalSaveBtn.textContent = 'Save Event';
    }
    function nfOpenCalendar(target = 'header') {
        nfCalendarTarget = target;
        nfCalendarOverlay?.classList.add('is-open');
        nfCalendarOverlay?.setAttribute('aria-hidden', 'false');
        renderNfCalendar();
        showToast('Calendar opened.');
        setTimeout(() => nfCalendarGrid?.querySelector('.nf-cal-day.is-selected')?.focus(), 40);
    }
    function nfCloseCalendar() {
        nfCalendarOverlay?.classList.remove('is-open');
        nfCalendarOverlay?.setAttribute('aria-hidden', 'true');
    }
    function renderNfEventList() {
        if (!nfCalEventList || !nfCalSelectedDateLabel) return;
        const selectedKey = nfDateKey(nfSelectedDate);
        const selectedEvents = nfEventsForDate(selectedKey);
        nfCalSelectedDateLabel.textContent = nfFormatLong(nfSelectedDate);
        nfCalEventList.innerHTML = '';
        if (!selectedEvents.length) {
            const empty = document.createElement('div');
            empty.className = 'nf-cal-empty';
            empty.textContent = 'No reminders yet for this date. Add one below.';
            nfCalEventList.appendChild(empty);
            return;
        }
        selectedEvents.forEach(eventItem => {
            const card = document.createElement('div');
            card.className = 'nf-cal-event-item';
            const title = document.createElement('div');
            title.className = 'nf-cal-event-title';
            title.textContent = eventItem.title;
            const meta = document.createElement('div');
            meta.className = 'nf-cal-event-meta';
            meta.textContent = eventItem.time ? `Time: ${eventItem.time}` : 'No time set';
            const note = document.createElement('div');
            note.className = 'nf-cal-event-note';
            note.textContent = eventItem.note || 'No note added.';
            const actions = document.createElement('div');
            actions.className = 'nf-cal-event-actions';
            const editBtn = document.createElement('button');
            editBtn.type = 'button';
            editBtn.className = 'nf-cal-mini-btn';
            editBtn.textContent = 'Edit';
            editBtn.addEventListener('click', () => {
                if (nfCalendarEventId) nfCalendarEventId.value = eventItem.id;
                if (nfCalendarEventTitle) nfCalendarEventTitle.value = eventItem.title;
                if (nfCalendarEventTime) nfCalendarEventTime.value = eventItem.time || '';
                if (nfCalendarEventNote) nfCalendarEventNote.value = eventItem.note || '';
                if (nfCalSaveBtn) nfCalSaveBtn.textContent = 'Update Event';
                nfCalendarEventTitle?.focus();
            });
            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'nf-cal-mini-btn danger';
            deleteBtn.textContent = 'Delete';
            deleteBtn.addEventListener('click', () => {
                nfCalendarEvents = nfCalendarEvents.filter(item => item.id !== eventItem.id);
                nfSaveCalendarEvents();
                nfClearCalendarForm();
                renderNfCalendar();
                showToast('Reminder deleted.');
            });
            actions.append(editBtn, deleteBtn);
            card.append(title, meta, note, actions);
            nfCalEventList.appendChild(card);
        });
    }
    function renderNfCalendar() {
        if (!nfCalendarGrid || !nfCalMonthLabel) return;
        const year = nfViewDate.getFullYear();
        const month = nfViewDate.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startOffset = firstDay.getDay();
        const totalCells = Math.ceil((startOffset + lastDay.getDate()) / 7) * 7;
        nfCalMonthLabel.textContent = nfFormatMonth(nfViewDate);
        nfCalendarGrid.innerHTML = '';
        for (let index = 0; index < totalCells; index++) {
            const dayNumber = index - startOffset + 1;
            const cell = document.createElement('button');
            cell.type = 'button';
            cell.className = 'nf-cal-day';
            if (dayNumber < 1 || dayNumber > lastDay.getDate()) {
                cell.classList.add('is-muted');
                cell.disabled = true;
                nfCalendarGrid.appendChild(cell);
                continue;
            }
            const cellDate = new Date(year, month, dayNumber);
            const cellKey = nfDateKey(cellDate);
            const dayEvents = nfEventsForDate(cellKey);
            cell.classList.toggle('is-today', nfSameDate(cellDate, nfToday));
            cell.classList.toggle('is-selected', nfSameDate(cellDate, nfSelectedDate));
            const num = document.createElement('span');
            num.className = 'nf-cal-day-number';
            num.textContent = dayNumber;
            const eventWrap = document.createElement('span');
            eventWrap.className = 'nf-cal-day-events';
            dayEvents.slice(0,3).forEach(() => {
                const dot = document.createElement('span');
                dot.className = 'nf-cal-event-dot';
                eventWrap.appendChild(dot);
            });
            cell.append(num, eventWrap);
            cell.addEventListener('click', () => {
                nfSelectedDate = cellDate;
                nfClearCalendarForm();
                renderNfCalendar();
            });
            nfCalendarGrid.appendChild(cell);
        }
        renderNfEventList();
    }
    function nfApplyCalendarDate() {
        const label = nfFormatLong(nfSelectedDate);
        const shortLabel = nfFormatDate(nfSelectedDate, {month:'short', day:'numeric', year:'numeric'});
        if (nfCalendarTarget === 'filter' && nfDateFilterBtn) {
            nfDateFilterBtn.textContent = shortLabel;
            updateNotificationUrl({view:'date-filter'});
            showToast(`Date filter set to ${shortLabel}.`);
        } else if (nfCalendarToggleText) {
            nfCalendarToggleText.textContent = `Today is ${shortLabel}`;
            showToast(`Dashboard date set to ${label}.`);
        }
        nfCloseCalendar();
    }
    nfCalendarToggle?.addEventListener('click', () => nfOpenCalendar('header'));
    nfDateFilterBtn?.addEventListener('click', () => nfOpenCalendar('filter'));
    nfCalCloseBtn?.addEventListener('click', nfCloseCalendar);
    nfCalendarOverlay?.addEventListener('click', event => { if (event.target === nfCalendarOverlay) nfCloseCalendar(); });
    nfCalPrevMonth?.addEventListener('click', () => { nfViewDate = new Date(nfViewDate.getFullYear(), nfViewDate.getMonth() - 1, 1); renderNfCalendar(); });
    nfCalNextMonth?.addEventListener('click', () => { nfViewDate = new Date(nfViewDate.getFullYear(), nfViewDate.getMonth() + 1, 1); renderNfCalendar(); });
    nfCalTodayBtn?.addEventListener('click', () => {
        nfToday = new Date();
        nfSelectedDate = new Date(nfToday.getFullYear(), nfToday.getMonth(), nfToday.getDate());
        nfViewDate = new Date(nfSelectedDate.getFullYear(), nfSelectedDate.getMonth(), 1);
        nfClearCalendarForm();
        renderNfCalendar();
    });
    nfCalUseDateBtn?.addEventListener('click', nfApplyCalendarDate);
    nfCalClearFormBtn?.addEventListener('click', nfClearCalendarForm);
    nfCalendarEventForm?.addEventListener('submit', event => {
        event.preventDefault();
        const title = String(nfCalendarEventTitle?.value || '').trim();
        if (!title) { nfCalendarEventTitle?.focus(); return; }
        const existingId = String(nfCalendarEventId?.value || '').trim();
        const payload = {
            id: existingId || `evt-${Date.now()}-${Math.random().toString(16).slice(2)}`,
            date: nfDateKey(nfSelectedDate),
            title,
            time: String(nfCalendarEventTime?.value || '').trim(),
            note: String(nfCalendarEventNote?.value || '').trim(),
            updated_at: new Date().toISOString()
        };
        if (existingId) nfCalendarEvents = nfCalendarEvents.map(item => item.id === existingId ? {...item, ...payload} : item);
        else nfCalendarEvents.push(payload);
        nfSaveCalendarEvents();
        nfClearCalendarForm();
        renderNfCalendar();
        showToast(existingId ? 'Reminder updated.' : 'Reminder saved.');
    });
    notificationStatusFilter?.addEventListener('change', () => applyFilter(notificationStatusFilter.value || 'all'));
    notificationExportBtn?.addEventListener('click', () => {
        const visible = visibleCards();
        const headers = ['Title','Category','Reference','Time','Status'];
        const rows = visible.map(card => [card.dataset.title || '', card.dataset.category || '', card.dataset.order || '', card.dataset.time || '', card.classList.contains('unread') ? 'Unread' : 'Read']);
        const csv = [headers, ...rows].map(row => row.map(value => `"${String(value).replace(/"/g,'""')}"`).join(',')).join('\n');
        const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'notifications-export.csv';
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
        showToast('Notifications exported.');
    });
    nfLoadCalendarEvents();

    loadPreferenceState();
    const urlParams = new URLSearchParams(window.location.search);
    const initialFilter = urlParams.get('filter') || 'all';
    const initialSort = urlParams.get('sort') || 'latest';
    if (sortSelect) sortSelect.value = initialSort;
    if (initialSort !== 'latest') sortNotifications(initialSort);
    applyFilter(initialFilter);
    if (notificationStatusFilter) notificationStatusFilter.value = initialFilter;
    ensureActive();
});
</script>
</x-app-layout>

<style>
/* === FINAL PATCH: Bulk/Sort alignment, steady preferences, X hover only === */
.nf-page .nf-action-row,
.nf-page .nf-tools,
.nf-page .nf-notification-controls{
    transform:none!important;
}

/* Bulk Actions + Sort By: clean transparent controls like calendar/date */
.nf-page .nf-notification-controls{
    display:flex!important;
    align-items:center!important;
    justify-content:flex-end!important;
    gap:10px!important;
    flex-wrap:nowrap!important;
}
.nf-page .nf-tool-select,
.nf-page select.nf-tool-select,
.nf-page .nf-select.nf-tool-select{
    width:154px!important;
    min-width:154px!important;
    max-width:154px!important;
    height:38px!important;
    padding:0 34px 0 14px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background-color:#fff!important;
    background-image:none!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    line-height:1!important;
    text-align:center!important;
    text-align-last:center!important;
    box-shadow:none!important;
    outline:none!important;
    cursor:pointer!important;
    transform:none!important;
    transition:background-color .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease!important;
}
.nf-page .nf-tool-select:hover,
.nf-page .nf-tool-select:focus,
.nf-page select.nf-tool-select:hover,
.nf-page select.nf-tool-select:focus{
    background-color:#111827!important;
    border-color:#111827!important;
    color:#fff!important;
    box-shadow:none!important;
    transform:none!important;
}

/* Notification Preferences button must stay steady when hovered */
.nf-page [data-open-modal="preferencesModal"],
.nf-page .nf-action-row [data-open-modal="preferencesModal"]{
    transform:none!important;
    will-change:auto!important;
}
.nf-page [data-open-modal="preferencesModal"]:hover,
.nf-page [data-open-modal="preferencesModal"]:focus,
.nf-page .nf-action-row [data-open-modal="preferencesModal"]:hover,
.nf-page .nf-action-row [data-open-modal="preferencesModal"]:focus{
    background:#111827!important;
    color:#fff!important;
    border-color:#111827!important;
    box-shadow:none!important;
    transform:none!important;
}

/* X close: no base bg/border, but visible hover color only */
.nf-page .nf-close,
.nf-page button.nf-close,
.nf-page #clearDetailBtn{
    width:30px!important;
    height:30px!important;
    min-width:30px!important;
    padding:0!important;
    border:0!important;
    border-radius:999px!important;
    background:transparent!important;
    color:#111827!important;
    box-shadow:none!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    font-size:22px!important;
    font-weight:400!important;
    line-height:1!important;
    cursor:pointer!important;
    opacity:1!important;
    transform:none!important;
    transition:background .18s ease,color .18s ease,opacity .18s ease!important;
}
.nf-page .nf-close:hover,
.nf-page .nf-close:focus,
.nf-page button.nf-close:hover,
.nf-page button.nf-close:focus,
.nf-page #clearDetailBtn:hover,
.nf-page #clearDetailBtn:focus{
    background:#111827!important;
    color:#fff!important;
    border:0!important;
    opacity:1!important;
    box-shadow:none!important;
    transform:none!important;
    outline:none!important;
}

/* Preference rows: steady, no sliding/padding shift */
.nf-page .nf-pref,
.nf-page .nf-pref:hover,
.nf-page .nf-pref:focus{
    margin-left:0!important;
    margin-right:0!important;
    padding-left:0!important;
    padding-right:0!important;
    transform:none!important;
}
.nf-page .nf-pref:hover,
.nf-page .nf-pref:focus{
    background:rgba(17,24,39,.10)!important;
    box-shadow:0 8px 22px rgba(17,24,39,.05)!important;
    backdrop-filter:blur(6px)!important;
    border-radius:8px!important;
}

/* Keep tabs/buttons consistent and endpoint tidy */
.nf-page .nf-tools{
    grid-template-columns:minmax(0,1fr) auto!important;
    align-items:center!important;
}
.nf-page .nf-tabs{
    align-items:center!important;
}
.nf-page .nf-tab{
    transform:none!important;
}

@media(max-width:940px){
    .nf-page .nf-notification-controls{flex-wrap:wrap!important;justify-content:flex-start!important}
    .nf-page .nf-tool-select,
    .nf-page select.nf-tool-select{width:154px!important;min-width:154px!important;max-width:154px!important}
}
@media(max-width:620px){
    .nf-page .nf-tool-select,
    .nf-page select.nf-tool-select{width:100%!important;min-width:0!important;max-width:none!important}
}
</style>

<style>
/* === FINAL USER PATCH: X hover follows preference hover color only, no bg; ensure controls stay functional === */
.nf-page .nf-close,
.nf-page button.nf-close,
.nf-page #clearDetailBtn{
    background:transparent!important;
    border:0!important;
    box-shadow:none!important;
    color:#111827!important;
    border-radius:0!important;
    width:auto!important;
    height:auto!important;
    min-width:0!important;
    min-height:0!important;
    padding:4px!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    transform:none!important;
    transition:color .18s ease, opacity .18s ease!important;
}
.nf-page .nf-close:hover,
.nf-page .nf-close:focus,
.nf-page button.nf-close:hover,
.nf-page button.nf-close:focus,
.nf-page #clearDetailBtn:hover,
.nf-page #clearDetailBtn:focus{
    background:transparent!important;
    border:0!important;
    box-shadow:none!important;
    color:#6b7280!important;
    opacity:1!important;
    transform:none!important;
    outline:none!important;
}
.nf-page .nf-close:active,
.nf-page button.nf-close:active,
.nf-page #clearDetailBtn:active{
    background:transparent!important;
    color:#374151!important;
    transform:none!important;
}

/* Notification Preferences button and preference rows: hover steady only */
.nf-page [data-open-modal="preferencesModal"],
.nf-page [data-open-modal="preferencesModal"]:hover,
.nf-page [data-open-modal="preferencesModal"]:focus,
.nf-page .nf-pref,
.nf-page .nf-pref:hover,
.nf-page .nf-pref:focus{
    transform:none!important;
    margin-left:0!important;
    margin-right:0!important;
}
.nf-page .nf-pref:hover,
.nf-page .nf-pref:focus{
    background:rgba(17,24,39,.10)!important;
    border-radius:10px!important;
    box-shadow:0 8px 22px rgba(17,24,39,.05)!important;
    backdrop-filter:blur(6px)!important;
}

/* Bulk and Sort remain real selects with clean matching dashboard size */
.nf-page .nf-notification-controls{
    display:flex!important;
    align-items:center!important;
    justify-content:flex-end!important;
    gap:10px!important;
}
.nf-page select.nf-tool-select,
.nf-page .nf-tool-select{
    appearance:auto!important;
    -webkit-appearance:auto!important;
    width:154px!important;
    min-width:154px!important;
    max-width:154px!important;
    height:38px!important;
    padding:0 12px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    color:#111827!important;
    font-size:11px!important;
    font-weight:500!important;
    line-height:1!important;
    text-align:center!important;
    box-shadow:none!important;
    cursor:pointer!important;
    transform:none!important;
}
.nf-page select.nf-tool-select:hover,
.nf-page select.nf-tool-select:focus,
.nf-page .nf-tool-select:hover,
.nf-page .nf-tool-select:focus{
    background:#111827!important;
    color:#fff!important;
    border-color:#111827!important;
    box-shadow:none!important;
    transform:none!important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const clearBtn = document.getElementById('clearDetailBtn');
    const detailTitle = document.getElementById('detailTitle');
    const detailOrder = document.getElementById('detailOrder');
    const detailTime = document.getElementById('detailTime');
    const detailMessage = document.getElementById('detailMessage');
    const detailTotal = document.getElementById('detailTotal');
    const detailBalance = document.getElementById('detailBalance');
    const detailPayment = document.getElementById('detailPayment');
    const detailDue = document.getElementById('detailDue');
    const detailChip = document.getElementById('detailChip');
    const supportSubject = document.getElementById('supportSubject');

    function forceClearNotificationDetail() {
        document.querySelectorAll('.nf-item.active').forEach(item => item.classList.remove('active'));
        if (detailChip) detailChip.textContent = 'Notification';
        if (detailTitle) detailTitle.textContent = 'No notification selected';
        if (detailOrder) detailOrder.textContent = '—';
        if (detailTime) detailTime.textContent = '—';
        if (detailMessage) detailMessage.textContent = 'Select a notification from the list to view its details.';
        if (detailTotal) detailTotal.textContent = '—';
        if (detailBalance) detailBalance.textContent = '—';
        if (detailPayment) detailPayment.textContent = '—';
        if (detailDue) detailDue.textContent = '—';
        if (supportSubject) supportSubject.value = 'Notification support request';
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            forceClearNotificationDetail();
        });
    }
});
</script>

<style>
/* === ABSOLUTE FINAL OVERRIDE: follow screenshot spacing and proportions === */
.nf-page .nf-wrap{max-width:1490px!important;margin:0 auto!important;padding:0 0 26px!important;}
.nf-page .nf-action-row{display:none!important;}
.nf-page .nf-tools{display:grid!important;grid-template-columns:minmax(0,1fr) auto!important;gap:18px!important;align-items:center!important;width:100%!important;margin-bottom:18px!important;}
.nf-page .nf-tabs{display:flex!important;align-items:center!important;gap:10px!important;overflow-x:auto!important;padding:0 0 2px!important;}
.nf-page .nf-tab,.nf-page .nf-mark-read-tab{width:auto!important;min-width:112px!important;height:38px!important;padding:0 16px!important;border:1px solid #e6e9ee!important;border-radius:8px!important;background:#fff!important;color:#111827!important;font-size:11px!important;font-weight:500!important;box-shadow:none!important;transform:none!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;gap:8px!important;white-space:nowrap!important;}
.nf-page .nf-tab[data-filter="all"]{min-width:92px!important;}
.nf-page .nf-tab.active,.nf-page .nf-tab:hover,.nf-page .nf-tab:focus,.nf-page .nf-mark-read-tab:hover,.nf-page .nf-mark-read-tab:focus{background:#111827!important;border-color:#111827!important;color:#fff!important;box-shadow:none!important;transform:none!important;}
.nf-page .nf-layout{display:grid!important;grid-template-columns:minmax(0,1fr) minmax(360px,420px)!important;gap:18px!important;align-items:start!important;width:100%!important;}
.nf-page .nf-list-card{width:100%!important;min-width:0!important;}
.nf-page .nf-workspace{display:block!important;width:100%!important;max-width:420px!important;}
.nf-page .nf-center{display:block!important;width:100%!important;}
.nf-page .nf-detail{width:100%!important;max-width:420px!important;border:1px solid #111827!important;border-radius:8px!important;background:#fff!important;padding:18px!important;box-shadow:none!important;}
.nf-page .nf-detail:hover{background:#fff!important;border-color:#111827!important;box-shadow:none!important;}
.nf-page .nf-side,.nf-page .nf-process-card{display:none!important;}
.nf-page .nf-actions{display:grid!important;grid-template-columns:1fr 1fr!important;gap:10px!important;width:100%!important;}
.nf-page .nf-actions .nf-action{width:100%!important;min-width:0!important;margin:0!important;}
.nf-page .nf-actions [data-open-modal="supportModal"]{grid-column:1/-1!important;}
@media(max-width:1320px){.nf-page .nf-layout{grid-template-columns:1fr!important}.nf-page .nf-workspace,.nf-page .nf-detail{max-width:none!important}}
@media(max-width:940px){.nf-page .nf-tools{grid-template-columns:1fr!important}.nf-page .nf-notification-controls{justify-content:flex-start!important;flex-wrap:wrap!important}}
@media(max-width:720px){.nf-page .nf-tab,.nf-page .nf-mark-read-tab{width:100%!important;min-width:0!important}.nf-page .nf-actions{grid-template-columns:1fr!important}}
</style>

<style>
/* === FINAL PROFILE-MATCHED SPACING: narrower Notification box, same calendar width, all functions retained === */
.nf-page .nf-wrap{
    max-width:1490px!important;
    width:auto!important;
    margin-left:auto!important;
    margin-right:auto!important;
    padding-left:0!important;
    padding-right:0!important;
    padding-bottom:26px!important;
}
.nf-page .nf-head,
.nf-page .nf-tools,
.nf-page .nf-footer{
    width:100%!important;
    max-width:none!important;
}
.nf-page .nf-date,
.nf-page .nf-calendar-trigger{
    width:178px!important;
    min-width:178px!important;
    max-width:178px!important;
    height:42px!important;
    padding:0 13px!important;
}
.nf-page .nf-tools{
    display:grid!important;
    grid-template-columns:minmax(0,1fr) auto!important;
    gap:18px!important;
    align-items:center!important;
    margin-bottom:18px!important;
}
.nf-page .nf-layout{
    display:grid!important;
    grid-template-columns:minmax(0,1fr) minmax(360px,420px)!important;
    gap:18px!important;
    align-items:start!important;
    justify-content:start!important;
    width:100%!important;
    max-width:1200px!important;
}
.nf-page .nf-list-card{
    width:100%!important;
    min-width:0!important;
}
.nf-page .nf-workspace{
    display:block!important;
    width:100%!important;
    max-width:420px!important;
    justify-self:stretch!important;
}
.nf-page .nf-center,
.nf-page .nf-detail{
    width:100%!important;
}
.nf-page .nf-detail{
    max-width:420px!important;
    border:1px solid #111827!important;
    border-radius:8px!important;
    background:#fff!important;
    padding:18px!important;
    box-shadow:none!important;
}
.nf-page .nf-detail:hover{
    background:#fff!important;
    border-color:#111827!important;
    box-shadow:none!important;
}
.nf-page .nf-side,
.nf-page .nf-process-card{
    display:none!important;
}
@media(max-width:1320px){
    .nf-page .nf-layout{
        grid-template-columns:1fr!important;
        max-width:none!important;
    }
    .nf-page .nf-workspace,
    .nf-page .nf-detail{
        max-width:none!important;
    }
}
@media(max-width:940px){
    .nf-page .nf-tools{grid-template-columns:1fr!important;}
    .nf-page .nf-notification-controls{justify-content:flex-start!important;flex-wrap:wrap!important;}
}
@media(max-width:620px){
    .nf-page .nf-date,
    .nf-page .nf-calendar-trigger{width:100%!important;max-width:none!important;}
}
</style>
