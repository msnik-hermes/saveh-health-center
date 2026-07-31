<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficialCorrespondence extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'official_correspondence';

    protected $fillable = [
        'tracking_number', 'type', 'sender_id', 'receiver_id',
        'center_id', 'subject', 'body', 'attachments', 'priority',
        'status', 'send_date', 'receive_date', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'attachments' => 'array',
            'send_date' => 'date',
            'receive_date' => 'date',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'receiver_id');
    }
}
