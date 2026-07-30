<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'patient_national_code', 'patient_name', 'disease_type',
    'diagnosis_date', 'diagnosis_confirmed_by', 'current_medications',
    'last_visit_date', 'next_visit_date', 'lab_results', 'vital_signs',
    'hba1c', 'blood_pressure', 'bmi', 'complication_screening',
    'control_status', 'referred_to', 'treatment_plan', 'adherence_level',
    'status', 'notes', 'created_by', 'updated_by',
])]
class ChronicDiseaseTracking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chronic_disease_tracking';

    protected function casts(): array
    {
        return [
            'diagnosis_date' => 'date',
            'last_visit_date' => 'date',
            'next_visit_date' => 'date',
            'current_medications' => 'array',
            'lab_results' => 'array',
            'vital_signs' => 'array',
            'complication_screening' => 'array',
            'hba1c' => 'decimal:1',
            'bmi' => 'decimal:1',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
