<?php

/* OGISIndexBundle:Default:homepage.html.twig */
class __TwigTemplate_65929cff0e723d124e5d374ee78dcfb6619b29f81228110a876357218d723fc5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("OGISIndexBundle:Default:header.html.twig", "OGISIndexBundle:Default:homepage.html.twig", 76);
        // line 76
        if (!$_trait_0->isTraitable()) {
            throw new Twig_Error_Runtime('Template "'."OGISIndexBundle:Default:header.html.twig".'" cannot be used as a trait.');
        }
        $_trait_0_blocks = $_trait_0->getBlocks();

        $this->traits = $_trait_0_blocks;

        $this->blocks = array_merge(
            $this->traits,
            array(
                'header' => array($this, 'block_header'),
                'bodycontent' => array($this, 'block_bodycontent'),
                'footer' => array($this, 'block_footer'),
            )
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_3e5da68e611ea42a1fcd98a2a4147dcdc72aec881136db241548943bd6701a8c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3e5da68e611ea42a1fcd98a2a4147dcdc72aec881136db241548943bd6701a8c->enter($__internal_3e5da68e611ea42a1fcd98a2a4147dcdc72aec881136db241548943bd6701a8c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "OGISIndexBundle:Default:homepage.html.twig"));

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
\t\t<link rel=\"stylesheet\" href=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/ogis_styles.css"), "html", null, true);
        echo "\" />
\t\t<title>Project O-GIS</title>
\t\t<style>
\t\t\t.contentbox{
\t\t\t\twidth: calc( 100% - 350px );
\t\t\t\tfloat: left;
\t\t\t\theight: 100%;
\t\t\t\tpadding-left: 14px;
\t\t\t\tpadding-right: 14px;
\t\t\t\tborder: 2px solid #ccc;
\t\t\t\tborder-radius: 20px;
\t\t\t\tcolor: #aaa;
\t\t\t\toverflow-y: auto;
\t\t\t}
\t\t\t.centermessage{
\t\t\t\tfont-size: 24px;
\t\t\t\tposition: relative;
\t\t\t\ttransform: translateY(50%)
\t\t\t}
\t\t\t.centermessagetext{
\t\t\t\tfont-size: 14px;
\t\t\t\tcolor: #2A2A2A;
\t\t\t}
\t\t\t.newsbox{
\t\t\t\tborder: 2px solid #ccc;
\t\t\t\tborder-radius: 20px;
\t\t\t\twidth: 300px;
\t\t\t\tfloat: right;
\t\t\t\theight: 100%;
\t\t\t}
\t\t\t.mainbody{
\t\t\t\twidth: 80%;
\t\t\t\tmargin-left: auto;
\t\t\t\tmargin-right: auto;
\t\t\t\theight: calc( 100% - 250px );
\t\t\t}
\t\t\t.newsbkg{
\t\t\t\tbackground: #efefff;
\t\t\t\tborder-bottom: 1px solid #ccc;
\t\t\t\tborder-top-left-radius: 20px;
\t\t\t\tborder-top-right-radius: 20px;
\t\t\t\tpadding: 4px;
\t\t\t\tfont-size: 18px;
\t\t\t}
\t\t</style>
\t\t<script>
\t\t\tconsole.log(";
        // line 70
        echo twig_escape_filter($this->env, twig_length_filter($this->env, (isset($context["news"]) ? $context["news"] : $this->getContext($context, "news"))), "html", null, true);
        echo ");
\t\t</script>
\t</head>

\t<body style=\"width:100%;position:absolute;top:-8px;left:-8px;height:100%\">

\t\t";
        // line 77
        echo "\t\t";
        $this->displayBlock('header', $context, $blocks);
        // line 80
        echo "
\t\t";
        // line 81
        $this->displayBlock('bodycontent', $context, $blocks);
        // line 116
        echo "
\t\t";
        // line 117
        $this->displayBlock('footer', $context, $blocks);
        // line 120
        echo "\t</body>
</html>
";
        
        $__internal_3e5da68e611ea42a1fcd98a2a4147dcdc72aec881136db241548943bd6701a8c->leave($__internal_3e5da68e611ea42a1fcd98a2a4147dcdc72aec881136db241548943bd6701a8c_prof);

    }

    // line 77
    public function block_header($context, array $blocks = array())
    {
        $__internal_c790e4b23c973fbc59fbc5fa59ae7ec8defe6ff2d6cdfdbdf5c68f1fbbe2562f = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_c790e4b23c973fbc59fbc5fa59ae7ec8defe6ff2d6cdfdbdf5c68f1fbbe2562f->enter($__internal_c790e4b23c973fbc59fbc5fa59ae7ec8defe6ff2d6cdfdbdf5c68f1fbbe2562f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        // line 78
        echo "\t\t\t";
        $this->displayParentBlock("header", $context, $blocks);
        echo "
\t\t";
        
        $__internal_c790e4b23c973fbc59fbc5fa59ae7ec8defe6ff2d6cdfdbdf5c68f1fbbe2562f->leave($__internal_c790e4b23c973fbc59fbc5fa59ae7ec8defe6ff2d6cdfdbdf5c68f1fbbe2562f_prof);

    }

    // line 81
    public function block_bodycontent($context, array $blocks = array())
    {
        $__internal_d1967884c2632e014e768d82326961320d9a5bf3bdcad5cecbee877a3039da06 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_d1967884c2632e014e768d82326961320d9a5bf3bdcad5cecbee877a3039da06->enter($__internal_d1967884c2632e014e768d82326961320d9a5bf3bdcad5cecbee877a3039da06_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "bodycontent"));

        // line 82
        echo "\t\t\t<center>
\t\t\t\t<h1>Welcome to project O-GIS</h1>
\t\t\t</center>
\t\t\t<div class=\"mainbody\">
\t\t\t\t<div class=\"contentbox\">
\t\t\t\t
\t\t\t\t</div>
\t\t\t\t<div class=\"newsbox\">
\t\t\t\t\t<div class=\"newsbkg\">
\t\t\t\t\t\t<b><center>Project O-GIS news</center></b>
\t\t\t\t\t</div>
\t\t\t\t\t<div style=\"overflow-y:auto;\">
\t\t\t\t\t\t";
        // line 94
        if ((twig_length_filter($this->env, (isset($context["news"]) ? $context["news"] : $this->getContext($context, "news"))) > 0)) {
            // line 95
            echo "\t\t\t\t\t\t\t";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["news"]) ? $context["news"] : $this->getContext($context, "news")));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 96
                echo "\t\t\t\t\t\t\t\t<div style=\"margin:4px;border:1px solid #ccc;\">
