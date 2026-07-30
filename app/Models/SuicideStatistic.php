<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'case_id', 'full_name', 'national_code', 'age', 'gender',
    'marital_status', 'education_level', 'occupation', 'employment_status',
    'children_count', 'family_size', 'income_level', 'district', 'city_village',
    'neighborhood', 'urban_rural', 'event_date', 'event_time', 'event_location',
    'method', 'premeditated', 'prior_communication', 'witnesses_present',
    'prior_attempts', 'prior_attempt_dates', 'mental_health_diagnosis',
    'psychiatric_treatment', 'substance_use', 'recent_life_events',
    'suicidal_intent', 'suicidal_plan', 'hopelessness_score', 'depression_score',
    'anxiety_score', 'survived', 'injury_severity', 'hospital_admission',
    'hospital_name', 'length_of_stay', 'outcome', 'date_of_death',
    'cause_of_death', 'follow_up_plan', 'emergency_response_time',
    'social_services_involved', 'notes', 'created_by', 'updated_by',
])]
class SuicideStatistic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'suicide_statistics';

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'date_of_death' => 'date',
            'age' => 'integer',
            'children_count' => 'integer',
            'family_size' => 'integer',
            'prior_attempts' => 'integer',
            'length_of_stay' => 'integer',
            'emergency_response_time' => 'integer',
            'premeditated' => 'boolean',
            'prior_communication' => 'boolean',
            'witnesses_present' => 'boolean',
            'psychiatric_treatment' => 'boolean',
            'substance_use' => 'boolean',
            'suicidal_plan' => 'boolean',
            'survived' => 'boolean',
            'hospital_admission' => 'boolean',
            'social_services_involved' => 'boolean',
            'hopelessness_score' => 'decimal:1',
            'depression_score' => 'decimal:1',
            'anxiety_score' => 'decimal:1',
            'mental_health_diagnosis' => 'array',
            'recent_life_events' => 'array',
            'event_time' => 'datetime:H:i',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
