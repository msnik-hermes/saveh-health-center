<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'action', 'table_name', 'record_id', 'old_values', 'new_values',
    'ip_address', 'user_agent', 'session_id',
])]
class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'record_id' => 'integer',
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Activity logs are immutable — no update/delete methods
    public function update(array $attributes = [], array $options = []): bool
    {
        return false;
    }

    public function delete(): bool
    {
        return false;
    }
}
