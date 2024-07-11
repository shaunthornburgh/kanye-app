<?php

namespace App\Services;

use App\Contracts\Cacheable;
use App\Contracts\QuoteServiceInterface;
use Illuminate\Support\Collection;

class QuoteService implements QuoteServiceInterface
{
    /**
     * @param Cacheable $cache
     * @param QuoteManager $quoteManager
     */
    public function __construct(
        private readonly Cacheable    $cache,
        private readonly QuoteManager $quoteManager
    ) {
    }

    /**
     * @param int $count
     * @return Collection
     */
    public function getQuotes(int $count = 5): Collection
    {
        $source =  $this->quoteManager->getDefaultDriver();
        $cacheKey = "{$source}_quotes";

        $quotes = $this->cache->get($cacheKey, $count);

        if ($quotes->isEmpty()) {
            $quotes = $this->refreshQuotes($count);
            $this->cache->put($cacheKey, $quotes, 60);
        }

        return $quotes;
    }

    /**
     * @param int $count
     * @return Collection
     */
    public function refreshQuotes(int $count = 5): Collection
    {
        $source = $this->quoteManager->getDefaultDriver();
        $quotes = $this->quoteManager->driver($source)->getQuotes($count);
        $cacheKey = "{$source}_quotes";
        $this->cache->put($cacheKey, $quotes, 60);

        return $quotes;
    }
}
