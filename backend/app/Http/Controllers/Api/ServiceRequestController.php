<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequestRequest;
use App\Http\Requests\ServiceRequestUpdateStatusRequest;
use App\Services\ServiceRequestService;
use Illuminate\Http\JsonResponse;

class ServiceRequestController extends Controller
{
    protected ServiceRequestService $serviceRequestService;

    public function __construct(ServiceRequestService $serviceRequestService)
    {
        $this->serviceRequestService = $serviceRequestService;
    }

    public function index(): JsonResponse
    {
        $serviceRequests = $this->serviceRequestService->getAll();
        return response()->json($serviceRequests);
    }

    public function store(ServiceRequestRequest $request): JsonResponse
    {
        $serviceRequest = $this->serviceRequestService->create($request->validated());
        return response()->json($serviceRequest, 201);
    }

    public function show(int $id): JsonResponse
    {
        $serviceRequest = $this->serviceRequestService->findById($id);
        return response()->json($serviceRequest);
    }

    public function update(ServiceRequestRequest $request, int $id): JsonResponse
    {
        $serviceRequest = $this->serviceRequestService->findById($id);
        $updatedServiceRequest = $this->serviceRequestService->update($serviceRequest, $request->validated());
        return response()->json($updatedServiceRequest, 200);
    }

    public function updateStatus(ServiceRequestUpdateStatusRequest $request, int $id): JsonResponse
    {
        $serviceRequest = $this->serviceRequestService->findById($id);
        $updatedServiceRequest = $this->serviceRequestService->updateStatus($serviceRequest, $request->status);
        return response()->json($updatedServiceRequest, 200);
    }
}
