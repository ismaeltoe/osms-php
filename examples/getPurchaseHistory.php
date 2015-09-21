<?php
require '../src/Osms.php';

use \Osms\Osms;

$config = array(
    'token' => 'your_access_token'
);

$osms = new Osms($config);

//$osms->setVerifyPeerSSL(false);

$response = $osms->getAdminPurchasedBundles();
//$response = $osms->getAdminPurchasedBundles('CIV');

if (empty($response['error'])) {    
    $purchaseOrders = $response['purchaseOrders'];

    foreach ($purchaseOrders as $purchaseOrder) {
        echo $purchaseOrder['bundleDescription'] .' ';
        echo $purchaseOrder['orderExecutioninformation']['amount'] . ' '
            . $purchaseOrder['orderExecutioninformation']['currency'];
    }
} else {
    echo $response['error'];
}
