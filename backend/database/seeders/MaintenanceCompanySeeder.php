<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceCompany;

class MaintenanceCompanySeeder extends Seeder
{
    public function run()
    {
        MaintenanceCompany::create(['name' => 'skytech-maintenance', 'contact' => '+1-111-1212', 'specialization' => 'Engine repair']);
        MaintenanceCompany::create(['name' => 'avionics-experts', 'contact' => '+380931111111', 'specialization' => 'Avionics']);
        MaintenanceCompany::create(['name' => 'fix-specialists', 'contact' => '+380935555555', 'specialization' => 'Structural repairs']);
        MaintenanceCompany::create(['name' => 'global-aviation-services', 'contact' => '+380932222222', 'specialization' => 'General maintenance']);
    }
}
