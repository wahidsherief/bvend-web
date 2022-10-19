<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MachineResource;
use App\Models\Machine;
use App\Services\BaseService;
use Illuminate\Http\Request;

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
        return MachineResource::collection($this->machine->all())->response(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stored = $this->machine->create($request->all());
        return response(new MachineResource($stored), 201);
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
}
