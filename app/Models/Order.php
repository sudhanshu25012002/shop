<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
        'subtotal',
        'discount',
        'shipping_fee',
        'tax',
        'total',
        'payment_method',
        'payment_status',
        'status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-50 text-amber-800 border-amber-200',
            'processing' => 'bg-blue-50 text-blue-800 border-blue-200',
            'shipped' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
            'delivered' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            'cancelled' => 'bg-rose-50 text-rose-800 border-rose-200',
            default => 'bg-zinc-50 text-zinc-800 border-zinc-200',
        };
    }
}
