<?php

$product_image_path = storage_path('/uploads/images/product/');
$vendor_image_path = storage_path('/uploads/images/vendor/');
$qrcode_image_path = storage_path('/uploads/images/machine_qr_code/');

$api_url = config('app.env') === 'production' ? env('PRODUCTION_API_URL') : env('LOCAL_API_URL');
$api_url_bkash = $api_url . 'bkash/';

return [
    'api_url' => $api_url,
    'api_url_bkash' => $api_url_bkash,
    'product_image_path' => $product_image_path,
    'vendor_image_path' => $vendor_image_path,
    'qrcode_image_path' => $qrcode_image_path,
];

