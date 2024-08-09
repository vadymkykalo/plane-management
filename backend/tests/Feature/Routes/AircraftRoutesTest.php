<?php

namespace Tests\Feature\Routes;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AircraftRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_aircraft_routes_exist()
    {
        $this->assertTrue(Route::has('aircrafts.index'));
        $this->assertTrue(Route::has('aircrafts.store'));
        $this->assertTrue(Route::has('aircrafts.show'));
        $this->assertTrue(Route::has('aircrafts.update'));
        $this->assertTrue(Route::has('aircrafts.destroy'));
    }
}
