<?php

namespace OGIS\IndexBundle\Controller;

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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use OGIS\IndexBundle\Entity\Project;
use OGIS\IndexBundle\Entity\ProjectParticipation;
use OGIS\IndexBundle\Entity\Catalog;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class ProjectController extends Controller {

    // create project page
    public function createProjectAction(){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        return $this->render('OGISIndexBundle:Create:createproject.html.twig');
    }

    // creating project...
    public function generateProjectAction(){
        $projectname = $_POST['_projectname'];
        $projectdescription = $_POST['_projectdescription'];

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($this->getUser()->getId());
        // generate a catalog for the project
        $catalog = new Catalog();
        $catalog->setTitle($projectname . ' resources');
        $catalog->addOwner($user);
        $catalog->setProject(true);
        $catalog->setParent(null);
        $em->persist($catalog);
        $em->flush();

        // ACL for project's catalog
        $objectIdentity = ObjectIdentity::fromDomainObject($catalog);
        $aclProvider = $this->get('security.acl.provider');
        try{
            $acl = $aclProvider->findAcl($objectIdentity);
        }catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
            $acl = $aclProvider->createAcl($objectIdentity);
        }
        $securityIdentity = UserSecurityIdentity::fromAccount($user);
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);

        // create project
        $project = new Project();
        $project->setName($projectname);
        $project->setDescription($projectdescription);
        $project->setCreated(new \DateTime("now"));
        $project->setModified(new \DateTime("now"));
        $project->setPublicviewable(true);
        $project->setPublicjoinable(true);
        $project->setCatalog($catalog->getId());
        $em->persist($project);
        $em->flush();

        // add user participation in the project
        $participation = new ProjectParticipation();
        $participation->setUser($user);
        $participation->setProject($project);
        $participation->setRank('Founder');
        $em->persist($participation);
        $em->flush();

        // ACL for project
        $projectIdentity = ObjectIdentity::fromDomainObject($project);
        try{
            $acl = $aclProvider->findAcl($projectIdentity);
        }catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
            $acl = $aclProvider->createAcl($projectIdentity);
        }
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);

        $id = $project->getId();

        return $this->redirect($this->generateUrl('generate_success', array('projectid' => $id)), 301);
    }

    // project successfully created
    public function generateProjectCompleteAction($projectid){
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('OGIS\IndexBundle\Entity\Project')->find($projectid);
        $projectname = $project->getName();
        return $this->render('OGISIndexBundle:Create:projectcreationsuccess.html.twig', array(
                'caption' => "Success!",
                'message' => "Project \"$projectname\" was successfully created!",
                'project' => $project->getId()
        ));
    }

    // show project's page
    public function showProjectAction($id){
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('OGIS\IndexBundle\Entity\Project')->find($id);
        if(!$project){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Project not found!",
                'message' => "The requested project doesn't exist in the database."
            ));
        }
        if(!$project->getPublicviewable()){
            if($this->getUser() == null){
                $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
                return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                    'caption' => "Access denied!",
                    'message' => "You don't have the permission necessary to access this page!",
                    'tip'     => "To get the necessary permission, try $login_link into O-GIS."
                ));
            }
            if($this->getUser()->getId() == $project->getAuthor()->getId() && !$this->get('security.context')->isGranted('ROLE_ADMIN')){
                return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                    'caption' => "Access denied!",
                    'message' => "You don't have the permissions necessary to access this page!",
                    'tip'     => "This project is private; only its participants can view the project's page."
                ));
            }
        }
        return $this->render('OGISIndexBundle:Objects:project.html.twig', array('project' => $project));
    }

    // a project's properties edit page
    public function editProjectPropertiesAction($id){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $project = $em->getRepository('OGIS\IndexBundle\Entity\Project')->find($id);
        if(!$project){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Project not found!",
                'message' => "The requested project doesn't exist in the database."
            ));
        }
        if(!$authorizationChecker->isGranted('EDIT', $project) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permissions necessary to access this page!",
                'tip'     => ""
            ));                    
        }
        return $this->render('OGISIndexBundle:Edit:editprojectproperties.html.twig', array('project' => $project));
    }

    // save the modified project properties
    public function saveProjectPropertiesAction($id){
        $rawdata = file_get_contents('php://input');
        $rawdata = substr($rawdata, strpos($rawdata, '_'));
        $params = array();
        parse_str($rawdata, $params);
        
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $em = $this->getDoctrine()->getManager();               
        $authorizationChecker = $this->get('security.context');
        $project = $em->getRepository('OGIS\IndexBundle\Entity\Project')->find($id);
        
        if(!$project){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Project not found!",
                'message' => "The requested project doesn't exist in the database."
            ));
        }
        
        if(!$authorizationChecker->isGranted('EDIT', $project) && !$this->get('security.context')->isGranted('ROLE_ADMIN')){
                return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                        'caption' => "Access denied!",
                        'message' => "You don't have the permission necessary to access this page!",
                        'tip'     => ""
                ));
        }

        $project->setName($params['_projectname']);
        $project->setDescription($params['_projectdescription']);
        $project->setPublicviewable($params['_publicviewable']);
        $project->setPublicjoinable($params['_publicjoinable']);
        $project->setModified(new \DateTime("now"));

        $em->persist($project);
        $em->flush();
        
        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($project->getCatalog());
        $catalog->setTitle($params['_projectname'] . ' resources');
        $em->persist($catalog);
        $em->flush();

        $id = $project->getId();
        return $this->redirect($this->generateUrl('edit_project_properties', array('id' => $id)), 301);
    }

    // a project's membership edit page
    public function editProjectMembersAction($id){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $project = $em->getRepository('OGIS\IndexBundle\Entity\Project')->find($id);
        if(!$project){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Project not found!",
                'message' => "The requested project doesn't exist in the database."
            ));
        }
        if(!$authorizationChecker->isGranted('EDIT', $project) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => ""
            ));                    
        }

        return $this->render('OGISIndexBundle:Edit:editprojectmembers.html.twig', array('project' => $project));
    }

    // add a new member to the project
    public function addProjectMembersAction(){
        $_project = $_REQUEST['project'];
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $project = $em->getRepository('OGIS\IndexBundle\Entity\Project')->find($_project);
        if (!$project){
            $msg = '{"success": false, "message": "Project not found!"}';
        }
        else{
            if (!$authorizationChecker->isGranted('EDIT', $project) && !$authorizationChecker->isGranted('ROLE_ADMIN') && !$project->getPublicjoinable()){
                $msg = '{"success": false, "message": "You don\'t have the permissions necessary to perform this action!"}';
            }
            else{
                $_user = $_REQUEST['user'];
                if (is_numeric($_user)){ $identitytype = 'id'; }
                else if (filter_var($_user, FILTER_VALIDATE_EMAIL)){ $identitytype = 'email'; }
                else { $identitytype = 'username'; }
                $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->findOneBy(array($identitytype => $_user));
                if (!$user){
                    $msg = '{"success": false, "message": "User not found!"}';
                }
                else{
                    $is_member = false;
                    $projects = $user->getProjects();
                    foreach ($projects as $proj){
                        if ($proj->getProject()->getId() == $project->getId()){
                            $is_member = true;
                            $msg = '{"success": false, "message": "This user is a member of this project already!"}';
                            break;
                        }
                    }
                    if(!$is_member){
                        // add user participation in the project
                        $participation = new ProjectParticipation();
                        $participation->setUser($user);
                        $participation->setProject($project);
                        $participation->setRank('Project member');
                        $em->persist($participation);
                        $em->flush();

                        $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($project->getCatalog());
                        $catalog->addOwner($user);
                        $em->persist($catalog);
                        $em->flush();

                        // ACL for project
                        $projectIdentity = ObjectIdentity::fromDomainObject($project);
                        $aclProvider = $this->get('security.acl.provider');
                        try{
                            $acl = $aclProvider->findAcl($projectIdentity);
                        }catch (AclNotFoundException $e) {
                            $acl = $aclProvider->createAcl($projectIdentity);
                        }
                        $securityIdentity = UserSecurityIdentity::fromAccount($user);
                        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_VIEW);
                        $aclProvider->updateAcl($acl);
                        $id = $user->getId();
                        $name = $user->getDisplayname();
                        $msg = '{"success": true, "message": "User ' . $name . ' was given a membership in this project", "id": ' . $id . ', "name": "' . $name . '"}';
                    }
                }
            }
        }
        $response = new Response($msg);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    // removes a user from the project
    public function removeProjectMembersAction(){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $_project = $_REQUEST['project'];
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $project = $em->getRepository('OGIS\IndexBundle\Entity\Project')->find($_project);
        if (!$project){
            $msg = '{"success": false, "message": "Project not found!"}';
        }
        else{            
            $_user = $_REQUEST['user'];
            $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($_user);
            if (!$user){
                $msg = '{"success": false, "message": "User not found!"}';
            }
            else{
                if (!$authorizationChecker->isGranted('EDIT', $project) && !$authorizationChecker->isGranted('ROLE_ADMIN') && $user->getId() != $this->getUser()->getId()){
                    $msg = '{"success": false, "message": "You don\'t have the permissions necessary to perform this action!"}';
                }
                else{
                    $catalog = $em->getRepository('OGIS\IndexBundle\Entity\Catalog')->find($project->getCatalog());
                    $participations = $user->getProjects();
                    foreach ($participations as $participation){
                        if ($participation->getProject()->getId() == $project->getId()){
                            $em->remove($participation);
                            $em->flush();
                            break;
                        }
                    }
                    $catalog->removeOwner($user);
                    $em->persist($catalog);
                    $em->flush();
                    $name = $user->getDisplayname();
                    $msg = "{\"success\": true, \"message\": \"User $name was kicked out of the project!\"}";
                }
            }
        }
        $response = new Response($msg);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    // changes user's rank within the project
    public  function changeProjectMembersRankAction(){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $_project = $_REQUEST['project'];
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $project = $em->getRepository('OGIS\IndexBundle\Entity\Project')->find($_project);
        if (!$project){
            $msg = '{"success": false, "message": "Project not found!"}';
        }
        else{
            if (!$authorizationChecker->isGranted('EDIT', $project) && !$authorizationChecker->isGranted('ROLE_ADMIN')){
                $msg = '{"success": false, "message": "You don\'t have the permission necessary to perform this action!"}';
            }
            else{
                $_user = $_REQUEST['user'];
                $_action = $_REQUEST['action'];
                $newrank = ($_action == 'promote') ? 'Administrator' : 'Project member';
                $mask = ($_action == 'promote') ? MaskBuilder::MASK_EDIT : MaskBuilder::MASK_VIEW;
                $members = $project->getParticipants();
                foreach($members as $member){
                    if ($member->getUser()->getId() == $_user){
                        $member->setRank($newrank);
                        $em->persist($member);
                        $em->flush();
                        
                        // ACL
                        $projectIdentity = ObjectIdentity::fromDomainObject($project);
                        $securityIdentity = UserSecurityIdentity::fromAccount($member->getUser());
                        $aclProvider = $this->get('security.acl.provider');
                        $acl = $aclProvider->findAcl($projectIdentity, array($securityIdentity));
                        foreach($acl->getObjectAces() as $index => $ace) {
                            if($ace->getSecurityIdentity()->equals($securityIdentity)) {
                                $acl->updateObjectAce($index, $mask);
                            }
                        }
                        $aclProvider->updateAcl($acl);
                        
                        $id = $member->getUser()->getId();
                        $name = $member->getUser()->getDisplayname();
                        $msg = '{"success": true, "message": "User\'s rank was successfully changed!", "id": ' . $id . ', "name": "' . $name . '"}';
                        break;
                    }
                }
            }
        }
        $response = new Response($msg);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

	public function deleteProjectConfirmAction($id){
        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
               'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('OGIS\IndexBundle\Entity\Project')->find($id);
        if(!$project){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Project not found!",
                'message' => "The requested project doesn't exist in the database."
            ));
        }
        $this_user = $this->getUser()->getId();
        $users = $project->getParticipants();
        $is_proj_admin = false;
        foreach ($users as $user){
            if ($user->getUser()->getId() == $this_user && ($user->getRank() == 'Основатель' || $user->getRank() == 'Администратор')){
                $is_proj_admin = true; break;
            }
        }
        $is_site_admin = $this->get('security.context')->isGranted('ROLE_ADMIN');
        if(!$is_proj_admin && !$is_site_admin){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "You don't have the permission necessary to perform this action!",
                'message' => "You don't have the permission necessary to perform this action!",
                'tip'     => ""
            ));
        }
        return $this->render('OGISIndexBundle:Delete:deleteconfirmation.html.twig', array(
            'entitytype' => "project",
            'entitytype_en' => "project",
            'entitytype_rp' => "project",
            'entityname' => $project->getName(),
            'entityid' => $project->getId()
        ));
	}

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
        $em->remove($catalog);
        $em->flush();
    }
        
    public function deleteProjectAction($id){
        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You don't have the permission necessary to access this page!",
                'tip'     => "To get the necessary permission, try $login_link into O-GIS."
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('OGIS\IndexBundle\Entity\Project')->find($id);
        $projectname = $project->getName();
        if(!$project){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Project not found!",
                'message' => "The requested project doesn't exist in the database."
            ));
        }
        $this_user = $this->getUser()->getId();
        $users = $project->getParticipants();
        $is_proj_admin = false;
        foreach ($users as $user){
            if ($user->getUser()->getId() == $this_user && ($user->getRank() == 'Основатель' || $user->getRank() == 'Администратор')){
                $is_proj_admin = true; break;
            }
        }
        $is_site_admin = $this->get('security.context')->isGranted('ROLE_ADMIN');
        if(!$is_proj_admin && !$is_site_admin){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "You don't have the permission necessary to perform this action!",
                'message' => "You don't have the permission necessary to perform this action!",
                'tip'     => ""
            ));
        }
        // remove users
        $query = $em->createQuery("DELETE from OGISIndexBundle:ProjectParticipation p where p.project = " . $project->getId());
        $query->getResult();
        // remove catalog
        $cat_id = $project->getCatalog();
        var_dump($cat_id);
        self::recursiveCatalogDelete($cat_id);
        // remove ACL for project
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($project);
        $aclProvider->deleteAcl($objectIdentity);
        // remove project
        $em->remove($project);
        $em->flush();

        return $this->redirect($this->generateUrl('deleteprojectdone', array('projectname' => $projectname)), 301);
    }

    public function deleteProjectSuccessAction($projectname){
        return $this->render('OGISIndexBundle:Delete:deletesuccess.html.twig', array(
            'caption' => "Project deletion successful",
            'message' => "Your project \"$projectname\" was successfully deleted."
        ));
    }

}
