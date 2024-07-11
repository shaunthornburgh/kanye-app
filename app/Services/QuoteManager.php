<?php

namespace App\Services;

use App\Contracts\QuoteSource;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Illuminate\Support\Facades\Config;

class QuoteManager
{
    /**
     * @param Collection $sources
     */
    public function __construct(
        protected Collection $sources = new Collection()
    ) {
    }

    /**
     * @param $driver
     * @param QuoteSource $source
     * @return void
     */
    public function extend($driver, QuoteSource $source): void
    {
        $this->sources->put($driver, $source);
    }

    /**
     * @param $driver
     * @return mixed
     */
    public function driver($driver = null): mixed
    {
        $driver = $driver ?: $this->getDefaultDriver();

        if (!isset($this->sources[$driver])) {
            throw new InvalidArgumentException("Driver [{$driver}] not supported.");
        }

        return $this->sources[$driver];
    }

    /**
     * @return mixed
     */
    public function getDefaultDriver(): mixed
    {
        return Config::get('quotes.default');
    }
}
