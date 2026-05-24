<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;

class CartRepository
{
    public function getCartByUserId(int $userId): ?Cart
    {
        return Cart::where('user_id', $userId)->with('items.product.images')->first();
    }

    public function getCartBySessionId(string $sessionId): ?Cart
    {
        return Cart::where('session_id', $sessionId)->with('items.product.images')->first();
    }

    public function createCartForUser(int $userId): Cart
    {
        return Cart::create(['user_id' => $userId]);
    }

    public function createCartForSession(string $sessionId): Cart
    {
        return Cart::create(['session_id' => $sessionId]);
    }

    public function getCartItem(int $cartId, int $productId): ?CartItem
    {
        return CartItem::where('cart_id', $cartId)->where('product_id', $productId)->first();
    }

    public function addOrUpdateItem(int $cartId, int $productId, int $quantity): CartItem
    {
        $item = $this->getCartItem($cartId, $productId);
        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $item = CartItem::create([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'save_for_later' => false
            ]);
        }
        return $item;
    }

    public function removeItem(int $cartId, int $productId): bool
    {
        return CartItem::where('cart_id', $cartId)->where('product_id', $productId)->delete() > 0;
    }

    public function updateItemQuantity(int $cartId, int $productId, int $quantity): bool
    {
        $item = $this->getCartItem($cartId, $productId);
        if ($item) {
            $item->quantity = $quantity;
            return $item->save();
        }
        return false;
    }

    public function toggleSaveForLater(int $cartId, int $productId): bool
    {
        $item = $this->getCartItem($cartId, $productId);
        if ($item) {
            $item->save_for_later = !$item->save_for_later;
            return $item->save();
        }
        return false;
    }

    public function mergeGuestCart(int $userId, string $sessionId): void
    {
        $guestCart = Cart::where('session_id', $sessionId)->first();
        if (!$guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate(['user_id' => $userId]);

        foreach ($guestCart->items as $guestItem) {
            $userItem = $this->getCartItem($userCart->id, $guestItem->product_id);
            if ($userItem) {
                $userItem->quantity += $guestItem->quantity;
                $userItem->save();
            } else {
                $guestItem->cart_id = $userCart->id;
                $guestItem->save();
            }
        }

        $guestCart->delete();
    }
}
