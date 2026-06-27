<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\SendOTP;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_staff_session_can_open_customer_login_without_admin_redirect(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
        $this->assertGuest();
    }

    public function test_authenticated_customer_login_link_uses_customer_redirect_flow(): void
    {
        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
        ]);

        $this
            ->actingAs($customer)
            ->get('/login')
            ->assertRedirect(route('dashboard.redirect', absolute: false));
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        Notification::assertSentTo($user, SendOTP::class);
        $response
            ->assertRedirect(route('otp.verify', [
                'email' => $user->email,
            ], false))
            ->assertSessionHas('otp_email', $user->email)
            ->assertSessionHas('auth_type', 'account_verification')
            ->assertSessionMissing('customer_otp_passed');
    }

    public function test_fresh_customer_login_clears_stale_otp_passed_session(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this
            ->withSession(['customer_otp_passed' => true])
            ->post('/login', [
                'email' => $user->email,
                'password' => 'password',
            ]);

        $this->assertAuthenticatedAs($user);
        Notification::assertSentTo($user, SendOTP::class);
        $response
            ->assertRedirect(route('otp.verify', [
                'email' => $user->email,
            ], false))
            ->assertSessionMissing('customer_otp_passed');
    }

    public function test_remember_me_sets_recaller_but_still_requires_customer_otp(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => 'on',
        ]);

        $this->assertAuthenticatedAs($user);
        Notification::assertSentTo($user, SendOTP::class);

        $response
            ->assertRedirect(route('otp.verify', [
                'email' => $user->email,
            ], false))
            ->assertCookie(Auth::guard('web')->getRecallerName())
            ->assertSessionHas('otp_email', $user->email)
            ->assertSessionMissing('customer_otp_passed');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_customer_login_locks_after_three_failed_attempts(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'three-attempt-customer@example.com',
        ]);

        for ($attempt = 0; $attempt < 3; $attempt++) {
            $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('email');
        }

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
        Notification::assertNothingSent();
    }

    public function test_normal_login_clears_stale_password_reset_session(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $response = $this
            ->withSession([
                'password_reset_email' => $user->email,
                'password_reset_token' => 'stale-token',
                'is_forgot_password' => true,
                'auth_type' => 'forgot_password',
            ])
            ->post('/login', [
                'email' => $user->email,
                'password' => 'password',
            ]);

        $this->assertAuthenticatedAs($user);
        Notification::assertSentTo($user, SendOTP::class);

        $response
            ->assertRedirect(route('otp.verify', [
                'email' => $user->email,
            ], false))
            ->assertSessionHas('otp_email', $user->email)
            ->assertSessionHas('auth_type', 'account_verification')
            ->assertSessionMissing('password_reset_email')
            ->assertSessionMissing('password_reset_token')
            ->assertSessionMissing('is_forgot_password');
    }

    public function test_customer_otp_requires_an_expiry_timestamp(): void
    {
        $user = User::factory()->unverified()->create([
            'otp_code' => '123456',
            'otp_expires_at' => null,
        ]);

        $response = $this
            ->withSession(['otp_email' => $user->email])
            ->from(route('otp.verify', [
                'email' => $user->email,
            ]))
            ->post(route('otp.submit'), [
                'email' => $user->email,
                'otp' => '123456',
            ]);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
        $response
            ->assertRedirect(route('otp.verify', [
                'email' => $user->email,
            ], false))
            ->assertSessionHasErrors('otp');
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
