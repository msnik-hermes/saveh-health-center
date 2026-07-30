<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'employee_id', 'license_number', 'license_type', 'license_expiry',
    'assigned_vehicle_id', 'fuel_card_number', 'driving_record', 'status',
    'notes', 'created_by', 'updated_by',
])]
class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'drivers';

    protected function casts(): array
    {
        return [
            'license_expiry' => 'date',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function assignedVehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'assigned_vehicle_id');
    }

    public function trips(): HasMany
    {
        return $this->hasMany(VehicleTrip::class);
    }

    public function vehicleRequests(): HasMany
    {
        return $this->hasMany(VehicleRequest::class, 'driver_id');
    }
}
