<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Vehicle
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $vehicle_type_id
 * @property string $vin
 * @property string|null $license_plate
 * @property string $make
 * @property string $model
 * @property int $year
 * @property string|null $color
 * @property string $status
 * @property float|null $battery_capacity
 * @property float|null $current_battery_level
 * @property float $odometer
 * @property string|null $last_maintenance_date
 * @property string|null $next_maintenance_due
 * @property array|null $maintenance_schedule
 * @property float|null $latitude
 * @property float|null $longitude
 * @property \Illuminate\Support\Carbon|null $last_location_update
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @property-read \App\Models\VehicleType $vehicleType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleTracking> $trackingRecords
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MaintenanceRecord> $maintenanceRecords
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereBatteryCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereCurrentBatteryLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereLastLocationUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereLastMaintenanceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereLicensePlate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereMaintenanceSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereMake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereNextMaintenanceDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereVehicleTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereYear($value)
 * @method static \Database\Factories\VehicleFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Vehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'vehicle_type_id',
        'vin',
        'license_plate',
        'make',
        'model',
        'year',
        'color',
        'status',
        'battery_capacity',
        'current_battery_level',
        'odometer',
        'last_maintenance_date',
        'next_maintenance_due',
        'maintenance_schedule',
        'latitude',
        'longitude',
        'last_location_update',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'battery_capacity' => 'decimal:2',
        'current_battery_level' => 'decimal:2',
        'odometer' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'maintenance_schedule' => 'array',
        'last_maintenance_date' => 'date',
        'next_maintenance_due' => 'date',
        'last_location_update' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the vehicle.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the vehicle type that owns the vehicle.
     */
    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    /**
     * Get the tracking records for the vehicle.
     */
    public function trackingRecords(): HasMany
    {
        return $this->hasMany(VehicleTracking::class);
    }

    /**
     * Get the maintenance records for the vehicle.
     */
    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(MaintenanceRecord::class);
    }
}