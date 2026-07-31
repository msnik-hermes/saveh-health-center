<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    use HasFactory;

    protected $table = 'user_login_logs';

    protected $fillable = [
        'user_id', 'ip_address', 'user_agent', 'device_type',
        'browser', 'os', 'location', 'login_type',
        'is_successful', 'failure_reason', 'login_at',
        'logout_at', 'session_duration_minutes',
    ];

    protected function casts(): array
    {
        return [
            'is_successful' => 'boolean',
            'login_at' => 'datetime',
            'logout_at' => 'datetime',
            'session_duration_minutes' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
