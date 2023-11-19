<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\BaseService;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SaveProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;

class ProductController extends Controller
{
    private $service;
    private $model;
    private $modelName = 'product';
    private $relations = ['category'];

    public function __construct(BaseService $service, Product $product)
    {
        $this->model = $product;
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

    public function store(SaveProductRequest $request)
    {
        return $this->service->save($request);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
