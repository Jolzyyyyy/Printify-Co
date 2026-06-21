<x-app-layout>
<style>
    :root {
        --staff-blue:   #2563EB;
        --staff-orange: #FF7A00;
        --staff-dark:   #111827;
        --bg-light:     #F8FAFC;
    }
    /* ── page shell ─────────────────────────────────────────────────────────── */
    .ac-page { padding: 36px 58px 52px; font-family: 'Inter', system-ui, sans-serif; }
    @media(max-width:900px){ .ac-page{ padding:24px 18px 36px; } }

    /* ── page header ─────────────────────────────────────────────────────────── */
    .ac-head { margin-bottom: 26px; }
    .ac-breadcrumb { font-size: 11px; font-weight: 700; color: #94A3B8;
        text-transform: uppercase; letter-spacing: .08em; margin-bottom: 8px; }
    .ac-breadcrumb a { color: var(--staff-blue); text-decoration: none; }
    .ac-breadcrumb a:hover { text-decoration: underline; }
    .ac-title {
        margin: 0 0 4px;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 28px; font-weight: 900; color: #172033;
        position: relative; display: inline-block; padding-bottom: 10px;
    }
    .ac-title::after {
        content: ''; position: absolute; left: 0; bottom: 0;
        width: 44px; height: 4px; border-radius: 999px;
        background: var(--staff-blue);
    }
    .ac-subtitle { margin: 8px 0 0; color: #64748B; font-size: 12.5px; font-weight: 600; }

    /* ── summary metrics ─────────────────────────────────────────────────────── */
    .ac-metrics { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 24px; }
    @media(max-width:720px){ .ac-metrics{ grid-template-columns:1fr; } }
    .ac-metric {
        background: white; border: 1px solid #E2E8F0; border-radius: 16px;
        padding: 16px 20px; display: flex; align-items: center; gap: 14px;
        box-shadow: 0 4px 18px -8px rgba(15,23,42,.12);
    }
    .ac-metric-icon {
        width: 42px; height: 42px; border-radius: 12px;
        display: grid; place-items: center; flex-shrink: 0; font-size: 18px;
    }
    .ac-metric-icon.blue   { background: #EFF6FF; color: var(--staff-blue); }
    .ac-metric-icon.amber  { background: #FFFBEB; color: #D97706; }
    .ac-metric-icon.green  { background: #F0FDF4; color: #16A34A; }
    .ac-metric-label { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: .06em; color: #94A3B8; margin-bottom: 3px; }
    .ac-metric-val   { font-size: 22px; font-weight: 950; color: #172033; line-height: 1; }

    /* ── flash messages ───────────────────────────────────────────────────────── */
    .ac-flash { border-radius: 12px; padding: 12px 16px; font-size: 13px; font-weight: 600; margin-bottom: 18px; }
    .ac-flash.success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; }
    .ac-flash.warning { background: #FFFBEB; border: 1px solid #FDE68A; color: #92400E; }
    .ac-flash.info    { background: #EFF6FF; border: 1px solid #BFDBFE; color: #1E3A8A; }
    .ac-flash.error   { background: #FFF1F2; border: 1px solid #FECDD3; color: #9F1239; }

    /* ── two-column layout ───────────────────────────────────────────────────── */
    .ac-layout { display: grid; grid-template-columns: 1fr 300px; gap: 24px; align-items: start; }
    @media(max-width:1024px){ .ac-layout{ grid-template-columns:1fr; } }

    /* ── section header ──────────────────────────────────────────────────────── */
    .ac-section-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    .ac-section-title {
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 15px; font-weight: 900; color: #172033; margin: 0;
    }
    .ac-section-count {
        background: var(--staff-blue); color: white;
        font-size: 10px; font-weight: 900;
        padding: 2px 9px; border-radius: 999px;
    }

    /* ── folder card grid ────────────────────────────────────────────────────── */
    .ac-folder-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px 16px;
    }

    /* folder tab + body */
    .ac-folder { position: relative; margin-top: 16px; cursor: pointer; }
    .ac-folder-tab {
        position: absolute; top: -14px; left: 18px;
        height: 15px; width: 72px; border-radius: 6px 6px 0 0;
        font-size: 8px; font-weight: 900; text-transform: uppercase;
        letter-spacing: .06em; display: flex; align-items: center;
        justify-content: center; color: white;
        pointer-events: none;
    }
    .ac-folder-tab.pending  { background: #D97706; }
    .ac-folder-tab.approved { background: #16A34A; }
    .ac-folder-tab.suspended{ background: #DC2626; }

    .ac-folder-body {
        background: white;
        border: 1.5px solid #E2E8F0;
        border-radius: 0 14px 14px 14px;
        padding: 16px;
        box-shadow: 0 4px 18px -8px rgba(15,23,42,.10);
        transition: transform .18s, box-shadow .18s;
        position: relative; overflow: hidden;
        display: flex; flex-direction: column; gap: 12px;
    }
    .ac-folder-body::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    }
    .ac-folder.pending  .ac-folder-body::before { background: #D97706; }
    .ac-folder.approved .ac-folder-body::before { background: #16A34A; }
    .ac-folder.suspended .ac-folder-body::before { background: #DC2626; }

    .ac-folder:hover .ac-folder-body {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px -8px rgba(37,99,235,.18);
        border-color: var(--staff-blue);
    }

    /* folder interior */
    .ac-folder-avatar {
        width: 44px; height: 44px; border-radius: 50%;
        background: var(--staff-blue); color: white;
        font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 900;
        display: grid; place-items: center; flex-shrink: 0;
    }
    .ac-folder-avatar.amber  { background: linear-gradient(135deg,#F59E0B,#D97706); }
    .ac-folder-avatar.green  { background: linear-gradient(135deg,#22C55E,#16A34A); }
    .ac-folder-avatar.red    { background: linear-gradient(135deg,#EF4444,#DC2626); }
    .ac-folder-avatar.blue   { background: linear-gradient(135deg,#60A5FA,#2563EB); }

    .ac-folder-id-row { display: flex; align-items: center; gap: 10px; }
    .ac-folder-name {
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 13px; font-weight: 800; color: #172033;
        margin: 0 0 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .ac-folder-email { font-size: 11px; color: #94A3B8; font-weight: 600;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ac-folder-biz { font-size: 11px; color: #475569; font-weight: 700;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .ac-folder-stats { display: flex; gap: 6px; flex-wrap: wrap; }
    .ac-stat-chip {
        background: var(--bg-light); border: 1px solid #E2E8F0;
        border-radius: 8px; padding: 4px 9px;
        font-size: 10px; font-weight: 800; color: #475569;
        display: flex; align-items: center; gap: 4px;
    }
    .ac-stat-chip svg { width: 11px; height: 11px; }

    .ac-folder-status-pill {
        display: inline-block; border-radius: 999px;
        padding: 2px 9px; font-size: 9px; font-weight: 900;
        text-transform: uppercase; letter-spacing: .06em;
    }
    .ac-folder-status-pill.pending  { background: #FEF3C7; color: #92400E; }
    .ac-folder-status-pill.approved { background: #DCFCE7; color: #166534; }
    .ac-folder-status-pill.suspended{ background: #FEE2E2; color: #991B1B; }

    .ac-folder-actions { display: flex; gap: 6px; flex-wrap: wrap; }
    .ac-btn {
        border-radius: 8px; padding: 7px 13px; font-size: 11px; font-weight: 900;
        text-transform: uppercase; letter-spacing: .06em; border: none;
        cursor: pointer; text-decoration: none; display: inline-flex;
        align-items: center; gap: 5px; transition: background .15s, color .15s;
    }
    .ac-btn-primary { background: var(--staff-blue); color: white; }
    .ac-btn-primary:hover { background: #1D4ED8; color: white; }
    .ac-btn-outline { background: white; color: #475569; border: 1px solid #E2E8F0; }
    .ac-btn-outline:hover { background: var(--bg-light); }
    .ac-btn-green  { background: #16A34A; color: white; }
    .ac-btn-green:hover  { background: #15803D; }
    .ac-btn-red    { background: white; color: #DC2626; border: 1px solid #FECDD3; }
    .ac-btn-red:hover    { background: #FFF1F2; }
    .ac-btn:disabled { opacity: .45; cursor: not-allowed; }

    /* ── invite panel ─────────────────────────────────────────────────────────── */
    .ac-invite-panel {
        background: white; border: 1px solid #E2E8F0; border-radius: 16px;
        padding: 20px; box-shadow: 0 4px 18px -8px rgba(15,23,42,.10);
    }
    .ac-invite-panel h2 {
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 14px; font-weight: 900; color: #172033; margin: 0 0 4px;
    }
    .ac-invite-panel p { font-size: 12px; color: #64748B; font-weight: 600; margin: 0 0 16px; }
    .ac-field { margin-bottom: 12px; }
    .ac-label { display: block; font-size: 11px; font-weight: 800; color: #475569;
        text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px; }
    .ac-input {
        width: 100%; border: 1.5px solid #E2E8F0; border-radius: 8px;
        padding: 8px 12px; font-size: 13px; font-family: 'Inter', sans-serif;
        color: #172033; background: #F8FAFC; box-sizing: border-box;
        transition: border-color .15s;
    }
    .ac-input:focus { outline: none; border-color: var(--staff-blue); background: white; }
    .ac-submit {
        width: 100%; background: var(--staff-blue); color: white;
        border: none; border-radius: 10px; padding: 10px;
        font-size: 12px; font-weight: 900; text-transform: uppercase;
        letter-spacing: .06em; cursor: pointer; transition: background .15s;
        font-family: 'Poppins', sans-serif;
    }
    .ac-submit:hover { background: #1D4ED8; }

    /* ── audit panel ──────────────────────────────────────────────────────────── */
    .ac-audit-panel {
        background: white; border: 1px solid #E2E8F0; border-radius: 16px;
        padding: 18px; margin-top: 16px;
        box-shadow: 0 4px 18px -8px rgba(15,23,42,.10);
    }
    .ac-audit-panel h2 {
        font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 900;
        color: #172033; margin: 0 0 12px;
    }
    .ac-audit-row { padding: 9px 0; border-bottom: 1px solid #F1F5F9; }
    .ac-audit-row:last-child { border-bottom: 0; }
    .ac-audit-action { font-size: 11px; font-weight: 800; color: #172033; margin: 0 0 2px; }
    .ac-audit-meta   { font-size: 10px; color: #94A3B8; font-weight: 600; }

    /* ── empty state ──────────────────────────────────────────────────────────── */
    .ac-empty { text-align: center; padding: 36px 16px; color: #94A3B8;
        font-size: 13px; font-weight: 600; }
    .ac-empty svg { width: 42px; height: 42px; margin: 0 auto 10px; display: block; color: #CBD5E1; }

    /* ── assign-customer inline form ──────────────────────────────────────────── */
    .ac-assign-form { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px; }
    .ac-assign-input {
        flex: 1; min-width: 0; border: 1.5px solid #E2E8F0; border-radius: 8px;
        padding: 7px 10px; font-size: 11px; color: #172033; background: #F8FAFC;
    }
    .ac-assign-input:focus { outline: none; border-color: var(--staff-blue); }

    /* ── profile info block inside folder ─────────────────────────────────────── */
    .ac-profile-info { background: #F8FAFC; border-radius: 8px; padding: 8px 10px; font-size: 10.5px; color: #475569; }
    .ac-profile-info p { margin: 2px 0; font-weight: 600; }
    .ac-profile-info span { color: #172033; font-weight: 800; }
</style>

<div class="ac-page">

    {{-- ── page header ── --}}
    <div class="ac-head">
        <p class="ac-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Developer Portal</a>
            &rsaquo; Manage Admin Clients
        </p>
        <h1 class="ac-title">Admin Client Accounts</h1>
        <p class="ac-subtitle">Invite business admins, review their profiles, and manage access to the Printify&nbsp;Co system.</p>
    </div>

    {{-- ── summary metrics ── --}}
    <div class="ac-metrics">
        <div class="ac-metric">
            <div class="ac-metric-icon amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 2a5 5 0 1 0 0 10A5 5 0 0 0 12 2zm0 12c-5.33 0-8 2.67-8 4v2h16v-2c0-1.33-2.67-4-8-4z"/></svg>
            </div>
            <div>
                <p class="ac-metric-label">Pending Approval</p>
                <p class="ac-metric-val">{{ $pendingAdminClients->count() }}</p>
            </div>
        </div>
        <div class="ac-metric">
            <div class="ac-metric-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            </div>
            <div>
                <p class="ac-metric-label">Approved Admins</p>
                <p class="ac-metric-val">{{ $approvedAdminClients->count() }}</p>
            </div>
        </div>
        <div class="ac-metric">
            <div class="ac-metric-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20 6h-2.18c.07-.44.18-.88.18-1.34A4.66 4.66 0 0 0 13.34 0c-1.31 0-2.63.54-3.54 1.44L8 3.29 6.2 1.44A4.98 4.98 0 0 0 2.66 0 4.66 4.66 0 0 0 2 9.32V20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z"/></svg>
            </div>
            <div>
                <p class="ac-metric-label">Total Clients</p>
                <p class="ac-metric-val">{{ $pendingAdminClients->count() + $approvedAdminClients->count() }}</p>
            </div>
        </div>
    </div>

    {{-- ── flash messages ── --}}
    @if (session('success'))
        <div class="ac-flash success">&#10003;&nbsp; {{ session('success') }}</div>
    @endif
    @if (session('warning'))
        <div class="ac-flash warning">&#9888;&nbsp; {{ session('warning') }}</div>
    @endif
    @if (session('invite_url'))
        <div class="ac-flash info">
            <strong>Invite setup link</strong><br>
            <a href="{{ session('invite_url') }}" style="word-break:break-all;color:#1D4ED8;">{{ session('invite_url') }}</a>
        </div>
    @endif
    @if ($errors->any())
        <div class="ac-flash error">{{ $errors->first() }}</div>
    @endif

    {{-- ── two-column layout ── --}}
    <div class="ac-layout">

        {{-- ── left: all admin client folders ── --}}
        <div>

            {{-- pending --}}
            @if ($pendingAdminClients->isNotEmpty())
            <div style="margin-bottom:32px;">
                <div class="ac-section-head">
                    <h2 class="ac-section-title">&#9654; Pending Approval</h2>
                    <span class="ac-section-count">{{ $pendingAdminClients->count() }}</span>
                </div>
                <div class="ac-folder-grid">
                    @foreach ($pendingAdminClients as $client)
                        @php
                            $profile = $client->adminClientProfile;
                            $isLegacy = !$client->hasAcceptedInvitation() && blank($client->invite_token);
                            $ready = $isLegacy || ($client->hasAcceptedInvitation() && $client->hasCompletedAdminClientProfile());
                            $initials = collect(explode(' ', $client->name))->map(fn($w)=>strtoupper($w[0]??''))->take(2)->implode('');
                        @endphp
                        <div class="ac-folder pending">
                            <div class="ac-folder-tab pending">Pending</div>
                            <div class="ac-folder-body">

                                {{-- identity --}}
                                <div class="ac-folder-id-row">
                                    <div class="ac-folder-avatar amber">{{ $initials }}</div>
                                    <div style="min-width:0">
                                        <p class="ac-folder-name" title="{{ $client->name }}">{{ $client->name }}</p>
                                        <p class="ac-folder-email" title="{{ $client->email }}">{{ $client->email }}</p>
                                    </div>
                                </div>

                                {{-- business info --}}
                                @if ($profile)
                                    <div class="ac-profile-info">
                                        <p><span>{{ $profile->business_name }}</span></p>
                                        <p>{{ $profile->contact_person }} &bull; {{ $profile->contact_number }}</p>
                                        @if ($profile->reference_notes)
                                            <p style="color:#64748B;margin-top:4px;">{{ Str::limit($profile->reference_notes,70) }}</p>
                                        @endif
                                    </div>
                                @endif

                                {{-- status --}}
                                <div>
                                    <span class="ac-folder-status-pill pending">
                                        {{ $ready ? ($isLegacy ? 'Legacy — needs profile' : 'Ready for approval') : ($client->hasAcceptedInvitation() ? 'Profile incomplete' : 'Awaiting invite acceptance') }}
                                    </span>
                                </div>

                                {{-- stats --}}
                                <div class="ac-folder-stats">
                                    <span class="ac-stat-chip">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0 2c-4 0-7 2-7 3v1h14v-1c0-1-3-3-7-3z"/></svg>
                                        {{ $client->assigned_customers_count }} customers
                                    </span>
                                    <span class="ac-stat-chip">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/></svg>
                                        {{ $client->managed_orders_count }} orders
                                    </span>
                                </div>

                                {{-- actions --}}
                                <div class="ac-folder-actions">
                                    <a href="{{ route('developer.admin-clients.show', $client) }}" class="ac-btn ac-btn-primary">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5C5.64 5 2 12 2 12s3.64 7 10 7 10-7 10-7-3.64-7-10-7zm0 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-6a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>
                                        Open Folder
                                    </a>
                                    <form method="POST" action="{{ route('developer.admin-clients.approve', $client) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="ac-btn ac-btn-green" @disabled(!$ready)>
                                            &#10003; Approve
                                        </button>
                                    </form>
                                </div>

                                @unless($ready)
                                    <p style="font-size:10px;color:#94A3B8;font-weight:600;margin:0;">Admin client must complete the setup before this button unlocks.</p>
                                @endunless

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- approved --}}
            <div style="margin-bottom:32px;">
                <div class="ac-section-head">
                    <h2 class="ac-section-title">&#9654; Approved Admin Clients</h2>
                    <span class="ac-section-count">{{ $approvedAdminClients->count() }}</span>
                </div>

                @if ($approvedAdminClients->isEmpty())
                    <div class="ac-empty">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"/><path d="M3 7l9 6 9-6"/></svg>
                        No approved admin clients yet.
                    </div>
                @else
                <div class="ac-folder-grid">
                    @foreach ($approvedAdminClients as $client)
                        @php
                            $profile = $client->adminClientProfile;
                            $initials = collect(explode(' ', $client->name))->map(fn($w)=>strtoupper($w[0]??''))->take(2)->implode('');
                        @endphp
                        <div class="ac-folder approved">
                            <div class="ac-folder-tab approved">Approved</div>
                            <div class="ac-folder-body">

                                <div class="ac-folder-id-row">
                                    <div class="ac-folder-avatar green">{{ $initials }}</div>
                                    <div style="min-width:0">
                                        <p class="ac-folder-name" title="{{ $client->name }}">{{ $client->name }}</p>
                                        <p class="ac-folder-email" title="{{ $client->email }}">{{ $client->email }}</p>
                                    </div>
                                </div>

                                @if ($profile)
                                    <p class="ac-folder-biz">&#128188; {{ $profile->business_name }}</p>
                                @endif

                                <div>
                                    <span class="ac-folder-status-pill approved">Active</span>
                                    @if ($client->approved_at)
                                        <span style="font-size:10px;color:#94A3B8;font-weight:600;margin-left:6px;">
                                            since {{ $client->approved_at->format('M d, Y') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="ac-folder-stats">
                                    <span class="ac-stat-chip">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0 2c-4 0-7 2-7 3v1h14v-1c0-1-3-3-7-3z"/></svg>
                                        {{ $client->assigned_customers_count }} customers
                                    </span>
                                    <span class="ac-stat-chip">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/></svg>
                                        {{ $client->managed_orders_count }} orders
                                    </span>
                                </div>

                                {{-- assign customer inline --}}
                                <form method="POST" action="{{ route('developer.admin-clients.assign-customer', $client) }}" class="ac-assign-form">
                                    @csrf @method('PATCH')
                                    <input type="email" name="customer_email" placeholder="Assign customer email…" class="ac-assign-input" required>
                                    <button type="submit" class="ac-btn ac-btn-outline" style="white-space:nowrap;">+ Assign</button>
                                </form>

                                <div class="ac-folder-actions">
                                    <a href="{{ route('developer.admin-clients.show', $client) }}" class="ac-btn ac-btn-primary">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5C5.64 5 2 12 2 12s3.64 7 10 7 10-7 10-7-3.64-7-10-7zm0 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-6a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>
                                        Open Folder
                                    </a>
                                    <form method="POST" action="{{ route('developer.admin-clients.suspend', $client) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="ac-btn ac-btn-red">&#9888; Suspend</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- all clients empty --}}
            @if ($pendingAdminClients->isEmpty() && $approvedAdminClients->isEmpty())
                <div class="ac-empty" style="background:white;border:1px solid #E2E8F0;border-radius:16px;padding:48px 16px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    No admin client accounts yet. Use the Invite Admin form to get started.
                </div>
            @endif

        </div>{{-- end left column --}}

        {{-- ── right: invite + audit sidebar ── --}}
        <div>

            <div class="ac-invite-panel">
                <h2>Invite Admin Client</h2>
                <p>The admin sets their own password and profile before developer approval.</p>
                <form method="POST" action="{{ route('developer.admin-clients.store') }}">
                    @csrf
                    <div class="ac-field">
                        <label class="ac-label" for="name">Full Name</label>
                        <input class="ac-input" type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Maria Santos">
                        @error('name')<p style="font-size:11px;color:#DC2626;margin-top:4px;font-weight:700;">{{ $message }}</p>@enderror
                    </div>
                    <div class="ac-field">
                        <label class="ac-label" for="email">Work Email</label>
                        <input class="ac-input" type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="admin@business.com">
                        @error('email')<p style="font-size:11px;color:#DC2626;margin-top:4px;font-weight:700;">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="ac-submit">&#9993; Send Invite</button>
                </form>
            </div>

            <div class="ac-audit-panel">
                <h2>Recent Audit Activity</h2>
                @forelse ($recentAuditLogs as $log)
                    <div class="ac-audit-row">
                        <p class="ac-audit-action">{{ str_replace('_', ' ', ucfirst($log->action)) }}</p>
                        <p class="ac-audit-meta">
                            {{ optional($log->actor)->email ?? 'System' }}
                            @if ($log->targetUser) &rarr; {{ $log->targetUser->email }} @endif
                            &bull; {{ $log->created_at->format('M d, h:i A') }}
                        </p>
                    </div>
                @empty
                    <p style="font-size:12px;color:#94A3B8;font-weight:600;">No audit activity yet.</p>
                @endforelse
            </div>

        </div>{{-- end right column --}}

    </div>{{-- end layout --}}

</div>
</x-app-layout>
