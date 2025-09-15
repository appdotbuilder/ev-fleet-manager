<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Geofence;
use App\Models\MaintenanceRecord;
use App\Models\Tenant;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class FleetManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo tenants
        $tenants = [
            [
                'name' => 'EcoRide Transportation',
                'slug' => 'ecoride',
                'domain' => 'ecoride.evfleet.app',
                'database_name' => 'evfleet_ecoride',
                'status' => 'active',
            ],
            [
                'name' => 'GreenFleet Logistics',
                'slug' => 'greenfleet',
                'domain' => 'greenfleet.evfleet.app',
                'database_name' => 'evfleet_greenfleet',
                'status' => 'active',
            ],
            [
                'name' => 'Urban Mobility Solutions',
                'slug' => 'urban-mobility',
                'domain' => 'urbanmobility.evfleet.app',
                'database_name' => 'evfleet_urbanmobility',
                'status' => 'active',
            ],
        ];

        foreach ($tenants as $tenantData) {
            $tenant = Tenant::create($tenantData);

            // Create vehicle types for each tenant
            $vehicleTypes = [
                [
                    'name' => 'Urban E-Bike',
                    'category' => 'e-bike',
                    'description' => 'Lightweight electric bike for urban delivery and commuting',
                    'specifications' => [
                        'battery_capacity' => '10 kWh',
                        'max_speed' => '35 km/h',
                        'range' => '60 km',
                        'charging_time' => '4 hours',
                    ],
                ],
                [
                    'name' => 'Cargo Tuk-Tuk',
                    'category' => 'tuk-tuk',
                    'description' => 'Electric three-wheeler for passenger and cargo transport',
                    'specifications' => [
                        'battery_capacity' => '15 kWh',
                        'max_speed' => '50 km/h',
                        'range' => '100 km',
                        'passenger_capacity' => 4,
                    ],
                ],
                [
                    'name' => 'City Bus',
                    'category' => 'bus',
                    'description' => 'Electric bus for public transportation',
                    'specifications' => [
                        'battery_capacity' => '300 kWh',
                        'max_speed' => '100 km/h',
                        'range' => '250 km',
                        'passenger_capacity' => 40,
                    ],
                ],
            ];

            foreach ($vehicleTypes as $typeData) {
                $vehicleType = VehicleType::create(array_merge($typeData, ['tenant_id' => $tenant->id]));

                // Create vehicles for each type
                $vehicleCount = 2; // default
                if ($typeData['category'] === 'e-bike') {
                    $vehicleCount = 8;
                } elseif ($typeData['category'] === 'tuk-tuk') {
                    $vehicleCount = 5;
                } elseif ($typeData['category'] === 'bus') {
                    $vehicleCount = 3;
                }

                Vehicle::factory($vehicleCount)
                    ->for($tenant)
                    ->for($vehicleType)
                    ->create();
            }

            // Create drivers for the tenant
            Driver::factory(12)
                ->for($tenant)
                ->create();

            // Create geofences for the tenant
            Geofence::factory(5)
                ->for($tenant)
                ->create();

            // Create tracking records for vehicles
            $vehicles = $tenant->vehicles;
            foreach ($vehicles as $vehicle) {
                // Create recent tracking records
                VehicleTracking::factory(random_int(10, 30))
                    ->for($tenant)
                    ->for($vehicle)
                    ->recent()
                    ->create();

                // Create maintenance records
                MaintenanceRecord::factory(random_int(2, 8))
                    ->for($tenant)
                    ->for($vehicle)
                    ->create();
            }
        }

        $this->command->info('Fleet management demo data created successfully!');
        $this->command->info('Created:');
        $this->command->info('- ' . Tenant::count() . ' tenants');
        $this->command->info('- ' . VehicleType::count() . ' vehicle types');
        $this->command->info('- ' . Vehicle::count() . ' vehicles');
        $this->command->info('- ' . Driver::count() . ' drivers');
        $this->command->info('- ' . Geofence::count() . ' geofences');
        $this->command->info('- ' . VehicleTracking::count() . ' tracking records');
        $this->command->info('- ' . MaintenanceRecord::count() . ' maintenance records');
    }
}