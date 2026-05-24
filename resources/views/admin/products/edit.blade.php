@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Product</h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg p-6">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-medium text-sm text-gray-700" for="name">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
            </div>
            <div>
                <label class="block font-medium text-sm text-gray-700" for="description">Description</label>
                <textarea id="description" name="description" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="price">Price ($)</label>
                    <input id="price" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="discount_price">Discount Price ($)</label>
                    <input id="discount_price" name="discount_price" type="number" step="0.01" value="{{ old('discount_price', $product->discount_price) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="stock">Stock Quantity</label>
                    <input id="stock" name="stock" type="number" value="{{ old('stock', $product->stock) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="category_id">Category</label>
                    <select id="category_id" name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="brand_id">Brand</label>
                    <select id="brand_id" name="brand_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block font-medium text-sm text-gray-700" for="image_url">Image URL (optional)</label>
                    <input id="image_url" name="image_url" type="url" value="{{ old('image_url', $product->primary_image_url) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                </div>
                <div class="col-span-2">
                    <label class="block font-medium text-sm text-gray-700" for="image_file">Upload New Image (optional)</label>
                    <input id="image_file" name="image_file" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                </div>
            </div>
            <div class="flex items-center justify-end">
                <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-emerald-600 mr-4">Cancel</a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
