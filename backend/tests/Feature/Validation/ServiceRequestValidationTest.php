<?php

namespace Tests\Feature\Validation;

use App\Models\Aircraft;
use App\Models\MaintenanceCompany;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceRequestValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_request_validation_fails_with_missing_data()
    {
        $response = $this->postJson('/api/service_requests', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'aircraft_id',
            'issue_description',
            'priority',
            'due_date'
        ]);
    }

    public function test_service_request_validation_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/service_requests', [
            'aircraft_id' => 999,  // Non-existent aircraft ID
            'maintenance_company_id' => 999,
            'issue_description' => '',  // Empty description
            'priority' => 'InvalidPriority',
            'due_date' => 'invalid-date',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'aircraft_id',
            'maintenance_company_id',
            'issue_description',
            'priority',
            'due_date'
        ]);
    }

    public function test_service_request_validation_passes_with_valid_data()
    {
        $aircraft = Aircraft::factory()->create();
        $maintenanceCompany = MaintenanceCompany::factory()->create();

        $response = $this->postJson('/api/service_requests', [
            'aircraft_id' => $aircraft->id,
            'maintenance_company_id' => $maintenanceCompany->id,
            'issue_description' => 'Engine check required',
            'priority' => 'High',
            'due_date' => now()->addDays(3)->toDateString(),
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'aircraft_id' => $aircraft->id,
            'issue_description' => 'Engine check required',
            'priority' => 'High',
        ]);
    }
}
