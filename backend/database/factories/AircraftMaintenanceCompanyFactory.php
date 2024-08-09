<?php

namespace Database\Factories;

use App\Models\Aircraft;
use App\Models\AircraftMaintenanceCompany;
use App\Models\MaintenanceCompany;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class AircraftMaintenanceCompanyFactory extends Factory
{
    protected $model = AircraftMaintenanceCompany::class;

    public function definition()
    {
        return [
            'service_requests_id' => ServiceRequest::factory(),
            'aircraft_id' => Aircraft::factory(),
            'maintenance_company_id' => MaintenanceCompany::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
