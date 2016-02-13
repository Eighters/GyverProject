<?php

namespace GP\UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Admin User Controller
 * @package GP\UserBundle\Controller
 *
 * @Route("/secure/admin")
 */
class AdminUserController extends Controller
{

    /**
     * Render Admin Dashboard
     *
     * @Route("/", name="admin_dashboard")
     * @Method("GET")
     * @Template("GPUserBundle:Admin:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        return array();
    }

    /**
     * Returns the list of application users
     *
     * @Route("/user", name="admin_show_all_user")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/User:showUsers.html.twig")
     */
    public function showUsersAction(Request $request)
    {
        // Getting all users
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('GPCoreBundle:User')->findAll();

        // Create a pagination
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            $this->container->getParameter( 'knp_paginator.page_range' )
        );

        // Return all users with KnpPaginator
        return array('pagination' => $pagination);
    }

    /**
     * Return the profile of a specific user
     *
     * @Route("/user/{id}", name="admin_show_user")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/User:showUser.html.twig")
     */
    public function showUserAction($id)
    {
        // Searching requested user
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('GPCoreBundle:User')->find($id);

        // Checking if user exists
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable');
            return $this->redirectToRoute('admin_show_all_user');
        }

        // Return user profile
        return array('user' => $user);
    }

    /**
     * Delete the specified user from the database.
     * This is a complete deletion, no turning back available
     *
     * @Route("/user/{id}/delete", name="admin_delete_user")
     * @Method("DELETE")
     */
    public function deleteUserAction($id)
    {
        // Searching requested user
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('GPCoreBundle:User')->find($id);

        // Checking if user exists
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable');
            return $this->redirectToRoute('admin_show_all_user');
        }

        // Admin can't be deleted !
        if ($user->hasRole('ROLE_ADMIN')) {
            $this->addFlash('error', 'Utilisateur '. $user->getFirstName() .' ne peut pas être supprimé');
            return $this->redirectToRoute('admin_show_all_user');
        }

        // Removing the user
        $em->remove($user);
        $em->flush();

        // Notice him by email
        $mailerService = $this->get('gp.core_bundle.mailing_service');
        $mailerService->sendUserAccountDeletedNotification($user);

        // Return success message
        $this->addFlash('success', 'Utilisateur '. $user->getFirstName() .' correctement supprimé');
        return $this->redirectToRoute('admin_show_all_user');
    }

    /**
     * Archive a given user. He can be reactivated later.
     *
     * @Route("/user/{id}/disable", name="admin_disable_user")
     * @Method("GET")
     */
    public function archiveUserAction($id)
    {
        // Searching requested user
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('GPCoreBundle:User')->find($id);

        // Checking if user exists
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable');
            return $this->redirectToRoute('admin_show_all_user');
        }

        // Admin can't be archived !
        if ($user->hasRole('ROLE_ADMIN')) {
            $this->addFlash('error', 'Utilisateur '. $user->getFirstName() .' ne peut pas être désactivé');
            return $this->redirectToRoute('admin_show_all_user');
        }

        // Archive the user
        $user->setEnabled(0);
        $em->persist($user);
        $em->flush();

        // Notice him by email
        $mailerService = $this->get('gp.core_bundle.mailing_service');
        $mailerService->sendUserAccountArchivedNotification($user);

        // Return success message
        $this->addFlash('success', 'Utilisateur '. $user->getFirstName() .' correctement désactivé');
        return $this->redirectToRoute('admin_show_all_user');
    }

    /**
     * Reactive a given user.
     *
     * @Route("/user/{id}/activate", name="admin_activate_user")
     * @Method("GET")
     */
    public function activateUserAction($id)
    {
        // Searching requested user
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('GPCoreBundle:User')->find($id);

        // Checking if user exists
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable');
            return $this->redirectToRoute('admin_show_all_user');
        }

        // Activate the user
        $user->setEnabled(1);
        $em->persist($user);
        $em->flush();

        // Notice him by email
        $mailerService = $this->get('gp.core_bundle.mailing_service');
        $mailerService->sendUserAccountActivatedNotification($user);

        // Return success message
        $this->addFlash('success', 'Utilisateur '. $user->getFirstName() .' correctement activé');
        return $this->redirectToRoute('admin_show_all_user');
    }

}
