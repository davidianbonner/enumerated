# Enumerated

[![Author](http://img.shields.io/badge/author-@dbonner1987-blue.svg?style=flat-square)](https://twitter.com/dbonner1987)
[![Build Status](https://img.shields.io/travis/davidianbonner/enumerated/master.svg?style=flat-square)](https://travis-ci.org/davidianbonner/enumerated)
[![Quality Score](https://img.shields.io/scrutinizer/g/davidianbonner/enumerated.svg?style=flat-square)](https://scrutinizer-ci.com/g/davidianbonner/enumerated)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/davidianbonner/enumerated.svg?style=flat-square)](https://packagist.org/packages/davidianbonner/enumerated)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/davidianbonner/enumerated.svg?style=flat-square)](https://scrutinizer-ci.com/g/davidianbonner/enumerated/code-structure)

An enumerated type (Enum) is a data type that consists of a set of predefined values. This can be useful for ensuring data consistency. The Enumerated package provides a simple base class for creating enumerated types allowing the devloper to define values statically.

## Install

Via Composer

``` bash
$ composer require davidianbonner/enumerated
```

## Usage

Most applications require some form of an enumerated type. PHP does not have native Enum support (yet: [https://wiki.php.net/rfc/enum](https://wiki.php.net/rfc/enum)). To get past this, we tend to pack groups of predefined values into config or settings files as arrays. This doesn't represent the data or it's type in a straightforward manner.

### Before

```php
<?php

return [
    'language' => [
        'php' => 'php',
        'javascript' => 'js',
        'css' => 'css',
        'go' => 'go',
    ],
];
```

Used like so:

```php
$codebase->language = config('language.php');

// or

foreach (config('language') as $language) {
    echo '<option value="'.$language.'">'.$language.'</option>';
}
```

### After

An enum would be a better fit for this set of values.

```php
<?php

use DavidIanBonner\Enumerated\Enum;

class Language extends Enum
{
    const PHP = 'php';
    const JAVASCRIPT = 'js';
    const GO = 'go';
    const CSS = 'css';
}
```

Used like so:

```php
$codebase->language = Language::PHP;

// or

$type = Language::PHP;
$codebase->language = Language::ofType($type)->value();

// or

foreach (Language::allValues() as $language) {
    echo '<option value="'.$language.'">'.$language.'</option>';
}
```

### Validate a value

A value can be validated against the predefined values:

```php
if (Language::isValid($value)) {
    // Is valid
}
```

### Laravel Collection instance

This package requires the Laravel Support package in order to return a collection of the available values:

```php
// Returns an instance of Illuminate\Support\Collection
Language::collect();
```

### Return keys

The `allValues` and `collect` method will accept a boolean argument to return the keys/constant names:

```php
$values = Language::allValues(true);

// Returns
[
    'PHP' => 'php',
    'JAVASCRIPT' => 'js',
    'CSS' => 'css',
    'GO' => 'go',
]

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ phpunit test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email davidianbonner@gmail.com instead of using the issue tracker.

## Credits

- [David Bonner](http://davidianbonner.com)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/davidianbonner/enumerated.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/davidianbonner/enumerated/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/davidianbonner/enumerated.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/davidianbonner/enumerated.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/davidianbonner/enumerated.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/davidianbonner/enumerated
[link-travis]: https://travis-ci.org/davidianbonner/enumerated
[link-scrutinizer]: https://scrutinizer-ci.com/g/davidianbonner/enumerated/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/davidianbonner/enumerated
[link-downloads]: https://packagist.org/packages/davidianbonner/enumerated
[link-author]: https://github.com/davidianbonner
[link-contributors]: ../../contributors
