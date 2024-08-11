<?php

namespace App\Services;

use App\Models\Aircraft;

interface AircraftServiceInterface
{
    public function getAllNotDeleted();
    public function create(array $data);
    public function findNotDeletedById(int $id);
    public function update(Aircraft $aircraft, array $data);
    public function softDelete(Aircraft $aircraft);
    public function getMaintenanceHistory(int $aircraftId);
}

