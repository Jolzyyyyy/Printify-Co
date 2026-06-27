<?php

namespace Tests\Feature\Auth;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerPortalBackendAlignmentTest extends TestCase
{
    use RefreshDatabase;

    private function customer(array $overrides = []): User
    {
        return User::factory()->create(array_merge([
            'role' => User::ROLE_CUSTOMER,
            'email_verified_at' => now(),
            'name' => 'Aligned Customer',
            'phone' => '09171234567',
            'street' => 'Backend Street',
            'barangay' => 'Backend Barangay',
            'city' => 'Pasay City',
            'region' => 'National Capital Region',
            'postal_code' => '1300',
        ], $overrides));
    }

    private function actingCustomer(User $customer): self
    {
        return $this->actingAs($customer)->withSession(['customer_otp_passed' => true]);
    }

    public function test_customer_portal_pages_render_for_verified_customer(): void
    {
        $customer = $this->customer();

        foreach (['settings', 'preferences', 'security', 'notifications', 'help-center'] as $routeName) {
            $this->actingCustomer($customer)
                ->get(route($routeName, absolute: false))
                ->assertOk();
        }
    }

    public function test_preferences_route_opens_settings_with_backend_saved_preferences(): void
    {
        $customer = $this->customer([
            'preferences' => [
                'preferences' => [
                    'theme' => 'Dark',
                    'language' => 'English',
                ],
            ],
        ]);

        $this->actingCustomer($customer)
            ->get(route('preferences', absolute: false))
            ->assertOk()
            ->assertSee('Preferences')
            ->assertSee('Region & Localization', false)
            ->assertSee('Dark');
    }

    public function test_settings_save_persists_to_user_preferences_json(): void
    {
        $customer = $this->customer();

        $this->actingCustomer($customer)
            ->postJson(route('settings.save', absolute: false), [
                'group' => 'preferences',
                'key' => 'theme',
                'value' => 'Dark',
            ])
            ->assertOk()
            ->assertJson(['ok' => true]);

        $this->assertSame('Dark', data_get($customer->fresh()->preferences, 'preferences.theme'));
    }

    public function test_settings_payment_area_uses_real_payment_records_and_not_fake_cards(): void
    {
        $customer = $this->customer();
        $order = Order::create([
            'user_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'order_reference' => 'PFY-REAL-ORDER',
            'status' => 'completed',
            'total_price' => 450,
        ]);

        Payment::create([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'payment_method' => 'gcash',
            'payment_gateway' => 'paymongo',
            'gateway_reference' => 'PAY-REAL-123',
            'amount' => 450,
            'status' => Payment::STATUS_PAID,
            'paid_at' => now(),
        ]);

        $this->actingCustomer($customer)
            ->get(route('settings', absolute: false))
            ->assertOk()
            ->assertSee('PAY-REAL-123')
            ->assertSee('PHP 450.00')
            ->assertDontSee('Visa ending in 4242')
            ->assertDontSee('Mastercard ending in 8888')
            ->assertDontSee('Document Printing')
            ->assertDontSee('Large Format Printing');
    }

    public function test_notifications_use_customer_records_and_do_not_show_fake_demo_items(): void
    {
        $customer = $this->customer();
        $otherCustomer = $this->customer(['email' => 'other@example.test']);

        Order::create([
            'user_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'order_reference' => 'PFY-OWN-NOTIFY',
            'status' => 'Pending',
            'total_price' => 300,
        ]);

        Order::create([
            'user_id' => $otherCustomer->id,
            'customer_name' => $otherCustomer->name,
            'customer_email' => $otherCustomer->email,
            'order_reference' => 'PFY-HIDDEN-NOTIFY',
            'status' => 'Pending',
            'total_price' => 300,
        ]);

        $this->actingCustomer($customer)
            ->get(route('notifications', absolute: false))
            ->assertOk()
            ->assertSee('PFY-OWN-NOTIFY')
            ->assertDontSee('PFY-HIDDEN-NOTIFY')
            ->assertDontSee('#ORD-55201')
            ->assertDontSee('Exclusive Coupon');
    }

    public function test_customer_only_pages_reject_staff_users(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        foreach (['settings', 'preferences', 'security', 'notifications', 'help-center'] as $routeName) {
            $response = $this
                ->actingAs($developer)
                ->withSession(['staff_otp_passed' => true])
                ->get(route($routeName, absolute: false));

            $this->assertContains($response->getStatusCode(), [302, 403]);
        }
    }
}
