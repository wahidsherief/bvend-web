<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\AuthService;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Registration\AdminRequest;

class AdminController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
        \Config::set('auth.defaults.guard', 'admin-api');
    }

    public function login(LoginRequest $request) {
        return $this->authService->login($request);
    }

    public function register(AdminRequest $request) {
        return $this->authService->register($request, Admin::class);
    }

    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function profile() {
        return $this->authService->user();
    }
}
