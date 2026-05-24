<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<Category> */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $name = $this->faker->word();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => $this->faker->imageUrl(640, 480, 'food'),
        ];
    }
}
