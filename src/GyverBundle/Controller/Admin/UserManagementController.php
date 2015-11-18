<?php

namespace GyverBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserController
 * @package GyverBundle\Controller\User
 *
 * @Route("/admin")
 */
class UserManagementController extends Controller
{
    /**
     * Return the list of all user
     *
     * @Route("/user", name="admin_overview")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('GyverBundle:User');

        $users = $userRepository->findAll();

        return $this->render('Admin/overview.html.twig', array('users' => $users));
    }

    /**
     * Show user information by user_id
     *
     * @Route("/user/{id}")
     * @Method("GET")
     */
    public function showUserAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('GyverBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $this->render('Admin/showUser.html.twig', array('user' => $user));
    }
}
