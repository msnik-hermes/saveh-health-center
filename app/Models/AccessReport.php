<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessReport extends Model
{
    use HasFactory;

    protected $table = 'access_reports';

    protected $fillable = [
        'user_id',
        'report_type',
        'filters',
        'results',
    ];

    protected $casts = [
        'filters' => 'array',
        'results' => 'array',
    ];
}