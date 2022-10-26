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
        for ($i=0; $i < 10 ; $i++) {
            $machine = new Machine();
            $machine->machine_code = 'bvend-' . rand(500, 900);
            $machine->machine_type = 'store';
            $machine->no_of_rows = 10;
            $machine->no_of_trays = 6;
            $machine->locks_per_tray = 10;
            $machine->qr_code = 'avatar.jpg';
            $machine->is_active = 0;
            $machine->save();
        }
    }
}
