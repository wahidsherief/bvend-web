<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i=1;$i<=50;$i++) {
            Transaction::insert([
                'id' => $i,
                // 'machine_code' => 'ML0080213160312',
                'machine_id' => rand(1, 3),
                'merchant_number' => '01812555111',
                'customer_number' => '01712555111',
                'refill_id' => rand(1, 100),
                'vendor_id' => 1,
                'invoice_no' => $faker->randomDigit,
                'bkash_trx_id' => rand(1, 5000),
                'total_amount' => $faker->randomFloat,
                'discount' => $faker->randomFloat,
                'payment_method_id' => rand(1, 3),
                'status' => "Completed",
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' =>\Carbon\Carbon::now()
             ]);
        }
    }
}
