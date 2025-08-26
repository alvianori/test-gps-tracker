<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    protected $fillable = ['name'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
