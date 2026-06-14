<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\OTPVerificationMail; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class VerifyOtpController extends Controller
{
    private const CUSTOMER_OTP_MAX_ATTEMPTS = 3;
    private const STAFF_OTP_MAX_ATTEMPTS = 5;
    private const CUSTOMER_OTP_RESEND_MAX_ATTEMPTS = 1;
    private const STAFF_OTP_RESEND_MAX_ATTEMPTS = 1;

    public function showVerifyForm(Request $request)
    {
        return $this->show($request);
    }

    /**
     * Ipakita ang OTP verification form.
     * FIXED: Method name is 'show' to match the error requirement.
     */
    public function show(Request $request)
    {
        // 1. Kunin ang email mula sa session o authenticated user
        $email = session('otp_email') 
                 ?? session('password_reset_email') 
                 ?? $request->email 
                 ?? (Auth::check() ? Auth::user()->email : null);

        // 2. Kung walang mahanap na email, ibalik sa login
        if (!$email) {
            return redirect()->route('login')->withErrors([
                'email' => 'Session expired or invalid request. Please try again.'
            ]);
        }

        $portal = $this->verificationPortal($request);
        $otpThrottleKey = $this->otpThrottleKeyFromContext($portal, $email, $request->ip());
        $resendThrottleKey = $this->otpResendThrottleKeyFromContext($portal, $email, $request->ip());
        $maxAttempts = $this->otpMaxAttempts($portal);
        $maxResends = $this->otpResendMaxAttempts($portal);
        $isStaffReset = $portal === 'staff';

        return view('auth.verify-otp', [
            'email' => $email,
            'verificationEmail' => session('is_forgot_password') === true
                ? session('password_reset_email')
                : $email,
            'otpTitle' => $isStaffReset ? 'Verify Staff Reset Code' : 'Verify Account',
            'otpInstruction' => $isStaffReset
                ? 'Enter the 6-digit staff reset code sent to your email address.'
                : 'Please enter the 6-digit security code sent to your email address to continue.',
            'otpStatusMessage' => $isStaffReset
                ? 'A 6-digit staff password reset code has been sent to your email.'
                : 'A 6-digit verification code has been sent to your email.',
            'otpSubmitAction' => $isStaffReset ? route('otp.submit') : route('customer.otp.submit'),
            'otpResendAction' => $isStaffReset ? route('otp.resend') : route('customer.otp.resend'),
            'otpBackRoute' => $isStaffReset ? route('admin.login') : route('login'),
            'otpBackLabel' => $isStaffReset ? 'Back to Staff Login' : 'Back to Login',
            'verificationFlow' => session('is_forgot_password') === true ? 'forgot_password' : null,
            'otpLockoutSeconds' => RateLimiter::tooManyAttempts($otpThrottleKey, $maxAttempts)
                ? RateLimiter::availableIn($otpThrottleKey)
                : 0,
            'resendCooldownSeconds' => RateLimiter::tooManyAttempts($resendThrottleKey, $maxResends)
                ? RateLimiter::availableIn($resendThrottleKey)
                : 0,
        ]);
    }

    /**
     * Handle ang pag-verify ng OTP code.
     */
    public function verify(Request $request)
    {
        // Validation for the OTP input
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
            'email' => ['required', 'email'],
            'verification_flow' => ['nullable', 'string'],
        ]);

        $lookupEmail = $this->verificationEmail($request);

        if (!$lookupEmail) {
            return redirect()->route('login')->withErrors([
                'email' => 'Verification session expired. Please sign in again.',
            ]);
        }

        if (Str::lower(trim((string) $request->email)) !== Str::lower(trim((string) $lookupEmail))) {
            return back()->withErrors([
                'email' => 'Verification session mismatch. Please restart the verification process.',
            ]);
        }

        $portal = $this->verificationPortal($request);
        $maxAttempts = $this->otpMaxAttempts($portal);
        $otpThrottleKey = $this->otpThrottleKey($request, $lookupEmail);

        $this->ensureRateLimit(
            $otpThrottleKey,
            $maxAttempts,
            'otp'
        );

        $user = User::where('email', trim((string) $lookupEmail))->first();

        if (!$user) {
            $attempts = RateLimiter::hit($otpThrottleKey, User::EMAIL_OTP_LOCKOUT_SECONDS);

            if ($attempts >= $maxAttempts) {
                $this->throwOtpLockout($otpThrottleKey, 'otp');
            }

            return back()->withErrors(['otp' => 'Account not found.']);
        }

        // 1. Security Check: Tugma ba ang OTP?
        if (trim((string)$user->otp_code) !== trim((string)$request->otp)) {
            $attempts = RateLimiter::hit($otpThrottleKey, User::EMAIL_OTP_LOCKOUT_SECONDS);

            if ($attempts >= $maxAttempts) {
                $this->throwOtpLockout($otpThrottleKey, 'otp');
            }

            return back()
                ->withInput()
                ->withErrors(['otp' => 'The security code you entered is incorrect.'])
                ->with('otp_attempt_count', min($attempts, $maxAttempts));
        }

        // 2. Security Check: may valid expiry ba ang code?
        if (!$user->otp_expires_at || Carbon::parse($user->otp_expires_at)->isPast()) {
            $attempts = RateLimiter::hit($otpThrottleKey, User::EMAIL_OTP_LOCKOUT_SECONDS);

            if ($attempts >= $maxAttempts) {
                $this->throwOtpLockout($otpThrottleKey, 'otp');
            }

            return back()->withErrors(['otp' => 'This code has expired. Please request a new one.']);
        }

        // 3. Mark as verified and Clean up OTP fields
        $user->forceFill([
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ])->save();

        /**
         * 🛡️ FLOW REDIRECTION
         */

        // --- SCENARIO A: FORGOT PASSWORD FLOW ---
        if (session('is_forgot_password') === true) {
            $token = session('password_reset_token');
            $emailForReset = session('password_reset_email', $user->email);
            $resetPortal = session('password_reset_portal', 'customer');

            if ($resetPortal === 'customer') {
                $request->session()->put('customer_otp_passed', true);
            }
            $request->session()->forget(['is_forgot_password', 'otp_email']);
            
            return redirect()->route('password.reset', [
                'token' => $token,
                'email' => $emailForReset
            ])->with('status', 'OTP Verified! Please set your new password below.');
        }

        // --- SCENARIO B: REGISTER / LOGIN FLOW ---
        if (!Auth::check()) {
            Auth::login($user);
        }

        $request->session()->regenerate();
        
        // MAHALAGA: Susi para makalampas sa 'customer_otp' middleware
        $request->session()->put('customer_otp_passed', true);
        
        // Linisin ang otp-related session data
        $request->session()->forget(['otp_email', 'password_reset_email', 'auth_type']);

        // Redirect sa Dashboard
        return redirect()->route('dashboard')->with('status', 'Verified successfully!');
    }

    /**
     * Resend ang OTP code sa user.
     */
    public function resend(Request $request)
    {
        $lookupEmail = $this->verificationEmail($request);

        if (!$lookupEmail) {
            return back()->withErrors(['otp' => 'Email session expired. Please restart the process.']);
        }

        $portal = $this->verificationPortal($request);
        $otpThrottleKey = $this->otpThrottleKey($request, $lookupEmail);

        $this->ensureRateLimit(
            $otpThrottleKey,
            $this->otpMaxAttempts($portal),
            'otp'
        );

        $this->ensureRateLimit(
            $this->otpResendThrottleKey($request, $lookupEmail),
            $this->otpResendMaxAttempts($portal),
            'otp'
        );

        $user = User::where('email', $lookupEmail)->first();
        if (!$user) return back()->withErrors(['otp' => 'User not found.']);

        // Generate bagong 6-digit OTP na may leading zeros
        $otp = sprintf("%06d", mt_rand(0, 999999));
        
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(User::EMAIL_OTP_TTL_MINUTES),
        ]);

        try {
            $deliveryEmail = session('is_forgot_password') === true
                ? session('otp_email', $user->email)
                : $user->email;

            Mail::to($deliveryEmail)->send(new OTPVerificationMail($otp));
            RateLimiter::hit(
                $this->otpResendThrottleKey($request, $lookupEmail),
                User::EMAIL_OTP_RESEND_COOLDOWN_SECONDS
            );
            return back()->with('status', 'A new 6-digit verification code has been sent to your email.');
        } catch (\Exception $e) {
            Log::error("OTP Resend failed for {$user->email}: " . $e->getMessage());
            return back()->withErrors(['otp' => 'Failed to send code. Please check your internet connection.']);
        }
    }

    private function ensureRateLimit(string $key, int $maxAttempts, string $bag): void
    {
        if (!RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return;
        }

        $this->throwOtpLockout($key, $bag);
    }

    private function throwOtpLockout(string $key, string $bag): never
    {
        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            $bag => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => (int) ceil($seconds / 60),
            ]),
        ]);
    }

    private function otpThrottleKey(Request $request, ?string $email = null): string
    {
        return $this->otpThrottleKeyFromContext(
            $this->verificationPortal($request),
            $email ?? $this->verificationEmail($request),
            $request->ip()
        );
    }

    private function isForgotPasswordFlow(Request $request): bool
    {
        if (Auth::check()) {
            return false;
        }

        if (session('auth_type') === 'forgot_password') {
            return true;
        }

        return session('is_forgot_password') === true
            || $request->query('flow') === 'forgot_password'
            || $request->input('verification_flow') === 'forgot_password';
    }

    private function otpResendThrottleKey(Request $request, ?string $email = null): string
    {
        return $this->otpResendThrottleKeyFromContext(
            $this->verificationPortal($request),
            $email ?? $this->verificationEmail($request),
            $request->ip()
        );
    }

    private function verificationEmail(Request $request): ?string
    {
        if (session('is_forgot_password') === true) {
            return session('password_reset_email');
        }

        if (Auth::check()) {
            return Auth::user()->email;
        }

        return session('otp_email')
            ?? session('password_reset_email')
            ?? $request->input('email')
            ?? $request->query('email');
    }

    private function verificationPortal(Request $request): string
    {
        if (session('password_reset_portal') === 'staff') {
            return 'staff';
        }

        return 'customer';
    }

    private function otpMaxAttempts(string $portal): int
    {
        return $portal === 'staff'
            ? self::STAFF_OTP_MAX_ATTEMPTS
            : self::CUSTOMER_OTP_MAX_ATTEMPTS;
    }

    private function otpResendMaxAttempts(string $portal): int
    {
        return $portal === 'staff'
            ? self::STAFF_OTP_RESEND_MAX_ATTEMPTS
            : self::CUSTOMER_OTP_RESEND_MAX_ATTEMPTS;
    }

    private function otpThrottleKeyFromContext(string $portal, ?string $email, string $ip): string
    {
        $prefix = $portal === 'staff' ? 'staff-otp:' : 'customer-otp:';

        return $prefix . Str::transliterate(Str::lower((string) $email) . '|' . $ip);
    }

    private function otpResendThrottleKeyFromContext(string $portal, ?string $email, string $ip): string
    {
        $prefix = $portal === 'staff' ? 'staff-otp-resend:' : 'customer-otp-resend:';

        return $prefix . Str::transliterate(Str::lower((string) $email) . '|' . $ip);
    }
}
