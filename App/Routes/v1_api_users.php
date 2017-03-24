<?php

use App\Middleware\AuthMiddlewareByIdAndToken;


$app->post('/api/v1/users/login', 'AuthController:login_api');
$app->post('/api/v1/users/registry', 'UserController:registry_api');


$app->group('/api/v1/users/{token}/{id}', function () {

    $this->get('', 'UserController:getUser_api');

    $this->get('/adress', 'UserAdressController:getUserAdress_api');
    $this->post('/adress', 'UserAdressController:postUserAdress_api');
    $this->put('/adress', 'UserAdressController:putUserAdress_api');

})->add(new AuthMiddlewareByIdAndToken($container));
