<?php

/* OGISIndexBundle:Lists:layers.html.twig */
class __TwigTemplate_707d23dd70ceeb3fb428cd218a0f5b18bd3f47ee21a5908febf8f9e7440eec7b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("OGISIndexBundle:Default:header.html.twig", "OGISIndexBundle:Lists:layers.html.twig", 37);
        // line 37
        if (!$_trait_0->isTraitable()) {
            throw new Twig_Error_Runtime('Template "'."OGISIndexBundle:Default:header.html.twig".'" cannot be used as a trait.');
        }
        $_trait_0_blocks = $_trait_0->getBlocks();

        $this->traits = $_trait_0_blocks;

        $this->blocks = array_merge(
            $this->traits,
            array(
                'header' => array($this, 'block_header'),
                'pagecontent' => array($this, 'block_pagecontent'),
                'footer' => array($this, 'block_footer'),
            )
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_bd69341cfd4d9526c475ccd57f3acfb0bb8c835c393e099c60d5a305df9fa613 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_bd69341cfd4d9526c475ccd57f3acfb0bb8c835c393e099c60d5a305df9fa613->enter($__internal_bd69341cfd4d9526c475ccd57f3acfb0bb8c835c393e099c60d5a305df9fa613_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "OGISIndexBundle:Lists:layers.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
\t<head>
\t\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        
<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<!--  Copyright © 2015      Pavel Solovyev (solovyev.p.a@gmail.com)            -->
<!--                        Sergey Sevryukov (sevrukovs@gmail.com)             -->
<!--                        Alexander Afonin (acer737@yandex.ru)               -->
<!--                                                                           -->
<!--  Licensed under the Apache License, Version 2.0 (the \"License\");          -->
<!--  you may not use this file except in compliance with the License.         -->
<!--  You may obtain a copy of the License at                                  -->
<!--              http://www.apache.org/licenses/LICENSE-2.0                   -->
<!--                                                                           -->
<!--  Unless required by applicable law or agreed to in writing, software      -->
<!--  distributed under the License is distributed on an \"AS IS\" BASIS,        -->
<!--  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. -->
<!--  See the License for the specific language governing permissions and      -->
<!--  limitations under the License.                                           -->
<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

\t\t<link rel=\"shortcut icon\" href=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
\t\t<title>Layers :: project O-GIS</title>
\t\t<style type=\"text/css\">
\t\t\t.listrow{
\t\t\t\tbackground: #fff;
\t\t\t\twidth: 100%;
\t\t\t\tpadding: 2px;
\t\t\t\tborder: 1px solid #aaa;
\t\t\t\tmargin-bottom: 4px;
\t\t\t}
\t\t</style>
\t</head>
\t<body style=\"width:100%; position:absolute; top:-8px; left:-8px;\">

\t\t";
        // line 38
        echo "\t\t";
        $this->displayBlock('header', $context, $blocks);
        // line 41
        echo "
\t\t";
        // line 42
        $this->displayBlock('pagecontent', $context, $blocks);
        // line 112
        echo "
\t\t";
        // line 113
        $this->displayBlock('footer', $context, $blocks);
        // line 116
        echo "</html>
";
        
        $__internal_bd69341cfd4d9526c475ccd57f3acfb0bb8c835c393e099c60d5a305df9fa613->leave($__internal_bd69341cfd4d9526c475ccd57f3acfb0bb8c835c393e099c60d5a305df9fa613_prof);

    }

    // line 38
    public function block_header($context, array $blocks = array())
    {
        $__internal_09c211416df73622e75bac4c0bfd34e2544661192450d5f4f3060db60542d8c1 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_09c211416df73622e75bac4c0bfd34e2544661192450d5f4f3060db60542d8c1->enter($__internal_09c211416df73622e75bac4c0bfd34e2544661192450d5f4f3060db60542d8c1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        // line 39
        echo "\t\t\t";
        $this->displayParentBlock("header", $context, $blocks);
        echo "
\t\t";
        
        $__internal_09c211416df73622e75bac4c0bfd34e2544661192450d5f4f3060db60542d8c1->leave($__internal_09c211416df73622e75bac4c0bfd34e2544661192450d5f4f3060db60542d8c1_prof);

    }

    // line 42
    public function block_pagecontent($context, array $blocks = array())
    {
        $__internal_27da53682e30ac32d5b1eae843a667ce8984ae7bbee31dc33d5d32b3eef0805f = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_27da53682e30ac32d5b1eae843a667ce8984ae7bbee31dc33d5d32b3eef0805f->enter($__internal_27da53682e30ac32d5b1eae843a667ce8984ae7bbee31dc33d5d32b3eef0805f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "pagecontent"));

        // line 43
        echo "\t\t\t<div style=\"width:80%;margin-left:auto;margin-right:auto;margin-top:8px;\">
\t\t\t\t<center>
\t\t\t\t\t<b>Order layers by</b>:&nbsp;
\t\t\t\t\t<a href=\"";
        // line 46
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("layerlist", array("sortby" => "bymodified", "page" => 1)), "html", null, true);
        echo "\">Modify date</a>,&nbsp;
\t\t\t\t\t<a href=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("layerlist", array("sortby" => "bycreated", "page" => 1)), "html", null, true);
        echo "\">Create date</a>,&nbsp;
\t\t\t\t\t<a href=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("layerlist", array("sortby" => "byname", "page" => 1)), "html", null, true);
        echo "\">Title</a>,&nbsp;
