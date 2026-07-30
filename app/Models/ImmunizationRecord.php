<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'patient_national_code', 'patient_name', 'patient_birth_date',
    'patient_gender', 'vaccine_type', 'dose_number', 'vaccine_name', 'batch_number',
    'administration_date', 'administered_by', 'injection_site', 'next_dose_date',
    'side_effects', 'guardian_name', 'guardian_phone', 'status', 'notes',
    'created_by', 'updated_by',
])]
class ImmunizationRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'immunization_records';

    protected function casts(): array
    {
        return [
            'patient_birth_date' => 'date',
            'dose_number' => 'integer',
            'administration_date' => 'date',
            'next_dose_date' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
