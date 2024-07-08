<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_login_and_receive_an_api_token()
    {
        $password = 'password';
        $user = User::factory()->create(['password' => bcrypt($password)]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['api_token']);

        $user->refresh();
        $this->assertNotNull($user->api_token);
    }

    #[Test]
    public function a_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure(['error']);
    }
}
