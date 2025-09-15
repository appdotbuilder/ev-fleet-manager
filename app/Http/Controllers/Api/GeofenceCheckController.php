<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeofenceResource;
use App\Models\Geofence;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GeofenceCheckController extends Controller
{
    /**
     * Check if a point is within geofences.
     */
    public function store(Request $request): JsonResponse
    {
        $tenantId = $request->header('X-Tenant-ID');
        
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'geofence_ids' => 'nullable|array',
            'geofence_ids.*' => 'integer|exists:geofences,id',
        ]);

        $query = Geofence::where('tenant_id', $tenantId)
            ->where('is_active', true);

        if (isset($validated['geofence_ids'])) {
            $query->whereIn('id', $validated['geofence_ids']);
        }

        $geofences = $query->get();
        $matches = [];

        foreach ($geofences as $geofence) {
            $isInside = false;

            if ($geofence->type === 'circular') {
                $distance = $this->calculateDistance(
                    $validated['latitude'],
                    $validated['longitude'],
                    $geofence->center_latitude,
                    $geofence->center_longitude
                );
                $isInside = $distance <= $geofence->radius;
            } elseif ($geofence->type === 'polygon' && $geofence->polygon_coordinates) {
                $isInside = $this->pointInPolygon(
                    $validated['latitude'],
                    $validated['longitude'],
                    $geofence->polygon_coordinates
                );
            }

            if ($isInside) {
                $matches[] = new GeofenceResource($geofence);
            }
        }

        return response()->json([
            'point' => [
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude']
            ],
            'matches' => $matches,
            'total_matches' => count($matches)
        ]);
    }

    /**
     * Calculate distance between two points in meters.
     */
    protected function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Check if a point is inside a polygon using ray casting algorithm.
     */
    protected function pointInPolygon(float $lat, float $lng, array $polygon): bool
    {
        $vertices = count($polygon);
        $inside = false;

        for ($i = 0, $j = $vertices - 1; $i < $vertices; $j = $i++) {
            $xi = $polygon[$i]['lng'];
            $yi = $polygon[$i]['lat'];
            $xj = $polygon[$j]['lng'];
            $yj = $polygon[$j]['lat'];

            if ((($yi > $lat) !== ($yj > $lat)) &&
                ($lng < ($xj - $xi) * ($lat - $yi) / ($yj - $yi) + $xi)) {
                $inside = !$inside;
            }
        }

        return $inside;
    }
}