<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'room_number', 'name', 'usage_type', 'floor', 'area_sqm',
    'capacity', 'status', 'notes', 'created_by', 'updated_by',
])]
class CenterRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'center_rooms';

    protected function casts(): array
    {
        return [
            'area_sqm' => 'decimal:2',
            'floor' => 'integer',
            'capacity' => 'integer',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(CenterEquipment::class, 'room_id');
    }

    public function medicalEquipment(): HasMany
    {
        return $this->hasMany(MedicalEquipment::class, 'room_id');
    }
}
