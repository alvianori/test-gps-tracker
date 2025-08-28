<?php

namespace App\Models;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'customer_category_id',
        'company_id'
    ];
    
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = '+62' . $value;
    }
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }

    public function category()
    {
        return $this->belongsTo(CustomerCategory::class, 'customer_category_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
