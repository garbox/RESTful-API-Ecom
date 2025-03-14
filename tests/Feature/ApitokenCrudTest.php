<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use App\Models\ApiToken;
use App\Models\Admin;
use Tests\TestCase;

class ApitokenCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_api_token()
    {
        Artisan::call('app:admin-api-token');
        $token = ApiToken::pluck('api_token')->first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token,
            'USER-API-KEY' => $admin->api_token,
        ];

        $apiTokenData = [
            'app_name' => 'Mobile App',
        ];

        $response = $this->postJson('/api/token', $apiTokenData, $headers);

        $response->assertStatus(201);

        $this->assertDatabaseHas('api_tokens', [
            'app_name' => 'Mobile App',
        ]);
    }

    /** @test */
    public function it_can_read_api_token()
    {
        Artisan::call('app:admin-api-token');
        $token = ApiToken::first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token->api_token,
            'USER-API-KEY' => $admin->api_token,
        ];

        $response = $this->getJson(route('token.show', ['token' => $token->api_token]), $headers);
        Log::info($response->json('message'));
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $token->id,
            'app_name' => $token->app_name,
            'api_token' => $token->api_token,
        ]);

        $response = $this->getJson(route('token.show', ['token' => $token->id + 1]), $headers);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_update_an_api_token()
    {
        Artisan::call('app:admin-api-token');
        $token = ApiToken::first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token->api_token,
            'USER-API-KEY' => $admin->api_token,
        ];

        $body = [
            'id' => $token->id,
            'app_name' => 'MasterBlaster',
        ];

        $response = $this->putJson(route('token.update'), $body, $headers);        
        $response->assertStatus(200);
        $this->assertDatabaseHas('api_tokens', [
            'id' => $token->id,
            'app_name' => $body['app_name'],
        ]);
    }

    /** @test */
    public function it_can_delete_an_api_token()
    {
        Artisan::call('app:admin-api-token');
        $token = ApiToken::first();
        $admin = Admin::factory()->create();

        $headers = [
            'GLOBAL-API-KEY' => $token->api_token,
            'USER-API-KEY' => $admin->api_token,
        ];

        $body = [
            'id' => $token->id,
        ];

        $response = $this->deleteJson(route('token.destroy'), $body, $headers);      
        $response->assertStatus(200);
        $this->assertDatabaseMissing('api_tokens', [
            'id' => $token->id,
        ]);
    }
}