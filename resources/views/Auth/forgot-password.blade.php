<x-guest-layout>
    {{-- 1. LAYOUT RESET --}}
    <style>
        .min-h-screen {
            background-color: #fdf9f5 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 0 !important;
            overflow: hidden !important;
            position: relative !important;
        }

        .min-h-screen > div:first-child {
            display: none !important;
        }

        .min-h-screen > div:last-child {
            width: 100% !important;
            max-width: none !important;
            min-height: 100vh !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            background-color: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>

    {{-- 2. CURRENT UI STYLING --}}
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
        }

        /* =========================
           BACKGROUND DESIGN
        ========================= */
        .bg-scene {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            background:
                radial-gradient(circle at 96% 3%, rgba(255, 120, 28, 0.85) 0 45px, transparent 105px),
                radial-gradient(circle at 1% 93%, rgba(255, 120, 28, 0.75) 0 45px, transparent 110px),
                radial-gradient(circle at 90% 90%, rgba(255, 135, 45, 0.18) 0 210px, transparent 360px),
                radial-gradient(circle at 7% 7%, rgba(255, 150, 60, 0.12) 0 220px, transparent 380px),
                linear-gradient(135deg, #fff8f3 0%, #ffffff 45%, #fff4eb 100%);
            z-index: 0;
        }

        .bg-scene::before {
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
           CARD
        ========================= */
        .forgot-container {
            position: relative;
            z-index: 2;
            width: 400px;
            min-height: 400px;
            background: rgba(255,255,255,0.96);
            border-radius: 22px;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.10);
            overflow: hidden;
            padding: 34px 42px 30px 68px;
        }

        .forgot-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 40px;
            height: 100%;
            background: linear-gradient(180deg, #ff6b16 0%, #ff7a1a 56%, #ff9427 100%);
            border-radius: 22px 0 0 22px;
            box-shadow: inset -7px 0 14px rgba(255,255,255,0.18);
        }

        .card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .top-icon {
            width: 60px;
            height: 40px;
            color: #ef8c2c;
            margin-bottom: 14px;
            stroke-width: 1.45;
        }

        .auth-title {
            margin: 0 0 12px 0;
            font-size: 21px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .instruction-text {
            margin: 0 0 22px 0;
            max-width: 285px;
            font-size: 13px;
            line-height: 1.55;
            color: #728096;
        }

        form {
            width: 100%;
        }

        .form-group {
            width: 100%;
            margin-bottom: 16px;
            text-align: left;
        }

        .label-text {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #252525;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #9aa3b2;
            stroke-width: 1.55;
            pointer-events: none;
        }

        .custom-input {
            width: 95%;
            height: 40px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: #ffffff;
            padding: 0 14px 0 46px;
            font-size: 13px;
            color: #1f2937;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .custom-input::placeholder {
            color: #9aa3b2;
        }

        .custom-input:focus {
            border-color: #ced5df;
            box-shadow: 0 0 0 3px rgba(190, 198, 212, 0.12);
        }

        .info-row {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 8px 0 14px 0;
            font-size: 12px;
            color: #7b8796;
            text-align: left;
        }

        .info-row svg {
            width: 18px;
            height: 18px;
            min-width: 18px;
            color: var(--danger);
            stroke-width: 1.7;
        }

        .backup-row {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            font-size: 12px;
            color: #6b7280;
            text-align: left;
        }

        .backup-row input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 15px;
            height: 15px;
            margin: 0;
            border: 1px solid #1f2937;
            border-radius: 2px;
            background: #ffffff;
            position: relative;
            cursor: pointer;
            flex-shrink: 0;
        }

        .backup-row input[type="checkbox"]:checked {
            background: #111827;
            border-color: #111827;
        }

        .backup-row input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            left: 4px;
            top: 1px;
            width: 4px;
            height: 8px;
            border: solid #ffffff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

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
        }

        .auth-btn:hover {
            background: var(--orange);
            color: #ffffff;
            transform: none !important;
        }

        .auth-btn:active {
            transform: none !important;
        }

        .back-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 22px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 13px;
            color: #7b8796;
            font-weight: 500;
            text-decoration: none;
            border-bottom: 1px solid transparent;
            padding-bottom: 2px;
            width: 35%;
            transition: color 0.2s ease, border-color 0.2s ease;
        }

        .back-link:hover,
        .back-link:focus,
        .back-link:active {
            color: #ef8c2c;
            border-bottom-color: #ef8c2c;
        }

        .back-link svg {
            width: 15px;
            height: 15px;
            stroke-width: 1.8;
        }

        .error-text,
        .text-xs {
            margin-top: 6px;
            font-size: 11px;
            color: var(--danger);
        }

        .status-text {
            margin-bottom: 12px;
            font-size: 12px;
            color: #16a34a;
        }

        @media (max-width: 560px) {
            .forgot-container {
                width: 92vw;
                min-height: auto;
                padding: 30px 24px 24px 52px;
            }

            .back-link {
                width: auto;
            }
        }
    </style>

    <div class="bg-scene">
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

    <div class="forgot-container">
        <div class="card-content">
            <svg class="top-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.75h16v10.5H4V6.75z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7l8 6 8-6" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 14.25v-1.2a2 2 0 114 0v1.2" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 14.25h5.5v4.5h-5.5v-4.5z" />
            </svg>

            <h1 class="auth-title">Forgot Password</h1>

            <p class="instruction-text">
                {{ __('Enter your email address and we will send you a code to reset your password.') }}
            </p>

            <x-auth-session-status class="status-text" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email" id="email-label" class="label-text">
                        {{ __('Email Address') }}
                    </label>

                    <div class="input-wrapper">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.75h16v10.5H4V6.75z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7l8 6 8-6" />
                        </svg>

                        <input
                            id="email"
                            class="custom-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="name@example.com"
                            required
                            autofocus
                        >
                    </div>

                    <x-input-error :messages="$errors->get('email')" class="error-text" />
                </div>

                <div class="info-row">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16h.01" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ __('We’ll send a secure code to your email.') }}</span>
                </div>

                <div class="backup-row">
                    <input
                        id="use_backup"
                        type="checkbox"
                        name="use_backup"
                        value="1"
                        onchange="toggleEmailLabel()"
                    >

                    <label for="use_backup">
                        {{ __('Use recovery email') }}
                    </label>
                </div>

                <button type="submit" class="auth-btn">
                    {{ __('Send Reset Code') }}
                </button>

                <div class="back-wrapper">
                    <a class="back-link" href="{{ route('login') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6" />
                        </svg>
                        {{ __('Back to Login') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleEmailLabel() {
            const checkbox = document.getElementById('use_backup');
            const label = document.getElementById('email-label');
            const input = document.getElementById('email');

            if (checkbox.checked) {
                label.innerText = "{{ __('Recovery Email') }}";
                input.placeholder = "Enter your recovery email";
            } else {
                label.innerText = "{{ __('Email Address') }}";
                input.placeholder = "name@example.com";
            }
        }
    </script>
</x-guest-layout>