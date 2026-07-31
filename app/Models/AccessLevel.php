<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessLevel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'access_levels';

    protected $fillable = [
        'name',
        'level',
        'description',
    ];

    protected $casts = [
        'level' => 'integer',
    ];
}