<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Services\ProductService;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    protected OrderRepository $orderRepository;
    protected ProductService $productService;

    public function __construct(OrderRepository $orderRepository, ProductService $productService)
    {
        $this->orderRepository = $orderRepository;
        $this->productService = $productService;
    }

    public function placeOrder(int $userId, array $checkoutData): array
    {
        return DB::transaction(function () use ($userId, $checkoutData) {
            // 1. Get user cart
            $cart = Cart::where('user_id', $userId)->with('items.product')->first();
            if (!$cart || $cart->items->count() === 0) {
                return ['success' => false, 'message' => 'Your cart is empty.'];
            }

            // 2. Validate inventory stock for all items
            foreach ($cart->items as $item) {
                if ($item->save_for_later) continue;
                if ($item->product->stock < $item->quantity) {
                    return [
                        'success' => false,
                        'message' => "Insufficient stock for product: {$item->product->name}. Only {$item->product->stock} items remaining."
                    ];
                }
            }

            // 3. Calculate financial sums
            $subtotal = 0.00;
            $itemsData = [];

            foreach ($cart->items as $item) {
                if ($item->save_for_later) continue;
                $price = $item->product->final_price;
                $subtotal += $price * $item->quantity;

                $itemsData[] = [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price
                ];
            }

            if (empty($itemsData)) {
                return ['success' => false, 'message' => 'No active items in the cart to check out.'];
            }

            // 4. Calculate Coupon Discount
            $discount = 0.00;
            $couponId = null;
            if (!empty($checkoutData['coupon_code'])) {
                $coupon = Coupon::where('code', $checkoutData['coupon_code'])->first();
                if ($coupon && $coupon->isValid() && $subtotal >= $coupon->min_order_amount) {
                    $discount = $coupon->calculateDiscount($subtotal);
                    $couponId = $coupon->id;
                }
            }

            // 5. Calculate delivery fee & tax
            $deliveryFee = $subtotal > 50 ? 0.00 : 4.99; // Free delivery over $50
            $tax = round(($subtotal - $discount) * 0.08, 2); // 8% tax
            $total = $subtotal - $discount + $deliveryFee + $tax;

            // 6. Assemble Order Data
            $orderNumber = 'GROC-' . strtoupper(Str::random(8)) . '-' . time();
            $orderData = [
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => $checkoutData['payment_method'] === 'cod' ? 'pending' : 'paid',
                'payment_method' => $checkoutData['payment_method'] ?? 'cod',
                'shipping_address' => $checkoutData['shipping_address'],
                'billing_address' => $checkoutData['billing_address'] ?? $checkoutData['shipping_address'],
                'coupon_code' => $checkoutData['coupon_code'] ?? null,
                'notes' => $checkoutData['notes'] ?? null
            ];

            // 7. Create Order & Order Items
            $order = $this->orderRepository->createOrder($orderData, $itemsData);

            // 8. Deduct stock & Create inventory logs
            foreach ($cart->items as $item) {
                if ($item->save_for_later) continue;
                $this->productService->updateInventory(
                    $item->product_id,
                    -$item->quantity,
                    'sale',
                    "Order payment: {$orderNumber}",
                    $userId
                );
            }

            // 9. Save coupon usage if coupon applied
            if ($couponId) {
                CouponUsage::create([
                    'user_id' => $userId,
                    'coupon_id' => $couponId,
                    'order_id' => $order->id
                ]);
            }

            // 10. Clear Cart Items (only items checked out, keep saved for later items)
            $cart->items()->where('save_for_later', false)->delete();

            return [
                'success' => true,
                'message' => 'Order placed successfully.',
                'order' => $order
            ];
        });
    }

    public function getUserOrders(int $userId)
    {
        return $this->orderRepository->getUserOrders($userId);
    }

    public function getOrderDetails(int $orderId)
    {
        return $this->orderRepository->findById($orderId);
    }

    public function getAllOrders()
    {
        return $this->orderRepository->getAllOrders();
    }

    public function updateOrderStatus(int $orderId, string $status): bool
    {
        return $this->orderRepository->updateStatus($orderId, $status);
    }

    public function updatePaymentStatus(int $orderId, string $paymentStatus): bool
    {
        return $this->orderRepository->updatePaymentStatus($orderId, $paymentStatus);
    }
}
