<?php

namespace Dena\IranPayment\LaravelAdmin;

use Encore\Admin\Extension;

class LaravelAdminExtension extends Extension
{
    public $name = 'iranpayment';

    public $menu = [
        'title' => 'IranPayment',
        'path'  => 'iranpayment',
        'icon'  => 'fa-bank',
    ];
}
