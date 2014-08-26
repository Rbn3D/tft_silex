<?php
namespace TFT\Tests;
require_once __DIR__.'/../../../vendor/autoload.php';

use TFT\OAuth;

class OAuthTest extends BaseTestCase
{
	public function testRequestAccessToken()
	{
		$oauthManager = $this->app['oauth_manager'];
		$code = $this->app['config']['disqus.audsync.debug.accesstoken'];

		var_dump($result=$oauthManager->requestAccessToken($code));
	}
}