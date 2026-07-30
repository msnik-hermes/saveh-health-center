<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'national_code', 'full_name', 'age', 'husband_name', 'phone',
    'address', 'village', 'gravida', 'parity', 'abortion_count', 'living_children',
    'lmp_date', 'edd_date', 'registration_date', 'first_anc_date', 'blood_type',
    'rh_factor', 'medical_history', 'risk_factors', 'current_medications',
    'tetanus_vaccination', 'iron_supplementation', 'folic_acid', 'anc_visits_count',
    'status', 'notes', 'created_by', 'updated_by',
])]
class PregnantWoman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pregnant_women';

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'gravida' => 'integer',
            'parity' => 'integer',
            'abortion_count' => 'integer',
            'living_children' => 'integer',
            'anc_visits_count' => 'integer',
            'lmp_date' => 'date',
            'edd_date' => 'date',
            'registration_date' => 'date',
            'first_anc_date' => 'date',
            'iron_supplementation' => 'boolean',
            'folic_acid' => 'boolean',
            'risk_factors' => 'array',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function maternalHealthRecords(): HasMany
    {
        return $this->hasMany(MaternalHealth::class);
    }

    public function infantsChildren(): HasMany
    {
        return $this->hasMany(InfantChild::class);
    }
}
