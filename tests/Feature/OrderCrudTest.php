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
        //create user
        //create prod types
        //create prod
        //create cart items
        //create order from cart items
        //get total price from cart items and 
        // send to get payment intent id. 
        //if working create order items from cart items, 
        //create order with total price, user_id and stripe intent id. 
        $user = User::factory()->create();

        $orderData = [
            'user_id' => $user->id,
            'total_price' => 5000,
            'stripe_payment_intent_id' => Str::random(25),
        ];

        $response = $this->postJson(route('order.create'), $orderData);

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

        $response = $this->putJson('/api/order/' . $order->id+1, $updatedData);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_delete_a_order(){
        User::factory()->create();
        ProductType::factory()->create();
        Product::factory()->create();
        $order = Order::factory()->create();

        $response = $this->deleteJson('/api/order/' . $order->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);

        $response = $this->deleteJson('/api/order/'. $order->id+1);
        $response->assertStatus(404);
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

        $response = $this->getJson('/api/order/user/'. $user->id+1);
        $response->assertStatus(404);
    }
}
