@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Revenue Widget -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900">Total Revenue</h3>
            <p class="mt-2 text-3xl font-bold text-emerald-600">${{ number_format($revenue, 2) }}</p>
        </div>
        <!-- Orders Count -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900">Orders</h3>
            <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $ordersCount }}</p>
        </div>
        <!-- Low Stock Products -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900">Low Stock</h3>
            <p class="mt-2 text-3xl font-bold text-red-600">{{ $lowStockProducts->count() }}</p>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Orders</h3>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($recentOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->order_number ?? $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 capitalize">{{ $order->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $recentOrders->links() }}
        </div>
    </div>
</div>
@endsection
