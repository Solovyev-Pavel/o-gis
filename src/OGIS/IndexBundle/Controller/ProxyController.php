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
use OGIS\IndexBundle\Entity\User;
use OGIS\IndexBundle\Entity\Layer;

class ProxyController extends Controller{

	public function wmsProxyAction(){
      $cs = $_GET['LAYERS'];
      if ($cs == null){ $cs = $_GET['QUERY_LAYERS']; }
      $ws = substr($cs, 0, strpos($cs, ":"));
      $cs = substr($cs, strpos($cs, ":") + 1);

    if($_GET['REQUEST'] == 'GetMap'){
        // get the image the user wants to get...
        $context = stream_context_create(array('http' => array('header' => "Authorization: Basic " . base64_encode("admin:geoserver"))));
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver/$ws/wms?" . $_SERVER['QUERY_STRING'];
        $im = file_get_contents($url, false, $context);
        // ...and send it to the user
        header("Content-Type: image/png");
        echo $im;
        exit;
		}
		else{
        // assuming that user does GetFeatureInfo request
        $server = $_SERVER['SERVER_ADDR'];
        $url = "http://$server:8080/geoserver/$ws/wms?" . $_SERVER['QUERY_STRING'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
        curl_exec($ch);
        curl_close($ch);
        return new response("", 200);
    }
		return new response("Mapping server provided no proper response", 404);
	}

	public function geoserverFunctionsProxyAction($something, $other){
      $server = $_SERVER['SERVER_ADDR'];
      $url = "http://$server:8080/geoserver/$something/$other?" . $_SERVER['QUERY_STRING'];
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($ch);
      $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
      curl_close($ch);
      header("Content-Type: $contentType");
      if (preg_match('/image\/(png|jpe?g)/', $contentType)){
          echo $result;
          exit;
      }
      return new response($result, $code);
  }

	public function geoserverIdentifyForwarderAction(){
      $server = $_SERVER['SERVER_ADDR'];
      $url = "http://$server:8080/geoserver/" . urldecode($_GET['url']);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($ch);
      $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
      curl_close($ch);
      header("Content-Type: $contentType");
      return new response($result, $code);
	}
	
	public function corsProxyAnyAction(){
      if ( $_SERVER['REQUEST_METHOD'] == "OPTIONS" ){			// just send back the message that app can request data
          header('Access-Control-Allow-Origin: *');
          header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
          header('Access-Control-Max-Age: 1728000');
          return new response('', 200);
      }
      $url = $_GET['url'];
      $localGS = $_SERVER['SERVER_ADDR'] . ':8080/geoserver/';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_USERPWD, "admin:geoserver");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array("7hTwlQptyN: admin"));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($ch);
      $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
      curl_close($ch);
      header("Content-Type: $contentType");
      header('Access-Control-Allow-Origin: *');
      header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
      header('Access-Control-Max-Age: 1728000');
      return new response($result, $code);
	}

}
