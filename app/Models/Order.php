<?php

namespace App\Models;

use App\Contract\OrderStatus;
use App\Contract\Roles;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

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

    protected $appends = ['order_status_readable', 'order_status_action_list'];

    public function getOrderStatusReadableAttribute(): null|string
    {
        return OrderStatus::tryFrom($this->getAttribute('order_status'))?->getReadable();
    }

    public function getOrderStatusActionListAttribute(): null|array
    {
        if (false === auth()->user()->hasRole(Roles::ADMINISTRATOR)) return [];

        return OrderStatus::tryFrom($this->getAttribute('order_status'))?->getActionList($this->getAttribute('id'));
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function isOrderIsOwnByAuthenticatedUser(Authenticatable|User $user): bool
    {
        return $this->owner->id === $user->getAttribute('id');
    }

    public function countOrderDoneAndCancelListMonthly(int $year): Collection
    {
        return \DB::table($this->getTable())
            ->selectRaw("MONTH(created_at) as 'bulan', COUNT(IF(order_status = 'SELESAI', 1, NULL)) as 'jumlah_pesanan_selesai', COUNT(IF(order_status = 'BATAL', 1, NULL)) as 'jumlah_pesanan_batal'")
            ->whereIn('order_status', [OrderStatus::SELESAI->value, OrderStatus::BATAL->value])
            ->whereYear('created_at', $year)
            ->groupByRaw("MONTH(created_at)")
            ->get()
        ;
    }
}
