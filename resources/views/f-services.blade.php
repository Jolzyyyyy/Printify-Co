<section id="products" class="pfsvc" aria-labelledby="pfsvcTitle">
  <div class="pfsvc-feedback" id="pfsvcFeedback" role="status" aria-live="polite">
    <i class="fa-regular fa-circle-check"></i>
    <span>Services ready.</span>
  </div>

  <div class="pfsvc-wrap">
    <aside class="pfsvc-side" aria-label="Browse services">
      <h3>Browse Services</h3>
      <button type="button" class="pfsvc-nav active" data-filter="all"><i class="fa-solid fa-table-cells-large"></i><span>All Services</span></button>
      <button type="button" class="pfsvc-nav" data-filter="doc"><i class="fa-solid fa-print"></i><span>Document Printing</span></button>
      <button type="button" class="pfsvc-nav" data-filter="photo"><i class="fa-solid fa-copy"></i><span>Photocopy &amp; Scanning</span></button>
      <button type="button" class="pfsvc-nav" data-filter="id"><i class="fa-solid fa-id-card"></i><span>ID &amp; Photo Services</span></button>
      <button type="button" class="pfsvc-nav" data-filter="bind"><i class="fa-solid fa-book-open"></i><span>Lamination &amp; Binding</span></button>
      <button type="button" class="pfsvc-nav" data-filter="largeformat"><i class="fa-solid fa-image"></i><span>Large Format Printing</span></button>
      <button type="button" class="pfsvc-nav" data-filter="special"><i class="fa-solid fa-star"></i><span>Custom Special Printing</span></button>

      <div class="pfsvc-filterbox">
        <h3>Filter By</h3>

        <label class="pfsvc-label" for="pfsvcPrice">Price Range</label>
        <div class="pfsvc-price-row"><span>₱0</span><strong id="pfsvcPriceValue">₱20,000+</strong></div>
        <input id="pfsvcPrice" type="range" min="0" max="20000" value="20000" step="100">

        <label class="pfsvc-label" for="pfsvcTime">TURNAROUND TIME</label>
        <select id="pfsvcTime">
          <option value="all">Any Time</option>
          <option value="same-day">Same Day</option>
          <option value="next-day">Next Day</option>
          <option value="custom">Custom</option>
        </select>

        <label class="pfsvc-switch">
          <input id="pfsvcExpress" type="checkbox" checked>
          <span>SHOW EXPRESS SERVICES</span>
          <b>ON</b>
        </label>
      </div>
    </aside>

    <main class="pfsvc-main">
      <div class="pfsvc-head">
        <span>What We Do</span>
        <h2 id="pfsvcTitle">Our Featured Services</h2>
        <p>Professional printing solutions tailored to your business and personal needs.</p>
      </div>

      <div class="pfsvc-tools" aria-label="Service controls">
        <button type="button" class="pfsvc-btn pfsvc-all active" onclick="pfsvcSetCategory('all')">
          <i class="fa-solid fa-table-cells-large"></i>
          <span>VIEW ALL SERVICES</span>
        </button>

        <label class="pfsvc-sort">SORT BY:
          <select id="pfsvcSort">
            <option value="popular">Popular</option>
            <option value="name">Name</option>
            <option value="price">Price</option>
          </select>
        </label>

        <button type="button" class="pfsvc-view active" data-view="grid" aria-label="Grid view"><i class="fa-solid fa-grip"></i></button>
        <button type="button" class="pfsvc-view" data-view="list" aria-label="List view"><i class="fa-solid fa-list"></i></button>
      </div>

      <div class="pfsvc-grid" id="pfsvcGrid"></div>

      <div class="pfsvc-empty" id="pfsvcEmpty">
        <i class="fa-solid fa-circle-info"></i>
        <h3>No service matched.</h3>
        <p>Try another filter or contact us for custom printing support.</p>
      </div>

      <div class="pfsvc-callout">
        <div class="pfsvc-callout-icon"><i class="fa-solid fa-truck-fast"></i></div>
        <div>
          <h3>Bulk Order or Regular Printing Needs?</h3>
          <p>Get support for business and bulk printing orders.</p>
        </div>
        <a class="pfsvc-btn" href="/contactus"><span>CONTACT US</span> <i class="fa-solid fa-arrow-right"></i></a>
      </div>

      <section class="pfsvc-detail" id="pfsvcDetail" hidden>
        <div class="pfsvc-detail-icon" id="pfsvcDetailIcon"><i class="fa-solid fa-print"></i></div>
        <div>
          <span>Selected Service</span>
          <h3 id="pfsvcDetailTitle">Document Printing</h3>
          <p id="pfsvcDetailDesc">Choose a service option to continue.</p>
        </div>
        <button type="button" class="pfsvc-btn" onclick="pfsvcProceedSelected()">Open Details <i class="fa-solid fa-arrow-right"></i></button>
      </section>
    </main>
  </div>
</section>

<div class="pfsvc-deck" id="pfsvcDeck" aria-hidden="true">
  <button type="button" class="pfsvc-deck-close" onclick="pfsvcCloseDeck()" aria-label="Close service options">
    <i class="fa-solid fa-xmark"></i>
  </button>

  <div class="pfsvc-deck-card">
    <div class="pfsvc-deck-title">
      <span id="pfsvcDeckKicker"><i class="fa-solid fa-print"></i> Document Printing</span>
      <h3 id="pfsvcDeckHeading">Choose Service Option</h3>
      <p>Select one card to continue.</p>
    </div>

    <button type="button" class="pfsvc-arrow left" onclick="pfsvcMoveDeck(-1)" aria-label="Previous option">
      <i class="fa-solid fa-chevron-left"></i>
    </button>

    <div class="pfsvc-stage" id="pfsvcStage"></div>

    <button type="button" class="pfsvc-arrow right" onclick="pfsvcMoveDeck(1)" aria-label="Next option">
      <i class="fa-solid fa-chevron-right"></i>
    </button>

    <div class="pfsvc-deck-actions">
      <div class="pfsvc-dots" id="pfsvcDots"></div>
      <button type="button" class="pfsvc-btn" id="pfsvcContinue" onclick="pfsvcProceedSelected()">Continue <i class="fa-solid fa-arrow-right"></i></button>
    </div>
  </div>
</div>

<style>
@font-face{
  font-family:'Boxing';
  src:url('/Fonts/Boxing-Regular.otf') format('opentype');
  font-weight:400;
  font-style:normal;
  font-display:swap;
}

@font-face{
  font-family:'Clash Display';
  src:url('/Fonts/ClashDisplay-Semibold.otf') format('opentype');
  font-weight:600;
  font-style:normal;
  font-display:swap;
}

@font-face{
  font-family:'InterFinal';
  src:url('/Fonts/Inter.ttc') format('truetype-collection');
  font-weight:600;
  font-style:normal;
  font-display:swap;
}

.pfsvc{
  width:100vw;
  margin-left:calc(50% - 50vw);
  padding:34px 0 64px;
  background:#fff;
  color:#111;
  font-family:'InterFinal',system-ui,sans-serif;
  font-weight:400;
  letter-spacing:0;
  scroll-margin-top:90px;
}

.pfsvc *{
  box-sizing:border-box;
}

.pfsvc-wrap{
  width:min(1280px,calc(100% - 104px));
  margin:0 24px 0 92px;
  display:grid;
  grid-template-columns:290px minmax(0,1fr);
  gap:42px;
  align-items:start;
}

.pfsvc-feedback{
  display:none;
  position:fixed;
  top:76px;
  left:50%;
  z-index:999999;
  transform:translate(-50%,-12px);
  min-width:250px;
  height:38px;
  padding:0 16px;
  border:1px solid #111;
  border-radius:10px;
  background:#111;
  color:#fff;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:10px;
  font:600 12px 'Clash Display';
  opacity:0;
  pointer-events:none;
  transition:opacity .25s ease,transform .25s ease;
}

.pfsvc-feedback.show{
  opacity:1;
  transform:translate(-50%,0);
}

.pfsvc-feedback i{
  color:#ff7a00;
}

.pfsvc-side{
  position:sticky;
  top:95px;
  background:#fff;
  padding:0 0 18px;
  border-right:0;
}

.pfsvc-side h3{
  margin:0 0 16px;
  color:#111;
  font:600 14px 'Clash Display';
  text-transform:uppercase;
}

.pfsvc-nav{
  width:calc(100% - 18px);
  height:40px;
  margin:0 18px 7px 0;
  border:0;
  border-radius:0;
  background:#fff;
  color:#111;
  display:flex;
  align-items:center;
  gap:14px;
  padding:0 16px;
  cursor:pointer;
  font:600 13px 'Clash Display';
  text-align:left;
  transition:background-color .2s ease,color .2s ease;
}

.pfsvc-nav i{
  width:18px;
  text-align:center;
  color:#111;
}

.pfsvc-nav:hover,
.pfsvc-nav.active{
  background:#fff1e8;
  color:#ff5a12;
  border-left:3px solid #ff5a12;
}

.pfsvc-nav:hover i,
.pfsvc-nav.active i{
  color:#ff5a12;
}

.pfsvc-filterbox{
  margin-top:24px;
  padding-top:22px;
  border-top:1px solid #111;
}

.pfsvc-label{
  display:block;
  margin:0 0 8px;
  color:#111;
  font:600 13px 'Clash Display';
}

.pfsvc-price-row{
  display:flex;
  justify-content:space-between;
  margin-bottom:8px;
  color:#111;
  font-size:11px;
}

.pfsvc-price-row strong{
  font-weight:400;
}

.pfsvc-filterbox input[type=range]{
  width:calc(100% - 18px);
  accent-color:#ff7a00;
}

.pfsvc-filterbox select{
  width:calc(100% - 18px);
  height:38px;
  margin:6px 0 18px;
  padding:0 12px;
  border:1px solid #111;
  border-radius:4px;
  background:#fff;
  color:#111;
  font:400 12px 'InterFinal';
  outline:none;
}

.pfsvc-switch{
  width:calc(100% - 18px);
  display:grid;
  grid-template-columns:1fr 54px;
  align-items:center;
  gap:10px;
  color:#111;
  font:400 12px 'InterFinal';
  cursor:pointer;
}

.pfsvc-switch input{
  display:none;
}

.pfsvc-switch b{
  height:28px;
  border-radius:999px;
  background:#111;
  color:#fff;
  display:flex;
  align-items:center;
  justify-content:center;
  font:600 10px 'Clash Display';
  transition:.2s;
}

.pfsvc-switch input:checked~b{
  background:#ff7a00;
  color:#111;
}

.pfsvc-main{
  min-width:0;
}

.pfsvc-head{
  margin-bottom:18px;
}

.pfsvc-head span{
  display:block;
  margin-bottom:8px;
  color:#ff5a12;
  font:600 13px 'Clash Display';
  text-transform:uppercase;
}

.pfsvc-head h2{
  margin:0 0 8px;
  color:#111;
  font:700 50px/1.04 'Clash Display',Georgia,serif;
  letter-spacing:0;
}

.pfsvc-head p{
  margin:0;
  color:#333;
  font-size:14px;
  line-height:1.55;
}

.pfsvc-tools{
  display:grid;
  grid-template-columns:auto minmax(0,1fr) auto 38px 38px;
  gap:10px;
  align-items:center;
  margin-bottom:18px;
}

.pfsvc-sort{
  height:38px;
  display:flex;
  align-items:center;
  gap:8px;
  white-space:nowrap;
  color:#111;
  font:600 12px 'Clash Display';
  grid-column:3;
}

.pfsvc-sort select{
  height:38px;
  min-width:134px;
  border:1px solid #111;
  border-radius:4px;
  background:#fff;
  color:#111;
  padding:0 10px;
  font:400 12px 'InterFinal';
  outline:none;
}

.pfsvc-btn{
  height:38px;
  min-width:136px;
  border:0!important;
  border-radius:8px;
  background:#ff7a00;
  color:#111;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  padding:0 16px;
  text-decoration:none;
  cursor:pointer;
  font:600 12px 'Clash Display';
  letter-spacing:0;
  transition:background-color .22s ease,color .22s ease;
}

.pfsvc-btn:hover,
.pfsvc-btn.active{
  background:#111!important;
  color:#fff!important;
}

.pfsvc-view{
  width:38px;
  height:38px;
  border:0;
  background:#fff;
  color:#111;
  display:grid;
  place-items:center;
  cursor:pointer;
  font-size:17px;
}

.pfsvc-view:hover,
.pfsvc-view.active{
  color:#ff5a12;
}

.pfsvc-grid{
  display:grid;
  grid-template-columns:repeat(5, minmax(0, 156px));
  justify-content:start;
  gap:14px;
  width:100%;
}

.pfsvc-grid.list{
  grid-template-columns:repeat(5, minmax(0, 156px));
}

.pfsvc-grid.list .pfsvc-card{
  display:block;
}

.pfsvc-grid.list .pfsvc-img,
.pfsvc-grid.list .pfsvc-img img{
  height:96px;
}

.pfsvc-card{
  width:156px;
  height:245px;
  border:1px solid #111;
  border-radius:15px;
  background:#fff;
  overflow:hidden;
  cursor:pointer;
  transition:transform .22s ease,background-color .22s ease,box-shadow .22s ease;
  display:flex;
  flex-direction:column;
  box-shadow:0 8px 18px rgba(0,0,0,.08);
}

.pfsvc-card:hover{
  transform:translateY(-4px);
  background:#fff7f1;
  box-shadow:0 14px 26px rgba(0,0,0,.12);
}

.pfsvc-img{
  position:relative;
  height:96px;
  background:#f7f7f7;
  border-bottom:1px solid #ececec;
  flex:0 0 auto;
}

.pfsvc-img img{
  width:100%;
  height:100%;
  object-fit:cover;
  object-position:center;
  display:block;
}

