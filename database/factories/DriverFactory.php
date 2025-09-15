<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'license_number' => fake()->unique()->bothify('DL###???###'),
            'license_expiry' => fake()->dateTimeBetween('+1 year', '+5 years'),
            'status' => fake()->randomElement(['active', 'inactive', 'suspended']),
            'certifications' => [
                'commercial_license' => fake()->boolean(60),
                'defensive_driving' => fake()->boolean(40),
                'hazmat' => fake()->boolean(20),
                'passenger_endorsement' => fake()->boolean(30),
            ],
            'rating' => fake()->randomFloat(2, 3.0, 5.0),
            'total_trips' => fake()->numberBetween(0, 1000),
            'total_distance' => fake()->randomFloat(2, 0, 50000),
        ];
    }

    /**
     * Indicate that the driver is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'rating' => fake()->randomFloat(2, 4.0, 5.0),
        ]);
    }

    /**
     * Indicate that the driver is experienced.
     */
    public function experienced(): static
    {
        return $this->state(fn (array $attributes) => [
            'total_trips' => fake()->numberBetween(500, 2000),
            'total_distance' => fake()->randomFloat(2, 25000, 100000),
            'rating' => fake()->randomFloat(2, 4.5, 5.0),
            'certifications' => [
                'commercial_license' => true,
                'defensive_driving' => true,
                'hazmat' => fake()->boolean(50),
                'passenger_endorsement' => fake()->boolean(70),
            ],
        ]);
    }
}