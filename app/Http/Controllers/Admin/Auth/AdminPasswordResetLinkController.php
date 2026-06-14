<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OTPVerificationMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminPasswordResetLinkController extends Controller
{
    private const PASSWORD_RESET_REQUEST_MAX_ATTEMPTS = 1;
    private const PASSWORD_RESET_REQUEST_COOLDOWN_SECONDS = 60;

    public function create(Request $request): View
    {
        return view('auth.forgot-password', [
            'resetCooldownSeconds' => $this->passwordResetCooldownSeconds($request),
            'passwordResetAction' => route('admin.password.email'),
            'passwordResetBackRoute' => route('admin.login'),
            'passwordResetTitle' => 'Staff Password Reset',
            'passwordResetCopy' => 'Enter your developer or admin-client email and we will send a code to reset your password.',
            'passwordResetInfo' => 'We will send a secure staff reset code to your email.',
            'showRecoveryEmailOption' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $this->ensureResetRequestIsNotRateLimited($request);
        $request->session()->put('staff_password_reset_throttle_email', Str::lower((string) $request->input('email', '')));
        RateLimiter::hit($this->passwordResetThrottleKey($request), self::PASSWORD_RESET_REQUEST_COOLDOWN_SECONDS);

        $user = User::where('email', trim((string) $request->email))
            ->whereIn('role', [User::ROLE_ADMIN_CLIENT, User::ROLE_DEVELOPER])
            ->first();

        if (!$user || ($user->isAdminClient() && !$user->isApprovedAdminClient())) {
            return back()
                ->withInput($request->only('email'))
                ->with('status', 'If that email belongs to an approved staff account, a verification code has been sent.');
        }

        $otp = sprintf('%06d', mt_rand(100000, 999999));
        $token = Password::createToken($user);

        $user->forceFill([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(User::EMAIL_OTP_TTL_MINUTES),
        ])->save();

        try {
            Mail::to($user->email)->send(new OTPVerificationMail($otp));
        } catch (\Throwable $e) {
            Log::error('Staff forgot password OTP send failed for ' . $user->email . ': ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'Failed to send verification code. Please try again.',
            ])->onlyInput('email');
        }

        $request->session()->put([
            'password_reset_token' => $token,
            'password_reset_email' => $user->email,
            'password_reset_portal' => 'staff',
            'otp_email' => $user->email,
            'is_forgot_password' => true,
            'auth_type' => 'forgot_password',
        ]);

        return redirect()->route('otp.verify', [
            'email' => $user->email,
            'flow' => 'forgot_password',
        ])->with('status', 'A 6-digit staff password reset code has been sent to your email.');
    }

    private function ensureResetRequestIsNotRateLimited(Request $request): void
    {
        $key = $this->passwordResetThrottleKey($request);

        if (!RateLimiter::tooManyAttempts($key, self::PASSWORD_RESET_REQUEST_MAX_ATTEMPTS)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'email' => "Please wait {$seconds} second" . ($seconds === 1 ? '' : 's') . ' before requesting another password reset code.',
        ]);
    }

    private function passwordResetThrottleKey(Request $request): string
    {
        return 'staff-password-reset-request:' . Str::transliterate(Str::lower((string) $request->input('email', '')) . '|' . $request->ip());
    }

    private function passwordResetCooldownSeconds(Request $request): int
    {
        $email = session('staff_password_reset_throttle_email');

        if (!$email) {
            return 0;
        }

        $key = 'staff-password-reset-request:' . Str::transliterate(Str::lower((string) $email) . '|' . $request->ip());

        return RateLimiter::tooManyAttempts($key, self::PASSWORD_RESET_REQUEST_MAX_ATTEMPTS)
            ? RateLimiter::availableIn($key)
            : 0;
    }
}
