<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<Product> */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'slug' => Str::slug($this->faker->words(3, true)),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 5, 200),
            'discount_price' => $this->faker->optional()->randomFloat(2, 1, 150),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'stock' => $this->faker->numberBetween(0, 100),
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
