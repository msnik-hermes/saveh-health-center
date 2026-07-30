<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'room_id', 'name', 'model', 'manufacturer', 'serial_number',
    'purchase_date', 'purchase_price', 'warranty_end', 'status',
    'condition_rating', 'last_maintenance', 'next_maintenance', 'calibration_due',
    'notes', 'created_by', 'updated_by',
])]
class MedicalEquipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'medical_equipment';

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'purchase_date' => 'date',
            'warranty_end' => 'date',
            'last_maintenance' => 'date',
            'next_maintenance' => 'date',
            'calibration_due' => 'date',
            'condition_rating' => 'integer',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(CenterRoom::class, 'room_id');
    }
}
