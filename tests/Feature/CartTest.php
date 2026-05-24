<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_product_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 10]);

        $response = $this->actingAs($user)
            ->post(route('cart.store'), [
                'product_id' => $product->id,
                'quantity' => 2,
            ]);

        $response->assertRedirect(route('cart.index'));
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    /** @test */
    public function user_can_remove_product_from_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 5]);
        $cart = Cart::create(['user_id' => $user->id]);
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
            'save_for_later' => false,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('cart.destroy', $product->id));

        $response->assertRedirect(route('cart.index'));
        $this->assertDatabaseMissing('cart_items', [
            'product_id' => $product->id,
        ]);
    }
}
