<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderCustomerInfoRequest;
use App\Resources\OrderCustomerInfo;
use App\Services\CartManagementService;
use App\Services\UserOrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class OrderCustomerInfoController extends Controller
{
    public function create(CartManagementService $cartManagementService): View|RedirectResponse
    {
        if ($cartManagementService->isEmpty()) 
            return redirect()
                ->route('order.create')
                ->with('bad-request', 'Anda belum memiliki pesanan, silahkan dipilih terlebih dahulu.');

        return view('order.customer-info.create');
    }

    public function store(
        StoreOrderCustomerInfoRequest $request,
        UserOrderService $userOrderService,
        CartManagementService $cartManagementService
        ): RedirectResponse
    {
        $customerInfo = OrderCustomerInfo::createFromRequest($request);
        $cartManagementService->getCart()->setCustomerInfo($customerInfo);
        
        $order = $userOrderService->createNewOrder($cartManagementService->getCart());
        $cartManagementService->clear();

        return redirect()
            ->route('order-created', ['order' => $order->id])
            ->with('status', 'Pesanan anda telah dibuat.')
            ;
    }
}
