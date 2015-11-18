<?php

namespace GyverBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserManagementController
 * @package GyverBundle\Controller\Admin
 *
 * @Route("/secure")
 */
class UserManagementController extends Controller
{
    /**
     * Show all user information by user_id ONLY for admin
     *
     * @Route("/user", name="user_list")
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
     * Show given user information ONLY for admin
     *
     * @Route("/user/{id}", name="user_show")
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
