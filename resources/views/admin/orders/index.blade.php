@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Orders Management') }}
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-slate-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-5 0 uppercase tracking-wider">Placed</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $order->order_number ?? $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">${{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $order->status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-slate-100 text-slate-800' : '' }}
                            ">{{ $order->status }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">View</a>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline" onsubmit="return confirm('Change status?');">
                                @csrf
                                @method('PUT')
                                <select name="status" class="border border-gray-300 rounded text-xs" onchange="this.form.submit()">
                                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                        <option value="{{ $s }}" {{ $order->status=== $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
