<?php

/* OGISIndexBundle:Edit:editusernotes.html.twig */
class __TwigTemplate_09c67f3e7ef560bc15d53400848ab588ced2bfd84af7ad5b4a4db8b5541f627c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("OGISIndexBundle:Default:header.html.twig", "OGISIndexBundle:Edit:editusernotes.html.twig", 55);
        // line 55
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
        $__internal_4f6da4dd7f365c2c52d6046e8f644ac86e65c01a4fecfe4f9846652e7ba70771 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_4f6da4dd7f365c2c52d6046e8f644ac86e65c01a4fecfe4f9846652e7ba70771->enter($__internal_4f6da4dd7f365c2c52d6046e8f644ac86e65c01a4fecfe4f9846652e7ba70771_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "OGISIndexBundle:Edit:editusernotes.html.twig"));

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
        <title>Editing notes for user \"";
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
        echo "\"</title>
        <script type=\"text/javascript\" src=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/ckeditor/ckeditor.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\">
            var isDirty = false;
            var isSubmit = false;
            
            function MarkAsDirty(){ isDirty = true; }
            function MarkAsSubmit(){ isSubmit = true; }
            
            window.onload = function(){
                window.addEventListener('beforeunload', function(e){
                    if (isSubmit || !isDirty){ return undefined; }
                    var msg = \"Are you sure you want to leave this page without saving changes?\";
                    (e || window.event).returnValue = msg;
                    return msg;
                });
            };
            
            function resetValues(){
                CKEDITOR.instances.projectmessageboard.setData(document.getElementById(\"messageboard_backup\").value);
                isDirty = false;
            }

            function goBackToProfile(){
                window.location.href = \"";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showuser", array("id" => $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "id", array()))), "html", null, true);
        echo "\";
            }
        </script>
    </head>

    <body style=\"width:100%; position:absolute; top:-8px; left:-8px;\">

        ";
        // line 56
        echo "        ";
        $this->displayBlock('header', $context, $blocks);
        // line 59
        echo "
        ";
        // line 60
        $this->displayBlock('bodycontent', $context, $blocks);
        // line 92
        echo "
        ";
        // line 93
        $this->displayBlock('footer', $context, $blocks);
        // line 96
        echo "    </body>
</html>
";
        
        $__internal_4f6da4dd7f365c2c52d6046e8f644ac86e65c01a4fecfe4f9846652e7ba70771->leave($__internal_4f6da4dd7f365c2c52d6046e8f644ac86e65c01a4fecfe4f9846652e7ba70771_prof);

    }

    // line 56
    public function block_header($context, array $blocks = array())
    {
        $__internal_355c6e1edecda7b2dc721cc3eacb2391dc303274d23b440a91dd8c597d7b521a = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_355c6e1edecda7b2dc721cc3eacb2391dc303274d23b440a91dd8c597d7b521a->enter($__internal_355c6e1edecda7b2dc721cc3eacb2391dc303274d23b440a91dd8c597d7b521a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        // line 57
        echo "            ";
        $this->displayParentBlock("header", $context, $blocks);
        echo "
        ";
        
        $__internal_355c6e1edecda7b2dc721cc3eacb2391dc303274d23b440a91dd8c597d7b521a->leave($__internal_355c6e1edecda7b2dc721cc3eacb2391dc303274d23b440a91dd8c597d7b521a_prof);

    }

    // line 60
    public function block_bodycontent($context, array $blocks = array())
    {
        $__internal_533dc345bc035fbceed5a40cc4c55d9be61825f02287188dff4c679f87d94ba3 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_533dc345bc035fbceed5a40cc4c55d9be61825f02287188dff4c679f87d94ba3->enter($__internal_533dc345bc035fbceed5a40cc4c55d9be61825f02287188dff4c679f87d94ba3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "bodycontent"));

        // line 61
        echo "            <form onsubmit=\"MarkAsSubmit();\" method=\"post\" action=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("usernotes", array("id" => $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "id", array()))), "html", null, true);
        echo "\" id=\"usernotesform\">
            <div style=\"width:80%;margin-left:auto;margin-right:auto;margin-top:16px;margin-bottom:8px;padding:4px;\">
                <table style=\"width:100%;border:1px solid #ccc;margin-bottom:8px;\">
                    <tr>
                        <td>
                            <b>Публикуемая информация:</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea style=\"display:none;\" id=\"messageboard_backup\">";
        // line 71
        echo $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messageboard", array());
        echo "</textarea>
                            <textarea style=\"width:calc(100% - 20px);resize:none;\" id=\"usermessageboard\" name=\"_projectwall\" form=\"usernotesform\">";
        // line 72
        echo $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messageboard", array());
        echo "</textarea>
                            <script type=\"text/javascript\">
                                CKEDITOR.config.height = window.innerHeight - 250;
                                CKEDITOR.replace('usermessageboard', {
                                    toolbar: [
                                        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike' ] },
                                        { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
                                        { name: 'links', items : [ 'Link','Unlink' ] }                                        
                                    ]
                                }).on('change', function(ev){ isDirty = true; });
                            </script>
                        </td>
                    </tr>
                </table>
                <input type=\"submit\" value=\"Apply changes\"/>&nbsp;
            </form>
                <button type=\"button\" onclick=\"resetValues();\">Undo changes</button>&nbsp;
                <button type=\"button\" onclick=\"goBackToProfile();\">Go back to ";
        // line 89
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "displayname", array()), "html", null, true);
        echo "'s profile</button>
            </div>
        ";
        
        $__internal_533dc345bc035fbceed5a40cc4c55d9be61825f02287188dff4c679f87d94ba3->leave($__internal_533dc345bc035fbceed5a40cc4c55d9be61825f02287188dff4c679f87d94ba3_prof);

    }

    // line 93
    public function block_footer($context, array $blocks = array())
    {
        $__internal_a78e25f74052e781a10dabed360f5f8ab59f26c1ee414733e55bf8514170b50f = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_a78e25f74052e781a10dabed360f5f8ab59f26c1ee414733e55bf8514170b50f->enter($__internal_a78e25f74052e781a10dabed360f5f8ab59f26c1ee414733e55bf8514170b50f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        // line 94
        echo "            ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
        ";
        
        $__internal_a78e25f74052e781a10dabed360f5f8ab59f26c1ee414733e55bf8514170b50f->leave($__internal_a78e25f74052e781a10dabed360f5f8ab59f26c1ee414733e55bf8514170b50f_prof);

    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:Edit:editusernotes.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  203 => 94,  197 => 93,  187 => 89,  167 => 72,  163 => 71,  149 => 61,  143 => 60,  133 => 57,  127 => 56,  118 => 96,  116 => 93,  113 => 92,  111 => 60,  108 => 59,  105 => 56,  95 => 48,  69 => 25,  65 => 24,  61 => 23,  37 => 1,  14 => 55,);
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
        <title>Editing notes for user \"{{ user.username }}\"</title>
        <script type=\"text/javascript\" src=\"{{ asset('./js/ckeditor/ckeditor.js') }}\"></script>
        <script type=\"text/javascript\">
            var isDirty = false;
            var isSubmit = false;
            
            function MarkAsDirty(){ isDirty = true; }
            function MarkAsSubmit(){ isSubmit = true; }
            
            window.onload = function(){
                window.addEventListener('beforeunload', function(e){
                    if (isSubmit || !isDirty){ return undefined; }
                    var msg = \"Are you sure you want to leave this page without saving changes?\";
                    (e || window.event).returnValue = msg;
                    return msg;
                });
            };
            
            function resetValues(){
                CKEDITOR.instances.projectmessageboard.setData(document.getElementById(\"messageboard_backup\").value);
                isDirty = false;
            }

            function goBackToProfile(){
                window.location.href = \"{{ path('showuser', {id: user.id}) }}\";
            }
        </script>
    </head>

    <body style=\"width:100%; position:absolute; top:-8px; left:-8px;\">

        {% use 'OGISIndexBundle:Default:header.html.twig' %}
        {% block header %}
            {{ parent() }}
        {% endblock %}

        {% block bodycontent %}
            <form onsubmit=\"MarkAsSubmit();\" method=\"post\" action=\"{{ path('usernotes', {id: user.id}) }}\" id=\"usernotesform\">
            <div style=\"width:80%;margin-left:auto;margin-right:auto;margin-top:16px;margin-bottom:8px;padding:4px;\">
                <table style=\"width:100%;border:1px solid #ccc;margin-bottom:8px;\">
                    <tr>
                        <td>
                            <b>Публикуемая информация:</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea style=\"display:none;\" id=\"messageboard_backup\">{{ user.messageboard|raw }}</textarea>
                            <textarea style=\"width:calc(100% - 20px);resize:none;\" id=\"usermessageboard\" name=\"_projectwall\" form=\"usernotesform\">{{ user.messageboard|raw }}</textarea>
                            <script type=\"text/javascript\">
                                CKEDITOR.config.height = window.innerHeight - 250;
                                CKEDITOR.replace('usermessageboard', {
                                    toolbar: [
                                        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike' ] },
                                        { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
                                        { name: 'links', items : [ 'Link','Unlink' ] }                                        
                                    ]
                                }).on('change', function(ev){ isDirty = true; });
                            </script>
                        </td>
                    </tr>
                </table>
                <input type=\"submit\" value=\"Apply changes\"/>&nbsp;
            </form>
                <button type=\"button\" onclick=\"resetValues();\">Undo changes</button>&nbsp;
                <button type=\"button\" onclick=\"goBackToProfile();\">Go back to {{ user.displayname}}'s profile</button>
            </div>
        {% endblock %}

        {% block footer %}
            {{ parent() }}
        {% endblock %}
    </body>
</html>
", "OGISIndexBundle:Edit:editusernotes.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/Edit/editusernotes.html.twig");
    }
}
