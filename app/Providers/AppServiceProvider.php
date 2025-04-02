<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NameService;
use App\Services\InputService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NameService::class, function () {
            return new NameService();
        });

        $this->app->singleton(InputService::class, function () {
            return new InputService();
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
