<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\Models\ServiceRequest;

interface ServiceRequestServiceInterface
{
    public function getAll(): Collection;
    public function create(array $data);
    public function findById(int $id);
    public function update(ServiceRequest $serviceRequest, array $data): ServiceRequest;
    public function updateStatus(ServiceRequest $serviceRequest, string $status): ServiceRequest;
}
