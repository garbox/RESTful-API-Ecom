<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ProductType;
use Tests\TestCase;

class OrderCrudTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_can_create_an_order(){
        $user = User::factory()->create();

        $orderData = [
            'user_id' => $user->id,
            'total_price' => 5000,
            'stripe_payment_intent_id' => Str::random(25),
        ];

        $response = $this->postJson('/api/order', $orderData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', [
            'user_id' => $orderData['user_id'],
        ]);
    }

    /** @test */
    public function it_can_read_a_order(){
        User::factory()->create();
        ProductType::factory()->create();
        Product::factory()->create();
        $order = Order::factory()->create();

        // Fetch the user using GET request
        $response = $this->getJson('/api/order/' . $order->id);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK
        $this->assertDatabaseHas('orders', [
            'user_id' => $order->user_id,
        ]);
    }

    /** @test */
    public function it_can_update_a_order(){
        User::factory()->create();
        ProductType::factory()->create();
        Product::factory()->create();
        $order = Order::factory()->create();

        $updatedData = [
            'total_price' => 500000,
        ];

        $response = $this->putJson('/api/order/' . $order->id, $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'total_price' => $updatedData['total_price'],
        ]);
    }

    /** @test */
    public function it_can_delete_a_order(){
        User::factory()->create();
        ProductType::factory()->create();
        Product::factory()->create();
        $order = Order::factory()->create();

        // Delete the user using DELETE request
        $response = $this->deleteJson('/api/order/' . $order->id);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK

        // Assert the user was deleted from the database
        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }

    /** @test */
    public function it_can_get_orders_by_user(){
        $user = User::factory()->create();
        ProductType::factory()->create();
        Product::factory()->create();
        $order = Order::factory()->create();
        Shipping::factory()->create();

        $response = $this->getJson('/api/order/user/'. $user->id);

        $response->assertStatus(200);
    }
}
