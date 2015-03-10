<?php
namespace Sopinet\UserBundle\Security\Core\User;
 
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
 
class FOSUBUserProvider extends BaseClass
{
	/**
	* {@inheritDoc}
	*/
	public function connect(UserInterface $user, UserResponseInterface $response)
	{
        // TODO: ESTO PARECE QUE NO SE LANZA NUNCA
        /**
		$property = $this->getProperty($response);
		$username = $response->getUsername();
	 
		//on connect - get the access token and the user ID
		$service = $response->getResourceOwner()->getName();
		if ($service == "google") $service = "gplus";
		$setter = 'set'.ucfirst($service);
		$setter_id = $setter.'Uid';
		$setter_token = $setter.'Name';
		 
		//we "disconnect" previously connected users
		if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
			$previousUser->$setter_id(null);
			$previousUser->$setter_token(null);
			$this->userManager->updateUser($previousUser);
		}
		//we connect current user
		$user->$setter_id($username);
		$user->$setter_token($response->getAccessToken());
		//save customfield		
        //update custom fields
        //TODO: Check google response, facebook?
        if ($service == "facebook") {
            $url = "http://graph.facebook.com/".$data['id']."/picture?type=normal";
            $user->setProfilePicture($url);
        }
		//TODO: Save locale, $user->setLocale($response->getLocale());

		$this->userManager->updateUser($user);
         **/
	}
	 
	/**
	* {@inheritdoc}
	*/
	public function loadUserByOAuthUserResponse(UserResponseInterface $response)
	{	
		$data = $response->getResponse();
		$username = $response->getUsername();		
		$user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        $service = $response->getResourceOwner()->getName();
		//when the user is registrating
		if (null === $user) {
			if ($service == "google") $service = "gplus";
			$setter = 'set'.ucfirst($service);
			$setter_id = $setter.'Uid';
			$setter_token = $setter.'Name';
			// create new user here
			// TODO: Check email, if exist add service
			$userE = $this->userManager->findUserBy(array("email" => $response->getEmail()));
			if (null === $userE) {
				$user = $this->userManager->createUser();
				$user->setUsername($response->getEmail());
				if($service == "gplus"){
					$user->setFirstname($data['given_name']);
				}
				if($service == "facebook"){
					$name = explode(" ",$data['name']);
					$user->setFirstname($name[0]);
                    $user->setLastname($name[1]);
				}
				$user->setEmail($response->getEmail());
				$user->setPassword("");
			} else {
				$user = $userE;
			}
			$user->$setter_id($username);
			$user->$setter_token($response->getAccessToken());
			$user->setEnabled(true);
			//Customfields
			$user->setProfilePicture($response->getProfilePicture());
			//TODO: Save Locale, $user->setLocale($response->getLocale());
			$this->userManager->updateUser($user);
			return $user;
		}
	 
		//if user exists - go with the HWIOAuth way
		$user = parent::loadUserByOAuthUserResponse($response);
		 
		$serviceName = $response->getResourceOwner()->getName();
		if ($serviceName == "google") $serviceName = "gplus";
		$setter = 'set' . ucfirst($serviceName) . 'Name';
		 
		//update access token
		$user->$setter($response->getAccessToken());
		
		//update custom fields
		//TODO: Check google response, facebook?
        if ($service == "facebook") {
            $url = "http://graph.facebook.com/".$data['id']."/picture?type=normal";
            $user->setProfilePicture($url);
        }

		return $user;
	}
}
