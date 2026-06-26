<?php

namespace Database\Seeders;

use App\Models\AdminClientProfile;
use App\Models\AuditLog;
use App\Models\Business;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoReadinessSeeder extends Seeder
{
    public function run(): void
    {
        $developer = User::updateOrCreate(
            ['email' => 'brielavery12@gmail.com'],
            [
                'name' => 'Briel Avery',
                'first_name' => 'Briel',
                'last_name' => 'Avery',
                'role' => User::ROLE_DEVELOPER,
                'email_verified_at' => now(),
                'password' => Hash::make(env('DEMO_DEVELOPER_PASSWORD', 'Developer@2026')),
                'approved_at' => now(),
                'approved_by' => null,
                'invitation_accepted_at' => now(),
                'invite_token' => null,
                'invite_expires_at' => null,
                'invite_cancelled_at' => null,
                'has_set_password' => true,
            ]
        );

        $activeAdmin = $this->adminClient(
            developer: $developer,
            email: 'demo.admin.active@printify.test',
            name: 'Maria Santos',
            businessName: 'Santos Print Studio',
            status: Business::STATUS_ACTIVE,
            approved: true
        );

        $suspendedAdmin = $this->adminClient(
            developer: $developer,
            email: 'demo.admin.suspended@printify.test',
            name: 'Juan Dela Cruz',
            businessName: 'Dela Cruz Digital Prints',
            status: Business::STATUS_SUSPENDED,
            approved: false
        );

        $inactiveAdmin = $this->adminClient(
            developer: $developer,
            email: 'demo.admin.pending@printify.test',
            name: 'Ana Reyes',
            businessName: 'Reyes Copy Center',
            status: Business::STATUS_INACTIVE,
            approved: false,
            pendingInvite: true
        );

        $this->demoOperations($developer, $activeAdmin, 'Santos');
        $this->demoOperations($developer, $suspendedAdmin, 'Dela Cruz', includeCancelled: true);

        AuditLog::updateOrCreate(
            [
                'actor_id' => $developer->id,
                'target_user_id' => $inactiveAdmin->id,
                'action' => 'admin_client_invitation_sent',
            ],
            [
                'business_id' => $inactiveAdmin->business_id,
                'auditable_type' => User::class,
                'auditable_id' => $inactiveAdmin->id,
                'module' => 'invitation',
                'new_values' => ['status' => 'pending'],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Demo Seeder',
            ]
        );
    }

    private function adminClient(
        User $developer,
        string $email,
        string $name,
        string $businessName,
        string $status,
        bool $approved,
        bool $pendingInvite = false
    ): User {
        $business = Business::withTrashed()->updateOrCreate(
            ['slug' => Str::slug($businessName)],
            [
                'name' => $businessName,
                'status' => $status,
                'email' => $email,
                'contact_number' => '+639451751414',
                'address' => 'Makati City, Metro Manila, Philippines',
                'deleted_at' => null,
            ]
        );

        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'first_name' => Str::before($name, ' '),
                'last_name' => Str::after($name, ' '),
                'role' => User::ROLE_ADMIN_CLIENT,
                'business_id' => $business->id,
                'company' => $businessName,
                'phone' => '+639451751414',
                'email_verified_at' => now(),
                'password' => Hash::make(env('DEMO_ADMIN_CLIENT_PASSWORD', 'AdminClient@2026')),
                'preregistered_by' => $developer->id,
                'approved_at' => $approved ? now() : null,
                'approved_by' => $approved ? $developer->id : null,
                'invitation_accepted_at' => $pendingInvite ? null : now(),
                'invite_token' => $pendingInvite ? hash('sha256', $email . now()->toDateString()) : null,
                'invite_expires_at' => $pendingInvite ? now()->addDays(7) : null,
                'invite_cancelled_at' => null,
                'has_set_password' => true,
            ]
        );

        $business->forceFill(['owner_user_id' => $admin->id])->save();

        AdminClientProfile::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'business_name' => $businessName,
                'contact_person' => $name,
                'contact_number' => '+639451751414',
                'business_address' => 'Makati City, Metro Manila, Philippines',
                'reference_notes' => 'Demo business profile for Capstone walkthrough.',
                'profile_completed_at' => $approved ? now() : null,
            ]
        );

        return $admin->fresh();
    }

    private function demoOperations(User $developer, User $admin, string $prefix, bool $includeCancelled = false): void
    {
        $customer = User::updateOrCreate(
            ['email' => strtolower(str_replace(' ', '.', $prefix)) . '.customer@printify.test'],
            [
                'name' => "{$prefix} Customer",
                'role' => User::ROLE_CUSTOMER,
                'business_id' => $admin->business_id,
                'admin_client_id' => $admin->id,
                'email_verified_at' => now(),
                'password' => Hash::make(env('DEMO_CUSTOMER_PASSWORD', 'Customer@2026')),
                'phone' => '+639000000001',
                'street' => 'Demo Street Address',
                'barangay' => 'Poblacion',
                'city' => 'Makati City',
                'region' => 'National Capital Region',
                'province' => 'Metro Manila',
                'postal_code' => '1200',
            ]
        );

        $order = Order::updateOrCreate(
            ['order_reference' => 'PFY-DEMO-' . Str::upper(Str::slug($prefix, '-')) . '-001'],
            [
                'user_id' => $customer->id,
                'business_id' => $admin->business_id,
                'admin_client_id' => $admin->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone,
                'status' => 'Completed',
                'total_price' => 1450,
                'payment_method' => 'gcash',
                'payment_provider' => 'paymongo',
                'payment_reference' => 'pay-demo-' . Str::slug($prefix),
                'paid_at' => now()->subDays(2),
                'delivery_method' => 'lalamove',
                'delivery_fee' => 150,
                'delivery_address' => 'Demo Street Address, Makati City',
                'delivery_booking_status' => 'delivered',
                'delivery_tracking_number' => 'LMV-DEMO-' . Str::upper(Str::slug($prefix, '')),
                'delivery_tracking_url' => 'https://track.example.test/demo',
                'delivery_booked_at' => now()->subDays(2),
            ]
        );

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'business_id' => $admin->business_id,
                'customer_id' => $customer->id,
                'payment_method' => 'gcash',
                'payment_gateway' => 'paymongo',
                'gateway_reference' => 'pay-demo-' . Str::slug($prefix),
                'amount' => 1450,
                'status' => Payment::STATUS_PAID,
                'verified_by' => $admin->id,
                'paid_at' => now()->subDays(2),
                'remarks' => 'Demo paid transaction.',
            ]
        );

        Delivery::updateOrCreate(
            ['order_id' => $order->id],
            [
                'business_id' => $admin->business_id,
                'customer_id' => $customer->id,
                'courier' => 'lalamove',
                'delivery_method' => 'lalamove',
                'tracking_reference' => 'LMV-DEMO-' . Str::upper(Str::slug($prefix, '')),
                'tracking_url' => 'https://track.example.test/demo',
                'delivery_address' => 'Demo Street Address, Makati City',
                'delivery_fee' => 150,
                'status' => Delivery::STATUS_DELIVERED,
                'booked_at' => now()->subDays(2),
                'delivered_at' => now()->subDay(),
                'remarks' => 'Demo delivered shipment.',
            ]
        );

        if ($includeCancelled) {
            Order::updateOrCreate(
                ['order_reference' => 'PFY-DEMO-' . Str::upper(Str::slug($prefix, '-')) . '-CANCELLED'],
                [
                    'user_id' => $customer->id,
                    'business_id' => $admin->business_id,
                    'admin_client_id' => $admin->id,
                    'customer_name' => $customer->name,
                    'customer_email' => $customer->email,
                    'status' => 'Cancelled',
                    'total_price' => 500,
                    'payment_method' => 'cash',
                ]
            );
        }

        Service::query()
            ->whereNull('business_id')
            ->orWhere('business_id', $admin->business_id)
            ->limit(3)
            ->get()
            ->each(fn (Service $service) => $service->forceFill(['business_id' => $admin->business_id])->save());

        AuditLog::updateOrCreate(
            [
                'actor_id' => $admin->id,
                'target_user_id' => $customer->id,
                'action' => 'demo_order_completed',
            ],
            [
                'business_id' => $admin->business_id,
                'auditable_type' => Order::class,
                'auditable_id' => $order->id,
                'module' => 'orders',
                'new_values' => ['status' => 'Completed'],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Demo Seeder',
            ]
        );
    }
}
