<?php

/* ************************************************************************** *
 *   Copyright © 2015       Pavel Solovyev (solovyev.p.a@gmail.com)           *
 *                          Sergey Sevryukov (sevrukovs@gmail.com)            *
 *                          Alexander Afonin (acer737@yandex.ru)              *
 *                                                                            *
 *   Licensed under the Apache License, Version 2.0 (the "License");          *
 *   you may not use this file except in compliance with the License.         *
 *   You may obtain a copy of the License at                                  *
 *               http://www.apache.org/licenses/LICENSE-2.0                   *
 *                                                                            *
 *   Unless required by applicable law or agreed to in writing, software      *
 *   distributed under the License is distributed on an "AS IS" BASIS,        *
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. *
 *   See the License for the specific language governing permissions and      *
 *   limitations under the License.                                           *
 * ************************************************************************** */

namespace OGIS\IndexBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RestoreController extends Controller{
    
    // registers a style
    protected function registerStyle($styleName){
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver/rest/styles";
        $body = "<style><name>$styleName</name><filename>$styleName.sld</filename></style>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $code;
    }
    
    // registers a vector ESRI Shapefile layer
    protected function registerVectorLayer($title, $descr, $name){
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver";
        $targetDir = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        
        // step 1: create store        
        $data = "file://$targetDir/$name/$name.shp";
        
        $ch = curl_init();
        $targeturl = "$url/rest/workspaces/OGIS/datastores/$name/external.shp?configure=first";
        curl_setopt($ch, CURLOPT_URL, $targeturl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/plain"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($code != 201 && $code != 200){ return 'Error!'; }
        
        // step 2: create layer in store
        $data = "<featureType><name>$name</name><nativeName>$name</nativeName><title>$title</title><description>$descr</description></featureType>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/workspaces/OGIS/datastores/$name/featuretypes");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, htmlentities($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // step 3: ensure that the layer is enabled
        $data = "<layer><enabled>true</enabled></layer>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/layers/OGIS:$name");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, htmlentities($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return "Success!";
    }
    
    // registers a raster WorldImage/Tiff layer
    protected function registerRasterLayer($title, $descr, $name, $layertype){
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver";
        $targetDir = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        
        // step 1: create store
        $data = "file://$targetDir/$name/$name.tif";
        
        $ch = curl_init();
        $targeturl = "$url/rest/workspaces/OGIS/coveragestores/$name/external.$layertype?configure=first&coverageName=$name";
        curl_setopt($ch, CURLOPT_URL, $targeturl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/plain"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($code != 201 && $code != 200){ return "Error! $code"; }
        
        // step 2: set layer properties
        $data = "<coverage><nativeName>$name</nativeName><title>$title</title><description>$descr</description><enabled>true</enabled></coverage>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/workspaces/OGIS/coveragestores/$name/coverages/$name");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, htmlentities($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        
        // step 3: ensure that the layer is enabled
        $data = "<layer><enabled>true</enabled></layer>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/layers/OGIS:$name");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, htmlentities($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return "Success!";
    }
    
    // generates a layer preview
    protected function generateLayerPreview($name){
        $server = $_SERVER['SERVER_ADDR'];
        $previewurl = "http://$server:8080/geoserver/wms/reflect?LAYERS=OGIS:$name";
        $targetDir = realpath(__DIR__ . '/../../../../web/');
        $path = "$targetDir/img/layer_previews/$name.png";

        $context = stream_context_create(array('http' => array('header' => "Authorization: Basic " . base64_encode("admin:geoserver"))));
        $data = file_get_contents($previewurl, false, $context);

        file_put_contents($path, $data);
    }
    
    // changes layer's style
    protected function applyStyleToLayer($styleName, $layerCS){
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver/";

        // change layer's default style
        $body = "<layer><defaultStyle><name>$styleName</name></defaultStyle></layer>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "rest/layers/$layerCS");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // refresh layer enability
        $body = "<layer><enabled>true</enabled></layer>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "rest/layers/$layerCS");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // generate new preview for the layer
        $cs = substr($layerCS, strpos($layerCS, ':') + 1);
        $previewurl = "http://$server:8080/geoserver/wms/reflect?LAYERS=$layerCS&STYLES=$styleName";

        $context = stream_context_create(array('http' => array('header' => "Authorization: Basic " . base64_encode("admin:geoserver"))));
        $im = file_get_contents($previewurl, false, $context);

        $directory = realpath(__DIR__ . '/../../../../web/img/layer_previews/');
        $path = "$directory/$cs.png";
        $output = fopen($path, 'wb');
        fwrite($output, $im);
        fclose($output);
    }
    
    // this method takes the DB of the system and re-registers all layers
    // and styles with the GeoServer (provided all of the necessary files
    // exist on the disk)
    public function RestoreOGISAction(){
        
        //return new response("!", 200);
        
        // global constants
        $path_to_styles = '/var/lib/tomcat7/webapps/geoserver/data/styles/';
        $path_to_layers = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        $registered = 0;
        $deleted = 0;
        // order of actions:

        // 1. read the list of named styles in the system (mostly to provide
        // backwards compatability now) and register these styles with the
        // GeoServer.
        $em = $this->getDoctrine()->getManager();
        $objects = $em->getRepository('OGIS\IndexBundle\Entity\Style')->findAll();
        foreach($objects as $style){
            $name = $style->getInternalname();
            if (file_exists("$path_to_styles/$name.sld")){
                // remove old xml files for styles - they aren't needed here
                unlink("$path_to_styles/$name.xml");
                // we have the style SLD file : register a GeoServer style using it
                $i = self::registerStyle($name);
                $registered++;
            }
            else{
                // we don't have the data file for this style. Remove it from O-GIS DB?
                $em->remove($style);
                $em->flush();
                $deleted++;
            }
        }
        // 2. read the list of layers. If layer->getPalette() != null,
        // register a style with the name = layer->getConString() with the
        // GeoServer. Then register the layer itself with the GeoServer and
        // apply the selected style to the layer.
        $objects = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->findAll();
        foreach($objects as $layer){
            $name = $layer->getConString();
            $type = ($layer->getType() == 'raster') ? 'tif' : 'shp';
            $file = "$path_to_layers/$name/$name.$type";
            $cstyle = $layer->getPalette();
            if (file_exists($file)){
                $title = $layer->getName();
                $descr = $layer->getDescription();
                if ($cstyle){
                    // this layer is supposed to have a custom-built SLD; check its existence
                    if (file_exists("$path_to_styles/$name.sld")){
                        // remove old xml files for styles - they aren't needed here
                        unlink("$path_to_styles/$name.xml");
                        // we have the style SLD file : register a GeoServer style using it
                        $i = self::registerStyle($name);
                        $registered++;
                    }
                    else{
                        $layer->setPalette(null);
                        $em->persist($layer);
                        $em->flush();
                    }
                }
                // now we register the layers
                if ($type == 'shp'){
                    $i = self::registerVectorLayer($title, $descr, $name);
                }
                else{
                    if (file_exists("$path_to_layers/$name/$name.tfw")){ $RasterType = 'worldimage'; }
                    else{ $RasterType = 'geotiff'; }
                    $i = self::registerRasterLayer($title, $descr, $name, $RasterType);
                }
                $registered++;
                if ($cstyle != null){
                    $i = self::applyStyleToLayer($name, $name);
                }
                elseif ($layer->getStyle() != null){
                    $style = $layer->getStyle()->getInternalname();
                    $i = self::applyStyleToLayer($style, $name);
                }
                else{
                    // do nothing - no custom style was applied to this layer
                }
            }
            else {
                // we don't have the data files for this layer. Remove it from O-GIS DB?
                $em->remove($layer);
                $em->flush();
                $deleted++;
            }
        }
        $response_msg = "$registered entities successfully restored in GeoServer.<br/>" .
                        "$deleted entities deleted due to the lack of necessary files.";
        return new response($response_msg, 200);
    }
}
