<style>
:root{
  --pf-orange:#ff4f16;
  --pf-orange-2:#ff7a00;
  --pf-orange-3:#ffb000;
  --pf-gradient:linear-gradient(135deg,#ffb000 0%,#ff7a00 48%,#ff4f16 100%);
  --pf-black:#0b0b0b;
  --pf-text:#111827;
  --pf-muted:#6b7280;
  --pf-line:#dfe3ea;
  --pf-soft:#f6f6f6;
  --pf-card:#ffffff;
  --pf-green:#16a34a;
  --pf-shadow:0 18px 44px rgba(17,24,39,.055);
  --pf-head:'Playfair Display',Georgia,serif;
  --pf-body:'Poppins','Inter',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
}
*{box-sizing:border-box}
html{scroll-behavior:smooth}
#checkout{
  font-family:var(--pf-body);
  background:#fff;
  color:var(--pf-text);
  padding:34px 0 70px;
  overflow-x:hidden;
}
#checkout button,
#checkout input,
#checkout select,
#checkout textarea{font-family:var(--pf-body)}
#checkout a{text-decoration:none;color:inherit}
#checkout button{cursor:pointer;transition:.18s ease}
.pfy-page{width:min(1660px,calc(100% - 220px));margin:0 auto;padding:0}
.pfy-breadcrumb{display:flex;align-items:center;flex-wrap:wrap;gap:10px;margin:0 0 26px;font-size:12px;font-weight:600;color:#111827}
.pfy-breadcrumb i{font-size:9px;color:#aeb4be}
.pfy-breadcrumb a,
.pfy-breadcrumb span,
.pfy-breadcrumb strong{display:inline-flex;align-items:center;border-bottom:3px solid transparent;padding-bottom:3px;transition:.16s ease}
.pfy-breadcrumb a:hover,
.pfy-breadcrumb span:hover,
.pfy-breadcrumb strong{color:var(--pf-orange);border-bottom-color:var(--pf-orange)}
.pfy-page-head{margin:0 0 14px}
.pfy-page-head h1{margin:0;font-family:var(--pf-head);font-size:37px;line-height:1.05;font-weight:800;letter-spacing:-.7px;color:#111}
.pfy-page-head p{margin:8px 0 0;color:#4b5563;font-size:15px;font-weight:400}
.pfy-main-grid{display:grid;grid-template-columns:minmax(470px,1fr) minmax(470px,1.05fr) minmax(370px,430px);grid-template-areas:"steps steps steps" "customer delivery summary";gap:22px 26px;align-items:start}
.pfy-left{display:contents}
.pfy-stepper{grid-area:steps;width:min(760px,100%);justify-self:center;display:grid;grid-template-columns:auto 160px auto 160px auto 160px auto;align-items:center;margin:0 auto 2px;background:transparent;border:0;box-shadow:none}
.pfy-step{position:relative;display:flex;flex-direction:column;align-items:center;gap:9px;white-space:nowrap;color:#111827}
.pfy-step:after{content:"";position:absolute;top:16px;left:calc(50% + 28px);width:160px;border-top:2px solid #cfd5df;transform:translateY(-50%)}
.pfy-step:last-child:after{display:none}
.pfy-step.is-active:after,.pfy-step.is-done:after{border-top-color:var(--pf-orange)}
.pfy-step-no{width:34px;height:34px;border-radius:50%;border:2px solid #cfd5df;background:#fff;color:#111827;display:grid;place-items:center;font-size:14px;font-weight:800;z-index:2}
.pfy-step.is-active .pfy-step-no,.pfy-step.is-done .pfy-step-no{background:var(--pf-gradient);border-color:transparent;color:#fff;box-shadow:0 9px 16px rgba(255,79,22,.22)}
.pfy-step-copy strong{display:block;font-size:13px;font-weight:800;color:#111827;line-height:1.1}
.pfy-step-copy small{display:none}
.pfy-step.is-active .pfy-step-copy strong,.pfy-step.is-done .pfy-step-copy strong{color:var(--pf-orange)}
.pfy-customer-shipping{grid-area:customer}
.pfy-delivery-payment{grid-area:delivery}
.pfy-sidebar{grid-area:summary;position:static;width:100%;min-width:0}
.pfy-form-group,.pfy-summary,.pfy-secure-card,.pfy-success{background:#fff;border:1px solid var(--pf-line);border-radius:14px;box-shadow:none;overflow:hidden}
.pfy-card{background:transparent;border:0;border-radius:0;box-shadow:none;margin:0;overflow:visible}
.pfy-card + .pfy-card{border-top:1px solid #eceff3}
.pfy-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;padding:22px 22px 8px}
.pfy-card-title{display:flex;align-items:flex-start;gap:13px;min-width:0}
.pfy-card-icon,.pfy-summary-title i,.pfy-secure-icon{width:26px;min-width:26px;height:26px;display:grid;place-items:center;background:transparent;border:0;color:var(--pf-orange);font-size:21px;line-height:1}
.pfy-card-title h2,.pfy-summary h3,.pfy-secure-card h4{margin:0;color:#111;font-size:17px;line-height:1.22;font-weight:800;letter-spacing:-.15px}
.pfy-card-title p,.pfy-secure-card p{margin:6px 0 0;color:#4b5563;font-size:12px;line-height:1.4;font-weight:400}
.pfy-card-body{padding:14px 22px 24px}
.pfy-field-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px 18px}
.pfy-field-grid.two,.pfy-field-grid.four{grid-template-columns:repeat(2,minmax(0,1fr))}
.pfy-field-grid.four{margin-top:16px}
.pfy-field{position:relative;min-width:0}
.pfy-field.full{grid-column:1 / -1}
.pfy-field label{position:absolute;left:14px;top:12px;color:#6b7280;font-size:0;z-index:2;pointer-events:none}
.pfy-field input,.pfy-field select{width:100%;height:54px;border:1px solid var(--pf-line);border-radius:10px;background:#fff;color:#111827;outline:0;padding:0 14px;font-size:12.5px;font-weight:500;box-shadow:none}
.pfy-field input::placeholder,.pfy-field select{color:#374151}
.pfy-field input:focus,.pfy-field select:focus,.pfy-note-box textarea:focus,.pfy-promo input:focus{border-color:var(--pf-orange);box-shadow:0 0 0 4px rgba(255,79,22,.08)}
.pfy-section-control{display:flex;align-items:center;gap:9px;margin-top:8px;white-space:nowrap;color:#111827;font-size:12px;font-weight:500}
.pfy-checkline{display:none}
.pfy-checkline input,.pfy-section-control input{width:16px;height:16px;accent-color:var(--pf-green)}
.pfy-radio-stack{display:grid;gap:9px}
.pfy-delivery-option{display:grid;grid-template-columns:22px minmax(0,1fr) auto;align-items:center;gap:12px;min-height:58px;padding:12px 14px;border:1px solid var(--pf-line);border-radius:10px;background:#fff;transition:.18s ease}
.pfy-delivery-option:hover,.pfy-delivery-option.is-selected{border-color:#111827;background:rgba(17,24,39,.045)}
.pfy-delivery-option input{width:17px;height:17px;accent-color:var(--pf-green)}
.pfy-delivery-copy strong{display:flex;align-items:center;gap:10px;color:#111;font-size:12.5px;line-height:1.25;font-weight:800}
.pfy-delivery-copy strong em{font-style:normal;padding:3px 9px;border-radius:999px;background:#f3f4f6;color:#5b6472;font-size:10px;font-weight:600;white-space:nowrap}
.pfy-delivery-copy small{display:block;margin-top:3px;color:#4b5563;font-size:11px;line-height:1.35}
.pfy-delivery-price{color:#111;font-size:12.5px;font-weight:900;white-space:nowrap}
.pfy-note-box{position:relative}
.pfy-note-box textarea{width:100%;height:74px;resize:none;border:1px solid var(--pf-line);border-radius:10px;background:#fff;outline:0;padding:14px;color:#111827;font-size:12px;line-height:1.45}
.pfy-note-box small{position:absolute;right:14px;bottom:10px;color:#8b95a1;font-size:10px;font-weight:600}
.pfy-payment-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
.pfy-pay-option{min-width:0;min-height:66px;display:grid;grid-template-columns:18px 60px minmax(0,1fr);align-items:center;gap:10px;padding:12px 14px;border:1px solid var(--pf-line);border-radius:10px;background:#fff;transition:.18s ease;overflow:hidden}
.pfy-pay-option:hover,.pfy-pay-option.is-selected{border-color:#111827;background:rgba(17,24,39,.045)}
.pfy-pay-option input{width:16px;height:16px;accent-color:var(--pf-green);margin:0}
.pfy-pay-option i{width:22px;height:22px;display:grid;place-items:center;background:transparent;color:#111827;font-size:18px}
.pfy-pay-option .pfy-card-logos{display:flex;align-items:center;gap:6px;min-width:60px;font-weight:900}
.pfy-pay-option span{display:flex;flex-direction:column;gap:2px;min-width:0;line-height:1.2}
.pfy-pay-option strong{display:block;color:#111;font-size:12px;font-weight:800;line-height:1.2;white-space:normal}
.pfy-pay-option small{display:block;color:#4b5563;font-size:10.5px;line-height:1.25;white-space:normal}
.pfy-logo-visa{color:#1557b0;font-weight:900;font-size:18px;letter-spacing:-1px}
.pfy-logo-mc{color:#f04b23;font-size:18px;letter-spacing:-5px;margin-right:4px}
.pfy-logo-jcb{color:#0b9a62;font-weight:900;font-size:14px}
.pfy-logo-gcash{color:#1976d2;font-weight:900;font-size:16px}
.pfy-logo-maya{color:#20b26b;font-weight:900;font-size:18px;text-transform:lowercase}
.pfy-secure-note{display:flex;align-items:center;gap:8px;margin-top:13px;color:#4b5563;font-size:11px;line-height:1.35}
.pfy-secure-note i{color:#111827}
.pfy-summary{padding:24px 23px}
.pfy-summary-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
.pfy-summary-title{display:flex;align-items:center;gap:13px}
.pfy-summary-title i{font-size:20px}
.pfy-item-count{color:#111827;font-size:12px;font-weight:600}
.pfy-order-items{display:grid;gap:14px}
.pfy-order-item{display:grid;grid-template-columns:92px minmax(0,1fr) auto;gap:20px;align-items:start}
.pfy-order-img{width:92px;height:92px;border-radius:8px;border:1px solid #eef0f4;background:#f4f4f4;object-fit:cover}
.pfy-order-placeholder{width:92px;height:92px;border-radius:8px;border:1px solid #eef0f4;background:linear-gradient(135deg,#f7f7f7,#ececec);display:grid;place-items:center;color:var(--pf-orange);font-size:42px}
.pfy-order-info h4{margin:10px 0 7px;color:#111;font-size:15px;line-height:1.25;font-weight:900}
.pfy-order-info p{margin:3px 0;color:#374151;font-size:11.5px;line-height:1.35}
.pfy-order-price{padding-top:13px;text-align:right;color:#111;font-size:14px;font-weight:900;white-space:nowrap}
.pfy-summary-line{height:1px;background:#edf0f4;margin:18px 0 16px}
.pfy-promo{display:grid;grid-template-columns:minmax(0,1fr) 110px;gap:14px;margin:0 0 18px;padding:0;background:transparent;border:0;box-shadow:none}
.pfy-promo input{height:45px;border:1px solid var(--pf-line);border-radius:10px;background:#fff;outline:0;padding:0 14px;color:#111827;font-size:12px}
.pfy-promo button{height:45px;border:0;border-radius:999px;background:var(--pf-gradient);color:#fff;font-size:13px;font-weight:800;box-shadow:none}
.pfy-promo button:hover,.pfy-place-order:hover{background:#111827;color:#fff;transform:none}
.pfy-total-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:11px;color:#111;font-size:12px;line-height:1.25}
.pfy-total-row span{font-weight:500}.pfy-total-row strong{font-weight:900}.pfy-total-row.discount strong{color:var(--pf-green)}
.pfy-grand-total{display:flex;align-items:center;justify-content:space-between;margin:18px 0 0;padding-top:18px;border-top:1px solid #edf0f4;background:transparent;border-radius:0}
.pfy-grand-total span{font-size:15px;font-weight:900;color:#111}.pfy-grand-total strong{font-size:24px;font-weight:900;color:var(--pf-orange)}
.pfy-reward,.pfy-terms{display:none}
.pfy-place-order{width:305px;max-width:100%;height:52px;margin:18px auto 0;border:0;border-radius:999px;background:var(--pf-gradient);color:#fff;font-size:15px;font-weight:900;display:flex;align-items:center;justify-content:center;gap:10px;box-shadow:none}
.pfy-place-order:disabled{background:#cfcfcf;color:#fff;cursor:not-allowed}
.pfy-secure-card{margin-top:18px;padding:26px 23px;border-radius:14px}
.pfy-secure-wrap{display:grid;grid-template-columns:32px minmax(0,1fr);gap:13px;align-items:start}
.pfy-secure-icon{font-size:24px;color:var(--pf-orange)}
.pfy-payment-logos{display:flex;align-items:center;justify-content:space-between;gap:14px;margin-top:26px;font-weight:900}
.pfy-payment-logos .visa{color:#1557b0;font-size:23px;letter-spacing:-1px}.pfy-payment-logos .mc{color:#f04b23;font-size:24px;letter-spacing:-6px}.pfy-payment-logos .jcb{color:#0b9a62;font-size:19px}.pfy-payment-logos .gcash{color:#1976d2;font-size:20px}.pfy-payment-logos .maya{color:#20b26b;font-size:21px;text-transform:lowercase}
.pfy-empty{display:none;background:#fff;border:1px dashed #ffd0b8;border-radius:12px;padding:28px 20px;text-align:center;color:#555}.pfy-empty i{font-size:38px;color:var(--pf-orange);margin-bottom:10px}.pfy-empty h2{margin:0 0 8px;color:#111;font-size:20px}.pfy-empty p{margin:0 0 16px;font-size:13px}.pfy-empty a{display:inline-flex;align-items:center;justify-content:center;height:42px;padding:0 18px;border-radius:999px;background:var(--pf-gradient);color:#fff;font-size:12px;font-weight:900}
.pfy-toast{position:fixed;left:50%;top:104px;z-index:3000;width:min(520px,calc(100% - 32px));padding:14px 18px;border-radius:14px;background:#111827;color:#fff;font-size:12.5px;line-height:1.45;box-shadow:0 22px 60px rgba(0,0,0,.22);transform:translate(-50%,-18px) scale(.98);opacity:0;pointer-events:none;transition:.22s ease;text-align:center;font-weight:700}.pfy-toast.show{transform:translate(-50%,0) scale(1);opacity:1}.pfy-toast.is-success{background:#0f5132}.pfy-toast.is-error{background:#7f1d1d}
.pfy-success{display:none;padding:28px;margin-bottom:20px}.pfy-success.show{display:block}.pfy-success h2{margin:0 0 8px;color:#111;font-size:22px}.pfy-success p{margin:0 0 16px;color:#666;font-size:13px}.pfy-success strong{color:var(--pf-green)}.pfy-success-actions{display:flex;gap:10px;flex-wrap:wrap}.pfy-success-actions a,.pfy-success-actions button{height:42px;padding:0 18px;border:0;border-radius:999px;background:var(--pf-gradient);color:#fff;font-size:12px;font-weight:900;display:inline-flex;align-items:center}
@media(max-width:1500px){.pfy-page{width:calc(100% - 80px)}.pfy-main-grid{grid-template-columns:minmax(390px,1fr) minmax(410px,1fr) minmax(340px,400px);gap:22px}.pfy-stepper{width:min(720px,100%);grid-template-columns:auto 130px auto 130px auto 130px auto}.pfy-step:after{width:130px}}
@media(max-width:1180px){.pfy-page{width:calc(100% - 32px)}.pfy-main-grid{grid-template-columns:1fr;grid-template-areas:"steps" "customer" "delivery" "summary"}.pfy-stepper{width:100%;grid-template-columns:repeat(4,1fr);gap:10px}.pfy-step:after{display:none}}
@media(max-width:760px){#checkout{padding-top:20px}.pfy-page{width:calc(100% - 22px)}.pfy-page-head h1{font-size:31px}.pfy-stepper{grid-template-columns:1fr 1fr}.pfy-field-grid,.pfy-field-grid.two,.pfy-field-grid.four,.pfy-payment-grid{grid-template-columns:1fr}.pfy-card-head{flex-direction:column}.pfy-order-item{grid-template-columns:64px 1fr}.pfy-order-price{grid-column:2;text-align:left;padding-top:0}.pfy-order-img,.pfy-order-placeholder{width:64px;height:64px}.pfy-promo{grid-template-columns:1fr}.pfy-promo button{width:100%}.pfy-place-order{width:100%}}
</style>

<style id="checkout-section-spacing-compact-final">
#checkout{
  padding-top:26px!important;
  padding-bottom:48px!important;
}
#checkout .pfy-page{
  width:min(1520px,calc(100% - 112px))!important;
  max-width:1520px!important;
  margin:0 auto!important;
}
#checkout .pfy-page-head{
  margin-bottom:18px!important;
}
@media(max-width:1260px){
  #checkout{
    padding-top:24px!important;
    padding-bottom:44px!important;
  }
  #checkout .pfy-page{
    width:calc(100% - 44px)!important;
  }
}
@media(max-width:760px){
  #checkout{
    padding-top:22px!important;
    padding-bottom:38px!important;
  }
  #checkout .pfy-page{
    width:calc(100% - 28px)!important;
  }
}
</style>

<style id="checkout-reference-layout-last-lock">
#checkout .pfy-main-grid{
  grid-template-columns:minmax(420px,1.05fr) minmax(430px,1fr) minmax(380px,.98fr)!important;
  grid-template-areas:"steps steps steps" "customer summary delivery"!important;
  gap:22px 24px!important;
}
#checkout .pfy-sidebar{grid-area:summary!important;display:flex!important;flex-direction:column!important;gap:14px!important;position:static!important}
#checkout .pfy-delivery-payment{grid-area:delivery!important}
#checkout .pfy-customer-shipping{grid-area:customer!important}
#checkout .pfy-stepper{grid-area:steps!important;width:min(640px,100%)!important;margin:-70px auto 4px!important}
#checkout .pfy-delivery-payment .pfy-card-notes,
#checkout .pfy-delivery-payment .pfy-card-payment{display:none!important}
#checkout .pfy-sidebar>.pfy-card-payment{display:block!important;border:1px solid #e4e8ef!important;border-radius:12px!important;background:#fff!important;box-shadow:0 10px 28px rgba(17,24,39,.035)!important}
#checkout .pfy-secure-card{display:none!important}
#checkout .pfy-delivery-option{min-height:78px!important;padding:16px!important;border-radius:8px!important}
#checkout .pfy-delivery-option.is-selected{border-color:#ff4f16!important;background:#fff9f5!important}
#checkout .pfy-summary .pfy-card-notes{display:block!important;margin:0 0 10px!important;border:0!important;background:transparent!important}
#checkout .pfy-summary .pfy-card-notes .pfy-card-head{padding:0 0 7px!important}
#checkout .pfy-summary .pfy-card-notes .pfy-card-body{padding:0!important}
#checkout .pfy-summary .pfy-card-notes .pfy-card-title p{display:none!important}
#checkout .pfy-receipt-row{display:flex!important}
@media(max-width:1260px){
  #checkout .pfy-main-grid{grid-template-columns:1fr!important;grid-template-areas:"steps" "customer" "summary" "delivery"!important}
  #checkout .pfy-stepper{margin:0 auto!important}
}
@media(max-width:720px){
  #checkout .pfy-main-grid{grid-template-areas:"steps" "customer" "summary" "delivery"!important}
}
</style>

<script id="checkout-reference-layout-script">
(function(){
  var layoutArranged=false;
  function arrangeCheckoutReference(){
    if(layoutArranged)return;
    var sidebar=document.querySelector('#checkout .pfy-sidebar');
    var summary=document.querySelector('#checkout .pfy-summary');
    var notes=document.querySelector('#checkout .pfy-card-notes');
    var payment=document.querySelector('#checkout .pfy-card-payment');
    var promo=document.querySelector('#checkout .pfy-promo');
    if(!sidebar||!summary||!notes||!payment||!promo)return;
    if(summary&&notes&&promo&&!summary.contains(notes)){
      promo.insertAdjacentElement('afterend',notes);
    }
    if(sidebar&&summary&&payment&&payment.parentElement!==sidebar){
      summary.insertAdjacentElement('afterend',payment);
    }
    var receipt=document.getElementById('pfyReceiptRow');
    if(summary&&!receipt){
      receipt=document.createElement('button');
      receipt.type='button';
      receipt.id='pfyReceiptRow';
      receipt.className='pfy-receipt-row';
      receipt.innerHTML='<span><i class="fa-regular fa-file-lines"></i><b>E-Receipt</b><small>Get e-receipt via email after order completion.</small></span><i class="fa-solid fa-chevron-right"></i>';
      var notesCard=summary.querySelector('.pfy-card-notes');
      if(notesCard) notesCard.insertAdjacentElement('afterend',receipt);
      receipt.setAttribute('aria-haspopup','dialog');
      receipt.setAttribute('aria-controls','pfyEReceiptModal');
      receipt.addEventListener('click',function(){
        if(typeof window.openEReceiptModal==='function') window.openEReceiptModal();
      });
    }
    layoutArranged=true;
  }
  document.addEventListener('printify:checkout-opened',arrangeCheckoutReference,{once:true});
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',arrangeCheckoutReference,{once:true});
  else arrangeCheckoutReference();
})();
</script>

<style id="checkout-reference-layout-final">
#checkout{
  padding:28px 0 46px!important;
  background:#fff!important;
}
#checkout .pfy-page{
  width:min(1520px,calc(100% - 108px))!important;
  max-width:1520px!important;
  padding:0 0 30px!important;
}
#checkout .pfy-breadcrumb{
  margin:0 0 18px!important;
  gap:10px!important;
  color:#536070!important;
  font-size:12px!important;
  font-weight:600!important;
}
#checkout .pfy-page-head{
  margin:0 0 22px!important;
}
#checkout .pfy-page-head h1{
  font-family:var(--pf-body)!important;
  font-size:28px!important;
  line-height:1.05!important;
  font-weight:900!important;
  letter-spacing:0!important;
}
#checkout .pfy-page-head p{
  margin-top:8px!important;
  font-size:14px!important;
  color:#485366!important;
}
#checkout .pfy-main-grid{
  display:grid!important;
  grid-template-columns:minmax(420px,1.05fr) minmax(430px,1fr) minmax(380px,.98fr)!important;
  grid-template-areas:
    "steps steps steps"
    "customer summary delivery"!important;
  gap:22px 24px!important;
  align-items:start!important;
  justify-content:center!important;
}
#checkout .pfy-left{display:contents!important}
#checkout .pfy-customer-shipping{grid-area:customer!important;width:100%!important}
#checkout .pfy-sidebar{grid-area:summary!important;width:100%!important;display:flex!important;flex-direction:column!important;gap:14px!important}
#checkout .pfy-delivery-payment{grid-area:delivery!important;width:100%!important}
#checkout .pfy-delivery-payment .pfy-card-notes,
#checkout .pfy-delivery-payment .pfy-card-payment{display:none!important}
#checkout .pfy-secure-card{display:none!important}
#checkout .pfy-stepper{
  grid-area:steps!important;
  width:min(640px,100%)!important;
  grid-template-columns:repeat(4,minmax(80px,1fr))!important;
  justify-self:center!important;
  gap:28px!important;
  margin:-70px auto 4px!important;
}
#checkout .pfy-step{gap:8px!important}
#checkout .pfy-step:after{
  top:18px!important;
  left:calc(50% + 44px)!important;
  width:84px!important;
  border-top:2px solid #d7dde7!important;
}
#checkout .pfy-step-no{
  width:36px!important;
  height:36px!important;
  border-radius:50%!important;
  font-size:13px!important;
  font-weight:900!important;
}
#checkout .pfy-step-copy strong{
  font-size:13px!important;
  line-height:1!important;
  font-weight:900!important;
}
#checkout .pfy-form-group,
#checkout .pfy-summary,
#checkout .pfy-sidebar>.pfy-card-payment{
  border:1px solid #e4e8ef!important;
  border-radius:12px!important;
  background:#fff!important;
  box-shadow:0 10px 28px rgba(17,24,39,.035)!important;
  overflow:hidden!important;
}
#checkout .pfy-form-group .pfy-card,
#checkout .pfy-sidebar>.pfy-card-payment{
  border:0!important;
  background:transparent!important;
  box-shadow:none!important;
}
#checkout .pfy-form-group .pfy-card + .pfy-card{
  border-top:1px solid #edf0f4!important;
}
#checkout .pfy-card-head{
  padding:24px 20px 10px!important;
}
#checkout .pfy-card-body{
  padding:14px 20px 24px!important;
}
#checkout .pfy-card-title{
  gap:12px!important;
}
#checkout .pfy-card-icon,
#checkout .pfy-summary-title i{
  width:26px!important;
  height:26px!important;
  min-width:26px!important;
  color:#ff4f16!important;
  font-size:21px!important;
}
#checkout .pfy-card-title h2,
#checkout .pfy-summary h3{
  font-size:16px!important;
  font-weight:900!important;
  line-height:1.2!important;
}
#checkout .pfy-card-title p{
  margin-top:6px!important;
  font-size:12px!important;
  line-height:1.35!important;
  color:#4b5563!important;
}
#checkout .pfy-customer-shipping .pfy-field-grid,
#checkout .pfy-customer-shipping .pfy-field-grid.two,
#checkout .pfy-customer-shipping .pfy-field-grid.four{
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
  gap:16px!important;
}
#checkout .pfy-customer-shipping .pfy-field:has(#street){grid-column:1/-1!important}
#checkout .pfy-customer-shipping .pfy-field:has(#apartment){grid-column:auto!important}
#checkout .pfy-field input,
#checkout .pfy-field select{
  height:48px!important;
  border:1px solid #dfe4ec!important;
  border-radius:8px!important;
  padding:0 14px!important;
  font-size:12.5px!important;
  font-weight:600!important;
}
#checkout .pfy-field label{display:none!important}
#checkout .pfy-section-control{
  align-self:center!important;
  margin:0!important;
  font-size:12px!important;
}
#checkout .pfy-summary{
  padding:16px 16px 15px!important;
}
#checkout .pfy-summary-head{
  margin-bottom:14px!important;
}
#checkout .pfy-order-item{
  grid-template-columns:58px minmax(0,1fr) auto!important;
  gap:13px!important;
  align-items:start!important;
}
#checkout .pfy-order-img,
#checkout .pfy-order-placeholder{
  width:58px!important;
  height:58px!important;
  border-radius:8px!important;
}
#checkout .pfy-order-placeholder{font-size:28px!important}
#checkout .pfy-order-info h4{
  margin:0 0 4px!important;
  font-size:13px!important;
  line-height:1.2!important;
  font-weight:900!important;
}
#checkout .pfy-order-info p{
  margin:1px 0!important;
  font-size:11px!important;
  line-height:1.25!important;
}
#checkout .pfy-order-price{
  padding-top:2px!important;
  font-size:12px!important;
}
#checkout .pfy-summary-line{
  margin:13px 0 11px!important;
}
#checkout .pfy-promo{
  grid-template-columns:minmax(0,1fr) 80px!important;
  gap:10px!important;
  margin-bottom:12px!important;
}
#checkout .pfy-promo input{
  height:36px!important;
  border-radius:9px!important;
  font-size:11.5px!important;
}
#checkout .pfy-promo button{
  height:36px!important;
  border-radius:999px!important;
}
#checkout .pfy-summary .pfy-card-notes{
  margin:0 0 10px!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
}
#checkout .pfy-summary .pfy-card-notes .pfy-card-head{
  padding:0 0 7px!important;
}
#checkout .pfy-summary .pfy-card-notes .pfy-card-title{
  gap:7px!important;
}
#checkout .pfy-summary .pfy-card-notes .pfy-card-title p{display:none!important}
#checkout .pfy-summary .pfy-card-notes .pfy-card-body{
  padding:0!important;
}
#checkout #notes{
  height:44px!important;
  min-height:44px!important;
  border-radius:9px!important;
  padding:11px 14px!important;
  font-size:11.5px!important;
}
#checkout .pfy-note-box small{
  right:12px!important;
  bottom:7px!important;
}
#checkout .pfy-receipt-row{
  width:100%!important;
  height:36px!important;
  margin:0 0 12px!important;
  padding:0 12px!important;
  border:1px solid #e4e8ef!important;
  border-radius:999px!important;
  background:#fff!important;
  color:#111827!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  text-align:left!important;
}
#checkout .pfy-receipt-row span{
  display:flex!important;
  align-items:center!important;
  gap:8px!important;
}
#checkout .pfy-receipt-row b{
  font-size:11.5px!important;
  font-weight:900!important;
}
#checkout .pfy-receipt-row small{
  font-size:9.5px!important;
  color:#6b7280!important;
}
#checkout .pfy-total-row{
  margin-bottom:6px!important;
  font-size:11.5px!important;
}
#checkout .pfy-grand-total{
  margin:10px 0 0!important;
  padding-top:10px!important;
}
#checkout .pfy-grand-total strong{
  font-size:19px!important;
  color:#ff4f16!important;
}
#checkout .pfy-place-order{
  width:100%!important;
  height:38px!important;
  margin-top:10px!important;
  border-radius:7px!important;
  font-size:13px!important;
}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-head{
  padding:16px 18px 6px!important;
}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-body{
  padding:10px 18px 16px!important;
}
#checkout .pfy-payment-grid{
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
  gap:10px!important;
}
#checkout .pfy-pay-option{
  min-height:50px!important;
  grid-template-columns:16px 52px minmax(0,1fr)!important;
  gap:9px!important;
  padding:9px 11px!important;
  border-radius:8px!important;
}
#checkout .pfy-delivery-payment{
  border:1px solid #e4e8ef!important;
  border-radius:12px!important;
  background:#fff!important;
  box-shadow:0 10px 28px rgba(17,24,39,.035)!important;
  overflow:hidden!important;
}
#checkout .pfy-delivery-payment>.pfy-card-delivery{
  border:0!important;
}
#checkout .pfy-radio-stack{
  gap:14px!important;
}
#checkout .pfy-delivery-option{
  min-height:78px!important;
  grid-template-columns:20px minmax(0,1fr) auto!important;
  gap:14px!important;
  padding:16px!important;
  border:1px solid #e4e8ef!important;
  border-radius:8px!important;
  background:#fff!important;
}
#checkout .pfy-delivery-option.is-selected{
  border-color:#ff4f16!important;
  background:#fff9f5!important;
}
#checkout .pfy-delivery-option input{
  accent-color:#ff4f16!important;
}
#checkout .pfy-delivery-copy strong{
  font-size:13px!important;
  font-weight:900!important;
}
#checkout .pfy-delivery-copy strong em{
  margin-left:8px!important;
  background:#f0f2f5!important;
  color:#111827!important;
  font-size:10px!important;
}
#checkout .pfy-delivery-copy small{
  margin-top:6px!important;
  font-size:11.5px!important;
  line-height:1.35!important;
}
#checkout .pfy-delivery-price{
  font-size:12.5px!important;
  font-weight:900!important;
}
@media(max-width:1260px){
  #checkout .pfy-page{width:calc(100% - 36px)!important}
  #checkout .pfy-main-grid{
    grid-template-columns:1fr!important;
    grid-template-areas:"steps" "customer" "summary" "delivery"!important;
  }
  #checkout .pfy-stepper{margin:0 auto!important}
}
@media(max-width:720px){
  #checkout .pfy-page{width:calc(100% - 22px)!important}
  #checkout .pfy-customer-shipping .pfy-field-grid,
  #checkout .pfy-customer-shipping .pfy-field-grid.two,
  #checkout .pfy-customer-shipping .pfy-field-grid.four,
  #checkout .pfy-payment-grid{grid-template-columns:1fr!important}
}
</style>

