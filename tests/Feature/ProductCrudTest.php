<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Admin;
use App\Models\ApiToken;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_product(){
        Artisan::call('app:admin-api-token');
        $category = Category::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            "USER_API_KEY" => $admin->api_token
        ];

        $productData = [
            'name' => Str::random(10),
            'price' => rand(300, 10000),
            'short_description' => Str::random(25),
            'long_description' => Str::random(25),
            'category_id' => $category->id,
            'featured' => (bool) rand(0, 1),
            'available' => (bool) rand(0, 1), 
        ];

        $response = $this->postJson(route('product.create'), $productData, $headers);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'name' => $productData['name'],
        ]);
    }
    
    /** @test */
    public function it_can_read_a_product(){
        Artisan::call('app:admin-api-token');
        Category::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();
        $product = Product::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            "USER_API_KEY" => $admin->api_token
        ];

        $response = $this->getJson(route('product.show', $product->id), $headers);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);

        $response = $this->getJson('/api/product/' . $product->id+1);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_update_a_product(){
        Artisan::call('app:admin-api-token');
        $category = Category::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();
        $product = Product::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            "USER_API_KEY" => $admin->api_token
        ];

        $updatedData = [
            'name' => Str::random(10),
            'price' => 5000,
            'short_description' => Str::random(25),
            'long_description' => Str::random(25),
            'category_id' => $category->id,
            'featured' => (bool) rand(0, 1),
            'available' => (bool) rand(0, 1), 
        ];
        
        $response = $this->putJson(route('product.update', $product->id), $updatedData ,  $headers);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'name' => $updatedData['name'],
        ]);

        $response = $this->putJson('/api/product/' . $product->id+1, $updatedData);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_delete_a_product(){
        Artisan::call('app:admin-api-token');
        Category::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();
        $product = Product::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => $admin->api_token
        ];

        $response = $this->deleteJson(route('product.destroy', $product->id),[], $headers);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);

        $response = $this->deleteJson(route('product.destroy', $product->id+100),[], $headers);
        $response->assertStatus(404);
    }

    /** @test */
    public function can_display_avaliable_products(){
        Artisan::call('app:admin-api-token');
        Category::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();
        Product::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => $admin->api_token
        ];

        $response = $this->getJson(route('product.avaliable'), $headers);
        $response->assertStatus(200); 

        $response = $this->getJson('/api/product/available');
        $response->assertStatus(404); 
    }

    /** @test */
    public function can_display_featured_products(){
        Artisan::call('app:admin-api-token');
        Category::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();
        Product::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            'USER_API_KEY' => $admin->api_token
        ];

        $response = $this->getJson(route('product.featured'), $headers);
        $response->assertStatus(200); 
    }
}
