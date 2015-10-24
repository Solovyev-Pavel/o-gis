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
		    return $this->render('OGISIndexBundle:Editor:compositioneditor.html.twig', array('composition' => $composition, 'layer' => $layer));
	  }
}
