<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\VehicleTracking
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $vehicle_id
 * @property int|null $driver_id
 * @property float $latitude
 * @property float $longitude
 * @property float|null $speed
 * @property float|null $heading
 * @property float|null $altitude
 * @property float|null $battery_level
 * @property float|null $odometer
 * @property bool $ignition_on
 * @property array|null $sensors
 * @property \Illuminate\Support\Carbon $recorded_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @property-read \App\Models\Vehicle $vehicle
 * @property-read \App\Models\Driver|null $driver
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking query()
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereBatteryLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereIgnitionOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereRecordedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereSensors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTracking whereVehicleId($value)
 * @method static \Database\Factories\VehicleTrackingFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class VehicleTracking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'vehicle_id',
        'driver_id',
        'latitude',
        'longitude',
        'speed',
        'heading',
        'altitude',
        'battery_level',
        'odometer',
        'ignition_on',
        'sensors',
        'recorded_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'speed' => 'decimal:2',
        'heading' => 'decimal:3',
        'altitude' => 'decimal:2',
        'battery_level' => 'decimal:2',
        'odometer' => 'decimal:2',
        'ignition_on' => 'boolean',
        'sensors' => 'array',
        'recorded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the tracking record.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the vehicle that owns the tracking record.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the driver that owns the tracking record.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}