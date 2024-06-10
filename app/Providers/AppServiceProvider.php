<?php

namespace App\Providers;

use DateTimeZone;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            \Laravel\Telescope\Telescope::night();
        }

        $this->app
            ->when(DateTimeZone::class)
            ->needs('$timezone')
            ->giveConfig('app.timezone');

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        JsonResource::withoutWrapping();
    }
}
