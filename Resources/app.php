<?php

use Respect\Validation\Validator;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'dd24002.kasserver.com',
            'database' => 'd024274b',
            'username' => 'd024274b',
            'password' => 'Wmn8xp3BTaskubh5',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ]
    ]
]);

$container = $app->getContainer();

/*===========================================================*
 *         Registry the Database and Validator               *
 *===========================================================*/
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule){
    return $capsule;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/views', [
        'cache' => false
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

$container['validator'] = function ($container){
    return new \App\Validation\Validator;
};


/*===========================================================*
 *              Registry the Controller                      *
 *===========================================================*/
$container['AuthController'] = function($container){
    return new \App\Controllers\Auth\AuthController($container);
};

$container['HomeController'] = function ($container){
    return new \App\Controllers\HomeController($container);
};

$container['UserController'] = function ($container){
    return new App\Controllers\UserController($container);
};

$container['UserAdressController'] = function ($container){
    return new App\Controllers\UserAdressController($container);
};

$container['csrf'] = function ($container){
    return new \Slim\Csrf\Guard;
};


/*===========================================================*
 *               Registry the Middleware                     *
 *===========================================================*/
//$app->add(new \App\Middleware\CsrfViewMiddleware($container));


/*===========================================================*
 *                  Registry the Auth                        *
 *===========================================================*/
$container['auth'] = function ($container){
    return new \App\Auth\Auth;
};

//Path for the Rules and Exceptions from 'custom Validations'
Validator::with('App\\Validation\\Rules\\');

//Routes
require __DIR__ . '/../App/Routes/routes.php';
require __DIR__ . '/../App/Routes/v1_api_users.php';

