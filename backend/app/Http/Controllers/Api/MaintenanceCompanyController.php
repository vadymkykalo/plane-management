<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceCompany;
use Illuminate\Http\Request;

class MaintenanceCompanyController extends Controller
{
    public function index()
    {
        return MaintenanceCompany::where('is_deleted', false)->get();
    }

    public function store(Request $request)
    {
        $maintenanceCompany = MaintenanceCompany::create($request->all());
        return response()->json($maintenanceCompany, 201);
    }

    public function show($id)
    {
        return MaintenanceCompany::where('is_deleted', false)->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $maintenanceCompany = MaintenanceCompany::findOrFail($id);
        $maintenanceCompany->update($request->all());
        return response()->json($maintenanceCompany, 200);
    }

    public function destroy($id)
    {
        $maintenanceCompany = MaintenanceCompany::findOrFail($id);
        $maintenanceCompany->is_deleted = true;
        $maintenanceCompany->save();
        return response()->json(null, 204);
    }
}
