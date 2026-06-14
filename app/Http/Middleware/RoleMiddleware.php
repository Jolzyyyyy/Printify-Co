<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request for Printify & Co.
     * * Sinisiguro nito na hindi maghahalo ang access ng customer, admin_client, at developer.
     * Usage in routes:
     * ->middleware('role:admin_client')
     * ->middleware('role:customer')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. AUTH CHECK: Siguraduhin na ang user ay logged in
        if (! Auth::check()) {
            /**
             * 🛡️ SMART REDIRECTION
             * Kung ang sinusubukang i-access ay ang Admin route (p-co-2026),
             * ibalik sila sa Admin Login. Kung hindi, sa Customer Login.
             */
            if ($request->is('p-co-2026/*') || $request->is('p-co-2026')) {
                return redirect()->route('admin.login');
            }
            
            return redirect()->route('login');
        }

        $user = Auth::user();

        /**
         * 2. ROLE AUTHORIZATION
         * Chine-check kung ang user role ay kasama sa 
         * pinapayagan para sa specific route na ito.
         */
        if (!$user->role || !in_array($user->role, $roles, true)) {
            if ($user->canAccessAdminPortal() && in_array(User::ROLE_CUSTOMER, $roles, true)) {
                $route = session('staff_otp_passed') === true ? 'admin.dashboard' : 'admin.otp.verify';

                return redirect()->route($route)->with(
                    'status',
                    'This account belongs to the staff portal. Redirecting you to the correct dashboard.'
                );
            }

            if ($user->isCustomer() && (in_array(User::ROLE_ADMIN_CLIENT, $roles, true) || in_array(User::ROLE_DEVELOPER, $roles, true))) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')->withErrors([
                    'email' => 'Wrong portal for this account. Customer accounts must sign in through the customer login.',
                ]);
            }

            abort(403, 'Unauthorized access for ' . ($user->role ?? 'unknown role'));
        }

        if (($user->isAdminClient() && !$user->isApprovedAdminClient()) || $user->isInvitedAdminPendingApproval()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->withErrors([
                'email' => 'This admin client account is not yet approved for portal access.',
            ]);
        }

        // 3. Allow access kung match ang role
        return $next($request);
    }
}
