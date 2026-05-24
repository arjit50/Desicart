<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function catalog_page_is_accessible()
    {
        // Create sample data
        $category = Category::factory()->create(['name' => 'Fruits']);
        $brand = Brand::factory()->create(['name' => 'FreshCo']);
        Product::factory()->count(3)->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
        $response->assertSee($category->name);
        $response->assertSee($brand->name);
    }

    /** @test */
    public function product_detail_page_shows_correct_information()
    {
        $product = Product::factory()->create(['name' => 'Apple', 'price' => 2.50]);
        $response = $this->get(route('products.show', $product->slug));
        $response->assertStatus(200);
        $response->assertSee('Apple');
        $response->assertSee('2.50');
    }
}