\t\t\t\t\t<a href=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("layerlist", array("sortby" => "byauthor", "page" => 1)), "html", null, true);
        echo "\">Author</a>.
\t\t\t\t</center>
\t\t\t</div>
\t\t\t<div style=\"width:80%;margin-left:auto;margin-right:auto;margin-bottom:8px;padding:8px;\">
\t\t\t\t";
        // line 53
        if ((twig_length_filter($this->env, (isset($context["layers"]) ? $context["layers"] : $this->getContext($context, "layers"))) > 0)) {
            // line 54
            echo "\t\t\t\t\t
\t\t\t\t\t<center style=\"font-color:#444;margin-bottom:8px;\">
\t\t\t\t\t\t";
            // line 56
            $context["pages"] = (((isset($context["total"]) ? $context["total"] : $this->getContext($context, "total")) / 10) + 1);
            // line 57
            echo "\t\t\t\t\t\tСтраница ";
            echo twig_escape_filter($this->env, (isset($context["cpage"]) ? $context["cpage"] : $this->getContext($context, "cpage")), "html", null, true);
            echo " из ";
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["pages"]) ? $context["pages"] : $this->getContext($context, "pages")), 0, ".", ","), "html", null, true);
            echo ".
\t\t\t\t\t\t";
            // line 58
            if ((twig_number_format_filter($this->env, (isset($context["pages"]) ? $context["pages"] : $this->getContext($context, "pages")), 0, ".", ",") > 1)) {
                // line 59
                echo "\t\t\t\t\t\t\t";
                $context["nextpage"] = ((isset($context["cpage"]) ? $context["cpage"] : $this->getContext($context, "cpage")) + 1);
                // line 60
                echo "\t\t\t\t\t\t\t";
                $context["prevpage"] = ((isset($context["cpage"]) ? $context["cpage"] : $this->getContext($context, "cpage")) - 1);
                // line 61
                echo "\t\t\t\t\t\t\t";
                if (((isset($context["cpage"]) ? $context["cpage"] : $this->getContext($context, "cpage")) == 1)) {
                    // line 62
                    echo "\t\t\t\t\t\t\t\t&nbsp;<a href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("layerlist", array("sortby" => (isset($context["filter"]) ? $context["filter"] : $this->getContext($context, "filter")), "page" => (isset($context["nextpage"]) ? $context["nextpage"] : $this->getContext($context, "nextpage")))), "html", null, true);
                    echo "\">Next&nbsp;>&nbsp;</a>
\t\t\t\t\t\t\t";
                } elseif ((                // line 63
(isset($context["cpage"]) ? $context["cpage"] : $this->getContext($context, "cpage")) == twig_number_format_filter($this->env, (isset($context["pages"]) ? $context["pages"] : $this->getContext($context, "pages")), 0, ".", ","))) {
                    // line 64
                    echo "\t\t\t\t\t\t\t\t&nbsp;<a href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("layerlist", array("sortby" => (isset($context["filter"]) ? $context["filter"] : $this->getContext($context, "filter")), "page" => (isset($context["prevpage"]) ? $context["prevpage"] : $this->getContext($context, "prevpage")))), "html", null, true);
                    echo "\">&nbsp;<&nbsp;Previous</a>
\t\t\t\t\t\t\t";
                } else {
                    // line 66
                    echo "\t\t\t\t\t\t\t\t&nbsp;<a href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("layerlist", array("sortby" => (isset($context["filter"]) ? $context["filter"] : $this->getContext($context, "filter")), "page" => (isset($context["prevpage"]) ? $context["prevpage"] : $this->getContext($context, "prevpage")))), "html", null, true);
                    echo "\">&nbsp;<&nbsp;Previous</a>
\t\t\t\t\t\t\t\t&nbsp;<a href=\"";
                    // line 67
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("layerlist", array("sortby" => (isset($context["filter"]) ? $context["filter"] : $this->getContext($context, "filter")), "page" => (isset($context["nextpage"]) ? $context["nextpage"] : $this->getContext($context, "nextpage")))), "html", null, true);
                    echo "\">Next&nbsp;>&nbsp;</a>
\t\t\t\t\t\t\t";
                }
                // line 69
                echo "\t\t\t\t\t\t";
            }
            // line 70
            echo "\t\t\t\t\t</center>

