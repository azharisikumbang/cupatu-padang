<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemToCartRequest;
use App\Models\Service;
use App\Resources\Cart;
use App\Resources\CartItem;
use App\Services\CartManagementService;
use Illuminate\Http\Request;

class CartManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartManagementService $cartManagementService)
    {
        return response()->json($cartManagementService->getCart()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemToCartRequest $request, CartManagementService $cartManagementService)
    {
        $cartItem = CartItem::createFromRequest($request);
        $service = Service::find($cartItem->getServiceId());
        $cartItem->setService($service);

        $cartManagementService->addItemToCart($cartItem);

        return response()->json($cartManagementService->getCart()->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $key, CartManagementService $cartManagementService)
    {
        $cartManagementService->removeItemFromCart($key);

        return response()->json([
            'message' => 'Item deleted from cart.'
        ]);
    }
}
