Sopinet/UserBundle
==================

NOT USE THIS VERSION, IS IN DEVELOPMENT


Easy Integration:

hwi_oauth: https://github.com/hwi/HWIOAuthBundle

fosub: https://github.com/FriendsOfSymfony/FOSUserBundle

Optional (sonatauser & sonataadmin): https://github.com/sonata-project/SonataUserBundle

(EXPERIMENTAL VERSION)


What it is?
===========

This bundle integrate fosub + hwi_oauth with default options and configuration for only work. You can use it as documentation, guide or use directly in your site.

Too integrate another bundles from Sopinet (Experimental / Alpha)

Installation
============

From composer, add 
```yaml
{
    "require": {
        "sopinet/userbundle": "1.2.*dev"
    }
}
```
Add bundle to AppKernel (you can need add FOSUB and SonataUserBundle too)
```php
 new Sopinet\UserBundle\SopinetUserBundle(),
```


Configuration
=============

1. Create Application\Sopinet\UserBundle folder
2. Create Entity and Admin folder
3. Create User.php in Entity folder:
```php
<?php
 namespace Application\Sopinet\UserBundle\Entity;

 use Doctrine\ORM\Mapping as ORM;
 use Knp\DoctrineBehaviors\Model as ORMBehaviors;
 use Sopinet\UserBundle\Model\BaseUser as BaseUser;
 
 /**
 * Entity User
 *
 * @ORM\Table("fos_user_user")
 * @ORM\Entity
 */
 class User extends BaseUser
 {
   // EXTEND HERE
 }
?> 
```
4. Create Group.php in Entity folder:
```
<?php
namespace Application\Sopinet\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Sopinet\UserBundle\Model\BaseGroup as BaseGroup;
#use FOS\UserBundle\Entity\User as BaseUser;

/**
 * Entity User
 *
 * @ORM\Table("fos_user_group")
 * @ORM\Entity
 */
class Group extends BaseGroup
{
  // EXTEND HERE
}
?>
```
5. Create UserAdmin in Admin folder:
```php
<?php
 namespace Application\Sopinet\UserBundle\Admin;
 use Sopinet\UserBundle\Admin\Model\BaseUserAdmin;
 use Sonata\AdminBundle\Form\FormMapper;

 class UserAdmin extends BaseUserAdmin
 {
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->with('EXTEND...')
            //->add('field...')
            // ...
            ->end()
        ;
    }
 }
?>
```
6. Create GroupAdmin in Admin folder:
```php
<?php
 namespace Application\Sopinet\UserBundle\Admin;
 use Sopinet\UserBundle\Admin\Model\BaseGroupAdmin;

 class GroupAdmin extends BaseGroupAdmin
 {
   // TODO EXTEND
 }
?>
```

More documentation is coming
