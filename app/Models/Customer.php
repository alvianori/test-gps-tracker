<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['category_customer_id', 'name_customer', 'email', 'number', 'address', 'npwp'];

    public function categoryCustomer()
    {
        return $this->belongsTo(CategoryCustomer::class, 'category_customer_id');
    }

    public function armadas()
    {
        return $this->hasMany(Armada::class, 'customer_id');
    }
}
