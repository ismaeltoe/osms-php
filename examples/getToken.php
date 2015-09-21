<?php
require '../src/Osms.php';

use \Osms\Osms;

$config = array(
    'clientId' => 'your_client_id',
    'clientSecret' => 'your_client_secret'
);

$osms = new Osms($config);

//$osms->setVerifyPeerSSL(false);

$response = $osms->getTokenFromConsumerKey();

if (empty($response['error'])) {
    echo $response['access_token'];
    // echo $osms->getToken();
} else {
    echo $response['error'];
}
