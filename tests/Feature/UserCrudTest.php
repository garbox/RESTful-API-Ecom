<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shipping;
use App\Models\Cart;
use App\Models\ApiToken;


class UserCrudTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_can_create_a_user(){
        Artisan::call('app:admin-api-token');;
        $token = ApiToken::pluck('api_token')->first();

        $headers = [
            'GLOBAL-API-KEY' => $token,
        ];

        $userData = [
            'name' => $this->faker->name,
            'email' => 'john@example.com',
            'email_confirmation' => 'john@example.com',
            'state' => $this->faker->state,
            'zip' => 78023,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Create a new user using POST request
        $response = $this->postJson(route('user.create'), $userData, $headers);

        // Assert the user is created and the response is successful
        $response->assertStatus(201); // 201 Created
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com'
        ]);
    }

    /** @test */
    public function it_can_read_a_user(){
        $user = User::factory()->create();
        Artisan::call('app:admin-api-token');;
        $token = ApiToken::pluck('api_token')->first();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => $user->api_token,
        ];

        // Fetch the user using GET request
        $response = $this->getJson(route('user.get'), $headers);

        $response->assertStatus(200); 

        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => "user->api_token"
        ];
        $response = $this->getJson(route('user.get'), $headers);
        $response->assertStatus(400); 
    }

    /** @test */
    public function it_can_update_a_user(){
        $user = User::factory()->create();
        Artisan::call('app:admin-api-token');;
        $token = ApiToken::pluck('api_token')->first();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => $user->api_token,
        ];

        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        $response = $this->putJson(route('user.update'), $updatedData, $headers);
        $response->assertStatus(200); 

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'jane@example.com',
        ]);

        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => "user->api_token"
        ];
        $response = $this->putJson(route('user.update'), $updatedData, $headers);
        $response->assertStatus(400); 
    }

    /** @test */
    public function it_can_delete_a_user(){
        $user = User::factory()->create();
        Artisan::call('app:admin-api-token');;
        $token = ApiToken::pluck('api_token')->first();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => $user->api_token,
        ];

        $response = $this->deleteJson(route('user.destroy'), [], $headers);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
    
    /** @test */
    public function it_can_get_orders_for_a_user(){
        $user = User::factory()->create();
        Artisan::call('app:admin-api-token');;
        $token = ApiToken::pluck('api_token')->first();
        Category::factory()->create();
        Product::factory()->create();
        Order::factory()->create();
        Shipping::factory()->create();
        
        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => $user->api_token,
        ];

        $response = $this->getJson(route('user.orders'), $headers);
        $response->assertStatus(200); 

        $response = $this->getJson('/api/user/' . 50 . '/orders');
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_get_shipping_info_for_a_user(){
        $user = User::factory()->create();
        Artisan::call('app:admin-api-token');;
        $token = ApiToken::pluck('api_token')->first();
        Category::factory()->create();
        Product::factory()->create();
        Order::factory()->create();
        Shipping::factory()->create();
        
        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => $user->api_token,
        ];
        
        $response = $this->getJson(route('user.shipping'), $headers);
        $response->assertStatus(200); 

        $response = $this->getJson('/api/user/' . 50 . '/shipping');
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_get_cart_info_for_a_user(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $user = User::factory()->create();
        Category::factory()->create();
        Product::factory()->create();
        Cart::factory()->create();
        Order::factory()->create();
        Shipping::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => $user->api_token,
        ];
        
        $response = $this->getJson(route('user.cart', $user->id), $headers);

        $response->assertStatus(200); 
    }
}
