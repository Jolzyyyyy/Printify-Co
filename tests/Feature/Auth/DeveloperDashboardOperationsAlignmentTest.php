<?php

namespace Tests\Feature\Auth;

use App\Models\AuditLog;
use App\Models\Business;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use App\Services\DeveloperDashboardMetricsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeveloperDashboardOperationsAlignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_developer_dashboard_renders_live_operations_and_reports_security_data(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'name' => 'Platform Admin Client',
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Platform Print Studio',
            'slug' => 'platform-print-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'name' => 'Platform Customer',
            'business_id' => $business->id,
            'admin_client_id' => $adminClient->id,
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'business_id' => $business->id,
            'admin_client_id' => $adminClient->id,
            'order_reference' => 'PFY-DEV-OPS',
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'status' => 'Processing',
            'total_price' => 700,
            'payment_method' => 'gcash',
            'delivery_method' => 'lalamove',
            'delivery_address' => 'Platform Address',
        ]);

        Payment::create([
            'business_id' => $business->id,
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'payment_method' => 'gcash',
            'payment_gateway' => 'paymongo',
            'gateway_reference' => 'paymongo-live-ref',
            'amount' => 700,
            'status' => Payment::STATUS_FAILED,
        ]);

        Delivery::create([
            'business_id' => $business->id,
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'delivery_method' => 'lalamove',
            'tracking_reference' => 'delivery-live-ref',
            'delivery_address' => 'Platform Address',
            'delivery_fee' => 120,
            'status' => 'out_for_delivery',
        ]);

        Service::create([
            'name' => 'Developer Service',
            'category' => 'Printing',
            'retail_price' => 20,
            'bulk_price' => 15,
            'unit' => 'page',
            'is_active' => true,
        ]);

        AuditLog::create([
            'actor_id' => $developer->id,
            'business_id' => $business->id,
            'action' => 'business_status_reviewed',
            'module' => 'business',
        ]);

        $dashboard = app(DeveloperDashboardMetricsService::class)->overview([
            'search' => null,
            'date_range' => 'this_month',
            'date_from' => now()->startOfMonth(),
            'date_to' => now()->endOfDay(),
            'business_id' => null,
            'status' => null,
            'payment_method' => null,
        ]);

        $operationCards = collect($dashboard['operationsCards'])->pluck('value', 'label');
        $securityCards = collect($dashboard['reportsSecurityCards'])->pluck('value', 'label');

        $this->assertSame(1, $operationCards['Platform Orders']);
        $this->assertSame(1, $operationCards['Payment Attention']);
        $this->assertSame(1, $operationCards['Active Deliveries']);
        $this->assertSame(1, $operationCards['Platform Customers']);
        $this->assertSame(1, $operationCards['Service Readiness']);
        $this->assertSame(1, $securityCards['Audit Logs']);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false));

        $response->assertOk();
        $content = $response->getContent();

        foreach ([
            'Operations Command Center',
            'Reports & Security',
            'Platform Orders',
            'Payment Attention',
            'Active Deliveries',
            'Reports & Security Activity',
            'Audit Logs',
            'paymongo-live-ref',
            'delivery-live-ref',
            'href="'.route('developer.payments.index').'"',
            'href="'.route('developer.deliveries.index').'"',
            'href="'.route('developer.audit-logs.index').'"',
            'href="'.route('developer.security.index').'"',
        ] as $expectedText) {
            $this->assertStringContainsString($expectedText, $content, "Developer dashboard is missing {$expectedText}");
        }

        foreach ([
            '3 jobs currently in queue',
            '12.6% vs last 7 days',
            'VISA',
            'full courier API integration',
            'live production deployment',
            '<h2>Notifications</h2>',
        ] as $removedText) {
            $this->assertStringNotContainsString($removedText, $content, "Developer dashboard still contains unsupported text: {$removedText}");
        }
    }

    public function test_developer_operations_and_reports_security_routes_are_developer_only(): void
    {
        $developer = User::factory()->create(['role' => User::ROLE_DEVELOPER, 'email_verified_at' => now()]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $customer = User::factory()->create(['role' => User::ROLE_CUSTOMER, 'email_verified_at' => now()]);

        foreach ($this->developerOnlyRoutes() as $routeName) {
            $this
                ->actingAs($developer)
                ->withSession(['staff_otp_passed' => true])
                ->get(route($routeName, absolute: false))
                ->assertOk();

            $this
                ->actingAs($adminClient)
                ->withSession(['staff_otp_passed' => true])
                ->get(route($routeName, absolute: false))
                ->assertForbidden();

            $customerResponse = $this
                ->actingAs($customer)
                ->withSession(['customer_otp_passed' => true])
                ->get(route($routeName, absolute: false));

            $this->assertContains($customerResponse->getStatusCode(), [302, 403]);
        }
    }

    public function test_empty_developer_dashboard_data_uses_empty_states(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false));

        $response->assertOk();
        $content = $response->getContent();

        foreach ([
            'Operations Command Center',
            'Reports & Security',
            'No orders for the selected date range.',
            'No payment issues for this range.',
            'No deliveries for this range.',
            'No audit logs yet.',
        ] as $expectedText) {
            $this->assertStringContainsString($expectedText, $content, "Empty dashboard is missing {$expectedText}");
        }
    }

    /**
     * @return list<string>
     */
    private function developerOnlyRoutes(): array
    {
        return [
            'developer.orders.index',
            'developer.payments.index',
            'developer.deliveries.index',
            'developer.reports.index',
            'developer.analytics.index',
            'developer.audit-logs.index',
            'developer.security.index',
        ];
    }
}
