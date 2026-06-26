<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REFUNDED = 'refunded';
    public const STATUS_DISCREPANCY = 'discrepancy';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'business_id',
        'order_id',
        'customer_id',
        'payment_method',
        'payment_gateway',
        'gateway_checkout_id',
        'gateway_reference',
        'amount',
        'status',
        'verified_by',
        'paid_at',
        'remarks',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
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

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
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
}
