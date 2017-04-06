<?php

/**
 * Created by PhpStorm.
 * User: Emre Ak
 * Date: 26.03.2017
 * Time: 14:22
 */

namespace App\Modules;

class Module {

    protected $basedir;
    protected $container;

    public function __construct($container)
    {
        $this->basedir = __DIR__ . '/../../data/';
        $this->container = $container;
    }

    public function __get($name)
    {
        if (isset($this->container->{$name})) {
            return $this->container->{$name};
        }
    }

    public function getRenderedTwig($module_path, $options = [])
    {
        $str = file_get_contents($this->basedir . $module_path);

        $json_array = json_decode($str, true);

        foreach ($options as $key => $value) {
            $json_array[$key] = $value;
        }

        $json_array[ 'base_url' ] = 'http://'. $_SERVER['HTTP_HOST'];

        $template = $this->twig->load($json_array['resourceType'] . '.twig');

        return $template->render($json_array);
    }

}

?>