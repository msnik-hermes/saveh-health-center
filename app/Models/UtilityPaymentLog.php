<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UtilityPaymentLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'utility_payment_logs';

    protected $fillable = [
        'utility_id', 'bank_account_id', 'amount', 'tracking_number',
        'payment_method', 'auto_paid', 'status', 'response_data', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'auto_paid' => 'boolean',
        ];
    }

    public function utility(): BelongsTo
    {
        return $this->belongsTo(CenterUtility::class, 'utility_id');
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(CenterBankAccount::class, 'bank_account_id');
    }
}
