<?php
namespace Sopinet\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use JMS\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
* @ORM\Table(name="profilepicturefile")
* @ORM\Entity
* @DoctrineAssert\UniqueEntity("id")
*/
class ProfilePictureFile
{
    use ORMBehaviors\Timestampable\Timestampable;
    use \Sopinet\Bundle\UploadMagicBundle\Model\UploadMagic;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"public"})
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\Application\Sopinet\UserBundle\Entity\User", inversedBy="profilepicturefile")
     */
    protected $user;

    public function setUser(\Application\Sopinet\UserBundle\Entity\User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


}
