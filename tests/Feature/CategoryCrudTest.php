<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Admin;
use App\Models\ApiToken;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_product_type(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $admin->api_token,
        ];

        $category = [
            'name' => Str::random(10),
        ];

        $response = $this->postJson(route('category.store'), $category, $headers);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'name' => $category['name'],
        ]);
    }
    
    /** @test */
    public function it_can_read_a_product_type(){
        $category = Category::factory()->create();
        Artisan::call('app:admin-api-token');
        $admin = Admin::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        
        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $admin->api_token,
        ];

        $response = $this->getJson(route('category.show', $category->id), $headers);
        $response->assertStatus(200); 
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);

        $response = $this->getJson(route('category.show', $category->id+1), $headers);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_update_a_product_type(){
        Artisan::call('app:admin-api-token');
        $category = Category::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();
        
        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $admin->api_token,
        ];

        $updatedData = [
            'name' => Str::random(10), 
        ];
        
        $response = $this->putJson(route('category.update', $category->id), $updatedData, $headers);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', [
            'name' => $updatedData['name'],
        ]);

        $response = $this->putJson(route('category.update', $category->id+1), $updatedData, $headers);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_delete_a_product_type(){
        Artisan::call('app:admin-api-token');
        $category = Category::factory()->create();
        $admin = Admin::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        Log::alert($category);
        Log::alert($admin);
        Log::alert($token);

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $admin->api_token
        ];

        Log::alert($headers);
        $response = $this->deleteJson(route('category.destroy' , $category->id), [],$headers );
        Log::alert($response->json());
        $response->assertStatus(200);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);

        $response = $this->deleteJson(route('category.destroy' , $category->id+1), $headers );
        $response->assertStatus(404);
    }
}
