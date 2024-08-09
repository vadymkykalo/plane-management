<?php

namespace Tests\Feature\Controllers;

use App\Models\AircraftMaintenanceCompany;
use App\Models\MaintenanceCompany;
use App\Models\ServiceRequest;
use Tests\TestCase;
use App\Models\Aircraft;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AircraftControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_an_aircraft()
    {
        $response = $this->postJson('/api/aircrafts', [
            'model' => 'Boeing 747',
            'serial_number' => 'SN123456',
            'registration' => 'REG123',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('aircrafts', [
            'model' => 'Boeing 747',
            'serial_number' => 'SN123456',
            'registration' => 'REG123',
        ]);
    }

    public function test_it_can_update_an_aircraft()
    {
        $aircraft = Aircraft::factory()->create();

        $response = $this->putJson("/api/aircrafts/{$aircraft->id}", [
            'model' => 'Airbus A320',
            'serial_number' => 'SN654321',
            'registration' => 'REG321',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('aircrafts', [
            'id' => $aircraft->id,
            'model' => 'Airbus A320',
            'serial_number' => 'SN654321',
            'registration' => 'REG321',
        ]);
    }

    public function test_it_can_delete_an_aircraft()
    {
        $aircraft = Aircraft::factory()->create();

        $response = $this->deleteJson("/api/aircrafts/{$aircraft->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('aircrafts', ['id' => $aircraft->id, 'is_deleted' => false]);
    }

    public function test_it_can_retrieve_aircraft_maintenance_history()
    {
        $aircraft = Aircraft::factory()->create();

        $maintenanceCompany = MaintenanceCompany::factory()->create();

        $serviceRequest = ServiceRequest::factory()->create([
            'aircraft_id' => $aircraft->id,
            'maintenance_company_id' => $maintenanceCompany->id,
        ]);

        AircraftMaintenanceCompany::create([
            'service_requests_id' => $serviceRequest->id,
            'aircraft_id' => $aircraft->id,
            'maintenance_company_id' => $maintenanceCompany->id,
        ]);

        $response = $this->getJson("/api/aircrafts/{$aircraft->id}/maintenance_history");

        $response->assertStatus(200);

        $response->assertJsonStructure([[
            'id',
            'service_requests_id',
            'aircraft_id',
            'maintenance_company_id',
            'maintenance_company' => [
                'id',
                'name',
                'contact',
                'specialization',
            ],
        ]]);
    }

}
