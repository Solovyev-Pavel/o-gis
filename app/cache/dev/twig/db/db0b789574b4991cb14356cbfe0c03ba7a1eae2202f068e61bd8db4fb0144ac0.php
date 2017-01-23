<?php

/* OGISIndexBundle:Lists:userlist.html.twig */
class __TwigTemplate_913df1203b64f55a0f9dd36e11e4a2efb9cde450b9ee4d1784291edb8e15d72a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("OGISIndexBundle:Default:header.html.twig", "OGISIndexBundle:Lists:userlist.html.twig", 82);
        // line 82
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
        $__internal_26591572af26faa5957babe6ecaf5552167c06a7b874e7dee310137bb47463a4 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_26591572af26faa5957babe6ecaf5552167c06a7b874e7dee310137bb47463a4->enter($__internal_26591572af26faa5957babe6ecaf5552167c06a7b874e7dee310137bb47463a4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "OGISIndexBundle:Lists:userlist.html.twig"));

        // line 1
        echo "<html>
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
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        <title>project O-GIS users</title>
        <link rel=\"stylesheet\" href=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/ogis_styles.css"), "html", null, true);
        echo "\" />
        <style>
            .userblock{
                width: 32%;
                display: inline-block;
                border: 1px solid #ccc;
                margin-right: 10px;
                margin-bottom: 10px;
            }
        </style>
        <script type=\"text/javascript\" src=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/jquery-2.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\">
            var page = 1;
            
            function GetUserListItems(pagechange){
                var url = '";
        // line 39
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("userlistitems");
        echo "';
                var ordering = document.getElementById('orderingselector').value;
                var order = document.getElementById('orderselector').value;
                //var group = document.getElementById('groupselector').value;
                var group = '1,2,3,4,5';
                var nextpage = (pagechange === 0) ? 1 : page + pagechange;
                var finurl = url + '?ordering=' + ordering + '&order=' + order + '&group=' + group + '&page=' + nextpage;
                \$.ajax(finurl)
                        .done(function(msg){
                            page = msg.cpage;
                            \$('#prevpagelink').empty();
                            \$('#nextpagelink').empty();
                            if (msg.cpage > 1){ \$('#prevpagelink').append('<a href=\"#\" onclick=\"GetUserListItems(-1)\"><< Previous page</a>'); }
                            else{ \$('#prevpagelink').append('&nbsp;'); }
                            if (msg.cpage < msg.tpages){ \$('#nextpagelink').append('<a href=\"#\" onclick=\"GetUserListItems(1)\">Next page >></a>'); }
                            else{ \$('#prevpagelink').append('&nbsp;'); }
                            var html = '';
                            for(var i = 0; i < msg.users.length; i++){
                                html +=     '<div class=\"userblock\"><table widht=\"100%\"><tr><td><img src=\"./img/icons/user.png\"/>&nbsp;' +
                                            '<a href=\"./app.php/user/' +
                                            msg.users[i].id + '\" target=\"_blank\"><b style=\"font-size:18px\">' + msg.users[i].name +
                                            '</b></a></td></tr><tr><td>';
                                switch(msg.users[i].role){
                                    case 1:     html += 'Project O-GIS system user'; break;
                                    case 2:     html += 'Project O-GIS administrator'; break;
                                    case 3:     html += 'Project O-GIS moderator'; break;
                                    case 4:     html += 'Project O-GIS user'; break;
                                    case 5:     html += 'Project O-GIS user'; break
                                }
                                html += '</td></tr></table></div>';
                            }
                            \$('#listcontents').empty().append(html);
                        })
                        .fail(function(){
                            var html = '<div class=\"loaderrormsg\"><b>Error while loading user list!</b></div>';
                            \$('#listcontents').empty().append(html);
                        });
            }
        </script>
    </head>
    
    <body class=\"bodyfullpage\" onload=\"GetUserListItems(0);\">

        ";
        // line 83
        echo "        ";
        $this->displayBlock('header', $context, $blocks);
        // line 86
        echo "
        ";
        // line 87
        $this->displayBlock('pagecontent', $context, $blocks);
        // line 136
        echo "        
        ";
        // line 137
        $this->displayBlock('footer', $context, $blocks);
        // line 140
        echo "    </body>
