<?php

use Illuminate\Http\Response;

if (!function_exists('getModel')) {
    function getModel($item)
    {
        $models = [
            'admin' => \App\Models\Admin::class,
            'staff' => \App\Models\Staff::class,
            'vendor' => \App\Models\Vendor::class,
            'customer' => \App\Models\Customer::class,

            'product' => \App\Models\Product::class,
            'product_category' => \App\Models\ProductCategory::class,
            'machine' => \App\Models\Machine::class,
            'machine_types' => \App\Models\MachineType::class
        ];

        return $models[$item];
    }
}

if (!function_exists('successResponse')) {
    function successResponse($message = null, $data = null)
    {
        $message = ucfirst(str_replace('_', ' ', $message . ' successfully.'));

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], Response::HTTP_OK);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($message, $errors = null, $status = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $message = ucfirst(str_replace('_', ' ', $message . ' failed.'));

        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
