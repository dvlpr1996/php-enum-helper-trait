# Php Enum Helper Trait

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/dvlpr1996/php-enum-helper-trait?style=flat)](https://packagist.org/packages/dvlpr1996/php-enum-helper-trait)
[![Total Downloads](https://img.shields.io/packagist/dt/dvlpr1996/php-enum-helper-trait)](https://packagist.org/packages/dvlpr1996/php-enum-helper-trait)

This package provides a trait designed to simplify and enhance the functionality of enums in PHP applications. It offers utility methods and features that make working with enums more intuitive and efficient, ideal for developers looking to streamline their enum handling in PHP applications.

## Requirements

- PHP 8.1 or higher

## Install

You can install the package via composer:

```bash
composer require dvlpr1996/php-enum-helper-trait
```

## Usage

```php
use PhpEnumHelperTrait\EnumHelperTrait;

enum Foo: string {
	use EnumHelperTrait;

	// Your Additional Cases, Methods And Properties...
}
```
## Documentation

See the [documentation](https://github.com/dvlpr1996/php-enum-helper-trait/wiki) for detailed installation and usage instructions.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## issues

If you discover any issues, please using the issue tracker.

## Credits

- [Nima jahan bakhshian](https://github.com/dvlpr1996)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
