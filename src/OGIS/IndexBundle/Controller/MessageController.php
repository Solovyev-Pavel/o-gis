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
use OGIS\IndexBundle\Entity\Message;

class MessageController extends Controller {
    
    // Returns a list of messages
    public function GetMessagesAction() {
        $em = $this->getDoctrine()->getManager();
        // authentification is required
        if(!$this->getUser()){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">authorizing</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Unauthorized users can't view messages!",
                'message' => "Unauthorized users can't view messages!",
                'tip'     => "To gain access to messagebox try $login_link in O-GIS."
            ));
        }
        $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($this->getUser()->getId());
        return $this->render('OGISIndexBundle:Default:messagebox.html.twig', array( 'user' => $user ));
    }
    
    // Returns message data
    public function ViewMessageAction($id) {
        $em = $this->getDoctrine()->getManager();
        $authorizationChecker = $this->get('security.context');
        $is_admin = $authorizationChecker->isGranted('ROLE_ADMIN');
        $message = $em->getRepository('OGIS\IndexBundle\Entity\Message')->find($id);
        if (!$message){
            return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                'caption' => "Error!",
                'message' => "Message not found!"
            ));
        }
        $sender = $message->getSender();
        $addressee = $message->getAddressee();
        if (!$message->getRead() && $this->getUser() == $addressee){
            $message->setRead(true);
            $em->persist($message);
            $em->flush();
        }
        if ($this->getUser() != $sender && $this->getUser() != $addressee && !$is_admin){
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Error!",
                'message' => "You can't view this message!"
            ));
        }
        // return message data
        return $this->render('OGISIndexBundle:Objects:message.html.twig', array('message' => $message));
    }
    
    // Sends a message
    public function SendMessageAction() {
        // authentification is required
        if(!$this->getUser()){
            $login_link = "<a href=\"". $this->generateUrl('fos_user_security_login') . "\">authorizing</a>";
            return $this->render('OGISIndexBundle:Error:accessdenied.html.twig', array(
                'caption' => "Unauthorized users can't send messages!",
                'message' => "Unauthorized users can't send messages!",
                'tip'     => "To be able to send messages, try $login_link in O-GIS."
            ));
        }
        // pull message data from the request
        // using $this->getUser() instead of $sender = $_REQUEST['sender']
        $addressee = $_REQUEST['addressee'];
        $subject = $_REQUEST['subject'];
        $body = $_REQUEST['body'];
        // check if everything is alright
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($addressee);
        if (!$user){
            $i = '{"success": false, "message":"Impossible to send message: O-GIS user not found!"}';
            $response = new Response($i);
            $response->headers->set('Content-Type', 'application/json');
            $response->setCharset('UTF-8');
            return $response;
        }
        // create message
        $message = new Message();
        $message->setSender($this->getUser());
        $message->setAddressee($user);
        $message->setSubject($subject);
        $message->setBody($body);
        $message->setRead(false);
        $message->setSent(new \DateTime("now"));
        $em->persist($message);
        $em->flush();
        // send response that message is sent
        $i = '{"success": true, "message":"Your message was successfully sent!"}';
        $response = new Response($i);
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        return $response;
    }
    
    // Marks a certain message as read
    public function MarkAsReadAction($id) {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('OGIS\IndexBundle\Entity\Message')->find($id);
        if (!$message){ return new Response("false", 404); }
        $message->setRead(true);
        $em->persist($message);
        $em->flush();
        return new Response("true", 200);
    }
    
}
