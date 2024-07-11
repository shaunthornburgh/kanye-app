<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface QuoteSource
{
    public function getQuotes(int $count): Collection;
}
