<x-guest-layout>
    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --orange: #ff7a1a;
            --orange-dark: #ff6b16;
            --soft-orange: #f5a25d;
            --text-dark: #171717;
            --text-mid: #6f7d91;
            --text-light: #98a1af;
            --border: #d9dee7;
            --danger: #ef4444;
            --green: #16a34a;
        }

        /* =========================
           ORIGINAL VERIFY OTP BG
           + FORGOT PASSWORD BG DESIGNS
        ========================= */
        .min-h-screen {
            min-height: 100vh !important;
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 20px !important;
            background:
                radial-gradient(circle at 96% 3%, rgba(255, 120, 28, 0.85) 0 45px, transparent 105px),
                radial-gradient(circle at 1% 93%, rgba(255, 120, 28, 0.75) 0 45px, transparent 110px),
                radial-gradient(circle at 90% 90%, rgba(255, 135, 45, 0.18) 0 210px, transparent 360px),
                radial-gradient(circle at 7% 7%, rgba(255, 150, 60, 0.12) 0 220px, transparent 380px),
                linear-gradient(135deg, #fff8f3 0%, #ffffff 45%, #fff4eb 100%) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        /* ORIGINAL VERIFY OTP DOTTED PATTERN */
        .min-h-screen::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(#ff7a2f 1.2px, transparent 1.2px),
                radial-gradient(circle at 86% 36%, transparent 0 5px, rgba(255,255,255,0.55) 6px, transparent 7px);
            background-size: 12px 12px, auto;
            background-position: 62px 52px, center;
            background-repeat: no-repeat;
            opacity: 0.35;
            pointer-events: none;
            z-index: 0;
        }

        .min-h-screen > div:first-child {
            display: none !important;
        }

        .min-h-screen > div:last-child {
            width: 100% !important;
            max-width: none !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            background: transparent !important;
            box-shadow: none !important;
            position: relative !important;
            z-index: 3 !important;
        }

        /* =========================
           FORGOT PASSWORD BG DESIGNS
           DAGDAG LANG SA ORIGINAL BG
        ========================= */
        .forgot-bg-scene {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }

        .blob-tl {
            position: absolute;
            top: -55px;
            left: -58px;
            width: 215px;
            height: 190px;
            background: rgba(246, 196, 154, 0.19);
            border-radius: 42% 58% 41% 59% / 44% 39% 61% 56%;
        }

        .blob-rb {
            position: absolute;
            right: -60px;
            bottom: 115px;
            width: 180px;
            height: 210px;
            background: rgba(246, 196, 154, 0.18);
            border-radius: 54% 46% 37% 63% / 42% 49% 51% 58%;
        }

        .orb-tr {
            position: absolute;
            top: -14px;
            right: -10px;
            width: 125px;
            height: 125px;
            border-radius: 50%;
            background:
                radial-gradient(circle,
                    rgba(255,123,25,1) 0 44px,
                    rgba(255,123,25,0.82) 45px 52px,
                    rgba(255,123,25,0.23) 53px 66px,
                    rgba(255,123,25,0) 67px 100%);
            filter: blur(0.2px);
        }

        .orb-bl {
            position: absolute;
            left: -22px;
            bottom: -18px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background:
                radial-gradient(circle,
                    rgba(255,123,25,1) 0 53px,
                    rgba(255,123,25,0.85) 54px 60px,
                    rgba(255,123,25,0.20) 61px 77px,
                    rgba(255,123,25,0) 78px 100%);
        }

        .lines-top-left {
            position: absolute;
            top: -70px;
            left: -20px;
            width: 560px;
            height: 290px;
            opacity: 0.35;
            background:
                repeating-radial-gradient(
                    ellipse at 42% 78%,
                    rgba(229, 166, 120, 0.42) 0px,
                    rgba(229, 166, 120, 0.42) 1px,
                    transparent 1px,
                    transparent 9px
                );
            transform: rotate(-7deg);
            mask-image: linear-gradient(to bottom, rgba(0,0,0,0.9), rgba(0,0,0,0.05));
            -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,0.9), rgba(0,0,0,0.05));
        }

        .lines-left-mid {
            position: absolute;
            left: -70px;
            top: 235px;
            width: 300px;
            height: 320px;
            opacity: 0.32;
            background:
                repeating-radial-gradient(
                    ellipse at 70% 35%,
                    rgba(229, 166, 120, 0.42) 0px,
                    rgba(229, 166, 120, 0.42) 1px,
                    transparent 1px,
                    transparent 10px
                );
            transform: rotate(7deg);
            mask-image: linear-gradient(to right, rgba(0,0,0,0.95), rgba(0,0,0,0.08));
            -webkit-mask-image: linear-gradient(to right, rgba(0,0,0,0.95), rgba(0,0,0,0.08));
        }

        .lines-bottom {
            position: absolute;
            left: 250px;
            bottom: -110px;
            width: 700px;
            height: 260px;
            opacity: 0.32;
            background:
                repeating-radial-gradient(
                    ellipse at 48% 16%,
                    rgba(229, 166, 120, 0.40) 0px,
                    rgba(229, 166, 120, 0.40) 1px,
                    transparent 1px,
                    transparent 10px
                );
            transform: rotate(2deg);
            mask-image: linear-gradient(to top, rgba(0,0,0,0.95), rgba(0,0,0,0.08));
            -webkit-mask-image: linear-gradient(to top, rgba(0,0,0,0.95), rgba(0,0,0,0.08));
        }

        .soft-center {
            position: absolute;
            left: 330px;
            bottom: 70px;
            width: 230px;
            height: 90px;
            background: radial-gradient(ellipse at center, rgba(240, 242, 247, 0.7) 0%, rgba(240, 242, 247, 0.1) 70%, rgba(240, 242, 247, 0) 100%);
            filter: blur(3px);
        }

        .dots-left {
            position: absolute;
            left: 12px;
            top: 432px;
            width: 62px;
            height: 62px;
            background-image: radial-gradient(circle, rgba(255,123,25,0.70) 1.1px, transparent 1.2px);
            background-size: 12px 12px;
            opacity: 0.95;
        }

        .dots-right {
            position: absolute;
            right: 48px;
            top: 232px;
            width: 62px;
            height: 62px;
            background-image: radial-gradient(circle, rgba(255,123,25,0.70) 1.1px, transparent 1.2px);
            background-size: 12px 12px;
            opacity: 0.95;
        }

        .spark {
            position: absolute;
            width: 18px;
            height: 18px;
            color: rgba(255,123,25,0.85);
        }

        .spark-left {
            left: 82px;
            top: 273px;
        }

        .spark-right {
            right: 148px;
            top: 378px;
        }

        /* =========================
           CARD - SAME WIDTH/HEIGHT SA FORGOT PASSWORD
           ORANGE PART STILL SA TOP
        ========================= */
        .auth-container {
            width: 400px !important;
            max-width: 94vw !important;
            min-height: 400px !important;
            background: #ffffff !important;
            border-radius: 22px !important;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.10) !important;
            overflow: hidden !important;
            position: relative !important;
            text-align: center !important;
            padding: 0 42px 30px !important;
        }

        .orange-header {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, #ff8a1f 0%, #ff4d2d 100%);
            border-radius: 22px 22px 0 0;
            overflow: hidden;
            z-index: 1;
        }

        .orange-header::before {
            content: "";
            position: absolute;
            left: -18%;
            bottom: -75px;
            width: 136%;
            height: 120px;
            background: #ffffff;
            border-radius: 50% 50% 0 0;
        }

        /* ICON - SAME SIZE STYLE SA FORGOT PASSWORD */
        .shield-wrap {
            position: relative;
            z-index: 3;
            width: 80px;
            height: 60px;
            margin: 20px auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            box-shadow: none;
            border-radius: 0;
        }

        .shield-wrap svg {
            width: 38px;
            height: 38px;
            stroke: #ffffff;
            stroke-width: 1.45;
            fill: none;
        }

        /* TITLES */
        .auth-title {
            position: relative;
            z-index: 3;
            font-size: 21px !important;
            font-weight: 700 !important;
            color: #1f2937 !important;
            margin: 0 0 12px !important;
            line-height: 1.2 !important;
        }

        .instruction-text {
            position: relative;
            z-index: 3;
            font-size: 13px !important;
            color: #728096 !important;
            line-height: 1.55 !important;
            width: 285px;
            max-width: 100%;
            margin: 0 auto 16px !important;
        }

        .status-message {
            position: relative;
            z-index: 3;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 12px;
            color: var(--green);
            font-weight: 600;
            line-height: 1.35;
            margin-bottom: 18px;
        }

        .status-message svg {
            width: 18px;
            height: 18px;
            min-width: 18px;
            stroke: var(--green);
            stroke-width: 1.7;
            fill: none;
        }

        .session-status {
            position: relative;
            z-index: 3;
            color: var(--green);
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        form {
            width: 100%;
            position: relative;
            z-index: 3;
        }

        /* OTP BOXES */
        .otp-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 18px;
            z-index: 3;
        }

        .otp-real-input {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 42px;
            opacity: 0;
            z-index: 5;
            cursor: text;
        }

        .otp-group {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 0;
        }

        .otp-box {
            width: 40px;
            height: 40px;
            border: 1px solid var(--border);
            background: #ffffff;
            border-radius: 10px;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            color: #111827;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .otp-box.active {
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(255, 122, 47, 0.12);
        }

        .error-text {
            color: var(--danger);
            font-size: 11px;
            font-weight: 700;
            margin-top: -8px;
            margin-bottom: 12px;
            position: relative;
            z-index: 3;
        }

        /* BUTTON */
        .auth-btn {
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 999px;
            background: linear-gradient(180deg, #171717 0%, #050505 100%);
            color: #ffffff;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
            transform: none !important;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.12);
        }

        .auth-btn:hover {
            background: var(--orange);
            color: #ffffff;
            transform: none !important;
        }

        .auth-btn:active {
            transform: none !important;
        }

        .auth-btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
            transform: none !important;
        }

        /* FOOTER */
        .footer-nav {
            position: relative;
            z-index: 3;
            margin-top: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            width: 100%;
        }

        .timer-info {
            font-size: 12px;
            color: #7b8796;
        }

        .timer-info span {
            color: var(--orange);
            font-weight: 700;
        }

        .lockout-info {
            position: relative;
            z-index: 3;
            width: 100%;
            border: 1px solid #fed7aa;
            background: #fff7ed;
            color: #9a3412;
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
            color: #7c2d12;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .nav-link {
            font-size: 13px;
            color: #7b8796;
            font-weight: 500;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #ef8c2c;
        }

        .resend-link {
            color: var(--green);
            font-weight: 700;
        }

        .resend-link:hover {
            color: #ef8c2c;
        }

        /* BACK TO LOGIN / LOG OUT - SAME SA FORGOT PASSWORD */
        .back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 12px;
            color: #7b8796;
            font-weight: 500;
            text-decoration: none;
            border-bottom: 1px solid transparent;
            padding-bottom: 2px;
            width: fit-content;
            margin: 0 auto;
            transition: color 0.2s ease, border-color 0.2s ease;
        }

        .back-link:hover,
        .back-link:focus,
        .back-link:active {
            color: #ef8c2c;
            border-bottom-color: #ef8c2c;
        }

        .back-link svg {
            width: 12px;
            height: 12px;
            stroke-width: 1.8;
        }

        @media (max-width: 560px) {
            .auth-container {
                width: 92vw !important;
                min-height: auto !important;
                padding: 0 24px 24px !important;
            }

            .otp-group {
                gap: 6px;
            }

            .otp-box {
                width: 36px;
                height: 38px;
                font-size: 18px;
            }

            .auth-title {
                font-size: 21px !important;
            }
        }
    </style>

    <!-- FORGOT PASSWORD BG DESIGN NA DINAGDAG SA ORIGINAL VERIFY OTP BG -->
    <div class="forgot-bg-scene">
        <div class="blob-tl"></div>
        <div class="blob-rb"></div>
        <div class="orb-tr"></div>
        <div class="orb-bl"></div>

        <div class="lines-top-left"></div>
        <div class="lines-left-mid"></div>
        <div class="lines-bottom"></div>
        <div class="soft-center"></div>

        <div class="dots-left"></div>
        <div class="dots-right"></div>

        <svg class="spark spark-left" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 2l1.8 8.2L22 12l-8.2 1.8L12 22l-1.8-8.2L2 12l8.2-1.8L12 2z"/>
        </svg>

        <svg class="spark spark-right" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 2l1.8 8.2L22 12l-8.2 1.8L12 22l-1.8-8.2L2 12l8.2-1.8L12 2z"/>
        </svg>
    </div>

    <div class="auth-container"
        x-data="{
            otp: '',
            timer: {{ max((int) ($resendCooldownSeconds ?? 0), 0) }},
            canResend: {{ (int) ($resendCooldownSeconds ?? 0) <= 0 ? 'true' : 'false' }},
            lockoutTimer: {{ max((int) ($otpLockoutSeconds ?? 0), 0) }},
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

                if (this.canResend) {
                    return;
                }

                let interval = setInterval(() => {
                    if (this.timer > 0) {
                        this.timer--;
                    } else {
                        this.canResend = true;
                        clearInterval(interval);
                    }
                }, 1000);
            },

            cleanOtp() {
                this.otp = this.otp.replace(/[^0-9]/g, '').slice(0, 6);
            }
        }"
    >

        <div class="orange-header"></div>

        <div class="shield-wrap">
            <svg viewBox="0 0 24 24">
                <path d="M12 3L5.5 5.8v5.3c0 4.3 2.7 8.2 6.5 9.9 3.8-1.7 6.5-5.6 6.5-9.9V5.8L12 3z"/>
                <path d="M9.2 12.1l1.8 1.8 3.9-4.1"/>
            </svg>
        </div>

        <h1 class="auth-title">{{ $otpTitle ?? 'Verify Account' }}</h1>

        <p class="instruction-text">
            {{ $otpInstruction ?? 'Please enter the 6-digit security code sent to your email address to continue.' }}
        </p>

        <div class="status-message">
            <svg viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9"></circle>
                <path d="M8.8 12.2l2 2 4.5-4.6"></path>
            </svg>
            <span>{{ $otpStatusMessage ?? 'A 6-digit verification code has been sent to your email.' }}</span>
        </div>

        @if (session('status'))
            <div class="session-status">
                {{ session('status') }}
            </div>
        @endif

        <div x-show="otpLocked" class="lockout-info" role="alert">
            <strong>Verification cooldown active</strong>
            Too many incorrect codes. Please wait <span x-text="Math.ceil(lockoutTimer / 60)"></span> minute<span x-show="Math.ceil(lockoutTimer / 60) !== 1">s</span>
            (<span x-text="lockoutTimer"></span>s) before trying again.
        </div>

        <form method="POST" action="{{ $otpSubmitAction ?? route('customer.otp.submit') }}">
            @csrf

            <input type="hidden" name="email" value="{{ $verificationEmail ?? $email ?? (Auth::user()->email ?? (session('otp_email') ?? request()->email)) }}">
            <input type="hidden" name="otp" :value="otp">
            @if (!empty($verificationFlow))
                <input type="hidden" name="verification_flow" value="{{ $verificationFlow }}">
            @endif

            <div class="otp-wrapper">
                <input
                    type="text"
                    maxlength="6"
                    x-model="otp"
                    @input="cleanOtp()"
                    @paste="$nextTick(() => cleanOtp())"
                    class="otp-real-input"
                    x-bind:disabled="otpLocked"
                    required
                    autofocus
                >

                <div class="otp-group">
                    <template x-for="i in 6" :key="i">
                        <div
                            class="otp-box"
                            :class="{ 'active': otp.length === i-1 }"
                            x-text="otp[i-1] || ''"
                        ></div>
                    </template>
                </div>
            </div>

            @error('otp')
                <div class="error-text">{{ $message }}</div>
            @enderror

            <button type="submit" class="auth-btn" x-bind:disabled="otpLocked || otp.length !== 6">
                Verify Account
            </button>
        </form>

        <div class="footer-nav">
            <form method="POST" action="{{ $otpResendAction ?? route('customer.otp.resend') }}">
                @csrf

                <input type="hidden" name="email" value="{{ $verificationEmail ?? $email ?? (Auth::user()->email ?? (session('otp_email') ?? request()->email)) }}">

                <button type="submit" x-show="canResend && !otpLocked" class="nav-link resend-link">
                    Resend Code
                </button>

                <div x-show="!otpLocked && !canResend" class="timer-info">
                    Resend available in <span x-text="'00:' + String(timer).padStart(2, '0')"></span>
                </div>
            </form>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link back-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6" />
                        </svg>
                        Log Out
                    </button>
                </form>
            @else
                <a href="{{ $otpBackRoute ?? route('login') }}" class="nav-link back-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6" />
                    </svg>
                    {{ $otpBackLabel ?? 'Back to Login' }}
                </a>
            @endauth
        </div>
    </div>
    <style id="customer-auth-shared-bg-final-0615">
        .min-h-screen {
            background:
                linear-gradient(152deg, rgba(255,247,237,.88) 0 28%, rgba(255,255,255,.98) 28.2% 64%, rgba(255,247,237,.82) 64.2% 100%)!important;
            overflow:hidden!important;
        }
        .min-h-screen::before {
            content:""!important;
            position:absolute!important;
            inset:0!important;
            opacity:1!important;
            pointer-events:none!important;
            background-image:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='930' height='300' viewBox='0 0 930 300'%3E%3Cg fill='none' stroke='rgba(255,122,0,.22)' stroke-width='1'%3E%3Cpath d='M-60 122 C86 38 185 230 335 132 S570 36 760 118 S950 220 1010 128'/%3E%3Cpath d='M-60 134 C86 50 185 242 335 144 S570 48 760 130 S950 232 1010 140'/%3E%3Cpath d='M-60 146 C86 62 185 254 335 156 S570 60 760 142 S950 244 1010 152'/%3E%3Cpath d='M-60 158 C86 74 185 266 335 168 S570 72 760 154 S950 256 1010 164'/%3E%3Cpath d='M-60 170 C86 86 185 278 335 180 S570 84 760 166 S950 268 1010 176'/%3E%3Cpath d='M-60 182 C86 98 185 290 335 192 S570 96 760 178 S950 280 1010 188'/%3E%3C/g%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='900' height='300' viewBox='0 0 900 300'%3E%3Cg fill='none' stroke='rgba(255,122,0,.20)' stroke-width='1'%3E%3Cpath d='M-30 170 C95 255 220 70 370 175 S610 262 930 118'/%3E%3Cpath d='M-30 182 C95 267 220 82 370 187 S610 274 930 130'/%3E%3Cpath d='M-30 194 C95 279 220 94 370 199 S610 286 930 142'/%3E%3Cpath d='M-30 206 C95 291 220 106 370 211 S610 298 930 154'/%3E%3Cpath d='M-30 218 C95 303 220 118 370 223 S610 310 930 166'/%3E%3C/g%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cg fill='rgba(255,122,0,.62)'%3E%3Ccircle cx='10' cy='10' r='1.4'/%3E%3Ccircle cx='26' cy='10' r='1.4'/%3E%3Ccircle cx='42' cy='10' r='1.4'/%3E%3Ccircle cx='58' cy='10' r='1.4'/%3E%3Ccircle cx='74' cy='10' r='1.4'/%3E%3Ccircle cx='10' cy='26' r='1.4'/%3E%3Ccircle cx='26' cy='26' r='1.4'/%3E%3Ccircle cx='42' cy='26' r='1.4'/%3E%3Ccircle cx='58' cy='26' r='1.4'/%3E%3Ccircle cx='74' cy='26' r='1.4'/%3E%3Ccircle cx='10' cy='42' r='1.4'/%3E%3Ccircle cx='26' cy='42' r='1.4'/%3E%3Ccircle cx='42' cy='42' r='1.4'/%3E%3Ccircle cx='58' cy='42' r='1.4'/%3E%3Ccircle cx='74' cy='42' r='1.4'/%3E%3Ccircle cx='10' cy='58' r='1.4'/%3E%3Ccircle cx='26' cy='58' r='1.4'/%3E%3Ccircle cx='42' cy='58' r='1.4'/%3E%3Ccircle cx='58' cy='58' r='1.4'/%3E%3Ccircle cx='74' cy='58' r='1.4'/%3E%3C/g%3E%3C/svg%3E")!important;
            background-size:930px 300px,900px 300px,120px 120px!important;
            background-position:left -150px top 82px,right -110px bottom 46px,right 70px center!important;
            background-repeat:no-repeat!important;
            animation:none!important;
        }
        .min-h-screen::after {
            content:""!important;
            position:absolute!important;
            inset:0!important;
            pointer-events:none!important;
            background-image:
                linear-gradient(152deg, transparent 0 28%, rgba(255,255,255,.70) 28.2% 57%, transparent 57.2% 100%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='220' height='180' viewBox='0 0 220 180'%3E%3Cg fill='none' stroke='rgba(255,122,0,.48)' stroke-width='1.6'%3E%3Cpath d='M42 25 C50 45 58 53 78 61 C58 69 50 77 42 97 C34 77 26 69 6 61 C26 53 34 45 42 25Z'/%3E%3Cpath d='M168 118 C174 132 180 138 194 144 C180 150 174 156 168 170 C162 156 156 150 142 144 C156 138 162 132 168 118Z'/%3E%3C/g%3E%3C/svg%3E")!important;
            background-size:100% 100%,220px 180px!important;
            background-position:center,left 80px top 270px!important;
            background-repeat:no-repeat!important;
        }
        .forgot-bg-scene,
        .bg-scene,
        .blob-tl,.blob-rb,.orb-tr,.orb-bl,.lines-top-left,.lines-left-mid,.lines-bottom,.soft-center,.dots-left,.dots-right,.spark {
            display:none!important;
        }
        .auth-container {
            position:relative!important;
            z-index:3!important;
        }
        .footer-nav .nav-link {
            position:relative!important;
            display:inline-flex!important;
            align-items:center!important;
            padding-bottom:2px!important;
            text-decoration:none!important;
        }
        .footer-nav .nav-link::after {
            content:"";
            position:absolute;
            left:0;
            right:0;
            bottom:-1px;
            height:1.5px;
            border-radius:999px;
            background:#ff7a00;
            opacity:0;
            transform:scaleX(0);
            transition:opacity .18s ease,transform .18s ease;
        }
        .footer-nav .nav-link:hover::after,
        .footer-nav .nav-link:focus-visible::after {
            opacity:1;
            transform:scaleX(1);
        }
    </style>
    <style id="auth-otp-field-consistency-0615">
        .auth-shell .otp-box,
        .auth-shell .otp-real-input {
            border-color:#6b7280!important;
        }
    </style>
</x-guest-layout>
