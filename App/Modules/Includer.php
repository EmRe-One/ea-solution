<?php

namespace App\Modules;

class Includer extends \Twig_Extension {

    protected $basedir;
    protected $container;

    public function __construct($container)
    {
        $this->basedir = __DIR__ . '/../../Data/';
        $this->container = $container;
    }

    public function getName()
    {
        return 'includer';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction( 'include', array($this, 'include'))
        ];
    }


    public function include($module_path, $options = [])
    {
        $str = file_get_contents($this->basedir . $module_path);

        $json_array = json_decode($str, true);

        foreach ($options as $key => $value) {
            $json_array[$key] = $value;
        }

        $template = $this->container->twig->load($json_array['resourceType'] . '.twig');

        return $template->render($json_array);
    }
}

?>