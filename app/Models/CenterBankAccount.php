<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'bank_name', 'branch_name', 'account_number', 'card_number', 'shaba',
    'account_type', 'purpose', 'is_default', 'balance', 'last_activity', 'status',
    'notes', 'created_by', 'updated_by',
])]
class CenterBankAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'center_bank_accounts';

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'balance' => 'decimal:2',
            'last_activity' => 'datetime',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function utilities(): HasMany
    {
        return $this->hasMany(CenterUtility::class, 'bank_account_id');
    }

    public function financialTransactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class, 'bank_account_id');
    }
}
