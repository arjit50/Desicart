<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function getQuery(): Builder
    {
        return Product::query()->with(['category', 'brand', 'images']);
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)
            ->with(['category', 'brand', 'images', 'reviews.user'])
            ->first();
    }

    public function getFeatured(int $limit = 8): Collection
    {
        return Product::with(['category', 'brand', 'images'])
            ->orderByDesc('rating')
            ->limit($limit)
            ->get();
    }

    public function getTrendingDeals(int $limit = 8): Collection
    {
        return Product::with(['category', 'brand', 'images'])
            ->whereNotNull('discount_price')
            ->orderByRaw('(price - discount_price) DESC')
            ->limit($limit)
            ->get();
    }

    public function getPopular(int $limit = 8): Collection
    {
        return Product::with(['category', 'brand', 'images'])
            ->orderByDesc('rating')
            ->limit($limit)
            ->get();
    }

    public function updateStock(int $productId, int $quantity): bool
    {
        $product = Product::find($productId);
        if ($product) {
            $product->stock = max(0, $product->stock + $quantity);
            return $product->save();
        }
        return false;
    }
}
