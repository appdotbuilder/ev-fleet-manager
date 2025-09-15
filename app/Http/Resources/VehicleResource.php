<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'vin' => $this->resource->vin,
            'license_plate' => $this->resource->license_plate,
            'make' => $this->resource->make,
            'model' => $this->resource->model,
            'year' => $this->resource->year,
            'color' => $this->resource->color,
            'status' => $this->resource->status,
            'battery_capacity' => $this->resource->battery_capacity,
            'current_battery_level' => $this->resource->current_battery_level,
            'odometer' => $this->resource->odometer,
            'last_maintenance_date' => $this->resource->last_maintenance_date?->format('Y-m-d'),
            'next_maintenance_due' => $this->resource->next_maintenance_due?->format('Y-m-d'),
            'maintenance_schedule' => $this->resource->maintenance_schedule,
            'location' => [
                'latitude' => $this->resource->latitude,
                'longitude' => $this->resource->longitude,
                'last_updated' => $this->resource->last_location_update?->toISOString(),
            ],
            'vehicle_type' => $this->whenLoaded('vehicleType', function () {
                return [
                    'id' => $this->resource->vehicleType->id,
                    'name' => $this->resource->vehicleType->name,
                    'category' => $this->resource->vehicleType->category,
                    'specifications' => $this->resource->vehicleType->specifications,
                ];
            }),
            'latest_tracking' => $this->whenLoaded('trackingRecords', function () {
                return $this->resource->trackingRecords->map(function ($record) {
                    return [
                        'id' => $record->id,
                        'latitude' => $record->latitude,
                        'longitude' => $record->longitude,
                        'speed' => $record->speed,
                        'heading' => $record->heading,
                        'battery_level' => $record->battery_level,
                        'ignition_on' => $record->ignition_on,
                        'recorded_at' => $record->recorded_at->toISOString(),
                    ];
                });
            }),
            'maintenance_records' => $this->whenLoaded('maintenanceRecords', function () {
                return $this->resource->maintenanceRecords->map(function ($record) {
                    return [
                        'id' => $record->id,
                        'type' => $record->type,
                        'title' => $record->title,
                        'status' => $record->status,
                        'scheduled_date' => $record->scheduled_date->format('Y-m-d'),
                        'completed_date' => $record->completed_date?->format('Y-m-d'),
                        'cost' => $record->cost,
                    ];
                });
            }),
            'created_at' => $this->resource->created_at->toISOString(),
            'updated_at' => $this->resource->updated_at->toISOString(),
        ];
    }
}