.pfsvc-img.no-image{
  background:linear-gradient(135deg,#fafafa,#f1f1f1);
}

.pfsvc-icon{
  position:absolute;
  left:10px;
  bottom:-13px;
  width:28px;
  height:28px;
  border:1px solid #ffd8bd;
  border-radius:8px;
  background:#fff4ec;
  color:#ff7a00;
  display:grid;
  place-items:center;
  font-size:12px;
  box-shadow:0 8px 18px rgba(255,122,0,.12);
}

.pfsvc-body{
  height:auto;
  padding:20px 10px 10px;
  display:flex;
  flex:1 1 auto;
  flex-direction:column;
  align-items:flex-start;
  justify-content:flex-start;
}

.pfsvc-body h3{
  min-height:34px;
  margin:0 0 4px;
  color:#111;
  font:600 12.5px/1.25 'Clash Display';
  letter-spacing:0;
  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
}

.pfsvc-body p{
  min-height:30px;
  margin:0 0 8px;
  color:#333;
  font-size:9.8px;
  line-height:1.25;
  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
}

.pfsvc-meta{
  width:100%;
  margin:0 0 8px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:6px;
  color:#111;
  font:600 10px 'Clash Display';
}

.pfsvc-price{
  max-width:95px;
  min-height:auto;
  border:0;
  border-radius:0;
  background:transparent;
  padding:0;
  display:inline-flex;
  align-items:center;
  justify-content:flex-end;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
  color:#111;
  font:700 10px 'Clash Display';
}

.pfsvc-type{
  color:#ff7a00;
  font:600 9.5px 'Clash Display';
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}

.pfsvc-card button{
  height:28px;
  min-width:92px;
  border:0;
  border-radius:8px;
  background:#ff7a00;
  color:#111;
  font:600 10px 'Clash Display';
  cursor:pointer;
  margin-top:auto;
  align-self:flex-start;
}

.pfsvc-card button:hover{
  background:#111;
  color:#fff;
}

.pfsvc-empty{
  display:none;
  margin-top:14px;
  border:1px solid #111;
  border-radius:8px;
  padding:28px;
  text-align:center;
}

.pfsvc-empty i{
  color:#ff7a00;
  font-size:25px;
}

.pfsvc-empty h3{
  font:600 18px 'Clash Display';
  margin:10px 0 4px;
}

.pfsvc-empty p{
  margin:0;
  color:#333;
  font-size:13px;
}

.pfsvc-callout{
  margin-top:22px;
  padding:0 14px;
  display:flex;
  align-items:center;
  gap:14px;
  background:transparent;
}

.pfsvc-detail{
  display:none!important;
}

.pfsvc-callout-icon{
  width:44px;
  height:44px;
  border-radius:50%;
  display:grid;
  place-items:center;
  color:#ff7a00;
  border:1px solid #ff7a00;
}

.pfsvc-callout h3{
  margin:0 0 3px;
  font:600 16px 'Clash Display';
}

.pfsvc-callout p{
  margin:0;
  color:#333;
  font-size:13px;
}

.pfsvc-callout a{
  margin-left:auto;
}

.pfsvc-deck{
  position:fixed;
  inset:0;
  z-index:99999;
  display:none;
  align-items:center;
  justify-content:center;
  background:rgba(0,0,0,.72);
  padding:20px;
}

.pfsvc-deck.active{
  display:flex;
}

.pfsvc-deck-card{
  position:relative;
  width:min(840px,94vw);
  min-height:500px;
  color:#fff;
  text-align:center;
}

.pfsvc-deck-close{
  position:absolute;
  right:0;
  top:0;
  width:44px;
  height:44px;
  border:0;
  border-radius:50%;
  background:#fff;
  color:#111;
  cursor:pointer;
  font-size:18px;
  z-index:20;
}

.pfsvc-deck-close:hover{
  background:#111;
  color:#fff;
}

.pfsvc-deck-title{
  padding-top:32px;
}

.pfsvc-deck-title span{
  color:#ff7a00;
  font:600 12px 'Clash Display';
  text-transform:uppercase;
}

.pfsvc-deck-title h3{
  margin:8px 0 3px;
  color:#fff;
  font:700 31px/1 'Clash Display';
}

.pfsvc-deck-title p{
  margin:0;
  color:#fff;
  font-size:12px;
}

.pfsvc-stage{
  position:relative;
  height:316px;
  margin:14px auto 0;
  width:min(560px,90vw);
  perspective:1200px;
}

.pfsvc-option{
  position:absolute;
  left:50%;
  top:50%;
  width:250px;
  height:300px;
  border:0;
  border-radius:16px;
  background:#fff;
  color:#111;
  padding:0;
  box-shadow:0 25px 55px rgba(0,0,0,.32);
  cursor:pointer;
  transform-origin:center 112%;
  transition:transform 1s cubic-bezier(.16,1,.3,1),opacity .35s ease,filter .35s ease,border-color .35s ease;
  will-change:transform;
  overflow:hidden;
}

.pfsvc-option.active{
  z-index:5;
}

.pfsvc-option.left,
.pfsvc-option.right{
  z-index:3;
  filter:none;
}

.pfsvc-option.hidden{
  opacity:0;
  pointer-events:none;
}

.pfsvc-option-img{
  width:100%;
  height:100%;
  border-radius:16px;
  background:#fff7f1;
  display:grid;
  place-items:center;
  overflow:hidden;
}

.pfsvc-option-img img{
  width:100%;
  height:100%;
  object-fit:cover;
}

.pfsvc-option-img i{
  font-size:82px;
  color:#ff7a00;
}

.pfsvc-option h4{
  display:none;
}

.pfsvc-option p{
  display:none;
}

.pfsvc-option small{
  display:none;
}

.pfsvc-arrow{
  position:absolute;
  top:57%;
  width:42px;
  height:42px;
  border:0;
  border-radius:50%;
  background:#fff;
  color:#111;
  cursor:pointer;
  z-index:15;
}

.pfsvc-arrow:hover{
  background:#ff7a00;
  color:#111;
}

.pfsvc-arrow.left{
  left:150px;
}

.pfsvc-arrow.right{
  right:150px;
}

.pfsvc-deck-actions{
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:8px;
  position:relative;
  z-index:8;
  margin-top:2px;
}

.pfsvc-dots{
  display:flex;
  gap:6px;
}

.pfsvc-dots button{
  width:8px;
  height:8px;
  border:0;
  border-radius:50%;
  background:#fff;
  opacity:.45;
  cursor:pointer;
}

.pfsvc-dots button.active{
  width:22px;
  border-radius:999px;
  background:#ff7a00;
  opacity:1;
}

@media(max-width:1120px){
  .pfsvc-wrap{
    width:calc(100% - 36px);
    margin:0 18px;
    grid-template-columns:1fr;
  }

  .pfsvc-side{
    position:static;
    border-right:0;
    border-bottom:1px solid #111;
    padding-bottom:20px;
  }

  .pfsvc-grid,
  .pfsvc-grid.list{
    grid-template-columns:repeat(3, minmax(0, 156px));
  }
}

@media(max-width:720px){
  .pfsvc-head h2{
    font-size:38px;
  }

  .pfsvc-tools{
    grid-template-columns:1fr 1fr;
  }

  .pfsvc-tools input,
  .pfsvc-sort{
    grid-column:1/-1;
  }

  .pfsvc-grid,
  .pfsvc-grid.list{
    grid-template-columns:repeat(2, minmax(0, 156px));
  }

  .pfsvc-grid.list .pfsvc-card{
    display:block;
  }

  .pfsvc-callout,
  .pfsvc-detail{
    align-items:flex-start;
    flex-direction:column;
  }

  .pfsvc-callout a,
  .pfsvc-detail button{
    margin-left:0;
  }

  .pfsvc-arrow.left{
    left:6px;
  }

  .pfsvc-arrow.right{
    right:6px;
  }
}



/* FINAL PATCH: ONLY SELECTED SERVICES BUTTONS MATCH CONTACT US BUTTON STYLE */
:root{
  --ui-orange-start:#FE7B09;
  --ui-orange-end:#FFAB0A;
  --ui-black:#111827;
}

/* Apply Contact Us button style ONLY to:
   ALL SERVICES, CONTACT US, LEARN MORE, and ON */
.pfsvc .pfsvc-tools .pfsvc-all,
.pfsvc .pfsvc-callout a.pfsvc-btn,
.pfsvc .pfsvc-card button,
.pfsvc .pfsvc-switch b{
  width:auto!important;
  min-width:104px!important;
  height:34px!important;
  padding:8px 16px!important;
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(90deg,var(--ui-orange-start),var(--ui-orange-end))!important;
  color:#111827!important;
  font-family:"Clash Display",Arial,sans-serif!important;
  font-size:11px!important;
  font-weight:500!important;
  line-height:1!important;
  letter-spacing:0!important;
  text-transform:none!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  gap:7px!important;
  white-space:nowrap!important;
  box-shadow:none!important;
  transform:none!important;
  text-decoration:none!important;
  cursor:pointer!important;
  transition:background .18s ease,color .18s ease,border-color .18s ease,box-shadow .18s ease!important;
}

.pfsvc .pfsvc-tools .pfsvc-all:hover,
.pfsvc .pfsvc-tools .pfsvc-all:focus,
.pfsvc .pfsvc-tools .pfsvc-all.active,
.pfsvc .pfsvc-callout a.pfsvc-btn:hover,
.pfsvc .pfsvc-callout a.pfsvc-btn:focus,
.pfsvc .pfsvc-card button:hover,
.pfsvc .pfsvc-card button:focus,
.pfsvc .pfsvc-switch:hover b,
.pfsvc .pfsvc-switch:focus-within b{
  background:var(--ui-black)!important;
  color:#ffffff!important;
  border-color:var(--ui-black)!important;
  box-shadow:none!important;
  transform:none!important;
  outline:0!important;
}

.pfsvc .pfsvc-tools .pfsvc-all:hover i,
.pfsvc .pfsvc-tools .pfsvc-all:focus i,
.pfsvc .pfsvc-tools .pfsvc-all.active i,
.pfsvc .pfsvc-callout a.pfsvc-btn:hover i,
.pfsvc .pfsvc-callout a.pfsvc-btn:focus i,
.pfsvc .pfsvc-card button:hover i,
.pfsvc .pfsvc-card button:focus i{
  color:#ffffff!important;
}

/* Keep Browse Services / sidebar buttons in their original style */
.pfsvc .pfsvc-nav{
  width:calc(100% - 18px)!important;
  height:40px!important;
  margin:0 18px 7px 0!important;
  border:0!important;
  border-radius:0!important;
  background:#fff!important;
  color:#111!important;
  display:flex!important;
  align-items:center!important;
  justify-content:flex-start!important;
  gap:14px!important;
  padding:0 16px!important;
  cursor:pointer!important;
  font:600 13px 'Clash Display'!important;
  text-align:left!important;
  transition:background-color .2s ease,color .2s ease!important;
}

.pfsvc .pfsvc-nav i{
  width:18px!important;
  text-align:center!important;
  color:#111!important;
  font-size:inherit!important;
}

.pfsvc .pfsvc-nav:hover,
.pfsvc .pfsvc-nav.active{
  background:#fff1e8!important;
  color:#ff5a12!important;
  border-left:3px solid #ff5a12!important;
}

.pfsvc .pfsvc-nav:hover i,
.pfsvc .pfsvc-nav.active i{
  color:#ff5a12!important;
}

/* Keep grid/list view buttons and close buttons in their original style */
.pfsvc .pfsvc-view{
  width:38px!important;
  height:38px!important;
  border:0!important;
  border-radius:0!important;
  background:#fff!important;
  color:#111!important;
  display:grid!important;
  place-items:center!important;
  cursor:pointer!important;
  font-size:17px!important;
}

.pfsvc .pfsvc-view:hover,
.pfsvc .pfsvc-view.active{
  background:#fff!important;
  color:#ff5a12!important;
}

.pfsvc .pfsvc-deck-close{
  width:44px!important;
  height:44px!important;
  border:0!important;
  border-radius:50%!important;
  background:#fff!important;
  color:#111!important;
}

.pfsvc .pfsvc-deck-close:hover{
  background:#111!important;
  color:#fff!important;
}



/* FINAL PATCH: LIST VIEW CARD HEIGHT MUST FOLLOW IMAGE HEIGHT */
.pfsvc .pfsvc-grid.list .pfsvc-card{
  height:180px!important;
  min-height:180px!important;
  max-height:180px!important;
  display:grid!important;
  grid-template-columns:300px minmax(0,1fr)!important;
  align-items:stretch!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-grid.list .pfsvc-img{
  height:180px!important;
  min-height:180px!important;
  max-height:180px!important;
  border-bottom:0!important;
  border-right:1px solid #ececec!important;
}

.pfsvc .pfsvc-grid.list .pfsvc-img img{
  height:180px!important;
}

.pfsvc .pfsvc-grid.list .pfsvc-body{
  height:180px!important;
  min-height:180px!important;
  max-height:180px!important;
  padding:0 18px!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:flex-start!important;
  justify-content:center!important;
}

.pfsvc .pfsvc-grid.list .pfsvc-icon{
  left:14px!important;
  bottom:14px!important;
}

.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  margin:0 0 4px!important;
}

.pfsvc .pfsvc-grid.list .pfsvc-body p{
  margin:0 0 10px!important;
}

@media (max-width:900px){
  .pfsvc .pfsvc-grid.list .pfsvc-card{
    height:auto!important;
    min-height:0!important;
    max-height:none!important;
    grid-template-columns:1fr!important;
  }

  .pfsvc .pfsvc-grid.list .pfsvc-img,
  .pfsvc .pfsvc-grid.list .pfsvc-img img{
    height:180px!important;
    min-height:180px!important;
    max-height:180px!important;
  }

  .pfsvc .pfsvc-grid.list .pfsvc-body{
    height:auto!important;
    min-height:126px!important;
    max-height:none!important;
    padding:20px 16px 14px!important;
  }
}



/* PATCH: compact 5-5-3 option boxes, boxes only */
.pfsvc .pfsvc-grid,
.pfsvc .pfsvc-grid.list{
  display:grid!important;
  grid-template-columns:repeat(5, minmax(0,156px))!important;
  justify-content:start!important;
  gap:14px!important;
}

.pfsvc .pfsvc-grid .pfsvc-card,
.pfsvc .pfsvc-grid.list .pfsvc-card{
  width:156px!important;
  height:245px!important;
  min-height:245px!important;
  max-height:245px!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:stretch!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-grid .pfsvc-img,
.pfsvc .pfsvc-grid.list .pfsvc-img,
.pfsvc .pfsvc-grid .pfsvc-img img,
.pfsvc .pfsvc-grid.list .pfsvc-img img{
  height:96px!important;
  min-height:96px!important;
  max-height:96px!important;
}

.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
  height:auto!important;
  min-height:0!important;
  max-height:none!important;
  padding:20px 10px 10px!important;
  display:flex!important;
  flex:1 1 auto!important;
  flex-direction:column!important;
  justify-content:flex-start!important;
}

@media(max-width:1120px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(3, minmax(0,156px))!important;
  }
}

