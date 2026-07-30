<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'requested_by', 'vehicle_id', 'driver_id', 'trip_purpose',
    'origin', 'destination', 'departure_datetime', 'expected_return',
    'passenger_count', 'passenger_list', 'status', 'notes',
    'created_by', 'updated_by',
])]
class VehicleRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicle_requests';

    protected function casts(): array
    {
        return [
            'departure_datetime' => 'datetime',
            'expected_return' => 'datetime',
            'passenger_count' => 'integer',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'requested_by');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(VehicleTrip::class);
    }
}
