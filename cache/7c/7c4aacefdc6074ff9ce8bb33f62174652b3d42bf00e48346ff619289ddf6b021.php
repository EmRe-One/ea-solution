<?php

/* modules/slider/slider.twig */
class __TwigTemplate_3c86040a10552a60b92df116d58a9281c89a2a951554cbee80ba80fd5e345b1e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div>
    ";
        // line 2
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo "
    <p>
        ";
        // line 4
        echo twig_escape_filter($this->env, ($context["text"] ?? null), "html", null, true);
        echo "
    </p>

    <ul>
        ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((($context["img"] ?? null) - ($context["list"] ?? null)));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 9
            echo "            <li>";
            echo twig_escape_filter($this->env, $context["item"], "html", null, true);
            echo "</li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        echo "    </ul>

</div>";
    }

    public function getTemplateName()
    {
        return "modules/slider/slider.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  47 => 11,  38 => 9,  34 => 8,  27 => 4,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "modules/slider/slider.twig", "C:\\Users\\Emre Ak\\Google Drive\\Projekte\\EA-Solution\\Resources\\views\\modules\\slider\\slider.twig");
    }
}
