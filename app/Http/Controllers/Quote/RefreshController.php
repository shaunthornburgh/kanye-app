<?php

namespace App\Http\Controllers\Quote;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RefreshController extends Controller
{
    /**
     * @param QuoteService $quoteService
     */
    public function __construct(
        protected QuoteService $quoteService
    ) {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        return QuoteResource::collection($this->quoteService->refreshQuotes());
    }
}
