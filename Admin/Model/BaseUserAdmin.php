<?php
namespace Sopinet\UserBundle\Admin\Model;

use Sonata\UserBundle\Admin\Model\UserAdmin as SonataUserAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class BaseUserAdmin extends SonataUserAdmin
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
                ->add('profilepicture')
                // ...
            ->end()
        ;
    }
}
?>