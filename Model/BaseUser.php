<?php

namespace Sopinet\UserBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser as AbstractUser;
#use FOS\UserBundle\Entity\User as BaseUser;

class BaseUser extends AbstractUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /** @ORM\Column(name="profilepicture", type="string", length=500, nullable=true) */
    protected $profilepicture;
   
    
    /**
     * Set profilepicture
     *
     * @param string $profilepicture
     * @return User
     */
    public function setProfilePicture($profilepicture)
    {
    	$this->profilepicture = $profilepicture;
    	return $this;
    }
    /**
     * Get profilepicture
     *
     * @return string
     */
    public function getProfilePicture()
    {
    	return $this->profilepicture;
    } 
}
