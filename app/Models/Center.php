<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Center extends Model
{
    use SoftDeletes;

    protected $table = 'centers';

    protected $fillable = [
        'code', 'name', 'type', 'parent_id', 'level', 'university',
        'province', 'city', 'district', 'address', 'postal_code',
        'gps_lat', 'gps_lng', 'phone', 'fax', 'email', 'website',
        'population_served', 'service_area_type', 'area_sqm', 'floors',
        'rooms_count', 'parking_spaces', 'has_elevator', 'has_generator',
        'generator_power_kw', 'has_fire_system', 'has_cctv', 'building_type',
        'status', 'established_date', 'license_number', 'license_expiry',
        'accreditation_level', 'working_hours_start', 'working_hours_end',
        'working_days', 'emergency_hours', 'logo', 'notes',
    ];

    protected $casts = [
        'gps_lat' => 'decimal:8',
        'gps_lng' => 'decimal:8',
        'has_elevator' => 'boolean',
        'has_generator' => 'boolean',
        'has_fire_system' => 'boolean',
        'has_cctv' => 'boolean',
        'population_served' => 'integer',
        'area_sqm' => 'decimal:2',
        'floors' => 'integer',
        'rooms_count' => 'integer',
        'parking_spaces' => 'integer',
        'generator_power_kw' => 'decimal:2',
        'working_hours_start' => 'datetime:H:i',
        'working_hours_end' => 'datetime:H:i',
        'established_date' => 'date',
        'license_expiry' => 'date',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function facilityRequests(): HasMany
    {
        return $this->hasMany(FacilityRequest::class);
    }

    public function itRequests(): HasMany
    {
        return $this->hasMany(ItRequest::class);
    }

    public function vehicleRequests(): HasMany
    {
        return $this->hasMany(VehicleRequest::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function pregnantWomen(): HasMany
    {
        return $this->hasMany(PregnantWoman::class);
    }

    public function diseaseSurveillances(): HasMany
    {
        return $this->hasMany(DiseaseSurveillance::class);
    }
}
