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
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use OGIS\IndexBundle\Entity\Catalog;
use OGIS\IndexBundle\Entity\Link;

// despite being called just CatalogController, this controller also works with 'Link' entities
class CatalogController extends Controller{

    // get the whole tree of a given user
    public function loadUserCatalogsAction($holderid){
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $is_admin = $authorizationChecker->isGranted('ROLE_ADMIN');
        
        $output = '{"catalogs": [';

        $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($holderid);
        $catalogs = $user->getCatalogs();
        // transform array of orm entities into json
        // using this method as we need to replace NULL for "#" for parent values
        foreach($catalogs as $catalog){
            if (!$authorizationChecker->isGranted('VIEW', $catalog) && !$catalog->getPublic() && !$is_admin){ continue; }
            if ($catalog->getParent() != null){ continue; }
            $id = $catalog->getId();
            $title = $catalog->getTitle();
            $type = 'catalog';
            $flags = '';
            if ($this->getUser() != null){
                // user can favorite this catalog : user is not its owner
                if ($holderid != $this->getUser()->getId()){ $flags .= 'f'; }
                // user can edit (rename, paste into, properties) catalog
                if ($authorizationChecker->isGranted('EDIT', $catalog) || $is_admin){ $flags .= 'nrps'; }
            }
            if ($output[strlen($output) - 1] != '['){ $output .= ','; }
            $output .= "{ \"id\":\"$id\",\"parent\":\"#\",\"text\":\"$title\",\"type\":\"$type\",\"flags\":\"$flags\"";
            $output .= " }";
        }
        $output .= ']}';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    // get the whole catalogs of user + global catalogs
    public function loadGlobalCatalogsAction(){
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $catalogs = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->findBy(array('global' => true));

        // transform array of orm entities into json
        // using this method as we need to replace NULL for "#" for parent values
        $output = '{"catalogs": [';
        foreach($catalogs as $catalog){
            if(!$authorizationChecker->isGranted('VIEW', $catalog) && !$catalog->getPublic() && !$authorizationChecker->isGranted('ROLE_ADMIN')){
                continue;
            }
                $id = $catalog->getId();
                $title = $catalog->getTitle();
                $type = 'catalog';
                $parent = '"#"';				// since jstree.js needs it this way for root nodes
                if ($output[strlen($output) - 1] != '['){ $output .= ','; }
                $output .= "{ \"id\": \"$id\", \"parent\": $parent, \"text\": \"$title\", \"type\": \"$type\"";
                $output .= " }";
        }

        if ($this->getUser() != null){
            $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($this->getUser()->getId());
            $catalogs = $user->getCatalogs();
            foreach($catalogs as $catalog){
            if(false == $authorizationChecker->isGranted('VIEW', $catalog) && !$catalog->getPublic()){
                continue;
            }
                $id = $catalog->getId();
                $title = $catalog->getTitle();
                $type = 'catalog';
                if ($catalog->getParent() == null){
                    // since jstree.js needs it this way for root nodes
                    $parent = '"#"';
                }
                else {
                        continue; // skip non-root catalogs here
                }
                if ($output[strlen($output) - 1] != '['){ $output .= ','; }
                $output .= "{ \"id\": \"$id\", \"parent\": $parent, \"text\": \"$title\", \"type\": \"$type\"";
                $output .= " }";
            }
        }

        $output .= ']}';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    // gets the specified catalog
    public function loadProjectCatalogAction($catid){
        $em = $this->getDoctrine()->getManager();
        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($catid);
        $authorizationChecker = $this->get('security.context');
        $is_admin = $authorizationChecker->isGranted('ROLE_ADMIN');

        // transform into json
        $output = '{"catalogs": [';
        if($authorizationChecker->isGranted('VIEW', $catalog) || $catalog->getPublic() || $is_admin){
            $id = $catalog->getId();
            $title = $catalog->getTitle();
            $type = 'catalog';
            $flags = '';
            if ($this->getUser() != null){
                // user can favorite this catalog : user is not its owner
                if (!$authorizationChecker->isGranted('OWNER', $catalog)){ $flags .= 'f'; }
                // user can edit (rename, paste into, properties) catalog
                if ($authorizationChecker->isGranted('EDIT', $catalog) || $is_admin){ $flags .= 'nrps'; }
            }
            if ($output[strlen($output) - 1] != '['){ $output .= ','; }
            $output .= "{ \"id\":\"$id\",\"parent\":\"#\",\"text\":\"$title\",\"type\":\"$type\",\"flags\":\"$flags\"";
            $output .= " }";
        }
        $output .= ']}';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    // gets only the data of the specified catalog
    public function loadCatalogDataAction($catid){
            $em = $this->getDoctrine()->getManager();
            $authorizationChecker = $this->get('security.context');
            $is_admin = $authorizationChecker->isGranted('ROLE_ADMIN');
            $_catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($catid);
            $catalogs = $_catalog->getChildren();

            // transform array of orm entities into json
            $output = '{"catalogs": [';
            foreach($catalogs as $catalog){
                if(!$authorizationChecker->isGranted('VIEW', $catalog) && !$catalog->getPublic() && !$is_admin){ continue; }
                $id = $catalog->getId();
                $title = $catalog->getTitle();
                $parent = $catid;
                $type = 'catalog';
                $flags = '';
                // now setting catalog access flags - only for authorized users
                if ($this->getUser() != null){
                    // user can favorite this catalog : user is not its owner
                    if (!$authorizationChecker->isGranted('OWNER', $catalog)){ $flags .= 'f'; }
                    // user can edit (rename, copy, cut, paste into, proterties) catalog
                    if ($authorizationChecker->isGranted('EDIT', $catalog) || $is_admin){ $flags .= 'nrmps'; }
                    // user can DELETE catalog
                    if ($authorizationChecker->isGranted('DELETE', $catalog) || $is_admin){ $flags .= 'd'; }
                    // user can UNLINK catalog
                    if ($catalog->getParent() != $catid && $authorizationChecker->isGranted('OWNER', $_catalog)){ $flags .= 'u'; }
                }
                if ($output[strlen($output) - 1] != '['){ $output .= ','; }
                $output .= "{\"id\":\"$id\",\"parent\":\"$parent\",\"text\":\"$title\",\"type\":\"$type\",\"flags\":\"$flags\"";
                $output .= "}";
            }
            $output .= '], "links": [';

            $links = $em->getRepository('OGIS\IndexBundle\Entity\Link')->findBy(array('catalog' => $_catalog->getId()));
            foreach($links as $link){
                $id = $link->getId();
                $target_entity_type = $link->getTargetType();
                $target_entity_title = $link->getTargetTitle();
                $target_entity_extra = $link->getExtraInfo();
                $params = explode('|', $target_entity_extra);
                if(isset($params[5])){
                    if($params[5] == 'raster'){ $target_entity_type = 'raster'; }
                    if($params[5] == 'line'){ $target_entity_type = 'line'; }
                    if($params[5] == 'point'){ $target_entity_type = 'point'; }
                    if($params[5] == 'polygon'){ $target_entity_type = 'polygon'; }
                }
                if ($output[strlen($output) - 1] != '['){ $output .= ','; }
                $flags = '';
                if ($this->getUser() != null){
                    if (!$authorizationChecker->isGranted('OWNER', $link)){ $flags .= 'f'; }
                    if ($authorizationChecker->isGranted('EDIT', $link) || $is_admin){ $flags .= 'rm'; }
                    if ($authorizationChecker->isGranted('DELETE', $link) || $is_admin){ $flags .= 'd'; }
                }
                if ($target_entity_type != 'external'){
                    $target_entity_id = $link->getTargetId();
                    $output .= "{\"id\":$id,\"parent\":\"$catid\",\"data\": $target_entity_id,\"text\":\"$target_entity_title\",\"type\":\"$target_entity_type\",\"flags\":\"$flags\",\"extra\":\"$target_entity_extra\"}";
                }
                else{
                     $target_entity_url = $link->getTargetUrl();
                    $output .= "{\"id\":$id,\"parent\":\"$catid\",\"data\":\"$target_entity_url\",\"text\":\"$target_entity_title\",\"type\":\"$target_entity_type\",\"flags\":\"$flags\",\"extra\":\"$target_entity_extra\"}";
                }

            }

            $output .= ']}';
            $response = new Response($output);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
    }

    // editor version
    public function loadCatalogDataEditorAction($catid){
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $_catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($catid);
        $catalogs = $_catalog->getChildren();

        // transform array of orm entities into json
        $output = '{"catalogs": [';
        foreach($catalogs as $catalog){
            if(false == $authorizationChecker->isGranted('VIEW', $catalog) && !$catalog->getPublic()){
                continue;
            }
            $id = $catalog->getId();
            $title = $catalog->getTitle();
            $type = 'catalog';
            $parent = $catid;
            if ($output[strlen($output) - 1] != '['){ $output .= ','; }
            $output .= "{ \"id\": \"$id\", \"parent\": \"$parent\", \"text\": \"$title\", \"type\": \"$type\"";
            $output .= " }";
        }
        $output .= '], "links": [';

        $links = $em->getRepository('OGIS\IndexBundle\Entity\Link')->findBy(array('catalog' => $_catalog->getId()));
        foreach($links as $link){
            $id = $link->getId();
            $target_entity_type = $link->getTargetType();
            $target_entity_title = $link->getTargetTitle();
            $target_entity_extra = $link->getExtraInfo();	
            if ($target_entity_type == 'layer'){
                if ($output[strlen($output) - 1] != '['){ $output .= ','; }
                $params = explode('|', $target_entity_extra);
                if(isset($params[5])){
                    if($params[5] == 'raster'){ $target_entity_type = 'raster'; }
                    if($params[5] == 'line'){ $target_entity_type = 'line'; }
                    if($params[5] == 'point'){ $target_entity_type = 'point'; }
                    if($params[5] == 'polygon'){ $target_entity_type = 'polygon'; }
                }
                $output .= "{\"id\":$id,\"parent\":\"$catid\",\"data\":\"$target_entity_extra\",\"text\":\"$target_entity_title\",\"type\":\"$target_entity_type\"}";
            }
            if ($target_entity_type == 'composition'){
                if ($output[strlen($output) - 1] != '['){ $output .= ','; }
                $tid = $link->getTargetId();
                $output .= "{\"id\":$id,\"parent\":\"$catid\",\"data\":$tid,\"text\":\"$target_entity_title\",\"type\":\"composition\"}";
            }
        }

        $output .= ']}';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }
    
    // gets styling options for layers
    public function stylingOptionsPageAction(){
        return $this->render('OGISIndexBundle:Lists:stylepalettelist.html.twig');
    }

    // creates or update a catalog based on the command send from profile page
    public function modifyCatalogAction(){
        if($this->getUser() == null){ 
            $i = '{"success":false, "message":"You don't have the permissions necessary to perform this action!"}';
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        $id = $_REQUEST['id'];
        $title = $_REQUEST['title'];
        $parent = $_REQUEST['parent'];
        $authorizationChecker = $this->get('security.context');
        $em = $this->getDoctrine()->getManager();
        if ($parent == null || $parent == ''){
            // we're modifying existing catalog
            $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($id);
            if (!$authorizationChecker->isGranted('EDIT', $catalog) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
                $i = '{"success":false, "message":"You don't have the permissions necessary to perform this action!"}';
                $response = new Response($i);
                $response->headers->set('Content-Type', 'application/json');
                $response->setCharset('UTF-8');
                return $response;
            }
            $catalog->setTitle($title);
            $em->persist($catalog);
            $em->flush();
            $i = '{"success":true, "message":"Catalog was successfully renamed!"}';
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        else{
            // we're creating a new catalog
            $parent_catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($parent);
            $catalog = new Catalog();
            $catalog->setId($id);
            $catalog->setTitle($title);
            $catalog->addOwner($this->getUser());
            $catalog->setParent($parent);

            $em->persist($catalog);
            $em->flush();

            // bind child to parent
            $parent_catalog->addChild($catalog);
            $em->persist($parent_catalog);
            $em->flush();

            // ACL
            $objectIdentity = ObjectIdentity::fromDomainObject($catalog);
            $aclProvider = $this->get('security.acl.provider');
            try{
                $acl = $aclProvider->findAcl($objectIdentity);
            }catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
                $acl = $aclProvider->createAcl($objectIdentity);
            }
            $securityIdentity = UserSecurityIdentity::fromAccount($this->getUser());
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);
            $i = '{"success":true, "message":"Catalog was successfully added to the database!", "id":"' . $catalog->getId() . '"}';
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
    }

    // modify a catalog
    public function editCatalogAction($id){
        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "You don't have the permissions necessary to perform this action!",
                'tip'     => "To gain the necessary permissions, try $login_link into O-GIS."
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($id);
        if(!$catalog){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Catalog not Found!",
                'message' => "The catalog you're looking for doesn't exist in the database."
            ));
        }
        if(!$authorizationChecker->isGranted('EDIT', $catalog) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied",
                'message' => "You don't have the permissions necessary to perform this action!",
                'tip'     => ""
            ));
        }

        // get all users that have 'VIEW' permission on this catalog
        $aclProvider = $this->get('security.acl.provider');
        $acl = $aclProvider->findAcl(ObjectIdentity::fromDomainObject($catalog));
        $aces = $acl->getObjectAces();
        $users = array();
        foreach($aces as $ace){
            if($ace->getMask() == 0){ continue; }
            $name = $ace->getSecurityIdentity()->getUsername();
            $query = $em->createQuery("SELECT u.id FROM OGIS\IndexBundle\Entity\User u WHERE u.username = '$name'");
            $id = $query->getSingleScalarResult();
            $user = (object)array('id' => $id, 'name' => $name);
            $users[] = $user;
        }

        return $this->render('OGISIndexBundle:Edit:editcatalogproperties.html.twig', array(
            'catalog' => $catalog,
            'users' => $users
        ));
    }

