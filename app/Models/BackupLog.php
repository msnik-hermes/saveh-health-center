<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackupLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'backup_logs';

    protected $fillable = [
        'backup_type', 'status', 'file_path', 'file_size_bytes',
        'duration_seconds', 'error_message', 'triggered_by',
        'started_at', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'file_size_bytes' => 'integer',
            'duration_seconds' => 'integer',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }
}
