<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'companies_id',
        'users_id',
        'name',
        'description',
        'create_by',
        'update_by',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
