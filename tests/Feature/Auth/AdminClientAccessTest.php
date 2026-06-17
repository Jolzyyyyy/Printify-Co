<?php

namespace Tests\Feature\Auth;

use App\Mail\OTPVerificationMail;
use App\Models\User;
use App\Notifications\AdminClientInvitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AdminClientAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_developer_can_preregister_admin_with_hashed_invite_token(): void
    {
        Notification::fake();

        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->post(route('developer.admin-clients.store', absolute: false), [
                'name' => 'Client Manager',
                'email' => 'client-manager@example.com',
            ]);

        $adminClient = User::where('email', 'client-manager@example.com')->firstOrFail();

        $response
            ->assertRedirect(route('developer.admin-clients.index', absolute: false))
            ->assertSessionHas('invite_url');

        $this->assertSame(User::ROLE_ADMIN_CLIENT, $adminClient->role);
        $this->assertSame($developer->id, $adminClient->preregistered_by);
        $this->assertNull($adminClient->approved_at);
        $this->assertNotNull($adminClient->invite_token);
        $this->assertNotSame(session('invite_url'), $adminClient->invite_token);

        Notification::assertSentTo($adminClient, AdminClientInvitation::class);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'admin_client_preregistered',
            'actor_id' => $developer->id,
            'target_user_id' => $adminClient->id,
        ]);
    }

    public function test_invite_acceptance_keeps_admin_client_email_unverified_until_portal_otp(): void
    {
        $token = 'plain-admin-client-token';
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email' => 'accepted-client@example.com',
            'password' => Hash::make('temporary-password'),
            'email_verified_at' => now(),
            'invite_token' => hash('sha256', $token),
            'invite_expires_at' => now()->addDay(),
            'approved_at' => null,
        ]);

        $response = $this->post(route('admin-client-invitations.store', [
            'token' => $token,
        ], false), [
            'password' => 'Password1!',
            'business_name' => 'Client Studio',
            'contact_person' => 'Client Owner',
            'contact_number' => '09170000000',
            'business_address' => '123 Client Street',
            'reference_notes' => 'Primary branch',
        ]);

        $adminClient->refresh();

        $response->assertRedirect(route('admin.login', absolute: false));
        $this->assertTrue(Hash::check('Password1!', $adminClient->password));
        $this->assertNull($adminClient->email_verified_at);
        $this->assertNull($adminClient->invite_token);
        $this->assertNull($adminClient->invite_expires_at);
        $this->assertNotNull($adminClient->invitation_accepted_at);
        $this->assertDatabaseHas('admin_client_profiles', [
            'user_id' => $adminClient->id,
            'business_name' => 'Client Studio',
            'contact_person' => 'Client Owner',
            'contact_number' => '+639170000000',
        ]);
    }

    public function test_admin_client_invite_password_uses_shared_password_policy(): void
    {
        $token = 'plain-admin-client-token';
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email' => 'weak-password-client@example.com',
            'password' => Hash::make('temporary-password'),
            'email_verified_at' => now(),
            'invite_token' => hash('sha256', $token),
            'invite_expires_at' => now()->addDay(),
            'approved_at' => null,
        ]);

        $response = $this
            ->from(route('admin-client-invitations.show', $token, false))
            ->post(route('admin-client-invitations.store', [
                'token' => $token,
            ], false), [
                'password' => 'weakpass',
                'business_name' => 'Client Studio',
                'contact_person' => 'Client Owner',
                'contact_number' => '09170000000',
                'business_address' => '123 Client Street',
                'reference_notes' => 'Primary branch',
            ]);

        $response
            ->assertRedirect(route('admin-client-invitations.show', $token, false))
            ->assertSessionHasErrors('password');

        $adminClient->refresh();
        $this->assertNotNull($adminClient->invite_token);
        $this->assertNull($adminClient->invitation_accepted_at);
    }

    public function test_approved_admin_client_login_requires_email_otp_before_dashboard(): void
    {
        Mail::fake();

        $developer = User::factory()->create(['role' => User::ROLE_DEVELOPER]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email' => 'approved-client@example.com',
            'password' => Hash::make('Password1!'),
            'email_verified_at' => null,
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
        ]);

        $adminClient->adminClientProfile()->create([
            'business_name' => 'Approved Studio',
            'contact_person' => 'Approved Owner',
            'contact_number' => '09171111111',
            'business_address' => '456 Approved Street',
            'profile_completed_at' => now(),
        ]);

        $response = $this->post(route('admin.login.submit', absolute: false), [
            'email' => 'approved-client@example.com',
            'password' => 'Password1!',
        ]);

        $response
            ->assertRedirect(route('admin.otp.verify', absolute: false))
            ->assertSessionHas('needs_email_otp', true)
            ->assertSessionHas('admin_email', 'approved-client@example.com')
            ->assertSessionHas('admin_role', User::ROLE_ADMIN_CLIENT)
            ->assertSessionHas('admin_role_label', 'Admin Client')
            ->assertSessionHas('admin_dashboard_label', 'Admin Client Dashboard');

        $this->assertAuthenticatedAs($adminClient);
        $this->assertNotNull($adminClient->fresh()->otp_code);
        Mail::assertSent(OTPVerificationMail::class);
    }

    public function test_developer_login_identifies_developer_role_before_otp(): void
    {
        Mail::fake();

        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email' => 'identified-developer@example.com',
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);

        $this
            ->post(route('admin.login.submit', absolute: false), [
                'email' => $developer->email,
                'password' => 'Password1!',
            ])
            ->assertRedirect(route('admin.otp.verify', absolute: false))
            ->assertSessionHas('admin_role', User::ROLE_DEVELOPER)
            ->assertSessionHas('admin_role_label', 'Developer')
            ->assertSessionHas('admin_dashboard_label', 'Developer Dashboard')
            ->assertSessionHas('status', 'Developer account identified. A verification code has been sent to your email before portal access can continue.');

        $this
            ->actingAs($developer)
            ->withSession([
                'admin_email' => $developer->email,
                'admin_role' => User::ROLE_DEVELOPER,
                'admin_role_label' => 'Developer',
                'admin_dashboard_label' => 'Developer Dashboard',
                'needs_email_otp' => true,
            ])
            ->get(route('admin.otp.verify', absolute: false))
            ->assertOk()
            ->assertSee('Verify Developer Account')
            ->assertSee('Developer Dashboard');
    }

    public function test_staff_portal_base_url_redirects_to_correct_entry_point(): void
    {
        $this
            ->get('/p-co-2026')
            ->assertRedirect(route('admin.login', absolute: false));

        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $this
            ->actingAs($developer)
            ->get('/p-co-2026')
            ->assertRedirect(route('admin.otp.verify', absolute: false));

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get('/p-co-2026')
            ->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_staff_forgot_password_sends_otp_for_developer_and_resets_to_staff_dashboard(): void
    {
        Mail::fake();

        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email' => 'reset-developer@example.com',
            'password' => Hash::make('OldPassword1!'),
            'email_verified_at' => now(),
        ]);

        $response = $this->post(route('admin.password.email', absolute: false), [
            'email' => $developer->email,
        ]);

        $response
            ->assertRedirect(route('otp.verify', [
                'email' => $developer->email,
                'flow' => 'forgot_password',
            ], false))
            ->assertSessionHas('password_reset_portal', 'staff')
            ->assertSessionHas('password_reset_email', $developer->email);
        Mail::assertSent(OTPVerificationMail::class);

        $developer->refresh();

        $this
            ->post(route('otp.submit', absolute: false), [
                'email' => $developer->email,
                'otp' => $developer->otp_code,
                'verification_flow' => 'forgot_password',
            ])
            ->assertRedirect(route('password.reset', [
                'token' => session('password_reset_token'),
                'email' => $developer->email,
            ], false));

        $this
            ->post(route('password.store', absolute: false), [
                'token' => session('password_reset_token'),
                'email' => $developer->email,
                'password' => 'NewPassword1!',
                'password_confirmation' => 'NewPassword1!',
                'action_type' => 'auto_login',
            ])
            ->assertRedirect(route('admin.dashboard', absolute: false))
            ->assertSessionHas('staff_otp_passed', true)
            ->assertSessionHas('status', 'Success! Your password has been updated and you are now logged in.');

        $this->assertTrue(Hash::check('NewPassword1!', $developer->fresh()->password));
        $this->assertAuthenticatedAs($developer);
    }

    public function test_staff_forgot_password_manual_login_option_returns_to_staff_login(): void
    {
        Mail::fake();

        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email' => 'manual-reset-developer@example.com',
            'password' => Hash::make('OldPassword1!'),
            'email_verified_at' => now(),
        ]);

        $this->post(route('admin.password.email', absolute: false), [
            'email' => $developer->email,
        ])->assertRedirect(route('otp.verify', [
            'email' => $developer->email,
            'flow' => 'forgot_password',
        ], false));

        $developer->refresh();

        $this
            ->post(route('otp.submit', absolute: false), [
                'email' => $developer->email,
                'otp' => $developer->otp_code,
                'verification_flow' => 'forgot_password',
            ])
            ->assertRedirect(route('password.reset', [
                'token' => session('password_reset_token'),
                'email' => $developer->email,
            ], false));

        $this
            ->post(route('password.store', absolute: false), [
                'token' => session('password_reset_token'),
                'email' => $developer->email,
                'password' => 'NewPassword1!',
                'password_confirmation' => 'NewPassword1!',
                'action_type' => 'manual_login',
            ])
            ->assertRedirect(route('admin.login', absolute: false))
            ->assertSessionHas('status', 'Your password has been updated! Please login with your new credentials.');

        $this->assertGuest();
        $this->assertTrue(Hash::check('NewPassword1!', $developer->fresh()->password));
    }

    public function test_staff_forgot_password_otp_screen_uses_staff_routes_and_limits(): void
    {
        Mail::fake();

        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email' => 'staff-otp-screen@example.com',
            'email_verified_at' => now(),
        ]);

        $this->post(route('admin.password.email', absolute: false), [
            'email' => $developer->email,
        ])->assertRedirect(route('otp.verify', [
            'email' => $developer->email,
            'flow' => 'forgot_password',
        ], false));

        $response = $this->get(route('otp.verify', [
            'email' => $developer->email,
            'flow' => 'forgot_password',
        ], false));

        $response
            ->assertOk()
            ->assertSee('Verify Staff Reset Code')
            ->assertSee('Back to Staff Login')
            ->assertSee('data-otp-box', false)
            ->assertSee('data-otp-input', false)
            ->assertDontSee('Verification cooldown active')
            ->assertSee('action="' . route('otp.submit') . '"', false)
            ->assertSee('action="' . route('otp.resend') . '"', false)
            ->assertDontSee('action="' . route('customer.otp.submit') . '"', false)
            ->assertDontSee('action="' . route('customer.otp.resend') . '"', false);

        for ($attempt = 1; $attempt <= 4; $attempt++) {
            $this->post(route('otp.submit', absolute: false), [
                'email' => $developer->email,
                'otp' => '000000',
                'verification_flow' => 'forgot_password',
            ])->assertSessionHasErrors('otp');

            $this->assertFalse(RateLimiter::tooManyAttempts(
                'staff-otp:' . strtolower($developer->email) . '|127.0.0.1',
                5
            ));
        }

        $this->post(route('otp.submit', absolute: false), [
            'email' => $developer->email,
            'otp' => '000000',
            'verification_flow' => 'forgot_password',
        ])->assertSessionHasErrors('otp');

        $this->assertTrue(RateLimiter::tooManyAttempts(
            'staff-otp:' . strtolower($developer->email) . '|127.0.0.1',
            5
        ));
    }

    public function test_staff_forgot_password_resets_approved_admin_client_to_staff_dashboard(): void
    {
        Mail::fake();

        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email' => 'reset-admin-client@example.com',
            'password' => Hash::make('OldPassword1!'),
            'email_verified_at' => now(),
            'approved_at' => now(),
            'approved_by' => $developer->id,
        ]);

        $this->post(route('admin.password.email', absolute: false), [
            'email' => $adminClient->email,
        ])->assertRedirect(route('otp.verify', [
            'email' => $adminClient->email,
            'flow' => 'forgot_password',
        ], false));

        $adminClient->refresh();

        $this
            ->post(route('otp.submit', absolute: false), [
                'email' => $adminClient->email,
                'otp' => $adminClient->otp_code,
                'verification_flow' => 'forgot_password',
            ])
            ->assertRedirect(route('password.reset', [
                'token' => session('password_reset_token'),
                'email' => $adminClient->email,
            ], false));

        $this
            ->get(route('password.reset', [
                'token' => session('password_reset_token'),
                'email' => $adminClient->email,
            ], false))
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Login')
            ->assertDontSee('Admin Client Dashboard')
            ->assertDontSee('Staff Login');

        $this
            ->post(route('password.store', absolute: false), [
                'token' => session('password_reset_token'),
                'email' => $adminClient->email,
                'password' => 'NewPassword1!',
                'password_confirmation' => 'NewPassword1!',
                'action_type' => 'auto_login',
            ])
            ->assertRedirect(route('admin.dashboard', absolute: false))
            ->assertSessionHas('staff_otp_passed', true);

        $this->assertAuthenticatedAs($adminClient);
        $this->assertTrue(Hash::check('NewPassword1!', $adminClient->fresh()->password));
    }

    public function test_staff_forgot_password_rejects_customer_email_without_sending_code(): void
    {
        Mail::fake();

        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'email' => 'customer-reset@example.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->post(route('admin.password.email', absolute: false), [
            'email' => $customer->email,
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('status', 'If that email belongs to an approved staff account, a verification code has been sent.')
            ->assertSessionMissing('password_reset_portal');
        Mail::assertNothingSent();
    }

    public function test_public_staff_registration_form_is_not_available(): void
    {
        $response = $this->get(route('admin.register', absolute: false));

        $response->assertNotFound();
    }

    public function test_public_staff_registration_submission_is_not_available(): void
    {
        Mail::fake();

        $response = $this->post(route('admin.register.submit', absolute: false), [
            'name' => 'Portal Developer',
            'email' => 'portal-developer@example.com',
            'role' => User::ROLE_DEVELOPER,
            'password' => 'Password1!',
        ]);

        $response->assertNotFound();
        $this->assertDatabaseMissing('users', ['email' => 'portal-developer@example.com']);
        $this->assertGuest();
        Mail::assertNothingSent();
    }

    public function test_developer_approval_keeps_invited_account_as_admin_client(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $pendingAdmin = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email' => 'pending-admin@example.com',
            'password' => Hash::make('Password1!'),
            'email_verified_at' => null,
            'approved_at' => null,
            'approved_by' => null,
            'invitation_accepted_at' => now(),
        ]);

        $pendingAdmin->adminClientProfile()->create([
            'business_name' => 'Admin Studio',
            'contact_person' => 'Pending Admin',
            'contact_number' => '09173333333',
            'business_address' => 'Admin Street',
            'profile_completed_at' => now(),
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->patch(route('developer.admin-clients.approve', $pendingAdmin, false));

        $pendingAdmin->refresh();

        $response->assertRedirect(route('developer.admin-clients.index', absolute: false));
        $this->assertSame(User::ROLE_ADMIN_CLIENT, $pendingAdmin->role);
        $this->assertNotNull($pendingAdmin->approved_at);
        $this->assertSame($developer->id, $pendingAdmin->approved_by);
    }

    public function test_verified_developer_login_still_requires_email_otp_each_session(): void
    {
        Mail::fake();

        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email' => 'developer@example.com',
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);

        $response = $this->post(route('admin.login.submit', absolute: false), [
            'email' => 'developer@example.com',
            'password' => 'Password1!',
        ]);

        $response
            ->assertRedirect(route('admin.otp.verify', absolute: false))
            ->assertSessionHas('needs_email_otp', true)
            ->assertSessionMissing('staff_otp_passed');

        $this->assertAuthenticatedAs($developer);
        $this->assertNotNull($developer->fresh()->otp_code);
        Mail::assertSent(OTPVerificationMail::class);
    }

    public function test_staff_email_otp_grants_dashboard_access_without_authenticator_app(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email' => 'developer@example.com',
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
            'otp_code' => '123456',
            'otp_expires_at' => now()->addMinutes(User::EMAIL_OTP_TTL_MINUTES),
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession([
                'admin_auth_passed' => true,
                'admin_email' => $developer->email,
                'needs_email_otp' => true,
            ])
            ->post(route('admin.otp.submit', absolute: false), [
                'otp' => '123456',
            ]);

        $response
            ->assertRedirect(route('admin.dashboard', absolute: false))
            ->assertSessionHas('staff_otp_passed', true)
            ->assertSessionMissing('admin_verified')
            ->assertSessionMissing('2fa_passed');

        $this->assertAuthenticatedAs($developer);
        $this->assertNull($developer->fresh()->otp_code);
    }

    public function test_suspending_admin_client_revokes_email_verification_and_2fa(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'google2fa_enabled' => true,
            'google2fa_secret' => 'JBSWY3DPEHPK3PXP',
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->patch(route('developer.admin-clients.suspend', $adminClient, false));

        $adminClient->refresh();

        $response->assertRedirect(route('developer.admin-clients.index', absolute: false));
        $this->assertNull($adminClient->approved_at);
        $this->assertNull($adminClient->approved_by);
        $this->assertNull($adminClient->email_verified_at);
        $this->assertFalse($adminClient->google2fa_enabled);
        $this->assertNull($adminClient->google2fa_secret);
    }

    public function test_legacy_authenticator_route_redirects_after_email_otp(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.security.2fa', absolute: false));

        $response->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_customer_credentials_are_rejected_by_staff_developer_portal(): void
    {
        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'email' => 'customer@example.com',
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);

        $response = $this->post(route('admin.login.submit', absolute: false), [
            'email' => $customer->email,
            'password' => 'Password1!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_customer_is_redirected_from_staff_developer_dashboard_with_feedback(): void
    {
        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($customer)
            ->withSession(['customer_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false));

        $response
            ->assertRedirect(route('admin.login', absolute: false))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_customer_cannot_submit_staff_portal_otp(): void
    {
        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'email_verified_at' => null,
            'otp_code' => '123456',
            'otp_expires_at' => now()->addMinutes(User::EMAIL_OTP_TTL_MINUTES),
        ]);

        $response = $this
            ->actingAs($customer)
            ->post(route('admin.otp.submit', absolute: false), [
                'otp' => '123456',
            ]);

        $response
            ->assertRedirect(route('admin.login', absolute: false))
            ->assertSessionHasErrors('email')
            ->assertSessionMissing('admin_verified');

        $this->assertGuest();
    }
}
