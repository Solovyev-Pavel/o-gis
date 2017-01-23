<?php

/* OGISIndexBundle:AuthManager:login.html.twig */
class __TwigTemplate_ff52c6bf41094d350875968262e3d5524853aa21976e5da14f56208585c65160 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("OGISIndexBundle:Default:header.html.twig", "OGISIndexBundle:AuthManager:login.html.twig", 46);
        // line 46
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
        $__internal_363c09162522d7454b832ee2fe2a91a06217b73d23c369775bf4650eb06c1079 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_363c09162522d7454b832ee2fe2a91a06217b73d23c369775bf4650eb06c1079->enter($__internal_363c09162522d7454b832ee2fe2a91a06217b73d23c369775bf4650eb06c1079_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "OGISIndexBundle:AuthManager:login.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        
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

<link rel=\"shortcut icon\" href=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/ogis_styles.css"), "html", null, true);
        echo "\" />
        <title>O-GIS Login</title>
        <style type=\"text/css\">
            .infobox{
                width: 80%;
                margin-left: auto;
                margin-right: auto;
                margin-top: 15px;
                margin-bottom: 15px;
                font-weight: bold;
                font-size: 18px;
                background: #e9c9c9;
                border: solid 2px #a00000;
                color: #d00000;
                padding-top: 10px;
                padding-bottom: 10px;
            }
        </style>
    </head>

    <body class=\"bodyfullpage\">

        ";
        // line 47
        echo "        ";
        $this->displayBlock('header', $context, $blocks);
        // line 50
        echo "
        ";
        // line 51
        $this->displayBlock('pagecontent', $context, $blocks);
        // line 99
        echo "
        ";
        // line 100
        $this->displayBlock('footer', $context, $blocks);
        // line 103
        echo "    </body>
