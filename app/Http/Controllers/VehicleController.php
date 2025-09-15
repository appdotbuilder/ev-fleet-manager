<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Inertia\Inertia;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::with(['vehicleType', 'tenant'])
            ->latest()
            ->paginate(12);
        
        return Inertia::render('vehicles/index', [
            'vehicles' => $vehicles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicleTypes = VehicleType::orderBy('name')->get();
        
        return Inertia::render('vehicles/create', [
            'vehicleTypes' => $vehicleTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request)
    {
        $vehicle = Vehicle::create([
            ...$request->validated(),
            'tenant_id' => auth()->user()->tenant_id ?? 1, // Default tenant for demo
        ]);

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Vehicle added to fleet successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['vehicleType', 'tenant', 'trackingRecords', 'maintenanceRecords']);
        
        return Inertia::render('vehicles/show', [
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        $vehicleTypes = VehicleType::orderBy('name')->get();
        
        return Inertia::render('vehicles/edit', [
            'vehicle' => $vehicle,
            'vehicleTypes' => $vehicleTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle removed from fleet.');
    }
}