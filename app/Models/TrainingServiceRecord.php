<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'material_id', 'session_date', 'session_type', 'topic',
    'trainer', 'duration_hours', 'participants_count', 'unique_reached',
    'attendance_list', 'evaluation_score', 'location', 'photos', 'cost',
    'notes', 'created_by', 'updated_by',
])]
class TrainingServiceRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'training_service_records';

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
            'duration_hours' => 'decimal:1',
            'participants_count' => 'integer',
            'unique_reached' => 'integer',
            'evaluation_score' => 'decimal:2',
            'cost' => 'decimal:2',
            'attendance_list' => 'array',
            'photos' => 'array',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(TrainingMaterial::class, 'material_id');
    }
}
