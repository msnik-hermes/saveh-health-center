<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'material_id', 'center_id', 'distribution_date', 'distribution_method',
    'distributor', 'target_group', 'quantity', 'purpose', 'campaign',
    'recipient_ack', 'feedback', 'photos', 'notes', 'created_by', 'updated_by',
])]
class TrainingDistribution extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'training_distributions';

    protected function casts(): array
    {
        return [
            'distribution_date' => 'date',
            'quantity' => 'integer',
            'recipient_ack' => 'boolean',
            'photos' => 'array',
        ];
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(TrainingMaterial::class, 'material_id');
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
