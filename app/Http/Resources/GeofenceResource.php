<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeofenceResource extends JsonResource
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
            'description' => $this->resource->description,
            'type' => $this->resource->type,
            'center' => [
                'latitude' => $this->resource->center_latitude,
                'longitude' => $this->resource->center_longitude,
            ],
            'radius' => $this->when($this->resource->type === 'circular', $this->resource->radius),
            'polygon_coordinates' => $this->when($this->resource->type === 'polygon', $this->resource->polygon_coordinates),
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at->toISOString(),
            'updated_at' => $this->resource->updated_at->toISOString(),
        ];
    }
}