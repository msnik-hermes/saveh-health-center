<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'employee_id', 'worker_name', 'national_code', 'birth_date', 'current_age',
    'company_name', 'job_title', 'total_service_years', 'hazardous_service_years',
    'education_level', 'family_status', 'dependent_count', 'work_history',
    'occupational_conditions', 'medical_assessment', 'impairment_rating',
    'eligibility', 'recommendation', 'expected_retirement_date',
    'social_security_status', 'case_status', 'application_date',
    'resolution_date', 'notes', 'created_by', 'updated_by',
])]
class EarlyRetirementCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'early_retirement_cases';

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'current_age' => 'integer',
            'total_service_years' => 'decimal:1',
            'hazardous_service_years' => 'decimal:1',
            'dependent_count' => 'integer',
            'impairment_rating' => 'decimal:1',
            'expected_retirement_date' => 'date',
            'application_date' => 'date',
            'resolution_date' => 'date',
            'work_history' => 'array',
            'occupational_conditions' => 'array',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
