<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ApiToken;
use App\Models\Category;
use App\Models\Admin;
use Tests\TestCase;

class PhotoCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_multiple_photos(){
        Storage::fake('public');
        Category::factory()->create();
        $product = Product::factory()->create();

        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            "USER_API_KEY" => $admin->api_token
        ];

        $photoFiles = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.png'),
        ];

        $photoData = [
            'product_id' => $product->id,
            'file_name' => $photoFiles,
        ];

        $response = $this->postJson(route('photo.store'), $photoData, $headers);

        $response->assertStatus(201);

        $this->assertDatabaseHas('photos', [
            'product_id' => $photoData['product_id'],
        ]);
    }

    /** @test */
    public function it_can_read_a_photo(){
        Category::factory()->create();
        Product::factory()->create();
        $photo = Photo::factory()->create();
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            "USER_API_KEY" => $admin->api_token
        ];

        // Fetch the user using GET request
        $response = $this->getJson(route('photo.show', $photo->id), $headers);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK
        $this->assertDatabaseHas('photos', [
            'id' => $photo->id,
        ]);
    }

    /** @test */
    public function it_can_delete_a_photo(){
        Artisan::call('app:admin-api-token');
        Category::factory()->create();
        Product::factory()->create();
        $photo = Photo::factory()->create();
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL_API_KEY' => $token,
            "USER_API_KEY" => $admin->api_token
        ];

        // Delete the user using DELETE request
        $response = $this->deleteJson(route('photo.destroy', $photo->id),[], $headers);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK

        // Assert the user was deleted from the database
        $this->assertDatabaseMissing('photos', [
            'id' => $photo->id,
        ]);
    }
}
