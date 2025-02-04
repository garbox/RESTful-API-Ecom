<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Admin;
use Tests\TestCase;


class AdminCrudTest extends TestCase
{
    // Use RefreshDatabase to ensure the database is rolled back after each test
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_admin(){
        $adminData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role_id' => 1,
            'permissions' => 1,
        ];

        $response = $this->postJson('/api/admin', $adminData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('admins', [
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    public function it_can_read_admin(){
        // Create a user in the database
        $admin = Admin::factory()->create();

        // Fetch the user using GET request
        $response = $this->getJson('/api/admin/' . $admin->id);

        // Assert the response is successful
        $response->assertStatus(200); // 200 OK
        $response->assertJson([
            'id' => $admin->id,
            'email' => $admin->email,
        ]);

        $response = $this->getJson('/api/admin/' . $admin->id+1);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_update_a_admin(){
        $admin = Admin::factory()->create();

        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        $response = $this->putJson('/api/admin/' . $admin->id, $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('admins', [
            'id' => $admin->id,
            'email' => 'jane@example.com',
        ]);

        $response = $this->getJson('/api/user/' . $admin->id+1, $updatedData);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_delete_a_admin(){
        $admin = Admin::factory()->create();

        $response = $this->deleteJson('/api/admin/' . $admin->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('admins', [
            'id' => $admin->id,
        ]);

        $response = $this->deleteJson('/api/admin/' . $admin->id+1);
        $response->assertStatus(404); 
    }
}
