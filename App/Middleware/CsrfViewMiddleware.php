<?php
/**
 * Created by PhpStorm.
 * User: Emre Ak
 * Date: 29.11.2016
 * Time: 03:55
 */

namespace App\Middleware;


class CsrfViewMiddleware extends Middleware
{

    public function __invoke($req, $res, $next)
    {
        // input in the View with {{ csrf.field | raw }}
        $this->container->view->getEnvironment()->addGlobal('csrf', [
           'field' => '
                <input type="hidden" name="'.$this->container->csrf->getTokenNameKey() .'" 
                    value="'. $this->container->csrf->getTokenName() .'">
                <input type="hidden" name="'. $this->container->csrf->getTokenValueKey() .'"
                    value="'. $this->container->csrf->getTokenValue() .'"> '
        ]);

        $res = $next($req, $res);
        return $res;
    }

}
