<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Models\Coupon;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected OrderService $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $sessionId = $request->session()->getId();
        $cart = $this->cartService->getCart($userId, $sessionId);

        if ($cart->items->where('save_for_later', false)->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $addresses = Address::where('user_id', $userId)->get();
        $defaultAddress = $addresses->where('is_default', true)->first() ?? $addresses->first();

        // Calculate summary values
        $subtotal = $cart->subtotal;
        $couponCode = $request->get('coupon_code');
        $discount = 0.00;
        $couponMessage = null;
        $couponSuccess = false;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValid()) {
                if ($subtotal >= $coupon->min_order_amount) {
                    $discount = $coupon->calculateDiscount($subtotal);
                    $couponSuccess = true;
                } else {
                    $couponMessage = "Coupon requires a minimum order amount of $" . number_format($coupon->min_order_amount, 2);
                }
            } else {
                $couponMessage = "Invalid or expired coupon code.";
            }
        }

        $deliveryFee = $subtotal > 50 ? 0.00 : 4.99;
        $tax = round(($subtotal - $discount) * 0.08, 2);
        $total = $subtotal - $discount + $deliveryFee + $tax;

        return view('checkout.index', [
            'cart' => $cart,
            'addresses' => $addresses,
            'defaultAddress' => $defaultAddress,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'deliveryFee' => $deliveryFee,
            'tax' => $tax,
            'total' => $total,
            'couponCode' => $couponCode,
            'couponSuccess' => $couponSuccess,
            'couponMessage' => $couponMessage
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,stripe,paypal',
            'coupon_code' => 'nullable|exists:coupons,code',
            'notes' => 'nullable|string|max:500'
        ]);

        $userId = Auth::id();
        $address = Address::where('user_id', $userId)->find($request->address_id);

        if (!$address) {
            return redirect()->back()->with('error', 'Invalid shipping address selected.');
        }

        $shippingAddressString = "{$address->name}\n{$address->address_line_1}" . 
            ($address->address_line_2 ? ", {$address->address_line_2}" : "") . 
            "\n{$address->city}, {$address->state} {$address->zip_code}\n{$address->country}\nPhone: {$address->phone}";

        $checkoutData = [
            'shipping_address' => $shippingAddressString,
            'payment_method' => $request->payment_method,
            'coupon_code' => $request->coupon_code,
            'notes' => $request->notes
        ];

        $result = $this->orderService->placeOrder($userId, $checkoutData);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->route('checkout.success')
            ->with('order_id', $result['order']->id)
            ->with('success', 'Thank you! Your order has been placed.');
    }

    public function success()
    {
        $orderId = session('order_id');
        $order = $this->orderService->getOrderDetails($orderId);
        if (!$order || $order->user_id !== Auth::id()) {
            abort(404);
        }

        return view('checkout.success', [
            'order' => $order
        ]);
    }
}
