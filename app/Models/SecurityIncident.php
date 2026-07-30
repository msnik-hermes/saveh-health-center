<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'incident_date', 'incident_type', 'location', 'severity',
    'persons_involved', 'witnesses', 'description', 'immediate_actions',
    'evidence', 'police_report_number', 'investigation_report',
    'corrective_actions', 'follow_up_status', 'reported_by', 'status',
    'resolution_date', 'notes', 'created_by', 'updated_by',
])]
class SecurityIncident extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'security_incidents';

    protected function casts(): array
    {
        return [
            'incident_date' => 'datetime',
            'evidence' => 'array',
            'resolution_date' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'reported_by');
    }
}