\t\t\t\t\t";
            // line 72
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["layers"]) ? $context["layers"] : $this->getContext($context, "layers")));
            foreach ($context['_seq'] as $context["_key"] => $context["layer"]) {
                // line 73
                echo "\t\t\t\t\t\t<table class=\"listrow\">
\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t<td rowspan=\"3\" width=\"100px\" style=\"border:1px solid #aaa;background:#fff;\" valign=\"middle\">
\t\t\t\t\t\t\t\t\t<a href=\"";
                // line 76
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showlayer", array("id" => $this->getAttribute($context["layer"], "id", array()))), "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t\t\t<img src=\"";
                // line 77
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl($this->getAttribute($context["layer"], "preview", array())), "html", null, true);
                echo "\" width=\"144px\"/>
\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t<td valign=\"top\" height=\"20px\" colspan=\"3\" style=\"font-size:18px;padding-left:16px;\">
\t\t\t\t\t\t\t\t\t<a href=\"";
                // line 81
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showlayer", array("id" => $this->getAttribute($context["layer"], "id", array()))), "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t\t<b>";
                // line 82
                echo twig_escape_filter($this->env, $this->getAttribute($context["layer"], "name", array()), "html", null, true);
                echo "</b></a>
\t\t\t\t\t\t\t\t\t<span style=\"display:inline;font-size:14px;padding-left:16px\">
\t\t\t\t\t\t\t\t\t\t<b>Author<b>: <a href=\"";
                // line 84
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showuser", array("id" => $this->getAttribute($this->getAttribute($context["layer"], "author", array()), "id", array()))), "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t\t\t<b>";
                // line 85
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["layer"], "author", array()), "username", array()), "html", null, true);
                echo "</b></a>
\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t<td valign=\"top\" height=\"24px\" width=\"200px\" style=\"font-size:14px;padding-left:16px;\">
\t\t\t\t\t\t\t\t\t<b>Last modified</b>:&nbsp;";
                // line 91
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["layer"], "modified", array()), "d.m.Y"), "html", null, true);
                echo "
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t<td valign=\"top\" height=\"24px\" width=\"150px\" style=\"font-size:14px;\">
\t\t\t\t\t\t\t\t\t<b>Viewed</b>:&nbsp; ";
                // line 94
                echo twig_escape_filter($this->env, $this->getAttribute($context["layer"], "views", array()), "html", null, true);
                echo "
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t<td valign=\"top\" height=\"24px\" style=\"font-size:14px;\">
\t\t\t\t\t\t\t\t\t<b>Downloaded</b>:&nbsp; ";
                // line 97
                echo twig_escape_filter($this->env, $this->getAttribute($context["layer"], "downloads", array()), "html", null, true);
                echo "
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t<td valign=\"top\" colspan=\"3\" style=\"font-size:14px;padding-left:16px;\">
\t\t\t\t\t\t\t\t\t<i>\"";
                // line 102
                echo twig_escape_filter($this->env, $this->getAttribute($context["layer"], "description", array()), "html", null, true);
                echo "\"</i>
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t</table>
\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['layer'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 107
            echo "\t\t\t\t";
        } else {
            // line 108
            echo "\t\t\t\t\t<center>No layers have been found.</center>
\t\t\t\t";
        }
        // line 110
        echo "\t\t\t</div>
