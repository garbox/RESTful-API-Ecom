<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use App\Models\ProductType;
use Tests\TestCase;

class ProductTypeCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_product_type(){

        $productType = [
            'name' => Str::random(10),
        ];

        $response = $this->postJson('/api/prodtype', $productType);

        $response->assertStatus(201);
        $this->assertDatabaseHas('product_types', [
            'name' => $productType['name'],
        ]);
    }
    
    /** @test */
    public function it_can_read_a_product_type(){
        $productType = ProductType::factory()->create();
        
        $response = $this->getJson('/api/prodtype/' . $productType->id);

        $response->assertStatus(200); 
        $this->assertDatabaseHas('product_types', [
            'id' => $productType->id,
        ]);
    }

    /** @test */
    public function it_can_update_a_product_type(){
        $productType = ProductType::factory()->create();

        $updatedData = [
            'name' => Str::random(10), 
        ];
        
        $response = $this->putJson('/api/prodtype/' . $productType->id, $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('product_types', [
            'name' => $updatedData['name'],
        ]);
    }

    /** @test */
    public function it_can_delete_a_product_type(){
        $productType = ProductType::factory()->create();

        $response = $this->deleteJson('/api/prodtype/' . $productType->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('product_types', [
            'id' => $productType->id,
        ]);
    }
}
