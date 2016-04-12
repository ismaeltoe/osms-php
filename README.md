# Osms

A PHP library to access Orange SMS API.

Current version: 2.0.1

## Installation

### With Composer (recommended)

Install [Composer](https://getcomposer.org/). Then, do:

    $ composer require ismaeltoe/osms

### Without Composer

Simply [download the latest release](https://github.com/ismaeltoe/osms-php/archive/master.zip).

## Loading

You can load the class using Composer's autoloading:

```php
require 'vendor/autoload.php';
```
Otherwise, you can simply require the file directly:

```php
require 'path/to/Osms.php';
```
## Quick Start

**Case 1: You have no access token**

```php
require 'vendor/autoload.php';

use \Osms\Osms;

$config = array(
    'clientId' => 'your_client_id',
    'clientSecret' => 'your_client_secret'
);

$osms = new Osms($config);

// retrieve an access token
$response = $osms->getTokenFromConsumerKey();

if (!empty($response['access_token'])) {
    $senderAddress = 'tel:+22500000000';
    $receiverAddress = 'tel:+22500000000';
    $message = 'Hello World!';
    $senderName = 'Optimus Prime';

    $osms->sendSMS($senderAddress, $receiverAddress, $message, $senderName);
} else {
    // error
}
```

**Case 2: You have an access token**

```php
require 'vendor/autoload.php';

use \Osms\Osms;

$config = array(
    'token' => 'your_access_token'
);

$osms = new Osms($config);

$senderAddress = 'tel:+22500000000';
$receiverAddress = 'tel:+22500000000';
$message = 'Hello World!';
$senderName = 'Optimus Prime';

$osms->sendSMS($senderAddress, $receiverAddress, $message, $senderName);
```
Check out [examples](https://github.com/ismaeltoe/osms-php/tree/master/examples) for more examples.

CHECK OUT also [Osms.php](https://github.com/ismaeltoe/osms-php/blob/master/src/Osms.php) to see all the methods available. But DON'T MODIFY IT. You can extend the class to add your own stuff.

## SSL certificate problem

If you get an SSL error, set the peer's certificate checking option to false:

```php
$osms = new Osms();
$osms->setVerifyPeerSSL(false);
```
But it should work on your hosting server, so enable the certificate checking when you are ready to deploy your application for security reasons.

## Documentation

 * Native API [https://developer.orange.com/apis/sms-ci/getting-started](https://developer.orange.com/apis/sms-ci/getting-started)

## Other Libraries

 * [osms-android](https://github.com/ismaeltoe/osms-android)

## License

Released under the MIT License - see `LICENSE.txt` for details.