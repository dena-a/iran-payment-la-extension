# iran-payment-la-extension
IranPayment extension for laravel-admin

## Requirements

* PHP >= 7.4
* [IranPayment](https://www.github.com/dena-a/iran-payment) >= 2.0
* [LaravelAdmin](https://www.github.com/z-song/laravel-admin) >= 1.8
* [Laravel](https://www.laravel.com) (or [Lumen](https://lumen.laravel.com)) >= 5.7

## Installation
1. Add the package to your composer file via the `composer require` command:

   ```bash
   $ composer require dena-a/iran-payment-la-extension:^1.0
   ```

   Or add it to `composer.json` manually:

   ```json
   "require": {
       "dena-a/iran-payment-la-extension": "^1.0"
   }
   ```

## Configuration

Open `config/admin.php` and add the following configuration to the `extensions` section:

```php
'extensions' => [

    'iranpayment' => [
        // Set to `false` if you want to disable this extension
        'enable' => true,
    ]
    
]
```

## Contribute

Contributions are always welcome!

## Support

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/dena-a/iran-payment/issues),
or better yet, fork the library and submit a pull request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
