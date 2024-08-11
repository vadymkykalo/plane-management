<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AircraftRequest;
use App\Services\AircraftService;
use Illuminate\Http\JsonResponse;

class AircraftController extends Controller
{
    protected AircraftService $aircraftService;

    public function __construct(AircraftService $aircraftService)
    {
        $this->aircraftService = $aircraftService;
    }

    public function index(): JsonResponse
    {
        $aircrafts = $this->aircraftService->getAllNotDeleted();
        return response()->json($aircrafts);
    }

    public function store(AircraftRequest $request): JsonResponse
    {
        $aircraft = $this->aircraftService->create($request->validated());
        return response()->json($aircraft, 201);
    }

    public function show(int $id): JsonResponse
    {
        $aircraft = $this->aircraftService->findNotDeletedById($id);
        return response()->json($aircraft);
    }

    public function update(AircraftRequest $request, int $id): JsonResponse
    {
        $aircraft = $this->aircraftService->findNotDeletedById($id);
        $this->aircraftService->update($aircraft, $request->validated());
        return response()->json($aircraft, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $aircraft = $this->aircraftService->findNotDeletedById($id);
        $this->aircraftService->softDelete($aircraft);
        return response()->json(null, 204);
    }

    public function maintenanceHistory(int $aircraftId): JsonResponse
    {
        $history = $this->aircraftService->getMaintenanceHistory($aircraftId);
        return response()->json($history);
    }
}
