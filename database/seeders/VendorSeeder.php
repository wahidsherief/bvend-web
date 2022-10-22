<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $items = [
            'kalam brothers ltd',
            'salam brothers ltd',
            'momin brothers ltd',
            'abul brothers ltd',
            'kader brothers ltd',
        ];

        foreach ($items as $key=>$item) {
            $vendor = new Vendor();
            $vendor->name = "Vendor ". $key;
            $vendor->contact = "01825645569";
            $vendor->image = "vendor image";
            $vendor->email = "vendor_".$key."@bvend.com";
            $vendor->password = "123456";
            $vendor->business_name = $item;
            $vendor->additional_contact = '01564589785';
            $vendor->trade_licence_no = $key.'-1234';
            $vendor->nid = $key.'-4321';
            $vendor->is_active = 0;
            $vendor->save();
        }
    }
}
