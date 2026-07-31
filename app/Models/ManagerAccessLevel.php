<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerAccessLevel extends Model
{
    use HasFactory;

    protected $table = 'manager_access_levels';

    protected $fillable = [
        'role_id',
        'access_level_id',
        'can_approve',
        'can_escalate',
        'can_override',
    ];

    protected $casts = [
        'can_approve' => 'boolean',
        'can_escalate' => 'boolean',
        'can_override' => 'boolean',
    ];
}