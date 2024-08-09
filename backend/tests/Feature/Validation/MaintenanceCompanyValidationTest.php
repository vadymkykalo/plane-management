<?php

namespace Tests\Feature\Validation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaintenanceCompanyValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_maintenance_company_validation_fails_with_missing_data()
    {
        $response = $this->postJson('/api/maintenance_companies', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'contact', 'specialization']);
    }

    public function test_maintenance_company_validation_passes_with_valid_data()
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
}
