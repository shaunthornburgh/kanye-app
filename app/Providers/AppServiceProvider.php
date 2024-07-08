<?php

namespace App\Providers;

use App\Cache\Cacheable;
use App\Cache\QuoteCache;
use App\Services\QuoteService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Cacheable::class, QuoteCache::class);
        $this->app->singleton(QuoteService::class, function ($app) {
            return new QuoteService($app->make(Cacheable::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
