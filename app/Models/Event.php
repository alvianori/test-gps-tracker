<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'venue',
        'starts_at',
        'ends_at',
    ];

    // kalau starts_at & ends_at dipakai untuk tanggal
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
}
