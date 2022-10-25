<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
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
                'name' => 'Chips',
                'product_categories_id' => 1,
                'image' => 'avatar.jpg',
                'unit' => '',
            ],
            [
                'id' => 2,
                'name' => 'Book',
                'product_categories_id' => 2,
                'image' => 'avatar.jpg',
                'unit' => '',
            ],
            [
                'id' => 3,
                'name' => 'Mobile',
                'product_categories_id' => 3,
                'image' => 'avatar.jpg',
                'unit' => '',
            ],
        ];

        Product::insert($data);
    }
}
