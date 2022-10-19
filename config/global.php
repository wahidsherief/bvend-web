<?php

$product_image_path = public_path('/uploads/products/');
$vendor_image_path = public_path('/uploads/vendors/');
$qrcode_image_path = public_path('/uploads/machine_qr_codes/');

$api_url = config('app.env') === 'production' ? env('PRODUCTION_API_URL') : env('LOCAL_API_URL');
$api_url_bkash = $api_url . 'bkash/';

return [
    'api_url' => $api_url,
    'api_url_bkash' => $api_url_bkash,
    // 'bkash_url' => $bkash_url,

    'product_image_path' => $product_image_path,
    'vendor_image_path' => $vendor_image_path,
    'qrcode_image_path' => $qrcode_image_path,
];