@media(max-width:720px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(2, minmax(0,156px))!important;
  }
}

@media(max-width:390px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:1fr!important;
  }
  .pfsvc .pfsvc-grid .pfsvc-card,
  .pfsvc .pfsvc-grid.list .pfsvc-card{
    width:min(220px,100%)!important;
  }
}


/* FINAL PATCH: rectangular product review cards like reference image, 5-5-3 layout */
.pfsvc .pfsvc-grid,
.pfsvc .pfsvc-grid.list{
  display:grid!important;
  grid-template-columns:repeat(5, minmax(0, 178px))!important;
  justify-content:start!important;
  align-items:start!important;
  gap:14px!important;
}

.pfsvc .pfsvc-grid .pfsvc-card,
.pfsvc .pfsvc-grid.list .pfsvc-card{
  width:178px!important;
  height:118px!important;
  min-height:118px!important;
  max-height:118px!important;
  display:grid!important;
  grid-template-columns:64px minmax(0,1fr)!important;
  align-items:stretch!important;
  border:1px solid #111!important;
  border-radius:15px!important;
  background:#fff!important;
  overflow:hidden!important;
  box-shadow:0 8px 18px rgba(0,0,0,.08)!important;
}

.pfsvc .pfsvc-grid .pfsvc-card:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card:hover{
  transform:translateY(-3px)!important;
  background:#fff7f1!important;
}

.pfsvc .pfsvc-grid .pfsvc-img,
.pfsvc .pfsvc-grid.list .pfsvc-img{
  width:64px!important;
  height:118px!important;
  min-height:118px!important;
  max-height:118px!important;
  border-bottom:0!important;
  border-right:1px solid #ececec!important;
  border-radius:15px 0 0 15px!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-grid .pfsvc-img img,
.pfsvc .pfsvc-grid.list .pfsvc-img img{
  width:100%!important;
  height:118px!important;
  min-height:118px!important;
  max-height:118px!important;
  object-fit:cover!important;
  object-position:center!important;
}

.pfsvc .pfsvc-grid .pfsvc-icon,
.pfsvc .pfsvc-grid.list .pfsvc-icon{
  left:7px!important;
  bottom:7px!important;
  width:22px!important;
  height:22px!important;
  border-radius:7px!important;
  font-size:10px!important;
}

.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
  width:100%!important;
  height:118px!important;
  min-height:118px!important;
  max-height:118px!important;
  padding:10px 9px 8px!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:flex-start!important;
  justify-content:flex-start!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  min-height:0!important;
  margin:0 0 3px!important;
  color:#111!important;
  font:600 11px/1.15 'Clash Display'!important;
  display:-webkit-box!important;
  -webkit-line-clamp:2!important;
  -webkit-box-orient:vertical!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-grid .pfsvc-body p,
.pfsvc .pfsvc-grid.list .pfsvc-body p{
  min-height:0!important;
  margin:0 0 4px!important;
  color:#333!important;
  font-size:8.6px!important;
  line-height:1.15!important;
  display:-webkit-box!important;
  -webkit-line-clamp:2!important;
  -webkit-box-orient:vertical!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-grid .pfsvc-meta,
.pfsvc .pfsvc-grid.list .pfsvc-meta{
  width:100%!important;
  margin:0 0 6px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  gap:5px!important;
}

.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
  max-width:54px!important;
  min-height:20px!important;
  height:20px!important;
  padding:3px 5px!important;
  border:1px solid #111!important;
  border-radius:8px!important;
  color:#111!important;
  font:600 8px 'Clash Display'!important;
}

.pfsvc .pfsvc-grid .pfsvc-type,
.pfsvc .pfsvc-grid.list .pfsvc-type{
  max-width:44px!important;
  color:#ff7a00!important;
  font:600 7.6px 'Clash Display'!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  width:auto!important;
  min-width:64px!important;
  height:24px!important;
  padding:6px 10px!important;
  margin-top:auto!important;
  align-self:flex-start!important;
  border-radius:8px!important;
  font-size:8.5px!important;
  line-height:1!important;
}

@media(max-width:1120px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(3, minmax(0,178px))!important;
  }
}

@media(max-width:720px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(2, minmax(0,178px))!important;
  }
}

@media(max-width:430px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:1fr!important;
  }

  .pfsvc .pfsvc-grid .pfsvc-card,
  .pfsvc .pfsvc-grid.list .pfsvc-card{
    width:min(100%, 280px)!important;
    grid-template-columns:90px minmax(0,1fr)!important;
  }

  .pfsvc .pfsvc-grid .pfsvc-img,
  .pfsvc .pfsvc-grid.list .pfsvc-img{
    width:90px!important;
  }
}



/* FINAL FIX: pahiga / horizontal service boxes, 4 columns / total 4 lines layout */
.pfsvc .pfsvc-wrap{
  width:min(1280px,calc(100% - 104px))!important;
  margin:0 24px 0 92px!important;
  grid-template-columns:290px minmax(0,1fr)!important;
  gap:42px!important;
}

.pfsvc .pfsvc-grid,
.pfsvc .pfsvc-grid.list{
  display:grid!important;
  grid-template-columns:repeat(4,156px)!important;
  justify-content:start!important;
  align-items:start!important;
  gap:14px!important;
  width:100%!important;
}

.pfsvc .pfsvc-grid .pfsvc-card,
.pfsvc .pfsvc-grid.list .pfsvc-card{
  width:156px!important;
  height:88px!important;
  min-height:88px!important;
  max-height:88px!important;
  display:grid!important;
  grid-template-columns:58px minmax(0,1fr)!important;
  align-items:stretch!important;
  border:1px solid #111!important;
  border-radius:15px!important;
  background:#fff!important;
  overflow:hidden!important;
  cursor:pointer!important;
  box-shadow:0 8px 18px rgba(0,0,0,.08)!important;
}

.pfsvc .pfsvc-grid .pfsvc-card:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card:hover{
  transform:translateY(-3px)!important;
  background:#fff7f1!important;
}

