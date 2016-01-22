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
     * @Route("/{id}", name="show_user")
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
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        // Return user profile
        return array('user' => $user);
    }

    /**
     * Delete the specified user from the database.
     * This is a complete deletion, no turning back available
     *
     * @Route("/{id}/delete", name="delete_user")
     * @Method("DELETE")
     */
    public function deleteUserAction($id)
    {
        // Searching requested user
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('GPCoreBundle:User')->find($id);

        // Checking if user exists
        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        // Removing the user
        $em->remove($user);
        $em->flush();

        // Return success message
        $this->addFlash('success', 'L\'utilisateur a été correctement supprimé');
        return $this->redirectToRoute('show_users');
    }
}
