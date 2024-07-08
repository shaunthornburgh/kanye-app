<?php

namespace App\Cache;

use App\DTOs\QuoteDTO;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class QuoteCache implements Cacheable
{
    /**
     * @param string $key
     * @param int $count
     * @return Collection
     */
    public function get(string $key, int $count): Collection
    {
        if (Cache::has($key)) {
            return collect(Cache::get($key))->map(function ($quote) {
                return new QuoteDTO($quote['quote']);
            });
        }

        return collect();
    }

    /**
     * @param string $key
     * @param Collection $value
     * @param int $minutes
     * @return void
     */
    public function put(string $key, Collection $value, int $minutes): void
    {
        Cache::put($key, $value->map(function ($quote) {
            return $quote->toArray();
        })->toArray(), $minutes);
    }
}
