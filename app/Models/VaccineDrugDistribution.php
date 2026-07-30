<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'vaccine_drug_id', 'center_id', 'distribution_date', 'quantity_sent',
    'quantity_received', 'temperature_at_distribution', 'distributor_name',
    'recipient_name', 'transport_method', 'cold_chain_maintained',
    'delivery_receipt', 'status', 'notes', 'created_by', 'updated_by',
])]
class VaccineDrugDistribution extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vaccine_drug_distributions';

    protected function casts(): array
    {
        return [
            'distribution_date' => 'date',
            'quantity_sent' => 'integer',
            'quantity_received' => 'integer',
            'temperature_at_distribution' => 'decimal:1',
            'cold_chain_maintained' => 'boolean',
            'delivery_receipt' => 'array',
        ];
    }

    public function vaccineDrug(): BelongsTo
    {
        return $this->belongsTo(VaccineDrug::class, 'vaccine_drug_id');
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
