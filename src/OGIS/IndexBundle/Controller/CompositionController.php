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
use OGIS\IndexBundle\Entity\Composition;
use OGIS\IndexBundle\Entity\Link;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class CompositionController extends Controller{

    public function showCompositionAction($id){
        $em = $this->getDoctrine()->getManager();
        $composition = $em->getRepository('OGIS\IndexBundle\Entity\Composition')->find($id);
        if(!$composition){
                return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                        'caption' => "Error while reading composition!",
                        'message' => "The composition you're looking for doesn't exist in the database."
                ));
        }
        $composition->setViews($composition->getViews() + 1);
        $em->persist($composition);
        $em->flush();

        $viewable = false;
        $authorizationChecker = $this->get('security.context');
        if ($authorizationChecker->isGranted('VIEW', $composition) || $authorizationChecker->isGranted('ROLE_ADMIN') || $composition->getPublic()){
            $viewable = true;
        }
        return $this->render('OGISIndexBundle:Objects:composition.html.twig', array('composition' => $composition, 'viewable' => $viewable));
    }
    
    public function getCompositionDataAction($id){
        $em = $this->getDoctrine()->getManager();
        $composition = $em->getRepository('OGIS\IndexBundle\Entity\Composition')->find($id);
        if (!$composition){
            $output = '{"success": false}';
            $response = new Response($output);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        $data = $composition->getData();
        $minx = $composition->getBoundingBoxMinX();
        $miny = $composition->getBoundingBoxMinY();
        $maxx = $composition->getBoundingBoxMaxX();
        $maxy = $composition->getBoundingBoxMaxY();
//        $output = '{"success":true,"data":' . $data . '}';
        $output = '{"success":true,"data":' . $data . ',"maxExtent":{"minX":' . $minx . ',"minY":' . $miny . ',"maxX":' . $maxx . ',"maxY":' . $maxy . '}}';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    private function generateCompositionPreview($layers, $filename, $boundingBox, $proj){
        $layer_img = array();
        $counter = 0;
        $server = $_SERVER['SERVER_ADDR'];
        foreach ($layers as $layer){
            if ($layer->vis == "false"){ continue; }
            $cs = $layer->cs;
            $ws = $layer->workspace;
            $is_sld = null;
            if ($layer->style->type == 'id'){ $is_sld = false; }
            else{ $is_sld = true; }
            $url = "http://$server:8080/geoserver/wms/reflect?FORMAT=image/png&transparent=true&layers=$ws:$cs&bbox=" . $boundingBox['minx'] . ',' . $boundingBox['miny'] . ',' . $boundingBox['maxx'] . ',' . $boundingBox['maxy'] . '&srs=' . $proj;
            if($is_sld){ $url .= '&sld_body=' . urlencode($layer->style->value); }
            else{ $url .= '&styles='. $layer->style->value; }
            $context = stream_context_create(array('http' => array('header' => "Authorization: Basic " . base64_encode("admin:geoserver"))));
            $layer_img[$counter] = imagecreatefromstring(file_get_contents($url, false, $context));
            imagesavealpha($layer_img[$counter], true);
            imagealphablending($layer_img[$counter], true);
            $counter++;
        }

        $width = imagesx($layer_img[0]);	// all images should be of the same resolution since the layers they depict
        $height = imagesy($layer_img[0]);	// have the same projection and the same bounding box

        $finalImage = imagecreatetruecolor($width, $height);
        imagefill($finalImage, 0, 0, IMG_COLOR_TRANSPARENT);
        imagesavealpha($finalImage, true);
        imagealphablending($finalImage, true);
        for($i = 0; $i < count($layer_img); $i++){
            imagecopy($finalImage, $layer_img[$i], 0, 0, 0, 0, $width, $height);
        }
        imagepng($finalImage, "/var/www/html/o-gis/web/img/composition_preview/$filename.png");
        imagedestroy($finalImage);
        $im = null;
        return $url;
    }

    public function saveCompositionAction($id){
        $json_raw = file_get_contents('php://input');
        $json = json_decode($json_raw);
        $catalog = $json->catalog;
        unset($json->catalog);
        if ($this->getUser() == null){ return new Response("Error: not authenticated!", 403); }
        if ($id == null){
            $author_id = $json->authors[0]->id;
            $cmp_proj = $json->projection;
            $layers = array();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($author_id);
            for($i = 0; $i < count($json->layers); $i++){
                $cs = $json->layers[$i]->cs;
                $layer_entity = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->findOneBy(array('con_string' => $cs));
                if ($layer_entity){ $layers[] = $layer_entity; }
            }
            $minx = 1000000000;
            $miny = 1000000000;
            $maxx = -1000000000;
            $maxy = -1000000000;
            foreach($layers as $layer){
                if ($layer->getProjection() != $cmp_proj){ continue; }
                if ($layer->getBoundingBoxMinX() < $minx){ $minx = $layer->getBoundingBoxMinX(); }
                if ($layer->getBoundingBoxMinY() < $miny){ $miny = $layer->getBoundingBoxMinY(); }
                if ($layer->getBoundingBoxMaxX() > $maxx){ $maxx = $layer->getBoundingBoxMaxX(); }
                if ($layer->getBoundingBoxMaxY() > $maxy){ $maxy = $layer->getBoundingBoxMaxY(); }
            }

            $filename = time() . "_" . $user->getId();
            // get the preview image
            $boundingBox = array('minx' => $minx, 'miny' => $miny, 'maxx' => $maxx, 'maxy' => $maxy);
            $i = self::generateCompositionPreview($json->layers, $filename, $boundingBox, $cmp_proj);

            $composition = new Composition();
            $composition->setName($json->name);
            $composition->setDescription($json->description);
            $composition->setAuthor($user);
            $composition->setCreated(new \DateTime("now"));
            $composition->setModified(new \DateTime("now"));
            $composition->setPublic(true);
            $composition->setViews(0);
            $composition->setData($json_raw);
            $composition->setProjection($cmp_proj);
            $composition->setBoundingBoxMinX($minx);
            $composition->setBoundingBoxMinY($miny);
            $composition->setBoundingBoxMaxX($maxx);
            $composition->setBoundingBoxMaxY($maxy);
            $composition->setPreview("./img/composition_preview/$filename.png");

            foreach($layers as $layer){
                $composition->addLayer($layer);
                $layer->addComposition($composition);
                $em->persist($layer);
            }
            $em->persist($composition);
            $em->flush();

            // ACL for composition
            $securityIdentity = UserSecurityIdentity::fromAccount($this->getUser());
            $compositionIdentity = ObjectIdentity::fromDomainObject($composition);
            $aclProvider = $this->get('security.acl.provider');
            try{
                $acl = $aclProvider->findAcl($compositionIdentity);
            }catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
                $acl = $aclProvider->createAcl($compositionIdentity);
            }
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            $cmp_id = $composition->getId();
            $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($catalog);
            $link = new Link();
            $link->setTargetType('composition');
            $link->setTargetTitle($json->name);
            $link->setTargetId($cmp_id);
            $link->setCatalog($catalog);
            $link->setExtraInfo("");
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
            $message = "$cmp_id";
        }
        else {
            $author_id = $json->authors[0]->id;
            $layers = array();
            $em = $this->getDoctrine()->getManager();
            $composition = $em->getRepository('OGIS\IndexBundle\Entity\Composition')->find($id);

            $old_layers = $composition->getLayers();
            $cmp_proj = $composition->getProjection();
            foreach($old_layers as $old_layer){
                $composition->removeLayer($old_layer);
                $old_layer->removeComposition($composition);
                $em->persist($old_layer);
            }
            $em->flush();

            for($i = 0; $i < count($json->layers); $i++){
                $cs = $json->layers[$i]->cs;
                $layer_entity = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->findOneBy(array('con_string' => $cs));
                if ($layer_entity){ $layers[] = $layer_entity; }
            }
            $minx = 1000000000;
            $miny = 1000000000;
            $maxx = -1000000000;
            $maxy = -1000000000;
            foreach($layers as $layer){
                if ($layer->getProjection() != $cmp_proj){ continue; }
                if ($layer->getBoundingBoxMinX() < $minx){ $minx = $layer->getBoundingBoxMinX(); }
                if ($layer->getBoundingBoxMinY() < $miny){ $miny = $layer->getBoundingBoxMinY(); }
                if ($layer->getBoundingBoxMaxX() > $maxx){ $maxx = $layer->getBoundingBoxMaxX(); }
                if ($layer->getBoundingBoxMaxY() > $maxy){ $maxy = $layer->getBoundingBoxMaxY(); }
            }
            $preview = $composition->getPreview();
            $filename = substr($preview, strlen($preview) - 16, 12);
            $boundingBox = array('minx' => $minx, 'miny' => $miny, 'maxx' => $maxx, 'maxy' => $maxy);
            $i = self::generateCompositionPreview($json->layers, $filename, $boundingBox, $cmp_proj);

            $composition->setModified(new \DateTime("now"));
            $composition->setBoundingBoxMinX($minx);
            $composition->setBoundingBoxMinY($miny);
            $composition->setBoundingBoxMaxX($maxx);
            $composition->setBoundingBoxMaxY($maxy);
            $composition->setData($json_raw);

            foreach($layers as $layer){
                $composition->addLayer($layer);
                $layer->addComposition($composition);
                $em->persist($layer);
            }
            $em->persist($composition);
            $em->flush();

            $cmp_id = $composition->getId();
            $message = "$cmp_id";
        }
    return new Response($message, 200);
    }

  public function editCompositionPropertiesAction($id){
      if ($this->getUser() == null){
          $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">logging in</a>";
          return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
              'caption' => "Access denied!",
              'message' => "You don't have necessary permissions to view this page!",
              'tip'     => "To get the permissions, try $login_link into O-GIS."
          ));
      }
      $em = $this->getDoctrine()->getManager();
      $composition = $em->getRepository('OGIS\IndexBundle\Entity\Composition')->find($id);
      $authorizationChecker = $this->get('security.context');
      if(!$authorizationChecker->isGranted('EDIT', $composition) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
          return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
              'caption' => "Access denied!",
              'message' => "You don't have necessary permissions to view this page!",
              'tip'     => ""
          ));
      }
      return $this->render('OGISIndexBundle:Edit:editcompositionproperties.html.twig', array('composition' => $composition));
    }
    
    public function saveCompositionPropertiesAction($id){
        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have necessary permissions to view this page!",
                'tip'     => "To get the permissions, try $login_link into O-GIS."
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $composition = $em->getRepository('OGIS\IndexBundle\Entity\Composition')->find($id);
        $authorizationChecker = $this->get('security.context');
        if(!$authorizationChecker->isGranted('EDIT', $composition) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have necessary permissions to view this page!",
                'tip'     => ""
            ));
        }

        $title = $_POST['_compositionname'];
        $descr = $_POST['_compositiondescription'];
        $composition->setName($title);
        $composition->setDescription($descr);
        $composition->setModified(new \DateTime("now"));
        $em->persist($composition);
        $em->flush();

        $query = $em->createQuery("UPDATE OGIS\IndexBundle\Entity\Link l SET l.targetTitle = '$title' WHERE l.targetType = 'composition' AND l.targetId = $id");
        $nullres = $query->getSingleResult();
        return $this->redirect($this->generateUrl('edit_composition_properties', array('id' => $id)), 301);
    }
    
    public function deleteCompositionConfirmAction($id){
        $em = $this->getDoctrine()->getManager();
        $composition = $em->getRepository('OGIS\IndexBundle\Entity\Composition')->find($id);
        if(!$composition){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Composition not found!",
                'message' => "The composition you're trying to delete doesn't exist in the database."
            ));
        }
        $authorizationChecker = $this->get('security.context');
        if(!$authorizationChecker->isGranted('DELETE', $composition) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permissions necessary to perform this action!",
                'tip'     => ""
            ));
        }
        return $this->render('OGISIndexBundle:Delete:deleteconfirmation.html.twig', array(
            'entitytype' => "composition",
            'entitytype_en' => "composition",
            'entitytype_rp' => "composition",
            'entityname' => $composition->getName(),
            'entityid' => $composition->getId()
        ));
    }

    public function deleteCompositionAction($id){
        $em = $this->getDoctrine()->getManager();
        $composition = $em->getRepository('OGIS\IndexBundle\Entity\Composition')->find($id);
        if ($this->getUser() == null){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permissions necessary to perform this action!",
                'tip'     => ""
            ));
        }
        $authorizationChecker = $this->get('security.context');
        if(!$authorizationChecker->isGranted('DELETE', $composition) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permissions necessary to perform this action!",
                'tip'     => ""
            ));
        }
        $name = $composition->getName();
        $author = $composition->getAuthor();
        $author->removeComposition($composition);

        $layers = $composition->getLayers();
        foreach($layers as $layer){
            $layer->removeComposition($composition);
        }
        // and remove all links
        $links = $em->getRepository('OGIS\IndexBundle\Entity\Link')->findBy(array('targetType' => 'composition', 'targetId' => $composition->getId()));
        foreach($links as $link){
            $em->remove($link);
        }
            
        // remove ACL
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($composition);
        $aclProvider->deleteAcl($objectIdentity);

        $em->remove($composition);
        $em->flush();

        return $this->redirect($this->generateUrl('deletecompositionsuccess', array('name' => $name)), 301);
    }

    public function deleteCompositionSuccessAction($name){
        return $this->render('OGISIndexBundle:Delete:deletesuccess.html.twig', array(
            'caption' => "Operation successful",
            'message' => "Your composition \"$name\" was successfully deleted from the database."
        ));
    }

}
