<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_client_id',
        'business_id',
        'order_reference',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'total_price',
        'checkout_details',
        'payment_method',
        'payment_provider',
        'payment_checkout_id',
        'payment_reference',
        'paid_at',
        'receipt_number',
        'receipt_pdf_path',
        'receipt_sent_at',
        'delivery_method',
        'delivery_fee',
        'delivery_address',
        'delivery_latitude',
        'delivery_longitude',
        'delivery_notes',
        'delivery_booking_status',
        'delivery_tracking_number',
        'delivery_tracking_url',
        'delivery_booked_at',
        'lalamove_quotation_id',
        'lalamove_order_id',
        'lalamove_status',
        'lalamove_driver_id',
        'lalamove_driver_name',
        'lalamove_driver_phone',
        'lalamove_plate_number',
        'lalamove_share_link',
        'lalamove_last_synced_at',
    ];

    protected $casts = [
        'checkout_details' => 'array',
        'total_price' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'delivery_latitude' => 'decimal:7',
        'delivery_longitude' => 'decimal:7',
        'lalamove_last_synced_at' => 'datetime',
        'paid_at' => 'datetime',
        'receipt_sent_at' => 'datetime',
        'delivery_booked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adminClient()
    {
        return $this->belongsTo(User::class, 'admin_client_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function files()
    {
        return $this->hasMany(\App\Models\OrderFile::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function recomputeTotal(): void
    {
        $total = $this->items()->sum('subtotal') + (float) ($this->delivery_fee ?? 0);
        $this->update(['total_price' => $total]);
    }

    public function scopeVisibleToPortalUser(Builder $query, User $user): Builder
    {
        if ($user->canViewAllPortalRecords()) {
            return $query;
        }

        if ($user->isAdminClient()) {
            return $query->where(function (Builder $scope) use ($user) {
                $scope->when($user->business_id, fn (Builder $tenant) => $tenant->where('business_id', $user->business_id))
                    ->orWhere('admin_client_id', $user->id)
                    ->orWhereHas('user', function (Builder $customer) use ($user) {
                        $customer->where('admin_client_id', $user->id)
                            ->when($user->business_id, fn (Builder $tenant) => $tenant->orWhere('business_id', $user->business_id));
                    });
            });
        }

        return $query->whereRaw('1 = 0');
    }

    public function isVisibleToPortalUser(User $user): bool
    {
        if ($user->canViewAllPortalRecords()) {
            return true;
        }

        if (!$user->isAdminClient()) {
            return false;
        }

        return ($user->business_id && (int) $this->business_id === (int) $user->business_id)
            || (int) $this->admin_client_id === (int) $user->id
            || (int) optional($this->user)->admin_client_id === (int) $user->id;
    }
}
