<?php

namespace TFT\OAuth;

/**
* Provides high level methods to interact with the Disqus Audience Sync API
*
* @uses     OAuthManager
*
* @author    Rubén Vallejo Gamboa <ruben3d3@gmail.com>
*/
class DisqusOAuthManager extends OAuthManager
{
    /**
     * Request an AudienceSync Access Token. This sould be called from the controller that handles the Audience Sync callback
     * 
     * @param mixed $code The temporal code that Disqus sents using _POST to the Audience Sync callback URL.
     *
     * @access public
     *
     * @return array A key-value array with the data (decoded from JSON) returned from the server.
     */
	public function requestDisqusAccessToken($code)
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

    /**
     * Request User Details
     * 
     * @param mixed $access_token The Audience Sync access token.
     *
     * @access public
     *
     * @return array A key-value array with the data (decoded from JSON) returned from the server.
     */
	public function requestDisqusUserDetails($access_token)
	{
		$url = 'https://disqus.com/api/3.0/users/details.json';
		$fields = array(
				'access_token' => $access_token,
				'api_key' => $this->app["config"]["disqus.audsync.publickey"],
				'api_secret' => $this->app["config"]["disqus.audsync.secret"]
	    );

		return $this->call($url, $fields, HTTPMethod::GET);
	}

    /**
     * Returns the Audience Sync completion URL where you should redirect the user after you have readed the data you need
     * 
     * @param mixed $audiencesync_uri The Audience Sync uri that Disqus sents using POST to the Audience Sync callback URL.
     * @param mixed $access_token     The Audience Sync access token.
     * @param mixed $user_id          The user_id.
     *
     * @access public
     *
     * @return mixed The generated URL.
     */
	public function getDisqusCompletionURL($audiencesync_uri, $access_token, $user_id)
	{
		return $audiencesync_uri ."?". http_build_query(array(
				'client_id'=>$this->app["config"]["disqus.audsync.publickey"],
				'user_id'=>$user_id,
				'access_token'=>$access_token,
				'success'=>1
			));
	}
}