<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'item_name', 'category', 'current_quantity', 'minimum_quantity',
    'unit', 'unit_cost', 'last_restock_date', 'supplier', 'storage_location',
    'status', 'notes', 'created_by', 'updated_by',
])]
class SupplyInventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'supply_inventory';

    protected function casts(): array
    {
        return [
            'current_quantity' => 'integer',
            'minimum_quantity' => 'integer',
            'unit_cost' => 'decimal:2',
            'last_restock_date' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
