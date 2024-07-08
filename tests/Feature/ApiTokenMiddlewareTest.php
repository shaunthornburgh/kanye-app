<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ApiTokenMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_request_without_a_token_is_unauthorized()
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
        $response->assertJsonStructure(['error']);
    }

    #[Test]
    public function a_request_with_an_invalid_token_is_unauthorized()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer invalid_token'])
            ->getJson('/api/user');

        $response->assertStatus(401);
        $response->assertJsonStructure(['error']);
    }

    #[Test]
    public function a_request_with_a_valid_token_is_authorized()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $user->api_token])
            ->getJson('/api/user');

        $response->assertStatus(200);
        $response->assertJson(['id' => $user->id, 'email' => $user->email]);
    }
}
