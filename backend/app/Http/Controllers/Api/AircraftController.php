<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use Illuminate\Http\Request;

class AircraftController extends Controller
{
    public function index()
    {
        return Aircraft::where('is_deleted', false)->get();
    }

    public function store(Request $request)
    {
        $aircraft = Aircraft::create($request->all());
        return response()->json($aircraft, 201);
    }

    public function show($id)
    {
        return Aircraft::where('is_deleted', false)->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $aircraft = Aircraft::findOrFail($id);
        $aircraft->update($request->all());
        return response()->json($aircraft, 200);
    }

    public function destroy($id)
    {
        $aircraft = Aircraft::findOrFail($id);
        $aircraft->is_deleted = true;
        $aircraft->save();
        return response()->json(null, 204);
    }
}
