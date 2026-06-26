<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'business_id',
        'order_id',
        'customer_id',
        'courier',
        'delivery_method',
        'tracking_reference',
        'tracking_url',
        'delivery_address',
        'delivery_fee',
        'status',
        'booked_at',
        'delivered_at',
        'remarks',
    ];

    protected $casts = [
        'delivery_fee' => 'decimal:2',
        'booked_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function scopeVisibleToPortalUser(Builder $query, User $user): Builder
    {
        if ($user->canViewAllPortalRecords()) {
            return $query;
        }

        if ($user->isAdminClient()) {
            return $query->where(function (Builder $scope) use ($user) {
                $scope->when($user->business_id, fn (Builder $tenant) => $tenant->where('business_id', $user->business_id))
                    ->orWhereHas('order', fn (Builder $order) => $order->visibleToPortalUser($user));
            });
        }

        if ($user->isCustomer()) {
            return $query->where('customer_id', $user->id);
        }

        return $query->whereRaw('1 = 0');
    }

    public static function syncFromOrder(Order $order): ?self
    {
        $method = $order->delivery_method ?: data_get($order->checkout_details, 'delivery.type');

        if (!$method && !$order->delivery_address && !$order->delivery_booking_status && !$order->lalamove_status) {
            return null;
        }

        return self::updateOrCreate(
            ['order_id' => $order->id],
            [
                'business_id' => $order->business_id,
                'customer_id' => $order->user_id,
                'courier' => $method === 'lalamove' ? 'lalamove' : null,
                'delivery_method' => $method ?: 'standard',
                'tracking_reference' => $order->delivery_tracking_number ?: $order->lalamove_order_id,
                'tracking_url' => $order->delivery_tracking_url ?: $order->lalamove_share_link,
                'delivery_address' => $order->delivery_address,
                'delivery_fee' => round((float) ($order->delivery_fee ?? 0), 2),
                'status' => self::statusFromOrder($order),
                'booked_at' => $order->delivery_booked_at,
                'delivered_at' => self::isDeliveredStatus($order) ? ($order->updated_at ?: now()) : null,
                'remarks' => $order->delivery_notes,
            ]
        );
    }

    public static function statusFromOrder(Order $order): string
    {
        $status = strtolower((string) ($order->delivery_booking_status ?: $order->lalamove_status ?: ''));

        return match (true) {
            $status === '' => self::STATUS_PENDING,
            str_contains($status, 'delivered') => self::STATUS_DELIVERED,
            str_contains($status, 'failed'), str_contains($status, 'rejected') => self::STATUS_FAILED,
            str_contains($status, 'cancelled'), str_contains($status, 'canceled') => self::STATUS_CANCELLED,
            default => $order->delivery_booking_status ?: $order->lalamove_status ?: self::STATUS_PENDING,
        };
    }

    private static function isDeliveredStatus(Order $order): bool
    {
        return str_contains(strtolower((string) ($order->delivery_booking_status ?: $order->lalamove_status)), 'delivered');
    }
}
