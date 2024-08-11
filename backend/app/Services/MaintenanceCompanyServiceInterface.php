<?php

namespace App\Services;

use App\Models\MaintenanceCompany;

interface MaintenanceCompanyServiceInterface
{
    public function getAllNotDeleted();
    public function create(array $data);
    public function findNotDeletedById(int $id);
    public function update(MaintenanceCompany $maintenanceCompany, array $data): void;
    public function softDelete(MaintenanceCompany $maintenanceCompany): void;
    public function getMaintenanceHistory(int $maintenanceCompanyId);
}
