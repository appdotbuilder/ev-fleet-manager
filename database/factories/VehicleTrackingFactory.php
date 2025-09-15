<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Tenant;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleTracking>
 */
class VehicleTrackingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'vehicle_id' => Vehicle::factory(),
            'driver_id' => fake()->boolean(70) ? Driver::factory() : null,
            'latitude' => fake()->latitude(-90, 90),
            'longitude' => fake()->longitude(-180, 180),
            'speed' => fake()->randomFloat(2, 0, 120),
            'heading' => fake()->randomFloat(3, 0, 360),
            'altitude' => fake()->randomFloat(2, 0, 1000),
            'battery_level' => fake()->randomFloat(2, 20, 100),
            'odometer' => fake()->randomFloat(2, 0, 50000),
            'ignition_on' => fake()->boolean(60),
            'sensors' => [
                'temperature' => fake()->randomFloat(1, 15, 35) . '°C',
                'humidity' => fake()->randomFloat(1, 30, 80) . '%',
                'tire_pressure' => fake()->randomFloat(1, 28, 35) . ' PSI',
            ],
            'recorded_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ];
    }

    /**
     * Indicate that the vehicle is moving.
     */
    public function moving(): static
    {
        return $this->state(fn (array $attributes) => [
            'speed' => fake()->randomFloat(2, 20, 80),
            'ignition_on' => true,
        ]);
    }

    /**
     * Indicate that the vehicle is parked.
     */
    public function parked(): static
    {
        return $this->state(fn (array $attributes) => [
            'speed' => 0,
            'ignition_on' => false,
        ]);
    }

    /**
     * Indicate recent tracking data.
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'recorded_at' => fake()->dateTimeBetween('-1 hour', 'now'),
        ]);
    }
}