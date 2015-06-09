<?php
require '../src/Osms.php';

use \Osms\Osms;

$osms = new Osms('your_client_id', 'your_client_secret', 'your_access_token');

$response = $osms->getAdminStats(array('country' => 'CIV'));
// $response = $osms->getAdminStats();
// $response = $osms->getAdminStats(array('appid' => 'your_app_id'));
// $response = $osms->getAdminStats(array('country' => 'CIV', 'appid' => 'your_app_id'));

if (empty($response['error'])) {
    var_export($response);
} else {
    echo $response['error'];
}
