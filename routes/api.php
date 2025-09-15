<?php

use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\VehicleLocationController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\GeofenceController;
use App\Http\Controllers\Api\GeofenceCheckController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Multi-tenant API routes - require X-Tenant-ID header
Route::middleware(['auth:sanctum', \App\Http\Middleware\TenantMiddleware::class])->prefix('v1')->group(function () {
    
    // Vehicle management routes
    Route::apiResource('vehicles', VehicleController::class);
    Route::put('vehicles/{vehicle}/location', [VehicleLocationController::class, 'update'])
        ->name('vehicles.location.update');
    
    // Driver management routes
    Route::apiResource('drivers', DriverController::class);
    
    // Geofencing routes
    Route::apiResource('geofences', GeofenceController::class);
    Route::post('geofence-checks', [GeofenceCheckController::class, 'store'])
        ->name('geofence-checks.store');
    
    // Fleet analytics routes
    Route::prefix('analytics')->group(function () {
        Route::get('fleet-overview', function (Request $request) {
            $tenantId = $request->header('X-Tenant-ID');
            
            return response()->json([
                'total_vehicles' => \App\Models\Vehicle::where('tenant_id', $tenantId)->count(),
                'active_vehicles' => \App\Models\Vehicle::where('tenant_id', $tenantId)->where('status', 'active')->count(),
                'total_drivers' => \App\Models\Driver::where('tenant_id', $tenantId)->count(),
                'active_drivers' => \App\Models\Driver::where('tenant_id', $tenantId)->where('status', 'active')->count(),
                'maintenance_due' => \App\Models\Vehicle::where('tenant_id', $tenantId)
                    ->whereDate('next_maintenance_due', '<=', now()->addDays(7))->count(),
                'low_battery_vehicles' => \App\Models\Vehicle::where('tenant_id', $tenantId)
                    ->where('current_battery_level', '<=', 20)->count(),
            ]);
        })->name('analytics.fleet-overview');
        
        Route::get('vehicle-utilization', function (Request $request) {
            $tenantId = $request->header('X-Tenant-ID');
            
            $vehicles = \App\Models\Vehicle::where('tenant_id', $tenantId)
                ->with(['trackingRecords' => function ($query) {
                    $query->where('recorded_at', '>=', now()->subDays(30))
                        ->selectRaw('vehicle_id, COUNT(*) as tracking_count, AVG(speed) as avg_speed')
                        ->groupBy('vehicle_id');
                }])
                ->get();
                
            return response()->json([
                'vehicles' => $vehicles->map(function ($vehicle) {
                    return [
                        'id' => $vehicle->id,
                        'make' => $vehicle->make,
                        'model' => $vehicle->model,
                        'license_plate' => $vehicle->license_plate,
                        'status' => $vehicle->status,
                        'tracking_points' => $vehicle->trackingRecords->sum('tracking_count') ?? 0,
                        'average_speed' => $vehicle->trackingRecords->avg('avg_speed') ?? 0,
                        'odometer' => $vehicle->odometer,
                        'battery_level' => $vehicle->current_battery_level,
                    ];
                })
            ]);
        })->name('analytics.vehicle-utilization');
    });
});