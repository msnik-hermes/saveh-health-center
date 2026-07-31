<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitAccessRestriction extends Model
{
    use HasFactory;

    protected $table = 'unit_access_restrictions';

    protected $fillable = [
        'unit_id',
        'role_id',
        'user_id',
        'restriction_type',
        'resource_type',
        'conditions',
    ];

    protected $casts = [
        'conditions' => 'array',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'unit_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}