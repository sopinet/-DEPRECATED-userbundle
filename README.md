userbundle
==========

Integration of hwi_oauth + fosub (sonatauser & sonataadmin, optional)

What it is?
===========

This bundle integrate fosub + hwi_oauth with default options and configuration for only work. You can use it as documentation, guide or use directly in your site.

Installation
============

From composer, add "sopinet/userbundle": "dev-master"

Configuration
=============

1. Add configuration / security file by default:

  imports
    - { resource: "../../vendor/sopinet/userbundle/Sopinet/UserBundle/Resources/config/config.yml" } 
    
2. Add your id and secret parameters:

  parameters:
      sopinet_user_facebook_id: "YOURID-FACEBOOK"
      sopinet_user_facebook_secret: "YOURSECRET-FACEBOOK"
      sopinet_user_google_id: "YOURID-GOOGLE"
      sopinet_user_google_secret: "YOURSECRET-GOOGLE"
      
3. It work with SonataUserBundle, overriding user class in app, so, you must have configure integration with FOSUB+SonataUser

  fos_user:
    db_driver: orm
    firewall_name: main
    user_class: Application\Sonata\UserBundle\Entity\User
    
4. In your Application\Sonata\UserBundle\Entity\User you must have one field ProfilePicture:

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
    
And it must be defined in User.orm.xml

    <field name="profilepicture" column="profilepicture" type="string" length="500" nullable="true"></field>
