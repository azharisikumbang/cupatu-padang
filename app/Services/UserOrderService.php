<?php

namespace App\Services;

use App\Contract\OrderStatus;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Resources\Cart;

class UserOrderService
{
    public function __construct(protected readonly CartManagementService $cartManagementService)
    {}

    public function createNewOrder(Cart $cart): Order
    {
        $customerInfo = $cart->getCustomerInfo();
        
        /** @var Order $order */
        $order = Order::create([
            'customer_id' => auth()->user()->id,
            'customer_name' => $customerInfo->getName(),
            'customer_address' => $customerInfo->getAddress(),
            'customer_contact' => $customerInfo->getContact(),
            'order_price_total' => $cart->getTotal(),
            'order_shipping_cost' => 0, // @TODO: ganti dengan perhitungan sebenarnya
            'order_shipping_address' => $customerInfo->getAddress(),
            'order_status' => OrderStatus::MENUNGGU_KONFIRMASI->value, // 'MENUNGGU_KONFIRMASI', // @TODO:: change dari database 'default'
            'order_notes' => '',
            'est_date_completion' => (date('Y-m-d H:i:s', strtotime('+3 days'))), // @TODO ganti dengan hari paling lama dalam pengerjaan setiap item
            'courier_name' => '', 
            'courier_contact' => '',
        ]);

        $orderItems = [];
        foreach($cart->getItems() as $item) {
            /** @var \App\Resources\CartItem $item */
            $orderItems[] = OrderDetail::make([
                'service_name' => $item->getService()['name'],
                'service_price' => $item->getService()['price'],
                'shoe_brand_name' => $item->getShoeName(),
                'shoe_image' => $item->getShoeImage()
            ]);
        }

        $order->details()->saveMany($orderItems);

        return $order;
    }
}