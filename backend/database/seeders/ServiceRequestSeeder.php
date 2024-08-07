<?php

namespace Database\Seeders;

use App\Models\Aircraft;
use Illuminate\Database\Seeder;
use App\Models\ServiceRequest;

class ServiceRequestSeeder extends Seeder
{
    public function run()
    {
        $aircraft1 = Aircraft::where('serial_number', '12345')->first()->id;
        $aircraft2 = Aircraft::where('serial_number', '67890')->first()->id;
        $aircraft3 = Aircraft::where('serial_number', '54321')->first()->id;
        $aircraft4 = Aircraft::where('serial_number', '98765')->first()->id;

        ServiceRequest::create(['aircraft_id' => $aircraft1, 'issue_description' => 'Engine inspection required', 'priority' => 'High', 'due_date' => '2024-08-15']);
        ServiceRequest::create(['aircraft_id' => $aircraft2, 'issue_description' => 'Cabin maintenance', 'priority' => 'Medium', 'due_date' => '2024-09-01']);
        ServiceRequest::create(['aircraft_id' => $aircraft3, 'issue_description' => 'Avionics system check', 'priority' => 'Low', 'due_date' => '2024-09-15']);
        ServiceRequest::create(['aircraft_id' => $aircraft1, 'issue_description' => 'Landing gear maintenance', 'priority' => 'High', 'due_date' => '2024-08-22']);
        ServiceRequest::create(['aircraft_id' => $aircraft4, 'issue_description' => 'Software update', 'priority' => 'Medium', 'due_date' => '2024-10-05']);
    }
}
