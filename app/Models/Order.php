<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
