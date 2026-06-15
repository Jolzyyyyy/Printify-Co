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

    {{-- 2. RESET PASSWORD UI STYLING --}}
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
            --success: #16a34a;
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
           MAIN CARD
        ========================= */
        .reset-container {
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

        .reset-container::before {
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

        .password-input {
            padding-right: 46px;
        }

        .eye-icon-btn {
            position: absolute;
            top: 50%;
            right: 22px;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            padding: 0;
            margin: 0;
            border: none;
            outline: none;
            background: transparent;
            cursor: pointer;
            color: #9aa3b2;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
        }

        .eye-icon-btn:hover {
            color: #171717;
        }

        .eye-icon-btn svg {
            width: 20px;
            height: 20px;
            stroke-width: 1.8;
        }

        .validation-grid {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 14px;
            row-gap: 8px;
            margin: 4px 0 18px 0;
            text-align: left;
        }

        .validation-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            line-height: 1.25;
            color: #7b8796;
        }

        .validation-item svg {
            width: 14px;
            height: 14px;
            min-width: 14px;
            stroke-width: 2;
        }

        .validation-neutral {
            color: #98a1af;
        }

        .validation-error {
            color: var(--danger);
        }

        .validation-success {
            color: var(--success);
            font-weight: 700;
        }

        .validation-success svg {
            stroke: var(--success);
        }

        .validation-error svg {
            stroke: var(--danger);
        }

        .validation-neutral svg {
            stroke: #98a1af;
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
            color: var(--success);
        }

        /* =========================
           SMOOTH SUCCESS POPUP
           SAME GREEN LINE POSITION
        ========================= */
        .success-comment-wrap {
            position: fixed;
            top: calc(50% - 105px);
            left: 50%;
            transform: translateX(-50%);
            z-index: 10005;
            width: 320px;
            max-width: 320px;
            text-align: center;
            pointer-events: none;
        }

        .success-comment {
            display: inline-block;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            outline: none !important;
            padding: 0;
            margin: 0;

            color: #111111;
            font-size: 11px;
            font-weight: 500;
            line-height: 1.25;
            text-align: center;

            animation: smoothSuccessPop 0.45s cubic-bezier(0.16, 1, 0.3, 1) both;
            transform-origin: center;
        }

        .success-comment strong {
            color: #00b050;
            font-weight: 700;
        }

        @keyframes smoothSuccessPop {
            0% {
                opacity: 0;
                transform: translateY(8px) scale(0.86);
                filter: blur(2px);
            }

            55% {
                opacity: 1;
                transform: translateY(-2px) scale(1.05);
                filter: blur(0);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        /* =========================
           MODALS
        ========================= */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(0, 0, 0, 0.50);
        }

        .modal-overlay[hidden] {
            display: none !important;
        }

        .modal-box {
            width: 100%;
            max-width: 435px;
            height: auto;
            min-height: 56px;
            background: rgba(255, 255, 255, 0.88);
            border-radius: 9px;
            padding: 14px 22px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.14);
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .modal-title {
            margin: 0;
            font-size: 16px;
            font-weight: 500;
            color: #111111;
            text-transform: none;
            letter-spacing: 0;
            line-height: 1.25;
            white-space: normal;
        }

        .modal-copy {
            margin: 5px 0 0;
            color: #6b7280;
            font-size: 12px;
            line-height: 1.35;
        }

        .modal-success {
            color: #00b050;
            font-weight: 600;
        }

        .modal-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 24px;
            margin-top: 0;
            margin-left: auto;
            height: 100%;
        }

        .modal-btn {
            flex: unset;
            min-width: auto;
            height: 56px;
            padding: 0;
            border: none;
            background: transparent;
            border-radius: 0;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            text-transform: none;
            line-height: 1;
            transition: color 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }

        .modal-btn-dark {
            background: transparent;
            color: #00b050;
        }

        .modal-btn-dark:hover,
        .modal-btn-dark:focus,
        .modal-btn-dark:active {
            color: #000000;
            background: transparent;
        }

        .modal-btn-light {
            background: transparent;
            color: #111111;
        }

        .modal-btn-light:hover,
        .modal-btn-light:focus,
        .modal-btn-light:active {
            color: #000000;
            background: transparent;
        }

        .success-modal-box {
            width: 100%;
            max-width: 545px;
            height: auto;
            min-height: 56px;
            padding: 16px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 9px;
            background: rgba(255, 255, 255, 0.88);
        }

        .success-modal-box .modal-title {
            margin: 0;
            line-height: 1.2;
        }

        .success-modal-box .modal-actions {
            gap: 10px;
            height: auto;
            flex-wrap: wrap;
        }

        .success-modal-box .modal-btn {
            height: 30px;
            min-width: 122px;
            padding: 0 18px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
        }

        .success-modal-box .modal-btn-dark {
            background: #171717;
            color: #ffffff;
            border-color: #171717;
        }

        .success-modal-box .modal-btn-dark:hover,
        .success-modal-box .modal-btn-dark:focus,
        .success-modal-box .modal-btn-dark:active {
            background: #000000;
            color: #ffffff;
            border-color: #000000;
        }

        .success-modal-box .modal-btn-light {
            background: rgba(255, 255, 255, 0.70);
            color: #111827;
            border-color: #d7d7d7;
        }

        .success-modal-box .modal-btn-light:hover,
        .success-modal-box .modal-btn-light:focus,
        .success-modal-box .modal-btn-light:active {
            background: #000000;
            color: #ffffff;
            border-color: #000000;
        }

        .success-modal-box .modal-btn-cancel {
            min-width: 76px;
            background: transparent;
            color: #6b7280;
            border-color: transparent;
        }

        .success-modal-box .modal-btn-cancel:hover,
        .success-modal-box .modal-btn-cancel:focus,
        .success-modal-box .modal-btn-cancel:active {
            background: #f3f4f6;
            color: #111827;
            border-color: #e5e7eb;
        }

        [x-cloak] {
            display: none !important;
        }

        @media (max-width: 560px) {
            .reset-container {
                width: 92vw;
                min-height: auto;
                padding: 30px 24px 24px 52px;
            }

            .validation-grid {
                grid-template-columns: 1fr;
            }

            .back-link {
                width: auto;
            }

            .success-comment-wrap {
                top: calc(50% - 104px);
                width: 260px;
                max-width: 260px;
            }

            .success-comment {
                font-size: 10px;
            }

            .modal-box {
                max-width: 90vw;
                height: auto;
                min-height: 54px;
                padding: 0 18px;
            }

            .modal-title {
                font-size: 15px;
            }

            .modal-actions {
                gap: 18px;
            }

            .modal-btn {
                height: 54px;
                font-size: 15px;
            }

            .success-modal-box {
                max-width: 90vw;
                height: auto;
                min-height: 54px;
                padding: 14px 18px;
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }

            .success-modal-box .modal-actions {
                width: 100%;
                gap: 8px;
            }

            .success-modal-box .modal-btn {
                height: 28px;
                min-width: 0;
                flex: 1 1 auto;
                padding: 0 12px;
                font-size: 11px;
            }
        }
    </style>

    {{-- BACKGROUND --}}
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

    {{-- RESET PASSWORD CARD --}}
    <div class="reset-container">
        <div class="card-content">
            <h1 class="auth-title">Reset Password</h1>

            <p class="instruction-text">
                {{ __('Set a new password for your account.') }}
            </p>

            <x-auth-session-status class="status-text" :status="session('status')" />

            <form method="POST" action="{{ route('password.store') }}" id="resetForm" novalidate>
                @csrf

                <input
                    type="hidden"
                    name="token"
                    value="{{ $token ?? (request()->route('token') ?? session('password_reset_token')) }}"
                >

                {{-- EMAIL --}}
                <div class="form-group">
                    <label for="email" class="label-text">
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
                            value="{{ old('email', $email ?? request('email') ?? session('password_reset_email')) }}"
                            placeholder="name@example.com"
                            required
                            autofocus
                        >
                    </div>

                    <x-input-error :messages="$errors->get('email')" class="error-text" />
                </div>

                {{-- NEW PASSWORD --}}
                <div class="form-group">
                    <label for="password" class="label-text">
                        {{ __('New Password') }}
                    </label>

                    <div class="input-wrapper">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 10.5V7.75a4.5 4.5 0 019 0v2.75" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 10.5h12v8.25H6V10.5z" />
                        </svg>

                        <input
                            id="password"
                            class="custom-input password-input"
                            type="password"
                            name="password"
                            placeholder="New Password"
                            required
                            autocomplete="new-password"
                        >

                        <button type="button" class="eye-icon-btn" onclick="togglePasswordVisibility('password', 'eye-1')">
                            <svg id="eye-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 01-4.24-4.24" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="error-text" />
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="form-group">
                    <label for="password_confirmation" class="label-text">
                        {{ __('Confirm New Password') }}
                    </label>

                    <div class="input-wrapper">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 10.5V7.75a4.5 4.5 0 019 0v2.75" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 10.5h12v8.25H6V10.5z" />
                        </svg>

                        <input
                            id="password_confirmation"
                            class="custom-input password-input"
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm New Password"
                            required
                            autocomplete="new-password"
                        >

                        <button type="button" class="eye-icon-btn" onclick="togglePasswordVisibility('password_confirmation', 'eye-2')">
                            <svg id="eye-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 01-4.24-4.24" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="error-text" />
                </div>

                {{-- VALIDATION RULES --}}
                <div class="validation-grid">
                    <div class="validation-item validation-neutral" data-rule="length">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('At least 8 characters') }}</span>
                    </div>

                    <div class="validation-item validation-neutral" data-rule="symbol">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Contains special symbol') }}</span>
                    </div>

                    <div class="validation-item validation-neutral" data-rule="number">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Must include a number') }}</span>
                    </div>

                    <div class="validation-item validation-neutral" data-rule="match">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Passwords must match') }}</span>
                    </div>
                </div>

                <button type="button" class="auth-btn" data-open-reset-confirm>
                    {{ __('Reset Password') }}
                </button>

                <div class="back-wrapper">
                    <a class="back-link" href="{{ ($resetPortal ?? session('password_reset_portal') ?? 'customer') === 'staff' ? route('admin.login') : route('login') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6" />
                        </svg>
                        {{ __($resetLoginLabel ?? 'Back to Login') }}
                    </a>
                </div>

                {{-- CONFIRM RESET MODAL --}}
                <div class="modal-overlay" data-requirements-modal hidden>
                    <div class="modal-box">
                        <h3 class="modal-title">
                            {{ __('Please complete all password requirements.') }}
                        </h3>

                        <div class="modal-actions">
                            <button
                                type="button"
                                class="modal-btn modal-btn-dark"
                                data-close-requirements
                            >
                                {{ __('OK') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- CONFIRM RESET MODAL --}}
                <div class="modal-overlay" data-confirm-reset-modal hidden>
                    <div class="modal-box success-modal-box">
                        <div>
                            <h3 class="modal-title">
                                {{ __('Confirm password reset') }}
                            </h3>
                            <p class="modal-copy">
                                {{ __('Choose where to continue after your password is updated.') }}
                            </p>
                        </div>

                        <div class="modal-actions">
                            <button
                                type="button"
                                class="modal-btn modal-btn-dark"
                                data-submit-reset="auto_login"
                            >
                                {{ __('Go to ') . __($resetDashboardLabel ?? 'Dashboard') }}
                            </button>

                            <button
                                type="button"
                                class="modal-btn modal-btn-light"
                                data-submit-reset="manual_login"
                            >
                                {{ __('Go to ') . __($resetLoginLabel ?? 'Login') }}
                            </button>

                            <button
                                type="button"
                                class="modal-btn modal-btn-cancel"
                                data-close-confirm
                            >
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        (() => {
            const form = document.getElementById('resetForm');
            if (!form) return;

            const password = document.getElementById('password');
            const confirmation = document.getElementById('password_confirmation');
            const confirmModal = form.querySelector('[data-confirm-reset-modal]');
            const requirementsModal = form.querySelector('[data-requirements-modal]');
            const openConfirmButton = form.querySelector('[data-open-reset-confirm]');
            const closeRequirements = form.querySelector('[data-close-requirements]');
            const closeConfirm = form.querySelector('[data-close-confirm]');
            const submitButtons = Array.from(form.querySelectorAll('[data-submit-reset]'));
            const ruleItems = {
                length: form.querySelector('[data-rule="length"]'),
                symbol: form.querySelector('[data-rule="symbol"]'),
                number: form.querySelector('[data-rule="number"]'),
                match: form.querySelector('[data-rule="match"]'),
            };

            let passwordTouched = false;
            let confirmationTouched = false;

            const rules = () => {
                const value = password?.value || '';
                const confirmValue = confirmation?.value || '';

                return {
                    length: value.length >= 8,
                    symbol: /[!@#$%^&*(),.?':{}|<>]/.test(value),
                    number: /[0-9]/.test(value),
                    match: value !== '' && value === confirmValue,
                };
            };

            const setRuleState = (item, state) => {
                if (!item) return;

                item.classList.remove('validation-neutral', 'validation-success', 'validation-error');
                item.classList.add(state);
            };

            const renderRules = (forceDirty = false) => {
                const current = rules();
                const passDirty = forceDirty || passwordTouched;
                const confirmDirty = forceDirty || confirmationTouched;

                setRuleState(ruleItems.length, !passDirty ? 'validation-neutral' : (current.length ? 'validation-success' : 'validation-error'));
                setRuleState(ruleItems.symbol, !passDirty ? 'validation-neutral' : (current.symbol ? 'validation-success' : 'validation-error'));
                setRuleState(ruleItems.number, !passDirty ? 'validation-neutral' : (current.number ? 'validation-success' : 'validation-error'));
                setRuleState(ruleItems.match, !confirmDirty ? 'validation-neutral' : (current.match ? 'validation-success' : 'validation-error'));

                return Object.values(current).every(Boolean);
            };

            const show = (element) => {
                if (element) element.hidden = false;
            };

            const hide = (element) => {
                if (element) element.hidden = true;
            };

            password?.addEventListener('input', () => {
                passwordTouched = true;
                renderRules();
            });

            confirmation?.addEventListener('input', () => {
                confirmationTouched = true;
                renderRules();
            });

            openConfirmButton?.addEventListener('click', () => {
                passwordTouched = true;
                confirmationTouched = true;

                if (renderRules(true)) {
                    show(confirmModal);
                    return;
                }

                show(requirementsModal);
            });

            closeRequirements?.addEventListener('click', () => hide(requirementsModal));
            closeConfirm?.addEventListener('click', () => hide(confirmModal));
            confirmModal?.addEventListener('click', (event) => {
                if (event.target === confirmModal) {
                    hide(confirmModal);
                }
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    hide(confirmModal);
                    hide(requirementsModal);
                }
            });

            submitButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    passwordTouched = true;
                    confirmationTouched = true;

                    if (!renderRules(true)) {
                        hide(confirmModal);
                        show(requirementsModal);
                        return;
                    }

                    form.querySelectorAll('input[name="action_type"]').forEach((input) => input.remove());

                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action_type';
                    actionInput.value = button.dataset.submitReset || 'auto_login';
                    form.appendChild(actionInput);

                    HTMLFormElement.prototype.submit.call(form);
                });
            });

            renderRules();
        })();

        function togglePasswordVisibility(inputId, svgId) {
            const input = document.getElementById(inputId);
            const svg = document.getElementById(svgId);

            if (!input || !svg) return;

            if (input.type === "password") {
                input.type = "text";

                svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
            } else {
                input.type = "password";

                svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 01-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                `;
            }
        }
    </script>
</x-guest-layout>
