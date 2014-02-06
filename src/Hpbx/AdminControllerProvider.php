<?php 
namespace Hpbx;

use Silex\Application;
use Silex\ControllerProviderInterface;

class AdminControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {
            return "Admin root"; // $app->redirect('/hello');
        });

        $controllers->get('/option', function (Application $app) {
            return "Admin option > get"; // $app->redirect('/hello');
        });

        $controllers->post('/option', function (Application $app) {
            return "Admin option > post"; // $app->redirect('/hello');
        });

        $controllers->put('/option', function (Application $app) {
            return "Admin option > put"; // $app->redirect('/hello');
        });

        $controllers->delete('/option', function (Application $app) {
            return "Admin option > delete"; // $app->redirect('/hello');
        });

        return $controllers;
    }
}

