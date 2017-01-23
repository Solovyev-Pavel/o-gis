<?php

/* OGISIndexBundle:Editor:compositioneditor.html.twig */
class __TwigTemplate_d69564a787018bd8075b88e151a4cef508d08c9e2038dc60ab397ee5ef472b17 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'pagecontent' => array($this, 'block_pagecontent'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_5ddbf78cd2b4843f906cef57c54c3c1f6dc7eafe34301226e202058676a0592b = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_5ddbf78cd2b4843f906cef57c54c3c1f6dc7eafe34301226e202058676a0592b->enter($__internal_5ddbf78cd2b4843f906cef57c54c3c1f6dc7eafe34301226e202058676a0592b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "OGISIndexBundle:Editor:compositioneditor.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        <link rel=\"shortcut icon\" href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        ";
        // line 6
        if (((isset($context["composition"]) ? $context["composition"] : $this->getContext($context, "composition")) != null)) {
            // line 7
            echo "            <title>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["composition"]) ? $context["composition"] : $this->getContext($context, "composition")), "name", array()), "html", null, true);
            echo " :: Composition editor :: project O-GIS</title>
        ";
        } else {
            // line 9
            echo "            <title>Composition editor :: project O-GIS</title>
        ";
        }
        // line 11
        echo "        
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

        <!-- styling and jquery -->
        <script type=\"text/javascript\" src=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/jquery-2.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-ui/jquery-ui.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"http://openlayers.org/api/OpenLayers.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-context/jquery.contextMenu.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-context/jquery.ui.position.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 35
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/addtofavorites.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 36
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/jstree.min.js"), "html", null, true);
        echo "\"></script>
        
        <link rel=\"stylesheet\" href=\"";
        // line 38
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/imagepicker/image-picker.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 39
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-context/jquery.contextMenu.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 40
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-ui/jquery-ui.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 41
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/editor_styles.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 42
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/themes/default/style.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 43
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/jstree-types.css"), "html", null, true);
        echo "\" />

        <script type=\"text/javascript\" src=\"";
        // line 45
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./EditorJQ/AddLayer.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 46
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./EditorJQ/Authorize.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./EditorJQ/CompositionEditor.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./EditorJQ/CompositionObject.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./EditorJQ/CompositionSave.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 50
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./EditorJQ/RasterAnalysis.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./EditorJQ/Styler.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 52
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./EditorJQ/WMSInfo.js"), "html", null, true);
        echo "\"></script>

        <link rel=\"stylesheet\" href=\"";
        // line 54
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./EditorJQ/styler-preview.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 55
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/colors/jquery.minicolors.css"), "html", null, true);
        echo "\" />
        <script type=\"text/javascript\" src=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/colors/jquery.minicolors.min.js"), "html", null, true);
        echo "\"></script>
        
        <style>
            .ui-dialog{ z-index: 9999 !important; }
            .ui-widget-overlay{ z-index: 6666 !important; }
        </style>

        <script type=\"text/javascript\">
            var editor = null;
            var catalogData = \"";
        // line 65
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("loadcatalogdata", array("catid" => "PATH"));
        echo "\";
            var addToFavRoute = \"";
        // line 66
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("addtofavorites");
        echo "\";
            var getLayerId = \"";
        // line 67
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("get_layer_id", array("cs" => "ID"));
        echo "\";
            var paletteListRoute = \"";
        // line 68
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("showpalettelisteditor");
        echo "\";
            var getPaletteRoute = \"";
        // line 69
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("getpalettecompressed", array("id" => "ID"));
        echo "\";
            var getCompositionData = \"";
        // line 70
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("getCompositionData", array("id" => "ID"));
        echo "\";
            var getLayerData = \"";
        // line 71
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("getLayerData", array("id" => "ID"));
        echo "\";

            function goToHomePage(){ window.location.href = \"";
        // line 73
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("homepage");
        echo "\"; }
            
            function initializeEditor(){
                editor = new CompositionEditor();
                editor.setVariable('editor');
                editor.setMapDOM('map_container');
                editor.setLayerListDOM('layerlist');
                editor.setAddLayerWindow('addlayerwindow');
                editor.setAddCompositionWindow('addcompositionwindow');
                editor.setAuthentificationWindow('authwindow');
                editor.setSaveCompositionWindow('newcompositionwindow');
                editor.setStylerWindow('stylelayerwindow');
                editor.setPaletteSelectWindow('selectpalettewindow');
                editor.setRasterOpWindow('rasteropeationswindow');
                editor.setSelectRasterWindow('selectrasterwindow');
                editor.setCursorPositionDom('coordinatesOutput');
                editor.setWaitAnimDom('processingbox');
                ";
        // line 90
        if (($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()) != null)) {
            // line 91
            echo "                    editor.setUser(";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "id", array()), "html", null, true);
            echo ", \"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "username", array()), "html", null, true);
            echo "\", ";
            echo twig_escape_filter($this->env, (isset($context["ulimit"]) ? $context["ulimit"] : $this->getContext($context, "ulimit")), "html", null, true);
            echo ");
                ";
        }
        // line 93
        echo "                ";
        if (((isset($context["composition"]) ? $context["composition"] : $this->getContext($context, "composition")) != null)) {
            // line 94
            echo "                    editor.initializeCompositionEditor('composition', ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["composition"]) ? $context["composition"] : $this->getContext($context, "composition")), "id", array()), "html", null, true);
            echo ");
                    editor.setEditPermission(";
            // line 95
            echo twig_escape_filter($this->env, (isset($context["permission"]) ? $context["permission"] : $this->getContext($context, "permission")), "html", null, true);
            echo ");
                ";
        } elseif ((        // line 96
(isset($context["layer"]) ? $context["layer"] : $this->getContext($context, "layer")) != null)) {
            // line 97
            echo "                    editor.initializeCompositionEditor('layer', ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["layer"]) ? $context["layer"] : $this->getContext($context, "layer")), "id", array()), "html", null, true);
            echo ");
                ";
        } else {
            // line 99
            echo "                    editor.initializeCompositionEditor(null, null);
                ";
        }
        // line 101
        echo "            }
        </script>
    </head>
    
    <body class=\"bodyfullpage\" onload=\"initializeEditor();\">

        ";
        // line 107
        $this->displayBlock('pagecontent', $context, $blocks);
        // line 306
        echo "
    </body>
</html>
";
        
        $__internal_5ddbf78cd2b4843f906cef57c54c3c1f6dc7eafe34301226e202058676a0592b->leave($__internal_5ddbf78cd2b4843f906cef57c54c3c1f6dc7eafe34301226e202058676a0592b_prof);

    }

    // line 107
    public function block_pagecontent($context, array $blocks = array())
    {
        $__internal_7cb0d70138455f17d6db1278f16a831b63ad708ea6d337e7f028b07ce08c58e7 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_7cb0d70138455f17d6db1278f16a831b63ad708ea6d337e7f028b07ce08c58e7->enter($__internal_7cb0d70138455f17d6db1278f16a831b63ad708ea6d337e7f028b07ce08c58e7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "pagecontent"));

        // line 108
        echo "            <div class=\"editorcontentbody\">
                <div class=\"editorwestpanel\">
                    <div id=\"layerlistpanel\" style=\"width:240px;height:100%;float:left;\">
                        <div class=\"editorwestpaneltoolbar\">
                            <span class=\"controlicon\" onclick=\"editor.AddLayers.showAvaliableLayers();\" title=\"Add...\">
                                <img src=\"./EditorJQ/img/add.png\" />
                            </span>
                            <span class=\"controlicon\" onclick=\"editor.RasterAnalysis.beginRasterOperations();\" title=\"Raster operations...\">
                                <img src=\"./EditorJQ/img/mathops.png\" />
                            </span>
                            <span class=\"controlicon\" onclick=\"editor.CompositionSave.reloadComposition();\" title=\"Rollback to last save\">
                                <img src=\"./EditorJQ/img/refresh.png\" />
                            </span>
                            <span class=\"controlicon\" onclick=\"editor.CompositionSave.saveTheComposition(false);\" title=\"Save\">
                                <img src=\"./EditorJQ/img/save.png\" />
                            </span>
                            <span class=\"controlicon\" onclick=\"editor.CompositionSave.saveTheComposition(true);\" title=\"Save as..\">
                                <img src=\"./EditorJQ/img/saveas.png\" />
                            </span>
                            <span class=\"controlicon\" onclick=\"editor.addCompositionToFavorites()\" title=\"Add composition to favorites\">
                                <img src=\"./EditorJQ/img/star.png\" />
                            </span>
                            ";
        // line 130
        if (((isset($context["composition"]) ? $context["composition"] : $this->getContext($context, "composition")) != null)) {
            // line 131
            echo "                            <span class=\"controlicon\" onclick=\"editor.goToEntity('composition', ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["composition"]) ? $context["composition"] : $this->getContext($context, "composition")), "id", array()), "html", null, true);
            echo ");\" title=\"Leave editor\">
                            ";
        } elseif ((        // line 132
(isset($context["layer"]) ? $context["layer"] : $this->getContext($context, "layer")) != null)) {
            // line 133
            echo "                            <span class=\"controlicon\" onclick=\"editor.goToEntity('layer', ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["layer"]) ? $context["layer"] : $this->getContext($context, "layer")), "id", array()), "html", null, true);
            echo ");\" title=\"Leave editor\">
                            ";
        } else {
            // line 135
            echo "                            <span class=\"controlicon\" onclick=\"goToHomePage();\" title=\"Leave editor\">
                            ";
        }
        // line 137
        echo "                                <img src=\"./EditorJQ/img/door.png\" />
                            </span>
                        </div>
                        <div class=\"dragsortlistcontainer\">
                            <ul id=\"layerlist\" class=\"sortable\"></ul>
                            <script type=\"text/javascript\">
                                \$( \"#layerlist\" ).sortable({
                                    stop: function(event, ui){ editor.updateLayerOrder(); }
                                });
                                \$( document ).tooltip();
                            </script>
                        </div>
                    </div>
                    <div class=\"listvisibilitytoggler\">
                        <div id=\"listvisibilitytoggler\" title=\"Hide\" class=\"listvisibilitytogglerbutton\" onclick=\"editor.toggleLayerListVisibility();\">
                            <p style=\"padding-top:11px;font-weight:bold;\">►</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id=\"mappanelmain\" class=\"editormain\">
                <div style=\"width:100%;height:100%\" id=\"map_container\"></div>  
            </div>

            <div class=\"editorcursorposition\"><center style=\"font-size:14px;padding-top:3px;\" id=\"coordinatesOutput\"></center></div>
            <div class=\"processingbox\" id=\"processingbox\" style=\"display:none;\">
                <table width=\"100%\">
                    <tr>
                        <td><img src=\"";
        // line 166
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./img/loading3.gif"), "html", null, true);
        echo "\"/></td>
                        <td>Processing your request<br/>Please wait...</td>
                    </tr>
                </table>
            </div>
                                
            <div class=\"editorfooter\">
                <table width=\"100%\">
                    <tr>
                        <td width=\"33%\">
                        </td>
                        <td width=\"34%\">
                            <center>(c) O-GIS team, 2014 - ";
        // line 178
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo "</center>
                        </td>
                        <td align=\"right\">
                            <a href=\"maito:\">O-GIS support</a>
                        </td>
                    </tr>
                </table>
            </div>

            <div id=\"addlayerwindow\" title=\"Adding layer\"></div>
            <div id=\"addcompositionwindow\" title=\"Adding composition\">
                <p>Select layers to add into editor:<br/></p>
                <div id=\"innercmpaddwindow\" style=\"height:260px;overflow-x:hidden;overflow-y:scroll\"></div>
            </div>
            <div id=\"stylelayerwindow\" title=\"Visualization settings\"></div>
            <div id=\"newcompositionwindow\" title=\"Saving composition\"></div>
            <div id=\"messagewindow\" title=\"\"></div>
            <div id=\"messagewindow2\" title=\"Saving composition\"></div>
            <div id=\"authwindow\" title=\"Logging into O-GIS\"></div>
            <div id=\"targetcatalogselector\" title=\"Select catalog\">
                <div id=\"targettree\" style=\"width:100%;height:300px;\"></div>
                <div id=\"targetnodeid\" style=\"display:none\"></div>
                <div id=\"targetnodetype\" style=\"display:none\"></div>
                <div id=\"selectednodeid\" style=\"display:none\"></div>
                <div id=\"selectednode\" style=\"height:20px;width:100%;float:bottom;padding-top:5px;border-top:1px solid #ccc\"></div>
            </div>
            <div id=\"rasteropeationswindow\" title=\"\"></div>
            <div id=\"selectrasterwindow\" title=\"Select raster layer\"></div>
            <div id=\"selectpalettewindow\" title=\"Select palette\"></div>
            <script type=\"text/javascript\">
                \$( \"#addlayerwindow\" ).dialog({ autoOpen: false,
                                                resizable: false,
                                                zIndex: 9999,
                                                height: 500,
                                                width: 600,
                                                modal: false,
                                                buttons: { \"Close\" : function(){ \$(this).dialog(\"close\"); } }
                });
                \$( \"#addcompositionwindow\" ).dialog({ autoOpen: false,
                                                resizable: false,
                                                zIndex: 9999,
                                                height: 400,
                                                width: 350,
                                                modal: false,
                                                buttons: [  { text: \"Add layers\", click: function(){ editor.AddLayers.addCompositionLayers(); } },
                                                            { text: \"Close\", click: function(){ editor.AddLayers.cancelCompositionAddition(); } }]
                });
                \$( \"#stylelayerwindow\" ).dialog({   autoOpen: false,
                                                    resizable: false,
                                                    zIndex: 9980,
                                                    height: 'auto',
                                                    width: 550,
                                                    modal: true,
                                                    buttons: [  { text: \"Apply\", id: \"applyButton\", title: \"Apply the selected stylization\", click: function(){ editor.LayerStyler.applyLayerStyling(); } },
                                                                { text: \"Close\", click: function(){ \$(this).dialog(\"close\"); } }]
                });
                \$( \"#newcompositionwindow\" ).dialog({   autoOpen: false,
                                                        resizable: false,
                                                        zIndex: 9999,
                                                        height: 'auto',
                                                        width: 500,
                                                        modal: true,
                                                        buttons: [  { text: \"Save\", click: function(){ editor.CompositionSave.applyCompositionData(true); } },
                                                                    { text: \"Close\", click: function(){ \$(this).dialog(\"close\"); } }]
                });
                \$( \"#messagewindow\" ).dialog({  autoOpen: false,
                                                resizable: false,
                                                zIndex: 9999,
                                                height: 'auto',
                                                width: 400,
                                                modal: true,
                                                buttons: { OK : function(){ \$(this).dialog(\"close\"); } }
                });
                \$( \"#messagewindow2\" ).dialog({ autoOpen: false,
                                                resizable: false,
                                                zIndex: 9999,
                                                height: 'auto',
                                                width: 400,
                                                modal: true,
                                                buttons:[   { text: \"Log in\", click: function(){ \$(this).dialog(\"close\"); editor.Authorize.beginAuthentication(); } },
                                                            { text: \"Cancel\", click: function(){ \$(this).dialog(\"close\"); } }]
                });
                \$( \"#authwindow\" ).dialog({ autoOpen: false,
                                            resizable: false,
                                            zIndex: 9999,
                                            height: 'auto',
                                            width: 400,
                                            modal: true,
                                            buttons: [  { text: \"Log In\", click: function(){ editor.Authorize.sendAuthenticationRequest(); } },
                                                        { text: \"Cancel\", click: function(){ \$(this).dialog(\"close\"); } }]
                });
                \$( \"#targetcatalogselector\" ).dialog({  autoOpen: false,
                                                        resizable: false,
                                                        zIndex: 9999,
                                                        height: 'auto',
                                                        width: 550,
                                                        modal: false,
                                                        buttons: [  { text: \"OK\", click: function(){ sendAddToFavoritesRequest(null); \$(this).dialog(\"close\"); } },
                                                                    { text: \"Cancel\", click: function(){ buffer = null; \$(this).dialog(\"close\"); } }]
                });
                \$( \"#rasteropeationswindow\" ).dialog({  autoOpen: false,
                                                        resizable: false,
                                                        zIndex: 9998,
                                                        height: 'auto',
                                                        width: 450,
                                                        modal: false,
                                                        buttons: { \"Cancel\" : function(){ \$(this).dialog(\"close\"); } }
                });
                \$( \"#selectrasterwindow\" ).dialog({ autoOpen: false,
                                                    resizable: false,
                                                    zIndex: 9999,
                                                    height: 'auto',
                                                    width: 400,
                                                    modal: true,
                                                    buttons: { \"Cancel\" : function(){ \$(this).dialog(\"close\"); } }

                });
                \$( \"#selectpalettewindow\" ).dialog({    autoOpen: false,
                                                        resizable: false,
                                                        zIndex: 9985,
                                                        height: 300,
                                                        width: 400,
                                                        modal: true,
                                                        buttons: { \"Cancel\" : function(){ \$(this).dialog(\"close\"); } }

                });
            </script>
        ";
        
        $__internal_7cb0d70138455f17d6db1278f16a831b63ad708ea6d337e7f028b07ce08c58e7->leave($__internal_7cb0d70138455f17d6db1278f16a831b63ad708ea6d337e7f028b07ce08c58e7_prof);

    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:Editor:compositioneditor.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  370 => 178,  355 => 166,  324 => 137,  320 => 135,  314 => 133,  312 => 132,  307 => 131,  305 => 130,  281 => 108,  275 => 107,  265 => 306,  263 => 107,  255 => 101,  251 => 99,  245 => 97,  243 => 96,  239 => 95,  234 => 94,  231 => 93,  221 => 91,  219 => 90,  199 => 73,  194 => 71,  190 => 70,  186 => 69,  182 => 68,  178 => 67,  174 => 66,  170 => 65,  158 => 56,  154 => 55,  150 => 54,  145 => 52,  141 => 51,  137 => 50,  133 => 49,  129 => 48,  125 => 47,  121 => 46,  117 => 45,  112 => 43,  108 => 42,  104 => 41,  100 => 40,  96 => 39,  92 => 38,  87 => 36,  83 => 35,  79 => 34,  75 => 33,  70 => 31,  66 => 30,  45 => 11,  41 => 9,  35 => 7,  33 => 6,  29 => 5,  23 => 1,);
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
        <link rel=\"shortcut icon\" href=\"{{ asset('favicon.ico') }}\" />
        {% if composition != null %}
            <title>{{ composition.name }} :: Composition editor :: project O-GIS</title>
        {% else %}
            <title>Composition editor :: project O-GIS</title>
        {% endif %}
        
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

        <!-- styling and jquery -->
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery/jquery-2.min.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery-ui/jquery-ui.min.js') }}\"></script>
        <script type=\"text/javascript\" src=\"http://openlayers.org/api/OpenLayers.js\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery-context/jquery.contextMenu.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery-context/jquery.ui.position.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/addtofavorites.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery/jstree.min.js') }}\"></script>
        
        <link rel=\"stylesheet\" href=\"{{ asset('./js/imagepicker/image-picker.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./js/jquery-context/jquery.contextMenu.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./js/jquery-ui/jquery-ui.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./css/editor_styles.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./js/jquery/themes/default/style.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./css/jstree-types.css') }}\" />

        <script type=\"text/javascript\" src=\"{{ asset('./EditorJQ/AddLayer.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./EditorJQ/Authorize.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./EditorJQ/CompositionEditor.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./EditorJQ/CompositionObject.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./EditorJQ/CompositionSave.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./EditorJQ/RasterAnalysis.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./EditorJQ/Styler.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./EditorJQ/WMSInfo.js') }}\"></script>

        <link rel=\"stylesheet\" href=\"{{ asset('./EditorJQ/styler-preview.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./js/colors/jquery.minicolors.css') }}\" />
        <script type=\"text/javascript\" src=\"{{ asset('./js/colors/jquery.minicolors.min.js') }}\"></script>
        
        <style>
            .ui-dialog{ z-index: 9999 !important; }
            .ui-widget-overlay{ z-index: 6666 !important; }
        </style>

        <script type=\"text/javascript\">
            var editor = null;
            var catalogData = \"{{ path('loadcatalogdata', {'catid': 'PATH' }) }}\";
            var addToFavRoute = \"{{ path('addtofavorites') }}\";
            var getLayerId = \"{{ path('get_layer_id', {'cs': 'ID'}) }}\";
            var paletteListRoute = \"{{ path('showpalettelisteditor') }}\";
            var getPaletteRoute = \"{{ path('getpalettecompressed', {'id': 'ID'}) }}\";
            var getCompositionData = \"{{ path('getCompositionData', {'id': 'ID'}) }}\";
            var getLayerData = \"{{ path('getLayerData', {'id': 'ID'}) }}\";

            function goToHomePage(){ window.location.href = \"{{ path('homepage') }}\"; }
            
            function initializeEditor(){
                editor = new CompositionEditor();
                editor.setVariable('editor');
                editor.setMapDOM('map_container');
                editor.setLayerListDOM('layerlist');
                editor.setAddLayerWindow('addlayerwindow');
                editor.setAddCompositionWindow('addcompositionwindow');
                editor.setAuthentificationWindow('authwindow');
                editor.setSaveCompositionWindow('newcompositionwindow');
                editor.setStylerWindow('stylelayerwindow');
                editor.setPaletteSelectWindow('selectpalettewindow');
                editor.setRasterOpWindow('rasteropeationswindow');
                editor.setSelectRasterWindow('selectrasterwindow');
                editor.setCursorPositionDom('coordinatesOutput');
                editor.setWaitAnimDom('processingbox');
                {% if app.user != null %}
                    editor.setUser({{ app.user.id }}, \"{{ app.user.username }}\", {{ ulimit }});
                {% endif %}
                {% if composition != null %}
                    editor.initializeCompositionEditor('composition', {{ composition.id }});
                    editor.setEditPermission({{ permission }});
                {% elseif layer != null %}
                    editor.initializeCompositionEditor('layer', {{layer.id}});
                {% else %}
                    editor.initializeCompositionEditor(null, null);
                {% endif %}
            }
        </script>
    </head>
    
    <body class=\"bodyfullpage\" onload=\"initializeEditor();\">

        {% block pagecontent %}
            <div class=\"editorcontentbody\">
                <div class=\"editorwestpanel\">
                    <div id=\"layerlistpanel\" style=\"width:240px;height:100%;float:left;\">
                        <div class=\"editorwestpaneltoolbar\">
                            <span class=\"controlicon\" onclick=\"editor.AddLayers.showAvaliableLayers();\" title=\"Add...\">
                                <img src=\"./EditorJQ/img/add.png\" />
                            </span>
                            <span class=\"controlicon\" onclick=\"editor.RasterAnalysis.beginRasterOperations();\" title=\"Raster operations...\">
                                <img src=\"./EditorJQ/img/mathops.png\" />
                            </span>
                            <span class=\"controlicon\" onclick=\"editor.CompositionSave.reloadComposition();\" title=\"Rollback to last save\">
                                <img src=\"./EditorJQ/img/refresh.png\" />
                            </span>
                            <span class=\"controlicon\" onclick=\"editor.CompositionSave.saveTheComposition(false);\" title=\"Save\">
                                <img src=\"./EditorJQ/img/save.png\" />
                            </span>
                            <span class=\"controlicon\" onclick=\"editor.CompositionSave.saveTheComposition(true);\" title=\"Save as..\">
                                <img src=\"./EditorJQ/img/saveas.png\" />
                            </span>
                            <span class=\"controlicon\" onclick=\"editor.addCompositionToFavorites()\" title=\"Add composition to favorites\">
                                <img src=\"./EditorJQ/img/star.png\" />
                            </span>
                            {% if composition != null %}
                            <span class=\"controlicon\" onclick=\"editor.goToEntity('composition', {{ composition.id }});\" title=\"Leave editor\">
                            {% elseif layer != null %}
                            <span class=\"controlicon\" onclick=\"editor.goToEntity('layer', {{ layer.id }});\" title=\"Leave editor\">
                            {% else %}
                            <span class=\"controlicon\" onclick=\"goToHomePage();\" title=\"Leave editor\">
                            {% endif %}
                                <img src=\"./EditorJQ/img/door.png\" />
                            </span>
                        </div>
                        <div class=\"dragsortlistcontainer\">
                            <ul id=\"layerlist\" class=\"sortable\"></ul>
                            <script type=\"text/javascript\">
                                \$( \"#layerlist\" ).sortable({
                                    stop: function(event, ui){ editor.updateLayerOrder(); }
                                });
                                \$( document ).tooltip();
                            </script>
                        </div>
                    </div>
                    <div class=\"listvisibilitytoggler\">
                        <div id=\"listvisibilitytoggler\" title=\"Hide\" class=\"listvisibilitytogglerbutton\" onclick=\"editor.toggleLayerListVisibility();\">
                            <p style=\"padding-top:11px;font-weight:bold;\">►</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id=\"mappanelmain\" class=\"editormain\">
                <div style=\"width:100%;height:100%\" id=\"map_container\"></div>  
            </div>

            <div class=\"editorcursorposition\"><center style=\"font-size:14px;padding-top:3px;\" id=\"coordinatesOutput\"></center></div>
            <div class=\"processingbox\" id=\"processingbox\" style=\"display:none;\">
                <table width=\"100%\">
                    <tr>
                        <td><img src=\"{{ asset('./img/loading3.gif') }}\"/></td>
                        <td>Processing your request<br/>Please wait...</td>
                    </tr>
                </table>
            </div>
                                
            <div class=\"editorfooter\">
                <table width=\"100%\">
                    <tr>
                        <td width=\"33%\">
                        </td>
                        <td width=\"34%\">
                            <center>(c) O-GIS team, 2014 - {{ \"now\"|date('Y') }}</center>
                        </td>
                        <td align=\"right\">
                            <a href=\"maito:\">O-GIS support</a>
                        </td>
                    </tr>
                </table>
            </div>

            <div id=\"addlayerwindow\" title=\"Adding layer\"></div>
            <div id=\"addcompositionwindow\" title=\"Adding composition\">
                <p>Select layers to add into editor:<br/></p>
                <div id=\"innercmpaddwindow\" style=\"height:260px;overflow-x:hidden;overflow-y:scroll\"></div>
            </div>
            <div id=\"stylelayerwindow\" title=\"Visualization settings\"></div>
            <div id=\"newcompositionwindow\" title=\"Saving composition\"></div>
            <div id=\"messagewindow\" title=\"\"></div>
            <div id=\"messagewindow2\" title=\"Saving composition\"></div>
            <div id=\"authwindow\" title=\"Logging into O-GIS\"></div>
            <div id=\"targetcatalogselector\" title=\"Select catalog\">
                <div id=\"targettree\" style=\"width:100%;height:300px;\"></div>
                <div id=\"targetnodeid\" style=\"display:none\"></div>
                <div id=\"targetnodetype\" style=\"display:none\"></div>
                <div id=\"selectednodeid\" style=\"display:none\"></div>
                <div id=\"selectednode\" style=\"height:20px;width:100%;float:bottom;padding-top:5px;border-top:1px solid #ccc\"></div>
            </div>
            <div id=\"rasteropeationswindow\" title=\"\"></div>
            <div id=\"selectrasterwindow\" title=\"Select raster layer\"></div>
            <div id=\"selectpalettewindow\" title=\"Select palette\"></div>
            <script type=\"text/javascript\">
                \$( \"#addlayerwindow\" ).dialog({ autoOpen: false,
                                                resizable: false,
                                                zIndex: 9999,
                                                height: 500,
                                                width: 600,
                                                modal: false,
                                                buttons: { \"Close\" : function(){ \$(this).dialog(\"close\"); } }
                });
                \$( \"#addcompositionwindow\" ).dialog({ autoOpen: false,
                                                resizable: false,
                                                zIndex: 9999,
                                                height: 400,
                                                width: 350,
                                                modal: false,
                                                buttons: [  { text: \"Add layers\", click: function(){ editor.AddLayers.addCompositionLayers(); } },
                                                            { text: \"Close\", click: function(){ editor.AddLayers.cancelCompositionAddition(); } }]
                });
                \$( \"#stylelayerwindow\" ).dialog({   autoOpen: false,
                                                    resizable: false,
                                                    zIndex: 9980,
                                                    height: 'auto',
                                                    width: 550,
                                                    modal: true,
                                                    buttons: [  { text: \"Apply\", id: \"applyButton\", title: \"Apply the selected stylization\", click: function(){ editor.LayerStyler.applyLayerStyling(); } },
                                                                { text: \"Close\", click: function(){ \$(this).dialog(\"close\"); } }]
                });
                \$( \"#newcompositionwindow\" ).dialog({   autoOpen: false,
                                                        resizable: false,
                                                        zIndex: 9999,
                                                        height: 'auto',
                                                        width: 500,
                                                        modal: true,
                                                        buttons: [  { text: \"Save\", click: function(){ editor.CompositionSave.applyCompositionData(true); } },
                                                                    { text: \"Close\", click: function(){ \$(this).dialog(\"close\"); } }]
                });
                \$( \"#messagewindow\" ).dialog({  autoOpen: false,
                                                resizable: false,
                                                zIndex: 9999,
                                                height: 'auto',
                                                width: 400,
                                                modal: true,
                                                buttons: { OK : function(){ \$(this).dialog(\"close\"); } }
                });
                \$( \"#messagewindow2\" ).dialog({ autoOpen: false,
                                                resizable: false,
                                                zIndex: 9999,
                                                height: 'auto',
                                                width: 400,
                                                modal: true,
                                                buttons:[   { text: \"Log in\", click: function(){ \$(this).dialog(\"close\"); editor.Authorize.beginAuthentication(); } },
                                                            { text: \"Cancel\", click: function(){ \$(this).dialog(\"close\"); } }]
                });
                \$( \"#authwindow\" ).dialog({ autoOpen: false,
                                            resizable: false,
                                            zIndex: 9999,
                                            height: 'auto',
                                            width: 400,
                                            modal: true,
                                            buttons: [  { text: \"Log In\", click: function(){ editor.Authorize.sendAuthenticationRequest(); } },
                                                        { text: \"Cancel\", click: function(){ \$(this).dialog(\"close\"); } }]
                });
                \$( \"#targetcatalogselector\" ).dialog({  autoOpen: false,
                                                        resizable: false,
                                                        zIndex: 9999,
                                                        height: 'auto',
                                                        width: 550,
                                                        modal: false,
                                                        buttons: [  { text: \"OK\", click: function(){ sendAddToFavoritesRequest(null); \$(this).dialog(\"close\"); } },
                                                                    { text: \"Cancel\", click: function(){ buffer = null; \$(this).dialog(\"close\"); } }]
                });
                \$( \"#rasteropeationswindow\" ).dialog({  autoOpen: false,
                                                        resizable: false,
                                                        zIndex: 9998,
                                                        height: 'auto',
                                                        width: 450,
                                                        modal: false,
                                                        buttons: { \"Cancel\" : function(){ \$(this).dialog(\"close\"); } }
                });
                \$( \"#selectrasterwindow\" ).dialog({ autoOpen: false,
                                                    resizable: false,
                                                    zIndex: 9999,
                                                    height: 'auto',
                                                    width: 400,
                                                    modal: true,
                                                    buttons: { \"Cancel\" : function(){ \$(this).dialog(\"close\"); } }

                });
                \$( \"#selectpalettewindow\" ).dialog({    autoOpen: false,
                                                        resizable: false,
                                                        zIndex: 9985,
                                                        height: 300,
                                                        width: 400,
                                                        modal: true,
                                                        buttons: { \"Cancel\" : function(){ \$(this).dialog(\"close\"); } }

                });
            </script>
        {% endblock %}

    </body>
</html>
", "OGISIndexBundle:Editor:compositioneditor.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/Editor/compositioneditor.html.twig");
    }
}
