<?php

namespace App\Providers;

use App\Contracts\Currency\CurrencyService as CurrencyServiceContract;
use App\Services\Currency\CurrencyService;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(CurrencyServiceContract::class, CurrencyService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
