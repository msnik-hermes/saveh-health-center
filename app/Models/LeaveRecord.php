<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'employee_id', 'leave_type', 'start_date', 'end_date', 'days_count', 'reason',
    'attachments', 'approved_by', 'approval_date', 'status', 'substitution_arranged',
    'replacement_id', 'notes', 'created_by', 'updated_by',
])]
class LeaveRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'leave_records';

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'approval_date' => 'date',
            'days_count' => 'integer',
            'substitution_arranged' => 'boolean',
            'attachments' => 'array',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    public function replacement(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'replacement_id');
    }
}
