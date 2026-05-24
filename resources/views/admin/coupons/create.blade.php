@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Create Coupon') }}
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Code</label>
                    <input type="text" name="code" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="fixed">Fixed Amount</option>
                        <option value="percentage">Percentage</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Value</label>
                    <input type="number" step="0.01" name="value" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Minimum Order Amount</label>
                    <input type="number" step="0.01" name="min_order_amount" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Starts At</label>
                    <input type="date" name="starts_at" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Expires At</label>
                    <input type="date" name="expires_at" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" checked />
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition">Create Coupon</button>
            </div>
        </form>
    </div>
</div>
@endsection
