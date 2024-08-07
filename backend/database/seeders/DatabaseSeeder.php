<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
            ]
        );

        $this->call(MaintenanceCompanySeeder::class);
        $this->call(AircraftSeeder::class);
        $this->call(ServiceRequestSeeder::class);
    }
}
