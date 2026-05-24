@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Category</h2>
@endsection

@section('content')
<div class="max-w-2xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg p-6">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Whoops!</strong> Please fix the following errors:
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block font-medium text-sm text-gray-700" for="name">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
            </div>
            <div>
                <label class="block font-medium text-sm text-gray-700" for="image_url">Image URL (optional)</label>
                <input id="image_url" name="image_url" type="url" value="{{ old('image_url') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
            </div>
            <div class="flex items-center justify-end">
                <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-emerald-600 mr-4">Cancel</a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
