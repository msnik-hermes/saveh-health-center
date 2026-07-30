<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'case_id', 'disease_category', 'disease_code', 'disease_name',
    'report_date', 'onset_date', 'patient_age', 'patient_gender',
    'patient_occupation', 'residence_location', 'infection_location', 'symptoms',
    'lab_confirmed', 'lab_result', 'severity', 'treatment', 'outcome',
    'contacts_identified', 'contact_tracing_done', 'isolation_applied',
    'report_source', 'follow_up_status', 'notes', 'created_by', 'updated_by',
])]
class DiseaseSurveillance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'disease_surveillance';

    protected function casts(): array
    {
        return [
            'report_date' => 'date',
            'onset_date' => 'date',
            'patient_age' => 'integer',
            'lab_confirmed' => 'boolean',
            'contacts_identified' => 'integer',
            'contact_tracing_done' => 'boolean',
            'isolation_applied' => 'boolean',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
