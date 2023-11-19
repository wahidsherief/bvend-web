<?php

namespace Database\Seeders;

use App\Models\MachineType;
use Illuminate\Database\Seeder;

class MachineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'type' => 'store',
            ],
            [
                'type' => 'box',
            ],
            [
                'type' => 'wash',
            ],
            [
                'type' => 'dry',
            ],
            [
                'type' => 'charge',
            ],
        ];

        foreach ($types as $type) {
            MachineType::create($type);
        }
    }
}
