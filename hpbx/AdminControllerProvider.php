<?php

namespace Hpbx;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        // Show a menu
        $controllers->get('/', function (Application $app) 
        {
             return $app['twig']->render('admin/index.html', array(
                'config' => $app['config'],
                // 'name' => $name,
            ));
        });

        // Add a widget
        $controllers->get('/addWidget', function (Application $app) 
        {

        });
        // Delete a widget

        // General config

        return $controllers;
    }
}