<?php

namespace Hpbx;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class RootControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        // Show a menu
        $controllers->get('/', function (Application $app) 
        {
             return $app['twig']->render('home/index.html', array(
                'config' => $app['config'],
            ));
        });

        return $controllers;
    }
}