.pfsvc .pfsvc-grid .pfsvc-img,
.pfsvc .pfsvc-grid.list .pfsvc-img{
  position:relative!important;
  width:58px!important;
  height:88px!important;
  min-height:88px!important;
  max-height:88px!important;
  border-bottom:0!important;
  border-right:1px solid #ececec!important;
  border-radius:15px 0 0 15px!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-grid .pfsvc-img img,
.pfsvc .pfsvc-grid.list .pfsvc-img img{
  width:100%!important;
  height:88px!important;
  min-height:88px!important;
  max-height:88px!important;
  object-fit:cover!important;
  object-position:center!important;
  display:block!important;
}

.pfsvc .pfsvc-grid .pfsvc-icon,
.pfsvc .pfsvc-grid.list .pfsvc-icon{
  left:5px!important;
  bottom:5px!important;
  width:20px!important;
  height:20px!important;
  min-width:20px!important;
  min-height:20px!important;
  border-radius:6px!important;
  font-size:9px!important;
  background:#fff4ec!important;
  color:#ff7a00!important;
}

.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
  width:100%!important;
  height:88px!important;
  min-height:88px!important;
  max-height:88px!important;
  padding:7px 7px 6px!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:flex-start!important;
  justify-content:flex-start!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  width:100%!important;
  min-height:0!important;
  margin:0 0 2px!important;
  color:#111!important;
  font:600 10px/1.05 'Clash Display'!important;
  letter-spacing:0!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-grid .pfsvc-body p,
.pfsvc .pfsvc-grid.list .pfsvc-body p{
  width:100%!important;
  min-height:0!important;
  margin:0 0 3px!important;
  color:#333!important;
  font-size:7.6px!important;
  line-height:1.1!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-grid .pfsvc-meta,
.pfsvc .pfsvc-grid.list .pfsvc-meta{
  width:100%!important;
  margin:0 0 2px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  gap:3px!important;
}

.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
  max-width:48px!important;
  height:17px!important;
  min-height:17px!important;
  padding:2px 4px!important;
  border:1px solid #111!important;
  border-radius:7px!important;
  color:#111!important;
  background:#fff!important;
  font:600 6.8px/1 'Clash Display'!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-grid .pfsvc-type,
.pfsvc .pfsvc-grid.list .pfsvc-type{
  max-width:39px!important;
  color:#ff7a00!important;
  font:600 6.7px/1 'Clash Display'!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-grid .pfsvc-service-id,
.pfsvc .pfsvc-grid.list .pfsvc-service-id{
  width:100%!important;
  margin:0 0 3px!important;
  color:#111!important;
  font:600 6.6px/1 'Clash Display'!important;
  letter-spacing:0!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  width:64px!important;
  min-width:64px!important;
  height:17px!important;
  min-height:17px!important;
  padding:0 7px!important;
  margin-top:auto!important;
  align-self:flex-start!important;
  border-radius:7px!important;
  background:#ff7a00!important;
  color:#111!important;
  font:600 7px/1 'Clash Display'!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card button:hover{
  background:#111!important;
  color:#fff!important;
}

@media(max-width:1120px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(3,156px)!important;
  }
}

@media(max-width:720px){
  .pfsvc .pfsvc-wrap{
    width:min(100% - 28px,680px)!important;
    margin:0 auto!important;
    grid-template-columns:1fr!important;
    gap:26px!important;
  }
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(2,156px)!important;
    justify-content:center!important;
  }
}

@media(max-width:390px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:1fr!important;
  }
  .pfsvc .pfsvc-grid .pfsvc-card,
  .pfsvc .pfsvc-grid.list .pfsvc-card{
    width:min(100%,280px)!important;
    height:105px!important;
    min-height:105px!important;
    max-height:105px!important;
    grid-template-columns:90px minmax(0,1fr)!important;
  }
  .pfsvc .pfsvc-grid .pfsvc-img,
  .pfsvc .pfsvc-grid.list .pfsvc-img,
  .pfsvc .pfsvc-grid .pfsvc-img img,
  .pfsvc .pfsvc-grid.list .pfsvc-img img{
    width:90px!important;
    height:105px!important;
    min-height:105px!important;
    max-height:105px!important;
  }
  .pfsvc .pfsvc-grid .pfsvc-body,
  .pfsvc .pfsvc-grid.list .pfsvc-body{
    height:105px!important;
    min-height:105px!important;
    max-height:105px!important;
  }
}


/* LATEST APPLY: Seamless UI sized pahiga rectangle cards */
.pfsvc .pfsvc-wrap{
  width:min(1280px,calc(100% - 104px))!important;
  margin:0 24px 0 92px!important;
  grid-template-columns:290px minmax(0,1fr)!important;
  gap:42px!important;
}

.pfsvc .pfsvc-grid,
.pfsvc .pfsvc-grid.list{
  display:grid!important;
  grid-template-columns:minmax(0,760px)!important;
  justify-content:start!important;
  align-items:start!important;
  gap:18px!important;
  width:100%!important;
}

.pfsvc .pfsvc-grid .pfsvc-card,
.pfsvc .pfsvc-grid.list .pfsvc-card{
  width:760px!important;
  height:202px!important;
  min-height:202px!important;
  max-height:202px!important;
  display:grid!important;
  grid-template-columns:278px minmax(0,1fr)!important;
  align-items:stretch!important;
  border:0!important;
  border-radius:15px!important;
  background:#fff!important;
  overflow:hidden!important;
  cursor:pointer!important;
  box-shadow:0 10px 25px rgba(0,0,0,.10)!important;
}

.pfsvc .pfsvc-grid .pfsvc-card:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card:hover{
  transform:translateY(-3px)!important;
  background:#fff!important;
  box-shadow:0 16px 34px rgba(0,0,0,.14)!important;
}

.pfsvc .pfsvc-grid .pfsvc-img,
.pfsvc .pfsvc-grid.list .pfsvc-img{
  position:relative!important;
  width:278px!important;
  height:202px!important;
  min-height:202px!important;
  max-height:202px!important;
  border:0!important;
  border-radius:15px 0 0 15px!important;
  overflow:hidden!important;
  background:#f7f7f7!important;
}

.pfsvc .pfsvc-grid .pfsvc-img img,
.pfsvc .pfsvc-grid.list .pfsvc-img img{
  width:278px!important;
  height:202px!important;
  min-height:202px!important;
  max-height:202px!important;
  object-fit:cover!important;
  object-position:center!important;
  display:block!important;
}

.pfsvc .pfsvc-grid .pfsvc-icon,
.pfsvc .pfsvc-grid.list .pfsvc-icon{
  left:14px!important;
  bottom:14px!important;
  width:34px!important;
  height:34px!important;
  min-width:34px!important;
  min-height:34px!important;
  border:1px solid #ffd8bd!important;
  border-radius:10px!important;
  background:#fff4ec!important;
  color:#ff7a00!important;
  font-size:14px!important;
}

.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
  width:100%!important;
  height:202px!important;
  min-height:202px!important;
  max-height:202px!important;
  padding:28px 34px 24px 30px!important;
  display:grid!important;
  grid-template-columns:minmax(0,1fr) 150px!important;
  gap:24px!important;
  align-items:start!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-info{
  min-width:0!important;
  height:100%!important;
}

.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  width:100%!important;
  min-height:0!important;
  margin:0 0 8px!important;
  color:#111!important;
  font:600 24px/32px 'Clash Display'!important;
  letter-spacing:.1px!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-author{
  margin:0 0 18px!important;
  color:#111!important;
  font:600 14px/1 'Clash Display'!important;
  letter-spacing:.2px!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-rating{
  display:flex!important;
  align-items:center!important;
  gap:28px!important;
  margin-bottom:20px!important;
}

.pfsvc .pfsvc-stars{
  color:#E77C40!important;
  font:700 20px/1 'Clash Display'!important;
  letter-spacing:5px!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-review{
  color:#111!important;
  font:600 14px/15px 'Clash Display'!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-sales{
  display:flex!important;
  align-items:center!important;
  gap:12px!important;
  color:#111!important;
  font:600 14px/24px 'Clash Display'!important;
}

.pfsvc .pfsvc-desc,
.pfsvc .pfsvc-grid .pfsvc-meta,
.pfsvc .pfsvc-grid.list .pfsvc-meta,
.pfsvc .pfsvc-type{
  display:none!important;
}

.pfsvc .pfsvc-service-id,
.pfsvc .pfsvc-grid.list .pfsvc-service-id{
  display:none!important;
}

.pfsvc .pfsvc-actions{
  height:150px!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:flex-end!important;
  justify-content:space-between!important;
  padding-top:6px!important;
}

.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
  width:100px!important;
  max-width:100px!important;
  height:39px!important;
  min-height:39px!important;
  padding:0!important;
  border:1px solid #111!important;
  border-radius:15px!important;
  background:transparent!important;
  color:#111!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  font:600 14px/1 'Clash Display'!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  width:140px!important;
  min-width:140px!important;
  height:44px!important;
  min-height:44px!important;
  padding:0!important;
  margin:0!important;
  border:0!important;
  border-radius:6px!important;
  background:#111!important;
  color:#fff!important;
  font:600 14px/1 'Clash Display'!important;
  align-self:flex-end!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card button:hover{
  background:#ff7a00!important;
  color:#111!important;
}

@media(max-width:1180px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:minmax(0,100%)!important;
  }

  .pfsvc .pfsvc-grid .pfsvc-card,
  .pfsvc .pfsvc-grid.list .pfsvc-card{
    width:min(100%,760px)!important;
  }
}

@media(max-width:820px){
  .pfsvc .pfsvc-wrap{
    width:min(100% - 28px,680px)!important;
    margin:0 auto!important;
    grid-template-columns:1fr!important;
    gap:26px!important;
  }

  .pfsvc .pfsvc-grid .pfsvc-card,
  .pfsvc .pfsvc-grid.list .pfsvc-card{
    height:auto!important;
    max-height:none!important;
    grid-template-columns:1fr!important;
  }

  .pfsvc .pfsvc-grid .pfsvc-img,
  .pfsvc .pfsvc-grid.list .pfsvc-img,
  .pfsvc .pfsvc-grid .pfsvc-img img,
  .pfsvc .pfsvc-grid.list .pfsvc-img img{
    width:100%!important;
    height:202px!important;
    border-radius:15px 15px 0 0!important;
  }

  .pfsvc .pfsvc-grid .pfsvc-body,
  .pfsvc .pfsvc-grid.list .pfsvc-body{
    height:auto!important;
    max-height:none!important;
    grid-template-columns:1fr!important;
  }

  .pfsvc .pfsvc-actions{
    height:auto!important;
    flex-direction:row!important;
    align-items:center!important;
    justify-content:space-between!important;
    padding-top:18px!important;
  }
}



/* FINAL LATEST: screenshot-style 4 columns / 4 rows compact landscape cards */
.pfsvc .pfsvc-wrap{
  width:min(1320px,calc(100% - 104px))!important;
  margin:0 24px 0 92px!important;
  grid-template-columns:290px minmax(0,1fr)!important;
  gap:42px!important;
}

.pfsvc .pfsvc-main{
  min-width:0!important;
}

.pfsvc .pfsvc-tools{
  margin-bottom:18px!important;
}

.pfsvc .pfsvc-grid,
.pfsvc .pfsvc-grid.list{
  display:grid!important;
  grid-template-columns:repeat(4,260px)!important;
  justify-content:start!important;
  align-items:start!important;
  gap:18px 28px!important;
  width:100%!important;
}

.pfsvc .pfsvc-grid .pfsvc-card,
.pfsvc .pfsvc-grid.list .pfsvc-card{
  width:260px!important;
  height:190px!important;
  min-height:190px!important;
  max-height:190px!important;
  display:flex!important;
  flex-direction:column!important;
  align-items:stretch!important;
  border:0!important;
  border-radius:6px!important;
  background:#fff!important;
  overflow:hidden!important;
  cursor:pointer!important;
  box-shadow:0 7px 16px rgba(0,0,0,.16)!important;
  transform:none!important;
}

.pfsvc .pfsvc-grid .pfsvc-card:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card:hover{
  transform:translateY(-3px)!important;
  background:#fff!important;
  box-shadow:0 12px 24px rgba(0,0,0,.20)!important;
}

.pfsvc .pfsvc-grid .pfsvc-img,
.pfsvc .pfsvc-grid.list .pfsvc-img{
  position:relative!important;
  width:100%!important;
  height:150px!important;
  min-height:150px!important;
  max-height:150px!important;
  border:0!important;
  border-radius:6px 6px 0 0!important;
  overflow:hidden!important;
  background:#f7f7f7!important;
}

.pfsvc .pfsvc-grid .pfsvc-img img,
.pfsvc .pfsvc-grid.list .pfsvc-img img{
  width:100%!important;
  height:82px!important;
  min-height:82px!important;
  max-height:82px!important;
  object-fit:cover!important;
  object-position:center!important;
  display:block!important;
}

.pfsvc .pfsvc-grid .pfsvc-icon,
.pfsvc .pfsvc-grid.list .pfsvc-icon{
  display:none!important;
}

.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
  width:100%!important;
  height:80px!important;
  min-height:80px!important;
  max-height:80px!important;
  padding:7px 10px 8px!important;
  display:grid!important;
  grid-template-columns:1fr auto!important;
  grid-template-rows:auto auto auto!important;
  column-gap:8px!important;
  row-gap:3px!important;
  align-items:center!important;
  overflow:hidden!important;
  background:#fff!important;
}

.pfsvc .pfsvc-info{
  display:contents!important;
}

.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  grid-column:1/2!important;
  grid-row:1!important;
  width:100%!important;
  min-height:0!important;
  margin:0!important;
  color:#111!important;
  font:700 16px/1.1 'Clash Display',Arial,sans-serif!important;
  letter-spacing:0!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-author,
.pfsvc .pfsvc-desc,
.pfsvc .pfsvc-grid .pfsvc-meta,
.pfsvc .pfsvc-grid.list .pfsvc-meta,
.pfsvc .pfsvc-type,
.pfsvc .pfsvc-service-id,
.pfsvc .pfsvc-grid.list .pfsvc-service-id{
  display:none!important;
}

.pfsvc .pfsvc-actions{
  display:contents!important;
}

.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
  grid-column:2/3!important;
  grid-row:1!important;
  width:auto!important;
  max-width:86px!important;
  min-width:76px!important;
  height:23px!important;
  min-height:23px!important;
  padding:0 8px!important;
  border:1px solid #111!important;
  border-radius:999px!important;
  background:#fff!important;
  color:#111!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  font:700 10px/1 'Clash Display',Arial,sans-serif!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-rating{
  grid-column:1/3!important;
  grid-row:2!important;
  display:flex!important;
  align-items:center!important;
  gap:7px!important;
  margin:0!important;
  min-width:0!important;
}

.pfsvc .pfsvc-stars{
  color:#ff5a12!important;
  font:700 13px/1 'Clash Display',Arial,sans-serif!important;
  letter-spacing:4px!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-review{
  color:#111!important;
  font:700 8px/1 'Clash Display',Arial,sans-serif!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-sales{
  grid-column:1/2!important;
  grid-row:3!important;
  display:flex!important;
  align-items:center!important;
  gap:8px!important;
  color:#111!important;
  font:600 11px/1 'Clash Display',Arial,sans-serif!important;
  min-width:0!important;
}

.pfsvc .pfsvc-sales i{
  font-size:11px!important;
  color:#111!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  grid-column:2/3!important;
  grid-row:3!important;
  width:78px!important;
  min-width:78px!important;
  height:23px!important;
  min-height:23px!important;
  padding:0!important;
  margin:0!important;
  border:1px solid #111!important;
  border-radius:6px!important;
  background:#fff!important;
  color:#111!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  font:700 9px/1 'Clash Display',Arial,sans-serif!important;
  box-shadow:none!important;
  align-self:center!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card button:hover{
  background:#111!important;
  color:#fff!important;
}

@media(max-width:1280px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(3,260px)!important;
  }
}

@media(max-width:980px){
  .pfsvc .pfsvc-wrap{
    width:min(100% - 36px,880px)!important;
    margin:0 auto!important;
    grid-template-columns:1fr!important;
    gap:28px!important;
  }
  .pfsvc .pfsvc-side{
    position:static!important;
  }
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(2,260px)!important;
    justify-content:center!important;
  }
}

@media(max-width:620px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:1fr!important;
    justify-content:center!important;
  }
  .pfsvc .pfsvc-grid .pfsvc-card,
  .pfsvc .pfsvc-grid.list .pfsvc-card{
    width:min(100%,320px)!important;
  }
}



/* FINAL CLEAN FIX: 4-column cards, no Inquiry clutter */
.pfsvc .pfsvc-grid,
.pfsvc .pfsvc-grid.list{
  grid-template-columns:repeat(4,260px)!important;
  gap:18px 28px!important;
}

.pfsvc .pfsvc-grid .pfsvc-card,
.pfsvc .pfsvc-grid.list .pfsvc-card{
  width:260px!important;
  height:162px!important;
  min-height:162px!important;
  max-height:162px!important;
  display:flex!important;
  flex-direction:column!important;
  border:0!important;
  border-radius:6px!important;
  background:#fff!important;
  overflow:hidden!important;
  box-shadow:0 7px 16px rgba(0,0,0,.16)!important;
}

.pfsvc .pfsvc-grid .pfsvc-img,
.pfsvc .pfsvc-grid.list .pfsvc-img,
.pfsvc .pfsvc-grid .pfsvc-img img,
.pfsvc .pfsvc-grid.list .pfsvc-img img{
  width:100%!important;
  height:82px!important;
  min-height:82px!important;
  max-height:82px!important;
  border-radius:6px 6px 0 0!important;
  object-fit:cover!important;
}

.pfsvc .pfsvc-grid .pfsvc-icon,
.pfsvc .pfsvc-grid.list .pfsvc-icon,
.pfsvc .pfsvc-author,
.pfsvc .pfsvc-desc,
.pfsvc .pfsvc-service-id,
.pfsvc .pfsvc-type,
.pfsvc .pfsvc-meta{
  display:none!important;
}

.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
  height:80px!important;
  min-height:80px!important;
  max-height:80px!important;
  padding:7px 10px 8px!important;
  display:grid!important;
  grid-template-columns:1fr auto!important;
  grid-template-rows:auto auto auto!important;
  column-gap:8px!important;
  row-gap:3px!important;
  align-items:center!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-info,
.pfsvc .pfsvc-actions{
  display:contents!important;
}

.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  grid-column:1/2!important;
  grid-row:1!important;
  margin:0!important;
  font:700 16px/1.1 'Clash Display',Arial,sans-serif!important;
  color:#111!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
  grid-column:2/3!important;
  grid-row:1!important;
  width:auto!important;
  min-width:76px!important;
  max-width:86px!important;
  height:23px!important;
  border:1px solid #111!important;
  border-radius:999px!important;
  background:#fff!important;
  color:#111!important;
  padding:0 8px!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  font:700 10px/1 'Clash Display',Arial,sans-serif!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-rating{
  grid-column:1/3!important;
  grid-row:2!important;
  display:flex!important;
  align-items:center!important;
  gap:7px!important;
  margin:0!important;
}

.pfsvc .pfsvc-stars{
  color:#ff5a12!important;
  font:700 13px/1 'Clash Display',Arial,sans-serif!important;
  letter-spacing:4px!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-review{
  color:#111!important;
  font:700 8px/1 'Clash Display',Arial,sans-serif!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-sales{
  grid-column:1/2!important;
  grid-row:3!important;
  display:flex!important;
  align-items:center!important;
  gap:8px!important;
  color:#111!important;
  font:600 11px/1 'Clash Display',Arial,sans-serif!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  grid-column:2/3!important;
  grid-row:3!important;
  width:78px!important;
  min-width:78px!important;
  height:23px!important;
  border:1px solid #111!important;
  border-radius:6px!important;
  background:#fff!important;
  color:#111!important;
  padding:0!important;
  margin:0!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  font:700 9px/1 'Clash Display',Arial,sans-serif!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card button:hover{
  background:#111!important;
  color:#fff!important;
}

@media(max-width:1280px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{grid-template-columns:repeat(3,260px)!important;}
}
@media(max-width:980px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{grid-template-columns:repeat(2,260px)!important;justify-content:center!important;}
}
@media(max-width:620px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{grid-template-columns:1fr!important;justify-content:center!important;}
  .pfsvc .pfsvc-grid .pfsvc-card,
  .pfsvc .pfsvc-grid.list .pfsvc-card{width:min(100%,320px)!important;}
}


/* FINAL APPLY: same laman at pagkakasunod-sunod ng screenshot */
.pfsvc .pfsvc-wrap{
  width:min(1320px,calc(100% - 104px))!important;
  margin:0 24px 0 92px!important;
  grid-template-columns:290px minmax(0,1fr)!important;
  gap:42px!important;
}

.pfsvc .pfsvc-grid,
.pfsvc .pfsvc-grid.list{
  display:grid!important;
  grid-template-columns:repeat(4,260px)!important;
  justify-content:start!important;
  align-items:start!important;
  gap:18px 28px!important;
  width:100%!important;
}

.pfsvc .pfsvc-grid .pfsvc-card,
.pfsvc .pfsvc-grid.list .pfsvc-card{
  width:260px!important;
  height:162px!important;
  min-height:162px!important;
  max-height:162px!important;
  display:flex!important;
  flex-direction:column!important;
  border:0!important;
  border-radius:6px!important;
  background:#fff!important;
  overflow:hidden!important;
  box-shadow:0 7px 16px rgba(0,0,0,.16)!important;
}

.pfsvc .pfsvc-grid .pfsvc-img,
.pfsvc .pfsvc-grid.list .pfsvc-img{
  width:100%!important;
  height:82px!important;
  min-height:82px!important;
  max-height:82px!important;
  border:0!important;
  border-radius:6px 6px 0 0!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-grid .pfsvc-img img,
.pfsvc .pfsvc-grid.list .pfsvc-img img{
  width:100%!important;
  height:82px!important;
  min-height:82px!important;
  max-height:82px!important;
  object-fit:cover!important;
  object-position:center!important;
}

.pfsvc .pfsvc-grid .pfsvc-icon,
.pfsvc .pfsvc-grid.list .pfsvc-icon,
.pfsvc .pfsvc-author,
.pfsvc .pfsvc-desc,
.pfsvc .pfsvc-service-id,
.pfsvc .pfsvc-type,
.pfsvc .pfsvc-meta{display:none!important;}

.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
  height:80px!important;
  min-height:80px!important;
  max-height:80px!important;
  padding:7px 10px 8px!important;
  display:grid!important;
  grid-template-columns:1fr auto!important;
  grid-template-rows:auto auto auto!important;
  column-gap:8px!important;
  row-gap:3px!important;
  align-items:center!important;
  background:#fff!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-info,
.pfsvc .pfsvc-actions{display:contents!important;}

.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  grid-column:1/2!important;
  grid-row:1!important;
  margin:0!important;
  color:#111!important;
  font:700 16px/1.1 'Clash Display',Arial,sans-serif!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
  grid-column:2/3!important;
  grid-row:1!important;
  width:auto!important;
  min-width:76px!important;
  max-width:86px!important;
  height:23px!important;
  border:1px solid #111!important;
  border-radius:999px!important;
  background:#fff!important;
  color:#111!important;
  padding:0 8px!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  font:700 10px/1 'Clash Display',Arial,sans-serif!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

.pfsvc .pfsvc-rating{
  grid-column:1/3!important;
  grid-row:2!important;
  display:flex!important;
  align-items:center!important;
  gap:7px!important;
  margin:0!important;
}

.pfsvc .pfsvc-stars{
  color:#ff5a12!important;
  font:700 13px/1 'Clash Display',Arial,sans-serif!important;
  letter-spacing:4px!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-review{
  color:#111!important;
  font:700 8px/1 'Clash Display',Arial,sans-serif!important;
  white-space:nowrap!important;
}

.pfsvc .pfsvc-sales{
  grid-column:1/2!important;
  grid-row:3!important;
  display:flex!important;
  align-items:center!important;
  gap:8px!important;
  color:#111!important;
  font:600 11px/1 'Clash Display',Arial,sans-serif!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  grid-column:2/3!important;
  grid-row:3!important;
  width:78px!important;
  min-width:78px!important;
  height:23px!important;
  border:1px solid #111!important;
  border-radius:6px!important;
  background:#fff!important;
  color:#111!important;
  padding:0!important;
  margin:0!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  font:700 9px/1 'Clash Display',Arial,sans-serif!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card button:hover{
  background:#111!important;
  color:#fff!important;
}

@media(max-width:1280px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{grid-template-columns:repeat(3,260px)!important;}
}
@media(max-width:980px){
  .pfsvc .pfsvc-wrap{width:min(100% - 36px,880px)!important;margin:0 auto!important;grid-template-columns:1fr!important;gap:28px!important;}
  .pfsvc .pfsvc-side{position:static!important;}
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{grid-template-columns:repeat(2,260px)!important;justify-content:center!important;}
}
@media(max-width:620px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{grid-template-columns:1fr!important;justify-content:center!important;}
  .pfsvc .pfsvc-grid .pfsvc-card,
  .pfsvc .pfsvc-grid.list .pfsvc-card{width:min(100%,320px)!important;}
}



/* FINAL FIX: exact UI price plain text only - no background shape */
.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
  width:auto!important;
  min-width:0!important;
  max-width:110px!important;
  height:auto!important;
  min-height:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  box-shadow:none!important;
  outline:none!important;
  padding:0!important;
  color:#111!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:flex-end!important;
  font:700 10px/1.1 'Clash Display',Arial,sans-serif!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}


/* FINAL PATCH: View Full button same color and shape as orange gradient ON button */
.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(90deg,var(--ui-orange-start,#FE7B09),var(--ui-orange-end,#FFAB0A))!important;
  color:#111827!important;
  box-shadow:none!important;
  text-transform:none!important;
  transform:none!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button:hover,
.pfsvc .pfsvc-grid .pfsvc-card button:focus,
.pfsvc .pfsvc-grid.list .pfsvc-card button:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card button:focus{
  background:var(--ui-black,#111827)!important;
  color:#ffffff!important;
  border:0!important;
  box-shadow:none!important;
  outline:0!important;
}

/* FINAL OVERRIDE: ADJUST CARD SIZE HERE */
.pfsvc .pfsvc-grid,
.pfsvc .pfsvc-grid.list{
  grid-template-columns:repeat(4,280px)!important;
  gap:24px 30px!important;
}

.pfsvc .pfsvc-grid .pfsvc-card,
.pfsvc .pfsvc-grid.list .pfsvc-card{
  width:280px!important;
  height:225px!important;
  min-height:225px!important;
  max-height:225px!important;
}

.pfsvc .pfsvc-grid .pfsvc-img,
.pfsvc .pfsvc-grid.list .pfsvc-img{
  height:135px!important;
  min-height:135px!important;
  max-height:135px!important;
}

.pfsvc .pfsvc-grid .pfsvc-img img,
.pfsvc .pfsvc-grid.list .pfsvc-img img{
  width:100%!important;
  height:135px!important;
  min-height:135px!important;
  max-height:135px!important;
  object-fit:cover!important;
  object-position:center!important;
  background:#f7f7f7!important;
}

.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
  height:95px!important;
  min-height:95px!important;
  max-height:95px!important;
}


/* FINAL FONT SYSTEM: only 3 local font files used in this section
   PRINTIFY & CO. only = Boxing-Regular.otf
   Headers / Card Titles / Subtitles = ClashDisplay-Semibold.otf
   Body / descriptions / buttons = Inter.ttc semibold */
.pfsvc,
.pfsvc p,
.pfsvc span,
.pfsvc label,
.pfsvc select,
.pfsvc input,
.pfsvc strong,
.pfsvc small,
.pfsvc option,
.pfsvc .pfsvc-desc,
.pfsvc .pfsvc-author,
.pfsvc .pfsvc-rating,
.pfsvc .pfsvc-stars,
.pfsvc .pfsvc-review,
.pfsvc .pfsvc-sales,
.pfsvc .pfsvc-price,
.pfsvc .pfsvc-type,
.pfsvc .pfsvc-service-id,
.pfsvc .pfsvc-feedback,
.pfsvc .pfsvc-price-row,
.pfsvc .pfsvc-label,
.pfsvc .pfsvc-switch,
.pfsvc .pfsvc-sort,
.pfsvc button,
.pfsvc .pfsvc-btn,
.pfsvc .pfsvc-card button,
.pfsvc .pfsvc-deck-actions button{
  font-family:'InterFinal',system-ui,sans-serif!important;
}

.pfsvc h1,
.pfsvc h2,
.pfsvc h3,
.pfsvc h4,
.pfsvc h5,
.pfsvc h6,
.pfsvc .pfsvc-side h3,
.pfsvc .pfsvc-head span,
.pfsvc .pfsvc-head h2,
.pfsvc .pfsvc-body h3,
.pfsvc .pfsvc-empty h3,
.pfsvc .pfsvc-callout h3,
.pfsvc .pfsvc-deck-title span,
.pfsvc .pfsvc-deck-title h3,
.pfsvc .pfsvc-deck-title p,
.pfsvc .pfsvc-nav,
.pfsvc .pfsvc-nav span{
  font-family:'Clash Display',system-ui,sans-serif!important;
}

.brand-main-text,
.printify-brand,
.printify-logo{
  font-family:'Boxing',serif!important;
}

</style>

<script>
const pfsvcServices=[
  {
    key:"doc",
    title:"Document Printing",
    desc:"High-quality black and white or color document printing for any need.",
    icon:"fa-solid fa-print",
    img:"{{ asset('images/Document PS.png') }}",
    time:"same-day",
    price:80,
    express:true,
    order:1,
    options:[
      {slug:"text-only",name:"Text Only",desc:"Plain black and white document output.",price:"from <b>₱1.00/page</b>",icon:"fa-solid fa-file-lines",serviceId:"DOC-TX-001"},
      {slug:"text-graphics",name:"Text + Image",desc:"Documents with images, charts, and simple graphics.",price:"from <b>₱2.00/page</b>",icon:"fa-solid fa-chart-simple",serviceId:"DOC-TWI-004"},
      {slug:"full-color",name:"Full Color",desc:"Colored document printing for reports and handouts.",price:"from <b>₱5.00/page</b>",icon:"fa-solid fa-palette",serviceId:"DOC-TX-003"}
    ]
  },
  {
    key:"photo",
    title:"Photocopy & Scanning",
    desc:"Clear photocopies and high-resolution scanning services.",
    icon:"fa-solid fa-copy",
    img:"{{ asset('images/Photocopy & ScanningS.png') }}",
    time:"same-day",
    price:120,
    express:true,
    order:2,
    options:[
      {slug:"photocopy",name:"Photocopy",desc:"Fast and clean document copies.",price:"from <b>₱2.00/page</b>",icon:"fa-solid fa-copy",serviceId:"DOC-PCPY-001"},
      {slug:"scanning",name:"Scanning",desc:"Digital scans for documents and records.",price:"from <b>₱5.00/page</b>",icon:"fa-solid fa-magnifying-glass",serviceId:"DOC-SCN-001"}
    ]
  },
  {
    key:"id",
    title:"ID & Photo Services",
    desc:"Professional ID pictures and photo printing services.",
    icon:"fa-solid fa-id-card",
    img:"{{ asset('images/Photo IDS.png') }}",
    time:"same-day",
    price:180,
    express:true,
    order:3,
    options:[
      {slug:"visa-photo",name:"Visa Photo",desc:"Visa and passport photo preparation.",price:"from <b>₱150.00</b>",icon:"fa-solid fa-passport",image:"{{ asset('images/Photo ID (cover).png') }}",serviceId:"IDP-PKG-004"},
      {slug:"id-photo",name:"ID Photo",desc:"ID photo print package.",price:"from <b>₱100.00</b>",icon:"fa-solid fa-id-card",image:"{{ asset('images/Photo ID (cover).png') }}",serviceId:"IDP-PKG-001"},
      {slug:"2x2-photo",name:"2x2 Photo",desc:"2x2 print photo package.",price:"from <b>₱100.00</b>",icon:"fa-solid fa-image",image:"{{ asset('images/Photo ID (cover).png') }}",serviceId:"IDP-SP-003"}
    ]
  },
  {
    key:"bind",
    title:"Lamination & Binding",
    desc:"Durable lamination and clean document binding solutions.",
    icon:"fa-solid fa-book-open",
    img:"{{ asset('images/Lamination & BindingS.png') }}",
    time:"next-day",
    price:500,
    express:false,
    order:4,
    options:[
      {slug:"lamination",name:"Lamination",desc:"Protective film for certificates and documents.",price:"from <b>₱20.00/page</b>",icon:"fa-solid fa-layer-group",serviceId:"LAM-001"},
      {slug:"spiral-binding",name:"Spiral Binding",desc:"Bound reports, manuals, and booklets.",price:"from <b>₱30.00/book</b>",icon:"fa-solid fa-book-open",serviceId:"BND-SPR-001"}
    ]
  },
  {
    key:"largeformat",
    title:"Large Format Printing",
    desc:"Banners, posters, tarpaulins, and oversized print output.",
    icon:"fa-solid fa-image",
    img:"{{ asset('images/Large FormatPS.png') }}",
    time:"next-day",
    price:2500,
    express:false,
    order:5,
    options:[
      {slug:"sintra-board",name:"Sintra Board",desc:"Rigid signage and presentation board output.",price:"from <b>₱150.00/sqft</b>",icon:"fa-solid fa-border-all",serviceId:"LF-SIN-001"},
      {slug:"tarpaulin",name:"Tarpaulin",desc:"Large outdoor and indoor tarpaulin printing.",price:"from <b>₱80.00/sqft</b>",icon:"fa-solid fa-panorama",serviceId:"LFP-TARP-001"}
    ]
  },
  {
    key:"special",
    title:"Custom Special Printing",
    desc:"Personalized printing for custom designs and special projects.",
    icon:"fa-solid fa-star",
    img:"{{ asset('images/Custom Special PS.png') }}",
    time:"custom",
    price:20000,
    express:false,
    order:6,
    options:[
      {slug:"poster-printing",name:"Poster Printing",desc:"Poster printing for events and promotions.",price:"from <b>₱10.00/page</b>",icon:"fa-solid fa-image",serviceId:"LFP-POST-001"}
    ]
  }
];

let pfsvcState={
  category:"all",
  view:"grid",
  activeKey:"doc",
  activeIndex:0,
  selected:null
};

function pfsvcToast(message){
  if(typeof window.showFrontFeedback==="function"){
    window.showFrontFeedback(message);
    return;
  }

  window.dispatchEvent(new CustomEvent("printify-front-feedback",{detail:{message}}));
}

function pfsvcSafe(text){
  return String(text||"").replace(/[&<>"']/g,ch=>({
    "&":"&amp;",
    "<":"&lt;",
    ">":"&gt;",
    "\"":"&quot;",
    "'":"&#039;"
  }[ch]));
}

function pfsvcServiceByKey(key){
  return pfsvcServices.find(item=>item.key===key)||pfsvcServices[0];
}

function pfsvcAllOptionCards(){
  const displayOrder={
    "text-only":1,
    "text-graphics":2,
    "full-color":3,
    "photocopy":4,
    "scanning":5,
    "visa-photo":6,
    "id-photo":7,
    "2x2-photo":8,
    "lamination":9,
    "spiral-binding":10,
    "sintra-board":11,
    "tarpaulin":12,
    "poster-printing":13
  };

  return pfsvcServices.flatMap(service=>
    service.options.map((option,index)=>({
      service,
      option,
      index,
      key:service.key,
      title:option.name,
      desc:option.desc,
      icon:option.icon||service.icon,
      img:option.image||service.img,
      time:service.time,
      price:service.price,
      express:service.express,
      order:displayOrder[option.slug] || ((service.order*100)+index)
    }))
  ).sort((a,b)=>a.order-b.order);
}


function pfsvcShortNote(text){
  const clean=String(text||"").replace(/<[^>]+>/g,"").trim();
  if(!clean)return "";
  return clean.length>48 ? clean.slice(0,45).trim()+"..." : clean;
}

function pfsvcShortPrice(price){
  const text=String(price||"").replace(/<[^>]+>/g,"").trim();
  if(!text || /inquiry/i.test(text)) return "View price";
  return text.replace(/^from\s+/i,"").trim();
}

function pfsvcOpenOption(serviceKey,index){
  if(typeof window.requireSignedInForOrder==="function"&&!window.requireSignedInForOrder())return false;
  pfsvcState.activeKey=serviceKey;
  pfsvcState.activeIndex=Number(index)||0;
  return pfsvcProceedSelected();
}

function pfsvcRenderCards(){
  const grid=document.getElementById("pfsvcGrid");
  const empty=document.getElementById("pfsvcEmpty");

  if(!grid)return;

  const time=document.getElementById("pfsvcTime")?.value||"all";
  const max=Number(document.getElementById("pfsvcPrice")?.value||20000);
  const showExpress=document.getElementById("pfsvcExpress")?.checked;

  let list=pfsvcAllOptionCards().filter(item=>
    (pfsvcState.category==="all"||item.key===pfsvcState.category)&&
    (time==="all"||item.time===time)&&
    item.price<=max&&
    (showExpress||!item.express)
  );

  const sort=document.getElementById("pfsvcSort")?.value||"popular";

  list.sort((a,b)=>
    sort==="name"
      ? a.title.localeCompare(b.title)
      : sort==="price"
        ? a.price-b.price
        : a.order-b.order
  );

  grid.classList.toggle("list",pfsvcState.view==="list");

  grid.innerHTML=list.map(item=>`
    <article class="pfsvc-card" data-key="${item.key}" onclick="pfsvcOpenOption('${item.key}',${item.index})">
      <div class="pfsvc-img ${item.img ? "" : "no-image"}">
        ${item.img ? `<img src="${item.img}" alt="${pfsvcSafe(item.title)}" loading="eager" decoding="sync" fetchpriority="high" onerror="this.closest('.pfsvc-img')?.classList.add('no-image');this.remove();">` : ""}
        <span class="pfsvc-icon"><i class="${item.icon}"></i></span>
      </div>

      <div class="pfsvc-body">
        <div class="pfsvc-info">
          <h3>${pfsvcSafe(item.title)}</h3>
          <p class="pfsvc-card-subtitle">${pfsvcSafe(pfsvcShortNote(item.desc || item.option.desc))}</p>
        </div>

        <div class="pfsvc-actions">
          <span class="pfsvc-price">${pfsvcShortPrice(item.option.price)}</span>
          <button type="button" onclick="event.stopPropagation();pfsvcOpenOption('${item.key}',${item.index})">VIEW FULL</button>
        </div>
      </div>
    </article>
  `).join("");

  empty.style.display=list.length?"none":"block";
}

function pfsvcSetCategory(category){
  pfsvcState.category=category||"all";

  document.querySelectorAll(".pfsvc-nav").forEach(btn=>{
    btn.classList.toggle("active",btn.dataset.filter===pfsvcState.category);
  });

  document.querySelector(".pfsvc-all")?.classList.toggle("active",pfsvcState.category==="all");

  pfsvcRenderCards();

  pfsvcToast(
    pfsvcState.category==="all"
      ? "All services shown."
      : `${pfsvcServiceByKey(category).title} selected.`
  );
}

function pfsvcBuildDeck(){
  const service=pfsvcServiceByKey(pfsvcState.activeKey);
  const stage=document.getElementById("pfsvcStage");

  stage.innerHTML=service.options.map((o,i)=>{
    const image=o.image||service.img;
    const img=image
      ? `<img src="${image}" alt="${pfsvcSafe(o.name)}" loading="eager" decoding="sync">`
      : `<i class="${o.icon||service.icon}"></i>`;

    return `
      <article class="pfsvc-option hidden" data-option-index="${i}" onclick="pfsvcChooseOption(${i})" aria-label="${pfsvcSafe(o.name)}">
        <div class="pfsvc-option-img">${img}</div>
      </article>
    `;
  }).join("");
}

function pfsvcOpenDeck(key){
  const service=pfsvcServiceByKey(key);

  pfsvcState.activeKey=service.key;
  pfsvcState.activeIndex=0;

  document.getElementById("pfsvcDeckKicker").innerHTML=`<i class="${service.icon}"></i> ${pfsvcSafe(service.title)}`;
  document.getElementById("pfsvcDeckHeading").textContent="Choose Service Option";
  document.getElementById("pfsvcDeck").classList.add("active");
  document.getElementById("pfsvcDeck").setAttribute("aria-hidden","false");

  document.body.style.overflow="hidden";

  pfsvcBuildDeck();
  requestAnimationFrame(pfsvcRenderDeck);
}

function pfsvcRenderDeck(){
  const service=pfsvcServiceByKey(pfsvcState.activeKey);
  const stage=document.getElementById("pfsvcStage");
  const dots=document.getElementById("pfsvcDots");

  let cards=Array.from(stage.querySelectorAll(".pfsvc-option"));

  if(cards.length!==service.options.length){
    pfsvcBuildDeck();
    cards=Array.from(stage.querySelectorAll(".pfsvc-option"));
  }

  cards.forEach((card,i)=>{
    const pos=(i-pfsvcState.activeIndex+service.options.length)%service.options.length;
    const cls=pos===0?"active":pos===1?"right":pos===service.options.length-1?"left":"hidden";

    const twoCards=service.options.length===2;
    let transform="translate(-50%,-50%) translateX(0) translateY(-2px) rotate(0deg) scale(1.04)";
    let opacity="1";

    if(twoCards && cls==="active"){
      transform="translate(-50%,-50%) translateX(-70px) translateY(0) rotate(0deg) scale(1)";
    }

    if(cls==="left"){
      transform=`translate(-50%,-50%) translateX(${twoCards?-96:-118}px) translateY(16px) rotate(-6deg) scale(.9)`;
      opacity="1";
    }

    if(cls==="right"){
      transform=`translate(-50%,-50%) translateX(${twoCards?110:118}px) translateY(${twoCards?0:16}px) rotate(${twoCards?0:6}deg) scale(${twoCards?.94:.9})`;
      opacity="1";
    }

    if(cls==="hidden"){
      transform="translate(-50%,-50%) translateY(22px) scale(.72)";
      opacity="0";
    }

    card.className=`pfsvc-option ${cls}`;
    card.style.transform=transform;
    card.style.opacity=opacity;
  });

  dots.innerHTML=service.options.map((_,i)=>`
    <button type="button" class="${i===pfsvcState.activeIndex?'active':''}" onclick="pfsvcPickOption(${i})" aria-label="Choose option ${i+1}"></button>
  `).join("");

  document.getElementById("pfsvcContinue").innerHTML=`Continue with ${pfsvcSafe(service.options[pfsvcState.activeIndex].name)} <i class="fa-solid fa-arrow-right"></i>`;
}

function pfsvcMoveDeck(step){
  const service=pfsvcServiceByKey(pfsvcState.activeKey);
  pfsvcState.activeIndex=(pfsvcState.activeIndex+step+service.options.length)%service.options.length;
  pfsvcRenderDeck();
}

function pfsvcPickOption(index){
  pfsvcState.activeIndex=index;
  pfsvcRenderDeck();
}

function pfsvcChooseOption(index){
  if(typeof window.requireSignedInForOrder==="function"&&!window.requireSignedInForOrder())return false;
  pfsvcState.activeIndex=index;
  pfsvcRenderDeck();
  setTimeout(pfsvcProceedSelected,180);
  return true;
}

function pfsvcCloseDeck(){
  document.getElementById("pfsvcDeck").classList.remove("active");
  document.getElementById("pfsvcDeck").setAttribute("aria-hidden","true");
  document.body.style.overflow="";
}

function pfsvcDetailSlug(slug){
  return ({
    "text-graphics":"text-image",
    "full-color":"image-only",
    "visa-photo":"passport-visa",
    "2x2-photo":"single-photo-print",
    "tarpaulin":"sintra-board"
  }[slug]||slug);
}

function pfsvcPayload(){
  const service=pfsvcServiceByKey(pfsvcState.activeKey);
  const option=service.options[pfsvcState.activeIndex];
  const detailSlug=pfsvcDetailSlug(option.slug);

  return {
    categoryKey:service.key,
    categoryTitle:service.title,
    categorySlug:service.key,
    serviceName:option.name,
    serviceSlug:detailSlug,
    optionSlug:option.slug,
    detailSlug,
    serviceDescription:option.desc,
    serviceIcon:option.icon||service.icon,
    serviceImage:option.image||service.img,
    serviceId:option.serviceId,
    servicePriceText:String(option.price).replace(/<[^>]+>/g,"")
  };
}

function pfsvcProceedSelected(){
  if(typeof window.requireSignedInForOrder==="function"&&!window.requireSignedInForOrder())return false;
  const payload=pfsvcPayload();

  pfsvcState.selected=payload;
  sessionStorage.setItem("selectedPrintifyService",JSON.stringify(payload));

  document.getElementById("pfsvcDetail").hidden=false;
  document.getElementById("pfsvcDetailIcon").innerHTML=`<i class="${payload.serviceIcon}"></i>`;
  document.getElementById("pfsvcDetailTitle").textContent=`${payload.categoryTitle} - ${payload.serviceName}`;
  document.getElementById("pfsvcDetailDesc").textContent=payload.serviceDescription;

  pfsvcCloseDeck();

  if(typeof window.openPrintifyServiceDetail==="function"){
    window.openPrintifyServiceDetail(payload,true);
    pfsvcToast(`${payload.serviceName} details opened.`);
    return;
  }

  const target=document.getElementById("serviceDetail")||document.getElementById("pfsvcDetail");

  target?.classList?.add("pdv-is-open","active","show");
  pfsvcToast(`${payload.serviceName} selected.`);

  setTimeout(()=>target?.scrollIntoView({behavior:"smooth",block:"start"}),120);
  return true;
}

document.querySelectorAll(".pfsvc-nav").forEach(btn=>{
  btn.addEventListener("click",()=>pfsvcSetCategory(btn.dataset.filter));
});

document.querySelectorAll(".pfsvc-view").forEach(btn=>{
  btn.addEventListener("click",()=>{
    pfsvcState.view=btn.dataset.view;

    document.querySelectorAll(".pfsvc-view").forEach(item=>{
      item.classList.toggle("active",item===btn);
    });

    pfsvcRenderCards();
    pfsvcToast(`${pfsvcState.view==="grid"?"Grid":"List"} view applied.`);
  });
});

["pfsvcSort","pfsvcTime","pfsvcExpress"].forEach(id=>{
  document.getElementById(id)?.addEventListener("change",pfsvcRenderCards);
});

document.getElementById("pfsvcPrice")?.addEventListener("input",e=>{
  document.getElementById("pfsvcPriceValue").textContent=
    Number(e.target.value)>=20000
      ? "₱20,000+"
      : `₱${Number(e.target.value).toLocaleString()}`;

  pfsvcRenderCards();
});

window.addEventListener("keydown",e=>{
  if(!document.getElementById("pfsvcDeck").classList.contains("active"))return;

  if(e.key==="Escape")pfsvcCloseDeck();
  if(e.key==="ArrowLeft")pfsvcMoveDeck(-1);
  if(e.key==="ArrowRight")pfsvcMoveDeck(1);
  if(e.key==="Enter")pfsvcProceedSelected();
});

window.addEventListener("click",e=>{
  if(e.target.id==="pfsvcDeck")pfsvcCloseDeck();
});

pfsvcRenderCards();
</script>


<style>
/* PATCH: Improved readability inside service cards */
.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
    font-family:'Clash Display', sans-serif !important;
    font-size:20px !important;
    font-weight:600 !important;
    line-height:1.15 !important;
    letter-spacing:0.2px !important;
    color:#111 !important;
}

.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
    font-family:'InterFinal', sans-serif !important;
    font-size:13px !important;
    font-weight:400 !important;
    line-height:1.2 !important;
    color:#111 !important;
}

.pfsvc .pfsvc-review,
.pfsvc .pfsvc-sales{
    font-family:'InterFinal', sans-serif !important;
    font-size:12px !important;
    font-weight:400 !important;
    line-height:1.25 !important;
    color:#111 !important;
}

.pfsvc .pfsvc-stars{
    font-size:14px !important;
    letter-spacing:2px !important;
}

.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
    font-family:'InterFinal', sans-serif !important;
    font-size:11px !important;
    font-weight:400 !important;
    line-height:1 !important;
}

.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
    padding:10px 12px 10px !important;
}
</style>


<style>
/* FINAL FONT CONSISTENCY PATCH
   Only 3 font styles:
   1. PRINTIFY & CO. only = Boxing
   2. Headers / Subtitles / Card Titles = Clash Display
   3. Body / Descriptions / Buttons = InterFinal
*/

/* Main section body font */
.pfsvc,
.pfsvc p,
.pfsvc span,
.pfsvc label,
.pfsvc select,
.pfsvc input,
.pfsvc strong{
  font-family:'InterFinal'!important;
}

/* Headers, subtitles, card titles */
.pfsvc-side h3,
.pfsvc-filterbox h3,
.pfsvc-head span,
.pfsvc-head h2,
.pfsvc-empty h3,
.pfsvc-callout h3,
.pfsvc-detail h3,
.pfsvc-detail span,
.pfsvc-deck-title span,
.pfsvc-deck-title h3,
.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  font-family:'Clash Display'!important;
  font-weight:600!important;
  letter-spacing:0!important;
}

/* Body/descriptions */
.pfsvc-head p,
.pfsvc-empty p,
.pfsvc-callout p,
.pfsvc-detail p,
.pfsvc-deck-title p,
.pfsvc .pfsvc-grid .pfsvc-body p,
.pfsvc .pfsvc-price,
.pfsvc .pfsvc-review,
.pfsvc .pfsvc-sales,
.pfsvc .pfsvc-price-row,
.pfsvc .pfsvc-label,
.pfsvc .pfsvc-sort,
.pfsvc .pfsvc-sort select,
.pfsvc .pfsvc-filterbox select,
.pfsvc .pfsvc-switch span{
  font-family:'InterFinal'!important;
  font-weight:400!important;
  letter-spacing:0!important;
}

/* Outside / regular buttons: same font style, same size, same letter spacing */
.pfsvc .pfsvc-btn,
.pfsvc .pfsvc-tools .pfsvc-all,
.pfsvc .pfsvc-callout a.pfsvc-btn,
.pfsvc .pfsvc-detail button.pfsvc-btn,
.pfsvc #pfsvcContinue{
  min-width:104px!important;
  height:34px!important;
  padding:8px 16px!important;
  font-family:'InterFinal'!important;
  font-size:11px!important;
  font-weight:400!important;
  line-height:1!important;
  letter-spacing:0!important;
  text-transform:none!important;
  white-space:nowrap!important;
}

/* Sidebar nav buttons: same font family, keep sidebar size/layout */
.pfsvc .pfsvc-nav,
.pfsvc .pfsvc-nav span{
  font-family:'Clash Display'!important;
  font-size:13px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:0!important;
  text-transform:none!important;
}

/* Small buttons only: allowed to stay smaller but same font style/spacing */
.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button,
.pfsvc .pfsvc-switch b{
  font-family:'InterFinal'!important;
  font-weight:400!important;
  letter-spacing:0!important;
  text-transform:none!important;
  white-space:nowrap!important;
}

/* Small View Full buttons inside cards */
.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  font-size:9.5px!important;
  line-height:1!important;
}

