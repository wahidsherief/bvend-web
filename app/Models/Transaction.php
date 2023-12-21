<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    // public function getUpdatedAtAttribute($value)
    // {
    //     return \Carbon\Carbon::parse($value)->format('d F, Y, l');
    // }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function vendor()
    {
        return $this->hasOne('App\Vendor', 'id', 'vendor_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
