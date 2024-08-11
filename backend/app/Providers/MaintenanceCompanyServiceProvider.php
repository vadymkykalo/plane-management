<?php

namespace App\Providers;

use App\Models\AircraftMaintenanceCompany;
use App\Models\MaintenanceCompany;
use Illuminate\Support\ServiceProvider;
use App\Services\MaintenanceCompanyServiceInterface;
use App\Services\MaintenanceCompanyService;

class MaintenanceCompanyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MaintenanceCompanyServiceInterface::class, function ($app) {
            return new MaintenanceCompanyService(
                $app->make(MaintenanceCompany::class),
                $app->make(AircraftMaintenanceCompany::class)
            );
        });
    }
}
