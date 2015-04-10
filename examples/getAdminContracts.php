<?php
require '../src/Osms.php';

use \Osms\Osms;

$osms = new Osms('your_client_id', 'your_client_secret', 
	'your_access_token');

$response = $osms->getAdminContracts('CIV');
// $response = $osms->getAdminContracts();

if (empty($response['error']))
{	
	var_export($response);
}
else
{
	echo $response['error'];
}