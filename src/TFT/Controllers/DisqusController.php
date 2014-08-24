<?php

namespace TFT\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

class DisqusController implements ControllerProviderInterface
{
	public function connect(Application $app)
    {
    	$disqus = $app['controllers_factory'];

		$disqus->get('/as_callback', function (\Symfony\Component\HttpFoundation\Request $request) use ($app)
		{
			if($request->query->get('verify', false))
			{
				// Return terms of service
				echo 'TOS';
			}
			else
			{
				// Get the access token

				// Get the code for request access
			    $code = $request->query->get('code');
			    $audiencesync_uri = urldecode($request->query->get('audiencesync_uri'));

			    // Request the access token
			    extract($_POST);

			    $url = 'https://disqus.com/api/oauth/2.0/access_token/';
			    $fields = array(
				    'grant_type'=>urlencode("audiencesync"),
				    'client_id'=>urlencode($app["config"]["disqus.audsync.publickey"]),
				    'client_secret'=>urlencode($app["config"]["disqus.audsync.secret"]),
				    'redirect_uri'=>urlencode($app->url('disqus_as_callback')),
				    'code'=>urlencode($code)
			    );

			    $fields_string = "";
			    //url-ify the data for the POST
			    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			    rtrim($fields_string, "&");

			    //open connection
			    $ch = \curl_init();

			    //set the url, number of POST vars, POST data
			    \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			    \curl_setopt($ch,CURLOPT_URL,$url);
			    \curl_setopt($ch,CURLOPT_POST,count($fields));
			    \curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

			    //execute post
			    $result = \curl_exec($ch);

			    //close connection
			    \curl_close($ch);

			    $auth_results = json_decode($result);

			    //var_dump($auth_results);

			    if (isset($auth_results->error)) 
			    {
			        die($auth_results->error);
			    }

			    // Extract access token and render
			    $access_token = $auth_results->access_token;
			    $user_id = $auth_results->user_id;
			    $success = $request->query->get('success');

			    // If success, ask for user details
			    $url = 'https://disqus.com/api/3.0/users/details.json';

				$query = http_build_query(array(
						'access_token' => $access_token,
						'api_key' => $app["config"]["disqus.audsync.publickey"],
						'api_secret' => $app["config"]["disqus.audsync.secret"]
					));

				$url .= '?'.$query;
				var_dump($url);

			    //open connection
			    $ch = \curl_init();

			    //set the url, number of POST vars, POST data
			    \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			    \curl_setopt($ch,CURLOPT_URL,$url);

			    //execute post
			    $result = \curl_exec($ch);

			    //close connection
			    \curl_close($ch);

			    $user_details = json_decode($result);

			    var_dump($user_details);
			    var_dump($user_details->response->email);

			    $completion_url = "";

			    /*echo   '<script type="text/javascript">
			            window.location = "' . $completion_url . '";
			            </script>';*/
			}

			//var_dump($request);
			return '_';
		})->bind('disqus_as_callback');

        return $disqus;
    }
}