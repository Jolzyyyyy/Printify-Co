<?php

namespace Tests\Feature\Auth;

use App\Models\Business;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminClientDashboardAlignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_client_dashboard_uses_live_tenant_operations_without_demo_details(): void
    {
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
        ]);

        $business = Business::create([
            'name' => 'Admin Client Studio',
            'slug' => 'admin-client-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);

        $adminClient->forceFill(['business_id' => $business->id])->save();
        $adminClient->adminClientProfile()->create([
            'business_name' => 'Admin Client Studio',
            'contact_person' => 'Admin Client User',
            'contact_number' => '09170000000',
            'business_address' => '123 Admin Client Street',
            'profile_completed_at' => now(),
        ]);

        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'business_id' => $business->id,
            'admin_client_id' => $adminClient->id,
            'email_verified_at' => now(),
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'business_id' => $business->id,
            'admin_client_id' => $adminClient->id,
            'order_reference' => 'PFY-ADMIN-LIVE',
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => '+639171234567',
            'status' => 'Processing',
            'total_price' => 450,
            'payment_method' => 'gcash',
            'delivery_method' => 'lalamove',
            'delivery_address' => '123 Demo Street',
            'delivery_booking_status' => 'pending_manual_booking',
        ]);

        Payment::create([
            'business_id' => $business->id,
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'payment_method' => 'gcash',
            'payment_gateway' => 'paymongo',
            'amount' => 450,
            'status' => Payment::STATUS_PENDING,
        ]);

        Delivery::create([
            'business_id' => $business->id,
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'delivery_method' => 'lalamove',
            'delivery_address' => '123 Demo Street',
            'delivery_fee' => 100,
            'status' => 'pending_manual_booking',
        ]);

        $response = $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false));

        $response->assertOk();

        $content = $response->getContent();

        foreach ([
            'Paid Revenue',
            'Payment Attention',
            'Active Deliveries',
            'Order Workload',
            'Workspace Actions',
            'Operational Alerts',
            'Service Readiness',
            'Payment follow-up',
            'Delivery follow-up',
        ] as $expectedText) {
            $this->assertStringContainsString($expectedText, $content, "Dashboard is missing: {$expectedText}");
        }

        foreach ([
            '3 jobs currently in queue',
            '12.6% vs last 7 days',
            'VISA',
        ] as $removedText) {
            $this->assertStringNotContainsString($removedText, $content, "Dashboard still contains demo text: {$removedText}");
        }
    }
}
