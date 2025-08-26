<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetCategory extends Model
{
    protected $fillable = ['name', 'description'];

    public function fleets()
    {
        return $this->hasMany(Fleet::class);
    }
}
