<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\BaseService;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SaveMachineTypeRequest;
use App\Models\MachineType;

class MachineTypeController extends Controller
{
    private $service;
    private $model;
    private $modelName = 'machine_type';
    private $relations = [];

    public function __construct(BaseService $service, MachineType $machineType)
    {
        $this->model = $machineType;
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

    public function store(SaveMachineTypeRequest $request)
    {
        $request->name = ucfirst($request->name);
        return $this->service->save($request);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
