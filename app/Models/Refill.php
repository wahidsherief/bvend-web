<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refill extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // public function vendorMachine()
    // {
    //     return $this->hasOne('App\Models\VendorMachine', 'vendors_id', 'id');
    // }
}
