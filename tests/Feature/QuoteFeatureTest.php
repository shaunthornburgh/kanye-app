<?php

namespace Tests\Feature;

use App\Contracts\Cacheable;
use App\DTOs\QuoteDTO;
use App\Models\User;
use App\Services\QuoteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class QuoteFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    #[Test]
    public function test_can_fetch_quotes(): void
    {
        $cachedQuotes = collect([
            new QuoteDTO('Quote 1'),
            new QuoteDTO('Quote 2'),
            new QuoteDTO('Quote 3'),
            new QuoteDTO('Quote 4'),
            new QuoteDTO('Quote 5'),
        ]);

        $cacheMock = Mockery::mock(Cacheable::class);
        $cacheMock->shouldReceive('get')
            ->once()
            ->andReturn($cachedQuotes);

        $this->app->instance(Cacheable::class, $cacheMock);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->api_token
        ])->get('/api/quotes');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    ['quote' => 'Quote 1'],
                    ['quote' => 'Quote 2'],
                    ['quote' => 'Quote 3'],
                    ['quote' => 'Quote 4'],
                    ['quote' => 'Quote 5'],
                ]
            ]);
    }

    #[Test]
    public function test_can_refresh_quotes()
    {
        $cachedQuotes = collect([
            new QuoteDTO('Quote 1'),
            new QuoteDTO('Quote 2'),
            new QuoteDTO('Quote 3'),
            new QuoteDTO('Quote 4'),
            new QuoteDTO('Quote 5'),
        ]);

        $quoteServiceMock = Mockery::mock(QuoteService::class);
        $quoteServiceMock->shouldReceive('refreshQuotes')
            ->once()
            ->andReturn($cachedQuotes);

        $this->app->instance(QuoteService::class, $quoteServiceMock);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->api_token
        ])->get('/api/quotes/refresh');


        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    ['quote' => 'Quote 1'],
                    ['quote' => 'Quote 2'],
                    ['quote' => 'Quote 3'],
                    ['quote' => 'Quote 4'],
                    ['quote' => 'Quote 5'],
                ]
            ]);
    }

    #[Test]
    public function test_cannot_access_without_token(): void
    {
        $response = $this->get('/api/quotes');
        $response->assertStatus(401);

        $response = $this->get('/api/quotes/refresh');
        $response->assertStatus(401);
    }
}
