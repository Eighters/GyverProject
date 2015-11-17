<?php

namespace GyverBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserManagementController extends Controller
{
    /**
     * @route
     */

    /**
     * Return the view to manage user
     *
     * @Route("/admin/overview", name="admin_overview")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('GyverBundle:User');

        $users = $userRepository->findAll();

        return $this->render('Admin/overview.html.twig', array('users' => $users));
    }
}
