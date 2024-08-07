<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index()
    {
        return ServiceRequest::where('is_deleted', false)->get();
    }

    public function store(Request $request)
    {
        $serviceRequest = ServiceRequest::create($request->all());
        return response()->json($serviceRequest, 201);
    }

    public function show($id)
    {
        return ServiceRequest::where('is_deleted', false)->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->update($request->all());
        return response()->json($serviceRequest, 200);
    }

    public function destroy($id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->is_deleted = true;
        $serviceRequest->save();
        return response()->json(null, 204);
    }
}
