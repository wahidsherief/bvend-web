<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('jS F, Y, l', strtotime($value));
    }

    public function machineType()
    {
        return $this->belongsTo('App\Models\MachineType', 'machine_type_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id', 'id');
    }

    public function locks()
    {
        return $this->hasMany('App\Models\Lock', 'machine_id', 'id');
    }

    public function refills()
    {
        return $this->hasMany('App\Models\Refill', 'machine_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'machine_product', 'machine_id', 'product_id')
                ->withPivot('price');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'machine_id', 'id');
    }
}
