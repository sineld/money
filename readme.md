# sineld/money

[![Latest Version][badge-release]][release]
[![Total Downloads][badge-downloads]][downloads]

`sineld/money` is a PHP library to make working with money easier! No static properties or methods!

Any number you have passed to the class will automatically prepared to make math operations.
Class uses `,` for thousands and `.` for decimals.

Package can be used with any framework or spagetty application. Just mail me if anything goes wrong.

## Installation

Via Composer

``` bash
$ composer require sineld/money
```

Add usecase to the top of your file

``` bash
use Sineld\Money\Money;
```

Start using.

## Non-Composer Users

Simply copy Money.php in src folder to your project and begin using. No extra dependencies.

### Request method aliases

For parametres to use with methods.

##### money->setDecimals(default = 2)
##### money->addTax(default = 18)
##### money->removeTax(default = 18)
##### money->setLocaleActive(default = false)
##### money->setLocaleCode(default = TRL)
##### money->setLocalePosition(default = prefix, (use "suffix" instead of reverse))

## Usage Examples

All in one place:

``` bash
<?php

$number1 = '100,123.45';
$number2 = '50,123.45';

use Sineld\Money\Money;
$money = (new Money())
    ->make($number1) // Create a new Money instance.
    ->setDecimals(4) // Set decimals size.
    ->sum($number2) // Add $number2 variable(s) value to the $money
    ->subtract($number2) // Remove $number2 variable(s) value from the $money
    ->multiply('3') // Multiply $money with $numbers variable(s) value.
    ->divide('3') // Divide $money with $numbers variable(s) value.
    ->addTax(18) // Add $percent variable to the $money with calculated value.
    ->removeTax(18) // Remove $percent variable to the $money with calculated value.
    ->setLocaleActive(true) // Enable Locale Usage.
    ->setLocaleCode('₺ ') // Set Locale Code preference
    ->setLocalePosition('prefix') // Set Locale Position preference

    // ->getTax(); // Return calculated $taxAmount variable.
    ->get(); // Return $money variable according to the locale usage.
    // ->all(); // Return the $money and $taxAmount variables in a array.

var_dump($money);
```

Basic Sum Operation:

``` bash
<?php

$number1 = '100,123.45';
$number2 = '50,123.45';

$money = (new Money())
    ->make($number1)
    ->sum($number2)
    ->get();

echo $money;
```

Basic Sum Operation with Two numbers:

``` bash
<?php

$number1 = '100,123.45';
$number2 = '50,123.45';
$number3 = '25,123.45';

$money = (new Money())
    ->make($number1)
    ->setDecimals(4)
    ->sum($number2, $number3)
    // ->sum($number2, $number3, $number4, ...) // add parametres as much as you need
    ->get();

echo $money;
```

Basic Subtract Operation:

``` bash
<?php

$number1 = '100,123.45';
$number2 = '50,123.45';

$money = (new Money())
    ->make($number1)
    ->subtract($number2)
    ->get();

echo $money;
```

Basic Subtract Operation with Two numbers:

``` bash
<?php

$number1 = '100,123.45';
$number2 = '50,123.45';
$number3 = '25,123.45';

$money = (new Money())
    ->make($number1)
    ->setDecimals(4)
    ->subtract($number2, $number3)
    // ->subtract($number2, $number3, $number4, ...) // add parametres as much as you need
    ->get();

echo $money;
```

Basic Sum and Subtract Operations in one place:

``` bash
<?php

$number1 = '100,123.45';
$number2 = '50,123.45';
$number3 = '25,123.45';

$money = (new Money())
    ->make($number1)
    ->setDecimals(4)
    ->sum($number2)
    ->subtract($number3)
    ->get();

echo $money;
```

Basic Multiplication and Division Operations in one place:

``` bash
<?php

$number1 = '100';
$number2 = '50';
$number3 = '25';

$money = (new Money())
    ->make($number1)
    ->setDecimals(0)
    ->multiply($number2)
    ->divide($number3)
    ->get();

echo $money;
```

Basic Tax Operations:

``` bash
<?php

$number1 = '100';
$taxPercent = '18';

$money = (new Money())
    ->make($number1)
    ->setDecimals(2)
    ->addTax($taxPercent)
    ->get();

// tax added number
echo $money;

$tax = (new Money())
    ->make($number1)
    ->setDecimals(2)
    ->addTax($taxPercent)
    ->getTax();

// calculated tax after addtition
echo $tax;

$money = (new Money())
    ->make($number1)
    ->setDecimals(2)
    ->addTax($taxPercent)
    ->all();

// tax added number and calculated tax together
// var_dump($money);
echo $money['amount'];
echo $money['tax'];
```

Remove tax percent from money:

``` bash
<?php

$number1 = '236';
$taxPercent = '18';

$money = (new Money())
    ->make($number1)
    ->setDecimals(2)
    ->removeTax($taxPercent)
    ->get();

echo $money;
```

Remove tax percent from money and add new tax:

``` bash
<?php

$number1 = '236';
$taxPercent1rst = '18';
$taxPercent2nd = '8';

$money = (new Money())
    ->make($number1)
    ->setDecimals(2)
    ->removeTax($taxPercent1rst)
    ->addTax($taxPercent2nd)
    ->get();

echo $money;
```

Enable Locale String Output in the Prefix:

``` bash
<?php

$number1 = '100';

$money = (new Money())
    ->make($number1) // Create a new Money instance.
    ->setDecimals(4) // Set decimals size.
    ->setLocaleActive(true) // Enable Locale Usage.
    ->setLocaleCode('₺ ') // Set Locale Code preference
    ->setLocalePosition('prefix') // Set Locale Position preference

    ->get(); // Return $money variable according to the locale usage.

echo $money;
```

Enable Locale String Output in the Suffix:

``` bash
<?php

$number1 = '100';

$money = (new Money())
    ->make($number1) // Create a new Money instance.
    ->setDecimals(4) // Set decimals size.
    ->setLocaleActive(true) // Enable Locale Usage.
    ->setLocaleCode(' €') // Set Locale Code preference
    ->setLocalePosition('suffix') // Set Locale Position preference

    ->get(); // Return $money variable according to the locale usage.

echo $money;
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Sinan Eldem](https://www.sinaneldem.com.tr)

## License

Please see the [license file](license.md) for more information.

[badge-release]: https://img.shields.io/packagist/v/sineld/money.svg?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/sineld/money.svg?style=flat-square

[release]: https://packagist.org/packages/sineld/money
[downloads]: https://packagist.org/packages/sineld/money
