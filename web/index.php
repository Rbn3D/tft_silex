<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/../settings.yml'));


//$app['debug'] = true;

// Disqus controllers, should be moved to another file as described here (http://silex.sensiolabs.org/doc/providers.html#controller-providers) if gets too fat
$disqus = $app['controllers_factory'];

$disqus->get('/as_callback', function (Symfony\Component\HttpFoundation\Request $request) use ($app)
{
	var_dump($app["config"]);
	var_dump($request);
	return 'df';
});

$app->mount("/disqus", $disqus);

$app->run();
