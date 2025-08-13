<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryArmada extends Model
{
    protected $fillable = ['name_category_armada', 'description'];

    public function armadas()
    {
        return $this->hasMany(Armada::class, 'category_armada_id');
    }
}
