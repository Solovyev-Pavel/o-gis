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

class UserController extends Controller {

    public function showUserAction($id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($id);
        if (!$user){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "User not found!",
                'message' => "The requested user doesn't exist in the database."
            ));
        }
        else{
            return $this->render('OGISIndexBundle:Objects:user.html.twig', array('user' => $user));
        }
    }

    public function showUserRoleAction($id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($id);
        var_dump($user->getRoles());
        return new response("!", 200);
    }

    public function userListAction(){
        return $this->render('OGISIndexBundle:Lists:userlist.html.twig');
    }
    
    public function userListItemsAction(){
        // sorting params : ordering ~ id, name, ...
        if (isset($_REQUEST['ordering'])){ $ordering = $_REQUEST['ordering']; }
        else{ $ordering = 'id'; }
        // sorting params : order ~ ASC, DESC
        if (isset($_REQUEST['order'])){ $order = $_REQUEST['order']; }
        else{ $order = 'ASC'; }
        // sorting params : group ~ all, users, moderators, admins
        // numerics for groups:     1-5, 4-5,   1-3,        1-2
        if (isset($_REQUEST['group'])){ $group = $_REQUEST['group']; }
        else{ $group = '1,2,3,4,5'; }
        // sorting params : page ~ 1 -> ...
        if (isset($_REQUEST['page'])){ $page = $_REQUEST['page']; }
        else{ $page = 1; }
        
        // getting results
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(u) FROM OGIS\IndexBundle\Entity\User u');
        $usercount = $query->getSingleScalarResult();
        $totalpages = ceil($usercount / 30);
        
        if ($page > $totalpages){ $page = $totalpages; }
        if ($page < 1){ $page = 1; }
        $skip = ($page - 1) * 30;
        
        $uquery = $em->createQuery("SELECT u FROM OGIS\IndexBundle\Entity\User u LEFT JOIN OGIS\IndexBundle\Entity\Role l WHERE l.id IN ($group) ORDER BY u.$ordering $order")->setFirstResult($skip)->setMaxResults(30);
        $users = $uquery->getResult();
        
        $output = "{\"cpage\":$page,\"tpages\":$totalpages,\"users\":[";
        foreach ($users as $user){
            if ($output[strlen($output) - 1] != '['){ $output .= ','; }
            $id = $user->getId();
            $name = $user->getDisplayname();
            $role = $user->getLimits()->getId();
            $output .= "{\"id\":$id,\"name\":\"$name\",\"role\":$role}";
        }
        $output .= ']}';
        
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }
    
    public function editUserNotesAction($id){
        $em = $this->getDoctrine()->getManager();               
        $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($id);
        if(!$user){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "User not found!",
                'message' => "The requested user doesn't exist in the database."
            ));
        }
        $this_user = $this->getUser();
        if($this_user->getId() != $user->getId() && !$this->get('security.context')->isGranted('ROLE_ADMIN')){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Access denied!",
                'message' => "You do not have permissions necessary to perform this action!",
                'tip'     => ""
            ));
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            return $this->render('OGISIndexBundle:Edit:editusernotes.html.twig', array('user' => $user));
        }
        else{
            $rawdata = file_get_contents('php://input');
            $rawdata = substr($rawdata, strpos($rawdata, '_'));
            $params = array();
            parse_str($rawdata, $params);
            $user->setMessageboard($params['_projectwall']);
            $em->persist($user);
            $em->flush();
            return $this->render('OGISIndexBundle:Edit:editusernotes.html.twig', array('user' => $user));
        }
    }
    
}
