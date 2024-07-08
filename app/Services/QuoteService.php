<?php

namespace App\Services;

use App\Cache\Cacheable;
use App\DTOs\QuoteDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class QuoteService implements QuoteServiceInterface
{
    /**
     * @param Cacheable $cache
     */
    public function __construct(
        private Cacheable $cache
    ) {
    }

    /**
     * @param int $count
     * @return Collection
     */
    public function getQuotes(int $count = 5): Collection
    {
        $quotes = $this->cache->get('kanye_quotes', $count);

        if ($quotes->isEmpty()) {
            $quotes = $this->fetchQuotes($count);
            $this->cache->put('kanye_quotes', $quotes, 60);
        }

        return $quotes;
    }

    /**
     * @param int $count
     * @return Collection
     */
    public function refreshQuotes(int $count = 5): Collection
    {
        $quotes = $this->fetchQuotes($count);
        $this->cache->put('kanye_quotes', $quotes, 60);

        return $quotes;
    }

    /**
     * @param int $count
     * @return Collection
     */
    private function fetchQuotes(int $count): Collection
    {
        $quotes = collect();
        for ($i = 0; $i < $count; $i++) {
            $response = Http::get('https://api.kanye.rest/');
            $quotes->push(new QuoteDTO($response->json()['quote']));
        }

        return $quotes;
    }
}
