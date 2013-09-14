Sopinet/UserBundle
==================

Easy Integration:

hwi_oauth: https://github.com/hwi/HWIOAuthBundle

fosub: https://github.com/FriendsOfSymfony/FOSUserBundle

Optional (sonatauser & sonataadmin): https://github.com/sonata-project/SonataUserBundle


What it is?
===========

This bundle integrate fosub + hwi_oauth with default options and configuration for only work. You can use it as documentation, guide or use directly in your site.

Installation
============

From composer, add 
```yaml
{
    "require": {
        "sopinet/userbundle": "dev-master"
    }
}
```
Add bundle to AppKernel (you can need add FOSUB and SonataUserBundle too)
```php
 new Sopinet\UserBundle\SopinetUserBundle(),
```


Configuration
=============

1. Add configuration / security file by default:

```yaml
imports
  - { resource: "../../vendor/sopinet/userbundle/Sopinet/UserBundle/Resources/config/config.yml" } 
```

2. Add your id and secret parameters:

```yaml
parameters:
  sopinet_user_facebook_id: "YOURID-FACEBOOK"
  sopinet_user_facebook_secret: "YOURSECRET-FACEBOOK"
  sopinet_user_google_id: "YOURID-GOOGLE"
  sopinet_user_google_secret: "YOURSECRET-GOOGLE"
```

3. It work with SonataUserBundle, overriding user class in app, so, you must have configure integration with FOSUB+SonataUser

```yaml
fos_user:
  db_driver: orm
  firewall_name: main
  user_class: Application\Sonata\UserBundle\Entity\User
```

4. In your Application\Sonata\UserBundle\Entity\User you must have one field ProfilePicture:

```php
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
```

And it must be defined in User.orm.xml

```yaml
    <field name="profilepicture" column="profilepicture" type="string" length="500" nullable="true"></field>
```

Usage
=====

```twig
    <a href="{{ hwi_oauth_login_url('google') }}">Connect with Google</a>
    <a href="{{ hwi_oauth_login_url('facebook') }}">Connect with Facebook</a>
```
