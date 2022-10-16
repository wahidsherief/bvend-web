<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use App\Services\BaseServices;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    protected $service;
    protected $vendor;

    public function __construct(BaseServices $service, Vendor $vendor)
    {
        // $this->middleware('auth:admin');
        $this->service = $service;
        $this->vendor = $vendor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return VendorResource::collection($this->vendor->with('category')->get())->response(200);
        return VendorResource::collection($this->vendor->all())->response(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stored = $this->vendor->create($request->all());
        return response(new VendorResource($stored), 201);
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
        $updated = tap($this->vendor->find($id))->update($request->all());
        return response(new VendorResource($updated), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->vendor->find($id)->delete();
        return response('success', 204);
    }
}
