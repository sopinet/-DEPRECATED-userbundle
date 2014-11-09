<?php

namespace Sopinet\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser as BaseUser

/**
 * @ORM\Table("fos_user")
 * @ORM\Entity
 */
class SopinetUserExtend as BaseUser
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
