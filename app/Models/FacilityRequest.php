<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'request_number', 'center_id', 'requested_by', 'facility_type', 'location', 'description',
    'priority', 'preferred_time', 'budget_approval', 'images', 'assigned_to',
    'status', 'completion_date', 'cost', 'notes', 'created_by', 'updated_by',
])]
class FacilityRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'facility_requests';

    protected function casts(): array
    {
        return [
            'preferred_time' => 'datetime',
            'budget_approval' => 'boolean',
            'images' => 'array',
            'completion_date' => 'date',
            'cost' => 'decimal:2',
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

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }
}
