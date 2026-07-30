<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'woman_national_code', 'woman_name', 'age', 'education_level',
    'living_children', 'pregnancies_count', 'desired_family_size', 'current_method',
    'method_start_date', 'method_change_history', 'side_effects', 'method_satisfaction',
    'counseling_sessions', 'last_visit_date', 'next_visit_date', 'pregnancy_status',
    'referred_to', 'status', 'notes', 'created_by', 'updated_by',
])]
class FamilyPlanning extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'family_planning';

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'living_children' => 'integer',
            'pregnancies_count' => 'integer',
            'desired_family_size' => 'integer',
            'method_satisfaction' => 'integer',
            'counseling_sessions' => 'integer',
            'method_start_date' => 'date',
            'last_visit_date' => 'date',
            'next_visit_date' => 'date',
            'method_change_history' => 'array',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
