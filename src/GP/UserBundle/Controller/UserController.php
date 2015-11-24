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

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM GPCoreBundle:User a ORDER BY a.firstName ASC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
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
