<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'requested_by', 'service_type', 'equipment_id',
    'problem_description', 'error_messages', 'priority', 'screenshots',
    'available_time', 'assigned_to', 'status', 'resolution_notes',
    'completion_date', 'notes', 'created_by', 'updated_by',
])]
class ItRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'it_requests';

    protected function casts(): array
    {
        return [
            'screenshots' => 'array',
            'completion_date' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'requested_by');
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(CenterEquipment::class, 'equipment_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}
