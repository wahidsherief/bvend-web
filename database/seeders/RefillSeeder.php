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
        $no_of_row = 1;
        $count = 0;
        for ($i=1; $i <= 30 ; $i++) {
            $count++;
            if ($count == 6) {
                $count = 0;
                $no_of_row++;
            }
            $Refill = new Refill();
            $Refill->machine_id = 1;
            $Refill->row_id = $no_of_row;
            $Refill->tray_id = $i;
            $Refill->product_id = null;
            $Refill->quantity = null;
            $Refill->sale_unit_price = null;
            $Refill->save();
        }
    }
}
