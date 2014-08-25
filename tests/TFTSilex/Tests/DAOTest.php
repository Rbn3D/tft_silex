<?php

namespace YourApp\Tests;

use Silex\WebTestCase;

class YourTest extends WebTestCase
{
	private $app;

    public function createApplication()
    {
        $app = require __DIR__.'/../../../../web/index.php';

        $app['debug'] = true;
	    $app['exception_handler']->disable();

	    $this->app = $app;
	    return $app;
    }

    public function testCreateUserDetails()
    {
        $this->app['daomanager']->getUserDetailsDao()->save(new \DAO\Model\UserDetails('2572652', 'test@mail.com'));
    }
}