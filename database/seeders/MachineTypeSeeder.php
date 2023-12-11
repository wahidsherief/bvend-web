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
                'name' => 'Store',
            ],
            [
                'name' => 'Box',
            ],
            [
                'name' => 'Wash',
            ],
            [
                'name' => 'Dry',
            ],
            [
                'name' => 'Charge',
            ],
        ];

        foreach ($types as $type) {
            MachineType::create($type);
        }
    }
}
