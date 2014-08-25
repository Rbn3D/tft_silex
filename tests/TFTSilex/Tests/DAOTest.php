<?php
namespace TFTSilex\Tests;

require_once __DIR__.'/../../../vendor/autoload.php';

use Silex\WebTestCase;
use TFT\Model;

class DAOTest extends WebTestCase
{
    public function createApplication()
    {
    	if(!defined('testing_env'))
    		define('testing_env', 1);
    	
        $app = require __DIR__.'/../../../web/index.php';

        $app['debug'] = true;
	    $app['exception_handler']->disable();

	    $this->app = $app;
	    return $app;
    }

    public function testCreateUserDetails()
    {
        $dao = $this->app['daomanager']->getUsetDetailsDAO();
        $dao->save(new \TFT\Model\UserDetails('2572652asfas', '2test@mail.com'));
        //$user = $this->app['daomanager']->getUsetDetailsDAO()->queryOneBy("disqus_user_id", '2572652');

        $user = new \TFT\Model\UserDetails('2572652', 'test@mail.com');
        $this->assertSame((string) '2572652', (string) $user->getDisqusUserId());
    }

    public function testQueryAll()
    {
    	$dao = $this->app['daomanager']->getUsetDetailsDAO();
    	$users = $dao->queryAll();

    	var_dump($users);

    	$this->assertTrue(count($users) > 0, "queryAll() didn't retrieve any users");
    }
}