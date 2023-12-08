<?php

namespace App\Services;

use App\Resources\Cart;
use App\Resources\CartItem;

class CartManagementService
{
    const SESSION_CART_NAME = 'cart';

    public function addItemToCart(CartItem $cartItem)
    {
        $cart = $this->getCart();
        $cart->addItem($cartItem);

        session()->put(self::SESSION_CART_NAME, $cart);
    }

    public function getCart(): Cart
    {
        return $this->isSessionHasBeenBuild() ? session()->get(self::SESSION_CART_NAME) : $this->createEmptySession();
    }

    public function removeItemFromCart(CartItem|string $item)
    {
        $this->getCart()->removeItem(
            is_string($item) ? $item : $item->getKey()
        );
    }

    public function clear(): void
    {
        $this->createEmptySession();
    }

    private function isSessionHasBeenBuild(): bool
    {
        return session()->has(self::SESSION_CART_NAME);
    }

    private function createEmptySession()
    {
        session()->put(self::SESSION_CART_NAME, new Cart);
    }
}