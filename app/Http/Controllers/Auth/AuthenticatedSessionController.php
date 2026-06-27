<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Notifications\SendOTP;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    private const CUSTOMER_LOGIN_MAX_ATTEMPTS = 3;
    private const CUSTOMER_LOGIN_LOCKOUT_SECONDS = 300;

    /**
     * Ipakita ang Login Form.
     */
    public function create(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user && $user->canAccessAdminPortal()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } elseif ($user) {
            return redirect()->route('dashboard.redirect');
        }

        $this->storeSafeIntendedUrl($request);

        return view('auth.login', [
            'loginCooldownSeconds' => $this->customerLoginCooldownSeconds($request),
        ]);
    }

    /**
     * Handle ang pag-login ng user.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. I-validate ang Email at Password
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $this->ensureLoginIsNotRateLimited($request);

        // 2. Subukang i-authenticate ang credentials
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $this->hitCustomerLoginThrottle($request);

            return back()->withErrors([
                'email' => __('auth.failed'),
            ])->onlyInput('email');
        }

        $user = Auth::user();

        /**
         * 3. ADMIN GUARD
         * Kung admin ang pumasok dito sa customer login, i-logout at ibalik sa login with error.
         * Naka-align ito sa security protocol mo para sa admin portal.
         */
        if ($user->canAccessAdminPortal()) {
            $this->hitCustomerLoginThrottle($request);

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Wrong portal for this account. Staff, admin-client, and developer accounts must sign in through the protected staff portal.',
            ])->onlyInput('email');
        }

        // 4. Regenerate session para sa security
        $request->session()->regenerate();
        RateLimiter::clear($this->customerLoginThrottleKey($request));
        $request->session()->forget('customer_login_throttle_email');

        $request->session()->forget([
            'password_reset_email',
            'password_reset_token',
            'is_forgot_password',
            'auth_type',
            'customer_otp_passed',
        ]);

        if ($user->isCustomer()) {
            $otp = sprintf("%06d", mt_rand(0, 999999));

            $user->forceFill([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(User::EMAIL_OTP_TTL_MINUTES),
            ])->save();

            try {
                $user->notify(new SendOTP($otp));
                RateLimiter::hit(
                    $this->customerOtpResendThrottleKey($user->email, $request->ip()),
                    User::EMAIL_OTP_RESEND_COOLDOWN_SECONDS
                );
            } catch (\Exception $e) {
                Log::error('Login OTP Email failed for ' . $user->email . ': ' . $e->getMessage());

                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => 'Unable to send verification code right now. Please try again.',
                ])->onlyInput('email');
            }

            $request->session()->put([
                'otp_email' => $user->email,
                'auth_type' => 'account_verification',
            ]);

            return redirect()->route('otp.verify', ['email' => $user->email])
                ->with('status', 'A 6-digit verification code has been sent to your email.');
        }

        return redirect()->route('dashboard.redirect');
    }

    public function redirectDashboard(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->canAccessAdminPortal()) {
            return session('staff_otp_passed') === true
                ? redirect()->route('admin.dashboard')
                : redirect()->route('admin.otp.verify');
        }

        return session('customer_otp_passed') === true
            ? redirect()->route('dashboard')
            : redirect()->route('otp.verify');
    }

    /**
     * Logout ang user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Linisin ang OTP session keys bago mag-logout para fresh start sa susunod
        $request->session()->forget([
            'otp_email',
            'auth_type',
            'customer_otp_passed',
            'password_reset_email',
            'password_reset_token',
            'is_forgot_password',
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function customerOtpResendThrottleKey(string $email, string $ip): string
    {
        return 'customer-otp-resend:' . Str::transliterate(Str::lower($email) . '|' . $ip);
    }

    private function ensureLoginIsNotRateLimited(Request $request): void
    {
        $key = $this->customerLoginThrottleKey($request);

        if (!RateLimiter::tooManyAttempts($key, self::CUSTOMER_LOGIN_MAX_ATTEMPTS)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);
        $minutes = (int) ceil($seconds / 60);

        throw ValidationException::withMessages([
            'email' => "Too many login attempts. Please wait {$minutes} minute" . ($minutes === 1 ? '' : 's') . ' before trying again.',
        ]);
    }

    private function customerLoginThrottleKey(Request $request): string
    {
        return 'customer-login:' . Str::transliterate(Str::lower((string) $request->input('email', '')) . '|' . $request->ip());
    }

    private function hitCustomerLoginThrottle(Request $request): void
    {
        $request->session()->put('customer_login_throttle_email', Str::lower((string) $request->input('email', '')));
        RateLimiter::hit($this->customerLoginThrottleKey($request), self::CUSTOMER_LOGIN_LOCKOUT_SECONDS);
    }

    private function customerLoginCooldownSeconds(Request $request): int
    {
        $email = session('customer_login_throttle_email');

        if (!$email) {
            return 0;
        }

        $key = 'customer-login:' . Str::transliterate(Str::lower((string) $email) . '|' . $request->ip());

        return RateLimiter::tooManyAttempts($key, self::CUSTOMER_LOGIN_MAX_ATTEMPTS)
            ? RateLimiter::availableIn($key)
            : 0;
    }

    private function storeSafeIntendedUrl(Request $request): void
    {
        $intended = (string) $request->query('intended', '');

        if ($intended === '') {
            return;
        }

        $path = parse_url($intended, PHP_URL_PATH) ?: '';

        if (in_array($path, ['/cart', '/checkout', '/payment/checkout'], true)) {
            $request->session()->put('url.intended', url($path));
        }
    }
}
