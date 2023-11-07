<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Staff;
use Validator;

class StaffController extends Controller
{
    public function __construct() {
        \Config::set('auth.defaults.guard', 'staff-api');
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response->json($validator->errors(), 422);
        }
        if(!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error', 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|string|max:100|unique:staffs',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $staff = Staff::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
    
        return response()->json([
            'message' => 'Staff registered',
            'staff' => $staff
        ], 200);
    }

    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Staff successfully signed out']);
    }

    public function userProfile() {
        return response()->json(auth->user());
    }

    protected function createNewToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => strtotime(date('Y-m-d H:i:s', strtotime('+60 min'))),
            'user' => auth()->user()
        ]);
    }
}