<section id="checkout" class="section checkout-section" data-section-id="checkout" data-page="checkout" data-location-source="data/ph-locations.json">
<main class="pfy-page">
  <div class="pfy-breadcrumb">
    <a href="{{ route('home') }}">Home</a><i class="fa-solid fa-chevron-right"></i>
    <a href="{{ route('services.index') }}">Services</a>
    <span id="checkoutCategoryCrumbWrap" hidden><i class="fa-solid fa-chevron-right"></i><span id="checkoutCategoryCrumb">Selected Service</span></span>
    <span id="checkoutServiceCrumbWrap" hidden><i class="fa-solid fa-chevron-right"></i><span id="checkoutServiceCrumb">Service Option</span></span>
    <i class="fa-solid fa-chevron-right"></i><strong>Checkout</strong>
  </div>

  <div class="pfy-page-head">
    <h1>Checkout</h1>
    <p>Complete your order in a few simple steps.</p>
  </div>

  <section class="pfy-success" id="successBox" aria-live="polite">
    <h2><i class="fa-solid fa-circle-check" style="color:#16a34a"></i> Payment successful!</h2>
    <p>Your order reference is <strong id="successRef">PFY-ORDER</strong>. Your payment was completed and your order is confirmed.</p>
    <div class="pfy-success-actions">
      <a href="{{ route('services.index') }}">Back to Services</a>
      <button type="button" onclick="window.print()">Print Confirmation</button>
    </div>
  </section>

  <div class="pfy-main-grid" id="checkoutGrid">
    <section class="pfy-left">
      <div class="pfy-stepper" aria-label="Checkout progress">
        <div class="pfy-step is-active" data-step="1"><span class="pfy-step-no">1</span><span class="pfy-step-copy"><strong>Customer Info</strong><small>Complete your details</small></span></div>
        <i class="pfy-step-line" aria-hidden="true"></i>
        <div class="pfy-step" data-step="2"><span class="pfy-step-no">2</span><span class="pfy-step-copy"><strong>Order Summary</strong><small>Review order details</small></span></div>
        <i class="pfy-step-line" aria-hidden="true"></i>
        <div class="pfy-step" data-step="3"><span class="pfy-step-no">3</span><span class="pfy-step-copy"><strong>Payment</strong><small>Secure payment</small></span></div>
        <i class="pfy-step-line" aria-hidden="true"></i>
        <div class="pfy-step" data-step="4"><span class="pfy-step-no">4</span><span class="pfy-step-copy"><strong>Delivery</strong><small>Select delivery method</small></span></div>
      </div>

      <div class="pfy-form-group pfy-customer-shipping">
        <section class="pfy-card pfy-card-customer">
          <div class="pfy-card-head">
            <div class="pfy-card-title"><span class="pfy-card-icon"><i class="fa-solid fa-user"></i></span><div><h2>Customer Information</h2><p>We'll use this information to contact you about your order.</p></div></div>
          </div>
          <div class="pfy-card-body">
            <input type="hidden" id="fullName" value="{{ old('fullName', Auth::check() ? Auth::user()->name : '') }}">
            <div class="pfy-field-grid">
              <div class="pfy-field"><label for="firstName">First Name</label><input type="text" id="firstName" placeholder="First Name" value="{{ old('firstName', Auth::check() ? Auth::user()->first_name : '') }}" autocomplete="given-name" required></div>
              <div class="pfy-field"><label for="lastName">Last Name</label><input type="text" id="lastName" placeholder="Last Name" value="{{ old('lastName', Auth::check() ? Auth::user()->last_name : '') }}" autocomplete="family-name" required></div>
              <div class="pfy-field"><label for="email">Email Address</label><input type="email" id="email" placeholder="Email Address" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" autocomplete="email" required></div>
              <div class="pfy-field"><label for="phone">Phone Number</label><input type="tel" id="phone" placeholder="Phone Number" value="{{ old('phone', Auth::check() ? \App\Services\PhilippinePhoneNumber::normalize(Auth::user()->phone) : '') }}" autocomplete="tel" required></div>
            </div>
          </div>
        </section>

        <section class="pfy-card pfy-card-shipping">
          <div class="pfy-card-head">
            <div class="pfy-card-title"><span class="pfy-card-icon"><i class="fa-solid fa-location-dot"></i></span><div><h2>Shipping Address</h2><p>Where should we deliver your order?</p></div></div>
          </div>
          <div class="pfy-card-body">
            <div class="pfy-address-book" id="pfyShippingAddressBook">
              <button class="pfy-address-add" type="button" id="pfyAddressAddBtn" aria-haspopup="dialog" aria-controls="pfyAddressBookModal"><span><i class="fa-solid fa-plus"></i><b>Add address</b></span><i class="fa-solid fa-chevron-right"></i></button>
              <div class="pfy-address-list" id="pfyAddressBookList" aria-live="polite"></div>
              <p class="pfy-address-book-hint">Choose a saved address or edit the fields below. Shipping address stays editable even after successful payment.</p>
            </div>
            <div class="pfy-address-book-modal" id="pfyAddressBookModal" role="dialog" aria-modal="true" aria-labelledby="pfyAddressBookModalTitle" hidden>
              <form class="pfy-address-book-dialog" id="pfyAddressBookForm" novalidate>
                <header class="pfy-address-book-modal-head">
                  <h3 id="pfyAddressBookModalTitle">Add address</h3>
                  <button type="button" class="pfy-address-book-close" id="pfyAddressBookClose" aria-label="Close address editor"><i class="fa-solid fa-xmark"></i></button>
                </header>
                <div class="pfy-address-book-modal-body">
                  <input type="hidden" id="pfyAddressBookId">
                  <div class="pfy-address-book-field full"><label for="pfyAddressBookName">Full Name</label><input type="text" id="pfyAddressBookName" placeholder="Full Name" required></div>
                  <div class="pfy-address-book-field full"><label for="pfyAddressBookPhone">Phone Number</label><input type="tel" id="pfyAddressBookPhone" placeholder="Phone Number"></div>
                  <div class="pfy-address-book-field full"><label for="pfyAddressBookStreet">Street Address</label><input type="text" id="pfyAddressBookStreet" placeholder="Street Address" required></div>
                  <div class="pfy-address-book-field full"><label for="pfyAddressBookApartment">Apartment, suite, etc. (optional)</label><input type="text" id="pfyAddressBookApartment" placeholder="Apartment, suite, etc. (optional)"></div>
                  <div class="pfy-address-book-field"><label for="pfyAddressBookProvince">State / Province</label><input type="text" id="pfyAddressBookProvince" placeholder="State / Province" required></div>
                  <div class="pfy-address-book-field"><label for="pfyAddressBookCity">City / Town</label><input type="text" id="pfyAddressBookCity" placeholder="City / Town" required></div>
                  <div class="pfy-address-book-field"><label for="pfyAddressBookBarangay">Barangay</label><input type="text" id="pfyAddressBookBarangay" placeholder="Barangay" required></div>
                  <div class="pfy-address-book-field"><label for="pfyAddressBookPostal">Postal Code</label><input type="text" id="pfyAddressBookPostal" placeholder="Postal Code"></div>
                  <div class="pfy-address-book-field full"><label for="pfyAddressBookCountry">Country</label><input type="text" id="pfyAddressBookCountry" placeholder="Country" value="Philippines" required></div>
                  <label class="pfy-address-book-default"><span>Set as default shipping address</span><input type="checkbox" id="pfyAddressBookDefault"></label>
                </div>
                <footer class="pfy-address-book-modal-actions">
                  <button type="button" class="pfy-address-book-delete" id="pfyAddressBookDelete" hidden>Delete</button>
                  <span></span>
                  <button type="button" class="pfy-address-book-cancel" id="pfyAddressBookCancel">Cancel</button>
                  <button type="submit" class="pfy-address-book-save">Save address</button>
                </footer>
              </form>
            </div>
            <div class="pfy-field-grid two pfy-apartment-barangay-row">
              <div class="pfy-field full"><label for="street">Street Address</label><input type="text" id="street" placeholder="Street Address" value="{{ old('street', '') }}" autocomplete="street-address" required></div>
              <div class="pfy-field pfy-field-apartment"><label for="apartment">Apartment, suite, etc. (optional)</label><input type="text" id="apartment" placeholder="Apartment, suite, etc. (optional)" value="{{ old('apartment', '') }}"></div>
              <div class="pfy-field pfy-field-barangay"><label for="barangay">Barangay</label><select id="barangay" data-current="{{ old('barangay', '') }}" required disabled><option value="">Select barangay</option></select></div>
            </div>
            <div class="pfy-field-grid four">
              <div class="pfy-field"><label for="province">State / Province</label><select id="province" data-current="{{ old('province', '') }}" required><option value="">Select state / province</option></select></div>
              <div class="pfy-field"><label for="city">City / Town</label><select id="city" data-current="{{ old('city', '') }}" required disabled><option value="">Select city / town</option></select></div>
              <div class="pfy-field"><label for="postal">Postal Code</label><input type="text" id="postal" placeholder="Postal Code" value="{{ old('postal', '') }}" required></div>
              <div class="pfy-field"><label for="country">Country</label><select id="country"><option value="Philippines" selected>Philippines</option></select></div>
            </div>
          </div>
        </section>
      </div>

      <div class="pfy-form-group pfy-delivery-payment">
        <section class="pfy-card pfy-card-delivery">
          <div class="pfy-card-head">
            <div class="pfy-card-title"><span class="pfy-card-icon"><i class="fa-solid fa-truck"></i></span><div><h2>Delivery Method</h2><p>Choose how you would like to receive your order.</p></div></div>
          </div>
          <div class="pfy-card-body">
            <div class="pfy-radio-stack">
              <label class="pfy-delivery-option" data-radio-wrap><input type="radio" name="shipping" value="standard" data-cost="150"><span class="pfy-delivery-copy"><strong>Standard Delivery <em>3–5 business days</em></strong><small>Reliable delivery to your doorstep.</small></span><span class="pfy-delivery-price">₱150.00</span></label>
              <label class="pfy-delivery-option" data-radio-wrap><input type="radio" name="shipping" value="express" data-cost="350"><span class="pfy-delivery-copy"><strong>Express Delivery <em>1–2 business days</em></strong><small>Faster delivery for urgent orders.</small></span><span class="pfy-delivery-price">₱350.00</span></label>
              <label class="pfy-delivery-option" data-radio-wrap><input type="radio" name="shipping" value="lalamove" data-cost="284"><span class="pfy-delivery-copy"><strong>Lalamove On-demand <em>Live price</em></strong><small>Use your exact drop-off location and track the driver after checkout.</small></span><span class="pfy-delivery-price">From &#8369;284.00</span></label>
              <label class="pfy-delivery-option" data-radio-wrap><input type="radio" name="shipping" value="pickup" data-cost="0"><span class="pfy-delivery-copy"><strong>Store Pick-up <em>No delivery fee</em></strong><small>Pick up your completed order at our store.</small></span><span class="pfy-delivery-price">FREE</span></label>
            </div>
          </div>
        </section>

        <section class="pfy-card pfy-card-notes">
          <div class="pfy-card-head">
            <div class="pfy-card-title"><span class="pfy-card-icon"><i class="fa-regular fa-clipboard"></i></span><div><h2>Order Notes (Optional)</h2><p>Add any special instructions or notes for your order.</p></div></div>
          </div>
          <div class="pfy-card-body">
            <div class="pfy-note-box"><textarea id="notes" maxlength="250" placeholder="E.g., Please handle with care, deliver during office hours, etc."></textarea><small id="noteCount">0/250</small></div>
          </div>
        </section>

        <section class="pfy-card pfy-card-payment">
          <div class="pfy-card-head">
            <div class="pfy-card-title"><span class="pfy-card-icon"><i class="fa-regular fa-credit-card"></i></span><div><h2>Payment Method</h2><p>Secure online payments only.</p></div></div>
          </div>
          <div class="pfy-card-body">
            <div class="pfy-payment-grid">
              <label class="pfy-pay-option" data-radio-wrap><input type="radio" name="payment" value="card"><span class="pfy-card-logos"><b class="pfy-logo-visa">VISA</b><b class="pfy-logo-mc">●●</b><b class="pfy-logo-jcb">JCB</b></span><span><strong>Credit / Debit Card</strong><small>Visa, Mastercard, JCB</small></span></label>
              <label class="pfy-pay-option" data-radio-wrap><input type="radio" name="payment" value="gcash"><span class="pfy-card-logos"><b class="pfy-logo-gcash">GCash</b></span><span><strong>GCash</strong><small>Pay using GCash</small></span></label>
              <label class="pfy-pay-option" data-radio-wrap><input type="radio" name="payment" value="maya"><span class="pfy-card-logos"><b class="pfy-logo-maya">maya</b></span><span><strong>Maya</strong><small>Pay using Maya</small></span></label>
              <label class="pfy-pay-option" data-radio-wrap><input type="radio" name="payment" value="bank"><span class="pfy-card-logos"><i class="fa-solid fa-building-columns"></i></span><span><strong>Bank Transfer</strong><small>Direct bank transfer</small></span></label>
            </div>
            <div class="pfy-secure-note"><i class="fa-solid fa-lock"></i>Your payment information is secure and will never be stored.</div>
          </div>
        </section>
      </div>
    </section>

    <aside class="pfy-sidebar">
      <section class="pfy-summary">
        <div class="pfy-summary-head"><div class="pfy-summary-title"><i class="fa-regular fa-rectangle-list"></i><h3>Order Summary</h3><small id="checkoutStageStatus">Complete customer info</small></div><span class="pfy-item-count" id="summaryItemCount">0 Items</span></div>
        <div id="emptyState" class="pfy-empty"><i class="fa-solid fa-cart-shopping"></i><h2>Your checkout is empty</h2><p>Please go back to Services and choose a printing service first.</p><a href="/services" onclick="jumpTo('products');return false;">Back to Services</a></div>
        <div id="orderContent">
          <div class="pfy-order-items" id="orderItems"></div>
          <div class="pfy-summary-line"></div>
          <div class="pfy-promo"><input type="text" id="promoCode" placeholder="Enter promo code"><button type="button" onclick="applyPromo()">Apply</button></div>
          <div class="pfy-total-row"><span>Subtotal</span><strong id="subtotal">₱0.00</strong></div>
          <div class="pfy-total-row discount"><span>Discount</span><strong id="discount">-₱0.00</strong></div>
          <div class="pfy-total-row"><span id="shippingLabel">Shipping (Store Pick-up)</span><strong id="shippingCost">₱0.00</strong></div>
          <div class="pfy-grand-total"><span>Total</span><strong id="total">₱0.00</strong></div>
          <button class="pfy-place-order" id="placeOrderBtn" type="button" onclick="placeOrder()" disabled>Complete Customer Info <i class="fa-solid fa-lock"></i></button>
        </div>
      </section>

      <section class="pfy-secure-card">
        <div class="pfy-secure-wrap"><span class="pfy-secure-icon"><i class="fa-solid fa-shield-halved"></i></span><div><h4>Safe &amp; Secure Checkout</h4><p>Your information and payment are protected with industry-standard encryption.</p></div></div>
        <div class="pfy-payment-logos"><span class="visa">VISA</span><span class="mc">●●</span><span class="jcb">JCB</span><span class="gcash">GCash</span><span class="maya">maya</span></div>
      </section>
    </aside>
  </div>
