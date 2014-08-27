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
		$oauthManager = $this->app['disqus_oauth_manager'];

		var_dump($oauthManager->getAudienceSyncAuthorizationURL());
	}
}