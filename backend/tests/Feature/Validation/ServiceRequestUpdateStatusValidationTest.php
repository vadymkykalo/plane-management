<?php

namespace Tests\Feature\Validation;

use App\Models\ServiceRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceRequestUpdateStatusValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_request_update_status_fails_with_missing_data()
    {
        $serviceRequest = ServiceRequest::factory()->create();

        $response = $this->patchJson("/api/service_requests/{$serviceRequest->id}/status", []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['status', 'updated_at']);
    }

    public function test_service_request_update_status_fails_with_invalid_data()
    {
        $serviceRequest = ServiceRequest::factory()->create();

        $response = $this->patchJson("/api/service_requests/{$serviceRequest->id}/status", [
            'status' => 'invalid_status',
            'updated_at' => 'invalid-date',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['status', 'updated_at']);
    }

    public function test_service_request_update_status_passes_with_valid_data()
    {
        $serviceRequest = ServiceRequest::factory()->create([
            'status' => ServiceRequest::STATUS_PENDING,
            'due_date' => now()->subDay()->toDateString(),
        ]);

        $response = $this->patchJson("/api/service_requests/{$serviceRequest->id}/status", [
            'status' => ServiceRequest::STATUS_IN_PROGRESS,
            'updated_at' => now()->toDateTimeString(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'status' => ServiceRequest::STATUS_IN_PROGRESS,
        ]);
    }
}
