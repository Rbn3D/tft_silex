<?php

namespace TFT\OAuth;

use TFT\OAuth\HTTPMethod;
/**
* OAuthManager
*
* @author   Rubén Vallejo Gamboa <ruben3d3@gmail.com>
*/
class OAuthManager
{
	/**
	 * @var \Silex\Application A reference to the Silex Application
	 */
	protected $app;

    /**
     * Creates a new {@link OAuthManager} instance 
     * 
     * @param \Silex\Application $app A reference to the Silex Application.
     *
     * @access public
     *
     * @return OAuthManager The created instance.
     */
	public function __construct($app)
	{
		$this->app = $app;
	}

    /**
     * Performs an HTTP request
     * 
     * @param mixed $url        The URL to be requested.
     * @param array $parameters A key value array with the parameters to be sent to the server. No needed to use urlencode(). Empty by default.
     * @param mixed $method     HTTP Method. Should be HTTPMethod::GET or HTTPMethod::POST. HTTPMethod::GET by default.
     *
     * @access public
     *
     * @throws OAuthException if the server returns an error, containing the error message.
     *
     * @return array A key-value array with the data (decoded from JSON) returned from the server.
     */
	public function call ($url, $parameters = array(), $method = HTTPMethod::GET)
	{
		$query = http_build_query($parameters);

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    if($method == HTTPMethod::POST)
	    {
	    	curl_setopt($ch,CURLOPT_POST,count($parameters));
	    	curl_setopt($ch,CURLOPT_POSTFIELDS,$query);
	    }
	    else if($method == HTTPMethod::GET)
	    {
	    	$url.= '?'.$query;
	    }

	    curl_setopt($ch,CURLOPT_URL,$url);

	   	$ch_result = curl_exec($ch);

	    curl_close($ch);

	    $result = json_decode($ch_result);

	   	if (isset($result->error)) 
	        throw new OAuthException($result->error);

		return $result;
	}
}