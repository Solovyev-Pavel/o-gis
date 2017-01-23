<?php

/* OGISIndexBundle:Objects:user.html.twig */
class __TwigTemplate_f9096ac7c0f5e9435c2947006cf5437926ca594154e2888893274e2cc90fe067 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("OGISIndexBundle:Default:header.html.twig", "OGISIndexBundle:Objects:user.html.twig", 128);
        // line 128
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
        $__internal_c5f3308fbdc6ca962666f58c62f0f469e0d5212e1349c99fab2e3e194855e668 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_c5f3308fbdc6ca962666f58c62f0f469e0d5212e1349c99fab2e3e194855e668->enter($__internal_c5f3308fbdc6ca962666f58c62f0f469e0d5212e1349c99fab2e3e194855e668_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "OGISIndexBundle:Objects:user.html.twig"));

        // line 1
        $context["is_owner"] = false;
        // line 2
        if (($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()) != null)) {
            // line 3
            echo "    ";
            if (($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "id", array()) == $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "id", array()))) {
                // line 4
                echo "        ";
                $context["is_owner"] = true;
                // line 5
                echo "        ";
                $context["unread"] = 0;
                // line 6
                echo "        ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messagesReceived", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                    // line 7
                    echo "            ";
                    if (($this->getAttribute($context["message"], "read", array()) == false)) {
                        // line 8
                        echo "                ";
                        $context["unread"] = ((isset($context["unread"]) ? $context["unread"] : $this->getContext($context, "unread")) + 1);
                        // line 9
                        echo "            ";
                    }
                    // line 10
                    echo "        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 11
                echo "    ";
            }
        }
        // line 13
        echo "
