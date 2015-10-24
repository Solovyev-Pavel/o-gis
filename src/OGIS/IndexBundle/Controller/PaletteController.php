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
use OGIS\IndexBundle\Entity\Palette;
use OGIS\IndexBundle\Entity\Link;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class PaletteController extends Controller {

    // return the list of (available) palettes
    public function listPalettesAction(){
        $em = $this->getDoctrine()->getManager();
        $output = '{"palettes":[';
        if ($this->getUser() != null){
            $userID = $this->getUser()->getId();
            $palettes = $this->getUser()->getPalettes();
            foreach($palettes as $palette){
                if ($palette->getPublic()){ continue; }
                $id = $palette->getId();
                $name = $palette->getName();
                if ($output[strlen($output) - 1] != '['){ $output .= ','; }
                $output .= "{\"id\": $id, \"name\":\"$name\", \"author\":$userID}";
            }
        }
        $palettes = $em->getRepository('OGIS\IndexBundle\Entity\Palette')->findBy(array('public' => true));
        $palettescount = count($palettes);
        for ($i = 0; $i < $palettescount; $i++){
            $id = $palettes[$i]->getId();
            $name = $palettes[$i]->getName();
            $author = $palettes[$i]->getAuthor()->getId();
            if ($output[strlen($output) - 1] != '['){ $output .= ','; }
            $output .= "{\"id\": $id, \"name\":\"$name\", \"author\":$author}";
        }
        $output .= ']}';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    // page with tree & palettes
    public function listPalettesEditorAction(){
        return $this->render('OGISIndexBundle:Lists:palettelist.html.twig');
    }
    
    // page with tree & palettes for composition editor
    public function listPalettesMainEditorAction() {
        return $this->render('OGISIndexBundle:Lists:palettelisteditor.html.twig');
    }
    
    // loading palette
    public function getPaletteAction($id){
        $em = $this->getDoctrine()->getManager();
        $palette = $em->getRepository('OGIS\IndexBundle\Entity\Palette')->find($id);
        if(!$palette){
            $output = '{"success":false,"msg":"Requested palette doesn\'t exist in the database!"}';
            $response = new Response($output);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        $id = $palette->getId();
        $name = $palette->getName();
        $colors = $palette->getColors();
        $keyVals = $palette->getKeyValues();
        $author = $palette->getAuthor()->getId();
        $output = "{\"success\":true,\"id\":$id,\"name\":\"$name\",\"author\":$author,\"colors\":\"$colors\",\"keyValues\":[$keyVals]}";
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }
    
    // load palette compressed - used in editor | so far
    public function getPaletteCompressedAction($id){
        $em = $this->getDoctrine()->getManager();
        $palette = $em->getRepository('OGIS\IndexBundle\Entity\Palette')->find($id);
        if(!$palette){
            $output = '{"success":false,"msg":"Requested palette doesn\'t exist in the database!"}';
            $response = new Response($output);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        $id = $palette->getId();
        $name = $palette->getName();
        $colors = $palette->getColors();
        $keyVals = $palette->getKeyValues();
        
        $output = "{\"success\":true,\"id\":$id,\"name\":\"$name\",\"colors\":[";
        $tmp = '"locations":[';
        
        $arr_keyvals = preg_split('/,/', $keyVals);
        $num_keyvals = count($arr_keyvals);
        for ($i = 0; $i < $num_keyvals; $i++){
            $c_loc = intval($arr_keyvals[$i]);
            $c_loc_abs = number_format(($c_loc - 1) / 255, 5);
            $c_clr = '0x' . substr($colors, ($c_loc - 1) * 8, 6);
            $c_opc = hexdec(substr($colors, ($c_loc - 1) * 8 + 6, 2)) / 255;
            $c_pos = $arr_keyvals[$i] - 1;
            if ($i > 0){ $output .= ','; $tmp .= ','; }
            $output .= "{\"rgb\":\"$c_clr\",\"opacity\":$c_opc,\"pos\":$c_pos}";
            $tmp .= $c_loc_abs;
        }
        
        $tmp .= ']';
        $output .= "], $tmp}";
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    // saving palette
    public function savePaletteAction($id){
        $json = json_decode(file_get_contents('php://input'));
        $em = $this->getDoctrine()->getManager();
        $limits = $this->getUser()->getLimits()->getPalettes();
        if($id == null){
            // check if user can create new palette
            if($this->getUser() == null){
                $output = '{"success":false, "msg":"Anonymous users can\'t save palettes!"}';
                $response = new Response($output);
                $response->headers->set('Content-Type', 'application/json');
                $response->setCharset('UTF-8');
                return $response;
            }
            if($limits != null && $limits == count($this->getUser()->getPalettes())){
                $output = '{"success":false, "msg":"You\'ve already reached the maximal permitted number of palettes!"}';
                $response = new Response($output);
                $response->headers->set('Content-Type', 'application/json');
                $response->setCharset('UTF-8');
                return $response;
            }
            // create new palette
            $palette = new Palette();
            $palette->setName($json->name);
            $palette->setColors($json->colors);
            $palette->setDescription($json->description);
            $palette->setKeyValues($json->keyValues);
            $palette->setPublic($json->public);
            $palette->setAuthor($this->getUser());
            
            $em->persist($palette);
            $em->flush();
            $palette_id = $palette->getId();

            // ACL
            $objectIdentity = ObjectIdentity::fromDomainObject($palette);
            $aclProvider = $this->get('security.acl.provider');
            try{
                $acl = $aclProvider->findAcl($objectIdentity);
            }catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
                $acl = $aclProvider->createAcl($objectIdentity);
            }
            $user = $this->get('security.context')->getToken()->getUser();
            $securityIdentity = UserSecurityIdentity::fromAccount($user);
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);
            
            // link
            $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($json->catalog);
            $link = new Link();
            $link->setTargetId($palette_id);
            $link->setTargetType('palette');
            $link->setTargetTitle($json->name);
            $link->setCatalog($catalog);
            $link->setExtraInfo('');
            
            $em->persist($link);
            $em->flush();
            
            // ACL
            $objectIdentity = ObjectIdentity::fromDomainObject($link);
            try{
                $acl = $aclProvider->findAcl($objectIdentity);
            }catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
                $acl = $aclProvider->createAcl($objectIdentity);
            }
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);
            
            $output = "{\"success\":true, \"id\":$palette_id, \"msg\":\"Palette saved successfully!\"}";
            $response = new Response($output);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        else{
            $palette = $em->getRepository('OGIS\IndexBundle\Entity\Palette')->find($id);
            $palette->setName($json->name);
            $palette->setColors($json->colors);
            $palette->setKeyValues($json->keyValues);
            $palette->setDescription($json->description);

            $em->persist($palette);
            
            // update all links
            $links = $em->getRepository('OGIS\IndexBundle\Entity\Link')->findBy(array('targetType' => 'palette', 'targetId' => $id));
            foreach($links as $link){
                $link->setTargetTitle($json->name);
                $em->persist($link);
            }
            
            $em->flush();
            $output = "{\"success\":true, \"id\":$id, \"msg\":\"Palette saved successfully!\"}";
            $response = new Response($output);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
    }

    // view palette
    public function showPaletteAction($id){
        $em = $this->getDoctrine()->getManager();
        $palette = $em->getRepository('OGIS\IndexBundle\Entity\Palette')->find($id);
        if (!$palette){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Palette not found!",
                'message' => "The requested palette doeesn't exist in the database."
            ));
        }
        $authorizationChecker = $this->get('security.context');
        if ($authorizationChecker->isGranted('VIEW', $palette) || $authorizationChecker->isGranted('ROLE_ADMIN') || $palette->getPublic()){ $viewable = true; }
        else { $viewable = false; }
        return $this->render('OGISIndexBundle:Objects:palette.html.twig', array('palette' => $palette, 'viewable' => $viewable));
    }

    // palette editor
    public function paletteEditorAction($id){
        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $palette = null;
        $overwrite = false;
        if ($id != null){
            $em = $this->getDoctrine()->getManager();
            $palette = $em->getRepository('OGIS\IndexBundle\Entity\Palette')->find($id);
            if (!$palette){
                return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                    'caption' => "Error!",
                    'message' => "Requested palette doesn't exist in the database."
                ));
            }
            $authorizationChecker = $this->get('security.context');
            if ($palette->getAuthor()->getId() == $this->getUser()->getId()){ $overwrite = true; }
            if ($authorizationChecker->isGranted('EDIT', $palette) || $authorizationChecker->isGranted('ROLE_ADMIN')){ $overwrite = true; }
        }
        return $this->render('OGISIndexBundle:Edit:editpalette.html.twig', array('palette' => $palette, 'overwrite' => $overwrite));
    }

    // confirm deleting palette
    public function deletePaletteConfirmAction($id) {
        $em = $this->getDoctrine()->getManager();
        $palette = $em->getRepository('OGIS\IndexBundle\Entity\Palette')->find($id);
        if (!$palette){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Error!",
                'message' => "Requested palette doesn't exist in the database."
            ));
        }
        $authorizationChecker = $this->get('security.context');
        if(!$authorizationChecker->isGranted('DELETE', $palette) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permissions necessary to perform this action!",
                'tip'     => ""
            ));
        }
        return $this->render('OGISIndexBundle:Delete:deleteconfirmation.html.twig', array(
            'entitytype' => "palette",
            'entitytype_en' => "palette",
            'entitytype_rp' => "palette",
            'entityname' => $palette->getName(),
            'entityid' => $palette->getId()
        ));
    }
 
    // deleting palette - DEPRECATED
    public function listDeletePaletteAction($id){
        if($this->getUser() == null){
            return new response('{"success":false, "msg":"You don\'t have the permissions necessary to perform this action!"}', 200);
        }
        $em = $this->getDoctrine()->getManager();
        $palette = $em->getRepository('OGIS\IndexBundle\Entity\Palette')->find($id);
        if(!$palette){
            return new response('{"success":false, "msg":"Palette doesn\'t exist!"}', 200);
        }
        $userID = $this->getUser()->getId();
        if($palette->getAuthor()->getId() != $userID){
            return new response('{"success":false, "msg":"You don\'t have the permissions necessary to perform this action!"}', 200);
        }
        $em->remove($palette);
        $em->flush();
        return new response("{\"success\":true, \"msg\":\"Palette deleted successfully!\"}", 200);		
    }
    
    // deleting palette
    public function deletePaletteAction($id){
        $em = $this->getDoctrine()->getManager();
        $palette = $em->getRepository('OGIS\IndexBundle\Entity\Palette')->find($id);        
        $authorizationChecker = $this->get('security.context');
        if(!$authorizationChecker->isGranted('DELETE', $palette) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permissions necessary to perform this action!",
                'tip'     => ""
            ));
        }
        
        // remove links
        $links = $em->getRepository('OGIS\IndexBundle\Entity\Link')->findBy(array('targetType' => 'palette', 'targetId' => $palette->getId()));
        foreach($links as $link){
            $em->remove($link);
        }
        
        // remove ACL
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($palette);
        $aclProvider->deleteAcl($objectIdentity);
        
        $name = $palette->getName();
        // remove object
        $em->remove($palette);
        $em->flush();
        
        return $this->redirect($this->generateUrl('deletepalettesuccess', array('name' => $name)), 301);        
    }
    
    // delete success
    public function deletePaletteSuccessAction($name){
        return $this->render('OGISIndexBundle:Delete:deletesuccess.html.twig', array(
            'caption' => "Suceess!",
            'message' => "Palette \"$name\" was successfully deleted."
        ));
    }

    // apply palette-created style to layer
    public function applyPaletteAction(){
        $sld = $_POST['_style'];
        $cs = $_POST['_layer'];
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
    
    // register palette-created style
    protected function registerStyle($styleName){
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver/rest/styles";
        $body = "<style><name>$styleName</name><filename>$styleName.sld</filename></style>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
//      curl_setopt($ch, CURLOPT_HTTPHEADER, array("7hTwlQptyN: admin", "Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $code;
    }
    
    // apply palette-created style to layer
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
//		curl_setopt($ch, CURLOPT_HTTPHEADER, array("7hTwlQptyN: admin", "Content-type: text/xml"));
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
//		curl_setopt($ch, CURLOPT_HTTPHEADER, array("7hTwlQptyN: admin", "Content-type: text/xml"));
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
        $output = fopen($path, 'w+');
        fwrite($output, $im);
        fclose($output);
    }
    
    // unregister style
    protected function unregisterStyle($styleName){
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver/rest/styles/$styleName";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
//		curl_setopt($ch, CURLOPT_HTTPHEADER, array("7hTwlQptyN: admin", "Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $code;
    }
    
}
