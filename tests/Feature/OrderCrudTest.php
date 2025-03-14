<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Category;
use App\Models\ApiToken;
use App\Models\Admin;
use Tests\TestCase;

class OrderCrudTest extends TestCase
{
    //use RefreshDatabase;
    
    /** @test */
    public function it_can_create_an_order(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        Admin::factory()->create();
        $user = User::factory()->create();
        Category::factory()->create();
        Product::factory()->create();
        Cart::factory(5)->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $user->api_token,
        ];

        $body = [
            'stripe_payment_intent_id' => STR::random(20),
            'shipping_name' => 'Kyle Metiver',
            'shipping_email' => 'SomeEmail@email.com',
            'shipping_phone' => '1234567890',
            'shipping_address' => '1234 Some St',
            'shipping_zip' => '12345',
            'shipping_city' => 'Some City',
            'shipping_state' => 'Some State',
        ];

        $response = $this->postJson(route('order.create'), $body, $headers);

        $response->assertStatus(200);

    }
    
    /** @test */
    public function it_can_read_a_order(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();
        User::factory()->create();
        Category::factory()->create();
        Product::factory()->create();
        $order = Order::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $admin->api_token,
        ];


        // Fetch the user using GET request
        $response = $this->getJson(route('admin.orders.show',$order->id), $headers);
        
        // Assert the response is successful
        $response->assertStatus(200); // 200 OK
        $this->assertDatabaseHas('orders', [
            'user_id' => $order->user_id,
        ]);
    }

    /** @test */
    public function it_can_update_a_order(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        User::factory()->create();
        $admin = Admin::factory()->create();
        Category::factory()->create();
        Product::factory()->create();
        $order = Order::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => $admin->api_token,
        ];

        $body = [
            'total_price' => 1000,
        ];

        $response = $this->putJson(route('order.update', $order->id), $body, $headers);

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'total_price' => $body['total_price'],
        ]);
    }

    /** @test */
    public function it_can_delete_a_order(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        User::factory()->create();
        $admin = Admin::factory()->create();
        Category::factory()->create();
        Product::factory()->create();
        $order = Order::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $admin->api_token,
        ];

        $response = $this->getJson(route('order.destroy', $order->id), $headers);

        $response->assertStatus(200);

        $response = $this->getJson(route('order.destroy', $order->id+1), $headers);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_get_orders_by_user(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $user = User::factory()->create();
        $admin = Admin::factory()->create();
        Category::factory()->create();
        Product::factory()->create();
        Order::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $admin->api_token,
        ];


        // Fetch the user using GET request
        $response = $this->getJson(route('order.user', $user->id), $headers);

        $response->assertStatus(200);
    }
}
