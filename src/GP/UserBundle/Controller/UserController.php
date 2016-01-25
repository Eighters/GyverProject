<?php

namespace GP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class DashboardController
 * @package GP\UserBundle\Controller
 *
 * @Route("/secure/user")
 */
class UserController extends Controller
{
    /**
     * Render user view
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return array();
    }
}
