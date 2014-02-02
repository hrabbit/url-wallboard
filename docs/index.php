<?php

// session_cache_limiter(false);
// session_start();

require '../vendor/autoload.php';

// Set the current mode
$app = new \Slim\Slim(array(
    'mode'				=> 'development',
    'view'				=> '\Slim\LayoutView',
    'templates.path'		=> '../templates',
    'layout'				=> 'admin/base.php',
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

QB::query('CREATE TABLE IF NOT EXISTS users( id INTEGER PRIMARY KEY AUTOINCREMENT, user VARCHAR(30) UNIQUE, role VARCHAR(30), password VARCHAR(255))');
QB::query('CREATE TABLE IF NOT EXISTS users( id INTEGER PRIMARY KEY AUTOINCREMENT, user VARCHAR(30) UNIQUE, role VARCHAR(30), password VARCHAR(255))');
QB::query('INSERT OR IGNORE INTO users (user,role,password) VALUES ("admin", "ROLE_ADMIN", "5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==")');
QB::query('CREATE TABLE IF NOT EXISTS options( id INTEGER PRIMARY KEY AUTOINCREMENT, key VARCHAR(30) UNIQUE, value VARCHAR(255))');
QB::query('INSERT OR IGNORE INTO options (key,value) VALUES ("title", "My wallboard")');
QB::query('CREATE TABLE IF NOT EXISTS widgets( id INTEGER PRIMARY KEY AUTOINCREMENT, title VARCHAR(30) UNIQUE, url VARCHAR(255) UNIQUE)');

$query = QB::table('options');
foreach($query->get() as $configs)
	$config[$configs->key] = $configs->value;

$app->add(new \Slim\Middleware\SessionCookie(array(
    'expires' => '20 minutes',
    'path' => '/admin',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name' => 'slim_session',
    'secret' => '98kqwefgiuwoedklfv',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));

// $app->add(new \Slim\Extras\Middleware\HttpBasicAuth('username2', 'password'));
function authenticate()
{
// 	$app = \Slim\Slim::getInstance();

// 	$auth = new \Slim\Extras\Middleware\HttpBasicAuth('username2', 'password');
// 	$app->add($auth);
// 	$auth->call();
// 	// echo '<pre>'; var_dump($app); exit;
}

// $app->hook('authentication', function () use ($app) 
// {
// 	echo 'hook';
// });

$app->group('/admin', 'authenticate', function () use ($app, $config) 
{
	$app->view->setData('config', $config);
	$app->get('/', function () use ($app, $config)
	{
		// $app->add(new \Slim\Extras\Middleware\HttpBasicAuth('username', 'password'));
		// $app->applyHook('authentication');
		// var_dump($config);
		$app->render('admin/widget/index.php', array('widgets' => QB::table('widgets')->get()));
	});

	$app->group('/widget', function () use ($app, $config)
	{
		$app->get('/', function () use ($app, $config)
		{
			// $app->applyHook('authentication');
			$app->render('admin/widget/index.php', array('widgets' => QB::table('widgets')->get()));
		});

		$app->post('/add', function () use ($app, $config)
		{
			// $app->applyHook('authentication');
			var_dump($app->request->post());
			QB::query(
				'INSERT INTO widgets (title,url) VALUES (?, ?)', 
				array($app->request->post('title'), $app->request->post('url'))
			);
			$app->flash('notice', 'Widget added');
			$app->redirect('/admin/widget');
		});

		$app->get('/delete/(:id)', function ($id = null) use ($app, $config)
		{
			// $app->applyHook('authentication');
			QB::query(
				'DELETE FROM widgets WHERE id = ? LIMIT 1', 
				array($id)
			);
			$app->flash('notice', 'Widget deleted');
			$app->redirect('/admin/widget');
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

	// Allow adding extra pages to the rotation
	// $app->group('/page', function() use ($app)
	// {

	// });

	// $app->group('/user', function () use ($app)
	// {
	// 	$app->get('/', function ()
	// 	{
	// 		// $app->applyHook('authentication');
	// 		echo "admin > user";
	// 	});

	// 	$app->get('/add', function () 
	// 	{
	// 		// $app->applyHook('authentication');
	// 		echo "admin > user > add";
	// 	});

	// 	$app->get('/delete/(:id)', function ($id = null) 
	// 	{
	// 		// $app->applyHook('authentication');
	// 		echo "admin > user > delete ($id)";
	// 	});

	// 	$app->get('/update/(:id)', function ($id = null) 
	// 	{
	// 		// $app->applyHook('authentication');
	// 		echo "admin > user > update ($id)";
	// 	});
	// });
});

// Show the wallboard
$app->get('/', function () use ($app, $config) {
	$app->render('index.php', array('page' => 'home', 'title' => 'Home', 'layout' => 'frontend.php'));
	// echo "Main walllboard page";
});

$app->notFound(function () use ($app, $config) {
    $app->render('404.html');
});

$app->run();
