<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MachineResource;
use App\Models\Machine;
use App\Services\BaseService;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;

class MachineController extends Controller
{
    protected $service;
    protected $machine;

    public function __construct(BaseService $service, Machine $machine)
    {
        // $this->middleware('auth:admin');
        $this->service = $service;
        $this->machine = $machine;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MachineResource::collection($this->machine->with('vendor')->get())->response(200);
        // return MachineResource::collection($this->machine->with('vendor'))->response(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $machine_code = mt_rand(100000, 999999);

        $qr_code =  $this->generateQRCode($machine_code, $request->machine_type);

        if (strlen($qr_code) > 0) {
            $data['machine_code'] = $machine_code;
            $data['qr_code'] = $qr_code;
            $data['is_active'] = $request->is_active === true ? 1 : 0;
            return $this->machine->create($data) && $this->index();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updated = tap($this->machine->find($id))->update($request->all());
        return response(new MachineResource($updated), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->machine->find($id)->delete();
        return response('success', 204);
    }

    public function assign(Request $request)
    {
        DB::table('vendor_machines')->insert($request->all());
    }

    private function generateQRCode($machine_code, $type)
    {
        $path = config('global.qrcode_image_path');
        try {
            $code = 'BVENDMACHINECODE-' . $machine_code;
            $qr_code = $type . '-' . $machine_code . '.png';
            $url = $path . $qr_code;
            QrCode::format('png')
                ->margin(0)
                ->size(500)
                ->generate($code, $url);

            return $qr_code;
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    private function getMachines()
    {
        return DB::table('machines')
        ->select('machines.*', 'vendors.id', 'vendors.name')
        ->join('vendor_machines', 'machines_id', '=', 'machines.id')
        ->join('vendors', 'vendors_id', '=', 'vendors.id')
        ->get();
    }
}
