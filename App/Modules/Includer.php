<?php

namespace App\Modules;

class Includer extends \Twig_Extension {

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'includer';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction( 'include', array($this, 'include')),
            new \Twig_SimpleFunction( 'includeNav', array($this, 'includeNav'))
        ];
    }


    public function include($module_path, $options = [])
    {
        $str = file_get_contents(__DIR__ . '/../../Resources/data/' . $module_path);

        $json_array = json_decode($str, true);

        foreach ($options as $key => $value) {
            $json_array[$key] = $value;
        }

        $json_array['resourceType'] .= ( ends_with($json_array['resourceType'], '.twig') ? '' : '.twig' );
        $template = $this->container->twig->load( $json_array['resourceType'] );

        return $template->render($json_array);
    }

    public function includeNav($nav) {
        return $this->include($nav['json'], $nav);
    }
}

?>