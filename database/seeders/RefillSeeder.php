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
        for ($i=1; $i <=30 ; $i++) {
            if ($col_count == 6) {
                $row++;
                $col_count = 0;
                $col = 1;
            }
            $Refill = new Refill();
            $Refill->machines_id = 1;
            $Refill->row = $row;
            $Refill->tray = $col;
            $Refill->products_id = null;
            $Refill->quantity = null;
            $Refill->price = null;
            $Refill->save();
            $col_count++;
            $col++;
        }
    }
}
