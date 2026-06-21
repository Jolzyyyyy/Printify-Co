<x-guest-layout>
    <style>
        :root {
            --primary-blue: #3158ff;
            --blue-mid: #4f46e5;
            --blue-deep: #241f9f;
            --dark-blue: #111827;
            --muted-text: #8b94a7;
            --line-blue: rgba(49, 88, 255, .22);
            --slide-ease: cubic-bezier(0.83, 0, 0.17, 1);
            --slide-time: 0.95s;
            --content-time: 0.72s;
        }

        .min-h-screen {
            min-height: 100vh !important;
            background:
                linear-gradient(151deg, rgba(239, 242, 255, .90) 0 27%, rgba(255, 255, 255, .96) 27.2% 63%, rgba(239, 242, 255, .86) 63.2% 100%),
                linear-gradient(26deg, transparent 0 72%, rgba(49, 88, 255, .14) 72.2% 74%, transparent 74.2% 100%) !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 0 !important;
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .min-h-screen::before,
        .min-h-screen::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 1;
        }

        .min-h-screen::before {
            opacity: 1 !important;
            background-image:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='880' height='300' viewBox='0 0 880 300'%3E%3Cg fill='none' stroke='rgba(49,88,255,.23)' stroke-width='1'%3E%3Cpath d='M-40 145 C80 60 170 245 310 155 S535 55 720 135 S920 225 980 135'/%3E%3Cpath d='M-40 157 C80 72 170 257 310 167 S535 67 720 147 S920 237 980 147'/%3E%3Cpath d='M-40 169 C80 84 170 269 310 179 S535 79 720 159 S920 249 980 159'/%3E%3Cpath d='M-40 181 C80 96 170 281 310 191 S535 91 720 171 S920 261 980 171'/%3E%3Cpath d='M-40 193 C80 108 170 293 310 203 S535 103 720 183 S920 273 980 183'/%3E%3Cpath d='M-40 205 C80 120 170 305 310 215 S535 115 720 195 S920 285 980 195'/%3E%3C/g%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='760' height='260' viewBox='0 0 760 260'%3E%3Cg fill='none' stroke='rgba(49,88,255,.20)' stroke-width='1'%3E%3Cpath d='M-25 78 C95 170 215 -20 355 92 S575 188 790 62'/%3E%3Cpath d='M-25 90 C95 182 215 -8 355 104 S575 200 790 74'/%3E%3Cpath d='M-25 102 C95 194 215 4 355 116 S575 212 790 86'/%3E%3Cpath d='M-25 114 C95 206 215 16 355 128 S575 224 790 98'/%3E%3C/g%3E%3C/svg%3E"),
                radial-gradient(circle, rgba(49, 88, 255, .66) 1.4px, transparent 1.8px);
            background-size: 930px 300px, 900px 300px, 120px 120px !important;
            background-position: left -150px top 82px, right -110px bottom 46px, right 70px center !important;
            background-repeat: no-repeat !important;
        }

        .min-h-screen::after {
            opacity: 1 !important;
            background-image:
                linear-gradient(152deg, transparent 0 28%, rgba(255, 255, 255, .70) 28.2% 57%, transparent 57.2% 100%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='220' height='180' viewBox='0 0 220 180'%3E%3Cg fill='none' stroke='rgba(49,88,255,.48)' stroke-width='1.6'%3E%3Cpath d='M42 25 C50 45 58 53 78 61 C58 69 50 77 42 97 C34 77 26 69 6 61 C26 53 34 45 42 25Z'/%3E%3Cpath d='M168 118 C174 132 180 138 194 144 C180 150 174 156 168 170 C162 156 156 150 142 144 C156 138 162 132 168 118Z'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 100% 100%, 220px 180px !important;
            background-position: center, left 80px top 270px !important;
            background-repeat: no-repeat !important;
        }

        .min-h-screen > div:first-child { display: none !important; }

        .min-h-screen > div:last-child {
            width: 100% !important;
            max-width: none !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            background-color: transparent !important;
            box-shadow: none !important;
            z-index: 10;
        }

        .sm\:max-w-md {
            max-width: none !important;
            width: auto !important;
            box-shadow: none !important;
            background-color: transparent !important;
            padding: 0 !important;
        }

        .auth-container {
            background-color: #fff;
            border-radius: 20px !important;
            box-shadow: 0 26px 62px rgba(17, 24, 39, .18) !important;
            position: relative;
            overflow: hidden !important;
            width: 835px !important;
            max-width: 95vw;
            min-height: 540px !important;
            display: flex;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            width: 50%;
            background-color: #fff !important;
            transition:
                transform var(--slide-time) var(--slide-ease),
                opacity .62s ease,
                filter .62s ease;
            will-change: transform, opacity, filter;
            backface-visibility: hidden;
            transform-style: preserve-3d;
        }

        .sign-in-container { left: 0; z-index: 2; opacity: 1; }
        @keyframes show {
            0%, 45% { opacity: 0; z-index: 1; }
            46%, 100% { opacity: 1; z-index: 5; }
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition:
                transform var(--slide-time) var(--slide-ease),
                border-radius var(--slide-time) var(--slide-ease);
            z-index: 100;
            border-radius: 82px 0 0 82px !important;
            will-change: transform, border-radius;
            backface-visibility: hidden;
            transform-style: preserve-3d;
        }

        .overlay {
            background: linear-gradient(145deg, #5d72ff 0%, #4f46e5 48%, #241f9f 100%) !important;
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform var(--slide-time) var(--slide-ease);
            will-change: transform;
            backface-visibility: hidden;
            transform-style: preserve-3d;
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 44px !important;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            z-index: 110;
            overflow: hidden;
            background-repeat: no-repeat;
            background-image:
                radial-gradient(circle, rgba(180, 190, 255, .34) 0 42%, rgba(180, 190, 255, .14) 43% 62%, transparent 63%),
                radial-gradient(circle, rgba(255, 255, 255, .88) 1.7px, transparent 1.9px),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 120' preserveAspectRatio='none'%3E%3Cg fill='none' stroke='rgba(255,255,255,0.50)' stroke-width='1'%3E%3Cpath d='M0 85 C45 62 88 62 134 85 S222 108 268 85 S354 62 400 85'/%3E%3Cpath d='M0 91 C45 68 88 68 134 91 S222 114 268 91 S354 68 400 91'/%3E%3Cpath d='M0 97 C45 74 88 74 134 97 S222 120 268 97 S354 74 400 97'/%3E%3Cpath d='M0 103 C45 80 88 80 134 103 S222 126 268 103 S354 80 400 103'/%3E%3Cpath d='M0 109 C45 86 88 86 134 109 S222 132 268 109 S354 86 400 109'/%3E%3Cpath d='M0 115 C45 92 88 92 134 115 S222 138 268 115 S354 92 400 115'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 210px 160px, 92px 92px, 100% 122px !important;
        }

        .overlay-panel::before {
            content: "";
            width: 92px !important;
            height: 92px !important;
            margin-bottom: 22px !important;
            border: 3px solid #111 !important;
            border-radius: 50%;
            background-color: #fff !important;
            box-shadow: 0 0 0 2px rgba(255,255,255,.75), 0 12px 28px rgba(20, 30, 95, .18);
            display: block;
            background-image: url('{{ asset('images/printify-footer-logo.png') }}') !important;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 86% 86% !important;
            position: relative;
            z-index: 3;
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
            transition: transform var(--slide-time) var(--slide-ease);
            background-position: calc(100% + 48px) -48px, calc(100% - 25px) 20px, center bottom -6px;
        }

        .overlay-panel h1 {
            font-size: 26px !important;
            line-height: 1.15 !important;
            margin: 0 0 13px !important;
            font-weight: 800 !important;
            position: relative;
            z-index: 3;
        }

        .overlay-panel p {
            max-width: 290px;
            margin: 0 auto 25px !important;
            font-size: 13.5px !important;
            line-height: 1.55 !important;
            opacity: 1 !important;
            position: relative;
            z-index: 3;
        }

        .form-content {
            padding: 24px 40px !important;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: stretch !important;
            justify-content: center;
            will-change: transform, opacity, filter;
            backface-visibility: hidden;
        }

        .overlay-panel > * {
            will-change: transform, opacity, filter;
            backface-visibility: hidden;
        }

        @keyframes authSlideInRight {
            0% { opacity: 0; transform: translateX(70px) scale(.97); filter: blur(3px); }
            62% { opacity: 1; transform: translateX(-8px) scale(1.01); filter: blur(0); }
            100% { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
        }

        @keyframes authSlideInLeft {
            0% { opacity: 0; transform: translateX(-70px) scale(.97); filter: blur(3px); }
            62% { opacity: 1; transform: translateX(8px) scale(1.01); filter: blur(0); }
            100% { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
        }

        @keyframes authSlideOutLeft {
            0% { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
            45% { opacity: .55; transform: translateX(-24px) scale(.99); filter: blur(1px); }
            100% { opacity: 0; transform: translateX(-70px) scale(.97); filter: blur(3px); }
        }

        @keyframes authSlideOutRight {
            0% { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
            45% { opacity: .55; transform: translateX(24px) scale(.99); filter: blur(1px); }
            100% { opacity: 0; transform: translateX(70px) scale(.97); filter: blur(3px); }
        }

        @keyframes overlaySlideInRight {
            0% { opacity: 0; transform: translateX(48px) scale(.98); filter: blur(2px); }
            68% { opacity: 1; transform: translateX(-4px) scale(1); filter: blur(0); }
            100% { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
        }

        @keyframes overlaySlideInLeft {
            0% { opacity: 0; transform: translateX(-48px) scale(.98); filter: blur(2px); }
            68% { opacity: 1; transform: translateX(4px) scale(1); filter: blur(0); }
            100% { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
        }

        @keyframes overlaySlideOutLeft {
            0% { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
            100% { opacity: 0; transform: translateX(-48px) scale(.98); filter: blur(2px); }
        }

        @keyframes overlaySlideOutRight {
            0% { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
            100% { opacity: 0; transform: translateX(48px) scale(.98); filter: blur(2px); }
        }

        .auth-title {
            margin: 0 !important;
            font-size: 25px !important;
            line-height: 1.1 !important;
            color: #171717 !important;
            text-align: left !important;
            font-weight: 800 !important;
        }

        .auth-subtitle {
            margin: 5px 0 13px !important;
            color: var(--muted-text) !important;
            font-size: 13.5px !important;
            line-height: 1.35 !important;
            font-weight: 500 !important;
        }

        .input-group {
            width: 100%;
            margin-bottom: 8px !important;
        }

        .input-label {
            display: block;
            margin-bottom: 5px !important;
            color: #171717 !important;
            font-size: 11px !important;
            font-weight: 700 !important;
        }

        .field-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .field-icon {
            position: absolute;
            left: 14px !important;
            color: #9aa3b5 !important;
            display: flex;
            align-items: center;
            pointer-events: none;
            z-index: 5;
        }

        .field-wrapper svg { width: 17px !important; height: 17px !important; }

        .custom-input {
            height: 41px !important;
            background: #fff !important;
            border: 1px solid #e1e5ec !important;
            padding: 10px 15px 10px 40px !important;
            border-radius: 9px !important;
            width: 100%;
            font-size: 13px !important;
            color: #111827 !important;
            outline: none;
            transition: all .3s ease;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .035) !important;
        }

        .custom-input::placeholder { color: #8b94a7 !important; }

        .custom-input:focus {
            border-color: var(--primary-blue) !important;
            box-shadow: 0 0 0 3px rgba(49, 88, 255, .12) !important;
        }

        select.custom-input {
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
        }

        .custom-input-pass { padding-right: 45px !important; }

        .eye-icon-btn {
            position: absolute;
            right: 14px !important;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            color: #7d8799 !important;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .auth-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin: 0 0 10px !important;
            font-size: 12px;
            color: #64748b;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .remember-me input {
            width: 15px !important;
            height: 15px !important;
            accent-color: var(--primary-blue) !important;
        }

        .forgot-link {
            color: var(--primary-blue) !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
        }

        .forgot-link:hover { color: var(--dark-blue) !important; }

        .auth-btn {
            height: 41px !important;
            margin: 0 !important;
            border-radius: 999px !important;
            background: var(--primary-blue) !important;
            color: #fff !important;
            font-size: 12px !important;
            font-weight: 800 !important;
            letter-spacing: 0 !important;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            width: 100%;
            box-shadow: 0 8px 18px rgba(49, 88, 255, .20) !important;
            transition: all .3s ease;
        }

        .auth-btn:hover {
            background: #243fe6 !important;
            transform: none !important;
        }

        .error-text {
            color: #dc2626;
            font-size: 10px;
            width: 100%;
            text-align: left;
            margin-top: 2px;
        }

        .auth-feedback {
            width: 100%;
            border: 1px solid #fecaca;
            background: #fff1f2;
            color: #991b1b;
            border-radius: 10px;
            padding: 10px 12px;
            margin: 0 0 12px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.35;
            text-align: left;
        }

        .auth-feedback strong {
            display: block;
            color: #7f1d1d;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .cooldown-timer {
            font-variant-numeric: tabular-nums;
        }

        @media (max-width: 860px) {
            .auth-container {
                width: min(835px, calc(100vw - 28px)) !important;
                min-height: 540px !important;
            }
        }

        @media (max-width: 720px) {
            .auth-container {
                width: calc(100vw - 24px) !important;
                min-height: 620px !important;
            }
            .form-content { padding: 24px !important; }
            .overlay-panel { padding: 0 22px !important; }
        }
    </style>

    <div class="auth-container" id="auth-container">
        {{-- ADMIN/DEVELOPER LOGIN FORM --}}
        <div class="form-container sign-in-container">
            <div class="form-content">
                <h1 class="auth-title">Sign In</h1>
                <p class="auth-subtitle">Welcome back! Please sign in</p>

                @if ($errors->any())
                    <div class="auth-feedback" role="alert">
                        <strong>Sign-in notice</strong>
                        {{ $errors->first() }}
                    </div>
                @elseif (($loginCooldownSeconds ?? 0) > 0)
                    <div class="auth-feedback" role="alert">
                        <strong>Login cooldown active</strong>
                        Please wait <span class="cooldown-timer" data-cooldown="{{ $loginCooldownSeconds }}">{{ $loginCooldownSeconds }}</span> seconds before trying again.
                    </div>
                @elseif (session('status'))
                    <div class="auth-feedback" role="status">
                        <strong>Notice</strong>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="w-full">
                    @csrf

                    <div class="input-group">
                        <label class="input-label">Email Address</label>
                        <div class="field-wrapper">
                            <span class="field-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            <input type="email" name="email" placeholder="name@example.com" class="custom-input" value="{{ old('email') }}" required autofocus />
                        </div>
                        @error('email') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Password</label>
                        <div class="field-wrapper">
                            <span class="field-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input type="password" id="login_password" name="password" placeholder="Password" class="custom-input custom-input-pass" required />
                            <button type="button" class="eye-icon-btn" onclick="togglePassword('login_password', 'eye-login-1')">
                                <svg id="eye-login-1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div class="auth-options">
                        <label for="remember_me" class="remember-me">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                        <a href="{{ route('admin.password.request') }}" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" class="auth-btn">Sign In</button>
                </form>

            </div>
        </div>

        {{-- BLUE OVERLAY PANEL --}}
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Staff Portal</h1>
                    <p>Sign in with your approved admin client or developer account to access the protected dashboard.</p>
                </div>
            </div>
        </div>
    </div>
    <style id="staff-auth-signin-only-lock">
        .auth-container {
            width: 835px !important;
            max-width: 95vw !important;
            min-height: 540px !important;
        }
        .auth-container .sign-in-container {
            left: 0 !important;
            z-index: 5 !important;
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
        }
        .auth-container .overlay {
            left: 0 !important;
            width: 100% !important;
            transform: none !important;
        }
        .auth-container .overlay-panel {
            width: 100% !important;
        }
        .auth-container .overlay-right {
            left: 0 !important;
            right: auto !important;
            transform: none !important;
            background-position: calc(100% + 48px) -48px, calc(100% - 25px) 20px, center bottom -6px !important;
        }
    </style>

    <script>
        document.querySelectorAll('[data-cooldown]').forEach((timer) => {
            let remaining = Number(timer.dataset.cooldown || 0);
            const render = () => {
                timer.textContent = Math.max(0, remaining).toString();
            };

            render();

            const interval = window.setInterval(() => {
                remaining -= 1;
                render();

                if (remaining <= 0) {
                    window.clearInterval(interval);
                    const notice = timer.closest('.auth-feedback');
                    if (notice) notice.remove();
                }
            }, 1000);
        });

        function togglePassword(inputId, svgId) {
            const input = document.getElementById(inputId);
            const svg = document.getElementById(svgId);

            if (!input || !svg) return;

            if (input.type === 'password') {
                input.type = 'text';
                svg.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
            } else {
                input.type = 'password';
                svg.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                `;
            }
        }
    </script>
    <style id="staff-auth-input-icon-field-consistency-0615">
        .auth-shell .field-icon,
        .auth-shell .field-icon svg,
        .auth-shell .password-toggle svg {
            color:#1f2937!important;
            stroke:#1f2937!important;
        }
        .auth-shell .field-icon svg,
        .auth-shell .password-toggle svg {
            width:18px!important;
            height:18px!important;
        }
        .auth-shell .input-field {
            border-color:#6b7280!important;
        }
    </style>
</x-guest-layout>
