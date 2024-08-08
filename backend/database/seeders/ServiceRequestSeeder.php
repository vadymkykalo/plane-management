<?php

namespace Database\Seeders;

use App\Models\AircraftMaintenanceCompany;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\ServiceRequest;

class ServiceRequestSeeder extends Seeder
{
    public function run()
    {
        $requests = [
            ['aircraft_id' => 1, 'issue_description' => 'Engine inspection required', 'priority' => 'High', 'due_date' => '2024-08-15', 'status' => 'pending'],
            ['aircraft_id' => 2, 'issue_description' => 'Cabin maintenance', 'priority' => 'Medium', 'due_date' => '2024-09-01', 'status' => 'pending'],
            ['aircraft_id' => 3, 'issue_description' => 'Avionics system check', 'priority' => 'Low', 'due_date' => '2024-09-15', 'status' => 'in_progress'],
            ['aircraft_id' => 1, 'issue_description' => 'Landing gear maintenance', 'priority' => 'High', 'due_date' => '2024-08-22', 'status' => 'completed'],
            ['aircraft_id' => 4, 'issue_description' => 'Software update', 'priority' => 'Medium', 'due_date' => '2024-10-05', 'status' => 'completed'],
        ];

        foreach ($requests as $request) {
            $maintenanceCompanyId = ($request['aircraft_id'] % 2 == 0) ? 1 : 2;

            $serviceRequest = ServiceRequest::create(array_merge($request, ['maintenance_company_id' => $maintenanceCompanyId]));

            if (in_array($serviceRequest->status, ['in_progress', 'completed'])) {
                AircraftMaintenanceCompany::create([
                    'aircraft_id' => $serviceRequest->aircraft_id,
                    'maintenance_company_id' => $maintenanceCompanyId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
