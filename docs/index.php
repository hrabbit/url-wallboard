<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

/*
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/../app.db',
    ),
));
*/

new \Pixie\Connection('sqlite', array(
                'driver'   => 'sqlite',
                'database' => __DIR__.'/../hpbx.sqlite',
                'prefix'   => '',
            ), 'QB');

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

// definitions
$app->mount('/admin', new Hpbx\AdminControllerProvider());

$app->get('/', function() use ($app) {
	// Get widgets here
	$widgets = array(
		array(
			'title' => 'A',
			'calls_waiting' => 5,
			'agents' => array(),
		),
		array(
			'title' => 'B',
			'calls_waiting' => 4,
			'agents' => array(),
		),
	);

	return $app['twig']->render('frontend.html.twig', array(
		'widgets' => $widgets,
		'config' => $config,
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
