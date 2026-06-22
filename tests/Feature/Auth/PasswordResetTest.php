<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\SendOTP;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, SendOTP::class);
        $this->assertNotNull($user->fresh()->otp_code);
        $response
            ->assertSessionHas('password_reset_token')
            ->assertRedirect(route('otp.verify', [
                'email' => $user->email,
                'flow' => 'forgot_password',
            ], false));
    }

    public function test_existing_password_reset_otp_session_returns_to_verification_instead_of_cooldown(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email])
            ->assertRedirect(route('otp.verify', [
                'email' => $user->email,
                'flow' => 'forgot_password',
            ], false));

        $this->get('/forgot-password')
            ->assertRedirect(route('otp.verify', [
                'email' => $user->email,
                'flow' => 'forgot_password',
            ], false))
            ->assertSessionHas('status', 'A reset code was already sent. Enter it to continue.');
    }

    public function test_repeated_password_reset_request_during_cooldown_returns_to_existing_otp_verification(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email])
            ->assertRedirect(route('otp.verify', [
                'email' => $user->email,
                'flow' => 'forgot_password',
            ], false));

        $this->post('/forgot-password', ['email' => $user->email])
            ->assertRedirect(route('otp.verify', [
                'email' => $user->email,
                'flow' => 'forgot_password',
            ], false))
            ->assertSessionHas('status', 'A reset code was already sent. Enter it to continue.');

        Notification::assertSentToTimes($user, SendOTP::class, 1);
    }

    public function test_stale_password_reset_cooldown_without_pending_otp_does_not_block_form(): void
    {
        $email = 'stale-reset@example.com';

        RateLimiter::hit(
            'password-reset-request:' . Str::transliterate(Str::lower($email . '|127.0.0.1')),
            60
        );

        $this
            ->withSession(['password_reset_throttle_email' => $email])
            ->get('/forgot-password')
            ->assertOk()
            ->assertDontSee('Password reset cooldown active')
            ->assertSessionMissing('password_reset_throttle_email');
    }

    public function test_password_reset_request_does_not_reveal_unknown_email(): void
    {
        Notification::fake();

        $response = $this->post('/forgot-password', [
            'email' => 'missing@example.com',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertSessionHas('status', 'If that email belongs to an account, a verification code has been sent.');

        Notification::assertNothingSent();
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $token = 'test-reset-token';

        $response = $this
            ->withSession([
                'password_reset_token' => $token,
                'password_reset_email' => $user->email,
            ])
            ->get(route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ], false));

        $response->assertStatus(200);
    }

    public function test_reset_password_screen_uses_shared_custom_validation_and_action_choices(): void
    {
        $user = User::factory()->create();
        $token = 'test-reset-token';

        $response = $this
            ->withSession([
                'password_reset_token' => $token,
                'password_reset_email' => $user->email,
            ])
            ->get(route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ], false));

        $response
            ->assertOk()
            ->assertSee('id="resetForm" novalidate', false)
            ->assertSee('data-submit-reset="auto_login"', false)
            ->assertSee('data-submit-reset="manual_login"', false)
            ->assertSee('Dashboard')
            ->assertSee('Login')
            ->assertDontSee('Success!');
    }

    public function test_password_can_be_reset_after_otp_context_is_verified(): void
    {
        $user = User::factory()->create();
        $token = 'test-reset-token';

        $response = $this
            ->withSession([
                'password_reset_token' => $token,
                'password_reset_email' => $user->email,
            ])
            ->post(route('password.store', absolute: false), [
                'token' => $token,
                'email' => $user->email,
                'password' => 'NewPassword1!',
                'password_confirmation' => 'NewPassword1!',
                'action_type' => 'manual_login',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login', absolute: false));

        $this->assertTrue(Hash::check('NewPassword1!', $user->fresh()->password));
    }

    public function test_manual_password_reset_clears_customer_login_cooldown(): void
    {
        $user = User::factory()->create();
        $token = 'test-reset-token';
        $throttleKey = 'customer-login:' . Str::transliterate(Str::lower($user->email . '|127.0.0.1'));

        foreach (range(1, 3) as $_) {
            RateLimiter::hit($throttleKey, 300);
        }

        $this->assertTrue(RateLimiter::tooManyAttempts($throttleKey, 3));

        $response = $this
            ->withSession([
                'password_reset_token' => $token,
                'password_reset_email' => $user->email,
                'customer_login_throttle_email' => $user->email,
            ])
            ->post(route('password.store', absolute: false), [
                'token' => $token,
                'email' => $user->email,
                'password' => 'NewPassword1!',
                'password_confirmation' => 'NewPassword1!',
                'action_type' => 'manual_login',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login', absolute: false))
            ->assertSessionMissing('customer_login_throttle_email');

        $this->assertFalse(RateLimiter::tooManyAttempts($throttleKey, 3));

        $this
            ->followingRedirects()
            ->get(route('login', absolute: false))
            ->assertOk()
            ->assertDontSee('Login cooldown active');
    }

    public function test_forgot_password_otp_reset_flow_can_auto_login_user(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'reset-flow@example.com',
            'password' => Hash::make('old-password'),
        ]);

        $this->post('/forgot-password', [
            'email' => $user->email,
        ])->assertRedirect(route('otp.verify', [
            'email' => $user->email,
            'flow' => 'forgot_password',
        ], false));

        $otp = $user->fresh()->otp_code;

        $this->post(route('customer.otp.submit', absolute: false), [
            'email' => $user->email,
            'otp' => $otp,
        ])->assertRedirect(route('password.reset', [
            'token' => session('password_reset_token'),
            'email' => $user->email,
        ], false));

        $this->post(route('password.store', absolute: false), [
            'token' => session('password_reset_token'),
            'email' => $user->email,
            'password' => 'NewPassword1!',
            'password_confirmation' => 'NewPassword1!',
            'action_type' => 'auto_login',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('NewPassword1!', $user->fresh()->password));
    }

    public function test_password_reset_requires_shared_password_policy(): void
    {
        $user = User::factory()->create();
        $token = 'test-reset-token';

        $response = $this
            ->withSession([
                'password_reset_token' => $token,
                'password_reset_email' => $user->email,
            ])
            ->from(route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ], false))
            ->post(route('password.store', absolute: false), [
                'token' => $token,
                'email' => $user->email,
                'password' => 'weakpass',
                'password_confirmation' => 'weakpass',
                'action_type' => 'manual_login',
            ]);

        $response
            ->assertRedirect(route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ], false))
            ->assertSessionHasErrors('password');
    }
}
