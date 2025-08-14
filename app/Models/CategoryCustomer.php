<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryCustomer extends Model
{
    protected $fillable = ['name_category_customer', 'description'];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'category_customer_id');
    }
}
