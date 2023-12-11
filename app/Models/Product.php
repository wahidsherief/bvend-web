<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProductCategory;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function machines()
    {
        return $this->belongsToMany(Machine::class, 'machine_product')->withPivot('price');
    }
}
