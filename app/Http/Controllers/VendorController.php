<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Services\BaseService;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    private $path = 'vendor';

    public function __construct(BaseService $service, Vendor $vendor)
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
        return response()->json($this->vendor->all(), 200);
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

        if ($request->has('image')) {
            $data['image'] = $this->service->uploadImage($request->file('image'), $this->path);
        }

        $data['is_active'] = $request->is_active === true ? 1 : 0;

        $stored = $this->vendor->create($data);
        if ($stored) {
            return $this->index();
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
        $data = $request->all();

        if ($request->has('image') && strlen($request->file('image')) > 0) {
            $data['image'] = $this->service->uploadImage($request->file('image'), $this->path);
        }

        $data['is_active'] = $request->is_active == 'false' ? 0 : 1;

        $updated = $this->vendor->find($id)->update($data);
        if ($updated) {
            return $this->index();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroyed = $this->vendor->find($id)->delete();
        if ($destroyed) {
            return $this->index();
        }
    }
}