/* ON switch button is small, keep small */
.pfsvc .pfsvc-switch b{
  font-size:10px!important;
  line-height:1!important;
}

/* Card text readability, not too large */
.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  font-size:17px!important;
  line-height:1.08!important;
}

.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
  font-size:10.5px!important;
  line-height:1.1!important;
}

.pfsvc .pfsvc-review{
  font-size:8.5px!important;
  line-height:1!important;
}

.pfsvc .pfsvc-sales{
  font-size:11px!important;
  line-height:1!important;
}

.pfsvc .pfsvc-stars{
  font-family:'InterFinal'!important;
  font-size:13px!important;
  letter-spacing:3px!important;
}
</style>


<style>
/* =========================================================
   FINAL PRODUCT BOX CONTENT PATCH
   Product box content is now:
   Title / Subtitle / Price / View Full
   Reviews, stars, and sales are removed.
   Fonts stay:
   - Brand only: Boxing
   - Header / Card Title / Subtitle labels: Clash Display
   - Body / buttons / price text: InterFinal
   ========================================================= */

/* Hide removed old review/sales UI if any old markup remains */
.pfsvc .pfsvc-rating,
.pfsvc .pfsvc-stars,
.pfsvc .pfsvc-review,
.pfsvc .pfsvc-sales{
  display:none!important;
}

