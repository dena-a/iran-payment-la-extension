<?php

use Dena\IranPayment\LaravelAdmin\Http\Controllers\IranPaymentTransactionController;

Route::resource(
    config('admin.extensions.iranpayment.prefix', 'iranpayment'),
    IranPaymentTransactionController::class,
    [
        'as' => 'iranpayment',
    ]
);
