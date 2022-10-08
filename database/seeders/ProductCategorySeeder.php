<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'category' => 'Chips',
                'brand' => 'Bombay Sweets',
            ],
            [
                'id' => 2,
                'category' => 'Shoe',
                'brand' => 'Nike',
            ],
            [
                'id' => 3,
                'category' => 'Computer',
                'brand' => 'HP',
            ],
        ];

        ProductCategory::insert($data);
    }
}
