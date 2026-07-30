<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'patient_national_code', 'patient_name', 'first_visit_date',
    'visit_date', 'clinician_id', 'service_type', 'presenting_complaint',
    'diagnosis_code', 'severity', 'treatment_plan', 'medications', 'side_effects',
    'session_notes', 'phq9_score', 'gad7_score', 'outcome_measures',
    'referrals_made', 'next_appointment', 'consent_on_file', 'status', 'notes',
    'created_by', 'updated_by',
])]
class MentalHealthClinic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mental_health_clinic';

    protected function casts(): array
    {
        return [
            'first_visit_date' => 'date',
            'visit_date' => 'date',
            'next_appointment' => 'date',
            'phq9_score' => 'decimal:1',
            'gad7_score' => 'decimal:1',
            'consent_on_file' => 'boolean',
            'medications' => 'array',
            'outcome_measures' => 'array',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function clinician(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'clinician_id');
    }
}
