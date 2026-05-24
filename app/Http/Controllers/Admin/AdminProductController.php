<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\InventoryLog;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::with(['category', 'brand'])->paginate(10);
        return view('admin.products.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', [
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048'
        ]);

        $slug = Str::slug($request->name) . '-' . time();

        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'rating' => 5.0
        ]);

        // Handle Image
        $imageUrl = 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80'; // Default placeholder

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif ($request->image_url) {
            $imageUrl = $request->image_url;
        }

        ProductImage::create([
            'product_id' => $product->id,
            'url' => $imageUrl,
            'is_primary' => true
        ]);

        // Create Inventory Log
        InventoryLog::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'quantity' => $request->stock,
            'type' => 'restock',
            'description' => 'Initial stock creation'
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048'
        ]);

        $oldStock = $product->stock;
        $newStock = $request->stock;
        
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
        ]);

        // Update image if provided
        if ($request->hasFile('image_file') || $request->image_url) {
            $imageUrl = '';
            if ($request->hasFile('image_file')) {
                $path = $request->file('image_file')->store('products', 'public');
                $imageUrl = '/storage/' . $path;
            } else {
                $imageUrl = $request->image_url;
            }

            // Mark old images as not primary
            ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);

            ProductImage::create([
                'product_id' => $product->id,
                'url' => $imageUrl,
                'is_primary' => true
            ]);
        }

        // Inventory logging if stock changed
        if ($newStock != $oldStock) {
            $diff = $newStock - $oldStock;
            InventoryLog::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'quantity' => $diff,
                'type' => $diff > 0 ? 'restock' : 'adjustment',
                'description' => 'Stock updated in admin panel'
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product soft deleted successfully.');
    }

    public function logs($id)
    {
        $product = Product::findOrFail($id);
        $logs = InventoryLog::where('product_id', $id)->with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.products.logs', [
            'product' => $product,
            'logs' => $logs
        ]);
    }
}
