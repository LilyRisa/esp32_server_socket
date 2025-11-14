<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceEq extends Model
{
    use HasFactory;
    
    protected $table = 'device_eqs';

    protected $fillable = [
        'device_code',
        'clarity',
        'ambience',
        'surround',
        'dynamic_boost',
        'bass_boost',
        'eq',
    ];

    // Cast eq JSON -> array tự động
    protected $casts = [
        'eq' => 'array',
        'clarity' => 'integer',
        'ambience' => 'integer',
        'surround' => 'integer',
        'dynamic_boost' => 'integer',
        'bass_boost' => 'integer',
    ];
}
