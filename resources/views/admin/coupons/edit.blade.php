@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Coupon') }} - {{ $coupon->code }}
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Code</label>
                    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>Percentage</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Value</label>
                    <input type="number" step="0.01" name="value" value="{{ old('value', $coupon->value) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Minimum Order Amount</label>
                    <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Starts At</label>
                    <input type="date" name="starts_at" value="{{ old('starts_at', optional($coupon->starts_at)->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Expires At</label>
                    <input type="date" name="expires_at" value="{{ old('expires_at', optional($coupon->expires_at)->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-emerald-600 border-gray-300 rounded" {{ $coupon->is_active ? 'checked' : '' }} />
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition">Update Coupon</button>
            </div>
        </form>
    </div>
</div>
@endsection
