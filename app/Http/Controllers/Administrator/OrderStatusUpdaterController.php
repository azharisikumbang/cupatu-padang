<?php

namespace App\Http\Controllers\Administrator;

use App\Contract\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusUpdaterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order, string $action)
    {
        if (strtolower($action) == 'next') $this->changeOrderStatusToNext($order);

        if (strtolower($action) == 'prev') $this->changeOrderStatusToPrev($order);

        return redirect()
            ->route('administrator.order.show', ['order' => $order->id])
            ->with('status', "Status Pesanan berhasil perbaharui.");
    }

    private function changeOrderStatusToNext(Order $order): void
    {
        $nextOrderStatus = OrderStatus::tryFrom($order->order_status_action_list['actual_next_order_status']);
        
        if (null !== $nextOrderStatus) $order->update(['order_status' => $nextOrderStatus->value]);
    }

    private function changeOrderStatusToPrev(Order $order): void
    {
        $prevOrderStatus = OrderStatus::tryFrom($order->order_status_action_list['actual_prev_order_status']);
        
        if (null !== $prevOrderStatus) $order->update(['order_status' => $prevOrderStatus->value]);
    }
}