</main>
<div class="pfy-ereceipt-overlay" id="pfyEReceiptModal" role="dialog" aria-modal="true" aria-labelledby="pfyEReceiptTitle" hidden>
  <div class="pfy-ereceipt-dialog">
    <header class="pfy-ereceipt-head">
      <div class="pfy-ereceipt-title"><i class="fa-regular fa-file-lines"></i><h2 id="pfyEReceiptTitle">Request E-Invoice</h2></div>
      <button class="pfy-ereceipt-close" type="button" aria-label="Close e-receipt form"><i class="fa-solid fa-xmark"></i></button>
    </header>
    <form id="pfyEReceiptForm" novalidate>
      <div class="pfy-ereceipt-scroll">
        <div class="pfy-ereceipt-notice"><i class="fa-solid fa-circle-exclamation"></i><p><strong>Please ensure the information is accurate.</strong> Once the e-invoice is submitted, no modifications can be changed.</p></div>
        <fieldset class="pfy-ereceipt-types">
          <legend>Receipt Type</legend>
          <label><input type="radio" name="receipt_type" value="personal" checked><span>Personal</span></label>
          <label><input type="radio" name="receipt_type" value="business"><span>Business</span></label>
        </fieldset>
        <div class="pfy-ereceipt-field" id="pfyBusinessNameWrap" hidden><label for="pfyBusinessName">Business Name</label><input id="pfyBusinessName" name="business_name" type="text" autocomplete="organization" placeholder="Enter registered business name"></div>
        <div class="pfy-ereceipt-field"><label for="pfyReceiptName">Full Name</label><input id="pfyReceiptName" name="full_name" type="text" value="{{ Auth::check() ? Auth::user()->name : '' }}" autocomplete="name" placeholder="Enter" required></div>
        <div class="pfy-ereceipt-field"><label for="pfyReceiptTin">TIN</label><input id="pfyReceiptTin" name="tin" type="text" inputmode="numeric" placeholder="Enter"></div>
        <div class="pfy-ereceipt-section-label">Address Info</div>
        <div class="pfy-address-street-row">
          <input id="pfyReceiptStreet" name="street_address" type="text" value="{{ Auth::check() ? Auth::user()->street : '' }}" autocomplete="street-address" placeholder="Street Address" required>
          <button class="pfy-address-toggle" type="button" aria-expanded="true" aria-label="Toggle address details" aria-controls="pfyReceiptAddressFields"><i class="fa-solid fa-chevron-up"></i></button>
        </div>
        <div class="pfy-address-grid" id="pfyReceiptAddressFields">
          <div class="pfy-ereceipt-field"><label for="pfyReceiptRegion">Region</label><select id="pfyReceiptRegion" name="region" data-current="{{ Auth::check() ? Auth::user()->region : '' }}" required><option value="">Enter region</option></select></div>
          <div class="pfy-ereceipt-field"><label for="pfyReceiptProvince">Province</label><select id="pfyReceiptProvince" name="province" data-current="{{ Auth::check() ? Auth::user()->province : '' }}" required disabled><option value="">Enter province</option></select></div>
          <div class="pfy-ereceipt-field"><label for="pfyReceiptCity">City</label><select id="pfyReceiptCity" name="city" data-current="{{ Auth::check() ? Auth::user()->city : '' }}" required disabled><option value="">Enter city</option></select></div>
          <div class="pfy-ereceipt-field"><label for="pfyReceiptBarangay">Barangay</label><select id="pfyReceiptBarangay" name="barangay" data-current="{{ Auth::check() ? Auth::user()->barangay : '' }}" required disabled><option value="">Enter barangay</option></select></div>
        </div>
        <div class="pfy-ereceipt-field"><label for="pfyReceiptPostal">Postal Code</label><input id="pfyReceiptPostal" name="postal_code" type="text" value="{{ Auth::check() ? Auth::user()->postal_code : '' }}" inputmode="numeric" placeholder="Enter" required></div>
        <label class="pfy-default-toggle"><span>Set as default <b id="pfyReceiptDefaultType">Personal</b> Billing Information</span><input type="checkbox" name="is_default" value="1"><i></i></label>
        <div class="pfy-ereceipt-disclaimer">
          <h3>Disclaimer</h3>
          <ul>
            <li>I confirm that the details for this invoice are complete and accurate.</li>
            <li>My personal information will be used to issue the invoice. For details, please review the Privacy Policy.</li>
            <li>When requesting an e-invoice, a valid email address is required. The invoice will be sent after order completion and successful payment.</li>
          </ul>
          <label class="pfy-consent"><input type="checkbox" name="consent" value="1" required><span>I accept the <a href="javascript:void(0)" onclick="closeEReceiptModal();footerCareAction('terms',this)">Terms of Service</a> and <a href="javascript:void(0)" onclick="closeEReceiptModal();footerCareAction('privacy',this)">Privacy Policy</a>.</span></label>
        </div>
        <section class="pfy-receipt-upload" id="pfyReceiptUploadWrap" @unless(session('checkout_payment_verified') === true) hidden @endunless>
          <div><strong>Upload Received Receipt</strong><small>After successful payment, upload the receipt sent to your email (PDF, JPG, or PNG; max 10MB).</small></div>
          <input id="pfyReceivedReceiptFile" type="file" accept=".pdf,.jpg,.jpeg,.png" hidden>
          <button id="pfyReceivedReceiptChoose" type="button"><i class="fa-solid fa-paperclip"></i> Choose Receipt</button>
          <p id="pfyReceivedReceiptStatus" role="status"></p>
        </section>
        <p class="pfy-ereceipt-error" id="pfyEReceiptError" role="alert" hidden></p>
      </div>
      <footer class="pfy-ereceipt-footer"><button id="pfyEReceiptSubmit" type="submit">Submit Request</button></footer>
    </form>
  </div>
</div>
<div class="pfy-toast" id="toast" role="status" aria-live="polite"></div>
</section>

