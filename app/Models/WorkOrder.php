<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'facility_request_id', 'order_number', 'category',
    'location_building', 'location_floor', 'location_room', 'priority',
    'description', 'assigned_technician', 'status', 'start_time', 'completion_time',
    'materials_used', 'cost', 'before_photos', 'after_photos', 'supervisor_approval',
    'notes', 'created_by', 'updated_by',
])]
class WorkOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'work_orders';

    protected function casts(): array
    {
        return [
            'location_floor' => 'integer',
            'materials_used' => 'array',
            'before_photos' => 'array',
            'after_photos' => 'array',
            'cost' => 'decimal:2',
            'supervisor_approval' => 'boolean',
            'start_time' => 'datetime',
            'completion_time' => 'datetime',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function facilityRequest(): BelongsTo
    {
        return $this->belongsTo(FacilityRequest::class);
    }

    public function assignedTechnician(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_technician');
    }
}
