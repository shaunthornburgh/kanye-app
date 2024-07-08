<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\DTOs\QuoteDTO;

class QuoteDTOTest extends TestCase
{
    #[Test]
    public function test_quote_dto_initialization()
    {
        $quote = 'This is a test quote';
        $quoteDTO = new QuoteDTO($quote);

        $this->assertInstanceOf(QuoteDTO::class, $quoteDTO);
        $this->assertEquals($quote, $quoteDTO->getQuote());
    }

    #[Test]
    public function test_quote_dto_to_array()
    {
        $quote = 'This is a test quote';
        $quoteDTO = new QuoteDTO($quote);
        $expectedArray = collect(['quote' => $quote]);

        $this->assertEquals($expectedArray, $quoteDTO->toArray());
    }
}
