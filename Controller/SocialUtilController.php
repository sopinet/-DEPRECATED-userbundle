<?php

namespace Sopinet\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Buzz\Browser;
use Buzz\Client\Curl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
		$url .= '&max-results=5000';
		 
		$browser = new Browser();
		$browser->setClient(new Curl());
		$response = $browser->get($url);
		$data = $response->getContent();
		ld($data);
		 
		$dataXML = new \SimpleXMLElement($data);
		
		$return = array();
		foreach($dataXML->entry as $entry) {
			// get image
			foreach($entry->link as $link) {
				if ($link['type'] == "image/*") {
					$object['image'] = $link['href'];
				}
			}
		
			// get name
			$object['name'] = $entry['title'];
		
			// get email
			$dataemail = $entry->children('gd', true);
			$attr = $dataemail->attributes();
			$object['email'] = $attr['address'];
		
			$return[] = $object;
		}
		 
		return $return;		
	}
    
    /**
     * @Route("/getfriends/{socialname}")
     */
    public function getFriendsAction($socialname) {    	
    	$user = $this->checkPrivateAccess();
    	if (!$user) return $this->msgDenied();
    	
    	if ($socialname == "gplus") {
			return $this->getFriendsGplus($user);
    	}
    }    
}