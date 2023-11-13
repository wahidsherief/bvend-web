<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
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
        $categories = [
            [
                'name' => 'Chips',
            ],
            [
                'name' => 'Shoe',
            ],
            [
                'name' => 'Computer',
            ],
            [
                'name' => 'Clothing',
            ],
            [
                'name' => 'Phone',
            ],
            [
                'name' => 'Furniture',
            ],
            [
                'name' => 'Camera',
            ],
            [
                'name' => 'Book',
            ],
            [
                'name' => 'Watch',
            ],
            [
                'name' => 'Bicycle',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
