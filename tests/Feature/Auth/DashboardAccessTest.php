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
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_dashboard_renders_for_verified_customer(): void
    {
        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($customer)
            ->withSession(['customer_otp_passed' => true])
            ->get(route('dashboard', absolute: false));

        $response
            ->assertOk()
            ->assertSee('Client Portal')
            ->assertSee('Dashboard Overview')
            ->assertSee('Customer');
    }

    public function test_verified_customer_without_session_otp_is_redirected_to_otp(): void
    {
        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($customer)
            ->get(route('dashboard', absolute: false));

        $response
            ->assertRedirect(route('customer.otp.verify', absolute: false))
            ->assertSessionHasErrors('otp');
    }

    public function test_developer_on_customer_dashboard_is_redirected_to_staff_dashboard(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('dashboard', absolute: false));

        $response
            ->assertRedirect(route('admin.dashboard', absolute: false))
            ->assertSessionHas('status', 'This account belongs to the staff portal. Redirecting you to the correct dashboard.');
    }

    public function test_developer_dashboard_renders_developer_controls(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
            'google2fa_enabled' => true,
            'google2fa_secret' => 'JBSWY3DPEHPK3PXP',
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false));

        $response
            ->assertOk()
            ->assertSee('Developer Dashboard')
            ->assertSee('Manage Admin Clients')
            ->assertSee('Recent Audit Activity');
    }

    public function test_admin_client_dashboard_does_not_render_developer_controls(): void
    {
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
        ]);
        $adminClient->adminClientProfile()->create([
            'business_name' => 'Admin Client Studio',
            'contact_person' => 'Admin Client User',
            'contact_number' => '09170000000',
            'business_address' => '123 Admin Client Street',
            'profile_completed_at' => now(),
        ]);

        $response = $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false));

        $response
            ->assertOk()
            ->assertSee('Admin Management Portal')
            ->assertSee('ADMIN DASHBOARD')
            ->assertDontSee('Developer Dashboard')
            ->assertDontSee('Manage Admin Clients');
    }

    public function test_admin_client_cannot_access_developer_admin_client_management(): void
    {
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
        ]);

        $response = $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.admin-clients.index', absolute: false));

        $response->assertForbidden();
    }

    public function test_developer_admin_client_management_uses_developer_portal_shell(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.admin-clients.index', absolute: false));

        $response
            ->assertOk()
            ->assertSee('Developer Portal')
            ->assertSee('Developer')
            ->assertSee('Manage Admin Clients')
            ->assertDontSee('Client Portal')
            ->assertDontSee('My Orders');
    }

    public function test_developer_dashboard_sidebar_uses_required_sections_only(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false));

        $response
            ->assertOk()
            ->assertSee('Go to Home')
            ->assertSee('Dashboard')
            ->assertSee('Manage Admin Clients')
            ->assertSee('Orders')
            ->assertSee('Services')
            ->assertSee('Customers')
            ->assertSee('Reports')
            ->assertSee('Analytics')
            ->assertSee('Settings')
            ->assertDontSee('Products')
            ->assertDontSee('Rates')
            ->assertDontSee('Help Center')
            ->assertDontSee('Customer/User');
    }

    public function test_admin_client_dashboard_renders_after_approval_and_profile_completion(): void
    {
        $developer = User::factory()->create(['role' => User::ROLE_DEVELOPER]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
            'google2fa_enabled' => true,
            'google2fa_secret' => 'JBSWY3DPEHPK3PXP',
        ]);

        $adminClient->adminClientProfile()->create([
            'business_name' => 'Dashboard Studio',
            'contact_person' => 'Dashboard Owner',
            'contact_number' => '09172222222',
            'business_address' => '789 Dashboard Street',
            'profile_completed_at' => now(),
        ]);

        $response = $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false));

        $response
            ->assertOk()
            ->assertSee('Admin Client Dashboard')
            ->assertSee('Access Checklist')
            ->assertSee('Reference Profile');
    }

    public function test_developer_can_assign_customer_to_admin_client_and_move_existing_orders(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'approved_by' => $developer->id,
        ]);

        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'email' => 'customer-scope@example.com',
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'status' => 'Pending',
            'total_price' => 150,
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->patch(route('developer.admin-clients.assign-customer', $adminClient, false), [
                'customer_email' => 'customer-scope@example.com',
            ]);

        $response->assertRedirect(route('developer.admin-clients.index', absolute: false));
        $this->assertSame($adminClient->id, $customer->fresh()->admin_client_id);
        $this->assertSame($adminClient->id, $order->fresh()->admin_client_id);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'customer_assigned_to_admin_client',
            'actor_id' => $developer->id,
            'target_user_id' => $customer->id,
        ]);
    }

    public function test_admin_client_order_database_is_limited_to_assigned_records(): void
    {
        $developer = User::factory()->create(['role' => User::ROLE_DEVELOPER]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
        ]);
        $otherAdminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
        ]);

        $adminClient->adminClientProfile()->create([
            'business_name' => 'Scope Studio',
            'contact_person' => 'Scope Owner',
            'contact_number' => '09173333333',
            'business_address' => '100 Scope Street',
            'profile_completed_at' => now(),
        ]);

        $assignedCustomer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'name' => 'Assigned Customer',
            'admin_client_id' => $adminClient->id,
        ]);
        $otherCustomer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'name' => 'Other Customer',
            'admin_client_id' => $otherAdminClient->id,
        ]);

        $assignedOrder = Order::create([
            'user_id' => $assignedCustomer->id,
            'admin_client_id' => $adminClient->id,
            'customer_name' => 'Assigned Customer',
            'customer_email' => $assignedCustomer->email,
            'status' => 'Processing',
            'total_price' => 250,
        ]);
        $otherOrder = Order::create([
            'user_id' => $otherCustomer->id,
            'admin_client_id' => $otherAdminClient->id,
            'customer_name' => 'Other Customer',
            'customer_email' => $otherCustomer->email,
            'status' => 'Pending',
            'total_price' => 300,
        ]);

        $response = $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.orders.index', absolute: false));

        $response
            ->assertOk()
            ->assertSee('Assigned Customer')
            ->assertDontSee('Other Customer');

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.customers.index', absolute: false))
            ->assertOk()
            ->assertSee('Assigned Customer')
            ->assertDontSee('Other Customer');

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.orders.show', $otherOrder, false))
            ->assertForbidden();

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.orders.show', $assignedOrder, false))
            ->assertOk();
    }

    public function test_developer_dashboard_can_show_all_businesses(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        $firstAdmin = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $firstBusiness = Business::create([
            'name' => 'North Print Studio',
            'slug' => 'north-print-studio',
            'owner_user_id' => $firstAdmin->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $firstAdmin->forceFill(['business_id' => $firstBusiness->id])->save();

        $secondAdmin = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $secondBusiness = Business::create([
            'name' => 'South Print Studio',
            'slug' => 'south-print-studio',
            'owner_user_id' => $secondAdmin->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $secondAdmin->forceFill(['business_id' => $secondBusiness->id])->save();

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false));

        $response
            ->assertOk()
            ->assertSee('North Print Studio')
            ->assertSee('South Print Studio')
            ->assertSee('Total Businesses');
    }

    public function test_admin_client_order_visibility_prefers_business_id_with_admin_client_fallback(): void
    {
        $developer = User::factory()->create(['role' => User::ROLE_DEVELOPER]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
            'email_verified_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Tenant Scope Studio',
            'slug' => 'tenant-scope-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();
        $adminClient->adminClientProfile()->create([
            'business_name' => 'Tenant Scope Studio',
            'contact_person' => 'Scope Owner',
            'contact_number' => '09173333333',
            'business_address' => '100 Scope Street',
            'profile_completed_at' => now(),
        ]);

        $otherAdminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
        ]);
        $otherBusiness = Business::create([
            'name' => 'Other Tenant Studio',
            'slug' => 'other-tenant-studio',
            'owner_user_id' => $otherAdminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $otherAdminClient->forceFill(['business_id' => $otherBusiness->id])->save();

        $assignedCustomer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'name' => 'Business Assigned Customer',
            'business_id' => $business->id,
        ]);
        $otherCustomer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'name' => 'Other Business Customer',
            'business_id' => $otherBusiness->id,
        ]);

        Order::create([
            'user_id' => $assignedCustomer->id,
            'business_id' => $business->id,
            'customer_name' => 'Business Assigned Customer',
            'customer_email' => $assignedCustomer->email,
            'status' => 'Processing',
            'total_price' => 250,
        ]);
        Order::create([
            'user_id' => $otherCustomer->id,
            'business_id' => $otherBusiness->id,
            'customer_name' => 'Other Business Customer',
            'customer_email' => $otherCustomer->email,
            'status' => 'Pending',
            'total_price' => 300,
        ]);

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.orders.index', absolute: false))
            ->assertOk()
            ->assertSee('Business Assigned Customer')
            ->assertDontSee('Other Business Customer');
    }

    public function test_admin_client_only_sees_payments_for_own_business(): void
    {
        $developer = User::factory()->create(['role' => User::ROLE_DEVELOPER]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Payment Tenant Studio',
            'slug' => 'payment-tenant-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $otherAdminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
        ]);
        $otherBusiness = Business::create([
            'name' => 'Other Payment Tenant',
            'slug' => 'other-payment-tenant',
            'owner_user_id' => $otherAdminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $otherAdminClient->forceFill(['business_id' => $otherBusiness->id])->save();

        $ownOrder = Order::create([
            'user_id' => User::factory()->create(['role' => User::ROLE_CUSTOMER, 'business_id' => $business->id])->id,
            'business_id' => $business->id,
            'admin_client_id' => $adminClient->id,
            'customer_name' => 'Payment Tenant Customer',
            'customer_email' => 'tenant-payment@example.com',
            'status' => 'paid',
            'total_price' => 500,
        ]);
        $otherOrder = Order::create([
            'user_id' => User::factory()->create(['role' => User::ROLE_CUSTOMER, 'business_id' => $otherBusiness->id])->id,
            'business_id' => $otherBusiness->id,
            'admin_client_id' => $otherAdminClient->id,
            'customer_name' => 'Other Payment Customer',
            'customer_email' => 'other-payment@example.com',
            'status' => 'paid',
            'total_price' => 900,
        ]);

        Payment::create([
            'business_id' => $business->id,
            'order_id' => $ownOrder->id,
            'customer_id' => $ownOrder->user_id,
            'payment_method' => 'gcash',
            'payment_gateway' => 'paymongo',
            'gateway_reference' => 'own-payment-ref',
            'amount' => 500,
            'status' => Payment::STATUS_PAID,
            'paid_at' => now(),
        ]);
        Payment::create([
            'business_id' => $otherBusiness->id,
            'order_id' => $otherOrder->id,
            'customer_id' => $otherOrder->user_id,
            'payment_method' => 'card',
            'payment_gateway' => 'paymongo',
            'gateway_reference' => 'other-payment-ref',
            'amount' => 900,
            'status' => Payment::STATUS_PAID,
            'paid_at' => now(),
        ]);

        $visiblePayments = Payment::visibleToPortalUser($adminClient)->pluck('gateway_reference')->all();

        $this->assertContains('own-payment-ref', $visiblePayments);
        $this->assertNotContains('other-payment-ref', $visiblePayments);
    }

    public function test_admin_client_only_sees_deliveries_for_own_business(): void
    {
        $developer = User::factory()->create(['role' => User::ROLE_DEVELOPER]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Delivery Tenant Studio',
            'slug' => 'delivery-tenant-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $otherAdminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
        ]);
        $otherBusiness = Business::create([
            'name' => 'Other Delivery Tenant',
            'slug' => 'other-delivery-tenant',
            'owner_user_id' => $otherAdminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $otherAdminClient->forceFill(['business_id' => $otherBusiness->id])->save();

        $ownOrder = Order::create([
            'user_id' => User::factory()->create(['role' => User::ROLE_CUSTOMER, 'business_id' => $business->id])->id,
            'business_id' => $business->id,
            'admin_client_id' => $adminClient->id,
            'customer_name' => 'Delivery Tenant Customer',
            'customer_email' => 'tenant-delivery@example.com',
            'status' => 'paid',
            'total_price' => 500,
        ]);
        $otherOrder = Order::create([
            'user_id' => User::factory()->create(['role' => User::ROLE_CUSTOMER, 'business_id' => $otherBusiness->id])->id,
            'business_id' => $otherBusiness->id,
            'admin_client_id' => $otherAdminClient->id,
            'customer_name' => 'Other Delivery Customer',
            'customer_email' => 'other-delivery@example.com',
            'status' => 'paid',
            'total_price' => 900,
        ]);

        Delivery::create([
            'business_id' => $business->id,
            'order_id' => $ownOrder->id,
            'customer_id' => $ownOrder->user_id,
            'delivery_method' => 'lalamove',
            'tracking_reference' => 'own-delivery-ref',
            'delivery_address' => 'Own customer address',
            'delivery_fee' => 150,
            'status' => 'pending_manual_booking',
        ]);
        Delivery::create([
            'business_id' => $otherBusiness->id,
            'order_id' => $otherOrder->id,
            'customer_id' => $otherOrder->user_id,
            'delivery_method' => 'lalamove',
            'tracking_reference' => 'other-delivery-ref',
            'delivery_address' => 'Other customer address',
            'delivery_fee' => 150,
            'status' => 'pending_manual_booking',
        ]);

        $visibleDeliveries = Delivery::visibleToPortalUser($adminClient)->pluck('tracking_reference')->all();

        $this->assertContains('own-delivery-ref', $visibleDeliveries);
        $this->assertNotContains('other-delivery-ref', $visibleDeliveries);
    }

    public function test_developer_can_view_business_detail_page(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Detail Page Studio',
            'slug' => 'detail-page-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
            'email' => 'detail@example.com',
            'contact_number' => '09175550000',
            'address' => 'Detail Street',
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.businesses.show', $business, false));

        $response
            ->assertOk()
            ->assertSee('Detail Page Studio')
            ->assertSee('Business Profile')
            ->assertSee('Customers')
            ->assertSee('Orders')
            ->assertSee('Payments')
            ->assertSee('Deliveries')
            ->assertSee('Audit Logs');
    }

    public function test_admin_client_cannot_view_developer_business_detail_page(): void
    {
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Restricted Business Studio',
            'slug' => 'restricted-business-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.businesses.show', $business, false))
            ->assertForbidden();
    }

    public function test_business_detail_page_shows_only_selected_business_records(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Selected Tenant Studio',
            'slug' => 'selected-tenant-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $otherAdminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $otherBusiness = Business::create([
            'name' => 'Other Tenant Detail',
            'slug' => 'other-tenant-detail',
            'owner_user_id' => $otherAdminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $otherAdminClient->forceFill(['business_id' => $otherBusiness->id])->save();

        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'name' => 'Selected Tenant Customer',
            'business_id' => $business->id,
        ]);
        $otherCustomer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'name' => 'Other Tenant Customer Hidden',
            'business_id' => $otherBusiness->id,
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'business_id' => $business->id,
            'admin_client_id' => $adminClient->id,
            'order_reference' => 'PFY-SELECTED-BIZ',
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'status' => 'Completed',
            'total_price' => 750,
            'paid_at' => now(),
        ]);
        $otherOrder = Order::create([
            'user_id' => $otherCustomer->id,
            'business_id' => $otherBusiness->id,
            'admin_client_id' => $otherAdminClient->id,
            'order_reference' => 'PFY-HIDDEN-BIZ',
            'customer_name' => $otherCustomer->name,
            'customer_email' => $otherCustomer->email,
            'status' => 'Completed',
            'total_price' => 900,
            'paid_at' => now(),
        ]);

        Payment::create([
            'business_id' => $business->id,
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'payment_method' => 'gcash',
            'payment_gateway' => 'paymongo',
            'gateway_reference' => 'pay-selected-business',
            'amount' => 750,
            'status' => Payment::STATUS_PAID,
            'paid_at' => now(),
        ]);
        Payment::create([
            'business_id' => $otherBusiness->id,
            'order_id' => $otherOrder->id,
            'customer_id' => $otherCustomer->id,
            'payment_method' => 'card',
            'payment_gateway' => 'paymongo',
            'gateway_reference' => 'pay-hidden-business',
            'amount' => 900,
            'status' => Payment::STATUS_PAID,
            'paid_at' => now(),
        ]);
        Delivery::create([
            'business_id' => $business->id,
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'delivery_method' => 'lalamove',
            'tracking_reference' => 'delivery-selected-business',
            'delivery_address' => 'Selected address',
            'delivery_fee' => 150,
            'status' => 'pending_manual_booking',
        ]);
        Delivery::create([
            'business_id' => $otherBusiness->id,
            'order_id' => $otherOrder->id,
            'customer_id' => $otherCustomer->id,
            'delivery_method' => 'lalamove',
            'tracking_reference' => 'delivery-hidden-business',
            'delivery_address' => 'Other address',
            'delivery_fee' => 150,
            'status' => 'pending_manual_booking',
        ]);
        Service::create([
            'business_id' => $business->id,
            'name' => 'Selected Business Service',
            'category' => 'Printing',
            'retail_price' => 10,
            'bulk_price' => 8,
            'unit' => 'page',
            'is_active' => true,
        ]);
        Service::create([
            'business_id' => $otherBusiness->id,
            'name' => 'Hidden Business Service',
            'category' => 'Printing',
            'retail_price' => 10,
            'bulk_price' => 8,
            'unit' => 'page',
            'is_active' => true,
        ]);
        AuditLog::create([
            'actor_id' => $adminClient->id,
            'target_user_id' => $customer->id,
            'business_id' => $business->id,
            'action' => 'selected_business_action',
        ]);
        AuditLog::create([
            'actor_id' => $otherAdminClient->id,
            'target_user_id' => $otherCustomer->id,
            'business_id' => $otherBusiness->id,
            'action' => 'hidden_business_action',
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.businesses.show', $business, false));

        $response
            ->assertOk()
            ->assertSee('Selected Tenant Studio')
            ->assertSee('Selected Tenant Customer')
            ->assertSee('PFY-SELECTED-BIZ')
            ->assertSee('pay-selected-business')
            ->assertSee('delivery-selected-business')
            ->assertSee('Selected Business Service')
            ->assertSee('Selected Business Action')
            ->assertDontSee('Other Tenant Customer Hidden')
            ->assertDontSee('PFY-HIDDEN-BIZ')
            ->assertDontSee('pay-hidden-business')
            ->assertDontSee('delivery-hidden-business')
            ->assertDontSee('Hidden Business Service')
            ->assertDontSee('Hidden Business Action');
    }

    public function test_dashboard_view_link_resolves_to_business_detail_page(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'name' => 'Dashboard Link Admin',
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Dashboard Link Studio',
            'slug' => 'dashboard-link-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false))
            ->assertOk()
            ->assertSee('Dashboard Link Studio')
            ->assertSee('href="'.route('developer.businesses.show', $business).'"', false);
    }

    public function test_developer_dashboard_report_route_renders(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'name' => 'Report Admin Client',
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Report Ready Studio',
            'slug' => 'report-ready-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.dashboard.export', ['format' => 'xls'], false));

        $response->assertOk();
        $content = $response->streamedContent();

        $this->assertStringContainsString('Developer Dashboard Report', $content);
        $this->assertStringContainsString('Report Ready Studio', $content);
        $this->assertStringContainsString('Business Health Summary', $content);
    }

    public function test_business_level_report_route_renders(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'name' => 'Business Report Owner',
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Business Report Studio',
            'slug' => 'business-report-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();
        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'name' => 'Report Customer',
            'business_id' => $business->id,
        ]);
        $order = Order::create([
            'user_id' => $customer->id,
            'business_id' => $business->id,
            'admin_client_id' => $adminClient->id,
            'order_reference' => 'PFY-BIZ-REPORT',
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'status' => 'Completed',
            'total_price' => 1200,
            'paid_at' => now(),
        ]);
        Payment::create([
            'business_id' => $business->id,
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'payment_method' => 'gcash',
            'payment_gateway' => 'paymongo',
            'gateway_reference' => 'biz-report-payment-ref',
            'amount' => 1200,
            'status' => Payment::STATUS_PAID,
            'paid_at' => now(),
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.businesses.export', [$business, 'format' => 'xls'], false));

        $response->assertOk();
        $content = $response->streamedContent();

        $this->assertStringContainsString('Business-Level Report', $content);
        $this->assertStringContainsString('Business Report Studio', $content);
        $this->assertStringContainsString('biz-report-payment-ref', $content);
    }

    public function test_admin_client_cannot_access_developer_report_exports(): void
    {
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Protected Report Studio',
            'slug' => 'protected-report-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.dashboard.export', ['format' => 'xls'], false))
            ->assertForbidden();

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.businesses.export', [$business, 'format' => 'xls'], false))
            ->assertForbidden();
    }

    public function test_reports_work_with_empty_data(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Empty Report Studio',
            'slug' => 'empty-report-studio',
            'status' => Business::STATUS_INACTIVE,
        ]);

        $dashboardResponse = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.dashboard.export', ['format' => 'xls'], false));

        $dashboardResponse->assertOk();
        $this->assertStringContainsString('No payments found for this period.', $dashboardResponse->streamedContent());

        $businessResponse = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.businesses.export', [$business, 'format' => 'xls'], false));

        $businessResponse->assertOk();
        $businessContent = $businessResponse->streamedContent();
        $this->assertStringContainsString('No payments found for this period.', $businessContent);
        $this->assertStringContainsString('No deliveries found for this period.', $businessContent);
        $this->assertStringContainsString('No audit logs found.', $businessContent);
    }

    public function test_business_report_uses_business_id_filtering(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        $selectedAdmin = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $hiddenAdmin = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $selectedBusiness = Business::create([
            'name' => 'Selected Report Studio',
            'slug' => 'selected-report-studio',
            'owner_user_id' => $selectedAdmin->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $hiddenBusiness = Business::create([
            'name' => 'Hidden Report Studio',
            'slug' => 'hidden-report-studio',
            'owner_user_id' => $hiddenAdmin->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $selectedAdmin->forceFill(['business_id' => $selectedBusiness->id])->save();
        $hiddenAdmin->forceFill(['business_id' => $hiddenBusiness->id])->save();
        $selectedCustomer = User::factory()->create(['role' => User::ROLE_CUSTOMER, 'business_id' => $selectedBusiness->id]);
        $hiddenCustomer = User::factory()->create(['role' => User::ROLE_CUSTOMER, 'business_id' => $hiddenBusiness->id]);
        $selectedOrder = Order::create([
            'user_id' => $selectedCustomer->id,
            'business_id' => $selectedBusiness->id,
            'admin_client_id' => $selectedAdmin->id,
            'order_reference' => 'PFY-REPORT-SELECTED',
            'customer_name' => $selectedCustomer->name,
            'customer_email' => $selectedCustomer->email,
            'status' => 'Completed',
            'total_price' => 500,
            'paid_at' => now(),
        ]);
        $hiddenOrder = Order::create([
            'user_id' => $hiddenCustomer->id,
            'business_id' => $hiddenBusiness->id,
            'admin_client_id' => $hiddenAdmin->id,
            'order_reference' => 'PFY-REPORT-HIDDEN',
            'customer_name' => $hiddenCustomer->name,
            'customer_email' => $hiddenCustomer->email,
            'status' => 'Completed',
            'total_price' => 900,
            'paid_at' => now(),
        ]);
        Payment::create([
            'business_id' => $selectedBusiness->id,
            'order_id' => $selectedOrder->id,
            'customer_id' => $selectedCustomer->id,
            'payment_method' => 'gcash',
            'gateway_reference' => 'selected-business-report-payment',
            'amount' => 500,
            'status' => Payment::STATUS_PAID,
        ]);
        Payment::create([
            'business_id' => $hiddenBusiness->id,
            'order_id' => $hiddenOrder->id,
            'customer_id' => $hiddenCustomer->id,
            'payment_method' => 'card',
            'gateway_reference' => 'hidden-business-report-payment',
            'amount' => 900,
            'status' => Payment::STATUS_PAID,
        ]);

        $response = $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.businesses.export', [$selectedBusiness, 'format' => 'xls'], false));

        $response->assertOk();
        $content = $response->streamedContent();

        $this->assertStringContainsString('Selected Report Studio', $content);
        $this->assertStringContainsString('selected-business-report-payment', $content);
        $this->assertStringNotContainsString('Hidden Report Studio', $content);
        $this->assertStringNotContainsString('hidden-business-report-payment', $content);
    }

    public function test_developer_can_suspend_business_and_audit_log_is_created(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Suspendable Studio',
            'slug' => 'suspendable-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->patch(route('developer.businesses.suspend', $business, false))
            ->assertRedirect();

        $this->assertSame(Business::STATUS_SUSPENDED, $business->fresh()->status);

        $log = AuditLog::where('business_id', $business->id)
            ->where('action', 'business_suspended')
            ->first();

        $this->assertNotNull($log);
        $this->assertSame('business', $log->module);
        $this->assertSame(Business::STATUS_ACTIVE, $log->old_values['status']);
        $this->assertSame(Business::STATUS_SUSPENDED, $log->new_values['status']);
    }

    public function test_developer_can_reactivate_business(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Reactivate Studio',
            'slug' => 'reactivate-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_SUSPENDED,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->patch(route('developer.businesses.activate', $business, false))
            ->assertRedirect();

        $this->assertSame(Business::STATUS_ACTIVE, $business->fresh()->status);
        $this->assertDatabaseHas('audit_logs', [
            'business_id' => $business->id,
            'action' => 'business_activated',
            'module' => 'business',
        ]);
    }

    public function test_admin_client_cannot_change_business_status(): void
    {
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Protected Status Studio',
            'slug' => 'protected-status-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_ACTIVE,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->patch(route('developer.businesses.suspend', $business, false))
            ->assertForbidden();

        $this->assertSame(Business::STATUS_ACTIVE, $business->fresh()->status);
    }

    public function test_suspended_business_admin_client_access_is_blocked(): void
    {
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Blocked Workspace Studio',
            'slug' => 'blocked-workspace-studio',
            'owner_user_id' => $adminClient->id,
            'status' => Business::STATUS_SUSPENDED,
        ]);
        $adminClient->forceFill(['business_id' => $business->id])->save();

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false))
            ->assertRedirect(route('admin.login', absolute: false))
            ->assertSessionHasErrors('email');
    }

    public function test_developer_dashboard_counts_business_statuses_from_business_records(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);

        foreach ([Business::STATUS_ACTIVE, Business::STATUS_INACTIVE, Business::STATUS_SUSPENDED] as $index => $status) {
            $adminClient = User::factory()->create([
                'role' => User::ROLE_ADMIN_CLIENT,
                'approved_at' => now(),
                'invitation_accepted_at' => now(),
            ]);
            $business = Business::create([
                'name' => "Status Count Studio {$index}",
                'slug' => "status-count-studio-{$index}",
                'owner_user_id' => $adminClient->id,
                'status' => $status,
            ]);
            $adminClient->forceFill(['business_id' => $business->id])->save();
        }

        $dashboard = app(DeveloperDashboardMetricsService::class)->overview([
            'search' => null,
            'date_range' => 'this_month',
            'date_from' => null,
            'date_to' => null,
            'business_id' => null,
            'status' => null,
            'payment_method' => null,
        ]);

        $kpis = collect($dashboard['kpis'])->pluck('value', 'label');

        $this->assertSame(3, $kpis['Total Businesses']);
        $this->assertSame(1, $kpis['Active Businesses']);
        $this->assertSame(1, $kpis['Inactive Businesses']);
        $this->assertSame(1, $kpis['Suspended Businesses']);

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false))
            ->assertOk()
            ->assertSee('Suspended Businesses');
    }

    public function test_developer_can_view_invitation_page(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'name' => 'Pending Invite User',
            'email' => 'pending-invite@example.com',
            'preregistered_by' => $developer->id,
            'invite_token' => hash('sha256', 'pending-token'),
            'invite_expires_at' => now()->addDays(7),
        ]);

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.invitations.index', absolute: false))
            ->assertOk()
            ->assertSee('Admin-Client Invitations')
            ->assertSee('Pending Invite User')
            ->assertSee('pending-invite@example.com');
    }

    public function test_admin_client_cannot_view_invitation_page(): void
    {
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'email_verified_at' => now(),
            'approved_at' => now(),
            'invitation_accepted_at' => now(),
        ]);

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('developer.invitations.index', absolute: false))
            ->assertForbidden();
    }

    public function test_developer_can_send_resend_and_cancel_invitation_with_business_link_and_audit_logs(): void
    {
        Notification::fake();

        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        $business = Business::create([
            'name' => 'Invitation Linked Studio',
            'slug' => 'invitation-linked-studio',
            'status' => Business::STATUS_INACTIVE,
        ]);

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->post(route('developer.invitations.store', absolute: false), [
                'name' => 'Invited Admin Client',
                'email' => 'invited-admin@example.com',
                'business_id' => $business->id,
            ])
            ->assertRedirect(route('developer.invitations.index', absolute: false));

        $adminClient = User::where('email', 'invited-admin@example.com')->firstOrFail();
        $originalToken = $adminClient->invite_token;

        $this->assertSame($business->id, $adminClient->business_id);
        $this->assertSame($adminClient->id, $business->fresh()->owner_user_id);
        $this->assertNotNull($adminClient->invite_token);
        $this->assertDatabaseHas('audit_logs', [
            'target_user_id' => $adminClient->id,
            'business_id' => $business->id,
            'action' => 'admin_client_invitation_sent',
            'module' => 'invitation',
        ]);

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->patch(route('developer.invitations.resend', $adminClient, false))
            ->assertRedirect(route('developer.invitations.index', absolute: false));

        $adminClient->refresh();
        $this->assertNotSame($originalToken, $adminClient->invite_token);
        $this->assertDatabaseHas('audit_logs', [
            'target_user_id' => $adminClient->id,
            'business_id' => $business->id,
            'action' => 'admin_client_invitation_resent',
            'module' => 'invitation',
        ]);

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->patch(route('developer.invitations.cancel', $adminClient, false))
            ->assertRedirect(route('developer.invitations.index', absolute: false));

        $adminClient->refresh();
        $this->assertNull($adminClient->invite_token);
        $this->assertNull($adminClient->invite_expires_at);
        $this->assertNotNull($adminClient->invite_cancelled_at);
        $this->assertDatabaseHas('audit_logs', [
            'target_user_id' => $adminClient->id,
            'business_id' => $business->id,
            'action' => 'admin_client_invitation_cancelled',
            'module' => 'invitation',
        ]);
    }

    public function test_pending_invitations_dashboard_card_links_to_invitation_page(): void
    {
        $developer = User::factory()->create([
            'role' => User::ROLE_DEVELOPER,
            'email_verified_at' => now(),
        ]);
        User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'name' => 'Dashboard Pending Invite',
            'preregistered_by' => $developer->id,
            'invite_token' => hash('sha256', 'dashboard-pending-token'),
            'invite_expires_at' => now()->addDays(7),
        ]);

        $this
            ->actingAs($developer)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.dashboard', absolute: false))
            ->assertOk()
            ->assertSee('Pending Invitations')
            ->assertSee('href="'.route('developer.invitations.index', ['status' => 'pending']).'"', false);
    }

    public function test_admin_client_can_view_but_not_manage_service_catalog(): void
    {
        $developer = User::factory()->create(['role' => User::ROLE_DEVELOPER]);
        $adminClient = User::factory()->create([
            'role' => User::ROLE_ADMIN_CLIENT,
            'approved_at' => now(),
            'approved_by' => $developer->id,
            'invitation_accepted_at' => now(),
        ]);

        $adminClient->adminClientProfile()->create([
            'business_name' => 'Service Scope Studio',
            'contact_person' => 'Service Owner',
            'contact_number' => '09174444444',
            'business_address' => '200 Service Street',
            'profile_completed_at' => now(),
        ]);

        $service = Service::create([
            'name' => 'Restricted Service',
            'category' => 'Printing',
            'retail_price' => 10,
            'bulk_price' => 8,
            'unit' => 'page',
            'is_active' => true,
        ]);

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.services.index', absolute: false))
            ->assertOk()
            ->assertSee('Restricted Service')
            ->assertSee('View only');

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.services.edit', $service, false))
            ->assertForbidden();

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->get(route('admin.services.create', absolute: false))
            ->assertForbidden();

        $this
            ->actingAs($adminClient)
            ->withSession(['staff_otp_passed' => true])
            ->patch(route('admin.services.toggle', $service, false))
            ->assertForbidden();
    }

    public function test_guest_cannot_submit_admin_customer_crud_routes(): void
    {
        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
            'email' => 'protected-customer@example.com',
        ]);

        $this
            ->post(route('admin.customers.save', absolute: false), [
                'id' => $customer->id,
                'name' => 'Changed Name',
                'email' => 'changed@example.com',
                'role' => User::ROLE_CUSTOMER,
            ])
            ->assertRedirect(route('login', absolute: false));

        $this
            ->delete(route('admin.customers.delete', $customer, false))
            ->assertRedirect(route('login', absolute: false));

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'email' => 'protected-customer@example.com',
        ]);
    }
}
