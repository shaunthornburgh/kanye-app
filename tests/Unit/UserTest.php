<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_generates_an_api_token(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->api_token);
        $this->assertIsString($user->api_token);
        $this->assertEquals(60, strlen($user->api_token));
    }
}
