<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048'
        ]);

        $imageUrl = 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80'; // default placeholder

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('categories', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif ($request->image_url) {
            $imageUrl = $request->image_url;
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imageUrl
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048'
        ]);

        $imageUrl = $category->image;

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('categories', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif ($request->image_url) {
            $imageUrl = $request->image_url;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imageUrl
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category that contains products.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
