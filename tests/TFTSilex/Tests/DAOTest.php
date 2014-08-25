<?php
namespace TFTSilex\Tests;

require_once __DIR__.'/../../../vendor/autoload.php';

use Silex\WebTestCase;
use TFT\Model;

class DAOTest extends WebTestCase
{
    public function createApplication()
    {
    	define('testing_env', 1);
        $app = require __DIR__.'/../../../web/index.php';

        $app['debug'] = true;
	    $app['exception_handler']->disable();

	    $this->app = $app;
	    return $app;
    }

    public function testCreateUserDetails()
    {
        $this->app['daomanager']->getUsetDetailsDAO()->save(new \TFT\Model\UserDetails('2572652', 'test@mail.com'));
        //$this->app['daomanager']->getUsetDetailsDAO();
        $user = $this->app['daomanager']->getUsetDetailsDAO()->queryOneBy("disqus_user_id", '2572652');

        $this->assertSame((string) '2572652', (string) $user->getDisqusUserId());
        //$this->assertSame((string) '2572652', (string) '2572652');
    }
}