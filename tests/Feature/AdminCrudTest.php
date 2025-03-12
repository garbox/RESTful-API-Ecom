<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\ApiToken;
use Tests\TestCase;


class AdminCrudTest extends TestCase
{
    // Use RefreshDatabase to ensure the database is rolled back after each test
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_admin(){
        //create main API key
        Artisan::call('app:admin-api-token');
        $admin = Admin::factory()->create();

        $token = ApiToken::pluck('api_token')->first();
        $password = Str::random(34);
        $adminData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role_id' => 1,
            'permissions' => 1,
            'password' => $password,
            'password_confirmation' => $password,
            'api_token' => Str::random(34),
        ];
    
        $headers = [
            'GLOBAL-API-KEY' => $token,
            "USER-API-KEY" => $admin->api_token
        ];
    
        $response = $this->postJson(route('admin.create'), $adminData, $headers);
        Log::info('Create response:', $response->json());
        $response->assertStatus(201);
    
        $this->assertDatabaseHas('admins', [
            'email' => 'john@example.com',
        ]);
    }
    
    /** @test */
    public function it_can_read_admin(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            "USER-API-KEY" => $admin->api_token
        ];

        $response = $this->getJson(route('admin.get'), $headers);

        $response->assertStatus(200); 
        $response->assertJson([
            'id' => $admin->id,
            'email' => $admin->email,
        ]);

        $response = $this->getJson('/api/admin/' . $admin->id+1);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_update_a_admin(){
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            "USER-API-KEY" => $admin->api_token
        ];

        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        $response = $this->putJson(route('admin.update'), $updatedData, $headers);
        
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
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $admin->api_token,
        ];

        $response = $this->deleteJson(route('admin.destroy'), [], $headers);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('admins', [
            'id' => $admin->id,
        ]);

        $response = $this->deleteJson(route('admin.destroy'));
        $response->assertStatus(404); 
    }

}
