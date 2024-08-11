<?php

namespace App\Providers;

use App\Models\Aircraft;
use App\Models\AircraftMaintenanceCompany;
use Illuminate\Support\ServiceProvider;
use App\Services\AircraftServiceInterface;
use App\Services\AircraftService;

class AircraftServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AircraftServiceInterface::class, function ($app) {
            return new AircraftService(
                $app->make(Aircraft::class),
                $app->make(AircraftMaintenanceCompany::class)
            );
        });
    }
}
