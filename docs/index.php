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

$app->hook('authentication', function () use ($app) 
{
	$app->response->headers->set('WWW-Authenticate', 'Basic realm="My Realm"');
	$app->response->setStatus(401);

	var_dump($app->request->headers);
	echo 'Text to send if user hits Cancel button';
});

$app->group('/admin', function () use ($app) 
{

	$app->get('/', function () use ($app)
	{
		$app->applyHook('authentication');
		echo "admin";
	});

	$app->group('/widget', function () use ($app)
	{
		$app->get('/', function ()
		{
			$app->applyHook('authentication');
			echo "admin > widget";
		});

		$app->get('/add', function () 
		{
			$app->applyHook('authentication');
			echo "admin > widget > add";
		});

		$app->get('/delete/(:id)', function ($id = null) 
		{
			$app->applyHook('authentication');
			echo "admin > widget > delete ($id)";
		});
	});

	$app->group('/option', function () use ($app)
	{
		$app->get('/', function ()
		{
			$app->applyHook('authentication');
			echo "admin > option";
		});

		$app->get('/add', function () 
		{
			$app->applyHook('authentication');
			echo "admin > option > add";
		});

		$app->get('/delete/(:id)', function ($id = null) 
		{
			$app->applyHook('authentication');
			echo "admin > option > delete ($id)";
		});

		$app->get('/update/(:id)', function ($id = null) 
		{
			$app->applyHook('authentication');
			echo "admin > option > update ($id)";
		});
	});

	$app->group('/user', function () use ($app)
	{
		$app->get('/', function ()
		{
			$app->applyHook('authentication');
			echo "admin > user";
		});

		$app->get('/add', function () 
		{
			$app->applyHook('authentication');
			echo "admin > user > add";
		});

		$app->get('/delete/(:id)', function ($id = null) 
		{
			$app->applyHook('authentication');
			echo "admin > user > delete ($id)";
		});

		$app->get('/update/(:id)', function ($id = null) 
		{
			$app->applyHook('authentication');
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
