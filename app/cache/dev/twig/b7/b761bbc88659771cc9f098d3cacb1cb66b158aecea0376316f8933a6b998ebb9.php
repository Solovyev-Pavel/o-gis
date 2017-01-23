<?php

/* OGISIndexBundle:Default:header.html.twig */
class __TwigTemplate_a88da743e9ad6aa6d2ed14ff2859d89e9e76ec84b6544c98a857cb5993116ced extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'header' => array($this, 'block_header'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_5a5542b0d8abdcd3afef216f0e49a6201060927c1182fa15ab336f4d6cf5794d = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_5a5542b0d8abdcd3afef216f0e49a6201060927c1182fa15ab336f4d6cf5794d->enter($__internal_5a5542b0d8abdcd3afef216f0e49a6201060927c1182fa15ab336f4d6cf5794d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "OGISIndexBundle:Default:header.html.twig"));

        // line 1
        $this->displayBlock('header', $context, $blocks);
        // line 56
        echo "
";
        // line 57
        $this->displayBlock('footer', $context, $blocks);
        
        $__internal_5a5542b0d8abdcd3afef216f0e49a6201060927c1182fa15ab336f4d6cf5794d->leave($__internal_5a5542b0d8abdcd3afef216f0e49a6201060927c1182fa15ab336f4d6cf5794d_prof);

    }

    // line 1
    public function block_header($context, array $blocks = array())
    {
        $__internal_86c85de48be73f509e677cbdfcd076f7f59935ccbb7d5a1098a4435aa0e38670 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_86c85de48be73f509e677cbdfcd076f7f59935ccbb7d5a1098a4435aa0e38670->enter($__internal_86c85de48be73f509e677cbdfcd076f7f59935ccbb7d5a1098a4435aa0e38670_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        // line 2
        echo "    
    <div class=\"headerpanelmain\">
        
        <div class=\"logobox\">
                <div class=\"logo\">O-GIS</div>
        </div>
        
        <div class=\"linkbox\">
            <a href=\"";
        // line 10
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("homepage");
        echo "\">
                <div class=\"linkitembox\">
                    <div class=\"linkitem\">Home</div>
                </div>
            </a>
            <a href=\"";
        // line 15
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("compositioneditor");
        echo "\">
                <div class=\"linkitembox\">
                    <div class=\"linkitem\">Editor</div>
                </div>
            </a>
            <a href=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("layerlist", array("sortby" => "modified", "page" => 1)), "html", null, true);
        echo "\">
                <div class=\"linkitembox\">
                    <div class=\"linkitem\">Layers</div>
                </div>
            </a>
            <a href=\"";
        // line 25
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("userlist");
        echo "\">
                <div class=\"linkitembox\">
                    <div class=\"linkitem\">O-GIS users</div>
                </div>
            </a>
        </div>
        
        <div class=\"userbox\">
            ";
        // line 33
        if (($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()) == true)) {
            // line 34
            echo "                
                ";
            // line 35
            $context["unread_messages"] = 0;
            // line 36
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "messagesReceived", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 37
                echo "                    ";
                if (($this->getAttribute($context["message"], "read", array()) == false)) {
                    // line 38
                    echo "                        ";
                    $context["unread_messages"] = ((isset($context["unread_messages"]) ? $context["unread_messages"] : $this->getContext($context, "unread_messages")) + 1);
                    // line 39
                    echo "                    ";
                }
                // line 40
                echo "                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 41
            echo "                
                <b>";
            // line 42
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "username", array()), "html", null, true);
            echo "</b> :: <a href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showuser", array("id" => $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "id", array()))), "html", null, true);
            echo "\">Profile</a> |
                <a href=\"";
            // line 43
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("usermessages");
            echo "\">Messagebox</a> ";
            if (((isset($context["unread_messages"]) ? $context["unread_messages"] : $this->getContext($context, "unread_messages")) > 0)) {
                echo "<b>&nbsp;(";
                echo twig_escape_filter($this->env, (isset($context["unread_messages"]) ? $context["unread_messages"] : $this->getContext($context, "unread_messages")), "html", null, true);
                echo ")</b>";
            }
            echo " |
                ";
            // line 44
            if (((($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "roles", array()), 0, array(), "array") == "ROLE_ADMIN") || ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "roles", array()), 0, array(), "array") == "ROLE_SUPER_ADMIN")) || ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "roles", array()), 0, array(), "array") == "ROLE_SYSTEM"))) {
                // line 45
                echo "                    <a href=\"";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("adminhome");
                echo "\" target=\"_blank\">Admin panel</a> |
                ";
            }
            // line 47
            echo "                <a href=\"";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_security_logout");
            echo "\">Logout</a>
            ";
        } else {
            // line 49
            echo "                <a href=\"";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("login");
            echo "\">Login</a> | <a href=\"";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_registration_register");
            echo "\">Sign up</a>
            ";
        }
        // line 51
        echo "        </div>
                
    </div>

