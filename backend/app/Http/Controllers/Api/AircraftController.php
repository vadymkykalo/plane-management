<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AircraftRequest;
use App\Models\Aircraft;

class AircraftController extends Controller
{
    public function index()
    {
        return Aircraft::notDeleted()->get();
    }

    public function store(AircraftRequest $request)
    {
        $aircraft = Aircraft::create($request->validated());
        return response()->json($aircraft, 201);
    }

    public function show($id)
    {
        $aircraft = Aircraft::notDeleted()->findOrFail($id);
        return response()->json($aircraft);
    }

    public function update(AircraftRequest $request, $id)
    {
        $aircraft = Aircraft::notDeleted()->findOrFail($id);
        $aircraft->update($request->validated());
        return response()->json($aircraft, 200);
    }

    public function destroy($id)
    {
        $aircraft = Aircraft::notDeleted()->findOrFail($id);
        $aircraft->is_deleted = true;
        $aircraft->save();
        return response()->json(null, 204);
    }
}
