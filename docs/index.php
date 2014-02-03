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

require_once(__DIR__.'/../hpbx.php');
$hpbx = new Hpbx();

$query = QB::table('options');
foreach($query->get() as $configs)
	$config[$configs->key] = $configs->value;

// $app->add(new \Slim\Middleware\SessionCookie(array(
//     'expires' => '20 minutes',
//     'path' => '/admin',
//     'domain' => null,
//     'secure' => false,
//     'httponly' => false,
//     'name' => 'slim_session',
//     'secret' => '98kqwefgiuwoedklfv',
//     'cipher' => MCRYPT_RIJNDAEL_256,
//     'cipher_mode' => MCRYPT_MODE_CBC
// )));

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
		// $app->applyHook('authentication');
		$app->render('admin/widget.php', array('widgets' => QB::table('widgets')->get()));
	});

	$app->group('/widget', function () use ($app, $config)
	{
		$app->get('/', function () use ($app, $config)
		{
			// $app->applyHook('authentication');
			$app->render('admin/widget.php', array('widgets' => QB::table('widgets')->get()));
		});

		$app->post('/add', function () use ($app, $config)
		{
			// $app->applyHook('authentication');
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

	$app->group('/option', function () use ($app, $config)
	{
		$app->get('/', function () use ($app, $config)
		{
			// $app->applyHook('authentication');
			$app->render('admin/option.php', array('options' => QB::table('options')->get()));
		});

		$app->post('/add', function () use ($app, $config)
		{
			// $app->applyHook('authentication');
			QB::query(
				'INSERT INTO options (key, value) VALUES (?, ?)', 
				array($app->request->post('key'), $app->request->post('value'))
			);
			$app->flash('notice', 'Option added');
			$app->redirect('/admin/option');
		});

		$app->get('/delete/(:id)', function ($id = null) use ($app, $config)
		{
			// $app->applyHook('authentication');
			QB::query(
				'DELETE FROM options WHERE id = ? LIMIT 1', 
				array($id)
			);
			$app->flash('notice', 'Option deleted');
			$app->redirect('/admin/option');
		});

		$app->post('/update/(:id)', function ($id = null) use ($app, $config)
		{
			// $app->applyHook('authentication');
			QB::query(
				'UPDATE options SET value = ? WHERE id = ? LIMIT 1',
				array($app->request->post('value'), $id)
			);
			$app->flash('notice', 'Option updated');
			$app->redirect('/admin/option');
		});
	});

	// Allow adding extra pages to the rotation
	$app->group('/page', function() use ($app)
	{

	});

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
$app->get('/', function() use ($app, $config) {

	$widgets = array();
	foreach(QB::table('widgets')->get() as $widget_key => $widget_value)
	{
		$widgets[$widget_key] = json_decode(\Hpbx::getWidget($widget_value->url));
		$widgets[$widget_key]->title = !empty($widget_value->title) ? $widget_value->title : $widgets[$widget_key]->queue_name;
	}

	$app->render('index.php', array('layout' => false, 'config' => $config, 'widgets' => $widgets));
	if($records = QB::query('SELECT count(*) AS records FROM pages LIMIT 1')->first())
	{
		// $records->records;
	}

});

$app->get('/page/:id', function($id) use ($app, $config) {
	echo 'foo';
});

$app->notFound(function() use ($app, $config) {
    $app->render('404.html', array('layout' => false));
});

$app->run();
