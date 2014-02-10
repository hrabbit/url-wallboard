<?php

if(!file_exists(__DIR__.'/../vendor/autoload.php'))
	no_installation();

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
	$widgets = array();
	foreach(\QB::table('widgets')->get() as $db_widget_key => $db_widget_value)
		$widgets[$db_widget_key] = \Hpbx\Helper::getWidget(trim($db_widget_value->url));

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

function no_installation()
{
	echo <<<EOF
<html>
<body>
<h1>Error</h1>
<p>It appears that you haven't installed the required dependancies. Please follow the instructions below.</p>
<p>Inside the root directory of this package, run the following commands;</p>
<pre><code>curl -sS https://getcomposer.org/installer | php
php composer.phar update</code></pre>
<p>This will ensure all dependancies are installed correctly.</p>
</body>
</html>
EOF;
}
