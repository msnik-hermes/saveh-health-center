<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'vehicle_id', 'service_date', 'service_type', 'mileage_at_service',
    'description', 'parts_replaced', 'service_provider', 'cost',
    'next_service_mileage', 'next_service_date', 'invoice', 'notes',
    'created_by', 'updated_by',
])]
class VehicleMaintenance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicle_maintenance';

    protected function casts(): array
    {
        return [
            'service_date' => 'date',
            'mileage_at_service' => 'integer',
            'parts_replaced' => 'array',
            'cost' => 'decimal:2',
            'next_service_mileage' => 'integer',
            'next_service_date' => 'date',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
