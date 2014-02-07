<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

new \Pixie\Connection('sqlite', array(
                'driver'   => 'sqlite',
                'database' => __DIR__.'/../hpbx.sqlite',
                'prefix'   => '',
            ), 'QB');

$hpbx = new \Hpbx\Helper();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$config = array();
foreach(\QB::table('options')->select(array('key', 'value'))->get() as $db_config)
	$config[$db_config->key] = $db_config->value;
$app['config'] = $config;

// definitions
$app->mount('/admin', new Hpbx\AdminControllerProvider());

$app->get('/', function() use ($app) {
	// Get widgets here
	$widgets = \QB::table('widgets')->get();
	foreach($widgets as $widget)
	{
		
	}

	return $app['twig']->render('frontend.html.twig', array(
		'widgets' => $widgets,
		// 'config' => $config,
	));
});

$app->error(function (\Exception $e, $code) use ($app){
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    if($app['debug'] == true)
	    return $e->getMessage();
    return new Response($message);
});

$app->run();
