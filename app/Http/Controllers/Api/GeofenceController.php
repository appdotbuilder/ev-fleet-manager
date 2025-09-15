<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeofenceResource;
use App\Models\Geofence;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GeofenceController extends Controller
{
    /**
     * Display a listing of geofences for the current tenant.
     */
    public function index(Request $request): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        $geofences = Geofence::where('tenant_id', $tenantId)
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->is_active !== null, function ($query) use ($request) {
                return $query->where('is_active', (bool) $request->is_active);
            })
            ->orderBy('name')
            ->paginate(20);

        return response()->json([
            'data' => GeofenceResource::collection($geofences->items()),
            'pagination' => [
                'current_page' => $geofences->currentPage(),
                'last_page' => $geofences->lastPage(),
                'per_page' => $geofences->perPage(),
                'total' => $geofences->total(),
            ]
        ]);
    }

    /**
     * Store a newly created geofence.
     */
    public function store(Request $request): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:circular,polygon',
            'center_latitude' => 'required|numeric|between:-90,90',
            'center_longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required_if:type,circular|nullable|numeric|min:1',
            'polygon_coordinates' => 'required_if:type,polygon|nullable|array',
            'polygon_coordinates.*' => 'array:lat,lng',
            'polygon_coordinates.*.lat' => 'numeric|between:-90,90',
            'polygon_coordinates.*.lng' => 'numeric|between:-180,180',
        ]);

        $validated['tenant_id'] = $tenantId;

        $geofence = Geofence::create($validated);

        return response()->json([
            'message' => 'Geofence created successfully',
            'data' => new GeofenceResource($geofence)
        ], 201);
    }

    /**
     * Display the specified geofence.
     */
    public function show(Request $request, Geofence $geofence): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($geofence->tenant_id !== (int) $tenantId) {
            return response()->json(['message' => 'Geofence not found'], 404);
        }

        return response()->json([
            'data' => new GeofenceResource($geofence)
        ]);
    }

    /**
     * Update the specified geofence.
     */
    public function update(Request $request, Geofence $geofence): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($geofence->tenant_id !== (int) $tenantId) {
            return response()->json(['message' => 'Geofence not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|in:circular,polygon',
            'center_latitude' => 'sometimes|numeric|between:-90,90',
            'center_longitude' => 'sometimes|numeric|between:-180,180',
            'radius' => 'required_if:type,circular|nullable|numeric|min:1',
            'polygon_coordinates' => 'required_if:type,polygon|nullable|array',
            'polygon_coordinates.*' => 'array:lat,lng',
            'polygon_coordinates.*.lat' => 'numeric|between:-90,90',
            'polygon_coordinates.*.lng' => 'numeric|between:-180,180',
            'is_active' => 'sometimes|boolean',
        ]);

        $geofence->update($validated);

        return response()->json([
            'message' => 'Geofence updated successfully',
            'data' => new GeofenceResource($geofence)
        ]);
    }

    /**
     * Remove the specified geofence.
     */
    public function destroy(Request $request, Geofence $geofence): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($geofence->tenant_id !== (int) $tenantId) {
            return response()->json(['message' => 'Geofence not found'], 404);
        }

        $geofence->delete();

        return response()->json([
            'message' => 'Geofence deleted successfully'
        ]);
    }


}