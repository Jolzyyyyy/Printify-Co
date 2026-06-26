<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Business;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class DeveloperBusinessController extends Controller
{
    private const COMPLETED_STATUSES = ['Completed', 'completed', 'Done', 'done', 'Fulfilled', 'fulfilled'];
    private const CANCELLED_STATUSES = ['Cancelled', 'cancelled', 'Canceled', 'canceled'];
    private const ACTIVE_DELIVERY_STATUSES = [
        'pending',
        'pending_manual_booking',
        'waiting_for_payment',
        'processing',
        'accepted',
        'on_going',
        'ongoing',
        'picked_up',
        'out_for_delivery',
        'pending_lalamove_configuration',
        'pending_lalamove_coordinates',
        'booked_lalamove',
        'PENDING_CONFIGURATION',
        'PENDING_COORDINATES',
        'PENDING_PAYMENT',
    ];

    public function show(Business $business): View
    {
        $business->load(['owner.adminClientProfile']);
        $owner = $business->owner;
        $fallbackAdminClientId = $owner?->id;

        $customers = $this->customersForBusiness($business, $fallbackAdminClientId)->latest()->limit(12)->get();
        $orders = $this->ordersForBusiness($business, $fallbackAdminClientId)->with(['user', 'payments', 'deliveries'])->latest();
        $payments = $this->paymentsForBusiness($business, $fallbackAdminClientId)->with(['order', 'customer'])->latest();
        $deliveries = $this->deliveriesForBusiness($business, $fallbackAdminClientId)->with(['order', 'customer'])->latest();
        $services = $this->servicesForBusiness($business)->withCount('activeVariations')->orderBy('category')->orderBy('name')->limit(12)->get();
        $auditLogs = $this->auditLogsForBusiness($business, $fallbackAdminClientId)->with(['actor', 'targetUser'])->latest()->limit(12)->get();

        $hasPaymentRows = (clone $payments)->exists();
        $hasDeliveryRows = (clone $deliveries)->exists();

        $kpis = [
            ['label' => 'Total Customers', 'value' => $this->customersForBusiness($business, $fallbackAdminClientId)->count(), 'tone' => 'green'],
            ['label' => 'Total Orders', 'value' => (clone $orders)->count(), 'tone' => 'blue'],
            ['label' => 'Completed Orders', 'value' => (clone $orders)->whereIn('status', self::COMPLETED_STATUSES)->count(), 'tone' => 'green'],
            ['label' => 'Cancelled Orders', 'value' => (clone $orders)->whereIn('status', self::CANCELLED_STATUSES)->count(), 'tone' => 'red'],
            ['label' => 'Total Sales', 'value' => 'PHP ' . number_format($hasPaymentRows ? (float) (clone $payments)->sum('amount') : (float) (clone $orders)->sum('total_price'), 2), 'tone' => 'blue'],
            ['label' => 'Total Revenue', 'value' => 'PHP ' . number_format($hasPaymentRows ? (float) (clone $payments)->where('status', Payment::STATUS_PAID)->sum('amount') : (float) (clone $orders)->whereNotNull('paid_at')->sum('total_price'), 2), 'tone' => 'green'],
            ['label' => 'Pending Payments', 'value' => $hasPaymentRows ? (clone $payments)->where('status', Payment::STATUS_PENDING)->count() : (clone $orders)->whereNull('paid_at')->count(), 'tone' => 'orange'],
            ['label' => 'Failed Payments', 'value' => $hasPaymentRows ? (clone $payments)->whereIn('status', [Payment::STATUS_FAILED, Payment::STATUS_DISCREPANCY, Payment::STATUS_REFUNDED, Payment::STATUS_CANCELLED])->count() : (clone $orders)->whereIn('status', ['failed', 'Failed', 'payment_failed', 'Payment Failed', 'discrepancy', 'Discrepancy'])->count(), 'tone' => 'red'],
            ['label' => 'Active Deliveries', 'value' => $hasDeliveryRows ? (clone $deliveries)->whereIn('status', self::ACTIVE_DELIVERY_STATUSES)->count() : (clone $orders)->where(function (Builder $query) {
                $query->whereIn('delivery_booking_status', self::ACTIVE_DELIVERY_STATUSES)
                    ->orWhereIn('lalamove_status', self::ACTIVE_DELIVERY_STATUSES);
            })->count(), 'tone' => 'blue'],
            ['label' => 'Services', 'value' => $this->servicesForBusiness($business)->count(), 'tone' => 'slate'],
        ];

        $lastActivity = collect([
            (clone $orders)->max('updated_at'),
            (clone $payments)->max('updated_at'),
            (clone $deliveries)->max('updated_at'),
            $business->updated_at,
            $owner?->updated_at,
        ])->filter()->max();

        return view('Admin.businesses.show', [
            'business' => $business,
            'owner' => $owner,
            'kpis' => $kpis,
            'customers' => $customers,
            'orders' => (clone $orders)->limit(12)->get(),
            'payments' => (clone $payments)->limit(12)->get(),
            'deliveries' => (clone $deliveries)->limit(12)->get(),
            'services' => $services,
            'auditLogs' => $auditLogs,
            'lastActivity' => $lastActivity,
        ]);
    }

    private function customersForBusiness(Business $business, ?int $fallbackAdminClientId): Builder
    {
        return User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->where(function (Builder $query) use ($business, $fallbackAdminClientId) {
                $query->where('business_id', $business->id)
                    ->when($fallbackAdminClientId, fn (Builder $scope) => $scope->orWhere('admin_client_id', $fallbackAdminClientId));
            });
    }

    private function ordersForBusiness(Business $business, ?int $fallbackAdminClientId): Builder
    {
        return Order::query()
            ->where(function (Builder $query) use ($business, $fallbackAdminClientId) {
                $query->where('business_id', $business->id)
                    ->when($fallbackAdminClientId, fn (Builder $scope) => $scope->orWhere('admin_client_id', $fallbackAdminClientId))
                    ->orWhereHas('user', function (Builder $customer) use ($business, $fallbackAdminClientId) {
                        $customer->where('business_id', $business->id)
                            ->when($fallbackAdminClientId, fn (Builder $scope) => $scope->orWhere('admin_client_id', $fallbackAdminClientId));
                    });
            });
    }

    private function paymentsForBusiness(Business $business, ?int $fallbackAdminClientId): Builder
    {
        return Payment::query()
            ->where(function (Builder $query) use ($business, $fallbackAdminClientId) {
                $query->where('business_id', $business->id)
                    ->orWhereHas('order', fn (Builder $order) => $this->ordersForBusinessScope($order, $business, $fallbackAdminClientId));
            });
    }

    private function deliveriesForBusiness(Business $business, ?int $fallbackAdminClientId): Builder
    {
        return Delivery::query()
            ->where(function (Builder $query) use ($business, $fallbackAdminClientId) {
                $query->where('business_id', $business->id)
                    ->orWhereHas('order', fn (Builder $order) => $this->ordersForBusinessScope($order, $business, $fallbackAdminClientId));
            });
    }

    private function servicesForBusiness(Business $business): Builder
    {
        return Service::query()->where('business_id', $business->id);
    }

    private function auditLogsForBusiness(Business $business, ?int $fallbackAdminClientId): Builder
    {
        return AuditLog::query()
            ->where(function (Builder $query) use ($business, $fallbackAdminClientId) {
                $query->where('business_id', $business->id)
                    ->when($fallbackAdminClientId, function (Builder $scope) use ($fallbackAdminClientId) {
                        $scope->orWhere('actor_id', $fallbackAdminClientId)
                            ->orWhere('target_user_id', $fallbackAdminClientId);
                    });
            });
    }

    private function ordersForBusinessScope(Builder $query, Business $business, ?int $fallbackAdminClientId): Builder
    {
        return $query->where(function (Builder $scope) use ($business, $fallbackAdminClientId) {
            $scope->where('business_id', $business->id)
                ->when($fallbackAdminClientId, fn (Builder $tenant) => $tenant->orWhere('admin_client_id', $fallbackAdminClientId))
                ->orWhereHas('user', function (Builder $customer) use ($business, $fallbackAdminClientId) {
                    $customer->where('business_id', $business->id)
                        ->when($fallbackAdminClientId, fn (Builder $tenant) => $tenant->orWhere('admin_client_id', $fallbackAdminClientId));
                });
        });
    }
}
