<?php

namespace App\Providers;

use App\Models\AircraftMaintenanceCompany;
use App\Models\ServiceRequest;
use Illuminate\Support\ServiceProvider;
use App\Services\ServiceRequestServiceInterface;
use App\Services\ServiceRequestService;

class ServiceRequestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ServiceRequestServiceInterface::class, function ($app) {
            return new ServiceRequestService(
                $app->make(ServiceRequest::class),
                $app->make(AircraftMaintenanceCompany::class)
            );
        });
    }
}
