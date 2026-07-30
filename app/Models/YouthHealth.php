<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'national_code', 'full_name', 'age', 'gender', 'age_group',
    'education_level', 'program_attended', 'session_date', 'topics_covered',
    'health_screening_results', 'mental_health_screening',
    'substance_abuse_screening', 'bmi', 'risk_behaviors', 'referrals_made',
    'follow_up_status', 'status', 'notes', 'created_by', 'updated_by',
])]
class YouthHealth extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'youth_health';

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'session_date' => 'date',
            'bmi' => 'decimal:1',
            'health_screening_results' => 'array',
            'risk_behaviors' => 'array',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
