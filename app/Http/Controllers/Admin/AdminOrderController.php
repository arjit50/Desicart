<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    protected OrderService $orderService;
    protected ProductService $productService;

    public function __construct(OrderService $orderService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }

    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', [
            'orders' => $orders
        ]);
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderDetails($id);
        if (!$order) {
            abort(404);
        }

        return view('admin.orders.show', [
            'order' => $order
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) {
            return redirect()->back()->with('info', 'Status is already set to ' . $newStatus);
        }

        // If order is cancelled, return items to inventory stock!
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $this->productService->updateInventory(
                    $item->product_id,
                    $item->quantity, // Return stock (positive number)
                    'return',
                    "Cancelled order refund: {$order->order_number}",
                    Auth::id()
                );
            }
        }

        // If order was cancelled and is now set back to active status (re-opened)
        if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $this->productService->updateInventory(
                    $item->product_id,
                    -$item->quantity, // Deduct stock (negative number)
                    'sale',
                    "Re-opened order reservation: {$order->order_number}",
                    Auth::id()
                );
            }
        }

        $this->orderService->updateOrderStatus($id, $newStatus);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded'
        ]);

        $this->orderService->updatePaymentStatus($id, $request->payment_status);

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }
}
