<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new SilexExtensions\ExtendedSilexApplication();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/../settings.yml'));
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__. '/../views'));

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

$app->run();
