<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name', 'generic_name', 'code', 'type', 'category', 'manufacturer',
    'batch_number', 'expiry_date', 'form', 'strength', 'unit_cost',
    'current_stock', 'minimum_stock', 'maximum_stock', 'storage_temperature',
    'storage_location', 'is_controlled', 'status', 'notes',
    'created_by', 'updated_by',
])]
class VaccineDrug extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vaccines_drugs';

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
            'unit_cost' => 'decimal:2',
            'current_stock' => 'integer',
            'minimum_stock' => 'integer',
            'maximum_stock' => 'integer',
            'is_controlled' => 'boolean',
        ];
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(VaccineDrugDistribution::class, 'vaccine_drug_id');
    }
}
