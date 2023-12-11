<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Refill;

class RefillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $row = 1;
        $col = 1;
        $col_count = 0;
        for ($i = 1; $i <= 10 ; $i++) {
            if ($col_count == 6) {
                $row++;
                $col_count = 0;
                $col = 1;
            }
            $Refill = new Refill();
            $Refill->machine_id = 1;
            $Refill->row_no = $row;
            $Refill->column_no = $col;
            $Refill->product_id = 1;
            $Refill->capacity = 10;
            $Refill->quantity = 10;
            $Refill->price = 20;
            $Refill->save();
            $col_count++;
            $col++;
        }
    }
}
