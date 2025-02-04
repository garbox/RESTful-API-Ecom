<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Shipping;
use App\Models\Cart;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user(){
        // Data for creating a new user
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123')
        ];

        // Create a new user using POST request
        $response = $this->postJson('/api/user', $userData);

        // Assert the user is created and the response is successful
        $response->assertStatus(201); // 201 Created
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com'
        ]);
    }

    /** @test */
    public function it_can_read_a_user(){
        // Create a user in the database
        $user = User::factory()->create();

        // Fetch the user using GET request
        $response = $this->getJson('/api/user/' . $user->id);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK
        $response->assertJson([
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function it_can_update_a_user(){
        // Create a user to update
        $user = User::factory()->create();

        // Data for updating the user
        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        // Update the user using PUT request
        $response = $this->putJson('/api/user/' . $user->id, $updatedData);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK

        // Assert the user was updated in the database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'jane@example.com',
        ]);
    }

    /** @test */
    public function it_can_delete_a_user(){
        // Create a user to delete
        $user = User::factory()->create();

        // Delete the user using DELETE request
        $response = $this->deleteJson('/api/user/' . $user->id);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK

        // Assert the user was deleted from the database
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
    
    /** @test */
    public function it_can_get_orders_for_a_user(){
        $user = User::factory()->create();
        ProductType::factory()->create();
        Product::factory()->create();
        Order::factory()->create();
        Shipping::factory()->create();
        
        // Delete the user using DELETE request
        $response = $this->getJson('/api/user/' . $user->id . '/orders');

        $response->assertStatus(200); 
    }

    /** @test */
    public function it_can_get_shipping_info_for_a_user(){
        $user = User::factory()->create();
        ProductType::factory()->create();
        Product::factory()->create();
        Order::factory()->create();
        Shipping::factory()->create();
        
        $response = $this->getJson('/api/user/' . $user->id . '/shipping');

        $response->assertStatus(200); 
    }

    /** @test */
    public function it_can_get_cart_info_for_a_user(){
        $user = User::factory()->create();
        ProductType::factory()->create();
        Product::factory()->create();
        Order::factory()->create();
        Cart::factory()->create();
        Shipping::factory()->create();
        
        $response = $this->getJson('/api/user/' . $user->id . '/cart');

        $response->assertStatus(200); 
    }
}
