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
     * @Route("/backend", name="backend_home")
     * @Method("GET")
     */
    public function homeAction(Request $request)
    {
        return $this->render('Settings/home.html.twig');
    }

}
