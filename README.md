# PHPHelpers

Pack of small helper functions for transformations input and outputs.

## Installation

Install via Composer:

```
composer require janmensik/phphelpers
```

## Usage

```php
use JanMensik\PHPHelpers\Helpers;

$snake = Helpers::toSnakeCase('HelloWorld'); // hello_world

use JanMensik\PHPHelpers\UrlParameters;

$new_url = new UrlParameters($url);
```
