<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'pregnant_woman_id', 'center_id', 'child_national_code', 'child_name',
    'birth_date', 'gender', 'birth_weight', 'birth_length', 'gestational_age',
    'apgar_score', 'birth_complications', 'breastfeeding_initiated',
    'breastfeeding_type', 'growth_monitoring', 'vaccination_status',
    'development_milestones', 'last_checkup_date', 'health_problems',
    'referrals', 'status', 'notes', 'created_by', 'updated_by',
])]
class InfantChild extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'infants_children';

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'birth_weight' => 'decimal:1',
            'birth_length' => 'decimal:1',
            'gestational_age' => 'integer',
            'last_checkup_date' => 'date',
            'breastfeeding_initiated' => 'boolean',
            'growth_monitoring' => 'array',
            'vaccination_status' => 'array',
            'development_milestones' => 'array',
        ];
    }

    public function pregnantWoman(): BelongsTo
    {
        return $this->belongsTo(PregnantWoman::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
