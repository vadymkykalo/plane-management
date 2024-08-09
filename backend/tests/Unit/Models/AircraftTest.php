<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Aircraft;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AircraftTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_aircraft()
    {
        $aircraft = Aircraft::create([
            'model' => 'Boeing 747',
            'serial_number' => 'SN123456',
            'registration' => 'REG123',
        ]);

        $this->assertDatabaseHas('aircrafts', [
            'model' => 'Boeing 747',
            'serial_number' => 'SN123456',
            'registration' => 'REG123',
        ]);
    }

    public function test_it_soft_deletes_aircraft()
    {
        $aircraft = Aircraft::factory()->create();

        $aircraft->is_deleted = true;
        $aircraft->save();

        $this->assertTrue($aircraft->is_deleted);
        $this->assertDatabaseHas('aircrafts', ['id' => $aircraft->id, 'is_deleted' => true]);
    }
}
