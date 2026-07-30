<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'pregnant_woman_id', 'center_id', 'visit_date', 'visit_type', 'gestational_week',
    'weight', 'blood_pressure', 'urine_protein', 'urine_sugar', 'fetal_heartbeat',
    'fundal_height', 'hemoglobin', 'ultrasound_performed', 'complications',
    'screening_results', 'tetanus_dose', 'next_visit_date', 'delivery_date',
    'delivery_type', 'delivery_location', 'postnatal_visits', 'pnc_complications',
    'notes', 'created_by', 'updated_by',
])]
class MaternalHealth extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'maternal_health';

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'gestational_week' => 'integer',
            'weight' => 'decimal:1',
            'fundal_height' => 'decimal:1',
            'hemoglobin' => 'decimal:1',
            'tetanus_dose' => 'integer',
            'postnatal_visits' => 'integer',
            'ultrasound_performed' => 'boolean',
            'fetal_heartbeat' => 'boolean',
            'next_visit_date' => 'date',
            'delivery_date' => 'date',
            'screening_results' => 'array',
        ];
    }

    public function pregnantWoman(): BelongsTo
    {
        return $this->belongsTo(PregnantWoman::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
