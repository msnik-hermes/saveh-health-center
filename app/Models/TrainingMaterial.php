<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'title', 'type', 'category', 'target_audience', 'language', 'production_date',
    'designer', 'reviewer', 'approval_status', 'print_quantity', 'digital_format',
    'file_location', 'version', 'cost', 'current_stock', 'minimum_stock', 'notes',
    'created_by', 'updated_by',
])]
class TrainingMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'training_materials';

    protected function casts(): array
    {
        return [
            'production_date' => 'date',
            'print_quantity' => 'integer',
            'version' => 'integer',
            'cost' => 'decimal:2',
            'current_stock' => 'integer',
            'minimum_stock' => 'integer',
        ];
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(TrainingDistribution::class, 'material_id');
    }

    public function serviceRecords(): HasMany
    {
        return $this->hasMany(TrainingServiceRecord::class, 'material_id');
    }
}
