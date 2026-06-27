<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerPortalViewSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_zip_designed_public_pages_render(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('PREMIUM PRINTS.')
            ->assertSee('printify-footer', false);

        $this->get(route('landing.about'))
            ->assertOk();

        $this->get(route('services.index'))
            ->assertOk()
            ->assertSee('Our Featured Services');

        $this->get(route('landing.contact'))
            ->assertOk();

        $this->get(route('landing.service-details'))
            ->assertOk();
    }

    public function test_customer_backend_pages_render_with_zip_design_sections(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($customer)
            ->withSession(['customer_otp_passed' => true]);

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Overview');

        $this->get(route('profile.edit'))
            ->assertOk();

        $this->get(route('myorders'))
            ->assertOk()
            ->assertSee('My Orders');

        $this->get(route('notifications'))
            ->assertOk()
            ->assertSee('Notifications');

        $this->get(route('security'))
            ->assertOk()
            ->assertSee('Security &amp; Privacy', false);

        $this->get(route('help-center'))
            ->assertOk()
            ->assertSee('Help Center');

        $this->get(route('settings'))
            ->assertOk()
            ->assertSee('st-settings-shell', false)
            ->assertSee('NOTIFICATION')
            ->assertSee('PREFERENCES')
            ->assertSee('SECURITY &amp; PRIVACY', false)
            ->assertSee('HELP-CENTER');
    }
}
