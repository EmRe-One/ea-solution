<?php

namespace App\Controllers;

use App\Modules\Includer;
use App\Modules\Module;

class HomeController extends Controller {

    public function index($req, $res){
        $e = (new Includer($this->container))->include('page/index.json');

        return $res->write($e);
    }

    public function getDocuPage($req, $res) {
        $e = (new Includer($this->container))->include('page/docu.json');

        return $res->write($e);
    }


    public function getApi($req, $res){
        $swagger = \Swagger\scan( __DIR__ . '\..\..\App');
        header('Content-Type: application/json');

        return $res->withJson($swagger, 200);
    }

}
?>
