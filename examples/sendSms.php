<?php
require '../src/Osms.php';

use \Osms\Osms;

$config = array(
    'token' => 'your_access_token'
);

$osms = new Osms($config);

//$osms->setVerifyPeerSSL(false);

$response = $osms->sendSms(
    // sender
    'tel:+22500000000',
    // receiver
    'tel:+22500000000',
    // message
    'Hello World!'
);

if (empty($response['error'])) {
    echo 'Done!';
} else {
    echo $response['error'];
}
