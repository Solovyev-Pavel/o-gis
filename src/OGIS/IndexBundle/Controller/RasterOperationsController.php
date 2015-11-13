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

class RasterOperationsController extends Controller {
    
    // shorthand for type => size (in bytes) conversion
    protected function TIFFDataTypeSizes($code){
        switch($code){
            case 1:  return 1;      // BYTE
            case 2:  return 1;      // ASCII
            case 3:  return 2;      // SHORT
            case 4:  return 4;      // LONG
            case 5:  return 8;      // RATIONAL ~ 2x LONG
            case 6:  return 1;      // SBYTE
            case 7:  return 1;      // just BYTE
            case 8:  return 2;      // SSHORT
            case 9:  return 4;      // SLONG
            case 10: return 8;      // SRATIONAL ~ 2x SLONG
            case 11: return 4;      // FLOAT
            case 12: return 8;      // LONG
            default: return 1;      // wildcard
        }
    }

    // registering the layer in GeoServer
    protected function registerLayerGS($params, $type){
        
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver";
        $targetDir = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        $cs = $params->name;
        $title = $params->title;
        $descr = $params->desc;

        // step 1: create store
        $data = "file://$targetDir/$cs/$cs.tif";
        $ch = curl_init();
        $targeturl = "$url/rest/workspaces/OGIS/coveragestores/$cs/external.$type?configure=first&coverageName=$cs";
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
        if ($code != 201 && $code != 200){ return '{"success": false, "message":"Error while registering layer with GeoServer!"}'; }
        
        // step 2: set layer properties
        $data = "<coverage><nativeName>$cs</nativeName><title>$title</title><description>$descr</description><enabled>true</enabled></coverage>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/workspaces/OGIS/coveragestores/$cs/coverages/$cs");
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
        curl_setopt($ch, CURLOPT_URL, "$url/rest/layers/OGIS:$cs");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, htmlentities($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return '{"success": true}';
    }

    // generate the layer preview
    protected function generatePreview($cs){
        $server = $_SERVER['SERVER_ADDR'];
        $previewurl = "http://$server:8080/geoserver/wms/reflect?LAYERS=OGIS:$cs";
        $targetDir = realpath(__DIR__ . '/../../../../web/');
        $path = "$targetDir/img/layer_previews/$cs.png";

        $context = stream_context_create(array('http' => array('header' => "Authorization: Basic " . base64_encode("admin:geoserver"))));
        $data = file_get_contents($previewurl, false, $context);

        file_put_contents($path, $data);
    }

    // unregister the layer
    protected function unregisterLayer($cs){
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/layers/OGIS:$cs");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/workspaces/OGIS/coveragestores/$cs/coverages/$cs");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url/rest/workspaces/OGIS/coveragestores/$cs");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    // remove the layer preview
    protected function removePreview($cs){
        $targetDir = realpath(__DIR__ . '/../../../../web/');
        $path = "$targetDir/img/layer_previews/$cs.png";
        unlink($path);
    }
    
