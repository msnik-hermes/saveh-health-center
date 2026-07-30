<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'year', 'quarter', 'month', 'total_population', 'male_population',
    'female_population', 'urban_population', 'rural_population', 'age_group_data',
    'household_count', 'avg_household_size', 'births', 'deaths', 'immigration',
    'emigration', 'marital_status_data', 'education_data', 'source', 'notes',
    'created_by', 'updated_by',
])]
class Demographic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'demographics';

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'quarter' => 'integer',
            'month' => 'integer',
            'total_population' => 'integer',
            'male_population' => 'integer',
            'female_population' => 'integer',
            'urban_population' => 'integer',
            'rural_population' => 'integer',
            'household_count' => 'integer',
            'avg_household_size' => 'decimal:1',
            'births' => 'integer',
            'deaths' => 'integer',
            'immigration' => 'integer',
            'emigration' => 'integer',
            'age_group_data' => 'array',
            'marital_status_data' => 'array',
            'education_data' => 'array',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
