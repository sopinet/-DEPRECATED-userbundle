<?php

namespace Sopinet\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("sopinetuserextend")
 * @ORM\Entity
 */
class SopinetUserExtend
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;   
    
    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="sopinetuserextend")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;
    
    /** @ORM\Column(name="profilepicture", type="string", length=500, nullable=true) */
    protected $profilepicture;
    
    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     *
     * @return UserExtend
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
    	$this->user = $user;
    
    	return $this;
    }
    
    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUser()
    {
    	return $this->user;
    }    
    
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
