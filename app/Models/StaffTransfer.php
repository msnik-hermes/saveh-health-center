<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'employee_id', 'from_center_id', 'to_center_id', 'from_department',
    'to_department', 'transfer_type', 'reason', 'request_date', 'requested_by',
    'gostaresh_review', 'health_deputy_approval', 'council_confirmation',
    'budget_confirmed', 'execution_date', 'status', 'notes', 'created_by', 'updated_by',
])]
class StaffTransfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'staff_transfers';

    protected function casts(): array
    {
        return [
            'request_date' => 'date',
            'execution_date' => 'date',
            'health_deputy_approval' => 'boolean',
            'council_confirmation' => 'boolean',
            'budget_confirmed' => 'boolean',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function fromCenter(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'from_center_id');
    }

    public function toCenter(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'to_center_id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'requested_by');
    }
}
