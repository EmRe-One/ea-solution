<?php

namespace App\Controllers;

use App\Modules\Module;

class HomeController extends Controller {

    public function index($req, $res){

        $moduleTwig = new Module($this->container);

        return $this->view->render($res, 'app.twig',
            [   'title' => 'Home',
                'modules' => [
                    $moduleTwig->getRenderedTwig('modules/header/header_main.json'),
                    $moduleTwig->getRenderedTwig('modules/slider/slider.json')
                ]
            ]);
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
