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
use Symfony\Component\HttpFoundation\Request;
use OGIS\IndexBundle\Entity\News;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AuthManagerController extends Controller {

    // logging in from the editor
    public function loginFromEditorAction(Request $request){
        $username = $_REQUEST['username'];
        $pass_plain = base64_decode($_REQUEST['password']);
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->findOneBy(array('username' => $username));
        if (!$user){
            return new Response("Error: Authentification error!", 200);
        }
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        $pass_enc = $encoder->encodePassword($pass_plain, $user->getSalt());
        if ($pass_enc == $user->getPassword()){

            $role = $user->getRoles();
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $role);
            $this->get("security.context")->setToken($token);
            $request = $this->getRequest();
            $session = $request->getSession();
            $session->set('_security_main',  serialize($token));
            $session_id = $session->getId();
            
            $cmp = $_REQUEST['composition'];
            $overwrite = 0;
            if ($cmp != 'null' && $cmp != 'undefined'){
                $composition = $em->getRepository('OGIS\IndexBundle\Entity\Composition')->find($cmp);
                $authorizationChecker = $this->get('security.context');                
                $found = false;
                if ($authorizationChecker->isGranted('EDIT', $composition)){ $overwrite = 1; $found = true; }
                $cmp_projects = $composition->getCompositionsProjects();
                $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($this->getUser()->getId());
                $usr_projects = $user->getUsersProjects();
                if (!found){
                    foreach($cmp_projects as $prj){
                        foreach($usr_projects as $p){
                            if ($p->getId() == $prj->getId()){
                                $found = true;
                                $overwrite = 1;
                                break;
                            }
                        }
                        if ($found){ break; }
                    }
                }
            }
            
            $id = $user->getId();
            $name = $user->getDisplayname();
            $limit = $user->getLimits()->getLayers() - count($user->getLayers());
            $output = "{ \"id\": $id, \"name\": \"$name\", \"session\": \"$session_id\", \"overwrite\": $overwrite, \"limit\": $limit }";
            $response = new Response($output);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        return new Response("Error: Authentification error!", 200);
    }

    // login page
    public function loginFromSiteAction(){
        $referer = $this->getRequest()->headers->get('referer');
        if ($this->getUser() != null){
            if (preg_match('/o-gis\.org/', $referer)){
                return $this->redirect($referer, 302);
            }
            else{
                return $this->redirect($this->generateUrl('homepage'), 302);
            }
        }
        return $this->render('OGISIndexBundle:AuthManager:login.html.twig', array(
            'message' => null,
            'username' => '',
            'login_target' => $referer
        ));
    }

    // validating login input
    public function credentialsCheckForLoginAction(Request $request){
        $username = $_REQUEST['username'];
        $pass_plain = $_REQUEST['password'];
        $referer = $_REQUEST['login_target'];
//        $remember = $_REQUEST['rememberme'];
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->findOneBy(array('username' => $username));
        if (!$user){
            return $this->render('OGISIndexBundle:AuthManager:login.html.twig', array(
                'message' => 'Erroneous login or password!',
                'username' => $username,
                'login_target' => $referer
            ));
        }
        
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        $pass_enc = $encoder->encodePassword($pass_plain, $user->getSalt());
        
        if($pass_enc != $user->getPassword()){
            return $this->render('OGISIndexBundle:AuthManager:login.html.twig', array(
                'message' => 'Erroneous login or password!',
                'username' => $username,
                'login_target' => $referer
            ));
        }
        
        $role = $user->getRoles();
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $role);
        $this->get("security.context")->setToken($token);
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->set('_security_main',  serialize($token));
//        if ($remember == true || $remember == 'on'){
//            $session->set('cookie_lifetime', 360000);
//            session_set_cookie_params(360000);
//        }
        
        if (preg_match('/o-gis\.org/', $referer)){
            return $this->redirect($referer, 302);
        }
        else{
            return $this->redirect($this->generateUrl('homepage'), 302);
        }
    }

    // admin-only accessible page | test for posting news
    // TODO: replace with a proper news-management, either through dashboard or via proper admin interface
    public function adminOnlyAction(){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "This page is unavailable for unauthorized users!",
                'tip'     => "To gain access to this page try $login_link into O-GIS."
            ));
        }
        if(!$this->get('security.context')->isGranted('ROLE_MODERATOR')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "You don't have the permissions necessary to view this page!",
                'tip'     => ""
            ));
        }
      	if ($_POST['_title'] == null){
	        	return $this->render('OGISIndexBundle:AuthManager:adminonly.html.twig');
	      }
	      else{
	        	$em = $this->getDoctrine()->getManager();
	        	$news = new News();
	        	$news->setTitle($_POST['_title']);
	        	$news->setText($_POST['_body']);
	        	$news->setAuthor($this->getUser());
	        	$news->setPosted(new \DateTime("now"));
	        	$em->persist($news);
	        	$em->flush();
	        	return new response('POSTED!', 200);
	      }
    }

    // logged-in-user-only accessible page | depricated
    public function userOnlyAction(){
        if($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('login') . "\">logging in</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "This page is unavailable for unauthorized users!",
                'tip'     => "To gain access to this page try $login_link into O-GIS."
            ));
        }
        return $this->render('OGISIndexBundle:AuthManager:useronly.html.twig');
    }

}
