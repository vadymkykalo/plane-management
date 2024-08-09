<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceCompanyRequest;
use App\Models\MaintenanceCompany;

class MaintenanceCompanyController extends Controller
{
    public function index()
    {
        return MaintenanceCompany::notDeleted()->get();
    }

    public function store(MaintenanceCompanyRequest $request)
    {
        $maintenanceCompany = MaintenanceCompany::create($request->validated());
        return response()->json($maintenanceCompany, 201);
    }

    public function show($id)
    {
        $maintenanceCompany = MaintenanceCompany::notDeleted()->findOrFail($id);
        return response()->json($maintenanceCompany);
    }

    public function update(MaintenanceCompanyRequest $request, $id)
    {
        $maintenanceCompany = MaintenanceCompany::notDeleted()->findOrFail($id);
        $maintenanceCompany->update($request->validated());
        return response()->json($maintenanceCompany, 200);
    }

    public function destroy($id)
    {
        $maintenanceCompany = MaintenanceCompany::notDeleted()->findOrFail($id);
        $maintenanceCompany->is_deleted = true;
        $maintenanceCompany->save();
        return response()->json(null, 204);
    }
}
