<?php

use App\Http\Controllers\Api\AircraftController;
use App\Http\Controllers\Api\MaintenanceCompanyController;
use App\Http\Controllers\Api\ServiceRequestController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [TestController::class, 'index']);

Route::prefix('api')->group(function () {
    Route::apiResource('aircraft', AircraftController::class);
    Route::apiResource('service-requests', ServiceRequestController::class);
    Route::apiResource('maintenance-companies', MaintenanceCompanyController::class);
});
