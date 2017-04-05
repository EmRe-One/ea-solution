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
        $e = (new Includer($this->container))->include('page/login.json');

        return $res->write($e);
    }

    public function postLogin($req, $res)
    {
        $params = $req->getParams();

        $auth = $this->auth->attempt($params['email'], $params['password']);

        if( !$auth ){
            return $res->withRedirect($this->router->pathFor('auth.login'));
        }

        return $res->withRedirect($this->router->pathFor('home'));

        /*$params['email'] = trim( strtolower( $params['email'] ) );

        $validation = $this->container->validator->validate($params, [
            'email' => v::notEmpty()->email()->emailExists(),
            'password' => v::notEmpty()
        ]);

        if ($validation->failed()) {

            $moduleTwig = new Module( $this->container );

            return $this->view->render($res, 'app.twig',
                [   'title' => 'Login fehlgeschlagen',
                    'modules' => [
                        $moduleTwig->getRenderedTwig( 'modules/form/login.json', [])
                    ]
                ]
            );
        }

        $user = User::where([
            '_email' => $params['email'],
            '_password' => password_hash( $params['password'], PASSWORD_DEFAULT)
        ])->first();

        if ($user) {

            $user->_token = UUID::v4();
            $user->save();


            $user = json_decode(json_encode($user), true);

            unset($user['_password']);
            unset($user['_password_code']);
            unset($user['_password_code_time']);
            unset($user['deleted_at']);

            return $res->withRedirect($this->router->pathFor('home'));

        } else {
            $moduleTwig = new Module( $this->container );

            return $this->view->render($res, 'app.twig',
                [   'title' => 'Login fehlgeschlagen',
                    'modules' => [
                        $moduleTwig->getRenderedTwig( 'modules/form/login.json',
                            [   'userLogin' => [
                                    'email' => $params['email']
                                ]
                            ])
                    ]
                ]
            );
        }*/


    }

    public function getRegistryView($req, $res)
    {
        $params = $req->getParams();

        $moduleTwig = new Module( $this->container );

        return $this->view->render($res, 'app.twig',
            [   'title' => 'Registrieren',
                'nav' => $moduleTwig->getRenderedTwig('modules/nav/nav.json'),
                'modules' => [
                    $moduleTwig->getRenderedTwig( 'modules/form/registry.json')
                ]
            ]
        );
    }

    public function postRegistry($req, $res)
    {
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

    public function login_api($req, $res)
    {
        $body = $req->getParsedBody();
        $body['email'] = strtolower($body['email']);

        $validation = $this->container->validator->validate($body, [
            'email' => v::notEmpty()->email()->emailExists(),
            'password' => v::notEmpty()
        ]);

        if ($validation->failed()) {
            $errors = $validation->getErrors();
            $errors["code"] = 400;

            return $res->withJson( $errors , 400);
        }

        $user = User::where([
            '_email' => $body['email'],
            '_password' => sha1($body['password'])
        ])->first();

        if ($user) {

            $user->_token = UUID::v4();
            $user->save();

            $user = json_decode(json_encode($user), true);

            unset($user['_password']);
            unset($user['_password_code']);
            unset($user['_password_code_time']);
            unset($user['deleted_at']);

            return $res->withJson($user, 200);
        } else {
            return $res->withJson(array("code" => "401", "message" => "Login failed"), 401);
        }
    }

}

?>