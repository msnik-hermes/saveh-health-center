<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'form_template_id', 'center_id', 'submitted_by', 'form_data', 'status',
    'priority', 'assigned_to', 'assigned_department', 'due_date', 'completion_date',
    'completion_notes', 'attachments', 'timeline', 'created_by', 'updated_by',
])]
class FormSubmission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_submissions';

    protected function casts(): array
    {
        return [
            'form_data' => 'array',
            'attachments' => 'array',
            'timeline' => 'array',
            'due_date' => 'date',
            'completion_date' => 'date',
        ];
    }

    public function formTemplate(): BelongsTo
    {
        return $this->belongsTo(FormTemplate::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'submitted_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function financialTransactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class, 'form_submission_id');
    }
}
