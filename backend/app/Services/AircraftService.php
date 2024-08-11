<?php

namespace App\Services;

use App\Models\Aircraft;
use App\Models\AircraftMaintenanceCompany;
use Illuminate\Database\Eloquent\Collection;

class AircraftService
{
    protected Aircraft $aircraft;
    protected AircraftMaintenanceCompany $aircraftMaintenanceCompany;

    public function __construct(Aircraft $aircraft, AircraftMaintenanceCompany $aircraftMaintenanceCompany)
    {
        $this->aircraft = $aircraft;
        $this->aircraftMaintenanceCompany = $aircraftMaintenanceCompany;
    }

    public function getAllNotDeleted(): Collection
    {
        return $this->aircraft->notDeleted()->get();
    }

    public function create(array $data): Aircraft
    {
        return $this->aircraft->create($data);
    }

    public function findNotDeletedById(int $id): ?Aircraft
    {
        return $this->aircraft->notDeleted()->findOrFail($id);
    }

    public function update(Aircraft $aircraft, array $data): bool
    {
        return $aircraft->update($data);
    }

    public function softDelete(Aircraft $aircraft): bool
    {
        $aircraft->is_deleted = true;
        return $aircraft->save();
    }

    public function getMaintenanceHistory(int $aircraftId): Collection
    {
        return $this->aircraftMaintenanceCompany->where('aircraft_id', $aircraftId)
            ->orderBy('created_at', 'desc')
            ->with('maintenanceCompany')
            ->get();
    }
}
