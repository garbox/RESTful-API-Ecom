<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductType;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_product(){
        $productType = ProductType::factory()->create();

        $productData = [
            'name' => Str::random(10),
            'price' => 5000,
            'short_description' => Str::random(25),
            'long_description' => Str::random(25),
            'product_type_id' => $productType->id,
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

        // Fetch the user using GET request
        $response = $this->getJson('/api/product/' . $product->id);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);
    }

    /** @test */
    public function it_can_update_a_product(){
        $productType = ProductType::factory()->create();
        $product = Product::factory()->create();

        $updatedData = [
            'name' => Str::random(10),
            'price' => 5000,
            'short_description' => Str::random(25),
            'long_description' => Str::random(25),
            'product_type_id' => $productType->id,
            'featured' => (bool) rand(0, 1),
            'available' => (bool) rand(0, 1), 
        ];
        
        $response = $this->putJson('/api/product/' . $product->id, $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'name' => $updatedData['name'],
        ]);
    }

    /** @test */
    public function it_can_delete_a_product(){
        ProductType::factory()->create();
        $product = Product::factory()->create();

        // Delete the user using DELETE request
        $response = $this->deleteJson('/api/product/' . $product->id);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK

        // Assert the user was deleted from the database
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    /** @test */
    public function can_display_avaliable_products(){
        ProductType::factory()->create();
        Product::factory()->create();

        $response = $this->getJson('/api/product/available');

        $response->assertStatus(200); 
    }

    /** @test */
    public function can_display_featured_products(){
        ProductType::factory()->create();
        Product::factory()->create();

        $response = $this->getJson('/api/product/featured');

        $response->assertStatus(200); 
    }
}
