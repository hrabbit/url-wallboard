<?php

require '../vendor/autoload.php';

// Set the current mode
$app = new \Slim\Slim(array(
    'mode'				=> 'development',
    'view'				=> '\Slim\LayoutView',
    'templates.path'		=> '../templates',
    'layout'				=> 'base.php',
));


// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true
    ));
});

new \Pixie\Connection('sqlite', array(
                'driver'   => 'sqlite',
                'database' => __DIR__.'/../hpbx.sqlite',
                'prefix'   => '',
            ), 'QB');


// $authentication = function($app)
// {
// 	return function () use ($app) {
// 		$app->add(new \Slim\Extras\Middleware\HttpBasicAuth('username', 'password'));
// 	};
// };

// $app->add(new \Slim\Extras\Middleware\HttpBasicAuth('username2', 'password'));
function authenticate()
{
// 	// use \Slim\Slim;
// 	// $app = \Slim\
// 	// $app = new \Slim\Slim();
// 	// $app = \Slim\Environment::getInstance();
// 	$app = \Slim\Slim::getInstance();
// 	$auth = new \Slim\Extras\Middleware\HttpBasicAuth('username2', 'password');
// 	$app->add($auth);
// 	$auth->call();
// 	// $app->add(new HttpBasicAuth('theUsername', 'thePassword'));
// 	// $app->add(new \Slim\Extras\Middleware\HttpBasicAuth('username', 'password'));
// 	// \Slim\Extras\Middleware\HttpBasicAuth::call();
// 	// echo '<pre>'; var_dump($app); exit;
}

// $app->hook('authentication', function () use ($app) 
// {
// 	echo 'hook';
// });

$app->group('/admin', 'authenticate', function () use ($app) 
{

	$app->get('/', function () use ($app)
	{
		// $app->applyHook('authentication');
		echo "admin";
	});

	$app->group('/widget', function () use ($app)
	{
		$app->get('/', function ()
		{
			// $app->applyHook('authentication');
			echo "admin > widget";
		});

		$app->post('/add', function () 
		{
			// $app->applyHook('authentication');
			echo "admin > widget > add";
		});

		$app->get('/delete/(:id)', function ($id = null) 
		{
			// $app->applyHook('authentication');
			echo "admin > widget > delete ($id)";
		});
	});

	$app->group('/option', function () use ($app)
	{
		$app->get('/', function ()
		{
			// $app->applyHook('authentication');
			echo "admin > option";
		});

		$app->get('/add', function () 
		{
			// $app->applyHook('authentication');
			echo "admin > option > add";
		});

		$app->get('/delete/(:id)', function ($id = null) 
		{
			// $app->applyHook('authentication');
			echo "admin > option > delete ($id)";
		});

		$app->get('/update/(:id)', function ($id = null) 
		{
			// $app->applyHook('authentication');
			echo "admin > option > update ($id)";
		});
	});

	$app->group('/user', function () use ($app)
	{
		$app->get('/', function ()
		{
			// $app->applyHook('authentication');
			echo "admin > user";
		});

		$app->get('/add', function () 
		{
			// $app->applyHook('authentication');
			echo "admin > user > add";
		});

		$app->get('/delete/(:id)', function ($id = null) 
		{
			// $app->applyHook('authentication');
			echo "admin > user > delete ($id)";
		});

		$app->get('/update/(:id)', function ($id = null) 
		{
			// $app->applyHook('authentication');
			echo "admin > user > update ($id)";
		});
	});
});

// Show the wallboard
$app->get('/', function () {
    echo "Main walllboard page";
});

$app->notFound(function () use ($app) {
    $app->render('404.html');
});

$app->run();
