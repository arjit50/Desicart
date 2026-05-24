@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Inventory Logs') }} – {{ $product->name }}
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    
    <!-- Back and Product overview banner -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-650 hover:text-indigo-800">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Product Management
        </a>
        <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4 text-xs font-bold text-slate-500">
            <div>
                Current Stock: <strong class="text-slate-800 text-sm ml-1">{{ $product->stock }} units</strong>
            </div>
            <span class="w-px h-4 bg-slate-200"></span>
            <div>
                Price: <strong class="text-emerald-600 text-sm ml-1">${{ number_format($product->final_price, 2) }}</strong>
            </div>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-200">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-900">Adjustment History</h3>
            <p class="text-xs text-slate-500 mt-1">Audit log of all stock increases and sales deductions.</p>
        </div>
        
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5 text-left">Date & Time</th>
                    <th class="px-6 py-3.5 text-left">Operator</th>
                    <th class="px-6 py-3.5 text-left">Log Type</th>
                    <th class="px-6 py-3.5 text-right">Quantity</th>
                    <th class="px-6 py-3.5 text-left">Description</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100 text-slate-700 text-sm">
                @forelse($logs as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                            {{ $log->created_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">
                            {{ $log->user->name ?? 'System Process' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-bold">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 capitalize
                                {{ $log->type === 'restock' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $log->type === 'sale' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $log->type === 'adjustment' ? 'bg-amber-100 text-amber-800' : '' }}">
                                {{ $log->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right font-mono font-bold">
                            @if($log->quantity > 0)
                                <span class="text-emerald-600">+{{ $log->quantity }}</span>
                            @elseif($log->quantity < 0)
                                <span class="text-red-500">{{ $log->quantity }}</span>
                            @else
                                <span class="text-slate-500">{{ $log->quantity }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-550 max-w-xs truncate">
                            {{ $log->description }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                            <i class="fa-solid fa-list-check text-slate-200 text-3xl mb-3 block"></i>
                            No inventory logs recorded for this product.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
