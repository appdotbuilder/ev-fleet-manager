<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleType>
 */
class VehicleTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['e-bike', 'tuk-tuk', 'bus', 'scooter', 'car', 'truck'];
        $category = fake()->randomElement($categories);
        
        $specifications = match ($category) {
            'e-bike' => [
                'battery_capacity' => fake()->randomFloat(1, 5, 15) . ' kWh',
                'max_speed' => fake()->numberBetween(25, 45) . ' km/h',
                'range' => fake()->numberBetween(40, 80) . ' km',
                'charging_time' => fake()->numberBetween(2, 6) . ' hours',
            ],
            'tuk-tuk' => [
                'battery_capacity' => fake()->randomFloat(1, 8, 20) . ' kWh',
                'max_speed' => fake()->numberBetween(35, 60) . ' km/h',
                'range' => fake()->numberBetween(60, 120) . ' km',
                'passenger_capacity' => fake()->numberBetween(3, 6),
            ],
            'bus' => [
                'battery_capacity' => fake()->randomFloat(1, 200, 400) . ' kWh',
                'max_speed' => fake()->numberBetween(80, 120) . ' km/h',
                'range' => fake()->numberBetween(200, 350) . ' km',
                'passenger_capacity' => fake()->numberBetween(30, 60),
            ],
            default => [
                'battery_capacity' => fake()->randomFloat(1, 10, 30) . ' kWh',
                'max_speed' => fake()->numberBetween(50, 90) . ' km/h',
                'range' => fake()->numberBetween(80, 150) . ' km',
            ],
        };

        return [
            'tenant_id' => Tenant::factory(),
            'name' => fake()->words(2, true) . ' ' . ucfirst($category),
            'category' => $category,
            'description' => fake()->paragraph(),
            'specifications' => $specifications,
            'is_active' => fake()->boolean(85),
        ];
    }

    /**
     * Indicate that the vehicle type is for e-bikes.
     */
    public function ebike(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'e-bike',
            'name' => fake()->company() . ' E-Bike',
            'specifications' => [
                'battery_capacity' => fake()->randomFloat(1, 5, 15) . ' kWh',
                'max_speed' => fake()->numberBetween(25, 45) . ' km/h',
                'range' => fake()->numberBetween(40, 80) . ' km',
                'charging_time' => fake()->numberBetween(2, 6) . ' hours',
            ],
        ]);
    }

    /**
     * Indicate that the vehicle type is for tuk-tuks.
     */
    public function tukTuk(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'tuk-tuk',
            'name' => fake()->company() . ' Tuk-Tuk',
            'specifications' => [
                'battery_capacity' => fake()->randomFloat(1, 8, 20) . ' kWh',
                'max_speed' => fake()->numberBetween(35, 60) . ' km/h',
                'range' => fake()->numberBetween(60, 120) . ' km',
                'passenger_capacity' => fake()->numberBetween(3, 6),
            ],
        ]);
    }
}