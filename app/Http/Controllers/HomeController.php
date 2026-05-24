<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $categories = Category::all();
        $homeData = $this->productService->getHomeProducts();

        return view('welcome', [
            'categories' => $categories,
            'featured' => $homeData['featured'],
            'trending' => $homeData['trending'],
            'popularProducts' => $homeData['popular'],
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
