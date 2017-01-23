<?php

/* OGISIndexBundle:Default:messagebox.html.twig */
class __TwigTemplate_b3631a55f5642deeb907e89afcb55779a1b753bba846a7e39652092ca8e6aa36 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("OGISIndexBundle:Default:header.html.twig", "OGISIndexBundle:Default:messagebox.html.twig", 44);
        // line 44
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
        $__internal_3493c5e6dfc226e642fa9b95be7434ff8b4e4dac66a2c01d8dcbcbdadbbf19a4 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3493c5e6dfc226e642fa9b95be7434ff8b4e4dac66a2c01d8dcbcbdadbbf19a4->enter($__internal_3493c5e6dfc226e642fa9b95be7434ff8b4e4dac66a2c01d8dcbcbdadbbf19a4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "OGISIndexBundle:Default:messagebox.html.twig"));

        // line 1
        $context["unread"] = 0;
        // line 2
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messagesReceived", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 3
            echo "    ";
            if (($this->getAttribute($context["message"], "read", array()) == false)) {
                // line 4
                echo "        ";
                $context["unread"] = ((isset($context["unread"]) ? $context["unread"] : $this->getContext($context, "unread")) + 1);
                // line 5
                echo "    ";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 7
        echo "
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        <link rel=\"shortcut icon\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        <title>Your messagebox :: project O-GIS</title>
        <link rel=\"stylesheet\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/ogis_styles.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/themes/default/style.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-ui/jquery-ui.css"), "html", null, true);
        echo "\" />
        <script type=\"text/javascript\" src=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/jquery-2.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-ui/jquery-ui.min.js"), "html", null, true);
        echo "\"></script>
        
        <script type=\"text/javascript\">
            
            function returnToProfile(){ window.location.href = \"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showuser", array("id" => $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "id", array()))), "html", null, true);
        echo "\"; }
            
            function switchTabs(id){
                var data_tabs = [\"inbox_tab\", \"outbox_tab\"];
                var select_tabs = [\"inbox_sel\", \"outbox_sel\"];
                for (var i = 0; i < 2; i++){
                    if (i === id){
                        \$('#' + data_tabs[i]).css('display', 'block');
                        document.getElementById(select_tabs[i]).setAttribute('class', 'objectlinkselected userprofilelinkbox');
                    }
                    else{
                        \$('#' + data_tabs[i]).css('display', 'none');
                        document.getElementById(select_tabs[i]).setAttribute('class', 'objectlink userprofilelinkbox');
                    }
                }
            }
            
        </script>
        
    </head>
    
    <body class=\"bodyfullpage\">
        ";
        // line 45
        echo "        ";
        $this->displayBlock('header', $context, $blocks);
        // line 48
        echo "
        ";
        // line 49
        $this->displayBlock('pagecontent', $context, $blocks);
        // line 116
        echo "        
        ";
        // line 117
        $this->displayBlock('footer', $context, $blocks);
        // line 120
        echo "        
    </body>
</html>
";
        
        $__internal_3493c5e6dfc226e642fa9b95be7434ff8b4e4dac66a2c01d8dcbcbdadbbf19a4->leave($__internal_3493c5e6dfc226e642fa9b95be7434ff8b4e4dac66a2c01d8dcbcbdadbbf19a4_prof);

    }

    // line 45
    public function block_header($context, array $blocks = array())
    {
        $__internal_71017a94cbd62180ceb405e8d78816240fba485b24d165fc79bc4e47412b52ee = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_71017a94cbd62180ceb405e8d78816240fba485b24d165fc79bc4e47412b52ee->enter($__internal_71017a94cbd62180ceb405e8d78816240fba485b24d165fc79bc4e47412b52ee_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        // line 46
        echo "            ";
        $this->displayParentBlock("header", $context, $blocks);
        echo "
        ";
        
        $__internal_71017a94cbd62180ceb405e8d78816240fba485b24d165fc79bc4e47412b52ee->leave($__internal_71017a94cbd62180ceb405e8d78816240fba485b24d165fc79bc4e47412b52ee_prof);

    }

    // line 49
    public function block_pagecontent($context, array $blocks = array())
    {
        $__internal_56793dedb4befe463041639dbabeead81ed04eed9a6560510e8c12eaee65acd7 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_56793dedb4befe463041639dbabeead81ed04eed9a6560510e8c12eaee65acd7->enter($__internal_56793dedb4befe463041639dbabeead81ed04eed9a6560510e8c12eaee65acd7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "pagecontent"));

        // line 50
        echo "            
            <div class=\"contentbody\">
                ";
        // line 53
        echo "                <div class=\"userpageleftside\">
                    <div>
                        <div class=\"userprofilelinkbox objectlinkselected\" id=\"inbox_sel\" onclick=\"switchTabs(0);\">
                            Inbox
                            ";
        // line 57
        if (((isset($context["unread"]) ? $context["unread"] : $this->getContext($context, "unread")) > 0)) {
            // line 58
            echo "                                &nbsp;(";
            echo twig_escape_filter($this->env, (isset($context["unread"]) ? $context["unread"] : $this->getContext($context, "unread")), "html", null, true);
            echo ")
                            ";
        }
        // line 60
        echo "                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"outbox_sel\" onclick=\"switchTabs(1);\">
                            Outbox
                        </div>
                        <div class=\"userprofilelinkbox objectlink\" onclick=\"returnToProfile();\">
                            Back to profile
                        </div>
                    </div>
                </div>
                ";
        // line 70
        echo "                <div class=\"userpagerightside\">
                    <div id=\"inbox_tab\" class=\"userfilesareafullside\" style=\"display:block;\">
                        ";
        // line 72
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messagesReceived", array())) == 0)) {
            // line 73
            echo "                            <center><br/><b>No messages in the inbox!</b></center>
                        ";
        } else {
            // line 75
            echo "                            <div class=\"internalboxcontainer\">
                                ";
            // line 76
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messagesReceived", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 77
                echo "                                    ";
                if (($this->getAttribute($context["message"], "read", array()) == true)) {
                    // line 78
                    echo "                                        <div class=\"messagecontainer\">
                                            <b><a href=\"";
                    // line 79
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("viewmessage", array("id" => $this->getAttribute($context["message"], "id", array()))), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["message"], "subject", array()), "html", null, true);
                    echo "</a></b> from&nbsp;
                                            <a href=\"";
                    // line 80
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showuser", array("id" => $this->getAttribute($this->getAttribute($context["message"], "sender", array()), "id", array()))), "html", null, true);
                    echo "\" target=\"_blank\">
                                                ";
                    // line 81
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["message"], "sender", array()), "displayname", array()), "html", null, true);
                    echo "
                                            </a>&nbsp;( ";
                    // line 82
                    echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["message"], "sent", array()), "H:i:s d.m.Y"), "html", null, true);
                    echo " )
                                        </div>
                                    ";
                } else {
                    // line 85
                    echo "                                        <div class=\"messagecontainernew\">
                                            <b><a href=\"";
                    // line 86
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("viewmessage", array("id" => $this->getAttribute($context["message"], "id", array()))), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["message"], "subject", array()), "html", null, true);
                    echo "</a></b> from&nbsp;
                                            <a href=\"";
                    // line 87
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showuser", array("id" => $this->getAttribute($this->getAttribute($context["message"], "sender", array()), "id", array()))), "html", null, true);
                    echo "\" target=\"_blank\">
                                                ";
                    // line 88
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["message"], "sender", array()), "displayname", array()), "html", null, true);
                    echo "
                                            </a>&nbsp;( ";
                    // line 89
                    echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["message"], "sent", array()), "H:i:s d.m.Y"), "html", null, true);
                    echo " )
                                        </div>
                                    ";
                }
                // line 92
                echo "                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 93
            echo "                            </div>
                        ";
        }
        // line 95
        echo "                    </div>
                    <div id=\"outbox_tab\" class=\"userfilesareafullside\" style=\"display:none;\">
                        ";
        // line 97
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messagesSent", array())) == 0)) {
            // line 98
            echo "                            <center><br/><b>No messages in the outbox!</b></center>
                        ";
        } else {
            // line 100
            echo "                            <div style=\"width:100%;height:100%;padding-left:10px;padding-right:10px;padding-top:6px;padding-bottom:6px;overflow-y:scroll;\">
                                ";
            // line 101
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messagesSent", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 102
                echo "                                    <div class=\"messagecontainer\">
                                        <b><a href=\"";
                // line 103
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("viewmessage", array("id" => $this->getAttribute($context["message"], "id", array()))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["message"], "subject", array()), "html", null, true);
                echo "</a></b> to&nbsp;
                                        <a href=\"";
                // line 104
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showuser", array("id" => $this->getAttribute($this->getAttribute($context["message"], "addressee", array()), "id", array()))), "html", null, true);
                echo "\" target=\"_blank\">
                                            ";
                // line 105
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["message"], "addressee", array()), "displayname", array()), "html", null, true);
                echo "
                                        </a>&nbsp;( ";
                // line 106
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["message"], "sent", array()), "H:i:s d.m.Y"), "html", null, true);
                echo " )
                                    </div>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 109
            echo "                            </div>
                        ";
        }
        // line 111
        echo "                    </div>
                </div>
            </div>
            
        ";
        
        $__internal_56793dedb4befe463041639dbabeead81ed04eed9a6560510e8c12eaee65acd7->leave($__internal_56793dedb4befe463041639dbabeead81ed04eed9a6560510e8c12eaee65acd7_prof);

    }

    // line 117
    public function block_footer($context, array $blocks = array())
    {
        $__internal_acd5a71c16dadade090a20f51ace1879264b15a93e6cc5cb21a68bfbccc8e453 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_acd5a71c16dadade090a20f51ace1879264b15a93e6cc5cb21a68bfbccc8e453->enter($__internal_acd5a71c16dadade090a20f51ace1879264b15a93e6cc5cb21a68bfbccc8e453_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        // line 118
        echo "            ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
        ";
        
        $__internal_acd5a71c16dadade090a20f51ace1879264b15a93e6cc5cb21a68bfbccc8e453->leave($__internal_acd5a71c16dadade090a20f51ace1879264b15a93e6cc5cb21a68bfbccc8e453_prof);

    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:Default:messagebox.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  330 => 118,  324 => 117,  313 => 111,  309 => 109,  300 => 106,  296 => 105,  292 => 104,  286 => 103,  283 => 102,  279 => 101,  276 => 100,  272 => 98,  270 => 97,  266 => 95,  262 => 93,  256 => 92,  250 => 89,  246 => 88,  242 => 87,  236 => 86,  233 => 85,  227 => 82,  223 => 81,  219 => 80,  213 => 79,  210 => 78,  207 => 77,  203 => 76,  200 => 75,  196 => 73,  194 => 72,  190 => 70,  179 => 60,  173 => 58,  171 => 57,  165 => 53,  161 => 50,  155 => 49,  145 => 46,  139 => 45,  129 => 120,  127 => 117,  124 => 116,  122 => 49,  119 => 48,  116 => 45,  91 => 22,  84 => 18,  80 => 17,  76 => 16,  72 => 15,  68 => 14,  63 => 12,  56 => 7,  49 => 5,  46 => 4,  43 => 3,  39 => 2,  37 => 1,  14 => 44,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% set unread = 0 %}
{% for message in user.messagesReceived %}
    {% if message.read == false %}
        {% set unread = unread + 1 %}
    {% endif %}
{% endfor %}

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        <link rel=\"shortcut icon\" href=\"{{ asset('favicon.ico') }}\" />
        <title>Your messagebox :: project O-GIS</title>
        <link rel=\"stylesheet\" href=\"{{ asset('./css/ogis_styles.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./js/jquery/themes/default/style.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./js/jquery-ui/jquery-ui.css') }}\" />
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery/jquery-2.min.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery-ui/jquery-ui.min.js') }}\"></script>
        
        <script type=\"text/javascript\">
            
            function returnToProfile(){ window.location.href = \"{{ path('showuser', {'id': user.id}) }}\"; }
            
            function switchTabs(id){
                var data_tabs = [\"inbox_tab\", \"outbox_tab\"];
                var select_tabs = [\"inbox_sel\", \"outbox_sel\"];
                for (var i = 0; i < 2; i++){
                    if (i === id){
                        \$('#' + data_tabs[i]).css('display', 'block');
                        document.getElementById(select_tabs[i]).setAttribute('class', 'objectlinkselected userprofilelinkbox');
                    }
                    else{
                        \$('#' + data_tabs[i]).css('display', 'none');
                        document.getElementById(select_tabs[i]).setAttribute('class', 'objectlink userprofilelinkbox');
                    }
                }
            }
            
        </script>
        
    </head>
    
    <body class=\"bodyfullpage\">
        {% use 'OGISIndexBundle:Default:header.html.twig' %}
        {% block header %}
            {{ parent() }}
        {% endblock %}

        {% block pagecontent %}
            
            <div class=\"contentbody\">
                {# leftpanel #}
                <div class=\"userpageleftside\">
                    <div>
                        <div class=\"userprofilelinkbox objectlinkselected\" id=\"inbox_sel\" onclick=\"switchTabs(0);\">
                            Inbox
                            {% if unread > 0 %}
                                &nbsp;({{unread}})
                            {% endif %}
                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"outbox_sel\" onclick=\"switchTabs(1);\">
                            Outbox
                        </div>
                        <div class=\"userprofilelinkbox objectlink\" onclick=\"returnToProfile();\">
                            Back to profile
                        </div>
                    </div>
                </div>
                {# rightside #}
                <div class=\"userpagerightside\">
                    <div id=\"inbox_tab\" class=\"userfilesareafullside\" style=\"display:block;\">
                        {% if user.messagesReceived|length == 0 %}
                            <center><br/><b>No messages in the inbox!</b></center>
                        {% else %}
                            <div class=\"internalboxcontainer\">
                                {% for message in user.messagesReceived %}
                                    {% if message.read == true %}
                                        <div class=\"messagecontainer\">
                                            <b><a href=\"{{ path('viewmessage', {'id': message.id}) }}\">{{ message.subject }}</a></b> from&nbsp;
                                            <a href=\"{{ path('showuser', {'id': message.sender.id}) }}\" target=\"_blank\">
                                                {{ message.sender.displayname }}
                                            </a>&nbsp;( {{ message.sent|date('H:i:s d.m.Y') }} )
                                        </div>
                                    {% else %}
                                        <div class=\"messagecontainernew\">
                                            <b><a href=\"{{ path('viewmessage', {'id': message.id}) }}\">{{ message.subject }}</a></b> from&nbsp;
                                            <a href=\"{{ path('showuser', {'id': message.sender.id}) }}\" target=\"_blank\">
                                                {{ message.sender.displayname }}
                                            </a>&nbsp;( {{ message.sent|date('H:i:s d.m.Y') }} )
                                        </div>
                                    {% endif %}
                                {% endfor %}
                            </div>
                        {% endif %}
                    </div>
                    <div id=\"outbox_tab\" class=\"userfilesareafullside\" style=\"display:none;\">
                        {% if user.messagesSent|length == 0 %}
                            <center><br/><b>No messages in the outbox!</b></center>
                        {% else %}
                            <div style=\"width:100%;height:100%;padding-left:10px;padding-right:10px;padding-top:6px;padding-bottom:6px;overflow-y:scroll;\">
                                {% for message in user.messagesSent %}
                                    <div class=\"messagecontainer\">
                                        <b><a href=\"{{ path('viewmessage', {'id': message.id}) }}\">{{ message.subject }}</a></b> to&nbsp;
                                        <a href=\"{{ path('showuser', {'id': message.addressee.id}) }}\" target=\"_blank\">
                                            {{ message.addressee.displayname }}
                                        </a>&nbsp;( {{ message.sent|date('H:i:s d.m.Y') }} )
                                    </div>
                                {% endfor %}
                            </div>
                        {% endif %}
                    </div>
                </div>
            </div>
            
        {% endblock %}
        
        {% block footer %}
            {{ parent() }}
        {% endblock %}
        
    </body>
</html>
", "OGISIndexBundle:Default:messagebox.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/Default/messagebox.html.twig");
    }
}
