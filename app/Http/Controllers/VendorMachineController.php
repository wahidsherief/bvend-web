<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\Refill;
use App\Models\Vendor;

class VendorMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $machines = Machine::where('vendors_id', $id)->withSum('refills', 'price')->withSum('refills', 'quantity')->get();
        return response()->json($machines, 200);
        
    }

    public function getRefills($id)
    {
        $refills = Refill::where('machines_id', $id)->with('product')->get();
        return response()->json($refills, 200);
    }

    public function storeRefill(Request $request)
    {
        $data['products_id'] = $request->products_id;
        $data['quantity'] = $request->quantity;
        $data['price'] = $request->price;
        $refills = Refill::where([
            'machines_id' => $request->machines_id,
            'row' => $request->row,
            'tray' => $request->tray])->update($data);

        if ($refills) {
            return $this->getRefills($request->machines_id);
        }
    }
}
