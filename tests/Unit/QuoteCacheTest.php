<?php

namespace Tests\Unit;

use App\Cache\QuoteCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\DTOs\QuoteDTO;

class QuoteCacheTest extends TestCase
{
    #[Test]
    public function test_cache_get_with_existing_data()
    {
        $cachedQuotes = [
            ['quote' => 'Quote 1'],
            ['quote' => 'Quote 2'],
            ['quote' => 'Quote 3'],
        ];

        Cache::shouldReceive('has')
            ->once()
            ->with('test_key')
            ->andReturn(true);

        Cache::shouldReceive('get')
            ->once()
            ->with('test_key')
            ->andReturn($cachedQuotes);

        $quoteCache = new QuoteCache();
        $quotes = $quoteCache->get('test_key', 5);

        $this->assertInstanceOf(Collection::class, $quotes);
        $this->assertCount(3, $quotes);
        $this->assertInstanceOf(QuoteDTO::class, $quotes->first());
        $this->assertEquals('Quote 1', $quotes->first()->getQuote());
    }

    public function test_cache_get_with_no_data()
    {
        Cache::shouldReceive('has')
            ->once()
            ->with('test_key')
            ->andReturn(false);

        $quoteCache = new QuoteCache();
        $quotes = $quoteCache->get('test_key', 5);

        $this->assertInstanceOf(Collection::class, $quotes);
        $this->assertTrue($quotes->isEmpty());
    }

    public function test_cache_put()
    {
        $quotes = collect([
            new QuoteDTO('Quote 1'),
            new QuoteDTO('Quote 2'),
            new QuoteDTO('Quote 3'),
        ]);

        Cache::shouldReceive('put')
            ->once()
            ->with('test_key', $quotes->map(function ($quote) {
                return $quote->toArray();
            })->toArray(), 60);

        $quoteCache = new QuoteCache();
        $quoteCache->put('test_key', $quotes, 60);

        // If no exception is thrown, the test passes
        $this->assertTrue(true);
    }
}
