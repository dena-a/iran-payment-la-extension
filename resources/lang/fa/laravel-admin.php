<?php

return [
    'bank_transactions' => 'تراکنش‌های بانکی',
    'bank_transactions_list' => 'لیست تراکنش‌های بانکی',
    'bank_transaction_details' => 'جزئیات تراکنش بانکی',
    'bank_transaction_edit' => 'ویرایش تراکنش بانکی',

    'columns' => [
        'id' => 'شناسه',
        'code' => 'کد تراکنش',
        'payable_id' => 'شناسه مورد پرداخت شده',
        'payable_type' => 'نوع مورد پرداخت شده',
        'gateway' => 'درگاه پرداخت',
        'amount' => 'مبلغ',
        'currency' => 'واحد',
        'status' => 'وضعیت',
        'tracking_code' => 'کد پیگیری',
        'reference_number' => 'شماره مرجع',
        'card_number' => 'شماره کارت',
        'full_name' => 'نام و نام خانوادگی',
        'email' => 'پست الکترونیک',
        'mobile' => 'تلفن همراه',
        'description' => 'توضیحات',
        'errors' => 'خطاها',
        'extra' => 'سایر داده‌ها',
        'gateway_data' => 'سایر داده‌های درگاه پرداخت',
        'paid_at' => 'زمان پرداخت',
        'created_at' => 'زمان ایجاد',
        'updated_at' => 'زمان آخرین بروزرسانی',
    ],

    'statuses' => [
        'init' => 'ایجاد شده',
        'succeed' => 'موفق',
        'failed' => 'ناموفق',
        'pending' => 'درجریان',
        'verify_pending' => 'در انتظار تایید',
        'paid_back' => 'برگشت وجه',
        'canceled' => 'انصراف',
    ],
];
