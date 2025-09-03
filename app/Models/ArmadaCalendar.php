<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArmadaCalendar extends Model
{
    protected $fillable = [
        'title',
        'start',
        'end',
        'color',
    ];
}
