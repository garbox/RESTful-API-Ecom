<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use App\Models\Category;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_product_type(){

        $category = [
            'name' => Str::random(10),
        ];

        $response = $this->postJson('/api/category', $category);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'name' => $category['name'],
        ]);
    }
    
    /** @test */
    public function it_can_read_a_product_type(){
        $category = Category::factory()->create();
        
        $response = $this->getJson('/api/category/' . $category->id);
        $response->assertStatus(200); 
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);

        $response = $this->getJson('/api/category/' . $category->id+1);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_update_a_product_type(){
        $productType = Category::factory()->create();

        $updatedData = [
            'name' => Str::random(10), 
        ];
        
        $response = $this->putJson('/api/category/' . $category->id, $updatedData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', [
            'name' => $updatedData['name'],
        ]);

        $response = $this->putJson('/api/category/' . $category->id+1, $updatedData);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_delete_a_product_type(){
        $productType = category::factory()->create();

        $response = $this->deleteJson('/api/category/' . $productType->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', [
            'id' => $productType->id,
        ]);

        $response = $this->deleteJson('/api/prodtype/' . $productType->id+1);
        $response->assertStatus(404);
    }
}
