<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Business;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class DeveloperDashboardMetricsService
{
    private const COMPLETED_STATUSES = ['Completed', 'completed', 'Done', 'done', 'Fulfilled', 'fulfilled'];
    private const CANCELLED_STATUSES = ['Cancelled', 'cancelled', 'Canceled', 'canceled'];
    private const PAID_STATUSES = ['Paid', 'paid', 'Completed', 'completed'];
    private const PENDING_PAYMENT_STATUSES = [
        'pending_payment',
        'Pending Payment',
        'pending',
        'Pending',
        'unpaid',
        'Unpaid',
        'waiting_for_payment',
    ];
    private const FAILED_PAYMENT_STATUSES = [
        'failed',
        'Failed',
        'discrepancy',
        'Discrepancy',
        'payment_failed',
        'Payment Failed',
        'refunded',
        'Refunded',
    ];
    private const ACTIVE_DELIVERY_STATUSES = [
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
    private const FAILED_DELIVERY_STATUSES = ['failed', 'cancelled', 'canceled', 'rejected', 'lalamove_booking_failed', 'BOOKING_FAILED'];

    public function overview(array $filters): array
    {
        $adminClients = $this->adminClientQuery($filters)
            ->with(['adminClientProfile', 'business'])
            ->withCount(['assignedCustomers', 'managedOrders'])
            ->latest('updated_at')
            ->get();
        $businesses = Business::query()->get();

        $orders = $this->orderQuery($filters)->with(['user', 'adminClient'])->latest();
        $payments = $this->paymentQuery($filters)->with(['order.adminClient', 'customer', 'business'])->latest();
        $deliveries = $this->deliveryQuery($filters)->with(['order.adminClient', 'customer', 'business'])->latest();
        $hasPaymentRows = $this->hasPaymentRows();
        $hasDeliveryRows = $this->hasDeliveryRows();
        $totalOrders = (clone $orders)->count();
        $completedOrders = $this->completedOrders(clone $orders)->count();
        $cancelledOrders = $this->cancelledOrders(clone $orders)->count();
        $totalSales = $hasPaymentRows ? (float) (clone $payments)->sum('amount') : (float) (clone $orders)->sum('total_price');
        $totalRevenue = $hasPaymentRows ? (float) $this->paidPayments(clone $payments)->sum('amount') : (float) $this->paidOrders(clone $orders)->sum('total_price');
        $pendingPayments = $hasPaymentRows ? $this->pendingPayments(clone $payments)->count() : $this->pendingPaymentOrders(clone $orders)->count();
        $failedPayments = $hasPaymentRows ? $this->failedPayments(clone $payments)->count() : $this->failedPaymentOrders(clone $orders)->count();
        $activeDeliveries = $hasDeliveryRows ? $this->activeDeliveries(clone $deliveries)->count() : $this->activeDeliveryOrders(clone $orders)->count();
        $failedDeliveries = $hasDeliveryRows ? $this->failedDeliveries(clone $deliveries)->count() : $this->failedDeliveryOrders(clone $orders)->count();

        $businessRows = $adminClients
            ->map(fn (User $adminClient) => $this->businessRow($adminClient, $filters))
            ->values();

        $statusCounts = (clone $orders)
            ->reorder()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $paymentMethodExpression = "COALESCE(payment_method, 'Unrecorded')";
        $paymentBreakdown = $hasPaymentRows
            ? (clone $payments)
                ->reorder()
                ->selectRaw("COALESCE(payment_method, 'Unrecorded') as method, COUNT(*) as total")
                ->groupByRaw("COALESCE(payment_method, 'Unrecorded')")
                ->pluck('total', 'method')
            : (clone $orders)
                ->reorder()
                ->selectRaw($paymentMethodExpression . ' as method, COUNT(*) as total')
                ->groupByRaw($paymentMethodExpression)
                ->pluck('total', 'method');

        $deliveryStatusExpression = "COALESCE(delivery_booking_status, COALESCE(lalamove_status, 'Not Booked'))";
        $deliveryBreakdown = $hasDeliveryRows
            ? (clone $deliveries)
                ->reorder()
                ->selectRaw("COALESCE(status, 'Not Booked') as status, COUNT(*) as total")
                ->groupByRaw("COALESCE(status, 'Not Booked')")
                ->pluck('total', 'status')
            : (clone $orders)
                ->reorder()
                ->selectRaw($deliveryStatusExpression . ' as status, COUNT(*) as total')
                ->groupByRaw($deliveryStatusExpression)
                ->pluck('total', 'status');

        $revenueTrend = $hasPaymentRows
            ? $this->paidPayments(clone $payments)
                ->reorder()
                ->selectRaw('DATE(created_at) as day, SUM(amount) as total')
                ->groupByRaw('DATE(created_at)')
                ->orderBy('day')
                ->pluck('total', 'day')
            : $this->paidOrders(clone $orders)
                ->reorder()
                ->selectRaw('DATE(created_at) as day, SUM(total_price) as total')
                ->groupByRaw('DATE(created_at)')
                ->orderBy('day')
                ->pluck('total', 'day');

        $cancellationTrend = $this->cancelledOrders(clone $orders)
            ->reorder()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('day')
            ->pluck('total', 'day');

        return [
            'filters' => $filters,
            'kpis' => [
                ['label' => 'Total Businesses', 'value' => $businesses->count() ?: $adminClients->count(), 'icon' => 'building-2', 'tone' => 'blue', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Active Businesses', 'value' => $businesses->where('status', Business::STATUS_ACTIVE)->count() ?: $adminClients->whereNotNull('approved_at')->count(), 'icon' => 'badge-check', 'tone' => 'green', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Inactive Businesses', 'value' => $businesses->where('status', Business::STATUS_INACTIVE)->count() ?: $adminClients->whereNull('invitation_accepted_at')->count(), 'icon' => 'clock-3', 'tone' => 'orange', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Suspended Businesses', 'value' => $businesses->where('status', Business::STATUS_SUSPENDED)->count() ?: $adminClients->whereNull('approved_at')->whereNotNull('invitation_accepted_at')->count(), 'icon' => 'ban', 'tone' => 'red', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Deleted Businesses', 'value' => Business::onlyTrashed()->count(), 'icon' => 'archive-x', 'tone' => 'slate', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Total Admin Clients', 'value' => $adminClients->count(), 'icon' => 'shield-check', 'tone' => 'blue', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Pending Invitations', 'value' => $adminClients->whereNull('invitation_accepted_at')->whereNotNull('invite_token')->count(), 'icon' => 'mail-clock', 'tone' => 'orange', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Total Customers', 'value' => User::where('role', User::ROLE_CUSTOMER)->count(), 'icon' => 'users-round', 'tone' => 'green', 'url' => route('developer.customers.index')],
                ['label' => 'Suspended Accounts', 'value' => $adminClients->whereNull('approved_at')->whereNotNull('invitation_accepted_at')->count(), 'icon' => 'user-x', 'tone' => 'red', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Total Orders', 'value' => $totalOrders, 'icon' => 'shopping-cart', 'tone' => 'blue', 'url' => route('developer.orders.index')],
                ['label' => 'Completed Orders', 'value' => $completedOrders, 'icon' => 'circle-check', 'tone' => 'green', 'url' => route('developer.orders.index')],
                ['label' => 'Cancelled Orders', 'value' => $cancelledOrders, 'icon' => 'circle-x', 'tone' => 'red', 'url' => route('developer.orders.index')],
                ['label' => 'Active Deliveries', 'value' => $activeDeliveries, 'icon' => 'truck', 'tone' => 'blue', 'url' => route('developer.orders.index')],
                ['label' => 'Total Sales', 'value' => 'PHP ' . number_format($totalSales, 2), 'icon' => 'receipt-text', 'tone' => 'blue', 'url' => route('developer.reports.index')],
                ['label' => 'Total Revenue', 'value' => 'PHP ' . number_format($totalRevenue, 2), 'icon' => 'circle-dollar-sign', 'tone' => 'green', 'url' => route('developer.reports.index')],
                ['label' => 'Pending Payments', 'value' => $pendingPayments, 'icon' => 'wallet-cards', 'tone' => 'orange', 'url' => route('developer.orders.index')],
                ['label' => 'Failed Payments', 'value' => $failedPayments, 'icon' => 'badge-alert', 'tone' => 'red', 'url' => route('developer.orders.index')],
            ],
            'businessRows' => $businessRows,
            'statusCounts' => $statusCounts,
            'paymentBreakdown' => $paymentBreakdown,
            'deliveryBreakdown' => $deliveryBreakdown,
            'revenueTrend' => $revenueTrend,
            'cancellationTrend' => $cancellationTrend,
            'recentPayments' => $hasPaymentRows
                ? $this->paymentIssues(clone $payments)->limit(5)->get()
                : $this->pendingPaymentOrders(clone $orders)->limit(5)->get(),
            'recentCancellations' => $this->cancelledOrders(clone $orders)->limit(5)->get(),
            'recentDeliveries' => $hasDeliveryRows
                ? $this->activeDeliveries(clone $deliveries)->limit(5)->get()
                : $this->activeDeliveryOrders(clone $orders)->limit(5)->get(),
            'recentAuditLogs' => AuditLog::with(['actor', 'targetUser', 'business'])->latest()->limit(5)->get(),
            'failedDeliveries' => $failedDeliveries,
        ];
    }

    public function exportRows(array $filters): array
    {
        return $this->overview($filters)['businessRows']
            ->map(fn (array $row) => [
                'Business Name' => $row['business_name'],
                'Admin Client' => $row['admin_client'],
                'Status' => $row['status'],
                'Customers' => $row['customers'],
                'Orders' => $row['orders'],
                'Completed' => $row['completed'],
                'Cancelled' => $row['cancelled'],
                'Sales' => number_format((float) $row['sales'], 2, '.', ''),
                'Revenue' => number_format((float) $row['revenue'], 2, '.', ''),
                'Payment Issues' => $row['payment_issues'],
                'Last Activity' => $row['last_activity'],
            ])
            ->all();
    }

    private function businessRow(User $adminClient, array $filters): array
    {
        $tenantOrders = $this->orderQuery([
            ...$filters,
            'business_id' => $adminClient->business_id ?: $adminClient->id,
            'search' => null,
        ]);

        $businessName = $adminClient->business?->name
            ?: $adminClient->adminClientProfile?->business_name
            ?: ($adminClient->company ?: $adminClient->name);

        $pendingIssues = $this->pendingPaymentOrders(clone $tenantOrders)->count();
        $failedIssues = $this->failedPaymentOrders(clone $tenantOrders)->count();
        $tenantPayments = $this->paymentQuery([
            ...$filters,
            'business_id' => $adminClient->business_id ?: $adminClient->id,
            'search' => null,
        ]);
        if ($this->hasPaymentRows()) {
            $pendingIssues = $this->pendingPayments(clone $tenantPayments)->count();
            $failedIssues = $this->failedPayments(clone $tenantPayments)->count();
        }

        $business = $adminClient->business;

        return [
            'id' => $adminClient->id,
            'business_id' => $business?->id,
            'business_name' => $businessName ?: 'Unregistered Business',
            'admin_client' => $adminClient->name ?: 'Admin Client',
            'status' => $business
                ? str($business->status)->headline()->toString()
                : ($adminClient->approved_at ? 'Active' : ($adminClient->invitation_accepted_at ? 'Suspended' : 'Inactive')),
            'customers' => $adminClient->assigned_customers_count,
            'orders' => (clone $tenantOrders)->count(),
            'completed' => $this->completedOrders(clone $tenantOrders)->count(),
            'cancelled' => $this->cancelledOrders(clone $tenantOrders)->count(),
            'sales' => $this->hasPaymentRows() ? (float) (clone $tenantPayments)->sum('amount') : (float) (clone $tenantOrders)->sum('total_price'),
            'revenue' => $this->hasPaymentRows() ? (float) $this->paidPayments(clone $tenantPayments)->sum('amount') : (float) $this->paidOrders(clone $tenantOrders)->sum('total_price'),
            'payment_issues' => $pendingIssues + $failedIssues,
            'last_activity' => optional($adminClient->updated_at)->diffForHumans() ?? 'No activity',
            'url' => $business
                ? route('developer.businesses.show', $business)
                : route('developer.admin-clients.show', $adminClient),
            'orders_url' => route('developer.orders.index', ['business_id' => $adminClient->id]),
            'customers_url' => route('developer.customers.index', ['business_id' => $adminClient->id]),
            'payments_url' => route('developer.orders.index', ['business_id' => $adminClient->id, 'payment' => 'issues']),
            'deliveries_url' => route('developer.orders.index', ['business_id' => $adminClient->id, 'delivery' => 'all']),
            'logs_url' => route('developer.reports.index', ['business_id' => $adminClient->id, 'type' => 'audit']),
            'business_activate_url' => $business ? route('developer.businesses.activate', $business) : null,
            'business_inactive_url' => $business ? route('developer.businesses.inactive', $business) : null,
            'business_suspend_url' => $business ? route('developer.businesses.suspend', $business) : null,
            'business_delete_url' => $business ? route('developer.businesses.destroy', $business) : null,
            'suspend_url' => route('developer.admin-clients.suspend', $adminClient),
            'activate_url' => route('developer.admin-clients.approve', $adminClient),
        ];
    }

    private function adminClientQuery(array $filters): Builder
    {
        return User::query()
            ->where('role', User::ROLE_ADMIN_CLIENT)
            ->when($filters['business_id'] ?? null, function (Builder $query, int $businessId) {
                $query->where(function (Builder $scope) use ($businessId) {
                    $scope->where('business_id', $businessId)
                        ->orWhereKey($businessId);
                });
            })
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $scope) use ($search) {
                    $scope->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhereHas('adminClientProfile', function (Builder $profile) use ($search) {
                            $profile->where('business_name', 'like', "%{$search}%")
                                ->orWhere('contact_person', 'like', "%{$search}%");
                        });
                });
            });
    }

    private function orderQuery(array $filters): Builder
    {
        return Order::query()
            ->when($filters['date_from'] ?? null, fn (Builder $query, $date) => $query->where('created_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn (Builder $query, $date) => $query->where('created_at', '<=', $date))
            ->when($filters['business_id'] ?? null, function (Builder $query, int $businessId) {
                $query->where(function (Builder $tenant) use ($businessId) {
                    $tenant->where('business_id', $businessId)
                        ->orWhere('admin_client_id', $businessId)
                        ->orWhereHas('user', fn (Builder $customer) => $customer->where('business_id', $businessId)->orWhere('admin_client_id', $businessId));
                });
            })
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['payment_method'] ?? null, fn (Builder $query, string $method) => $query->where('payment_method', $method))
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $nested) use ($search) {
                    $nested->where('order_reference', 'like', "%{$search}%")
                        ->orWhere('payment_reference', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%")
                        ->orWhereHas('user', fn (Builder $customer) => $customer->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                        ->orWhereHas('adminClient', fn (Builder $admin) => $admin->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
                });
            });
    }

    private function paymentQuery(array $filters): Builder
    {
        return Payment::query()
            ->when($filters['date_from'] ?? null, fn (Builder $query, $date) => $query->where('created_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn (Builder $query, $date) => $query->where('created_at', '<=', $date))
            ->when($filters['business_id'] ?? null, function (Builder $query, int $businessId) {
                $query->where(function (Builder $tenant) use ($businessId) {
                    $tenant->where('business_id', $businessId)
                        ->orWhereHas('order', function (Builder $order) use ($businessId) {
                            $order->where('business_id', $businessId)
                                ->orWhere('admin_client_id', $businessId)
                                ->orWhereHas('user', fn (Builder $customer) => $customer->where('business_id', $businessId)->orWhere('admin_client_id', $businessId));
                        });
                });
            })
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $this->normalizePaymentStatus($status)))
            ->when($filters['payment_method'] ?? null, fn (Builder $query, string $method) => $query->where('payment_method', $method))
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $nested) use ($search) {
                    $nested->where('gateway_reference', 'like', "%{$search}%")
                        ->orWhere('gateway_checkout_id', 'like', "%{$search}%")
                        ->orWhereHas('customer', fn (Builder $customer) => $customer->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                        ->orWhereHas('business', fn (Builder $business) => $business->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('order', function (Builder $order) use ($search) {
                            $order->where('order_reference', 'like', "%{$search}%")
                                ->orWhere('payment_reference', 'like', "%{$search}%")
                                ->orWhere('customer_name', 'like', "%{$search}%")
                                ->orWhere('customer_email', 'like', "%{$search}%")
                                ->orWhereHas('adminClient', fn (Builder $admin) => $admin->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
                        });
                });
            });
    }

    private function deliveryQuery(array $filters): Builder
    {
        return Delivery::query()
            ->when($filters['date_from'] ?? null, fn (Builder $query, $date) => $query->where('created_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn (Builder $query, $date) => $query->where('created_at', '<=', $date))
            ->when($filters['business_id'] ?? null, function (Builder $query, int $businessId) {
                $query->where(function (Builder $tenant) use ($businessId) {
                    $tenant->where('business_id', $businessId)
                        ->orWhereHas('order', function (Builder $order) use ($businessId) {
                            $order->where('business_id', $businessId)
                                ->orWhere('admin_client_id', $businessId)
                                ->orWhereHas('user', fn (Builder $customer) => $customer->where('business_id', $businessId)->orWhere('admin_client_id', $businessId));
                        });
                });
            })
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $nested) use ($search) {
                    $nested->where('tracking_reference', 'like', "%{$search}%")
                        ->orWhere('delivery_address', 'like', "%{$search}%")
                        ->orWhereHas('customer', fn (Builder $customer) => $customer->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                        ->orWhereHas('business', fn (Builder $business) => $business->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('order', function (Builder $order) use ($search) {
                            $order->where('order_reference', 'like', "%{$search}%")
                                ->orWhere('customer_name', 'like', "%{$search}%")
                                ->orWhere('customer_email', 'like', "%{$search}%")
                                ->orWhereHas('adminClient', fn (Builder $admin) => $admin->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
                        });
                });
            });
    }

    private function completedOrders(Builder $query): Builder
    {
        return $query->whereIn('status', self::COMPLETED_STATUSES);
    }

    private function cancelledOrders(Builder $query): Builder
    {
        return $query->whereIn('status', self::CANCELLED_STATUSES);
    }

    private function paidOrders(Builder $query): Builder
    {
        return $query->where(function (Builder $scope) {
            $scope->whereNotNull('paid_at')
                ->orWhereIn('status', self::PAID_STATUSES);
        });
    }

    private function paidPayments(Builder $query): Builder
    {
        return $query->where('status', Payment::STATUS_PAID);
    }

    private function pendingPayments(Builder $query): Builder
    {
        return $query->where('status', Payment::STATUS_PENDING);
    }

    private function failedPayments(Builder $query): Builder
    {
        return $query->whereIn('status', [
            Payment::STATUS_FAILED,
            Payment::STATUS_DISCREPANCY,
            Payment::STATUS_REFUNDED,
            Payment::STATUS_CANCELLED,
        ]);
    }

    private function paymentIssues(Builder $query): Builder
    {
        return $query->whereIn('status', [
            Payment::STATUS_PENDING,
            Payment::STATUS_FAILED,
            Payment::STATUS_DISCREPANCY,
            Payment::STATUS_REFUNDED,
            Payment::STATUS_CANCELLED,
        ]);
    }

    private function activeDeliveries(Builder $query): Builder
    {
        return $query->whereIn('status', self::ACTIVE_DELIVERY_STATUSES);
    }

    private function failedDeliveries(Builder $query): Builder
    {
        return $query->whereIn('status', self::FAILED_DELIVERY_STATUSES);
    }

    private function hasPaymentRows(): bool
    {
        return Schema::hasTable('payments') && Payment::query()->exists();
    }

    private function hasDeliveryRows(): bool
    {
        return Schema::hasTable('deliveries') && Delivery::query()->exists();
    }

    private function normalizePaymentStatus(string $status): string
    {
        $status = strtolower($status);

        return match ($status) {
            'paid', 'completed' => Payment::STATUS_PAID,
            'failed', 'payment_failed' => Payment::STATUS_FAILED,
            'refunded' => Payment::STATUS_REFUNDED,
            'discrepancy' => Payment::STATUS_DISCREPANCY,
            'cancelled', 'canceled' => Payment::STATUS_CANCELLED,
            default => $status,
        };
    }

    private function pendingPaymentOrders(Builder $query): Builder
    {
        return $query->where(function (Builder $scope) {
            $scope->whereNull('paid_at')
                ->orWhereIn('status', self::PENDING_PAYMENT_STATUSES);
        })->whereNotIn('status', array_merge(self::PAID_STATUSES, self::FAILED_PAYMENT_STATUSES));
    }

    private function failedPaymentOrders(Builder $query): Builder
    {
        return $query->whereIn('status', self::FAILED_PAYMENT_STATUSES);
    }

    private function activeDeliveryOrders(Builder $query): Builder
    {
        return $query->where(function (Builder $scope) {
            $scope->whereIn('delivery_booking_status', self::ACTIVE_DELIVERY_STATUSES)
                ->orWhereIn('lalamove_status', self::ACTIVE_DELIVERY_STATUSES);
        });
    }

    private function failedDeliveryOrders(Builder $query): Builder
    {
        return $query->where(function (Builder $scope) {
            $scope->whereIn('delivery_booking_status', self::FAILED_DELIVERY_STATUSES)
                ->orWhereIn('lalamove_status', self::FAILED_DELIVERY_STATUSES);
        });
    }
}