</html>
";
        
        $__internal_363c09162522d7454b832ee2fe2a91a06217b73d23c369775bf4650eb06c1079->leave($__internal_363c09162522d7454b832ee2fe2a91a06217b73d23c369775bf4650eb06c1079_prof);

    }

    // line 47
    public function block_header($context, array $blocks = array())
    {
        $__internal_afe9a118a79e72a16fcdcc60b3e021c5d3bf6782f0b6b8dd1057ef3e5f59f378 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_afe9a118a79e72a16fcdcc60b3e021c5d3bf6782f0b6b8dd1057ef3e5f59f378->enter($__internal_afe9a118a79e72a16fcdcc60b3e021c5d3bf6782f0b6b8dd1057ef3e5f59f378_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        // line 48
        echo "            ";
        $this->displayParentBlock("header", $context, $blocks);
        echo "
        ";
        
        $__internal_afe9a118a79e72a16fcdcc60b3e021c5d3bf6782f0b6b8dd1057ef3e5f59f378->leave($__internal_afe9a118a79e72a16fcdcc60b3e021c5d3bf6782f0b6b8dd1057ef3e5f59f378_prof);

    }

    // line 51
    public function block_pagecontent($context, array $blocks = array())
    {
        $__internal_f3ab3deab07ca62576b35b08f2fb9b28de8c9e4fb0a9549cc3cf175519006f71 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_f3ab3deab07ca62576b35b08f2fb9b28de8c9e4fb0a9549cc3cf175519006f71->enter($__internal_f3ab3deab07ca62576b35b08f2fb9b28de8c9e4fb0a9549cc3cf175519006f71_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "pagecontent"));

        // line 52
        echo "            <div class=\"contentbody\">
            
            ";
        // line 54
        if (((isset($context["message"]) ? $context["message"] : $this->getContext($context, "message")) != null)) {
            // line 55
            echo "                <table class=\"infobox\">
                    <tr>
                        <td width=\"96px\" valign=\"middle\">
                            <center><img src=\"";
            // line 58
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./img/info.png"), "html", null, true);
            echo "\"/></center>
                        </td>
                        <td valign=\"middle\">
                            <center>";
            // line 61
            echo twig_escape_filter($this->env, (isset($context["message"]) ? $context["message"] : $this->getContext($context, "message")), "html", null, true);
            echo "</center>
                        </td>
                        <td width=\"96px\" valign=\"middle\">
                            <center><img src=\"";
            // line 64
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./img/info.png"), "html", null, true);
            echo "\"/></center>
                        </td>
                    </tr>
                </table>
            ";
        }
        // line 69
        echo "            
                <form action=\"";
        // line 70
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("validatelogin");
        echo "\" method=\"post\" id=\"loginform\">
                <table style=\"width:40%;min-width:350px;margin-left:auto;margin-right:auto;margin-top:32px;\">
                    <tr>
                        <td width=\"120px\"><b>Login</b>:</td>
                        <td>
                            <input name=\"username\" type=\"text\" value=\"";
        // line 75
        echo twig_escape_filter($this->env, (isset($context["username"]) ? $context["username"] : $this->getContext($context, "username")), "html", null, true);
        echo "\" style=\"width:100%\" />
                        </td>
                    </tr>
                    <tr>
                        <td><b>Password</b>:</td>
                        <td>
                            <input name=\"password\" type=\"password\" value=\"\" style=\"width:100%\" />
                            <input name=\"login_target\" type=\"hidden\" value=\"";
        // line 82
        echo twig_escape_filter($this->env, (isset($context["login_target"]) ? $context["login_target"] : $this->getContext($context, "login_target")), "html", null, true);
        echo "\" />
                        </td>
                    </tr>
<!--                    <tr>
                        <td colspan=\"2\">
                            <label><input name=\"rememberme\" form=\"loginform\" type=\"checkbox\" /> Запомнить меня</label>
                        </td>
                    </tr> -->
                    <tr>
                        <td colspan=\"2\">
                            <button type=\"submit\"> Login into O-GIS </button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        ";
        
        $__internal_f3ab3deab07ca62576b35b08f2fb9b28de8c9e4fb0a9549cc3cf175519006f71->leave($__internal_f3ab3deab07ca62576b35b08f2fb9b28de8c9e4fb0a9549cc3cf175519006f71_prof);

    }

    // line 100
    public function block_footer($context, array $blocks = array())
    {
        $__internal_25c8992789e77498ec1dfaddf93ebf5417d578b18fd054a6b766385f31d40bd5 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_25c8992789e77498ec1dfaddf93ebf5417d578b18fd054a6b766385f31d40bd5->enter($__internal_25c8992789e77498ec1dfaddf93ebf5417d578b18fd054a6b766385f31d40bd5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        // line 101
        echo "            ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
        ";
        
        $__internal_25c8992789e77498ec1dfaddf93ebf5417d578b18fd054a6b766385f31d40bd5->leave($__internal_25c8992789e77498ec1dfaddf93ebf5417d578b18fd054a6b766385f31d40bd5_prof);

    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:AuthManager:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  216 => 101,  210 => 100,  186 => 82,  176 => 75,  168 => 70,  165 => 69,  157 => 64,  151 => 61,  145 => 58,  140 => 55,  138 => 54,  134 => 52,  128 => 51,  118 => 48,  112 => 47,  103 => 103,  101 => 100,  98 => 99,  96 => 51,  93 => 50,  90 => 47,  65 => 24,  61 => 23,  37 => 1,  14 => 46,);
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
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        
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

<link rel=\"shortcut icon\" href=\"{{ asset('favicon.ico') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./css/ogis_styles.css') }}\" />
        <title>O-GIS Login</title>
        <style type=\"text/css\">
            .infobox{
                width: 80%;
                margin-left: auto;
                margin-right: auto;
                margin-top: 15px;
                margin-bottom: 15px;
                font-weight: bold;
                font-size: 18px;
                background: #e9c9c9;
                border: solid 2px #a00000;
                color: #d00000;
                padding-top: 10px;
                padding-bottom: 10px;
            }
        </style>
    </head>

    <body class=\"bodyfullpage\">

        {% use 'OGISIndexBundle:Default:header.html.twig' %}
        {% block header %}
            {{ parent() }}
        {% endblock %}

        {% block pagecontent %}
            <div class=\"contentbody\">
            
            {% if message != null %}
                <table class=\"infobox\">
                    <tr>
                        <td width=\"96px\" valign=\"middle\">
                            <center><img src=\"{{ asset('./img/info.png') }}\"/></center>
                        </td>
                        <td valign=\"middle\">
                            <center>{{ message }}</center>
                        </td>
                        <td width=\"96px\" valign=\"middle\">
                            <center><img src=\"{{ asset('./img/info.png') }}\"/></center>
                        </td>
                    </tr>
                </table>
            {% endif %}
            
                <form action=\"{{ path('validatelogin') }}\" method=\"post\" id=\"loginform\">
                <table style=\"width:40%;min-width:350px;margin-left:auto;margin-right:auto;margin-top:32px;\">
                    <tr>
                        <td width=\"120px\"><b>Login</b>:</td>
                        <td>
                            <input name=\"username\" type=\"text\" value=\"{{ username }}\" style=\"width:100%\" />
                        </td>
                    </tr>
                    <tr>
                        <td><b>Password</b>:</td>
                        <td>
                            <input name=\"password\" type=\"password\" value=\"\" style=\"width:100%\" />
                            <input name=\"login_target\" type=\"hidden\" value=\"{{ login_target }}\" />
                        </td>
                    </tr>
<!--                    <tr>
                        <td colspan=\"2\">
                            <label><input name=\"rememberme\" form=\"loginform\" type=\"checkbox\" /> Запомнить меня</label>
                        </td>
                    </tr> -->
                    <tr>
                        <td colspan=\"2\">
                            <button type=\"submit\"> Login into O-GIS </button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        {% endblock %}

        {% block footer %}
            {{ parent() }}
        {% endblock %}
    </body>
</html>
", "OGISIndexBundle:AuthManager:login.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/AuthManager/login.html.twig");
    }
}