<style id="checkout-e-receipt-modal-styles">
body.pfy-ereceipt-open{overflow:hidden!important}
#checkout .pfy-ereceipt-overlay[hidden]{display:none!important}
#checkout .pfy-ereceipt-overlay{position:fixed;inset:0;z-index:10050;display:grid;place-items:center;padding:18px;background:rgba(0,0,0,.64);backdrop-filter:blur(1.5px)}
#checkout .pfy-ereceipt-dialog{width:min(386px,calc(100vw - 30px));height:min(510px,calc(100vh - 32px));display:flex;flex-direction:column;overflow:hidden;border:1px solid rgba(17,24,39,.14);border-radius:12px;background:#fff;box-shadow:0 24px 70px rgba(0,0,0,.34);color:#111827;animation:pfyReceiptIn .18s ease-out}
@keyframes pfyReceiptIn{from{opacity:0;transform:translateY(8px) scale(.985)}to{opacity:1;transform:none}}
#checkout .pfy-ereceipt-head{height:47px;min-height:47px;display:flex;align-items:center;justify-content:space-between;padding:0 14px;border-bottom:1px solid #eceff3;background:#fff}
#checkout .pfy-ereceipt-title{display:flex;align-items:center;gap:8px}#checkout .pfy-ereceipt-title i{color:var(--pf-orange);font-size:17px}#checkout .pfy-ereceipt-title h2{margin:0;font-size:13px;font-weight:800;line-height:1.2}
#checkout .pfy-ereceipt-close{width:28px;height:28px;display:grid;place-items:center;padding:0;border:0;border-radius:50%;background:transparent;color:#111827;font-size:12px}#checkout .pfy-ereceipt-close:hover{background:#f2f3f5;color:var(--pf-orange)}
#checkout #pfyEReceiptForm{min-height:0;display:flex;flex:1;flex-direction:column}#checkout .pfy-ereceipt-scroll{min-height:0;flex:1;overflow-y:auto;overscroll-behavior:contain;padding:12px 14px 14px;scrollbar-width:thin;scrollbar-color:#c9cdd4 transparent}#checkout .pfy-ereceipt-scroll::-webkit-scrollbar{width:5px}#checkout .pfy-ereceipt-scroll::-webkit-scrollbar-thumb{border-radius:99px;background:#c9cdd4}
#checkout .pfy-ereceipt-notice{display:grid;grid-template-columns:17px 1fr;gap:7px;margin-bottom:12px;padding:8px 9px;border:1px solid #f4b743;border-radius:5px;background:#fff9e8;color:#4b3a12}#checkout .pfy-ereceipt-notice i{margin-top:1px;color:#f59e0b;font-size:12px}#checkout .pfy-ereceipt-notice p{margin:0;font-size:8.8px;line-height:1.35}#checkout .pfy-ereceipt-notice strong{font-weight:800}
#checkout .pfy-ereceipt-types{display:flex;align-items:center;gap:18px;margin:0 0 11px;padding:0;border:0}#checkout .pfy-ereceipt-types legend{float:left;width:84px;font-size:10px;font-weight:800}#checkout .pfy-ereceipt-types label{display:flex;align-items:center;gap:5px;font-size:9.5px;cursor:pointer}#checkout .pfy-ereceipt-types input{width:13px;height:13px;margin:0;accent-color:var(--pf-orange)}
#checkout .pfy-ereceipt-field{display:grid;grid-template-columns:112px minmax(0,1fr);align-items:center;min-height:38px;border-bottom:1px solid #eceff3}#checkout .pfy-ereceipt-field label,#checkout .pfy-ereceipt-section-label{font-size:9.2px;font-weight:700;color:#111827}#checkout .pfy-ereceipt-field input,#checkout .pfy-ereceipt-field select{width:100%;height:36px;padding:0 2px;border:0!important;background:transparent!important;color:#111827;font-size:9.5px;outline:0!important;box-shadow:none!important}#checkout .pfy-ereceipt-field input::placeholder{color:#a1a7b0}#checkout .pfy-ereceipt-field input:focus,#checkout .pfy-ereceipt-field select:focus{color:var(--pf-orange)}
#checkout .pfy-ereceipt-section-label{padding:12px 0 5px}#checkout .pfy-address-street-row{height:34px;display:grid;grid-template-columns:minmax(0,1fr) 24px;align-items:center;border-bottom:1px solid #eceff3}#checkout .pfy-address-street-row input{width:100%;height:32px;padding:0 2px;border:0!important;background:transparent!important;color:#111827;font-size:9.5px;outline:0!important;box-shadow:none!important}#checkout .pfy-address-street-row input::placeholder{color:#5f6671}#checkout .pfy-address-toggle{width:24px;height:24px;display:grid;place-items:center;padding:0;border:0;background:#fff;color:#5f6671;font-size:9.3px}#checkout .pfy-address-toggle:hover{color:var(--pf-orange)}#checkout .pfy-address-toggle i{font-size:8px}
#checkout .pfy-address-grid{display:grid;grid-template-columns:1fr 1fr;column-gap:10px}#checkout .pfy-address-grid[hidden]{display:none}#checkout .pfy-address-grid .pfy-ereceipt-field{grid-template-columns:1fr;align-content:center;padding:4px 0}#checkout .pfy-address-grid .pfy-ereceipt-field label{font-size:8.2px;color:#6b7280}#checkout .pfy-address-grid .pfy-ereceipt-field input,#checkout .pfy-address-grid .pfy-ereceipt-field select{height:25px}.pfy-ereceipt-field-full{grid-column:1/-1}
#checkout .pfy-default-toggle{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 0 7px;font-size:9.3px;font-weight:700;cursor:pointer}#checkout .pfy-default-toggle input{position:absolute;opacity:0;pointer-events:none}#checkout .pfy-default-toggle i{position:relative;width:29px;height:16px;flex:0 0 29px;border-radius:99px;background:#d7dbe1;transition:.18s}#checkout .pfy-default-toggle i:after{content:"";position:absolute;top:2px;left:2px;width:12px;height:12px;border-radius:50%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.25);transition:.18s}#checkout .pfy-default-toggle input:checked+i{background:var(--pf-orange)}#checkout .pfy-default-toggle input:checked+i:after{transform:translateX(13px)}
#checkout .pfy-ereceipt-disclaimer{margin-top:5px;color:#525966}#checkout .pfy-ereceipt-disclaimer h3{margin:0 0 5px;font-size:9.2px;color:#111827}#checkout .pfy-ereceipt-disclaimer ul{margin:0;padding-left:14px;font-size:7.8px;line-height:1.42}#checkout .pfy-ereceipt-disclaimer li+li{margin-top:3px}#checkout .pfy-consent{display:flex;align-items:flex-start;gap:6px;margin-top:9px;font-size:8px;line-height:1.35;cursor:pointer}#checkout .pfy-consent input{width:11px;height:11px;flex:0 0 11px;margin:0;accent-color:var(--pf-orange)}#checkout .pfy-consent a{color:var(--pf-orange);font-weight:700;text-decoration:underline}
#checkout .pfy-ereceipt-error{margin:9px 0 0;padding:7px 8px;border-radius:5px;background:#fff0ed;color:#c52b18;font-size:8.5px;line-height:1.35}#checkout .pfy-ereceipt-footer{min-height:57px;display:grid;place-items:center;padding:10px 14px;border-top:1px solid #eceff3;background:#fff}#checkout .pfy-ereceipt-footer button{width:190px;height:36px;border:0;border-radius:999px;background:var(--pf-gradient);color:#111827;font-size:10px;font-weight:800;box-shadow:none}#checkout .pfy-ereceipt-footer button:hover{background:#111827;color:#fff}#checkout .pfy-ereceipt-footer button:disabled{cursor:wait;opacity:.62}
#checkout .pfy-receipt-row:hover{border-color:#111827!important;background:#f7f7f7!important}#checkout .pfy-receipt-row:hover>i{color:var(--pf-orange)!important;transform:translateX(2px)}
#checkout .pfy-ereceipt-title h2{font-size:15px!important}
#checkout .pfy-ereceipt-notice p{font-size:11px!important;line-height:1.45!important}
#checkout .pfy-ereceipt-types legend,#checkout .pfy-ereceipt-types label{font-size:11px!important}
#checkout .pfy-ereceipt-field label,#checkout .pfy-ereceipt-section-label,#checkout .pfy-address-toggle,#checkout .pfy-default-toggle{font-size:10.8px!important}
#checkout .pfy-ereceipt-field input{font-size:11px!important}
#checkout .pfy-address-grid .pfy-ereceipt-field label{font-size:10px!important}
#checkout .pfy-ereceipt-disclaimer h3{font-size:11px!important}
#checkout .pfy-ereceipt-disclaimer ul,#checkout .pfy-consent{font-size:9.8px!important;line-height:1.45!important}
#checkout .pfy-ereceipt-error{font-size:10.5px!important}
#checkout .pfy-ereceipt-footer button{font-size:11px!important}
#checkout .pfy-receipt-upload{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:8px 10px;margin-top:12px;padding:11px;border:1px solid #b8ddc5;border-radius:8px;background:#f3fbf6}
#checkout .pfy-receipt-upload[hidden]{display:none!important}
#checkout .pfy-receipt-upload strong{display:block;font-size:11px;color:#111827}
#checkout .pfy-receipt-upload small{display:block;margin-top:3px;font-size:9.5px;line-height:1.4;color:#52606d}
#checkout .pfy-receipt-upload button{align-self:center;height:32px;padding:0 12px;border:1px solid #159447;border-radius:999px;background:#fff;color:#15803d;font-size:10px;font-weight:800;cursor:pointer}
#checkout .pfy-receipt-upload button:hover{background:#15803d;color:#fff}
#checkout .pfy-receipt-upload p{grid-column:1 / -1;margin:0;font-size:10px;color:#15803d}
@media(max-width:480px){#checkout .pfy-ereceipt-overlay{padding:10px}#checkout .pfy-ereceipt-dialog{width:100%;height:min(560px,calc(100vh - 20px))}#checkout .pfy-address-grid{grid-template-columns:1fr}}
</style>

<script id="checkout-e-receipt-modal-script">
(function(){
  'use strict';
  var modal=document.getElementById('pfyEReceiptModal');
  var form=document.getElementById('pfyEReceiptForm');
  var closeButton=modal?modal.querySelector('.pfy-ereceipt-close'):null;
  var addressToggle=modal?modal.querySelector('.pfy-address-toggle'):null;
  var addressFields=document.getElementById('pfyReceiptAddressFields');
  var errorBox=document.getElementById('pfyEReceiptError');
  var submitButton=document.getElementById('pfyEReceiptSubmit');
  var uploadWrap=document.getElementById('pfyReceiptUploadWrap');
  var uploadInput=document.getElementById('pfyReceivedReceiptFile');
  var uploadChoose=document.getElementById('pfyReceivedReceiptChoose');
  var uploadStatus=document.getElementById('pfyReceivedReceiptStatus');
  var lastFocus=null;

  function setReceiptType(type){
    var business=type==='business';
    var wrap=document.getElementById('pfyBusinessNameWrap');
    var input=document.getElementById('pfyBusinessName');
    var label=document.getElementById('pfyReceiptDefaultType');
    if(wrap)wrap.hidden=!business;
    if(input)input.required=business;
    if(label)label.textContent=business?'Business':'Personal';
  }
  function setUrl(open){
    var next=open?'{{ route('e-receipt.index') }}':'{{ route('checkout.index') }}';
    if(window.location.pathname!==next)window.history.pushState({eReceipt:open},'',next);
  }
  function openModal(updateUrl){
    if(!modal)return;
    lastFocus=document.activeElement;
    modal.hidden=false;
    document.body.classList.add('pfy-ereceipt-open');
    if(updateUrl!==false)setUrl(true);
    setTimeout(function(){var first=modal.querySelector('input:checked, input, button');if(first)first.focus()},20);
  }
  function closeModal(updateUrl){
    if(!modal)return;
    modal.hidden=true;
    document.body.classList.remove('pfy-ereceipt-open');
    if(updateUrl!==false)setUrl(false);
    if(lastFocus&&typeof lastFocus.focus==='function')lastFocus.focus();
  }
  window.openEReceiptModal=function(){openModal(true)};
  window.closeEReceiptModal=function(){closeModal(true)};
  if(closeButton)closeButton.addEventListener('click',function(){closeModal(true)});
  if(modal)modal.addEventListener('mousedown',function(event){if(event.target===modal)closeModal(true)});
  document.addEventListener('keydown',function(event){if(event.key==='Escape'&&modal&&!modal.hidden)closeModal(true)});
  window.addEventListener('popstate',function(){if(window.location.pathname==='{{ route('e-receipt.index') }}')openModal(false);else closeModal(false)});
  document.querySelectorAll('#pfyEReceiptForm input[name="receipt_type"]').forEach(function(input){input.addEventListener('change',function(){setReceiptType(input.value)})});
  if(addressToggle)addressToggle.addEventListener('click',function(){var expanded=addressToggle.getAttribute('aria-expanded')==='true';addressToggle.setAttribute('aria-expanded',String(!expanded));addressFields.hidden=expanded;var icon=addressToggle.querySelector('i');if(icon)icon.className='fa-solid fa-chevron-'+(expanded?'down':'up')});

  if(form)form.addEventListener('submit',async function(event){
    event.preventDefault();
    if(errorBox){errorBox.hidden=true;errorBox.textContent=''}
    if(!form.reportValidity())return;
    submitButton.disabled=true;
    submitButton.textContent='Submitting...';
    var payload=Object.fromEntries(new FormData(form).entries());
    payload.is_default=form.elements.is_default.checked;
    try{
      var response=await fetch('{{ route('e-receipt.store') }}',{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||''},body:JSON.stringify(payload)});
      var data=await response.json().catch(function(){return {}});
      if(!response.ok){var errors=data.errors?Object.values(data.errors).flat().join(' '):data.message;throw new Error(errors||'Unable to submit the e-receipt request.')}
      closeModal(true);
      document.body.dataset.eReceiptRequested='true';
      window.dispatchEvent(new CustomEvent('printify:e-receipt-submitted',{detail:{receipt:data.receipt||null}}));
      window.dispatchEvent(new CustomEvent('printify-front-feedback',{detail:{message:data.message||'E-receipt request submitted.'}}));
    }catch(error){if(errorBox){errorBox.textContent=error.message;errorBox.hidden=false}}
    finally{submitButton.disabled=false;submitButton.textContent='Submit Request'}
  });
  if(uploadChoose&&uploadInput)uploadChoose.addEventListener('click',function(){uploadInput.click()});
  if(uploadInput)uploadInput.addEventListener('change',async function(){
    var file=uploadInput.files&&uploadInput.files[0];
    if(!file)return;
    if(uploadStatus)uploadStatus.textContent='Uploading '+file.name+'...';
    if(uploadChoose)uploadChoose.disabled=true;
    var body=new FormData();body.append('receipt_file',file);
    try{
      var response=await fetch('{{ route('e-receipt.upload') }}',{method:'POST',headers:{'Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||''},body:body});
      var data=await response.json().catch(function(){return {}});
      if(!response.ok)throw new Error(data.message||Object.values(data.errors||{}).flat().join(' ')||'Unable to upload the receipt.');
      if(uploadStatus)uploadStatus.textContent='Uploaded: '+(data.receipt?.uploaded_receipt_name||file.name);
      window.dispatchEvent(new CustomEvent('printify-front-feedback',{detail:{message:data.message||'Receipt uploaded successfully.'}}));
    }catch(error){if(uploadStatus)uploadStatus.textContent=error.message}
    finally{if(uploadChoose)uploadChoose.disabled=false}
  });
  fetch('{{ route('e-receipt.show') }}',{headers:{'Accept':'application/json'}}).then(function(response){return response.ok?response.json():null}).then(function(data){
    if(!data)return;
    if(data.request_complete){document.body.dataset.eReceiptRequested='true';window.dispatchEvent(new CustomEvent('printify:e-receipt-submitted',{detail:{receipt:data.receipt||null}}))}
    if(uploadWrap)uploadWrap.hidden=!data.payment_verified;
    if(data.receipt?.uploaded_receipt_name&&uploadStatus)uploadStatus.textContent='Uploaded: '+data.receipt.uploaded_receipt_name;
  }).catch(function(){});
  setReceiptType(document.querySelector('#pfyEReceiptForm input[name="receipt_type"]:checked')?.value||'personal');
  if(window.location.pathname==='{{ route('e-receipt.index') }}')setTimeout(function(){openModal(false)},0);
})();
</script>

<script>
(function(){
"use strict";
const serverPaymentVerified=@json(session('checkout_payment_verified') === true);
const serverPaymentMethod=@json(session('checkout_payment_method'));
const serverPaymentReference=@json(session('checkout_payment_reference'));
const serverCheckoutDetails=@json(session('checkout_details', []));
const state={items:[],promoCode:"",paymentVerified:false,receiptRequested:@json((bool) session('checkout_e_receipt_request_id')),totals:{subtotal:0,discount:0,shipping:0,tax:0,total:0}};
const els={orderItems:document.getElementById("orderItems"),summaryItemCount:document.getElementById("summaryItemCount"),stageStatus:document.getElementById("checkoutStageStatus"),emptyState:document.getElementById("emptyState"),orderContent:document.getElementById("orderContent"),subtotal:document.getElementById("subtotal"),discount:document.getElementById("discount"),shippingCost:document.getElementById("shippingCost"),shippingLabel:document.getElementById("shippingLabel"),total:document.getElementById("total"),toast:document.getElementById("toast"),noteCount:document.getElementById("noteCount"),notes:document.getElementById("notes"),successBox:document.getElementById("successBox"),successRef:document.getElementById("successRef"),checkoutGrid:document.getElementById("checkoutGrid"),categoryCrumb:document.getElementById("checkoutCategoryCrumb"),categoryCrumbWrap:document.getElementById("checkoutCategoryCrumbWrap"),serviceCrumb:document.getElementById("checkoutServiceCrumb"),serviceCrumbWrap:document.getElementById("checkoutServiceCrumbWrap")};
function safeJson(key,fallback){try{return JSON.parse(localStorage.getItem(key)||fallback)}catch(e){return JSON.parse(fallback)}}
function saveJson(key,value){localStorage.setItem(key,JSON.stringify(value))}
function hydrateStoredCheckout(){if(!serverCheckoutDetails||typeof serverCheckoutDetails!=="object")return;const customer=serverCheckoutDetails.customer||{};const address=serverCheckoutDetails.shippingAddress||{};const values={firstName:customer.firstName,lastName:customer.lastName,email:customer.email,phone:customer.phone,street:address.street,apartment:address.apartment,postal:address.postal,country:address.country,notes:serverCheckoutDetails.notes};Object.entries(values).forEach(function(entry){const input=document.getElementById(entry[0]);if(input&&entry[1]!=null&&String(entry[1]).trim()!=="")input.value=entry[1]});[["province",address.province],["city",address.city],["barangay",address.barangay]].forEach(function(entry){const input=document.getElementById(entry[0]);if(input&&entry[1])input.dataset.current=entry[1]})}
function checkoutReturnStatus(){return (new URLSearchParams(window.location.search).get("payment")||"").toLowerCase()}
function saveCheckoutFormDraft(){const value=function(id){return document.getElementById(id)?.value||""};saveJson("printifyCheckoutFormDraft",{firstName:value("firstName"),lastName:value("lastName"),email:value("email"),phone:value("phone"),street:value("street"),apartment:value("apartment"),province:value("province"),city:value("city"),barangay:value("barangay"),postal:value("postal"),country:value("country"),notes:value("notes"),payment:selectedPayment()})}
function restoreCascadingAddress(source){if(!source||typeof source!=="object")return;const province=document.getElementById("province"),city=document.getElementById("city"),barangay=document.getElementById("barangay");if(province&&source.province){province.dataset.current=source.province;province.value=source.province;province.dispatchEvent(new Event("change",{bubbles:true}))}if(city&&source.city){city.dataset.current=source.city;city.value=source.city;city.dispatchEvent(new Event("change",{bubbles:true}))}if(barangay&&source.barangay){barangay.dataset.current=source.barangay;barangay.value=source.barangay;barangay.dispatchEvent(new Event("change",{bubbles:true}))}}
function hydrateCheckoutReturnDraft(){const status=checkoutReturnStatus();const storedAddress=serverCheckoutDetails&&serverCheckoutDetails.shippingAddress||{};restoreCascadingAddress(storedAddress);if(status!=="success"&&status!=="cancel")return;const draft=safeJson("printifyCheckoutFormDraft","{}");if(!draft||typeof draft!=="object")return;["firstName","lastName","email","phone","street","apartment","postal","country","notes"].forEach(function(id){const field=document.getElementById(id);if(field&&draft[id]!=null)field.value=draft[id]});restoreCascadingAddress(draft);if(draft.payment){const payment=document.querySelector('input[name="payment"][value="'+String(draft.payment)+'"]');if(payment)payment.checked=true}}
function peso(value){return "₱"+Number(value||0).toLocaleString("en-PH",{minimumFractionDigits:2,maximumFractionDigits:2})}
function money(value){return Number(value||0).toFixed(2)}
function escapeHtml(value){return String(value??"").replace(/[&<>"']/g,function(m){return {"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#039;"}[m]})}
function normalizeNumber(value){return Number(String(value||0).replace(/[^0-9.]/g,""))||0}
function showToast(message,type){if(!els.toast)return;els.toast.textContent=message;els.toast.classList.remove("is-success","is-error","is-info");els.toast.classList.add(type==="success"?"is-success":type==="error"?"is-error":"is-info","show");clearTimeout(showToast.timer);showToast.timer=setTimeout(function(){els.toast.classList.remove("show")},3600)}
function makeOrderReference(){return "PFY-"+new Date().getFullYear()+"-"+Date.now().toString(36).toUpperCase().slice(-6)+"-"+Math.random().toString(36).slice(2,5).toUpperCase()}
function sourceItems(){const checkoutItems=safeJson("printifyCheckoutItems","[]");const active=safeJson("printifyActiveCheckout","null");const cartItems=safeJson("printifyCartItems","[]");const oldCartItems=safeJson("cartItems","[]");if(Array.isArray(checkoutItems)&&checkoutItems.length)return checkoutItems;if(active&&typeof active==="object")return [active];if(Array.isArray(cartItems)&&cartItems.length)return cartItems;if(Array.isArray(oldCartItems)&&oldCartItems.length)return oldCartItems;return []}
function firstMeta(item){if(Array.isArray(item.meta))return item.meta;const meta=[];if(item.category)meta.push(item.category);if(item.paperSize||item.colorVariation)meta.push([item.paperSize,item.colorVariation].filter(Boolean).join(" - "));if(item.serviceOption)meta.push(item.serviceOption);if(item.fileName)meta.push("File: "+item.fileName);return meta.filter(Boolean)}
function normalizeImagePath(value){return value?String(value):""}
function normalizeCheckoutItem(item,index){const raw=item&&typeof item==="object"?item:{};const nested=raw.raw&&typeof raw.raw==="object"?raw.raw:{};const qty=Math.max(1,parseInt(raw.qty||raw.quantity||nested.qty||nested.quantity||1,10)||1);const lineTotal=normalizeNumber(raw.total||raw.lineTotal||raw.amountTotal||nested.total||nested.lineTotal);const rawPrice=normalizeNumber(raw.price||raw.unitPrice||raw.unit_price||raw.amount||nested.price||nested.unitPrice);const price=rawPrice||(lineTotal&&qty?lineTotal/qty:0);const name=raw.name||raw.serviceName||raw.title||raw.summaryTitle||nested.serviceName||nested.name||"Print Item";const meta=firstMeta(Object.assign({},nested,raw));const image=normalizeImagePath(raw.image_path||raw.image||raw.img||raw.thumbnail||raw.previewImage||nested.image_path||nested.image||nested.previewImage||"");return {id:String(raw.id||nested.id||"checkout-item-"+index),name:String(name),qty:qty,price:Number(money(price)),lineTotal:Number(money(lineTotal||price*qty)),image:image,meta:meta,raw:raw,fileName:raw.fileName||((raw.fileMeta&&raw.fileMeta.name)||nested.fileName||"")}}
function loadItems(){state.items=sourceItems().map(normalizeCheckoutItem).filter(function(item){return item.name&&item.qty>0})}
function itemCount(){return state.items.reduce(function(sum,item){return sum+item.qty},0)}
function syncFullName(){const first=(document.getElementById("firstName")?.value||"").trim();const last=(document.getElementById("lastName")?.value||"").trim();const full=document.getElementById("fullName");if(full)full.value=[first,last].filter(Boolean).join(" ").trim()}
function selectedShipping(){const checked=document.querySelector('input[name="shipping"]:checked');const value=checked?checked.value:"";const names={standard:"Standard Delivery",express:"Express Delivery",lalamove:"Lalamove On-demand",pickup:"Store Pick-up"};return {name:names[value]||"Select delivery method",type:value,cost:checked?normalizeNumber(checked.dataset.cost):0}}
function selectedPayment(){const checked=document.querySelector('input[name="payment"]:checked');return checked?checked.value:""}
function calculateTotals(){const subtotal=state.items.reduce(function(sum,item){return sum+item.lineTotal},0);const code=state.promoCode.toUpperCase();let discount=0;if(code==="SAVE10"||code==="DISCOUNT10")discount=subtotal*.10;if(code==="PRINTIFY50")discount=50;discount=Math.min(discount,subtotal);const shipping=selectedShipping().cost;const total=subtotal-discount+shipping;state.totals={subtotal:subtotal,discount:discount,shipping:shipping,tax:0,total:total}}
function imageMarkup(item){if(item.image)return '<img class="pfy-order-img" src="'+escapeHtml(item.image)+'" alt="'+escapeHtml(item.name)+'">';return '<div class="pfy-order-placeholder"><i class="fa-regular fa-file-lines"></i></div>'}
function renderItems(){const placeOrderButton=document.getElementById("placeOrderBtn");if(!state.items.length){if(els.emptyState)els.emptyState.style.display="block";if(els.orderContent)els.orderContent.style.display="none";if(placeOrderButton)placeOrderButton.disabled=true;return}if(els.emptyState)els.emptyState.style.display="none";if(els.orderContent)els.orderContent.style.display="block";if(!els.orderItems)return;els.orderItems.innerHTML=state.items.map(function(item){const meta=item.meta.slice(0,4).map(function(line){return '<p>'+escapeHtml(line)+'</p>'}).join("");return '<article class="pfy-order-item">'+imageMarkup(item)+'<div class="pfy-order-info"><h4>'+escapeHtml(item.name)+'</h4><p>Quantity: '+item.qty+' pcs</p>'+meta+'</div><div class="pfy-order-price">'+peso(item.lineTotal)+'</div></article>'}).join("")}
function renderCheckoutBreadcrumb(){const first=state.items[0]||{};const raw=first.raw&&typeof first.raw==="object"?first.raw:{};const category=raw.categoryTitle||raw.category||first.category||(Array.isArray(first.meta)?first.meta[0]:"");const service=raw.serviceName||raw.title||first.name||"";const serviceKey=raw.serviceKey||raw.slug||first.serviceKey||"text-only";const bindNav=function(node,url){node.style.cursor="pointer";node.setAttribute("role","link");node.setAttribute("tabindex","0");node.onclick=function(){window.location.href=url};node.onkeydown=function(event){if(event.key==="Enter"||event.key===" "){event.preventDefault();window.location.href=url}}};if(els.categoryCrumb&&els.categoryCrumbWrap){els.categoryCrumb.textContent=category||"Selected Service";els.categoryCrumbWrap.hidden=!category;bindNav(els.categoryCrumb,"/services")}if(els.serviceCrumb&&els.serviceCrumbWrap){els.serviceCrumb.textContent=service||"Service Option";els.serviceCrumbWrap.hidden=!service;bindNav(els.serviceCrumb,"/service-details?service="+encodeURIComponent(serviceKey))}}
function renderTotals(){calculateTotals();const count=itemCount();if(els.summaryItemCount)els.summaryItemCount.textContent=count+" "+(count===1?"Item":"Items");if(els.subtotal)els.subtotal.textContent=peso(state.totals.subtotal);if(els.discount)els.discount.textContent="-"+peso(state.totals.discount);if(els.shippingCost)els.shippingCost.textContent=state.totals.shipping===0?"₱0.00":peso(state.totals.shipping);if(els.shippingLabel)els.shippingLabel.textContent="Shipping ("+selectedShipping().name+")";if(els.total)els.total.textContent=peso(state.totals.total)}
function updateStep(step){document.querySelectorAll(".pfy-step").forEach(function(node){const current=Number(node.dataset.step);node.classList.toggle("is-active",current===step);node.classList.toggle("is-done",current<step)})}
function hasValues(ids){return ids.every(function(id){const input=document.getElementById(id);return input&&input.value.trim()})}
function customerInfoComplete(){return hasValues(["firstName","lastName","email","phone","street","barangay","city","province","postal"])}
function deliveryComplete(){return Boolean(selectedShipping().type)}
function setCheckoutCardLocked(selector,locked){const card=document.querySelector(selector);if(!card)return;card.classList.toggle("is-checkout-locked",locked);card.setAttribute("aria-disabled",locked?"true":"false");card.querySelectorAll('input[type="radio"]').forEach(function(input){input.disabled=locked})}
function updateCheckoutState(){syncFullName();const customerDone=customerInfoComplete();const paymentChosen=Boolean(selectedPayment());const deliveryChosen=deliveryComplete();setCheckoutCardLocked("#checkout .pfy-card-payment",!customerDone||state.paymentVerified);setCheckoutCardLocked("#checkout .pfy-card-delivery",!state.paymentVerified);const button=document.getElementById("placeOrderBtn");if(!state.items.length){updateStep(1);if(button){button.disabled=true;button.innerHTML='Checkout Empty <i class="fa-solid fa-lock"></i>'}if(els.stageStatus)els.stageStatus.textContent="No checkout items";return}if(!customerDone){updateStep(1);if(button){button.disabled=true;button.innerHTML='Complete Customer Info <i class="fa-solid fa-lock"></i>'}if(els.stageStatus)els.stageStatus.textContent="Complete customer info";return}if(!state.paymentVerified&&!state.receiptRequested){updateStep(2);if(button){button.disabled=true;button.innerHTML='Complete E-Invoice Request <i class="fa-solid fa-file-invoice"></i>'}if(els.stageStatus)els.stageStatus.textContent="Submit e-invoice details before payment";return}if(!state.paymentVerified){updateStep(paymentChosen?3:2);if(button){button.disabled=!paymentChosen;button.innerHTML=paymentChosen?'Pay Now <i class="fa-solid fa-lock"></i>':'Select Payment Method <i class="fa-solid fa-lock"></i>'}if(els.stageStatus)els.stageStatus.textContent=paymentChosen?"Ready for payment":"E-invoice request complete";return}updateStep(4);if(!deliveryChosen){if(button){button.disabled=true;button.innerHTML='Select Delivery Method <i class="fa-solid fa-truck"></i>'}if(els.stageStatus)els.stageStatus.textContent="Payment complete";return}if(button){button.disabled=false;button.innerHTML='Place Order <i class="fa-solid fa-box"></i>'}if(els.stageStatus)els.stageStatus.textContent="Ready to place order"}
function syncCheckoutStep(){updateCheckoutState()}
function updateRadioCards(){document.querySelectorAll("[data-radio-wrap]").forEach(function(label){const input=label.querySelector('input[type="radio"]');label.classList.toggle("is-selected",Boolean(input&&input.checked))})}
function syncPickupAddressState(){const pickup=selectedShipping().type==="pickup";["street","barangay","city","province","postal"].forEach(function(id){const input=document.getElementById(id);if(input)input.required=!pickup})}
function validateCustomerInfo(){syncFullName();for(const id of ["firstName","lastName","email","phone","street","barangay","city","province","postal"]){const input=document.getElementById(id);if(input&&!input.value.trim()){input.focus();showToast("Please complete all customer and address information first.","error");return false}}if(!state.items.length){showToast("Checkout is empty. Please add a service first.","error");return false}return true}
function validateDelivery(){if(!selectedShipping().type){showToast("Please select a delivery method.","error");return false}return true}
function buildCompletedOrder(){syncFullName();return {reference:makeOrderReference(),items:state.items.map(function(item){const raw=item.raw&&typeof item.raw==="object"?Object.assign({},item.raw):{};const image=raw.image_path||raw.image||item.image||"";return Object.assign({},raw,{name:raw.name||item.name,serviceName:raw.serviceName||item.name,qty:item.qty,quantity:item.qty,unitPrice:item.price,price:item.price,lineTotal:item.lineTotal,total:item.lineTotal,image:image,image_path:image,previewImage:raw.previewImage||image,fileName:item.fileName||raw.fileName||null,meta:Array.isArray(item.meta)?item.meta:(raw.meta||[])})}),totals:state.totals,customer:{fullName:document.getElementById("fullName").value.trim(),firstName:document.getElementById("firstName").value.trim(),lastName:document.getElementById("lastName").value.trim(),email:document.getElementById("email").value.trim(),phone:document.getElementById("phone").value.trim()},shippingAddress:{street:document.getElementById("street").value.trim(),apartment:document.getElementById("apartment").value.trim(),barangay:document.getElementById("barangay").value.trim(),city:document.getElementById("city").value.trim(),province:document.getElementById("province").value.trim(),postal:document.getElementById("postal").value.trim(),country:document.getElementById("country").value},delivery:selectedShipping(),payment:selectedPayment(),notes:els.notes?els.notes.value.trim():"",promoCode:state.promoCode,createdAt:new Date().toISOString(),status:state.paymentVerified?"paid":"pending_payment"}}
function csrfToken(){const meta=document.querySelector('meta[name="csrf-token"]');return meta?meta.getAttribute("content"):""}
function numericId(value){const parsed=parseInt(String(value??"").replace(/[^0-9-]/g,""),10);return Number.isFinite(parsed)?parsed:0}
function checkoutPayloadItems(){return state.items.map(function(item,index){const raw=item.raw&&typeof item.raw==="object"?item.raw:{};const rawServiceId=raw.service_id||"";const rawVariationId=raw.variation_id||"";const unitPrice=item.qty?item.lineTotal/item.qty:item.price;const image=raw.image_path||raw.image||raw.previewImage||item.image||"";return{id:item.id||("checkout-item-"+index),name:item.name,qty:item.qty,unit_price:Number(money(unitPrice)),price:Number(money(unitPrice)),service_code:raw.serviceId||raw.service_item_id||item.id,service_id:/^\d+$/.test(String(rawServiceId))?Number(rawServiceId):0,variation_id:/^\d+$/.test(String(rawVariationId))?Number(rawVariationId):0,service_item_id:raw.service_item_id||raw.serviceItemId||raw.serviceId||item.id,category:raw.categoryTitle||raw.category||"Printing Service",variation_label:[raw.paperSize,raw.colorVariation,raw.serviceOption].filter(Boolean).join(" / "),unit:raw.unit||"piece",image_path:image,price_type:String(raw.priceMode||raw.price_type||"retail").toLowerCase()==="bulk"?"bulk":"retail"}})}
async function syncCheckoutSession(){if(typeof fetch!=="function")return;const response=await fetch("{{ route('cart.sync') }}",{method:"POST",headers:{"Content-Type":"application/json","Accept":"application/json","X-CSRF-TOKEN":csrfToken()},body:JSON.stringify({items:checkoutPayloadItems()})});if(!response.ok){const body=await response.text();throw new Error(body||"Unable to prepare checkout session.")}}
async function startPaymentCheckout(order){const response=await fetch("{{ route('payment.start') }}",{method:"POST",headers:{"Content-Type":"application/json","Accept":"application/json","X-CSRF-TOKEN":csrfToken()},body:JSON.stringify({payment_method:selectedPayment(),checkout:order})});const data=await response.json().catch(function(){return {}});if(!response.ok||!data.redirect_url){const errors=data.errors?Object.values(data.errors).flat().join(" "):"";throw new Error(errors||data.message||"Payment provider did not return a checkout link.")}return data.redirect_url}
async function finalizePaidOrder(order){const response=await fetch("{{ route('checkout.finalize') }}",{method:"POST",headers:{"Content-Type":"application/json","Accept":"application/json","X-CSRF-TOKEN":csrfToken()},body:JSON.stringify({checkout:order})});const data=await response.json().catch(function(){return {}});if(!response.ok||!data.redirect_url)throw new Error(data.message||"Unable to place the paid order.");return data.redirect_url}
window.applyPromo=function(){const code=document.getElementById("promoCode").value.trim().toUpperCase();if(!code){state.promoCode="";renderTotals();return}if(!["SAVE10","DISCOUNT10","PRINTIFY50"].includes(code)){showToast("Invalid promo code. Try SAVE10 or PRINTIFY50.","error");return}state.promoCode=code;localStorage.setItem("printifyPromoCode",code);renderTotals();showToast("Promo code applied.","success")};
window.placeOrder=async function(){if(!validateCustomerInfo()){updateCheckoutState();return}if(!state.paymentVerified&&!state.receiptRequested){showToast("Complete and submit the e-invoice request before payment.","error");if(typeof window.openEReceiptModal==="function")window.openEReceiptModal();updateCheckoutState();return}if(!state.paymentVerified&&!selectedPayment()){showToast("Please select a payment method.","error");updateCheckoutState();return}if(state.paymentVerified&&!validateDelivery()){updateCheckoutState();return}calculateTotals();let order=buildCompletedOrder();const button=document.getElementById("placeOrderBtn");if(button){button.disabled=true;button.innerHTML='Processing <i class="fa-solid fa-spinner fa-spin"></i>'}try{if(!state.paymentVerified){const paymentOrder=JSON.parse(JSON.stringify(order));paymentOrder.delivery={name:"Pending delivery selection",type:"pickup",cost:0};paymentOrder.totals.shipping=0;paymentOrder.totals.total=paymentOrder.totals.subtotal-paymentOrder.totals.discount;saveCheckoutFormDraft();saveJson("printifyLastPlacedOrder",paymentOrder);await syncCheckoutSession();showToast("Opening secure payment checkout...");window.location.href=await startPaymentCheckout(paymentOrder);return}showToast("Creating your paid order...");const redirectUrl=await finalizePaidOrder(order);localStorage.removeItem("printifyCheckoutItems");localStorage.removeItem("printifyActiveCheckout");localStorage.removeItem("printifyCheckoutTotals");localStorage.removeItem("printifyCheckoutFormDraft");window.location.assign(redirectUrl)}catch(error){updateCheckoutState();showToast(error&&error.message?error.message:"Checkout failed. Please try again.","error");console.error("Checkout flow failed:",error)}};
function renderAll(){updateRadioCards();syncPickupAddressState();renderItems();renderCheckoutBreadcrumb();renderTotals();updateCheckoutState()}
let checkoutRenderFingerprint="";
function currentCheckoutFingerprint(){return [window.location.pathname,window.location.search,localStorage.getItem("printifyCheckoutItems")||"",localStorage.getItem("printifyActiveCheckout")||"",localStorage.getItem("printifyPromoCode")||""].join("|")}
window.refreshPrintifyCheckout=function(options){const force=Boolean(options&&options.force);const fingerprint=currentCheckoutFingerprint();if(!force&&fingerprint===checkoutRenderFingerprint)return;checkoutRenderFingerprint=fingerprint;hydrateStoredCheckout();hydrateCheckoutReturnDraft();loadItems();state.promoCode=(localStorage.getItem("printifyPromoCode")||"").toUpperCase();const promo=document.getElementById("promoCode");if(state.promoCode&&promo)promo.value=state.promoCode;if(els.successBox)els.successBox.classList.remove("show");if(els.checkoutGrid)els.checkoutGrid.style.display="";renderAll();applyPaymentReturnState();document.body.classList.add("checkout-hydrated")};
function applyPaymentReturnState(){const params=new URLSearchParams(window.location.search);const status=(params.get("payment")||"").toLowerCase();const returnedReference=params.get("ref")||"";state.paymentVerified=status==="success"&&serverPaymentVerified&&Boolean(serverPaymentReference)&&returnedReference===String(serverPaymentReference);if(state.paymentVerified){const paidMethod=document.querySelector('input[name="payment"][value="'+String(serverPaymentMethod||"")+'"]');if(paidMethod)paidMethod.checked=true;document.querySelectorAll('#firstName,#lastName,#email,#phone,input[name="payment"]').forEach(function(field){field.disabled=true});document.querySelectorAll('#street,#apartment,#province,#city,#barangay,#postal,#country').forEach(function(field){field.disabled=false});if(els.successBox)els.successBox.classList.remove("show");showToast("Payment successful. You can still edit your shipping address, then select your delivery method and place the order.","success")}else{document.querySelectorAll('input[name="shipping"]').forEach(function(field){field.checked=false});document.querySelectorAll('input[name="payment"]').forEach(function(field){field.checked=false;field.disabled=false});document.querySelectorAll('#firstName,#lastName,#email,#phone,#street,#apartment,#province,#city,#barangay,#postal,#country').forEach(function(field){field.disabled=false})}updateRadioCards();renderTotals();updateCheckoutState();if(status==="cancel")showToast("Payment was cancelled. You can choose another payment method and try again.","error")}
document.querySelectorAll('input[name="shipping"], input[name="payment"]').forEach(function(input){input.addEventListener("change",function(){updateRadioCards();syncPickupAddressState();renderTotals();updateCheckoutState()})});
["firstName","lastName","email","phone","street","barangay","city","province","postal"].forEach(function(id){const node=document.getElementById(id);if(node){node.addEventListener("input",syncCheckoutStep);node.addEventListener("change",syncCheckoutStep)}});
if(els.notes)els.notes.addEventListener("input",function(){els.noteCount.textContent=els.notes.value.length+"/250"});
document.addEventListener("printify:checkout-opened",function(){window.refreshPrintifyCheckout()});
window.addEventListener("printify:e-receipt-submitted",function(){state.receiptRequested=true;updateCheckoutState()});
function openCheckoutFromHash(){if((location.hash||"").toLowerCase()!=="#checkout"&&!/\/checkout\/?$/.test(location.pathname.toLowerCase()))return;if(typeof window.jumpTo==="function")window.jumpTo("checkout");else{const section=document.getElementById("checkout");if(section){section.classList.add("active");section.style.display="block"}}window.refreshPrintifyCheckout()}
window.addEventListener("hashchange",openCheckoutFromHash);if(document.readyState==="loading")document.addEventListener("DOMContentLoaded",openCheckoutFromHash,{once:true});else openCheckoutFromHash();
})();
</script>

<style>
/* =========================================================
   FINAL LOCK 06/09 V8 - sakto size + promo field fix
   - Hindi na pinalaki: balik sa compact/original-looking size
   - Maayos na salansan ng 3 columns
   - Promo field full width na, wala nang maliit na square lang
   - Customer/Shipping fields stay clean 2-column like reference
========================================================= */
:root{
  --pf-v8-orange:#ff4f16!important;
  --pf-v8-orange-2:#ff7a00!important;
  --pf-v8-gradient:linear-gradient(135deg,#ff9f00 0%,#ff7a00 50%,#ff4f16 100%)!important;
  --pf-v8-black:#111827!important;
  --pf-v8-line:#e3e6eb!important;
}

/* sakto lang ang lapad, hindi sobrang laki */
#checkout{
  padding:22px 0 46px!important;
  background:#fff!important;
}
#checkout .pfy-page{
  width:min(1270px,calc(100% - 72px))!important;
  max-width:1270px!important;
  margin:0 auto!important;
  padding:10px 0 34px!important;
}
#checkout .pfy-page-head{margin:0 0 18px!important}
#checkout .pfy-page-head h1{font-size:28px!important;line-height:1.08!important}
#checkout .pfy-page-head p{font-size:12px!important;margin-top:5px!important}

/* maayos na 3 columns, hindi dikit at hindi oversized */
#checkout .pfy-main-grid{
  display:grid!important;
  grid-template-columns:minmax(360px,410px) minmax(380px,420px) minmax(315px,350px)!important;
  grid-template-areas:
    "steps steps steps"
    "customer delivery summary"!important;
  justify-content:center!important;
  align-items:start!important;
  column-gap:24px!important;
  row-gap:22px!important;
}
#checkout .pfy-left{display:contents!important}
#checkout .pfy-customer-shipping{grid-area:customer!important}
#checkout .pfy-delivery-payment{grid-area:delivery!important}
#checkout .pfy-sidebar{
  grid-area:summary!important;
  position:static!important;
  width:100%!important;
  min-width:0!important;
}

/* stepper compact, centered, same arrangement */
#checkout .pfy-stepper{
  grid-area:steps!important;
  width:min(720px,100%)!important;
  display:grid!important;
  grid-template-columns:repeat(4,minmax(92px,1fr))!important;
  gap:28px!important;
  margin:0 auto 2px!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
  overflow:visible!important;
}
#checkout .pfy-step{
  position:relative!important;
  justify-content:center!important;
  gap:6px!important;
  min-height:22px!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
}
#checkout .pfy-step:after{
  left:calc(50% + 46px)!important;
  width:62px!important;
  border-top:2px solid #e3e6eb!important;
}
#checkout .pfy-step:last-child:after{display:none!important}
#checkout .pfy-step-no,
#checkout .pfy-step-copy strong{
  font-size:12px!important;
  font-weight:800!important;
  line-height:1!important;
}
#checkout .pfy-step-copy small{display:none!important}
#checkout .pfy-step.is-active .pfy-step-no,
#checkout .pfy-step.is-active .pfy-step-copy strong,
#checkout .pfy-step.is-done .pfy-step-no,
#checkout .pfy-step.is-done .pfy-step-copy strong{color:var(--pf-v8-orange)!important}

