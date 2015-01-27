<?php
namespace Sopinet\UserBundle\Admin\Model;

use Sonata\UserBundle\Admin\Model\GroupAdmin as SonataGroupAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class BaseGroupAdmin extends SonataGroupAdmin
{
    public $baseRouteName = null;
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->with('Sopinet')
                //->add('profilepicture')
                // ...
            ->end()
        ;
    }
}
?>
