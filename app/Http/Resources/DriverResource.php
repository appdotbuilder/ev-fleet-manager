<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'license_number' => $this->resource->license_number,
            'license_expiry' => $this->resource->license_expiry->format('Y-m-d'),
            'status' => $this->resource->status,
            'certifications' => $this->resource->certifications,
            'rating' => $this->resource->rating,
            'total_trips' => $this->resource->total_trips,
            'total_distance' => $this->resource->total_distance,
            'recent_trips' => $this->whenLoaded('trackingRecords', function () {
                return $this->resource->trackingRecords->map(function ($record) {
                    return [
                        'id' => $record->id,
                        'vehicle' => $record->whenLoaded('vehicle', function () use ($record) {
                            return [
                                'id' => $record->vehicle->id,
                                'make' => $record->vehicle->make,
                                'model' => $record->vehicle->model,
                                'license_plate' => $record->vehicle->license_plate,
                            ];
                        }),
                        'latitude' => $record->latitude,
                        'longitude' => $record->longitude,
                        'speed' => $record->speed,
                        'recorded_at' => $record->recorded_at->toISOString(),
                    ];
                });
            }),
            'created_at' => $this->resource->created_at->toISOString(),
            'updated_at' => $this->resource->updated_at->toISOString(),
        ];
    }
}