<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    protected $fillable = [
        'category_armada_id','customer_id', 'name_car', 'plate_number', 'color', 'year', 'frame_number','machine_number', 'status', 'keterangan'
    ];

    public function categoryArmada()
    {
        return $this->belongsTo(CategoryArmada::class, 'category_armada_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
