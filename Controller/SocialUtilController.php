<?php

namespace Sopinet\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Buzz\Browser;
use Buzz\Client\Curl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @Route("/socialutil")
 * @author sopinet
 *
 */
class SocialUtilController extends FOSRestController
{	
	/**
	 * Funcion para representar un acceso denegado a la API
	 */
	private function msgDenied() {
		$array['state'] = -1;
		$array['msg'] = "Access Denied";
		$view = View::create()
		->setStatusCode(200)
		->setFormat('json')
		->setData($array);
		return $this->handleView($view);
	}
	
	private function msgOk() {
		$view = view::create()
		->setStatusCode(200)
		->setFormat('json')
		->setData($this->doOk(null));
	
		return $this->handleView($view);
	}
	
	/**
	 * Funcion para representar un acceso valido a la API
	 * @param array $data Serie de datos
	 * @return array Serie de datos
	 */
	private function doOK($data) {
		$ret['state'] = 1;
		$ret['msg'] = "Ok";
		$ret['data'] = $data;
		return $ret;
	}
	
	/**
	 * Funcion que controla el usuario que envia datos a la API
	 */
	private function checkUser($email, $pass){
		$user = $this->getDoctrine()->getRepository('\Application\Sonata\UserBundle\Entity\User')->findOneByEmail($email);
	
		if ($user == null) return false;
		if ($pass == $user->getPassword()) return $user;
		else return false;
	}
	
	private function checkPrivateAccess() {
		$user = $this->get('security.context')->getToken()->getUser();
		if ($user != null) {
			return $user;
		}
	
		$request = $this->getRequest();
		// TODO: ACTIVAR, QUITAR FALSE
		if ('POST' != $request->getMethod() && false) {
			return false;
		}
		$user = $this->checkUser($request->get('email'), $request->get('pass'));
		if($user == false) {
			return false;
		}
	
		return $user;
	}
	
	private function getFriendsGplus($user) {
		$url = 'https://www.google.com/m8/feeds/contacts/';
		$url .= $user->getEmail();
		$url .= '/full?access_token=';
		$url .= $user->getGplusname();
		$url .= '&max-results=10';
		 
		$browser = new Browser();
		$browser->setClient(new Curl());
		$response = $browser->get($url);
		$data = $response->getContent();

		$return = array();		
		
		if (substr($data,0,6) == '<html>') {
			return null;
		} else {
			$dataXML = new \SimpleXMLElement($data);
		}
		

		foreach($dataXML->entry as $entry) {
			// get image
			foreach($entry->link as $link) {
				if ($link['type'] == "image/*") {
					$object['picture'] = $link['href']->__toString();
				}
			}
		
			// get name
			$object['name'] = $entry->title->__toString();
		
			// get email
			$dataemail = $entry->children('gd', true);
			$attr = $dataemail->attributes();
			if ($attr['address'] != null) {
				$object['username'] = $attr['address']->__toString();
				$return[] = $object;
			}
			$object = null;
		}		

		return $return;		
	}
	
	private function getFriendsFacebook($user) {
		ini_set("display_errors",1);
		$url = 'https://graph.facebook.com/';
		$url .= $user->getFacebookuid();
		$url .= '/friends?fields=name,picture,username&access_token=';
		$url .= $user->getFacebookname();
			
		$browser = new Browser();
		$browser->setClient(new Curl());
		$response = $browser->get($url);
		$data = $response->getContent();
		
		$return = array();
		
		$dataJSON = json_decode($data);
		foreach($dataJSON->data as $item) {
			$object['id'] = $item->id;
			$object['name'] = $item->name;
			if (isset($item->username)) {
				$object['username'] = $item->username;
			}
			$object['picture'] = $item->picture->data->url;
			
			$return[] = $object;
		}

		return $return;
	}
    
    /**
     * @Route("/getfriends/{socialname}")
     * @param String $socialname (facebook/gplus)
     */
    public function getFriendsAction($socialname) {    	
    	$user = $this->checkPrivateAccess();
    	if (!$user) return $this->msgDenied();
    	
    	$userManager = $this->container->get('fos_user.user_manager');
    	//$serializer = JMS\Serializer\SerializerBuilder::create()->build();
    	
    	if ($socialname == "gplus") {
    		$data = $this->getFriendsGplus($user);
    		if ($data != null) {
    			$user->setGplusdata($data);
    		}
    	} else if ($socialname == "facebook") {
    		$data = $this->getFriendsFacebook($user);
    		if ($data != null) {
    			$user->setFacebookdata($data);
    		} 		
    	}
    	
    	$userManager->updateUser($user);    	

    	$view = View::create()
    	->setStatusCode(200)
    	->setFormat('json')
    	->setData($this->doOK($data));
    	
    	return $this->handleView($view);    	
    }
    
    /**
     * @Route("/getcachefriends/{socialname}")
     * @param String $socialname (facebook/gplus)
     */
    public function getCacheFriendsAction($socialname) {    	
    	$user = $this->checkPrivateAccess();
    	if (!$user) return $this->msgDenied();
    	    	
    	if ($socialname == 'gplus') {
    		$data = $user->getGplusdata();
    	} else {
    		$data = $user->getFacebookdata();
    	}
    	
    	if ($data == null) {
    		$view = $this->getFriendsAction($socialname);
    		return $view;
    	}
    	else {
	    	$view = View::create()
	    	->setStatusCode(200)
	    	->setFormat('json')
	    	->setData($this->doOK($data));
	    	 
	    	return $this->handleView($view);
    	}    	
    }
}