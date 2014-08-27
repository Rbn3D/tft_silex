<?php
namespace AudSync\Tests;
require_once __DIR__.'/../../../vendor/autoload.php';

if(!defined('testing_env'))
	define('testing_env', 1);

/**
 * Trait that loads the Silex Application and makes it ready for testing. All tests should inherit Silex/WebTestCase and use this trait
 */
trait BaseTestCase
{
	public function createApplication()
    {    	
        $app = require __DIR__.'/../../../web/index.php';

        $app['debug'] = true;
	    $app['exception_handler']->disable();

	    $this->app = $app;
	    return $app;
    }
}