<?php

namespace App\Controllers;

use App\Models\User;
use App\UUID;
use Respect\Validation\Validator as v;
use App\Modules\Module;

class UserController extends Controller
{

    public function getRegistryView($req, $res)
    {
        $params = $req->getParams();

        $moduleTwig = new Module( $this->container );

        return $this->view->render($res, 'app.twig',
            [   'title' => 'Registrieren',
                'modules' => [
                    $moduleTwig->getRenderedTwig( 'modules/form/registry.json',
                        [   'userRegistry' => [
                                'email' => 'emre.akguel.1@gmail.com', //$params['email'],
                                'name' => 'Akgül', //$params['name'],
                                'vorname' => 'Emre' //$params['vorname']
                            ]
                        ], true)
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
            $errors = $validation->getErrors();

            $moduleTwig = new Module( $this->container );

            $res->withStatus(400);
            return $this->view->render($res, 'app.twig',
                [   'title' => 'Registrierung fehlgeschlagen',
                    'modules' => [
                        $moduleTwig->getRenderedTwig( 'modules/form/registry.json',
                            [   'errors' => $errors,
                                'userRegistry' => [
                                    'email' => $params['email'],
                                    'name' => $params['name'],
                                    'vorname' => $params['vorname']
                                ]
                            ], true)
                    ]
                ]
            );
        }

        $user = User::create([
            "_id" => UUID::v4(),
            "_name" => $params['name'],
            "_vorname" => $params['vorname'],
            "_email" => $params['email'],
            "_password" => password_hash( $params['password'], PASSWORD_DEFAULT),
            "_token" => UUID::v4()
        ]);


        return $res->withRedirect( $this->router->pathFor( 'home' ));
        /* if ($user) {

           /* macht $user objClass zu json
             $user = json_decode(json_encode($user), true);

             unset($user['_password']);
             unset($user['_password_code']);
             unset($user['_password_code_time']);
             unset($user['deleted_at']);

             return $res->withJson($user, 201);


         }*/
    }

}
