<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MaintenanceRecord
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $vehicle_id
 * @property string $type
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string $scheduled_date
 * @property string|null $completed_date
 * @property float|null $cost
 * @property string|null $technician_name
 * @property array|null $parts_replaced
 * @property string|null $notes
 * @property float|null $odometer_at_service
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @property-read \App\Models\Vehicle $vehicle
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereCompletedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereOdometerAtService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord wherePartsReplaced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereScheduledDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereTechnicianName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaintenanceRecord whereVehicleId($value)
 * @method static \Database\Factories\MaintenanceRecordFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class MaintenanceRecord extends Model
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
        'type',
        'title',
        'description',
        'status',
        'scheduled_date',
        'completed_date',
        'cost',
        'technician_name',
        'parts_replaced',
        'notes',
        'odometer_at_service',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_date' => 'date',
        'completed_date' => 'date',
        'cost' => 'decimal:2',
        'parts_replaced' => 'array',
        'odometer_at_service' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the maintenance record.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the vehicle that owns the maintenance record.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}