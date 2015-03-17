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
     * @ORM\OneToOne(targetEntity="\Sopinet\UserBundle\Entity\ProfilePictureFile", mappedBy="user")
     */
    protected $profilepicturefile;


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
        if ($this->getProfilePictureFile() != null) {
            return $this->getProfilePictureFile()->getPathRelative();
        } else {
            return $this->profilepicture;
        }
    }

    public function setProfilePictureFile(\Sopinet\UserBundle\Entity\ProfilePictureFile $profilepicturefile)
    {
	    $this->profilepicturefle = $profilepicturefile;
	    return $this;
    }

    public function getProfilePictureFile()
    {
	    return $this->profilepicturefile;
    }
}
