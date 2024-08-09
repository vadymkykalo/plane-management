<?php

namespace Tests\Feature\Routes;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaintenanceCompanyRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_maintenance_company_routes_exist()
    {
        $this->assertTrue(Route::has('maintenance_companies.index'));
        $this->assertTrue(Route::has('maintenance_companies.store'));
        $this->assertTrue(Route::has('maintenance_companies.show'));
        $this->assertTrue(Route::has('maintenance_companies.update'));
        $this->assertTrue(Route::has('maintenance_companies.destroy'));
    }
}
