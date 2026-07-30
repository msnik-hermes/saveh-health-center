<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'fiscal_year', 'budget_code', 'category', 'sub_category',
    'unit_allocation', 'allocated_amount', 'spent_amount', 'committed_amount',
    'remaining_amount', 'utilization_pct', 'status', 'justification',
    'approval_authority', 'notes', 'created_by', 'updated_by',
])]
class Budget extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'budgets';

    protected function casts(): array
    {
        return [
            'fiscal_year' => 'integer',
            'allocated_amount' => 'decimal:2',
            'spent_amount' => 'decimal:2',
            'committed_amount' => 'decimal:2',
            'remaining_amount' => 'decimal:2',
            'utilization_pct' => 'decimal:2',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function financialTransactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class, 'budget_id');
    }
}
