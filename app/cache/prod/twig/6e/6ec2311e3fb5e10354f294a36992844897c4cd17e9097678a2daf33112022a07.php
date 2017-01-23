<?php

/* OGISIndexBundle:Lists:layerlist.html.twig */
class __TwigTemplate_d982973034bd06a3319ec791aef6bfbe682dd985510c60c7192a4cd12210e78f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'bodycontent' => array($this, 'block_bodycontent'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
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
\t\t<title>Layer list</title>
\t\t<link rel=\"stylesheet\" href=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./css/editor_list.css"), "html", null, true);
        echo "\" />
\t\t<link rel=\"stylesheet\" href=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/themes/default/style.css"), "html", null, true);
        echo "\" />
\t\t<script type=\"text/javascript\" src=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/jquery-2.min.js"), "html", null, true);
        echo "\"></script>
\t\t<script type=\"text/javascript\" src=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("./js/jquery/jstree.min.js"), "html", null, true);
        echo "\"></script>

\t\t<style>
\t\t\ta { color: #4040af; }
\t\t</style>

\t\t<script type=\"text/javascript\">
        var rootNodes = \"";
        // line 35
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("loaduserandglobalcatalogs");
        echo "\";
        var catalogData = \"";
        // line 36
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("loadcatalogdataeditor", array("catid" => "PATH"));
        echo "\";
                    
        function loadCatalogContents(node){
            if (node.loaded !== undefined){ return; }
            if (!node.type.match(/^catalog/g)){
                if (node.type === 'composition'){
                    parent.editor.AddLayers.addThisComposition(node.text, node.data );
                }
                else {
                    parent.editor.AddLayers.addThisLayer(node.text, node.data);
                }
                return;
            }

            node.loaded = true;
            var url = catalogData.replace('PATH', node.id);
            \$.ajax(url)
                .done(function(msg){
                    var tree = \$('#foldertree').jstree(true);
                    for (var i = 0; i < msg.catalogs.length; i++){
                        var newNode = msg.catalogs[i];
                        tree.create_node(newNode.parent, newNode);
                    }
                    for (var i = 0; i < msg.links.length; i++){
                        var newNode = msg.links[i];
                        tree.create_node(newNode.parent, newNode);
                    }
                    tree.open_node(node.id);
                })
                .fail(function(){
                    console.log(\"Error while acquiring data!\");
                    delete node.loaded;
                });
        }
                    
\t\t\tfunction loadUserCatalogs(){
          \$.ajax(rootNodes)
              .done(function(msg){
                  \$('#foldertree').jstree({
                      'core' : {
                          'multiple' : false,
                          'data' : msg.catalogs,
                          'check_callback': true
                      },
                      'types':{
                          \"catalog\": {icon: \"./img/icons/catalog.png\"},
                          \"layer\": {icon: \"./img/icons/layer.png\"},
                          \"raster\": {icon: \"./img/icons/raster.png\"},
                          \"line\": {icon: \"./img/icons/line.png\"},
                          \"point\": {icon: \"./img/icons/point.png\"},
                          \"polygon\": {icon: \"./img/icons/polygon.png\"},
                          \"composition\": {icon: \"./img/icons/composition.png\"},
                          \"style\": {icon: \"./img/icons/style.png\"},
                          \"external\": {icon: \"./img/icons/external.png\"}
                      },
                      'plugins': [ \"sort\", \"types\", \"contextmenu\" ],
                      'sort': function (a, b) {
                          var nodeA = this.get_node(a);
                          var nodeB = this.get_node(b);
                          if (nodeA.type.match(/^catalog/g) && !nodeB.type.match(/^catalog/g)){ return -1; }
                          if (!nodeA.type.match(/^catalog/g) && nodeB.type.match(/^catalog/g)){ return 1; }
                          return this.get_text(a) > this.get_text(b) ? 1 : -1;
                      },
                  }).on('select_node.jstree', function(e, data){
                      loadCatalogContents(data.node);
                  });
              })
              .fail(function(){
                  \$('#foldertree').append('<div class=\"loaderrormsg\"><b>Error while loading data!</b></div>');
              });
          }
\t\t</script>

\t</head>

\t<body onload=\"loadUserCatalogs();\">
\t\t";
        // line 112
        $this->displayBlock('bodycontent', $context, $blocks);
        // line 117
        echo "\t</body>
</html>
";
    }

    // line 112
    public function block_bodycontent($context, array $blocks = array())
    {
        // line 113
        echo "
\t\t\t<div  id=\"foldertree\"></div>

\t\t";
    }

    public function getTemplateName()
    {
        return "OGISIndexBundle:Lists:layerlist.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  165 => 113,  162 => 112,  156 => 117,  154 => 112,  75 => 36,  71 => 35,  61 => 28,  57 => 27,  53 => 26,  49 => 25,  44 => 23,  20 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "OGISIndexBundle:Lists:layerlist.html.twig", "D:\\dev\\o-gis\\src\\OGIS\\IndexBundle/Resources/views/Lists/layerlist.html.twig");
    }
}
