<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VehicleController extends Controller
{
    /**
     * Display a listing of vehicles for the current tenant.
     */
    public function index(Request $request): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        $vehicles = Vehicle::with(['vehicleType', 'trackingRecords' => function ($query) {
            $query->latest('recorded_at')->limit(1);
        }])
        ->where('tenant_id', $tenantId)
        ->when($request->status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->when($request->vehicle_type_id, function ($query, $vehicleTypeId) {
            return $query->where('vehicle_type_id', $vehicleTypeId);
        })
        ->paginate(20);

        return response()->json([
            'data' => VehicleResource::collection($vehicles->items()),
            'pagination' => [
                'current_page' => $vehicles->currentPage(),
                'last_page' => $vehicles->lastPage(),
                'per_page' => $vehicles->perPage(),
                'total' => $vehicles->total(),
            ]
        ]);
    }

    /**
     * Store a newly created vehicle.
     */
    public function store(Request $request): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        $validated = $request->validate([
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'vin' => 'required|string|unique:vehicles',
            'license_plate' => 'nullable|string',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:255',
            'battery_capacity' => 'nullable|numeric|min:0',
        ]);

        $validated['tenant_id'] = $tenantId;

        $vehicle = Vehicle::create($validated);
        $vehicle->load('vehicleType');

        return response()->json([
            'message' => 'Vehicle created successfully',
            'data' => new VehicleResource($vehicle)
        ], 201);
    }

    /**
     * Display the specified vehicle.
     */
    public function show(Request $request, Vehicle $vehicle): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($vehicle->tenant_id !== (int) $tenantId) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $vehicle->load(['vehicleType', 'trackingRecords' => function ($query) {
            $query->latest('recorded_at')->limit(10);
        }, 'maintenanceRecords' => function ($query) {
            $query->latest()->limit(5);
        }]);

        return response()->json([
            'data' => new VehicleResource($vehicle)
        ]);
    }

    /**
     * Update the specified vehicle.
     */
    public function update(Request $request, Vehicle $vehicle): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($vehicle->tenant_id !== (int) $tenantId) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $validated = $request->validate([
            'vehicle_type_id' => 'sometimes|exists:vehicle_types,id',
            'license_plate' => 'nullable|string',
            'color' => 'nullable|string|max:255',
            'status' => 'sometimes|in:active,maintenance,retired,charging',
            'current_battery_level' => 'nullable|numeric|between:0,100',
            'odometer' => 'sometimes|numeric|min:0',
        ]);

        $vehicle->update($validated);
        $vehicle->load('vehicleType');

        return response()->json([
            'message' => 'Vehicle updated successfully',
            'data' => new VehicleResource($vehicle)
        ]);
    }

    /**
     * Remove the specified vehicle.
     */
    public function destroy(Request $request, Vehicle $vehicle): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($vehicle->tenant_id !== (int) $tenantId) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $vehicle->delete();

        return response()->json([
            'message' => 'Vehicle deleted successfully'
        ]);
    }


}