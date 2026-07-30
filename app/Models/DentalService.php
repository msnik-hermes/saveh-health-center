<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'patient_national_code', 'patient_name', 'patient_age',
    'patient_gender', 'visit_date', 'dentist_id', 'service_type',
    'teeth_involved', 'diagnosis_code', 'treatment_provided', 'materials_used',
    'fee', 'follow_up_needed', 'follow_up_date', 'patient_satisfaction',
    'notes', 'created_by', 'updated_by',
])]
class DentalService extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dental_services';

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'patient_age' => 'integer',
            'materials_used' => 'array',
            'fee' => 'decimal:2',
            'follow_up_needed' => 'boolean',
            'follow_up_date' => 'date',
            'patient_satisfaction' => 'integer',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function dentist(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'dentist_id');
    }
}
