<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EReceiptRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'receipt_type', 'full_name', 'business_name', 'tin',
        'region', 'province', 'city', 'barangay', 'postal_code',
        'street_address', 'is_default', 'status',
    ];

    protected $casts = ['is_default' => 'boolean'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
