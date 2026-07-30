<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'vehicle_id', 'driver_id', 'vehicle_request_id', 'trip_date', 'departure_time',
    'return_time', 'origin', 'destination', 'route', 'start_mileage', 'end_mileage',
    'total_distance', 'fuel_filled', 'fuel_cost', 'passenger_list', 'trip_purpose',
    'notes', 'created_by', 'updated_by',
])]
class VehicleTrip extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicle_trips';

    protected function casts(): array
    {
        return [
            'trip_date' => 'date',
            'departure_time' => 'datetime:H:i',
            'return_time' => 'datetime:H:i',
            'start_mileage' => 'integer',
            'end_mileage' => 'integer',
            'total_distance' => 'integer',
            'fuel_filled' => 'decimal:1',
            'fuel_cost' => 'decimal:2',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicleRequest(): BelongsTo
    {
        return $this->belongsTo(VehicleRequest::class);
    }
}
