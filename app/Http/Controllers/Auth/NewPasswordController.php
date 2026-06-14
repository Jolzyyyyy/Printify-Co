<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Show reset password view.
     */
    public function create(Request $request): View|RedirectResponse
    {
        // Kunin ang token at email mula sa route parameter o sa session (OTP fallback)
        $token = $request->route('token') ?? session('password_reset_token');
        $email = $request->email ?? session('password_reset_email');

        /**
         * 🛡️ ACCESS PROTECTION
         * Kung walang token o email, ibig sabihin hindi dumaan ang user sa tamang flow.
         */
        if (!$token || !$email) {
            $loginRoute = session('password_reset_portal') === 'staff' ? 'admin.login' : 'login';

            return redirect()->route($loginRoute)->withErrors([
                'email' => 'Session expired or invalid access. Please restart the password reset process.',
            ]);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Handle reset password submission.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Strict Validation
        $request->validate([
            'token'       => ['required'],
            'email'       => ['required', 'email'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            'action_type' => ['nullable', 'in:auto_login,manual_login'],
        ]);

        /**
         * 2. SECURITY CHECK
         * Sinisiguro natin na dumaan ang user sa OTP verification bago payagang palitan ang password.
         */
        $sessionToken = session('password_reset_token');
        $sessionEmail = session('password_reset_email');
        $resetPortal = session('password_reset_portal', 'customer');

        if (!$sessionToken || !$sessionEmail) {
            $loginRoute = session('password_reset_portal') === 'staff' ? 'admin.login' : 'login';

            return redirect()->route($loginRoute)->withErrors([
                'email' => 'Security check failed. Please verify your identity via OTP again.',
            ]);
        }

        if (!hash_equals((string) $sessionToken, (string) $request->token)
            || Str::lower(trim((string) $sessionEmail)) !== Str::lower(trim((string) $request->email))) {
            $loginRoute = $resetPortal === 'staff' ? 'admin.login' : 'login';

            return redirect()->route($loginRoute)->withErrors([
                'email' => 'Password reset session mismatch. Please request a new reset code.',
            ]);
        }

        // 3. Find user and verify existence
        $user = User::where('email', trim($request->email))->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'User account not found.',
            ]);
        }

        if ($resetPortal === 'staff' && !$user->canAccessAdminPortal()) {
            return redirect()->route('admin.login')->withErrors([
                'email' => 'This password reset link is only for admin-client and developer accounts.',
            ]);
        }

        /**
         * 4. UPDATE USER DATA
         * Ginagamit ang forceFill para sa direct model manipulation.
         */
        $user->forceFill([
            'password'          => Hash::make($request->password),
            'remember_token'    => Str::random(60),
            'email_verified_at' => $user->email_verified_at ?? now(), // Ensure user is verified
        ])->save();

        // Trigger Laravel internal event
        event(new PasswordReset($user));

        // 5. Cleanup session markers after successful reset
        $request->session()->forget([
            'password_reset_token',
            'password_reset_email',
            'password_reset_portal',
            'otp_email',
            'is_forgot_password',
            'auth_type',
            'otp_passed',
        ]);

        /**
         * 6. SMART REDIRECTION LOGIC
         * Base sa 'action_type' na ipinasa mula sa Blade form.
         */
        $action = $resetPortal === 'staff'
            ? 'auto_login'
            : ($request->action_type ?? 'auto_login');

        if ($action === 'auto_login') {
            // Flow: Dashboard Entry
            Auth::login($user);
            if ($resetPortal === 'staff' && $user->canAccessAdminPortal()) {
                $request->session()->put('staff_otp_passed', true);

                return redirect()->route('admin.dashboard')->with('status',
                    'Success! Your password has been updated and you are now logged in.'
                );
            }

            $request->session()->put('customer_otp_passed', true);

            return redirect()->route('dashboard')->with('status', 
                'Success! Your password has been updated and you are now logged in.'
            );
        }

        // Flow: Back to Login (Manual)
        Auth::guard('web')->logout();
        $request->session()->forget('customer_otp_passed');

        return redirect()->route($resetPortal === 'staff' ? 'admin.login' : 'login')->with('status', 
            'Your password has been updated! Please login with your new credentials.'
        );
    }
}
