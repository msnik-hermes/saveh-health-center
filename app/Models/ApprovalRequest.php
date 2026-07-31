<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'approval_requests';

    protected $fillable = [
        'workflow_id', 'target_type', 'target_id', 'requester_id',
        'current_step', 'status', 'approvals', 'notes', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'approvals' => 'array',
            'current_step' => 'integer',
            'completed_at' => 'datetime',
        ];
    }

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(ApprovalWorkflow::class, 'workflow_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'requester_id');
    }
}