/* Keep product cards same general UI size from your current layout */
.pfsvc .pfsvc-grid,
.pfsvc .pfsvc-grid.list{
  grid-template-columns:repeat(4,280px)!important;
  gap:24px 30px!important;
}

.pfsvc .pfsvc-grid .pfsvc-card,
.pfsvc .pfsvc-grid.list .pfsvc-card{
  width:290px!important;
  height:230px!important;
  min-height:230px!important;
  max-height:230px!important;
  border:0!important;
  border-radius:6px!important;
  background:#fff!important;
  overflow:hidden!important;
  box-shadow:0 7px 16px rgba(0,0,0,.16)!important;
}

.pfsvc .pfsvc-grid .pfsvc-img,
.pfsvc .pfsvc-grid.list .pfsvc-img,
.pfsvc .pfsvc-grid .pfsvc-img img,
.pfsvc .pfsvc-grid.list .pfsvc-img img{
  height:135px!important;
  min-height:135px!important;
  max-height:135px!important;
  border-radius:6px 6px 0 0!important;
  object-fit:cover!important;
  object-position:center!important;
}

/* Product box layout: title/subtitle left, price + button right */
.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
  height:90px!important;
  min-height:92px!important;
  max-height:95px!important;
  padding:10px 12px 11px!important;
  display:grid!important;
  grid-template-columns:minmax(0,1fr) auto!important;
  grid-template-rows:auto 1fr auto!important;
  column-gap:10px!important;
  row-gap:3px!important;
  align-items:start!important;
  background:#fff!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-info{
  display:block!important;
  grid-column:1/2!important;
  grid-row:1/4!important;
  min-width:0!important;
}

