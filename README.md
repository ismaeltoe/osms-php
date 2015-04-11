# Osms

A PHP library to access Orange SMS API.

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
```
## Quick Start

```php
require 'vendor/autoload.php';

use \Osms\Osms;

$osms = new Osms('your_client_id', 'your_client_secret', 'your_access_token');

$senderAddress = 'tel:+22500000000';
$receiverAddress = 'tel:+22501010101';
$message = 'Hello World!';

$osms->sendSMS($senderAddress, $receiverAddress, $message);
```
For more examples, see [examples](https://github.com/ismaeltoe/osms-php/tree/master/examples).

## SSL certificate problem

When running your application in a local environment, you will get an SSL error. To make things work, set the peer's certificate checking option to false:

```php
$osms = new Osms('your_client_id', 'your_client_secret', 'your_access_token', false);
```
But it should work on your hosting server, so enable the certificate checking when you are ready to deploy your application for security reasons.

## Links

Follow this link to know more about the Orange SMS API:

 * [Orange SMS API](https://www.orangepartner.com/SMS-CI-API)

## License

Released under the MIT License - see `LICENSE.txt` for details.