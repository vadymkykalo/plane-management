<?php

namespace Tests\Feature\Controllers;

use App\Models\Aircraft;
use App\Models\AircraftMaintenanceCompany;
use App\Models\MaintenanceCompany;
use App\Models\ServiceRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaintenanceCompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_maintenance_company()
    {
        $data = [
            'name' => 'SkyTech Maintenance',
            'contact' => '+1-555-1212',
            'specialization' => 'Engine repair',
        ];

        $response = $this->postJson('/api/maintenance_companies', $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('maintenance_companies', $data);
    }

    public function test_it_can_update_a_maintenance_company()
    {
        $maintenanceCompany = MaintenanceCompany::factory()->create();

        $updatedData = [
            'name' => 'Updated Maintenance',
            'contact' => '+1-555-9999',
            'specialization' => 'Avionics',
        ];

        $response = $this->putJson("/api/maintenance_companies/{$maintenanceCompany->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('maintenance_companies', $updatedData);
    }

    public function test_it_can_delete_a_maintenance_company()
    {
        $maintenanceCompany = MaintenanceCompany::factory()->create();

        $response = $this->deleteJson("/api/maintenance_companies/{$maintenanceCompany->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('maintenance_companies', ['id' => $maintenanceCompany->id, 'is_deleted' => false]);
    }

    public function test_it_can_list_maintenance_companies()
    {
        MaintenanceCompany::factory()->count(3)->create();

        $response = $this->getJson('/api/maintenance_companies');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_it_can_retrieve_maintenance_history()
    {
        $maintenanceCompany = MaintenanceCompany::factory()->create();
        $aircraft = Aircraft::factory()->create();
        $serviceRequest = ServiceRequest::factory()->create([
            'aircraft_id' => $aircraft->id,
            'maintenance_company_id' => $maintenanceCompany->id,
        ]);
        AircraftMaintenanceCompany::factory()->create([
            'service_requests_id' => $serviceRequest->id,
            'aircraft_id' => $aircraft->id,
            'maintenance_company_id' => $maintenanceCompany->id,
        ]);

        $response = $this->getJson("/api/maintenance_companies/{$maintenanceCompany->id}/maintenance_history");

        $response->assertStatus(200)
            ->assertJsonStructure([[
                'id',
                'service_requests_id',
                'aircraft_id',
                'maintenance_company_id',
                'aircraft' => [
                    'id',
                    'model',
                    'serial_number',
                    'registration',
                ],
                'service_request' => [
                    'id',
                    'issue_description',
                    'priority',
                    'due_date',
                    'status',
                ],
            ]]);
    }
}
