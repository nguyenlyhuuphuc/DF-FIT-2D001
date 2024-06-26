<?php 
    return [
        'product_category' => [
            'item_per_page' => 6
        ],
        'my_item_per_page' => env('ITEM_PER_PAGE', 7),
        'vnpay' => [
            'TmnCode' => env('VNPAY_TMN_CODE', 'PUEN5D41'),
            'HashSecret' => env('VNPAY_HASH_SECRET', 'HOTFMHEKKTGITZXOWUHWZRDRHVSUEXXG'),
            'Url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
            'Returnurl' => env('VNPAY_RETURN_URL', 'http://localhost/vnpay_php/vnpay_return.php'),
            'vnp_apiUrl' => env('VNPAY_VNP_API_URL', 'http://sandbox.vnpayment.vn/merchant_webapi/merchant.html'),
            'apiUrl' => env('VNPAY_API_URL', 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction')
        ]
    ];
?>