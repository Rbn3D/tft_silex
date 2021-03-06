<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new AudSync\Silex\ExtendedSilexApplication();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/../settings.yml'));
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__. '/../views'));
$app->register(new Knp\Provider\ConsoleServiceProvider(), array(
    'console.name' => 'TFT_Silex command line interface',
    'console.version' => '1.0.0',
    'console.project_directory' => __DIR__ . '/..'
));

$app['dao_manager'] = function () use ($app) {
	return new AudSync\DAO\DAOManager($app['config']['mysql']);
};
$app['disqus_oauth_manager'] = function () use ($app) {
	return new AudSync\OAuth\DisqusOAuthManager($app);
};

$app['debug'] = true;

// Debug controllers (local site to test disqus stuff)
$debug = $app['controllers_factory'];

$debug->get("/", function() use ($app)
{
	// Render a simple page with disqus comments
	$parameters = array('config'=>$app['config']);

    return $app['twig']->render('disqus_debug_page.twig', $parameters);
});


$app->mount("/disqus", new AudSync\Controllers\DisqusController());

if($app['debug'])
	$app->mount("/debug", $debug);

if(php_sapi_name() == 'cli' || defined('testing_env')) // it's cli or we are running unit tests, return $app instead of run the application
	return $app;
else
	$app->run();
