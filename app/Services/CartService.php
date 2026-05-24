<?php

namespace App\Services;

use App\Repositories\CartRepository;
use App\Models\Cart;
use App\Models\Product;

class CartService
{
    protected CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getCart(?int $userId, ?string $sessionId): Cart
    {
        if ($userId) {
            $cart = $this->cartRepository->getCartByUserId($userId);
            if (!$cart) {
                $cart = $this->cartRepository->createCartForUser($userId);
            }
            return $cart;
        }

        if ($sessionId) {
            $cart = $this->cartRepository->getCartBySessionId($sessionId);
            if (!$cart) {
                $cart = $this->cartRepository->createCartForSession($sessionId);
            }
            return $cart;
        }

        throw new \InvalidArgumentException("Either user_id or session_id must be provided to retrieve a cart.");
    }

    public function addItemToCart(?int $userId, ?string $sessionId, int $productId, int $quantity): array
    {
        $product = Product::find($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        if ($product->stock < $quantity) {
            return ['success' => false, 'message' => 'Not enough stock available. Only ' . $product->stock . ' units left.'];
        }

        $cart = $this->getCart($userId, $sessionId);
        $this->cartRepository->addOrUpdateItem($cart->id, $productId, $quantity);

        return ['success' => true, 'message' => 'Product added to cart successfully.'];
    }

    public function removeItemFromCart(?int $userId, ?string $sessionId, int $productId): bool
    {
        $cart = $this->getCart($userId, $sessionId);
        return $this->cartRepository->removeItem($cart->id, $productId);
    }

    public function updateQuantity(?int $userId, ?string $sessionId, int $productId, int $quantity): array
    {
        $product = Product::find($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        if ($product->stock < $quantity) {
            return ['success' => false, 'message' => 'Not enough stock available. Only ' . $product->stock . ' units left.'];
        }

        $cart = $this->getCart($userId, $sessionId);
        $this->cartRepository->updateItemQuantity($cart->id, $productId, $quantity);

        return ['success' => true, 'message' => 'Cart updated successfully.'];
    }

    public function toggleSaveForLater(?int $userId, ?string $sessionId, int $productId): bool
    {
        $cart = $this->getCart($userId, $sessionId);
        return $this->cartRepository->toggleSaveForLater($cart->id, $productId);
    }

    public function mergeCarts(int $userId, string $sessionId): void
    {
        $this->cartRepository->mergeGuestCart($userId, $sessionId);
    }
}
