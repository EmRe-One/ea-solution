<?php

namespace App\Controllers;



class HomeController extends Controller {

    public function index($req, $res){

        return $this->view->render($res, 'startseite.twig');

    }

    public function indexMobil($req, $res){
        return $this->view->render($res, 'startseiteMobil.twig');
    }

    /**
     *  @SWG\Swagger(
     *      @SWG\Info(
     *          version="1.0.0",
     *          title="Libanon Express Delivery",
     *          description="The Full API-Docu created with SWG v2.0"),
     *      ),
     *      basePath="/api",
     *      host="libanonexpressdelivery.ea-solution.de",
     *      schemes={"http"},
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      @SWG\Definition(
     *          definition="errorModel",
     *          required={"error"},
     *          @SWG\Property(
     *              property="error",
     *              type="array",
     *              @SWG\items(ref="#/definitions/error")
     *          )
     *      ),
     *      @SWG\Definition(
     *          definition="error",
     *          required={"code", "message"},
     *          @SWG\Property(
     *              property="code",
     *              type="integer",
     *              format="int32"
     *          ),
     *          @SWG\Property(
     *              property="message",
     *              type="string"
     *          )
     *      )
     *  )
     *
     * @SWG\Get(
     *     path="/api",
     *     description="Returns the Api in json",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="api docu"
     *     )
     * )
     */
    public function getApi($req, $res){

        $swagger = \Swagger\scan( __DIR__ . '\..\..\App');
        header('Content-Type: application/json');

        return $res->withJson($swagger, 200);
    }

}

?>