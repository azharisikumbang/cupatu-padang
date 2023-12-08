<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderCreatedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order)
    {
        $order->load('details');

        return view('order.created.index', [
            'order' => $order->toArray()
        ]);
    }
}
