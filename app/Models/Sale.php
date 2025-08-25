<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'sales_name',
        'role',
        'telepon',
        'status',];
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
