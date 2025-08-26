<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffPosition extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    public function staffCompanies()
    {
        return $this->hasMany(StaffCompany::class);
    }
}
