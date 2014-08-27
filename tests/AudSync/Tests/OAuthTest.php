<?php
namespace AudSync\Tests;

use AudSync\Tests\BaseTestCase;
use Silex\WebTestCase;
use AudSync\OAuth;

class OAuthTest extends WebTestCase
{
	use BaseTestCase;
	public function testRequestAccessToken()
	{
		$oauthManager = $this->app['disqus_oauth_manager'];

		var_dump($oauthManager->getAudienceSyncAuthorizationURL());
	}
}