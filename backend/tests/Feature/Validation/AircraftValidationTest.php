<?php

namespace Tests\Feature\Validation;

use App\Models\Aircraft;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AircraftValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_aircraft_validation_fails_with_missing_data()
    {
        $response = $this->postJson('/api/aircrafts', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['model', 'serial_number', 'registration']);
    }

    public function test_aircraft_validation_fails_with_duplicate_data()
    {
        Aircraft::factory()->create([
            'serial_number' => 'SN123456',
            'registration' => 'REG123',
        ]);

        $response = $this->postJson('/api/aircrafts', [
            'model' => 'Boeing 747',
            'serial_number' => 'SN123456',
            'registration' => 'REG123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['serial_number', 'registration']);
    }
}
