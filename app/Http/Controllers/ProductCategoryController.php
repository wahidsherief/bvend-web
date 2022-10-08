<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Http\Requests\ProductCategory\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategory\ProductCategoryUpdateRequest;
use App\Services\BaseServices;

class ProductCategoryController extends Controller
{
    protected $product_category;

    public function __construct(ProductCategory $product_category, BaseServices $service)
    {
        // $this->middleware('auth:admin');
        $this->product_category = $product_category;
        $this->service = $service;
    }

    public function index()
    {
        return $this->product_category->all();
    }

    public function get($item = 15)
    {
        return $this->product_category->latest()->paginate($item);
    }

    public function find($id)
    {
        return $this->product_category->findOrFail($id);
    }

    public function store(ProductCategoryStoreRequest $request)
    {
        // dd($request->all());
        return $this->product_category->newInstance()->fill($request->all())->save() ? true : false;
    }

    public function update(ProductCategoryUpdateRequest $request, $id)
    {
        return $this->product_category->find($id)->update($request->all()) ? true : false;
    }

    public function delete($id)
    {
        return $this->product_category->find($id)->delete() ? true : false;
    }
}
