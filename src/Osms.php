<?php 
namespace Osms;

class Osms 
{
	const BASE_URL = 'https://api.orange.com';

	/**
     * Client Identifier. Unique ID provided by the Orange backend server to identify 
     * your application.
     *
     * @var string
     */
    protected $clientId = '';

    /**
     * Client Secret. Used to sign/crypt the requests.
     *
     * @var string
     */
    protected $clientSecret = '';

    /**
     * The Token will be used for all further API calls.
     *
     * @var string
     */
    protected $token = '';

    /**
	 * Create a new Osms instance. If the user doesn't know his token or doesn't have a token 
	 * yet, he can leave $token empty and retrieve a token with getTokenFromConsumerKey() 
	 * method later.
	 *
	 * @param  string  $clientId
	 * @param  string  $clientSecret
	 * @param  string  $token
	 * @return void
	 */
    public function __construct($clientId, $clientSecret, $token = '')
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->token = $token;
    }

    /**
	 * Retrieves a token that will be used for all further API calls.
	 *
	 * @return array
	 */
    public function getTokenFromConsumerKey() 
    {	
    	$url = self::BASE_URL . '/oauth/v2/token';

    	$credentials = $this->getClientId() . ':' . $this->getClientSecret();

    	$headers = array(
    		'Authorization: Basic ' . base64_encode($credentials)
    	);

	    $args = array(
	        'grant_type' => 'client_credentials',
	    );

	    $response = $this->callApi($headers, $args, $url, 'POST', 200);

	    if (!empty($response['access_token']))
	    {
	    	$this->setToken($response['access_token']);
	    }

	    return $response;
    }

    /**
	 * Send SMS.
	 *
	 * @param  string  $senderAddress    The receiver address in this format: "tel:+22500000000" 
	 * @param  string  $receiverAddress  The receiver address in this format: "tel:+22500000000"
	 * @param  string  $message          The content of SMS, must not exceed 160 characters         
	 * @param  string  $senderName       The sender name
	 * @return array
	 */
    public function sendSms($senderAddress, $receiverAddress, $message, $senderName = '') 
    {	

    	$url = self::BASE_URL . '/smsmessaging/v1/outbound/' . urlencode($senderAddress) . '/requests';

    	$headers = array(
	    	'Authorization: Bearer ' . $this->getToken(),
	        'Content-Type: application/json'
    	);

    	if (!empty($senderName))
    	{
		    $args = array(
		        'outboundSMSMessageRequest' => array(
		            'address'                   => $receiverAddress,
		            'senderAddress'             => $senderAddress,
		            'senderName'                => urlencode($senderName),
		            'outboundSMSTextMessage'    => array(
		                'message' => $message
		            )
		        )
	    	);
	    }
	    else
	    {
	    	$args = array(
		        'outboundSMSMessageRequest' => array(
		            'address'                   => $receiverAddress,
		            'senderAddress'             => $senderAddress,
		            'outboundSMSTextMessage'    => array(
		                'message' => $message
		            )
		        )
	    	);
	    }

	    return $this->callApi($headers, $args, $url, 'POST', 201, true);
    }

    /**
	 * Lists SMS usage statistics per application.
	 *
	 * @param  array  $args  An associative array to filter the results, 
	 *                       containing country (the international 3 digits country code) 
	 *                       and/or appid (you can retrieve the application ID from your 
	 *                       dashboard application)
	 * @return array
	 */
    public function getAdminStats($args = null) 
    {	
    	$url = self::BASE_URL . '/sms/admin/v1/statistics';

    	$headers = array(
    		'Authorization: Bearer ' . $this->getToken()
    	);

	    return $this->callApi($headers, $args, $url, 'GET', 200);
    }

    /**
	 * Displays how many SMS you can still send.
	 *
	 * @param  string  $country  The country to filter on (the international 3 digits country)
	 * @return array
	 */
    public function getAdminContracts($country = '') 
    {
    	$url = self::BASE_URL . '/sms/admin/v1/contracts';

    	$headers = array(
    		'Authorization: Bearer ' . $this->getToken()
    	);

    	$args = null;

    	if (!empty($country))
    	{
		    $args = array(
		        'country' => $country,
		    );
		}

	    return $this->callApi($headers, $args, $url, 'GET', 200);
    }

    /**
	 *  Lists your purchase history.
	 *
	 * @param  string  $country  The country to filter on (the international 3 digits country)
	 * @return array
	 */
    public function getAdminPurchasedBundles($country = '')
    {
    	$url = self::BASE_URL . '/sms/admin/v1/purchaseorders';

    	$headers = array(
    		'Authorization: Bearer ' . $this->getToken()
    	);

    	$args = null;

    	if (!empty($country))
    	{
		    $args = array(
		        'country' => $country,
		    );
		}

	    return $this->callApi($headers, $args, $url, 'GET', 200);
    }

    /**
	 *  Get the Cliend ID.
	 *
	 * @return string
	 */
    public function getClientId()
    {
    	return $this->clientId;
    }

    /**
	 *  Call API Endpoints.
	 *
	 * @param  array   $headers         An array of HTTP header fields to set
	 * @param  array   $args            The data to send
	 * @param  string  $url             The URL to fetch
	 * @param  string  $method          Whether to do a HTTP POST or a HTTP GET
	 * @param  int     $successCode     The HTTP code that will be returned on success
	 * @param  bool    $jsonEncodeArgs  Whether or not to json_encode $args
	 * @return array   Contains the results returned by the endpoint or an error message 
	 */
    public function callApi($headers, $args, $url, $method, $successCode, $jsonEncodeArgs = false)
    {
    	$ch = curl_init();
 	
 		if ($method === 'POST')
 		{
	    	curl_setopt($ch, CURLOPT_URL, $url);
	 		curl_setopt($ch, CURLOPT_POST, true);

	 		if (!empty($args))
	 		{
		 		if ($jsonEncodeArgs === true)
		 		{
		 			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
		 		}
		 		else
		 		{
		 			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
		 		}
	 		}
	 	} // GET
	 	else
	 	{	
	 		if (!empty($args))
	 		{
	 			curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($args));
	 		}
	 		else
	 		{
	 			curl_setopt($ch, CURLOPT_URL, $url);
	 		}
	 	}

    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	// Make sure we can access the response when we execute the call
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    	$data = curl_exec($ch);

    	if ($data === false) {
    		return array('error' => 'API call failed with cURL error: ' . curl_error($ch));
    	}

    	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 
    	curl_close($ch);

    	$response = json_decode($data, true);

	    $jsonErrorCode = json_last_error();
	    if ($jsonErrorCode !== JSON_ERROR_NONE) {
	    	return array(
	    		'error' => 'API response not well-formed (json error code: ' . $jsonErrorCode . ')');
	    }

    	if ($httpCode !== $successCode) {
	        $errorMessage = '';

	        if (!empty($response['error_description'])) {
	            $errorMessage = $response['error_description'];
	        }
	        elseif (!empty($response['error'])) {
	            $errorMessage = $response['error'];
	        }
	        elseif (!empty($response['description'])) {
	            $errorMessage = $response['description'];
	        }
	        elseif (!empty($response['message'])) {
	            $errorMessage = $response['message'];
	        }
	        elseif (!empty($response['requestError']['serviceException'])) {
	            $errorMessage = $response['requestError']['serviceException']['text'] .
	                ' ' . $response['requestError']['serviceException']['variables'];
	        }
	        elseif (!empty($response['requestError']['policyException'])) {
	            $errorMessage = $response['requestError']['policyException']['text'] .
	                ' ' . $response['requestError']['policyException']['variables'];
	        }

	        return array('error' => $errorMessage);
    	}

    	return $response;
    }

    /**
	 *  Get the Client Secret.
	 *
	 * @return string
	 */
    public function getClientSecret()
    {
    	return $this->clientSecret;
    }

    /**
	 *  Get the Token.
	 *
	 * @return string
	 */
    public function getToken()
    {
    	return $this->token;
    }

    /**
	 *  Set the Token value.
	 *
	 * @return string
	 */
    public function setToken($token)
    {
    	$this->token = $token;
    }
}