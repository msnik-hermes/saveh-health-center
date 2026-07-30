<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'bank_account_id', 'type', 'category', 'amount', 'description',
    'reference_number', 'bill_id', 'utility_id', 'form_submission_id', 'budget_id',
    'invoice_number', 'payee_name', 'payment_method', 'transaction_date', 'status',
    'approved_by', 'approval_date', 'attachments', 'notes', 'created_by', 'updated_by',
])]
class FinancialTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financial_transactions';

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'transaction_date' => 'date',
            'approval_date' => 'date',
            'attachments' => 'array',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(CenterBankAccount::class, 'bank_account_id');
    }

    public function utility(): BelongsTo
    {
        return $this->belongsTo(CenterUtility::class, 'utility_id');
    }

    public function formSubmission(): BelongsTo
    {
        return $this->belongsTo(FormSubmission::class, 'form_submission_id');
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }
}
