<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\BaseService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $path = 'product';

    public function __construct(BaseService $service, Product $product)
    {
        // $this->middleware('auth:admin');
        $this->service = $service;
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection($this->product->with('category')->get())->response(200);
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

        $stored = $this->product->create($data);
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
        // $updated = tap($this->product->find($id))->update($request->all());
        $updated = $this->product->find($id)->update($request->all());
        if ($updated) {
            return $this->index();
        }
        // return response(new ProductResource($updated), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroyed = $this->product->find($id)->delete();
        if ($destroyed) {
            return $this->index();
        }
    }
}