";
        
        $__internal_86c85de48be73f509e677cbdfcd076f7f59935ccbb7d5a1098a4435aa0e38670->leave($__internal_86c85de48be73f509e677cbdfcd076f7f59935ccbb7d5a1098a4435aa0e38670_prof);

    }

    // line 57
    public function block_footer($context, array $blocks = array())
    {
        $__internal_b7a3a9b25f2e85bf3f71c5af1089b503f37774d48ff3d1509d21ff02a08ae027 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_b7a3a9b25f2e85bf3f71c5af1089b503f37774d48ff3d1509d21ff02a08ae027->enter($__internal_b7a3a9b25f2e85bf3f71c5af1089b503f37774d48ff3d1509d21ff02a08ae027_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        // line 58
        echo "    <table width=\"100%\">
        <tr>
            <td width=\"33%\"></td>
            <td width=\"34%\">
                <center>(c) O-GIS team, 2014 - ";
        // line 62
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo "</center>
            </td>
            <td></td>
        </tr>
    </table>
";
        
        $__internal_b7a3a9b25f2e85bf3f71c5af1089b503f37774d48ff3d1509d21ff02a08ae027->leave($__internal_b7a3a9b25f2e85bf3f71c5af1089b503f37774d48ff3d1509d21ff02a08ae027_prof);

    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:Default:header.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  178 => 62,  172 => 58,  166 => 57,  155 => 51,  147 => 49,  141 => 47,  135 => 45,  133 => 44,  123 => 43,  117 => 42,  114 => 41,  108 => 40,  105 => 39,  102 => 38,  99 => 37,  94 => 36,  92 => 35,  89 => 34,  87 => 33,  76 => 25,  68 => 20,  60 => 15,  52 => 10,  42 => 2,  36 => 1,  29 => 57,  26 => 56,  24 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% block header %}
    
    <div class=\"headerpanelmain\">
        
        <div class=\"logobox\">
                <div class=\"logo\">O-GIS</div>
        </div>
        
        <div class=\"linkbox\">
            <a href=\"{{ path('homepage') }}\">
                <div class=\"linkitembox\">
                    <div class=\"linkitem\">Home</div>
                </div>
            </a>
            <a href=\"{{ path('compositioneditor') }}\">
                <div class=\"linkitembox\">
                    <div class=\"linkitem\">Editor</div>
                </div>
            </a>
            <a href=\"{{ path('layerlist', {sortby: 'modified', page: 1}) }}\">
                <div class=\"linkitembox\">
                    <div class=\"linkitem\">Layers</div>
                </div>
            </a>
            <a href=\"{{ path('userlist') }}\">
                <div class=\"linkitembox\">
                    <div class=\"linkitem\">O-GIS users</div>
                </div>
            </a>
        </div>
        
        <div class=\"userbox\">
            {% if app.user == true %}
                
                {% set unread_messages = 0 %}
                {% for message in app.user.messagesReceived %}
                    {% if message.read == false %}
                        {% set unread_messages = unread_messages + 1 %}
                    {% endif %}
                {% endfor %}
                
                <b>{{ app.user.username }}</b> :: <a href=\"{{ path('showuser', {'id' : app.user.id}) }}\">Profile</a> |
                <a href=\"{{ path('usermessages') }}\">Messagebox</a> {% if unread_messages > 0 %}<b>&nbsp;({{unread_messages}})</b>{% endif %} |
                {% if app.user.roles[0] == \"ROLE_ADMIN\" or app.user.roles[0] == \"ROLE_SUPER_ADMIN\" or app.user.roles[0] == \"ROLE_SYSTEM\" %}
                    <a href=\"{{ path('adminhome') }}\" target=\"_blank\">Admin panel</a> |
                {% endif %}
                <a href=\"{{ path('fos_user_security_logout') }}\">Logout</a>
            {% else %}
                <a href=\"{{ path('login') }}\">Login</a> | <a href=\"{{ path('fos_user_registration_register') }}\">Sign up</a>
            {% endif %}
        </div>
                
    </div>

{% endblock %}

{% block footer %}
    <table width=\"100%\">
        <tr>
            <td width=\"33%\"></td>
            <td width=\"34%\">
                <center>(c) O-GIS team, 2014 - {{ \"now\"|date('Y') }}</center>
            </td>
            <td></td>
        </tr>
    </table>
{% endblock %}
", "OGISIndexBundle:Default:header.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/Default/header.html.twig");
    }
}
