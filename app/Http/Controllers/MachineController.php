<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Services\MachineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\SaveMachineRequest;
use App\Http\Requests\Admin\UpdateMachineRequest;

class MachineController extends Controller
{
    protected $service;

    public function __construct(MachineService $service)
    {
        // $this->middleware('auth:admin');
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->all();
    }

    public function show($id)
    {
        return $this->service->get($id);
    }
    
    public function store(SaveMachineRequest $request)
    {
        return $this->service->save($request);
    }
    
    public function update(UpdateMachineRequest $request, $id)
    {
        return $this->service->update($request, $id);
    }
    
    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
