<?php

return [
    'bank_transactions' => 'Bank Transactions',
    'bank_transactions_list' => 'Bank Transactions List',
    'bank_transaction_details' => 'Bank Transaction Details',
    'bank_transaction_edit' => 'Edit Bank Transaction',

    'columns' => [
        'id' => 'id',
        'code' => 'code',
        'payable_id' => 'payable_id',
        'payable_type' => 'payable_type',
        'gateway' => 'gateway',
        'amount' => 'amount',
        'currency' => 'currency',
        'status' => 'status',
        'tracking_code' => 'tracking_code',
        'reference_number' => 'reference_number',
        'card_number' => 'card_number',
        'full_name' => 'full_name',
        'email' => 'email',
        'mobile' => 'mobile',
        'description' => 'description',
        'errors' => 'errors',
        'extra' => 'extra',
        'gateway_data' => 'gateway_data',
        'paid_at' => 'paid_at',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
    ],

    'statuses' => [
        'init' => 'Initialized',
        'succeed' => 'Succeed',
        'failed' => 'Failed',
        'pending' => 'Pending',
        'verify_pending' => 'Verify Pending',
        'paid_back' => 'Paid Back',
        'canceled' => 'Canceled',
    ],
];
