<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Geofence>
 */
class GeofenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['circular', 'polygon'];
        $type = fake()->randomElement($types);
        
        $centerLat = fake()->latitude(-90, 90);
        $centerLng = fake()->longitude(-180, 180);
        
        return [
            'tenant_id' => Tenant::factory(),
            'name' => fake()->words(2, true) . ' Zone',
            'description' => fake()->sentence(),
            'type' => $type,
            'center_latitude' => $centerLat,
            'center_longitude' => $centerLng,
            'radius' => $type === 'circular' ? fake()->randomFloat(2, 100, 5000) : null,
            'polygon_coordinates' => $type === 'polygon' ? $this->generatePolygon($centerLat, $centerLng) : null,
            'is_active' => fake()->boolean(85),
        ];
    }

    /**
     * Indicate that the geofence is circular.
     */
    public function circular(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'circular',
            'radius' => fake()->randomFloat(2, 100, 5000),
            'polygon_coordinates' => null,
        ]);
    }

    /**
     * Indicate that the geofence is a polygon.
     */
    public function polygon(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'polygon',
            'radius' => null,
            'polygon_coordinates' => $this->generatePolygon(
                $attributes['center_latitude'] ?? fake()->latitude(-90, 90),
                $attributes['center_longitude'] ?? fake()->longitude(-180, 180)
            ),
        ]);
    }

    /**
     * Generate a simple polygon around a center point.
     */
    protected function generatePolygon(float $centerLat, float $centerLng): array
    {
        $points = [];
        $radius = 0.01; // Roughly 1km
        $numPoints = fake()->numberBetween(4, 8);
        
        for ($i = 0; $i < $numPoints; $i++) {
            $angle = ($i / $numPoints) * 2 * pi();
            $lat = $centerLat + ($radius * cos($angle));
            $lng = $centerLng + ($radius * sin($angle));
            
            $points[] = [
                'lat' => round($lat, 8),
                'lng' => round($lng, 8),
            ];
        }
        
        return $points;
    }
}