/* Title */
.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  margin:0 0 5px!important;
  color:#111!important;
  font-family:'Clash Display',system-ui,sans-serif!important;
  font-size:17px!important;
  font-weight:600!important;
  line-height:1.08!important;
  letter-spacing:.1px!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

/* Subtitle under title */
.pfsvc .pfsvc-card-subtitle,
.pfsvc .pfsvc-grid .pfsvc-body p.pfsvc-card-subtitle,
.pfsvc .pfsvc-grid.list .pfsvc-body p.pfsvc-card-subtitle{
  display:-webkit-box!important;
  -webkit-line-clamp:2!important;
  -webkit-box-orient:vertical!important;
  margin:0!important;
  color:#111!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:400!important;
  line-height:1.25!important;
  letter-spacing:0!important;
  overflow:hidden!important;
}

/* Price: green like your reference screenshot */
.pfsvc .pfsvc-actions{
  display:flex!important;
  grid-column:2/3!important;
  grid-row:1/4!important;
  flex-direction:column!important;
  align-items:flex-end!important;
  justify-content:space-between!important;
  height:100%!important;
  min-width:82px!important;
}

.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
  width:auto!important;
  min-width:0!important;
  max-width:96px!important;
  height:auto!important;
  min-height:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  padding:0!important;
  box-shadow:none!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:flex-end!important;
  color:#07820d!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:13px!important;
  font-weight:600!important;
  line-height:1.15!important;
  letter-spacing:.05px!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

/* Small View Full button remains orange and clean */
.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  width:82px!important;
  min-width:82px!important;
  height:26px!important;
  min-height:26px!important;
  padding:0 10px!important;
  margin:0!important;
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(90deg,var(--ui-orange-start,#FE7B09),var(--ui-orange-end,#FFAB0A))!important;
  color:#111827!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:9.5px!important;
  font-weight:400!important;
  line-height:1!important;
  letter-spacing:.1px!important;
  text-transform:none!important;
  white-space:nowrap!important;
  box-shadow:none!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card button:hover{
  background:#111827!important;
  color:#fff!important;
}

/* Outside/regular buttons keep semibold with slight letter spacing */
.pfsvc .pfsvc-btn,
.pfsvc .pfsvc-tools .pfsvc-all,
.pfsvc .pfsvc-callout a.pfsvc-btn,
.pfsvc #pfsvcContinue{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-weight:600!important;
  letter-spacing:.35px!important;
}

/* Keep the 3-font system only */
.pfsvc,
.pfsvc p,
.pfsvc span,
.pfsvc label,
.pfsvc select,
.pfsvc input,
.pfsvc strong,
.pfsvc button{
  font-family:'InterFinal',system-ui,sans-serif!important;
}

.pfsvc h1,
.pfsvc h2,
.pfsvc h3,
.pfsvc h4,
.pfsvc h5,
.pfsvc h6,
.pfsvc .pfsvc-nav,
.pfsvc .pfsvc-nav span,
.pfsvc .pfsvc-head span,
.pfsvc .pfsvc-head h2,
.pfsvc .pfsvc-side h3{
  font-family:'Clash Display',system-ui,sans-serif!important;
}

.brand-main-text,
.printify-brand,
.printify-logo{
  font-family:'Boxing',serif!important;
}

@media(max-width:1280px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(3,280px)!important;
  }
}

@media(max-width:980px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(2,280px)!important;
    justify-content:center!important;
  }
}

@media(max-width:620px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:1fr!important;
    justify-content:center!important;
  }

  .pfsvc .pfsvc-grid .pfsvc-card,
  .pfsvc .pfsvc-grid.list .pfsvc-card{
    width:min(100%,320px)!important;
  }
}
</style>


<style>
/* =========================================================
   FINAL FIX: PRICE AT BOTTOM + SHORT NOTE
   Product box content:
   Title
   Short note
   Bottom row: green price left, View Full button right
   Reviews/stars/sales removed.
   ========================================================= */

.pfsvc .pfsvc-rating,
.pfsvc .pfsvc-stars,
.pfsvc .pfsvc-review,
.pfsvc .pfsvc-sales{
  display:none!important;
}

/* Product card size/layout stays the same */
.pfsvc .pfsvc-grid,
.pfsvc .pfsvc-grid.list{
  grid-template-columns:repeat(4,280px)!important;
  gap:24px 30px!important;
}

.pfsvc .pfsvc-grid .pfsvc-card,
.pfsvc .pfsvc-grid.list .pfsvc-card{
  width:280px!important;
  height:225px!important;
  min-height:225px!important;
  max-height:225px!important;
  border:0!important;
  border-radius:6px!important;
  background:#fff!important;
  overflow:hidden!important;
  box-shadow:0 7px 16px rgba(0,0,0,.16)!important;
}

.pfsvc .pfsvc-grid .pfsvc-img,
.pfsvc .pfsvc-grid.list .pfsvc-img,
.pfsvc .pfsvc-grid .pfsvc-img img,
.pfsvc .pfsvc-grid.list .pfsvc-img img{
  width:100%!important;
  height:135px!important;
  min-height:135px!important;
  max-height:135px!important;
  border-radius:6px 6px 0 0!important;
  object-fit:cover!important;
  object-position:center!important;
}

/* Body uses 3 clean rows */
.pfsvc .pfsvc-grid .pfsvc-body,
.pfsvc .pfsvc-grid.list .pfsvc-body{
  height:90px!important;
  min-height:90px!important;
  max-height:90px!important;
  padding:10px 12px 11px!important;
  display:grid!important;
  grid-template-columns:minmax(0,1fr) auto!important;
  grid-template-rows:auto auto 1fr!important;
  column-gap:10px!important;
  row-gap:3px!important;
  align-items:start!important;
  background:#fff!important;
  overflow:hidden!important;
}

.pfsvc .pfsvc-info{
  display:contents!important;
}