/* card/group size: sakto lang */
#checkout .pfy-form-group,
#checkout .pfy-summary{
  border:1px solid rgba(17,24,39,.12)!important;
  border-radius:13px!important;
  background:#fff!important;
  box-shadow:none!important;
  overflow:hidden!important;
}
#checkout .pfy-form-group .pfy-card{
  margin:0!important;
  border:0!important;
  border-radius:0!important;
  box-shadow:none!important;
  background:transparent!important;
}
#checkout .pfy-form-group .pfy-card + .pfy-card{border-top:1px solid #eef0f3!important}
#checkout .pfy-form-group .pfy-card-head{padding:16px 16px 7px!important}
#checkout .pfy-form-group .pfy-card-body{padding:10px 16px 16px!important}
#checkout .pfy-card-title{gap:9px!important;align-items:flex-start!important}
#checkout .pfy-card-icon,
#checkout .pfy-summary-title i,
#checkout .pfy-secure-icon{
  width:22px!important;
  min-width:22px!important;
  height:22px!important;
  background:transparent!important;
  border:0!important;
  color:var(--pf-v8-orange)!important;
  font-size:15px!important;
}
#checkout .pfy-card-title h2,
#checkout .pfy-summary h3,
#checkout .pfy-secure-card h4{
  font-size:14px!important;
  line-height:1.25!important;
  font-weight:800!important;
  margin:0!important;
}
#checkout .pfy-card-title p,
#checkout .pfy-secure-card p{
  font-size:10.8px!important;
  line-height:1.35!important;
  margin:3px 0 0!important;
  color:#626976!important;
}

/* fields: original-like size and clean rows */
#checkout .pfy-customer-shipping .pfy-field-grid,
#checkout .pfy-customer-shipping .pfy-field-grid.two,
#checkout .pfy-customer-shipping .pfy-field-grid.four{
  display:grid!important;
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
  gap:10px!important;
  margin:0!important;
}
#checkout .pfy-customer-shipping .pfy-field-grid.four{margin-top:10px!important}
#checkout .pfy-customer-shipping .pfy-field:has(#street),
#checkout .pfy-customer-shipping .pfy-field:has(#apartment){grid-column:1 / -1!important}
#checkout .pfy-customer-shipping .pfy-field:has(#phone){grid-column:auto!important}
#checkout .pfy-field input,
#checkout .pfy-field select{
  width:100%!important;
  height:40px!important;
  border:1px solid #dfe3ea!important;
  border-radius:8px!important;
  background:#fff!important;
  color:#111827!important;
  padding:15px 11px 5px!important;
  font-size:11px!important;
  font-weight:500!important;
  box-shadow:none!important;
  outline:0!important;
}
#checkout .pfy-field input:focus,
#checkout .pfy-field select:focus,
#checkout #notes:focus,
#checkout #promoCode:focus{
  border-color:var(--pf-v8-orange)!important;
  box-shadow:0 0 0 3px rgba(255,79,22,.10)!important;
}
#checkout .pfy-field label{top:6px!important;left:11px!important;font-size:8.8px!important;color:#667085!important}
#checkout .pfy-checkline,
#checkout .pfy-section-control{font-size:10.5px!important;margin-top:10px!important;line-height:1.35!important}

/* delivery and notes: compact */
#checkout .pfy-radio-stack{gap:8px!important}
#checkout .pfy-delivery-option{
  min-height:52px!important;
  padding:10px 12px!important;
  grid-template-columns:18px minmax(0,1fr) auto!important;
  gap:9px!important;
  border:1px solid #dfe3ea!important;
  border-radius:8px!important;
  background:#fff!important;
  box-shadow:none!important;
}
#checkout .pfy-delivery-option:hover,
#checkout .pfy-delivery-option.is-selected{
  border-color:#111827!important;
  background:rgba(17,24,39,.045)!important;
}
#checkout .pfy-delivery-copy strong{font-size:11px!important;line-height:1.22!important}
#checkout .pfy-delivery-copy strong em{font-size:9.2px!important;padding:3px 7px!important}
#checkout .pfy-delivery-copy small{font-size:9.5px!important;line-height:1.25!important}
#checkout .pfy-delivery-price{font-size:10.8px!important}
#checkout #notes{
  height:68px!important;
  min-height:68px!important;
  border:1px solid #dfe3ea!important;
  border-radius:8px!important;
  padding:11px 12px!important;
  font-size:10.8px!important;
  line-height:1.4!important;
  resize:none!important;
}
#checkout .pfy-note-box small{font-size:9px!important;right:10px!important;bottom:8px!important}

/* payment method: maayos na salansan, hindi malaki */
#checkout .pfy-payment-grid,
#checkout .pfy-pay-grid{
  display:grid!important;
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
  gap:10px!important;
  width:100%!important;
}
#checkout .pfy-pay-option{
  min-height:64px!important;
  padding:10px!important;
  display:grid!important;
  grid-template-columns:15px 45px minmax(0,1fr)!important;
  align-items:center!important;
  gap:8px!important;
  border:1px solid #dfe3ea!important;
  border-radius:8px!important;
  background:#fff!important;
  overflow:hidden!important;
  box-shadow:none!important;
}
#checkout .pfy-pay-option:hover,
#checkout .pfy-pay-option.is-selected{
  border-color:#111827!important;
  background:rgba(17,24,39,.045)!important;
}
#checkout .pfy-pay-option input{width:13px!important;height:13px!important;margin:0!important;accent-color:#16a34a!important}
#checkout .pfy-card-logos{
  width:45px!important;
  min-width:45px!important;
  display:flex!important;
  flex-wrap:wrap!important;
  align-items:center!important;
  justify-content:center!important;
  gap:2px 5px!important;
  line-height:1!important;
}
#checkout .pfy-card-logos b,
#checkout .pfy-card-logos i{font-size:10px!important;line-height:1!important}
#checkout .pfy-pay-option>span:last-child{min-width:0!important;overflow:hidden!important}
#checkout .pfy-pay-option strong{font-size:10.2px!important;line-height:1.18!important;font-weight:800!important;white-space:normal!important}
#checkout .pfy-pay-option small{font-size:8.8px!important;line-height:1.22!important;color:#6b7280!important;white-space:normal!important}
#checkout .pfy-secure-note{font-size:10px!important;margin-top:10px!important;line-height:1.3!important}

/* order summary: compact and same height feel */
#checkout .pfy-summary{
  padding:16px!important;
  overflow:visible!important;
}
#checkout .pfy-summary-head{margin-bottom:12px!important}
#checkout .pfy-summary-title{gap:8px!important}
#checkout .pfy-item-count{font-size:10.8px!important}
#checkout .pfy-order-items{max-height:none!important;overflow:visible!important;padding-bottom:8px!important}
#checkout .pfy-order-item{
  grid-template-columns:50px minmax(0,1fr) auto!important;
  gap:10px!important;
  align-items:start!important;
}
#checkout .pfy-order-img,
#checkout .pfy-order-placeholder{width:50px!important;height:50px!important;border-radius:8px!important}
#checkout .pfy-order-info h4{font-size:11px!important;margin:0 0 3px!important;line-height:1.2!important}
#checkout .pfy-order-info p{font-size:9.4px!important;line-height:1.25!important;margin:1px 0!important}
#checkout .pfy-order-price{font-size:11px!important}
#checkout .pfy-summary-line{margin:12px 0!important}

/* PROMO FIX: full input width, no small square only */
#checkout .pfy-promo,
#checkout .pfy-promo:hover{
  display:grid!important;
  grid-template-columns:minmax(0,1fr) 84px!important;
  align-items:center!important;
  gap:8px!important;
  width:100%!important;
  min-width:0!important;
  margin:0 0 12px!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
}
#checkout .pfy-promo input,
#checkout #promoCode{
  display:block!important;
  width:100%!important;
  min-width:0!important;
  max-width:none!important;
  height:36px!important;
  flex:1 1 auto!important;
  border:1px solid #dfe3ea!important;
  border-radius:8px!important;
  background:#fff!important;
  color:#111827!important;
  padding:0 12px!important;
  font-size:10.5px!important;
  line-height:36px!important;
  box-shadow:none!important;
  outline:0!important;
}
#checkout #promoCode::placeholder{color:#7b8290!important;opacity:1!important}
#checkout .pfy-promo button{
  width:84px!important;
  min-width:84px!important;
  max-width:84px!important;
  height:36px!important;
  border:0!important;
  border-radius:999px!important;
  background:var(--pf-v8-gradient)!important;
  color:#111827!important;
  font-size:10.5px!important;
  font-weight:800!important;
}
#checkout .pfy-promo button:hover{background:var(--pf-v8-black)!important;color:#fff!important}

#checkout .pfy-total-row{font-size:10.8px!important;margin-bottom:8px!important;line-height:1.25!important}
#checkout .pfy-grand-total{margin-top:10px!important;padding-top:12px!important;border-top:1px solid #eee!important;background:transparent!important;border-radius:0!important}
#checkout .pfy-grand-total span{font-size:13px!important;font-weight:800!important}
#checkout .pfy-grand-total strong{font-size:18px!important;color:var(--pf-v8-orange)!important;font-weight:900!important}
#checkout .pfy-place-order{
  width:190px!important;
  min-width:190px!important;
  max-width:190px!important;
  height:38px!important;
  margin:14px auto 0!important;
  border:0!important;
  border-radius:999px!important;
  background:var(--pf-v8-gradient)!important;
  color:#111827!important;
  font-size:10.8px!important;
  font-weight:800!important;
}
#checkout .pfy-place-order:hover{background:var(--pf-v8-black)!important;color:#fff!important}

/* safe checkout same as reference but not too big */
#checkout .pfy-secure-card,
#checkout .pfy-secure-card:hover{
  margin-top:16px!important;
  padding:16px!important;
  border:1px solid rgba(17,24,39,.12)!important;
  border-radius:13px!important;
  background:#fff!important;
  box-shadow:none!important;
}
#checkout .pfy-secure-wrap{grid-template-columns:24px minmax(0,1fr)!important;gap:9px!important;align-items:start!important}
#checkout .pfy-payment-logos{margin-top:14px!important;font-size:16px!important;gap:10px!important}
#checkout .pfy-payment-logos span{font-size:12px!important}

@media(max-width:1180px){
  #checkout .pfy-page{width:calc(100% - 32px)!important;max-width:none!important}
  #checkout .pfy-main-grid{grid-template-columns:1fr!important;grid-template-areas:"steps" "customer" "delivery" "summary"!important;row-gap:18px!important}
  #checkout .pfy-stepper{width:100%!important;grid-template-columns:repeat(4,1fr)!important;gap:10px!important}
  #checkout .pfy-step:after{display:none!important}
}
@media(max-width:760px){
  #checkout .pfy-page{width:calc(100% - 22px)!important}
  #checkout .pfy-customer-shipping .pfy-field-grid,
  #checkout .pfy-customer-shipping .pfy-field-grid.two,
  #checkout .pfy-customer-shipping .pfy-field-grid.four,
  #checkout .pfy-payment-grid,
  #checkout .pfy-pay-grid{grid-template-columns:1fr!important}
  #checkout .pfy-stepper{grid-template-columns:1fr 1fr!important}
  #checkout .pfy-promo{grid-template-columns:minmax(0,1fr) 84px!important}
}
</style>


<style>
/* =========================================================
   FINAL LOCK 06/09 V9 - SAKTO SIZE FINAL
   Request: hindi sobrang laki, hindi sobrang liit; original feel,
   maayos ang salansan, fixed Enter promo code field.
   This override is layout/style only. Existing checkout functions untouched.
========================================================= */
:root{
  --pf-v9-orange:#ff4f16!important;
  --pf-v9-orange-2:#ff7a00!important;
  --pf-v9-gradient:linear-gradient(135deg,#ff9f00 0%,#ff7a00 48%,#ff4f16 100%)!important;
  --pf-v9-black:#111827!important;
  --pf-v9-line:#e1e5eb!important;
}

#checkout{
  background:#fff!important;
  padding:22px 0 58px!important;
  overflow-x:hidden!important;
}
#checkout .pfy-page{
  width:min(1400px,calc(100% - 74px))!important;
  max-width:1400px!important;
  margin:0 auto!important;
  padding:10px 0 48px!important;
}

/* Breadcrumb and title: sakto lang */
#checkout .pfy-breadcrumb{
  gap:10px!important;
  margin:0 0 14px!important;
  font-size:12px!important;
  line-height:1.2!important;
}
#checkout .pfy-breadcrumb a,
#checkout .pfy-breadcrumb span,
#checkout .pfy-breadcrumb strong{
  color:#111827!important;
  border-bottom:3px solid transparent!important;
  padding-bottom:3px!important;
  text-decoration:none!important;
}
#checkout .pfy-breadcrumb strong,
#checkout .pfy-breadcrumb a:hover,
#checkout .pfy-breadcrumb span:hover,
#checkout .pfy-breadcrumb strong:hover{
  color:var(--pf-v9-orange)!important;
  border-bottom-color:var(--pf-v9-orange)!important;
}
#checkout .pfy-page-head{margin:0 0 20px!important}
#checkout .pfy-page-head h1{
  font-size:31px!important;
  line-height:1.08!important;
  margin:0!important;
}
#checkout .pfy-page-head p{
  font-size:13px!important;
  margin:6px 0 0!important;
  color:#555!important;
}

/* 3-column layout: sakto width and clean spacing */
#checkout .pfy-main-grid{
  display:grid!important;
  grid-template-columns:minmax(390px,460px) minmax(410px,480px) minmax(335px,390px)!important;
  grid-template-areas:
    "steps steps steps"
    "customer delivery summary"!important;
  justify-content:center!important;
  align-items:start!important;
  column-gap:30px!important;
  row-gap:24px!important;
  width:100%!important;
}
#checkout .pfy-left{display:contents!important}
#checkout .pfy-customer-shipping{grid-area:customer!important;width:100%!important;min-width:0!important}
#checkout .pfy-delivery-payment{grid-area:delivery!important;width:100%!important;min-width:0!important}
#checkout .pfy-sidebar{grid-area:summary!important;position:static!important;top:auto!important;width:100%!important;min-width:0!important}

