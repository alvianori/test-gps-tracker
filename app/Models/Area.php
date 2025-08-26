<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'province',
        'city',
        'subdistrict',
        'postal_code',
        'street_name',
        'house_number'

    ];

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}
