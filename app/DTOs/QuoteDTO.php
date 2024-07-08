<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

readonly class QuoteDTO
{
    /**
     * @param string $quote
     */
    public function __construct(
        private string $quote
    ) {
    }

    /**
     * @return string
     */
    public function getQuote(): string
    {
        return $this->quote;
    }

    /**
     * @return Collection
     */
    public function toArray(): Collection
    {
        return collect([
            'quote' => $this->quote
        ]);
    }
}
