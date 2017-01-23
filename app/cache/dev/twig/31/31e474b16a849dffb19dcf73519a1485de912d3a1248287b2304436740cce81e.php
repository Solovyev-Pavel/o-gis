<?php

/* FOSUserBundle:Registration:register.html.twig */
class __TwigTemplate_a3dc020df45c8004db6870e76c1bec0415e670036077fd1405261116a8c89297 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Registration:register.html.twig", 1);
        $this->blocks = array(
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "FOSUserBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_bc45cf9caa5503514e1a73f0826509b8f4a4e0b2f8c9e9409542973b6b75e191 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_bc45cf9caa5503514e1a73f0826509b8f4a4e0b2f8c9e9409542973b6b75e191->enter($__internal_bc45cf9caa5503514e1a73f0826509b8f4a4e0b2f8c9e9409542973b6b75e191_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Registration:register.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_bc45cf9caa5503514e1a73f0826509b8f4a4e0b2f8c9e9409542973b6b75e191->leave($__internal_bc45cf9caa5503514e1a73f0826509b8f4a4e0b2f8c9e9409542973b6b75e191_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_02eec22339d43151e7042ff73eebf7fc1d141c0a5ea4ebf3cb2ea69f06c4cbe2 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_02eec22339d43151e7042ff73eebf7fc1d141c0a5ea4ebf3cb2ea69f06c4cbe2->enter($__internal_02eec22339d43151e7042ff73eebf7fc1d141c0a5ea4ebf3cb2ea69f06c4cbe2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:Registration:register_content.html.twig", "FOSUserBundle:Registration:register.html.twig", 4)->display($context);
        
        $__internal_02eec22339d43151e7042ff73eebf7fc1d141c0a5ea4ebf3cb2ea69f06c4cbe2->leave($__internal_02eec22339d43151e7042ff73eebf7fc1d141c0a5ea4ebf3cb2ea69f06c4cbe2_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Registration:register.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 4,  34 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"FOSUserBundle::layout.html.twig\" %}

{% block fos_user_content %}
{% include \"FOSUserBundle:Registration:register_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:Registration:register.html.twig", "D:\\dev\\o-gis\\vendor\\friendsofsymfony\\user-bundle/Resources/views/Registration/register.html.twig");
    }
}
