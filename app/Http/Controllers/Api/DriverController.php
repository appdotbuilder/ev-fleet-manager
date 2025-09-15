<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DriverController extends Controller
{
    /**
     * Display a listing of drivers for the current tenant.
     */
    public function index(Request $request): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        $drivers = Driver::where('tenant_id', $tenantId)
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('license_number', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(20);

        return response()->json([
            'data' => DriverResource::collection($drivers->items()),
            'pagination' => [
                'current_page' => $drivers->currentPage(),
                'last_page' => $drivers->lastPage(),
                'per_page' => $drivers->perPage(),
                'total' => $drivers->total(),
            ]
        ]);
    }

    /**
     * Store a newly created driver.
     */
    public function store(Request $request): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers',
            'phone' => 'required|string|max:20',
            'license_number' => 'required|string|unique:drivers',
            'license_expiry' => 'required|date|after:today',
            'certifications' => 'nullable|array',
        ]);

        $validated['tenant_id'] = $tenantId;

        $driver = Driver::create($validated);

        return response()->json([
            'message' => 'Driver created successfully',
            'data' => new DriverResource($driver)
        ], 201);
    }

    /**
     * Display the specified driver.
     */
    public function show(Request $request, Driver $driver): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($driver->tenant_id !== (int) $tenantId) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $driver->load(['trackingRecords' => function ($query) {
            $query->with('vehicle')->latest('recorded_at')->limit(10);
        }]);

        return response()->json([
            'data' => new DriverResource($driver)
        ]);
    }

    /**
     * Update the specified driver.
     */
    public function update(Request $request, Driver $driver): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($driver->tenant_id !== (int) $tenantId) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:drivers,email,' . $driver->id,
            'phone' => 'sometimes|string|max:20',
            'license_number' => 'sometimes|string|unique:drivers,license_number,' . $driver->id,
            'license_expiry' => 'sometimes|date|after:today',
            'status' => 'sometimes|in:active,inactive,suspended',
            'certifications' => 'nullable|array',
        ]);

        $driver->update($validated);

        return response()->json([
            'message' => 'Driver updated successfully',
            'data' => new DriverResource($driver)
        ]);
    }

    /**
     * Remove the specified driver.
     */
    public function destroy(Request $request, Driver $driver): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($driver->tenant_id !== (int) $tenantId) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $driver->delete();

        return response()->json([
            'message' => 'Driver deleted successfully'
        ]);
    }
}