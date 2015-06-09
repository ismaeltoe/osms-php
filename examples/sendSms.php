<?php
require '../src/Osms.php';

use \Osms\Osms;

$osms = new Osms('your_client_id', 'your_client_secret', 'your_access_token');

$response = $osms->sendSms('tel:+22500000000', 'tel:+22501010101', 'Hello World!');

if (empty($response['error'])) {
    echo 'Done!';
} else {
    echo $response['error'];
}
