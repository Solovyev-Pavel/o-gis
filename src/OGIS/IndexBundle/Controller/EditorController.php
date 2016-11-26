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

class EditorController extends Controller{

	public function showEditorAction($datasource, $id){
		$em = $this->getDoctrine()->getManager();
		$composition = null;
		$layer = null;
		if ($datasource == "composition"){
			$composition = $em->getRepository('OGIS\IndexBundle\Entity\Composition')->find($id);
			if(!$composition){
				return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
					'caption' => "Error while reading data!",
					'message' => "The composition you're looking for doesn't exist in the database."
			));
		}
		if ($this->getUser() != null){
            $found = false;
            $authorizationChecker = $this->get('security.context');
            if ($authorizationChecker->isGranted('EDIT', $composition)){ $can_overwrite = 1; $found = true; }
            $cmp_projects = $composition->getCompositionsProjects();
            $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($this->getUser()->getId());
            $usr_projects = $user->getUsersProjects();
            if (!$found){
            	foreach($cmp_projects as $prj){
            		foreach($usr_projects as $p){
            			if ($p->getId() == $prj->getId()){
            				$found = true;
            				$can_overwrite = 1;
            				break;
            			}
            		}
            		if ($found){ break; }
            	}
            }
		}
		if ($datasource == "layer"){
			$layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->find($id);
			if(!$layer){
				return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
					'caption' => "Error while reading data!",
					'message' => "The layer you're looking for doesn't exist in the database."
				));
			}
		}
		if ($this->getUser() != null){
            $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($this->getUser()->getId());
            $limit = $user->getLimits()->getLayers();
            if ($limit == null){ $limit = -1; }
        }
        else { $limit = 0; }
		return $this->render('OGISIndexBundle:Editor:compositioneditor.html.twig', array(
			'composition' => $composition,
			'layer' => $layer,
            'permission' => $can_overwrite,
            'ulimit' => $limit
		));
	}

	public function showCompositionEditorAction($datasource, $id){
        $em = $this->getDoctrine()->getManager();
        $composition = null;
        $layer = null;
        $can_overwrite = 0;
        if ($datasource == "composition"){
            $composition = $em->getRepository('OGIS\IndexBundle\Entity\Composition')->find($id);
            if(!$composition){
                return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                        'caption' => "Error while retrieving composition data!",
                        'message' => "Requested composition wasn't found in the O-GIS database."
                ));
            }
            if ($this->getUser() != null){
                $found = false;
                $authorizationChecker = $this->get('security.context');
                if ($authorizationChecker->isGranted('EDIT', $composition)){ $can_overwrite = 1; $found = true; }
                $cmp_projects = $composition->getCompositionsProjects();
                $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($this->getUser()->getId());
                $usr_projects = $user->getUsersProjects();
                if (!$found){
                    foreach($cmp_projects as $prj){
                        foreach($usr_projects as $p){
                            if ($p->getId() == $prj->getId()){
                                $found = true;
                                $can_overwrite = 1;
                                break;
                            }
                        }
                        if ($found){ break; }
                    }
                }
            }
        }
        if ($datasource == "layer"){
            $layer = $em->getRepository('OGIS\IndexBundle\Entity\Layer')->find($id);
            if(!$layer){
                return $this->render('OGISIndexBundle:Error:entitynotfound.html.twig', array(
                        'caption' => "Error while retrieving layer data!",
                        'message' => "Requested layer wasn't found in the O-GIS database."
                ));
            }
        }
        if ($this->getUser() != null){
            $user = $em->getRepository('OGIS\IndexBundle\Entity\User')->find($this->getUser()->getId());
            $limit = $user->getLimits()->getLayers();
            if ($limit == null){ $limit = -1; }
        }
        else {
            $limit = 0;
        }
        return $this->render('OGISIndexBundle:Editor:compositioneditor.html.twig', array(
            'composition' => $composition,
            'layer' => $layer,
            'permission' => $can_overwrite,
            'ulimit' => $limit
        ));
    }

}
