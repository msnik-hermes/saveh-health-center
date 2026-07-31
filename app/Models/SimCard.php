<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sim_cards';

    protected $fillable = [
        'phone_number', 'operator', 'card_type', 'iccid',
        'current_plan', 'monthly_cost', 'activation_date', 'expiry_date',
        'center_id', 'assigned_to', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'monthly_cost' => 'integer',
            'activation_date' => 'date',
            'expiry_date' => 'date',
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
