<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'product_categories_id', 'image', 'unit'];

    public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'product_categories_id', 'id');
    }
}
