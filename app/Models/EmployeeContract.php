<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'employee_id', 'contract_type', 'start_date', 'end_date', 'renewal_count',
    'salary_grade', 'benefits', 'insurance_provider', 'insurance_start',
    'pension_source', 'convertible_to_permanent', 'service_region',
    'restrictions', 'legal_basis', 'attachments', 'status', 'notes',
    'created_by', 'updated_by',
])]
class EmployeeContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employee_contracts';

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'insurance_start' => 'date',
            'renewal_count' => 'integer',
            'convertible_to_permanent' => 'boolean',
            'benefits' => 'array',
            'restrictions' => 'array',
            'attachments' => 'array',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
