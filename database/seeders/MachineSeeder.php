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
        for ($i=0; $i < 4 ; $i++) {
            $machine = new Machine();
            $machine->machine_code = 'b' . rand(500, 900);
            $machine->machine_types_id = rand(1, 5);
            $machine->no_of_rows = 10;
            $machine->no_of_columns = 6;
            $machine->locks_per_column = 10;
            $machine->qr_code = 'avatar.jpg';
            $machine->vendors_id = rand(1, 3);
            $machine->assign_date = '';
            $machine->location = '';
            $machine->is_active = 0;
            $machine->save();
        }
    }
}
