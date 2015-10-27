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
 
/* ************************************************************************** *
 *       This controller initializes the roles limitations used in O-GIS      *
 * ************************************************************************** */

namespace OGIS\IndexBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use OGIS\IndexBundle\Entity\Role;

class CreateEntityController extends Controller{

    public function createRolesAction(){
  		$classType = 'Role';
	  	$em = $this->getDoctrine()->getManager();
	  	$dql = "SELECT COUNT(u.id) FROM OGIS\IndexBundle\Entity\\$classType u";
	  	$query = $em->createQuery($dql);
		  $entity_count = $query->getSingleScalarResult();
		  if ($entity_count != 0){
		      return new Response("Users are already initialized!", 200);
		  }
		  $entityArray = array();

			// System user
			$role = new Role();
			$role->setRole('ROLE_SYSTEM');
			$role->setName('System User');

			array_push($entityArray, $role);

			// Administrator
			$role = new Role();
			$role->setRole('ROLE_SUPER_ADMIN');
			$role->setName('Site Administrator');
			array_push($entityArray, $role);

			// Moderator
			$role = new Role();
			$role->setRole('ROLE_ADMIN');
			$role->setName('Site Moderator');
			array_push($entityArray, $role);

			// Advanced user
			$role = new Role();
			$role->setRole('ROLE_PRIV_USER');
			$role->setName('Priviledged User');
			$role->setLayers(50);
			$role->setPalettes(50);
			$role->setStyles(50);
			array_push($entityArray, $role);

			// Generic user
			$role = new Role();
			$role->setRole('ROLE_USER');
			$role->setName('User');
			$role->setLayers(25);
			$role->setPalettes(25);
			$role->setStyles(25);
			array_push($entityArray, $role);

  		for ($i = 0; $i < 5; $i++){
	  		$em->persist($entityArray[$i]);
		  }
		  $em->flush();

		  $responsetext = "User roles were successfully created!";
		  return new Response("$responsetext", 200);
	}

}
