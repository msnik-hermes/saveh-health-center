<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'patient_national_code', 'referral_date', 'referring_clinician',
    'referring_unit', 'reason', 'urgency', 'referred_to_facility',
    'referred_to_specialty', 'referred_to_clinician', 'documentation_sent',
    'appointment_date', 'patient_attended', 'non_attendance_reason', 'outcome',
    'report_received', 'report_date', 'status', 'notes', 'created_by', 'updated_by',
])]
class Referral extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'referrals';

    protected function casts(): array
    {
        return [
            'referral_date' => 'date',
            'appointment_date' => 'date',
            'report_date' => 'date',
            'patient_attended' => 'boolean',
            'report_received' => 'boolean',
            'documentation_sent' => 'array',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
