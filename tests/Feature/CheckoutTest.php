<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_view_checkout_page()
    {
        $product = Product::factory()->create(['price' => 10.00]);
        $response = $this->get(route('checkout.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_apply_valid_coupon_and_complete_order()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 50.00]);
        $coupon = Coupon::factory()->create([
            'code' => 'SAVE10',
            'type' => 'fixed',
            'value' => 10,
            'min_order_amount' => 20,
            'is_active' => true,
        ]);

        // Add product to cart
        $this->actingAs($user)
            ->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);

        // Apply coupon and checkout
        $address = \App\Models\Address::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'coupon_code' => $coupon->code,
            'address_id' => $address->id,
            'payment_method' => 'cod',
        ]);

        $response->assertRedirect(route('checkout.success'));
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total' => 40.00, // 50 - 10 coupon
        ]);
    }
}
