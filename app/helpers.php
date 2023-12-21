<?php

use Illuminate\Http\Response;
use Carbon\Carbon;

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
    function successResponse($message, $data = [])
    {
        $message = ucfirst(str_replace('_', ' ', $message));

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
        $message = ucfirst(str_replace('_', ' ', $message));

        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}


if (!function_exists('filterEmptyValues')) {
    function filterEmptyValues($data)
    {
        return collect($data)->reject(function ($value) {
            return empty($value);
        })->toArray();
    }
}


if (!function_exists('readableDate')) {
    function readableDate($dateString)
    {
        $date = Carbon::createFromFormat('Y-m-d', $dateString);
        return $date->format('d F, Y, l');
    }
}
