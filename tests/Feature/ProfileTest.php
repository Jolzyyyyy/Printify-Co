<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->patch('/profile', [
                'username' => 'test_user',
                'first_name' => 'Test',
                'last_name' => 'User',
                'email' => 'test@example.com',
                'backup_email' => 'test.backup@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test_user', $user->username);
        $this->assertSame('test@example.com', $user->email);
        $this->assertSame('test.backup@example.com', $user->backup_email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->patch('/profile', [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_customer_profile_details_are_saved_to_the_account_record(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@example.com',
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->patchJson('/profile', [
                'name' => 'Maria Santos',
                'username' => 'maria_santos',
                'email' => 'customer@example.com',
                'backup_email' => 'maria.backup@example.com',
                'phone' => '+639171112222',
                'birthdate' => '1998-04-12',
                'gender' => 'Female',
                'street' => 'Blk 6 Lot 8',
                'barangay' => 'Ninada',
                'region' => 'Metro Manila',
                'province' => 'Metro Manila',
                'city' => 'Quezon City',
                'postal_code' => '1121',
                'company' => 'Printify Co.',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('ok', true);

        $user->refresh();

        $this->assertSame('Maria Santos', $user->name);
        $this->assertSame('maria_santos', $user->username);
        $this->assertSame('maria.backup@example.com', $user->backup_email);
        $this->assertSame('+639171112222', $user->phone);
        $this->assertSame('1998-04-12', $user->birthdate);
        $this->assertSame('Female', $user->gender);
        $this->assertSame('Blk 6 Lot 8', $user->street);
        $this->assertSame('Ninada', $user->barangay);
        $this->assertSame('Metro Manila', $user->region);
        $this->assertSame('Metro Manila', $user->province);
        $this->assertSame('Quezon City', $user->city);
        $this->assertSame('1121', $user->postal_code);
        $this->assertSame('Printify Co.', $user->company);
    }

    public function test_profile_phone_number_is_normalized_to_e164_format(): void
    {
        $user = User::factory()->create([
            'email' => 'phone-normalize@example.com',
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->patchJson('/profile', [
                'first_name' => 'Phone',
                'last_name' => 'User',
                'email' => 'phone-normalize@example.com',
                'phone' => '0917 111 2222',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('ok', true);

        $this->assertSame('+639171112222', $user->refresh()->phone);
    }

    public function test_profile_accepts_plain_country_code_mobile_number_and_stores_plus639(): void
    {
        $user = User::factory()->create([
            'email' => 'phone-country-code@example.com',
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->patchJson('/profile', [
                'first_name' => 'Phone',
                'last_name' => 'User',
                'email' => 'phone-country-code@example.com',
                'phone' => '639171112222',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('ok', true);

        $this->assertSame('+639171112222', $user->refresh()->phone);
    }

    public function test_profile_rejects_philippine_landline_number(): void
    {
        $user = User::factory()->create([
            'email' => 'phone-landline@example.com',
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->patchJson('/profile', [
                'first_name' => 'Phone',
                'last_name' => 'User',
                'email' => 'phone-landline@example.com',
                'phone' => '+63281234567',
            ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('phone');
    }

    public function test_profile_rejects_invalid_philippine_mobile_number(): void
    {
        $user = User::factory()->create([
            'email' => 'phone-invalid@example.com',
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->patchJson('/profile', [
                'first_name' => 'Phone',
                'last_name' => 'User',
                'email' => 'phone-invalid@example.com',
                'phone' => '12345',
            ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('phone');
    }

    public function test_backup_email_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->patch('/profile/backup-email', [
                'backup_email' => 'backup@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertSame('backup@example.com', $user->refresh()->backup_email);
    }

    public function test_backup_email_cannot_match_primary_email(): void
    {
        $user = User::factory()->create([
            'email' => 'primary@example.com',
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->from('/profile')
            ->patch('/profile/backup-email', [
                'backup_email' => 'primary@example.com',
            ]);

        $response
            ->assertSessionHasErrorsIn('backupEmail', 'backup_email')
            ->assertRedirect('/profile');
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->withSession(['customer_otp_passed' => true])
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
