<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new SilexExtensions\ExtendedSilexApplication();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/../settings.yml'));
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__. '/../views'));
$app->register(new Knp\Provider\ConsoleServiceProvider(), array(
    'console.name' => 'TFT_Silex command line interface',
    'console.version' => '1.0.0',
    'console.project_directory' => __DIR__ . '/..'
));

$app['daomanager'] = function () use ($app) {
	return new TFT\DAO\DAOManager($app['config']['mysql']);
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


$app->mount("/disqus", new TFT\Controllers\DisqusController());

if($app['debug'])
	$app->mount("/debug", $debug);

if(php_sapi_name() == 'cli') // it's cli, return $app (to allow app/console get it)
	return $app;
else
	$app->run();
