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
  function arrangeCheckoutReference(){
    var sidebar=document.querySelector('#checkout .pfy-sidebar');
    var summary=document.querySelector('#checkout .pfy-summary');
    var notes=document.querySelector('#checkout .pfy-card-notes');
    var payment=document.querySelector('#checkout .pfy-card-payment');
    var promo=document.querySelector('#checkout .pfy-promo');
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
      receipt.addEventListener('click',function(){
        if(typeof window.dispatchEvent==='function'){
          window.dispatchEvent(new CustomEvent('printify-front-feedback',{detail:{message:'E-receipt will be sent after order completion.'}}));
        }
      });
    }
  }
  document.addEventListener('DOMContentLoaded',arrangeCheckoutReference);
  document.addEventListener('printify:checkout-opened',arrangeCheckoutReference);
  window.addEventListener('load',arrangeCheckoutReference);
  arrangeCheckoutReference();
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
#checkout .pfy-card-shipping.is-disabled{
  opacity:.62!important;
}
#checkout .pfy-card-shipping.is-disabled input,
#checkout .pfy-card-shipping.is-disabled select,
#checkout .pfy-card-shipping.is-disabled .pfy-section-control{
  cursor:not-allowed!important;
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

<section id="checkout" class="section checkout-section" data-section-id="checkout" data-page="checkout">
<main class="pfy-page">
  <div class="pfy-breadcrumb">
    <a href="/" onclick="jumpTo('home');return false;">Home</a><i class="fa-solid fa-chevron-right"></i>
    <a href="/services" onclick="jumpTo('products');return false;">Services</a>
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
      <a href="/services" onclick="jumpTo('products');return false;">Back to Services</a>
      <button type="button" onclick="window.print()">Print Confirmation</button>
    </div>
  </section>

  <div class="pfy-main-grid" id="checkoutGrid">
    <section class="pfy-left">
      <div class="pfy-stepper" aria-label="Checkout progress">
        <div class="pfy-step is-active" data-step="1"><span class="pfy-step-no">1</span><span class="pfy-step-copy"><strong>1. Cart</strong><small>Review items</small></span></div>
        <div class="pfy-step" data-step="2"><span class="pfy-step-no">2</span><span class="pfy-step-copy"><strong>2. Shipping</strong><small>Delivery details</small></span></div>
        <div class="pfy-step" data-step="3"><span class="pfy-step-no">3</span><span class="pfy-step-copy"><strong>3. Payment</strong><small>Secure payment</small></span></div>
        <div class="pfy-step" data-step="4"><span class="pfy-step-no">4</span><span class="pfy-step-copy"><strong>4. Review</strong><small>Confirm order</small></span></div>
      </div>

      <div class="pfy-form-group pfy-customer-shipping">
        @php
          $checkoutUser = auth()->user();
          $checkoutPhone = $checkoutUser?->phone
              ? \App\Services\PhilippinePhoneNumber::normalize($checkoutUser->phone)
              : null;
        @endphp
        <section class="pfy-card pfy-card-customer">
          <div class="pfy-card-head">
            <div class="pfy-card-title"><span class="pfy-card-icon"><i class="fa-solid fa-user"></i></span><div><h2>Customer Information</h2><p>We'll use this information to contact you about your order.</p></div></div>
          </div>
          <div class="pfy-card-body">
            <input type="hidden" id="fullName" value="{{ old('fullName', Auth::check() ? Auth::user()->name : '') }}">
            <div class="pfy-field-grid">
              <div class="pfy-field"><label for="firstName">First Name</label><input type="text" id="firstName" placeholder="First Name" value="{{ old('firstName', $checkoutUser?->first_name ?? '') }}" autocomplete="given-name" required></div>
              <div class="pfy-field"><label for="lastName">Last Name</label><input type="text" id="lastName" placeholder="Last Name" value="{{ old('lastName', $checkoutUser?->last_name ?? '') }}" autocomplete="family-name" required></div>
              <div class="pfy-field"><label for="email">Email Address</label><input type="email" id="email" placeholder="Email Address" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" autocomplete="email" required></div>
              <div class="pfy-field"><label for="phone">Mobile Number</label><input type="tel" id="phone" placeholder="09171234567 or +639171234567" value="{{ old('phone', $checkoutPhone ?? '') }}" autocomplete="tel" inputmode="tel" pattern="^(09\d{9}|\+639\d{9}|639\d{9})$" title="Use a valid Philippine mobile number: 09171234567 or +639171234567" required></div>
            </div>
          </div>
        </section>

        <section class="pfy-card pfy-card-shipping">
          <div class="pfy-card-head">
            <div class="pfy-card-title"><span class="pfy-card-icon"><i class="fa-solid fa-location-dot"></i></span><div><h2>Shipping Address</h2><p>Where should we deliver your order?</p></div></div>
            <label class="pfy-section-control"><input type="checkbox" id="differentAddress">Ship to a different address</label>
          </div>
          <div class="pfy-card-body">
            <div class="pfy-field-grid two">
              <div class="pfy-field full"><label for="street">Street Address</label><input type="text" id="street" placeholder="Street Address" value="{{ old('street', '') }}" autocomplete="street-address" required></div>
              <div class="pfy-field full"><label for="apartment">House / Unit / Landmark</label><input type="text" id="apartment" placeholder="House / Unit / Landmark" value="{{ old('apartment', '') }}" autocomplete="address-line2" required></div>
            </div>
            <div class="pfy-field-grid four">
              <div class="pfy-field"><label for="country">Country</label><select id="country" data-old="{{ old('country', 'Philippines') }}"><option value="Philippines" selected>Philippines</option></select></div>
              <div class="pfy-field"><label for="province">State / Province</label><select id="province" data-old="{{ old('province', '') }}" required><option value="">State / Province</option></select></div>
              <div class="pfy-field"><label for="city">City / Town</label><select id="city" data-old="{{ old('city', '') }}" required disabled><option value="">City / Town</option></select></div>
              <div class="pfy-field"><label for="barangay">Barangay</label><select id="barangay" data-old="{{ old('barangay', '') }}" required disabled><option value="">Barangay</option></select></div>
              <div class="pfy-field"><label for="postal">Postal Code</label><input type="text" id="postal" placeholder="Postal Code" value="{{ old('postal', '') }}" required></div>
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
              <label class="pfy-delivery-option is-selected" data-radio-wrap><input type="radio" name="shipping" value="lalamove" data-cost="284" checked><span class="pfy-delivery-copy"><strong>Lalamove On-demand <em>Live price</em></strong><small>Use your exact drop-off location and track the driver after checkout.</small></span><span class="pfy-delivery-price">From &#8369;284.00</span></label>
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
            <div class="pfy-card-title"><span class="pfy-card-icon"><i class="fa-regular fa-credit-card"></i></span><div><h2>Payment Method</h2><p>All transactions are secure and encrypted.</p></div></div>
          </div>
          <div class="pfy-card-body">
            <div class="pfy-payment-grid">
              <label class="pfy-pay-option is-selected" data-radio-wrap><input type="radio" name="payment" value="card" checked><span class="pfy-card-logos"><b class="pfy-logo-visa">VISA</b><b class="pfy-logo-mc">●●</b><b class="pfy-logo-jcb">JCB</b></span><span><strong>Credit / Debit Card</strong><small>Visa, Mastercard, JCB</small></span></label>
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
        <div class="pfy-summary-head"><div class="pfy-summary-title"><i class="fa-regular fa-rectangle-list"></i><h3>Order Summary</h3></div><span class="pfy-item-count" id="summaryItemCount">0 Items</span></div>
        <div id="emptyState" class="pfy-empty"><i class="fa-solid fa-cart-shopping"></i><h2>Your checkout is empty</h2><p>Please go back to Services and choose a printing service first.</p><a href="/services" onclick="jumpTo('products');return false;">Back to Services</a></div>
        <div id="orderContent">
          <div class="pfy-order-items" id="orderItems"></div>
          <div class="pfy-summary-line"></div>
          <div class="pfy-promo"><input type="text" id="promoCode" placeholder="Enter promo code"><button type="button" onclick="applyPromo()">Apply</button></div>
          <div class="pfy-total-row"><span>Subtotal</span><strong id="subtotal">₱0.00</strong></div>
          <div class="pfy-total-row discount"><span>Discount</span><strong id="discount">-₱0.00</strong></div>
          <div class="pfy-total-row"><span id="shippingLabel">Shipping (Store Pick-up)</span><strong id="shippingCost">₱0.00</strong></div>
          <div class="pfy-grand-total"><span>Total</span><strong id="total">₱0.00</strong></div>
          <button class="pfy-place-order" id="placeOrderBtn" type="button" onclick="placeOrder()">Place Order <i class="fa-solid fa-lock"></i></button>
        </div>
      </section>

      <section class="pfy-secure-card">
        <div class="pfy-secure-wrap"><span class="pfy-secure-icon"><i class="fa-solid fa-shield-halved"></i></span><div><h4>Safe &amp; Secure Checkout</h4><p>Your information and payment are protected with industry-standard encryption.</p></div></div>
        <div class="pfy-payment-logos"><span class="visa">VISA</span><span class="mc">●●</span><span class="jcb">JCB</span><span class="gcash">GCash</span><span class="maya">maya</span></div>
      </section>
    </aside>
  </div>
