<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaintenanceRecord>
 */
class MaintenanceRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['scheduled', 'unscheduled', 'emergency'];
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
        $type = fake()->randomElement($types);
        $status = fake()->randomElement($statuses);
        
        $maintenanceTypes = [
            'Battery Check and Replacement',
            'Tire Inspection and Rotation',
            'Brake System Service',
            'Charging Port Maintenance',
            'Software Update',
            'Motor Inspection',
            'Cooling System Service',
            'General Safety Inspection',
        ];
        
        $title = fake()->randomElement($maintenanceTypes);
        
        return [
            'tenant_id' => Tenant::factory(),
            'vehicle_id' => Vehicle::factory(),
            'type' => $type,
            'title' => $title,
            'description' => fake()->paragraph(),
            'status' => $status,
            'scheduled_date' => fake()->dateTimeBetween('-1 month', '+2 months'),
            'completed_date' => $status === 'completed' ? 
                fake()->dateTimeBetween('-1 month', 'now') : null,
            'cost' => fake()->boolean(60) ? fake()->randomFloat(2, 50, 2000) : null,
            'technician_name' => fake()->name(),
            'parts_replaced' => fake()->boolean(40) ? [
                fake()->randomElement(['Battery Pack', 'Brake Pads', 'Tires', 'Motor', 'Charging Cable']),
                fake()->randomElement(['Filter', 'Sensor', 'Fuse', 'Belt', 'Coolant']),
            ] : null,
            'notes' => fake()->boolean(70) ? fake()->paragraph() : null,
            'odometer_at_service' => fake()->randomFloat(2, 1000, 40000),
        ];
    }

    /**
     * Indicate that the maintenance is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'completed_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'cost' => fake()->randomFloat(2, 100, 1500),
        ]);
    }

    /**
     * Indicate that the maintenance is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'completed_date' => null,
            'scheduled_date' => fake()->dateTimeBetween('now', '+1 month'),
        ]);
    }

    /**
     * Indicate that this is emergency maintenance.
     */
    public function emergency(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'emergency',
            'title' => fake()->randomElement([
                'Emergency Battery Replacement',
                'Critical Motor Failure',
                'Brake System Emergency',
                'Electrical System Failure',
            ]),
            'scheduled_date' => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }
}