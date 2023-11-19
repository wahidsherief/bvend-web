<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $primaryKey = 'id';
    // protected $fillable = ['name', 'brand'];
    protected $guarded = [];

    public function machines() {
        return $this->belongsToMany(Machine::class, 'machine_product_category', 'product_category_id', 'machine_id');
    }
}
