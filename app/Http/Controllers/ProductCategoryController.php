<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Services\BaseService;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SaveProductCategoryRequest;
use App\Http\Requests\Admin\UpdateProductCategoryRequest;

class ProductCategoryController extends Controller
{
    private $service;
    private $model;
    private $modelName = 'product_category';
    private $relations = [];

    public function __construct(BaseService $service, ProductCategory $productCategory)
    {
        $this->model = $productCategory;
        $this->service = $service->initialize($this->model, $this->modelName, $this->relations);
    }

    public function index()
    {
        return $this->service->all();
    }

    public function show($id)
    {
        return $this->service->get($id);
    }

    public function store(SaveProductCategoryRequest $request)
    {
        return $this->service->save($request);
    }

    public function update(UpdateProductCategoryRequest $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