/* Title */
.pfsvc .pfsvc-grid .pfsvc-body h3,
.pfsvc .pfsvc-grid.list .pfsvc-body h3{
  grid-column:1/3!important;
  grid-row:1!important;
  margin:0!important;
  color:#111!important;
  font-family:'Clash Display',system-ui,sans-serif!important;
  font-size:17px!important;
  font-weight:600!important;
  line-height:1.08!important;
  letter-spacing:.1px!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

/* Short note/subtitle */
.pfsvc .pfsvc-card-subtitle,
.pfsvc .pfsvc-grid .pfsvc-body p.pfsvc-card-subtitle,
.pfsvc .pfsvc-grid.list .pfsvc-body p.pfsvc-card-subtitle{
  grid-column:1/3!important;
  grid-row:2!important;
  display:block!important;
  width:100%!important;
  margin:0!important;
  color:#111!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:11.5px!important;
  font-weight:400!important;
  line-height:1.15!important;
  letter-spacing:0!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

/* Actions become bottom row */
.pfsvc .pfsvc-actions{
  display:contents!important;
}

/* Price is now at the very bottom-left */
.pfsvc .pfsvc-grid .pfsvc-price,
.pfsvc .pfsvc-grid.list .pfsvc-price{
  grid-column:1/2!important;
  grid-row:3!important;
  align-self:end!important;
  justify-self:start!important;
  width:auto!important;
  min-width:0!important;
  max-width:140px!important;
  height:auto!important;
  min-height:0!important;
  border:0!important;
  border-radius:0!important;
  background:transparent!important;
  padding:0!important;
  box-shadow:none!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:flex-start!important;
  color:#07820d!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:13px!important;
  font-weight:600!important;
  line-height:1.1!important;
  letter-spacing:.05px!important;
  white-space:nowrap!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
}

/* View Full button bottom-right */
.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  grid-column:2/3!important;
  grid-row:3!important;
  align-self:end!important;
  justify-self:end!important;
  width:82px!important;
  min-width:82px!important;
  height:26px!important;
  min-height:26px!important;
  padding:0 10px!important;
  margin:0!important;
  border:0!important;
  border-radius:999px!important;
  background:linear-gradient(90deg,var(--ui-orange-start,#FE7B09),var(--ui-orange-end,#FFAB0A))!important;
  color:#111827!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:9.5px!important;
  font-weight:400!important;
  line-height:1!important;
  letter-spacing:.1px!important;
  text-transform:none!important;
  white-space:nowrap!important;
  box-shadow:none!important;
}

.pfsvc .pfsvc-grid .pfsvc-card button:hover,
.pfsvc .pfsvc-grid.list .pfsvc-card button:hover{
  background:#111827!important;
  color:#fff!important;
}

/* Keep 3-font system */
.pfsvc,
.pfsvc p,
.pfsvc span,
.pfsvc label,
.pfsvc select,
.pfsvc input,
.pfsvc strong,
.pfsvc button{
  font-family:'InterFinal',system-ui,sans-serif!important;
}

.pfsvc h1,
.pfsvc h2,
.pfsvc h3,
.pfsvc h4,
.pfsvc h5,
.pfsvc h6,
.pfsvc .pfsvc-nav,
.pfsvc .pfsvc-nav span,
.pfsvc .pfsvc-head span,
.pfsvc .pfsvc-head h2,
.pfsvc .pfsvc-side h3{
  font-family:'Clash Display',system-ui,sans-serif!important;
}

.brand-main-text,
.printify-brand,
.printify-logo{
  font-family:'Boxing',serif!important;
}

@media(max-width:1280px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(3,280px)!important;
  }
}

@media(max-width:980px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:repeat(2,280px)!important;
    justify-content:center!important;
  }
}

@media(max-width:620px){
  .pfsvc .pfsvc-grid,
  .pfsvc .pfsvc-grid.list{
    grid-template-columns:1fr!important;
    justify-content:center!important;
  }

  .pfsvc .pfsvc-grid .pfsvc-card,
  .pfsvc .pfsvc-grid.list .pfsvc-card{
    width:min(100%,320px)!important;
  }
}
</style>



<style id="services-final-font-fix-contact-us-style">
/* =========================================================
   SERVICES PAGE FINAL FONT FIX - CONTACT US STYLE
   Fonts only. UI / colors / sizes / positions unchanged.
   PRINTIFY & CO. word only = Boxing-Regular.otf
   Header / Card Title / Sub title = ClashDisplay-Semibold.otf
   Body / normal text / buttons = Inter.ttc semibold
   ========================================================= */
@font-face{
  font-family:'BoxingFinal';
  src:url('/Fonts/Boxing-Regular.otf') format('opentype');
  font-weight:400;
  font-style:normal;
  font-display:swap;
}
@font-face{
  font-family:'ClashDisplayFinal';
  src:url('/Fonts/ClashDisplay-Semibold.otf') format('opentype');
  font-weight:600;
  font-style:normal;
  font-display:swap;
}
@font-face{
  font-family:'InterFinal';
  src:url('/Fonts/Inter.ttc') format('truetype-collection');
  font-weight:600;
  font-style:normal;
  font-display:swap;
}

/* Body / descriptions / normal text / buttons = Inter.ttc semibold */
.pfsvc,
.pfsvc :where(p,span,a,li,small,td,th,input,textarea,select,option,button,strong,div,label),
.pfsvc-deck,
.pfsvc-deck :where(p,span,a,li,small,td,th,input,textarea,select,option,button,strong,div,label){
  font-family:'InterFinal',Arial,sans-serif!important;
  font-weight:600!important;
}

/* Headers / Card Titles / Sub titles = ClashDisplay-Semibold.otf */
.pfsvc :where(h1,h2,h3,h4,h5,h6,.pfsvc-head span,.pfsvc-head h2,.pfsvc-side h3,.pfsvc-filterbox h3,.pfsvc-body h3,.pfsvc-card-subtitle,.pfsvc-nav,.pfsvc-nav span,.pfsvc-empty h3,.pfsvc-callout h3,.pfsvc-detail h3,.pfsvc-detail span),
.pfsvc-deck :where(h1,h2,h3,h4,h5,h6,.pfsvc-deck-title span,.pfsvc-deck-title h3,.pfsvc-deck-title p){
  font-family:'ClashDisplayFinal','Clash Display',Arial,sans-serif!important;
  font-weight:600!important;
}

/* PRINTIFY & CO. wordmark only = Boxing-Regular.otf */
.brand-main-text,
.printify-brand,
.printify-logo,
.printify-wordmark,
[aria-label*="Printify"],
[title*="Printify"]{
  font-family:'BoxingFinal','Boxing',serif!important;
  font-weight:400!important;
}

/* Keep Font Awesome icons working */
.pfsvc i,
.pfsvc-deck i{
  font-family:"Font Awesome 6 Free","Font Awesome 6 Brands"!important;
}
</style>


<style id="services-final-requested-adjustments">
/* =========================================================
   FINAL REQUESTED ADJUSTMENTS
   - TURNAROUND TIME label uppercase + bold
   - Turnaround Time field width reduced
   - Any Time / Same Day / Next Day / Custom semibold + centered
   - SORT BY label uppercase + bold
   - Popular / Name / Price semibold + centered
   - SHOW EXPRESS SERVICES uppercase + bold
   - ON button moved slightly left + semibold
   - ON, CONTACT US, VIEW ALL SERVICES, VIEW FULL semibold
   ========================================================= */

/* TURNAROUND TIME label */
.pfsvc label.pfsvc-label[for="pfsvcTime"]{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:700!important;
  line-height:1!important;
  letter-spacing:.25px!important;
  text-transform:uppercase!important;
  color:#111!important;
}

/* Reduce width of Turnaround Time select field */
.pfsvc #pfsvcTime{
  width:190px!important;
  max-width:190px!important;
  height:38px!important;
  margin:6px 0 18px!important;
  padding:0 30px 0 12px!important;
  text-align:center!important;
  text-align-last:center!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:0!important;
  color:#111!important;
}

/* Center + semibold dropdown option labels */
.pfsvc #pfsvcTime option,
.pfsvc #pfsvcSort option{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:600!important;
  text-align:center!important;
  color:#111!important;
}

/* SORT BY label */
.pfsvc .pfsvc-sort{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:700!important;
  line-height:1!important;
  letter-spacing:.25px!important;
  text-transform:uppercase!important;
  color:#111!important;
}

/* Sort field text centered + semibold */
.pfsvc #pfsvcSort{
  text-align:center!important;
  text-align-last:center!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:0!important;
  color:#111!important;
}

/* SHOW EXPRESS SERVICES uppercase + bold */
.pfsvc .pfsvc-switch span{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:700!important;
  line-height:1.2!important;
  letter-spacing:.25px!important;
  text-transform:uppercase!important;
  color:#111!important;
}

/* Move ON button slightly to the left and make semibold */
.pfsvc .pfsvc-switch b{
  justify-self:start!important;
  transform:translateX(-10px)!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:10px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:.15px!important;
  text-transform:uppercase!important;
}

/* VIEW ALL SERVICES / CONTACT US / VIEW FULL = semibold */
.pfsvc .pfsvc-tools .pfsvc-all,
.pfsvc .pfsvc-tools .pfsvc-all span,
.pfsvc .pfsvc-callout a.pfsvc-btn,
.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-weight:600!important;
  letter-spacing:.15px!important;
}

/* Keep VIEW ALL SERVICES text clean and centered */
.pfsvc .pfsvc-tools .pfsvc-all{
  min-width:154px!important;
  justify-content:center!important;
  text-align:center!important;
}

/* Make card button text semibold without changing size/layout */
.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  font-size:9.5px!important;
  font-weight:600!important;
}

/* Mobile safety */
@media(max-width:720px){
  .pfsvc #pfsvcTime{
    width:min(190px,100%)!important;
    max-width:100%!important;
  }
}
</style>

<style id="services-final-tight-fields-and-steady-on-button">
/* =========================================================
   FINAL FINAL ADJUSTMENTS PER SCREENSHOT
   - Turnaround Time field mas maliit ang width
   - Sort By field mas maliit ang width
   - Dropdown texts centered + semibold
   - SHOW EXPRESS SERVICES + ON closer together
   - ON button steady, hindi gumagalaw on hover/focus
   - ON / CONTACT US / VIEW ALL SERVICES / VIEW FULL semibold
   ========================================================= */

/* TURNAROUND TIME label stays uppercase + bold */
.pfsvc label.pfsvc-label[for="pfsvcTime"]{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:700!important;
  line-height:1!important;
  letter-spacing:.25px!important;
  text-transform:uppercase!important;
  color:#111!important;
}

/* Mas bawas pa ang width ng Turnaround Time field */
.pfsvc #pfsvcTime{
  width:165px!important;
  max-width:165px!important;
  min-width:165px!important;
  height:38px!important;
  margin:6px 0 18px!important;
  padding:0 28px 0 10px!important;
  text-align:center!important;
  text-align-last:center!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:0!important;
  color:#111!important;
  background-color:#fff!important;
}

/* SORT BY label uppercase + bold */
.pfsvc .pfsvc-sort{
  height:38px!important;
  display:flex!important;
  align-items:center!important;
  gap:7px!important;
  white-space:nowrap!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:700!important;
  line-height:1!important;
  letter-spacing:.25px!important;
  text-transform:uppercase!important;
  color:#111!important;
}

/* Mas bawas din ang width ng Sort By field */
.pfsvc #pfsvcSort{
  width:105px!important;
  min-width:105px!important;
  max-width:105px!important;
  height:38px!important;
  padding:0 26px 0 10px!important;
  text-align:center!important;
  text-align-last:center!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:0!important;
  color:#111!important;
  background-color:#fff!important;
}

/* Dropdown items semibold + centered */
.pfsvc #pfsvcTime option,
.pfsvc #pfsvcSort option{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:600!important;
  text-align:center!important;
  color:#111!important;
}

/* Show Express row: idikit ang ON sa label, papasok sa loob ng sidebar */
.pfsvc .pfsvc-switch{
  width:255px!important;
  max-width:255px!important;
  display:grid!important;
  grid-template-columns:max-content 86px!important;
  align-items:center!important;
  justify-content:start!important;
  column-gap:18px!important;
  margin-top:6px!important;
  color:#111!important;
  cursor:pointer!important;
}

/* SHOW EXPRESS SERVICES uppercase + bold */
.pfsvc .pfsvc-switch span{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:700!important;
  line-height:1.2!important;
  letter-spacing:.25px!important;
  text-transform:uppercase!important;
  color:#111!important;
  white-space:nowrap!important;
}

/* ON button: semibold, steady lang, walang galaw on hover/focus */
.pfsvc .pfsvc-switch b,
.pfsvc .pfsvc-switch input:checked~b{
  width:86px!important;
  min-width:86px!important;
  max-width:86px!important;
  height:34px!important;
  min-height:34px!important;
  padding:0 14px!important;
  justify-self:start!important;
  transform:none!important;
  translate:none!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:10px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:.15px!important;
  text-transform:uppercase!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
}

.pfsvc .pfsvc-switch:hover b,
.pfsvc .pfsvc-switch:focus-within b,
.pfsvc .pfsvc-switch input:checked~b:hover,
.pfsvc .pfsvc-switch input:checked~b:focus{
  transform:none!important;
  translate:none!important;
  box-shadow:none!important;
}

/* VIEW ALL SERVICES button semibold */
.pfsvc .pfsvc-tools .pfsvc-all,
.pfsvc .pfsvc-tools .pfsvc-all span{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:11px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:.15px!important;
  text-transform:none!important;
}

/* CONTACT US button semibold */
.pfsvc .pfsvc-callout a.pfsvc-btn,
.pfsvc .pfsvc-callout a.pfsvc-btn span{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:11px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:.15px!important;
  text-transform:uppercase!important;
}

/* VIEW FULL button semibold */
.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:9.5px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:.15px!important;
  text-transform:none!important;
}

/* Mobile safety */
@media(max-width:720px){
  .pfsvc #pfsvcTime{
    width:165px!important;
    min-width:165px!important;
    max-width:100%!important;
  }

  .pfsvc #pfsvcSort{
    width:105px!important;
    min-width:105px!important;
    max-width:105px!important;
  }

  .pfsvc .pfsvc-switch{
    width:min(255px,100%)!important;
    max-width:100%!important;
    grid-template-columns:max-content 86px!important;
  }
}
</style>

<style id="services-final-sort-buttons-semibold-override">
/* =========================================================
   FINAL REQUEST FIX
   - SORT BY: uppercase + bold
   - Popular / Name / Price centered + semibold
   - ON / CONTACT US / VIEW ALL SERVICES / VIEW FULL semibold
   - Button inner text itself is semibold
   ========================================================= */

/* SORT BY label uppercase + bold */
.pfsvc .pfsvc-sort{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:700!important;
  line-height:1!important;
  letter-spacing:.25px!important;
  text-transform:uppercase!important;
  color:#111!important;
}

/* SORT BY select field text centered + semibold */
.pfsvc #pfsvcSort{
  width:105px!important;
  min-width:105px!important;
  max-width:105px!important;
  height:38px!important;
  padding:0 26px 0 10px!important;
  text-align:center!important;
  text-align-last:center!important;
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:0!important;
  color:#111!important;
  background:#fff!important;
}

/* Dropdown choices centered + semibold */
.pfsvc #pfsvcSort option,
.pfsvc #pfsvcTime option{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:12px!important;
  font-weight:600!important;
  text-align:center!important;
  color:#111!important;
}

/* ON button text itself semibold and steady */
.pfsvc .pfsvc-switch b,
.pfsvc .pfsvc-switch input:checked~b,
.pfsvc .pfsvc-switch:hover b,
.pfsvc .pfsvc-switch:focus-within b{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:10px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:.15px!important;
  text-transform:uppercase!important;
  transform:none!important;
  translate:none!important;
  box-shadow:none!important;
}

/* VIEW ALL SERVICES button + inner span semibold */
.pfsvc .pfsvc-tools .pfsvc-all,
.pfsvc .pfsvc-tools .pfsvc-all span{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:11px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:.15px!important;
  text-transform:uppercase!important;
}

/* CONTACT US button + inner span semibold */
.pfsvc .pfsvc-callout a.pfsvc-btn,
.pfsvc .pfsvc-callout a.pfsvc-btn span{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:11px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:.15px!important;
  text-transform:uppercase!important;
}

/* VIEW FULL button text itself semibold */
.pfsvc .pfsvc-grid .pfsvc-card button,
.pfsvc .pfsvc-grid.list .pfsvc-card button{
  font-family:'InterFinal',system-ui,sans-serif!important;
  font-size:9.5px!important;
  font-weight:600!important;
  line-height:1!important;
  letter-spacing:.15px!important;
  text-transform:uppercase!important;
}

/* Keep Font Awesome icons working */
.pfsvc i,
.pfsvc-deck i{
  font-family:"Font Awesome 6 Free","Font Awesome 6 Brands"!important;
}
</style>