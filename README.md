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

$url_string = Helpers::text2seolink("Hello World."); // "hello-world"

use JanMensik\PHPHelpers\UrlParameters;

$new_url = new UrlParameters($url);
```
