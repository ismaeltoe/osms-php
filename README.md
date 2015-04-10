![Osms](https://github.com/ismaeltoe/osms-php)

A PHP library to access Orange SMS API.

* [Installation](#installation)
* [Loading](#loading)
* [Quick Start](#quick-start)
* [Links](#links)
* [License](#license)

## Installation

Install Composer. Then, simply do:

    $ composer require ismaeltoe/osms

## Loading

You can load the class using Composer's autoloading:

```php
require 'vendor/autoload.php';
```

Otherwise, you can simply require the file directly:

```php
require_once 'path/to/Osms.php';

## Quick Start

```php
require 'vendor/autoload.php';

use \Osms\Osms;

$osms = new Osms('your_client_id', 'your_client_secret', 'your_access_token');
$osms->sendSMS('tel:+22500000000', 'tel:+22501010101', 'Hello World!');
```
For more examples, see [examples](#https://github.com/ismaeltoe/osms-php/tree/master/examples)

## Links

Follow this link to know more about the Orange SMS API:

 * [Orange SMS API](https://www.orangepartner.com/SMS-CI-API)

## License

Released under the MIT License - see `LICENSE.txt` for details.
