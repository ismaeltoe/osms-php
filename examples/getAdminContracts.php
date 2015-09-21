<?php
require '../src/Osms.php';

use \Osms\Osms;

$config = array(
    'token' => 'your_access_token',
);

$osms = new Osms($config);

//$osms->setVerifyPeerSSL(false);

$response = $osms->getAdminContracts('CIV');
// $response = $osms->getAdminContracts();

if (empty($response['error'])) {
    var_export($response);
} else {
    echo $response['error'];
}
