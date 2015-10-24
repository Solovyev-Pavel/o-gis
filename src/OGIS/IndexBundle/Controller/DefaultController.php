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
use OGIS\IndexBundle\Entity\News;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DefaultController extends Controller{

  	public function indexAction($name){
    		return $this->render('OGISIndexBundle:Default:index.html.twig', array('name' => $name));
	  }

	  public function homePageAction() {
    		$em = $this->getDoctrine()->getManager();
		    $query = $em->createQuery("SELECT c FROM OGISIndexBundle:News c ORDER BY c.id DESC");
		    $news = $query->setMaxResults(5)->getResult();
		    return $this->render('OGISIndexBundle:Default:homepage.html.twig', array('news' => $news));
	  }
}
