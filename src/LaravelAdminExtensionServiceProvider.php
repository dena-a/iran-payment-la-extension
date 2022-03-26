<?php

namespace Dena\IranPayment\LaravelAdmin;

use Illuminate\Support\ServiceProvider;

class LaravelAdminExtensionServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(LaravelAdminExtension $extension)
    {
        if (!LaravelAdmin::boot()) {
            return;
        }

        if ($this->app->config('admin.extensions.iranpayment.enable', false)) {
            $this->app->booted(function () {
                LaravelAdminExtension::routes(__DIR__.'/../routes/web.php');
            });
        }
    }
}
