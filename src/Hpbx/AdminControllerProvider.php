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

        $controllers->get('/', function (Application $app) {
            return $app->handle(Request::create('/admin/widget')); 
        });

        $controllers->get('/widget', function (Application $app)
        {
            // echo __DIR__; exit;
            return $app['twig']->render('../../admin/hello.twig', array(
                'name' => $name,
            ));
            // $app['db']->fetchAll('widget')->get();
            return ' in widget get';
        });

        $controllers->post('/widget', function (Application $app)
        {

        });
        
        $controllers->delete('/widget', function (Application $app)
        {

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

