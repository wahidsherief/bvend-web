<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Vendor;
use App\Services\BaseService;
use App\Services\AuthService;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Registration\AdminRequest;
use App\Http\Requests\Admin\SaveVendorRequest;
use App\Http\Requests\Admin\UpdateVendorRequest;
use App\Http\Requests\Admin\SaveProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;

class AdminController extends Controller
{
    protected $service;
    protected $authService;

    public function __construct(AuthService $authService, BaseService $service)
    {
        $this->service = $service;
        $this->authService = $authService;
        \Config::set('auth.defaults.guard', 'admin-api');
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }

    public function register(AdminRequest $request)
    {
        return $this->authService->register($request, Admin::class);
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function profile()
    {
        return $this->authService->user();
    }

    public function assignMachine() {}
}
