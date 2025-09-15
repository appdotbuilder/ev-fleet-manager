<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $makes = ['Tesla', 'BYD', 'Nissan', 'BMW', 'Volkswagen', 'Ford', 'GM', 'Rivian'];
        $statuses = ['active', 'maintenance', 'charging', 'retired'];
        
        return [
            'tenant_id' => Tenant::factory(),
            'vehicle_type_id' => VehicleType::factory(),
            'vin' => strtoupper(fake()->bothify('??#########')),
            'license_plate' => fake()->bothify('??###??'),
            'make' => fake()->randomElement($makes),
            'model' => fake()->words(2, true),
            'year' => fake()->numberBetween(2018, 2024),
            'color' => fake()->colorName(),
            'status' => fake()->randomElement($statuses),
            'battery_capacity' => fake()->randomFloat(2, 10, 100),
            'current_battery_level' => fake()->randomFloat(2, 20, 100),
            'odometer' => fake()->randomFloat(2, 0, 50000),
            'last_maintenance_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'next_maintenance_due' => fake()->dateTimeBetween('now', '+3 months'),
            'maintenance_schedule' => [
                'oil_change' => fake()->numberBetween(5000, 10000) . ' km',
                'tire_rotation' => fake()->numberBetween(10000, 15000) . ' km',
                'battery_check' => fake()->numberBetween(20000, 30000) . ' km',
            ],
            'latitude' => fake()->latitude(-90, 90),
            'longitude' => fake()->longitude(-180, 180),
            'last_location_update' => fake()->dateTimeBetween('-1 hour', 'now'),
        ];
    }

    /**
     * Indicate that the vehicle is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'current_battery_level' => fake()->randomFloat(2, 50, 100),
        ]);
    }

    /**
     * Indicate that the vehicle needs maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'maintenance',
            'next_maintenance_due' => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Indicate that the vehicle has low battery.
     */
    public function lowBattery(): static
    {
        return $this->state(fn (array $attributes) => [
            'current_battery_level' => fake()->randomFloat(2, 5, 20),
            'status' => 'charging',
        ]);
    }
}