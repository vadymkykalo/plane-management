<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AircraftController;
use App\Http\Controllers\Api\ServiceRequestController;
use App\Http\Controllers\Api\MaintenanceCompanyController;

Route::middleware('api')->group(function () {
    Route::apiResource('aircrafts', AircraftController::class);
    Route::apiResource('service_requests', ServiceRequestController::class);
    Route::apiResource('maintenance_companies', MaintenanceCompanyController::class);
    Route::get('/aircrafts/{id}/maintenance_history', [AircraftController::class, 'maintenanceHistory'])
        ->name('aircrafts.maintenanceHistory');
    Route::patch('/service_requests/{id}/status', [ServiceRequestController::class, 'updateStatus']);
    Route::get('/maintenance_companies/{id}/maintenance_history', [MaintenanceCompanyController::class, 'maintenanceHistory'])
        ->name('maintenance_companies.maintenanceHistory');
});
