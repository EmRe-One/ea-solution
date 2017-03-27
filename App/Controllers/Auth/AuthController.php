<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use App\UUID;
use Respect\Validation\Validator as v;
use App\Modules\Module;

class AuthController extends Controller
{

    public function getLoginView($req, $res) {

        $moduleTwig = new Module( $this->container );

        return $this->view->render($res, 'app.twig',
            [   'title' => 'Login',
                'modules' => [
                    $moduleTwig->getRenderedTwig( 'modules/form/login.json', [], true)
                ]
            ]
        );
    }

    public function postLogin($req, $res)
    {
        $params = $req->getParams();

        $params['email'] = trim( strtolower( $params['email'] ) );

        $validation = $this->container->validator->validate($params, [
            'email' => v::notEmpty()->email()->emailExists(),
            'password' => v::notEmpty()
        ]);

        if ($validation->failed()) {
            $errors = $validation->getErrors();

            $moduleTwig = new Module( $this->container );
            $nameKey = $this->csrf->getTokenNameKey();
            $valueKey = $this->csrf->getTokenValueKey();

            return $this->view->render($res, 'app.twig',
                [   'title' => 'Login fehlgeschlagen',
                    'modules' => [
                        $moduleTwig->getRenderedTwig( 'modules/form/login.json',
                        [   'errors' => $errors,
                            'userLogin' => [
                                'email' => $params['email']
                            ]
                        ], true )
                    ]
                ]
            );
        }

        $user = User::where([
            '_email' => $params['email'],
            '_password' => sha1($params['password'])
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

        $this->view->getEnvironment()->setGlobal('user', [
            'email' => '$users.email@gmail.com',
            'name' => '$users.vorname $users.nachname'
        ]);
    }

    /**
     * @SWG\Post(
     *     path="/api/v1/users/login",
     *     description="Login the user, refresh the Token, and push 'Login':'Success' attribut"
     *     @SWG\Parameter(
     *         name="user",
     *         in="body",
     *         description="email and password to login",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/userLogin"),
     *     ),
     *     @SWG\Response(
     *          response="200",
     *          description="Login a user, if correct email and password",
     *          @SWG\Schema(ref="#/definitions/userModel")
     *     ),
     *     @SWG\Response(
     *          response="400",
     *          description="Verification failed or Bad Request or User not found",
     *          @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     *
     *     @SWG\Response(
     *          response="401",
     *          description="Login failed",
     *          @SWG\Schema(ref="#/definitions/errorModel")
     *     )
     * )
     *
     * @SWG\Definition(
     *     definition="userLogin",
     *     required={"email", "password"},
     *     @SWG\Property(
     *          property="email",
     *          type="string"
     *     ),
     *     @SWG\Property(
     *          property="password",
     *          type="string"
     *     )
     * )
     */
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