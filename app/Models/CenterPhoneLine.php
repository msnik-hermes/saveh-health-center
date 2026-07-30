<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'phone_number', 'line_type', 'provider', 'bill_id', 'account_number',
    'monthly_cost', 'department', 'status', 'start_date', 'end_date', 'notes',
    'created_by', 'updated_by',
])]
class CenterPhoneLine extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'center_phone_lines';

    protected function casts(): array
    {
        return [
            'monthly_cost' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
