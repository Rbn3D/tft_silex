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
			$oauthManager = $app['disqus_oauth_manager'];

			// Get Access Token
		    $auth_results = $oauthManager->requestDisqusAccessToken($request->request->get('code'));
		    $access_token = $auth_results->access_token;
		    $user_id = $auth_results->user_id;

		    // Request user details
		    $user_details = $oauthManager->requestDisqusUserDetails($access_token);

		    // Persist user details
		    $user = new \TFT\Model\UserDetails($user_id, $user_details->response->email);
		    $daoManager = $app['dao_manager'];
		    $daoManager->getUsetDetailsDAO()->save($user);

			//Rendirect user to end point
		    $audiencesync_uri = $request->request->get('audiencesync_uri');
		    $end_url = $oauthManager->getDisqusCompletionURL($audiencesync_uri, $access_token, $user_id);

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