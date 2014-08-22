<?php

namespace SilexExtensions;

use \Silex\Application;

/**
 * Extended Silex application class
 *
 * @author Rubén Vallejo <ruben@rubenvallejogamboa.com>
 */
class ExtendedSilexApplication extends Application
{
	use \Silex\Application\UrlGeneratorTrait;
	use \Silex\Application\TwigTrait;
}