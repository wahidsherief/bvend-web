<?php

$product_image_path = storage_path('app/public/uploads/images/product');
$vendor_image_path = storage_path('app/public/uploads/images/vendor');
$qr_code_image_path = storage_path('app/public/uploads/images/machine_qr_code');
$bkash_qr_code_image_path = storage_path('app/public/uploads/images/bkash_qr_code');

$api_url = config('app.env') === 'production' ? env('PRODUCTION_API_URL') : (config('app.env') === 'demo' ? env('DEMO_API_URL') : env('LOCAL_API_URL'));


$app_url = config('app.env') === 'production' ? env('PRODUCTION_APP_URL') : (config('app.env') === 'demo' ? env('DEMO_APP_URL') : env('LOCAL_APP_URL'));


// $api_url_bkash = $api_url . 'bkash';


return [
    'api_url' => $api_url,
    'app_url' => $app_url,
    // 'api_url_bkash' => $api_url_bkash,
    'product_image_path' => $product_image_path,
    'vendor_image_path' => $vendor_image_path,
    'machine_qr_code_image_path' => $qr_code_image_path,
    'bkash_qr_code_image_path' => $bkash_qr_code_image_path,
];