</html>
";
        
        $__internal_26591572af26faa5957babe6ecaf5552167c06a7b874e7dee310137bb47463a4->leave($__internal_26591572af26faa5957babe6ecaf5552167c06a7b874e7dee310137bb47463a4_prof);

    }

    // line 83
    public function block_header($context, array $blocks = array())
    {
        $__internal_f882a24dd32d0ce97f3dc48f4648fc18f5fd7406a7c622e5f659f6b1c42f48cd = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_f882a24dd32d0ce97f3dc48f4648fc18f5fd7406a7c622e5f659f6b1c42f48cd->enter($__internal_f882a24dd32d0ce97f3dc48f4648fc18f5fd7406a7c622e5f659f6b1c42f48cd_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        // line 84
        echo "            ";
        $this->displayParentBlock("header", $context, $blocks);
        echo "
        ";
        
        $__internal_f882a24dd32d0ce97f3dc48f4648fc18f5fd7406a7c622e5f659f6b1c42f48cd->leave($__internal_f882a24dd32d0ce97f3dc48f4648fc18f5fd7406a7c622e5f659f6b1c42f48cd_prof);

    }

    // line 87
    public function block_pagecontent($context, array $blocks = array())
    {
        $__internal_bb4bb2a6c2aca39aba820eae543997158f396d5cbbc463496a88cc4d1037f9cf = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_bb4bb2a6c2aca39aba820eae543997158f396d5cbbc463496a88cc4d1037f9cf->enter($__internal_bb4bb2a6c2aca39aba820eae543997158f396d5cbbc463496a88cc4d1037f9cf_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "pagecontent"));

        // line 88
        echo "            <div class=\"contentbody\">
                <!-- параметры поиска -->
                <table width=\"100%\" style=\"border-left:1px solid #ccc;border-right:1px solid #ccc;border-top:1px solid #ccc;\">
                    <tr>
                        <td colspan=\"5\"><center><h3>Project <b style=\"color:#4040af;\">O-GIS</b> users</h3></center></td>
                    </tr>
                    <tr>
                        <td width=\"200px\"><b>Sort by</b>:</td>
                        <td width=\"300px\">
                            <select id=\"orderingselector\" style=\"width:100%;\" onchange=\"GetUserListItems(0);\">
                                <option value=\"id\">Date joined</option>
                                <option value=\"displayname\">Username</option>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td width=\"150px\"><b>Order by</b>:</td>
                        <td width=\"300px\">
                            <select id=\"orderselector\" style=\"width:100%;\" onchange=\"GetUserListItems(0);\">
                                <option value=\"ASC\">A → Z</option>
                                <option value=\"DESC\">Z → A</option>
                            </select>
                        </td>
                    </tr>
<!--                    <tr>
                        <td><b>Category</b>:</td>
                        <td>
                            <select id=\"groupselector\" style=\"width:100%;\" onchange=\"GetUserListItems(0);\">
                                <option value=\"1,2,3,4,5\">Any</option>
                                <option value=\"4,5\">Project O-GIS users</option>
                                <option value=\"1,2,3\">Project O-GIS moderators</option>
                                <option value=\"1,2,3\">Project O-GIS administration</option>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr> -->
                </table>
                <table width=\"100%\" style=\"margin-bottom:10px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;\">
                    <tr>
                        <td id=\"prevpagelink\" width=\"50%\">&nbsp;</td>
                        <td id=\"nextpagelink\">&nbsp;</td>
                    </tr>
                </table>
                
                <div id=\"listcontents\"></div>
            </div>
        ";
        
        $__internal_bb4bb2a6c2aca39aba820eae543997158f396d5cbbc463496a88cc4d1037f9cf->leave($__internal_bb4bb2a6c2aca39aba820eae543997158f396d5cbbc463496a88cc4d1037f9cf_prof);

    }

    // line 137
    public function block_footer($context, array $blocks = array())
    {
        $__internal_ab4f6fc587e30c30d3d4cf93cfee0fdcfe383b9bc491b1db8378002a88921ff5 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ab4f6fc587e30c30d3d4cf93cfee0fdcfe383b9bc491b1db8378002a88921ff5->enter($__internal_ab4f6fc587e30c30d3d4cf93cfee0fdcfe383b9bc491b1db8378002a88921ff5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        // line 138
        echo "            ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
        ";
        
        $__internal_ab4f6fc587e30c30d3d4cf93cfee0fdcfe383b9bc491b1db8378002a88921ff5->leave($__internal_ab4f6fc587e30c30d3d4cf93cfee0fdcfe383b9bc491b1db8378002a88921ff5_prof);

    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:Lists:userlist.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  236 => 138,  230 => 137,  176 => 88,  170 => 87,  160 => 84,  154 => 83,  145 => 140,  143 => 137,  140 => 136,  138 => 87,  135 => 86,  132 => 83,  86 => 39,  78 => 34,  65 => 24,  60 => 22,  37 => 1,  14 => 82,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<html>
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
        <title>project O-GIS users</title>
        <link rel=\"stylesheet\" href=\"{{ asset('./css/ogis_styles.css') }}\" />
        <style>
            .userblock{
                width: 32%;
                display: inline-block;
                border: 1px solid #ccc;
                margin-right: 10px;
                margin-bottom: 10px;
            }
        </style>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery/jquery-2.min.js') }}\"></script>
        <script type=\"text/javascript\">
            var page = 1;
            
            function GetUserListItems(pagechange){
                var url = '{{ path('userlistitems') }}';
                var ordering = document.getElementById('orderingselector').value;
                var order = document.getElementById('orderselector').value;
                //var group = document.getElementById('groupselector').value;
                var group = '1,2,3,4,5';
                var nextpage = (pagechange === 0) ? 1 : page + pagechange;
                var finurl = url + '?ordering=' + ordering + '&order=' + order + '&group=' + group + '&page=' + nextpage;
                \$.ajax(finurl)
                        .done(function(msg){
                            page = msg.cpage;
                            \$('#prevpagelink').empty();
                            \$('#nextpagelink').empty();
                            if (msg.cpage > 1){ \$('#prevpagelink').append('<a href=\"#\" onclick=\"GetUserListItems(-1)\"><< Previous page</a>'); }
                            else{ \$('#prevpagelink').append('&nbsp;'); }
                            if (msg.cpage < msg.tpages){ \$('#nextpagelink').append('<a href=\"#\" onclick=\"GetUserListItems(1)\">Next page >></a>'); }
                            else{ \$('#prevpagelink').append('&nbsp;'); }
                            var html = '';
                            for(var i = 0; i < msg.users.length; i++){
                                html +=     '<div class=\"userblock\"><table widht=\"100%\"><tr><td><img src=\"./img/icons/user.png\"/>&nbsp;' +
                                            '<a href=\"./app.php/user/' +
                                            msg.users[i].id + '\" target=\"_blank\"><b style=\"font-size:18px\">' + msg.users[i].name +
                                            '</b></a></td></tr><tr><td>';
                                switch(msg.users[i].role){
                                    case 1:     html += 'Project O-GIS system user'; break;
                                    case 2:     html += 'Project O-GIS administrator'; break;
                                    case 3:     html += 'Project O-GIS moderator'; break;
                                    case 4:     html += 'Project O-GIS user'; break;
                                    case 5:     html += 'Project O-GIS user'; break
                                }
                                html += '</td></tr></table></div>';
                            }
                            \$('#listcontents').empty().append(html);
                        })
                        .fail(function(){
                            var html = '<div class=\"loaderrormsg\"><b>Error while loading user list!</b></div>';
                            \$('#listcontents').empty().append(html);
                        });
            }
        </script>
    </head>
    
    <body class=\"bodyfullpage\" onload=\"GetUserListItems(0);\">

        {% use 'OGISIndexBundle:Default:header.html.twig' %}
        {% block header %}
            {{ parent() }}
        {% endblock %}

        {% block pagecontent %}
            <div class=\"contentbody\">
                <!-- параметры поиска -->
                <table width=\"100%\" style=\"border-left:1px solid #ccc;border-right:1px solid #ccc;border-top:1px solid #ccc;\">
                    <tr>
                        <td colspan=\"5\"><center><h3>Project <b style=\"color:#4040af;\">O-GIS</b> users</h3></center></td>
                    </tr>
                    <tr>
                        <td width=\"200px\"><b>Sort by</b>:</td>
                        <td width=\"300px\">
                            <select id=\"orderingselector\" style=\"width:100%;\" onchange=\"GetUserListItems(0);\">
                                <option value=\"id\">Date joined</option>
                                <option value=\"displayname\">Username</option>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td width=\"150px\"><b>Order by</b>:</td>
                        <td width=\"300px\">
                            <select id=\"orderselector\" style=\"width:100%;\" onchange=\"GetUserListItems(0);\">
                                <option value=\"ASC\">A → Z</option>
                                <option value=\"DESC\">Z → A</option>
                            </select>
                        </td>
                    </tr>
<!--                    <tr>
                        <td><b>Category</b>:</td>
                        <td>
                            <select id=\"groupselector\" style=\"width:100%;\" onchange=\"GetUserListItems(0);\">
                                <option value=\"1,2,3,4,5\">Any</option>
                                <option value=\"4,5\">Project O-GIS users</option>
                                <option value=\"1,2,3\">Project O-GIS moderators</option>
                                <option value=\"1,2,3\">Project O-GIS administration</option>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr> -->
                </table>
                <table width=\"100%\" style=\"margin-bottom:10px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;\">
                    <tr>
                        <td id=\"prevpagelink\" width=\"50%\">&nbsp;</td>
                        <td id=\"nextpagelink\">&nbsp;</td>
                    </tr>
                </table>
                
                <div id=\"listcontents\"></div>
            </div>
        {% endblock %}
        
        {% block footer %}
            {{ parent() }}
        {% endblock %}
    </body>
</html>
", "OGISIndexBundle:Lists:userlist.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/Lists/userlist.html.twig");
    }
}
