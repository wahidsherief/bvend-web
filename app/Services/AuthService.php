<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login($request)
    {
        if(!$token = auth()->attempt($request->validated())) {
            return successResponse('Login failed', 'Unauthorized', 401);
        }
        return $this->createNewToken($token, $request);
    }

    // public function register($request, $model)
    // {
    //     try {
    //         $user = $model::create(array_merge(
    //             $request->validated(),
    //             ['password' => bcrypt($request->password)]
    //         ));

    //         return response()->json([
    //             'message' => 'Registration Successfull',
    //             'user' => $user
    //         ], 200);

    //     } catch (ValidationException $e) {
    //         return response()->json([
    //             'message' => 'Registration failed',
    //             'errors' => $e->errors(),
    //         ], 422);
    //     }
    // }

    public function logout()
    {
        auth()->logout();

        if (!auth()->check()) {
            return successResponse('Logged out successfully');
        }
    }

    public function user()
    {
        $data = auth()->user();

        return successResponse('Auth user', $data);
    }

    private function createNewToken($token, $request)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => strtotime(date('Y-m-d H:i:s', strtotime('+60 min'))),
            'user' => auth()->user(),
            'role' => $request->role
        ];

        return successResponse('Logged in successfully', $data);
    }
}