</main>
<div class="pfy-toast" id="toast" role="status" aria-live="polite"></div>
</section>

<script>
(function(){
"use strict";
const state={items:[],promoCode:"",totals:{subtotal:0,discount:0,shipping:0,tax:0,total:0}};
const els={orderItems:document.getElementById("orderItems"),summaryItemCount:document.getElementById("summaryItemCount"),emptyState:document.getElementById("emptyState"),orderContent:document.getElementById("orderContent"),subtotal:document.getElementById("subtotal"),discount:document.getElementById("discount"),shippingCost:document.getElementById("shippingCost"),shippingLabel:document.getElementById("shippingLabel"),total:document.getElementById("total"),toast:document.getElementById("toast"),noteCount:document.getElementById("noteCount"),notes:document.getElementById("notes"),successBox:document.getElementById("successBox"),successRef:document.getElementById("successRef"),checkoutGrid:document.getElementById("checkoutGrid"),categoryCrumb:document.getElementById("checkoutCategoryCrumb"),categoryCrumbWrap:document.getElementById("checkoutCategoryCrumbWrap"),serviceCrumb:document.getElementById("checkoutServiceCrumb"),serviceCrumbWrap:document.getElementById("checkoutServiceCrumbWrap")};
function safeJson(key,fallback){try{return JSON.parse(localStorage.getItem(key)||fallback)}catch(e){return JSON.parse(fallback)}}
function saveJson(key,value){localStorage.setItem(key,JSON.stringify(value))}
function peso(value){return "₱"+Number(value||0).toLocaleString("en-PH",{minimumFractionDigits:2,maximumFractionDigits:2})}
function money(value){return Number(value||0).toFixed(2)}
function escapeHtml(value){return String(value??"").replace(/[&<>"']/g,function(m){return {"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#039;"}[m]})}
function normalizeNumber(value){return Number(String(value||0).replace(/[^0-9.]/g,""))||0}
function showToast(message,type){if(!els.toast)return;els.toast.textContent=message;els.toast.classList.remove("is-success","is-error","is-info");els.toast.classList.add(type==="success"?"is-success":type==="error"?"is-error":"is-info","show");clearTimeout(showToast.timer);showToast.timer=setTimeout(function(){els.toast.classList.remove("show")},3600)}
function makeOrderReference(){return "PFY-"+new Date().getFullYear()+"-"+Date.now().toString(36).toUpperCase().slice(-6)+"-"+Math.random().toString(36).slice(2,5).toUpperCase()}
function normalizePhilippineMobile(value){
  const cleaned=String(value||"").trim().replace(/[^\d+]/g,"");
  if(!cleaned)return "";
  if(/^09\d{9}$/.test(cleaned))return "+63"+cleaned.slice(1);
  if(/^639\d{9}$/.test(cleaned))return "+"+cleaned;
  if(/^\+639\d{9}$/.test(cleaned))return cleaned;
  return "";
}
function syncCheckoutPhone(showInvalidMessage){
  const input=document.getElementById("phone");
  if(!input)return true;
  const raw=input.value.trim();
  if(!raw){
    input.setCustomValidity("");
    return false;
  }
  const normalized=normalizePhilippineMobile(raw);
  if(!normalized){
    input.value="";
    input.setCustomValidity("Use a valid Philippine mobile number: 09171234567 or +639171234567.");
    if(showInvalidMessage)showToast("Please enter a valid Philippine mobile number starting with 09 or +639.","error");
    return false;
  }
  input.value=normalized;
  input.setCustomValidity("");
  return true;
}
function sourceItems(){const checkoutItems=safeJson("printifyCheckoutItems","[]");const active=safeJson("printifyActiveCheckout","null");const cartItems=safeJson("printifyCartItems","[]");const oldCartItems=safeJson("cartItems","[]");if(Array.isArray(checkoutItems)&&checkoutItems.length)return checkoutItems;if(active&&typeof active==="object")return [active];if(Array.isArray(cartItems)&&cartItems.length)return cartItems;if(Array.isArray(oldCartItems)&&oldCartItems.length)return oldCartItems;return []}
function firstMeta(item){if(Array.isArray(item.meta))return item.meta;const meta=[];if(item.category)meta.push(item.category);if(item.paperSize||item.colorVariation)meta.push([item.paperSize,item.colorVariation].filter(Boolean).join(" - "));if(item.serviceOption)meta.push(item.serviceOption);if(item.fileName)meta.push("File: "+item.fileName);return meta.filter(Boolean)}
function normalizeCheckoutItem(item,index){const raw=item&&typeof item==="object"?item:{};const qty=Math.max(1,parseInt(raw.qty||raw.quantity||1,10)||1);const lineTotal=normalizeNumber(raw.total||raw.lineTotal||raw.amountTotal);const rawPrice=normalizeNumber(raw.price||raw.unitPrice||raw.unit_price||raw.amount);const price=rawPrice||(lineTotal&&qty?lineTotal/qty:0);const name=raw.name||raw.serviceName||raw.title||raw.summaryTitle||"Print Item";const meta=firstMeta(raw);const image=raw.image||raw.img||raw.thumbnail||raw.previewImage||"";return {id:String(raw.id||"checkout-item-"+index),name:String(name),qty:qty,price:Number(money(price)),lineTotal:Number(money(lineTotal||price*qty)),image:image,meta:meta,raw:raw,fileName:raw.fileName||((raw.fileMeta&&raw.fileMeta.name)||"")}}
function loadItems(){state.items=sourceItems().map(normalizeCheckoutItem).filter(function(item){return item.name&&item.qty>0})}
function itemCount(){return state.items.reduce(function(sum,item){return sum+item.qty},0)}
function syncFullName(){const first=(document.getElementById("firstName")?.value||"").trim();const last=(document.getElementById("lastName")?.value||"").trim();const full=document.getElementById("fullName");if(full)full.value=[first,last].filter(Boolean).join(" ").trim()}
function selectedShipping(){const checked=document.querySelector('input[name="shipping"]:checked');const value=checked?checked.value:"pickup";const names={standard:"Standard Delivery",express:"Express Delivery",lalamove:"Lalamove On-demand",pickup:"Store Pick-up"};return {name:names[value]||"Store Pick-up",type:value,cost:checked?normalizeNumber(checked.dataset.cost):0}}
function selectedPayment(){const checked=document.querySelector('input[name="payment"]:checked');return checked?checked.value:"card"}
function calculateTotals(){const subtotal=state.items.reduce(function(sum,item){return sum+item.lineTotal},0);const code=state.promoCode.toUpperCase();let discount=0;if(code==="SAVE10"||code==="DISCOUNT10")discount=subtotal*.10;if(code==="PRINTIFY50")discount=50;discount=Math.min(discount,subtotal);const shipping=selectedShipping().cost;const total=subtotal-discount+shipping;state.totals={subtotal:subtotal,discount:discount,shipping:shipping,tax:0,total:total}}
function imageMarkup(item){if(item.image)return '<img class="pfy-order-img" src="'+escapeHtml(item.image)+'" alt="'+escapeHtml(item.name)+'">';return '<div class="pfy-order-placeholder"><i class="fa-regular fa-file-lines"></i></div>'}
function renderItems(){const placeOrderButton=document.getElementById("placeOrderBtn");if(!state.items.length){if(els.emptyState)els.emptyState.style.display="block";if(els.orderContent)els.orderContent.style.display="none";if(placeOrderButton)placeOrderButton.disabled=true;return}if(els.emptyState)els.emptyState.style.display="none";if(els.orderContent)els.orderContent.style.display="block";if(placeOrderButton)placeOrderButton.disabled=false;if(!els.orderItems)return;els.orderItems.innerHTML=state.items.map(function(item){const meta=item.meta.slice(0,4).map(function(line){return '<p>'+escapeHtml(line)+'</p>'}).join("");return '<article class="pfy-order-item">'+imageMarkup(item)+'<div class="pfy-order-info"><h4>'+escapeHtml(item.name)+'</h4><p>Quantity: '+item.qty+' pcs</p>'+meta+'</div><div class="pfy-order-price">'+peso(item.lineTotal)+'</div></article>'}).join("")}
function renderCheckoutBreadcrumb(){const first=state.items[0]||{};const raw=first.raw&&typeof first.raw==="object"?first.raw:{};const category=raw.categoryTitle||raw.category||first.category||(Array.isArray(first.meta)?first.meta[0]:"");const service=raw.serviceName||raw.title||first.name||"";const serviceKey=raw.serviceKey||raw.slug||first.serviceKey||"text-only";if(els.categoryCrumb&&els.categoryCrumbWrap){els.categoryCrumb.textContent=category||"Selected Service";els.categoryCrumbWrap.hidden=!category;els.categoryCrumb.style.cursor="pointer";els.categoryCrumb.onclick=function(){if(typeof jumpTo==="function")jumpTo("products",{updateUrl:true});else window.location.href="/services"}}if(els.serviceCrumb&&els.serviceCrumbWrap){els.serviceCrumb.textContent=service||"Service Option";els.serviceCrumbWrap.hidden=!service;els.serviceCrumb.style.cursor="pointer";els.serviceCrumb.onclick=function(){if(typeof window.openPrintifyServiceDetail==="function")window.openPrintifyServiceDetail(serviceKey,true);else window.location.href="/service-details?service="+encodeURIComponent(serviceKey)}}}
function renderTotals(){calculateTotals();const count=itemCount();if(els.summaryItemCount)els.summaryItemCount.textContent=count+" "+(count===1?"Item":"Items");if(els.subtotal)els.subtotal.textContent=peso(state.totals.subtotal);if(els.discount)els.discount.textContent="-"+peso(state.totals.discount);if(els.shippingCost)els.shippingCost.textContent=state.totals.shipping===0?"₱0.00":peso(state.totals.shipping);if(els.shippingLabel)els.shippingLabel.textContent="Shipping ("+selectedShipping().name+")";if(els.total)els.total.textContent=peso(state.totals.total)}
function updateStep(step){document.querySelectorAll(".pfy-step").forEach(function(node){const current=Number(node.dataset.step);node.classList.toggle("is-active",current===step);node.classList.toggle("is-done",current<step)})}
function hasValues(ids){return ids.every(function(id){const input=document.getElementById(id);return input&&input.value.trim()})}
let locationCatalog={provinces:[]};
let locationCatalogLoaded=false;
async function loadLocationCatalog(){
  if(locationCatalogLoaded)return locationCatalog;
  const province=document.getElementById("province"),city=document.getElementById("city"),barangay=document.getElementById("barangay");
  [province,city,barangay].forEach(function(select){if(select)select.disabled=true});
  try{
    const response=await fetch("{{ asset('data/ph-locations.json') }}",{headers:{"Accept":"application/json"}});
    if(!response.ok)throw new Error("Unable to load Philippine location catalog.");
    const data=await response.json();
    locationCatalog={provinces:Array.isArray(data.provinces)?data.provinces:[]};
    locationCatalogLoaded=true;
    return locationCatalog;
  }catch(error){
    console.error("PSGC location catalog failed to load:",error);
    showToast("Location list could not load. Please refresh the checkout page.","error");
    return locationCatalog;
  }
}
function setSelectOptions(select,options,placeholder,selectedValue){
  if(!select)return;
  const rows=options.map(function(option){const label=typeof option==="string"?option:option.name;return '<option value="'+escapeHtml(label)+'">'+escapeHtml(label)+'</option>'}).join("");
  select.innerHTML='<option value="">'+escapeHtml(placeholder)+'</option>'+rows;
  const labels=options.map(function(option){return typeof option==="string"?option:option.name});
  if(selectedValue&&labels.includes(selectedValue))select.value=selectedValue;
}
function selectedProvinceRecord(){
  const province=document.getElementById("province");
  return locationCatalog.provinces.find(function(item){return item.name===(province?province.value:"")})||null;
}
function selectedCityRecord(){
  const city=document.getElementById("city"),provinceRecord=selectedProvinceRecord();
  return (provinceRecord?.cities||[]).find(function(item){return item.name===(city?city.value:"")})||null;
}
async function setupLocationDropdowns(){
  const country=document.getElementById("country"),province=document.getElementById("province"),city=document.getElementById("city"),barangay=document.getElementById("barangay");
  if(!country||!province||!city||!barangay)return;
  await loadLocationCatalog();
  setSelectOptions(province,locationCatalog.provinces,"State / Province",province.dataset.old||province.value||"");
  province.disabled=!locationCatalog.provinces.length;
  function populateCities(){
    const provinceRecord=selectedProvinceRecord();
    const cities=provinceRecord?.cities||[];
    const selectedCity=city.dataset.old||city.value||"";
    setSelectOptions(city,cities,"City / Town",selectedCity);
    city.disabled=!province.value||!cities.length;
    if(!cities.some(function(item){return item.name===city.value}))city.value="";
    populateBarangays();
  }
  function populateBarangays(){
    const cityRecord=selectedCityRecord();
    const barangays=cityRecord?.barangays||[];
    const selectedBarangay=barangay.dataset.old||barangay.value||"";
    setSelectOptions(barangay,barangays,"Barangay",selectedBarangay);
    barangay.disabled=!city.value||!barangays.length;
    if(!barangays.some(function(item){return item.name===barangay.value}))barangay.value="";
  }
  province.addEventListener("change",function(){city.dataset.old="";barangay.dataset.old="";populateCities();syncCheckoutStep()});
  city.addEventListener("change",function(){barangay.dataset.old="";populateBarangays();syncCheckoutStep()});
  barangay.addEventListener("change",syncCheckoutStep);
  populateCities();
}
function syncCheckoutStep(){syncFullName();if(!state.items.length){updateStep(1);return}const customerDone=hasValues(["firstName","lastName","email","phone"]);const pickup=selectedShipping().type==="pickup";const shippingDone=pickup||hasValues(["street","apartment","province","city","barangay","postal"]);if(customerDone&&shippingDone){updateStep(3);return}if(customerDone){updateStep(2);return}updateStep(1)}
function updateRadioCards(){document.querySelectorAll("[data-radio-wrap]").forEach(function(label){const input=label.querySelector('input[type="radio"]');label.classList.toggle("is-selected",Boolean(input&&input.checked))})}
function syncPickupAddressState(){const pickup=selectedShipping().type==="pickup";const shippingCard=document.querySelector(".pfy-card-shipping");if(shippingCard)shippingCard.classList.toggle("is-disabled",pickup);["differentAddress","country","street","apartment","province","city","barangay","postal"].forEach(function(id){const input=document.getElementById(id);if(input){input.required=!pickup&&id!=="differentAddress"&&id!=="country";input.disabled=pickup;input.classList.toggle("is-disabled",pickup);if(pickup&&id==="differentAddress")input.checked=false}})}
function validateForm(){syncFullName();const pickup=selectedShipping().type==="pickup";const required=pickup?["firstName","lastName","email","phone"]:["firstName","lastName","email","phone","street","apartment","province","city","barangay","postal"];for(const id of required){const input=document.getElementById(id);if(input&&!input.value.trim()){input.focus();showToast(pickup?"Please complete Customer Information before checkout.":"Please complete Customer Information and Shipping Address before checkout.","error");return false}}if(!syncCheckoutPhone(true)){document.getElementById("phone")?.focus();return false}if(!state.items.length){showToast("Checkout is empty. Please add a service first.","error");return false}return true}
function buildCompletedOrder(){syncFullName();return {reference:makeOrderReference(),items:state.items.map(function(item){return item.raw&&Object.keys(item.raw).length?item.raw:item}),totals:state.totals,customer:{fullName:document.getElementById("fullName").value.trim(),firstName:document.getElementById("firstName").value.trim(),lastName:document.getElementById("lastName").value.trim(),email:document.getElementById("email").value.trim(),phone:document.getElementById("phone").value.trim()},shippingAddress:{street:document.getElementById("street").value.trim(),apartment:document.getElementById("apartment").value.trim(),barangay:document.getElementById("barangay").value.trim(),city:document.getElementById("city").value.trim(),province:document.getElementById("province").value.trim(),postal:document.getElementById("postal").value.trim(),country:document.getElementById("country").value},delivery:selectedShipping(),payment:selectedPayment(),notes:els.notes?els.notes.value.trim():"",promoCode:state.promoCode,createdAt:new Date().toISOString(),status:"placed"}}
function csrfToken(){const meta=document.querySelector('meta[name="csrf-token"]');return meta?meta.getAttribute("content"):""}
function numericId(value){const parsed=parseInt(String(value??"").replace(/[^0-9-]/g,""),10);return Number.isFinite(parsed)?parsed:0}
function checkoutPayloadItems(){const first=state.items[0]||{};const raw=first.raw&&typeof first.raw==="object"?first.raw:{};const names=state.items.map(function(item){return item.name}).filter(Boolean).join(", ");return [{name:names?("Printify Checkout - "+names).slice(0,180):"Printify Checkout Order",qty:1,unit_price:state.totals.total,price:state.totals.total,service_code:"checkout-"+Date.now(),service_id:numericId(raw.service_id||raw.serviceId),variation_id:numericId(raw.variation_id||raw.variationId),service_item_id:raw.service_item_id||raw.serviceItemId||raw.serviceId||"",category:"Checkout Total",variation_label:selectedShipping().name+" / "+selectedPayment(),unit:"order",image_path:raw.image_path||raw.image||""}]}
async function syncCheckoutSession(){if(typeof fetch!=="function")return;const response=await fetch("{{ route('cart.sync') }}",{method:"POST",headers:{"Content-Type":"application/json","Accept":"application/json","X-CSRF-TOKEN":csrfToken()},body:JSON.stringify({items:checkoutPayloadItems()})});if(!response.ok){const body=await response.text();throw new Error(body||"Unable to prepare checkout session.")}}
async function startPaymentCheckout(order){const response=await fetch("{{ route('payment.start') }}",{method:"POST",headers:{"Content-Type":"application/json","Accept":"application/json","X-CSRF-TOKEN":csrfToken()},body:JSON.stringify({payment_method:selectedPayment(),checkout:order})});const data=await response.json().catch(function(){return {}});if(!response.ok||!data.redirect_url){throw new Error(data.message||"Payment provider did not return a checkout link.")}return data.redirect_url}
window.applyPromo=function(){const code=document.getElementById("promoCode").value.trim().toUpperCase();if(!code){state.promoCode="";renderTotals();return}if(!["SAVE10","DISCOUNT10","PRINTIFY50"].includes(code)){showToast("Invalid promo code. Try SAVE10 or PRINTIFY50.","error");return}state.promoCode=code;localStorage.setItem("printifyPromoCode",code);renderTotals();showToast("Promo code applied.","success")};
window.placeOrder=async function(){if(!validateForm()){syncCheckoutStep();return}updateStep(4);calculateTotals();const order=buildCompletedOrder();const orders=safeJson("printifyOrders","[]");orders.push(order);saveJson("printifyOrders",orders);saveJson("printifyLastPlacedOrder",order);const button=document.getElementById("placeOrderBtn");if(button){button.disabled=true;button.innerHTML='Processing <i class="fa-solid fa-spinner fa-spin"></i>'}try{await syncCheckoutSession();showToast("Opening secure payment checkout...");const redirectUrl=await startPaymentCheckout(order);window.location.href=redirectUrl}catch(error){if(button){button.disabled=false;button.innerHTML='Place Order <i class="fa-solid fa-lock"></i>'}showToast(error&&error.message?error.message:"Payment checkout failed to start. Please try again.","error");console.error("Checkout payment start failed:",error)}};
function renderAll(){updateRadioCards();syncPickupAddressState();renderItems();renderCheckoutBreadcrumb();renderTotals();syncCheckoutStep()}
window.refreshPrintifyCheckout=function(){loadItems();state.promoCode=(localStorage.getItem("printifyPromoCode")||"").toUpperCase();const promo=document.getElementById("promoCode");if(state.promoCode&&promo)promo.value=state.promoCode;if(els.successBox)els.successBox.classList.remove("show");if(els.checkoutGrid)els.checkoutGrid.style.display="";renderAll();applyPaymentReturnState()};
function applyPaymentReturnState(){const params=new URLSearchParams(window.location.search);const status=(params.get("payment")||"").toLowerCase();if(status==="success"){const last=safeJson("printifyLastPlacedOrder","{}");const ref=params.get("ref")||last.reference||"PAYMENT-SUCCESS";if(els.successRef)els.successRef.textContent=ref;if(els.successBox)els.successBox.classList.add("show");if(els.checkoutGrid)els.checkoutGrid.style.display="none";localStorage.removeItem("printifyCheckoutItems");localStorage.removeItem("printifyActiveCheckout");localStorage.removeItem("printifyCheckoutTotals");showToast("Payment successful. Your order is confirmed.","success");return}if(status==="cancel")showToast("Payment was cancelled. You can choose another payment method and try again.","error")}
document.querySelectorAll('input[name="shipping"], input[name="payment"]').forEach(function(input){input.addEventListener("change",function(){updateRadioCards();syncPickupAddressState();renderTotals();syncCheckoutStep()})});
setupLocationDropdowns();
["firstName","lastName","email","phone","street","apartment","province","city","barangay","postal"].forEach(function(id){const node=document.getElementById(id);if(node){node.addEventListener("input",syncCheckoutStep);node.addEventListener("change",syncCheckoutStep)}});
const phoneInput=document.getElementById("phone");
if(phoneInput){
  phoneInput.addEventListener("blur",function(){syncCheckoutPhone(Boolean(phoneInput.value.trim()))});
  phoneInput.addEventListener("change",function(){syncCheckoutPhone(false)});
  setTimeout(function(){syncCheckoutPhone(false);syncCheckoutStep()},150);
  setTimeout(function(){syncCheckoutPhone(false);syncCheckoutStep()},900);
}
if(els.notes)els.notes.addEventListener("input",function(){els.noteCount.textContent=els.notes.value.length+"/250"});
document.addEventListener("printify:checkout-opened",window.refreshPrintifyCheckout);
function openCheckoutFromHash(){if((location.hash||"").toLowerCase()!=="#checkout"&&!/\/checkout\/?$/.test(location.pathname.toLowerCase()))return;if(typeof window.jumpTo==="function")window.jumpTo("checkout");else{const section=document.getElementById("checkout");if(section){section.classList.add("active");section.style.display="block"}}window.refreshPrintifyCheckout()}
window.addEventListener("hashchange",openCheckoutFromHash);window.addEventListener("load",function(){setTimeout(openCheckoutFromHash,0)});window.refreshPrintifyCheckout();setTimeout(openCheckoutFromHash,0);
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
#checkout .pfy-page{width:min(1520px,calc(100% - 112px))!important;max-width:1520px!important;margin:0 auto!important}
#checkout .pfy-page-head{margin-bottom:18px!important}
@media(max-width:1260px){#checkout{padding-top:24px!important;padding-bottom:44px!important}#checkout .pfy-page{width:calc(100% - 44px)!important}}
@media(max-width:760px){#checkout{padding-top:22px!important;padding-bottom:38px!important}#checkout .pfy-page{width:calc(100% - 28px)!important}}
</style>
