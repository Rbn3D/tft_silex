<?php
namespace TFT\Tests;

abstract class BaseTestCase
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