<?php

namespace Sopinet\UserBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseGroup as AbstractGroup;
#use FOS\UserBundle\Entity\Group as BaseGroup;

class BaseGroup extends AbstractGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
}
