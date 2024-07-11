<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface QuoteServiceInterface
{
    public function getQuotes(int $count): Collection;

    public function refreshQuotes(int $count): Collection;
}
