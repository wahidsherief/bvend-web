<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Staff;

class AllUserSeeder extends Seeder
{
    public function run()
    {
        // Create regular users
        User::factory()->count(6)->create();

        // Create admins
        Admin::factory()->count(1)->create();

        // Create vendors
        Vendor::factory()->count(3)->create();

        // Create staff
        Staff::factory()->count(6)->create();
    }
}
