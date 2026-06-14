<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOTP;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class FacebookController extends Controller
{
    public function redirectToFacebook(): RedirectResponse
    {
        if (!$this->facebookConfigIsReady()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Facebook login is not configured yet. Please use email and password for now.',
            ]);
        }

        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(): RedirectResponse
    {
        if (!$this->facebookConfigIsReady()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Facebook login is not configured yet. Please use email and password for now.',
            ]);
        }

        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (Throwable $exception) {
            Log::warning('Facebook login callback failed: ' . $exception->getMessage());

            return redirect()->route('login')->withErrors([
                'email' => 'Facebook authentication failed. Please try again or use email and password.',
            ]);
        }

        $email = Str::lower(trim((string) $facebookUser->getEmail()));

        if ($email === '') {
            return redirect()->route('login')->withErrors([
                'email' => 'Facebook did not return the email address needed for login.',
            ]);
        }

        $user = User::where('email', $email)->first();

        if ($user && $user->canAccessAdminPortal()) {
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Wrong portal for this account. Staff, admin-client, and developer accounts must sign in through the protected staff portal.',
            ]);
        }

        $createdNewUser = false;

        if (!$user) {
            [$firstName, $lastName] = $this->splitFacebookName((string) $facebookUser->getName());

            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => Hash::make(Str::random(48)),
                'has_set_password' => false,
                'role' => User::ROLE_CUSTOMER,
                'email_verified_at' => null,
            ]);

            $createdNewUser = true;
        }

        Auth::login($user);
        request()->session()->regenerate();
        request()->session()->forget([
            'password_reset_email',
            'password_reset_token',
            'is_forgot_password',
            'otp_passed',
            'customer_otp_passed',
        ]);

        $otp = sprintf('%06d', mt_rand(0, 999999));
        $user->forceFill([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(User::EMAIL_OTP_TTL_MINUTES),
        ])->save();

        try {
            $user->notify(new SendOTP($otp));
            RateLimiter::hit(
                $this->customerOtpResendThrottleKey($user->email, request()->ip()),
                User::EMAIL_OTP_RESEND_COOLDOWN_SECONDS
            );
        } catch (Throwable $exception) {
            Log::error('Facebook login OTP failed for ' . $user->email . ': ' . $exception->getMessage());

            Auth::guard('web')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            if ($createdNewUser) {
                $user->delete();
            }

            return redirect()->route('login')->withErrors([
                'email' => 'Unable to send your verification code right now. Please try again.',
            ]);
        }

        request()->session()->put('otp_email', $user->email);
        request()->session()->put('auth_type', 'account_verification');

        return redirect()->route('otp.verify', [
            'email' => $user->email,
        ])->with('status', 'Facebook sign-in completed. Enter the verification code sent to your email to finish setup.');
    }

    private function facebookConfigIsReady(): bool
    {
        return filled(config('services.facebook.client_id'))
            && filled(config('services.facebook.client_secret'))
            && filled(config('services.facebook.redirect'));
    }

    private function splitFacebookName(string $name): array
    {
        $name = trim($name);

        if ($name === '') {
            return ['Facebook', 'Customer'];
        }

        $parts = preg_split('/\s+/', $name, 2);

        return [
            $parts[0] ?? 'Facebook',
            $parts[1] ?? 'Customer',
        ];
    }

    private function customerOtpResendThrottleKey(string $email, string $ip): string
    {
        return 'customer-otp-resend:' . Str::transliterate(Str::lower($email) . '|' . $ip);
    }
}
