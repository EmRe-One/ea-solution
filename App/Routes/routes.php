<?php

$app->get('/api', 'HomeController:getApi')->setName('api');

$app->group('', function (){

    $this->get('/registry', 'UserController:getRegistryView')->setName('user.registry');
    $this->post('/registry', 'UserController:postRegistry');

    $this->get('/login', 'AuthController:getLoginView');
    $this->post('/login', 'AuthController:postLogin')->setName('auth.login');

});