    // save changes to a catalog
    public function updateCatalogAction($id){
        $newtitle = $_POST['_title'];
        $public = $_POST['_public'];
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($id);
        if(!$authorizationChecker->isGranted('EDIT', $catalog) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->redirect($this->generateUrl('editcatalog', array(
                    'id' => $catalog->getId()
                )), 301);
        }
        $catalog->setTitle($newtitle);
        $catalog->setPublic($public);
        $em->persist($catalog);
        $em->flush();
        return $this->redirect($this->generateUrl('editcatalog', array(
                'id' => $catalog->getId()
            )), 301);
    }

    // unlinking a catalog from its fake parent
    protected function unlinkCatalog($id, $parent_id){
        $em = $this->getDoctrine()->getManager();
        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($id);
        if (!$catalog){ return '{"success": false, "message":"Target Catalog does not exist!"}'; }
        $parent = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($parent_id);
        if (!$parent){ return '{"success": false, "message":"Error while locating target catalog in the tree!"}'; }
        $parent->removeChild($catalog);
        $em->persist($parent);
        $em->persist($catalog);
        $em->flush();
        return '{"success":true, "message":"Catalog was deleted successfully!"}';
    }

    // recursive deleting of a catalog with everything inside it
    protected function recursiveCatalogDelete($id){
        $em = $this->getDoctrine()->getManager();
        $aclProvider = $this->get('security.acl.provider');
        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($id);
        $childCatalogs = $catalog->getChildren();
        foreach($childCatalogs as $child){
            if ($child->getParent() != $catalog){   // unlink
                $catalog->removeChild($child);
                $em->persist($child);
            }
            else{
                $i = self::recursiveCatalogDelete($child->getId());
            }
        }
        $links = $catalog->getLinks();
        foreach($links as $link){
            $catalog->removeLink($link);
            $objectIdentity = ObjectIdentity::fromDomainObject($link);
            $aclProvider->deleteAcl($objectIdentity);
            $em->remove($link);
        }
        $objectIdentity = ObjectIdentity::fromDomainObject($catalog);
        $aclProvider->deleteAcl($objectIdentity);
        $parent = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($catalog->getParent());
        $parent->removeChild($catalog);
        $em->persist($parent);
        $em->remove($catalog);
        $em->flush();
        return '{"success":true, "message":"Catalog and its contents were successfully deleted!"}';
    }

