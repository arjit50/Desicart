@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Order Details') }} – {{ $order->order_number ?? $order->id }}
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
        <p><strong>Name:</strong> {{ $order->user->name ?? 'Guest' }}</p>
        <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
        <p><strong>Placed on:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>

        <h3 class="text-lg font-medium text-gray-900 mt-6 mb-4">Order Items</h3>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->product->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">${{ number_format($item->price, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 text-right text-xl font-semibold">
            Total: ${{ number_format($order->total, 2) }}
        </div>

        <h3 class="text-lg font-medium text-gray-900 mt-6 mb-4">Status</h3>
        <p class="mb-2"><strong>Current Status:</strong> {{ ucfirst($order->status) }}</p>
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="inline-block">
            @csrf
            @method('PUT')
            <select name="status" class="border border-gray-300 rounded" onchange="this.form.submit()">
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </form>
    </div>
</div>
@endsection
