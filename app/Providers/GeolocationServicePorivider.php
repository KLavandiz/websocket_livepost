<?php

namespace App\Providers;

use App\Services\Geolocation\Geolocation;
use App\Services\Map\Map;
use App\Services\Satellite\Satellite;
use Illuminate\Support\ServiceProvider;

class GeolocationServicePorivider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(Geolocation::class, function ($app) {
            $map = new Map();
            $satellite = new Satellite();
            return new Geolocation($map, $satellite);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void // bind the event listener for example to send an email when the class called
    {
        //
    }
}
