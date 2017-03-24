<?php
/**
 * Created by PhpStorm.
 * User: Emre Ak
 * Date: 26.11.2016
 * Time: 17:18
 */

namespace App\Controllers;

use App\Models\User;
use App\Models\UserAdress;
use App\UUID;

class UserAdressController{


    /**
     * @SWG\Get(
     *     path="/api/v1/users/{token}/{id}/adress",
     *     description="Returns the adress based on a user ID",
     *     operationId="getAdressByUserId",
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
     *         description="Adress of user response",
     *         @SWG\Schema(ref="#/definitions/userAdressModel")
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Wrong token",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="User not found",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     */
    public function getUserAdress_api($req, $res, $arsg){
        $user = $req->getAttribute('user');

        $adress = UserAdress::where('_user_id', $user['_id'])->first();

        if(!$adress){
            $adress = UserAdress::create([
                '_adress_id' => UUID::v4(),
                '_user_id' => $user['_id']
            ]);

            $adress['status'] = "created";
            return $res->withJson($adress, 201);
        }

        return $res->withJson($adress, 200);
    }

    /**
     * @SWT\Post(
     *
     * )
     */
    public function postUserAdress_api($req, $res, $args){
        $body = $req->getParsedBody();

        if($body){
            $adress = UserAdress::where('_user_id', $args['id'])->first();

            if(!$adress){
                $adress = UserAdress::create([
                    '_adress_id' => UUID::v4(),
                    '_user_id' => $args['id']
                ]);
            }

            unset($body['adress_id'], $body['_adress_id'], $body['user_id'], $body['_user_id']);


            $adress->update($body);
            $adress->save();

            return $res->withJson($adress, 200);
        }else{
            return $res->withJson(array("status"=>"400", "message"=>"Empty Body"), 400);
        }

    }

    /*
     * @SWT\Put(
     *
     * )
     *
    public function putUserAdress_api($req, $res, $args){
        $body = $req->getParsedBody();

        if($body && isset($body['token'])){

            $adress = $this->db->table('tbl_adress')->where('_user_id', $args['id'])->get()->first();
            $adress = json_decode(json_encode($adress), true);

            if($adress && $adress['_token'] == $body['token']){
                return $res
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($adress, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            }else{
                return $res
                    ->withStatus(401)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode(array("status"=>"401", "message"=>"Unauthorized"),
                        JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            }
        }else{
            return $res
                ->withStatus(400)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode(array("status"=>"400", "message"=>"Empty Body"),
                    JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    }*/


}

?>