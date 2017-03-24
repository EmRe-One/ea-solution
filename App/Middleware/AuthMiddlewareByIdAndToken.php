<?php

namespace App\Middleware;

use App\Models\User;

class AuthMiddlewareByIdAndToken extends Middleware
{

    public function __invoke($req, $res, $next)
    {
        $route = $req->getAttribute('route');
        $userId = $route->getArgument('id');
        $token = $route->getArgument('token');

        $user = User::find($userId);

        if(!$user){
            return $res->withJson(array("code" => "404", "message" => "User Id not found."), 404);
        }

        // fehler falls {id} und {token} nicht passen
        $user = User::where(['_id' => $userId, '_token' => $token])->first();

        if(!$user){
            return $res->withJson(array("code" => "401", "message" => "Auth failed"), 401);
        }

        $req = $req->withAttribute('user', $user);
        $res = $next($req, $res);
        return $res;
    }
}
