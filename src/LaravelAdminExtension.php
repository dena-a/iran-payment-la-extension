<?php

namespace Dena\IranPayment\LaravelAdmin;

use Encore\Admin\Extension;

use Encore\Admin\Auth\Database\Menu;

class LaravelAdminExtension extends Extension
{
    public $name = 'iranpayment';

    /**
     * {@inheritdoc}
     */
    public static function boot()
    {
        if (!parent::boot()) {
            return false;
        }

        static::registerRoutes();

        return true;
    }

    /**
     * Register routes for laravel-admin.
     *
     * @return void
     */
    protected static function registerRoutes()
    {
        parent::routes(function ($router) {
            /* @var \Illuminate\Routing\Router $router */
            $router->group([
                'prefix' => config('admin.extensions.iranpayment.uri', 'iranpayment'),
                'as' => config('admin.route.as') ? config('admin.route.as').'.iranpayment.' : 'iranpayment.',
            ], function ($router) {
                $router->get('/', 'Dena\IranPayment\LaravelAdmin\Http\Controllers\IranPaymentTransactionController@index')->name('index');
                $router->get('/{iranpayment}', 'Dena\IranPayment\LaravelAdmin\Http\Controllers\IranPaymentTransactionController@show')->name('show');
                $router->get('/{iranpayment}/edit', 'Dena\IranPayment\LaravelAdmin\Http\Controllers\IranPaymentTransactionController@edit')->name('edit');
                $router->put('/{iranpayment}', 'Dena\IranPayment\LaravelAdmin\Http\Controllers\IranPaymentTransactionController@update')->name('update');
            });
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        $lastOrder = Menu::max('order') ?: 0;

        Menu::create([
            'parent_id' => 0,
            'order'     => $lastOrder++,
            'title'     => __('iranpayment::laravel-admin.bank_transactions'),
            'icon'      => 'fa-bank',
            'uri'       => config('admin.extensions.iranpayment.uri'),
        ]);
    }
}
