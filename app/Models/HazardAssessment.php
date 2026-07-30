<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'company_name', 'company_id', 'assessment_date', 'assessor_name',
    'assessor_qualifications', 'job_title_assessed', 'workers_in_job',
    'daily_work_hours', 'weekly_work_days', 'hazard_categories',
    'physical_hazards', 'chemical_hazards', 'biological_hazards',
    'ergonomic_hazards', 'psychosocial_hazards', 'risk_category', 'overall_risk',
    'control_measures', 'recommendations', 'review_date', 'assessment_report',
    'notes', 'created_by', 'updated_by',
])]
class HazardAssessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hazard_assessments';

    protected function casts(): array
    {
        return [
            'assessment_date' => 'date',
            'review_date' => 'date',
            'workers_in_job' => 'integer',
            'daily_work_hours' => 'decimal:1',
            'weekly_work_days' => 'integer',
            'hazard_categories' => 'array',
            'physical_hazards' => 'array',
            'chemical_hazards' => 'array',
            'biological_hazards' => 'array',
            'ergonomic_hazards' => 'array',
            'psychosocial_hazards' => 'array',
            'control_measures' => 'array',
        ];
    }
}
