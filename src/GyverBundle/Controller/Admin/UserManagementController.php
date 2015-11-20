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
     * Show all users ONLY for admin
     *
     * @Route("/user/page/{page}", name="user_list")
     * @Method("GET")
     */
    public function indexAction($page=1)
    {
        $maxperpage = 6;
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('GyverBundle:User');

        $users = $userRepository->findAll();

        $nbUsers = count($users);

        $pagination = array(
            'page' => $page,
            'route' => 'user_list',
            'pages_count' => ceil($nbUsers / $maxperpage),
            'route_params' => array()
        );

        $users = $this->getDoctrine()->getRepository('GyverBundle:User')
            ->getList($page, $maxperpage);

        return $this->render('Admin/overview.html.twig', array(
            'users' => $users,
            'pagination' => $pagination
        ));


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

    /**
     * @Route("/colleage/{id}", name="colleage_show")
     * @Method("GET")
     */
    public function showColleageAction($id)
    {
        $loggedUser = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $colleage = $em->getRepository('GyverBundle:User')->find($id);

        if (!$colleage || !$loggedUser) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $isSameCompany = false;

        foreach($loggedUser->getCompany() as $company)
            if($colleage->getCompany()->contains($company)) {
                $isSameCompany = true;
                break;
            }


        if($isSameCompany)
            return $this->render('Admin/showUser.html.twig', array(
                'user' => $colleage));
        else
            throw $this->createAccessDeniedException('You cannot access this page!');
    }
}
