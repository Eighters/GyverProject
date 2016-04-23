<?php

namespace GP\UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class Admin Home Controller
 * @package GP\UserBundle\Controller
 *
 * @Route("/secure/admin")
 */
class AdminHomeController extends Controller
{
    /**
     * Render Admin Dashboard
     *
     * @Route("/", name="admin_dashboard")
     * @Method("GET")
     * @Template("GPUserBundle:Admin:index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}
