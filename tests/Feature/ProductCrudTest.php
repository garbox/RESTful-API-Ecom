<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_product(){
        $category = Category::factory()->create();

        $productData = [
            'name' => Str::random(10),
            'price' => 5000,
            'short_description' => Str::random(25),
            'long_description' => Str::random(25),
            'product_type_id' => $category->id,
            'featured' => (bool) rand(0, 1),
            'available' => (bool) rand(0, 1), 
        ];

        $response = $this->postJson('/api/product', $productData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'name' => $productData['name'],
        ]);
    }
    
    /** @test */
    public function it_can_read_a_product(){
        ProductType::factory()->create();
        $product = Product::factory()->create();

        $response = $this->getJson('/api/product/' . $product->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);

        $response = $this->getJson('/api/product/' . $product->id+1);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_update_a_product(){
        $category = Category::factory()->create();
        $product = Product::factory()->create();

        $updatedData = [
            'name' => Str::random(10),
            'price' => 5000,
            'short_description' => Str::random(25),
            'long_description' => Str::random(25),
            'product_type_id' => $category->id,
            'featured' => (bool) rand(0, 1),
            'available' => (bool) rand(0, 1), 
        ];
        
        $response = $this->putJson('/api/product/' . $product->id, $updatedData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'name' => $updatedData['name'],
        ]);

        $response = $this->putJson('/api/product/' . $product->id+1, $updatedData);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_delete_a_product(){
        Category::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/product/' . $product->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);

        $response = $this->deleteJson('/api/product/' . $product->id+1);
        $response->assertStatus(404);
    }

    /** @test */
    public function can_display_avaliable_products(){
        $response = $this->getJson('/api/product/available');
        $response->assertStatus(404); 

        Category::factory()->create();
        Product::factory()->create();

        $response = $this->getJson('/api/product/available');
        $response->assertStatus(200); 
    }

    /** @test */
    public function can_display_featured_products(){
        $response = $this->getJson('/api/product/featured');
        $response->assertStatus(404); 

        Category::factory()->create();
        Product::factory()->create();

        $response = $this->getJson('/api/product/featured');
        $response->assertStatus(200); 
    }
}
