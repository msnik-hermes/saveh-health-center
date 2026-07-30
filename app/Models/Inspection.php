<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'inspector_id', 'inspection_type', 'date', 'findings',
    'compliance_status', 'corrective_actions', 'images', 'next_inspection_date',
    'status', 'notes', 'created_by', 'updated_by',
])]
class Inspection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inspections';

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'corrective_actions' => 'array',
            'images' => 'array',
            'next_inspection_date' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'inspector_id');
    }
}
