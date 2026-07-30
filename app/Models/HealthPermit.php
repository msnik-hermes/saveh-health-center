<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'establishment_id', 'permit_type', 'permit_number', 'issue_date', 'expiry_date',
    'conditions', 'issuing_authority', 'inspector_id', 'fee_paid',
    'payment_reference', 'status', 'suspension_reason', 'renewal_count',
    'previous_permit_id', 'notes', 'created_by', 'updated_by',
])]
class HealthPermit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'health_permits';

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'expiry_date' => 'date',
            'fee_paid' => 'decimal:2',
            'renewal_count' => 'integer',
        ];
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(EnvironmentalEstablishment::class, 'establishment_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'inspector_id');
    }

    public function previousPermit(): BelongsTo
    {
        return $this->belongsTo(HealthPermit::class, 'previous_permit_id');
    }
}
