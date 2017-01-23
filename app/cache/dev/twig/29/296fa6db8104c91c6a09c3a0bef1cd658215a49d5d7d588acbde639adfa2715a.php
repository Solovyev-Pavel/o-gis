<?php

/* OGISIndexBundle:Create:createlayer.html.twig */
class __TwigTemplate_3f8325060fd0f0d9b826441b8d4a23a8b36dcafc1159217f51d514f0362193e3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("OGISIndexBundle:Default:header.html.twig", "OGISIndexBundle:Create:createlayer.html.twig", 120);
        // line 120
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
        $__internal_76e7b5343f1dfba99878334976d38cf2fc50b813bd50220e2d48d752391459ce = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_76e7b5343f1dfba99878334976d38cf2fc50b813bd50220e2d48d752391459ce->enter($__internal_76e7b5343f1dfba99878334976d38cf2fc50b813bd50220e2d48d752391459ce_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "OGISIndexBundle:Create:createlayer.html.twig"));

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
        <title>Creating layer :: project O-GIS</title>
        <link rel=\"stylesheet\" href=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/ogis_styles.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/jstree-types.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/themes/default/style.css"), "html", null, true);
        echo "\" />
        <link rel=\"stylesheet\" href=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-ui/jquery-ui.css"), "html", null, true);
        echo "\" />
        <script type=\"text/javascript\" src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/jquery-2.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/jstree.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery-ui/jquery-ui.min.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/addtofavorites.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jszip.js"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jszip-utils.js"), "html", null, true);
        echo "\"></script>

        <script type=\"text/javascript\">
            var catalogData = \"";
        // line 37
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("loadcatalogdata", array("catid" => "PATH"));
        echo "\";
            var rootFavNodes = \"";
        // line 38
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("loadusercatalogs", array("holderid" => $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "id", array()))), "html", null, true);
        echo "\";    
            
            function validateInput(){
                // check layer title
                var title = \$('#layername').val();
                title = title.replace(/^[\\s\\r\\n]+|[\\s\\r\\n]+\$/gm,'');
                if (title.length < 1 || title[0] === ''){
                    var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">You should enter a meaningful name for your layer!</td></tr></table>';
                    \$('#errormessagewindow').empty();
                    \$('#errormessagewindow').append(html);
                    \$('#errormessagewindow').dialog('open');
                    return false;
                }
                // check selected node
                var node = \$('#selectednodeid').text();
                if (node === '' || node === null || node === undefined){
                    var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">You should choose a catalog to place a link to your layer into!</td></tr></table>';
                    \$('#errormessagewindow').empty();
                    \$('#errormessagewindow').append(html);
                    \$('#errormessagewindow').dialog('open');
                    return false;
                }
                else{
                    \$('#targetnode').prop('value', node);
                }
                // check archive with files
                var file = document.getElementById(\"layerfile\").files[0];
                if (!file || !file.name.toLowerCase().match(/\\.zip\$/g)){
                    var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">Please, choose a *.zip archive with layer\\'s files!</td></tr></table>';
                    \$('#errormessagewindow').empty();
                    \$('#errormessagewindow').append(html);
                    \$('#errormessagewindow').dialog('open');
                    return false;
                }
                else{
                    // check that the archive indeed contains all the required layer files
                    var fileReader = new FileReader();
                    var wimg_files = 0;
                    var esri_files = 0;
                    var counter = 0;
                    
                    fileReader.onload = (function(fileLoadedEvent){
                        return function(e){
                            var zip = new JSZip(e.target.result);
                            for (var fileInZip in zip.files){
                                counter++;
                                var file = zip.files[fileInZip];
                                // WorldImage Tiff
                                if (file.name.toLowerCase().match(/\\.tfw\$/g)){ wimg_files++; }
                                if (file.name.toLowerCase().match(/\\.tif\$/g)){ wimg_files++; }
                                if (file.name.toLowerCase().match(/\\.prj\$/g)){ wimg_files++; }
                                // ESRI ShapeFile
                                if (file.name.toLowerCase().match(/\\.dbf\$/g)){ esri_files++; }
                                if (file.name.toLowerCase().match(/\\.prj\$/g)){ esri_files++; }
                                if (file.name.toLowerCase().match(/\\.shp\$/g)){ esri_files++; }
                                if (file.name.toLowerCase().match(/\\.shx\$/g)){ esri_files++; }
                            }
                            // validate archive contents
                            if (counter === wimg_files){
                                if (counter === 1){ document.getElementById(\"layertype\").value = \"geotiff\"; }
                                else { document.getElementById(\"layertype\").value = \"worldimage\"; }
                                document.getElementById(\"layerform\").submit();
                                return;
                            }
                            if (counter === 4 && esri_files === 4){
                                document.getElementById(\"layertype\").value = \"shp\";
                                document.getElementById(\"layerform\").submit();
                                return;
                            }
                            var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">Please check the files in the archive!\\r\\n* There may be missing or extra files\\r\\n* Or the layer is in an unsupported format</td></tr></table>';
                            \$('#errormessagewindow').empty();
                            \$('#errormessagewindow').append(html);
                            \$('#errormessagewindow').dialog('open');
                        };
                    })(file);
                    fileReader.readAsArrayBuffer(file);
                }
            }
        </script>
    </head>
    <body class=\"bodyfullpage\" onload=\"showTargetCatalogTree();\">

        ";
        // line 121
        echo "        ";
        $this->displayBlock('header', $context, $blocks);
        // line 124
        echo "
        ";
        // line 125
        $this->displayBlock('pagecontent', $context, $blocks);
        // line 202
        echo "
        ";
        // line 203
        $this->displayBlock('footer', $context, $blocks);
        // line 206
        echo "    </body>
</html>
";
        
        $__internal_76e7b5343f1dfba99878334976d38cf2fc50b813bd50220e2d48d752391459ce->leave($__internal_76e7b5343f1dfba99878334976d38cf2fc50b813bd50220e2d48d752391459ce_prof);

    }

    // line 121
    public function block_header($context, array $blocks = array())
    {
        $__internal_0ca02358a1b33d55c99d8781ec2bff35de5f15f1b416e217fddbceeb68b79a6b = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0ca02358a1b33d55c99d8781ec2bff35de5f15f1b416e217fddbceeb68b79a6b->enter($__internal_0ca02358a1b33d55c99d8781ec2bff35de5f15f1b416e217fddbceeb68b79a6b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        // line 122
        echo "                ";
        $this->displayParentBlock("header", $context, $blocks);
        echo "
        ";
        
        $__internal_0ca02358a1b33d55c99d8781ec2bff35de5f15f1b416e217fddbceeb68b79a6b->leave($__internal_0ca02358a1b33d55c99d8781ec2bff35de5f15f1b416e217fddbceeb68b79a6b_prof);

    }

    // line 125
    public function block_pagecontent($context, array $blocks = array())
    {
        $__internal_0e5974f505ec7c7078f1b595084da403321d6b63a198fa3637e4b7780f1497cc = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0e5974f505ec7c7078f1b595084da403321d6b63a198fa3637e4b7780f1497cc->enter($__internal_0e5974f505ec7c7078f1b595084da403321d6b63a198fa3637e4b7780f1497cc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "pagecontent"));

        // line 126
        echo "
            <div class=\"contentbody\">
                <div class=\"paraminputbox\">
                    <div class=\"userlistheader\">A Layer to Upload</div>
                    <table width=\"100%\">
                        <form action=\"";
        // line 131
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("layer_upload");
        echo "\" method=\"post\" id=\"layerform\" enctype=\"multipart/form-data\">
                            <tr>
                                <td width=\"155px\"><label for=\"layername\"><b>Layer's Title</b>:</label>&nbsp;</td>
                                <td style=\"text-align:right\">
                                    <input type=\"text\" style=\"width:300px\" id=\"layername\" name=\"_layername\" maxlength=\"256\" value=\"\" />
                                </td>
                            </tr>
                            <tr>
                                <td><label for=\"description\"><b>Layer's Description</b>:</label>&nbsp;</td>
                                <td style=\"text-align:right\">
                                    <textarea style=\"width:300px;resize:none;\" rows=\"5\" form=\"layerform\" name=\"_layerdescription\" maxlength=\"1024\"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Target Catalog</b>:&nbsp;</td>
                                <td>
                                    <input type=\"hidden\" name=\"_targetcatalog\" id=\"targetnode\" value=\"\"/>
                                    <div style=\"display:none\" id=\"selectednodeid\"></div>
                                    <div class=\"catalogtreediv\" id=\"targettree\"></div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for=\"layerfile\"><b>Archive with Files</b>:</label>&nbsp;</td>
                                <td style=\"padding-left:29px\">
                                    <input type=\"file\" style=\"width:300px\" id=\"layerfile\" name=\"_layerfile\" value=\"\"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=\"2\">
                                    <br/>
                                    <input type=\"hidden\" id=\"layertype\" name=\"_layertype\" value=\"\"/>
                                    <input type=\"button\" onclick=\"validateInput();\" id=\"uploadbutton\" style=\"width:155px\" value=\"Загрузить слой\"/>
                                </td>
                            </tr>
                        </form>
                    </table>
                </div>

                <div class=\"helpboxmain\">
                    <div class=\"userlistheader\">Rules and Information:</div>
                    <div>
                        <ol>
                            <li>Field \"Layer's Title\" must be filled. First character can't be whitespace</li>
                            <li>Field \"Layer's Description\" can be left empty.</li>
                            <li>You must choose a catalog into which a link to your layer will be placed. Later, it can be copied or moved to any other catalog.</li>
                            <li>All necessary files of the layer must be placed in the root of an unprotected *.zip archive. No other files can be in there.</li>
                            <li>The following layer formats are supported:
                                <ol>
                                    <li>GeoTiff (*.tif file)</li>
                                    <li>WorldImage Tiff (*.tfw и *.tif files)</li>
                                    <li>ESRI Shapefile (*.dbf, *.prj, *.shp и *.shx files)</li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
                            
            <div id=\"errormessagewindow\" title=\"Error\"></div>
            <script type=\"text/javascript\">
                \$( \"#errormessagewindow\" ).dialog({
                        autoOpen: false,
                        resizable: false,
                        zIndex: 9999,
                        height: 'auto',
                        width: 400,
                        modal: true,
                        buttons: { OK : function(){ \$(this).dialog(\"close\"); }
                    }});
            </script>
        ";
        
        $__internal_0e5974f505ec7c7078f1b595084da403321d6b63a198fa3637e4b7780f1497cc->leave($__internal_0e5974f505ec7c7078f1b595084da403321d6b63a198fa3637e4b7780f1497cc_prof);

    }

    // line 203
    public function block_footer($context, array $blocks = array())
    {
        $__internal_40512a288508f77e37d84b416f5c4eb1a8a7274cab93cfa00352e9eea491e654 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_40512a288508f77e37d84b416f5c4eb1a8a7274cab93cfa00352e9eea491e654->enter($__internal_40512a288508f77e37d84b416f5c4eb1a8a7274cab93cfa00352e9eea491e654_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        // line 204
        echo "                ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
        ";
        
        $__internal_40512a288508f77e37d84b416f5c4eb1a8a7274cab93cfa00352e9eea491e654->leave($__internal_40512a288508f77e37d84b416f5c4eb1a8a7274cab93cfa00352e9eea491e654_prof);

    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:Create:createlayer.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  332 => 204,  326 => 203,  248 => 131,  241 => 126,  235 => 125,  225 => 122,  219 => 121,  210 => 206,  208 => 203,  205 => 202,  203 => 125,  200 => 124,  197 => 121,  112 => 38,  108 => 37,  102 => 34,  98 => 33,  94 => 32,  90 => 31,  86 => 30,  82 => 29,  78 => 28,  74 => 27,  70 => 26,  66 => 25,  61 => 23,  37 => 1,  14 => 120,);
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
        <title>Creating layer :: project O-GIS</title>
        <link rel=\"stylesheet\" href=\"{{ asset('./css/ogis_styles.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./css/jstree-types.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./js/jquery/themes/default/style.css') }}\" />
        <link rel=\"stylesheet\" href=\"{{ asset('./js/jquery-ui/jquery-ui.css') }}\" />
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery/jquery-2.min.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery/jstree.min.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jquery-ui/jquery-ui.min.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/addtofavorites.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jszip.js') }}\"></script>
        <script type=\"text/javascript\" src=\"{{ asset('./js/jszip-utils.js') }}\"></script>

        <script type=\"text/javascript\">
            var catalogData = \"{{ path('loadcatalogdata', {'catid': 'PATH' }) }}\";
            var rootFavNodes = \"{{ path('loadusercatalogs', {'holderid': app.user.id}) }}\";    
            
            function validateInput(){
                // check layer title
                var title = \$('#layername').val();
                title = title.replace(/^[\\s\\r\\n]+|[\\s\\r\\n]+\$/gm,'');
                if (title.length < 1 || title[0] === ''){
                    var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">You should enter a meaningful name for your layer!</td></tr></table>';
                    \$('#errormessagewindow').empty();
                    \$('#errormessagewindow').append(html);
                    \$('#errormessagewindow').dialog('open');
                    return false;
                }
                // check selected node
                var node = \$('#selectednodeid').text();
                if (node === '' || node === null || node === undefined){
                    var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">You should choose a catalog to place a link to your layer into!</td></tr></table>';
                    \$('#errormessagewindow').empty();
                    \$('#errormessagewindow').append(html);
                    \$('#errormessagewindow').dialog('open');
                    return false;
                }
                else{
                    \$('#targetnode').prop('value', node);
                }
                // check archive with files
                var file = document.getElementById(\"layerfile\").files[0];
                if (!file || !file.name.toLowerCase().match(/\\.zip\$/g)){
                    var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">Please, choose a *.zip archive with layer\\'s files!</td></tr></table>';
                    \$('#errormessagewindow').empty();
                    \$('#errormessagewindow').append(html);
                    \$('#errormessagewindow').dialog('open');
                    return false;
                }
                else{
                    // check that the archive indeed contains all the required layer files
                    var fileReader = new FileReader();
                    var wimg_files = 0;
                    var esri_files = 0;
                    var counter = 0;
                    
                    fileReader.onload = (function(fileLoadedEvent){
                        return function(e){
                            var zip = new JSZip(e.target.result);
                            for (var fileInZip in zip.files){
                                counter++;
                                var file = zip.files[fileInZip];
                                // WorldImage Tiff
                                if (file.name.toLowerCase().match(/\\.tfw\$/g)){ wimg_files++; }
                                if (file.name.toLowerCase().match(/\\.tif\$/g)){ wimg_files++; }
                                if (file.name.toLowerCase().match(/\\.prj\$/g)){ wimg_files++; }
                                // ESRI ShapeFile
                                if (file.name.toLowerCase().match(/\\.dbf\$/g)){ esri_files++; }
                                if (file.name.toLowerCase().match(/\\.prj\$/g)){ esri_files++; }
                                if (file.name.toLowerCase().match(/\\.shp\$/g)){ esri_files++; }
                                if (file.name.toLowerCase().match(/\\.shx\$/g)){ esri_files++; }
                            }
                            // validate archive contents
                            if (counter === wimg_files){
                                if (counter === 1){ document.getElementById(\"layertype\").value = \"geotiff\"; }
                                else { document.getElementById(\"layertype\").value = \"worldimage\"; }
                                document.getElementById(\"layerform\").submit();
                                return;
                            }
                            if (counter === 4 && esri_files === 4){
                                document.getElementById(\"layertype\").value = \"shp\";
                                document.getElementById(\"layerform\").submit();
                                return;
                            }
                            var html = '<table><tr><td width=\"64px\"><img src=\"./img/error.png\"/></td><td valign=\"middle\">Please check the files in the archive!\\r\\n* There may be missing or extra files\\r\\n* Or the layer is in an unsupported format</td></tr></table>';
                            \$('#errormessagewindow').empty();
                            \$('#errormessagewindow').append(html);
                            \$('#errormessagewindow').dialog('open');
                        };
                    })(file);
                    fileReader.readAsArrayBuffer(file);
                }
            }
        </script>
    </head>
    <body class=\"bodyfullpage\" onload=\"showTargetCatalogTree();\">

        {% use 'OGISIndexBundle:Default:header.html.twig' %}
        {% block header %}
                {{ parent() }}
        {% endblock %}

        {% block pagecontent %}

            <div class=\"contentbody\">
                <div class=\"paraminputbox\">
                    <div class=\"userlistheader\">A Layer to Upload</div>
                    <table width=\"100%\">
                        <form action=\"{{ path('layer_upload') }}\" method=\"post\" id=\"layerform\" enctype=\"multipart/form-data\">
                            <tr>
                                <td width=\"155px\"><label for=\"layername\"><b>Layer's Title</b>:</label>&nbsp;</td>
                                <td style=\"text-align:right\">
                                    <input type=\"text\" style=\"width:300px\" id=\"layername\" name=\"_layername\" maxlength=\"256\" value=\"\" />
                                </td>
                            </tr>
                            <tr>
                                <td><label for=\"description\"><b>Layer's Description</b>:</label>&nbsp;</td>
                                <td style=\"text-align:right\">
                                    <textarea style=\"width:300px;resize:none;\" rows=\"5\" form=\"layerform\" name=\"_layerdescription\" maxlength=\"1024\"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Target Catalog</b>:&nbsp;</td>
                                <td>
                                    <input type=\"hidden\" name=\"_targetcatalog\" id=\"targetnode\" value=\"\"/>
                                    <div style=\"display:none\" id=\"selectednodeid\"></div>
                                    <div class=\"catalogtreediv\" id=\"targettree\"></div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for=\"layerfile\"><b>Archive with Files</b>:</label>&nbsp;</td>
                                <td style=\"padding-left:29px\">
                                    <input type=\"file\" style=\"width:300px\" id=\"layerfile\" name=\"_layerfile\" value=\"\"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=\"2\">
                                    <br/>
                                    <input type=\"hidden\" id=\"layertype\" name=\"_layertype\" value=\"\"/>
                                    <input type=\"button\" onclick=\"validateInput();\" id=\"uploadbutton\" style=\"width:155px\" value=\"Загрузить слой\"/>
                                </td>
                            </tr>
                        </form>
                    </table>
                </div>

                <div class=\"helpboxmain\">
                    <div class=\"userlistheader\">Rules and Information:</div>
                    <div>
                        <ol>
                            <li>Field \"Layer's Title\" must be filled. First character can't be whitespace</li>
                            <li>Field \"Layer's Description\" can be left empty.</li>
                            <li>You must choose a catalog into which a link to your layer will be placed. Later, it can be copied or moved to any other catalog.</li>
                            <li>All necessary files of the layer must be placed in the root of an unprotected *.zip archive. No other files can be in there.</li>
                            <li>The following layer formats are supported:
                                <ol>
                                    <li>GeoTiff (*.tif file)</li>
                                    <li>WorldImage Tiff (*.tfw и *.tif files)</li>
                                    <li>ESRI Shapefile (*.dbf, *.prj, *.shp и *.shx files)</li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
                            
            <div id=\"errormessagewindow\" title=\"Error\"></div>
            <script type=\"text/javascript\">
                \$( \"#errormessagewindow\" ).dialog({
                        autoOpen: false,
                        resizable: false,
                        zIndex: 9999,
                        height: 'auto',
                        width: 400,
                        modal: true,
                        buttons: { OK : function(){ \$(this).dialog(\"close\"); }
                    }});
            </script>
        {% endblock %}

        {% block footer %}
                {{ parent() }}
        {% endblock %}
    </body>
</html>
", "OGISIndexBundle:Create:createlayer.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/Create/createlayer.html.twig");
    }
}
