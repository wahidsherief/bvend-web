<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function machineType()
    {
        return $this->belongsTo('App\Models\MachineType', 'machine_types_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendors_id', 'id');
    }
    
    public function locks()
    {
        return $this->hasMany('App\Models\Lock', 'machines_id', 'id');
    }

    public function refills()
    {
        return $this->hasMany('App\Models\Refill', 'machines_id', 'id');
    }

    public function productCategories() {
        return $this->belongsToMany(ProductCategory::class, 'machine_product_category', 'machine_id', 'product_category_id');
    }
}
