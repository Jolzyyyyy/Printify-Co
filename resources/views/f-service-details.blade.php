<?php ?>
<!-- =========================================================
  PRINTIFY & CO. - SERVICE DETAIL + CART PANEL
  Clean full code version (kept under 800 lines)
  UI FIX MAP:
  1) Sidebar images gap/position: .pdv-left-card, .pdv-layout
  2) Equal card endpoints: --pdv-panel-h and .pdv-preview-card/.pdv-summary-card
  3) Only Preview and Order Summary have main frames
  4) Printing Details outer frame removed; fields/upload remain boxed
  5) Order Summary image enlarged: .pdv-summary-thumb
  6) Button widths equalized: .pdv-action-row button
========================================================= -->
<div class="pfy-cart-backdrop" id="pfyCartBackdrop"></div>
<aside class="pfy-cart-panel" id="pfyCartPanel" aria-label="Shopping cart">
  <div class="pfy-cart-head">
    <h2>Your Cart <span id="pfyCartCount">(0)</span></h2>
    <button type="button" class="pfy-cart-close" onclick="closePrintifyCart()" aria-label="Close cart">&times;</button>
  </div>
  <div class="pfy-select-bar">
    <label class="pfy-select-all"><input type="checkbox" id="pfyCartSelectAll" checked onchange="togglePrintifyCartSelectAll(this.checked)"><span id="pfyCartSelectedLabel">Select All</span></label>
    <button type="button" class="pfy-remove-all" id="pfyRemoveAllBtn" onclick="clearPrintifyCart()"><i class="fa-regular fa-trash-can"></i> Remove All</button>
  </div>
  <div class="pfy-items" id="pfyCartItems"></div>
  <div class="pfy-summary" id="pfyCartSummary">
    <div class="pfy-promo"><i class="fa-solid fa-tag"></i><input type="text" id="pfyPromoCode" placeholder="Enter promo code"><button type="button" onclick="applyPrintifyPromo()">Apply</button></div>
    <div class="pfy-row"><span id="pfySubtotalLabel">Subtotal</span><strong id="pfySubtotal">₱0.00</strong></div>
    <div class="pfy-row"><span>Shipping</span><span id="pfyShippingLabel">Calculated at checkout</span></div>
    <div class="pfy-row" id="pfyDiscountRow" style="display:none"><span>Discount</span><strong id="pfyDiscount">-₱0.00</strong></div>
    <div class="pfy-row pfy-total"><span>Total</span><strong id="pfyTotal">₱0.00</strong></div>
    <div class="pfy-secure-checkout">
      <button type="button" class="pfy-check" id="pfyCartCheckoutBtn" onclick="checkoutPrintifyCart()"><i class="fa-solid fa-lock"></i> Proceed to Checkout</button>
    </div>
  </div>
</aside>

<section id="serviceDetail" class="pdv-product-detail" aria-label="Service detail and checkout panel">
  <div class="pdv-shell">
    <div class="pdv-topbar">
      <nav class="pdv-breadcrumb" aria-label="Breadcrumb">
        <a href="/">Home</a><span><i class="fa-solid fa-chevron-right"></i></span>
        <a href="/services">Services</a><span><i class="fa-solid fa-chevron-right"></i></span>
        <a href="/services" id="pdvCrumbCategory">Document Printing</a><span><i class="fa-solid fa-chevron-right"></i></span>
        <a href="/service-details" id="pdvCrumbService" class="pdv-current-service">Text Only</a>
      </nav>
    </div>
    <div class="pdv-hero-row">
      <div class="pdv-service-intro"><h1 id="pdvTitle">Text Only Printing</h1><p id="pdvSubtitle">High-quality print services for clean, ready-to-submit output.</p></div>
      <div class="pdv-stepper" aria-label="Checkout progress" role="list">
        <div class="pdv-step is-active" data-step="1" role="listitem" aria-current="step"><span>1</span><p>Select Service</p></div><i></i>
        <div class="pdv-step" data-step="2" role="listitem"><span>2</span><p>Customize</p></div><i></i>
        <div class="pdv-step" data-step="3" role="listitem"><span>3</span><p>Upload File</p></div><i></i>
        <div class="pdv-step" data-step="4" role="listitem"><span>4</span><p>Checkout</p></div>
      </div>
    </div>
    <div class="pdv-layout">
      <aside class="pdv-left-card" data-pdv-section="select">
        <div class="pdv-thumb-stack" id="pdvThumbStack"></div>
        <button type="button" class="pdv-download-guide" onclick="downloadSampleGuide()"><i class="fa-solid fa-download"></i><span><strong>Download Print Guide</strong><small>Accepted file checklist</small></span></button>
      </aside>
      <main class="pdv-preview-card" data-pdv-section="preview">
        <header class="pdv-product-head"><h2>Preview</h2></header>
        <div class="pdv-preview-window"><button type="button" class="pdv-side-nav pdv-side-prev" onclick="pdvPrevPreview()" aria-label="Previous preview"><i class="fa-solid fa-chevron-left"></i></button><article class="pdv-document-preview" id="pdvPreviewDocument"></article><button type="button" class="pdv-side-nav pdv-side-next" onclick="pdvNextPreview()" aria-label="Next preview"><i class="fa-solid fa-chevron-right"></i></button></div>
        <div class="pdv-product-review-block"><div class="pdv-review-main-score"><span id="pdvStars">★★★★★</span><strong id="pdvRatingText">4.9</strong><em>/ 5</em></div><button type="button" class="pdv-review-link" id="pdvRatingBtn" onclick="pdvOpenReviews()"><span id="pdvReviewText">128 Reviews</span><small>View customer feedback</small></button></div>
      </main>
      <section class="pdv-options-card" aria-label="Printing options" data-pdv-section="customize">
        <div class="pdv-card-section">
          <h2><span>1.</span> Printing Details</h2>
          <div class="pdv-field-grid">
            <div class="pdv-field"><label>Printing Category</label><select id="pdvPrintingCategory" onchange="pdvHandleCategoryChange()"></select></div>
            <div class="pdv-field"><label>Color Variation</label><select id="pdvColorVariation" onchange="pdvUpdateOrder()"></select></div>
            <div class="pdv-field"><label>Paper Size</label><select id="pdvPaperSize" onchange="pdvUpdateOrder()"></select></div>
            <div class="pdv-field"><label>Quantity</label><div class="pdv-qty-box"><button type="button" onclick="pdvChangeQty(-1)">-</button><input type="text" id="pdvQty" value="" inputmode="numeric" maxlength="3" aria-label="Quantity" oninput="pdvHandleQtyInput()"><button type="button" onclick="pdvChangeQty(1)">+</button></div></div>
            <div class="pdv-field"><label>Service Option</label><select id="pdvServiceOption" onchange="pdvUpdateOrder()"><option value="standard">Standard Service</option><option value="priority">Priority Handling +₱15.00</option><option value="counter">Counter Pick-up Preparation +₱5.00</option></select></div>
            <div class="pdv-field"><label>File Type</label><select id="pdvFileType" onchange="pdvUpdateOrder()"><option value="pdf">PDF</option><option value="docx">DOC / DOCX</option><option value="image">JPG / PNG</option><option value="txt">TXT</option></select></div>
          </div>
        </div>
        <div class="pdv-divider"></div>
        <div class="pdv-card-section" data-pdv-section="upload">
          <h2><span>2.</span> Upload File</h2>
          <div class="pdv-upload-box" id="pdvUploadBox"><input type="file" id="pdvFileInput" hidden accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png"><div class="pdv-file-row"><button type="button" class="pdv-choose-file" onclick="document.getElementById('pdvFileInput').click()">Choose File</button><span class="pdv-no-file" id="pdvNoFileText">No file chosen</span></div><small>Required before checkout • Max 50MB</small></div>
          <div class="pdv-service-id-inline" id="pdvServiceIdInline" aria-label="Service ID"><i class="fa-regular fa-clipboard"></i><span>SERVICE ID</span><strong id="pdvServiceIdText">SRV-TXT-001</strong></div>
          <div class="pdv-file-result" id="pdvFileResult"><i class="fa-solid fa-file-circle-check"></i><span id="pdvFileName">No file selected</span><button type="button" onclick="pdvClearFile()">Remove</button></div>
          <div class="pdv-warning"><i class="fa-regular fa-hand"></i><span><strong>Reminder/Note</strong><small>Please review your uploaded file, layout, margins, and page order before checkout.</small></span></div>
        </div>
        <div class="pdv-divider"></div>
        <div class="pdv-card-section">
          <h2><span>3.</span> Service Add-ons <em>(Optional)</em></h2>
          <label class="pdv-addon"><input type="checkbox" id="pdvAddonDuplex" onchange="pdvUpdateOrder()"><span>Double-sided Printing</span><strong>+₱0.50 / sheet</strong><i class="fa-solid fa-circle-info"></i></label>
          <label class="pdv-addon"><input type="checkbox" id="pdvAddonStaple" onchange="pdvUpdateOrder()"><span>Collated & Stapled</span><strong>+₱1.00 / order</strong><i class="fa-solid fa-circle-info"></i></label>
          <label class="pdv-addon"><input type="checkbox" id="pdvAddonEnvelope" onchange="pdvUpdateOrder()"><span>Document Envelope</span><strong>+₱3.00 / order</strong><i class="fa-solid fa-circle-info"></i></label>
        </div>
      </section>
      <aside class="pdv-summary-card" aria-label="Order summary" data-pdv-section="checkout">
        <div class="pdv-summary-head"><h2>Order Summary</h2><button type="button" onclick="pdvFocusOptions()">Edit</button></div>
        <div class="pdv-summary-product"><div class="pdv-summary-thumb" id="pdvSummaryThumb"><span></span></div><div><h3 id="pdvSummaryTitle">Text Only Printing</h3><p id="pdvSummaryMeta">Short - Black and White</p><small id="pdvSummaryQty">1 sheet</small></div></div>
        <div class="pdv-summary-line"></div>
        <div class="pdv-price-grid">
          <button type="button" class="pdv-price-card is-active" id="pdvRetailPriceCard" onclick="pdvSelectPriceMode('retail')"><span class="pdv-price-label">Retail Price</span><strong class="pdv-price-medallion">₱<b id="pdvRetailPrice">2.00</b></strong><small>Best for regular quantity</small></button>
          <button type="button" class="pdv-price-card" id="pdvBulkPriceCard" onclick="pdvSelectPriceMode('bulk')"><span class="pdv-price-label">Bulk Price</span><strong class="pdv-price-medallion">₱<b id="pdvBulkPrice">1.50</b></strong><small id="pdvBulkHint">Click for 50+ sheets</small></button>
        </div>
        <div class="pdv-price-note" id="pdvPriceMode">Retail pricing applies below 50 sheets.</div>
        <div class="pdv-estimated-total"><span>Total Amount:</span><strong>₱<b id="pdvEstimatedTotal">2.00</b></strong></div>
        <div class="pdv-checkout-note" id="pdvCheckoutNote"><strong>Reminder/Note</strong><small>Checkout will be allowed only after a file is uploaded.</small></div>
        <div class="pdv-action-row"><button type="button" class="pdv-cart" id="pdvCartBtn" onclick="addToCart()">ADD TO CART</button><button type="button" class="pdv-checkout is-disabled" id="pdvCheckoutBtn" onclick="placeOrderNow()">CHECK OUT NOW</button></div>
      </aside>
    </div>
  </div>
  <aside class="pdv-review-panel" id="pdvReviewDrawer"><button type="button" class="pdv-review-close" onclick="pdvCloseReviews()"><i class="fa-solid fa-xmark"></i></button><small>Customer Reviews</small><h3 id="pdvReviewTitle">Text Only Printing</h3><div class="pdv-review-score"><span>★★★★★</span><strong id="pdvReviewAvg">4.9</strong><em id="pdvReviewCount">128 reviews</em></div><div class="pdv-review-bars" id="pdvReviewBars"></div><p>Ratings are used to help customers compare service quality before uploading and checking out.</p></aside>
  <div class="pdv-toast" id="pdvToast"></div>
</section>

<style>
:root{--pdv-orange:#ff4f16;--pdv-border:#e8e8e8;--pdv-text:#111;--pdv-muted:#676767;--pdv-soft:#fff6f0;--pdv-panel-h:540px;--pfy-orange:#ff5a12;--pfy-red:#ff2b1a}
*{box-sizing:border-box}
.cart-badge{position:absolute;top:13px;right:-8px;min-width:15px;height:15px;padding:0 4px;color:#fff;background:var(--pfy-orange);border-radius:999px;font:900 9px/1 Poppins,sans-serif;display:grid;place-items:center;box-shadow:0 5px 12px rgba(255,90,18,.28)}
body.guest-user .cart-badge{display:none!important}
body.auth-user .cart-badge{display:grid}

.pfy-cart-backdrop{position:fixed!important;inset:78px 0 0!important;z-index:1001!important;background:rgba(0,0,0,.035)!important;opacity:0;pointer-events:none;transition:opacity .22s ease}
.pfy-cart-backdrop.show{opacity:1;pointer-events:auto}
.pfy-cart-panel{--pfy-pointer-right:142px;position:fixed!important;top:82px!important;right:clamp(16px,2.2vw,38px)!important;z-index:1002!important;width:378px!important;max-width:calc(100vw - 32px)!important;max-height:calc(100vh - 102px)!important;display:flex;flex-direction:column;overflow:visible;background:#fff;border:1px solid #ececec;border-radius:16px;box-shadow:0 22px 55px rgba(0,0,0,.14);font-family:Poppins,Arial,sans-serif;transform:translateY(-16px) scale(.985);transform-origin:top right;opacity:0;pointer-events:none;will-change:transform,opacity;transition:opacity .22s ease,transform .22s cubic-bezier(.22,.8,.24,1)}
.pfy-cart-panel.show{opacity:1;pointer-events:auto;transform:translateY(0) scale(1)}
.pfy-cart-panel:before{content:"";position:absolute;top:-8px;right:var(--pfy-pointer-right);width:15px;height:15px;background:#fff;border-left:1px solid #ececec;border-top:1px solid #ececec;border-radius:3px 0 0 0;transform:rotate(45deg);transition:right .18s ease}

.pfy-cart-head{display:flex;align-items:center;justify-content:space-between;padding:15px 17px 6px;background:#fff;border-radius:16px 16px 0 0}
.pfy-cart-head h2{margin:0;color:#111;font-size:16.5px;line-height:1.15;font-weight:700}
.pfy-cart-head span{color:var(--pfy-orange)}
.pfy-cart-close{width:25px;height:25px;border:0;border-radius:50%;background:#fff;color:#222;font-size:20px;line-height:25px;display:grid;place-items:center;cursor:pointer}
.pfy-cart-close:hover{background:#f7f7f7;color:var(--pfy-orange)}

.pfy-free-shipping{padding:0 17px 11px}
.pfy-free-copy{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:0 0 7px;color:#6f6f6f;font-size:10px;line-height:1.35}
.pfy-free-copy strong{color:var(--pfy-orange);font-weight:600}
.pfy-free-copy i{color:#333;font-size:13px}
.pfy-free-track{height:5px;border-radius:999px;background:#eee;overflow:hidden}
.pfy-free-track i{display:block;height:100%;width:0%;border-radius:999px;background:#ff5a12;transition:.24s}
.pfy-select-bar{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:8px 17px;border-top:1px solid #f0f0f0;border-bottom:1px solid #f0f0f0;background:#fff}
.pfy-select-all{display:inline-flex;align-items:center;gap:6px;color:#222;font:400 10.5px/1.2 Poppins,sans-serif;cursor:pointer}
.pfy-remove-all{border:0;background:transparent;color:#4e4e4e;font-size:10.2px;font-weight:400;display:inline-flex;align-items:center;gap:5px;cursor:pointer;padding:3px 0}
.pfy-remove-all:hover{color:var(--pfy-orange)}

.pfy-select-all input,.pfy-check-wrap input{appearance:none;-webkit-appearance:none;position:relative;width:10px;height:10px;min-width:10px;border:1.1px solid #d7d7d7;border-radius:3px;background:#fff;cursor:pointer;display:block;transition:border-color .15s,background .15s,box-shadow .15s}.pfy-select-all input:focus-visible,.pfy-check-wrap input:focus-visible{outline:0;box-shadow:0 0 0 3px rgba(255,90,18,.14)}
.pfy-select-all input:checked,.pfy-check-wrap input:checked,.pfy-select-all input:indeterminate{border-color:#ff5a12;background:#ff5a12}
.pfy-select-all input:checked:before,.pfy-check-wrap input:checked:before{content:"";position:absolute;left:50%;top:47%;width:3px;height:6px;border-right:1.35px solid #fff;border-bottom:1.35px solid #fff;transform:translate(-50%,-55%) rotate(45deg)}
.pfy-select-all input:indeterminate:before{content:"";position:absolute;left:50%;top:50%;width:6px;height:1.4px;background:#fff;transform:translate(-50%,-50%)}

.pfy-items{flex:1 1 auto;max-height:min(286px,37vh);overflow:auto;padding:0 17px;background:#fff;scrollbar-width:thin;scrollbar-color:#ffbd9e #f7f7f7}
.pfy-items::-webkit-scrollbar{width:6px}
.pfy-items::-webkit-scrollbar-thumb{background:#ffbd9e;border-radius:999px}
.pfy-items.is-empty{min-height:178px;max-height:178px;display:flex;align-items:center;justify-content:center;padding:0 17px;overflow:hidden!important}
.pfy-item{display:grid;grid-template-columns:20px 44px minmax(0,1fr) 62px 18px;align-items:start;column-gap:8px;padding:12px 0;border-bottom:1px solid #eee;background:#fff}
.pfy-check-wrap{display:flex;align-items:flex-start;justify-content:center;padding-top:15px;width:20px;height:44px;cursor:pointer}
.pfy-img,.pfy-noimg{width:44px;height:44px;border:0;border-radius:8px;background:#fff1ea;object-fit:cover;box-shadow:inset 0 0 0 1px rgba(255,90,18,.08)}
.pfy-noimg{display:grid;place-items:center;color:#4a4a4a;font-size:17px}
.pfy-info{min-width:0}
.pfy-info h3{margin:0 0 2px;color:#111;font-size:11px;line-height:1.22;font-weight:600}
.pfy-info p{margin:0 0 1px;color:#666;font-size:9.4px;line-height:1.28;font-weight:400;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.pfy-price{display:none}
.pfy-file-required{display:inline-flex!important;gap:4px;margin-top:2px;color:var(--pfy-orange)!important;font-size:8.8px!important;font-weight:500!important}
.pfy-bottom{display:flex;margin-top:7px}
.pfy-qty{width:76px;height:24px;display:grid;grid-template-columns:23px 30px 23px;border:1px solid #e7e7e7;border-radius:7px;background:#fff;overflow:hidden}
.pfy-qty button{width:23px;height:24px;border:0;background:#fff;color:#111;font-size:11px;cursor:pointer}
.pfy-qty button:hover{background:#fff4ee;color:var(--pfy-orange)}
.pfy-qty span{width:30px;height:24px;display:grid;place-items:center;color:#111;font-size:10.7px;font-weight:600;border-left:1px solid #f1f1f1;border-right:1px solid #f1f1f1}
.pfy-line{min-width:62px;width:62px;align-self:end;justify-self:end;margin:0 0 3px;color:#111;font-size:10.8px;font-weight:600;text-align:right;white-space:nowrap}
.pfy-remove{justify-self:end;width:18px;height:18px;border:0;border-radius:50%;background:#fff;color:#777;font-size:10px;display:grid;place-items:center;cursor:pointer}
.pfy-remove:hover{background:#fff3ec;color:var(--pfy-orange)}

.pfy-summary{flex:0 0 auto;padding:12px 17px 16px;background:#fff;border-top:1px solid #f0f0f0;border-radius:0 0 16px 16px}
.pfy-promo{display:grid!important;grid-template-columns:18px minmax(0,1fr) 70px!important;gap:7px;align-items:center;margin:0 0 10px;width:100%}
.pfy-promo>i{width:18px;height:34px;display:grid;place-items:center;font-size:12px}
.pfy-promo input,.pfy-promo button{height:34px;border-radius:7px;line-height:34px}
.pfy-promo input{min-width:0;width:100%;border:1px solid #e4e4e4;padding:0 10px;font:400 10.2px Poppins,sans-serif;color:#333;background:#fff}
.pfy-promo input:focus{border-color:#ff9a73;box-shadow:0 0 0 3px rgba(255,90,18,.10);outline:0}
.pfy-promo button{width:70px;border:1px solid #ffc8b1;background:#fff7f1;color:var(--pfy-orange);font-size:9.5px;font-weight:600;display:grid;place-items:center;cursor:pointer;transition:background .18s,color .18s,border-color .18s}
.pfy-promo button:hover{background:var(--pfy-orange);border-color:var(--pfy-orange);color:#fff}
.pfy-row{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:0 0 5px;color:#222;font-size:10.6px;font-weight:400;line-height:1.35}
.pfy-row strong{color:#111;font-weight:600}
.pfy-row #pfyShippingLabel,#pfyShippingLabel.is-free{color:#13a352;font-weight:500}
.pfy-total{margin-top:10px;padding-top:11px;border-top:1px solid #eee;font-size:15.5px;font-weight:600}
.pfy-total strong{color:var(--pfy-orange);font-size:18px;font-weight:700}
.pfy-upload-alert{align-items:flex-start;gap:7px;margin:9px 0;padding:8px 10px;border:1px dashed #ffc6aa;background:#fff8f4;border-radius:9px;color:#d84a15;font-size:10px}
.pfy-secure-checkout{display:flex;align-items:center;justify-content:space-between;gap:9px;margin-top:13px}
.pfy-secure-copy{display:flex;align-items:center;gap:8px;color:#111}
.pfy-secure-copy i{font-size:14px}
.pfy-secure-copy span{display:flex;flex-direction:column}
.pfy-secure-copy strong{font-size:9.8px;font-weight:600}
.pfy-secure-copy small{color:#777;font-size:8.5px}
.pfy-check{width:156px;min-width:156px;height:38px;border:0;border-radius:9px;background:#ff5a12;color:#fff;font:600 10.5px Poppins,sans-serif;display:flex;align-items:center;justify-content:center;gap:7px;box-shadow:0 10px 20px rgba(255,90,18,.18);cursor:pointer;transition:background .18s}
.pfy-check:hover{background:var(--pfy-red)}
.pfy-check.is-disabled{background:#cfcfcf;box-shadow:none;cursor:not-allowed}
.pfy-check.is-disabled:hover{background:#cfcfcf}
.pfy-empty{width:100%;padding:28px 18px;text-align:center;color:#606060;border:1px dashed #ffcdb9;border-radius:12px;background:#fff}
.pfy-empty i{font-size:34px;color:var(--pfy-orange);margin-bottom:9px}
.pfy-empty h3{margin:0 0 5px;color:#111;font-size:15px;font-weight:600}
.pfy-empty p{margin:0;font-size:11px;color:#777}

/* Cart drawer content skin - keeps existing drawer size and cart-icon pointer */
.pfy-cart-panel{border-color:#e8e8e8;border-radius:18px;box-shadow:0 24px 60px rgba(15,23,42,.16)}
.pfy-cart-panel:before{border-color:#e8e8e8}
.pfy-cart-head{padding:22px 24px 9px;border-radius:18px 18px 0 0}
.pfy-cart-head h2{font-size:21px!important;font-weight:800!important;letter-spacing:-.02em!important}
.pfy-cart-head span{color:#ff4f16!important}
.pfy-cart-close{font-size:26px;color:#111;background:transparent}
.pfy-cart-close:hover{background:transparent;color:#ff4f16}
.pfy-free-shipping{padding:0 24px 16px}
.pfy-free-copy{font-size:12px;color:#555;margin-bottom:9px}
.pfy-free-copy strong{color:#ff4f16;font-weight:800}
.pfy-free-copy i{color:#111}
.pfy-free-track{height:7px;background:#eeeeee}
.pfy-free-track i{background:#ff4f16}
.pfy-select-bar{padding:12px 24px;border:0}
.pfy-select-all{font-size:12px;color:#333}
.pfy-remove-all{font-size:11.5px;color:#555}
.pfy-select-all input,.pfy-check-wrap input{width:15px;height:15px;min-width:15px;border-radius:4px}
.pfy-select-all input:checked:before,.pfy-check-wrap input:checked:before{width:4px;height:8px;border-width:1.7px}
.pfy-items{padding:0 24px;max-height:min(292px,37vh)}
.pfy-item{grid-template-columns:20px 58px minmax(0,1fr) 70px 20px;column-gap:10px;margin:0 0 14px;padding:16px;border:1px solid #e7e7e7;border-radius:12px;background:#fff;box-shadow:0 12px 30px rgba(15,23,42,.045)}
.pfy-check-wrap{padding-top:10px;height:auto}
.pfy-img,.pfy-noimg{width:58px;height:58px;border-radius:10px;background:#fff3ed;color:#ff4f16;box-shadow:none}
.pfy-noimg{font-size:22px}
.pfy-info h3{font-size:13px;font-weight:800;margin-bottom:4px}
.pfy-info p{font-size:10.6px;color:#555;line-height:1.35;white-space:normal}
.pfy-bottom{margin-top:10px}
.pfy-qty{width:84px;height:28px;grid-template-columns:26px 32px 26px;border-radius:8px}
.pfy-qty button,.pfy-qty span{height:28px}
.pfy-qty button{width:26px;font-size:13px}
.pfy-qty span{width:32px;font-size:12px;font-weight:800}
.pfy-line{align-self:end;margin-bottom:8px;font-size:12px;font-weight:800}
.pfy-remove{width:20px;height:20px;color:#555;background:transparent}
.pfy-summary{padding:10px 24px 20px;border-top:0;border-radius:0 0 18px 18px}
.pfy-promo{grid-template-columns:24px minmax(0,1fr) 78px!important;gap:10px;margin:0 0 13px;padding:12px;border:1px solid #e8e8e8;border-radius:12px;background:#fff}
.pfy-promo>i{height:34px;font-size:14px;color:#111}
.pfy-promo input{height:36px;border-radius:8px;font-size:11px}
.pfy-promo button{width:78px;height:36px;border-radius:8px;background:#fff6f1;border-color:#ffd5c4;color:#ff4f16;font-size:11px;font-weight:800}
.pfy-row{font-size:12px;margin-bottom:9px;color:#333}
.pfy-row strong{font-weight:800}
.pfy-row #pfyShippingLabel,#pfyShippingLabel.is-free{color:#16a34a!important;font-weight:800!important}
.pfy-total{margin:13px 0 10px;padding:14px 16px;border:0;border-radius:7px;background:#171717;color:#fff;font-size:18px}
.pfy-total span{color:#fff}
.pfy-total strong{color:#ff4f16!important;font-size:20px;font-weight:900}
.pfy-reward{display:flex;align-items:center;gap:8px;margin:0 0 12px;color:#555;font-size:11px}
.pfy-reward i{color:#ffae24}
.pfy-secure-checkout{display:grid;grid-template-columns:1fr;gap:12px;margin-top:10px}
.pfy-secure-copy{min-height:48px;padding:10px 12px;border-radius:10px;background:#f7f7f7;justify-content:space-between}
.pfy-secure-copy i{width:28px;height:28px;border:1px solid #111;border-radius:50%;display:grid;place-items:center;font-size:14px;order:2}
.pfy-secure-copy strong{font-size:12px;font-weight:800}
.pfy-secure-copy small{font-size:10.2px;color:#666}
.pfy-check{width:100%;min-width:0;height:44px;border-radius:10px;background:#ff4f16;color:#fff;font-size:13px;font-weight:800;box-shadow:none}
.pfy-check:hover{background:#111827;color:#fff}
.pfy-check.is-disabled,.pfy-check.is-disabled:hover{background:#cfcfcf;color:#fff}
.pfy-terms{margin:2px 4px 0;color:#666;text-align:center;font-size:10.2px;line-height:1.45}
.pfy-terms a{color:#ff4f16;font-weight:800;text-decoration:none}

#serviceDetail,#serviceDetail *{box-sizing:border-box}
#serviceDetail{display:none;width:100%;background:#fff;color:var(--pdv-text);font-family:Poppins,Arial,sans-serif;padding:18px 0 32px;scroll-margin-top:82px;overflow-x:hidden}
#serviceDetail.pdv-is-open{display:block}
body.front-route-service-details #serviceDetail{display:block}
.pdv-shell{width:min(1450px,calc(100% - 46px));margin:0 auto}
.pdv-topbar{margin:0 0 12px}
.pdv-breadcrumb{display:flex;align-items:center;gap:12px;flex-wrap:wrap;color:#6d6d6d;font-size:13px;font-weight:500;line-height:1.2}
.pdv-breadcrumb a{color:#5f6670;text-decoration:none}
.pdv-breadcrumb span{color:#9ca1a7;font-size:9px}
.pdv-breadcrumb strong{color:#111;font-weight:700}
.pdv-breadcrumb a.pdv-current-service{color:#ff7a00!important;border-bottom:3px solid #ff7a00;text-decoration:none;padding-bottom:3px;font-weight:700}
.pdv-hero-row{display:grid;grid-template-columns:minmax(280px,1fr) minmax(560px,760px);align-items:end;gap:18px;margin:7px 0 23px}
.pdv-service-intro h1{margin:0 0 7px;color:#111;font:800 31px/1.08 Poppins,Arial,sans-serif;letter-spacing:-.035em}
.pdv-service-intro p{margin:0;color:#5f6368;font-size:14px;line-height:1.45}
.pdv-stepper{display:grid;grid-template-columns:auto 1fr auto 1fr auto 1fr auto;gap:10px;align-items:center;width:100%;margin-bottom:4px}
.pdv-step{display:flex;align-items:center;gap:10px;color:#787b80;font-size:12px;font-weight:500;white-space:nowrap}
.pdv-step span{width:32px;height:32px;border-radius:50%;background:#6f7176;color:#fff;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 16px rgba(0,0,0,.12);font-size:12px;font-weight:800}
.pdv-step p{margin:0;line-height:32px}
.pdv-stepper>i{height:1px;border-top:2px dotted #cfcfcf}
.pdv-step.is-active,.pdv-step.is-done{color:var(--pdv-orange);font-weight:700}
.pdv-step.is-active span,.pdv-step.is-done span{background:var(--pdv-orange)}

.pdv-layout{display:grid;grid-template-columns:130px minmax(455px,1.28fr) 355px 300px;column-gap:18px;row-gap:16px;align-items:stretch}
.pdv-left-card,.pdv-options-card{min-height:var(--pdv-panel-h);background:transparent!important;border:0!important;box-shadow:none!important;border-radius:0!important}
.pdv-preview-card,.pdv-summary-card{min-height:var(--pdv-panel-h);border:1px solid var(--pdv-border);border-radius:10px;background:#fff;box-shadow:0 15px 34px rgba(0,0,0,.035)}
.pdv-left-card{padding:0;margin-left:-14px;margin-right:27px;display:flex;flex-direction:column}
.pdv-thumb-stack{display:flex;flex-direction:column;gap:16px}
.pdv-thumb{width:100%;min-height:102px;border:1px solid #e2e2e2;background:#fff;border-radius:9px;cursor:pointer;padding:10px 8px;display:flex;flex-direction:column;align-items:center;justify-content:space-between;color:#111;transition:.2s;overflow:hidden}
.pdv-thumb:hover{transform:translateY(-1px);border-color:#ffb89b;box-shadow:0 12px 22px rgba(255,79,22,.10)}
.pdv-thumb.is-active{border:2px solid var(--pdv-orange);background:#fffaf7;box-shadow:none}
.pdv-thumb strong{font-size:10.5px;line-height:1.15;font-weight:800;text-align:center}
.pdv-thumb.is-active strong{color:var(--pdv-orange)}
.pdv-thumb-paper{width:48px;height:66px;background:#fff;border:1px solid #dedede;box-shadow:0 8px 18px rgba(0,0,0,.10);padding:7px 5px;display:block;overflow:hidden}
.pdv-thumb-paper b{display:block;width:100%;height:5px;border-radius:9px;background:#232323;margin-bottom:5px}
.pdv-thumb-paper i,.pdv-thumb-paper em{display:block;height:4px;border-radius:8px;background:#b7b7b7;margin-bottom:4px}
.pdv-thumb.has-real-thumb{padding:0;background:transparent}
.pdv-thumb.has-real-thumb strong{width:100%;padding:7px 3px 8px;background:#fff}
.pdv-thumb-paper.is-real-thumb{width:100%;height:auto;padding:0;background:transparent;border:0;box-shadow:none;line-height:0}
.pdv-thumb-real-img{width:100%;height:auto;max-height:96px;object-fit:contain;display:block}
.pdv-download-guide{height:54px;margin-top:14px;border:1px solid #f5ddcf;background:#fff7f1;border-radius:9px;display:flex;align-items:center;gap:9px;padding:0 10px;cursor:pointer;color:#111;text-align:left}
.pdv-download-guide i{font-size:18px;color:var(--pdv-orange)}
.pdv-download-guide strong{display:block;font-size:10.5px}
.pdv-download-guide small{display:block;font-size:9px;color:#6a6a6a;line-height:1.35}

.pdv-preview-card{padding:18px 18px 24px;display:flex;flex-direction:column;align-items:stretch;justify-content:flex-start;overflow:hidden}
.pdv-product-head{margin:0 0 12px}
.pdv-product-head h2{margin:0;color:#111;font-size:18px;font-weight:800}
.pdv-preview-window{flex:1;min-height:385px;display:flex;align-items:center;justify-content:center;position:relative}
.pdv-side-next{display:none}
.pdv-document-preview{width:min(390px,92%);aspect-ratio:8.5/11;background:#fff;box-shadow:0 15px 38px rgba(0,0,0,.15);padding:34px;color:#111;transition:.18s}
.pdv-document-preview h4{font-family:Georgia,serif;text-align:center;margin:0 0 26px;font-size:13px;line-height:1.25}
.pdv-document-preview p{font-family:Georgia,serif;font-size:11px;line-height:1.55;margin:0 0 19px}
.pdv-document-preview.is-real-image-preview{width:auto;max-width:95%;aspect-ratio:auto;padding:0;background:transparent;box-shadow:0 15px 38px rgba(0,0,0,.12);line-height:0}
.pdv-real-preview-img{max-height:420px;max-width:100%;object-fit:contain;display:block}
.pdv-image-missing{width:100%;height:100%;padding:26px 24px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;border:1px dashed #ff9f79;background:#fff8f3;color:#111}
.pdv-image-missing i{font-size:28px;color:var(--pdv-orange);margin-bottom:12px}
.pdv-product-review-block{width:100%;margin:16px auto 0;border:1px solid #ffe3d5;background:#fffaf7;border-radius:12px;padding:10px 13px;display:flex;align-items:center;justify-content:space-between;gap:10px}
.pdv-review-main-score{display:flex;align-items:baseline;gap:6px;white-space:nowrap}
.pdv-review-main-score span{color:#ffb400;font-size:12px;letter-spacing:1px}
.pdv-review-main-score strong{font-size:24px;font-weight:900}
.pdv-review-main-score em{font-style:normal;color:#8f6c20;font-size:10px;font-weight:800}
.pdv-review-link{border:0;background:transparent;padding:0;text-align:right;cursor:pointer;font-family:Poppins,sans-serif}
.pdv-review-link span{display:block;color:#111;font-size:11px;font-weight:900;text-decoration:underline}
.pdv-review-link small{display:block;margin-top:3px;color:var(--pdv-orange);font-size:10px;font-weight:700}

.pdv-options-card{padding:0 2px}
.pdv-card-section h2{margin:0 0 11px;color:#111;font-size:16px;line-height:1.1;font-weight:700}
.pdv-card-section h2 span{margin-right:10px}
.pdv-card-section h2 em{color:#999;font-size:11px;font-style:normal;font-weight:500}
.pdv-field-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));column-gap:8px;row-gap:9px}
.pdv-field label{display:block;margin:0 0 5px;color:#111;font-size:10px;line-height:1.15;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.pdv-field select,.pdv-qty-box{width:100%;height:34px;border:1px solid #e4e4e4;border-radius:8px;background:#fff;color:#111;outline:none;font-family:Poppins,sans-serif;font-size:10px;font-weight:400;transition:border-color .18s,box-shadow .18s,background .18s}
.pdv-field select{padding:0 10px;cursor:pointer}
.pdv-field select:hover,.pdv-qty-box:hover{border-color:#ffbea5}.pdv-field select:focus,.pdv-qty-box:focus-within{border-color:#ff8c63;box-shadow:0 0 0 3px rgba(255,79,22,.10)}
.pdv-qty-box{display:grid;grid-template-columns:30px 1fr 30px;overflow:hidden}
.pdv-qty-box button{border:0;background:#fff;color:#111;cursor:pointer;font-size:11px;font-weight:700;transition:background .18s,color .18s}
.pdv-qty-box button:hover{background:var(--pdv-orange);color:#fff}
.pdv-qty-box input{width:100%;border:0;border-left:1px solid #eee;border-right:1px solid #eee;text-align:center;color:#111;font-size:11px;font-weight:600;outline:none;font-family:Poppins,sans-serif;background:#fff}
.pdv-qty-box input::-webkit-outer-spin-button,.pdv-qty-box input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
.pdv-qty-box input[type=number]{-moz-appearance:textfield}
.pdv-divider{height:1px;background:#e8e8e8;margin:12px 0}
.pdv-upload-box{width:100%;max-width:348px;min-height:58px;border:1px solid #e4e4e4;border-radius:8px;background:#fff;display:grid;grid-template-columns:32px minmax(0,1fr) auto;align-items:center;gap:8px;text-align:left;padding:8px 9px;transition:border-color .18s,box-shadow .18s,background .18s}
.pdv-upload-box:hover,.pdv-upload-box.is-dragging{border-color:#ff9a73;background:#fff;box-shadow:0 0 0 3px rgba(255,79,22,.08)}
.pdv-upload-icon{width:30px;height:30px;border:0;background:#fff6f0;border-radius:50%;color:var(--pdv-orange);font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center}
.pdv-upload-copy{min-width:0}
.pdv-upload-box strong{display:block;color:#111;font-size:10.5px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.pdv-upload-box span{display:block;color:#777;font-size:8.8px;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.pdv-choose-file{height:28px;min-width:86px;border:0;border-radius:7px;background:var(--pdv-orange);color:#fff;cursor:pointer;font-family:Poppins,sans-serif;font-size:9.3px;font-weight:700;transition:background .18s}
.pdv-choose-file:hover{background:var(--pdv-red,#ff2b1a)}
.pdv-upload-box small{grid-column:2/4;margin-top:-2px;color:#9a9a9a;font-size:8.4px}
.pdv-file-result{display:none;align-items:center;gap:8px;min-height:32px;margin-top:8px;padding:7px 9px;background:#f7fff9;border:1px solid #ccefd5;border-radius:8px;color:#1c8543;font-size:10px;font-weight:800}
.pdv-file-result.is-visible{display:flex}
.pdv-file-result span{min-width:0;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.pdv-file-result button{border:0;background:transparent;color:#d23d19;cursor:pointer;font-size:9.8px;font-weight:900}
.pdv-warning{margin-top:8px;display:flex;gap:8px;align-items:flex-start;background:#fff6f0;border-radius:7px;padding:8px 10px;color:#111}
.pdv-warning i{width:21px;height:21px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--pdv-orange);background:#fff;flex:0 0 auto}
.pdv-warning strong{display:block;font-size:10px;font-weight:700}
.pdv-warning small{display:block;color:#777;font-size:8.9px;line-height:1.3}
.pdv-addon{display:grid;grid-template-columns:16px 1fr auto 15px;align-items:center;gap:7px;margin-top:8px;color:#444;cursor:pointer;font-size:10.5px}
.pdv-addon input{width:14px;height:14px;accent-color:var(--pdv-orange)}
.pdv-addon span{font-weight:500}
.pdv-addon strong{color:#111;font-size:9.5px;font-weight:700}
.pdv-addon i{color:#bbb;font-size:11px}

.pdv-summary-card{padding:17px 16px;display:flex;flex-direction:column;justify-content:flex-start}
.pdv-summary-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
.pdv-summary-head h2{margin:0;color:#111;font-size:16px;font-weight:700}
.pdv-summary-head button{width:44px;height:25px;border:1px solid #ffb89b;border-radius:7px;background:#fff;color:var(--pdv-orange);cursor:pointer;font-size:10px;font-weight:600}
.pdv-summary-product{display:grid;grid-template-columns:64px minmax(0,1fr);gap:12px;align-items:start}
.pdv-summary-thumb{width:64px;height:82px;border:1px solid #ededed;background:#fbfbfb;box-shadow:0 8px 18px rgba(0,0,0,.06);padding:7px;overflow:hidden}
.pdv-summary-thumb.is-real-summary{padding:0;background:transparent;line-height:0}
.pdv-summary-real-img{width:100%;height:100%;max-height:82px;object-fit:contain;display:block}
.pdv-summary-thumb span,.pdv-summary-thumb span:before,.pdv-summary-thumb span:after{display:block;content:"";border-radius:9px;background:#bdbdbd}
.pdv-summary-thumb span{height:5px;width:72%;margin-bottom:7px}
.pdv-summary-thumb span:before{height:4px;width:120%;margin-top:11px}
.pdv-summary-thumb span:after{height:4px;width:100%;margin-top:8px}
.pdv-summary-product h3{margin:1px 0 5px;color:#111;font-size:11.8px;line-height:1.25;font-weight:600}
.pdv-summary-product p,.pdv-summary-product small{display:block;margin:0 0 3px;color:#555;font-size:9.7px;line-height:1.25}
.pdv-summary-line{height:1px;background:#e8e8e8;margin:11px 0}
.pdv-price-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin:0 0 9px}
.pdv-price-card{min-height:66px;border:1px solid #e6e6e6;border-radius:8px;background:#fff;padding:9px 10px;text-align:left;cursor:pointer;font-family:Poppins,sans-serif}
.pdv-price-card.is-active{border-color:#ffc8b1;background:#fff7f1}
.pdv-price-label{display:block;color:#111;font-size:9.2px;font-weight:600}
.pdv-price-card.is-active .pdv-price-label{color:var(--pdv-orange)}
.pdv-price-medallion{display:block;margin:4px 0 3px;color:#111;font-size:13px;line-height:1;font-weight:700}
.pdv-price-medallion b{font-size:14px}
.pdv-price-card.is-active .pdv-price-medallion{color:var(--pdv-orange)}
.pdv-price-card small{display:block;color:#666;font-size:8.4px;line-height:1.18}
.pdv-price-note{background:#f7f7f7;border:0;border-radius:7px;padding:8px 9px;color:#6a6a6a;font-size:9.5px;line-height:1.32;margin-bottom:9px}
.pdv-estimated-total{display:flex;align-items:center;justify-content:space-between;background:#fff6f0;border:0;border-radius:0;padding:9px 10px;color:#111;font-size:11px;font-weight:600;margin-bottom:10px}
.pdv-estimated-total strong{color:var(--pdv-orange);font-size:16px}
.pdv-checkout-note{background:#fff6f0;border-radius:8px;padding:8px 9px 8px 34px;margin-bottom:10px;position:relative}
.pdv-checkout-note:before{content:"\f133";font-family:"Font Awesome 6 Free";font-weight:900;position:absolute;left:11px;top:10px;color:var(--pdv-orange)}
.pdv-checkout-note strong{display:block;color:#111;font-size:10px;font-weight:700;margin-bottom:2px}
.pdv-checkout-note small{display:block;color:#777;font-size:8.8px;line-height:1.3}
.pdv-action-row{display:grid;grid-template-columns:1fr;gap:8px;margin-top:auto;justify-items:center}
.pdv-cart,.pdv-checkout{width:232px!important;max-width:100%;height:37px;border:0;border-radius:7px;cursor:pointer;font-family:Poppins,sans-serif;font-size:11px;font-weight:700;background:var(--pdv-orange);color:#fff;box-shadow:none;transition:background .18s,opacity .18s}
.pdv-cart:hover,.pdv-checkout:hover{background:#ff2b1a}
.pdv-checkout:disabled,.pdv-checkout.is-disabled{background:#cfcfcf;color:#fff;opacity:1;cursor:not-allowed}
.pdv-checkout:disabled:hover,.pdv-checkout.is-disabled:hover{background:#cfcfcf}

.pdv-review-panel{display:none;width:min(520px,calc(100% - 56px));margin:16px auto 0;background:#fff;border:1px solid #ffe0b5;border-radius:16px;box-shadow:0 18px 48px rgba(0,0,0,.10);padding:18px;position:relative}
.pdv-review-panel.is-visible{display:block}
.pdv-review-close{position:absolute;right:12px;top:12px;width:30px;height:30px;border:0;border-radius:50%;background:#fff3ec;color:#d74814;cursor:pointer}
.pdv-review-panel>small{display:block;color:var(--pdv-orange);font-size:10px;font-weight:900;text-transform:uppercase}
.pdv-review-panel h3{margin:4px 34px 9px 0;font-size:16px}
.pdv-review-score{display:flex;align-items:center;gap:8px;background:#fff9e9;border:1px solid #ffe3a6;border-radius:11px;padding:10px;margin-bottom:12px}
.pdv-review-score span{color:#ffb400;letter-spacing:1px;font-size:12px}
.pdv-review-score strong{font-size:22px}
.pdv-review-score em{font-style:normal;color:#805f12;font-size:11px;font-weight:800}
.pdv-review-bar{display:grid;grid-template-columns:44px 1fr 36px;align-items:center;gap:8px;margin:8px 0;font-size:10px;color:#555;font-weight:800}
.pdv-review-track{height:7px;border-radius:99px;background:#f0f0f0;overflow:hidden}
.pdv-review-fill{height:100%;border-radius:99px;background:#ffb400}
.pdv-review-panel p{margin:12px 0 0;color:#777;font-size:10.5px;line-height:1.45}
.pdv-toast{position:fixed;right:28px;bottom:28px;min-width:260px;max-width:360px;transform:translateY(24px);opacity:0;pointer-events:none;border-radius:12px;background:#151515;color:#fff;padding:14px 16px;font-size:12px;line-height:1.45;box-shadow:0 18px 55px rgba(0,0,0,.22);z-index:999999;transition:.25s}
.pdv-toast.is-visible{transform:translateY(0);opacity:1}

@media(max-width:1500px){:root{--pdv-panel-h:520px}
.pdv-shell{width:calc(100% - 30px)}
.pdv-layout{grid-template-columns:126px minmax(420px,1.25fr) 325px 280px;column-gap:12px}
.pdv-left-card{margin-left:-12px;margin-right:22px}
.pdv-preview-window{min-height:370px}
.pdv-real-preview-img{max-height:405px}
.pdv-field-grid{column-gap:8px;row-gap:8px}
.pdv-summary-product{grid-template-columns:60px minmax(0,1fr)}
.pdv-summary-thumb{width:60px;height:78px}
.pdv-summary-real-img{max-height:78px}
}

@media(max-width:1250px){.pdv-hero-row{grid-template-columns:1fr}
.pdv-stepper{max-width:900px}
.pdv-layout{grid-template-columns:170px minmax(0,1fr);gap:14px}
.pdv-left-card{margin:0}
.pdv-options-card,.pdv-summary-card{min-height:auto}
.pdv-preview-card{min-height:520px}
.pdv-summary-card{padding-bottom:18px}
}

@media(max-width:850px){.pdv-shell{width:calc(100% - 22px)}
.pdv-stepper{grid-template-columns:1fr 1fr;gap:9px}
.pdv-stepper>i{display:none}
.pdv-step{justify-content:flex-start;border:1px solid #eee;border-radius:999px;padding:8px 10px;background:#fff}
.pdv-step span{width:28px;height:28px;font-size:12px}
.pdv-step p{line-height:28px;font-size:12px}
.pdv-layout{grid-template-columns:1fr;gap:12px}
.pdv-thumb-stack{display:grid;grid-template-columns:repeat(3,1fr)}
.pdv-field-grid{grid-template-columns:1fr}
.pdv-upload-box{grid-template-columns:32px 1fr}
.pdv-choose-file{grid-column:1/3;width:100%}
.pdv-upload-box small{grid-column:1/3}
.pdv-price-grid{grid-template-columns:1fr}
.pfy-cart-panel{left:12px!important;right:12px!important;width:auto!important;--pfy-pointer-right:72px}
.pfy-secure-checkout{display:grid;grid-template-columns:1fr}
}

@media(max-width:430px){.pdv-thumb-stack{grid-template-columns:1fr}
.pfy-item{grid-template-columns:10px 44px minmax(0,1fr) 18px;column-gap:8px}
.pfy-img,.pfy-noimg{width:44px;height:44px}
.pfy-line{grid-column:3;grid-row:1;width:auto;min-width:0;margin:40px 0 0;justify-self:start;text-align:left}
.pfy-remove{grid-column:4;grid-row:1}
}

.pfy-cart-panel .pfy-promo>*{min-width:0!important;max-width:100%}
.pfy-cart-panel .pfy-promo>i{grid-column:1!important;grid-row:1!important}
.pfy-cart-panel .pfy-promo input{grid-column:2!important;grid-row:1!important}
.pfy-cart-panel .pfy-promo button{grid-column:3!important;grid-row:1!important;white-space:nowrap!important}
.pfy-cart-panel .pfy-summary,.pfy-cart-panel .pfy-items{width:100%}

/* Customer dashboard style alignment */
:root{--pdv-orange:#ff7a00;--pfy-orange:#ff7a00;--pdv-green:#16a34a;--pdv-card-border:#111827;--pdv-hover:rgba(17,24,39,.10);--pdv-hover-strong:rgba(17,24,39,.16);--pdv-body:'Inter',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;--pdv-head:'Playfair Display',Georgia,serif;--pdv-title:'Poppins',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif}
#serviceDetail,.pfy-cart-panel{font-family:var(--pdv-body)!important;font-weight:400;letter-spacing:0;color:#111827}
#serviceDetail{padding:12px 0 30px}
.pdv-shell{width:min(1490px,calc(100% - 30px));margin:0 auto}
.pdv-service-intro h1,.pdv-review-panel h3{font-family:var(--pdv-head)!important;font-weight:700!important;letter-spacing:0!important}
.pdv-service-intro h1{font-size:30px;line-height:1.08}
.pdv-product-head h2,.pdv-card-section h2,.pdv-summary-head h2,.pfy-cart-head h2,.pfy-empty h3{font-family:var(--pdv-title)!important;font-size:14.5px!important;font-weight:600!important;letter-spacing:.018em!important;line-height:1.35}
.pdv-breadcrumb,.pdv-step,.pdv-field label,.pdv-field select,.pdv-qty-box,.pdv-upload-box,.pdv-warning,.pdv-addon,.pdv-summary-product,.pdv-price-card,.pdv-price-note,.pdv-checkout-note,.pfy-cart-panel,.pfy-cart-panel input{font-family:var(--pdv-body)!important;font-weight:400;letter-spacing:0}
.pdv-preview-card,.pdv-summary-card{border:1px solid var(--pdv-card-border)!important;border-radius:14px;box-shadow:none!important;transition:background .18s ease,box-shadow .18s ease,border-color .18s ease}
.pdv-preview-card:hover,.pdv-summary-card:hover{background:var(--pdv-hover)!important;border-color:var(--pdv-card-border)!important;box-shadow:none!important}
.pdv-thumb,.pdv-download-guide,.pdv-upload-box,.pdv-price-card,.pdv-file-result,.pfy-item,.pfy-summary,.pfy-free-shipping{transition:background .18s ease,box-shadow .18s ease,border-color .18s ease,transform .18s ease}
.pdv-thumb:hover,.pdv-download-guide:hover,.pdv-upload-box:hover,.pdv-price-card:hover,.pfy-item:hover{background:var(--pdv-hover)!important;border-color:var(--pdv-card-border)!important;box-shadow:none!important;transform:none!important}
.pdv-thumb.is-active,.pdv-price-card.is-active{border-color:var(--pdv-card-border)!important;background:var(--pdv-hover-strong)!important;color:#111827}
.pdv-thumb.is-active strong,.pdv-price-card.is-active .pdv-price-label,.pdv-price-card.is-active .pdv-price-medallion{color:#111827!important}
.pdv-card-section h2 span,.pdv-step.is-active span,.pdv-step.is-done span,.pdv-upload-icon,.pdv-warning i,.pdv-checkout-note:before,.pdv-download-guide i{background:var(--pdv-orange)!important;color:#111827!important}
.pdv-step.is-active,.pdv-step.is-done{color:#111827!important}
.pdv-cart,.pdv-checkout,.pdv-choose-file,.pdv-summary-head button,.pdv-qty-box button,.pdv-file-result button,.pdv-review-close,.pfy-check,.pfy-remove-all,.pfy-promo button,.pfy-remove,.pfy-qty button,.pdv-download-guide{border:0!important;box-shadow:none!important}
.pdv-cart,.pdv-checkout,.pdv-choose-file,.pdv-summary-head button,.pfy-check,.pfy-promo button{height:42px;min-width:132px;border-radius:10px;background:var(--pdv-orange)!important;color:#111827!important;font-family:var(--pdv-title)!important;font-size:12px;font-weight:600!important;letter-spacing:.014em;display:inline-flex;align-items:center;justify-content:center;gap:8px}
.pdv-download-guide{background:var(--pdv-orange)!important;color:#111827!important}
.pdv-download-guide i{color:#111827!important;background:transparent!important}
.pdv-download-guide small{color:#111827!important}
.pdv-action-row .pdv-cart,.pdv-action-row .pdv-checkout{width:232px!important;max-width:100%}
.pdv-cart:hover,.pdv-checkout:hover,.pdv-choose-file:hover,.pdv-summary-head button:hover,.pfy-check:hover,.pfy-promo button:hover,.pdv-download-guide:hover{background:#111827!important;color:#fff!important}
.pdv-checkout:disabled,.pdv-checkout.is-disabled,.pfy-check.is-disabled{background:#cfcfcf!important;color:#fff!important;cursor:not-allowed}
.pdv-checkout:disabled:hover,.pdv-checkout.is-disabled:hover,.pfy-check.is-disabled:hover{background:#cfcfcf!important;color:#fff!important}
.pdv-field select:focus,.pdv-qty-box:focus-within,.pdv-upload-box.is-dragging{border-color:var(--pdv-card-border)!important;box-shadow:0 0 0 3px rgba(17,24,39,.10)!important}
.pdv-addon input,.pfy-select-all input,.pfy-check-wrap input{accent-color:var(--pdv-green)}
.pdv-file-result,.pfy-row #pfyShippingLabel,#pfyShippingLabel.is-free{color:var(--pdv-green)!important}
.pdv-toast{left:50%!important;right:auto!important;top:96px!important;bottom:auto!important;min-width:260px;max-width:min(460px,calc(100vw - 32px));transform:translate(-50%,-14px)!important;text-align:center;border-radius:14px;background:#111827!important;font-family:var(--pdv-body)!important;font-weight:700;z-index:1000000}
.pdv-toast.is-visible{transform:translate(-50%,0)!important;opacity:1}
@media(max-width:1500px){.pdv-shell{width:min(1490px,calc(100% - 30px))}}
@media(max-width:850px){.pdv-shell{width:calc(100% - 24px)}}
.pdv-preview-card,.pdv-summary-card,.pdv-thumb:hover,.pdv-download-guide:hover,.pdv-upload-box:hover,.pdv-price-card:hover,.pfy-item:hover{box-shadow:none!important}
.pdv-card-section h2 span,.pdv-step span,.pdv-step.is-active span,.pdv-step.is-done span{background:transparent!important;color:#111827!important;box-shadow:none!important;border:0!important;border-radius:0!important;width:auto!important;height:auto!important;margin-right:8px!important;display:inline!important;font-family:var(--pdv-body)!important;font-size:12px!important;font-weight:600!important;line-height:1.35!important}
.pdv-step{gap:7px}
.pdv-step p{line-height:1.35!important;font-size:12px!important}
.pdv-step.is-active,.pdv-step.is-done{color:#111827!important}
.pdv-upload-icon,.pdv-warning i,.pdv-checkout-note:before,.pdv-download-guide i{background:transparent!important;color:#111827!important}
.pdv-upload-box strong,.pdv-warning strong,.pdv-checkout-note strong,.pdv-addon span,.pdv-addon strong{font-size:12px!important;line-height:1.35!important}
.pdv-upload-box span,.pdv-upload-box small,.pdv-warning small,.pdv-checkout-note small,.pdv-price-note,.pdv-addon{font-size:12px!important;line-height:1.4!important}
.pdv-upload-box{max-width:none;min-height:70px;grid-template-columns:32px minmax(0,1fr) 104px;gap:10px}
.pdv-choose-file,.pdv-summary-head button{height:34px!important;min-width:96px!important;border-radius:9px!important;font-size:11px!important}
.pdv-summary-head button{min-width:58px!important;width:58px!important}
.pdv-qty-box{height:38px!important;grid-template-columns:34px minmax(42px,1fr) 34px!important;align-items:center}
.pdv-qty-box button{height:100%!important;width:100%!important;display:grid!important;place-items:center!important;padding:0!important;line-height:1!important;font-size:13px!important}
.pdv-qty-box input{height:100%!important;display:block!important;line-height:38px!important;padding:0!important;font-size:12px!important}
.pdv-field select{height:38px!important;font-size:12px!important}
.pdv-field label{font-size:12px!important}
.pdv-warning,.pdv-checkout-note,.pdv-price-note{padding:10px 12px!important}
.pdv-checkout-note{padding-left:34px!important}
.pdv-cart,.pdv-checkout{box-shadow:none!important}
.pdv-cart:hover,.pdv-checkout:hover,.pdv-choose-file:hover,.pdv-summary-head button:hover,.pfy-check:hover,.pfy-promo button:hover,.pdv-download-guide:hover{box-shadow:none!important}
.pdv-breadcrumb strong{color:#ff7a00!important;border-bottom:3px solid #ff7a00;text-decoration:none;padding-bottom:3px}
.pdv-breadcrumb a#pdvCrumbCategory{color:#111827!important;font-weight:600}
.pdv-step.is-active,.pdv-step.is-done,.pdv-step.is-active p,.pdv-step.is-done p{color:#ff7a00!important}
.pdv-step.is-active span,.pdv-step.is-done span{color:#ff7a00!important;background:transparent!important;border:0!important}
.pdv-stepper>i{border-top-color:#d8dce2}
.pdv-step.is-done+ i{border-top-color:#ff7a00!important}
.pdv-price-card.is-active{border-color:#ff7a00!important;background:rgba(255,122,0,.08)!important}
.pdv-price-card.is-active .pdv-price-label,.pdv-price-card.is-active .pdv-price-medallion,.pdv-price-card.is-active small{color:#ff7a00!important}
.pdv-price-card:not(.is-active) .pdv-price-label,.pdv-price-card:not(.is-active) .pdv-price-medallion{color:#111827!important}
.pdv-estimated-total strong,.pfy-total strong{color:#16a34a!important}
.pdv-upload-icon,.pdv-warning i,.pdv-checkout-note:before,.pdv-download-guide i,.pdv-addon i,.pdv-review-close,.pdv-side-next{color:#ff7a00!important;background:transparent!important}
.pdv-addon input{accent-color:#16a34a!important}
@media(min-width:851px){
#serviceDetail{padding:40px 18px 70px 100px}
.pdv-shell{width:100%;max-width:1270px;margin:0}
.pdv-layout{gap:32px}
}

/* Final cart drawer UI: reference layout inside the existing cart popover size/pointer */
.pfy-cart-panel{
  overflow:visible!important;
  background:#fff!important;
  border:1px solid #e8e8e8!important;
  border-radius:18px!important;
  box-shadow:0 24px 60px rgba(15,23,42,.16)!important;
  color:#111827!important;
}
.pfy-cart-panel:before{background:#fff!important;border-color:#e8e8e8!important}
.pfy-cart-head{padding:22px 24px 8px!important;background:#fff!important;border:0!important;border-radius:18px 18px 0 0!important;box-shadow:none!important}
.pfy-cart-head h2{font-family:var(--pdv-title)!important;font-size:21px!important;font-weight:600!important;letter-spacing:0!important;color:#111827!important}
.pfy-cart-head span{color:#ff4f16!important}
.pfy-cart-close{background:transparent!important;border:0!important;color:#111827!important;font-size:26px!important;box-shadow:none!important}
.pfy-cart-close:hover{background:transparent!important;color:#ff4f16!important}
.pfy-free-shipping{padding:0 24px 16px!important;background:#fff!important;border:0!important;box-shadow:none!important}
.pfy-free-copy{font-size:12px!important;color:#555!important;margin-bottom:9px!important}
.pfy-free-copy strong{color:#ff4f16!important;font-weight:700!important}
.pfy-free-copy i{color:#111827!important;background:transparent!important}
.pfy-free-track{height:7px!important;background:#eee!important;border-radius:999px!important}
.pfy-free-track i{background:#ff4f16!important}
.pfy-select-bar{padding:12px 24px!important;background:#fff!important;border:0!important;box-shadow:none!important}
.pfy-select-all{font-size:12px!important;color:#333!important}
.pfy-remove-all{height:auto!important;min-width:0!important;background:transparent!important;border:0!important;color:#555!important;font-size:11.5px!important;font-weight:400!important;padding:0!important;box-shadow:none!important}
.pfy-remove-all:hover{background:transparent!important;color:#ff4f16!important}
.pfy-select-all input,.pfy-check-wrap input{width:15px!important;height:15px!important;min-width:15px!important;border-radius:4px!important;accent-color:#ff4f16!important}
.pfy-items{flex:1 1 auto!important;padding:0 24px!important;max-height:min(260px,34vh)!important;overflow:auto!important;background:#fff!important;box-shadow:none!important}
.pfy-items.is-empty{min-height:152px!important;max-height:152px!important;padding:0 24px!important}
.pfy-item{grid-template-columns:20px 58px minmax(0,1fr) 70px 20px!important;column-gap:10px!important;margin:0 0 14px!important;padding:16px!important;border:1px solid #e7e7e7!important;border-radius:12px!important;background:#fff!important;box-shadow:0 12px 30px rgba(15,23,42,.045)!important;transform:none!important}
.pfy-img,.pfy-noimg{width:58px!important;height:58px!important;border-radius:10px!important;background:#fff3ed!important;color:#ff4f16!important;box-shadow:none!important}
.pfy-info h3{font-size:13px!important;font-weight:600!important;letter-spacing:0!important;margin:0 0 4px!important;color:#111827!important}
.pfy-info p{font-size:10.6px!important;color:#555!important;line-height:1.35!important;white-space:normal!important}
.pfy-qty{width:84px!important;height:28px!important;grid-template-columns:26px 32px 26px!important;border:1px solid #e7e7e7!important;border-radius:8px!important;background:#fff!important}
.pfy-qty button{width:26px!important;height:28px!important;min-width:0!important;background:#fff!important;color:#111827!important;border:0!important;border-radius:0!important;font-size:13px!important;box-shadow:none!important}
.pfy-qty button:hover{background:#fff4ee!important;color:#ff4f16!important}
.pfy-qty span{width:32px!important;height:28px!important;font-size:12px!important;font-weight:600!important}
.pfy-line{font-size:12px!important;font-weight:600!important;color:#111827!important;margin-bottom:8px!important}
.pfy-remove{width:20px!important;height:20px!important;min-width:0!important;background:transparent!important;color:#555!important;border:0!important;border-radius:50%!important;box-shadow:none!important}
.pfy-remove:hover{background:transparent!important;color:#ff4f16!important}
.pfy-empty{border:1px solid #e7e7e7!important;border-radius:12px!important;background:#fff!important;box-shadow:none!important}
.pfy-empty i{color:#ff7a00!important}
.pfy-summary{flex:0 0 auto!important;width:100%!important;margin:0!important;padding:10px 24px 20px!important;background:#fff!important;border:0!important;border-radius:0 0 18px 18px!important;box-shadow:none!important;transform:none!important}
.pfy-promo{display:grid!important;grid-template-columns:24px minmax(0,1fr) 78px!important;gap:10px!important;align-items:center!important;margin:0 0 13px!important;padding:12px!important;border:1px solid #e8e8e8!important;border-radius:12px!important;background:#fff!important;box-shadow:none!important}
.pfy-promo>i{height:34px!important;color:#111827!important;background:transparent!important}
.pfy-promo input{height:36px!important;border:1px solid #e4e4e4!important;border-radius:8px!important;background:#fff!important;font-size:11px!important}
.pfy-promo button{width:78px!important;min-width:78px!important;height:36px!important;border:1px solid #ffd5c4!important;border-radius:8px!important;background:#fff6f1!important;color:#ff4f16!important;font-size:11px!important;font-weight:600!important;box-shadow:none!important}
.pfy-promo button:hover{background:#ff4f16!important;color:#fff!important;border-color:#ff4f16!important}
.pfy-row{font-size:12px!important;margin-bottom:9px!important;color:#333!important}
.pfy-row strong{font-weight:600!important;color:#111827!important}
.pfy-row #pfyShippingLabel,#pfyShippingLabel.is-free{color:#16a34a!important;font-weight:600!important}
.pfy-total{margin:13px 0 10px!important;padding:14px 16px!important;border:0!important;border-radius:7px!important;background:#171717!important;color:#fff!important;font-size:18px!important}
.pfy-total span{color:#fff!important}
.pfy-total strong{color:#ff4f16!important;font-size:20px!important;font-weight:700!important}
.pfy-reward{display:flex!important;align-items:center!important;gap:8px!important;margin:0 0 12px!important;color:#555!important;font-size:11px!important}
.pfy-reward i{color:#ffae24!important;background:transparent!important}
.pfy-secure-checkout{display:grid!important;grid-template-columns:1fr!important;gap:12px!important;margin-top:10px!important}
.pfy-secure-copy{min-height:48px!important;padding:10px 12px!important;border-radius:10px!important;background:#f7f7f7!important;color:#111827!important;justify-content:space-between!important;box-shadow:none!important}
.pfy-secure-copy i{width:28px!important;height:28px!important;border:1px solid #111827!important;border-radius:50%!important;background:transparent!important;color:#111827!important;display:grid!important;place-items:center!important;order:2!important}
.pfy-secure-copy strong{font-size:12px!important;font-weight:600!important;color:#111827!important}
.pfy-secure-copy small{font-size:10.2px!important;color:#666!important}
.pfy-check{width:100%!important;min-width:0!important;height:44px!important;border:0!important;border-radius:10px!important;background:#ff4f16!important;color:#fff!important;font-family:var(--pdv-title)!important;font-size:13px!important;font-weight:600!important;box-shadow:none!important}
.pfy-check:hover{background:#111827!important;color:#fff!important}
.pfy-check.is-disabled,.pfy-check.is-disabled:hover{background:#cfcfcf!important;color:#fff!important}
.pfy-terms{margin:2px 4px 0!important;color:#666!important;text-align:center!important;font-size:10.2px!important;line-height:1.45!important}
.pfy-terms a{color:#ff4f16!important;font-weight:600!important;text-decoration:none!important}

/* Cleaner cart drawer variant matching the latest reference */
.pfy-cart-panel{background:#fff!important;border-radius:18px!important;border-color:#e8e8e8!important;box-shadow:0 24px 60px rgba(15,23,42,.14)!important}
.pfy-cart-head{padding:20px 22px 6px!important}
.pfy-cart-head h2{font-size:20px!important;font-weight:700!important}
.pfy-free-shipping{padding:0 22px 14px!important}
.pfy-free-copy{font-size:10.5px!important;line-height:1.3!important;margin-bottom:8px!important}
.pfy-free-track{height:5px!important}
.pfy-select-bar{padding:10px 22px 11px!important}
.pfy-select-all{font-size:10.8px!important}
.pfy-remove-all{font-size:10.2px!important}
.pfy-select-all input,.pfy-check-wrap input{width:13px!important;height:13px!important;min-width:13px!important}
.pfy-items{padding:0 22px!important;max-height:min(230px,31vh)!important}
.pfy-items.is-empty{min-height:142px!important;max-height:142px!important}
.pfy-item{grid-template-columns:18px 48px minmax(0,1fr) 62px 18px!important;column-gap:9px!important;margin-bottom:12px!important;padding:14px!important;border-radius:11px!important;box-shadow:none!important}
.pfy-img,.pfy-noimg{width:48px!important;height:48px!important;border-radius:9px!important}
.pfy-noimg{font-size:19px!important}
.pfy-info h3{font-size:11.5px!important;margin-bottom:3px!important}
.pfy-info p{font-size:9.6px!important;line-height:1.3!important}
.pfy-bottom{margin-top:8px!important}
.pfy-qty{width:72px!important;height:24px!important;grid-template-columns:22px 28px 22px!important;border-radius:7px!important}
.pfy-qty button{width:22px!important;height:24px!important;font-size:11px!important}
.pfy-qty span{width:28px!important;height:24px!important;font-size:10.5px!important}
.pfy-line{width:62px!important;min-width:62px!important;margin-bottom:5px!important;font-size:10.8px!important}
.pfy-summary{padding:7px 22px 18px!important}
.pfy-promo{grid-template-columns:20px minmax(0,1fr) 64px!important;gap:8px!important;margin-bottom:13px!important;padding:10px!important;border-radius:10px!important}
.pfy-promo>i{height:31px!important;font-size:12px!important}
.pfy-promo input{height:31px!important;font-size:9.5px!important}
.pfy-promo button{width:64px!important;min-width:64px!important;height:31px!important;border-radius:8px!important;font-size:9.5px!important;background:#fff6f1!important;color:#ff4f16!important}
.pfy-row{font-size:10.6px!important;margin-bottom:8px!important}
.pfy-tax-row,.pfy-reward,.pfy-terms{display:none!important}
.pfy-total{display:flex!important;align-items:center!important;justify-content:space-between!important;margin:13px 0 15px!important;padding:13px 0 0!important;border-top:1px solid #eeeeee!important;border-radius:0!important;background:#fff!important;color:#111827!important;font-size:14px!important}
.pfy-total span{color:#111827!important;font-weight:700!important}
.pfy-total strong{color:#ff4f16!important;font-size:18px!important;font-weight:800!important}
.pfy-secure-checkout{gap:12px!important;margin-top:0!important}
.pfy-secure-copy{display:grid!important;grid-template-columns:28px minmax(0,1fr) 20px!important;align-items:center!important;gap:9px!important;min-height:52px!important;padding:10px 12px!important;border:1px solid #eeeeee!important;border-radius:10px!important;background:#fff!important}
.pfy-secure-copy i:first-child{order:0!important;width:22px!important;height:22px!important;border:0!important;border-radius:0!important;color:#111827!important}
.pfy-secure-copy span{order:1!important}
.pfy-secure-copy:after{content:"\f023";font-family:"Font Awesome 6 Free";font-weight:900;order:2;color:#555;font-size:13px;justify-self:end}
.pfy-secure-copy strong{font-size:11px!important;font-weight:700!important}
.pfy-secure-copy small{font-size:9.4px!important}
.pfy-check{height:42px!important;border-radius:9px!important;background:#ff4f16!important;color:#fff!important;font-size:12px!important;font-weight:700!important}
.pfy-check:hover{background:#111827!important;color:#fff!important}

/* Cart final lock: one clean section, no stacked/black summary UI */
#pfyCartPanel .pfy-tax-row,
#pfyCartPanel .pfy-reward,
#pfyCartPanel .pfy-terms,
#pfyCartPanel .pfy-upload-alert{display:none!important}
#pfyCartPanel .pfy-summary{background:#fff!important;border:0!important;box-shadow:none!important;padding:8px 22px 18px!important}
#pfyCartPanel .pfy-promo{background:#fff!important;border:1px solid #e8e8e8!important;border-radius:10px!important;box-shadow:none!important;margin:0 0 14px!important}
#pfyCartPanel .pfy-total{display:flex!important;align-items:center!important;justify-content:space-between!important;background:#fff!important;border:0!important;border-top:1px solid #eeeeee!important;border-radius:0!important;margin:12px 0 14px!important;padding:13px 0 0!important;color:#111827!important}
#pfyCartPanel .pfy-total span{color:#111827!important;font-size:14px!important;font-weight:700!important}
#pfyCartPanel .pfy-total strong{color:#ff4f16!important;font-size:18px!important;font-weight:800!important}
#pfyCartPanel .pfy-secure-copy{background:#fff!important;border:1px solid #eeeeee!important;border-radius:10px!important;box-shadow:none!important}
#pfyCartPanel .pfy-check{background:#ff4f16!important;color:#fff!important;box-shadow:none!important}
#pfyCartPanel .pfy-check.is-disabled{background:#cfcfcf!important;color:#fff!important}

/* Strong final cart lock: one clean white drawer, no inner/stacked panel look */
body #pfyCartPanel{
  background:#fff!important;
  border:1px solid #e8e8e8!important;
  border-radius:18px!important;
  box-shadow:0 24px 60px rgba(15,23,42,.14)!important;
  overflow:visible!important;
}
body #pfyCartPanel:before{
  background:#fff!important;
  border-color:#e8e8e8!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-cart-head,
body #pfyCartPanel .pfy-free-shipping,
body #pfyCartPanel .pfy-select-bar,
body #pfyCartPanel .pfy-items,
body #pfyCartPanel .pfy-summary{
  background:#fff!important;
  border:0!important;
  outline:0!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-cart-head{padding:22px 24px 8px!important;border-radius:18px 18px 0 0!important}
body #pfyCartPanel .pfy-free-shipping{padding:0 24px 16px!important}
body #pfyCartPanel .pfy-select-bar{padding:12px 24px!important}
body #pfyCartPanel .pfy-items{
  padding:0 24px!important;
  max-height:min(260px,34vh)!important;
  overflow:auto!important;
}
body #pfyCartPanel .pfy-summary{
  margin:0!important;
  padding:10px 24px 20px!important;
  border-radius:0 0 18px 18px!important;
}
body #pfyCartPanel .pfy-summary:before,
body #pfyCartPanel .pfy-summary:after,
body #pfyCartPanel .pfy-items:before,
body #pfyCartPanel .pfy-items:after{
  content:none!important;
  display:none!important;
}
body #pfyCartPanel .pfy-item,
body #pfyCartPanel .pfy-item:hover{
  background:#fff!important;
  border:1px solid #e7e7e7!important;
  border-radius:12px!important;
  box-shadow:none!important;
  transform:none!important;
}
body #pfyCartPanel .pfy-needs-file,
body #pfyCartPanel .pfy-needs-file:hover{
  background:#fff!important;
  border-color:#e7e7e7!important;
}
body #pfyCartPanel .pfy-file-required,
body #pfyCartPanel .pfy-tax-row,
body #pfyCartPanel .pfy-reward,
body #pfyCartPanel .pfy-terms,
body #pfyCartPanel .pfy-upload-alert{
  display:none!important;
}
body #pfyCartPanel .pfy-promo{
  background:#fff!important;
  border:1px solid #e8e8e8!important;
  border-radius:10px!important;
  box-shadow:none!important;
  margin:0 0 14px!important;
  padding:10px!important;
}
body #pfyCartPanel .pfy-total{
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  background:#fff!important;
  border:0!important;
  border-top:1px solid #eeeeee!important;
  border-radius:0!important;
  box-shadow:none!important;
  color:#111827!important;
  margin:12px 0 14px!important;
  padding:13px 0 0!important;
}
body #pfyCartPanel .pfy-total span{color:#111827!important;font-size:14px!important;font-weight:700!important}
body #pfyCartPanel .pfy-total strong{color:#ff4f16!important;font-size:18px!important;font-weight:800!important}
body #pfyCartPanel .pfy-secure-checkout{
  background:#fff!important;
  border:0!important;
  box-shadow:none!important;
  gap:12px!important;
  margin-top:0!important;
}
body #pfyCartPanel .pfy-secure-copy{
  background:#fff!important;
  border:1px solid #eeeeee!important;
  border-radius:10px!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-check{
  background:#ff4f16!important;
  color:#fff!important;
  border:0!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-check:hover{background:#111827!important;color:#fff!important}
body #pfyCartPanel .pfy-check.is-disabled,
body #pfyCartPanel .pfy-check.is-disabled:hover{
  background:#cfcfcf!important;
  color:#fff!important;
}
body #pfyCartPanel .pfy-item,
body #pfyCartPanel .pfy-item:hover{
  position:relative!important;
  grid-template-columns:66px minmax(0,1fr) 62px 16px!important;
  column-gap:9px!important;
  padding:14px 12px 14px 14px!important;
}
body #pfyCartPanel .pfy-check-wrap{
  position:absolute!important;
  left:11px!important;
  top:13px!important;
  z-index:2!important;
  display:grid!important;
  place-items:center!important;
  width:12px!important;
  min-width:12px!important;
  max-width:12px!important;
  height:12px!important;
  min-height:12px!important;
  max-height:12px!important;
  padding:0!important;
  margin:0!important;
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-check-wrap input{
  appearance:none!important;
  -webkit-appearance:none!important;
  display:block!important;
  position:relative!important;
  width:12px!important;
  min-width:12px!important;
  max-width:12px!important;
  height:12px!important;
  min-height:12px!important;
  max-height:12px!important;
  margin:0!important;
  padding:0!important;
  border:1.2px solid #d7d7d7!important;
  border-radius:3px!important;
  background:#fff!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-check-wrap input:checked{
  background:#ff4f16!important;
  border-color:#ff4f16!important;
}
body #pfyCartPanel .pfy-check-wrap input:checked:before{
  content:""!important;
  position:absolute!important;
  left:50%!important;
  top:46%!important;
  width:3px!important;
  height:6px!important;
  border-right:1.35px solid #fff!important;
  border-bottom:1.35px solid #fff!important;
  transform:translate(-50%,-55%) rotate(45deg)!important;
}
body #pfyCartPanel .pfy-img,
body #pfyCartPanel .pfy-noimg{
  width:62px!important;
  height:62px!important;
  border-radius:10px!important;
  margin-left:10px!important;
}
body #pfyCartPanel .pfy-line{
  width:62px!important;
  min-width:62px!important;
}
body #pfyCartPanel .pfy-select-all input{
  appearance:none!important;
  -webkit-appearance:none!important;
  width:12px!important;
  min-width:12px!important;
  max-width:12px!important;
  height:12px!important;
  min-height:12px!important;
  max-height:12px!important;
  border:1.2px solid #d7d7d7!important;
  border-radius:3px!important;
  background:#fff!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-select-all input:checked,
body #pfyCartPanel .pfy-select-all input:indeterminate{
  background:#ff4f16!important;
  border-color:#ff4f16!important;
}

/* Final service detail spacing pass */
#serviceDetail{padding:18px 0 34px!important}
#serviceDetail .pdv-shell{width:min(1270px,calc(100% - 118px))!important;max-width:1270px!important;margin:0 18px 0 100px!important}
#serviceDetail .pdv-hero-row{grid-template-columns:minmax(320px,1fr) minmax(560px,760px)!important;gap:24px!important;margin:8px 0 24px!important}
#serviceDetail .pdv-layout{--pdv-panel-h:500px;grid-template-columns:150px minmax(470px,1.18fr) minmax(320px,.82fr) minmax(380px,.92fr)!important;column-gap:50px!important;row-gap:18px!important;align-items:start!important}
#serviceDetail .pdv-left-card{margin:0!important;padding-top:2px!important;gap:18px!important}
#serviceDetail .pdv-thumb-stack{gap:32px!important}
#serviceDetail .pdv-thumb{min-height:145px!important;border-radius:8px!important;padding:11px 10px!important}
#serviceDetail .pdv-thumb-paper{width:52px!important;height:68px!important}
#serviceDetail .pdv-thumb-real-img{max-height:106px!important}
#serviceDetail .pdv-download-guide{min-height:70px!important;height:auto!important;margin-top:6px!important;padding:10px 14px!important;border-radius:8px!important}
#serviceDetail .pdv-preview-card{min-height:var(--pdv-panel-h)!important;border-radius:8px!important}
#serviceDetail .pdv-summary-card{min-height:var(--pdv-panel-h)!important;border:0!important;border-radius:0!important;background:transparent!important;box-shadow:none!important}
#serviceDetail .pdv-summary-card:hover{background:transparent!important;border:0!important;box-shadow:none!important}
#serviceDetail .pdv-preview-card{padding:20px 22px 24px!important}
#serviceDetail .pdv-product-head{margin-bottom:14px!important}
#serviceDetail .pdv-preview-window{min-height:330px!important}
#serviceDetail .pdv-side-nav{position:absolute;top:50%;z-index:4;width:38px;height:38px;border:0!important;border-radius:50%;background:#fff!important;color:#111827!important;display:grid!important;place-items:center!important;box-shadow:0 10px 26px rgba(17,24,39,.16)!important;cursor:pointer;transform:translateY(-50%);transition:background .18s ease,color .18s ease,box-shadow .18s ease}
#serviceDetail .pdv-side-prev{left:14px}
#serviceDetail .pdv-side-next{right:14px}
#serviceDetail .pdv-side-nav:hover,#serviceDetail .pdv-side-nav:focus{background:#111827!important;color:#fff!important;box-shadow:none!important;outline:0}
#serviceDetail .pdv-side-nav i{font-size:14px}
#serviceDetail .pdv-document-preview{width:min(370px,92%)!important;padding:30px!important}
#serviceDetail .pdv-real-preview-img{max-height:370px!important}
#serviceDetail .pdv-product-review-block{margin-top:18px!important}
#serviceDetail .pdv-options-card{padding:2px 0!important;display:flex!important;flex-direction:column!important;gap:0!important}
#serviceDetail .pdv-card-section{padding:0!important}
#serviceDetail .pdv-card-section h2{margin-bottom:13px!important}
#serviceDetail .pdv-field-grid{column-gap:12px!important;row-gap:13px!important}
#serviceDetail .pdv-field label{margin-bottom:7px!important}
#serviceDetail .pdv-field select,#serviceDetail .pdv-qty-box{height:42px!important;border-radius:8px!important}
#serviceDetail .pdv-divider{margin:18px 0!important}
#serviceDetail .pdv-upload-box{min-height:74px!important;border-radius:8px!important;padding:10px 12px!important}
#serviceDetail .pdv-warning{margin-top:12px!important;border-radius:8px!important;padding:12px 14px!important}
#serviceDetail .pdv-addon{margin-top:12px!important;gap:10px!important}
#serviceDetail .pdv-summary-card{padding:8px 0 0!important;align-self:start!important}
#serviceDetail .pdv-summary-head{margin-bottom:18px!important}
#serviceDetail .pdv-summary-product{grid-template-columns:82px minmax(0,1fr)!important;gap:16px!important;align-items:center!important}
#serviceDetail .pdv-summary-thumb{width:82px!important;height:104px!important;border-radius:8px!important}
#serviceDetail .pdv-summary-real-img{max-height:104px!important}
#serviceDetail .pdv-summary-product h3{font-size:13px!important;margin-bottom:7px!important}
#serviceDetail .pdv-summary-product p,#serviceDetail .pdv-summary-product small{font-size:11px!important;line-height:1.45!important}
#serviceDetail .pdv-summary-line{margin:18px 0!important}
#serviceDetail .pdv-price-grid{gap:12px!important;margin-bottom:12px!important}
#serviceDetail .pdv-price-card{min-height:82px!important;border-radius:8px!important;padding:12px!important}
#serviceDetail .pdv-price-note,#serviceDetail .pdv-estimated-total,#serviceDetail .pdv-checkout-note{margin-bottom:12px!important}
#serviceDetail .pdv-action-row{gap:10px!important}
#serviceDetail .pdv-action-row .pdv-cart,#serviceDetail .pdv-action-row .pdv-checkout{width:100%!important;height:44px!important}
@media(max-width:1500px){
  #serviceDetail .pdv-shell{width:min(1270px,calc(100% - 118px))!important;max-width:1270px!important;margin:0 18px 0 100px!important}
  #serviceDetail .pdv-layout{grid-template-columns:140px minmax(430px,1.12fr) minmax(320px,.86fr) minmax(390px,.9fr)!important;column-gap:30px!important}
  #serviceDetail .pdv-preview-window{min-height:320px!important}
  #serviceDetail .pdv-document-preview{width:min(360px,92%)!important}
}
@media(max-width:1250px){
  #serviceDetail .pdv-layout{grid-template-columns:170px minmax(0,1fr)!important;gap:16px!important}
  #serviceDetail .pdv-preview-card{min-height:470px!important}
  #serviceDetail .pdv-options-card,#serviceDetail .pdv-summary-card{min-height:auto!important}
}
@media(max-width:850px){
  #serviceDetail .pdv-shell{width:calc(100% - 24px)!important;margin-left:auto!important;margin-right:auto!important}
  #serviceDetail .pdv-hero-row{display:grid!important;grid-template-columns:1fr!important}
  #serviceDetail .pdv-layout{grid-template-columns:1fr!important;gap:14px!important}
  #serviceDetail .pdv-thumb-stack{grid-template-columns:repeat(3,minmax(0,1fr))!important;gap:12px!important}
  #serviceDetail .pdv-thumb{min-height:108px!important}
  #serviceDetail .pdv-preview-window{min-height:330px!important}
  #serviceDetail .pdv-document-preview{width:min(390px,94%)!important;padding:30px!important}
  #serviceDetail .pdv-summary-product{grid-template-columns:72px minmax(0,1fr)!important}
  #serviceDetail .pdv-summary-thumb{width:72px!important;height:92px!important}
}

#serviceDetail .pdv-toast{
  background:transparent!important;
  color:#fff!important;
  border:0!important;
  box-shadow:none!important;
  border-radius:0!important;
  padding:0!important;
  min-width:0!important;
  font-family:var(--pdv-body)!important;
  font-size:12px!important;
  font-weight:400!important;
  line-height:1.45!important;
  text-shadow:0 1px 12px rgba(0,0,0,.68)!important;
}


/* =========================================================
   FINAL REQUEST FIX:
   - Contact Us / Services orange applied consistently
   - Small Choose File + Edit buttons retained
   - ADD TO CART / CHECK OUT NOW centered and not too wide
   - Cart pointer/arrow aligned directly under cart icon
========================================================= */
:root{
  --pdv-orange:#ff4f16!important;
  --pfy-orange:#ff4f16!important;
  --pdv-contact-orange:#ff4f16!important;
  --pdv-contact-orange-2:#ff7a00!important;
  --pdv-button-hover:#111827!important;
}

/* all orange text/accent/icons use the same Contact Us orange */
#serviceDetail .pdv-breadcrumb a.pdv-current-service,
#serviceDetail .pdv-breadcrumb strong,
#serviceDetail .pdv-step.is-active,
#serviceDetail .pdv-step.is-done,
#serviceDetail .pdv-step.is-active p,
#serviceDetail .pdv-step.is-done p,
#serviceDetail .pdv-step.is-active span,
#serviceDetail .pdv-step.is-done span,
#serviceDetail .pdv-thumb.is-active strong,
#serviceDetail .pdv-price-card.is-active .pdv-price-label,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion,
#serviceDetail .pdv-price-card.is-active small,
#serviceDetail .pdv-estimated-total strong,
#serviceDetail .pdv-download-guide i,
#serviceDetail .pdv-upload-icon,
#serviceDetail .pdv-warning i,
#serviceDetail .pdv-checkout-note:before,
#serviceDetail .pdv-addon i,
#serviceDetail .pdv-review-link small,
#serviceDetail .pdv-review-close,
#serviceDetail .pdv-file-result button,
#pfyCartPanel .pfy-cart-head span,
#pfyCartPanel .pfy-free-copy strong,
#pfyCartPanel .pfy-remove-all:hover,
#pfyCartPanel .pfy-remove:hover,
#pfyCartPanel .pfy-total strong,
#pfyCartPanel .pfy-promo button,
#pfyCartPanel .pfy-empty i{
  color:var(--pdv-contact-orange)!important;
}

#serviceDetail .pdv-breadcrumb a.pdv-current-service,
#serviceDetail .pdv-breadcrumb strong{
  border-bottom-color:var(--pdv-contact-orange)!important;
}

#serviceDetail .pdv-step.is-done + i,
#serviceDetail .pdv-thumb.is-active,
#serviceDetail .pdv-price-card.is-active{
  border-color:var(--pdv-contact-orange)!important;
}

#serviceDetail .pdv-price-card.is-active,
#serviceDetail .pdv-estimated-total,
#serviceDetail .pdv-warning,
#serviceDetail .pdv-checkout-note{
  background:rgba(255,79,22,.08)!important;
}

/* Contact Us / Services exact button treatment */
#serviceDetail .pdv-cart,
#serviceDetail .pdv-checkout,
#serviceDetail .pdv-choose-file,
#serviceDetail .pdv-summary-head button,
#serviceDetail .pdv-download-guide,
#pfyCartPanel .pfy-check{
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(135deg,var(--pdv-contact-orange-2),var(--pdv-contact-orange))!important;
  color:#111827!important;
  font-family:var(--pdv-title,'Poppins',sans-serif)!important;
  font-weight:700!important;
  box-shadow:none!important;
  transition:background .18s ease,color .18s ease,transform .18s ease!important;
}

#serviceDetail .pdv-cart:hover,
#serviceDetail .pdv-checkout:hover,
#serviceDetail .pdv-choose-file:hover,
#serviceDetail .pdv-summary-head button:hover,
#serviceDetail .pdv-download-guide:hover,
#pfyCartPanel .pfy-check:hover{
  background:var(--pdv-button-hover)!important;
  color:#fff!important;
  transform:none!important;
}

/* Keep Choose File small */
#serviceDetail .pdv-choose-file{
  width:auto!important;
  min-width:86px!important;
  max-width:96px!important;
  height:30px!important;
  padding:0 12px!important;
  border-radius:9px!important;
  font-size:9.5px!important;
  line-height:30px!important;
  justify-self:end!important;
}

/* Keep Edit button small */
#serviceDetail .pdv-summary-head button{
  width:58px!important;
  min-width:58px!important;
  max-width:58px!important;
  height:30px!important;
  padding:0!important;
  border-radius:9px!important;
  font-size:10.5px!important;
}

/* ADD TO CART & CHECK OUT NOW: centered, not overly wide */
#serviceDetail .pdv-action-row{
  display:flex!important;
  flex-direction:column!important;
  align-items:center!important;
  justify-content:center!important;
  gap:10px!important;
  width:100%!important;
  margin-top:16px!important;
}

#serviceDetail .pdv-action-row .pdv-cart,
#serviceDetail .pdv-action-row .pdv-checkout{
  width:190px!important;
  max-width:190px!important;
  min-width:190px!important;
  height:42px!important;
  border-radius:999px!important;
  padding:0 18px!important;
  font-size:11px!important;
  letter-spacing:.01em!important;
}

#serviceDetail .pdv-checkout:disabled,
#serviceDetail .pdv-checkout.is-disabled,
#pfyCartPanel .pfy-check.is-disabled,
#pfyCartPanel .pfy-check.is-disabled:hover{
  background:#cfcfcf!important;
  color:#fff!important;
  cursor:not-allowed!important;
}

/* orange form controls and progress */
#serviceDetail .pdv-addon input,
#pfyCartPanel .pfy-select-all input,
#pfyCartPanel .pfy-check-wrap input{
  accent-color:var(--pdv-contact-orange)!important;
}

#pfyCartPanel .pfy-free-track i,
#pfyCartPanel .pfy-select-all input:checked,
#pfyCartPanel .pfy-select-all input:indeterminate,
#pfyCartPanel .pfy-check-wrap input:checked{
  background:var(--pdv-contact-orange)!important;
  border-color:var(--pdv-contact-orange)!important;
}

/* Apply button inside cart stays compact */
#pfyCartPanel .pfy-promo button{
  width:64px!important;
  min-width:64px!important;
  height:31px!important;
  border-radius:9px!important;
  background:#fff6f1!important;
  color:var(--pdv-contact-orange)!important;
  border:1px solid rgba(255,79,22,.24)!important;
}
#pfyCartPanel .pfy-promo button:hover{
  background:linear-gradient(135deg,var(--pdv-contact-orange-2),var(--pdv-contact-orange))!important;
  color:#fff!important;
}

/* Cart panel arrow: keep it attached to cart icon */
body #pfyCartPanel{
  --pfy-pointer-right:72px;
}
body #pfyCartPanel:before{
  top:-12px!important;
  right:var(--pfy-pointer-right)!important;
  width:15px!important;
  height:15px!important;
  background:#fff!important;
  border-left:1px solid #e8e8e8!important;
  border-top:1px solid #e8e8e8!important;
  border-right:0!important;
  border-bottom:0!important;
  transform:rotate(45deg)!important;
  z-index:3!important;
}

/* keep cart icon/badge orange consistent */
.cart-badge,
#cartBadge,
#cartCount,
[data-cart-count]{
  background:var(--pdv-contact-orange)!important;
  color:#fff!important;
}



/* =========================================================
   FINAL REQUEST FIXES - 06/08
   1) Choose File + Edit buttons follow Contact/Services pill style but stay small
   2) Stepper moved to the right, aligned over Printing Details area
   3) Download Print Guide removed
   4) Breadcrumb/nav inline becomes green on hover only
========================================================= */
:root{
  --pfy-contact-orange-1:#ffb000;
  --pfy-contact-orange-2:#ff7a00;
  --pfy-contact-orange-3:#ff4f16;
  --pfy-contact-gradient:linear-gradient(135deg,var(--pfy-contact-orange-1) 0%,var(--pfy-contact-orange-2) 52%,var(--pfy-contact-orange-3) 100%);
  --pfy-black-hover:#111827;
  --pfy-hover-green:#16a34a;
}

/* remove Download Print Guide completely */
#serviceDetail .pdv-download-guide{
  display:none!important;
}

/* keep left thumbnail stack clean after guide removal */
#serviceDetail .pdv-left-card{
  justify-content:flex-start!important;
}

/* Choose File button: same rounded orange button shape, still small */
#serviceDetail .pdv-choose-file,
#serviceDetail .pdv-upload-box .pdv-choose-file{
  width:auto!important;
  min-width:86px!important;
  max-width:96px!important;
  height:28px!important;
  padding:0 14px!important;
  border:0!important;
  border-radius:999px!important;
  background:var(--pfy-contact-gradient)!important;
  color:#111827!important;
  font-family:var(--pdv-title, Poppins, sans-serif)!important;
  font-size:9.3px!important;
  font-weight:700!important;
  line-height:28px!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  box-shadow:none!important;
  cursor:pointer!important;
  transition:background .18s ease,color .18s ease,transform .18s ease!important;
}
#serviceDetail .pdv-choose-file:hover,
#serviceDetail .pdv-upload-box .pdv-choose-file:hover{
  background:var(--pfy-black-hover)!important;
  color:#fff!important;
  transform:none!important;
}

/* Edit button: same rounded orange button shape, still small */
#serviceDetail .pdv-summary-head button{
  width:auto!important;
  min-width:50px!important;
  max-width:58px!important;
  height:28px!important;
  padding:0 14px!important;
  border:0!important;
  border-radius:999px!important;
  background:var(--pfy-contact-gradient)!important;
  color:#111827!important;
  font-family:var(--pdv-title, Poppins, sans-serif)!important;
  font-size:9.8px!important;
  font-weight:700!important;
  line-height:28px!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  box-shadow:none!important;
  cursor:pointer!important;
  transition:background .18s ease,color .18s ease,transform .18s ease!important;
}
#serviceDetail .pdv-summary-head button:hover{
  background:var(--pfy-black-hover)!important;
  color:#fff!important;
  transform:none!important;
}

/* Move checkout stepper to the right so it starts above the Printing Details section */
@media(min-width:1251px){
  #serviceDetail .pdv-hero-row{
    grid-template-columns:minmax(260px,520px) minmax(760px,1fr)!important;
    align-items:end!important;
  }
  #serviceDetail .pdv-stepper{
    width:min(780px,100%)!important;
    max-width:780px!important;
    justify-self:end!important;
    margin-left:auto!important;
    transform:translateX(54px)!important;
  }
}
@media(min-width:1501px){
  #serviceDetail .pdv-stepper{
    transform:translateX(72px)!important;
  }
}
@media(max-width:1250px){
  #serviceDetail .pdv-stepper{
    transform:none!important;
    justify-self:stretch!important;
  }
}

/* Green inline hover only for breadcrumb/current inline links */
#serviceDetail .pdv-breadcrumb a,
#serviceDetail .pdv-breadcrumb strong,
#serviceDetail .pdv-breadcrumb a.pdv-current-service,
#serviceDetail .pdv-breadcrumb a#pdvCrumbCategory{
  border-bottom:3px solid transparent!important;
  padding-bottom:3px!important;
  transition:color .16s ease,border-color .16s ease!important;
}
#serviceDetail .pdv-breadcrumb a:hover,
#serviceDetail .pdv-breadcrumb strong:hover,
#serviceDetail .pdv-breadcrumb a.pdv-current-service:hover,
#serviceDetail .pdv-breadcrumb a#pdvCrumbCategory:hover{
  color:var(--pfy-hover-green)!important;
  border-bottom-color:var(--pfy-hover-green)!important;
  text-decoration:none!important;
}

/* Current breadcrumb text can keep orange/red text, but the green line only appears on hover */
#serviceDetail .pdv-breadcrumb a.pdv-current-service,
#serviceDetail .pdv-breadcrumb strong{
  border-bottom-color:transparent!important;
}

/* keep ADD TO CART / CHECK OUT NOW centered and not too wide */
#serviceDetail .pdv-action-row{
  justify-items:center!important;
  align-items:center!important;
}
#serviceDetail .pdv-action-row .pdv-cart,
#serviceDetail .pdv-action-row .pdv-checkout{
  width:190px!important;
  max-width:190px!important;
  min-width:190px!important;
  height:38px!important;
  border-radius:999px!important;
}




/* =========================================================
   FINAL FIX - Choose File 200px dark pill, orange inline hover,
   and equal/clean stepper endpoints aligned to Printing Details
========================================================= */
:root{
  --pfy-inline-orange:#ff4f16!important;
  --pfy-inline-orange-2:#ff7a00!important;
  --pfy-dark-field:#111827!important;
}

/* Choose File: dark pill like the sample, 200px only, same height feel as HOME search field */
#serviceDetail .pdv-upload-box .pdv-choose-file,
#serviceDetail .pdv-choose-file{
  position:relative!important;
  width:200px!important;
  min-width:200px!important;
  max-width:200px!important;
  height:36px!important;
  min-height:36px!important;
  padding:0 18px 0 42px!important;
  border:1px solid var(--pfy-dark-field)!important;
  border-radius:999px!important;
  background:var(--pfy-dark-field)!important;
  color:#fff!important;
  font-family:var(--pdv-body, Inter, Arial, sans-serif)!important;
  font-size:12px!important;
  font-weight:600!important;
  line-height:36px!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:flex-start!important;
  text-align:left!important;
  box-shadow:none!important;
  cursor:pointer!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  transition:background .18s ease,color .18s ease,border-color .18s ease!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:before,
#serviceDetail .pdv-choose-file:before{
  content:"\f0c1"!important;
  font-family:"Font Awesome 6 Free"!important;
  font-weight:900!important;
  position:absolute!important;
  left:18px!important;
  top:50%!important;
  transform:translateY(-50%)!important;
  color:#fff!important;
  font-size:13px!important;
  line-height:1!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:hover,
#serviceDetail .pdv-choose-file:hover{
  background:linear-gradient(135deg,var(--pfy-inline-orange-2),var(--pfy-inline-orange))!important;
  border-color:var(--pfy-inline-orange)!important;
  color:#fff!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:hover:before,
#serviceDetail .pdv-choose-file:hover:before{color:#fff!important}

/* Upload row layout: keep the 200px file button from stretching and keep endpoints neat */
#serviceDetail .pdv-upload-box{
  grid-template-columns:32px minmax(0,1fr) 200px!important;
  align-items:center!important;
}
#serviceDetail .pdv-upload-box small{grid-column:2/4!important}

/* Edit remains small, but now follows the same rounded button family cleanly */
#serviceDetail .pdv-summary-head button{
  width:58px!important;
  min-width:58px!important;
  max-width:58px!important;
  height:32px!important;
  min-height:32px!important;
  padding:0!important;
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(135deg,var(--pfy-inline-orange-2),var(--pfy-inline-orange))!important;
  color:#111827!important;
  font-family:var(--pdv-title, Poppins, sans-serif)!important;
  font-size:10px!important;
  font-weight:700!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-summary-head button:hover{
  background:#111827!important;
  color:#fff!important;
}

/* Orange inline hover only; no green line */
#serviceDetail .pdv-breadcrumb a,
#serviceDetail .pdv-breadcrumb strong,
#serviceDetail .pdv-breadcrumb a.pdv-current-service,
#serviceDetail .pdv-breadcrumb a#pdvCrumbCategory{
  border-bottom:3px solid transparent!important;
  padding-bottom:3px!important;
  transition:color .16s ease,border-color .16s ease!important;
}
#serviceDetail .pdv-breadcrumb a:hover,
#serviceDetail .pdv-breadcrumb strong:hover,
#serviceDetail .pdv-breadcrumb a.pdv-current-service:hover,
#serviceDetail .pdv-breadcrumb a#pdvCrumbCategory:hover{
  color:var(--pfy-inline-orange)!important;
  border-bottom-color:var(--pfy-inline-orange)!important;
  text-decoration:none!important;
}
#serviceDetail .pdv-breadcrumb a.pdv-current-service,
#serviceDetail .pdv-breadcrumb strong{
  border-bottom-color:transparent!important;
}

/* Stepper starts exactly over the Printing Details column and keeps even endpoints */
@media(min-width:1251px){
  #serviceDetail .pdv-hero-row{
    display:grid!important;
    grid-template-columns:638px minmax(600px,1fr)!important;
    align-items:end!important;
    gap:38px!important;
    margin:8px 0 24px!important;
  }
  #serviceDetail .pdv-stepper{
    justify-self:start!important;
    align-self:end!important;
    width:100%!important;
    max-width:690px!important;
    margin:0!important;
    transform:none!important;
    grid-template-columns:auto 1fr auto 1fr auto 1fr auto!important;
    column-gap:10px!important;
  }
  #serviceDetail .pdv-stepper>i{
    width:100%!important;
    min-width:0!important;
    height:1px!important;
    border-top:2px dotted #d8dce2!important;
  }
  #serviceDetail .pdv-step.is-done + i{
    border-top-color:var(--pfy-inline-orange)!important;
  }
}
@media(min-width:1501px){
  #serviceDetail .pdv-hero-row{
    grid-template-columns:660px minmax(610px,1fr)!important;
  }
  #serviceDetail .pdv-stepper{max-width:720px!important}
}
@media(max-width:850px){
  #serviceDetail .pdv-upload-box{
    grid-template-columns:32px minmax(0,1fr)!important;
  }
  #serviceDetail .pdv-upload-box .pdv-choose-file,
  #serviceDetail .pdv-choose-file{
    grid-column:1/3!important;
    width:200px!important;
    min-width:200px!important;
    max-width:200px!important;
    justify-self:start!important;
  }
  #serviceDetail .pdv-upload-box small{grid-column:1/3!important}
}

/* Keep ADD TO CART / CHECK OUT NOW centered with equal endpoints */
#serviceDetail .pdv-action-row{
  display:flex!important;
  flex-direction:column!important;
  align-items:center!important;
  justify-content:center!important;
  gap:10px!important;
}
#serviceDetail .pdv-action-row .pdv-cart,
#serviceDetail .pdv-action-row .pdv-checkout{
  width:190px!important;
  min-width:190px!important;
  max-width:190px!important;
  height:38px!important;
  border-radius:999px!important;
}


/* =========================================================
   FINAL FIX - Upload button only, readable fonts, cart pointer attached to cart icon
========================================================= */
:root{
  --pfy-final-orange:#ff4f16!important;
  --pfy-final-orange-2:#ff7a00!important;
  --pfy-final-black:#111827!important;
}

/* readable normal webpage text sizing */
#serviceDetail{
  font-size:13px!important;
  line-height:1.45!important;
}
#serviceDetail .pdv-service-intro p,
#serviceDetail .pdv-breadcrumb,
#serviceDetail .pdv-step,
#serviceDetail .pdv-field label,
#serviceDetail .pdv-field select,
#serviceDetail .pdv-qty-box,
#serviceDetail .pdv-summary-product p,
#serviceDetail .pdv-summary-product small,
#serviceDetail .pdv-price-note,
#serviceDetail .pdv-checkout-note small,
#serviceDetail .pdv-warning small,
#serviceDetail .pdv-addon,
#serviceDetail .pdv-no-file,
#serviceDetail .pdv-upload-box small{
  font-size:13px!important;
  line-height:1.4!important;
}
#serviceDetail .pdv-card-section h2,
#serviceDetail .pdv-product-head h2,
#serviceDetail .pdv-summary-head h2{
  font-size:16px!important;
  line-height:1.35!important;
}
#serviceDetail .pdv-summary-product h3{
  font-size:14px!important;
  line-height:1.35!important;
}

/* Upload File: remove the big outer box; show only Choose File + No file chosen, then note below */
#serviceDetail .pdv-upload-box,
#serviceDetail .pdv-upload-box:hover,
#serviceDetail .pdv-upload-box.is-dragging{
  width:100%!important;
  max-width:none!important;
  min-height:0!important;
  height:auto!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:flex-start!important;
  justify-content:flex-start!important;
  gap:7px!important;
  padding:0!important;
  margin:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  box-shadow:none!important;
  outline:0!important;
}
#serviceDetail .pdv-file-row{
  display:flex!important;
  align-items:center!important;
  gap:10px!important;
  width:100%!important;
  min-width:0!important;
}
#serviceDetail .pdv-upload-icon,
#serviceDetail .pdv-upload-copy{
  display:none!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file,
#serviceDetail .pdv-choose-file{
  position:relative!important;
  width:200px!important;
  min-width:200px!important;
  max-width:200px!important;
  height:34px!important;
  min-height:34px!important;
  padding:0 18px!important;
  border:1px solid var(--pfy-final-black)!important;
  border-radius:999px!important;
  background:#fff!important;
  color:var(--pfy-final-black)!important;
  font-family:var(--pdv-body, Inter, Arial, sans-serif)!important;
  font-size:13px!important;
  font-weight:700!important;
  line-height:34px!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  text-align:center!important;
  box-shadow:none!important;
  cursor:pointer!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  transition:background .18s ease,color .18s ease,border-color .18s ease!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:before,
#serviceDetail .pdv-choose-file:before{
  content:none!important;
  display:none!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:hover,
#serviceDetail .pdv-choose-file:hover{
  background:var(--pfy-final-black)!important;
  border-color:var(--pfy-final-black)!important;
  color:#fff!important;
}
#serviceDetail .pdv-no-file{
  display:inline-block!important;
  min-width:0!important;
  max-width:calc(100% - 212px)!important;
  color:#555!important;
  font-family:var(--pdv-body, Inter, Arial, sans-serif)!important;
  font-weight:500!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}
#serviceDetail .pdv-upload-box small{
  display:block!important;
  grid-column:auto!important;
  margin:0 0 0 2px!important;
  color:#777!important;
  font-family:var(--pdv-body, Inter, Arial, sans-serif)!important;
  font-weight:500!important;
}

/* Edit remains compact but follows the rounded button family */
#serviceDetail .pdv-summary-head button{
  width:58px!important;
  min-width:58px!important;
  max-width:58px!important;
  height:32px!important;
  border-radius:999px!important;
  background:linear-gradient(135deg,var(--pfy-final-orange-2),var(--pfy-final-orange))!important;
  color:#111827!important;
  border:0!important;
  font-size:12px!important;
  font-weight:700!important;
}
#serviceDetail .pdv-summary-head button:hover{
  background:#111827!important;
  color:#fff!important;
}

/* orange inline hover only */
#serviceDetail .pdv-breadcrumb a:hover,
#serviceDetail .pdv-breadcrumb strong:hover,
#serviceDetail .pdv-breadcrumb a.pdv-current-service:hover,
#serviceDetail .pdv-breadcrumb a#pdvCrumbCategory:hover{
  color:var(--pfy-final-orange)!important;
  border-bottom-color:var(--pfy-final-orange)!important;
}

/* FINAL STEPPER POSITION + SIZE */
#serviceDetail .pdv-stepper{
  transform:translateX(120px)!important;
  max-width:760px!important;
}

#serviceDetail .pdv-step{
  font-size:12px!important;
  gap:8px!important;
}

#serviceDetail .pdv-step span,
#serviceDetail .pdv-step p{
  font-size:14px!important;
}

/* cart dropdown higher; pointer touches the cart icon instead of the black header area */
body #pfyCartPanel{
  top:124px!important;
  max-height:calc(100vh - 144px)!important;
}
body #pfyCartPanel:before{
  top:-9px!important;
}
@media(max-width:850px){
  body #pfyCartPanel{top:112px!important;max-height:calc(100vh - 132px)!important;}
  #serviceDetail .pdv-file-row{flex-wrap:wrap!important;}
  #serviceDetail .pdv-no-file{max-width:100%!important;}
}


/* =========================================================
   FINAL REQUEST OVERRIDES - Upload width + clean cart drawer
   Date: latest user request
   Scope: only requested fixes; rest of UI unchanged
========================================================= */

/* Upload File: bawasan width ng Choose File button */
#serviceDetail .pdv-upload-box .pdv-choose-file,
#serviceDetail .pdv-choose-file{
  width:118px!important;
  min-width:118px!important;
  max-width:118px!important;
  height:34px!important;
  min-height:34px!important;
  padding:0 14px!important;
  border:1px solid #111827!important;
  border-radius:999px!important;
  background:#fff!important;
  color:#111827!important;
  font-size:13px!important;
  font-weight:700!important;
  line-height:34px!important;
  justify-content:center!important;
  text-align:center!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:hover,
#serviceDetail .pdv-choose-file:hover{
  background:#111827!important;
  border-color:#111827!important;
  color:#fff!important;
}
#serviceDetail .pdv-no-file{
  max-width:calc(100% - 130px)!important;
}

/* Cart drawer: remove free shipping and secure checkout message blocks */
body #pfyCartPanel .pfy-free-shipping,
body #pfyCartPanel .pfy-secure-copy{
  display:none!important;
}

/* Cart item: alisin yung inner box/card look */
body #pfyCartPanel .pfy-item,
body #pfyCartPanel .pfy-item:hover{
  background:transparent!important;
  border:0!important;
  border-bottom:1px solid #eeeeee!important;
  border-radius:0!important;
  box-shadow:none!important;
  margin:0!important;
  padding:12px 0!important;
  transform:none!important;
}

/* Keep cart product layout clean after removing the item box */
body #pfyCartPanel .pfy-items{
  padding:0 24px!important;
}
body #pfyCartPanel .pfy-img,
body #pfyCartPanel .pfy-noimg{
  margin-left:8px!important;
}

/* Promo row: remove outer box, widen input, Apply same style as orange buttons */
body #pfyCartPanel .pfy-promo{
  display:grid!important;
  grid-template-columns:18px minmax(0,1fr) 88px!important;
  gap:10px!important;
  align-items:center!important;
  width:100%!important;
  margin:4px 0 14px!important;
  padding:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-promo>i{
  width:18px!important;
  height:36px!important;
  color:#111827!important;
}
body #pfyCartPanel .pfy-promo input{
  width:100%!important;
  min-width:0!important;
  height:36px!important;
  border:1px solid #e4e4e4!important;
  border-radius:9px!important;
  background:#fff!important;
  padding:0 12px!important;
  font-size:11px!important;
}
body #pfyCartPanel .pfy-promo button{
  width:88px!important;
  min-width:88px!important;
  max-width:88px!important;
  height:36px!important;
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(135deg,#ff7a00,#ff4f16)!important;
  color:#111827!important;
  font-family:var(--pdv-title, Poppins, sans-serif)!important;
  font-size:11px!important;
  font-weight:700!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-promo button:hover{
  background:#111827!important;
  color:#fff!important;
}

/* Proceed to Checkout: same visual size as ADD TO CART */
body #pfyCartPanel .pfy-secure-checkout{
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
  margin-top:10px!important;
}
body #pfyCartPanel .pfy-check{
  width:190px!important;
  min-width:190px!important;
  max-width:190px!important;
  height:38px!important;
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(135deg,#ff7a00,#ff4f16)!important;
  color:#111827!important;
  font-family:var(--pdv-title, Poppins, sans-serif)!important;
  font-size:11px!important;
  font-weight:700!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-check:hover{
  background:#111827!important;
  color:#fff!important;
}
body #pfyCartPanel .pfy-check.is-disabled,
body #pfyCartPanel .pfy-check.is-disabled:hover{
  background:#cfcfcf!important;
  color:#fff!important;
  cursor:not-allowed!important;
}

/* Cart arrow/pointer: exact center under cart icon */
body #pfyCartPanel:before{
  top:-8px!important;
  right:var(--pfy-pointer-right)!important;
  width:15px!important;
  height:15px!important;
  background:#fff!important;
  border-left:1px solid #e8e8e8!important;
  border-top:1px solid #e8e8e8!important;
  border-right:0!important;
  border-bottom:0!important;
  transform:rotate(45deg)!important;
  z-index:3!important;
}

</style>

<style id="service-detail-section-spacing-compact-final">
#serviceDetail{
  padding-top:26px!important;
  padding-bottom:48px!important;
}
#serviceDetail .pdv-shell{
  width:min(1270px,calc(100% - 112px))!important;
  max-width:1270px!important;
  margin:0 auto!important;
}
@media(max-width:1180px){
  #serviceDetail{
    padding-top:24px!important;
    padding-bottom:44px!important;
  }
  #serviceDetail .pdv-shell{
    width:calc(100% - 44px)!important;
  }
}
@media(max-width:850px){
  #serviceDetail{
    padding-top:22px!important;
    padding-bottom:38px!important;
  }
  #serviceDetail .pdv-shell{
    width:calc(100% - 28px)!important;
  }
}
</style>

<script>
(function(){"use strict";

const CART_KEY="printifyCartItems",LEGACY_KEY="printifyCart",LEGACY_KEY_2="cartItems",PROMO_KEY="printifyPromoCode",FREE_SHIPPING_TARGET=25;

const $=s=>document.querySelector(s),$$=s=>Array.from(document.querySelectorAll(s));

const readJson=(k,f="[]")=>{try{return JSON.parse(localStorage.getItem(k)||f)}catch(e){return JSON.parse(f)}};

const writeJson=(k,v)=>localStorage.setItem(k,JSON.stringify(v));

const toNumber=v=>{if(v==null||v==="")return 0;const n=Number(String(v).replace(/[^0-9.-]/g,""));return Number.isFinite(n)?n:0};

const roundMoney=v=>Math.round((Number(v)||0)*100)/100,peso=v=>"₱"+roundMoney(v).toLocaleString("en-PH",{minimumFractionDigits:2,maximumFractionDigits:2});

const esc=v=>String(v??"").replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#039;"}[c]));

const slug=v=>String(v||"print-item").toLowerCase().trim().replace(/[^a-z0-9]+/g,"-").replace(/^-+|-+$/g,"");

const cleanQty=v=>Math.max(1,Math.min(9999,parseInt(v,10)||1));

const stableId=item=>{const r=item?.raw&&typeof item.raw==="object"?item.raw:(item||{});return String(item?.id||item?.cartId||r.cartId||r.id||[r.serviceId||item?.serviceId||item?.serviceKey||r.serviceKey||item?.name||r.serviceName||"item",r.createdAt||r.addedAt||r.total||item?.total||"0",r.quantity||item?.qty||"1"].map(slug).join("-"))};

const selectedItems=items=>items.filter(i=>i.selected!==false),countQty=items=>(items||[]).reduce((s,i)=>s+cleanQty(i.qty||i.quantity),0);

const hasRequiredFile=i=>{const r=i?.raw||{};return !!(i?.fileName||r.fileName||r.fileMeta?.name||(Array.isArray(i?.meta)?i.meta:[]).some(m=>/^File:\s*(?!$|no file|null|undefined)/i.test(String(m||""))))};

const lineTotal=i=>{const q=cleanQty(i?.qty||i?.quantity),unit=toNumber(i?.unitPrice??i?.price??i?.raw?.unitPrice),flat=toNumber(i?.flatFee??i?.raw?.flatFee),direct=toNumber(i?.lineTotal??i?.raw?.total??i?.total);return roundMoney(unit>0||flat>0?unit*q+flat:direct)};

const repriceItem=i=>{const r=i?.raw||{},qty=cleanQty(i?.qty||r.quantity),bulkAt=Math.max(1,parseInt(r.bulkAt,10)||50),retail=toNumber(r.retailPrice),bulk=toNumber(r.bulkPrice),isBulk=qty>=bulkAt&&bulk>0,addon=r.addons?.doubleSided?.5:0;if(retail>0||bulk>0){i.unitPrice=roundMoney((isBulk?bulk:retail)+addon);i.price=i.unitPrice}i.qty=qty;r.quantity=qty;r.priceMode=isBulk?"Bulk":"Retail";r.unitPrice=i.unitPrice;r.total=lineTotal(i);i.lineTotal=r.total;i.raw=r;return i};

const syncRawOrder=i=>{const r=i.raw&&typeof i.raw==="object"?{...i.raw}:{};r.cartId=i.id;r.status=r.status||"cart";r.serviceName=r.serviceName||i.name;r.quantity=cleanQty(i.qty);r.unitPrice=roundMoney(i.unitPrice||i.price);r.flatFee=roundMoney(i.flatFee);r.total=lineTotal(i);r.selected=i.selected!==false;r.updatedAt=new Date().toISOString();return r};

function normalizeItem(item){if(!item)return null;const raw=item.raw&&typeof item.raw==="object"?{...item.raw}:{...item},catalog=raw.catalogVariation&&typeof raw.catalogVariation==="object"?raw.catalogVariation:{};const qty=cleanQty(item.qty??item.quantity??raw.quantity??1);const name=item.name||item.title||item.serviceName||raw.serviceName||"Print Item";const direct=toNumber(item.lineTotal??raw.total??item.total??item.amountTotal);let unit=toNumber(raw.unitPrice)||toNumber(item.unitPrice)||toNumber(item.price??item.amount??item.unit_price);if(unit&&direct&&qty>1&&Math.abs(unit-direct)<.01)unit=roundMoney(direct/qty);if(!unit&&direct)unit=roundMoney(direct/qty);let flat=toNumber(item.flatFee??raw.flatFee??raw.orderFee??raw.serviceFee);if(!flat&&direct&&unit)flat=Math.max(0,roundMoney(direct-unit*qty));const meta=[];if(Array.isArray(item.meta||item.details))meta.push(...(item.meta||item.details));else if(item.meta||item.details)meta.push(item.meta||item.details);const category=raw.categoryTitle||raw.printingCategory||catalog.printingCategory||raw.category||item.printingCategory||item.category;if(category)meta.push(category);const paper=raw.paperSize||raw.productSize||catalog.productSize||item.paperSize||item.productSize,color=raw.colorVariation||raw.colorMode||catalog.colorMode||item.colorVariation||item.colorMode,paperColor=[paper,color].filter(Boolean).join(" - ");if(paperColor)meta.push(paperColor);const option=raw.serviceOption||raw.variationLabel||raw.variation_label||item.serviceOption||item.variationLabel||item.variation_label||catalog.finishType||catalog.packageType;if(option)meta.push(option);if(raw.fileName||item.fileName)meta.push("File: "+(raw.fileName||item.fileName));const n={id:stableId({...item,raw}),name:String(name),unitPrice:roundMoney(unit),price:roundMoney(unit),flatFee:roundMoney(flat),qty,selected:item.selected!==false&&raw.selected!==false,image:item.image||item.img||item.thumbnail||item.previewImage||raw.image||raw.previewImage||"",meta:[...new Set(meta.map(v=>String(v||"").trim()).filter(Boolean))],raw};n.raw=syncRawOrder(n);return n}

const readCartItems=()=>{const p=readJson(CART_KEY);if(Array.isArray(p)&&p.length)return p.map(normalizeItem).filter(Boolean);const s=readJson(LEGACY_KEY_2);if(Array.isArray(s)&&s.length)return s.map(normalizeItem).filter(Boolean);const l=readJson(LEGACY_KEY);return Array.isArray(l)?l.map(normalizeItem).filter(Boolean):[]};

const totals=items=>{const subtotal=roundMoney((items||[]).reduce((s,i)=>s+lineTotal(i),0));const code=(localStorage.getItem(PROMO_KEY)||"").trim().toUpperCase();let discount=0;if(code==="SAVE10")discount=roundMoney(subtotal*.1);if(code==="PRINTIFY50")discount=50;discount=Math.min(discount,subtotal);return{subtotal,discount,total:roundMoney(subtotal-discount)}};

const updateCartBadges=count=>{$$("#cartBadge,#cartCount,#printifyCartCount,.cart-count,[data-cart-count]").forEach(n=>{n.textContent=String(count);if(n.classList.contains("cart-badge"))n.style.display=count?"grid":"none"})};

const visibleRect=n=>{if(!n)return null;const r=n.getBoundingClientRect();return r.width&&r.height&&r.bottom>0&&r.right>0?r:null};
const findCartAnchor=()=>{let selectors=["#navCart","[aria-label=\"Cart\"]","[onclick*=\"toggleCart\"]","[onclick*=\"openPrintifyCart\"]","#cartIcon","#cartBtn",".cart-icon",".cart-btn",".cart-link",".nav-cart",".shopping-cart","[data-cart-toggle]","[aria-label*=\"cart\" i]"],nodes=[];selectors.forEach(sel=>{try{nodes.push(...$$(sel))}catch(e){}});nodes.push(...$$("i.fa-cart-shopping,i.fa-shopping-cart,svg[data-icon*=cart],.fa-bag-shopping"));return nodes.map(n=>n.closest("a,button,[role=button],li,div")||n).find(n=>!n.closest("#pfyCartPanel")&&visibleRect(n))||null};
function alignCartPanel(){const panel=$("#pfyCartPanel"),anchor=findCartAnchor();if(!panel||!anchor)return;const ar=visibleRect(anchor);if(!ar)return;const center=ar.left+ar.width/2,pr=panel.getBoundingClientRect();let pointer=pr.right-center-7.5;pointer=Math.max(12,Math.min(pr.width-24,pointer));panel.style.setProperty("--pfy-pointer-right",pointer+"px")}

function saveCartItems(items){const n=(items||[]).map(normalizeItem).filter(Boolean);writeJson(CART_KEY,n);writeJson(LEGACY_KEY_2,n);writeJson(LEGACY_KEY,n.map(syncRawOrder));localStorage.setItem("printifyCartCount",String(countQty(n)));renderCart(n);if(typeof window.scheduleBackendCartSync==="function")window.scheduleBackendCartSync(n);return n}

function renderCart(cartItems=readCartItems()){const items=(cartItems||[]).map(normalizeItem).filter(Boolean),selected=selectedItems(items),t=totals(selected),allQty=countQty(items),selQty=countQty(selected),missing=selected.length>0&&selected.some(i=>!hasRequiredFile(i)),free=t.subtotal>=FREE_SHIPPING_TARGET,remaining=Math.max(0,FREE_SHIPPING_TARGET-t.subtotal),progress=FREE_SHIPPING_TARGET?Math.min(100,t.subtotal/FREE_SHIPPING_TARGET*100):0;const list=$("#pfyCartItems"),summary=$("#pfyCartSummary");if($("#pfyCartCount"))$("#pfyCartCount").textContent=`(${allQty})`;if($("#pfyCartFreeText"))$("#pfyCartFreeText").innerHTML=free?"You unlocked <strong>FREE SHIPPING</strong>":`Add <strong>${peso(remaining)}</strong> more to unlock <strong>FREE SHIPPING</strong>`;if($("#pfyFreeProgress"))$("#pfyFreeProgress").style.width=progress+"%";if($("#pfyShippingLabel")){const s=$("#pfyShippingLabel");s.textContent=selected.length?(free?"FREE":"Calculated at checkout"):"—";s.classList.toggle("is-free",free&&selected.length>0)}if($("#pfyCartSelectedLabel"))$("#pfyCartSelectedLabel").textContent=selected.length&&selected.length<items.length?`Selected (${selQty})`:"Select All";if($("#pfySubtotalLabel"))$("#pfySubtotalLabel").textContent=`Subtotal (${selQty} item${selQty===1?"":"s"})`;if($("#pfyRemoveAllBtn"))$("#pfyRemoveAllBtn").disabled=!items.length;if($("#pfyCartSelectAll")){const c=$("#pfyCartSelectAll");c.checked=!!items.length&&selected.length===items.length;c.indeterminate=!!items.length&&!!selected.length&&selected.length<items.length;c.disabled=!items.length}if($("#pfySubtotal"))$("#pfySubtotal").textContent=peso(t.subtotal);if($("#pfyTax"))$("#pfyTax").textContent=peso(0);if($("#pfyTotal"))$("#pfyTotal").textContent=peso(t.total);if($("#pfyRewardText"))$("#pfyRewardText").textContent=`You'll earn ${Math.floor(t.total/20)} reward points with this order!`;if($("#pfyDiscountRow"))$("#pfyDiscountRow").style.display=t.discount?"flex":"none";if($("#pfyDiscount"))$("#pfyDiscount").textContent="-"+peso(t.discount);if($("#pfyCartUploadAlert"))$("#pfyCartUploadAlert").style.display=missing?"flex":"none";if($("#pfyCartCheckoutBtn"))$("#pfyCartCheckoutBtn").classList.toggle("is-disabled",missing||!selected.length);updateCartBadges(allQty);if(!list||!summary)return;if(!items.length){summary.style.display="block";list.classList.add("is-empty");list.innerHTML="";if($("#pfyShippingLabel")){$("#pfyShippingLabel").textContent="Calculated at checkout";$("#pfyShippingLabel").classList.remove("is-free")}if($("#pfyCartCheckoutBtn"))$("#pfyCartCheckoutBtn").classList.add("is-disabled");return}summary.style.display="block";list.classList.remove("is-empty");list.innerHTML=items.map(i=>{const q=cleanQty(i.qty),ok=hasRequiredFile(i),checked=i.selected!==false?" checked":"",meta=i.meta.slice(0,3).map(v=>`<p>${esc(v)}</p>`).join("")+(ok?"":'<p class="pfy-file-required"><i class="fa-solid fa-file-circle-exclamation"></i> File required</p>'),img=i.image?`<img class="pfy-img" src="${esc(i.image)}" alt="${esc(i.name)}">`:'<div class="pfy-noimg"><i class="fa-regular fa-file-lines"></i></div>';return `<article class="pfy-item ${ok?"":"pfy-needs-file"}" data-id="${esc(i.id)}"><label class="pfy-check-wrap"><input type="checkbox" data-act="select"${checked}></label>${img}<div class="pfy-info"><h3>${esc(i.name)}</h3>${meta}<div class="pfy-price">${peso(i.unitPrice)}</div><div class="pfy-bottom"><div class="pfy-qty"><button type="button" data-act="minus">−</button><span>${q}</span><button type="button" data-act="plus">+</button></div></div></div><div class="pfy-line">${peso(lineTotal(i))}</div><button type="button" class="pfy-remove" data-act="remove"><i class="fa-regular fa-trash-can"></i></button></article>`}).join("")}

window.getCartItems=readCartItems;
window.saveCartItems=saveCartItems;
window.renderPrintifyCart=renderCart;
window.openPrintifyCart=()=>{if(typeof requireSignedInForOrder==="function"&&!requireSignedInForOrder())return false;renderCart();alignCartPanel();$("#pfyCartPanel")?.classList.add("show");$("#pfyCartBackdrop")?.classList.add("show");if(typeof updateBrowserUrl==="function")updateBrowserUrl("cart");else if(window.history&&window.location.pathname!=="/cart")window.history.pushState({sectionId:"cart"},"","/cart");window.dispatchEvent(new CustomEvent("printify-front-feedback",{detail:{message:"Cart opened."}}));requestAnimationFrame(alignCartPanel);return true};
window.closePrintifyCart=()=>{$("#pfyCartPanel")?.classList.remove("show");$("#pfyCartBackdrop")?.classList.remove("show");if(window.location.pathname==="/cart"){const fallback=typeof getVisibleMainSection==="function"?getVisibleMainSection():"products";if(typeof updateBrowserUrl==="function")updateBrowserUrl(fallback,true);}};
window.toggleCart=()=>{$("#pfyCartPanel")?.classList.contains("show")?closePrintifyCart():openPrintifyCart();return false};
window.addEventListener("resize",()=>{$("#pfyCartPanel")?.classList.contains("show")&&alignCartPanel()});
window.addToPrintifyCart=(payload,opt={})=>{if(typeof requireSignedInForOrder==="function"&&!requireSignedInForOrder())return null;const item=normalizeItem(payload);if(!item)return null;let cart=readCartItems();const ex=cart.find(c=>c.id===item.id);if(opt.merge===false||!ex)cart.push(item);else{ex.qty=cleanQty(ex.qty)+cleanQty(item.qty);ex.unitPrice=item.unitPrice||ex.unitPrice;ex.price=ex.unitPrice;ex.flatFee=roundMoney((ex.flatFee||0)+(item.flatFee||0));ex.raw={...ex.raw,...item.raw};ex.raw.quantity=ex.qty;ex.raw.total=lineTotal(ex)}saveCartItems(cart);if(opt.rawOrder)localStorage.setItem("printifyLatestCartItem",JSON.stringify(opt.rawOrder));if(opt.open!==false)openPrintifyCart();return item};
window.clearPrintifyCart=()=>{if(readCartItems().length&&confirm("Remove all items from your cart?"))saveCartItems([])};
window.applyPrintifyPromo=async()=>{const code=($("#pfyPromoCode")?.value||"").trim().toUpperCase();if(!code)return;try{if(typeof window.applyBackendCartPromo==="function")await window.applyBackendCartPromo(code);else if(!["SAVE10","PRINTIFY50"].includes(code))throw new Error("Invalid promo code.");localStorage.setItem(PROMO_KEY,code);renderCart()}catch(error){alert(error&&error.message?error.message:"Invalid promo code.")}};
window.checkoutPrintifyCart=()=>{if(typeof requireSignedInForOrder==="function"&&!requireSignedInForOrder())return false;const cart=readCartItems(),sel=selectedItems(cart),t=totals(sel);if(!cart.length)return alert("Your cart is empty.");if(!sel.length)return alert("Please select at least one cart item before checkout.");if(sel.some(i=>!hasRequiredFile(i))){renderCart(cart);return alert("Please upload a file for every selected cart item before checkout.")}const checkoutItems=sel.map(syncRawOrder);writeJson("printifyCheckoutItems",checkoutItems);writeJson("printifyActiveCheckout",checkoutItems[0]||null);writeJson("printifyCheckoutTotals",{itemCount:countQty(sel),subtotal:t.subtotal,discount:t.discount,total:t.total,freeShipping:t.subtotal>=FREE_SHIPPING_TARGET,createdAt:new Date().toISOString()});localStorage.setItem("printifyCheckoutSource","cart");closePrintifyCart();if(typeof window.openCheckoutSection==="function")return window.openCheckoutSection();window.location.href="/checkout"};
window.togglePrintifyCartSelectAll=checked=>{const c=readCartItems();c.forEach(i=>i.selected=!!checked);saveCartItems(c)};
document.addEventListener("change",e=>{const cb=e.target.closest('#pfyCartItems input[data-act="select"]');if(!cb)return;const row=cb.closest(".pfy-item"),cart=readCartItems(),item=cart.find(i=>i.id===row?.dataset.id);if(item){item.selected=!!cb.checked;saveCartItems(cart)}});
document.addEventListener("click",e=>{const b=e.target.closest('#pfyCartItems button[data-act]');if(!b)return;const row=b.closest(".pfy-item");let cart=readCartItems();const item=cart.find(i=>i.id===row?.dataset.id);if(!item)return;if(b.dataset.act==="plus")item.qty=cleanQty(item.qty)+1;if(b.dataset.act==="minus")item.qty=Math.max(1,cleanQty(item.qty)-1);if(b.dataset.act==="remove")cart=cart.filter(i=>i.id!==item.id);else{repriceItem(item);item.raw=syncRawOrder(item)}saveCartItems(cart)});
document.addEventListener("click",e=>{if(e.target?.id==="pfyCartBackdrop")closePrintifyCart()});
document.addEventListener("keydown",e=>{if(e.key==="Escape")closePrintifyCart()});
function renderInitialCartOnce(){if(window.__pfyCartInitialRenderComplete)return;renderCart();window.__pfyCartInitialRenderComplete=true;window.__pfyCartRenderSignature=JSON.stringify(readCartItems().map(i=>[i.id,i.qty,i.selected!==false,i.unitPrice,i.fileName||i.raw?.fileName||""]))+"|"+(localStorage.getItem(PROMO_KEY)||"")}
document.readyState==="loading"?
document.addEventListener("DOMContentLoaded",renderInitialCartOnce,{once:true}):renderInitialCartOnce();})();

(function(){"use strict";

const d=document,$=s=>d.querySelector(s),products={"text-only":{"categoryKey":"doc","categoryTitle":"Document Printing","serviceName":"Text Only","title":"Text Only Printing","summaryTitle":"Text Only Printing","serviceId":"DOC-TX-BW-SHT-CS","retailPrice":5.0,"bulkPrice":3.0,"bulkAt":50,"unit":"sheets","previewType":"text","previewImage":"TXTONLY (B&W).png","rating":"4.8","reviews":128},"text-image":{"categoryKey":"doc","categoryTitle":"Document Printing","serviceName":"Text with Image","title":"Text with Image Printing","summaryTitle":"Text with Image Printing","serviceId":"DOC-TWI-BW-SHT-CS","retailPrice":6.0,"bulkPrice":4.5,"bulkAt":50,"unit":"sheets","previewType":"text-image","previewImage":"TXTWI (B&W).png","rating":"4.8","reviews":96},"image-only":{"categoryKey":"doc","categoryTitle":"Document Printing","serviceName":"Image Only","title":"Image Only Printing","summaryTitle":"Image Only Printing","serviceId":"DOC-IM-BW-SHT-CS","retailPrice":8.0,"bulkPrice":6.0,"bulkAt":50,"unit":"sheets","previewType":"image","previewImage":"IO (B&W).png","rating":"4.8","reviews":84},"photocopy":{"categoryKey":"photo","categoryTitle":"Photocopy & Scanning","serviceName":"Photocopy","title":"Photocopy","summaryTitle":"Photocopy","serviceId":"COPY-BW-A4","retailPrice":0,"bulkPrice":6.0,"bulkAt":50,"unit":"copies","previewType":"text","previewImage":"PHOTOC (B&W).png","rating":"4.8","reviews":144},"scanning":{"categoryKey":"photo","categoryTitle":"Photocopy & Scanning","serviceName":"Scanning / Text Only","title":"Scanning / Text Only","summaryTitle":"Scanning / Text Only","serviceId":"PCS-SCAN-TX-SHT-BW-ARF","retailPrice":4.0,"bulkPrice":2.5,"bulkAt":50,"unit":"pages","previewType":"text","previewImage":"Photocopy & ScanningS.png","rating":"4.8","reviews":73},"id-photo":{"categoryKey":"id","categoryTitle":"ID & Photo Services","serviceName":"ID Photo","title":"ID Photo","summaryTitle":"ID Photo","serviceId":"IDP-ID-B-BW-BC","retailPrice":45.0,"bulkPrice":35.0,"bulkAt":5,"unit":"sets","previewType":"id","previewImage":"Photo ID (cover).png","rating":"4.8","reviews":102},"passport-visa":{"categoryKey":"id","categoryTitle":"ID & Photo Services","serviceName":"Passport / Visa","title":"Passport / Visa","summaryTitle":"Passport / Visa","serviceId":"IDP-PV-PASS-BW-BCC","retailPrice":80.0,"bulkPrice":70.0,"bulkAt":5,"unit":"sets","previewType":"id","previewImage":"Photo ID (cover).png","rating":"4.8","reviews":77},"single-photo-print":{"categoryKey":"id","categoryTitle":"ID & Photo Services","serviceName":"Single Photo Print","title":"Single Photo Print","summaryTitle":"Single Photo Print","serviceId":"IDP-SP-2R-BW-BC","retailPrice":5.0,"bulkPrice":4.0,"bulkAt":5,"unit":"prints","previewType":"image","previewImage":"Photo ID (cover).png","rating":"4.8","reviews":65},"lamination":{"categoryKey":"bind","categoryTitle":"Lamination & Binding","serviceName":"Lamination","title":"Lamination","summaryTitle":"Lamination","serviceId":"BND-LAM-STD-A4-CCS","retailPrice":35.0,"bulkPrice":30.0,"bulkAt":10,"unit":"pieces","previewType":"text","previewImage":"Lamination & BindingS.png","rating":"4.8","reviews":91},"spiral-binding":{"categoryKey":"bind","categoryTitle":"Lamination & Binding","serviceName":"Spiral Binding","title":"Spiral Binding","summaryTitle":"Spiral Binding","serviceId":"BND-SPR-STD-A4-CCS","retailPrice":120.0,"bulkPrice":110.0,"bulkAt":10,"unit":"sets","previewType":"text","previewImage":"Lamination & BindingS.png","rating":"4.8","reviews":58},"sintra-board":{"categoryKey":"largeformat","categoryTitle":"Large Format Printing","serviceName":"Sintra Board Printing","title":"Sintra Board Printing","summaryTitle":"Sintra Board Printing","serviceId":"LFP-SINTRA-A4-BW-GLS-ID","retailPrice":100.0,"bulkPrice":90.0,"bulkAt":5,"unit":"pieces","previewType":"image","previewImage":"Large FormatPS.png","rating":"4.8","reviews":39},"tarpaulin":{"categoryKey":"largeformat","categoryTitle":"Large Format Printing","serviceName":"Tarpaulin","title":"Tarpaulin","summaryTitle":"Tarpaulin","serviceId":"LFP-TARP-3X4","retailPrice":0,"bulkPrice":0,"bulkAt":5,"unit":"pieces","previewType":"image","previewImage":"Large FormatPS.png","rating":"4.8","reviews":30},"custom-layout":{"categoryKey":"special","categoryTitle":"Custom Special Printing","serviceName":"Custom Layout","title":"Custom Layout","summaryTitle":"Custom Layout","serviceId":"CSP-LYT-STD-A4-CQ","retailPrice":150.0,"bulkPrice":140.0,"bulkAt":10,"unit":"orders","previewType":"image","previewImage":"Custom Special PS.png","rating":"4.8","reviews":42},"marketing-collateral":{"categoryKey":"special","categoryTitle":"Custom Special Printing","serviceName":"Marketing Collateral","title":"Marketing Collateral","summaryTitle":"Marketing Collateral","serviceId":"CSP-MKT-STD-A4-CQ","retailPrice":180.0,"bulkPrice":170.0,"bulkAt":10,"unit":"orders","previewType":"image","previewImage":"Custom Special PS.png","rating":"4.8","reviews":36},"sticker-cut":{"categoryKey":"special","categoryTitle":"Custom Special Printing","serviceName":"Sticker Cut","title":"Sticker Cut","summaryTitle":"Sticker Cut","serviceId":"CSP-STK-STD-A4-CQ","retailPrice":200.0,"bulkPrice":190.0,"bulkAt":10,"unit":"orders","previewType":"image","previewImage":"Custom Special PS.png","rating":"4.8","reviews":34}};
const serviceVariants={"custom-layout":[{"serviceItemId":"CSP-LYT-PRM-A3-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Premium Production","productSize":"A3","finishType":"Custom Quote","packageType":"","retailPrice":290.0,"bulkPrice":280.0},{"serviceItemId":"CSP-LYT-PRM-A3-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Premium Production","productSize":"A3","finishType":"Layout Consultation","packageType":"","retailPrice":290.0,"bulkPrice":280.0},{"serviceItemId":"CSP-LYT-PRM-A3-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Premium Production","productSize":"A3","finishType":"Rush Request","packageType":"","retailPrice":290.0,"bulkPrice":280.0},{"serviceItemId":"CSP-LYT-PRM-A4-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Premium Production","productSize":"A4","finishType":"Custom Quote","packageType":"","retailPrice":210.0,"bulkPrice":200.0},{"serviceItemId":"CSP-LYT-PRM-A4-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Premium Production","productSize":"A4","finishType":"Layout Consultation","packageType":"","retailPrice":210.0,"bulkPrice":200.0},{"serviceItemId":"CSP-LYT-PRM-A4-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Premium Production","productSize":"A4","finishType":"Rush Request","packageType":"","retailPrice":210.0,"bulkPrice":200.0},{"serviceItemId":"CSP-LYT-PRM-C-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Premium Production","productSize":"Custom Size","finishType":"Custom Quote","packageType":"","retailPrice":380.0,"bulkPrice":380.0},{"serviceItemId":"CSP-LYT-PRM-C-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Premium Production","productSize":"Custom Size","finishType":"Layout Consultation","packageType":"","retailPrice":380.0,"bulkPrice":380.0},{"serviceItemId":"CSP-LYT-PRM-C-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Premium Production","productSize":"Custom Size","finishType":"Rush Request","packageType":"","retailPrice":380.0,"bulkPrice":380.0},{"serviceItemId":"CSP-LYT-STD-A3-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Standard Production","productSize":"A3","finishType":"Custom Quote","packageType":"","retailPrice":220.0,"bulkPrice":210.0},{"serviceItemId":"CSP-LYT-STD-A3-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Standard Production","productSize":"A3","finishType":"Layout Consultation","packageType":"","retailPrice":220.0,"bulkPrice":210.0},{"serviceItemId":"CSP-LYT-STD-A3-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Standard Production","productSize":"A3","finishType":"Rush Request","packageType":"","retailPrice":220.0,"bulkPrice":210.0},{"serviceItemId":"CSP-LYT-STD-A4-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Standard Production","productSize":"A4","finishType":"Custom Quote","packageType":"","retailPrice":150.0,"bulkPrice":140.0},{"serviceItemId":"CSP-LYT-STD-A4-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Standard Production","productSize":"A4","finishType":"Layout Consultation","packageType":"","retailPrice":150.0,"bulkPrice":140.0},{"serviceItemId":"CSP-LYT-STD-A4-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Standard Production","productSize":"A4","finishType":"Rush Request","packageType":"","retailPrice":150.0,"bulkPrice":140.0},{"serviceItemId":"CSP-LYT-STD-C-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Standard Production","productSize":"Custom Size","finishType":"Custom Quote","packageType":"","retailPrice":300.0,"bulkPrice":300.0},{"serviceItemId":"CSP-LYT-STD-C-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Standard Production","productSize":"Custom Size","finishType":"Layout Consultation","packageType":"","retailPrice":300.0,"bulkPrice":300.0},{"serviceItemId":"CSP-LYT-STD-C-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Custom Layout","colorMode":"Standard Production","productSize":"Custom Size","finishType":"Rush Request","packageType":"","retailPrice":300.0,"bulkPrice":300.0}],"marketing-collateral":[{"serviceItemId":"CSP-MKT-PRM-A3-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Premium Production","productSize":"A3","finishType":"Custom Quote","packageType":"","retailPrice":320.0,"bulkPrice":310.0},{"serviceItemId":"CSP-MKT-PRM-A3-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Premium Production","productSize":"A3","finishType":"Layout Consultation","packageType":"","retailPrice":320.0,"bulkPrice":310.0},{"serviceItemId":"CSP-MKT-PRM-A3-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Premium Production","productSize":"A3","finishType":"Rush Request","packageType":"","retailPrice":320.0,"bulkPrice":310.0},{"serviceItemId":"CSP-MKT-PRM-A4-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Premium Production","productSize":"A4","finishType":"Custom Quote","packageType":"","retailPrice":240.0,"bulkPrice":230.0},{"serviceItemId":"CSP-MKT-PRM-A4-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Premium Production","productSize":"A4","finishType":"Layout Consultation","packageType":"","retailPrice":240.0,"bulkPrice":230.0},{"serviceItemId":"CSP-MKT-PRM-A4-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Premium Production","productSize":"A4","finishType":"Rush Request","packageType":"","retailPrice":240.0,"bulkPrice":230.0},{"serviceItemId":"CSP-MKT-PRM-C-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Premium Production","productSize":"Custom Size","finishType":"Custom Quote","packageType":"","retailPrice":420.0,"bulkPrice":420.0},{"serviceItemId":"CSP-MKT-PRM-C-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Premium Production","productSize":"Custom Size","finishType":"Layout Consultation","packageType":"","retailPrice":420.0,"bulkPrice":420.0},{"serviceItemId":"CSP-MKT-PRM-C-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Premium Production","productSize":"Custom Size","finishType":"Rush Request","packageType":"","retailPrice":420.0,"bulkPrice":420.0},{"serviceItemId":"CSP-MKT-STD-A3-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Standard Production","productSize":"A3","finishType":"Custom Quote","packageType":"","retailPrice":260.0,"bulkPrice":250.0},{"serviceItemId":"CSP-MKT-STD-A3-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Standard Production","productSize":"A3","finishType":"Layout Consultation","packageType":"","retailPrice":260.0,"bulkPrice":250.0},{"serviceItemId":"CSP-MKT-STD-A3-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Standard Production","productSize":"A3","finishType":"Rush Request","packageType":"","retailPrice":260.0,"bulkPrice":250.0},{"serviceItemId":"CSP-MKT-STD-A4-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Standard Production","productSize":"A4","finishType":"Custom Quote","packageType":"","retailPrice":180.0,"bulkPrice":170.0},{"serviceItemId":"CSP-MKT-STD-A4-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Standard Production","productSize":"A4","finishType":"Layout Consultation","packageType":"","retailPrice":180.0,"bulkPrice":170.0},{"serviceItemId":"CSP-MKT-STD-A4-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Standard Production","productSize":"A4","finishType":"Rush Request","packageType":"","retailPrice":180.0,"bulkPrice":170.0},{"serviceItemId":"CSP-MKT-STD-C-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Standard Production","productSize":"Custom Size","finishType":"Custom Quote","packageType":"","retailPrice":340.0,"bulkPrice":340.0},{"serviceItemId":"CSP-MKT-STD-C-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Standard Production","productSize":"Custom Size","finishType":"Layout Consultation","packageType":"","retailPrice":340.0,"bulkPrice":340.0},{"serviceItemId":"CSP-MKT-STD-C-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Marketing Collateral","colorMode":"Standard Production","productSize":"Custom Size","finishType":"Rush Request","packageType":"","retailPrice":340.0,"bulkPrice":340.0}],"sticker-cut":[{"serviceItemId":"CSP-STK-PRM-A3-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Premium Production","productSize":"A3","finishType":"Custom Quote","packageType":"","retailPrice":340.0,"bulkPrice":330.0},{"serviceItemId":"CSP-STK-PRM-A3-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Premium Production","productSize":"A3","finishType":"Layout Consultation","packageType":"","retailPrice":340.0,"bulkPrice":330.0},{"serviceItemId":"CSP-STK-PRM-A3-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Premium Production","productSize":"A3","finishType":"Rush Request","packageType":"","retailPrice":340.0,"bulkPrice":330.0},{"serviceItemId":"CSP-STK-PRM-A4-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Premium Production","productSize":"A4","finishType":"Custom Quote","packageType":"","retailPrice":260.0,"bulkPrice":250.0},{"serviceItemId":"CSP-STK-PRM-A4-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Premium Production","productSize":"A4","finishType":"Layout Consultation","packageType":"","retailPrice":260.0,"bulkPrice":250.0},{"serviceItemId":"CSP-STK-PRM-A4-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Premium Production","productSize":"A4","finishType":"Rush Request","packageType":"","retailPrice":260.0,"bulkPrice":250.0},{"serviceItemId":"CSP-STK-PRM-C-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Premium Production","productSize":"Custom Size","finishType":"Custom Quote","packageType":"","retailPrice":440.0,"bulkPrice":440.0},{"serviceItemId":"CSP-STK-PRM-C-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Premium Production","productSize":"Custom Size","finishType":"Layout Consultation","packageType":"","retailPrice":440.0,"bulkPrice":440.0},{"serviceItemId":"CSP-STK-PRM-C-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Premium Production","productSize":"Custom Size","finishType":"Rush Request","packageType":"","retailPrice":440.0,"bulkPrice":440.0},{"serviceItemId":"CSP-STK-STD-A3-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Standard Production","productSize":"A3","finishType":"Custom Quote","packageType":"","retailPrice":280.0,"bulkPrice":270.0},{"serviceItemId":"CSP-STK-STD-A3-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Standard Production","productSize":"A3","finishType":"Layout Consultation","packageType":"","retailPrice":280.0,"bulkPrice":270.0},{"serviceItemId":"CSP-STK-STD-A3-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Standard Production","productSize":"A3","finishType":"Rush Request","packageType":"","retailPrice":280.0,"bulkPrice":270.0},{"serviceItemId":"CSP-STK-STD-A4-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Standard Production","productSize":"A4","finishType":"Custom Quote","packageType":"","retailPrice":200.0,"bulkPrice":190.0},{"serviceItemId":"CSP-STK-STD-A4-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Standard Production","productSize":"A4","finishType":"Layout Consultation","packageType":"","retailPrice":200.0,"bulkPrice":190.0},{"serviceItemId":"CSP-STK-STD-A4-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Standard Production","productSize":"A4","finishType":"Rush Request","packageType":"","retailPrice":200.0,"bulkPrice":190.0},{"serviceItemId":"CSP-STK-STD-C-CQ","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Standard Production","productSize":"Custom Size","finishType":"Custom Quote","packageType":"","retailPrice":360.0,"bulkPrice":360.0},{"serviceItemId":"CSP-STK-STD-C-LC","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Standard Production","productSize":"Custom Size","finishType":"Layout Consultation","packageType":"","retailPrice":360.0,"bulkPrice":360.0},{"serviceItemId":"CSP-STK-STD-C-RR","service":"Custom Special Printing","category":"Custom","printingCategory":"Sticker Cut","colorMode":"Standard Production","productSize":"Custom Size","finishType":"Rush Request","packageType":"","retailPrice":360.0,"bulkPrice":360.0}],"image-only":[{"serviceItemId":"DOC-IM-BW-A4-CS","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Collated Set","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"DOC-IM-BW-A4-FT","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Fast Turnaround","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"DOC-IM-BW-A4-LC","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Layout Check","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"DOC-IM-BW-A4-SP","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Print","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"DOC-IM-BW-LGL-CS","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Collated Set","packageType":"","retailPrice":12.0,"bulkPrice":10.0},{"serviceItemId":"DOC-IM-BW-LGL-FT","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Fast Turnaround","packageType":"","retailPrice":12.0,"bulkPrice":10.0},{"serviceItemId":"DOC-IM-BW-LGL-LC","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Layout Check","packageType":"","retailPrice":12.0,"bulkPrice":10.0},{"serviceItemId":"DOC-IM-BW-LGL-SP","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Standard Print","packageType":"","retailPrice":12.0,"bulkPrice":10.0},{"serviceItemId":"DOC-IM-BW-SHT-CS","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Collated Set","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-IM-BW-SHT-FT","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Fast Turnaround","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-IM-BW-SHT-LC","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Layout Check","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-IM-BW-SHT-SP","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Standard Print","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-IM-FC-A4-CS","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Collated Set","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"DOC-IM-FC-A4-FT","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Fast Turnaround","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"DOC-IM-FC-A4-LC","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Layout Check","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"DOC-IM-FC-A4-SP","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Print","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"DOC-IM-FC-LGL-CS","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Collated Set","packageType":"","retailPrice":30.0,"bulkPrice":24.0},{"serviceItemId":"DOC-IM-FC-LGL-FT","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Fast Turnaround","packageType":"","retailPrice":30.0,"bulkPrice":24.0},{"serviceItemId":"DOC-IM-FC-LGL-LC","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Layout Check","packageType":"","retailPrice":30.0,"bulkPrice":24.0},{"serviceItemId":"DOC-IM-FC-LGL-SP","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Print","packageType":"","retailPrice":30.0,"bulkPrice":24.0},{"serviceItemId":"DOC-IM-FC-SHT-CS","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Collated Set","packageType":"","retailPrice":22.0,"bulkPrice":18.0},{"serviceItemId":"DOC-IM-FC-SHT-FT","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Fast Turnaround","packageType":"","retailPrice":22.0,"bulkPrice":18.0},{"serviceItemId":"DOC-IM-FC-SHT-LC","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Layout Check","packageType":"","retailPrice":22.0,"bulkPrice":18.0},{"serviceItemId":"DOC-IM-FC-SHT-SP","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Standard Print","packageType":"","retailPrice":22.0,"bulkPrice":18.0},{"serviceItemId":"DOC-IM-PC-A4-CS","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Collated Set","packageType":"","retailPrice":18.0,"bulkPrice":13.0},{"serviceItemId":"DOC-IM-PC-A4-FT","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Fast Turnaround","packageType":"","retailPrice":18.0,"bulkPrice":13.0},{"serviceItemId":"DOC-IM-PC-A4-LC","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Layout Check","packageType":"","retailPrice":18.0,"bulkPrice":13.0},{"serviceItemId":"DOC-IM-PC-A4-SP","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Print","packageType":"","retailPrice":18.0,"bulkPrice":13.0},{"serviceItemId":"DOC-IM-PC-LGL-CS","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Collated Set","packageType":"","retailPrice":22.0,"bulkPrice":16.0},{"serviceItemId":"DOC-IM-PC-LGL-FT","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Fast Turnaround","packageType":"","retailPrice":22.0,"bulkPrice":16.0},{"serviceItemId":"DOC-IM-PC-LGL-LC","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Layout Check","packageType":"","retailPrice":22.0,"bulkPrice":16.0},{"serviceItemId":"DOC-IM-PC-LGL-SP","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Print","packageType":"","retailPrice":22.0,"bulkPrice":16.0},{"serviceItemId":"DOC-IM-PC-SHT-CS","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Collated Set","packageType":"","retailPrice":15.0,"bulkPrice":11.0},{"serviceItemId":"DOC-IM-PC-SHT-FT","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Fast Turnaround","packageType":"","retailPrice":15.0,"bulkPrice":11.0},{"serviceItemId":"DOC-IM-PC-SHT-LC","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Layout Check","packageType":"","retailPrice":15.0,"bulkPrice":11.0},{"serviceItemId":"DOC-IM-PC-SHT-SP","service":"Document Printing","category":"Printing","printingCategory":"Image Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Standard Print","packageType":"","retailPrice":15.0,"bulkPrice":11.0}],"text-image":[{"serviceItemId":"DOC-TWI-BW-A4-CS","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Collated Set","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TWI-BW-A4-FT","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Fast Turnaround","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TWI-BW-A4-LC","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Layout Check","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TWI-BW-A4-SP","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Print","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TWI-BW-LGL-CS","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Collated Set","packageType":"","retailPrice":10.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TWI-BW-LGL-FT","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Fast Turnaround","packageType":"","retailPrice":10.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TWI-BW-LGL-LC","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Layout Check","packageType":"","retailPrice":10.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TWI-BW-LGL-SP","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Standard Print","packageType":"","retailPrice":10.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TWI-BW-SHT-CS","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Collated Set","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"DOC-TWI-BW-SHT-FT","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Fast Turnaround","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"DOC-TWI-BW-SHT-LC","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Layout Check","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"DOC-TWI-BW-SHT-SP","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Standard Print","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"DOC-TWI-FC-A4-CS","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Collated Set","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"DOC-TWI-FC-A4-FT","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Fast Turnaround","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"DOC-TWI-FC-A4-LC","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Layout Check","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"DOC-TWI-FC-A4-SP","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Print","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"DOC-TWI-FC-LGL-CS","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Collated Set","packageType":"","retailPrice":18.0,"bulkPrice":14.0},{"serviceItemId":"DOC-TWI-FC-LGL-FT","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Fast Turnaround","packageType":"","retailPrice":18.0,"bulkPrice":14.0},{"serviceItemId":"DOC-TWI-FC-LGL-LC","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Layout Check","packageType":"","retailPrice":18.0,"bulkPrice":14.0},{"serviceItemId":"DOC-TWI-FC-LGL-SP","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Print","packageType":"","retailPrice":18.0,"bulkPrice":14.0},{"serviceItemId":"DOC-TWI-FC-SHT-CS","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Collated Set","packageType":"","retailPrice":12.0,"bulkPrice":10.0},{"serviceItemId":"DOC-TWI-FC-SHT-FT","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Fast Turnaround","packageType":"","retailPrice":12.0,"bulkPrice":10.0},{"serviceItemId":"DOC-TWI-FC-SHT-LC","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Layout Check","packageType":"","retailPrice":12.0,"bulkPrice":10.0},{"serviceItemId":"DOC-TWI-FC-SHT-SP","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Standard Print","packageType":"","retailPrice":12.0,"bulkPrice":10.0},{"serviceItemId":"DOC-TWI-PC-A4-CS","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Collated Set","packageType":"","retailPrice":9.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TWI-PC-A4-FT","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Fast Turnaround","packageType":"","retailPrice":9.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TWI-PC-A4-LC","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Layout Check","packageType":"","retailPrice":9.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TWI-PC-A4-SP","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Print","packageType":"","retailPrice":9.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TWI-PC-LGL-CS","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Collated Set","packageType":"","retailPrice":11.0,"bulkPrice":8.5},{"serviceItemId":"DOC-TWI-PC-LGL-FT","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Fast Turnaround","packageType":"","retailPrice":11.0,"bulkPrice":8.5},{"serviceItemId":"DOC-TWI-PC-LGL-LC","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Layout Check","packageType":"","retailPrice":11.0,"bulkPrice":8.5},{"serviceItemId":"DOC-TWI-PC-LGL-SP","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Print","packageType":"","retailPrice":11.0,"bulkPrice":8.5},{"serviceItemId":"DOC-TWI-PC-SHT-CS","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Collated Set","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TWI-PC-SHT-FT","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Fast Turnaround","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TWI-PC-SHT-LC","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Layout Check","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TWI-PC-SHT-SP","service":"Document Printing","category":"Printing","printingCategory":"Text with Image","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Standard Print","packageType":"","retailPrice":8.0,"bulkPrice":6.0}],"text-only":[{"serviceItemId":"DOC-TX-BW-A4-CS","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Collated Set","packageType":"","retailPrice":6.0,"bulkPrice":4.0},{"serviceItemId":"DOC-TX-BW-A4-FT","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Fast Turnaround","packageType":"","retailPrice":6.0,"bulkPrice":4.0},{"serviceItemId":"DOC-TX-BW-A4-LC","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Layout Check","packageType":"","retailPrice":6.0,"bulkPrice":4.0},{"serviceItemId":"DOC-TX-BW-A4-SP","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Print","packageType":"","retailPrice":6.0,"bulkPrice":4.0},{"serviceItemId":"DOC-TX-BW-LGL-CS","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Collated Set","packageType":"","retailPrice":7.0,"bulkPrice":5.0},{"serviceItemId":"DOC-TX-BW-LGL-FT","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Fast Turnaround","packageType":"","retailPrice":7.0,"bulkPrice":5.0},{"serviceItemId":"DOC-TX-BW-LGL-LC","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Layout Check","packageType":"","retailPrice":7.0,"bulkPrice":5.0},{"serviceItemId":"DOC-TX-BW-LGL-SP","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Standard Print","packageType":"","retailPrice":7.0,"bulkPrice":5.0},{"serviceItemId":"DOC-TX-BW-SHT-CS","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Collated Set","packageType":"","retailPrice":5.0,"bulkPrice":3.0},{"serviceItemId":"DOC-TX-BW-SHT-FT","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Fast Turnaround","packageType":"","retailPrice":5.0,"bulkPrice":3.0},{"serviceItemId":"DOC-TX-BW-SHT-LC","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Layout Check","packageType":"","retailPrice":5.0,"bulkPrice":3.0},{"serviceItemId":"DOC-TX-BW-SHT-SP","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Standard Print","packageType":"","retailPrice":5.0,"bulkPrice":3.0},{"serviceItemId":"DOC-TX-FC-A4-CS","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Collated Set","packageType":"","retailPrice":10.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TX-FC-A4-FT","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Fast Turnaround","packageType":"","retailPrice":10.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TX-FC-A4-LC","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Layout Check","packageType":"","retailPrice":10.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TX-FC-A4-SP","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Print","packageType":"","retailPrice":10.0,"bulkPrice":7.0},{"serviceItemId":"DOC-TX-FC-LGL-CS","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Collated Set","packageType":"","retailPrice":12.0,"bulkPrice":9.0},{"serviceItemId":"DOC-TX-FC-LGL-FT","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Fast Turnaround","packageType":"","retailPrice":12.0,"bulkPrice":9.0},{"serviceItemId":"DOC-TX-FC-LGL-LC","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Layout Check","packageType":"","retailPrice":12.0,"bulkPrice":9.0},{"serviceItemId":"DOC-TX-FC-LGL-SP","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Print","packageType":"","retailPrice":12.0,"bulkPrice":9.0},{"serviceItemId":"DOC-TX-FC-SHT-CS","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Collated Set","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TX-FC-SHT-FT","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Fast Turnaround","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TX-FC-SHT-LC","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Layout Check","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TX-FC-SHT-SP","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Standard Print","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TX-PC-A4-CS","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Collated Set","packageType":"","retailPrice":7.0,"bulkPrice":5.0},{"serviceItemId":"DOC-TX-PC-A4-FT","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Fast Turnaround","packageType":"","retailPrice":7.0,"bulkPrice":5.0},{"serviceItemId":"DOC-TX-PC-A4-LC","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Layout Check","packageType":"","retailPrice":7.0,"bulkPrice":5.0},{"serviceItemId":"DOC-TX-PC-A4-SP","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Print","packageType":"","retailPrice":7.0,"bulkPrice":5.0},{"serviceItemId":"DOC-TX-PC-LGL-CS","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Collated Set","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TX-PC-LGL-FT","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Fast Turnaround","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TX-PC-LGL-LC","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Layout Check","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TX-PC-LGL-SP","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Print","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"DOC-TX-PC-SHT-CS","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Collated Set","packageType":"","retailPrice":6.0,"bulkPrice":4.0},{"serviceItemId":"DOC-TX-PC-SHT-FT","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Fast Turnaround","packageType":"","retailPrice":6.0,"bulkPrice":4.0},{"serviceItemId":"DOC-TX-PC-SHT-LC","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Layout Check","packageType":"","retailPrice":6.0,"bulkPrice":4.0},{"serviceItemId":"DOC-TX-PC-SHT-SP","service":"Document Printing","category":"Printing","printingCategory":"Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Standard Print","packageType":"","retailPrice":6.0,"bulkPrice":4.0}],"id-photo":[{"serviceItemId":"IDP-ID-A-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Background Cleanup","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-BW-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Basic Retouch","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Glossy Finish","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-BW-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Soft Copy Included","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Background Cleanup","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-FC-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Basic Retouch","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Glossy Finish","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-FC-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Soft Copy Included","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-MT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Background Cleanup","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-MT-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Basic Retouch","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-MT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Glossy Finish","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-A-MT-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package A: Mixed 1x1 & 2x2","finishType":"Soft Copy Included","packageType":"Package A","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-B-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package B: 1x1 Set","finishType":"Background Cleanup","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-BW-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package B: 1x1 Set","finishType":"Basic Retouch","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package B: 1x1 Set","finishType":"Glossy Finish","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-BW-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package B: 1x1 Set","finishType":"Soft Copy Included","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package B: 1x1 Set","finishType":"Background Cleanup","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-FC-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package B: 1x1 Set","finishType":"Basic Retouch","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package B: 1x1 Set","finishType":"Glossy Finish","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-FC-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package B: 1x1 Set","finishType":"Soft Copy Included","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-MT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package B: 1x1 Set","finishType":"Background Cleanup","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-MT-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package B: 1x1 Set","finishType":"Basic Retouch","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-MT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package B: 1x1 Set","finishType":"Glossy Finish","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-B-MT-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package B: 1x1 Set","finishType":"Soft Copy Included","packageType":"Package B","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package C: 2x2 Set","finishType":"Background Cleanup","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-BW-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package C: 2x2 Set","finishType":"Basic Retouch","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package C: 2x2 Set","finishType":"Glossy Finish","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-BW-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package C: 2x2 Set","finishType":"Soft Copy Included","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package C: 2x2 Set","finishType":"Background Cleanup","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-FC-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package C: 2x2 Set","finishType":"Basic Retouch","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package C: 2x2 Set","finishType":"Glossy Finish","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-FC-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package C: 2x2 Set","finishType":"Soft Copy Included","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-MT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package C: 2x2 Set","finishType":"Background Cleanup","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-MT-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package C: 2x2 Set","finishType":"Basic Retouch","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-MT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package C: 2x2 Set","finishType":"Glossy Finish","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-C-MT-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package C: 2x2 Set","finishType":"Soft Copy Included","packageType":"Package C","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Background Cleanup","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-BW-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Basic Retouch","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Glossy Finish","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-BW-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Soft Copy Included","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Background Cleanup","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-FC-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Basic Retouch","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Glossy Finish","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-FC-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Soft Copy Included","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-MT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Background Cleanup","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-MT-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Basic Retouch","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-MT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Glossy Finish","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-D-MT-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package D: 1.5 x 1.5 Set","finishType":"Soft Copy Included","packageType":"Package E","retailPrice":45.0,"bulkPrice":35.0},{"serviceItemId":"IDP-ID-E-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package E: Wallet Size Set","finishType":"Background Cleanup","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-BW-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package E: Wallet Size Set","finishType":"Basic Retouch","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package E: Wallet Size Set","finishType":"Glossy Finish","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-BW-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"B&W","productSize":"Package E: Wallet Size Set","finishType":"Soft Copy Included","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package E: Wallet Size Set","finishType":"Background Cleanup","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-FC-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package E: Wallet Size Set","finishType":"Basic Retouch","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package E: Wallet Size Set","finishType":"Glossy Finish","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-FC-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Full Color","productSize":"Package E: Wallet Size Set","finishType":"Soft Copy Included","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-MT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package E: Wallet Size Set","finishType":"Background Cleanup","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-MT-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package E: Wallet Size Set","finishType":"Basic Retouch","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-MT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package E: Wallet Size Set","finishType":"Glossy Finish","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0},{"serviceItemId":"IDP-ID-E-MT-SCI","service":"ID & Photo Services","category":"Photo","printingCategory":"ID Photo","colorMode":"Matte Tone","productSize":"Package E: Wallet Size Set","finishType":"Soft Copy Included","packageType":"Package F","retailPrice":55.0,"bulkPrice":45.0}],"passport-visa":[{"serviceItemId":"IDP-PV-PASS-BW-BCC","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"B&W","productSize":"Passport","finishType":"Background Compliance Check","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-BW-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"B&W","productSize":"Passport","finishType":"Basic Retouch","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"B&W","productSize":"Passport","finishType":"Glossy Finish","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-BW-PCC","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"B&W","productSize":"Passport","finishType":"Passport Crop Check","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-FC-BCC","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Full Color","productSize":"Passport","finishType":"Background Compliance Check","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-FC-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Full Color","productSize":"Passport","finishType":"Basic Retouch","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Full Color","productSize":"Passport","finishType":"Glossy Finish","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-FC-PCC","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Full Color","productSize":"Passport","finishType":"Passport Crop Check","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-SB-BCC","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Studio Bright","productSize":"Passport","finishType":"Background Compliance Check","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-SB-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Studio Bright","productSize":"Passport","finishType":"Basic Retouch","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-SB-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Studio Bright","productSize":"Passport","finishType":"Glossy Finish","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-PASS-SB-PCC","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Studio Bright","productSize":"Passport","finishType":"Passport Crop Check","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-BW-BCC","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"B&W","productSize":"Visa","finishType":"Background Compliance Check","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-BW-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"B&W","productSize":"Visa","finishType":"Basic Retouch","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"B&W","productSize":"Visa","finishType":"Glossy Finish","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-BW-VSR","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"B&W","productSize":"Visa","finishType":"Visa Spec Review","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-FC-BCC","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Full Color","productSize":"Visa","finishType":"Background Compliance Check","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-FC-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Full Color","productSize":"Visa","finishType":"Basic Retouch","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Full Color","productSize":"Visa","finishType":"Glossy Finish","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-FC-VSR","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Full Color","productSize":"Visa","finishType":"Visa Spec Review","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-SB-BCC","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Studio Bright","productSize":"Visa","finishType":"Background Compliance Check","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-SB-BR","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Studio Bright","productSize":"Visa","finishType":"Basic Retouch","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-SB-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Studio Bright","productSize":"Visa","finishType":"Glossy Finish","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0},{"serviceItemId":"IDP-PV-VISA-SB-VSR","service":"ID & Photo Services","category":"Photo","printingCategory":"Passport / Visa","colorMode":"Studio Bright","productSize":"Visa","finishType":"Visa Spec Review","packageType":"Package D","retailPrice":80.0,"bulkPrice":70.0}],"single-photo-print":[{"serviceItemId":"IDP-SP-2R-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"2R (2.5x3.5)","finishType":"Borderless Crop","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"2R (2.5x3.5)","finishType":"Glossy Finish","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-BW-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"2R (2.5x3.5)","finishType":"Matte Finish","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-BW-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"2R (2.5x3.5)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-CT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"2R (2.5x3.5)","finishType":"Borderless Crop","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-CT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"2R (2.5x3.5)","finishType":"Glossy Finish","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-CT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"2R (2.5x3.5)","finishType":"Matte Finish","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-CT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"2R (2.5x3.5)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"2R (2.5x3.5)","finishType":"Borderless Crop","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"2R (2.5x3.5)","finishType":"Glossy Finish","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-FC-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"2R (2.5x3.5)","finishType":"Matte Finish","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-FC-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"2R (2.5x3.5)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-WT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"2R (2.5x3.5)","finishType":"Borderless Crop","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-WT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"2R (2.5x3.5)","finishType":"Glossy Finish","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-WT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"2R (2.5x3.5)","finishType":"Matte Finish","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-2R-WT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"2R (2.5x3.5)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":5.0,"bulkPrice":4.0},{"serviceItemId":"IDP-SP-3R-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"3R (3.5x5.0)","finishType":"Borderless Crop","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"3R (3.5x5.0)","finishType":"Glossy Finish","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-BW-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"3R (3.5x5.0)","finishType":"Matte Finish","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-BW-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"3R (3.5x5.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-CT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"3R (3.5x5.0)","finishType":"Borderless Crop","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-CT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"3R (3.5x5.0)","finishType":"Glossy Finish","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-CT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"3R (3.5x5.0)","finishType":"Matte Finish","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-CT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"3R (3.5x5.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"3R (3.5x5.0)","finishType":"Borderless Crop","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"3R (3.5x5.0)","finishType":"Glossy Finish","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-FC-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"3R (3.5x5.0)","finishType":"Matte Finish","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-FC-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"3R (3.5x5.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-WT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"3R (3.5x5.0)","finishType":"Borderless Crop","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-WT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"3R (3.5x5.0)","finishType":"Glossy Finish","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-WT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"3R (3.5x5.0)","finishType":"Matte Finish","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-3R-WT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"3R (3.5x5.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":8.0,"bulkPrice":6.0},{"serviceItemId":"IDP-SP-4R-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"4R (4.0x6.0)","finishType":"Borderless Crop","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"4R (4.0x6.0)","finishType":"Glossy Finish","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-BW-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"4R (4.0x6.0)","finishType":"Matte Finish","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-BW-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"4R (4.0x6.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-CT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"4R (4.0x6.0)","finishType":"Borderless Crop","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-CT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"4R (4.0x6.0)","finishType":"Glossy Finish","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-CT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"4R (4.0x6.0)","finishType":"Matte Finish","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-CT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"4R (4.0x6.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"4R (4.0x6.0)","finishType":"Borderless Crop","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"4R (4.0x6.0)","finishType":"Glossy Finish","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-FC-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"4R (4.0x6.0)","finishType":"Matte Finish","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-FC-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"4R (4.0x6.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-WT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"4R (4.0x6.0)","finishType":"Borderless Crop","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-WT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"4R (4.0x6.0)","finishType":"Glossy Finish","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-WT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"4R (4.0x6.0)","finishType":"Matte Finish","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-4R-WT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"4R (4.0x6.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":10.0,"bulkPrice":8.0},{"serviceItemId":"IDP-SP-5R-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"5R (5.0x7.0)","finishType":"Borderless Crop","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"5R (5.0x7.0)","finishType":"Glossy Finish","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-BW-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"5R (5.0x7.0)","finishType":"Matte Finish","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-BW-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"5R (5.0x7.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-CT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"5R (5.0x7.0)","finishType":"Borderless Crop","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-CT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"5R (5.0x7.0)","finishType":"Glossy Finish","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-CT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"5R (5.0x7.0)","finishType":"Matte Finish","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-CT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"5R (5.0x7.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"5R (5.0x7.0)","finishType":"Borderless Crop","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"5R (5.0x7.0)","finishType":"Glossy Finish","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-FC-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"5R (5.0x7.0)","finishType":"Matte Finish","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-FC-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"5R (5.0x7.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-WT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"5R (5.0x7.0)","finishType":"Borderless Crop","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-WT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"5R (5.0x7.0)","finishType":"Glossy Finish","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-WT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"5R (5.0x7.0)","finishType":"Matte Finish","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-5R-WT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"5R (5.0x7.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":15.0,"bulkPrice":12.0},{"serviceItemId":"IDP-SP-6R-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"6R (6.0x8.0)","finishType":"Borderless Crop","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"6R (6.0x8.0)","finishType":"Glossy Finish","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-BW-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"6R (6.0x8.0)","finishType":"Matte Finish","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-BW-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"6R (6.0x8.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-CT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"6R (6.0x8.0)","finishType":"Borderless Crop","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-CT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"6R (6.0x8.0)","finishType":"Glossy Finish","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-CT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"6R (6.0x8.0)","finishType":"Matte Finish","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-CT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"6R (6.0x8.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"6R (6.0x8.0)","finishType":"Borderless Crop","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"6R (6.0x8.0)","finishType":"Glossy Finish","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-FC-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"6R (6.0x8.0)","finishType":"Matte Finish","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-FC-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"6R (6.0x8.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-WT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"6R (6.0x8.0)","finishType":"Borderless Crop","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-WT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"6R (6.0x8.0)","finishType":"Glossy Finish","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-WT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"6R (6.0x8.0)","finishType":"Matte Finish","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-6R-WT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"6R (6.0x8.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":25.0,"bulkPrice":20.0},{"serviceItemId":"IDP-SP-8R-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"8R (8.0x10.0)","finishType":"Borderless Crop","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"8R (8.0x10.0)","finishType":"Glossy Finish","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-BW-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"8R (8.0x10.0)","finishType":"Matte Finish","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-BW-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"8R (8.0x10.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-CT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"8R (8.0x10.0)","finishType":"Borderless Crop","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-CT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"8R (8.0x10.0)","finishType":"Glossy Finish","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-CT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"8R (8.0x10.0)","finishType":"Matte Finish","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-CT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"8R (8.0x10.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"8R (8.0x10.0)","finishType":"Borderless Crop","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"8R (8.0x10.0)","finishType":"Glossy Finish","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-FC-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"8R (8.0x10.0)","finishType":"Matte Finish","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-FC-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"8R (8.0x10.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-WT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"8R (8.0x10.0)","finishType":"Borderless Crop","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-WT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"8R (8.0x10.0)","finishType":"Glossy Finish","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-WT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"8R (8.0x10.0)","finishType":"Matte Finish","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-8R-WT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"8R (8.0x10.0)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":40.0,"bulkPrice":32.0},{"serviceItemId":"IDP-SP-A4-BW-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"A4 (8.27x11.69)","finishType":"Borderless Crop","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-BW-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"A4 (8.27x11.69)","finishType":"Glossy Finish","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-BW-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"A4 (8.27x11.69)","finishType":"Matte Finish","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-BW-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"B&W","productSize":"A4 (8.27x11.69)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-CT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"A4 (8.27x11.69)","finishType":"Borderless Crop","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-CT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"A4 (8.27x11.69)","finishType":"Glossy Finish","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-CT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"A4 (8.27x11.69)","finishType":"Matte Finish","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-CT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Cool Tone","productSize":"A4 (8.27x11.69)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-FC-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"A4 (8.27x11.69)","finishType":"Borderless Crop","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-FC-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"A4 (8.27x11.69)","finishType":"Glossy Finish","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-FC-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"A4 (8.27x11.69)","finishType":"Matte Finish","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-FC-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Full Color","productSize":"A4 (8.27x11.69)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-WT-BC","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"A4 (8.27x11.69)","finishType":"Borderless Crop","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-WT-GF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"A4 (8.27x11.69)","finishType":"Glossy Finish","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-WT-MF","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"A4 (8.27x11.69)","finishType":"Matte Finish","packageType":"","retailPrice":50.0,"bulkPrice":40.0},{"serviceItemId":"IDP-SP-A4-WT-PER","service":"ID & Photo Services","category":"Photo","printingCategory":"Single Photo Print","colorMode":"Warm Tone","productSize":"A4 (8.27x11.69)","finishType":"Photo Editing / Retouch","packageType":"","retailPrice":50.0,"bulkPrice":40.0}],"lamination":[{"serviceItemId":"BND-LAM-PRM-A4-CCS","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Premium","productSize":"A4","finishType":"Clear Cover Set","packageType":"","retailPrice":50.0,"bulkPrice":45.0},{"serviceItemId":"BND-LAM-PRM-A4-LC","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Premium","productSize":"A4","finishType":"Laminated Cover","packageType":"","retailPrice":50.0,"bulkPrice":45.0},{"serviceItemId":"BND-LAM-PRM-A4-SF","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Premium","productSize":"A4","finishType":"Spiral Finish","packageType":"","retailPrice":50.0,"bulkPrice":45.0},{"serviceItemId":"BND-LAM-PRM-LGL-CCS","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Premium","productSize":"Legal","finishType":"Clear Cover Set","packageType":"","retailPrice":60.0,"bulkPrice":55.0},{"serviceItemId":"BND-LAM-PRM-LGL-LC","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Premium","productSize":"Legal","finishType":"Laminated Cover","packageType":"","retailPrice":60.0,"bulkPrice":55.0},{"serviceItemId":"BND-LAM-PRM-LGL-SF","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Premium","productSize":"Legal","finishType":"Spiral Finish","packageType":"","retailPrice":60.0,"bulkPrice":55.0},{"serviceItemId":"BND-LAM-STD-A4-CCS","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Standard","productSize":"A4","finishType":"Clear Cover Set","packageType":"","retailPrice":35.0,"bulkPrice":30.0},{"serviceItemId":"BND-LAM-STD-A4-LC","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Standard","productSize":"A4","finishType":"Laminated Cover","packageType":"","retailPrice":35.0,"bulkPrice":30.0},{"serviceItemId":"BND-LAM-STD-A4-SF","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Standard","productSize":"A4","finishType":"Spiral Finish","packageType":"","retailPrice":35.0,"bulkPrice":30.0},{"serviceItemId":"BND-LAM-STD-LGL-CCS","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Standard","productSize":"Legal","finishType":"Clear Cover Set","packageType":"","retailPrice":45.0,"bulkPrice":40.0},{"serviceItemId":"BND-LAM-STD-LGL-LC","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Standard","productSize":"Legal","finishType":"Laminated Cover","packageType":"","retailPrice":45.0,"bulkPrice":40.0},{"serviceItemId":"BND-LAM-STD-LGL-SF","service":"Lamination & Binding","category":"Finishing","printingCategory":"Lamination","colorMode":"Standard","productSize":"Legal","finishType":"Spiral Finish","packageType":"","retailPrice":45.0,"bulkPrice":40.0}],"spiral-binding":[{"serviceItemId":"BND-SPR-PRM-A4-CCS","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Premium","productSize":"A4","finishType":"Clear Cover Set","packageType":"","retailPrice":160.0,"bulkPrice":150.0},{"serviceItemId":"BND-SPR-PRM-A4-LC","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Premium","productSize":"A4","finishType":"Laminated Cover","packageType":"","retailPrice":160.0,"bulkPrice":150.0},{"serviceItemId":"BND-SPR-PRM-A4-SF","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Premium","productSize":"A4","finishType":"Spiral Finish","packageType":"","retailPrice":160.0,"bulkPrice":150.0},{"serviceItemId":"BND-SPR-PRM-LGL-CCS","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Premium","productSize":"Legal","finishType":"Clear Cover Set","packageType":"","retailPrice":180.0,"bulkPrice":170.0},{"serviceItemId":"BND-SPR-PRM-LGL-LC","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Premium","productSize":"Legal","finishType":"Laminated Cover","packageType":"","retailPrice":180.0,"bulkPrice":170.0},{"serviceItemId":"BND-SPR-PRM-LGL-SF","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Premium","productSize":"Legal","finishType":"Spiral Finish","packageType":"","retailPrice":180.0,"bulkPrice":170.0},{"serviceItemId":"BND-SPR-STD-A4-CCS","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Standard","productSize":"A4","finishType":"Clear Cover Set","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"BND-SPR-STD-A4-LC","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Standard","productSize":"A4","finishType":"Laminated Cover","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"BND-SPR-STD-A4-SF","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Standard","productSize":"A4","finishType":"Spiral Finish","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"BND-SPR-STD-LGL-CCS","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Standard","productSize":"Legal","finishType":"Clear Cover Set","packageType":"","retailPrice":140.0,"bulkPrice":130.0},{"serviceItemId":"BND-SPR-STD-LGL-LC","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Standard","productSize":"Legal","finishType":"Laminated Cover","packageType":"","retailPrice":140.0,"bulkPrice":130.0},{"serviceItemId":"BND-SPR-STD-LGL-SF","service":"Lamination & Binding","category":"Finishing","printingCategory":"Spiral Binding","colorMode":"Standard","productSize":"Legal","finishType":"Spiral Finish","packageType":"","retailPrice":140.0,"bulkPrice":130.0}],"sintra-board":[{"serviceItemId":"LFP-SINTRA-A4-BW-3D-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Indoor Display","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-BW-3D-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Photo Finish Check","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-BW-3D-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Ready to Mount","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-BW-BRG-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Indoor Display","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-BW-BRG-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Photo Finish Check","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-BW-BRG-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Ready to Mount","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-BW-CVM-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Indoor Display","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-BW-CVM-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Photo Finish Check","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-BW-CVM-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Ready to Mount","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-BW-GLS-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Indoor Display","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-BW-GLS-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Photo Finish Check","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-BW-GLS-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Ready to Mount","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-BW-GLT-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Indoor Display","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-BW-GLT-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Photo Finish Check","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-BW-GLT-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Ready to Mount","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-BW-LTH-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Indoor Display","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-BW-LTH-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Photo Finish Check","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-BW-LTH-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Ready to Mount","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-BW-MAT-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Indoor Display","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-BW-MAT-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Photo Finish Check","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-BW-MAT-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Ready to Mount","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-BW-R-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Indoor Display","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-BW-R-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Photo Finish Check","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-BW-R-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Ready to Mount","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-FC-3D-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Indoor Display","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-FC-3D-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Photo Finish Check","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-FC-3D-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Ready to Mount","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-FC-BRG-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Indoor Display","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-FC-BRG-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Photo Finish Check","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-FC-BRG-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Ready to Mount","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-FC-CVM-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Indoor Display","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-FC-CVM-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Photo Finish Check","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-FC-CVM-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Ready to Mount","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-FC-GLS-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Indoor Display","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-FC-GLS-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Photo Finish Check","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-FC-GLS-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Ready to Mount","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-FC-GLT-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Indoor Display","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-FC-GLT-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Photo Finish Check","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-FC-GLT-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Ready to Mount","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-FC-LTH-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Indoor Display","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-FC-LTH-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Photo Finish Check","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-FC-LTH-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Ready to Mount","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-FC-MAT-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Indoor Display","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-FC-MAT-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Photo Finish Check","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-FC-MAT-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Ready to Mount","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-FC-R-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Indoor Display","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-FC-R-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Photo Finish Check","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-FC-R-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Ready to Mount","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-HC-3D-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Indoor Display","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-HC-3D-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Photo Finish Check","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-HC-3D-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Ready to Mount","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-HC-BRG-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Indoor Display","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-HC-BRG-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Photo Finish Check","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-HC-BRG-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Ready to Mount","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-HC-CVM-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Indoor Display","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-HC-CVM-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Photo Finish Check","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-HC-CVM-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Ready to Mount","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-HC-GLS-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Indoor Display","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-HC-GLS-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Photo Finish Check","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-HC-GLS-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Ready to Mount","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-HC-GLT-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Indoor Display","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-HC-GLT-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Photo Finish Check","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-HC-GLT-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Ready to Mount","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-HC-LTH-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Indoor Display","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-HC-LTH-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Photo Finish Check","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-HC-LTH-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Ready to Mount","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-HC-MAT-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Indoor Display","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-HC-MAT-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Photo Finish Check","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-HC-MAT-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Ready to Mount","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-HC-R-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Indoor Display","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-HC-R-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Photo Finish Check","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-HC-R-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"High Contrast","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Ready to Mount","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-MT-3D-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Indoor Display","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-MT-3D-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Photo Finish Check","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-MT-3D-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"3D Finish / Ready to Mount","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-MT-BRG-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Indoor Display","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-MT-BRG-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Photo Finish Check","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-MT-BRG-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Broken Glass Finish / Ready to Mount","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-MT-CVM-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Indoor Display","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-MT-CVM-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Photo Finish Check","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-MT-CVM-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Canvas Matte Finish / Ready to Mount","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-MT-GLS-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Indoor Display","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-MT-GLS-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Photo Finish Check","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-MT-GLS-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Glossy Finish / Ready to Mount","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-MT-GLT-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Indoor Display","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-MT-GLT-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Photo Finish Check","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-MT-GLT-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Glittered Finish / Ready to Mount","packageType":"","retailPrice":120.0,"bulkPrice":110.0},{"serviceItemId":"LFP-SINTRA-A4-MT-LTH-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Indoor Display","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-MT-LTH-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Photo Finish Check","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-MT-LTH-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Leather Finish / Ready to Mount","packageType":"","retailPrice":110.0,"bulkPrice":100.0},{"serviceItemId":"LFP-SINTRA-A4-MT-MAT-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Indoor Display","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-MT-MAT-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Photo Finish Check","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-MT-MAT-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Matte Finish / Ready to Mount","packageType":"","retailPrice":100.0,"bulkPrice":90.0},{"serviceItemId":"LFP-SINTRA-A4-MT-R-ID","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Indoor Display","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-MT-R-PFC","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Photo Finish Check","packageType":"","retailPrice":130.0,"bulkPrice":120.0},{"serviceItemId":"LFP-SINTRA-A4-MT-R-RTM","service":"Large Format Printing","category":"Large Format","printingCategory":"Sintra Board Printing","colorMode":"Matte Tone","productSize":"A4 (8.27 x 11.69)","finishType":"Rainbow Finish / Ready to Mount","packageType":"","retailPrice":130.0,"bulkPrice":120.0}],"tarpaulin":[{"serviceItemId":"LFP-TARP-3X4","service":"Large Format Printing","category":"Large Format","printingCategory":"Tarpaulin","colorMode":"Full Color","productSize":"3x4 ft","finishType":"","packageType":"","retailPrice":0,"bulkPrice":0}],"photocopy":[{"serviceItemId":"COPY-BW-A4","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Photocopy","colorMode":"Black and White","productSize":"A4","finishType":"","packageType":"","retailPrice":0,"bulkPrice":6.0}],"scanning":[{"serviceItemId":"PCS-SCAN-TX-A4-BW-ARF","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":5.0,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-BW-MPS","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":5.0,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-BW-STD","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B&W","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":5.0,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-FC-ARF","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":5.0,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-FC-MPS","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":5.0,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-FC-STD","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":5.0,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-PC-ARF","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":5.0,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-PC-MPS","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":5.0,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-PC-STD","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":5.0,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-LGL-BW-ARF","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-BW-MPS","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-BW-STD","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B&W","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-FC-ARF","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-FC-MPS","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-FC-STD","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-PC-ARF","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-PC-MPS","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-PC-STD","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":6.0,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-SHT-BW-ARF","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":4.0,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-BW-MPS","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":4.0,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-BW-STD","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B&W","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":4.0,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-FC-ARF","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":4.0,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-FC-MPS","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":4.0,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-FC-STD","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":4.0,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-PC-ARF","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":4.0,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-PC-MPS","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":4.0,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-PC-STD","service":"Photocopy & Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":4.0,"bulkPrice":2.5}]};

const csvProductExtras={"photocopy-image-only":{"categoryKey":"photo","categoryTitle":"Photocopy \u0026 Scanning","serviceName":"Photocopy / Image Only","title":"Photocopy / Image Only","summaryTitle":"Photocopy / Image Only","serviceId":"PCS-COPY-IM-A4-BW-SRT","retailPrice":8,"bulkPrice":6,"bulkAt":50,"unit":"copies","previewType":"image","previewImage":"Photocopy \u0026 ScanningS.png","rating":"4.8","reviews":73},"photocopy-text-only":{"categoryKey":"photo","categoryTitle":"Photocopy \u0026 Scanning","serviceName":"Photocopy / Text Only","title":"Photocopy / Text Only","summaryTitle":"Photocopy / Text Only","serviceId":"PCS-COPY-TX-A4-BW-SRT","retailPrice":5,"bulkPrice":3.5,"bulkAt":50,"unit":"copies","previewType":"text","previewImage":"PHOTOC (B\u0026W).png","rating":"4.8","reviews":73},"photocopy-text-image":{"categoryKey":"photo","categoryTitle":"Photocopy \u0026 Scanning","serviceName":"Photocopy / Text with Image","title":"Photocopy / Text with Image","summaryTitle":"Photocopy / Text with Image","serviceId":"PCS-COPY-TWI-A4-BW-SRT","retailPrice":5,"bulkPrice":3.5,"bulkAt":50,"unit":"copies","previewType":"text-image","previewImage":"Photocopy \u0026 ScanningS.png","rating":"4.8","reviews":73},"scanning-image-only":{"categoryKey":"photo","categoryTitle":"Photocopy \u0026 Scanning","serviceName":"Scanning / Image Only","title":"Scanning / Image Only","summaryTitle":"Scanning / Image Only","serviceId":"PCS-SCAN-IM-A4-BW-ARF","retailPrice":8,"bulkPrice":6,"bulkAt":50,"unit":"pages","previewType":"image","previewImage":"Photocopy \u0026 ScanningS.png","rating":"4.8","reviews":73},"scanning-text-only":{"categoryKey":"photo","categoryTitle":"Photocopy \u0026 Scanning","serviceName":"Scanning / Text Only","title":"Scanning / Text Only","summaryTitle":"Scanning / Text Only","serviceId":"PCS-SCAN-TX-A4-BW-ARF","retailPrice":5,"bulkPrice":3.5,"bulkAt":50,"unit":"pages","previewType":"text","previewImage":"Photocopy \u0026 ScanningS.png","rating":"4.8","reviews":73},"scanning-text-image":{"categoryKey":"photo","categoryTitle":"Photocopy \u0026 Scanning","serviceName":"Scanning / Text with Image","title":"Scanning / Text with Image","summaryTitle":"Scanning / Text with Image","serviceId":"PCS-SCAN-TWI-A4-BW-ARF","retailPrice":5,"bulkPrice":3.5,"bulkAt":50,"unit":"pages","previewType":"text-image","previewImage":"Photocopy \u0026 ScanningS.png","rating":"4.8","reviews":73}};
const csvVariantExtras={"photocopy-image-only":[{"serviceItemId":"PCS-COPY-IM-A4-BW-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Sorted Set","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-IM-A4-BW-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Stapled Set","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-IM-A4-BW-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Walk-in Copy","packageType":"","retailPrice":8,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-A4-FC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Sorted Set","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-A4-FC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Stapled Set","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-A4-FC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Walk-in Copy","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-A4-PC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Sorted Set","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-A4-PC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Stapled Set","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-A4-PC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Walk-in Copy","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-LGL-BW-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Sorted Set","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-LGL-BW-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Stapled Set","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-LGL-BW-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Walk-in Copy","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-LGL-FC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Sorted Set","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-LGL-FC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Stapled Set","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-LGL-FC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Walk-in Copy","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-LGL-PC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Sorted Set","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-LGL-PC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Stapled Set","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-LGL-PC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Walk-in Copy","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-COPY-IM-SHT-BW-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Sorted Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-IM-SHT-BW-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Stapled Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-IM-SHT-BW-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Walk-in Copy","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-IM-SHT-FC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Sorted Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-IM-SHT-FC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Stapled Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-IM-SHT-FC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Walk-in Copy","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-IM-SHT-PC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Sorted Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-IM-SHT-PC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Stapled Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-IM-SHT-PC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Image Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Walk-in Copy","packageType":"","retailPrice":5,"bulkPrice":3.5}],"photocopy-text-only":[{"serviceItemId":"PCS-COPY-TX-A4-BW-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Sorted Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TX-A4-BW-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Stapled Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TX-A4-BW-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Walk-in Copy","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TX-A4-FC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Sorted Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TX-A4-FC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Stapled Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TX-A4-FC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Walk-in Copy","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TX-A4-PC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Sorted Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TX-A4-PC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Stapled Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TX-A4-PC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Walk-in Copy","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TX-LGL-BW-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Sorted Set","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-COPY-TX-LGL-BW-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Stapled Set","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-COPY-TX-LGL-BW-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Walk-in Copy","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-COPY-TX-LGL-FC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Sorted Set","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-COPY-TX-LGL-FC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Stapled Set","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-COPY-TX-LGL-FC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Walk-in Copy","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-COPY-TX-LGL-PC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Sorted Set","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-COPY-TX-LGL-PC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Stapled Set","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-COPY-TX-LGL-PC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Walk-in Copy","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-COPY-TX-SHT-BW-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Sorted Set","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-COPY-TX-SHT-BW-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Stapled Set","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-COPY-TX-SHT-BW-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Walk-in Copy","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-COPY-TX-SHT-FC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Sorted Set","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-COPY-TX-SHT-FC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Stapled Set","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-COPY-TX-SHT-FC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Walk-in Copy","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-COPY-TX-SHT-PC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Sorted Set","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-COPY-TX-SHT-PC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Stapled Set","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-COPY-TX-SHT-PC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Walk-in Copy","packageType":"","retailPrice":4,"bulkPrice":2.5}],"photocopy-text-image":[{"serviceItemId":"PCS-COPY-TWI-A4-BW-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Sorted Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-A4-BW-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Stapled Set","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-A4-BW-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Walk-in Copy","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-A4-FC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Sorted Set","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-COPY-TWI-A4-FC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Stapled Set","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-COPY-TWI-A4-FC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Walk-in Copy","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-COPY-TWI-A4-PC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Sorted Set","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-COPY-TWI-A4-PC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Stapled Set","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-COPY-TWI-A4-PC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Walk-in Copy","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-COPY-TWI-LGL-BW-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Sorted Set","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-TWI-LGL-BW-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Stapled Set","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-TWI-LGL-BW-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Walk-in Copy","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-TWI-LGL-FC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Sorted Set","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-TWI-LGL-FC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Stapled Set","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-TWI-LGL-FC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Walk-in Copy","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-TWI-LGL-PC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Sorted Set","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-TWI-LGL-PC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Stapled Set","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-TWI-LGL-PC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Walk-in Copy","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-COPY-TWI-SHT-BW-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Sorted Set","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-SHT-BW-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Stapled Set","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-SHT-BW-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Walk-in Copy","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-SHT-FC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Sorted Set","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-SHT-FC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Stapled Set","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-SHT-FC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Walk-in Copy","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-SHT-PC-SRT","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Sorted Set","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-SHT-PC-STP","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Stapled Set","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-COPY-TWI-SHT-PC-WIC","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Photocopy / Text with Image","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Walk-in Copy","packageType":"","retailPrice":4,"bulkPrice":3.5}],"scanning-image-only":[{"serviceItemId":"PCS-SCAN-IM-A4-BW-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-IM-A4-BW-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-IM-A4-BW-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":8,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-A4-FC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-A4-FC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-A4-FC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-A4-PC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-A4-PC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-A4-PC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-LGL-BW-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-LGL-BW-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-LGL-BW-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-LGL-FC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-LGL-FC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-LGL-FC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-LGL-PC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-LGL-PC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-LGL-PC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":10,"bulkPrice":8},{"serviceItemId":"PCS-SCAN-IM-SHT-BW-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-IM-SHT-BW-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-IM-SHT-BW-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-IM-SHT-FC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-IM-SHT-FC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-IM-SHT-FC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-IM-SHT-PC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-IM-SHT-PC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-IM-SHT-PC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Image Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":5,"bulkPrice":3.5}],"scanning-text-only":[{"serviceItemId":"PCS-SCAN-TX-A4-BW-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-BW-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-BW-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-FC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-FC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-FC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-PC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-PC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-A4-PC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TX-LGL-BW-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-BW-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-BW-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-FC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-FC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-FC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-PC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-PC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-LGL-PC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":6,"bulkPrice":4.5},{"serviceItemId":"PCS-SCAN-TX-SHT-BW-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-BW-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-BW-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-FC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-FC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-FC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-PC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-PC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":4,"bulkPrice":2.5},{"serviceItemId":"PCS-SCAN-TX-SHT-PC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text Only","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":4,"bulkPrice":2.5}],"scanning-text-image":[{"serviceItemId":"PCS-SCAN-TWI-A4-BW-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-A4-BW-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-A4-BW-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"B\u0026W","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":5,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-A4-FC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-SCAN-TWI-A4-FC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-SCAN-TWI-A4-FC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Full Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-SCAN-TWI-A4-PC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Archive-ready File","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-SCAN-TWI-A4-PC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Multi-page Scan","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-SCAN-TWI-A4-PC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Partial Color","productSize":"A4 (8.27 x 11.69)","finishType":"Standard Scan","packageType":"","retailPrice":7,"bulkPrice":5.5},{"serviceItemId":"PCS-SCAN-TWI-LGL-BW-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-TWI-LGL-BW-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-TWI-LGL-BW-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"B\u0026W","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-TWI-LGL-FC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-TWI-LGL-FC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-TWI-LGL-FC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Full Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-TWI-LGL-PC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Archive-ready File","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-TWI-LGL-PC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Multi-page Scan","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-TWI-LGL-PC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Partial Color","productSize":"Legal (8.5 x 14)","finishType":"Standard Scan","packageType":"","retailPrice":8,"bulkPrice":6},{"serviceItemId":"PCS-SCAN-TWI-SHT-BW-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-SHT-BW-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-SHT-BW-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"B\u0026W","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-SHT-FC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-SHT-FC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-SHT-FC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Full Color","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-SHT-PC-ARF","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Archive-ready File","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-SHT-PC-MPS","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Multi-page Scan","packageType":"","retailPrice":4,"bulkPrice":3.5},{"serviceItemId":"PCS-SCAN-TWI-SHT-PC-STD","service":"Photocopy \u0026 Scanning","category":"Printing","printingCategory":"Scanning / Text with Image","colorMode":"Partial Color","productSize":"Short (8.5 x 11)","finishType":"Standard Scan","packageType":"","retailPrice":4,"bulkPrice":3.5}]};
Object.assign(products,csvProductExtras);
Object.assign(serviceVariants,csvVariantExtras);


let state={productKey:"text-only",product:products["text-only"],selectedFile:null},cache={};

const el={root:$("#serviceDetail"),crumbCategory:$("#pdvCrumbCategory"),crumbService:$("#pdvCrumbService"),title:$("#pdvTitle"),subtitle:$("#pdvSubtitle"),preview:$("#pdvPreviewDocument"),cat:$("#pdvPrintingCategory"),color:$("#pdvColorVariation"),paper:$("#pdvPaperSize"),qty:$("#pdvQty"),svc:$("#pdvServiceOption"),ftype:$("#pdvFileType"),sumTitle:$("#pdvSummaryTitle"),sumMeta:$("#pdvSummaryMeta"),sumQty:$("#pdvSummaryQty"),sumThumb:$("#pdvSummaryThumb"),retail:$("#pdvRetailPrice"),bulk:$("#pdvBulkPrice"),retailCard:$("#pdvRetailPriceCard"),bulkCard:$("#pdvBulkPriceCard"),bulkHint:$("#pdvBulkHint"),mode:$("#pdvPriceMode"),total:$("#pdvEstimatedTotal"),ratingText:$("#pdvRatingText"),reviewText:$("#pdvReviewText"),duplex:$("#pdvAddonDuplex"),staple:$("#pdvAddonStaple"),env:$("#pdvAddonEnvelope"),file:$("#pdvFileInput"),upload:$("#pdvUploadBox"),fileResult:$("#pdvFileResult"),fileName:$("#pdvFileName"),checkout:$("#pdvCheckoutBtn"),note:$("#pdvCheckoutNote"),toast:$("#pdvToast"),drawer:$("#pdvReviewDrawer"),rTitle:$("#pdvReviewTitle"),rAvg:$("#pdvReviewAvg"),rCount:$("#pdvReviewCount"),bars:$("#pdvReviewBars")};

const money=v=>Number(v||0).toFixed(2),key=v=>String(v||"").toLowerCase().trim().replace(/&/g,"and").replace(/[^a-z0-9]+/g,"-").replace(/^-+|-+$/g,""),esc=v=>String(v||"").replace(/[&<>"']/g,m=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#039;"}[m]));

const json=(k,f="[]")=>{try{return JSON.parse(localStorage.getItem(k)||f)}catch(e){return JSON.parse(f)}},save=(k,v)=>localStorage.setItem(k,JSON.stringify(v));

function toast(m){el.toast.textContent=m;el.toast.classList.add("is-visible");clearTimeout(toast.t);toast.t=setTimeout(()=>el.toast.classList.remove("is-visible"),2600)}

function txt(s){return s?.options?.[s.selectedIndex]?.text||""}
function q(forceOne=false){let raw=String(el.qty.value||"").replace(/\D/g,"");if(raw!==el.qty.value)el.qty.value=raw;if(raw===""){if(forceOne){el.qty.value="1";return 1}return 0}let v=Math.max(1,Math.min(999,parseInt(raw,10)||0));el.qty.value=String(v);return v}

function step(n){d.querySelectorAll("#serviceDetail .pdv-step").forEach(i=>{let x=+i.dataset.step;i.classList.toggle("is-active",x===n);i.classList.toggle("is-done",x<n);x===n?i.setAttribute("aria-current","step"):i.removeAttribute("aria-current")})}

function variantRows(p=state.product){return serviceVariants[state.productKey]||serviceVariants[key(p?.serviceName)]||[]}
function uniqueOptions(rows,field,fallback){let seen=new Set(),out=[];(rows||[]).forEach(r=>{let value=String(r[field]||"").trim();if(value&&!seen.has(value)){seen.add(value);out.push([value,value])}});return out.length?out:fallback}
function setSelectOptions(select,options,preferred){let current=preferred??select.value;select.innerHTML=options.map(o=>`<option value="${esc(o[0])}">${esc(o[1])}</option>`).join("");if([...select.options].some(o=>o.value===current))select.value=current}
function selectOptions(p){let cat={doc:[["text-only","Text Only"],["text-image","Text with Image"],["image-only","Image Only"]],photo:[["photocopy","Photocopy"],["photocopy-text-only","Photocopy / Text Only"],["photocopy-text-image","Photocopy / Text with Image"],["photocopy-image-only","Photocopy / Image Only"],["scanning","Scanning / Text Only"],["scanning-text-image","Scanning / Text with Image"],["scanning-image-only","Scanning / Image Only"]],id:[["id-photo","ID Photo"],["passport-visa","Passport / Visa"],["single-photo-print","Single Photo Print"]],bind:[["lamination","Lamination"],["spiral-binding","Spiral Binding"]],largeformat:[["sintra-board","Sintra Board Printing"],["tarpaulin","Tarpaulin"]],special:[["custom-layout","Custom Layout"],["marketing-collateral","Marketing Collateral"],["sticker-cut","Sticker Cut"]]}[p.categoryKey]||[];el.cat.innerHTML=cat.map(o=>`<option value="${o[0]}">${o[1]}</option>`).join("");el.cat.value=state.productKey;let rows=variantRows(p),fallbackColors=p.categoryKey==="id"?[["B&W","B&W"],["Full Color","Full Color"],["Matte Tone","Matte Tone"]]:["largeformat","special"].includes(p.categoryKey)?[["Standard Production","Standard Production"],["Premium Production","Premium Production"]]:[["B&W","B&W"],["Partial Color","Partial Color"],["Full Color","Full Color"]],fallbackPapers=p.categoryKey==="id"?[["Package A: Mixed 1x1 & 2x2","Package A: Mixed 1x1 & 2x2"],["Package B: 1x1 Set","Package B: 1x1 Set"],["Package C: 2x2 Set","Package C: 2x2 Set"],["Passport","Passport"],["Visa","Visa"]]:p.categoryKey==="largeformat"?[["A4 (8.27 x 11.69)","A4 (8.27 x 11.69)"],["3x4 ft","3x4 ft"]]:[["Short (8.5 x 11)","Short (8.5 x 11)"],["A4 (8.27 x 11.69)","A4 (8.27 x 11.69)"],["Legal (8.5 x 14)","Legal (8.5 x 14)"]];setSelectOptions(el.color,uniqueOptions(rows,"colorMode",fallbackColors));setSelectOptions(el.paper,uniqueOptions(rows,"productSize",fallbackPapers));let finishOptions=uniqueOptions(rows,"finishType",[["Standard Service","Standard Service"]]);setSelectOptions(el.svc,finishOptions)}

function imgPaths(p){let list=[p.previewImage,...(p.previewImageCandidates||[]),p.title+".png",p.serviceName+".png",key(p.title)+".png"].filter(Boolean),folders=["","./","images/","images/services/","assets/images/","uploads/services/"];return[...new Set(list.flatMap(f=>folders.map(x=>x+f).concat(folders.map(x=>(x+f).split("/").map(encodeURIComponent).join("/")))))]}

function setImg(img,p,fail){let ck=p.serviceId+p.previewImage;if(cache[ck]){img.src=cache[ck];return}let arr=imgPaths(p),i=0,probe=new Image();probe.onload=()=>{cache[ck]=arr[i-1];img.src=cache[ck]};probe.onerror=()=>{i<arr.length?probe.src=arr[i++]:fail&&fail()};probe.src=arr[i++]}

function thumbs(p){let map={doc:[["text-only","TEXT ONLY","pdv-thumb-text"],["text-image","TEXT WITH IMAGE","pdv-thumb-image"],["image-only","IMAGE ONLY","pdv-thumb-grid"]],photo:[["photocopy","PHOTOCOPY","pdv-thumb-text"],["photocopy-text-only","COPY TEXT","pdv-thumb-text"],["photocopy-text-image","COPY TEXT+IMAGE","pdv-thumb-image"],["photocopy-image-only","COPY IMAGE","pdv-thumb-grid"],["scanning","SCAN TEXT","pdv-thumb-text"],["scanning-text-image","SCAN TEXT+IMAGE","pdv-thumb-image"],["scanning-image-only","SCAN IMAGE","pdv-thumb-grid"]],id:[["id-photo","ID PHOTO","pdv-thumb-grid"],["passport-visa","PASSPORT/VISA","pdv-thumb-image"],["single-photo-print","PHOTO PRINT","pdv-thumb-grid"]],bind:[["lamination","LAMINATION","pdv-thumb-text"],["spiral-binding","SPIRAL BINDING","pdv-thumb-image"]],largeformat:[["sintra-board","SINTRA BOARD","pdv-thumb-grid"],["tarpaulin","TARPAULIN","pdv-thumb-image"]],special:[["custom-layout","CUSTOM LAYOUT","pdv-thumb-grid"],["marketing-collateral","MARKETING","pdv-thumb-grid"],["sticker-cut","STICKER CUT","pdv-thumb-grid"]]}[p.categoryKey]||[];$("#pdvThumbStack").innerHTML=map.map(x=>{let pr=products[x[0]],real=pr?.previewImage;return`<button type="button" class="pdv-thumb ${real?"has-real-thumb":""} ${state.productKey===x[0]?"is-active":""}" data-option="${x[0]}"><span class="pdv-thumb-paper ${x[2]} ${real?"is-real-thumb":""}">${real?`<img class="pdv-thumb-real-img" alt="${esc(x[1])}">`:`<b></b><em></em><em></em><em></em><i></i><i></i><i></i>`}</span><strong>${x[1]}</strong></button>`}).join("");d.querySelectorAll("#pdvThumbStack .pdv-thumb").forEach(btn=>{let pr=products[btn.dataset.option],img=btn.querySelector("img");if(img)setImg(img,pr,()=>{btn.classList.remove("has-real-thumb");btn.querySelector("span").classList.remove("is-real-thumb");btn.querySelector("span").innerHTML="<b></b><em></em><em></em><em></em><i></i><i></i><i></i>"})})}

function preview(p){el.preview.className="pdv-document-preview";if(p.previewImage){el.preview.className="pdv-document-preview is-real-image-preview";el.preview.innerHTML=`<img class="pdv-real-preview-img" alt="${esc(p.title)} preview">`;setImg(el.preview.querySelector("img"),p,()=>{el.preview.className="pdv-document-preview";el.preview.innerHTML=`<div class="pdv-image-missing"><i class="fa-regular fa-image"></i><strong>Preview image not found</strong><small>Place <b>${esc(p.previewImage)}</b> inside your root or images folder.</small></div>`});return}el.preview.innerHTML=`<h4>${p.serviceName} Sample Layout</h4><p>This preview represents a clean black and white document print with readable margins and sharp text output.</p><p>Please check the file before uploading. The final print will follow the uploaded file layout, selected paper size, color option, and quantity.</p><p>For best results, upload a ready-to-print PDF or document file with the correct page setup.</p><p>Make sure names, page numbers, images, and margins are already reviewed before checkout.</p>`}

function summaryThumb(p){if(p.previewImage){el.sumThumb.classList.add("is-real-summary");el.sumThumb.innerHTML=`<img class="pdv-summary-real-img" alt="${esc(p.title)} preview">`;setImg(el.sumThumb.querySelector("img"),p,()=>{el.sumThumb.classList.remove("is-real-summary");el.sumThumb.innerHTML="<span></span>"})}else{el.sumThumb.classList.remove("is-real-summary");el.sumThumb.innerHTML="<span></span>"}}

function open(k,payload={},opt={}){let p=products[key(k)]||products["text-only"];state.productKey=products[key(k)]?key(k):"text-only";state.product=p;if(!opt.keepQty)el.qty.value="";el.root.classList.add("pdv-is-open");el.crumbCategory.textContent=p.categoryTitle;el.crumbService.textContent=p.serviceName;el.title.textContent=p.title;el.subtitle.textContent=p.serviceName==="Photocopy"?"High-quality black & white photocopies for documents of all sizes.":p.serviceName==="Scanning"?"Clean document scanning with organized digital output.":`High-quality ${p.serviceName.toLowerCase()} service with clean, ready-to-submit output.`;el.ratingText.textContent=p.rating;el.reviewText.textContent=p.reviews+" Reviews";selectOptions(p);thumbs(p);preview(p);summaryThumb(p);step(opt.step||1);pdvUpdateOrder();if(opt.scroll)requestAnimationFrame(()=>el.root.scrollIntoView({behavior:"smooth",block:"start"}))}

function normVariant(v){return String(v||"").toLowerCase().replace(/&/g,"and").replace(/[^a-z0-9]+/g,"").trim()}
function currentVariant(){let rows=variantRows(),color=normVariant(el.color.value),paper=normVariant(el.paper.value),finish=normVariant(el.svc.value),score=row=>{let s=0,hasFinish=String(row.finishType||"").trim();if(color&&normVariant(row.colorMode)===color)s+=8;if(paper&&normVariant(row.productSize)===paper)s+=8;if(finish&&hasFinish&&normVariant(row.finishType)===finish)s+=6;if(!hasFinish&&!finish)s+=2;return s};if(!rows.length)return null;let exact=rows.filter(r=>(!color||normVariant(r.colorMode)===color)&&(!paper||normVariant(r.productSize)===paper)&&(!finish||!r.finishType||normVariant(r.finishType)===finish));if(exact.length)return exact[0];return rows.slice().sort((a,b)=>score(b)-score(a))[0]||null}
function activeRetailPrice(){let v=currentVariant(),p=state.product;return v?Number(v.retailPrice)||0:p.retailPrice}
function activeBulkPrice(){let v=currentVariant(),p=state.product;return v?Number(v.bulkPrice)||0:p.bulkPrice}
function activeServiceId(){let v=currentVariant(),p=state.product;return (v&&v.serviceItemId)||p.serviceId}
function calc(){let n=q(false),p=state.product,retail=activeRetailPrice(),bulk=activeBulkPrice(),base=n>=p.bulkAt?bulk:retail,unit=base+(el.duplex.checked?.5:0),flat=n?((el.staple.checked?1:0)+(el.env.checked?3:0)):0;return{qty:n,base,unitPrice:unit,total:unit*n+flat,isBulk:n>=p.bulkAt,variant:currentVariant(),retailPrice:retail,bulkPrice:bulk,serviceId:activeServiceId()}}

window.pdvUpdateOrder=function(){let o=calc(),p=state.product,unit=o.qty>1?p.unit:p.unit.replace(/s$/," ").trim(),serviceId=document.getElementById("pdvServiceIdText");el.sumTitle.textContent=p.summaryTitle;el.sumMeta.textContent=txt(el.paper)+" - "+txt(el.color);el.sumQty.textContent=o.qty?o.qty+" "+unit+" \u2022 "+txt(el.svc):"Quantity not selected \u2022 "+txt(el.svc);el.retail.textContent=money(o.retailPrice);el.bulk.textContent=money(o.bulkPrice);el.total.textContent=money(o.total);if(serviceId)serviceId.textContent=o.serviceId;el.mode.textContent=!o.qty?"Select quantity using the \u2212 / + buttons or type the number to calculate total amount.":o.isBulk?`Bulk pricing is active because quantity reached ${p.bulkAt} ${p.unit}.`:`Retail pricing applies below ${p.bulkAt} ${p.unit}. Click Bulk Price to jump to bulk quantity.`;el.retailCard.classList.toggle("is-active",!o.isBulk);el.bulkCard.classList.toggle("is-active",o.isBulk);el.bulkHint.textContent=`Click for ${p.bulkAt}+ ${p.unit.replace(/s$/,"")}`;el.checkout.disabled=false;el.checkout.classList.toggle("is-disabled",!state.selectedFile||!o.qty);el.note.querySelector("small").textContent=state.selectedFile?"File uploaded. Please confirm that this is the correct file before checkout.":"Checkout will be allowed only after a file is uploaded."};

window.pdvGetCurrentServiceId=()=>activeServiceId();
window.pdvHandleCategoryChange=()=>open(el.cat.value,null,{step:2});
window.pdvHandleQtyInput=()=>{q(false);step(2);pdvUpdateOrder()};
window.pdvChangeQty=n=>{let current=q(false),next=current?current+n:1;el.qty.value=String(Math.max(1,Math.min(999,next)));step(2);pdvUpdateOrder()};
window.pdvSelectPriceMode=m=>{let p=state.product,current=q(false);if(m==="bulk"&&current<p.bulkAt){el.qty.value=p.bulkAt;toast(`Bulk price selected. Quantity set to ${p.bulkAt} ${p.unit}.`)}else if(m==="retail"&&current>=p.bulkAt){el.qty.value=Math.max(1,p.bulkAt-1);toast("Retail price selected. Quantity adjusted below bulk level.")}else if(m==="retail"&&!current){el.qty.value="1";toast("Retail price selected. Quantity set to 1.")}step(2);pdvUpdateOrder()};
window.pdvPrevPreview=()=>{let b=[...d.querySelectorAll("#pdvThumbStack .pdv-thumb")],i=b.findIndex(x=>x.classList.contains("is-active"));if(b.length)open(b[(i<=0?b.length:i)-1].dataset.option,null,{step:1})};
window.pdvNextPreview=()=>{let b=[...d.querySelectorAll("#pdvThumbStack .pdv-thumb")],i=b.findIndex(x=>x.classList.contains("is-active"));if(b.length)open(b[(i+1)%b.length].dataset.option,null,{step:1})};
window.pdvFocusOptions=()=>{$("#serviceDetail .pdv-options-card").scrollIntoView({behavior:"smooth",block:"center"});step(2)};
function setFile(f){if(!f)return;let ext=(f.name.split(".").pop()||"").toLowerCase();if(f.size>50*1024*1024)return toast("File is too large. Maximum allowed file size is 50MB.");if(!["pdf","doc","docx","txt","jpg","jpeg","png"].includes(ext))return toast("Invalid file type. Please upload PDF, DOC, DOCX, TXT, JPG, or PNG.");state.selectedFile={name:f.name,size:f.size,type:f.type||ext,extension:ext,lastModified:f.lastModified||Date.now()};state.selectedFileObject=f;var nf=document.getElementById("pdvNoFileText");if(nf)nf.textContent=f.name;el.fileName.textContent=f.name;el.fileResult.classList.add("is-visible");el.upload.classList.remove("is-dragging");step(3);pdvUpdateOrder();toast("File uploaded: "+f.name)}

window.pdvClearFile=()=>{state.selectedFile=null;state.selectedFileObject=null;el.file.value="";var nf=document.getElementById("pdvNoFileText");if(nf)nf.textContent="No file chosen";el.fileResult.classList.remove("is-visible");el.fileName.textContent="No file selected";step(2);pdvUpdateOrder();toast("File removed. Upload is required before checkout.")};

window.pdvRestoreBackendDraft=function(draft){
  if(!draft||typeof draft!=="object")return;
  let serviceKey=key(draft.service_key||"text-only");
  if(products[serviceKey])open(serviceKey,null,{step:1,scroll:false});
  const setValue=(select,value)=>{if(value&&[...select.options].some(option=>option.value===value||option.text===value)){let match=[...select.options].find(option=>option.value===value||option.text===value);select.value=match.value}};
  setValue(el.cat,draft.printing_category);setValue(el.color,draft.color_variation);setValue(el.paper,draft.paper_size);setValue(el.svc,draft.service_option);setValue(el.ftype,draft.file_type);
  el.qty.value=draft.quantity?String(draft.quantity):"";
  el.duplex.checked=!!draft.addons?.double_sided;el.staple.checked=!!draft.addons?.collated_stapled;el.env.checked=!!draft.addons?.document_envelope;
  if(draft.file?.name){state.selectedFile={name:draft.file.name,size:draft.file.size||0,type:draft.file.type||"",lastModified:Date.now()};var nf=document.getElementById("pdvNoFileText");if(nf)nf.textContent=draft.file.name;el.fileName.textContent=draft.file.name;el.fileResult.classList.add("is-visible")}
  pdvUpdateOrder();
};

function order(status){let o=calc(),p=state.product,f=state.selectedFile,v=o.variant||{};return{id:(status==="checkout"?"CHK":"CRT")+"-"+Date.now().toString(36).toUpperCase()+"-"+Math.random().toString(36).slice(2,7).toUpperCase(),status,serviceKey:state.productKey,category:p.categoryTitle,serviceName:p.serviceName,serviceId:o.serviceId,serviceItemId:o.serviceId,service_item_id:o.serviceId,printingCategory:txt(el.cat),colorVariation:txt(el.color),paperSize:txt(el.paper),quantity:o.qty,unit:p.unit,bulkAt:p.bulkAt,serviceOption:txt(el.svc),fileType:txt(el.ftype),fileName:f?f.name:null,fileMeta:f,retailPrice:o.retailPrice,bulkPrice:o.bulkPrice,priceMode:o.isBulk?"Bulk":"Retail",unitPrice:+money(o.unitPrice),catalogVariation:{service:v.service||"",category:v.category||"",printingCategory:v.printingCategory||"",colorMode:v.colorMode||"",productSize:v.productSize||"",finishType:v.finishType||"",packageType:v.packageType||""},addons:{doubleSided:el.duplex.checked,collatedStapled:el.staple.checked,documentEnvelope:el.env.checked},total:+money(o.total),createdAt:new Date().toISOString()}}

function currentImg(){let img=$("#pdvSummaryThumb img")||$("#pdvPreviewDocument img")||$("#pdvThumbStack .pdv-thumb.is-active img");return img?.getAttribute("src")||""}

window.addToCart=()=>{if(typeof requireSignedInForOrder==="function"&&!requireSignedInForOrder())return false;let o=order("cart");if(!o.quantity){el.qty.focus();return toast("Please set the quantity first using the − / + buttons.")}let qty=Math.max(1,parseInt(o.quantity)||1),flat=+(money(o.total-o.unitPrice*qty)),item={id:o.id,name:o.serviceName,unitPrice:+money(o.unitPrice),price:+money(o.unitPrice),flatFee:Math.max(0,flat),qty,lineTotal:+money(o.total),image:currentImg(),meta:[o.category,o.paperSize+(o.colorVariation?" - "+o.colorVariation:""),o.serviceOption,o.fileName?"File: "+o.fileName:""].filter(Boolean),raw:o};if(window.addToPrintifyCart)window.addToPrintifyCart(item,{rawOrder:o,merge:false,open:true});if(state.selectedFileObject&&typeof window.uploadCartAttachment==="function")window.uploadCartAttachment(item.id,state.selectedFileObject).catch(()=>toast("Cart saved, but the attachment could not be uploaded."));toast(`Added to cart: ${o.serviceName} • ₱${money(o.total)}`)};

window.placeOrderNow=()=>{if(typeof requireSignedInForOrder==="function"&&!requireSignedInForOrder())return false;if(!state.selectedFile){step(3);el.file.click();toast("Please upload a file first before checkout.");return}let o=order("checkout"),list=json("printifyCheckout");list.push(o);save("printifyCheckout",list);save("printifyActiveCheckout",o);save("printifyCheckoutItems",[o]);save("printifyCheckoutSource","direct");step(4);toast(`Proceeding to checkout: ${o.serviceName} • ₱${money(o.total)}`);if(typeof window.openCheckoutSection==="function")return window.openCheckoutSection(o);window.location.href="/checkout"};

window.downloadSampleGuide=()=>{let blob=new Blob([["PRINTIFY & CO. PRINT GUIDE","Service: "+state.product.summaryTitle,"Accepted files: PDF, DOC, DOCX, TXT, JPG, PNG","Maximum file size: 50MB","Reminder: Review layout, margins, and page order before checkout."].join("\n")],{type:"text/plain"}),url=URL.createObjectURL(blob),a=d.createElement("a");a.href=url;a.download="printify-print-guide.txt";d.body.appendChild(a);a.click();a.remove();URL.revokeObjectURL(url);toast("Print guide downloaded.")};

window.pdvOpenReviews=()=>{let p=state.product,avg=parseFloat(p.rating)||4.7,base=Math.round(avg*20),bars=[Math.min(96,base),Math.round(base*.18),Math.round(base*.08),Math.round(base*.04),Math.round(base*.02)];el.rTitle.textContent=p.title;el.rAvg.textContent=p.rating;el.rCount.textContent=p.reviews+" reviews";el.bars.innerHTML=bars.map((v,i)=>`<div class="pdv-review-bar"><span>${5-i} stars</span><div class="pdv-review-track"><div class="pdv-review-fill" style="width:${v}%"></div></div><strong>${v}%</strong></div>`).join("");el.drawer.classList.add("is-visible");save("printifyLastViewedReviews",{serviceKey:state.productKey,serviceId:p.serviceId,rating:p.rating,reviews:p.reviews,viewedAt:new Date().toISOString()})};
window.pdvCloseReviews=()=>el.drawer.classList.remove("is-visible");

function bind(){d.addEventListener("click",e=>{let t=e.target.closest("#pdvThumbStack .pdv-thumb");if(t?.dataset.option)open(t.dataset.option,null,{step:1})});
["dragenter","dragover"].forEach(x=>el.upload.addEventListener(x,e=>{e.preventDefault();el.upload.classList.add("is-dragging");step(3)}));
["dragleave","drop"].forEach(x=>el.upload.addEventListener(x,e=>{e.preventDefault();if(x==="drop"&&e.dataTransfer.files?.[0])setFile(e.dataTransfer.files[0]);else el.upload.classList.remove("is-dragging")}));
el.file.addEventListener("change",function(){if(this.files?.[0])setFile(this.files[0])});
[el.color,el.paper,el.qty,el.svc,el.ftype,el.duplex,el.staple,el.env].forEach(x=>["change","input","focus"].forEach(ev=>x.addEventListener(ev,()=>{step(2);pdvUpdateOrder()})));
window.addEventListener("printifyServiceSelected",e=>
window.openPrintifyServiceDetail(e.detail||"text-only",true))}

window.openPrintifyServiceDetail=(payload,scroll)=>{let k=typeof payload==="string"?payload:(payload?.serviceSlug||payload?.slug||payload?.serviceName||payload?.categoryKey||"text-only");if(typeof setStandalonePage==="function")setStandalonePage("service-details");else document.body.classList.add("service-detail-open");if(typeof updateBrowserUrl==="function")updateBrowserUrl("service-details");open(k,payload,{step:1,scroll:scroll!==false})};
bind();
let payload=null;
try{payload=JSON.parse(sessionStorage.getItem("selectedPrintifyService")||"null")}catch(e){}
const isServiceDetailRoute=/\/service-details?\/?$/i.test(location.pathname);
const queryService=new URLSearchParams(window.location.search).get("service");
if(queryService)
window.openPrintifyServiceDetail(queryService,true);else if(payload)
{if(isServiceDetailRoute)window.openPrintifyServiceDetail(payload,true)}else if(location.hash==="#serviceDetail"||isServiceDetailRoute)open("text-only",null,{step:1,scroll:false})})();
</script>

<style id="service-detail-cart-final-motion-lock">
body #pfyCartPanel{
  top:72px!important;
  transform:none!important;
  transform-origin:top right!important;
  transition:opacity .13s ease-out!important;
  will-change:opacity!important;
}
body #pfyCartPanel.show{transform:none!important}
body #pfyCartPanel:before{top:-6px!important;transition:none!important}
body #pfyCartBackdrop{transition:opacity .13s ease-out!important}
body.front-route-service-details:not(.service-detail-hydrated) #serviceDetail,
body.front-route-service-details:not(.service-detail-hydrated) #mainHeader{visibility:hidden!important}
</style>

<script id="service-detail-backend-finalization">
(function(){
  if(window.__serviceDetailBackendFinalized)return;
  window.__serviceDetailBackendFinalized=true;
  window.__PFY_DISABLE_LEGACY_CART_PATCHES=true;
  var csrf=(document.querySelector('meta[name="csrf-token"]')||{}).content||'';
  var draftTimer=0;

  function selectedText(id){var el=document.getElementById(id);return el&&el.options&&el.selectedIndex>-1?el.options[el.selectedIndex].text:''}
  function draftPayload(){
    var quantity=parseInt(document.getElementById('pdvQty')?.value,10)||0;
    var bulkCard=document.getElementById('pdvBulkPriceCard');
    return {
      service_key:document.getElementById('pdvPrintingCategory')?.value||'text-only',
      service_id:document.getElementById('pdvServiceIdText')?.textContent?.trim()||null,
      printing_category:selectedText('pdvPrintingCategory'),
      color_variation:selectedText('pdvColorVariation'),
      paper_size:selectedText('pdvPaperSize'),
      quantity:quantity,
      service_option:selectedText('pdvServiceOption'),
      file_type:selectedText('pdvFileType'),
      price_mode:bulkCard?.classList.contains('is-active')?'Bulk':'Retail',
      unit_price:Number((bulkCard?.classList.contains('is-active')?document.getElementById('pdvBulkPrice'):document.getElementById('pdvRetailPrice'))?.textContent||0),
      total:Number(document.getElementById('pdvEstimatedTotal')?.textContent||0),
      addons:{
        double_sided:!!document.getElementById('pdvAddonDuplex')?.checked,
        collated_stapled:!!document.getElementById('pdvAddonStaple')?.checked,
        document_envelope:!!document.getElementById('pdvAddonEnvelope')?.checked
      }
    };
  }

  async function saveDraft(){
    var response=await fetch('{{ route('service-details.update') }}',{
      method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf},credentials:'same-origin',body:JSON.stringify(draftPayload())
    });
    if(!response.ok)throw new Error('Unable to save service details.');
    return response.json();
  }

  function scheduleDraftSave(){
    clearTimeout(draftTimer);
    draftTimer=setTimeout(function(){saveDraft().catch(function(){})},160);
  }

  async function uploadDraftFile(file){
    await saveDraft();
    var body=new FormData();body.append('file',file);
    var response=await fetch('{{ route('service-details.upload') }}',{
      method:'POST',headers:{'Accept':'application/json','X-CSRF-TOKEN':csrf},credentials:'same-origin',body:body
    });
    if(!response.ok)throw new Error('Unable to upload the service file.');
  }

  async function removeDraftFile(){
    await fetch('{{ route('service-details.upload.remove') }}',{
      method:'DELETE',headers:{'Accept':'application/json','X-CSRF-TOKEN':csrf},credentials:'same-origin'
    });
  }

  async function hydrateServiceDetail(){
    try{
      var response=await fetch('{{ route('service-details.state') }}',{headers:{'Accept':'application/json'},credentials:'same-origin'});
      var data=response.ok?await response.json():{};
      if(data.draft&&typeof window.pdvRestoreBackendDraft==='function')window.pdvRestoreBackendDraft(data.draft);
    }catch(error){}
    document.dispatchEvent(new CustomEvent('printify:service-detail-hydrated'));
  }

  document.addEventListener('change',function(event){
    if(!event.target.closest?.('#serviceDetail'))return;
    scheduleDraftSave();
    if(event.target.id==='pdvFileInput'&&event.target.files?.[0])uploadDraftFile(event.target.files[0]).catch(function(){});
  });
  document.addEventListener('input',function(event){if(event.target.id==='pdvQty')scheduleDraftSave()});
  document.addEventListener('click',function(event){
    if(event.target.closest?.('#serviceDetail .pdv-qty-box button,#serviceDetail .pdv-price-card,#serviceDetail .pdv-cart'))setTimeout(scheduleDraftSave,0);
    if(event.target.closest?.('#serviceDetail .pdv-file-result button'))removeDraftFile().catch(function(){});
  });

  function cartAnchor(){
    return document.querySelector('#navCart i.fa-cart-shopping,#navCart i.fa-shopping-cart,#cartIcon i.fa-cart-shopping,#cartBtn i.fa-cart-shopping,i.fa-cart-shopping,i.fa-shopping-cart');
  }
  function alignArrowOnce(){
    var panel=document.getElementById('pfyCartPanel'),anchor=cartAnchor();
    if(!panel||!anchor)return;
    panel.style.setProperty('top','72px','important');
    panel.style.setProperty('max-height','calc(100vh - 88px)','important');
    var ar=anchor.getBoundingClientRect(),pr=panel.getBoundingClientRect();
    var pointer=Math.max(12,Math.min(pr.width-24,pr.right-(ar.left+ar.width/2)-7.5));
    panel.style.setProperty('--pfy-pointer-right',pointer+'px');
  }

  window.alignPrintifyCartPointerExact=alignArrowOnce;
  window.openPrintifyCart=function(){
    if(typeof requireSignedInForOrder==='function'&&!requireSignedInForOrder())return false;
    if(typeof window.renderPrintifyCart==='function')window.renderPrintifyCart();
    var panel=document.getElementById('pfyCartPanel'),backdrop=document.getElementById('pfyCartBackdrop');
    alignArrowOnce();
    panel?.classList.add('show');backdrop?.classList.add('show');
    if(typeof updateBrowserUrl==='function')updateBrowserUrl('cart');
    return true;
  };
  window.toggleCart=function(){
    var panel=document.getElementById('pfyCartPanel');
    return panel?.classList.contains('show')?(window.closePrintifyCart(),false):window.openPrintifyCart();
  };

  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',hydrateServiceDetail,{once:true});
  else hydrateServiceDetail();
})();
</script>

<div class="pfy-checkout-confirm" id="pfyCheckoutConfirm" aria-hidden="true">
  <div class="pfy-checkout-confirm__dialog" role="dialog" aria-modal="true" aria-labelledby="pfyCheckoutConfirmTitle">
    <span class="pfy-checkout-confirm__icon"><i class="fa-solid fa-circle-question"></i></span>
    <h3 id="pfyCheckoutConfirmTitle">Confirm checkout</h3>
    <p id="pfyCheckoutConfirmMessage">Please confirm that your order details and uploaded file are correct before checkout.</p>
    <div class="pfy-checkout-confirm__actions">
      <button type="button" class="pfy-checkout-confirm__no" data-pfy-confirm="no">No</button>
      <button type="button" class="pfy-checkout-confirm__yes" data-pfy-confirm="yes">Yes</button>
    </div>
  </div>
</div>

<style id="service-detail-final-checkout-polish">
#serviceDetail{padding-top:50px!important;padding-bottom:50px!important}
#serviceDetail .pdv-shell{width:min(1270px,calc(100% - 160px))!important;max-width:1270px!important;margin:0 auto!important}
#serviceDetail .pdv-layout{column-gap:34px!important}
#serviceDetail #pdvThumbStack{gap:24px!important;justify-content:space-between!important}
#serviceDetail .pdv-thumb{margin:0!important}
#serviceDetail .pdv-checkout.is-disabled,#serviceDetail .pdv-checkout:disabled{background:#cfcfcf!important;color:#fff!important;box-shadow:none!important;cursor:not-allowed!important;opacity:1!important}
#serviceDetail .pdv-checkout:not(.is-disabled):not(:disabled){background:linear-gradient(135deg,#ff8a00,#ff5a14)!important;color:#111827!important}
#serviceDetail .pdv-checkout:not(.is-disabled):not(:disabled):hover{background:#111827!important;color:#fff!important}
#serviceDetail #pfyCartPanel .pfy-check:not(.is-disabled){background:linear-gradient(135deg,#ff8a00,#ff5a14)!important;color:#111827!important}
#serviceDetail #pfyCartPanel .pfy-check:not(.is-disabled):hover{background:#111827!important;color:#fff!important}
.pfy-checkout-confirm{position:fixed;inset:0;z-index:99999;display:grid;place-items:center;padding:24px;background:rgba(15,23,42,.45);backdrop-filter:blur(6px);opacity:0;pointer-events:none;transition:opacity .18s ease}
.pfy-checkout-confirm.is-open{opacity:1;pointer-events:auto}
.pfy-checkout-confirm__dialog{width:min(420px,calc(100vw - 40px));background:#fff;border:1px solid rgba(15,23,42,.12);border-radius:18px;box-shadow:0 24px 70px rgba(15,23,42,.22);padding:26px;text-align:center;transform:translateY(8px) scale(.98);transition:transform .18s ease}
.pfy-checkout-confirm.is-open .pfy-checkout-confirm__dialog{transform:translateY(0) scale(1)}
.pfy-checkout-confirm__icon{width:48px;height:48px;border-radius:999px;margin:0 auto 12px;display:grid;place-items:center;background:#fff3e8;color:#ff6b00;font-size:20px}
.pfy-checkout-confirm h3{margin:0 0 8px;color:#111827;font-size:22px;font-weight:800}
.pfy-checkout-confirm p{margin:0 auto 20px;max-width:320px;color:#4b5563;font-size:13px;line-height:1.45}
.pfy-checkout-confirm__actions{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.pfy-checkout-confirm__actions button{height:42px;border-radius:999px;font-weight:800;cursor:pointer}
.pfy-checkout-confirm__no{border:1px solid #d1d5db;background:#fff;color:#111827}
.pfy-checkout-confirm__yes{border:1px solid #ff6b00;background:linear-gradient(135deg,#ff8a00,#ff5a14);color:#111827}
.pfy-checkout-confirm__actions button:hover{background:#111827!important;border-color:#111827!important;color:#fff!important}
@media(max-width:1180px){#serviceDetail .pdv-shell{width:calc(100% - 44px)!important}}
@media(max-width:850px){#serviceDetail{padding-top:36px!important;padding-bottom:42px!important}#serviceDetail .pdv-shell{width:calc(100% - 28px)!important}#serviceDetail #pdvThumbStack{gap:14px!important}}
</style>

<script id="service-detail-final-checkout-polish-js">
(function(){
  if(window.__pfyServiceDetailFinalCheckoutPolish)return;
  window.__pfyServiceDetailFinalCheckoutPolish=true;
  function checkoutConfirm(message){
    var modal=document.getElementById("pfyCheckoutConfirm");
    if(!modal)return Promise.resolve(window.confirm(message||"Proceed to checkout?"));
    var msg=document.getElementById("pfyCheckoutConfirmMessage");
    if(msg&&message)msg.textContent=message;
    modal.classList.add("is-open");
    modal.setAttribute("aria-hidden","false");
    return new Promise(function(resolve){
      function done(value){
        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden","true");
        modal.removeEventListener("click",onClick);
        document.removeEventListener("keydown",onKey);
        resolve(value);
      }
      function onClick(e){
        if(e.target===modal||e.target.closest('[data-pfy-confirm="no"]'))done(false);
        if(e.target.closest('[data-pfy-confirm="yes"]'))done(true);
      }
      function onKey(e){if(e.key==="Escape")done(false);}
      modal.addEventListener("click",onClick);
      document.addEventListener("keydown",onKey);
    });
  }
  window.printifyConfirmCheckout=checkoutConfirm;
  function hasValue(id){var node=document.getElementById(id);return !!(node&&String(node.value||"").trim());}
  function detailReady(){
    var qty=document.getElementById("pdvQty");
    var fileResult=document.getElementById("pdvFileResult");
    var fileName=document.getElementById("pdvFileName");
    var nameText=String(fileName&&fileName.textContent||"").trim().toLowerCase();
    var fileReady=!!(fileResult&&fileResult.classList.contains("is-visible")&&nameText&&nameText!=="no file selected");
    var qtyReady=!!(qty&&Number(qty.value)>0);
    return qtyReady&&fileReady&&hasValue("pdvPrintingCategory")&&hasValue("pdvPaperSize")&&hasValue("pdvColorVariation")&&hasValue("pdvServiceOption")&&hasValue("pdvFileType");
  }
  function syncCheckout(){
    var btn=document.getElementById("pdvCheckoutBtn");
    if(!btn)return;
    var ready=detailReady();
    btn.disabled=!ready;
    btn.classList.toggle("is-disabled",!ready);
    btn.setAttribute("aria-disabled",String(!ready));
  }
  var oldUpdate=window.pdvUpdateOrder;
  if(typeof oldUpdate==="function"&&!oldUpdate.__pfyFinalCheckoutSync){
    window.pdvUpdateOrder=function(){var result=oldUpdate.apply(this,arguments);syncCheckout();return result;};
    window.pdvUpdateOrder.__pfyFinalCheckoutSync=true;
  }
  document.addEventListener("change",function(e){if(e.target&&e.target.closest&&e.target.closest("#serviceDetail"))setTimeout(syncCheckout,0);});
  document.addEventListener("input",function(e){if(e.target&&e.target.closest&&e.target.closest("#serviceDetail"))setTimeout(syncCheckout,0);});
  if(document.readyState==="loading")document.addEventListener("DOMContentLoaded",syncCheckout,{once:true});
  else syncCheckout();
  var oldPlace=window.placeOrderNow;
  if(typeof oldPlace==="function"&&!oldPlace.__pfyConfirmWrapped){
    window.placeOrderNow=async function(){
      syncCheckout();
      var btn=document.getElementById("pdvCheckoutBtn");
      if(btn&&(btn.disabled||btn.classList.contains("is-disabled"))){return oldPlace.apply(this,arguments);}
      var ok=await checkoutConfirm("Please confirm that your selected service, quantity, and uploaded file are correct before checkout.");
      if(!ok)return false;
      return oldPlace.apply(this,arguments);
    };
    window.placeOrderNow.__pfyConfirmWrapped=true;
  }
  var oldCart=window.checkoutPrintifyCart;
  if(typeof oldCart==="function"&&!oldCart.__pfyConfirmWrapped){
    window.checkoutPrintifyCart=async function(){
      var ok=await checkoutConfirm("Please confirm that your selected cart items are ready before proceeding to checkout.");
      if(!ok)return false;
      return oldCart.apply(this,arguments);
    };
    window.checkoutPrintifyCart.__pfyConfirmWrapped=true;
  }
})();
</script>


<script>
/* Final cart pointer alignment: arrow is placed under the actual cart icon/badge */
(function(){
  if(window.__PFY_DISABLE_LEGACY_CART_PATCHES)return;
  function visibleRect(node){
    if(!node) return null;
    var r=node.getBoundingClientRect();
    return (r.width && r.height && r.bottom>0 && r.right>0) ? r : null;
  }

  function findCartIcon(){
    var selectors=[
      '#cartBadge',
      '.cart-badge',
      '#navCart',
      '#cartIcon',
      '#cartBtn',
      '.nav-cart',
      '.cart-icon',
      '.cart-btn',
      '.cart-link',
      '[data-cart-toggle]',
      '[aria-label="Cart"]',
      '[aria-label*="cart" i]',
      'i.fa-cart-shopping',
      'i.fa-shopping-cart',
      'i.fa-bag-shopping'
    ];

    for(var i=0;i<selectors.length;i++){
      var nodes=[];
      try{ nodes=Array.prototype.slice.call(document.querySelectorAll(selectors[i])); }catch(e){}
      for(var j=0;j<nodes.length;j++){
        var n=nodes[j];
        if(n.closest && n.closest('#pfyCartPanel')) continue;
        var target=n.classList && n.classList.contains('cart-badge') ? n : (n.closest('a,button,[role="button"],li,div') || n);
        if(visibleRect(target)) return target;
      }
    }
    return null;
  }

  window.alignPrintifyCartPointerExact=function(){
    var panel=document.getElementById('pfyCartPanel');
    var anchor=findCartIcon();
    if(!panel || !anchor) return;

    var ar=visibleRect(anchor);
    var pr=visibleRect(panel);
    if(!ar || !pr) return;

    var cartCenter=ar.left+(ar.width/2);
    var pointerRight=pr.right-cartCenter-7.5;

    pointerRight=Math.max(12,Math.min(pr.width-24,pointerRight));
    if(!panel.classList.contains('show'))panel.style.setProperty('--pfy-pointer-right',pointerRight+'px');
  };

  var oldOpen=window.openPrintifyCart;
  if(typeof oldOpen==="function"){
    window.openPrintifyCart=function(){
      var result=oldOpen.apply(this,arguments);
      requestAnimationFrame(window.alignPrintifyCartPointerExact);
      setTimeout(window.alignPrintifyCartPointerExact,80);
      setTimeout(window.alignPrintifyCartPointerExact,180);
      return result;
    };
  }

  document.addEventListener('click',function(e){
    if(e.target.closest('.cart-badge,#cartBadge,#navCart,#cartIcon,#cartBtn,.nav-cart,.cart-icon,.cart-btn,.cart-link,[data-cart-toggle],[aria-label*="cart" i],i.fa-cart-shopping,i.fa-shopping-cart,i.fa-bag-shopping')){
      setTimeout(window.alignPrintifyCartPointerExact,40);
      setTimeout(window.alignPrintifyCartPointerExact,140);
    }
  });

  window.addEventListener('resize',function(){
    if(document.getElementById('pfyCartPanel')?.classList.contains('show')){
      window.alignPrintifyCartPointerExact();
    }
  });

  document.addEventListener('DOMContentLoaded',function(){
    setTimeout(window.alignPrintifyCartPointerExact,120);
  });
})();
</script>


<script>
/* Final cart arrow vertical + horizontal alignment to the real cart icon */
(function(){
  if(window.__PFY_DISABLE_LEGACY_CART_PATCHES)return;
  function rect(n){if(!n)return null;var r=n.getBoundingClientRect();return r.width&&r.height&&r.bottom>0&&r.right>0?r:null;}
  function cartAnchor(){
    var selectors=['i.fa-cart-shopping','i.fa-shopping-cart','i.fa-bag-shopping','#navCart','#cartIcon','#cartBtn','.nav-cart','.cart-icon','.cart-btn','.cart-link','[data-cart-toggle]','[aria-label="Cart"]','[aria-label*="cart" i]'];
    for(var i=0;i<selectors.length;i++){
      var nodes=[];try{nodes=[].slice.call(document.querySelectorAll(selectors[i]));}catch(e){}
      for(var j=0;j<nodes.length;j++){
        var n=nodes[j]; if(n.closest&&n.closest('#pfyCartPanel')) continue;
        var target=(n.closest&&n.closest('a,button,[role="button"],li,div'))||n;
        if(rect(target)) return target;
      }
    }
    return null;
  }
  window.alignPrintifyCartPointerExact=function(){
    var panel=document.getElementById('pfyCartPanel'), anchor=cartAnchor();
    if(!panel||!anchor) return;
    var ar=rect(anchor); if(!ar) return;
    var desiredTop=66;
    panel.style.setProperty('top','66px','important');
    panel.style.setProperty('max-height','calc(100vh - 82px)','important');
    var pr=rect(panel); if(!pr) return;
    var center=ar.left+(ar.width/2);
    var pointerRight=pr.right-center-7.5;
    pointerRight=Math.max(12,Math.min(pr.width-24,pointerRight));
    if(!panel.classList.contains('show'))panel.style.setProperty('--pfy-pointer-right',pointerRight+'px');
  };
  var oldOpen=window.openPrintifyCart;
  if(typeof oldOpen==='function'){
    window.openPrintifyCart=function(){
      var r=oldOpen.apply(this,arguments);
      requestAnimationFrame(window.alignPrintifyCartPointerExact);
      setTimeout(window.alignPrintifyCartPointerExact,60);
      setTimeout(window.alignPrintifyCartPointerExact,160);
      return r;
    };
  }
  document.addEventListener('click',function(e){
    if(e.target.closest('#navCart,#cartIcon,#cartBtn,.nav-cart,.cart-icon,.cart-btn,.cart-link,[data-cart-toggle],[aria-label*="cart" i],i.fa-cart-shopping,i.fa-shopping-cart,i.fa-bag-shopping')){
      setTimeout(window.alignPrintifyCartPointerExact,40);
      setTimeout(window.alignPrintifyCartPointerExact,130);
    }
  });
  window.addEventListener('resize',function(){
    if(document.getElementById('pfyCartPanel')?.classList.contains('show')) window.alignPrintifyCartPointerExact();
  });
})();
</script>


<script>
/* FINAL OVERRIDE: cart pointer follows exact cart icon/badge center */
(function(){
  if(window.__PFY_DISABLE_LEGACY_CART_PATCHES)return;
  function visibleRect(n){
    if(!n) return null;
    var r=n.getBoundingClientRect();
    return (r.width && r.height && r.bottom>0 && r.right>0) ? r : null;
  }

  function findExactCartAnchor(){
    var selectors=[
      '#cartBadge',
      '.cart-badge',
      'i.fa-cart-shopping',
      'i.fa-shopping-cart',
      'i.fa-bag-shopping',
      '#navCart',
      '#cartIcon',
      '#cartBtn',
      '.nav-cart',
      '.cart-icon',
      '.cart-btn',
      '.cart-link',
      '[data-cart-toggle]',
      '[aria-label="Cart"]',
      '[aria-label*="cart" i]'
    ];

    for(var i=0;i<selectors.length;i++){
      var nodes=[];
      try{ nodes=Array.prototype.slice.call(document.querySelectorAll(selectors[i])); }catch(e){}
      for(var j=0;j<nodes.length;j++){
        var n=nodes[j];
        if(n.closest && n.closest('#pfyCartPanel')) continue;

        var target=n;
        if(!(n.id==='cartBadge' || (n.classList && n.classList.contains('cart-badge')) || (n.tagName && n.tagName.toLowerCase()==='i'))){
          target=(n.closest && n.closest('a,button,[role="button"],li,div')) || n;
        }

        if(visibleRect(target)) return target;
      }
    }
    return null;
  }

  window.alignPrintifyCartPointerExact=function(){
    var panel=document.getElementById('pfyCartPanel');
    var anchor=findExactCartAnchor();
    if(!panel || !anchor) return;

    var ar=visibleRect(anchor);
    if(!ar) return;

    var desiredTop=66;
    panel.style.setProperty('top','66px','important');
    panel.style.setProperty('max-height','calc(100vh - 82px)','important');

    var pr=visibleRect(panel);
    if(!pr) return;

    var center=ar.left+(ar.width/2);
    var pointerRight=pr.right-center-7.5;
    pointerRight=Math.max(12,Math.min(pr.width-24,pointerRight));
    if(!panel.classList.contains('show'))panel.style.setProperty('--pfy-pointer-right',pointerRight+'px');
  };

  var oldOpen=window.openPrintifyCart;
  if(typeof oldOpen==='function' && !oldOpen.__finalPointerPatched){
    var patched=function(){
      var result=oldOpen.apply(this,arguments);
      requestAnimationFrame(window.alignPrintifyCartPointerExact);
      setTimeout(window.alignPrintifyCartPointerExact,50);
      setTimeout(window.alignPrintifyCartPointerExact,150);
      setTimeout(window.alignPrintifyCartPointerExact,300);
      return result;
    };
    patched.__finalPointerPatched=true;
    window.openPrintifyCart=patched;
  }

  document.addEventListener('click',function(e){
    if(e.target.closest('#cartBadge,.cart-badge,#navCart,#cartIcon,#cartBtn,.nav-cart,.cart-icon,.cart-btn,.cart-link,[data-cart-toggle],[aria-label*="cart" i],i.fa-cart-shopping,i.fa-shopping-cart,i.fa-bag-shopping')){
      setTimeout(window.alignPrintifyCartPointerExact,40);
      setTimeout(window.alignPrintifyCartPointerExact,140);
    }
  });

  window.addEventListener('resize',function(){
    if(document.getElementById('pfyCartPanel')?.classList.contains('show')){
      window.alignPrintifyCartPointerExact();
    }
  });
})();
</script>

<style>
/* =========================================================
   FINAL LOCK 06/09:
   - Cart arrow points to the actual cart icon, not the badge number
   - Cart checkboxes stay on the left side outside the image
   - Small orange custom checkbox style based on requested sample
   - Choose File button has a left icon inside the button
   No other UI sections changed.
========================================================= */
:root{
  --pfy-final-orange:#ff4f16!important;
  --pfy-final-orange-2:#ff7a00!important;
  --pfy-final-black:#111827!important;
}

/* Choose File: add icon inside the left side, keep current small button size */
#serviceDetail .pdv-upload-box .pdv-choose-file,
#serviceDetail .pdv-choose-file{
  position:relative!important;
  width:150px!important;
  min-width:150px!important;
  max-width:150px!important;
  height:34px!important;
  min-height:34px!important;
  padding:0 16px 0 38px!important;
  justify-content:flex-start!important;
  text-align:left!important;
  border:1px solid var(--pfy-final-black)!important;
  border-radius:999px!important;
  background:#fff!important;
  color:var(--pfy-final-black)!important;
  font-family:var(--pdv-body,Inter,Arial,sans-serif)!important;
  font-size:12px!important;
  font-weight:700!important;
  line-height:34px!important;
  box-shadow:none!important;
  white-space:nowrap!important;
  overflow:hidden!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:before,
#serviceDetail .pdv-choose-file:before{
  content:"\f093"!important;
  display:block!important;
  font-family:"Font Awesome 6 Free"!important;
  font-weight:900!important;
  position:absolute!important;
  left:16px!important;
  top:50%!important;
  transform:translateY(-50%)!important;
  color:currentColor!important;
  font-size:12px!important;
  line-height:1!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:hover,
#serviceDetail .pdv-choose-file:hover{
  background:var(--pfy-final-black)!important;
  border-color:var(--pfy-final-black)!important;
  color:#fff!important;
}
#serviceDetail .pdv-file-row{
  gap:10px!important;
}
#serviceDetail .pdv-no-file{
  max-width:calc(100% - 162px)!important;
}

/* Cart item layout: checkbox column is outside/left of image */
body #pfyCartPanel .pfy-item,
body #pfyCartPanel .pfy-item:hover{
  position:relative!important;
  display:grid!important;
  grid-template-columns:18px 58px minmax(0,1fr) 62px 18px!important;
  column-gap:9px!important;
  align-items:start!important;
  padding:14px 12px!important;
  margin:0 0 12px!important;
  background:#fff!important;
  border:0!important;
  border-radius:0!important;
  box-shadow:none!important;
  transform:none!important;
}
body #pfyCartPanel .pfy-check-wrap{
  position:static!important;
  grid-column:1!important;
  grid-row:1!important;
  align-self:start!important;
  justify-self:start!important;
  display:block!important;
  width:14px!important;
  min-width:14px!important;
  max-width:14px!important;
  height:14px!important;
  min-height:14px!important;
  max-height:14px!important;
  padding:0!important;
  margin:3px 0 0 0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
  cursor:pointer!important;
}
body #pfyCartPanel .pfy-img,
body #pfyCartPanel .pfy-noimg{
  grid-column:2!important;
  grid-row:1!important;
  width:58px!important;
  height:58px!important;
  margin-left:0!important;
  border-radius:9px!important;
}
body #pfyCartPanel .pfy-info{
  grid-column:3!important;
  grid-row:1!important;
  min-width:0!important;
}
body #pfyCartPanel .pfy-line{
  grid-column:4!important;
  grid-row:1!important;
  width:62px!important;
  min-width:62px!important;
  align-self:end!important;
  justify-self:end!important;
  margin:0 0 5px!important;
}
body #pfyCartPanel .pfy-remove{
  grid-column:5!important;
  grid-row:1!important;
  justify-self:end!important;
}

/* Requested custom checkbox look: small, orange, hover dark */
body #pfyCartPanel .pfy-check-wrap input,
body #pfyCartPanel .pfy-select-all input{
  appearance:none!important;
  -webkit-appearance:none!important;
  position:relative!important;
  display:block!important;
  width:14px!important;
  min-width:14px!important;
  max-width:14px!important;
  height:14px!important;
  min-height:14px!important;
  max-height:14px!important;
  margin:0!important;
  padding:0!important;
  border:1.4px solid var(--pfy-final-orange)!important;
  border-radius:4px!important;
  background:#fff!important;
  box-shadow:none!important;
  cursor:pointer!important;
  transition:background .16s ease,border-color .16s ease!important;
}
body #pfyCartPanel .pfy-check-wrap input:hover,
body #pfyCartPanel .pfy-select-all input:hover{
  border-color:var(--pfy-final-black)!important;
}
body #pfyCartPanel .pfy-check-wrap input:checked,
body #pfyCartPanel .pfy-select-all input:checked,
body #pfyCartPanel .pfy-select-all input:indeterminate{
  background:var(--pfy-final-orange)!important;
  border-color:var(--pfy-final-orange)!important;
}
body #pfyCartPanel .pfy-check-wrap input:checked:hover,
body #pfyCartPanel .pfy-select-all input:checked:hover,
body #pfyCartPanel .pfy-select-all input:indeterminate:hover{
  background:var(--pfy-final-black)!important;
  border-color:var(--pfy-final-black)!important;
}
body #pfyCartPanel .pfy-check-wrap input:checked:before,
body #pfyCartPanel .pfy-select-all input:checked:before{
  content:""!important;
  position:absolute!important;
  left:50%!important;
  top:45%!important;
  display:block!important;
  width:4px!important;
  height:8px!important;
  border-right:2px solid #fff!important;
  border-bottom:2px solid #fff!important;
  transform:translate(-50%,-55%) rotate(45deg)!important;
}
body #pfyCartPanel .pfy-select-all input:indeterminate:before{
  content:""!important;
  position:absolute!important;
  left:50%!important;
  top:50%!important;
  display:block!important;
  width:8px!important;
  height:2px!important;
  background:#fff!important;
  transform:translate(-50%,-50%)!important;
}

/* Keep select all checkbox aligned with label text */
body #pfyCartPanel .pfy-select-all{
  display:inline-flex!important;
  align-items:center!important;
  gap:7px!important;
}

/* Cart arrow visual: exact icon bottom, clean diamond */
body #pfyCartPanel:before{
  top:-8px!important;
  right:var(--pfy-pointer-right)!important;
  width:15px!important;
  height:15px!important;
  background:#fff!important;
  border-left:1px solid #e8e8e8!important;
  border-top:1px solid #e8e8e8!important;
  border-right:0!important;
  border-bottom:0!important;
  border-radius:3px 0 0 0!important;
  transform:rotate(45deg)!important;
  z-index:5!important;
}

@media(max-width:850px){
  #serviceDetail .pdv-upload-box .pdv-choose-file,
  #serviceDetail .pdv-choose-file{
    width:150px!important;
    min-width:150px!important;
    max-width:150px!important;
  }
  #serviceDetail .pdv-no-file{
    max-width:100%!important;
  }
}
</style>

<script>
/* FINAL LOCK 06/09: pointer follows the actual cart icon only, not the red badge/count */
(function(){
  if(window.__PFY_DISABLE_LEGACY_CART_PATCHES)return;
  function rect(node){
    if(!node) return null;
    var r=node.getBoundingClientRect();
    return (r.width && r.height && r.bottom>0 && r.right>0) ? r : null;
  }

  function exactCartIcon(){
    var iconSelectors=[
      'i.fa-cart-shopping',
      'i.fa-shopping-cart',
      'i.fa-bag-shopping',
      'svg[data-icon="cart-shopping"]',
      'svg[data-icon="shopping-cart"]',
      'svg[data-icon="bag-shopping"]',
      '.fa-cart-shopping',
      '.fa-shopping-cart',
      '.fa-bag-shopping'
    ];

    for(var i=0;i<iconSelectors.length;i++){
      var icons=[];
      try{ icons=Array.prototype.slice.call(document.querySelectorAll(iconSelectors[i])); }catch(e){}
      for(var j=0;j<icons.length;j++){
        var icon=icons[j];
        if(icon.closest && icon.closest('#pfyCartPanel')) continue;
        if(icon.classList && icon.classList.contains('cart-badge')) continue;
        if(icon.id==='cartBadge' || icon.id==='cartCount') continue;
        if(rect(icon)) return icon;
      }
    }

    var holderSelectors=[
      '#navCart',
      '#cartIcon',
      '#cartBtn',
      '.nav-cart',
      '.cart-icon',
      '.cart-btn',
      '.cart-link',
      '[data-cart-toggle]',
      '[aria-label="Cart"]',
      '[aria-label*="cart" i]'
    ];

    for(var h=0;h<holderSelectors.length;h++){
      var holders=[];
      try{ holders=Array.prototype.slice.call(document.querySelectorAll(holderSelectors[h])); }catch(e){}
      for(var k=0;k<holders.length;k++){
        var holder=holders[k];
        if(holder.closest && holder.closest('#pfyCartPanel')) continue;
        var insideIcon=null;
        try{ insideIcon=holder.querySelector('i.fa-cart-shopping,i.fa-shopping-cart,i.fa-bag-shopping,svg[data-icon="cart-shopping"],svg[data-icon="shopping-cart"],svg[data-icon="bag-shopping"]'); }catch(e){}
        if(insideIcon && rect(insideIcon)) return insideIcon;
        if(rect(holder)) return holder;
      }
    }
    return null;
  }

  function alignToIcon(){
    var panel=document.getElementById('pfyCartPanel');
    var icon=exactCartIcon();
    if(!panel || !icon) return;

    var ir=rect(icon);
    if(!ir) return;

    var desiredTop=66;
    panel.style.setProperty('top','66px','important');
    panel.style.setProperty('max-height','calc(100vh - 82px)','important');

    var pr=rect(panel);
    if(!pr) return;

    var iconCenter=ir.left+(ir.width/2);
    var pointerRight=pr.right-iconCenter-7.5;
    pointerRight=Math.max(12,Math.min(pr.width-24,pointerRight));
    if(!panel.classList.contains('show'))panel.style.setProperty('--pfy-pointer-right',pointerRight+'px');
  }

  window.alignPrintifyCartPointerExact=alignToIcon;

  var openFn=window.openPrintifyCart;
  if(typeof openFn==='function' && !openFn.__iconOnlyPointerPatch){
    var patched=function(){
      var result=openFn.apply(this,arguments);
      requestAnimationFrame(alignToIcon);
      setTimeout(alignToIcon,40);
      setTimeout(alignToIcon,120);
      setTimeout(alignToIcon,260);
      return result;
    };
    patched.__iconOnlyPointerPatch=true;
    window.openPrintifyCart=patched;
  }

  document.addEventListener('click',function(e){
    if(e.target.closest('#navCart,#cartIcon,#cartBtn,.nav-cart,.cart-icon,.cart-btn,.cart-link,[data-cart-toggle],[aria-label*="cart" i],i.fa-cart-shopping,i.fa-shopping-cart,i.fa-bag-shopping,svg[data-icon="cart-shopping"],svg[data-icon="shopping-cart"],svg[data-icon="bag-shopping"]')){
      setTimeout(alignToIcon,35);
      setTimeout(alignToIcon,120);
      setTimeout(alignToIcon,240);
    }
  });

  window.addEventListener('resize',function(){
    if(document.getElementById('pfyCartPanel') && document.getElementById('pfyCartPanel').classList.contains('show')){
      alignToIcon();
    }
  });

  document.addEventListener('DOMContentLoaded',function(){
    setTimeout(alignToIcon,120);
  });
})();
</script>


<style>
/* =========================================================
   FINAL LOCK 06/09 V3 - requested only:
   - Checkbox border black, orange checked, dark hover
   - Cart internal scrollbar changed to neutral/default gray
   - Checkbox + image moved closer to left side
   - Keep cart item checkbox/qty/remove/select functions working
   - No other UI design sections changed
========================================================= */
:root{
  --pfy-v3-orange:#ff4f16!important;
  --pfy-v3-orange-2:#ff7a00!important;
  --pfy-v3-black:#111827!important;
  --pfy-v3-scroll-thumb:#b8b8b8!important;
  --pfy-v3-scroll-track:#f3f3f3!important;
}

/* Neutral / typical scrollbar color for cart items */
body #pfyCartPanel .pfy-items{
  padding-left:12px!important;
  padding-right:14px!important;
  scrollbar-width:thin!important;
  scrollbar-color:var(--pfy-v3-scroll-thumb) var(--pfy-v3-scroll-track)!important;
}
body #pfyCartPanel .pfy-items::-webkit-scrollbar{
  width:6px!important;
}
body #pfyCartPanel .pfy-items::-webkit-scrollbar-track{
  background:var(--pfy-v3-scroll-track)!important;
  border-radius:999px!important;
}
body #pfyCartPanel .pfy-items::-webkit-scrollbar-thumb{
  background:var(--pfy-v3-scroll-thumb)!important;
  border-radius:999px!important;
}
body #pfyCartPanel .pfy-items::-webkit-scrollbar-thumb:hover{
  background:#8f8f8f!important;
}

/* Move checkbox + image closer to left side; keep checkbox outside image */
body #pfyCartPanel .pfy-item,
body #pfyCartPanel .pfy-item:hover{
  position:relative!important;
  display:grid!important;
  grid-template-columns:14px 54px minmax(0,1fr) 60px 16px!important;
  column-gap:6px!important;
  align-items:start!important;
  padding:13px 4px 13px 0!important;
  margin:0!important;
  background:transparent!important;
  border:0!important;
  border-bottom:1px solid #eeeeee!important;
  border-radius:0!important;
  box-shadow:none!important;
  transform:none!important;
}
body #pfyCartPanel .pfy-check-wrap{
  position:static!important;
  grid-column:1!important;
  grid-row:1!important;
  align-self:start!important;
  justify-self:start!important;
  display:block!important;
  width:13px!important;
  min-width:13px!important;
  max-width:13px!important;
  height:13px!important;
  min-height:13px!important;
  max-height:13px!important;
  padding:0!important;
  margin:3px 0 0 0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
  cursor:pointer!important;
  z-index:3!important;
}
body #pfyCartPanel .pfy-img,
body #pfyCartPanel .pfy-noimg{
  grid-column:2!important;
  grid-row:1!important;
  width:54px!important;
  height:54px!important;
  margin-left:0!important;
  border-radius:9px!important;
}
body #pfyCartPanel .pfy-info{
  grid-column:3!important;
  grid-row:1!important;
  min-width:0!important;
}
body #pfyCartPanel .pfy-line{
  grid-column:4!important;
  grid-row:1!important;
  width:60px!important;
  min-width:60px!important;
  align-self:end!important;
  justify-self:end!important;
  margin:0 0 5px!important;
}
body #pfyCartPanel .pfy-remove{
  grid-column:5!important;
  grid-row:1!important;
  justify-self:end!important;
  width:16px!important;
  height:16px!important;
}

/* Checkbox border must be black; checked remains orange; hover goes dark */
body #pfyCartPanel .pfy-check-wrap input,
body #pfyCartPanel .pfy-select-all input{
  appearance:none!important;
  -webkit-appearance:none!important;
  position:relative!important;
  display:block!important;
  width:13px!important;
  min-width:13px!important;
  max-width:13px!important;
  height:13px!important;
  min-height:13px!important;
  max-height:13px!important;
  margin:0!important;
  padding:0!important;
  border:1.4px solid var(--pfy-v3-black)!important;
  border-radius:3px!important;
  background:#fff!important;
  box-shadow:none!important;
  cursor:pointer!important;
  transition:background .16s ease,border-color .16s ease!important;
  pointer-events:auto!important;
}
body #pfyCartPanel .pfy-check-wrap input:hover,
body #pfyCartPanel .pfy-select-all input:hover{
  background:#fff!important;
  border-color:var(--pfy-v3-orange)!important;
}
body #pfyCartPanel .pfy-check-wrap input:checked,
body #pfyCartPanel .pfy-select-all input:checked,
body #pfyCartPanel .pfy-select-all input:indeterminate{
  background:var(--pfy-v3-orange)!important;
  border-color:var(--pfy-v3-orange)!important;
}
body #pfyCartPanel .pfy-check-wrap input:checked:hover,
body #pfyCartPanel .pfy-select-all input:checked:hover,
body #pfyCartPanel .pfy-select-all input:indeterminate:hover{
  background:var(--pfy-v3-black)!important;
  border-color:var(--pfy-v3-black)!important;
}
body #pfyCartPanel .pfy-check-wrap input:checked:before,
body #pfyCartPanel .pfy-select-all input:checked:before{
  content:""!important;
  position:absolute!important;
  left:50%!important;
  top:45%!important;
  display:block!important;
  width:3.5px!important;
  height:7px!important;
  border-right:2px solid #fff!important;
  border-bottom:2px solid #fff!important;
  transform:translate(-50%,-55%) rotate(45deg)!important;
}
body #pfyCartPanel .pfy-select-all input:indeterminate:before{
  content:""!important;
  position:absolute!important;
  left:50%!important;
  top:50%!important;
  display:block!important;
  width:7px!important;
  height:2px!important;
  background:#fff!important;
  transform:translate(-50%,-50%)!important;
}
body #pfyCartPanel .pfy-select-all{
  display:inline-flex!important;
  align-items:center!important;
  gap:7px!important;
}

/* Make sure Choose File icon remains inside the button */
#serviceDetail .pdv-upload-box .pdv-choose-file,
#serviceDetail .pdv-choose-file{
  position:relative!important;
  width:150px!important;
  min-width:150px!important;
  max-width:150px!important;
  padding-left:38px!important;
  justify-content:flex-start!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:before,
#serviceDetail .pdv-choose-file:before{
  content:"\f093"!important;
  display:block!important;
  font-family:"Font Awesome 6 Free"!important;
  font-weight:900!important;
  position:absolute!important;
  left:16px!important;
  top:50%!important;
  transform:translateY(-50%)!important;
  color:currentColor!important;
  font-size:12px!important;
  line-height:1!important;
}

/* Keep Proceed button same width as Add to Cart */
body #pfyCartPanel .pfy-check{
  width:190px!important;
  min-width:190px!important;
  max-width:190px!important;
}
</style>

<script>
/* FINAL LOCK 06/09 V3 - function safety patch for cart controls */
(function(){
  if(window.__PFY_DISABLE_LEGACY_CART_PATCHES)return;
  function readCart(){
    if(typeof window.getCartItems==='function') return window.getCartItems();
    try{return JSON.parse(localStorage.getItem('printifyCartItems')||'[]');}catch(e){return [];}
  }
  function saveCart(items){
    if(typeof window.saveCartItems==='function') return window.saveCartItems(items);
    localStorage.setItem('printifyCartItems',JSON.stringify(items||[]));
    if(typeof window.renderPrintifyCart==='function') window.renderPrintifyCart(items||[]);
  }
  function qty(v){return Math.max(1,Math.min(9999,parseInt(v,10)||1));}

  document.addEventListener('click',function(e){
    var label=e.target.closest && e.target.closest('#pfyCartPanel .pfy-check-wrap');
    if(label && e.target.tagName && e.target.tagName.toLowerCase()!=='input'){
      var input=label.querySelector('input[data-act="select"]');
      if(input){
        input.checked=!input.checked;
        input.dispatchEvent(new Event('change',{bubbles:true}));
        e.preventDefault();
      }
    }
  },true);

  /* Quantity/remove actions are handled once by the canonical cart controller. */

  document.addEventListener('change',function(e){
    var input=e.target.closest && e.target.closest('#pfyCartItems input[data-act="select"]');
    if(!input) return;
    var row=input.closest('.pfy-item');
    if(!row || !row.dataset.id) return;
    var cart=readCart();
    var item=cart.find(function(x){return String(x.id)===String(row.dataset.id);});
    if(!item) return;
    item.selected=!!input.checked;
    saveCart(cart);
  },true);

  /* Pointer stays aligned to icon only, never to badge/count */
  function rect(n){if(!n)return null;var r=n.getBoundingClientRect();return r.width&&r.height&&r.bottom>0&&r.right>0?r:null;}
  function iconOnly(){
    var icons=[];
    try{icons=[].slice.call(document.querySelectorAll('i.fa-cart-shopping,i.fa-shopping-cart,i.fa-bag-shopping,svg[data-icon="cart-shopping"],svg[data-icon="shopping-cart"],svg[data-icon="bag-shopping"]'));}catch(e){}
    for(var i=0;i<icons.length;i++){
      var x=icons[i];
      if(x.closest&&x.closest('#pfyCartPanel')) continue;
      if(x.id==='cartBadge'||x.id==='cartCount'||(x.classList&&x.classList.contains('cart-badge'))) continue;
      if(rect(x)) return x;
    }
    var holders=[];
    try{holders=[].slice.call(document.querySelectorAll('#navCart,#cartIcon,#cartBtn,.nav-cart,.cart-icon,.cart-btn,.cart-link,[data-cart-toggle],[aria-label="Cart"],[aria-label*="cart" i]'));}catch(e){}
    for(var h=0;h<holders.length;h++){
      var holder=holders[h];
      if(holder.closest&&holder.closest('#pfyCartPanel')) continue;
      var inner=null;
      try{inner=holder.querySelector('i.fa-cart-shopping,i.fa-shopping-cart,i.fa-bag-shopping,svg[data-icon="cart-shopping"],svg[data-icon="shopping-cart"],svg[data-icon="bag-shopping"]');}catch(e){}
      if(inner&&rect(inner)) return inner;
      if(rect(holder)) return holder;
    }
    return null;
  }
  window.alignPrintifyCartPointerExact=function(){
    var panel=document.getElementById('pfyCartPanel'), icon=iconOnly();
    if(!panel||!icon) return;
    var ir=rect(icon); if(!ir) return;
    var top=66;
    panel.style.setProperty('top','66px','important');
    panel.style.setProperty('max-height','calc(100vh - 82px)','important');
    var pr=rect(panel); if(!pr) return;
    var center=ir.left+(ir.width/2);
    var pointerRight=pr.right-center-7.5;
    pointerRight=Math.max(12,Math.min(pr.width-24,pointerRight));
    if(!panel.classList.contains('show'))panel.style.setProperty('--pfy-pointer-right',pointerRight+'px');
  };
  var oldOpen=window.openPrintifyCart;
  if(typeof oldOpen==='function' && !oldOpen.__v3IconPointer){
    var patched=function(){
      var result=oldOpen.apply(this,arguments);
      requestAnimationFrame(window.alignPrintifyCartPointerExact);
      setTimeout(window.alignPrintifyCartPointerExact,50);
      setTimeout(window.alignPrintifyCartPointerExact,140);
      setTimeout(window.alignPrintifyCartPointerExact,300);
      return result;
    };
    patched.__v3IconPointer=true;
    window.openPrintifyCart=patched;
  }
})();
</script>


<style>
/* =========================================================
   FINAL LOCK 06/09 V4 - requested only:
   - Empty cart still shows promo, subtotal, shipping, total, and checkout button
   - Removed empty cart icon/black box visual
   - Cleaned Order Summary price note / total amount / reminder blocks
   - Existing functions remain connected
========================================================= */
body #pfyCartPanel .pfy-items.is-empty{
  min-height:0!important;
  max-height:none!important;
  height:0!important;
  padding-top:0!important;
  padding-bottom:0!important;
  overflow:hidden!important;
  display:block!important;
}
body #pfyCartPanel .pfy-empty,
body #pfyCartPanel .pfy-empty *{
  display:none!important;
  border:0!important;
  background:transparent!important;
  box-shadow:none!important;
}
body #pfyCartPanel .pfy-summary{
  display:block!important;
}
body #pfyCartPanel .pfy-promo{
  margin-top:4px!important;
}
body #pfyCartPanel .pfy-check.is-disabled,
body #pfyCartPanel .pfy-check.is-disabled:hover{
  background:#cfcfcf!important;
  color:#fff!important;
  cursor:not-allowed!important;
}

/* Order Summary clean section: remove background/shape from these parts only */
#serviceDetail .pdv-price-note{
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  padding:0!important;
  margin:12px 0 16px!important;
  color:#555!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-estimated-total{
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  padding:0 0 12px!important;
  margin:0 0 12px!important;
  color:#111827!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-estimated-total span{
  color:#111827!important;
  font-weight:700!important;
}
#serviceDetail .pdv-estimated-total strong{
  color:#ff4f16!important;
  font-size:18px!important;
  font-weight:800!important;
}
#serviceDetail .pdv-checkout-note{
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  padding:0 0 0 28px!important;
  margin:0 0 14px!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-checkout-note:before{
  left:0!important;
  top:2px!important;
  color:#ff4f16!important;
}
#serviceDetail .pdv-checkout-note strong{
  color:#111827!important;
  font-weight:700!important;
}
#serviceDetail .pdv-checkout-note small{
  color:#666!important;
}
</style>

<script>
/* FINAL LOCK 06/09 V4 - empty cart summary stays visible with real controls */
(function(){
  if(window.__PFY_DISABLE_LEGACY_CART_PATCHES)return;
  function peso(v){
    v=Number(v)||0;
    return '₱'+v.toLocaleString('en-PH',{minimumFractionDigits:2,maximumFractionDigits:2});
  }
  function readCart(){
    if(typeof window.getCartItems==='function') return window.getCartItems()||[];
    try{return JSON.parse(localStorage.getItem('printifyCartItems')||'[]')||[];}catch(e){return [];}
  }
  function isSelected(item){return item && item.selected!==false;}
  function emptyCartSummaryFix(){
    var panel=document.getElementById('pfyCartPanel');
    if(!panel) return;
    var cart=readCart();
    if(cart.length) return;

    var list=document.getElementById('pfyCartItems');
    var summary=document.getElementById('pfyCartSummary');
    if(list){
      list.classList.add('is-empty');
      list.innerHTML='';
    }
    if(summary) summary.style.display='block';

    var count=document.getElementById('pfyCartCount');
    if(count) count.textContent='(0)';

    var selectedLabel=document.getElementById('pfyCartSelectedLabel');
    if(selectedLabel) selectedLabel.textContent='Select All';

    var selectAll=document.getElementById('pfyCartSelectAll');
    if(selectAll){
      selectAll.checked=false;
      selectAll.indeterminate=false;
      selectAll.disabled=true;
    }

    var removeAll=document.getElementById('pfyRemoveAllBtn');
    if(removeAll) removeAll.disabled=true;

    var subtotalLabel=document.getElementById('pfySubtotalLabel');
    if(subtotalLabel) subtotalLabel.textContent='Subtotal (0 items)';

    var subtotal=document.getElementById('pfySubtotal');
    if(subtotal) subtotal.textContent=peso(0);

    var shipping=document.getElementById('pfyShippingLabel');
    if(shipping){
      shipping.textContent='Calculated at checkout';
      shipping.classList.remove('is-free');
    }

    var discountRow=document.getElementById('pfyDiscountRow');
    if(discountRow) discountRow.style.display='none';

    var total=document.getElementById('pfyTotal');
    if(total) total.textContent=peso(0);

    var checkout=document.getElementById('pfyCartCheckoutBtn');
    if(checkout){
      checkout.classList.add('is-disabled');
      checkout.setAttribute('aria-disabled','true');
    }
  }

  var oldRender=window.renderPrintifyCart;
  if(typeof oldRender==='function' && !oldRender.__v4EmptySummary){
    var patchedRender=function(){
      var result=oldRender.apply(this,arguments);
      emptyCartSummaryFix();
      return result;
    };
    patchedRender.__v4EmptySummary=true;
    window.renderPrintifyCart=patchedRender;
  }

  var oldSave=window.saveCartItems;
  if(typeof oldSave==='function' && !oldSave.__v4EmptySummary){
    var patchedSave=function(){
      var result=oldSave.apply(this,arguments);
      setTimeout(emptyCartSummaryFix,0);
      return result;
    };
    patchedSave.__v4EmptySummary=true;
    window.saveCartItems=patchedSave;
  }

  var oldOpen=window.openPrintifyCart;
  if(typeof oldOpen==='function' && !oldOpen.__v4EmptySummary){
    var patchedOpen=function(){
      var result=oldOpen.apply(this,arguments);
      requestAnimationFrame(emptyCartSummaryFix);
      setTimeout(emptyCartSummaryFix,80);
      return result;
    };
    patchedOpen.__v4EmptySummary=true;
    window.openPrintifyCart=patchedOpen;
  }

  var oldCheckout=window.checkoutPrintifyCart;
  if(typeof oldCheckout==='function' && !oldCheckout.__v4EmptySummary){
    window.checkoutPrintifyCart=function(){
      if(!readCart().filter(isSelected).length){
        emptyCartSummaryFix();
        alert('Your cart is empty. Please add a printing service before checkout.');
        return false;
      }
      return oldCheckout.apply(this,arguments);
    };
    window.checkoutPrintifyCart.__v4EmptySummary=true;
  }

  document.addEventListener('DOMContentLoaded',function(){setTimeout(emptyCartSummaryFix,120);});
  document.addEventListener('click',function(e){
    if(e.target.closest && e.target.closest('#pfyCartPanel,[data-cart-toggle],#navCart,#cartIcon,#cartBtn,.nav-cart,.cart-icon,.cart-btn,.cart-link,[aria-label*="cart" i],i.fa-cart-shopping,i.fa-shopping-cart,i.fa-bag-shopping')){
      setTimeout(emptyCartSummaryFix,120);
    }
  });
})();
</script>


<style>
/* =========================================================
   FINAL SERVICE DETAILS UI REQUEST
   Scope only: Service ID, Upload File, Retail/Bulk, sidebar thumbs.
   Positions/layout of other sections are intentionally untouched.
========================================================= */
:root{
  --pfy-final-orange:#ff4f16!important;
  --pfy-final-orange-2:#ff7a00!important;
  --pfy-final-black:#111827!important;
  --pfy-final-muted:#666!important;
  --pfy-final-line:#e6e6e6!important;
}

/* Sidebar: image only, no title text, no gray/white background card */
#serviceDetail .pdv-thumb{
  min-height:96px!important;
  height:auto!important;
  padding:0!important;
  border:0!important;
  background:transparent!important;
  box-shadow:none!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  overflow:visible!important;
}
#serviceDetail .pdv-thumb:hover,
#serviceDetail .pdv-thumb.is-active,
#serviceDetail .pdv-thumb.is-active:hover{
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
  transform:none!important;
}
#serviceDetail .pdv-thumb strong{display:none!important;}
#serviceDetail .pdv-thumb-paper,
#serviceDetail .pdv-thumb-paper.is-real-thumb{
  width:86px!important;
  max-width:86px!important;
  height:96px!important;
  max-height:96px!important;
  padding:0!important;
  border:0!important;
  background:transparent!important;
  box-shadow:none!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
}
#serviceDetail .pdv-thumb-real-img{
  width:78px!important;
  height:92px!important;
  max-height:92px!important;
  object-fit:contain!important;
  display:block!important;
  filter:drop-shadow(0 8px 14px rgba(17,24,39,.14));
}
#serviceDetail .pdv-thumb.is-active .pdv-thumb-real-img{
  outline:2px solid var(--pfy-final-orange)!important;
  outline-offset:6px!important;
  border-radius:4px!important;
}
#serviceDetail .pdv-thumb:not(.has-real-thumb) .pdv-thumb-paper{
  border:0!important;
  background:transparent!important;
  box-shadow:0 8px 14px rgba(17,24,39,.10)!important;
}

/* Upload File: no surrounding upload box, compact only */
#serviceDetail .pdv-upload-box,
#serviceDetail .pdv-upload-box:hover,
#serviceDetail .pdv-upload-box.is-dragging{
  width:100%!important;
  max-width:none!important;
  min-height:0!important;
  height:auto!important;
  padding:0!important;
  margin:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  box-shadow:none!important;
  outline:0!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:flex-start!important;
  justify-content:flex-start!important;
  gap:6px!important;
}
#serviceDetail .pdv-file-row{
  display:flex!important;
  align-items:center!important;
  gap:10px!important;
  width:100%!important;
  min-width:0!important;
}
#serviceDetail .pdv-upload-icon,
#serviceDetail .pdv-upload-copy{display:none!important;}
#serviceDetail .pdv-upload-box .pdv-choose-file,
#serviceDetail .pdv-choose-file{
  position:relative!important;
  width:150px!important;
  min-width:150px!important;
  max-width:150px!important;
  height:34px!important;
  min-height:34px!important;
  padding:0 16px 0 38px!important;
  border:1px solid var(--pfy-final-black)!important;
  border-radius:999px!important;
  background:#fff!important;
  color:var(--pfy-final-black)!important;
  font-family:var(--pdv-body,Inter,Arial,sans-serif)!important;
  font-size:12px!important;
  font-weight:700!important;
  line-height:34px!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:flex-start!important;
  text-align:left!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  box-shadow:none!important;
  cursor:pointer!important;
  transition:background .18s ease,color .18s ease,border-color .18s ease!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:before,
#serviceDetail .pdv-choose-file:before{
  content:"093"!important;
  display:block!important;
  font-family:"Font Awesome 6 Free"!important;
  font-weight:900!important;
  position:absolute!important;
  left:16px!important;
  top:50%!important;
  transform:translateY(-50%)!important;
  color:currentColor!important;
  font-size:12px!important;
  line-height:1!important;
}
#serviceDetail .pdv-upload-box .pdv-choose-file:hover,
#serviceDetail .pdv-choose-file:hover{
  background:var(--pfy-final-black)!important;
  border-color:var(--pfy-final-black)!important;
  color:#fff!important;
}
#serviceDetail .pdv-no-file{
  display:inline-block!important;
  min-width:0!important;
  max-width:calc(100% - 162px)!important;
  color:#555!important;
  font-family:var(--pdv-body,Inter,Arial,sans-serif)!important;
  font-size:13px!important;
  font-weight:500!important;
  line-height:1.35!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}
#serviceDetail .pdv-upload-box small{
  display:block!important;
  grid-column:auto!important;
  margin:0 0 0 2px!important;
  color:#777!important;
  font-family:var(--pdv-body,Inter,Arial,sans-serif)!important;
  font-size:13px!important;
  font-weight:500!important;
  line-height:1.35!important;
}

/* Service ID: below Upload File, colored, visible, but no box */
#serviceDetail .pdv-service-id-inline{
  width:100%!important;
  display:flex!important;
  align-items:center!important;
  gap:10px!important;
  margin:12px 0 0!important;
  padding:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  box-shadow:none!important;
  color:#111827!important;
  font-family:var(--pdv-body,Inter,Arial,sans-serif)!important;
  line-height:1.2!important;
}
#serviceDetail .pdv-service-id-inline i{
  color:var(--pfy-final-orange)!important;
  font-size:18px!important;
  width:20px!important;
  text-align:center!important;
}
#serviceDetail .pdv-service-id-inline span{
  color:var(--pfy-final-orange)!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:12px!important;
  font-weight:800!important;
  letter-spacing:.035em!important;
  text-transform:uppercase!important;
}
#serviceDetail .pdv-service-id-inline span:after{
  content:"";
  display:inline-block;
  width:1px;
  height:24px;
  margin-left:10px;
  vertical-align:middle;
  background:#cfcfcf;
}
#serviceDetail .pdv-service-id-inline strong{
  color:#111827!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:15px!important;
  font-weight:800!important;
  letter-spacing:.01em!important;
}

/* Retail/Bulk: same position, cleaner no big card box */
#serviceDetail .pdv-price-grid{
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:0!important;
  margin:0 0 16px!important;
  padding:16px 0!important;
  border-top:1px solid var(--pfy-final-line)!important;
  border-bottom:0!important;
}
#serviceDetail .pdv-price-card,
#serviceDetail .pdv-price-card:hover,
#serviceDetail .pdv-price-card.is-active,
#serviceDetail .pdv-price-card.is-active:hover{
  min-height:0!important;
  height:auto!important;
  padding:0 14px!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  box-shadow:none!important;
  text-align:left!important;
  transform:none!important;
  cursor:pointer!important;
}
#serviceDetail .pdv-price-card:first-child{
  padding-left:0!important;
  border-right:1px solid var(--pfy-final-line)!important;
}
#serviceDetail .pdv-price-card:last-child{
  padding-right:0!important;
  padding-left:22px!important;
}
#serviceDetail .pdv-price-label{
  display:block!important;
  color:#111827!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:12px!important;
  font-weight:700!important;
  margin:0 0 7px!important;
}
#serviceDetail .pdv-price-medallion{
  display:block!important;
  color:#111827!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:19px!important;
  font-weight:800!important;
  line-height:1!important;
  margin:0 0 9px!important;
}
#serviceDetail .pdv-price-medallion b{font-size:19px!important;}
#serviceDetail .pdv-price-card small{
  display:block!important;
  color:#666!important;
  font-family:var(--pdv-body,Inter,Arial,sans-serif)!important;
  font-size:12px!important;
  font-weight:500!important;
  line-height:1.3!important;
}
#serviceDetail .pdv-price-card.is-active .pdv-price-label,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion b{
  color:var(--pfy-final-orange)!important;
}
#serviceDetail .pdv-price-card.is-active small{color:#d65122!important;}
#serviceDetail #pdvBulkPriceCard small:after{
  content:"Save 25%";
  display:inline-block;
  margin-left:14px;
  color:#16a34a;
  font-weight:800;
  white-space:nowrap;
}
#serviceDetail .pdv-price-note{
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  padding:0!important;
  margin:8px 0 16px!important;
  color:#555!important;
  font-size:13px!important;
  line-height:1.45!important;
  box-shadow:none!important;
}

/* Keep existing position; only clean the total/reminder shapes */
#serviceDetail .pdv-estimated-total{
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  background:transparent!important;
  border:0!important;
  border-top:1px solid var(--pfy-final-line)!important;
  border-radius:0!important;
  padding:18px 0 0!important;
  margin:0 0 14px!important;
  color:#111827!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-estimated-total span{
  color:#111827!important;
  font-weight:800!important;
}
#serviceDetail .pdv-estimated-total strong{
  color:var(--pfy-final-orange)!important;
  font-size:18px!important;
  font-weight:900!important;
}
#serviceDetail .pdv-checkout-note{
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  padding:0 0 0 28px!important;
  margin:0 0 14px!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-checkout-note:before{
  left:0!important;
  top:2px!important;
  color:var(--pfy-final-orange)!important;
}
#serviceDetail .pdv-checkout-note strong{
  color:#111827!important;
  font-weight:800!important;
}
#serviceDetail .pdv-checkout-note small{
  color:#666!important;
  font-size:13px!important;
  line-height:1.35!important;
}

@media(max-width:850px){
  #serviceDetail .pdv-no-file{max-width:100%!important;}
  #serviceDetail .pdv-file-row{flex-wrap:wrap!important;}
  #serviceDetail .pdv-price-grid{grid-template-columns:1fr!important;gap:14px!important;}
  #serviceDetail .pdv-price-card:first-child{border-right:0!important;border-bottom:1px solid var(--pfy-final-line)!important;padding-bottom:14px!important;}
  #serviceDetail .pdv-price-card:last-child{padding-left:0!important;}
}
</style>

<script>
/* FINAL SERVICE ID SYNC: use the current CSV variation only, never stale checkout storage */
(function(){
  function syncServiceId(){
    var target=document.getElementById('pdvServiceIdText');
    if(!target) return;
    try{
      if(typeof window.pdvGetCurrentServiceId==='function'){
        target.textContent=window.pdvGetCurrentServiceId();
      }
    }catch(e){}
  }
  var oldUpdate=window.pdvUpdateOrder;
  if(typeof oldUpdate==='function' && !oldUpdate.__serviceIdCsvPatch){
    var patchedUpdate=function(){
      var result=oldUpdate.apply(this,arguments);
      syncServiceId();
      return result;
    };
    patchedUpdate.__serviceIdCsvPatch=true;
    window.pdvUpdateOrder=patchedUpdate;
  }
  ['change','input'].forEach(function(evt){
    document.addEventListener(evt,function(e){
      if(e.target&&e.target.closest&&e.target.closest('#pdvPrintingCategory,#pdvColorVariation,#pdvPaperSize,#pdvServiceOption,#pdvQty')){
        setTimeout(syncServiceId,0);
      }
    });
  });
  document.addEventListener('DOMContentLoaded',syncServiceId);
  setTimeout(syncServiceId,100);
})();
</script>

<style>
/* =========================================================
   FINAL FIX: Retail / Bulk section only
   - smaller / compact
   - no movement on hover/click
   - no card jumping from border/background changes
========================================================= */
#serviceDetail .pdv-price-grid{
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:0!important;
  align-items:stretch!important;
  margin:8px 0 12px!important;
  padding:0!important;
  width:100%!important;
}

#serviceDetail .pdv-price-card,
#serviceDetail .pdv-price-card:hover,
#serviceDetail .pdv-price-card:focus,
#serviceDetail .pdv-price-card:active,
#serviceDetail .pdv-price-card.is-active,
#serviceDetail .pdv-price-card.is-active:hover{
  min-height:54px!important;
  height:54px!important;
  padding:0 14px!important;
  margin:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  box-shadow:none!important;
  outline:0!important;
  transform:none!important;
  transition:none!important;
  display:flex!important;
  flex-direction:column!important;
  justify-content:center!important;
  cursor:pointer!important;
}

#serviceDetail .pdv-price-card:first-child{
  padding-left:0!important;
  border-right:1px solid #dfe3e8!important;
}

#serviceDetail .pdv-price-card:last-child{
  padding-left:18px!important;
  padding-right:0!important;
}

#serviceDetail .pdv-price-label{
  display:block!important;
  margin:0 0 4px!important;
  color:#111827!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:11px!important;
  font-weight:700!important;
  line-height:1.15!important;
}

#serviceDetail .pdv-price-medallion{
  display:block!important;
  margin:0 0 4px!important;
  color:#111827!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:16px!important;
  font-weight:800!important;
  line-height:1!important;
}

#serviceDetail .pdv-price-medallion b{
  font-size:16px!important;
  line-height:1!important;
}

#serviceDetail .pdv-price-card small{
  display:block!important;
  margin:0!important;
  color:#666!important;
  font-family:var(--pdv-body,Inter,Arial,sans-serif)!important;
  font-size:10.5px!important;
  font-weight:500!important;
  line-height:1.2!important;
  white-space:nowrap!important;
}

#serviceDetail .pdv-price-card.is-active .pdv-price-label,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion b{
  color:#ff4f16!important;
}

#serviceDetail #pdvBulkPriceCard small:after{
  content:"Save 25%"!important;
  display:inline-block!important;
  margin-left:10px!important;
  color:#16a34a!important;
  font-size:10px!important;
  font-weight:800!important;
  white-space:nowrap!important;
}

@media(max-width:850px){
  #serviceDetail .pdv-price-grid{
    grid-template-columns:1fr 1fr!important;
    gap:0!important;
  }
  #serviceDetail .pdv-price-card:first-child{
    border-right:1px solid #dfe3e8!important;
    border-bottom:0!important;
    padding-bottom:0!important;
  }
  #serviceDetail .pdv-price-card:last-child{
    padding-left:14px!important;
  }
}
</style>

<style>
/* =========================================================
   FINAL USER REQUEST: Restore original boxed Retail / Bulk design
   Scope only: Retail Price and Bulk Price cards.
   Keeps current positions/layout and prevents hover/click movement.
========================================================= */
#serviceDetail .pdv-price-grid{
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:12px!important;
  align-items:stretch!important;
  width:100%!important;
  margin:10px 0 18px!important;
  padding:0!important;
  border:0!important;
}

#serviceDetail .pdv-price-card,
#serviceDetail .pdv-price-card:hover,
#serviceDetail .pdv-price-card:focus,
#serviceDetail .pdv-price-card:active{
  min-height:78px!important;
  height:78px!important;
  padding:12px 14px!important;
  margin:0!important;
  border:1px solid #dfe3e8!important;
  border-radius:8px!important;
  background:#fff!important;
  box-shadow:none!important;
  outline:0!important;
  transform:none!important;
  transition:background .16s ease,border-color .16s ease,color .16s ease!important;
  display:flex!important;
  flex-direction:column!important;
  justify-content:center!important;
  text-align:left!important;
  cursor:pointer!important;
}

/* Active Retail/Bulk style: orange outline + light orange fill */
#serviceDetail .pdv-price-card.is-active,
#serviceDetail .pdv-price-card.is-active:hover,
#serviceDetail .pdv-price-card.is-active:focus,
#serviceDetail .pdv-price-card.is-active:active{
  border:1px solid #ff4f16!important;
  background:#fff3ed!important;
  box-shadow:none!important;
  transform:none!important;
}

/* Non-active Bulk/other box style like the first design */
#serviceDetail .pdv-price-card:not(.is-active),
#serviceDetail .pdv-price-card:not(.is-active):hover{
  border:1px solid #111827!important;
  background:#f2f3f5!important;
  transform:none!important;
  box-shadow:none!important;
}

#serviceDetail .pdv-price-card:first-child,
#serviceDetail .pdv-price-card:last-child{
  padding:12px 14px!important;
  border-right-width:1px!important;
  border-bottom-width:1px!important;
}

#serviceDetail .pdv-price-label{
  display:block!important;
  margin:0 0 5px!important;
  color:#111827!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:10px!important;
  font-weight:700!important;
  line-height:1.15!important;
}

#serviceDetail .pdv-price-medallion{
  display:block!important;
  margin:0 0 5px!important;
  color:#111827!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:18px!important;
  font-weight:800!important;
  line-height:1!important;
}

#serviceDetail .pdv-price-medallion b{
  font-size:18px!important;
  line-height:1!important;
}

#serviceDetail .pdv-price-card small{
  display:block!important;
  margin:0!important;
  color:#555!important;
  font-family:var(--pdv-body,Inter,Arial,sans-serif)!important;
  font-size:9px!important;
  font-weight:500!important;
  line-height:1.2!important;
  white-space:nowrap!important;
}

#serviceDetail .pdv-price-card.is-active .pdv-price-label,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion b,
#serviceDetail .pdv-price-card.is-active small{
  color:#ff4f16!important;
}

#serviceDetail #pdvBulkPriceCard small:after{
  content:"Save 25%"!important;
  display:inline-block!important;
  margin-left:10px!important;
  color:#16a34a!important;
  font-size:9px!important;
  font-weight:800!important;
  white-space:nowrap!important;
}

@media(max-width:850px){
  #serviceDetail .pdv-price-grid{
    grid-template-columns:1fr 1fr!important;
    gap:10px!important;
  }
  #serviceDetail .pdv-price-card,
  #serviceDetail .pdv-price-card:hover,
  #serviceDetail .pdv-price-card:focus,
  #serviceDetail .pdv-price-card:active{
    min-height:74px!important;
    height:74px!important;
    padding:10px 12px!important;
  }
}
</style>


<style>
/* =========================================================
   FINAL APPLY UI FROM SCREENSHOT - 06/09
   Scope:
   - Move Service Add-ons above Order Summary
   - Keep position/layout of left/preview/details/summary clean
   - Put Service ID below Reminder/Note and make it immediately visible
   - Make right side fit without needing scroll
========================================================= */
#serviceDetail{
  background:#fff!important;
  overflow-x:hidden!important;
}

@media(min-width:1251px){
  #serviceDetail .pdv-shell{
    width:min(1500px,calc(100% - 90px))!important;
    max-width:1500px!important;
    margin:0 auto!important;
  }

  #serviceDetail .pdv-hero-row{
    display:grid!important;
    grid-template-columns:minmax(430px,1fr) minmax(690px,760px)!important;
    gap:24px!important;
    align-items:end!important;
    margin:8px 0 22px!important;
  }

  #serviceDetail .pdv-stepper{
    width:100%!important;
    max-width:760px!important;
    justify-self:end!important;
    transform:none!important;
    margin:0!important;
  }

  #serviceDetail .pdv-layout{
    --pdv-panel-h:520px!important;
    display:grid!important;
    grid-template-columns:150px minmax(420px,460px) minmax(350px,380px) minmax(350px,380px)!important;
    column-gap:70px!important;
    row-gap:18px!important;
    align-items:start!important;
  }
}

/* left service choices like screenshot */
#serviceDetail .pdv-left-card{
  margin:0!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-thumb-stack{
  gap:18px!important;
}
#serviceDetail .pdv-thumb{
  min-height:146px!important;
  border-radius:8px!important;
  background:#fff!important;
  border:1px solid #dfe4ea!important;
  box-shadow:none!important;
  padding:12px 10px!important;
  transform:none!important;
}
#serviceDetail .pdv-thumb.is-active{
  border:1.6px solid #ff4f16!important;
  background:#fff7f2!important;
}
#serviceDetail .pdv-thumb strong{
  font-size:12px!important;
  font-weight:800!important;
}

/* Preview card frame only */
#serviceDetail .pdv-preview-card{
  min-height:520px!important;
  border:1px solid #111827!important;
  border-radius:8px!important;
  background:#fff!important;
  box-shadow:none!important;
  padding:18px 20px 22px!important;
}
#serviceDetail .pdv-preview-card:hover{
  background:#fff!important;
  border-color:#111827!important;
}
#serviceDetail .pdv-preview-window{
  min-height:360px!important;
}
#serviceDetail .pdv-document-preview{
  width:min(360px,92%)!important;
}
#serviceDetail .pdv-real-preview-img{
  max-height:390px!important;
}
#serviceDetail .pdv-product-review-block{
  margin-top:14px!important;
  border:1px solid #ffe1d3!important;
  background:#fffaf7!important;
  border-radius:8px!important;
}

/* Middle printing details: no outer box, compact fields */
#serviceDetail .pdv-options-card{
  min-height:0!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-options-card:hover{
  background:transparent!important;
}
#serviceDetail .pdv-card-section h2{
  margin:0 0 14px!important;
  color:#111827!important;
  font-size:16px!important;
  font-weight:700!important;
}
#serviceDetail .pdv-field-grid{
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:14px 18px!important;
}
#serviceDetail .pdv-field label{
  margin-bottom:7px!important;
  color:#111827!important;
  font-size:12px!important;
  font-weight:700!important;
}
#serviceDetail .pdv-field select,
#serviceDetail .pdv-qty-box{
  height:38px!important;
  border:1px solid #dfe4ea!important;
  border-radius:7px!important;
  background:#fff!important;
  font-size:13px!important;
}
#serviceDetail .pdv-divider{
  margin:22px 0!important;
  background:transparent!important;
  height:0!important;
}

/* Upload section like screenshot */
#serviceDetail .pdv-upload-box,
#serviceDetail .pdv-upload-box:hover,
#serviceDetail .pdv-upload-box.is-dragging{
  display:flex!important;
  flex-direction:column!important;
  gap:8px!important;
  padding:0!important;
  margin:0!important;
  border:0!important;
  background:transparent!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-file-row{
  display:flex!important;
  align-items:center!important;
  gap:12px!important;
}
#serviceDetail .pdv-choose-file{
  width:130px!important;
  min-width:130px!important;
  max-width:130px!important;
  height:34px!important;
  padding:0 15px 0 36px!important;
  border:1px solid #111827!important;
  border-radius:999px!important;
  background:#fff!important;
  color:#111827!important;
  font-size:13px!important;
  font-weight:700!important;
  justify-content:flex-start!important;
}
#serviceDetail .pdv-choose-file:before{
  content:"\f093"!important;
  display:block!important;
  font-family:"Font Awesome 6 Free"!important;
  font-weight:900!important;
  position:absolute!important;
  left:15px!important;
  top:50%!important;
  transform:translateY(-50%)!important;
  font-size:12px!important;
}
#serviceDetail .pdv-choose-file:hover{
  background:#111827!important;
  color:#fff!important;
}
#serviceDetail .pdv-no-file{
  max-width:calc(100% - 142px)!important;
  font-size:13px!important;
  color:#444!important;
}
#serviceDetail .pdv-upload-box small{
  margin:0!important;
  color:#666!important;
  font-size:12px!important;
}
#serviceDetail .pdv-warning{
  margin-top:16px!important;
  padding:14px 16px!important;
  border-radius:8px!important;
  background:#fff1ed!important;
  display:flex!important;
  align-items:flex-start!important;
  gap:12px!important;
}
#serviceDetail .pdv-warning strong{
  font-size:13px!important;
  font-weight:800!important;
}
#serviceDetail .pdv-warning small{
  font-size:13px!important;
  color:#444!important;
  line-height:1.4!important;
}

/* Service ID should be visible below reminder, colored, no box */
#serviceDetail .pdv-service-id-inline{
  display:flex!important;
  align-items:center!important;
  gap:12px!important;
  width:100%!important;
  margin:22px 0 0!important;
  padding:0!important;
  border:0!important;
  background:transparent!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-service-id-inline i{
  color:#ff4f16!important;
  font-size:20px!important;
  width:22px!important;
  text-align:center!important;
}
#serviceDetail .pdv-service-id-inline span{
  color:#ff4f16!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:13px!important;
  font-weight:800!important;
  letter-spacing:.03em!important;
}
#serviceDetail .pdv-service-id-inline span:after{
  content:""!important;
  display:inline-block!important;
  width:1px!important;
  height:24px!important;
  margin-left:12px!important;
  vertical-align:middle!important;
  background:#d7d7d7!important;
}
#serviceDetail .pdv-service-id-inline strong{
  color:#111827!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:15px!important;
  font-weight:800!important;
}

/* Right column: Add-ons on top, Order Summary under it */
#serviceDetail .pdv-summary-card{
  min-height:0!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-summary-card:hover{
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-summary-card .pdv-card-section.pdv-addons-moved{
  margin:0 0 24px!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  box-shadow:none!important;
}
#serviceDetail .pdv-summary-card .pdv-card-section.pdv-addons-moved h2{
  margin:0 0 13px!important;
}
#serviceDetail .pdv-addon{
  display:grid!important;
  grid-template-columns:16px 1fr auto 16px!important;
  align-items:center!important;
  gap:10px!important;
  margin-top:12px!important;
  color:#333!important;
  font-size:13px!important;
}
#serviceDetail .pdv-addon input{
  width:14px!important;
  height:14px!important;
  accent-color:#ff4f16!important;
}
#serviceDetail .pdv-addon span{
  font-size:13px!important;
  font-weight:500!important;
}
#serviceDetail .pdv-addon strong{
  color:#111827!important;
  font-size:12px!important;
  font-weight:800!important;
  white-space:nowrap!important;
}
#serviceDetail .pdv-addon i{
  color:#111827!important;
  font-size:12px!important;
}

/* Order Summary clean sizing */
#serviceDetail .pdv-summary-head{
  margin:0 0 14px!important;
}
#serviceDetail .pdv-summary-head h2{
  font-size:18px!important;
  font-weight:800!important;
}
#serviceDetail .pdv-summary-head button{
  width:48px!important;
  min-width:48px!important;
  max-width:48px!important;
  height:28px!important;
  border-radius:999px!important;
  background:linear-gradient(135deg,#ff7a00,#ff4f16)!important;
  color:#111827!important;
  font-size:12px!important;
  font-weight:800!important;
}
#serviceDetail .pdv-summary-product{
  display:grid!important;
  grid-template-columns:66px minmax(0,1fr)!important;
  gap:14px!important;
  align-items:start!important;
}
#serviceDetail .pdv-summary-thumb{
  width:66px!important;
  height:86px!important;
  border-radius:3px!important;
}
#serviceDetail .pdv-summary-real-img{
  max-height:86px!important;
}
#serviceDetail .pdv-summary-product h3{
  font-size:15px!important;
  font-weight:800!important;
  margin:0 0 6px!important;
}
#serviceDetail .pdv-summary-product p,
#serviceDetail .pdv-summary-product small{
  font-size:13px!important;
  color:#444!important;
  line-height:1.45!important;
}
#serviceDetail .pdv-summary-line{
  height:0!important;
  margin:14px 0!important;
  background:transparent!important;
}

/* Retail/Bulk boxed like screenshot */
#serviceDetail .pdv-price-grid{
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:12px!important;
  margin:8px 0 14px!important;
}
#serviceDetail .pdv-price-card,
#serviceDetail .pdv-price-card:hover,
#serviceDetail .pdv-price-card:focus,
#serviceDetail .pdv-price-card:active{
  height:78px!important;
  min-height:78px!important;
  padding:12px 14px!important;
  border:1px solid #111827!important;
  border-radius:8px!important;
  background:#f2f3f5!important;
  box-shadow:none!important;
  transform:none!important;
}
#serviceDetail .pdv-price-card.is-active,
#serviceDetail .pdv-price-card.is-active:hover{
  border-color:#ff4f16!important;
  background:#fff3ed!important;
}
#serviceDetail .pdv-price-label{
  font-size:10px!important;
  font-weight:800!important;
  margin-bottom:5px!important;
}
#serviceDetail .pdv-price-medallion,
#serviceDetail .pdv-price-medallion b{
  font-size:18px!important;
  font-weight:900!important;
}
#serviceDetail .pdv-price-card small{
  font-size:9.5px!important;
  line-height:1.2!important;
  white-space:nowrap!important;
}
#serviceDetail #pdvBulkPriceCard small:after{
  content:"Save 25%"!important;
  display:inline-block!important;
  margin-left:10px!important;
  color:#16a34a!important;
  font-weight:900!important;
}

#serviceDetail .pdv-price-note{
  margin:8px 0 14px!important;
  padding:0!important;
  background:transparent!important;
  color:#555!important;
  font-size:13px!important;
  line-height:1.35!important;
}
#serviceDetail .pdv-estimated-total{
  margin:0 0 12px!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  display:flex!important;
  justify-content:space-between!important;
  align-items:center!important;
}
#serviceDetail .pdv-estimated-total span{
  font-size:13px!important;
  font-weight:800!important;
}
#serviceDetail .pdv-estimated-total strong{
  color:#ff4f16!important;
  font-size:20px!important;
  font-weight:900!important;
}
#serviceDetail .pdv-action-row{
  display:flex!important;
  flex-direction:column!important;
  align-items:stretch!important;
  gap:8px!important;
  margin:8px 0 16px!important;
}
#serviceDetail .pdv-action-row .pdv-cart,
#serviceDetail .pdv-action-row .pdv-checkout{
  width:100%!important;
  min-width:0!important;
  max-width:none!important;
  height:34px!important;
  border-radius:999px!important;
  font-size:12px!important;
  font-weight:800!important;
}
#serviceDetail .pdv-checkout-note{
  margin:0!important;
  padding:0 0 0 28px!important;
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
}
#serviceDetail .pdv-checkout-note:before{
  left:0!important;
  top:1px!important;
  color:#ff4f16!important;
}
#serviceDetail .pdv-checkout-note strong{
  font-size:12px!important;
  font-weight:800!important;
}
#serviceDetail .pdv-checkout-note small{
  font-size:12px!important;
  color:#444!important;
}

@media(max-width:1250px){
  #serviceDetail .pdv-summary-card .pdv-card-section.pdv-addons-moved{
    margin-bottom:18px!important;
  }
}
@media(max-width:850px){
  #serviceDetail .pdv-field-grid{
    grid-template-columns:1fr!important;
  }
  #serviceDetail .pdv-price-grid{
    grid-template-columns:1fr 1fr!important;
  }
  #serviceDetail .pdv-file-row{
    flex-wrap:wrap!important;
  }
  #serviceDetail .pdv-no-file{
    max-width:100%!important;
  }
}
</style>

<script>
/* Move sections to match the provided screenshot without changing existing functions. */
(function(){
  function applyScreenshotLayout(){
    var root=document.getElementById('serviceDetail');
    if(!root) return;

    var summary=root.querySelector('.pdv-summary-card');
    var options=root.querySelector('.pdv-options-card');
    if(summary && options){
      var addonSection=Array.prototype.slice.call(options.querySelectorAll('.pdv-card-section')).find(function(sec){
        return /Service\s+Add-ons/i.test(sec.textContent||'');
      });
      var summaryHead=summary.querySelector('.pdv-summary-head');
      if(addonSection && summaryHead && addonSection.parentNode!==summary){
        addonSection.classList.add('pdv-addons-moved');
        summary.insertBefore(addonSection,summaryHead);
      }
    }

    var uploadSec=root.querySelector('[data-pdv-section="upload"]');
    if(uploadSec){
      var warning=uploadSec.querySelector('.pdv-warning');
      var serviceId=uploadSec.querySelector('.pdv-service-id-inline');
      if(warning && serviceId && warning.nextElementSibling!==serviceId){
        warning.insertAdjacentElement('afterend',serviceId);
      }
    }
  }

  if(document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded',applyScreenshotLayout);
  }else{
    applyScreenshotLayout();
  }

  window.addEventListener('printifyServiceSelected',function(){
    setTimeout(applyScreenshotLayout,30);
  });
  var oldOpen=window.openPrintifyServiceDetail;
  if(typeof oldOpen==='function' && !oldOpen.__screenshotLayoutPatch){
    var patched=function(){
      var result=oldOpen.apply(this,arguments);
      setTimeout(applyScreenshotLayout,30);
      return result;
    };
    patched.__screenshotLayoutPatch=true;
    window.openPrintifyServiceDetail=patched;
  }
})();
</script>

<style>
/* =========================================================
   FINAL RETAIL/BULK BOX LOCK
   Requested fix:
   - Retail Price and Bulk Price cards should stay steady.
   - No movement / no lifting / no resizing on hover or active.
   - Hover changes color only.
   - Both boxes keep equal width, height, padding, border radius.
========================================================= */
#serviceDetail .pdv-price-grid{
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:12px!important;
  align-items:stretch!important;
  width:100%!important;
  margin:0 0 14px!important;
}

#serviceDetail .pdv-price-card,
#serviceDetail .pdv-price-card:hover,
#serviceDetail .pdv-price-card:focus,
#serviceDetail .pdv-price-card:active,
#serviceDetail .pdv-price-card.is-active,
#serviceDetail .pdv-price-card.is-active:hover,
#serviceDetail .pdv-price-card.is-active:focus,
#serviceDetail .pdv-price-card.is-active:active{
  position:relative!important;
  width:100%!important;
  min-width:0!important;
  max-width:none!important;
  min-height:78px!important;
  height:78px!important;
  max-height:78px!important;
  padding:11px 12px!important;
  border-radius:9px!important;
  box-sizing:border-box!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:flex-start!important;
  justify-content:center!important;
  gap:3px!important;
  text-align:left!important;
  font-family:var(--pdv-body,Inter,Arial,sans-serif)!important;
  overflow:hidden!important;
  cursor:pointer!important;
  transform:none!important;
  translate:none!important;
  scale:1!important;
  margin:0!important;
  inset:auto!important;
  box-shadow:none!important;
  outline:0!important;
  transition:background-color .16s ease,border-color .16s ease,color .16s ease!important;
}

/* Default inactive look */
#serviceDetail .pdv-price-card{
  background:#fff!important;
  border:1px solid #111827!important;
  color:#111827!important;
}

/* Active selected look */
#serviceDetail .pdv-price-card.is-active{
  background:rgba(255,79,22,.08)!important;
  border:1px solid #ff4f16!important;
  color:#ff4f16!important;
}

/* Hover color only, no movement */
#serviceDetail .pdv-price-card:hover{
  background:rgba(255,79,22,.08)!important;
  border-color:#ff4f16!important;
  color:#ff4f16!important;
}

#serviceDetail .pdv-price-card.is-active:hover{
  background:rgba(255,79,22,.12)!important;
  border-color:#ff4f16!important;
  color:#ff4f16!important;
}

/* Text inside cards also stays steady */
#serviceDetail .pdv-price-card .pdv-price-label,
#serviceDetail .pdv-price-card .pdv-price-medallion,
#serviceDetail .pdv-price-card .pdv-price-medallion b,
#serviceDetail .pdv-price-card small,
#serviceDetail .pdv-price-card:hover .pdv-price-label,
#serviceDetail .pdv-price-card:hover .pdv-price-medallion,
#serviceDetail .pdv-price-card:hover .pdv-price-medallion b,
#serviceDetail .pdv-price-card:hover small,
#serviceDetail .pdv-price-card.is-active .pdv-price-label,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion b,
#serviceDetail .pdv-price-card.is-active small{
  transform:none!important;
  translate:none!important;
  scale:1!important;
  margin-left:0!important;
  margin-right:0!important;
  position:static!important;
  line-height:1.2!important;
  transition:color .16s ease!important;
}

#serviceDetail .pdv-price-card .pdv-price-label{
  display:block!important;
  font-size:11px!important;
  font-weight:700!important;
  color:#111827!important;
}

#serviceDetail .pdv-price-card .pdv-price-medallion{
  display:block!important;
  margin:3px 0 2px!important;
  font-size:14px!important;
  font-weight:800!important;
  color:#111827!important;
}

#serviceDetail .pdv-price-card .pdv-price-medallion b{
  font-size:18px!important;
  font-weight:900!important;
  color:inherit!important;
}

#serviceDetail .pdv-price-card small{
  display:block!important;
  font-size:10px!important;
  font-weight:600!important;
  line-height:1.25!important;
  color:#555!important;
}

#serviceDetail .pdv-price-card:hover .pdv-price-label,
#serviceDetail .pdv-price-card:hover .pdv-price-medallion,
#serviceDetail .pdv-price-card:hover .pdv-price-medallion b,
#serviceDetail .pdv-price-card:hover small,
#serviceDetail .pdv-price-card.is-active .pdv-price-label,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion b,
#serviceDetail .pdv-price-card.is-active small{
  color:#ff4f16!important;
}

/* Prevent old global hover rules from making the cards move */
#serviceDetail .pdv-price-card:hover,
#serviceDetail .pdv-price-card.is-active:hover{
  box-shadow:none!important;
  transform:none!important;
}

@media(max-width:850px){
  #serviceDetail .pdv-price-grid{
    grid-template-columns:1fr 1fr!important;
    gap:10px!important;
  }
  #serviceDetail .pdv-price-card,
  #serviceDetail .pdv-price-card:hover,
  #serviceDetail .pdv-price-card.is-active,
  #serviceDetail .pdv-price-card.is-active:hover{
    height:76px!important;
    min-height:76px!important;
    max-height:76px!important;
    padding:10px!important;
  }
}
</style>

<style>
/* =========================================================
   FINAL LOCK 06/09 V5 - requested fixes:
   1) ADD TO CART and CHECK OUT NOW same compact size as Proceed to Checkout button.
   2) Current breadcrumb inline/underline stays visible and also hovers.
   3) Retail/Bulk boxes stay steady; hover color only.
========================================================= */
:root{
  --pfy-v5-orange:#ff4f16!important;
  --pfy-v5-orange-2:#ff7a00!important;
  --pfy-v5-black:#111827!important;
}

/* Compact order buttons: same visual size as Proceed to Checkout */
#serviceDetail .pdv-action-row{
  display:flex!important;
  flex-direction:column!important;
  align-items:center!important;
  justify-content:center!important;
  gap:9px!important;
  width:100%!important;
  margin-top:12px!important;
}
#serviceDetail .pdv-action-row .pdv-cart,
#serviceDetail .pdv-action-row .pdv-checkout,
#serviceDetail .pdv-cart,
#serviceDetail .pdv-checkout{
  width:190px!important;
  min-width:190px!important;
  max-width:190px!important;
  height:38px!important;
  min-height:38px!important;
  max-height:38px!important;
  padding:0 16px!important;
  border:0!important;
  border-radius:999px!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  align-self:center!important;
  justify-self:center!important;
  font-family:var(--pdv-title,Poppins,sans-serif)!important;
  font-size:11px!important;
  font-weight:700!important;
  line-height:38px!important;
  letter-spacing:.01em!important;
  text-align:center!important;
  white-space:nowrap!important;
  box-sizing:border-box!important;
  box-shadow:none!important;
  transform:none!important;
}
#serviceDetail .pdv-cart{
  background:linear-gradient(135deg,var(--pfy-v5-orange-2),var(--pfy-v5-orange))!important;
  color:#111827!important;
}
#serviceDetail .pdv-cart:hover{
  background:var(--pfy-v5-black)!important;
  color:#fff!important;
  transform:none!important;
}
#serviceDetail .pdv-checkout,
#serviceDetail .pdv-checkout.is-disabled,
#serviceDetail .pdv-checkout:disabled{
  background:#cfcfcf!important;
  color:#fff!important;
  cursor:not-allowed!important;
}
#serviceDetail .pdv-checkout:not(.is-disabled):not(:disabled):hover{
  background:var(--pfy-v5-black)!important;
  color:#fff!important;
  transform:none!important;
}

/* Keep breadcrumb inline underline visible. Hover keeps/changes underline cleanly. */
#serviceDetail .pdv-breadcrumb a,
#serviceDetail .pdv-breadcrumb strong,
#serviceDetail .pdv-breadcrumb a#pdvCrumbCategory,
#serviceDetail .pdv-breadcrumb a.pdv-current-service,
#serviceDetail .pdv-breadcrumb #pdvCrumbService{
  display:inline-flex!important;
  align-items:center!important;
  padding-bottom:4px!important;
  border-bottom:3px solid transparent!important;
  text-decoration:none!important;
  line-height:1.2!important;
  transition:color .16s ease,border-color .16s ease!important;
}
#serviceDetail .pdv-breadcrumb a.pdv-current-service,
#serviceDetail .pdv-breadcrumb #pdvCrumbService,
#serviceDetail .pdv-breadcrumb strong{
  color:var(--pfy-v5-orange)!important;
  border-bottom-color:var(--pfy-v5-orange)!important;
  font-weight:700!important;
}
#serviceDetail .pdv-breadcrumb a:hover,
#serviceDetail .pdv-breadcrumb strong:hover,
#serviceDetail .pdv-breadcrumb a#pdvCrumbCategory:hover,
#serviceDetail .pdv-breadcrumb a.pdv-current-service:hover,
#serviceDetail .pdv-breadcrumb #pdvCrumbService:hover{
  color:var(--pfy-v5-orange)!important;
  border-bottom-color:var(--pfy-v5-orange)!important;
  text-decoration:none!important;
}

/* Retail/Bulk final steady lock: color-only hover, no movement. */
#serviceDetail .pdv-price-grid{
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:12px!important;
  align-items:stretch!important;
}
#serviceDetail .pdv-price-card,
#serviceDetail .pdv-price-card:hover,
#serviceDetail .pdv-price-card:focus,
#serviceDetail .pdv-price-card:active,
#serviceDetail .pdv-price-card.is-active,
#serviceDetail .pdv-price-card.is-active:hover,
#serviceDetail .pdv-price-card.is-active:focus,
#serviceDetail .pdv-price-card.is-active:active{
  width:100%!important;
  min-width:0!important;
  max-width:none!important;
  height:78px!important;
  min-height:78px!important;
  max-height:78px!important;
  padding:11px 12px!important;
  margin:0!important;
  border-radius:9px!important;
  box-sizing:border-box!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:flex-start!important;
  justify-content:center!important;
  gap:3px!important;
  overflow:hidden!important;
  transform:none!important;
  translate:none!important;
  scale:1!important;
  box-shadow:none!important;
  outline:0!important;
  transition:background-color .16s ease,border-color .16s ease,color .16s ease!important;
}
#serviceDetail .pdv-price-card{
  background:#fff!important;
  border:1px solid var(--pfy-v5-black)!important;
  color:var(--pfy-v5-black)!important;
}
#serviceDetail .pdv-price-card.is-active{
  background:rgba(255,79,22,.08)!important;
  border-color:var(--pfy-v5-orange)!important;
  color:var(--pfy-v5-orange)!important;
}
#serviceDetail .pdv-price-card:hover,
#serviceDetail .pdv-price-card.is-active:hover{
  background:rgba(255,79,22,.11)!important;
  border-color:var(--pfy-v5-orange)!important;
  color:var(--pfy-v5-orange)!important;
}
#serviceDetail .pdv-price-card .pdv-price-label,
#serviceDetail .pdv-price-card .pdv-price-medallion,
#serviceDetail .pdv-price-card .pdv-price-medallion b,
#serviceDetail .pdv-price-card small,
#serviceDetail .pdv-price-card:hover .pdv-price-label,
#serviceDetail .pdv-price-card:hover .pdv-price-medallion,
#serviceDetail .pdv-price-card:hover .pdv-price-medallion b,
#serviceDetail .pdv-price-card:hover small,
#serviceDetail .pdv-price-card.is-active .pdv-price-label,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion b,
#serviceDetail .pdv-price-card.is-active small{
  position:static!important;
  transform:none!important;
  translate:none!important;
  scale:1!important;
  margin-left:0!important;
  margin-right:0!important;
  transition:color .16s ease!important;
}
#serviceDetail .pdv-price-card:hover .pdv-price-label,
#serviceDetail .pdv-price-card:hover .pdv-price-medallion,
#serviceDetail .pdv-price-card:hover .pdv-price-medallion b,
#serviceDetail .pdv-price-card:hover small,
#serviceDetail .pdv-price-card.is-active .pdv-price-label,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion b,
#serviceDetail .pdv-price-card.is-active small{
  color:var(--pfy-v5-orange)!important;
}

@media(max-width:850px){
  #serviceDetail .pdv-action-row .pdv-cart,
  #serviceDetail .pdv-action-row .pdv-checkout,
  #serviceDetail .pdv-cart,
  #serviceDetail .pdv-checkout{
    width:190px!important;
    min-width:190px!important;
    max-width:190px!important;
  }
}
</style>

<style>
/* =========================================================
   FINAL LOCK 06/09 V6 - requested fixes only:
   1) Retail/Bulk state no longer changes page height or creates scroll.
   2) Order Summary section stays steady in both Retail and Bulk.
   3) Sidebar thumbnails show the actual image directly; no inner paper/frame.
   Everything else remains unchanged.
========================================================= */
:root{
  --pfy-v6-orange:#ff4f16!important;
  --pfy-v6-black:#111827!important;
}

/* -------- ORDER SUMMARY: lock same height for retail and bulk states -------- */
#serviceDetail .pdv-summary-card{
  overflow:visible!important;
}

#serviceDetail .pdv-price-grid{
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:12px!important;
  align-items:stretch!important;
  margin:0 0 12px!important;
}

#serviceDetail .pdv-price-card,
#serviceDetail .pdv-price-card:hover,
#serviceDetail .pdv-price-card.is-active,
#serviceDetail .pdv-price-card.is-active:hover{
  width:100%!important;
  min-width:0!important;
  max-width:none!important;
  height:78px!important;
  min-height:78px!important;
  max-height:78px!important;
  padding:11px 12px!important;
  margin:0!important;
  box-sizing:border-box!important;
  display:flex!important;
  flex-direction:column!important;
  justify-content:center!important;
  align-items:flex-start!important;
  gap:3px!important;
  transform:none!important;
  translate:none!important;
  scale:1!important;
  box-shadow:none!important;
  overflow:hidden!important;
  transition:background-color .16s ease,border-color .16s ease,color .16s ease!important;
}

#serviceDetail .pdv-price-card{
  background:#fff!important;
  border:1px solid var(--pfy-v6-black)!important;
  color:var(--pfy-v6-black)!important;
}

#serviceDetail .pdv-price-card.is-active{
  background:rgba(255,79,22,.08)!important;
  border-color:var(--pfy-v6-orange)!important;
  color:var(--pfy-v6-orange)!important;
}

#serviceDetail .pdv-price-card:hover,
#serviceDetail .pdv-price-card.is-active:hover{
  background:rgba(255,79,22,.12)!important;
  border-color:var(--pfy-v6-orange)!important;
  color:var(--pfy-v6-orange)!important;
}

#serviceDetail .pdv-price-card *,
#serviceDetail .pdv-price-card:hover *,
#serviceDetail .pdv-price-card.is-active *,
#serviceDetail .pdv-price-card.is-active:hover *{
  transform:none!important;
  translate:none!important;
  scale:1!important;
}

#serviceDetail .pdv-price-card:hover .pdv-price-label,
#serviceDetail .pdv-price-card:hover .pdv-price-medallion,
#serviceDetail .pdv-price-card:hover .pdv-price-medallion b,
#serviceDetail .pdv-price-card:hover small,
#serviceDetail .pdv-price-card.is-active .pdv-price-label,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion,
#serviceDetail .pdv-price-card.is-active .pdv-price-medallion b,
#serviceDetail .pdv-price-card.is-active small{
  color:var(--pfy-v6-orange)!important;
}

/* This was the part causing Retail to become taller than Bulk. Keep it fixed. */
#serviceDetail .pdv-price-note{
  height:38px!important;
  min-height:38px!important;
  max-height:38px!important;
  padding:0!important;
  margin:12px 0 12px!important;
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  box-shadow:none!important;
  color:#555!important;
  font-size:12px!important;
  line-height:1.35!important;
  overflow:hidden!important;
}

#serviceDetail .pdv-estimated-total{
  height:28px!important;
  min-height:28px!important;
  max-height:28px!important;
  padding:0!important;
  margin:0 0 10px!important;
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  box-shadow:none!important;
}

#serviceDetail .pdv-checkout-note{
  height:42px!important;
  min-height:42px!important;
  max-height:42px!important;
  padding:0 0 0 28px!important;
  margin:0 0 12px!important;
  background:transparent!important;
  border:0!important;
  border-radius:0!important;
  box-shadow:none!important;
  overflow:hidden!important;
}

#serviceDetail .pdv-checkout-note:before{
  left:0!important;
  top:2px!important;
}

#serviceDetail .pdv-action-row{
  margin-top:0!important;
  height:86px!important;
  min-height:86px!important;
  max-height:86px!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:center!important;
  justify-content:flex-start!important;
  gap:9px!important;
  overflow:hidden!important;
}

#serviceDetail .pdv-action-row .pdv-cart,
#serviceDetail .pdv-action-row .pdv-checkout,
#serviceDetail .pdv-cart,
#serviceDetail .pdv-checkout{
  width:190px!important;
  min-width:190px!important;
  max-width:190px!important;
  height:38px!important;
  min-height:38px!important;
  max-height:38px!important;
  border-radius:999px!important;
  padding:0 18px!important;
  margin:0!important;
  box-sizing:border-box!important;
}

/* Keep the whole right column stable when quantity changes. */
#serviceDetail .pdv-summary-product{
  min-height:104px!important;
}
#serviceDetail .pdv-summary-line{
  margin:14px 0!important;
}

/* Prevent accidental page height shift on desktop caused by summary text wrapping. */
@media(min-width:1251px){
  #serviceDetail .pdv-layout{
    align-items:start!important;
  }
  #serviceDetail .pdv-summary-card{
    min-height:0!important;
  }
}

/* -------- LEFT SIDEBAR THUMBNAILS: show image directly, no inner frame -------- */
#serviceDetail .pdv-thumb.has-real-thumb{
  padding:0!important;
  overflow:hidden!important;
  background:#fff!important;
  display:flex!important;
  align-items:stretch!important;
  justify-content:stretch!important;
}

#serviceDetail .pdv-thumb.has-real-thumb .pdv-thumb-paper.is-real-thumb{
  width:100%!important;
  height:100%!important;
  min-height:0!important;
  flex:1 1 auto!important;
  padding:0!important;
  margin:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  box-shadow:none!important;
  line-height:0!important;
  display:block!important;
  overflow:hidden!important;
}

#serviceDetail .pdv-thumb.has-real-thumb .pdv-thumb-real-img{
  width:100%!important;
  height:100%!important;
  max-width:100%!important;
  max-height:100%!important;
  display:block!important;
  object-fit:contain!important;
  object-position:center!important;
  padding:8px!important;
  margin:0!important;
  border:0!important;
  background:#fff!important;
  box-shadow:none!important;
}

#serviceDetail .pdv-thumb.has-real-thumb strong{
  display:none!important;
}

/* If an image is missing, do not show a fake paper frame. Keep the card clean. */
#serviceDetail .pdv-thumb:not(.has-real-thumb) .pdv-thumb-paper{
  border:0!important;
  box-shadow:none!important;
  background:transparent!important;
}
</style>

<style>
/* =========================================================
   FINAL LOCK 06/09 V7 - SIDEBAR THUMBNAIL IMAGE FIT ONLY
   - Sidebar real image is centered and covers the whole thumbnail box
   - Removes inner paper/frame look completely
   - Active border stays on the outside card only
   - No other UI sections changed
========================================================= */
#serviceDetail .pdv-thumb.has-real-thumb{
  position:relative!important;
  width:100%!important;
  min-height:145px!important;
  padding:0!important;
  display:block!important;
  overflow:hidden!important;
  background:#fff!important;
  border-radius:8px!important;
  box-sizing:border-box!important;
}

#serviceDetail .pdv-thumb.has-real-thumb .pdv-thumb-paper,
#serviceDetail .pdv-thumb.has-real-thumb .pdv-thumb-paper.is-real-thumb{
  position:absolute!important;
  inset:0!important;
  width:100%!important;
  height:100%!important;
  min-width:100%!important;
  min-height:100%!important;
  max-width:100%!important;
  max-height:100%!important;
  padding:0!important;
  margin:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  box-shadow:none!important;
  line-height:0!important;
  display:block!important;
  overflow:hidden!important;
}

#serviceDetail .pdv-thumb.has-real-thumb .pdv-thumb-real-img{
  position:absolute!important;
  inset:0!important;
  width:100%!important;
  height:100%!important;
  min-width:100%!important;
  min-height:100%!important;
  max-width:none!important;
  max-height:none!important;
  padding:0!important;
  margin:0!important;
  border:0!important;
  border-radius:0!important;
  display:block!important;
  object-fit:cover!important;
  object-position:center center!important;
  background:#fff!important;
  box-shadow:none!important;
}

#serviceDetail .pdv-thumb.has-real-thumb strong{
  display:none!important;
}

/* Broken/missing images: hide ugly browser broken icon/alt text instead of showing it top-left. */
#serviceDetail .pdv-thumb.has-real-thumb .pdv-thumb-real-img:not([src]),
#serviceDetail .pdv-thumb.has-real-thumb .pdv-thumb-real-img[src=""]{
  visibility:hidden!important;
}

/* Mobile keeps the same full-card image fit. */
@media(max-width:850px){
  #serviceDetail .pdv-thumb.has-real-thumb{
    min-height:108px!important;
  }
}
</style>
<style id="service-detail-section-spacing-true-last-lock">
#serviceDetail{padding-top:26px!important;padding-bottom:48px!important}
#serviceDetail .pdv-shell{width:min(1270px,calc(100% - 160px))!important;max-width:1270px!important;margin:0 auto 0 80px!important}
@media(max-width:1180px){#serviceDetail{padding-top:24px!important;padding-bottom:44px!important}#serviceDetail .pdv-shell{width:calc(100% - 44px)!important;margin-left:22px!important;margin-right:22px!important}}
@media(max-width:850px){#serviceDetail{padding-top:22px!important;padding-bottom:38px!important}#serviceDetail .pdv-shell{width:calc(100% - 28px)!important;margin-left:14px!important;margin-right:14px!important}}
</style>

<style id="service-detail-stepper-details-alignment-lock">
@media(min-width:1251px){
  #serviceDetail .pdv-layout,
  #serviceDetail .pdv-hero-row{
    grid-template-columns:150px minmax(420px,460px) minmax(350px,380px) minmax(350px,380px)!important;
    column-gap:70px!important;
  }
  #serviceDetail .pdv-service-intro{
    grid-column:1 / 3!important;
  }
  #serviceDetail .pdv-stepper{
    grid-column:3 / 5!important;
    width:100%!important;
    max-width:none!important;
    justify-self:stretch!important;
  }
  #serviceDetail .pdv-left-card{
    align-self:start!important;
    height:auto!important;
    min-height:0!important;
  }
  #serviceDetail #pdvThumbStack{
    display:grid!important;
    grid-template-columns:1fr!important;
    grid-template-rows:repeat(3,minmax(0,1fr))!important;
    gap:34px!important;
    height:auto!important;
    min-height:0!important;
    max-height:none!important;
  }
  #serviceDetail #pdvThumbStack .pdv-thumb,
  #serviceDetail #pdvThumbStack .pdv-thumb.has-real-thumb{
    width:100%!important;
    height:auto!important;
    min-height:0!important;
  }
  #serviceDetail .pdv-summary-line{
    margin:4px 0!important;
  }
  #serviceDetail .pdv-summary-product{
    min-height:90px!important;
  }
  #serviceDetail .pdv-checkout-note{
    height:auto!important;
    min-height:34px!important;
    overflow:visible!important;
  }
  #serviceDetail .pdv-checkout-note small{
    display:block!important;
    max-height:none!important;
    white-space:normal!important;
    overflow:visible!important;
  }
}
</style>

<script id="service-detail-sidebar-height-sync">
(function(){
  if(window.__pdvSidebarHeightSync)return;
  window.__pdvSidebarHeightSync=true;

  function syncSidebarHeight(){
    var root=document.getElementById('serviceDetail');
    if(!root)return;
    var stack=root.querySelector('#pdvThumbStack');
    var sidebar=root.querySelector('.pdv-left-card');
    var preview=root.querySelector('.pdv-preview-card');
    if(!stack||!sidebar||!preview)return;

    if(window.innerWidth<=1250){
      stack.style.removeProperty('height');
      stack.style.removeProperty('min-height');
      stack.style.removeProperty('max-height');
      sidebar.style.removeProperty('height');
      return;
    }

    var previewHeight=Math.round(preview.getBoundingClientRect().height);
    if(previewHeight<1)return;
    var exactHeight=previewHeight+'px';
    stack.style.setProperty('height',exactHeight,'important');
    stack.style.setProperty('min-height',exactHeight,'important');
    stack.style.setProperty('max-height',exactHeight,'important');
    sidebar.style.setProperty('height',exactHeight,'important');
  }

  function startSidebarSync(){
    syncSidebarHeight();
    var preview=document.querySelector('#serviceDetail .pdv-preview-card');
    if(preview&&window.ResizeObserver){
      new ResizeObserver(syncSidebarHeight).observe(preview);
    }
    document.querySelectorAll('#serviceDetail .pdv-preview-card img').forEach(function(image){
      if(!image.complete)image.addEventListener('load',syncSidebarHeight,{once:true});
    });
    window.addEventListener('resize',syncSidebarHeight,{passive:true});
    document.addEventListener('printify:service-detail-opened',syncSidebarHeight);
  }

  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',startSidebarSync,{once:true});
  else startSidebarSync();
})();
</script>

<script id="service-detail-first-paint-ready">
(function(){
  var revealed=false;
  function revealServiceDetail(){
    if(revealed)return;
    revealed=true;
    requestAnimationFrame(function(){requestAnimationFrame(function(){
      document.body.classList.add('service-detail-ready','service-detail-hydrated');
    });});
  }
  document.addEventListener('printify:service-detail-hydrated',revealServiceDetail,{once:true});
  window.setTimeout(revealServiceDetail,180);
})();
</script>

<style id="cart-item-file-edit-controls-lock">
body #pfyCartPanel .pfy-select-bar{padding-left:12px!important;padding-right:14px!important}
body #pfyCartPanel .pfy-item{position:relative!important}
body #pfyCartPanel .pfy-cart-item-edit{
  position:absolute!important;
  top:13px!important;
  right:26px!important;
  width:auto!important;
  height:20px!important;
  padding:0 1px 3px!important;
  border:0!important;
  border-bottom:2px solid transparent!important;
  border-radius:0!important;
  background:transparent!important;
  color:#111827!important;
  font-size:9px!important;
  font-weight:600!important;
  line-height:1!important;
  box-shadow:none!important;
  cursor:pointer!important;
  transition:color .16s ease,border-color .16s ease!important;
}
body #pfyCartPanel .pfy-cart-item-edit:hover,
body #pfyCartPanel .pfy-cart-item-edit:focus-visible{
  color:#ff4f16!important;
  border-bottom-color:#ff4f16!important;
  outline:0!important;
}
body #pfyCartPanel .pfy-cart-item-edit i{margin-right:3px!important;font-size:8px!important;color:currentColor!important}
body #pfyCartPanel .pfy-cart-file-control{
  display:flex!important;
  align-items:center!important;
  gap:5px!important;
  min-width:0!important;
  margin:5px 0 3px!important;
  color:#5f6670!important;
  font-size:8.5px!important;
  line-height:1.25!important;
}
body #pfyCartPanel .pfy-cart-file-control i{flex:0 0 auto!important;color:#6b7280!important;font-size:9px!important}
body #pfyCartPanel .pfy-cart-file-name{min-width:0!important;overflow:hidden!important;text-overflow:ellipsis!important;white-space:nowrap!important}
body #pfyCartPanel .pfy-cart-attach-file{
  width:auto!important;
  height:auto!important;
  padding:0 1px 2px!important;
  border:0!important;
  border-bottom:1px solid #ff4f16!important;
  border-radius:0!important;
  background:transparent!important;
  color:#ff4f16!important;
  font-size:8.5px!important;
  font-weight:600!important;
  line-height:1.2!important;
  box-shadow:none!important;
  cursor:pointer!important;
}
body #pfyCartPanel .pfy-cart-attach-file:hover{color:#111827!important;border-bottom-color:#111827!important}
body #pfyCartPanel{
  top:82px!important;
  transform:none!important;
  will-change:opacity!important;
  transition:opacity .16s ease!important;
}
body #pfyCartPanel:before{transition:none!important}
body #pfyCartPanel .pfy-cart-item-edit{
  min-width:38px!important;
  max-width:38px!important;
  padding-bottom:4px!important;
  border-bottom:0!important;
  text-align:center!important;
}
body #pfyCartPanel .pfy-cart-item-edit:after{
  content:"";
  position:absolute;
  left:7px;
  right:7px;
  bottom:0;
  height:2px;
  background:transparent;
  transition:background-color .16s ease;
}
body #pfyCartPanel .pfy-cart-item-edit:hover:after,
body #pfyCartPanel .pfy-cart-item-edit:focus-visible:after{background:#ff4f16}
body #pfyCartPanel .pfy-cart-order-facts{
  display:flex!important;
  align-items:center!important;
  gap:6px!important;
  margin:5px 0 2px!important;
  font-size:8.5px!important;
  line-height:1.2!important;
}
body #pfyCartPanel .pfy-cart-order-facts span{
  display:inline-flex!important;
  align-items:center!important;
  min-height:18px!important;
  padding:2px 7px!important;
  border:1px solid #e7e7e7!important;
  border-radius:999px!important;
  color:#343b45!important;
  background:#fff!important;
  white-space:nowrap!important;
}
body #pfyCartPanel .pfy-cart-order-facts .is-price-mode{
  border-color:#ffd0bd!important;
  color:#ff4f16!important;
  background:#fff7f3!important;
  font-weight:600!important;
}
</style>

<script id="cart-item-file-edit-controls">
(function(){
  if(window.__pfyCartItemFileEditControls)return;
  window.__pfyCartItemFileEditControls=true;

  function cartItems(){return typeof window.getCartItems==='function'?window.getCartItems():[]}
  function fileName(item){var raw=item&&item.raw||{};return item&&item.fileName||raw.fileName||raw.fileMeta&&raw.fileMeta.name||''}
  function enhanceCartItems(){
    var list=document.getElementById('pfyCartItems');
    if(!list)return;
    var items=cartItems();
    list.querySelectorAll('.pfy-item').forEach(function(row){
      if(row.querySelector('.pfy-cart-item-edit'))return;
      var item=items.find(function(entry){return String(entry.id)===String(row.dataset.id)});
      if(!item)return;
      row.querySelectorAll('.pfy-info p').forEach(function(line){
        if(/^File:\s|^File required$/i.test((line.textContent||'').trim()))line.style.display='none';
      });

      var edit=document.createElement('button');
      edit.type='button';
      edit.className='pfy-cart-item-edit';
      edit.dataset.cartEdit=row.dataset.id;
      edit.innerHTML='<i class="fa-regular fa-pen-to-square"></i>Edit';
      row.appendChild(edit);

      var info=row.querySelector('.pfy-info');
      if(!info)return;
      var raw=item.raw||{};
      var quantity=Math.max(1,parseInt(item.qty||raw.quantity,10)||1);
      var bulkAt=Math.max(1,parseInt(raw.bulkAt,10)||50);
      var mode=String(raw.priceMode||item.priceType||item.price_type||(quantity>=bulkAt?'Bulk':'Retail')).replace(/\s*Price$/i,'');
      var facts=document.createElement('div');
      facts.className='pfy-cart-order-facts';
      facts.innerHTML='<span class="is-quantity-count">'+quantity+' pcs</span><span class="is-price-mode">'+mode+'</span>';
      var quantityRow=info.querySelector('.pfy-bottom');
      if(quantityRow)info.insertBefore(facts,quantityRow);else info.appendChild(facts);
      var control=document.createElement('div');
      control.className='pfy-cart-file-control';
      var attached=fileName(item);
      if(attached){
        control.innerHTML='<i class="fa-solid fa-paperclip"></i><span class="pfy-cart-file-name">Attached: '+String(attached).replace(/[&<>"']/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]})+'</span>';
      }else{
        control.innerHTML='<i class="fa-solid fa-paperclip"></i><button type="button" class="pfy-cart-attach-file" data-cart-attach="'+row.dataset.id+'">Attach File</button><input type="file" data-cart-file="'+row.dataset.id+'" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png" hidden>';
      }
      var price=info.querySelector('.pfy-price');
      info.insertBefore(control,price||null);
    });
  }

  document.addEventListener('click',function(event){
    var attach=event.target.closest&&event.target.closest('#pfyCartPanel [data-cart-attach]');
    if(attach){
      var input=document.querySelector('#pfyCartPanel input[data-cart-file="'+CSS.escape(attach.dataset.cartAttach)+'"]');
      if(input)input.click();
      return;
    }
    var edit=event.target.closest&&event.target.closest('#pfyCartPanel [data-cart-edit]');
    if(!edit)return;
    var item=cartItems().find(function(entry){return String(entry.id)===String(edit.dataset.cartEdit)});
    if(!item)return;
    if(typeof window.closePrintifyCart==='function')window.closePrintifyCart();
    if(typeof window.openPrintifyServiceDetail==='function')window.openPrintifyServiceDetail(item.raw||item,true);
  });

  document.addEventListener('change',function(event){
    var input=event.target.closest&&event.target.closest('#pfyCartPanel input[data-cart-file]');
    if(!input||!input.files||!input.files[0])return;
    var file=input.files[0];
    var items=cartItems();
    var item=items.find(function(entry){return String(entry.id)===String(input.dataset.cartFile)});
    if(!item)return;
    item.fileName=file.name;
    item.raw=item.raw&&typeof item.raw==='object'?item.raw:{};
    item.raw.fileName=file.name;
    item.raw.fileMeta={name:file.name,size:file.size,type:file.type,lastModified:file.lastModified};
    item.meta=(item.meta||[]).filter(function(value){return !/^File:\s/i.test(String(value||''))});
    item.meta.push('File: '+file.name);
    if(typeof window.saveCartItems==='function')window.saveCartItems(items);
    if(typeof window.uploadCartAttachment==='function'){
      window.uploadCartAttachment(item.id,file).catch(function(error){
        window.alert(error&&error.message?error.message:'Unable to attach the file to this cart item.');
      });
    }
  });

  var list=document.getElementById('pfyCartItems');
  if(list&&window.MutationObserver)new MutationObserver(enhanceCartItems).observe(list,{childList:true});
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',enhanceCartItems,{once:true});
  else enhanceCartItems();
})();
</script>

<script id="cart-backend-finalization">
(function(){
  if(window.__pfyCartBackendFinalized)return;
  window.__pfyCartBackendFinalized=true;
  var hydrating=false,syncTimer=0;
  var csrf=(document.querySelector('meta[name="csrf-token"]')||{}).content||'';

  function backendPayload(items){
    return (items||[]).map(function(item){
      var raw=item.raw&&typeof item.raw==='object'?item.raw:{};
      var mode=String(raw.priceMode||item.priceType||item.price_type||'retail').toLowerCase().indexOf('bulk')>-1?'bulk':'retail';
      return {
        id:String(item.id||raw.id||''),
        name:String(item.name||raw.serviceName||'Print Item'),
        qty:Math.max(1,parseInt(item.qty||raw.quantity,10)||1),
        unit_price:Number(item.unitPrice||item.price||raw.unitPrice||0),
        price:Number(item.unitPrice||item.price||raw.unitPrice||0),
        service_id:raw.service_id||raw.serviceId||null,
        variation_id:raw.variation_id||null,
        service_item_id:raw.service_item_id||raw.serviceItemId||raw.serviceId||null,
        category:raw.category||null,
        variation_label:raw.variation_label||raw.serviceOption||null,
        unit:raw.unit||'pcs',
        image_path:item.image||raw.image||null,
        service_code:raw.serviceId||null,
        price_type:mode,
        selected:item.selected!==false,
        file_name:item.fileName||raw.fileName||raw.fileMeta&&raw.fileMeta.name||null,
        file_meta:raw.fileMeta||null,
        meta:Array.isArray(item.meta)?item.meta:[],
        raw:raw
      };
    });
  }

  window.syncCartToBackend=async function(items){
    var response=await fetch('{{ route('cart.sync') }}',{
      method:'POST',
      headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf},
      credentials:'same-origin',
      body:JSON.stringify({items:backendPayload(items)})
    });
    if(!response.ok)throw new Error('Unable to save the cart.');
    return response.json();
  };

  window.scheduleBackendCartSync=function(items){
    if(hydrating)return;
    clearTimeout(syncTimer);
    syncTimer=setTimeout(function(){
      window.syncCartToBackend(items).catch(function(){
        document.getElementById('pfyCartPanel')?.setAttribute('data-sync-status','pending');
      });
    },180);
  };

  window.uploadCartAttachment=async function(cartId,file){
    var items=typeof window.getCartItems==='function'?window.getCartItems():[];
    await window.syncCartToBackend(items);
    var body=new FormData();
    body.append('cart_id',String(cartId));
    body.append('file',file);
    var response=await fetch('{{ route('cart.attachment') }}',{
      method:'POST',headers:{'Accept':'application/json','X-CSRF-TOKEN':csrf},credentials:'same-origin',body:body
    });
    var data=await response.json().catch(function(){return {}});
    if(!response.ok)throw new Error(data.message||'Unable to attach the file.');
    return data;
  };

  window.applyBackendCartPromo=async function(code){
    var response=await fetch('{{ route('cart.promo') }}',{
      method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf},credentials:'same-origin',body:JSON.stringify({code:code})
    });
    var data=await response.json().catch(function(){return {}});
    if(!response.ok)throw new Error(data.message||'Invalid promo code.');
    return data;
  };

  async function hydrateCart(){
    try{
      var response=await fetch('{{ route('cart.state') }}',{headers:{'Accept':'application/json'},credentials:'same-origin'});
      if(!response.ok)return;
      var data=await response.json();
      var local=typeof window.getCartItems==='function'?window.getCartItems():[];
      if(data.promo_code)localStorage.setItem('printifyPromoCode',data.promo_code);
      if(Array.isArray(data.items)&&data.items.length){
        var compact=function(items){return JSON.stringify((items||[]).map(function(item){var raw=item&&item.raw||{};return [String(item.id||raw.id||''),Number(item.qty||item.quantity||raw.quantity||1),Number(item.unitPrice||item.price||raw.unitPrice||0),item.selected!==false,String(item.fileName||raw.fileName||'')]}))};
        if(compact(data.items)!==compact(local)){
          hydrating=true;
          window.saveCartItems(data.items);
          hydrating=false;
        }
      }else if(local.length){
        await window.syncCartToBackend(local);
      }
    }catch(error){}finally{
      requestAnimationFrame(function(){document.body.classList.add('cart-ui-ready')});
    }
  }

  window.setTimeout(function(){document.body.classList.add('cart-ui-ready')},450);

  window.alignPrintifyCartPointerExact=function(){
    var panel=document.getElementById('pfyCartPanel');
    if(!panel)return;
    panel.style.setProperty('top','82px','important');
    panel.style.setProperty('max-height','calc(100vh - 102px)','important');
  };

  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',hydrateCart,{once:true});
  else hydrateCart();
})();
</script>

<script id="cart-direct-open-final-lock">
(function(){
  function markCartReady(){requestAnimationFrame(function(){document.body.classList.add('cart-ui-ready')})}
  function cartSignature(items){return JSON.stringify((items||[]).map(function(i){var raw=i&&i.raw||{};return [i.id||raw.id||'',i.qty||i.quantity||raw.quantity||1,i.selected!==false,i.unitPrice||i.price||raw.unitPrice||0,i.fileName||raw.fileName||'']}))+"|"+(localStorage.getItem('printifyPromoCode')||'')}
  var renderCartFinal=window.renderPrintifyCart;
  if(typeof renderCartFinal==='function'&&!renderCartFinal.__singlePass){
    var singlePassRender=function(items){var source=Array.isArray(items)?items:(typeof window.getCartItems==='function'?window.getCartItems():[]);var signature=cartSignature(source);if(window.__pfyCartInitialRenderComplete&&signature===window.__pfyCartRenderSignature)return;var result=renderCartFinal.apply(this,arguments);window.__pfyCartInitialRenderComplete=true;window.__pfyCartRenderSignature=signature;return result};
    singlePassRender.__singlePass=true;
    window.renderPrintifyCart=singlePassRender;
  }
  function anchor(){return document.querySelector('#navCart .nav-svg-icon')||document.getElementById('navCart')}
  function align(){
    var panel=document.getElementById('pfyCartPanel'),icon=anchor();
    if(!panel)return;
    panel.style.setProperty('top','66px','important');
    panel.style.setProperty('max-height','calc(100vh - 82px)','important');
    if(!icon)return;
    var ir=icon.getBoundingClientRect(),pr=panel.getBoundingClientRect();
    panel.style.setProperty('--pfy-pointer-right',Math.max(13,Math.min(pr.width-26,pr.right-(ir.left+ir.width/2)-13))+'px');
  }
  window.alignPrintifyCartPointerExact=align;
  window.openPrintifyCart=function(){
    if(typeof requireSignedInForOrder==='function'&&!requireSignedInForOrder())return false;
    document.body.classList.add('cart-ui-ready');
    if(typeof window.renderPrintifyCart==='function')window.renderPrintifyCart();
    align();
    document.getElementById('pfyCartPanel')?.classList.add('show');
    document.getElementById('pfyCartBackdrop')?.classList.add('show');
    if(typeof updateBrowserUrl==='function')updateBrowserUrl('cart');
    return true;
  };
  window.toggleCart=function(){
    return document.getElementById('pfyCartPanel')?.classList.contains('show')?(window.closePrintifyCart(),false):window.openPrintifyCart();
  };
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',markCartReady,{once:true});
  else markCartReady();
})();
</script>

<style id="cart-zero-shake-absolute-final-lock">
body #pfyCartPanel,
body #pfyCartPanel.show{
  top:66px!important;
  transform:none!important;
  translate:none!important;
  animation:none!important;
  transition:none!important;
  will-change:auto!important;
}
body #pfyCartPanel:before{
  top:-18px!important;
  width:0!important;
  height:0!important;
  border:0!important;
  border-left:13px solid transparent!important;
  border-right:13px solid transparent!important;
  border-bottom:18px solid #fff!important;
  border-radius:0!important;
  background:transparent!important;
  transform:none!important;
  filter:drop-shadow(0 -1px 0 #e8e8e8)!important;
  animation:none!important;
  transition:none!important;
}
body #pfyCartPanel .pfy-bottom{
  align-items:center!important;
  gap:0!important;
  flex-wrap:nowrap!important;
}
body #pfyCartPanel .pfy-cart-order-facts{
  display:flex!important;
  align-items:center!important;
  gap:14px!important;
  margin:5px 0 7px!important;
}
body #pfyCartPanel .pfy-cart-order-facts span{
  min-height:0!important;
  padding:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  font-size:9px!important;
  line-height:1.25!important;
}
body #pfyCartPanel .pfy-cart-order-facts .is-quantity-count{
  color:#5f6670!important;
}
body #pfyCartPanel .pfy-cart-order-facts .is-price-mode{
  min-width:0!important;
  color:#ff4f16!important;
  font-weight:600!important;
}
body #pfyCartBackdrop,
body #pfyCartBackdrop.show{
  animation:none!important;
  transition:none!important;
}
</style>
