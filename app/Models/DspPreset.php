<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DspPreset extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'eq_data'];
    protected $casts = [
        'eq_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_dsp_links', 'dsp_preset_id', 'device_id');
    }
}