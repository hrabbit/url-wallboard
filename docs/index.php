<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;

$app = new Silex\Application();
$app['debug'] = true;

$base_config = array(
	'title' => 'My Wallboard',
	'users' => array(
		'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
	),
);

/* Lets start by trying to establish a generic config */
try{
	$app['config'] = Yaml::parse(__DIR__.'/../settings.yml');
} catch (\InvalidArgumentException $e) {
	return new Response("Unable to parse the YAML string: ".$e->getMessage(),500);
}

if(!is_array($app['config']))
{
	$app['config'] = $base_config;
}
// $yaml = Yaml::dump($config);

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
	'security.firewalls' => array(
		'login' => array(
			'pattern' => '^/admin/login$',
			),
		'admin' => array(
			'pattern' => '^/admin',
			// 'logout' => array('logout_path' => '/admin/logout'),
			'http' => true,
			// 'form' => array('login_path' => '/admin/login', 'check_path' => '/admin/login_check'),
			'users' => //array(
				// raw password is foo
				$app['config']['users'],
				// isset($app['config']['users']) ? $app['config']['users'] : array(),
				// 'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
				//),
			),
		),
	));

// Access the default (and only) route which shows the board
$app->get('/', function () use ($app) {
    return 'Wallboard content here';
});

$app->mount('/admin', new Hpbx\AdminControllerProvider());

$app->run();