    // delete a catalog
    public function deleteCatalogAction($id){
        if ($this->getUser() == null){
            $i = '{"success":false, "message":"You don't have the permissions necessary to perform this action!"}';
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        if (isset($_REQUEST['parent'])){   // merely unlinking a catalog
            $_parent = $_REQUEST['parent'];
            $i = self::unlinkCatalog($id, $_parent);
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        else{
            $em = $this->getDoctrine()->getManager();
            $authorizationChecker = $this->get('security.context');
            $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($id);
            if (!$authorizationChecker->isGranted('DELETE', $catalog) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
                $i = '{"success":false, "message":"You don't have the permissions necessary to perform this action!"}';
                $response = new Response($i);
                $response->headers->set('Content-Type', 'application/json');
                $response->setCharset('UTF-8');
                return $response;
            }
            if ($catalog->getParent() == null){ 
                $i = '{"success":false, "message":"Impossible to delete root catalog!"}';
                $response = new Response($i);
                $response->headers->set('Content-Type', 'application/json');
                $response->setCharset('UTF-8');
                return $response;
            }
            $i = self::recursiveCatalogDelete($id);
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
    }

    // add something to favorites
    public function addToFavoriteAction(){
            if ($this->getUser() == null){
                $output = '{"success": false, "message": "You need to log in into O-GIS to add this to your favorites!"}';
                $response = new Response($output);
                $response->headers->set('Content-Type', 'application/json');
                $response->setCharset('UTF-8');
                return $response;
            }

            $objtype = $_REQUEST['type'];
            $objid = $_REQUEST['id'];
            $_parent = $_REQUEST['parent'];
            $em = $this->getDoctrine()->getManager();
            $parent = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($_parent);

            if (!$parent){
                $output = '{"success": false, "message": "Catalog not found!"}';
                $response = new Response($output);
                $response->headers->set('Content-Type', 'application/json');
                $response->setCharset('UTF-8');
                return $response;
            }
            if ($objtype == 'catalog'){
                $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($objid);
                if (!$catalog){
                    $output = '{"success": false, "message": "Target catalog not found!"}';
                    $response = new Response($output);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setCharset('UTF-8');
                    return $response;
                }
                $parent->addChild($catalog);
                $em->persist($parent);		
                $em->flush();
            }
            else{
                $entitytype = ucwords($objtype);
                $obj = $em->getRepository("OGIS\IndexBundle\Entity\\$entitytype")->find($objid);
                if(!$obj){
                    $output = '{"success": false, "message": "Target $entitytpe not found!"}';
                    $response = new Response($output);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setCharset('UTF-8');
                    return $response;
                }
                $link = new Link();
                if ($objtype == 'link'){
                    $link->setTargetTitle($obj->getTargetTitle());
                    $link->setTargetType('external');
                    $link->setTargetUrl($obj->getTargetUrl());
                }
                elseif ($objtype == 'user'){
                    $link->setTargetTitle($obj->getDisplayName());
                    $link->setTargetType($objtype);
                    $link->setTargetId($obj->getId());
                }
                else{
                    $link->setTargetTitle($obj->getName());
                    $link->setTargetType($objtype);
                    $link->setTargetId($obj->getId());
                }
                $link->setCatalog($parent);
                if($objtype == 'layer'){
                    $ws = $obj->getWorkspace();
                    $cs =  $obj->getConString();
                    $min = $obj->getMinvalue();
                    $max = $obj->getMaxvalue();
                    $nodata = $obj->getNodatavalue();
                    $proj = $obj->getProjection();
                    $type = $obj->getType();
                    $info = "$ws:$cs|$min|$max|$nodata|$proj|$type";
                    $link->setExtraInfo($info);
                }
                elseif($objtype == 'style'){
                    $name = $obj->getInternalName();
                    $link->setExtraInfo($name);
                }
                else{
                    $link->setExtraInfo("");
                }
                $em->persist($link);		
                $em->flush();

                // ACL
                $objectIdentity = ObjectIdentity::fromDomainObject($link);
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
            }
        $output = '{"success": true, "message": "Добавлено в избранное", "id":' . $link->getId() . '}';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }
    
    // renames existing link
    public function modifyLinkAction(){
        if ($this->getUser() == null){ 
            $i = '{"success":false, "message":"You do not have permissions necessary to perform this action!"}';
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        $id = $_REQUEST['id'];
        $newtitle = $_REQUEST['title'];
        $em = $this->getDoctrine()->getManager();
        $link = $em->getRepository('OGIS\IndexBundle\Entity\Link')->find($id);
        $authorizationChecker = $this->get('security.context');
        if(!$authorizationChecker->isGranted('EDIT', $link) && !$authorizationChecker->isGranted('ROLE_ADMIN')){ 
            $i = '{"success":false, "message":"You do not have permissions necessary to perform this action!"}';
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        $link->setTargetTitle($newtitle);
        $em->persist($link);
        $em->flush();
        $i = '{"success":true, "message":"Success!"}';
        $response = new Response($i);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    // change entity's parent
    public function changeParentAction(){
        if ($this->getUser() == null){
                $i = '{"success":false, "message":"You do not have permissions necessary to perform this action!"}';
                $response = new Response($i);
                $response->headers->set('Content-Type', 'application/json');
                $response->setCharset('UTF-8');
                return $response;
            }
        $newparent = $_REQUEST['_to'];
        $oldparent = $_REQUEST['_from'];
        $nodeid = $_REQUEST['id'];
        $nodetype = $_REQUEST['type'];
        if ($newparent == $oldparent || $nodeid == $newparent){
            $output = '{"success": false, "message": "Operation canceled as no changed would have been made!"}';
            $response = new Response($output);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        $em = $this->getDoctrine()->getManager();
        $parent_new = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($newparent);
        $parent_old = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($oldparent);
        if ($nodetype == 'catalog'){
            $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($nodeid);
            if ($oldparent == $catalog->getParent()){
                $catalog->setParent($newparent);
            }
            $parent_old->removeChild($catalog);
            $parent_new->addChild($catalog);
            $em->persist($catalog);
            $em->persist($parent_new);
            $em->persist($parent_old);
            $em->flush();
        }
        else{
            $link = $em->getRepository('OGIS\IndexBundle\Entity\Link')->find($nodeid);
            $parent_new->addLink($link);
            $parent_old->removeLink($link);
            $link->setCatalog($parent_new);
            $em->persist($link);
            $em->persist($parent_new);
            $em->persist($parent_old);
            $em->flush();
        }
        $output = '{"success": true, "message": "Moved!"}';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    // remove something from favorites
    public function removeFavoriteAction($id){
            if ($this->getUser() == null){ 
                $i = '{"success":false, "message":"You do not have permissions necessary to perform this action!"}';
                $response = new Response($i);
                $response->headers->set('Content-Type', 'application/json');
                $response->setCharset('UTF-8');
                return $response;
            }
            $em = $this->getDoctrine()->getManager();
            $link = $em->getRepository('OGIS\IndexBundle\Entity\Link')->find($id);
            $authorizationChecker = $this->get('security.context');
            if (!$authorizationChecker->isGranted('DELETE', $link) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
                $i = '{"success":false, "message":"You do not have permissions necessary to perform this action!"}';
                $response = new Response($i);
                $response->headers->set('Content-Type', 'application/json');
                $response->setCharset('UTF-8');
                return $response;
            }
            $link->getCatalog()->removeLink($link);

            // remove ACL of the link
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($link);
            $aclProvider->deleteAcl($objectIdentity);

            $em->remove($link);
            $em->flush();
            $i = '{"success":true, "message":"Successfully removed from your favorites!"}';
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
    }

    // modify acl of a catalog
    public function updateAclAction($id){
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($id);
        if (!$authorizationChecker->isGranted('EDIT', $catalog)){
            $msg = "{'success': false, 'message': \"You do not have permissions necessary to perform this action!\"}";
        }
        else{
            $useridentity = $_REQUEST['_user'];
            $action = $_REQUEST['_action'];
            if (is_numeric($useridentity)){ $identitytype = 'id'; }
            else if (filter_var($useridentity, FILTER_VALIDATE_EMAIL)){ $identitytype = 'email'; }
            else { $identitytype = 'username'; }
            $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->findOneBy(array($identitytype => $useridentity));
            if (!$user){
                $msg = "{\"success\": false, \"message\": \"User not found!\"}";
            }
            else{
                $aclProvider = $this->get('security.acl.provider');
                $name = $user->getDisplayname();
                $acl = $aclProvider->findAcl(ObjectIdentity::fromDomainObject($catalog));
                if ($action == 'remove'){
                    $aces = $acl->getObjectAces();
                    foreach ($aces as $index => $ace){
                        $identity = $ace->getSecurityIdentity()->getUsername();
                        if ($identity == $user->getUsername()){
                            $acl->deleteObjectAce($index);
                            $aclProvider->updateAcl($acl);
                            $msg = "{\"success\": true, \"added\": false, \"message\": \"User $name can no longer view this catalog!\"}";
                            break;
                        }
                    }
                }
                if($action == 'add'){
                    $aces = $acl->getObjectAces();
                    $isgranted = false;
                    foreach ($aces as $index => $ace){
                        $identity = $ace->getSecurityIdentity()->getUsername();
                        if ($identity == $user->getUsername()){
                            $msg = "{\"success\": false, \"message\": \"User $name already can view this catalog!\"}";
                            $isgranted = true;
                            break;
                        }
                    }
                    if(!$isgranted){
                        $securityIdentity = UserSecurityIdentity::fromAccount($user);
                        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_VIEW);
                        $aclProvider->updateAcl($acl);
                        $id = $user->getId();
                        $msg = "{\"success\": true, \"added\": true, \"message\": \"User $name now can view this catalog!\", \"id\": $id, \"name\": \"$name\"}";
                    }
                }
            }
        }
        $response = new Response($msg);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

}
