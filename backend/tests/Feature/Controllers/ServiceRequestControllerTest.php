<?php

namespace Tests\Feature\Controllers;

use App\Models\Aircraft;
use App\Models\MaintenanceCompany;
use App\Models\ServiceRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class ServiceRequestControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_service_request()
    {
        $aircraft = Aircraft::factory()->create();
        $maintenanceCompany = MaintenanceCompany::factory()->create();

        $response = $this->postJson('/api/service_requests', [
            'aircraft_id' => $aircraft->id,
            'maintenance_company_id' => $maintenanceCompany->id,
            'issue_description' => 'Test issue',
            'priority' => 'High',
            'due_date' => Carbon::now()->addDay()->toDateString(),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'aircraft_id',
                'maintenance_company_id',
                'issue_description',
                'priority',
                'due_date',
                'status',
            ]);
    }

    public function test_it_can_update_a_service_request()
    {
        $serviceRequest = ServiceRequest::factory()->create([
            'status' => ServiceRequest::STATUS_PENDING,
        ]);

        $response = $this->putJson("/api/service_requests/{$serviceRequest->id}", [
            'aircraft_id' => $serviceRequest->aircraft_id, // Добавлено поле aircraft_id
            'issue_description' => 'Updated issue',
            'priority' => 'Low',
            'due_date' => Carbon::now()->addDays(2)->toDateString(),
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'issue_description' => 'Updated issue',
                'priority' => 'Low',
            ]);
    }

    public function test_it_can_update_status_to_in_progress()
    {
        $serviceRequest = ServiceRequest::factory()->create([
            'status' => ServiceRequest::STATUS_PENDING,
            'due_date' => Carbon::now()->subDay(),
        ]);

        $response = $this->patchJson("/api/service_requests/{$serviceRequest->id}/status", [
            'status' => ServiceRequest::STATUS_IN_PROGRESS,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => ServiceRequest::STATUS_IN_PROGRESS,
            ]);
    }

    public function test_it_fails_to_update_status_to_in_progress_before_due_date()
    {
        $serviceRequest = ServiceRequest::factory()->create([
            'status' => ServiceRequest::STATUS_PENDING,
            'due_date' => Carbon::now()->addDay(),
        ]);

        $response = $this->patchJson("/api/service_requests/{$serviceRequest->id}/status", [
            'status' => ServiceRequest::STATUS_IN_PROGRESS,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        $response->assertStatus(400)
            ->assertJsonFragment([
                'message' => 'Cannot start progress before the due date.',
            ]);
    }

    public function test_it_can_update_status_to_completed()
    {
        $serviceRequest = ServiceRequest::factory()->create([
            'status' => ServiceRequest::STATUS_IN_PROGRESS,
        ]);

        $response = $this->patchJson("/api/service_requests/{$serviceRequest->id}/status", [
            'status' => ServiceRequest::STATUS_COMPLETED,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => ServiceRequest::STATUS_COMPLETED,
            ]);
    }

    public function test_it_can_retrieve_all_service_requests()
    {
        $serviceRequest = ServiceRequest::factory()->count(3)->create();

        $response = $this->getJson('/api/service_requests');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }
}
