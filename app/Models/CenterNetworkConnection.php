<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'center_id', 'connection_type', 'provider', 'speed_download', 'speed_upload',
    'ip_address', 'contract_number', 'status', 'notes', 'created_by', 'updated_by',
])]
class CenterNetworkConnection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'center_network_connections';

    protected function casts(): array
    {
        return [
            'speed_download' => 'decimal:2',
            'speed_upload' => 'decimal:2',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function monitoringLogs(): HasMany
    {
        return $this->hasMany(NetworkMonitoringLog::class, 'connection_id');
    }
}
