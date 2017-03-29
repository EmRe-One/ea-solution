<?php

require 'Resources/app.php';

// 200 - Alles Ok
// 201 - Created

//

// 400 - Falscher Request bzw Bad request
// 401 - Unauthorisiert
// 403 - Verboten
// 404 - Nicht gefunden

$app->get('/', 'HomeController:index')->setName('home');

$app->run();
