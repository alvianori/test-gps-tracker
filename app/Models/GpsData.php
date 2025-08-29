<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpsData extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'device_id',
        'latitude',
        'longitude',
        'speed',
        'course',
        'direction',
        'devices_timestamp'
    ];
    
    protected $casts = [
        'devices_timestamp' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'speed' => 'decimal:2',
        'course' => 'decimal:2'
    ];
}