<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin – Categories</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="inline-block mb-4 px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition">Add New Category</a>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Slug</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $category->id }}</td>
                            <td class="px-4 py-2">{{ $category->name }}</td>
                            <td class="px-4 py-2">{{ $category->slug }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-teal-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
