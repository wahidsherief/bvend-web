<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Services\BaseServices;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product, BaseServices $service)
    {
        // $this->middleware('auth:admin');
        $this->product = $product;
        $this->service = $service;
    }

    public function index()
    {
        // return  json_encode($this->product->with('category')->get());
        return
        $this->product->with('category')->get()->toArray();
        // return $this->product->all()->toJson();
    }

    public function get($item = 15)
    {
        return $this->product->latest()->paginate($item);
    }

    public function find($id)
    {
        return $this->product->findOrFail($id);
    }

    public function store(ProductStoreRequest $request)
    {
        return
            $this->product->newInstance()->fill($request->all())->save()
            ? $this->product->all()
            : false;
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        return
            $this->product->find($id)->update($request->all())
            ? $this->product->all()
            : false;
    }

    public function delete($id)
    {
        return
            $this->product->find($id)->delete()
            ? $this->product->all()
            : false;
    }
}