/* Stepper centered, normal size */
#checkout .pfy-stepper,
#checkout .pfy-stepper:hover{
  grid-area:steps!important;
  width:min(860px,100%)!important;
  max-width:860px!important;
  justify-self:center!important;
  display:grid!important;
  grid-template-columns:repeat(4,minmax(118px,1fr))!important;
  gap:30px!important;
  min-height:auto!important;
  height:auto!important;
  padding:0!important;
  margin:0 auto 2px!important;
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  box-shadow:none!important;
  overflow:visible!important;
}
#checkout .pfy-step{
  position:relative!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  gap:7px!important;
  min-height:26px!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
  white-space:nowrap!important;
}
#checkout .pfy-step:after{
  content:""!important;
  position:absolute!important;
  left:calc(50% + 58px)!important;
  top:50%!important;
  width:78px!important;
  border-top:2px solid #e3e6eb!important;
  transform:translateY(-50%)!important;
}
#checkout .pfy-step:last-child:after{display:none!important}
#checkout .pfy-step-no,
#checkout .pfy-step-copy strong{
  font-size:13px!important;
  line-height:1!important;
  font-weight:800!important;
  color:#111827!important;
}
#checkout .pfy-step-copy small{display:none!important}
#checkout .pfy-step.is-active .pfy-step-no,
#checkout .pfy-step.is-active .pfy-step-copy strong,
#checkout .pfy-step.is-done .pfy-step-no,
#checkout .pfy-step.is-done .pfy-step-copy strong{color:var(--pf-v9-orange)!important}
#checkout .pfy-step.is-active:after,
#checkout .pfy-step.is-done:after{border-top-color:var(--pf-v9-orange)!important}

/* Main cards: original-like size, not too large */
#checkout .pfy-form-group,
#checkout .pfy-summary,
#checkout .pfy-secure-card{
  background:#fff!important;
  border:1px solid rgba(17,24,39,.12)!important;
  border-radius:15px!important;
  box-shadow:none!important;
}
#checkout .pfy-form-group{
  overflow:hidden!important;
  margin:0!important;
  min-height:0!important;
  height:auto!important;
}
#checkout .pfy-form-group .pfy-card,
#checkout .pfy-form-group .pfy-card:hover{
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  box-shadow:none!important;
  margin:0!important;
}
#checkout .pfy-form-group .pfy-card + .pfy-card{border-top:1px solid rgba(17,24,39,.07)!important}
#checkout .pfy-form-group .pfy-card-head{padding:20px 21px 8px!important}
#checkout .pfy-form-group .pfy-card-body{padding:13px 21px 21px!important}
#checkout .pfy-card-title{gap:11px!important;align-items:flex-start!important}
#checkout .pfy-card-icon,
#checkout .pfy-summary-title i,
#checkout .pfy-secure-icon{
  width:24px!important;
  min-width:24px!important;
  height:24px!important;
  display:grid!important;
  place-items:center!important;
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  color:var(--pf-v9-orange)!important;
  font-size:16px!important;
}
#checkout .pfy-card-title h2,
#checkout .pfy-summary h3,
#checkout .pfy-secure-card h4{
  font-size:15px!important;
  line-height:1.26!important;
  font-weight:800!important;
  margin:0!important;
  letter-spacing:0!important;
}
#checkout .pfy-card-title p,
#checkout .pfy-secure-card p{
  font-size:11.5px!important;
  line-height:1.38!important;
  margin:4px 0 0!important;
  color:#626976!important;
}

/* Customer + shipping fields: original/sakto size */
#checkout .pfy-customer-shipping .pfy-field-grid,
#checkout .pfy-customer-shipping .pfy-field-grid.two,
#checkout .pfy-customer-shipping .pfy-field-grid.four{
  display:grid!important;
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
  gap:12px!important;
  margin:0!important;
}
#checkout .pfy-customer-shipping .pfy-field-grid.four{margin-top:12px!important}
#checkout .pfy-customer-shipping .pfy-field:has(#street),
#checkout .pfy-customer-shipping .pfy-field:has(#apartment){grid-column:1 / -1!important}
#checkout .pfy-field input,
#checkout .pfy-field select{
  width:100%!important;
  height:43px!important;
  border:1px solid var(--pf-v9-line)!important;
  border-radius:9px!important;
  background:#fff!important;
  color:#111827!important;
  padding:16px 12px 6px!important;
  font-size:11.5px!important;
  font-weight:500!important;
  box-shadow:none!important;
  outline:0!important;
}
#checkout .pfy-field input:focus,
#checkout .pfy-field select:focus,
#checkout #notes:focus,
#checkout #promoCode:focus{
  border-color:var(--pf-v9-orange)!important;
  box-shadow:0 0 0 3px rgba(255,79,22,.10)!important;
}
#checkout .pfy-field label{
  top:7px!important;
  left:12px!important;
  font-size:9px!important;
  color:#667085!important;
  font-weight:600!important;
}
#checkout .pfy-checkline,
#checkout .pfy-section-control{
  margin-top:11px!important;
  font-size:11px!important;
  line-height:1.35!important;
  color:#555!important;
}

/* Delivery / notes: sakto lang */
#checkout .pfy-radio-stack{gap:10px!important}
#checkout .pfy-delivery-option{
  min-height:56px!important;
  padding:12px 14px!important;
  display:grid!important;
  grid-template-columns:18px minmax(0,1fr) auto!important;
  align-items:center!important;
  gap:10px!important;
  border:1px solid var(--pf-v9-line)!important;
  border-radius:9px!important;
  background:#fff!important;
  box-shadow:none!important;
}
#checkout .pfy-delivery-option:hover,
#checkout .pfy-delivery-option.is-selected,
#checkout .pfy-pay-option:hover,
#checkout .pfy-pay-option.is-selected{
  border-color:#111827!important;
  background:rgba(17,24,39,.045)!important;
}
#checkout .pfy-delivery-copy strong{font-size:11.5px!important;line-height:1.24!important;font-weight:800!important}
#checkout .pfy-delivery-copy strong em{font-size:9.8px!important;padding:3px 7px!important;white-space:nowrap!important}
#checkout .pfy-delivery-copy small{font-size:10px!important;line-height:1.28!important;color:#626976!important}
#checkout .pfy-delivery-price{font-size:11px!important;font-weight:900!important;white-space:nowrap!important}
#checkout #notes{
  width:100%!important;
  height:76px!important;
  min-height:76px!important;
  border:1px solid var(--pf-v9-line)!important;
  border-radius:9px!important;
  padding:12px 13px!important;
  font-size:11px!important;
  line-height:1.42!important;
  resize:none!important;
  box-shadow:none!important;
}
#checkout .pfy-note-box small{font-size:9.4px!important;right:11px!important;bottom:9px!important}

/* Payment cards: clean salansan, readable, not oversized */
#checkout .pfy-payment-grid,
#checkout .pfy-pay-grid{
  display:grid!important;
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
  gap:11px!important;
  width:100%!important;
}
#checkout .pfy-pay-option{
  min-width:0!important;
  min-height:70px!important;
  display:grid!important;
  grid-template-columns:15px 50px minmax(0,1fr)!important;
  align-items:center!important;
  gap:9px!important;
  padding:11px!important;
  border:1px solid var(--pf-v9-line)!important;
  border-radius:9px!important;
  background:#fff!important;
  box-shadow:none!important;
  overflow:hidden!important;
}
#checkout .pfy-pay-option input{
  width:14px!important;
  min-width:14px!important;
  height:14px!important;
  margin:0!important;
  accent-color:#16a34a!important;
}
#checkout .pfy-card-logos{
  width:50px!important;
  min-width:50px!important;
  display:flex!important;
  flex-wrap:wrap!important;
  align-items:center!important;
  justify-content:center!important;
  gap:2px 6px!important;
  line-height:1!important;
}
#checkout .pfy-card-logos b,
#checkout .pfy-card-logos i{font-size:10.5px!important;line-height:1!important}
#checkout .pfy-logo-visa{color:#1950a3!important}
#checkout .pfy-logo-mc{color:#e63900!important}
#checkout .pfy-logo-jcb{color:#059669!important}
#checkout .pfy-logo-gcash{color:#2688df!important}
#checkout .pfy-logo-maya{color:#2cae58!important}
#checkout .pfy-pay-option>span:last-child{
  min-width:0!important;
  overflow:hidden!important;
}
#checkout .pfy-pay-option strong{
  display:block!important;
  font-size:10.8px!important;
  line-height:1.2!important;
  font-weight:800!important;
  color:#111827!important;
  white-space:normal!important;
}
#checkout .pfy-pay-option small{
  display:block!important;
  margin-top:2px!important;
  font-size:9.3px!important;
  line-height:1.25!important;
  color:#6b7280!important;
  white-space:normal!important;
}
#checkout .pfy-secure-note{
  margin-top:11px!important;
  font-size:10.5px!important;
  line-height:1.35!important;
  color:#555!important;
}

/* Order summary: balanced with columns */
#checkout .pfy-summary,
#checkout .pfy-summary:hover{
  width:100%!important;
  padding:18px!important;
  border-radius:15px!important;
  background:#fff!important;
  box-shadow:none!important;
}
#checkout .pfy-summary-head{margin-bottom:13px!important}
#checkout .pfy-summary-title{gap:9px!important}
#checkout .pfy-item-count{font-size:11px!important;font-weight:700!important}
#checkout .pfy-order-items{max-height:none!important;overflow:visible!important;padding-bottom:10px!important}
#checkout .pfy-order-item{
  display:grid!important;
  grid-template-columns:54px minmax(0,1fr) auto!important;
  gap:11px!important;
  align-items:start!important;
}
#checkout .pfy-order-img,
#checkout .pfy-order-placeholder{width:54px!important;height:54px!important;border-radius:8px!important}
#checkout .pfy-order-info h4{font-size:11.5px!important;line-height:1.2!important;margin:0 0 3px!important;font-weight:800!important}
#checkout .pfy-order-info p{font-size:9.8px!important;line-height:1.27!important;margin:1px 0!important;color:#374151!important}
#checkout .pfy-order-price{font-size:11px!important;font-weight:900!important}
#checkout .pfy-summary-line{height:1px!important;background:#eceff3!important;margin:13px 0!important}

/* Promo field: fixed, full input, sakto height */
#checkout .pfy-promo,
#checkout .pfy-promo:hover{
  display:grid!important;
  grid-template-columns:minmax(0,1fr) 90px!important;
  align-items:center!important;
  gap:9px!important;
  width:100%!important;
  min-width:0!important;
  margin:0 0 13px!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
}
#checkout .pfy-promo input,
#checkout #promoCode{
  display:block!important;
  width:100%!important;
  min-width:0!important;
  max-width:none!important;
  height:38px!important;
  border:1px solid var(--pf-v9-line)!important;
  border-radius:9px!important;
  background:#fff!important;
  color:#111827!important;
  padding:0 13px!important;
  font-size:11px!important;
  line-height:38px!important;
  box-shadow:none!important;
  outline:0!important;
}
#checkout #promoCode::placeholder{color:#7b8290!important;opacity:1!important}
#checkout .pfy-promo button{
  width:90px!important;
  min-width:90px!important;
  max-width:90px!important;
  height:38px!important;
  border:0!important;
  border-radius:999px!important;
  background:var(--pf-v9-gradient)!important;
  color:#111827!important;
  font-size:11px!important;
  font-weight:800!important;
  box-shadow:none!important;
}
#checkout .pfy-promo button:hover{background:var(--pf-v9-black)!important;color:#fff!important}

#checkout .pfy-total-row{font-size:11px!important;margin-bottom:8px!important;line-height:1.28!important}
#checkout .pfy-grand-total{
  margin-top:11px!important;
  padding-top:13px!important;
  border-top:1px solid #eeeeee!important;
  background:transparent!important;
  border-radius:0!important;
}
#checkout .pfy-grand-total span{font-size:13.5px!important;font-weight:800!important}
#checkout .pfy-grand-total strong{font-size:19px!important;color:var(--pf-v9-orange)!important;font-weight:900!important}
#checkout .pfy-place-order{
  width:205px!important;
  min-width:205px!important;
  max-width:205px!important;
  height:40px!important;
  margin:14px auto 0!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  gap:7px!important;
  border:0!important;
  border-radius:999px!important;
  background:var(--pf-v9-gradient)!important;
  color:#111827!important;
  font-size:11px!important;
  font-weight:800!important;
  box-shadow:none!important;
}
#checkout .pfy-place-order:hover{background:var(--pf-v9-black)!important;color:#fff!important}
#checkout .pfy-reward,
#checkout .pfy-terms{display:none!important}

/* Safe checkout box: sakto, aligned with reference */
#checkout .pfy-secure-card,
#checkout .pfy-secure-card:hover{
  margin-top:18px!important;
  padding:18px!important;
  border-radius:15px!important;
  background:#fff!important;
  box-shadow:none!important;
}
#checkout .pfy-secure-wrap{
  display:grid!important;
  grid-template-columns:26px minmax(0,1fr)!important;
  align-items:start!important;
  gap:10px!important;
}
#checkout .pfy-payment-logos{
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  gap:10px!important;
  margin-top:15px!important;
  font-size:17px!important;
}
#checkout .pfy-payment-logos span{font-size:12px!important}

@media(max-width:1380px){
  #checkout .pfy-page{width:calc(100% - 54px)!important;max-width:none!important}
  #checkout .pfy-main-grid{
    grid-template-columns:minmax(360px,430px) minmax(380px,450px) minmax(315px,360px)!important;
    column-gap:24px!important;
  }
  #checkout .pfy-stepper{width:min(820px,100%)!important;gap:22px!important}
  #checkout .pfy-step:after{width:64px!important;left:calc(50% + 54px)!important}
}
@media(max-width:1180px){
  #checkout .pfy-page{width:calc(100% - 32px)!important;max-width:none!important}
  #checkout .pfy-main-grid{
    grid-template-columns:1fr!important;
    grid-template-areas:"steps" "customer" "delivery" "summary"!important;
    row-gap:18px!important;
  }
  #checkout .pfy-stepper{
    width:100%!important;
    grid-template-columns:repeat(4,1fr)!important;
    gap:10px!important;
  }
  #checkout .pfy-step:after{display:none!important}
}
@media(max-width:760px){
  #checkout .pfy-page{width:calc(100% - 22px)!important}
  #checkout .pfy-stepper{grid-template-columns:1fr 1fr!important}
  #checkout .pfy-customer-shipping .pfy-field-grid,
  #checkout .pfy-customer-shipping .pfy-field-grid.two,
  #checkout .pfy-customer-shipping .pfy-field-grid.four,
  #checkout .pfy-payment-grid,
  #checkout .pfy-pay-grid{grid-template-columns:1fr!important}
  #checkout .pfy-promo{grid-template-columns:minmax(0,1fr) 90px!important}
}
</style>

<style>
/* =========================================================
   FINAL FIX 06/09 - no duplicate text, less left space, wider gaps
   - Hide floating labels inside inputs to avoid duplicate text
   - Use placeholder/value only inside fields
   - Reduce left whitespace by starting checkout grid earlier
   - Add more column gap for cleaner spacing
   - Keep original/sakto field sizing
========================================================= */
:root{
  --pf-final-orange:#ff4f16!important;
  --pf-final-orange-2:#ff7a00!important;
  --pf-final-black:#111827!important;
  --pf-final-gradient:linear-gradient(135deg,#ff9f00 0%,#ff7a00 45%,#ff4f16 100%)!important;
}

/* Page: bawas left spacing pero hindi sobrang laki */
#checkout{
  padding:26px 0 54px!important;
  background:#fff!important;
  overflow-x:hidden!important;
}
#checkout .pfy-page{
  width:min(1480px,calc(100% - 64px))!important;
  max-width:1480px!important;
  margin:0 auto!important;
  padding:12px 0 42px!important;
}

/* Mas maayos na salansan: same 3 columns, bigger gaps, less left blank */
#checkout .pfy-main-grid{
  display:grid!important;
  grid-template-columns:minmax(390px,430px) minmax(420px,460px) minmax(330px,370px)!important;
  grid-template-areas:
    "steps steps steps"
    "customer delivery summary"!important;
  column-gap:44px!important;
  row-gap:26px!important;
  align-items:start!important;
  justify-content:start!important;
  width:100%!important;
}
#checkout .pfy-left{display:contents!important}
#checkout .pfy-customer-shipping{grid-area:customer!important;min-width:0!important;width:100%!important}
#checkout .pfy-delivery-payment{grid-area:delivery!important;min-width:0!important;width:100%!important}
#checkout .pfy-sidebar{grid-area:summary!important;position:static!important;top:auto!important;min-width:0!important;width:100%!important}

/* Stepper centered across the full checkout area */
#checkout .pfy-stepper{
  grid-area:steps!important;
  width:min(820px,100%)!important;
  justify-self:center!important;
  margin:0 auto!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
}

/* Cards remain sakto lang */
#checkout .pfy-form-group,
#checkout .pfy-summary,
#checkout .pfy-secure-card{
  box-shadow:none!important;
}
#checkout .pfy-form-group{
  background:#fff!important;
  border:1px solid rgba(17,24,39,.08)!important;
  border-radius:16px!important;
  overflow:hidden!important;
  margin:0!important;
}
#checkout .pfy-form-group .pfy-card-head{padding:18px 20px 8px!important}
#checkout .pfy-form-group .pfy-card-body{padding:12px 20px 20px!important}

/* IMPORTANT: remove duplicate field text. Labels are kept for accessibility only. */
#checkout .pfy-field label{
  position:absolute!important;
  width:1px!important;
  height:1px!important;
  padding:0!important;
  margin:-1px!important;
  overflow:hidden!important;
  clip:rect(0,0,0,0)!important;
  white-space:nowrap!important;
  border:0!important;
}
#checkout .pfy-field label:after{content:none!important}
#checkout .pfy-field input,
#checkout .pfy-field select{
  height:44px!important;
  padding:0 14px!important;
  border:1px solid #dfe3ea!important;
  border-radius:9px!important;
  background:#fff!important;
  color:#111827!important;
  font-size:12px!important;
  font-weight:500!important;
  line-height:44px!important;
  box-shadow:none!important;
  outline:0!important;
}
#checkout .pfy-field input::placeholder,
#checkout .pfy-field select::placeholder{
  color:#6b7280!important;
  opacity:1!important;
}
#checkout .pfy-field input:focus,
#checkout .pfy-field select:focus,
#checkout .pfy-note-box textarea:focus,
#checkout .pfy-promo input:focus{
  border-color:var(--pf-final-orange)!important;
  box-shadow:0 0 0 3px rgba(255,79,22,.10)!important;
}

/* Customer + Shipping fields: still 2 columns, cleaner spacing */
#checkout .pfy-customer-shipping .pfy-field-grid,
#checkout .pfy-customer-shipping .pfy-field-grid.two,
#checkout .pfy-customer-shipping .pfy-field-grid.four{
  display:grid!important;
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
  gap:12px!important;
  margin:0!important;
}
#checkout .pfy-customer-shipping .pfy-field-grid.four{margin-top:12px!important}
#checkout .pfy-customer-shipping .pfy-field:has(#street),
#checkout .pfy-customer-shipping .pfy-field:has(#apartment){
  grid-column:1 / -1!important;
}
#checkout .pfy-customer-shipping .pfy-field:has(#phone){grid-column:auto!important}

/* Delivery/payment column: balanced spacing */
#checkout .pfy-radio-stack{gap:10px!important}
#checkout .pfy-delivery-option{
  min-height:58px!important;
  padding:12px 14px!important;
  grid-template-columns:18px minmax(0,1fr) auto!important;
  gap:10px!important;
  border-radius:10px!important;
}
#checkout .pfy-note-box textarea,
#checkout #notes{
  height:86px!important;
  min-height:86px!important;
  padding:12px!important;
  border-radius:10px!important;
  font-size:11.5px!important;
  line-height:1.45!important;
}
#checkout .pfy-payment-grid,
#checkout .pfy-pay-grid{
  display:grid!important;
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
  gap:12px!important;
}
#checkout .pfy-pay-option{
  min-height:76px!important;
  padding:12px!important;
  grid-template-columns:16px 24px minmax(0,1fr)!important;
  gap:9px!important;
  border-radius:11px!important;
  overflow:hidden!important;
}

/* Promo field fixed: full input + apply button, no tiny blank box */
#checkout .pfy-promo,
#checkout .pfy-promo:hover{
  display:grid!important;
  grid-template-columns:minmax(0,1fr) 94px!important;
  gap:10px!important;
  padding:0!important;
  margin:0 0 13px!important;
  border:0!important;
  background:transparent!important;
  box-shadow:none!important;
}
#checkout .pfy-promo input,
#checkout .pfy-promo input:focus{
  width:100%!important;
  height:38px!important;
  padding:0 14px!important;
  border:1px solid #dfe3ea!important;
  border-radius:9px!important;
  background:#fff!important;
  box-shadow:none!important;
  outline:0!important;
  font-size:11px!important;
}
#checkout .pfy-promo button{
  width:94px!important;
  min-width:94px!important;
  height:38px!important;
  border-radius:999px!important;
  background:var(--pf-final-gradient)!important;
  color:#111827!important;
  font-weight:700!important;
  box-shadow:none!important;
}
#checkout .pfy-promo button:hover{
  background:var(--pf-final-black)!important;
  color:#fff!important;
}

/* Order summary sakto lang */
#checkout .pfy-summary{
  padding:18px!important;
  border-radius:16px!important;
  border:1px solid rgba(17,24,39,.12)!important;
  background:#fff!important;
}
#checkout .pfy-place-order{
  width:200px!important;
  min-width:200px!important;
  max-width:200px!important;
  height:40px!important;
  margin:14px auto 0!important;
  border-radius:999px!important;
  background:var(--pf-final-gradient)!important;
  color:#111827!important;
  font-weight:700!important;
  box-shadow:none!important;
}
#checkout .pfy-place-order:hover{
  background:var(--pf-final-black)!important;
  color:#fff!important;
}

