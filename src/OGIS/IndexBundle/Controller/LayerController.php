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
use OGIS\IndexBundle\Entity\Layer;
use OGIS\IndexBundle\Entity\Link;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class LayerController extends Controller {
    
    // -------------------- protected internal methods ---------------------- \\
   
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
    
    // unregister a layer
    protected function unregisterLayer($name, $type){
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/layers/OGIS:$name");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($type == "shp"){
            $store = 'datastores';
            $data = 'featuretypes';
        }
        else{
            $store = 'coveragestores';
            $data = 'coverages';
        }
            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/workspaces/OGIS/$store/$name/$data/$name");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/workspaces/OGIS/$store/$name");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
    }
    
    // remove a layer preview image
    protected function removePreview($name){
        $targetDir = realpath(__DIR__ . '/../../../../web/');
        $path = "$targetDir/img/layer_previews/$name.png";
        unlink($path);
    }
    
    // remove a directory and its contents
    protected function rrmdir($dir) { 
        foreach(glob($dir . '/*') as $file) { 
            if(is_dir($file)){ rrmdir($file); }
            else{ unlink($file); }
        } rmdir($dir); 
    }

    // ---------------------- public available methods ---------------------- \\

    // layer list
    public function showListAction($sortby, $page){
        switch($sortby){
            case 'bymodified':	$filter = 'modified'; break;
            case 'bycreated':	$filter = 'id'; break;
            case 'byauthor':	$filter = 'author'; break;
            case 'byname':	$filter = 'name'; break;
            default:		$filter = 'modified'; break;
        }
        $startfrom = ($page - 1) * 10;
        $sql = "SELECT c FROM OGISIndexBundle:Layer c ORDER BY c.$filter ";
        if ($filter == 'name') { $sql .= 'ASC'; }
        elseif ($filter == 'author'){ $sql .= 'ASC, c.id ASC'; }
        else { $sql .= 'DESC, c.id DESC'; }

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($sql);
        $layers = $query->setMaxResults(10)->setFirstResult($startfrom)->getResult();

        $sql = "SELECT COUNT(c) FROM OGISIndexBundle:Layer c";
        $query = $em->createQuery($sql);
        $total = $query->getSingleScalarResult();

        return $this->render('OGISIndexBundle:Lists:layers.html.twig', array(
            'layers' => $layers,
            'cpage' => $page,
            'total' => $total,
            'filter' => $sortby
        ));
    }

    public function layerListForAddFunctionAction(){
        return $this->render('OGISIndexBundle:Lists:layerlist.html.twig');
    }
    
    public function rasterListFunctionAction(){
        return $this->render('OGISIndexBundle:Lists:rasterlayerlist.html.twig');
    }
    
    public function rasterListEditorFunctionAction(){
        return $this->render('OGISIndexBundle:Lists:rasterslist.html.twig');
    }

    // create a layer page
    public function createLayerAction(){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($this->getUser()->getId());
        $limit = $user->getLimits()->getLayers();
        if ($limit != null && count($user->getLayers()) > $limit){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Layers cap is reached!",
                'message' => "You can't access this page because you've uploaded maximal permitted number of layers!",
                'tip'     => ""
            ));
        }
        return $this->render('OGISIndexBundle:Create:createlayer.html.twig');
    }

   // support function to calculate min, max and nodata values (of a raster) by parsing the layer data
    protected function getMinMaxNodata($target, $type){
        if ($type != 'worldimage' && $type != 'geotiff'){
            // this isn't a layer type we can get min-max-nodata for just yet
            return array(-9999, -9999, -9999);
        }
        $targetDir = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        $source = "$targetDir/$target/$target.tif";
        $tiff = fopen($source, 'rb');
        if(!$tiff){ return array(-9999, -9999, -9999); }

        // make sure that this is a valid TIFF file we're working with
        fseek($tiff, 0);
        $dataBytes = fread($tiff, 2);
        $data = unpack('c2chars', $dataBytes);
        $value = sprintf('%c', $data['chars1']);
        if ($value == 'I'){ $isLittleEndian = true; }
        elseif ($value == 'M'){ $isLittleEndian = false; }
        else { return array(-9999, -9999, -9999); }
        $dataBytes = fread($tiff, 2);
        $data = ($isLittleEndian) ? unpack('vTIFF_ID', $dataBytes) : unpack('nTIFF_ID', $dataBytes);
        if($data['TIFF_ID'] != 42){ return array(-9999, -9999, -9999); }

        fseek($tiff, 4);
        $dataBytes = fread($tiff, 4);
        $data = ($isLittleEndian) ? unpack('VIFDoffset', $dataBytes) : unpack('NIFDoffset', $dataBytes);
        $IDFoffset = $data['IFDoffset'];
        fseek($tiff, $IDFoffset);
        $dataBytes = fread($tiff, 2) ;
        $data = ($isLittleEndian) ? unpack('vcount', $dataBytes) : unpack('ncount', $dataBytes);   
        $numFields = $data['count'];
        $StripStarts = array();
        $StripSizes = array();

        $IDFraw = fread($tiff, $numFields * 12);
        for ($i = 0; $i < $numFields; $i++) {
            $dataBytes = substr($IDFraw, $i * 12, 12);
            $data = ($isLittleEndian) ? unpack('vtag/vtype/Vcount/Voffset', $dataBytes) : unpack('ntag/ntype/Ncount/Noffset', $dataBytes); 
            switch($data['tag']){
                case 0x0100:    $width = $data['offset']; break;
                case 0x0101:    $height = $data['offset']; break;
                case 0x0102:    $bpsample = $data['offset']; break;
                case 0x0103:    $compression = $data['offset']; break;
                case 0x0111:    if ($data['count'] == 1){
                                    $strips = 1;
                                    $multiStrip = false;
                                    $StripStarts[1] = $data['offset'];
                                }
                                else{
                                    $strips = $data['count'];
                                    $multiStrip = true;
                                    fseek($tiff, $data['offset']);
                                    if ($data['type'] == 4){
                                        $dataBytes = fread($tiff, 4 * $data['count']);
                                        $StripStarts = ($isLittleEndian) ? unpack('V*', $dataBytes) : unpack('N*', $dataBytes) ;
                                    }
                                    elseif ($data['type'] == 3){
                                        $dataBytes = fread($tiff, 2 * $data['count']);
                                        $StripStarts = ($isLittleEndian) ? unpack('v*', $dataBytes) : unpack('n*', $dataBytes) ;
                                    }
                                    else{
                                        $dataBytes = fread($tiff, $data['count']);
                                        $StripStarts = unpack('c*', $dataBytes);                                        
                                    }
                                }
                                break;
                case 0x0115:    $samplespp = $data['offset']; break;
                case 0x0117:    if ($data['count'] == 1){
                                    $multiStrip = false;
                                    $StripSizes[1] = $data['offset'];
                                }
                                else{
                                    $multiStrip = true;
                                    fseek($tiff, $data['offset']);
                                    if ($data['type'] == 4){
                                        $dataBytes = fread($tiff, 4 * $data['count']);
                                        $StripSizes = ($isLittleEndian) ? unpack('V*', $dataBytes) : unpack('N*', $dataBytes) ;
                                    }
                                    elseif ($data['type'] == 3){
                                        $dataBytes = fread($tiff, 2 * $data['count']);
                                        $StripSizes = ($isLittleEndian) ? unpack('v*', $dataBytes) : unpack('n*', $dataBytes) ;
                                    }
                                    else{
                                        $dataBytes = fread($tiff, $data['count']);
                                        $StripSizes = unpack('c*', $dataBytes);                                        
                                    }
                                }
                                break;
                case 0x0153:    $datatype = $data['offset']; break;
            }
        }
        if($compression != 1){	return array(-9999, -9999, -9999);	}
        if($datatype > 3){	return array(-9999, -9999, -9999);	}
        if ($samplespp == null){ $samplespp = 1; }  // let's hope it is indeed so
        if($samplespp != 1){	return array(-9996, -9996, -9996);      }

        $points = $width * $height;
        switch($datatype){
            case 1:	$valuein = ($isLittleEndian) ? 'v*' : 'n*'; $bytes = 2; break;
            case 2:	$valuein = 's*'; $bytes = 2; break;
            case 3:	$valuein = 'f*'; $bytes = 4; break;
            case NULL:	$bytes = $bpsample / 8;
                        // assuming that we're dealing with signed values... no way to tell otherwise
                        switch($bytes){
                            case 1: $valuein = 'c*'; break;
                            case 2: $valuein = 's*'; break;
                            case 4: $valuein = 'f*'; break;
                        }
                        break;
        }
        $min = 10000000;
        $max = -1000000;
        $nodata = 10000000;	// we will assume that the absolutely minimal value is NODATA and the next smallest is actual minimum

        if (!$multiStrip){
            fseek($tiff, $StripStarts[1]);
            $pointsleft = $points;
            while($pointsleft > 0){
                if ($pointsleft < 32768){
                    $dataBytes = fread($tiff, $bytes * $pointsleft);
                    $lim = $pointsleft;
                    $pointsleft = 0;
                }
                else {
                    $lim = 32768;
                    $dataBytes = fread($tiff, $bytes * $lim);
                    $pointsleft -= 32768;
                }
                $data = unpack($valuein, $dataBytes);
                for ($i = 1; $i <= $lim; $i++){
                    if ($data[$i] < $nodata){ $min = $nodata; $nodata = $data[$i]; }
                    if ($data[$i] > $nodata && $data[$i] < $min){ $min = $data[$i]; }
                    if ($data[$i] > $max){ $max = $data[$i]; }
                }
            }
        }
        else{
            for ($j = 1; $j <= $strips; $j++){
                fseek($tiff, $StripStarts[$j]);
                $dataBytes = fread($tiff, $StripSizes[$j]);
                $data = unpack($valuein, $dataBytes);
                $lim = $StripSizes[$j] / $bytes;
                for ($i = 1; $i <= $lim; $i++){
                    if ($data[$i] < $nodata){ $min = $nodata; $nodata = $data[$i]; }
                    if ($data[$i] > $nodata && $data[$i] < $min){ $min = $data[$i]; }
                    if ($data[$i] > $max){ $max = $data[$i]; }
                }
            }
        }
        return array($min, $max, $nodata);
    }

    // actual upload of a layer
    public function uploadLayerAction(){
        $layername = $_POST['_layername'];
        $layerdescription = $_POST['_layerdescription'];
        $targetcatalog = $_POST['_targetcatalog'];
        $layertype = $_POST['_layertype'];
        $filesize = $_FILES['_layerfile']['size'];
        $target = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        $internalname = time() . "_" . $this->getUser()->getId();
        
        // extract files from the uploaded archive to target folder and rename them
        if (!extension_loaded('zip')){ return new response("no zip!", 200); }
        $source = $_FILES['_layerfile']['tmp_name'];
        $destination = "$target/$internalname/$internalname.zip";
        $zip = new \ZipArchive();
        $zip->open($source);
        $zip->extractTo("$target/$internalname/");
        $zip->close();
        rename($source, $destination);
        foreach (array_filter(glob("$target/$internalname/*.*") ,"is_file") as $f){
            $file = pathinfo($f);
            $extension = $file['extension'];
            rename($f, "$target/$internalname/$internalname.$extension");
        }

        // register the layer
        if ($layertype == "shp"){ $i = self::registerVectorLayer($layername, $layerdescription, $internalname); }
        else { $i = self::registerRasterLayer($layername, $layerdescription, $internalname, $layertype); }
        if ($i != 'Success!'){
            // uploading layer to geoserver failed entirely
            rename("$target/$internalname", "$target/../failed/$internalname");
            return $this->redirect($this->generateUrl('upload_failed'), 301);
        }
        $i = self::generateLayerPreview($internalname);
        $minmaxnodata = self::getMinMaxNodata($internalname, $layertype);
        
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080";
        $type = $layertype == "shp" ? "vector" : "raster";
        $context = stream_context_create(array('http' => array('header' => "Authorization: Basic " . base64_encode("admin:geoserver"))));
        if($type == 'vector'){ $resturl = "$url/geoserver/rest/workspaces/OGIS/datastores/$internalname/featuretypes/$internalname.json"; }
        else{ $resturl = "$url/geoserver/rest/workspaces/OGIS/coveragestores/$internalname/coverages/$internalname.json"; }

        $layerdata = json_decode(file_get_contents($resturl, false, $context));

        // determine, whether the upload was successful (theoretically) or not
        if(!$layerdata || ($layerdata->featureType->srs == null && $layerdata->coverage->srs == null)){
            // something went wrong and GeoServer failed to properly process the uploaded layer
            // unregister the layer, delete (null) preview and move files to the failed catalog
            rename("$target/$internalname", "$target/../failed/$internalname");
            $i = self::unregisterLayer($internalname, $layertype);
            $i = self::removePreview($internalname);
            // now show user the message
            return $this->redirect($this->generateUrl('upload_failed'), 301);
        }

        $layer = new Layer();
        $layer->setName($layername);
        $layer->setAuthor($this->getUser());
        $layer->setDescription($layerdescription);
        $layer->setConString($internalname);
        $layer->setWorkspace('OGIS');
        $layer->setPublic(true);
        $layer->setCreated(new \DateTime("now"));
        $layer->setModified(new \DateTime("now"));
        $layer->setPreview("./img/layer_previews/$internalname.png");
        $layer->setViews(0);
        $layer->setDownloads(0);
        $layer->setSize($filesize);
        $layer->setMinvalue($minmaxnodata[0]);
        $layer->setMaxvalue($minmaxnodata[1]);
        $layer->setNodatavalue($minmaxnodata[2]);
        if($type == 'vector'){
            if (strpos($layerdata->featureType->attributes->attribute[0]->binding, 'Polygon') !== FALSE){ $type = 'polygon'; }
            if (strpos($layerdata->featureType->attributes->attribute[0]->binding, 'Point') !== FALSE){ $type = 'point'; }
            if (strpos($layerdata->featureType->attributes->attribute[0]->binding, 'Line') !== FALSE){ $type = 'line'; }
            $layer->setType($type);
            $layer->setProjection($layerdata->featureType->srs);
            $layer->setFormat("ESRI ShapeFile");
            $layer->setBoundingBoxMinX($layerdata->featureType->nativeBoundingBox->minx);
            $layer->setBoundingBoxMinY($layerdata->featureType->nativeBoundingBox->miny);
            $layer->setBoundingBoxMaxX($layerdata->featureType->nativeBoundingBox->maxx);
            $layer->setBoundingBoxMaxY($layerdata->featureType->nativeBoundingBox->maxy);
        }
        else{
            $layer->setType($type);
            $height = substr($layerdata->coverage->grid->range->high, 0, strpos($layerdata->coverage->grid->range->high, " ")) - substr($layerdata->coverage->grid->range->low, 0, strpos($layerdata->coverage->grid->range->low, " "));
            $width = strstr($layerdata->coverage->grid->range->high, " ") - strstr($layerdata->coverage->grid->range->low, " ");
            
            if ($layertype == 'rst'){ $format = 'IDRISI RST'; }
            elseif ($layertype == 'worldimage'){ $format = 'WorldImage Tiff'; }
            elseif ($layertype == 'geotiff'){ $format = 'GeoTiff'; }
            else { $format = 'unknown raster'; }
            
            $layer->setProjection($layerdata->coverage->srs);			
            $layer->setResolutionX($height);
            $layer->setResolutionY($width);
            $layer->setFormat($format);
            $layer->setDatatype($layerdata->coverage->dimensions->coverageDimension[0]->dimensionType->name);
            $layer->setBoundingBoxMinX($layerdata->coverage->nativeBoundingBox->minx);
            $layer->setBoundingBoxMinY($layerdata->coverage->nativeBoundingBox->miny);
            $layer->setBoundingBoxMaxX($layerdata->coverage->nativeBoundingBox->maxx);
            $layer->setBoundingBoxMaxY($layerdata->coverage->nativeBoundingBox->maxy);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($layer);
        $em->flush();

        // ACL for layer
        $securityIdentity = UserSecurityIdentity::fromAccount($this->getUser());
        $layerIdentity = ObjectIdentity::fromDomainObject($layer);
        $aclProvider = $this->get('security.acl.provider');
        try{
            $acl = $aclProvider->findAcl($layerIdentity);
        }catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
            $acl = $aclProvider->createAcl($layerIdentity);
        }
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);

        // Link
        $id = $layer->getId();
        $projection = $layer->getProjection();
        $min = $minmaxnodata[0];
        $max = $minmaxnodata[1];
        $nodata = $minmaxnodata[2];
        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($targetcatalog);

        $link = new Link();
        $link->setTargetType('layer');
        $link->setTargetTitle($layername);
        $link->setTargetId($id);
        $link->setExtraInfo("OGIS:$internalname|$min|$max|$nodata|$projection|$type");
        $link->setCatalog($catalog);

        $em->persist($link);
        $em->flush();

        // ACL for link
        $linkIdentity = ObjectIdentity::fromDomainObject($link);
        try{
            $acl = $aclProvider->findAcl($linkIdentity);
        }catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
            $acl = $aclProvider->createAcl($linkIdentity);
        }
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);

        return $this->redirect($this->generateUrl('upload_successful', array('layername' => $id)), 301);
    }

    // response on layer upload failed
    public function uploadFailedAction(){
        return $this->render('OGISIndexBundle:Error:uploadfailed.html.twig', array(
            'caption' => "Error!",
            'message' => "An error occured while uploading your layer.",
            'tip'     => "Administration is sorry and will do everything in its power to rectify the situation."
        ));
    }

    // response on layer successfully uploaded
    public function uploadCompleteAction($layername){
        $em = $this->getDoctrine()->getManager();
        $id = $layername;
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->find($id);
        $layername = $layer->getName();
        return $this->render('OGISIndexBundle:Create:uploadsuccessful.html.twig', array(
            'caption' => "Success!",
            'message' => "Your layer \"$layername\" was uploaded successfully!",
            'layer' => $id
        ));
    }

    // show layer
    public function showLayerAction($id){
        $em = $this->getDoctrine()->getManager();
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->find($id);
        if(!$layer){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Error while reading database!",
                'message' => "The layer you're requesting doesn't exist in the database."
            ));
        }
        $layer->setViews($layer->getViews() + 1);
        $em->persist($layer);
        $em->flush();

        $viewable = false;
        $authorizationChecker = $this->get('security.context');
        if ($authorizationChecker->isGranted('VIEW', $layer) || $authorizationChecker->isGranted('ROLE_ADMIN') || $layer->getPublic()){
            $viewable = true;
        }

        return $this->render('OGISIndexBundle:Objects:layer.html.twig', array('layer' => $layer, 'viewable' => $viewable));
    }

    // update layer downloads counter
    public function updateDLCounterAction($id){
        $em = $this->getDoctrine()->getManager();
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->find($id);
        if(!$layer){
            return new response("error", 200);
        }
        $layer->setDownloads($layer->getDownloads() + 1);
        $em->persist($layer);
        $em->flush();
        return new response("success", 200);
    }

    // edit layer properties interface
    public function editLayerPropertiesAction($id){
        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->find($id);
        $authorizationChecker = $this->get('security.context');
        if(!$authorizationChecker->isGranted('EDIT', $layer) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => ""
            ));
        }
        if ($layer->getType() == 'raster'){
            return $this->render('OGISIndexBundle:Edit:edit_raster_properties.html.twig', array('layer' => $layer));
        }
        else{
            return $this->render('OGISIndexBundle:Edit:edit_vector_properties.html.twig', array('layer' => $layer));
        }
    }

    // updating layer properties
    public function saveLayerPropertiesAction($id){
        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->find($id);
        $authorizationChecker = $this->get('security.context');
        if(!$authorizationChecker->isGranted('EDIT', $layer) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => ""
            ));
        }

        $title = $_POST['_layername'];
        $descr = $_POST['_layerdescription'];
        $layer->setName($title);
        $layer->setDescription($descr);
        $layer->setModified(new \DateTime("now"));
        $em->persist($layer);
        $em->flush();

        return $this->redirect($this->generateUrl('edit_layer_properties', array('id' => $id)), 301);
    }

    // confirm delete of a layer
    public function deleteLayerConfirmAction($id){
        $em = $this->getDoctrine()->getManager();
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->find($id);
        if(!$layer){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Layer not found!",
                'message' => "The layer you're trying to delete doesn't exist in the database."
            ));
        }
        $authorizationChecker = $this->get('security.context');
        if(!$authorizationChecker->isGranted('DELETE', $layer) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => ""
            ));
        }
        return $this->render('OGISIndexBundle:Delete:deleteconfirmation.html.twig', array(
            'entitytype' => "layer",
            'entitytype_en' => "layer",
            'entitytype_rp' => "layer",
            'entityname' => $layer->getName(),
            'entityid' => $layer->getId()
        ));
    }

    // actual deletion of a layer
    public function deleteLayerAction($id){
        $em = $this->getDoctrine()->getManager();
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->find($id);        
        $authorizationChecker = $this->get('security.context');
        if(!$authorizationChecker->isGranted('DELETE', $layer) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => ""
            ));
        }
        $internalname = $layer->getConString();
        $layername = $layer->getName();
        $target = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        $author = $layer->getAuthor();
        $author->removeLayer($layer);
        $type = ($layer->getType() == 'vector') ? 'shp' : 'worldimage';
        $comps = sizeof($layer->getCompositions());

        // if layer isn't used in compositions, delete it permanently
        if ($comps == 0){
            $i = self::rrmdir("$target/$internalname");
            $i = self::unregisterLayer($internalname, $type);
            $i = self::removePreview($internalname);

            // and remove all links
            $links = $em->getRepository('OGIS\IndexBundle\Entity\Link')->findBy(array('targetType' => 'layer', 'targetId' => $layer->getId()));
            foreach($links as $link){
                $em->remove($link);
            }
        }

        // remove ACL
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($layer);
        $aclProvider->deleteAcl($objectIdentity);

        $em->remove($layer);
        $em->flush();

        return $this->redirect($this->generateUrl('deletelayersuccess', array('layername' => $layername)), 301);
    }

    // response on layer successfully removed from the system
    public function deleteLayerSuccessAction($layername){
        return $this->render('OGISIndexBundle:Delete:deletesuccess.html.twig', array(
            'caption' => "Operation successful",
            'message' => "Your layer \"$layername\" was deleted successfully."
        ));
    }

    // gets layer type by its connection string
    public function getLayerTypeAction($cs){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT l.type FROM OGISIndexBundle:Layer l WHERE l.con_string = '$cs'");
        $type = $query->getSingleResult();
        return new Response($type['type'], 200);
    }
    
    // gets layer id by its connestion string
    public function findLayerByConStringAction($cs){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT l.id FROM OGISIndexBundle:Layer l WHERE l.con_string = '$cs'");
        $type = $query->getSingleResult();
        $output = '{"id": ' . $type['id'] . '}';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    // sends a JSON of a layer
    public function getLayerDataAction($id){
        $em = $this->getDoctrine()->getManager();
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->find($id);
        if (!$layer){
            $output = '{"success":false,"msg":"Layer not found!"}';
            $response = new Response($output);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        $id = $layer->getId();
        $title = $layer->getName();
        $cs = $layer->getConString();
        $ws = $layer->getWorkspace();
        $min = $layer->getMinvalue();
        $max = $layer->getMaxvalue();
        $ndt = $layer->getNodatavalue();
        $type = $layer->getType();
        $proj = $layer->getProjection();
        $minx = $layer->getBoundingBoxMinX();
        $miny = $layer->getBoundingBoxMinY();
        $maxx = $layer->getBoundingBoxMaxX();
        $maxy = $layer->getBoundingBoxMaxY();
        $output = "{\"success\":true,\"data\":{\"id\":null,\"name\":\"\","
                . "\"layers\":[{\"id\":$id,\"name\":\"$title\",\"type\":\"$type\","
                . "\"projection\":\"$proj\",\"cs\":\"$cs\",\"workspace\":\"$ws\","
                . "\"vis\":true,\"transp\":1.0,\"style\":{\"type\":\"id\","
                . "\"value\":\"\"},\"gridvalues\":{\"min\":$min,\"max\":$max,"
                . "\"nodata\":$ndt}}],\"projection\":\"$proj\",\"extent\":"
                . "{\"type\":\"bb\",\"minX\":$minx,\"minY\":$miny,\"maxX\":$maxx,\"maxY\":$maxy}}}";
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }
}
