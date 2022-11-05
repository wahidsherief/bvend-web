<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MachineResource;
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
        $machines = Machine::where('vendors_id', $id)->get();
        return MachineResource::collection($machines)->response(200);
    }

    public function getRefills($id)
    {
        $refills = Refill::where('machine_id', $id)->get();
        return MachineResource::collection($refills)->response(200);
    }
}
