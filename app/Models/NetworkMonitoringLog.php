<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'connection_id', 'check_time', 'download_speed', 'upload_speed', 'latency',
    'packet_loss', 'uptime_pct', 'status', 'notes',
])]
class NetworkMonitoringLog extends Model
{
    use HasFactory;

    protected $table = 'network_monitoring_logs';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'check_time' => 'datetime',
            'download_speed' => 'decimal:2',
            'upload_speed' => 'decimal:2',
            'latency' => 'decimal:2',
            'packet_loss' => 'decimal:2',
            'uptime_pct' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function connection(): BelongsTo
    {
        return $this->belongsTo(CenterNetworkConnection::class, 'connection_id');
    }
}
