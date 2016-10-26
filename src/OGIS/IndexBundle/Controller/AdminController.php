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
use OGIS\IndexBundle\Entity\News;

class AdminController extends Controller{
    
    public function geoserverPageAction(){
        $authorizationChecker = $this->get('security.context');
        $is_admin = $authorizationChecker->isGranted('ROLE_ADMIN');

        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">authorizing</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Unauthorized users can't access this page!",
                'tip'     => "To gain access to this page try $login_link in O-GIS."
            ));
        }
        if (!$is_admin){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Only O-GIS administrators can access this page!",
                'tip'     => ""
            ));
        }
        return $this->render('OGISIndexBundle:Admin:geoserver.html.twig');
    }
    
    
    public function geoserverRestartAction(){
        $authorizationChecker = $this->get('security.context');
        $is_admin = $authorizationChecker->isGranted('ROLE_ADMIN');

       if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">authorizing</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Unauthorized users can't access this page!",
                'tip'     => "To gain access to this page try $login_link in O-GIS."
            ));
        }
        if (!$is_admin){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Only O-GIS administrators can access this page!",
                'tip'     => ""
            ));
        }
        
        $pass = 'avyqtkjndcsn';
        $command = 'echo ' . $pass . ' | sudo -S service tomcat7 restart';
        $i = exec($command);
        $i = ($i == '' || $i == null) ? '* Restarting Tomcat servlet engine tomcat7    [ OK ]' : $i;
        $output = '{"message":"' . $i . '"}';
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }
     
    public function newsListAction(){
        $authorizationChecker = $this->get('security.context');
        $is_admin = $authorizationChecker->isGranted('ROLE_ADMIN');

        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">authorizing</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Unauthorized users can't access this page!",
                'tip'     => "To gain access to this page try $login_link in O-GIS."
            ));
        }
        if (!$is_admin){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Only O-GIS administrators can access this page!",
                'tip'     => ""
            ));
        }
        
        return $this->render('OGISIndexBundle:Admin:newslist.html.twig');        
    }
     
    public function getNewsListAction(){
         // sorting params : ordering ~ id, name, ...
        if (isset($_REQUEST['ordering'])){ $ordering = $_REQUEST['ordering']; }
        else{ $ordering = 'id'; }
        // sorting params : order ~ ASC, DESC
        if (isset($_REQUEST['order'])){ $order = $_REQUEST['order']; }
        else{ $order = 'ASC'; }
        // sorting params : page ~ 1 -> ...
        if (isset($_REQUEST['page'])){ $page = $_REQUEST['page']; }
        else{ $page = 1; }
        
        // getting results
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(n) FROM OGIS\IndexBundle\Entity\News n');
        $newscount = $query->getSingleScalarResult();
        $totalpages = ceil($newscount / 20);
        if ($page > $totalpages){ $page = $totalpages; }
        if ($page < 1){ $page = 1; }
        $skip = ($page - 1) * 20;
        
        $nquery = $em->createQuery("SELECT n FROM OGIS\IndexBundle\Entity\News n ORDER BY n.$ordering $order")->setFirstResult($skip)->setMaxResults(20);
        $news = $nquery->getResult();
        
        $output = "{\"cpage\":$page,\"tpages\":$totalpages,\"news\":[";
        foreach ($news as $n){
            if ($output[strlen($output) - 1] != '['){ $output .= ','; }
            $id = $n->getId();
            $name = $n->getTitle();
            $author_name = $n->getAuthor()->getUsername();
            $author_id = $n->getAuthor()->getId();
            $posted = date_format($n->getPosted(),'d-m-Y');
            $output .= "{\"id\":$id,\"name\":\"$name\",\"posted\":\"$posted\",\"author\":{\"id\":$author_id,\"name\":\"$author_name\"}}";
        }
        $output .= ']}';
        
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }

    public function editNewsAction($id){
        $authorizationChecker = $this->get('security.context');
        $is_admin = $authorizationChecker->isGranted('ROLE_ADMIN');
        $success = $_REQUEST['success'];
        $success = ($success == 'true') ? true : false;

        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">authorizing</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Unauthorized users can't access this page!",
                'tip'     => "To gain access to this page try $login_link in O-GIS."
            ));
        }
        if (!$is_admin){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Only O-GIS administrators can access this page!",
                'tip'     => ""
            ));
        }
        
        if ($id == null){ $news = null; }
        else{
            $em = $this->getDoctrine()->getManager();
            $news = $em->getRepository('OGIS\IndexBundle\Entity\News')->find($id);
            if (!$news){ $news = null; }
        }
        
        return $this->render('OGISIndexBundle:Admin:editnews.html.twig', array('news' => $news, 'success' => $success));        
    }

    public function saveNewsAction($id){
        $authorizationChecker = $this->get('security.context');
        $is_admin = $authorizationChecker->isGranted('ROLE_ADMIN');

        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">authorizing</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Unauthorized users can't access this page!",
                'tip'     => "To gain access to this page try $login_link in O-GIS."
            ));
        }
        if (!$is_admin){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Only O-GIS administrators can access this page!",
                'tip'     => ""
            ));
        }
        
        $title = $_REQUEST['_title'];
        $text = $_REQUEST['_text'];
        $em = $this->getDoctrine()->getManager();
        // new news
        if ($id == null){
            $news = new News();
            $news->setAuthor($this->getUser());
            $news->setPosted(new \DateTime("now"));
            $news->setTitle($title);
            $news->setText($text);
            
            $em->persist($news);
            $em->flush();
            $news_id = $news->getId();
            
            return $this->redirect($this->generateUrl('admineditnews', array('id' => $news_id)) . '?success=true', 301);
        }
        // updating old one
        else{
            $news = $em->getRepository('OGIS\IndexBundle\Entity\News')->find($id);
            $news->setTitle($title);
            $news->setText($text);
            
            $em->persist($news);
            $em->flush();
            
            return $this->redirect($this->generateUrl('admineditnews', array('id' => $id)) . '?success=true', 301);
        }
    }

    public function deleteNewsAction($id){
        $authorizationChecker = $this->get('security.context');
        $is_admin = $authorizationChecker->isGranted('ROLE_ADMIN');

        if ($this->getUser() == null){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">authorizing</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Unauthorized users can't access this page!",
                'tip'     => "To gain access to this page try $login_link in O-GIS."
            ));
        }
        if (!$is_admin){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access Denied!",
                'message' => "Only O-GIS administrators can access this page!",
                'tip'     => ""
            ));
        }
        
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('OGIS\IndexBundle\Entity\News')->find($id);
        if (!$news){ return $this->redirect($this->generateUrl('adminnewslist', 301)); }
        $em->remove($news);
        $em->flush();
        return $this->redirect($this->generateUrl('adminnewslist', 301));
    }
}
