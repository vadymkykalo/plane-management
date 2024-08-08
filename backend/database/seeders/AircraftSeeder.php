<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aircraft;

class AircraftSeeder extends Seeder
{
    public function run()
    {
        $aircrafts = [
            ['model' => 'Boeing 737-800', 'serial_number' => '12345', 'registration' => 'N123AB'],
            ['model' => 'Airbus A320neo', 'serial_number' => '67890', 'registration' => 'N678CD'],
            ['model' => 'Embraer E190', 'serial_number' => '54321', 'registration' => 'N543EF'],
            ['model' => 'Bombardier CRJ900', 'serial_number' => '98765', 'registration' => 'N987GH'],
        ];

        foreach ($aircrafts as $aircraft) {
            Aircraft::create($aircraft);
        }
    }
}
