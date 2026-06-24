<!-- PRODUCTS OVERVIEW MAIN CONTENT ONLY -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
:root{
  --po-blue:#0b6cff;
  --po-blue-2:#0755d8;
  --po-black:#07111f;
  --po-muted:#64748b;
  --po-line:#e7ebf1;
  --po-soft:#f8fafc;
  --po-green:#12a36a;
  --po-red:#ef2f2f;
  --po-orange:#f59e0b;
  --po-violet:#7c3aed;
}
.products-page-main,
.products-page-main *{box-sizing:border-box}
.products-page-main{
  width:100%;
  background:#fff;
  color:var(--po-black);
  font-family:'Inter',sans-serif;
  padding:22px 28px 26px;
  letter-spacing:-.01em;
}
.products-shell{width:100%;max-width:100%;margin:0 auto;}
.po-topline{width:54px;height:4px;background:linear-gradient(90deg,var(--po-blue),#408bff);border-radius:999px;margin:0 0 12px 0;}
.po-header{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin-bottom:20px;}
.po-title h1{font-family:'Playfair Display',serif;font-size:34px;line-height:1.02;font-weight:800;margin:0 0 6px;color:#07111f;letter-spacing:-.035em;}
.po-title p{margin:0;color:#475569;font-size:13.5px;line-height:1.35;}
.po-actions-top{display:flex;flex-direction:column;align-items:flex-end;gap:8px;white-space:nowrap;margin-left:auto;}
.po-action-row{display:flex;align-items:center;justify-content:flex-end;gap:10px;}
.po-date-btn,.po-button,.po-tab,.po-filter-toggle,.po-card-action{
  height:40px;border-radius:8px;border:1px solid #0f172a;background:#fff;color:#07111f;
  display:inline-flex;align-items:center;justify-content:center;gap:8px;font-family:'Poppins',sans-serif;
  font-size:12px;font-weight:600;line-height:1;cursor:pointer;transition:color .18s ease,background .18s ease,border-color .18s ease,box-shadow .18s ease;transform:none!important;
}
.po-date-btn{width:254px;justify-content:space-between;padding:0 13px;}
.po-button{width:112px;padding:0 13px;}
.po-button.primary{border:0;background:linear-gradient(135deg,#2785ff 0%,#0759dc 100%);color:#fff;box-shadow:0 8px 16px rgba(11,108,255,.18);}
.po-button:not(.primary):hover,.po-date-btn:hover,.po-tab:not(.active):hover,.po-filter-toggle:hover,.po-card-action:hover{background:#0b0f19;color:#fff;border-color:#0b0f19;}
.po-button svg,.po-date-btn svg,.po-tab svg,.po-filter-toggle svg,.po-card-action svg{width:16px;height:16px;flex:0 0 auto;}
.po-grid-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:18px;}
.po-stat-card{height:92px;border-radius:12px;background:#fff;border:1px solid var(--po-line);display:flex;align-items:center;gap:16px;padding:15px 18px;overflow:hidden;}
.po-stat-card.blue{border-color:#b7d4ff;background:#f8fbff}.po-stat-card.green{border-color:#b9ead7;background:#fbfffd}.po-stat-card.red{border-color:#ffc6c6;background:#fffafa}.po-stat-card.orange{border-color:#ffdca1;background:#fffdf8}
.po-stat-icon{width:54px;height:54px;border-radius:11px;display:flex;align-items:center;justify-content:center;flex:0 0 auto;}
.po-stat-card.blue .po-stat-icon{background:#eaf3ff;color:var(--po-blue)}.po-stat-card.green .po-stat-icon{background:#e7f8f0;color:var(--po-green)}.po-stat-card.red .po-stat-icon{background:#fff0f0;color:var(--po-red)}.po-stat-card.orange .po-stat-icon{background:#fff5e4;color:var(--po-orange)}
.po-stat-icon svg{width:30px;height:30px;stroke-width:2.4}.po-stat-label{font-family:'Poppins',sans-serif;font-weight:700;font-size:11px;text-transform:uppercase;color:#172033;margin-bottom:3px}.po-stat-num{font-family:'Poppins',sans-serif;font-size:25px;font-weight:800;line-height:1;margin-bottom:8px;color:#07111f}.po-stat-sub{font-size:12px;color:#475569;display:flex;align-items:center;gap:8px}.po-dot{width:10px;height:10px;border-radius:50%;display:inline-block}.po-dot.blue{background:var(--po-blue)}.po-dot.green{background:var(--po-green)}.po-dot.red{background:var(--po-red)}.po-dot.orange{background:var(--po-orange)}.po-dot.gray{background:#a8b3c4}
.po-charts{display:grid;grid-template-columns:1.12fr .96fr .96fr;gap:16px;margin-bottom:24px;}
.po-chart-box{height:212px;border:1px solid #dde5ef;border-radius:12px;background:#fff;padding:17px 18px;overflow:hidden;}
.po-chart-title{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;margin:0 0 10px;color:#07111f}.po-chart-small{font-size:12px;color:#64748b;margin-bottom:5px}.po-money{font-family:'Poppins',sans-serif;font-size:24px;font-weight:800;margin-bottom:4px}.po-live{float:right;display:flex;align-items:center;gap:6px;color:#05a86b;font-size:11px;font-weight:800}.po-line-chart{width:100%;height:105px;margin-top:4px}.po-chart-flex{display:flex;align-items:center;height:150px;gap:26px}.po-donut{width:126px;height:126px;border-radius:50%;position:relative;flex:0 0 auto;background:conic-gradient(var(--po-green) 0 42%,var(--po-blue) 42% 70%,var(--po-orange) 70% 88%,#cbd5e1 88% 100%)}.po-donut.inventory{background:conic-gradient(var(--po-green) 0 58%,#e2e8f0 58% 86%,var(--po-orange) 86% 100%)}.po-donut:after{content:"";position:absolute;inset:32px;background:#fff;border-radius:50%;box-shadow:inset 0 0 0 1px #edf2f7}.po-donut-center{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:1;text-align:center}.po-donut-center strong{font-family:'Poppins',sans-serif;font-size:21px;font-weight:800}.po-donut-center span{font-size:11px;color:#475569}.po-legend{flex:1;display:grid;gap:13px}.po-legend-row{display:grid;grid-template-columns:12px 1fr auto;align-items:center;gap:10px;font-size:13px}.po-legend-row b{font-weight:800}
.po-toolbar{display:grid;grid-template-columns:auto 1fr auto;align-items:center;gap:18px;margin:0 0 16px;}
.po-tabs{display:flex;gap:10px;align-items:center;flex-wrap:wrap}.po-tab{width:126px;padding:0 12px;justify-content:center}.po-tab.active{background:linear-gradient(135deg,#2785ff 0%,#0759dc 100%);color:#fff;border:0;box-shadow:0 8px 16px rgba(11,108,255,.16)}.po-tab-count{background:transparent!important;border:0!important;padding:0!important;margin-left:2px;color:inherit;font-weight:800}
.po-search-filter{display:flex;align-items:center;gap:10px;justify-self:end}.po-search{height:40px;width:286px;border:1px solid #0f172a;border-radius:8px;display:flex;align-items:center;gap:10px;padding:0 12px;background:#fff}.po-search svg{width:17px;height:17px;color:#07111f}.po-search input{border:0;outline:0;width:100%;font-size:12.5px;font-family:'Inter',sans-serif;background:transparent}.po-filter-toggle{width:126px;position:relative}.po-filter-menu{position:absolute;right:0;top:46px;width:180px;background:#fff;border:1px solid #d8e0ea;border-radius:8px;box-shadow:0 18px 35px rgba(15,23,42,.14);z-index:30;padding:6px}.po-filter-menu button{width:100%;height:34px;border:0;background:#fff;border-radius:6px;text-align:left;padding:0 11px;font-size:12px;cursor:pointer;color:#07111f}.po-filter-menu button:hover{background:#f1f5f9;color:#07111f}.po-filter-menu button.active{background:#eaf3ff;color:#0759dc;font-weight:700}
.po-products-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:14px;margin-top:8px;}
.po-product-card{border:1px solid #07111f;border-radius:7px;background:#fff;overflow:hidden;min-height:264px;display:flex;flex-direction:column;transition:background .18s ease;}.po-product-card:hover{background:rgba(15,23,42,.055)}
.po-product-image{height:136px;border-bottom:1px solid #07111f;position:relative;overflow:hidden;background:#061425;display:flex;align-items:center;justify-content:center}.po-product-image img{width:100%;height:100%;object-fit:cover;display:block}.po-product-body{padding:7px 9px 8px;display:flex;flex-direction:column;gap:3px;flex:1}.po-product-name{font-family:'Poppins',sans-serif;font-size:12px;line-height:1.12;font-weight:700;color:#07111f;margin:0}.po-product-desc{font-size:10.6px;line-height:1.16;color:#334155;margin:0;min-height:25px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}.po-product-row{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:2px}.po-price{font-family:'Poppins',sans-serif;font-size:13.5px;font-weight:800;color:#07111f}.po-stock{height:22px;padding:0 8px;border-radius:6px;font-size:10px;font-family:'Poppins',sans-serif;font-weight:800;display:flex;align-items:center;justify-content:center;white-space:nowrap}.po-stock.green{background:#dcfce7;color:#07884f;border:1px solid #a7efc5}.po-stock.red{background:#fff1f1;color:#ef2f2f;border:1px solid #ffc7c7}.po-stock.orange{background:#fff7e6;color:#b76a00;border:1px solid #ffd38c}.po-card-actions{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:4px}.po-card-action{width:100%;height:30px;font-size:10.5px;border-radius:6px;padding:0 8px}.po-card-action.edit{color:#006bff}.po-card-action.delete{color:#ef2f2f}.po-card-action.edit svg{stroke:#006bff}.po-card-action.delete svg{stroke:#ef2f2f}.po-card-action:hover svg{stroke:#fff}
.po-footer{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;margin-top:18px;color:#334155;font-size:12px}.po-footer .po-showing{justify-self:end}.po-pagination{display:flex;gap:9px;align-items:center;justify-content:center}.po-page{height:30px;min-width:32px;border:1px solid #d9e1ec;border-radius:7px;background:transparent!important;font-family:'Poppins',sans-serif;font-weight:700;cursor:pointer;color:#07111f;display:inline-flex;align-items:center;justify-content:center;box-shadow:none!important}.po-page.active{background:transparent!important;border-color:#0b6cff;color:#0b6cff}.po-page:hover:not(.active){background:transparent!important;border-color:#0b6cff;color:#0b6cff}.po-empty{grid-column:1/-1;padding:32px;text-align:center;border:1px dashed #cbd5e1;border-radius:10px;color:#64748b;font-family:'Poppins',sans-serif}
.po-toast{position:fixed;top:22px;left:50%;transform:translateX(-50%);background:#07111f;color:#fff;border-radius:9px;padding:12px 18px;z-index:9999;box-shadow:0 12px 28px rgba(2,6,23,.22);font-size:13px;font-weight:600}.po-modal-backdrop{position:fixed;inset:0;background:rgba(15,23,42,.48);backdrop-filter:blur(3px);z-index:9000;display:flex;align-items:center;justify-content:center;padding:18px}.po-modal{width:min(820px,96vw);background:#fff;border-radius:12px;border:1px solid #07111f;box-shadow:0 28px 60px rgba(2,6,23,.22);overflow:hidden}.po-modal-header{height:58px;border-bottom:1px solid #e7ebf1;display:flex;align-items:center;justify-content:space-between;padding:0 22px}.po-modal-title{font-family:'Poppins',sans-serif;font-weight:700;font-size:16px}.po-modal-title span{color:#64748b;font-weight:600;margin-left:8px}.po-modal-close{border:0;background:#fff;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center}.po-modal-body{padding:18px 22px}.po-template-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:12px}.po-template-card{border:1px solid #dde5ef;border-radius:8px;padding:12px;min-height:118px}.po-template-card h4,.po-items-template h4{font-family:'Poppins',sans-serif;font-size:12px;font-weight:700;margin:0 0 12px}.po-fieldline{display:flex;justify-content:space-between;border-bottom:1px solid #edf2f7;padding:5px 0;font-size:11.5px;color:#64748b}.po-fieldline b{color:#07111f}.po-items-template{border:1px solid #dde5ef;border-radius:8px;padding:12px}.po-items-template table{width:100%;border-collapse:collapse;font-size:11.5px}.po-items-template th{background:#f8fafc;text-align:left;padding:9px;font-family:'Poppins',sans-serif;font-size:11px}.po-items-template td{padding:13px 9px;border-bottom:1px solid #edf2f7}.po-modal-actions{display:flex;justify-content:flex-end;gap:10px;padding:0 22px 18px}.po-modal-actions .po-button{height:38px}
@media(max-width:1280px){.po-products-grid{grid-template-columns:repeat(4,1fr)}.po-grid-stats{grid-template-columns:repeat(2,1fr)}.po-charts{grid-template-columns:1fr}.po-chart-box{height:auto}.po-chart-flex{height:auto}.po-toolbar{grid-template-columns:1fr}.po-search-filter{justify-self:start}.po-header{flex-direction:column}.po-actions-top{align-self:flex-end}}
</style>

<div class="products-page-main" x-data="productsOverviewExact()" x-init="init()">
  <template x-if="toast.show"><div class="po-toast" x-text="toast.text"></div></template>
  <div class="products-shell">
    <div class="po-header">
      <div class="po-title">
        <div class="po-topline"></div>
        <h1>Products Overview</h1>
        <p>Monitor product performance and manage your catalog.</p>
      </div>
      <div class="po-actions-top">
        <button type="button" class="po-date-btn" @click="openProductCalendar()">
          <span><?= svg_icon('calendar') ?><b x-text="productDateLabel()"></b></span><?= svg_icon('chevron-down') ?>
        </button>
        <div class="po-action-row">
          <button class="po-button" @click="exportCSV()"><?= svg_icon('upload') ?> Export</button>
          <button class="po-button primary" @click="openAddModal()"><?= svg_icon('plus') ?> {{ auth()->user()?->isDeveloper() ? 'Add Product' : 'Open Catalog' }}</button>
        </div>
      </div>
    </div>

    <template x-if="calendarOpen">
      <div class="po-calendar-overlay" x-transition.opacity @click.self="closeProductCalendar()" @keydown.escape.window="closeProductCalendar()">
        <section class="po-calendar-modal" x-transition.scale>
          <div class="po-calendar-main">
            <header class="po-calendar-head">
              <div>
                <h2 x-text="calendarMonthLabel()"></h2>
                <p>Manage product reminders, restock dates, and catalog review schedules.</p>
              </div>
              <div class="po-calendar-nav">
                <button type="button" class="po-calendar-icon" @click="previousCalendarMonth()">‹</button>
                <button type="button" class="po-calendar-mini primary" @click="goTodayCalendar()">Today</button>
                <button type="button" class="po-calendar-icon" @click="nextCalendarMonth()">›</button>
                <button type="button" class="po-calendar-icon" @click="closeProductCalendar()">×</button>
              </div>
            </header>
            <div class="po-calendar-weekdays"><span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span></div>
            <div class="po-calendar-grid">
              <template x-for="day in productCalendarDays()" :key="day.key">
                <button type="button" class="po-calendar-day" :class="{'is-muted':day.muted,'is-today':day.today,'is-selected':day.iso===selectedProductDate}" @click="selectProductDate(day)">
                  <strong x-text="day.number"></strong>
                  <span class="po-calendar-dots" x-show="day.iso && productEventsForDate(day.iso).length">
                    <template x-for="event in productEventsForDate(day.iso).slice(0,3)" :key="event.id"><i></i></template>
                    <em x-show="productEventsForDate(day.iso).length>3" x-text="'+'+(productEventsForDate(day.iso).length-3)"></em>
                  </span>
                </button>
              </template>
            </div>
          </div>
          <aside class="po-calendar-side">
            <h3 x-text="productDateLabel()"></h3>
            <div class="po-calendar-list">
              <template x-if="eventsForSelectedProductDate().length===0">
                <div class="po-calendar-empty">Wala pang product reminder sa date na ito.</div>
              </template>
              <template x-for="event in eventsForSelectedProductDate()" :key="event.id">
                <article class="po-calendar-event">
                  <b x-text="event.title"></b>
                  <small x-text="event.time || 'Any time'"></small>
                  <p x-text="event.note || 'No note added.'"></p>
                  <div>
                    <button type="button" @click="editProductCalendarEvent(event)">Edit</button>
                    <button type="button" class="danger" @click="deleteProductCalendarEvent(event.id)">Delete</button>
                  </div>
                </article>
              </template>
            </div>
            <form class="po-calendar-form" @submit.prevent="saveProductCalendarEvent()">
              <label><span>Title</span><input x-model="calendarDraft.title" placeholder="Restock / product review"></label>
              <label><span>Time</span><input type="time" x-model="calendarDraft.time"></label>
              <label><span>Note</span><textarea x-model="calendarDraft.note" placeholder="Product reminder details..."></textarea></label>
              <div class="po-calendar-form-actions">
                <button type="button" class="po-calendar-clear" @click="resetProductCalendarForm()">Clear</button>
                <button type="submit" class="po-calendar-save" x-text="calendarDraft.id ? 'Update' : 'Save'"></button>
              </div>
            </form>
          </aside>
        </section>
      </div>
    </template>

    <div class="po-grid-stats">
      <div class="po-stat-card blue"><div class="po-stat-icon"><?= svg_icon('box') ?></div><div><div class="po-stat-label">Total Products</div><div class="po-stat-num" x-text="products.length"></div><div class="po-stat-sub"><span class="po-dot blue"></span> All services</div></div></div>
      <div class="po-stat-card green"><div class="po-stat-icon"><?= svg_icon('check-circle') ?></div><div><div class="po-stat-label">Published</div><div class="po-stat-num" x-text="countByStatus('published')"></div><div class="po-stat-sub"><span class="po-dot green"></span> In stock</div></div></div>
      <div class="po-stat-card red"><div class="po-stat-icon"><?= svg_icon('package-x') ?></div><div><div class="po-stat-label">Out of Stock</div><div class="po-stat-num" x-text="countByStatus('out')"></div><div class="po-stat-sub"><span class="po-dot red"></span> Needs restock</div></div></div>
      <div class="po-stat-card orange"><div class="po-stat-icon"><?= svg_icon('alert') ?></div><div><div class="po-stat-label">Low Stock</div><div class="po-stat-num" x-text="countByStatus('low')"></div><div class="po-stat-sub"><span class="po-dot orange"></span> Need reorder</div></div></div>
    </div>

    <div class="po-charts">
      <div class="po-chart-box po-performance-box">
        <div class="po-live"><span class="po-dot green" style="width:7px;height:7px"></span>LIVE</div>
        <h3 class="po-chart-title">Product Performance</h3>
        <div class="po-performance-head">
          <div>
            <div class="po-chart-small">Total Catalog Value</div>
            <div class="po-money">PHP 1,575.00</div>
          </div>
          <div class="po-performance-growth"><span>↗ 12.4%</span><small>vs last week</small></div>
        </div>
        <div class="po-performance-mini">
          <div><span>Published</span><b x-text="countByStatus('published')"></b></div>
          <div><span>Out of Stock</span><b x-text="countByStatus('out')"></b></div>
          <div><span>Low Stock</span><b x-text="countByStatus('low')"></b></div>
        </div>
        <svg class="po-line-chart" viewBox="0 0 520 130" preserveAspectRatio="none">
          <defs><linearGradient id="prodArea" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#0b6cff" stop-opacity=".22"/><stop offset="1" stop-color="#0b6cff" stop-opacity="0"/></linearGradient></defs>
          <g stroke="#e7ebf1" stroke-width="1"><line x1="0" y1="105" x2="520" y2="105"/><line x1="0" y1="76" x2="520" y2="76"/><line x1="0" y1="47" x2="520" y2="47"/></g>
          <path d="M0,110 C55,80 92,68 130,60 C170,50 184,10 220,22 C250,30 245,84 284,83 C325,82 335,18 374,24 C414,29 405,108 452,105 C486,101 486,38 520,22 L520,130 L0,130 Z" fill="url(#prodArea)"/>
          <path d="M0,110 C55,80 92,68 130,60 C170,50 184,10 220,22 C250,30 245,84 284,83 C325,82 335,18 374,24 C414,29 405,108 452,105 C486,101 486,38 520,22" fill="none" stroke="#0b6cff" stroke-width="4" stroke-linecap="round"/>
          <circle cx="520" cy="22" r="5" fill="#0b6cff" stroke="#fff" stroke-width="3"/>
        </svg>
      </div>
      <div class="po-chart-box"><h3 class="po-chart-title">Top Selling Category</h3><div class="po-chart-flex"><div class="po-donut"><div class="po-donut-center"><strong>Print</strong><span>42%</span></div></div><div class="po-legend"><div class="po-legend-row"><span class="po-dot green"></span><span>Printing</span><b>42%</b></div><div class="po-legend-row"><span class="po-dot blue"></span><span>Services</span><b>28%</b></div><div class="po-legend-row"><span class="po-dot orange"></span><span>Photo</span><b>18%</b></div><div class="po-legend-row"><span class="po-dot gray"></span><span>Other</span><b>12%</b></div></div></div></div>
      <div class="po-chart-box"><h3 class="po-chart-title">Inventory Status</h3><div class="po-chart-flex"><div class="po-donut inventory"><div class="po-donut-center"><strong x-text="products.length">13</strong><span>Products</span></div></div><div class="po-legend"><div class="po-legend-row"><span class="po-dot green"></span><span>In Stock</span><b x-text="countByStatus('published')">6</b></div><div class="po-legend-row"><span class="po-dot red"></span><span>Out</span><b x-text="countByStatus('out')">2</b></div><div class="po-legend-row"><span class="po-dot orange"></span><span>Low Stock</span><b x-text="countByStatus('low')">5</b></div></div></div></div>
    </div>

    <div class="po-toolbar">
      <div class="po-tabs">
        <button class="po-tab" :class="filter==='all'?'active':''" @click="setFilter('all')">All Products <span class="po-tab-count" x-text="products.length"></span></button>
        <button class="po-tab" :class="filter==='published'?'active':''" @click="setFilter('published')">Published <span class="po-tab-count" x-text="countByStatus('published')"></span></button>
        <button class="po-tab" :class="filter==='out'?'active':''" @click="setFilter('out')">Out of Stock <span class="po-tab-count" x-text="countByStatus('out')"></span></button>
        <button class="po-tab" :class="filter==='low'?'active':''" @click="setFilter('low')">Low Stock <span class="po-tab-count" x-text="countByStatus('low')"></span></button>
      </div>
      <div></div>
      <div class="po-search-filter">
        <label class="po-search"><?= svg_icon('search') ?><input type="text" x-model.debounce.150ms="search" placeholder="Search products..."></label>
        <div style="position:relative"><button class="po-filter-toggle" @click="filterMenu=!filterMenu"><?= svg_icon('filter') ?> Filters <?= svg_icon('chevron-down') ?></button><div class="po-filter-menu" x-show="filterMenu" @click.outside="filterMenu=false" x-transition><button :class="filter==='all'?'active':''" @click="setFilter('all');filterMenu=false">All Products</button><button :class="filter==='published'?'active':''" @click="setFilter('published');filterMenu=false">Published</button><button :class="filter==='out'?'active':''" @click="setFilter('out');filterMenu=false">Out of Stock</button><button :class="filter==='low'?'active':''" @click="setFilter('low');filterMenu=false">Low Stock</button></div></div>
      </div>
    </div>

    <div class="po-products-grid">
      <template x-for="product in pagedProducts" :key="product.id">
        <div class="po-product-card" @dblclick="openTemplate(product)">
          <div class="po-product-image"><img :src="product.image" :alt="product.name" loading="eager" decoding="sync" fetchpriority="high"></div>
          <div class="po-product-body">
            <h3 class="po-product-name" x-text="product.name"></h3>
            <p class="po-product-desc" x-text="product.desc"></p>
            <div class="po-product-row"><div class="po-price" x-text="product.price"></div><div class="po-stock" :class="product.status==='out'?'red':(product.status==='low'?'orange':'green')" x-text="product.stock"></div></div>
            <div class="po-card-actions"><button class="po-card-action edit" @click.stop="editProduct(product)"><?= svg_icon('pencil') ?> {{ auth()->user()?->isDeveloper() ? 'Edit' : 'Catalog' }}</button><button class="po-card-action delete" @click.stop="openCatalogProduct(product)"><?= svg_icon('box') ?> View</button></div>
          </div>
        </div>
      </template>
      <template x-if="pagedProducts.length===0"><div class="po-empty">No products found.</div></template>
    </div>

    <div class="po-footer">
      <span x-text="showingText"></span>
      <div class="po-pagination"><button class="po-page" @click="prevPage()">‹</button><template x-for="page in totalPages" :key="page"><button class="po-page" :class="currentPage===page?'active':''" @click="currentPage=page" x-text="page"></button></template><button class="po-page" @click="nextPage()">›</button></div>
      <span x-text="showingText"></span>
    </div>
  </div>

  <template x-if="modal.open">
    <div class="po-modal-backdrop" @click.self="closeModal()">
      <div class="po-modal">
        <div class="po-modal-header"><div class="po-modal-title" x-text="modal.mode==='add'?'Add Product Template':'Product Details Template'"></div><button class="po-modal-close" @click="closeModal()"><?= svg_icon('x') ?></button></div>
        <div class="po-modal-body">
          <div class="po-template-grid"><div class="po-template-card"><h4>Product Information</h4><div class="po-fieldline"><span>Product Name</span><b x-text="modal.product?.name || '—'"></b></div><div class="po-fieldline"><span>Category</span><b x-text="modal.product?.category || '—'"></b></div><div class="po-fieldline"><span>SKU</span><b x-text="modal.product?.sku || '—'"></b></div><div class="po-fieldline"><span>Status</span><b x-text="modal.product?.statusLabel || '—'"></b></div></div><div class="po-template-card"><h4>Pricing & Inventory</h4><div class="po-fieldline"><span>Price</span><b x-text="modal.product?.price || '—'"></b></div><div class="po-fieldline"><span>Stock</span><b x-text="modal.product?.stock || '—'"></b></div><div class="po-fieldline"><span>Unit</span><b x-text="modal.product?.unit || '—'"></b></div><div class="po-fieldline"><span>Options</span><b x-text="modal.product?.variationSummary || '—'"></b></div></div><div class="po-template-card"><h4>Publishing</h4><div class="po-fieldline"><span>Visibility</span><b x-text="modal.product?.isActive ? 'Customer visible' : 'Hidden'"></b></div><div class="po-fieldline"><span>Last Updated</span><b x-text="modal.product?.updatedAt || '—'"></b></div><div class="po-fieldline"><span>Created By</span><b>Service Catalog</b></div><div class="po-fieldline"><span>Notes</span><b x-text="modal.product?.desc || '—'"></b></div></div></div>
          <div class="po-items-template"><h4>Items / Service Template</h4><table><thead><tr><th>ITEM</th><th>DESCRIPTION</th><th>QTY</th><th>UNIT PRICE</th><th>TOTAL</th></tr></thead><tbody><template x-for="variation in (modal.product?.variations || [])" :key="variation.id"><tr><td x-text="variation.name"></td><td x-text="variation.description"></td><td>1</td><td x-text="variation.price"></td><td x-text="variation.price"></td></tr></template><tr x-show="!(modal.product?.variations || []).length"><td>—</td><td>No active variations yet.</td><td>—</td><td>—</td><td>—</td></tr></tbody></table></div>
        </div><div class="po-modal-actions"><button class="po-button primary" @click="saveTemplate()">Save Template</button><button class="po-button" @click="printTemplate()"><?= svg_icon('printer') ?> Print</button></div>
      </div>
    </div>
  </template>
</div>

<?php
function svg_icon($name){
  $icons=[
    'calendar'=>'<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>',
    'chevron-down'=>'<svg fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"/></svg>',
    'upload'=>'<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5-5 5 5M12 5v12"/></svg>',
    'plus'=>'<svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>',
    'box'=>'<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 8 12 3 3 8l9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>',
    'check-circle'=>'<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.1V12a10 10 0 1 1-5.9-9.1"/><path d="m22 4-10 10.01-3-3"/></svg>',
    'package-x'=>'<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 8 12 3 3 8l9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="m15 9-6 6M9 9l6 6"/></svg>',
    'alert'=>'<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m21.73 18-8-14a2 2 0 0 0-3.46 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4M12 17h.01"/></svg>',
    'search'=>'<svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>',
    'filter'=>'<svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3Z"/></svg>',
    'pencil'=>'<svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>',
    'trash'=>'<svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6M10 11v6M14 11v6"/></svg>',
    'x'=>'<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>',
    'printer'=>'<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>'
  ];
  return $icons[$name] ?? '';
}
?>
@php
  $canManageServices = auth()->user()?->isDeveloper() ?? false;
  $serviceImageUrl = function (?string $path) {
      if (!$path) {
          return null;
      }

      return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://', 'data:'])
          ? $path
          : asset('storage/' . ltrim($path, '/'));
  };
  $serviceCatalogProducts = \App\Models\Service::query()
      ->with(['activeVariations' => fn ($query) => $query->orderBy('retail_price')])
      ->withCount(['variations', 'activeVariations'])
      ->orderBy('category')
      ->orderBy('name')
      ->get()
      ->map(function ($service) use ($canManageServices, $serviceImageUrl) {
          $activeOptions = (int) ($service->active_variations_count ?? $service->activeVariations->count());
          $priceValue = (float) ($service->activeVariations->min('retail_price') ?? $service->retail_price ?? 0);
          $firstVariationImage = optional($service->activeVariations->first())->variation_image_path;
          $status = ! $service->is_active ? 'out' : ($activeOptions === 0 ? 'low' : 'published');

          return [
              'id' => $service->id,
              'name' => $service->name,
              'desc' => $service->description ?: 'Customer-visible print service from the live catalog.',
              'category' => $service->category ?: 'Uncategorized',
              'sku' => $service->service_item_id ?: ('SVC-' . str_pad((string) $service->id, 4, '0', STR_PAD_LEFT)),
              'unit' => $service->unit ?: 'per service',
              'price' => 'PHP ' . number_format($priceValue, 2),
              'stock' => ! $service->is_active ? 'INACTIVE' : ($activeOptions > 0 ? $activeOptions . ' OPTIONS' : 'NO OPTIONS'),
              'status' => $status,
              'statusLabel' => $service->is_active ? 'Published' : 'Inactive',
              'isActive' => (bool) $service->is_active,
              'variationSummary' => $activeOptions . ' active / ' . (int) ($service->variations_count ?? 0) . ' total',
              'updatedAt' => optional($service->updated_at)->format('M d, Y') ?: '—',
              'image' => $serviceImageUrl($service->image_path ?: $firstVariationImage),
              'showUrl' => $service->is_active ? route('services.show', $service) : route('admin.services.index'),
              'editUrl' => $canManageServices ? route('admin.services.edit', $service) : route('admin.services.index'),
              'adminUrl' => route('admin.services.index'),
              'variations' => $service->activeVariations->take(6)->map(fn ($variation) => [
                  'id' => $variation->id,
                  'name' => $variation->service_item_id ?: ('Option ' . $variation->id),
                  'description' => $variation->variation_label ?: 'Standard service option',
                  'price' => 'PHP ' . number_format((float) $variation->retail_price, 2),
              ])->values(),
          ];
      })
      ->values();
  $serviceCatalogRoutes = [
      'create' => $canManageServices ? route('admin.services.create') : route('admin.services.index'),
      'index' => route('admin.services.index'),
      'canManage' => $canManageServices,
  ];
@endphp
<script>
function productsOverviewExact(){
  const liveCatalogProducts=@json($serviceCatalogProducts);
  const serviceCatalogRoutes=@json($serviceCatalogRoutes);
  const esc=(v)=>String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  const img=(seed)=>`data:image/svg+xml;utf8,${encodeURIComponent(`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 520 260"><defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#020617"/><stop offset=".55" stop-color="#0b2038"/><stop offset="1" stop-color="#07111f"/></linearGradient><radialGradient id="b" cx="35%" cy="18%" r="44%"><stop stop-color="#0b6cff" stop-opacity=".78"/><stop offset="1" stop-color="#0b6cff" stop-opacity="0"/></radialGradient></defs><rect width="520" height="260" fill="url(#g)"/><rect width="520" height="260" fill="url(#b)"/><g transform="translate(78 62)" opacity=".96"><rect x="0" y="54" width="310" height="86" rx="9" fill="#f8fafc"/><rect x="30" y="24" width="220" height="50" rx="5" fill="#dbeafe"/><rect x="60" y="14" width="266" height="34" rx="3" fill="#ffffff" opacity=".88"/><circle cx="340" cy="94" r="27" fill="#2563eb" opacity=".82"/><rect x="32" y="96" width="190" height="14" rx="6" fill="#94a3b8"/><rect x="240" y="96" width="54" height="14" rx="6" fill="#94a3b8"/></g><text x="490" y="232" font-family="Arial" font-size="26" fill="#93c5fd" text-anchor="end">${esc(seed)}</text></svg>`)}`;
  return{
    filter:'all',search:'',filterMenu:false,currentPage:1,perPage:13,toast:{show:false,text:''},modal:{open:false,mode:'view',product:null},calendarOpen:false,selectedProductDate:'2026-06-06',calendarMonth:5,calendarYear:2026,calendarDraft:{id:null,title:'',time:'09:00',note:''},productCalendarEvents:[{id:1,date:'2026-06-06',title:'Product inventory review',time:'09:00',note:'Check low stock and out of stock products.'},{id:2,date:'2026-06-10',title:'Restock follow-up',time:'14:00',note:'Review supplier status and reorder items.'}],
    products:liveCatalogProducts.map(product=>({...product,image:product.image||img(product.name||'SERVICE')})),
    init(){this.currentPage=1;this.loadProductCalendarEvents()},
    get filteredProducts(){let q=this.search.toLowerCase().trim();return this.products.filter(p=>(this.filter==='all'||p.status===this.filter)&&(!q||p.name.toLowerCase().includes(q)||p.desc.toLowerCase().includes(q)))},
    get displayProducts(){return this.filteredProducts},
    get totalPages(){return Math.max(1,Math.ceil(this.displayProducts.length/this.perPage))},
    get pagedProducts(){let start=(this.currentPage-1)*this.perPage;return this.displayProducts.slice(start,start+this.perPage)},
    get showingText(){let total=this.displayProducts.length;if(!total)return 'Showing 0 products';let start=(this.currentPage-1)*this.perPage+1;let end=Math.min(start+this.perPage-1,total);return `Showing ${start}–${end} of ${total} products`},
    countByStatus(s){return this.products.filter(p=>p.status===s).length},
    setFilter(f){this.filter=f;this.currentPage=1;this.showToast('Product list filtered')},
    prevPage(){if(this.currentPage>1)this.currentPage--},nextPage(){if(this.currentPage<this.totalPages)this.currentPage++},
    showToast(t){this.toast.text=t;this.toast.show=true;clearTimeout(this._toast);this._toast=setTimeout(()=>this.toast.show=false,1800)},
    exportCSV(){const rows=[['Name','Description','Price','Stock','Status'],...this.filteredProducts.map(p=>[p.name,p.desc,p.price,p.stock,p.status])];const csv=rows.map(r=>r.map(v=>`"${String(v).replace(/"/g,'""')}"`).join(',')).join('\n');const blob=new Blob([csv],{type:'text/csv'});const url=URL.createObjectURL(blob);const a=document.createElement('a');a.href=url;a.download='products.csv';a.click();URL.revokeObjectURL(url);this.showToast('Products exported')},
    pad(v){return String(v).padStart(2,'0')},
    productDateLabel(){const [y,m,d]=this.selectedProductDate.split('-').map(Number);return new Date(y,m-1,d).toLocaleDateString('en-US',{month:'short',day:'2-digit',year:'numeric'})},
    calendarMonthLabel(){return new Date(this.calendarYear,this.calendarMonth,1).toLocaleDateString('en-US',{month:'long',year:'numeric'})},
    openProductCalendar(){this.calendarOpen=true;this.$nextTick(()=>document.querySelector('.po-calendar-overlay')?.focus?.())},
    closeProductCalendar(){this.calendarOpen=false;this.resetProductCalendarForm()},
    productCalendarDays(){const first=new Date(this.calendarYear,this.calendarMonth,1);const total=new Date(this.calendarYear,this.calendarMonth+1,0).getDate();const lead=first.getDay();const today=new Date().toISOString().slice(0,10);let days=[];for(let i=0;i<lead;i++)days.push({key:'blank-'+i,number:'',iso:'',muted:true,today:false});for(let d=1;d<=total;d++){const iso=`${this.calendarYear}-${this.pad(this.calendarMonth+1)}-${this.pad(d)}`;days.push({key:iso,number:d,iso,muted:false,today:iso===today})}while(days.length%7!==0)days.push({key:'end-'+days.length,number:'',iso:'',muted:true,today:false});return days},
    selectProductDate(day){if(!day||day.muted||!day.iso)return;this.selectedProductDate=day.iso;this.resetProductCalendarForm();this.showToast('Date selected: '+this.productDateLabel())},
    previousCalendarMonth(){if(this.calendarMonth===0){this.calendarMonth=11;this.calendarYear--}else this.calendarMonth--},
    nextCalendarMonth(){if(this.calendarMonth===11){this.calendarMonth=0;this.calendarYear++}else this.calendarMonth++},
    goTodayCalendar(){const now=new Date();this.calendarYear=now.getFullYear();this.calendarMonth=now.getMonth();this.selectedProductDate=now.toISOString().slice(0,10);this.resetProductCalendarForm()},
    productEventsForDate(date){return this.productCalendarEvents.filter(e=>e.date===date)},
    eventsForSelectedProductDate(){return this.productEventsForDate(this.selectedProductDate).sort((a,b)=>(a.time||'').localeCompare(b.time||''))},
    loadProductCalendarEvents(){try{const saved=JSON.parse(localStorage.getItem('printifyProductCalendarEvents')||'null');if(Array.isArray(saved))this.productCalendarEvents=saved}catch(e){}},
    persistProductCalendarEvents(){localStorage.setItem('printifyProductCalendarEvents',JSON.stringify(this.productCalendarEvents))},
    resetProductCalendarForm(){this.calendarDraft={id:null,title:'',time:'09:00',note:''}},
    saveProductCalendarEvent(){if(!this.calendarDraft.title.trim()){this.showToast('Lagyan muna ng title yung calendar reminder');return}if(this.calendarDraft.id){const found=this.productCalendarEvents.find(e=>e.id===this.calendarDraft.id);if(found){found.title=this.calendarDraft.title.trim();found.time=this.calendarDraft.time;found.note=this.calendarDraft.note;found.date=this.selectedProductDate}this.showToast('Product calendar reminder updated')}else{this.productCalendarEvents.push({id:Date.now(),date:this.selectedProductDate,title:this.calendarDraft.title.trim(),time:this.calendarDraft.time,note:this.calendarDraft.note});this.showToast('Product calendar reminder saved')}this.persistProductCalendarEvents();this.resetProductCalendarForm()},
    editProductCalendarEvent(event){this.calendarDraft={id:event.id,title:event.title,time:event.time||'09:00',note:event.note||''}},
    deleteProductCalendarEvent(id){this.productCalendarEvents=this.productCalendarEvents.filter(e=>e.id!==id);this.persistProductCalendarEvents();this.resetProductCalendarForm();this.showToast('Product calendar reminder deleted')},
    openAddModal(){window.location.href=serviceCatalogRoutes.create||serviceCatalogRoutes.index},editProduct(p){window.location.href=p.editUrl||serviceCatalogRoutes.index},openCatalogProduct(p){window.location.href=p.showUrl||p.adminUrl||serviceCatalogRoutes.index},openTemplate(p){this.modal={open:true,mode:'view',product:p}},closeModal(){this.modal.open=false},saveTemplate(){this.showToast('Service details are managed in the live catalog')},printTemplate(){window.print()}
  }
}
</script>


<!-- =========================================================
     FINAL PRODUCT SECTION REQUEST PATCH
     - Product Performance, Top Selling Category, Inventory Status:
       same Knowledge Base Management box color/style
     - Calendar/date: same Dashboard rounded-rectangle style
     - Product buttons: same compact Dashboard/Customer/Orders size/style
========================================================== -->
<style id="products-kb-box-dashboard-buttons-final-patch">
    .products-page-main{
        --prod-admin-blue:#0b63f6!important;
        --prod-admin-blue-mid:#0d66f2!important;
        --prod-admin-blue-dark:#084ac2!important;
        --prod-admin-black:#111827!important;
        --prod-kb-border:#DDE6F2!important;
        --prod-kb-shadow:0 10px 25px rgba(15,23,42,0.045)!important;
        --prod-kb-bg:#FFFFFF!important;
    }

    /* Knowledge Base Management box style applied to Product Performance, Top Selling Category, Inventory Status */
    .products-page-main .po-charts .po-chart-box,
    .products-page-main .po-charts .po-chart-box:nth-child(1),
    .products-page-main .po-charts .po-chart-box:nth-child(2),
    .products-page-main .po-charts .po-chart-box:nth-child(3){
        background:var(--prod-kb-bg)!important;
        border:1px solid var(--prod-kb-border)!important;
        border-radius:14px!important;
        box-shadow:var(--prod-kb-shadow)!important;
        padding:18px!important;
        overflow:hidden!important;
    }
    .products-page-main .po-charts .po-chart-box:hover,
    .products-page-main .po-charts .po-chart-box:nth-child(1):hover,
    .products-page-main .po-charts .po-chart-box:nth-child(2):hover,
    .products-page-main .po-charts .po-chart-box:nth-child(3):hover{
        background:#FFFFFF!important;
        border-color:var(--prod-kb-border)!important;
        box-shadow:var(--prod-kb-shadow)!important;
        transform:none!important;
    }

    /* Date / calendar control: same Dashboard rounded-rectangle style */
    .products-page-main .po-date-btn{
        width:265px!important;
        min-width:265px!important;
        height:42px!important;
        min-height:42px!important;
        padding:0 15px!important;
        border-radius:8px!important;
        border:1px solid var(--prod-admin-black)!important;
        background:#FFFFFF!important;
        background-image:none!important;
        color:var(--prod-admin-black)!important;
        box-shadow:none!important;
        display:grid!important;
        grid-template-columns:18px minmax(0,1fr) 16px!important;
        align-items:center!important;
        justify-items:center!important;
        column-gap:10px!important;
        font-family:'Inter',system-ui,sans-serif!important;
        font-size:12px!important;
        font-weight:700!important;
        line-height:1!important;
        white-space:nowrap!important;
        overflow:hidden!important;
        transform:none!important;
    }
    .products-page-main .po-date-btn span{
        display:flex!important;
        align-items:center!important;
        justify-content:center!important;
        gap:9px!important;
        width:100%!important;
        min-width:0!important;
        overflow:hidden!important;
        text-overflow:ellipsis!important;
        white-space:nowrap!important;
        color:inherit!important;
    }
    .products-page-main .po-date-btn svg{
        width:16px!important;
        height:16px!important;
        stroke:currentColor!important;
        color:currentColor!important;
        flex:0 0 auto!important;
    }
    .products-page-main .po-date-btn:hover,
    .products-page-main .po-date-btn:focus{
        background:var(--prod-admin-black)!important;
        background-image:none!important;
        border-color:var(--prod-admin-black)!important;
        color:#FFFFFF!important;
        box-shadow:none!important;
        transform:none!important;
    }

    /* Dashboard / Customer / Orders compact button size and style for Product section */
    .products-page-main .po-button,
    .products-page-main .po-tab,
    .products-page-main .po-filter-toggle,
    .products-page-main .po-card-action,
    .products-page-main .po-page,
    .products-page-main .po-modal-close{
        min-height:34px!important;
        height:34px!important;
        border-radius:999px!important;
        font-family:'Poppins',system-ui,sans-serif!important;
        font-size:11.8px!important;
        font-weight:500!important;
        line-height:1!important;
        letter-spacing:0!important;
        display:inline-flex!important;
        align-items:center!important;
        justify-content:center!important;
        gap:6px!important;
        white-space:nowrap!important;
        box-shadow:none!important;
        transform:none!important;
        transition:background-color .15s ease,color .15s ease,border-color .15s ease,box-shadow .15s ease!important;
    }
    .products-page-main .po-button,
    .products-page-main .po-filter-toggle,
    .products-page-main .po-tab{
        width:118px!important;
        min-width:118px!important;
        max-width:118px!important;
        padding:0 14px!important;
    }
    .products-page-main .po-card-action{
        width:100%!important;
        min-width:0!important;
        max-width:none!important;
        height:30px!important;
        min-height:30px!important;
        padding:0 10px!important;
        border-radius:999px!important;
        font-size:10.8px!important;
    }
    .products-page-main .po-modal-actions .po-button{
        width:118px!important;
        min-width:118px!important;
        max-width:118px!important;
        height:34px!important;
        min-height:34px!important;
    }

    /* Outline buttons: white + black border; hover black with white text */
    .products-page-main .po-button:not(.primary),
    .products-page-main .po-filter-toggle,
    .products-page-main .po-tab:not(.active),
    .products-page-main .po-card-action,
    .products-page-main .po-page,
    .products-page-main .po-modal-close{
        background:#FFFFFF!important;
        background-image:none!important;
        color:var(--prod-admin-black)!important;
        border:1px solid var(--prod-admin-black)!important;
    }
    .products-page-main .po-button:not(.primary):hover,
    .products-page-main .po-button:not(.primary):focus,
    .products-page-main .po-filter-toggle:hover,
    .products-page-main .po-filter-toggle:focus,
    .products-page-main .po-tab:not(.active):hover,
    .products-page-main .po-tab:not(.active):focus,
    .products-page-main .po-card-action:hover,
    .products-page-main .po-card-action:focus,
    .products-page-main .po-page:hover,
    .products-page-main .po-page:focus,
    .products-page-main .po-modal-close:hover,
    .products-page-main .po-modal-close:focus{
        background:var(--prod-admin-black)!important;
        background-image:none!important;
        border-color:var(--prod-admin-black)!important;
        color:#FFFFFF!important;
        box-shadow:none!important;
        transform:none!important;
    }
    .products-page-main .po-button:not(.primary):hover svg,
    .products-page-main .po-filter-toggle:hover svg,
    .products-page-main .po-tab:not(.active):hover svg,
    .products-page-main .po-card-action:hover svg,
    .products-page-main .po-page:hover svg,
    .products-page-main .po-modal-close:hover svg{
        stroke:#FFFFFF!important;
        color:#FFFFFF!important;
    }

    /* Primary buttons: Dashboard blue gradient; hover black with white text */
    .products-page-main .po-button.primary,
    .products-page-main .po-tab.active{
        background:linear-gradient(135deg,var(--prod-admin-blue) 0%,var(--prod-admin-blue-mid) 52%,var(--prod-admin-blue-dark) 100%)!important;
        background-image:linear-gradient(135deg,var(--prod-admin-blue) 0%,var(--prod-admin-blue-mid) 52%,var(--prod-admin-blue-dark) 100%)!important;
        color:#FFFFFF!important;
        border:1px solid transparent!important;
        box-shadow:none!important;
    }
    .products-page-main .po-button.primary:hover,
    .products-page-main .po-button.primary:focus,
    .products-page-main .po-tab.active:hover,
    .products-page-main .po-tab.active:focus{
        background:var(--prod-admin-black)!important;
        background-image:none!important;
        border-color:var(--prod-admin-black)!important;
        color:#FFFFFF!important;
        box-shadow:none!important;
        transform:none!important;
    }

    /* Make search/filter controls visually aligned with the same button system */
    .products-page-main .po-search{
        height:34px!important;
        min-height:34px!important;
        border-radius:8px!important;
        border:1px solid var(--prod-admin-black)!important;
        background:#FFFFFF!important;
        box-shadow:none!important;
    }
    .products-page-main .po-search input{
        font-size:12px!important;
    }

    /* Keep product chart spacing clean after applying KB style */
    .products-page-main .po-charts{
        gap:16px!important;
        margin-bottom:24px!important;
        align-items:stretch!important;
    }
    .products-page-main .po-chart-title{
        font-family:'Poppins',system-ui,sans-serif!important;
        font-size:15px!important;
        font-weight:700!important;
        color:#07111f!important;
    }

    @media(max-width:1280px){
        .products-page-main .po-actions-top{align-self:flex-end!important;}
        .products-page-main .po-charts{grid-template-columns:1fr!important;}
        .products-page-main .po-chart-box{height:auto!important;min-height:190px!important;}
    }
    @media(max-width:760px){
        .products-page-main .po-actions-top,
        .products-page-main .po-action-row,
        .products-page-main .po-search-filter{
            width:100%!important;
            align-items:stretch!important;
        }
        .products-page-main .po-date-btn,
        .products-page-main .po-button,
        .products-page-main .po-filter-toggle,
        .products-page-main .po-tab,
        .products-page-main .po-search{
            width:100%!important;
            max-width:none!important;
            min-width:0!important;
        }
        .products-page-main .po-action-row,
        .products-page-main .po-tabs,
        .products-page-main .po-search-filter{
            flex-direction:column!important;
        }
    }
</style>

<!-- =========================================================
     FINAL PRODUCTS FIX V2 - calendar/date, chart visibility, footer alignment
     - Fixes Calendar/Date text/icon layout so full date is visible
     - Product Performance / Top Selling Category / Inventory Status stay KB style but have enough height
     - Fixes bottom footer duplicate showing text and pagination alignment
========================================================== -->
<style id="products-final-v2-calendar-chart-footer-fix">
    .products-page-main{
        --prod-v2-black:#111827!important;
        --prod-v2-blue:#0b63f6!important;
        --prod-v2-blue-mid:#0d66f2!important;
        --prod-v2-blue-dark:#084ac2!important;
        --prod-v2-kb-border:#DDE6F2!important;
        --prod-v2-kb-shadow:0 10px 25px rgba(15,23,42,0.045)!important;
    }

    /* Calendar/date button: full readable text, calendar icon + date centered, chevron at right */
    .products-page-main .po-actions-top{
        align-items:flex-end!important;
        gap:8px!important;
    }
    .products-page-main .po-date-btn{
        width:265px!important;
        min-width:265px!important;
        max-width:265px!important;
        height:42px!important;
        min-height:42px!important;
        padding:0 14px!important;
        border-radius:8px!important;
        border:1px solid var(--prod-v2-black)!important;
        background:#fff!important;
        color:var(--prod-v2-black)!important;
        display:grid!important;
        grid-template-columns:minmax(0,1fr) 16px!important;
        align-items:center!important;
        column-gap:10px!important;
        overflow:hidden!important;
        box-shadow:none!important;
        transform:none!important;
        white-space:nowrap!important;
    }
    .products-page-main .po-date-btn > span{
        min-width:0!important;
        width:100%!important;
        display:flex!important;
        align-items:center!important;
        justify-content:center!important;
        gap:8px!important;
        overflow:hidden!important;
        text-overflow:ellipsis!important;
        white-space:nowrap!important;
        font-size:12px!important;
        font-weight:700!important;
        color:inherit!important;
        line-height:1!important;
    }
    .products-page-main .po-date-btn > span svg{
        width:16px!important;
        height:16px!important;
        flex:0 0 16px!important;
        stroke:currentColor!important;
    }
    .products-page-main .po-date-btn > svg{
        width:16px!important;
        height:16px!important;
        justify-self:end!important;
        flex:0 0 16px!important;
        stroke:currentColor!important;
    }
    .products-page-main .po-date-btn:hover,
    .products-page-main .po-date-btn:focus{
        background:var(--prod-v2-black)!important;
        border-color:var(--prod-v2-black)!important;
        color:#fff!important;
        box-shadow:none!important;
        transform:none!important;
    }

    /* Buttons same compact dashboard/customer/orders style */
    .products-page-main .po-button,
    .products-page-main .po-tab,
    .products-page-main .po-filter-toggle{
        height:34px!important;
        min-height:34px!important;
        width:118px!important;
        min-width:118px!important;
        max-width:118px!important;
        padding:0 14px!important;
        border-radius:999px!important;
        font-size:11.8px!important;
        font-weight:500!important;
        display:inline-flex!important;
        align-items:center!important;
        justify-content:center!important;
        gap:6px!important;
        box-shadow:none!important;
        transform:none!important;
    }
    .products-page-main .po-button.primary,
    .products-page-main .po-tab.active{
        background:linear-gradient(135deg,var(--prod-v2-blue) 0%,var(--prod-v2-blue-mid) 52%,var(--prod-v2-blue-dark) 100%)!important;
        color:#fff!important;
        border:1px solid transparent!important;
    }
    .products-page-main .po-button:not(.primary),
    .products-page-main .po-tab:not(.active),
    .products-page-main .po-filter-toggle{
        background:#fff!important;
        color:var(--prod-v2-black)!important;
        border:1px solid var(--prod-v2-black)!important;
    }
    .products-page-main .po-button:hover,
    .products-page-main .po-button:focus,
    .products-page-main .po-tab:hover,
    .products-page-main .po-tab:focus,
    .products-page-main .po-filter-toggle:hover,
    .products-page-main .po-filter-toggle:focus{
        background:var(--prod-v2-black)!important;
        background-image:none!important;
        color:#fff!important;
        border-color:var(--prod-v2-black)!important;
        box-shadow:none!important;
        transform:none!important;
    }
    .products-page-main .po-button:hover svg,
    .products-page-main .po-tab:hover svg,
    .products-page-main .po-filter-toggle:hover svg{
        stroke:#fff!important;
        color:#fff!important;
    }

    /* KB Management box style + enough height so Product Performance chart is complete */
    .products-page-main .po-charts{
        display:grid!important;
        grid-template-columns:1.12fr .96fr .96fr!important;
        gap:16px!important;
        align-items:stretch!important;
        margin-bottom:24px!important;
    }
    .products-page-main .po-chart-box,
    .products-page-main .po-charts .po-chart-box:nth-child(1),
    .products-page-main .po-charts .po-chart-box:nth-child(2),
    .products-page-main .po-charts .po-chart-box:nth-child(3){
        height:236px!important;
        min-height:236px!important;
        background:#fff!important;
        border:1px solid var(--prod-v2-kb-border)!important;
        border-radius:14px!important;
        box-shadow:var(--prod-v2-kb-shadow)!important;
        padding:18px!important;
        overflow:visible!important;
    }
    .products-page-main .po-chart-box:hover{
        background:#fff!important;
        border-color:var(--prod-v2-kb-border)!important;
        box-shadow:var(--prod-v2-kb-shadow)!important;
        transform:none!important;
    }
    .products-page-main .po-chart-title{
        margin:0 0 12px!important;
        font-size:15px!important;
        line-height:1.2!important;
    }
    .products-page-main .po-chart-small{
        margin-bottom:7px!important;
    }
    .products-page-main .po-money{
        margin-bottom:8px!important;
    }
    .products-page-main .po-line-chart{
        width:100%!important;
        height:126px!important;
        margin-top:6px!important;
        display:block!important;
        overflow:visible!important;
    }
    .products-page-main .po-chart-flex{
        height:166px!important;
        min-height:166px!important;
        align-items:center!important;
    }

    /* Product cards area spacing stays same UI but cleaner */
    .products-page-main .po-toolbar{
        margin-top:0!important;
        margin-bottom:16px!important;
    }
    .products-page-main .po-products-grid{
        gap:14px!important;
        margin-top:8px!important;
    }

    /* Bottom footer fix: remove duplicate Showing text on the right and align pagination properly */
    .products-page-main .po-footer{
        display:grid!important;
        grid-template-columns:1fr auto 1fr!important;
        align-items:center!important;
        column-gap:16px!important;
        margin-top:22px!important;
        padding:0 0 6px!important;
        color:#334155!important;
        font-size:12px!important;
    }
    .products-page-main .po-footer > span:first-child{
        justify-self:start!important;
        white-space:nowrap!important;
    }
    .products-page-main .po-footer > span:last-child{
        display:none!important;
    }
    .products-page-main .po-pagination{
        justify-self:center!important;
        display:flex!important;
        align-items:center!important;
        justify-content:center!important;
        gap:10px!important;
    }
    .products-page-main .po-page{
        width:32px!important;
        min-width:32px!important;
        height:32px!important;
        min-height:32px!important;
        border-radius:999px!important;
        border:1px solid #d9e1ec!important;
        background:#fff!important;
        color:#07111f!important;
        font-family:'Poppins',sans-serif!important;
        font-size:12px!important;
        font-weight:700!important;
        padding:0!important;
        display:inline-flex!important;
        align-items:center!important;
        justify-content:center!important;
        box-shadow:none!important;
    }
    .products-page-main .po-page.active{
        background:#fff!important;
        border-color:#0b63f6!important;
        color:#0b63f6!important;
    }
    .products-page-main .po-page:hover{
        background:#111827!important;
        border-color:#111827!important;
        color:#fff!important;
    }

    @media(max-width:1280px){
        .products-page-main .po-charts{
            grid-template-columns:1fr!important;
        }
        .products-page-main .po-chart-box,
        .products-page-main .po-charts .po-chart-box:nth-child(1),
        .products-page-main .po-charts .po-chart-box:nth-child(2),
        .products-page-main .po-charts .po-chart-box:nth-child(3){
            height:auto!important;
            min-height:236px!important;
        }
        .products-page-main .po-chart-flex{
            height:auto!important;
            min-height:150px!important;
        }
    }
    @media(max-width:760px){
        .products-page-main .po-date-btn,
        .products-page-main .po-button,
        .products-page-main .po-tab,
        .products-page-main .po-filter-toggle{
            width:100%!important;
            min-width:0!important;
            max-width:none!important;
        }
        .products-page-main .po-footer{
            grid-template-columns:1fr!important;
            row-gap:12px!important;
        }
        .products-page-main .po-footer > span:first-child,
        .products-page-main .po-pagination{
            justify-self:center!important;
        }
    }
</style>


<style id="products-calendar-functional-final-fix">
/* Functional Product Calendar Modal */
.products-page-main .po-calendar-overlay{position:fixed;inset:0;z-index:9000;background:rgba(17,24,39,.38);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;padding:18px;}
.products-page-main .po-calendar-modal{width:min(930px,calc(100vw - 36px));max-height:calc(100vh - 36px);overflow:hidden;background:#fff;border:1px solid #111827;border-radius:18px;box-shadow:0 26px 80px rgba(15,23,42,.24);display:grid;grid-template-columns:minmax(0,1.15fr) 320px;color:#111827;}
.products-page-main .po-calendar-main{padding:18px;border-right:1px solid #e7ebf1;min-width:0;}
.products-page-main .po-calendar-side{padding:18px;background:#fff;min-width:0;overflow:auto;}
.products-page-main .po-calendar-head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;margin-bottom:15px;}
.products-page-main .po-calendar-head h2{font-family:'Poppins',sans-serif;font-size:17px;font-weight:700;margin:0 0 4px;color:#07111f;}
.products-page-main .po-calendar-head p{margin:0;color:#64748b;font-size:11.5px;line-height:1.45;}
.products-page-main .po-calendar-nav{display:flex;align-items:center;gap:7px;}
.products-page-main .po-calendar-icon{width:34px;height:34px;border-radius:999px;border:1px solid #dbe3ee;background:#fff;color:#111827;font-size:20px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;}
.products-page-main .po-calendar-mini,.products-page-main .po-calendar-save,.products-page-main .po-calendar-clear,.products-page-main .po-calendar-event button{height:34px;border-radius:999px;border:1px solid #111827;background:#fff;color:#111827;padding:0 14px;font-family:'Poppins',sans-serif;font-size:11.5px;font-weight:600;cursor:pointer;}
.products-page-main .po-calendar-mini.primary,.products-page-main .po-calendar-save{border:0;background:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%);color:#fff;}
.products-page-main .po-calendar-icon:hover,.products-page-main .po-calendar-mini:hover,.products-page-main .po-calendar-clear:hover,.products-page-main .po-calendar-event button:hover,.products-page-main .po-calendar-save:hover{background:#111827!important;border-color:#111827!important;color:#fff!important;}
.products-page-main .po-calendar-weekdays,.products-page-main .po-calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:7px;}
.products-page-main .po-calendar-weekdays{margin-bottom:7px;}
.products-page-main .po-calendar-weekdays span{text-align:center;font-size:9.5px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:.08em;}
.products-page-main .po-calendar-day{position:relative;min-height:78px;border:1px solid #e1e7f0;border-radius:12px;background:#fff;color:#111827;text-align:left;padding:8px;cursor:pointer;transition:.16s ease;}
.products-page-main .po-calendar-day strong{font-size:12px;font-weight:800;}
.products-page-main .po-calendar-day:hover{border-color:#0b63f6;box-shadow:0 10px 24px rgba(11,99,246,.10);}
.products-page-main .po-calendar-day.is-muted{background:#f9fafb;color:#cbd5e1;cursor:default;}
.products-page-main .po-calendar-day.is-today{background:#eef6ff;border-color:#0b63f6;}
.products-page-main .po-calendar-day.is-selected{background:rgba(17,24,39,.08);border-color:#111827;box-shadow:inset 0 0 0 1px #111827;}
.products-page-main .po-calendar-dots{display:flex;align-items:center;gap:4px;position:absolute;left:8px;bottom:9px;}
.products-page-main .po-calendar-dots i{width:7px;height:7px;border-radius:50%;background:#0b63f6;}
.products-page-main .po-calendar-dots em{font-style:normal;font-size:9px;font-weight:700;color:#64748b;}
.products-page-main .po-calendar-side h3{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;margin:0 0 12px;color:#07111f;}
.products-page-main .po-calendar-list{display:grid;gap:8px;max-height:190px;overflow:auto;margin-bottom:13px;}
.products-page-main .po-calendar-empty{min-height:76px;border:1px dashed #cbd5e1;border-radius:12px;display:grid;place-items:center;text-align:center;color:#64748b;font-size:11px;padding:12px;background:#fff;}
.products-page-main .po-calendar-event{border:1px solid #dde6f2;border-radius:12px;background:#fff;padding:10px;display:grid;gap:6px;}
.products-page-main .po-calendar-event b{font-size:12px;font-weight:800;}
.products-page-main .po-calendar-event small{font-size:10.5px;font-weight:700;color:#0b63f6;}
.products-page-main .po-calendar-event p{font-size:11px;color:#64748b;line-height:1.35;margin:0;}
.products-page-main .po-calendar-event div{display:flex;justify-content:flex-end;gap:6px;}
.products-page-main .po-calendar-event button{height:27px;font-size:9.5px;padding:0 9px;border-color:#dbe3ee;}
.products-page-main .po-calendar-event button.danger{color:#ef2f2f;border-color:#ffd0d0;}
.products-page-main .po-calendar-event button.danger:hover{background:#ef2f2f!important;border-color:#ef2f2f!important;color:#fff!important;}
.products-page-main .po-calendar-form{display:grid;gap:9px;}
.products-page-main .po-calendar-form label{display:grid;gap:5px;}
.products-page-main .po-calendar-form span{font-size:10px;font-weight:800;color:#475569;text-transform:uppercase;letter-spacing:.05em;}
.products-page-main .po-calendar-form input,.products-page-main .po-calendar-form textarea{width:100%;border:1px solid #dbe3ee;border-radius:10px;background:#fff;color:#111827;padding:10px 11px;font-family:'Inter',sans-serif;font-size:12px;outline:none;}
.products-page-main .po-calendar-form textarea{min-height:68px;resize:vertical;}
.products-page-main .po-calendar-form input:focus,.products-page-main .po-calendar-form textarea:focus{border-color:#0b63f6;box-shadow:0 0 0 3px rgba(11,99,246,.10);}
.products-page-main .po-calendar-form-actions{display:flex;justify-content:flex-end;gap:8px;}
.products-page-main .po-calendar-clear{width:86px;}
.products-page-main .po-calendar-save{width:110px;}
.products-page-main .po-date-btn span{display:flex!important;align-items:center!important;justify-content:center!important;gap:8px!important;min-width:0!important;width:100%!important;}
.products-page-main .po-date-btn span b{font-weight:700!important;overflow:hidden!important;text-overflow:ellipsis!important;white-space:nowrap!important;}
@media(max-width:860px){.products-page-main .po-calendar-modal{grid-template-columns:1fr;overflow:auto}.products-page-main .po-calendar-main{border-right:0;border-bottom:1px solid #e7ebf1}.products-page-main .po-calendar-day{min-height:62px}}
</style>


<style id="products-final-v4-calendar-performance-fix">
/* FINAL V4: Product Performance detailed content + Dashboard/Customer/Orders exact calendar/date width */
.products-page-main .po-actions-top{
  width:392px!important;
  max-width:392px!important;
  min-width:392px!important;
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  grid-template-areas:"date date" "export add"!important;
  gap:8px!important;
  align-items:stretch!important;
  justify-content:end!important;
  margin-left:auto!important;
}
.products-page-main .po-date-btn{
  grid-area:date!important;
  width:100%!important;
  min-width:0!important;
  max-width:none!important;
  height:42px!important;
  min-height:42px!important;
  border-radius:8px!important;
  border:1px solid #111827!important;
  background:#fff!important;
  color:#111827!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  gap:10px!important;
  padding:0 15px!important;
  overflow:hidden!important;
}
.products-page-main .po-date-btn > span{
  flex:1 1 auto!important;
  min-width:0!important;
  width:auto!important;
  display:flex!important;
  align-items:center!important;
  justify-content:flex-start!important;
  gap:9px!important;
  overflow:hidden!important;
  color:inherit!important;
}
.products-page-main .po-date-btn b{
  display:block!important;
  min-width:0!important;
  overflow:hidden!important;
  text-overflow:ellipsis!important;
  white-space:nowrap!important;
  font-size:12px!important;
  font-weight:700!important;
  color:inherit!important;
}
.products-page-main .po-date-btn svg{width:16px!important;height:16px!important;stroke:currentColor!important;color:currentColor!important;flex:0 0 auto!important;}
.products-page-main .po-date-btn:hover,.products-page-main .po-date-btn:focus{background:#111827!important;color:#fff!important;border-color:#111827!important;}
.products-page-main .po-action-row{display:contents!important;}
.products-page-main .po-action-row .po-button:first-child{grid-area:export!important;width:100%!important;min-width:0!important;max-width:none!important;}
.products-page-main .po-action-row .po-button.primary{grid-area:add!important;width:100%!important;min-width:0!important;max-width:none!important;}

/* Make Product Performance complete and less plain while keeping same UI style */
.products-page-main .po-charts{grid-template-columns:1.18fr .96fr .96fr!important;align-items:stretch!important;gap:16px!important;}
.products-page-main .po-chart-box{height:250px!important;min-height:250px!important;padding:18px!important;}
.products-page-main .po-performance-box{overflow:hidden!important;}
.products-page-main .po-performance-head{display:flex!important;align-items:flex-start!important;justify-content:space-between!important;gap:14px!important;margin-bottom:10px!important;}
.products-page-main .po-performance-growth{min-width:88px!important;text-align:right!important;font-family:'Poppins',sans-serif!important;}
.products-page-main .po-performance-growth span{display:block!important;color:#12a36a!important;font-size:15px!important;font-weight:800!important;line-height:1!important;}
.products-page-main .po-performance-growth small{display:block!important;color:#64748b!important;font-size:10px!important;font-weight:600!important;margin-top:5px!important;}
.products-page-main .po-performance-mini{display:grid!important;grid-template-columns:repeat(3,1fr)!important;gap:8px!important;margin:8px 0 8px!important;}
.products-page-main .po-performance-mini div{border:1px solid #e8edf5!important;background:#f8fafc!important;border-radius:9px!important;padding:8px 9px!important;min-height:48px!important;}
.products-page-main .po-performance-mini span{display:block!important;color:#64748b!important;font-size:10px!important;font-weight:700!important;margin-bottom:5px!important;}
.products-page-main .po-performance-mini b{display:block!important;color:#07111f!important;font-family:'Poppins',sans-serif!important;font-size:17px!important;font-weight:800!important;line-height:1!important;}
.products-page-main .po-performance-box .po-line-chart{height:92px!important;margin-top:2px!important;display:block!important;}
.products-page-main .po-chart-flex{height:178px!important;}
.products-page-main .po-donut{width:136px!important;height:136px!important;}

/* Calendar modal copied to Dashboard/Customer/Orders scale and structure */
.products-page-main .po-calendar-overlay{
  position:fixed!important;
  inset:0!important;
  z-index:9000!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  padding:18px!important;
  background:rgba(17,24,39,.36)!important;
  backdrop-filter:blur(9px)!important;
  -webkit-backdrop-filter:blur(9px)!important;
}
.products-page-main .po-calendar-modal{
  width:min(980px,calc(100vw - 48px))!important;
  max-height:calc(100vh - 42px)!important;
  overflow:hidden!important;
  border:1.2px solid #111827!important;
  border-radius:18px!important;
  background:#fff!important;
  box-shadow:0 26px 80px rgba(15,23,42,.22)!important;
  display:grid!important;
  grid-template-columns:minmax(0,650px) 330px!important;
  color:#111827!important;
}
.products-page-main .po-calendar-main{padding:18px 18px 20px!important;border-right:1px solid #e8edf5!important;background:#fff!important;min-width:0!important;}
.products-page-main .po-calendar-side{padding:18px!important;background:#fff!important;min-width:0!important;}
.products-page-main .po-calendar-head{display:grid!important;grid-template-columns:minmax(160px,1fr) auto!important;gap:14px!important;align-items:start!important;margin-bottom:16px!important;}
.products-page-main .po-calendar-head h2{margin:0 0 3px!important;font-family:'Poppins',sans-serif!important;font-size:16px!important;font-weight:700!important;color:#111827!important;line-height:1.2!important;}
.products-page-main .po-calendar-head p{width:190px!important;margin:0!important;font-size:11px!important;font-weight:400!important;line-height:1.45!important;color:#6b7280!important;}
.products-page-main .po-calendar-nav{display:flex!important;align-items:center!important;justify-content:center!important;gap:12px!important;padding-top:4px!important;}
.products-page-main .po-calendar-icon{width:34px!important;height:34px!important;min-width:34px!important;padding:0!important;border:0!important;border-radius:999px!important;background:#fff!important;color:#111827!important;font-size:22px!important;line-height:1!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;box-shadow:none!important;}
.products-page-main .po-calendar-icon:hover,.products-page-main .po-calendar-icon:focus{background:#f4f6f9!important;color:#111827!important;}
.products-page-main .po-calendar-mini,.products-page-main .po-calendar-clear,.products-page-main .po-calendar-save,.products-page-main .po-calendar-event button{
  height:34px!important;min-height:34px!important;border-radius:999px!important;font-family:'Poppins',sans-serif!important;font-size:11.5px!important;font-weight:600!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;gap:6px!important;box-shadow:none!important;transform:none!important;
}
.products-page-main .po-calendar-mini{min-width:86px!important;padding:0 18px!important;border:1px solid #111827!important;background:#fff!important;color:#111827!important;}
.products-page-main .po-calendar-mini.primary{background:#0b63f6!important;color:#fff!important;border-color:#0b63f6!important;}
.products-page-main .po-calendar-mini:hover,.products-page-main .po-calendar-clear:hover,.products-page-main .po-calendar-event button:hover{background:#111827!important;color:#fff!important;border-color:#111827!important;}
.products-page-main .po-calendar-weekdays,.products-page-main .po-calendar-grid{display:grid!important;grid-template-columns:repeat(7,minmax(0,1fr))!important;gap:7px!important;}
.products-page-main .po-calendar-weekdays{margin-bottom:7px!important;}
.products-page-main .po-calendar-weekdays span{text-align:center!important;font-size:9.5px!important;font-weight:800!important;color:#6b7280!important;letter-spacing:.08em!important;text-transform:uppercase!important;}
.products-page-main .po-calendar-day{min-height:78px!important;border:1px solid #e8edf5!important;border-radius:12px!important;background:#fff!important;padding:8px!important;text-align:left!important;color:#111827!important;box-shadow:none!important;position:relative!important;}
.products-page-main .po-calendar-day:hover,.products-page-main .po-calendar-day:focus{border-color:#0b63f6!important;box-shadow:0 10px 24px rgba(11,99,246,.10)!important;}
.products-page-main .po-calendar-day.is-today{border-color:#0b63f6!important;background:#f7fbff!important;}
.products-page-main .po-calendar-day.is-selected{border-color:#111827!important;background:rgba(17,24,39,.08)!important;box-shadow:inset 0 0 0 1px #111827!important;}
.products-page-main .po-calendar-day.is-muted{background:#fafafa!important;color:#a1a1aa!important;cursor:default!important;}
.products-page-main .po-calendar-day strong{font-size:12px!important;font-weight:800!important;}
.products-page-main .po-calendar-dots{display:flex!important;flex-wrap:wrap!important;gap:4px!important;margin-top:18px!important;}
.products-page-main .po-calendar-dots i{width:7px!important;height:7px!important;border-radius:999px!important;background:#0b63f6!important;box-shadow:0 0 0 3px rgba(11,99,246,.10)!important;}
.products-page-main .po-calendar-dots em{font-size:9px!important;color:#6b7280!important;font-style:normal!important;font-weight:700!important;}
.products-page-main .po-calendar-side h3{margin:0 0 14px!important;font-family:'Poppins',sans-serif!important;font-size:16px!important;font-weight:700!important;color:#111827!important;}
.products-page-main .po-calendar-list{display:grid!important;gap:8px!important;max-height:176px!important;overflow:auto!important;margin-bottom:12px!important;}
.products-page-main .po-calendar-empty{min-height:74px!important;border:1px dashed #d8dee8!important;border-radius:12px!important;display:grid!important;place-items:center!important;text-align:center!important;color:#6b7280!important;font-size:11px!important;font-weight:400!important;line-height:1.45!important;padding:12px!important;background:#fff!important;}
.products-page-main .po-calendar-event{border:1px solid #e8edf5!important;border-radius:12px!important;background:#fff!important;padding:10px!important;display:grid!important;gap:7px!important;}
.products-page-main .po-calendar-event b{font-size:12px!important;font-weight:800!important;color:#111827!important;line-height:1.3!important;}
.products-page-main .po-calendar-event small{font-size:10px!important;font-weight:700!important;color:#0b63f6!important;}
.products-page-main .po-calendar-event p{font-size:10.5px!important;font-weight:400!important;color:#6b7280!important;line-height:1.45!important;margin:0!important;}
.products-page-main .po-calendar-event div{display:flex!important;gap:6px!important;justify-content:flex-end!important;}
.products-page-main .po-calendar-event button{height:27px!important;min-height:27px!important;min-width:auto!important;padding:0 9px!important;border:1px solid #e8edf5!important;background:#fff!important;color:#111827!important;font-size:9.5px!important;}
.products-page-main .po-calendar-event button.danger{border-color:#ef4444!important;color:#ef4444!important;}
.products-page-main .po-calendar-event button.danger:hover{background:#ef4444!important;border-color:#ef4444!important;color:#fff!important;}
.products-page-main .po-calendar-form{display:grid!important;gap:10px!important;}
.products-page-main .po-calendar-form label{display:grid!important;gap:5px!important;}
.products-page-main .po-calendar-form label span{font-size:10px!important;font-weight:800!important;color:#4b5563!important;letter-spacing:.05em!important;text-transform:uppercase!important;}
.products-page-main .po-calendar-form input,.products-page-main .po-calendar-form textarea{width:100%!important;border:1px solid #e8edf5!important;border-radius:10px!important;background:#fff!important;padding:10px 11px!important;color:#111827!important;font-family:'Inter',sans-serif!important;font-size:12px!important;font-weight:500!important;outline:none!important;box-shadow:none!important;}
.products-page-main .po-calendar-form textarea{min-height:68px!important;resize:vertical!important;}
.products-page-main .po-calendar-form input:focus,.products-page-main .po-calendar-form textarea:focus{border-color:#0b63f6!important;box-shadow:0 0 0 3px rgba(11,99,246,.10)!important;}
.products-page-main .po-calendar-form-actions{display:flex!important;align-items:center!important;justify-content:flex-end!important;gap:8px!important;margin-top:0!important;}
.products-page-main .po-calendar-clear{width:92px!important;min-width:92px!important;border:1px solid #111827!important;background:#fff!important;color:#111827!important;}
.products-page-main .po-calendar-save{width:124px!important;min-width:124px!important;border:0!important;background:#0b63f6!important;color:#fff!important;}
.products-page-main .po-calendar-save:hover{background:#111827!important;color:#fff!important;}

@media(max-width:1280px){.products-page-main .po-charts{grid-template-columns:1fr!important}.products-page-main .po-chart-box{height:auto!important;min-height:250px!important}.products-page-main .po-chart-flex{height:auto!important;min-height:178px!important}}
@media(max-width:920px){.products-page-main .po-calendar-modal{grid-template-columns:1fr!important;width:min(720px,calc(100vw - 32px))!important;overflow:auto!important}.products-page-main .po-calendar-main{border-right:0!important;border-bottom:1px solid #e8edf5!important}.products-page-main .po-calendar-side{background:#fff!important}.products-page-main .po-calendar-head{grid-template-columns:1fr!important}.products-page-main .po-calendar-nav{justify-content:space-between!important}}
@media(max-width:760px){.products-page-main .po-actions-top{width:100%!important;min-width:0!important;max-width:none!important;grid-template-columns:1fr 1fr!important}.products-page-main .po-performance-mini{grid-template-columns:1fr!important}.products-page-main .po-date-btn{width:100%!important}.products-page-main .po-action-row .po-button:first-child,.products-page-main .po-action-row .po-button.primary{width:100%!important}.products-page-main .po-calendar-day{min-height:62px!important}}
</style>

<!-- =========================================================
     FINAL PRODUCTS PATCH V5
     - Add just enough height to Product Performance, Top Selling Category,
       and Inventory Status so content is complete and not clipped.
     - Calendar/date width now matches Dashboard exact compact width.
     - Keep same UI/design; only spacing/height/width fixes.
========================================================== -->
<style id="products-v5-calendar-width-chart-height-final">
    .products-page-main{
        --products-dashboard-date-width:265px;
        --products-dashboard-btn-width:128px;
        --products-dashboard-btn-height:34px;
        --products-black:#111827;
        --products-blue:#0b63f6;
    }

    /* Exact Dashboard-style header actions: compact date on top, two buttons below */
    .products-page-main .po-actions-top{
        display:grid!important;
        grid-template-columns:var(--products-dashboard-btn-width) var(--products-dashboard-btn-width)!important;
        grid-template-areas:
            "date date"
            "export add"!important;
        gap:9px!important;
        width:var(--products-dashboard-date-width)!important;
        min-width:var(--products-dashboard-date-width)!important;
        max-width:var(--products-dashboard-date-width)!important;
        align-items:stretch!important;
        justify-content:end!important;
        justify-items:stretch!important;
        margin-left:auto!important;
    }

    .products-page-main .po-date-btn{
        grid-area:date!important;
        width:var(--products-dashboard-date-width)!important;
        min-width:var(--products-dashboard-date-width)!important;
        max-width:var(--products-dashboard-date-width)!important;
        height:42px!important;
        min-height:42px!important;
        padding:0 14px!important;
        border-radius:8px!important;
        border:1px solid var(--products-black)!important;
        background:#fff!important;
        background-image:none!important;
        color:var(--products-black)!important;
        box-shadow:none!important;
        display:grid!important;
        grid-template-columns:18px minmax(0,1fr) 16px!important;
        align-items:center!important;
        column-gap:10px!important;
        justify-content:stretch!important;
        overflow:hidden!important;
        white-space:nowrap!important;
    }

    .products-page-main .po-date-btn > span{
        min-width:0!important;
        width:100%!important;
        display:flex!important;
        align-items:center!important;
        justify-content:center!important;
        gap:8px!important;
        overflow:hidden!important;
        text-align:center!important;
        font-size:12px!important;
        font-weight:700!important;
        color:inherit!important;
    }

    .products-page-main .po-date-btn > span svg,
    .products-page-main .po-date-btn > svg{
        width:16px!important;
        height:16px!important;
        stroke:currentColor!important;
        color:currentColor!important;
        flex:0 0 auto!important;
    }

    .products-page-main .po-date-btn b,
    .products-page-main .po-date-btn .po-date-label,
    .products-page-main .po-date-btn span span{
        min-width:0!important;
        overflow:hidden!important;
        text-overflow:ellipsis!important;
        white-space:nowrap!important;
        text-align:center!important;
    }

    .products-page-main .po-date-btn:hover,
    .products-page-main .po-date-btn:focus{
        background:var(--products-black)!important;
        color:#fff!important;
        border-color:var(--products-black)!important;
        box-shadow:none!important;
        transform:none!important;
    }

    .products-page-main .po-actions-top .po-button:not(.primary){
        grid-area:export!important;
    }

    .products-page-main .po-actions-top .po-button.primary{
        grid-area:add!important;
    }

    .products-page-main .po-actions-top .po-button{
        width:var(--products-dashboard-btn-width)!important;
        min-width:var(--products-dashboard-btn-width)!important;
        max-width:var(--products-dashboard-btn-width)!important;
        height:var(--products-dashboard-btn-height)!important;
        min-height:var(--products-dashboard-btn-height)!important;
        border-radius:999px!important;
        padding:0 14px!important;
        font-size:11.5px!important;
        font-weight:500!important;
        display:inline-flex!important;
        align-items:center!important;
        justify-content:center!important;
        gap:6px!important;
        white-space:nowrap!important;
        box-shadow:none!important;
        transform:none!important;
    }

    .products-page-main .po-actions-top .po-button svg{
        width:16px!important;
        height:16px!important;
        flex:0 0 auto!important;
    }

    /* Sakto lang na dagdag height sa 3 boxes para walang putol/clipping */
    .products-page-main .po-charts{
        align-items:stretch!important;
        gap:16px!important;
        margin-bottom:24px!important;
    }

    .products-page-main .po-charts .po-chart-box,
    .products-page-main .po-performance-box{
        height:288px!important;
        min-height:288px!important;
        padding:18px!important;
        overflow:hidden!important;
        background:#fff!important;
        border:1px solid #DDE6F2!important;
        border-radius:14px!important;
        box-shadow:0 10px 25px rgba(15,23,42,0.045)!important;
    }

    .products-page-main .po-charts .po-chart-box:hover,
    .products-page-main .po-performance-box:hover{
        background:#fff!important;
        border-color:#DDE6F2!important;
        box-shadow:0 10px 25px rgba(15,23,42,0.045)!important;
        transform:none!important;
    }

    .products-page-main .po-performance-box{
        display:flex!important;
        flex-direction:column!important;
    }

    .products-page-main .po-performance-mini{
        margin:10px 0 8px!important;
        flex:0 0 auto!important;
    }

    .products-page-main .po-line-area,
    .products-page-main .po-performance-chart,
    .products-page-main .po-chart-area{
        flex:1 1 auto!important;
        min-height:104px!important;
        height:auto!important;
        margin-top:6px!important;
        overflow:visible!important;
    }

    .products-page-main .po-performance-box svg,
    .products-page-main .po-line-area svg,
    .products-page-main .po-performance-chart svg,
    .products-page-main .po-chart-area svg{
        height:112px!important;
        max-height:112px!important;
        overflow:visible!important;
    }

    .products-page-main .po-chart-flex{
        height:210px!important;
        min-height:210px!important;
        align-items:center!important;
    }

    .products-page-main .po-donut{
        width:148px!important;
        height:148px!important;
        flex:0 0 148px!important;
    }

    .products-page-main .po-donut-center{
        width:80px!important;
        height:80px!important;
    }

    .products-page-main .po-legend{
        gap:13px!important;
    }

    /* Give tabs/search row breathing room under taller analytics cards */
    .products-page-main .po-toolbar,
    .products-page-main .po-product-tabs,
    .products-page-main .po-search-filter{
        position:relative!important;
        z-index:1!important;
    }

    @media(max-width:1280px){
        .products-page-main .po-actions-top{
            align-self:flex-end!important;
        }
        .products-page-main .po-charts .po-chart-box,
        .products-page-main .po-performance-box{
            height:auto!important;
            min-height:288px!important;
        }
        .products-page-main .po-chart-flex{
            height:auto!important;
            min-height:210px!important;
        }
    }

    @media(max-width:760px){
        .products-page-main .po-actions-top{
            width:100%!important;
            min-width:0!important;
            max-width:none!important;
            grid-template-columns:1fr 1fr!important;
        }
        .products-page-main .po-date-btn{
            width:100%!important;
            min-width:0!important;
            max-width:none!important;
        }
        .products-page-main .po-actions-top .po-button{
            width:100%!important;
            min-width:0!important;
            max-width:none!important;
        }
        .products-page-main .po-charts .po-chart-box,
        .products-page-main .po-performance-box{
            min-height:300px!important;
        }
    }
</style>


<!-- =========================================================
     FINAL PRODUCTS PATCH V6 - match target UI screenshot
     - Date text visible; exact Dashboard-like compact date width
     - Product Performance no longer clipped/plain; clean chart with axis/labels
     - 3 analytics boxes same Knowledge Base Management style and enough height
     - Product cards in 6-column layout like reference; all 16 products visible
     - Bottom footer fixed: one showing text on right only
========================================================== -->
<style id="products-final-v6-match-reference-ui">
    .products-page-main{
        --po-v6-blue:#0b63f6!important;
        --po-v6-blue-dark:#084ac2!important;
        --po-v6-black:#111827!important;
        --po-v6-line:#DDE6F2!important;
        --po-v6-soft:#F8FAFC!important;
        --po-v6-shadow:0 10px 25px rgba(15,23,42,0.045)!important;
        padding:32px 32px 42px!important;
        background:#fff!important;
    }

    .products-page-main .products-shell{
        max-width:1480px!important;
        margin:0 auto!important;
    }

    .products-page-main .po-header{
        margin-bottom:24px!important;
        align-items:flex-start!important;
    }

    /* EXACT dashboard/customer/orders-style top controls */
    .products-page-main .po-actions-top{
        width:392px!important;
        min-width:392px!important;
        max-width:392px!important;
        display:grid!important;
        grid-template-columns:1fr 1fr!important;
        grid-template-areas:"date date" "export add"!important;
        gap:8px!important;
        align-items:stretch!important;
        justify-content:end!important;
        justify-items:stretch!important;
        margin-left:auto!important;
    }

    .products-page-main .po-date-btn{
        grid-area:date!important;
        width:100%!important;
        min-width:0!important;
        max-width:none!important;
        height:42px!important;
        min-height:42px!important;
        border-radius:8px!important;
        border:1.4px solid var(--po-v6-black)!important;
        background:#fff!important;
        background-image:none!important;
        color:var(--po-v6-black)!important;
        box-shadow:none!important;
        padding:0 14px!important;
        display:flex!important;
        align-items:center!important;
        justify-content:space-between!important;
        gap:10px!important;
        overflow:hidden!important;
        white-space:nowrap!important;
        font-family:'Inter',system-ui,sans-serif!important;
        font-size:12px!important;
        font-weight:700!important;
        line-height:1!important;
    }

    .products-page-main .po-date-btn > span{
        flex:1 1 auto!important;
        min-width:0!important;
        width:auto!important;
        display:flex!important;
        align-items:center!important;
        justify-content:flex-start!important;
        gap:9px!important;
        overflow:hidden!important;
        color:inherit!important;
        text-align:left!important;
    }

    .products-page-main .po-date-btn > span b{
        display:inline-block!important;
        min-width:0!important;
        max-width:100%!important;
        overflow:hidden!important;
        text-overflow:ellipsis!important;
        white-space:nowrap!important;
        color:inherit!important;
        font-size:12px!important;
        font-weight:700!important;
        line-height:1!important;
        opacity:1!important;
        visibility:visible!important;
    }

    .products-page-main .po-date-btn svg{
        width:16px!important;
        height:16px!important;
        stroke:currentColor!important;
        color:currentColor!important;
        flex:0 0 auto!important;
        opacity:1!important;
        visibility:visible!important;
    }

    .products-page-main .po-date-btn:hover,
    .products-page-main .po-date-btn:focus{
        background:var(--po-v6-black)!important;
        border-color:var(--po-v6-black)!important;
        color:#fff!important;
    }

    .products-page-main .po-action-row{display:contents!important;}
    .products-page-main .po-action-row .po-button:first-child,
    .products-page-main .po-actions-top .po-button:not(.primary){
        grid-area:export!important;
        width:100%!important;
        min-width:0!important;
        max-width:none!important;
    }
    .products-page-main .po-action-row .po-button.primary,
    .products-page-main .po-actions-top .po-button.primary{
        grid-area:add!important;
        width:100%!important;
        min-width:0!important;
        max-width:none!important;
    }

    .products-page-main .po-actions-top .po-button,
    .products-page-main .po-tab,
    .products-page-main .po-filter-toggle,
    .products-page-main .po-card-action{
        height:36px!important;
        min-height:36px!important;
        border-radius:999px!important;
        font-size:12px!important;
        font-weight:600!important;
        padding:0 14px!important;
        box-shadow:none!important;
        transform:none!important;
    }

    .products-page-main .po-actions-top .po-button.primary,
    .products-page-main .po-tab.active{
        background:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;
        color:#fff!important;
        border:0!important;
    }

    .products-page-main .po-actions-top .po-button:not(.primary),
    .products-page-main .po-tab:not(.active),
    .products-page-main .po-filter-toggle{
        background:#fff!important;
        color:var(--po-v6-black)!important;
        border:1.4px solid var(--po-v6-black)!important;
    }

    .products-page-main .po-actions-top .po-button:hover,
    .products-page-main .po-tab:hover,
    .products-page-main .po-filter-toggle:hover,
    .products-page-main .po-card-action:hover{
        background:var(--po-v6-black)!important;
        border-color:var(--po-v6-black)!important;
        color:#fff!important;
    }

    /* Metrics and charts spacing like target screenshot */
    .products-page-main .po-grid-stats{
        grid-template-columns:repeat(4,minmax(0,1fr))!important;
        gap:22px!important;
        margin-bottom:18px!important;
    }

    .products-page-main .po-charts{
        grid-template-columns:1.16fr .98fr .98fr!important;
        gap:16px!important;
        margin-bottom:16px!important;
        align-items:stretch!important;
    }

    .products-page-main .po-charts .po-chart-box{
        height:230px!important;
        min-height:230px!important;
        padding:18px 20px!important;
        background:#fff!important;
        border:1px solid var(--po-v6-line)!important;
        border-radius:14px!important;
        box-shadow:var(--po-v6-shadow)!important;
        overflow:hidden!important;
        position:relative!important;
    }

    .products-page-main .po-charts .po-chart-box:hover{
        background:#fff!important;
        border-color:var(--po-v6-line)!important;
        box-shadow:var(--po-v6-shadow)!important;
        transform:none!important;
    }

    /* Product Performance: follow reference layout, no mini boxes cutting chart */
    .products-page-main .po-performance-box{
        display:grid!important;
        grid-template-rows:auto auto minmax(0,1fr)!important;
        height:230px!important;
        min-height:230px!important;
        padding:18px 20px 16px!important;
    }

    .products-page-main .po-performance-box .po-live{
        position:absolute!important;
        right:18px!important;
        top:18px!important;
        float:none!important;
        background:#eaf8f0!important;
        color:#0f9f63!important;
        border-radius:7px!important;
        height:22px!important;
        padding:0 8px!important;
        display:flex!important;
        align-items:center!important;
        gap:6px!important;
        font-size:10px!important;
        font-weight:800!important;
    }

    .products-page-main .po-performance-box .po-chart-title{
        margin:0 0 8px!important;
        padding-right:70px!important;
    }

    .products-page-main .po-performance-head{
        display:block!important;
        margin:0 0 6px!important;
    }

    .products-page-main .po-performance-growth,
    .products-page-main .po-performance-mini{
        display:none!important;
    }

    .products-page-main .po-chart-small{
        font-size:12px!important;
        margin:0 0 8px!important;
        color:#64748b!important;
    }

    .products-page-main .po-money{
        font-size:23px!important;
        margin:0 0 6px!important;
        line-height:1.05!important;
    }

    .products-page-main .po-performance-box::before{
        content:'2250\A1500\A750\A0';
        white-space:pre!important;
        position:absolute!important;
        left:20px!important;
        bottom:34px!important;
        height:94px!important;
        display:flex!important;
        flex-direction:column!important;
        justify-content:space-between!important;
        color:#334155!important;
        font-size:11px!important;
        font-weight:600!important;
        line-height:1!important;
        pointer-events:none!important;
    }

    .products-page-main .po-performance-box::after{
        content:'May 31      Jun 1      Jun 2      Jun 3      Jun 4      Jun 5      Jun 6';
        position:absolute!important;
        left:65px!important;
        right:20px!important;
        bottom:13px!important;
        color:#334155!important;
        font-size:11px!important;
        font-weight:600!important;
        white-space:pre!important;
        overflow:hidden!important;
        pointer-events:none!important;
    }

    .products-page-main .po-performance-box .po-line-chart{
        width:calc(100% - 42px)!important;
        height:104px!important;
        margin:2px 0 0 42px!important;
        align-self:end!important;
        display:block!important;
        overflow:visible!important;
        transform:none!important;
    }

    .products-page-main .po-performance-box .po-line-chart path[stroke],
    .products-page-main .po-performance-box .po-line-chart circle{
        vector-effect:non-scaling-stroke!important;
    }

    .products-page-main .po-chart-flex{
        height:168px!important;
        min-height:168px!important;
        gap:26px!important;
        align-items:center!important;
        justify-content:center!important;
    }

    .products-page-main .po-donut{
        width:138px!important;
        height:138px!important;
        flex:0 0 138px!important;
    }

    .products-page-main .po-donut:after{inset:36px!important;}
    .products-page-main .po-donut-center strong{font-size:20px!important;}
    .products-page-main .po-donut-center span{font-size:11px!important;}
    .products-page-main .po-legend{gap:13px!important;}
    .products-page-main .po-legend-row{font-size:13px!important;}

    /* Toolbar/cards like target screenshot */
    .products-page-main .po-toolbar{
        margin:0 0 14px!important;
        display:grid!important;
        grid-template-columns:auto 1fr auto!important;
        gap:18px!important;
        align-items:center!important;
    }

    .products-page-main .po-tabs{gap:12px!important;}
    .products-page-main .po-tab{width:128px!important;}
    .products-page-main .po-search{height:38px!important;width:300px!important;border-radius:8px!important;}
    .products-page-main .po-filter-toggle{height:38px!important;width:126px!important;border-radius:8px!important;}

    .products-page-main .po-products-grid{
        grid-template-columns:repeat(6,minmax(0,1fr))!important;
        gap:16px!important;
        margin-top:10px!important;
    }

    .products-page-main .po-product-card{
        min-height:244px!important;
        border-radius:8px!important;
    }

    .products-page-main .po-product-image{
        height:78px!important;
    }

    .products-page-main .po-product-body{
        padding:9px 10px 10px!important;
        gap:4px!important;
    }

    .products-page-main .po-product-name{font-size:12px!important;}
    .products-page-main .po-product-desc{font-size:10.5px!important;min-height:32px!important;-webkit-line-clamp:3!important;}
    .products-page-main .po-card-actions{gap:8px!important;margin-top:6px!important;}
    .products-page-main .po-card-action{height:30px!important;border-radius:6px!important;}

    /* Footer: remove duplicate left showing; keep pagination center + showing right */
    .products-page-main .po-footer{
        display:grid!important;
        grid-template-columns:1fr auto 1fr!important;
        align-items:center!important;
        margin-top:18px!important;
        padding:0 2px!important;
    }

    .products-page-main .po-footer > span:first-child{
        visibility:hidden!important;
    }

    .products-page-main .po-footer .po-showing,
    .products-page-main .po-footer > span:last-child{
        justify-self:end!important;
        visibility:visible!important;
    }

    .products-page-main .po-pagination{
        justify-self:center!important;
        gap:8px!important;
    }

    .products-page-main .po-page{
        height:34px!important;
        min-width:34px!important;
        border-radius:8px!important;
        background:#fff!important;
        border:1.4px solid #d8e0ea!important;
        color:#07111f!important;
    }

    .products-page-main .po-page.active{
        background:#fff!important;
        border-color:var(--po-v6-blue)!important;
        color:var(--po-v6-blue)!important;
        box-shadow:0 0 0 2px rgba(11,99,246,.08)!important;
    }

    /* Calendar modal same width/style as Dashboard/Customer/Orders */
    .products-page-main .po-calendar-modal{
        width:min(980px,calc(100vw - 48px))!important;
        max-height:calc(100vh - 42px)!important;
        border:1.2px solid var(--po-v6-black)!important;
        border-radius:18px!important;
        display:grid!important;
        grid-template-columns:minmax(0,650px) 330px!important;
        background:#fff!important;
        box-shadow:0 26px 80px rgba(15,23,42,.22)!important;
        overflow:hidden!important;
    }

    @media(max-width:1380px){
        .products-page-main .po-products-grid{grid-template-columns:repeat(5,minmax(0,1fr))!important;}
    }
    @media(max-width:1280px){
        .products-page-main .po-charts{grid-template-columns:1fr!important;}
        .products-page-main .po-charts .po-chart-box,
        .products-page-main .po-performance-box{height:auto!important;min-height:230px!important;}
        .products-page-main .po-chart-flex{height:auto!important;min-height:168px!important;}
    }
    @media(max-width:920px){
        .products-page-main .po-calendar-modal{grid-template-columns:1fr!important;width:min(720px,calc(100vw - 32px))!important;overflow:auto!important;}
        .products-page-main .po-products-grid{grid-template-columns:repeat(2,minmax(0,1fr))!important;}
    }
    @media(max-width:760px){
        .products-page-main{padding:20px 16px 32px!important;}
        .products-page-main .po-header{flex-direction:column!important;}
        .products-page-main .po-actions-top{width:100%!important;min-width:0!important;max-width:none!important;grid-template-columns:1fr 1fr!important;}
        .products-page-main .po-products-grid{grid-template-columns:1fr!important;}
        .products-page-main .po-grid-stats{grid-template-columns:1fr!important;}
        .products-page-main .po-toolbar{grid-template-columns:1fr!important;}
        .products-page-main .po-search-filter{justify-self:stretch!important;}
        .products-page-main .po-search{width:100%!important;}
        .products-page-main .po-filter-toggle{width:120px!important;}
    }
</style>


<!-- =========================================================
     FINAL V7 PRODUCT GRID PATCH
     - Show only 13 product boxes
     - 4 boxes per row/line on desktop
     - Hidden remaining products from display/counts
========================================================== -->
<style id="products-v7-thirteen-boxes-four-columns-final">
    .products-page-main .po-products-grid{
        display:grid!important;
        grid-template-columns:repeat(4,minmax(0,1fr))!important;
        gap:16px!important;
        margin-top:10px!important;
    }

    .products-page-main .po-product-card{
        min-height:250px!important;
        height:auto!important;
    }

    .products-page-main .po-product-image{
        height:92px!important;
    }

    .products-page-main .po-product-body{
        min-height:154px!important;
    }

    .products-page-main .po-footer{
        grid-template-columns:1fr auto 1fr!important;
    }

    .products-page-main .po-footer > span:first-child{
        visibility:hidden!important;
    }

    .products-page-main .po-footer > span:last-child{
        display:block!important;
        visibility:visible!important;
        justify-self:end!important;
        white-space:nowrap!important;
    }

    @media(max-width:1180px){
        .products-page-main .po-products-grid{grid-template-columns:repeat(3,minmax(0,1fr))!important;}
    }

    @media(max-width:920px){
        .products-page-main .po-products-grid{grid-template-columns:repeat(2,minmax(0,1fr))!important;}
    }

    @media(max-width:760px){
        .products-page-main .po-products-grid{grid-template-columns:1fr!important;}
    }
</style>


<!-- =========================================================
     FINAL V8 PRODUCT CARD SPACING PATCH
     - Reduce text/button spacing inside each product card
     - Make product image the priority/visual focus
     - Keep 13 boxes and 4-column layout from V7
========================================================== -->
<style id="products-v8-image-priority-card-spacing-final">
    .products-page-main .po-products-grid{
        grid-template-columns:repeat(4,minmax(0,1fr))!important;
        gap:14px!important;
        margin-top:10px!important;
    }

    .products-page-main .po-product-card{
        min-height:236px!important;
        height:236px!important;
        border-radius:8px!important;
        overflow:hidden!important;
        display:flex!important;
        flex-direction:column!important;
    }

    /* Mas malaki ang image area; dito ang focus ng card. */
    .products-page-main .po-product-image{
        height:124px!important;
        min-height:124px!important;
        flex:0 0 124px!important;
        border-bottom:1px solid #07111f!important;
    }

    .products-page-main .po-product-image img{
        width:100%!important;
        height:100%!important;
        object-fit:cover!important;
        display:block!important;
    }

    /* Pinakaliit na spacing sa content area para hindi kumain ng space. */
    .products-page-main .po-product-body{
        flex:1 1 auto!important;
        min-height:0!important;
        padding:6px 8px 7px!important;
        gap:2px!important;
        display:flex!important;
        flex-direction:column!important;
        justify-content:flex-start!important;
    }

    .products-page-main .po-product-name{
        font-size:11.5px!important;
        line-height:1.05!important;
        margin:0!important;
        padding:0!important;
        white-space:nowrap!important;
        overflow:hidden!important;
        text-overflow:ellipsis!important;
    }

    .products-page-main .po-product-desc{
        font-size:9.6px!important;
        line-height:1.08!important;
        margin:0!important;
        padding:0!important;
        min-height:20px!important;
        max-height:21px!important;
        -webkit-line-clamp:2!important;
        overflow:hidden!important;
        color:#334155!important;
    }

    .products-page-main .po-product-row{
        margin-top:2px!important;
        gap:6px!important;
        min-height:20px!important;
        align-items:center!important;
    }

    .products-page-main .po-price{
        font-size:12.5px!important;
        line-height:1!important;
        margin:0!important;
        padding:0!important;
        white-space:nowrap!important;
    }

    .products-page-main .po-stock{
        height:18px!important;
        min-height:18px!important;
        padding:0 6px!important;
        border-radius:5px!important;
        font-size:8.8px!important;
        line-height:1!important;
        white-space:nowrap!important;
    }

    .products-page-main .po-card-actions{
        display:grid!important;
        grid-template-columns:1fr 1fr!important;
        gap:6px!important;
        margin-top:5px!important;
    }

    .products-page-main .po-card-action{
        height:24px!important;
        min-height:24px!important;
        border-radius:999px!important;
        font-size:9.5px!important;
        padding:0 7px!important;
        gap:4px!important;
    }

    .products-page-main .po-card-action svg{
        width:12px!important;
        height:12px!important;
    }

    .products-page-main .po-footer{
        margin-top:14px!important;
    }

    @media(max-width:1180px){
        .products-page-main .po-products-grid{grid-template-columns:repeat(3,minmax(0,1fr))!important;}
        .products-page-main .po-product-card{height:238px!important;}
        .products-page-main .po-product-image{height:126px!important;min-height:126px!important;flex-basis:126px!important;}
    }

    @media(max-width:920px){
        .products-page-main .po-products-grid{grid-template-columns:repeat(2,minmax(0,1fr))!important;}
        .products-page-main .po-product-card{height:250px!important;}
        .products-page-main .po-product-image{height:138px!important;min-height:138px!important;flex-basis:138px!important;}
    }

    @media(max-width:760px){
        .products-page-main .po-products-grid{grid-template-columns:1fr!important;}
        .products-page-main .po-product-card{height:auto!important;min-height:260px!important;}
        .products-page-main .po-product-image{height:152px!important;min-height:152px!important;flex-basis:152px!important;}
    }
</style>