@media(max-width:1380px){
  #checkout .pfy-page{width:calc(100% - 44px)!important;max-width:none!important}
  #checkout .pfy-main-grid{
    grid-template-columns:minmax(370px,410px) minmax(390px,430px) minmax(310px,350px)!important;
    column-gap:34px!important;
  }
}
@media(max-width:1180px){
  #checkout .pfy-page{width:calc(100% - 32px)!important}
  #checkout .pfy-main-grid{
    grid-template-columns:1fr!important;
    grid-template-areas:"steps" "customer" "delivery" "summary"!important;
    row-gap:18px!important;
    justify-content:stretch!important;
  }
  #checkout .pfy-stepper{width:100%!important;grid-template-columns:repeat(4,1fr)!important;gap:10px!important}
  #checkout .pfy-step:after{display:none!important}
}
@media(max-width:760px){
  #checkout .pfy-page{width:calc(100% - 22px)!important}
  #checkout .pfy-customer-shipping .pfy-field-grid,
  #checkout .pfy-customer-shipping .pfy-field-grid.two,
  #checkout .pfy-customer-shipping .pfy-field-grid.four,
  #checkout .pfy-payment-grid,
  #checkout .pfy-pay-grid{grid-template-columns:1fr!important}
  #checkout .pfy-stepper{grid-template-columns:1fr 1fr!important}
  #checkout .pfy-promo{grid-template-columns:1fr!important}
  #checkout .pfy-promo button{width:100%!important;min-width:0!important}
}
</style>

<style id="checkout-reference-layout-last-lock">
#checkout .pfy-main-grid{
  grid-template-columns:minmax(420px,1.05fr) minmax(430px,1fr) minmax(380px,.98fr)!important;
  grid-template-areas:"steps steps steps" "customer summary delivery"!important;
  gap:22px 24px!important;
}
#checkout .pfy-sidebar{grid-area:summary!important;display:flex!important;flex-direction:column!important;gap:14px!important;position:static!important}
#checkout .pfy-delivery-payment{grid-area:delivery!important}
#checkout .pfy-customer-shipping{grid-area:customer!important}
#checkout .pfy-stepper{grid-area:steps!important;width:min(640px,100%)!important;margin:-70px auto 4px!important}
#checkout .pfy-delivery-payment .pfy-card-notes,
#checkout .pfy-delivery-payment .pfy-card-payment{display:none!important}
#checkout .pfy-sidebar>.pfy-card-payment{display:block!important;border:1px solid #e4e8ef!important;border-radius:12px!important;background:#fff!important;box-shadow:0 10px 28px rgba(17,24,39,.035)!important}
#checkout .pfy-secure-card{display:none!important}
#checkout .pfy-delivery-option{min-height:78px!important;padding:16px!important;border-radius:8px!important}
#checkout .pfy-delivery-option.is-selected{border-color:#ff4f16!important;background:#fff9f5!important}
#checkout .pfy-summary .pfy-card-notes{display:block!important;margin:0 0 10px!important;border:0!important;background:transparent!important}
#checkout .pfy-summary .pfy-card-notes .pfy-card-head{padding:0 0 7px!important}
#checkout .pfy-summary .pfy-card-notes .pfy-card-body{padding:0!important}
#checkout .pfy-summary .pfy-card-notes .pfy-card-title p{display:none!important}
#checkout .pfy-receipt-row{display:flex!important}
@media(max-width:1260px){
  #checkout .pfy-main-grid{grid-template-columns:1fr!important;grid-template-areas:"steps" "customer" "summary" "delivery"!important}
  #checkout .pfy-stepper{margin:0 auto!important}
}
@media(max-width:720px){
  #checkout .pfy-main-grid{grid-template-areas:"steps" "customer" "summary" "delivery"!important}
}
</style>
<style id="checkout-section-spacing-true-last-lock">
#checkout{padding-top:26px!important;padding-bottom:48px!important}
#checkout .pfy-page{width:min(1520px,calc(100% - 160px))!important;max-width:1520px!important;margin:0 auto 0 80px!important}
#checkout .pfy-page-head{margin-bottom:18px!important}
@media(max-width:1260px){#checkout{padding-top:24px!important;padding-bottom:44px!important}#checkout .pfy-page{width:calc(100% - 44px)!important;margin-left:22px!important;margin-right:22px!important}}
@media(max-width:760px){#checkout{padding-top:22px!important;padding-bottom:38px!important}#checkout .pfy-page{width:calc(100% - 28px)!important;margin-left:14px!important;margin-right:14px!important}}
</style>

<style id="checkout-service-detail-style-alignment-lock">
#checkout .pfy-breadcrumb{
  display:flex!important;
  align-items:center!important;
  flex-wrap:wrap!important;
  gap:12px!important;
  margin:0 0 8px!important;
  color:#6d6d6d!important;
  font-size:13px!important;
  font-weight:500!important;
  line-height:1.2!important;
}
#checkout .pfy-breadcrumb i{color:#9ca1a7!important;font-size:9px!important}
#checkout .pfy-breadcrumb a,
#checkout .pfy-breadcrumb span,
#checkout .pfy-breadcrumb strong{
  display:inline-flex!important;
  align-items:center!important;
  padding-bottom:4px!important;
  border-bottom:3px solid transparent!important;
  color:#5f6670!important;
  text-decoration:none!important;
  line-height:1.2!important;
  font-family:var(--pf-body)!important;
  font-size:13px!important;
  font-weight:500!important;
  letter-spacing:0!important;
  transition:color .16s ease,border-color .16s ease!important;
}
#checkout .pfy-breadcrumb strong{
  color:var(--pf-orange)!important;
  border-bottom-color:var(--pf-orange)!important;
  font-weight:500!important;
}
#checkout .pfy-breadcrumb a:hover{
  color:var(--pf-orange)!important;
  border-bottom-color:var(--pf-orange)!important;
}
#checkout .pfy-breadcrumb:has(a:hover) strong{
  color:#5f6670!important;
  border-bottom-color:transparent!important;
}
#checkout .pfy-breadcrumb #checkoutCategoryCrumbWrap:not([hidden]),
#checkout .pfy-breadcrumb #checkoutServiceCrumbWrap:not([hidden]){display:contents!important}
#checkout .pfy-breadcrumb #checkoutCategoryCrumbWrap[hidden],
#checkout .pfy-breadcrumb #checkoutServiceCrumbWrap[hidden]{display:none!important}
#checkout .pfy-breadcrumb #checkoutCategoryCrumb,
#checkout .pfy-breadcrumb #checkoutServiceCrumb{
  color:#5f6670!important;
  border-bottom-color:transparent!important;
}
#checkout .pfy-breadcrumb #checkoutCategoryCrumb:hover,
#checkout .pfy-breadcrumb #checkoutServiceCrumb:hover{
  color:var(--pf-orange)!important;
  border-bottom-color:var(--pf-orange)!important;
}
#checkout .pfy-breadcrumb:has(#checkoutCategoryCrumb:hover) strong,
#checkout .pfy-breadcrumb:has(#checkoutServiceCrumb:hover) strong{
  color:#5f6670!important;
  border-bottom-color:transparent!important;
}
#checkout .pfy-page-head{margin:0 0 18px!important}
#checkout .pfy-page-head h1{
  margin:0 0 7px!important;
  color:#111!important;
  font-family:var(--pf-head)!important;
  font-size:30px!important;
  font-weight:700!important;
  line-height:1.08!important;
  letter-spacing:0!important;
}
#checkout .pfy-page-head p{margin:0!important;color:#5f6368!important;font-size:14px!important;line-height:1.45!important}
#checkout .pfy-customer-shipping .pfy-field-grid.two .pfy-field-apartment,
#checkout .pfy-customer-shipping .pfy-field-grid.two .pfy-field-barangay{grid-column:auto!important}
#checkout .pfy-customer-shipping .pfy-apartment-barangay-row{
  display:grid!important;
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
  gap:10px!important;
}
#checkout .pfy-customer-shipping .pfy-apartment-barangay-row .pfy-field-apartment{grid-column:1!important}
#checkout .pfy-customer-shipping .pfy-apartment-barangay-row .pfy-field-barangay{grid-column:2!important}
#checkout .pfy-customer-shipping .pfy-apartment-barangay-row .pfy-field-apartment:has(#apartment){grid-column:1!important}
#checkout .pfy-customer-shipping .pfy-apartment-barangay-row .pfy-field-barangay:has(#barangay){grid-column:2!important}
#checkout .pfy-field select:disabled{background:#f5f6f7!important;color:#9aa0a9!important;cursor:not-allowed!important}
#checkout .pfy-sidebar>.pfy-card-payment{
  display:block!important;
  width:100%!important;
  margin:0!important;
  border:1px solid rgba(17,24,39,.12)!important;
  border-radius:12px!important;
  background:#fff!important;
  box-shadow:none!important;
  overflow:hidden!important;
}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-head{padding:14px 14px 6px!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-body{padding:8px 14px 12px!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-title{gap:8px!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-icon{width:20px!important;min-width:20px!important;height:20px!important;font-size:14px!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-title h2{font-size:12px!important;line-height:1.2!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-title p{font-size:8.5px!important;line-height:1.3!important;margin-top:2px!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-payment-grid{
  display:grid!important;
  grid-template-columns:repeat(4,minmax(0,1fr))!important;
  gap:7px!important;
  width:100%!important;
}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-pay-option{
  min-width:0!important;
  min-height:78px!important;
  display:grid!important;
  grid-template-columns:14px minmax(0,1fr)!important;
  grid-template-rows:20px auto!important;
  align-items:center!important;
  gap:4px 3px!important;
  padding:7px!important;
  border:1px solid #dfe3ea!important;
  border-radius:7px!important;
  background:#fff!important;
  text-align:center!important;
  overflow:hidden!important;
}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-pay-option:hover,
#checkout .pfy-sidebar>.pfy-card-payment .pfy-pay-option.is-selected{border-color:var(--pf-orange)!important;background:#fff8f3!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-pay-option input{grid-column:1!important;grid-row:1!important;width:12px!important;height:12px!important;margin:0!important;accent-color:var(--pf-orange)!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-logos{grid-column:2!important;grid-row:1!important;width:auto!important;min-width:0!important;justify-content:flex-start!important;flex-direction:row!important;gap:3px!important;overflow:visible!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-logos b,
#checkout .pfy-sidebar>.pfy-card-payment .pfy-card-logos i{font-size:8.5px!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-pay-option>span:last-child{grid-column:1 / -1!important;grid-row:2!important;display:block!important;text-align:center!important;overflow:visible!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-pay-option strong{display:block!important;font-size:8px!important;line-height:1.2!important;white-space:normal!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-pay-option small{display:block!important;margin-top:2px!important;font-size:6.8px!important;line-height:1.25!important;white-space:normal!important}
#checkout .pfy-sidebar>.pfy-card-payment .pfy-secure-note{margin-top:9px!important;font-size:7.5px!important;line-height:1.3!important}

@media(min-width:1261px){
  #checkout .pfy-main-grid{
    grid-template-areas:
      ". steps steps"
      "customer summary delivery"!important;
    row-gap:16px!important;
  }
  #checkout .pfy-stepper,
  #checkout .pfy-stepper:hover{
    grid-area:steps!important;
    width:min(760px,100%)!important;
    max-width:760px!important;
    display:grid!important;
    grid-template-columns:auto minmax(64px,1fr) auto minmax(64px,1fr) auto minmax(64px,1fr) auto!important;
    align-items:center!important;
    gap:0!important;
    justify-self:center!important;
    margin:0!important;
    padding:0!important;
    border:0!important;
    background:transparent!important;
    box-shadow:none!important;
    transform:none!important;
  }
  #checkout .pfy-step{
    position:relative!important;
    display:flex!important;
    flex-direction:row!important;
    align-items:center!important;
    justify-content:center!important;
    gap:7px!important;
    min-height:24px!important;
    padding:0!important;
    border:0!important;
    border-radius:0!important;
    background:transparent!important;
    box-shadow:none!important;
    color:#787b80!important;
    font-family:var(--pf-body)!important;
    font-size:12px!important;
    font-weight:500!important;
    line-height:1.35!important;
    letter-spacing:0!important;
  }
  #checkout .pfy-step:after{
    display:none!important;
  }
  #checkout .pfy-step-line{
    display:block!important;
    width:100%!important;
    height:0!important;
    margin:0!important;
    border:0!important;
    border-top:2px dotted #d8dce2!important;
    align-self:center!important;
  }
  #checkout .pfy-step.is-active + .pfy-step-line{border-top-color:var(--pf-orange)!important}
  #checkout .pfy-step-no,
  #checkout .pfy-step-copy strong{
    width:auto!important;
    height:auto!important;
    margin:0!important;
    padding:0!important;
    border:0!important;
    border-radius:0!important;
    background:transparent!important;
    box-shadow:none!important;
    color:inherit!important;
    font-family:var(--pf-body)!important;
    font-size:12px!important;
    font-weight:500!important;
    line-height:1.35!important;
    letter-spacing:0!important;
  }
  #checkout .pfy-step-copy{font-family:var(--pf-body)!important;font-size:12px!important;font-weight:500!important;line-height:1.35!important;letter-spacing:0!important}
  #checkout .pfy-step-copy{position:relative!important;z-index:2!important;background:#fff!important;padding-right:8px!important}
  #checkout .pfy-step-no{position:relative!important;z-index:2!important;background:#fff!important}
  #checkout .pfy-step-copy small{display:none!important}
  #checkout .pfy-step.is-active,
  #checkout .pfy-step.is-active .pfy-step-no,
  #checkout .pfy-step.is-active .pfy-step-copy strong{
    color:var(--pf-orange)!important;
    font-weight:500!important;
  }
  #checkout .pfy-step.is-done,
  #checkout .pfy-step.is-done .pfy-step-no,
  #checkout .pfy-step.is-done .pfy-step-copy strong{
    color:#787b80!important;
    font-weight:500!important;
  }
  #checkout .pfy-step:hover,
  #checkout .pfy-step:hover .pfy-step-no,
  #checkout .pfy-step:hover .pfy-step-copy strong{
    color:var(--pf-orange)!important;
    background-color:#fff!important;
  }
}
@media(min-width:1600px){
  #checkout .pfy-main-grid{
    grid-template-columns:470px 455px 475px!important;
    column-gap:0!important;
    justify-content:space-between!important;
  }
}
@media(max-width:1260px){#checkout .pfy-stepper>.pfy-step-line{display:none!important}}
@media(max-width:760px){#checkout .pfy-sidebar>.pfy-card-payment .pfy-payment-grid{grid-template-columns:1fr 1fr!important}}
</style>

<style id="checkout-shipping-address-book-styles">
/* =========================================================
   SHIPPING ADDRESS BOOK FINAL LOCK
   - Removes the old extra-address checkbox control
   - Adds editable saved shipping addresses similar to the reference
   - Keeps Shipping Address editable after successful payment
========================================================= */
#checkout .pfy-address-book{
  display:grid!important;
  gap:10px!important;
  margin:0 0 14px!important;
  padding:0 0 14px!important;
  border-bottom:1px solid #eef0f3!important;
}
#checkout .pfy-address-add{
  width:100%!important;
  min-height:44px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  gap:12px!important;
  padding:0 4px 10px!important;
  border:0!important;
  border-bottom:1px solid #eef0f3!important;
  border-radius:0!important;
  background:#fff!important;
  color:#111827!important;
  text-align:left!important;
  box-shadow:none!important;
}
#checkout .pfy-address-add span{display:flex!important;align-items:center!important;gap:11px!important;min-width:0!important}
#checkout .pfy-address-add i:first-child{font-size:22px!important;color:#6b7280!important}
#checkout .pfy-address-add b{font-size:13px!important;font-weight:700!important;color:#f4f4f5!important;color:#111827!important}
#checkout .pfy-address-add>i:last-child{font-size:12px!important;color:#9ca3af!important}
#checkout .pfy-address-add:hover b,#checkout .pfy-address-add:hover>i:last-child{color:var(--pf-orange)!important}
#checkout .pfy-address-list{display:grid!important;gap:11px!important}
#checkout .pfy-address-card{
  width:100%!important;
  display:grid!important;
  grid-template-columns:minmax(0,1fr) auto!important;
  gap:10px 12px!important;
  padding:12px 0 12px!important;
  border:0!important;
  border-bottom:1px solid #eef0f3!important;
  background:#fff!important;
  text-align:left!important;
  color:#111827!important;
}
#checkout .pfy-address-card.is-selected{background:#fff!important}
#checkout .pfy-address-card-main{width:100%!important;min-width:0!important;display:block!important;padding:0!important;border:0!important;background:transparent!important;color:inherit!important;text-align:left!important;cursor:pointer!important}
#checkout .pfy-address-card-name{
  display:block!important;
  margin:0 0 7px!important;
  color:#111827!important;
  font-size:13px!important;
  line-height:1.25!important;
  font-weight:900!important;
}
#checkout .pfy-address-card-phone,
#checkout .pfy-address-card-line{
  display:block!important;
  margin:0!important;
  color:#d1d5db!important;
  color:#4b5563!important;
  font-size:11.2px!important;
  line-height:1.42!important;
  font-weight:500!important;
}
#checkout .pfy-address-card-meta{display:flex!important;align-items:center!important;gap:8px!important;margin-top:7px!important;flex-wrap:wrap!important}
#checkout .pfy-address-default-badge{
  display:inline-flex!important;
  align-items:center!important;
  height:20px!important;
  padding:0 7px!important;
  border-radius:3px!important;
  background:#ededed!important;
  color:#555!important;
  font-size:10px!important;
  line-height:20px!important;
  font-weight:800!important;
}
#checkout .pfy-address-selected-badge{
  display:inline-flex!important;
  align-items:center!important;
  height:20px!important;
  padding:0 7px!important;
  border-radius:999px!important;
  background:#fff3ed!important;
  color:var(--pf-orange)!important;
  font-size:10px!important;
  line-height:20px!important;
  font-weight:800!important;
}
#checkout .pfy-address-edit{
  align-self:start!important;
  padding:0!important;
  border:0!important;
  background:transparent!important;
  color:#ff2f6d!important;
  font-size:12px!important;
  font-weight:900!important;
}
#checkout .pfy-address-edit:hover{text-decoration:underline!important}
#checkout .pfy-address-book-hint{
  margin:0!important;
  color:#6b7280!important;
  font-size:10.5px!important;
  line-height:1.35!important;
}
#checkout .pfy-address-empty{
  width:100%!important;
  display:grid!important;
  gap:4px!important;
  padding:12px 0!important;
  border-bottom:1px solid #eef0f3!important;
  color:#6b7280!important;
}
#checkout .pfy-address-empty strong{
  color:#111827!important;
  font-size:12.5px!important;
  font-weight:900!important;
}
#checkout .pfy-address-empty span{
  display:block!important;
  color:#6b7280!important;
  font-size:10.5px!important;
  line-height:1.35!important;
}
#checkout .pfy-address-book-modal[hidden]{display:none!important}
#checkout .pfy-address-book-modal{
  position:fixed!important;
  inset:0!important;
  z-index:10070!important;
  display:grid!important;
  place-items:center!important;
  padding:18px!important;
  background:rgba(0,0,0,.62)!important;
}
#checkout .pfy-address-book-dialog{
  width:min(470px,calc(100vw - 28px))!important;
  max-height:min(720px,calc(100vh - 32px))!important;
  display:flex!important;
  flex-direction:column!important;
  overflow:hidden!important;
  border-radius:14px!important;
  border:1px solid rgba(17,24,39,.14)!important;
  background:#fff!important;
  color:#111827!important;
  box-shadow:0 24px 70px rgba(0,0,0,.35)!important;
}
#checkout .pfy-address-book-modal-head{
  min-height:52px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  gap:12px!important;
  padding:0 18px!important;
  border-bottom:1px solid #eceff3!important;
}
#checkout .pfy-address-book-modal-head h3{margin:0!important;font-size:16px!important;font-weight:900!important;color:#111827!important}
#checkout .pfy-address-book-close{width:32px!important;height:32px!important;display:grid!important;place-items:center!important;border:0!important;border-radius:50%!important;background:#fff!important;color:#111827!important}
#checkout .pfy-address-book-close:hover{background:#f3f4f6!important;color:var(--pf-orange)!important}
#checkout .pfy-address-book-modal-body{
  min-height:0!important;
  overflow:auto!important;
  display:grid!important;
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
  gap:12px!important;
  padding:16px 18px!important;
}
#checkout .pfy-address-book-field{display:grid!important;gap:5px!important;min-width:0!important}
#checkout .pfy-address-book-field.full{grid-column:1/-1!important}
#checkout .pfy-address-book-field label{font-size:10.5px!important;font-weight:800!important;color:#374151!important}
#checkout .pfy-address-book-field input{
  width:100%!important;
  height:42px!important;
  border:1px solid #dfe3ea!important;
  border-radius:9px!important;
  background:#fff!important;
  color:#111827!important;
  padding:0 12px!important;
  font-size:12px!important;
  outline:0!important;
  box-shadow:none!important;
}
#checkout .pfy-address-book-field input:focus{border-color:var(--pf-orange)!important;box-shadow:0 0 0 3px rgba(255,79,22,.10)!important}
#checkout .pfy-address-book-default{
  grid-column:1/-1!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  gap:12px!important;
  margin-top:2px!important;
  padding:10px 12px!important;
  border:1px solid #e5e7eb!important;
  border-radius:10px!important;
  color:#111827!important;
  font-size:12px!important;
  font-weight:800!important;
}
#checkout .pfy-address-book-default input{width:16px!important;height:16px!important;accent-color:var(--pf-orange)!important}
#checkout .pfy-address-book-modal-actions{
  display:grid!important;
  grid-template-columns:auto 1fr auto auto!important;
  gap:10px!important;
  align-items:center!important;
  padding:13px 18px!important;
  border-top:1px solid #eceff3!important;
}
#checkout .pfy-address-book-modal-actions button{height:38px!important;padding:0 15px!important;border-radius:999px!important;font-size:11.5px!important;font-weight:900!important}
#checkout .pfy-address-book-delete{border:1px solid #fecaca!important;background:#fff!important;color:#dc2626!important}
#checkout .pfy-address-book-cancel{border:1px solid #d1d5db!important;background:#fff!important;color:#111827!important}
#checkout .pfy-address-book-save{border:0!important;background:var(--pf-gradient)!important;color:#111827!important}
#checkout .pfy-address-book-save:hover{background:#111827!important;color:#fff!important}
@media(max-width:760px){
  #checkout .pfy-address-book-modal-body{grid-template-columns:1fr!important}
  #checkout .pfy-address-book-modal-actions{grid-template-columns:1fr!important}
  #checkout .pfy-address-book-delete,#checkout .pfy-address-book-cancel,#checkout .pfy-address-book-save{width:100%!important}
}
</style>

