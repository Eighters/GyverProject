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
 * @Route("/secure/admin/user")
 */
class UserController extends Controller
{

    /**
     * Returns the list of application users
     * - If [ROLE_ADMIN_COMPANY] : return only company users
     * - If [ROLE_ADMIN] : return all application users
     *
     * @Route("/", name="show_users")
     * @Method("GET")
     * @Template()
     */
    public function showUsersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('GPCoreBundle:User')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return array('pagination' => $pagination);
    }

    /**
     * @Route("/toto", name="user_show")
     */
    public function totoAction()
    {

    }
}
