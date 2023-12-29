<?php

namespace App\Models;

use App\Contract\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_address',
        'customer_contact',
        'order_price_total',
        'order_shipping_cost',
        'order_shipping_address',
        'order_status',
        'order_notes',
        'est_date_completion',
        'courier_name',
        'courier_contact',

    ];

    protected $appends = ['order_status_readable'];

    public function getOrderStatusReadableAttribute()
    {
        return OrderStatus::tryFrom($this->getAttribute('order_status'))?->showReadable();
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
