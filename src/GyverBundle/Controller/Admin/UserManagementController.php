<?php

namespace GyverBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * Delete given user information ONLY for admin
     *
     * @Route("/user/{id}/delete", name="user_delete")
     * @Method("DELETE")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUserAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('GyverBundle:User')->find($id);
        $name = $user->getFirstName() . ' ' .$user->getLastName();

        if ($user->hasRole('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer l\'utilisateur :'. $name .' car il est Administrateur !');
            return $this->redirect($this->generateUrl('user_list'));
        }

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'L\'utilisateur '. $name .' a été correctement supprimé');
        return $this->redirect($this->generateUrl('user_list'));
    }

    /**
     * Check the Admin password to confirm sensitive actions
     *
     * @Route("/user/admin/password/check", name="admin_password_check")
     * @Method("POST")
     *
     * @return Response
     */
    public function checkUserPasswordAction()
    {
        $inputPassword = $this->get('request')->get('password');

        $em = $this->getDoctrine()->getManager();
        $admin = $em->getRepository('GyverBundle:User')->find(1);

        $salt = $admin->getSalt();
        $passwordEncrypt = $admin->getPassword();

        $salted = $inputPassword.'{'.$salt.'}';
        $digest = hash('sha512', $salted, true);

        for ($i=1; $i<5000; $i++) {
            $digest = hash('sha512', $digest.$salted, true);
        }

        $encodedPassword = base64_encode($digest);

        if ($passwordEncrypt == $encodedPassword) {
            return new Response(json_encode(true));
        } else {
            return  new Response(json_encode(false));
        }
    }
}
