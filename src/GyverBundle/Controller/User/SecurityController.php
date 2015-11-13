<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 10/11/15
 * Time: 00:47
 */

namespace GyverBundle\Controller\User;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class SecurityController
 *
 * Application security controller, manage the user authentication.
 *
 * @package GyverBundle\Controller\User
 */
class SecurityController extends Controller
{
    /**
     * Render the user login view
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/login", name="login")
     * @Method("GET")
     */
    public function loginAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBER')) {
            return $this->redirectToRoute('/backend');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('User/form_login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ));
    }
}
