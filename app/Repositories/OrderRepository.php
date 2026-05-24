<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    public function createOrder(array $orderData, array $items): Order
    {
        $order = Order::create($orderData);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        return $order->load('items.product');
    }

    public function getUserOrders(int $userId): Collection
    {
        return Order::where('user_id', $userId)
            ->with(['items.product.images'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAllOrders(): Collection
    {
        return Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findById(int $orderId): ?Order
    {
        return Order::with(['user', 'items.product.images'])->find($orderId);
    }

    public function updateStatus(int $orderId, string $status): bool
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $status;
            return $order->save();
        }
        return false;
    }

    public function updatePaymentStatus(int $orderId, string $paymentStatus): bool
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->payment_status = $paymentStatus;
            return $order->save();
        }
        return false;
    }
}
