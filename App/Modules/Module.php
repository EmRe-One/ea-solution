<?php

/**
 * Created by PhpStorm.
 * User: Emre Ak
 * Date: 26.03.2017
 * Time: 14:22
 */

namespace App\Modules;

class Module
{

    protected $basedir;
    protected $container;

    public function __construct($container)
    {
        $this->basedir = __DIR__ . '/../../Data/';
        $this->container = $container;
    }

    public function __get($name)
    {
        if (isset($this->container->{$name})) {
            return $this->container->{$name};
        }
    }

    public function getRenderedTwig($module_path, $options = [], $csrf = false)
    {
        $str = file_get_contents($this->basedir . $module_path);

        $json_array = json_decode($str, true);

        foreach ($options as $key => $value) {
            $json_array[$key] = $value;
        }

        $json_array[ 'base_url' ] = 'http://'. $_SERVER['HTTP_HOST'];

        if ($csrf) {
            $nameKey = $this->csrf->getTokenNameKey();
            $valueKey = $this->csrf->getTokenValueKey();
            $nameValue = $this->csrf->getTokenName();
            $valueValue = $this->csrf->getTokenValue();

            $json_array['csrf_nameKey'] = $nameKey;
            $json_array['csrf_valueKey'] = $valueKey;
            $json_array['csrf_name'] = $nameValue;
            $json_array['csrf_value'] = $valueValue;
        }

        $template = $this->twig->load($json_array['resourceType'] . '.twig');

        return $template->render($json_array);
    }
}

?>