<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\ApiToken;
use Tests\TestCase;

class ApitokenCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_api_token(){
        $apiTokenData = [
            'app_name' => 'Mobile App'
        ];

        $response = $this->postJson('/api/token', $apiTokenData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('api_tokens', [
            'app_name' => 'Mobile App',
        ]);
    }

    /** @test */
    public function it_can_read_api_token(){
        $token = ApiToken::factory()->create();

        $response = $this->getJson('/api/token/' . $token->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $token->id,
            'app_name' => $token->app_name,
            'api_token' => $token->api_token,
        ]);

        $response = $this->getJson('/api/token/' . $token->id+1);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_update_a_api_token(){
        $token = ApiToken::factory()->create();

        $updatedData = [
            'app_name' => 'Jane Doe',
        ];

        $response = $this->putJson('/api/token/' . $token->id, $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('api_tokens', [
            'id' => $token->id,
            'app_name' => $updatedData['app_name'],
        ]);

        $response = $this->getJson('/api/token/{token}' . $token->id+1, $updatedData);
        $response->assertStatus(404); 
    }

    /** @test */
    public function it_can_delete_a_api_token(){
        $token = ApiToken::factory()->create();

        $response = $this->deleteJson('/api/token/' . $token->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('api_tokens', [
            'id' => $token->id,
        ]);

        $response = $this->deleteJson('/api/token/' . $token->id+1);
        $response->assertStatus(404); 
    }
}
