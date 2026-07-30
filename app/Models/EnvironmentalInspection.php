<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'establishment_id', 'center_id', 'inspector_id', 'inspection_type',
    'inspection_date', 'personal_hygiene_score', 'facility_conditions_score',
    'food_safety_score', 'cleaning_sanitation_score', 'pest_control_score',
    'water_quality_score', 'chemical_safety_score', 'waste_management_score',
    'overall_score', 'compliance_level', 'critical_violations', 'major_violations',
    'minor_violations', 'violations_detail', 'positive_findings', 'images',
    'recommendations', 'corrective_actions', 'follow_up_needed', 'follow_up_date',
    'status', 'notes', 'created_by', 'updated_by',
])]
class EnvironmentalInspection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'environmental_inspections';

    protected function casts(): array
    {
        return [
            'inspection_date' => 'date',
            'personal_hygiene_score' => 'integer',
            'facility_conditions_score' => 'integer',
            'food_safety_score' => 'integer',
            'cleaning_sanitation_score' => 'integer',
            'pest_control_score' => 'integer',
            'water_quality_score' => 'integer',
            'chemical_safety_score' => 'integer',
            'waste_management_score' => 'integer',
            'overall_score' => 'decimal:2',
            'critical_violations' => 'integer',
            'major_violations' => 'integer',
            'minor_violations' => 'integer',
            'follow_up_needed' => 'boolean',
            'follow_up_date' => 'date',
            'violations_detail' => 'array',
            'images' => 'array',
            'corrective_actions' => 'array',
        ];
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(EnvironmentalEstablishment::class, 'establishment_id');
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'inspector_id');
    }
}
