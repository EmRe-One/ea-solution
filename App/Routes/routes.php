<?php


$app->get('/api', 'HomeController:getApi')->setName('api');

$app->group('', function (){

    $this->get('/registry', 'UserController:getRegistryView')->setName('user.registry');
    $this->post('/registry', 'UserController:postRegister');

    $this->get('/login', 'AuthController:getLoginView')->setName('user.login');
    $this->post('/login', 'AuthController:postLogin');

})->add($container->csrf);


