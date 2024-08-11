<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceCompanyRequest;
use App\Services\MaintenanceCompanyService;
use Illuminate\Http\JsonResponse;

class MaintenanceCompanyController extends Controller
{
    protected MaintenanceCompanyService $maintenanceCompanyService;

    public function __construct(MaintenanceCompanyService $maintenanceCompanyService)
    {
        $this->maintenanceCompanyService = $maintenanceCompanyService;
    }

    public function index(): JsonResponse
    {
        $companies = $this->maintenanceCompanyService->getAllNotDeleted();
        return response()->json($companies);
    }

    public function store(MaintenanceCompanyRequest $request): JsonResponse
    {
        $company = $this->maintenanceCompanyService->create($request->validated());
        return response()->json($company, 201);
    }

    public function show(int $id): JsonResponse
    {
        $company = $this->maintenanceCompanyService->findNotDeletedById($id);
        return response()->json($company);
    }

    public function update(MaintenanceCompanyRequest $request, int $id): JsonResponse
    {
        $company = $this->maintenanceCompanyService->findNotDeletedById($id);
        $this->maintenanceCompanyService->update($company, $request->validated());
        return response()->json($company, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $company = $this->maintenanceCompanyService->findNotDeletedById($id);
        $this->maintenanceCompanyService->softDelete($company);
        return response()->json(null, 204);
    }

    public function maintenanceHistory(int $maintenanceCompanyId): JsonResponse
    {
        $history = $this->maintenanceCompanyService->getMaintenanceHistory($maintenanceCompanyId);
        return response()->json($history);
    }
}
