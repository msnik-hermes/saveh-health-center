<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id_1', 'center_id_2', 'relation_type', 'description', 'valid_from',
    'valid_to', 'notes', 'created_by', 'updated_by',
])]
class CenterRelation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'center_relations';

    protected function casts(): array
    {
        return [
            'valid_from' => 'date',
            'valid_to' => 'date',
        ];
    }

    public function center1(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id_1');
    }

    public function center2(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id_2');
    }
}
