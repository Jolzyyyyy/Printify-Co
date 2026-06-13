<style>
    :root {
        --hc-blue: #0B63F6;
        --hc-blue-dark: #084AC2;
        --hc-orange: #FF7A00;
        --hc-green: #16A34A;
        --hc-red: #EF4444;
        --hc-purple: #7C3AED;
        --hc-black: #111827;
        --hc-title: #0F172A;
        --hc-text: #1E293B;
        --hc-muted: #64748B;
        --hc-border: #D8DEE8;
        --hc-soft-border: #E8EDF5;
        --hc-bg: #F8FAFC;
        --hc-card: #FFFFFF;
        --hc-blue-gradient: linear-gradient(135deg, #1274FF 0%, #0B63F6 54%, #084AC2 100%);
        --hc-green-gradient: linear-gradient(135deg, #22C55E 0%, #16A34A 100%);
        --hc-shadow: 0 5px 18px rgba(5, 8, 22, 0.04);
    }

    .hc-admin-wrapper,
    .hc-admin-wrapper * {
        box-sizing: border-box;
    }

    .hc-admin-wrapper {
        width: 100%;
        max-width: 1360px;
        margin: 0 auto;
        padding: 18px 22px 28px;
        color: var(--hc-text);
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .hc-page-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 18px;
        margin-bottom: 15px;
    }

    .hc-title-wrap {
        position: relative;
        padding-top: 12px;
    }

    .hc-title-wrap::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 68px;
        height: 4px;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--hc-blue), #4A90FF);
    }

    .hc-title-wrap h1 {
        font-family: 'Playfair Display', Georgia, serif !important;
        font-size: 38px !important;
        font-weight: 700 !important;
        line-height: 1.05 !important;
        letter-spacing: 0 !important;
        margin: 0 0 7px !important;
        color: var(--hc-black) !important;
        text-transform: none !important;
    }

    .hc-title-wrap p {
        margin: 0;
        font-size: 14px;
        font-weight: 400;
        color: #344054;
    }

    .hc-head-actions {
        display: grid;
        grid-template-columns: 118px 136px;
        grid-template-areas:
            "date date"
            "export primary";
        gap: 9px;
        justify-content: end;
        align-items: center;
        min-width: 270px;
    }

    .hc-date-control {
        grid-area: date;
        width: 100%;
        min-width: 265px;
        height: 42px;
        min-height: 42px;
        padding: 0 14px;
        border-radius: 8px;
        border: 1px solid var(--hc-black);
        background: #FFFFFF;
        color: var(--hc-black);
        box-shadow: none;
        display: grid;
        grid-template-columns: 18px minmax(0, 1fr) 16px;
        align-items: center;
        justify-items: center;
        column-gap: 10px;
        white-space: nowrap;
        overflow: hidden;
        cursor: pointer;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .hc-date-control span {
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        color: inherit;
    }

    .hc-date-control i,
    .hc-btn i,
    .hc-icon-btn i {
        width: 16px;
        height: 16px;
        color: currentColor;
        stroke: currentColor;
    }

    .hc-date-control:hover,
    .hc-date-control:focus {
        background: var(--hc-black);
        border-color: var(--hc-black);
        color: #FFFFFF;
    }

    .hc-btn {
        height: 34px;
        min-height: 34px;
        min-width: 118px;
        width: 100%;
        padding: 0 14px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 500;
        line-height: 1;
        letter-spacing: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
        box-shadow: none;
        transform: none;
        cursor: pointer;
        font-family: 'Inter', system-ui, sans-serif;
        transition: background-color .18s ease, color .18s ease, border-color .18s ease;
    }

    .hc-btn-export {
        grid-area: export;
        background: #FFFFFF;
        color: var(--hc-black);
        border: 1px solid var(--hc-black);
    }

    .hc-btn-primary {
        grid-area: primary;
        background: var(--hc-blue-gradient);
        color: #FFFFFF;
        border: 1px solid transparent;
    }

    .hc-btn-outline {
        background: #FFFFFF;
        color: var(--hc-black);
        border: 1px solid var(--hc-black);
    }

    .hc-btn-save {
        background: var(--hc-green-gradient);
        color: #FFFFFF;
        border: 0;
    }

    .hc-btn:hover,
    .hc-btn:focus {
        background: var(--hc-black) !important;
        background-image: none !important;
        color: #FFFFFF !important;
        border-color: var(--hc-black) !important;
    }

    .hc-metrics {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 15px;
    }

    .hc-metric {
        min-height: 82px;
        background: #FFFFFF;
        border: 1.4px solid var(--hc-border);
        border-radius: 12px;
        padding: 13px 15px;
        display: flex;
        align-items: center;
        gap: 13px;
        text-align: left;
        cursor: pointer;
        box-shadow: var(--hc-shadow);
        transition: background-color .18s ease, border-color .18s ease;
    }

    .hc-metric:hover,
    .hc-panel:hover {
        background: rgba(33, 37, 41, 0.04);
    }

    .hc-metric.blue { border-color: var(--hc-blue); }
    .hc-metric.green { border-color: var(--hc-green); }
    .hc-metric.orange { border-color: var(--hc-orange); }
    .hc-metric.purple { border-color: var(--hc-purple); }
    .hc-metric.cyan { border-color: #0EA5E9; }

    .hc-metric-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
    }

    .hc-metric-icon i { width: 25px; height: 25px; }
    .hc-soft-blue { background: #EAF1FF; color: var(--hc-blue); }
    .hc-soft-green { background: #E4F8EE; color: var(--hc-green); }
    .hc-soft-orange { background: #FFF3E6; color: var(--hc-orange); }
    .hc-soft-purple { background: #F3E8FF; color: var(--hc-purple); }
    .hc-soft-cyan { background: #E8F8FF; color: #0EA5E9; }

    .hc-metric small {
        display: block;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 10px;
        font-weight: 600;
        color: #344054;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .hc-metric strong {
        display: block;
        font-size: 22px;
        line-height: 1;
        font-weight: 800;
        color: var(--hc-black);
        margin-bottom: 7px;
    }

    .hc-metric span span {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--hc-green);
        font-size: 11px;
        font-weight: 700;
    }

    .hc-search-wrap {
        position: relative;
        margin-bottom: 15px;
    }

    .hc-search-wrap i {
        position: absolute;
        left: 17px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        color: #64748B;
    }

    .hc-search-wrap input {
        width: 100%;
        height: 48px;
        border: 1.4px solid var(--hc-border);
        border-radius: 12px;
        background: #FFFFFF;
        padding: 0 48px;
        color: var(--hc-black);
        font-size: 14px;
        outline: none;
        box-shadow: var(--hc-shadow);
    }

    .hc-search-wrap input:focus {
        border-color: var(--hc-blue);
        box-shadow: 0 0 0 3px rgba(11, 99, 246, .10);
    }

    .hc-quick-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 14px;
    }

    .hc-quick-card,
    .hc-panel,
    .hc-resource-card,
    .hc-mini-panel {
        background: var(--hc-card);
        border: 1.4px solid var(--hc-border);
        border-radius: 12px;
        box-shadow: var(--hc-shadow);
    }

    .hc-quick-card {
        min-height: 104px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 16px;
        cursor: pointer;
        transition: background .18s, border-color .18s;
        text-align: left;
        width: 100%;
    }

    .hc-quick-card:hover {
        border-color: var(--hc-blue);
        background: #F8FBFF;
    }

    .hc-quick-card .hc-big-icon {
        width: 54px;
        height: 54px;
        border-radius: 999px;
        background: #EAF1FF;
        color: var(--hc-blue);
        display: grid;
        place-items: center;
        flex: 0 0 auto;
    }

    .hc-big-icon i { width: 28px; height: 28px; }

    .hc-quick-card h3,
    .hc-panel-title,
    .hc-resource-card h3 {
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 15px;
        font-weight: 600;
        color: var(--hc-black);
        margin: 0;
    }

    .hc-quick-card p,
    .hc-resource-card p,
    .hc-small-copy {
        margin: 5px 0 0;
        font-size: 12px;
        line-height: 1.45;
        color: var(--hc-muted);
    }

    .hc-arrow {
        margin-left: auto;
        color: var(--hc-blue);
        flex: 0 0 auto;
    }

    .hc-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(350px, .85fr);
        gap: 14px;
        margin-bottom: 14px;
        align-items: stretch;
    }

    .hc-panel {
        padding: 15px;
        min-height: 188px;
    }

    .hc-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 13px;
    }

    .hc-panel-title {
        position: relative;
        padding-left: 14px;
    }

    .hc-panel-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 9px;
        width: 8px;
        height: 2px;
        border-radius: 99px;
        background: var(--hc-orange);
    }

    .hc-table {
        width: 100%;
        border-collapse: collapse;
    }

    .hc-table th {
        height: 34px;
        text-align: left;
        background: #FBFCFE;
        border-bottom: 1px solid var(--hc-soft-border);
        color: #344054;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 800;
        padding: 0 12px;
    }

    .hc-table td {
        height: 42px;
        border-bottom: 1px solid var(--hc-soft-border);
        color: var(--hc-black);
        font-size: 12px;
        font-weight: 500;
        padding: 0 12px;
    }

    .hc-table tbody tr {
        cursor: pointer;
    }

    .hc-table tbody tr:hover {
        background: #F8FAFC;
    }

    .hc-pill {
        min-height: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 9px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .hc-pill.green { background: #DFF8EC; color: #0F7A4F; }
    .hc-pill.blue { background: #DBEAFE; color: var(--hc-blue); }
    .hc-pill.orange { background: #FFF0D4; color: #C26C00; }
    .hc-pill.gray { background: #EEF2F7; color: #475569; }

    .hc-actions-cell {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .hc-icon-btn {
        width: 30px;
        height: 30px;
        border-radius: 999px;
        border: 1px solid var(--hc-soft-border);
        background: #FFFFFF;
        color: var(--hc-black);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .hc-icon-btn:hover {
        background: var(--hc-black);
        color: #FFFFFF;
        border-color: var(--hc-black);
    }

    .hc-live-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 14px;
    }

    .hc-live-stat {
        border-left: 1px solid var(--hc-soft-border);
        padding-left: 12px;
    }

    .hc-live-stat:first-child { border-left: 0; padding-left: 0; }
    .hc-live-stat small { display: block; font-size: 10px; font-weight: 600; color: var(--hc-muted); margin-bottom: 6px; }
    .hc-live-stat strong { display: block; font-size: 24px; line-height: 1; font-weight: 800; color: var(--hc-black); }
    .hc-live-stat span { display: block; margin-top: 6px; font-size: 10px; color: var(--hc-green); font-weight: 700; }

    .hc-quick-actions-row {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 9px;
        margin: 12px 0;
    }

    .hc-chat-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 24px;
        padding: 0 10px;
        border-radius: 999px;
        background: #DCFCE7;
        color: #166534;
        font-size: 11px;
        font-weight: 800;
    }

    .hc-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        background: currentColor;
    }

    .hc-sub-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1.05fr 1.1fr;
        gap: 14px;
        margin-bottom: 14px;
        align-items: stretch;
    }

    .hc-mini-panel {
        padding: 15px;
        min-height: 220px;
    }

    .hc-rank-list,
    .hc-feedback-list,
    .hc-settings-list,
    .hc-team-list {
        display: grid;
        gap: 9px;
    }

    .hc-list-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid var(--hc-soft-border);
        color: var(--hc-black);
        font-size: 12px;
        background: transparent;
        border-left: 0;
        border-right: 0;
        border-top: 0;
        width: 100%;
        text-align: left;
        cursor: pointer;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .hc-list-row:last-child { border-bottom: 0; }
    .hc-list-row:hover { color: var(--hc-blue); }
    .hc-list-row strong { color: var(--hc-black); font-size: 12px; font-weight: 800; }
    .hc-list-row small { display: block; color: var(--hc-muted); font-size: 10px; margin-top: 2px; line-height: 1.35; }

    .hc-avatar {
        width: 30px;
        height: 30px;
        border-radius: 999px;
        background: #EAF1FF;
        color: var(--hc-blue);
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        font-size: 12px;
        font-weight: 900;
        overflow: hidden;
    }

    .hc-row-left {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
    }

    .hc-media-panel {
        padding: 15px;
        background: #FFFFFF;
        border: 1.4px solid var(--hc-border);
        border-radius: 12px;
        box-shadow: var(--hc-shadow);
        margin-bottom: 10px;
    }

    .hc-media-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 10px;
    }

    .hc-media-card,
    .hc-upload-box {
        min-height: 72px;
        border: 1px solid var(--hc-soft-border);
        border-radius: 10px;
        background: #FFFFFF;
        padding: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .hc-upload-box {
        border-style: dashed;
        border-color: var(--hc-blue);
        justify-content: space-between;
        grid-column: span 2;
    }

    .hc-media-card strong,
    .hc-upload-box strong {
        display: block;
        color: var(--hc-black);
        font-size: 18px;
        line-height: 1;
        margin-bottom: 4px;
    }

    .hc-media-card small,
    .hc-upload-box small {
        color: var(--hc-muted);
        font-size: 10px;
        font-weight: 500;
        line-height: 1.35;
    }

    .hc-resource-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .hc-resource-card {
        min-height: 105px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 15px;
        cursor: pointer;
    }

    .hc-resource-card:hover {
        border-color: var(--hc-blue);
        background: #F8FBFF;
    }

    .hc-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 6900;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px;
        background: rgba(17, 24, 39, .36);
        backdrop-filter: blur(9px);
    }

    .hc-modal,
    .hc-calendar-modal {
        background: #FFFFFF;
        color: var(--hc-black);
        border: 1.2px solid var(--hc-black);
        border-radius: 18px;
        box-shadow: 0 26px 80px rgba(15, 23, 42, .22);
        overflow: hidden;
    }

    .hc-modal {
        width: min(560px, calc(100vw - 36px));
    }

    .hc-modal-head {
        min-height: 56px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--hc-soft-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .hc-modal-head h2 {
        margin: 0;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: var(--hc-black);
    }

    .hc-modal-body { padding: 18px; }

    .hc-form-grid {
        display: grid;
        gap: 10px;
    }

    .hc-field {
        display: grid;
        gap: 5px;
    }

    .hc-field label {
        font-size: 10px;
        font-weight: 800;
        color: #4B5563;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .hc-field input,
    .hc-field select,
    .hc-field textarea {
        width: 100%;
        border: 1px solid var(--hc-soft-border);
        border-radius: 10px;
        background: #FFFFFF;
        padding: 10px 11px;
        color: var(--hc-black);
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 12px;
        font-weight: 500;
        outline: none;
    }

    .hc-field textarea { min-height: 86px; resize: vertical; }
    .hc-field input:focus,
    .hc-field select:focus,
    .hc-field textarea:focus {
        border-color: var(--hc-blue);
        box-shadow: 0 0 0 3px rgba(11, 99, 246, .10);
    }

    .hc-modal-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 9px;
        margin-top: 14px;
    }

    .hc-toast {
        position: fixed;
        top: 22px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 7200;
        min-width: 260px;
        max-width: 520px;
        padding: 12px 18px;
        border-radius: 999px;
        background: var(--hc-black);
        color: #FFFFFF;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        box-shadow: 0 18px 50px rgba(15, 23, 42, .24);
    }

    .hc-calendar-modal {
        width: min(980px, calc(100vw - 48px));
        max-height: calc(100vh - 42px);
        display: grid;
        grid-template-columns: minmax(0, 650px) 330px;
    }

    .hc-calendar-main { padding: 18px 18px 20px; border-right: 1px solid var(--hc-soft-border); min-width: 0; }
    .hc-calendar-side { padding: 18px; min-width: 0; }
    .hc-calendar-headline { display: grid; grid-template-columns: minmax(160px, 1fr) auto 34px; gap: 14px; align-items: start; margin-bottom: 16px; }
    .hc-calendar-intro h3 { margin: 0 0 3px; font-family: 'Poppins', system-ui, sans-serif; font-size: 16px; font-weight: 700; color: var(--hc-black); }
    .hc-calendar-intro p { width: 170px; margin: 0; font-size: 11px; font-weight: 400; line-height: 1.45; color: #6B7280; }
    .hc-calendar-nav-main { display: flex; align-items: center; justify-content: center; gap: 38px; padding-top: 8px; }
    .hc-calendar-monthbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 12px; }
    .hc-calendar-title { margin: 0; font-family: 'Poppins', system-ui, sans-serif; font-size: 14px; font-weight: 700; color: var(--hc-black); }
    .hc-calendar-weekdays,
    .hc-calendar-grid { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 7px; }
    .hc-calendar-weekdays { margin-bottom: 7px; }
    .hc-calendar-weekdays span { text-align: center; font-size: 9.5px; font-weight: 800; color: #6B7280; letter-spacing: .08em; text-transform: uppercase; }
    .hc-calendar-day { min-height: 78px; border: 1px solid var(--hc-soft-border); border-radius: 12px; background: #FFFFFF; padding: 8px; text-align: left; color: var(--hc-black); cursor: pointer; box-shadow: none; }
    .hc-calendar-day:hover,
    .hc-calendar-day:focus { border-color: var(--hc-blue); box-shadow: 0 10px 24px rgba(11, 99, 246, .10); }
    .hc-calendar-day.is-muted { background: #FAFAFA; color: #A1A1AA; cursor: default; }
    .hc-calendar-day.is-today { border-color: var(--hc-blue); background: #F7FBFF; }
    .hc-calendar-day.is-selected { border-color: var(--hc-black); background: rgba(17, 24, 39, .08); box-shadow: inset 0 0 0 1px var(--hc-black); }
    .hc-calendar-day-number { display: block; font-size: 12px; font-weight: 800; line-height: 1; }
    .hc-calendar-day-events { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 17px; }
    .hc-calendar-event-dot { width: 7px; height: 7px; border-radius: 999px; background: var(--hc-blue); box-shadow: 0 0 0 3px rgba(11, 99, 246, .10); }
    .hc-calendar-more { font-size: 9px; font-weight: 700; color: #6B7280; line-height: 1; }
    .hc-calendar-selected-date { margin: 0 0 14px; font-family: 'Poppins', system-ui, sans-serif; font-size: 16px; font-weight: 700; color: var(--hc-black); }
    .hc-calendar-event-list { display: grid; gap: 8px; max-height: 176px; overflow: auto; padding-right: 2px; margin-bottom: 12px; }
    .hc-calendar-event-item { border: 1px solid var(--hc-soft-border); border-radius: 12px; background: #FFFFFF; padding: 10px; display: grid; gap: 7px; }
    .hc-calendar-event-title { font-size: 12px; font-weight: 800; color: var(--hc-black); line-height: 1.3; }
    .hc-calendar-event-meta { font-size: 10px; font-weight: 600; color: var(--hc-blue); line-height: 1.35; }
    .hc-calendar-event-note { font-size: 10.5px; font-weight: 400; color: #6B7280; line-height: 1.45; }
    .hc-calendar-event-actions { display: flex; gap: 6px; justify-content: flex-end; }
    .hc-calendar-empty { min-height: 74px; border: 1px dashed var(--hc-border); border-radius: 12px; display: grid; place-items: center; text-align: center; color: #6B7280; font-size: 11px; font-weight: 400; line-height: 1.45; padding: 12px; background: #FFFFFF; margin-bottom: 12px; }
    .hc-mini-calendar-btn { height: 27px; min-height: 27px; min-width: 58px; padding: 0 10px; border: 1px solid var(--hc-soft-border); background: #FFFFFF; color: var(--hc-black); border-radius: 999px; font-size: 9.5px; font-weight: 800; cursor: pointer; }
    .hc-mini-calendar-btn:hover { background: var(--hc-black); color: #FFFFFF; border-color: var(--hc-black); }
    .hc-mini-calendar-btn.danger { border-color: #FEE2E2; color: var(--hc-red); }
    .hc-mini-calendar-btn.danger:hover { background: var(--hc-red); border-color: var(--hc-red); color: #FFFFFF; }

    [x-cloak] { display: none !important; }

    @media (max-width: 1200px) {
        .hc-metrics { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .hc-main-grid,
        .hc-sub-grid { grid-template-columns: 1fr; }
        .hc-media-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .hc-upload-box { grid-column: span 1; }
    }

    @media (max-width: 760px) {
        .hc-admin-wrapper { padding: 16px; }
        .hc-page-head { flex-direction: column; align-items: stretch; }
        .hc-head-actions { width: 100%; min-width: 0; grid-template-columns: 1fr 1fr; }
        .hc-date-control { min-width: 0; }
        .hc-quick-grid,
        .hc-resource-grid,
        .hc-media-grid,
        .hc-metrics { grid-template-columns: 1fr; }
        .hc-calendar-modal { grid-template-columns: 1fr; width: min(720px, calc(100vw - 32px)); overflow: auto; }
        .hc-calendar-main { border-right: 0; border-bottom: 1px solid var(--hc-soft-border); }
        .hc-calendar-headline { grid-template-columns: 1fr auto; }
        .hc-calendar-nav-main { grid-column: 1 / -1; justify-content: space-between; gap: 12px; }
    }
</style>

<div class="hc-admin-wrapper" x-data="helpCenterAdminFinal()" x-init="init()">
    <div class="hc-toast" x-show="toastMessage" x-transition x-cloak x-text="toastMessage"></div>

    <section class="hc-page-head">
        <div class="hc-title-wrap">
            <h1>Help Center</h1>
            <p>Manage help articles, support resources, customer assistance, and knowledge base settings.</p>
        </div>

        <div class="hc-head-actions">
            <button type="button" class="hc-date-control" @click="openCalendar()">
                <i data-lucide="calendar-days"></i>
                <span x-text="dateRangeLabel()"></span>
                <i data-lucide="chevron-down"></i>
            </button>
            <button type="button" class="hc-btn hc-btn-export" @click="exportData()">
                <i data-lucide="download"></i>
                <span>Export</span>
            </button>
            <button type="button" class="hc-btn hc-btn-primary" @click="openCreateArticle()">
                <i data-lucide="plus"></i>
                <span>Create Article</span>
            </button>
        </div>
    </section>

    <section class="hc-metrics">
        <button type="button" class="hc-metric blue" @click="openMetric('Total Articles', 'All published and draft help articles are shown in the Knowledge Base Management table.')">
            <span class="hc-metric-icon hc-soft-blue"><i data-lucide="book-open"></i></span>
            <span><small>Total Articles</small><strong x-text="articles.length"></strong><span>↗ 15.6% this week</span></span>
        </button>
        <button type="button" class="hc-metric green" @click="openMetric('Total Categories', 'Manage article categories, sorting, and category visibility.')">
            <span class="hc-metric-icon hc-soft-green"><i data-lucide="messages-square"></i></span>
            <span><small>Total Categories</small><strong x-text="categories.length"></strong><span>↗ 8.3% this week</span></span>
        </button>
        <button type="button" class="hc-metric orange" @click="openMetric('Total Views', 'Total help-center views based on the current selected date range.')">
            <span class="hc-metric-icon hc-soft-orange"><i data-lucide="eye"></i></span>
            <span><small>Total Views</small><strong>24,850</strong><span>↗ 15.6% vs last week</span></span>
        </button>
        <button type="button" class="hc-metric purple" @click="openMetric('Helpful Rate', 'Helpful votes divided by total feedback submitted by customers.')">
            <span class="hc-metric-icon hc-soft-purple"><i data-lucide="thumbs-up"></i></span>
            <span><small>Helpful Rate</small><strong>92.4%</strong><span>↗ 3.2% vs last week</span></span>
        </button>
        <button type="button" class="hc-metric cyan" @click="openMetric('Average Response Time', 'Live-chat response time from available support agents.')">
            <span class="hc-metric-icon hc-soft-cyan"><i data-lucide="clock"></i></span>
            <span><small>Avg. Response Time</small><strong>2m 15s</strong><span>↓ 12s vs last week</span></span>
        </button>
    </section>

    <div class="hc-search-wrap">
        <i data-lucide="search"></i>
        <input type="text" x-model="searchQuery" placeholder="Search help articles, categories, settings, and resources...">
    </div>

    <section class="hc-quick-grid">
        <button type="button" class="hc-quick-card" @click="openGuide('Getting Started Guide')">
            <span class="hc-big-icon"><i data-lucide="book-open"></i></span>
            <span><h3>Getting Started Guide</h3><p>Manage onboarding articles and first-time customer guides.</p></span>
            <i class="hc-arrow" data-lucide="arrow-right"></i>
        </button>
        <button type="button" class="hc-quick-card" @click="openGuide('FAQs')">
            <span class="hc-big-icon"><i data-lucide="circle-help"></i></span>
            <span><h3>FAQs</h3><p>Create, update, and sort frequently asked customer questions.</p></span>
            <i class="hc-arrow" data-lucide="arrow-right"></i>
        </button>
        <button type="button" class="hc-quick-card" @click="openGuide('Contact Support')">
            <span class="hc-big-icon"><i data-lucide="mail"></i></span>
            <span><h3>Contact Support</h3><p>Configure ticket forms, email routing, and escalation rules.</p></span>
            <i class="hc-arrow" data-lucide="arrow-right"></i>
        </button>
    </section>

    <section class="hc-main-grid">
        <article class="hc-panel">
            <div class="hc-panel-head">
                <h2 class="hc-panel-title">Knowledge Base Management</h2>
                <button type="button" class="hc-btn hc-btn-outline hc-small-action-btn" @click="manageCategories()"><i data-lucide="settings"></i>Manage</button>
            </div>
            <table class="hc-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Articles</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="article in filteredArticles" :key="article.id">
                        <tr @click="openArticle(article)">
                            <td><strong x-text="article.category"></strong></td>
                            <td x-text="article.count"></td>
                            <td x-text="article.views.toLocaleString()"></td>
                            <td><span class="hc-pill green" x-text="article.status"></span></td>
                            <td>
                                <div class="hc-actions-cell">
                                    <button type="button" class="hc-icon-btn" @click.stop="editArticle(article)" title="Edit"><i data-lucide="pencil"></i></button>
                                    <button type="button" class="hc-icon-btn" @click.stop="duplicateArticle(article)" title="Duplicate"><i data-lucide="copy"></i></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <a href="#" class="hc-small-copy" style="display:inline-flex;margin-top:12px;color:var(--hc-blue);font-weight:800;text-decoration:none;" @click.prevent="viewAllArticles()">View all articles →</a>
        </article>

        <article class="hc-panel">
            <div class="hc-panel-head">
                <h2 class="hc-panel-title">Live Chat Overview</h2>
                <span class="hc-chat-status"><span class="hc-dot"></span>Online</span>
            </div>
            <div class="hc-live-grid">
                <div class="hc-live-stat"><small>Active Chats</small><strong>8</strong><span>View all →</span></div>
                <div class="hc-live-stat"><small>Chats Today</small><strong>45</strong><span>↗ 18.2%</span></div>
                <div class="hc-live-stat"><small>Resolved Today</small><strong>37</strong><span>↗ 21.5%</span></div>
                <div class="hc-live-stat"><small>Satisfaction</small><strong>96%</strong><span>↗ 4.1%</span></div>
            </div>
            <div class="hc-panel-head" style="margin-top:16px;margin-bottom:8px;">
                <h2 class="hc-panel-title" style="font-size:13px;">Quick Actions</h2>
            </div>
            <div class="hc-quick-actions-row">
                <button type="button" class="hc-btn hc-btn-outline" @click="openSettings('Chat Settings')"><i data-lucide="settings"></i>Chat Settings</button>
                <button type="button" class="hc-btn hc-btn-outline" @click="openSettings('Auto Replies')"><i data-lucide="message-square-text"></i>Auto Replies</button>
                <button type="button" class="hc-btn hc-btn-outline" @click="openSettings('Canned Responses')"><i data-lucide="file-text"></i>Canned</button>
            </div>
            <button type="button" class="hc-btn hc-btn-primary hc-chat-dashboard-btn" @click="openChatDashboard()"><i data-lucide="headphones"></i>Open Chat Dashboard</button>
        </article>
    </section>

    <section class="hc-sub-grid">
        <article class="hc-mini-panel">
            <div class="hc-panel-head"><h2 class="hc-panel-title">Top Articles</h2></div>
            <div class="hc-rank-list">
                <template x-for="(article, index) in topArticles" :key="article.title">
                    <button class="hc-list-row" type="button" @click="openMetric(article.title, 'Article opened from top viewed list.')">
                        <span><strong x-text="(index + 1) + '. ' + article.title"></strong></span>
                        <span class="hc-pill blue" x-text="article.views"></span>
                    </button>
                </template>
            </div>
            <a href="#" class="hc-small-copy" style="display:inline-flex;margin-top:12px;color:var(--hc-blue);font-weight:800;text-decoration:none;" @click.prevent="viewAllArticles()">View all articles →</a>
        </article>

        <article class="hc-mini-panel">
            <div class="hc-panel-head"><h2 class="hc-panel-title">Recent Feedback</h2></div>
            <div class="hc-feedback-list">
                <template x-for="feedback in feedbackItems" :key="feedback.text">
                    <button class="hc-list-row" type="button" @click="openMetric('Feedback Details', feedback.text)">
                        <span class="hc-row-left"><span class="hc-avatar" x-text="feedback.icon"></span><span><strong x-text="feedback.text"></strong><small x-text="feedback.article"></small></span></span>
                        <small x-text="feedback.time"></small>
                    </button>
                </template>
            </div>
            <a href="#" class="hc-small-copy" style="display:inline-flex;margin-top:12px;color:var(--hc-blue);font-weight:800;text-decoration:none;" @click.prevent="openMetric('Feedback', 'Opening all help center feedback.')">View all feedback →</a>
        </article>

        <article class="hc-mini-panel">
            <div class="hc-panel-head"><h2 class="hc-panel-title">Help Center Settings</h2></div>
            <div class="hc-settings-list">
                <template x-for="setting in settingsItems" :key="setting.title">
                    <button class="hc-list-row" type="button" @click="openSettings(setting.title)">
                        <span class="hc-row-left"><span class="hc-avatar"><i :data-lucide="setting.icon"></i></span><span><strong x-text="setting.title"></strong><small x-text="setting.desc"></small></span></span>
                        <i data-lucide="chevron-right" style="width:15px;"></i>
                    </button>
                </template>
            </div>
        </article>

        <article class="hc-mini-panel">
            <div class="hc-panel-head">
                <h2 class="hc-panel-title">Support Team</h2>
                <button type="button" class="hc-btn hc-btn-outline" style="min-width:96px;width:auto;" @click="addMember()"><i data-lucide="plus"></i>Add</button>
            </div>
            <div class="hc-team-list">
                <template x-for="member in supportTeam" :key="member.name">
                    <button class="hc-list-row" type="button" @click="openMetric(member.name, member.role + ' profile opened.')">
                        <span class="hc-row-left"><span class="hc-avatar" x-text="member.initial"></span><span><strong x-text="member.name"></strong><small x-text="member.role"></small></span></span>
                        <span class="hc-pill" :class="member.status === 'Online' ? 'green' : (member.status === 'Away' ? 'orange' : 'gray')" x-text="member.status"></span>
                    </button>
                </template>
            </div>
            <a href="#" class="hc-small-copy" style="display:inline-flex;margin-top:12px;color:var(--hc-blue);font-weight:800;text-decoration:none;" @click.prevent="openMetric('Support Team', 'Opening all support team members.')">View all team members →</a>
        </article>
    </section>

    <section class="hc-media-panel">
        <div class="hc-panel-head"><h2 class="hc-panel-title">Resource & Media Management</h2></div>
        <div class="hc-media-grid">
            <div class="hc-media-card"><span class="hc-metric-icon hc-soft-blue"><i data-lucide="archive"></i></span><span><strong>128</strong><small>File uploads<br>Images, docs, videos</small></span></div>
            <div class="hc-media-card"><span class="hc-metric-icon hc-soft-cyan"><i data-lucide="download"></i></span><span><strong>3,450</strong><small>Total downloads</small></span></div>
            <div class="hc-media-card"><span class="hc-metric-icon hc-soft-purple"><i data-lucide="search"></i></span><span><strong>1,246</strong><small>Searches this week</small></span></div>
            <div class="hc-upload-box">
                <span class="hc-row-left"><span class="hc-metric-icon hc-soft-green"><i data-lucide="cloud-upload"></i></span><span><strong style="font-size:13px;line-height:1.2;">Upload New File</strong><small>JPG, PNG, PDF or ZIP. Max size 10MB.</small></span></span>
                <button type="button" class="hc-btn hc-btn-outline" style="width:auto;min-width:96px;" @click="uploadFile()">Upload File</button>
            </div>
        </div>
    </section>

    <section class="hc-resource-grid">
        <button type="button" class="hc-resource-card" @click="openResource('Video Tutorials')">
            <span class="hc-big-icon"><i data-lucide="play-square"></i></span>
            <span><h3>Video Tutorials</h3><p>Watch step-by-step guides on how to set up your store and optimize products.</p></span>
            <i class="hc-arrow" data-lucide="arrow-right"></i>
        </button>
        <button type="button" class="hc-resource-card" @click="openResource('Community Forum')">
            <span class="hc-big-icon"><i data-lucide="users-round"></i></span>
            <span><h3>Community Forum</h3><p>Connect with other entrepreneurs. Share strategies and get inspired.</p></span>
            <i class="hc-arrow" data-lucide="arrow-right"></i>
        </button>
        <button type="button" class="hc-resource-card" @click="openResource('API Reference')">
            <span class="hc-big-icon"><i data-lucide="code-2"></i></span>
            <span><h3>API Reference</h3><p>Detailed documentation for developers to integrate printing services.</p></span>
            <i class="hc-arrow" data-lucide="arrow-right"></i>
        </button>
    </section>

    <div class="hc-modal-backdrop" x-show="calendarOpen" x-transition.opacity x-cloak @click.self="closeCalendar()" @keydown.escape.window="closeCalendar()">
        <div class="hc-calendar-modal" x-transition.scale>
            <div class="hc-calendar-main">
                <div class="hc-calendar-headline">
                    <div class="hc-calendar-intro">
                        <h3>Admin Calendar</h3>
                        <p>Select dates and manage help center reminders.</p>
                    </div>
                    <div class="hc-calendar-nav-main">
                        <button type="button" class="hc-icon-btn" @click="previousMonth()" title="Previous month"><i data-lucide="chevron-left"></i></button>
                        <button type="button" class="hc-btn hc-btn-outline" style="width:auto;min-width:86px;" @click="goToday()">Today</button>
                        <button type="button" class="hc-icon-btn" @click="nextMonth()" title="Next month"><i data-lucide="chevron-right"></i></button>
                    </div>
                    <button type="button" class="hc-icon-btn" @click="closeCalendar()" title="Close"><i data-lucide="x"></i></button>
                </div>
                <div class="hc-calendar-monthbar">
                    <h3 class="hc-calendar-title" x-text="calendarMonthLabel()"></h3>
                    <button type="button" class="hc-btn hc-btn-outline" style="width:auto;min-width:104px;" @click="useSelectedDate()"><i data-lucide="check"></i>Use Date</button>
                </div>
                <div class="hc-calendar-weekdays"><span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span></div>
                <div class="hc-calendar-grid">
                    <template x-for="day in calendarDays()" :key="day.key">
                        <button type="button" class="hc-calendar-day" :class="{'is-muted': day.muted, 'is-today': day.today, 'is-selected': day.iso === selectedDate}" @click="selectCalendarDate(day)">
                            <span class="hc-calendar-day-number" x-text="day.number"></span>
                            <span class="hc-calendar-day-events" x-show="eventCount(day.iso) > 0">
                                <template x-for="dot in Math.min(eventCount(day.iso), 3)"><span class="hc-calendar-event-dot"></span></template>
                                <span class="hc-calendar-more" x-show="eventCount(day.iso) > 3" x-text="'+' + (eventCount(day.iso) - 3)"></span>
                            </span>
                        </button>
                    </template>
                </div>
            </div>
            <aside class="hc-calendar-side">
                <h3 class="hc-calendar-selected-date" x-text="formattedSelectedDate()"></h3>
                <div class="hc-calendar-event-list" x-show="eventsForSelectedDate().length">
                    <template x-for="event in eventsForSelectedDate()" :key="event.id">
                        <div class="hc-calendar-event-item">
                            <div class="hc-calendar-event-title" x-text="event.title"></div>
                            <div class="hc-calendar-event-meta" x-text="event.time || 'All day'"></div>
                            <div class="hc-calendar-event-note" x-text="event.note || 'No note added.'"></div>
                            <div class="hc-calendar-event-actions">
                                <button type="button" class="hc-mini-calendar-btn" @click="editCalendarEvent(event)">Edit</button>
                                <button type="button" class="hc-mini-calendar-btn danger" @click="deleteCalendarEvent(event.id)">Delete</button>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="hc-calendar-empty" x-show="!eventsForSelectedDate().length">No reminders yet for this date. Add one below.</div>
                <form class="hc-form-grid" @submit.prevent="saveCalendarEvent()">
                    <div class="hc-field"><label>Event / Reminder</label><input type="text" x-model="calendarForm.title" placeholder="Example: Update FAQ article"></div>
                    <div class="hc-field"><label>Time</label><input type="time" x-model="calendarForm.time"></div>
                    <div class="hc-field"><label>Note</label><textarea x-model="calendarForm.note" placeholder="Optional note"></textarea></div>
                    <div class="hc-modal-actions">
                        <button type="button" class="hc-btn hc-btn-outline" style="width:auto;min-width:92px;" @click="resetCalendarForm()">Clear</button>
                        <button type="submit" class="hc-btn hc-btn-save" style="width:auto;min-width:124px;" x-text="calendarForm.id ? 'Update Event' : 'Save Event'"></button>
                    </div>
                </form>
            </aside>
        </div>
    </div>

    <div class="hc-modal-backdrop" x-show="articleModal" x-transition.opacity x-cloak @click.self="closeArticleModal()" @keydown.escape.window="closeArticleModal()">
        <div class="hc-modal" x-transition.scale>
            <div class="hc-modal-head">
                <h2 x-text="articleForm.id ? 'Edit Help Article' : 'Create Help Article'"></h2>
                <button type="button" class="hc-icon-btn" @click="closeArticleModal()"><i data-lucide="x"></i></button>
            </div>
            <div class="hc-modal-body">
                <form class="hc-form-grid" @submit.prevent="saveArticle()">
                    <div class="hc-field"><label>Article Title</label><input type="text" x-model="articleForm.title" placeholder="Enter article title"></div>
                    <div class="hc-field"><label>Category</label><select x-model="articleForm.category"><template x-for="category in categories" :key="category"><option :value="category" x-text="category"></option></template></select></div>
                    <div class="hc-field"><label>Status</label><select x-model="articleForm.status"><option>Published</option><option>Draft</option><option>Archived</option></select></div>
                    <div class="hc-field"><label>Description</label><textarea x-model="articleForm.description" placeholder="Short article description"></textarea></div>
                    <div class="hc-modal-actions">
                        <button type="button" class="hc-btn hc-btn-outline" style="width:auto;" @click="closeArticleModal()">Cancel</button>
                        <button type="submit" class="hc-btn hc-btn-save" style="width:auto;min-width:124px;"><i data-lucide="save"></i>Save Article</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="hc-modal-backdrop" x-show="infoModal" x-transition.opacity x-cloak @click.self="infoModal=false" @keydown.escape.window="infoModal=false">
        <div class="hc-modal" x-transition.scale>
            <div class="hc-modal-head">
                <h2 x-text="infoTitle"></h2>
                <button type="button" class="hc-icon-btn" @click="infoModal=false"><i data-lucide="x"></i></button>
            </div>
            <div class="hc-modal-body">
                <p style="margin:0 0 16px;color:var(--hc-muted);font-size:13px;line-height:1.65;" x-text="infoText"></p>
                <div class="hc-modal-actions">
                    <button type="button" class="hc-btn hc-btn-primary" style="width:auto;min-width:120px;" @click="infoModal=false">Done</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('helpCenterAdminFinal', () => ({
            searchQuery: '',
            toastMessage: '',
            toastTimer: null,
            infoModal: false,
            infoTitle: '',
            infoText: '',
            articleModal: false,
            calendarOpen: false,
            selectedDate: new Date().toISOString().slice(0, 10),
            calendarMonth: new Date().getMonth(),
            calendarYear: new Date().getFullYear(),
            calendarEvents: [],
            calendarForm: { id: null, title: '', time: '', note: '' },
            categories: [
                'Account & Billing Settings',
                'Privacy and Data Security',
                'Technical API Documentation',
                'Order Tracking & Returns',
                'Shipping & Delivery Policies'
            ],
            articles: [
                { id: 1, category: 'Account & Billing Settings', title: 'Update Billing Info', count: 24, views: 4521, status: 'Published', description: 'Manage your account, billing details, invoices, and payments.' },
                { id: 2, category: 'Privacy and Data Security', title: 'Protect Customer Data', count: 18, views: 3210, status: 'Published', description: 'Learn how customer data is protected and secured.' },
                { id: 3, category: 'Technical API Documentation', title: 'API Keys', count: 32, views: 6875, status: 'Published', description: 'API guides, endpoints, keys, and integration references.' },
                { id: 4, category: 'Order Tracking & Returns', title: 'Track Orders', count: 21, views: 4102, status: 'Published', description: 'Track orders, process returns, and manage refunds.' },
                { id: 5, category: 'Shipping & Delivery Policies', title: 'Shipping Times', count: 19, views: 3194, status: 'Published', description: 'Shipping options, delivery times, and policy guidelines.' }
            ],
            articleForm: { id: null, title: '', category: 'Account & Billing Settings', status: 'Published', description: '' },
            topArticles: [
                { title: 'How to Create a New Product', views: '1,245' },
                { title: 'Setting Up Your Payment Method', views: '987' },
                { title: 'How to Track Your Order', views: '856' },
                { title: 'Managing Subscriptions', views: '765' },
                { title: 'Return & Refund Policy', views: '654' }
            ],
            feedbackItems: [
                { icon: '😊', text: 'Great article! Very helpful.', article: 'How to Create a New Product', time: '2h ago' },
                { icon: '🙂', text: 'Article was okay but could be better.', article: 'Return & Refund Policy', time: '5h ago' },
                { icon: '😊', text: 'Easy to follow steps. Thanks!', article: 'Setting Up Your Payment Method', time: '1d ago' },
                { icon: '☹️', text: 'Information not clear.', article: 'Shipping & Delivery Options', time: '1d ago' }
            ],
            settingsItems: [
                { title: 'General Settings', desc: 'Configure general help center settings', icon: 'settings' },
                { title: 'Design & Branding', desc: 'Customize help center appearance', icon: 'paintbrush' },
                { title: 'Article Settings', desc: 'Manage article behavior and permissions', icon: 'file-text' },
                { title: 'Live Chat Settings', desc: 'Configure chat and availability', icon: 'message-square' },
                { title: 'Email Notifications', desc: 'Manage customer notifications', icon: 'mail' }
            ],
            supportTeam: [
                { name: 'Maria Santos', role: 'Support Manager', initial: 'M', status: 'Online' },
                { name: 'John Reyes', role: 'Live Chat Agent', initial: 'J', status: 'Online' },
                { name: 'Anna Cruz', role: 'Documentation Specialist', initial: 'A', status: 'Away' },
                { name: 'David Lim', role: 'Technical Support', initial: 'D', status: 'Offline' }
            ],
            init() {
                this.loadArticles();
                this.loadCalendarEvents();
                this.refreshIcons();
            },
            refreshIcons() {
                this.$nextTick(() => {
                    if (window.lucide) window.lucide.createIcons();
                });
            },
            showToast(message) {
                this.toastMessage = message;
                if (this.toastTimer) clearTimeout(this.toastTimer);
                this.toastTimer = setTimeout(() => this.toastMessage = '', 2400);
            },
            get filteredArticles() {
                const term = this.searchQuery.trim().toLowerCase();
                if (!term) return this.articles;
                return this.articles.filter(article =>
                    (article.category + ' ' + article.title + ' ' + article.description + ' ' + article.status).toLowerCase().includes(term)
                );
            },
            saveArticles() {
                window.localStorage.setItem('printifyHelpCenterArticles', JSON.stringify(this.articles));
            },
            loadArticles() {
                try {
                    const saved = JSON.parse(window.localStorage.getItem('printifyHelpCenterArticles') || '[]');
                    if (Array.isArray(saved) && saved.length) this.articles = saved;
                } catch (error) {}
            },
            openMetric(title, text) {
                this.infoTitle = title;
                this.infoText = text;
                this.infoModal = true;
                this.refreshIcons();
            },
            openGuide(title) {
                this.openMetric(title, title + ' admin content opened. You can manage, edit, and publish this section.');
            },
            openResource(title) {
                this.openMetric(title, title + ' resource opened. Admin can manage links and content from this panel.');
            },
            openArticle(article) {
                this.openMetric(article.title, article.description + ' Views: ' + article.views.toLocaleString() + '. Status: ' + article.status + '.');
            },
            openCreateArticle() {
                this.articleForm = { id: null, title: '', category: this.categories[0], status: 'Published', description: '' };
                this.articleModal = true;
                this.refreshIcons();
            },
            closeArticleModal() {
                this.articleModal = false;
                this.refreshIcons();
            },
            editArticle(article) {
                this.articleForm = { id: article.id, title: article.title, category: article.category, status: article.status, description: article.description || '' };
                this.articleModal = true;
                this.refreshIcons();
            },
            duplicateArticle(article) {
                const copy = { ...article, id: Date.now(), title: article.title + ' Copy', views: 0 };
                this.articles.unshift(copy);
                this.saveArticles();
                this.showToast('Article duplicated.');
            },
            saveArticle() {
                if (!this.articleForm.title.trim()) {
                    this.showToast('Please add an article title.');
                    return;
                }
                if (this.articleForm.id) {
                    const found = this.articles.find(article => article.id === this.articleForm.id);
                    if (found) {
                        found.title = this.articleForm.title.trim();
                        found.category = this.articleForm.category;
                        found.status = this.articleForm.status;
                        found.description = this.articleForm.description;
                    }
                    this.showToast('Article updated.');
                } else {
                    this.articles.unshift({
                        id: Date.now(),
                        title: this.articleForm.title.trim(),
                        category: this.articleForm.category,
                        status: this.articleForm.status,
                        description: this.articleForm.description,
                        count: 1,
                        views: 0
                    });
                    this.showToast('Article created.');
                }
                this.saveArticles();
                this.closeArticleModal();
            },
            manageCategories() { this.openMetric('Manage Categories', 'Category management opened. You can add, rename, archive, and reorder categories.'); },
            openSettings(title) { this.openMetric(title, title + ' opened. Settings can be configured from this admin panel.'); },
            openChatDashboard() { this.openMetric('Live Chat Dashboard', 'Opening live chat dashboard with active conversations, auto replies, and canned responses.'); },
            addMember() { this.openMetric('Add Support Member', 'Support team member form opened.'); },
            uploadFile() { this.showToast('Upload file function opened. Connect this to your Laravel file upload route.'); },
            viewAllArticles() { this.openMetric('All Articles', 'Showing all article records from the Knowledge Base.'); },
            exportData() {
                const rows = [['Category', 'Title', 'Articles', 'Views', 'Status'], ...this.articles.map(article => [article.category, article.title, article.count, article.views, article.status])];
                const csv = rows.map(row => row.map(value => '"' + String(value).replaceAll('"', '""') + '"').join(',')).join('\n');
                const anchor = document.createElement('a');
                anchor.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv' }));
                anchor.download = 'help-center-admin-export.csv';
                anchor.click();
                URL.revokeObjectURL(anchor.href);
                this.showToast('Help Center exported as CSV.');
            },
            pad(value) { return String(value).padStart(2, '0'); },
            isoDate(year, month, day) { return `${year}-${this.pad(month + 1)}-${this.pad(day)}`; },
            dateRangeLabel() { return this.formattedSelectedDate(); },
            openCalendar() { this.calendarOpen = true; this.refreshIcons(); },
            closeCalendar() { this.calendarOpen = false; this.resetCalendarForm(); this.refreshIcons(); },
            calendarMonthLabel() { return new Date(this.calendarYear, this.calendarMonth, 1).toLocaleDateString('en-US', { month: 'long', year: 'numeric' }); },
            formattedSelectedDate() {
                const parts = this.selectedDate.split('-').map(Number);
                return new Date(parts[0], parts[1] - 1, parts[2]).toLocaleDateString('en-US', { month: 'long', day: '2-digit', year: 'numeric' });
            },
            calendarDays() {
                const first = new Date(this.calendarYear, this.calendarMonth, 1);
                const total = new Date(this.calendarYear, this.calendarMonth + 1, 0).getDate();
                const lead = first.getDay();
                const days = [];
                for (let i = 0; i < lead; i++) days.push({ key: `blank-${i}`, number: '', iso: '', muted: true, today: false });
                const today = new Date().toISOString().slice(0, 10);
                for (let d = 1; d <= total; d++) {
                    const iso = this.isoDate(this.calendarYear, this.calendarMonth, d);
                    days.push({ key: iso, number: d, iso, muted: false, today: iso === today });
                }
                while (days.length % 7 !== 0) days.push({ key: `blank-end-${days.length}`, number: '', iso: '', muted: true, today: false });
                return days;
            },
            selectCalendarDate(day) {
                if (!day || day.muted || !day.iso) return;
                this.selectedDate = day.iso;
                this.resetCalendarForm();
            },
            previousMonth() {
                if (this.calendarMonth === 0) { this.calendarMonth = 11; this.calendarYear--; } else this.calendarMonth--;
                this.refreshIcons();
            },
            nextMonth() {
                if (this.calendarMonth === 11) { this.calendarMonth = 0; this.calendarYear++; } else this.calendarMonth++;
                this.refreshIcons();
            },
            goToday() {
                const now = new Date();
                this.calendarYear = now.getFullYear();
                this.calendarMonth = now.getMonth();
                this.selectedDate = now.toISOString().slice(0, 10);
                this.resetCalendarForm();
                this.refreshIcons();
            },
            useSelectedDate() {
                this.closeCalendar();
                this.showToast('Date applied: ' + this.formattedSelectedDate());
            },
            loadCalendarEvents() {
                try { this.calendarEvents = JSON.parse(window.localStorage.getItem('printifyHelpCenterCalendarEvents') || '[]'); }
                catch (error) { this.calendarEvents = []; }
            },
            persistCalendarEvents() { window.localStorage.setItem('printifyHelpCenterCalendarEvents', JSON.stringify(this.calendarEvents)); },
            eventsForSelectedDate() { return this.calendarEvents.filter(event => event.date === this.selectedDate).sort((a, b) => (a.time || '').localeCompare(b.time || '')); },
            eventCount(iso) { return iso ? this.calendarEvents.filter(event => event.date === iso).length : 0; },
            resetCalendarForm() { this.calendarForm = { id: null, title: '', time: '', note: '' }; },
            saveCalendarEvent() {
                if (!this.calendarForm.title.trim()) { this.showToast('Please add an event title.'); return; }
                if (this.calendarForm.id) {
                    const found = this.calendarEvents.find(event => event.id === this.calendarForm.id);
                    if (found) { found.title = this.calendarForm.title.trim(); found.time = this.calendarForm.time; found.note = this.calendarForm.note; found.date = this.selectedDate; }
                    this.showToast('Calendar event updated.');
                } else {
                    this.calendarEvents.push({ id: Date.now(), date: this.selectedDate, title: this.calendarForm.title.trim(), time: this.calendarForm.time, note: this.calendarForm.note });
                    this.showToast('Calendar event saved.');
                }
                this.persistCalendarEvents();
                this.resetCalendarForm();
                this.refreshIcons();
            },
            editCalendarEvent(event) { this.calendarForm = { id: event.id, title: event.title, time: event.time || '', note: event.note || '' }; },
            deleteCalendarEvent(id) {
                this.calendarEvents = this.calendarEvents.filter(event => event.id !== id);
                this.persistCalendarEvents();
                this.resetCalendarForm();
                this.showToast('Calendar event deleted.');
            }
        }));
    });
</script>


<!-- FINAL PATCH: equal width for Manage and Chat Dashboard buttons -->
<style id="helpcenter-equal-button-width-final-patch">
    .hc-admin-wrapper .hc-small-action-btn,
    .hc-admin-wrapper .hc-chat-dashboard-btn {
        width: 118px !important;
        min-width: 118px !important;
        max-width: 118px !important;
        flex: 0 0 118px !important;
        height: 34px !important;
        min-height: 34px !important;
        padding: 0 14px !important;
        border-radius: 999px !important;
        font-size: 11.5px !important;
        font-weight: 500 !important;
        white-space: nowrap !important;
    }

    .hc-admin-wrapper .hc-chat-dashboard-btn {
        margin-top: 0 !important;
        justify-self: start !important;
    }

    .hc-admin-wrapper .hc-quick-actions-row .hc-btn {
        width: 100% !important;
        min-width: 0 !important;
        max-width: none !important;
        height: 34px !important;
        min-height: 34px !important;
    }

    @media (max-width: 760px) {
        .hc-admin-wrapper .hc-small-action-btn,
        .hc-admin-wrapper .hc-chat-dashboard-btn {
            width: 118px !important;
            min-width: 118px !important;
            max-width: 118px !important;
        }
    }
</style>

<!-- FINAL PATCH: center Open Chat Dashboard button -->
<style id="helpcenter-chat-button-center-final-patch">
    .hc-admin-wrapper .hc-chat-dashboard-btn {
        width: 118px !important;
        min-width: 118px !important;
        max-width: 118px !important;
        flex: 0 0 118px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin: 12px auto 0 !important;
        justify-self: center !important;
        align-self: center !important;
    }

    .hc-admin-wrapper .hc-panel:has(.hc-chat-dashboard-btn) {
        display: flex !important;
        flex-direction: column !important;
    }

    .hc-admin-wrapper .hc-panel:has(.hc-chat-dashboard-btn) .hc-chat-dashboard-btn {
        margin-left: auto !important;
        margin-right: auto !important;
    }
</style>

<!-- FINAL FIX: Chat Dashboard button same shape/size as Manage button and centered -->
<style id="helpcenter-chat-same-as-manage-centered-final-fix">
    .hc-admin-wrapper .hc-small-action-btn,
    .hc-admin-wrapper .hc-chat-dashboard-btn {
        width: 118px !important;
        min-width: 118px !important;
        max-width: 118px !important;
        height: 34px !important;
        min-height: 34px !important;
        padding: 0 14px !important;
        border-radius: 999px !important;
        font-size: 11.5px !important;
        font-weight: 500 !important;
        line-height: 1 !important;
        letter-spacing: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        white-space: nowrap !important;
        box-shadow: none !important;
        transform: none !important;
        flex: 0 0 118px !important;
    }

    .hc-admin-wrapper .hc-chat-dashboard-btn {
        margin: 12px auto 0 !important;
        align-self: center !important;
        justify-self: center !important;
        text-align: center !important;
    }

    .hc-admin-wrapper .hc-panel:has(.hc-chat-dashboard-btn) {
        display: flex !important;
        flex-direction: column !important;
    }

    .hc-admin-wrapper .hc-panel:has(.hc-chat-dashboard-btn) .hc-chat-dashboard-btn {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .hc-admin-wrapper .hc-chat-dashboard-btn i,
    .hc-admin-wrapper .hc-small-action-btn i {
        width: 16px !important;
        height: 16px !important;
        flex: 0 0 16px !important;
    }

    @media (max-width: 760px) {
        .hc-admin-wrapper .hc-small-action-btn,
        .hc-admin-wrapper .hc-chat-dashboard-btn {
            width: 118px !important;
            min-width: 118px !important;
            max-width: 118px !important;
        }
    }
</style>
