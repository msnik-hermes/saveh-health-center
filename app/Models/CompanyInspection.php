<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'company_id', 'company_name', 'inspector_id', 'inspection_type',
    'inspection_date', 'workers_inspected', 'findings', 'violations_found',
    'compliance_score', 'violations', 'corrective_actions', 'next_inspection_date',
    'status', 'photos', 'notes', 'created_by', 'updated_by',
])]
class CompanyInspection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'company_inspections';

    protected function casts(): array
    {
        return [
            'inspection_date' => 'date',
            'workers_inspected' => 'integer',
            'violations_found' => 'integer',
            'compliance_score' => 'decimal:2',
            'next_inspection_date' => 'date',
            'violations' => 'array',
            'photos' => 'array',
        ];
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'inspector_id');
    }
}
