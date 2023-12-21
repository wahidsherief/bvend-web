<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Machine;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        for ($i = 0; $i < 4 ; $i++) {
            $machine = new Machine();
            $machine->machine_code = 'b' . rand(500, 900);
            $machine->machine_type_id = rand(1, 5);
            $machine->no_of_rows = 4;
            $machine->no_of_columns = 4;
            $machine->capacity = 10;
            $machine->qr_code = '';
            $machine->vendor_id = rand(1, 3);
            $machine->bkash_qr_code = '';
            $machine->location = '';
            $machine->is_active = 0;
            $machine->save();
        }
    }
}
