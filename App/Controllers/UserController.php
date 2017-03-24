<?php

namespace App\Controllers;

use App\Models\User;
use App\UUID;
use Respect\Validation\Validator as v;


class UserController extends Controller
{

    public function getRegistryView($req, $res)
    {
        return $this->view->render($res, 'registry.twig');
    }

    public function postRegistry($req, $res)
    {

    }


    /**
     * @SWG\Post(
     *     path="/api/v1/users/registry",
     *     operationId="addUser",
     *     description="Creates a new User in the Database.  Duplicates by email are not allowed",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="user",
     *         in="body",
     *         description="User to add in DB",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/userModel"),
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Create a User successfully",
     *         @SWG\Schema(ref="#/definitions/userModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Validation error",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     )
     * )
     */
    public function registry_api($req, $res)
    {
        $body = $req->getParsedBody();
        $body['email'] = strtolower($body['email']);

        $validation = $this->container->validator->validate($body, [
            'name' => v::notEmpty()->alpha(),
            'vorname' => v::notEmpty()->alpha(),
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'password' => v::noWhitespace()->notEmpty()
        ]);

        if ($validation->failed()) {
            $errors = $validation->getErrors();
            $errors["code"] = 400;

            return $res->withJson( $errors , 400);
        }

        $user = User::create([
            "_id" => UUID::v4(),
            "_name" => $body['name'],
            "_vorname" => $body['vorname'],
            "_email" => $body['email'],
            "_password" => sha1($body['password']),
            "_token" => UUID::v4()
        ]);

        if ($user) {

            // macht $user objClass zu json
            $user = json_decode(json_encode($user), true);

            unset($user['_password']);
            unset($user['_password_code']);
            unset($user['_password_code_time']);
            unset($user['deleted_at']);

            return $res->withJson($user, 201);

        }
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/users/{token}/{id}",
     *     description="Returns a user based on a single ID",
     *     operationId="getUserById",
     *     @SWG\Parameter(
     *         description="ID of user to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="token of user because of Auth",
     *         in="path",
     *         name="token",
     *         required=true,
     *         type="string"
     *     ),
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="user response",
     *         @SWG\Schema(ref="#/definitions/userModel")
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Auth failed",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="User not found",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     */
    public function getUser_api($req, $res, $args)
    {

        // from middleware AuthMiddlewareByIdAndToken
        $user = $req->getAttribute('user');


        unset($user['_password']);
        unset($user['_password_code']);
        unset($user['_password_code_time']);
        unset($user['deleted_at']);

        return $res->withJson($user, 200);
    }


}
