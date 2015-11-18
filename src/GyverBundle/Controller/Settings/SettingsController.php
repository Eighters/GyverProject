<?php

namespace GyverBundle\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class SettingsController
 *
 * User settings controller
 *
 * @package GyverBundle\Controller\Settings
 */
class SettingsController extends Controller
{

    /**
     * Render the backend home view
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/secure", name="backend_home")
     * @Method("GET")
     */
    public function homeAction(Request $request)
    {
        return $this->render('Settings/home.html.twig');
    }

    /**
     * @Route("/account", name="user_info")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction()
    {
        //To get the user who is logged
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render(':User:form_informations.html.twig', array('user' => $user ));
    }

}
