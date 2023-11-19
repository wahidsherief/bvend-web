<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Services\AuthService;
use App\Services\BaseService;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SaveVendorRequest;
use App\Http\Requests\Admin\UpdateVendorRequest;

class VendorController extends Controller
{
    private $item = 'vendor';
    protected $service;
    protected $authService;

    public function __construct(AuthService $authService,  BaseService $service) {
        $this->service = $service;
        $this->authService = $authService;
        \Config::set('auth.defaults.guard', 'vendor-api');
    }

    public function login(LoginRequest $request) {
        return $this->authService->login($request);
    }

    public function register(AdminRequest $request) {
        return $this->authService->register($request, Admin::class);
    }

    public function logout() {
        return $this->authService->logout();
    }

    public function profile() {
        return $this->authService->user();
    }

    public function index()
    {
        return $this->service->all($this->item);
    }

    public function show($id)
    {
        return $this->service->get($this->item, $id);
    }
    
    public function store(SaveVendorRequest $request)
    {
        return $this->service->save($this->item, $request);
    }
    
    public function update(UpdateVendorRequest $request, $id)
    {
        return $this->service->update($this->item, $request, $id);
    }
    
    public function destroy($id)
    {
        return $this->service->delete($this->item, $id);
    }
}