\t\t";
        
        $__internal_27da53682e30ac32d5b1eae843a667ce8984ae7bbee31dc33d5d32b3eef0805f->leave($__internal_27da53682e30ac32d5b1eae843a667ce8984ae7bbee31dc33d5d32b3eef0805f_prof);

    }

    // line 113
    public function block_footer($context, array $blocks = array())
    {
        $__internal_d70773360fcf3c5c3b0ad73d0b281d9de99675dda064930ac375695d48ff7a7d = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_d70773360fcf3c5c3b0ad73d0b281d9de99675dda064930ac375695d48ff7a7d->enter($__internal_d70773360fcf3c5c3b0ad73d0b281d9de99675dda064930ac375695d48ff7a7d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        // line 114
        echo "\t\t\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t\t";
        
        $__internal_d70773360fcf3c5c3b0ad73d0b281d9de99675dda064930ac375695d48ff7a7d->leave($__internal_d70773360fcf3c5c3b0ad73d0b281d9de99675dda064930ac375695d48ff7a7d_prof);

    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:Lists:layers.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  295 => 114,  289 => 113,  281 => 110,  277 => 108,  274 => 107,  263 => 102,  255 => 97,  249 => 94,  243 => 91,  234 => 85,  230 => 84,  225 => 82,  221 => 81,  214 => 77,  210 => 76,  205 => 73,  201 => 72,  197 => 70,  194 => 69,  189 => 67,  184 => 66,  178 => 64,  176 => 63,  171 => 62,  168 => 61,  165 => 60,  162 => 59,  160 => 58,  153 => 57,  151 => 56,  147 => 54,  145 => 53,  138 => 49,  134 => 48,  130 => 47,  126 => 46,  121 => 43,  115 => 42,  105 => 39,  99 => 38,  91 => 116,  89 => 113,  86 => 112,  84 => 42,  81 => 41,  78 => 38,  61 => 23,  37 => 1,  14 => 37,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
\t<head>
\t\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        
<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<!--  Copyright © 2015      Pavel Solovyev (solovyev.p.a@gmail.com)            -->
<!--                        Sergey Sevryukov (sevrukovs@gmail.com)             -->
<!--                        Alexander Afonin (acer737@yandex.ru)               -->
<!--                                                                           -->
<!--  Licensed under the Apache License, Version 2.0 (the \"License\");          -->
<!--  you may not use this file except in compliance with the License.         -->
<!--  You may obtain a copy of the License at                                  -->
<!--              http://www.apache.org/licenses/LICENSE-2.0                   -->
<!--                                                                           -->
<!--  Unless required by applicable law or agreed to in writing, software      -->
<!--  distributed under the License is distributed on an \"AS IS\" BASIS,        -->
<!--  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. -->
<!--  See the License for the specific language governing permissions and      -->
<!--  limitations under the License.                                           -->
<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

\t\t<link rel=\"shortcut icon\" href=\"{{ asset('favicon.ico') }}\" />
\t\t<title>Layers :: project O-GIS</title>
\t\t<style type=\"text/css\">
\t\t\t.listrow{
\t\t\t\tbackground: #fff;
\t\t\t\twidth: 100%;
\t\t\t\tpadding: 2px;
\t\t\t\tborder: 1px solid #aaa;
\t\t\t\tmargin-bottom: 4px;
\t\t\t}
\t\t</style>
\t</head>
\t<body style=\"width:100%; position:absolute; top:-8px; left:-8px;\">

\t\t{% use 'OGISIndexBundle:Default:header.html.twig' %}
\t\t{% block header %}
\t\t\t{{ parent() }}
\t\t{% endblock %}

\t\t{% block pagecontent %}
\t\t\t<div style=\"width:80%;margin-left:auto;margin-right:auto;margin-top:8px;\">
\t\t\t\t<center>
\t\t\t\t\t<b>Order layers by</b>:&nbsp;
\t\t\t\t\t<a href=\"{{ path('layerlist', {sortby: 'bymodified', page: 1}) }}\">Modify date</a>,&nbsp;
\t\t\t\t\t<a href=\"{{ path('layerlist', {sortby: 'bycreated', page: 1}) }}\">Create date</a>,&nbsp;
\t\t\t\t\t<a href=\"{{ path('layerlist', {sortby: 'byname', page: 1}) }}\">Title</a>,&nbsp;
\t\t\t\t\t<a href=\"{{ path('layerlist', {sortby: 'byauthor', page: 1}) }}\">Author</a>.
\t\t\t\t</center>
\t\t\t</div>
\t\t\t<div style=\"width:80%;margin-left:auto;margin-right:auto;margin-bottom:8px;padding:8px;\">
\t\t\t\t{% if layers|length > 0 %}
\t\t\t\t\t
\t\t\t\t\t<center style=\"font-color:#444;margin-bottom:8px;\">
\t\t\t\t\t\t{% set pages = total / 10 + 1 %}
\t\t\t\t\t\tСтраница {{ cpage }} из {{ pages|number_format(0, '.', ',') }}.
\t\t\t\t\t\t{% if pages|number_format(0, '.', ',') > 1 %}
\t\t\t\t\t\t\t{% set nextpage = cpage + 1 %}
\t\t\t\t\t\t\t{% set prevpage = cpage - 1 %}
\t\t\t\t\t\t\t{% if cpage == 1 %}
\t\t\t\t\t\t\t\t&nbsp;<a href=\"{{ path('layerlist', {sortby: filter, page: nextpage}) }}\">Next&nbsp;>&nbsp;</a>
\t\t\t\t\t\t\t{% elseif cpage == pages|number_format(0, '.', ',') %}
\t\t\t\t\t\t\t\t&nbsp;<a href=\"{{ path('layerlist', {sortby: filter, page: prevpage}) }}\">&nbsp;<&nbsp;Previous</a>
\t\t\t\t\t\t\t{% else %}
\t\t\t\t\t\t\t\t&nbsp;<a href=\"{{ path('layerlist', {sortby: filter, page: prevpage}) }}\">&nbsp;<&nbsp;Previous</a>
\t\t\t\t\t\t\t\t&nbsp;<a href=\"{{ path('layerlist', {sortby: filter, page: nextpage}) }}\">Next&nbsp;>&nbsp;</a>
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t{% endif %}
\t\t\t\t\t</center>

\t\t\t\t\t{% for layer in layers %}
\t\t\t\t\t\t<table class=\"listrow\">
\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t<td rowspan=\"3\" width=\"100px\" style=\"border:1px solid #aaa;background:#fff;\" valign=\"middle\">
\t\t\t\t\t\t\t\t\t<a href=\"{{ path('showlayer', {id: layer.id}) }}\">
\t\t\t\t\t\t\t\t\t\t<img src=\"{{ asset(layer.preview) }}\" width=\"144px\"/>
\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t<td valign=\"top\" height=\"20px\" colspan=\"3\" style=\"font-size:18px;padding-left:16px;\">
\t\t\t\t\t\t\t\t\t<a href=\"{{ path('showlayer', {id: layer.id}) }}\">
\t\t\t\t\t\t\t\t\t<b>{{ layer.name }}</b></a>
\t\t\t\t\t\t\t\t\t<span style=\"display:inline;font-size:14px;padding-left:16px\">
\t\t\t\t\t\t\t\t\t\t<b>Author<b>: <a href=\"{{ path('showuser', {id: layer.author.id}) }}\">
\t\t\t\t\t\t\t\t\t\t<b>{{ layer.author.username }}</b></a>
\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t<td valign=\"top\" height=\"24px\" width=\"200px\" style=\"font-size:14px;padding-left:16px;\">
\t\t\t\t\t\t\t\t\t<b>Last modified</b>:&nbsp;{{ layer.modified|date('d.m.Y') }}
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t<td valign=\"top\" height=\"24px\" width=\"150px\" style=\"font-size:14px;\">
\t\t\t\t\t\t\t\t\t<b>Viewed</b>:&nbsp; {{ layer.views }}
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t<td valign=\"top\" height=\"24px\" style=\"font-size:14px;\">
\t\t\t\t\t\t\t\t\t<b>Downloaded</b>:&nbsp; {{ layer.downloads }}
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t<td valign=\"top\" colspan=\"3\" style=\"font-size:14px;padding-left:16px;\">
\t\t\t\t\t\t\t\t\t<i>\"{{ layer.description }}\"</i>
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t</table>
\t\t\t\t\t{% endfor %}
\t\t\t\t{% else %}
\t\t\t\t\t<center>No layers have been found.</center>
\t\t\t\t{% endif %}
\t\t\t</div>
\t\t{% endblock %}

\t\t{% block footer %}
\t\t\t{{ parent() }}
\t\t{% endblock %}
</html>
", "OGISIndexBundle:Lists:layers.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/Lists/layers.html.twig");
    }
}
