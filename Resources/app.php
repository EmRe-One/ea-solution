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
            'database' => 'd025c831',
            'username' => 'd025c831',
            'password' => 'JuYgTqmPfc5awWNY',
            'charset' => 'utf8',
            'collation' => 'utf8_bin'
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

$container['db'] = function ($container) use ($capsule) {
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

$container['twig'] = function ($container) {
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
    $twig = new Twig_Environment($loader, []);

    return $twig;
};

$container['validator'] = function ($container) {
    return new \App\Validation\Validator;
};

/*===========================================================*
 *              Registry the Controller                      *
 *===========================================================*/
$container['AuthController'] = function ($container) {
    return new \App\Controllers\Auth\AuthController($container);
};

$container['HomeController'] = function ($container) {
    return new \App\Controllers\HomeController($container);
};

$container['UserController'] = function ($container) {
    return new App\Controllers\UserController($container);
};

$container['UserAdressController'] = function ($container) {
    return new App\Controllers\UserAdressController($container);
};

$container['csrf'] = function ($container) {
    $guard = new \Slim\Csrf\Guard();
    /*$guard->setFailureCallable(function ($req, $res, $next) {
        // $req = $req->withAttribute("csrf_status", false);
        $res->write('errooooor');
        return $next($req, $res);
    });*/
    return $guard;
};

/*===========================================================*
 *               Registry the Middleware                     *
 *===========================================================*/
$app->add(new \App\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);

/*===========================================================*
 *                  Registry the Auth                        *
 *===========================================================*/
$container['auth'] = function ($container) {
    return new \App\Auth\Auth;
};

//Path for the Rules and Exceptions from 'custom Validations'
Validator::with('App\\Validation\\Rules\\');

/*===========================================================*
 *                  Not Found Handler                        *
 *===========================================================*/
$container['notFoundHandler'] = function ($container) {
    return function ($req, $res) use ($container) {
        $res->withStatus(404)
            ->withHeader('Content-Type', 'text/html');
        return $container->view->render($res, 'app.twig',
            [   'title' => 'Nicht gefunden',
                'modules' => ['404.twig']
            ]);
    };
};

/*===========================================================*
 *                  Not Allowed Handler                      *
 *===========================================================*/
$container['notAllowedHandler'] = function ($container) {
    return function ($req, $res, $methods) use ($container) {
        $res->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-Type', 'text/html');
        return $container->view->render($res, 'app.twig',
            [   'title' => 'Kein Zutritt',
                'modules' => ['405.twig']
            ]);
    };
};

/*===========================================================*
 *             PHP Runtime Error Handler                     *
 *===========================================================*/
$container['phpErrorHandler'] = function ($container) {
    return function ($req, $res, $error) use ($container) {
        $res->withStatus(500)
            ->withHeader('Content-Type', 'text/html');

        return $container->view->render($res, 'app.twig',
            [   'title' => 'PHP Runtime Error',
                'error' => $error,
                'modules' => ['500.twig']
            ]);
    };
};

//Routes
require __DIR__ . '/../App/Routes/routes.php';
//require __DIR__ . '/../App/Routes/v1_api_users.php';
