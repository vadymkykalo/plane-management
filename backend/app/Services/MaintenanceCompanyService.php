<?php

namespace App\Services;

use App\Models\AircraftMaintenanceCompany;
use App\Models\MaintenanceCompany;

class MaintenanceCompanyService implements MaintenanceCompanyServiceInterface
{
    protected MaintenanceCompany $maintenanceCompany;
    protected AircraftMaintenanceCompany $aircraftMaintenanceCompany;

    public function __construct(MaintenanceCompany $maintenanceCompany, AircraftMaintenanceCompany $aircraftMaintenanceCompany)
    {
        $this->maintenanceCompany = $maintenanceCompany;
        $this->aircraftMaintenanceCompany = $aircraftMaintenanceCompany;
    }

    public function getAllNotDeleted()
    {
        return $this->maintenanceCompany->notDeleted()->get();
    }

    public function create(array $data)
    {
        return $this->maintenanceCompany->create($data);
    }

    public function findNotDeletedById(int $id)
    {
        return $this->maintenanceCompany->notDeleted()->findOrFail($id);
    }

    public function update(MaintenanceCompany $maintenanceCompany, array $data): void
    {
        $maintenanceCompany->update($data);
    }

    public function softDelete(MaintenanceCompany $maintenanceCompany): void
    {
        $maintenanceCompany->is_deleted = true;
        $maintenanceCompany->save();
    }

    public function getMaintenanceHistory(int $maintenanceCompanyId)
    {
        return $this->aircraftMaintenanceCompany->where('maintenance_company_id', $maintenanceCompanyId)
            ->orderBy('created_at', 'desc')
            ->with(['aircraft', 'serviceRequest'])
            ->get();
    }
}
