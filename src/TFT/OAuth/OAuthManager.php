<?php

namespace TFT\OAuth;

use TFT\OAuth\HTTPMethod;
class OAuthManager
{
	/**
	 * @var \Silex\Application A reference to the Silex Application
	 */
	private $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function requestAccessToken($code)
	{
		$url = 'https://disqus.com/api/oauth/2.0/access_token/';
		$fields = array(
		    'grant_type'=>"audiencesync",
		    'client_id'=>$this->app["config"]["disqus.audsync.publickey"],
		    'client_secret'=>$this->app["config"]["disqus.audsync.secret"],
		    'redirect_uri'=>$this->app->url('disqus_as_callback'),
		    'code'=>$code
	    );

		return $this->call($url, $fields, HTTPMethod::POST);
	}

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