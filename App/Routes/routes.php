<?php

$app->get('/api', 'HomeController:getApi')->setName('api');
$app->get('/docs', 'HomeController:getDocsPage')->setName('docs');


$app->group('', function (){

    $this->get('/registry', 'AuthController:getRegistryView')->setName('auth.registry');
    $this->post('/registry', 'AuthController:postRegistry');

    $this->get('/login', 'AuthController:getLoginView')->setName('auth.login');
    $this->post('/login', 'AuthController:postLogin');

    $this->get('/logout', 'AuthController:getLogout')->setName('auth.logout');
});


