<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'patient_national_code', 'age', 'gender', 'screening_type',
    'target_group', 'goiter_grade', 'urine_iodine', 'tsh_level', 'free_t4',
    'thyroid_antibodies', 'diagnosis', 'treatment_recommendation',
    'screening_date', 'follow_up_date', 'salt_iodine_test', 'notes',
    'created_by', 'updated_by',
])]
class ThyroidScreening extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'thyroid_screening';

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'urine_iodine' => 'decimal:2',
            'tsh_level' => 'decimal:2',
            'free_t4' => 'decimal:2',
            'salt_iodine_test' => 'decimal:2',
            'screening_date' => 'date',
            'follow_up_date' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
