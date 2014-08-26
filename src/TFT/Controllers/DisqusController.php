<?php

namespace TFT\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

use TFT\DAO;
use TFT\Model;

class DisqusController implements ControllerProviderInterface
{
	public function connect(Application $app)
    {
    	$disqus = $app['controllers_factory'];

		$disqus->get('/as_callback', function (\Symfony\Component\HttpFoundation\Request $request) use ($app)
		{
			$oauthManager = $app['oauth_manager'];

		    $auth_results = $oauthManager->requestAccessToken($request->request->get('code'));

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

		    $user_details = $oauthManager->requestUserDetails($access_token);

		    $user = new \TFT\Model\UserDetails($user_id, $user_details->response->email);

		    $daoManager = $app['dao_manager'];
		    $daoManager->getUsetDetailsDAO()->save($user);

		    // Finalize process

		    $end_url = $audiencesync_uri ."?". http_build_query(array(
	    			'client_id'=>$app["config"]["disqus.audsync.publickey"],
	    			'user_id'=>$user_id,
	    			'access_token'=>$access_token,
	    			'success'=>1
	    		));

			//Rendirect user to end point
			return $app->redirect($end_url);

		})->bind('disqus_as_callback');

	    $disqus->get('/as_callback/tos', function (\Symfony\Component\HttpFoundation\Request $request) use ($app)
	    {
	    	return $app['twig']->render('disqus_as_tos.twig', array());
	    })
	    ->bind('disqus_as_callback_tos');

        return $disqus;
    }
}