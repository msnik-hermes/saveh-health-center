<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecurityPolicy extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'security_policies';

    protected $fillable = [
        'name', 'slug', 'policy_type', 'rules', 'description', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'rules' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
