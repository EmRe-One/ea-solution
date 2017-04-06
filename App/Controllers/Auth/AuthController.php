<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\UUID;
use Respect\Validation\Validator as v;
use App\Modules\Includer;
use App\Models\User;

class AuthController extends Controller
{
    public function getLogout($req, $res) {

        $this->auth->logout();

        return $res->withRedirect($this->router->pathFor('home'));
    }

    public function getLoginView($req, $res) {

        $e = (new Includer($this->container))->include('page/login_page.json');

        return $res->write($e);
    }

    public function postLogin($req, $res) {

        $params = $req->getParams();

        $auth = $this->auth->attempt($params['email'], $params['password']);

        if( !$auth ){
            return $res->withRedirect($this->router->pathFor('auth.login'));
        }

        return $res->withRedirect($this->router->pathFor('home'));

    }

    public function getRegistryView($req, $res) {

        $e = (new Includer($this->container))->include('page/registry_page.json');

        return $res->write($e);
    }

    public function postRegistry($req, $res) {

        $params = $req->getParams();

        $params['email'] = trim( strtolower( $params['email'] ) );

        $validation = $this->container->validator->validate($params, [
            'name' => v::notEmpty()->alpha('äöüß-'),
            'vorname' => v::notEmpty()->alpha('äöüß-'),
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'password' => v::noWhitespace()->notEmpty()->equals($params['repeat_password'])
        ]);

        if ( $validation->failed() ) {

            return $res->withRedirect( $this->router->pathFor('auth.registry'));
        }

        $user = User::create([
            "_id" => UUID::v4(),
            "_name" => $params['name'],
            "_vorname" => $params['vorname'],
            "_email" => $params['email'],
            "_password" => password_hash( $params['password'], PASSWORD_DEFAULT),
            "_token" => UUID::v4()
        ]);

        $_SESSION['user'] = $user['_id'];

        return $res->withRedirect( $this->router->pathFor( 'home' ));
    }

}

?>