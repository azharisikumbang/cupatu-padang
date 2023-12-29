<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = auth()->user()->id;

        return view('customer.order.index', [
            'orders' => $request->has('cari') 
                        ? Order::where('customer_id', $userId)->where('customer_name', 'like', "%{$request->get('cari')}%")->orderBy('created_at', 'desc')->paginate(10)->toArray()
                        : Order::where('customer_id', $userId)->orderBy('created_at', 'desc')->paginate(10)->toArray()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if ($order->owner->id != auth()->user()->id) return abort('403');

        dd($order->toArray());

        return view('customer.order.show', [
            'order' => $order->load('details')->toArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
