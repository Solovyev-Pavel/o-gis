<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_51d7c4dff7cf649a1ee91789fefba5f277f74fa843d124d7aec3cda7ce4cd292 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_f84929be396214333adb841c14c5790fb5d24f0544a0871ca619193faa00ed5b = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_f84929be396214333adb841c14c5790fb5d24f0544a0871ca619193faa00ed5b->enter($__internal_f84929be396214333adb841c14c5790fb5d24f0544a0871ca619193faa00ed5b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_f84929be396214333adb841c14c5790fb5d24f0544a0871ca619193faa00ed5b->leave($__internal_f84929be396214333adb841c14c5790fb5d24f0544a0871ca619193faa00ed5b_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_aeb7725644d01562a28c9349f2681dfb981042b94b2998eb20273949e0c01043 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_aeb7725644d01562a28c9349f2681dfb981042b94b2998eb20273949e0c01043->enter($__internal_aeb7725644d01562a28c9349f2681dfb981042b94b2998eb20273949e0c01043_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_aeb7725644d01562a28c9349f2681dfb981042b94b2998eb20273949e0c01043->leave($__internal_aeb7725644d01562a28c9349f2681dfb981042b94b2998eb20273949e0c01043_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_07a30b43b49e22d07bce1c974ea023e87680d4ce88e16f350ae77194b01475a9 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_07a30b43b49e22d07bce1c974ea023e87680d4ce88e16f350ae77194b01475a9->enter($__internal_07a30b43b49e22d07bce1c974ea023e87680d4ce88e16f350ae77194b01475a9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_07a30b43b49e22d07bce1c974ea023e87680d4ce88e16f350ae77194b01475a9->leave($__internal_07a30b43b49e22d07bce1c974ea023e87680d4ce88e16f350ae77194b01475a9_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_0d7908199219fb1374f9f1be9b88cf567d0c1037a98b4c5648d018b93b5e73a8 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0d7908199219fb1374f9f1be9b88cf567d0c1037a98b4c5648d018b93b5e73a8->enter($__internal_0d7908199219fb1374f9f1be9b88cf567d0c1037a98b4c5648d018b93b5e73a8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_0d7908199219fb1374f9f1be9b88cf567d0c1037a98b4c5648d018b93b5e73a8->leave($__internal_0d7908199219fb1374f9f1be9b88cf567d0c1037a98b4c5648d018b93b5e73a8_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'TwigBundle::layout.html.twig' %}

{% block head %}
    <link href=\"{{ absolute_url(asset('bundles/framework/css/exception.css')) }}\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
{% endblock %}

{% block title %}
    {{ exception.message }} ({{ status_code }} {{ status_text }})
{% endblock %}

{% block body %}
    {% include 'TwigBundle:Exception:exception.html.twig' %}
{% endblock %}
", "TwigBundle:Exception:exception_full.html.twig", "D:\\dev\\o-gis\\vendor\\symfony\\symfony\\src\\Symfony\\Bundle\\TwigBundle/Resources/views/Exception/exception_full.html.twig");
    }
}
