<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'school_name', 'school_code', 'school_type', 'school_location',
    'student_population', 'male_count', 'female_count', 'screening_type',
    'screening_date', 'students_screened', 'vision_problems', 'hearing_problems',
    'dental_problems', 'bmi_underweight', 'bmi_normal', 'bmi_overweight',
    'bmi_obese', 'growth_problems', 'anemia_cases', 'referrals_made',
    'referral_outcomes', 'education_sessions', 'topics_covered',
    'students_reached', 'notes', 'created_by', 'updated_by',
])]
class SchoolHealth extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'school_health';

    protected function casts(): array
    {
        return [
            'screening_date' => 'date',
            'student_population' => 'integer',
            'male_count' => 'integer',
            'female_count' => 'integer',
            'students_screened' => 'integer',
            'vision_problems' => 'integer',
            'hearing_problems' => 'integer',
            'dental_problems' => 'integer',
            'bmi_underweight' => 'integer',
            'bmi_normal' => 'integer',
            'bmi_overweight' => 'integer',
            'bmi_obese' => 'integer',
            'growth_problems' => 'integer',
            'anemia_cases' => 'integer',
            'referrals_made' => 'integer',
            'education_sessions' => 'integer',
            'students_reached' => 'integer',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
