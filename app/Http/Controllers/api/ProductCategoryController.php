<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use App\Services\BaseService;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected $service;
    protected $product_category;

    public function __construct(BaseService $service, ProductCategory $product_category)
    {
        // $this->middleware('auth:admin');
        $this->service = $service;
        $this->product_category = $product_category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCategoryResource::collection($this->product_category->all())->response(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stored = $this->product_category->create($request->all());
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
        $updated = tap($this->product_category->find($id))->update($request->all());
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
        $destroyed = $this->product_category->find($id)->delete();
        if ($destroyed) {
            return $this->index();
        }
    }
}
