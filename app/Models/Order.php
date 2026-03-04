<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'shipping_info',
        'payment_method',
        'payment_status',
        'stripe_payment_intent_id',
        'paid_at',
        'cancelled_at',
        'restocked_at',
        'order_email_sent_at',
        'payment_email_sent_at',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'shipping_info' => 'array',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'restocked_at' => 'datetime',
        'order_email_sent_at' => 'datetime',
        'payment_email_sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

