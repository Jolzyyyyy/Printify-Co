@php
    $otpLockoutSeconds = $otpLockoutSeconds ?? 0;
    $resendCooldownSeconds = $resendCooldownSeconds ?? 0;
@endphp

<x-guest-layout>
    {{-- 1. LAYOUT OVERRIDE (Same as Customer) --}}
    <style>
        html,
        body {
            min-height: 100% !important;
            margin: 0 !important;
            background: #f8fafc !important;
        }

        .min-h-screen {
            background-color: #f3f4f6 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            min-height: 100vh !important;
            height: 100vh !important;
            padding: 0 !important;
        }
        
        .min-h-screen > div:first-child { display: none !important; }

        .min-h-screen > div:last-child {
            width: 100% !important;
            min-height: 100vh !important;
            height: 100vh !important;
            max-width: none !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            background-color: transparent !important;
            box-shadow: none !important;
            margin: 0 !important;
            padding: 24px !important;
            overflow: hidden !important;
        }
    </style>

    {{-- 2. EXACT CUSTOMER UI DIMENSIONS & SPACING (Admin Theme Colors) --}}
    <style>
        .auth-container {
            background-color: #fff !important;
            border-radius: 20px !important;
            box-shadow: 0 24px 70px rgba(15,23,42,0.14), 0 10px 22px rgba(15,23,42,0.06) !important;
            width: 420px !important;
            max-width: min(92vw, 420px) !important;
            padding: 34px 32px 30px !important;
            text-align: center !important;
            box-sizing: border-box !important;
            border: 1px solid rgba(226,232,240,.9) !important;
        }

        .auth-title {
            font-size: 1.45rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-bottom: 0.65rem !important;
            text-transform: none !important;
            letter-spacing: normal !important;
            line-height: 1.2 !important;
        }

        .instruction-text {
            font-size: 13px !important;
            color: #475569 !important;
            line-height: 1.55 !important;
            margin: 0 auto 22px !important;
            max-width: 310px !important;
        }

        .otp-input {
            background-color: #f0f2f5 !important;
            border: none !important;
            padding: 12px 15px !important;
            border-radius: 8px !important; 
            width: 100% !important;
            font-size: 24px !important;
            font-weight: 800 !important;
            letter-spacing: 0.4em !important;
            text-align: center !important;
            color: #1a202c !important;
            box-sizing: border-box !important;
            outline: none !important;
            margin-bottom: 5px !important;
            box-shadow: inset 0 0 0 1px rgba(226,232,240,.7) !important;
        }

        .auth-btn {
            background-color: #4f46e5 !important; /* ADMIN THEME BLUE */
            color: white !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            padding: 10px 0 !important;
            border-radius: 25px !important;
            width: 100% !important;
            margin-top: 15px !important;
            cursor: pointer !important;
            font-size: 12px !important;
            letter-spacing: 1px !important;
            border: none !important;
            transition: all 0.2s ease !important;
            display: block !important;
        }

        .auth-btn:hover { background-color: #4338ca !important; }
        .auth-btn:active { transform: scale(0.98) !important; }
        .auth-btn:disabled { background-color: #cbd5e1 !important; cursor: not-allowed !important; }

        .footer-nav {
            margin-top: 14px !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 6px !important;
        }

        .nav-link {
            font-size: 13px !important;
            color: #64748b !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            background: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            cursor: pointer !important;
        }

        .nav-link:hover { 
            color: #4f46e5 !important; 
            text-decoration: underline !important;
        }

        .resend-link {
            color: #4f46e5 !important; /* ADMIN THEME BLUE */
            font-weight: 700 !important;
        }

        .timer-info {
            font-size: 12px !important;
            color: #94a3b8 !important;
            font-style: italic !important;
            margin-top: 12px !important;
            margin-bottom: 5px !important;
        }

        .lockout-info {
            border: 1px solid #fecaca;
            background: #fff1f2;
            color: #991b1b;
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.35;
            text-align: left;
        }

        .lockout-info strong {
            display: block;
            color: #7f1d1d;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
    </style>

    <div class="auth-container"
         x-data="{
            otp: '',
            timer: {{ max((int) $resendCooldownSeconds, 0) }},
            canResend: {{ (int) $resendCooldownSeconds <= 0 ? 'true' : 'false' }},
            lockoutTimer: {{ max((int) $otpLockoutSeconds, 0) }},
            get otpLocked() {
                return this.lockoutTimer > 0;
            },
            init() {
                if (this.lockoutTimer > 0) {
                    let lockoutInterval = setInterval(() => {
                        if (this.lockoutTimer > 0) {
                            this.lockoutTimer--;
                        } else {
                            clearInterval(lockoutInterval);
                        }
                    }, 1000);
                }

                if (this.canResend) return;

                let interval = setInterval(() => {
                    if (this.timer > 0) {
                        this.timer--;
                    } else {
                        this.canResend = true;
                        clearInterval(interval);
                    }
                }, 1000);
            }
         }">
        <noscript>
            <style>
                [x-show] { display: none !important; }
            </style>
        </noscript>
        
        <h1 class="auth-title">Verify {{ $portalRoleLabel ?? session('admin_role_label', 'Staff') }} Account</h1>
        
        <p class="instruction-text">
            Please enter the 6-digit security code sent to your email address to continue to your {{ $portalDashboardLabel ?? session('admin_dashboard_label', 'staff dashboard') }}.
        </p>

        @if((int) $otpLockoutSeconds > 0)
            <div class="lockout-info" role="alert" data-lockout-box>
                <strong>Verification cooldown active</strong>
                Too many incorrect codes. Please wait
                <span data-lockout-minutes>{{ (int) ceil($otpLockoutSeconds / 60) }}</span>
                minute<span data-lockout-minute-label>{{ (int) ceil($otpLockoutSeconds / 60) === 1 ? '' : 's' }}</span>
                (<span data-lockout-seconds>{{ (int) $otpLockoutSeconds }}</span>s) before trying again.
            </div>
        @endif

        @if (session('status'))
            <div style="color: #16a34a; font-size: 12px; font-weight: 600; margin-bottom: 10px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.otp.submit') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('admin_email') }}">

            <input
                id="otp"
                type="text"
                name="otp"
                x-model="otp"
                @input="otp = otp.replace(/[^0-9]/g, '')"
                maxlength="6"
                placeholder="000000"
                class="otp-input"
                x-bind:disabled="otpLocked"
                @disabled((int) $otpLockoutSeconds > 0)
                required
                autofocus
            />

            @error('otp')
                <div style="color: #dc2626; font-size: 11px; font-weight: 700; margin-top: 5px;">{{ $message }}</div>
            @enderror

            <button type="submit" class="auth-btn" x-bind:disabled="otpLocked || otp.length !== 6" @disabled((int) $otpLockoutSeconds > 0)>
                Verify My Account
            </button>
        </form>

        <div class="footer-nav">
            {{-- Resend Logic Section --}}
            <div>
                <form method="POST" action="{{ route('admin.otp.resend') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('admin_email') }}">
                    
                    @if((int) $otpLockoutSeconds <= 0 && (int) $resendCooldownSeconds <= 0)
                        <button type="submit" class="nav-link resend-link">
                            Resend Code
                        </button>
                    @elseif((int) $otpLockoutSeconds <= 0)
                        <div class="timer-info">
                            Resend available in <span data-resend-seconds style="color:#4f46e5; font-weight: bold;">{{ (int) $resendCooldownSeconds }}</span>s
                        </div>
                    @endif
                </form>
            </div>

            {{-- Logout Section --}}
            <div style="margin-top: -2px;">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link">
                        Cancel
                    </button>
                </form>
            </div>
        </div>
    </div>
    <style id="staff-otp-blue-wave-bg-final-0624">
        body {
            min-height:100vh!important;
            background:#f8fafc!important;
            overflow:hidden!important;
        }
        .min-h-screen {
            background:
                linear-gradient(151deg, rgba(239, 242, 255, .90) 0 27%, rgba(255, 255, 255, .96) 27.2% 63%, rgba(239, 242, 255, .86) 63.2% 100%),
                linear-gradient(26deg, transparent 0 72%, rgba(49, 88, 255, .14) 72.2% 74%, transparent 74.2% 100%) !important;
            position:relative!important;
            min-height:100vh!important;
            height:100vh!important;
            overflow:hidden!important;
            isolation:isolate!important;
        }
        .min-h-screen::before,
        .min-h-screen::after {
            content:""!important;
            position:absolute!important;
            inset:0!important;
            pointer-events:none!important;
            display:block!important;
        }
        .min-h-screen::before {
            z-index:0!important;
            opacity:1!important;
            background-image:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='880' height='300' viewBox='0 0 880 300'%3E%3Cg fill='none' stroke='rgba(49,88,255,.23)' stroke-width='1'%3E%3Cpath d='M-40 145 C80 60 170 245 310 155 S535 55 720 135 S920 225 980 135'/%3E%3Cpath d='M-40 157 C80 72 170 257 310 167 S535 67 720 147 S920 237 980 147'/%3E%3Cpath d='M-40 169 C80 84 170 269 310 179 S535 79 720 159 S920 249 980 159'/%3E%3Cpath d='M-40 181 C80 96 170 281 310 191 S535 91 720 171 S920 261 980 171'/%3E%3Cpath d='M-40 193 C80 108 170 293 310 203 S535 103 720 183 S920 273 980 183'/%3E%3Cpath d='M-40 205 C80 120 170 305 310 215 S535 115 720 195 S920 285 980 195'/%3E%3C/g%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='760' height='260' viewBox='0 0 760 260'%3E%3Cg fill='none' stroke='rgba(49,88,255,.20)' stroke-width='1'%3E%3Cpath d='M-25 78 C95 170 215 -20 355 92 S575 188 790 62'/%3E%3Cpath d='M-25 90 C95 182 215 -8 355 104 S575 200 790 74'/%3E%3Cpath d='M-25 102 C95 194 215 4 355 116 S575 212 790 86'/%3E%3Cpath d='M-25 114 C95 206 215 16 355 128 S575 224 790 98'/%3E%3C/g%3E%3C/svg%3E"),
                radial-gradient(circle, rgba(49, 88, 255, .66) 1.4px, transparent 1.8px);
            background-size:930px 300px,900px 300px,120px 120px!important;
            background-position:left -150px top 82px,right -110px bottom 46px,right 70px center!important;
            background-repeat:no-repeat!important;
        }
        .min-h-screen::after {
            z-index:1!important;
            opacity:1!important;
            background-image:
                linear-gradient(152deg, transparent 0 28%, rgba(255, 255, 255, .70) 28.2% 57%, transparent 57.2% 100%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='220' height='180' viewBox='0 0 220 180'%3E%3Cg fill='none' stroke='rgba(49,88,255,.48)' stroke-width='1.6'%3E%3Cpath d='M42 25 C50 45 58 53 78 61 C58 69 50 77 42 97 C34 77 26 69 6 61 C26 53 34 45 42 25Z'/%3E%3Cpath d='M168 118 C174 132 180 138 194 144 C180 150 174 156 168 170 C162 156 156 150 142 144 C156 138 162 132 168 118Z'/%3E%3C/g%3E%3C/svg%3E")!important;
            background-size:100% 100%,220px 180px!important;
            background-position:center,left 80px top 270px!important;
            background-repeat:no-repeat!important;
        }
        .min-h-screen > div:last-child {
            min-height:100vh!important;
            height:100vh!important;
            display:flex!important;
            align-items:center!important;
            justify-content:center!important;
            margin:0!important;
            padding:24px!important;
            overflow:hidden!important;
        }
        .min-h-screen > div:last-child,
        .auth-container {
            position:relative!important;
            z-index:10!important;
        }
        @media(max-width:640px){
            .min-h-screen > div:last-child{padding:16px!important}
            .auth-container{width:100%!important;max-width:390px!important;padding:28px 22px 24px!important}
            .auth-title{font-size:1.25rem!important}
            .otp-input{font-size:22px!important;letter-spacing:.32em!important}
        }
    </style>
    <script>
        (function(){
            var lockoutSeconds = Number(document.querySelector('[data-lockout-seconds]')?.textContent || 0);
            var resendSeconds = Number(document.querySelector('[data-resend-seconds]')?.textContent || 0);
            var lockoutBox = document.querySelector('[data-lockout-box]');
            var lockoutSecondsEl = document.querySelector('[data-lockout-seconds]');
            var lockoutMinutesEl = document.querySelector('[data-lockout-minutes]');
            var lockoutMinuteLabelEl = document.querySelector('[data-lockout-minute-label]');
            var resendSecondsEl = document.querySelector('[data-resend-seconds]');

            if (lockoutSeconds > 0 && lockoutSecondsEl) {
                var lockoutInterval = window.setInterval(function(){
                    lockoutSeconds -= 1;
                    var minutes = Math.ceil(Math.max(lockoutSeconds, 0) / 60);
                    lockoutSecondsEl.textContent = String(Math.max(lockoutSeconds, 0));
                    if (lockoutMinutesEl) lockoutMinutesEl.textContent = String(minutes);
                    if (lockoutMinuteLabelEl) lockoutMinuteLabelEl.textContent = minutes === 1 ? '' : 's';
                    if (lockoutSeconds <= 0) {
                        window.clearInterval(lockoutInterval);
                        if (lockoutBox) lockoutBox.style.display = 'none';
                        window.location.reload();
                    }
                }, 1000);
            }

            if (resendSeconds > 0 && resendSecondsEl) {
                var resendInterval = window.setInterval(function(){
                    resendSeconds -= 1;
                    resendSecondsEl.textContent = String(Math.max(resendSeconds, 0));
                    if (resendSeconds <= 0) {
                        window.clearInterval(resendInterval);
                        window.location.reload();
                    }
                }, 1000);
            }
        })();
    </script>
</x-guest-layout>
