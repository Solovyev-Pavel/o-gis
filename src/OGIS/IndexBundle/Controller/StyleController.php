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
use OGIS\IndexBundle\Entity\Style;
use OGIS\IndexBundle\Entity\Link;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class StyleController extends Controller {

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

    protected function unregisterStyle($styleName){
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver/rest/styles/$styleName";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $code;
    }

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

    public function createStyleAction(){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        return $this->render('OGISIndexBundle:Create:createstyle.html.twig');
    }

    public function createRasterStyleAction(){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        return $this->render('OGISIndexBundle:Create:createrasterstyle.html.twig');
    }
        
    public function uploadStyleAction(){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $stylename = $_POST['_stylename'];
        $styledescription = $_POST['_styledescription'];
        $styletype = $_POST['_styletype'];
        $stylebody = $_POST['_stylebody'];
        $targetcatalog = $_POST['_targetcatalog'];
        $internalname = time() . "_" . $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $style = new Style();
        $style->setAuthor($this->getUser());
        $style->setName($stylename);
        $style->setType($styletype);
        $style->setDescription($styledescription);
        $style->setData($stylebody);
        $style->setPublic(true);
        $style->setInternalname($internalname);
        $style->setCreated(new \DateTime("now"));
        $style->setModified(new \DateTime("now"));

        $em->persist($style);
        $em->flush();

        // ACL for style
        $securityIdentity = UserSecurityIdentity::fromAccount($this->getUser());
        $layerIdentity = ObjectIdentity::fromDomainObject($style);
        $aclProvider = $this->get('security.acl.provider');
        try{
            $acl = $aclProvider->findAcl($layerIdentity);
        }catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
            $acl = $aclProvider->createAcl($layerIdentity);
        }
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);

        $id = $style->getId();
        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($targetcatalog);
        $destination = "/var/lib/tomcat7/webapps/geoserver/data/styles/$internalname.sld";
        $sldoutput = fopen($destination, 'wb');
        fwrite($sldoutput, $stylebody);
        fclose($sldoutput);
        $i = self::registerStyle($internalname);

        $link = new Link();
        $link->setTargetType('style');
        $link->setTargetTitle($stylename);
        $link->setTargetId($id);
        $link->setExtraInfo($internalname);
        $link->setCatalog($catalog);

        $em->persist($link);
        $em->flush();

        // ACL for catalog
        $linkIdentity = ObjectIdentity::fromDomainObject($link);
        try{
            $acl = $aclProvider->findAcl($linkIdentity);
        }catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
            $acl = $aclProvider->createAcl($linkIdentity);
        }
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);

        $stylebody = htmlentities($stylebody);
        return new Response("<b>name</b>:&nbsp;$stylename<br/><b>description</b>:&nbsp;$styledescription<br/><b>type</b>:&nbsp;$styletype<br/><br/>$stylebody", 200);
    }

    public function listStylesAction(){
        return $this->render('OGISIndexBundle:Lists:stylelist.html.twig');
    }
        
    public function showStyleAction($id){
        $em = $this->getDoctrine()->getManager();
        $style = $em->getRepository('OGIS\IndexBundle\Entity\Style')->find($id);
        return $this->render('OGISIndexBundle:Objects:style.html.twig', array('style' => $style));
    }
        
    public function getStyleListAction(){
        $type = $_GET['type'];
        $em = $this->getDoctrine()->getManager();
        $output = '[';

        if ($this->getUser() != null){
            $userid = $this->getUser()->getId();
            $query = $em->createQuery("SELECT s.name, s.internalname FROM OGISIndexBundle:Style s WHERE s.type = '$type' AND s.public = false AND s.author = $userid");
            $styles = $query->getResult();
            $stylescount = count($styles);
            for ($i = 0; $i < $stylescount; $i++){
                $name = $styles[$i]['name'];
                $internalname = $styles[$i]['internalname'];
                if ($output[strlen($output) - 1] != '['){ $output .= ','; }
                $output .= "{ \"name\": \"$name\", \"internalname\": \"$internalname\" }";	
            }
        }

        $query = $em->createQuery("SELECT s.name, s.internalname FROM OGISIndexBundle:Style s WHERE s.type = '$type' AND s.public = true");
        $styles = $query->getResult();
        $stylescount = count($styles);
        for ($i = 0; $i < $stylescount; $i++){
            $name = $styles[$i]['name'];
            $internalname = $styles[$i]['internalname'];
            if ($output[strlen($output) - 1] != '['){ $output .= ','; }
            $output .= "{ \"name\": \"$name\", \"internalname\": \"$internalname\" }";	
        }

        $output .= ']';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    public function applyStyleAction(){
        $layercs = $_POST['_layer'];
        $cs = substr($layercs, strpos($layercs, ':') + 1);
        $stylename = $_POST['_style'];
        $em = $this->getDoctrine()->getManager();

        $style = $em->getRepository('OGIS\IndexBundle\Entity\Style')->findOneBy(array('internalname' => $stylename));
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->findOneBy(array('con_string' => $cs));

        $i = self::applyStyleToLayer($stylename, $layercs);
        $id = $layer->getId();

        $layer->setStyle($style);
        $layer->setPalette(NULL);
        $em->persist($layer);
        $em->flush();

        return $this->redirect($this->generateUrl('edit_layer_properties', array('id' => $id)), 301);
    }
        
    public function applyCustomStyleAction(){
        $cs = $_POST['_layer'];
        $sld = $_POST['_style'];
        $palette = $_POST['_palette'];

        $em = $this->getDoctrine()->getManager();
        $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->findOneBy(array('con_string' => $cs));
        
        // save the style
        $destination = "/var/lib/tomcat7/webapps/geoserver/data/styles/$cs.sld";
        $i = self::applyStyleToLayer($layer->getType(), $cs);
        $i = self::unregisterStyle($cs);
        unlink($destination);
        unlink("/var/lib/tomcat7/webapps/geoserver/data/styles/$cs.xml");
        $sldoutput = fopen($destination, 'wb');
        fwrite($sldoutput, $sld);
        fclose($sldoutput);
        $i = self::registerStyle($cs);
        $i = self::applyStyleToLayer($cs, 'OGIS:' . $cs);
        
        $layer->setPalette($palette);
        $layer->setStyle(NULL);

        $id = $layer->getId();
        $em->persist($layer);
        $em->flush();
        return $this->redirect($this->generateUrl('edit_layer_properties', array('id' => $id)), 301); 
    }

}