    // apply styling to the newly-created layer
    protected function applyStyling($cs, $min, $max, $nodata){
        // create and SLD style for the layer
        $middle = $min + ($max - $min) * 0.5;
        $sld =  '<StyledLayerDescriptor version="1.0.0" xmlns="http://www.opengis.net/sld" ' .
                'xmlns:ogc="http://www.opengis.net/ogc"><NamedLayer><Name>' . $sld .
                '</Name><UserStyle><FeatureTypeStyle><Rule><Abstract>Autogenerated raster style' .
                '</Abstract><RasterSymbolizer><ColorMap type="ramp" extended="true">' .
                '<ColorMapEntry color="0x000000" quantity="' . $nodata . '" opacity="0"/>' .
                '<ColorMapEntry color="0x0a00b2" quantity="' . $min . '" opacity="1"/>' .
                '<ColorMapEntry color="0xfffb00" quantity="' . $middle . '" opacity="1"/>' .
                '<ColorMapEntry color="0xff0000" quantity="' . $max . '" opacity="1"/>' .
                '</ColorMap></RasterSymbolizer></Rule></FeatureTypeStyle></UserStyle>' .
                '</NamedLayer></StyledLayerDescriptor>';
        // save the SLD to disk
        $destination = "/var/lib/tomcat7/webapps/geoserver/data/styles/$cs.sld";
        $sldoutput = fopen($destination, 'wb');
        fwrite($sldoutput, $sld);
        fclose($sldoutput);
        // register the style with GeoServer
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver/rest/styles";
        $body = "<style><name>$cs</name><filename>$cs.sld</filename></style>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        // apply the style to the newly-created layer
        $url = "http://$server:8080/geoserver/";
        $body = "<layer><defaultStyle><name>$cs</name></defaultStyle></layer>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "rest/layers/$cs");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        // refresh layer's availability
        $body = "<layer><enabled>true</enabled></layer>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "rest/layers/$cs");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    // register the layer within the system
    protected function registerLayerCMS($params){
        // archive all layer's files for download
        $directory = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        $zip = new \ZipArchive();
        $cs = $params->name;
        $files = array();
        $hasTiff = false; $hasTfw = false; $hasRst = false; $type = '';
        if (file_exists("$directory/$cs/$cs.tif")){
            $hasTiff = true;
            array_push($files, "$directory/$cs/$cs.tif");
        }
        if (file_exists("$directory/$cs/$cs.tfw")){
            $hasTfw = true;
            array_push($files, "$directory/$cs/$cs.tfw");
        }
        if (file_exists("$directory/$cs/$cs.rst")){
            $hasRst = true;
            array_push($files, "$directory/$cs/$cs.rst"); 
        }
        if (file_exists("$directory/$cs/$cs.rdc")){ array_push($files, "$directory/$cs/$cs.rdc"); }
        if (file_exists("$directory/$cs/$cs.prj")){ array_push($files, "$directory/$cs/$cs.prj"); }

        if ($hasTiff && $hasTfw){ $type = 'worldimage'; }
        if ($hasTiff && !$hasTfw){ $type = 'geotiff'; }
        if ($hasRst){ $type = 'rst'; }
        if ($type == ''){ return '{"success": false, "message": "Unknown layer format!"}'; }

        $zip->open("$directory/$cs/$cs.zip", \ZipArchive::CREATE);
        foreach($files as $file){ $zip->addFile($file); }
        $zip->close();
        $filesize = filesize("$directory/$cs/$cs.zip");

        // register the layer within the GeoServer
        $i = self::registerLayerGS($params, $type);
        $j = json_decode($i);
        if (!$j->success){
            rename("$directory/$cs", "$directory/../failed/$cs");            
            return $i;
        }

        // apply 'base' styling (of palette variety)
        $i = self::applyStyling($cs, $params->min, $params->max, $params->nodata);
        // generate layer preview
        $i = self::generatePreview($cs);
        // get the special data from GeoServer
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080";
        $context = stream_context_create(array('http' => array('header' => "Authorization: Basic " . base64_encode("admin:geoserver"))));
        $resturl = "$url/geoserver/rest/workspaces/OGIS/coveragestores/$cs/coverages/$cs.json";
        $layerdata = json_decode(file_get_contents($resturl, false, $context));
        if(!$layerdata || $layerdata->coverage->srs == null){
            rename("$directory/$cs", "$directory/../failed/$cs");
            $i = self::unregisterLayer($cs);
            $i = self::removePreview($cs);
            return '{"success": false, "message": "Error while reading layer data!"}';
        }
        
        $min = $params->min;
        $max = $params->max;
        $nodata = $params->nodata;
        
        $layer = new Layer();
        $layer->setName($params->title);
        $layer->setDescription($params->desc);
        $layer->setAuthor($this->getUser());
        $layer->setConString($cs);
        $layer->setWorkspace('OGIS');
        $layer->setPublic(true);
        $layer->setCreated(new \DateTime("now"));
        $layer->setModified(new \DateTime("now"));
        $layer->setPreview("./img/layer_previews/$cs.png");
        $layer->setViews(0);
        $layer->setDownloads(0);
        $layer->setSize($filesize);
        $layer->setMinvalue($min);
        $layer->setMaxvalue($max);
        $layer->setNodatavalue($nodata);
        $layer->setType('raster');

        switch($type){
            case 'rst': $format = 'IDRISI RST'; break;
            case 'geotiff': $format = 'GeoTiff'; break;
            case 'worldimage': $format = 'WorldImage Tiff'; break;
            default: $format = 'Unknown raster'; break;
        }
        
        $layer->setProjection($layerdata->coverage->srs);			
        $layer->setResolutionX($params->width);
        $layer->setResolutionY($params->height);
        $layer->setFormat($format);
        $layer->setDatatype($layerdata->coverage->dimensions->coverageDimension[0]->dimensionType->name);
        $layer->setBoundingBoxMinX($layerdata->coverage->nativeBoundingBox->minx);
        $layer->setBoundingBoxMinY($layerdata->coverage->nativeBoundingBox->miny);
        $layer->setBoundingBoxMaxX($layerdata->coverage->nativeBoundingBox->maxx);
        $layer->setBoundingBoxMaxY($layerdata->coverage->nativeBoundingBox->maxy);
        
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
        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($params->target);

        $link = new Link();
        $link->setTargetType('layer');
        $link->setTargetTitle($params->title);
        $link->setTargetId($id);
        $link->setExtraInfo("OGIS:$cs|$min|$max|$nodata|$projection|raster");
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
        
        return '{"success":true,"message":"Слой успешно создан!"}';
    }

    // get the request
    public function rasterOperationAction(){
        if(!$this->getUser()){
            $i = '{"success": false, "message":"Anonymous users can\'t perform raster operations!"}';
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        $layers = count($this->getUser()->getLayers());
        $limits = $this->getUser()->getLimits()->getLayers();
        if($limits > 0 && $layers >= $limits){
            $i = '{"success": false, "message":"Operation canceled: you\'ve reached the maximal permitted number of layers!"}';
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        
        $json_raw = file_get_contents('php://input');
        $json = json_decode($json_raw);
        if($json->isReclass){
            $i = self::doRasterReclassification($json);
        }
        else {
            $i = self::doRasterAlgebra($json);
        }
        // whether the operation was a success or not, return the resulting json
        $response = new Response($i);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }
    
    // reclassify selected layer
    protected function doRasterReclassification($json){
        $cs = $json->sources->cs;
        $em = $this->getDoctrine()->getManager();
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->findOneBy(array('con_string' => $cs));
        if (!$layer){ return '{"success":false,"message":"Targeted layer doesn\'t exist!"}'; }
        if ($layer->getType() != 'raster'){ return '{"success":false, "message":"Raster analysis can\'t be performed on vector layer!"}'; }
        $nodata = $layer->getNodatavalue();
        
        // make sure that file with layer data actually exists
        $dataSourceFound = false;
        $directory = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        $source = $directory . "/$cs/$cs.tif";
        if (file_exists($source)){
            // We're dealing with TIFF file... need to parse tags and whatnot... >_<
            $dataSourceFound = true;
            $i = self::TiffReclassification($cs, $json->params, $nodata);
        }
        $source = $directory . "/$cs/$cs.rst";
        if (file_exists($source)){
            // We're dealing with IDRISI RST file here...
            $dataSourceFound = true;
            $i = self::RstReclassification($cs, $json->params, $nodata);
        }
        if(!$dataSourceFound){ return '{"success":false, "message":"Layer\'s data was not found!"}'; }
        $j = json_decode($i);
        if (!$j->success){
            return $i;
        }
        else{
            $create_params = (object)array(
                'name' => $j->name,
                'title' => $json->name,
                'desc' => $json->desc,
                'target' => $json->target,
                'min' => $j->min,
                'max' => $j->max,
                'nodata' => $j->nodata,
                'width' => $j->width,
                'height' => $j->height
            );
            $i = self::registerLayerCMS($create_params);
            return $i;
        }
    }

    // process a Tiff file
    protected function TiffReclassification($cs, $params, $nodata){
        $directory = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        $source = $directory . "/$cs/$cs.tif";
        $tiff = fopen($source, 'rb');
        if (!$tiff){ return '{"success":false, "message":"Error while reading layer files!"}'; }
        
        // make sure that this is a valid TIFF file we're working with
        fseek($tiff, 0);
        $dataBytes = fread($tiff, 2);
        $data = unpack('c2chars', $dataBytes);
        $value = sprintf('%c', $data['chars1']);
        if ($value == 'I'){ $isLittleEndian = true; }
        elseif ($value == 'M'){ $isLittleEndian = false; }
        else { return '{"success":false, "message":"Error while reading layer data :: TIFF byte order undefined"}'; }
        $dataBytes = fread($tiff, 2);
        $data = ($isLittleEndian) ? unpack('vTIFF_ID', $dataBytes) : unpack('nTIFF_ID', $dataBytes);
        if($data['TIFF_ID'] != 42){ return '{"success":false, "message":"Error while reading layer data :: TIFF is not valid!"}'; }
        
        // find the IFD of the TIFF file
        $dataBytes = fread($tiff, 4);
        $data = ($isLittleEndian) ? unpack('VIFDoffset', $dataBytes): unpack('NIFDoffset', $dataBytes);
        $IFDOffset = $data['IFDoffset'];
        fseek($tiff, $IFDOffset);
        $dataBytes = fread($tiff, 2);
        $data = ($isLittleEndian) ? unpack('vcount', $dataBytes) : unpack('ncount', $dataBytes);
        $length = $data['count'];
        
        // read IFD tags
        $dataBytes = fread($tiff, $length * 12);
        // make sure to take the possibility of multi-stripped tiffs into account
        $multiStripped = false;     // a flag of whether this TIFF keeps the actual data in multiple data strips or not
        $stripOffsets = array();    // a container for the data strips' offsets
        $stripSizes = array();      // a container to hold the lengths of data strips
        $IFD = array();             // a container for the parsed IFD itself
        
        // parse IFD
        for($i = 0; $i < $length; $i++){
            $value = substr($dataBytes, $i * 12, 12);
            $data = ($isLittleEndian) ? unpack('vtag/vtype/Vcount/Voffset', $value) : unpack('ntag/ntype/Ncount/Noffset', $value);
            $reclass = $data['count'] * self::TIFFDataTypeSizes($data['type']);
            if($reclass < 5){ $reclass = 0; }
            array_push($IFD, array(
                'tag' => $data['tag'],          // id of the IFD tag
                'type' => $data['type'],        // value type
                'count' => $data['count'],      // value count
                'offset' => $data['offset'],    // value or pointer to values in file
                'externallength' => $reclass    // how many bytes the tag stores outside of the offset field
            ));
            switch ($data['tag']){
                case 0x0100:    $width = $data['offset']; break;
                case 0x0101:    $height = $data['offset']; break;
                case 0x0102:    $bpsample = $data['offset']; break;
                case 0x0103:    $compression = $data['offset']; break;
                case 0x0111:    $multiStripped = ($data['count'] > 1) ? true : false;
                                if ($multiStripped){
                                    fseek($tiff, $data['offset']);
                                    if ($data['type'] == 4){
                                        $value = fread($tiff, 4 * $data['count']);
                                        $stripOffsets = ($isLittleEndian) ? unpack('V*', $value) : unpack('N*', $value) ;
                                    }
                                    elseif ($data['type'] == 3){
                                        $value = fread($tiff, 2 * $data['count']);
                                        $stripOffsets = ($isLittleEndian) ? unpack('v*', $value) : unpack('n*', $value) ;
                                    }
                                    else{
                                        $value = fread($tiff, $data['count']);
                                        $stripOffsets = unpack('c*', $value);                                        
                                    }
                                }
                                else{
                                    $stripOffsets[1] = $data['offset'];
                                }
                                break;
                case 0x0115:    $samplespp = $data['offset']; break;
                case 0x0117:    $multiStripped = ($data['count'] > 1) ? true : false;
                                if ($multiStripped){
                                    fseek($tiff, $data['offset']);
                                    if ($data['type'] == 4){
                                        $value = fread($tiff, 4 * $data['count']);
                                        $stripSizes = ($isLittleEndian) ? unpack('V*', $value) : unpack('N*', $value) ;
                                    }
                                    elseif ($data['type'] == 3){
                                        $value = fread($tiff, 2 * $data['count']);
                                        $stripSizes = ($isLittleEndian) ? unpack('v*', $value) : unpack('n*', $value) ;
                                    }
                                    else{
                                        $value = fread($tiff, $data['count']);
                                        $stripSizes = unpack('c*', $value);                                        
                                    }
                                }
                                else{
                                    $stripSizes[1] = $data['offset'];
                                }
                                break;
                case 0x0153:    $datatype = $data['offset']; break;
            }
        }
        
        // prepare the input data formater
        if ($samplespp == null) { $samplespp = 1; } // let's hope it is indeed so
        if ($compression != 1){ return '{"success":false, "message":"Error: only uncompressed files can be processed at the moment!"}'; }
        if ($samplespp != 1){ return '{"success":false, "message":"Error: only layers with one data block per pixel can be processed at the moment!"}'; }
        if ($datatype > 3){ return '{"success":false, "message":"Error: unsupported data type!"}'; }
        $pointsleft = $points = $width * $height;
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
        
        // prepare the output data formatter
        $params_count = count($params);
        $min = 100000000; $max = -100000000;
        for($j = 0; $j < $params_count; $j++){
            $value = floatval($params[$j]->newval);
            if ($min > $value){ $min = $value; }
            if ($max < $value){ $max = $value; }
        }
        if( $valuein != 'f*' ){ $valueout = 's'; $outbytes = 2; $sformat = 2; $intclasses = true; }
        else{ $valueout = 'f'; $outbytes = 4; $sformat = 3; $intclasses = false; }
        
        // create the output file
        $newname = time() . '_' . $this->getUser()->getId();
        mkdir($directory . "/$newname");
        $destination = $directory . "/$newname/$newname.tif";
        $result = fopen($destination, 'wb');
        
        // write the TIFF
        // we're reconstructing the IFD from scratch... hopefully, nothing too bad happens because of that
        $dataBytes = ($isLittleEndian) ? pack('c2vV', 0x49, 0x49, 42, 8) : pack('c2nN', 0x4D, 0x4D, 42, 8);
        fwrite($result, $dataBytes);
        $dataBytes = ($isLittleEndian) ? pack('v', $length) : pack('n', $length);
        fwrite($result, $dataBytes);
        $byteswritten = 14 + $length * 12;
        $buffer = '';
        $lim = '';
        $StripOffsetTag = null;         // container for the strip offset tag
        
        // build new IFD
        for ($i = 0; $i < $length; $i++){
            // also, for whatever reason, TIFF readers throw warnings if tags aren't sorted in correct order...
            // to avoid this, we will need second buffer to store tags with id > 0x0111
            if ($IFD[$i]['externallength'] == 0){
                // this tag stores all of its data exactly within its 'offset' field
                // we can copy such tag without much thinking...
                // some update still must be done
                if ($IFD[$i]['tag'] == 0x0102){ $IFD[$i]['offset'] = $outbytes * 8; }
                if ($IFD[$i]['tag'] == 0x0111){ $StripOffsetTag = $IFD[$i]; continue; }
                if ($IFD[$i]['tag'] == 0x0117){ $IFD[$i]['offset'] = $IFD[$i]['offset'] * $outbytes / $bytes; }
                if ($IFD[$i]['tag'] == 0x0153){ $IFD[$i]['offset'] = $sformat; }
                // pack and write...
                if ($isLittleEndian){ $reclass = pack('vvVV', $IFD[$i]['tag'], $IFD[$i]['type'], $IFD[$i]['count'], $IFD[$i]['offset']); }
                else{ $reclass = pack('nnNN', $IFD[$i]['tag'], $IFD[$i]['type'], $IFD[$i]['count'], $IFD[$i]['offset']); }
                if ($IFD[$i]['tag'] > 0x0111){ $lim .= $reclass; }
                else{ fwrite($result, $reclass); }
            }
            else{
                // this tag stores its data outside of its 'offset' field
                // we need to change the value of the 'offset' field to account for that
                // the actual data of the tag will be temporarily stored in $buffer
                if ($IFD[$i]['tag'] == 0x0111){
                    // we will have to apply this tag last to be sure that the new values are correct
                    $StripOffsetTag = $IFD[$i];
                    continue;
                }
                fseek($tiff, $IFD[$i]['offset']);
                $dataBytes = fread($tiff, $IFD[$i]['externallength']);
                if ($IFD[$i]['tag'] == 0x0117){
                    // StripByteCount
                    for ($j = 1; $j <= $IFD[$i]['count']; $j++){
                        $value = $stripSizes[$j] * $outbytes / $bytes;
                        if ($IFD[$i]['type'] == 4){ $dataBytes = ($isLittleEndian) ? pack('V*', $value) : pack('N*', $value); }
                        elseif ($IFD[$i]['type'] == 3){ $dataBytes = ($isLittleEndian) ? pack('v*', $value) : pack('n*', $value); }
                        else{ $dataBytes = pack('C*', $value); }
                        $buffer .= $dataBytes;
                    }
                    if ($isLittleEndian){ $reclass = pack('vvVV', $IFD[$i]['tag'], $IFD[$i]['type'], $IFD[$i]['count'], $byteswritten); }
                    else{ $reclass = pack('nnNN', $IFD[$i]['tag'], $IFD[$i]['type'], $IFD[$i]['count'], $byteswritten); }
                    if ($IFD[$i]['tag'] > 0x0111){ $lim .= $reclass; }
                    else{ fwrite($result, $reclass); }
                    $byteswritten += $IFD[$i]['externallength'];
                }
                else{
                    $buffer .= $dataBytes;
                    if ($isLittleEndian){ $reclass = pack('vvVV', $IFD[$i]['tag'], $IFD[$i]['type'], $IFD[$i]['count'], $byteswritten); }
                    else{ $reclass = pack('nnNN', $IFD[$i]['tag'], $IFD[$i]['type'], $IFD[$i]['count'], $byteswritten); }
                    if ($IFD[$i]['tag'] > 0x0111){ $lim .= $reclass; }
                    else{ fwrite($result, $reclass); }
                    $byteswritten += $IFD[$i]['externallength'];
                }
            }
        }
        if ($StripOffsetTag != null && $multiStripped){
            if ($isLittleEndian){ $reclass = pack('vvVV', $StripOffsetTag['tag'], $StripOffsetTag['type'], $StripOffsetTag['count'], $byteswritten); }
            else{ $reclass = pack('nnNN', $StripOffsetTag['tag'], $StripOffsetTag['type'], $StripOffsetTag['count'], $byteswritten); }
            $byteswritten += $StripOffsetTag['externallength'] + 2;
            fwrite($result, $reclass);
            fwrite($result, $lim);
            for($j = 1; $j <= $StripOffsetTag['count']; $j++){
                if ($StripOffsetTag['type'] == 4){ $dataBytes = ($isLittleEndian) ? pack('V', $byteswritten) : pack('N', $byteswritten); }
                elseif ($StripOffsetTag['type'] == 3) { $dataBytes = ($isLittleEndian) ? pack('v', $byteswritten) : pack('n', $byteswritten); }
                else { $dataBytes = pack('C', $byteswritten); }
                $buffer .= $dataBytes;
                $byteswritten += $stripSizes[$j] * $outbytes / $bytes;
            }
        }
        if ($StripOffsetTag != null && !$multiStripped){
            $StripOffsetTag['offset'] = $byteswritten + 2;
            if ($isLittleEndian){ $reclass = pack('vvVV', $StripOffsetTag['tag'], $StripOffsetTag['type'], $StripOffsetTag['count'], $StripOffsetTag['offset']); }
            else{ $reclass = pack('nnNN', $StripOffsetTag['tag'], $StripOffsetTag['type'], $StripOffsetTag['count'], $StripOffsetTag['offset']); }
            fwrite($result, $reclass);
            fwrite($result, $lim);
        }
        $dataBytes = ($isLittleEndian) ? pack('V', 0x00) : pack('N', 0x00);
        fwrite($result, $dataBytes);
        fwrite($result, $buffer);
        $dataBytes = ($isLittleEndian) ? pack('v', 0x00) : pack('n', 0x00);
        fwrite($result, $dataBytes);
        $buffer = '';
        
        // Reclassification time!
        $nodata = $min;
        if(!$multiStripped){
            // single-block processing
            fseek($tiff, $stripOffsets[1]);
            while($pointsleft > 0){
                if ($pointsleft < 32768){
                    // read all remaining points
                    $dataBytes = fread($tiff, $pointsleft * $bytes);
                    $lim = $pointsleft;
                    $pointsleft = 0;
                }
                else{
                    $pointsleft -= 32768;
                    $lim = 32768;
                    $dataBytes = fread($tiff, $lim * $bytes);
                }
                $data = unpack($valuein, $dataBytes);
                $i = 1;
                while ($i <= $lim){
                    $reclass = $data[$i];
                    for($j = 0; $j < $params_count; $j++){
                        if ($reclass > $params[$j]->low && $reclass <= $params[$j]->high){
                            $reclass = $params[$j]->newval;
                            break;
                        }
                    }
                    if ($intclasses){ $reclass = intval($reclass);}
                    if ($reclass < $nodata){ $min = $nodata; $nodata = $reclass; }
                    if ($reclass > $max){ $max = $reclass; }
                    if ($reclass < $min && $reclass > $nodata){ $min = $reclass; }
                    $buffer .= pack($valueout, $reclass);
                    $i++;
                }
                fwrite($result, $buffer);
                $buffer = '';
            }
        }
        else{
            for($i = 1; $i <= $StripOffsetTag['count']; $i++){
                fseek($tiff, $stripOffsets[$i]);
                $dataBytes = fread($tiff, $stripSizes[$i]);
                $data = unpack($valuein, $dataBytes);
                $lim = $stripSizes[$i] / $bytes;
                $j = 1;
                while ($j <= $lim){
                    $reclass = $data[$j];
                    for($k = 0; $k < $params_count; $k++){
                        if ($reclass > $params[$k]->low && $reclass <= $params[$k]->high){
                            $reclass = $params[$k]->newval;
                            break;
                        }
                    }
                    if ($intclasses){ $reclass = intval($reclass);}
                    if ($reclass < $nodata){ $min = $nodata; $nodata = $reclass; }
                    if ($reclass > $max){ $max = $reclass; }
                    if ($reclass < $min && $reclass > $nodata){ $min = $reclass; }
                    $buffer .= pack($valueout, $reclass);
                    $j++;
                }
                fwrite($result, $buffer);
                $buffer = '';
            }
        }
        
        fclose($tiff);
        fclose($result);
        
        // coppy additional files over
        $source = "$directory/$cs/$cs.tfw";
        if(file_exists($source)){ copy($source, "$directory/$newname/$newname.tfw"); }
        $source = "$directory/$cs/$cs.prj";
        if(file_exists($source)){ copy($source, "$directory/$newname/$newname.prj"); }
        
        // output message
        return "{\"success\":true,\"min\":$min,\"max\":$max, \"nodata\":$nodata,\"width\":$width,\"height\":$height,\"name\":\"$newname\"}";
    }

    // proceess IDRISI RST file
    protected function RstReclassification($source, $params, $nodata){
        return '{"success":false,"message":"IDRISI RST isn't supported right now!"}';
    }
    
    // raster algebra
    protected function doRasterAlgebra($json){
        $i = self::processRasters($json, false);
        $j = json_decode($i);
        if (!$j->success){ return $i; }
        else{
            $create_params = (object)array(
                'name' => $j->name,
                'title' => $json->name,
                'desc' => $json->desc,
                'target' => $json->target,
                'min' => $j->min,
                'max' => $j->max,
                'nodata' => $j->nodata,
                'width' => $j->width,
                'height' => $j->height
            );
            $i = self::registerLayerCMS($create_params);
            return $i;
        }
    }
    
    // process rasters for algebra
    protected function processRasters($json, $istest){
        $em = $this->getDoctrine()->getManager();
        $count = count($json->sources);
        // make sure that all layers actually exist in the CMS
        $layers = array();
        $nodatas = array();
        for ($i = 0; $i < $count; $i++){
            $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->findOneBy(array('con_string' => $json->sources[$i]->cs));
            if (!$layer){ return '{"success":false, "message":"At least one of the layers wasn\'t found!"}'; }
            $layers[$i] = $layer;
        }
        // make sure that all layers are (presumably, since 404000) of the same projection and have same dimensions
        $width = null; $height = null; $data = null; $base = null;
        for($i = 0; $i < $count; $i++){
            $nodatas[$i] = $layers[$i]->getNodatavalue();
            // checking layers' dimensions : width
            if ($width == null){ $width = $layers[$i]->getResolutionX(); }
            else{
                if ($layers[$i]->getResolutionX() != $width){ return '{"success":false, "message":"Layers\' dimenstions don\'t match!"}'; }
            }
            // cheking layers' dimensions : height
            if ($height == null){ $height = $layers[$i]->getResolutionY(); }
            else{
                if ($layers[$i]->getResolutionY() != $height){ return '{"success":false, "message":"Layers\' dimenstions don\'t match!"}'; }
            }
            // checking layers' projections
            if ($data == null || $data == 'EPSG:404000'){ $data = $layers[$i]->getProjection(); $base = $i; }
            else{
                if ($data != $layers[$i]->getProjection() && $layers[$i]->getProjection() != 'EPSG:404000'){
                    return '{"success":false, "message":"Layers\' projections don\'t match!"}';
                }
            }
        }
        // open the layers' files
        $tiffs = array();
        $directory = realpath(__DIR__ . '/../../../../web/uploads/layers/');
        for($i = 0; $i < $count; $i++){
            $cs = $json->sources[$i]->cs;
            $source = $directory . "/$cs/$cs.tif";
            $tiff = fopen($source, 'rb');
            if ($tiff == false){ return '{"success":false, "message":"Error while reading layer files!"}'; }
            array_push($tiffs, $tiff);
        }
        // validate the files as proper tiffs
        $basetags = array(); $dataBytes = null; $bytes = array(); $valueins = array();
        $stripOffsets = array(); $stripSizes = array(); $multiStripped = array();
        for($i = 0; $i < $count; $i++){
            fseek($tiffs[$i], 0);
            $dataBytes = fread($tiffs[$i], 2);
            $data = unpack('c2chars', $dataBytes);
            $value = sprintf('%c', $data['chars1']);
            if ($value == 'I'){ $isLittleEndian = true; }
            elseif ($value == 'M'){ $isLittleEndian = false; }
            else { return '{"success":false, "message":"Error while reading layer data :: TIFF byte order undefined"}'; }
            $dataBytes = fread($tiffs[$i], 2);
            $data = ($isLittleEndian) ? unpack('vTIFF_ID', $dataBytes) : unpack('nTIFF_ID', $dataBytes);
            if($data['TIFF_ID'] != 42){ return '{"success":false, "message":"Error while reading layer data :: TIFF is not valid!"}'; }

            // find the IFD of the TIFF file
            $dataBytes = fread($tiffs[$i], 4);
            $data = ($isLittleEndian) ? unpack('VIFDoffset', $dataBytes): unpack('NIFDoffset', $dataBytes);
            $IFDOffset = $data['IFDoffset'];
            fseek($tiffs[$i], $IFDOffset);
            $dataBytes = fread($tiffs[$i], 2);
            $data = ($isLittleEndian) ? unpack('vcount', $dataBytes) : unpack('ncount', $dataBytes);
            $length = $data['count'];
            
            // read IFD tags
            $dataBytes = fread($tiffs[$i], $length * 12);
            $multiStripped[$i] = false;
            $stripOffsets[$i] = array();
            $stripSizes[$i] = array();
            
            // parse IFD
            for($j = 0; $j < $length; $j++){
                $value = substr($dataBytes, $j * 12, 12);
                $data = ($isLittleEndian) ? unpack('vtag/vtype/Vcount/Voffset', $value) : unpack('ntag/ntype/Ncount/Noffset', $value);
                if ($i == $base){
                    $extlength = $data['count'] * self::TIFFDataTypeSizes($data['type']);
                    if ($extlength < 5){ $extlength = 0; }
                    array_push($basetags, array(
                        'tag' => $data['tag'],          // id of the IFD tag
                        'type' => $data['type'],        // value type
                        'count' => $data['count'],      // value count
                        'offset' => $data['offset'],    // value or pointer to values in file
                        'externallength' => $extlength  // how many bytes the tag stores outside of the offset field
                    ));
                }
                switch ($data['tag']){
                    case 0x0102:    $bpsample = $data['offset']; break;
                    case 0x0103:    $compression = $data['offset']; break;
                    case 0x0111:    $multiStripped[$i] = ($data['count'] > 1) ? true : false;
                                    if ($multiStripped[$i]){
                                        fseek($tiffs[$i], $data['offset']);
                                        if ($data['type'] == 4){
                                            $value = fread($tiffs[$i], 4 * $data['count']);
                                            $stripOffsets[$i] = ($isLittleEndian) ? unpack('V*', $value) : unpack('N*', $value) ;
                                        }
                                        elseif ($data['type'] == 3){
                                            $value = fread($tiffs[$i], 2 * $data['count']);
                                            $stripOffsets[$i] = ($isLittleEndian) ? unpack('v*', $value) : unpack('n*', $value) ;
                                        }
                                        else{
                                            $value = fread($tiffs[$i], $data['count']);
                                            $stripOffsets[$i] = unpack('c*', $value);                                        
                                        }
                                    }
                                    else{
                                        $stripOffsets[$i][1] = $data['offset'];
                                    }
                                    break;
                    case 0x0115:    $samplespp = $data['offset']; break;
                    case 0x0117:    $multiStripped[$i] = ($data['count'] > 1) ? true : false;
                                    if ($multiStripped[$i]){
                                        fseek($tiffs[$i], $data['offset']);
                                        if ($data['type'] == 4){
                                            $value = fread($tiffs[$i], 4 * $data['count']);
                                            $stripSizes[$i] = ($isLittleEndian) ? unpack('V*', $value) : unpack('N*', $value) ;
                                        }
                                        elseif ($data['type'] == 3){
                                            $value = fread($tiffs[$i], 2 * $data['count']);
                                            $stripSizes[$i] = ($isLittleEndian) ? unpack('v*', $value) : unpack('n*', $value) ;
                                        }
                                        else{
                                            $value = fread($tiffs[$i], $data['count']);
                                            $stripSizes[$i] = unpack('c*', $value);                                        
                                        }
                                    }
                                    else{
                                        $stripSizes[$i][1] = $data['offset'];
                                    }
                                    break;
                    case 0x0153:    $datatype = $data['offset']; break;
                }
            }
            // prepare the input data formater
            if ($samplespp == null) { $samplespp = 1; } // let's hope it is indeed so
            if ($compression != 1){ return '{"success":false, "message":"Error: only uncompressed files can be processed at the moment!"}'; }
            if ($samplespp != 1){ return '{"success":false, "message":"Error: only layers with one data block per pixel can be processed at the moment!"}'; }
            if ($datatype > 3){ return '{"success":false, "message":"Error: unsupported data type!"}'; }
            switch($datatype){
                case 1:	$valueins[$i] = ($isLittleEndian) ? 'v*' : 'n*'; $bytes[$i] = 2; break;
                case 2:	$valueins[$i] = 's*'; $bytes[$i] = 2; break;
                case 3:	$valueins[$i] = 'f*'; $bytes[$i] = 4; break;
                case NULL:	$bytes[$i] = $bpsample / 8;
                            // assuming that we're dealing with signed values... no way to tell otherwise
                            switch($bytes[$i]){
                                case 1: $valueins[$i] = 'c*'; break;
                                case 2: $valueins[$i] = 's*'; break;
                                case 4: $valueins[$i] = 'f*'; break;
                            }
                            break;
            }
        }
        // for the sake of simplicity, algebra output is always in float32 format
        $valueout = 'f'; $outbytes = 4; $sformat = 3;
        // math expression itself...
        $pointsleft = $width * $height; // all layers have the same dimensions
        
        // write the output file
        $newname = time() . '_' . $this->getUser()->getId();
        if ($istest){ $newname = 'test'; }
        mkdir($directory . "/$newname");
        $destination = $directory . "/$newname/$newname.tif";
        $result = fopen($destination, 'wb');
        
        // write the TIFF
        // we're reconstructing the IFD from scratch... hopefully, nothing too bad happens because of that
        // for the sake of simplicity, we will be writing strictly little endian
        $length = count($basetags);
        $dataBytes = pack('c2vVv', 0x49, 0x49, 42, 8, $length);
        fwrite($result, $dataBytes);
        $byteswritten = 14 + $length * 12;
        $lim = '';
        // build new IFD
        for ($i = 0; $i < $length; $i++){
            $tag = $basetags[$i];
            // also, for whatever reason, TIFF readers throw warnings if tags aren't sorted in correct order...
            // to avoid this, we will need second buffer to store tags with id > 0x0111
            if ($tag['externallength'] == 0){
                // this tag stores all of its data exactly within its 'offset' field
                // we can copy such tag without much thinking...
                // some update still must be done
                if ($tag['tag'] == 0x0102){ $tag['offset'] = $outbytes * 8; }
                if ($tag['tag'] == 0x0111){ $StripOffsetTag = $tag; continue; }
                if ($tag['tag'] == 0x0117){ $tag['offset'] = $pointsleft * $outbytes; }
                if ($tag['tag'] == 0x0153){ $tag['offset'] = $sformat; }
                // pack and write...
                $data = pack('vvVV', $tag['tag'], $tag['type'], $tag['count'], $tag['offset']);
                if ($tag['tag'] > 0x0111){ $lim .= $data; }
                else{ fwrite($result, $data); }
            }
            else{
                // this tag stores its data outside of its 'offset' field
                // we need to change the value of the 'offset' field to account for that
                // the actual data of the tag will be temporarily stored in $buffer
                if ($tag['tag'] == 0x0111){
                    // we will have to apply this tag last to be sure that the new values are correct
                    $StripOffsetTag = $tag;
                    continue;
                }
                fseek($tiffs[$base], $tag['offset']);
                $dataBytes = fread($tiffs[$base], $tag['externallength']);
                if ($tag['tag'] == 0x0117){
                    // StripByteCount
                    for ($j = 1; $j <= $tag['count']; $j++){
                        $value = $stripSizes[$base][$j] * $outbytes / $bytes;
                        if ($tag['type'] == 4){ $dataBytes = pack('V*', $value); }
                        elseif ($tag['type'] == 3){ $dataBytes = pack('v*', $value); }
                        else{ $dataBytes = pack('C*', $value); }
                        $buffer .= $dataBytes;
                    }
                    
                    $data = pack('vvVV', $tag['tag'], $tag['type'], $tag['count'], $byteswritten);
                    if ($tag['tag'] > 0x0111){ $lim .= $data; }
                    else{ fwrite($result, $data); }
                    $byteswritten += $tag['externallength'];
                }
                else{
                    $buffer .= $dataBytes;
                    $data = pack('vvVV', $tag['tag'], $tag['type'], $tag['count'], $byteswritten);
                    if ($tag['tag'] > 0x0111){ $lim .= $data; }
                    else{ fwrite($result, $data); }
                    $byteswritten += $tag['externallength'];
                }
            }
        }
        if ($StripOffsetTag != null && $multiStripped[$base]){
            $data = pack('vvVV', $StripOffsetTag['tag'], $StripOffsetTag['type'], $StripOffsetTag['count'], $byteswritten);
            $byteswritten += $StripOffsetTag['externallength'] + 2;
            fwrite($result, $data);
            fwrite($result, $lim);
            for($j = 1; $j <= $StripOffsetTag['count']; $j++){
                if ($StripOffsetTag['type'] == 4){ $dataBytes = pack('V', $byteswritten); }
                elseif ($StripOffsetTag['type'] == 3) { $dataBytes = pack('v', $byteswritten); }
                else { $dataBytes = pack('C', $byteswritten); }
                $buffer .= $dataBytes;
                $byteswritten += $stripSizes[$base][$j] * $outbytes / $bytes;
            }
        }
        if ($StripOffsetTag != null && !$multiStripped[$base]){
            $StripOffsetTag['offset'] = $byteswritten + 2;
            $data = pack('vvVV', $StripOffsetTag['tag'], $StripOffsetTag['type'], $StripOffsetTag['count'], $StripOffsetTag['offset']);
            fwrite($result, $data);
            fwrite($result, $lim);
        }
        $dataBytes = pack('V', 0x00);
        fwrite($result, $dataBytes);
        fwrite($result, $buffer);
        fwrite($result, pack('v', 0x00));
        $buffer = '';
        
        // min, max, nodata
        $min = 10000000; $max = -10000000; $nodata = 10000000;
        // preparations for algebra
        $in_buffers = array();  // buffers for values read from the source files
        $indexes = array();     // array of current indexes in the in_buffers[]
        $index_lims = array();  // array with the sizes of buffers
        $strips = array();      // # of current strip

        // using Expression class below
        $calc = new Expression();
        $calc->SetExpression($json->params);
        $data = $calc->GetTokens();
        $tokens = $calc->GetTokens();
        
        $value = false;
        for ($i = 0; $i < $count; $i++){
            fseek($tiffs[$i], $stripOffsets[$i][1]);
            $indexes[$i] = 1;
            $strips[$i] = 1;
            if ($multiStripped[$i]){
                $dataBytes = fread($tiffs[$i], $stripSizes[$i][1]);
                $in_buffers[$i] = unpack($valueins[$i], $dataBytes);
                $index_lims[$i] = $stripSizes[$i][1] / $bytes[$i];
            }
            else{
                $lim = ($pointsleft > 32768) ? 32768 : $pointsleft;
                $dataBytes = fread($tiffs[$i], $lim * $bytes[$i]);
                $in_buffers[$i] = unpack($valueins[$i], $dataBytes);
                $index_lims[$i] = $lim;
            }
            if ($in_buffers[$i][$indexes[$i]] == $nodatas[$i]){ $value = true; }
            $layers[$i] = $in_buffers[$i][$indexes[$i]];
            for ($j = 0; $j < count($data); $j++){
                if ($data[$j] == '{{' . $json->sources[$i]->variable . '}}'){
                    $tokens[$j] = &$layers[$i];
                }
            }
        }
        $calc->UpdateTokens($tokens);
        // actual algebra
        while ($pointsleft > 0){
            $data = $calc->EvaluateExpression();
            if (is_nan($data) || $value){ $data = $nodatas[$base]; }
            if ($data > $max){ $max = $data; }
            if ($data < $nodata){ $min = $nodata; $nodata = $data; }
            if ($data < $min && $data > $nodata){ $min = $data; }
            $buffer .= pack($valueout, $data);
            $pointsleft--;
            $value = false;
            $i = 0;
            while ($i < $count){
                $indexes[$i]++;
                if ($indexes[$i] > $index_lims[$i]){
                    if ($multiStripped[$i]){
                        $strips[$i]++;
                        fseek($tiffs[$i], $stripOffsets[$i][$strips[$i]]);
                        $dataBytes = fread($tiffs[$i], $stripSizes[$i][$strips[$i]]);
                        $in_buffers[$i] = unpack($valueins[$i], $dataBytes);
                        $indexes[$i] = 1;
                        $index_lims[$i] = $stripSizes[$i][$strips[$i]] / $bytes[$i];
                    }
                    else{
                        $lim = ($pointsleft > 32768) ? 32768 : $pointsleft;
                        $dataBytes = fread($tiffs[$i], $lim * $bytes[$i]);
                        $in_buffers[$i] = unpack($valueins[$i], $dataBytes);
                        $indexes[$i] = 1;
                        $index_lims[$i] = $lim;
                    }
                    if ($buffer != ''){
                        fwrite($result, $buffer);
                        $buffer = '';
                    }
                }
                if ($in_buffers[$i][$indexes[$i]] == $nodatas[$i]){ $value = true; }
                $layers[$i] = $in_buffers[$i][$indexes[$i]];
                $i++;
            }
        }
        if ($buffer != ''){
            fwrite($result, $buffer);
            $buffer = '';
        }

        // close the files and return the created layer's data
        for ($i = 0; $i < $count; $i++){ fclose($tiffs[$i]); }
        fclose($result);
        // copy additional files
        $cs = $json->sources[$base]->cs;
        $source = "$directory/$cs/$cs.tfw";
        if(file_exists($source)){ copy($source, "$directory/$newname/$newname.tfw"); }
        $source = "$directory/$cs/$cs.prj";
        if(file_exists($source)){ copy($source, "$directory/$newname/$newname.prj"); }
        // return 'success'
        return "{\"success\":true,\"min\":$min,\"max\":$max, \"nodata\":$nodata,\"width\":$width,\"height\":$height,\"name\":\"$newname\"}";
    }

    // test method
    public function testRasterAlgeraAction(){
        return $this->render('OGISIndexBundle:Test:tester.html.twig');
    }
    
    public function testAlgebraAction(){
        $json_raw = file_get_contents('php://input');
        $json = json_decode($json_raw);
        
        if ($json->isReclass){ $i = self::TiffReclassification($json->sources->cs, $json->params, -100); }
        else{ $i = self::processRasters($json, true); }
        
        return new response("<br/>response: $i", 200);
    }
}

class Expression{
    protected $_expression;         // source expression
    protected $_tokens = array();   // tokenized in RPN
    protected $_evstack = array();  // evaluation stack
    protected $T_LST = 1,           // lowest-priority  ~ functions, brackets
              $T_LOW = 2,           // low-priority     ~ plus, binary minus
              $T_MID = 3,           // medium-priority  ~ multiply, divide
              $T_MHG = 4,           // medium-high      ~ power
              $T_HGH = 5;           // highest-priority ~ unary minus

    // sets the expression to evaluate
    public function SetExpression($expression){
        $this->_expression = preg_replace('/[\s\n\t\f\r\v]+/', '', $expression);    // remove unnecessary symbols
        $this->InfixToRPN();
        return $this;
    }
    
    // reorder tokens into an RPN -- assumes that expression is valid
    public function InfixToRPN(){
        $tokens = preg_split('@(\+|\-|\*|/|\^|sin|cos|tan|ctg|sqrt|\(|\))@', $this->_expression, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $count = count($tokens);
        $infixmin = true;
        $priority_stack = array();
        for ($i = 0; $i < $count; $i++){
            $token = $tokens[$i];
            switch($token){
                // lower-priority operators can't be in stack higher than higher-priority operators
                // low = { + , - } >> high = { * , - } >> extreme = { unary_minus }
                // brackets are always added onto the stack, regardless of what is there at the moment
                case 'sin': $this->_evstack[] = $token;
                            $priority_stack[] = $this->T_LST;
                            break;
                case 'cos': $this->_evstack[] = $token;
                            $priority_stack[] = $this->T_LST;
                            break;
                case 'tan': $this->_evstack[] = $token;
                            $priority_stack[] = $this->T_LST;
                            break;
                case 'ctg': $this->_evstack[] = $token;
                            $priority_stack[] = $this->T_LST;
                            break;
                case 'sqrt': $this->_evstack[] = $token;
                            $priority_stack[] = $this->T_LST;
                            break;
                case '+' :  $p = $this->T_LOW;
                            while (true){
                                $j = end($this->_evstack);
                                $k = end($priority_stack);
                                if ($j == null || $p > $k){ break; }
                                $this->_tokens[] = array_pop($this->_evstack);
                                array_pop($priority_stack);
                            }
                            $this->_evstack[] = $token;
                            $priority_stack[] = $p;
                            $infixmin = true;
                            break;
                case '-' :  if ($infixmin){
                                $this->_evstack[] = '_';
                                $priority_stack[] = $this->T_HGH;
                                break;
                            }
                            else {
                                $p = $this->T_LOW;
                                while (true){
                                    $j = end($this->_evstack);
                                    $k = end($priority_stack);
                                    if ($j == null || $p > $k){ break; }
                                    $this->_tokens[] = array_pop($this->_evstack);
                                    array_pop($priority_stack);
                                }
                                $this->_evstack[] = $token;
                                $priority_stack[] = $p;
                                $infixmin = true;
                                break; }
                case '*' :  $p = $this->T_MID;
                            while (true){
                                $j = end($this->_evstack);
                                $k = end($priority_stack);
                                if ($j == null || $p > $k){ break; }
                                $this->_tokens[] = array_pop($this->_evstack);
                                array_pop($priority_stack);
                            }
                            $this->_evstack[] = $token;
                            $priority_stack[] = $p;
                            $infixmin = true;
                            break;
                case '^' :  $p = $this->T_MHG;
                            while (true){
                                $j = end($this->_evstack);
                                $k = end($priority_stack);
                                if ($j == null || $p >= $k){ break; }
                                $this->_tokens[] = array_pop($this->_evstack);
                                array_pop($priority_stack);
                            }
                            $this->_evstack[] = $token;
                            $priority_stack[] = $p;
                            $infixmin = true;
                            break;
                case '/' :  $p = $this->T_MID;
                            while (true){
                                $j = end($this->_evstack);
                                $k = end($priority_stack);
                                if ($j == null || $p > $k){ break; }
                                $this->_tokens[] = array_pop($this->_evstack);
                                array_pop($priority_stack);
                            }
                            $this->_evstack[] = $token;
                            $priority_stack[] = $p;
                            $infixmin = true;
                            break;
                case '(' :  $this->_evstack[] = '(';
                            $priority_stack[] = $this->T_LST;
                            $infixmin = true;
                            break;
                case ')' :  $j = array_pop($this->_evstack);            // minus immediately after will be binary
                            while($j != '('){
                                $this->_tokens[] = $j;
                                $j = array_pop($this->_evstack);
                            }
                            $infixmin = false;
                            break;
                default  :  $this->_tokens[] = $token; $infixmin = false; break;
            }
        }
        while (($j = array_pop($this->_evstack)) != null){ $this->_tokens[] = $j; }
        return $this;
    }
    
    // evaluates expression
    public function EvaluateExpression(){
        $count = count($this->_tokens);
        unset($this->_evstack);
        $this->_evstack = array();
        $left; $right;                                      // operands holders
        for ($i = 0; $i < $count; $i++){
            $token = $this->_tokens[$i];
            switch($token){
                case '+' :  $right = array_pop($this->_evstack);
                            $left = array_pop($this->_evstack);
                            $this->_evstack[] = $left + $right;
                            break;
                case '-' :  $right = array_pop($this->_evstack);
                            $left = array_pop($this->_evstack);
                            $this->_evstack[] = $left - $right;
                            break;
                case '*' :  $right = array_pop($this->_evstack);
                            $left = array_pop($this->_evstack);
                            $this->_evstack[] = $left * $right;
                            break;
                case '/' :  $right = array_pop($this->_evstack);
                            $left = array_pop($this->_evstack);
                            if ($right == 0){ return NAN; }
                            $this->_evstack[] = $left / $right;
                            break;
                case '^' :  $right = array_pop($this->_evstack);
                            $left = array_pop($this->_evstack);
                            $this->_evstack[] = pow($left, $right);
                            break;
                case '_' :  $right = array_pop($this->_evstack);
                            $this->_evstack[] = -$right;
                            break;
                case 'sin': $right = array_pop($this->_evstack);
                            $this->_evstack[] = sin($right);
                            break;
                case 'cos': $right = array_pop($this->_evstack);
                            $this->_evstack[] = cos($right);
                            break;
                case 'tan': $right = array_pop($this->_evstack);
                            $left = cos($right);
                            if ($left == 0){ return NAN; }
                            $this->_evstack[] = sin($right) / $left;
                            break;
                case 'ctg': $right = array_pop($this->_evstack);
                            $left = sin($right);
                            if ($left == 0){ return NAN; }
                            $this->_evstack[] = cos($right) / $left;
                            break;
                case 'sqrt': $right = array_pop($this->_evstack);
                            $this->_evstack[] = sqrt($right);
                            break;
                default  :  $this->_evstack[] = $token;
                            break;
            }
        }
        return array_pop($this->_evstack);
    }
    
    // debug functions
    public function GetTokens(){ return $this->_tokens; }
    public function GetExpression() { return $this->_expression; }
    
    // update tokens
    public function UpdateTokens($tokens){
        $this->_tokens = $tokens;
        return $this;
    }
    
}
