<?php
require '../src/Osms.php';

use \Osms\Osms;

$osms = new Osms('your_client_id', 'your_client_secret', 
	'your_access_token');

$response = $osms->getAdminPurchasedBundles();
//$response = $osms->getAdminPurchasedBundles('CIV');

if (empty($response['error']))
{	
	$purchaseOrders = $response['purchaseOrders'];

	foreach ($purchaseOrders as $purchaseOrder) {
		echo $purchaseOrder['bundleDescription'] .' ';
		echo $purchaseOrder['orderExecutioninformation']['amount'] . ' ' . 
			$purchaseOrder['orderExecutioninformation']['currency'];
	}
}
else
{
	echo $response['error'];
}