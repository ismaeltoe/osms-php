<?php
require '../src/Osms.php';

use \Osms\Osms;

$osms = new Osms('your_client_id', 'your_client_secret');

$response = $osms->getTokenFromConsumerKey();

if (empty($response['error'])) {
    echo $response['access_token'];
    // echo $osms->getToken();
} else {
    echo $response['error'];
}
