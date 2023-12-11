<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;

class StoreController extends Controller
{
    public function getStore($id)
    {
        $machine = Machine::where('id', $id)->first();

        $store = [
            'machine' => $machine,
            'machineType' => $machine->machineType,
            'products' => $machine->products()->join('refills', 'products.id', '=', 'refills.product_id')
                ->select('products.*', 'refills.price', 'refills.quantity')
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'image' => $product->image,
                        'price' => $product->price,
                        'quantity' => $product->quantity,
                    ];
                })
        ];

        // Return or use $resultArray as needed

        return $store
            ? successResponse('Store fetched successfully.', $store)
            : errorResponse('Store fetch failed.');
    }
}
