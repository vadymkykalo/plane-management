<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceCompany;

class MaintenanceCompanySeeder extends Seeder
{
    public function run()
    {
        $companies = [
            ['name' => 'SkyTech Maintenance', 'contact' => '+1-555-1212', 'specialization' => 'Engine repair'],
            ['name' => 'Avionics Experts', 'contact' => '+1-555-3434', 'specialization' => 'Avionics'],
            ['name' => 'WingFix Specialists', 'contact' => '+1-555-6767', 'specialization' => 'Structural repairs'],
            ['name' => 'Global Aviation Services', 'contact' => '+1-555-8989', 'specialization' => 'General maintenance'],
        ];

        foreach ($companies as $company) {
            MaintenanceCompany::create($company);
        }
    }
}
