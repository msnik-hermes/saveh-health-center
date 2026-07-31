<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemAlert extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'system_alerts';

    protected $fillable = [
        'alert_type', 'severity', 'target_type', 'target_id',
        'title', 'message', 'is_read', 'resolved_by',
        'resolved_at', 'resolution_notes',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'resolved_at' => 'datetime',
        ];
    }
}
