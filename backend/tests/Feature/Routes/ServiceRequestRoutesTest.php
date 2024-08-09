<?php

namespace Tests\Feature\Routes;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceRequestRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_request_routes_exist()
    {
        $this->assertTrue(Route::has('service_requests.index'));
        $this->assertTrue(Route::has('service_requests.store'));
        $this->assertTrue(Route::has('service_requests.show'));
        $this->assertTrue(Route::has('service_requests.update'));
    }
}
