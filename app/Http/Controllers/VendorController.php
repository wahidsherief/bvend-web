<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Services\AuthService;
use App\Services\BaseService;
use Illuminate\Http\Request;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Admin\SaveVendorRequest;
use App\Http\Requests\Admin\UpdateVendorRequest;

class VendorController extends Controller
{
    private $item = 'vendor';
    protected $service;
    protected $authService;
    private $model;
    private $modelName = 'vendor';
    private $relations = [];

    public function __construct(AuthService $authService, BaseService $service, Vendor $vendor)
    {
        $this->model = $vendor;
        $this->service = $service->initialize($this->model, $this->modelName, $this->relations);
        $this->authService = $authService;
        \Config::set('auth.defaults.guard', 'vendor-api');
    }


    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }


    public function logout()
    {
        return $this->authService->logout();
    }

    public function profile()
    {
        return $this->authService->user();
    }

    public function update(UpdateVendorRequest $request, $id)
    {
        return $this->service->update($request, $id);
    }

}
