<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['user_id', 'mac', 'code', 'last_ip'];

    public function dspPreset()
    {
        return $this->belongsToMany(DspPreset::class, 'device_dsp_links', 'device_id', 'dsp_preset_id');
    }
}
