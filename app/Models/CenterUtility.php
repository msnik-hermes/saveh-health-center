<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'utility_type', 'company', 'meter_number', 'bill_id', 'account_number',
    'meter_type', 'capacity', 'last_reading', 'avg_consumption', 'peak_consumption',
    'offpeak_consumption', 'monthly_cost', 'payment_status', 'last_reading_date',
    'last_payment_date', 'last_payment_tracking', 'contract_number', 'contract_start',
    'contract_end', 'internet_type', 'internet_speed', 'internet_ip', 'internet_modem',
    'internet_firewall', 'internet_vpn', 'has_emergency_power', 'bank_account_id',
    'status', 'notes', 'created_by', 'updated_by',
])]
class CenterUtility extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'center_utilities';

    protected function casts(): array
    {
        return [
            'last_reading' => 'decimal:2',
            'avg_consumption' => 'decimal:2',
            'peak_consumption' => 'decimal:2',
            'offpeak_consumption' => 'decimal:2',
            'monthly_cost' => 'decimal:2',
            'internet_vpn' => 'boolean',
            'has_emergency_power' => 'boolean',
            'last_reading_date' => 'date',
            'last_payment_date' => 'date',
            'contract_start' => 'date',
            'contract_end' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(CenterBankAccount::class, 'bank_account_id');
    }

    public function financialTransactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class, 'utility_id');
    }
}
