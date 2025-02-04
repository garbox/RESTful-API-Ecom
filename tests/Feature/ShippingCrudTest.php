<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shipping;
use App\Models\Order;

class ShippingCrudTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_can_create_a_shipping_info(){
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $shippingData = [
            'name' => $this->faker->name,  
            'email' => $this->faker->unique()->safeEmail,  
            'address' => $this->faker->address, 
            'city' => $this->faker->city, 
            'zip' => 78021, 
            'state' => $this->faker->state, 
            'phone' => $this->faker->phoneNumber, 
            'user_id' => $user->id, 
            'order_id' => $order->id,
        ];

        // Create a new user using POST request
        $response = $this->postJson('/api/shipping', $shippingData);

        // Assert the user is created and the response is successful
        $response->assertStatus(201); // 201 Created
        $this->assertDatabaseHas('shippings', [
            'email' => $shippingData['email'],
        ]);
    }

    /** @test */
    public function it_can_read_a_shipping_info(){
        User::factory()->create();
        Order::factory()->create();
        $shipping = Shipping::factory()->create();

        $response = $this->getJson('/api/shipping/' . $shipping->id);
        $response->assertStatus(200); 
        $response->assertJson([
            'id' => $shipping->id,
            'email' => $shipping->email,
        ]);

        $response = $this->getJson('/api/shipping/' . $shipping->id+1);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_update_a_shipping_info(){
        User::factory()->create();
        Order::factory()->create();
        $shipping = Shipping::factory()->create();

        $updatedData = [
            'name' => $this->faker->name,  
            'email' => $this->faker->unique()->safeEmail,  
            'address' => $this->faker->address, 
            'city' => $this->faker->city, 
            'zip' => 78023, 
            'state' => $this->faker->state, 
            'phone' => $this->faker->phoneNumber, 
        ];

        $response = $this->putJson('/api/shipping/' . $shipping->id, $updatedData);
        $response->assertStatus(200); 
        $this->assertDatabaseHas('shippings', [
            'name' => $updatedData['name'],
            'email' => $updatedData['email'],
        ]);

        $response = $this->putJson('/api/shipping/' . $shipping->id+1, $updatedData);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_delete_a_shipping_info(){
        User::factory()->create();
        Order::factory()->create();
        $shipping = Shipping::factory()->create();

        $response = $this->deleteJson('/api/shipping/' . $shipping->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('shippings', [
            'id' => $shipping->id,
        ]);

        $response = $this->deleteJson('/api/shipping/' . $shipping->id+1);
        $response->assertStatus(404);
    }
}
