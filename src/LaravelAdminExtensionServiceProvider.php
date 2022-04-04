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
        if (!LaravelAdminExtension::boot()) {
            return;
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'iranpayment');
    }
}
