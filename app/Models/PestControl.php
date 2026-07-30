<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'survey_date', 'location', 'gps_lat', 'gps_lng', 'area_type',
    'pest_type', 'trap_type', 'traps_deployed', 'traps_checked', 'total_catches',
    'species_identified', 'disease_testing', 'environmental_conditions',
    'previous_control', 'recommended_actions', 'follow_up_date', 'notes',
    'created_by', 'updated_by',
])]
class PestControl extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pest_control';

    protected function casts(): array
    {
        return [
            'survey_date' => 'date',
            'gps_lat' => 'decimal:8',
            'gps_lng' => 'decimal:8',
            'traps_deployed' => 'integer',
            'traps_checked' => 'integer',
            'total_catches' => 'integer',
            'follow_up_date' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
