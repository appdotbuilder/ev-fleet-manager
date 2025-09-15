<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Geofence
 *
 * @property int $id
 * @property int $tenant_id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property float $center_latitude
 * @property float $center_longitude
 * @property float|null $radius
 * @property array|null $polygon_coordinates
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereCenterLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereCenterLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence wherePolygonCoordinates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence whereUpdatedAt($value)
 * @method static \Database\Factories\GeofenceFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Geofence extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'type',
        'center_latitude',
        'center_longitude',
        'radius',
        'polygon_coordinates',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'center_latitude' => 'decimal:8',
        'center_longitude' => 'decimal:8',
        'radius' => 'decimal:2',
        'polygon_coordinates' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the geofence.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}