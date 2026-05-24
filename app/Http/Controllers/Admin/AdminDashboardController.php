<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $revenue = Order::where('payment_status', 'paid')->sum('total');
        $ordersCount = Order::count();
        $productsCount = Product::count();
        $usersCount = User::role('customer')->count();

        // Low stock threshold
        $lowStockProducts = Product::where('stock', '<', 15)->get();

        // Recent Orders
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        // Monthly sales metrics
        $salesData = Order::select(
                DB::raw('strftime("%m", created_at) as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->where('payment_status', 'paid')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return view('admin.dashboard', [
            'revenue' => $revenue,
            'ordersCount' => $ordersCount,
            'productsCount' => $productsCount,
            'usersCount' => $usersCount,
            'lowStockProducts' => $lowStockProducts,
            'recentOrders' => $recentOrders,
            'salesData' => $salesData
        ]);
    }
}
