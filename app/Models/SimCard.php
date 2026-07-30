<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'phone_number', 'provider', 'assigned_to', 'purpose',
    'monthly_cost', 'status', 'activation_date', 'notes',
    'created_by', 'updated_by',
])]
class SimCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sim_cards';

    protected function casts(): array
    {
        return [
            'monthly_cost' => 'decimal:2',
            'activation_date' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}
