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
 * @Route("/secure/admin")
 */
class AdminController extends Controller
{

    /**
     * Render Admin Dashboard
     *
     * @Route("/", name="admin_dashboard")
     * @Method("GET")
     * @Template()
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
     * @Template()
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
     * @Template()
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
        $user = $this->getUser();

        if (!$user->hasRole('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You need to be admin');
        }

        // Searching requested user
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('GPCoreBundle:User')->find($id);

        // Checking if user exists
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable');
        }

        // Removing the user
        $em->remove($user);
        $em->flush();

        // Return success message
        $this->addFlash('success', 'L\'utilisateur a été correctement supprimé');

        return $this->redirectToRoute('admin_show_all_user');
    }
}
