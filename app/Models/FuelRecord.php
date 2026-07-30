<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'vehicle_id', 'date', 'fuel_type', 'quantity', 'cost', 'fuel_card_number',
    'mileage', 'station', 'receipt_number', 'notes', 'created_by', 'updated_by',
])]
class FuelRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fuel_records';

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'quantity' => 'decimal:1',
            'cost' => 'decimal:2',
            'mileage' => 'integer',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
