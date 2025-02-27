<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Cart;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ApiToken;
use App\Models\Category;
use Tests\TestCase;


class CartCrudTest extends TestCase
{
    // Use RefreshDatabase to ensure the database is rolled back after each test
    use RefreshDatabase;
    
    /** @test */
    public function it_can_create_an_cart_no_session(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $user = User::factory()->create();

        Category::factory()->create();
        Product::factory()->create();
        User::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
        ];

        $cartData = [
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => 1,
            'user_id' => User::inRandomOrder()->first()->id,
        ];

        $response = $this->postJson(route('cart.create'), $cartData, $headers);

        $response->assertStatus(201);
        $this->assertDatabaseHas('carts', [
            'product_id' => $cartData['product_id'],
            'session_id' => !empty($cartData['session_id']),
        ]);
    }

    /** @test */
    public function it_can_create_an_cart_with_session(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $user = User::factory()->create();

        Category::factory()->create();
        Product::factory()->create();
        User::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
        ];

        $cartData = [
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => 1,
            'session_id' => Str::random(34),
            'user_id' => User::inRandomOrder()->first()->id,
        ];

        $response = $this->postJson(route('cart.create'), $cartData, $headers);

        $response->assertStatus(201);
        $this->assertDatabaseHas('carts', [
            'product_id' => $cartData['product_id'],
            'session_id' => $cartData['session_id'],
        ]);
    }

    /** @test */
    public function it_can_create_an_cart_user_logged_in(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $user = User::factory()->create();

        Category::factory()->create();
        Product::factory()->create();
        User::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            "USER-API-KEY" => $user->api_token,
        ];

        $cartData = [
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => 1,
            'session_id' => $user->api_token,
            'user_id' => $user->id,
        ];

        $response = $this->postJson(route('cart.create'), $cartData, $headers);

        $response->assertStatus(201);
        $this->assertDatabaseHas('carts', [
            'product_id' => $cartData['product_id'],
            'session_id' => $cartData['session_id'],
        ]);
    }

    /** @test */
    public function it_can_read_cart_session_id(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        
        Category::factory()->create();
        Product::factory()->create();
        $user = User::factory()->create();
        $cart = Cart::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'session_id' => $cart->session_id
        ];

        $response = $this->getJson(route('cart.get'), $headers);
        
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('carts', [
            'product_id' => $cart->product_id,
            'session_id' => $headers['session_id']
        ]);
    }

    /** @test */
    public function it_can_read_cart_user_logged_in(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        
        Category::factory()->create();
        Product::factory()->create();
        $user = User::factory()->create();
        $cart = Cart::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $user->api_token
        ];

        $response = $this->getJson(route('cart.get'), $headers);
        
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('carts', [
            'product_id' => $cart->product_id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function it_can_update_a_cart(){
        Artisan::call('app:admin-api-token');
        Category::factory()->create();
        Product::factory()->create();
        $user = User::factory()->create();
        $cart = Cart::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        
        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $user->api_token
        ];

        $updatedData = [
            'cart_id' => $cart->id,
            'quantity' => 10,
        ];

        $response = $this->putJson(route('cart.update', $cart->id), $updatedData, $headers);

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('carts', [
            'quantity' => $updatedData['quantity'],
        ]);

        $updatedData = [
            'cart_id' => $cart->id+100,
            'quantity' => 10,
        ];
        $response = $this->putJson(route('cart.update', $cart->id), $updatedData, $headers);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_delete_a_cart(){
        Artisan::call('app:admin-api-token');
        Category::factory()->create();
        Product::factory()->create();
        User::factory()->create();
        $cart = Cart::factory()->create();
        $token = ApiToken::pluck('api_token')->first();

        $headers = [
            'GLOBAL-API-KEY' => $token,
        ];

        $body = [
            'cart_id' => $cart->id,
        ];

        $response = $this->deleteJson(route('cart.destory'), $body, $headers);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('carts', [
            'id' => $cart->id,
        ]);

        $body = [
            'cart_id' => $cart->id+100,
        ];

        $response = $this->deleteJson(route('cart.destory'), $body, $headers);
        $response->assertStatus(404); 
    }
}
