<?php

namespace Database\Seeders;

use App\Models\MaintenanceCompany;
use Illuminate\Database\Seeder;
use App\Models\Aircraft;

class AircraftSeeder extends Seeder
{
    public function run()
    {
        $company1 = MaintenanceCompany::where('name', 'skytech-maintenance')->first();
        $company2 = MaintenanceCompany::where('name', 'avionics-experts')->first();
        $company3 = MaintenanceCompany::where('name', 'fix-specialists')->first();
        $company4 = MaintenanceCompany::where('name', 'global-aviation-services')->first();

        if ($company1 && $company2 && $company3 && $company4) {
            Aircraft::create([
                'model' => 'Boeing 737-800',
                'serial_number' => '12345',
                'registration' => 'N123AB',
                'maintenance_history' => 'Oil change completed on 2022-07-15.',
                'maintenance_company_id' => $company1->id
            ]);
            Aircraft::create([
                'model' => 'Airbus A320neo',
                'serial_number' => '67890',
                'registration' => 'N678CD',
                'maintenance_history' => 'Avionics update completed on 2024-06-15.',
                'maintenance_company_id' => $company2->id
            ]);
            Aircraft::create([
                'model' => 'Embraer E190',
                'serial_number' => '54321',
                'registration' => 'N543EF',
                'maintenance_company_id' => $company3->id
            ]);
            Aircraft::create([
                'model' => 'Bombardier CRJ900',
                'serial_number' => '98765',
                'registration' => 'N987GH',
                'maintenance_history' => 'Software update completed on 2024-04-01',
                'maintenance_company_id' => $company4->id
            ]);
        } else {
            throw new \Exception('Maintenance companies not found');
        }
    }
}