<!DOCTYPE html>
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
        // line 36
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        <title>";
        // line 37
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
        echo " :: project O-GIS</title>
        <link rel=\"stylesheet\" href=\"";
        // line 38
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/ogis_styles.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 39
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/jstree-types.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 40
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/themes/default/style.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 41
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-ui/jquery-ui.css"), "html", null, true);
        echo "\" />
        <script type=\"text/javascript\" src=\"";
        // line 42
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/jquery-2.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 43
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/jstree.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-ui/jquery-ui.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 45
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/catalogTree.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 46
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/treeContextMenu.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/addtofavorites.js"), "html", null, true);
        echo "\"></script>

        <script type=\"text/javascript\">
            ";
        // line 50
        if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
            // line 51
            echo "                function RedirectToEditNotes(){ window.location.href = \"";
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("usernotes", array("id" => $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "id", array()))), "html", null, true);
            echo "\"; }
                function redirectToLayerUpload(){ window.location.href = \"";
            // line 52
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("createlayer");
            echo "\"; }
                function redirectToCmpEditor(){ window.location.href = \"";
            // line 53
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("compositioneditor");
            echo "\"; }
                function redirectToStyleCreation(){ window.location.href = \"";
            // line 54
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("createstyle");
            echo "\"; }
                function redirectToCreateProject(){ window.location.href = \"";
            // line 55
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("createproject");
            echo "\"; }
                function redirectToPaletteCreation(){ window.location.href = \"";
            // line 56
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("paletteeditor", array("id" => null));
            echo "\"; }
                function goToMessagebox(){ window.location.href = \"";
            // line 57
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("usermessages");
            echo "\" }
            ";
        }
        // line 59
        echo "
            var homepage = \"";
        // line 60
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("homepage");
        echo "\";
            var catalogData = \"";
        // line 61
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("loadcatalogdata", array("catid" => "PATH"));
        echo "\";
            var rootNodes = \"";
        // line 62
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("loadusercatalogs", array("holderid" => $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "id", array()))), "html", null, true);
        echo "\";
            ";
        // line 63
        if (($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()) != null)) {
            // line 64
            echo "                var rootFavNodes = \"";
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("loadusercatalogs", array("holderid" => $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "id", array()))), "html", null, true);
            echo "\";
                var editCatalogRoute = \"";
            // line 65
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("editcatalog", array("id" => "ID"));
            echo "\";
                var cutPasteRoute = \"";
            // line 66
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("movecatalogentity");
            echo "\";
            ";
        }
        // line 68
        echo "            var saveCatalogRoute = \"";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("savecatalog");
        echo "\";
            var deleteCatalogRoute = \"";
        // line 69
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("deletecatalog", array("id" => "ID"));
        echo "\";
            var modifyLinkRoute = \"";
        // line 70
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("updatelink");
        echo "\";
            var deleteLinkRoute = \"";
        // line 71
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("removefromfavorites", array("id" => "ID"));
        echo "\";
            var addToFavRoute = \"";
        // line 72
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("addtofavorites");
        echo "\";
            
            function switchTabs(id){
                var data_tabs = [\"user_tab\",\"notes_tab\",\"layer_tab\",\"cmp_tab\",\"palette_tab\",\"proj_tab\"];
                var select_tabs = [\"user_sel\",\"notes_sel\",\"layer_sel\",\"cmp_sel\",\"palette_sel\",\"proj_sel\"];
                for (var i = 0; i < 6; i++){
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
            
            function ShowSendMessageDialog(){ \$( \"#writemessage\" ).dialog('open'); }
            
            function sendMessageToUser(){
                var user_id = ";
        // line 92
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "id", array()), "html", null, true);
        echo "
                var subject = document.getElementById('message_subject').value;
                var body = document.getElementById('message_body').value;
                var url = \"";
        // line 95
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("sendmessage");
        echo "\";
                url += '?addressee=' + user_id + '&subject=' + subject + '&body=' + body;
                \$.ajax({
                    url: url,
                    method: 'POST'
                }).done(function(response){
                    if (!response.success){
                        var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">' + response.message + '</td></tr></table>';
                        \$( \"#messagewindow\" ).dialog('option', 'title', 'Sending Message');
                        \$( \"#messagewindow\" ).empty();
                        \$( \"#messagewindow\" ).append(html);
                        \$( \"#messagewindow\" ).dialog(\"open\");
                    }
                    else {
                        var html = '<table><tr><td width=\"64px\"><img src=\"./img/ok.png\"/></td><td valign=\"middle\">' + response.message + '</td></tr></table>';
                        \$( \"#messagewindow\" ).dialog('option', 'title', 'Sending Message');
                        \$( \"#messagewindow\" ).empty();
                        \$( \"#messagewindow\" ).append(html);
                        \$( \"#messagewindow\" ).dialog(\"open\");
                    }
                }).fail(function(){
                    var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">Unknown error while sending your message!</td></tr></table>';
                    \$( \"#messagewindow\" ).dialog('option', 'title', 'Sending Message');
                    \$( \"#messagewindow\" ).empty();
                    \$( \"#messagewindow\" ).append(html);
                    \$( \"#messagewindow\" ).dialog(\"open\");
                });
            }
            
        </script>
    </head>
    <body class=\"bodyfullpage\" onload=\"loadUserCatalogs();\">

        ";
        // line 129
        echo "        ";
        $this->displayBlock('header', $context, $blocks);
        // line 132
        echo "
        ";
        // line 133
        $this->displayBlock('pagecontent', $context, $blocks);
        // line 472
        echo "            
        ";
        // line 473
        $this->displayBlock('footer', $context, $blocks);
        // line 476
        echo "    </body>
</html>
";
        
        $__internal_c5f3308fbdc6ca962666f58c62f0f469e0d5212e1349c99fab2e3e194855e668->leave($__internal_c5f3308fbdc6ca962666f58c62f0f469e0d5212e1349c99fab2e3e194855e668_prof);

    }

    // line 129
    public function block_header($context, array $blocks = array())
    {
        $__internal_981546045bad920b5ab225280083249dd6ed79d4fd536400d8d4d717a588425a = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_981546045bad920b5ab225280083249dd6ed79d4fd536400d8d4d717a588425a->enter($__internal_981546045bad920b5ab225280083249dd6ed79d4fd536400d8d4d717a588425a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        // line 130
        echo "            ";
        $this->displayParentBlock("header", $context, $blocks);
        echo "
        ";
        
        $__internal_981546045bad920b5ab225280083249dd6ed79d4fd536400d8d4d717a588425a->leave($__internal_981546045bad920b5ab225280083249dd6ed79d4fd536400d8d4d717a588425a_prof);

    }

    // line 133
    public function block_pagecontent($context, array $blocks = array())
    {
        $__internal_1d0f3a0bedf0fa6e259a61c6450ab35b05bd13ddc730dd7cd72fcbb9bfa12506 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_1d0f3a0bedf0fa6e259a61c6450ab35b05bd13ddc730dd7cd72fcbb9bfa12506->enter($__internal_1d0f3a0bedf0fa6e259a61c6450ab35b05bd13ddc730dd7cd72fcbb9bfa12506_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "pagecontent"));

        // line 134
        echo "            <div class=\"contentbody\">
                ";
        // line 136
        echo "                <div class=\"userpageleftside\">
                    <div class=\"useravatar\">
                        <center><img src=\"";
        // line 138
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./img/user.png"), "html", null, true);
        echo "\" height=\"200px\" width=\"200px\"></img></center>
                    </div>
                    <div>
                        ";
        // line 141
        if (($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()) != null)) {
            // line 142
            echo "                            ";
            if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
                // line 143
                echo "                                <div class=\"userprofilelinkbox objectlink\" onclick=\"goToMessagebox();\">
                                    Your messagebox
                                    ";
                // line 145
                if (((isset($context["unread"]) ? $context["unread"] : $this->getContext($context, "unread")) > 0)) {
                    // line 146
                    echo "                                        &nbsp;(";
                    echo twig_escape_filter($this->env, (isset($context["unread"]) ? $context["unread"] : $this->getContext($context, "unread")), "html", null, true);
                    echo ")
                                    ";
                }
                // line 148
                echo "                                </div>
                            ";
            } else {
                // line 150
                echo "                                <div class=\"userprofilelinkbox objectlink\" onclick=\"ShowSendMessageDialog();\">
                                    Send ";
                // line 151
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
                echo " a message
                                </div>
                            ";
            }
            // line 154
            echo "                        ";
        }
        // line 155
        echo "                        <div class=\"userprofilelinkbox objectlinkselected\" id=\"user_sel\" onclick=\"switchTabs(0);\">
                            User Info
                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"notes_sel\" onclick=\"switchTabs(1);\">
                            ";
        // line 159
        if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
            echo "Your Notes";
        } else {
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            echo "'s Notes";
        }
        // line 160
        echo "                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"layer_sel\" onclick=\"switchTabs(2);\">
                            ";
        // line 162
        if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
            echo "Your Layers";
        } else {
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            echo "'s Layers";
        }
        // line 163
        echo "                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"cmp_sel\" onclick=\"switchTabs(3);\">
                            ";
        // line 165
        if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
            echo "Your Compositions";
        } else {
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            echo "'s Compositions";
        }
        // line 166
        echo "                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"palette_sel\" onclick=\"switchTabs(4);\">
                            ";
        // line 168
        if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
            echo "Your Palettes";
        } else {
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            echo "'s Palettes";
        }
        // line 169
        echo "                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"proj_sel\" onclick=\"switchTabs(5);\">
                            Participation in Projects
                        </div>
                        ";
        // line 173
        if (((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner")) == false)) {
            // line 174
            echo "                            <div class=\"userprofilelinkbox objectlink\" onclick=\"showTargetCatalogTree(";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "id", array()), "html", null, true);
            echo ", 'user');\">Add User to Favorites</div>
                        ";
        }
        // line 176
        echo "                    </div>
                </div>
                ";
        // line 179
        echo "                <div class=\"userpagerightside\">
                    <div id=\"user_tab\" style=\"height:100%;display:block\">
                        <div class=\"usernamebox\">
                            <span class=\"username\">";
        // line 182
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "displayname", array()), "html", null, true);
        echo "</span><br/>
                            ";
        // line 183
        if (($this->getAttribute($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "limits", array()), "role", array()) == "ROLE_SUPER_ADMIN")) {
            // line 184
            echo "                                <i class=\"userroleadmin\">O-GIS Administrator</i>
                            ";
        } elseif (($this->getAttribute($this->getAttribute(        // line 185
(isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "limits", array()), "role", array()) == "ROLE_SYSTEM")) {
            // line 186
            echo "                                <i class=\"userroleadmin\">System User</i>
                            ";
        } elseif (($this->getAttribute($this->getAttribute(        // line 187
(isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "limits", array()), "role", array()) == "ROLE_ADMIN")) {
            // line 188
            echo "                                <i class=\"userrolemod\">O-GIS Moderator</i>
                            ";
        } else {
            // line 190
            echo "                                <i class=\"userrolebase\">O-GIS User</i>
                            ";
        }
        // line 192
        echo "                        </div>
                        <div class=\"userfilesarea\">
                            <div class=\"userfilesheader\" style=\"height:30px;padding-top:6px;\">User's resources</div>
                            <div class=\"foldertree\" id=\"foldertree\"></div>
                        </div>
                    </div>
                    <div id=\"notes_tab\" class=\"userfilesareafullside\" style=\"display:none;\">
                        <div class=\"userfilesheader\">
                            ";
        // line 200
        if (((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner")) || $this->env->getExtension('Symfony\Bridge\Twig\Extension\SecurityExtension')->isGranted("ROLE_ADMIN"))) {
            // line 201
            echo "                                <div class=\"biglink\" onclick=\"RedirectToEditNotes();\"><b>Edit notes</b></div>
                            ";
        } else {
            // line 203
            echo "                                <div style=\"height:30px;width:100%;padding-top:6px;\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            echo "'s Notes</div>
                            ";
        }
        // line 205
        echo "                        </div>
                        <div class=\"foldertree\">
                            ";
        // line 207
        if ((($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messageboard", array()) != null) && ($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messageboard", array()) != ""))) {
            // line 208
            echo "                                ";
            echo $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "messageboard", array());
            echo "
                            ";
        } else {
            // line 210
            echo "                                ";
            if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
                echo "You";
            } else {
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            }
            echo " made no notes.
                            ";
        }
        // line 212
        echo "                        </div>
                    </div>
                    <div id=\"layer_tab\"  class=\"userfilesareafullside\" style=\"display:none;\">
                        <div class=\"userfilesheader\">
                            ";
        // line 216
        if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
            // line 217
            echo "                                ";
            $context["layersleft"] = ($this->getAttribute($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "limits", array()), "layers", array()) - twig_length_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "layers", array())));
            // line 218
            echo "                                ";
            if (($this->getAttribute($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "limits", array()), "layers", array()) == null)) {
                // line 219
                echo "                                    <div class=\"biglink\" onclick=\"redirectToLayerUpload();\"><b>Upload a Layer</b></div>
                                ";
            } elseif ((            // line 220
(isset($context["layersleft"]) ? $context["layersleft"] : $this->getContext($context, "layersleft")) > 0)) {
                // line 221
                echo "                                    <div class=\"biglink\" onclick=\"redirectToLayerUpload();\"><b>Upload a Layer</b> (";
                echo twig_escape_filter($this->env, (isset($context["layersleft"]) ? $context["layersleft"] : $this->getContext($context, "layersleft")), "html", null, true);
                echo ")</div>
                                ";
            } elseif ((            // line 222
(isset($context["layersleft"]) ? $context["layersleft"] : $this->getContext($context, "layersleft")) <= 0)) {
                // line 223
                echo "                                    <div style=\"height:30px;width:100%;padding-top:6px;\">You've reached the max permitted number of layers</div>
                                ";
            }
            // line 225
            echo "                            ";
        } else {
            // line 226
            echo "                                <div style=\"height:30px;width:100%;padding-top:6px;\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            echo "'s Layers</div>
                            ";
        }
        // line 228
        echo "                        </div>
                        <div class=\"foldertree\">
                            ";
        // line 230
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "layers", array())) == 0)) {
            // line 231
            echo "                                ";
            if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
                echo "You";
            } else {
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            }
            echo " haven't uploaded any layers yet.
                            ";
        } else {
            // line 233
            echo "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_reverse_filter($this->env, twig_sort_filter($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "layers", array()))));
            foreach ($context['_seq'] as $context["_key"] => $context["layer"]) {
                // line 234
                echo "                                    <table class=\"listrow\">
                                        <tr>
                                            <td rowspan=\"3\" width=\"100px\" style=\"border:1px solid #aaa;background:#fff;\" valign=\"middle\">
                                                <a href=\"";
                // line 237
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showlayer", array("id" => $this->getAttribute($context["layer"], "id", array()))), "html", null, true);
                echo "\">
                                                        <img src=\"";
                // line 238
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl($this->getAttribute($context["layer"], "preview", array())), "html", null, true);
                echo "\" width=\"144px\"/>
                                                </a>
                                            </td>
                                            <td valign=\"top\" height=\"20px\" colspan=\"3\" style=\"font-size:18px;padding-left:16px;\">
                                                <a href=\"";
                // line 242
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showlayer", array("id" => $this->getAttribute($context["layer"], "id", array()))), "html", null, true);
                echo "\">
                                                <b>";
                // line 243
                echo twig_escape_filter($this->env, $this->getAttribute($context["layer"], "name", array()), "html", null, true);
                echo "</b></a>
                                                ";
                // line 244
                if ( !(isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
                    // line 245
                    echo "                                                    <span style=\"display:inline;font-size:14px;padding-left:16px\">
                                                        <a href=\"#\" onclick=\"showTargetCatalogTree(";
                    // line 246
                    echo twig_escape_filter($this->env, $this->getAttribute($context["layer"], "id", array()), "html", null, true);
                    echo ", 'layer');\">Add to favorites</a>
                                                    </span>
                                                ";
                }
                // line 249
                echo "                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign=\"top\" height=\"24px\" width=\"200px\" style=\"font-size:14px;padding-left:16px;\">
                                                <b>Last modified</b>:&nbsp;";
                // line 253
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["layer"], "modified", array()), "d.m.Y"), "html", null, true);
                echo "
                                            </td>
                                            <td valign=\"top\" height=\"24px\" width=\"150px\" style=\"font-size:14px;\">
                                                <b>Views</b>:&nbsp; ";
                // line 256
                echo twig_escape_filter($this->env, $this->getAttribute($context["layer"], "views", array()), "html", null, true);
                echo "
                                            </td>
                                            <td valign=\"top\" height=\"24px\" style=\"font-size:14px;\">
                                                <b>Downloads</b>:&nbsp; ";
                // line 259
                echo twig_escape_filter($this->env, $this->getAttribute($context["layer"], "downloads", array()), "html", null, true);
                echo "
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign=\"top\" colspan=\"3\" style=\"font-size:14px;padding-left:16px;\">
                                                <i>\"";
                // line 264
                echo twig_escape_filter($this->env, $this->getAttribute($context["layer"], "description", array()), "html", null, true);
                echo "\"</i>
                                            </td>
                                        </tr>
                                    </table>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['layer'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 269
            echo "                            ";
        }
        // line 270
        echo "                        </div>
                    </div>
                    <div id=\"cmp_tab\" class=\"userfilesareafullside\" style=\"display:none;\">
                        <div class=\"userfilesheader\">
                            ";
        // line 274
        if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
            // line 275
            echo "                                <div class=\"biglink\" onclick=\"redirectToCmpEditor();\"><b>Open Composition Editor</b></div>
                            ";
        } else {
            // line 277
            echo "                                <div style=\"height:30px;width:100%;padding-top:6px;\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            echo "'s Compositions</div>
                            ";
        }
        // line 279
        echo "                        </div>
                        <div class=\"foldertree\">
                            ";
        // line 281
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "compositions", array())) == 0)) {
            // line 282
            echo "                                ";
            if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
                echo "You";
            } else {
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            }
            echo " haven't created any compositions yet.
                            ";
        } else {
            // line 284
            echo "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_reverse_filter($this->env, twig_sort_filter($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "compositions", array()))));
            foreach ($context['_seq'] as $context["_key"] => $context["cmp"]) {
                // line 285
                echo "                                    <table class=\"listrow\">
                                        <tr>
                                            <td rowspan=\"3\" style=\"width:48px;height:48px;\" valign=\"middle\">
                                                <a href=\"";
                // line 288
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showcomposition", array("id" => $this->getAttribute($context["cmp"], "id", array()))), "html", null, true);
                echo "\">
                                                    <center><img src=\"";
                // line 289
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./img/composition_icon.png"), "html", null, true);
                echo "\" width=\"48px\" height=\"48px\"/></center>
                                                </a>
                                            </td>
                                            <td valign=\"top\" height=\"20px\" colspan=\"2\" style=\"font-size:18px;padding-left:20px;\">
                                                <a href=\"";
                // line 293
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showcomposition", array("id" => $this->getAttribute($context["cmp"], "id", array()))), "html", null, true);
                echo "\">
                                                <b>";
                // line 294
                echo twig_escape_filter($this->env, $this->getAttribute($context["cmp"], "name", array()), "html", null, true);
                echo "</b></a>
                                                ";
                // line 295
                if ( !(isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
                    // line 296
                    echo "                                                    <span style=\"display:inline;font-size:14px;padding-left:16px\">
                                                        <a href=\"#\" onclick=\"showTargetCatalogTree(";
                    // line 297
                    echo twig_escape_filter($this->env, $this->getAttribute($context["cmp"], "id", array()), "html", null, true);
                    echo ", 'composition');\">Add to Favorites</a>
                                                    </span>
                                                ";
                }
                // line 300
                echo "                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign=\"top\" height=\"24px\" width=\"300px\" style=\"font-size:14px;padding-left:16px;\">
                                                <b>Last modified</b>:&nbsp;";
                // line 304
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["cmp"], "modified", array()), "d.m.Y"), "html", null, true);
                echo "
                                            </td>
                                            <td valign=\"top\" height=\"24px\" style=\"font-size:14px;\">
                                                <b>Views</b>:&nbsp; ";
                // line 307
                echo twig_escape_filter($this->env, $this->getAttribute($context["cmp"], "views", array()), "html", null, true);
                echo "
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign=\"top\" colspan=\"2\" style=\"font-size:14px;padding-left:16px;\">
                                                <i>\"";
                // line 312
                echo twig_escape_filter($this->env, $this->getAttribute($context["cmp"], "description", array()), "html", null, true);
                echo "\"</i>
                                            </td>
                                        </tr>
                                    </table>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cmp'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 317
            echo "                            ";
        }
        // line 318
        echo "                        </div>
                    </div>
                    <div id=\"palette_tab\" class=\"userfilesareafullside\" style=\"display:none;\">
                        <div class=\"userfilesheader\">
                            ";
        // line 322
        if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
            // line 323
            echo "                                ";
            $context["palettesleft"] = ($this->getAttribute($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "limits", array()), "palettes", array()) - twig_length_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "palettes", array())));
            // line 324
            echo "                                ";
            if (($this->getAttribute($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "limits", array()), "palettes", array()) == null)) {
                // line 325
                echo "                                    <div class=\"biglink\" onclick=\"redirectToPaletteCreation();\"><b>Create Palette</b></div>
                                ";
            } elseif ((            // line 326
(isset($context["palettesleft"]) ? $context["palettesleft"] : $this->getContext($context, "palettesleft")) > 0)) {
                // line 327
                echo "                                    <div class=\"biglink\" onclick=\"redirectToPaletteCreation();\"><b>Create Palette</b> (";
                echo twig_escape_filter($this->env, (isset($context["palettesleft"]) ? $context["palettesleft"] : $this->getContext($context, "palettesleft")), "html", null, true);
                echo ")</div>
                                ";
            } elseif ((            // line 328
(isset($context["palettesleft"]) ? $context["palettesleft"] : $this->getContext($context, "palettesleft")) <= 0)) {
                // line 329
                echo "                                    <div style=\"height:30px;width:100%;padding-top:6px;\">You've reached max permitted number of palettes</div>
                                ";
            }
            // line 331
            echo "                            ";
        } else {
            // line 332
            echo "                                <div style=\"height:30px;width:100%;padding-top:6px;\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            echo "'s Palettes</div>
                            ";
        }
        // line 334
        echo "                        </div>
                        <div class=\"foldertree\">
                            ";
        // line 336
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "palettes", array())) == 0)) {
            // line 337
            echo "                                ";
            if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
                echo "You";
            } else {
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            }
            echo " haven't created any palettes yet.
                            ";
        } else {
            // line 339
            echo "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_reverse_filter($this->env, twig_sort_filter($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "palettes", array()))));
            foreach ($context['_seq'] as $context["_key"] => $context["palette"]) {
                // line 340
                echo "                                    <table class=\"listrow\">
                                        <tr>
                                            <td rowspan=\"3\" style=\"width:48px;height:48px;\" valign=\"middle\">
                                                <a href=\"";
                // line 343
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showpalette", array("id" => $this->getAttribute($context["palette"], "id", array()))), "html", null, true);
                echo "\">
                                                    <center><img src=\"";
                // line 344
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./img/palette.png"), "html", null, true);
                echo "\" width=\"48px\" height=\"48px\"/></center>
                                                </a>
                                            </td>
                                            <td valign=\"top\" height=\"20px\" colspan=\"2\" style=\"font-size:18px;padding-left:20px;\">
                                                <a href=\"";
                // line 348
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showpalette", array("id" => $this->getAttribute($context["palette"], "id", array()))), "html", null, true);
                echo "\">
                                                <b>";
                // line 349
                echo twig_escape_filter($this->env, $this->getAttribute($context["palette"], "name", array()), "html", null, true);
                echo "</b></a>
                                                ";
                // line 350
                if ( !(isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
                    // line 351
                    echo "                                                    <span style=\"display:inline;font-size:14px;padding-left:16px\">
                                                        <a href=\"#\" onclick=\"showTargetCatalogTree(";
                    // line 352
                    echo twig_escape_filter($this->env, $this->getAttribute($context["palette"], "id", array()), "html", null, true);
                    echo ", 'palette');\">Add to Favorites</a>
                                                    </span>
                                                ";
                }
                // line 355
                echo "                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign=\"top\" colspan=\"2\" style=\"font-size:14px;padding-left:16px;\">
                                                <i>\"";
                // line 359
                echo twig_escape_filter($this->env, $this->getAttribute($context["palette"], "description", array()), "html", null, true);
                echo "\"</i>
                                            </td>
                                        </tr>
                                    </table>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['palette'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 364
            echo "                            ";
        }
        // line 365
        echo "                        </div>
                    </div>
                    <div id=\"proj_tab\" class=\"userfilesareafullside\" style=\"display:none;\">
                        <div class=\"userfilesheader\">
                            ";
        // line 369
        if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
            // line 370
            echo "                                <div style=\"height:30px;width:100%;padding-top:6px;\">Projects you participate in</div>
                            ";
        } else {
            // line 372
            echo "                                <div style=\"height:30px;width:100%;padding-top:6px;\">Projects ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
            echo " participates in</div>
                            ";
        }
        // line 374
        echo "                        </div>
                        <div class=\"foldertree\">
                            ";
        // line 376
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "projects", array())) == 0)) {
            // line 377
            echo "                                ";
            if ((isset($context["is_owner"]) ? $context["is_owner"] : $this->getContext($context, "is_owner"))) {
                // line 378
                echo "                                    You aren't participating in any projects.
                                ";
            } else {
                // line 380
                echo "                                    ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "username", array()), "html", null, true);
                echo " isn't participating in any projects.
                                ";
            }
            // line 382
            echo "                            ";
        } else {
            // line 383
            echo "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "projects", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["project"]) {
                // line 384
                echo "                                    <table class=\"listrow\">
                                        <tr>
                                            <td width=\"48px\" rowspan=\"2\">
                                                <img src=\"";
                // line 387
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./img/project_user.png"), "html", null, true);
                echo "\" widht=\"48px\" height=\"48px\"/>
                                            </td>
                                            <td width=\"16px\">&nbsp;</td>
                                            <td style=\"height:36px;font-size:22px;font-weight:bold;\">
                                                <a href=\"";
                // line 391
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showproject", array("id" => $this->getAttribute($this->getAttribute($context["project"], "project", array()), "id", array()))), "html", null, true);
                echo "\" target=\"_blank\">";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["project"], "project", array()), "name", array()), "html", null, true);
                echo "</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>Rang: <i style=\"color:#000090;font-size:16px;\">";
                // line 396
                echo twig_escape_filter($this->env, $this->getAttribute($context["project"], "rank", array()), "html", null, true);
                echo "</i></td>
                                        </tr>
                                    </table>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['project'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 400
            echo "                            ";
        }
        // line 401
        echo "                        </div>
                    </div>
                </div>
            </div>

    <div id=\"messagewindow\" title=\"Adding to favorites\"></div>
    <div id=\"errormessagewinow\" title=\"Error!\"></div>
    <div id=\"targetcatalogselector\" title=\"Choose a catalog\">
        <div id=\"targettree\" style=\"width:100%;height:300px;\"></div>
        <div id=\"targetnodeid\" style=\"display:none\"></div>
        <div id=\"targetnodetype\" style=\"display:none\"></div>
        <div id=\"selectednodeid\" style=\"display:none\"></div>
        <div id=\"selectednode\" style=\"height:20px;width:100%;float:bottom;padding-top:5px;border-top:1px solid #ccc\"></div>
    </div>
    <div id=\"writemessage\" title=\"New message\">
        <table width=\"100%\" height=\"100%\">
            <tr>
                <td>Subject:&nbsp;</td>
                <td><input id=\"message_subject\" type=\"text\" maxlenght=\"128\" style=\"width:100%\" value=\"\"/>
            </tr>
            <tr>
                <td colspan=\"2\">
                    <textarea id=\"message_body\" rows=\"7\" style=\"resize:none;width:100%;\"></textarea>
                </td>
            </tr>
        </table>
    </div>
    <script type=\"text/javascript\">
        \$( \"#messagewindow\" ).dialog({
            autoOpen: false,
            resizable: false,
            zIndex: 9999,
            height: 'auto',
            width: 400,
            modal: false,
            buttons: { OK : function(){ \$(this).dialog(\"close\"); }
        }});
        \$( \"#errormessagewinow\" ).dialog({
            autoOpen: false,
            resizable: false,
            zIndex: 9999,
            height: 'auto',
            width: 400,
            modal: false,
            buttons: { OK : function(){ \$(this).dialog(\"close\"); }
        }});
        \$( \"#targetcatalogselector\" ).dialog({
            autoOpen: false,
            resizable: false,
            zIndex: 9999,
            height: 'auto',
            width: 550,
            modal: false,
            buttons: [
                { text: \"OK\", click: function(){ sendAddToFavoritesRequest(null); \$(this).dialog(\"close\"); } },
                { text: \"Cancel\", click: function(){ buffer = null; \$(this).dialog(\"close\"); } }]
            });
        \$( \"#writemessage\" ).dialog({
            autoOpen: false,
            resizable: false,
            zIndex: 9999,
            height: 'auto',
            width: 400,
            modal: false,
            buttons: [
                { text: \"Send\", click: function(){ sendMessageToUser(); \$(this).dialog(\"close\"); } },
                { text: \"Cancel\", click: function(){ \$(this).dialog(\"close\"); } }]
            });
        </script>

        ";
        
        $__internal_1d0f3a0bedf0fa6e259a61c6450ab35b05bd13ddc730dd7cd72fcbb9bfa12506->leave($__internal_1d0f3a0bedf0fa6e259a61c6450ab35b05bd13ddc730dd7cd72fcbb9bfa12506_prof);

    }

    // line 473
    public function block_footer($context, array $blocks = array())
    {
        $__internal_719afaae6c6608c4fae25780e082b4944e37007610b0a1f0a0f277eba927e301 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_719afaae6c6608c4fae25780e082b4944e37007610b0a1f0a0f277eba927e301->enter($__internal_719afaae6c6608c4fae25780e082b4944e37007610b0a1f0a0f277eba927e301_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        // line 474
        echo "            ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
        ";
        
        $__internal_719afaae6c6608c4fae25780e082b4944e37007610b0a1f0a0f277eba927e301->leave($__internal_719afaae6c6608c4fae25780e082b4944e37007610b0a1f0a0f277eba927e301_prof);

    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:Objects:user.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1042 => 474,  1036 => 473,  959 => 401,  956 => 400,  946 => 396,  936 => 391,  929 => 387,  924 => 384,  919 => 383,  916 => 382,  910 => 380,  906 => 378,  903 => 377,  901 => 376,  897 => 374,  891 => 372,  887 => 370,  885 => 369,  879 => 365,  876 => 364,  865 => 359,  859 => 355,  853 => 352,  850 => 351,  848 => 350,  844 => 349,  840 => 348,  833 => 344,  829 => 343,  824 => 340,  819 => 339,  809 => 337,  807 => 336,  803 => 334,  797 => 332,  794 => 331,  790 => 329,  788 => 328,  783 => 327,  781 => 326,  778 => 325,  775 => 324,  772 => 323,  770 => 322,  764 => 318,  761 => 317,  750 => 312,  742 => 307,  736 => 304,  730 => 300,  724 => 297,  721 => 296,  719 => 295,  715 => 294,  711 => 293,  704 => 289,  700 => 288,  695 => 285,  690 => 284,  680 => 282,  678 => 281,  674 => 279,  668 => 277,  664 => 275,  662 => 274,  656 => 270,  653 => 269,  642 => 264,  634 => 259,  628 => 256,  622 => 253,  616 => 249,  610 => 246,  607 => 245,  605 => 244,  601 => 243,  597 => 242,  590 => 238,  586 => 237,  581 => 234,  576 => 233,  566 => 231,  564 => 230,  560 => 228,  554 => 226,  551 => 225,  547 => 223,  545 => 222,  540 => 221,  538 => 220,  535 => 219,  532 => 218,  529 => 217,  527 => 216,  521 => 212,  511 => 210,  505 => 208,  503 => 207,  499 => 205,  493 => 203,  489 => 201,  487 => 200,  477 => 192,  473 => 190,  469 => 188,  467 => 187,  464 => 186,  462 => 185,  459 => 184,  457 => 183,  453 => 182,  448 => 179,  444 => 176,  438 => 174,  436 => 173,  430 => 169,  423 => 168,  419 => 166,  412 => 165,  408 => 163,  401 => 162,  397 => 160,  390 => 159,  384 => 155,  381 => 154,  375 => 151,  372 => 150,  368 => 148,  362 => 146,  360 => 145,  356 => 143,  353 => 142,  351 => 141,  345 => 138,  341 => 136,  338 => 134,  332 => 133,  322 => 130,  316 => 129,  307 => 476,  305 => 473,  302 => 472,  300 => 133,  297 => 132,  294 => 129,  258 => 95,  252 => 92,  229 => 72,  225 => 71,  221 => 70,  217 => 69,  212 => 68,  207 => 66,  203 => 65,  198 => 64,  196 => 63,  192 => 62,  188 => 61,  184 => 60,  181 => 59,  176 => 57,  172 => 56,  168 => 55,  164 => 54,  160 => 53,  156 => 52,  151 => 51,  149 => 50,  143 => 47,  139 => 46,  135 => 45,  131 => 44,  127 => 43,  123 => 42,  119 => 41,  115 => 40,  111 => 39,  107 => 38,  103 => 37,  99 => 36,  74 => 13,  70 => 11,  64 => 10,  61 => 9,  58 => 8,  55 => 7,  50 => 6,  47 => 5,  44 => 4,  41 => 3,  39 => 2,  37 => 1,  14 => 128,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% set is_owner = false %}
{% if app.user != null %}
    {% if app.user.id == user.id %}
        {% set is_owner = true %}
        {% set unread = 0 %}
        {% for message in user.messagesReceived %}
            {% if message.read == false %}
                {% set unread = unread + 1 %}
            {% endif %}
        {% endfor %}
    {% endif %}
{% endif %}

<!DOCTYPE html>
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
        <title>{{ user.username }} :: project O-GIS</title>
        <link rel=\"stylesheet\" href=\"{{ asset('./css/ogis_styles.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./css/jstree-types.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./js/jquery/themes/default/style.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./js/jquery-ui/jquery-ui.css') }}\" />
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery/jquery-2.min.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery/jstree.min.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery-ui/jquery-ui.min.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/catalogTree.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/treeContextMenu.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/addtofavorites.js') }}\"></script>

        <script type=\"text/javascript\">
            {% if is_owner %}
                function RedirectToEditNotes(){ window.location.href = \"{{ path('usernotes', {'id': user.id}) }}\"; }
                function redirectToLayerUpload(){ window.location.href = \"{{ path('createlayer') }}\"; }
                function redirectToCmpEditor(){ window.location.href = \"{{ path('compositioneditor') }}\"; }
                function redirectToStyleCreation(){ window.location.href = \"{{ path('createstyle') }}\"; }
                function redirectToCreateProject(){ window.location.href = \"{{ path('createproject') }}\"; }
                function redirectToPaletteCreation(){ window.location.href = \"{{ path('paletteeditor', {'id': null}) }}\"; }
                function goToMessagebox(){ window.location.href = \"{{ path('usermessages') }}\" }
            {% endif %}

            var homepage = \"{{ path('homepage') }}\";
            var catalogData = \"{{ path('loadcatalogdata', {'catid': 'PATH' }) }}\";
            var rootNodes = \"{{ path('loadusercatalogs', {'holderid': user.id}) }}\";
            {% if app.user != null %}
                var rootFavNodes = \"{{ path('loadusercatalogs', {'holderid': app.user.id}) }}\";
                var editCatalogRoute = \"{{ path('editcatalog', {'id': 'ID'}) }}\";
                var cutPasteRoute = \"{{ path('movecatalogentity') }}\";
            {% endif %}
            var saveCatalogRoute = \"{{ path('savecatalog') }}\";
            var deleteCatalogRoute = \"{{ path('deletecatalog', {'id': 'ID'}) }}\";
            var modifyLinkRoute = \"{{ path('updatelink') }}\";
            var deleteLinkRoute = \"{{ path('removefromfavorites', {'id' : 'ID'}) }}\";
            var addToFavRoute = \"{{ path('addtofavorites') }}\";
            
            function switchTabs(id){
                var data_tabs = [\"user_tab\",\"notes_tab\",\"layer_tab\",\"cmp_tab\",\"palette_tab\",\"proj_tab\"];
                var select_tabs = [\"user_sel\",\"notes_sel\",\"layer_sel\",\"cmp_sel\",\"palette_sel\",\"proj_sel\"];
                for (var i = 0; i < 6; i++){
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
            
            function ShowSendMessageDialog(){ \$( \"#writemessage\" ).dialog('open'); }
            
            function sendMessageToUser(){
                var user_id = {{ user.id }}
                var subject = document.getElementById('message_subject').value;
                var body = document.getElementById('message_body').value;
                var url = \"{{ path('sendmessage') }}\";
                url += '?addressee=' + user_id + '&subject=' + subject + '&body=' + body;
                \$.ajax({
                    url: url,
                    method: 'POST'
                }).done(function(response){
                    if (!response.success){
                        var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">' + response.message + '</td></tr></table>';
                        \$( \"#messagewindow\" ).dialog('option', 'title', 'Sending Message');
                        \$( \"#messagewindow\" ).empty();
                        \$( \"#messagewindow\" ).append(html);
                        \$( \"#messagewindow\" ).dialog(\"open\");
                    }
                    else {
                        var html = '<table><tr><td width=\"64px\"><img src=\"./img/ok.png\"/></td><td valign=\"middle\">' + response.message + '</td></tr></table>';
                        \$( \"#messagewindow\" ).dialog('option', 'title', 'Sending Message');
                        \$( \"#messagewindow\" ).empty();
                        \$( \"#messagewindow\" ).append(html);
                        \$( \"#messagewindow\" ).dialog(\"open\");
                    }
                }).fail(function(){
                    var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">Unknown error while sending your message!</td></tr></table>';
                    \$( \"#messagewindow\" ).dialog('option', 'title', 'Sending Message');
                    \$( \"#messagewindow\" ).empty();
                    \$( \"#messagewindow\" ).append(html);
                    \$( \"#messagewindow\" ).dialog(\"open\");
                });
            }
            
        </script>
    </head>
    <body class=\"bodyfullpage\" onload=\"loadUserCatalogs();\">

        {% use 'OGISIndexBundle:Default:header.html.twig' %}
        {% block header %}
            {{ parent() }}
        {% endblock %}

        {% block pagecontent %}
            <div class=\"contentbody\">
                {# avatar + instruments panel #}
                <div class=\"userpageleftside\">
                    <div class=\"useravatar\">
                        <center><img src=\"{{ asset('./img/user.png') }}\" height=\"200px\" width=\"200px\"></img></center>
                    </div>
                    <div>
                        {% if app.user != null %}
                            {% if is_owner %}
                                <div class=\"userprofilelinkbox objectlink\" onclick=\"goToMessagebox();\">
                                    Your messagebox
                                    {% if unread > 0 %}
                                        &nbsp;({{unread}})
                                    {% endif %}
                                </div>
                            {% else %}
                                <div class=\"userprofilelinkbox objectlink\" onclick=\"ShowSendMessageDialog();\">
                                    Send {{ user.username }} a message
                                </div>
                            {% endif %}
                        {% endif %}
                        <div class=\"userprofilelinkbox objectlinkselected\" id=\"user_sel\" onclick=\"switchTabs(0);\">
                            User Info
                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"notes_sel\" onclick=\"switchTabs(1);\">
                            {% if is_owner %}Your Notes{% else %}{{ user.username }}'s Notes{% endif %}
                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"layer_sel\" onclick=\"switchTabs(2);\">
                            {% if is_owner %}Your Layers{% else %}{{ user.username }}'s Layers{% endif %}
                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"cmp_sel\" onclick=\"switchTabs(3);\">
                            {% if is_owner %}Your Compositions{% else %}{{ user.username }}'s Compositions{% endif %}
                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"palette_sel\" onclick=\"switchTabs(4);\">
                            {% if is_owner %}Your Palettes{% else %}{{ user.username }}'s Palettes{% endif %}
                        </div>
                        <div class=\"userprofilelinkbox objectlink\" id=\"proj_sel\" onclick=\"switchTabs(5);\">
                            Participation in Projects
                        </div>
                        {% if is_owner == false%}
                            <div class=\"userprofilelinkbox objectlink\" onclick=\"showTargetCatalogTree({{ user.id }}, 'user');\">Add User to Favorites</div>
                        {% endif %}
                    </div>
                </div>
                {# main content of the page #}
                <div class=\"userpagerightside\">
                    <div id=\"user_tab\" style=\"height:100%;display:block\">
                        <div class=\"usernamebox\">
                            <span class=\"username\">{{ user.displayname }}</span><br/>
                            {% if user.limits.role == \"ROLE_SUPER_ADMIN\" %}
                                <i class=\"userroleadmin\">O-GIS Administrator</i>
                            {% elseif user.limits.role == \"ROLE_SYSTEM\" %}
                                <i class=\"userroleadmin\">System User</i>
                            {% elseif user.limits.role == \"ROLE_ADMIN\" %}
                                <i class=\"userrolemod\">O-GIS Moderator</i>
                            {% else %}
                                <i class=\"userrolebase\">O-GIS User</i>
                            {% endif %}
                        </div>
                        <div class=\"userfilesarea\">
                            <div class=\"userfilesheader\" style=\"height:30px;padding-top:6px;\">User's resources</div>
                            <div class=\"foldertree\" id=\"foldertree\"></div>
                        </div>
                    </div>
                    <div id=\"notes_tab\" class=\"userfilesareafullside\" style=\"display:none;\">
                        <div class=\"userfilesheader\">
                            {% if is_owner or is_granted('ROLE_ADMIN') %}
                                <div class=\"biglink\" onclick=\"RedirectToEditNotes();\"><b>Edit notes</b></div>
                            {% else %}
                                <div style=\"height:30px;width:100%;padding-top:6px;\">{{ user.username }}'s Notes</div>
                            {% endif %}
                        </div>
                        <div class=\"foldertree\">
                            {% if user.messageboard != null and user.messageboard != \"\" %}
                                {{ user.messageboard|raw }}
                            {% else %}
                                {% if is_owner %}You{% else %}{{ user.username }}{% endif %} made no notes.
                            {% endif %}
                        </div>
                    </div>
                    <div id=\"layer_tab\"  class=\"userfilesareafullside\" style=\"display:none;\">
                        <div class=\"userfilesheader\">
                            {% if is_owner %}
                                {% set layersleft = user.limits.layers - user.layers|length %}
                                {% if user.limits.layers == null %}
                                    <div class=\"biglink\" onclick=\"redirectToLayerUpload();\"><b>Upload a Layer</b></div>
                                {% elseif layersleft > 0 %}
                                    <div class=\"biglink\" onclick=\"redirectToLayerUpload();\"><b>Upload a Layer</b> ({{ layersleft }})</div>
                                {% elseif layersleft <= 0 %}
                                    <div style=\"height:30px;width:100%;padding-top:6px;\">You've reached the max permitted number of layers</div>
                                {% endif %}
                            {% else %}
                                <div style=\"height:30px;width:100%;padding-top:6px;\">{{ user.username }}'s Layers</div>
                            {% endif %}
                        </div>
                        <div class=\"foldertree\">
                            {% if user.layers|length == 0 %}
                                {% if is_owner %}You{% else %}{{ user.username }}{% endif %} haven't uploaded any layers yet.
                            {% else %}
                                {% for layer in user.layers|sort|reverse %}
                                    <table class=\"listrow\">
                                        <tr>
                                            <td rowspan=\"3\" width=\"100px\" style=\"border:1px solid #aaa;background:#fff;\" valign=\"middle\">
                                                <a href=\"{{ path('showlayer', {id: layer.id}) }}\">
                                                        <img src=\"{{ asset(layer.preview) }}\" width=\"144px\"/>
                                                </a>
                                            </td>
                                            <td valign=\"top\" height=\"20px\" colspan=\"3\" style=\"font-size:18px;padding-left:16px;\">
                                                <a href=\"{{ path('showlayer', {id: layer.id}) }}\">
                                                <b>{{ layer.name }}</b></a>
                                                {% if not is_owner %}
                                                    <span style=\"display:inline;font-size:14px;padding-left:16px\">
                                                        <a href=\"#\" onclick=\"showTargetCatalogTree({{ layer.id }}, 'layer');\">Add to favorites</a>
                                                    </span>
                                                {% endif %}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign=\"top\" height=\"24px\" width=\"200px\" style=\"font-size:14px;padding-left:16px;\">
                                                <b>Last modified</b>:&nbsp;{{ layer.modified|date('d.m.Y') }}
                                            </td>
                                            <td valign=\"top\" height=\"24px\" width=\"150px\" style=\"font-size:14px;\">
                                                <b>Views</b>:&nbsp; {{ layer.views }}
                                            </td>
                                            <td valign=\"top\" height=\"24px\" style=\"font-size:14px;\">
                                                <b>Downloads</b>:&nbsp; {{ layer.downloads }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign=\"top\" colspan=\"3\" style=\"font-size:14px;padding-left:16px;\">
                                                <i>\"{{ layer.description }}\"</i>
                                            </td>
                                        </tr>
                                    </table>
                                {% endfor %}
                            {% endif %}
                        </div>
                    </div>
                    <div id=\"cmp_tab\" class=\"userfilesareafullside\" style=\"display:none;\">
                        <div class=\"userfilesheader\">
                            {% if is_owner %}
                                <div class=\"biglink\" onclick=\"redirectToCmpEditor();\"><b>Open Composition Editor</b></div>
                            {% else %}
                                <div style=\"height:30px;width:100%;padding-top:6px;\">{{ user.username }}'s Compositions</div>
                            {% endif %}
                        </div>
                        <div class=\"foldertree\">
                            {% if user.compositions|length == 0 %}
                                {% if is_owner %}You{% else %}{{ user.username }}{% endif %} haven't created any compositions yet.
                            {% else %}
                                {% for cmp in user.compositions|sort|reverse %}
                                    <table class=\"listrow\">
                                        <tr>
                                            <td rowspan=\"3\" style=\"width:48px;height:48px;\" valign=\"middle\">
                                                <a href=\"{{ path('showcomposition', {id: cmp.id}) }}\">
                                                    <center><img src=\"{{ asset('./img/composition_icon.png') }}\" width=\"48px\" height=\"48px\"/></center>
                                                </a>
                                            </td>
                                            <td valign=\"top\" height=\"20px\" colspan=\"2\" style=\"font-size:18px;padding-left:20px;\">
                                                <a href=\"{{ path('showcomposition', {id: cmp.id}) }}\">
                                                <b>{{ cmp.name }}</b></a>
                                                {% if not is_owner %}
                                                    <span style=\"display:inline;font-size:14px;padding-left:16px\">
                                                        <a href=\"#\" onclick=\"showTargetCatalogTree({{ cmp.id }}, 'composition');\">Add to Favorites</a>
                                                    </span>
                                                {% endif %}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign=\"top\" height=\"24px\" width=\"300px\" style=\"font-size:14px;padding-left:16px;\">
                                                <b>Last modified</b>:&nbsp;{{ cmp.modified|date('d.m.Y') }}
                                            </td>
                                            <td valign=\"top\" height=\"24px\" style=\"font-size:14px;\">
                                                <b>Views</b>:&nbsp; {{ cmp.views }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign=\"top\" colspan=\"2\" style=\"font-size:14px;padding-left:16px;\">
                                                <i>\"{{ cmp.description }}\"</i>
                                            </td>
                                        </tr>
                                    </table>
                                {% endfor %}
                            {% endif %}
                        </div>
                    </div>
                    <div id=\"palette_tab\" class=\"userfilesareafullside\" style=\"display:none;\">
                        <div class=\"userfilesheader\">
                            {% if is_owner %}
                                {% set palettesleft = user.limits.palettes - user.palettes|length %}
                                {% if user.limits.palettes == null %}
                                    <div class=\"biglink\" onclick=\"redirectToPaletteCreation();\"><b>Create Palette</b></div>
                                {% elseif palettesleft > 0 %}
                                    <div class=\"biglink\" onclick=\"redirectToPaletteCreation();\"><b>Create Palette</b> ({{ palettesleft }})</div>
                                {% elseif palettesleft <= 0 %}
                                    <div style=\"height:30px;width:100%;padding-top:6px;\">You've reached max permitted number of palettes</div>
                                {% endif %}
                            {% else %}
                                <div style=\"height:30px;width:100%;padding-top:6px;\">{{ user.username }}'s Palettes</div>
                            {% endif %}
                        </div>
                        <div class=\"foldertree\">
                            {% if user.palettes|length == 0 %}
                                {% if is_owner %}You{% else %}{{ user.username }}{% endif %} haven't created any palettes yet.
                            {% else %}
                                {% for palette in user.palettes|sort|reverse %}
                                    <table class=\"listrow\">
                                        <tr>
                                            <td rowspan=\"3\" style=\"width:48px;height:48px;\" valign=\"middle\">
                                                <a href=\"{{ path('showpalette', {id: palette.id}) }}\">
                                                    <center><img src=\"{{ asset('./img/palette.png') }}\" width=\"48px\" height=\"48px\"/></center>
                                                </a>
                                            </td>
                                            <td valign=\"top\" height=\"20px\" colspan=\"2\" style=\"font-size:18px;padding-left:20px;\">
                                                <a href=\"{{ path('showpalette', {id: palette.id}) }}\">
                                                <b>{{ palette.name }}</b></a>
                                                {% if not is_owner %}
                                                    <span style=\"display:inline;font-size:14px;padding-left:16px\">
                                                        <a href=\"#\" onclick=\"showTargetCatalogTree({{ palette.id }}, 'palette');\">Add to Favorites</a>
                                                    </span>
                                                {% endif %}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign=\"top\" colspan=\"2\" style=\"font-size:14px;padding-left:16px;\">
                                                <i>\"{{ palette.description }}\"</i>
                                            </td>
                                        </tr>
                                    </table>
                                {% endfor %}
                            {% endif %}
                        </div>
                    </div>
                    <div id=\"proj_tab\" class=\"userfilesareafullside\" style=\"display:none;\">
                        <div class=\"userfilesheader\">
                            {% if is_owner %}
                                <div style=\"height:30px;width:100%;padding-top:6px;\">Projects you participate in</div>
                            {% else %}
                                <div style=\"height:30px;width:100%;padding-top:6px;\">Projects {{ user.username }} participates in</div>
                            {% endif %}
                        </div>
                        <div class=\"foldertree\">
                            {% if user.projects|length == 0 %}
                                {% if is_owner %}
                                    You aren't participating in any projects.
                                {% else %}
                                    {{ user.username }} isn't participating in any projects.
                                {% endif %}
                            {% else %}
                                {% for project in user.projects %}
                                    <table class=\"listrow\">
                                        <tr>
                                            <td width=\"48px\" rowspan=\"2\">
                                                <img src=\"{{ asset('./img/project_user.png') }}\" widht=\"48px\" height=\"48px\"/>
                                            </td>
                                            <td width=\"16px\">&nbsp;</td>
                                            <td style=\"height:36px;font-size:22px;font-weight:bold;\">
                                                <a href=\"{{ path('showproject', {'id': project.project.id}) }}\" target=\"_blank\">{{ project.project.name }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>Rang: <i style=\"color:#000090;font-size:16px;\">{{ project.rank }}</i></td>
                                        </tr>
                                    </table>
                                {% endfor %}
                            {% endif %}
                        </div>
                    </div>
                </div>
            </div>

    <div id=\"messagewindow\" title=\"Adding to favorites\"></div>
    <div id=\"errormessagewinow\" title=\"Error!\"></div>
    <div id=\"targetcatalogselector\" title=\"Choose a catalog\">
        <div id=\"targettree\" style=\"width:100%;height:300px;\"></div>
        <div id=\"targetnodeid\" style=\"display:none\"></div>
        <div id=\"targetnodetype\" style=\"display:none\"></div>
        <div id=\"selectednodeid\" style=\"display:none\"></div>
        <div id=\"selectednode\" style=\"height:20px;width:100%;float:bottom;padding-top:5px;border-top:1px solid #ccc\"></div>
    </div>
    <div id=\"writemessage\" title=\"New message\">
        <table width=\"100%\" height=\"100%\">
            <tr>
                <td>Subject:&nbsp;</td>
                <td><input id=\"message_subject\" type=\"text\" maxlenght=\"128\" style=\"width:100%\" value=\"\"/>
            </tr>
            <tr>
                <td colspan=\"2\">
                    <textarea id=\"message_body\" rows=\"7\" style=\"resize:none;width:100%;\"></textarea>
                </td>
            </tr>
        </table>
    </div>
    <script type=\"text/javascript\">
        \$( \"#messagewindow\" ).dialog({
            autoOpen: false,
            resizable: false,
            zIndex: 9999,
            height: 'auto',
            width: 400,
            modal: false,
            buttons: { OK : function(){ \$(this).dialog(\"close\"); }
        }});
        \$( \"#errormessagewinow\" ).dialog({
            autoOpen: false,
            resizable: false,
            zIndex: 9999,
            height: 'auto',
            width: 400,
            modal: false,
            buttons: { OK : function(){ \$(this).dialog(\"close\"); }
        }});
        \$( \"#targetcatalogselector\" ).dialog({
            autoOpen: false,
            resizable: false,
            zIndex: 9999,
            height: 'auto',
            width: 550,
            modal: false,
            buttons: [
                { text: \"OK\", click: function(){ sendAddToFavoritesRequest(null); \$(this).dialog(\"close\"); } },
                { text: \"Cancel\", click: function(){ buffer = null; \$(this).dialog(\"close\"); } }]
            });
        \$( \"#writemessage\" ).dialog({
            autoOpen: false,
            resizable: false,
            zIndex: 9999,
            height: 'auto',
            width: 400,
            modal: false,
            buttons: [
                { text: \"Send\", click: function(){ sendMessageToUser(); \$(this).dialog(\"close\"); } },
                { text: \"Cancel\", click: function(){ \$(this).dialog(\"close\"); } }]
            });
        </script>

        {% endblock %}
            
        {% block footer %}
            {{ parent() }}
        {% endblock %}
    </body>
</html>
", "OGISIndexBundle:Objects:user.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/Objects/user.html.twig");
    }
}
