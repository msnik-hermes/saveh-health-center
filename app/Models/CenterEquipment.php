<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'category', 'name', 'model', 'manufacturer', 'serial_number',
    'purchase_date', 'purchase_price', 'depreciation_value', 'warranty_end',
    'location', 'room_id', 'status', 'condition_rating', 'last_maintenance',
    'next_maintenance', 'maintenance_interval', 'custodian_id', 'insurance_status',
    'documents', 'notes', 'created_by', 'updated_by',
])]
class CenterEquipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'center_equipment';

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'depreciation_value' => 'decimal:2',
            'documents' => 'array',
            'purchase_date' => 'date',
            'warranty_end' => 'date',
            'last_maintenance' => 'date',
            'next_maintenance' => 'date',
            'condition_rating' => 'integer',
            'maintenance_interval' => 'integer',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(CenterRoom::class, 'room_id');
    }

    public function custodian(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'custodian_id');
    }
}
