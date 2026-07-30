<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'worker_id', 'worker_name', 'national_code', 'company_name', 'job_title',
    'hazard_exposures', 'examination_type', 'examination_date', 'physician_name',
    'vision_result', 'hearing_result', 'spirometry_result', 'blood_test_result',
    'urine_test_result', 'blood_pressure', 'bmi', 'physical_findings',
    'abnormalities', 'fit_status', 'restrictions', 'referrals',
    'next_examination_date', 'notes', 'created_by', 'updated_by',
])]
class OccupationalExamination extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'occupational_examinations';

    protected function casts(): array
    {
        return [
            'examination_date' => 'date',
            'next_examination_date' => 'date',
            'bmi' => 'decimal:1',
            'hazard_exposures' => 'array',
        ];
    }
}
