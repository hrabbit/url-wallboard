<?php


require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$base_config = array(
	'title' => 'My Wallboard',
	'users' => array(
		'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
	),
);

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/../app.db',
    ),
));

// If we don't actually have tables and data then we need to create the base tables
$app['db']->exec('CREATE TABLE IF NOT EXISTS users( id INTEGER PRIMARY KEY AUTOINCREMENT, user VARCHAR(30) UNIQUE, role VARCHAR(30), password VARCHAR(255))');
$app['db']->exec('INSERT OR IGNORE INTO users (user,role,password) VALUES ("admin", "ROLE_ADMIN", "5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==")');
$app['db']->exec('CREATE TABLE IF NOT EXISTS options( id INTEGER PRIMARY KEY AUTOINCREMENT, key VARCHAR(30) UNIQUE, value VARCHAR(255))');
$app['db']->exec('INSERT OR IGNORE INTO options (key,value) VALUES ("title", "My wallboard")');
$app['db']->exec('CREATE TABLE IF NOT EXISTS widgets( id INTEGER PRIMARY KEY AUTOINCREMENT, url VARCHAR(30) UNIQUE)');

$getConfig = function() use ($app) {
	$options = array();
	foreach($app['db']->fetchAll('SELECT * FROM options') as $option)
		$options[$option['key']] = $option['value'];
	return $options;
	// $option = $app['db']->fetchAssoc('SELECT value FROM options WHERE key = ?', array($option));
	// var_dump($option);
	// exit;
};

$app['config'] = $getConfig();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$getUsers = function() use ($app) {
	$users = array();
	foreach($app['db']->fetchAll('SELECT * FROM users') as $user)
		$users[$user['user']] = array($user['role'], $user['password']);

	return $users;
};


$app->register(new Silex\Provider\SecurityServiceProvider(), array(
	'security.firewalls' => array(
		// 'login' => array(
		// 	'pattern' => '^/admin/login$',
		// ),
		'admin' => array(
			'pattern' => '^/admin',
			// 'logout' => array('logout_path' => '/admin/logout'),
			'http' => true,
			// 'form' => array('login_path' => '/admin/login', 'check_path' => '/admin/login_check'),
			'users' => $app->share(function () use ($app) {
    				return new UserProvider($app['db']);
			}),
			'users' => $getUsers(),
		),
	),
));

// Access the default (and only) route which shows the board
// $app->get('/', function () use ($app) {
//     return 'Wallboard content here';
// });

$app->mount('/admin', new Hpbx\AdminControllerProvider());
$app->mount('/', new Hpbx\RootControllerProvider());

$app->run();
