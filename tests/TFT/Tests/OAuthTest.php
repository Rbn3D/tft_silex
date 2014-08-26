<?php
namespace TFT\Tests;

use TFT\Tests\BaseTestCase;
use Silex\WebTestCase;
use TFT\OAuth;

class OAuthTest extends WebTestCase
{
	use BaseTestCase;
	public function testRequestAccessToken()
	{
		$oauthManager = $this->app['oauth_manager'];
		$code = $this->app['config']['disqus.audsync.debug.accesstoken'];

		var_dump($result=$oauthManager->requestAccessToken($code));
	}
}