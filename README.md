# Complete Laravel 11 Menu Builder - Still Developing

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yamanhacioglu/menu-builder.svg?style=flat-square)](https://packagist.org/packages/yamanhacioglu/menu-builder)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/yamanhacioglu/menu-builder/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/yamanhacioglu/menu-builder/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/:vendor_slug/menu-builder/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/yamanhacioglu/menu-builder/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/yamanhacioglu/menu-builder.svg?style=flat-square)](https://packagist.org/packages/yamanhacioglu/menu-builder)
<!--delete-->

Laravel Menu Builder with VueJs and jQuery. Build your multi level menu within 5 minutes.


## Installation

You can install the package via composer:

```bash
composer require yamanhacioglu/menu-builder
```

You can install the menu requirements via:

```bash
php artisan menu:install
```
The package self-publishes at https://domain.tld/admin/menus by default. To edit this address, you need to define prefix and base_url variables in the config file.

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag=":package_slug-views"
```

## Usage

```php
$variable = new VendorName\Skeleton();
echo $variable->echoPhrase('Hello, VendorName!');
```

## Testing

```bash
composer test
```

## Notes

This package is still under development. 


## Credits

- [Yaman HACIOĞLU](https://github.com/yamanhacioglu)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
