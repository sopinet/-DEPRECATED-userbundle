<?php

namespace Sopinet\UserBundle\Model;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("userbundle_userextend")
 * @ORM\Entity
 */
trait UserExtend
{
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