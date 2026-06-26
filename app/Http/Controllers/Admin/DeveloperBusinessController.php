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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $data = $this->businessReportData($business, 12);

        return view('Admin.businesses.show', $data);
    }

    public function export(Request $request, Business $business): Response
    {
        $format = in_array($request->query('format'), ['csv', 'pdf', 'xls'], true)
            ? $request->query('format')
            : 'pdf';
        $report = $this->businessReportData($business, 50);
        $baseName = 'business-report-' . str($business->slug ?: $business->id)->slug() . '-' . now()->format('Y-m-d-His');
        $headers = ['Section', 'Item', 'Status', 'Amount / Count', 'Date'];

        if ($format === 'csv') {
            return response()->streamDownload(function () use ($headers, $report) {
                $output = fopen('php://output', 'w');
                fputcsv($output, $headers);

                foreach ($this->businessCsvRows($report) as $row) {
                    fputcsv($output, $row);
                }

                fclose($output);
            }, $baseName . '.csv', ['Content-Type' => 'text/csv']);
        }

        if ($format === 'xls') {
            return response()->streamDownload(function () use ($report) {
                echo view('pdf.developer-business-report', [
                    'report' => $report,
                    'generatedAt' => now(),
                ])->render();
            }, $baseName . '.xls', [
                'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            ]);
        }

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.developer-business-report', [
                'report' => $report,
                'generatedAt' => now(),
            ])->download($baseName . '.pdf');
        }

        return response()->streamDownload(function () use ($report) {
            echo view('pdf.developer-business-report', [
                'report' => $report,
                'generatedAt' => now(),
            ])->render();
        }, $baseName . '.html', ['Content-Type' => 'text/html; charset=UTF-8']);
    }

    private function businessReportData(Business $business, int $limit): array
    {
        $business->load(['owner.adminClientProfile']);
        $owner = $business->owner;
        $fallbackAdminClientId = $owner?->id;

        $customerQuery = $this->customersForBusiness($business, $fallbackAdminClientId);
        $orderQuery = $this->ordersForBusiness($business, $fallbackAdminClientId);
        $paymentQuery = $this->paymentsForBusiness($business, $fallbackAdminClientId);
        $deliveryQuery = $this->deliveriesForBusiness($business, $fallbackAdminClientId);
        $serviceQuery = $this->servicesForBusiness($business);
        $auditQuery = $this->auditLogsForBusiness($business, $fallbackAdminClientId);
        $invitationQuery = $this->invitationsForBusiness($business, $fallbackAdminClientId);

        $orders = (clone $orderQuery)->with(['user', 'payments', 'deliveries'])->latest();
        $payments = (clone $paymentQuery)->with(['order', 'customer'])->latest();
        $deliveries = (clone $deliveryQuery)->with(['order', 'customer'])->latest();

        $hasPaymentRows = (clone $payments)->exists();
        $hasDeliveryRows = (clone $deliveries)->exists();

        $kpis = [
            ['label' => 'Total Customers', 'value' => (clone $customerQuery)->count(), 'tone' => 'green'],
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
            ['label' => 'Services', 'value' => (clone $serviceQuery)->count(), 'tone' => 'slate'],
        ];

        $lastActivity = collect([
            (clone $orders)->max('updated_at'),
            (clone $payments)->max('updated_at'),
            (clone $deliveries)->max('updated_at'),
            $business->updated_at,
            $owner?->updated_at,
        ])->filter()->max();

        return [
            'business' => $business,
            'owner' => $owner,
            'kpis' => $kpis,
            'customers' => (clone $customerQuery)->latest()->limit($limit)->get(),
            'orders' => (clone $orders)->limit($limit)->get(),
            'payments' => (clone $payments)->limit($limit)->get(),
            'deliveries' => (clone $deliveries)->limit($limit)->get(),
            'services' => (clone $serviceQuery)->withCount('activeVariations')->orderBy('category')->orderBy('name')->limit($limit)->get(),
            'invitations' => (clone $invitationQuery)->latest()->limit($limit)->get(),
            'auditLogs' => (clone $auditQuery)->with(['actor', 'targetUser'])->latest()->limit($limit)->get(),
            'lastActivity' => $lastActivity,
            'paymentsSummary' => [
                'paid' => $hasPaymentRows ? (clone $payments)->where('status', Payment::STATUS_PAID)->count() : (clone $orders)->whereNotNull('paid_at')->count(),
                'pending' => $hasPaymentRows ? (clone $payments)->where('status', Payment::STATUS_PENDING)->count() : (clone $orders)->whereNull('paid_at')->count(),
                'failed' => $hasPaymentRows ? (clone $payments)->whereIn('status', [Payment::STATUS_FAILED, Payment::STATUS_DISCREPANCY, Payment::STATUS_REFUNDED, Payment::STATUS_CANCELLED])->count() : (clone $orders)->whereIn('status', ['failed', 'Failed', 'payment_failed', 'Payment Failed', 'discrepancy', 'Discrepancy'])->count(),
            ],
            'deliveriesSummary' => [
                'active' => $hasDeliveryRows ? (clone $deliveries)->whereIn('status', self::ACTIVE_DELIVERY_STATUSES)->count() : (clone $orders)->where(function (Builder $query) {
                    $query->whereIn('delivery_booking_status', self::ACTIVE_DELIVERY_STATUSES)
                        ->orWhereIn('lalamove_status', self::ACTIVE_DELIVERY_STATUSES);
                })->count(),
                'delivered' => $hasDeliveryRows ? (clone $deliveries)->where('status', Delivery::STATUS_DELIVERED)->count() : (clone $orders)->where(function (Builder $query) {
                    $query->where('delivery_booking_status', 'delivered')
                        ->orWhere('lalamove_status', 'delivered');
                })->count(),
                'failed' => $hasDeliveryRows ? (clone $deliveries)->whereIn('status', [Delivery::STATUS_FAILED, Delivery::STATUS_CANCELLED])->count() : (clone $orders)->where(function (Builder $query) {
                    $query->whereIn('delivery_booking_status', ['failed', 'cancelled', 'canceled', 'rejected'])
                        ->orWhereIn('lalamove_status', ['failed', 'cancelled', 'canceled', 'rejected']);
                })->count(),
            ],
        ];
    }

    private function businessCsvRows(array $report): array
    {
        $rows = [];

        foreach ($report['kpis'] as $kpi) {
            $rows[] = ['Summary', $kpi['label'], '', $kpi['value'], ''];
        }

        foreach ($report['payments'] as $payment) {
            $rows[] = ['Payment', $payment->gateway_reference ?: $payment->order?->order_reference ?: '#' . $payment->id, $payment->status, $payment->amount, optional($payment->created_at)->format('Y-m-d')];
        }

        foreach ($report['deliveries'] as $delivery) {
            $rows[] = ['Delivery', $delivery->tracking_reference ?: $delivery->order?->order_reference ?: '#' . $delivery->id, $delivery->status, $delivery->delivery_fee, optional($delivery->created_at)->format('Y-m-d')];
        }

        foreach ($report['auditLogs'] as $log) {
            $rows[] = ['Audit Log', $log->action ?? 'activity', $log->actor?->name ?: 'System', '', optional($log->created_at)->format('Y-m-d')];
        }

        return $rows;
    }

    public function activate(Request $request, Business $business): RedirectResponse
    {
        return $this->changeStatus($request, $business, Business::STATUS_ACTIVE, 'business_activated');
    }

    public function markInactive(Request $request, Business $business): RedirectResponse
    {
        return $this->changeStatus($request, $business, Business::STATUS_INACTIVE, 'business_marked_inactive');
    }

    public function suspend(Request $request, Business $business): RedirectResponse
    {
        return $this->changeStatus($request, $business, Business::STATUS_SUSPENDED, 'business_suspended');
    }

    public function destroy(Request $request, Business $business): RedirectResponse
    {
        $oldStatus = $business->status;

        $business->forceFill(['status' => Business::STATUS_DELETED])->save();
        $business->delete();

        $this->recordBusinessStatusAudit($request, $business, 'business_deleted', $oldStatus, Business::STATUS_DELETED);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Business marked as deleted.');
    }

    public function restore(Request $request, int $business): RedirectResponse
    {
        $business = Business::withTrashed()->findOrFail($business);
        $oldStatus = $business->status;

        if ($business->trashed()) {
            $business->restore();
        }

        $business->forceFill(['status' => Business::STATUS_ACTIVE])->save();
        $this->recordBusinessStatusAudit($request, $business, 'business_restored', $oldStatus, Business::STATUS_ACTIVE);

        return redirect()
            ->route('developer.businesses.show', $business)
            ->with('success', 'Business restored and reactivated.');
    }

    private function changeStatus(Request $request, Business $business, string $status, string $action): RedirectResponse
    {
        $oldStatus = $business->status;

        $business->forceFill(['status' => $status])->save();
        $this->recordBusinessStatusAudit($request, $business, $action, $oldStatus, $status);

        return redirect()
            ->back()
            ->with('success', 'Business status updated to ' . str($status)->headline() . '.');
    }

    private function recordBusinessStatusAudit(Request $request, Business $business, string $action, ?string $oldStatus, string $newStatus): void
    {
        AuditLog::create([
            'actor_id' => $request->user()?->id,
            'target_user_id' => $business->owner_user_id,
            'business_id' => $business->id,
            'auditable_type' => Business::class,
            'auditable_id' => $business->id,
            'action' => $action,
            'module' => 'business',
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $newStatus],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
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

    private function invitationsForBusiness(Business $business, ?int $fallbackAdminClientId): Builder
    {
        return User::query()
            ->where('role', User::ROLE_ADMIN_CLIENT)
            ->where(function (Builder $query) use ($business, $fallbackAdminClientId) {
                $query->where('business_id', $business->id)
                    ->orWhere('id', $business->owner_user_id)
                    ->when($fallbackAdminClientId, fn (Builder $scope) => $scope->orWhere('id', $fallbackAdminClientId));
            })
            ->where(function (Builder $query) {
                $query->whereNotNull('preregistered_by')
                    ->orWhereNotNull('invite_token')
                    ->orWhereNotNull('invitation_accepted_at')
                    ->orWhereNotNull('invite_cancelled_at');
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
