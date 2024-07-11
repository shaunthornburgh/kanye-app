<?php

namespace App\Services;

use App\Contracts\QuoteSource;
use App\DTOs\QuoteDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class KanyeRestQuoteSource implements QuoteSource
{
    public function getQuotes(int $count): Collection
    {
        $quotes = collect();
        for ($i = 0; $i < $count; $i++) {
            $response = Http::get('https://api.kanye.rest/');
            $quotes->push(new QuoteDTO($response->json()['quote']));
        }
        return $quotes;
    }
}
