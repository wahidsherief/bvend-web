<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // // Clear existing data to avoid duplicates when re-seeding
        // \DB::table('product_transaction')->delete();

        // // Generating sample data and inserting it into the table
        // $data = [
        //     ['transaction_id' => 1, 'product_id' => 1, 'sale_price' => 100],
        //     ['transaction_id' => 2, 'product_id' => 2, 'sale_price' => 150],
        //     ['transaction_id' => 3, 'product_id' => 3, 'sale_price' => 200],
        //     ['transaction_id' => 4, 'product_id' => 4, 'sale_price' => 250],
        //     ['transaction_id' => 5, 'product_id' => 5, 'sale_price' => 300],
        //     ['transaction_id' => 6, 'product_id' => 6, 'sale_price' => 350],
        //     ['transaction_id' => 7, 'product_id' => 7, 'sale_price' => 400],
        //     // Add more rows as needed
        // ];

        // DB::table('product_transaction')->insert($data);
    }
}
