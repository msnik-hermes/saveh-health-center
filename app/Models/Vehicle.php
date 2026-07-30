<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'plate_number', 'make', 'model', 'year', 'color', 'vehicle_type',
    'engine_number', 'chassis_number', 'registration_expiry', 'insurance_number',
    'insurance_expiry', 'fuel_type', 'tank_capacity', 'total_mileage',
    'assigned_driver_id', 'center_id', 'photo', 'status', 'gps_device',
    'notes', 'created_by', 'updated_by',
])]
class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicles';

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'registration_expiry' => 'date',
            'insurance_expiry' => 'date',
            'tank_capacity' => 'decimal:1',
            'total_mileage' => 'integer',
        ];
    }

    public function assignedDriver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'assigned_driver_id');
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class, 'assigned_vehicle_id');
    }

    public function trips(): HasMany
    {
        return $this->hasMany(VehicleTrip::class);
    }

    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(VehicleMaintenance::class);
    }

    public function fuelRecords(): HasMany
    {
        return $this->hasMany(FuelRecord::class);
    }

    public function vehicleRequests(): HasMany
    {
        return $this->hasMany(VehicleRequest::class);
    }
}
