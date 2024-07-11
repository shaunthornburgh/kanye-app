<?php

namespace App\Providers;

use App\Cache\QuoteCache;
use App\Contracts\Cacheable;
use App\Services\QuoteManager;
use App\Services\QuoteService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(QuoteManager::class, function ($app) {
            $manager = new QuoteManager();
            foreach (config('quotes.drivers') as $driver => $config) {
                $manager->extend($driver, new $config['class']);
            }
            return $manager;
        });

        $this->app->singleton(Cacheable::class, QuoteCache::class);
        $this->app->singleton(QuoteService::class, function ($app) {
            return new QuoteService(
                $app->make(Cacheable::class),
                $app->make(QuoteManager::class)
            );
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
