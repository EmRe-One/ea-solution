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
        $this->container->twig->addGlobal('csrf_nameKey', $this->container->csrf->getTokenNameKey() );
        $this->container->twig->addGlobal('csrf_name', $this->container->csrf->getTokenName() );
        $this->container->twig->addGlobal('csrf_valueKey', $this->container->csrf->getTokenValueKey() );
        $this->container->twig->addGlobal('csrf_value', $this->container->csrf->getTokenValue() );

        $res = $next($req, $res);
        return $res;
    }

}
