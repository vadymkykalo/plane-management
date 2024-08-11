<?php

namespace App\Services;

use App\Models\AircraftMaintenanceCompany;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ServiceRequestService
{
    protected ServiceRequest $serviceRequest;
    protected AircraftMaintenanceCompany $aircraftMaintenanceCompany;

    public function __construct(ServiceRequest $serviceRequest, AircraftMaintenanceCompany $aircraftMaintenanceCompany)
    {
        $this->serviceRequest = $serviceRequest;
        $this->aircraftMaintenanceCompany = $aircraftMaintenanceCompany;
    }

    public function getAll(): Collection
    {
        return $this->serviceRequest->all();
    }

    public function create(array $data)
    {
        $data['status'] = ServiceRequest::STATUS_PENDING;
        return $this->serviceRequest->create($data);
    }

    public function findById(int $id)
    {
        return $this->serviceRequest->findOrFail($id);
    }

    public function update(ServiceRequest $serviceRequest, array $data): ServiceRequest
    {
        $serviceRequest->update($data);
        return $serviceRequest;
    }

    public function updateStatus(ServiceRequest $serviceRequest, string $status): ServiceRequest
    {
        $currentDate = Carbon::now();

        switch ($status) {
            case ServiceRequest::STATUS_IN_PROGRESS:
                if ($serviceRequest->status !== ServiceRequest::STATUS_PENDING) {
                    throw new HttpException(400, 'Invalid status transition.');
                }
                if ($currentDate->lessThan($serviceRequest->due_date)) {
                    throw new HttpException(400, 'Cannot start progress before the due date.');
                }

                $serviceRequest->status = ServiceRequest::STATUS_IN_PROGRESS;
                break;

            case ServiceRequest::STATUS_COMPLETED:
                if ($serviceRequest->status !== ServiceRequest::STATUS_IN_PROGRESS) {
                    throw new HttpException(400, 'Invalid status transition.');
                }

                $serviceRequest->status = ServiceRequest::STATUS_COMPLETED;
                break;

            default:
                throw new HttpException(400, 'Invalid status.');
        }

        $serviceRequest->save();

        if ($serviceRequest->status === ServiceRequest::STATUS_IN_PROGRESS) {
            $this->createMaintenanceCompanyRecord($serviceRequest);
        }

        return $serviceRequest;
    }

    private function createMaintenanceCompanyRecord(ServiceRequest $serviceRequest): void
    {
        $this->aircraftMaintenanceCompany->create([
            'service_requests_id' => $serviceRequest->id,
            'aircraft_id' => $serviceRequest->aircraft_id,
            'maintenance_company_id' => $serviceRequest->maintenance_company_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
