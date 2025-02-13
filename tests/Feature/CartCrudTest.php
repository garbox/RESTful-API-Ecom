<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Tests\TestCase;


class CartCrudTest extends TestCase
{
    // Use RefreshDatabase to ensure the database is rolled back after each test
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_cart(){
        Category::factory()->create();
        Product::factory()->create();
        User::factory()->create();

        $cartData = [
            'product_id' => Product::inRandomOrder()->first()->id,
            'session_id' => Str::random(25),
            'quantity' => 1,
            'user_id' => User::inRandomOrder()->first()->id,
        ];

        $response = $this->postJson('/api/cart', $cartData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('carts', [
            'product_id' => $cartData['product_id'],
        ]);
    }

    /** @test */
    public function it_can_read_cart(){
        Category::factory()->create();
        Product::factory()->create();
        User::factory()->create();
        $cart = Cart::factory()->create();

        $response = $this->getJson('/api/cart/' . $cart->id);
        $response->assertStatus(200); // 200 OK
        $this->assertDatabaseHas('carts', [
            'product_id' => $cart->product_id,
        ]);

        $response = $this->getJson('/api/cart/' . $cart->id+1);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_update_a_cart(){
        Category::factory()->create();
        Product::factory()->create();
        User::factory()->create();
        $cart = Cart::factory()->create();

        $updatedData = [
            'quantity' => 10,
        ];

        $response = $this->putJson('/api/cart/' . $cart->id, $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('carts', [
            'quantity' => $updatedData['quantity'],
        ]);

        $response = $this->putJson('/api/cart/' . $cart->id+1, $updatedData);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_delete_a_cart(){
        Category::factory()->create();
        Product::factory()->create();
        User::factory()->create();
        $cart = Cart::factory()->create();

        $response = $this->deleteJson('/api/cart/' . $cart->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('carts', [
            'id' => $cart->id,
        ]);

        $response = $this->deleteJson('/api/cart/' . $cart->id);
        $response->assertStatus(404); 
    }
}
