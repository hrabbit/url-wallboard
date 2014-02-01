<?php

namespace Hpbx;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\FormServiceProvider;

class AdminControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app->register(new FormServiceProvider());
        $app->register(new \Silex\Provider\TranslationServiceProvider(), array(
            'translator.messages' => array(),
        ));

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
        // $controllers->get('/addWidget', function (Application $app) 
        $controllers->match('/addWidget', function (Request $request) use ($app)
        {
            $data = array(
                'url' => 'http://url.net.au/',
            );

            $form = $app['form.factory']->createBuilder('form', $data)
                ->add('url')
                ->getForm();

            $form->handleRequest($request);

            if ($form->isValid()) 
            {
                $data = $form->getData();
                var_dump($data); exit;
                // $app['db']->exec('INSERT INTO widgets')
                // Add entry to database
                return $app->redirect('/admin');
            }

            return $app['twig']->render('admin/addWidget.html', array(
                'config' => $app['config'],
                'form' => $form->createView()
            ));
        });
        // Delete a widget

        // General config

        return $controllers;
    }
}