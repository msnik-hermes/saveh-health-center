<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalEquipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'medical_equipment';

    protected $fillable = [
        'center_id', 'name', 'category', 'brand', 'model',
        'serial_number', 'asset_code', 'purchase_date', 'purchase_price',
        'warranty_end', 'location', 'room_id', 'custodian_id',
        'status', 'last_maintenance', 'next_maintenance',
        'maintenance_interval_months', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'integer',
            'purchase_date' => 'date',
            'warranty_end' => 'date',
            'last_maintenance' => 'date',
            'next_maintenance' => 'date',
            'maintenance_interval_months' => 'integer',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function custodian(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'custodian_id');
    }
}
