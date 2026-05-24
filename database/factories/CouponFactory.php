<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Coupon>
 */
class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition()
    {
        return [
            'code' => strtoupper(Str::random(8)),
            'type' => $this->faker->randomElement(['fixed', 'percentage']),
            'value' => $this->faker->randomFloat(2, 5, 100),
            'min_order_amount' => $this->faker->randomFloat(2, 0, 50),
            'starts_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'expires_at' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'is_active' => true,
        ];
    }
}
