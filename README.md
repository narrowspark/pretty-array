<h1 align="center">Narrowspark Pretty Array</h1>
<p align="center">
    <a href="https://github.com/narrowspark/pretty-array/releases"><img src="https://img.shields.io/packagist/v/narrowspark/pretty-array.svg?style=flat-square"></a>
    <a href="https://php.net/"><img src="https://img.shields.io/badge/php-%5E7.2.0-8892BF.svg?style=flat-square"></a>
    <a href="https://codecov.io/gh/narrowspark/pretty-array"><img src="https://img.shields.io/codecov/c/github/narrowspark/pretty-array/master.svg?style=flat-square"></a>
    <a href="http://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square"></a>
</p>

Branch Status
------------
[![Travis branch](https://img.shields.io/travis/narrowspark/pretty-array/master.svg?style=flat-square)](https://travis-ci.org/narrowspark/pretty-array)
[![Codecov branch](https://img.shields.io/codecov/c/github/narrowspark/pretty-array/master.svg?style=flat-square)](https://codecov.io/gh/narrowspark/pretty-array/branch/master)

Installation
-------------

Use [Composer](https://getcomposer.org/) to install this package:

```sh
composer require narrowspark/pretty-array
```

Usage
-------------

```php
use Narrowspark\PrettyArray\PrettyArray;

$prettyArray = new PrettyArray();
```

If you just pass a array you will get this output.

```php
/**
 * This is the output.
 * 
 * [
 *     0 => 1,
 * ]
 */
$prettyArray->print([1]);
```

To let the array output start from 4 spaces, just change the indent level.

```php
/**
 * This is the output.
 * 
 *     [
 *         0 => 1,
 *     ]
 */
$prettyArray->print([1], 2);
```

You can add a type resolver to change the value output.

All supported types can be found on [php.net](http://php.net/manual/en/function.gettype.php)

```php
$prettyArray->setResolver('object', function($value) {
    return 'foo'
});

/**
 * This is the output.
 * 
 * [
 *    0 => 'foo',
 * ]
 */
$prettyArray->print(
    [
        0 => function() {
            return 'foo'; 
        },
    ],
);
```

Testing
-------------

You need to run:
``` bash
$ php vendor/bin/phpunit
```

Contributing
------------

If you would like to help take a look at the [list of issues](http://github.com/narrowspark/testing-helper/issues) and check our [Contributing](CONTRIBUTING.md) guild.

> **Note:** Please note that this project is released with a Contributor Code of Conduct. By participating in this project you agree to abide by its terms.

Credits
-------------

- [Daniel Bannert](https://github.com/prisis)
- [All Contributors](../../contributors)

License
-------------

The MIT License (MIT). Please see [License File](LICENSE) for more information.
