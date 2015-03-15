<?php

namespace Sopinet\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @Route("/sopinet_userbundle_modal")
 * @author sopinet
 *
 */
class ModalController extends Controller
{
    /**
     * @Route("/userProfilePicture", name="sopinet_userbundle_modal_profilepicture")
     */
    public function userProfilePictureAction() {
        return $this->render('SopinetUserBundle:Modal:changeProfilePicture.html.twig');
    }
}