<script src="{{ asset('js/psgc-cascade.js') }}"></script>
<script id="checkout-ph-address-cascade">
(function(){
  var province=document.getElementById('province');
  var city=document.getElementById('city');
  var barangay=document.getElementById('barangay');
  if(!province||!city||!barangay)return;

  var metroCities=['Caloocan','Las Piñas','Makati','Malabon','Mandaluyong','Manila','Marikina','Muntinlupa','Navotas','Parañaque','Pasay','Pasig','Pateros','Quezon City','San Juan','Taguig','Valenzuela'];
  var citiesByProvince={
    'Metro Manila':metroCities,
    'Bulacan':['Baliwag','Bocaue','Bulakan','Calumpit','Guiguinto','Hagonoy','Malolos','Marilao','Meycauayan','Norzagaray','Obando','Plaridel','Pulilan','San Jose del Monte','Santa Maria'],
    'Cavite':['Bacoor','Carmona','Cavite City','Dasmariñas','General Trias','Imus','Silang','Tagaytay','Trece Martires'],
    'Laguna':['Biñan','Cabuyao','Calamba','Los Baños','San Pablo','San Pedro','Santa Cruz','Santa Rosa'],
    'Rizal':['Angono','Antipolo','Binangonan','Cainta','Cardona','Morong','Rodriguez','San Mateo','Tanay','Taytay'],
    'Other Province':['Other City / Municipality']
  };
  var quezonCityBarangays=[
    'Alicia','Amihan','Apolonio Samson','Aurora','Baesa','Bagbag','Bagong Lipunan ng Crame','Bagong Pag-asa','Bagong Silangan','Balingasa','Balong Bato','Batasan Hills','Bayanihan','Blue Ridge A','Blue Ridge B','Botocan','Bungad','Camp Aguinaldo','Capri','Central','Claro','Commonwealth','Culiat','Damar','Damayan','Damayang Lagi','Del Monte','Dioquino Zobel','Don Manuel','Doña Aurora','Doña Imelda','Doña Josefa','Duyan-Duyan','E. Rodriguez','East Kamias','Escopa I','Escopa II','Escopa III','Escopa IV','Fairview','Greater Lagro','Gulod','Holy Spirit','Horseshoe','Immaculate Conception','Kaligayahan','Kalusugan','Kamuning','Katipunan','Kaunlaran','Kristong Hari','Krus na Ligas','Laging Handa','Libis','Lourdes','Loyola Heights','Maharlika','Malaya','Mangga','Manresa','Mariana','Mariblo','Marilag','Masagana','Masambong','Matandang Balara','Milagrosa','Nagkaisang Nayon','Nayong Kaunlaran','New Era','North Fairview','Novaliches Proper','Obrero','Old Capitol Site','Paang Bundok','Pag-ibig sa Nayon','Paligsahan','Paltok','Pansol','Paraiso','Pasong Putik Proper','Pasong Tamo','Payatas','Phil-Am','Pinagkaisahan','Pinyahan','Project 6','Quirino 2-A','Quirino 2-B','Quirino 2-C','Quirino 3-A','Ramon Magsaysay','Roxas','Sacred Heart','Saint Ignatius','Saint Peter','Salvacion','San Agustin','San Antonio','San Bartolome','San Isidro Galas','San Isidro Labrador','San Jose','San Martin de Porres','San Roque','Santa Cruz','Santa Lucia','Santa Monica','Santo Cristo','Santo Domingo','Santo Niño','Santol','Sauyo','Sienna','Sikatuna Village','Silangan','Socorro','South Triangle','Tagumpay','Talayan','Talipapa','Tandang Sora','Tatalon','Teachers Village East','Teachers Village West','U.P. Campus','U.P. Village','Ugong Norte','Unang Sigaw','Valencia','Vasra','Veterans Village','Villa Maria Clara','West Kamias','West Triangle','White Plains'
  ];
  var barangaysByCity={
    'Quezon City':quezonCityBarangays,
    'Makati':['Bangkal','Bel-Air','Carmona','Dasmariñas','Forbes Park','Guadalupe Nuevo','Guadalupe Viejo','Kasilawan','La Paz','Magallanes','Olympia','Palanan','Pinagkaisahan','Pio del Pilar','Pitogo','Poblacion','San Antonio','San Isidro','San Lorenzo','Santa Cruz','Singkamas','Tejeros','Urdaneta','Valenzuela'],
    'Mandaluyong':['Addition Hills','Bagong Silang','Barangka Drive','Barangka Ibaba','Barangka Ilaya','Barangka Itaas','Buayang Bato','Burol','Daang Bakal','Hagdang Bato Itaas','Hagdang Bato Libis','Harapin Ang Bukas','Highway Hills','Hulo','Mabini-J. Rizal','Malamig','Mauway','Namayan','New Zañiga','Old Zañiga','Pag-asa','Plainview','Pleasant Hills','Poblacion','San Jose','Vergara','Wack-Wack Greenhills'],
    'Pasig':['Bagong Ilog','Bagong Katipunan','Bambang','Buting','Caniogan','Dela Paz','Kalawaan','Kapasigan','Kapitolyo','Malinao','Manggahan','Maybunga','Oranbo','Palatiw','Pinagbuhatan','Pineda','Rosario','Sagad','San Antonio','San Joaquin','San Jose','San Miguel','San Nicolas','Santa Cruz','Santa Lucia','Santa Rosa','Santo Tomas','Santolan','Sumilang','Ugong'],
    'San Juan':['Addition Hills','Balong-Bato','Batis','Corazon de Jesus','Ermitaño','Greenhills','Halo-halo','Isabelita','Kabayanan','Little Baguio','Maytunas','Onse','Pasadeña','Pedro Cruz','Progreso','Rivera','Salapan','San Perfecto','Santa Lucia','Tibagan','West Crame'],
    'Taguig':['Bagumbayan','Bambang','Calzada','Central Bicutan','Central Signal Village','Fort Bonifacio','Hagonoy','Ibayo-Tipas','Katuparan','Ligid-Tipas','Lower Bicutan','Maharlika Village','Napindan','New Lower Bicutan','North Daang Hari','North Signal Village','Palingon','Pinagsama','San Miguel','Santa Ana','South Daang Hari','South Signal Village','Tanyag','Tuktukan','Upper Bicutan','Ususan','Wawa','Western Bicutan']
  };

  function fill(select,placeholder,values,current){
    select.innerHTML='';
    var first=document.createElement('option');
    first.value='';first.textContent=placeholder;select.appendChild(first);
    values.forEach(function(value){var option=document.createElement('option');option.value=value;option.textContent=value;select.appendChild(option)});
    if(current&&!values.includes(current)){var custom=document.createElement('option');custom.value=current;custom.textContent=current;select.appendChild(custom)}
    select.value=current||'';
  }
  function normalizedProvince(value){return ['NCR','National Capital Region','Metro Manila'].includes(value)?'Metro Manila':value}
  function populateBarangays(current){
    var values=barangaysByCity[city.value]||['Other / Not listed'];
    fill(barangay,'Select barangay',values,current||'');
    barangay.disabled=!city.value;
    barangay.dispatchEvent(new Event('change',{bubbles:true}));
  }
  function populateCities(currentCity,currentBarangay){
    var values=citiesByProvince[province.value]||[];
    fill(city,'Select city / town',values,currentCity||'');
    city.disabled=!province.value;
    populateBarangays(currentBarangay||'');
  }

  var currentProvince=normalizedProvince(province.dataset.current||'');
  var currentCity=city.dataset.current||'';
  var currentBarangay=barangay.dataset.current||'';
  if(!currentProvince&&metroCities.includes(currentCity))currentProvince='Metro Manila';
  fill(province,'Select state / province',Object.keys(citiesByProvince),currentProvince);
  populateCities(currentCity,currentBarangay);
  province.addEventListener('change',function(){populateCities('','')});
  city.addEventListener('change',function(){populateBarangays('')});
})();
</script>

<script id="checkout-shipping-address-book-script">
(function(){
  'use strict';
  var STORAGE_KEY='printifyAddressBook';
  var SELECTED_KEY='printifySelectedShippingAddressId';
  var OLD_SEEDED_KEY=STORAGE_KEY+'SeededShippingV2';
  var list=document.getElementById('pfyAddressBookList');
  var addBtn=document.getElementById('pfyAddressAddBtn');
  var modal=document.getElementById('pfyAddressBookModal');
  var form=document.getElementById('pfyAddressBookForm');
  var closeBtn=document.getElementById('pfyAddressBookClose');
  var cancelBtn=document.getElementById('pfyAddressBookCancel');
  var deleteBtn=document.getElementById('pfyAddressBookDelete');
  var title=document.getElementById('pfyAddressBookModalTitle');
  if(!list||!addBtn||!modal||!form)return;

  function readJson(key,fallback){try{return JSON.parse(localStorage.getItem(key)||fallback)}catch(error){return JSON.parse(fallback)}}
  function writeBook(book){localStorage.setItem(STORAGE_KEY,JSON.stringify(book))}
  function escapeHtml(value){return String(value==null?'':value).replace(/[&<>"']/g,function(match){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[match]})}
  function normalizeProvince(value){return ['NCR','National Capital Region','Metro Manila'].includes(value)?'Metro Manila':value}
  function normalizeAddress(address){
    var item=Object.assign({id:'address-'+Date.now().toString(36)+'-'+Math.random().toString(36).slice(2,6),fullName:'',phone:'',street:'',apartment:'',barangay:'',city:'',province:'',postal:'',country:'Philippines',isDefault:false},address||{});
    item.id=String(item.id||('address-'+Date.now().toString(36)+'-'+Math.random().toString(36).slice(2,6)));
    item.fullName=String(item.fullName||'').trim();
    item.phone=String(item.phone||'').trim();
    item.street=String(item.street||'').trim();
    item.apartment=String(item.apartment||'').trim();
    item.barangay=String(item.barangay||'').trim();
    item.city=String(item.city||'').trim();
    item.province=normalizeProvince(String(item.province||'').trim());
    item.postal=String(item.postal||'').trim();
    item.country=String(item.country||'Philippines').trim()||'Philippines';
    item.isDefault=Boolean(item.isDefault);
    return item;
  }
  function hasAddressDetails(address){
    return ['fullName','street','barangay','city','province','postal','phone','apartment'].some(function(key){return String(address[key]||'').trim()!==''});
  }
  function isOldSeededSample(address){
    var id=String(address.id||'').toLowerCase();
    var name=String(address.fullName||'').toLowerCase();
    var street=String(address.street||'').toLowerCase();
    return id==='address-julie-anne-calusa'||id==='address-quiel-asha-calusa'||
      ((name==='julie anne calusa'||name==='quiel asha l. calusa')&&street.indexOf('u.p. sikatuna bliss 2')!==-1);
  }
  function readBook(){
    var existing=readJson(STORAGE_KEY,'[]');
    if(!Array.isArray(existing))existing=[];
    existing=existing.map(normalizeAddress).filter(function(address){return hasAddressDetails(address)&&!isOldSeededSample(address)});
    localStorage.removeItem(OLD_SEEDED_KEY);
    if(existing.length&&!existing.some(function(address){return address.isDefault}))existing[0].isDefault=true;
    if(!existing.length)localStorage.removeItem(SELECTED_KEY);
    else if(selectedId()&&!existing.some(function(address){return address.id===selectedId()}))localStorage.setItem(SELECTED_KEY,(existing.find(function(address){return address.isDefault})||existing[0]).id);
    writeBook(existing);
    return existing;
  }
  function selectedId(){return localStorage.getItem(SELECTED_KEY)||''}
  function selectedAddress(book){
    var id=selectedId();
    return book.find(function(address){return address.id===id})||book.find(function(address){return address.isDefault})||book[0]||null;
  }
  function addressLine(address){
    return [address.street,address.apartment,address.barangay,address.city,address.province,address.country].filter(function(value){return String(value||'').trim()!==''}).join(', ');
  }
  function checkoutHasAddress(){
    return ['street','province','city','barangay','postal'].some(function(id){return String(document.getElementById(id)?.value||'').trim()!==''});
  }
  function ensureOption(select,value){
    if(!select||!value)return;
    var exists=Array.prototype.some.call(select.options,function(option){return option.value===value});
    if(!exists){var option=document.createElement('option');option.value=value;option.textContent=value;select.appendChild(option)}
  }
  function fireFieldEvents(field){
    if(!field)return;
    field.dispatchEvent(new Event('input',{bubbles:true}));
    field.dispatchEvent(new Event('change',{bubbles:true}));
  }
  function setValue(id,value){var field=document.getElementById(id);if(!field)return;field.disabled=false;field.value=value||'';fireFieldEvents(field)}
  function setSelectValue(id,value){
    var select=document.getElementById(id);
    if(!select)return;
    select.disabled=false;
    ensureOption(select,value);
    select.dataset.current=value||'';
    select.value=value||'';
    fireFieldEvents(select);
  }
  function applyAddressToCheckout(address){
    if(!address)return;
    setValue('street',address.street);
    setValue('apartment',address.apartment);
    setValue('postal',address.postal);
    setSelectValue('country',address.country||'Philippines');
    setSelectValue('province',normalizeProvince(address.province||''));
    setTimeout(function(){
      setSelectValue('city',address.city||'');
      setTimeout(function(){
        setSelectValue('barangay',address.barangay||'');
      },20);
    },20);
  }
  function selectAddress(id,shouldFill){
    var book=readBook();
    var address=book.find(function(item){return item.id===id});
    if(!address)return;
    localStorage.setItem(SELECTED_KEY,address.id);
    renderBook();
    if(shouldFill!==false)applyAddressToCheckout(address);
  }
  function renderBook(){
    var book=readBook();
    if(!book.length){
      list.innerHTML='<div class="pfy-address-empty"><strong>No saved address yet</strong><span>Template muna ito. Lalabas lang dito ang address kapag nag-add at nag-save na si user/customer.</span></div>';
      return;
    }
    var selected=selectedAddress(book);
    if(selected&&!selectedId())localStorage.setItem(SELECTED_KEY,selected.id);
    list.innerHTML=book.map(function(address){
      var isSelected=selected&&selected.id===address.id;
      return '<article class="pfy-address-card '+(isSelected?'is-selected':'')+'" data-address-id="'+escapeHtml(address.id)+'">'+
        '<button type="button" class="pfy-address-card-main" data-address-use="'+escapeHtml(address.id)+'">'+
          '<strong class="pfy-address-card-name">'+escapeHtml(address.fullName||'Unnamed Address')+'</strong>'+
          '<span class="pfy-address-card-phone">'+escapeHtml(address.phone||'No phone number')+'</span>'+
          '<span class="pfy-address-card-line">'+escapeHtml(addressLine(address))+'</span>'+
          '<span class="pfy-address-card-meta">'+(address.isDefault?'<em class="pfy-address-default-badge">Default</em>':'')+(isSelected?'<em class="pfy-address-selected-badge">Selected</em>':'')+'</span>'+
        '</button>'+
        '<button type="button" class="pfy-address-edit" data-address-edit="'+escapeHtml(address.id)+'">Edit</button>'+
      '</article>';
    }).join('');
    list.querySelectorAll('[data-address-use]').forEach(function(button){button.addEventListener('click',function(){selectAddress(button.getAttribute('data-address-use'),true)})});
    list.querySelectorAll('[data-address-edit]').forEach(function(button){button.addEventListener('click',function(){openEditor(button.getAttribute('data-address-edit'))})});
  }
  function field(id){return document.getElementById(id)}
  function setEditorValue(id,value){var input=field(id);if(input)input.value=value||''}
  function openEditor(id){
    var book=readBook();
    var address=id?book.find(function(item){return item.id===id}):null;
    var fresh=!address;
    address=normalizeAddress(address||{country:'Philippines'});
    setEditorValue('pfyAddressBookId',fresh?'':address.id);
    setEditorValue('pfyAddressBookName',address.fullName);
    setEditorValue('pfyAddressBookPhone',address.phone);
    setEditorValue('pfyAddressBookStreet',address.street);
    setEditorValue('pfyAddressBookApartment',address.apartment);
    setEditorValue('pfyAddressBookProvince',address.province);
    setEditorValue('pfyAddressBookCity',address.city);
    setEditorValue('pfyAddressBookBarangay',address.barangay);
    setEditorValue('pfyAddressBookPostal',address.postal);
    setEditorValue('pfyAddressBookCountry',address.country||'Philippines');
    var defaultInput=field('pfyAddressBookDefault');
    if(defaultInput)defaultInput.checked=Boolean(address.isDefault||fresh&&!book.length);
    if(title)title.textContent=fresh?'Add address':'Edit address';
    if(deleteBtn)deleteBtn.hidden=fresh;
    modal.hidden=false;
    document.body.classList.add('pfy-address-book-open');
    setTimeout(function(){field('pfyAddressBookName')?.focus()},20);
  }
  function closeEditor(){modal.hidden=true;document.body.classList.remove('pfy-address-book-open');form.reset()}
  function saveEditor(event){
    event.preventDefault();
    if(!form.reportValidity())return;
    var id=field('pfyAddressBookId')?.value||'';
    var book=readBook();
    var address=normalizeAddress({
      id:id||('address-'+Date.now().toString(36)+'-'+Math.random().toString(36).slice(2,7)),
      fullName:field('pfyAddressBookName')?.value.trim()||'',
      phone:field('pfyAddressBookPhone')?.value.trim()||'',
      street:field('pfyAddressBookStreet')?.value.trim()||'',
      apartment:field('pfyAddressBookApartment')?.value.trim()||'',
      province:field('pfyAddressBookProvince')?.value.trim()||'',
      city:field('pfyAddressBookCity')?.value.trim()||'',
      barangay:field('pfyAddressBookBarangay')?.value.trim()||'',
      postal:field('pfyAddressBookPostal')?.value.trim()||'',
      country:field('pfyAddressBookCountry')?.value.trim()||'Philippines',
      isDefault:Boolean(field('pfyAddressBookDefault')?.checked)
    });
    if(address.isDefault)book.forEach(function(item){item.isDefault=false});
    var index=book.findIndex(function(item){return item.id===address.id});
    if(index>=0)book[index]=address;else book.push(address);
    if(book.length&&!book.some(function(item){return item.isDefault}))book[0].isDefault=true;
    writeBook(book);
    localStorage.setItem(SELECTED_KEY,address.id);
    closeEditor();
    renderBook();
    applyAddressToCheckout(address);
  }
  function deleteCurrent(){
    var id=field('pfyAddressBookId')?.value||'';
    if(!id)return;
    var book=readBook().filter(function(item){return item.id!==id});
    if(book.length&&!book.some(function(item){return item.isDefault}))book[0].isDefault=true;
    writeBook(book);
    var next=selectedAddress(book);
    if(next)localStorage.setItem(SELECTED_KEY,next.id);else localStorage.removeItem(SELECTED_KEY);
    closeEditor();
    renderBook();
    if(next&&!checkoutHasAddress())applyAddressToCheckout(next);
  }
  addBtn.addEventListener('click',function(){openEditor('')});
  form.addEventListener('submit',saveEditor);
  if(closeBtn)closeBtn.addEventListener('click',closeEditor);
  if(cancelBtn)cancelBtn.addEventListener('click',closeEditor);
  if(deleteBtn)deleteBtn.addEventListener('click',deleteCurrent);
  modal.addEventListener('mousedown',function(event){if(event.target===modal)closeEditor()});
  document.addEventListener('keydown',function(event){if(event.key==='Escape'&&!modal.hidden)closeEditor()});
  renderBook();
  var initial=selectedAddress(readBook());
  if(initial&&!checkoutHasAddress())applyAddressToCheckout(initial);
  document.addEventListener('printify:checkout-opened',function(){renderBook();var current=selectedAddress(readBook());if(current&&!checkoutHasAddress())applyAddressToCheckout(current)});
})();
</script>

<script id="checkout-psgc-address-cascade">
(function(){
  if(!window.PrintifyPsgc)return;
  var source='/data/ph-locations.json';
  var shippingProvince=document.getElementById('province');
  window.PrintifyPsgc.bindCascade({
    source:source,
    region:'#pfyReceiptRegion',
    province:'#pfyReceiptProvince',
    city:'#pfyReceiptCity',
    barangay:'#pfyReceiptBarangay',
    current:{
      region:document.getElementById('pfyReceiptRegion')?.dataset.current||'',
      province:document.getElementById('pfyReceiptProvince')?.dataset.current||'',
      city:document.getElementById('pfyReceiptCity')?.dataset.current||'',
      barangay:document.getElementById('pfyReceiptBarangay')?.dataset.current||''
    },
    placeholders:{
      region:'Enter region',
      province:'Enter province',
      city:'Enter city',
      barangay:'Enter barangay'
    }
  });
  window.PrintifyPsgc.bindCascade({
    source:source,
    region:'#province',
    province:'#province',
    city:'#city',
    barangay:'#barangay',
    current:{
      region:shippingProvince?.dataset.current||'',
      province:shippingProvince?.dataset.current||'',
      city:document.getElementById('city')?.dataset.current||'',
      barangay:document.getElementById('barangay')?.dataset.current||''
    },
    placeholders:{
      region:'Select state / province',
      province:'Select state / province',
      city:'Select city / town',
      barangay:'Select barangay'
    },
    onChange:function(){if(typeof syncCheckoutStep==='function')syncCheckoutStep()}
  });
})();
</script>

<script id="checkout-first-paint-ready">
(function(){
  var revealed=false;
  var attempts=0;
  function revealCheckout(){
    if(revealed)return;
    if(!document.body.classList.contains('checkout-hydrated')&&attempts<90){
      attempts+=1;
      requestAnimationFrame(revealCheckout);
      return;
    }
    revealed=true;
    requestAnimationFrame(function(){
      requestAnimationFrame(function(){document.body.classList.add('checkout-ready')});
    });
  }
  document.addEventListener('printify:checkout-opened',revealCheckout,{once:true});
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',revealCheckout,{once:true});
  else revealCheckout();
})();
</script>

<style id="checkout-sequential-flow-lock">
#checkout .pfy-summary-title{flex-wrap:wrap}
#checkout #checkoutStageStatus{width:100%;margin:2px 0 0 27px;color:#6b7280;font-family:var(--pf-body);font-size:9px;font-weight:500;line-height:1.2}
#checkout #checkoutStageStatus::before{content:"";display:inline-block;width:6px;height:6px;margin-right:5px;border-radius:50%;background:var(--pf-orange);vertical-align:1px}
#checkout .is-checkout-locked{position:relative;opacity:.52;filter:grayscale(.12);cursor:not-allowed}
#checkout .is-checkout-locked .pfy-card-body{pointer-events:none;user-select:none}
#checkout .is-checkout-locked::after{content:"Complete the previous checkout step to continue";position:absolute;inset:0;z-index:4;display:flex;align-items:flex-end;justify-content:center;padding:12px;border-radius:inherit;background:rgba(255,255,255,.08);color:#6b7280;font-family:var(--pf-body);font-size:9px;font-weight:600;pointer-events:none}
#checkout .pfy-place-order:disabled{cursor:not-allowed!important;opacity:.48!important;background:#9ca3af!important;color:#fff!important}
</style>
