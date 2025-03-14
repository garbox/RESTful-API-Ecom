<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\Admin;
use App\Models\ApiToken;

class ShippingCrudTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_can_create_a_shipping_info(){
        Artisan::call('app:admin-api-token');
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $user->api_token,
        ];

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
        $response = $this->postJson(route('shipping.store'), $shippingData , $headers);

        // Assert the user is created and the response is successful
        $response->assertStatus(201); // 201 Created
        $this->assertDatabaseHas('shippings', [
            'email' => $shippingData['email'],
        ]);
    }

    /** @test */
    public function it_can_read_a_shipping_info(){
        Artisan::call('app:admin-api-token');
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $shipping = Shipping::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $user->api_token,
        ];

        $response = $this->getJson(route('shipping.show', $shipping->id), $headers);
        $response->assertStatus(200); 
        $response->assertJson([
            'id' => $shipping->id,
            'email' => $shipping->email,
        ]);

        $response = $this->getJson(route('shipping.show', $shipping->id+1), $headers);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_update_a_shipping_info(){
        Artisan::call('app:admin-api-token');
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $shipping = Shipping::factory()->create();
        $token = ApiToken::pluck('api_token')->first();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $user->api_token,
        ];

        $updatedData = [
            'name' => $this->faker->name,  
            'email' => $this->faker->unique()->safeEmail,  
            'address' => $this->faker->address, 
            'city' => $this->faker->city, 
            'zip' => 78023, 
            'state' => $this->faker->state, 
            'phone' => $this->faker->phoneNumber, 
        ];

        $response = $this->putJson(route('shipping.update', $shipping->id),$updatedData ,$headers);

        $response->assertStatus(200); 
        $this->assertDatabaseHas('shippings', [
            'name' => $updatedData['name'],
            'email' => $updatedData['email'],
        ]);

        $response = $this->putJson(route('shipping.update', $shipping->id+100),$updatedData ,$headers);
        $response->assertStatus(404); 
    }
    
    /** @test */
    public function it_can_delete_a_shipping_info(){
        Artisan::call('app:admin-api-token');
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $admin = Admin::factory()->create();
        $shipping = Shipping::factory()->create();
        $token = ApiToken::pluck('api_token')->first();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $user->api_token,
        ];
        $response = $this->deleteJson(route('shipping.destroy', $shipping->id),[], $headers);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('shippings', [
            'id' => $shipping->id,
        ]);

        $response = $this->deleteJson(route('shipping.destroy', $shipping->id+100),[], $headers);
        $response->assertStatus(404);
    }
}
