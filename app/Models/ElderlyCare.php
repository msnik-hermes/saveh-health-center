<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'national_code', 'full_name', 'age', 'gender', 'address',
    'phone', 'village', 'chronic_diseases', 'medications', 'cognitive_screening',
    'depression_screening', 'mobility_status', 'fall_risk', 'nutrition_status',
    'vaccination_status', 'last_checkup_date', 'caregiver_info', 'social_support',
    'services_provided', 'referrals', 'status', 'notes', 'created_by', 'updated_by',
])]
class ElderlyCare extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'elderly_care';

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'last_checkup_date' => 'date',
            'chronic_diseases' => 'array',
            'medications' => 'array',
            'vaccination_status' => 'array',
            'services_provided' => 'array',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
