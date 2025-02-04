<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductType;
use Tests\TestCase;

class PhotoCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_multiple_photos(){
        Storage::fake('public');
        ProductType::factory()->create();
        $product = Product::factory()->create();

        $photoFiles = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.png'),
        ];

        $photoData = [
            'product_id' => $product->id,
            'file_name' => $photoFiles,
        ];

        $response = $this->postJson('/api/photo', $photoData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('photos', [
            'product_id' => $photoData['product_id'],
        ]);
    }

    /** @test */
    public function it_can_read_a_photo(){
        ProductType::factory()->create();
        Product::factory()->create();
        $photo = Photo::factory()->create();

        // Fetch the user using GET request
        $response = $this->getJson('/api/photo/' . $photo->id);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK
        $this->assertDatabaseHas('photos', [
            'id' => $photo->id,
        ]);
    }

    /** @test */
    public function it_can_delete_a_photo(){
        ProductType::factory()->create();
        Product::factory()->create();
        $photo = Photo::factory()->create();

        // Delete the user using DELETE request
        $response = $this->deleteJson('/api/photo/' . $photo->id);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK

        // Assert the user was deleted from the database
        $this->assertDatabaseMissing('photos', [
            'id' => $photo->id,
        ]);
    }
}
