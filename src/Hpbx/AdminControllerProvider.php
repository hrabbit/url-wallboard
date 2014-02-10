<?php 
namespace Hpbx;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Allow the use of PUT and DELETE
Request::enableHttpMethodParameterOverride();

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
          return $app['twig']->render('admin/widget.html.twig', array(
             'widgets' => \QB::table('widgets')->get(),
             ));
      });

        $controllers->post('/widget', function (Application $app, Request $request)
        {
          \QB::query(
             'INSERT INTO widgets (url) VALUES (?)', 
             array($request->get('url'))
             );
          return $app->redirect('/admin/widget');
      });
        
        $controllers->delete('/widget/{id}', function (Application $app, Request $request, $id)
        {
          \QB::query('DELETE FROM widgets WHERE id = ? LIMIT 1', array($id));
          return $app->redirect('/admin/widget');
      });
        
        $controllers->get('/option', function (Application $app) {
            return $app['twig']->render('admin/option.html.twig', array(
            	'options' => \QB::table('options')->get(),
                ));
        });

        $controllers->post('/option', function (Application $app, Request $request) {
            \QB::query(
                'INSERT INTO options (key,value) VALUES (?, ?)', 
                array($request->get('key'), $request->get('value'))
                );
            return $app->redirect('/admin/option');
        });

        $controllers->put('/option/{id}', function (Application $app, Request $request, $id) {
            \QB::query(
                'UPDATE options SET value = ? WHERE id = ? LIMIT 1', 
                array($request->get('value'), $id)
                );
            return $app->redirect('/admin/option');
        });

        $controllers->delete('/option/{id}', function (Application $app, $id) {
            \QB::query('DELETE FROM options WHERE id = ? LIMIT 1', array($id));
            return $app->redirect('/admin/option');

        });

        return $controllers;
    }
}

