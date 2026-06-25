<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Services\DeveloperDashboardMetricsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request, DeveloperDashboardMetricsService $developerMetrics): View
    {
        $user = $request->user();
        $isDeveloper = $user->isDeveloper();
        $isAdminClient = $user->isAdminClient();

        $orderQuery = Order::query()->visibleToPortalUser($user);
        $customerQuery = User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->when($isAdminClient, fn (Builder $query) => $query->where('admin_client_id', $user->id));

        $statusCounts = (clone $orderQuery)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $pipeline = collect([
            ['status' => 'Pending', 'label' => 'New Orders', 'note' => 'Needs staff review'],
            ['status' => 'For Verification', 'label' => 'For Verification', 'note' => 'Files or payment to check'],
            ['status' => 'Processing', 'label' => 'In Production', 'note' => 'Printing or preparation'],
            ['status' => 'Ready', 'label' => 'Ready / Delivery', 'note' => 'Ready for pickup or release'],
            ['status' => 'Completed', 'label' => 'Completed', 'note' => 'Finished requests'],
            ['status' => 'Cancelled', 'label' => 'Cancelled', 'note' => 'Stopped requests'],
        ])->map(fn (array $item) => [
            ...$item,
            'count' => (int) ($statusCounts[$item['status']] ?? 0),
        ]);

        $stats = [
            'orders' => (clone $orderQuery)->count(),
            'orders_this_month' => (clone $orderQuery)->where('created_at', '>=', now()->startOfMonth())->count(),
            'active_orders' => (clone $orderQuery)->whereIn('status', ['Pending', 'For Verification', 'Processing', 'Ready'])->count(),
            'completed_orders' => (clone $orderQuery)->where('status', 'Completed')->count(),
            'sales_total' => (float) (clone $orderQuery)->sum('total_price'),
            'sales_this_month' => (float) (clone $orderQuery)->where('created_at', '>=', now()->startOfMonth())->sum('total_price'),
            'customers' => (clone $customerQuery)->count(),
            'services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'inactive_services' => Service::where('is_active', false)->count(),
            'pending_admin_clients' => $isDeveloper
                ? $this->developerManagedAdminQuery()->whereNull('approved_at')->count()
                : 0,
            'approved_admin_clients' => $isDeveloper
                ? User::where('role', User::ROLE_ADMIN_CLIENT)->whereNotNull('approved_at')->count()
                : 0,
            'unassigned_orders' => $isDeveloper
                ? Order::whereNull('admin_client_id')->count()
                : 0,
            'unassigned_customers' => $isDeveloper
                ? User::where('role', User::ROLE_CUSTOMER)->whereNull('admin_client_id')->count()
                : 0,
        ];

        $recentOrders = (clone $orderQuery)
            ->with(['user', 'adminClient'])
            ->latest()
            ->limit(6)
            ->get();

        $recentCustomers = (clone $customerQuery)
            ->with('assignedAdminClient')
            ->latest()
            ->limit(5)
            ->get();

        $auditQuery = AuditLog::query()
            ->with(['actor', 'targetUser'])
            ->when(!$isDeveloper, function (Builder $query) use ($user) {
                $query->where(function (Builder $scope) use ($user) {
                    $scope->where('actor_id', $user->id)
                        ->orWhere('target_user_id', $user->id);
                });
            });

        $recentAuditLogs = $auditQuery
            ->latest()
            ->limit($isDeveloper ? 8 : 5)
            ->get();

        $recentAdminClients = collect();

        if ($isDeveloper) {
            $recentAdminClients = $this->developerManagedAdminQuery()
                ->with('adminClientProfile')
                ->withCount(['assignedCustomers', 'managedOrders'])
                ->latest('updated_at')
                ->limit(5)
                ->get();
        }

        $developerCommandCenter = $isDeveloper
            ? $developerMetrics->overview($this->developerDashboardFilters($request))
            : null;
        $staffDashboard = $this->staffDashboardViewData($user, $isDeveloper, $isAdminClient, $recentAuditLogs);

        return view('Admin.dashboard', [
            'section' => $isDeveloper
                ? 'developer-dashboard'
                : ($isAdminClient ? 'admin-client-dashboard' : 'dashboard'),
            ...$staffDashboard,
            'stats' => $stats,
            'pipeline' => $pipeline,
            'recentOrders' => $recentOrders,
            'recentCustomers' => $recentCustomers,
            'recentAuditLogs' => $recentAuditLogs,
            'recentAdminClients' => $recentAdminClients,
            'developerCommandCenter' => $developerCommandCenter,
            'profile' => $isAdminClient ? $user->adminClientProfile : null,
        ]);
    }

    private function staffDashboardViewData(User $user, bool $isDeveloper, bool $isAdminClient, $recentAuditLogs): array
    {
        $headerNotifications = $recentAuditLogs->map(fn ($log) => [
            'title' => \Illuminate\Support\Str::headline($log->event ?? $log->action ?? 'System update'),
            'body' => trim(($log->actor?->name ?? 'System') . ($log->targetUser ? ' updated ' . $log->targetUser->name : ' activity recorded')),
            'time' => optional($log->created_at)->diffForHumans() ?? 'Just now',
        ])->values();

        if ($headerNotifications->isEmpty()) {
            $headerNotifications = collect([
                ['title' => 'Dashboard ready', 'body' => 'Admin workspace is ready for today.', 'time' => 'Now'],
                ['title' => 'System status', 'body' => 'No critical alerts detected.', 'time' => 'Now'],
            ]);
        }

        $dashboardOrders = Order::query()->visibleToPortalUser($user);
        $dashboardActiveUsers = User::query()
            ->whereNotNull('email_verified_at')
            ->when($isDeveloper, fn (Builder $query) => $query
                ->where('role', User::ROLE_ADMIN_CLIENT)
                ->whereNotNull('approved_at'))
            ->when($isAdminClient, fn (Builder $query) => $query
                ->where('role', User::ROLE_CUSTOMER)
                ->where('admin_client_id', $user->id))
            ->when(!$isDeveloper && !$isAdminClient, fn (Builder $query) => $query
                ->where('role', User::ROLE_CUSTOMER));
        $dashboardServices = Service::query()->where('is_active', true);
        $dashboardServiceAlerts = Service::query()
            ->where('is_active', true)
            ->withCount('activeVariations')
            ->orderBy('category')
            ->orderBy('name')
            ->limit(3)
            ->get()
            ->map(function (Service $service) {
                $category = strtolower((string) ($service->category ?? ''));
                $icon = str_contains($category, 'photo') || str_contains($category, 'id')
                    ? 'image'
                    : (str_contains($category, 'lamination') || str_contains($category, 'binding')
                        ? 'book-open'
                        : (str_contains($category, 'large') || str_contains($category, 'custom')
                            ? 'package'
                            : (str_contains($category, 'copy') || str_contains($category, 'scan')
                                ? 'copy'
                                : 'printer')));
                $variationCount = (int) $service->active_variations_count;

                return [
                    'name' => $service->name,
                    'category' => $service->category ?: 'General Service',
                    'icon' => $icon,
                    'options' => $variationCount,
                    'status' => $variationCount > 0 ? 'Live' : 'Needs setup',
                    'status_class' => $variationCount > 0 ? 'completed' : 'low',
                    'message' => $variationCount > 0
                        ? "{$variationCount} live service option" . ($variationCount === 1 ? '' : 's') . ' synced from the customer catalog.'
                        : 'No active options yet. Open the catalog to finish setup.',
                ];
            })
            ->values();

        $dashboardStats = [
            'revenue' => (float) (clone $dashboardOrders)->sum('total_price'),
            'orders' => (clone $dashboardOrders)->count(),
            'customers' => (clone $dashboardActiveUsers)->count(),
            'services' => (clone $dashboardServices)->count(),
            'pending' => (clone $dashboardOrders)->whereIn('status', ['Pending', 'For Verification'])->count(),
            'ready' => (clone $dashboardOrders)->whereIn('status', ['Ready', 'Ready / Delivery'])->count(),
            'completed' => (clone $dashboardOrders)->where('status', 'Completed')->count(),
            'cancelled' => (clone $dashboardOrders)->where('status', 'Cancelled')->count(),
        ];

        $portalRoleLabel = $isDeveloper ? 'Developer' : ($isAdminClient ? 'Admin Client' : 'Admin');

        return [
            'portalUser' => $user,
            'headerAuditLogs' => $recentAuditLogs,
            'headerNotifications' => $headerNotifications,
            'dashboardServiceAlerts' => $dashboardServiceAlerts,
            'dashboardStats' => $dashboardStats,
            'dashboardServiceAlertCount' => $dashboardServiceAlerts->count(),
            'dashboardActiveUsersLabel' => $isDeveloper ? 'Active Admin Clients' : ($isAdminClient ? 'Active Customers' : 'Active Users'),
            'dashboardActiveUsersRoute' => $isDeveloper ? route('developer.admin-clients.index') : route('admin.customers'),
            'dashboardRecentOrders' => (clone $dashboardOrders)->with('user')->latest()->limit(5)->get(),
            'portalRoleLabel' => $portalRoleLabel,
            'portalRoleUpper' => strtoupper($portalRoleLabel),
            'portalTitle' => $isDeveloper ? 'Developer Dashboard' : 'ADMIN DASHBOARD',
            'portalKicker' => $isDeveloper ? 'Developer Management Portal' : 'Admin Management Portal',
            'portalTagline' => $isDeveloper
                ? 'Manage admin clients, services, analytics, and platform controls from one developer workspace.'
                : ($isAdminClient
                    ? 'Manage assigned customers, orders, reports, and reference profile activity from one admin-client workspace.'
                    : 'Manage customers, orders, products, reports, and system activity from one admin workspace.'),
            'portalDisplayName' => $user->name ?? $portalRoleLabel,
            'portalInitial' => strtoupper(substr($user->name ?? $portalRoleLabel, 0, 1)),
            'headerSearchItems' => $this->headerSearchItems($isDeveloper),
        ];
    }

    private function headerSearchItems(bool $isDeveloper): array
    {
        if ($isDeveloper) {
            return [
                ['title' => 'Dashboard', 'meta' => 'Developer overview and platform activity', 'url' => route('admin.dashboard')],
                ['title' => 'Manage Admin Clients', 'meta' => 'Approve, assign, and review admin clients', 'url' => route('developer.admin-clients.index')],
                ['title' => 'Orders', 'meta' => 'Developer order monitoring', 'url' => route('developer.orders.index')],
                ['title' => 'Services', 'meta' => 'Manage service catalog and availability', 'url' => route('developer.services.index')],
                ['title' => 'Customers', 'meta' => 'Review customer records and activity', 'url' => route('developer.customers.index')],
                ['title' => 'Analytics', 'meta' => 'Developer analytics and platform insights', 'url' => route('developer.analytics.index')],
                ['title' => 'Reports', 'meta' => 'Operational and performance reports', 'url' => route('developer.reports.index')],
                ['title' => 'Settings', 'meta' => 'Developer preferences and system controls', 'url' => route('developer.settings.index')],
            ];
        }

        return [
            ['title' => 'Dashboard', 'meta' => 'Overview and recent transactions', 'url' => route('admin.dashboard')],
            ['title' => 'Customer/User', 'meta' => 'Manage registered users', 'url' => route('admin.customers')],
            ['title' => 'Orders', 'meta' => 'Order management and status tracking', 'url' => route('admin.orders')],
            ['title' => 'Products', 'meta' => 'Product inventory and services', 'url' => route('admin.products')],
            ['title' => 'Reports', 'meta' => 'Sales reports and export tools', 'url' => route('admin.reports')],
            ['title' => 'Analytics', 'meta' => 'Traffic and performance charts', 'url' => route('admin.analytics')],
            ['title' => 'Settings', 'meta' => 'Preferences and system controls', 'url' => route('admin.settings')],
        ];
    }

    public function export(Request $request, DeveloperDashboardMetricsService $developerMetrics): Response
    {
        $filters = $this->developerDashboardFilters($request);
        $dashboard = $developerMetrics->overview($filters);
        $rows = $developerMetrics->exportRows($filters);
        $format = in_array($request->query('format'), ['csv', 'pdf', 'xls'], true)
            ? $request->query('format')
            : 'csv';
        $baseName = 'developer-dashboard-report-' . now()->format('Y-m-d-His');
        $headers = [
            'Business Name',
            'Admin Client',
            'Status',
            'Customers',
            'Orders',
            'Completed',
            'Cancelled',
            'Sales',
            'Revenue',
            'Payment Issues',
            'Last Activity',
        ];

        if ($format === 'pdf' && class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.developer-dashboard-report', [
                'dashboard' => $dashboard,
                'headers' => $headers,
                'rows' => $rows,
                'generatedAt' => now(),
            ])->download($baseName . '.pdf');
        }

        if ($format === 'xls') {
            return response()->streamDownload(function () use ($dashboard, $headers, $rows) {
                echo view('pdf.developer-dashboard-report', [
                    'dashboard' => $dashboard,
                    'headers' => $headers,
                    'rows' => $rows,
                    'generatedAt' => now(),
                ])->render();
            }, $baseName . '.xls', [
                'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            ]);
        }

        return response()->streamDownload(function () use ($headers, $rows) {
            $output = fopen('php://output', 'w');

            fputcsv($output, $headers);

            foreach ($rows as $row) {
                fputcsv($output, array_map(fn (string $header) => $row[$header] ?? '', $headers));
            }

            fclose($output);
        }, $baseName . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function developerManagedAdminQuery(): Builder
    {
        return User::query()
            ->where('role', User::ROLE_ADMIN_CLIENT);
    }

    private function developerCommandCenter(Request $request): array
    {
        $filters = $this->developerDashboardFilters($request);
        $adminClients = User::query()
            ->where('role', User::ROLE_ADMIN_CLIENT)
            ->with('adminClientProfile')
            ->withCount(['assignedCustomers', 'managedOrders'])
            ->when($filters['search'], function (Builder $query, string $search) {
                $query->where(function (Builder $scope) use ($search) {
                    $scope->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhereHas('adminClientProfile', function (Builder $profile) use ($search) {
                            $profile->where('business_name', 'like', "%{$search}%")
                                ->orWhere('contact_person', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('updated_at')
            ->get();

        $orders = $this->applyDeveloperOrderFilters(
            Order::query()->with(['user', 'adminClient']),
            $filters
        )->latest();
        $totalOrders = (clone $orders)->count();
        $completedOrders = (clone $orders)->where('status', 'Completed')->count();
        $cancelledOrders = (clone $orders)->where('status', 'Cancelled')->count();
        $paidOrders = (clone $orders)->whereNotNull('paid_at')->count();
        $pendingPayments = (clone $orders)->whereNull('paid_at')->count();
        $activeDeliveries = (clone $orders)
            ->whereNotNull('delivery_booking_status')
            ->whereNotIn('delivery_booking_status', ['delivered', 'failed', 'cancelled'])
            ->count();
        $failedDeliveries = (clone $orders)
            ->where(function (Builder $query) {
                $query->whereIn('delivery_booking_status', ['failed', 'cancelled'])
                    ->orWhereIn('lalamove_status', ['failed', 'cancelled', 'rejected']);
            })
            ->count();

        $businessRows = $adminClients->map(function (User $adminClient) use ($filters) {
            $tenantOrders = $this->applyDeveloperOrderFilters(Order::query(), [
                ...$filters,
                'business_id' => $adminClient->id,
                'search' => null,
            ])
                ->where(function (Builder $query) use ($adminClient) {
                    $query->where('admin_client_id', $adminClient->id)
                        ->orWhereHas('user', fn (Builder $customer) => $customer->where('admin_client_id', $adminClient->id));
                });

            $ordersCount = (clone $tenantOrders)->count();
            $completedCount = (clone $tenantOrders)->where('status', 'Completed')->count();
            $cancelledCount = (clone $tenantOrders)->where('status', 'Cancelled')->count();
            $salesTotal = (float) (clone $tenantOrders)->sum('total_price');
            $revenueTotal = (float) (clone $tenantOrders)->whereNotNull('paid_at')->sum('total_price');
            $paymentIssues = (clone $tenantOrders)->whereNull('paid_at')->count();
            $businessName = $adminClient->adminClientProfile?->business_name ?: ($adminClient->company ?: $adminClient->name);

            return [
                'id' => $adminClient->id,
                'business_name' => $businessName ?: 'Unregistered Business',
                'admin_client' => $adminClient->name ?: 'Admin Client',
                'status' => $adminClient->approved_at ? 'Active' : ($adminClient->invitation_accepted_at ? 'Suspended' : 'Inactive'),
                'customers' => $adminClient->assigned_customers_count,
                'orders' => $ordersCount,
                'completed' => $completedCount,
                'cancelled' => $cancelledCount,
                'sales' => $salesTotal,
                'revenue' => $revenueTotal,
                'payment_issues' => $paymentIssues,
                'last_activity' => optional($adminClient->updated_at)->diffForHumans() ?? 'No activity',
                'url' => route('developer.admin-clients.show', $adminClient),
                'orders_url' => route('developer.orders.index', ['business_id' => $adminClient->id]),
                'customers_url' => route('developer.customers.index', ['business_id' => $adminClient->id]),
                'payments_url' => route('developer.orders.index', ['business_id' => $adminClient->id, 'payment' => 'issues']),
                'deliveries_url' => route('developer.orders.index', ['business_id' => $adminClient->id, 'delivery' => 'all']),
                'logs_url' => route('developer.reports.index', ['business_id' => $adminClient->id, 'type' => 'audit']),
                'suspend_url' => route('developer.admin-clients.suspend', $adminClient),
                'activate_url' => route('developer.admin-clients.approve', $adminClient),
            ];
        })->values();

        $statusCounts = (clone $orders)
            ->reorder()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $paymentMethodExpression = "COALESCE(payment_method, 'Unrecorded')";
        $paymentBreakdown = (clone $orders)
            ->reorder()
            ->selectRaw($paymentMethodExpression . ' as method, COUNT(*) as total')
            ->groupByRaw($paymentMethodExpression)
            ->pluck('total', 'method');

        $deliveryStatusExpression = "COALESCE(delivery_booking_status, COALESCE(lalamove_status, 'Not Booked'))";
        $deliveryBreakdown = (clone $orders)
            ->reorder()
            ->selectRaw($deliveryStatusExpression . ' as status, COUNT(*) as total')
            ->groupByRaw($deliveryStatusExpression)
            ->pluck('total', 'status');

        $revenueTrend = (clone $orders)
            ->reorder()
            ->selectRaw('DATE(created_at) as day, SUM(total_price) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('day')
            ->pluck('total', 'day');

        $cancellationTrend = (clone $orders)
            ->reorder()
            ->where('status', 'Cancelled')
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('day')
            ->pluck('total', 'day');

        return [
            'filters' => $filters,
            'kpis' => [
                ['label' => 'Total Businesses', 'value' => $adminClients->count(), 'icon' => 'building-2', 'tone' => 'blue', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Active Businesses', 'value' => $adminClients->whereNotNull('approved_at')->count(), 'icon' => 'badge-check', 'tone' => 'green', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Inactive Businesses', 'value' => $adminClients->whereNull('invitation_accepted_at')->count(), 'icon' => 'clock-3', 'tone' => 'orange', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Suspended Businesses', 'value' => $adminClients->whereNull('approved_at')->whereNotNull('invitation_accepted_at')->count(), 'icon' => 'ban', 'tone' => 'red', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Deleted Businesses', 'value' => 0, 'icon' => 'archive-x', 'tone' => 'slate', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Total Admin Clients', 'value' => $adminClients->count(), 'icon' => 'shield-check', 'tone' => 'blue', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Pending Invitations', 'value' => $adminClients->whereNull('invitation_accepted_at')->whereNotNull('invite_token')->count(), 'icon' => 'mail-clock', 'tone' => 'orange', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Total Customers', 'value' => User::where('role', User::ROLE_CUSTOMER)->count(), 'icon' => 'users-round', 'tone' => 'green', 'url' => route('developer.customers.index')],
                ['label' => 'Suspended Accounts', 'value' => $adminClients->whereNull('approved_at')->whereNotNull('invitation_accepted_at')->count(), 'icon' => 'user-x', 'tone' => 'red', 'url' => route('developer.admin-clients.index')],
                ['label' => 'Total Orders', 'value' => $totalOrders, 'icon' => 'shopping-cart', 'tone' => 'blue', 'url' => route('developer.orders.index')],
                ['label' => 'Completed Orders', 'value' => $completedOrders, 'icon' => 'circle-check', 'tone' => 'green', 'url' => route('developer.orders.index')],
                ['label' => 'Cancelled Orders', 'value' => $cancelledOrders, 'icon' => 'circle-x', 'tone' => 'red', 'url' => route('developer.orders.index')],
                ['label' => 'Total Sales', 'value' => 'PHP ' . number_format((float) (clone $orders)->sum('total_price'), 2), 'icon' => 'receipt-text', 'tone' => 'blue', 'url' => route('developer.reports.index')],
                ['label' => 'Total Revenue', 'value' => 'PHP ' . number_format((float) (clone $orders)->whereNotNull('paid_at')->sum('total_price'), 2), 'icon' => 'circle-dollar-sign', 'tone' => 'green', 'url' => route('developer.reports.index')],
                ['label' => 'Pending Payments', 'value' => $pendingPayments, 'icon' => 'wallet-cards', 'tone' => 'orange', 'url' => route('developer.orders.index')],
                ['label' => 'Failed Payments', 'value' => max(0, $totalOrders - $paidOrders - $pendingPayments), 'icon' => 'badge-alert', 'tone' => 'red', 'url' => route('developer.orders.index')],
                ['label' => 'Active Deliveries', 'value' => $activeDeliveries, 'icon' => 'truck', 'tone' => 'blue', 'url' => route('developer.orders.index')],
            ],
            'businessRows' => $businessRows,
            'statusCounts' => $statusCounts,
            'paymentBreakdown' => $paymentBreakdown,
            'deliveryBreakdown' => $deliveryBreakdown,
            'revenueTrend' => $revenueTrend,
            'cancellationTrend' => $cancellationTrend,
            'recentPayments' => (clone $orders)->whereNotNull('payment_method')->limit(5)->get(),
            'recentCancellations' => (clone $orders)->where('status', 'Cancelled')->limit(5)->get(),
            'recentDeliveries' => (clone $orders)->whereNotNull('delivery_booking_status')->limit(5)->get(),
            'recentAuditLogs' => AuditLog::with(['actor', 'targetUser'])->latest()->limit(5)->get(),
            'failedDeliveries' => $failedDeliveries,
        ];
    }

    private function developerDashboardFilters(Request $request): array
    {
        $range = $request->string('date_range')->toString() ?: 'this_month';
        $from = null;
        $to = null;

        if ($range === 'today') {
            $from = now()->startOfDay();
            $to = now()->endOfDay();
        } elseif ($range === 'last_7') {
            $from = now()->subDays(6)->startOfDay();
            $to = now()->endOfDay();
        } elseif ($range === 'custom') {
            $from = $request->date('date_from')?->startOfDay();
            $to = $request->date('date_to')?->endOfDay();
        } else {
            $range = 'this_month';
            $from = now()->startOfMonth();
            $to = now()->endOfDay();
        }

        return [
            'search' => trim((string) $request->query('search', '')) ?: null,
            'date_range' => $range,
            'date_from' => $from,
            'date_to' => $to,
            'business_id' => $request->integer('business_id') ?: null,
            'status' => trim((string) $request->query('status', '')) ?: null,
            'payment_method' => trim((string) $request->query('payment_method', '')) ?: null,
        ];
    }

    private function applyDeveloperOrderFilters(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['date_from'] ?? null, fn (Builder $scope, $date) => $scope->where('created_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn (Builder $scope, $date) => $scope->where('created_at', '<=', $date))
            ->when($filters['business_id'] ?? null, function (Builder $scope, int $businessId) {
                $scope->where(function (Builder $tenant) use ($businessId) {
                    $tenant->where('admin_client_id', $businessId)
                        ->orWhereHas('user', fn (Builder $customer) => $customer->where('admin_client_id', $businessId));
                });
            })
            ->when($filters['status'] ?? null, fn (Builder $scope, string $status) => $scope->where('status', $status))
            ->when($filters['payment_method'] ?? null, fn (Builder $scope, string $method) => $scope->where('payment_method', $method))
            ->when($filters['search'] ?? null, function (Builder $scope, string $search) {
                $scope->where(function (Builder $nested) use ($search) {
                    $nested->where('order_reference', 'like', "%{$search}%")
                        ->orWhere('payment_reference', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%")
                        ->orWhereHas('user', fn (Builder $customer) => $customer->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                        ->orWhereHas('adminClient', fn (Builder $admin) => $admin->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
                });
            });
    }
}
