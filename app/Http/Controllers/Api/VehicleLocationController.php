<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VehicleLocationController extends Controller
{
    /**
     * Update vehicle location from GPS tracking.
     */
    public function update(Request $request, Vehicle $vehicle): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($vehicle->tenant_id !== (int) $tenantId) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed' => 'nullable|numeric|min:0',
            'heading' => 'nullable|numeric|between:0,360',
            'battery_level' => 'nullable|numeric|between:0,100',
            'ignition_on' => 'boolean',
        ]);

        // Update vehicle's current location
        $vehicle->update([
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'current_battery_level' => $validated['battery_level'] ?? $vehicle->current_battery_level,
            'last_location_update' => now(),
        ]);

        // Store tracking record
        $vehicle->trackingRecords()->create([
            'tenant_id' => $tenantId,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'speed' => $validated['speed'],
            'heading' => $validated['heading'],
            'battery_level' => $validated['battery_level'],
            'ignition_on' => $validated['ignition_on'] ?? false,
            'recorded_at' => now(),
        ]);

        return response()->json([
            'message' => 'Vehicle location updated successfully',
            'data' => new VehicleResource($vehicle->fresh())
        ]);
    }
}