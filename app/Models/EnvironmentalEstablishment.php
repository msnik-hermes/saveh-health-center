<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'name', 'name_english', 'type', 'address', 'gps_lat', 'gps_lng',
    'owner_name', 'owner_national_code', 'owner_phone', 'manager_name',
    'business_license_number', 'health_permit_number', 'health_permit_issue_date',
    'health_permit_expiry', 'employee_count', 'business_hours', 'risk_category',
    'compliance_status', 'last_inspection_date', 'next_inspection_due',
    'violations_history', 'status', 'notes', 'created_by', 'updated_by',
])]
class EnvironmentalEstablishment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'environmental_establishments';

    protected function casts(): array
    {
        return [
            'gps_lat' => 'decimal:8',
            'gps_lng' => 'decimal:8',
            'employee_count' => 'integer',
            'health_permit_issue_date' => 'date',
            'health_permit_expiry' => 'date',
            'last_inspection_date' => 'date',
            'next_inspection_due' => 'date',
            'violations_history' => 'array',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function environmentalInspections(): HasMany
    {
        return $this->hasMany(EnvironmentalInspection::class, 'establishment_id');
    }

    public function healthPermits(): HasMany
    {
        return $this->hasMany(HealthPermit::class, 'establishment_id');
    }
}
