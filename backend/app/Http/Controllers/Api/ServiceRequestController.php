<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequestRequest;
use App\Http\Requests\ServiceRequestUpdateStatusRequest;
use App\Models\AircraftMaintenanceCompany;
use App\Models\ServiceRequest;
use Carbon\Carbon;

class ServiceRequestController extends Controller
{
    public function index()
    {
        return ServiceRequest::notDeleted()->get();
    }

    public function store(ServiceRequestRequest $request)
    {
        $serviceRequest = ServiceRequest::create(array_merge(
            $request->validated(),
            [
                'status' => 'pending'
            ]
        ));

        return response()->json($serviceRequest, 201);
    }

    public function show($id)
    {
        $serviceRequest = ServiceRequest::notDeleted()->findOrFail($id);
        return response()->json($serviceRequest);
    }

    public function update(ServiceRequestRequest $request, $id)
    {
        $serviceRequest = ServiceRequest::notDeleted()->findOrFail($id);
        $serviceRequest->update($request->validated());

        return response()->json($serviceRequest, 200);
    }

    public function destroy($id)
    {
        $serviceRequest = ServiceRequest::notDeleted()->findOrFail($id);
        $serviceRequest->is_deleted = true;
        $serviceRequest->save();
        return response()->json(null, 204);
    }

    public function updateStatus(ServiceRequestUpdateStatusRequest $request, $id)
    {
        $serviceRequest = ServiceRequest::notDeleted()->findOrFail($id);
        $serviceRequest->status = $request->status;
        $serviceRequest->save();

        if ($serviceRequest->status === 'in_progress') {
            $this->createMaintenanceCompanyRecord($serviceRequest);
        }

        return response()->json($serviceRequest, 200);
    }

    private function createMaintenanceCompanyRecord(ServiceRequest $serviceRequest)
    {
        AircraftMaintenanceCompany::create([
            'service_requests_id' => $serviceRequest->id,
            'aircraft_id' => $serviceRequest->aircraft_id,
            'maintenance_company_id' => $serviceRequest->maintenance_company_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