\t\t\t\t\t\t\t\t\t<div style=\"background:#efefef;border-bottom:1px solid #ccc;\">
\t\t\t\t\t\t\t\t\t\t<center><b>";
                // line 98
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
                echo "</b></center>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div style=\"padding:4px;\">
\t\t\t\t\t\t\t\t\t\t";
                // line 101
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "text", array()), "html", null, true);
                echo "
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div style=\"background:#fbfbfb;border-top:1px solid #ccc;text-align:right;padding-right:4px;font-size:13px;\">
\t\t\t\t\t\t\t\t\t\tAuthor: <a href=\"";
                // line 104
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showuser", array("id" => $this->getAttribute($this->getAttribute($context["item"], "author", array()), "id", array()))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "author", array()), "username", array()), "html", null, true);
                echo "</a>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 108
            echo "\t\t\t\t\t\t";
        } else {
            // line 109
            echo "\t\t\t\t\t\t\t<center style=\"padding:4px\">There are no news</center>
\t\t\t\t\t\t";
        }
        // line 111
        echo "\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<p>&nbsp;</p>
\t\t";
        
        $__internal_d1967884c2632e014e768d82326961320d9a5bf3bdcad5cecbee877a3039da06->leave($__internal_d1967884c2632e014e768d82326961320d9a5bf3bdcad5cecbee877a3039da06_prof);

    }

    // line 117
    public function block_footer($context, array $blocks = array())
    {
        $__internal_b91e5ccb501c4189c59a9e144dc36885f9a5d5b0996988a00ed66c6b44ba8764 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_b91e5ccb501c4189c59a9e144dc36885f9a5d5b0996988a00ed66c6b44ba8764->enter($__internal_b91e5ccb501c4189c59a9e144dc36885f9a5d5b0996988a00ed66c6b44ba8764_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        // line 118
        echo "\t\t\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t\t";
        
        $__internal_b91e5ccb501c4189c59a9e144dc36885f9a5d5b0996988a00ed66c6b44ba8764->leave($__internal_b91e5ccb501c4189c59a9e144dc36885f9a5d5b0996988a00ed66c6b44ba8764_prof);

    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:Default:homepage.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  240 => 118,  234 => 117,  223 => 111,  219 => 109,  216 => 108,  204 => 104,  198 => 101,  192 => 98,  188 => 96,  183 => 95,  181 => 94,  167 => 82,  161 => 81,  151 => 78,  145 => 77,  136 => 120,  134 => 117,  131 => 116,  129 => 81,  126 => 80,  123 => 77,  114 => 70,  65 => 24,  61 => 23,  37 => 1,  14 => 76,);
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
\t\t<link rel=\"stylesheet\" href=\"{{ asset('./css/ogis_styles.css') }}\" />
\t\t<title>Project O-GIS</title>
\t\t<style>
\t\t\t.contentbox{
\t\t\t\twidth: calc( 100% - 350px );
\t\t\t\tfloat: left;
\t\t\t\theight: 100%;
\t\t\t\tpadding-left: 14px;
\t\t\t\tpadding-right: 14px;
\t\t\t\tborder: 2px solid #ccc;
\t\t\t\tborder-radius: 20px;
\t\t\t\tcolor: #aaa;
\t\t\t\toverflow-y: auto;
\t\t\t}
\t\t\t.centermessage{
\t\t\t\tfont-size: 24px;
\t\t\t\tposition: relative;
\t\t\t\ttransform: translateY(50%)
\t\t\t}
\t\t\t.centermessagetext{
\t\t\t\tfont-size: 14px;
\t\t\t\tcolor: #2A2A2A;
\t\t\t}
\t\t\t.newsbox{
\t\t\t\tborder: 2px solid #ccc;
\t\t\t\tborder-radius: 20px;
\t\t\t\twidth: 300px;
\t\t\t\tfloat: right;
\t\t\t\theight: 100%;
\t\t\t}
\t\t\t.mainbody{
\t\t\t\twidth: 80%;
\t\t\t\tmargin-left: auto;
\t\t\t\tmargin-right: auto;
\t\t\t\theight: calc( 100% - 250px );
\t\t\t}
\t\t\t.newsbkg{
\t\t\t\tbackground: #efefff;
\t\t\t\tborder-bottom: 1px solid #ccc;
\t\t\t\tborder-top-left-radius: 20px;
\t\t\t\tborder-top-right-radius: 20px;
\t\t\t\tpadding: 4px;
\t\t\t\tfont-size: 18px;
\t\t\t}
\t\t</style>
\t\t<script>
\t\t\tconsole.log({{news|length}});
\t\t</script>
\t</head>

\t<body style=\"width:100%;position:absolute;top:-8px;left:-8px;height:100%\">

\t\t{% use 'OGISIndexBundle:Default:header.html.twig' %}
\t\t{% block header %}
\t\t\t{{ parent() }}
\t\t{% endblock %}

\t\t{% block bodycontent %}
\t\t\t<center>
\t\t\t\t<h1>Welcome to project O-GIS</h1>
\t\t\t</center>
\t\t\t<div class=\"mainbody\">
\t\t\t\t<div class=\"contentbox\">
\t\t\t\t
\t\t\t\t</div>
\t\t\t\t<div class=\"newsbox\">
\t\t\t\t\t<div class=\"newsbkg\">
\t\t\t\t\t\t<b><center>Project O-GIS news</center></b>
\t\t\t\t\t</div>
\t\t\t\t\t<div style=\"overflow-y:auto;\">
\t\t\t\t\t\t{% if news|length > 0 %}
\t\t\t\t\t\t\t{% for item in news %}
\t\t\t\t\t\t\t\t<div style=\"margin:4px;border:1px solid #ccc;\">
\t\t\t\t\t\t\t\t\t<div style=\"background:#efefef;border-bottom:1px solid #ccc;\">
\t\t\t\t\t\t\t\t\t\t<center><b>{{ item.title }}</b></center>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div style=\"padding:4px;\">
\t\t\t\t\t\t\t\t\t\t{{ item.text }}
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div style=\"background:#fbfbfb;border-top:1px solid #ccc;text-align:right;padding-right:4px;font-size:13px;\">
\t\t\t\t\t\t\t\t\t\tAuthor: <a href=\"{{ path('showuser', {id: item.author.id}) }}\">{{ item.author.username }}</a>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t{% else %}
\t\t\t\t\t\t\t<center style=\"padding:4px\">There are no news</center>
\t\t\t\t\t\t{% endif %}
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<p>&nbsp;</p>
\t\t{% endblock %}

\t\t{% block footer %}
\t\t\t{{ parent() }}
\t\t{% endblock %}
\t</body>
</html>
", "OGISIndexBundle:Default:homepage.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/Default/homepage.html.twig");
    }
}
